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