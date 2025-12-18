<?php

namespace App\Controllers;

use App\Models\UserModel;

class AdminController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $data = [
            'nama_user' => session()->get('nama_user'),
            'role'      => session()->get('role'),
            
            // Mengambil Data untuk Dropdown & Tabel
            'users'     => $this->db->table('users')->get()->getResultArray(),
            'fakultas'  => $this->db->table('fakultas')->get()->getResultArray(),
            'jurusan'   => $this->db->table('jurusan')
                                    ->join('fakultas', 'fakultas.id_fakultas = jurusan.id_fakultas')
                                    ->get()->getResultArray(),
            'prodi'     => $this->db->table('prodi')
                                    ->join('jurusan', 'jurusan.id_jurusan = prodi.id_jurusan')
                                    ->join('users', 'users.id_user = prodi.id_user_kaprodi', 'left')
                                    ->select('prodi.*, jurusan.nama_jurusan, users.nama_user as nama_kaprodi')
                                    ->get()->getResultArray(),
            'mahasiswa' => $this->db->table('mahasiswa')
                                    ->join('users', 'users.id_user = mahasiswa.id_user', 'left')
                                    ->get()->getResultArray()
        ];

        return view('admin/dashboard', $data);
    }

    // --- 1. BUAT USER (ANTI-ADMIN & ANTI-DUPLIKAT) ---
    public function tambahUser()
    {
        $nama_user = $this->request->getPost('nama_user');
        $role      = $this->request->getPost('role');

        if ($role === 'admin') {
            return redirect()->back()->with('error', 'ACCESS DENIED: Dilarang menambah user Admin baru!');
        }

        $exist = $this->db->table('users')->where('nama_user', $nama_user)->get()->getRow();
        if ($exist) {
            return redirect()->back()->with('error', 'Gagal! Username/Nama User tersebut sudah terdaftar.');
        }

        $userModel = new UserModel();
        $userModel->insert([
            'nama_user' => $nama_user,
            'role'      => $role,
            'password'  => password_hash('123', PASSWORD_BCRYPT)
        ]);
        
        return redirect()->to('/admin/dashboard')->with('success', 'User berhasil dibuat!');
    }

    // --- 2. BUAT FAKULTAS (ANTI-DUPLIKAT) ---
    public function tambahFakultas()
    {
        $nama = $this->request->getPost('nama_fakultas');
        
        $exist = $this->db->table('fakultas')->where('nama_fakultas', $nama)->get()->getRow();
        if ($exist) return redirect()->back()->with('error', 'Gagal! Nama Fakultas sudah ada.');

        $this->db->table('fakultas')->insert(['nama_fakultas' => $nama]);
        return redirect()->to('/admin/dashboard')->with('success', 'Fakultas berhasil dibuat!');
    }

    // --- 3. BUAT JURUSAN (ANTI-DUPLIKAT) ---
    public function tambahJurusan()
    {
        $nama = $this->request->getPost('nama_jurusan');
        
        $exist = $this->db->table('jurusan')->where('nama_jurusan', $nama)->get()->getRow();
        if ($exist) return redirect()->back()->with('error', 'Gagal! Nama Jurusan sudah ada.');

        $this->db->table('jurusan')->insert([
            'nama_jurusan' => $nama,
            'id_fakultas'  => $this->request->getPost('id_fakultas')
        ]);
        return redirect()->to('/admin/dashboard')->with('success', 'Jurusan berhasil dibuat!');
    }

    // --- 4. BUAT PRODI (ANTI-DUPLIKAT) ---
    public function tambahProdi()
    {
        $nama = $this->request->getPost('nama_prodi');
        
        $exist = $this->db->table('prodi')->where('nama_prodi', $nama)->get()->getRow();
        if ($exist) return redirect()->back()->with('error', 'Gagal! Nama Prodi sudah ada.');

        $this->db->table('prodi')->insert([
            'nama_prodi'      => $nama,
            'id_jurusan'      => $this->request->getPost('id_jurusan'),
            'id_user_kaprodi' => $this->request->getPost('id_user_kaprodi') ?: null
        ]);
        return redirect()->to('/admin/dashboard')->with('success', 'Prodi berhasil dibuat!');
    }

    // --- 5. BUAT MAHASISWA (ANTI-DUPLIKAT NIM & AKUN GANDA) ---
    public function tambahMahasiswa()
    {
        $nim = $this->request->getPost('nim');
        $id_user = $this->request->getPost('id_user');

        $cekNIM = $this->db->table('mahasiswa')->where('nim', $nim)->get()->getRow();
        if ($cekNIM) return redirect()->back()->with('error', 'Gagal! NIM tersebut sudah terdaftar.');

        if ($id_user) {
            $cekUser = $this->db->table('mahasiswa')->where('id_user', $id_user)->get()->getRow();
            if ($cekUser) return redirect()->back()->with('error', 'Gagal! Akun User ini sudah digunakan oleh mahasiswa lain.');
        }

        $this->db->table('mahasiswa')->insert([
            'nim'            => $nim,
            'nama_mahasiswa' => $this->request->getPost('nama_mahasiswa'),
            'id_user'        => $id_user
        ]);
        return redirect()->to('/admin/dashboard')->with('success', 'Data Mahasiswa berhasil disimpan!');
    }

    public function hapusUser($id)
    {
        $this->db->table('users')->where('id_user', $id)->delete();
        return redirect()->to('/admin/dashboard')->with('success', 'User berhasil dihapus!');
    }

    public function hapusFakultas($id)
    {
        $this->db->table('fakultas')->where('id_fakultas', $id)->delete();
        return redirect()->to('/admin/dashboard')->with('success', 'Fakultas berhasil dihapus!');
    }

    public function hapusJurusan($id)
    {
        $this->db->table('jurusan')->where('id_jurusan', $id)->delete();
        return redirect()->to('/admin/dashboard')->with('success', 'Jurusan berhasil dihapus!');
    }

    public function hapusProdi($id)
    {
        $this->db->table('prodi')->where('id_prodi', $id)->delete();
        return redirect()->to('/admin/dashboard')->with('success', 'Prodi berhasil dihapus!');
    }

    public function hapusMahasiswa($nim)
    {
        $this->db->table('mahasiswa')->where('nim', $nim)->delete();
        return redirect()->to('/admin/dashboard')->with('success', 'Data Mahasiswa berhasil dihapus!');
    }

    public function formEdit($type, $id)
    {
        $data = [
            'type' => $type,
            'user_login' => session()->get('nama_user')
        ];

        if ($type == 'user') {
            $data['record'] = $this->db->table('users')->where('id_user', $id)->get()->getRowArray();
        } 
        elseif ($type == 'fakultas') {
            $data['record'] = $this->db->table('fakultas')->where('id_fakultas', $id)->get()->getRowArray();
        } 
        elseif ($type == 'jurusan') {
            $data['record']   = $this->db->table('jurusan')->where('id_jurusan', $id)->get()->getRowArray();
            $data['fakultas'] = $this->db->table('fakultas')->get()->getResultArray();
        } 
        elseif ($type == 'prodi') {
            $data['record']  = $this->db->table('prodi')->where('id_prodi', $id)->get()->getRowArray();
            $data['jurusan'] = $this->db->table('jurusan')->get()->getResultArray();
            $data['users']   = $this->db->table('users')->where('role', 'kaprodi')->get()->getResultArray();
        } 
        elseif ($type == 'mahasiswa') {
            $data['record'] = $this->db->table('mahasiswa')->where('nim', $id)->get()->getRowArray();
            $data['users']  = $this->db->table('users')->where('role', 'mahasiswa')->get()->getResultArray();
        }

        return view('admin/form_edit_universal', $data);
    }

    public function updateData()
    {
        $type = $this->request->getPost('type');
        $id   = $this->request->getPost('id_asli');

        if ($type == 'user') {
            $data = [
                'nama_user' => $this->request->getPost('nama_user'),
                'role'      => $this->request->getPost('role'),
            ];
            if($this->request->getPost('password')) {
                $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_BCRYPT);
            }
            $this->db->table('users')->where('id_user', $id)->update($data);
        }
        elseif ($type == 'fakultas') {
            $this->db->table('fakultas')->where('id_fakultas', $id)->update([
                'nama_fakultas' => $this->request->getPost('nama_fakultas')
            ]);
        }
        elseif ($type == 'jurusan') {
            $this->db->table('jurusan')->where('id_jurusan', $id)->update([
                'nama_jurusan' => $this->request->getPost('nama_jurusan'),
                'id_fakultas'  => $this->request->getPost('id_fakultas')
            ]);
        }
        elseif ($type == 'prodi') {
            $this->db->table('prodi')->where('id_prodi', $id)->update([
                'nama_prodi'      => $this->request->getPost('nama_prodi'),
                'id_jurusan'      => $this->request->getPost('id_jurusan'),
                'id_user_kaprodi' => $this->request->getPost('id_user_kaprodi') ?: null
            ]);
        }
        elseif ($type == 'mahasiswa') {
            $this->db->table('mahasiswa')->where('nim', $id)->update([
                'nim'            => $this->request->getPost('nim'),
                'nama_mahasiswa' => $this->request->getPost('nama_mahasiswa'),
                'id_user'        => $this->request->getPost('id_user')
            ]);
        }

        return redirect()->to('/admin/dashboard')->with('success', 'Data berhasil diperbarui!');
    }
}