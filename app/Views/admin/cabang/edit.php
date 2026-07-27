<?= $this->extend('layout/template') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/dashboard.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="modern-card shadow-sm border-0 rounded-4 mb-4">
    <div class="card-header bg-light border-bottom-0">
        <h5 class="text-dark"><i class="bi bi-building me-2"></i><?= $page_title ?? 'Edit Data Cabang Anda' ?></h5>
    </div>
    <div class="card-body p-4">
        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success" role="alert"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('errors')) : ?>
            <div class="alert alert-danger" role="alert">
                <ul class="mb-0">
                    <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('admin/cabang/update') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="nama_cabang" class="form-label">Nama Cabang:</label>
                <input type="text" class="form-control" id="nama_cabang" name="nama_cabang" value="<?= old('nama_cabang', $cabang['nama_cabang'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label for="nama_ketua" class="form-label">Nama Ketua:</label>
                <input type="text" class="form-control" id="nama_ketua" name="nama_ketua" value="<?= old('nama_ketua', $cabang['nama_ketua'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label for="nama_sekretaris" class="form-label">Nama Sekretaris:</label>
                <input type="text" class="form-control" id="nama_sekretaris" name="nama_sekretaris" value="<?= old('nama_sekretaris', $cabang['nama_sekretaris'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label for="nama_bendahara" class="form-label">Nama Bendahara:</label>
                <input type="text" class="form-control" id="nama_bendahara" name="nama_bendahara" value="<?= old('nama_bendahara', $cabang['nama_bendahara'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label for="cp_cabang" class="form-label">Contact Person Cabang (Telepon):</label>
                <input type="text" class="form-control" id="cp_cabang" name="cp_cabang" value="<?= old('cp_cabang', $cabang['cp_cabang'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label for="email_cabang" class="form-label">Email Cabang:</label>
                <input type="email" class="form-control" id="email_cabang" name="email_cabang" value="<?= old('email_cabang', $cabang['email_cabang'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label for="alamat_sekretariat" class="form-label">Alamat Sekretariat:</label>
                <textarea class="form-control" id="alamat_sekretariat" name="alamat_sekretariat" rows="3"><?= old('alamat_sekretariat', $cabang['alamat_sekretariat'] ?? '') ?></textarea>
            </div>

            <div class="mb-3">
                <label for="deskripsi_cabang" class="form-label">Deskripsi Cabang:</label>
                <textarea class="form-control" id="deskripsi_cabang" name="deskripsi_cabang" rows="5"><?= old('deskripsi_cabang', $cabang['deskripsi_cabang'] ?? '') ?></textarea>
            </div>

            <div class="mb-3">
                <label for="instagram" class="form-label">Instagram URL:</label>
                <input type="url" class="form-control" id="instagram" name="instagram" value="<?= old('instagram', $cabang['instagram'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label for="facebook" class="form-label">Facebook URL:</label>
                <input type="url" class="form-control" id="facebook" name="facebook" value="<?= old('facebook', $cabang['facebook'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label for="twitter" class="form-label">Twitter URL:</label>
                <input type="url" class="form-control" id="twitter" name="twitter" value="<?= old('twitter', $cabang['twitter'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label for="youtube" class="form-label">Youtube URL:</label>
                <input type="url" class="form-control" id="youtube" name="youtube" value="<?= old('youtube', $cabang['youtube'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label for="website" class="form-label">Website URL:</label>
                <input type="url" class="form-control" id="website" name="website" value="<?= old('website', $cabang['website'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label for="foto_sekretariat" class="form-label">Foto Sekretariat:</label>
                <?php if (!empty($cabang['foto_sekretariat'])) : ?>
                    <div class="mb-2">
                        <img src="<?= base_url('uploads/cabang/' . $cabang['foto_sekretariat']) ?>" alt="Current Image" class="img-thumbnail" width="150">
                    </div>
                <?php endif; ?>
                <input type="file" class="form-control" id="foto_sekretariat" name="foto_sekretariat">
            </div>

            <button type="submit" class="btn btn-primary">Update Data Cabang</button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>