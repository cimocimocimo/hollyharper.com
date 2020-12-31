<?php
	  if ( $custom_fields['open-house-start-time'] && $custom_fields['open-house-end-time'] ) {
		$open_house_start_time_unix = strtotime( $custom_fields['open-house-start-time'][0] );
		$open_house_end_time_unix = strtotime( $custom_fields['open-house-end-time'][0] );

		// when to start displaying the open house
		$open_house_display_time_unix = strtotime( $custom_fields['open-house-display-time'][0] );

		// the php time() function and the WP current_time() function appear to return the same times
		// using the WP current_time() function incase changing the timezone in WP does not cuase a timezone change in PHP
		// converting the WP timestamp to unix time for easier comparisons
		$wp_current_time_unix = strtotime( current_time('mysql') );

		// if the current time is before the end of the open house
		if ( $wp_current_time_unix < $open_house_end_time_unix && $wp_current_time_unix > $open_house_display_time_unix) {
		  $open_house_day = date('l, F j', $open_house_start_time_unix ) . "\n";
		  $open_house_start_hour = date('g', $open_house_start_time_unix ) . "\n";
		  $open_house_end_hour = date('g a', $open_house_end_time_unix ) . "\n";

?>

<div class="open-house">
<span class="open-house-header">Open House</span>
<br/>
   <?php echo $open_house_day; ?>
<br/>
   <?php echo $open_house_start_hour . " – " . $open_house_end_hour; ?>
</div>
<?php
   } // end if current time is before open house end time
	  } // end if open house start and end times are not false

?>
