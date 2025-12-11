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
        
        $keyword = $this->request->getGet('keyword');

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
            'keyword'  => $keyword,
            'mode'     => 'VULNERABLE_MODE'
        ];

        return view('dashboard_universal', $data);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }

    public function profile()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) { return redirect()->to('/login'); }

        $db = \Config\Database::connect();
        
        $userId = $session->get('id');
        $userModel = new \App\Models\UserModel($db);
        $user = $userModel->find($userId);

        if (!$user) {
            $session->setFlashdata('error', 'User record not found.');
            return redirect()->to('/dashboard');
        }

        $data = [
            'user' => $user,
            'mode' => 'VULNERABLE_MODE (UPDATE INJECTION READY)'
        ];

        return view('profile_form', $data);
    }

    public function updateProfile()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) { return redirect()->to('/login'); }
        
        $db = \Config\Database::connect();
        $request = $this->request;

        $userId = $request->getPost('user_id');
        $newUsername = $request->getPost('username');
        $newEmail = $request->getPost('email');

        $sql = "UPDATE users SET username = '$newUsername', email = '$newEmail' WHERE id = $userId";

        try {
            $db->query($sql);
            $session->setFlashdata('success', 'Profile updated successfully! (Query executed: ' . htmlspecialchars($sql) . ')');
        } catch (\Exception $e) {
            // Error-Based SQLi: Database error ditampilkan langsung ke user jika ada kesalahan sintaks
            $session->setFlashdata('error', 'Database Error: ' . $e->getMessage());
        }

        return redirect()->to('/dashboard/profile');
    }
}