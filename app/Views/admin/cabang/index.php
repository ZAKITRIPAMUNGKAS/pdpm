<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Cabang</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Cabang</th>
                                <th>Ketua</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cabang_list as $cabang) : ?>
                                <tr>
                                    <td><?= esc($cabang['id']) ?></td>
                                    <td><?= esc($cabang['nama_cabang']) ?></td>
                                    <td><?= esc($cabang['nama_ketua']) ?></td>
                                    <td>
                                        <?php if ($cabang['is_completed']) : ?>
                                            <span class="badge bg-success">Lengkap</span>
                                        <?php else : ?>
                                            <span class="badge bg-warning">Belum Lengkap</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-info btn-sm">Detail</a>
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
