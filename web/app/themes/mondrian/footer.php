<?php
/**
 * @package WordPress
 * @subpackage Mondrian
 */
?>
	</div><!-- #wrap -->
	<div id="footer" class="row">
	  <div id="footer-nav"><?php 
		               // there is a walker argument that can be specified to alter how the html for the menu is built. look into this.
		               wp_nav_menu( array( 'container_class' => 'footer-nav-menu', 'theme_location' => 'tertiary' ) ); ?>
	  </div>
          <div id="copyright">
            <p>
              Copyright &copy; <?php echo date('Y'); ?> John West & Holly Harper
            </p>
          </div>
          <?php

          // if ( is_front_page() == false ):

          ?>
	  <div id="newport-info">
    	    <a href="http://newportrealty.com/" target="_blank">
              <img src="<?php bloginfo('template_directory'); ?>/img/newport-realty-victoria-bc-85x60-logo.png" width="85" height="60" alt="Newport Realty Logo" />
            </a>
    	    <p>
              1286 Fairfield Road<br/>
    	      Victoria, BC<br/>
    	      Canada V8V 4W3
            </p>
	  </div>
	</div>
        <?php

        // endif;

        wp_footer();

        ?>
        <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery-1.12.1.min.js"></script>
        <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.cycle.all.js"></script>
        <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/slideshow.js"></script>
</body>
</html>
