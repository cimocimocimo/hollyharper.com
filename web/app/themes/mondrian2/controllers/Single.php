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
        return $data;
    }

}