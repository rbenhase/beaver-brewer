<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://beaverbrewer.com
 * @since      0.1.0
 *
 * @package    Beaver_Brewer
 * @subpackage Beaver_Brewer/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      0.1.0
 * @package    Beaver_Brewer
 * @subpackage Beaver_Brewer/includes
 * @author     Ryan Benhase <ryan@beaverbrewer.com>
 */
class Beaver_Brewer_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    0.1.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'beaver-brewer',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
