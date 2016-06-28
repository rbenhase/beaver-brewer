<?php

/**
 * The public-specific functionality of the plugin.
 *
 * @link       http://beaverbrewer.com
 * @since      0.1.0
 *
 * @package    Beaver_Brewer
 * @subpackage Beaver_Brewer/public
 */

/**
 * The public-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-specific stylesheet and JavaScript.
 *
 * @package    Beaver_Brewer
 * @subpackage Beaver_Brewer/public
 * @author     Ryan Benhase <ryan@beaverbrewer.com>
 */
class Beaver_Brewer_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * All modules and their relevant data.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      array    $modules    All recognized modules.
	 */
	private $modules;


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.1.0
	 * @param      string         $plugin_name  The name of this plugin.
	 * @param      string         $version    The version of this plugin.
	 * @param      Beaver_Brewer  $brewer    An instance of the main Beaver Brewer class.
	 */
	public function __construct( $plugin_name, $version, $modules ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->modules = $modules;
	}
	

	/**
	 * Register modules so they can be used in Beaver Builder.
	 *
	 * @since    0.1.0
	 */
	public function register_modules() {
  	
  	// Ensure required Beaver Builder class exists
    if ( class_exists( 'FLBuilder' ) && isset( $this->modules ) ) {
        
      // First load other modules to check for compatibility issues
      $active_modules = Beaver_Brewer::get_modules_active();    
      
      foreach ( $active_modules as $active_module ) {
        
        // Require all PHP files in main directory      
        $path = MY_MODULES_DIR . $active_module;
        $files = glob( $path . '/*.php' );
        if ( !empty( $files ) ) foreach ( $files as $file_path ){
          require_once( $file_path );
        }
      }        
    }      
  }		
}
