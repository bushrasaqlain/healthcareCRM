<?php

namespace App\Models;

use CodeIgniter\Model;

class LabReportModel extends Model
{
    protected $table = 'lab_reports';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'fk_booking_id',
        'fk_test_id',
        'fk_patient_id',
        'report_file',
        'report_status',
        'uploaded_at',
        'verified_at'
    ];
    
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    protected $validationRules = [
        'fk_booking_id' => 'required|integer',
        'fk_test_id' => 'required|integer',
        'fk_patient_id' => 'required|integer',
        'report_file' => 'required|max_length[255]',
        'report_status' => 'required|in_list[pending,uploaded,verified]',
    ];
    
    /**
     * Get reports by booking ID
     */
    public function getReportsByBooking($bookingId)
    {
        return $this->db->table('lab_reports lr')
            ->select('lr.*, lt.test_name, lt.test_code')
            ->join('lab_tests lt', 'lt.id = lr.fk_test_id', 'left')
            ->where('lr.fk_booking_id', $bookingId)
            ->get()
            ->getResultArray();
    }
    
    /**
     * Get uploaded reports count for a booking
     */
    public function getUploadedReportsCount($bookingId)
    {
        return $this->where('fk_booking_id', $bookingId)
                    ->where('report_status', 'uploaded')
                    ->countAllResults();
    }
    
    /**
     * Check if all tests have reports uploaded
     */
    public function areAllTestsReported($bookingId, $totalTests)
    {
        $uploadedCount = $this->getUploadedReportsCount($bookingId);
        return $uploadedCount >= $totalTests;
    }
}