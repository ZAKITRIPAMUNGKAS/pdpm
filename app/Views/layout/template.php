<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Dashboard PDPM Karanganyar' ?></title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&family=Poppins:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">

    <!-- Local CSS -->
    <link rel="stylesheet" href="<?= base_url('css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('bootstrap-icons/bootstrap-icons-complete.min.css') ?>">
    
    <!-- Bootstrap Icons Fallback -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    
    <!-- Icon Fix CSS -->
    <link rel="stylesheet" href="<?= base_url('css/icon-fix.css') ?>">
    
    <!-- PDPM Unified Theme System -->
    <link rel="stylesheet" href="<?= base_url('css/pdpm-theme.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/navbar-pdpm-theme.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/sidebar-minimalist.css') ?>">
    
    <!-- Mobile Responsive Fix - Must load after other CSS -->
    <link rel="stylesheet" href="<?= base_url('css/mobile-responsive-fix.css') ?>">

    <!-- Dashboard Responsive System -->
    <link rel="stylesheet" href="<?= base_url('css/dashboard-responsive.css') ?>">
    
    <!-- Page Specific Styles -->
    <?= $this->renderSection('styles') ?>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= base_url('logo.png') ?>">
</head>
<body class="d-flex flex-column h-100">

    <!-- Header Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm sticky-top">
        <div class="container-fluid px-2 px-sm-3 d-flex align-items-center justify-content-between">
            
            <!-- Left: Sidebar Toggle + Brand Logo & Title -->
            <div class="d-flex align-items-center me-2">
                <button class="btn-sidebar-toggle me-2" id="sidebarToggleBtn" type="button" aria-label="Toggle Sidebar">
                    <i class="bi bi-list"></i>
                </button>

                <a class="navbar-brand d-flex align-items-center m-0 p-0" href="<?= site_url('dashboard') ?>">
                    <img src="<?= base_url('logo.png') ?>" alt="PDPM Karanganyar" class="navbar-logo me-2">
                    <span class="d-none d-sm-inline">PDPM KARANGANYAR</span>
                    <span class="d-inline d-sm-none fs-6 fw-bold">PDPM</span>
                </a>
            </div>

            <!-- Middle: Desktop Navigation Links (≥992px) -->
            <div class="d-none d-lg-flex align-items-center mx-auto">
                <ul class="navbar-nav flex-row gap-1">
                    <li class="nav-item">
                        <a class="nav-link px-3 <?= current_url() == site_url('dashboard') ? 'active' : '' ?>" href="<?= site_url('dashboard') ?>">
                            <i class="bi bi-speedometer2 me-1"></i>Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 <?= strpos(current_url(), 'admin-berita') !== false ? 'active' : '' ?>" href="<?= site_url('admin-berita') ?>">
                            <i class="bi bi-newspaper me-1"></i>Berita
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 <?= strpos(current_url(), 'admin-agenda') !== false ? 'active' : '' ?>" href="<?= site_url('admin-agenda') ?>">
                            <i class="bi bi-calendar-event me-1"></i>Agenda
                        </a>
                    </li>
                    <?php if(session()->get('id_role') == 1): ?>
                    <li class="nav-item">
                        <a class="nav-link px-3 <?= strpos(current_url(), 'admin-voting') !== false ? 'active' : '' ?>" href="<?= site_url('admin-voting') ?>">
                            <i class="bi bi-ui-checks me-1"></i>Voting
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if(session()->get('id_role') == 3): ?>
                    <li class="nav-item">
                        <a class="nav-link px-3 <?= strpos(current_url(), 'voting') !== false ? 'active' : '' ?>" href="<?= site_url('voting') ?>">
                            <i class="bi bi-ui-checks me-1"></i>Voting
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Right: User Profile Dropdown Pill -->
            <div class="dropdown ms-auto">
                <a class="nav-link dropdown-toggle text-white d-flex align-items-center py-1 px-2 px-sm-3 rounded-pill bg-white bg-opacity-10 border border-warning border-opacity-25" 
                   href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="navbar-user-avatar me-1 me-sm-2"><?= strtoupper(substr(session()->get('nama_lengkap') ?? 'U', 0, 2)) ?></span>
                    <span class="d-none d-md-inline small fw-semibold me-1 me-sm-2 text-truncate" style="max-width: 140px;"><?= esc(session()->get('nama_lengkap')) ?></span>
                    <i class="bi bi-chevron-down small text-warning"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="navbarDropdown">
                    <li class="dropdown-header d-md-none text-wrap text-dark fw-bold border-bottom pb-2 mb-1">
                        <i class="bi bi-person-circle me-1 text-danger"></i><?= esc(session()->get('nama_lengkap')) ?>
                    </li>
                    <li><a class="dropdown-item" href="<?= site_url('profil-saya') ?>"><i class="bi bi-person-fill me-2 text-primary"></i>Profil Saya</a></li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li><a class="dropdown-item text-danger" href="<?= site_url('logout') ?>"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                </ul>
            </div>

        </div>
    </nav>

    <!-- Sidebar Overlay for mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="container-fluid flex-grow-1">
        <div class="row">
            <!-- Minimalist Sidebar -->
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar-minimalist collapse">
                <div class="sidebar-content">
                    <!-- User Profile Section -->
                    <div class="sidebar-user-profile">
                        <div class="user-avatar">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <div class="user-info">
                            <div class="user-name"><?= session()->get('nama_lengkap') ?></div>
                            <div class="user-role">
                                <?php 
                                $role = session()->get('id_role');
                                echo $role == 1 ? 'Super Admin' : ($role == 2 ? 'Admin' : 'Anggota');
                                ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Navigation Menu -->
                    <ul class="nav flex-column sidebar-nav">
                        <li class="nav-item">
                            <a class="nav-link <?= current_url() == site_url('dashboard') ? 'active' : '' ?>" href="<?= site_url('dashboard') ?>">
                                <i class="bi bi-speedometer2"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        
                        <?php if(session()->get('id_role') == 1 || session()->get('id_role') == 2): // Super Admin & Admin ?>
                        <li class="nav-section">
                            <span>Konten</span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= strpos(current_url(), 'admin-berita') !== false ? 'active' : '' ?>" href="<?= site_url('admin-berita') ?>">
                                <i class="bi bi-newspaper"></i>
                                <span>Berita</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= strpos(current_url(), 'admin-galeri') !== false ? 'active' : '' ?>" href="<?= site_url('admin-galeri') ?>">
                                <i class="bi bi-images"></i>
                                <span>Galeri</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= strpos(current_url(), 'admin-agenda') !== false ? 'active' : '' ?>" href="<?= site_url('admin-agenda') ?>">
                                <i class="bi bi-calendar-event"></i>
                                <span>Agenda</span>
                            </a>
                        </li>
                        <?php if(session()->get('id_role') == 1): // Hanya Super Admin ?>
                        <li class="nav-item">
                            <a class="nav-link <?= strpos(current_url(), 'admin-voting') !== false ? 'active' : '' ?>" href="<?= site_url('admin-voting') ?>">
                                <i class="bi bi-ui-checks"></i>
                                <span>Voting</span>
                            </a>
                        </li>
                        <?php endif; ?>
                        
                        <?php if(session()->get('id_role') == 2): // Hanya Admin ?>
                        <li class="nav-section">
                            <span>Organisasi</span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= strpos(current_url(), 'admin/cabang') !== false ? 'active' : '' ?>" href="<?= site_url('admin/cabang') ?>">
                                <i class="bi bi-building"></i>
                                <span>Cabang</span>
                            </a>
                        </li>
                        <?php endif; ?>
                        
                        <li class="nav-section">
                            <span>Keanggotaan</span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= strpos(current_url(), 'manajemen-anggota') !== false && strpos(current_url(), 'hapus') === false ? 'active' : '' ?>" href="<?= site_url('manajemen-anggota') ?>">
                                <i class="bi bi-people"></i>
                                <span>Anggota</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= strpos(current_url(), 'verifikasi-anggota') !== false ? 'active' : '' ?>" href="<?= site_url('verifikasi-anggota') ?>">
                                <i class="bi bi-person-check"></i>
                                <span>Verifikasi</span>
                                <?php 
                                $pendingCount = session()->get('pending_verifikasi_count') ?? 0;
                                if($pendingCount > 0): 
                                ?>
                                <span class="badge-count"><?= $pendingCount ?></span>
                                <?php endif; ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= strpos(current_url(), 'manajemen-anggota/hapus') !== false ? 'active' : '' ?>" href="<?= site_url('manajemen-anggota/hapus') ?>">
                                <i class="bi bi-trash"></i>
                                <span>Hapus</span>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if(session()->get('id_role') == 1): // Hanya Super Admin ?>
                        <li class="nav-section">
                            <span>Sistem</span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= strpos(current_url(), 'admin') !== false && strpos(current_url(), 'admin-') === false ? 'active' : '' ?>" href="<?= site_url('admin') ?>">
                                <i class="bi bi-person-gear"></i>
                                <span>Admin</span>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if(session()->get('id_role') == 3): // Anggota ?>
                        <li class="nav-section">
                            <span>Partisipasi</span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= strpos(current_url(), 'voting') !== false ? 'active' : '' ?>" href="<?= site_url('voting') ?>">
                                <i class="bi bi-ui-checks"></i>
                                <span>Voting</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= strpos(current_url(), 'absensi') !== false ? 'active' : '' ?>" href="<?= site_url('absensi/agenda') ?>">
                                <i class="bi bi-calendar-check"></i>
                                <span>Absensi</span>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content-minimalist d-flex flex-column">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2"><?= $page_title ?? 'Dashboard' ?></h1>
                </div>
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success" role="alert"><?= session()->getFlashdata('success') ?></div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger" role="alert"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>
                
                <div class="flex-grow-1">
                    <?= $this->renderSection('content') ?>
                </div>

                <!-- Minimalist Dashboard Footer -->
                <footer class="footer mt-5 py-3 px-3 bg-white border rounded-3 shadow-sm mb-3">
                    <div class="container-fluid p-0">
                        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-2 text-center text-md-start">
                            <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                                <img src="<?= base_url('logo.png') ?>" alt="PDPM Logo" style="height: 22px; width: auto;" class="me-2">
                                <span class="small text-muted">
                                    &copy; <?= date('Y') ?> <strong class="text-dark fw-semibold">PDPM Karanganyar</strong> &bull; Pemuda Muhammadiyah
                                </span>
                            </div>
                            <div class="footer-links small">
                                <a href="<?= site_url('profil') ?>" class="text-secondary text-decoration-none me-3 hover-danger">Tentang</a>
                                <a href="<?= site_url('kontak') ?>" class="text-secondary text-decoration-none me-3 hover-danger">Kontak</a>
                                <a href="https://wa.me/6281234567890" target="_blank" class="text-secondary text-decoration-none hover-success"><i class="bi bi-whatsapp text-success me-1"></i>Bantuan</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </main>
        </div>
    </div>

    <!-- Local Scripts -->
    <script src="<?= base_url('js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('js/navbar-dropdown-stable.js') ?>"></script>
    <script src="<?= base_url('js/navbar-enhanced.js') ?>"></script>
    <script src="<?= base_url('js/mobile-sidebar-toggle.js') ?>"></script>
    <script src="<?= base_url('js/custom.js') ?>"></script>
    
    <!-- Icon Fix Script -->
    <script src="<?= base_url('js/icon-fix.js') ?>"></script>

    <!-- Responsive Sidebar Toggle Script -->
    <script>
    (function() {
        var toggleBtn  = document.getElementById('sidebarToggleBtn');
        var sidebar    = document.getElementById('sidebarMenu');
        var overlay    = document.getElementById('sidebarOverlay');

        function openSidebar() {
            if (!sidebar) return;
            sidebar.classList.add('show');
            overlay.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            if (!sidebar) return;
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
            document.body.style.overflow = '';
        }

        if (toggleBtn) {
            toggleBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                sidebar && sidebar.classList.contains('show') ? closeSidebar() : openSidebar();
            });
        }

        if (overlay) {
            overlay.addEventListener('click', closeSidebar);
        }

        // Close when a sidebar nav-link is clicked on mobile
        if (sidebar) {
            sidebar.querySelectorAll('.nav-link').forEach(function(link) {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 992) closeSidebar();
                });
            });
        }

        // ESC key close
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeSidebar();
        });

        // Swipe support
        var touchStartX = 0;
        document.addEventListener('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });
        document.addEventListener('touchend', function(e) {
            var dx = e.changedTouches[0].screenX - touchStartX;
            if (touchStartX < 30 && dx > 60) openSidebar();
            if (sidebar && sidebar.classList.contains('show') && dx < -60) closeSidebar();
        }, { passive: true });

        // On resize: reset sidebar state on desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 992) {
                if (sidebar) sidebar.classList.remove('show');
                if (overlay) overlay.classList.remove('show');
                document.body.style.overflow = '';
            }
        });
    })();
    </script>

    <?= $this->renderSection('scripts') ?>
</body>
</html>
