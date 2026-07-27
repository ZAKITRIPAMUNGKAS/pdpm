<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPhotoToVotingOptions extends Migration
{
    public function up()
    {
        $this->forge->addColumn('voting_options', [
            'foto' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'deskripsi',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('voting_options', 'foto');
    }
}
