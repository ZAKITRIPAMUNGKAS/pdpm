<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'PDPM Karanganyar') ?></title>
    
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('logo.png') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('logo.png') ?>">
    <link rel="apple-touch-icon" href="<?= base_url('logo.png') ?>">
    <meta name="msapplication-TileImage" content="<?= base_url('logo.png') ?>">
    <meta name="msapplication-TileColor" content="#dc3545">
    <meta name="theme-color" content="#dc3545">
    
    <meta name="description" content="Pimpinan Daerah Pemuda Muhammadiyah Karanganyar - Organisasi Otonom Muhammadiyah untuk Pembinaan Generasi Muda Islam">
    <meta name="keywords" content="PDPM, Pemuda Muhammadiyah, Karanganyar, Organisasi Islam, Kaderisasi, Dakwah">
    <meta name="author" content="PDPM Karanganyar">
    
    <meta property="og:title" content="<?= esc($title ?? 'PDPM Karanganyar') ?>">
    <meta property="og:description" content="<?= esc($deskripsi ?? 'Pimpinan Daerah Pemuda Muhammadiyah Karanganyar - Organisasi Otonom Muhammadiyah untuk Pembinaan Generasi Muda Islam') ?>">
    <meta property="og:image" content="<?= esc($thumbnail ?? base_url('logo.png')) ?>">
    <meta property="og:url" content="<?= current_url() ?>">
    <meta property="og:type" content="website">
    
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= esc($title ?? 'PDPM Karanganyar') ?>">
    <meta name="twitter:description" content="<?= esc($deskripsi ?? 'Pimpinan Daerah Pemuda Muhammadiyah Karanganyar - Organisasi Otonom Muhammadiyah untuk Pembinaan Generasi Muda Islam') ?>">
    <meta name="twitter:image" content="<?= esc($thumbnail ?? base_url('logo.png')) ?>">
    
    <link rel="stylesheet" href="<?= base_url('css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/custom.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/ui-enhancements.css') ?>">
    <!-- Bootstrap Icons - Local dengan fallback ke CDN -->
    <link rel="stylesheet" href="<?= base_url('bootstrap-icons/bootstrap-icons-complete.min.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url('css/hide-debug.css') ?>">

    <?= $this->renderSection('styles') ?>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="/">
                <img src="<?= base_url('logo.png') ?>" alt="PDPM Karanganyar" class="navbar-logo me-2">
                <span>PDPM KARANGANYAR</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="/">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="/profil">Profil</a></li>
                    <li class="nav-item"><a class="nav-link" href="/cabang">Cabang</a></li>
                    <li class="nav-item"><a class="nav-link" href="/berita">Berita</a></li>
                    <li class="nav-item"><a class="nav-link" href="/agenda">Agenda</a></li>
                    <li class="nav-item"><a class="nav-link" href="/galeri">Galeri</a></li>
                    <li class="nav-item"><a class="nav-link" href="/kontak">Kontak</a></li>
                </ul>
                <a href="/login" class="btn btn-outline-light ms-lg-2">Login Anggota</a>
            </div>
        </div>
    </nav>

    <main>
        <?= $this->renderSection('content') ?>
    </main>

    <footer class="footer mt-auto py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                        <img src="<?= base_url('logo.png') ?>" alt="PDPM Karanganyar" class="footer-logo me-3">
                        <div>
                            <h6 class="mb-1 text-white">PDPM Karanganyar</h6>
                            <small class="text-light opacity-75">Pemuda Muhammadiyah</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="mb-0 text-light">&copy; <?= date('Y') ?> Pimpinan Daerah Pemuda Muhammadiyah Karanganyar.</p>
                    <small class="text-light opacity-75">Seluruh hak cipta dilindungi.</small>
                </div>
            </div>
        </div>
    </footer>

    <script src="<?= base_url('js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('js/custom.js') ?>"></script>
    <script src="<?= base_url('js/ui-enhancements.js') ?>"></script>

    <?= $this->renderSection('scripts') ?>

    <?php if (current_url(true)->getPath() !== '/kontak'): ?>
    <div class="chatbot-container">
        <div class="chatbot-button" id="chatbot-button">
            <img src="<?= base_url('4.png') ?>" alt="Chatbot Icon" style="width: 60%; height: 60%; object-fit: contain;">
        </div>
        <div class="chatbot-window" id="chatbot-window">
            <div class="chatbot-header">
                <span class="chatbot-title">Asisten Virtual PDPM</span>
                <button class="chatbot-close" id="chatbot-close">&times;</button>
            </div>
            <div class="chatbot-messages" id="chatbot-messages"></div>
            <div id="chatbot-questions" class="chatbot-questions"></div>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatbotButton = document.getElementById('chatbot-button');
    const chatbotWindow = document.getElementById('chatbot-window');
    const chatbotClose = document.getElementById('chatbot-close');
    const chatbotMessages = document.getElementById('chatbot-messages');
    const chatbotQuestions = document.getElementById('chatbot-questions');

    let isFirstOpen = true;

    // Data QnA - Diperbarui sesuai konten halaman profil
    const qaData = [
        { question: "Apa itu PDPM Karanganyar?", answer: "PDPM Karanganyar adalah organisasi otonom Muhammadiyah yang bergerak dalam pembinaan dan pengembangan generasi muda Islam di Kabupaten Karanganyar untuk mewujudkan cita-cita Muhammadiyah." },
        { question: "Apa Visi PDPM Karanganyar?", answer: 'Visi kami adalah "Pemuda berkeadaban, Meneguhkan karanganyar berkemajuan".' },
        { question: "Apa saja Misi PDPM Karanganyar?", answer: "Misi kami meliputi: 1. Meningkatkan kualitas kader (spiritual, intelektual, moral), 2. Mengembangkan potensi ekonomi kader, 3. Berperan aktif dalam dakwah, 4. Membangun jaringan dan kerjasama strategis." },
        { question: "Siapa Ketua PDPM Karanganyar saat ini?", answer: "Ketua PDPM Karanganyar untuk periode 2023-2027 adalah Mahlich Ibrahim." },
        { question: "Siapa saja Pimpinan Harian PDPM Karanganyar?", answer: "Pimpinan Harian periode 2023-2027 adalah: Ketua (Mahlich Ibrahim), Sekretaris (Isna Hidayat), Bendahara (Gesang Triwigati), dan Wakil Bendahara (Jarwanto)." },
        { question: "Apa saja bidang yang ada di PDPM?", answer: "Struktur kami memiliki banyak bidang, antara lain: Organisasi, Dakwah, Pendidikan & Kaderisasi, KOKAM & SAR, KOMINFO, Ekonomi, Hikmah, Seni Budaya, Hukum & HAM, serta Lingkungan Hidup." },
        { question: "Apa saja program kerja di bidang Kaderisasi?", answer: "Program di bidang Pendidikan & Kaderisasi antara lain Baitul Arqom Dasar (Agustus 2025), Sekolah Kader (September 2025), dan Pendataan SDM Kader." },
        { question: "Kapan jadwal Diksar Kokam?", answer: "Berdasarkan jadwal program kerja, Pendidikan Dasar (Diksar) Kokam akan dilaksanakan pada bulan Desember 2026." },
        { question: "Apa contoh program di bidang Seni Budaya?", answer: "Contoh programnya adalah Pembentukan Tim Outbond, Seminar, Pemuda Muhammadiyah CUP (April 2026 & 2027), dan Sekolah Pambiworo." },
        { question: "Bagaimana cara bergabung dengan PDPM?", answer: "Untuk bergabung, Anda bisa menghubungi pengurus Pimpinan Cabang (tingkat kecamatan) atau Pimpinan Ranting (tingkat desa) Pemuda Muhammadiyah di wilayah Anda." },
        { question: "Apakah ada program di bidang teknologi?", answer: "Ya, bidang Komunikasi, Informasi, Riset & Teknologi (KOMINFO RISTEK) memiliki program Pembuatan Website (Juni 2025) dan Launching Produk 3D (Oktober 2025)." }
    ];

    function addMessage(text, sender) {
        const messageDiv = document.createElement('div');
        messageDiv.classList.add('chatbot-message', sender);
        messageDiv.textContent = text;
        chatbotMessages.appendChild(messageDiv);
        chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
    }

    function botTyping(callback) {
        const typingDiv = document.createElement('div');
        typingDiv.classList.add('chatbot-message', 'bot', 'typing');
        // Membuat 3 titik untuk animasi
        typingDiv.innerHTML = '<span></span><span></span><span></span>'; 
        chatbotMessages.appendChild(typingDiv);
        chatbotMessages.scrollTop = chatbotMessages.scrollHeight;

        // Simulasi waktu mengetik
        setTimeout(() => {
            typingDiv.remove();
            callback();
        }, 1000);
    }

    function showQuestions() {
        chatbotQuestions.innerHTML = '';
        qaData.forEach(item => {
            const button = document.createElement('button');
            button.textContent = item.question;
            button.classList.add('chatbot-question-button');
            button.addEventListener('click', () => handleQuestionClick(item.question, item.answer));
            chatbotQuestions.appendChild(button);
        });
    }

    function handleQuestionClick(question, answer) {
        addMessage(question, 'user');
        botTyping(() => {
            addMessage(answer, 'bot');
        });
    }

    // Event Listeners
    chatbotButton.addEventListener('click', function() {
        chatbotWindow.classList.toggle('open');
        if (chatbotWindow.classList.contains('open') && isFirstOpen) {
            isFirstOpen = false;
            botTyping(() => {
                addMessage("Assalamualaikum! Saya Asisten Virtual PDPM Karanganyar. Apa yang ingin Anda ketahui?", 'bot');
                showQuestions();
            });
        }
    });

    chatbotClose.addEventListener('click', function() {
        chatbotWindow.classList.remove('open');
    });
});
</script>

<style>
/* Font Kustom untuk Tampilan Futuristik */
@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap');

:root {
    --chatbot-bg: rgba(25, 28, 36, 0.85); /* Latar belakang gelap transparan */
    --chatbot-header-bg: rgba(35, 40, 51, 0.9);
    --bot-message-bg: linear-gradient(135deg, #2a2d38, #3a3f4f);
    --user-message-bg: linear-gradient(135deg, #e43a4b, #b72136);
    --accent-color: #e43a4b;
    --text-color: #f0f0f0;
    --border-color: rgba(255, 255, 255, 0.1);
    --font-family: 'Roboto', sans-serif;
}

.chatbot-container {
    position: fixed;
    bottom: 25px;
    right: 25px;
    z-index: 1000;
    font-family: var(--font-family);
}

.chatbot-button {
    width: 65px;
    height: 65px;
    background: var(--accent-color);
    border-radius: 50%;
    cursor: pointer;
    box-shadow: 0 5px 20px rgba(220, 53, 69, 0.4);
    display: flex;
    justify-content: center;
    align-items: center;
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease;
    animation: pulse 2s infinite;
}

.chatbot-button:hover {
    transform: scale(1.1);
    box-shadow: 0 8px 25px rgba(220, 53, 69, 0.6);
}

@keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7); }
    70% { box-shadow: 0 0 0 15px rgba(220, 53, 69, 0); }
    100% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
}

.chatbot-window {
    display: flex;
    flex-direction: column;
    position: absolute;
    bottom: 90px;
    right: 0;
    width: 350px;
    max-height: 550px;
    background: var(--chatbot-bg);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    overflow: hidden;
    border: 1px solid var(--border-color);
    transform: scale(0.5) translateY(50px);
    opacity: 0;
    pointer-events: none;
    transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), opacity 0.3s ease;
}

/* Mobile responsive chatbot */
@media (max-width: 768px) {
    .chatbot-window {
        width: calc(100vw - 40px);
        max-width: 350px;
        right: 20px;
        left: 20px;
        bottom: 100px;
        max-height: 60vh;
    }
    
    .chatbot-container {
        bottom: 20px;
        right: 20px;
    }
    
    .chatbot-button {
        width: 60px;
        height: 60px;
    }
}

.chatbot-window.open {
    transform: scale(1) translateY(0);
    opacity: 1;
    pointer-events: auto;
}

.chatbot-header {
    background: var(--chatbot-header-bg);
    color: var(--text-color);
    padding: 15px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid var(--border-color);
    font-weight: 500;
}

.chatbot-close {
    background: none;
    border: none;
    color: var(--text-color);
    font-size: 24px;
    cursor: pointer;
    opacity: 0.7;
    transition: opacity 0.2s;
}

.chatbot-close:hover { opacity: 1; }

.chatbot-messages {
    flex: 1;
    padding: 20px;
    overflow-y: auto;
    font-size: 15px;
    display: flex;
    flex-direction: column;
    gap: 12px;
}
/* Scrollbar styling */
.chatbot-messages::-webkit-scrollbar { width: 6px; }
.chatbot-messages::-webkit-scrollbar-track { background: transparent; }
.chatbot-messages::-webkit-scrollbar-thumb { background: #555; border-radius: 3px; }
.chatbot-messages::-webkit-scrollbar-thumb:hover { background: #777; }

.chatbot-message {
    padding: 10px 15px;
    border-radius: 18px;
    max-width: 85%;
    line-height: 1.5;
    animation: slideIn 0.4s ease-out;
}

@keyframes slideIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.chatbot-message.bot {
    background: var(--bot-message-bg);
    color: var(--text-color);
    align-self: flex-start;
    border-bottom-left-radius: 4px;
}

.chatbot-message.user {
    background: var(--user-message-bg);
    color: #fff;
    align-self: flex-end;
    border-bottom-right-radius: 4px;
}

.chatbot-message.typing {
    display: flex;
    align-items: center;
    padding: 12px 15px;
    background: var(--bot-message-bg);
}
.chatbot-message.typing span {
    height: 8px;
    width: 8px;
    margin: 0 2px;
    background-color: #999;
    display: block;
    border-radius: 50%;
    opacity: 0.4;
    animation: typing 1s infinite;
}
.chatbot-message.typing span:nth-child(2) { animation-delay: 0.2s; }
.chatbot-message.typing span:nth-child(3) { animation-delay: 0.4s; }

@keyframes typing {
    0% { transform: translateY(0px); }
    25% { transform: translateY(-4px); }
    50%, 100% { transform: translateY(0px); }
}

.chatbot-questions {
    padding: 15px;
    max-height: 180px;
    overflow-y: auto;
    border-top: 1px solid var(--border-color);
    background: var(--chatbot-header-bg);
    display: flex;
    flex-direction: column;
    gap: 8px;
}
/* Scrollbar styling for questions */
.chatbot-questions::-webkit-scrollbar { width: 6px; }
.chatbot-questions::-webkit-scrollbar-track { background: transparent; }
.chatbot-questions::-webkit-scrollbar-thumb { background: #555; border-radius: 3px; }
.chatbot-questions::-webkit-scrollbar-thumb:hover { background: #777; }

.chatbot-question-button {
    background-color: rgba(255, 255, 255, 0.05);
    border: 1px solid var(--border-color);
    color: var(--text-color);
    padding: 12px;
    border-radius: 10px;
    cursor: pointer;
    text-align: left;
    transition: background-color 0.2s, border-color 0.2s;
    font-size: 14px;
    width: 100%;
}

.chatbot-question-button:hover {
    background-color: rgba(255, 255, 255, 0.1);
    border-color: rgba(255, 255, 255, 0.3);
}
</style>
<?php endif; ?>
</body>
</html>