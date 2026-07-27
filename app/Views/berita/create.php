<?= $this->extend('layout/template') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/admin-berita.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="berita-page-header">
    <div class="berita-page-header-left">
        <a href="<?= site_url('admin-berita') ?>" class="btn-berita-back" title="Kembali ke Daftar Berita">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div class="berita-page-icon">
            <i class="bi bi-pencil-square"></i>
        </div>
        <div>
            <h1 class="berita-page-title">Form Tulis Berita Baru</h1>
            <p class="berita-page-sub">Buat dan terbitkan berita atau pengumuman terbaru</p>
        </div>
    </div>
</div>

<div class="berita-card p-4">
    <?php $errors = session()->get('errors'); ?>
    <?php if (!empty($errors)): ?>
        <div class="berita-alert berita-alert-danger mb-4">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <div>
                <strong>Terdapat beberapa kesalahan:</strong>
                <ul class="mb-0 mt-1 ps-3">
                <?php foreach ($errors as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
                </ul>
            </div>
        </div>
    <?php endif ?>

    <form action="<?= site_url('admin-berita/store') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        
        <div class="row g-4">
            <!-- Col Main Form -->
            <div class="col-lg-8">
                <div class="mb-3">
                    <label for="judul" class="form-label fw-bold text-dark">Judul Berita <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-lg" id="judul" name="judul" value="<?= old('judul') ?>" placeholder="Masukkan judul berita yang menarik..." required>
                </div>
                
                <div class="mb-3">
                    <label for="isi" class="form-label fw-bold text-dark">Isi Konten Berita <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="isi" name="isi" rows="14" required><?= old('isi') ?></textarea>
                </div>
            </div>

            <!-- Col Sidebar Option -->
            <div class="col-lg-4">
                <div class="berita-sidebar-box p-3 border rounded-3 bg-light">
                    <h6 class="fw-bold text-dark mb-3"><i class="bi bi-image me-2 text-danger"></i>Gambar Utama</h6>
                    
                    <div class="mb-3">
                        <div class="berita-preview-container mb-2 text-center border rounded bg-white p-3">
                            <img id="imgPreview" src="" alt="Preview Gambar" class="img-fluid rounded d-none" style="max-height: 180px; object-fit: cover;">
                            <div id="imgPlaceholder" class="py-4 text-muted">
                                <i class="bi bi-cloud-arrow-up display-5"></i>
                                <p class="small mb-0 mt-2">Pilih gambar dari perangkat Anda</p>
                            </div>
                        </div>
                        <input class="form-control" type="file" id="gambar" name="gambar" accept="image/*" required>
                        <small class="form-text text-muted d-block mt-1">Ukuran maksimal 2MB. Format: JPG, JPEG, PNG.</small>
                    </div>

                    <hr class="my-4">

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn-berita-primary justify-content-center py-2">
                            <i class="bi bi-send-fill me-1"></i> Terbitkan Berita
                        </button>
                        <a href="<?= site_url('admin-berita') ?>" class="btn btn-outline-secondary rounded-pill fw-semibold py-2">
                            <i class="bi bi-x-circle me-1"></i> Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.tiny.cloud/1/a57s7o7gpionktat3e3d74z5ncynq4cci8yn8a08rackomvi/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
<script>
  tinymce.init({
    selector: 'textarea#isi',
    height: 480,
    plugins: [
      'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
      'checklist', 'mediaembed', 'casechange', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'advtemplate', 'ai', 'uploadcare', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown','importword', 'exportword', 'exportpdf'
    ],
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link media table mergetags | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    branding: false,
    promotion: false
  });

  // Image Preview Handler
  document.getElementById('gambar').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('imgPreview');
    const placeholder = document.getElementById('imgPlaceholder');
    
    if (file) {
      const reader = new FileReader();
      reader.onload = function(evt) {
        preview.src = evt.target.result;
        preview.classList.remove('d-none');
        placeholder.classList.add('d-none');
      }
      reader.readAsDataURL(file);
    } else {
      preview.src = '';
      preview.classList.add('d-none');
      placeholder.classList.remove('d-none');
    }
  });

  const form = document.querySelector('form');
  if (form) {
    form.addEventListener('submit', function() {
      tinymce.triggerSave();
    });
  }
</script>
<?= $this->endSection() ?>
