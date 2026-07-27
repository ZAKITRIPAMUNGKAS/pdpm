<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-0">

    <!-- Unified Metric Summary Cards -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden h-100 border-start border-4 border-danger">
                <div class="card-body d-flex align-items-center p-3">
                    <div class="flex-shrink-0 bg-danger-subtle text-danger rounded-3 p-3 me-3">
                        <i class="bi bi-people-fill fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase fw-semibold fs-7 mb-1" style="letter-spacing: 0.5px;">Total Anggota Aktif</h6>
                        <h3 class="fw-bold mb-0 text-dark"><?= count($users) ?> <span class="fs-6 fw-normal text-muted">Orang</span></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden h-100 border-start border-4 border-danger">
                <div class="card-body d-flex align-items-center p-3">
                    <div class="flex-shrink-0 bg-danger-subtle text-danger rounded-3 p-3 me-3">
                        <i class="bi bi-shield-check fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase fw-semibold fs-7 mb-1" style="letter-spacing: 0.5px;">Anggota KOKAM</h6>
                        <?php $kokamCount = count(array_filter($users, fn($u) => ($u['is_kokam'] ?? 0) == 1)); ?>
                        <h3 class="fw-bold mb-0 text-dark"><?= $kokamCount ?> <span class="fs-6 fw-normal text-muted">Personel</span></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-12 col-xl-4">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden h-100 border-start border-4 border-warning">
                <div class="card-body d-flex align-items-center p-3">
                    <div class="flex-shrink-0 bg-warning-subtle text-warning-emphasis rounded-3 p-3 me-3">
                        <i class="bi bi-building fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase fw-semibold fs-7 mb-1" style="letter-spacing: 0.5px;">Filter Cabang Aktif</h6>
                        <h5 class="fw-bold mb-0 text-dark">
                            <?php 
                                if (!empty($selected_cabang)) {
                                    $matchedCabang = array_filter($cabang_list, fn($c) => $c['id'] == $selected_cabang);
                                    $firstMatch = reset($matchedCabang);
                                    echo esc($firstMatch['nama_cabang'] ?? 'Cabang Terpilih');
                                } else {
                                    echo 'Semua Cabang';
                                }
                            ?>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Toolbar Bar -->
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-body p-3">
            <form action="<?= site_url('manajemen-anggota') ?>" method="get" class="row g-2 align-items-center">
                <!-- Search Input Bar -->
                <div class="col-12 col-md-4 col-lg-5">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" id="memberSearch" class="form-control border-start-0 bg-light" placeholder="Cari nama, NBM, HP, email, alamat..." autocomplete="off">
                    </div>
                </div>

                <!-- Filter Cabang Dropdown -->
                <div class="col-12 col-sm-6 col-md-3 col-lg-3">
                    <select name="cabang_id" id="cabang_id" class="form-select bg-light" onchange="this.form.submit()">
                        <option value="">-- Semua Cabang --</option>
                        <?php foreach ($cabang_list as $cabang): ?>
                            <option value="<?= $cabang['id'] ?>" <?= ($selected_cabang == $cabang['id']) ? 'selected' : '' ?>>
                                PC <?= esc($cabang['nama_cabang']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Filter KOKAM Dropdown -->
                <div class="col-12 col-sm-6 col-md-3 col-lg-2">
                    <select name="is_kokam" id="is_kokam" class="form-select bg-light" onchange="this.form.submit()">
                        <option value="">-- Semua Type --</option>
                        <option value="1" <?= ($selected_kokam === '1') ? 'selected' : '' ?>>Anggota KOKAM</option>
                        <option value="0" <?= ($selected_kokam === '0') ? 'selected' : '' ?>>Non-KOKAM</option>
                    </select>
                </div>

                <!-- Action Button -->
                <div class="col-12 col-md-2 col-lg-2 text-md-end ms-auto">
                    <a href="<?= site_url('manajemen-anggota/export') . ($selected_cabang ? '?cabang_id=' . $selected_cabang : '') . ($selected_kokam !== '' ? ($selected_cabang ? '&' : '?') . 'is_kokam=' . $selected_kokam : '') ?>" 
                       class="btn btn-success w-100 fw-semibold d-inline-flex align-items-center justify-content-center gap-2 shadow-sm">
                        <i class="bi bi-file-earmark-excel-fill"></i> Ekspor Excel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Table Container -->
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 custom-pdpm-table">
                <thead>
                    <tr>
                        <th width="45" class="text-center">No</th>
                        <th width="65" class="text-center">Foto</th>
                        <th style="min-width: 170px;">Nama Lengkap</th>
                        <th style="min-width: 170px;">Email</th>
                        <th style="min-width: 140px;">No WhatsApp</th>
                        <th style="min-width: 120px;">NBM</th>
                        <th style="min-width: 110px;">Tgl Lahir</th>
                        <th style="min-width: 140px;">Tingkat Pimpinan</th>
                        <th style="min-width: 150px;">Jabatan Organisasi</th>
                        <th style="min-width: 220px; max-width: 300px;">Alamat Rumah</th>
                        <th width="100" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="memberTableBody">
                    <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="11" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                                Tidak ada data anggota yang ditemukan
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($users as $user): ?>
                            <tr>
                                <td class="text-center text-muted fw-semibold fs-7"><?= $no++ ?></td>
                                <td class="text-center">
                                    <img src="<?= base_url('uploads/profil/' . esc($user['foto'] ?? 'default.png')) ?>" 
                                         alt="Foto Profil" 
                                         class="rounded-circle shadow-sm avatar-img" 
                                         style="width: 42px; height: 42px; object-fit: cover;">
                                </td>
                                <td>
                                    <div class="fw-bold text-dark mb-0"><?= esc($user['nama_lengkap']) ?></div>
                                    <?php if (!empty($user['is_kokam']) && $user['is_kokam'] == 1): ?>
                                        <span class="badge bg-danger rounded-pill fs-8 mt-1">
                                            <i class="bi bi-shield-check me-1"></i>KOKAM
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="mailto:<?= esc($user['email']) ?>" class="member-email-link small">
                                        <i class="bi bi-envelope me-1 text-muted"></i><?= esc($user['email']) ?>
                                    </a>
                                </td>
                                <td>
                                    <?php if (!empty($user['nomor_telepon'])): ?>
                                        <a href="https://wa.me/<?= preg_replace('/^0/', '62', esc($user['nomor_telepon'])) ?>" 
                                           target="_blank" 
                                           class="btn btn-xs btn-outline-success rounded-pill px-2 py-1 text-decoration-none font-monospace small"
                                           title="Kirim Pesan WhatsApp">
                                            <i class="bi bi-whatsapp me-1"></i><?= esc($user['nomor_telepon']) ?>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted small">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="font-monospace text-dark small fw-medium"><?= esc($user['nbm'] ?? '-') ?></span>
                                </td>
                                <td>
                                    <span class="text-secondary small"><?= esc($user['tanggal_lahir'] ?? '-') ?></span>
                                </td>
                                <td>
                                    <?php 
                                        $tingkat_pimpinan = $user['tipe_pimpinan'] ?? '-';
                                        if ($tingkat_pimpinan === 'cabang' && !empty($user['nama_cabang'])) {
                                            echo '<span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill">PC ' . esc($user['nama_cabang']) . '</span>';
                                        } elseif ($tingkat_pimpinan === 'ranting' && !empty($user['nama_ranting'])) {
                                            echo '<span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill">PR ' . esc($user['nama_ranting']) . '</span>';
                                        } elseif ($tingkat_pimpinan === 'daerah') {
                                            echo '<span class="badge bg-dark-subtle text-dark border border-dark-subtle rounded-pill">PD Karanganyar</span>';
                                        } else {
                                            echo '<span class="text-muted">-</span>';
                                        }
                                    ?>
                                </td>
                                <td>
                                    <span class="small text-dark fw-medium"><?= esc($user['jabatan'] ?? '-') ?></span>
                                </td>
                                <td style="min-width: 220px; max-width: 300px; word-wrap: break-word; white-space: normal;">
                                    <span class="small text-muted d-block line-clamp-2"><?= esc($user['alamat_rumah'] ?? '-') ?></span>
                                </td>
                                <td class="text-center">
                                    <a href="<?= site_url('manajemen-anggota/edit/' . $user['id']) ?>" 
                                       class="btn btn-sm btn-outline-danger rounded-pill px-3 shadow-xs fw-medium" 
                                       title="Edit Data Anggota">
                                        <i class="bi bi-pencil-square me-1"></i>Edit
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<style>
    /* Unified PDPM Crimson Red Header Theme */
    .custom-pdpm-table thead th {
        background: linear-gradient(135deg, #dc3545, #b02a37) !important;
        color: #ffffff !important;
        font-weight: 600;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        padding: 14px 16px;
        border-bottom: 2px solid #a51d2a !important;
    }
    
    .custom-pdpm-table tbody td {
        padding: 12px 16px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
    }

    .custom-pdpm-table tbody tr:hover {
        background-color: rgba(220, 53, 69, 0.03) !important;
    }

    .member-email-link {
        color: #475569;
        text-decoration: none;
        transition: color 0.15s ease-in-out;
    }

    .member-email-link:hover {
        color: #dc3545;
        text-decoration: underline;
    }

    .avatar-img {
        transition: transform 0.2s ease-in-out;
    }

    .avatar-img:hover {
        transform: scale(1.15);
    }

    .fs-7 {
        font-size: 0.75rem;
    }
    .fs-8 {
        font-size: 0.7rem;
    }

    .btn-xs {
        font-size: 0.75rem;
        padding: 0.2rem 0.5rem;
    }

    .shadow-xs {
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    }

    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
</style>

<script>
    // Live Client-side Table Search
    document.getElementById('memberSearch').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase().trim();
        let rows = document.querySelectorAll('#memberTableBody tr');

        rows.forEach(row => {
            let text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
</script>

<?= $this->endSection() ?>
