<?php
/**
 * @package WordPress
 * @subpackage Mondrian
 */

// this code checks the author for the post which is either holly or john and then displays their image and phone number and email underneith their photo.

  // the author is used to store the info for the listing agent for the current listing
  $fname = get_the_author_meta('first_name');
  $lname = get_the_author_meta('last_name');
  $phone = get_the_author_meta('aim'); // no phone field, so use aim.
  $email = get_the_author_meta('user_email');

  // formats the name of the listing agent
$fname_char = substr($fname, 0, 1);
$fname_rest = substr($fname, 1);
$lname_char = substr($lname, 0, 1);
$lname_rest = substr($lname, 1);
$string_format = '<span>%s</span>%s <span>%s</span>%s';
$name_formatted = sprintf($string_format, $fname_char, $fname_rest, $lname_char, $lname_rest);

$agent_photo_filename = strtolower($fname) . '-' . strtolower($lname) . '-profile-thumb.jpg';

?>
<div id="listing-realtor">
	<a href="/contact/">
	    <img src="<?php bloginfo('template_directory'); ?>/img/<?php echo $agent_photo_filename; ?>" width="130" height="179" />
	    <img class="profile-frame" src="<?php bloginfo('template_directory'); ?>/img/profile-frame.png" width="143" height="193" />
	    <div class="name-phone-email">
		    <div class="name"><?php echo $name_formatted; ?></div>
		    <div class="phone"><?php echo $phone; ?></div>
		    <div class="email"><?php echo $email; ?></div>
	    </div>
	</a>
</div>
<?php wp_nav_menu( array( 'container_id' => 'general-nav', 'theme_location' => 'secondary' ) ); ?>
