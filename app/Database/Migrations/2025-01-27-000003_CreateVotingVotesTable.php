<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVotingVotesTable extends Migration
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
            'id_voting' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_voting_option' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_user' => [
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
        $this->forge->addForeignKey('id_voting', 'voting', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_voting_option', 'voting_options', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE', 'CASCADE');
        
        // Unique constraint untuk mencegah user vote berkali-kali pada pilihan yang sama
        $this->forge->addUniqueKey(['id_voting', 'id_voting_option', 'id_user']);
        
        $this->forge->createTable('voting_votes');
    }

    public function down()
    {
        $this->forge->dropTable('voting_votes');
    }
}
