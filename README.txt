=== Delivery Fees for WooCommerce ===
Contributors: deviodigital
Donate link: https://www.deviodigital.com
Tags: woocommerce, delivery, delivery-fees, courier, shipping, shipping-fees
Requires at least: 3.0.1
Tested up to: 6.2.2
Stable tag: 1.6.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds a custom shipping method to WooCommerce for delivery services.

== Description ==

Delivery Fees for WooCommerce adds a custom shipping method to WooCommerce specifically for delivery services.

When you add the **DFWC Delivery Fees** shipping method to your shipping zone, it automatically turns your WooCommerce store's **Shipping** text into **Delivery**.

## Built for delivery services

WooCommerce lets you add *Shipping Zones* but what about companies who only offer delivery?

That's where the Delivery Fees for WooCommerce plugin comes in!

We know that not all businesses ship products, instead delivering them directly to customers.

So to go along with our [Delivery Drivers](https://www.wordpress.org/plugins/delivery-drivers-for-woocommerce) plugin, we created the Delivery Fees for WooCommerce plugin which adds a custom WooCommerce Shipping Method to cater to delivery services like yours.

## Features

*   Unlimited shipping methods and cost rules
*   Offer free delivery with minimum order
*   Automatically change "Shipping" to "Delivery" in order details.
*   ... and more!

## Pro Features

[Delivery Fees for WooCommerce Pro](https://deviodigital.com/product/delivery-fees-for-woocommerce-pro/) includes the following additional features:

*   Adds Fee types for flat fee or percentage
*   Adds Fee type for distance (per mile)
*   Adds Fee type for time (per minute)
*   Require a minimum order amount before checkout

### Delivery Times for WooCommerce

Our newest plugin gives you a highly customizable way for your customers to select a delivery date and time during checkout.

Learn more at [Delivery Times for WooCommerce](https://www.wordpress.org/plugins/delivery-times-for-woocommerce)

### Delivery Drivers for WooCommerce

This plugin allows offers better driver management for all delivery services who use WooCommerce, streamlining your workflow and increasing your bottom line.

Learn more at [Delivery Drivers for WooCommerce](https://www.wordpress.org/plugins/delivery-drivers-for-woocommerce)

== Installation ==

1. In your dashboard, go to `Plugins -> Add New`
2. Search for `Delivery Fees` and install this plugin
3. Pat yourself on the back for a job well done :)

== Screenshots ==

1. DFWC Delivery Fees Shipping Method options
2. Delivery fee displayed in Checkout (changing "Shipping" to "Delivery")
3. Customer's Order Details page with delivery fee & "Delivery Address" instead of "Shipping Address"
4. Order details in WordPress dashboard with "Delivery" instead of "Shipping"

== Changelog ==

= 1.6.0 =
*   Updated code for PHP 8.0 compatibility in multiple files throughout the plugin
*   Updated text strings for localization for translations found in the `languages` folder

= 1.5.1 =
*   Added new German translation in `languages/dfwc-de_DE.pot`
*   Added new Afrikaans translation in `languages/dfwc-af.pot`
*   Updated WordPress Coding Standards in various areas throughout the plugin
*   General code cleanup in various areas throughout the plugin

= 1.5.0 =
*   Updated various security related issues found with [Codacy](https://codacy.com) throughout multiple files in the plugin

= 1.4.1 =
*   Updated textdomain to use the full plugin slug `delivery-fees-for-woocommerce` in multiple files

= 1.4 =
*   Added new Spanish translation in `languages/dfwc-es_ES.pot`
*   Added new French translation in `languages/dfwc-fr_FR.pot`
*   Added new Italian translation in `languages/dfwc-it_IT.pot`
*   Updated text strings for localization in `languages/dfwc.pot`
*   General code cleanup in various areas throughout the plugin

= 1.3.2 =
*   Added DFWC Pro version check with notice displayed if it's outdated in `delivery-fees-for-woocommerce.php`
*   Bugfix fatal error in backend due to WC session data being called but not found in `admin/dfwc-woocommerce-delivery-fees.php`
*   General code and inline docs updates throughout multiple files in the plugin

= 1.3.1 =

*   General code and inline docs updates throughout multiple files in the plugin

= 1.3 =

*   Bugfix to change Shipping text to Delivery text (bug introduced in v1.2) in `admin/dfwc-woocommerce-delivery-fees.php`
*   Updated to hide "Settings" link except if DFWC Pro is active in `delivery-fees-for-woocommerce.php`
*   Updated and removed public js and css files from loading in `public/class-dfwc-public.php`
*   Updated `.pot` file with text strings for localization in `languages/dfwc.pot`
*   General code cleanup throughout multiple files in the plugin

= 1.2 =

*   Added helper functions file and `is_rest` function in `includes/dfwc-functions.php`
*   Added a 'Settings' link on the All Plugins page in `delivery-fees-for-woocommerce.php`
*   Updated 'Ship to' text on Edit Orders screen for translation in `admin/dfwc-woocommerce-delivery-fees.php`
*   Updated text translation filter priorities in `admin/dfwc-woocommerce-delivery-fees.php`
*   Updated change shipping text function to not run in_admin and in_rest in `admin/dfwc-woocommerce-delivery-fees.php`
*   Updated `.pot` file with text strings for localization in `languages/dfwc.pot`

= 1.1 =

*   Added `dfwc_free_delivery_minimum` filter in `admin/dfwc-woocommerce-delivery-fees.php`
*   Updated code to set default empty variables to remove notices in `admin/dfwc-woocommerce-delivery-fees.php`
*   Updated `Shipping` case for translated text in `admin/dfwc-woocommerce-delivery-fees.php`
*   Updated text strings for localization in `admin/dfwc-woocommerce-delivery-fees.php`
*   Updated `.pot` file with text strings for localization in `languages/dfwc.pot`
*   General code and inline docs updates throughout multiple files in the plugin

= 1.0 =

*   Initial release
