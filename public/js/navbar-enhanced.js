/**
 * Navbar Enhanced JavaScript
 * PDPM Karanganyar - Navbar Interactions
 */

document.addEventListener('DOMContentLoaded', function() {
    // Get navbar element
    const navbar = document.querySelector('.navbar');
    
    // Scroll effect
    if (navbar) {
        let lastScrollTop = 0;
        
        window.addEventListener('scroll', function() {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            // Add scrolled class when scrolling down
            if (scrollTop > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
            
            // Hide/show navbar on scroll
            if (scrollTop > lastScrollTop && scrollTop > 100) {
                // Scrolling down
                navbar.style.transform = 'translateY(-100%)';
            } else {
                // Scrolling up
                navbar.style.transform = 'translateY(0)';
            }
            
            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
        }, false);
    }
    
    // Removed hover effect to prevent conflict with click functionality
    // Dropdown functionality is now handled by navbar-dropdown-fix.js
    
    // Add ripple effect to nav links
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
    
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Create ripple element
            const ripple = document.createElement('span');
            ripple.classList.add('ripple');
            
            // Calculate position
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            // Set ripple styles
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            
            // Add ripple to link
            this.appendChild(ripple);
            
            // Remove ripple after animation
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
    
    // Mobile menu toggle animation
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    
    if (navbarToggler && navbarCollapse) {
        navbarToggler.addEventListener('click', function() {
            // Add animation class
            navbarCollapse.classList.toggle('animating');
            
            setTimeout(() => {
                navbarCollapse.classList.remove('animating');
            }, 350);
        });
    }
    
    // Active page highlighting
    const currentLocation = location.pathname;
    const menuItems = document.querySelectorAll('.navbar-nav .nav-link');
    
    menuItems.forEach(item => {
        if (item.getAttribute('href') === currentLocation) {
            item.classList.add('active');
        }
    });
    
    // User avatar initial
    const userDropdown = document.querySelector('.navbar-nav .dropdown-toggle');
    if (userDropdown) {
        const userName = userDropdown.textContent.trim();
        const initials = userName.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
        
        // Create avatar element if it doesn't exist
        if (!userDropdown.querySelector('.navbar-user-avatar')) {
            const avatar = document.createElement('span');
            avatar.className = 'navbar-user-avatar';
            avatar.textContent = initials;
            userDropdown.insertBefore(avatar, userDropdown.firstChild);
        }
    }
    
    // REMOVED: Loading indicator functionality
    // The navbar loading animation has been disabled as requested
    
    // Notification badge animation
    const badges = document.querySelectorAll('.navbar .badge');
    badges.forEach(badge => {
        // Add pulse animation on new notification
        badge.addEventListener('animationend', function() {
            setTimeout(() => {
                this.style.animation = 'pulse 2s infinite';
            }, 5000);
        });
    });
});

// Add CSS for ripple effect
const style = document.createElement('style');
style.textContent = `
    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 193, 7, 0.5);
        transform: scale(0);
        animation: ripple-animation 0.6s ease-out;
        pointer-events: none;
    }
    
    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
    
    .navbar-nav .nav-link {
        position: relative;
        overflow: hidden;
    }
    
    .navbar-collapse.animating {
        animation: slideIn 0.35s ease-out;
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .navbar {
        transition: transform 0.3s ease-in-out;
    }
`;
document.head.appendChild(style);
