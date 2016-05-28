<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly



//Adds a Wordpress Pages menu to adminbar if setting is turned on.
$aps_which_option_is_selected = get_option('apspider_radio_editmenu');
if ($aps_which_option_is_selected[0] == 'option1') { //option1=display
	add_action( 'admin_bar_menu', 'apspider_edit_wp_pg', 998 );
}

function apspider_edit_wp_pg( $wp_admin_bar ) {

	//Since the option is turned on to show the page, then we can delete the default edit link.
	add_action( 'wp_before_admin_bar_render', 'apspider_admin_bar_removal', 99);

	//Gets Menu name settings or Sets it to default.
	$aps_which_option_is_selected = get_option('apspider_editmenu_name');
	if ( empty( $aps_which_option_is_selected[0]) OR $aps_which_option_is_selected[0] == ''){
		$aps_which_option_is_selected = 'Edit Pages';
	}

	//Create Main Menu Node (edits current post)
	$id = get_the_ID();
	$args = array(
		'id'    => 'apspider_edit_wp_pg',
		'title' => __($aps_which_option_is_selected , 'admin-page-spider'),
		'href'  => admin_url( '/post.php?post=' . $id . '&action=edit'),
		'meta'  => array( 'class' => 'apspider_menu_class','title' => __('Edit Current Page', 'admin_page_spider'))
		);
	$wp_admin_bar->add_node( $args );

	//Create 'View All' Menu Node
	$args = array(
		'id'    => 'viewapspider_edit_wp_pg',
		'title' => __( 'View All Pages' , 'admin-page-spider' ),
		'href'  => admin_url( '/edit.php?post_type=page'),
		'parent' => 'apspider_edit_wp_pg',
		'meta'  => array( 'class' => 'aps_highlighted', 'title' => __('View All Pages in Wordpress', 'admin_page_spider'))
		);
	$wp_admin_bar->add_node( $args );

	//Now start the cycle for all pages parent level only
	$pages = get_pages(array( 'parent' => '0', 'sort_column' => 'menu_order'));
	foreach ( $pages as $page ) {
		$link = get_page_link( $page->ID );
		$title = $page->post_title;

		//Create Menu Item to edit in wordpress.
		$args = array(
			'id'    => $page->ID . 'wppg',
			'title' => $title,
			'href'  => admin_url( '/post.php?post=' . $page->ID . '&action=edit'),
			'parent' => 'apspider_edit_wp_pg',
			'meta'  => array( 'title' => __('Edit: ', 'admin_page_spider') . $page->post_title )
			);
		$wp_admin_bar->add_node( $args );

		//For each parent level item add a link 'child' which creates a 'view' icon.
		$args = array(
			'id'    => $page->ID. 'wppg1',
			'title' => '',
			'href'  => $link,
			'parent' => $page->ID . 'wppg',
			'meta'  => array( 'class' => 'aps_highlighted_view', 'title' => __('View: ', 'admin_page_spider') . $page->post_title )
			);
		$wp_admin_bar->add_node( $args );

		//Now run another loop but looking for child pages of this parent page.
		$subpages = get_pages( array( 'child_of' => $page->ID, 'sort_column' => 'menu_order'));
		foreach( $subpages as $subpage ) {
			$link = get_page_link( $subpage->ID );
			$title = $subpage->post_title;

			//Create a 'child page' item which is indented
			$args = array(
				'id'    => $subpage->ID. 'wppg',
				'title' => $title,
				'href'  => admin_url( '/post.php?post=' . $subpage->ID . '&action=edit'),
				'parent' => 'apspider_edit_wp_pg',
				'meta'  => array( 'class' => 'apspider_child_item', 'title' => __('Edit: ', 'admin_page_spider') . $subpage->post_title  )
				);
			$wp_admin_bar->add_node( $args );

			//setup the 'view' icon link again.
			$args = array(
				'id'    => $subpage->ID. 'wppg1',
				'title' => '',
				'href'  => $link,
				'parent' => $subpage->ID . 'wppg',
				'meta'  => array( 'class' => 'apspider_child_item aps_highlighted_view', 'title' => __('View: ', 'admin_page_spider') . $subpage->post_title)
				);
			$wp_admin_bar->add_node( $args );
		}
	}
} // End of "Edit Pages" Menu Bar creation

// Remove the 'redundant' Edit node from the admin bar that is no longer needed
function apspider_admin_bar_removal() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_node('edit');
}


//Adds custom styling css for the admin bar both in frontend and backend so that on really long lists it will display a scrollbar and properly show child menu items and view buttons.
function add_aps_custom_admin_styles() {
	echo '<style type="text/css">

	/* Main Menu div*/
	.apspider_menu_class>.ab-sub-wrapper {
		max-height: 90vh !important ;
		min-width: 250px !important;
		opacity: 0.94;
		overflow-x:  hidden;
		overflow-y: auto;
	}

	.apspider_child_item {
		margin-left: 20px !important;
		margin-right: 20px !important;
	}

	/* Highlight Grey Item */
	.aps_highlighted a{
		text-decoration: underline !important;
		color: #848484 !important;
	}

	/* View Buttons */
	.aps_highlighted_view, .aps_highlighted_view *{
		background-color: #23282d !important;
		position: absolute !important;
		max-width: 20px !important;
		min-width: 20px !important;
		text-align: right;
		left: -21px;
		right: 0;
	}
	/* View Button Search Icon */
	.aps_highlighted_view a:before{
		content: "\f179";
	}

	/* Hide default arrow for submenu items */
	#wpadminbar .menupop .menupop>.ab-item:before{
	content: "";
}

</style>';

}
add_action('admin_head', 'add_aps_custom_admin_styles', 10);
add_action('wp_head', 'add_aps_custom_admin_styles', 10);

// echo '<script "type="text/javascript">
// (function($){
// 	jQuery(document).ready(function(){
// 		jQuery(".aps_has_children").hover(function(){
// 		});
// 	});
// })(jQuery);
// </script>';