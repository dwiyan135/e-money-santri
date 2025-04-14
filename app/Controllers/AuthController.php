<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        $data = [
            'title' => 'Masuk Admin'
        ];
        return view('auth/login', $data); // Load form login
    }

    public function authenticate()
    {
        $session = session();
        $model = new UserModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Cari pengguna berdasarkan username menggunakan UserModel
        $user = $model->getUserByUsername($username);

        if ($user) {
            // Verifikasi password
            if (password_verify($password, $user['password'])) {
                // Set data sesi
                $session->set([
                    'user_id' => $user['id_user'],
                    'username' => $user['username'],
                    'level' => $user['level'],
                    'logged_in' => true,
                ]);

                // Redirect berdasarkan role
                return redirect()->to('/dashboard');
            } else {
                $session->setFlashdata('error', 'Password salah.');
                return redirect()->back();
            }
        } else {
            $session->setFlashdata('error', 'Username tidak ditemukan.');
            return redirect()->back();
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
    
        if ($session->get('logged_in')) {
            log_message('error', 'Session masih aktif setelah keluar.');
        } else {
            log_message('info', 'Session berhasil dihapus.');
        }
    
        return redirect()->to('/auth/login')->with('success', 'Anda telah keluar.');
    }
    
}
