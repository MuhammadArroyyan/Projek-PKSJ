<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class SecureLogin extends BaseController
{
    public function index()
    {
        // Memuat View Secure (Visual sama, form action beda)
        return view('login_secure');
    }

    public function auth()
    {
        $session = session();
        $db = \Config\Database::connect();

        // 1. Ambil Input
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // [THE FORTRESS - SECURITY PATCH]
        // Menggunakan Query Builder CI4.
        // CodeIgniter secara otomatis melakukan 'escaping' pada input ini.
        // Input 'admin OR 1=1' akan dianggap sebagai STRING username semata,
        // bukan perintah logika SQL.
        
        $user = $db->table('users')
                   ->where('username', $username)
                   ->where('password', $password) // Catatan: Idealnya password di-hash, tapi untuk demo SQLi, plain text oke.
                   ->get()
                   ->getRow();

        if ($user) {
            // Login Berhasil
            $sessData = [
                'id'       => $user->id,
                'username' => $user->username,
                'role'     => $user->role,
                'isLoggedIn' => true,
                'security_level' => 'SECURE_MODE' // Penanda kita ada di mode aman
            ];
            $session->set($sessData);
            
            return redirect()->to('/dashboard');
        } else {
            // Login Gagal & Serangan Gagal
            $session->setFlashdata('msg', 'ACCESS DENIED. ATTACK NEUTRALIZED.');
            return redirect()->to('/secure-login');
        }
    }
}