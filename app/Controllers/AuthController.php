<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    // Show login page
    public function index()
    {
        return view('login/loginform');
    }

    // Handle login form submit
   // Handle login form submit
public function login()
{
    $email    = $this->request->getPost('email');
    $password = $this->request->getPost('password');

    $userModel = new UserModel();
    $user = $userModel->getUserByEmail($email);

    // Check user exists and password matches
    if (!$user || !password_verify($password, $user['password'])) {
        return redirect()->to('/login')->with('error', 'Invalid email or password');
    }

    // Save user in session
    session()->set([
        'user_id'   => $user['id'],
        'user_name' => $user['name'],
        'user_role' => $user['role'],
        'logged_in' => true,
    ]);

    // ─── Redirect based on role ───────────────────────────────
    if ($user['role'] === 'admin') {
        return redirect()->to('/dbadmin/dashboard');
    }

    return redirect()->to('/labDashboard/dashboard');
}

    // Dashboard page
    public function dashboard()
    {
        // Block if not logged in
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        return view('/dbadmin/dashboard');
    }

    // Logout
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}