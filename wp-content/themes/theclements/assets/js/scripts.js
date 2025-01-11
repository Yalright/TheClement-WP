
function adjustSlideshowHeights() {
    // Select all slideshow container elements
    const slideshowContainers = document.querySelectorAll('.slideshow-container, .livingstone-slideshow, .video-container');

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
        
        // Add mousewheel support
        addMousewheelSupport($carousel);
    }
});
jQuery(document).ready(function($) {
    // Only initialize if snapScroll-enabled class is present
    if ($('.main-content').hasClass('snapScroll-enabled')) {
        // Add auto-height class to all sections and footer
        $('.full-section, .site-footer').addClass('fp-auto-height');
        $('.site-footer, .site-footer *').removeClass('fp-overflow');
        
        // Remove fp-overflow from footer children
        function removeFooterOverflow() {
            $('.site-footer').find('.fp-overflow').removeClass('fp-overflow');
        }
        
        // Initialize fullPage.js
        $('.main-content').fullpage({
            // License
            licenseKey: 'N171H-04IZ8-PBIJ8-PSI48-QMXNN',
            credits: false,
            
            // Scrolling
            scrollingSpeed: 250,
            autoScrolling: true,
            fitToSection: false,
            scrollBar: true,
            bigSectionsDestination: 'top',
            continuousVertical: false,
            
            // Disable all horizontal sliding
            scrollHorizontally: false,
            allowSlideMovements: false,
            
            // Selector - include both full-sections and footer
            sectionSelector: '.full-section, .site-footer',
            slideSelector: false,
            
            // Design
            paddingTop: 'var(--header-height)',
            fixedElements: 'header.header',
            
            // Accessibility
            keyboardScrolling: true,
            animateAnchor: true,
            recordHistory: true,
            normalScrollElements: '.block-details, .block-details + .site-footer',
            
            // Events
            onLeave: function(origin, destination, direction) {
                // Ensure header stays sticky
                $('header.header').css('position', 'fixed');
                removeFooterOverflow();
            },
            afterLoad: function(origin, destination, direction) {
                // Ensure header stays sticky
                $('header.header').css('position', 'fixed');
                
                // Remove any fp-slides classes
                $('.fp-slides, .fp-slidesContainer').remove();
                removeFooterOverflow();
            },
            afterRender: function() {
                // Ensure header stays sticky on initial load
                $('header.header').css('position', 'fixed');
                
                // Remove any fp-slides classes
                $('.fp-slides, .fp-slidesContainer').remove();
                removeFooterOverflow();
            }
        });
        
        // Remove any fp-slides classes and check footer overflow that might get added
        setInterval(function() {
            $('.fp-slides, .fp-slidesContainer').remove();
            removeFooterOverflow();
        }, 100);
    }
});
