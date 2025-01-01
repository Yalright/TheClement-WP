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


function get_all_header_nav_menus()
{
  $current_site_id = get_current_blog_id(); // Get the current site ID
  $sites = get_sites(); // Retrieve all sites in the network
  $menus = []; // Initialize an array to store menus

  // Loop through all sites
  foreach ($sites as $site) {
    switch_to_blog($site->blog_id); // Switch to the site's context

    // Get menu locations and find the 'header-nav' menu
    $locations = get_nav_menu_locations();
    if (isset($locations['header-nav'])) {
      $menu_id = $locations['header-nav'];
      $menu_items = wp_get_nav_menu_items($menu_id); // Get menu items

      // Group menu items by parent
      $menu_structure = [];
      if ($menu_items) {
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
      }

      // Add the menu to the list with site info
      $menus[] = [
        'site_id' => $site->blog_id,
        'site_name' => get_bloginfo('name'),
        'menu_structure' => $menu_structure,
      ];
    }

    restore_current_blog(); // Restore the original blog context
  }

  // Sort menus to have the current site first
  usort($menus, function ($a, $b) use ($current_site_id) {
    if ($a['site_id'] == $current_site_id) return -1;
    if ($b['site_id'] == $current_site_id) return 1;
    return 0;
  });

  return $menus;
}
