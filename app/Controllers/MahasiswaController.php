<?php

namespace App\Controllers;

use App\Models\PeriodeModel;
use App\Models\JawabanModel;

class MahasiswaController extends BaseController
{
    public function index()
    {
        $periodeModel = new PeriodeModel();
        
        $data = [
            'nama_user' => session()->get('nama_user'),
            'role'      => session()->get('role'),
            'periode_aktif' => $periodeModel->getActive() 
        ];

        return view('mahasiswa/dashboard', $data);
    }

    public function isiKuisioner($id_periode)
    {
        $jawabanModel = new \App\Models\JawabanModel();
        $mahasiswaModel = new \App\Models\MahasiswaModel();
        $periodeModel = new \App\Models\PeriodeModel();
        $db = \Config\Database::connect(); 

        // 1. Ambil Mahasiswa yg Login
        $user_id = session()->get('id_user');
        $mhs = $mahasiswaModel->where('id_user', $user_id)->first();
        
        if(!$mhs) return redirect()->to('/login');

        // 2. Ambil Data Periode
        $periode = $periodeModel->find($id_periode);

        // 3. AMBIL SOAL BERDASARKAN PERIODE
        $list_pertanyaan = $db->table('pertanyaan_periode_kuisioner')
            ->select('pertanyaan.*')
            ->join('pertanyaan', 'pertanyaan.id_pertanyaan = pertanyaan_periode_kuisioner.id_pertanyaan')
            ->where('pertanyaan_periode_kuisioner.id_periode_kuisioner', $id_periode)
            ->get()->getResultArray();

        // Inject Pilihan Jawaban
        foreach ($list_pertanyaan as &$p) {
            $p['pilihan'] = $db->table('pilihan_jawaban_pertanyaan')
                               ->where('id_pertanyaan', $p['id_pertanyaan'])
                               ->get()->getResultArray();
        }

        // 4. Ambil Jawaban Lama (Fitur Memory)
        $jawaban_lama = $jawabanModel->where([
            'nim' => $mhs['nim'],
            'id_periode' => $id_periode
        ])->findAll();

        $map_jawaban = [];
        foreach($jawaban_lama as $j) {
            $map_jawaban[$j['id_pertanyaan']] = $j['id_pilihan_jawaban_pertanyaan'];
        }

        $data = [
            'nama_user'      => session()->get('nama_user'),
            'periode'        => $periode,
            'id_periode'     => $id_periode,
            'pertanyaan'     => $list_pertanyaan,
            'existing_answers' => $map_jawaban
        ];

        return view('mahasiswa/form_kuisioner', $data);
    }

    public function simpanJawaban()
    {
        $jawabanModel = new \App\Models\JawabanModel();
        $mahasiswaModel = new \App\Models\MahasiswaModel();

        $mhs = $mahasiswaModel->where('id_user', session()->get('id_user'))->first();
        $id_periode = $this->request->getPost('id_periode');
        $input_jawaban = $this->request->getPost('jawaban');

        if ($input_jawaban) {
            foreach ($input_jawaban as $id_pertanyaan => $id_pilihan) {
                $cek = $jawabanModel->where([
                    'nim' => $mhs['nim'],
                    'id_periode' => $id_periode,
                    'id_pertanyaan' => $id_pertanyaan
                ])->first();

                if ($cek) {
                    $jawabanModel->update($cek['id_jawaban'], [
                        'id_pilihan_jawaban_pertanyaan' => $id_pilihan
                    ]);
                } else {
                    $jawabanModel->insert([
                        'nim' => $mhs['nim'],
                        'id_pertanyaan' => $id_pertanyaan,
                        'id_pilihan_jawaban_pertanyaan' => $id_pilihan,
                        'id_periode' => $id_periode
                    ]);
                }
            }
        }

        return redirect()->to('/mahasiswa/dashboard')->with('success', 'Terima kasih! Jawaban Anda telah tersimpan.');
    }
}