<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePenjualanDetailTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_detail' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'kode_penjualan' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'kode_barang' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'qty' => [
                'type'       => 'INT',
                'constraint' => 5,
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
        $this->forge->addKey('id_detail', true); // Primary key
        $this->forge->addKey('kode_penjualan'); // Index for relationship
        $this->forge->addKey('kode_barang'); // Index for relationship
        $this->forge->createTable('penjualan_detail');
    }

    public function down()
    {
        $this->forge->dropTable('penjualan_detail');
    }
}
