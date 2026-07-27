<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateAgendaAddGpsFields extends Migration
{
    public function up()
    {
        $this->forge->addColumn('agenda', [
            'lokasi' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'deskripsi'
            ],
            'latitude' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,8',
                'null'       => true,
                'after'      => 'lokasi'
            ],
            'longitude' => [
                'type'       => 'DECIMAL',
                'constraint' => '11,8',
                'null'       => true,
                'after'      => 'latitude'
            ],
            'radius_meter' => [
                'type'       => 'INT',
                'default'    => 100,
                'null'       => false,
                'after'      => 'longitude'
            ],
            'jam_mulai' => [
                'type'       => 'TIME',
                'null'       => true,
                'after'      => 'tanggal_mulai'
            ],
            'jam_selesai' => [
                'type'       => 'TIME',
                'null'       => true,
                'after'      => 'tanggal_selesai'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('agenda', ['lokasi', 'latitude', 'longitude', 'radius_meter', 'jam_mulai', 'jam_selesai']);
    }
}
