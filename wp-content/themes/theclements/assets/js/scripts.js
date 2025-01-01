
function adjustSlideshowHeights() {
    // Select all slideshow container elements
    const slideshowContainers = document.querySelectorAll('.slideshow-container, .livingstone-slideshow');

    slideshowContainers.forEach(slideshow => {
        // Find the next sibling with the class 'footer-bar'
        const footerBar = slideshow.nextElementSibling;
        if (footerBar && (footerBar.classList.contains('footer-bar') || footerBar.classList.contains('livingstone-footer'))) {
            // Get the height of the footer-bar
            const footerHeight = footerBar.offsetHeight;

            // Set the max height using calc and the CSS variable --header-height
            slideshow.style.maxHeight = `calc(100vh - ${footerHeight}px - var(--header-height))`;
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
    // Initialize gallery container sliders
    $('.gallery-container').not('.slick-initialized').each(function() {
        const $slider = $(this);
        const slideCount = $slider.children().length;
        
        $slider.slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            dots: slideCount > 1,
            arrows: false,
            fade: true,
            autoplay: slideCount > 1,
            autoplaySpeed: 3000,
            infinite: slideCount > 1,
            adaptiveHeight: false,
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        arrows: false,
                        dots: slideCount > 1
                    }
                }
            ]
        });
    });

    // Initialize Livingstone slideshow
    $('.livingstone-slideshow').not('.slick-initialized').each(function() {
        const $slider = $(this);
        const slideCount = $slider.children().length;
        
        $slider.slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            dots: slideCount > 1,
            arrows: false,
            fade: true,
            autoplay: slideCount > 1,
            autoplaySpeed: 3000,
            infinite: slideCount > 1,
            adaptiveHeight: false,
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        arrows: false,
                        dots: slideCount > 1
                    }
                }
            ]
        });
    });

    // Initialize generic slick sliders
    $('.slick-slider').not('.slick-initialized').each(function() {
        const $slider = $(this);
        const slideCount = $slider.children().length;
        
        $slider.slick({
            dots: slideCount > 1,
            arrows: false,
            autoplay: slideCount > 1,
            autoplaySpeed: 3000,
            fade: true,
            infinite: slideCount > 1,
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        arrows: false,
                        dots: slideCount > 1
                    }
                }
            ]
        });
    });
});
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
