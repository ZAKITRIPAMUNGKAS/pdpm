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
            'poin' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'aktivitas' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'referensi_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'referensi_tipe' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'tanggal_dapat' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('id_user');
        $this->forge->addKey('tanggal_dapat');
        
        // Add foreign key constraint
        $this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('user_points');
    }

    public function down()
    {
        $this->forge->dropTable('user_points');
    }
}
