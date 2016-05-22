<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

if (is_multisite())
{
	global $wpdb;
	$blogs = $wpdb->get_results("SELECT blog_id FROM {$wpdb->blogs}", ARRAY_A);

	if(!empty($blogs))
	{
		foreach($blogs as $blog)
		{
			switch_to_blog($blog['blog_id']);
			aps_delete_options();
		}
	}
} else {
	aps_delete_options();
}


function aps_delete_options(){
	// Include the array of settings
	include('apspider-adminfieldsarray.php');
	// Cycle through the array and add all options
	foreach( $fields as $field ){
		delete_option( $field['uid']);
	}
}