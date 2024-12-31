<?php
// CSS Variables
$CSS_VARS = [
    'color-feature' => '#283582',
    'color-background' => '#f0e3db',
    'color-dark' => '#1a1a1a',
    'color-module-footer' => '#edede1',
    'header-height' => '80px',
    'grid-gap' => '1.5rem',
    'transition-timing' => '0.3s ease-in-out',
    'body-font' => '"adobe-caslon-pro", sans-serif',
    'header-font' => '"english-grotesque", serif',
    'font-size-base' => '17px',
    'line-height-base' => '1.6',
    'font-size-h1' => '2.5rem',
    'font-size-h2' => '2.25rem',
    'font-size-h3' => '2rem',
    'font-size-h4' => '1.5rem',
    'line-height-heading' => '1.3',
    'footer-height' => '100px',
    'line-thickness' => '1px',
    'color-border' => '#1a1a1a',
    'details-max-width' => '900px',
    'feature-font' => 'Doves Type',
    'feature-font-weight' => 'bold'
];
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
    <!-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,200;0,300;0,400;0,600;0,700;1,400&family=Roboto:wght@200;300;400;600;700&display=swap" rel="preload" as="style" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,200;0,300;0,400;0,600;0,700;1,400&family=Roboto:wght@200;300;400;600;700&display=swap" rel="stylesheet" crossorigin="anonymous"> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://use.typekit.net/brd3dwf.css">

    <title><?php wp_title(''); ?></title>
    <?php if (!empty(get_field('analytics_code', 'option'))) : ?><?php the_field('analytics_code', 'option'); ?><?php endif; ?>
    <?php if (!empty(get_field('header_scripts', 'option'))) : ?><?php the_field('header_scripts', 'option'); ?><?php endif; ?>
    <?php wp_head(); ?>
    <style>
        :root {
            <?php
            foreach ($CSS_VARS as $key => $value) {
                echo "--{$key}: {$value};\n";
            }
            ?>
        }
    </style>
</head>

<body <?php body_class(); ?>>

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
        <div class="header__brand">
            <a href="<?php echo site_url(); ?>">
                <img class="header__brand-logo"
                    src="<?php echo $SITE_CONFIG['logo']['url']; ?>"
                    alt="<?php echo $SITE_CONFIG['logo']['alt']; ?>"
                    <?php if ($SITE_CONFIG['logo']['width']) echo 'width="' . $SITE_CONFIG['logo']['width'] . '"'; ?>
                    <?php if ($SITE_CONFIG['logo']['height']) echo 'height="' . $SITE_CONFIG['logo']['height'] . '"'; ?>>
            </a>
        </div>

        <?php if ($SITE_CONFIG['enable_booking']): ?>
            <a href="<?php echo $SITE_CONFIG['booking_link']['url']; ?>"
                class="header__book-button btn"
                <?php if ($SITE_CONFIG['booking_link']['target']) echo 'target="' . $SITE_CONFIG['booking_link']['target'] . '"'; ?>>
                <?php echo $SITE_CONFIG['booking_link']['title']; ?>
            </a>
        <?php endif; ?>

        <div class="menu">
            <div class="menu__nav">
                <?php
                // Check if the menu "header-nav" exists
                if (($locations = get_nav_menu_locations()) && isset($locations['header-nav'])) {
                    $menu = wp_get_nav_menu_object($locations['header-nav']); // Get the menu object
                    $menu_items = wp_get_nav_menu_items($menu->term_id); // Get the menu items

                    // Group menu items by parent
                    $menu_structure = [];
                    foreach ($menu_items as $menu_item) {
                        if ($menu_item->menu_item_parent == 0) {
                            // Top-level item
                            $menu_structure[$menu_item->ID] = [
                                'title' => $menu_item->title,
                                'url' => $menu_item->url,
                                'children' => [],
                            ];
                        } else {
                            // Sub-menu item
                            $menu_structure[$menu_item->menu_item_parent]['children'][] = [
                                'title' => $menu_item->title,
                                'url' => $menu_item->url,
                            ];
                        }
                    }

                    // Render the menu structure
                    foreach ($menu_structure as $section_id => $section): ?>
                        <div class="menu__section">
                            <h2 class="menu__section-title" onclick="toggleMenu(this)">
                                <?php echo esc_html($section['title']); ?>
                            </h2>
                            <div class="menu__links-wrapper">
                                <div class="menu__links">
                                    <?php foreach ($section['children'] as $link): ?>
                                        <a href="<?php echo esc_url($link['url']); ?>" class="menu__link">
                                            <?php echo esc_html($link['title']); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                <?php endforeach;
                }
                ?>
            </div>


            <div class="menu__footer">
                <div class="menu__footer-social">
                    <?php foreach ($SOCIALS_CONFIG as $social): ?>
                        <a class="menu__footer-link" aria-label="<?php echo $social['icon']['alt']; ?>" href="<?php echo $social['link']['url']; ?>">
                            <img class="menu__footer-social-icon" src="<?php echo $social['icon']['url']; ?>" alt="<?php echo $social['icon']['alt']; ?>">
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </header>

    <script>
        // Menu elements
        const toggleButton = document.querySelector('.header__menu-toggle');
        const menu = document.querySelector('.menu');

        // Function to close menu
        function closeMenu() {
            menu.classList.remove('menu--active');
            toggleButton.classList.remove('state-x');
            setTimeout(() => toggleButton.classList.remove('state-square'), 300);
        }

        // Handle the main menu toggle
        toggleButton.addEventListener('click', function(e) {
            e.stopPropagation();

            const isMenuActive = menu.classList.contains('menu--active');

            if (isMenuActive) {
                closeMenu();
            } else {
                this.classList.add('state-square');
                setTimeout(() => this.classList.add('state-x'), 300);
                menu.classList.add('menu--active');
            }
        });

        // Prevent clicks inside the menu from closing it
        menu.addEventListener('click', function(e) {
            e.stopPropagation();
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (menu.classList.contains('menu--active')) {
                closeMenu();
            }
        });

        // Close menu on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && menu.classList.contains('menu--active')) {
                closeMenu();
            }
        });

        // Accordion toggle function
        function toggleMenu(element) {
            const allSections = document.querySelectorAll('.menu__section');
            const parentSection = element.parentElement;
            const linksContainer = parentSection.querySelector('.menu__links');
            const links = parentSection.querySelectorAll('.menu__link');

            // Close all other sections
            allSections.forEach(section => {
                if (section !== parentSection) {
                    section.classList.remove('active');
                    section.querySelector('.menu__links').style.maxHeight = null;
                }
            });

            // Toggle current section
            if (parentSection.classList.contains('active')) {
                parentSection.classList.remove('active');
                linksContainer.style.maxHeight = null;
            } else {
                parentSection.classList.add('active');
                linksContainer.style.maxHeight = linksContainer.scrollHeight + 'px';

                // Staggered animations for links
                links.forEach((link, index) => {
                    link.style.setProperty('--fade-delay', `${index * 0.1}s`);
                });
            }
        }

        // Automatically open the first menu section on load
        window.addEventListener('DOMContentLoaded', () => {
            const firstSection = document.querySelector('.menu__section');
            if (firstSection) {
                firstSection.classList.add('active');
                const linksContainer = firstSection.querySelector('.menu__links');
                linksContainer.style.maxHeight = linksContainer.scrollHeight + 'px';
                const links = firstSection.querySelectorAll('.menu__link');

                // Apply staggered animations for links
                links.forEach((link, index) => {
                    link.style.setProperty('--fade-delay', `${index * 0.1}s`);
                });
            }
        });
    </script>