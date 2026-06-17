<?php

namespace App\Controllers;

use App\Models\LabModel;

class LabController extends BaseController
{
    public function dashboard()
{
    if (!session()->get('logged_in')) {
        return redirect()->to('/login');
    }

    return view('labDashboard/dashboard');
}


 public function sampleCollected($id = null)
    {
        // Sample data - in real application, fetch from database using $id
        $data = [
            'booking_id' => 'cmqfan2e2000zt5083orfxtd1j',
            'patient_name' => 'Nadia Tariq',
            'phone' => '+923228117733',
            'address' => 'House 90 Dream Villas Society',
            'gender' => 'Female',
            'notes' => '16 june 3 pm',
            'phlebotomist' => 'Khawar',
            'eta' => '16 Jun 2026, 3:00 PM',
            'tests' => [
                [
                    'code' => '6668',
                    'name' => 'LFTs (T-Bili, ALT, AST, ALP, ALB, GGT, T-Prot, Globulins, A/G)',
                    'reporting_time' => '—',
                    'price' => 'PKR 1,365',
                    'payment' => 'Cash'
                ],
                [
                    'code' => '4303',
                    'name' => 'Beta HCG',
                    'reporting_time' => 'Same Day After 3 Hour',
                    'price' => 'PKR 1,575',
                    'payment' => 'Pending'
                ]
            ],
            'original_total' => '4,200',
            'discount' => '1,260',
            'patient_pays' => 'PKR 2,940',
            'status_history' => ['In Process', 'Phlebotomist Assigned', 'Phlebotomist Arrived', 'Sample Collected'],
            'created_at' => 'Jun 15, 2026 7:13 PM',
            'created_by' => 'Marham Agent',
            'assigned_to' => 'INFINITY Lab'
        ];

        return view('labDashboard/sample_collected', $data);        
    }

    private function getSampleBookingData($id)
    {
        return (object) [
            'id' => $id,
            'patient_name' => 'Nadia Tariq',
            'patient_phone' => '+923228117733',
            'patient_address' => 'House 90 Dream Villas Society',
            'patient_gender' => 'Female',
            'phlebotomist' => 'Khawar',
            'eta' => '16 Jun 2026, 3:00 PM',
            'status' => 'Sample Collected',
            'created_at' => 'Jun 15, 2026 7:13 PM',
            'created_by' => 'Marham Agent',
            'assigned_to' => 'INFINITY Lab',
            'booking_id' => 'cmqfan2e2000zt5083orfxtd1j',
            'notes' => '16 june 3 pm',
            'total_original' => 4200,
            'discount' => 1260,
            'patient_pays' => 2940
        ];
    }

    private function getSampleTestsData()
    {
        return [
            (object) [
                'code' => '6668',
                'name' => 'LFTs (T-Bili, ALT, AST, ALP, ALB, GGT, T-Prot, Globulins, A/G)',
                'reporting_time' => '—',
                'price' => 1365,
                'payment_status' => 'Cash'
            ],
            (object) [
                'code' => '4303',
                'name' => 'Beta HCG',
                'reporting_time' => 'Same Day After 3 Hour',
                'price' => 1575,
                'payment_status' => 'Pending'
            ]
        ];
    }
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $labModel = new LabModel();

        $labs = $labModel->select('labs.*, users.name, users.email, users.status')
                         ->join('users', 'users.id = labs.user_id')
                         ->findAll();

        return view('dbadmin/lablist', ['labs' => $labs]);
    }

    public function priceList($labId)
{
    if (!session()->get('logged_in')) {
        return redirect()->to('/login');
    }

    $labModel = new LabModel();
    $lab = $labModel->select('labs.*, users.name, users.email')
                    ->join('users', 'users.id = labs.user_id')
                    ->find($labId);

    if (!$lab) {
        return redirect()->to('/lablist')->with('error', 'Lab not found.');
    }

    $db    = \Config\Database::connect();
    $tests = $db->table('lab_tests')->where('lab_id', $labId)->get()->getResultArray();

    return view('dbadmin/pricelist', ['lab' => $lab, 'tests' => $tests]);
}

public function importPriceList($labId)
{
    if (!session()->get('logged_in')) {
        return redirect()->to('/login');
    }

    $file = $this->request->getFile('excel_file');

    if (!$file || !$file->isValid()) {
        return redirect()->back()->with('error', 'Please upload a valid Excel file.');
    }

    $allowed = ['xlsx', 'xls', 'csv'];
    if (!in_array(strtolower($file->getExtension()), $allowed)) {
        return redirect()->back()->with('error', 'Only .xlsx, .xls, .csv files allowed.');
    }

    try {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getTempName());
        $sheet       = $spreadsheet->getActiveSheet();
        $rows        = $sheet->toArray();

        // Skip header row
        array_shift($rows);

        $db = \Config\Database::connect();
        $db->table('lab_tests')->where('lab_id', $labId)->delete();

        $data = [];
        foreach ($rows as $row) {
            if (empty($row[1])) continue; // skip if no test name
            $data[] = [
                'lab_id'         => $labId,
                'test_code'      => $row[0] ?? '',
                'test_name'      => $row[1] ?? '',
                'rate'           => $row[2] ?? 0,
                'sample'         => $row[3] ?? '',
                'reporting_time' => $row[4] ?? '',
                'created_at'     => date('Y-m-d H:i:s'),
            ];
        }

        if (!empty($data)) {
            $db->table('lab_tests')->insertBatch($data);
        }

        return redirect()->to(base_url('labs/' . $labId . '/pricelist'))
                         ->with('success', count($data) . ' tests imported successfully.');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to read file: ' . $e->getMessage());
    }
}
}
