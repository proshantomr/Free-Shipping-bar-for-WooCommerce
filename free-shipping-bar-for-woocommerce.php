<?php

/**
 * Plugin Name:       Free Shipping Bar
 * Plugin URI:        https://woocopilot.com/plugins/free-shipping-bar/
 * Description:       The Free Shipping Bar plugin allows store owners to easily add a customizable notification bar to their WooCommerce store, highlighting free shipping offers, minimum purchase requirements, and limited-time shipping deals.
 * Version:           1.0.0
 * Requires at least: 6.5
 * Requires PHP:      7.2
 * Author:            WooCopilot
 * Author URI:        https://woocopilot.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       fsb
 * Domain Path:       /languages
 */

defined('ABSPATH') || exit;

// Including classes.
require_once __DIR__ . '/includes/class-admin-free-shipping-bar-for-woocommerce.php';
require_once __DIR__ . '/includes/class-free-shipping-bar-for-woocommerce.php';

/**
 * Initializing plugin.
 *
 * @since 1.0.0
 * @return object Plugin object.
 */
function free_shipping_bar_for_woocommerce() {
    return new Free_Shipping_Bar_For_Woocommerce(__FILE__, '1.0.0');
}
free_shipping_bar_for_woocommerce();
