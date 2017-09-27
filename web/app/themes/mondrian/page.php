<?php
/**
 * @package WordPress
 * @subpackage Mondrian
 */

get_header();

?>
<div class="row first-row last-row">
	<div class="side col">
    <?php

    get_sidebar();

    ?>
	</div><!-- .side .col -->
	<div class="main col">
    <?php

    while ( have_posts() ) : the_post();

    ?>
	    <div class="block-header">
        <h1><?php the_title(); ?></h1>
      </div>
	    <div id="page-content">
			  <?php

        the_content();

        ?>
	    </div>
    <?php

    endwhile; // end loop

    ?>
	</div><!-- .main .col -->
</div><!-- .row .last-row -->
<?php

get_footer();

?>
