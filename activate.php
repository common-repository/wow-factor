<?
/*

This file is loaded only when the plugin is Activated for the first time.

It does these things:

1. Adds a rewrite rule so that the URLs domain.com/something/video/video-name  correctly load the right video from the Wow Factor API.

2. Creates a custom page type.

*/

function WowFactor_plugin_activate() {

    // Activation code starts here...
    
    
    ///////////////////////////////////////////////////////////////////////
    //
    // 		Step 1:  Wow Factor page
    //
    ///////////////////////////////////////////////////////////////////////
    
    // create the new Wow Factor page.
    $WOWFACTOR_PAGE_ID = CreateNewWowFactorPage();

    
	
    ///////////////////////////////////////////////////////////////////////
    //
    // 		Step 2:  Database variables
    //
    ///////////////////////////////////////////////////////////////////////
    
    // save the ID of the Wow Factor page.  This is used to override the page template in plugin.php
    update_option('WowFactor_video_page_id', $WOWFACTOR_PAGE_ID);
    
    // plugin version number
	update_option('WowFactor_version', '1.0.0');
	
	// autoplay the Youtube instruction video on page load of Admin page
	update_option('WowFactor_autoplay_instruction_video', '1', '', 'no');
	
}

?>