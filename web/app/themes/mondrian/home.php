<?php
/**
 * @package WordPress
 * @subpackage Mondrian 0.1
 */

get_header();

// set up the posts object with nothing but the sticky posts

$args = array(
        	'category_name'  => 'listings',
        	'orderby'	=>	'rand',
        	);
$current_listings = get_posts($args);

// query_posts($args);

?>
<div class="row first-row">
	<div class="side col">
		<?php get_sidebar(); ?>
	</div>
	<div id="featured-listings" class="main col">
			<div class="slideshow">
<?php

foreach ($current_listings as $listing):

    $custom_fields = get_post_custom($listing->ID);

    // check for a post image, listings should all have images
    if ( has_post_thumbnail( $listing->ID ) ) {
    	$thumb_id = get_post_thumbnail_id( $listing->ID );
    	$thumb = get_post($thumb_id);
    	$size = 'slideshow-large';
    	$attr = array(
    				'class'	=> "attachment-$size",
    				'alt'	=> trim(strip_tags( $thumb->post_excerpt )),
    				'title'	=> trim(strip_tags( $thumb->post_title )),
    			    );
    }

?>
		<div id="post-<?php echo $listing->ID; ?>" <?php post_class('featured'); ?>>
			<a href="<?php echo get_permalink( $listing->ID ); ?>">
				<div class="listing-img-header">
					<?php echo get_the_post_thumbnail( $listing->ID , $size, $attr ); ?>
					<div class="listing-title-price">
						<h1><?php echo get_the_title( $listing->ID ); ?></h1>
						<p class='price'>$<?php if($price = get_post_meta($listing->ID, 'price')) echo $price[0]; ?></p>
					</div>
				</div>
			</a>
		</div><!-- #post-<?php echo $listing->ID; ?> -->
<?php

endforeach; // end current listing slideshow loop

?>
			</div><!-- .slideshow -->
		</div><!-- #featured-listings -->
</div><!-- .row -->
<div id="sold-blog-row" class="row last-row">
	<div class="side col">
<?php

get_sidebar('seller');

?>


	</div><!-- .side .col -->
  <div class="main col">
  
  <div class="garden-tour" style="display: none;">
      <div class="block-header">
        <h2>Victoria, BC Events</h2>
      </div>
      <div class="block">
        <h3>35th Annual Mother’s Day Musical Garden Tour</h3>
        <p>Newport Realty is a proud sponsor of the Mother's Day Garden Tour in Support of the Victoria Conservatory of Music.</p>
        <p><iframe src="https://player.vimeo.com/video/191727982" frameborder="0" width="560" height="315"></iframe></p>
        <p>
          Saturday May 13, 2017 - Sunday May 14, 2017
          <br>
          Starts: 10:00 AM
          <br>
          Cost: $30
        </p>
        <p>
          <a href="https://www.ticketfly.com/purchase/event/1442796?utm_medium=bks">Buy your Tickets Today through ticketfly.com</a>
        </p>
      </div>
    </div>
	  <div id="recently-sold">
		  <div class="block-header">
			  <h2>Recently Sold</h2>
		  </div> 
      <?php 

      $args = array(
        'category_name'	=>	'sold',
          'posts_per_page' =>	5,
      );

      $sold_properties = get_posts($args);

      foreach ($sold_properties as $property):

                         $custom_fields = get_post_custom($property->ID);
      
      // check for a post image, listings should all have images
      if ( has_post_thumbnail( $property->ID ) ) {
    	  $thumb_id = get_post_thumbnail_id( $property->ID );
    	  $thumb = get_post($thumb_id);
    	  $size = 'thumbnail';
    	  $attr = array(
    			'class'	=> "attachment-$size",
    				'alt'	=> trim(strip_tags( $thumb->post_excerpt )),
    				'title'	=> trim(strip_tags( $thumb->post_title )),
        );
      }

      ?>
 		    <div <?php post_class('sold block'); ?>>
 			    <a href="<?php echo get_permalink( $property->ID ); ?>">
 					  <?php echo get_the_post_thumbnail( $property->ID , $size, $attr ); ?>
 						<h3><?php echo get_the_title( $property->ID ); ?></h3>
 						<p>$<?php if($price = get_post_meta( $property->ID, 'price')) echo $price[0]; ?></p>
 			    </a>
 		    </div><!-- #post-<?php echo get_the_ID( $property->ID ); ?> -->
      <?php

      endforeach; // end sold properties loop

      ?>
      <p class="block">
        <a href="/sold/">All Sold Listings</a>
      </p>
	  </div><!-- #recently-sold -->
  </div>
</div><!-- .row .last-row -->
<?php

get_footer();

?>
