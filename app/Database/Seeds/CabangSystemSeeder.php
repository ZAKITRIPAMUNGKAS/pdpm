<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CabangSystemSeeder extends Seeder
{
    public function run()
    {
        // Insert cabang profiles
        $cabang_profiles = [
            [
                'id_cabang' => 1,
                'nama_ketua' => 'H. Ahmad Ketua Colomadu',
                'nama_sekretaris' => 'Siti Sekretaris Colomadu',
                'nama_bendahara' => 'Budi Bendahara Colomadu',
                'cp_cabang' => '08123456780',
                'email_cabang' => 'colomadu@pdpm.org',
                'alamat_sekretariat' => 'Jl. Sekretariat No. 1, Colomadu',
                'deskripsi_cabang' => 'Cabang Colomadu adalah salah satu cabang aktif PDPM Karanganyar yang berkomitmen untuk mengembangkan dakwah dan pendidikan Islam.',
                'instagram' => '@pdpm_colomadu',
                'facebook' => 'PDPM Colomadu',
                'website' => 'https://colomadu.pdpm.org',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id_cabang' => 2,
                'nama_ketua' => 'H. Ahmad Ketua Gondangrejo',
                'nama_sekretaris' => 'Siti Sekretaris Gondangrejo',
                'nama_bendahara' => 'Budi Bendahara Gondangrejo',
                'cp_cabang' => '08123456781',
                'email_cabang' => 'gondangrejo@pdpm.org',
                'alamat_sekretariat' => 'Jl. Sekretariat No. 2, Gondangrejo',
                'deskripsi_cabang' => 'Cabang Gondangrejo adalah salah satu cabang aktif PDPM Karanganyar yang berkomitmen untuk mengembangkan dakwah dan pendidikan Islam.',
                'instagram' => '@pdpm_gondangrejo',
                'facebook' => 'PDPM Gondangrejo',
                'website' => 'https://gondangrejo.pdpm.org',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id_cabang' => 3,
                'nama_ketua' => 'H. Ahmad Ketua Jaten',
                'nama_sekretaris' => 'Siti Sekretaris Jaten',
                'nama_bendahara' => 'Budi Bendahara Jaten',
                'cp_cabang' => '08123456782',
                'email_cabang' => 'jaten@pdpm.org',
                'alamat_sekretariat' => 'Jl. Sekretariat No. 3, Jaten',
                'deskripsi_cabang' => 'Cabang Jaten adalah salah satu cabang aktif PDPM Karanganyar yang berkomitmen untuk mengembangkan dakwah dan pendidikan Islam.',
                'instagram' => '@pdpm_jaten',
                'facebook' => 'PDPM Jaten',
                'website' => 'https://jaten.pdpm.org',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Insert cabang profiles
        foreach ($cabang_profiles as $profile) {
            // Check if already exists
            $existing = $this->db->table('cabang_profile')->where('id_cabang', $profile['id_cabang'])->get()->getRowArray();
            if (!$existing) {
                $this->db->table('cabang_profile')->insert($profile);
                echo "✅ Created profile for cabang ID: {$profile['id_cabang']}\n";
            }
        }

        // Insert struktur cabang
        $struktur_data = [
            // Struktur Cabang Colomadu
            ['id_cabang' => 1, 'nama_lengkap' => 'H. Ahmad Ketua Colomadu', 'jabatan' => 'Ketua', 'urutan_tampil' => 1, 'status' => 'aktif'],
            ['id_cabang' => 1, 'nama_lengkap' => 'Siti Sekretaris Colomadu', 'jabatan' => 'Sekretaris', 'urutan_tampil' => 2, 'status' => 'aktif'],
            ['id_cabang' => 1, 'nama_lengkap' => 'Budi Bendahara Colomadu', 'jabatan' => 'Bendahara', 'urutan_tampil' => 3, 'status' => 'aktif'],
            ['id_cabang' => 1, 'nama_lengkap' => 'Andi Wakil Ketua Colomadu', 'jabatan' => 'Wakil Ketua', 'urutan_tampil' => 4, 'status' => 'aktif'],
            
            // Struktur Cabang Gondangrejo
            ['id_cabang' => 2, 'nama_lengkap' => 'H. Ahmad Ketua Gondangrejo', 'jabatan' => 'Ketua', 'urutan_tampil' => 1, 'status' => 'aktif'],
            ['id_cabang' => 2, 'nama_lengkap' => 'Siti Sekretaris Gondangrejo', 'jabatan' => 'Sekretaris', 'urutan_tampil' => 2, 'status' => 'aktif'],
            ['id_cabang' => 2, 'nama_lengkap' => 'Budi Bendahara Gondangrejo', 'jabatan' => 'Bendahara', 'urutan_tampil' => 3, 'status' => 'aktif'],
            
            // Struktur Cabang Jaten
            ['id_cabang' => 3, 'nama_lengkap' => 'H. Ahmad Ketua Jaten', 'jabatan' => 'Ketua', 'urutan_tampil' => 1, 'status' => 'aktif'],
            ['id_cabang' => 3, 'nama_lengkap' => 'Siti Sekretaris Jaten', 'jabatan' => 'Sekretaris', 'urutan_tampil' => 2, 'status' => 'aktif'],
            ['id_cabang' => 3, 'nama_lengkap' => 'Budi Bendahara Jaten', 'jabatan' => 'Bendahara', 'urutan_tampil' => 3, 'status' => 'aktif']
        ];

        foreach ($struktur_data as $struktur) {
            $struktur['created_at'] = date('Y-m-d H:i:s');
            $struktur['updated_at'] = date('Y-m-d H:i:s');
            
            // Check if already exists
            $existing = $this->db->table('struktur_cabang')
                                ->where('id_cabang', $struktur['id_cabang'])
                                ->where('jabatan', $struktur['jabatan'])
                                ->get()->getRowArray();
            
            if (!$existing) {
                $this->db->table('struktur_cabang')->insert($struktur);
                echo "✅ Added {$struktur['jabatan']}: {$struktur['nama_lengkap']}\n";
            }
        }

        // Insert sample agenda cabang
        $agenda_data = [
            [
                'nama_kegiatan' => 'Rapat Cabang Colomadu',
                'deskripsi' => 'Rapat rutin bulanan cabang Colomadu untuk membahas program kerja dan evaluasi kegiatan.',
                'lokasi' => 'Sekretariat Cabang Colomadu',
                'latitude' => -7.6145,
                'longitude' => 110.9425,
                'radius_meter' => 50,
                'tanggal_mulai' => date('Y-m-d', strtotime('+7 days')),
                'jam_mulai' => '19:00:00',
                'tanggal_selesai' => date('Y-m-d', strtotime('+7 days')),
                'jam_selesai' => '21:00:00',
                'id_penulis' => 1,
                'tingkat_agenda' => 'cabang',
                'id_cabang_khusus' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nama_kegiatan' => 'Pengajian Rutin Gondangrejo',
                'deskripsi' => 'Pengajian rutin mingguan cabang Gondangrejo dengan tema akhlak mulia.',
                'lokasi' => 'Masjid Al-Ikhlas Gondangrejo',
                'latitude' => -7.6200,
                'longitude' => 110.9500,
                'radius_meter' => 30,
                'tanggal_mulai' => date('Y-m-d', strtotime('+3 days')),
                'jam_mulai' => '20:00:00',
                'tanggal_selesai' => date('Y-m-d', strtotime('+3 days')),
                'jam_selesai' => '21:30:00',
                'id_penulis' => 1,
                'tingkat_agenda' => 'cabang',
                'id_cabang_khusus' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        foreach ($agenda_data as $agenda) {
            // Check if already exists
            $existing = $this->db->table('agenda')->where('nama_kegiatan', $agenda['nama_kegiatan'])->get()->getRowArray();
            if (!$existing) {
                $this->db->table('agenda')->insert($agenda);
                echo "✅ Created agenda: {$agenda['nama_kegiatan']}\n";
            }
        }

        echo "\n✅ Cabang system seeder completed successfully!\n";
    }
}
