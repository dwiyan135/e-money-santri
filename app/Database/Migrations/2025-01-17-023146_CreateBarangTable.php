<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBarangTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_barang' => [
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
            'nama_barang' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'stok' => [
                'type'       => 'INT',
                'constraint' => 5,
                'null'       => true,
            ],
            'harga' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'harga_suplayer' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'laba' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'nama_suplayer' => [
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
        $this->forge->addKey('id_barang', true); // Primary key
        $this->forge->addKey('kode_barang'); // Index for faster lookup
        $this->forge->createTable('barang');
    }

    public function down()
    {
        $this->forge->dropTable('barang');
    }
}
