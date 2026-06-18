<?php

namespace App\Models;

use CodeIgniter\Model;

class LABTestModel extends Model
{
    protected $table            = 'lab_tests';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['code', 'test_name', 'rate', 'sample', 'reporting_time'];

    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $validationRules  = [
        'code'      => 'required|max_length[20]|is_unique[tests.code,id,{id}]',
        'test_name' => 'required|max_length[255]',
        'rate'      => 'required|decimal',
    ];
}