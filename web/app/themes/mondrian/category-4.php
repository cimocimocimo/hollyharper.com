<?php
/**
 * @package WordPress
 * @subpackage Mondrian
 */

get_header(); ?>

<?php get_sidebar(); ?>

	<div id="main">
<h2>Sold Properties</h2>

<p>List of all the properties sold by John and Holly.</p>

<p>Exactly the same format of listing as the Listings index page.</p>

<p>Header, discuss marketing text for selling properties.</p>

<p>Body, list of sold properties</p>

<p>This would be a good place to have testimonials from the sellers, have a testimonials or comments about selling the homes on the properties page as well.</p>

<ul>
<li>Small Listing Photo</li>
<li>Sold for..</li>
<li>MLS</li>
<ul>

<?php if (have_posts()) : ?>

	<?php while (have_posts()) : the_post(); ?>

		<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<h2>Sold - <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
			<p><?php the_time('F jS, Y') ?> <!-- by <?php the_author() ?> --></p>
			<?php the_content('Read the rest of this entry &raquo;'); ?>
			<p><?php the_tags('Tags: ', ', ', '<br />'); ?> Posted in <?php the_category(', ') ?> | <?php edit_post_link('Edit', '', ' | '); ?>  <?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></p>
		</div>

	<?php endwhile; ?>

	<?php next_posts_link('&laquo; Older Entries') ?> | <?php previous_posts_link('Newer Entries &raquo;') ?>

<?php else : ?>

	<h2>Not Found</h2>
	<p>Sorry, but you are looking for something that isn't here.</p>
	<?php get_search_form(); ?>

<?php endif; ?>
<p>Footer, links to about and contact. call to action to either contact John and holly or learn more about them on the about page.</p>
	</div><!-- end main -->


<?php get_sidebar(); ?>
<?php get_footer(); ?>
