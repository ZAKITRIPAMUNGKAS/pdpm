<?= $this->extend('layout/template') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/dashboard.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="modern-card shadow-sm border-0 rounded-4 mb-4">
    <div class="card-header bg-light border-bottom-0">
        <h5 class="text-dark"><i class="bi bi-people-fill me-2"></i><?= $page_title ?? 'Struktur Cabang Anda' ?></h5>
    </div>
    <div class="card-body p-4">
        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success" role="alert"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger" role="alert"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <div class="d-flex justify-content-between mb-3">
            <a href="<?= base_url('admin/cabang/struktur/create') ?>" class="btn btn-primary"><i class="bi bi-plus-circle me-2"></i>Tambah Anggota Struktur Baru</a>
            <a href="<?= base_url('admin/cabang/edit') ?>" class="btn btn-secondary"><i class="bi bi-arrow-left-circle me-2"></i>Kembali ke Edit Data Cabang</a>
        </div>

        <?php if (!empty($struktur_list)) : ?>
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($struktur_list as $struktur) : ?>
                            <tr>
                                <td class="align-middle">
                                    <?php if (!empty($struktur['foto'])) : ?>
                                        <img src="<?= base_url('uploads/struktur/' . $struktur['foto']) ?>" alt="<?= $struktur['nama'] ?>" class="img-thumbnail" width="70">
                                    <?php else : ?>
                                        <img src="<?= base_url('default.png') ?>" alt="No Photo" class="img-thumbnail" width="70">
                                    <?php endif; ?>
                                </td>
                                <td class="align-middle"><?= esc($struktur['nama']) ?></td>
                                <td class="align-middle"><?= esc($struktur['jabatan']) ?></td>
                                <td class="align-middle">
                                    <a href="<?= base_url('admin/cabang/struktur/edit/' . $struktur['id']) ?>" class="btn btn-sm btn-warning me-2"><i class="bi bi-pencil"></i> Edit</a>
                                    <form action="<?= base_url('admin/cabang/struktur/delete/' . $struktur['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota struktur ini?');">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else : ?>
            <div class="alert alert-info text-center" role="alert">
                Belum ada anggota struktur yang ditambahkan.
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>