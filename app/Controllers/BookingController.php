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
                 'payment_method'   => $row['payment_method'],  
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
    ->select('ptb.*, lt.test_code, lt.test_name, lt.rate, lt.reporting_time, ph.name as phleb_name')
    ->join('lab_tests lt', 'lt.id = ptb.fk_test_id', 'left')
    ->join('phlebotomists ph', 'ph.id = ptb.phleb_id', 'left')
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

    // Fetch phlebotomists for dropdown
$phlebotomists = $db->table('phlebotomists')->orderBy('name', 'ASC')->get()->getResultArray();

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
    'bookingId',
    'phlebotomists'   // ← add this
);

        return view('labDashboard/booking_details', $data);
    }
    // Add this method to your BookingController class
public function assignPhlebotomist($bookingId = null)
{
    if (!session()->get('logged_in')) {
        return redirect()->to('/login');
    }

    if (!$bookingId) {
        return redirect()->back()->with('error', 'Invalid booking ID');
    }

    $phlebId = (int) $this->request->getPost('phleb_id');
    $eta     = $this->request->getPost('eta') ?: null;

    if (!$phlebId) {
        return redirect()->back()->with('error', 'Please select a phlebotomist.');
    }

    $db = \Config\Database::connect();

    $booking = $db->table('patient_test_bookings')
        ->where('id', $bookingId)
        ->get()->getRowArray();

    if (!$booking) {
        return redirect()->back()->with('error', 'Booking not found.');
    }

    // Update ALL rows for this patient (in case multiple tests)
    $db->table('patient_test_bookings')
        ->where('fk_patient_id', $booking['fk_patient_id'])
        ->update([
            'phleb_id'     => $phlebId,
            'eta'          => $eta,
            'status'       => 'Phlebotomist Assigned',
            'date_updated' => date('Y-m-d H:i:s'),
        ]);

    return redirect()->to('/booking/view/' . $booking['fk_patient_id'])
        ->with('success', 'Phlebotomist assigned successfully!');
}
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
    // Silently skip if booking_status_history table doesn't exist yet
    $db = \Config\Database::connect();
    if (!$db->tableExists('booking_status_history')) {
        return;
    }

    $db->table('booking_status_history')->insert([
        'booking_id' => $bookingId,
        'patient_id' => $patientId,
        'status'     => $status,
        'changed_by' => $changedBy ?: (session()->get('username') ?? 'System'),
        'notes'      => $notes,
        'changed_at' => date('Y-m-d H:i:s'),
    ]);
}
public function saveNotes($patientId = null)
{
    if (!session()->get('logged_in')) {
        return redirect()->to('/login');
    }

    if (!$patientId) {
        return redirect()->back()->with('error', 'Invalid patient ID');
    }

    $db = \Config\Database::connect();
    $db->table('patients')
        ->where('id', $patientId)
        ->update([
            'instructions' => $this->request->getPost('instructions'),
            'updated_at'   => date('Y-m-d H:i:s'),
        ]);

    return redirect()->to('/booking/view/' . $patientId)
        ->with('success', 'Notes saved successfully.');
}
    // Add to BookingController

public function editTests($patientId = null)
{
    if (!session()->get('logged_in')) {
        return redirect()->to('/login');
    }

    $db = \Config\Database::connect();

    $patient = $db->table('patients')->where('id', $patientId)->get()->getRowArray();
    if (!$patient) {
        return redirect()->back()->with('error', 'Patient not found.');
    }

    // Current bookings for this patient
    $currentBookings = $db->table('patient_test_bookings ptb')
        ->select('ptb.id, ptb.fk_test_id, ptb.discount_percent, ptb.payment_method, lt.test_name, lt.test_code, lt.rate')
        ->join('lab_tests lt', 'lt.id = ptb.fk_test_id', 'left')
        ->where('ptb.fk_patient_id', $patientId)
        ->orderBy('ptb.date_created', 'ASC')
        ->get()->getResultArray();

    // All available tests
    $allTests = $db->table('lab_tests')
        ->orderBy('test_name', 'ASC')
        ->get()->getResultArray();

    return view('labDashboard/edit_tests', [
        'patient'         => $patient,
        'currentBookings' => $currentBookings,
        'allTests'        => $allTests,
    ]);
}

public function updateTests($patientId = null)
{
    if (!session()->get('logged_in')) {
        return redirect()->to('/login');
    }

    $db           = \Config\Database::connect();
    $bookingModel = new PatientTestBookingModel();
    $now          = date('Y-m-d H:i:s');

    // IDs to delete (removed tests)
    $deleteIds = $this->request->getPost('delete_ids') ?? [];
    if (!empty($deleteIds)) {
        $bookingModel->whereIn('id', $deleteIds)
                     ->where('fk_patient_id', $patientId)  // safety check
                     ->delete();
    }

    // New tests to add
    $newTests = $this->request->getPost('new_tests') ?? [];
    $insertRows = [];

    foreach ($newTests as $t) {
        $testId   = (int)($t['test_id'] ?? 0);
        $discount = (int)($t['discount'] ?? 0);
        $payment  = $t['payment'] ?? 'prepaid';

        if ($testId <= 0) continue;
        if ($discount < 0 || $discount > 100) $discount = 0;
        if (!in_array($payment, ['cash', 'prepaid'], true)) $payment = 'prepaid';

        $insertRows[] = [
            'fk_patient_id'    => $patientId,
            'fk_test_id'       => $testId,
            'status'           => 'In Process',
            'discount_percent' => $discount,
            'payment_method'      => $payment,
            'date_created'     => $now,
            'date_updated'     => $now,
        ];
    }

    if (!empty($insertRows)) {
        $bookingModel->insertBatch($insertRows);
    }

    // Update existing rows (discount / payment changes)
    $existingUpdates = $this->request->getPost('existing') ?? [];
    foreach ($existingUpdates as $rowId => $vals) {
        $discount = (int)($vals['discount'] ?? 0);
        $payment  = $vals['payment'] ?? 'prepaid';

        if ($discount < 0 || $discount > 100) $discount = 0;
        if (!in_array($payment, ['cash', 'prepaid'], true)) $payment = 'prepaid';

        $bookingModel->where('id', (int)$rowId)
                     ->where('fk_patient_id', $patientId)
                     ->set(['discount_percent' => $discount, 'payment_method' => $payment, 'date_updated' => $now])
                     ->update();
    }

    return redirect()->to(site_url('booking/view/' . $patientId))
                     ->with('success', 'Tests updated successfully.');
}
}