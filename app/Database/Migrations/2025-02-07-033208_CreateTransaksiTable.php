<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransaksiTable extends Migration
{
    public function up()
    {
        // Jika tabel sudah ada, hapus dulu
        $this->forge->dropTable('transaksi', true);

        $this->forge->addField([
            'id_transaksi' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'no_santri' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => false,
            ],
            'nama_santri' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'total_harga' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => false,
            ],
            'metode_pembayaran' => [
                'type'       => 'ENUM',
                'constraint' => ['tunai', 'e-money'],
                'null'       => false,
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'null'    => false,
                'default' => null,
                'useCurrent' => true, // Tambahkan ini
            ],


        ]);

        $this->forge->addKey('id_transaksi', true);
        $this->forge->createTable('transaksi');
    }


    public function down()
    {
        $this->forge->dropTable('transaksi');
    }
}
