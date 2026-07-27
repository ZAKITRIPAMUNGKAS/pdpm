<?= $this->extend('layout/template') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/dashboard.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="modern-card shadow-sm border-0 rounded-4 mb-4">
    <div class="card-header bg-light border-bottom-0">
        <h5 class="text-dark"><i class="bi bi-person-plus-fill me-2"></i><?= $page_title ?? 'Tambah Anggota Struktur' ?></h5>
    </div>
    <div class="card-body p-4">
        <?php if (session()->getFlashdata('errors')) : ?>
            <div class="alert alert-danger" role="alert">
                <ul class="mb-0">
                    <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('admin/cabang/struktur/store') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama:</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?= old('nama') ?>">
            </div>

            <div class="mb-3">
                <label for="jabatan" class="form-label">Jabatan:</label>
                <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?= old('jabatan') ?>">
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Foto:</label>
                <input type="file" class="form-control" id="foto" name="foto">
            </div>

            <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Simpan Anggota Struktur</button>
            <a href="<?= base_url('admin/cabang/struktur') ?>" class="btn btn-secondary ms-2"><i class="bi bi-arrow-left-circle me-2"></i>Kembali ke Daftar Struktur</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>