<?php
add_filter('allowed_block_types_all', 'rt_allowed_block_types', 25, 2);

function rt_allowed_block_types($allowed_blocks, $editor_context)
{
  if (in_array($editor_context->post->post_type, ["page", "post"])) {
    $allowed_blocks = array(
      'acf/hero-banner',
      'acf/block-settings',
      'acf/details',
      'acf/listing',
      'acf/slider',
      'acf/video'
    );
  }
  return $allowed_blocks;
}
