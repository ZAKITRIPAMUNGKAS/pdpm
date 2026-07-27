<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNbmToUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'nbm' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'no_hp'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'nbm');
    }
}
