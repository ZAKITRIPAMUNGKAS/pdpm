<?= $this->extend('layout/template') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/dashboard-enhanced.css') ?>">
<link rel="stylesheet" href="<?= base_url('css/dashboard-member-unified.css') ?>">
<link rel="stylesheet" href="<?= base_url('css/dashboard-header-fix.css') ?>">
<link rel="stylesheet" href="<?= base_url('css/statistics-enhanced.css') ?>">
<link rel="stylesheet" href="<?= base_url('css/kader-stats.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="dashboard-container">
    <!-- Enhanced Dashboard Header -->
    <div class="dashboard-header">
        <h1 class="dashboard-title">
            <?php if ($dashboard_type === 'super_admin'): ?>
                <i class="bi bi-crown-fill text-warning"></i> Dashboard Super Admin
            <?php elseif ($dashboard_type === 'admin'): ?>
                <i class="bi bi-shield-fill-check text-primary"></i> Dashboard Admin
            <?php else: ?>
                <i class="bi bi-person-fill text-success"></i> Dashboard Anggota
            <?php endif; ?>
        </h1>
        <p class="dashboard-subtitle">Selamat datang kembali, <strong><?= esc($user_name ?? 'User') ?></strong>!</p>
    </div>

    <!-- ================================================================= -->
    <!-- TAMPILAN UNTUK SUPER ADMIN -->
    <!-- ================================================================= -->
    <?php if ($dashboard_type === 'super_admin'): ?>
        <!-- Enhanced Statistics Cards for Super Admin -->
        <div class="row g-2 g-md-3 mb-4">
            <div class="col-6 col-md-4 col-xl-3">
                <div class="stat-card red">
                    <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
                    <div class="stat-number"><?= number_format($totalAnggota) ?></div>
                    <div class="stat-label">Total Anggota</div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl-3">
                <div class="stat-card yellow">
                    <div class="stat-icon"><i class="bi bi-newspaper"></i></div>
                    <div class="stat-number"><?= number_format($totalBerita) ?></div>
                    <div class="stat-label">Total Berita</div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl-3">
                <div class="stat-card black">
                    <div class="stat-icon"><i class="bi bi-calendar-event"></i></div>
                    <div class="stat-number"><?= number_format($totalAgenda) ?></div>
                    <div class="stat-label">Total Agenda</div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl-3">
                <div class="stat-card red">
                    <div class="stat-icon"><i class="bi bi-person-check"></i></div>
                    <div class="stat-number"><?= number_format($pendingVerifikasi) ?></div>
                    <div class="stat-label">Verifikasi Baru</div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl-3">
                <div class="stat-card yellow">
                    <div class="stat-icon"><i class="bi bi-images"></i></div>
                    <div class="stat-number"><?= number_format($totalGaleri) ?></div>
                    <div class="stat-label">Total Galeri</div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl-3">
                <div class="stat-card black">
                    <div class="stat-icon"><i class="bi bi-building"></i></div>
                    <div class="stat-number"><?= number_format($totalCabang) ?></div>
                    <div class="stat-label">Total Cabang</div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl-3">
                <div class="stat-card red">
                    <div class="stat-icon"><i class="bi bi-geo-alt"></i></div>
                    <div class="stat-number"><?= number_format($totalRanting) ?></div>
                    <div class="stat-label">Total Ranting</div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl-3">
                <div class="stat-card yellow">
                    <div class="stat-icon"><i class="bi bi-person-gear"></i></div>
                    <div class="stat-number"><?= number_format($totalAdmin) ?></div>
                    <div class="stat-label">Total Admin</div>
                </div>
            </div>
        </div>
    
        
        <!-- Enhanced Content Layout for Super Admin -->
        <div class="row g-4">
            <div class="col-lg-8">
                <!-- Enhanced Attendance History Card -->
                <div class="modern-card mb-4">
                    <div class="card-header">
                        <h5><i class="bi bi-calendar-check"></i>Riwayat Absensi Agenda</h5>
                    </div>
                    <div class="card-body">
                    <?php if(empty($agendaWithAbsensi)): ?>
                            <div class="empty-state">
                                <i class="bi bi-calendar-x"></i>
                                <p>Belum ada agenda dengan data absensi</p>
                                <small>Data akan muncul setelah ada agenda dengan absensi</small>
                            </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th data-label="Agenda">Agenda</th>
                                        <th data-label="Penulis">Penulis</th>
                                        <th data-label="Tanggal">Tanggal</th>
                                        <th data-label="Peserta">Peserta</th>
                                        <th data-label="Hadir">Hadir</th>
                                        <th data-label="Kehadiran">Kehadiran</th>
                                    </tr>
                                </thead>
                                    <tbody>
                                        <?php foreach(array_slice($agendaWithAbsensi, 0, 10) as $agenda): ?>
                                            <tr>
                                                <td data-label="Agenda">
                                                    <div class="fw-bold"><?= esc($agenda['nama_kegiatan']) ?></div>
                                                    <small class="text-muted"><?= esc(word_limiter($agenda['deskripsi'] ?? '', 8)) ?></small>
                                                </td>
                                                <td data-label="Penulis">
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
                                                <td data-label="Tanggal">
                                                    <div><?= date('d M Y', strtotime($agenda['tanggal_mulai'])) ?></div>
                                                    <small class="text-muted"><?= date('H:i', strtotime($agenda['jam_mulai'] ?? '00:00')) ?></small>
                                                </td>
                                                <td data-label="Peserta">
                                                    <span class="badge bg-primary rounded-pill"><?= $agenda['total_peserta'] ?></span>
                                                </td>
                                                <td data-label="Hadir">
                                                    <span class="badge bg-success rounded-pill"><?= $agenda['total_hadir'] ?></span>
                                                </td>
                                                <td data-label="Kehadiran">
                                                    <?php 
                                                    $persentase = (float)$agenda['persentase_kehadiran'];
                                                    $progressClass = 'bg-danger';
                                                    if ($persentase >= 80) $progressClass = 'bg-success';
                                                    elseif ($persentase >= 60) $progressClass = 'bg-warning';
                                                    ?>
                                                    <div class="d-flex align-items-center">
                                                        <div class="progress">
                                                            <div class="progress-bar <?= $progressClass ?>" 
                                                                 data-width="<?= $persentase ?>%"></div>
                                                        </div>
                                                        <small class="text-muted ms-2"><?= number_format($persentase, 1) ?>%</small>
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
                
                <!-- Enhanced Recent Activities Card -->
                <div class="modern-card">
                    <div class="card-header">
                        <h5><i class="bi bi-graph-up"></i>Aktivitas Terbaru</h5>
                    </div>
                    <div class="card-body">
                        <?php if(empty($recentAnggota) && empty($recentBerita)): ?>
                            <div class="empty-state">
                                <i class="bi bi-activity"></i>
                                <p>Belum ada aktivitas terbaru</p>
                                <small>Aktivitas akan muncul di sini</small>
                            </div>
                        <?php else: ?>
                            <div class="activity-list">
                                <?php foreach($recentAnggota as $anggota): ?>
                                    <div class="activity-item d-flex align-items-center">
                                        <div class="activity-icon red me-3">
                                            <i class="bi bi-person-plus-fill"></i>
                                        </div>
                                        <div class="activity-content">
                                            <div class="activity-text">Anggota baru <strong><?= esc($anggota['nama_lengkap']) ?></strong> telah bergabung</div>
                                            <div class="activity-time"><?= date('d M Y', strtotime($anggota['created_at'])) ?></div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <?php foreach($recentBerita as $berita): ?>
                                    <div class="activity-item d-flex align-items-center">
                                        <div class="activity-icon yellow me-3">
                                            <i class="bi bi-newspaper"></i>
                                        </div>
                                        <div class="activity-content">
                                            <div class="activity-text">Berita baru <strong>"<?= esc(word_limiter($berita['judul'] ?? 'Berita', 5)) ?>"</strong> dipublikasikan</div>
                                            <div class="activity-time"><?= date('d M Y', strtotime($berita['created_at'])) ?></div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
        </div>

        <!-- ================================================================= -->
        <!-- STATISTIK PERSEBARAN KADER - Full Width Grid Section              -->
        <!-- ================================================================= -->
        <?php if(!empty($statistikCabang)): ?>
        <?php
        $validCabang    = array_values(array_filter($statistikCabang, function($c) { return !empty($c['nama_cabang']); }));
        $totalCabangAkt = count($validCabang);
        $maxAnggota     = $totalCabangAkt > 0 ? max(array_column($validCabang, 'jumlah_anggota')) : 1;
        $rataRata       = $totalCabangAkt > 0 ? round($totalAnggota / $totalCabangAkt, 1) : 0;
        $colors8        = ['#dc3545','#ffc107','#198754','#0dcaf0','#6f42c1','#fd7e14','#20c997','#e83e8c'];
        usort($validCabang, fn($a,$b) => $b['jumlah_anggota'] - $a['jumlah_anggota']);
        ?>
        <div class="kader-stats-section mt-4">
            <!-- Section Header -->
            <div class="kader-stats-header">
                <div class="kader-stats-title-wrap">
                    <div class="kader-stats-icon">
                        <i class="bi bi-diagram-3-fill"></i>
                    </div>
                    <div>
                        <h5 class="kader-stats-title">Statistik Persebaran Kader</h5>
                        <p class="kader-stats-subtitle">Data persebaran anggota Pemuda Muhammadiyah di seluruh Karanganyar</p>
                    </div>
                </div>
                <div class="kader-stats-controls">
                    <!-- Search -->
                    <div class="kader-search-wrap">
                        <i class="bi bi-search kader-search-icon"></i>
                        <input type="text" id="kaderSearchInput" class="kader-search-input" placeholder="Cari cabang...">
                    </div>
                    <!-- Sort -->
                    <select id="kaderSortSelect" class="kader-sort-select">
                        <option value="desc">Terbanyak</option>
                        <option value="asc">Tersedikit</option>
                        <option value="name">A–Z</option>
                    </select>
                    <!-- View Toggle -->
                    <div class="kader-view-toggle">
                        <button class="kader-view-btn active" id="btnGridView" title="Tampilan Grid" onclick="setKaderView('grid')">
                            <i class="bi bi-grid-3x3-gap-fill"></i>
                        </button>
                        <button class="kader-view-btn" id="btnListView" title="Tampilan List" onclick="setKaderView('list')">
                            <i class="bi bi-list-ul"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Summary Bar -->
            <div class="kader-summary-bar">
                <div class="kader-summary-item">
                    <i class="bi bi-building-fill"></i>
                    <span class="kader-summary-val"><?= $totalCabangAkt ?></span>
                    <span class="kader-summary-lbl">Cabang Aktif</span>
                </div>
                <div class="kader-summary-divider"></div>
                <div class="kader-summary-item">
                    <i class="bi bi-people-fill"></i>
                    <span class="kader-summary-val"><?= number_format($totalAnggota) ?></span>
                    <span class="kader-summary-lbl">Total Anggota</span>
                </div>
                <div class="kader-summary-divider"></div>
                <div class="kader-summary-item">
                    <i class="bi bi-bar-chart-fill"></i>
                    <span class="kader-summary-val"><?= $rataRata ?></span>
                    <span class="kader-summary-lbl">Rata-rata / Cabang</span>
                </div>
                <div class="kader-summary-divider"></div>
                <div class="kader-summary-item">
                    <i class="bi bi-trophy-fill text-warning"></i>
                    <span class="kader-summary-val kader-top-name"><?= esc(mb_strimwidth($validCabang[0]['nama_cabang'] ?? '-', 0, 20, '…')) ?></span>
                    <span class="kader-summary-lbl">Cabang Terbanyak</span>
                </div>
            </div>

            <!-- Cards Grid -->
            <div class="kader-grid" id="kaderGrid">
                <?php foreach($validCabang as $idx => $cabang): ?>
                <?php
                $pct      = $totalAnggota > 0 ? round(($cabang['jumlah_anggota'] / $totalAnggota) * 100, 1) : 0;
                $barPct   = $maxAnggota > 0 ? round(($cabang['jumlah_anggota'] / $maxAnggota) * 100, 1) : 0;
                $clr      = $colors8[$idx % count($colors8)];
                $rank     = $idx + 1;
                $rankCls  = $rank === 1 ? 'rank-gold' : ($rank === 2 ? 'rank-silver' : ($rank === 3 ? 'rank-bronze' : ''));
                $rankIcon = $rank === 1 ? '🥇' : ($rank === 2 ? '🥈' : ($rank === 3 ? '🥉' : '#'.$rank));
                ?>
                <div class="kader-card" 
                     data-name="<?= strtolower(esc($cabang['nama_cabang'])) ?>" 
                     data-count="<?= $cabang['jumlah_anggota'] ?>"
                     data-rank="<?= $rank ?>">
                    <!-- Color accent top -->
                    <div class="kader-card-accent" style="background: <?= $clr ?>;"></div>
                    
                    <!-- Rank badge -->
                    <div class="kader-rank <?= $rankCls ?>">
                        <span><?= $rankIcon ?></span>
                    </div>

                    <!-- Card body -->
                    <div class="kader-card-body">
                        <!-- Radial indicator -->
                        <div class="kader-radial-wrap">
                            <svg class="kader-radial-svg" viewBox="0 0 44 44">
                                <circle cx="22" cy="22" r="18" fill="none" stroke="#f0f0f0" stroke-width="4"/>
                                <circle cx="22" cy="22" r="18" fill="none" stroke="<?= $clr ?>" stroke-width="4"
                                        stroke-dasharray="<?= round($barPct * 1.131) ?> 113.1"
                                        stroke-linecap="round"
                                        transform="rotate(-90 22 22)"/>
                            </svg>
                            <div class="kader-radial-val"><?= $pct ?>%</div>
                        </div>

                        <!-- Info -->
                        <div class="kader-card-info">
                            <div class="kader-card-name"><?= esc($cabang['nama_cabang']) ?></div>
                            <div class="kader-card-count" style="color: <?= $clr ?>;"><?= number_format($cabang['jumlah_anggota']) ?></div>
                            <div class="kader-card-sub">anggota</div>
                        </div>
                    </div>

                    <!-- Bar -->
                    <div class="kader-bar-wrap">
                        <div class="kader-bar-track">
                            <div class="kader-bar-fill" style="width: <?= $barPct ?>%; background: <?= $clr ?>;"></div>
                        </div>
                        <span class="kader-bar-label"><?= $cabang['jumlah_anggota'] ?> / <?= $totalAnggota ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Empty result on search -->
            <div class="kader-no-result d-none" id="kaderNoResult">
                <i class="bi bi-search"></i>
                <p>Cabang tidak ditemukan</p>
                <small>Coba kata kunci lain</small>
            </div>

            <!-- Showing count -->
            <div class="kader-count-info mt-2" id="kaderCountInfo">
                Menampilkan <strong id="kaderShownCount"><?= $totalCabangAkt ?></strong> dari <?= $totalCabangAkt ?> cabang
            </div>
        </div>
        <?php endif; ?>


    <?php endif; ?>

    <!-- ================================================================= -->
    <!-- TAMPILAN UNTUK ADMIN -->
    <!-- ================================================================= -->
    <?php if ($dashboard_type === 'admin'): ?>
        <!-- Enhanced Statistics Cards for Admin -->
        <div class="row g-2 g-md-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="stat-card red">
                    <div class="stat-icon"><i class="bi bi-people"></i></div>
                    <div class="stat-number"><?= number_format($totalAnggota) ?></div>
                    <div class="stat-label">Total Anggota</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card yellow">
                    <div class="stat-icon"><i class="bi bi-newspaper"></i></div>
                    <div class="stat-number"><?= number_format($totalBerita) ?></div>
                    <div class="stat-label">Total Berita</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card black">
                    <div class="stat-icon"><i class="bi bi-calendar-event"></i></div>
                    <div class="stat-number"><?= number_format($totalAgenda) ?></div>
                    <div class="stat-label">Total Agenda</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card red">
                    <div class="stat-icon"><i class="bi bi-person-check"></i></div>
                    <div class="stat-number"><?= number_format($pendingVerifikasi) ?></div>
                    <div class="stat-label">Verifikasi Baru</div>
                </div>
            </div>
        </div>
        
        <!-- Enhanced Quick Actions for Admin -->
        <div class="row g-4">
            <div class="col-12">
                <div class="modern-card">
                    <div class="card-header">
                        <h5><i class="bi bi-lightning-charge"></i>Aksi Cepat</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-lg-3 col-md-6">
                                <a href="admin-berita" class="action-btn btn-outline-danger w-100">
                                    <i class="bi bi-plus-circle"></i>
                                    <span>Tambah Berita</span>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <a href="admin-agenda" class="action-btn btn-outline-warning w-100">
                                    <i class="bi bi-calendar-plus"></i>
                                    <span>Tambah Agenda</span>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <a href="admin-galeri" class="action-btn btn-outline-dark w-100">
                                    <i class="bi bi-images"></i>
                                    <span>Unggah Galeri</span>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <a href="verifikasi-anggota" class="action-btn btn-outline-danger w-100">
                                    <i class="bi bi-person-check"></i>
                                    <span>Verifikasi Anggota</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- ================================================================= -->
    <!-- TAMPILAN UNTUK ANGGOTA - UNIFIED LAYOUT -->
    <!-- ================================================================= -->
    <?php if ($dashboard_type === 'anggota'): ?>
        <div class="member-dashboard-unified">
            <!-- Top Stats Section -->
            <div class="row g-4 mb-4">
                <!-- Profile Overview Card -->
                <div class="col-lg-4 col-md-6">
                    <div class="stat-card-member">
                        <div class="stat-card-header">
                            <img src="/uploads/profil/<?= esc($userProfile['foto'] ?? 'default.png') ?>" 
                                 class="profile-pic-small" 
                                 alt="Foto Profil">
                            <div class="profile-info">
                                <h6 class="mb-1"><?= esc($userProfile['nama_lengkap'] ?? 'Nama Pengguna') ?></h6>
                                <p class="text-muted mb-0 small"><?= esc($userProfile['jabatan'] ?? 'Jabatan') ?></p>
                                <div class="badges-container mt-1">
                                    <span class="badge bg-<?= ($userProfile['status'] ?? 'Tidak Aktif') === 'Aktif' ? 'success' : 'warning' ?> rounded-pill"><?= esc($userProfile['status'] ?? 'Tidak Aktif') ?></span>
                                    <?php if($userProfile['is_kokam'] ?? false): ?>
                                        <span class="badge bg-danger rounded-pill ms-1">KOKAM</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="stat-card-body">
                            <div class="progress-label text-primary fw-semibold">
                                <i class="bi bi-person-check me-1"></i>Kelengkapan Profil: 
                                <span class="text-gradient"><?= $profileCompletion ?>%</span>
                            </div>
                            
                            <div class="progress">
                                <div class="progress-bar progress-animated" data-width="<?= $profileCompletion ?>%"></div>
                            </div>
                            <a href="profil-saya" class="btn btn-primary btn-sm w-100 mt-3">
                                <i class="bi bi-person-gear me-1"></i>Lengkapi Profil
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Points & Level Card -->
                <div class="col-lg-4 col-md-6">
                    <div class="stat-card-member">
                        <div class="stat-card-icon bg-gradient-primary">
                            <i class="bi bi-trophy-fill"></i>
                        </div>
                        <div class="stat-card-content">
                            <div class="level-badge bg-<?= $progressData['level_sekarang']['badge'] ?? 'secondary' ?> mb-2">
                                <i class="bi bi-<?= $progressData['level_sekarang']['icon'] ?? 'person' ?> me-1"></i>
                                <?= esc($progressData['level_sekarang']['nama'] ?? 'Anggota Baru') ?>
                            </div>
                            <div class="points-display">
                                <div class="points-number"><?= number_format($userPoints ?? 0) ?></div>
                                <small class="text-muted">Total Poin</small>
                            </div>
                            <?php if (isset($progressData['level_berikutnya']) && $progressData['level_berikutnya']): ?>
                                <div class="progress mt-3">
                                    <div class="progress-bar bg-primary progress-animated" 
                                         style="width: <?= $progressData['progress_persen'] ?>%"></div>
                                </div>
                                <small class="text-muted d-block mt-1">
                                    Butuh <span class="fw-semibold text-primary"><?= $progressData['poin_dibutuhkan'] ?></span> poin lagi
                                </small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Attendance Stats Card -->
                <div class="col-lg-4 col-md-12">
                    <div class="stat-card-member">
                        <div class="stat-card-icon bg-gradient-success">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <div class="stat-card-content">
                            <h6 class="mb-3">Statistik Kehadiran</h6>
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="stat-mini">
                                        <div class="stat-number text-success"><?= $attendanceStats['total_kehadiran'] ?? 0 ?></div>
                                        <small class="text-muted">Hadir</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-mini">
                                        <div class="stat-number text-primary"><?= $attendanceStats['total_terdaftar'] ?? 0 ?></div>
                                        <small class="text-muted">Terdaftar</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-mini">
                                        <div class="stat-number text-warning"><?= $attendanceStats['persentase'] ?? 0 ?>%</div>
                                        <small class="text-muted">Tingkat</small>
                                    </div>
                                </div>
                            </div>
                            <div class="progress mt-3">
                                <div class="progress-bar bg-success progress-animated" 
                                     style="width: <?= $attendanceStats['persentase'] ?? 0 ?>%"></div>
                            </div>
                            <a href="<?= site_url('absensi/riwayat') ?>" class="btn btn-outline-success btn-sm w-100 mt-3">
                                <i class="bi bi-clock-history me-1"></i>Lihat Riwayat
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Section -->
            <div class="row g-4 mb-4">
                <div class="col-12">
                    <div class="modern-card">
                        <div class="card-header">
                            <h5><i class="bi bi-lightning-charge"></i>Aksi Cepat</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-lg-3 col-md-6">
                                    <a href="<?= site_url('absensi/agenda') ?>" class="action-btn btn-outline-primary w-100">
                                        <i class="bi bi-calendar-event"></i>
                                        <span>Lihat Agenda</span>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <a href="<?= site_url('absensi/riwayat') ?>" class="action-btn btn-outline-success w-100">
                                        <i class="bi bi-clock-history"></i>
                                        <span>Riwayat Absensi</span>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <a href="<?= site_url('profil-saya') ?>" class="action-btn btn-outline-warning w-100">
                                        <i class="bi bi-person-gear"></i>
                                        <span>Edit Profil</span>
                                    </a>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <a href="<?= site_url('berita') ?>" class="action-btn btn-outline-info w-100">
                                        <i class="bi bi-newspaper"></i>
                                        <span>Baca Berita</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="row g-4">
                <!-- Agenda & Activities Section -->
                <div class="col-lg-8">
                    <!-- Upcoming Agenda Card -->
                    <div class="modern-card mb-4">
                        <div class="card-header">
                            <h5><i class="bi bi-calendar-check"></i>Agenda Terdekat</h5>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                <?php if(empty($upcomingAgenda)): ?>
                                    <li class="list-group-item">
                                        <div class="empty-state">
                                            <i class="bi bi-calendar-x"></i>
                                            <p>Tidak ada agenda terdekat</p>
                                            <small>Agenda akan muncul di sini</small>
                                        </div>
                                    </li>
                                <?php else: ?>
                                    <?php foreach($upcomingAgenda as $agenda): ?>
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1"><strong><?= esc($agenda['nama_kegiatan']) ?></strong></h6>
                                                    <p class="text-muted mb-1">
                                                        <i class="bi bi-calendar2-week me-1"></i> 
                                                        <?= date('d M Y H:i', strtotime($agenda['tanggal_mulai'])) ?>
                                                    </p>
                                                    <p class="text-muted mb-1">
                                                        <i class="bi bi-geo-alt me-1"></i> 
                                                        <?= esc($agenda['lokasi']) ?>
                                                    </p>
                                                    <small class="text-break"><?= esc(word_limiter($agenda['deskripsi'] ?? 'Deskripsi agenda', 15)) ?></small>
                                                </div>
                                                <div class="ms-3">
                                                    <a href="<?= site_url('dashboard/add-to-calendar/' . $agenda['id']) ?>" class="btn btn-sm btn-outline-primary mb-1" title="Tambahkan ke Kalender">
                                                        <i class="bi bi-calendar-plus"></i>
                                                    </a>
                                                    <a href="<?= site_url('absensi/agenda/' . $agenda['id']) ?>" class="btn btn-sm btn-primary" title="Lihat Detail">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Recent Activities Card -->
                    <div class="modern-card">
                        <div class="card-header">
                            <h5><i class="bi bi-activity"></i>Aktivitas Terbaru</h5>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($recentActivities)): ?>
                                <div class="activity-timeline">
                                    <?php foreach (array_slice($recentActivities, 0, 5) as $activity): ?>
                                        <div class="activity-item d-flex align-items-start mb-3">
                                            <?php if (isset($activity['nama_kegiatan'])): ?>
                                                <div class="activity-icon me-3">
                                                    <div class="icon-circle bg-success">
                                                        <i class="bi bi-check-circle"></i>
                                                    </div>
                                                </div>
                                                <div class="activity-content flex-grow-1">
                                                    <div class="activity-text fw-medium">Hadir di kegiatan</div>
                                                    <div class="activity-detail text-muted"><?= esc(word_limiter($activity['nama_kegiatan'] ?? 'Kegiatan', 6)) ?></div>
                                                    <small class="activity-time text-muted">
                                                        <?= !empty($activity['waktu_absen']) ? date('d M Y H:i', strtotime($activity['waktu_absen'])) : '-' ?>
                                                    </small>
                                                </div>
                                            <?php else: ?>
                                                <div class="activity-icon me-3">
                                                    <div class="icon-circle bg-warning">
                                                        <i class="bi bi-star-fill"></i>
                                                    </div>
                                                </div>
                                                <div class="activity-content flex-grow-1">
                                                    <div class="activity-text fw-medium">+<?= $activity['poin'] ?? 0 ?> poin</div>
                                                    <div class="activity-detail text-muted"><?= esc(word_limiter($activity['deskripsi'] ?? 'Aktivitas', 6)) ?></div>
                                                    <small class="activity-time text-muted">
                                                        <?= !empty($activity['tanggal_dapat']) ? date('d M Y H:i', strtotime($activity['tanggal_dapat'])) : '-' ?>
                                                    </small>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="empty-state text-center">
                                    <i class="bi bi-clock-history"></i>
                                    <p class="mb-0">Belum ada aktivitas</p>
                                    <small>Aktivitas akan muncul di sini</small>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Side Content -->
                <div class="col-lg-4">
                    <!-- Quick Join Agenda -->
                    <div class="modern-card mb-4">
                        <div class="card-header">
                            <h5><i class="bi bi-calendar-plus"></i>Join Agenda Cepat</h5>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($availableAgenda)): ?>
                                <div class="agenda-quick-list">
                                    <?php foreach (array_slice($availableAgenda, 0, 3) as $agenda): ?>
                                        <div class="agenda-quick-item mb-3 p-3 border rounded">
                                            <h6 class="mb-2"><?= esc($agenda['nama_kegiatan'] ?? 'Nama Kegiatan') ?></h6>
                                            <div class="agenda-meta small">
                                                <div class="mb-1">
                                                    <i class="bi bi-calendar3 text-primary me-1"></i>
                                                    <?= !empty($agenda['tanggal_mulai']) ? date('d M Y', strtotime($agenda['tanggal_mulai'])) : '-' ?>
                                                </div>
                                                <div class="mb-1">
                                                    <i class="bi bi-clock text-success me-1"></i>
                                                    <?= !empty($agenda['jam_mulai']) ? date('H:i', strtotime($agenda['jam_mulai'])) : '-' ?> WIB
                                                </div>
                                                <div class="mb-2">
                                                    <i class="bi bi-geo-alt text-warning me-1"></i>
                                                    <?= esc(word_limiter($agenda['lokasi'] ?? 'Lokasi', 3)) ?>
                                                </div>
                                            </div>
                                            <?php if (!($agenda['sudah_daftar'] ?? false)): ?>
                                                <button class="btn btn-primary btn-sm w-100 quick-join-btn" 
                                                        data-agenda-id="<?= $agenda['id'] ?? 0 ?>"
                                                        data-agenda-name="<?= esc($agenda['nama_kegiatan'] ?? '') ?>">
                                                    <i class="bi bi-plus-circle me-1"></i>Gabung
                                                </button>
                                            <?php else: ?>
                                                <span class="badge bg-success w-100 py-2">
                                                    <i class="bi bi-check-circle me-1"></i>Terdaftar
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <a href="<?= site_url('absensi/agenda') ?>" class="btn btn-outline-primary btn-sm w-100">
                                    <i class="bi bi-calendar-event me-1"></i>Lihat Semua Agenda
                                </a>
                            <?php else: ?>
                                <div class="empty-state text-center">
                                    <i class="bi bi-calendar-x"></i>
                                    <p class="mb-0">Tidak ada agenda</p>
                                    <small>Cek kembali nanti</small>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Recent News -->
                    <div class="modern-card">
                        <div class="card-header">
                            <h5><i class="bi bi-newspaper"></i>Berita Terbaru</h5>
                        </div>
                        <div class="card-body">
                            <?php if(!empty($recentBerita)): ?>
                                <div class="news-list">
                                    <?php foreach(array_slice($recentBerita, 0, 3) as $berita): ?>
                                        <div class="news-item d-flex align-items-center mb-3">
                                            <div class="activity-icon red me-3">
                                                <i class="bi bi-newspaper"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="news-title small fw-medium"><?= esc(word_limiter($berita['judul'] ?? 'Berita', 8)) ?></div>
                                                <small class="text-muted"><?= date('d M Y', strtotime($berita['created_at'])) ?></small>
                                            </div>
                                            <a href="/berita/<?= $berita['slug'] ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-arrow-right"></i>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <a href="<?= site_url('berita') ?>" class="btn btn-outline-info btn-sm w-100">
                                    <i class="bi bi-newspaper me-1"></i>Lihat Semua Berita
                                </a>
                            <?php else: ?>
                                <div class="empty-state text-center">
                                    <i class="bi bi-newspaper"></i>
                                    <p class="mb-0">Tidak ada berita</p>
                                    <small>Berita akan muncul di sini</small>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('js/dashboard-enhanced.js') ?>"></script>
<?php if ($dashboard_type === 'anggota'): ?>
<script src="<?= base_url('js/dashboard-member.js') ?>"></script>
<?php endif; ?>
<?php if ($dashboard_type === 'super_admin'): ?>
<script src="<?= base_url('js/statistics-enhanced.js') ?>"></script>
<script>
/* ============================================
   KADER STATISTICS — Search, Sort, View Toggle
   ============================================ */
(function() {
    var grid       = document.getElementById('kaderGrid');
    var searchInp  = document.getElementById('kaderSearchInput');
    var sortSel    = document.getElementById('kaderSortSelect');
    var noResult   = document.getElementById('kaderNoResult');
    var countEl    = document.getElementById('kaderShownCount');

    if (!grid) return;

    var allCards = Array.from(grid.querySelectorAll('.kader-card'));

    function filterAndSort() {
        var q    = searchInp ? searchInp.value.toLowerCase().trim() : '';
        var sort = sortSel ? sortSel.value : 'desc';

        // Filter
        var visible = allCards.filter(function(c) {
            var name = c.dataset.name || '';
            return name.includes(q);
        });

        // Sort
        visible.sort(function(a, b) {
            if (sort === 'asc')  return parseInt(a.dataset.count) - parseInt(b.dataset.count);
            if (sort === 'name') return (a.dataset.name || '').localeCompare(b.dataset.name || '');
            return parseInt(b.dataset.count) - parseInt(a.dataset.count); // desc default
        });

        // Hide all
        allCards.forEach(function(c) {
            c.classList.add('kader-hidden');
            c.style.order = '';
        });

        // Show visible in sorted order
        visible.forEach(function(c, i) {
            c.classList.remove('kader-hidden');
            c.style.order = i;
        });

        // No result state
        if (noResult) noResult.classList.toggle('d-none', visible.length > 0);
        if (countEl)  countEl.textContent = visible.length;
    }

    if (searchInp) {
        searchInp.addEventListener('input', filterAndSort);
    }
    if (sortSel) {
        sortSel.addEventListener('change', filterAndSort);
    }

    // Initial run
    filterAndSort();
})();

/* View toggle */
function setKaderView(mode) {
    var grid   = document.getElementById('kaderGrid');
    var btnG   = document.getElementById('btnGridView');
    var btnL   = document.getElementById('btnListView');
    if (!grid) return;

    if (mode === 'list') {
        grid.classList.add('list-mode');
        if (btnG) btnG.classList.remove('active');
        if (btnL) btnL.classList.add('active');
    } else {
        grid.classList.remove('list-mode');
        if (btnG) btnG.classList.add('active');
        if (btnL) btnL.classList.remove('active');
    }
}
</script>
<?php endif; ?>
<?= $this->endSection() ?>
