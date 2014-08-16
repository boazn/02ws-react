<?php

function lbx_admin_notice()
{
	$version=get_option('xyz_lbx_free_version');
	$current_version=xyz_lbx_plugin_get_version();
	$xyz_qbx_repeat_interval_timing=get_option('xyz_qbx_repeat_interval_timing');
	if($xyz_qbx_repeat_interval_timing==''|| ($version!=$current_version))
	{
			echo '<div class="error">
			   <p>It seems you have upgraded the Lightbox Pop Plugin. Please deactivate and then reactivate the plugin to upgrade the database.</p>
			</div>';
	}
}

add_action('admin_notices', 'lbx_admin_notice');

?>