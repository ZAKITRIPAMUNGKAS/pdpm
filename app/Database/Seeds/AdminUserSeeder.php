<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Data admin user
        $adminData = [
            'nama_lengkap' => 'Administrator PDPM',
            'email' => 'admin@pdpmkaranganyar.org',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'no_hp' => '081234567890',
            'tanggal_lahir' => '1990-01-01',
            'alamat_rumah' => 'Karanganyar, Jawa Tengah',
            'id_role' => 1, // Super Admin
            'id_cabang' => 1, // Cabang Karanganyar Kota
            'id_ranting' => 1, // Ranting Karanganyar
            'status' => 'Aktif', // Added status field
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Cek apakah admin sudah ada
        $existingAdmin = $this->db->table('users')->where('email', 'admin@pdpmkaranganyar.org')->get()->getRow();
        
        if (!$existingAdmin) {
            $this->db->table('users')->insert($adminData);
            echo "✅ Admin user created: admin@pdpmkaranganyar.org / admin123\n";
        } else {
            echo "ℹ️ Admin user already exists\n";
        }

        // Data user anggota untuk testing
        $memberData = [
            'nama_lengkap' => 'Ahmad Anggota',
            'email' => 'anggota@pdpmkaranganyar.org',
            'password' => password_hash('anggota123', PASSWORD_DEFAULT),
            'no_hp' => '081234567891',
            'tanggal_lahir' => '1995-05-15',
            'alamat_rumah' => 'Karanganyar, Jawa Tengah',
            'id_role' => 3, // Anggota
            'id_cabang' => 1, // Cabang Karanganyar Kota
            'id_ranting' => 1, // Ranting Karanganyar
            'status' => 'Aktif', // Added status field
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Cek apakah anggota sudah ada
        $existingMember = $this->db->table('users')->where('email', 'anggota@pdpmkaranganyar.org')->get()->getRow();
        
        if (!$existingMember) {
            $this->db->table('users')->insert($memberData);
            echo "✅ Member user created: anggota@pdpmkaranganyar.org / anggota123\n";
        } else {
            echo "ℹ️ Member user already exists\n";
        }
    }
}
