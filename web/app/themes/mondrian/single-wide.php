<?php
/**
 * @package WordPress
 * @subpackage Mondrian
 *
 * Single Post Template: Listing Wide
 */

// page globals
$slide_img_size = 'slideshow-large';
$pager_img_size = 'slideshow-thumb';

// check for a post thumbnail, all listings SHOULD have one. 
if ( has_post_thumbnail() ) {
    $thumb_id = get_post_thumbnail_id();
}

// Add template specific body class
add_filter( 'body_class', 'template_body_class' );
function template_body_class( $classes ) {
    // add 'class-name' to the $classes array
    $classes[] = 'single-post-listing-wide';
    // return the $classes array
    return $classes;
}

get_header();

// start the loop
while ( have_posts() ){
    the_post();

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
        }
    }

?>
<div class="row first-row">
  <div class="side col">
    <?php get_sidebar('listing'); ?>
  </div>
  <div class="main col">
    <div class="listing-wide-gallery">
      <div class="listing-wide-gallery__slides">
        <?php
        
        $index = 0;
        foreach ($attached_imgs as $img_data) {
	    $slide_img = $img_data->slide_img;
	    $thumb_image_url = $img_data->pager_img->url;
            
        ?>
          <div class="listing-wide-gallery__slide"
               data-thumb-image-url="<?php echo $thumb_image_url; ?>"
               data-hash="slide-<?php echo $index; ?>">
	    <img src="<?php echo $slide_img->url; ?>" width="<?php echo $slide_img->width; ?>" height="<?php echo $slide_img->height; ?>" />
          </div>
        <?php 
        
        $index++;
        } // end foreach
        
        ?>
      </div>
    </div>
    <script id="listing-wide-gallery-pager-template" type="text/x-handlebars-template">
      <div class="listing-wide-gallery__pager"></div>
    </script>
    <script id="listing-wide-gallery-pager-thumb-template" type="text/x-handlebars-template">
      <a class="listing-wide-gallery__thumb"
         href="#slide-{{index}}">
        <img src="{{src}}" alt="{{alt}}" />
      </a>
    </script>
  </div>
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

      } // endwhile; // end loop

      ?>
  </div><!-- .main .col -->
</div><!-- .row .last-row -->
<?php

get_footer();

?>
