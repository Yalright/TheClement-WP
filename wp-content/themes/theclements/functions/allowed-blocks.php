<?php
add_filter('allowed_block_types_all', 'rt_allowed_block_types', 25, 2);

function rt_allowed_block_types($allowed_blocks, $editor_context)
{
  if (in_array($editor_context->post->post_type, ["page"])) {
    $allowed_blocks = array(
      'acf/hero-banner',
      'acf/section-title',
      'acf/text-media',
      'acf/wysiwyg',
      'acf/code',
      'acf/anchor-links',
      'acf/business-grid',
      'acf/accordion',
      'acf/feature-grid',
      'acf/location-list',
      'acf/business-contact-wizard',
      'acf/latest-news'
    );
  } else if ($editor_context->post->post_type == 'post') {
    $allowed_blocks = array(
      'acf/section-title',
      'acf/text-media',
      'acf/wysiwyg',
      'acf/code',
      'acf/anchor-links',
      'acf/accordion',
      'acf/feature-grid',
    );
  }
  return $allowed_blocks;
}
