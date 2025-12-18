<?php

namespace App\Models;

use CodeIgniter\Model;

class PertanyaanModel extends Model
{
    protected $table            = 'pertanyaan';
    protected $primaryKey       = 'id_pertanyaan';
    protected $returnType       = 'array';
    protected $allowedFields    = ['pertanyaan', 'id_prodi'];

    public function getPertanyaanWithPilihan($id_prodi)
    {
        $db = \Config\Database::connect();
        $builder = $this->builder();
        
        $pertanyaan = $builder->where('id_prodi', $id_prodi)->get()->getResultArray();
        
        foreach ($pertanyaan as &$p) {
            $p['pilihan'] = $db->table('pilihan_jawaban_pertanyaan')
                               ->where('id_pertanyaan', $p['id_pertanyaan'])
                               ->get()->getResultArray();
        }
        
        return $pertanyaan;
    }
}