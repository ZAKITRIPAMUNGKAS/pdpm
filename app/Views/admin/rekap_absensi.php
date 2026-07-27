<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-geo-alt-fill me-2"></i>
                        Rekap Absensi GPS
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (empty($agenda)): ?>
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            Belum ada agenda kegiatan yang tersedia.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Kegiatan</th>
                                        <th>Tanggal</th>
                                        <th>Lokasi</th>
                                        <th>Total Peserta</th>
                                        <th>Hadir</th>
                                        <th>Terlambat</th>
                                        <th>Tidak Hadir</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($agenda as $item): ?>
                                    <tr>
                                        <td>
                                            <strong><?= esc($item['nama_kegiatan']) ?></strong>
                                        </td>
                                        <td>
                                            <?= date('d M Y', strtotime($item['tanggal_mulai'])) ?>
                                            <?php if ($item['tanggal_mulai'] !== $item['tanggal_selesai']): ?>
                                                - <?= date('d M Y', strtotime($item['tanggal_selesai'])) ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?= esc($item['lokasi']) ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary"><?= $item['total_peserta'] ?></span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success"><?= $item['hadir'] ?></span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning"><?= $item['terlambat'] ?></span>
                                        </td>
                                        <td>
                                            <span class="badge bg-danger"><?= $item['tidak_hadir'] ?></span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="<?= site_url('rekap-absensi/' . $item['id']) ?>" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye me-1"></i>Detail
                                                </a>
                                                <a href="<?= site_url('rekap-absensi/export/' . $item['id']) ?>" 
                                                   class="btn btn-sm btn-outline-success">
                                                    <i class="bi bi-download me-1"></i>Export
                                                </a>
                                            </div>
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
