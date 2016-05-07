<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/*
Plugin Name: Admin Page Spider
Plugin URI: https://j7digital.com/admin-page-spider
Description: Adds menus to the admin bar which gives you quick access to view or edit any page available on the website.
Author: J7Digital
Version: 1.05
Author URI: https://j7digital.com/admin-page-spider
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

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/


// Load settings page
include_once 'apspider-adminsettings.php';

// Loads functions & menus
include_once 'apspider-functions.php';

add_action ( 'plugins_loaded' , 'page_spider_textdomain' );

function page_spider_textdomain () {
	load_plugin_textdomain( 'admin-page-spider', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
}

// Defines activation & deactivation functions
register_deactivation_hook( __FILE__, 'apspider_plugin_deactivate' );
register_activation_hook( __FILE__, 'apspider_plugin_activate' );

// Deletes all settings upon plugin deactivation
function apspider_plugin_deactivate(){
	if ( ! current_user_can( 'activate_plugins' ) )
		return;
	$plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
	check_admin_referer( "deactivate-plugin_{$plugin}" );

	// Include the array of settings
	include('apspider-adminfieldsarray.php');
	// Cycle through the array & delete all options
	foreach( $fields as $field ){
		delete_option($field['uid'] );
	}
}

// Adds all options upon plugin activation
function apspider_plugin_activate(){
	if ( ! current_user_can( 'activate_plugins' ) )
		return;
	$plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
	check_admin_referer( "activate-plugin_{$plugin}" );

	// Include the array of settings
	include('apspider-adminfieldsarray.php');
	// Cycle through the array and add all options
	foreach( $fields as $field ){
		add_option( $field['uid'], $field['default']);
	}
}
