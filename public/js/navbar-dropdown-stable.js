/**
 * Navbar Dropdown Stable Fix
 * Mengatasi masalah dropdown yang muncul-hilang
 */

document.addEventListener('DOMContentLoaded', function() {
    // Wait for Bootstrap to load
    setTimeout(function() {
        // Get all dropdown toggles in navbar
        const dropdownToggles = document.querySelectorAll('.navbar .dropdown-toggle');
        
        dropdownToggles.forEach(function(toggle) {
            // Remove Bootstrap's auto handling
            toggle.removeAttribute('data-bs-toggle');
            
            // Add our own click handler
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const dropdown = this.parentElement;
                const menu = dropdown.querySelector('.dropdown-menu');
                
                if (!menu) return;
                
                // Check current state
                const isOpen = menu.classList.contains('show');
                
                // Close all dropdowns
                document.querySelectorAll('.navbar .dropdown-menu.show').forEach(function(openMenu) {
                    openMenu.classList.remove('show');
                    openMenu.previousElementSibling.setAttribute('aria-expanded', 'false');
                });
                
                // Toggle this dropdown
                if (!isOpen) {
                    menu.classList.add('show');
                    this.setAttribute('aria-expanded', 'true');
                } else {
                    menu.classList.remove('show');
                    this.setAttribute('aria-expanded', 'false');
                }
            });
        });
        
        // Close on outside click
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.navbar .dropdown')) {
                document.querySelectorAll('.navbar .dropdown-menu.show').forEach(function(menu) {
                    menu.classList.remove('show');
                    const toggle = menu.previousElementSibling;
                    if (toggle) {
                        toggle.setAttribute('aria-expanded', 'false');
                    }
                });
            }
        });
        
        // Handle menu item clicks
        document.querySelectorAll('.navbar .dropdown-item').forEach(function(item) {
            item.addEventListener('click', function() {
                const menu = this.closest('.dropdown-menu');
                if (menu) {
                    setTimeout(function() {
                        menu.classList.remove('show');
                        const toggle = menu.previousElementSibling;
                        if (toggle) {
                            toggle.setAttribute('aria-expanded', 'false');
                        }
                    }, 50);
                }
            });
        });
    }, 100); // Small delay to ensure Bootstrap is loaded
});
