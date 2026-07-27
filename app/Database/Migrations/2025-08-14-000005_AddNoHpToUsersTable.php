<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNoHpToUsersTable extends Migration
{
    public function up()
    {
        $fields = [
            'no_hp' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => true,
                'after'      => 'email', // Menempatkan kolom setelah email
            ],
        ];
        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'no_hp');
    }
}
