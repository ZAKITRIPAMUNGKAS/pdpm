<?= $this->extend('layout/public_template') ?>

<?= $this->section('content') ?>

<?php
$headerData = [
    'title' => 'Berita Terbaru',
    'subtitle' => 'Informasi terkini dan kegiatan Pimpinan Daerah Pemuda Muhammadiyah Karanganyar',
    'icon' => 'bi-newspaper',
    'stats' => [
        'total_anggota' => $totalAnggota ?? 0,
        'total_cabang' => $totalCabang ?? 0,
        'total_ranting' => $totalRanting ?? 0,
        'total_kokam' => $totalKokam ?? 0
    ]
];
?>
<?= $this->include('layout/page_header', $headerData) ?>

<!-- Main Content -->
<section class="py-5">
    <div class="container">
        <?php if (!empty($berita)): ?>
            <div class="row g-4">
                <?php foreach ($berita as $item): ?>
                    <div class="col-lg-4 col-md-6">
                        <article class="news-card">
                            <div class="news-image-container">
                                <?php if (!empty($item['gambar'])): ?>
                                    <img src="<?= base_url('uploads/berita/' . $item['gambar']) ?>" 
                                         class="news-image" 
                                         alt="<?= esc($item['judul']) ?>">
                                <?php else: ?>
                                    <div class="news-placeholder">
                                        <i class="bi bi-image text-muted csp-icon-2rem"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="news-overlay">
                                    <span class="news-badge">
                                        <i class="bi bi-newspaper me-1"></i>Berita
                                    </span>
                                </div>
                            </div>
                            
                            <div class="news-content">
                                <div class="news-meta">
                                    <div class="meta-item">
                                        <i class="bi bi-person-lines-fill text-primary"></i>
                                        <span><?= esc($item['nama_penulis'] ?? 'Admin') ?></span>
                                    </div>
                                    <div class="meta-item">
                                        <i class="bi bi-calendar-event text-primary"></i>
                                        <span><?= date('d M Y', strtotime($item['created_at'])) ?></span>
                                    </div>
                                </div>
                                
                                <h3 class="news-title">
                                    <a href="<?= site_url('berita/' . $item['slug']) ?>">
                                        <?= esc($item['judul']) ?>
                                    </a>
                                </h3>
                                
                                <p class="news-excerpt">
                                    <?= word_limiter(strip_tags($item['isi'] ?? ''), 20, '') ?>
                                </p>
                                
                                <div class="news-footer">
                                    <a href="<?= site_url('berita/' . $item['slug']) ?>" class="read-more-btn">
                                        <span>Baca Selengkapnya</span>
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="bi bi-newspaper text-muted opacity-50 csp-icon-3rem"></i>
                </div>
                <h3 class="empty-title">Belum Ada Berita</h3>
                <p class="empty-text">Saat ini belum ada berita yang dipublikasikan.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/berita.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- Berita page scripts are now handled in custom.js -->
<?= $this->endSection() ?>
