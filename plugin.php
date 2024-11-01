<?php
/**
 * @package Wow Factor
 * @version 1.0
 */
/*
Plugin Name: Wow Factor
Plugin URI: http://WowFactor.io
Description: <strong>Wow Factor is the mobile app that creates awesome videos and displays them on your Wordpress website automatically. </strong> It also adds your videos to massively popular websites to increase your marketing and audience size - like Youtube, Facebook, LinkedIn, Twitter, Google and Yahoo.  All the videos on those sites have links under them that point back to your Wordpress site, leading video watchers to come visit your main site after watching your video.
Author: WowFactor
Version: 1.0
Author URI: http://WowFactor.io
*/

// load config
include_once('config.php');

// get API codes, if saved in database
$WowFactor_API_code_1 = get_option('WowFactor_API_code_1');
$WowFactor_API_code_2 = get_option('WowFactor_API_code_2');


///////////////////////////////////////////////////////////////////////
//
// 		Public Pages
//
///////////////////////////////////////////////////////////////////////
    
// Add the new $_GET variable to WP list of $_GET variables allowed through htaccess 'fancy' URL redirects
function add_WowFactor_GET_variables( $qvars ) {
	
	
	WowFactor_RefreshPlugin();
	
	
	$qvars[] = 'page_uri'; // $_GET['page_uri'] is required by the API to get your video content from Wow Factor
	return $qvars;
	
}   
add_filter('query_vars', 'add_WowFactor_GET_variables');
	

// Loading the page template from the plugin
// DOCUMENTATION FROM: http://codex.wordpress.org/Plugin_API/Action_Reference/template_redirect

function WowFactorPageTemplate() {

	if( is_page( WOWFACTOR_PAGE_ID ) )
    {
        include( WOWFACTOR_PLUGIN_PHP_PATH . 'page_template.php' );
        exit();
    }

}
add_action( 'template_redirect', 'WowFactorPageTemplate', 1 );




///////////////////////////////////////////////////////////////////////
//
// 		Changes like Wordpress Update, permalink structure change.
//
///////////////////////////////////////////////////////////////////////

// Refresh the plugin if Wordpress has been Updated. Otherwise it breaks the rewrite_rules.
// Or you change your permalink structure.
//add_action( 'template_redirect', 'WowFactor_RefreshPlugin', 1 );


///////////////////////////////////////////////////////////////////////
//
// 		Admin Pages
//
///////////////////////////////////////////////////////////////////////

// add the WP admin menu link to the WP menu
add_action('admin_menu', 'WowFactor_admin');


function WowFactor_admin() {  
  
  // add the link in the admin menu
  add_menu_page( 'Wow Factor', 'Wow Factor',  'manage_options', 'WowFactor', 'WowFactor_admin_HTML', WOWFACTOR_PLUGIN_URL . '/images/icon_16x16.png', 99.0145 );
	
}  

function WowFactor_admin_HTML() {  
	
	if( $_GET['content'] == 'API_codes' ) {
		// include the webmaster setup page HTML
		include( WOWFACTOR_PLUGIN_PHP_PATH . '/api_codes.php');
	} elseif( $_GET['content'] == 'change_url' ) {
		// include the webmaster setup page HTML
		include( WOWFACTOR_PLUGIN_PHP_PATH . '/edit_url.php');
	} elseif( $_GET['content'] == 'disconnect' ) {
		// include the webmaster setup page HTML
		include( WOWFACTOR_PLUGIN_PHP_PATH . '/disconnect_account.php');
	} elseif( $_GET['content'] == 'settings' ) {
		// include the webmaster setup page HTML
		include( WOWFACTOR_PLUGIN_PHP_PATH . '/settings.php');
	} else {
		// include the main Admin page HTML
		include( WOWFACTOR_PLUGIN_PHP_PATH . '/admin.php');
	}
} 


// Add settings link on plugin page
function WowFactor_settings_link($links) { 
  $settings_link = '<a href="admin.php?page=' . WOWFACTOR_PLUGIN_NAME . '">Settings</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}
 
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'WowFactor_settings_link' );

///////////////////////////////////////////////////////////////////////
//
// 		Activation
//
///////////////////////////////////////////////////////////////////////

// When plugin is Activated, do this one-time function to set up database, htaccess redirects.
include_once('activate.php');
register_activation_hook( __FILE__, 'WowFactor_plugin_activate' );


///////////////////////////////////////////////////////////////////////
//
// 		Deactivation
//
///////////////////////////////////////////////////////////////////////

include_once('deactivate.php');
register_deactivation_hook( __FILE__, 'WowFactor_plugin_deactivate');
?>
