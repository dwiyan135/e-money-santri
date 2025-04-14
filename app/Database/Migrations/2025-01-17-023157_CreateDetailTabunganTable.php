<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDetailTabunganTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'no_santri' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'saldo_tambahan' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'waktu' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
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
        $this->forge->addKey('id', true); // Primary key
        $this->forge->addKey('no_santri'); // Index for relationship
        $this->forge->createTable('detail_tabungan');
    }

    public function down()
    {
        $this->forge->dropTable('detail_tabungan');
    }
}
