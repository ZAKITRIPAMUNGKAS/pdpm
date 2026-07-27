document.addEventListener('DOMContentLoaded', function() {

    // --- CSP-Compliant Dynamic Styling ---
    
    // Handle progress bars with data-width attribute
    const progressBars = document.querySelectorAll('[data-csp-dynamic-width]');
    progressBars.forEach(bar => {
        const widthValue = bar.getAttribute('data-csp-dynamic-width');
        if (widthValue) {
            bar.style.width = widthValue + '%';
        }
    });

    // Handle progress bars with data-width attribute
    const dynamicProgressBars = document.querySelectorAll('.progress-bar-dynamic[data-width], .progress-bar[data-width]');
    dynamicProgressBars.forEach(bar => {
        const width = bar.getAttribute('data-width');
        if (width) {
            bar.style.width = width + '%';
        }
    });

    // Handle any elements with data-style attribute for CSP compliance
    const elementsWithDataStyle = document.querySelectorAll('[data-csp-style]');
    elementsWithDataStyle.forEach(element => {
        const styleValue = element.getAttribute('data-csp-style');
        if (styleValue) {
            element.setAttribute('style', styleValue);
        }
    });

    // Handle dynamic icon sizes
    const iconElements = document.querySelectorAll('[data-icon-size]');
    iconElements.forEach(icon => {
        const size = icon.getAttribute('data-icon-size');
        if (size) {
            icon.style.fontSize = size;
        }
    });

    // Handle dynamic image dimensions
    const imageElements = document.querySelectorAll('[data-img-dimensions]');
    imageElements.forEach(img => {
        const dimensions = img.getAttribute('data-img-dimensions');
        if (dimensions) {
            const [width, height] = dimensions.split('x');
            if (width) img.style.width = width + 'px';
            if (height) img.style.height = height + 'px';
        }
    });

    // Handle dynamic colors for stat cards
    const statCards = document.querySelectorAll('.stat-card[data-color]');
    statCards.forEach(card => {
        const color = card.getAttribute('data-color');
        if (color) {
            card.style.setProperty('--card-color', color);
        }
    });

    // --- Logic from event handlers (onclick, etc.) ---
    const confirmActions = document.querySelectorAll('.confirm-action');
    confirmActions.forEach(button => {
        button.addEventListener('click', function(event) {
            const message = this.getAttribute('data-confirm-message');
            if (!confirm(message)) {
                event.preventDefault();
            }
        });
    });

    // --- Logic from inline scripts ---
    const togglePassword = document.querySelector('#togglePassword');
    if (togglePassword) {
        togglePassword.addEventListener('click', function (e) {
            const password = document.getElementById('password');
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });
    }

    // Handle confirm password toggle
    const toggleConfirmPassword = document.querySelector('#toggleConfirmPassword');
    if (toggleConfirmPassword) {
        toggleConfirmPassword.addEventListener('click', function (e) {
            const confirmPassword = document.getElementById('pass_confirm');
            const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPassword.setAttribute('type', type);
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });
    }

    // --- Contact Form Functionality ---
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        const submitBtn = contactForm.querySelector('.submit-btn');
        const btnText = submitBtn.querySelector('.btn-text');
        const btnLoading = submitBtn.querySelector('.btn-loading');
        
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show loading state
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline-flex';
            submitBtn.disabled = true;
            
            // Simulate form submission (replace with actual form handling)
            setTimeout(() => {
                // Reset form
                contactForm.reset();
                
                // Show success message
                showNotification('Pesan berhasil dikirim! Kami akan segera menghubungi Anda.', 'success');
                
                // Reset button state
                btnText.style.display = 'inline-flex';
                btnLoading.style.display = 'none';
                submitBtn.disabled = false;
            }, 2000);
        });
        
        // Form validation
        const inputs = contactForm.querySelectorAll('input[required], select[required], textarea[required]');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateField(this);
            });
            
            input.addEventListener('input', function() {
                if (this.classList.contains('is-invalid')) {
                    validateField(this);
                }
            });
        });
    }

    // --- Intersection Observer for animations ---
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observe contact cards for animation
    const contactCards = document.querySelectorAll('.contact-card');
    contactCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = `all 0.6s ease ${index * 0.1}s`;
        observer.observe(card);
    });
    
    // Observe form card
    const formCard = document.querySelector('.contact-form-card');
    if (formCard) {
        formCard.style.opacity = '0';
        formCard.style.transform = 'translateY(30px)';
        formCard.style.transition = 'all 0.6s ease 0.3s';
        observer.observe(formCard);
    }

    // --- Register Form Functionality ---
    const tipeRantingRadio = document.getElementById('tipe_ranting');
    const tipeCabangRadio = document.getElementById('tipe_cabang');
    const tipeDaerahRadio = document.getElementById('tipe_daerah');
    const cabangSelect = document.getElementById('id_cabang');
    const rantingWrapper = document.getElementById('ranting-wrapper');
    const rantingSelect = document.getElementById('id_ranting');

    if (tipeRantingRadio && tipeCabangRadio && tipeDaerahRadio) {
        function toggleRantingField() {
            const cabangWrapper = document.getElementById('cabang-wrapper');

            if (tipeRantingRadio.checked) {
                cabangWrapper.style.display = 'block';
                rantingWrapper.style.display = 'block';
                cabangSelect.required = true;
                rantingSelect.required = true;
            } else if (tipeCabangRadio.checked) {
                cabangWrapper.style.display = 'block';
                rantingWrapper.style.display = 'none';
                rantingSelect.required = false;
                rantingSelect.value = '';
                cabangSelect.required = true;
            } else if (tipeDaerahRadio.checked) {
                cabangWrapper.style.display = 'none';
                rantingWrapper.style.display = 'none';
                rantingSelect.required = false;
                rantingSelect.value = '';
                cabangSelect.required = false;
                cabangSelect.value = '';
            } else {
                cabangWrapper.style.display = 'none';
                rantingWrapper.style.display = 'none';
                rantingSelect.required = false;
                rantingSelect.value = '';
                cabangSelect.required = false;
                cabangSelect.value = '';
            }
        }

        function fetchRanting() {
            const cabangId = cabangSelect.value;
            rantingSelect.innerHTML = '<option value="">Memuat...</option>';
            rantingSelect.disabled = true;

            if (cabangId) {
                fetch(`/auth/ranting/${cabangId}`)
                    .then(response => response.json())
                    .then(data => {
                        rantingSelect.innerHTML = '<option value="">-- Pilih Ranting --</option>';
                        data.forEach(ranting => {
                            rantingSelect.innerHTML += `<option value="${ranting.id}">${ranting.nama_ranting}</option>`;
                        });
                        rantingSelect.disabled = false;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        rantingSelect.innerHTML = '<option value="">Error memuat data</option>';
                    });
            } else {
                rantingSelect.innerHTML = '<option value="">-- Pilih Cabang Dulu --</option>';
            }
        }

        // Jabatan Organisasi Logic
        const jabatanUmumRadio = document.getElementById('jabatan_umum');
        const jabatanHarianRadio = document.getElementById('jabatan_harian');
        const jabatanAnggotaRadio = document.getElementById('jabatan_anggota');

        const jabatanStrukturalWrapper = document.getElementById('jabatan-struktural-wrapper');
        const jabatanStrukturalSelect = document.getElementById('jabatan_struktural');
        const jabatanBidangWrapper = document.getElementById('jabatan-bidang-wrapper');
        const jabatanBidangSelect = document.getElementById('jabatan_bidang');

        const bidangOptions = [
            { value: '', text: '-- Pilih Bidang --' },
            { value: 'Organisasi & Keanggotaan', text: 'Organisasi & Keanggotaan' },
            { value: 'Dakwah & Pengkajian Agama', text: 'Dakwah & Pengkajian Agama' },
            { value: 'Pendidikan & Kaderisasi', text: 'Pendidikan & Kaderisasi' },
            { value: 'KOKAM & SAR', text: 'KOKAM & SAR' },
            { value: 'Komunikasi, Informasi, Riset & Teknologi', text: 'Komunikasi, Informasi, Riset & Teknologi' },
            { value: 'Ekonomi, Kewirausahaan, Buruh & Tani', text: 'Ekonomi, Kewirausahaan, Buruh & Tani' },
            { value: 'Hikmah & Hubungan antar Lembaga', text: 'Hikmah & Hubungan antar Lembaga' },
            { value: 'Seni Budaya, Olahraga & Pariwisata', text: 'Seni Budaya, Olahraga & Pariwisata' },
            { value: 'Hukum, HAM & Advokasi', text: 'Hukum, HAM & Advokasi' },
            { value: 'ESDM & Lingkungan Hidup', text: 'ESDM & Lingkungan Hidup' }
        ];

        function populateSelect(selectElement, options) {
            selectElement.innerHTML = '';
            options.forEach(option => {
                const optionElement = document.createElement('option');
                optionElement.value = option.value;
                optionElement.textContent = option.text;
                selectElement.appendChild(optionElement);
            });
        }

        function handleJabatanOrganisasiChange() {
            // Hide all and reset required
            if (jabatanStrukturalWrapper) {
                jabatanStrukturalWrapper.style.display = 'none';
                jabatanStrukturalWrapper.classList.add('csp-hidden');
                jabatanStrukturalSelect.required = false;
                jabatanStrukturalSelect.value = '';
            }
            if (jabatanBidangWrapper) {
                jabatanBidangWrapper.style.display = 'none';
                jabatanBidangWrapper.classList.add('csp-hidden');
                jabatanBidangSelect.required = false;
                jabatanBidangSelect.value = '';
            }

            if (jabatanUmumRadio && jabatanUmumRadio.checked) {
                jabatanStrukturalWrapper.style.display = 'block';
                jabatanStrukturalWrapper.classList.remove('csp-hidden');
                jabatanStrukturalSelect.required = true;
                populateSelect(jabatanStrukturalSelect, [
                    { value: '', text: '-- Pilih Jabatan Struktural --' },
                    { value: 'Ketua', text: 'Ketua' },
                    { value: 'Sekretaris', text: 'Sekretaris' },
                    { value: 'Bendahara', text: 'Bendahara' },
                    { value: 'Wakil Bendahara', text: 'Wakil Bendahara' }
                ]);
            } else if (jabatanHarianRadio && jabatanHarianRadio.checked) {
                jabatanStrukturalWrapper.style.display = 'block';
                jabatanStrukturalWrapper.classList.remove('csp-hidden');
                jabatanStrukturalSelect.required = true;
                populateSelect(jabatanStrukturalSelect, [
                    { value: '', text: '-- Pilih Jabatan Struktural --' },
                    { value: 'Wakil Ketua', text: 'Wakil Ketua' },
                    { value: 'Wakil Sekretaris', text: 'Wakil Sekretaris' }
                ]);
                jabatanBidangWrapper.style.display = 'block';
                jabatanBidangWrapper.classList.remove('csp-hidden');
                jabatanBidangSelect.required = true;
                populateSelect(jabatanBidangSelect, bidangOptions);
            } else if (jabatanAnggotaRadio && jabatanAnggotaRadio.checked) {
                jabatanBidangWrapper.style.display = 'block';
                jabatanBidangWrapper.classList.remove('csp-hidden');
                jabatanBidangSelect.required = true;
                populateSelect(jabatanBidangSelect, bidangOptions);
            }
        }

        // Handle structural position change for harian mode
        function handleStrukturalChange() {
            if (jabatanHarianRadio && jabatanHarianRadio.checked) {
                const strukturalValue = jabatanStrukturalSelect.value;
                if (strukturalValue === 'Wakil Sekretaris') {
                    jabatanBidangWrapper.style.display = 'none';
                    jabatanBidangWrapper.classList.add('csp-hidden');
                    jabatanBidangSelect.required = false;
                    jabatanBidangSelect.value = '';
                } else if (strukturalValue === 'Wakil Ketua') {
                    jabatanBidangWrapper.style.display = 'block';
                    jabatanBidangWrapper.classList.remove('csp-hidden');
                    jabatanBidangSelect.required = true;
                    populateSelect(jabatanBidangSelect, bidangOptions);
                }
            }
        }

        // Event listeners
        tipeRantingRadio.addEventListener('change', toggleRantingField);
        tipeCabangRadio.addEventListener('change', toggleRantingField);
        tipeDaerahRadio.addEventListener('change', toggleRantingField);
        if (cabangSelect) {
            cabangSelect.addEventListener('change', fetchRanting);
        }
        if (jabatanUmumRadio) jabatanUmumRadio.addEventListener('change', handleJabatanOrganisasiChange);
        if (jabatanHarianRadio) jabatanHarianRadio.addEventListener('change', handleJabatanOrganisasiChange);
        if (jabatanAnggotaRadio) jabatanAnggotaRadio.addEventListener('change', handleJabatanOrganisasiChange);
        if (jabatanStrukturalSelect) jabatanStrukturalSelect.addEventListener('change', handleStrukturalChange);

        // Initialize
        toggleRantingField();
        handleJabatanOrganisasiChange();
        if (cabangSelect && cabangSelect.value) fetchRanting();

        // Form validation
        const registerForm = document.querySelector('form[action*="register"]');
        if (registerForm) {
            const inputs = registerForm.querySelectorAll('input[required], select[required]');
            
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.value.trim() === '') {
                        this.classList.add('is-invalid');
                    } else {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    }
                });
                
                input.addEventListener('input', function() {
                    if (this.classList.contains('is-invalid') && this.value.trim() !== '') {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    }
                });
            });

            // Password confirmation validation
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('pass_confirm');
            
            if (password && confirmPassword) {
                function validatePassword() {
                    if (password.value !== confirmPassword.value) {
                        confirmPassword.setCustomValidity('Password tidak cocok');
                        confirmPassword.classList.add('is-invalid');
                    } else {
                        confirmPassword.setCustomValidity('');
                        confirmPassword.classList.remove('is-invalid');
                        if (confirmPassword.value.length > 0) {
                            confirmPassword.classList.add('is-valid');
                        }
                    }
                }
                
                password.addEventListener('input', validatePassword);
                confirmPassword.addEventListener('input', validatePassword);
            }
            
            // Form submit animation
            registerForm.addEventListener('submit', function() {
                const submitBtn = this.querySelector('.btn-auth');
                if (submitBtn) {
                    submitBtn.innerHTML = '<i class="bi bi-arrow-clockwise me-2"></i>Memproses...';
                    submitBtn.disabled = true;
                }
            });
        }
    }

    // Auto-hide alerts for register page
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        });
    }, 8000);

    // --- Smooth scrolling for anchor links ---
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href && href !== '#' && href.length > 1) {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });

    // --- Profile Page Animations ---
    const animatedElements = document.querySelectorAll('.program-card, .position-card, .vision-card, .mission-card, .division-card');
    if (animatedElements.length > 0) {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        const observer = new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in-up');
                    entry.target.style.opacity = '1';
                    obs.unobserve(entry.target);
                }
            });
        }, observerOptions);

        animatedElements.forEach(el => {
            el.style.opacity = '0';
            observer.observe(el);
        });
    }
    
    // Handle tab content visibility for profile page
    const profileTabButtons = document.querySelectorAll('#profileTabs .nav-link');
    if (profileTabButtons.length > 0) {
        profileTabButtons.forEach(button => {
            button.addEventListener('shown.bs.tab', function (e) {
                const targetPane = document.querySelector(e.target.getAttribute('data-bs-target'));
                if (targetPane) {
                    const contentCard = targetPane.querySelector('.content-card');
                    if (contentCard) {
                        contentCard.style.opacity = '1';
                        contentCard.classList.add('fade-in-up');
                    }
                }
            });
        });
        
        // Ensure initial active tab content is visible
        const activeTab = document.querySelector('#profileTabs .nav-link.active');
        if (activeTab) {
            const targetPane = document.querySelector(activeTab.getAttribute('data-bs-target'));
            if (targetPane) {
                const contentCard = targetPane.querySelector('.content-card');
                if (contentCard) {
                    contentCard.style.opacity = '1';
                    contentCard.classList.add('fade-in-up');
                }
            }
        }
    }

    // --- Gallery Page Animations ---
    const galleryItems = document.querySelectorAll('.gallery-item');
    if (galleryItems.length > 0) {
        const galleryObserverOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const galleryObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, galleryObserverOptions);
        
        galleryItems.forEach((item, index) => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(30px)';
            item.style.transition = `all 0.6s ease ${index * 0.1}s`;
            galleryObserver.observe(item);
        });
    }

    // --- Berita Page Animations ---
    const newsCards = document.querySelectorAll('.news-card');
    if (newsCards.length > 0) {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);
        
        // Observe news cards for animation
        newsCards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = `all 0.6s ease ${index * 0.1}s`;
            observer.observe(card);
        });
    }

    // --- Agenda Page Animations ---
    const agendaCards = document.querySelectorAll('.agenda-card');
    if (agendaCards.length > 0) {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);
        
        // Observe agenda cards for animation
        agendaCards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = `all 0.6s ease ${index * 0.1}s`;
            observer.observe(card);
        });
    }

    // --- Agenda Detail Modal Handler ---
    const agendaDetailButtons = document.querySelectorAll('[data-agenda-detail]');
    agendaDetailButtons.forEach(button => {
        button.addEventListener('click', function() {
            const agendaData = JSON.parse(this.getAttribute('data-agenda-detail'));
            showAgendaDetail(agendaData);
        });
    });

    // --- Counter Animation for Homepage ---
    function animateCounters() {
        const counters = document.querySelectorAll('.counter');
        
        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-target'));
            const current = parseInt(counter.innerText.replace(/,/g, ''));
            
            if (current < target) {
                const increment = target / 100;
                const newValue = Math.ceil(current + increment);
                
                counter.innerText = newValue.toLocaleString();
                
                setTimeout(() => animateCounters(), 20);
            }
        });
    }

    // Intersection Observer for homepage animations
    const homeObserverOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const homeObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
                
                // Start counter animation when stats section is visible
                if (entry.target.classList.contains('hero-stats')) {
                    setTimeout(animateCounters, 500);
                }
            }
        });
    }, homeObserverOptions);

    // Observe elements for homepage animation
    const homeAnimatedElements = document.querySelectorAll('.feature-card, .stat-card, .agenda-card-modern, .news-card-modern');
    homeAnimatedElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'all 0.6s ease';
        homeObserver.observe(el);
    });
    
    // Observe stats section
    const statsSection = document.querySelector('.hero-stats');
    if (statsSection) {
        homeObserver.observe(statsSection);
    }

});

// --- Gallery Functions ---
// Gallery functionality
function viewImage(imageSrc, imageTitle) {
    const modal = new bootstrap.Modal(document.getElementById('imageViewerModal'));
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('imageViewerModalLabel').textContent = imageTitle;
    modal.show();
}

function downloadImage(imageSrc, imageTitle) {
    const link = document.createElement('a');
    link.href = imageSrc;
    link.download = imageTitle + '.jpg';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// --- Utility Functions ---

// Function to show notifications
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}

// Function to open Google Maps (CSP Compliant)
function openMaps() {
    const address = "Jl. Lawu No. 123, Karanganyar, Jawa Tengah";
    const encodedAddress = encodeURIComponent(address);
    const mapsUrl = `https://www.google.com/maps/search/?api=1&query=${encodedAddress}`;
    
    // Buat link sementara untuk membuka maps
    const link = document.createElement('a');
    link.href = mapsUrl;
    link.target = '_blank';
    link.rel = 'noopener noreferrer';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// Function to validate form fields
function validateField(field) {
    if (field.value.trim() === '') {
        field.classList.add('is-invalid');
        field.classList.remove('is-valid');
    } else if (field.type === 'email' && !isValidEmail(field.value)) {
        field.classList.add('is-invalid');
        field.classList.remove('is-valid');
    } else {
        field.classList.remove('is-invalid');
        field.classList.add('is-valid');
    }
}

// Function to validate email format
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Function to show agenda detail in modal
function showAgendaDetail(agenda) {
    const modal = new bootstrap.Modal(document.getElementById('agendaDetailModal'));
    const content = document.getElementById('agendaDetailContent');
    
    const startDate = new Date(agenda.tanggal_mulai);
    const endDate = new Date(agenda.tanggal_selesai);
    
    content.innerHTML = `
        <div class="agenda-detail">
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="detail-card">
                        <h6 class="detail-label"><i class="bi bi-calendar-event me-2 text-primary"></i>Tanggal</h6>
                        <p class="detail-value">${startDate.toLocaleDateString('id-ID', { 
                            weekday: 'long', 
                            year: 'numeric', 
                            month: 'long', 
                            day: 'numeric' 
                        })}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-card">
                        <h6 class="detail-label"><i class="bi bi-clock me-2 text-primary"></i>Waktu</h6>
                        <p class="detail-value">
                            ${startDate.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })} - 
                            ${endDate.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })} WIB
                        </p>
                    </div>
                </div>
            </div>
            
            ${agenda.lokasi ? `
            <div class="detail-card mb-3">
                <h6 class="detail-label"><i class="bi bi-geo-alt me-2 text-primary"></i>Lokasi</h6>
                <p class="detail-value">${agenda.lokasi}</p>
            </div>
            ` : ''}
            
            ${agenda.penyelenggara ? `
            <div class="detail-card mb-3">
                <h6 class="detail-label"><i class="bi bi-people me-2 text-primary"></i>Penyelenggara</h6>
                <p class="detail-value">${agenda.penyelenggara}</p>
            </div>
            ` : ''}
            
            ${agenda.deskripsi ? `
            <div class="detail-card">
                <h6 class="detail-label"><i class="bi bi-info-circle me-2 text-primary"></i>Deskripsi</h6>
                <div class="detail-value">${agenda.deskripsi}</div>
            </div>
            ` : ''}
        </div>
    `;
    
    document.getElementById('agendaDetailModalLabel').textContent = agenda.nama_kegiatan;
    modal.show();
}
