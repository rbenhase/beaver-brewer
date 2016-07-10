<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://beaverbrewer.com
 * @since             0.1.0
 * @package           Beaver_Brewer
 *
 * @wordpress-plugin
 * Plugin Name:       Beaver Brewer
 * Plugin URI:        http://beaverbrewer.com/
 * Description:       Enables a la carte installation of custom Beaver Builder modules. Requires Beaver Builder Premium.
 * Version:           0.4.0
 * Author:            Ryan Benhase
 * Author URI:        http://ryanbenhase.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       beaver-brewer
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! defined( 'PLUGIN_MAIN' ) ) {
	define( "PLUGIN_MAIN", __FILE__ );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-beaver-brewer-activator.php
 */
function activate_beaver_brewer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-beaver-brewer-activator.php';
	Beaver_Brewer_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-beaver-brewer-deactivator.php
 */
function deactivate_beaver_brewer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-beaver-brewer-deactivator.php';
	Beaver_Brewer_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_beaver_brewer' );
register_deactivation_hook( __FILE__, 'deactivate_beaver_brewer' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-beaver-brewer.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.1.0
 */
function run_beaver_brewer() {

	$plugin = new Beaver_Brewer( plugin_basename( __FILE__ ) );
	$plugin->run();

}
run_beaver_brewer();
