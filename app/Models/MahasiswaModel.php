<?php

namespace App\Models;

use CodeIgniter\Model;

class MahasiswaModel extends Model
{
    protected $table            = 'mahasiswa';
    protected $primaryKey       = 'nim';
    protected $useAutoIncrement = false; // NIM bukan Auto Increment
    protected $returnType       = 'array';
    protected $allowedFields    = ['nim', 'nama_mahasiswa', 'id_user'];

    public function getProfile($id_user)
    {
        return $this->where('id_user', $id_user)->first();
    }
}