<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Admin_Page_Spider
 *
 * Creates the admin page settings & calls the function files.
 *
 * @since 1.00
 */
class Admin_Page_Spider {

// Initialise for admin settings page menus and settings fields
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'apspider_plugin_settings_page' ) );
		add_action( 'admin_init', array( $this, 'apspider_setup_sections' ) );
		add_action( 'admin_init', array( $this, 'apspider_setup_fields' ) );
	}

// Add the menu item and page
	public function apspider_plugin_settings_page() {
		$page_title = __( 'Admin Page Spider' , 'admin-page-spider' );
		$menu_title = __( 'Admin Page Spider' , 'admin-page-spider' );
		$capability = 'manage_options';
		$slug = 'apspider_fields';
		$callback = array( $this, 'apspider_plugin_settings_page_content' );
		add_submenu_page( 'options-general.php', $page_title, $menu_title, $capability, $slug, $callback);
	}

// Create the layout of the settings page
	public function apspider_plugin_settings_page_content() {
		?>
		<style type="text/css">

form h2 {
	background-color: lightblue ;
	padding: 20px;
	cursor: pointer;
}
</style>

<script>
	(function($){
	jQuery(document).ready(function(){

	jQuery('.wrap table, .wrap p:not(.submit, .description)').toggle();

	jQuery('h2').on('click', function(){

	$(this).nextAll().slice(0, 2).toggle('slideIn');

	});

	});
	})(jQuery);
</script>


<div class= "wrap" style="width: 70%; float: left;">
			<h1>Admin Page Spider Plugin</h1>
			<form method="post" action="options.php">
				<?php
				settings_fields( 'apspider_fields' );
				do_settings_sections( 'apspider_fields' );
				submit_button();
				?>
			</form>

<?php
global $message;
printf ( apply_filters( 'apspp_after_settings_message', $message ));
?>

</div>

<div class="wrap" style="width: 20%; float: right; text-align: center; margin: 50px 50px 0 0; background-color: #ADD8E6; padding: 30px 20px;">
<a href="https://www.wpbeaverbuilder.com/?fla=215" target="_blank"><img style="width: 100%; height: auto;" src="https://www.wpbeaverbuilder.com/wp-content/uploads/2014/03/300x2501.jpg"/><h4>Get Beaver Builder</h4></a>
<a href="https://themeover.com/microthemer?ap_id=jatacid" target="_blank" ><img style="width: 100%; height: auto;" src="https://themeover.com/wp-content/banners/square.png"/><h4>Get Microthemer</h4></a>
<a href="http://www.csshero.org/?rid=9738" ><img  style="width: 100%; height: auto;" src="http://www.csshero.org/banners/125x125_01.png" alt="WordPress Theme Editor"><h4>Get CSS Hero</h4></a>
<span>
<?php
_e('Support Us With Our Affiliate Links To Some Great Plugins!', 'admin-page-spider');
?>
</span>
</div>
<div style="clear: both;"></br></div>

<?php
}


// Create a list of 'sections' for the settings page.
	public function apspider_setup_sections() {

		add_settings_section( 'first_section', __( '+ Wordpress Page Menus' , 'admin-page-spider' ), array( $this, 'apspider_section_callback' ), 'apspider_fields' );

	do_action( 'add_more_settings_sections');
	}

// Callback to handle each scenario of each section creation.
	public static function apspider_section_callback( $arguments ) {
		switch( $arguments['id'] ){
			case 'first_section':
			echo __( '<p>The options for the Wordpress menus, allowing you to quickly view and edit any page</p>' , 'admin-page-spider' );
			break;

	do_action( 'extra_section_callbacks', $arguments);
	}
}

// Create a list of 'settings' for the sections, inside the settings page
	public function apspider_setup_fields() {

	global $fields;
	apply_filters( 'aps_add_fields', $fields );

		// Cycle through the settings, create the field and register the setting
		foreach( $fields as $field ){
			add_settings_field( $field['uid'], $field['label'], array( $this, 'apspider_field_callback' ), 'apspider_fields', $field['section'], $field );
			register_setting( 'apspider_fields', $field['uid'] );
		}
	}


// Callback to handle each scenario of each settings field created and passed to it.
	public function apspider_field_callback( $arguments ) {
		$value = get_option( $arguments['uid'] );

		if( ! $value ) {
			$value = $arguments['default'];
		}

		if ( ! empty ( $arguments['placeholder'] )){
			$placeholder = $arguments['placeholder'];
		} else {
			$placeholder = false ;
		}

printf('<div style="background-color: #DFDFDF; padding: 5px;">');


		switch( $arguments['type'] ){
			case 'text':
			case 'password':
			case 'number':
			printf( '<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />', $arguments['uid'], $arguments['type'], $placeholder, $value );
			break;
			case 'textarea':
			printf( '<textarea name="%1$s" id="%1$s" placeholder="%2$s" rows="5" cols="50">%3$s</textarea>', $arguments['uid'], $placeholder, $value );
			break;
			case 'select':
			case 'multiselect':
			if( ! empty ( $arguments['options'] ) && is_array( $arguments['options'] ) ){
				$attributes = '';
				$options_markup = '';
				foreach( $arguments['options'] as $key => $label ){
					$options_markup .= sprintf( '<option value="%s" %s>%s</option>', $key, selected( $value[ array_search( $key, $value, true ) ], $key, false ), $label );
				}
				if( $arguments['type'] === 'multiselect' ){
					$attributes = ' multiple="multiple" ';
				}
				printf( '<select name="%1$s[]" id="%1$s" %2$s>%3$s</select>', $arguments['uid'], $attributes, $options_markup );
			}
			break;
			case 'radio':
			case 'checkbox':
			if( ! empty ( $arguments['options'] ) && is_array( $arguments['options'] ) ){
				$options_markup = '';
				$iterator = 0;
				foreach( $arguments['options'] as $key => $label ){
					$iterator++;
					$options_markup .= sprintf( '<label for="%1$s_%6$s"><input id="%1$s_%6$s" name="%1$s[]" type="%2$s" value="%3$s" %4$s /> %5$s</label><br/>', $arguments['uid'], $arguments['type'], $key, checked( $value[ array_search( $key, $value, true ) ], $key, false ), $label, $iterator );
				}
				printf( '<fieldset>%s</fieldset>', $options_markup );
			}

			break;
		}

		if( ! empty ( $arguments['helper'] )) {
			printf( '<span class="helper"> %s</span>', $arguments['helper'] );
		}

		// Add a supplemental text field if you ever want to display an additional field
        if( ! empty ( $arguments['supplemental'] )) {
            printf( '<p class="description">%s</p>', $arguments['supplemental'] );
 		}

printf('</div>');

	} //End of public function apspider_field_callback()
}
new Admin_Page_Spider();


add_filter('apspp_after_settings_message', 'apspp_after_settings_messages', 10);
function apspp_after_settings_messages($message){

// return '
// <div style="padding: 30px; background-color: lightblue; margin: 50px 0; text-align: center;">
// <br><h1>GET THE PRO PACK!</h1><ul>
// <li>+ Support for Beaver Builder AND Templates!</li>
// <li>+ Support For Wordpress Posts</li>
// <li>+ Support For CSS Hero!</li>
// <li>+ Support For Microthemer!</li>
// <li>+ Cheap & Dev Friendly Site Licenses!</li>
// </ul><br/>
// <a target="_blank" href="https://adminpagespider.com/admin-page-spider-pro-pack/" style="text-decoration: none;"><h3 style="background-color: darkslateblue; color: white; max-width: 300px; text-decoration: none; margin: auto; padding: 10px 20px; border-radius: 15px;">Check It Out Now</h3></a></div>' ;

return '
<div style="padding: 30px; background-color: lightblue; margin: 50px 0; text-align: center;">
<h1>Since you have been an early adopter of Admin Page Spider - the code below can be used to get you 60 PERCENT OFF!!! your purchase of the Pro Pack!</h1>
<h1 style="color: orange;">Code: FRIENDOFBEAVER</h1>
<span style="color: red;"> Hurry! This code is only valid for the first 200 purchases!</span>
<br><Br>

<br><h1>GET THE PRO PACK!</h1><ul>
<li>+ Support for Beaver Builder AND Templates!</li>
<li>+ Support For Wordpress Posts</li>
<li>+ Support For CSS Hero!</li>
<li>+ Support For Microthemer!</li>
<li>+ Cheap & Dev Friendly Site Licenses!</li>
</ul><br/>
<a target="_blank" href="https://adminpagespider.com/admin-page-spider-pro-pack/" style="text-decoration: none;"><h3 style="background-color: darkslateblue; color: white; max-width: 300px; text-decoration: none; margin: auto; padding: 10px 20px; border-radius: 15px;">Check It Out Now</h3></a></div>' ;

}


add_filter('aps_add_fields', 'aps_add_fields', 10);
function aps_add_fields(){
include_once('apspider-adminfieldsarray.php');
}