<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Hapus Anggota</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>Cabang</th>
                                <th>Ranting</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user) : ?>
                                <tr>
                                    <td><?= esc($user['nama_lengkap']) ?></td>
                                    <td><?= esc($user['email']) ?></td>
                                    <td><?= esc($user['nama_cabang']) ?></td>
                                    <td><?= esc($user['nama_ranting']) ?></td>
                                    <td>
                                        <form action="<?= site_url('manajemen-anggota/delete/' . $user['id']) ?>" method="post" onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota ini?')">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
