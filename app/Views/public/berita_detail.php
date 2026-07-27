<?= $this->extend('layout/public_template') ?>

<?= $this->section('content') ?>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="news-detail-container">

                    <!-- Tombol Kembali -->
                    <div class="mb-4">
                        <a href="<?= site_url('/berita') ?>" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Berita
                        </a>
                    </div>

                    <!-- Header Berita -->
                    <header class="mb-4">
                        <h1 class="display-5 fw-bold mb-3"><?= esc($berita['judul']) ?></h1>
                        <div class="news-meta-detail">
                            <span class="meta-item">
                                <i class="bi bi-person-fill"></i>
                                <?= esc($berita['nama_penulis']) ?>
                            </span>
                            <span class="meta-item">
                                <i class="bi bi-calendar-event"></i>
                                <?= date('d F Y', strtotime($berita['created_at'])) ?>
                            </span>
                        </div>
                    </header>

                    <!-- Gambar Utama -->
                    <figure class="mb-4 text-center">
                        <img class="img-fluid rounded shadow-sm" src="/uploads/berita/<?= esc($berita['gambar']) ?>" alt="<?= esc($berita['judul']) ?>" style="max-height: 500px; object-fit: cover;">
                    </figure>

                    <!-- Isi Berita -->
                    <section class="news-content-full mb-5">
                        <?= $berita['isi'] // Assuming content is safe HTML, otherwise use esc() and nl2br() ?>
                    </section>

                    <hr>

                    <!-- Social Share -->
                    <div class="social-share text-center py-3">
                        <h5 class="mb-3">Bagikan Artikel Ini</h5>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(current_url()) ?>" target="_blank" class="btn btn-social btn-facebook mx-1" title="Bagikan di Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url=<?= urlencode(current_url()) ?>&text=<?= urlencode($berita['judul']) ?>" target="_blank" class="btn btn-social btn-twitter mx-1" title="Bagikan di Twitter">
                            <i class="bi bi-twitter"></i>
                        </a>
                        <a href="https://api.whatsapp.com/send?text=<?= urlencode($berita['judul'] . ' ' . current_url()) ?>" target="_blank" class="btn btn-social btn-whatsapp mx-1" title="Bagikan di WhatsApp">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<meta property="og:title" content="<?= esc($berita['judul']) ?>">
<meta property="og:description" content="<?= esc(word_limiter(strip_tags($berita['isi']), 30)) ?>">
<meta property="og:image" content="<?= base_url('uploads/berita/' . $berita['gambar']) ?>">
<meta property="og:url" content="<?= current_url() ?>">
<meta property="og:type" content="article">
<style>
    .news-detail-container {
        background-color: #fff;
        padding: 2rem;
        border-radius: 0.5rem;
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.05);
    }
    .news-meta-detail {
        display: flex;
        gap: 1.5rem;
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
    }
    .meta-item i {
        margin-right: 0.5rem;
        color: var(--bs-primary);
    }
    .news-content-full {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #343a40;
    }
    .news-content-full p {
        margin-bottom: 1.5rem;
    }
    .btn-social {
        font-size: 1.2rem;
        width: 40px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: all 0.3s ease;
    }
    .btn-facebook { color: #fff; background-color: #1877F2; }
    .btn-twitter { color: #fff; background-color: #1DA1F2; }
    .btn-whatsapp { color: #fff; background-color: #25D366; }
    .btn-social:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
</style>
<?= $this->endSection() ?>