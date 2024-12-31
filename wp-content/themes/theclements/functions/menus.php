<?php
// Register menus
function custom_menus()
{
  register_nav_menus(
    array(
      'header-nav' => __('Header Navigation'),
      'header-nav-footer' => __('Header Navigation Footer'),
      'mobile-nav' => __('Mobile Navigation'),
      'footer-nav-1' => __('Footer Navigation 1'),
      'footer-nav-2' => __('Footer Navigation 2'),
      'footer-nav-3' => __('Footer Navigation 3'),
      'footer-nav-4' => __('Footer Navigation 4'),
    )
  );
}
add_action('init', 'custom_menus');

// Add active class to menu
add_filter('nav_menu_css_class', 'active_nav_class', 10, 2);
function active_nav_class($classes, $item)
{
  $first_uri_part = explode("/", $_SERVER["REQUEST_URI"])[1];
  if (!empty($first_uri_part) && strstr($item->url, $first_uri_part) > -1) {
    $classes[] = 'active';
  }
  return $classes;
}

// // ACF Custom menu
// add_filter('wp_nav_menu_objects', 'my_wp_nav_menu_objects', 10, 2);

// function my_wp_nav_menu_objects($items, $args)
// {

//   // loop
//   foreach ($items as $item) {

//     // vars
//     $image = get_field('icon', $item);
//     // print_r($item);
//     // append icon
//     if ($image) {
//       $item->title .= ' <img width="24" height="25" alt="" src="' . $image['url'] . '" />';
//     }
//   }

//   // return
//   return $items;
// }
