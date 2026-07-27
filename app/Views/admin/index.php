<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Admin</h3>
        <div class="card-tools">
            <a href="<?= site_url('admin/create') ?>" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i> Tambah Admin
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>Admin Cabang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($admins)): ?>
                    <tr>
                        <td colspan="5" class="text-center">Belum ada data admin.</td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($admins as $admin): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= esc($admin['nama_lengkap']) ?></td>
                            <td><?= esc($admin['email']) ?></td>
                            <td><?= esc($admin['nama_cabang']) ?></td>
                            <td>
                                <a href="<?= site_url('admin/edit/' . $admin['id']) ?>" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="<?= site_url('admin/delete/' . $admin['id']) ?>" method="post" class="d-inline confirm-action" data-confirm-message="Apakah Anda yakin ingin menghapus admin ini?">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash3"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
