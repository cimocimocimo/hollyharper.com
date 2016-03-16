<?php
/**
 * @package WordPress
 * @subpackage Mondrian
 */

/* this removes some stuff in the header I don't need for this theme
Only needed if you are publishing to the blog from Windows Live Writer
http://lancesjournal.com/remove-rel-edituri-and-rel-wlwmanifest-links/
*/
add_action('init', 'remheadlink');
function remheadlink() {
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
}

/* remove the meta generator tag from the header */
remove_action('wp_head', 'wp_generator');


remove_action( 'wp_head', 'index_rel_link' ); // index link
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // prev link
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // start link
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); // Display relational links for the posts adjacent to the current post.




// This theme uses wp_nav_menu() in one location.
register_nav_menus( array(
    'primary' => 'Main Navigation',
    'secondary' => 'Side Navigation',
    'tertiary' => 'Footer Navigation',
) );




function new_excerpt_length($length) {
    return 18;
}
add_filter('excerpt_length', 'new_excerpt_length');




  // These are modified functions for the new template system. They basically replace some of the wordpress functions that echo content to the screen by doing the same thing but returning it.

  // this function is to replace the_content()
function return_the_content($more_link_text = null, $stripteaser = 0) {
  $content = get_the_content($more_link_text, $stripteaser);
  $content = apply_filters('the_content', $content);
  $content = str_replace(']]>', ']]&gt;', $content);
  return $content;
}

// replaces post_class()
function return_post_class( $class = '', $post_id = null ) {
  // Separates classes with a single space, collates classes for post DIV
  return 'class="' . join( ' ', get_post_class( $class, $post_id ) ) . '"';
}


if ( function_exists( 'add_theme_support' ) ) {
  add_theme_support( 'post-thumbnails' );
}


if ( function_exists('register_sidebar') ) {
    register_sidebar(array(
        'id' => 'sidebar-1',
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));
}


/*
 * Fix the extra 10 pixel width issue for image captions
 * http://wordpress.org/support/topic/234109
 */

add_shortcode('wp_caption', 'fixed_img_caption_shortcode');
add_shortcode('caption', 'fixed_img_caption_shortcode');

function fixed_img_caption_shortcode($attr, $content = null) {
  
  // Allow plugins/themes to override the default caption template.
  $output = apply_filters('img_caption_shortcode', '', $attr, $content);
  if ( $output != '' ) return $output;

  extract(shortcode_atts(array(
                   'id'=> '',
                   'align'=> 'alignnone',
                   'width'=> '',
                   'caption' => ''), $attr));

  if ( $id ) $id = 'id="' . esc_attr($id) . '" ';
    return '<div ' . $id . 'class="wp-caption ' . esc_attr($align)
    . '" style="width: ' . ((int) $width) . 'px">'
    . do_shortcode( $content ) . '<p class="wp-caption-text">'
    . $caption . '</p></div>';
}


/*
 * This function enables Yoast simple-taxonomies to display where I want the list
 * http://wordpress.org/support/topic/284217?replies=12
 */

function show_taxonomies_here() {
  global $post;
  $opt  = get_option('yoast_simpletax');
  $output = '';
  foreach ( $opt['taxonomies'] as $taxonomy ) {
  
  echo $taxonomy['name'];
  
  
    if ( $terms = get_the_terms( $post->ID, $taxonomy['name']) ) {
      $output .= '<dt>' . $taxonomy['label'] . '</dt>';
      $output .= '<ul class="' . $taxonomy['name'] . '">';
      foreach ( $terms as $term ) {
    $output .= '<li class="feature">' . $term->name . '</li>';
      }
      $output .= '</ul>';
    }
  }
  if ($output) return '<dl class="feature-list">' . "\n" . $output . "\n" . '</dl>';
}


function show_interior_features() {
    global $post;

    $int_features = get_the_terms( $post->ID, 'interior-features');
    if ( is_array($int_features) ) {
      $output .= '<dt>Interior Features</dt>';
      $output .= '<ul class="interior-features">';
      foreach ( $int_features as $feature ) {
            $output .= '<li class="feature">' . $feature->name . '</li>';
      }
      $output .= '</ul>';
        echo '<dl class="interior-features feature-list">' . "\n" . $output . "\n" . '</dl>';
    }
}



function show_lot_features() {
    global $post;
    
    $lot_features = get_the_terms( $post->ID, 'lot-features');
    if ( is_array($lot_features) ) {
        $output = '';
      $output .= '<dt>Lot Features</dt>';
      $output .= '<ul class="lot-features">';
      foreach ( $lot_features as $feature ) {
          if (isset($feature->name)){
            $output .= '<li class="feature">' . $feature->name . '</li>';
          }
      }
      $output .= '</ul>';
        echo '<dl class="lot-features feature-list">' . "\n" . $output . "\n" . '</dl>';
    }
}




class listingData {

    public $mls;
    public $price;
    public $taxes;
    public $finished_area;
    public $lot_size;
    public $bed;
    public $bath;
    
    private $location;
    private $address;
    private $latitude;
    private $longitude;
    
    function __construct() {
        global $post;
        
        $custom_fields = get_post_custom($post->ID);
        
        // init these as objects
        $this->mls = new stdClass();
        $this->price = new stdClass();
        $this->taxes = new stdClass();
        $this->finished_area = new stdClass();
        $this->lot_size = new stdClass();
        $this->bed = new stdClass();
        $this->bath = new stdClass();
        $this->location = new stdClass();
        $this->address = new stdClass();
        $this->latitude = new stdClass();
        $this->longitude = new stdClass();
        
        foreach ( $custom_fields as $key => $val ) {
        
            switch ($key)
            {
                case 'mls-number':
                    //
                    $this->mls->data = $val[0];	
                    $this->mls->label = 'MLS Number';	    		
                    break;
        
                case 'taxes':
                    //code
                    $this->taxes->data = '$' . $val[0];
                    $this->taxes->label = 'Taxes';
                    break;
                
                case 'finished-square-feet':
                    //code
                    $this->finished_area->data = $val[0] . ' sq. ft.';
                    $this->finished_area->label = 'Finished Area';
                    break;
                
                case 'lot-square-feet':
                    //code
                    $this->lot_size->data = $val[0] . ' sq. ft.';
                    $this->lot_size->label = 'Lot Size';
                    break;
                
                case 'bedrooms':
                    $this->bed->data = $val[0];
                    $this->bed->label = 'Bedrooms';
                    //code
                    break;
                
                case 'bathrooms':
                    //code
                    $this->bath->data = $val[0];
                    $this->bath->label = 'Bathrooms';
                    break;
        
                case 'price':
                    //code
                    $this->price->data = '$' . $val[0];
                    $this->price->label = 'Price';
                    break;
                case 'address':
                    //code
                    $this->address->data = $val[0];
                    $this->address->label = 'Address';
                    break;
                case 'latitude':
                    //code
                    $this->latitude->data = $val[0];
                    $this->latitude->label = 'Latitude';
                    break;
                case 'longitude':
                    //code
                    $this->longitude->data = $val[0];
                    $this->longitude->label = 'Longitude';
                    break;
                default:
                    //code
                    break;
            } // end switch

        } // end foreach
        
        // build the location object
        $this->location = new stdClass();
        if ( $this->address ) {
            $this->location->address = $this->address;
        }
        if ( $this->latitude && $this->longitude ) {
            $this->location->latitude = $this->latitude;
            $this->location->longitude = $this->longitude;
        }
        
	} // end __construct()

    function location() {        
        return $this->location;
    }

}


// this outputs the html nessessary to embed a map for the listing into the listing page.
class listingMap {

    public $address;
    public $latitude;
    public $longitude;
    
    var $google_maps_static_url_base = 'http://maps.google.com/maps/api/staticmap?';

    function __construct( $loc ){
        if ($loc->address) {
            $this->address = $loc->address;
        }
        if ($loc->latitude && $loc->longitude) {
            $this->latitude = $loc->latitude;
            $this->longitude = $loc->longitude;
        }
    } // end __construct()
    
    public function static_map_img(){

        $map_img_src = $this->static_map_url();
        $img_tag = '<img class="map" src="%s" height="259" width="259" alt="Google map image of the property" title="Click to zoom in" />';
        
        $img_html = sprintf($img_tag, $map_img_src);

        $link_tag = '<a href="%s" target="_blank">%s</a>';
        $url_base = 'http://maps.google.com';

        // build the query string for the google maps
        $query = '?';
        if ($this->address->data) {
            $query .= 'q=' . urlencode($this->address->data);
        } elseif ($this->latitude && $this->longitude) {
            $encoded_latlon_pair = urlencode($this->latitude->data) . ',' . urlencode($this->longitude->data);
            $query .= 'q=' . $encoded_latlon_pair . '&';
            $query .= 'll=' . $encoded_latlon_pair;
        }
        $query .= '&z=16';
        $href = $url_base . $query;
        $link_img_html = sprintf($link_tag, $href, $img_html);


        return $link_img_html;
    } // static_map_img()
    
    public function static_map_url(){
        /* example url to return http://maps.google.com/maps/api/staticmap?center=Brooklyn+Bridge,New+York,NY&zoom=14&size=512x512&maptype=roadmap
        &markers=color:blue|label:S|40.702147,-74.015794&markers=color:green|label:G|40.711614,-74.012318
        &markers=color:red|color:red|label:C|40.718217,-73.998284&sensor=false
        */
        
        $url = '';
        $url_base = $this->google_maps_static_url_base;

        $default_params = array(
                // can be "lat,lon" or a location string
                // required only if markers are not present
                'center' => 'victoria, bc, canada',
                // 0 to show the entire world, 21 to show individual buildings
                // required only if markers are not present
                'zoom' => 16,
                // WIDTHxHEIGHT, pixel units, eg. 500x400, this would return an img 500px high by 400px wide
                // required
                'size' => '259x259',
                'format' => 'PNG',
                'maptype' => 'hybrid',
                // required
                'sensor' => 'false',
            );
        
        $url = $url_base;
        
        $params = $default_params;
        if ($this->address) {
            $params['center'] = $this->address->data;
            $params['markers'] = 'color:blue|' . $this->address->data;
        } elseif ($this->latitude && $this->longitude) {
            $params['center'] = $this->latitude->data . ',' . $this->longitude->data;
            $params['markers'] = 'color:blue|' . $this->latitude->data . ',' . $this->longitude->data;
        }
            
        $numb_of_params = count($params);
        foreach ($params as $param => $value)
        {
            $url .=  $param . '=' . urlencode($value);
            $numb_of_params--;
            if ( $numb_of_params > 0 ) {
                $url .= '&';
            }
        }
        
        return $url;
    }
}

function random_listing_feed_setup()
{
    load_template( TEMPLATEPATH . '/random_listing_feed.php');
}

add_action('do_feed_random-listing', 'random_listing_feed_setup', 10, 1);

function custom_feed_rewrite($wp_rewrite) {
    $feed_rules = array(
        'feed/(.+)' => 'index.php?feed=' . $wp_rewrite->preg_index(1),
        '(.+).xml' => 'index.php?feed='. $wp_rewrite->preg_index(1)
    );
    $wp_rewrite->rules = $feed_rules + $wp_rewrite->rules;
}
add_filter('generate_rewrite_rules', 'custom_feed_rewrite');



?>
