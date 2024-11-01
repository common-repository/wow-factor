<?

// process the form

// process the form from the narrow signup box shown on video pages.  Just get the input details, and save as variables to show on this page.
if(isset($_POST['act']) ){			
			
			// empty variable to hold error messages, if any.
			$err = '';
			$msg = '';
			
			// process the form data
			if ( isset($_POST['WowFactor_video_page_slug']) && !empty($_POST['WowFactor_video_page_slug']) ) { 
				
				
				// check if slug already exists for another page
				$WowFactor_existing_slug_page_id = get_ID_by_slug( $_POST['WowFactor_video_page_slug'] );
				
				// if the slug is not being used...
				if( ! $WowFactor_existing_slug_page_id ) {
					
					// the desired slug is available. It does not exist already.
					
					// check if Wow Factor page already exists
					if( WOWFACTOR_PAGE_ID ) {
					
						// Wow Factor page already exists, but with a different slug.
						
						// update the slug of this existing Wow Factor page to the new slug.
					
						// create post update array
						$WowFactor_slug_update_array = array();
						$WowFactor_slug_update_array['ID'] = WOWFACTOR_PAGE_ID;
						$WowFactor_slug_update_array['post_name'] = $_POST['WowFactor_video_page_slug'];
					
						// update the database
						wp_update_post( $WowFactor_slug_update_array );
						
						// update the .htaccess rewrite rules with the new slug
   						WowFactorRewriteRules( $_POST['WowFactor_video_page_slug'] );
					
					} else {
					
						// the Wow Factor page does not exist.
						
						// create the new Wow Factor page.
    					$WowFactor_new_page_id = CreateNewWowFactorPage( $_POST['WowFactor_video_page_slug'] );
    				
    					// update the database with this value
    					update_option('WowFactor_video_page_id', $WowFactor_new_page_id, '', 'yes');
    					
					}
					
					
				} else {
					
					// a page ID exists for the desired slug.
					
					// the desired slug is already in use by an existing page.
					
					// double-check that it is not the Wow Factor page.
					if( WOWFACTOR_PAGE_ID != $WowFactor_existing_slug_page_id ) {
					
						// the desired slug belongs to an existing page (but not a Wow Factor page).
						
						// user needs to select a different slug.
						$err .= 'That video page name is already taken by <a target="_blank" href="' . get_permalink($WowFactor_existing_slug_page_id) . '">this page (click to view it)</a>. <br/><br/>
								You have 2 options:<br/><br/>
								1. Type something different in the video page box.<br/><br/>
								2. Delete the page or post that has the same setting.<br/><br/>
								3. If the page is already deleted it will be in the Trash. You need to empty the Trash.<br/><br/>
								';
					}
					
				}
				
			
			} else {
				$err .= 'There was a problem with the video page box. <br /><br />';
			}
			
			// save to session if no error
			if ( empty($err) || $err == '') {
								
				// show message
				$msg .= 'The setting was saved.<br><br><a href="' . WOWFACTOR_ADMIN_URL . '">Click here</a> to go back to the main admin page.';
				
			} else {
			
				// there was an error
				// send them to the form again to try again, and show the error message on that page
				$err .= 'The setting you typed was not saved.';
			}


}
	
// get slug for the new page. Eg, if you named your video page "Video Page", then your slug URI is: video-page
$WowFactor_video_page_slug = basename( get_permalink( WOWFACTOR_PAGE_ID ) );

// show an instruction video on how to set up the codes.
$WowFactor_youtube_video = 'http://www.youtube.com/v/n-eGvYcakwE';
				
// should we start playing the instruction video when the  page loads?  
// The user will only want to see it the first time.
// returns 0 to stop autoplay, false if empty (which means it has not been set yet and user has not seen the video)
$WowFactor_autoplay_instruction_video = 0;



// Headlines
$h1 = "Your Main Video Page.";
$h2 = "Change where you show your videos on your website.";

// show header
include_once('header.php');


// display error messages or success messages for the form submission
if( !empty($err) || !empty($msg) ) {
	
	// display error message
	if( !empty($err) ) {
		echo '<div class="error" style="padding:50px;"> ' . $err . '</div>';
	} 
	
	// display success message	
	if( !empty($msg) ) {
		echo '<div class="success" style="padding:50px;"> ' . $msg . '</div>';
	}
	
}

?>


	<div class="row_hero" style="margin: 80px 0 0;padding: 0 0 100px 0;">

		<div class="span-4 marginleft-1 marginright-1">
						
				&nbsp;


		</div>
		<div class="span-16">
					
			
<div id="member_signup_container_narrow">


  <form method="post" action="" enctype="multipart/form-data">
  	
  		
	<p style="margin-top:50px;">The website address where you want your videos to appear</p>
	
 	<div class="row">
		<div class="left_column">
			Main video page <span class="required">*</span>
		</div>
		<div class="right_column">
			<? echo site_url() ?> / <input style="width:50%;" type="text" name="WowFactor_video_page_slug" class="signup_input" <? if(isset($WowFactor_video_page_slug)) {echo 'value="' . $WowFactor_video_page_slug . '"'; } ?>>
		</div>
	</div>
	
 	<div class="row">
			<div class="submitbutton-green">
	    		<input type="submit" name="act" value="Save" />
			</div>
	</div>	
	
</form>  

</div><!-- end container -->
			
			
			
			
						
		</div>
	</div>

	<!-- clear banner settings -->
	<div class="clear"></div>



<?

// show footer
include_once('footer.php');

?>

