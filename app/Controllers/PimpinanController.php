<?php

namespace App\Controllers;

use App\Models\PeriodeModel;

class PimpinanController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $periodeModel = new PeriodeModel();

        // 1. FILTER PERIODE
        $selected_periode = $this->request->getGet('periode');
        $all_periode = $periodeModel->orderBy('id_periode', 'DESC')->findAll();

        // Default: Periode terbaru
        if (!$selected_periode && !empty($all_periode)) {
            $selected_periode = $all_periode[0]['id_periode'];
        }

        // 2. QUERY DATA SUMMARY (Complex Query)
        $laporan = [];
        
        if ($selected_periode) {
           $pertanyaan = $this->db->table('pertanyaan_periode_kuisioner')
                ->join('pertanyaan', 'pertanyaan.id_pertanyaan = pertanyaan_periode_kuisioner.id_pertanyaan')
                ->join('prodi', 'prodi.id_prodi = pertanyaan.id_prodi')
                ->where('pertanyaan_periode_kuisioner.id_periode_kuisioner', $selected_periode)
                ->orderBy('prodi.nama_prodi', 'ASC')
                ->get()->getResultArray();

            foreach ($pertanyaan as $p) {
               $opsi = $this->db->table('pilihan_jawaban_pertanyaan')
                    ->select('pilihan_jawaban_pertanyaan.*, 
                             (SELECT COUNT(*) FROM jawaban 
                              WHERE jawaban.id_pilihan_jawaban_pertanyaan = pilihan_jawaban_pertanyaan.id_pilihan_jawaban 
                              AND jawaban.id_periode = ' . $this->db->escape($selected_periode) . ') as total_pilih')
                    ->where('id_pertanyaan', $p['id_pertanyaan'])
                    ->get()->getResultArray();

                $chart_labels = [];
                $chart_data   = [];
                $total_responden = 0;

                foreach ($opsi as $op) {
                    $chart_labels[] = $op['deskripsi_pilihan'];
                    $chart_data[]   = (int)$op['total_pilih'];
                    $total_responden += (int)$op['total_pilih'];
                }

                $laporan[] = [
                    'id_pertanyaan' => $p['id_pertanyaan'],
                    'soal'          => $p['pertanyaan'],
                    'prodi'         => $p['nama_prodi'],
                    'opsi'          => $opsi,
                    'chart_labels'  => $chart_labels,
                    'chart_data'    => $chart_data,
                    'total_responden' => $total_responden
                ];
            }
        }

        $data = [
            'nama_user'     => session()->get('nama_user'),
            'role'          => session()->get('role'),
            'all_periode'   => $all_periode,
            'selected_id'   => $selected_periode,
            'laporan'       => $laporan
        ];

        return view('pimpinan/dashboard', $data);
    }
}