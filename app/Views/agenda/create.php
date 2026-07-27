<?= $this->extend('layout/template') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/admin-agenda.css') ?>">
<style>
    .form-section {
        background: #f8f9fa;
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .form-section-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: #dc3545;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .form-section-title i {
        font-size: 1.25rem;
    }
    .map-preview {
        height: 300px;
        background: #e9ecef;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
        margin-top: 1rem;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Header Section -->
<div class="agenda-header-section mb-4">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h2 class="agenda-title mb-2">
                <i class="bi bi-calendar-plus text-danger me-2"></i>
                Tambah Agenda Baru
            </h2>
            <p class="text-muted mb-0">
                Buat agenda kegiatan untuk PDPM Karanganyar
            </p>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="<?= site_url('admin-agenda') ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body p-4">
        <?php $errors = session()->get('errors'); ?>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Perhatian!</strong> Terdapat beberapa kesalahan:
                <ul class="mb-0 mt-2">
                <?php foreach ($errors as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif ?>

        <form action="<?= site_url('admin-agenda/store') ?>" method="post">
            <?= csrf_field() ?>
            
            <!-- Informasi Dasar -->
            <div class="form-section">
                <h5 class="form-section-title">
                    <i class="bi bi-info-circle"></i>
                    Informasi Dasar
                </h5>
                
                <div class="mb-3">
                    <label for="nama_kegiatan" class="form-label fw-semibold">
                        Nama Kegiatan <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control form-control-lg" id="nama_kegiatan" 
                           name="nama_kegiatan" value="<?= old('nama_kegiatan') ?>" 
                           placeholder="Masukkan nama kegiatan" required>
                    <small class="form-text text-muted">Nama kegiatan yang jelas dan deskriptif</small>
                </div>

                <?php if ($user_role == 1): // Hanya superadmin yang bisa pilih tingkat ?>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tingkat_agenda" class="form-label fw-semibold">
                            Tingkat Agenda <span class="text-danger">*</span>
                        </label>
                        <select class="form-select form-select-lg" id="tingkat_agenda" name="tingkat_agenda" onchange="toggleCabangSelect()">
                            <option value="daerah" <?= old('tingkat_agenda') == 'daerah' ? 'selected' : '' ?>>
                                🏢 Agenda Daerah (Untuk Semua Cabang)
                            </option>
                            <option value="cabang" <?= old('tingkat_agenda') == 'cabang' ? 'selected' : '' ?>>
                                📍 Agenda Cabang (Khusus Cabang Tertentu)
                            </option>
                        </select>
                        <small class="form-text text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            Pilih cakupan agenda kegiatan
                        </small>
                    </div>
                    <div class="col-md-6 mb-3" id="cabang-select-container" style="display: none;">
                        <label for="id_cabang_khusus" class="form-label fw-semibold">
                            Pilih Cabang <span class="text-danger">*</span>
                        </label>
                        <select class="form-select form-select-lg" id="id_cabang_khusus" name="id_cabang_khusus">
                            <option value="">-- Pilih Cabang --</option>
                            <?php foreach ($cabang_list as $cabang): ?>
                                <option value="<?= $cabang['id'] ?>" <?= old('id_cabang_khusus') == $cabang['id'] ? 'selected' : '' ?>>
                                    <?= esc($cabang['nama_cabang']) ?> 
                                    <?php if (!empty($cabang['wilayah'])): ?>
                                        - <?= esc($cabang['wilayah']) ?>
                                    <?php endif; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="form-text text-muted">
                            <i class="bi bi-geo-alt me-1"></i>
                            Cabang yang akan mengikuti agenda ini
                        </small>
                    </div>
                </div>
                <?php else: ?>
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Agenda Cabang:</strong> Sebagai admin cabang, agenda yang Anda buat akan otomatis menjadi agenda khusus cabang Anda.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label fw-semibold">
                        Deskripsi <span class="text-danger">*</span>
                    </label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" 
                              placeholder="Jelaskan detail kegiatan, tujuan, dan informasi penting lainnya" 
                              required><?= old('deskripsi') ?></textarea>
                    <small class="form-text text-muted">Minimal 20 karakter</small>
                </div>
            </div>

            <!-- Waktu Pelaksanaan -->
            <div class="form-section">
                <h5 class="form-section-title">
                    <i class="bi bi-clock"></i>
                    Waktu Pelaksanaan
                </h5>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_mulai" class="form-label fw-semibold">
                            Tanggal & Waktu Mulai <span class="text-danger">*</span>
                        </label>
                        <input type="datetime-local" class="form-control form-control-lg" 
                               id="tanggal_mulai" name="tanggal_mulai" 
                               value="<?= old('tanggal_mulai') ?>" required>
                        <small class="form-text text-muted">
                            <i class="bi bi-calendar-event me-1"></i>
                            Waktu mulai kegiatan
                        </small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_selesai" class="form-label fw-semibold">
                            Tanggal & Waktu Selesai <span class="text-muted">(Opsional)</span>
                        </label>
                        <input type="datetime-local" class="form-control form-control-lg" 
                               id="tanggal_selesai" name="tanggal_selesai" 
                               value="<?= old('tanggal_selesai') ?>">
                        <small class="form-text text-muted">
                            <i class="bi bi-calendar-check me-1"></i>
                            Kosongkan jika kegiatan selesai di hari yang sama
                        </small>
                    </div>
                </div>
            </div>

            <!-- Lokasi & Absensi -->
            <div class="form-section">
                <h5 class="form-section-title">
                    <i class="bi bi-geo-alt"></i>
                    Lokasi & Pengaturan Absensi
                </h5>
                
                <div class="mb-3">
                    <label for="lokasi" class="form-label fw-semibold">
                        Lokasi Kegiatan <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control form-control-lg" id="lokasi" 
                           name="lokasi" value="<?= old('lokasi') ?>" 
                           placeholder="Contoh: Gedung Dakwah Muhammadiyah Karanganyar" required>
                    <small class="form-text text-muted">
                        <i class="bi bi-geo me-1"></i>
                        Nama tempat atau alamat lengkap lokasi kegiatan
                    </small>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="latitude" class="form-label fw-semibold">
                            Latitude <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="latitude" name="latitude" 
                               value="<?= old('latitude') ?>" placeholder="-7.56789" required>
                        <small class="form-text text-muted">Koordinat lintang</small>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="longitude" class="form-label fw-semibold">
                            Longitude <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="longitude" name="longitude" 
                               value="<?= old('longitude') ?>" placeholder="110.12345" required>
                        <small class="form-text text-muted">Koordinat bujur</small>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="radius_meter" class="form-label fw-semibold">
                            Radius Absensi <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="radius_meter" 
                                   name="radius_meter" value="<?= old('radius_meter', 100) ?>" 
                                   min="10" max="5000" required>
                            <span class="input-group-text">meter</span>
                        </div>
                        <small class="form-text text-muted">Jarak maksimal untuk absen</small>
                    </div>
                </div>

                <div class="alert alert-warning" role="alert">
                    <i class="bi bi-lightbulb me-2"></i>
                    <strong>Tips:</strong> Anda bisa mendapatkan koordinat dari Google Maps dengan klik kanan pada lokasi dan pilih koordinat.
                </div>

                <!-- Map Preview (Optional) -->
                <div class="map-preview">
                    <i class="bi bi-map fs-1"></i>
                    <p class="mt-2">Preview peta akan ditampilkan di sini</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="<?= site_url('admin-agenda') ?>" class="btn btn-lg btn-outline-secondary">
                    <i class="bi bi-x-circle me-2"></i>Batal
                </a>
                <button type="submit" class="btn btn-lg btn-danger px-4">
                    <i class="bi bi-save me-2"></i>Simpan Agenda
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleCabangSelect() {
    const tingkatSelect = document.getElementById('tingkat_agenda');
    const cabangContainer = document.getElementById('cabang-select-container');
    const cabangSelect = document.getElementById('id_cabang_khusus');
    
    if (tingkatSelect.value === 'cabang') {
        cabangContainer.style.display = 'block';
        cabangSelect.required = true;
    } else {
        cabangContainer.style.display = 'none';
        cabangSelect.required = false;
        cabangSelect.value = '';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleCabangSelect();
});
</script>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const latInput = document.getElementById('latitude');
        const lonInput = document.getElementById('longitude');
        const mapPreviewContainer = document.querySelector('.map-preview');

        let map, marker;
        
        function initMap(lat, lon) {
            if (map) return;

            mapPreviewContainer.innerHTML = ''; 
            mapPreviewContainer.style.height = '300px';
            mapPreviewContainer.id = 'map'; 

            map = L.map('map').setView([lat, lon], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            marker = L.marker([lat, lon]).addTo(map);
        }

        function updateMap() {
            let lat = parseFloat(latInput.value);
            let lon = parseFloat(lonInput.value);

            if (!isNaN(lat) && !isNaN(lon)) {
                if (!map) {
                    initMap(lat, lon);
                } else {
                    const newLatLng = L.latLng(lat, lon);
                    map.setView(newLatLng, 13);
                    marker.setLatLng(newLatLng);
                }
            }
        }

        latInput.addEventListener('input', updateMap);
        lonInput.addEventListener('input', updateMap);
    });
</script>
<?= $this->endSection() ?>
