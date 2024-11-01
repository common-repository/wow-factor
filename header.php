<?
// header and menu for Wow Factor admin pages.


	// load stylesheet
	echo '<link rel="stylesheet" type="text/css" href="' . WOWFACTOR_PLUGIN_URL . '/styles.css" />';
	
	// add styles that have images.  We have to do this so the correct URL to the image folder appears
	echo '
		<style>
			.row_hero {background: #fff url('.WOWFACTOR_PLUGIN_URL.'/images/line-shadow-no-bg.png) no-repeat center bottom;}
			.row_hero.medium_bg_image {background: #fff url('.WOWFACTOR_PLUGIN_URL.'/images/line-shadow-horizontal-medium.jpg) no-repeat center bottom;}
		</style>
	
	';
	
?>

<div id="wp_WowFactor_container">

<div class="row_hero" style="margin: 2em 0 0; padding: 0 0 4em 8%;">

<?

	if( ! $_GET['content'] && ( ! get_option( 'WowFactor_API_code_1' ) || ! get_option( 'WowFactor_API_code_2' ) )  ) {
		
		
		echo '
			
			<div id="header_youtube_video_container">
						
				<object width="420" height="236">
					<param name="movie" value="' . $WowFactor_youtube_video . '?hl=en_US&amp;version=3&amp;rel=0&amp;autoplay=' . $WowFactor_autoplay_instruction_video . '"></param>
					<param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param>
					<embed src="' . $WowFactor_youtube_video . '?hl=en_US&amp;version=3&amp;rel=0&amp;autoplay=' . $WowFactor_autoplay_instruction_video . '" type="application/x-shockwave-flash" width="420" height="236" allowscriptaccess="always" allowfullscreen="true"></embed>
				</object>
				
			</div>
			
				
			<h1>' . $h1 . '</h1>
			<h2 id="subtitle_before_connection" class="quiet">' . $h2 . '</h2>
			
			';
		
	} else {
		
		/*
		
			<div style="width:40%;float:right;margin-left:10%;border:1px solid grey; padding: 5%;">
				Stats go here
			</div>
		*/
		
		echo '
			
			<img src="' . WOWFACTOR_URL . 'images/logos/app_icon_200.jpg" width="10%" style="float:right;margin:0 10%;">
			
			<h1>' . $h1 . '</h1>
			<h2 class="quiet">' . $h2 . '</h2>

			';
	}

?>

</div>

<!-- clear banner settings -->
<div class="clear"></div>
