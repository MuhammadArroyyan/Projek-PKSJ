<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialDataSeeder extends Seeder
{
    public function run()
    {
        // 1. SEED USERS (Admin, Pimpinan, Kaprodi, Mahasiswa)
        $users = [
            [
                'id_user'   => 1,
                'nama_user' => 'Super Admin',
                'role'      => 'admin',
            ],
            [
                'id_user'   => 2,
                'nama_user' => 'Bapak Pimpinan',
                'role'      => 'pimpinan',
            ],
            [
                'id_user'   => 3,
                'nama_user' => 'Kaprodi Informatika',
                'role'      => 'kaprodi',
            ],
            [
                'id_user'   => 4,
                'nama_user' => 'Muhammad Arroyyan Hamel',
                'role'      => 'mahasiswa',
            ]
        ];

        $this->db->table('users')->ignore(true)->insertBatch($users);

        // 2. SEED FAKULTAS
        $this->db->table('fakultas')->ignore(true)->insert([
            'id_fakultas'   => 1,
            'nama_fakultas' => 'FTTK' 
        ]);

        // 3. SEED JURUSAN (Sesuai Data Anda)
        $jurusan = [
            [
                'id_jurusan'  => 1,
                'nama_jurusan'=> 'Jurusan Teknik Elektro dan Informatika',
                'id_fakultas' => 1
            ],
            [
                'id_jurusan'  => 2,
                'nama_jurusan'=> 'Jurusan Teknik Industri Maritim',
                'id_fakultas' => 1
            ],
            [
                'id_jurusan'  => 3,
                'nama_jurusan'=> 'Jurusan Teknik Sipil dan Arsitektur',
                'id_fakultas' => 1
            ]
        ];
        $this->db->table('jurusan')->ignore(true)->insertBatch($jurusan);

        // 4. SEED PRODI (Pemetaan Logis ke Jurusan)
        $prodi = [
            [
                'nama_prodi'      => 'Teknik Informatika',
                'id_user_kaprodi' => 3, 
                'id_jurusan'      => 1 
            ],
            [
                'nama_prodi'      => 'Teknik Elektro',
                'id_user_kaprodi' => null, 
                'id_jurusan'      => 1
            ],

            [
                'nama_prodi'      => 'Teknik Perkapalan',
                'id_user_kaprodi' => null,
                'id_jurusan'      => 2
            ],
            [
                'nama_prodi'      => 'Teknik Industri',
                'id_user_kaprodi' => null,
                'id_jurusan'      => 2
            ],
            [
                'nama_prodi'      => 'Kimia',
                'id_user_kaprodi' => null,
                'id_jurusan'      => 2 
            ],

            [
                'nama_prodi'      => 'Teknik Sipil',
                'id_user_kaprodi' => null,
                'id_jurusan'      => 3
            ],
            [
                'nama_prodi'      => 'Perancangan Wilayah Kota',
                'id_user_kaprodi' => null,
                'id_jurusan'      => 3
            ]
        ];
        $this->db->table('prodi')->ignore(true)->insertBatch($prodi);

        // 5. SEED MAHASISWA (Anda)
        $this->db->table('mahasiswa')->ignore(true)->insert([
            'nim'            => '2301020117',
            'nama_mahasiswa' => 'Muhammad Arroyyan Hamel',
            'id_user'        => 4 // Link ke user login Anda
        ]);
    }
}