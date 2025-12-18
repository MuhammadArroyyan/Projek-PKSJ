<?php

namespace App\Models;

use CodeIgniter\Model;

class JawabanModel extends Model
{
    protected $table            = 'jawaban';
    protected $primaryKey       = 'id_jawaban';
    protected $returnType       = 'array';
    protected $allowedFields    = ['nim', 'id_pertanyaan', 'id_pilihan_jawaban_pertanyaan', 'id_periode'];

    public function getJawabanMahasiswa($nim, $id_periode)
    {
        return $this->where('nim', $nim)
                    ->where('id_periode', $id_periode)
                    ->findAll();
    }

    public function getSummary($id_pertanyaan, $id_periode)
    {
        return $this->select('id_pilihan_jawaban_pertanyaan, COUNT(*) as total')
                    ->where('id_pertanyaan', $id_pertanyaan)
                    ->where('id_periode', $id_periode)
                    ->groupBy('id_pilihan_jawaban_pertanyaan')
                    ->findAll();
    }
}