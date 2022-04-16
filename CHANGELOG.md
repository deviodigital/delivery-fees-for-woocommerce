# Changelog

## 1.5.0
*   Updated various security related issues found with [Codacy](https://codacy.com) throughout multiple files in the plugin

## 1.4.1
*   Updated textdomain to use the full plugin slug `delivery-fees-for-woocommerce` in multiple files

## 1.4
*   Added new Spanish translation in `languages/dfwc-es_ES.pot`
*   Added new French translation in `languages/dfwc-fr_FR.pot`
*   Added new Italian translation in `languages/dfwc-it_IT.pot`
*   Updated text strings for localization in `languages/dfwc.pot`
*   General code cleanup in various areas throughout the plugin

## 1.3.2
*   Added DFWC Pro version check with notice displayed if it's outdated in `delivery-fees-for-woocommerce.php`
*   Bugfix fatal error in backend due to WC session data being called but not found in `admin/dfwc-woocommerce-delivery-fees.php`
*   General code and inline docs updates throughout multiple files in the plugin

## 1.3.1
*   General code and inline docs updates throughout multiple files in the plugin

## 1.3

*   Bugfix to change Shipping text to Delivery text (bug introduced in v1.2) in `admin/dfwc-woocommerce-delivery-fees.php`
*   Updated to hide "Settings" link except if DFWC Pro is active in `delivery-fees-for-woocommerce.php`
*   Updated and removed public js and css files from loading in `public/class-dfwc-public.php`
*   Updated `.pot` file with text strings for localization in `languages/dfwc.pot`
*   General code cleanup throughout multiple files in the plugin

## 1.2

*   Added helper functions file and `is_rest` function in `includes/dfwc-functions.php`
*   Added a 'Settings' link on the All Plugins page in `delivery-fees-for-woocommerce.php`
*   Updated 'Ship to' text on Edit Orders screen for translation in `admin/dfwc-woocommerce-delivery-fees.php`
*   Updated text translation filter priorities in `admin/dfwc-woocommerce-delivery-fees.php`
*   Updated change shipping text function to not run in_admin and in_rest in `admin/dfwc-woocommerce-delivery-fees.php`
*   Updated `.pot` file with text strings for localization in `languages/dfwc.pot`

## 1.1

*   Added `dfwc_free_delivery_minimum` filter in `admin/dfwc-woocommerce-delivery-fees.php`
*   Updated code to set default empty variables to remove notices in `admin/dfwc-woocommerce-delivery-fees.php`
*   Updated `Shipping` case for translated text in `admin/dfwc-woocommerce-delivery-fees.php`
*   Updated text strings for localization in `admin/dfwc-woocommerce-delivery-fees.php`
*   Updated `.pot` file with text strings for localization in `languages/dfwc.pot`
*   General code and inline docs updates throughout multiple files in the plugin

## 1.0

*   Initial release
