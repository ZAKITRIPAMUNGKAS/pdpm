/**
 * Navbar Dropdown Fix
 * PDPM Karanganyar - Fix untuk dropdown navbar
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap dropdowns properly
    const dropdownElementList = document.querySelectorAll('.dropdown-toggle');
    const dropdownList = [...dropdownElementList].map(dropdownToggleEl => {
        // Remove any existing Bootstrap dropdown instance
        if (dropdownToggleEl._dropdown) {
            dropdownToggleEl._dropdown.dispose();
        }
        
        // Create new Bootstrap dropdown instance
        return new bootstrap.Dropdown(dropdownToggleEl, {
            autoClose: true,
            boundary: 'viewport',
            reference: 'toggle',
            display: 'dynamic',
            popperConfig: null
        });
    });
    
    // Fix untuk memastikan dropdown bekerja dengan baik
    dropdownElementList.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const dropdownMenu = this.nextElementSibling;
            if (!dropdownMenu || !dropdownMenu.classList.contains('dropdown-menu')) {
                return;
            }
            
            // Toggle dropdown dengan animasi
            if (dropdownMenu.classList.contains('show')) {
                // Tutup dropdown
                dropdownMenu.style.opacity = '0';
                dropdownMenu.style.transform = 'translateY(-10px)';
                
                setTimeout(() => {
                    dropdownMenu.classList.remove('show');
                    this.setAttribute('aria-expanded', 'false');
                    dropdownMenu.style.opacity = '';
                    dropdownMenu.style.transform = '';
                }, 200);
            } else {
                // Tutup dropdown lain yang terbuka
                document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                    menu.classList.remove('show');
                    const otherToggle = menu.previousElementSibling;
                    if (otherToggle) {
                        otherToggle.setAttribute('aria-expanded', 'false');
                    }
                });
                
                // Buka dropdown ini
                dropdownMenu.classList.add('show');
                this.setAttribute('aria-expanded', 'true');
                
                // Animasi smooth
                dropdownMenu.style.opacity = '0';
                dropdownMenu.style.transform = 'translateY(-10px)';
                dropdownMenu.style.transition = 'all 0.2s ease';
                
                setTimeout(() => {
                    dropdownMenu.style.opacity = '1';
                    dropdownMenu.style.transform = 'translateY(0)';
                }, 10);
            }
        });
    });
    
    // Tutup dropdown saat klik di luar
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                menu.style.opacity = '0';
                menu.style.transform = 'translateY(-10px)';
                
                setTimeout(() => {
                    menu.classList.remove('show');
                    const toggle = menu.previousElementSibling;
                    if (toggle) {
                        toggle.setAttribute('aria-expanded', 'false');
                    }
                    menu.style.opacity = '';
                    menu.style.transform = '';
                }, 200);
            });
        }
    });
    
    // Handle dropdown item clicks
    document.querySelectorAll('.dropdown-item').forEach(item => {
        item.addEventListener('click', function(e) {
            const dropdownMenu = this.closest('.dropdown-menu');
            if (dropdownMenu) {
                setTimeout(() => {
                    dropdownMenu.classList.remove('show');
                    const toggle = dropdownMenu.previousElementSibling;
                    if (toggle) {
                        toggle.setAttribute('aria-expanded', 'false');
                    }
                }, 100);
            }
        });
    });
    
    // Mobile specific fixes
    if (window.innerWidth <= 991) {
        // Ensure dropdown works on mobile
        dropdownElementList.forEach(toggle => {
            toggle.removeAttribute('data-bs-toggle');
            toggle.removeAttribute('data-bs-auto-close');
        });
    }
    
    // Re-initialize on window resize
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            // Re-initialize dropdowns after resize
            dropdownList.forEach(dropdown => {
                if (dropdown && dropdown._element) {
                    dropdown.dispose();
                }
            });
            
            // Recreate dropdowns
            [...dropdownElementList].map(dropdownToggleEl => {
                return new bootstrap.Dropdown(dropdownToggleEl, {
                    autoClose: true,
                    boundary: 'viewport'
                });
            });
        }, 250);
    });
});

// Add smooth transition styles
const dropdownStyles = document.createElement('style');
dropdownStyles.textContent = `
    /* Dropdown transition styles */
    .dropdown-menu {
        transition: opacity 0.2s ease, transform 0.2s ease;
    }
    
    .dropdown-menu:not(.show) {
        display: none !important;
    }
    
    .dropdown-toggle::after {
        transition: transform 0.2s ease;
    }
    
    .dropdown-toggle[aria-expanded="true"]::after {
        transform: rotate(180deg);
    }
    
    /* Ensure dropdown is clickable */
    .dropdown-toggle {
        cursor: pointer;
        user-select: none;
    }
    
    /* Mobile dropdown styles */
    @media (max-width: 991.98px) {
        .navbar-collapse .dropdown-menu {
            position: static !important;
            float: none;
            width: auto;
            margin-top: 0.125rem;
            background-color: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(0, 0, 0, 0.1);
        }
        
        .navbar-collapse .dropdown-menu .dropdown-item {
            padding: 0.5rem 1.5rem;
        }
    }
    
    /* Desktop dropdown positioning */
    @media (min-width: 992px) {
        .navbar .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            left: auto;
            margin-top: 0.125rem;
        }
    }
`;
document.head.appendChild(dropdownStyles);
