<? 
/* 
  Main admin page for WowFactor.io plugin
*/

$WowFactor_video_page_url = WowFactorPageURL();

// Headlines
$h1 = 'Wow Factor';
$h2 = 'Make videos on your mobile.<br>Show them here on your website.<br><span class="veryquiet">Automatically.</span>';


// if user has not saved their API codes yet, show an instruction video on how to set up the codes.
$WowFactor_youtube_video = 'http://www.youtube.com/v/n-eGvYcakwE';
				
// should we start playing the instruction video when the Admin page loads?  
// The user will only want to see it the first time.
// returns 0 to stop autoplay, false if empty (which means it has not been set yet and user has not seen the video)
$WowFactor_autoplay_instruction_video = get_option('WowFactor_autoplay_instruction_video');

// if autoplay is 1, then user has not seen the video, and it will start playing when this page loads for the first time.
if( $WowFactor_autoplay_instruction_video == 1) { 
	
	// set the autoplay option in the database to 0, so that on future page loads, the video does not start autoplaying.
	update_option('WowFactor_autoplay_instruction_video', '0');

}


// show header
include_once('header.php');



// check if user wants to disconnect from his WowFactor account
if( $_GET['disconnect'] == 'yes' ) {

	delete_option( 'WowFactor_API_code_1' );
	delete_option( 'WowFactor_API_code_2' );
	delete_option( 'WowFactor_auth_token' );
	
	// delete Wow Factor page
	wp_delete_post( WOWFACTOR_PAGE_ID, 'true' );
	
	/*
	 The true setting in wp_delete_post forces the page to be deleted instead of stored in trash.
	 
	 If the page is stored in trash, the slug (eg 'video') is still active when the user tries to choose 
	 the same slug in the future, eg 'video'
	
	*/
	
	// delete option
	delete_option( 'WowFactor_video_page_id' );
	
}


// If URL contains an auth-token, then the user is returning after authorizing their Wow Factor account.
if( $_GET['auth_token'] == get_option('WowFactor_auth_token') && isset($_GET['code1']) && isset($_GET['code2']) ) {
	
	// add the API credentials to the datbase 'options' table
	add_option( 'WowFactor_API_code_1', $_GET['code1'], '', 'yes' );
	add_option( 'WowFactor_API_code_2', $_GET['code2'], '', 'yes' );
	
	// check for existence of the Wow Factor page.  Create one if it does not exist.	
	if( ! WOWFACTOR_PAGE_ID ) {
	
    	// create the new Wow Factor page.
    	$WOWFACTOR_PAGE_ID = CreateNewWowFactorPage();
    	
    	$WowFactor_video_page_url = WowFactorPageURL($WOWFACTOR_PAGE_ID);
	
	}
	
}

// Check if API codes are saved in database
if( ! get_option( 'WowFactor_API_code_1' ) || ! get_option( 'WowFactor_API_code_2' ) ) {

	// page to return to after authorizing account with WowFactor.io
	$WowFactor_return_url = urlencode( WOWFACTOR_ADMIN_URL );

	// check if auth token already exists.  Create a new one if necessary
	if( ! get_option('WowFactor_auth_token') ) {
	
		// generate a temporary auth token
		$WowFactor_auth_token = urlencode( RandomString(20) );
	
		// save auth token to database
		update_option('WowFactor_auth_token', $WowFactor_auth_token);
		
	} else {
		
		$WowFactor_auth_token = get_option('WowFactor_auth_token');
	
	}
	
	// URL of the wordpress site
	$WowFactor_wordpress_url = site_url();
	
	// URL to send user to authorize this API connection
	/*
	$WowFactor_auth_url = 'http://test/api/test/auth.php?return_url=' . $WowFactor_return_url . '&auth_token=' . $WowFactor_auth_token
							. '&website=' . $WowFactor_wordpress_url;
	*/
	$WowFactor_auth_url = WOWFACTOR_URL . 'members/api_auth.php?return_url=' . $WowFactor_return_url 
							. '&auth_token=' . $WowFactor_auth_token
							. '&website=' . $WowFactor_wordpress_url;
	
	
	
	////////////////////////////////////////////////////////////////////////////////////////////
	/*

			Display Connection button HTML

	*/
	////////////////////////////////////////////////////////////////////////////////////////////


?>
	
	<div class="row_hero" style="margin: 2em 0 0;padding: 0 0 5em 0;">

		<div class="span-12 marginleft-2 marginright-1">


				<img src="<?= WOWFACTOR_API_URL ?>images/link_to_website.jpg" style="width:80%;">

			
		</div>
		<div class="span-8">
			
			<h2>Start here</h2>
		
			<p><a href="<?= $WowFactor_auth_url ?>">Click here to connect</a> Wow Factor to this Wordpress website.</p>
			<p>You'll need to log in or sign up at the Wow Factor website.</p>
			<p>Your videos from the mobile app will then show on this website automatically.</p>
			
			
			<h3 class="paragraph_title">Did not work?</h3>
			<p>If the process above does not work, follow the instructions <a href="?page=WowFactor&content=API_codes" id="webmaster_setup">here</a>.</p>
						
		</div>
	</div>

	<!-- clear banner settings -->
	<div class="clear"></div>

<?


} else {

	////////////////////////////////////////////////////////////////////////////////////////////
	/*

			Wordpress is CONNECTED to Wow Factor.
			
			Display HTML showing disconnect option, plus other info.

	*/
	////////////////////////////////////////////////////////////////////////////////////////////


	// if user has already set up their API codes, show a different video
	// $WowFactor_youtube_video = 'http://www.youtube.com/v/n-eGvYcakwE';

?>


	<div class="row_hero" style="margin: 0;padding: 0 0 100px 0;">

		<div class="span-8 marginleft-2 marginright-3">
				
			
			<h3>Your video page</h3>

			<p>Your videos will show on this page...</p>
			
			<p><a target="_blank" href="<?= $WowFactor_video_page_url ?>"><?= $WowFactor_video_page_url ?></a></p>
			



			<h3 class="paragraph_title">Settings</h3>
			
			<p><a href="?page=WowFactor&content=settings">Edit</a> the settings</p>
				
					
		</div>
		<div class="span-12">
		
			
			<h3>Status: <span class="green">connected</span></h3>
			
			<p>Your mobile phone can send videos <br>here to your Wordpress website.</p>
			
				<img src="<?= WOWFACTOR_API_URL ?>images/link_to_website.jpg" style="width:80%;">
				

		</div>
	</div>

	<!-- clear banner settings -->
	<div class="clear"></div>
	


<?

} // end  if( ! $WowFactor_API_code_1 || ! $WowFactor_API_code_2 ) {


////////////////////////////////////////////////////////////////////////////////////////////
/*

			Display other HTML

*/
////////////////////////////////////////////////////////////////////////////////////////////

?>	

	
			

	<div class="row_hero" style="margin:0;padding: 0 0 100px 0; text-align:center;">

		<h2>An example</h2>
	
			<p>Each video will appear on its own separate web page - kind of like how Youtube does it.</p>
			<p>Each web page will be created magically by the mobile app and this Wordpress plugin.</p>
			<p>All you have to do, is connect... and make videos on your mobile.</p>
		
		<img src="<?= WOWFACTOR_API_URL ?>images/send_to_website.jpg" style="width:80%;">
		
	</div>

	<!-- clear settings -->
	<div class="clear"></div>
	
	

	<div class="row_hero" style="margin: 80px 0 0;padding: 0 0 100px 0;">

		<div class="span-14" style="text-align:center;">
			<a target="_blank" href="<?= WOWFACTOR_APP_STORE_URL ?>">
				<img src="<?= WOWFACTOR_URL ?>images/logos/app_icon_200.jpg">
			</a>
			
		</div>
		<div class="span-8">
		
			<h2 style="margin:0 auto 30px;">Get the mobile app.</h2>
			<h2 style="margin:0 auto 30px;">It's called Wow Factor.</h2>
				
			<p class="verylarge">And it's FREE.</p>
			<p class="verylarge">Find it in the App Store.</p>
			
				
			
		</div>
	
		<!-- clear settings -->
		<div class="clear"></div>
		
		<div id="app_store_down_arrow">
			<img src="<?= WOWFACTOR_URL ?>images/arrow_big_horizontal.png">
		</div>
				
			
		<div id="app_store_button_main_page">
			<a target="_blank" href="<?= WOWFACTOR_APP_STORE_URL ?>">
				<img src="<?= WOWFACTOR_URL ?>images/app_store_button.png">
			</a>
		</div>
		
		
	</div>

	<!-- clear settings -->
	<div class="clear"></div>



<?

// show footer
include_once('footer.php');

?>

