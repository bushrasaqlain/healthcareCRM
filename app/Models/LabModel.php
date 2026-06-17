<?php

namespace App\Models;

use CodeIgniter\Model;

class LabModel extends Model
{
    protected $table         = 'labs';
    protected $primaryKey    = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'user_id', 'contact_person', 'phone', 'license_number', 'address', 'created_at'
    ];

    public function createLab($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->insert($data);
    }
}