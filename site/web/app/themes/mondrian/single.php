<?php
/**
 * @package WordPress
 * @subpackage Mondrian
 */

// page globals
$slide_img_size = 'slideshow-large';
$pager_img_size = 'slideshow-thumb';

// check for a post thumbnail, all listings SHOULD have one. 
if ( has_post_thumbnail() ) {
    $thumb_id = get_post_thumbnail_id();
}

get_header();

// start the loop
while ( have_posts() ) : the_post();

// find out what type of single post this is
// ( really need to replace this with the custom post type functionality )
$categories = get_the_category();
// cycle through the categories for this post.
$blog = false;
foreach ($categories as $category) {
    // if it belongs to the blog category then we'll treat this post as a blog post type
    if ($category->slug == 'blog') {
        $blog = true;
    }
}

// this if statement decides what type of layout to display for this page
if ($blog) {

?>
  <div class="row single-row">
    <div class="side col">
      <?php get_sidebar(); ?>
    </div>
    <div class="main col">
      <div class="block-header"><h1><?php the_title(); ?></h1></div>


      <?php /* Display navigation to next/previous pages when applicable */ ?>
      <?php if ( $wp_query->max_num_pages > 1 ) : ?>
        <div id="nav-above" class="navigation">
          <div class="nav-previous"><?php next_posts_link( '<span class="meta-nav">&larr;</span> Older po\
sts' ); ?></div>
          <div class="nav-next"><?php previous_posts_link( 'Newer posts <span class="meta-nav">&rarr;</sp\
an>', 'twentyten' ); ?></div>
        </div><!-- #nav-above -->                                                                               
      <?php endif; ?>

      <div class="post">
	<div class="date">
	  Posted on: <?php the_time(get_option('date_format')); ?>
	</div>

	<?php the_content(); ?>	
	
      </div>
<?php

} else { // this is a listing post

    // get the data for the listing from the custom fields in the post
    $listing = new listingData();
    $map = new listingMap($listing->location());

    // get all the post attachments
    $args = array(
	'post_type' => 'attachment',
	'numberposts' => -1,
	'post_status' => null,
	'post_parent' => $post->ID,
	'orderby'     => 'menu_order',
    ); 
    $attachments = get_posts($args);
    
    // sort the images from the pdfs and store them in their own arrays
    foreach ($attachments as $index => $attach){
	if ( $attach->post_mime_type == 'application/pdf' ) {
	    $attached_pdfs[$attach->post_excerpt] = $attach;
	} elseif (strpos( $attach->post_mime_type, 'image' ) !== false) {
	    
	    // we've got attached images
	    // create an array for them if the array is not set
	    // we need the empty array since array_unshift() thows an error when the passed array does not exist		
	    if ( !isset($attached_imgs) ) { $attached_imgs = array(); }
	    
	    
	    // add image data for the large slideshow image and the thumb used for the pager
	    $slide_temp = wp_get_attachment_image_src( $attach->ID, $slide_img_size );
	    $slide_img = new stdClass();
	    $slide_img->url = $slide_temp[0];
	    $slide_img->width = $slide_temp[1];
	    $slide_img->height = $slide_temp[2];		
	    $attach->slide_img = $slide_img;
	    
	    
	    $pager_temp = wp_get_attachment_image_src( $attach->ID, $pager_img_size );
	    $pager_img = new stdClass();
	    $pager_img->url = $pager_temp[0];
	    $pager_img->width = $pager_temp[1];
	    $pager_img->height = $pager_temp[2];
	    $attach->pager_img = $pager_img;
	    
	    
            // push the images onto the front of the array to perserve their ordering.
	    array_unshift($attached_imgs, $attach);
            /*

               // if the current attachment id matches this post's thumbnail id then we unshift that object onto the front of the array
               // else just push it onto the end

	       if ( $attach->ID == $thumb_id ) {
	       array_unshift($attached_imgs, $attach);
	       } else {
	       $attached_imgs[] = $attach;
	       }
             */
	}
    }
    
?>
      <div class="row first-row">
	<div class="side col">
	  <?php get_sidebar('listing'); ?>
	</div>
	<div id="listing-gallery" class="main col">
	  <div class="slideshow">				
	    <?php
	    
	    // here we output the images for the gallery. For users with javascript disabled we hide all sides after the first.
	    
            $first = true;
	    foreach ($attached_imgs as $img_data) {
		$slide_img = $img_data->slide_img;
	    ?>
	      <div class="slide<?php echo $first ? ' first' : ''; ?>">
		<img src="<?php echo $slide_img->url; ?>" width="<?php echo $slide_img->width; ?>" height="<?php echo $slide_img->height; ?>" />
		<?php if ($img_data->post_excerpt) : ?>
		  <div class="slide-meta-box">
		    <p><?php echo $img_data->post_excerpt; ?></p>
		  </div>
		<?php endif; ?>
	      </div>
              <?php
              
	      $first = false;
	      } // end foreach
	      
	      ?>
	      
	  </div><!-- .slideshow -->
	  <div class="pager">
	    <div class="pager-imgs">
	      
	      <?php
	      
	      foreach ($attached_imgs as $index => $img_data) {
		  $pager_img = $img_data->pager_img;
	      ?>
		<div id="pager-img-<?php echo $index; ?>">
		  <img src="<?php echo $pager_img->url; ?>" width="<?php echo $pager_img->width; ?>" height="<?php echo $pager_img->height; ?>" />
		</div>
	      <?php
	      
	      }
	      
	      ?>
	    </div><!-- .pager-imgs -->
	    
	    
	    
	  </div><!-- .pager -->
	</div><!-- #featured-listings -->
      </div><!-- .row -->
      <div class="row last-row">
	<div class="side col">
	  <div id="listing-data">
	    <div class="block-header">
	      <h3>Listing Data</h3>
	    </div>
	    <dl class="listing-data">
	      <?php
	      foreach ($listing as $key => $value){

		  if ( $value && $key != 'price' && isset($value->label)){

	      ?>
		<dt><?php echo $value->label; ?></dt><dd><?php echo $value->data; ?></dd>
	      <?php
	      } // end if
	      } // end foreach
	      ?>
	    </dl>

            <?php if (isset($attached_pdfs)) { ?>

              <div class="block-header">
	        <h3>Floorplan &amp; PDFs</h3>
              </div>

              <ul>
	        <li><?php if ($attached_pdfs['floorplan']) { ?>
		  <a href="<?php echo $attached_pdfs['floorplan']->guid; ?>">Floorplan</a>
		<?php } ?></li>
	        <li><?php if ($attached_pdfs['brochure']) { ?>
		  <a href="<?php echo $attached_pdfs['brochure']->guid; ?>">Listing Brochure</a>
		<?php } ?></li>
                <li><?php if ($attached_pdfs['davenport']) { ?>
	          <a href="<?php echo $attached_pdfs['davenport']->guid; ?>">Davenport Map</a>
	        <?php } ?></li>


              </ul>	

            <?php } // if attached pdfs ?>
	  </div>		
	  
	</div><!-- .side .col -->
	<div class="main col">
          <?php

          $listing_title = get_the_title();

          if (in_category('sold')) {
              $listing_title = 'SOLD - ' . $listing_title;
          }

          ?>


	  <div class="block-header">
	    <h1><?php echo $listing_title; ?></h1>
	    <p><?php echo $listing->price->data; ?></p>
	  </div>
	  
	  <?php the_content(); ?>
	  
	  <div class="col main-half">
	    <?php show_interior_features(); ?>
	  </div>
	  <div class="col main-half">
	    <?php show_lot_features(); ?>
	    
            <div class="listing-location">
              <h4>Location</h4>
              <?php 
              
              echo $map->static_map_img();
              
              if (isset($map->location)){
                  echo $map->location;
              }
              
              ?>
	    </div>
	    
	  </div>
	  
	  
<?php		
} // end if


endwhile; // end loop ?>


	</div><!-- .main .col -->
      </div><!-- .row .last-row -->

      <?php get_footer(); ?>
