<?php

/**
 * The "My Modules" tab of the Beaver Brewer admin page.
 *
 * @link       http://beaverbrewer.com
 * @since      0.3.0
 *
 * @package    Beaver_Brewer
 * @subpackage Beaver_Brewer/admin/partials
 */
?>
<div id="installed-modules">
    
  <h2><?php _e( "Installed Modules", $this->plugin_name ); ?></h2> 
  <a href="#" id="module-install-button" class="page-title-action"><?php _e( "Upload Module ZIP", $this->plugin_name ); ?></a>
  <div id="module-list">        
    <div class="drag-drop-inside">

    <?php if ( !empty( $this->modules ) ): ?>
    
      <?php foreach ( $this->modules as $module ): ?>
        
        <?php $update_available = $this->check_updates( $module ); ?>
        
        <div class="single-module 
          <?php echo ( $update_available === true ? 'update-available' : '' ); ?> 
          <?php echo ( isset( $module['active'] ) && $module['active'] === true ? 'module-active' : '' ); ?>
        ">
          
          <div class="module-name">
            <?php echo $module['nicename']; ?>
            <?php echo ( isset( $module['active'] ) && $module['active'] === true ? __( "(Active)" ) : __( "(Inactive)" ) ); ?>
          </div>
          
          <div class="module-version">
            Version <span class="version-number"><?php echo ( isset( $module['version'] ) ? $module['version'] : 'Unknown' ); ?></span>.             
          </div>
          
          <div class="module-description">
            <?php echo ( isset( $module['description'] ) ? '<p>' . $module['description'] . '</p>' : '' ); ?>
          </div>
          
          <div class="module-url">
            <?php echo ( isset( $module['more-url'] ) ? '<a href="' . $module['more-url'] . '" target="_blank">&rarr; More Information</a>' : '' ); ?>
          </div>
          
          <?php $latest = ( isset( $module['updates'] ) ? $this->get_latest( $module['updates'] ) : false ); ?>
          <div class="module-updates">
            
            <?php if ( !$update_available ): ?>
              <?php _e( "Up to date.", $this->plugin_name ); ?>
              
            <?php elseif ( !empty( $module['version'] ) && version_compare( $module['version'], $latest, '<' ) ): ?>
              <?php _e( "Update Available: Version ", $this->plugin_name ); ?><?php echo $latest; ?>
              <?php $update_count++; ?>
              <?php if ( !empty( $module['download'] ) ): ?>
                <p>
                  <a class="button-primary update-automatically" href="#" data-module="<?php echo $module['name'];?>" data-download="<?php echo $module['download'];?>" data-latest="<?php echo $latest;?>">
                    <?php _e( "Update Automatically", $this->plugin_name ); ?>
                  </a>
                  
                  <a class="button-secondary" href="<?php echo $module['download']; ?>" target="_blank">
                    <?php _e( "Manual Download", $this->plugin_name ); ?>
                  </a>
                </p>
              
              <?php endif; ?>
              
            <?php else: ?>
              <?php _e( "Updates are unavailable for this module.", $this->plugin_name ); ?>              
            <?php endif; ?>
          </div>
      
          <div class="module-actions">
            
            <?php if ( isset( $module['active'] ) && $module['active'] ): ?>
              <a class="module-deactivate button-secondary" href="#" data-module="<?php echo $module['name']; ?>">
                <?php _e( "Deactivate", $this->plugin_name ); ?>
              </a>
            <?php else: ?>
              <a class="module-activate button-secondary" href="#" data-module="<?php echo $module['name']; ?>">
                <?php _e( "Activate", $this->plugin_name ); ?>
              </a>
            <?php endif; ?>
            
            <a class="module-delete button-secondary" href="#" data-module="<?php echo $module['name']; ?>">
              <?php _e( "Delete", $this->plugin_name ); ?>
            </a>
          </div>
          
          <div class="module-messages"></div>
          
        </div>
        
      <?php endforeach; ?>
    
    <?php else: ?>
    
      <p><?php _e( "There are no modules currently installed.", $this->plugin_name ); ?></p>
      
      <p>
        <?php _e( "You can add a module by clicking the \"Add New\" button, or by dragging and dropping a module ZIP file straight into this panel.", $this->plugin_name ); ?><br>
        <?php _e( "Or, if you'd prefer to do things manually (e.g. in the case of file permission issues), you can use an FTP client to place modules into your wp-content/bb-modules directory.", $this->plugin_name ); ?>
      </p>
          
    <?php endif; ?>
    </div>
  </div>
</div>
