<?= $this->extend('layout/public_template') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/profil.css') ?>"><!-- samakan header dengan halaman profil -->
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
$headerData = [
    'title' => 'Daftar PCPM Karanganyar',
    'subtitle' => 'Profil dan informasi lengkap Pimpinan Cabang Pemuda Muhammadiyah di seluruh Karanganyar',
    'icon' => 'bi-building',
    'stats' => [
        'total_anggota' => $total_anggota ?? 0,
        'total_cabang' => count($cabang_list ?? []),
        'total_ranting' => $total_ranting ?? 0,
        'total_kokam' => $total_kokam ?? 0
    ]
];
?>
<?= $this->include('layout/page_header', $headerData) ?>

<div class="container my-5">
    <!-- Cabang Cards -->
    <div class="row">
        <?php if (!empty($cabang_list)): ?>
            <?php foreach ($cabang_list as $cabang): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 shadow-sm border-0 cabang-card">
                        <div class="card-image-container">
                            <?php if (!empty($cabang['foto_sekretariat'])): ?>
                                <img src="<?= base_url('uploads/cabang/' . $cabang['foto_sekretariat']) ?>" 
                                     class="card-img-top" alt="Sekretariat <?= esc($cabang['nama_cabang']) ?>">
                            <?php else: ?>
                                <div class="card-img-placeholder">
                                    <i class="bi bi-building"></i>
                                </div>
                            <?php endif; ?>
                            <div class="card-overlay">
                                <div class="overlay-content">
                                    <i class="bi bi-eye"></i>
                                    <span>Lihat Detail</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="card-header-section"> 
                                <h5 class="card-title">
                                    <i class="bi bi-geo-alt me-2 text-danger"></i>
                                    Cabang <?= esc($cabang['nama_cabang']) ?>
                                </h5>
                                
                                <?php if (!empty($cabang['deskripsi_cabang'])): ?>
                                    <p class="card-description">
                                        <?= character_limiter(esc($cabang['deskripsi_cabang']), 100) ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                            
                            <div class="card-info-section">
                                <?php if (!empty($cabang['nama_ketua'])): ?>
                                    <div class="info-item">
                                        <i class="bi bi-person-badge text-primary"></i>
                                        <div>
                                            <small class="text-muted">Ketua</small>
                                            <div class="fw-semibold"><?= esc($cabang['nama_ketua']) ?></div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($cabang['cp_cabang'])): ?>
                                    <div class="info-item">
                                        <i class="bi bi-telephone-fill text-success"></i>
                                        <div>
                                            <small class="text-muted">Kontak</small>
                                            <div class="fw-semibold"><?= esc($cabang['cp_cabang']) ?></div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($cabang['email_cabang'])): ?>
                                    <div class="info-item">
                                        <i class="bi bi-envelope text-warning"></i>
                                        <div>
                                            <small class="text-muted">Email</small>
                                            <div class="fw-semibold"><?= esc($cabang['email_cabang']) ?></div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="card-footer">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="<?= base_url('cabang/' . url_title($cabang['nama_cabang'], '-', true)) ?>" 
                                   class="btn btn-primary btn-modern">
                                    <i class="bi bi-eye me-1"></i>
                                    Lihat Detail
                                </a>
                                
                                <div class="social-links">
                                    <?php if (!empty($cabang['instagram'])): ?>
                                        <a href="https://instagram.com/<?= ltrim(esc($cabang['instagram']), '@') ?>" 
                                           target="_blank" class="social-link instagram">
                                            <i class="bi bi-instagram"></i>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($cabang['facebook'])): ?>
                                        <a href="https://facebook.com/<?= esc($cabang['facebook']) ?>" 
                                           target="_blank" class="social-link facebook">
                                            <i class="bi bi-facebook"></i>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($cabang['website'])): ?>
                                        <a href="<?= esc($cabang['website']) ?>" 
                                           target="_blank" class="social-link website">
                                            <i class="bi bi-globe"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="bi bi-building"></i>
                    </div>
                    <h3>Belum Ada Data Cabang</h3>
                    <p>Data profil cabang belum tersedia.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Statistik (menyesuaikan gaya profil) -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="content-card">
                <div class="stats-header text-center mb-4">
                    <h4 class="section-title-small mb-2">
                        <i class="bi bi-bar-chart text-primary me-2"></i>
                        Statistik PDPM Karanganyar
                    </h4>
                    <p class="text-muted">Data terkini organisasi Pemuda Muhammadiyah Karanganyar</p>
                </div>
                
                <div class="row g-4">
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-card">
                            <div class="stat-icon building">
                                <i class="bi bi-building"></i>
                            </div>
                            <div class="stat-content">
                                <h3><?= count($cabang_list) ?></h3>
                                <p>Total Cabang</p>
                                <div class="stat-progress">
                                    <div class="progress-bar" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-card">
                            <div class="stat-icon people">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="stat-content">
                                <h3><?= number_format($total_anggota ?? 0) ?></h3>
                                <p>Total Anggota</p>
                                <div class="stat-progress">
                                    <div class="progress-bar" style="width: 85%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-card">
                            <div class="stat-icon agenda">
                                <i class="bi bi-calendar-event"></i>
                            </div>
                            <div class="stat-content">
                                <h3><?= $total_agenda ?? 0 ?></h3>
                                <p>Agenda Aktif</p>
                                <div class="stat-progress">
                                    <div class="progress-bar" style="width: 70%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-card">
                            <div class="stat-icon news">
                                <i class="bi bi-newspaper"></i>
                            </div>
                            <div class="stat-content">
                                <h3><?= $total_berita ?? 0 ?></h3>
                                <p>Berita Terbaru</p>
                                <div class="stat-progress">
                                    <div class="progress-bar" style="width: 90%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Hero Section */
.hero-section {
    background: linear-gradient(135deg, #dc3545 0%, #000000 100%);
    color: white;
    padding: 80px 0;
    position: relative;
    overflow: hidden;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
}

.hero-content {
    position: relative;
    z-index: 2;
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
    line-height: 1.2;
}

.hero-subtitle {
    font-size: 1.25rem;
    margin-bottom: 2rem;
    opacity: 0.9;
    line-height: 1.6;
}

.hero-icon-container {
    position: relative;
    text-align: center;
}

.hero-icon {
    font-size: 8rem;
    opacity: 0.8;
    position: relative;
    z-index: 2;
}

.hero-decoration {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 200px;
    height: 200px;
    background: radial-gradient(circle, rgba(255, 193, 7, 0.2) 0%, transparent 70%);
    border-radius: 50%;
    animation: pulse 3s ease-in-out infinite;
}

/* Cabang Cards */
.cabang-card {
    border-radius: 1.5rem;
    overflow: hidden;
    transition: all 0.4s ease;
    position: relative;
}

.cabang-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(220, 53, 69, 0.2);
}

.card-image-container {
    position: relative;
    height: 220px;
    overflow: hidden;
}

.card-img-top {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.card-img-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #dc3545 0%, #000000 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 3rem;
}

.card-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(220, 53, 69, 0.9) 0%, rgba(0, 0, 0, 0.9) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.4s ease;
}

.cabang-card:hover .card-overlay {
    opacity: 1;
}

.cabang-card:hover .card-img-top {
    transform: scale(1.1);
}

.overlay-content {
    text-align: center;
    color: white;
    transform: translateY(20px);
    transition: transform 0.4s ease;
}

.cabang-card:hover .overlay-content {
    transform: translateY(0);
}

.overlay-content i {
    font-size: 2rem;
    margin-bottom: 0.5rem;
    display: block;
}

.card-body {
    padding: 1.5rem;
}

.card-title {
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: #2c3e50;
}

.card-description {
    color: #6c757d;
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

.info-item {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    margin-bottom: 1rem;
    padding: 0.75rem;
    background: #f8f9fa;
    border-radius: 0.75rem;
    border-left: 4px solid #dc3545;
    transition: all 0.3s ease;
}

.info-item:hover {
    background: #e9ecef;
    transform: translateX(5px);
}

.info-item i {
    font-size: 1.25rem;
    margin-top: 0.25rem;
}

.info-item small {
    display: block;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.card-footer {
    padding: 1.5rem;
    background: #f8f9fa;
    border-top: 1px solid #e9ecef;
}

.btn-modern {
    background: linear-gradient(135deg, #dc3545 0%, #e74c3c 100%);
    border: none;
    border-radius: 0.75rem;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    color: white;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.btn-modern::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.btn-modern:hover::before {
    left: 100%;
}

.btn-modern:hover {
    background: linear-gradient(135deg, #e74c3c 0%, #dc3545 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(220, 53, 69, 0.3);
    color: white;
}

.social-links {
    display: flex;
    gap: 0.5rem;
}

.social-link {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 0.875rem;
}

.social-link.instagram {
    background: linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%);
}

.social-link.facebook {
    background: #1877f2;
}

.social-link.website {
    background: #6c757d;
}

.social-link:hover {
    transform: translateY(-3px) scale(1.1);
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
}

/* Statistics Section */
.stats-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 2rem;
    padding: 3rem 2rem;
    position: relative;
    overflow: hidden;
}

.stats-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="dots" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="rgba(220,53,69,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23dots)"/></svg>');
}

.stats-header {
    text-align: center;
    margin-bottom: 3rem;
    position: relative;
    z-index: 2;
}

.stats-header h4 {
    font-size: 2rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.stats-header p {
    color: #6c757d;
    font-size: 1.1rem;
}

.stat-card {
    background: white;
    border-radius: 1.5rem;
    padding: 2rem;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.4s ease;
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(135deg, #dc3545 0%, #ffc107 100%);
}

.stat-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(220, 53, 69, 0.2);
}

.stat-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2rem;
    color: white;
    position: relative;
}

.stat-icon.building {
    background: linear-gradient(135deg, #dc3545 0%, #e74c3c 100%);
}

.stat-icon.people {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

.stat-icon.agenda {
    background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
}

.stat-icon.news {
    background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);
}

.stat-content h3 {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
    color: #2c3e50;
}

.stat-content p {
    color: #6c757d;
    font-weight: 600;
    margin-bottom: 1rem;
}

.stat-progress {
    height: 4px;
    background: #e9ecef;
    border-radius: 2px;
    overflow: hidden;
}

.progress-bar {
    height: 100%;
    background: linear-gradient(135deg, #dc3545 0%, #ffc107 100%);
    border-radius: 2px;
    transition: width 2s ease;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-icon {
    font-size: 4rem;
    color: #dee2e6;
    margin-bottom: 1.5rem;
}

.empty-state h3 {
    color: #6c757d;
    margin-bottom: 1rem;
}

.empty-state p {
    color: #adb5bd;
}

/* Animations */
@keyframes pulse {
    0%, 100% { transform: translate(-50%, -50%) scale(1); opacity: 0.7; }
    50% { transform: translate(-50%, -50%) scale(1.1); opacity: 0.4; }
}

.fade-in-up {
    animation: fadeInUp 0.8s ease-out;
}

.csp-anim-delay-1s {
    animation-delay: 0.3s;
    animation-fill-mode: both;
}

.csp-anim-delay-2s {
    animation-delay: 0.6s;
    animation-fill-mode: both;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }
    
    .hero-subtitle {
        font-size: 1.1rem;
    }
    
    .stats-section {
        padding: 2rem 1rem;
    }
    
    .stat-card {
        padding: 1.5rem;
    }
    
    .stat-content h3 {
        font-size: 2rem;
    }
}
</style>
<?= $this->endSection() ?>
