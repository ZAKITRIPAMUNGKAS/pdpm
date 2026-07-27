<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRantingTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_ranting' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'id_cabang' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        // Menambahkan foreign key untuk relasi ke tabel 'cabang'
        $this->forge->addForeignKey('id_cabang', 'cabang', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('ranting');
    }

    public function down()
    {
        $this->forge->dropTable('ranting');
    }
}
