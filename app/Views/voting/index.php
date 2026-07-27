<?= $this->extend('layout/member') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $page_title ?></h1>
    </div>

    <!-- Voting List -->
    <div class="row">
        <?php if (empty($voting_list)): ?>
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-ui-checks fa-3x text-gray-300 mb-3"></i>
                        <h5 class="text-gray-500">Tidak Ada Voting Aktif</h5>
                        <p class="text-gray-500">Saat ini tidak ada voting yang sedang berlangsung.</p>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($voting_list as $voting): ?>
                <div class="col-lg-6 mb-4">
                    <div class="card shadow h-100">
                        <div class="card-header py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="m-0 font-weight-bold text-primary"><?= esc($voting['judul']) ?></h6>
                                <span class="badge badge-success">Aktif</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($voting['deskripsi'])): ?>
                                <p class="text-muted"><?= esc(character_limiter($voting['deskripsi'], 100)) ?></p>
                            <?php endif; ?>
                            
                            <div class="row mb-3">
                                <div class="col-6">
                                    <small class="text-muted">
                                        <i class="bi bi-calendar-event"></i> Mulai:<br>
                                        <?= date('d/m/Y H:i', strtotime($voting['tanggal_mulai'])) ?>
                                    </small>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">
                                        <i class="bi bi-calendar-check"></i> Selesai:<br>
                                        <?= date('d/m/Y H:i', strtotime($voting['tanggal_selesai'])) ?>
                                    </small>
                                </div>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted">
                                    <i class="bi bi-person"></i> Pembuat: <?= esc($voting['creator_name']) ?><br>
                                    <i class="bi bi-people"></i> Total pemilih: <?= $voting['total_voters'] ?>
                                </small>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <span class="badge badge-info">
                                        <?= isset($voting['required_selections']) && $voting['required_selections'] ? (int)$voting['required_selections'] : 9 ?> formatur
                                    </span>
                                </small>
                                <a href="<?= base_url('voting/' . $voting['id']) ?>" class="btn btn-primary btn-sm">
                                    <i class="bi bi-ui-checks"></i> Ikuti Voting
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
