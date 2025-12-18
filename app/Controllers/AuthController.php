<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AuthController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function loginAman()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to($this->getDashboardByRole(session()->get('role')));
        }
        return view('auth/login_aman');
    }

    public function authAman()
    {
        $session = session();
        $model = new UserModel();
        
        $username = $this->request->getVar('nama_user'); 
        $password = $this->request->getVar('password');

        $user = $model->where('nama_user', $username)->first();

        if ($user) {
            $pass_verif = password_verify($password, $user['password']);
            
            if ($pass_verif) {
                $this->setUserSession($user);
                return redirect()->to($this->getDashboardByRole($user['role']));
            } else {
                $session->setFlashdata('msg', 'Password Salah!');
                return redirect()->to('/auth/login');
            }
        } else {
            $session->setFlashdata('msg', 'Username tidak ditemukan!');
            return redirect()->to('/auth/login');
        }
    }

    public function loginRawan()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to($this->getDashboardByRole(session()->get('role')));
        }
        return view('auth/login_rawan');
    }

    public function authRawan()
    {
        $session = session();
        
        $username = $this->request->getVar('nama_user');

        $sql = "SELECT * FROM users WHERE nama_user = '$username'";
        
        $query = $this->db->query($sql);
        $user  = $query->getRowArray();

        if ($user) {
            $session->setFlashdata('success', '⚠️ LOGIN BYPASS BERHASIL VIA SQL INJECTION!');
            
            $this->setUserSession($user);
            return redirect()->to($this->getDashboardByRole($user['role']));
        } else {
            $session->setFlashdata('msg', 'Query gagal atau user tidak ditemukan. Coba payload lain.');
            return redirect()->to('/auth/login_rawan');
        }
    }

    private function setUserSession($user)
    {
        $data = [
            'id_user'    => $user['id_user'],
            'nama_user'  => $user['nama_user'],
            'role'       => $user['role'],
            'isLoggedIn' => TRUE
        ];
        session()->set($data);
    }

    private function getDashboardByRole($role)
    {
        switch ($role) {
            case 'admin': return '/admin/dashboard';
            case 'kaprodi': return '/kaprodi/dashboard';
            case 'mahasiswa': return '/mahasiswa/dashboard';
            case 'pimpinan': return '/pimpinan/dashboard';
            default: return '/';
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login');
    }
}