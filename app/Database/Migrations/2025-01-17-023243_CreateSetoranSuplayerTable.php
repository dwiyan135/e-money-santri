<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSetoranSuplayerTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_setoran' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'kode_barang' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => true,
            ],
            'tgl_setoran' => [
                'type'    => 'DATE',
                'null'    => true,
            ],
            'jumlah' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'petugas' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
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
        $this->forge->addKey('id_setoran', true); // Primary key
        $this->forge->createTable('setoran_suplayer');
    }

    public function down()
    {
        $this->forge->dropTable('setoran_suplayer');
    }
}
