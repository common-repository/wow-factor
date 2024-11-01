<?
/*

This file is loaded only when the plugin is Activated for the first time.

It does these things:

1. Adds a rewrite rule so that the URLs domain.com/something/video/video-name  correctly load the right video from the Wow Factor API.

2. Creates a custom page type.

*/

function WowFactor_plugin_deactivate() {

    // Deactivation code starts here...
    
    
    ///////////////////////////////////////////////////////////////////////
    //
    // 		Wow Factor page
    //
    ///////////////////////////////////////////////////////////////////////
    
    
    // Remove Wow Factor pages
    
    	$WowFactorPageID = get_option('WowFactor_video_page_id');
    	
    	wp_delete_post( $WowFactorPageID, 'true');
    	
    	/*
    	
    	wp_delete_post( $postid, $force_delete );
    	
    	Removes a post, attachment, or page.

		When the post and page goes, everything that is tied to it is deleted also. 
		This includes comments, post meta fields, and relationships between the post and taxonomy terms. 
		
		 $force_delete  (bool) (optional) Whether to bypass trash and force deletion (added in WordPress 2.9).
		
    	*/
    
    
    
    // Remove Wow Factor template from the current theme
     
     
	
	
    ///////////////////////////////////////////////////////////////////////
    //
    // 		Database variables
    //
    ///////////////////////////////////////////////////////////////////////
    
	delete_option('WowFactor_API_code_1');
	delete_option('WowFactor_API_code_2');
	delete_option('WowFactor_auth_token');
	delete_option('WowFactor_video_page_id');
	delete_option('WowFactor_version');
	delete_option('WowFactor_autoplay_instruction_video');
	
}

?>