<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAgendaPesertaTable extends Migration
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
            'status_pendaftaran' => [
                'type'       => 'ENUM',
                'constraint' => ['terdaftar', 'batal'],
                'default'    => 'terdaftar',
            ],
            'tanggal_daftar' => [
                'type'    => 'DATETIME',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_agenda', 'agenda', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addUniqueKey(['id_agenda', 'id_user'], 'unique_peserta');
        $this->forge->createTable('agenda_peserta');
    }

    public function down()
    {
        $this->forge->dropTable('agenda_peserta');
    }
}
