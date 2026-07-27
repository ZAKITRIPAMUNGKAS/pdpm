<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserPointsTable extends Migration
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
            'id_user' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'jenis_aktivitas' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'poin' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'deskripsi' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'id_referensi' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'tanggal_dapat' => [
                'type' => 'DATETIME',
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
        $this->forge->addKey('id_user');
        $this->forge->addKey('jenis_aktivitas');
        $this->forge->addKey('tanggal_dapat');
        
        // Foreign key constraint
        $this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('user_points');
    }

    public function down()
    {
        $this->forge->dropTable('user_points');
    }
}
