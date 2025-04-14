<?php

namespace App\Models;

use CodeIgniter\Model;

class TabunganModel extends Model
{
    protected $table = 'tabungan'; // Nama tabel
    protected $primaryKey = 'id_tabungan'; // Primary key
    protected $allowedFields = ['id_santri', 'saldo', 'created_at', 'updated_at'];

    // Relasi dengan tabel santri
    public function getSantri($id_santri)
    {
        return $this->db->table('santri')->where('id_santri', $id_santri)->get()->getRow();
    }
}
