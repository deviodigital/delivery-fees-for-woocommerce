<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.deviodigital.com
 * @since      1.0.0
 *
 * @package    DFWC
 * @subpackage DFWC/admin
 */

/**
 * Add delivery fees
 * 
 * @since 1.0
 */
function dfwc_add_delivery_fees() {

    global $woocommerce;

    // Set delivery fee.
	if ( null !== get_option( 'dfwc_settings_delivery_fee_amount' ) && '' !== get_option( 'dfwc_settings_delivery_fee_amount' ) ) {
        $delivery_cost = get_option( 'dfwc_settings_delivery_fee_amount' );
    } else {
        $delivery_cost = '0';
    }

    // Add delivery fee.
    if ( '0' != $delivery_cost ) {
        $woocommerce->cart->add_fee( __( 'Delivery', 'dfwc' ), number_format((float)$delivery_cost, 2, '.', ',' ) );
    }

}
add_action( 'woocommerce_cart_calculate_fees', 'dfwc_add_delivery_fees' );
