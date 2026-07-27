<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAlamatRumahToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'alamat_rumah' => [
                'type'       => 'TEXT',
                'null'       => true,
                'after'      => 'nbm'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'alamat_rumah');
    }
}
