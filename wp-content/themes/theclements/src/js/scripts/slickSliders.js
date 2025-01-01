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

    // Initialize mobile-only carousel for related properties
    function initMobileCarousel() {
        const $carousel = $('.carousel-container');
        
        if (window.innerWidth <= 768) {
            if (!$carousel.hasClass('slick-initialized')) {
                $carousel.slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: false,
                    arrows: false,
                    fade: false,
                    infinite: false,
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
                                slidesToScroll: 1
                            }
                        }
                    ]
                });
            }
        } else {
            if ($carousel.hasClass('slick-initialized')) {
                $carousel.slick('unslick');
            }
        }
    }

    // Initialize on load
    initMobileCarousel();

    // Re-initialize on resize
    let resizeTimer;
    $(window).on('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            initMobileCarousel();
        }, 250);
    });
});