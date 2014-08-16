<?php

if ( is_admin() )
{

	add_action('admin_menu', 'lbx_menu');
	

}

function lbx_menu()
{
	add_menu_page('Lightbox Pop - Manage settings', 'XYZ Lightbox', 'manage_options', 'lightbox-popup-settings', 'lbx_basic_settings');
	// Add a submenu to the Dashboard:
	add_submenu_page('lightbox-popup-settings','Lightbox Pop - Manage settings', 'Settings', 'manage_options', 'lightbox-popup-settings', 'lbx_basic_settings');
	$page1=add_submenu_page('lightbox-popup-settings', 'Lightbox Pop - Manage settings', 'Lightbox Popup', 'manage_options', 'lightbox-settings' ,'lbx_settings'); // 8 for admin
	$page2=add_submenu_page('lightbox-popup-settings', 'Quick Popupbox - Manage settings', 'Quick Popup Box', 'manage_options', 'quick-popup-box-settings', 'qbx_settings'); // 8 for admin
		$page3=add_submenu_page('lightbox-popup-settings','Popup Dialog Box - Manage settings', 'Dialog Box Popup', 'manage_options', 'popup-dialog-box-settings', 'dbx_settings'); // 8 for admin
		add_submenu_page('lightbox-popup-settings', ' Popup - About', 'About', 'manage_options', 'popup-about' ,'lbx_about'); // 8 for admin
	
	
	//add_options_page('Lightbox - Manage settings',  'Lightbox Settings', 'administrator', 'my-first', 'lbx_settings');
	add_action( "admin_print_scripts-$page1", 'lbx_farbtastic_script' );
	add_action( "admin_print_styles-$page1", 'lbx_farbtastic_style' );
	add_action( "admin_print_scripts-$page2", 'lbx_farbtastic_script' );
	add_action( "admin_print_styles-$page2", 'lbx_farbtastic_style' );
	add_action( "admin_print_scripts-$page3", 'lbx_farbtastic_script' );
	add_action( "admin_print_styles-$page3", 'lbx_farbtastic_style' );
}

function lbx_basic_settings()
{
	require( dirname( __FILE__ ) . '/header.php' );
	require( dirname( __FILE__ ) . '/settings.php' );
	require( dirname( __FILE__ ) . '/footer.php' );
}

function lbx_settings()
{
	require( dirname( __FILE__ ) . '/header.php' );
	require( dirname( __FILE__ ) . '/lightbox-settings.php' );
	require( dirname( __FILE__ ) . '/footer.php' );
}

function qbx_settings()
{
	require( dirname( __FILE__ ) . '/header.php' );
	require( dirname( __FILE__ ) . '/quickbox-settings.php' );
	require( dirname( __FILE__ ) . '/footer.php' );
}

function dbx_settings()
{
	require( dirname( __FILE__ ) . '/header.php' );
	require( dirname( __FILE__ ) . '/dialogbox-settings.php' );
	require( dirname( __FILE__ ) . '/footer.php' );
}
function lbx_about()
{
	require( dirname( __FILE__ ) . '/header.php' );
	require( dirname( __FILE__ ) . '/about.php' );
	require( dirname( __FILE__ ) . '/footer.php' );
}




function lbx_farbtastic_script() 
{
	wp_enqueue_script('jquery');
	wp_enqueue_script('farbtastic');

}

function lbx_farbtastic_style() 
{
	wp_enqueue_style('farbtastic');
}
function xyz_lbx_admin_style()
{
	require( dirname( __FILE__ ) . '/style.php' );

}


if(is_admin())
{
	wp_enqueue_script('jquery');
	add_action('admin_print_styles', 'xyz_lbx_admin_style');

	wp_register_script( 'xyz_notice_script', plugins_url('lightbox-pop/js/notice.js') );
	wp_enqueue_script( 'xyz_notice_script' );

	wp_register_style( 'xyz_lbx_style', plugins_url('lightbox-pop/css/xyz_lbx_styles.css'));
	wp_enqueue_style( 'xyz_lbx_style');
}


?>