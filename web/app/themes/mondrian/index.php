<?php
/**
 * @package WordPress
 * @subpackage Mondrian 0.1
 */
get_header();

while ( have_posts() ) : the_post();

$custom_fields = get_post_custom($post->ID);

// check for a post image, listings should all have images
if ( has_post_thumbnail() ) {
	$thumb_id = get_post_thumbnail_id();
	$thumb = get_post($thumb_id);
	$size = (is_sticky() ? 'slideshow-large' : 'thumbnail'); // the featured listing will be sticky so make that image larger than the rest
	$attr = array(
				'class'	=> "attachment-$size",
				'alt'	=> trim(strip_tags( $thumb->post_excerpt )),
				'title'	=> trim(strip_tags( $thumb->post_title )),
			);
}


// if this is the first post <div id="featured-slideshow">
// *** we are assuming that there is at least one sticky post 
if ( !$after_first_post ) {
?>
	<div class="row">
			<?php get_sidebar(); ?>
		<div id="featured-listings" class="main col">
				<div class="slideshow">
<?php
	$after_first_post = true;
}
// we need to close the slideshow div just before the rest of the regular posts
// and open a new set of side and main col divs.
// the first post that is not sticky is going to be a regular post
// so we use this trick again to test for a variable that we set as true when the if first runs, preventing it from running again.
if ( !is_sticky() && !$after_first_normal_post ) {
?>
				</div><!-- .slideshow -->
			</div><!-- #featured-listings -->
	</div><!-- .row -->
	<div class="row last-row">
		<div class="side col">
			stuff in the side by the rest of the properties
		</div><!-- .side .col -->
		<div class="main col">
<?php
	$after_first_normal_post = true;
}
?>

		<div id="post-<?php the_ID(); ?>" <?php post_class((is_sticky() ? 'featured' : '')); ?>>
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark">
				<div class="listing-img-header">
					<?php echo get_the_post_thumbnail( $post->ID , $size, $attr ); ?>
					<div class="listing-title-price">
						<h2 class="listing-title"><?php the_title(); ?></h2>
						<h3 class="listing-price">$<?php if($price = get_post_meta($post->ID, 'price')) echo $price[0]; ?></h3>
					</div>
				</div>
			</a>
		</div><!-- #post-<?php the_ID(); ?> -->

<?php endwhile; // end loop ?>


 	
	
	
	</div><!-- .main .col -->
</div><!-- .row .last-row -->

<?php get_footer(); ?>
