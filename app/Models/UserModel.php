<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table         = 'users';
    protected $primaryKey    = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'name', 'email', 'password', 'password_hint', 'role', 'status', 'created_at'
    ];

    protected $validationRules = [
        'name'     => 'required|min_length[2]',
        'email'    => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[6]',
        'role'     => 'required|in_list[admin,doctor,nurse,receptionist,lab]',
    ];

    protected $validationMessages = [
        'email' => ['is_unique' => 'This email is already registered.'],
    ];

    public function getUserByEmail($email)
    {
        return $this->where('email', $email)
                    ->where('status', 'active')
                    ->first();
    }

    public function createUser($data)
    {
        $data['password_hint'] = $data['password'];
        $data['password']      = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['created_at']    = date('Y-m-d H:i:s');
        return $this->insert($data);
    }
}