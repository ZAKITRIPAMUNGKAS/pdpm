<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TestUserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'nama_lengkap' => 'Test User Absensi',
            'email' => 'test@pdpmkaranganyar.org',
            'password' => password_hash('test123', PASSWORD_DEFAULT),
            'id_role' => 3, // Role anggota
            'status' => 'Aktif',
            'no_hp' => '081234567890',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Check if test user already exists
        $existing = $this->db->table('users')->where('email', 'test@pdpmkaranganyar.org')->get()->getRowArray();
        
        if (!$existing) {
            $this->db->table('users')->insert($data);
            echo "✅ Test user created: test@pdpmkaranganyar.org / test123\n";
        } else {
            echo "ℹ️ Test user already exists\n";
        }
    }
}
