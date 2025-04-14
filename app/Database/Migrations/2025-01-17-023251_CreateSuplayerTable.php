<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSuplayerTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_suplayer' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'kode_barang' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'nama_suplayer' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'jumlah_storan' => [
                'type'       => 'INT',
                'constraint' => 10,
                'null'       => true,
            ],
            'tgl_penyetoran' => [
                'type'    => 'DATE',
                'null'    => true,
            ],
            'jumlah_terjual' => [
                'type'       => 'INT',
                'constraint' => 5,
                'null'       => true,
            ],
            'sisa_barang' => [
                'type'       => 'INT',
                'constraint' => 5,
                'null'       => true,
            ],
            'nominal_uang' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'tgl_pengambilan' => [
                'type'    => 'DATE',
                'null'    => true,
            ],
            'petugas' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'null'    => true,
                'default' => null,
            ],
            'updated_at' => [
                'type'    => 'TIMESTAMP',
                'null'    => true,
                'default' => null,
            ],
        ]);
        $this->forge->addKey('id_suplayer', true); // Primary key
        $this->forge->createTable('suplayer');
    }

    public function down()
    {
        $this->forge->dropTable('suplayer');
    }
}
