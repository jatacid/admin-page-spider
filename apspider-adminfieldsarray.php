<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $fields;
//Settings fields array containing all settings used in the plugin
$fields = array(

			array(
				'uid' => 'apspider_editmenu_name',
				'label' => __( 'Name for the Wordpress Pages Menu?', 'admin-page-spider'),
				'section' => 'first_section',
				'type' => 'text',
				'supplemental' => __( 'The name of the menu item in the Admin Bar', 'admin-page-spider'),
				'default' => 'Wordpress Pages'
			),

			array(
				'uid' => 'apspider_radio_editmenu',
				'label' => __( 'Display The Wordpress Pages Menu?' , 'admin-page-spider' ),
				'section' => 'first_section',
				'type' => 'radio',
				'supplemental' => __( 'Easy access to edit each page.', 'admin-page-spider'),
				'options' => array(
					'option1' => __( 'Display' , 'admin-page-spider' ),
					'option2' => __( 'Hide' , 'admin-page-spider' ),
					),
				'default' => array('option1')
				),

			);