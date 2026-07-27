<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Data peran yang akan dimasukkan
        $data = [
            [
                'id'        => 1,
                'nama_role' => 'Super Admin',
            ],
            [
                'id'        => 2,
                'nama_role' => 'Admin',
            ],
            [
                'id'        => 3,
                'nama_role' => 'Anggota',
            ],
        ];

        // Menggunakan Query Builder untuk memasukkan data
        // insertBatch() lebih efisien untuk banyak data sekaligus
        $this->db->table('roles')->insertBatch($data);
    }
}
