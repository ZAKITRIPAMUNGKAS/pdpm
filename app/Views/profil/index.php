<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-md-4">
        <!-- Kartu Profil -->
        <div class="card card-success card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle" 
                         src="/uploads/profil/<?= esc($user['foto'] ?? 'default.png') ?>" 
                         alt="Foto profil <?= esc($user['nama_lengkap']) ?>"
                         style="width: 100px; height: 100px; object-fit: cover;">
                </div>
                <h3 class="profile-username text-center mt-3"><?= esc($user['nama_lengkap']) ?></h3>
                <p class="text-muted text-center"><?= esc($user['jabatan']) ?></p>
                
                <?php if($user['is_kokam']): ?>
                    <div class="text-center mb-2">
                        <span class="badge bg-danger">ANGGOTA KOKAM</span>
                    </div>
                <?php endif; ?>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Email</b> <a class="float-end"><?= esc($user['email']) ?></a>
                    </li>
                    <li class="list-group-item">
                        <b>NBM</b> <a class="float-end"><?= esc($user['nbm'] ?? '-') ?></a>
                    </li>
                    <li class="list-group-item">
                        <b>No. HP</b> <a class="float-end"><?= esc($user['no_hp'] ?? '-') ?></a>
                    </li>
                    <li class="list-group-item">
                        <b>Cabang</b> <a class="float-end"><?= esc($user['nama_cabang'] ?? '-') ?></a>
                    </li>
                    <li class="list-group-item">
                        <b>Ranting</b> <a class="float-end"><?= esc($user['nama_ranting'] ?? '-') ?></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <!-- Form Edit Profil -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Ubah Foto Profil</h3>
            </div>
            <div class="card-body">
                <form action="<?= site_url('profil-saya/update-foto') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Pilih Foto Baru</label>
                        <input type="file" class="form-control" id="foto" name="foto" accept="image/*" required>
                        <small class="form-text text-muted">Pilih file gambar (JPG, PNG, GIF) dengan ukuran maksimal 2MB.</small>
                    </div>
                    <button type="submit" class="btn btn-success">Update Foto</button>
                </form>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h3 class="card-title">Ubah Data Diri</h3>
            </div>
            <div class="card-body">
                <!-- ... Form tidak berubah dari sebelumnya ... -->
                <?php $errors = session()->get('errors'); ?>
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <strong>Perhatian!</strong> Terdapat beberapa kesalahan:
                        <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                        </ul>
                    </div>
                <?php endif ?>

                <form action="<?= site_url('profil-saya/update') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?= old('nama_lengkap', $user['nama_lengkap']) ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= old('email', $user['email']) ?>" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nbm" class="form-label">NBM (Nomor Baku Muhammadiyah)</label>
                                <input type="text" class="form-control" id="nbm" name="nbm" value="<?= old('nbm', $user['nbm'] ?? '') ?>" maxlength="50">
                                <small class="form-text text-muted">Masukkan Nomor Baku Muhammadiyah Anda</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="no_hp" class="form-label">Nomor HP</label>
                                <input type="tel" class="form-control" id="no_hp" name="no_hp" value="<?= old('no_hp', $user['no_hp'] ?? '') ?>" maxlength="15">
                                <small class="form-text text-muted">Contoh: 081234567890</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="alamat_rumah" class="form-label">Alamat Rumah</label>
                        <textarea class="form-control" id="alamat_rumah" name="alamat_rumah" rows="3"><?= old('alamat_rumah', $user['alamat_rumah'] ?? '') ?></textarea>
                        <small class="form-text text-muted">Masukkan alamat rumah lengkap Anda.</small>
                    </div>

                    <hr>
                    <p class="text-muted">Kosongkan bagian di bawah ini jika Anda tidak ingin mengubah password.</p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">Password Baru</label>
                                <input type="password" class="form-control" id="password" name="password" autocomplete="new-password">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pass_confirm" class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" id="pass_confirm" name="pass_confirm" autocomplete="new-password">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
