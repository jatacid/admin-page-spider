<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


//Adds a "Edit Page In BB" menu to adminbar
if (get_option('apspider_radio_bbmenu')[0] == 'option1') {  // Checks if option is set to Display
	add_action( 'admin_bar_menu', 'apspider_edit_bb_pg', 999 );
}

//Adds a "Edit Page In BB" menu to adminbar
function apspider_edit_bb_pg( $wp_admin_bar ) {

// Exit if beaver builder isn't active - no need to create the menu
if ( !class_exists( 'FLBuilder' ) ) {
return;
}

// Check the url so that it's not wp-admin and append beaver builder url
	$ur = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//$ur = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$pos = strpos($ur, 'wp-admin');
	if ($pos === false){
		$ur = $ur . '?fl_builder';
	}else{
		$ur = '';
	}

// Create the admin menu & submenus
	$args = array(
		'id'    => 'apspider_edit_bb_pg',
		'title' => __( 'Edit Page in BB' , 'admin-page-spider' ),
		'href'  =>  $ur,
		'meta'  => array( 'class' => 'apspider_edit_bb_pg_group apspider_menu_class' )
		);
	$wp_admin_bar->add_node( $args );

	$pages = get_pages(array( 'parent' => '0', 'sort_column' => 'menu_order'));
	foreach ( $pages as $page ) {
		$link = get_page_link( $page->ID );
		$title = $page->post_title;
		$args = array(
			'id'    => $page->ID . 'bbpg',
			'title' => $title,
			'href'  => $link . '?fl_builder',
			'parent' => 'apspider_edit_bb_pg',
			'meta'  => array( 'class' => 'apspider_edit_bb_pg_group' )
			);
		$wp_admin_bar->add_node( $args );

		$subpages = get_pages( array( 'child_of' => $page->ID, 'sort_column' => 'menu_order'));
		foreach( $subpages as $subpage ) {
			$link = get_page_link( $subpage->ID );
			$title = $subpage->post_title;
			$args = array(
				'id'    => $subpage->ID. 'bbpg',
				'title' => $title,
				'href'  => $link . '?fl_builder',
				'parent' => $page->ID . 'bbpg',
				'meta'  => array( 'class' => 'apspider_edit_bb_pg_group' )
				);
			$wp_admin_bar->add_node( $args );
		}
	}
} // End of "Edit Page in BB" Menu Bar creation



//Adds a "Edit Page In WP" menu to adminbar
if (get_option('apspider_radio_editmenu')[0] == 'option1') { //option1=display
	add_action( 'admin_bar_menu', 'apspider_edit_wp_pg', 998 );
}
//Adds a "Edit Page In WP" menu to adminbar
function apspider_edit_wp_pg( $wp_admin_bar ) {
	$id = get_the_ID();
	$args = array(
		'id'    => 'apspider_edit_wp_pg',
		'title' => __( 'Edit Page in WP' , 'admin-page-spider' ),
		'href'  => admin_url( '/post.php?post=' . $id . '&action=edit'),
		'meta'  => array( 'class' => 'apspider_edit_wp_pg_group apspider_menu_class' )
		);
	$wp_admin_bar->add_node( $args );

	$args = array(
		'id'    => 'viewapspider_edit_wp_pg',
		'title' => __( 'View ALL Pages in Backend' , 'admin-page-spider' ),
		'href'  => admin_url( '/edit.php?post_type=page'),
		'parent' => 'apspider_edit_wp_pg',
		'meta'  => array( 'class' => 'apspider_edit_wp_pg_group' )
		);
	$wp_admin_bar->add_node( $args );

	$pages = get_pages(array( 'parent' => '0', 'sort_column' => 'menu_order'));
	foreach ( $pages as $page ) {
		$link = $page->ID;
		$title = $page->post_title;
		$args = array(
			'id'    => $page->ID . 'wppg',
			'title' => $title,
			'href'  => admin_url( '/post.php?post=' . $link . '&action=edit'),
			'parent' => 'apspider_edit_wp_pg',
			'meta'  => array( 'class' => 'apspider_edit_wp_pg_group' )
			);
		$wp_admin_bar->add_node( $args );

		$subpages = get_pages( array( 'child_of' => $page->ID, 'sort_column' => 'menu_order'));
		foreach( $subpages as $subpage ) {
			$link = $subpage->ID;
			$title = $subpage->post_title;
			$args = array(
				'id'    => $subpage->ID. 'wppg',
				'title' => $title,
				'href'  => admin_url( '/post.php?post=' . $link . '&action=edit'),
				'parent' => $page->ID . 'wppg',
				'meta'  => array( 'class' => 'apspider_edit_wp_pg_group' )
				);
			$wp_admin_bar->add_node( $args );
		}

	}
} // End of "Edit Page in WP" Menu Bar creation




//Adds a "View Page" menu to adminbar
if (get_option('apspider_radio_viewmenu')[0] == 'option1') { //option1=display
	add_action( 'admin_bar_menu', 'apspider_view_wp_pg', 997);
}
//Adds a "View Page" menu to adminbar
function apspider_view_wp_pg( $wp_admin_bar ) {
	if (current_user_can( 'administrator')){
		$args = array(
			'id'    => 'apspider_view_wp_pg',
			'title' => __( 'View Page' , 'admin-page-spider' ),
			'href'  =>  '',
			'meta'  => array( 'class' => 'apspider_view_wp_pg_group apspider_menu_class' )
			);
		$wp_admin_bar->add_node( $args );

		$pages = get_pages(array( 'parent' => '0', 'sort_column' => 'menu_order'));
		foreach ( $pages as $page ) {
			$link = get_page_link( $page->ID );
			$title = $page->post_title;
			$args = array(
				'id'    => $page->ID . 'vpg',
				'title' => $title,
				'href'  => $link,
				'parent' => 'apspider_view_wp_pg',
				'meta'  => array( 'class' => 'apspider_view_wp_pg_group' )
				);


			$wp_admin_bar->add_node( $args );

			$subpages = get_pages( array( 'child_of' => $page->ID, 'sort_column' => 'menu_order'));
			foreach( $subpages as $subpage ) {
				$link = get_page_link( $subpage->ID );
				$title = $subpage->post_title;
				$args = array(
					'id'    => $subpage->ID. 'vpg',
					'title' => $title,
					'href'  => $link,
					'parent' => $page->ID . 'vpg',
					'meta'  => array( 'class' => 'apspider_view_wp_pg_group' )
					);
				$wp_admin_bar->add_node( $args );
			}
		}
	}
} // End of "View Page" Menu Bar creation



// Remove all the now 'redundant' nodes from the admin bar that are no longer needed
// This section removes the beaver builder and edit items from Admin Bar
function apspider_admin_bar_removal() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_node('edit');
	$wp_admin_bar->remove_node('fl-builder-frontend-edit-link');
}
add_action( 'wp_before_admin_bar_render', 'apspider_admin_bar_removal', 99);


//Adds custom styling css for the admin bar both in frontend and backend so that on really long lists it will display a scrollbar and properly show child menu items as a hover over the top of the child menus.
function add_aps_custom_admin_styles() {
	echo '<style type="text/css">
.apspider_menu_class .ab-sub-wrapper {
    max-height: 90vh !important ;
    overflow-y: auto !important;
    overflow-x: hidden !important;
}
.apspider_menu_class .ab-sub-wrapper li {
    width: 90% !important;
}
.apspider_menu_class .menupop ul {
    position: fixed !important;
    z-index: 999999 !important;
    top: auto !important;
    left: auto !important;
    overflow: none !important;
    background-color: #32373C !important;
}</style>';
}
add_action('admin_head', 'add_aps_custom_admin_styles', 10);
add_action('wp_head', 'add_aps_custom_admin_styles', 10);
