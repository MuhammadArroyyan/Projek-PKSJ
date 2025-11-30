<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) { return redirect()->to('/login'); }

        $db = \Config\Database::connect();
        
        // 1. Tangkap Input Pencarian
        $keyword = $this->request->getGet('keyword');

        // 2. LOGIKA RENTAN (VULNERABLE)
        if ($keyword) {
            $sql = "SELECT * FROM mahasiswa WHERE nama LIKE '%$keyword%' OR jurusan LIKE '%$keyword%'";
        } else {
            $sql = "SELECT * FROM mahasiswa";
        }

        $query = $db->query($sql);

        $data = [
            'username' => $session->get('username'),
            'role'     => $session->get('role'),
            'students' => $query->getResultArray(),
            'keyword'  => $keyword, // Kirim balik ke view
            'mode'     => 'VULNERABLE_MODE' // Penanda visual
        ];

        return view('dashboard_universal', $data);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}