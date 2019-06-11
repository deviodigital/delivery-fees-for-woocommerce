<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.deviodigital.com
 * @since             1.0.0
 * @package           DFWC
 *
 * @wordpress-plugin
 * Plugin Name:       Delivery Fees for WooCommerce
 * Plugin URI:        https://www.deviodigital.com/delivery-fees-for-woocommerce
 * Description:       Adds a custom shipping method to WooCommerce for delivery services.
 * Version:           1.1
 * Author:            Devio Digital
 * Author URI:        https://www.deviodigital.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       dfwc
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'DFWC_VERSION', '1.1' );

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
	// Get GO PRO link.
	$pro_link = '<a href="https://deviodigital.com/product/delivery-fees-for-woocommerce-pro/" target="_blank" style="font-weight:700;">' . __( 'Go Pro', 'dfwc' ) . '</a>';

	// Add GO PRO link.
	if ( ! function_exists( 'run_dfwc_pro' ) ) {
		array_unshift( $links, $pro_link );
	}

	return $links;
}

$pluginname = plugin_basename( __FILE__ );

add_filter( "plugin_action_links_$pluginname", 'dfwc_settings_link' );
