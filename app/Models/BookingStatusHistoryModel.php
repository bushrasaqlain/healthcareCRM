<?php
namespace App\Models;
use CodeIgniter\Model;

class BookingStatusHistoryModel extends Model
{
    protected $table      = 'booking_status_history';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'booking_id', 'patient_id', 'status',
        'changed_by', 'notes', 'changed_at'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

    public function getHistoryForPatient(int $patientId): array
    {
        return $this->where('patient_id', $patientId)
                    ->orderBy('changed_at', 'ASC')
                    ->findAll();
    }
}