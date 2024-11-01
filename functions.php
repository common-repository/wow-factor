<?
// Functions for WowFactor.io plugin


function form_data($value){
	if(get_magic_quotes_gpc()){
		return stripslashes($value);
	}else{
		return $value;
	}
}

function alphanumericstring($string) {
$new_string = ereg_replace("[^A-Za-z0-9]", "", $string);
return $new_string;
}

function decimalnumericstring($string) {
$new_string = ereg_replace("[^0-9.]", "", $string);
return $new_string;
}

function createshorturl($string) {
$string = strtolower($string);
$new_string = ereg_replace("[^A-Za-z0-9]", "-", $string);
return $new_string;
}

function RandomString($length =12) {
    // makes a random alpha numeric string of a given lenth
    $aZ09 = array_merge(range('A', 'Z'), range('a', 'z'),range(0, 9));
    $out ='';
    for($c=0;$c < $length;$c++) {
       $out .= $aZ09[mt_rand(0,count($aZ09)-1)];
    }
    return $out;
} 

function CreateNewWowFactorPage( $page_slug = '' ) {
	
	if( empty( $page_slug ) ) {
		$page_slug = 'video'; // default slug
	}
	
	// check for unique slug.  Adjust slug if necessary by adding number on the end, eg slug-2, slug-3, etc.
    $page_slug = WowFactorUniquePageSlug($page_slug);
    
    // Create a new category called 'video' if it does not already exist
    
    // Check if category 'video' already exists.
    $category_slug		= 'video';
    $video_category_id 	= get_category_by_slug( $category_slug ); // returns category id
    
    if( empty($video_category_id) ) {
    
    	// Category 'video' does not exist.  Create it.
	    wp_create_category( $category_slug );
	    
	    // Get category id
	    $video_category_id 	= get_category_by_slug( $category_slug );
    }
    
    
    
    // Create a new page to display Wow Factor videos
    
    // set the new page variables
    $new_post = array(
		'post_title' 	=> 'Videos',
		'post_content' 	=> '',		// no content required in the WP database. The page will display content pulled from Wow Factor API.
		'post_status' 	=> 'publish',
		'post_type' 	=> 'page',
		'post_name'     => $page_slug, // The name (slug) for your post
		'post_category' => array($video_category_id), 		// add the 'video' category that we created (or that already existed)
		'tags_input' 	=> array('video', 'videos','youtube'), 	// add some tags to this page relating to video
		'comment_status' => 'closed' // 'closed' means no comments.
	);
 	
 	// insert the page.  This returns the new page ID.
	$WOWFACTOR_PAGE_ID = wp_insert_post($new_post);
	
	// save the ID of the Wow Factor page.  This is used to override the page template in plugin.php
    update_option('WowFactor_video_page_id', $WOWFACTOR_PAGE_ID);
    
    // Re-define WOWFACTOR_PAGE_ID to the new page id.
    define('WOWFACTOR_PAGE_ID', $WOWFACTOR_PAGE_ID );
    
    // update the .htaccess rewrite rules with the new slug
    WowFactorRewriteRules($page_slug);
	
	// return the ID of this new page
	return $WOWFACTOR_PAGE_ID;
	
}

function WowFactorUniquePageSlug($page_slug) {
	
	$original_page_slug = $page_slug;
	
	// do a loop for different url codes until we have a unique URL code for this page.
	$unique_url_code = "no";
	$number = 2;
	while ($unique_url_code == "no" ) {
	
		$slug_page_id = get_ID_by_slug($page_slug);
		
		if( $slug_page_id ) { // page already exists for this slug
 		
 			$page_slug = $original_page_slug . '-' . $number; // add number to end of slug, and try again.
		
			$number++;
			
			$unique_url_code = "no";
		
		} else { // unique code is available.
		
			$unique_url_code = "yes";

		}
	}
	
	return $page_slug;
	
}

function get_ID_by_slug($page_slug) {

		
	/*
	// is the existing page an active page, or trashed, draft, etc?
	$q = mysql_query("SELECT ID FROM wp_posts WHERE post_name = '$page_slug' AND post_status = 'publish' LIMIT 1");
	
	if(mysql_num_rows($q)==1){
		$r = mysql_fetch_assoc($q);
		return $r['ID']; // return the WP page id for this slug
	} else {
		return null; // no matching slug found
	}
	*/
		
	$page = get_page_by_path($page_slug);    //   TO DO IN FUTURE.  THIS LOOKS UP TRASHED PAGES SO SLUG IS NOT AVAILABLE
	
	if( $page ) {
	
		// this page is active.  Return the page id.
		return $page->ID;
		
	} else {
		return null;
	}
	
}

function WowFactorPageURL( $page_id = WOWFACTOR_PAGE_ID ) {
	
	// first, get the slug
	$slug_uri = WowFactorPageSlug( $page_id );
	
	// INSTRUCTIONS:
	// check if there are rewrite rules.  This means the user is using a custom htaccess redirect, such as:
	// domain.com/video/slug
	// If no rewrite rules, they are using the default URL structure, such as:
	// domain.com/?page_id=7
	
	// Get the current .htaccess rewrite rules
    $rules = get_option( 'rewrite_rules' );
    
    // Check if there is a redirect already for the video page
    if ( isset( $rules['^' . $slug_uri . '/([^/]+)/?$'] ) ) {
			
		// Rewrite rule exists.
		// Custom URL structure.
		// Create matching URL
		// Eg,  domain.com/wordpress/slug/
		$url = site_url() . '/' . $slug_uri . '/';  // trailing slash.
		return $url;
	   	
    } else {
    	
    	// Default URL structure.
    	// Create matching URL.
    	// Eg, domain.com/?page_id=7&page_uri=
    	$url = get_permalink( $page_id ) . '&page_uri=';
    	return $url;
    }
}


function WowFactorPageSlug( $WOWFACTOR_PAGE_ID ) {
	
	$WowFactor_page_array = get_post( $WOWFACTOR_PAGE_ID );
	$slug_uri = $WowFactor_page_array->post_name;
	
	return $slug_uri;
}


function WowFactorRewriteRules($slug_uri) {
	
	// Wordpress converts all slugs to lowercase, so make this slug lowercase before creating rewrite rule
	$slug_uri = strtolower($slug_uri);

	// Get the current .htaccess rewrite rules
    $rules = get_option( 'rewrite_rules' );
    
    // Check if there is a redirect already for the video page
    if ( ! isset( $rules['^' . $slug_uri . '/([^/]+)/?$'] ) ) {
			
		// Rewrite rule does not exist.  Add it.
		// add a rule to check for a match for the "slug" in the URL, followed by a /
		// Eg, if the page's slug is: "video-page", then check for "video-page" in the URL, followed by a /
		// whatever comes after the / is the name of the individual video page that we need for the page URI.
		add_rewrite_rule('^' . $slug_uri . '/([^/]+)/?$', 'index.php?pagename=' . $slug_uri . '&page_uri=$matches[1]', 'top' );
			
		// flush the rules to force a database save of the new rules.
		global $wp_rewrite;
	   	$wp_rewrite->flush_rules();
	   	
    }
    
}

function WowFactor_RefreshPlugin() {

	// compare current Wordpress version to the Wordpress version that WowFactor plugin has been installed on.
	if( get_bloginfo( 'version' ) != get_option( 'WowFactor_WP_version' ) ) {
		
		$WowFactor_version_mismatch = true;
		
	}
	
	// compare current Wordpress permalink structure to the permalink structure that WowFactor plugin has been using.
	if( get_option( 'permalink_structure' ) != get_option( 'WowFactor_permalink_structure' ) ) {
		
		$WowFactor_permalink_mismatch = true;
		
	}
	
		
	if( $WowFactor_permalink_mismatch || $WowFactor_version_mismatch ) {
	
		
		// Either Wordpress has been updated recently, or the permalink structure has changed. 
		
		// Most likely, the rewrite rules for WowFactor are currently wrong, and need updating.
		
		// Check if Permalink structure is empty or has a value. 
		// If empty, it is default structure, and does not require rewrite_rules.  
		// If not empty, it is custom and requires rewrite_rules.
		if( get_option( 'permalink_structure' ) ) {
			
			// You have a custom Permalink structure, like %postname%
			// We have to re-create the rewrite rules for WowFactor.
		
			// get the WowFactor page slug using the page_id set in config (and stored in the database already)
			$slug_uri = WowFactorPageSlug( WOWFACTOR_PAGE_ID );
		
			// update the rewrite rules to redirect URL requests with the page slug in them.
			WowFactorRewriteRules($slug_uri);
    
		}
		
	} 
	
	
	// Tell the database WowFactor has been updated to the latest version of Wordpress.
	update_option( 'WowFactor_WP_version', get_bloginfo( 'version' ) );
	update_option( 'WowFactor_permalink_structure', get_option( 'permalink_structure' ) );
	
}

?>