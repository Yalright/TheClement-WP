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

<div class="guten-block block-listing full-section livingstone-module">
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