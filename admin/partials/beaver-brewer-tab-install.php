<?php

/**
 * The hidden "Install Module" tab of the Beaver Brewer admin page.
 *
 * @link       http://beaverbrewer.com
 * @since      0.4.0
 *
 * @package    Beaver_Brewer
 * @subpackage Beaver_Brewer/admin/partials
 */
?>
<div id="install-modules">
    
  <h2><?php _e( "Install Module", $this->plugin_name ); ?></h2> 
  <div id="install-result">            
    <?php $source = ( isset( $_REQUEST['source'] ) ? $_REQUEST['source'] : false ); ?>
    <?php $slug = ( isset( $_REQUEST['module'] ) ? $_REQUEST['module'] : false ); ?>
    <?php if ( $source && $slug ): ?>
      <p><?php $result = $this->install_module( $_REQUEST['source'] ); ?></p>
      
      <?php if ( $result === true ): ?>
        <a class="button-primary" href="<?php echo wp_nonce_url( admin_url( 'admin.php?page=beaver-brewer&tab=my-modules&activate=' . $slug ), 'activate_module', 'activate_module_nonce' ); ?>">
          <?php _e( "Activate Module Now" ); ?>
        </a>
        <a class="button-secondary" href="<?php echo admin_url( 'admin.php?page=beaver-brewer&tab=my-modules' ); ?>">
          <?php _e( "View Your Installed Modules" ); ?>
        </a>
      <?php else: ?>
      <a class="button-secondary" href="<?php echo admin_url( 'admin.php?page=beaver-brewer&tab=my-modules' ); ?>">
        <?php _e( "View Your Installed Modules" ); ?>
      </a><br> 
      <a class="button-secondary" href="<?php echo admin_url( 'admin.php?page=beaver-brewer&tab=find-more' ); ?>">
        <?php _e( "Back to Find More Modules" ); ?>
      </a>
      <?php endif; ?>
    <?php else: ?>
      <p><?php _e( "An empty or invalid source was specified." ); ?></p>
    <?php endif; ?>
  </div>
</div>
