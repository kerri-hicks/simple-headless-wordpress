<?php

// This script pulls page/post content from a WordPress instance using the WordPress REST API. It returns page data/metadata in JSON format. It is expected that you will have an external (non-WordPress) CSS file in your project that will be applied to the page.

// set default values to compose the RESTful URL -- this assumes your multisite is subdirectory-based, not subdomain-based
$wp_server_name = "server.com/" ;
$wp_instance_name = "multisite_root/" ; // where your WP is if it's not at the root, leave blank if it is at the root
$wp_site_name = "sitename" ;

$page_slug = $_REQUEST['page_slug'] ;
	if($page_slug == ''){
		$page_slug = "defaultpage" ;
	}

// compose URL
$url_to_json_content = "https://$wp_server_name$wp_instance_name$wp_site_name/wp-json/wp/v2/pages/?slug=$page_slug/" ;

// get the page contents (JSON), and convert it to a PHP array
$json_content = file_get_contents($url_to_json_content) ;
$page_content_array = json_decode($json_content, true) ;

// return the content on the page
$page_heading = $page_content_array[0]['title']['rendered'] ;
$html = $page_content_array[0]['content']['rendered'] ;

?>
<html>
<head>
	<title><?php echo $page_heading . ' - ' . $wp_site_name ; ?></title>
</head>
<body>

	<?php echo "<h1>" . $page_heading . "</h1>" . $html ; ?>

</body>
</html>
	
