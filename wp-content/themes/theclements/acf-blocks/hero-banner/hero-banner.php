<?php

/***
 * Block - Hero Banner
 ***/


$style_classes = include get_stylesheet_directory() . '/acf-blocks/block-settings/block-settings.php';


$block_name     = "hero-banner";

array_unshift($style_classes, $block_name);
$style_classes[] = $block_name;
$classes = implode(' ', $style_classes);


$style     = get_field("style");
$title     = get_field("title");
$content   = get_field("content");
$cta       = get_field("cta");
if (!empty($cta)) {
    $cta_url        = $cta['url'];
    $cta_title      = $cta['title'];
    $cta_target     = $cta['target'] ? $cta['target'] : '_self';
}
if (!empty(get_field("cta_theme"))) {
    $cta_theme = "cta-button-" . get_field("cta_theme");
} else {
    $cta_theme = "";
}

if ($style == "image" && !empty(get_field("image"))) {
    $image = get_field("image");
    $image_id = $image['id']; // Get the image ID
    $image_url = $image['url']; // Get the image URL
    $alt_text = $image['alt']; // Get the image alt text (always include alt text for accessibility)
    $srcset = wp_get_attachment_image_srcset($image_id); // Generate the srcset attribute
    $sizes = wp_get_attachment_image_sizes($image_id);
}
?>

<style>
    .hero-banner:before {
        background-image: url(<?php echo $image_url; ?>);
    }
</style>

<section class="guten-block <?php echo $classes; ?>">
    <div class="container">
        <div class="content-container">
            <?php if (!empty($title)) { ?>
                <h1><?php echo $title; ?></h1>
            <?php } ?>

            <?php if (!empty($content)) { ?>
                <p><?php echo $content; ?></p>
            <?php } ?>

            <?php if (!empty($cta)) { ?>
                <a class="cta-button <?php echo $cta_theme; ?>" href="<?php echo $cta_url; ?>" target="<?php echo $cta_target; ?>"><?php echo $cta_title; ?></a>
            <?php } ?>
        </div>
        <div class="media-area <?php echo $style; ?>">
            <?php if (!empty($image)) { ?>
                <figure>
                    <img
                        src="<?php echo esc_url($image_url); ?>"
                        srcset="<?php echo esc_attr($srcset); ?>"
                        sizes="<?php echo esc_attr($sizes); ?>"
                        alt="<?php echo esc_attr($alt_text); ?>" />
                </figure>
            <?php } ?>
        </div>
    </div>
</section>