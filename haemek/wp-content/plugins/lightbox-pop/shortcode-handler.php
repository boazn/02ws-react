<?php

$lbx_page_option=get_option('xyz_lbx_page_option');
if($lbx_page_option==3)
{

add_shortcode( 'xyz_lbx_default_code', 'lbx_lightbox_display' );
}


$qbx_page_option=get_option('xyz_qbx_page_option');
if($qbx_page_option==3)
{

	add_shortcode( 'xyz_qbx_default_code', 'qbx_lightbox_display' );
}

$dbx_page_option=get_option('xyz_dbx_page_option');
if($dbx_page_option==3)
{

	add_shortcode( 'xyz_dbx_default_code', 'dbx_lightbox_display' );
}





























?>