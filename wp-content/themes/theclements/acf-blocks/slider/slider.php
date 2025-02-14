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


<div class="guten-block block-slider full-section clement-module">
    <?php if (!empty($variable_logo) && !empty($variable_logo)): ?>
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
            <p><?php echo !empty($footer_text) ? $footer_text : ''; ?></p>
            <?php if (!empty($footer_links) && !empty($footer_links)): ?>
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
