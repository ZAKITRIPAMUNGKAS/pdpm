<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RefactorCabangSchema extends Migration
{
    public function up()
    {
        // Add columns from cabang_profile to cabang
        $this->forge->addColumn('cabang', [
            'nama_ketua' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'nama_sekretaris' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'nama_bendahara' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'cp_cabang' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'email_cabang' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'alamat_sekretariat' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'foto_sekretariat' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'instagram' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'facebook' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'twitter' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'youtube' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'website' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'deskripsi_cabang' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'is_completed' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'admin_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
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

        // Add foreign key for admin_id
        $this->forge->addForeignKey('admin_id', 'users', 'id', 'SET NULL', 'CASCADE');

        // Drop the old cabang_profile table
        $this->forge->dropTable('cabang_profile', true);
    }

    public function down()
    {
        // Recreate the cabang_profile table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_cabang' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            // ... add all the other columns back ...
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('cabang_profile');

        // Remove the columns from the cabang table
        $this->forge->dropColumn('cabang', ['nama_ketua', 'nama_sekretaris', 'nama_bendahara', 'cp_cabang', 'email_cabang', 'alamat_sekretariat', 'foto_sekretariat', 'instagram', 'facebook', 'twitter', 'youtube', 'website', 'deskripsi_cabang', 'is_completed', 'admin_id', 'created_at', 'updated_at']);
    }
}
