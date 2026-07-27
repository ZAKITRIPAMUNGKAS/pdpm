<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDeskripsiToGaleriTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('galeri', [
            'deskripsi' => [
                'type'       => 'TEXT',
                'null'       => true,
                'after'      => 'judul',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('galeri', 'deskripsi');
    }
}