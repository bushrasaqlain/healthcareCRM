<?php

namespace App\Controllers;

use Config\Database;
use App\Models\UserModel;
use App\Models\LabTestModel;
use App\Models\PatientModel;
use App\Models\PatientTestBookingModel;
use App\Models\ShareTokenModel;
use App\Services\WhatsAppService;
use App\Services\WhatsAppMessages;


class BookingController extends BaseController
{

    public function index()
    {
        $testModel = new LabTestModel();

        $data = [
            'tests'   => $testModel->orderBy('test_name', 'ASC')->findAll(),
            'genders' => ['Male', 'Female', 'Other'],
        ];
        return view('Booking/bookingform', $data);
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
                'payment_method'      => $payment,
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
                'fk_test_id'       => $row['fk_test_id'],
                'status'           => 'In Process',
                'discount_percent' => $row['discount_percent'],
                 'payment_method'   => $row['payment_method'],  // ✅ was $row['paid_status']
        'payment_status'   => 'unpaid',
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

        try {
            $whatsapp = new WhatsAppService();
            $message  = WhatsAppMessages::forStatus(
                'booking_created',
                $this->request->getPost('patient_name')
            );
            $whatsapp->sendText($this->request->getPost('phone_number'), $message);
        } catch (\Exception $e) {
            log_message('error', '[WhatsApp] booking_created failed: ' . $e->getMessage());
        }
 
        return redirect()->to(site_url('labDashboard/dashboard'))
            ->with('success', count($rows) . ' test(s) booked successfully.');
    }

    public function dashboard()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $model = new \App\Models\PatientTestBookingModel();
        $bookings = [];
        $counts = ['total' => 0, 'in_process' => 0, 'assigned' => 0, 'arrived' => 0, 'collected' => 0, 'report_ready' => 0];

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

    public function viewBooking($patientId = null)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();

        // Get patient
        $patient = $db->table('patients')->where('id', $patientId)->get()->getRowArray();
        if (!$patient) {
            return redirect()->to('/labDashboard/dashboard')->with('error', 'Patient not found.');
        }

        // Get all bookings for this patient (each row = one test)
        $bookingRows = $db->table('patient_test_bookings ptb')
            ->select('ptb.*, lt.test_code, lt.test_name, lt.rate, lt.reporting_time')
            ->join('lab_tests lt', 'lt.id = ptb.fk_test_id', 'left')
            ->where('ptb.fk_patient_id', $patientId)
            ->orderBy('ptb.date_created', 'ASC')
            ->get()->getResultArray();

        if (empty($bookingRows)) {
            return redirect()->to('/labDashboard/dashboard')->with('error', 'No bookings found.');
        }

        // Use the latest booking row for status/eta/meta
        $latestBooking = end($bookingRows);
        $currentStatus = $latestBooking['status'];
        $bookingId = $latestBooking['id']; // ← ADD THIS LINE

        // Status steps
        $statusSteps = ['In Process', 'Phlebotomist Assigned', 'Arrived', 'Sample Collected', 'Report Ready'];
        $currentStepIdx = array_search($currentStatus, $statusSteps);
        if ($currentStepIdx === false) $currentStepIdx = 0;

        // Build tests ordered with financials
        $originalTotal = 0;
        $discountTotal = 0;
        $patientPays   = 0;
        $testsOrdered  = [];

        foreach ($bookingRows as $row) {
            $rate        = (float)($row['rate'] ?? 0);
            $discPct     = (float)($row['discount_percent'] ?? 0);
            $discAmt     = round($rate * $discPct / 100);
            $patientPrice = $rate - $discAmt;

            $originalTotal += $rate;
            $discountTotal += $discAmt;
            $patientPays   += $patientPrice;

            $testsOrdered[] = [
                'booking'       => $row,
                'test'          => [
                    'test_code'      => $row['test_code'] ?? '—',
                    'test_name'      => $row['test_name'] ?? 'Unknown Test',
                    'reporting_time' => $row['reporting_time'] ?? '—',
                ],
                'patient_price' => $patientPrice,
                'discount_amt'  => $discAmt,
            ];
        }

        // Status history
        $statusHistory = [];
        $statusHistory[] = [
            'status'     => 'In Process',
            'changed_at' => $bookingRows[0]['date_created'] ?? date('Y-m-d H:i:s'),
        ];

        // Only add current status if it's different from 'In Process'
        if ($currentStatus !== 'In Process') {
            $statusHistory[] = [
                'status'     => $currentStatus,
                'changed_at' => $latestBooking['date_updated'] ?? date('Y-m-d H:i:s'),
            ];
        }

        $data = compact(
            'patient',
            'latestBooking',
            'currentStatus',
            'statusSteps',
            'currentStepIdx',
            'testsOrdered',
            'originalTotal',
            'discountTotal',
            'patientPays',
            'statusHistory',
            'bookingId'  // ← ADD THIS
        );

        return view('labDashboard/booking_details', $data);
    }
    // Add this method to your BookingController class

    public function updateStatus($bookingId = null, $action = null)
    {
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Please login to perform this action');
        }

        // Validate booking ID
        if (!$bookingId) {
            return redirect()->back()->with('error', 'Invalid booking ID');
        }

        // Define valid actions and their corresponding statuses
        $statusMap = [
            'arrived' => [
                'status' => 'Arrived',
                'from' => 'Phlebotomist Assigned',
                'message' => 'Phlebotomist marked as arrived successfully!'
            ],
            'collected' => [
                'status' => 'Sample Collected',
                'from' => 'Arrived',
                'message' => 'Sample marked as collected successfully!'
            ],
            'report_ready' => [
                'status' => 'Report Ready',
                'from' => 'Sample Collected',
                'message' => 'Report marked as ready successfully!'
            ]
        ];

        // Validate action
        if (!$action || !isset($statusMap[$action])) {
            return redirect()->back()->with('error', 'Invalid action specified');
        }

        $db = \Config\Database::connect();

        // Get the booking
        $booking = $db->table('patient_test_bookings')
            ->where('id', $bookingId)
            ->get()
            ->getRowArray();

        if (!$booking) {
            return redirect()->back()->with('error', 'Booking not found');
        }

        // Check if booking is in the correct state for this action
        $currentStatus = $booking['status'];
        $expectedStatus = $statusMap[$action]['from'];

        if ($currentStatus !== $expectedStatus) {
            return redirect()->back()->with(
                'error',
                'Cannot perform this action. Current status: "' . $currentStatus .
                    '". Expected status: "' . $expectedStatus . '"'
            );
        }

        // Update status
        $newStatus = $statusMap[$action]['status'];
        $updated = $db->table('patient_test_bookings')
            ->where('id', $bookingId)
            ->update([
                'status' => $newStatus,
                'date_updated' => date('Y-m-d H:i:s')
            ]);

        if (!$updated) {
            return redirect()->back()->with('error', 'Failed to update booking status');
        }
        // After the update succeeds:
        $this->logStatusHistory(
            $bookingId,
            $booking['fk_patient_id'],
            $newStatus,
            $statusMap[$action]['message']
        );

        try {
            $patient = $db->table('patients')
                ->where('id', $booking['fk_patient_id'])
                ->get()->getRowArray();

            if ($patient && !empty($patient['phone_number'])) {
                $whatsapp = new WhatsAppService();
                $message  = WhatsAppMessages::forStatus(
                    $newStatus,
                    $patient['patient_name']
                );
                $whatsapp->sendText($patient['phone_number'], $message);
            }
        } catch (\Exception $e) {
            log_message('error', '[WhatsApp] status_update failed: ' . $e->getMessage());
        }

        // Redirect back to booking details page
        return redirect()->to('/booking/view/' . $booking['fk_patient_id'])
            ->with('success', $statusMap[$action]['message']);
    }
    /**
     * Upload lab reports for a booking
     */
    public function uploadReport($bookingId = null)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Please login to perform this action');
        }

        if (!$bookingId) {
            return redirect()->back()->with('error', 'Invalid booking ID');
        }

        // Validate input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'test_ids' => 'required',
            'report_file' => 'uploaded[report_file]|max_size[report_file,10240]|ext_in[report_file,pdf]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        $testIds = $this->request->getPost('test_ids');
        $file = $this->request->getFile('report_file');

        if (!$file->isValid()) {
            return redirect()->back()->with('error', 'Please upload a valid PDF file.');
        }

        $db = \Config\Database::connect();
        $booking = $db->table('patient_test_bookings')
            ->where('id', $bookingId)
            ->get()
            ->getRowArray();

        if (!$booking) {
            return redirect()->back()->with('error', 'Booking not found');
        }

        // Generate unique filename
        $newName = 'report_' . $bookingId . '_' . time() . '.' . $file->getExtension();
        $uploadPath = WRITEPATH . 'uploads/reports/';

        // Create directory if it doesn't exist
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Move file to uploads directory
        if (!$file->move($uploadPath, $newName)) {
            return redirect()->back()->with('error', 'Failed to upload file.');
        }

        $filePath = 'uploads/reports/' . $newName;
        $reportModel = new \App\Models\LabReportModel();
        $patientId = $booking['fk_patient_id'];

        // Insert reports for selected tests
        $inserted = 0;
        foreach ($testIds as $testId) {
            $data = [
                'fk_booking_id' => $bookingId,
                'fk_test_id' => $testId,
                'fk_patient_id' => $patientId,
                'report_file' => $filePath,
                'report_status' => 'uploaded',
                'uploaded_at' => date('Y-m-d H:i:s'),
            ];

            // Check if report already exists
            $existing = $reportModel->where('fk_booking_id', $bookingId)
                ->where('fk_test_id', $testId)
                ->first();

            if ($existing) {
                // Update existing report
                $reportModel->update($existing['id'], $data);
            } else {
                // Insert new report
                $reportModel->insert($data);
            }
            $inserted++;
        }

        // Check if all tests are now reported
        $totalTests = count($db->table('patient_test_bookings')
            ->where('id', $bookingId)
            ->get()
            ->getResultArray());

        $reportedCount = $reportModel->getUploadedReportsCount($bookingId);

        // If all tests are reported, update booking status to "Report Ready"
        if ($reportedCount >= $totalTests) {
            $db->table('patient_test_bookings')
                ->where('id', $bookingId)
                ->update([
                    'status' => 'Report Ready',
                    'date_updated' => date('Y-m-d H:i:s')
                ]);

            return redirect()->to('/booking/view/' . $patientId)
                ->with('success', 'All reports uploaded successfully! Booking marked as Report Ready.');
       // After the update succeeds:

                }

        return redirect()->to('/booking/view/' . $patientId)
            ->with('success', $inserted . ' report(s) uploaded successfully!');
    }
    public function markPaymentPaid($bookingId = null)
    {
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Please login to perform this action');
        }

        if (!$bookingId) {
            return redirect()->back()->with('error', 'Invalid booking ID');
        }

        $db = \Config\Database::connect();

        // Get the booking to get patient_id
        $booking = $db->table('patient_test_bookings')
            ->where('id', $bookingId)
            ->get()
            ->getRowArray();

        if (!$booking) {
            return redirect()->back()->with('error', 'Booking not found');
        }

        // Check if already paid
        if (isset($booking['payment_status']) && $booking['payment_status'] === 'paid') {
            return redirect()->back()->with('error', 'This payment is already marked as paid');
        }

        // Update payment status to 'paid'
        $updated = $db->table('patient_test_bookings')
            ->where('id', $bookingId)
            ->update([
                'payment_status' => 'paid',
                'payment_date' => date('Y-m-d H:i:s'),
                'date_updated' => date('Y-m-d H:i:s')
            ]);

        if (!$updated) {
            return redirect()->back()->with('error', 'Failed to update payment status');
        }

        // Redirect back to booking details page with success message
        return redirect()->to('/booking/view/' . $booking['fk_patient_id'])
            ->with('success', 'Payment marked as paid successfully!');
    }
    private function logStatusHistory(int $bookingId, int $patientId, string $status, string $notes = '', string $changedBy = ''): void
    {
        $statusHistory = $historyModel->getHistoryForPatient((int)$patientId);
        $historyModel->insert([
            'booking_id' => $bookingId,
            'patient_id' => $patientId,
            'status'     => $status,
            'changed_by' => $changedBy ?: (session()->get('username') ?? 'System'),
            'notes'      => $notes,
            'changed_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function viewInvoice($bookingId)
{
    // Check if user is logged in
    if (!session()->get('logged_in')) {
        return redirect()->to('/login')->with('error', 'Please login to view invoice');
    }

    $db = \Config\Database::connect();
    $patientModel = new PatientModel();
    
    // Get the specific booking record
    $booking = $db->table('patient_test_bookings')
        ->where('id', $bookingId)
        ->get()
        ->getRowArray();
    
    if (!$booking) {
        return redirect()->back()->with('error', 'Invoice not found');
    }
    
    // Get patient
    $patient = $patientModel->find($booking['fk_patient_id']);
    
    // Get ALL tests for this patient on the same date with lab details
    // Join labs table to get user_id, then join users table to get lab name
    $tests = $db->table('patient_test_bookings ptb')
        ->select('
            ptb.*,
            lt.test_name,
            lt.test_code,
            lt.rate as rack_rate,
            lt.reporting_time,
            u.name as lab_name,
            l.address as lab_address,
            l.phone as lab_phone,
            (lt.rate * ptb.discount_percent / 100) as discount_amt,
            (lt.rate - (lt.rate * ptb.discount_percent / 100)) as patient_price
        ')
        ->join('lab_tests lt', 'lt.id = ptb.fk_test_id', 'left')
        ->join('labs l', 'l.id = lt.lab_id', 'left')
        ->join('users u', 'u.id = l.user_id', 'left')  // Join users table to get lab name
        ->where('ptb.fk_patient_id', $booking['fk_patient_id'])
        ->where('DATE(ptb.date_created)', date('Y-m-d', strtotime($booking['date_created'])))
        ->get()
        ->getResultArray();
    
    // Calculate financials
    $originalTotal = 0;
    $discountTotal = 0;
    $patientPays = 0;
    $labName = '';
    $labAddress = '';
    $labPhone = '';
    
    foreach ($tests as $test) {
        $originalTotal += (float)($test['rack_rate'] ?? 0);
        $discountTotal += (float)($test['discount_amt'] ?? 0);
        $patientPays += (float)($test['patient_price'] ?? 0);
        if (empty($labName) && !empty($test['lab_name'])) {
            $labName = $test['lab_name'];
            $labAddress = $test['lab_address'] ?? '';
            $labPhone = $test['lab_phone'] ?? '';
        }
    }
    
    $data = [
        'booking' => $booking,
        'patient' => $patient,
        'tests' => $tests,
        'labName' => $labName,
        'labAddress' => $labAddress,
        'labPhone' => $labPhone,
        'originalTotal' => $originalTotal,
        'discountTotal' => $discountTotal,
        'patientPays' => $patientPays,
        'invoiceNumber' => 'INV-' . str_pad($booking['fk_patient_id'], 6, '0', STR_PAD_LEFT) . '-' . date('Ymd', strtotime($booking['date_created'])),
        'issuedDate' => date('d M Y', strtotime($booking['date_created'])),
        'isShared' => false,
        'shareToken' => null
    ];
    
    return view('labDashboard/invoice', $data);
}

 public function generateShareLink($bookingId)
    {
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login to generate share link'
            ]);
        }
        
        // Generate unique token
        $token = bin2hex(random_bytes(32));
        
        // Save token in database with expiry (24 hours)
        $shareModel = new ShareTokenModel();
        $shareModel->insert([
            'booking_id' => $bookingId,
            'token' => $token,
            'created_at' => date('Y-m-d H:i:s'),
            'expires_at' => date('Y-m-d H:i:s', strtotime('+24 hours'))
        ]);
        
        $shareUrl = base_url('booking/sharedInvoice/' . $bookingId . '/' . $token);
        
        return $this->response->setJSON([
            'success' => true,
            'share_url' => $shareUrl
        ]);
    }
}
