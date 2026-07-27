<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNewColumnsToUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'tipe_pimpinan' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'is_kokam', // Adjust 'after' as needed
            ],
            'jabatan_organisasi' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'tipe_pimpinan',
            ],
            'jabatan_struktural' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'jabatan_organisasi',
            ],
            'jabatan_bidang' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'jabatan_struktural',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', [
            'tipe_pimpinan',
            'jabatan_organisasi',
            'jabatan_struktural',
            'jabatan_bidang',
        ]);
    }
}
