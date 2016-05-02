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
		<div class="wrap">
			<h2>Admin Page Spider Plugin</h2>
			<form method="post" action="options.php">
				<?php
				settings_fields( 'apspider_fields' );
				do_settings_sections( 'apspider_fields' );
				submit_button();
				?>
			</form>
		</div> <?php
	}

// Create a list of 'sections' for the settings page.
	public function apspider_setup_sections() {

		add_settings_section( 'first_section', __( '"View Menu" Settings' , 'admin-page-spider' ), array( $this, 'apspider_section_callback' ), 'apspider_fields' );

		add_settings_section( 'second_section', __( '"Edit Menu" Settings' , 'admin-page-spider' ), array( $this, 'apspider_section_callback' ), 'apspider_fields' );

	// Only create this section if Beaver Builder is active
		if ( class_exists( 'FLBuilder' ) ) {
			add_settings_section( 'third_section', __( 'Beaver Builder Settings' , 'admin-page-spider' ), array( $this, 'apspider_section_callback' ), 'apspider_fields' );
		}
	}

// Callback to handle each scenario of each section creation.
	public function apspider_section_callback( $arguments ) {
		switch( $arguments['id'] ){
			case 'first_section':
			echo __( 'Options for the "View Menu" allowing you to view any page' , 'admin-page-spider' );
			break;

		case 'second_section':
			echo __( 'Options for the "Edit in WP" allowing you quick access to the Wordpress Edit Page' , 'admin-page-spider' );
			break;
		case 'third_section':
			echo __( 'Options for Beaver Builder and shortcut menus' , 'admin-page-spider' );
			break;
		}
	}

// Create a list of 'settings' for the sections, inside the settings page
	public function apspider_setup_fields() {
		// Include the array of settings fields
		include('apspider-adminfieldsarray.php');

		// Cycle through the settings, create the field and register the setting
		foreach( $fields as $field ){

			/* Check if the 'supplemental' argument has 'bb' type on it.  Then make sure Beaver Builder is active before creating this setting field.  Otherwise break from this particular loop. */
			if( !empty ( $field['supplemental'] )) {
				if ( $field['supplemental'] == 'bb'){
					if ( !class_exists( 'FLBuilder' ) ) {
						break;
					}
				}
			}

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
		switch( $arguments['type'] ){
			case 'text':
			case 'password':
			case 'number':
			printf( '<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />', $arguments['uid'], $arguments['type'], $arguments['placeholder'], $value );
			break;
			case 'textarea':
			printf( '<textarea name="%1$s" id="%1$s" placeholder="%2$s" rows="5" cols="50">%3$s</textarea>', $arguments['uid'], $arguments['placeholder'], $value );
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

		/* Add a supplemental text field if you ever want to display an additional field
        if( $supplemental = $arguments['supplemental'] ){
            printf( '<p class="description">%s</p>', $supplemental );
 		} */
	} //End of public function apspider_field_callback()
}
new Admin_Page_Spider();
