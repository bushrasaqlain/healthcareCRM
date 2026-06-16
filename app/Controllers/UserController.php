<?php

namespace App\Controllers;

use App\Models\UserModel;

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
}

