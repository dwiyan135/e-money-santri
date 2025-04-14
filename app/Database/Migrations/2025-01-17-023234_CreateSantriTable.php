<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSantriTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_santri' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'no_santri' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'alamat' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'tempat_lahir' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'tanggal_lahir' => [
                'type'    => 'DATE',
                'null'    => true,
            ],
            'no_telp' => [
                'type'       => 'BIGINT',
                'constraint' => 15,
                'unsigned'   => true,
                'null'       => true,
            ],
            'kelas' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => true,
            ],
            'unit_pendidikan' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => true,
            ],
            'pin' => [
                'type'       => 'INT',
                'constraint' => 6,
                'null'       => false,
                'default'    => 123456, // Default PIN untuk santri baru
            ],
            'saldo' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => false,
                'default'    => 0.00, // Saldo awal 0
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true, // Izinkan NULL, nanti diisi secara otomatis
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => true, // Izinkan NULL, diupdate saat ada perubahan
            ],
        ]);

        $this->forge->addKey('id_santri', true); // Primary key
        $this->forge->createTable('santri');
    }

    public function down()
    {
        $this->forge->dropTable('santri');
    }
}
