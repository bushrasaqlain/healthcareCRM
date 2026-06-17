<?php

namespace App\Models;

use CodeIgniter\Model;

class PatientTestBookingModel extends Model
{
    protected $table         = 'patient_test_bookings';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'fk_patient_id',
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
        'fk_lab_id'    => 'required|integer',
        'status'        => 'required',
        'paid_status'   => 'required|in_list[cash,prepaid]',
    ];
}