<?php

/***
 * Block - Slider
 ***/


$style_classes = include get_stylesheet_directory() . '/acf-blocks/block-settings/block-settings.php';
$block_name     = "slider";

array_unshift($style_classes, $block_name);
$style_classes[] = $block_name;
$classes = implode(' ', $style_classes);

$video_cover_image = get_field('video_cover_image');
$video_file = get_field('video_file');
$footer_text = get_field('footer_text');
$footer_links = get_field('footer_links');
?>

<div class="guten-block block-video full-section clement-module">
    <div class="video-container">
        <?php if ($video_file): ?>
            <div class="video-wrapper">
                <video id="background-video" playsinline muted loop>
                    <source src="<?php echo esc_url($video_file); ?>" type="video/mp4">
                </video>
            </div>

            <?php if ($video_cover_image): ?>
                <div id="video-cover">
                    <img src="<?php echo $video_cover_image['url']; ?>" alt="<?php echo $video_cover_image['alt']; ?>">
                </div>
            <?php endif; ?>

            <script>
                (function($) {
                    var video = document.getElementById('background-video');
                    var cover = document.getElementById('video-cover');

                    video.addEventListener('loadeddata', function() {
                        if (video.readyState >= 1) {
                            if (cover) {
                                cover.style.opacity = '0';
                                setTimeout(function() {
                                    cover.remove();
                                }, 500);
                            }
                            video.play();
                        }
                    });
                })(jQuery);
            </script>

            <style>
                #video-cover {
                    transition: opacity 0.5s ease;
                }
            </style>
        <?php endif; ?>
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

<style>
    .video-container {
        background-image: url('<?php echo $video_cover_image['url']; ?>');
        background-size: cover;
        background-position: center;
    }
</style>