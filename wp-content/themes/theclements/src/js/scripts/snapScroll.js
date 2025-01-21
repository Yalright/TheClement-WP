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
            scrollingSpeed: 500,
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
