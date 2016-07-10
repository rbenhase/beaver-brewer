<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://beaverbrewer.com
 * @since      0.1.0
 *
 * @package    Beaver_Brewer
 * @subpackage Beaver_Brewer/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
  <h1><?php _e( "Beaver Brewer", $this->plugin_name ); ?></h1>
  
  <?php $ready = $this->check_directory(); ?>
  
  <?php if ( $ready ): ?>
    <hr>

    <?php $tab = $this->get_admin_page_tabs(); ?>
        
    <?php if ( $tab === 'my-modules' ): ?>
      
      <?php include_once( 'beaver-brewer-tab-my-modules.php' ); ?>
    
    <?php elseif( $tab === 'find-more' ): ?>
    
      <?php include_once( 'beaver-brewer-tab-find-more.php' ); ?>
      
    <?php elseif( $tab === 'install' ): ?>
    
      <?php include_once( 'beaver-brewer-tab-install.php' ); ?>
    
    <?php else: ?>
    
      <p>Tab not found.</p>
    
    <?php endif; ?>
      
  <?php else: ?>
  
  <?php endif; ?>
  
  <h4>
  <?php _e( "Warning: Installing modules from untrusted sources could create big problems for you and your site.<br>
              Always use caution when adding or updating modules, and back up your site on a regular basis.", $this->plugin_name ); ?>
</h4>
</div>