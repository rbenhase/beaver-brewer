<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://beaverbrewer.com
 * @since      0.1.0
 *
 * @package    Beaver_Brewer
 * @subpackage Beaver_Brewer/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Beaver_Brewer
 * @subpackage Beaver_Brewer/admin
 * @author     Ryan Benhase <ryan@beaverbrewer.com>
 */
class Beaver_Brewer_Admin {

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
	 * Add the Beaver Brewer menu item.
	 *
	 * @since    0.1.0
	 */
	public function add_menu_page() {
  	
  	// Count updates (retrieve cached value in DB if available)
  	$update_count = get_transient( "beaver-brewer-updates" );
  	if ( $update_count === false )
  	  $update_count = $this->count_updates();
  	
  	$update_title = $update_count . __( "Updates" );
  	
  	// If there are module updates waiting
  	if ( $update_count > 0 ) {
    	$menu_label = sprintf( 
    	  __( "Beaver Brewer %s" ), 
        "<span class='update-plugins count-$update_count' title='$update_title'><span class='update-count'>" . number_format_i18n($update_count) . "</span></span>" 
      );
      
    } else {
      $menu_label = __( "Beaver Brewer" );
    }

    add_menu_page( 
        __( 'Beaver Brewer', $this->plugin_name ),
        $menu_label,
        'manage_options',
        'beaver-brewer',
        array( $this, 'render_admin' ),
        'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48c3ZnIHZlcnNpb249IjEuMSIgaWQ9InN2ZzIiIGlua3NjYXBlOnZlcnNpb249IjAuNDguMiByOTgxOSIgc29kaXBvZGk6ZG9jbmFtZT0iYm90dGxlX2xvbmduZWNrLnN2ZyIgeG1sbnM6Y2M9Imh0dHA6Ly9jcmVhdGl2ZWNvbW1vbnMub3JnL25zIyIgeG1sbnM6ZGM9Imh0dHA6Ly9wdXJsLm9yZy9kYy9lbGVtZW50cy8xLjEvIiB4bWxuczppbmtzY2FwZT0iaHR0cDovL3d3dy5pbmtzY2FwZS5vcmcvbmFtZXNwYWNlcy9pbmtzY2FwZSIgeG1sbnM6bnMxPSJodHRwOi8vc296aS5iYWllcm91Z2UuZnIiIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyIgeG1sbnM6c29kaXBvZGk9Imh0dHA6Ly9zb2RpcG9kaS5zb3VyY2Vmb3JnZS5uZXQvRFREL3NvZGlwb2RpLTAuZHRkIiB4bWxuczpzdmc9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDc0NC4xIDEwNTIuNCIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNzQ0LjEgMTA1Mi40OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+PHNvZGlwb2RpOm5hbWVkdmlldyAgYm9yZGVyY29sb3I9IiM2NjY2NjYiIGJvcmRlcm9wYWNpdHk9IjEuMCIgaWQ9ImJhc2UiIGlua3NjYXBlOmN1cnJlbnQtbGF5ZXI9ImxheWVyMSIgaW5rc2NhcGU6Y3g9IjE0Ni4wMTMyMyIgaW5rc2NhcGU6Y3k9IjU1NC43NTY4OCIgaW5rc2NhcGU6ZG9jdW1lbnQtdW5pdHM9InB4IiBpbmtzY2FwZTpwYWdlb3BhY2l0eT0iMC4wIiBpbmtzY2FwZTpwYWdlc2hhZG93PSIyIiBpbmtzY2FwZTp3aW5kb3ctaGVpZ2h0PSIxMDI2IiBpbmtzY2FwZTp3aW5kb3ctbWF4aW1pemVkPSIxIiBpbmtzY2FwZTp3aW5kb3ctd2lkdGg9IjE2ODAiIGlua3NjYXBlOndpbmRvdy14PSIwIiBpbmtzY2FwZTp3aW5kb3cteT0iMjQiIGlua3NjYXBlOnpvb209IjAuNDk0OTc0NzUiIHBhZ2Vjb2xvcj0iI2ZmZmZmZiIgc2hvd2dyaWQ9ImZhbHNlIj48L3NvZGlwb2RpOm5hbWVkdmlldz48Zz48cGF0aCBkPSJNMjU3LDU1My43bC05LjQtOC4ybC0xNy4xLDE5LjZsOS40LDguMmM5LjUsOC4zLDE3LjEsOS4xLDIyLjgsMi42QzI2OC40LDU2OS40LDI2Ni41LDU2MiwyNTcsNTUzLjd6Ii8+PHBhdGggZD0iTTM2MS41LDYxOC44YzMuNCwwLjgsNi43LTAuNiw5LjktNC4zYzMuMi0zLjcsNC4xLTcuMiwyLjctMTAuNWMtMS40LTMuMy00LjYtNy4yLTkuOC0xMS43bC00LjktNC4ybC0xNiwxOC40bDUsNC4zQzM1My44LDYxNS4zLDM1OC4xLDYxOCwzNjEuNSw2MTguOHoiLz48cGF0aCBkPSJNMzQxLjgsNjI3LjRsLTkuNC04LjJsLTE3LjEsMTkuNmw5LjQsOC4yYzkuNSw4LjMsMTcuMSw5LjEsMjIuOCwyLjZDMzUzLjIsNjQzLjEsMzUxLjMsNjM1LjcsMzQxLjgsNjI3LjR6Ii8+PHBhdGggZD0iTTQ1OC41LDU3MS4xYzMxLjktMzkuMSwxNy05MC40LDM2LjctMTE1LjRMNjIxLDI4Ny41YzE5LjEsNS45LDI2LjUtMjQsMzAuMS0zMi45YzE4LjgtNSwxMC44LTEzLjksMTAuNS0xNy41Yy0yMi44LTIzLjgtMzQuNy0zMy41LTYzLjgtNTQuOGMwLDAtMTcuNy0wLjYtMTIuNywxNC40Yy0xLjMsNi4yLTQwLjgsMTEuMi0yOS4zLDM0LjVsLTE1MSwxNDljLTI3LDIzLjktNjgsMTQtMTAxLjEsNDYuNkwzMC44LDc0NS4xYzAsMC0xMi45LDE0LjgtMTIuOSwyMi43bDAsMGMxLjUsMzQsMTIzLjcsMTM1LjUsMTQzLjcsMTI2LjhjMTQuNiwwLjcsMzIuOS0yNC4zLDMyLjktMjQuM0w0NTguNSw1NzEuMXogTTI2NC42LDYwN2MtNy45LDAtMTYtMy41LTI0LjEtMTAuNUwxOTYuMiw1NThsNjYuNi03Ni42bDM3LDMyLjJjNC44LDQuMiw4LjYsOC4zLDExLjMsMTIuM2MyLjgsNCw0LjUsNy44LDUuMywxMS4zYzAuOCwzLjUsMC44LDYuOC0wLjEsOS45Yy0wLjgsMy4xLTIuNCw1LjktNC42LDguNWMtMi40LDIuOC01LjIsNC45LTguNCw2LjNjLTMuMiwxLjQtNi4yLDIuMi05LjIsMi4zYy0zLDAuMS01LjYtMC4zLTcuOC0xLjFjMy40LDYuNiw1LjIsMTIuNyw1LjIsMTguMmMwLDUuNS0yLjIsMTAuOC02LjUsMTUuOEMyNzkuNCw2MDMuNywyNzIuNSw2MDcsMjY0LjYsNjA3eiBNMzQ5LjQsNjgwLjdjLTcuOSwwLTE2LTMuNS0yNC4xLTEwLjVMMjgxLDYzMS43bDY2LjYtNzYuNmwzNywzMi4yYzQuOCw0LjIsOC42LDguMywxMS4zLDEyLjNjMi44LDQsNC41LDcuOCw1LjMsMTEuM2MwLjgsMy41LDAuOCw2LjgtMC4xLDkuOWMtMC44LDMuMS0yLjQsNS45LTQuNiw4LjVjLTIuNCwyLjgtNS4yLDQuOS04LjQsNi4zYy0zLjIsMS40LTYuMiwyLjItOS4yLDIuM2MtMywwLjEtNS42LTAuMy03LjgtMS4xYzMuNCw2LjYsNS4yLDEyLjcsNS4yLDE4LjJjMCw1LjUtMi4yLDEwLjgtNi41LDE1LjhDMzY0LjEsNjc3LjQsMzU3LjMsNjgwLjcsMzQ5LjQsNjgwLjd6Ii8+PHBhdGggZD0iTTI3Ni44LDU0NS4xYzMuNCwwLjgsNi43LTAuNiw5LjktNC4zYzMuMi0zLjcsNC4xLTcuMiwyLjctMTAuNWMtMS40LTMuMy00LjYtNy4yLTkuOC0xMS43bC00LjktNC4ybC0xNiwxOC40bDUsNC4zQzI2OSw1NDEuNiwyNzMuNCw1NDQuMywyNzYuOCw1NDUuMXoiLz48L2c+PC9zdmc+',
        60
    ); 

	}	

	/**
	 * Render the Beaver Brewer admin page.
	 *
	 * @since    0.1.0
	 */
	public function render_admin() {
  	
    // See if we are supposed to activate any modules and update their status accordinly.
    if ( !empty( $_GET['activate'] ) && wp_verify_nonce( $_GET['activate_module_nonce'], 'activate_module' ) ) {
      $result = $this->activate_module( $_GET['activate'] );    
      if ( $result ) {
        foreach ( $this->modules as $k => $module ) {          
          if ( $module['name'] == $_GET['activate'] )  {
            $this->modules[$k]['active'] = true;    
            $this->print_message( 
              __( "Module Activated", $this->plugin_name ),
              sprintf( __( "Successfully activated the %s module.", $this->plugin_name ), ( !empty( $this->modules[$k]['nicename'] ) ? $this->modules[$k]['nicename'] : $this->modules[$k]['name'] ) )
            );
          }      
        }
      }
    }

    $update_count = 0;
      
    include_once( 'partials/beaver-brewer-admin-display.php' );
    
    // If updates are available, update the cached value
    if ( $update_count > 0 ) 
      set_transient( "beaver-brewer-updates", $update_count, 12 * HOUR_IN_SECONDS );
	}

	
	/**
	 * Render the admin page tab navigation.
	 *
	 * @since    0.3.0
	 * @return   Int  $current  The current active tab
	 */
  public function get_admin_page_tabs() {
    $tabs = array(
      "my-modules" => __( "My Modules", $this->plugin_name ),
      "find-more" => __( "Find More Modules", $this->plugin_name )
    );
    
    $current = ( isset( $_REQUEST['tab'] ) ? $_REQUEST['tab'] : 'my-modules' );
    
    echo '<h2 class="nav-tab-wrapper">';
    foreach( $tabs as $tab => $name ){
        $class = ( $tab == $current ) ? ' nav-tab-active' : '';
        echo "<a class='nav-tab$class' href='?page=beaver-brewer&tab=$tab'>$name</a>";
    }
    echo '</h2>';
    return $current;
  }		
  
  
	/**
	 * Render the module results on the "Find Modules" page.
	 *
	 * @since    0.3.0
	 */
  public function prepare_module_results() {
    
    $result_page = ( isset( $_REQUEST['result_page'] ) ? $_REQUEST['result_page'] : 1 );
    
    echo '<h3>';
    if ( isset( $_REQUEST['search'] ) ) {
      $response = wp_remote_get( 'http://beaverbrewer.com/wp-json/brewer/v2/modules-search/' . urlencode( $_REQUEST['search'] ) . '/' . $result_page );    
      _e( "Search Results: ", $this->plugin_name );
      echo $_REQUEST['search']; 
    } else if ( isset( $_REQUEST['orderby'] ) && $_REQUEST['orderby'] == 'name' ) {
      $response = wp_remote_get( 'http://beaverbrewer.com/wp-json/brewer/v2/modules-alphabetical/' . ( !empty( $_REQUEST['filter'] ) ? urlencode( $_REQUEST['filter'] ) : 'none' ) . '/' . $result_page ); 
      _e( "Modules - Alphabetical", $this->plugin_name );
    } else if ( isset( $_REQUEST['orderby'] ) && $_REQUEST['orderby'] == 'date_asc' ) {
      $response = wp_remote_get( 'http://beaverbrewer.com/wp-json/brewer/v2/modules-oldest/' . ( !empty( $_REQUEST['filter'] ) ? urlencode( $_REQUEST['filter'] ) : 'none' ) . '/' . $result_page );
      _e( "Oldest Added Modules", $this->plugin_name );
    } else {
      $response = wp_remote_get( 'http://beaverbrewer.com/wp-json/brewer/v2/modules-latest/' . ( !empty( $_REQUEST['filter'] ) ? urlencode( $_REQUEST['filter'] ) : 'none' ) . '/' . $result_page );
      _e( "Recently Added Modules", $this->plugin_name );
    }
    echo '</h3>';
    
    $this->render_module_results( $response ); 
      
  }
  
	/**
	 * Render the module results on the "Find Modules" page.
	 *
	 * @since   0.3.0
	 * @param   Object  $response  The response from the BB Module API.
	 */
  public function render_module_results( $response ) {
  ?>
    <div id="module-results">
      <ul class="clearfix">
        
      <?php $result = json_decode( $response['body'] ); ?>

      <?php $modules = ( empty( $result->posts ) ? 0 : $result->posts ); ?>

      <?php if ( !empty( $modules ) && is_object( $modules ) ): ?>
        <li><?_e( "An error occurred while connecting to the directory. Try again in a minute, and if you continue to experience problems, make sure the Beaver Brewer plugin is up-to-date.", $this->plugin_name ); ?></li>
      <?php elseif ( !empty( $modules ) && isset( $modules[0]->ID ) ): ?>
        
        <?php $found = $result->found; ?>
        <?php $offset = $result->offset; ?>
        <?php $count_modules = count( $modules ); ?>
        <?php $result_page = ( isset( $_REQUEST['result_page'] ) ? $_REQUEST['result_page'] : 1 ); ?>
        
        <?php foreach ( $modules as $module ): ?>
        
          <?php $paid = !empty( $module->meta->{"module-purchase"}[0] ); ?>
        
          <li class="single-module <?php echo ( $paid ? 'paid-module' : 'free-module' ); ?>">          
            <h3 class="module-title"><?php echo $module->post_title; ?><?php echo ( $paid ? ' <span class="paid">[Paid]</span>' : '' ); ?></h3>
            <?php if ( !empty(  $module->meta->{"module-description"}[0] ) ): ?>
              <p><?php echo ( strlen( $module->meta->{"module-description"}[0] )> 140  ? mb_substr( $module->meta->{"module-description"}[0], 0, 140 ) . '...' : $module->meta->{"module-description"}[0] ); ?></p>
            <?php endif; ?>
            <ul class="module-details">

              <?php if ( !empty( $module->meta->{"module-version"}[0] ) ): ?>
    					  <li><strong> <?php _e( "Version", $this->plugin_name ); ?>: </strong> <?php echo $module->meta->{"module-version"}[0]; ?></li>
    					<?php endif; ?>
    					
    					<?php if ( !empty(  $module->meta->{"module-author"}[0] ) ): ?>
    					  <li><strong><?php _e( "Author", $this->plugin_name ); ?>: </strong> 
    					  
  					    <?php if ( !empty(  $module->meta->{"module-author-url"}[0] ) ): ?>
                <a href="<?php echo  $module->meta->{"module-author-url"}[0]; ?>" target="_blank">
                <?php endif; ?>
                
                <?php echo $module->meta->{"module-author"}[0] ?>
                
                <?php if ( !empty( $module->meta->{"module-author"}[0] ) ): ?>
                </a>
                <?php endif; ?></li>
                
                <?php if ( !empty( $module->meta->{"module-more-info"}[0] ) ): ?>
    					  <li><a href="<?php echo $module->meta->{"module-more-info"}[0]; ?>" target="_blank">&rtri; <?php _e( "More Information", $this->plugin_name ); ?></a></li>
                <?php endif; ?>
                
                <?php if ( !$paid && !empty( $module->meta->{"module-download"}[0] ) && !Beaver_Brewer::module_exists( $module->slug ) ): ?>
                <li class="install-now">
                  <a href="<?php echo admin_url( 'admin.php?page=beaver-brewer&tab=install&module=' . urlencode( $module->slug ) . '&source=' . urlencode( $module->meta->{"module-download"}[0] ) ); ?>" class="button-primary install-now">
                    <?php _e( "Install This Module Now", $this->plugin_name ); ?>
                  </a>
                </li>        
                <?php elseif ( $paid && !Beaver_Brewer::module_exists( $module->slug ) ): ?>
                  <li class="install-now">
                    <a href="<?php echo esc_url( $module->meta->{"module-purchase"}[0] ); ?>" target="_blank" class="button-secondary install-now">
                      <?php _e( "Purchase This Module Now", $this->plugin_name ); ?>
                    </a>
                  </li>  
                <?php elseif ( Beaver_Brewer::module_exists( $module->slug ) ): ?>
                <li class="install-now">
                  <em class="install-now">
                    <?php _e( "This module is already installed on your site.", $this->plugin_name ); ?>
                  </em>
                </li>  
                <?php endif; ?>
                  
              <?php endif; ?>
                              
            </ul>
          </li>
        <?php endforeach; ?>
        </ul>
        
        <div class="pagination">
          
          <?php $offset_string = ( $offset + 1 ) . '-' . ( ( $offset + 20 ) < $found ?  ( $offset + 20 ) : $found ); ?>
          <?php echo sprintf( __( "Showing Results %s of %d" , $this->plugin_name ), $offset_string, $found ); ?>

          <ul class="pagination-links">
            <?php 
             
            $last = ceil( $found / 20 );
         
            $start = ( ( $result_page - $count_modules ) > 0 ) ? $result_page - $count_modules : 1;
            $end = ( ( $result_page + $count_modules ) < $last ) ? $result_page + $count_modules : $last;
                     
            if ( $result_page > 1 ) {
              echo '<li>';
              echo '<a href="' . add_query_arg( 'result_page', $result_page - 1 ) . '">&laquo;</a>';
              echo '</li>';
            }
         
            if ( $start > 1 ) {
              echo '<li><a href="' . add_query_arg( 'result_page', 1 ) . '">1</a></li>';
              echo '<li class="disabled"><span>...</span></li>';
            }
         
            for ( $i = $start ; $i <= $end; $i++ ) {
                echo'<li class="' . ( $result_page == $i ? 'active' : '' ) . '">';
                echo '<a href="' . add_query_arg( 'result_page', $i ) . '">' . $i . '</a>';
                echo '</li>';
            }
         
            if ( $end < $last ) {
                echo '<li class="disabled"><span>...</span></li>';
                echo '<li><a href="' . add_query_arg( 'result_page', $last ) . '">' . $last . '</a></li>';
            }
         
            if ( $result_page != $last ) { 
              echo '<li>';
              echo '<a href="' . add_query_arg( 'result_page', $result_page + 1 ) . '">&raquo;</a>';
              echo '</li>';
            }         
            ?>
          </ul>          
        </div>
        
      <?php else: ?>
        <li><?php _e( "No modules found. If you think this is in error, make sure the Beaver Brewer plugin is up-to-date.", $this->plugin_name ); ?></li>
      <?php endif; ?>
      </ul>                 
    </div>
  <?php
  }
  	
	/**
	 * Get latest version of a module.
	 *
	 * @since    0.1.0
	 * @param    String   $update_url   The URL against which to check for updates
	 */
	private function get_latest( $update_url ) {

    // Append Unique ID as query argument to prevent cache issues
    $update_url = add_query_arg( 'beaverbrewer', uniqid(), $update_url );
  
    $data = get_file_data( 
      $update_url, 
      array( 
        "ModuleVersion" => "Module Version"
      ) 
    );
    
    if ( !empty( $data['ModuleVersion'] ) )
      return $data['ModuleVersion'];
      
    return false;
	}
	
  /**
	 * Check for updates to each module and return a total number of updates available.
	 *
	 * @since    0.1.0
	 * @return   Int   $count The number of available module updates
	 */
	private function count_updates() {
  	
  	$count = 0;
  	
  	// Loop through modules and check each for updates
  	foreach( $this->modules as $module ) {
    	if ( $this->check_updates( $module ) === true ) {
      	$count++;
    	}
  	}
  	
  	// Cache update count for 12 hours.
  	set_transient( "beaver-brewer-updates", $count, 12 * HOUR_IN_SECONDS );
  	
  	return $count;
	}
	
  /**
	 * Check for updates to a module.
	 *
	 * @since    0.1.0
	 * @param    Array   $module   The module configuration settings to use
	 */
	private function check_updates( $module ) {

    if ( empty( $module['version'] ) )
      return -1;
      
    if ( empty( $module['updates'] ) ) {
      error_log(
        __( "Beaver Brewer Error: Some of the data in your module.config file appears to be missing or invalid. Automatic updates will not work." ) 
        . ( !empty( $module['name'] ) ? __( " Check module: " ) . $module['name'] : '' ) 
      );
      return -1;
    }
      
    $latest = $this->get_latest( $module['updates'] );
      
    return version_compare( $module['version'], $latest, '<' );    	
  } 
  
  
  /**
	 * Echo a failure notice as a JSON-encoded string (e.g., as a response to an AJAX call).
	 *
	 * @since    0.1.0
	 * @param    String   $message   The (untranslated) message to use
	 */
  private function trigger_ajax_failure( $message ) {
    echo json_encode(
      array(
        "success" => 0,
        "message" => __( $message, $this->plugin_name )
      )
    );
    exit;
  }  
  
  /**
   * Delete a Directory.
   *
   * @access public
   * @param String $dir The directory to delete
   * @return Boolean False on failure, true on success
   */
  private function delete_directory( $dir ) {
    
    if (! is_dir( $dir ) ) {
      return false;
    }    
    if ( substr( $dir, strlen( $dir ) - 1, 1 ) != '/' ) {
        $dir .= '/';
    }    
    $files = glob( $dir . '*', GLOB_MARK );
    foreach ( $files as $file ) {
      if ( is_dir($file ) ) {
        $this->delete_directory( $file );
      } else {
        $result = @unlink( $file );
        if ( $result === false )
          return false;
      }
    }    
    return @rmdir( $dir );    
  }
    
  
  /**
	 * Update a module via Ajax.
	 *
	 * Echoes a JSON-encoded response.
	 *
	 * @since    0.1.0
	 */
	public function auto_update_ajax() {
  	
  	// Verify AJAX request
  	check_ajax_referer( 'beaver-brewer-admin', '_ajax_nonce' );
  	
    header( "Content-Type:application/json" );
    
    // Make sure all data we need are present
    if ( !isset( $_POST['module'] ) ) {
      $this->trigger_ajax_failure( "No module path specified." );
    }
    if ( !isset( $_POST['update'] ) ) {
      $this->trigger_ajax_failure( "No remote module config specified." );
    }    
    if ( !is_dir( MY_MODULES_DIR . $_POST['module'] ) ) {
      $this->trigger_ajax_failure( "Could not find module directory." );
    }

    //Prepare temporary file for writing
    $tmp = tempnam( sys_get_temp_dir(), 'beaver-brewer-' );
    $handle = fopen( $tmp, "w" );
    
    if ( !$handle ) {
      $this->trigger_ajax_failure( "Could not open temporary file for writing." );
    }
    
    $data = get_file_data( 
      $_POST['update'], 
      array( 
        "DownloadZIP" => "Download ZIP"
      ) 
    );
    
    if ( empty( $data["DownloadZIP"] ) ) 
      $this->trigger_ajax_failure( "Update Failed: Could not read from remote module config." );
    
    $download_url = $data["DownloadZIP"];
    
    //Download update via cURL
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_URL, $download_url );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, false );
    curl_setopt( $ch, CURLOPT_BINARYTRANSFER, true );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
    curl_setopt( $ch, CURLOPT_POSTREDIR, 3);
    curl_setopt( $ch, CURLOPT_MAXREDIRS, 25 );
    curl_setopt( $ch, CURLOPT_TIMEOUT, 60 );
    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 10 );
    curl_setopt( $ch, CURLOPT_FILE, $handle );    

    $result = curl_exec( $ch );
    
    curl_close( $ch );

    // Handle download failed errors
    if ( !$result ) {
      
      $response_code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
      $this->trigger_ajax_failure( "Update Failed: Could not download update." . ( !empty( $response_code ) ? " HTTP Response Code $response_code." : '' ) );
      
    }     
    
    // Close temp file
    fclose( $handle );     
    
    // Prepare ZIP archive
    $zip = new ZipArchive;
        
    if ( $zip->open( $tmp, ZIPARCHIVE::CREATE ) != "true" ) {
      $this->trigger_ajax_failure( "Update Failed: Could not open ZIP. Error Code " . $zip->open( $tmp, ZIPARCHIVE::CREATE ) );
    }

    // Delete any old backups to make way for our new one    
    if ( is_dir( MY_MODULES_DIR . '.backup/' . $_POST['module'] ) ){
      $rm = $this->delete_directory( MY_MODULES_DIR . '.backup/' . $_POST['module'] );
      if ( !$rm )
        $this->trigger_ajax_failure( "Update Failed: Could not delete old backup of module. Check your file permissions." );
    }
    
    // Ensure we have a backup of the existing module before proceeding
    if( !is_dir( MY_MODULES_DIR . '.backup' ) && mkdir( MY_MODULES_DIR . '.backup', 0775 ) === false || 
        !rename( MY_MODULES_DIR . $_POST['module'], MY_MODULES_DIR . '.backup/' . $_POST['module'] ) ) {
          
      $zip->close();   
      $this->trigger_ajax_failure( "Update Failed: Could not create temporary backup of existing module. Check your file permissions." );
    } 
    // Create blank index.php file to prevent inadvertantly listing directory contents
    @file_put_contents( MY_MODULES_DIR . '.backup/index.php', "<?php \n//Silence is golden", LOCK_EX );
        
    // Set temporary error handler
		set_error_handler( function($errno, $errstr, $errfile, $errline ) {
  		
  		// error was suppressed with the @-operator
      if ( 0 === error_reporting() ) {
          return false;
      }  
      throw new ErrorException( $errstr, 0, $errno, $errfile, $errline );
    });
    
    try {
      $extracted = $zip->extractTo( rtrim( MY_MODULES_DIR, '/' ) );
    } catch ( ErrorException $e ) {
      $extracted = false;
    }
    
    // Restore default error handler
    restore_error_handler();
    
    // If extraction failed
    if ( $extracted == false ) {
      $zip->close();   
      $this->trigger_ajax_failure( "Update Failed: Could not extract ZIP contents of update. Check your file permissions." );
    }    
    
    // Attempt to get module directory name from extracted ZIP
    $dir = trim( $zip->getNameIndex(0), '/' );        
    if ( $dir === false ) {
      $this->trigger_ajax_failure( "Update Failed:  Could not find module folder within extracted files." );
    }
    
    // If directory inside ZIP does not match module name (e.g. Bitbucket ZIP files), rename accordingly.
    if ( !is_dir( MY_MODULES_DIR . $_POST['module'] ) ){
      $r = rename( MY_MODULES_DIR . $dir, MY_MODULES_DIR . $_POST['module'] );
      if ( !$r )
        $this->trigger_ajax_failure( "Update Error: Could not rename module directory. Check your bb-modules folder. " . MY_MODULES_DIR . $dir . ' != ' . MY_MODULES_DIR . $_POST['module']);
    }
        
    // Update was successful; remove transient to force count to be updated
    delete_transient( "beaver-brewer-updates" );
    
    // Attempt to remove old module
    if ( !$this->delete_directory( MY_MODULES_DIR . '.backup/' . $_POST['module'] ) ) {
      echo json_encode(
        array(
          "success" => 1,
          "message" => __("Updated successfully, but could not completely remove the old module. It has been moved to the hidden wp-content/bb-modules/.backup folder instead, where you can manually delete it if desired.", $this->plugin_name )
        )
      );
      $zip->close();     
        
    } else {    
      // Everything worked perfectly!
      
      echo json_encode(
        array(
          "success" => 1,
          "message" => __("Updated successfully.", $this->plugin_name )
        )
      );      
      $zip->close();             
    }
    exit;
  }
  
  

  /**
   * Activate a module.
   * 
	 * @since    0.1.0
   * @param String $module The module to activate
   * @return Boolean True on success, False on failure.
   */
  public function activate_module( $module ) {
        
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

    // Now Load New Module
    $path = MY_MODULES_DIR . $module;
    $files = glob( $path . '/*.php' );
    
    if ( !empty( $files ) ) foreach ( $files as $file_path ){
      require_once( $file_path );
    } else {
      return false;
    }    
    
    // If module is not already listed as active, activate it in DB
    if ( !in_array( $module, $active_modules ) )
      array_push( $active_modules, $module );
        
    // Update DB
    update_option( "bb-modules-active", $active_modules );
    return true;  
  }
  
  
  /**
   * Dectivate a module.
   * 
	 * @since    0.1.0
   * @param String $module The module to deactivate
   * @return Boolean True on success, False if module is not found in active list
   */
  public function deactivate_module( $module ) {
        
    // Get active modules, search for specified module, and unset.
    $active_modules = Beaver_Brewer::get_modules_active();    
    $key = array_search( $module, $active_modules, true );
    
    if ( $key !== false ) {
      unset( $active_modules[$key] );
      update_option( "bb-modules-active", $active_modules );
      return true;
    }
    return false;
  }
        
    
  
  /**
   * Delete a module.
   * 
	 * @since    0.1.0
   * @param String $module The module to delete
   */
  public function delete_module( $module ) {
        
    // First deactivate module
    $this->deactivate_module( $module );
        
    // Attempt to delete folder
    return $this->delete_directory( MY_MODULES_DIR . $module );       
  }
  
  
 /**
	 * Deactivate a module via Ajax.
	 *
	 * Echoes a JSON-encoded response.
	 *
	 * @since    0.1.0
	 */
	public function activate_ajax() {
  	
  	check_ajax_referer( 'beaver-brewer-admin', '_ajax_nonce' );
  	
    header( "Content-Type:application/json" );
    
    /*
     * Make sure all data we need are present
     */
    if ( !isset( $_POST['module'] ) ) {
      echo json_encode(
        array(
          "success" => 0,
          "message" => __( "No module specified.", $this->plugin_name )
        )
      );
      exit;
    }

    $module = $_POST['module'];
    
    ob_start();
    
    $success = $this->activate_module( $module );
    
    if ( $success && ob_get_length() > 0 ) {
      
      echo json_encode(
          array(
            "success" => 1,
            "message" => __( "The module was activated, but it generated some unexpected output. If you experience any \"headers already sent\" errors, try deactivating the module.", $this->plugin_name )
          )
        );
      exit;  
    } elseif ( !$success ) {
      $this->trigger_ajax_failure( "This module could not be activated because it does not appear to contain any valid PHP files." );
    }  
    ob_end_clean();         
      
    
    // Check to see that activation succeeded
    if ( !Beaver_Brewer::is_module_active( $module ) ) {
      $this->trigger_ajax_failure( "The module failed to activate for an unknown reason." );
    } else {
        echo json_encode(
        array(
          "success" => 1,
          "message" => __( "The module is now active.", $this->plugin_name )
        )
      );
    }
    
    exit;
  
  }
  
  
 /**
	 * Deactivate a module via Ajax.
	 *
	 * Echoes a JSON-encoded response.
	 *
	 * @since    0.1.0
	 */
	public function deactivate_ajax() {
  	
  	check_ajax_referer( 'beaver-brewer-admin', '_ajax_nonce' );
  	
    header( "Content-Type:application/json" );
    
    /*
     * Make sure all data we need are present
     */
    if ( !isset( $_POST['module'] ) ) {
      $this->trigger_ajax_failure(  "No module specified." );
    }

    $module = $_POST['module'];
    $this->deactivate_module( $module );
        
    // Check to see that deactivation succeeded
    if ( Beaver_Brewer::is_module_active( $module ) ) {
      $this->trigger_ajax_failure( "The module failed to deactivate for an unknown (and, quite frankly, upsetting) reason." );
    } else {
        echo json_encode(
        array(
          "success" => 1,
          "message" => __( "The module is no longer active.", $this->plugin_name )
        )
      );
    }
    
    exit;  
  }
	
	
 /**
	 * Deletes a module via Ajax.
	 *
	 * Echoes a JSON-encoded response.
	 *
	 * @since    0.1.0
	 */
	public function delete_ajax() {
  	
  	check_ajax_referer( 'beaver-brewer-admin', '_ajax_nonce' );
  	
    header( "Content-Type:application/json" );
    
    /*
     * Make sure all data we need are present
     */
    if ( !isset( $_POST['module'] ) ) {
      $this->trigger_ajax_failure( "No module specified." );
    }

    $module = $_POST['module'];
    $result = $this->delete_module( $module );
        
    // Check to see that deletion succeeded
    if ( $result !== true ) {
      $this->trigger_ajax_failure( "Failed to delete the module (this is probably a permissions issue). You will need to delete it manually." );
    } else {
        echo json_encode(
        array(
          "success" => 1,
          "message" => __( "The module has been deleted.", $this->plugin_name )
        )
      );
    }
    
    exit;  
  }
	
	/**
	 * Get a list of all installed modules
	 *
	 * Note that this does not translate strings (so that you can pass HTML in your message if desired).
	 * You will therefore need to translate your title/message BEFORE passing it to this function.
	 *
	 * @since   0.1.0
	 * @param   String  $title    The title of the message, if any (appears before message, inside <strong> tags)
	 * @param   String  $message  The message itself
	 * @param   String  $type     The type of message ('error' or 'updated') which will become the container div class.
	 */
	public function print_message( $title = '', $message  = '', $type = 'updated' ) {
  	
    echo "<div class='$type'>";
    echo '<p>';    
    echo "<strong>$title:</strong> $message";        
  	echo '</p>';
  	echo '</div>';

	}
	
	
	/**
	 * Checks if the bb-modules directory has been created. If not, attempts to create it.
	 *
	 * @since    0.1.0
	 * @return   Boolean  true if the directory exists or is successfully created; otherwise false.
	 */
	public function check_directory() {
  	  	  
    if ( !is_dir( WP_CONTENT_DIR . '/bb-modules' ) ) {
  
      $result = mkdir( WP_CONTENT_DIR . '/bb-modules', 0775 );
  
      if ( $result ){
        
        $this->print_message( 
                  __( "Beaver Brewer Ready", $this->plugin_name ),
                  __( "Automatically created the bb-modules directory inside your Wordpress 'wp-content' directory. You're all set!", $this->plugin_name )
        );
        
        return true;
                  
      } else {
        
        $this->print_message( 
                  __( "Beaver Brewer Warning", $this->plugin_name ),
                  __( "Could not automatically create bb-modules directory. This is probably a permissions issue. In order for Beaver Brewer to work, you will need to manually create a directory called 'bb-modules' inside your Wordpress 'wp-content' directory.", $this->plugin_name ),
                  'error'
        );
        
        return false;      
        
      }      
      
    }
    return true; 
	}
	
	
	/**
	 * Handle uploaded files.
	 *
	 * @since    0.1.0
	 */
	public function upload_ajax() {
  	
  	header("Content-Type: application/json");

    check_ajax_referer( "module-upload" );  

    $file = $_FILES['async-upload'];
    $status = wp_handle_upload( $file, array( 'test_form'=>true, 'action' => 'beaver_brewer_upload' ) );
    
    
    if ( empty( $status['file'] ) ) {
      $this->trigger_ajax_failure( "The file upload failed. Check your error log for more info." );
    } else {
      
      // Prepare ZIP archive
      $zip = new ZipArchive;
      
      if ( $zip->open( $status['file'] ) != "true" ) {
        $this->trigger_ajax_failure( "Failed to read from ZIP. Make sure your archive isn't corrupt." );
      }
      
      // Set temporary error handler
  		set_error_handler( function( $errno, $errstr, $errfile, $errline ) {
    		
    		// error was suppressed with the @-operator
        if ( 0 === error_reporting() ) {
            return false;
        }
    
        throw new ErrorException( $errstr, 0, $errno, $errfile, $errline );
      });
      
      try {
        $extracted = $zip->extractTo( rtrim( MY_MODULES_DIR, '/' ) );
      } catch ( ErrorException $e ) {
        $extracted = false;
      }
      
      // Restore default error handler
      restore_error_handler();
      
      // If extraction failed
      if ( $extracted == false ) {
        $zip->close();   
        $this->trigger_ajax_failure( "Failed to extract ZIP contents of update. Check your file permissions." );
      } 
      
      $zip->close(); 
      echo json_encode(
        array(
          "success" => 1,
          "message" => __( "The module was successfully installed.", $this->plugin_name )
        )
      );
  
      exit;
    }
	}

	
	
	/**
	 * Install module in one click.
	 *
	 * @since   0.4.0
	 * @param   String    $source   An encoded URL from which to retrieve the module package.
	 * @return  Boolean             Whether or not installation succeeded.
	 */
	public function install_module( $source ) {
  	
  	$temp_file = download_url( urldecode( $source ), 300 );
  	
  	if ( is_wp_error( $temp_file ) ) {
    	_e( "Installation Failed: Could not download package. Check your error log for more info.", $this->plugin_name );
    	return false;
    } else {
      
      // Prepare ZIP archive
      $zip = new ZipArchive;
      
      if ( $zip->open( $temp_file ) != "true" ) {
        _e( "Installation Failed: Cannot read from package.", $this->plugin_name );
        return false;
      }
      
      // Set temporary error handler
  		set_error_handler( function( $errno, $errstr, $errfile, $errline ) {
    		
    		// error was suppressed with the @-operator
        if ( 0 === error_reporting() ) {
            return false;
        }
    
        throw new ErrorException( $errstr, 0, $errno, $errfile, $errline );
      });
      
      try {
        $extracted = $zip->extractTo( rtrim( MY_MODULES_DIR, '/' ) );
      } catch ( ErrorException $e ) {
        $extracted = false;
      }
      
      // Restore default error handler
      restore_error_handler();
      
      // If extraction failed
      if ( $extracted == false ) {
        $zip->close();   
        _e( "Installation Failed: Could not extract update. Check your file permissions.", $this->plugin_name );
        return false;
      } 
      
      $zip->close(); 
      _e( "Success! The module has been installed.", $this->plugin_name );
      return true;
    }
	}



	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    0.1.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/beaver-brewer-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    0.1.0
	 */
	public function enqueue_scripts( $hook ) {

    if ( $hook == "toplevel_page_beaver-brewer" ){
      
      wp_register_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/beaver-brewer-admin.js', array( 'jquery', 'plupload-all' ), $this->version, false );
      
      // Get plupload config for file uploads
      $plupload_config = array(
      'runtimes'            => 'html5,silverlight,flash,html4',
      'browse_button'       => 'module-install-button',
      'container'           => 'installed-modules',
      'drop_element'        => 'module-list',
      'file_data_name'      => 'async-upload',            
      'multiple_queues'     => true,
      'max_file_size'       => wp_max_upload_size().'b',
      'url'                 => admin_url('admin-ajax.php'),
      'flash_photos_url'       => includes_url('js/plupload/plupload.flash.swf'),
      'silverlight_xap_url' => includes_url('js/plupload/plupload.silverlight.xap'),
      'filters'             => array(array('title' => __('Allowed Files'), 'extensions' => 'zip')),
      'multipart'           => true,
      'urlstream_upload'    => true,
  
      // Additional post data to send to the ajax hook
      'multipart_params'    => array(
        '_ajax_nonce' => wp_create_nonce( 'module-upload' ),
        'action'      => 'beaver_brewer_upload',            // the ajax action name
      ),
    );
  
    $plupload_init = apply_filters( 'plupload_init', $plupload_config ); 
		
  		// Localize some configuration options / translated strings
  		$bb_config = array(
    		"pluploadConfig" => $plupload_config,
    		"ajaxNonce" => wp_create_nonce( "beaver-brewer-admin" ),
    		"activationFatalError" => __( "The module could not be activated because it triggered a fatal error. Check your error log for more info." ),
    		"moduleDeleteConfirm" => __( "Warning: You are about to delete a module, which will result in all of its files being removed. You cannot undo this action, so it's recommended that you have a backup handy. \n\nAre you sure you want to continue?" ),
    		"moduleUpdateError" => __( "Failed to update module. Check your file permissions and your error log for more info." ),
    		"installedModulesText" => __( "Installed Modules" ),
    		"dropToUploadText" => __( "Install Module: Drop File to Begin Upload" )
  		);
  		
  		wp_localize_script( $this->plugin_name, "BeaverBrewer", $bb_config );
  
      wp_enqueue_script( $this->plugin_name );
    }
	}
}
