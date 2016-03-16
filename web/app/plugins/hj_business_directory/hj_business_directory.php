<?php
   /*
   Plugin Name: Holly & John Business Directory
   Plugin URI: http://cimolini.com
   Description: Custom plugin for adding a business directory to the website for Holly & John
   Version: 0.1
   Author: Aaron Cimolini
   Author URI: http://cimolini.com
   */

function add_hj_business_post_type() {
    $labels = array(
        'name'               => _x( 'Businesses', 'post type general name' ),
        'singular_name'      => _x( 'Business', 'post type singular name' ),
        'add_new'            => _x( 'Add New', 'business' ),
        'add_new_item'       => __( 'Add New Business' ),
        'edit_item'          => __( 'Edit Business' ),
        'new_item'           => __( 'New Business' ),
        'all_items'          => __( 'All Business' ),
        'view_item'          => __( 'View Business' ),
        'search_items'       => __( 'Search Businesses' ),
        'not_found'          => __( 'No businesses found' ),
        'not_found_in_trash' => __( 'No businesses found in the Trash' ),
        'parent_item_colon'  => '',
        'menu_name'          => 'Businesses'
    );

    $args = array(
        'labels'        => $labels,
        'description'   => 'Can either be a business or a person. ',
        'public'        => true,
        'menu_position' => 5,
        'hierarchical'  => true,
        'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes'),
        'has_archive'   => true,
        'rewrite'       => array('slug' => 'directory'),
        'taxonomies'    => array('hj_business_categories'),
    );

    register_post_type( 'hj_business', $args );
}

add_action('init', 'add_hj_business_post_type');



function hj_business_category_init() {
	// create a new taxonomy
	register_taxonomy(
        'hj_business_categories', // taxonomy name
        'hj_business',            // works with this post type.
		array(
			'label' => __( 'Business Categories' ),
            'hierarchical' => True,
            'show_admin_column' => True,
			'rewrite' => array(
                'slug' => 'business-category',
                'hierarchical'  => True,
            ),
            'sort' => True,
            
		)
	);
}
add_action( 'init', 'hj_business_category_init' );




?>
