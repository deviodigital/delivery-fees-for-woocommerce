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
 * Devide number
 *
 * @param float $number
 * @param float $divide_by
 * @param float $max
 * @return float
 * @since 1.0
 */
function divideNumber( $number, $divide_by, $max ) {
    if( $number > $max ) {
        return divideNumber( $number/$divide_by, $divide_by, $max );
    } else {
        return $number;
    }
}

/**
 * Delivery Fee Override
 *
 * @param [type] $rates
 * @param [type] $package
 * @return void
 * @since 1.0
 */
function dfwc_package_rate_override( $rates, $package ) {

    global $woocommerce;

    // Cart subtotal.
    $cart_subtotal = WC()->cart->subtotal;

    // Loop through rates.
    foreach ( $rates as $rate ) {
        // DFWC Method ID.
        if ( 'dfwc' === $rate->method_id ) {

            // Get method settings.
            $delivery_cost = get_option( 'woocommerce_' . $rate->method_id . '_' . $rate->instance_id . '_settings' ); 

            // Get free delivery setting value.
            $free_delivery = $delivery_cost['free_delivery'];

            // If minimum order amount is met, change to free delivery.
            if ( '' !== $free_delivery && $free_delivery <= $cart_subtotal ) {
                $rate->cost = '0';
            }
        }
    }

    return $rates;
}
add_filter( 'woocommerce_package_rates', 'dfwc_package_rate_override', 100, 2 );

/**
 * Change "Delivery" label to "FREE" if cost is zero.
 * 
 * @return string
 * @since 1.0
 */
function dfwc_free_delivery_label_text( $label, $method ) {

    if ( 'dfwc' === $method->method_id ) {
        if ( $method->cost <= 0 ) {
            $label = __( 'FREE', 'dfwc' );
        }
    }

    return $label;

}
add_filter( 'woocommerce_cart_shipping_method_full_label', 'dfwc_free_delivery_label_text', 10, 2 );

    }

}
add_action( 'woocommerce_cart_calculate_fees', 'dfwc_add_delivery_fees' );
