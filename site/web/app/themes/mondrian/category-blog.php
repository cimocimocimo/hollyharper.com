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
	</div>
	<div class="main col blog">
    	<div class="block-header"><h1>Holly &amp; John's Real Estate Blog</h1></div>

    	<p class="description">Tips on selling your home, finding your dream home, and living and working in Victoria, British Columbia.</p>
<?php

// start the loop
while ( have_posts() ):
    the_post();

// for each of the blog posts let's gather up the first
// three paragraphs, the images and then have a click through for teh heading

$post_image = get_the_post_thumbnail( $post->ID , 'medium', $attr );
// $post_title = '';
$post_date = get_the_time(get_option('date_format'));
$post_tags = get_the_tags();


?>
<div class="blog-post">
<?php

    if ($post_image):

?>
    <div class="alignleft">
		<?php echo $post_image ?>
	</div>
<?php

    endif;

?>
    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
		<h2><?php the_title(); ?></h2>
	</a>
	<div class="date"><?php echo $post_date; ?></div>
<?php

    the_excerpt();
    
	if ($post_tags):

?>
	<div class="tags"><?php echo $post_tags; ?></div>
<?php

    endif;

?>
    <div class="read-more"><a href="<?php the_permalink(); ?>">Read More</a></div>
</div>
<?php

// end loop
endwhile;

?>

<?php

if (  $wp_query->max_num_pages > 1 ):
    
?>
                <div id="nav-below" class="navigation">
                    <div class="nav-previous"><?php next_posts_link( '<span class="meta-nav">&larr;</sp\
an> Older posts' ); ?></div>
                    <div class="nav-next"><?php previous_posts_link( 'Newer posts <span class="meta-nav\
">&rarr;</span>' ); ?></div>
                </div><!-- #nav-below -->                                                                   
<?php

endif;

?>
	</div><!-- .main .col -->
</div><!-- .row .first-row .last-row -->
<?php

get_footer();

?>