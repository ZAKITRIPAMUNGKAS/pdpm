<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Manajemen Profil Cabang</h3>
                </div>
                <div class="card-body">
                    <form id="profile-form" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $profile['id'] ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_cabang">Nama Cabang</label>
                                    <input type="text" class="form-control" id="nama_cabang" name="nama_cabang" value="<?= esc($profile['nama_cabang']) ?>">
                                </div>
                                <div class="form-group">
                                    <label for="nama_ketua">Nama Ketua</label>
                                    <input type="text" class="form-control" id="nama_ketua" name="nama_ketua" value="<?= esc($profile['nama_ketua']) ?>">
                                </div>
                                <div class="form-group">
                                    <label for="nama_sekretaris">Nama Sekretaris</label>
                                    <input type="text" class="form-control" id="nama_sekretaris" name="nama_sekretaris" value="<?= esc($profile['nama_sekretaris']) ?>">
                                </div>
                                <div class="form-group">
                                    <label for="nama_bendahara">Nama Bendahara</label>
                                    <input type="text" class="form-control" id="nama_bendahara" name="nama_bendahara" value="<?= esc($profile['nama_bendahara']) ?>">
                                </div>
                                <div class="form-group">
                                    <label for="cp_cabang">Kontak Person</label>
                                    <input type="text" class="form-control" id="cp_cabang" name="cp_cabang" value="<?= esc($profile['cp_cabang']) ?>">
                                </div>
                                <div class="form-group">
                                    <label for="email_cabang">Email Cabang</label>
                                    <input type="email" class="form-control" id="email_cabang" name="email_cabang" value="<?= esc($profile['email_cabang']) ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="alamat_sekretariat">Alamat Sekretariat</label>
                                    <textarea class="form-control" id="alamat_sekretariat" name="alamat_sekretariat" rows="3"><?= esc($profile['alamat_sekretariat']) ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi_cabang">Deskripsi Cabang</label>
                                    <textarea class="form-control" id="deskripsi_cabang" name="deskripsi_cabang" rows="3"><?= esc($profile['deskripsi_cabang']) ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="foto_sekretariat">Foto Bersama satu cabang</label>
                                    <input type="file" class="form-control-file" id="foto_sekretariat" name="foto_sekretariat">
                                    <?php if ($profile['foto_sekretariat']) : ?>
                                        <img src="<?= base_url('uploads/cabang/' . $profile['foto_sekretariat']) ?>" alt="Foto Sekretariat" class="img-thumbnail mt-2" width="200">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h5>Media Sosial</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="instagram">Instagram</label>
                                    <input type="text" class="form-control" id="instagram" name="instagram" value="<?= esc($profile['instagram']) ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="facebook">Facebook</label>
                                    <input type="text" class="form-control" id="facebook" name="facebook" value="<?= esc($profile['facebook']) ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="twitter">Twitter</label>
                                    <input type="text" class="form-control" id="twitter" name="twitter" value="<?= esc($profile['twitter']) ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="youtube">Youtube</label>
                                    <input type="text" class="form-control" id="youtube" name="youtube" value="<?= esc($profile['youtube']) ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="website">Website</label>
                                    <input type="text" class="form-control" id="website" name="website" value="<?= esc($profile['website']) ?>">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function () {
        $('#profile-form').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url: '<?= base_url('admin-cabang/profile/update') ?>',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.success) {
                        Swal.fire(
                            'Berhasil!',
                            response.message,
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire(
                            'Gagal!',
                            response.message,
                            'error'
                        );
                    }
                },
                error: function () {
                    Swal.fire(
                        'Error!',
                        'Terjadi kesalahan saat menghubungi server.',
                        'error'
                    );
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>
