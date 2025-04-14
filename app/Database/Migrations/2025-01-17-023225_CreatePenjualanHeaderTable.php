<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePenjualanHeaderTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_penjualan' => [
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
            'no_santri' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => true,
            ],
            'total_harga' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'tgl_penjualan' => [
                'type'    => 'DATE',
                'null'    => true,
            ],
            'kasir' => [
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
        $this->forge->addKey('id_penjualan', true); // Primary key
        $this->forge->createTable('penjualan_header');
    }

    public function down()
    {
        $this->forge->dropTable('penjualan_header');
    }
}
