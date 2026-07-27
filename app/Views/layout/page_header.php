<?php
/**
 * Standardized Page Header Component
 * Usage: <?= $this->include('layout/page_header', $headerData) ?>
 * 
 * $headerData should contain:
 * - title: Page title
 * - subtitle: Page subtitle/description
 * - icon: Bootstrap icon class (e.g., 'bi-newspaper')
 * - bg_class: Background class (optional, defaults to 'bg-gradient-primary')
 */
?>

<!-- Standardized Page Header -->
<section class="page-header <?= $bg_class ?? 'bg-gradient-primary' ?> text-white position-relative overflow-hidden">
    <div class="container position-relative">
        <div class="row align-items-center min-vh-30 g-0">
            <div class="col-12 px-4 py-5">
                <div class="header-content text-center">
                    <div class="header-badge mb-3">
                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fs-6 fw-bold shadow-sm">
                            <i class="bi bi-star-fill me-2"></i>PDPM Karanganyar
                        </span>
                    </div>
                    <h1 class="display-4 fw-bold mb-3 text-shadow header-title">
                        <i class="bi <?= $icon ?? 'bi-info-circle' ?> me-3 text-warning"></i>
                        <?= esc($title ?? 'Halaman') ?>
                    </h1>
                    <p class="lead mb-0 fs-5 text-light header-subtitle">
                        <?= esc($subtitle ?? 'Informasi terkini dari Pimpinan Daerah Pemuda Muhammadiyah Karanganyar') ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="header-wave">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M0,120V73.71c47.79-22.2,103.59-32.17,158-28,70.36,5.37,136.33,33.31,206.8,37.5C438.64,87.57,512.34,66.33,583,47.95c69.27-18,138.3-24.88,209.4-13.08,36.15,6,69.85,17.84,104.45,29.34C989.49,95,1113,134.29,1200,67.53V120Z" opacity=".25" fill="#ffffff"></path>
            <path d="M0,120V104.19C13,83.08,27.64,63.14,47.69,47.95,99.41,8.73,165,9,224.58,28.42c31.15,10.15,60.09,26.07,89.67,39.8,40.92,19,84.73,46,130.83,49.67,36.26,2.85,70.9-9.42,98.6-31.56,31.77-25.39,62.32-62,103.63-73,40.44-10.79,81.35,6.69,119.13,24.28s75.16,39,116.92,43.05c59.73,5.85,113.28-22.88,168.9-38.84,30.2-8.66,59-6.17,87.09,7.5,22.43,10.89,48,26.93,60.65,49.24V120Z" opacity=".5" fill="#ffffff"></path>
            <path d="M0,120V114.37C149.93,61,314.09,48.68,475.83,77.43c43,7.64,84.23,20.12,127.61,26.46,59,8.63,112.48-12.24,165.56-35.4C827.93,42.78,886,24.76,951.2,30c86.53,7,172.46,45.71,248.8,84.81V120Z" fill="#ffffff"></path>
        </svg>
    </div>
</section>

<style>
/* Standardized Page Header Styles */
.page-header {
    background: linear-gradient(135deg, #dc3545 0%, #000000 100%);
    position: relative;
    overflow: hidden;
}

.page-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
}

.header-content {
    position: relative;
    z-index: 2;
}

.header-title {
    font-size: 3rem;
    font-weight: 800;
    line-height: 1.2;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.header-subtitle {
    opacity: 0.9;
    line-height: 1.6;
}



.header-wave {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 60px;
    overflow: hidden;
}

.header-wave svg {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

/* Responsive Design */
@media (max-width: 768px) {
    .header-title {
        font-size: 2.2rem;
    }
    
    .header-subtitle {
        font-size: 1rem;
    }
}

@media (max-width: 576px) {
    .header-title {
        font-size: 1.8rem;
    }
    
    .header-subtitle {
        font-size: 0.9rem;
    }
}
</style>
