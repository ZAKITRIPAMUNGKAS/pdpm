<?= $this->extend('layout/public_template') ?>

<?= $this->section('content') ?>
<!-- Hero Section with Background Image -->
<section class="hero-section">
    <div class="hero-background">
        <?php if (!empty($cabang['foto_sekretariat'])): ?>
            <img src="<?= base_url('uploads/cabang/' . $cabang['foto_sekretariat']) ?>" alt="<?= esc($cabang['nama_cabang']) ?>">
        <?php endif; ?>
        <div class="hero-overlay"></div>
    </div>
    <div class="container">
        <div class="hero-content">
            <div class="hero-badge">
                <i class="bi bi-building me-2"></i>
                Profil Cabang
            </div>
            <h1 class="hero-title">
                Cabang <?= esc($cabang['nama_cabang']) ?>
            </h1>
            <p class="hero-description">
                <?= esc($cabang['deskripsi_cabang']) ?>
            </p>
            <div class="hero-actions">
                <a href="<?= base_url('cabang') ?>" class="btn btn-outline-light">
                    <i class="bi bi-arrow-left me-2"></i>
                    Kembali ke Daftar
                </a>
                <?php if (!empty($cabang['website'])): ?>
                    <a href="<?= esc($cabang['website']) ?>" target="_blank" class="btn btn-light">
                        <i class="bi bi-globe me-2"></i>
                        Website Resmi
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="stats-section">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon people">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?= number_format($stats['total_anggota'] ?? 0) ?></h3>
                        <p>Anggota Aktif</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon ranting">
                        <i class="bi bi-geo-alt"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?= number_format($stats['total_ranting'] ?? 0) ?></h3>
                        <p>Ranting</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon kokam">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?= number_format($stats['total_kokam'] ?? 0) ?></h3>
                        <p>Anggota KOKAM</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon building">
                        <i class="bi bi-building"></i>
                    </div>
                    <div class="stat-content">
                        <h3>1</h3>
                        <p>Cabang</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container my-5">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Informasi Cabang -->
            <div class="info-card">
                <div class="card-header">
                    <h2>
                        <i class="bi bi-info-circle me-2"></i>
                        Informasi Cabang
                    </h2>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-icon ketua">
                                    <i class="bi bi-person-badge"></i>
                                </div>
                                <div class="info-content">
                                    <h6>Ketua</h6>
                                    <p><?= esc($cabang['nama_ketua']) ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-icon sekretaris">
                                    <i class="bi bi-person-lines-fill"></i>
                                </div>
                                <div class="info-content">
                                    <h6>Sekretaris</h6>
                                    <p><?= esc($cabang['nama_sekretaris']) ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-icon bendahara">
                                    <i class="bi bi-wallet"></i>
                                </div>
                                <div class="info-content">
                                    <h6>Bendahara</h6>
                                    <p><?= esc($cabang['nama_bendahara']) ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-icon kontak">
                                    <i class="bi bi-telephone-fill"></i>
                                </div>
                                <div class="info-content">
                                    <h6>Kontak</h6>
                                    <p><?= esc($cabang['cp_cabang']) ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="info-item">
                                <div class="info-icon alamat">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                                <div class="info-content">
                                    <h6>Alamat Sekretariat</h6>
                                    <p><?= esc($cabang['alamat_sekretariat']) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Social Media -->
                    <div class="social-section">
                        <h6 class="mb-3">
                            <i class="bi bi-share me-2"></i>
                            Media Sosial
                        </h6>
                        <div class="social-links">
                            <?php if (!empty($cabang['instagram'])): ?>
                                <a href="https://instagram.com/<?= ltrim(esc($cabang['instagram']), '@') ?>" target="_blank" class="social-link instagram">
                                    <i class="bi bi-instagram"></i>
                                    <span>Instagram</span>
                                </a>
                            <?php endif; ?>
                            <?php if (!empty($cabang['facebook'])): ?>
                                <a href="https://facebook.com/<?= esc($cabang['facebook']) ?>" target="_blank" class="social-link facebook">
                                    <i class="bi bi-facebook"></i>
                                    <span>Facebook</span>
                                </a>
                            <?php endif; ?>
                            <?php if (!empty($cabang['twitter'])): ?>
                                <a href="https://twitter.com/<?= esc($cabang['twitter']) ?>" target="_blank" class="social-link twitter">
                                    <i class="bi bi-twitter"></i>
                                    <span>Twitter</span>
                                </a>
                            <?php endif; ?>
                            <?php if (!empty($cabang['website'])): ?>
                                <a href="<?= esc($cabang['website']) ?>" target="_blank" class="social-link website">
                                    <i class="bi bi-globe"></i>
                                    <span>Website</span>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Berita Terkini -->
            <?php if (!empty($berita_cabang)): ?>
                <div class="news-section">
                    <div class="section-header">
                        <h2>
                            <i class="bi bi-newspaper me-2"></i>
                            Berita Terkini
                        </h2>
                        <p>Informasi dan kegiatan terbaru dari cabang <?= esc($cabang['nama_cabang']) ?></p>
                    </div>
                    
                    <div class="row g-4">
                        <?php foreach ($berita_cabang as $berita): ?>
                            <div class="col-md-6">
                                <div class="news-card">
                                    <div class="news-image">
                                        <img src="<?= base_url('uploads/' . $berita['gambar']) ?>" alt="<?= esc($berita['judul']) ?>">
                                        <div class="news-overlay">
                                            <a href="<?= base_url('berita/' . $berita['slug']) ?>" class="btn btn-light btn-sm">
                                                <i class="bi bi-eye me-1"></i>
                                                Baca
                                            </a>
                                        </div>
                                    </div>
                                    <div class="news-content">
                                        <h5><?= esc($berita['judul']) ?></h5>
                                        <p><?= character_limiter(esc($berita['isi']), 100) ?></p>
                                        <div class="news-meta">
                                            <small class="text-muted">
                                                <i class="bi bi-calendar me-1"></i>
                                                <?= date('d M Y', strtotime($berita['created_at'])) ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Daftar Anggota -->
            <?php if (!empty($anggota_cabang)): ?>
                <div class="members-card">
                    <div class="card-header">
                        <h4>
                            <i class="bi bi-people me-2"></i>
                            Daftar Anggota
                        </h4>
                        <p class="mb-0">Anggota aktif cabang <?= esc($cabang['nama_cabang']) ?></p>
                    </div>
                    <div class="card-body">
                        <div class="members-list">
                            <?php foreach ($anggota_cabang as $anggota): ?>
                                <div class="member-item">
                                    <div class="member-avatar">
                                        <?php if (!empty($anggota['foto'])): ?>
                                            <img src="<?= base_url('uploads/profil/' . $anggota['foto']) ?>" alt="<?= esc($anggota['nama_lengkap']) ?>">
                                        <?php else: ?>
                                            <div class="avatar-placeholder">
                                                <i class="bi bi-person"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div class="member-status <?= strtolower($anggota['nama_role']) ?>"></div>
                                    </div>
                                    <div class="member-info">
                                        <h6><?= esc($anggota['nama_lengkap']) ?></h6>
                                        
                                        <?php if (!empty($anggota['jabatan_organisasi'])): ?>
                                            <p class="member-jabatan">
                                                <i class="bi bi-person-badge me-1"></i>
                                                <?php
                                                $jabatan = esc($anggota['jabatan_organisasi']);
                                                // Tambahkan "pimpinan" di depan "harian"
                                                if (stripos($jabatan, 'harian') !== false && stripos($jabatan, 'pimpinan') === false) {
                                                    $jabatan = str_ireplace('harian', 'pimpinan harian', $jabatan);
                                                }
                                                echo $jabatan;
                                                ?>
                                            </p>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($anggota['jabatan_struktural'])): ?>
                                            <p class="member-struktural">
                                                <i class="bi bi-diagram-3 me-1"></i>
                                                <?php
                                                $struktural = esc($anggota['jabatan_struktural']);
                                                // Tambahkan bidang untuk wakil sekretaris
                                                if (stripos($struktural, 'wakil sekretaris') !== false) {
                                                    $struktural .= ' + Bidang';
                                                }
                                                echo $struktural;
                                                ?>
                                            </p>
                                        <?php endif; ?>

                                        <?php
                                        $jabatan_struktural = strtolower($anggota['jabatan_struktural'] ?? '');
                                        $jabatan_organisasi = strtolower($anggota['jabatan_organisasi'] ?? '');
                                        $show_bidang = !empty($anggota['jabatan_bidang']) && (
                                            $jabatan_struktural === 'wakil ketua' ||
                                            $jabatan_struktural === 'wakil sekretaris' ||
                                            $jabatan_organisasi === 'anggota'
                                        );
                                        ?>
                                        <?php if ($show_bidang): ?>
                                            <p class="member-bidang text-muted" style="font-size: 0.8rem; margin-top: 4px;">
                                                <i class="bi bi-briefcase-fill me-1"></i>
                                                <?= esc($anggota['jabatan_bidang']) ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <?php if (count($anggota_cabang) > 10): ?>
                            <div class="text-center mt-3">
                                <button class="btn btn-outline-primary btn-sm" onclick="toggleAllMembers()">
                                    <i class="bi bi-eye me-1"></i>
                                    Lihat Semua Anggota
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
/* Bootstrap Icons Fix */
.bi {
    font-family: "bootstrap-icons" !important;
}

/* Global Image Fix untuk Mobile */
img {
    max-width: 100%;
    height: auto;
    display: block;
}

/* Global Icon Fix - Pastikan semua icon bulat */
.info-icon,
.stat-icon,
.member-avatar img,
.avatar-placeholder {
    border-radius: 50% !important;
    flex-shrink: 0;
}

/* Hero Section */
.hero-section {
    position: relative;
    min-height: 60vh;
    display: flex;
    align-items: center;
    color: white;
    overflow: hidden;
}

.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 1;
}

.hero-background img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(220, 53, 69, 0.9) 0%, rgba(0, 0, 0, 0.8) 100%);
    z-index: 2;
}

.hero-content {
    position: relative;
    z-index: 3;
    text-align: center;
}

.hero-badge {
    display: inline-block;
    background: rgba(255, 255, 255, 0.2);
    padding: 0.5rem 1rem;
    border-radius: 2rem;
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 1rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
    line-height: 1.2;
}

.hero-description {
    font-size: 1.25rem;
    margin-bottom: 2rem;
    opacity: 0.9;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
    line-height: 1.6;
}

.hero-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.hero-actions .btn {
    padding: 0.75rem 2rem;
    font-weight: 600;
    border-radius: 2rem;
    transition: all 0.3s ease;
}

.hero-actions .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
}

/* Statistics Section */
.stats-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 4rem 0;
    margin-top: -2rem;
    position: relative;
    z-index: 4;
}

.stat-card {
    background: white;
    border-radius: 1.5rem;
    padding: 2rem;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
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
    font-family: "bootstrap-icons";
}

.stat-icon i {
    font-family: "bootstrap-icons";
}

.stat-icon.people {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

.stat-icon.ranting {
    background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
}

.stat-icon.kokam {
    background: linear-gradient(135deg, #dc3545 0%, #e74c3c 100%);
}

.stat-icon.building {
    background: linear-gradient(135deg, #6f42c1 0%, #e83e8c 100%);
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
    margin: 0;
}

/* Info Card */
.info-card {
    background: white;
    border-radius: 1.5rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    margin-bottom: 2rem;
}

.info-card .card-header {
    background: linear-gradient(135deg, #dc3545 0%, #000000 100%);
    color: white;
    padding: 2rem;
    border: none;
}

.info-card .card-header h2 {
    margin: 0;
    font-size: 1.75rem;
    font-weight: 700;
}

.info-card .card-body {
    padding: 2rem;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 1rem;
    transition: all 0.3s ease;
    border-left: 4px solid transparent;
}

.info-item:hover {
    background: #e9ecef;
    border-left-color: #dc3545;
    transform: translateX(5px);
}

.info-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
    font-family: "bootstrap-icons";
}

.info-icon i {
    font-family: "bootstrap-icons";
}

.info-icon.ketua {
    background: linear-gradient(135deg, #dc3545 0%, #e74c3c 100%);
}

.info-icon.sekretaris {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

.info-icon.bendahara {
    background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
}

.info-icon.kontak {
    background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);
}

.info-icon.alamat {
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
}

.info-content h6 {
    margin: 0 0 0.5rem 0;
    font-weight: 700;
    color: #2c3e50;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-content p {
    margin: 0;
    color: #495057;
    font-weight: 600;
}

/* Social Section */
.social-section {
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid #e9ecef;
}

.social-links {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.social-link {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: 2rem;
    text-decoration: none;
    color: white;
    font-weight: 600;
    transition: all 0.3s ease;
    font-size: 0.875rem;
}

.social-link i {
    font-family: "bootstrap-icons";
}

.social-link.instagram {
    background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
}

.social-link.facebook {
    background: #1877f2;
}

.social-link.twitter {
    background: #1da1f2;
}

.social-link.website {
    background: #6c757d;
}

.social-link:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    color: white;
}

/* Members Card */
.members-card {
    background: white;
    border-radius: 1.5rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    position: sticky;
    top: 2rem;
}

.members-card .card-header {
    background: linear-gradient(135deg, #dc3545 0%, #000000 100%);
    color: white;
    padding: 1.5rem;
    border: none;
}

.members-card .card-header h4 {
    margin: 0 0 0.5rem 0;
    font-size: 1.25rem;
    font-weight: 700;
}

.members-card .card-body {
    padding: 0;
    max-height: 600px;
    overflow-y: auto;
}

.members-list {
    padding: 1rem;
}

.member-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border-radius: 1rem;
    transition: all 0.3s ease;
    position: relative;
}

.member-item:hover {
    background: #f8f9fa;
    transform: translateX(5px);
}

.member-avatar {
    position: relative;
    flex-shrink: 0;
}

.member-avatar img,
.avatar-placeholder {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
}

.avatar-placeholder {
    background: linear-gradient(135deg, #dc3545 0%, #e74c3c 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
}

.avatar-placeholder i {
    font-family: "bootstrap-icons";
}

.member-status {
    position: absolute;
    bottom: -2px;
    right: -2px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    border: 2px solid white;
}

.member-status.anggota {
    background: #28a745;
}

.member-status.kokam {
    background: #dc3545;
}

.member-info {
    flex: 1;
    min-width: 0;
}

.member-info h6 {
    margin: 0 0 0.25rem 0;
    font-weight: 700;
    color: #2c3e50;
    font-size: 0.95rem;
}

.member-jabatan {
    margin: 0 0 0.25rem 0;
    color: #6c757d;
    font-size: 0.8rem;
    font-weight: 600;
}

.member-struktural {
    margin: 0;
    color: #495057;
    font-size: 0.75rem;
}

/* News Section */
.news-section {
    margin-top: 3rem;
}

.section-header {
    text-align: center;
    margin-bottom: 3rem;
}

.section-header h2 {
    font-size: 2rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.section-header p {
    color: #6c757d;
    font-size: 1.1rem;
}

.news-card {
    background: white;
    border-radius: 1.5rem;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: all 0.4s ease;
}

.news-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(220, 53, 69, 0.2);
}

.news-image {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.news-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.news-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(220, 53, 69, 0.9) 0%, rgba(0, 0, 0, 0.7) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.4s ease;
}

.news-card:hover .news-overlay {
    opacity: 1;
}

.news-card:hover .news-image img {
    transform: scale(1.1);
}

.news-content {
    padding: 1.5rem;
}

.news-content h5 {
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 1rem;
    line-height: 1.4;
}

.news-content p {
    color: #6c757d;
    line-height: 1.6;
    margin-bottom: 1rem;
}

.news-meta {
    padding-top: 1rem;
    border-top: 1px solid #e9ecef;
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }
    
    .hero-description {
        font-size: 1.1rem;
    }
    
    .hero-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .hero-actions .btn {
        width: 100%;
        max-width: 300px;
    }
    
    .stats-section {
        padding: 2rem 0;
    }
    
    .stat-card {
        padding: 1.5rem;
    }
    
    .stat-content h3 {
        font-size: 2rem;
    }
    
    .info-card .card-header,
    .info-card .card-body {
        padding: 1.5rem;
    }
    
    .info-item {
        padding: 1rem;
    }
    
    .social-links {
        justify-content: center;
    }
    
    .members-card {
        position: static;
        margin-top: 2rem;
    }
    
    /* Fix gambar agar tidak oval di mobile */
    .hero-background img {
        object-fit: cover;
        object-position: center;
        min-height: 100%;
        width: 100%;
    }
    
    .news-image {
        height: 180px;
    }
    
    .news-image img {
        object-fit: cover;
        object-position: center;
    }
    
    .member-avatar img {
        object-fit: cover;
        object-position: center;
    }
}

/* Mobile Portrait - lebih kecil */
@media (max-width: 480px) {
    .hero-section {
        min-height: 50vh;
    }
    
    .hero-background img {
        object-fit: cover;
        object-position: center center;
        height: 100%;
        width: 100%;
    }
    
    .news-image {
        height: 160px;
    }
    
    .news-image img {
        object-fit: cover;
        object-position: center center;
    }
    
    .stat-icon {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
        border-radius: 50%;
    }
    
    .info-icon {
        width: 40px;
        height: 40px;
        font-size: 1rem;
        border-radius: 50%;
    }
}

/* Mobile Landscape */
@media (max-width: 768px) and (orientation: landscape) {
    .hero-section {
        min-height: 40vh;
    }
    
    .hero-background img {
        object-fit: cover;
        object-position: center center;
    }
}
</style>

<script>
function toggleAllMembers() {
    const membersList = document.querySelector('.members-list');
    const button = event.target;
    
    if (membersList.style.maxHeight === 'none') {
        membersList.style.maxHeight = '600px';
        button.innerHTML = '<i class="bi bi-eye me-1"></i>Lihat Semua Anggota';
    } else {
        membersList.style.maxHeight = 'none';
        button.innerHTML = '<i class="bi bi-eye-slash me-1"></i>Sembunyikan';
    }
}
</script>
<?= $this->endSection() ?>
