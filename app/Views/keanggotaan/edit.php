<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="card shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-primary fw-bold">
            <i class="bi bi-pencil-square me-2"></i>Edit Data Anggota: <?= esc($user['nama_lengkap']) ?>
        </h5>
        <a href="<?= site_url('manajemen-anggota') ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
    </div>
    <div class="card-body p-4">
        
        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('manajemen-anggota/update/' . $user['id']) ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="row g-3">
                <!-- Foto Profil Preview & Upload -->
                <div class="col-md-12 text-center mb-3">
                    <div class="position-relative d-inline-block">
                        <img src="<?= base_url('uploads/profil/' . esc($user['foto'] ?? 'default.png')) ?>" 
                             alt="Foto Profil" 
                             id="fotoPreview" 
                             class="rounded-circle img-thumbnail shadow-sm" 
                             style="width: 120px; height: 120px; object-fit: cover;">
                    </div>
                    <div class="mt-2 col-md-6 mx-auto">
                        <label for="foto" class="form-label text-muted small">Ganti Foto Profil (opsional):</label>
                        <input type="file" name="foto" id="foto" class="form-control form-control-sm" accept="image/*" onchange="previewImage(this)">
                        <div class="form-text">Format: JPG, PNG, WEBP. Maks 2MB.</div>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Nama Lengkap -->
                <div class="col-md-6">
                    <label for="nama_lengkap" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" value="<?= old('nama_lengkap', $user['nama_lengkap']) ?>" required>
                </div>

                <!-- Email -->
                <div class="col-md-6">
                    <label for="email" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" id="email" class="form-control" value="<?= old('email', $user['email']) ?>" required>
                </div>

                <!-- No HP -->
                <div class="col-md-6">
                    <label for="no_hp" class="form-label fw-semibold">No HP / WhatsApp</label>
                    <input type="text" name="no_hp" id="no_hp" class="form-control" value="<?= old('no_hp', $user['no_hp']) ?>" placeholder="Contoh: 08123456789">
                </div>

                <!-- NBM -->
                <div class="col-md-6">
                    <label for="nbm" class="form-label fw-semibold">NBM (Nomor Baku Muhammadiyah)</label>
                    <input type="text" name="nbm" id="nbm" class="form-control" value="<?= old('nbm', $user['nbm']) ?>" placeholder="Kosongkan jika tidak ada">
                </div>

                <!-- Tanggal Lahir -->
                <div class="col-md-6">
                    <label for="tanggal_lahir" class="form-label fw-semibold">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="<?= old('tanggal_lahir', $user['tanggal_lahir']) ?>">
                </div>

                <!-- Status Anggota -->
                <div class="col-md-6">
                    <label for="status" class="form-label fw-semibold">Status Anggota <span class="text-danger">*</span></label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="Aktif" <?= old('status', $user['status']) === 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                        <option value="Menunggu Verifikasi" <?= old('status', $user['status']) === 'Menunggu Verifikasi' ? 'selected' : '' ?>>Menunggu Verifikasi</option>
                        <option value="Ditolak" <?= old('status', $user['status']) === 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
                        <option value="Non-Aktif" <?= old('status', $user['status']) === 'Non-Aktif' ? 'selected' : '' ?>>Non-Aktif</option>
                    </select>
                </div>

                <!-- Anggota KOKAM -->
                <div class="col-md-6">
                    <label for="is_kokam" class="form-label fw-semibold">Anggota KOKAM</label>
                    <select name="is_kokam" id="is_kokam" class="form-select">
                        <option value="0" <?= old('is_kokam', $user['is_kokam']) == 0 ? 'selected' : '' ?>>Bukan KOKAM</option>
                        <option value="1" <?= old('is_kokam', $user['is_kokam']) == 1 ? 'selected' : '' ?>>Anggota KOKAM</option>
                    </select>
                </div>

                <!-- Tingkat Pimpinan -->
                <div class="col-md-6">
                    <label for="tipe_pimpinan" class="form-label fw-semibold">Tingkat Pimpinan</label>
                    <select name="tipe_pimpinan" id="tipe_pimpinan" class="form-select" onchange="togglePimpinanFields()">
                        <option value="">-- Pilih Tingkat --</option>
                        <option value="daerah" <?= old('tipe_pimpinan', $user['tipe_pimpinan']) === 'daerah' ? 'selected' : '' ?>>PD Karanganyar (Daerah)</option>
                        <option value="cabang" <?= old('tipe_pimpinan', $user['tipe_pimpinan']) === 'cabang' ? 'selected' : '' ?>>PC (Cabang)</option>
                        <option value="ranting" <?= old('tipe_pimpinan', $user['tipe_pimpinan']) === 'ranting' ? 'selected' : '' ?>>PR (Ranting)</option>
                    </select>
                </div>

                <!-- Pilihan Cabang -->
                <div class="col-md-6" id="container_cabang">
                    <label for="id_cabang" class="form-label fw-semibold">Pimpinan Cabang</label>
                    <select name="id_cabang" id="id_cabang" class="form-select" onchange="loadRanting(this.value)">
                        <option value="">-- Pilih Cabang --</option>
                        <?php foreach ($cabang_list as $cabang): ?>
                            <option value="<?= $cabang['id'] ?>" <?= old('id_cabang', $user['id_cabang']) == $cabang['id'] ? 'selected' : '' ?>>
                                <?= esc($cabang['nama_cabang']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Pilihan Ranting -->
                <div class="col-md-6" id="container_ranting">
                    <label for="id_ranting" class="form-label fw-semibold">Pimpinan Ranting</label>
                    <select name="id_ranting" id="id_ranting" class="form-select">
                        <option value="">-- Pilih Ranting --</option>
                        <?php foreach ($ranting_list as $ranting): ?>
                            <option value="<?= $ranting['id'] ?>" <?= old('id_ranting', $user['id_ranting']) == $ranting['id'] ? 'selected' : '' ?>>
                                <?= esc($ranting['nama_ranting']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Jabatan Organisasi -->
                <div class="col-md-6">
                    <label for="jabatan" class="form-label fw-semibold">Jabatan Organisasi</label>
                    <input type="text" name="jabatan" id="jabatan" class="form-control" value="<?= old('jabatan', $user['jabatan']) ?>" placeholder="Contoh: Ketua, Anggota Bidang Hikmah, dll">
                </div>

                <!-- Reset Password (Opsional) -->
                <div class="col-md-6">
                    <label for="password" class="form-label fw-semibold">Reset Password (Opsional)</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Kosongkan jika tidak ingin diubah">
                    <div class="form-text">Isi hanya jika ingin mengganti password anggota ini.</div>
                </div>

                <!-- Alamat Rumah -->
                <div class="col-md-12">
                    <label for="alamat_rumah" class="form-label fw-semibold">Alamat Rumah Lengkap</label>
                    <textarea name="alamat_rumah" id="alamat_rumah" class="form-control" rows="3" placeholder="Alamat rumah lengkap..."><?= old('alamat_rumah', $user['alamat_rumah']) ?></textarea>
                </div>

            </div>

            <div class="mt-4 pt-3 border-top text-end">
                <a href="<?= site_url('manajemen-anggota') ?>" class="btn btn-secondary me-2">
                    <i class="bi bi-x-circle me-1"></i>Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-1"></i>Simpan Perubahan
                </button>
            </div>

        </form>

    </div>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('fotoPreview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function togglePimpinanFields() {
        var tipe = document.getElementById('tipe_pimpinan').value;
        var containerCabang = document.getElementById('container_cabang');
        var containerRanting = document.getElementById('container_ranting');

        if (tipe === 'daerah') {
            containerCabang.style.display = 'none';
            containerRanting.style.display = 'none';
        } else if (tipe === 'cabang') {
            containerCabang.style.display = 'block';
            containerRanting.style.display = 'none';
        } else {
            containerCabang.style.display = 'block';
            containerRanting.style.display = 'block';
        }
    }

    function loadRanting(cabangId) {
        var rantingSelect = document.getElementById('id_ranting');
        rantingSelect.innerHTML = '<option value="">-- Memuat Ranting... --</option>';

        if (!cabangId) {
            rantingSelect.innerHTML = '<option value="">-- Pilih Ranting --</option>';
            return;
        }

        fetch('<?= site_url('api/ranting/') ?>' + cabangId)
            .then(response => response.json())
            .then(data => {
                var html = '<option value="">-- Pilih Ranting --</option>';
                data.forEach(function(item) {
                    html += '<option value="' + item.id + '">' + item.nama_ranting + '</option>';
                });
                rantingSelect.innerHTML = html;
            })
            .catch(err => {
                console.error('Error fetching ranting:', err);
                rantingSelect.innerHTML = '<option value="">-- Gagal Memuat --</option>';
            });
    }

    document.addEventListener('DOMContentLoaded', function() {
        togglePimpinanFields();
    });
</script>

<?= $this->endSection() ?>
