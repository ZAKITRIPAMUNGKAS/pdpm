<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - PDPM Karanganyar</title>
    
    <!-- Favicon & Meta Tags -->
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('logo.png') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('logo.png') ?>">
    <link rel="apple-touch-icon" href="<?= base_url('logo.png') ?>">
    <meta name="msapplication-TileImage" content="<?= base_url('logo.png') ?>">
    <meta name="msapplication-TileColor" content="#dc3545">
    <meta name="theme-color" content="#dc3545">
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="Registrasi Anggota PDPM Karanganyar - Bergabunglah dengan Pimpinan Daerah Pemuda Muhammadiyah Karanganyar">
    <meta name="keywords" content="Registrasi, Daftar, PDPM, Pemuda Muhammadiyah, Karanganyar, Anggota Baru">
    <meta name="author" content="PDPM Karanganyar">
    
    <!-- Local CSS -->
    <link rel="stylesheet" href="<?= base_url('css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('bootstrap-icons/bootstrap-icons-complete.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/custom.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/auth.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/hide-debug.css') ?>">
</head>
<body class="auth-page-body">
    <div class="auth-container">
        <div class="auth-card register-card">
            <div class="auth-header">
                <a href="/" class="back-button" title="Kembali ke Beranda">
                    <i class="bi bi-arrow-left"></i>
                </a>
                
                <div class="logo-container">
                    <a href="<?= base_url('/') ?>">
                        <img src="<?= base_url('logo.png') ?>" alt="PDPM Karanganyar" class="auth-logo">
                    </a>
                </div>
                
                <h1 class="auth-title">Daftar Anggota Baru</h1>
                <p class="auth-subtitle">Bergabunglah dengan Pemuda Muhammadiyah Karanganyar</p>
            </div>

            <div class="auth-body auth-page">
                <?php $errors = session()->get('errors'); ?>
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Terdapat kesalahan:</strong>
                        <ul class="mb-0 mt-2 ps-3">
                        <?php foreach ($errors as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                        </ul>
                    </div>
                <?php endif ?>

                <form action="<?= site_url('register/process') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    
                    <!-- Data Pribadi -->
                    <div class="form-section">
                        <div class="form-section-title">
                            <i class="bi bi-person"></i>
                            Data Pribadi
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nama_lengkap" class="form-label">
                                    <i class="bi bi-person-badge me-1 text-primary"></i>Nama Lengkap
                                </label>
                                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" 
                                       value="<?= old('nama_lengkap') ?>" placeholder="Masukkan nama lengkap" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">
                                    <i class="bi bi-envelope me-1 text-primary"></i>Email
                                </label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?= old('email') ?>" placeholder="contoh@email.com" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="no_hp" class="form-label">
                                    <i class="bi bi-whatsapp me-1 text-primary"></i>Nomor HP (WhatsApp)
                                </label>
                                <input type="tel" class="form-control" id="no_hp" name="no_hp" 
                                       value="<?= old('no_hp') ?>" placeholder="08xxxxxxxxxx" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nbm" class="form-label">
                                    <i class="bi bi-card-text me-1 text-primary"></i>NBM (Nomor Baku Muhammadiyah)
                                </label>
                                <input type="text" class="form-control" id="nbm" name="nbm" 
                                       value="<?= old('nbm') ?>" placeholder="Contoh: 1234567890">
                                <div class="form-text">
                                    <i class="bi bi-info-circle me-1"></i>
                                    <strong>Note:</strong> Jika Anda sudah memiliki NBM, silakan isi nomor NBM Anda. 
                                    Jika belum memiliki NBM, kosongkan saja field ini.
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_lahir" class="form-label">
                                    <i class="bi bi-calendar-date me-1 text-primary"></i>Tanggal Lahir
                                </label>
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" 
                                       value="<?= old('tanggal_lahir') ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="alamat_rumah" class="form-label">
                                    <i class="bi bi-house me-1 text-primary"></i>Alamat Rumah Lengkap
                                </label>
                                <textarea class="form-control" id="alamat_rumah" name="alamat_rumah" rows="3" 
                                          placeholder="Masukkan alamat lengkap (Jalan, RT/RW, Kelurahan/Desa, Kecamatan, Kabupaten/Kota)" 
                                          required><?= old('alamat_rumah') ?></textarea>
                                <div class="form-text">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Contoh: Jl. Merdeka No. 123, RT 02/RW 05, Kelurahan Karanganyar, Kecamatan Karanganyar, Kabupaten Karanganyar
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="foto" class="form-label">
                                    <i class="bi bi-camera me-1 text-primary"></i>Foto Diri
                                </label>
                                <input class="form-control" type="file" id="foto" name="foto" accept="image/*">
                                <div class="form-text">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Gunakan pakaian sopan dan rapi. Maksimal 2MB. <strong>Opsional</strong> - jika tidak diisi akan menggunakan foto default.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data Keorganisasian -->
                    <div class="form-section">
                        <div class="form-section-title">
                            <i class="bi bi-diagram-3"></i>
                            Data Keorganisasian
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-layers me-1 text-primary"></i>Tingkat Pimpinan
                            </label>
                            <div class="radio-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipe_pimpinan" id="tipe_ranting" 
                                           value="ranting" <?= old('tipe_pimpinan', 'ranting') == 'ranting' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="tipe_ranting">
                                        <i class="bi bi-geo-alt me-1"></i>Pimpinan Ranting
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipe_pimpinan" id="tipe_cabang" 
                                           value="cabang" <?= old('tipe_pimpinan') == 'cabang' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="tipe_cabang">
                                        <i class="bi bi-building me-1"></i>Pimpinan Cabang
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tipe_pimpinan" id="tipe_daerah" 
                                           value="daerah" <?= old('tipe_pimpinan') == 'daerah' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="tipe_daerah">
                                        <i class="bi bi-globe me-1"></i>Pimpinan Daerah
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3" id="cabang-wrapper">
                                <label for="id_cabang" class="form-label">
                                    <i class="bi bi-building me-1 text-primary"></i>Asal Pimpinan Cabang
                                </label>
                                <select class="form-select" id="id_cabang" name="id_cabang" required>
                                    <option value="">-- Pilih Cabang --</option>
                                    <?php foreach ($cabang as $c): ?>
                                        <option value="<?= $c['id'] ?>" <?= old('id_cabang') == $c['id'] ? 'selected' : '' ?>>
                                            <?= $c['nama_cabang'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3" id="ranting-wrapper">
                                <label for="id_ranting" class="form-label">
                                    <i class="bi bi-geo-alt me-1 text-primary"></i>Asal Pimpinan Ranting
                                </label>
                                <select class="form-select" id="id_ranting" name="id_ranting" disabled>
                                    <option value="">-- Pilih Cabang Dulu --</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-person-badge me-1 text-primary"></i>Jabatan Organisasi
                            </label>
                            <div class="radio-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jabatan_organisasi" id="jabatan_umum" 
                                           value="umum" <?= old('jabatan_organisasi') == 'umum' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="jabatan_umum">
                                        <i class="bi bi-star me-1"></i>Pimpinan Umum
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jabatan_organisasi" id="jabatan_harian" 
                                           value="harian" <?= old('jabatan_organisasi') == 'harian' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="jabatan_harian">
                                        <i class="bi bi-people me-1"></i>Pimpinan Harian
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jabatan_organisasi" id="jabatan_anggota" 
                                           value="anggota" <?= old('jabatan_organisasi', 'anggota') == 'anggota' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="jabatan_anggota">
                                        <i class="bi bi-person me-1"></i>Anggota
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row csp-hidden" id="jabatan-struktural-wrapper">
                            <div class="col-md-6 mb-3">
                                <label for="jabatan_struktural" class="form-label">
                                    <i class="bi bi-person-badge me-1 text-primary"></i>Jabatan Struktural
                                </label>
                                <select class="form-select" id="jabatan_struktural" name="jabatan_struktural">
                                    <option value="">-- Pilih Jabatan Struktural --</option>
                                </select>
                            </div>
                        </div>

                        <div class="row csp-hidden" id="jabatan-bidang-wrapper">
                            <div class="col-md-6 mb-3">
                                <label for="jabatan_bidang" class="form-label">
                                    <i class="bi bi-list-task me-1 text-primary"></i>Jabatan Bidang
                                </label>
                                <select class="form-select" id="jabatan_bidang" name="jabatan_bidang">
                                    <option value="">-- Pilih Jabatan Bidang --</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" value="1" id="is_kokam" name="is_kokam" 
                                   <?= old('is_kokam') ? 'checked' : '' ?>>
                            <label class="form-check-label" for="is_kokam">
                                <i class="bi bi-shield-check me-1 text-warning"></i>
                                Saya adalah anggota <strong>KOKAM</strong> (Komando Kesiapsiagaan Angkatan Muda Muhammadiyah)
                            </label>
                        </div>
                    </div>

                    <!-- Keamanan Akun -->
                    <div class="form-section">
                        <div class="form-section-title">
                            <i class="bi bi-lock"></i>
                            Keamanan Akun
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">
                                    <i class="bi bi-key me-1 text-primary"></i>Password
                                </label>
                                <div class="csp-pos-relative">
                                    <input type="password" class="form-control" id="password" name="password" 
                                           placeholder="Minimal 6 karakter" required>
                                    <i class="bi bi-eye csp-password-toggle" id="togglePassword"></i>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="pass_confirm" class="form-label">
                                    <i class="bi bi-check2-all me-1 text-primary"></i>Konfirmasi Password
                                </label>
                                <div class="csp-pos-relative">
                                    <input type="password" class="form-control" id="pass_confirm" name="pass_confirm" 
                                           placeholder="Ulangi password" required>
                                    <i class="bi bi-eye csp-password-toggle" id="toggleConfirmPassword"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-auth">
                        <i class="bi bi-person-plus me-2"></i>
                        Daftar Sekarang
                    </button>
                </form>

                <div class="text-center mt-4">
                    <p class="mb-0">
                        Sudah punya akun? 
                        <a href="<?= site_url('login') ?>" class="auth-link">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Login di sini
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Local Scripts -->
    <script src="<?= base_url('js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('js/custom.js') ?>"></script>
</body>
</html>
