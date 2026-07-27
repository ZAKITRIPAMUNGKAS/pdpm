<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialDataSeeder extends Seeder
{
    public function run()
    {
        // Nonaktifkan pengecekan foreign key untuk sementara
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');

        // KOSONGKAN SEMUA TABEL
        $this->db->table('berita')->truncate();
        $this->db->table('agenda')->truncate();
        $this->db->table('galeri')->truncate();
        $this->db->table('users')->truncate();
        $this->db->table('ranting')->truncate();
        $this->db->table('cabang')->truncate();
        $this->db->table('roles')->truncate();
        echo "All relevant tables truncated successfully.\n";

        // Aktifkan kembali pengecekan foreign key
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');


        // 1. Isi Tabel Roles
        $roles = [
            ['id' => 1, 'nama_role' => 'Super Admin'],
            ['id' => 2, 'nama_role' => 'Admin'],
            ['id' => 3, 'nama_role' => 'Anggota'],
        ];
        $this->db->table('roles')->insertBatch($roles);
        echo "Roles table seeded.\n";

        // 2. Isi Tabel Cabang (Data Lengkap)
        $cabang = [
            ['id' => 1, 'nama_cabang' => 'Colomadu'],
            ['id' => 2, 'nama_cabang' => 'Gondangrejo'],
            ['id' => 3, 'nama_cabang' => 'Jaten'],
            ['id' => 4, 'nama_cabang' => 'Jatipuro'],
            ['id' => 5, 'nama_cabang' => 'Jatiyoso'],
            ['id' => 6, 'nama_cabang' => 'Jenawi'],
            ['id' => 7, 'nama_cabang' => 'Jumapolo'],
            ['id' => 8, 'nama_cabang' => 'Jumantono'],
            ['id' => 9, 'nama_cabang' => 'Karanganyar'],
            ['id' => 10, 'nama_cabang' => 'Karangpandan'],
            ['id' => 11, 'nama_cabang' => 'Kebakkramat'],
            ['id' => 12, 'nama_cabang' => 'Kerjo'],
            ['id' => 13, 'nama_cabang' => 'Matesih'],
            ['id' => 14, 'nama_cabang' => 'Ngargoyoso'],
            ['id' => 15, 'nama_cabang' => 'Mojogedang'],
            ['id' => 16, 'nama_cabang' => 'Tasikmadu'],
            ['id' => 17, 'nama_cabang' => 'Tawangmangu'],
        ];
        $this->db->table('cabang')->insertBatch($cabang);
        echo "Cabang table seeded with complete data.\n";

        // 3. Isi Tabel Ranting (Data Lengkap)
        $ranting = [
            // Colomadu (id_cabang=1)
            ['nama_ranting' => 'Baturan', 'id_cabang' => 1], ['nama_ranting' => 'Blulukan', 'id_cabang' => 1], ['nama_ranting' => 'Bolon', 'id_cabang' => 1], ['nama_ranting' => 'Gajahan', 'id_cabang' => 1], ['nama_ranting' => 'Gawanan', 'id_cabang' => 1], ['nama_ranting' => 'Gedongan', 'id_cabang' => 1], ['nama_ranting' => 'Klodran', 'id_cabang' => 1], ['nama_ranting' => 'Malangjiwan', 'id_cabang' => 1], ['nama_ranting' => 'Ngasem', 'id_cabang' => 1], ['nama_ranting' => 'Paulan', 'id_cabang' => 1], ['nama_ranting' => 'Tohudan', 'id_cabang' => 1],
            // Gondangrejo (id_cabang=2)
            ['nama_ranting' => 'Bulurejo', 'id_cabang' => 2], ['nama_ranting' => 'Dayu', 'id_cabang' => 2], ['nama_ranting' => 'Jatikuwung', 'id_cabang' => 2], ['nama_ranting' => 'Jeruksawit', 'id_cabang' => 2], ['nama_ranting' => 'Karangturi', 'id_cabang' => 2], ['nama_ranting' => 'Kragan', 'id_cabang' => 2], ['nama_ranting' => 'Krendowahono', 'id_cabang' => 2], ['nama_ranting' => 'Plesungan', 'id_cabang' => 2], ['nama_ranting' => 'Rejosari', 'id_cabang' => 2], ['nama_ranting' => 'Selokaton', 'id_cabang' => 2], ['nama_ranting' => 'Tuban', 'id_cabang' => 2], ['nama_ranting' => 'Wonorejo', 'id_cabang' => 2], ['nama_ranting' => 'Wonosari', 'id_cabang' => 2],
            // Jaten (id_cabang=3)
            ['nama_ranting' => 'Brujul', 'id_cabang' => 3], ['nama_ranting' => 'Dagen', 'id_cabang' => 3], ['nama_ranting' => 'Jaten', 'id_cabang' => 3], ['nama_ranting' => 'Jati', 'id_cabang' => 3], ['nama_ranting' => 'Jetis', 'id_cabang' => 3], ['nama_ranting' => 'Ngringo', 'id_cabang' => 3], ['nama_ranting' => 'Sroyo', 'id_cabang' => 3], ['nama_ranting' => 'Suruhkalang', 'id_cabang' => 3],
            // Jatipuro (id_cabang=4)
            ['nama_ranting' => 'Jatiharjo', 'id_cabang' => 4], ['nama_ranting' => 'Jatikuwung', 'id_cabang' => 4], ['nama_ranting' => 'Jatimulyo', 'id_cabang' => 4], ['nama_ranting' => 'Jatipuro', 'id_cabang' => 4], ['nama_ranting' => 'Jatipurwo', 'id_cabang' => 4], ['nama_ranting' => 'Jatiroyo', 'id_cabang' => 4], ['nama_ranting' => 'Jatisobo', 'id_cabang' => 4], ['nama_ranting' => 'Jatisuko', 'id_cabang' => 4], ['nama_ranting' => 'Jatiwarno', 'id_cabang' => 4], ['nama_ranting' => 'Ngepungsari', 'id_cabang' => 4],
            // Jatiyoso (id_cabang=5)
            ['nama_ranting' => 'Beruk', 'id_cabang' => 5], ['nama_ranting' => 'Jatisawit', 'id_cabang' => 5], ['nama_ranting' => 'Jatiyoso', 'id_cabang' => 5], ['nama_ranting' => 'Karangsari', 'id_cabang' => 5], ['nama_ranting' => 'Petung', 'id_cabang' => 5], ['nama_ranting' => 'Tlobo', 'id_cabang' => 5], ['nama_ranting' => 'Wonokeling', 'id_cabang' => 5], ['nama_ranting' => 'Wonorejo', 'id_cabang' => 5], ['nama_ranting' => 'Wukirsawit', 'id_cabang' => 5],
            // Jenawi (id_cabang=6)
            ['nama_ranting' => 'Anggrasmanis', 'id_cabang' => 6], ['nama_ranting' => 'Balong', 'id_cabang' => 6], ['nama_ranting' => 'Gumeng', 'id_cabang' => 6], ['nama_ranting' => 'Jenawi', 'id_cabang' => 6], ['nama_ranting' => 'Lempong', 'id_cabang' => 6], ['nama_ranting' => 'Menjing', 'id_cabang' => 6], ['nama_ranting' => 'Seloromo', 'id_cabang' => 6], ['nama_ranting' => 'Sidomukti', 'id_cabang' => 6], ['nama_ranting' => 'Trengguli', 'id_cabang' => 6],
            // Jumapolo (id_cabang=7)
            ['nama_ranting' => 'Bakalan', 'id_cabang' => 7], ['nama_ranting' => 'Giriwondo', 'id_cabang' => 7], ['nama_ranting' => 'Jatirejo', 'id_cabang' => 7], ['nama_ranting' => 'Jumantoro', 'id_cabang' => 7], ['nama_ranting' => 'Jumapolo', 'id_cabang' => 7], ['nama_ranting' => 'Kadipiro', 'id_cabang' => 7], ['nama_ranting' => 'Karangbangun', 'id_cabang' => 7], ['nama_ranting' => 'Kedawung', 'id_cabang' => 7], ['nama_ranting' => 'Kwangsan', 'id_cabang' => 7], ['nama_ranting' => 'Lemahbang', 'id_cabang' => 7], ['nama_ranting' => 'Paseban', 'id_cabang' => 7], ['nama_ranting' => 'Ploso', 'id_cabang' => 7],
            // Jumantono (id_cabang=8)
            ['nama_ranting' => 'Blorong', 'id_cabang' => 8], ['nama_ranting' => 'Gemantar', 'id_cabang' => 8], ['nama_ranting' => 'Genengan', 'id_cabang' => 8], ['nama_ranting' => 'Kebak', 'id_cabang' => 8], ['nama_ranting' => 'Ngunut', 'id_cabang' => 8], ['nama_ranting' => 'Sambirejo', 'id_cabang' => 8], ['nama_ranting' => 'Sedayu', 'id_cabang' => 8], ['nama_ranting' => 'Sringin', 'id_cabang' => 8], ['nama_ranting' => 'Sukosari', 'id_cabang' => 8], ['nama_ranting' => 'Tugu', 'id_cabang' => 8], ['nama_ranting' => 'Tunggulrejo', 'id_cabang' => 8],
            // Karanganyar (id_cabang=9)
            ['nama_ranting' => 'Bejen', 'id_cabang' => 9], ['nama_ranting' => 'Bolong', 'id_cabang' => 9], ['nama_ranting' => 'Cangakan', 'id_cabang' => 9], ['nama_ranting' => 'Delingan', 'id_cabang' => 9], ['nama_ranting' => 'Gayamdompo', 'id_cabang' => 9], ['nama_ranting' => 'Gedong', 'id_cabang' => 9], ['nama_ranting' => 'Jantiharjo', 'id_cabang' => 9], ['nama_ranting' => 'Jungke', 'id_cabang' => 9], ['nama_ranting' => 'Karanganyar', 'id_cabang' => 9], ['nama_ranting' => 'Lalung', 'id_cabang' => 9], ['nama_ranting' => 'Popongan', 'id_cabang' => 9], ['nama_ranting' => 'Tegalgede', 'id_cabang' => 9],
            // Karangpandan (id_cabang=10)
            ['nama_ranting' => 'Bangsri', 'id_cabang' => 10], ['nama_ranting' => 'Dayu', 'id_cabang' => 10], ['nama_ranting' => 'Doplang', 'id_cabang' => 10], ['nama_ranting' => 'Gerdu', 'id_cabang' => 10], ['nama_ranting' => 'Gondangmanis', 'id_cabang' => 10], ['nama_ranting' => 'Harjosari', 'id_cabang' => 10], ['nama_ranting' => 'Karang', 'id_cabang' => 10], ['nama_ranting' => 'Karangpandan', 'id_cabang' => 10], ['nama_ranting' => 'Ngemplak', 'id_cabang' => 10], ['nama_ranting' => 'Salam', 'id_cabang' => 10], ['nama_ranting' => 'Tohkuning', 'id_cabang' => 10],
            // Kebakkramat (id_cabang=11)
            ['nama_ranting' => 'Alastuwo', 'id_cabang' => 11], ['nama_ranting' => 'Banjarharjo', 'id_cabang' => 11], ['nama_ranting' => 'Kaliwuluh', 'id_cabang' => 11], ['nama_ranting' => 'Kebak', 'id_cabang' => 11], ['nama_ranting' => 'Kemiri', 'id_cabang' => 11], ['nama_ranting' => 'Macanan', 'id_cabang' => 11], ['nama_ranting' => 'Malanggaten', 'id_cabang' => 11], ['nama_ranting' => 'Nangsri', 'id_cabang' => 11], ['nama_ranting' => 'Pulosari', 'id_cabang' => 11], ['nama_ranting' => 'Waru', 'id_cabang' => 11],
            // Kerjo (id_cabang=12)
            ['nama_ranting' => 'Botok', 'id_cabang' => 12], ['nama_ranting' => 'Ganten', 'id_cabang' => 12], ['nama_ranting' => 'Gempolan', 'id_cabang' => 12], ['nama_ranting' => 'Karangrejo', 'id_cabang' => 12], ['nama_ranting' => 'Kuto', 'id_cabang' => 12], ['nama_ranting' => 'Kwadungan', 'id_cabang' => 12], ['nama_ranting' => 'Plosorejo', 'id_cabang' => 12], ['nama_ranting' => 'Sumberejo', 'id_cabang' => 12], ['nama_ranting' => 'Tamansari', 'id_cabang' => 12], ['nama_ranting' => 'Tawangsari', 'id_cabang' => 12],
            // Matesih (id_cabang=13)
            ['nama_ranting' => 'Dawung', 'id_cabang' => 13], ['nama_ranting' => 'Gantiwarno', 'id_cabang' => 13], ['nama_ranting' => 'Girilayu', 'id_cabang' => 13], ['nama_ranting' => 'Karangbangun', 'id_cabang' => 13], ['nama_ranting' => 'Koripan', 'id_cabang' => 13], ['nama_ranting' => 'Matesih', 'id_cabang' => 13], ['nama_ranting' => 'Ngadiluwih', 'id_cabang' => 13], ['nama_ranting' => 'Pablengan', 'id_cabang' => 13], ['nama_ranting' => 'Plosorejo', 'id_cabang' => 13],
            // Ngargoyoso (id_cabang=14)
            ['nama_ranting' => 'Berjo', 'id_cabang' => 14], ['nama_ranting' => 'Dukuh', 'id_cabang' => 14], ['nama_ranting' => 'Girimulyo', 'id_cabang' => 14], ['nama_ranting' => 'Jatirejo', 'id_cabang' => 14], ['nama_ranting' => 'Kemuning', 'id_cabang' => 14], ['nama_ranting' => 'Ngargoyoso', 'id_cabang' => 14], ['nama_ranting' => 'Nglegok', 'id_cabang' => 14], ['nama_ranting' => 'Puntukrejo', 'id_cabang' => 14], ['nama_ranting' => 'Segorogunung', 'id_cabang' => 14],
            // Mojogedang (id_cabang=15)
            ['nama_ranting' => 'Buntar', 'id_cabang' => 15], ['nama_ranting' => 'Gebyok', 'id_cabang' => 15], ['nama_ranting' => 'Gentungan', 'id_cabang' => 15], ['nama_ranting' => 'Kaliboto', 'id_cabang' => 15], ['nama_ranting' => 'Kedungjeruk', 'id_cabang' => 15], ['nama_ranting' => 'Mojogedang', 'id_cabang' => 15], ['nama_ranting' => 'Mojoroto', 'id_cabang' => 15], ['nama_ranting' => 'Munggur', 'id_cabang' => 15], ['nama_ranting' => 'Ngadirejo', 'id_cabang' => 15], ['nama_ranting' => 'Pendem', 'id_cabang' => 15], ['nama_ranting' => 'Pereng', 'id_cabang' => 15], ['nama_ranting' => 'Pojok', 'id_cabang' => 15], ['nama_ranting' => 'Sewurejo', 'id_cabang' => 15],
            // Tasikmadu (id_cabang=16)
            ['nama_ranting' => 'Buran', 'id_cabang' => 16], ['nama_ranting' => 'Gaum', 'id_cabang' => 16], ['nama_ranting' => 'Kalijirak', 'id_cabang' => 16], ['nama_ranting' => 'Kaling', 'id_cabang' => 16], ['nama_ranting' => 'Karangmojo', 'id_cabang' => 16], ['nama_ranting' => 'Ngijo', 'id_cabang' => 16], ['nama_ranting' => 'Pandeyan', 'id_cabang' => 16], ['nama_ranting' => 'Papahan', 'id_cabang' => 16], ['nama_ranting' => 'Suruh', 'id_cabang' => 16], ['nama_ranting' => 'Wonolopo', 'id_cabang' => 16],
            // Tawangmangu (id_cabang=17)
            ['nama_ranting' => 'Bandardawung', 'id_cabang' => 17], ['nama_ranting' => 'Gondosuli', 'id_cabang' => 17], ['nama_ranting' => 'Karanglo', 'id_cabang' => 17], ['nama_ranting' => 'Nglebak', 'id_cabang' => 17], ['nama_ranting' => 'Plumbon', 'id_cabang' => 17], ['nama_ranting' => 'Sepanjang', 'id_cabang' => 17], ['nama_ranting' => 'Tengklik', 'id_cabang' => 17], ['nama_ranting' => 'Blumbang', 'id_cabang' => 17], ['nama_ranting' => 'Kalisoro', 'id_cabang' => 17], ['nama_ranting' => 'Tawangmangu', 'id_cabang' => 17],
        ];
        $this->db->table('ranting')->insertBatch($ranting);
        echo "Ranting table seeded with complete data.\n";

        // 4. Buat Akun Super Admin Pertama
        $superAdmin = [
            'nama_lengkap' => 'Super Admin PDPM',
            'email'        => 'superadmin@pdpmkra.com',
            'password'     => password_hash('password123', PASSWORD_DEFAULT),
            'id_role'      => 1, // ID untuk Super Admin
            'id_cabang'    => null, // Super admin tidak terikat cabang
            'id_ranting'   => null, // Super admin tidak terikat ranting
            'status'       => 'Aktif',
        ];
        $this->db->table('users')->insert($superAdmin);
        echo "Super Admin account created.\n";
        echo "Email: superadmin@pdpmkra.com\n";
        echo "Password: password123\n";
    }
}
