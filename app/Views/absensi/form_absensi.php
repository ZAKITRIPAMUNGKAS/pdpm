<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-geo-alt me-2"></i>
                        Absensi GPS: <?= esc($agenda['nama_kegiatan']) ?>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-light border-0 h-100">
                                <div class="card-body">
                                    <h6 class="text-primary mb-3">
                                        <i class="bi bi-calendar-event me-2"></i>
                                        <?= esc($agenda['nama_kegiatan']) ?>
                                    </h6>
                                    
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-geo-alt text-danger me-2"></i>
                                            <strong>Lokasi Kegiatan:</strong>
                                        </div>
                                        <p class="text-muted ms-4 mb-0">
                                            <?= esc($agenda['lokasi']) ?>
                                        </p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-clock text-info me-2"></i>
                                            <strong>Waktu Kegiatan:</strong>
                                        </div>
                                        <p class="text-muted ms-4 mb-0">
                                            <?= date('d M Y', strtotime($agenda['tanggal_mulai'])) ?><br>
                                            <?= date('H:i', strtotime($agenda['jam_mulai'])) ?> - 
                                            <?= date('H:i', strtotime($agenda['jam_selesai'])) ?> WIB
                                        </p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-bullseye text-warning me-2"></i>
                                            <strong>Radius Toleransi:</strong>
                                        </div>
                                        <p class="text-muted ms-4 mb-0">
                                            <?= $agenda['radius_meter'] ?? 100 ?> meter
                                        </p>
                                    </div>

                                    <div class="alert alert-info border-0">
                                        <i class="bi bi-info-circle me-2"></i>
                                        <small>
                                            Pastikan GPS aktif dan izinkan akses lokasi untuk melakukan absensi.
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card border-primary h-100">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="card-title mb-0">
                                        <i class="bi bi-check-circle me-2"></i>
                                        Form Absensi GPS
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div id="status-gps" class="alert alert-info border-0">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-info-circle me-2"></i>
                                            <span>Klik tombol di bawah untuk memulai absensi</span>
                                        </div>
                                    </div>
                                    
                                    <div id="info-lokasi" class="card bg-light border-0 mb-3" style="display: none;">
                                        <div class="card-body p-3">
                                            <h6 class="card-title text-primary mb-2">
                                                <i class="bi bi-geo me-1"></i>
                                                Informasi Lokasi
                                            </h6>
                                            <div class="row">
                                                <div class="col-12">
                                                    <small class="text-muted">
                                                        <strong>Koordinat Anda:</strong><br>
                                                        <span id="koordinat-user" class="font-monospace">-</span>
                                                    </small>
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <small class="text-muted">
                                                        <strong>Jarak ke Lokasi:</strong><br>
                                                        <span id="jarak-lokasi" class="badge bg-secondary">-</span>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <form id="form-absensi" method="post" action="<?= site_url('absensi/proses') ?>">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="id_agenda" value="<?= $agenda['id'] ?>">
                                        <input type="hidden" name="latitude" id="latitude_absen">
                                        <input type="hidden" name="longitude" id="longitude_absen">
                                        <input type="hidden" name="jarak_meter" id="jarak_meter">
                                        
                                        <div class="mb-3">
                                            <label for="keterangan" class="form-label">
                                                <i class="bi bi-chat-text me-1"></i>
                                                Keterangan (Opsional)
                                            </label>
                                            <textarea class="form-control" id="keterangan" name="keterangan" 
                                                      rows="3" placeholder="Tambahkan keterangan jika diperlukan..."></textarea>
                                        </div>
                                        
                                        <div class="d-grid gap-2">
                                            <button type="button" id="btn-get-location" class="btn btn-primary">
                                                <i class="bi bi-geo-alt me-1"></i>
                                                Dapatkan Lokasi GPS
                                            </button>
                                            
                                            <button type="submit" id="btn-submit-absen" class="btn btn-success" 
                                                    style="display: none;" disabled>
                                                <i class="bi bi-check-circle me-1"></i>
                                                Kirim Absensi
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <a href="<?= site_url('absensi/agenda/' . $agenda['id']) ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i>
                            Kembali ke Detail Agenda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnGetLocation = document.getElementById('btn-get-location');
    const btnSubmitAbsen = document.getElementById('btn-submit-absen');
    const statusGps = document.getElementById('status-gps');
    const infoLokasi = document.getElementById('info-lokasi');
    const koordinatUser = document.getElementById('koordinat-user');
    const jarakLokasi = document.getElementById('jarak-lokasi');
    
    // Koordinat lokasi kegiatan
    const latKegiatan = <?= !empty($agenda['latitude']) ? $agenda['latitude'] : 0 ?>;
    const lngKegiatan = <?= !empty($agenda['longitude']) ? $agenda['longitude'] : 0 ?>;
    const radiusToleransi = <?= !empty($agenda['radius_meter']) ? $agenda['radius_meter'] : 100 ?>;
    
    // Validasi koordinat kegiatan
    if (!latKegiatan || !lngKegiatan) {
        statusGps.className = 'alert alert-danger border-0';
        statusGps.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="bi bi-x-circle me-2"></i>
                <span>Koordinat lokasi kegiatan belum diatur. Hubungi admin.</span>
            </div>
        `;
        btnGetLocation.disabled = true;
        return;
    }
    
    btnGetLocation.addEventListener('click', function() {
        if (!navigator.geolocation) {
            showStatus('danger', 'x-circle', 'Browser tidak mendukung GPS');
            return;
        }
        
        showStatus('warning', 'hourglass-split', 'Mengambil lokasi GPS...', true);
        btnGetLocation.disabled = true;
        btnGetLocation.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mengambil Lokasi...';
        
        navigator.geolocation.getCurrentPosition(
            function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                const accuracy = position.coords.accuracy;
                
                // Hitung jarak menggunakan Haversine formula
                const jarak = hitungJarak(lat, lng, latKegiatan, lngKegiatan);
                
                // Update UI
                koordinatUser.textContent = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                
                // Update badge jarak dengan warna
                if (jarak <= radiusToleransi) {
                    jarakLokasi.className = 'badge bg-success';
                    jarakLokasi.textContent = `${jarak.toFixed(2)}m (Valid)`;
                } else {
                    jarakLokasi.className = 'badge bg-danger';
                    jarakLokasi.textContent = `${jarak.toFixed(2)}m (Terlalu Jauh)`;
                }
                
                infoLokasi.style.display = 'block';
                
                // Set hidden inputs
                document.getElementById('latitude_absen').value = lat;
                document.getElementById('longitude_absen').value = lng;
                document.getElementById('jarak_meter').value = jarak;
                
                // Validasi jarak
                if (jarak <= radiusToleransi) {
                    showStatus('success', 'check-circle', `Lokasi valid! Anda dapat melakukan absensi. (Jarak: ${jarak.toFixed(2)}m)`);
                    btnSubmitAbsen.style.display = 'block';
                    btnSubmitAbsen.disabled = false;
                } else {
                    showStatus('danger', 'x-circle', `Anda terlalu jauh dari lokasi kegiatan. Jarak: ${jarak.toFixed(2)}m (Maksimal: ${radiusToleransi}m)`);
                }
                
                // Tambahkan info akurasi GPS
                if (accuracy > 50) {
                    const accuracyWarning = document.createElement('div');
                    accuracyWarning.className = 'alert alert-warning border-0 mt-2';
                    accuracyWarning.innerHTML = `
                        <div class="d-flex align-items-center">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <small>Akurasi GPS rendah (±${accuracy.toFixed(0)}m). Coba pindah ke area terbuka.</small>
                        </div>
                    `;
                    statusGps.parentNode.insertBefore(accuracyWarning, statusGps.nextSibling);
                }
                
                resetButton();
            },
            function(error) {
                let pesan = 'Gagal mendapatkan lokasi GPS';
                let icon = 'x-circle';
                
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        pesan = 'Akses GPS ditolak. Silakan izinkan akses lokasi di browser.';
                        icon = 'shield-x';
                        break;
                    case error.POSITION_UNAVAILABLE:
                        pesan = 'Informasi lokasi tidak tersedia. Pastikan GPS aktif.';
                        icon = 'geo-alt-fill';
                        break;
                    case error.TIMEOUT:
                        pesan = 'Timeout mendapatkan lokasi GPS. Coba lagi.';
                        icon = 'clock';
                        break;
                }
                
                showStatus('danger', icon, pesan);
                resetButton();
            },
            {
                enableHighAccuracy: true,
                timeout: 15000,
                maximumAge: 60000
            }
        );
    });
    
    // Fungsi untuk menampilkan status
    function showStatus(type, icon, message, loading = false) {
        statusGps.className = `alert alert-${type} border-0`;
        statusGps.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="bi bi-${icon} me-2"></i>
                <span>${message}</span>
            </div>
        `;
    }
    
    // Reset button state
    function resetButton() {
        btnGetLocation.disabled = false;
        btnGetLocation.innerHTML = '<i class="bi bi-geo-alt me-1"></i>Dapatkan Lokasi GPS';
    }
    
    // Fungsi Haversine untuk menghitung jarak
    function hitungJarak(lat1, lng1, lat2, lng2) {
        const R = 6371000; // Radius bumi dalam meter
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLng = (lng2 - lng1) * Math.PI / 180;
        const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                  Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                  Math.sin(dLng/2) * Math.sin(dLng/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        return R * c;
    }
    
    // Handle form submission
    document.getElementById('form-absensi').addEventListener('submit', function(e) {
        e.preventDefault();
        
        btnSubmitAbsen.disabled = true;
        btnSubmitAbsen.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mengirim...';
        
        // Submit via AJAX
        fetch(this.action, {
            method: 'POST',
            body: new FormData(this),
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showStatus('success', 'check-circle', data.message);
                btnSubmitAbsen.style.display = 'none';
                
                // Tampilkan info sukses
                const successInfo = document.createElement('div');
                successInfo.className = 'alert alert-success border-0 mt-3';
                successInfo.innerHTML = `
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-check-circle me-2"></i>
                        <strong>Absensi Berhasil!</strong>
                    </div>
                    <small>
                        Status: <span class="badge bg-success">${data.status.toUpperCase()}</span><br>
                        Waktu: ${data.waktu}<br>
                        Jarak: ${data.distance.toFixed(2)} meter
                    </small>
                `;
                statusGps.parentNode.appendChild(successInfo);
                
                // Redirect setelah 3 detik
                setTimeout(function() {
                    window.location.href = '<?= site_url('absensi/agenda/' . $agenda['id']) ?>';
                }, 3000);
            } else {
                showStatus('danger', 'x-circle', data.message);
                btnSubmitAbsen.disabled = false;
                btnSubmitAbsen.innerHTML = '<i class="bi bi-check-circle me-1"></i>Kirim Absensi';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showStatus('danger', 'x-circle', 'Terjadi kesalahan sistem. Silakan coba lagi.');
            btnSubmitAbsen.disabled = false;
            btnSubmitAbsen.innerHTML = '<i class="bi bi-check-circle me-1"></i>Kirim Absensi';
        });
    });
});
</script>

<style>
.card {
    border-radius: 10px;
}

.card-header {
    border-radius: 10px 10px 0 0 !important;
}

.alert {
    border-radius: 8px;
}

.btn {
    border-radius: 6px;
}

.font-monospace {
    font-family: 'Courier New', monospace;
    font-size: 0.85em;
}

.spinner-border-sm {
    width: 1rem;
    height: 1rem;
}

#info-lokasi {
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
<?= $this->endSection() ?>
