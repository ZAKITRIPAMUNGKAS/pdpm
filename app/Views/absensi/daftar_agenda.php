<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4">
        <div>
            <h1 class="h2 mb-0">
                <i class="bi bi-calendar-event me-2 text-danger"></i>
                Agenda Kegiatan
            </h1>
            <p class="text-muted mb-0">Daftar agenda kegiatan yang dapat diikuti</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?= site_url('absensi/riwayat') ?>" class="btn btn-outline-primary">
                    <i class="bi bi-clock-history me-1"></i>
                    Riwayat Absensi
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <?php if (empty($agenda)): ?>
            <!-- Empty State -->
            <div class="col-md-8 mx-auto">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <i class="bi bi-calendar-x text-muted" style="font-size: 4rem;"></i>
                        </div>
                        <h4 class="text-muted mb-3">Belum Ada Agenda</h4>
                        <p class="text-muted mb-4">
                            Saat ini belum ada agenda kegiatan yang tersedia untuk diikuti.
                            <br>Silakan cek kembali nanti.
                        </p>
                        <a href="<?= site_url('dashboard') ?>" class="btn btn-primary">
                            <i class="bi bi-arrow-left me-1"></i>
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <!-- Agenda Cards -->
            <?php foreach ($agenda as $item): ?>
                <div class="col-lg-6 col-xl-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm agenda-card">
                        <!-- Card Header with Status -->
                        <div class="card-header bg-gradient border-0 d-flex justify-content-between align-items-center <?= ($item['tingkat_agenda'] ?? 'daerah') == 'daerah' ? 'bg-danger-gradient' : 'bg-warning-gradient' ?>">
                            <div class="d-flex align-items-center">
                                <?php if (($item['tingkat_agenda'] ?? 'daerah') == 'daerah'): ?>
                                    <i class="bi bi-building text-white me-2"></i>
                                    <span class="text-white fw-semibold">AGENDA DAERAH</span>
                                <?php else: ?>
                                    <i class="bi bi-geo-alt text-dark me-2"></i>
                                    <span class="text-dark fw-semibold">AGENDA CABANG</span>
                                <?php endif; ?>
                            </div>
                            <div class="agenda-status">
                                <?php if ($item['sudah_absen']): ?>
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle me-1"></i>Sudah Absen
                                    </span>
                                <?php elseif ($item['sudah_daftar']): ?>
                                    <span class="badge bg-info">
                                        <i class="bi bi-person-check me-1"></i>Terdaftar
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">
                                        <i class="bi bi-person-plus me-1"></i>Belum Daftar
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body">
                            <h5 class="card-title text-dark mb-3 fw-bold">
                                <?= esc($item['nama_kegiatan']) ?>
                            </h5>
                            
                            <?php if (($item['tingkat_agenda'] ?? 'daerah') == 'cabang' && !empty($item['nama_cabang'])): ?>
                                <div class="mb-3">
                                    <span class="badge bg-info">
                                        <i class="bi bi-geo-alt me-1"></i>
                                        <?= esc($item['nama_cabang']) ?>
                                    </span>
                                    <?php if (!empty($item['wilayah_cabang'])): ?>
                                        <small class="text-muted ms-2"><?= esc($item['wilayah_cabang']) ?></small>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="agenda-details mb-3">
                                <div class="detail-item mb-2">
                                    <i class="bi bi-calendar3 text-danger me-2"></i>
                                    <span class="text-muted">
                                        <?= date('d M Y', strtotime($item['tanggal_mulai'])) ?>
                                        <?php if ($item['tanggal_mulai'] != $item['tanggal_selesai']): ?>
                                            - <?= date('d M Y', strtotime($item['tanggal_selesai'])) ?>
                                        <?php endif; ?>
                                    </span>
                                </div>
                                
                                <?php if (!empty($item['jam_mulai']) && !empty($item['jam_selesai'])): ?>
                                <div class="detail-item mb-2">
                                    <i class="bi bi-clock text-warning me-2"></i>
                                    <span class="text-muted">
                                        <?= date('H:i', strtotime($item['jam_mulai'])) ?> - 
                                        <?= date('H:i', strtotime($item['jam_selesai'])) ?>
                                    </span>
                                </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($item['lokasi'])): ?>
                                <div class="detail-item mb-2">
                                    <i class="bi bi-geo-alt text-info me-2"></i>
                                    <span class="text-muted"><?= esc($item['lokasi']) ?></span>
                                </div>
                                <?php endif; ?>
                                
                                <div class="detail-item">
                                    <i class="bi bi-people text-success me-2"></i>
                                    <span class="text-muted">
                                        <?= $item['jumlah_peserta'] ?> peserta terdaftar
                                    </span>
                                </div>
                            </div>

                            <?php if (!empty($item['deskripsi'])): ?>
                                <div class="agenda-description mb-3">
                                    <p class="text-muted small mb-0">
                                        <?= character_limiter(esc($item['deskripsi']), 100) ?>
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Card Footer -->
                        <div class="card-footer bg-transparent border-0 pt-0">
                            <div class="d-grid gap-2">
                                <a href="<?= site_url('absensi/agenda/' . $item['id']) ?>" 
                                   class="btn btn-primary btn-modern">
                                    <i class="bi bi-eye me-1"></i>
                                    Lihat Detail
                                </a>
                                <?php if (!$item['sudah_daftar'] && !$item['sudah_absen']): ?>
                                    <a href="<?= site_url('absensi/agenda/' . $item['id'] . '/join') ?>" 
                                       class="btn btn-success btn-modern mt-2">
                                        <i class="bi bi-person-plus me-1"></i>
                                        Gabung Sekarang
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<style>
.agenda-card {
    transition: all 0.3s ease;
    border-radius: 1rem;
    overflow: hidden;
}

.agenda-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
}

.agenda-card .card-header.bg-danger-gradient {
    background: linear-gradient(135deg, #dc3545 0%, #000000 100%) !important;
    padding: 1rem 1.25rem;
}

.agenda-card .card-header.bg-warning-gradient {
    background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%) !important;
    padding: 1rem 1.25rem;
}

.agenda-details .detail-item {
    display: flex;
    align-items: center;
    font-size: 0.9rem;
}

.agenda-details .detail-item i {
    width: 20px;
    flex-shrink: 0;
}

.btn-modern {
    background: linear-gradient(135deg, #dc3545 0%, #e74c3c 100%);
    border: none;
    border-radius: 0.75rem;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
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
}

.agenda-status .badge {
    font-size: 0.75rem;
    padding: 0.5rem 0.75rem;
    border-radius: 0.5rem;
}

.agenda-description {
    border-left: 3px solid #dc3545;
    padding-left: 1rem;
    background: rgba(220, 53, 69, 0.05);
    border-radius: 0 0.5rem 0.5rem 0;
    padding: 0.75rem 1rem;
}

@media (max-width: 768px) {
    .agenda-card .card-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .agenda-status {
        align-self: flex-end;
    }
}
</style>
<?= $this->endSection() ?>
