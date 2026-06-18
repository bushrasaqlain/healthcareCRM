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
        'fk_lab_id',
        'status',
        'eta',
        'discount_percent',
        'paid_status',
    ];

    protected $returnType    = 'array';

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'date_created';
    protected $updatedField  = 'date_updated';

    protected $validationRules = [
        'fk_patient_id' => 'required|integer',
        'fk_test_id'    => 'required|integer',
        'status'        => 'required',
        'paid_status'   => 'required|in_list[cash,prepaid]',
    ];

    // ─── Dashboard ────────────────────────────────────────────────

    /**
     * Get all bookings joined with patient info, newest first.
     */
    public function getBookingsWithPatient(): array
    {
        return $this->select('
                patient_test_bookings.id,
                patient_test_bookings.fk_patient_id,
                patient_test_bookings.fk_lab_id,
                patient_test_bookings.status,
                patient_test_bookings.eta,
                patient_test_bookings.discount_percent,
                patient_test_bookings.paid_status,
                patient_test_bookings.date_created,
                p.patient_name,
                p.phone_number,
                p.age,
                p.gender,
                p.home_address
            ')
            ->join('patients p', 'p.id = patient_test_bookings.fk_patient_id', 'left')
            ->orderBy('patient_test_bookings.date_created', 'DESC')
            ->findAll();
    }

    /**
     * Count bookings grouped by status for dashboard cards.
     * Returns associative array: ['total', 'in_process', 'assigned', 'arrived', 'collected', 'report_ready']
     */
    public function getStatusCounts(): array
    {
        $rows = $this->select('status, COUNT(*) as cnt')
                     ->groupBy('status')
                     ->findAll();

        $map = [
            'In Process'             => 'in_process',
            'Phlebotomist Assigned'  => 'assigned',
            'Arrived'                => 'arrived',
            'Sample Collected'       => 'collected',
            'Report Ready'           => 'report_ready',
        ];

        $counts = [
            'total'        => 0,
            'in_process'   => 0,
            'assigned'     => 0,
            'arrived'      => 0,
            'collected'    => 0,
            'report_ready' => 0,
        ];

        foreach ($rows as $row) {
            $counts['total'] += (int) $row['cnt'];
            $key = $map[$row['status']] ?? null;
            if ($key) {
                $counts[$key] = (int) $row['cnt'];
            }
        }

        return $counts;
    }

    // ─── Test Details (booking_test_details table) ────────────────

    /**
     * Get tests for a single booking with test name, rate, etc.
     * Requires booking_test_details + lab_tests tables.
     */
    public function getTestsByBookingId(int $bookingId): array
    {
        $db = \Config\Database::connect();

        if (!$db->tableExists('booking_test_details')) {
            return [];
        }

        return $db->table('booking_test_details btd')
            ->select('lt.test_name, lt.rate, lt.reporting_time, lt.test_code')
            ->join('lab_tests lt', 'lt.id = btd.fk_test_id', 'left')
            ->where('btd.fk_booking_id', $bookingId)
            ->get()
            ->getResultArray();
    }

    /**
     * Attach tests + calculated totals to each booking row.
     * Mutates the passed array in place.
     */
    public function attachTestDetails(array &$bookings): void
    {
        foreach ($bookings as &$booking) {
            $tests    = $this->getTestsByBookingId((int) $booking['id']);
            $total    = array_sum(array_column($tests, 'rate'));
            $discount = ($booking['discount_percent'] / 100) * $total;

            $booking['tests']      = $tests;
            $booking['test_count'] = count($tests);
            $booking['total']      = $total;
            $booking['discount']   = $discount;
            $booking['payable']    = $total - $discount;
        }
    }

    /**
 * Get bookings with patient info, applying optional filters.
 */
public function getFilteredBookings(array $filters = []): array
{
    $builder = $this->select('
            patient_test_bookings.id,
            patient_test_bookings.fk_patient_id,
            patient_test_bookings.fk_lab_id,
            patient_test_bookings.status,
            patient_test_bookings.eta,
            patient_test_bookings.discount_percent,
            patient_test_bookings.paid_status,
            patient_test_bookings.date_created,
            p.patient_name,
            p.phone_number,
            p.age,
            p.gender,
            p.home_address
        ')
        ->join('patients p', 'p.id = patient_test_bookings.fk_patient_id', 'left');

    // Status filter
    if (!empty($filters['status']) && $filters['status'] !== 'All') {
        $builder->where('patient_test_bookings.status', $filters['status']);
    }

    // Search filter (patient name or phone)
    if (!empty($filters['search'])) {
        $search = $filters['search'];
        $builder->groupStart()
                    ->like('p.patient_name', $search)
                    ->orLike('p.phone_number', $search)
                ->groupEnd();
    }

    // Date range filter (on date_created)
    if (!empty($filters['date_from'])) {
        $builder->where('DATE(patient_test_bookings.date_created) >=', $filters['date_from']);
    }
    if (!empty($filters['date_to'])) {
        $builder->where('DATE(patient_test_bookings.date_created) <=', $filters['date_to']);
    }

    return $builder->orderBy('patient_test_bookings.date_created', 'DESC')->findAll();
}
}