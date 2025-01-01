<?php

/***
 * Block - Listing
 ***/


$style_classes = include get_stylesheet_directory() . '/acf-blocks/block-settings/block-settings.php';
$block_name     = "listing";

array_unshift($style_classes, $block_name);
$style_classes[] = $block_name;
$classes = implode(' ', $style_classes);

$variable_name      = get_field('variable_name');
$variable_color     = get_field('variable_color');
$slideshow_images   = get_field('slideshow_images');
$footer_text        = get_field('footer_text');
$footer_links       = get_field('footer_links');
$specs              = get_field('specs');

?>

<div class="guten-block livingstone-module">
    <?php if (!empty($variable_name) && !empty($variable_name)): ?>
        <div class="livingstone-name">
            <h3 style="color:<?php echo $variable_color; ?>"><?php echo $variable_name; ?></h3>
        </div>
    <?php endif; ?>

    <div class="livingstone-slideshow">
        <?php foreach ($slideshow_images as $image):
            $desktop_image = $image['desktop'];
            $mobile_image = $image['mobile'];
        ?>

            <div class="livingstone-slide">
                <picture>
                    <!-- Mobile Image -->
                    <source srcset="<?php echo esc_url($mobile_image['url']); ?>" media="(max-width: 768px)">
                    <!-- Desktop Image -->
                    <img src="<?php echo esc_url($desktop_image['url']); ?>" alt="Gallery Image">
                </picture>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="livingstone-footer">
        <div class="livingstone-foot-content">
            <p><?php echo !empty($footer_text) ? $footer_text : ''; ?></p>
            <?php if (!empty($footer_links) && !empty($footer_links)): ?>
                <div class="livingstone-links">
                    <?php foreach ($footer_links as $link): ?>
                        <a href="<?php echo $link['link']['url']; ?>" class="btn livingstone-link">
                            <?php echo $link['link']['title']; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="livingstone-specs">
            <?php foreach ($specs as $spec): ?>
                <span class="spec">
                    <img src="<?php echo $spec['icon']['url']; ?>" alt="<?php echo $spec['icon']['alt']; ?>">
                    <?php echo $spec['content']; ?>
                </span>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<style>
    .livingstone-slide {
        background-image: none;
        transition: opacity 0.5s ease;
    }

    .lazy {
        opacity: 0;
        transition: opacity 0.3s;
    }

    .lazy.loaded {
        opacity: 1;
    }
</style>

<script>
    jQuery(document).ready(function($) {
        $('.slick-slider').not('.slick-initialized').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            dots: true,
            arrows: false,
            fade: true,
            autoplay: true,
            autoplaySpeed: 3000,
            infinite: true,
            adaptiveHeight: true,
            responsive: [{
                breakpoint: 768,
                settings: {
                    arrows: false,
                    dots: true
                }
            }]
        });
    });

    class ListingModule {
        constructor(element) {
            this.module = element;
            this.slides = this.module.querySelectorAll('.livingstone-slide');
            this.dots = this.module.querySelectorAll('.livingstone-dot');
            this.currentSlide = 0;
            this.autoSlideInterval = null;
            this.isInViewport = false;
            this.observer = null;
            this.isMobile = window.innerWidth < 768;

            this.init();
        }

        init() {
            window.addEventListener('resize', () => {
                const wasMobile = this.isMobile;
                this.isMobile = window.innerWidth < 768;

                if (wasMobile !== this.isMobile) {
                    this.loadSlideImage(this.slides[this.currentSlide]);
                }
            });

            this.setupObserver();
            this.setupLazyLoading();

            this.dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    this.currentSlide = index;
                    this.showSlide(this.currentSlide);
                });
            });

            this.loadSlideImage(this.slides[0]);
        }

        setupObserver() {
            this.observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    this.isInViewport = entry.isIntersecting;
                    if (this.isInViewport) {
                        this.startAutoSlide();
                        this.preloadNextSlides();
                    } else {
                        this.stopAutoSlide();
                    }
                });
            }, {
                threshold: 0.1
            });

            this.observer.observe(this.module);
        }

        setupLazyLoading() {
            const lazyImages = this.module.querySelectorAll('img.lazy');
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.add('loaded');
                        observer.unobserve(img);
                    }
                });
            });

            lazyImages.forEach(img => imageObserver.observe(img));
        }

        loadSlideImage(slide) {
            if (!slide) return;

            const imageUrl = this.isMobile ?
                slide.dataset.backgroundImageMobile :
                slide.dataset.backgroundImageDesktop;

            if (imageUrl && (!slide.style.backgroundImage || this.getCurrentImageUrl(slide) !== imageUrl)) {
                const image = new Image();
                image.onload = () => {
                    slide.style.backgroundImage = `url(${imageUrl})`;
                };
                image.src = imageUrl;
            }
        }

        getCurrentImageUrl(slide) {
            const bgImage = slide.style.backgroundImage;
            return bgImage ? bgImage.replace(/url\(['"]?(.*?)['"]?\)/i, '$1') : '';
        }

        preloadNextSlides() {
            const nextIndexes = [
                (this.currentSlide + 1) % this.slides.length,
                (this.currentSlide + 2) % this.slides.length
            ];

            nextIndexes.forEach(index => {
                this.loadSlideImage(this.slides[index]);
            });
        }

        showSlide(index) {
            this.slides.forEach((slide, i) => {
                slide.classList.remove('active');
                this.dots[i].classList.remove('active');
            });

            this.slides[index].classList.add('active');
            this.dots[index].classList.add('active');

            this.loadSlideImage(this.slides[index]);
            this.preloadNextSlides();
        }

        startAutoSlide() {
            if (this.slides.length <= 1) return;

            if (!this.autoSlideInterval) {
                this.autoSlideInterval = setInterval(() => {
                    if (this.isInViewport) {
                        this.currentSlide = (this.currentSlide + 1) % this.slides.length;
                        this.showSlide(this.currentSlide);
                    }
                }, 5000);
            }
        }

        stopAutoSlide() {
            if (this.autoSlideInterval) {
                clearInterval(this.autoSlideInterval);
                this.autoSlideInterval = null;
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize listing modules
        const livingStoneModules = document.querySelectorAll('.livingstone-module');
        livingStoneModules.forEach(module => new ListingModule(module));

        // Handle scroll behavior
        const mainContent = document.querySelector('.main-content');
        const firstClementModule = document.querySelector('.clement-module');
        const allClementModules = document.querySelectorAll('.clement-module');
        const moduleTop = firstClementModule ? firstClementModule.offsetTop : 0;

        let isInClementSection = false;
        let lastScrollTop = mainContent.scrollTop;
        let scrollBuffer = 0;
        const BUFFER_THRESHOLD = 15;
        const EXIT_ZONE = 300;

        const hasPreContent = Array.from(mainContent.children).some(child =>
            child !== firstClementModule &&
            child.offsetTop < moduleTop &&
            !child.classList.contains('clement-module')
        );

        const setSnapMode = (enable) => {
            if (enable !== isInClementSection) {
                isInClementSection = enable;
                requestAnimationFrame(() => {
                    mainContent.style.scrollSnapType = enable ? 'y proximity' : 'none';
                    allClementModules.forEach(module => {
                        module.style.scrollSnapAlign = enable ? 'start' : 'unset';
                    });
                });
            }
        };

        mainContent.addEventListener('scroll', () => {
            const scrollPosition = mainContent.scrollTop;
            const isScrollingUp = scrollPosition < lastScrollTop;
            const threshold = moduleTop - (window.innerHeight / 2);

            if (isScrollingUp && scrollPosition < threshold + EXIT_ZONE) {
                scrollBuffer += lastScrollTop - scrollPosition;
                if (scrollBuffer > BUFFER_THRESHOLD) {
                    setSnapMode(false);
                    scrollBuffer = 0;
                }
            } else if (scrollPosition >= threshold && !isScrollingUp) {
                setSnapMode(true);
                scrollBuffer = 0;
            } else {
                scrollBuffer = 0;
            }

            lastScrollTop = scrollPosition;
        });

        setSnapMode(!hasPreContent);
    });
</script>