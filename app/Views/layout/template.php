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

    <!-- Header (diseragamkan dengan public) -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm sticky-top">
        <div class="container">
            <!-- Hamburger Sidebar Toggle (mobile only) -->
            <button class="btn-sidebar-toggle me-2" id="sidebarToggleBtn" type="button" aria-label="Toggle Sidebar">
                <i class="bi bi-list"></i>
            </button>

            <a class="navbar-brand d-flex align-items-center" href="<?= site_url('dashboard') ?>">
                <img src="<?= base_url('logo.png') ?>" alt="PDPM Karanganyar" class="navbar-logo me-2">
                <span>PDPM KARANGANYAR</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item d-none d-lg-block me-3">
                        <a class="nav-link <?= current_url() == site_url('dashboard') ? 'active' : '' ?>" href="<?= site_url('dashboard') ?>">Beranda</a>
                    </li>
                    <li class="nav-item d-none d-lg-block me-3">
                        <a class="nav-link <?= strpos(current_url(), 'admin-berita') !== false ? 'active' : '' ?>" href="<?= site_url('admin-berita') ?>">Berita</a>
                    </li>
                    <li class="nav-item d-none d-lg-block me-3">
                        <a class="nav-link <?= strpos(current_url(), 'admin-agenda') !== false ? 'active' : '' ?>" href="<?= site_url('admin-agenda') ?>">Agenda</a>
                    </li>
                    <?php if(session()->get('id_role') == 1): // Hanya Super Admin ?>
                    <li class="nav-item d-none d-lg-block me-3">
                        <a class="nav-link <?= strpos(current_url(), 'admin-voting') !== false ? 'active' : '' ?>" href="<?= site_url('admin-voting') ?>">Voting</a>
                    </li>
                    <?php endif; ?>
                    <?php if(session()->get('id_role') == 3): // Anggota ?>
                    <li class="nav-item d-none d-lg-block me-3">
                        <a class="nav-link <?= strpos(current_url(), 'voting') !== false ? 'active' : '' ?>" href="<?= site_url('voting') ?>">Voting</a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-fill me-1"></i>
                            <?= session()->get('nama_lengkap') ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="<?= site_url('profil-saya') ?>">Profil Saya</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?= site_url('logout') ?>">Logout</a></li>
                        </ul>
                    </li>
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
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content-minimalist">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2"><?= $page_title ?? 'Dashboard' ?></h1>
                </div>
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success" role="alert"><?= session()->getFlashdata('success') ?></div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger" role="alert"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>
                <?= $this->renderSection('content') ?>
            </main>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="footer mt-auto py-3 bg-light border-top">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <img src="<?= base_url('logo.png') ?>" alt="PDPM" height="30" class="me-2">
                        <span class="text-muted">© <?= date('Y') ?> PDPM Karanganyar. All rights reserved.</span>
                    </div>
                </div>
                <div class="col-md-6 text-md-end mt-2 mt-md-0">
                    <a href="#" class="text-muted text-decoration-none me-3">Tentang</a>
                    <a href="#" class="text-muted text-decoration-none me-3">Kontak</a>
                    <a href="#" class="text-muted text-decoration-none">Bantuan</a>
                </div>
            </div>
        </div>
    </footer>

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
