<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyVotingForFormatur extends Migration
{
    public function up()
    {
        // Remove tipe_voting column since it's now specifically for formatur
        $this->forge->dropColumn('voting', 'tipe_voting');
        
        // Add formatur-specific fields
        $this->forge->addColumn('voting', [
            'required_selections' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'default'    => 9,
                'after'      => 'allow_multiple_choice',
                'comment'    => 'Number of formatur that must be selected (default 9)',
            ],
            'min_candidates' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'default'    => 9,
                'after'      => 'required_selections',
                'comment'    => 'Minimum number of candidates required (default 9)',
            ],
        ]);
        
        // Update allow_multiple_choice to true by default for formatur voting
        $this->forge->modifyColumn('voting', [
            'allow_multiple_choice' => [
                'type'       => 'BOOLEAN',
                'default'    => true,
            ],
        ]);
    }

    public function down()
    {
        // Restore tipe_voting column
        $this->forge->addColumn('voting', [
            'tipe_voting' => [
                'type'       => 'ENUM',
                'constraint' => ['pemilihan_ketua', 'musyawarah', 'keputusan_organisasi', 'lainnya'],
                'default'    => 'lainnya',
                'after'      => 'deskripsi',
            ],
        ]);
        
        // Remove formatur-specific fields
        $this->forge->dropColumn('voting', ['required_selections', 'min_candidates']);
        
        // Restore allow_multiple_choice default
        $this->forge->modifyColumn('voting', [
            'allow_multiple_choice' => [
                'type'       => 'BOOLEAN',
                'default'    => false,
            ],
        ]);
    }
}
