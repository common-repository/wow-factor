<?
/* 
  Settings page for WowFactor.io plugin
*/


$WowFactor_video_page_url = WowFactorPageURL();


// Headlines
$h1 = "Settings";
$h2 = "";

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
					
			<h3>Your video page</h3> 

<?
if( ! empty( $WowFactor_video_page_url ) ) {

	echo '
			<p>Your videos will show on this page...</p>
			
			<p><a target="_blank" href="' . $WowFactor_video_page_url . '">' . $WowFactor_video_page_url . '</a></p>
		';

	// if user has pretty permalinks, show the option to update the name of the page
	if( get_option('rewrite_rules') ) {
	
		echo '
			<p><a href="?page=WowFactor&content=change_url">Edit</a></p>
			';
	}
	
} else {
	
	// User has not connected the plugin to their Wow Factor account yet. So no video page has been made.	
	echo '
			<p>You need to <a href="?page=WowFactor">connect</a> to your Wow Factor account first.</p>
			
			<p>Then you will see a link to the page where your videos will appear.</p>
		';
}
?>
				
			<h3 class="paragraph_title">Codes</h3> 

			<p><a href="?page=WowFactor&content=API_codes">Edit the codes</a> that connect the mobile app to this website.</p>


			<h3 class="paragraph_title">Stop the connection</h3> 
	
			<p>
				<a class="red" href="?page=WowFactor&content=disconnect">Disconnect</a> this Wordpress site from your Wow Factor account.</p>			
			

						
		</div>
	</div>

	<!-- clear settings -->
	<div class="clear"></div>



<?

// show footer
include_once('footer.php');

?>

