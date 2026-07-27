<?= $this->extend('layout/template') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/admin-berita.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Edit Berita</h3>
    </div>
    <div class="card-body">
        <?php $errors = session()->get('errors'); ?>
        <?php if (!empty($errors)):
 ?>
            <div class="alert alert-danger">
                <strong>Perhatian!</strong> Terdapat beberapa kesalahan:
                <ul class="mb-0">
                <?php foreach ($errors as $error):
 ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach
 ?>
                </ul>
            </div>
        <?php endif
 ?>

        <form action="<?= site_url('admin-berita/update/' . $berita['id']) ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">
            <div class="mb-3">
                <label for="judul" class="form-label">Judul Berita</label>
                <input type="text" class="form-control" id="judul" name="judul" value="<?= old('judul', $berita['judul']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="isi" class="form-label">Isi Berita</label>
                <textarea class="form-control" id="isi" name="isi" rows="10" required><?= old('isi', $berita['isi']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">Ganti Gambar Utama</label>
                <div class="mt-3 mb-3">
                    <p class="fw-semibold">Gambar Saat Ini:</p>
                    <?php if (!empty($berita['gambar']) && file_exists(FCPATH . 'uploads/berita/' . $berita['gambar'])): ?>
                        <img src="/uploads/berita/<?= esc($berita['gambar']) ?>" 
                             alt="Gambar Lama" 
                             class="csp-img-150x150">
                    <?php else: ?>
                        <div class="csp-img-150x150 d-flex align-items-center justify-content-center bg-light">
                            <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                        </div>
                    <?php endif; ?>
                </div>
                <input class="form-control" type="file" id="gambar" name="gambar" accept="image/*">
                <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti gambar. Ukuran maksimal 2MB.</small>
            </div>
            <button type="submit" class="btn btn-primary">Perbarui</button>
            <a href="<?= site_url('admin-berita') ?>" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.tiny.cloud/1/a57s7o7gpionktat3e3d74z5ncynq4cci8yn8a08rackomvi/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
<script>
  tinymce.init({
    selector: 'textarea#isi',
    plugins: [
      'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
      'checklist', 'mediaembed', 'casechange', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'advtemplate', 'ai', 'uploadcare', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown','importword', 'exportword', 'exportpdf'
    ],
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography uploadcare | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    mergetags_list: [
      { value: 'First.Name', title: 'First Name' },
      { value: 'Email', title: 'Email' },
    ],
    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
    uploadcare_public_key: '8c0a9bf54934714a8a4c',
  });
</script>
<?= $this->endSection() ?>
