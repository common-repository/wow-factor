<?
/*
This code gets the actual HTML from our database.

It then displays the HTML.

To use this file, simple include this file wherever you want it to appear on your site.

Example include command using PHP:

<? include_once('get_page.php'); ?>

*/

// load config
require_once("_config.php");
	
	
$args = array();

// Add the Wordpress site url.
// This domain or subdomain must be listed in the WowFactor account as authorized to display the account's videos.
$args['website'] = site_url();

// Add the video template page url, so we can construct links on the page that lead to your other video pages.
// For example, there might be links on this page to 4 other related videos belonging to the same WowFactor account.
$args['video_page_url']	= WowFactorPageURL();

// Add the Youtube video size that you want
$args['Youtube_Video_Width'] 	= 560;
$args['Youtube_Video_Height'] 	= 420;
	
// Add the API codes (code1 and code2) that are unique to your account.
$args["code1"] 		= $WowFactor_API_code_1;
$args["code2"] 		= $WowFactor_API_code_2;

// which page do you want to show?  Get it from the URL that the user typed into the browser.
// Documentation: http://codex.wordpress.org/Custom_Queries
// Also see: in file plugin.php, function add_WowFactor_GET_variables( $qvars )
global $wp_query;
if(isset($wp_query->query_vars['page_uri'])) {
	$args["page"] = urldecode($wp_query->query_vars['page_uri']); // eg, http://your-site.com/video-template-page/individual-video-name
} else {
	$args["page"] = $_GET['page_uri']; // eg, http://your-site.com/?page_id=2&page_uri=video-name
}

// get the HTML from the WowFactor.io
$url = sprintf("%s?%s", $url, build_WowFactor_query($args));

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$page_html = curl_exec($ch);

// close the handle
curl_close($ch);

// if there is no page_uri requested, then we are not looking at an individual video page
// We are looking at the total list of videos
// Display the title of this page, set in Wordpress pages
if( empty( $args["page"] ) ) {
	echo '<h1 class="entry-title">';
	echo the_title();
	echo '</h1>';
}


// display the HTML
echo $page_html;
	    	
?>