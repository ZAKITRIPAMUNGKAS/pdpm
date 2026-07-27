/**
 * UI Enhancements for PDPM Karanganyar Website
 * Includes loading states, error handling, and user experience improvements
 */

class UIEnhancements {
    constructor() {
        this.init();
    }

    init() {
        this.setupLoadingStates();
        this.setupFormValidation();
        this.setupErrorHandling();
        this.setupAccessibility();
        this.setupProgressIndicators();
        this.setupToastNotifications();
        this.setupLazyLoading();
        this.setupSmoothScrolling();
    }

    /**
     * Setup loading states for forms and buttons
     */
    setupLoadingStates() {
        // Add loading state to all forms
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', (e) => {
                const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
                if (submitBtn && !form.hasAttribute('data-no-loading')) {
                    this.showButtonLoading(submitBtn);
                }
            });
        });

        // Add loading state to AJAX buttons
        document.querySelectorAll('[data-ajax]').forEach(button => {
            button.addEventListener('click', (e) => {
                this.showButtonLoading(button);
            });
        });
    }

    /**
     * Show loading state on button
     */
    showButtonLoading(button) {
        if (button.hasAttribute('data-loading')) return;

        const originalText = button.innerHTML;
        const loadingText = button.getAttribute('data-loading-text') || 'Memproses...';
        
        button.setAttribute('data-loading', 'true');
        button.setAttribute('data-original-text', originalText);
        button.disabled = true;
        
        button.innerHTML = `
            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
            ${loadingText}
        `;

        // Auto-restore after 30 seconds (fallback)
        setTimeout(() => {
            this.hideButtonLoading(button);
        }, 30000);
    }

    /**
     * Hide loading state on button
     */
    hideButtonLoading(button) {
        if (!button.hasAttribute('data-loading')) return;

        const originalText = button.getAttribute('data-original-text');
        
        button.removeAttribute('data-loading');
        button.removeAttribute('data-original-text');
        button.disabled = false;
        button.innerHTML = originalText;
    }

    /**
     * Setup enhanced form validation
     */
    setupFormValidation() {
        // Real-time validation
        document.querySelectorAll('input, textarea, select').forEach(field => {
            field.addEventListener('blur', () => {
                this.validateField(field);
            });

            field.addEventListener('input', () => {
                if (field.classList.contains('is-invalid')) {
                    this.validateField(field);
                }
            });
        });

        // Password strength indicator
        document.querySelectorAll('input[type="password"]').forEach(passwordField => {
            if (passwordField.name === 'password' || passwordField.name === 'new_password') {
                this.setupPasswordStrengthIndicator(passwordField);
            }
        });
    }

    /**
     * Validate individual field
     */
    validateField(field) {
        const value = field.value.trim();
        let isValid = true;
        let errorMessage = '';

        // Required field validation
        if (field.hasAttribute('required') && !value) {
            isValid = false;
            errorMessage = 'Field ini wajib diisi';
        }

        // Email validation
        if (field.type === 'email' && value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                isValid = false;
                errorMessage = 'Format email tidak valid';
            }
        }

        // Phone validation
        if (field.name === 'no_hp' && value) {
            const phoneRegex = /^(\+62|62|0)[0-9]{9,13}$/;
            if (!phoneRegex.test(value)) {
                isValid = false;
                errorMessage = 'Format nomor HP tidak valid';
            }
        }

        // Minimum length validation
        const minLength = field.getAttribute('minlength');
        if (minLength && value.length < parseInt(minLength)) {
            isValid = false;
            errorMessage = `Minimal ${minLength} karakter`;
        }

        // Update field appearance
        this.updateFieldValidation(field, isValid, errorMessage);
        
        return isValid;
    }

    /**
     * Update field validation appearance
     */
    updateFieldValidation(field, isValid, errorMessage) {
        const feedbackElement = field.parentNode.querySelector('.invalid-feedback') || 
                               field.parentNode.querySelector('.error-message');

        if (isValid) {
            field.classList.remove('is-invalid');
            field.classList.add('is-valid');
            if (feedbackElement) {
                feedbackElement.style.display = 'none';
            }
        } else {
            field.classList.remove('is-valid');
            field.classList.add('is-invalid');
            
            if (feedbackElement) {
                feedbackElement.textContent = errorMessage;
                feedbackElement.style.display = 'block';
            } else {
                // Create error message element
                const errorDiv = document.createElement('div');
                errorDiv.className = 'invalid-feedback';
                errorDiv.textContent = errorMessage;
                field.parentNode.appendChild(errorDiv);
            }
        }
    }

    /**
     * Setup password strength indicator
     */
    setupPasswordStrengthIndicator(passwordField) {
        const strengthIndicator = document.createElement('div');
        strengthIndicator.className = 'password-strength mt-2';
        strengthIndicator.innerHTML = `
            <div class="strength-bar">
                <div class="strength-fill"></div>
            </div>
            <div class="strength-text">Kekuatan password</div>
        `;
        
        passwordField.parentNode.appendChild(strengthIndicator);

        passwordField.addEventListener('input', () => {
            const strength = this.calculatePasswordStrength(passwordField.value);
            this.updatePasswordStrengthIndicator(strengthIndicator, strength);
        });
    }

    /**
     * Calculate password strength
     */
    calculatePasswordStrength(password) {
        let score = 0;
        let feedback = [];

        if (password.length >= 8) score += 2;
        else feedback.push('Minimal 8 karakter');

        if (/[a-z]/.test(password)) score += 1;
        else feedback.push('Huruf kecil');

        if (/[A-Z]/.test(password)) score += 1;
        else feedback.push('Huruf besar');

        if (/[0-9]/.test(password)) score += 1;
        else feedback.push('Angka');

        if (/[^a-zA-Z0-9]/.test(password)) score += 1;
        else feedback.push('Karakter khusus');

        let strength = 'weak';
        if (score >= 5) strength = 'strong';
        else if (score >= 3) strength = 'medium';

        return { score, strength, feedback };
    }

    /**
     * Update password strength indicator
     */
    updatePasswordStrengthIndicator(indicator, strength) {
        const fill = indicator.querySelector('.strength-fill');
        const text = indicator.querySelector('.strength-text');

        const colors = {
            weak: '#dc3545',
            medium: '#ffc107',
            strong: '#28a745'
        };

        const labels = {
            weak: 'Lemah',
            medium: 'Sedang',
            strong: 'Kuat'
        };

        const percentage = (strength.score / 6) * 100;
        
        fill.style.width = `${percentage}%`;
        fill.style.backgroundColor = colors[strength.strength];
        text.textContent = `Kekuatan password: ${labels[strength.strength]}`;
        
        if (strength.feedback.length > 0) {
            text.textContent += ` (Perlu: ${strength.feedback.join(', ')})`;
        }
    }

    /**
     * Setup global error handling
     */
    setupErrorHandling() {
        // Handle AJAX errors
        document.addEventListener('ajaxError', (e) => {
            this.showToast('Terjadi kesalahan. Silakan coba lagi.', 'error');
        });

        // Handle form submission errors
        document.addEventListener('formError', (e) => {
            const form = e.detail.form;
            const errors = e.detail.errors;
            
            this.showFormErrors(form, errors);
        });

        // Handle network errors
        window.addEventListener('offline', () => {
            this.showToast('Koneksi internet terputus', 'warning');
        });

        window.addEventListener('online', () => {
            this.showToast('Koneksi internet tersambung kembali', 'success');
        });
    }

    /**
     * Show form errors
     */
    showFormErrors(form, errors) {
        // Clear previous errors
        form.querySelectorAll('.is-invalid').forEach(field => {
            field.classList.remove('is-invalid');
        });

        form.querySelectorAll('.invalid-feedback').forEach(feedback => {
            feedback.remove();
        });

        // Show new errors
        Object.keys(errors).forEach(fieldName => {
            const field = form.querySelector(`[name="${fieldName}"]`);
            if (field) {
                this.updateFieldValidation(field, false, errors[fieldName]);
            }
        });

        // Focus on first error field
        const firstErrorField = form.querySelector('.is-invalid');
        if (firstErrorField) {
            firstErrorField.focus();
            firstErrorField.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    /**
     * Setup accessibility improvements
     */
    setupAccessibility() {
        // Add ARIA labels to form fields without labels
        document.querySelectorAll('input, textarea, select').forEach(field => {
            if (!field.getAttribute('aria-label') && !field.getAttribute('aria-labelledby')) {
                const placeholder = field.getAttribute('placeholder');
                if (placeholder) {
                    field.setAttribute('aria-label', placeholder);
                }
            }
        });

        // Keyboard navigation for custom elements
        document.querySelectorAll('[data-toggle]').forEach(element => {
            element.setAttribute('tabindex', '0');
            element.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    element.click();
                }
            });
        });

        // Skip to main content link
        if (!document.querySelector('.skip-link')) {
            const skipLink = document.createElement('a');
            skipLink.className = 'skip-link sr-only sr-only-focusable';
            skipLink.href = '#main-content';
            skipLink.textContent = 'Skip to main content';
            document.body.insertBefore(skipLink, document.body.firstChild);
        }
    }

    /**
     * Setup progress indicators
     */
    setupProgressIndicators() {
        // File upload progress
        document.querySelectorAll('input[type="file"]').forEach(fileInput => {
            fileInput.addEventListener('change', (e) => {
                if (e.target.files.length > 0) {
                    this.showFileUploadProgress(e.target);
                }
            });
        });

        // Form completion progress
        document.querySelectorAll('form[data-progress]').forEach(form => {
            this.setupFormProgress(form);
        });
    }

    /**
     * Show file upload progress
     */
    showFileUploadProgress(fileInput) {
        const file = fileInput.files[0];
        const progressContainer = document.createElement('div');
        progressContainer.className = 'upload-progress mt-2';
        progressContainer.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-1">
                <small class="text-muted">${file.name}</small>
                <small class="text-muted">${this.formatFileSize(file.size)}</small>
            </div>
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: 0%"></div>
            </div>
        `;
        
        fileInput.parentNode.appendChild(progressContainer);

        // Simulate upload progress (replace with actual upload logic)
        let progress = 0;
        const progressBar = progressContainer.querySelector('.progress-bar');
        
        const interval = setInterval(() => {
            progress += Math.random() * 30;
            if (progress >= 100) {
                progress = 100;
                clearInterval(interval);
                setTimeout(() => {
                    progressContainer.remove();
                }, 1000);
            }
            progressBar.style.width = `${progress}%`;
        }, 200);
    }

    /**
     * Setup form completion progress
     */
    setupFormProgress(form) {
        const requiredFields = form.querySelectorAll('[required]');
        const progressBar = document.createElement('div');
        progressBar.className = 'form-progress mb-3';
        progressBar.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-1">
                <small class="text-muted">Progress pengisian form</small>
                <small class="text-muted"><span class="progress-text">0%</span></small>
            </div>
            <div class="progress">
                <div class="progress-bar bg-success" role="progressbar" style="width: 0%"></div>
            </div>
        `;
        
        form.insertBefore(progressBar, form.firstChild);

        const updateProgress = () => {
            const filledFields = Array.from(requiredFields).filter(field => {
                return field.value.trim() !== '';
            });
            
            const percentage = (filledFields.length / requiredFields.length) * 100;
            const progressBarElement = progressBar.querySelector('.progress-bar');
            const progressText = progressBar.querySelector('.progress-text');
            
            progressBarElement.style.width = `${percentage}%`;
            progressText.textContent = `${Math.round(percentage)}%`;
        };

        requiredFields.forEach(field => {
            field.addEventListener('input', updateProgress);
            field.addEventListener('change', updateProgress);
        });

        updateProgress();
    }

    /**
     * Setup toast notifications
     */
    setupToastNotifications() {
        // Create toast container if not exists
        if (!document.querySelector('.toast-container')) {
            const container = document.createElement('div');
            container.className = 'toast-container position-fixed top-0 end-0 p-3';
            container.style.zIndex = '9999';
            document.body.appendChild(container);
        }
    }

    /**
     * Show toast notification
     */
    showToast(message, type = 'info', duration = 5000) {
        const container = document.querySelector('.toast-container');
        const toastId = 'toast-' + Date.now();
        
        const icons = {
            success: 'bi-check-circle-fill',
            error: 'bi-exclamation-triangle-fill',
            warning: 'bi-exclamation-circle-fill',
            info: 'bi-info-circle-fill'
        };

        const colors = {
            success: 'text-success',
            error: 'text-danger',
            warning: 'text-warning',
            info: 'text-info'
        };

        const toastHTML = `
            <div id="${toastId}" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <i class="bi ${icons[type]} ${colors[type]} me-2"></i>
                    <strong class="me-auto">PDPM Karanganyar</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    ${message}
                </div>
            </div>
        `;

        container.insertAdjacentHTML('beforeend', toastHTML);
        
        const toastElement = document.getElementById(toastId);
        const toast = new bootstrap.Toast(toastElement, { delay: duration });
        
        toast.show();

        // Remove toast element after it's hidden
        toastElement.addEventListener('hidden.bs.toast', () => {
            toastElement.remove();
        });
    }

    /**
     * Setup lazy loading for images
     */
    setupLazyLoading() {
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });

            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }
    }

    /**
     * Setup smooth scrolling
     */
    setupSmoothScrolling() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    }

    /**
     * Format file size
     */
    formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    /**
     * Show success message
     */
    showSuccess(message) {
        this.showToast(message, 'success');
    }

    /**
     * Show error message
     */
    showError(message) {
        this.showToast(message, 'error');
    }

    /**
     * Show warning message
     */
    showWarning(message) {
        this.showToast(message, 'warning');
    }

    /**
     * Show info message
     */
    showInfo(message) {
        this.showToast(message, 'info');
    }
}

// Initialize UI enhancements when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.uiEnhancements = new UIEnhancements();
});

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = UIEnhancements;
}
