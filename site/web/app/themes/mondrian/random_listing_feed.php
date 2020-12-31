<?php


function print_item($item){

    echo "    <item>\n";
    foreach ($item as $tag => $value){
        echo '        <' . $tag . '>' . $value . '</' . $tag . '>' . "\n";    
    }
    echo "    </item>\n";
}


// this array will hold all the product items for the data feed
$items = array();

// gather the data for creating the product entries

$listing_posts = get_posts(
        array(
            'category_name' => 'listings',
           	'post__in'  => get_option('sticky_posts'),
           	'orderby'	=>	'rand',
           	'posts_per_page' => -1,
        )
    );

// get the first listing

//print_r($listing_posts);

$listing_post = $listing_posts[0];

$listing = array();

// check for a post image, listings should all have images
if ( has_post_thumbnail($listing_post->ID) ) {
	$size = 'hollys-blog-photos';
	$image_id = get_post_thumbnail_id($listing_post->ID);
	$image_url = wp_get_attachment_image_src($image_id, $size);
	
	$listing['image_url'] = $image_url[0];
	
	$image = get_post($image_id);
	
	$listing['image_alt'] = trim(strip_tags( $image->post_excerpt ));
	$listing['image_title'] = trim(strip_tags( $image->post_title ));
}

$listing['title'] = get_the_title($listing_post->ID);
$price_array = get_post_meta($listing_post->ID, 'price');
$listing['price'] = $price_array[0];
$listing['url'] = $listing_post->guid;


// output the header of the feed

header('Content-Type: ' . feed_content_type('atom') . '; charset=' . get_option('blog_charset'), true);
header("Cache-Control: no-cache");
header("Pragma: no-cache");
header("Expires: -1");
echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>' . "\n";

?>
<feed xmlns="http://www.w3.org/2005/Atom" xmlns:g="http://base.google.com/ns/1.0">
    <title type="text">Products by StayDry Systems</title>
    <link rel="self" type="application/atom+xml" href="<?php self_link(); ?>" />
    <updated><?php echo mysql2date('Y-m-d\TH:i:s\Z', get_lastpostmodified('GMT'), false); ?></updated>
    <author>
        <name>John West &amp; Holly Harper Real Estate</name>
    </author>
    <id>http://www.hollyandjohn.ca/feed/random-listing/</id>
<?php

print_item($listing);

?>
</feed>