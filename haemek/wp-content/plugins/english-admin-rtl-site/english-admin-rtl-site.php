<?php
/*
Plugin Name: English Admin RTL Site
Version: 0.1
Plugin URI: http://wordpress.org
Description: Use English Admin, with your RTL Site. Activate and if your themes has an RTL stylesheet, it will be used.
Author: Adam Tal
Author URI: http://adamtal.com
*/

function iptrtl_add_stylesheet() {
	$template_dir_uri = get_template_directory_uri();
	$template_dir = get_template_directory();
	//$stylesheet_dir = get_stylesheet_directory();

	if ( file_exists("$template_dir/rtl.css") ) {
		wp_register_style( 'parent-theme-rtl', "$template_dir_uri/rtl.css" );
		wp_enqueue_style( 'parent-theme-rtl' );
	}
}
add_action('wp_print_styles', 'iptrtl_add_stylesheet');
?>