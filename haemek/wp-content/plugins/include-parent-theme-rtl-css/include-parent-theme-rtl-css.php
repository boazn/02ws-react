<?php
/*
Plugin Name: Include Parent Theme RTL CSS
Version: 0.1
Plugin URI: http://core.trac.wordpress.org/ticket/15863
Description: Allows to include a parent theme RTL stylesheet for a child theme.
Author: Sergey Biryukov
Author URI: http://profiles.wordpress.org/sergeybiryukov/
*/

function iptrtl_add_stylesheet() {
	$template_dir_uri = get_template_directory_uri();
	$template_dir = get_template_directory();
	$stylesheet_dir = get_stylesheet_directory();

	if ( is_rtl() && is_child_theme() && file_exists("$template_dir/rtl.css") && ! file_exists("$stylesheet_dir/rtl.css") ) {
		wp_register_style( 'parent-theme-rtl', "$template_dir_uri/rtl.css" );
		wp_enqueue_style( 'parent-theme-rtl' );
	}
}
add_action('wp_print_styles', 'iptrtl_add_stylesheet');
?>