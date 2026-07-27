<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FormaturVotingSeeder extends Seeder
{
    public function run()
    {
        // Get the first Super Admin user
        $userModel = new \App\Models\UserModel();
        $superAdmin = $userModel->where('id_role', 1)->first();
        
        if (!$superAdmin) {
            echo "No Super Admin found. Please run AdminUserSeeder first.\n";
            return;
        }

        $votingModel = new \App\Models\VotingModel();
        $votingOptionModel = new \App\Models\VotingOptionModel();

        // Create formatur voting
        $votingData = [
            'judul' => 'Pemilihan Formatur PDPM Karanganyar 2025',
            'deskripsi' => 'Pemilihan formatur untuk periode 2025-2027. Setiap anggota dapat memilih 9 formatur dari daftar kandidat yang tersedia.',
            'tanggal_mulai' => date('Y-m-d H:i:s', strtotime('+1 day')),
            'tanggal_selesai' => date('Y-m-d H:i:s', strtotime('+7 days')),
            'id_creator' => $superAdmin['id'],
            'allow_multiple_choice' => 1,
            'required_selections' => 9,
            'min_candidates' => 9,
            'show_results_before_end' => 1,
            'min_participants' => 1,
            'status' => 'draft',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $votingId = $votingModel->insert($votingData);

        // Create formatur candidates (25 candidates)
        $candidates = [
            ['nama' => 'Ahmad Rizki Pratama', 'deskripsi' => 'Ketua Umum periode sebelumnya, berpengalaman dalam organisasi'],
            ['nama' => 'Siti Nurhaliza', 'deskripsi' => 'Sekretaris Umum, aktif dalam kegiatan sosial'],
            ['nama' => 'Budi Santoso', 'deskripsi' => 'Bendahara, memiliki latar belakang keuangan'],
            ['nama' => 'Dewi Kartika', 'deskripsi' => 'Koordinator Bidang Pendidikan'],
            ['nama' => 'Eko Prasetyo', 'deskripsi' => 'Koordinator Bidang Olahraga'],
            ['nama' => 'Fina Rahayu', 'deskripsi' => 'Koordinator Bidang Kesehatan'],
            ['nama' => 'Guntur Wijaya', 'deskripsi' => 'Koordinator Bidang Ekonomi'],
            ['nama' => 'Hesti Lestari', 'deskripsi' => 'Koordinator Bidang Sosial'],
            ['nama' => 'Indra Kurniawan', 'deskripsi' => 'Koordinator Bidang Teknologi'],
            ['nama' => 'Jihan Maharani', 'deskripsi' => 'Koordinator Bidang Lingkungan'],
            ['nama' => 'Kurniawan Adi', 'deskripsi' => 'Koordinator Bidang Pemuda'],
            ['nama' => 'Lina Sari', 'deskripsi' => 'Koordinator Bidang Perempuan'],
            ['nama' => 'Muhammad Fajar', 'deskripsi' => 'Koordinator Bidang Dakwah'],
            ['nama' => 'Nina Wulandari', 'deskripsi' => 'Koordinator Bidang Kreatif'],
            ['nama' => 'Oscar Pratama', 'deskripsi' => 'Koordinator Bidang Media'],
            ['nama' => 'Putri Anggraini', 'deskripsi' => 'Koordinator Bidang Seni'],
            ['nama' => 'Qori Sandria', 'deskripsi' => 'Koordinator Bidang Budaya'],
            ['nama' => 'Rizki Ramadhan', 'deskripsi' => 'Koordinator Bidang Rohani'],
            ['nama' => 'Sari Indah', 'deskripsi' => 'Koordinator Bidang Kesejahteraan'],
            ['nama' => 'Taufik Hidayat', 'deskripsi' => 'Koordinator Bidang Hubungan Masyarakat'],
            ['nama' => 'Umi Kalsum', 'deskripsi' => 'Koordinator Bidang Pengembangan SDM'],
            ['nama' => 'Vina Sari', 'deskripsi' => 'Koordinator Bidang Riset dan Pengembangan'],
            ['nama' => 'Wahyu Nugroho', 'deskripsi' => 'Koordinator Bidang Logistik'],
            ['nama' => 'Xena Putri', 'deskripsi' => 'Koordinator Bidang Dokumentasi'],
            ['nama' => 'Yoga Pratama', 'deskripsi' => 'Koordinator Bidang Evaluasi']
        ];

        foreach ($candidates as $index => $candidate) {
            $optionData = [
                'id_voting' => $votingId,
                'nama_pilihan' => $candidate['nama'],
                'deskripsi' => $candidate['deskripsi'],
                'foto' => null, // No photo for now
                'urutan' => $index + 1,
                'total_votes' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $votingOptionModel->insert($optionData);
        }

        echo "Formatur voting created successfully with ID: {$votingId}\n";
        echo "Created " . count($candidates) . " formatur candidates\n";
    }
}
