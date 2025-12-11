<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class SecureDashboard extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('isLoggedIn') || $session->get('security_level') != 'SECURE_MODE') { 
            return redirect()->to('/secure-login'); 
        }

        $db = \Config\Database::connect();
        $builder = $db->table('mahasiswa');

        $keyword = $this->request->getGet('keyword');

        if ($keyword) {
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

        return view('dashboard_universal', $data);
    }
    public function profile()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) { return redirect()->to('/secure-login'); }

        $db = \Config\Database::connect();
        
        $userId = $session->get('id');
        $userModel = new \App\Models\UserModel($db);
        $user = $userModel->find($userId);

        if (!$user) {
            $session->setFlashdata('error', 'User record not found.');
            return redirect()->to('/secure-dashboard');
        }

        $data = [
            'user' => $user,
            'mode' => 'SECURE_MODE (PATIENTLY WAITING)'
        ];

        return view('profile_form', $data);
    }

    public function updateProfile()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) { return redirect()->to('/secure-login'); }
        
        $userModel = new \App\Models\UserModel();
        $request = $this->request;

        $userId = $request->getPost('user_id');
        $newUsername = $request->getPost('username');
        $newEmail = $request->getPost('email');

        try {
            $userModel->update($userId, [
                'username' => $newUsername,
                'email'    => $newEmail,
            ]);

            $session->setFlashdata('success', 'Profile updated successfully via Secure Model.');
        } catch (\Exception $e) {
            $session->setFlashdata('error', 'Update Failed: ' . $e->getMessage());
        }

        return redirect()->to('/secure-dashboard/profile');
    }
}