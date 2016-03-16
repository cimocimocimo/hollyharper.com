<?php
/**
 * @package WordPress
 * @subpackage Mondrian
 */

// cordova listing is post id 627
$listing = wp_get_single_post( 627 );

while ( have_posts() ) : the_post(); ?>
<pre>
    <?php print_r($listing); ?>
</pre>
<?php

$args = array( 'post_type' => 'attachment', 'numberposts' => -1, 'post_status' => null, 'post_parent' => 627 ); 
$attachments = get_posts($args);
if ($attachments) {
	foreach ( $attachments as $attachment ) {
		echo wp_get_attachment_image( $attachment->ID , 'full' );
	}
}

endwhile; // end loop

?>