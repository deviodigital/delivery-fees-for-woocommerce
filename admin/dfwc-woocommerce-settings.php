<?php

/**
 * Custom Class for Woocommerce Settings
 *
 * @link       https://www.deviodigital.com
 * @since      1.0.0
 *
 * @package    DFWC
 * @subpackage DFWC/admin
 */
class Delivery_Fees_WooCommerce_Settings {
	/**
	* Bootstraps the class and hooks required actions & filters.
	*
	*/
	public static function init() {
	   add_filter( 'woocommerce_settings_tabs_array', __CLASS__ . '::add_settings_tab', 50 );
	   add_action( 'woocommerce_settings_tabs_dfwc', __CLASS__ . '::settings_tab' );
	   add_action( 'woocommerce_update_options_dfwc', __CLASS__ . '::update_settings' );
	   //add custom type.
	   add_action( 'woocommerce_admin_field_custom_type', __CLASS__ . '::output_custom_type', 10, 1 );
	}

	public static function output_custom_type( $value ) {
	 	//you can output the custom type in any format you'd like.
		echo $value['desc'];
	}

	/**
	* Add a new settings tab to the WooCommerce settings tabs array.
	*
	* @param array $settings_tabs Array of WooCommerce setting tabs & their labels, excluding the Subscription tab.
	* @return array $settings_tabs Array of WooCommerce setting tabs & their labels, including the Subscription tab.
	*/
	public static function add_settings_tab( $settings_tabs ) {
	   $settings_tabs['dfwc'] = __( 'Delivery Fees', 'dfwc' );
	   return $settings_tabs;
	}
	/**
	* Uses the WooCommerce admin fields API to output settings via the @see woocommerce_admin_fields() function.
	*
	* @uses woocommerce_admin_fields()
	* @uses self::get_settings()
	*/
	public static function settings_tab() {
	   woocommerce_admin_fields( self::get_settings() );
	}
	/**
	* Uses the WooCommerce options API to save settings via the @see woocommerce_update_options() function.
	*
	* @uses woocommerce_update_options()
	* @uses self::get_settings()
	*/
	public static function update_settings() {
	   woocommerce_update_options( self::get_settings() );
	}

	/**
	* Get all the settings for this plugin for @see woocommerce_admin_fields() function.
	*
	* @return array Array of settings for @see woocommerce_admin_fields() function.
	*/
	public static function get_settings() {

		// Get loop of all Pages.
		$args = array(
			'sort_column'  => 'post_title',
			'hierarchical' => 1,
			'post_type'    => 'page',
			'post_status'  => 'publish'
		);
		$pages = get_pages( $args );

		// Create data array.
		$pages_array = array( 'none' => '' );

		// Loop through pages.
		foreach ( $pages as $page ) {
			$pages_array[ $page->ID ] = $page->post_title;
		}

		$settings = array(
			// Section title.
			'dfwc_settings_section_title' => array(
			    'name' => __( 'Delivery Fees for WooCommerce', 'dfwc' ),
			    'type' => 'title',
			    'desc' => __( 'Brought to you by <a href="https://www.deviodigital.com" target="_blank">Devio Digital</a>', 'dfwc' ),
			    'id'   => 'dfwc_settings_section_title'
			),
			// Delivery fee type.
			'delivery_fee_type' => array(
				'name'    => __( 'Delivery fee type', 'dfwc' ),
				'type'    => 'select',
				'desc'    => __( 'Choose the type of delivery fee you would like to add', 'dfwc' ),
				'id'      => 'dfwc_settings_delivery_fee_type',
				'options' => array(
					'none'       => '',
					'flat-rate'  => 'Flat Rate',
					'percentage' => 'Percentage',
				),
			),
			// Delivery fee amount.
			'delivery_fee_amount' => array(
				'name' => __( 'Delivery fee amount', 'dfwc' ),
				'type' => 'text',
				'desc' => __( 'Add the amount you would like to charge for delivery', 'dfwc' ),
				'id'   => 'dfwc_settings_delivery_fee_amount'
			),
			// Delivery fee free amount.
			'delivery_fee_free_amount' => array(
				'name' => __( 'Free delivery minimum', 'dfwc' ),
				'type' => 'text',
				'desc' => __( 'Add the minimum amount required before applying free delivery', 'dfwc' ),
				'id'   => 'dfwc_settings_delivery_fee_free_amount'
			),
			// Section End.
			'section_end' => array(
				'type' => 'sectionend',
				'id'   => 'dfwc_settings_section_end'
			),
		);
		return apply_filters( 'dfwc_woocommerce_settings', $settings );

	}
}
Delivery_Fees_WooCommerce_Settings::init();
