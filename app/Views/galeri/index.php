<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<!-- Form Unggah Foto -->
<div class="card card-primary mb-4">
    <div class="card-header">
        <h3 class="card-title">Unggah Foto Baru</h3>
    </div>
    <div class="card-body">
        <?php $errors = session()->get('errors'); ?>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <strong>Perhatian!</strong> Terdapat beberapa kesalahan:
                <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
                </ul>
            </div>
        <?php endif ?>

        <form action="<?= site_url('admin-galeri/store') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="judul" class="form-label">Judul/Keterangan Foto</label>
                <input type="text" class="form-control" id="judul" name="judul" value="<?= old('judul') ?>" required>
            </div>
            <div class="mb-3">
                <label for="kategori" class="form-label">Kategori</label>
                <select class="form-select" id="kategori" name="kategori" required>
                    <option value="">Pilih Kategori</option>
                    <option value="kegiatan" <?= old('kategori') == 'kegiatan' ? 'selected' : '' ?>>Kegiatan</option>
                    <option value="rapat" <?= old('kategori') == 'rapat' ? 'selected' : '' ?>>Rapat</option>
                    <option value="pelatihan" <?= old('kategori') == 'pelatihan' ? 'selected' : '' ?>>Pelatihan</option>
                    <option value="lainnya" <?= old('kategori') == 'lainnya' ? 'selected' : '' ?>>Lainnya</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">Pilih File Foto</label>
                <input class="form-control" type="file" id="gambar" name="gambar" required>
                <small class="form-text text-muted">Ukuran maksimal 2MB. Format: JPG, JPEG, PNG.</small>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-upload"></i> Unggah Sekarang
            </button>
        </form>
    </div>
</div>

<!-- Daftar Foto yang Sudah Diunggah -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Koleksi Galeri</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <?php if (empty($galeri)): ?>
                <div class="col-12">
                    <p class="text-center">Belum ada foto di galeri.</p>
                </div>
            <?php else: ?>
                <?php foreach ($galeri as $item): ?>
                    <div class="col-md-4 col-lg-3 mb-4">
                        <div class="card h-100">
                            <img src="/uploads/galeri/<?= esc($item['file_path']) ?>" class="card-img-top" alt="<?= esc($item['judul']) ?>" style="height: 180px; object-fit: cover;">
                            <div class="card-body">
                                <p class="card-text"><?= esc($item['judul']) ?></p>
                            </div>
                            <div class="card-footer text-center">
                                <form action="<?= site_url('admin-galeri/delete/' . $item['id']) ?>" method="post" onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto ini?');">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash3"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
