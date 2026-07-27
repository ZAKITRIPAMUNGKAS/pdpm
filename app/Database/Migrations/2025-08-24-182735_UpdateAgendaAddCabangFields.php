<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateAgendaAddCabangFields extends Migration
{
    public function up()
    {
        // Add new fields to agenda table
        $fields = [
            'tingkat_agenda' => [
                'type'       => 'ENUM',
                'constraint' => ['daerah', 'cabang'],
                'default'    => 'daerah',
                'after'      => 'id_penulis',
            ],
            'id_cabang_khusus' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'tingkat_agenda',
            ],
        ];

        $this->forge->addColumn('agenda', $fields);

        // Add foreign key for id_cabang_khusus
        $this->forge->addForeignKey('id_cabang_khusus', 'cabang', 'id', 'SET NULL', 'CASCADE', 'agenda');
    }

    public function down()
    {
        // Drop foreign key first
        $this->forge->dropForeignKey('agenda', 'agenda_id_cabang_khusus_foreign');
        
        // Drop columns
        $this->forge->dropColumn('agenda', ['tingkat_agenda', 'id_cabang_khusus']);
    }
}
