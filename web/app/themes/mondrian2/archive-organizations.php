<?php
	wp_head();

	$org_type = '';
	$previous_org_type = '';
	$org_link = '';
	$org_desc = '';

	// Query for all organizations, order by organization_type and title so we 
	// just have to group the items in the loop.
	$the_query = new WP_Query(array(
		'post_type'         => 'organizations',
		'posts_per_page'    => -1,
		'meta_key'          => 'organization_type',
		'orderby'           => array( 'meta_value' => 'ASC', 'title' => 'ASC' )
	));

	if( $the_query->have_posts() ) {
?>
		<ul>
<?php

		while( $the_query->have_posts() ){ 
			$the_query->the_post();
			$org_type = get_field('organization_type');
			$org_link = get_field('organization_link');
			$org_desc = get_field('organization_description');

			// If the organization type has changed (Accomodation to School, etc)
			if( $org_type != $previous_org_type ) {
				// Print the next organization type header
?>
				<div class="org_type_header"><?php echo $org_type; ?></div>
<?php

				$previous_org_type = $org_type;
			} else {
				// Print the title of the organization and link to it.
?>
				<li class="org_title"><a href="<?php echo $org_link; ?>"><?php the_title(); ?></a><?php echo ($org_desc != '' ? ' - ' .$org_desc : ''); ?></li>
<?php
			}
		}
?>
		</ul>
<?php
	} else {
		// If there are organizations, print something other than a blank page.
?>
		<div class="org_error">Sorry, there are no organizations listed right now, please check again later.</div>
<?php
	}
	wp_reset_query();  // Restore global post data stomped by the_post().

	wp_footer();
?>
