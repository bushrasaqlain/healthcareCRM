<?php

namespace App\Controllers;
use Config\Database;
use App\Models\UserModel;
use App\Models\LabTestModel;
use App\Models\PatientModel;
use App\Models\PatientTestBookingModel;


class BookingController extends BaseController
{
    
    public function index()
    {
         $testModel = new LabTestModel();
 
        $data = [
            'tests'   => $testModel->orderBy('test_name', 'ASC')->findAll(),
            'genders' => ['Male', 'Female', 'Other'],
        ];
        return view('Booking/bookingform',$data);
    }

        public function add_booking()
    {

    $rules = [
            'patient_name' => 'required|regex_match[/^[A-Za-z\s]+$/]',
            'phone_number' => 'required|max_length[20]',
            'home_address' => 'required',
            'age'          => 'permit_empty|numeric',
            'gender'       => 'permit_empty|in_list[Male,Female,Other]',
            'pin_location' => 'permit_empty|valid_url_strict',
            'tests'        => 'required', // must have at least one row
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
 
        $tests = $this->request->getPost('tests') ?? [];

        log_message('debug', 'Raw tests payload: ' . json_encode($tests));
 

        $cleanRows = [];
        
        foreach ($tests as $t) {
            $testId   = (int) ($t['test_id'] ?? 0);
            $discount = (int) ($t['discount'] ?? 0);
            $payment  = $t['payment'] ?? 'prepaid';
 
            if ($testId <= 0) {
                continue; 
            }
            if ($discount < 0 || $discount > 100) {
                $discount = 0; 
            }
            if (! in_array($payment, ['cash', 'prepaid'], true)) {
                $payment = 'prepaid';
            }
 
            $cleanRows[] = [
                'fk_test_id'       => $testId,
                'discount_percent' => $discount,
                'paid_status'      => $payment,
            ];
        }
 
        if (empty($cleanRows)) {
            log_message('debug', 'cleanRows ended up empty — every test row was missing a valid test_id.');
            return redirect()->back()->withInput()->with('error', 'Please add at least one valid test.');
        }
 
       
        $patientModel = new PatientModel();
 
        $patientId = $patientModel->insert([
            'patient_name'         => $this->request->getPost('patient_name'),
            'phone_number'        => $this->request->getPost('phone_number'),
            'age'          => $this->request->getPost('age') ?: null,
            'gender'       => $this->request->getPost('gender'),
            'home_address'      => $this->request->getPost('home_address'),
            'pin_location' => $this->request->getPost('pin_location'),
            'instructions' => $this->request->getPost('instructions'),
        ], true); 
 
        if (! $patientId) {
            
        
            $modelErrors = $patientModel->errors();
            return redirect()->back()->withInput()->with(
                'errors',
                $modelErrors ?: ['patient' => 'Could not save patient details.']
            );
        }
 

        $now  = date('Y-m-d H:i:s');
        $rows = array_map(static function (array $row) use ($patientId, $now) {
            return [
                'fk_patient_id'    => $patientId,
                'fk_lab_id'       => $row['fk_test_id'],
                'status'           => 'In Process',
                'discount_percent' => $row['discount_percent'],
                'paid_status'      => $row['paid_status'],
                'date_created'     => $now,
                'date_updated'     => $now,
            ];
        }, $cleanRows);

        $bookingModel = new PatientTestBookingModel();
        $inserted = $bookingModel->insertBatch($rows);
 
        if ($inserted === false) {
            log_message('error', 'lab_bookings insertBatch failed: ' . json_encode($bookingModel->errors()));
            log_message('error', 'Last DB error: ' . json_encode(\Config\Database::connect()->error()));
            return redirect()->back()->withInput()->with('error', 'Could not save the test bookings.');
        }
 
        return redirect()->to(site_url('/labDashboard/dashboard'))
            ->with('success', count($rows) . ' test(s) booked successfully.');
    }

   public function dashboard()
{
    if (!session()->get('logged_in')) {
        return redirect()->to('/login');
    }

    $model    = new \App\Models\PatientTestBookingModel();
    $bookings = [];
    $counts   = ['total'=>0,'in_process'=>0,'assigned'=>0,'arrived'=>0,'collected'=>0,'report_ready'=>0];

    // Read filters from GET
    $filters = [
        'status'    => $this->request->getGet('status'),
        'search'    => $this->request->getGet('search'),
        'date_from' => $this->request->getGet('date_from'),
        'date_to'   => $this->request->getGet('date_to'),
    ];

    try {
        $db = \Config\Database::connect();

        if ($db->tableExists('patient_test_bookings')) {
            $bookings = $model->getFilteredBookings($filters);
            $counts   = $model->getStatusCounts();
            $model->attachTestDetails($bookings);
        }

    } catch (\Exception $e) {
        log_message('error', 'Dashboard error: ' . $e->getMessage());
    }

    return view('labDashboard/dashboard', compact('bookings', 'counts', 'filters'));
}

    public function sampleCollected($id = null)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        try {
            $db = \Config\Database::connect();
            
            // Get booking details with patient info
            $booking = $db->table('patient_test_bookings ptb')
                ->select('
                    ptb.*,
                    p.patient_name,
                    p.phone_number,
                    p.age,
                    p.gender,
                    p.home_address,
                    l.name as lab_name
                ')
                ->join('patients p', 'p.id = ptb.fk_patient_id', 'left')
                ->join('labs l', 'l.id = ptb.fk_lab_id', 'left')
                ->where('ptb.id', $id)
                ->get()
                ->getRowArray();

            if (!$booking) {
                return redirect()->to('/labDashboard/dashboard')->with('error', 'Booking not found.');
            }

            // Get tests for this booking if you have a test details table
            $tests = [];
            /*
            if ($db->tableExists('booking_test_details')) {
                $tests = $db->table('booking_test_details btd')
                    ->select('lt.test_code, lt.test_name, lt.rate, lt.reporting_time, btd.payment_status')
                    ->join('lab_tests lt', 'lt.id = btd.fk_test_id', 'left')
                    ->where('btd.fk_booking_id', $id)
                ->get()
                ->getResultArray();
            }
            */

            $data = [
                'booking_id' => $booking['id'] ?? 'N/A',
                'patient_name' => $booking['patient_name'] ?? 'N/A',
                'phone' => $booking['phone_number'] ?? 'N/A',
                'address' => $booking['home_address'] ?? 'N/A',
                'gender' => $booking['gender'] ?? 'N/A',
                'notes' => 'Sample collected notes',
                'phlebotomist' => 'Assigned Phlebotomist',
                'eta' => $booking['eta'] ? date('M j, Y g:i A', strtotime($booking['eta'])) : 'Not set',
                'tests' => $tests,
                'original_total' => '0',
                'discount' => $booking['discount_percent'] ?? 0,
                'patient_pays' => '0',
                'status_history' => ['In Process', 'Phlebotomist Assigned', 'Sample Collected'],
                'created_at' => $booking['date_created'] ? date('M j, Y g:i A', strtotime($booking['date_created'])) : 'N/A',
                'created_by' => 'System',
                'assigned_to' => $booking['lab_name'] ?? 'Not Assigned'
            ];

            return view('labDashboard/sample_collected', $data);

        } catch (\Exception $e) {
            log_message('error', 'Sample collected error: ' . $e->getMessage());
            return redirect()->to('/labDashboard/dashboard')->with('error', 'Error loading sample details.');
        }
    }

}
   
