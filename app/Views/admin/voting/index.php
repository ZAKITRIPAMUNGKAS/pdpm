<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<style>
/* Button Action Container */
.action-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    align-items: center;
    justify-content: center;
    min-height: 40px;
}

.action-buttons .btn {
    width: 36px;
    height: 36px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    line-height: 1;
    flex-shrink: 0;
}

/* Icon + label pattern */
.action-buttons .btn .label { display: none; }
@media (min-width: 1200px) {
    .action-buttons .btn { width: auto; height: auto; padding: 0.25rem 0.5rem; }
    .action-buttons .btn .label { display: inline; margin-left: .35rem; }
}

/* Button Groups - Remove grouping for better layout */
.btn-group-primary,
.btn-group-secondary {
    display: contents; /* Makes children behave as if they're direct children of parent */
}

/* Responsive Design */
@media (max-width: 1200px) {
    .action-buttons {
        gap: 0.375rem;
    }
    
    .action-buttons .btn {
        width: 34px;
        height: 34px;
    }
}

@media (max-width: 992px) {
    .action-buttons {
        gap: 0.25rem;
        justify-content: flex-start;
    }
    
    .action-buttons .btn {
        width: 32px;
        height: 32px;
        font-size: 0.8rem;
    }
}

@media (max-width: 768px) {
    .action-buttons {
        flex-direction: row;
        flex-wrap: wrap;
        gap: 0.25rem;
        justify-content: center;
    }
    
    .action-buttons .btn {
        width: 36px;
        height: 36px;
    }
}

@media (max-width: 576px) {
    .action-buttons {
        gap: 0.2rem;
    }
    
    .action-buttons .btn {
        width: 30px;
        height: 30px;
        font-size: 0.75rem;
    }
}

/* Table Responsive */
@media (max-width: 992px) {
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .table th,
    .table td {
        padding: 0.5rem 0.25rem;
    }
}

/* Action Column Specific */
.table td:last-child {
    text-align: center;
    vertical-align: middle;
    white-space: nowrap;
}

/* Button Hover Effects */
.action-buttons .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: all 0.2s ease;
}

/* Button Focus States */
.action-buttons .btn:focus {
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
    outline: none;
}

/* Ensure consistent button alignment */
.action-buttons {
    white-space: nowrap;
}

/* Fix for table cell alignment */
.table td {
    vertical-align: middle;
}
</style>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $page_title ?></h1>
        <a href="<?= base_url('admin-voting/create') ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Buat Voting Formatur
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Voting</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['total_voting'] ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-ui-checks" style="font-size: 2rem; color: #d1d3e2;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Voting Aktif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['active_voting'] ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-play-circle" style="font-size: 2rem; color: #d1d3e2;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Voting Selesai</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['finished_voting'] ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-check-circle" style="font-size: 2rem; color: #d1d3e2;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Draft</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['draft_voting'] ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-pencil-square" style="font-size: 2rem; color: #d1d3e2;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Voting List -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Voting Formatur</h6>
        </div>
        <div class="card-body">
            <?php if (empty($voting_list)): ?>
                <div class="text-center py-4">
                    <i class="bi bi-ui-checks" style="font-size: 3rem; color: #d1d3e2;" class="mb-3"></i>
                    <p class="text-gray-500">Belum ada voting formatur yang dibuat.</p>
                    <a href="<?= base_url('admin-voting/create') ?>" class="btn btn-primary">Buat Voting Formatur Pertama</a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Formatur</th>
                                <th>Status</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Pembuat</th>
                                <th>Total Suara</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($voting_list as $voting): ?>
                                <tr>
                                    <td>
                                        <strong><?= esc($voting['judul']) ?></strong>
                                        <?php if (!empty($voting['deskripsi'])): ?>
                                            <br><small class="text-muted"><?= esc(character_limiter($voting['deskripsi'], 50)) ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">
                                            <?= $voting['required_selections'] ?? 9 ?> formatur
                                        </span>
                                    </td>
                                    <td>
                                        <?php
                                        $statusClass = [
                                            'draft' => 'badge-secondary',
                                            'aktif' => 'badge-success',
                                            'selesai' => 'badge-info',
                                            'dibatalkan' => 'badge-danger'
                                        ];
                                        $statusText = [
                                            'draft' => 'Draft',
                                            'aktif' => 'Aktif',
                                            'selesai' => 'Selesai',
                                            'dibatalkan' => 'Dibatalkan'
                                        ];
                                        ?>
                                        <span class="badge <?= $statusClass[$voting['status']] ?>">
                                            <?= $statusText[$voting['status']] ?>
                                        </span>
                                    </td>
                                    <td><?= date('d/m/Y H:i', strtotime($voting['tanggal_mulai'])) ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($voting['tanggal_selesai'])) ?></td>
                                    <td><?= esc($voting['creator_name']) ?></td>
                                    <td>
                                        <span class="badge badge-primary"><?= $voting['total_voters'] ?> pemilih</span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <!-- Lihat Detail - Always visible -->
                                            <a href="<?= base_url('admin-voting/' . $voting['id']) ?>" 
                                               class="btn btn-info" title="Lihat Detail" data-bs-toggle="tooltip" data-bs-placement="top">
                                                <i class="bi bi-eye"></i><span class="label">Lihat</span>
                                            </a>
                                            
                                            <!-- Edit - Only for draft -->
                                            <?php if ($voting['status'] === 'draft'): ?>
                                                <a href="<?= base_url('admin-voting/edit/' . $voting['id']) ?>" 
                                                   class="btn btn-warning" title="Edit" data-bs-toggle="tooltip" data-bs-placement="top">
                                                    <i class="bi bi-pencil"></i><span class="label">Edit</span>
                                                </a>
                                            <?php endif; ?>
                                            
                                            <!-- Aktifkan - Only for draft -->
                                            <?php if ($voting['status'] === 'draft'): ?>
                                                <button type="button" class="btn btn-success" 
                                                        onclick="changeStatus(<?= $voting['id'] ?>, 'aktif')" 
                                                        title="Aktifkan" data-bs-toggle="tooltip" data-bs-placement="top">
                                                    <i class="bi bi-play-fill"></i><span class="label">Aktifkan</span>
                                                </button>
                                            <?php endif; ?>
                                            
                                            <!-- Selesaikan - Only for active -->
                                            <?php if ($voting['status'] === 'aktif'): ?>
                                                <button type="button" class="btn btn-warning" 
                                                        onclick="changeStatus(<?= $voting['id'] ?>, 'selesai')" 
                                                        title="Selesaikan" data-bs-toggle="tooltip" data-bs-placement="top">
                                                    <i class="bi bi-check-circle"></i><span class="label">Selesai</span>
                                                </button>
                                            <?php endif; ?>
                                            
                                            <!-- Batalkan - For draft and active -->
                                            <?php if (in_array($voting['status'], ['draft', 'aktif'])): ?>
                                                <button type="button" class="btn btn-danger" 
                                                        onclick="changeStatus(<?= $voting['id'] ?>, 'dibatalkan')" 
                                                        title="Batalkan" data-bs-toggle="tooltip" data-bs-placement="top">
                                                    <i class="bi bi-x"></i><span class="label">Batal</span>
                                                </button>
                                            <?php endif; ?>
                                            
                                            <!-- Hapus - Only for draft -->
                                            <?php if ($voting['status'] === 'draft'): ?>
                                                <button type="button" class="btn btn-outline-danger" 
                                                        onclick="deleteVoting(<?= $voting['id'] ?>)" 
                                                        title="Hapus" data-bs-toggle="tooltip" data-bs-placement="top">
                                                    <i class="bi bi-trash3"></i><span class="label">Hapus</span>
                                                </button>
                                            <?php endif; ?>
                                            
                                            <!-- Export - For finished and cancelled -->
                                            <?php if (in_array($voting['status'], ['selesai', 'dibatalkan'])): ?>
                                                <a href="<?= base_url('admin-voting/export/' . $voting['id']) ?>" 
                                                   class="btn btn-secondary" title="Export" data-bs-toggle="tooltip" data-bs-placement="top">
                                                    <i class="bi bi-download"></i><span class="label">Export</span>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Status Change Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Status Voting</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="statusForm" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <input type="hidden" name="status" id="newStatus">
                    <p>Apakah Anda yakin ingin mengubah status voting ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Ya, Ubah Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Voting</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus voting ini? Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="post" class="d-inline">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function changeStatus(votingId, newStatus) {
    document.getElementById('newStatus').value = newStatus;
    document.getElementById('statusForm').action = '<?= base_url('admin-voting/status/') ?>' + votingId;
    var statusModal = new bootstrap.Modal(document.getElementById('statusModal'));
    statusModal.show();
}

function deleteVoting(votingId) {
    var form = document.getElementById('deleteForm');
    form.action = '<?= base_url('admin-voting/delete/') ?>' + votingId;
    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

// Initialize Bootstrap 5 tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
<?= $this->endSection() ?>

