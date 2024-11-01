<?

// Headlines
$h1 = "Disconnect your account.";
$h2 = "Do not show videos any more from your Wow Factor account.";

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


	<div class="row_hero" style="margin: 30px 0 0;padding: 0 0 100px 0;">

		<div class="span-4 marginleft-1 marginright-1">
						
				&nbsp;


		</div>
		<div class="span-16">
		
		<h4>Some consequences</h4>
		<p>People arriving on your site by clicking any links from other websites to your video pages will not be found.  This creates a 404 (not found) error message.  Be sure to have a 404 error page ready, or if you are familiar with redirecting pages using the .htaccess file, set up redirects for your video pages and point the traffic to other pages of your choice.</p>
		<p>Search engines will encounter the same problems above.  After a while, they will stop sending traffic to those pages.</p>
		
		<h4 class="paragraph_title">But don't worry…</h4>
		<p>You can always re-connect your account at any time.</p>
		
		<h4 class="paragraph_title">Disconnect here</h4>
		
		<p>
			<a href="?page=WowFactor&disconnect=yes">Click here to disconnect</a> this Wordpress site from your Wow Factor account.</p>
		
						
		</div>
	</div>

	<!-- clear banner settings -->
	<div class="clear"></div>



<?

// show footer
include_once('footer.php');

?>

