<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://beaverbrewer.com
 * @since      0.1.0
 *
 * @package    Beaver_Brewer
 * @subpackage Beaver_Brewer/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      0.1.0
 * @package    Beaver_Brewer
 * @subpackage Beaver_Brewer/includes
 * @author     Ryan Benhase <ryan@beaverbrewer.com>
 */
class Beaver_Brewer {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    0.1.0
	 * @access   protected
	 * @var      Beaver_Brewer_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    0.1.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;
	
	/**
	 * The basename of the plugin (path to plugin file relative to plugins directory).
	 *
	 * @since    0.1.0
	 * @access   protected
	 * @var      string    $plugin_basenamename    The basename of this plugin.
	 */
	protected $plugin_basename;

	/**
	 * The current version of the plugin.
	 *
	 * @since    0.1.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    0.1.0
	 * @param    $basename The plugin basename
	 */
	public function __construct( $basename ) {

		$this->plugin_name = 'beaver-brewer';
		$this->version = '0.1.0';
		$this->plugin_basename = $basename;

		$this->load_dependencies();
		
		/**
		 * Check for external dependencies.
		 */
		$this->loader = new Beaver_Brewer_Loader();		
    $this->loader->add_action( 'plugins_loaded', $this, 'dependency_check' );    
    
		$this->set_locale();
		$this->updater_init();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		
		define( 'MY_MODULES_DIR', WP_CONTENT_DIR . '/bb-modules/' );
    define( 'MY_MODULES_URL', WP_CONTENT_URL . '/bb-modules/' );	
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Beaver_Brewer_Loader. Orchestrates the hooks of the plugin.
	 * - Beaver_Brewer_i18n. Defines internationalization functionality.
	 * - Beaver_Brewer_Admin. Defines all hooks for the admin area.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function load_dependencies() {
        
		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-beaver-brewer-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-beaver-brewer-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-beaver-brewer-admin.php';

		/**
		 * The class responsible for defining all actions that occur on the public side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-beaver-brewer-public.php';		
				
    /**
		 * The script responsible for updating the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/plugin-update-checker/plugin-update-checker.php';
		
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Beaver_Brewer_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Beaver_Brewer_i18n();
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}
	
	/**
	 * Initialize the plugin updater class
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function updater_init() {

		$className = PucFactory::getLatestClassVersion( 'PucGitHubChecker' );
		$myUpdateChecker = new $className(
			'https://github.com/rbenhase/beaver-brewer/',
			PLUGIN_MAIN,
			'master'
		);

	}

	/**
	 * Register all of the hooks related to the admin area functionality.
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Beaver_Brewer_Admin( $this->get_plugin_name(), $this->get_version(), self::get_modules() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_menu_page' );
		$this->loader->add_action( 'wp_ajax_beaver_brewer_auto_update', $plugin_admin, 'auto_update_ajax' );
		$this->loader->add_action( 'wp_ajax_beaver_brewer_activate', $plugin_admin, 'activate_ajax' );
		$this->loader->add_action( 'wp_ajax_beaver_brewer_deactivate', $plugin_admin, 'deactivate_ajax' );
		$this->loader->add_action( 'wp_ajax_beaver_brewer_delete', $plugin_admin, 'delete_ajax' );
		$this->loader->add_action( 'wp_ajax_beaver_brewer_upload', $plugin_admin, 'upload_ajax' );
	}
	
	/**
	 * Register all of the hooks related to the public/front-facing functionality.
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function define_public_hooks() {

    if( !is_admin() ) {
      $plugin_public = new Beaver_Brewer_Public( $this->get_plugin_name(), $this->get_version(), self::get_modules() );		
      $this->loader->add_action( 'init', $plugin_public, 'register_modules' );
    }		
	}
	

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    0.1.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     0.1.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     0.1.0
	 * @return    Beaver_Brewer_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     0.1.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
	
	
	/**
	 * Get installed modules
	 *
	 * @since   0.1.0
	 * @return  Array   $modules  All installed modules
	 */
	public static function get_modules() {
  	
  	$modules = array();
    	
  	// Get directory listing
    $directory_contents = glob( WP_CONTENT_DIR . '/bb-modules/*' );
    
    // Make sure each subdirectory at least contains a PHP file
    foreach ( $directory_contents as $subdirectory ) {
      
      $module_settings = array();
      $glob = glob( $subdirectory . '/*.php' );
      
      if ( is_dir( $subdirectory ) && basename( $subdirectory ) != '.backup'  && !empty ( $glob ) ) {
        $module_settings['path'] = $subdirectory;
        $module_settings['name'] = basename( $subdirectory );
        
        // Set default nicename if no module.config file exists
        $module_settings['nicename'] = basename( $subdirectory );
        
        // Attempt to get real nicename from config file
        if ( file_exists( $subdirectory . '/module.config' ) ) {
          
          $data = get_file_data( 
                    $subdirectory . '/module.config', 
                    array( 
                      "ModuleName" => "Module Name",
                      "ModuleSlug" => "Module Slug",
                      "ModuleVersion" => "Module Version",  
                      "ShortDescription" => "Short Description",  
                      "AuthorName" => "Author Name",
                      "AuthorURL" => "Author URL",
                      "UpdateURL" => "Update URL",
                      "DownloadZIP" => "Download ZIP",
                      "MoreInfo" => "More Info URL" 
                    ) 
                  );
                  
          if ( !empty( $data['ModuleName'] ) )
            $module_settings['nicename'] = $data['ModuleName'];
            
          if ( !empty( $data['ModuleVersion'] ) )
            $module_settings['version'] = $data['ModuleVersion'];
            
          if ( !empty( $data['ModuleSlug'] ) )
            $module_settings['slug'] = $data['ModuleSlug'];
            
          if ( !empty( $data['ShortDescription'] ) )
            $module_settings['description'] = $data['ShortDescription'];            
            
          if ( !empty( $data['AuthorName'] ) )
            $module_settings['author'] = $data['AuthorName'];            
            
          if ( !empty( $data['AuthorURL'] ) )
            $module_settings['author-url'] = $data['AuthorURL'];         
            
          if ( !empty( $data['UpdateURL'] ) )
            $module_settings['updates'] = $data['UpdateURL'];
            
          if ( !empty( $data['DownloadZIP'] ) )
            $module_settings['download'] = $data['DownloadZIP'];
            
          if ( !empty( $data['MoreInfo'] ) )
            $module_settings['more-url'] = $data['MoreInfo'];             
        }
        
        if ( self::is_module_active( $module_settings['name'] ) ) 
          $module_settings['active'] = true;   

        $modules[] = $module_settings;
      }        
    }
    
    return $modules;
	}
	
	
	/**
	 * Get active modules.
	 *
	 * @since   0.3.0
	 * @param   String    $module_slug  The machine-readable module slug
	 * @return  Boolean                 Whether or not the module is installed
	 */
	public static function module_exists( $module_slug ) {
  	
    $modules = self::get_modules();
  	
  	foreach ( $modules as $module ) {
    	if ( $module['name'] == $module_slug )
    	  return true;
  	}  	
  	return false;
	}
	

	
	/**
	 * Get active modules.
	 *
	 * @since   0.1.0
	 * @return  Array   $active_modules  All active modules
	 */
	public static function get_modules_active() {
  	
  	// Get list of modules from DB.
  	$active_modules = get_option( "bb-modules-active" );
  	
  	// If we are not working with an array (e.g. option value is false), fix that.
  	if ( !is_array( $active_modules ) )
  	  $active_modules = array();
  	  
  	return $active_modules;
	}
	

	/**
	 * See if module is active.
	 *
	 * @since   0.1.0
	 * @param String  $module  Module to check
	 * @return Boolean True if active, false if not.
	 */
	public static function is_module_active( $module ) {
  
    $active_modules = self::get_modules_active();
    
    if ( in_array( $module, $active_modules ) )
      return true;
    
    return false;
  }



	
  /**
	 * Check to ensure that all dependencies (e.g. the Beaver Builder plugin) are
	 * active, and disable this plugin if they aren't.
	 *
	 *
	 * @since    0.1.0
	 */
	public function dependency_check() {
  	if ( !class_exists( "FLBuilderModule" ) ) {
    	add_action( 'admin_notices', array( $this, 'deactivation_notice' ) );
      add_action( 'admin_init', array( $this, 'deactivate_plugin' ) );
  	}  	
  }
  
  /**
	 * Deactivate plugin.
	 *
	 *
	 * @since    0.1.0
	 */
	public function deactivate_plugin() {
  	deactivate_plugins( $this->plugin_basename );
  }
  
  /**
	 * Display a notice to the user, stating that the Beaver Builder plugin is not 
	 * active and that this plugin has therefore been disabled (since it's required).
	 *
	 *
	 * @since    0.1.0
	 */
	public function deactivation_notice() {
  	
  	echo '<div class="error">';
  	echo '<p>';
  	
  	echo '<strong>';
  	_e( "Beaver Brewer Deactivated: ");
  	echo '</strong>';
  	
  	_e( "The Beaver Brewer plugin requires Beaver Builder Premium in order to work. Since Beaver Builder was not found, Beaver Brewer has been deactivated.", $this->plugin_name );
  	
  	echo '</p>';
  	echo '</div>';
  }

}
