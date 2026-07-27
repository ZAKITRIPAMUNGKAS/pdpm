<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKategoriToGaleriTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('galeri', [
            'kategori' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => false,
                'after'      => 'deskripsi',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('galeri', 'kategori');
    }
}
