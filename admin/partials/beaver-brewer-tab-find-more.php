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
 
 $orderby = ( !empty( $_REQUEST['orderby'] ) ? $_REQUEST['orderby'] : 'date' );
 $filter = ( !empty( $_REQUEST['filter'] ) ? $_REQUEST['filter'] : 'none' );
 $search = ( !empty( $_REQUEST['search'] ) ? $_REQUEST['search'] : '' );
?>
<div id="find-more-modules">
    
  <h2><?php _e( "Find Beaver Brewer Modules", $this->plugin_name ); ?></h2> 
  <div id="module-directory">        

    <div class="module-directory-toolbar">
      
      <div class="toolbar-section order-box">
        <strong>Browse By: </strong>
        <a class="<?php echo ( empty( $search ) && $orderby == 'date' ? 'active-orderby' : '' ); ?>" href="<?php echo add_query_arg( "orderby", "date" );?>">
            <?php _e( "Most Recent", $this->plugin_name ); ?>
        </a>
        <a class="<?php echo ( empty( $search ) && $orderby == 'date_asc' ? 'active-orderby' : '' ); ?>" href="<?php echo add_query_arg( "orderby", "date_asc" );?>">
          <?php _e( "Least Recent", $this->plugin_name ); ?>
        </a>
        <a class="<?php echo ( empty( $search ) && $orderby == 'name' ? 'active-orderby' : '' ); ?>" href="<?php echo add_query_arg( "orderby", "name" );?>">
          <?php _e( "Name (Alphabetically)", $this->plugin_name ); ?>
        </a>  
      </div>
      
      <div class="toolbar-section filter-box">
        <strong>Filter: </strong>
        <a class="<?php echo ( empty( $search ) && $filter == 'none' ? 'active-filter' : '' ); ?>" href="<?php echo add_query_arg( "filter", "none" );?>">
          <?php _e( "None", $this->plugin_name ); ?>
        </a>
        <a class="<?php echo ( empty( $search ) && $filter == 'free' ? 'active-filter' : '' ); ?>" href="<?php echo add_query_arg( "filter", "free" );?>">
          <?php _e( "Free Modules", $this->plugin_name ); ?>
        </a>
        <a class="<?php echo ( empty( $search ) && $filter == 'paid' ? 'active-filter' : '' ); ?>" href="<?php echo add_query_arg( "filter", "paid" );?>">
          <?php _e( "Paid Modules", $this->plugin_name ); ?>
        </a> 
      </div>
      
      <form method="POST" action="">
      <input type="search" name="search" id="module-search" size="30" placeholder="<?php _e( "Enter Search Term...", $this->plugin_name ); ?>" value="<?php ( isset( $_REQUEST['search'] ) ? $_REQUEST['search'] : '' ); ?>">
      <input type="submit" class="button-secondary" value="<?php _e( "Search Modules", $this->plugin_name ); ?>">
      </form>
    </div>    
    
    
    <?php $this->prepare_module_results(); ?>

  </div>
</div>
