## PDPMKRA Website v2.0 Update Patch

### Ringkasan
Rilis v2.0 berfokus pada stabilitas, penambahan fitur voting formatur, perbaikan modul agenda/absensi berbasis lokasi, perapian struktur data, dan file dump SQL yang siap diimpor untuk production.

### Sorotan Perubahan
- Fitur Voting Formatur lengkap (tabel `voting`, `voting_options`, `voting_votes`).
- Peningkatan modul Agenda & Absensi:
  - Penambahan field GPS (latitude/longitude/radius) pada `agenda`.
  - Tabel `agenda_peserta` dan `absensi_kegiatan` dengan pembatasan unik dan FK.
- Konsolidasi data organisasi:
  - Tabel `roles`, `cabang`, `ranting`, `struktur_cabang` selaras dengan FK.
- Media & Konten:
  - Tabel `berita` dan `galeri` diperbarui sesuai referensi penulis (`users`).
- Poin Pengguna:
  - Tabel `user_points` untuk akumulasi aktivitas.
- Migrations tercatat pada tabel `migrations` untuk histori pengembangan.
- Disediakan `pdpmkara_db.sql` yang terurut sesuai dependensi FK dan kompatibel phpMyAdmin/HeidiSQL.

### Perubahan Skema Basis Data (ringkas)
- Baru/diperluas:
  - `voting`, `voting_options`, `voting_votes`
  - `agenda` (GPS & pengaturan radius)
  - `agenda_peserta`, `absensi_kegiatan`
  - `user_points`
- Inti organisasi/konten:
  - `roles`, `users`, `cabang`, `ranting`, `struktur_cabang`, `berita`, `galeri`
- Sistem:
  - `migrations`

Semua definisi dan seed contoh tersedia di `pdpmkara_db.sql` (root project).

### Cara Terapkan Update
1. Backup dulu
   - Backup database lama (export via phpMyAdmin/HeidiSQL).
   - Backup folder `public/uploads/` bila diperlukan.
2. Deploy source code v2.0 ke server (salin seluruh project atau lakukan pull).
3. Import database
   - Buka phpMyAdmin → pilih database target → Import → pilih `pdpmkara_db.sql` → jalankan.
   - File sudah menyertakan `FOREIGN_KEY_CHECKS=0` dan urutan tabel yang benar.
4. Cek file environment (jika ada)
   - Pastikan koneksi DB di `app/Config/Database.php` sesuai server production.
5. Permissions (opsional, tergantung server)
   - Pastikan `writable/` dapat ditulis oleh PHP.
6. Verifikasi aplikasi berjalan (`public/index.php`).

### Potensi Breaking Changes
- Validasi FK: record `users`, `cabang`, `ranting`, `agenda` harus konsisten sebelum insert dependent.
- Unique constraints:
  - `agenda_peserta.unique_peserta (id_agenda, id_user)`
  - `absensi_kegiatan.unique_absensi (id_agenda, id_user)`
  - `berita.slug` unik
  - `users.email` unik

### Langkah Migrasi Data (jika sudah ada data lama)
- Import `pdpmkara_db.sql` ke database baru, lalu migrasikan data lama ke tabel terkait dengan menjaga FK.
- Untuk entitas yang berubah (mis. agenda dengan GPS), isi default yang aman bila belum tersedia.

### Checklist Verifikasi Pasca-Deploy
- [ ] Halaman utama dan dashboard admin terbuka tanpa error.
- [ ] CRUD `users`, `roles`, `cabang`, `ranting` berfungsi.
- [ ] Modul `agenda` menampilkan lokasi dan radius; absensi dapat tercatat.
- [ ] `berita` dan `galeri` tampil dan relasi penulis benar.
- [ ] Fitur voting: buat voting, tambah pilihan, lakukan vote, rekap statistik.
- [ ] Upload file (jika ada) berhasil dan tersimpan di `public/uploads`.
- [ ] Log error kosong atau minimal (`writable/logs/`).

### Rollback Cepat
- Restore backup database yang diambil pada langkah awal.
- Kembalikan source code ke versi sebelumnya.

### Catatan Tambahan
- SQL dump disiapkan kompatibel dengan MariaDB/MySQL, tested via HeidiSQL dan phpMyAdmin.
- Jika import gagal, periksa pesan error dan pastikan versi DB mendukung `utf8mb4` dan `InnoDB`.
