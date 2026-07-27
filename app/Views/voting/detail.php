<?= $this->extend('layout/member') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $page_title ?></h1>
        <a href="<?= base_url('voting') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Voting Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Voting</h6>
                </div>
                <div class="card-body">
                    <h4><?= esc($voting['judul']) ?></h4>
                    <?php if (!empty($voting['deskripsi'])): ?>
                        <p class="text-muted"><?= nl2br(esc($voting['deskripsi'])) ?></p>
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

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <strong>Pembuat:</strong><br>
                            <?= esc($voting['creator_name']) ?>
                        </div>
                        <div class="col-md-6">
                            <strong>Total Pemilih:</strong><br>
                            <?= $voting['total_voters'] ?> orang
                        </div>
                    </div>

                    <?php if ($voting['allow_multiple_choice']): ?>
                        <div class="alert alert-info mt-3">
                            <i class="bi bi-info-circle"></i> 
                            <strong>Pilihan Ganda:</strong> Anda dapat memilih lebih dari satu pilihan.
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Voting Form -->
            <?php if (!$hasVoted && $canVote): ?>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Pilih Jawaban Anda</h6>
                    </div>
                    <div class="card-body">
                        <form id="votingForm">
                            <?= csrf_field() ?>
                            <?php foreach ($options as $option): ?>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="<?= $voting['allow_multiple_choice'] ? 'checkbox' : 'radio' ?>" 
                                           name="options[]" value="<?= $option['id'] ?>" id="option_<?= $option['id'] ?>">
                                    <label class="form-check-label" for="option_<?= $option['id'] ?>">
                                        <strong><?= esc($option['nama_pilihan']) ?></strong>
                                        <?php if (!empty($option['deskripsi'])): ?>
                                            <br><small class="text-muted"><?= esc($option['deskripsi']) ?></small>
                                        <?php endif; ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-ui-checks"></i> Kirim Suara
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php elseif ($hasVoted): ?>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-success">
                            <i class="bi bi-check-circle"></i> Anda Sudah Memberikan Suara
                        </h6>
                    </div>
                    <div class="card-body">
                        <p>Pilihan Anda:</p>
                        <ul>
                            <?php foreach ($userVotes as $vote): ?>
                                <li><strong><?= esc($vote['nama_pilihan']) ?></strong></li>
                            <?php endforeach; ?>
                        </ul>
                        <small class="text-muted">
                            Suara diberikan pada: <?= date('d/m/Y H:i', strtotime($userVotes[0]['created_at'])) ?>
                        </small>
                    </div>
                </div>
            <?php else: ?>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-warning">
                            <i class="bi bi-exclamation-triangle"></i> Tidak Dapat Memberikan Suara
                        </h6>
                    </div>
                    <div class="card-body">
                        <p>Anda tidak dapat memberikan suara untuk voting ini.</p>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Results -->
            <?php if ($stats && ($voting['show_results_before_end'] || $voting['status'] === 'selesai')): ?>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Hasil Voting</h6>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Total Suara:</strong> <?= $stats['total_votes'] ?>
                            </div>
                            <div class="col-md-6">
                                <strong>Total Pemilih:</strong> <?= $stats['unique_voters'] ?>
                            </div>
                        </div>

                        <?php foreach ($stats['options'] as $option): ?>
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
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-lg-4">
            <!-- Voting Status -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Status Voting</h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <span class="badge badge-success badge-lg">Aktif</span>
                    </div>
                    
                    <hr>
                    
                    <div class="text-center">
                        <div id="countdown"></div>
                    </div>
                    
                    <hr>
                    
                    <div class="text-center">
                        <a href="<?= base_url('voting/history') ?>" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-clock-history"></i> Riwayat Voting Saya
                        </a>
                    </div>
                </div>
            </div>

            <!-- Voting Options -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Pilihan Voting</h6>
                </div>
                <div class="card-body">
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
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Countdown timer
function updateCountdown() {
    const endTime = new Date('<?= $voting['tanggal_selesai'] ?>').getTime();
    const now = new Date().getTime();
    const distance = endTime - now;

    if (distance < 0) {
        document.getElementById('countdown').innerHTML = '<span class="text-danger">Voting sudah berakhir</span>';
        return;
    }

    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

    document.getElementById('countdown').innerHTML = `
        <div class="row text-center">
            <div class="col-3">
                <div class="badge badge-primary">${days}</div><br>
                <small>Hari</small>
            </div>
            <div class="col-3">
                <div class="badge badge-primary">${hours}</div><br>
                <small>Jam</small>
            </div>
            <div class="col-3">
                <div class="badge badge-primary">${minutes}</div><br>
                <small>Menit</small>
            </div>
            <div class="col-3">
                <div class="badge badge-primary">${seconds}</div><br>
                <small>Detik</small>
            </div>
        </div>
    `;
}

// Update countdown every second
setInterval(updateCountdown, 1000);
updateCountdown();

// Voting form submission
document.getElementById('votingForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const selectedOptions = formData.getAll('options[]');
    // Explicitly attach CSRF token header for CI4
    const csrfName = '<?= csrf_token() ?>';
    const csrfValue = this.querySelector(`input[name='<?= csrf_token() ?>']`)?.value || '';
    
    if (selectedOptions.length === 0) {
        alert('Pilih minimal satu pilihan');
        return;
    }
    
    fetch('/voting/vote/<?= $voting['id'] ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfValue
        },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
    });
});
</script>
<?= $this->endSection() ?>
