<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class VotingSeeder extends Seeder
{
    public function run()
    {
        // Get super admin user ID
        $superAdmin = $this->db->table('users')
            ->where('id_role', 1)
            ->get()
            ->getRowArray();

        if (!$superAdmin) {
            echo "Super Admin tidak ditemukan. Pastikan user Super Admin sudah dibuat.\n";
            return;
        }

        // Sample voting data
        $votingData = [
            [
                'judul' => 'Pemilihan Ketua PDPM Karanganyar Periode 2025-2027',
                'deskripsi' => 'Pemilihan ketua PDPM Karanganyar untuk periode kepemimpinan 2025-2027. Silakan pilih kandidat yang menurut Anda paling tepat untuk memimpin organisasi.',
                'tipe_voting' => 'pemilihan_ketua',
                'status' => 'draft',
                'tanggal_mulai' => date('Y-m-d H:i:s', strtotime('+1 day')),
                'tanggal_selesai' => date('Y-m-d H:i:s', strtotime('+7 days')),
                'id_creator' => $superAdmin['id'],
                'allow_multiple_choice' => 0,
                'show_results_before_end' => 0,
                'min_participants' => 10,
                'total_voters' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'judul' => 'Musyawarah Rencana Kegiatan Tahunan 2025',
                'deskripsi' => 'Musyawarah untuk menentukan prioritas kegiatan PDPM Karanganyar tahun 2025. Pilih kegiatan yang menurut Anda paling penting untuk dilaksanakan.',
                'tipe_voting' => 'musyawarah',
                'status' => 'draft',
                'tanggal_mulai' => date('Y-m-d H:i:s', strtotime('+2 days')),
                'tanggal_selesai' => date('Y-m-d H:i:s', strtotime('+5 days')),
                'id_creator' => $superAdmin['id'],
                'allow_multiple_choice' => 1,
                'show_results_before_end' => 1,
                'min_participants' => 5,
                'total_voters' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'judul' => 'Keputusan Lokasi Rapat Koordinasi Bulanan',
                'deskripsi' => 'Pemilihan lokasi untuk rapat koordinasi bulanan PDPM Karanganyar. Pilih lokasi yang paling mudah dijangkau oleh semua anggota.',
                'tipe_voting' => 'keputusan_organisasi',
                'status' => 'draft',
                'tanggal_mulai' => date('Y-m-d H:i:s', strtotime('+3 days')),
                'tanggal_selesai' => date('Y-m-d H:i:s', strtotime('+3 days')),
                'id_creator' => $superAdmin['id'],
                'allow_multiple_choice' => 0,
                'show_results_before_end' => 1,
                'min_participants' => 3,
                'total_voters' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Insert voting data
        foreach ($votingData as $voting) {
            $votingId = $this->db->table('voting')->insert($voting);
            
            if ($votingId) {
                echo "✅ Voting '{$voting['judul']}' berhasil dibuat.\n";
                
                // Add options based on voting type
                $this->addVotingOptions($votingId, $voting['tipe_voting']);
            }
        }
    }

    private function addVotingOptions($votingId, $votingType)
    {
        $options = [];

        switch ($votingType) {
            case 'pemilihan_ketua':
                $options = [
                    ['nama_pilihan' => 'Ahmad Suryadi', 'deskripsi' => 'Ketua Cabang Colomadu, berpengalaman 5 tahun'],
                    ['nama_pilihan' => 'Budi Santoso', 'deskripsi' => 'Sekretaris Cabang Karanganyar Kota, aktif dalam organisasi'],
                    ['nama_pilihan' => 'Citra Dewi', 'deskripsi' => 'Bendahara Cabang Jaten, memiliki visi yang jelas'],
                    ['nama_pilihan' => 'Dedi Kurniawan', 'deskripsi' => 'Ketua Ranting Karanganyar, dekat dengan anggota']
                ];
                break;

            case 'musyawarah':
                $options = [
                    ['nama_pilihan' => 'Pelatihan Kepemimpinan', 'deskripsi' => 'Program pelatihan untuk meningkatkan kemampuan kepemimpinan anggota'],
                    ['nama_pilihan' => 'Kegiatan Sosial', 'deskripsi' => 'Aksi sosial untuk membantu masyarakat sekitar'],
                    ['nama_pilihan' => 'Seminar Kewirausahaan', 'deskripsi' => 'Seminar untuk mengembangkan jiwa kewirausahaan'],
                    ['nama_pilihan' => 'Kegiatan Olahraga', 'deskripsi' => 'Turnamen olahraga untuk mempererat silaturahmi'],
                    ['nama_pilihan' => 'Workshop Teknologi', 'deskripsi' => 'Pelatihan teknologi untuk meningkatkan kompetensi digital']
                ];
                break;

            case 'keputusan_organisasi':
                $options = [
                    ['nama_pilihan' => 'Kantor Cabang Colomadu', 'deskripsi' => 'Lokasi strategis, mudah dijangkau'],
                    ['nama_pilihan' => 'Aula Kecamatan Karanganyar', 'deskripsi' => 'Fasilitas lengkap, parkir luas'],
                    ['nama_pilihan' => 'Gedung Serbaguna Jaten', 'deskripsi' => 'Akses transportasi umum mudah'],
                    ['nama_pilihan' => 'Rumah Ketua Cabang', 'deskripsi' => 'Suasana informal, lebih akrab']
                ];
                break;

            default:
                $options = [
                    ['nama_pilihan' => 'Pilihan A', 'deskripsi' => 'Deskripsi pilihan A'],
                    ['nama_pilihan' => 'Pilihan B', 'deskripsi' => 'Deskripsi pilihan B'],
                    ['nama_pilihan' => 'Pilihan C', 'deskripsi' => 'Deskripsi pilihan C']
                ];
        }

        // Insert options
        foreach ($options as $index => $option) {
            $optionData = [
                'id_voting' => $votingId,
                'nama_pilihan' => $option['nama_pilihan'],
                'deskripsi' => $option['deskripsi'],
                'urutan' => $index + 1,
                'total_votes' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $this->db->table('voting_options')->insert($optionData);
        }

        echo "   📋 {$votingId} pilihan berhasil ditambahkan.\n";
    }
}
