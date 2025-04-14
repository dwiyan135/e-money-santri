<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_lengkap' => 'Admin Utama',
                'username'     => 'admin',
                'password'     => password_hash('admin', PASSWORD_DEFAULT),
                'foto'         => null,
                'unit'         => 'Administrasi',
                'level'        => 'admin',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'nama_lengkap' => 'Kasir Utama',
                'username'     => 'kasir',
                'password'     => password_hash('kasir', PASSWORD_DEFAULT),
                'foto'         => null,
                'unit'         => 'Kasir',
                'level'        => 'kasir',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'nama_lengkap' => 'Tabungan Manager',
                'username'     => 'tabungan',
                'password'     => password_hash('tabungan', PASSWORD_DEFAULT),
                'foto'         => null,
                'unit'         => 'Tabungan',
                'level'        => 'tabungan',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
        ];

        // Insert data ke tabel 'user'
        $this->db->table('user')->insertBatch($data);
    }
}
