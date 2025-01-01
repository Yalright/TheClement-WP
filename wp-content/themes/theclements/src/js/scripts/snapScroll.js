jQuery(document).ready(function($) {
    // Configuration
    const USE_PERCENTAGE_BUFFER = true;
    const SCROLL_BUFFER_PX = 200;
    const SCROLL_BUFFER_PERCENT = 0.25;
    const SNAP_DELAY = 300;
    const SNAP_SPEED = 500;
    const DEBOUNCE_DELAY = 150; // Delay for debouncing scroll events
    
    let isScrolling = false;
    let sections = [];
    let lastScrollTime = Date.now();
    let userIsScrolling = false;
    let snapTimeout = null;
    
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
            
            if (distance < currentBuffer && distance < nearestDistance) {
                nearest = section;
                nearestDistance = distance;
            }
        });

        return nearest;
    }

    // Smooth scroll to target
    function scrollToSection(section) {
        if (isScrolling || userIsScrolling) return;
        
        isScrolling = true;
        $('html, body').animate({
            scrollTop: section.top
        }, {
            duration: SNAP_SPEED,
            easing: 'easeInOutCubic',
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

    // Handle scroll events with debouncing
    let scrollTimeout;
    $(window).on('scroll', function() {
        // Clear any existing snap timeout
        if (snapTimeout) {
            clearTimeout(snapTimeout);
        }

        // Indicate that user is actively scrolling
        userIsScrolling = true;
        lastScrollTime = Date.now();

        // Clear existing scroll timeout
        if (scrollTimeout) {
            clearTimeout(scrollTimeout);
        }

        // Set new scroll timeout
        scrollTimeout = setTimeout(function() {
            userIsScrolling = false;

            // Only attempt to snap if user has stopped scrolling
            snapTimeout = setTimeout(function() {
                if (!userIsScrolling && !isScrolling) {
                    const scrollPosition = $(window).scrollTop();
                    const nearestSection = getNearestSection(scrollPosition);
                    
                    if (nearestSection !== null) {
                        scrollToSection(nearestSection);
                    }
                }
            }, SNAP_DELAY);
        }, DEBOUNCE_DELAY);
    });

    // Stop any ongoing snap if user starts scrolling
    $(window).on('wheel touchstart mousewheel DOMMouseScroll', function() {
        if (isScrolling) {
            $('html, body').stop();
            isScrolling = false;
        }
        userIsScrolling = true;
        lastScrollTime = Date.now();
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
