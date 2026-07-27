<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-clock-history me-2"></i>
                        Riwayat Absensi Saya
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (empty($riwayat)): ?>
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            Belum ada riwayat absensi.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Kegiatan</th>
                                        <th>Tanggal Kegiatan</th>
                                        <th>Waktu Absen</th>
                                        <th>Status</th>
                                        <th>Jarak</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($riwayat as $item): ?>
                                    <tr>
                                        <td>
                                            <strong><?= esc($item['nama_kegiatan']) ?></strong><br>
                                            <small class="text-muted"><?= esc($item['lokasi']) ?></small>
                                        </td>
                                        <td>
                                            <?= date('d M Y', strtotime($item['tanggal_mulai'])) ?><br>
                                            <small class="text-muted">
                                                <?= !empty($item['jam_mulai']) ? date('H:i', strtotime($item['jam_mulai'])) : '00:00' ?> - 
                                                <?= !empty($item['jam_selesai']) ? date('H:i', strtotime($item['jam_selesai'])) : '23:59' ?>
                                            </small>
                                        </td>
                                        <td>
                                            <?= date('d M Y H:i', strtotime($item['waktu_absen'])) ?>
                                        </td>
                                        <td>
                                            <?php if ($item['status_absen'] === 'hadir'): ?>
                                                <span class="badge bg-success">
                                                    <i class="bi bi-check-circle me-1"></i>Hadir
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-warning">
                                                    <i class="bi bi-clock me-1"></i>Terlambat
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?= number_format($item['jarak_meter'], 2) ?> m
                                        </td>
                                        <td>
                                            <?= $item['keterangan'] ? esc($item['keterangan']) : '-' ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
