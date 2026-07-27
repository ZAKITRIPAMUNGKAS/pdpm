<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-calendar-event me-2"></i>
                        Detail Agenda: <?= esc($agenda['nama_kegiatan']) ?>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card bg-light border-0 h-100">
                                <div class="card-body">
                                    <h6 class="text-primary mb-3">
                                        <i class="bi bi-info-circle me-2"></i>
                                        Informasi Kegiatan
                                    </h6>
                                    
                                    <div class="row mb-3">
                                        <div class="col-sm-4">
                                            <strong><i class="bi bi-calendar2-event text-primary me-2"></i>Nama Kegiatan:</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            <?= esc($agenda['nama_kegiatan']) ?>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-sm-4">
                                            <strong><i class="bi bi-calendar-date text-info me-2"></i>Tanggal:</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            <?= date('d F Y', strtotime($agenda['tanggal_mulai'])) ?>
                                            <?php if ($agenda['tanggal_mulai'] != $agenda['tanggal_selesai']): ?>
                                                - <?= date('d F Y', strtotime($agenda['tanggal_selesai'])) ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-sm-4">
                                            <strong><i class="bi bi-clock text-warning me-2"></i>Waktu:</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            <?= date('H:i', strtotime($agenda['jam_mulai'])) ?> - 
                                            <?= date('H:i', strtotime($agenda['jam_selesai'])) ?> WIB
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-sm-4">
                                            <strong><i class="bi bi-geo-alt text-danger me-2"></i>Lokasi:</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            <?= esc($agenda['lokasi']) ?>
                                        </div>
                                    </div>
                                    
                                    <?php if (!empty($agenda['deskripsi'])): ?>
                                    <div class="row mb-3">
                                        <div class="col-sm-4">
                                            <strong><i class="bi bi-file-text text-secondary me-2"></i>Deskripsi:</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            <?= nl2br(esc($agenda['deskripsi'])) ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <div class="row mb-3">
                                        <div class="col-sm-4">
                                            <strong><i class="bi bi-people text-success me-2"></i>Peserta Terdaftar:</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            <span class="badge bg-success fs-6"><?= $jumlah_peserta ?> orang</span>
                                        </div>
                                    </div>

                                    <?php if (!empty($agenda['radius_meter'])): ?>
                                    <div class="row mb-3">
                                        <div class="col-sm-4">
                                            <strong><i class="bi bi-bullseye text-warning me-2"></i>Radius Absensi:</strong>
                                        </div>
                                        <div class="col-sm-8">
                                            <?= $agenda['radius_meter'] ?> meter
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card border-primary h-100">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="card-title mb-0">
                                        <i class="bi bi-person-check me-2"></i>
                                        Status Keikutsertaan
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <?php if ($sudah_absen): ?>
                                        <div class="alert alert-success border-0">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="bi bi-check-circle me-2"></i>
                                                <strong>Sudah Absen</strong>
                                            </div>
                                            <small>
                                                Status: <span class="badge bg-success"><?= $status_absen ?></span><br>
                                                Waktu: <?= $waktu_absen ?>
                                            </small>
                                        </div>
                                    <?php elseif ($sudah_daftar): ?>
                                        <?php if ($bisa_absen): ?>
                                            <div class="alert alert-info border-0">
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-info-circle me-2"></i>
                                                    <span>Anda sudah terdaftar. Silakan lakukan absensi.</span>
                                                </div>
                                            </div>
                                            <div class="d-grid">
                                                <a href="<?= site_url('absensi/hadir/' . $agenda['id']) ?>"
                                                   class="btn btn-success">
                                                    <i class="bi bi-geo-alt me-1"></i>
                                                    Absensi GPS
                                                </a>
                                            </div>
                                        <?php else: ?>
                                            <div class="alert alert-warning border-0">
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-clock me-2"></i>
                                                    <span>Anda sudah terdaftar</span>
                                                </div>
                                            </div>
                                            <?php if (!empty($pesan_waktu)): ?>
                                                <div class="alert alert-info border-0">
                                                    <small><i class="bi bi-info-circle me-1"></i><?= $pesan_waktu ?></small>
                                                </div>
                                            <?php endif; ?>
                                            <div class="d-grid gap-2">
                                                <form method="post" action="<?= site_url('absensi/batal/' . $agenda['id']) ?>">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="btn btn-outline-danger w-100"
                                                            onclick="return confirm('Yakin ingin membatalkan pendaftaran?')">
                                                        <i class="bi bi-x-circle me-1"></i>
                                                        Batalkan Pendaftaran
                                                    </button>
                                                </form>
                                            </div>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <div class="alert alert-warning border-0">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-exclamation-triangle me-2"></i>
                                                <span>Anda belum terdaftar di agenda ini</span>
                                            </div>
                                        </div>
                                        <div class="d-grid">
                                            <form method="post" action="<?= site_url('absensi/daftar/' . $agenda['id']) ?>">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-primary w-100">
                                                    <i class="bi bi-person-plus me-1"></i>
                                                    Daftar Kegiatan
                                                </button>
                                            </form>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($sudah_daftar && !empty($peserta_list)): ?>
                                        <div class="mt-4">
                                            <h6 class="text-primary mb-3">
                                                <i class="bi bi-people me-2"></i>
                                                Daftar Peserta
                                            </h6>
                                            <div class="list-group list-group-flush" style="max-height: 300px; overflow-y: auto;">
                                                <?php foreach ($peserta_list as $peserta): ?>
                                                    <div class="list-group-item border-0 px-0 py-2">
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                                                <i class="bi bi-person"></i>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <h6 class="mb-0 small"><?= esc($peserta['nama_lengkap']) ?></h6>
                                                                <small class="text-muted"><?= date('d/m/Y H:i', strtotime($peserta['tanggal_daftar'])) ?></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <a href="<?= site_url('absensi/agenda') ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i>
                            Kembali ke Daftar Agenda
                        </a>
                        
                        <?php if (!empty($agenda['latitude']) && !empty($agenda['longitude'])): ?>
                            <a href="https://www.google.com/maps/search/?api=1&query=<?= $agenda['latitude'] ?>,<?= $agenda['longitude'] ?>" 
                               target="_blank" class="btn btn-outline-info ms-2">
                                <i class="bi bi-map me-1"></i>
                                Lihat di Maps
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 10px;
}

.card-header {
    border-radius: 10px 10px 0 0 !important;
}

.alert {
    border-radius: 8px;
}

.btn {
    border-radius: 6px;
}

.avatar-sm {
    width: 32px;
    height: 32px;
    font-size: 14px;
}

.list-group-item {
    background-color: transparent;
}

.list-group-item:hover {
    background-color: rgba(0, 123, 255, 0.1);
    border-radius: 6px;
}

.badge {
    font-size: 0.875em;
}

.row.mb-3 {
    border-bottom: 1px solid #f8f9fa;
    padding-bottom: 0.75rem;
}

.row.mb-3:last-child {
    border-bottom: none;
}

@media (max-width: 768px) {
    .row.mb-3 .col-sm-4 {
        margin-bottom: 0.5rem;
    }
}
</style>

<?php if (session()->getFlashdata('success')): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const toast = document.createElement('div');
    toast.className = 'toast align-items-center text-white bg-success border-0 position-fixed top-0 end-0 m-3';
    toast.style.zIndex = '9999';
    toast.setAttribute('role', 'alert');
    toast.innerHTML = '<div class="d-flex"><div class="toast-body"><i class="bi bi-check-circle me-2"></i><?= addslashes(session()->getFlashdata('success')) ?></div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div>';
    document.body.appendChild(toast);
    
    const bsToast = new bootstrap.Toast(toast);
    bsToast.show();
    
    setTimeout(function() {
        toast.remove();
    }, 5000);
});
</script>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const toast = document.createElement('div');
    toast.className = 'toast align-items-center text-white bg-danger border-0 position-fixed top-0 end-0 m-3';
    toast.style.zIndex = '9999';
    toast.setAttribute('role', 'alert');
    toast.innerHTML = '<div class="d-flex"><div class="toast-body"><i class="bi bi-exclamation-triangle me-2"></i><?= addslashes(session()->getFlashdata('error')) ?></div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div>';
    document.body.appendChild(toast);
    
    const bsToast = new bootstrap.Toast(toast);
    bsToast.show();
    
    setTimeout(function() {
        toast.remove();
    }, 5000);
});
</script>
<?php endif; ?>

<?= $this->endSection() ?>
