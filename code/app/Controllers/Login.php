<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Login extends BaseController
{
    public function index()
    {
        // Memuat View dengan tema Glitch
        return view('login_vulnerable');
    }

    public function auth()
    {
        $session = session();
        $db = \Config\Database::connect();

        // 1. MENGAMBIL INPUT RAW (Tanpa Sanitasi)
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // [VULNERABILITY POINT] 
        // Menggunakan Raw SQL dengan interpolasi variabel langsung.
        // Ini adalah "Karpet Merah" untuk SQL Injection.
        $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";

        // Eksekusi Query
        // Debugging: Kita tampilkan query ke layar agar Anda bisa melihat bentuk serangannya
        // (Hapus baris echo ini jika ingin simulasi 'blind')
        // echo "Executing Query: " . $sql; die; 
        
        $query = $db->query($sql);
        $user = $query->getRow();

        if ($user) {
            // Login Berhasil
            $sessData = [
                'id'       => $user->id,
                'username' => $user->username,
                'role'     => $user->role,
                'isLoggedIn' => true,
            ];
            $session->set($sessData);
            
            // Redirect ke Dashboard (Akan kita buat nanti)
            return redirect()->to('/dashboard');
        } else {
            // Login Gagal
            $session->setFlashdata('msg', 'ACCESS DENIED. IDENTITY INVALID.');
            return redirect()->to('/login');
        }
    }
}