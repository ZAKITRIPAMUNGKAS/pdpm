<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAllProfileFieldsToUsers extends Migration
{
    public function up()
    {
        $fields = [
            'foto' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'no_hp',
            ],
            'is_kokam' => [
                'type'       => 'BOOLEAN',
                'default'    => false,
                'after'      => 'foto',
            ],
            'jabatan' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'is_kokam',
            ],
        ];
        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['foto', 'is_kokam', 'jabatan']);
    }
}
