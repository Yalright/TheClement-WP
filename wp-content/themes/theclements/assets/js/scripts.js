
function adjustSlideshowHeights() {
    // Select all slideshow container elements
    const slideshowContainers = document.querySelectorAll('.slideshow-container, .livingstone-slideshow');

    slideshowContainers.forEach(slideshow => {
        // Find the next sibling with the class 'footer-bar'
        const footerBar = slideshow.nextElementSibling;
        if (footerBar && (footerBar.classList.contains('footer-bar') || footerBar.classList.contains('livingstone-footer'))) {
            // Get the height of the footer-bar
            const footerHeight = parseInt(footerBar.offsetHeight);
            
            // Set the max height using string concatenation
            slideshow.style.maxHeight = 'calc(100vh - ' + footerHeight + 'px - var(--header-height))';
        }
    });
}

// Run the function on initial load
adjustSlideshowHeights();

// Run the function again when the window is resized
window.addEventListener('resize', adjustSlideshowHeights);
 // Menu elements
 const toggleButton = document.querySelector('.header__menu-toggle');
 const menu = document.querySelector('.menu');

 // Function to close menu
 function closeMenu() {
     menu.classList.remove('menu--active');
     toggleButton.classList.remove('state-x');
     setTimeout(() => toggleButton.classList.remove('state-square'), 300);
 }

 // Handle the main menu toggle
 toggleButton.addEventListener('click', function(e) {
     e.stopPropagation();

     const isMenuActive = menu.classList.contains('menu--active');

     if (isMenuActive) {
         closeMenu();
     } else {
         this.classList.add('state-square');
         setTimeout(() => this.classList.add('state-x'), 300);
         menu.classList.add('menu--active');
     }
 });

 // Prevent clicks inside the menu from closing it
 menu.addEventListener('click', function(e) {
     e.stopPropagation();
 });

 // Close menu when clicking outside
 document.addEventListener('click', function(e) {
     if (menu.classList.contains('menu--active')) {
         closeMenu();
     }
 });

 // Close menu on ESC key
 document.addEventListener('keydown', function(e) {
     if (e.key === 'Escape' && menu.classList.contains('menu--active')) {
         closeMenu();
     }
 });

 // Accordion toggle function
 function toggleMenu(element) {
     const allSections = document.querySelectorAll('.menu__section');
     const parentSection = element.parentElement;
     const linksContainer = parentSection.querySelector('.menu__links');
     const links = parentSection.querySelectorAll('.menu__link');

     // Close all other sections
     allSections.forEach(section => {
         if (section !== parentSection) {
             section.classList.remove('active');
             section.querySelector('.menu__links').style.maxHeight = null;
         }
     });

     // Toggle current section
     if (parentSection.classList.contains('active')) {
         parentSection.classList.remove('active');
         linksContainer.style.maxHeight = null;
     } else {
         parentSection.classList.add('active');
         linksContainer.style.maxHeight = linksContainer.scrollHeight + 'px';

         // Staggered animations for links
         links.forEach((link, index) => {
             link.style.setProperty('--fade-delay', `${index * 0.1}s`);
         });
     }
 }

 // Automatically open the first menu section on load
 window.addEventListener('DOMContentLoaded', () => {
     const firstSection = document.querySelector('.menu__section');
     if (firstSection) {
         firstSection.classList.add('active');
         const linksContainer = firstSection.querySelector('.menu__links');
         linksContainer.style.maxHeight = linksContainer.scrollHeight + 'px';
         const links = firstSection.querySelectorAll('.menu__link');

         // Apply staggered animations for links
         links.forEach((link, index) => {
             link.style.setProperty('--fade-delay', `${index * 0.1}s`);
         });
     }
 });
jQuery(document).ready(function($) {
    // Common function to add mousewheel support to a slider
    function addMousewheelSupport($slider) {
        $slider.on('mousewheel', function(e) {
            // Only handle horizontal scrolling
            if (e.deltaX !== 0) {
                e.preventDefault();
                if (e.deltaX > 0) {
                    $(this).slick('slickNext');
                } else {
                    $(this).slick('slickPrev');
                }
            }
        });
    }

    // Initialize gallery container sliders
    $('.gallery-container').not('.slick-initialized').each(function() {
        const $slider = $(this);
        const slideCount = $slider.children().length;
        
        $slider.slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            dots: slideCount > 1,
            arrows: true,
            fade: true,
            autoplay: slideCount > 1,
            autoplaySpeed: 3000,
            infinite: slideCount > 1,
            adaptiveHeight: false,
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        arrows: true,
                        dots: slideCount > 1
                    }
                }
            ]
        });

        // Add mousewheel support
        addMousewheelSupport($slider);
    });

    // Initialize Livingstone slideshow
    $('.livingstone-slideshow').not('.slick-initialized').each(function() {
        const $slider = $(this);
        const slideCount = $slider.children().length;
        
        $slider.slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            dots: slideCount > 1,
            arrows: true,
            fade: true,
            autoplay: slideCount > 1,
            autoplaySpeed: 3000,
            infinite: slideCount > 1,
            adaptiveHeight: false,
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        arrows: true,
                        dots: slideCount > 1
                    }
                }
            ]
        });

        // Add mousewheel support
        addMousewheelSupport($slider);
    });

    // Initialize generic slick sliders
    $('.slick-slider').not('.slick-initialized').each(function() {
        const $slider = $(this);
        const slideCount = $slider.children().length;
        
        $slider.slick({
            dots: slideCount > 1,
            arrows: true,
            autoplay: slideCount > 1,
            autoplaySpeed: 3000,
            fade: true,
            infinite: slideCount > 1,
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        arrows: true,
                        dots: slideCount > 1
                    }
                }
            ]
        });

        // Add mousewheel support
        addMousewheelSupport($slider);
    });

    // Initialize carousel for related properties
    const $carousel = $('.carousel-container');
    if ($carousel.length) {
        $carousel.slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            dots: false,
            arrows: true,
            fade: false,
            infinite: true,
            adaptiveHeight: false,
            centerMode: true,
            variableWidth: false,
            swipeToSlide: true,
            touchThreshold: 10,
            cssEase: 'ease-out',
            speed: 300,
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        centerMode: true
                    }
                }
            ]
        });
    }
});
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
        debounceDelay: 0,
        wheelThreshold: 1,
        activeClass: 'section-active',
        scrollCooldown: 600  // Cooldown period in milliseconds after scroll completion
    };

    let state = {
        sections: [],
        headerSection: null,
        footerSection: null,
        currentIndex: 0,
        isAnimating: false,
        isInHeader: false,
        isInFooter: false,
        isCoolingDown: false
    };

    // Native wheel event handler to block scrolling during cooldown
    document.addEventListener('wheel', function(event) {
        if (state.isCoolingDown) {
            event.preventDefault();
            return false;
        }
    }, { passive: false });

    // Wheel event handler for snap scrolling
    let wheelTimeout;
    $(window).on('wheel', function(event) {
        if (state.isCoolingDown || state.isAnimating) {
            return;
        }

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
            if (Math.abs(delta) > CONFIG.wheelThreshold) {
                const targetSection = getTargetSection(direction);
                if (targetSection) {
                    scrollToSection(targetSection);
                }
            }
        }, CONFIG.debounceDelay);
    });

    // Touch event handler - only prevent when necessary
    const touchHandler = function(event) {
        if (state.isCoolingDown && state.isAnimating) {
            event.preventDefault();
            return false;
        }
    };

    // Add touch event listener with passive: false
    window.addEventListener('touchmove', touchHandler, { passive: false });

    // Clean up function
    function cleanupEvents() {
        window.removeEventListener('wheel', wheelHandler);
        window.removeEventListener('touchmove', touchHandler);
    }

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

        // Store current active section for comparison
        let previousActiveIndex = state.currentIndex;

        // Remove active class from all elements
        state.sections.forEach(section => section.element.removeClass(CONFIG.activeClass));
        if (state.headerSection) state.headerSection.element.removeClass(CONFIG.activeClass);
        if (state.footerSection) state.footerSection.element.removeClass(CONFIG.activeClass);

        // Check if we're in header
        if (state.headerSection && windowCenter < state.sections[0].top) {
            state.headerSection.element.addClass(CONFIG.activeClass);
            state.isInHeader = true;
            state.isInFooter = false;
            if (!state.isInHeader) {
                // Trigger cooldown when entering header
                state.isCoolingDown = true;
                setTimeout(() => {
                    state.isCoolingDown = false;
                }, CONFIG.scrollCooldown);
            }
            return;
        }

        // Check if footer is 20% in viewport
        if (state.footerSection && footerTriggerPoint >= state.footerSection.top) {
            state.footerSection.element.addClass(CONFIG.activeClass);
            state.isInHeader = false;
            state.isInFooter = true;
            if (!state.isInFooter) {
                // Trigger cooldown when entering footer
                state.isCoolingDown = true;
                setTimeout(() => {
                    state.isCoolingDown = false;
                }, CONFIG.scrollCooldown);
            }
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
            
            // If the active section has changed, trigger cooldown
            if (previousActiveIndex !== activeSection.index) {
                state.isCoolingDown = true;
                setTimeout(() => {
                    state.isCoolingDown = false;
                }, CONFIG.scrollCooldown);
            }
            
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
        if (state.isAnimating || state.isCoolingDown) return;
        
        state.isAnimating = true;
        
        $('html, body').animate({
            scrollTop: section.top
        }, {
            duration: CONFIG.animationSpeed,
            easing: CONFIG.easing,
            complete: () => {
                state.isAnimating = false;
                updateActiveSection();
                
                // Start cooldown period
                state.isCoolingDown = true;
                setTimeout(() => {
                    state.isCoolingDown = false;
                }, CONFIG.scrollCooldown);
            },
            step: () => {
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

    // Handle scroll events for active section updates
    let scrollTimeout;
    $(window).on('scroll.snapScroll', function() {
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
        if (state.isAnimating && !state.isCoolingDown) {
            $('html, body').stop();
            state.isAnimating = false;
            updateActiveSection();
        }
    });

    // Initial setup
    initSections();

    // Clean up event handlers when needed
    function cleanupEvents() {
        $(window).off('.snapScroll');
    }
});
