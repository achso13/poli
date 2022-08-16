<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function __construct()
    {
        $this->userModel = new UserModel;
    }

    public function index()
    {
        return redirect()->to('auth/login');
    }

    public function login()
    {
        if (session()->get('log_id')) {
            return redirect()->to('/');
        }
        $data['title'] = 'Login';
        return view('auth/login', $data);
    }

    public function verifying()
    {
        $username = $this->request->getPost('f_username');
        $password = $this->request->getPost('f_password');


        if (!$username || !$password) {
            session()->setFlashdata('info', [
                'class' => 'alert-warning',
                'icon' => 'fas fa-exclamation-triangle',
                'message' => 'Username atau password tidak boleh kosong'
            ]);
            return redirect()->to('auth/login');
        }

        $user = $this->userModel->where('username', $username)->first();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $data = [
                    'log_id' => $user['id_user'],
                    'log_role' => $user['role'],
                ];
                session()->set($data);
                return redirect()->to('/');
            } else {
                session()->setFlashdata('info', [
                    'class' => 'alert-warning',
                    'icon' => 'fas fa-exclamation-triangle',
                    'message' => 'Username atau password salah'
                ]);
                return redirect()->to('/auth/login');
            }
        } else {
            session()->setFlashdata('info', [
                'class' => 'alert-warning',
                'icon' => 'fas fa-exclamation-triangle',
                'message' => 'Username atau password salah'
            ]);
            return redirect()->to('/auth/login');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login');
    }
}
