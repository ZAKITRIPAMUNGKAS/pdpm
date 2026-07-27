<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Pendaftar Baru</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>Asal Cabang</th>
                    <th>Asal Ranting</th>
                    <th>Tanggal Daftar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($users)): ?>
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada pendaftar baru.</td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($users as $user): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= esc($user['nama_lengkap']) ?></td>
                            <td><?= esc($user['email']) ?></td>
                            <td><?= esc($user['nama_cabang']) ?></td>
                            <td><?= esc($user['nama_ranting']) ?></td>
                            <td><?= date('d M Y, H:i', strtotime($user['created_at'])) ?></td>
                            <td>
                                <a href="<?= site_url('verifikasi-anggota/setujui/' . $user['id']) ?>" class="btn btn-sm btn-success confirm-action" data-confirm-message="Apakah Anda yakin ingin menyetujui anggota ini?">
                                    <i class="bi bi-check-lg"></i> Setujui
                                </a>
                                <a href="<?= site_url('verifikasi-anggota/tolak/' . $user['id']) ?>" class="btn btn-sm btn-danger confirm-action" data-confirm-message="Apakah Anda yakin ingin menolak anggota ini?">
                                    <i class="bi bi-x-lg"></i> Tolak
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script nonce="<?= csp_script_nonce() ?>">
document.addEventListener('DOMContentLoaded', function() {
    const confirmActions = document.querySelectorAll('.confirm-action');
    confirmActions.forEach(button => {
        button.addEventListener('click', function(event) {
            const message = this.getAttribute('data-confirm-message');
            if (!confirm(message)) {
                event.preventDefault();
            }
        });
    });
});
</script>
<?= $this->endSection() ?>