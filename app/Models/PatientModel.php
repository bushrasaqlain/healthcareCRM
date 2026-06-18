<?php

namespace App\Models;

use CodeIgniter\Model;

class PatientModel extends Model
{
    protected $table         = 'patients';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['patient_name', 'phone_number', 'age', 'gender', 'home_address', 'pin_location', 'instructions'];

    protected $returnType    = 'array';
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'patient_name'    => 'required|max_length[255]',
        'phone_number'   => 'required|max_length[20]',
        'home_address' => 'required',
    ];
}