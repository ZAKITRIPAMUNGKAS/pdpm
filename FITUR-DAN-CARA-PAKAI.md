## Fitur Utama PDPMKRA v2.0 dan Cara Pakainya (Bahasa Santai)

Dokumen ini bantu kamu paham semua fitur website dan cara memakainya tanpa ribet.

### 1) Akun & Login
- **Login**: Masuk pakai email dan password.
- **Peran (Role)**: Ada Super Admin, Admin, dan Anggota. Hak akses beda-beda.
- **Profil**: Kamu bisa lengkapi data diri, upload foto, isi jabatan, dll.

Cara pakai:
- Buka halaman login → masukkan email & password → klik Masuk.
- Setelah masuk, buka menu Profil untuk update data.

### 2) Manajemen Cabang & Ranting
- **Cabang**: Data pimpinan cabang (nama, kontak, alamat sekretariat, sosmed, dll).
- **Ranting**: Daftar ranting per cabang.

Cara pakai (Admin):
- Masuk Dashboard Admin → Cabang/Ranting → tambah/edit/hapus sesuai kebutuhan.

### 3) Agenda Kegiatan
- **Buat Agenda**: Isi nama kegiatan, deskripsi, waktu, lokasi.
- **Lokasi GPS**: Bisa isi latitude/longitude + radius (meter). Dipakai untuk absensi.
- **Penulis**: Tercatat siapa yang membuat agenda.

Cara pakai:
- Dashboard Admin → Agenda → Tambah Agenda → simpan.
- Atur koordinat lokasi (boleh salin titik dari Google Maps) + radius aman (misal 100–300 m).

### 4) Pendaftaran Peserta Agenda
- **Daftar**: Anggota bisa daftar ke agenda.
- **Status**: Otomatis "terdaftar" (bisa dibatalkan kalau perlu).

Cara pakai:
- Buka halaman agenda → klik Daftar/Ikut → status akan tersimpan.

### 5) Absensi Kegiatan (Berbasis GPS)
- **Check-in**: Absensi hanya bisa dilakukan jika kamu berada dalam radius lokasi agenda.
- **Terekam**: Sistem simpan waktu, koordinat, jarak ke titik, dan status (hadir/terlambat).

Cara pakai:
- Datang ke lokasi saat waktu kegiatan.
- Buka halaman absensi agenda → klik Absen → izinkan akses lokasi di browser.
- Kalau jarak masih jauh, dekati lokasi sesuai radius.

Tips:
- Aktifkan GPS/Location di HP.
- Pakai browser terbaru (Chrome/Edge/Safari) dan izinkan lokasi.

### 6) Berita
- **Kelola Berita**: Tulis berita, upload gambar, auto-slug.
- **Penulis**: Terhubung ke akun yang menulis.

Cara pakai (Admin):
- Dashboard Admin → Berita → Tambah → isi judul, isi berita, upload gambar → simpan.

### 7) Galeri
- **Foto/Video**: Simpan dokumentasi kegiatan.
- **Kategori**: Biar rapi berdasarkan jenis konten.

Cara pakai (Admin):
- Dashboard Admin → Galeri → Tambah → isi judul, pilih tipe, upload file → simpan.

### 8) Voting Formatur
- **Buat Voting**: Tentukan judul, deskripsi, tanggal mulai & selesai.
- **Pilihan (Kandidat)**: Tambahkan daftar kandidat.
- **Pengaturan**: Bisa wajib pilih 9 kandidat (formatur) dan minimal kandidat tersedia.
- **Hasil**: Rekap suara muncul setelah voting selesai (atau bisa diatur tampil sebelumnya).

Cara pakai (Admin):
- Dashboard Admin → Voting → Buat Voting → atur pengaturan → simpan.
- Tambahkan opsi/kandidat → simpan.

Cara ikut voting (Anggota):
- Buka halaman voting aktif → centang kandidat sesuai aturan (misal 9 orang) → Kirim.

Catatan:
- Setiap pengguna hanya bisa memilih kombinasi kandidat satu kali untuk satu voting.

### 9) Poin Pengguna (User Points)
- **Poin**: Sistem bisa memberi poin untuk aktivitas tertentu (misal keaktifan).
- **Riwayat**: Poin tersimpan per pengguna.

Cara pakai:
- Poin biasanya otomatis (sesuai aturan internal). Admin bisa melihat/kelola jika disediakan di dashboard.

### 10) Dashboard
- **Ringkasan**: Statistik singkat (pengguna, agenda, berita, dll).
- **Akses Cepat**: Menu ke modul-modul penting.

Cara pakai:
- Login → otomatis masuk Dashboard → klik menu sesuai kebutuhan.

### 11) Upload Media
- **Folder Upload**: File tersimpan di `public/uploads/` (dibagi per konten).
- **Ukuran & Format**: Gunakan ukuran wajar; format umum: JPG/PNG/WEBP untuk gambar.

Cara pakai:
- Saat tambah Berita/Galeri/Profil, klik upload → pilih file → simpan.

### 12) Keamanan & Hak Akses
- **Role-Based Access**: Super Admin/Admin bisa kelola data; Anggota akses fitur sesuai perannya.
- **Validasi**: Ada batasan unik (contoh: email unik, slug berita unik, dll).

Tips Admin:
- Kelola role user di menu Users (jika tersedia) agar akses sesuai kebutuhan.

### 13) SEO & Sitemap (opsional jika diaktifkan)
- **Sitemap**: Memudahkan indexing (cek `public/sitemap.xml`).
- **Robots**: Atur di `public/robots.txt` jika perlu.

Cara pakai:
- Pastikan domain sudah terhubung → submit sitemap ke Google Search Console.

### 14) Bantuan & Troubleshooting
- **Gagal Absensi GPS**: Pastikan GPS aktif, browser izinkan lokasi, dan kamu berada di radius lokasi.
- **Import Database**: Pakai `pdpmkara_db.sql` di root proyek; import via phpMyAdmin.
- **Error Upload**: Cek permission folder `writable/` dan `public/uploads/`.
- **Login Bermasalah**: Minta reset password ke Admin.

### 15) Alur Cepat untuk Panitia Kegiatan
1. Admin buat Agenda + atur titik lokasi & radius.
2. Anggota daftar sebagai peserta.
3. Hari H: Anggota datang, buka halaman absensi, dan Check-in.
4. Optional: Upload dokumentasi ke Galeri, buat Berita liputan.
5. Jika ada pemilihan: Admin buat Voting → anggota memilih → cek hasil.

Kalau masih bingung, sebutkan halaman yang dimaksud dan kendalanya. Nanti aku bantu langkah spesifiknya.
