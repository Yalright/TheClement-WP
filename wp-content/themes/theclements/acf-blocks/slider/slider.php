<?php

/***
 * Block - Slider
 ***/


$style_classes = include get_stylesheet_directory() . '/acf-blocks/block-settings/block-settings.php';
$block_name     = "slider";

array_unshift($style_classes, $block_name);
$style_classes[] = $block_name;
$classes = implode(' ', $style_classes);

$variable_logo = get_field('variable_logo');
$slideshow_images = get_field('slideshow_images');
$footer_text = get_field('footer_text');
$footer_links = get_field('footer_links');
?>


<div class="guten-block clement-module">
    <?php if (isset($variable_logo) && !empty($variable_logo)): ?>
        <div class="module-logo">
            <img src="<?php echo $variable_logo['url']; ?>"
                data-src="<?php echo $variable_logo['url']; ?>"
                alt="Logo"
                class="lazy">
        </div>
    <?php endif; ?>

    <div class="slideshow-container slick-slider">
        <?php foreach ($slideshow_images as $image):
            $desktop_image = $image['desktop'];
            $mobile_image = $image['mobile'];
        ?>
            <div class="slide">
                <picture>
                    <!-- Mobile Image -->
                    <source media="(max-width: 768px)" srcset="<?php echo esc_url($mobile_image['url']); ?>">
                    <!-- Desktop Image -->
                    <img src="<?php echo esc_url($desktop_image['url']); ?>" alt="<?php echo esc_attr($desktop_image['alt']); ?>">
                </picture>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="footer-bar">
        <div class="slide-foot-content">
            <p><?php echo isset($footer_text) ? $footer_text : ''; ?></p>
            <?php if (isset($footer_links) && !empty($footer_links)): ?>
                <div class="footer-links">
                    <?php foreach ($footer_links as $link): ?>
                        <a href="<?php echo $link['link']['url']; ?>" class="btn footer-link">
                            <?php echo $link['link']['title']; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>



<script>
    jQuery(document).ready(function($) {
        $('.slick-slider').each(function() {
            const $slider = $(this);
            const slideCount = $slider.children().length; // Count the number of slides
            
            $slider.slick({
                dots: slideCount > 1, // Show dots only if more than 1 slide
                arrows: false, // Show arrows for navigation
                autoplay: true, // Autoplay slides
                autoplaySpeed: 3000, // Time in ms between slides
                fade: true,
                responsive: [
                    {
                        breakpoint: 768, // Settings for mobile
                        settings: {
                            arrows: false, // Hide arrows on mobile
                            dots: slideCount > 1 // Keep dots navigation only if more than 1 slide
                        }
                    }
                ]
            });
        });
    });
</script>
