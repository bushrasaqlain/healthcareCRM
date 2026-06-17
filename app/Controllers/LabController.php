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