<?php

namespace App;

use Sober\Controller\Controller;

class listingData extends Controller 
{
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
        $this->mls = new \stdClass();
        $this->price = new \stdClass();
        $this->taxes = new \stdClass();
        $this->finished_area = new \stdClass();
        $this->lot_size = new \stdClass();
        $this->bed = new \stdClass();
        $this->bath = new \stdClass();
        $this->location = new \stdClass();
        $this->address = new \stdClass();
        $this->latitude = new \stdClass();
        $this->longitude = new \stdClass();
        
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
        $this->location = new \stdClass();
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
class listingMap extends Controller 
{
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