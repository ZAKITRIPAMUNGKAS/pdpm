<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAbsensiKegiatanTable extends Migration
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
            'id_agenda' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_user' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'waktu_absen' => [
                'type'    => 'DATETIME',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],
            'latitude_absen' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,8',
            ],
            'longitude_absen' => [
                'type'       => 'DECIMAL',
                'constraint' => '11,8',
            ],
            'jarak_meter' => [
                'type'       => 'DECIMAL',
                'constraint' => '8,2',
            ],
            'status_absen' => [
                'type'       => 'ENUM',
                'constraint' => ['hadir', 'terlambat'],
                'default'    => 'hadir',
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_agenda', 'agenda', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addUniqueKey(['id_agenda', 'id_user'], 'unique_absensi');
        $this->forge->createTable('absensi_kegiatan');
    }

    public function down()
    {
        $this->forge->dropTable('absensi_kegiatan');
    }
}
