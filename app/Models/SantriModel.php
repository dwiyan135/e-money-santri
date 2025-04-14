<?php
namespace App\Models;

use CodeIgniter\Model;

class SantriModel extends Model
{
    protected $table = 'santri';
    protected $primaryKey = 'id_santri';
    protected $allowedFields = [
        'no_santri', 
        'nama', 
        'alamat', 
        'tempat_lahir', 
        'tanggal_lahir', 
        'no_telp', 
        'kelas', 
        'unit_pendidikan', 
        'pin',  // Admin bisa mengubah PIN
        'saldo' // Saldo hanya bisa diubah melalui fitur Top-Up
    ];
}
