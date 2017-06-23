<?php echo file_get_contents( get_template_directory() . '/assets/svgs/inline/filters.svg'); ?>

<div class="multilevel-offcanvas off-canvas position-right" id="offCanvasRight" data-off-canvas>

  <ul class="vertical menu" data-accordion-menu>
    <li><a href="#">SERVICES</a>
      <ul class="menu vertical nested">
        <li><a href="#">Brand</a></li>
        <li><a href="#">Web Apps</a></li>
        <li><a href="#">Mobile Apps</a></li>
      </ul>
    </li>
    <li><a href="#">PRODUCTS</a>
      <ul class="menu vertical nested">
        <li><a href="#">Product 1</a></li>
        <li><a href="#">Product 2</a></li>
        <li><a href="#">Product 3</a></li>
      </ul>
    </li>
    <li><a href="#">CITIES</a>
      <ul class="menu vertical nested">
        <li><a href="#">London</a></li>
        <li><a href="#">New York</a></li>
        <li><a href="#">Paris</a></li>
      </ul>
    </li>
  </ul>
  <ul class="menu simple social-links">
    <li><a href="#" target="_blank"><i class="fa fa-twitter-square" aria-hidden="true"></i></a></li>
    <li><a href="#" target="_blank"><i class="fa fa-facebook-square" aria-hidden="true"></i></a></li>
    <li><a href="#" target="_blank"><i class="fa fa-github-square" aria-hidden="true"></i></a></li>
    <li><a href="#" target="_blank"><i class="fa fa-google-plus-square" aria-hidden="true"></i></a></li>
  </ul>
</div>

<div class="off-canvas-content" data-off-canvas-content>
  <div class="nav-bar header">
    <div class="nav-bar-left">
      <a class="nav-bar-logo site-logo" href="{{ home_url('/') }}">

        <?php echo file_get_contents( get_template_directory() . '/assets/svgs/inline/Holly-Harper-logo-full.svg'); ?>
        <?php echo file_get_contents( get_template_directory() . '/assets/svgs/inline/Holly-Harper-logo-condensed.svg'); ?>
        <?php echo file_get_contents( get_template_directory() . '/assets/svgs/inline/Holly-Harper-logo-abbreviated.svg'); ?>

      </a>
    </div>
    <div class="nav-bar-right">
      <ul class="menu">
        <li class="hide-for-small-only"><a href="{{ home_url('/') }}">HOME</a></li>
        <li class="hide-for-small-only"><a href="{{ home_url('/about') }}">ABOUT</a></li>
        <li class="hide-for-small-only"><a href="{{ home_url('/contact') }}">CONTACT</a></li>
        <li>
          <button class="offcanvas-trigger" type="button" data-open="offCanvasRight">
            <span class="offcanvas-trigger-text hide-for-small-only">Menu</span>
            <div class="hamburger">
              <span class="line"></span>
              <span class="line"></span>
              <span class="line"></span>
            </div>
          </button>
        </li>
      </ul>
    </div>
  </div>
  <!-- <header class="banner">
    <div class="header__nav-bg"></div>
    <div class="header__container">
      <div class="header__branding">
        <a class="site-logo" href="{{ home_url('/') }}">

          < ?php echo file_get_contents( get_template_directory() . '/assets/svgs/inline/Holly-Harper-logo-full.svg'); ?>
          < ?php echo file_get_contents( get_template_directory() . '/assets/svgs/inline/Holly-Harper-logo-condensed.svg'); ?>
          < ?php echo file_get_contents( get_template_directory() . '/assets/svgs/inline/Holly-Harper-logo-abbreviated.svg'); ?>

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
  </header> -->
</div>
