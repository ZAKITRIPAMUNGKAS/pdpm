<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AbsensiGpsSeeder extends Seeder
{
    public function run()
    {
        // Buat tabel roles jika belum ada
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `roles` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `nama_role` varchar(50) NOT NULL,
                `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ");

        // Buat tabel cabang jika belum ada
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `cabang` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `nama_cabang` varchar(100) NOT NULL,
                `alamat` text,
                `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ");

        // Insert roles
        $roles = [
            ['id' => 1, 'nama_role' => 'Super Admin'],
            ['id' => 2, 'nama_role' => 'Admin'],
            ['id' => 3, 'nama_role' => 'Anggota']
        ];

        foreach ($roles as $role) {
            $existing = $this->db->table('roles')->where('id', $role['id'])->get()->getRow();
            if (!$existing) {
                $this->db->table('roles')->insert($role);
            }
        }

        // Insert cabang
        $cabang = [
            ['id' => 1, 'nama_cabang' => 'Karanganyar Kota', 'alamat' => 'Jl. Lawu No. 1 Karanganyar'],
            ['id' => 2, 'nama_cabang' => 'Jaten', 'alamat' => 'Jl. Raya Jaten No. 10'],
            ['id' => 3, 'nama_cabang' => 'Tasikmadu', 'alamat' => 'Jl. Raya Tasikmadu No. 5']
        ];

        foreach ($cabang as $cb) {
            $existing = $this->db->table('cabang')->where('id', $cb['id'])->get()->getRow();
            if (!$existing) {
                $this->db->table('cabang')->insert($cb);
            }
        }

        // Insert user admin
        $adminData = [
            'nama_lengkap' => 'Administrator',
            'email' => 'admin@pdpm.com',
            'no_hp' => '081234567890',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'id_role' => 1, // Super Admin
            'id_cabang' => 1,
            'status' => 'Aktif',
            'jabatan' => 'Administrator Sistem',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Cek apakah admin sudah ada
        $existingAdmin = $this->db->table('users')->where('email', 'admin@pdpm.com')->get()->getRow();
        if (!$existingAdmin) {
            $this->db->table('users')->insert($adminData);
        }

        // Insert user anggota untuk testing
        $anggotaData = [
            'nama_lengkap' => 'Ahmad Anggota',
            'email' => 'anggota@pdpm.com',
            'no_hp' => '081234567891',
            'password' => password_hash('anggota123', PASSWORD_DEFAULT),
            'id_role' => 3, // Anggota
            'id_cabang' => 1,
            'status' => 'Aktif',
            'jabatan' => 'Anggota Biasa',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Cek apakah anggota sudah ada
        $existingAnggota = $this->db->table('users')->where('email', 'anggota@pdpm.com')->get()->getRow();
        if (!$existingAnggota) {
            $this->db->table('users')->insert($anggotaData);
        }

        // Insert sample agenda dengan GPS
        $agendaData = [
            'nama_kegiatan' => 'Rapat Koordinasi Bulanan',
            'deskripsi' => 'Rapat koordinasi rutin bulanan untuk membahas program kerja dan evaluasi kegiatan.',
            'tanggal_mulai' => date('Y-m-d', strtotime('+1 day')),
            'tanggal_selesai' => date('Y-m-d', strtotime('+1 day')),
            'jam_mulai' => '08:00:00',
            'jam_selesai' => '12:00:00',
            'lokasi' => 'Kantor PDPM Karanganyar',
            'latitude' => -7.6145, // Koordinat Karanganyar
            'longitude' => 110.9425,
            'radius_meter' => 100,
            'id_penulis' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Cek apakah agenda sudah ada
        $existingAgenda = $this->db->table('agenda')->where('nama_kegiatan', 'Rapat Koordinasi Bulanan')->get()->getRow();
        if (!$existingAgenda) {
            $this->db->table('agenda')->insert($agendaData);
        }

        echo "Seeder berhasil dijalankan!\n";
        echo "Login Admin: admin@pdpm.com / admin123\n";
        echo "Login Anggota: anggota@pdpm.com / anggota123\n";
    }
}
