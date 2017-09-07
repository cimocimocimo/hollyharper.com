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
        $loop_data = [
            'is_blog' => self::check_if_blog()
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
}