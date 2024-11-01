<?php
/*
config settings for plugin
*/


// WowFactor website URL
define('WOWFACTOR_URL','http://wowfactor.io/');

// WowFactor API URL
define('WOWFACTOR_API_URL','http://wowfactor.io/api/');

// URL to WowFactor mobile app in the App Store
define('WOWFACTOR_APP_STORE_URL','https://itunes.apple.com/app/id668513156?');


// plugin name
define('WOWFACTOR_PLUGIN_NAME','WowFactor');

// url to the plugin folder
define('WOWFACTOR_PLUGIN_URL', plugin_dir_url(__FILE__) );

// php path to plugin folder
define( 'WOWFACTOR_PLUGIN_PHP_PATH', plugin_dir_path( __FILE__ ) ); // this returns a path WITH A TRAILING SLASH

// include functions
include_once( WOWFACTOR_PLUGIN_PHP_PATH . 'functions.php');

// page ID
define('WOWFACTOR_PAGE_ID', get_option('WowFactor_video_page_id') );

// page link
/*
if( get_option('WowFactor_video_page_id') ) {
	define( 'WOWFACTOR_PAGE_URL', get_permalink(WOWFACTOR_PAGE_ID) );
}
*/

/*
 URL to the admin page.  This will be the site domain (domain.com), plus /wp-admin/admin.php?page=  
 and the name of the admin page (WowFactor)
 so the full URL of the admin page is something like:
 example: http://jobscrabble.com/wp-admin/admin.php?page=WowFactor
*/
define('WOWFACTOR_ADMIN_URL', admin_url() . 'admin.php?page=WowFactor' );

/*
Check the URI structure of this WP installation.

For example it may be any of:

1. http://wordpress/?p=123
2. http://wordpress/2013/07/23/sample-post/
3. http://wordpress/2013/07/sample-post/
4. http://wordpress/archives/123
5. http://wordpress/sample-post/

It could also be any other custom structure, which the user can create using these tags:

6. http://wordpress/%year%/%monthnum%/%day%/%postname%/%post_id%/%category%/%author%


The first case is easy, we just add on another variable for the required page_uri

http://wordpress/?p=123&page_uri=required-page-name-goes-here

The other cases require looking up the URI structure in the WP database, wp_options table, where option_name = rewrite_rules
The value of that database entry contains the code that interprets the URI structure.
We have to get that code, interpret the structure, then extract the Wow Factor page URI from the end of the WP URI structure

For example, we need the last bit of this URL:

http://wordpress/2013/07/23/video-page/

We want to extract the words "video-page" from the URL above.  That represents the URI of the page in the user's account at WowFactor.io

*/

?>