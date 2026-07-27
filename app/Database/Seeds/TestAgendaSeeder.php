<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TestAgendaSeeder extends Seeder
{
    public function run()
    {
        // Get test user ID
        $testUser = $this->db->table('users')->where('email', 'test@pdpmkaranganyar.org')->get()->getRowArray();
        
        if (!$testUser) {
            echo "❌ Test user not found. Please run TestUserSeeder first.\n";
            return;
        }

        $data = [
            'nama_kegiatan' => 'Test Agenda Absensi GPS',
            'deskripsi' => 'Agenda test untuk menguji sistem absensi dengan GPS tracking.',
            'lokasi' => 'Kantor PDPM Karanganyar',
            'latitude' => -7.6113, // Koordinat Karanganyar
            'longitude' => 110.9447,
            'radius_meter' => 100,
            'tanggal_mulai' => date('Y-m-d'),
            'tanggal_selesai' => date('Y-m-d'),
            'jam_mulai' => '08:00:00',
            'jam_selesai' => '23:59:00', // Extended time for testing
            'id_penulis' => $testUser['id'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Check if test agenda already exists
        $existing = $this->db->table('agenda')->where('nama_kegiatan', 'Test Agenda Absensi GPS')->get()->getRowArray();
        
        if (!$existing) {
            $this->db->table('agenda')->insert($data);
            echo "✅ Test agenda created: Test Agenda Absensi GPS\n";
            echo "📍 Location: Lat {$data['latitude']}, Lng {$data['longitude']}, Radius {$data['radius_meter']}m\n";
        } else {
            echo "ℹ️ Test agenda already exists\n";
        }
    }
}
