<?= $this->extend('layout/public_template') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/profil.css') ?>"><!-- samakan gaya dengan halaman profil -->
<link rel="stylesheet" href="<?= base_url('css/kontak.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$headerData = [
    'title' => 'Hubungi Kami',
    'subtitle' => 'Jangan ragu untuk menghubungi kami. Kami siap membantu dan menjawab pertanyaan Anda',
    'icon' => 'bi-telephone',
    'stats' => [
        'total_anggota' => $totalAnggota ?? 0,
        'total_cabang' => $totalCabang ?? 0,
        'total_ranting' => $totalRanting ?? 0,
        'total_kokam' => $totalKokam ?? 0
    ]
];
?>
<?= $this->include('layout/page_header', $headerData) ?>

<!-- Main Content -->
<section class="py-5">
    <div class="container">
        <div class="row g-5">
            <!-- Contact Information -->
            <div class="col-lg-5">
                <div class="content-card contact-info-section">
                    <h2 class="section-title-small mb-4">
                        <i class="bi bi-info-circle text-primary me-2"></i>
                        Informasi Kontak
                    </h2>
                    
                    <div class="contact-cards">
                        <!-- Address Card -->
                        <div class="contact-card">
                            <div class="contact-icon">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div class="contact-content">
                                <h5 class="contact-title">Alamat Kantor</h5>
                                <p class="contact-text">
                                    Gedung Dakwah Muhammadiyah<br>
                                    Pengurus Daerah Muhammadiyah Karanganyar
                                </p>
                            </div>
                        </div>
                        
                        <!-- Phone Card -->
                        <div class="contact-card">
                            <div class="contact-icon">
                                <i class="bi bi-telephone"></i>
                            </div>
                            <div class="contact-content">
                                <h5 class="contact-title">Telepon</h5>
                                <p class="contact-text">
                                    <a href="tel:+62271123456" class="contact-link">+62 271 123456</a><br>
                                    <a href="tel:+628123456789" class="contact-link">+62 812 3456 789</a>
                                </p>
                            </div>
                        </div>
                        
                        <!-- Email Card -->
                        <div class="contact-card">
                            <div class="contact-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <div class="contact-content">
                                <h5 class="contact-title">Email</h5>
                                <p class="contact-text">
                                    <a href="mailto:info@pdpmkaranganyar.org" class="contact-link">info@pdpmkaranganyar.org</a><br>
                                    <a href="mailto:admin@pdpmkaranganyar.org" class="contact-link">admin@pdpmkaranganyar.org</a>
                                </p>
                            </div>
                        </div>
                        
                        <!-- Social Media Card -->
                        <div class="contact-card">
                            <div class="contact-icon">
                                <i class="bi bi-share"></i>
                            </div>
                            <div class="contact-content">
                                <h5 class="contact-title">Media Sosial</h5>
                                <div class="social-links">
                                    <a href="#" class="social-link facebook" title="Facebook">
                                        <i class="bi bi-facebook"></i>
                                    </a>
                                    <a href="#" class="social-link instagram" title="Instagram">
                                        <i class="bi bi-instagram"></i>
                                    </a>
                                    <a href="#" class="social-link youtube" title="YouTube">
                                        <i class="bi bi-youtube"></i>
                                    </a>
                                    <a href="#" class="social-link twitter" title="Twitter">
                                        <i class="bi bi-twitter-x"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>
                </div>
            </div>
            
            <!-- Contact Form -->
            <div class="col-lg-7">
                <div class="content-card contact-form-section">
                    <h2 class="section-title-small mb-4">
                        <i class="bi bi-send text-primary me-2"></i>
                        Kirim Pesan
                    </h2>
                    
                    <div class="contact-form-card">
                        <form id="contactForm" class="contact-form">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="form-label">
                                            <i class="bi bi-person me-2 text-primary"></i>Nama Lengkap
                                        </label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="form-label">
                                            <i class="bi bi-envelope me-2 text-primary"></i>Email
                                        </label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone" class="form-label">
                                            <i class="bi bi-telephone me-2 text-primary"></i>Nomor Telepon
                                        </label>
                                        <input type="tel" class="form-control" id="phone" name="phone">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="subject" class="form-label">
                                            <i class="bi bi-tag me-2 text-primary"></i>Subjek
                                        </label>
                                        <select class="form-control" id="subject" name="subject" required>
                                            <option value="">Pilih Subjek</option>
                                            <option value="informasi">Informasi Umum</option>
                                            <option value="keanggotaan">Keanggotaan</option>
                                            <option value="kegiatan">Kegiatan</option>
                                            <option value="kerjasama">Kerjasama</option>
                                            <option value="lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="message" class="form-label">
                                            <i class="bi bi-chat-dots me-2 text-primary"></i>Pesan
                                        </label>
                                        <textarea class="form-control" id="message" name="message" rows="6" required placeholder="Tulis pesan Anda di sini..."></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="submit-btn">
                                        <span class="btn-text">
                                            <i class="bi bi-send me-2"></i>
                                            Kirim Pesan
                                        </span>
                                        <span class="btn-loading csp-d-none">
                                            <i class="bi bi-arrow-clockwise me-2"></i>
                                            Mengirim...
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Map Section -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="content-card map-section">
                    <h2 class="section-title-small mb-4 text-center">
                        <i class="bi bi-geo-alt text-primary me-2"></i>
                        Lokasi Kami
                    </h2>
                    <div class="map-container">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.0000000000005!2d110.9151809!3d-7.5863568!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a18170072cc41%3A0x8e554a168bd1599c!2sGedung%20Dakwah%20Muhammadiyah%20Pengurus%20Daerah%20Muhammadiyah%20Karanganyar!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<?= $this->endSection() ?>