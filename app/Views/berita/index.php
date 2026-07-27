<?= $this->extend('layout/template') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/admin-berita.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Berita</h3>
        <div class="card-tools">
            <a href="<?= site_url('admin-berita/create') ?>" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i> Tulis Berita Baru
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive-custom">
            <table class="table-berita">
                <thead>
                    <tr>
                        <th class="col-no">No</th>
                        <th class="col-image">Gambar</th>
                        <th class="col-title">Judul</th>
                        <th class="col-author">Penulis</th>
                        <th class="col-date">Tanggal Terbit</th>
                        <th class="col-actions">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($berita)): ?>
                        <tr class="empty-state-row">
                            <td colspan="6">
                                <i class="bi bi-newspaper" style="font-size: 3rem; color: #dee2e6;"></i>
                                <p class="mt-3 mb-0">Belum ada berita yang dipublikasikan</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($berita as $item): ?>
                            <tr>
                                <td class="col-no"><?= $no++ ?></td>
                                <td class="col-image">
                                    <?php if (!empty($item['gambar']) && file_exists(FCPATH . 'uploads/berita/' . $item['gambar'])): ?>
                                        <img src="/uploads/berita/<?= esc($item['gambar']) ?>" 
                                             alt="<?= esc($item['judul']) ?>" 
                                             class="berita-thumbnail"
                                             loading="lazy">
                                    <?php else: ?>
                                        <div class="berita-thumbnail d-flex align-items-center justify-content-center bg-light">
                                            <i class="bi bi-image text-muted" style="font-size: 2rem;"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="col-title">
                                    <div class="news-title-cell" title="<?= esc($item['judul']) ?>">
                                        <?= esc($item['judul']) ?>
                                    </div>
                                </td>
                                <td class="col-author">
                                    <span class="author-badge">
                                        <i class="bi bi-person-fill me-1"></i>
                                        <?= esc($item['nama_penulis']) ?>
                                    </span>
                                </td>
                                <td class="col-date">
                                    <span class="date-badge">
                                        <i class="bi bi-calendar-event me-1"></i>
                                        <?= date('d M Y', strtotime($item['created_at'])) ?>
                                    </span>
                                    <small class="d-block text-muted mt-1">
                                        <?= date('H:i', strtotime($item['created_at'])) ?> WIB
                                    </small>
                                </td>
                                <td class="col-actions">
                                    <div class="btn-action-group">
                                        <a href="<?= site_url('admin-berita/edit/' . $item['id']) ?>" 
                                           class="btn btn-sm btn-warning"
                                           title="Edit Berita">
                                            <i class="bi bi-pencil-square"></i> 
                                            <span>Edit</span>
                                        </a>
                                        <form action="<?= site_url('admin-berita/delete/' . $item['id']) ?>" 
                                              method="post" 
                                              class="d-inline confirm-action" 
                                              data-confirm-message="Apakah Anda yakin ingin menghapus berita ini?">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" 
                                                    class="btn btn-sm btn-danger"
                                                    title="Hapus Berita">
                                                <i class="bi bi-trash3"></i> 
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
