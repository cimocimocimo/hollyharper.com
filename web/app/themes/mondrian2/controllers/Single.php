<?php

namespace App;

use Sober\Controller\Controller;

class Single extends Controller
{   
     /**
        * Return foo from Advanced Custom Fields
        *
        * @return array
        */

    
    public function old_single_post_data()
    {
        $data = [
            'slide_img_size' => 'slideshow-large',
            'pager_img_size' => 'slideshow-thumb'
        ];

        // check for a post thumbnail, all listings SHOULD have one. 
        if ( has_post_thumbnail() ) {
            $data['thumb_id'] = get_post_thumbnail_id();
        }

        return $data;
    }

    public static function old_single_post_in_loop_data()
    {
        $listing = new listingData();
        $loop_data = [
            'is_blog' => self::check_if_blog(),
            'listing' => $listing,
            'map' => new listingMap($listing->location())
        ];

        return $loop_data;
    }

    public static function check_if_blog()
    {
        $categories = get_the_category();
        
        foreach ($categories as $category) {
            // if it belongs to the blog category then we'll treat this post as a blog post type
            if ($category->slug == 'blog') {
                return true;
            }
        }
        return false;
    }

    public static function get_post_attachments()
    {
        global $post;
        $args = array(
            'post_type' => 'attachment',
            'numberposts' => -1,
            'post_status' => null,
            'post_parent' => $post->ID,
            'orderby'     => 'menu_order',
        ); 

        $attachments = get_posts($args);
        $images = self::get_post_images($attachments);
        $pdfs   = self::get_post_pdfs($attachments);

        $attachments_array = array(
            'images' => $images, 
            'pdfs'   => $pdfs
        );
        return $attachments_array;
    }

    public static function get_post_images($attachments)
    {
        $slide_img_size = 'slideshow-large';
        $pager_img_size = 'slideshow-thumb';
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
                $slide_img = new \stdClass();
                $slide_img->url = $slide_temp[0];
                $slide_img->width = $slide_temp[1];
                $slide_img->height = $slide_temp[2];		
                $attach->slide_img = $slide_img;
                
                
                $pager_temp = wp_get_attachment_image_src( $attach->ID, $pager_img_size );
                $pager_img = new \stdClass();
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
        return $attached_imgs;
    }

    public static function get_post_pdfs($attachments)
    {
        foreach ($attachments as $index => $attach){
            if ( $attach->post_mime_type == 'application/pdf' ) {
                $attached_pdfs[$attach->post_excerpt] = $attach;
            }
        }

        if(isset($attached_pdfs)) {
            return $attached_pdfs;
        }
    }
}