<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdiModel extends Model
{
    protected $table            = 'prodi';
    protected $primaryKey       = 'id_prodi';
    protected $returnType       = 'array';
    protected $allowedFields    = ['nama_prodi', 'id_user_kaprodi', 'id_jurusan'];

    public function getByKaprodi($id_user_kaprodi)
    {
        return $this->where('id_user_kaprodi', $id_user_kaprodi)->first();
    }
}