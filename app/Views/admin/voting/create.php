<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $page_title ?></h1>
        <a href="<?= base_url('admin-voting') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Buat Voting</h6>
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

                    <form action="<?= base_url('admin-voting/store') ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="form-group">
                            <label for="judul">Judul Voting <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="judul" name="judul" 
                                   value="<?= old('judul') ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"><?= old('deskripsi') ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="tipe_voting">Tipe Voting <span class="text-danger">*</span></label>
                            <select class="form-control" id="tipe_voting" name="tipe_voting" required>
                                <option value="">Pilih Tipe Voting</option>
                                <option value="pemilihan_ketua" <?= old('tipe_voting') === 'pemilihan_ketua' ? 'selected' : '' ?>>Pemilihan Ketua</option>
                                <option value="musyawarah" <?= old('tipe_voting') === 'musyawarah' ? 'selected' : '' ?>>Musyawarah</option>
                                <option value="keputusan_organisasi" <?= old('tipe_voting') === 'keputusan_organisasi' ? 'selected' : '' ?>>Keputusan Organisasi</option>
                                <option value="lainnya" <?= old('tipe_voting') === 'lainnya' ? 'selected' : '' ?>>Lainnya</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_mulai">Tanggal Mulai <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control" id="tanggal_mulai" name="tanggal_mulai" 
                                           value="<?= old('tanggal_mulai') ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_selesai">Tanggal Selesai <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control" id="tanggal_selesai" name="tanggal_selesai" 
                                           value="<?= old('tanggal_selesai') ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="min_participants">Minimum Peserta</label>
                            <input type="number" class="form-control" id="min_participants" name="min_participants" 
                                   value="<?= old('min_participants', 1) ?>" min="1">
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="allow_multiple_choice" name="allow_multiple_choice" value="1"
                                       <?= old('allow_multiple_choice') ? 'checked' : '' ?>>
                                <label class="form-check-label" for="allow_multiple_choice">
                                    Izinkan pilihan ganda
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="show_results_before_end" name="show_results_before_end" value="1"
                                       <?= old('show_results_before_end') ? 'checked' : '' ?>>
                                <label class="form-check-label" for="show_results_before_end">
                                    Tampilkan hasil sebelum voting selesai
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Pilihan Voting <span class="text-danger">*</span></label>
                            <div id="options-container">
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="options[]" placeholder="Pilihan 1" required>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-danger" onclick="removeOption(this)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="options[]" placeholder="Pilihan 2" required>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-danger" onclick="removeOption(this)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addOption()">
                                <i class="bi bi-plus"></i> Tambah Pilihan
                            </button>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan Voting
                            </button>
                            <a href="<?= base_url('admin-voting') ?>" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi</h6>
                </div>
                <div class="card-body">
                    <h6>Tips Membuat Voting:</h6>
                    <ul class="small">
                        <li>Judul harus jelas dan mudah dipahami</li>
                        <li>Deskripsi dapat menjelaskan konteks voting</li>
                        <li>Pastikan tanggal mulai dan selesai sudah benar</li>
                        <li>Minimum 2 pilihan voting</li>
                        <li>Voting akan dimulai dalam status "Draft"</li>
                    </ul>
                    
                    <hr>
                    
                    <h6>Status Voting:</h6>
                    <ul class="small">
                        <li><span class="badge badge-secondary">Draft</span> - Belum dimulai</li>
                        <li><span class="badge badge-success">Aktif</span> - Sedang berlangsung</li>
                        <li><span class="badge badge-info">Selesai</span> - Sudah berakhir</li>
                        <li><span class="badge badge-danger">Dibatalkan</span> - Dibatalkan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let optionCount = 2;

function addOption() {
    optionCount++;
    const container = document.getElementById('options-container');
    const newOption = document.createElement('div');
    newOption.className = 'input-group mb-2';
    newOption.innerHTML = `
        <input type="text" class="form-control" name="options[]" placeholder="Pilihan ${optionCount}" required>
        <div class="input-group-append">
            <button type="button" class="btn btn-outline-danger" onclick="removeOption(this)">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    `;
    container.appendChild(newOption);
}

function removeOption(button) {
    const container = document.getElementById('options-container');
    if (container.children.length > 2) {
        button.closest('.input-group').remove();
    } else {
        alert('Minimal harus ada 2 pilihan voting');
    }
}

// Set default datetime values
document.addEventListener('DOMContentLoaded', function() {
    const now = new Date();
    const startTime = new Date(now.getTime() + 60 * 60 * 1000); // 1 hour from now
    const endTime = new Date(now.getTime() + 24 * 60 * 60 * 1000); // 24 hours from now
    
    document.getElementById('tanggal_mulai').value = startTime.toISOString().slice(0, 16);
    document.getElementById('tanggal_selesai').value = endTime.toISOString().slice(0, 16);
});
</script>
<?= $this->endSection() ?>
