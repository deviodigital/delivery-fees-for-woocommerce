<?php
/**
 * The delivery fee functionality of the plugin.
 *
 * @link       https://www.deviodigital.com
 * @since      1.0.0
 *
 * @package    DFWC
 * @subpackage DFWC/admin
 */

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
add_filter( 'woocommerce_package_rates', 'dfwc_package_rate_override', 100, 2 );

/**
 * Remove Shipping Label from Cart/Checkout.
 *
 * @param [type] $label
 * @param [type] $method
 * @return string
 */
function dfwc_remove_shipping_label( $label, $method ) {
    $new_label = preg_replace( '/^.+:/', '', $label );
    return $new_label;
}

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

/**
 * Change "Shipping" text to "Delivery" on WC pages.
 * 
 * @since 1.0
 */
function dfwc_change_shipping_text_on_woocommerce_pages( $order_id ) {

    // An instance of the order.
    $order = wc_get_order( $order_id );

    // Create empty variable.
    $shipping_method_id = '';

    // Iterating through order shipping items.
    foreach( $order->get_items( 'shipping' ) as $item_id => $shipping_item_obj ){
        $order_item_name           = $shipping_item_obj->get_name();
        $order_item_type           = $shipping_item_obj->get_type();
        $shipping_method_title     = $shipping_item_obj->get_method_title();
        $shipping_method_id        = $shipping_item_obj->get_method_id();
        $shipping_method_total     = $shipping_item_obj->get_total();
        $shipping_method_total_tax = $shipping_item_obj->get_total_tax();
        $shipping_method_taxes     = $shipping_item_obj->get_taxes();
    }

    // If DFWC shipping method is set.
    if ( 'dfwc' === $shipping_method_id ) {
        add_filter( 'gettext', 'dfwc_shipping_field_strings3', 99, 3 );
        add_filter( 'gettext', 'dfwc_shipping_field_strings2', 99, 3 );
    }
}
add_action( 'woocommerce_thankyou', 'dfwc_change_shipping_text_on_woocommerce_pages' );
add_action( 'woocommerce_view_order', 'dfwc_change_shipping_text_on_woocommerce_pages' );


/**
 * Change "Shipping" text to "Delivery" on WooCommerce pages.
 * 
 * @since 1.0
 */
function dfwc_change_shipping_text_on_woocommerce_edit_order() {

    // An instance of the order.
    $order = wc_get_order( $_GET['post'] );

    // Create empty variable.
    $shipping_method_id = '';

    // Iterating through order shipping items.
    foreach( $order->get_items( 'shipping' ) as $item_id => $shipping_item_obj ) {
        $order_item_name           = $shipping_item_obj->get_name();
        $order_item_type           = $shipping_item_obj->get_type();
        $shipping_method_title     = $shipping_item_obj->get_method_title();
        $shipping_method_id        = $shipping_item_obj->get_method_id();
        $shipping_method_total     = $shipping_item_obj->get_total();
        $shipping_method_total_tax = $shipping_item_obj->get_total_tax();
        $shipping_method_taxes     = $shipping_item_obj->get_taxes();
    }

    if ( is_admin() ) {
        // If DFWC shipping method is set.
        if ( 'dfwc' === $shipping_method_id ) {
            add_filter( 'gettext', 'dfwc_shipping_field_strings4', 99, 3 );
            add_filter( 'gettext', 'dfwc_shipping_field_strings3', 99, 3 );
            add_filter( 'gettext', 'dfwc_shipping_field_strings2', 99, 3 );
        }
    }
}
add_action( 'woocommerce_after_order_itemmeta', 'dfwc_change_shipping_text_on_woocommerce_edit_order' );

/**
 * Change the Shipping Address checkout label.
 *
 * @param [type] $translated_text
 * @param [type] $text
 * @param [type] $domain
 * @return void
 * @since 1.0
 */
function dfwc_shipping_field_strings( $translated_text, $text, $domain ) {
    switch ( $translated_text ) {
    case 'Shipping Address' :
        $translated_text = __( 'Delivery Address', 'dfwc' );
        break;
    }
    return $translated_text;
}

/**
 * Change Shipping: to Delivery:
 *
 * @param string $translated_text
 * @param string $text
 * @param string $domain
 * @return string
 * @since 1.0
 */
function dfwc_shipping_field_strings2( $translated_text, $text, $domain ) {
    global $post;

    switch ( $translated_text ) {
        case 'Shipping:' :
        $translated_text = __( 'Delivery:', 'dfwc' );
        break;
    }
    return $translated_text;
}

/**
 * Change the Shipping address checkout label.
 *
 * @param [type] $translated_text
 * @param [type] $text
 * @param [type] $domain
 * @return void
 * @since 1.0
 */
function dfwc_shipping_field_strings3( $translated_text, $text, $domain ) {
    switch ( $translated_text ) {
    case 'Shipping address' :
        $translated_text = __( 'Delivery address', 'dfwc' );
        break;
    }
    return $translated_text;
}

/**
 * Change the Shipping address checkout label.
 *
 * @param [type] $translated_text
 * @param [type] $text
 * @param [type] $domain
 * @return void
 * @since 1.0
 */
function dfwc_shipping_field_strings4( $translated_text, $text, $domain ) {
    switch ( $translated_text ) {
    case 'Shipping' :
        $translated_text = __( 'Delivery', 'dfwc' );
        break;
    }
    return $translated_text;
}

/**
 * Change the Ship to a different address text.
 *
 * @param string $translated_text
 * @param string $text
 * @param string $domain
 * @return string
 * @since 1.0
 */
function dfwc_strings_translation( $translated_text, $text, $domain ) {
    switch ( $translated_text ) {
    case 'Ship to a different address?' :
        $translated_text =  __( 'Deliver to a different address?', 'dfwc' );
        break;
    }
    return $translated_text;
}

/**
 *
 * Function to replace shipping text to delivery text
 *
 * @param $package_name
 * @param $i
 * @param $package
 * @return string
 * @since 1.0
 */
function dfwc_delivery_text( $package_name, $i, $package ) {
    return sprintf( _nx( 'Delivery', 'Delivery %d', ( $i + 1 ), 'shipping packages', 'dfwc' ), ( $i + 1 ) );
}

/**
 * Change the string "Shipping" to "Delivery" on Order Received page.
 *
 * @param [type] $translated
 * @return void
 * @since 1.0
 */
function dfwc_translate_reply( $translated ) {
    $translated = str_ireplace( 'Shipping', 'Delivery', $translated );
    return $translated;
}

/**
 * Change "Shipping" to "Delivery" text if chosen shipping method is
 * the custom DFWC Delivery method.
 *
 * @return void
 * @since 1.0
 */
function dfwc_change_shipping_text() {

    global $woocommerce;

    // Front end only.
    if ( ! is_admin() ) {
        $chosen_methods          = WC()->session->get( 'chosen_shipping_methods' );
        $chosen_shipping_no_ajax = $chosen_methods[0];

        if ( 0 === strpos( $chosen_shipping_no_ajax, 'dfwc' ) ) {
            add_filter( 'gettext', 'dfwc_shipping_field_strings', 99, 3 );
            add_filter( 'gettext', 'dfwc_shipping_field_strings2', 99, 3 );
            add_filter( 'gettext', 'dfwc_strings_translation', 99, 3 );
            add_filter( 'woocommerce_shipping_package_name' , 'dfwc_delivery_text', 99, 3 );
            add_filter( 'woocommerce_cart_shipping_method_full_label', 'dfwc_remove_shipping_label', 99, 2 );
            add_filter( 'gettext', 'dfwc_translate_reply' );
            add_filter( 'ngettext', 'dfwc_translate_reply' );
        }
    }
}
add_action( 'init', 'dfwc_change_shipping_text', 99 );

/**
 * Translate 'Ship to' text on WooCommerce Edit Orders screen
 *
 * @param string $translated
 * @return void
 */
function dfwc_translate_reply_ship_to( $translated ) {
	$translated = str_ireplace( 'Ship to', 'Deliver to', $translated );
	return $translated;
}
add_filter( 'gettext', 'dfwc_translate_reply_ship_to' );
add_filter( 'ngettext', 'dfwc_translate_reply_ship_to' );
