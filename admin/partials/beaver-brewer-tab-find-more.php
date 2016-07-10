<?php

/**
 * The "Find More Modules" tab of the Beaver Brewer admin page.
 *
 * @link       http://beaverbrewer.com
 * @since      0.3.0
 *
 * @package    Beaver_Brewer
 * @subpackage Beaver_Brewer/admin/partials
 */
?>
<div id="find-more-modules">
    
  <h2><?php _e( "Find Beaver Brewer Modules", $this->plugin_name ); ?></h2> 
  <div id="module-directory">        

    <div class="module-directory-toolbar">
      <a href="<?php echo add_query_arg( "orderby", "date", admin_url( "admin.php?page=beaver-brewer&tab=find-more" ) );?>"><?php _e( "By Most Recent", $this->plugin_name ); ?></a> |
      <a href="<?php echo add_query_arg( "orderby", "name", admin_url( "admin.php?page=beaver-brewer&tab=find-more" ) );?>"><?php _e( "Alphabetically", $this->plugin_name ); ?></a>
      <form method="POST" action="">
      <input type="search" name="search" id="module-search" size="30" placeholder="<?php _e( "Enter Search Term...", $this->plugin_name ); ?>" value="<?php ( isset( $_REQUEST['search'] ) ? $_REQUEST['search'] : '' ); ?>">
      <input type="submit" class="button-secondary" value="<?php _e( "Search Modules", $this->plugin_name ); ?>">
      </form>
    </div>    
    
    
    <?php $this->prepare_module_results(); ?>

  </div>
</div>
