<?php

//Works with WooCommerce 3.2.6
function dfwc_shipping_method() {
    if ( ! class_exists( 'WC_DFWC_Shipping_Method' ) ) {
        class WC_DFWC_Shipping_Method extends WC_Shipping_Method {
            public function __construct( $instance_id = 0 ) {
                $this->instance_id 	      = absint( $instance_id );
                $this->id                 = 'dfwc'; //this is the id of our shipping method
                $this->method_title       = __( 'Delivery fee', 'dfwc' );
                $this->method_description = __( 'Add your custom delivery fee for this shipping zone', 'dfwc' );
                // Add to shipping zones list.
                $this->supports = array(
                    'shipping-zones',
                    //'settings', // Use this for separate settings page.
                    'instance-settings',
                    'instance-settings-modal',
                );
                // Make it always enabled.
                $this->title = __( 'DFWC Delivery Fees', 'dfwc' );
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
                /**
                 * @todo turn this into a filterable array for the Pro version.
                 */
                // Fields for the modal form from the Zones window.
                $this->instance_form_fields = array(
                    'title' => array(
                        'title'       => __( 'Title', 'dfwc' ),
                        'type'        => 'text',
                        'description' => '',
                        'default'     => __( 'Delivery', 'dfwc' )
                    ),
                    'cost' => array(
                        'title'       => __( 'Fee', 'dfwc' ),
                        'type'        => 'number',
                        'description' => '',
                        'default'     => 0
                    ),
                    'free_delivery' => array(
                        'title'       => __( 'Free delivery minimum', 'dfwc' ),
                        'type'        => 'number',
                        'description' => '',
                        'default'     => ''
                    ),
                );
                //$this->form_fields - use this with the same array as above for setting fields for separate settings page
            }

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
    //add your shipping method to WooCommers list of Shipping methods
    function add_dfwc_shipping_method( $methods ) {
        $methods['dfwc'] = 'WC_DFWC_Shipping_Method';
        return $methods;
    }
    add_filter( 'woocommerce_shipping_methods', 'add_dfwc_shipping_method' );
}
add_action( 'woocommerce_shipping_init', 'dfwc_shipping_method' );
