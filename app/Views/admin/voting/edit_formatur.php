<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0"><?= $page_title ?></h3>
                    <a href="<?= site_url('admin-voting') ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                    </a>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= site_url('admin-voting/update/' . $voting['id']) ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="judul">Judul Voting Formatur <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="judul" name="judul" 
                                           value="<?= old('judul', $voting['judul']) ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"><?= old('deskripsi', $voting['deskripsi']) ?></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tanggal_mulai">Tanggal Mulai <span class="text-danger">*</span></label>
                                            <input type="datetime-local" class="form-control" id="tanggal_mulai" name="tanggal_mulai" 
                                                   value="<?= old('tanggal_mulai', date('Y-m-d\TH:i', strtotime($voting['tanggal_mulai']))) ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tanggal_selesai">Tanggal Selesai <span class="text-danger">*</span></label>
                                            <input type="datetime-local" class="form-control" id="tanggal_selesai" name="tanggal_selesai" 
                                                   value="<?= old('tanggal_selesai', date('Y-m-d\TH:i', strtotime($voting['tanggal_selesai']))) ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="required_selections">Jumlah Formatur yang Harus Dipilih <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" id="required_selections" name="required_selections" 
                                                   value="<?= old('required_selections', $voting['required_selections'] ?? 9) ?>" min="1" required>
                                            <small class="form-text text-muted">Default: 9 formatur</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="min_candidates">Minimal Kandidat <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" id="min_candidates" name="min_candidates" 
                                                   value="<?= old('min_candidates', $voting['min_candidates'] ?? 9) ?>" min="1" required>
                                            <small class="form-text text-muted">Minimal 9 kandidat formatur</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="show_results_before_end" name="show_results_before_end" value="1" <?= old('show_results_before_end', $voting['show_results_before_end']) ? 'checked' : '' ?> style="pointer-events: auto; z-index: 1;">
                                        <label class="form-check-label" for="show_results_before_end" style="cursor: pointer; pointer-events: auto;">
                                            Tampilkan hasil sebelum voting selesai
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <h5>Kandidat Formatur</h5>
                        <p class="text-muted">Minimal 9 kandidat formatur. Anda dapat menambah lebih banyak kandidat.</p>
                        
                        <div id="candidates-container">
                            <?php 
                            $oldOptions = old('options', []);
                            $oldPhotos = old('photos', []);
                            $defaultCount = max(9, count($oldOptions), count($options));
                            
                            // Use existing options if no old data
                            if (empty($oldOptions) && !empty($options)) {
                                $oldOptions = array_column($options, 'nama_pilihan');
                                $oldPhotos = array_column($options, 'foto');
                            }
                            
                            for ($i = 0; $i < $defaultCount; $i++): 
                            ?>
                            <div class="candidate-item border p-3 mb-3">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>Nama Kandidat Formatur <?= $i + 1 ?> <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control candidate-name" name="options[]" 
                                                   value="<?= isset($oldOptions[$i]) ? $oldOptions[$i] : '' ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Foto Kandidat</label>
                                            <input type="file" class="form-control candidate-photo" name="photos[]" accept="image/*">
                                            <small class="form-text text-muted">Format: JPG, PNG (Max: 2MB)</small>
                                            <?php if (isset($oldPhotos[$i]) && $oldPhotos[$i]): ?>
                                                <div class="mt-2">
                                                    <small class="text-info">Foto saat ini: <?= $oldPhotos[$i] ?></small>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Deskripsi (Opsional)</label>
                                            <textarea class="form-control" name="descriptions[]" rows="2"><?= isset($oldDescriptions[$i]) ? $oldDescriptions[$i] : '' ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-danger btn-sm remove-candidate" style="display: none;">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </div>
                            <?php endfor; ?>
                        </div>

                        <div class="mb-4 d-flex justify-content-center">
                            <button type="button" class="btn btn-success" id="add-candidate">
                                <i class="bi bi-plus"></i> Tambah Kandidat
                            </button>
                        </div>

                        <div class="form-group d-flex justify-content-end gap-2">
                            <a href="<?= site_url('admin-voting') ?>" class="btn btn-outline-secondary">
                                <i class="bi bi-x"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Update Voting Formatur
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('candidates-container');
    const addButton = document.getElementById('add-candidate');
    let candidateCount = <?= $defaultCount ?>;

    // Add candidate
    addButton.addEventListener('click', function() {
        candidateCount++;
        const candidateHtml = `
            <div class="candidate-item border p-3 mb-3">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Nama Kandidat Formatur ${candidateCount} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control candidate-name" name="options[]" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Foto Kandidat</label>
                            <input type="file" class="form-control candidate-photo" name="photos[]" accept="image/*">
                            <small class="form-text text-muted">Format: JPG, PNG (Max: 2MB)</small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label>Deskripsi (Opsional)</label>
                            <textarea class="form-control" name="descriptions[]" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-danger btn-sm remove-candidate">
                    <i class="bi bi-trash"></i> Hapus
                </button>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', candidateHtml);
        updateRemoveButtons();
    });

    // Remove candidate
    container.addEventListener('click', function(e) {
        if (e.target.closest('.remove-candidate')) {
            const candidateItem = e.target.closest('.candidate-item');
            candidateItem.remove();
            updateRemoveButtons();
        }
    });

    // Update remove buttons visibility
    function updateRemoveButtons() {
        const candidates = container.querySelectorAll('.candidate-item');
        candidates.forEach((candidate, index) => {
            const removeBtn = candidate.querySelector('.remove-candidate');
            if (candidates.length > 9) {
                removeBtn.style.display = 'inline-block';
            } else {
                removeBtn.style.display = 'none';
            }
        });
    }

    // Initialize
    updateRemoveButtons();
    
    // Ensure checkbox is clickable
    const checkbox = document.getElementById('show_results_before_end');
    if (checkbox) {
        checkbox.addEventListener('click', function(e) {
            e.stopPropagation();
        });
        
        // Also handle label click
        const label = document.querySelector('label[for="show_results_before_end"]');
        if (label) {
            label.addEventListener('click', function(e) {
                e.preventDefault();
                checkbox.checked = !checkbox.checked;
            });
        }
    }
});
</script>
<?= $this->endSection() ?>
