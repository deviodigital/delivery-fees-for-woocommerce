<?php
/**
 * The delivery fee functionality of the plugin.
 *
 * @package    DFWC
 * @subpackage DFWC/admin
 * @author     Devio Digital <contact@deviodigital.com>
 * @license    GPL-2.0+ http://www.gnu.org/licenses/gpl-2.0.txt
 * @link       https://www.deviodigital.com
 * @since      1.0.0
 */

/**
 * Delivery Fee Override
 *
 * @param array $rates 
 * 
 * @since  1.0
 * @return void
 */
function dfwc_package_rate_override( $rates ) {

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

            // Filter the free delivery minimum.
            $free_delivery = apply_filters( 'dfwc_free_delivery_minimum', $free_delivery );

            // If minimum order amount is met, change to free delivery.
            if ( '' !== $free_delivery && $free_delivery <= $cart_subtotal ) {
                $rate->cost = apply_filters( 'dfwc_free_delivery_cost', '0' );
            }
        }
    }

    return $rates;
}
add_filter( 'woocommerce_package_rates', 'dfwc_package_rate_override', 100, 1 );

/**
 * Remove Shipping Label from Cart/Checkout.
 *
 * @param string $label 
 * 
 * @return string
 */
function dfwc_remove_shipping_label( $label ) {
    $new_label = preg_replace( '/^.+:/', '', $label );
    return $new_label;
}

/**
 * Change "Delivery" label to "FREE" if cost is zero.
 * 
 * @param string $label 
 * @param object $method 
 * 
 * @since  1.0
 * @return string
 */
function dfwc_free_delivery_label_text( $label, $method ) {

    // Update the label?
    if ( 'dfwc' === $method->method_id && $method->cost <= 0 ) {
        $label = esc_attr__( 'FREE', 'delivery-fees-for-woocommerce' );
    }

    return $label;
}
add_filter( 'woocommerce_cart_shipping_method_full_label', 'dfwc_free_delivery_label_text', 10, 2 );

/**
 * Change "Shipping" text to "Delivery" on WC pages.
 * 
 * @param int $order_id 
 * 
 * @since  1.0
 * @return void
 */
function dfwc_change_shipping_text_on_woocommerce_pages( $order_id ) {

    // An instance of the order.
    $order = wc_get_order( $order_id );

    // Create empty variable.
    $shipping_method_id = '';

    // Iterating through order shipping items.
    foreach ( $order->get_items( 'shipping' ) as $shipping_item_obj ) {
        $shipping_method_id = $shipping_item_obj->get_method_id();
    }

    // If DFWC shipping method is set.
    if ( 'dfwc' === $shipping_method_id ) {
        add_filter( 'gettext', 'dfwc_shipping_field_strings3', 99, 1 );
        add_filter( 'gettext', 'dfwc_shipping_field_strings2', 99, 1 );
    }
}
add_action( 'woocommerce_thankyou', 'dfwc_change_shipping_text_on_woocommerce_pages' );
add_action( 'woocommerce_view_order', 'dfwc_change_shipping_text_on_woocommerce_pages' );


/**
 * Change "Shipping" text to "Delivery" on WooCommerce pages.
 * 
 * @since  1.0
 * @return void
 */
function dfwc_change_shipping_text_on_woocommerce_edit_order() {

    // An instance of the order.
    $order = wc_get_order( filter_input( INPUT_GET, 'post' ) );

    // Create empty variable.
    $shipping_method_id = '';

    // Iterating through order shipping items.
    foreach ( $order->get_items( 'shipping' ) as $shipping_item_obj ) {
        $shipping_method_id = $shipping_item_obj->get_method_id();
    }

    if ( is_admin() ) {
        // If DFWC shipping method is set.
        if ( 'dfwc' === $shipping_method_id ) {
            add_filter( 'gettext', 'dfwc_shipping_field_strings4', 99, 1 );
            add_filter( 'gettext', 'dfwc_shipping_field_strings3', 99, 1 );
            add_filter( 'gettext', 'dfwc_shipping_field_strings2', 99, 1 );
        }
    }
}
add_action( 'woocommerce_after_order_itemmeta', 'dfwc_change_shipping_text_on_woocommerce_edit_order' );

/**
 * Change the Shipping Address checkout label.
 *
 * @param array $translated_text 
 * 
 * @since  1.0
 * @return array
 */
function dfwc_shipping_field_strings( $translated_text ) {
    switch ( $translated_text ) {
    case 'Shipping Address' :
        $translated_text = esc_attr__( 'Delivery Address', 'delivery-fees-for-woocommerce' );
        break;
    }
    return $translated_text;
}

/**
 * Change Shipping: to Delivery:
 *
 * @param array $translated_text 
 * 
 * @since  1.0
 * @return string
 */
function dfwc_shipping_field_strings2( $translated_text ) {
    switch ( $translated_text ) {
    case 'Shipping:' :
        $translated_text = esc_attr__( 'Delivery:', 'delivery-fees-for-woocommerce' );
        break;
    }
    return $translated_text;
}

/**
 * Change the Shipping address checkout label.
 *
 * @param array $translated_text 
 * 
 * @since  1.0
 * @return string
 */
function dfwc_shipping_field_strings3( $translated_text ) {
    switch ( $translated_text ) {
    case 'Shipping address' :
        $translated_text = esc_attr__( 'Delivery address', 'delivery-fees-for-woocommerce' );
        break;
    }
    return $translated_text;
}

/**
 * Change the Shipping address checkout label.
 *
 * @param array $translated_text 
 * 
 * @since  1.0
 * @return void
 */
function dfwc_shipping_field_strings4( $translated_text ) {
    switch ( $translated_text ) {
    case 'Shipping' :
        $translated_text = esc_attr__( 'Delivery', 'delivery-fees-for-woocommerce' );
        break;
    }
    return $translated_text;
}

/**
 * Change the Ship to a different address text.
 *
 * @param array $translated_text 
 *
 * @since  1.0
 * @return string
 */
function dfwc_strings_translation( $translated_text ) {
    switch ( $translated_text ) {
    case 'Ship to a different address?' :
        $translated_text =  esc_attr__( 'Deliver to a different address?', 'delivery-fees-for-woocommerce' );
        break;
    }
    return $translated_text;
}

/**
 * Function to replace shipping text to delivery text
 *
 * @param int $num 
 * 
 * @since  1.0
 * @return string
 */
function dfwc_delivery_text( $num ) {
    return sprintf( _nx( 'Delivery', 'Delivery %d', ( $num + 1 ), 'shipping packages', 'delivery-fees-for-woocommerce' ), ( $num + 1 ) );
}

/**
 * Change the string "Shipping" to "Delivery" on Order Received page.
 *
 * @param string $translated 
 * 
 * @since  1.0
 * @return string
 */
function dfwc_translate_reply( $translated ) {
    $translated = str_ireplace( 'Shipping', 'Delivery', $translated );
    return $translated;
}

/**
 * Change "Shipping" to "Delivery" text if chosen shipping method is
 * the custom DFWC Delivery method.
 *
 * @since  1.0
 * @return void
 */
function dfwc_change_shipping_text() {

    global $woocommerce;

    // Front end only with an active WooCommerce session.
    if ( ! is_rest() && ! is_admin() && null != WC()->session ) {
        // Chosen shipping method.
        $chosen_methods = WC()->session->get( 'chosen_shipping_methods' );
        // Check chosen shipping method.
        if ( is_array( $chosen_methods ) && count( $chosen_methods ) > 0 && false !== $chosen_methods[0] ) {
            // Translation for DFWC shipping method.
            if ( 'dfwc' == $chosen_methods[0] ) {
                add_filter( 'gettext', 'dfwc_shipping_field_strings', 99, 1 );
                add_filter( 'gettext', 'dfwc_shipping_field_strings2', 99, 1 );
                add_filter( 'gettext', 'dfwc_strings_translation', 99, 1 );
                add_filter( 'woocommerce_shipping_package_name', 'dfwc_delivery_text', 99, 2 );
                add_filter( 'woocommerce_cart_shipping_method_full_label', 'dfwc_remove_shipping_label', 99, 1 );
                add_filter( 'gettext', 'dfwc_translate_reply' );
                add_filter( 'ngettext', 'dfwc_translate_reply' );
            }
        }
    }
}
add_action( 'init', 'dfwc_change_shipping_text', 99 );

/**
 * Translate 'Ship to' text on WooCommerce Edit Orders screen
 *
 * @param string $translated 
 * 
 * @return string
 */
function dfwc_translate_reply_ship_to( $translated ) {
    $translated = str_ireplace( 'Ship to', 'Deliver to', $translated );
    return $translated;
}
add_filter( 'gettext', 'dfwc_translate_reply_ship_to' );
add_filter( 'ngettext', 'dfwc_translate_reply_ship_to' );
