<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'nama_lengkap' => 'Super Administrator',
            'email'        => 'superadmin@pdpm.com',
            'password'     => password_hash('123456', PASSWORD_DEFAULT),
            'id_role'      => 1, // ID untuk Super Admin
            'status'       => 'Aktif',
            'created_at'   => date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s'),
        ];

        // Using Query Builder
        $this->db->table('users')->insert($data);
    }
}
