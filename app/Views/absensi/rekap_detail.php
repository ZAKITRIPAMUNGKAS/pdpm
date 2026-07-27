<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header Info -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-calendar-event me-2"></i>
                        <?= esc($agenda['nama_kegiatan']) ?>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Tanggal:</strong> 
                                <?= date('d M Y', strtotime($agenda['tanggal_mulai'])) ?>
                                <?php if ($agenda['tanggal_mulai'] !== $agenda['tanggal_selesai']): ?>
                                    - <?= date('d M Y', strtotime($agenda['tanggal_selesai'])) ?>
                                <?php endif; ?>
                            </p>
                            <p><strong>Waktu:</strong> 
                                <?= $agenda['jam_mulai'] ?? '00:00' ?> - <?= $agenda['jam_selesai'] ?? '23:59' ?>
                            </p>
                            <p><strong>Lokasi:</strong> <?= esc($agenda['lokasi'] ?? '-') ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Koordinat GPS:</strong> 
                                <?= $agenda['latitude'] ?>, <?= $agenda['longitude'] ?>
                            </p>
                            <p><strong>Radius:</strong> <?= $agenda['radius_meter'] ?> meter</p>
                            <p><strong>Deskripsi:</strong> <?= esc($agenda['deskripsi'] ?? '-') ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistik -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="text-primary"><?= $statistik['total_terdaftar'] ?></h3>
                            <p class="mb-0">Total Terdaftar</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="text-success"><?= $statistik['total_hadir'] ?></h3>
                            <p class="mb-0">Hadir</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="text-danger"><?= $statistik['total_tidak_hadir'] ?></h3>
                            <p class="mb-0">Tidak Hadir</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="text-info"><?= $statistik['persentase_kehadiran'] ?>%</h3>
                            <p class="mb-0">Persentase</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Daftar Absensi -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-list-check me-2"></i>
                        Daftar Absensi
                    </h5>
                    <a href="<?= site_url('rekap-absensi/export/' . $agenda['id']) ?>" 
                       class="btn btn-success">
                        <i class="bi bi-download me-1"></i>Export Excel
                    </a>
                </div>
                <div class="card-body">
                    <?php if (empty($absensi_list)): ?>
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            Belum ada yang melakukan absensi.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>No HP</th>
                                        <th>Waktu Absen</th>
                                        <th>Status</th>
                                        <th>Jarak</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($absensi_list as $index => $absen): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td><?= esc($absen['nama_lengkap']) ?></td>
                                        <td><?= esc($absen['email']) ?></td>
                                        <td><?= esc($absen['no_hp']) ?></td>
                                        <td><?= date('d/m/Y H:i:s', strtotime($absen['waktu_absen'])) ?></td>
                                        <td>
                                            <?php if ($absen['status_absen'] === 'hadir'): ?>
                                                <span class="badge bg-success">Hadir</span>
                                            <?php elseif ($absen['status_absen'] === 'terlambat'): ?>
                                                <span class="badge bg-warning">Terlambat</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary"><?= ucfirst($absen['status_absen']) ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= number_format($absen['jarak_meter'], 1) ?> m</td>
                                        <td><?= esc($absen['keterangan'] ?? '-') ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Daftar Peserta yang Belum Absen -->
            <?php 
            $peserta_belum_absen = [];
            foreach ($peserta_list as $peserta) {
                $sudah_absen = false;
                foreach ($absensi_list as $absen) {
                    if ($absen['id_user'] == $peserta['id_user']) {
                        $sudah_absen = true;
                        break;
                    }
                }
                if (!$sudah_absen) {
                    $peserta_belum_absen[] = $peserta;
                }
            }
            ?>

            <?php if (!empty($peserta_belum_absen)): ?>
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Peserta Belum Absen (<?= count($peserta_belum_absen) ?>)
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>No HP</th>
                                    <th>Tanggal Daftar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($peserta_belum_absen as $index => $peserta): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= esc($peserta['nama_lengkap']) ?></td>
                                    <td><?= esc($peserta['email']) ?></td>
                                    <td><?= esc($peserta['no_hp']) ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($peserta['tanggal_daftar'])) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <div class="mt-3">
                <a href="<?= site_url('rekap-absensi') ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Kembali
                </a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
