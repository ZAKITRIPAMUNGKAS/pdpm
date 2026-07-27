/**
 * Icon Fix JavaScript - PDPM Karanganyar
 * Memastikan semua icon Bootstrap ditampilkan dengan benar
 */

document.addEventListener('DOMContentLoaded', function() {
    console.log('Icon Fix: Starting icon verification...');
    
    // Function to check if Bootstrap Icons font is loaded
    function checkBootstrapIcons() {
        const testElement = document.createElement('i');
        testElement.className = 'bi bi-check-circle';
        testElement.style.position = 'absolute';
        testElement.style.left = '-9999px';
        testElement.style.fontSize = '16px';
        document.body.appendChild(testElement);
        
        const computedStyle = window.getComputedStyle(testElement);
        const fontFamily = computedStyle.getPropertyValue('font-family');
        
        document.body.removeChild(testElement);
        
        return fontFamily.includes('bootstrap-icons');
    }
    
    // Function to fix missing icons
    function fixMissingIcons() {
        const iconMap = {
            'bi-person-check': '\uF4DA',
            'bi-trash': '\uF5DE',
            'bi-plus-circle': '\uF4FE',
            'bi-calendar-plus': '\uF4E5',
            'bi-newspaper': '\uF4F5',
            'bi-calendar-event': '\uF4E5',
            'bi-images': '\uF4F0',
            'bi-building': '\uF4D7',
            'bi-people': '\uF4D0',
            'bi-people-fill': '\uF4D1',
            'bi-ui-checks': '\uF5E7',
            'bi-geo-alt': '\uF4E8',
            'bi-person-gear': '\uF4DB',
            'bi-lightning-charge': '\uF4F1',
            'bi-speedometer2': '\uF5A0',
            'bi-crown-fill': '\uF4E0',
            'bi-shield-fill-check': '\uF5A8',
            'bi-person-fill': '\uF4D9'
        };
        
        // Check all icon elements
        const iconElements = document.querySelectorAll('.bi');
        let fixedCount = 0;
        
        iconElements.forEach(function(icon) {
            const classes = icon.className.split(' ');
            const iconClass = classes.find(cls => cls.startsWith('bi-') && cls !== 'bi');
            
            if (iconClass && iconMap[iconClass]) {
                // Check if icon is visible
                const computedStyle = window.getComputedStyle(icon);
                const content = computedStyle.getPropertyValue('content');
                
                if (!content || content === 'none' || content === '""') {
                    // Icon is not displaying, add fallback
                    icon.style.fontFamily = '"bootstrap-icons"';
                    icon.style.display = 'inline-block';
                    icon.style.visibility = 'visible';
                    icon.style.opacity = '1';
                    
                    // Add Unicode fallback
                    if (!icon.textContent) {
                        icon.textContent = iconMap[iconClass];
                    }
                    
                    fixedCount++;
                    console.log('Icon Fix: Fixed icon', iconClass);
                }
            }
        });
        
        if (fixedCount > 0) {
            console.log(`Icon Fix: Fixed ${fixedCount} missing icons`);
        } else {
            console.log('Icon Fix: All icons are displaying correctly');
        }
    }
    
    // Function to add debug mode
    function addDebugMode() {
        // Add debug class to body if URL contains debug=icons
        if (window.location.search.includes('debug=icons')) {
            document.body.classList.add('debug-icons');
            console.log('Icon Fix: Debug mode enabled');
        }
    }
    
    // Function to preload Bootstrap Icons font
    function preloadBootstrapIcons() {
        const fontUrl = 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/fonts/bootstrap-icons.woff2';
        const link = document.createElement('link');
        link.rel = 'preload';
        link.href = fontUrl;
        link.as = 'font';
        link.type = 'font/woff2';
        link.crossOrigin = 'anonymous';
        document.head.appendChild(link);
    }
    
    // Function to add fallback CSS
    function addFallbackCSS() {
        const style = document.createElement('style');
        style.textContent = `
            .bi {
                font-family: "bootstrap-icons", "Font Awesome 5 Free", "Font Awesome 5 Brands", sans-serif !important;
            }
            .bi::before {
                display: inline-block !important;
                font-style: normal !important;
                font-variant: normal !important;
                text-rendering: auto !important;
                -webkit-font-smoothing: antialiased !important;
                -moz-osx-font-smoothing: grayscale !important;
            }
        `;
        document.head.appendChild(style);
    }
    
    // Initialize icon fix
    function init() {
        console.log('Icon Fix: Initializing...');
        
        // Check if Bootstrap Icons are loaded
        const iconsLoaded = checkBootstrapIcons();
        console.log('Icon Fix: Bootstrap Icons loaded:', iconsLoaded);
        
        if (!iconsLoaded) {
            console.log('Icon Fix: Bootstrap Icons not loaded, adding fallback...');
            addFallbackCSS();
            preloadBootstrapIcons();
        }
        
        // Fix missing icons
        setTimeout(fixMissingIcons, 100);
        
        // Add debug mode
        addDebugMode();
        
        // Re-check icons after a delay
        setTimeout(fixMissingIcons, 1000);
        
        console.log('Icon Fix: Initialization complete');
    }
    
    // Run initialization
    init();
    
    // Re-run on window resize (in case of dynamic content)
    window.addEventListener('resize', function() {
        setTimeout(fixMissingIcons, 100);
    });
    
    // Re-run when new content is added
    const observer = new MutationObserver(function(mutations) {
        let shouldCheck = false;
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                mutation.addedNodes.forEach(function(node) {
                    if (node.nodeType === 1 && (node.classList.contains('bi') || node.querySelector('.bi'))) {
                        shouldCheck = true;
                    }
                });
            }
        });
        
        if (shouldCheck) {
            setTimeout(fixMissingIcons, 100);
        }
    });
    
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
});
