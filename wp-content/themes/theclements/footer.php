<?php
$FOOTER_CONFIG = get_field('footer_config', 'option');
$SOCIALS_CONFIG = get_field('socials', 'option');
?>
<footer class="site-footer">
  <div class="footer-content">
    <!-- Logo -->
    <div class="footer-branding">
      <img class="header__brand-logo"
        src="<?php echo $FOOTER_CONFIG['logo']['url']; ?>"
        alt="<?php echo $FOOTER_CONFIG['logo']['alt']; ?>">
    </div>

    <!-- Main footer content -->
    <div class="footer-main">
      <!-- Column 1 -->
      <div class="footer-column">
        <?php
        // Check if the menu "footer-nav-1" exists
        if (($locations = get_nav_menu_locations()) && isset($locations['footer-nav-1'])) {
          $menu = wp_get_nav_menu_object($locations['footer-nav-1']); // Get the menu object
          $menu_items = wp_get_nav_menu_items($menu->term_id); // Get the menu items

          if ($menu_items) {
            foreach ($menu_items as $menu_item): ?>
              <a href="<?php echo esc_url($menu_item->url); ?>"><?php echo esc_html($menu_item->title); ?></a>
        <?php endforeach;
          }
        }
        ?>
      </div>

      <!-- Column 2 -->
      <div class="footer-column">
        <?php
        // Check if the menu "footer-nav-1" exists
        if (($locations = get_nav_menu_locations()) && isset($locations['footer-nav-2'])) {
          $menu = wp_get_nav_menu_object($locations['footer-nav-2']); // Get the menu object
          $menu_items = wp_get_nav_menu_items($menu->term_id); // Get the menu items

          if ($menu_items) {
            foreach ($menu_items as $menu_item): ?>
              <a href="<?php echo esc_url($menu_item->url); ?>"><?php echo esc_html($menu_item->title); ?></a>
        <?php endforeach;
          }
        }
        ?>
      </div>

      <!-- Column 3 -->
      <div class="footer-info">
        <div class="footer-actions">
          <?php
          // Check if the menu "footer-nav-1" exists
          if (($locations = get_nav_menu_locations()) && isset($locations['footer-nav-3'])) {
            $menu = wp_get_nav_menu_object($locations['footer-nav-3']); // Get the menu object
            $menu_items = wp_get_nav_menu_items($menu->term_id); // Get the menu items

            if ($menu_items) {
              foreach ($menu_items as $menu_item): ?>
                <a href="<?php echo esc_url($menu_item->url); ?>"><?php echo esc_html($menu_item->title); ?></a>
          <?php endforeach;
            }
          }
          ?>

          <?php if ($FOOTER_CONFIG['enable_newsletter']): ?>
            <div class="newsletter">
              <h4><?php echo $FOOTER_CONFIG['newsletter_title']; ?></h4>
              <input type="email" placeholder="<?php echo $FOOTER_CONFIG['newsletter_placeholder']; ?>">
              <button class="btn"><?php echo $FOOTER_CONFIG['newsletter_button_text']; ?></button>
            </div>
          <?php endif; ?>
        </div>

        <div class="footer-social">
          <?php foreach ($SOCIALS_CONFIG as $social): ?>
            <a href="<?php echo $social['link']['url']; ?>">
              <img src="<?php echo $social['icon']['url']; ?>" alt="<?php echo $social['icon']['alt']; ?>">
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <!-- Bottom legal section -->
    <div class="footer-legal">
      <div class="legal-links">
        <?php
        // Check if the menu "footer-nav-1" exists
        if (($locations = get_nav_menu_locations()) && isset($locations['footer-nav-4'])) {
          $menu = wp_get_nav_menu_object($locations['footer-nav-4']); // Get the menu object
          $menu_items = wp_get_nav_menu_items($menu->term_id); // Get the menu items

          if ($menu_items) {
            foreach ($menu_items as $menu_item): ?>
              <a href="<?php echo esc_url($menu_item->url); ?>"><?php echo esc_html($menu_item->title); ?></a>
        <?php endforeach;
          }
        }
        ?>
      </div>
      <div class="company-info">
        <?php echo $FOOTER_CONFIG['copyright_text']; ?> &copy; <?php echo date('Y'); ?>
      </div>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>

<script>
  // document.addEventListener('DOMContentLoaded', function() {
  //   const mainContent = document.querySelector('.main-content');
  //   const modules = document.querySelectorAll('.clement-module');
  //   const footer = document.querySelector('.site-footer');
  //   let lastModule = modules[modules.length - 1];

  //   mainContent.addEventListener('scroll', function() {
  //     const lastModuleRect = lastModule.getBoundingClientRect();
  //     const footerRect = footer.getBoundingClientRect();

  //     if (lastModuleRect.bottom <= window.innerHeight + 100) { // 100px threshold
  //       mainContent.style.scrollSnapType = 'none'; // Disable snap
  //     } else {
  //       mainContent.style.scrollSnapType = 'y mandatory'; // Re-enable snap
  //     }
  //   });
  // });
</script>
</div><?php // closing main-content div 
      ?>
</body>

</html>