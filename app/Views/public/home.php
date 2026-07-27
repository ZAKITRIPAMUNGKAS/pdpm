<?= $this->extend('layout/public_template') ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<section class="hero-section bg-gradient-primary text-white position-relative overflow-hidden">
    <div class="container-fluid position-relative">
        <div class="row align-items-center min-vh-85 g-0">
            <div class="col-lg-6 px-5 py-5">
                <div class="hero-content text-center text-lg-start">
                    <div class="hero-logo-section mb-4">
                        <div class="logo-container mb-3">
                            <img src="/logo.png" alt="PDPM Karanganyar" class="hero-logo">
                        </div>
                        <div class="badge-container">
                            <span class="hero-badge bg-warning text-dark px-4 py-2 rounded-pill fs-6 fw-bold shadow-sm">
                                <i class="bi bi-star-fill me-2"></i>Organisasi Otonom Muhammadiyah
                            </span>
                        </div>
                    </div>
                    <h1 class="display-3 fw-bold mb-4 text-shadow hero-title">
                        Pemuda Muhammadiyah
                        <span class="text-warning d-block hero-subtitle">Karanganyar</span>
                    </h1>
                    <p class="lead mb-4 fs-5 text-light text-lg-start text-md-center text-sm-center">
                        Bersama membangun generasi muda yang beriman, berilmu, dan berakhlak mulia 
                        untuk kemajuan bangsa dan agama Islam.
                    </p>
                    <div class="hero-buttons d-flex flex-column flex-sm-row gap-3 justify-content-center justify-content-lg-start mb-4">
                        <a href="/register" class="btn btn-warning btn-lg px-5 py-3 fw-bold shadow-lg rounded-pill hero-btn-primary">
                            <i class="bi bi-person-plus me-2"></i>Bergabung Sekarang
                        </a>
                        <a href="/profil" class="btn btn-outline-light btn-lg px-5 py-3 fw-bold rounded-pill hero-btn-secondary">
                            <i class="bi bi-info-circle me-2"></i>Tentang Kami
                        </a>
                    </div>
                    <div class="hero-social d-flex justify-content-center justify-content-lg-start gap-3 mb-5">
                        <a href="#" class="social-link">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://www.instagram.com/pdpm_karanganyar/" class="social-link">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i class="bi bi-youtube"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i class="bi bi-twitter-x"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-stats">
                    <div class="row g-4">
                        <div class="col-6">
                            <div class="stat-card bg-dark bg-opacity-80 rounded-4 p-4 text-center border border-warning border-opacity-50 position-relative">
                                <div class="stat-glow"></div>
                                <div class="stat-icon mb-3">
                                    <i class="bi bi-people text-warning" data-icon-size="3rem"></i>
                                </div>
                                <h2 class="fw-bold mb-2 text-warning counter" data-target="<?= $totalAnggota ?>"><?= number_format($totalAnggota) ?></h2>
                                <p class="text-light mb-0 fw-semibold">Anggota Aktif</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-card bg-dark bg-opacity-80 rounded-4 p-4 text-center border border-warning border-opacity-50 position-relative">
                                <div class="stat-glow"></div>
                                <div class="stat-icon mb-3">
                                    <i class="bi bi-building text-warning" data-icon-size="3rem"></i>
                                </div>
                                <h2 class="fw-bold mb-2 text-warning counter" data-target="<?= $totalCabang ?>"><?= $totalCabang ?></h2>
                                <p class="text-light mb-0 fw-semibold">Cabang</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-card bg-dark bg-opacity-80 rounded-4 p-4 text-center border border-warning border-opacity-50 position-relative">
                                <div class="stat-glow"></div>
                                <div class="stat-icon mb-3">
                                    <i class="bi bi-geo-alt text-warning" data-icon-size="3rem"></i>
                                </div>
                                <h2 class="fw-bold mb-2 text-warning counter" data-target="<?= $totalRanting ?>"><?= $totalRanting ?></h2>
                                <p class="text-light mb-0 fw-semibold">Ranting</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-card bg-dark bg-opacity-80 rounded-4 p-4 text-center border border-warning border-opacity-50 position-relative">
                                <div class="stat-glow"></div>
                                <div class="stat-icon mb-3">
                                    <i class="bi bi-shield-check text-warning" data-icon-size="3rem"></i>
                                </div>
                                <h2 class="fw-bold mb-2 text-warning counter" data-target="<?= $totalKokam ?>"><?= $totalKokam ?></h2>
                                <p class="text-light mb-0 fw-semibold">Anggota KOKAM</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-wave">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M0,120V73.71c47.79-22.2,103.59-32.17,158-28,70.36,5.37,136.33,33.31,206.8,37.5C438.64,87.57,512.34,66.33,583,47.95c69.27-18,138.3-24.88,209.4-13.08,36.15,6,69.85,17.84,104.45,29.34C989.49,95,1113,134.29,1200,67.53V120Z" opacity=".25" fill="#ffffff"></path>
            <path d="M0,120V104.19C13,83.08,27.64,63.14,47.69,47.95,99.41,8.73,165,9,224.58,28.42c31.15,10.15,60.09,26.07,89.67,39.8,40.92,19,84.73,46,130.83,49.67,36.26,2.85,70.9-9.42,98.6-31.56,31.77-25.39,62.32-62,103.63-73,40.44-10.79,81.35,6.69,119.13,24.28s75.16,39,116.92,43.05c59.73,5.85,113.28-22.88,168.9-38.84,30.2-8.66,59-6.17,87.09,7.5,22.43,10.89,48,26.93,60.65,49.24V120Z" opacity=".5" fill="#ffffff"></path>
            <path d="M0,120V114.37C149.93,61,314.09,48.68,475.83,77.43c43,7.64,84.23,20.12,127.61,26.46,59,8.63,112.48-12.24,165.56-35.4C827.93,42.78,886,24.76,951.2,30c86.53,7,172.46,45.71,248.8,84.81V120Z" fill="#ffffff"></path>
        </svg>
    </div>
</section>

<!-- Features Section -->
<section class="features-section py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="display-5 fw-bold text-dark mb-3">Mengapa Bergabung dengan Kami?</h2>
                <p class="lead text-muted">Temukan alasan mengapa ribuan pemuda memilih PDPM Karanganyar</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="feature-card text-center p-4 h-100 bg-white rounded-4 shadow-sm border-0">
                    <div class="feature-icon mb-4">
                        <div class="icon-circle bg-danger bg-opacity-10 d-inline-flex align-items-center justify-content-center rounded-circle">
                            <i class="bi bi-mortarboard text-danger" data-icon-size="2rem"></i>
                        </div>
                    </div>
                    <h4 class="fw-bold mb-3 text-dark">Pengembangan Diri</h4>
                    <p class="text-muted">Program pelatihan dan pengembangan kapasitas untuk meningkatkan skill dan kemampuan anggota.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card text-center p-4 h-100 bg-white rounded-4 shadow-sm border-0">
                    <div class="feature-icon mb-4">
                        <div class="icon-circle bg-warning bg-opacity-10 d-inline-flex align-items-center justify-content-center rounded-circle">
                            <i class="bi bi-people text-warning" data-icon-size="2rem"></i>
                        </div>
                    </div>
                    <h4 class="fw-bold mb-3 text-dark">Kegiatan Sosial</h4>
                    <p class="text-muted">Berbagai program sosial dan kemanusiaan untuk membantu masyarakat yang membutuhkan.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card text-center p-4 h-100 bg-white rounded-4 shadow-sm border-0">
                    <div class="feature-icon mb-4">
                        <div class="icon-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center rounded-circle">
                            <i class="bi bi-diagram-3 text-success" data-icon-size="2rem"></i>
                        </div>
                    </div>
                    <h4 class="fw-bold mb-3 text-dark">Networking</h4>
                    <p class="text-muted">Membangun jaringan dan koneksi dengan pemuda-pemuda terbaik di seluruh Indonesia.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistik Persebaran Kader -->
<section class="statistics-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge bg-danger text-white px-3 py-2 rounded-pill mb-3">Data Terkini</span>
            <h2 class="display-5 fw-bold text-dark mb-3">Statistik Persebaran Kader</h2>
            <p class="lead text-muted">Data persebaran anggota Pemuda Muhammadiyah di seluruh Karanganyar</p>
        </div>

        <div class="row g-4">
            <!-- Statistik per Cabang -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-lg h-100 rounded-4 overflow-hidden">
                    <div class="card-header bg-gradient-danger text-white py-4 position-relative">
                        <div class="header-pattern"></div>
                        <h5 class="mb-0 fw-bold position-relative">
                            <i class="bi bi-building me-2"></i>
                            Persebaran per Cabang
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <?php if (!empty($statistikCabang)): ?>
                            <?php foreach ($statistikCabang as $index => $cabang): ?>
                                <div class="stat-item mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="d-flex align-items-center">
                                            <span class="rank-badge bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-3"><?= $index + 1 ?></span>
                                            <span class="fw-bold text-dark"><?= esc($cabang['nama_cabang']) ?></span>
                                        </div>
                                        <span class="badge bg-warning text-dark fs-6 px-3 py-2 rounded-pill"><?= $cabang['jumlah_anggota'] ?> orang</span>
                                    </div>
                                    <div class="progress-modern">
                                        <div class="progress-bar-modern bg-gradient-danger" 
                                             data-width="<?= ($cabang['jumlah_anggota'] / $totalAnggota) * 100 ?>">
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <i class="bi bi-bar-chart text-muted mb-3" style="font-size: 3rem;"></i>
                                <h5 class="text-muted">Belum ada data statistik cabang</h5>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Statistik per Ranting -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-lg h-100 rounded-4 overflow-hidden">
                    <div class="card-header bg-dark text-white py-4 position-relative">
                        <div class="header-pattern"></div>
                        <h5 class="mb-0 fw-bold position-relative">
                            <i class="bi bi-geo-alt me-2"></i>
                            Top 10 Ranting Terbesar
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <?php if (!empty($statistikRanting)): ?>
                            <?php foreach ($statistikRanting as $index => $ranting): ?>
                                <div class="ranting-item d-flex justify-content-between align-items-center mb-3 p-3 rounded-3 bg-light border-start border-4 border-warning">
                                    <div class="d-flex align-items-center">
                                        <span class="rank-badge bg-dark text-white rounded-circle d-flex align-items-center justify-content-center me-3"><?= $index + 1 ?></span>
                                        <div>
                                            <div class="fw-bold text-dark"><?= esc($ranting['nama_ranting']) ?></div>
                                            <small class="text-muted"><?= esc($ranting['nama_cabang']) ?></small>
                                        </div>
                                    </div>
                                    <span class="badge bg-warning text-dark fs-6 px-3 py-2 rounded-pill"><?= $ranting['jumlah_anggota'] ?> orang</span>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <i class="bi bi-geo-alt text-muted mb-3" style="font-size: 3rem;"></i>
                                <h5 class="text-muted">Belum ada data statistik ranting</h5>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Agenda Mendatang -->
<?php if (!empty($agenda)): ?>
<section class="agenda-section py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill mb-3">Upcoming Events</span>
            <h2 class="display-5 fw-bold text-dark mb-3">Agenda Mendatang</h2>
            <p class="lead text-muted">Kegiatan dan acara yang akan datang</p>
        </div>
        <div class="row g-4">
            <?php foreach ($agenda as $item): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="agenda-card-modern bg-white rounded-4 shadow-sm border-0 overflow-hidden h-100">
                        <div class="agenda-header bg-gradient-warning p-4 text-center">
                            <div class="date-circle bg-white text-dark rounded-circle d-inline-flex align-items-center justify-content-center mb-2">
                                <div>
                                    <div class="fw-bold fs-3"><?= date('d', strtotime($item['tanggal_mulai'])) ?></div>
                                    <small class="fw-bold"><?= strtoupper(date('M', strtotime($item['tanggal_mulai']))) ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3 text-dark"><?= esc($item['nama_kegiatan']) ?></h5>
                            <div class="agenda-meta mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-clock text-danger me-2"></i>
                                    <span class="text-muted"><?= date('H:i', strtotime($item['tanggal_mulai'])) ?> WIB</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-calendar-event text-danger me-2"></i>
                                    <span class="text-muted"><?= date('d F Y', strtotime($item['tanggal_mulai'])) ?></span>
                                </div>
                            </div>
                            <p class="text-muted"><?= esc(word_limiter($item['deskripsi'], 20, '')) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-5">
            <a href="/agenda" class="btn btn-danger btn-lg px-5 py-3 rounded-pill shadow-sm">
                <i class="bi bi-calendar-event me-2"></i>Lihat Semua Agenda
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Berita Terbaru -->
<section class="news-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge bg-danger text-white px-3 py-2 rounded-pill mb-3">Latest News</span>
            <h2 class="display-5 fw-bold text-dark mb-3">Berita & Kegiatan Terbaru</h2>
            <p class="lead text-muted">Informasi terkini dari Pimpinan Daerah Pemuda Muhammadiyah Karanganyar</p>
        </div>

        <div class="row g-4">
            <?php if (empty($berita)): ?>
                <div class="col-12">
                    <div class="empty-state text-center py-5">
                        <div class="empty-icon mb-4">
                            <i class="bi bi-newspaper text-muted opacity-50" style="font-size: 3rem;"></i>
                        </div>
                        <h4 class="text-dark mb-3">Belum Ada Berita</h4>
                        <p class="text-muted">Saat ini belum ada berita yang dipublikasikan.</p>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($berita as $item): ?>
                    <div class="col-lg-4 col-md-6">
                        <article class="news-card-modern bg-white rounded-4 shadow-sm border-0 overflow-hidden h-100">
                            <div class="news-image position-relative">
                                <img src="/uploads/berita/<?= esc($item['gambar']) ?>" 
                                     class="w-100 csp-img-250h" 
                                     alt="<?= esc($item['judul']) ?>">
                                <div class="news-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-end p-3">
                                    <span class="badge bg-danger text-white px-3 py-2 rounded-pill">Berita</span>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <h5 class="news-title fw-bold mb-3 text-dark"><?= esc($item['judul']) ?></h5>
                                <div class="news-meta d-flex align-items-center mb-3 text-muted small">
                                    <div class="d-flex align-items-center me-3">
                                        <i class="bi bi-person-lines-fill me-1 text-danger"></i>
                                        <span><?= esc($item['nama_penulis'] ?? 'Admin') ?></span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-calendar-event me-1 text-danger"></i>
                                        <span><?= date('d M Y', strtotime($item['created_at'])) ?></span>
                                    </div>
                                </div>
                                <p class="news-excerpt text-muted mb-4">
                                    <?= esc(word_limiter(strip_tags($item['isi'] ?? ''), 25, '')) ?>
                                </p>
                                <a href="<?= site_url('berita/' . $item['slug']) ?>" 
                                   class="btn btn-outline-danger rounded-pill px-4">
                                    <i class="bi bi-arrow-right me-2"></i>Baca Selengkapnya
                                </a>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <?php if (!empty($berita)): ?>
        <div class="text-center mt-5">
            <a href="/berita" class="btn btn-danger btn-lg px-5 py-3 rounded-pill shadow-sm">
                <i class="bi bi-newspaper me-2"></i>Lihat Semua Berita
            </a>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section py-5 bg-gradient-primary text-white position-relative overflow-hidden">
    <div class="cta-pattern"></div>
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h2 class="display-5 fw-bold mb-3">Siap Bergabung dengan Kami?</h2>
                <p class="lead mb-4">Jadilah bagian dari gerakan pemuda yang membawa perubahan positif untuk Indonesia.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="/register" class="btn btn-warning btn-lg px-5 py-3 fw-bold rounded-pill shadow-lg">
                    <i class="bi bi-rocket-takeoff me-2"></i>Daftar Sekarang
                </a>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/home.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- Home page scripts are now handled in custom.js -->
<?= $this->endSection() ?>
