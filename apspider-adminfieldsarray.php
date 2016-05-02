<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

//Settings fields array containing all settings used in the plugin
$fields = array(

// Template examples to use for additional options
/*        array(
				'uid' => 'apspider_text_field',
				'label' => 'Sample Text Field',
				'section' => 'first_section',
				'type' => 'text',
				'placeholder' => 'Some text',
				'helper' => 'Does this help?',
				'supplemental' => 'I am underneath!',
			),
			array(
				'uid' => 'apspider_password_field',
				'label' => 'Sample Password Field',
				'section' => 'first_section',
				'type' => 'password',
			),
			array(
				'uid' => 'apspider_number_field',
				'label' => 'Sample Number Field',
				'section' => 'first_section',
				'type' => 'number',
			),
			array(
				'uid' => 'apspider_textarea',
				'label' => 'Sample Text Area',
				'section' => 'first_section',
				'type' => 'textarea',
			),
			array(
				'uid' => 'apspider_select',
				'label' => 'Sample Select Dropdown',
				'section' => 'first_section',
				'type' => 'select',
				'options' => array(
					'option1' => 'Option 1',
					'option2' => 'Option 2',
					'option3' => 'Option 3',
					'option4' => 'Option 4',
					'option5' => 'Option 5',
				),
				'default' => array()
			),
			array(
				'uid' => 'apspider_multiselect',
				'label' => 'Sample Multi Select',
				'section' => 'first_section',
				'type' => 'multiselect',
				'options' => array(
					'option1' => 'Option 1',
					'option2' => 'Option 2',
					'option3' => 'Option 3',
					'option4' => 'Option 4',
					'option5' => 'Option 5',
				),
				'default' => array()
			),
			array(
				'uid' => 'apspider_radio',
				'label' => 'Sample Radio Buttons',
				'section' => 'first_section',
				'type' => 'radio',
				'options' => array(
					'option1' => 'Option 1',
					'option2' => 'Option 2',
					'option3' => 'Option 3',
					'option4' => 'Option 4',
					'option5' => 'Option 5',
				),
				'default' => array()
			),
			array(
				'uid' => 'apspider_checkboxes',
				'label' => 'Sample Checkboxes',
				'section' => 'first_section',
				'type' => 'checkbox',
				'options' => array(
					'option1' => 'Option 1',
					'option2' => 'Option 2',
					'option3' => 'Option 3',
					'option4' => 'Option 4',
					'option5' => 'Option 5',
				),
				'default' => array()
			)
  */

			array(
				'uid' => 'apspider_radio_viewmenu',
				'label' => __( 'Display The "VIEW" Menu?' , 'admin-page-spider' ),
				'section' => 'first_section',
				'type' => 'radio',
				'options' => array(
					'option1' => __( 'Display' , 'admin-page-spider' ),
					'option2' => __( 'Hide' , 'admin-page-spider' ),
					),
				'default' => array('option1')
				),

			array(
				'uid' => 'apspider_radio_editmenu',
				'label' => __( 'Display The "EDIT" Menu?' , 'admin-page-spider' ),
				'section' => 'second_section',
				'type' => 'radio',
				'options' => array(
					'option1' => __( 'Display' , 'admin-page-spider' ),
					'option2' => __( 'Hide' , 'admin-page-spider' ),
					),
				'default' => array('option1')
				),


			array(
				'uid' => 'apspider_radio_bbmenu',
				'label' => __( 'Display The "EDIT in Beaver Builder" Menu?' , 'admin-page-spider' ),
				'section' => 'third_section',
				'type' => 'radio',
				'supplemental' => 'bb',
				'options' => array(
					'option1' => __( 'Display' , 'admin-page-spider' ),
					'option2' => __( 'Hide' , 'admin-page-spider' ),
					),
				'default' => array('option1')
				)
			);
