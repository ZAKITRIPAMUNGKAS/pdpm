<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Tulis Berita Baru</h3>
    </div>
    <div class="card-body">
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

        <form action="<?= site_url('admin-berita/store') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="judul" class="form-label">Judul Berita</label>
                <input type="text" class="form-control" id="judul" name="judul" value="<?= old('judul') ?>" required>
            </div>
            <div class="mb-3">
                <label for="isi" class="form-label">Isi Berita</label>
                <textarea class="form-control" id="isi" name="isi" rows="10" required><?= old('isi') ?></textarea>
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar Utama</label>
                <input class="form-control" type="file" id="gambar" name="gambar" required>
                <small class="form-text text-muted">Ukuran maksimal 2MB. Format: JPG, JPEG, PNG.</small>
            </div>
            <button type="submit" class="btn btn-primary">Terbitkan</button>
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

  // Ensure TinyMCE updates the original textarea before form submission
  const form = document.querySelector('form'); // Assuming there's only one form on the page
  if (form) {
    form.addEventListener('submit', function() {
      tinymce.triggerSave();
    });
  }
</script>
<?= $this->endSection() ?>
