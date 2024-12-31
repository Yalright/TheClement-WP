<?php
// Get the parent block settings group
$parent_settings = get_field('block_settings');

// Ensure the parent settings are valid and include nested `block_settings`
if (!empty($parent_settings['block_settings']) && is_array($parent_settings['block_settings'])) {
    $block_settings = $parent_settings['block_settings'];
} else {
    $block_settings = [];
}

// Initialize the styles array
$style_classes = [];

// Add background and text color classes to the array
if (!empty($block_settings['background_colour'])) {
    $style_classes[] = esc_attr($block_settings['background_colour']);
}
if (!empty($block_settings['text_colour'])) {
    $style_classes[] = esc_attr($block_settings['text_colour']);
}

// Add desktop padding and margin classes
if (!empty($block_settings['desktop_padding_top'])) {
    $style_classes[] = esc_attr($block_settings['desktop_padding_top']);
}
if (!empty($block_settings['desktop_padding_bottom'])) {
    $style_classes[] = esc_attr($block_settings['desktop_padding_bottom']);
}
if (!empty($block_settings['desktop_margin_top'])) {
    $style_classes[] = esc_attr($block_settings['desktop_margin_top']);
}
if (!empty($block_settings['desktop_margin_bottom'])) {
    $style_classes[] = esc_attr($block_settings['desktop_margin_bottom']);
}

// Add mobile padding and margin classes
if (!empty($block_settings['mobile_padding_top'])) {
    $style_classes[] = esc_attr($block_settings['mobile_padding_top']);
}
if (!empty($block_settings['mobile_padding_bottom'])) {
    $style_classes[] = esc_attr($block_settings['mobile_padding_bottom']);
}
if (!empty($block_settings['mobile_margin_top'])) {
    $style_classes[] = esc_attr($block_settings['mobile_margin_top']);
}
if (!empty($block_settings['mobile_margin_bottom'])) {
    $style_classes[] = esc_attr($block_settings['mobile_margin_bottom']);
}

// Return the array
return $style_classes;
