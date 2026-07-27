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
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Voting Formatur</h6>
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
                            <strong>Formatur yang Harus Dipilih:</strong><br>
                            <span class="badge badge-primary badge-lg"><?= $voting['required_selections'] ?> formatur</span>
                        </div>
                        <div class="col-md-6">
                            <strong>Total Kandidat:</strong><br>
                            <?= count($options) ?> kandidat
                        </div>
                    </div>

                    <div class="alert alert-info mt-3">
                        <i class="bi bi-info-circle"></i> 
                        <strong>Penting:</strong> Anda harus memilih tepat <strong><?= $voting['required_selections'] ?> formatur</strong> dari daftar kandidat di bawah.
                    </div>
                </div>
            </div>

            <!-- Voting Form -->
            <?php if (!$hasVoted && $canVote): ?>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            Pilih <?= $voting['required_selections'] ?> Formatur
                            <span class="badge badge-warning ml-2" id="selection-counter">
                                0 / <?= $voting['required_selections'] ?>
                            </span>
                        </h6>
                    </div>
                    <div class="card-body">
                        <form id="votingForm">
                            <?= csrf_field() ?>
                            <div class="row">
                                <?php foreach ($options as $option): ?>
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card candidate-card" data-option-id="<?= $option['id'] ?>">
                                        <div class="card-img-container">
                                            <?php if ($option['foto']): ?>
                                                <img src="<?= base_url('uploads/formatur/' . $option['foto']) ?>" 
                                                     class="card-img-top" style="height: 200px; object-fit: cover;" 
                                                     alt="<?= $option['nama_pilihan'] ?>">
                                            <?php else: ?>
                                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                                    <i class="bi bi-person fa-3x text-muted"></i>
                                                </div>
                                            <?php endif; ?>
                                            <div class="card-img-overlay">
                                                <div class="form-check">
                                                    <input class="form-check-input candidate-checkbox" type="checkbox" 
                                                           name="options[]" value="<?= $option['id'] ?>" 
                                                           id="option_<?= $option['id'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="card-body">
                                            <h6 class="card-title"><?= esc($option['nama_pilihan']) ?></h6>
                                            <?php if (!empty($option['deskripsi'])): ?>
                                                <p class="card-text text-muted small"><?= esc($option['deskripsi']) ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>

                            <div class="form-group mt-4 text-center">
                                <button type="submit" class="btn btn-primary btn-lg" id="submit-btn" disabled>
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
                        <p>Formatur yang Anda pilih:</p>
                        <div class="row">
                            <?php foreach ($userVotes as $vote): ?>
                            <div class="col-md-6 col-lg-4 mb-3">
                                <div class="card border-success">
                                    <div class="card-body text-center">
                                        <i class="bi bi-person-check fa-2x text-success mb-2"></i>
                                        <h6 class="card-title"><?= esc($vote['nama_pilihan']) ?></h6>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
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
                        <h6 class="m-0 font-weight-bold text-primary">Hasil Voting Formatur</h6>
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

                        <div class="row">
                            <?php foreach ($stats['options'] as $option): ?>
                            <div class="col-md-6 col-lg-4 mb-3">
                                <div class="card">
                                    <?php if ($option['foto']): ?>
                                        <img src="<?= base_url('uploads/formatur/' . $option['foto']) ?>" 
                                             class="card-img-top" style="height: 150px; object-fit: cover;" 
                                             alt="<?= $option['nama_pilihan'] ?>">
                                    <?php else: ?>
                                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 150px;">
                                            <i class="bi bi-person fa-2x text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="card-body">
                                        <h6 class="card-title"><?= esc($option['nama_pilihan']) ?></h6>
                                        
                                        <div class="mb-2">
                                            <span class="badge badge-primary">
                                                <?= $option['vote_count'] ?> suara
                                            </span>
                                            
                                            <?php if ($stats['total_votes'] > 0): ?>
                                                <?php $percentage = ($option['vote_count'] / $stats['total_votes']) * 100; ?>
                                                <span class="badge badge-info">
                                                    <?= number_format($percentage, 1) ?>%
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <?php if ($stats['total_votes'] > 0): ?>
                                            <?php $percentage = ($option['vote_count'] / $stats['total_votes']) * 100; ?>
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar" role="progressbar" style="width: <?= $percentage ?>%" 
                                                     aria-valuenow="<?= $percentage ?>" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
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

            <!-- Selection Info -->
            <?php if (!$hasVoted && $canVote): ?>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Pemilihan</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i>
                        <strong>Perhatian:</strong> Anda harus memilih tepat <strong><?= $voting['required_selections'] ?> formatur</strong>.
                    </div>
                    
                    <div class="text-center">
                        <div class="mb-2">
                            <span class="badge badge-primary badge-lg" id="selection-info">
                                0 / <?= $voting['required_selections'] ?>
                            </span>
                        </div>
                        <small class="text-muted">Formatur Terpilih</small>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.candidate-card {
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.candidate-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.candidate-card.selected {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}

.candidate-checkbox {
    transform: scale(1.5);
}

.card-img-container {
    position: relative;
}

.card-img-overlay {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(255,255,255,0.9);
    border-radius: 50%;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>

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

// Formatur selection logic
<?php if (!$hasVoted && $canVote): ?>
const requiredSelections = <?= $voting['required_selections'] ?>;
let selectedCount = 0;

// Handle candidate card clicks
document.querySelectorAll('.candidate-card').forEach(card => {
    card.addEventListener('click', function(e) {
        if (e.target.type === 'checkbox') return;
        
        const checkbox = this.querySelector('.candidate-checkbox');
        if (checkbox.disabled) return;
        
        checkbox.checked = !checkbox.checked;
        updateSelection();
    });
});

// Handle checkbox changes
document.querySelectorAll('.candidate-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', updateSelection);
});

function updateSelection() {
    const checkboxes = document.querySelectorAll('.candidate-checkbox');
    selectedCount = 0;
    
    checkboxes.forEach(checkbox => {
        const card = checkbox.closest('.candidate-card');
        if (checkbox.checked) {
            selectedCount++;
            card.classList.add('selected');
        } else {
            card.classList.remove('selected');
        }
    });
    
    // Update counters
    document.getElementById('selection-counter').textContent = `${selectedCount} / ${requiredSelections}`;
    document.getElementById('selection-info').textContent = `${selectedCount} / ${requiredSelections}`;
    
    // Enable/disable submit button
    const submitBtn = document.getElementById('submit-btn');
    if (selectedCount === requiredSelections) {
        submitBtn.disabled = false;
        submitBtn.classList.remove('btn-secondary');
        submitBtn.classList.add('btn-primary');
    } else {
        submitBtn.disabled = true;
        submitBtn.classList.remove('btn-primary');
        submitBtn.classList.add('btn-secondary');
    }
    
    // Disable other checkboxes if limit reached
    checkboxes.forEach(checkbox => {
        const card = checkbox.closest('.candidate-card');
        if (!checkbox.checked && selectedCount >= requiredSelections) {
            card.style.opacity = '0.5';
            card.style.pointerEvents = 'none';
        } else {
            card.style.opacity = '1';
            card.style.pointerEvents = 'auto';
        }
    });
}

// Voting form submission
document.getElementById('votingForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const selectedOptions = formData.getAll('options[]');
    // Explicitly attach CSRF token header for CI4
    const csrfName = '<?= csrf_token() ?>';
    const csrfValue = this.querySelector(`input[name='<?= csrf_token() ?>']`)?.value || '';
    
    if (selectedOptions.length !== requiredSelections) {
        alert(`Anda harus memilih tepat ${requiredSelections} formatur.`);
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
<?php endif; ?>
</script>
<?= $this->endSection() ?>
