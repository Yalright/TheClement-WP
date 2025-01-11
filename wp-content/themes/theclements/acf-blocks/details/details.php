<?php

/***
 * Block - Details
 ***/


$style_classes = include get_stylesheet_directory() . '/acf-blocks/block-settings/block-settings.php';
$block_name     = "details";

array_unshift($style_classes, $block_name);
$style_classes[] = $block_name;
$classes = implode(' ', $style_classes);

$title          = get_field('title');
$description    = get_field('description');
$rich_content   = get_field('rich_content');
$gallery_images = get_field('gallery_images');
$action_buttons = get_field('action_buttons');
$specs          = get_field('specs');
$sections       = get_field('sections');
$related_properties = get_field('related_properties');

$SOCIALS_CONFIG = get_field('socials', 'option');

?>

<div class="guten-block block-details river-lofts" id="river-lofts-<?php echo sanitize_title($title); ?>">
    <?php if (!empty($gallery_images)): ?>
        <div class="main-gallery">
            <div class="gallery-container slick-slider">
                <!-- Slick Slider Container -->
                <?php foreach ($gallery_images as $image):
                    $desktop_image = $image['desktop'];
                    $mobile_image = $image['mobile']; ?>
                    <div class="gallery-slide">
                        <picture>
                            <!-- Mobile Image -->
                            <source srcset="<?php echo esc_url($mobile_image['url']); ?>" media="(max-width: 768px)">
                            <!-- Desktop Image -->
                            <img src="<?php echo esc_url($desktop_image['url']); ?>" alt="Gallery Image">
                        </picture>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>


    <?php if (
        !empty($title) || !empty($specs) || !empty($description) || !empty($action_buttons)
    ): ?>
        <div class="property-details">
            <?php if (!empty($title)): ?>
                <h1 class="property-title"><?php echo $title; ?></h1>
            <?php endif; ?>

            <?php if (!empty($specs)): ?>
                <div class="property-specs">
                    <?php foreach ($specs as $spec): ?>
                        <span class="spec">
                            <?php
                            $file_extension = pathinfo($spec['icon']['url'], PATHINFO_EXTENSION);
                            if ($file_extension === 'svg' && !is_admin()) {
                                $response = wp_remote_get($spec['icon']['url']);
                                if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
                                    echo wp_remote_retrieve_body($response);
                                } else {
                                    // Fallback to img tag if request fails
                                    echo '<img src="' . $spec['icon']['url'] . '" alt="' . $spec['icon']['alt'] . '" />';
                                }
                            } else {
                            ?>
                                <img src="<?php echo $spec['icon']['url']; ?>"
                                alt="<?php echo $spec['icon']['alt']; ?>" />
                            <?php
                            }
                            ?>
                            
                            <?php echo $spec['content']; ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($description)): ?>
                <p class="property-description">
                    <?php echo $description; ?>
                </p>
            <?php endif; ?>


            <style>
                .details-links {
                    justify-content: center;
                    margin-top: 0px;
                }
            </style>
            <?php if (!empty($SOCIALS_CONFIG)): ?>
                <div class="footer-social details-links">
                    <?php foreach ($SOCIALS_CONFIG as $social): ?>
                        <a href="<?php echo $social['link']['url']; ?>">
                            <img src="<?php echo $social['icon']['url']; ?>" alt="<?php echo $social['icon']['alt']; ?>">
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- <?php if (!empty($action_buttons)): ?>
                    <div class="property-actions">
                        <?php foreach ($action_buttons as $button): ?>
                            <button class="action-button btn" data-action="<?php echo $action; ?>">
                                <?php echo $text; ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?> -->
        </div>
    <?php endif; ?>

    <?php if (!empty($rich_content)): ?>
        <div class="rich-content">
            <?php echo $rich_content; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($sections)): ?>
        <div class="property-sections">
            <?php foreach ($sections as $section): ?>
                <div class="section">
                    <button class="section-toggle btn" aria-expanded="false">
                        <span><?php echo $section['title']; ?></span>
                        <span class="toggle-icon"></span>
                    </button>
                    <div class="section-content">
                        <?php if (!empty($section['description'])): ?>
                            <p><?php echo $section['description']; ?></p>
                        <?php endif; ?>

                        <?php if (!empty($section['bullets'])): ?>
                            <div class="bullet-grid">
                                <?php foreach ($section['bullets'] as $bullet): ?>
                                    <div class="bullet-item">
                                        <?php echo $bullet['bullet']; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($section['floor_plan']['image'])): ?>
                            <div class="floor-plan">
                                <img src="<?php echo $section['floor_plan']['image']['url']; ?>" alt="Floor Plan" />
                                <?php if (!empty($section['floor_plan']['actions'])): ?>
                                    <div class="floor-plan-actions">
                                        <?php foreach ($section['floor_plan']['actions'] as $action): ?>
                                            <button class="plan-action btn"
                                                data-action="<?php echo $action['link']['url']; ?>">
                                                <?php echo $action['link']['title']; ?>
                                            </button>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($related_properties['title']) && !empty($related_properties['items'])): ?>
        <div class="related-properties">
            <?php if (!empty($related_properties['title'])): ?>
                <h4><?php echo $related_properties['title']; ?></h4>
            <?php endif; ?>
            <div class="property-carousel">
                <div class="carousel-container">
                    <?php foreach ($related_properties['items'] as $index => $property):
                        $image = $property['image'];
                        $title = $property['title'];
                        $link = $property['link'];
                    ?>
                        <div class="carousel-slide <?php echo $index === 1 ? 'active' : ''; ?>">
                            <?php if (!empty($image)): ?>
                                <img src="<?php echo esc_url($image['url']); ?>"
                                    alt="<?php echo esc_attr($title); ?>" />
                            <?php endif; ?>
                            <?php if (!empty($title)): ?>
                                <h4 class="feature-font"><?php echo esc_html($title); ?></h4>
                            <?php endif; ?>
                            <?php if (!empty($link)): ?>
                                <a href="<?php echo esc_url($link['url']); ?>" class="link"><?php echo esc_html($link['title']); ?></a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    class RiverLoftsAccordion {
        constructor(containerId) {
            this.container = document.getElementById(containerId);
            if (!this.container) return;

            this.sections = this.container.querySelectorAll('.section');
            this.init();
        }

        init() {
            this.sections.forEach(section => {
                const toggle = section.querySelector('.section-toggle');
                const content = section.querySelector('.section-content');

                if (toggle && content) {
                    toggle.addEventListener('click', () => {
                        const isExpanded = toggle.getAttribute('aria-expanded') === 'true';
                        this.toggleSection(toggle, content, !isExpanded);
                    });

                    content.style.maxHeight = '0px';
                    content.style.overflow = 'hidden';
                    content.style.transition = 'max-height 0.3s ease-out';
                }
            });
        }

        toggleSection(toggle, content, expand) {
            toggle.setAttribute('aria-expanded', expand);
            content.style.maxHeight = expand ? `${content.scrollHeight}px` : '0px';
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Initialize gallery
        document.querySelectorAll('.river-lofts').forEach(loft => {
            // new RiverLoftsGallery(loft.id);
            new RiverLoftsAccordion(loft.id);
        });

        // Initialize carousel
        // initCarousel();
    });
</script>