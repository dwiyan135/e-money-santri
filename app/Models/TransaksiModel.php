<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    protected $allowedFields = ['no_santri', 'nama_santri', 'total_harga', 'metode_pembayaran', 'created_at'];

    public function getAllTransaksi()
    {
        return $this->orderBy('created_at', 'DESC')->findAll();
    }
}
