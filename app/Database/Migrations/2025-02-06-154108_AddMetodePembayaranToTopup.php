<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMetodePembayaranToTopup extends Migration
{
    public function up()
    {
        $this->forge->addColumn('topup', [
            'metode_pembayaran' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
                'default'    => 'Tunai'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('topup', 'metode_pembayaran');
    }
}
