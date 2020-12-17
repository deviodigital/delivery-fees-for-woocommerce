<?php
/**
 * The WooCommerce Shipping Method functionality of the plugin.
 *
 * @link       https://www.deviodigital.com
 * @since      1.0.0
 *
 * @package    DFWC
 * @subpackage DFWC/admin
 */

/**
 * Add the DFWC Shipping Method
 * 
 * @return void
 */
function dfwc_shipping_method() {
    if ( ! class_exists( 'WC_DFWC_Shipping_Method' ) ) {
        class WC_DFWC_Shipping_Method extends WC_Shipping_Method {
            public function __construct( $instance_id = 0 ) {
                $this->instance_id 	      = absint( $instance_id );
                $this->id                 = 'dfwc'; //this is the id of our shipping method
                $this->method_title       = esc_attr__( 'Delivery Fees', 'dfwc' );
                $this->method_description = esc_attr__( 'Add your custom delivery fee for this shipping zone', 'dfwc' );
                // Add to shipping zones list.
                $this->supports = array(
                    'shipping-zones',
                    //'settings', // Use this for separate settings page.
                    'instance-settings',
                    'instance-settings-modal',
                );
                // Make it always enabled.
                $this->title = esc_attr__( 'DFWC Delivery Fees', 'dfwc' );
                $this->init();
            }
            function init() {
                // Load the settings API
                $this->init_form_fields();
                $this->init_settings();
                // Save settings in admin if you have any defined
                add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
            }
            // Fields for the settings page.
            function init_form_fields() {
                $dfwc_instance_fields = array(
                    'title' => array(
                        'title'       => esc_attr__( 'Title', 'dfwc' ),
                        'type'        => 'text',
                        'description' => '',
                        'default'     => esc_attr__( 'Delivery', 'dfwc' )
                    ),
                    'cost' => array(
                        'title'       => esc_attr__( 'Fee', 'dfwc' ),
                        'type'        => 'number',
                        'description' => '',
                        'default'     => 0
                    ),
                    'free_delivery' => array(
                        'title'       => esc_attr__( 'Free delivery minimum', 'dfwc' ),
                        'type'        => 'number',
                        'description' => '',
                        'default'     => ''
                    ),
                );

                // Fields for the modal form from the Zones window.
                $this->instance_form_fields = apply_filters( 'dfwc_instance_form_fields', $dfwc_instance_fields );
                //$this->form_fields - use this with the same array as above for setting fields for separate settings page
            }
            // Calculate shipping.
            public function calculate_shipping( $package = array() ) {
                // As we are using instances for the cost and the title we need to take those values from the instance_settings
                $intance_settings =  $this->instance_settings;
                // Register the rate.
                $this->add_rate( array(
                    'id'      => $this->id,
                    'label'   => $intance_settings['title'],
                    'cost'    => $intance_settings['cost'],
                    'package' => $package,
                    'taxes'   => false,
                ) );
            }
        }
    }
    // Add your shipping method to WooCommers list of Shipping methods
    function add_dfwc_shipping_method( $methods ) {
        $methods['dfwc'] = 'WC_DFWC_Shipping_Method';
        return $methods;
    }
    add_filter( 'woocommerce_shipping_methods', 'add_dfwc_shipping_method' );
}
add_action( 'woocommerce_shipping_init', 'dfwc_shipping_method' );
