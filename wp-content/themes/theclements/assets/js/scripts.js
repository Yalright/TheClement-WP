
jQuery(document).ready(function($) {
    $('.gallery-container').not('.slick-initialized').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: true,
        arrows: false,
        fade: true,
        autoplay: true,
        autoplaySpeed: 3000,
        infinite: true,
        adaptiveHeight: false,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    arrows: false,
                    dots: true
                }
            }
        ]
    });
});

jQuery(document).ready(function($) {
    $('.livingstone-slideshow').not('.slick-initialized').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: true,
        arrows: false,
        fade: true,
        autoplay: true,
        autoplaySpeed: 3000,
        infinite: true,
        adaptiveHeight: false,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    arrows: false,
                    dots: true
                }
            }
        ]
    });
});