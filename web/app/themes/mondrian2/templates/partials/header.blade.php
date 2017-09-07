<?php echo file_get_contents( get_template_directory() . '/assets/svgs/inline/filters.svg'); ?>

<div class="multilevel-offcanvas off-canvas position-right" id="offCanvasRight" data-off-canvas>
  <?php wp_nav_menu( array( 'theme_location' => 'sidebar-menu' ) ); ?>

  <ul class="vertical menu" data-accordion-menu>
    <li>
      <a href="/sold">SOLD PROPERTIES</a>
      <!-- <ul class="menu vertical nested">
        <li><a href="#">Property 1</a></li>
        <li><a href="#">Property 2</a></li>
        <li><a href="#">Property 3</a></li>
      </ul> -->
    </li>
    <li>
      <a href="/listings">CURRENT LISTINGS</a>
      <!-- <ul class="menu vertical nested">
        <li><a href="#">Property 1</a></li>
        <li><a href="#">Property 2</a></li>
        <li><a href="#">Property 3</a></li>
      </ul> -->
    </li>
    <li>
      <a href="/links">VICTORIA, BC INFO</a>
    </li>
    <li>
      <a href="/blog">REAL ESTATE BLOG</a>
    </li>
  </ul>

  <!-- Begin MailChimp Signup Form -->
  <div id="mc_embed_signup">
    <div class="block-header">
      <h4>Holly's Real Estate Newsletter</h4>
    </div>
    <p>
      New Listings, Price Drops, Real Estate Tips,
      and articles about living in Victoria, BC delivered to your email.
    </p>
    <form action="http://hollyandjohn.us6.list-manage.com/subscribe/post?u=099f7cafd42f8208755180329&amp;id=6c3f3940a7" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate="" _lpchecked="1">
      <fieldset>
        <input type="text" value="" name="EMAIL" class="required email defaultText defaultTextActive" title="Enter your email" id="mce-EMAIL">
        <input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button">
        <div id="pp-link">
          <a href="/privacy-policy/">Privacy Policy</a>
        </div>
      </fieldset>
    </form>
  </div>
  <!--End mc_embed_signup-->

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

    <?php wp_nav_menu(
      array(
        'theme_location' => 'header-menu',
        'container' => 'div',
        'container_class' => 'nav-bar-right'
      )
    ); ?>
    <div class="nav-bar-right">
      <ul class="menu">
        <!-- <li class="hide-for-small-only"><a href="{{ home_url('/') }}">HOME</a></li>
        <li class="hide-for-small-only"><a href="{{ home_url('/about') }}">ABOUT</a></li>
        <li class="hide-for-small-only"><a href="{{ home_url('/contact') }}">CONTACT</a></li> -->
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
