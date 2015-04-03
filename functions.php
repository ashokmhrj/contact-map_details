<?php
/**
 * Theme option for map setting
 */
function contact_detail_theme_menu() {
  //add_theme_page( 'Theme Option', 'Map Options', 'manage_options', 'show_map', 'we_theme_page'); 
  add_menu_page( 'Contact Details', 'Contact Details', 'manage_options', 'contact_details','contact_page', '', 61 );
  //add_submenu_page( 'contact_details', 'Contact Details', 'Contact Details', 'manage_options', 'contact_details', 'contact_page' );
  //add_submenu_page( 'contact_details', 'Map Details', 'Map Details', 'manage_options', 'map_details', 'map_page' );
}
add_action('admin_menu', 'contact_detail_theme_menu');

function webEq_display_menu_icon(){
	$style = '<style type="text/css">';
	$style .= '#toplevel_page_contact_details .dashicons-admin-generic:before {';
	$style .= ' content: "\f230" !important;';
	$style .= '}';
	$style .= '</style>';
	echo $style;
}
add_action( 'admin_head', 'webEq_display_menu_icon' );
 
require_once('contact-panel.php');

