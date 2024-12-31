<?php
// Add ACF options page
if (function_exists('acf_add_options_page')) {
  acf_add_options_page(array(
    'page_title'   => __('Theme Settings', 'your-text-domain'),
    'menu_title'   => __('Theme Settings', 'your-text-domain'),
    'menu_slug'    => 'theme-settings',
    'capability'   => 'edit_posts',
    'redirect'     => false,
  ));
}


add_action('acf/init', 'my_acf_init');
function my_acf_init()
{
  // Check if function exists
  if (function_exists('acf_register_block_type')) {

    // Hero Component
    // acf_register_block_type(array(
    //   'name'            => 'hero-component',
    //   'title'           => __('Hero Component', 'your-text-domain'),
    //   'description'     => __('Displays a hero component with various styles.', 'your-text-domain'),
    //   'render_callback' => 'my_acf_block_render_callback',
    //   'category'        => 'custom-blocks',
    //   'icon'            => 'cover-image',
    //   'keywords'        => array('hero', 'banner'),

    //   // Enable preview by default, switch to edit mode on selection
    //   'mode'            => 'preview',
    //   'supports'        => array(
    //     'mode'       => true,   // Allow edit/preview switching
    //     'html'       => false,  // Prevent HTML editing
    //     'align'      => true,   // Optional: alignment support
    //   ),
    // ));




    
  }
}

function custom_gutenberg_category($categories, $post)
{
  return array_merge(
    $categories,
    array(
      array(
        'slug'  => 'custom-blocks',
        'title' => __('Custom Blocks', 'custom-blocks'),
      ),
    )
  );
}
add_filter('block_categories_all', 'custom_gutenberg_category', 10, 2);

function my_acf_block_render_callback($block)
{

  // Convert name ("acf/testimonial") into path-friendly slug ("testimonial")
  $slug = str_replace('acf/', '', $block['name']);

  // Include a template part from within the "acf-blocks" folder
  if (file_exists(get_theme_file_path("/acf-blocks/content-{$slug}.php"))) {
    include(get_theme_file_path("/acf-blocks/content-{$slug}.php"));
  }
}
