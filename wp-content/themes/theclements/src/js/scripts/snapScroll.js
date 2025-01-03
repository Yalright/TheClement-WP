jQuery(document).ready(function($) {
    // Configuration
    const CONFIG = {
        sectionSelector: '.guten-block:not(.block-details)',
        headerSelector: 'header.header',
        footerSelector: 'footer.site-footer',
        headerOffset: parseInt(getComputedStyle(document.documentElement)
            .getPropertyValue('--header-height')) || 0,
        animationSpeed: 250,
        easing: 'easeOutExpo',
        debounceDelay: 50,
        wheelThreshold: 1,
        activeClass: 'section-active'
    };

    let state = {
        sections: [],
        headerSection: null,
        footerSection: null,
        currentIndex: 0,
        isAnimating: false,
        isInHeader: false,
        isInFooter: false
    };

    // Initialize sections data
    function initSections() {
        // Get header data
        const $header = $(CONFIG.headerSelector);
        if ($header.length) {
            state.headerSection = {
                element: $header,
                top: 0,
                height: $header.outerHeight(),
                isHeader: true
            };
        }

        // Get main sections
        state.sections = $(CONFIG.sectionSelector).map(function(index) {
            const $element = $(this);
            return {
                element: $element,
                top: $element.offset().top - CONFIG.headerOffset,
                height: $element.outerHeight(),
                index: index
            };
        }).get();

        // Get footer data
        const $footer = $(CONFIG.footerSelector);
        if ($footer.length) {
            state.footerSection = {
                element: $footer,
                top: $footer.offset().top - CONFIG.headerOffset,
                height: $footer.outerHeight(),
                isFooter: true
            };
        }
        
        updateActiveSection();
    }

    // Update active section based on scroll position
    function updateActiveSection() {
        const currentScroll = $(window).scrollTop();
        const windowHeight = $(window).height();
        const windowCenter = currentScroll + (windowHeight / 2);
        const footerTriggerPoint = currentScroll + (windowHeight * 0.9);

        // Remove active class from all elements
        state.sections.forEach(section => section.element.removeClass(CONFIG.activeClass));
        if (state.headerSection) state.headerSection.element.removeClass(CONFIG.activeClass);
        if (state.footerSection) state.footerSection.element.removeClass(CONFIG.activeClass);

        // Check if we're in header
        if (state.headerSection && windowCenter < state.sections[0].top) {
            state.headerSection.element.addClass(CONFIG.activeClass);
            state.isInHeader = true;
            state.isInFooter = false;
            return;
        }

        // Check if footer is 20% in viewport
        if (state.footerSection && footerTriggerPoint >= state.footerSection.top) {
            state.footerSection.element.addClass(CONFIG.activeClass);
            state.isInHeader = false;
            state.isInFooter = true;
            return;
        }

        // Find active main section
        const activeSection = state.sections.find(section => {
            const sectionTop = section.top;
            const sectionBottom = section.top + section.height;
            return windowCenter >= sectionTop && windowCenter < sectionBottom;
        });

        if (activeSection) {
            activeSection.element.addClass(CONFIG.activeClass);
            state.currentIndex = activeSection.index;
            state.isInHeader = false;
            state.isInFooter = false;
        }
    }

    // Get next/prev section based on direction
    function getTargetSection(direction) {
        if (state.sections.length === 0) return null;

        // If in footer and scrolling up, get last main section
        if (state.isInFooter && direction === 'prev') {
            return state.sections[state.sections.length - 1];
        }

        // If in header and scrolling down, get first main section
        if (state.isInHeader && direction === 'next') {
            return state.sections[0];
        }

        const targetIndex = direction === 'next' 
            ? state.currentIndex + 1 
            : state.currentIndex - 1;

        return state.sections[targetIndex] || null;
    }

    // Check if we're at the last section
    function checkLastSection() {
        if (state.sections.length === 0) return false;
        const lastSection = state.sections[state.sections.length - 1];
        return lastSection.element.hasClass(CONFIG.activeClass);
    }

    // Smooth scroll to target
    function scrollToSection(section) {
        if (state.isAnimating) return;
        
        state.isAnimating = true;
        
        $('html, body').animate({
            scrollTop: section.top
        }, {
            duration: CONFIG.animationSpeed,
            easing: CONFIG.easing,
            complete: () => {
                state.isAnimating = false;
                updateActiveSection();
            },
            step: () => {
                // Update active section during animation
                updateActiveSection();
            }
        });
    }

    // Add custom easing if not exists
    if (typeof $.easing.easeOutExpo === 'undefined') {
        $.easing.easeOutExpo = function(x) {
            return x === 1 ? 1 : 1 - Math.pow(2, -10 * x);
        };
    }

    // Wheel event handler with debounce
    let wheelTimeout;
    $(window).on('wheel', function(event) {
        // Clear existing timeout
        if (wheelTimeout) {
            clearTimeout(wheelTimeout);
        }

        wheelTimeout = setTimeout(() => {
            const delta = event.originalEvent.deltaY;
            const direction = delta > 0 ? 'next' : 'prev';
            
            // Allow normal scroll if at last section and scrolling down
            if (direction === 'next' && checkLastSection()) {
                return;
            }

            // Only process if wheel movement is significant
            if (Math.abs(delta) > CONFIG.wheelThreshold && !state.isAnimating) {
                event.preventDefault();
                
                const targetSection = getTargetSection(direction);
                if (targetSection) {
                    scrollToSection(targetSection);
                }
            }
        }, CONFIG.debounceDelay);
    });

    // Handle scroll events for active section updates
    let scrollTimeout;
    $(window).on('scroll', function() {
        if (!state.isAnimating) {
            if (scrollTimeout) {
                clearTimeout(scrollTimeout);
            }
            scrollTimeout = setTimeout(updateActiveSection, 50);
        }
    });

    // Handle resize
    let resizeTimeout;
    $(window).on('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
            initSections();
            updateActiveSection();
        }, 250);
    });

    // Stop any ongoing animation if user tries to scroll
    $(window).on('touchstart mousewheel DOMMouseScroll', function() {
        if (state.isAnimating) {
            $('html, body').stop();
            state.isAnimating = false;
            updateActiveSection();
        }
    });

    // Initial setup
    initSections();
});
