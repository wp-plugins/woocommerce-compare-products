<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WooCommerce Compare Grid View Panel
 *
 * Table Of Contents
 *
 * panel_manager()
 */
class WC_Compare_Grid_View_Panel{
	function panel_manager() {
		$message = '';
		if (isset($_REQUEST['bt_save_settings'])) {
			$message = '<div class="updated" id=""><p>'.__('Gird View Style Successfully saved.', 'woo_cp').'</p></div>';
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			$message = '<div class="updated" id=""><p>'.__('Gird View Style Successfully reseted.', 'woo_cp').'</p></div>';
		}
		
		?>
        <?php echo $message; ?>
	<form action="" method="post">
    <div id="wc_compare_product_panel_container">
    	<div id="wc_compare_product_panel_fields" class="a3_subsubsub_section">
        	<ul class="subsubsub">
                <li><a href="#global-settings" class="current"><?php _e('Grid View Settings', 'woo_cp'); ?></a> | </li>
                <li><a href="#grid-view-button"><?php _e('Grid View Button', 'woo_cp'); ?></a> | </li>
                <li><a href="#grid-view-view-compare"><?php _e('View Compare', 'woo_cp'); ?></a></li>
			</ul>
            <br class="clear">
            <div class="section" id="global-settings">
            	<?php WC_Compare_Grid_View_Settings::panel_page(); ?>
            </div>
            
            <div class="section" id="grid-view-button">
            	<div class="pro_feature_fields">
                <?php WC_Compare_Grid_View_Button_Style::panel_page(); ?>
                </div>
            </div>
            
            <div class="section" id="grid-view-view-compare">
            	<div class="pro_feature_fields">
                <?php WC_Compare_Grid_View_View_Compare_Style::panel_page(); ?>
                </div>
            </div>
        </div>
        <div id="wc_compare_product_upgrade_area"><?php echo WC_Compare_Functions::plugin_pro_notice(); ?></div>
	</div>
        <div style="clear:both;"></div>            
            <p class="submit">
                <input type="submit" value="<?php _e('Save changes', 'woo_cp'); ?>" class="button-primary" name="bt_save_settings" id="bt_save_settings">
				<input type="submit" name="bt_reset_settings" id="bt_reset_settings" class="button" value="<?php _e('Reset Settings', 'woo_cp'); ?>"  />
        		<input type="hidden" id="last_tab" name="subtab" />
            </p>
    </form>
	<?php
	}
}
?>