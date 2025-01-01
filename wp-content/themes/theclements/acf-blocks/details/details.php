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

$SOCIALS_CONFIG = get_field('socials', 'option');

?>

<div class="guten-block river-lofts" id="river-lofts-<?php echo sanitize_title($title); ?>">
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
        isset($title) || !empty($specs) || isset($description) || !empty($action_buttons)
    ): ?>
        <div class="property-details">
            <?php if (isset($title)): ?>
                <h1 class="property-title"><?php echo htmlspecialchars($title); ?></h1>
            <?php endif; ?>

            <?php if (!empty($specs)): ?>
                <div class="property-specs">
                    <?php foreach ($specs as $spec): ?>
                        <span class="spec">
                            <img src="<?php echo htmlspecialchars($spec['icon']['url']); ?>"
                                alt="<?php echo htmlspecialchars($spec['icon']['alt']); ?>" />
                            <?php echo htmlspecialchars($spec['content']); ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (isset($description)): ?>
                <p class="property-description">
                    <?php echo htmlspecialchars($description); ?>
                </p>
            <?php endif; ?>


            <style>
                .details-links {
                    justify-content: center;
                    margin-top: 0px;
                }
            </style>
            <div class="footer-social details-links">
                <?php foreach ($SOCIALS_CONFIG as $social): ?>
                    <a href="<?php echo $social['link']['url']; ?>">
                        <img src="<?php echo $social['icon']['url']; ?>" alt="<?php echo $social['icon']['alt']; ?>">
                    </a>
                <?php endforeach; ?>
            </div>

            <!-- <?php if (!empty($action_buttons)): ?>
                    <div class="property-actions">
                        <?php foreach ($action_buttons as $button): ?>
                            <button class="action-button btn" data-action="<?php echo htmlspecialchars($action); ?>">
                                <?php echo htmlspecialchars($text); ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?> -->
        </div>
    <?php endif; ?>

    <?php if (isset($rich_content)): ?>
        <div class="rich-content">
            <?php echo $rich_content; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($sections)): ?>
        <div class="property-sections">
            <?php foreach ($sections as $section): ?>
                <div class="section">
                    <button class="section-toggle btn" aria-expanded="false">
                        <span><?php echo htmlspecialchars($section['title']); ?></span>
                        <span class="toggle-icon"></span>
                    </button>
                    <div class="section-content">
                        <?php if (!empty($section['description'])): ?>
                            <p><?php echo htmlspecialchars($section['description']); ?></p>
                        <?php endif; ?>

                        <?php if (!empty($section['bullets'])): ?>
                            <div class="bullet-grid">
                                <?php foreach ($section['bullets'] as $bullet): ?>
                                    <div class="bullet-item">
                                        <?php echo htmlspecialchars($bullet['bullet']); ?>
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
                                                data-action="">
                                                <?php echo htmlspecialchars($action['link']['title']); ?>
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

    <?php if (isset($config['related_properties']) && !empty($config['related_properties']['items'])): ?>
        <div class="related-properties">
            <?php if (isset($config['related_properties']['title'])): ?>
                <h4><?php echo htmlspecialchars($config['related_properties']['title']); ?></h4>
            <?php endif; ?>
            <div class="property-carousel">
                <div class="carousel-container">
                    <?php foreach ($config['related_properties']['items'] as $index => $property): ?>
                        <div class="carousel-slide <?php echo $index === 1 ? 'active' : ''; ?>">
                            <img src="<?php echo htmlspecialchars($property['image']); ?>"
                                alt="<?php echo htmlspecialchars($property['title']); ?>" />
                            <h4 class="feature-font"><?php echo htmlspecialchars($property['title']); ?></h4>
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