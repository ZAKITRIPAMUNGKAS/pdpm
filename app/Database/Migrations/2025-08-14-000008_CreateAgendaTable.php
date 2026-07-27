<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAgendaTable extends Migration
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
            'nama_kegiatan' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'tanggal_mulai' => [
                'type' => 'DATETIME',
            ],
            'tanggal_selesai' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'id_penulis' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
             'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_penulis', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('agenda');
    }

    public function down()
    {
        $this->forge->dropTable('agenda');
    }
}
