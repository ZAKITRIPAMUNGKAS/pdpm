<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><?= $page_title ?></h3>
                    <div class="card-tools">
                        <a href="<?= site_url('admin-voting') ?>" class="btn btn-secondary btn-sm">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Voting Information -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <h4><?= $voting['judul'] ?></h4>
                            <?php if ($voting['deskripsi']): ?>
                                <p class="text-muted"><?= $voting['deskripsi'] ?></p>
                            <?php endif; ?>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Tanggal Mulai:</strong><br>
                                    <?= date('d/m/Y H:i', strtotime($voting['tanggal_mulai'])) ?>
                                </div>
                                <div class="col-md-6">
                                    <strong>Tanggal Selesai:</strong><br>
                                    <?= date('d/m/Y H:i', strtotime($voting['tanggal_selesai'])) ?>
                                </div>
                            </div>
                            
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <strong>Formatur yang Harus Dipilih:</strong><br>
                                    <?= $voting['required_selections'] ?> formatur
                                </div>
                                <div class="col-md-6">
                                    <strong>Minimal Kandidat:</strong><br>
                                    <?= $voting['min_candidates'] ?> kandidat
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h5>Status Voting</h5>
                                    <?php
                                    $statusClass = [
                                        'draft' => 'warning',
                                        'aktif' => 'success',
                                        'selesai' => 'info',
                                        'dibatalkan' => 'danger'
                                    ];
                                    $statusText = [
                                        'draft' => 'Draft',
                                        'aktif' => 'Aktif',
                                        'selesai' => 'Selesai',
                                        'dibatalkan' => 'Dibatalkan'
                                    ];
                                    ?>
                                    <span class="badge badge-<?= $statusClass[$voting['status']] ?> badge-lg">
                                        <?= $statusText[$voting['status']] ?>
                                    </span>
                                    
                                    <?php if ($voting['status'] === 'aktif'): ?>
                                        <div class="mt-2">
                                            <small class="text-muted">Waktu Tersisa:</small><br>
                                            <span id="countdown" class="text-primary font-weight-bold"></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics -->
                    <?php if ($stats): ?>
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h4><?= $stats['total_votes'] ?></h4>
                                    <p class="mb-0">Total Suara</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h4><?= $stats['unique_voters'] ?></h4>
                                    <p class="mb-0">Total Pemilih</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <h4><?= count($options) ?></h4>
                                    <p class="mb-0">Total Kandidat</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    <h4><?= $voting['required_selections'] ?></h4>
                                    <p class="mb-0">Formatur Terpilih</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Action Buttons -->
                    <div class="mb-4">
                        <?php if ($voting['status'] === 'draft'): ?>
                            <a href="<?= site_url('admin-voting/edit/' . $voting['id']) ?>" class="btn btn-warning">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                        <?php endif; ?>
                        
                        <?php if (in_array($voting['status'], ['draft', 'aktif'])): ?>
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#statusModal">
                                <i class="bi bi-play-fill"></i> Ubah Status
                            </button>
                        <?php endif; ?>
                        
                        <a href="<?= site_url('admin-voting/export/' . $voting['id']) ?>" class="btn btn-info">
                            <i class="bi bi-download"></i> Export Hasil
                        </a>
                        
                        <?php if ($voting['status'] === 'draft'): ?>
                            <button type="button" class="btn btn-danger" onclick="deleteVoting(<?= $voting['id'] ?>)">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        <?php endif; ?>
                    </div>

                    <!-- Candidates List -->
                    <h5>Daftar Kandidat Formatur</h5>
                    <div class="row">
                        <?php foreach ($options as $index => $option): ?>
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <?php if ($option['foto']): ?>
                                    <img src="<?= base_url('uploads/formatur/' . $option['foto']) ?>" 
                                         class="card-img-top" style="height: 200px; object-fit: cover;" 
                                         alt="<?= $option['nama_pilihan'] ?>">
                                <?php else: ?>
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                        <i class="bi bi-person fa-3x text-muted"></i>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="card-body">
                                    <h6 class="card-title"><?= $option['nama_pilihan'] ?></h6>
                                    <?php if ($option['deskripsi']): ?>
                                        <p class="card-text text-muted small"><?= $option['deskripsi'] ?></p>
                                    <?php endif; ?>
                                    
                                    <div class="mt-2">
                                        <span class="badge badge-primary">
                                            <?= $option['vote_count'] ?> suara
                                        </span>
                                        
                                        <?php if ($stats && $stats['total_votes'] > 0): ?>
                                            <?php $percentage = ($option['vote_count'] / $stats['total_votes']) * 100; ?>
                                            <span class="badge badge-info">
                                                <?= number_format($percentage, 1) ?>%
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Results Chart -->
                    <?php if ($stats && $stats['total_votes'] > 0): ?>
                    <div class="mt-4">
                        <h5>Grafik Hasil Voting</h5>
                        <canvas id="resultsChart" width="400" height="200"></canvas>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status Change Modal -->
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Status Voting</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="<?= site_url('admin-voting/status/' . $voting['id']) ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="status">Status Baru</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="draft" <?= $voting['status'] === 'draft' ? 'selected' : '' ?>>Draft</option>
                            <option value="aktif" <?= $voting['status'] === 'aktif' ? 'selected' : '' ?>>Aktif</option>
                            <option value="selesai" <?= $voting['status'] === 'selesai' ? 'selected' : '' ?>>Selesai</option>
                            <option value="dibatalkan" <?= $voting['status'] === 'dibatalkan' ? 'selected' : '' ?>>Dibatalkan</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Ubah Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Countdown timer
<?php if ($voting['status'] === 'aktif'): ?>
function updateCountdown() {
    const endTime = new Date('<?= $voting['tanggal_selesai'] ?>').getTime();
    const now = new Date().getTime();
    const distance = endTime - now;

    if (distance < 0) {
        document.getElementById('countdown').innerHTML = 'Voting Selesai';
        return;
    }

    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

    document.getElementById('countdown').innerHTML = 
        days + 'd ' + hours + 'h ' + minutes + 'm ' + seconds + 's';
}

setInterval(updateCountdown, 1000);
updateCountdown();
<?php endif; ?>

// Results Chart
<?php if ($stats && $stats['total_votes'] > 0): ?>
const ctx = document.getElementById('resultsChart').getContext('2d');
const chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?= implode(',', array_map(function($option) { return "'" . addslashes($option['nama_pilihan']) . "'"; }, $options)) ?>],
        datasets: [{
            label: 'Jumlah Suara',
            data: [<?= implode(',', array_column($options, 'vote_count')) ?>],
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
<?php endif; ?>

// Delete voting
function deleteVoting(id) {
    if (confirm('Apakah Anda yakin ingin menghapus voting ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= site_url('admin-voting/delete/') ?>' + id;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '<?= csrf_token() ?>';
        csrfToken.value = '<?= csrf_hash() ?>';
        form.appendChild(csrfToken);
        
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
<?= $this->endSection() ?>
