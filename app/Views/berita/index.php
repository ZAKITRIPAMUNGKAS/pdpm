<?= $this->extend('layout/template') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/admin-berita.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="berita-page-header">
    <div class="berita-page-header-left">
        <div class="berita-page-icon">
            <i class="bi bi-newspaper"></i>
        </div>
        <div>
            <h1 class="berita-page-title">Manajemen Berita</h1>
            <p class="berita-page-sub">Kelola artikel dan publikasi PDPM Karanganyar</p>
        </div>
    </div>
    <a href="<?= site_url('admin-berita/create') ?>" class="btn-berita-primary">
        <i class="bi bi-plus-lg"></i>
        <span>Tulis Berita Baru</span>
    </a>
</div>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="berita-alert berita-alert-success">
        <i class="bi bi-check-circle-fill"></i>
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="berita-alert berita-alert-danger">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<!-- Content Card -->
<div class="berita-card">

    <!-- Stats Row -->
    <?php if (!empty($berita)): ?>
    <div class="berita-stats-row">
        <div class="berita-stat-pill">
            <i class="bi bi-journals"></i>
            <strong><?= count($berita) ?></strong> Berita Terbit
        </div>
        <div class="berita-search-wrap">
            <i class="bi bi-search berita-search-icon"></i>
            <input type="text" id="beritaSearch" class="berita-search-input" placeholder="Cari judul berita...">
        </div>
    </div>
    <?php endif; ?>

    <!-- Table -->
    <div class="berita-table-wrap">
        <?php if (empty($berita)): ?>
            <!-- Empty State -->
            <div class="berita-empty">
                <div class="berita-empty-icon">
                    <i class="bi bi-newspaper"></i>
                </div>
                <h5>Belum Ada Berita</h5>
                <p>Mulai tulis artikel pertama untuk dipublikasikan</p>
                <a href="<?= site_url('admin-berita/create') ?>" class="btn-berita-primary">
                    <i class="bi bi-plus-lg"></i> Tulis Sekarang
                </a>
            </div>
        <?php else: ?>
        <table class="berita-table" id="beritaTable">
            <thead>
                <tr>
                    <th class="th-no">No</th>
                    <th class="th-img">Gambar</th>
                    <th class="th-title">Judul Berita</th>
                    <th class="th-author">Penulis</th>
                    <th class="th-date">Tanggal Terbit</th>
                    <th class="th-action">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($berita as $item): ?>
                <tr class="berita-row" data-search="<?= strtolower(esc($item['judul'])) ?>">
                    <!-- No -->
                    <td class="td-no">
                        <span class="berita-no"><?= $no++ ?></span>
                    </td>

                    <!-- Gambar -->
                    <td class="td-img">
                        <?php if (!empty($item['gambar']) && file_exists(FCPATH . 'uploads/berita/' . $item['gambar'])): ?>
                            <img src="/uploads/berita/<?= esc($item['gambar']) ?>"
                                 alt="<?= esc($item['judul']) ?>"
                                 class="berita-thumb"
                                 loading="lazy">
                        <?php else: ?>
                            <div class="berita-thumb-placeholder">
                                <i class="bi bi-image"></i>
                            </div>
                        <?php endif; ?>
                    </td>

                    <!-- Judul -->
                    <td class="td-title">
                        <div class="berita-title-text" title="<?= esc($item['judul']) ?>">
                            <?= esc($item['judul']) ?>
                        </div>
                        <div class="berita-slug">
                            <i class="bi bi-link-45deg"></i>
                            <?= esc($item['slug'] ?? '') ?>
                        </div>
                    </td>

                    <!-- Penulis -->
                    <td class="td-author">
                        <div class="berita-author">
                            <div class="berita-author-avatar">
                                <?= strtoupper(substr($item['nama_penulis'] ?? 'A', 0, 1)) ?>
                            </div>
                            <span><?= esc($item['nama_penulis']) ?></span>
                        </div>
                    </td>

                    <!-- Tanggal -->
                    <td class="td-date">
                        <div class="berita-date">
                            <i class="bi bi-calendar3"></i>
                            <?= date('d M Y', strtotime($item['created_at'])) ?>
                        </div>
                        <div class="berita-time">
                            <i class="bi bi-clock"></i>
                            <?= date('H:i', strtotime($item['created_at'])) ?> WIB
                        </div>
                    </td>

                    <!-- Aksi -->
                    <td class="td-action">
                        <div class="berita-actions">
                            <a href="<?= site_url('admin-berita/edit/' . $item['id']) ?>"
                               class="btn-action btn-edit"
                               title="Edit Berita">
                                <i class="bi bi-pencil-square"></i>
                                <span>Edit</span>
                            </a>
                            <form action="<?= site_url('admin-berita/delete/' . $item['id']) ?>"
                                  method="post"
                                  class="d-inline confirm-delete-form">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit"
                                        class="btn-action btn-hapus"
                                        title="Hapus Berita">
                                    <i class="bi bi-trash3"></i>
                                    <span>Hapus</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- No search result -->
        <div class="berita-empty d-none" id="beritaNoResult">
            <div class="berita-empty-icon">
                <i class="bi bi-search"></i>
            </div>
            <h5>Berita Tidak Ditemukan</h5>
            <p>Coba kata kunci yang berbeda</p>
        </div>
        <?php endif; ?>
    </div>

    <!-- Footer Count -->
    <?php if (!empty($berita)): ?>
    <div class="berita-footer">
        Menampilkan <strong id="beritaShownCount"><?= count($berita) ?></strong> dari <?= count($berita) ?> berita
    </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
(function() {
    var searchInput = document.getElementById('beritaSearch');
    var table       = document.getElementById('beritaTable');
    var noResult    = document.getElementById('beritaNoResult');
    var countEl     = document.getElementById('beritaShownCount');

    if (!searchInput || !table) return;

    searchInput.addEventListener('input', function() {
        var q    = this.value.toLowerCase().trim();
        var rows = table.querySelectorAll('tbody .berita-row');
        var shown = 0;

        rows.forEach(function(row) {
            var txt = row.dataset.search || '';
            if (txt.includes(q)) {
                row.style.display = '';
                shown++;
            } else {
                row.style.display = 'none';
            }
        });

        if (noResult) noResult.classList.toggle('d-none', shown > 0);
        if (countEl)  countEl.textContent = shown;
    });

    // Confirm delete
    document.querySelectorAll('.confirm-delete-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            if (!confirm('Yakin ingin menghapus berita ini? Tindakan tidak bisa dibatalkan.')) {
                e.preventDefault();
            }
        });
    });
})();
</script>
<?= $this->endSection() ?>
