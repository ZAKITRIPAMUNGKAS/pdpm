<?= $this->extend('layout/public_template') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/agenda.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$headerData = [
    'title' => 'Agenda Kegiatan',
    'subtitle' => 'Jadwal kegiatan dan acara Pimpinan Daerah Pemuda Muhammadiyah Karanganyar',
    'icon' => 'bi-calendar-event',
    'stats' => [
        'total_anggota' => $totalAnggota ?? 0,
        'total_cabang' => $totalCabang ?? 0,
        'total_ranting' => $totalRanting ?? 0,
        'total_kokam' => $totalKokam ?? 0
    ]
];
?>
<?= $this->include('layout/page_header', $headerData) ?>

<!-- Filter Section -->
<section class="filter-section">
    <div class="container">
        <div class="filter-container">
            <div class="agenda-legend">
                <span class="legend-item">
                    <span class="legend-color bg-danger"></span>
                    <span class="legend-text">Agenda Daerah</span>
                </span>
                <span class="legend-item">
                    <span class="legend-color bg-warning"></span>
                    <span class="legend-text">Agenda Cabang</span>
                </span>
                <span class="legend-item">
                    <span class="legend-color" style="background: linear-gradient(135deg, #17a2b8, #138496);"></span>
                    <span class="legend-text">Akan Datang</span>
                </span>
                <span class="legend-item">
                    <span class="legend-color" style="background: linear-gradient(135deg, #28a745, #218838);"></span>
                    <span class="legend-text">Sedang Berlangsung</span>
                </span>
                <span class="legend-item">
                    <span class="legend-color" style="background: linear-gradient(135deg, #6c757d, #5a6268);"></span>
                    <span class="legend-text">Selesai</span>
                </span>
            </div>
            <div class="filter-controls">
                <div class="filter-group">
                    <label for="filterTingkat" class="form-label fw-semibold me-2 mb-0">Tingkat:</label>
                    <select class="form-select form-select-sm" id="filterTingkat">
                        <option value="">Semua Agenda</option>
                        <option value="daerah">Agenda Daerah</option>
                        <option value="cabang">Agenda Cabang</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="filterStatus" class="form-label fw-semibold me-2 mb-0">Status:</label>
                    <select class="form-select form-select-sm" id="filterStatus">
                        <option value="">Semua Status</option>
                        <option value="upcoming">Akan Datang</option>
                        <option value="ongoing">Sedang Berlangsung</option>
                        <option value="completed">Selesai</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="py-5">
    <div class="container">
        <!-- Loading State -->
        <div class="loading-state" id="loadingState" style="display: none;">
            <div class="loading-spinner">
                <div class="spinner"></div>
            </div>
            <p class="loading-text">Memuat agenda...</p>
        </div>
        
        <?php if (!empty($agenda)): ?>
            <div class="agenda-grid" id="agendaContainer">
                <?php foreach ($agenda as $item): ?>
                    <?php
                    // Status indicator based on date - moved to top of loop
                    $now = new DateTime();
                    $startDate = new DateTime($item['tanggal_mulai']);
                    $endDate = isset($item['tanggal_selesai']) ? new DateTime($item['tanggal_selesai']) : $startDate;
                    
                    $statusClass = 'upcoming';
                    $statusText = 'Akan Datang';
                    $statusIcon = 'bi-clock';
                    
                    if ($now >= $startDate && $now <= $endDate) {
                        $statusClass = 'ongoing';
                        $statusText = 'Sedang Berlangsung';
                        $statusIcon = 'bi-play-circle';
                    } elseif ($now > $endDate) {
                        $statusClass = 'completed';
                        $statusText = 'Selesai';
                        $statusIcon = 'bi-check-circle';
                    }
                    ?>
                    <div class="agenda-item" data-tingkat="<?= esc($item['tingkat_agenda'] ?? 'daerah') ?>" data-status="<?= $statusClass ?>">
                        <div class="agenda-card">
                            <div class="card-header">
                                <div class="date-day"><?= date('d', strtotime($item['tanggal_mulai'])) ?></div>
                                <div class="date-month-year"><?= strtoupper(date('M Y', strtotime($item['tanggal_mulai']))) ?></div>
                            </div>
                            <div class="card-body">
                                <div class="badge-container">
                                    <?php if (($item['tingkat_agenda'] ?? 'daerah') === 'daerah'): ?>
                                        <span class="badge bg-danger">
                                            <i class="bi bi-building me-1"></i>Daerah
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">
                                            <i class="bi bi-geo-alt me-1"></i>
                                            <?= !empty($item['nama_cabang']) ? esc($item['nama_cabang']) : 'Cabang' ?>
                                        </span>
                                    <?php endif; ?>
                                    
                                    <div class="status-badge <?= $statusClass ?>">
                                        <i class="<?= $statusIcon ?> me-1"></i>
                                        <?= $statusText ?>
                                    </div>
                                </div>
                                <h5 class="agenda-title"><?= esc($item['nama_kegiatan']) ?></h5>
                                <div class="agenda-meta">
                                    <div class="meta-item">
                                        <i class="bi bi-clock"></i>
                                        <span><?= date('H:i', strtotime($item['jam_mulai'] ?? $item['tanggal_mulai'])) ?> WIB</span>
                                    </div>
                                    <div class="meta-item">
                                        <i class="bi bi-geo-alt"></i>
                                        <span><?= esc($item['lokasi']) ?></span>
                                    </div>
                                    <?php if (!empty($item['nama_penulis'])): ?>
                                    <div class="meta-item">
                                        <i class="bi bi-person"></i>
                                        <span><?= esc($item['nama_penulis']) ?></span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-detail" data-bs-toggle="modal" data-bs-target="#agendaModal<?= $item['id'] ?>">
                                    Lihat Detail
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Modal untuk setiap agenda -->
                    <div class="modal fade" id="agendaModal<?= $item['id'] ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content agenda-modal">
                                <div class="modal-header agenda-modal-header">
                                    <div class="modal-title-container">
                                        <h5 class="modal-title">
                                            <i class="bi bi-calendar-event me-2"></i>Detail Agenda
                                        </h5>
                                        <div class="modal-status">
                                            <span class="status-badge <?= $statusClass ?>">
                                                <i class="<?= $statusIcon ?> me-1"></i>
                                                <?= $statusText ?>
                                            </span>
                                        </div>
                                    </div>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body agenda-modal-body">
                                    <div class="agenda-modal-badge">
                                        <?php if (($item['tingkat_agenda'] ?? 'daerah') === 'daerah'): ?>
                                            <span class="badge bg-danger">
                                                <i class="bi bi-building me-1"></i>Agenda Daerah
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark">
                                                <i class="bi bi-geo-alt me-1"></i>
                                                Agenda <?= !empty($item['nama_cabang']) ? esc($item['nama_cabang']) : 'Cabang' ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <h4 class="agenda-modal-title"><?= esc($item['nama_kegiatan']) ?></h4>
                                    
                                    <div class="agenda-modal-info">
                                        <div class="info-card">
                                            <div class="info-icon">
                                                <i class="bi bi-calendar3"></i>
                                            </div>
                                            <div class="info-content">
                                                <strong>Tanggal</strong>
                                                <span><?= date('l, d F Y', strtotime($item['tanggal_mulai'])) ?></span>
                                            </div>
                                        </div>
                                        
                                        <div class="info-card">
                                            <div class="info-icon">
                                                <i class="bi bi-clock"></i>
                                            </div>
                                            <div class="info-content">
                                                <strong>Waktu</strong>
                                                <span>
                                                    <?= date('H:i', strtotime($item['jam_mulai'] ?? $item['tanggal_mulai'])) ?> - 
                                                    <?= date('H:i', strtotime($item['jam_selesai'] ?? $item['tanggal_selesai'])) ?> WIB
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <?php if (!empty($item['lokasi'])): ?>
                                        <div class="info-card">
                                            <div class="info-icon">
                                                <i class="bi bi-geo-alt"></i>
                                            </div>
                                            <div class="info-content">
                                                <strong>Lokasi</strong>
                                                <span><?= esc($item['lokasi']) ?></span>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($item['nama_penulis'])): ?>
                                        <div class="info-card">
                                            <div class="info-icon">
                                                <i class="bi bi-person"></i>
                                            </div>
                                            <div class="info-content">
                                                <strong>Penyelenggara</strong>
                                                <span><?= esc($item['nama_penulis']) ?></span>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <?php if (!empty($item['deskripsi'])): ?>
                                    <div class="agenda-modal-description">
                                        <h6><i class="bi bi-info-circle me-2"></i>Deskripsi Kegiatan</h6>
                                        <div class="description-content"><?= nl2br(esc($item['deskripsi'])) ?></div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="modal-footer agenda-modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        <i class="bi bi-x-circle me-1"></i>Tutup
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="bi bi-calendar-x"></i>
                </div>
                <h3 class="empty-title">Belum Ada Agenda</h3>
                <p class="empty-text">Saat ini belum ada agenda kegiatan yang dijadwalkan.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var filterTingkat = document.getElementById('filterTingkat');
    var filterStatus = document.getElementById('filterStatus');
    var agendaContainer = document.getElementById('agendaContainer');
    var loadingState = document.getElementById('loadingState');
    
    function filterAgenda() {
        var selectedTingkat = filterTingkat ? filterTingkat.value : '';
        var selectedStatus = filterStatus ? filterStatus.value : '';
        var agendaItems = document.querySelectorAll('.agenda-item');
        
        // Show loading state
        if (loadingState) {
            loadingState.style.display = 'block';
        }
        if (agendaContainer) {
            agendaContainer.style.opacity = '0.5';
        }
        
        // Simulate loading delay for better UX
        setTimeout(function() {
            var visibleCount = 0;
            
            agendaItems.forEach(function(item, index) {
                var itemTingkat = item.getAttribute('data-tingkat');
                var itemStatus = item.getAttribute('data-status');
                
                var shouldShowTingkat = selectedTingkat === '' || itemTingkat === selectedTingkat;
                var shouldShowStatus = selectedStatus === '' || itemStatus === selectedStatus;
                var shouldShow = shouldShowTingkat && shouldShowStatus;
                
                if (shouldShow) {
                    item.style.display = 'block';
                    item.style.opacity = '0';
                    item.style.transform = 'scale(0.9)';
                    visibleCount++;
                    
                    // Animate in with delay
                    setTimeout(function() {
                        item.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
                        item.style.opacity = '1';
                        item.style.transform = 'scale(1)';
                    }, index * 100);
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Hide loading state
            if (loadingState) {
                loadingState.style.display = 'none';
            }
            if (agendaContainer) {
                agendaContainer.style.opacity = '1';
            }
            
            // Show empty state if no items visible
            if (visibleCount === 0) {
                showEmptyState();
            } else {
                hideEmptyState();
            }
        }, 300);
    }
    
    if (filterTingkat) {
        filterTingkat.addEventListener('change', filterAgenda);
    }
    
    if (filterStatus) {
        filterStatus.addEventListener('change', filterAgenda);
    }
    
    // Add hover effects to agenda cards
    var agendaCards = document.querySelectorAll('.agenda-card');
    agendaCards.forEach(function(card) {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-12px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
    
    // Add click animation to buttons
    var detailButtons = document.querySelectorAll('.btn-detail');
    detailButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            this.style.transform = 'scale(0.95)';
            setTimeout(function() {
                button.style.transform = 'scale(1)';
            }, 150);
        });
    });
    
    // Add smooth scroll to top when filter changes
    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
    
    if (filterTingkat) {
        filterTingkat.addEventListener('change', function() {
            setTimeout(scrollToTop, 100);
        });
    }
    
    if (filterStatus) {
        filterStatus.addEventListener('change', function() {
            setTimeout(scrollToTop, 100);
        });
    }
    
    // Show empty state function
    function showEmptyState() {
        var emptyState = document.querySelector('.empty-state');
        if (emptyState) {
            emptyState.style.display = 'block';
        }
    }
    
    // Hide empty state function
    function hideEmptyState() {
        var emptyState = document.querySelector('.empty-state');
        if (emptyState) {
            emptyState.style.display = 'none';
        }
    }
    
    // Initialize animations on page load
    var agendaItems = document.querySelectorAll('.agenda-item');
    agendaItems.forEach(function(item, index) {
        item.style.opacity = '0';
        item.style.transform = 'translateY(20px)';
        
        setTimeout(function() {
            item.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
            item.style.opacity = '1';
            item.style.transform = 'translateY(0)';
        }, index * 150);
    });
});
</script>
<?= $this->endSection() ?>
