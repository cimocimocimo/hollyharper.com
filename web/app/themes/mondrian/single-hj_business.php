<?php
/**
 * @package WordPress
 * @subpackage Mondrian 0.1
 */
  get_header();


  // start the loop
  while ( have_posts() ) : the_post();

  // check for a post thumbnail, all listings SHOULD have one. 
  if ( has_post_thumbnail() ) {
      $thumb_id = get_post_thumbnail_id();
  }

  
?>
<div class="row single-row">
	<div class="side col">
		<?php get_sidebar(); ?>
	</div><!-- .side .col -->
	<div class="main col">
        <div class="block-header"><h1><?php the_title(); ?></h1></div>
        <div class="post">
	        <?php the_content(); ?>	
        </div>
	</div><!-- .main .col -->
</div><!-- .row .last-row -->
<?php
    
  endwhile;
  get_footer();

?>
