<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PDPM Karanganyar</title>
    
    <!-- Favicon & Meta Tags -->
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('logo.png') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('logo.png') ?>">
    <link rel="apple-touch-icon" href="<?= base_url('logo.png') ?>">
    <meta name="msapplication-TileImage" content="<?= base_url('logo.png') ?>">
    <meta name="msapplication-TileColor" content="#dc3545">
    <meta name="theme-color" content="#dc3545">
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="Login Anggota PDPM Karanganyar - Sistem Informasi Pimpinan Daerah Pemuda Muhammadiyah Karanganyar">
    <meta name="keywords" content="Login, PDPM, Pemuda Muhammadiyah, Karanganyar, Anggota">
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
        <div class="auth-card">
            <div class="auth-header">
                <a href="/" class="back-button" title="Kembali ke Beranda">
                    <i class="bi bi-arrow-left"></i>
                </a>
                
                <div class="logo-container">
                    <a href="<?= base_url('/') ?>">
                        <img src="<?= base_url('logo.png') ?>" alt="PDPM Karanganyar" class="auth-logo">
                    </a>
                </div>
                
                <h1 class="auth-title">Login Anggota</h1>
                <p class="auth-subtitle">Sistem Informasi PDPM Karanganyar</p>
            </div>

            <div class="auth-body auth-page">
                <!-- Notifikasi -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle me-2"></i>
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>
                
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>
                
                <?php $errors = session()->get('errors'); ?>
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <ul class="mb-0 ps-3">
                        <?php foreach ($errors as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                        </ul>
                    </div>
                <?php endif ?>

                <form action="<?= site_url('login/process') ?>" method="post">
                    <?= csrf_field() ?>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <i class="bi bi-envelope me-2 text-primary"></i>Email
                        </label>
                        <input type="email" 
                               class="form-control" 
                               id="email" 
                               name="email" 
                               value="<?= old('email') ?>" 
                               placeholder="Masukkan email Anda"
                               required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="password" class="form-label">
                            <i class="bi bi-lock me-2 text-primary"></i>Password
                        </label>
                        <div class="csp-pos-relative">
                            <input type="password" 
                                   class="form-control" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Masukkan password Anda"
                                   required>
                            <i class="bi bi-eye csp-password-toggle" id="togglePassword"></i>
                        </div>
                    </div>

                    
                    <button type="submit" class="btn btn-auth">
                        <i class="bi bi-box-arrow-in-right me-2"></i>
                        Masuk
                    </button>
                </form>

                <div class="social-divider">
                    <span>atau</span>
                </div>

                <div class="text-center">
                    <p class="mb-0">
                        Belum punya akun? 
                        <a href="<?= site_url('register') ?>" class="auth-link">
                            <i class="bi bi-person-plus me-1"></i>Daftar di sini
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
