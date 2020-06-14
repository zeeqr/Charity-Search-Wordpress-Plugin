<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://facebook.com/humayoon.zahoor
 * @since      1.0.0
 *
 * @package    Hz_Api_Feed
 * @subpackage Hz_Api_Feed/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Hz_Api_Feed
 * @subpackage Hz_Api_Feed/includes
 * @author     Humayoon Zahoor <humayoon.zahoor@gmail.com>
 */
class Hz_Api_Feed_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'hz-api-feed',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
