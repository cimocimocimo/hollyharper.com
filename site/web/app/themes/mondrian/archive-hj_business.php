<?php
/**
 * @package WordPress
 * @subpackage Mondrian 0.1
 */
  get_header();
  
?>
<div class="row last-row">
	<div class="side col">
        &nbsp;
	</div><!-- .side .col -->
	<div class="main col">
        <h2>Business Directory</h2>
        <p>Here you can find a number of businesses that can help you with either selling or buying a new home. If you would like to be included in this directory then please <a href="/contact/">contact us.</a></p>
        <div id="directory-index">
            <?php
              
              // get an array of the categories with posts in them.
              $args = array(
                  'hide_empty'    => true, 
              );
              $categories = get_terms( 'hj_business_categories', $args );

              // run wp_querey to get the posts in each category.
              $businesses_by_category = array();
              foreach($categories as $cat) {
                  $args = array(
                      'post_type' => 'hj_business',
                      'hj_business_categories' => $cat->name,
                  );
                  $query  = new WP_Query( $args );
                  array_push($businesses_by_category, $query);
              }

              foreach($businesses_by_category as $cat) {
                  $cat_name = $cat->query['hj_business_categories'];

            ?>
            <div class="block">
                <h3><?php echo $cat_name; ?></h3>
                <ul>
                    <?php

                      foreach( $cat->posts as $business) {

                          $business_name = $business->post_title;
                          $business_href = get_permalink($business->ID);

                    ?>
                    <li><a href="<?php echo $business_href; ?>"><?php echo $business_name; ?></a></li>
                    <?php

                      } // end foreach

                    ?>
                </ul>
            </div>
            <?php

              } // end foreach

            ?>
        </div>
        
	</div><!-- .main .col -->
</div><!-- .row .last-row -->

<?php get_footer(); ?>

