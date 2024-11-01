<?
/*

 This file contains the access keys to your account on our database.

 Please limit the people who have access to this information.
 
*/
	
// API codes
$WowFactor_API_code_1 = get_option('WowFactor_API_code_1');
$WowFactor_API_code_2 = get_option('WowFactor_API_code_2');


	
// URL of the WowFactor.io API
$url = WOWFACTOR_API_URL . "v1/index.php";	



// Function to build the API query that sends your API codes and page request to WowFactor.io

function build_WowFactor_query($params) {

    if (!$params) return '';

    $pairs = array();
    
    foreach ($params as $parameter => $value) {
    
      $pairs[] = $parameter . '=' . urlencode($value);
      
    }
    
    // For each parameter, the name is separated from the corresponding value by an '=' character (ASCII code 61)
    // Each name-value pair is separated by an '&' character (ASCII code 38)
    return implode('&', $pairs);
    
}
  
?>