<?php
/**
 * The plugin bootstrap file
 *
 * @link              https://www.deviodigital.com
 * @since             1.0.0
 * @package           DFWC
 *
 * @wordpress-plugin
 * Plugin Name:          Delivery Fees for WooCommerce
 * Plugin URI:           https://www.deviodigital.com/delivery-fees-for-woocommerce
 * Description:          Adds a custom shipping method to WooCommerce for delivery services.
 * Version:              1.5.0
 * Author:               Devio Digital
 * Author URI:           https://www.deviodigital.com
 * License:              GPL-2.0+
 * License URI:          http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:          delivery-fees-for-woocommerce
 * Domain Path:          /languages
 * WC requires at least: 3.5.0
 * WC tested up to:      5.6.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	wp_die();
}

/**
 * Current plugin version.
 */
define( 'DFWC_VERSION', '1.5.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-dfwc-activator.php
 */
function activate_dfwc() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dfwc-activator.php';
	DFWC_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-dfwc-deactivator.php
 */
function deactivate_dfwc() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dfwc-deactivator.php';
	DFWC_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_dfwc' );
register_deactivation_hook( __FILE__, 'deactivate_dfwc' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-dfwc.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_dfwc() {

	$plugin = new DFWC();
	$plugin->run();

}
run_dfwc();

/**
 * Add Go Pro link on plugin page
 *
 * @since 1.0.0
 * @param array $links an array of links related to the plugin.
 * @return array updatead array of links related to the plugin.
 */
function dfwc_settings_link( $links ) {
	// Get Settings link.
	$settings_link = '<a href="admin.php?page=wc-settings&tab=dfwc">' . esc_attr__( 'Settings', 'delivery-fees-for-woocommerce' ) . '</a>';
	// Get GO PRO link.
	$pro_link = '<a href="https://deviodigital.com/product/delivery-fees-for-woocommerce-pro/" target="_blank" style="font-weight:700;">' . esc_attr__( 'Go Pro', 'delivery-fees-for-woocommerce' ) . '</a>';

	// Add 'GO PRO' link.
	if ( ! function_exists( 'run_dfwc_pro' ) ) {
		array_unshift( $links, $pro_link );
	}

	// Add 'Settings' link.
	if ( function_exists( 'run_dfwc_pro' ) ) {
		array_unshift( $links, $settings_link );
	}

	return $links;
}

$pluginname = plugin_basename( __FILE__ );

add_filter( "plugin_action_links_$pluginname", 'dfwc_settings_link' );

/**
 * Check DFWC Pro version number.
 *
 * If the DFWC Pro version number is less than what's defined below, there will
 * be a notice added to the admin screen letting the user know there's a new
 * version of the DFWC Pro plugin available.
 *
 * @since 1.4
 */
function dfwc_check_pro_version() {
	// Only run if DFWC Pro is active.
	if ( function_exists( 'dfwc_pro_all_settings' ) ) {
		// Check if DFWC Pro version is defined.
		if ( ! defined( 'DFWC_PRO_VERSION' ) ) {
			define( 'DFWC_PRO_VERSION', 0 ); // default to zero.
		}
		// Set pro version number.
		$pro_version = DFWC_PRO_VERSION;
		// Check pro version number.
		if ( '0' == $pro_version || $pro_version < '1.3' ) {
			// Add DFWC Pro version upgrade notice to admin notices.
			add_action( 'admin_notices', 'dfwc_update_dfwc_pro_notice' );
		}
	}
}
add_action( 'admin_init', 'dfwc_check_pro_version' );

/**
 * Error notice - Runs if DFWC Pro is out of date.
 *
 * @see dfwc_check_pro_version()
 * @since 2.9
 */
function dfwc_update_dfwc_pro_notice() {
	$dfwc_orders = '<a href="https://www.deviodigital.com/my-account/orders/" target="_blank">' . esc_attr__( 'Orders', 'delivery-fees-for-woocommerce' ) . '</a>';
	$error       = sprintf( esc_html__( 'There is a new version of DFWC Pro available. Download your copy from the %1$s page on Devio Digital.', 'delivery-fees-for-woocommerce' ), $dfwc_orders );
	echo '<div class="notice notice-info"><p>' . $error . '</p></div>';
}
