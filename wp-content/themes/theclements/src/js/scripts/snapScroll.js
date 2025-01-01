jQuery(document).ready(function($) {
    // Configuration
    const USE_PERCENTAGE_BUFFER = true; // Switch between percentage and pixel buffer
    const SCROLL_BUFFER_PX = 200; // Buffer in pixels
    const SCROLL_BUFFER_PERCENT = 0.25; // Buffer as percentage of viewport height (15%)
    const SNAP_DELAY = 300; // Delay in milliseconds before snapping
    const SNAP_SPEED = 500; // Animation speed in milliseconds
    let isScrolling = false;
    let sections = [];
    let lastScrollTime = Date.now();
    
    // Get header height from CSS variable
    const headerHeight = parseInt(getComputedStyle(document.documentElement)
        .getPropertyValue('--header-height')) || 0;
    
    // Calculate buffer based on setting
    function getBuffer() {
        if (USE_PERCENTAGE_BUFFER) {
            return $(window).height() * SCROLL_BUFFER_PERCENT;
        }
        return SCROLL_BUFFER_PX;
    }
    
    // Get all sections and their positions
    function updateSections() {
        sections = $('.guten-block').map(function() {
            return {
                element: $(this),
                top: $(this).offset().top - headerHeight,
                height: $(this).outerHeight()
            };
        }).get();
    }

    // Find the nearest section based on scroll position
    function getNearestSection(scrollPosition) {
        let nearest = null;
        let nearestDistance = Infinity;
        const currentBuffer = getBuffer();

        sections.forEach(section => {
            const distance = Math.abs(scrollPosition - section.top);
            
            // Only consider sections within the buffer zone
            if (distance < currentBuffer && distance < nearestDistance) {
                nearest = section;
                nearestDistance = distance;
            }
        });

        return nearest;
    }

    // Smooth scroll to target
    function scrollToSection(section) {
        if (isScrolling) return;
        
        isScrolling = true;
        $('html, body').animate({
            scrollTop: section.top
        }, {
            duration: SNAP_SPEED,
            easing: 'easeInOutCubic', // Smooth easing
            complete: function() {
                isScrolling = false;
            }
        });
    }

    // Add jQuery easing if it doesn't exist
    if (typeof $.easing.easeInOutCubic === 'undefined') {
        $.easing.easeInOutCubic = function(x) {
            return x < 0.5 ?
                4 * x * x * x :
                1 - Math.pow(-2 * x + 2, 3) / 2;
        };
    }

    // Debounce scroll handler
    let scrollTimeout;
    $(window).on('scroll', function() {
        if (isScrolling) return;
        
        // Update last scroll time
        lastScrollTime = Date.now();
        
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(function() {
            // Check if enough time has passed since last scroll
            if (Date.now() - lastScrollTime >= SNAP_DELAY) {
                const scrollPosition = $(window).scrollTop();
                const nearestSection = getNearestSection(scrollPosition);
                
                // Only snap if we found a section within the buffer
                if (nearestSection !== null) {
                    scrollToSection(nearestSection);
                }
            }
        }, SNAP_DELAY);
    });

    // Update sections on resize
    let resizeTimeout;
    $(window).on('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(updateSections, 250);
    });

    // Initial setup
    updateSections();
});
