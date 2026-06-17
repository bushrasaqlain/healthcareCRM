<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\LabModel;
use Config\Database;

class UserController extends BaseController
{
    // ─── POSTMAN: Create admin via API ───────────────────────────
    public function createAdmin()
    {
        // Only accept JSON requests
        $json = $this->request->getJSON(true);

        if (!$json) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => 'error',
                'message' => 'Invalid JSON body',
            ]);
        }

        $model = new UserModel();

        $data = [
            'name'     => $json['name']     ?? '',
            'email'    => $json['email']    ?? '',
            'password' => $json['password'] ?? '',
            'role'     => 'admin',
            'status'   => 'active',
        ];

        if (!$model->validate($data)) {
            return $this->response->setStatusCode(422)->setJSON([
                'status'  => 'error',
                'errors'  => $model->errors(),
            ]);
        }

        $model->createUser($data);

        return $this->response->setStatusCode(201)->setJSON([
            'status'  => 'success',
            'message' => 'Admin created successfully',
        ]);
    }

    // ─── DASHBOARD: Show add user form ───────────────────────────
    public function create()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        return view('users/create');
    }

    // ─── DASHBOARD: Save new user ────────────────────────────────
    public function store()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $model = new UserModel();

        $data = [
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'role'     => $this->request->getPost('role'),
            'status'   => 'active',
        ];

        if (!$model->validate($data)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $model->errors());
        }

        $model->createUser($data);

        return redirect()->to('/users')
                         ->with('success', 'User created successfully');
    }

    // ─── DASHBOARD: List all users ───────────────────────────────
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $model = new UserModel();
        $data['users'] = $model->findAll();

        return view('users/index', $data);
    }

    public function labList()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        return view('dbadmin/lablist');
    }

    // ─── DASHBOARD: Show register form ───────────────────────────
    public function registerForm()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        return view('dbadmin/registerform');
    }

    // ─── DASHBOARD: Save new lab partner (users + labs) ──────────
    public function registerLab()
{
    if (!session()->get('logged_in')) {
        return redirect()->to('/login');
    }

    $password        = $this->request->getPost('password');
    $confirmPassword = $this->request->getPost('confirm_password');

    if ($password !== $confirmPassword) {
        return redirect()->to('/registerform')
                         ->withInput()
                         ->with('errors', ['Password and Confirm Password do not match.']);
    }

    $userModel = new UserModel();
    $labModel  = new LabModel();

    $userData = [
        'name'     => $this->request->getPost('name'),
        'email'    => $this->request->getPost('email'),
        'password' => $password,
        'role'     => 'lab',
        'status'   => 'active',
    ];

    if (!$userModel->validate($userData)) {
        return redirect()->to('/registerform')
                         ->withInput()
                         ->with('errors', $userModel->errors());
    }

    $db = \Config\Database::connect();
    $db->transStart();

    $userModel->createUser($userData);
    $userId = $db->insertID();

    $labModel->createLab([
        'user_id'        => $userId,
        'contact_person' => $this->request->getPost('contact_person'),
        'phone'          => $this->request->getPost('phone'),
        'license_number' => $this->request->getPost('license_number'),
        'address'        => $this->request->getPost('address'),
    ]);

    $db->transComplete();

    if ($db->transStatus() === false) {
        return redirect()->to('/registerform')
                         ->withInput()
                         ->with('errors', ['Something went wrong. Please try again.']);
    }

    return redirect()->to('/registerform')
                     ->with('success', 'Lab registered successfully.');
}
}