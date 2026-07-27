<?= $this->extend('layout/public_template') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/profil.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$headerData = [
    'title' => 'Profil Organisasi',
    'subtitle' => 'Mengenal lebih dekat Pimpinan Daerah Pemuda Muhammadiyah Kabupaten Karanganyar',
    'icon' => 'bi-building',
    'stats' => [
        'total_anggota' => $totalAnggota ?? 0,
        'total_cabang' => $totalCabang ?? 0,
        'total_ranting' => $totalRanting ?? 0,
        'total_kokam' => $totalKokam ?? 0
    ]
];
?>
<?= $this->include('layout/page_header', $headerData) ?>

<section class="py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12">
                <div class="nav-tabs-modern">
                    <ul class="nav nav-pills justify-content-center" id="profileTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="sejarah-tab" data-bs-toggle="pill" data-bs-target="#sejarah" type="button" role="tab" aria-controls="sejarah" aria-selected="true">
                                <i class="bi bi-clock-history me-2"></i>Sejarah
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="visi-misi-tab" data-bs-toggle="pill" data-bs-target="#visi-misi" type="button" role="tab" aria-controls="visi-misi" aria-selected="false">
                                <i class="bi bi-bullseye me-2"></i>Visi & Misi
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="struktur-tab" data-bs-toggle="pill" data-bs-target="#struktur" type="button" role="tab" aria-controls="struktur" aria-selected="false">
                                <i class="bi bi-diagram-3 me-2"></i>Struktur
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="program-tab" data-bs-toggle="pill" data-bs-target="#program" type="button" role="tab" aria-controls="program" aria-selected="false">
                                <i class="bi bi-list-task me-2"></i>Program
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="tab-content" id="profileTabsContent">
            <div class="tab-pane fade show active" id="sejarah" role="tabpanel" aria-labelledby="sejarah-tab">
                <!-- Modern Hero Section -->
                <div class="modern-hero-section">
                    <div class="container">
                        <div class="hero-content-modern">
                            <div class="hero-text-modern">
                                <div class="hero-badge">
                                    <i class="bi bi-clock-history me-2"></i>
                                    Sejarah Organisasi
                                </div>
                                <h1 class="hero-title-modern">Perjalanan PDPM Karanganyar</h1>
                                <p class="hero-subtitle-modern">
                                    Membina generasi muda Islam yang berkarakter, berakhlak mulia, dan berkontribusi nyata untuk kemajuan bangsa
                                </p>
                                <div class="hero-stats">
                                    <div class="stat-item">
                                        <span class="stat-number">92+</span>
                                        <span class="stat-label">Tahun Perjuangan</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-number">45+</span>
                                        <span class="stat-label">Tahun di Karanganyar</span>
                                    </div>
                                </div>
                            </div>
                            <div class="hero-image-modern">
                                <div class="image-container-modern">
                                    <img src="<?= base_url('images.jpg') ?>" alt="Sejarah PDPM Karanganyar" 
                                         onerror="this.src='<?= base_url('default.png') ?>'; this.onerror=null;"
                                         loading="lazy" class="hero-img">
                                    <div class="image-overlay-modern">
                                        <div class="overlay-content">
                                            <i class="bi bi-play-circle-fill"></i>
                                            <span>Lihat Perjalanan Kami</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modern Timeline Section -->
                <div class="modern-timeline-section">
                    <div class="container">
                        <div class="timeline-header-modern">
                            <div class="section-badge-modern">
                                <i class="bi bi-diagram-3 me-2"></i>
                                Timeline Sejarah
                            </div>
                            <h2 class="section-title-modern">Perjalanan Panjang Organisasi</h2>
                            <p class="section-subtitle-modern">Mengenal lebih dekat perjalanan dan perkembangan PDPM Karanganyar dari masa ke masa</p>
                        </div>

                        <div class="timeline-container-modern">
                            <div class="timeline-line"></div>
                            
                            <!-- Timeline Item 1 -->
                            <div class="timeline-item-modern">
                                <div class="timeline-marker-modern">
                                    <div class="marker-icon">
                                        <i class="bi bi-star-fill"></i>
                                    </div>
                                    <div class="marker-year">1932</div>
                                </div>
                                <div class="timeline-content-modern">
                                    <div class="timeline-card">
                                        <div class="card-header-modern">
                                            <h3 class="timeline-title-modern">Kelahiran Pemuda Muhammadiyah</h3>
                                            <div class="timeline-tag">Sejarah Nasional</div>
                                        </div>
                                        <div class="card-body-modern">
                                            <p class="timeline-text-modern">
                                                Pemuda Muhammadiyah lahir sebagai organisasi otonom Muhammadiyah pada 2 Mei 1932, berawal dari gagasan KH. Ahmad Dahlan melalui gerakan Siswo Proyo Priyo (SPP) yang membina remaja dan pemuda Islam.
                                            </p>
                                            <div class="timeline-highlights">
                                                <div class="highlight-item-modern">
                                                    <i class="bi bi-calendar-event"></i>
                                                    <span>2 Mei 1932</span>
                                                </div>
                                                <div class="highlight-item-modern">
                                                    <i class="bi bi-person-badge"></i>
                                                    <span>KH. Ahmad Dahlan</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Timeline Item 2 -->
                            <div class="timeline-item-modern">
                                <div class="timeline-marker-modern">
                                    <div class="marker-icon">
                                        <i class="bi bi-geo-alt-fill"></i>
                                    </div>
                                    <div class="marker-year">1957</div>
                                </div>
                                <div class="timeline-content-modern">
                                    <div class="timeline-card">
                                        <div class="card-header-modern">
                                            <h3 class="timeline-title-modern">Cikal Bakal di Karanganyar</h3>
                                            <div class="timeline-tag">Lokal</div>
                                        </div>
                                        <div class="card-body-modern">
                                            <p class="timeline-text-modern">
                                                Di Karanganyar, cikal bakal Pemuda Muhammadiyah sudah muncul sejak 1957, dipelopori oleh Achmad Samsuri di bawah kepemimpinan Cabang Muhammadiyah Karanganyar.
                                            </p>
                                            <div class="timeline-highlights">
                                                <div class="highlight-item-modern">
                                                    <i class="bi bi-person-check"></i>
                                                    <span>Achmad Samsuri</span>
                                                </div>
                                                <div class="highlight-item-modern">
                                                    <i class="bi bi-building"></i>
                                                    <span>Cabang Muhammadiyah</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Timeline Item 3 -->
                            <div class="timeline-item-modern">
                                <div class="timeline-marker-modern">
                                    <div class="marker-icon">
                                        <i class="bi bi-shield-check"></i>
                                    </div>
                                    <div class="marker-year">1966</div>
                                </div>
                                <div class="timeline-content-modern">
                                    <div class="timeline-card">
                                        <div class="card-header-modern">
                                            <h3 class="timeline-title-modern">Pembentukan KOKAM</h3>
                                            <div class="timeline-tag">Keamanan</div>
                                        </div>
                                        <div class="card-body-modern">
                                            <p class="timeline-text-modern">
                                                Setelah peristiwa G30S/PKI 1966, didirikanlah KOKAM (Komando Kesiapsiagaan Angkatan Muda Muhammadiyah) yang sempat menggelar Apel Akbar di Stadion 45 Karanganyar.
                                            </p>
                                            <div class="timeline-highlights">
                                                <div class="highlight-item-modern">
                                                    <i class="bi bi-shield-fill-check"></i>
                                                    <span>KOKAM</span>
                                                </div>
                                                <div class="highlight-item-modern">
                                                    <i class="bi bi-geo-alt"></i>
                                                    <span>Stadion 45</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Timeline Item 4 -->
                            <div class="timeline-item-modern">
                                <div class="timeline-marker-modern">
                                    <div class="marker-icon">
                                        <i class="bi bi-building"></i>
                                    </div>
                                    <div class="marker-year">1979</div>
                                </div>
                                <div class="timeline-content-modern">
                                    <div class="timeline-card">
                                        <div class="card-header-modern">
                                            <h3 class="timeline-title-modern">Struktur Resmi Terbentuk</h3>
                                            <div class="timeline-tag">Organisasi</div>
                                        </div>
                                        <div class="card-body-modern">
                                            <p class="timeline-text-modern">
                                                Secara resmi, struktur Pemuda Muhammadiyah Karanganyar terbentuk pada 1979, dengan periode rintisan (1979–1995) dan pengembangan (1996–sekarang).
                                            </p>
                                            <div class="timeline-highlights">
                                                <div class="highlight-item-modern">
                                                    <i class="bi bi-diagram-3"></i>
                                                    <span>Struktur Resmi</span>
                                                </div>
                                                <div class="highlight-item-modern">
                                                    <i class="bi bi-arrow-up-circle"></i>
                                                    <span>Periode Rintisan</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modern Leadership Section -->
                <div class="modern-leadership-section">
                    <div class="container">
                        <div class="leadership-header-modern">
                            <div class="section-badge-modern">
                                <i class="bi bi-people-fill me-2"></i>
                                Kepemimpinan
                            </div>
                            <h2 class="section-title-modern">Para Pemimpin Organisasi</h2>
                            <p class="section-subtitle-modern">Tokoh-tokoh yang telah memimpin dan mengembangkan PDPM Karanganyar dari masa ke masa</p>
                        </div>

                        <div class="leadership-grid-modern">
                            <div class="leader-card-modern">
                                <div class="leader-period-modern">1979-1995</div>
                                <div class="leader-info-modern">
                                    <h4 class="leader-name-modern">Mudzakir</h4>
                                    <p class="leader-role-modern">Periode Rintisan</p>
                                    <div class="leader-achievement">Membangun fondasi organisasi</div>
                                </div>
                            </div>

                            <div class="leader-card-modern">
                                <div class="leader-period-modern">1996-2000</div>
                                <div class="leader-info-modern">
                                    <h4 class="leader-name-modern">Affandi</h4>
                                    <p class="leader-role-modern">Periode Pengembangan</p>
                                    <div class="leader-achievement">Ekspansi program dan kegiatan</div>
                                </div>
                            </div>

                            <div class="leader-card-modern">
                                <div class="leader-period-modern">2000-2004</div>
                                <div class="leader-info-modern">
                                    <h4 class="leader-name-modern">Sugiarso HS</h4>
                                    <p class="leader-role-modern">Periode Konsolidasi</p>
                                    <div class="leader-achievement">Memperkuat struktur internal</div>
                                </div>
                            </div>

                            <div class="leader-card-modern">
                                <div class="leader-period-modern">2004-2008</div>
                                <div class="leader-info-modern">
                                    <h4 class="leader-name-modern">Mulyono</h4>
                                    <p class="leader-role-modern">Periode Modernisasi</p>
                                    <div class="leader-achievement">Adaptasi teknologi dan metode baru</div>
                                </div>
                            </div>

                            <div class="leader-card-modern">
                                <div class="leader-period-modern">2008-2012</div>
                                <div class="leader-info-modern">
                                    <h4 class="leader-name-modern">Juliyatmono</h4>
                                    <p class="leader-role-modern">Periode Inovasi</p>
                                    <div class="leader-achievement">Program kreatif dan inovatif</div>
                                </div>
                            </div>

                            <div class="leader-card-modern">
                                <div class="leader-period-modern">2012-2016</div>
                                <div class="leader-info-modern">
                                    <h4 class="leader-name-modern">Muh Samsuri</h4>
                                    <p class="leader-role-modern">Periode Transformasi</p>
                                    <div class="leader-achievement">Perubahan struktural besar</div>
                                </div>
                            </div>

                            <div class="leader-card-modern">
                                <div class="leader-period-modern">2016-2020</div>
                                <div class="leader-info-modern">
                                    <h4 class="leader-name-modern">Hastono</h4>
                                    <p class="leader-role-modern">Periode Digitalisasi</p>
                                    <div class="leader-achievement">Era teknologi digital</div>
                                </div>
                            </div>

                            <div class="leader-card-modern">
                                <div class="leader-period-modern">2020-2024</div>
                                <div class="leader-info-modern">
                                    <h4 class="leader-name-modern">Tarno</h4>
                                    <p class="leader-role-modern">Periode Kontemporer</p>
                                    <div class="leader-achievement">Adaptasi era modern</div>
                                </div>
                            </div>

                            <div class="leader-card-modern current">
                                <div class="leader-period-modern">2024-Sekarang</div>
                                <div class="leader-info-modern">
                                    <h4 class="leader-name-modern">Mahlich Ibrahim</h4>
                                    <p class="leader-role-modern">Periode Berkemajuan</p>
                                    <div class="leader-achievement">Visi kemajuan dan inovasi</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modern Vision Section -->
                <div class="modern-vision-section">
                    <div class="container">
                        <div class="vision-content-modern">
                            <div class="vision-header-modern">
                                <div class="section-badge-modern">
                                    <i class="bi bi-eye-fill me-2"></i>
                                    Visi Masa Kini
                                </div>
                                <h2 class="section-title-modern">Masa Depan yang Berkemajuan</h2>
                                <p class="section-subtitle-modern">
                                    Dalam perjalanannya, Pemuda Muhammadiyah Karanganyar aktif menggerakkan dakwah, kajian keislaman, pengkaderan, gerakan sosial, hingga kegiatan kebangsaan. Dengan semangat sebagai pelopor, pelangsung, dan penyempurna perjuangan Muhammadiyah, organisasi ini terus berkiprah membina generasi muda Islam di Karanganyar.
                                </p>
                            </div>
                            
                            <div class="vision-focus-modern">
                                <div class="focus-card-modern">
                                    <div class="focus-icon-modern">
                                        <i class="bi bi-megaphone"></i>
                                    </div>
                                    <h4 class="focus-title-modern">Dakwah & Kajian Keislaman</h4>
                                    <p class="focus-text-modern">Menggerakkan dakwah dan kajian keislaman di masyarakat dengan pendekatan yang relevan dan modern</p>
                                </div>
                                
                                <div class="focus-card-modern">
                                    <div class="focus-icon-modern">
                                        <i class="bi bi-mortarboard"></i>
                                    </div>
                                    <h4 class="focus-title-modern">Pengkaderan & Pendidikan</h4>
                                    <p class="focus-text-modern">Membina dan mengembangkan kader-kader berkualitas yang siap memimpin di masa depan</p>
                                </div>
                                
                                <div class="focus-card-modern">
                                    <div class="focus-icon-modern">
                                        <i class="bi bi-heart-fill"></i>
                                    </div>
                                    <h4 class="focus-title-modern">Gerakan Sosial & Kebangsaan</h4>
                                    <p class="focus-text-modern">Berperan aktif dalam gerakan sosial dan kebangsaan untuk kemajuan masyarakat</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="visi-misi" role="tabpanel" aria-labelledby="visi-misi-tab">
                <div class="content-card">
                    <!-- Header Section -->
                    <div class="text-center mb-5">
                        <div class="section-badge">
                            <i class="bi bi-bullseye me-2"></i>
                            Visi & Misi Organisasi
                        </div>
                        <h2 class="section-title">Pandangan & Tujuan Kami</h2>
                        <p class="section-subtitle">Landasan perjuangan dan arah pembangunan PDPM Karanganyar</p>
                    </div>

                    <div class="row g-4">
                        <!-- Vision Card -->
                        <div class="col-lg-6">
                            <div class="vision-card">
                                <div class="card-header">
                                    <div class="card-icon">
                                        <i class="bi bi-eye"></i>
                                    </div>
                                    <div class="card-badge">Visi</div>
                                </div>
                                <div class="card-content">
                                    <h3 class="card-title">Visi Kami</h3>
                                    <div class="vision-quote">
                                        <div class="quote-mark">"</div>
                                        <p class="vision-text">
                                            Pemuda berkeadaban, Meneguhkan karanganyar berkemajuan
                                        </p>
                                        <div class="quote-mark">"</div>
                                    </div>
                                    <div class="vision-description">
                                        <p>Sebuah cita-cita mulia untuk membangun generasi muda yang berkarakter, berakhlak mulia, dan berkontribusi nyata dalam memajukan Kabupaten Karanganyar.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Mission Card -->
                        <div class="col-lg-6">
                            <div class="mission-card">
                                <div class="card-header">
                                    <div class="card-icon">
                                        <i class="bi bi-bullseye"></i>
                                    </div>
                                    <div class="card-badge">Misi</div>
                                </div>
                                <div class="card-content">
                                    <h3 class="card-title">Misi Kami</h3>
                                    <div class="mission-list">
                                        <div class="mission-item">
                                            <div class="mission-number">
                                                <span>1</span>
                                            </div>
                                            <div class="mission-content">
                                                <h5 class="mission-title">Peningkatan Kualitas Kader</h5>
                                                <p class="mission-text">Meningkatkan kualitas kader dalam aspek spiritual, intelektual, dan moral.</p>
                                            </div>
                                        </div>
                                        <div class="mission-item">
                                            <div class="mission-number">
                                                <span>2</span>
                                            </div>
                                            <div class="mission-content">
                                                <h5 class="mission-title">Pengembangan Ekonomi</h5>
                                                <p class="mission-text">Mengembangkan potensi ekonomi dan kemandirian kader.</p>
                                            </div>
                                        </div>
                                        <div class="mission-item">
                                            <div class="mission-number">
                                                <span>3</span>
                                            </div>
                                            <div class="mission-content">
                                                <h5 class="mission-title">Dakwah Aktif</h5>
                                                <p class="mission-text">Berperan aktif dalam dakwah amar ma'ruf nahi munkar.</p>
                                            </div>
                                        </div>
                                        <div class="mission-item">
                                            <div class="mission-number">
                                                <span>4</span>
                                            </div>
                                            <div class="mission-content">
                                                <h5 class="mission-title">Jaringan & Kerjasama</h5>
                                                <p class="mission-text">Membangun jaringan dan kerjasama strategis dengan berbagai pihak.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Values Section -->
                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="values-section">
                                <div class="text-center mb-4">
                                    <h3 class="values-title">Nilai-Nilai Dasar</h3>
                                    <p class="values-subtitle">Prinsip yang menjadi landasan perjuangan kami</p>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-3 col-sm-6">
                                        <div class="value-item">
                                            <div class="value-icon">
                                                <i class="bi bi-heart"></i>
                                            </div>
                                            <h6 class="value-name">Iman</h6>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="value-item">
                                            <div class="value-icon">
                                                <i class="bi bi-book"></i>
                                            </div>
                                            <h6 class="value-name">Ilmu</h6>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="value-item">
                                            <div class="value-icon">
                                                <i class="bi bi-people"></i>
                                            </div>
                                            <h6 class="value-name">Amal</h6>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="value-item">
                                            <div class="value-icon">
                                                <i class="bi bi-shield-check"></i>
                                            </div>
                                            <h6 class="value-name">Akhlaq</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="struktur" role="tabpanel" aria-labelledby="struktur-tab">
                <div class="content-card">
                    <h2 class="section-title-small mb-5 text-center mx-auto csp-max-width-600">
                        <i class="bi bi-diagram-3 text-primary me-2"></i>
                        Struktur PDPM KRA 2023-2027
                    </h2>
                    <div class="org-structure">
                        <div class="structure-level">
                            <h4 class="level-title">Pimpinan Harian</h4>
                            <div class="row justify-content-center g-4">
                                <div class="col-lg-3 col-md-6">
                                    <div class="position-card ketua">
                                        <div class="profile-image-container"><img src="<?= base_url('uploads/profil/ketua-umum.jpg') ?>" alt="Ketua Mahlich Ibrahim" class="profile-image"></div>
                                        <h5>Ketua</h5>
                                        <p class="name">Mahlich Ibrahim</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="position-card sekretaris">
                                        <div class="profile-image-container"><img src="<?= base_url('uploads/profil/sekretaris-umum.jpg') ?>" alt="Sekretaris Isna Hidayat" class="profile-image"></div>
                                        <h5>Sekretaris</h5>
                                        <p class="name">Isna Hidayat</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="position-card bendahara">
                                        <div class="profile-image-container"><img src="<?= base_url('uploads/profil/bendahara-umum.jpg') ?>" alt="Bendahara Gesang Triwigati" class="profile-image"></div>
                                        <h5>Bendahara</h5>
                                        <p class="name">Gesang Triwigati</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="position-card wakil-bendahara">
                                        <div class="profile-image-container"><img src="<?= base_url('uploads/profil/wakil-bendahara-umum.jpg') ?>" alt="Wakil Bendahara Jarwanto" class="profile-image"></div>
                                        <h5>Wakil Bendahara</h5>
                                        <p class="name">Jarwanto</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="structure-level">
                            <h4 class="level-title">Struktur Bidang</h4>
                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="division-card">
                                        <h5 class="division-title">Bidang Organisasi & Keanggotaan</h5>
                                        <ul class="personnel-list">
                                            <li><div class="personnel-photo"><img src="<?= base_url('uploads/bo/1.png') ?>" alt="Atha Zha Zha Zaky"></div><div class="personnel-info"><span class="personnel-name">Atha Zha Zha Zaky</span><span class="personnel-role">Wakil Ketua Bidang</span></div></li>
                                            <li><div class="personnel-photo"><img src="<?= base_url('uploads/bo/2.png') ?>" alt="Muhammad Abdul Rahman"></div><div class="personnel-info"><span class="personnel-name">Muhammad Abdul Rahman</span><span class="personnel-role">Wakil Sekretaris Bidang</span></div></li>
                                        </ul>
                                        <hr><h6 class="member-title">Anggota</h6>
                                        <ul class="personnel-list member">
                                            <li><div class="personnel-photo"><img src="<?= base_url('uploads/bo/3.png') ?>" alt="Said An Nazar"></div><div class="personnel-info"><span class="personnel-name">Said An Nazar</span></div></li>
                                            <li><div class="personnel-photo"><img src="<?= base_url('uploads/bo/4.png') ?>" alt="Alfian Fajar Budi Nugroho"></div><div class="personnel-info"><span class="personnel-name">Alfian Fajar Budi Nugroho</span></div></li>
                                            <li><div class="personnel-photo"><img src="<?= base_url('uploads/bo/5.png') ?>" alt="Zaki Tri Pamungkas"></div><div class="personnel-info"><span class="personnel-name">Zaki Tri Pamungkas</span></div></li>
                                            <li><div class="personnel-photo"><img src="<?= base_url('uploads/bo/6.png') ?>" alt="Agus Salim"></div><div class="personnel-info"><span class="personnel-name">Agus Salim</span></div></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="division-card">
                                    <h5 class="division-title">Bidang Dakwah & Pengkajian Agama</h5>
                                        <ul class="personnel-list">
                                            <li><div class="personnel-photo"><img src="<?= base_url('uploads/dakwah/dakwah/syahrul.png') ?>" alt="M. Syahrul Shidiq"></div><div class="personnel-info"><span class="personnel-name">M. Syahrul Shidiq</span><span class="personnel-role">Wakil Ketua Bidang</span></div></li>
                                            <li><div class="personnel-photo"><img src="<?= base_url('uploads/dakwah/dakwah/yusuf.png') ?>" alt="Yusuf Naufal"></div><div class="personnel-info"><span class="personnel-name">Yusuf Naufal</span><span class="personnel-role">Wakil Sekretaris Bidang</span></div></li>
                                        </ul>
                                        <hr><h6 class="member-title">Anggota</h6>
                                        <ul class="personnel-list member">
                                            <li><div class="personnel-photo"><img src="<?= base_url('default.png') ?>" alt="Wisnu Wijanarko"></div><div class="personnel-info"><span class="personnel-name">Wisnu Wijanarko</span></div></li>
                                            <li><div class="personnel-photo"><img src="<?= base_url('default.png') ?>" alt="Nanda Bagus Romadlon"></div><div class="personnel-info"><span class="personnel-name">Nanda Bagus Romadlon</span></div></li>
                                            <li><div class="personnel-photo"><img src="<?= base_url('default.png') ?>" alt="Andri Rosyad Kurniawan"></div><div class="personnel-info"><span class="personnel-name">Andri Rosyad Kurniawan</span></div></li>
                                            <li><div class="personnel-photo"><img src="<?= base_url('uploads/dakwah/dakwah/husna.png') ?>" alt="Muhammad Afad Al Husna"></div><div class="personnel-info"><span class="personnel-name">Muhammad Afad Al Husna</span></div></li>
                                            <li><div class="personnel-photo"><img src="<?= base_url('uploads/dakwah/dakwah/roh.png') ?>" alt="Roh Prehadi Santoso"></div><div class="personnel-info"><span class="personnel-name">Roh Prehadi Santoso</span></div></li>
                                            <li><div class="personnel-photo"><img src="<?= base_url('uploads/dakwah/dakwah/novan.png') ?>" alt="Novan Dwi Santoso"></div><div class="personnel-info"><span class="personnel-name">Novan Dwi Santoso</span></div></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="division-card">
                                    <h5 class="division-title">Bidang Pendidikan & Kaderisasi</h5>
                                        <ul class="personnel-list">
                                            <li><div class="personnel-photo"><img src="<?= base_url('uploads/kader/kader/nur.png') ?>" alt="Nur Wijayanto"></div><div class="personnel-info"><span class="personnel-name">Nur Wijayanto</span><span class="personnel-role">Wakil Ketua Bidang</span></div></li>
                                            <li><div class="personnel-photo"><img src="<?= base_url('uploads/kader/kader/giri.png') ?>" alt="Giri Suratno"></div><div class="personnel-info"><span class="personnel-name">Giri Suratno</span><span class="personnel-role">Wakil Sekretaris Bidang</span></div></li>
                                        </ul>
                                        <hr><h6 class="member-title">Anggota</h6>
                                        <ul class="personnel-list member">
                                            <li><div class="personnel-photo"><img src="<?= base_url('uploads/kader/kader/andri.png') ?>" alt="Andri"></div><div class="personnel-info"><span class="personnel-name">Andri</span></div></li>
                                            <li><div class="personnel-photo"><img src="<?= base_url('uploads/kader/kader/yusuf.png') ?>" alt="Muh Yusuf Sofyan"></div><div class="personnel-info"><span class="personnel-name">Muh Yusuf Sofyan</span></div></li>
                                            <li><div class="personnel-photo"><img src="<?= base_url('uploads/kader/kader/kolik.png') ?>" alt="Abdul Kholik"></div><div class="personnel-info"><span class="personnel-name">Abdul Kholik</span></div></li>
                                            <li><div class="personnel-photo"><img src="<?= base_url('default.png') ?>" alt="Deni Budi Prasetyo"></div><div class="personnel-info"><span class="personnel-name">Deni Budi Prasetyo</span></div></li>
                                            <li><div class="personnel-photo"><img src="<?= base_url('uploads/kader/kader/fauzi.png') ?>" alt="Ahmad Fauzi"></div><div class="personnel-info"><span class="personnel-name">Ahmad Fauzi</span></div></li>
                                            <li><div class="personnel-photo"><img src="<?= base_url('default.png') ?>" alt="Arfan Rifqi Fauzi"></div><div class="personnel-info"><span class="personnel-name">Arfan Rifqi Fauzi</span></div></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="division-card">
                                        <h5 class="division-title">Bidang Hukum, HAM & Advokasi</h5>
                                        <ul class="personnel-list">
                                            <li><div class="personnel-photo"><img src="<?= base_url('default.png') ?>" alt="Husain Faqihuddin Asy Sarif"></div><div class="personnel-info"><span class="personnel-name">Husain Faqihuddin Asy Sarif</span><span class="personnel-role">Wakil Ketua Bidang</span></div></li>
                                            <li><div class="personnel-photo"><img src="<?= base_url('default.png') ?>" alt="Prasetyo Dwi Basuki"></div><div class="personnel-info"><span class="personnel-name">Prasetyo Dwi Basuki</span><span class="personnel-role">Wakil Sekretaris Bidang</span></div></li>
                                        </ul>
                                        <hr><h6 class="member-title">Anggota</h6>
                                        <ul class="personnel-list member">
                                            <li><div class="personnel-photo"><img src="<?= base_url('default.png') ?>" alt="Koko Noviana"></div><div class="personnel-info"><span class="personnel-name">Koko Noviana</span></div></li>
                                            <li><div class="personnel-photo"><img src="<?= base_url('default.png') ?>" alt="Setianto Tri Wibowo"></div><div class="personnel-info"><span class="personnel-name">Setianto Tri Wibowo</span></div></li>
                                            <li><div class="personnel-photo"><img src="<?= base_url('default.png') ?>" alt="Agus Murtiyana"></div><div class="personnel-info"><span class="personnel-name">Agus Murtiyana</span></div></li>
                                            <li><div class="personnel-photo"><img src="<?= base_url('default.png') ?>" alt="Budi Sutarto"></div><div class="personnel-info"><span class="personnel-name">Budi Sutarto</span></div></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="division-card">
                                        <h5 class="division-title">Bidang ESDM & Lingkungan Hidup</h5>
                                        <ul class="personnel-list">
                                            <li><div class="personnel-photo"><img src="<?= base_url('default.png') ?>" alt="Niko Alamsyach"></div><div class="personnel-info"><span class="personnel-name">Niko Alamsyach</span><span class="personnel-role">Wakil Ketua Bidang</span></div></li>
                                            <li><div class="personnel-photo"><img src="<?= base_url('default.png') ?>" alt="Muhammad Isnan"></div><div class="personnel-info"><span class="personnel-name">Muhammad Isnan</span><span class="personnel-role">Wakil Sekretaris Bidang</span></div></li>
                                        </ul>
                                        <hr><h6 class="member-title">Anggota</h6>
                                        <ul class="personnel-list member">
                                            <li><div class="personnel-photo"><img src="<?= base_url('default.png') ?>" alt="Hasan Arifin As Syarif"></div><div class="personnel-info"><span class="personnel-name">Hasan Arifin As Syarif</span></div></li>
                                            <li><div class="personnel-photo"><img src="<?= base_url('default.png') ?>" alt="Qintara Rafiandra"></div><div class="personnel-info"><span class="personnel-name">Qintara Rafiandra</span></div></li>
                                            <li><div class="personnel-photo"><img src="<?= base_url('default.png') ?>" alt="Robi Muslim"></div><div class="personnel-info"><span class="personnel-name">Robi Muslim</span></div></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="program" role="tabpanel" aria-labelledby="program-tab">
                <div class="content-card">
                    <h2 class="section-title-small mb-5 text-center mx-auto csp-max-width-600">
                        <i class="bi bi-list-task text-primary me-2"></i>
                        Program Kerja & Jadwal
                    </h2>
                    <div class="programs-grid">
                        <div class="row g-4">
                            <!-- Organisasi & Keanggotaan -->
                            <div class="col-lg-4 col-md-6">
                                <div class="program-card">
                                    <div class="program-icon"><i class="bi bi-people text-primary"></i></div>
                                    <h4>Organisasi & Keanggotaan</h4>
                                    <ul class="program-list">
                                        <li>Database — Juni 2025</li>
                                        <li>Rakerda I — Juli 2025</li>
                                        <li>Rakerda II — Januari 2026</li>
                                        <li>Turba — Feb–Maret 2026 & 2007</li>
                                        <li>Rapimda I — Agustus 2026</li>
                                        <li>Rakerda III — Januari 2027</li>
                                    </ul>
                                </div>
                            </div>
                            <!-- Dakwah & Pengkajian Agama -->
                            <div class="col-lg-4 col-md-6">
                                <div class="program-card">
                                    <div class="program-icon"><i class="bi bi-building text-success"></i></div>
                                    <h4>Dakwah & Pengkajian Agama</h4>
                                    <ul class="program-list">
                                        <li>Semasa — Rutin Mingguan</li>
                                        <li>Safari Ramadhan — Feb–Maret 2026 & 2027</li>
                                    </ul>
                                </div>
                            </div>
                            <!-- Pendidikan & Kaderisasi -->
                            <div class="col-lg-4 col-md-6">
                                <div class="program-card">
                                    <div class="program-icon"><i class="bi bi-mortarboard text-info"></i></div>
                                    <h4>Pendidikan & Kaderisasi</h4>
                                    <ul class="program-list">
                                        <li>BAD — Agustus 2025</li>
                                        <li>Sekolah Kader — September 2025</li>
                                        <li>Pendataan SDM Kader di AUM — Desember 2025</li>
                                        <li>Silaturahmi Kader Muh — April 2026</li>
                                    </ul>
                                </div>
                            </div>
                            <!-- Kokam & SAR -->
                            <div class="col-lg-4 col-md-6">
                                <div class="program-card">
                                    <div class="program-icon"><i class="bi bi-shield-check text-danger"></i></div>
                                    <h4>Kokam & SAR</h4>
                                    <ul class="program-list">
                                        <li>Pendataan Anggota — Juni 2025</li>
                                        <li>Rebranding Mobil Kokam — Agustus 2025</li>
                                        <li>Pengadaan Jaket Kokam — Agustus 2025</li>
                                        <li>Pengadaan KTA Kokam — Agustus 2025</li>
                                        <li>Diksar Kokam — Desember 2026</li>
                                    </ul>
                                </div>
                            </div>
                            <!-- KOMINFO RISTEK -->
                            <div class="col-lg-4 col-md-6">
                                <div class="program-card">
                                    <div class="program-icon"><i class="bi bi-laptop text-secondary"></i></div>
                                    <h4>KOMINFO RISTEK</h4>
                                    <ul class="program-list">
                                        <li>Pembuatan Website — Juni 2025</li>
                                        <li>Launching Produk 3D — Oktober 2025</li>
                                    </ul>
                                </div>
                            </div>
                            <!-- Ekowir & Buruh Tani -->
                            <div class="col-lg-4 col-md-6">
                                <div class="program-card">
                                    <div class="program-icon"><i class="bi bi-tree text-success"></i></div>
                                    <h4>Ekowir & Buruh Tani</h4>
                                    <ul class="program-list">
                                        <li>Seminar Ekonomi — Juni 2026</li>
                                    </ul>
                                </div>
                            </div>
                            <!-- Hikmah & Hubungan antar Lembaga -->
                            <div class="col-lg-4 col-md-6">
                                <div class="program-card">
                                    <div class="program-icon"><i class="bi bi-handshake text-warning"></i></div>
                                    <h4>Hikmah & Hubungan antar Lembaga</h4>
                                    <ul class="program-list">
                                        <li>Sosialisasi Politik — Juli 2026</li>
                                        <li>Dikpol — Mei 2027</li>
                                    </ul>
                                </div>
                            </div>
                            <!-- Seni Budaya, Olahraga, Pariwisata -->
                            <div class="col-lg-4 col-md-6">
                                <div class="program-card">
                                    <div class="program-icon"><i class="bi bi-palette text-info"></i></div>
                                    <h4>Seni Budaya, Olahraga, Pariwisata</h4>
                                    <ul class="program-list">
                                        <li>Pembentukan Tim Outbond — September 2025</li>
                                        <li>Seminar & Launching Program Mingguan — Desember 2025</li>
                                        <li>Pemuda Muhammadiyah CUP — April 2026 & 2027</li>
                                        <li>Sekolah Pambiworo — Oktober 2026</li>
                                    </ul>
                                </div>
                            </div>
                            <!-- Hukum, HAM & Advokasi -->
                            <div class="col-lg-4 col-md-6">
                                <div class="program-card">
                                    <div class="program-icon"><i class="bi bi-hammer text-dark"></i></div>
                                    <h4>Hukum, HAM & Advokasi</h4>
                                    <ul class="program-list">
                                        <li>Sekolah Advokasi — Juli 2027</li>
                                    </ul>
                                </div>
                            </div>
                            <!-- ESDM & Lingkungan Hidup -->
                            <div class="col-lg-4 col-md-6">
                                <div class="program-card">
                                    <div class="program-icon"><i class="bi bi-globe text-primary"></i></div>
                                    <h4>ESDM & Lingkungan Hidup</h4>
                                    <ul class="program-list">
                                        <li>Seminar — Oktober 2025</li>
                                        <li>Ploging — September 2026</li>
                                        <li>Tanam Lestari — Juni 2027</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>



<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Intersection Observer for scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate');
                if (entry.target.classList.contains('modern-timeline-item')) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            }
        });
    }, observerOptions);

    // Observe timeline items
    const timelineItems = document.querySelectorAll('.modern-timeline-item');
    timelineItems.forEach((el, index) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(50px)';
        el.style.transition = `opacity 0.8s ease-out ${index * 0.2}s, transform 0.8s ease-out ${index * 0.2}s`;
        observer.observe(el);
    });

    // Observe other animated elements
    const animatedElements = document.querySelectorAll('.fade-in-up, .slide-in-left, .slide-in-right');
    animatedElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'opacity 0.8s ease-out, transform 0.8s ease-out';
        observer.observe(el);
    });

    // Modern timeline card hover effects
    const timelineCards = document.querySelectorAll('.timeline-content-card');
    timelineCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Modern leader card interactions
    const leaderCardsModern = document.querySelectorAll('.leader-card-modern');
    leaderCardsModern.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Highlight item interactions
    const highlightItems = document.querySelectorAll('.highlight-item-modern');
    highlightItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(10px) scale(1.02)';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0) scale(1)';
        });
    });

    // Hero image parallax effect
    const heroImageCard = document.querySelector('.hero-image-card');
    if (heroImageCard) {
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const rate = scrolled * -0.3;
            heroImageCard.style.transform = `perspective(1000px) rotateY(-5deg) rotateX(5deg) translateY(${rate}px)`;
        });
    }

    // Vision image parallax effect
    const visionImageCard = document.querySelector('.vision-image-card');
    if (visionImageCard) {
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const rate = scrolled * -0.2;
            visionImageCard.style.transform = `scale(1.02) translateY(${rate}px)`;
        });
    }

    // Smooth scroll for navigation
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('data-bs-target');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Add loading animation
    const contentCard = document.querySelector('.content-card');
    if (contentCard) {
        contentCard.style.opacity = '0';
        contentCard.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            contentCard.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
            contentCard.style.opacity = '1';
            contentCard.style.transform = 'translateY(0)';
        }, 100);
    }

    // Modern Timeline Animations
    const timelineItems = document.querySelectorAll('.timeline-item-modern');
    timelineItems.forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(50px)';
        
        // Adjust animation delay based on screen size
        const isMobile = window.innerWidth <= 768;
        const delay = isMobile ? index * 0.1 : index * 0.2;
        item.style.transition = `opacity 0.8s ease-out ${delay}s, transform 0.8s ease-out ${delay}s`;
        
        const timelineObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { 
            threshold: window.innerWidth <= 768 ? 0.05 : 0.1,
            rootMargin: window.innerWidth <= 768 ? '50px' : '0px'
        });
        
        timelineObserver.observe(item);
    });

    // Modern Leadership Cards Animation
    const leaderCards = document.querySelectorAll('.leader-card-modern');
    leaderCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        
        // Adjust animation delay based on screen size
        const isMobile = window.innerWidth <= 768;
        const delay = isMobile ? index * 0.05 : index * 0.1;
        card.style.transition = `opacity 0.6s ease-out ${delay}s, transform 0.6s ease-out ${delay}s`;
        
        const leaderObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { 
            threshold: window.innerWidth <= 768 ? 0.05 : 0.1,
            rootMargin: window.innerWidth <= 768 ? '30px' : '0px'
        });
        
        leaderObserver.observe(card);
    });

    // Modern Focus Cards Animation
    const focusCards = document.querySelectorAll('.focus-card-modern');
    focusCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        
        // Adjust animation delay based on screen size
        const isMobile = window.innerWidth <= 768;
        const delay = isMobile ? index * 0.1 : index * 0.2;
        card.style.transition = `opacity 0.6s ease-out ${delay}s, transform 0.6s ease-out ${delay}s`;
        
        const focusObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { 
            threshold: window.innerWidth <= 768 ? 0.05 : 0.1,
            rootMargin: window.innerWidth <= 768 ? '30px' : '0px'
        });
        
        focusObserver.observe(card);
    });

    // Hero Image Hover Effects
    const heroImageContainer = document.querySelector('.image-container-modern');
    if (heroImageContainer) {
        heroImageContainer.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.02)';
        });
        
        heroImageContainer.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    }

    // Timeline Card Hover Effects
    const timelineCards = document.querySelectorAll('.timeline-card');
    timelineCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px)';
            this.style.boxShadow = '0 25px 50px rgba(0, 0, 0, 0.15)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 15px 35px rgba(0, 0, 0, 0.1)';
        });
    });

    // Leader Card Hover Effects
    const leaderCardsModern = document.querySelectorAll('.leader-card-modern');
    leaderCardsModern.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px)';
            this.style.boxShadow = '0 25px 50px rgba(0, 0, 0, 0.15)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 15px 35px rgba(0, 0, 0, 0.1)';
        });
    });

    // Focus Card Hover Effects
    const focusCardsModern = document.querySelectorAll('.focus-card-modern');
    focusCardsModern.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px)';
            this.style.boxShadow = '0 25px 50px rgba(0, 0, 0, 0.15)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 15px 35px rgba(0, 0, 0, 0.1)';
        });
    });

    // Timeline Marker Animation
    const timelineMarkers = document.querySelectorAll('.marker-icon');
    timelineMarkers.forEach(marker => {
        marker.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.1) rotate(10deg)';
            this.style.boxShadow = '0 12px 35px rgba(220, 53, 69, 0.5)';
        });
        
        marker.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1) rotate(0deg)';
            this.style.boxShadow = '0 8px 25px rgba(220, 53, 69, 0.4)';
        });
    });

    // Focus Icon Animation
    const focusIcons = document.querySelectorAll('.focus-icon-modern');
    focusIcons.forEach(icon => {
        icon.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.1) rotate(10deg)';
            this.style.boxShadow = '0 12px 35px rgba(220, 53, 69, 0.4)';
        });
        
        icon.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1) rotate(0deg)';
            this.style.boxShadow = '0 8px 25px rgba(220, 53, 69, 0.3)';
        });
    });

    // Hero Stats Counter Animation
    const statNumbers = document.querySelectorAll('.stat-number');
    statNumbers.forEach(stat => {
        const target = parseInt(stat.textContent);
        const increment = target / 50;
        let current = 0;
        
        const updateCounter = () => {
            if (current < target) {
                current += increment;
                stat.textContent = Math.ceil(current) + '+';
                requestAnimationFrame(updateCounter);
            } else {
                stat.textContent = target + '+';
            }
        };
        
        const statObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    updateCounter();
                    statObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        
        statObserver.observe(stat);
    });

    // Image loading debugging and fallback
    const heroImage = document.querySelector('.hero-img');
    if (heroImage) {
        // Check if image loads successfully
        heroImage.addEventListener('load', function() {
            console.log('Hero image loaded successfully');
            this.style.opacity = '1';
        });
        
        heroImage.addEventListener('error', function() {
            console.log('Hero image failed to load, trying alternatives...');
            
            // Try alternative paths
            const alternatives = [
                '<?= base_url('images.jpg') ?>',
                '<?= base_url('public/images.jpg') ?>',
                '<?= base_url('default.png') ?>',
                '<?= base_url('logo.png') ?>'
            ];
            
            let currentIndex = 0;
            const tryNextImage = () => {
                if (currentIndex < alternatives.length) {
                    this.src = alternatives[currentIndex];
                    currentIndex++;
                } else {
                    console.log('All image alternatives failed');
                    this.style.background = 'linear-gradient(135deg, #f8f9fa, #e9ecef)';
                    this.style.display = 'flex';
                    this.style.alignItems = 'center';
                    this.style.justifyContent = 'center';
                    this.innerHTML = '<span style="color: #6c757d; font-size: 1.5rem;">📷</span>';
                }
            };
            
            tryNextImage();
        });
        
        // Preload the image
        const img = new Image();
        img.onload = function() {
            console.log('Image preloaded successfully');
        };
        img.onerror = function() {
            console.log('Image preload failed');
        };
        img.src = heroImage.src;
    }

    // Responsive adjustments on window resize
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function() {
            // Recalculate animation delays based on new screen size
            const isMobile = window.innerWidth <= 768;
            
            // Update timeline items
            timelineItems.forEach((item, index) => {
                const delay = isMobile ? index * 0.1 : index * 0.2;
                item.style.transition = `opacity 0.8s ease-out ${delay}s, transform 0.8s ease-out ${delay}s`;
            });
            
            // Update leader cards
            leaderCards.forEach((card, index) => {
                const delay = isMobile ? index * 0.05 : index * 0.1;
                card.style.transition = `opacity 0.6s ease-out ${delay}s, transform 0.6s ease-out ${delay}s`;
            });
            
            // Update focus cards
            focusCards.forEach((card, index) => {
                const delay = isMobile ? index * 0.1 : index * 0.2;
                card.style.transition = `opacity 0.6s ease-out ${delay}s, transform 0.6s ease-out ${delay}s`;
            });
        }, 250);
    });

    // Touch device optimizations
    if ('ontouchstart' in window) {
        // Reduce hover effects on touch devices
        const hoverElements = document.querySelectorAll('.timeline-card, .leader-card-modern, .focus-card-modern, .image-container-modern');
        hoverElements.forEach(element => {
            element.style.transition = 'transform 0.2s ease, box-shadow 0.2s ease';
        });
        
        // Optimize scroll performance on mobile
        document.body.style.webkitOverflowScrolling = 'touch';
    }

    // Performance optimization for low-end devices
    if (navigator.hardwareConcurrency && navigator.hardwareConcurrency < 4) {
        // Reduce animation complexity for low-end devices
        const animatedElements = document.querySelectorAll('.timeline-item-modern, .leader-card-modern, .focus-card-modern');
        animatedElements.forEach(element => {
            element.style.willChange = 'auto';
        });
    }
});
</script>
<?= $this->endSection() ?>