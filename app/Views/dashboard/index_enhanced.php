<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<!-- Header Selamat Datang -->
<div class="dashboard-header">
    <h1 class="dashboard-title">
        <?php if ($dashboard_type === 'super_admin'): ?>
            <i class="bi bi-crown-fill text-warning me-2"></i> Dashboard Super Admin
        <?php elseif ($dashboard_type === 'admin'): ?>
            <i class="bi bi-shield-fill-check text-primary me-2"></i> Dashboard Admin
        <?php else: ?>
            <i class="bi bi-person-fill text-success me-2"></i> Dashboard Anggota
        <?php endif; ?>
    </h1>
    <p class="dashboard-subtitle">Selamat datang kembali, <strong><?= esc($user_name ?? 'User') ?></strong>!</p>
</div>

<!-- ================================================================= -->
<!-- TAMPILAN UNTUK SUPER ADMIN -->
<!-- ================================================================= -->
<?php if ($dashboard_type === 'super_admin'): ?>
    <!-- Kartu Statistik Super Admin -->
    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="stat-card red">
                <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
                <div class="stat-number"><?= number_format($totalAnggota) ?></div>
                <div class="stat-label">Total Anggota</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card yellow">
                <div class="stat-icon"><i class="bi bi-newspaper"></i></div>
                <div class="stat-number"><?= number_format($totalBerita) ?></div>
                <div class="stat-label">Total Berita</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card black">
                <div class="stat-icon"><i class="bi bi-calendar-event"></i></div>
                <div class="stat-number"><?= number_format($totalAgenda) ?></div>
                <div class="stat-label">Total Agenda</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card red">
                <div class="stat-icon"><i class="bi bi-person-check"></i></div>
                <div class="stat-number"><?= number_format($pendingVerifikasi) ?></div>
                <div class="stat-label">Verifikasi Baru</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card yellow">
                <div class="stat-icon"><i class="bi bi-images"></i></div>
                <div class="stat-number"><?= number_format($totalGaleri) ?></div>
                <div class="stat-label">Total Galeri</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card black">
                <div class="stat-icon"><i class="bi bi-building"></i></div>
                <div class="stat-number"><?= number_format($totalCabang) ?></div>
                <div class="stat-label">Total Cabang</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card red">
                <div class="stat-icon"><i class="bi bi-geo-alt"></i></div>
                <div class="stat-number"><?= number_format($totalRanting) ?></div>
                <div class="stat-label">Total Ranting</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card yellow">
                <div class="stat-icon"><i class="bi bi-person-gear"></i></div>
                <div class="stat-number"><?= number_format($totalAdmin) ?></div>
                <div class="stat-label">Total Admin</div>
            </div>
        </div>
    </div>
    
    <!-- Konten Super Admin -->
    <div class="row g-4">
        <div class="col-lg-8">
            <!-- Riwayat Absensi Agenda -->
            <div class="modern-card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header bg-light border-bottom-0">
                    <h5 class="text-dark"><i class="bi bi-calendar-check me-2"></i>Riwayat Absensi Agenda</h5>
                </div>
                <div class="card-body p-3">
                    <?php if(empty($agendaWithAbsensi)): ?>
                        <div class="text-muted text-center py-3">Belum ada agenda dengan data absensi.</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Agenda</th>
                                        <th>Penulis</th>
                                        <th>Tanggal</th>
                                        <th>Peserta</th>
                                        <th>Hadir</th>
                                        <th>Kehadiran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach(array_slice($agendaWithAbsensi, 0, 10) as $agenda): ?>
                                        <tr>
                                            <td>
                                                <div class="fw-bold"><?= esc($agenda['nama_kegiatan']) ?></div>
                                                <small class="text-muted"><?= esc(word_limiter($agenda['deskripsi'] ?? '', 8)) ?></small>
                                            </td>
                                            <td>
                                                <?php 
                                                $badgeClass = 'secondary';
                                                $label = '';
                                                if ($agenda['role_penulis'] == 1): 
                                                    $badgeClass = 'danger';
                                                    $label = 'Pimpinan Daerah';
                                                elseif ($agenda['role_penulis'] == 2): 
                                                    $badgeClass = 'warning';
                                                    $label = 'Pimpinan Cabang';
                                                else:
                                                    $label = 'Admin';
                                                endif;
                                                ?>
                                                <div><?= esc($agenda['nama_penulis']) ?></div>
                                                <span class="badge bg-<?= $badgeClass ?> rounded-pill small"><?= $label ?></span>
                                            </td>
                                            <td>
                                                <div><?= date('d M Y', strtotime($agenda['tanggal_mulai'])) ?></div>
                                                <small class="text-muted"><?= date('H:i', strtotime($agenda['jam_mulai'] ?? '00:00')) ?></small>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary rounded-pill"><?= $agenda['total_peserta'] ?></span>
                                            </td>
                                            <td>
                                                <span class="badge bg-success rounded-pill"><?= $agenda['total_hadir'] ?></span>
                                            </td>
                                            <td>
                                                <?php 
                                                $persentase = (float)$agenda['persentase_kehadiran'];
                                                $progressClass = 'bg-danger';
                                                if ($persentase >= 80) $progressClass = 'bg-success';
                                                elseif ($persentase >= 60) $progressClass = 'bg-warning';
                                                ?>
                                                <div class="d-flex align-items-center">
                                                    <div class="progress me-2" style="width: 60px; height: 8px;">
                                                        <div class="progress-bar <?= $progressClass ?>" 
                                                             style="width: <?= $persentase ?>%"></div>
                                                    </div>
                                                    <small class="text-muted"><?= number_format($persentase, 1) ?>%</small>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <a href="<?= site_url('rekap-absensi') ?>" class="btn btn-outline-primary btn-sm">
                                                <i class="bi bi-eye me-1"></i>Lihat Semua Rekap
                                            </a>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Aktivitas Terbaru -->
            <div class="modern-card shadow-sm border-0 rounded-4">
                <div class="card-header bg-light border-bottom-0">
                    <h5 class="text-dark"><i class="bi bi-graph-up me-2"></i>Aktivitas Terbaru</h5>
                </div>
                <div class="card-body p-3">
                    <?php if(empty($recentAnggota) && empty($recentBerita)): ?>
                        <div class="activity-item text-muted text-center py-3">Belum ada aktivitas terbaru.</div>
                    <?php else: ?>
                        <?php foreach($recentAnggota as $anggota): ?>
                            <div class="activity-item d-flex align-items-center mb-3">
                                <div class="activity-icon red me-3">
                                    <i class="bi bi-person-plus-fill"></i>
                                </div>
                                <div>
                                    <div class="activity-text">Anggota baru <strong><?= esc($anggota['nama_lengkap']) ?></strong> telah bergabung.</div>
                                    <div class="activity-time small text-muted"><?= date('d M', strtotime($anggota['created_at'])) ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <?php foreach($recentBerita as $berita): ?>
                            <div class="activity-item d-flex align-items-center mb-3">
                                <div class="activity-icon yellow me-3">
                                    <i class="bi bi-newspaper"></i>
                                </div>
                                <div>
                                    <div class="activity-text">Berita baru <strong>"<?= esc(word_limiter($berita['judul'], 5)) ?>"</strong> dipublikasikan.</div>
                                    <div class="activity-time small text-muted"><?= date('d M', strtotime($berita['created_at'])) ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="modern-card shadow-sm border-0 rounded-4">
                <div class="card-header bg-light border-bottom-0">
                    <h5 class="text-dark"><i class="bi bi-pie-chart-fill me-2"></i>Anggota per Cabang</h5>
                </div>
                <div class="card-body p-3">
                    <?php if(empty($statistikCabang)): ?>
                        <div class="text-muted text-center">Belum ada data anggota.</div>
                    <?php else: ?>
                        <?php foreach($statistikCabang as $cabang): ?>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span><?= esc($cabang['nama_cabang'] ?? 'Lainnya') ?></span>
                                    <span><?= $cabang['jumlah_anggota'] ?></span>
                                </div>
                                <div class="progress csp-progress-8h">
                                    <div class="progress-bar bg-primary" role="progressbar" data-width="<?= $totalAnggota > 0 ? ($cabang['jumlah_anggota']/$totalAnggota)*100 : 0 ?>"></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- ================================================================= -->
<!-- TAMPILAN UNTUK ADMIN -->
<!-- ================================================================= -->
<?php if ($dashboard_type === 'admin'): ?>
    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="stat-card red">
                <div class="stat-icon"><i class="bi bi-people"></i></div>
                <div class="stat-number"><?= number_format($totalAnggota) ?></div>
                <div class="stat-label">Total Anggota</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card yellow">
                <div class="stat-icon"><i class="bi bi-newspaper"></i></div>
                <div class="stat-number"><?= number_format($totalBerita) ?></div>
                <div class="stat-label">Total Berita</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card black">
                <div class="stat-icon"><i class="bi bi-calendar-event"></i></div>
                <div class="stat-number"><?= number_format($totalAgenda) ?></div>
                <div class="stat-label">Total Agenda</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card red">
                <div class="stat-icon"><i class="bi bi-person-check"></i></div>
                <div class="stat-number"><?= number_format($pendingVerifikasi) ?></div>
                <div class="stat-label">Verifikasi Baru</div>
            </div>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-12">
            <div class="modern-card">
                <div class="card-header"><h5><i class="bi bi-lightning-charge me-2"></i>Aksi Cepat</h5></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-lg-3 col-md-6 d-flex align-items-center">
                            <a href="admin-berita" class="btn btn-block btn-outline-danger action-btn">
                                <div class="d-flex justify-content-center">
                                    <i class="bi bi-plus-circle fa-fw" data-icon-size="2rem"></i>
                                </div>
                                <span class="d-block text-center mt-2">Tambah Berita</span>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 d-flex align-items-center">
                            <a href="admin-agenda" class="btn btn-block btn-outline-warning action-btn">
                                <div class="d-flex justify-content-center">
                                    <i class="bi bi-calendar-plus fa-fw" data-icon-size="2rem"></i>
                                </div>
                                <span class="d-block text-center mt-2">Tambah Agenda</span>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 d-flex align-items-center">
                            <a href="admin-galeri" class="btn btn-block btn-outline-dark action-btn">
                                <div class="d-flex justify-content-center">
                                    <i class="bi bi-images fa-fw" data-icon-size="2rem"></i>
                                </div>
                                <span class="d-block text-center mt-2">Unggah Galeri</span>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 d-flex align-items-center">
                            <a href="verifikasi-anggota" class="btn btn-block btn-outline-danger action-btn">
                                <div class="d-flex justify-content-center">
                                    <i class="bi bi-person-check fa-fw" data-icon-size="2rem"></i>
                                </div>
                                <span class="d-block text-center mt-2">Verifikasi Anggota</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- ================================================================= -->
<!-- TAMPILAN UNTUK ANGGOTA -->
<!-- ================================================================= -->
<?php if ($dashboard_type === 'anggota'): ?>
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card-profile shadow-sm border-0 rounded-4">
                <div class="card-header bg-light border-bottom-0 d-flex justify-content-center">
                    <img src="/uploads/profil/<?= esc($userProfile['foto'] ?? 'default.png') ?>" class="profile-pic mb-3" alt="Foto Profil" data-img-dimensions="100x100" data-csp-style="object-fit: cover; border-radius: 50%;">
                </div>
                <div class="card-body p-4 text-center">
                    <h5 class="mb-1"><?= esc($userProfile['nama_lengkap']) ?></h5>
                    <p class="text-muted mb-2"><?= esc($userProfile['jabatan']) ?></p>
                    <span class="badge bg-<?= $userProfile['status'] === 'Aktif' ? 'success' : 'warning' ?> rounded-pill"><?= esc($userProfile['status']) ?></span>
                    <?php if($userProfile['is_kokam']): ?><span class="badge bg-danger rounded-pill ms-2">KOKAM</span><?php endif; ?>
                    <hr>
                    
                    <div class="progress csp-progress-8h">
                        <div class="progress-bar" role="progressbar" data-width="<?= $profileCompletion ?>"></div>
                    </div>
                    <a href="profil-saya" class="btn btn-primary btn-sm mt-3">Lengkapi Profil</a>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card-agenda shadow-sm border-0 rounded-4">
                <div class="card-header bg-light border-bottom-0">
                    <h5 class="text-dark"><i class="bi bi-calendar-check me-2"></i>Agenda Terdekat</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <?php if(empty($upcomingAgenda)): ?>
                            <li class="list-group-item text-muted text-center">Tidak ada agenda terdekat.</li>
                        <?php else: ?>
                            <?php foreach($upcomingAgenda as $agenda): ?>
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1"><strong><?= esc($agenda['nama_kegiatan']) ?></strong></h6>
                                            <p class="text-muted mb-1"><i class="bi bi-calendar2-week me-1"></i> <?= date('d M Y H:i', strtotime($agenda['tanggal_mulai'])) ?></p>
                                            
                                            <small class="text-break"><?= esc(word_limiter($agenda['deskripsi'] ?? '-', 15)) ?></small>
                                        </div>
                                        <a href="<?= site_url('dashboard/add-to-calendar/' . $agenda['id']) ?>" class="btn btn-sm btn-outline-primary ms-3" title="Tambahkan ke Kalender">
                                            <i class="bi bi-calendar-plus"></i>
                                        </a>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <div class="card-berita shadow-sm border-0 rounded-4 mt-4">
                <div class="card-header bg-light border-bottom-0">
                    <h5 class="text-dark"><i class="bi bi-newspaper me-2"></i>Berita Terbaru</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <?php if(empty($recentBerita)): ?>
                            <li class="list-group-item text-muted text-center">Tidak ada berita terbaru.</li>
                        <?php else: ?>
                            <?php foreach($recentBerita as $berita): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <div class="activity-icon red me-2"><i class="bi bi-newspaper"></i></div>
                                        <div class="activity-text"><?= esc(word_limiter($berita['judul'], 10)) ?></div>
                                    </div>
                                    <a href="/berita/<?= $berita['slug'] ?>" class="btn btn-sm btn-outline-primary">Baca</a>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/dashboard.css') ?>">
<?= $this->endSection() ?>
