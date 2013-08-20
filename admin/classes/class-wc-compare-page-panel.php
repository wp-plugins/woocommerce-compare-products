<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WooCommerce Comparison Table Panel
 *
 * Table Of Contents
 *
 * panel_manager()
 */
class WC_Compare_Page_Panel
{
	public static function panel_manager() {
		$message = '';
		if (isset($_REQUEST['bt_save_settings'])) {
			$message = '<div class="updated" id=""><p>'.__('Comparison Table Style Successfully saved.', 'woo_cp').'</p></div>';
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			$message = '<div class="updated" id=""><p>'.__('Comparison Table Style Successfully reseted.', 'woo_cp').'</p></div>';
		}
		
		?>
        <?php echo $message; ?>
	<form action="" method="post">
    <div id="wc_compare_product_panel_container">
    	<div id="wc_compare_product_panel_fields" class="a3_subsubsub_section">
        	<ul class="subsubsub">
            	<li><a href="#table-global-settings" class="current"><?php _e('Global Settings', 'woo_cp'); ?></a> | </li>
                <li><a href="#comparison-page-style"><?php _e('Page Style', 'woo_cp'); ?></a> | </li>
            	<li><a href="#table-style"><?php _e('Table Style', 'woo_cp'); ?></a> | </li>
                <li><a href="#table-content-style"><?php _e('Table Content Style', 'woo_cp'); ?></a> | </li>
                <li><a href="#product-prices-style"><?php _e('Product Prices', 'woo_cp'); ?></a> | </li>
                <li><a href="#addtocart-style"><?php _e('Add to Cart', 'woo_cp'); ?></a> | </li>
                <li><a href="#viewcart-style"><?php _e('View Cart', 'woo_cp'); ?></a> | </li>
                <li><a href="#print-page"><?php _e('Print Page', 'woo_cp'); ?></a> | </li>
                <li><a href="#close-window-button"><?php _e('Close Window Button', 'woo_cp'); ?></a></li>
			</ul>
            <br class="clear">
            <div class="section" id="table-global-settings">
            	<?php WC_Compare_Comparison_Page_Global_Settings::panel_page(); ?>
            </div>
            
            <div class="section" id="comparison-page-style">
            	<?php WC_Compare_Page_Style::panel_page(); ?>
            </div>
            
            <div class="section" id="table-style">
            	<div class="pro_feature_fields">
            	<?php WC_Compare_Table_Row_Style::panel_page(); ?>
                </div>
            </div>
            
            <div class="section" id="table-content-style">
            	<div class="pro_feature_fields">
            	<?php WC_Compare_Table_Content_Style::panel_page(); ?>
                </div>
            </div>
            
            <div class="section" id="product-prices-style">
            	<div class="pro_feature_fields">
				<?php WC_Compare_Price_Style::panel_page(); ?>
                </div>
            </div>
            
            <div class="section" id="addtocart-style">
            	<div class="pro_feature_fields">
				<?php WC_Compare_AddToCart_Style::panel_page(); ?>
                </div>
            </div>
            
            <div class="section" id="viewcart-style">
            	<div class="pro_feature_fields">
            	<?php WC_Compare_ViewCart_Style::panel_page(); ?>
                </div>
            </div>
            
            <div class="section" id="print-page">
            	<div class="pro_feature_fields">
				<?php WC_Compare_Print_Message_Style::panel_page(); ?>
                <?php WC_Compare_Print_Button_Style::panel_page(); ?>
                </div>
            </div>
            
            <div class="section" id="close-window-button">
                <div class="pro_feature_fields">
				<?php WC_Compare_Close_Window_Button_Style::panel_page(); ?>
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