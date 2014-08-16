<?php


function lbx_destroy()
{
	global $wpdb;
	delete_option("xyz_lbx_html");
	delete_option("xyz_tinymce");
	if(get_option('xyz_credit_link')=="lbx")
	{
		update_option("xyz_credit_link", '0');
	}
	delete_option("xyz_lbx_top");
	delete_option("xyz_lbx_width");
	delete_option("xyz_lbx_height");
	delete_option("xyz_lbx_left");
	delete_option("xyz_lbx_delay");
	delete_option("xyz_lbx_page_count");
	delete_option("xyz_lbx_mode"); //page_count_only,both are other options
	delete_option("xyz_lbx_repeat_interval");
	delete_option("xyz_lbx_repeat_interval_timing");//hrs or  minute
	delete_option("xyz_lbx_z_index");
	delete_option("xyz_lbx_color");	
	delete_option("xyz_lbx_corner_radius");
	delete_option("xyz_lbx_width_dim");
	delete_option("xyz_lbx_height_dim");
	delete_option("xyz_lbx_left_dim");
	delete_option("xyz_lbx_top_dim");
	delete_option("xyz_lbx_border_color");
	delete_option("xyz_lbx_bg_color");
	delete_option("xyz_lbx_opacity");
	delete_option("xyz_lbx_border_width");
	delete_option("xyz_lbx_page_option");
	delete_option("xyz_lbx_close_button_option");
	delete_option("xyz_lbx_iframe");
	
	delete_option("xyz_lbx_positioning");
	delete_option("xyz_lbx_position_predefined");
	delete_option("xyz_lbx_display_position");
	delete_option("xyz_dbx_html");
	delete_option("xyz_dbx_top");
	delete_option("xyz_dbx_width");
	delete_option("xyz_dbx_height");
	delete_option("xyz_dbx_left");
	delete_option("xyz_dbx_delay");
	delete_option("xyz_dbx_page_count");
	delete_option("xyz_dbx_mode"); //page_count_only,both are other options
	delete_option("xyz_dbx_repeat_interval");
	delete_option("xyz_dbx_repeat_interval_timing");//hrs or  minute
	delete_option("xyz_dbx_z_index");
	delete_option("xyz_dbx_color");
	delete_option("xyz_dbx_corner_radius");
	delete_option("xyz_dbx_width_dim");
	delete_option("xyz_dbx_height_dim");
	delete_option("xyz_dbx_left_dim");
	delete_option("xyz_dbx_top_dim");
	delete_option("xyz_dbx_border_color");
	delete_option("xyz_dbx_bg_color");
	delete_option("xyz_dbx_opacity");
	delete_option("xyz_dbx_border_width");
	delete_option("xyz_dbx_page_option");
	delete_option("xyz_dbx_close_button_option");
	delete_option("xyz_dbx_iframe");
	
	delete_option("xyz_dbx_positioning");
	delete_option("xyz_dbx_position_predefined");
	delete_option("xyz_dbx_display_position");
	delete_option("xyz_qbx_html");
	delete_option("xyz_qbx_top");
	delete_option("xyz_qbx_width");
	delete_option("xyz_qbx_height");
	delete_option("xyz_qbx_left");
	delete_option("xyz_qbx_delay");
	delete_option("xyz_qbx_page_count");
	delete_option("xyz_qbx_mode"); //page_count_only,both are other options
	delete_option("xyz_qbx_repeat_interval");
	delete_option("xyz_qbx_repeat_interval_timing");//hrs or  minute
	delete_option("xyz_qbx_z_index");
	delete_option("xyz_qbx_color");
	delete_option("xyz_qbx_corner_radius");
	delete_option("xyz_qbx_width_dim");
	delete_option("xyz_qbx_height_dim");
	delete_option("xyz_qbx_left_dim");
	delete_option("xyz_qbx_top_dim");
	delete_option("xyz_qbx_border_color");
	delete_option("xyz_qbx_bg_color");
	delete_option("xyz_qbx_opacity");
	delete_option("xyz_qbx_border_width");
	delete_option("xyz_qbx_page_option");
	delete_option("xyz_qbx_close_button_option");
	delete_option("xyz_qbx_iframe");
	
	delete_option("xyz_qbx_positioning");
	delete_option("xyz_qbx_position_predefined");
	delete_option("xyz_qbx_display_position");
	
	
}

register_uninstall_hook(XYZ_LBX_PLUGIN_FILE,'lbx_destroy');


?>