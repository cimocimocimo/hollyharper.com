<?php echo file_get_contents( get_template_directory() . '/assets/svgs/inline/filters.svg'); ?>
<header class="banner">
  <div class="header__nav-bg"></div>
  <div class="header__container">
    <div class="header__branding">
      <a class="site-logo" href="{{ home_url('/') }}">

        <?php echo file_get_contents( get_template_directory() . '/assets/svgs/inline/Holly-Harper-logo-full.svg'); ?>
        <?php echo file_get_contents( get_template_directory() . '/assets/svgs/inline/Holly-Harper-logo-condensed.svg'); ?>
        <?php echo file_get_contents( get_template_directory() . '/assets/svgs/inline/Holly-Harper-logo-abbreviated.svg'); ?>

      </a>
    </div>
    <div class="header__nav">
      <nav class="nav-primary">
        @if (has_nav_menu('primary_navigation'))
          {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']) !!}
        @endif
      </nav>
    </div>
  </div>
</header>
