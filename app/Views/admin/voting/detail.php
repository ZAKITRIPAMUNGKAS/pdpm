<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $page_title ?></h1>
        <div>
            <a href="<?= base_url('admin-voting') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <?php if (in_array($voting['status'], ['draft'])): ?>
                <a href="<?= base_url('admin-voting/edit/' . $voting['id']) ?>" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Voting Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Voting</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5><?= esc($voting['judul']) ?></h5>
                            <?php if (!empty($voting['deskripsi'])): ?>
                                <p class="text-muted"><?= nl2br(esc($voting['deskripsi'])) ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <div class="text-right">
                                <?php
                                $statusClass = [
                                    'draft' => 'badge-secondary',
                                    'aktif' => 'badge-success',
                                    'selesai' => 'badge-info',
                                    'dibatalkan' => 'badge-danger'
                                ];
                                $statusText = [
                                    'draft' => 'Draft',
                                    'aktif' => 'Aktif',
                                    'selesai' => 'Selesai',
                                    'dibatalkan' => 'Dibatalkan'
                                ];
                                ?>
                                <span class="badge <?= $statusClass[$voting['status']] ?> badge-lg">
                                    <?= $statusText[$voting['status']] ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <strong>Tipe Voting:</strong><br>
                            <?php
                            $tipeLabels = [
                                'pemilihan_ketua' => 'Pemilihan Ketua',
                                'musyawarah' => 'Musyawarah',
                                'keputusan_organisasi' => 'Keputusan Organisasi',
                                'lainnya' => 'Lainnya'
                            ];
                            echo $tipeLabels[$voting['tipe_voting']] ?? $voting['tipe_voting'];
                            ?>
                        </div>
                        <div class="col-md-6">
                            <strong>Pembuat:</strong><br>
                            <?= esc($voting['creator_name']) ?>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <strong>Tanggal Mulai:</strong><br>
                            <?= date('d/m/Y H:i', strtotime($voting['tanggal_mulai'])) ?>
                        </div>
                        <div class="col-md-6">
                            <strong>Tanggal Selesai:</strong><br>
                            <?= date('d/m/Y H:i', strtotime($voting['tanggal_selesai'])) ?>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <strong>Pengaturan:</strong><br>
                            <small class="text-muted">
                                <?= $voting['allow_multiple_choice'] ? '✓ Pilihan ganda diizinkan' : '✗ Pilihan tunggal' ?><br>
                                <?= $voting['show_results_before_end'] ? '✓ Hasil ditampilkan sebelum selesai' : '✗ Hasil ditampilkan setelah selesai' ?><br>
                                Minimum peserta: <?= $voting['min_participants'] ?>
                            </small>
                        </div>
                        <div class="col-md-6">
                            <strong>Statistik:</strong><br>
                            <small class="text-muted">
                                Total suara: <?= $stats['total_votes'] ?><br>
                                Total pemilih: <?= $stats['unique_voters'] ?><br>
                                Dibuat: <?= date('d/m/Y H:i', strtotime($voting['created_at'])) ?>
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Voting Results -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Hasil Voting</h6>
                </div>
                <div class="card-body">
                    <?php if (empty($options)): ?>
                        <p class="text-muted">Belum ada pilihan voting.</p>
                    <?php else: ?>
                        <?php foreach ($options as $option): ?>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span><strong><?= esc($option['nama_pilihan']) ?></strong></span>
                                    <span class="badge badge-primary"><?= $option['vote_count'] ?> suara</span>
                                </div>
                                <?php
                                $percentage = $stats['total_votes'] > 0 ? ($option['vote_count'] / $stats['total_votes']) * 100 : 0;
                                ?>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: <?= $percentage ?>%" 
                                         aria-valuenow="<?= $percentage ?>" aria-valuemin="0" aria-valuemax="100">
                                        <?= number_format($percentage, 1) ?>%
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aksi Cepat</h6>
                </div>
                <div class="card-body">
                    <?php if ($voting'status'] === 'draft'): ?>
                        <button type="button" class="btn btn-success btn-block mb-2" 
                                onclick="changeStatus(<?= $voting['id'] ?>, 'aktif')">
                            <i class="bi bi-play-fill"></i> Mulai Voting
                        </button>
                    <?php endif; ?>

                    <?php if ($voting['status'] === 'aktif'): ?>
                        <button type="button" class="btn btn-warning btn-block mb-2" 
                                onclick="changeStatus(<?= $voting['id'] ?>, 'selesai')">
                            <i class="bi bi-stop-fill"></i> Selesaikan Voting
                        </button>
                    <?php endif; ?>

                    <?php if (in_array($voting['status'], ['draft', 'aktif'])): ?>
                        <button type="button" class="btn btn-danger btn-block mb-2" 
                                onclick="changeStatus(<?= $voting['id'] ?>, 'dibatalkan')">
                            <i class="bi bi-x"></i> Batalkan Voting
                        </button>
                    <?php endif; ?>

                    <?php if ($voting['status'] === 'draft'): ?>
                        <a href="<?= base_url('admin-voting/edit/' . $voting['id']) ?>" 
                           class="btn btn-warning btn-block mb-2">
                            <i class="bi bi-pencil"></i> Edit Voting
                        </a>
                        <button type="button" class="btn btn-danger btn-block mb-2" 
                                onclick="deleteVoting(<?= $voting['id'] ?>)">
                            <i class="bi bi-trash"></i> Hapus Voting
                        </button>
                    <?php endif; ?>

                    <?php if (in_array($voting['status'], ['selesai', 'dibatalkan'])): ?>
                        <a href="<?= base_url('admin-voting/export/' . $voting['id']) ?>" 
                           class="btn btn-secondary btn-block mb-2">
                            <i class="bi bi-download"></i> Export Hasil
                        </a>
                    <?php endif; ?>

                    <button type="button" class="btn btn-info btn-block" onclick="refreshResults()">
                        <i class="bi bi-arrow-repeat"></i> Refresh Hasil
                    </button>
                </div>
            </div>

            <!-- Voting Options -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Pilihan Voting</h6>
                </div>
                <div class="card-body">
                    <?php if (empty($options)): ?>
                        <p class="text-muted">Belum ada pilihan voting.</p>
                    <?php else: ?>
                        <ol>
                            <?php foreach ($options as $option): ?>
                                <li class="mb-2">
                                    <strong><?= esc($option['nama_pilihan']) ?></strong>
                                    <?php if (!empty($option['deskripsi'])): ?>
                                        <br><small class="text-muted"><?= esc($option['deskripsi']) ?></small>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ol>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status Change Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Status Voting</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="statusForm" method="post">
                <div class="modal-body">
                    <input type="hidden" name="status" id="newStatus">
                    <p>Apakah Anda yakin ingin mengubah status voting ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Ya, Ubah Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Voting</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus voting ini? Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <a href="#" id="deleteLink" class="btn btn-danger">Ya, Hapus</a>
            </div>
        </div>
    </div>
</div>

<script>
function changeStatus(votingId, newStatus) {
    document.getElementById('newStatus').value = newStatus;
    document.getElementById('statusForm').action = '<?= base_url('admin-voting/status/') ?>' + votingId;
    $('#statusModal').modal('show');
}

function deleteVoting(votingId) {
    document.getElementById('deleteLink').href = '<?= base_url('admin-voting/delete/') ?>' + votingId;
    $('#deleteModal').modal('show');
}

function refreshResults() {
    location.reload();
}
</script>
<?= $this->endSection() ?>
