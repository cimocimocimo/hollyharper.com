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
	<div id="recently-sold" class="main-half col">
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
	</div><!-- #recently-sold .main-half .col -->
	<div id="recent-entries" class="main-half col">

<!--
		<div class="block-header">
			<h2>Blog Entries</h2>
		</div>
<?php

// set up the posts object with 5 of the most recent listings that are not sticky (featured)

$args = array(
        	'category_name'	=>	'blog',
        	'posts_per_page' =>	5,
        	);

$blog_entries = get_posts($args);

foreach ($blog_entries as $entry):

    $custom_fields = get_post_custom($entry->ID);
    
    // check for a post image, listings should all have images
    
    $img_html = False;
    if ( has_post_thumbnail( $entry->ID ) ) {
    	$thumb_id = get_post_thumbnail_id( $entry->ID );
    	$thumb = get_post($thumb_id);
    	$size = 'thumbnail';
    	$attr = array(
    				'class'	=> "attachment-$size",
    				'alt'	=> trim(strip_tags( $thumb->post_excerpt )),
    				'title'	=> trim(strip_tags( $thumb->post_title )),
    			);
    	$img_html = get_the_post_thumbnail( $entry->ID, $size, $attr );
    }

?>
 		<div <?php post_class('blog block'); ?>>
 		<a href="<?php echo get_permalink( $entry->ID ); ?>">
 			<h3 class="post-title"><?php echo get_the_title( $entry->ID ); ?></h3>
 		</a>
<?php

    if ($img_html):

?>
 			<a href="<?php echo get_permalink( $entry->ID ); ?>">
 				<?php echo $img_html; ?>
			</a>
<?php

    endif;

?>
 			<?php echo get_the_excerpt( $entry->ID ); ?>
			
 			<p><a href="<?php echo get_permalink( $entry->ID ); ?>" class="more">Read More</a></p>
  		</div>
<?php

endforeach; // end blog entries loop

?>
        <p class="block">
        <a href="/blog/">More Blog Entries</a>
        </p>
-->

	</div><!-- .main-half .col -->
</div><!-- .row .last-row -->
<?php

get_footer();

?>
