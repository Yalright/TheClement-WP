<?php
$CSS_VARS_FIELDS = get_field('css_vars', 'option'); // Retrieve the string
$ADDITIONAL_CSS = get_field('additional_css', 'option'); // Retrieve the string
if (!empty($CSS_VARS_FIELDS)) {
    // Convert the string to an associative array
    $CSS_VARS = [];

    // Remove whitespace and split by lines
    $lines = explode("\n", trim($CSS_VARS_FIELDS));

    foreach ($lines as $line) {
        // Match key-value pairs using regex
        if (preg_match("/'([^']+)'\\s*=>\\s*'([^']+)'/", $line, $matches)) {
            $key = $matches[1];
            $value = $matches[2];
            $CSS_VARS[$key] = $value;
        }
    }

    // Use the resulting array
    // echo '<pre>';
    // print_r($CSS_VARS);
    // echo '</pre>';
}

$enable_snap_scrolling = get_field('enable_snap_scrolling', get_the_ID());
if (!empty($enable_snap_scrolling)) {
    $snapScrollClass = "snapScroll-enabled";
} else {
    $snapScrollClass = "snapScroll-disabled";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#000000">
    <meta name="description" content="<?php echo get_bloginfo('description'); ?>">
    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon.png">
    <link href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon.png" rel="apple-touch-icon" />
    <link rel="stylesheet" href="https://use.typekit.net/brd3dwf.css">

    <title><?php wp_title(''); ?></title>
    <?php if (!empty(get_field('header_scripts', 'option'))) : ?><?php the_field('header_scripts', 'option'); ?><?php endif; ?>
    <?php wp_head(); ?>

    <?php if (!empty($CSS_VARS_FIELDS) || !empty($ADDITIONAL_CSS)) { ?>
        <style>
            <?php if (!empty($CSS_VARS_FIELDS)) {
                echo ":root {";
                foreach ($CSS_VARS as $key => $value) {
                    echo "--{$key}: {$value};\n";
                }
                echo "}";
            }
            if (!empty($ADDITIONAL_CSS)) {
                echo $ADDITIONAL_CSS;
            } ?>
        </style>
    <?php } ?>
</head>

<body <?php body_class(); ?>>
    <div class="main-content <?php echo $snapScrollClass; ?>">

        <?php

        $SITE_CONFIG = get_field('site_config', 'option');
        $SOCIALS_CONFIG = get_field('socials', 'option');

        ?>

        <header class="header">
            <button class="header__menu-toggle">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
            </button>

            <?php if (!empty($SITE_CONFIG['logo'])): ?>
                <div class="header__brand">
                    <a href="<?php echo site_url(); ?>">
                        <img class="header__brand-logo"
                            src="<?php echo $SITE_CONFIG['logo']['url']; ?>"
                            alt="<?php echo $SITE_CONFIG['logo']['alt']; ?>"
                            <?php if ($SITE_CONFIG['logo']['width']) echo 'width="' . $SITE_CONFIG['logo']['width'] . '"'; ?>
                            <?php if ($SITE_CONFIG['logo']['height']) echo 'height="' . $SITE_CONFIG['logo']['height'] . '"'; ?>>
                    </a>
                </div>
            <?php endif; ?>

            <?php if (!empty($SITE_CONFIG['enable_booking']) && !empty($SITE_CONFIG['booking_link'])): ?>
                <a href="<?php echo $SITE_CONFIG['booking_link']['url']; ?>"
                    class="header__book-button btn"
                    <?php if ($SITE_CONFIG['booking_link']['target']) echo 'target="' . $SITE_CONFIG['booking_link']['target'] . '"'; ?>>
                    <?php echo $SITE_CONFIG['booking_link']['title']; ?>
                </a>
            <?php endif; ?>

            <div class="menu">
                <div class="menu__nav">

                    <?php
                    $menus = get_all_header_nav_menus();
                    if (!empty($menus)) {
                        foreach ($menus as $index => $menu_data) {
                            $site_name = $menu_data['site_name'];
                            $menu_structure = $menu_data['menu_structure'];

                            // Set "active" class for the current site
                            $section_class = ($index === 0) ? 'menu__section active' : 'menu__section';

                            echo '<div class="' . esc_attr($section_class) . '">';
                            echo '<h2 class="menu__section-title" onclick="toggleMenu(this)">' . esc_html($site_name) . '</h2>';
                            echo '<div class="menu__links-wrapper">';
                            echo '<div class="menu__links">';

                            foreach ($menu_structure as $section) {
                                echo '<a href="' . esc_url($section['url']) . '" class="menu__link">' . esc_html($section['title']) . '</a>';
                                if (!empty($section['children'])) {
                                    foreach ($section['children'] as $child) {
                                        echo '<a href="' . esc_url($child['url']) . '" class="menu__link">' . esc_html($child['title']) . '</a>';
                                    }
                                }
                            }

                            echo '</div>'; // End .menu__links
                            echo '</div>'; // End .menu__links-wrapper
                            echo '</div>'; // End .menu__section
                        }
                    }
                    ?>

                </div>


                <div class="menu__footer">
                    <?php if (!empty($SOCIALS_CONFIG)): ?>
                        <div class="menu__footer-social">
                            <?php foreach ($SOCIALS_CONFIG as $social): ?>
                                <a class="menu__footer-link" aria-label="<?php echo $social['icon']['alt']; ?>" href="<?php echo $social['link']['url']; ?>">
                                    <img class="menu__footer-social-icon" src="<?php echo $social['icon']['url']; ?>" alt="<?php echo $social['icon']['alt']; ?>">
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </header>