<?php

// OVERVIEW: This script pulls page/post content from a WordPress instance using the WordPress REST API. It returns page data/metadata in JSON format. It is expected that you will have an external (non-WordPress) CSS file in your project that will be applied to the page

// get the filename of the file that this script is included in, and strip off the PHP extension
$this_file = basename($_SERVER['SCRIPT_FILENAME']); 
$this_file = preg_replace('/\.php$/', '', $this_file) ; 

// get the path of the file that this script is included in, and strip off the non-Apache parts of the path
$path = realpath('') ;
$path = preg_replace('/\/var\/www\/html\//', '', $path) ; 

// set default values to compose the RESTful URL from a WP multisite installation
$wp_server_name = "yoursite.yourdomain.com" ;
$wp_instance_name = "yourWPmulitsiteTopDirectory" ;
$wp_site_name = "yourWPmultisiteSite" ;

// if there are no slug parameters passed, get the path and filename, and find the WordPress item with that slug
	$page_slug = $path . '-' . $this_file ;

// compose URL
$url_to_json_content = "https://$wp_server_name/$wp_instance_name/$wp_site_name/wp-json/wp/v2/pages/?slug=$page_slug" ;

// get the page contents (JSON), and convert it to a PHP array
$json_content = file_get_contents($url_to_json_content) ;
$page_content_array = json_decode($json_content, true) ;

// return the content on the page
$page_heading = $page_content_array[0]['title']['rendered'] ;
$html = $page_content_array[0]['content']['rendered'] ;

echo "<h2 style=\"font-size : 2.8rem ; margin-bottom : 9px ; color : #917673 ; font-weight : bold ;
    line-height : 1.25 ; \">$page_heading</h2><hr />" ;
echo $html ; 

?>
