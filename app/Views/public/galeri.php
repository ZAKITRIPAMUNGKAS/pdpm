<?= $this->extend('layout/public_template') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/galeri.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$headerData = [
    'title' => 'Galeri Foto',
    'subtitle' => 'Dokumentasi kegiatan dan momen bersejarah Pimpinan Daerah Pemuda Muhammadiyah Karanganyar',
    'icon' => 'bi-images',
    'stats' => [
        'total_anggota' => $totalAnggota ?? 0,
        'total_cabang' => $totalCabang ?? 0,
        'total_ranting' => $totalRanting ?? 0,
        'total_kokam' => $totalKokam ?? 0
    ]
];
?>
<?= $this->include('layout/page_header', $headerData) ?>

<!-- Filter Tabs -->
<section class="py-3 bg-light">
    <div class="container">
        <div class="filter-tabs">
            <ul class="nav nav-pills justify-content-center" id="galleryTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link <?= empty($kategori) ? 'active' : '' ?>" href="<?= site_url('galeri') ?>">
                        <i class="bi bi-grid-3x3-gap me-2"></i>Semua Foto
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link <?= ($kategori == 'kegiatan') ? 'active' : '' ?>" href="<?= site_url('galeri?kategori=kegiatan') ?>">
                        <i class="bi bi-calendar-event me-2"></i>Kegiatan
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link <?= ($kategori == 'rapat') ? 'active' : '' ?>" href="<?= site_url('galeri?kategori=rapat') ?>">
                        <i class="bi bi-people me-2"></i>Rapat
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link <?= ($kategori == 'pelatihan') ? 'active' : '' ?>" href="<?= site_url('galeri?kategori=pelatihan') ?>">
                        <i class="bi bi-mortarboard me-2"></i>Pelatihan
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link <?= ($kategori == 'lainnya') ? 'active' : '' ?>" href="<?= site_url('galeri?kategori=lainnya') ?>">
                        <i class="bi bi-three-dots me-2"></i>Lainnya
                    </a>
                </li>
            </ul>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="py-5">
    <div class="container">
        <?php if (!empty($galeri)): ?>
            <div class="gallery-grid" id="galleryContainer">
                <?php foreach ($galeri as $item): ?>
                    <div class="gallery-item" data-category="<?= strtolower($item['kategori'] ?? 'lainnya') ?>">
                        <div class="gallery-card">
                            <div class="image-container">
                                <?php if (!empty($item['file_path'])): ?>
                                    <img src="<?= base_url('uploads/galeri/' . $item['file_path']) ?>" 
                                         alt="<?= esc($item['judul']) ?>" 
                                         class="gallery-image"
                                         loading="lazy">
                                <?php else: ?>
                                    <div class="image-placeholder">
                                        <i class="bi bi-image text-muted csp-icon-2-25rem"></i>
                                        <p class="mt-3 text-muted">Tidak ada gambar</p>
                                    </div>
                                <?php endif; ?>
                                <div class="image-overlay">
                                    <div class="overlay-content">
                                        <h5 class="image-title"><?= esc($item['judul']) ?></h5>
                                        <?php if (!empty($item['deskripsi'])): ?>
                                            <p class="image-description"><?= esc($item['deskripsi']) ?></p>
                                        <?php endif; ?>
                                        <div class="image-meta">
                                            <span class="category-badge">
                                                <i class="bi bi-tag me-1"></i>
                                                <?= ucfirst($item['kategori'] ?? 'Lainnya') ?>
                                            </span>
                                            <span class="date-badge">
                                                <i class="bi bi-calendar-event me-1"></i>
                                                <?= date('d M Y', strtotime($item['created_at'])) ?>
                                            </span>
                                        </div>
                                    </div>
                                    <?php if (!empty($item['file_path'])): ?>
                                    <div class="overlay-actions">
                                        <button class="action-btn view-btn" onclick="viewImage('<?= base_url('uploads/galeri/' . $item['file_path']) ?>', '<?= esc($item['judul']) ?>')">
                                            <i class="bi bi-zoom-in"></i>
                                        </button>
                                        <button class="action-btn download-btn" onclick="downloadImage('<?= base_url('uploads/galeri/' . $item['file_path']) ?>', '<?= esc($item['judul']) ?>')">
                                            <i class="bi bi-download"></i>
                                        </button>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="bi bi-image text-muted opacity-50 csp-icon-3rem"></i>
                </div>
                <h3 class="empty-title">Belum Ada Foto</h3>
                <p class="empty-text">Saat ini belum ada foto yang tersedia di galeri.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Image Viewer Modal -->
<div class="modal fade" id="imageViewerModal" tabindex="-1" aria-labelledby="imageViewerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title text-white" id="imageViewerModalLabel"></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-0">
                <img id="modalImage" src="" alt="" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<?= $this->endSection() ?>
