<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AbsensiTestSeeder extends Seeder
{
    public function run()
    {
        // Data agenda test untuk absensi
        $agendaData = [
            [
                'nama_kegiatan' => 'Rapat Koordinasi Bulanan',
                'deskripsi' => 'Rapat koordinasi rutin bulanan untuk membahas program kerja dan evaluasi kegiatan.',
                'lokasi' => 'Sekretariat PDPM Karanganyar',
                'latitude' => -7.6281,
                'longitude' => 110.9425,
                'radius_meter' => 100,
                'tanggal_mulai' => date('Y-m-d'),
                'tanggal_selesai' => date('Y-m-d'),
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '17:00:00',
                'tingkat_agenda' => 'daerah',
                'id_penulis' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nama_kegiatan' => 'Pengajian Rutin Mingguan',
                'deskripsi' => 'Pengajian rutin mingguan dengan tema akhlak mulia dan pembinaan karakter.',
                'lokasi' => 'Masjid Al-Ikhlas Karanganyar',
                'latitude' => -7.6300,
                'longitude' => 110.9400,
                'radius_meter' => 50,
                'tanggal_mulai' => date('Y-m-d', strtotime('+1 day')),
                'tanggal_selesai' => date('Y-m-d', strtotime('+1 day')),
                'jam_mulai' => '19:00:00',
                'jam_selesai' => '21:00:00',
                'tingkat_agenda' => 'cabang',
                'id_cabang_khusus' => 1,
                'id_penulis' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'nama_kegiatan' => 'Pelatihan Kepemimpinan Pemuda',
                'deskripsi' => 'Pelatihan kepemimpinan untuk kader muda Muhammadiyah.',
                'lokasi' => 'Aula PDPM Karanganyar',
                'latitude' => -7.6250,
                'longitude' => 110.9450,
                'radius_meter' => 75,
                'tanggal_mulai' => date('Y-m-d', strtotime('+2 days')),
                'tanggal_selesai' => date('Y-m-d', strtotime('+2 days')),
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '16:00:00',
                'tingkat_agenda' => 'daerah',
                'id_penulis' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        foreach ($agendaData as $agenda) {
            $existing = $this->db->table('agenda')->where('nama_kegiatan', $agenda['nama_kegiatan'])->get()->getRow();
            
            if (!$existing) {
                $this->db->table('agenda')->insert($agenda);
                echo "✅ Created agenda: {$agenda['nama_kegiatan']}\n";
            } else {
                echo "ℹ️ Agenda already exists: {$agenda['nama_kegiatan']}\n";
            }
        }

        // Daftarkan anggota ke agenda pertama untuk testing
        // Cari user anggota yang ada
        $memberUser = $this->db->table('users')->where('email', 'anggota@pdpmkaranganyar.org')->get()->getRow();
        $agendaRow = $this->db->table('agenda')->where('nama_kegiatan', 'Rapat Koordinasi Bulanan')->get()->getRow();
        
        if ($memberUser && $agendaRow) {
            $existingPeserta = $this->db->table('agenda_peserta')
                ->where('id_agenda', $agendaRow->id)
                ->where('id_user', $memberUser->id)
                ->get()->getRow();
                
            if (!$existingPeserta) {
                $pesertaData = [
                    'id_agenda' => $agendaRow->id,
                    'id_user' => $memberUser->id,
                    'status_pendaftaran' => 'terdaftar',
                    'tanggal_daftar' => date('Y-m-d H:i:s')
                ];
                
                $this->db->table('agenda_peserta')->insert($pesertaData);
                echo "✅ Registered member to agenda for testing\n";
            } else {
                echo "ℹ️ Member already registered to agenda\n";
            }
        } else {
            echo "⚠️ Could not find member user or agenda for registration\n";
        }
    }
}
