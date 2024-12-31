<?php

if (!defined('ABSPATH')) {
  exit;
}


if ($query->have_posts() && is_page('search')) {
  echo "<span id='sf-results-count'>" . $query->found_posts . "</span>";
  while ($query->have_posts()) {
    $query->the_post(); ?>

    <?php // get_template_part('partials/partial', 'search-item'); 
    ?>
  <?php
  }
} else if ($query->have_posts() && is_home()) {

  while ($query->have_posts()) {
    $query->the_post(); ?>

    <?php // get_template_part('partials/partial', 'news-item'); 
    ?>

  <?php }
} else { ?>

  <div class='search-filter-results-list' data-search-filter-action='infinite-scroll-end'>
    <!-- <span>End of Results</span> -->
  </div>

<?php }
