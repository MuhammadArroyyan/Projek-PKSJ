<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class SecureDashboard extends BaseController
{
    public function index()
    {
        $session = session();
        // Cek login khusus mode secure
        if (!$session->get('isLoggedIn') || $session->get('security_level') != 'SECURE_MODE') { 
            return redirect()->to('/secure-login'); 
        }

        $db = \Config\Database::connect();
        $builder = $db->table('mahasiswa');

        // 1. Tangkap Input
        $keyword = $this->request->getGet('keyword');

        // 2. LOGIKA AMAN (THE FORTRESS)
        if ($keyword) {
            // CI4 otomatis melakukan escaping di sini.
            // Karakter ' akan diubah jadi \' sehingga tidak merusak query.
            $builder->groupStart()
                    ->like('nama', $keyword)
                    ->orLike('jurusan', $keyword)
                    ->groupEnd();
        }

        $query = $builder->get();

        $data = [
            'username' => $session->get('username'),
            'role'     => $session->get('role'),
            'students' => $query->getResultArray(),
            'keyword'  => $keyword,
            'mode'     => 'SECURE_MODE'
        ];

        // Kita pakai View yang SAMA untuk membuktikan UI-nya identik
        return view('dashboard_universal', $data);
    }
}