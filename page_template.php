<?php 
/*
Template Name: Wow Factor basic page
*/

// load config
include_once('config.php');

// load normal Wordpress page header
get_header();


// get the video content from WowFactor.io
include_once( WOWFACTOR_PLUGIN_PHP_PATH . 'api/index.php');


// load normal Wordpress page footer
get_footer();

?>