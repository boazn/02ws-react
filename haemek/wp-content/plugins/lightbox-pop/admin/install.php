<?php


function lbx_install()
{
	global $wpdb;
	if(get_option('xyz_credit_link')=="")
	{
		add_option("xyz_credit_link", '0');
	}
	add_option("xyz_tinymce", '1');
	add_option("xyz_lbx_html", 'Hello world.');
	add_option("xyz_lbx_top", '25');
	add_option("xyz_lbx_width", '50');
	add_option("xyz_lbx_height", '50');
	add_option("xyz_lbx_left", '25');
	add_option("xyz_lbx_right", '25');
	add_option("xyz_lbx_bottom", '25');
	add_option("xyz_lbx_display_position", '1');
	add_option("xyz_lbx_delay", '0');
	add_option("xyz_lbx_page_count", '1');
	add_option("xyz_lbx_mode", 'delay_only'); //page_count_only,both are other options
	add_option("xyz_lbx_repeat_interval", '1');
	add_option("xyz_lbx_repeat_interval_timing", '1');//hrs or  minute
	add_option("xyz_lbx_z_index",'10000');
	add_option("xyz_lbx_color",'#000000');	
	add_option("xyz_lbx_corner_radius",'5');
	add_option("xyz_lbx_width_dim",'%');
	add_option("xyz_lbx_height_dim",'%');
		add_option("xyz_lbx_right_dim",'%');
		add_option("xyz_lbx_bottom_dim",'%');
		add_option("xyz_lbx_left_dim",'%');
		add_option("xyz_lbx_top_dim",'%');
	add_option("xyz_lbx_border_color",'#cccccc');
	add_option("xyz_lbx_bg_color",'#ffffff');
	add_option("xyz_lbx_opacity",'60');
	add_option("xyz_lbx_border_width",'10');
	add_option("xyz_lbx_page_option",'1');
	add_option("xyz_lbx_close_button_option",'0');
	add_option("xyz_lbx_iframe",'1');
	
	add_option("xyz_lbx_positioning",'1');
	add_option("xyz_lbx_position_predefined","1");
	
	add_option("xyz_dbx_html", 'Hello world.');
	add_option("xyz_dbx_top", '25');
	add_option("xyz_dbx_width", '50');
	add_option("xyz_dbx_height", '50');
	add_option("xyz_dbx_left", '25');
	add_option("xyz_dbx_right", '25');
	add_option("xyz_dbx_bottom", '25');
	add_option("xyz_dbx_display_position", '1');
	add_option("xyz_dbx_delay", '2');
	add_option("xyz_dbx_page_count", '1');
	add_option("xyz_dbx_mode", 'delay_only'); //page_count_only,both are other options
	add_option("xyz_dbx_repeat_interval", '1');
	add_option("xyz_dbx_repeat_interval_timing", '1');//hrs or  minute
	add_option("xyz_dbx_z_index",'10000');
	
	add_option("xyz_dbx_corner_radius",'5');
	add_option("xyz_dbx_width_dim",'%');
	add_option("xyz_dbx_height_dim",'%');
	add_option("xyz_dbx_right_dim",'%');
	add_option("xyz_dbx_bottom_dim",'%');
	add_option("xyz_dbx_left_dim",'%');
	add_option("xyz_dbx_top_dim",'%');
	add_option("xyz_dbx_border_color",'#cccccc');
	add_option("xyz_dbx_bg_color",'#ffffff');
	add_option("xyz_dbx_title",'Testing');
	add_option("xyz_dbx_title_color",'#000000');
	add_option("xyz_dbx_font",'14');
	add_option("xyz_dbx_border_width",'10');
	add_option("xyz_dbx_page_option",'3');
	add_option("xyz_dbx_close_button_option",'0');
	add_option("xyz_dbx_iframe",'1');
	
	add_option("xyz_dbx_positioning",'1');
	add_option("xyz_dbx_position_predefined","1");
	add_option("xyz_qbx_html", 'Hello world.');
	
	add_option("xyz_qbx_width", '50');
	add_option("xyz_qbx_height", '50');
	
	add_option("xyz_qbx_display_position", '0');
	add_option("xyz_qbx_delay", '0');
	add_option("xyz_qbx_page_count", '0');
	add_option("xyz_qbx_mode", 'delay_only'); //page_count_only,both are other options
	add_option("xyz_qbx_repeat_interval", '0');
	add_option("xyz_qbx_repeat_interval_timing", '1');//hrs or  minute
	add_option("xyz_qbx_z_index",'10000');
	add_option("xyz_qbx_z_index",'10000');
	add_option("xyz_qbx_corner_radius",'5');
	add_option("xyz_qbx_width_dim",'%');
	add_option("xyz_qbx_height_dim",'%');
	
	add_option("xyz_qbx_border_color",'#cccccc');
	add_option("xyz_qbx_bg_color",'#ffffff');
	add_option("xyz_qbx_title",'Testing');
	add_option("xyz_qbx_font",'14');
	add_option("xyz_qbx_title_color",'#000000');
	add_option("xyz_qbx_border_width",'10');
	add_option("xyz_qbx_page_option",'3');
	
	add_option("xyz_qbx_iframe",'1');
	
	
	add_option("xyz_qbx_position_predefined","1");
	
	$version=get_option('xyz_lbx_free_version');
	$currentversion=xyz_lbx_plugin_get_version();
	if($version=="")
	{
		add_option("xyz_lbx_free_version", $currentversion);
	}
	else
	{
	
		update_option('xyz_lbx_free_version', $currentversion);
	}
	
}
register_activation_hook(XYZ_LBX_PLUGIN_FILE,'lbx_install');


?>
