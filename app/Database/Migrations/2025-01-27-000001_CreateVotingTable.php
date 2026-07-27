<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVotingTable extends Migration
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
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'tipe_voting' => [
                'type'       => 'ENUM',
                'constraint' => ['pemilihan_ketua', 'musyawarah', 'keputusan_organisasi', 'lainnya'],
                'default'    => 'lainnya',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['draft', 'aktif', 'selesai', 'dibatalkan'],
                'default'    => 'draft',
            ],
            'tanggal_mulai' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'tanggal_selesai' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'id_creator' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'allow_multiple_choice' => [
                'type'       => 'BOOLEAN',
                'default'    => false,
            ],
            'show_results_before_end' => [
                'type'       => 'BOOLEAN',
                'default'    => false,
            ],
            'min_participants' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'default'    => 1,
            ],
            'total_voters' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'default'    => 0,
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
        $this->forge->addForeignKey('id_creator', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('voting');
    }

    public function down()
    {
        $this->forge->dropTable('voting');
    }
}
