<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/*
Plugin Name: Admin Page Spider
Plugin URI: https://wordpress.org/plugins/admin-page-spider/
Description: Adds menus to the admin bar which gives you quick access to view or edit any page available on the website.
Author: J7Digital
Version: 1.09
Author URI: https://adminpagespider.com
Text Domain: admin-page-spider
Domain Path: /languages
License: GPLv2 or later

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/




add_action ( 'init' , 'page_spider_init' );
function page_spider_init () {
if ( current_user_can( 'administrator' )){
	//textdomain
	load_plugin_textdomain( 'admin-page-spider', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
	// Load settings page
	include_once 'apspider-adminsettings.php';
	// Loads functions & menus
	include_once 'apspider-functions.php';
}
}


// Defines activation & deactivation functions
register_deactivation_hook( __FILE__, 'apspider_plugin_deactivate' );

// Deletes all settings upon plugin deactivation
function apspider_plugin_deactivate(){
	if ( ! current_user_can( 'activate_plugins' ) )
		return;

	// Include the array of settings
	include('apspider-adminfieldsarray.php');
	// Cycle through the array & delete all options
	foreach( $fields as $field ){
		delete_option($field['uid'] );
	}
}
// Defines activation & deactivation functions
register_activation_hook( __FILE__, 'apspider_plugin_activate' );

//Adds all settings upon plugin activation
function apspider_plugin_activate(){
	if ( ! current_user_can( 'activate_plugins' ) )
		return;

//Delete defunct menu option (from 1.06)
delete_option('apspider_radio_viewmenu');

	// Include the array of settings
	include('apspider-adminfieldsarray.php');
	// Cycle through the array & delete all options
	foreach( $fields as $field ){
		update_option($field['uid'], $field['default']);
	}
}


add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'aps_pluginaction_links' );

function aps_pluginaction_links( $links ) {
   $links[] = '<a href="'. esc_url( get_admin_url(null, 'options-general.php?page=apspider_fields') ) .'">Settings</a>';

   $links[] = '<a href="https://adminpagespider.com/" target="_blank">Get Pro</a>';
   return $links;
}