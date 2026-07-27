(function() {
/**
 * Mobile Sidebar Toggle Handler
 * Manages sidebar visibility on mobile devices
 */

document.addEventListener('DOMContentLoaded', function() {
    // Duplicate toggle creation removed - template.php handles #sidebarToggleBtn
    const createMobileToggle = () => {};
    
    // Create overlay element
    const createOverlay = () => {
        if (!document.querySelector('.sidebar-overlay')) {
            const overlay = document.createElement('div');
            overlay.className = 'sidebar-overlay';
            document.body.appendChild(overlay);
        }
    };
    
    // Initialize mobile sidebar
    createMobileToggle();
    createOverlay();
    
    // Handle sidebar toggle
    const sidebar = document.querySelector('.sidebar-minimalist');
    const overlay = document.querySelector('.sidebar-overlay');
    const toggleBtn = document.querySelector('.sidebar-toggle-mobile');
    
    if (toggleBtn && sidebar && overlay) {
        toggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
            document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
        });
        
        // Close sidebar when clicking overlay
        overlay.addEventListener('click', function() {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
            document.body.style.overflow = '';
        });
        
        // Close sidebar when clicking a nav link on mobile
        const navLinks = sidebar.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                    document.body.style.overflow = '';
                }
            });
        });
    }
    
    // Handle window resize
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            const toggleBtn = document.querySelector('.sidebar-toggle-mobile');
            const navbarBrand = document.querySelector('.navbar-brand');
            
            if (window.innerWidth > 768) {
                // Remove mobile elements on desktop
                if (toggleBtn) {
                    toggleBtn.remove();
                }
                if (navbarBrand) {
                    navbarBrand.style.marginLeft = '';
                }
                if (sidebar) {
                    sidebar.classList.remove('show');
                }
                if (overlay) {
                    overlay.classList.remove('show');
                }
                document.body.style.overflow = '';
            } else {
                // Re-create mobile toggle if needed
                createMobileToggle();
            }
        }, 250);
    });
    
    // Handle escape key to close sidebar
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && sidebar && sidebar.classList.contains('show')) {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
            document.body.style.overflow = '';
        }
    });
    
    // Prevent body scroll when sidebar is open
    const preventBodyScroll = () => {
        if (sidebar && sidebar.classList.contains('show')) {
            document.body.style.overflow = 'hidden';
        }
    };
    
    // Touch swipe support for mobile
    let touchStartX = 0;
    let touchEndX = 0;
    
    document.addEventListener('touchstart', function(e) {
        touchStartX = e.changedTouches[0].screenX;
    }, false);
    
    document.addEventListener('touchend', function(e) {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    }, false);
    
    function handleSwipe() {
        if (!sidebar) return;
        
        // Swipe right to open sidebar (from left edge)
        if (touchStartX < 50 && touchEndX > touchStartX + 50) {
            sidebar.classList.add('show');
            overlay.classList.add('show');
            document.body.style.overflow = 'hidden';
        }
        
        // Swipe left to close sidebar
        if (sidebar.classList.contains('show') && touchEndX < touchStartX - 50) {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
            document.body.style.overflow = '';
        }
    }
    
    // Add active class to current page in sidebar
    const currentPath = window.location.pathname;
    const sidebarLinks = document.querySelectorAll('.sidebar-nav .nav-link');
    
    sidebarLinks.forEach(link => {
        const linkPath = new URL(link.href).pathname;
        if (currentPath === linkPath || 
            (currentPath.includes(linkPath) && linkPath !== '/')) {
            link.classList.add('active');
        }
    });
    
    // Smooth scroll for sidebar
    if (sidebar) {
        const activeLink = sidebar.querySelector('.nav-link.active');
        if (activeLink) {
            setTimeout(() => {
                activeLink.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }, 100);
        }
    }
});

// Add CSS for smooth transitions
const sidebarStyle = document.createElement('style');
sidebarStyle.textContent = `
    .sidebar-minimalist {
        transition: left 0.3s ease !important;
    }
    
    .sidebar-overlay {
        transition: opacity 0.3s ease;
        opacity: 0;
        pointer-events: none;
    }
    
    .sidebar-overlay.show {
        opacity: 1;
        pointer-events: auto;
    }
    
    .sidebar-toggle-mobile {
        transition: transform 0.2s ease;
    }
    
    .sidebar-toggle-mobile:hover {
        transform: translateY(-50%) scale(1.1);
    }
    
    .sidebar-toggle-mobile:active {
        transform: translateY(-50%) scale(0.95);
    }
    
    @media (max-width: 768px) {
        .navbar-brand {
            transition: margin-left 0.3s ease;
        }
    }
`;
document.head.appendChild(sidebarStyle);
})();
