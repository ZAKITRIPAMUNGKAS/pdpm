/**
 * Enhanced Dashboard JavaScript
 * Interactive features for PDPM Karanganyar Dashboard
 */

(function() {
    'use strict';

    // ===================================
    // INITIALIZATION
    // ===================================
    
    document.addEventListener('DOMContentLoaded', function() {
        initializeAnimations();
        initializeCounters();
        initializeProgressBars();
        initializeTooltips();
        initializeCharts();
        initializeQuickJoin();
        initializeActivityFeed();
        initializeSmoothScroll();
        initializeLoadingStates();
        initializeResponsiveFeatures();
    });

    // ===================================
    // ANIMATIONS
    // ===================================
    
    function initializeAnimations() {
        // Intersection Observer for fade-in animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animated');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observe elements with animation classes
        document.querySelectorAll('.stat-card, .modern-card, .sidebar-card').forEach(el => {
            observer.observe(el);
        });
    }

    // ===================================
    // NUMBER COUNTERS
    // ===================================
    
    function initializeCounters() {
        const counters = document.querySelectorAll('.stat-number, .points-number');
        
        counters.forEach(counter => {
            const target = parseInt(counter.innerText.replace(/,/g, ''));
            const duration = 1500; // Animation duration in ms
            const increment = target / (duration / 16); // 60 FPS
            let current = 0;
            
            const updateCounter = () => {
                current += increment;
                if (current < target) {
                    counter.innerText = formatNumber(Math.floor(current));
                    requestAnimationFrame(updateCounter);
                } else {
                    counter.innerText = formatNumber(target);
                }
            };
            
            // Start animation when element is visible
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        updateCounter();
                        observer.unobserve(entry.target);
                    }
                });
            });
            
            observer.observe(counter);
        });
    }
    
    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    // ===================================
    // PROGRESS BARS
    // ===================================
    
    function initializeProgressBars() {
        const progressBars = document.querySelectorAll('.progress-bar');
        
        progressBars.forEach(bar => {
            const width = bar.getAttribute('data-width') || bar.style.width;
            if (width) {
                bar.style.width = '0%';
                
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            setTimeout(() => {
                                bar.style.width = width;
                            }, 200);
                            observer.unobserve(entry.target);
                        }
                    });
                });
                
                observer.observe(bar);
            }
        });
    }

    // ===================================
    // TOOLTIPS
    // ===================================
    
    function initializeTooltips() {
        // Initialize Bootstrap tooltips if available
        if (typeof bootstrap !== 'undefined') {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
        
        // Custom tooltips for stat cards
        document.querySelectorAll('.stat-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                const label = this.querySelector('.stat-label').textContent;
                const number = this.querySelector('.stat-number').textContent;
                this.setAttribute('title', `${label}: ${number}`);
            });
        });
    }

    // ===================================
    // CHARTS (Using Chart.js if available)
    // ===================================
    
    function initializeCharts() {
        // Check if Chart.js is loaded
        if (typeof Chart === 'undefined') {
            // Create simple CSS-based charts as fallback
            createCSSCharts();
            return;
        }
        
        // Initialize actual charts with Chart.js
        initializeStatisticsChart();
        initializeActivityChart();
    }
    
    function createCSSCharts() {
        // Create simple bar charts using CSS
        const chartContainers = document.querySelectorAll('[data-chart-type="bar"]');
        
        chartContainers.forEach(container => {
            const data = JSON.parse(container.getAttribute('data-chart-data') || '[]');
            if (data.length === 0) return;
            
            const maxValue = Math.max(...data.map(d => d.value));
            const chartHTML = data.map(item => `
                <div class="css-chart-bar">
                    <div class="bar-fill" style="height: ${(item.value / maxValue) * 100}%">
                        <span class="bar-value">${item.value}</span>
                    </div>
                    <span class="bar-label">${item.label}</span>
                </div>
            `).join('');
            
            container.innerHTML = `<div class="css-chart">${chartHTML}</div>`;
        });
    }
    
    function initializeStatisticsChart() {
        const ctx = document.getElementById('statisticsChart');
        if (!ctx) return;
        
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Hadir', 'Tidak Hadir', 'Pending'],
                datasets: [{
                    data: [65, 20, 15],
                    backgroundColor: [
                        '#28a745',
                        '#dc3545',
                        '#ffc107'
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }
    
    function initializeActivityChart() {
        const ctx = document.getElementById('activityChart');
        if (!ctx) return;
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Aktivitas',
                    data: [12, 19, 3, 5, 2, 3],
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220, 53, 69, 0.1)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }

    // ===================================
    // QUICK JOIN FUNCTIONALITY
    // ===================================
    
    function initializeQuickJoin() {
        const quickJoinBtns = document.querySelectorAll('.quick-join-btn');
        
        quickJoinBtns.forEach(btn => {
            btn.addEventListener('click', async function(e) {
                e.preventDefault();
                
                const agendaId = this.getAttribute('data-agenda-id');
                const agendaName = this.getAttribute('data-agenda-name');
                
                // Show loading state
                const originalContent = this.innerHTML;
                this.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Memproses...';
                this.disabled = true;
                
                try {
                    // Simulate API call (replace with actual API endpoint)
                    const response = await fetch(`/api/agenda/join/${agendaId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    
                    if (response.ok) {
                        // Success state
                        this.innerHTML = '<i class="bi bi-check-circle me-2"></i>Terdaftar';
                        this.classList.remove('btn-primary');
                        this.classList.add('btn-success');
                        
                        // Show success notification
                        showNotification('success', `Berhasil mendaftar ke ${agendaName}`);
                        
                        // Update UI
                        updateAgendaCard(agendaId, true);
                    } else {
                        throw new Error('Failed to join agenda');
                    }
                } catch (error) {
                    // Error state
                    this.innerHTML = originalContent;
                    this.disabled = false;
                    
                    // Show error notification
                    showNotification('error', 'Gagal mendaftar. Silakan coba lagi.');
                    console.error('Error joining agenda:', error);
                }
            });
        });
    }
    
    function updateAgendaCard(agendaId, joined) {
        const card = document.querySelector(`[data-agenda-id="${agendaId}"]`).closest('.agenda-item');
        if (card && joined) {
            // Add joined badge
            const badge = document.createElement('span');
            badge.className = 'badge bg-success rounded-pill ms-2';
            badge.innerHTML = '<i class="bi bi-check-circle me-1"></i>Terdaftar';
            
            const titleElement = card.querySelector('.agenda-title');
            if (titleElement && !card.querySelector('.badge')) {
                titleElement.appendChild(badge);
            }
        }
    }

    // ===================================
    // ACTIVITY FEED
    // ===================================
    
    function initializeActivityFeed() {
        // Activity feed auto-refresh disabled - data is pre-rendered via server
    }

    // ===================================
    // SMOOTH SCROLL
    // ===================================
    
    function initializeSmoothScroll() {
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
    }

    // ===================================
    // LOADING STATES
    // ===================================
    
    function initializeLoadingStates() {
        // Add loading skeletons while data loads
        const dataContainers = document.querySelectorAll('[data-loading="true"]');
        
        dataContainers.forEach(container => {
            showSkeleton(container);
            
            // Remove skeleton when data is loaded
            container.addEventListener('data-loaded', () => {
                hideSkeleton(container);
            });
        });
    }
    
    function showSkeleton(container) {
        const skeletonHTML = `
            <div class="skeleton-wrapper">
                <div class="skeleton skeleton-title"></div>
                <div class="skeleton skeleton-text"></div>
                <div class="skeleton skeleton-text"></div>
            </div>
        `;
        container.innerHTML = skeletonHTML;
    }
    
    function hideSkeleton(container) {
        const skeleton = container.querySelector('.skeleton-wrapper');
        if (skeleton) {
            skeleton.style.opacity = '0';
            setTimeout(() => {
                skeleton.remove();
            }, 300);
        }
    }

    // ===================================
    // RESPONSIVE FEATURES
    // ===================================
    
    function initializeResponsiveFeatures() {
        // Handle mobile menu toggle for sidebar
        const sidebarToggle = document.querySelector('[data-toggle="sidebar"]');
        const sidebar = document.querySelector('.member-sidebar');
        
        if (sidebarToggle && sidebar) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('show');
                document.body.classList.toggle('sidebar-open');
            });
            
            // Close sidebar when clicking outside
            document.addEventListener('click', (e) => {
                if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                    sidebar.classList.remove('show');
                    document.body.classList.remove('sidebar-open');
                }
            });
        }
        
        // Adjust card layouts on resize
        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                adjustCardLayouts();
            }, 250);
        });
    }
    
    function adjustCardLayouts() {
        const isMobile = window.innerWidth < 768;
        const cards = document.querySelectorAll('.stat-card');
        
        cards.forEach(card => {
            if (isMobile) {
                card.classList.add('mobile-view');
            } else {
                card.classList.remove('mobile-view');
            }
        });
    }

    // ===================================
    // NOTIFICATIONS
    // ===================================
    
    function showNotification(type, message) {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                <span>${message}</span>
            </div>
            <button class="notification-close" onclick="this.parentElement.remove()">
                <i class="bi bi-x"></i>
            </button>
        `;
        
        // Add to notification container
        let container = document.querySelector('.notification-container');
        if (!container) {
            container = document.createElement('div');
            container.className = 'notification-container';
            document.body.appendChild(container);
        }
        
        container.appendChild(notification);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease-out';
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 5000);
    }

    // ===================================
    // UTILITY FUNCTIONS
    // ===================================
    
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
    
    function throttle(func, limit) {
        let inThrottle;
        return function(...args) {
            if (!inThrottle) {
                func.apply(this, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    }

    // ===================================
    // EXPORT PUBLIC API
    // ===================================
    
    window.DashboardEnhanced = {
        showNotification,
        showSkeleton,
        hideSkeleton,
        updateActivityFeed,
        formatNumber
    };

})();

// ===================================
// NOTIFICATION STYLES (Add to CSS)
// ===================================

const notificationStyles = `
<style>
.notification-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    pointer-events: none;
}

.notification {
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    padding: 16px;
    margin-bottom: 12px;
    min-width: 300px;
    pointer-events: all;
    animation: slideIn 0.3s ease-out;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.notification-success {
    border-left: 4px solid #28a745;
}

.notification-error {
    border-left: 4px solid #dc3545;
}

.notification-content {
    display: flex;
    align-items: center;
    flex: 1;
}

.notification-close {
    background: none;
    border: none;
    font-size: 1.2rem;
    cursor: pointer;
    opacity: 0.6;
    transition: opacity 0.2s;
    padding: 0;
    margin-left: 12px;
}

.notification-close:hover {
    opacity: 1;
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOut {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(100%);
        opacity: 0;
    }
}

.css-chart {
    display: flex;
    align-items: flex-end;
    justify-content: space-around;
    height: 200px;
    padding: 10px;
}

.css-chart-bar {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    margin: 0 5px;
}

.bar-fill {
    width: 100%;
    background: linear-gradient(135deg, #dc3545, #ffc107);
    border-radius: 4px 4px 0 0;
    position: relative;
    transition: height 1s ease-out;
    min-height: 5px;
}

.bar-value {
    position: absolute;
    top: -20px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 0.75rem;
    font-weight: 600;
}

.bar-label {
    margin-top: 8px;
    font-size: 0.75rem;
    color: #6c757d;
    text-align: center;
}
</style>
`;

// Inject notification styles
document.head.insertAdjacentHTML('beforeend', notificationStyles);
