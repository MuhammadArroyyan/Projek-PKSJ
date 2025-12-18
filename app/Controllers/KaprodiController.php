<?php

namespace App\Controllers;

use App\Models\PeriodeModel;

class KaprodiController extends BaseController
{
    public function index()
    {
        $model = new PeriodeModel();
        
        $data = [
            'nama_user' => session()->get('nama_user'),
            'role'      => session()->get('role'),
            'periode'   => $model->orderBy('id_periode', 'DESC')->findAll()
        ];

        return view('kaprodi/dashboard', $data);
    }

    public function tambahPeriode()
    {
        $model = new PeriodeModel();

        if (!$this->validate(['keterangan' => 'required'])) {
            return redirect()->back()->with('error', 'Keterangan wajib diisi!');
        }

        $model->save([
            'keterangan'     => $this->request->getPost('keterangan'),
            'status_periode' => 'non-aktif'
        ]);

        return redirect()->to('/kaprodi/dashboard')->with('success', 'Periode berhasil dibuat!');
    }

    public function aktifkanPeriode($id)
    {
        $model = new PeriodeModel();
        $model->update($id, ['status_periode' => 'aktif']);

        return redirect()->to('/kaprodi/dashboard')->with('success', 'Periode Berhasil Diaktifkan!');
    }

    public function kelolaPertanyaan($id_periode)
    {
        $db = \Config\Database::connect();
        
        $periode = $db->table('periode_kuisioner')->where('id_periode', $id_periode)->get()->getRowArray();
        
        $user_id = session()->get('id_user');
        $prodi   = $db->table('prodi')->where('id_user_kaprodi', $user_id)->get()->getRowArray();

        if (!$prodi) {
            return redirect()->to('/kaprodi/dashboard')->with('error', 'Anda belum di-assign ke Prodi manapun!');
        }

        $pertanyaan_existing = $db->table('pertanyaan_periode_kuisioner')
            ->join('pertanyaan', 'pertanyaan.id_pertanyaan = pertanyaan_periode_kuisioner.id_pertanyaan')
            ->where('pertanyaan_periode_kuisioner.id_periode_kuisioner', $id_periode)
            ->get()->getResultArray();

        $data = [
            'nama_user' => session()->get('nama_user'),
            'role'      => session()->get('role'),
            'periode'   => $periode,
            'prodi'     => $prodi,
            'list_pertanyaan' => $pertanyaan_existing
        ];

        return view('kaprodi/kelola_pertanyaan', $data);
    }

    public function simpanPertanyaan()
    {
        $db = \Config\Database::connect();
        
        $id_periode = $this->request->getPost('id_periode');
        $id_prodi   = $this->request->getPost('id_prodi');
        $teks_pertanyaan = $this->request->getPost('pertanyaan');

        $db->table('pertanyaan')->insert([
            'pertanyaan' => $teks_pertanyaan,
            'id_prodi'   => $id_prodi
        ]);
        $id_pertanyaan_baru = $db->insertID();

        $opsi = ['Sangat Baik', 'Baik', 'Cukup', 'Kurang'];
        foreach($opsi as $op) {
            $db->table('pilihan_jawaban_pertanyaan')->insert([
                'deskripsi_pilihan' => $op,
                'id_pertanyaan'     => $id_pertanyaan_baru
            ]);
        }

        $db->table('pertanyaan_periode_kuisioner')->insert([
            'id_periode_kuisioner' => $id_periode,
            'id_pertanyaan'        => $id_pertanyaan_baru
        ]);

        return redirect()->to('/kaprodi/kelola_pertanyaan/' . $id_periode)->with('success', 'Pertanyaan berhasil ditambahkan ke periode ini!');
    }

    public function hapusPertanyaan($id_link, $id_periode)
    {
        $db = \Config\Database::connect();
        $db->table('pertanyaan_periode_kuisioner')->where('id_pertanyaan_periode_kuisioner', $id_link)->delete();
        return redirect()->to('/kaprodi/kelola_pertanyaan/' . $id_periode)->with('success', 'Pertanyaan dihapus dari periode.');
    }

    public function laporan($id_periode)
    {
        $db = \Config\Database::connect();
        
        // Validasi Kepemilikan Prodi
        $user_id = session()->get('id_user');
        $prodi   = $db->table('prodi')->where('id_user_kaprodi', $user_id)->get()->getRowArray();
        $periode = $db->table('periode_kuisioner')->where('id_periode', $id_periode)->get()->getRowArray();

        $pertanyaan = $db->table('pertanyaan_periode_kuisioner')
            ->join('pertanyaan', 'pertanyaan.id_pertanyaan = pertanyaan_periode_kuisioner.id_pertanyaan')
            ->where('pertanyaan_periode_kuisioner.id_periode_kuisioner', $id_periode)
            ->get()->getResultArray();

        $summary_data = [];
        foreach($pertanyaan as $p) {
            $stats = $db->table('jawaban')
                ->select('pilihan_jawaban_pertanyaan.deskripsi_pilihan, COUNT(jawaban.id_jawaban) as total')
                ->join('pilihan_jawaban_pertanyaan', 'pilihan_jawaban_pertanyaan.id_pilihan_jawaban = jawaban.id_pilihan_jawaban_pertanyaan')
                ->where('jawaban.id_pertanyaan', $p['id_pertanyaan'])
                ->where('jawaban.id_periode', $id_periode)
                ->groupBy('jawaban.id_pilihan_jawaban_pertanyaan')
                ->get()->getResultArray();
            
            $summary_data[] = [
                'soal' => $p['pertanyaan'],
                'stats'=> $stats
            ];
        }

        $detail_jawaban = $db->table('jawaban')
            ->select('mahasiswa.nama_mahasiswa, mahasiswa.nim, pertanyaan.pertanyaan, pilihan_jawaban_pertanyaan.deskripsi_pilihan')
            ->join('mahasiswa', 'mahasiswa.nim = jawaban.nim')
            ->join('pertanyaan', 'pertanyaan.id_pertanyaan = jawaban.id_pertanyaan')
            ->join('pilihan_jawaban_pertanyaan', 'pilihan_jawaban_pertanyaan.id_pilihan_jawaban = jawaban.id_pilihan_jawaban_pertanyaan')
            ->where('jawaban.id_periode', $id_periode)
            ->where('pertanyaan.id_prodi', $prodi['id_prodi'])
            ->orderBy('mahasiswa.nama_mahasiswa', 'ASC')
            ->get()->getResultArray();

        $data = [
            'nama_user' => session()->get('nama_user'),
            'role'      => session()->get('role'),
            'periode'   => $periode,
            'summary'   => $summary_data,
            'detail'    => $detail_jawaban
        ];

        return view('kaprodi/laporan', $data);
    }
}