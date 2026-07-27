<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStrukturCabangTable extends Migration
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
            'id_cabang' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'nama_lengkap' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'jabatan' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'foto' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'urutan_tampil' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['aktif', 'tidak_aktif'],
                'default'    => 'aktif',
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
        $this->forge->addKey('id_cabang');
        $this->forge->addForeignKey('id_cabang', 'cabang', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('struktur_cabang');
    }

    public function down()
    {
        $this->forge->dropTable('struktur_cabang');
    }
}
