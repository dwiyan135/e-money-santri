<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user'; // Nama tabel
    protected $primaryKey = 'id_user'; // Primary key
    protected $allowedFields = [
        'nama_lengkap',
        'username',
        'password',
        'foto',
        'unit',
        'level',
        'created_at',
        'updated_at'
    ]; // Kolom yang bisa diisi/diupdate

    /**
     * Cari pengguna berdasarkan username.
     *
     * @param string $username
     * @return array|null
     */
    public function getUserByUsername(string $username)
    {
        return $this->where('username', $username)->first();
    }
}
