<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly



//Adds a Wordpress Pages menu to adminbar
$aps_which_option_is_selected = get_option('apspider_radio_editmenu');
if ($aps_which_option_is_selected[0] == 'option1') { //option1=display
	add_action( 'admin_bar_menu', 'apspider_edit_wp_pg', 998 );
}

function apspider_edit_wp_pg( $wp_admin_bar ) {

	//Since the option is turned on to show the page, then we can delete the default edit link.
	add_action( 'wp_before_admin_bar_render', 'apspider_admin_bar_removal', 99);

	//Gets Menu name settings & Sets it.
	$aps_which_option_is_selected = get_option('apspider_editmenu_name');
	if ( empty( $aps_which_option_is_selected[0]) OR $aps_which_option_is_selected[0] == ''){
		$aps_which_option_is_selected = 'Wordpress Pages';
	}

	//Menu Node
	$id = get_the_ID();
	$args = array(
		'id'    => 'apspider_edit_wp_pg',
		'title' => $aps_which_option_is_selected , 'admin-page-spider',
		'href'  => admin_url( '/post.php?post=' . $id . '&action=edit'),
		'meta'  => array( 'class' => 'apspider_edit_wp_pg_group apspider_menu_class' )
		);
	$wp_admin_bar->add_node( $args );

	//View All Node
	$args = array(
		'id'    => 'viewapspider_edit_wp_pg',
		'title' => __( 'View All Pages' , 'admin-page-spider' ),
		'href'  => admin_url( '/edit.php?post_type=page'),
		'parent' => 'apspider_edit_wp_pg',
		'meta'  => array( 'class' => 'apspider_edit_wp_pg_group aps_highlighted' )
		);
	$wp_admin_bar->add_node( $args );

	//Now start the cycle for all pages parent level only
	$pages = get_pages(array( 'parent' => '0', 'sort_column' => 'menu_order'));
	foreach ( $pages as $page ) {
		$link = get_page_link( $page->ID );
		$title = $page->post_title;
		if (strlen($title) > 20){
		$title = substr($title, 0, 20) . '...';
		}
		$children = get_pages('child_of='.$page->ID);
		if( count( $children ) > 0 ) {
			$children = 'aps_has_children';}
		else {
			$children = '';
		}

		$args = array(
			'id'    => $page->ID . 'wppg',
			'title' => $title,
			'href'  => $link,
			'parent' => 'apspider_edit_wp_pg',
			'meta'  => array( 'class' => 'apspider_edit_wp_pg_group ' . $children )
			);
		$wp_admin_bar->add_node( $args );

		//For each parent level item add an edit link 'child' so that user may view & edit with a single menu.
			$args = array(
			'id'    => $page->ID. 'wppg1',
			'title' => __('Edit','admin-page-spider'),
			'href'  => admin_url( '/post.php?post=' . $link . '&action=edit'),
			'parent' => $page->ID . 'wppg',
			'meta'  => array( 'class' => 'apspider_edit_wp_pg_group aps_highlighted' )
			);
		$wp_admin_bar->add_node( $args );

		//Now run another loop but looking for child pages
		$subpages = get_pages( array( 'child_of' => $page->ID, 'sort_column' => 'menu_order'));
		foreach( $subpages as $subpage ) {
			$link = get_page_link( $subpage->ID );
			$title = $subpage->post_title;
			if (strlen($title) > 20){
			$title = substr($title, 0, 20) . '...';
			}
			$args = array(
				'id'    => $subpage->ID. 'wppg',
				'title' => $title,
				'href'  => $link,
				'parent' => $page->ID . 'wppg',
				'meta'  => array( 'class' => 'apspider_edit_wp_pg_group' )
				);
			$wp_admin_bar->add_node( $args );
			//setup the edit link again.
			$args = array(
			'id'    => $subpage->ID. 'wppg1',
			'title' => __('Edit','admin-page-spider'),
			'href'  => admin_url( '/post.php?post=' . $link . '&action=edit'),
			'parent' => $subpage->ID . 'wppg',
			'meta'  => array( 'class' => 'apspider_edit_wp_pg_group aps_highlighted' )
			);
		$wp_admin_bar->add_node( $args );
		}
	}
} // End of "Edit Page in WP" Menu Bar creation



// Remove all the now 'redundant' nodes from the admin bar that are no longer needed
function apspider_admin_bar_removal() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_node('edit');
}


//Adds custom styling css for the admin bar both in frontend and backend so that on really long lists it will display a scrollbar and properly show child menu items as a hover over the top of the child menus.
function add_aps_custom_admin_styles() {
	echo '<style type="text/css">
.apspider_menu_class .ab-sub-wrapper {
    max-height: 90vh !important ;
    overflow-y: auto !important;
    overflow-x: hidden !important;
}
.apspider_menu_class .ab-sub-wrapper li {
    width: 100% !important;
}
.apspider_menu_class .menupop ul {
    position: fixed !important;
    z-index: 999999 !important;
    top: auto !important;
    left: auto !important;
    overflow: none !important;
    background-color: #32373C !important;
}
.aps_highlighted a{
	text-decoration: underline !important;
	color: #848484 !important;
}


#wpadminbar .menupop .menupop:not(.aps_has_children)>.ab-item:before{
	content: "";
}
</style>';
}
add_action('admin_head', 'add_aps_custom_admin_styles', 10);
add_action('wp_head', 'add_aps_custom_admin_styles', 10);