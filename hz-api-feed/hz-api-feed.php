<?php

/**
 * @link              https://facebook.com/humayoon.zahoor
 * @since             1.0.0
 * @package           Hz_Api_Feed
 *
 * @wordpress-plugin
 * Plugin Name:       HZ API-Feed
 * Plugin URI:        https://web.facebook.com/humayoon.zahoor
 * Description:       Use shortcode [charity-commission] to display.
 * Version:           1.0.0
 * Author:            Humayoon Zahoor
 * Author URI:        https://facebook.com/humayoon.zahoor
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       hz-api-feed
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'HZ_API_FEED_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-hz-api-feed-activator.php
 */
function activate_hz_api_feed() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-hz-api-feed-activator.php';
	Hz_Api_Feed_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-hz-api-feed-deactivator.php
 */
function deactivate_hz_api_feed() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-hz-api-feed-deactivator.php';
	Hz_Api_Feed_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_hz_api_feed' );
register_deactivation_hook( __FILE__, 'deactivate_hz_api_feed' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-hz-api-feed.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_hz_api_feed() {

	$plugin = new Hz_Api_Feed();
	$plugin->run();

}
run_hz_api_feed();
