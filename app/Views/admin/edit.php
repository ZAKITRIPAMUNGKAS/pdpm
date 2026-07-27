<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?= $page_title ?? 'Form Edit Admin' ?></h3>
    </div>
    <div class="card-body">
        <?php $errors = session()->get('errors'); ?>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
                </ul>
            </div>
        <?php endif ?>

        <form action="<?= site_url('admin/update/' . ($admin['id'] ?? '')) ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?= old('nama_lengkap', $admin['nama_lengkap'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= old('email', $admin['email'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label for="id_cabang" class="form-label">Tugaskan ke Cabang</label>
                <select class="form-select" id="id_cabang" name="id_cabang" required>
                    <option value="">-- Pilih Cabang --</option>
                    <?php foreach ($cabang as $c): ?>
                        <option value="<?= $c['id'] ?>" <?= old('id_cabang', $admin['id_cabang'] ?? '') == $c['id'] ? 'selected' : '' ?>><?= $c['nama_cabang'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <hr>
            <p class="text-muted">Kosongkan bagian password jika tidak ingin mengubahnya.</p>
            <div class="mb-3">
                <label for="password" class="form-label">Password Baru</label>
                <input type="password" class="form-control" id="password" name="password" autocomplete="new-password">
            </div>
            <div class="mb-3">
                <label for="pass_confirm" class="form-label">Konfirmasi Password Baru</label>
                <input type="password" class="form-control" id="pass_confirm" name="pass_confirm" autocomplete="new-password">
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="<?= site_url('admin') ?>" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>