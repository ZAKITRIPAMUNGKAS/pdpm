<?= $this->extend('layout/template') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/admin-agenda.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Header Section -->
<div class="agenda-header-section mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h2 class="agenda-title mb-2">
                <i class="bi bi-calendar-event text-danger me-2"></i>
                Daftar Agenda Kegiatan
            </h2>
            <p class="text-muted mb-0">
                Kelola agenda kegiatan PDPM Karanganyar
            </p>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <a href="<?= site_url('admin-agenda/create') ?>" class="btn btn-danger btn-create-agenda">
                <i class="bi bi-plus-circle me-2"></i>
                Buat Agenda Baru
            </a>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card-mini bg-danger">
            <div class="stat-content">
                <div class="stat-icon">
                    <i class="bi bi-calendar-check"></i>
                </div>
                <div class="stat-details">
                    <h4><?= count(array_filter($agenda ?? [], function($item) { 
                        return strtotime($item['tanggal_mulai']) > time(); 
                    })) ?></h4>
                    <p>Akan Datang</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card-mini bg-warning">
            <div class="stat-content">
                <div class="stat-icon">
                    <i class="bi bi-calendar-event"></i>
                </div>
                <div class="stat-details">
                    <h4><?= count(array_filter($agenda ?? [], function($item) { 
                        $start = strtotime($item['tanggal_mulai']);
                        $end = $item['tanggal_selesai'] ? strtotime($item['tanggal_selesai']) : $start;
                        $now = time();
                        return $start <= $now && $end >= $now; 
                    })) ?></h4>
                    <p>Sedang Berlangsung</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card-mini bg-success">
            <div class="stat-content">
                <div class="stat-icon">
                    <i class="bi bi-building"></i>
                </div>
                <div class="stat-details">
                    <h4><?= count(array_filter($agenda ?? [], function($item) { 
                        return ($item['tingkat_agenda'] ?? 'daerah') == 'daerah'; 
                    })) ?></h4>
                    <p>Agenda Daerah</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stat-card-mini bg-info">
            <div class="stat-content">
                <div class="stat-icon">
                    <i class="bi bi-geo-alt"></i>
                </div>
                <div class="stat-details">
                    <h4><?= count(array_filter($agenda ?? [], function($item) { 
                        return ($item['tingkat_agenda'] ?? 'daerah') == 'cabang'; 
                    })) ?></h4>
                    <p>Agenda Cabang</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="filter-section mb-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" id="searchAgenda" 
                               placeholder="Cari nama kegiatan...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="filterTingkat">
                        <option value="">Semua Tingkat</option>
                        <option value="daerah">Agenda Daerah</option>
                        <option value="cabang">Agenda Cabang</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="filterStatus">
                        <option value="">Semua Status</option>
                        <option value="upcoming">Akan Datang</option>
                        <option value="ongoing">Sedang Berlangsung</option>
                        <option value="past">Sudah Selesai</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-secondary w-100" onclick="resetFilters()">
                        <i class="bi bi-arrow-clockwise me-1"></i> Reset
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Agenda List -->
<div class="agenda-list">
    <?php if (empty($agenda)): ?>
        <!-- Empty State -->
        <div class="empty-state-container">
            <div class="empty-state-icon">
                <i class="bi bi-calendar-x"></i>
            </div>
            <h4>Belum Ada Agenda</h4>
            <p class="text-muted">Mulai buat agenda kegiatan untuk organisasi</p>
            <a href="<?= site_url('admin-agenda/create') ?>" class="btn btn-danger mt-3">
                <i class="bi bi-plus-circle me-2"></i>Buat Agenda Pertama
            </a>
        </div>
    <?php else: ?>
        <div class="row" id="agendaContainer">
            <?php foreach ($agenda as $item): 
                $now = time();
                $start = strtotime($item['tanggal_mulai']);
                $end = $item['tanggal_selesai'] ? strtotime($item['tanggal_selesai']) : $start;
                
                // Determine status
                $status = '';
                $statusClass = '';
                $statusIcon = '';
                if ($start > $now) {
                    $status = 'upcoming';
                    $statusClass = 'status-upcoming';
                    $statusIcon = 'bi-clock-history';
                    $statusText = 'Akan Datang';
                } elseif ($start <= $now && $end >= $now) {
                    $status = 'ongoing';
                    $statusClass = 'status-ongoing';
                    $statusIcon = 'bi-broadcast';
                    $statusText = 'Berlangsung';
                } else {
                    $status = 'past';
                    $statusClass = 'status-past';
                    $statusIcon = 'bi-check-circle';
                    $statusText = 'Selesai';
                }
                
                $tingkat = $item['tingkat_agenda'] ?? 'daerah';
            ?>
            <div class="col-lg-6 mb-4 agenda-item" 
                 data-nama="<?= strtolower(esc($item['nama_kegiatan'])) ?>"
                 data-tingkat="<?= $tingkat ?>"
                 data-status="<?= $status ?>">
                <div class="agenda-card <?= $statusClass ?>">
                    <!-- Card Header with Status -->
                    <div class="agenda-card-header">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="status-badge <?= $statusClass ?>">
                                    <i class="bi <?= $statusIcon ?> me-1"></i>
                                    <?= $statusText ?>
                                </span>
                                <?php if ($tingkat == 'daerah'): ?>
                                    <span class="level-badge level-daerah">
                                        <i class="bi bi-building me-1"></i>DAERAH
                                    </span>
                                <?php else: ?>
                                    <span class="level-badge level-cabang">
                                        <i class="bi bi-geo-alt me-1"></i>CABANG
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-link text-muted p-0" type="button" 
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="<?= site_url('admin-agenda/edit/' . $item['id']) ?>">
                                            <i class="bi bi-pencil me-2"></i>Edit
                                        </a>
                                    </li>
                                    <li>
                                        <form action="<?= site_url('admin-agenda/delete/' . $item['id']) ?>" 
                                              method="post" class="d-inline" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus agenda ini?');">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bi bi-trash me-2"></i>Hapus
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Card Body -->
                    <div class="agenda-card-body">
                        <h5 class="agenda-title"><?= esc($item['nama_kegiatan']) ?></h5>
                        
                        <!-- Date and Time -->
                        <div class="agenda-datetime mb-3">
                            <div class="datetime-item">
                                <i class="bi bi-calendar2-event text-danger"></i>
                                <div>
                                    <small class="text-muted d-block">Mulai</small>
                                    <span><?= date('d M Y', $start) ?></span>
                                    <span class="text-muted ms-1"><?= date('H:i', $start) ?></span>
                                </div>
                            </div>
                            <?php if ($item['tanggal_selesai']): ?>
                            <div class="datetime-item">
                                <i class="bi bi-calendar2-check text-success"></i>
                                <div>
                                    <small class="text-muted d-block">Selesai</small>
                                    <span><?= date('d M Y', $end) ?></span>
                                    <span class="text-muted ms-1"><?= date('H:i', $end) ?></span>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Location -->
                        <div class="agenda-info-item">
                            <i class="bi bi-geo-alt-fill text-warning"></i>
                            <span><?= esc($item['lokasi']) ?></span>
                        </div>
                        
                        <!-- Branch Info (if applicable) -->
                        <?php if ($tingkat == 'cabang' && !empty($item['nama_cabang'])): ?>
                        <div class="agenda-info-item">
                            <i class="bi bi-building text-info"></i>
                            <span>
                                <?= esc($item['nama_cabang']) ?>
                                <?php if (!empty($item['wilayah_cabang'])): ?>
                                    <small class="text-muted">(<?= esc($item['wilayah_cabang']) ?>)</small>
                                <?php endif; ?>
                            </span>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Author -->
                        <div class="agenda-info-item">
                            <i class="bi bi-person-circle text-secondary"></i>
                            <span>
                                <small class="text-muted">Dibuat oleh:</small>
                                <?= esc($item['nama_penulis']) ?>
                            </span>
                        </div>
                        
                        <!-- Attendance Radius -->
                        <div class="agenda-info-item">
                            <i class="bi bi-radar text-primary"></i>
                            <span>
                                <small class="text-muted">Radius absensi:</small>
                                <?= $item['radius_meter'] ?> meter
                            </span>
                        </div>
                    </div>
                    
                    <!-- Card Footer with Actions -->
                    <div class="agenda-card-footer">
                        <div class="btn-group w-100" role="group">
                            <a href="<?= site_url('admin-agenda/edit/' . $item['id']) ?>" 
                               class="btn btn-outline-warning btn-sm">
                                <i class="bi bi-pencil me-1"></i>Edit
                            </a>
                            <a href="<?= site_url('absensi/agenda/' . $item['id']) ?>" class="btn btn-outline-info btn-sm">
                                <i class="bi bi-eye me-1"></i>Detail
                            </a>
                            <form action="<?= site_url('admin-agenda/delete/' . $item['id']) ?>" 
                                  method="post" class="d-inline flex-fill" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus agenda ini?');">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                    <i class="bi bi-trash me-1"></i>Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- No Results Message (hidden by default) -->
        <div id="noResults" class="text-center py-5" style="display: none;">
            <i class="bi bi-search fs-1 text-muted"></i>
            <h5 class="mt-3">Tidak ada agenda yang sesuai</h5>
            <p class="text-muted">Coba ubah filter atau kata kunci pencarian</p>
        </div>
    <?php endif; ?>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="bi bi-calendar-event me-2"></i>Detail Agenda
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalContent">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchAgenda');
    const filterTingkat = document.getElementById('filterTingkat');
    const filterStatus = document.getElementById('filterStatus');
    const agendaItems = document.querySelectorAll('.agenda-item');
    const noResults = document.getElementById('noResults');
    
    function filterAgenda() {
        const searchTerm = searchInput.value.toLowerCase();
        const tingkatValue = filterTingkat.value;
        const statusValue = filterStatus.value;
        let visibleCount = 0;
        
        agendaItems.forEach(item => {
            const nama = item.dataset.nama;
            const tingkat = item.dataset.tingkat;
            const status = item.dataset.status;
            
            const matchSearch = !searchTerm || nama.includes(searchTerm);
            const matchTingkat = !tingkatValue || tingkat === tingkatValue;
            const matchStatus = !statusValue || status === statusValue;
            
            if (matchSearch && matchTingkat && matchStatus) {
                item.style.display = '';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });
        
        // Show/hide no results message
        if (noResults) {
            noResults.style.display = visibleCount === 0 ? 'block' : 'none';
        }
    }
    
    // Add event listeners
    searchInput?.addEventListener('input', filterAgenda);
    filterTingkat?.addEventListener('change', filterAgenda);
    filterStatus?.addEventListener('change', filterAgenda);
});

// Reset filters
function resetFilters() {
    document.getElementById('searchAgenda').value = '';
    document.getElementById('filterTingkat').value = '';
    document.getElementById('filterStatus').value = '';
    
    // Show all items
    document.querySelectorAll('.agenda-item').forEach(item => {
        item.style.display = '';
    });
    
    // Hide no results message
    const noResults = document.getElementById('noResults');
    if (noResults) {
        noResults.style.display = 'none';
    }
}

// View details function
function viewDetails(id) {
    // This would typically load details via AJAX
    // For now, we'll show a placeholder
    const modalContent = document.getElementById('modalContent');
    modalContent.innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-danger" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3">Memuat detail agenda...</p>
        </div>
    `;
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('detailModal'));
    modal.show();
    
    // Simulate loading and show message
    setTimeout(() => {
        modalContent.innerHTML = `
            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>
                Fitur detail agenda akan segera tersedia.
            </div>
        `;
    }, 1000);
}
</script>
<?= $this->endSection() ?>
