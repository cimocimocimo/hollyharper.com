<?php echo file_get_contents( get_template_directory() . '/assets/svgs/inline/filters.svg'); ?>
<header>
  <div class="header__nav-bg"></div>
  <div class="header__container">
    <div class="header__branding">
      <a class="site-logo" href="<?= esc_url(home_url('/')); ?>">

        <?php echo file_get_contents( get_template_directory() . '/assets/svgs/inline/logo-full.svg'); ?>
        <?php echo file_get_contents( get_template_directory() . '/assets/svgs/inline/logo-condensed-horizontal.svg'); ?>
        <?php echo file_get_contents( get_template_directory() . '/assets/svgs/inline/logo-condensed-vertical.svg'); ?>

      </a>
    </div>
    <div class="header__nav">
      <nav class="nav-primary">
        <?php
        if (has_nav_menu('primary_navigation')) :
        wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']);
        endif;
        ?>
      </nav>
    </div>
  </div>
</header>
