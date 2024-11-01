<?php



function returnFileSize($fileSize) {
    switch ($fileSize) :
        case ($fileSize < 1024):
            return $fileSize.' <b>Bit</b>';
        case ($fileSize > 1024 && $fileSize < 1048576):
            return round($fileSize/1024, 1).' <b>Kb</b>';
        case ($fileSize > 1048576 && $fileSize < 1073741824):
            return round($fileSize/1048576, 1).' <b>Mb</b>';
        case ($fileSize > 1073741824 && $fileSize < 1099511627776 ):
            return round($fileSize/1073741824, 1).' <b>Gb</b>';
        case ($fileSize > 1099511627776 && $fileSize < 1125899906842624):
            return round($fileSize/1099511627776, 1).' <b>TB</b>';
        case ($fileSize > 1125899906842624):
            return round($fileSize/1125899906842624, 1).' <b>PB</b>';
        default:
            return $fileSize;
    endswitch;
}


$url = 'http://wordpress/wp-content/plugins/WowFactor/admin.php';

$url = 'http://psychoactiveux.com/';


		// load the url page
		$page_html = file_get_contents($url);
		
		//check size of remote file
		$headers = get_headers ( $url, 1 );
    	$file_size = $headers['Content-Length']; 
    	
    	if (empty($file_size)) {
    		
    		// header method could not load file size.  Use this other method...
    		$file_size = strlen($page_html); 
    	}
    	
    	echo '<br><br>This search bandwidth... ' . returnFileSize($file_size) . '<br><br>';

    	echo '<hr>';
    	
    	echo '<br><br>';
    	
    	echo $page_html;
   
?>
