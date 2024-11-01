<?

// process the form

// process the form from the narrow signup box shown on video pages.  Just get the input details, and save as variables to show on this page.
if(isset($_POST['act']) ){			
			
			// empty variable to hold error messages, if any.
			$err = '';
			$msg = '';
			
			// process the form data
			if ( isset($_POST['WowFactor_API_code_1']) && !empty($_POST['WowFactor_API_code_1']) ) { 
				$WowFactor_API_code_1 = addslashes( $_POST['WowFactor_API_code_1'] );
				update_option('WowFactor_API_code_1', $WowFactor_API_code_1, '', 'yes'); // update the database with this value
			} else {
				$err .= 'There was a problem with Code 1. <br /><br />';
			}
			
			if ( isset($_POST['WowFactor_API_code_2']) && !empty($_POST['WowFactor_API_code_2']) ) { 
				$WowFactor_API_code_2 = addslashes( $_POST['WowFactor_API_code_2'] ); 
				update_option('WowFactor_API_code_2', $WowFactor_API_code_2, '', 'yes'); // update the database with this value
			} else {
				$err .= 'There was a problem with Code 2. <br /><br />';
			}
			
			
			// save to session if no error
			if ( empty($err) || $err == '') {
								
				// show message
				$msg .= 'The settings were saved.<br><br><a href="' . WOWFACTOR_ADMIN_URL . '">Click here</a> to go back to the main admin page.';
				
				// check for existence of the Wow Factor page.  Create one if it does not exist.	
				if( ! WOWFACTOR_PAGE_ID ) {
	
    				// create the new Wow Factor page.
    				$WOWFACTOR_PAGE_ID = CreateNewWowFactorPage();
    	
    				$WowFactor_video_page_url = WowFactorPageURL($WOWFACTOR_PAGE_ID);
	
				}
				
			} else {
			
				// there was an error
				// send them to the form again to try again, and show the error message on that page
				$err .= 'The settings were not saved.';
			}


}

	
// get current values for form boxes
$WowFactor_API_code_1 = get_option( 'WowFactor_API_code_1' );
$WowFactor_API_code_2 = get_option( 'WowFactor_API_code_2' );



// show an instruction video on how to set up the codes.
$WowFactor_youtube_video = 'http://www.youtube.com/v/n-eGvYcakwE';
				
// should we start playing the instruction video when the  page loads?  
// The user will only want to see it the first time.
// returns 0 to stop autoplay, false if empty (which means it has not been set yet and user has not seen the video)
$WowFactor_autoplay_instruction_video = 0;



// Headlines
$h1 = "Connect your website.";
$h2 = "Copy and paste the codes from your Wow Factor account.";

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


	<div class="row_hero" style="margin: 1em 0 0;padding: 0 0 100px 0;">

		<div class="span-4 marginleft-1 marginright-1">
						
				&nbsp;


		</div>
		<div class="span-16">
					
			<h3>All you have to do is:</h3> 
			<ol>
				<li><a href="<?= WOWFACTOR_URL ?>members/admin/api.php">Log in</a> to your Wow Factor account.</li>
				<li>Go to the admin section.</li>
				<li>Click the option to show your videos on your website.</li>
				<li>Click the &quot;Website Settings&quot; link.</li>
				<li>Copy and paste the 2 codes into the boxes below.</li>
			</ol>
			
			
				
	
<div id="member_signup_container_narrow">


  <form method="post" action="" enctype="multipart/form-data">
  	
  	<h3 class="paragraph_title">Copy and paste Code 1 and Code 2 here.</h3>
  	
 	<div class="row" style="margin-top:30px;">
		<div class="left_column">
			Code 1 <span class="required">*</span>
		</div>
		<div class="right_column">
			<input type="text" name="WowFactor_API_code_1" class="signup_input" <? if(isset($WowFactor_API_code_1)) {echo 'value="' . $WowFactor_API_code_1 . '"'; } ?>>
		</div>
	</div>	
	
 	<div class="row">
		<div class="left_column">
			Code 2 <span class="required">*</span>
		</div>
		<div class="right_column">
			<input type="text" name="WowFactor_API_code_2" class="signup_input" <? if(isset($WowFactor_API_code_2)) {echo 'value="' . $WowFactor_API_code_2 . '"'; } ?>>
		</div>
	</div>	
	
	<div class="row" style="margin-top:30px;"></div>
	
 	<div class="row">
			<div>
	    		<input class="submitbutton-green" type="submit" name="act" value="Save" />
			</div>
	</div>	
	
</form>  

</div><!-- end container -->
			
			
			
  			<h3 class="paragraph_title">Webmasters</h3>
  			<h4 class="quiet">If you look after this site for someone else...</h4>
			<p>Ask your client to:</p> 
			<ol>
				<li><a href="<?= WOWFACTOR_URL ?>members/admin/api.php">Log in</a> to their Wow Factor account.</li>
				<li>Go to the admin section.</li>
				<li>Click the option to show their videos on their website.</li>
				<li>Choose to send the codes by email to you (the webmaster).</li>
				<li>Type your email address into a box.</li>
			</ol>
			<p>Wow Factor will automatically create Code 1 and Code 2, and send them to your email address.</p>
			<p>Then you can copy and paste them into the boxes above.</p>
			<p>It might be a good idea to copy and paste those instructions and email them to the client.</p>
			
			
			
						
		</div>
	</div>

	<!-- clear settings -->
	<div class="clear"></div>



<?

// show footer
include_once('footer.php');

?>

