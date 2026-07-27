<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGaleriTable extends Migration
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
            'judul' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'file_path' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'tipe' => [
                'type'       => 'ENUM',
                'constraint' => ['foto', 'video'],
                'default'    => 'foto',
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
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_penulis', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('galeri');
    }

    public function down()
    {
        $this->forge->dropTable('galeri');
    }
}
