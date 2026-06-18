<?php

namespace App\Models;

use CodeIgniter\Model;

class PatientTestBookingModel extends Model
{
    protected $table         = 'patient_test_bookings';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'fk_patient_id',
        'fk_test_id',
        'status',
        'eta',
        'discount_percent',
        'payment_method',
        'payment_status',
        'payment_date'
    ];

    protected $returnType    = 'array';

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'date_created';
    protected $updatedField  = 'date_updated';
    protected $payment_date='payment_date';
    protected $validationRules = [
        'fk_patient_id' => 'required|integer',
        'fk_test_id'    => 'required|integer',
        'fk_test_id'    => 'required|integer',
        'status'        => 'required',
        'payment_method' => 'required|in_list[cash,prepaid]',
        'payment_status' => 'required|in_list[paid,unpaid]',
        
    ];

    // Get filtered bookings for dashboard
    public function getFilteredBookings(array $filters = []): array
    {
        $db = \Config\Database::connect();

        $builder = $db->table('patient_test_bookings ptb')
            ->select('
                MIN(ptb.id) as id,
                ptb.fk_patient_id,
                ptb.status,
                ptb.eta,
                ptb.payment_method,
                ptb.payment_status,
                ptb.date_created,
                p.patient_name,
                p.phone_number,
                p.age,
                p.gender,
                p.home_address,
                COUNT(ptb.id) as test_count,
                SUM(lt.rate) as total,
                lt.reporting_time,
                SUM(lt.rate * (1 - ptb.discount_percent / 100)) as payable
            ')
            ->join('patients p', 'p.id = ptb.fk_patient_id', 'left')
            ->join('lab_tests lt', 'lt.id = ptb.fk_test_id', 'left')
            ->groupBy('ptb.fk_patient_id, ptb.status, DATE(ptb.date_created)');

        if (!empty($filters['status']) && $filters['status'] !== 'All') {
            $builder->where('ptb.status', $filters['status']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $builder->groupStart()
                        ->like('p.patient_name', $search)
                        ->orLike('p.phone_number', $search)
                    ->groupEnd();
        }

        if (!empty($filters['date_from'])) {
            $builder->where('DATE(ptb.date_created) >=', $filters['date_from']);
        }
        if (!empty($filters['date_to'])) {
            $builder->where('DATE(ptb.date_created) <=', $filters['date_to']);
        }

        return $builder->orderBy('ptb.date_created', 'DESC')->get()->getResultArray();
    }

    // Attach test details to bookings
    public function attachTestDetails(array &$bookings): void
    {
        if (empty($bookings)) return;

        $db = \Config\Database::connect();

        $patientIds = array_unique(array_column($bookings, 'fk_patient_id'));

        $rows = $db->table('patient_test_bookings ptb')
            ->select('ptb.fk_patient_id, lt.test_name, lt.rate, lt.reporting_time, ptb.discount_percent')
            ->join('lab_tests lt', 'lt.id = ptb.fk_test_id', 'left')
            ->whereIn('ptb.fk_patient_id', $patientIds)
            ->get()->getResultArray();

        $testMap = [];
        foreach ($rows as $row) {
            $testMap[$row['fk_patient_id']][] = $row;
        }

        foreach ($bookings as &$b) {
            $b['tests'] = $testMap[$b['fk_patient_id']] ?? [];
        }
    }

    // Get status counts for dashboard
    public function getStatusCounts(): array
    {
        $db = \Config\Database::connect();
        $result = $db->table('patient_test_bookings')
            ->select('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()->getResultArray();

        $counts = [
            'total' => 0,
            'in_process' => 0,
            'assigned' => 0,
            'arrived' => 0,
            'collected' => 0,
            'report_ready' => 0
        ];

        foreach ($result as $row) {
            $status = strtolower($row['status']);
            $counts['total'] += (int)$row['count'];
            
            if ($status === 'in process') {
                $counts['in_process'] = (int)$row['count'];
            } elseif ($status === 'phlebotomist assigned') {
                $counts['assigned'] = (int)$row['count'];
            } elseif ($status === 'phlebotomist arrived') {
                $counts['arrived'] = (int)$row['count'];
            } elseif ($status === 'sample collected') {
                $counts['collected'] = (int)$row['count'];
            } elseif ($status === 'report ready') {
                $counts['report_ready'] = (int)$row['count'];
            }
        }

        return $counts;
    }

    // Get booking with details for invoice
    public function getBookingWithDetails($bookingId)
    {
        $db = \Config\Database::connect();
        
        // First get the booking
        $booking = $db->table('patient_test_bookings')
            ->where('id', $bookingId)
            ->get()
            ->getRowArray();
            
        if (!$booking) {
            return null;
        }
        
        // Get patient details
        $patient = $db->table('patients')
            ->where('id', $booking['fk_patient_id'])
            ->get()
            ->getRowArray();
            
        $booking['patient'] = $patient;
        
        // Get all tests for this booking
        $tests = $db->table('patient_test_bookings ptb')
            ->select('ptb.*, lt.test_name, lt.test_code, lt.rate as rack_rate, lt.reporting_time')
            ->join('lab_tests lt', 'lt.id = ptb.fk_test_id', 'left')
            ->where('ptb.id', $bookingId)
            ->get()
            ->getResultArray();
            
        $booking['tests'] = $tests;
        
        return $booking;
    }

    // Get tests by booking ID
    public function getTestsByBookingId($bookingId)
    {
        $db = \Config\Database::connect();
        
        return $db->table('patient_test_bookings ptb')
            ->select('
                ptb.*,
                lt.test_name,
                lt.test_code,
                lt.rate as rack_rate,
                lt.reporting_time,
                (lt.rate * ptb.discount_percent / 100) as discount_amt,
                (lt.rate - (lt.rate * ptb.discount_percent / 100)) as patient_price
            ')
            ->join('lab_tests lt', 'lt.id = ptb.fk_test_id', 'left')
            ->where('ptb.id', $bookingId)
            ->get()
            ->getResultArray();
    }

    // Get all bookings for a patient
    public function getBookingsByPatientId($patientId)
    {
        $db = \Config\Database::connect();
        
        return $db->table('patient_test_bookings ptb')
            ->select('ptb.*, lt.test_name, lt.test_code, lt.rate')
            ->join('lab_tests lt', 'lt.id = ptb.fk_test_id', 'left')
            ->where('ptb.fk_patient_id', $patientId)
            ->orderBy('ptb.date_created', 'DESC')
            ->get()
            ->getResultArray();
    }

    // Update payment status
    public function updatePaymentStatus($bookingId, $status)
    {
        return $this->update($bookingId, [
            'payment_status' => $status,
            'date_updated' => date('Y-m-d H:i:s')
        ]);
    }
}