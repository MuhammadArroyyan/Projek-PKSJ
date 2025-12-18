<?php

namespace App\Models;

use CodeIgniter\Model;

class PeriodeModel extends Model
{
    protected $table            = 'periode_kuisioner';
    protected $primaryKey       = 'id_periode';
    protected $returnType       = 'array';
    protected $allowedFields    = ['keterangan', 'status_periode'];

    public function getActive()
    {
        return $this->where('status_periode', 'aktif')->findAll();
    }
}