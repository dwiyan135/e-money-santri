<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTopupTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_topup' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'id_santri' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'nominal' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => false,
            ],
            'admin' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
            ],
            'tanggal' => [
                'type'    => 'TIMESTAMP',
                'null'    => false,
                'onUpdate' => 'CURRENT_TIMESTAMP', // Tambahkan ini agar tanggal update otomatis
            ],
        ]);

        $this->forge->addKey('id_topup', true);
        $this->forge->addForeignKey('id_santri', 'santri', 'id_santri', 'CASCADE', 'CASCADE');
        $this->forge->createTable('topup');
    }

    public function down()
    {
        $this->forge->dropTable('topup');
    }
}
