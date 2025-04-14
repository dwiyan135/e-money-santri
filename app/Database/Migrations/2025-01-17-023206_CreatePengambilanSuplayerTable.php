<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePengambilanSuplayerTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pengambilan' => [
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
            'tgl_pengambilan' => [
                'type'    => 'DATE',
                'null'    => true,
            ],
            'jumlah' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'sisa_barang' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'nominal_uang' => [
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
        $this->forge->addKey('id_pengambilan', true); // Primary key
        $this->forge->createTable('pengambilan_suplayer');
    }

    public function down()
    {
        $this->forge->dropTable('pengambilan_suplayer');
    }
}
