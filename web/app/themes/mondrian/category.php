<?php
/**
 * @package WordPress
 * @subpackage Mondrian
 */
$categories = get_the_category($post->ID);
get_header(); ?>

<div class="row first-row last-row">
	<div class="side col">
		<?php get_sidebar(); ?>
	</div>
	<div class="main col">
	<div class="block-header"><h1><?php
	echo $categories[0]->name;
	?></h1></div>

<?php

// start the loop
while ( have_posts() ) : the_post();

// get the data for the listing from the custom fields in the post
$listing = new listingData();


// check for a post image, listings should all have images
if ( has_post_thumbnail() ) {
	$thumb_id = get_post_thumbnail_id();
	$thumb = get_post($thumb_id);
	$size = 'thumbnail';
	$attr = array(
				'class'	=> "attachment-$size",
				'alt'	=> trim(strip_tags( $thumb->post_excerpt )),
				'title'	=> trim(strip_tags( $thumb->post_title )),
			);
}

?>



	
			<div <?php post_class('block'); ?>>
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
						<?php echo get_the_post_thumbnail( $post->ID , $size, $attr ); ?>
							<h3><?php the_title(); ?></h3>
							<p>$<?php if($price = get_post_meta($post->ID, 'price')) echo $price[0]; ?></p>
				</a>
			</div><!-- #post-<?php the_ID(); ?> -->
	
 <?php endwhile; // end loop ?>

<?php if (  $wp_query->max_num_pages > 1 ) : ?>
                <div id="nav-below" class="navigation">
                    <div class="nav-previous"><?php next_posts_link( '<span class="meta-nav">&larr;</sp\
an> Older posts' ); ?></div>
                    <div class="nav-next"><?php previous_posts_link( 'Newer posts <span class="meta-nav\
">&rarr;</span>' ); ?></div>
                </div><!-- #nav-below -->                                                                   
<?php endif; ?>



	</div><!-- .main .col -->
</div><!-- .row .first-row .last-row -->


<?php get_footer(); ?>