<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WooCommerce Compare Product Page Settings Class
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 *
 */
class WC_Compare_Product_Page_Tab
{
	public static function get_settings_default() {
		$default_settings = array(
			'auto_compare_featured_tab'		=> 29,
			'compare_featured_tab'			=> __('Technical Details', 'woo_cp'),
			
			'disable_compare_featured_tab'	=> 0,
		);
		
		return $default_settings;
	}
	
	public static function set_settings_default($reset=false) {
		$woo_compare_product_page_tab = get_option('woo_compare_product_page_tab');
		if ( !is_array($woo_compare_product_page_tab) ) $woo_compare_product_page_tab = array();
		
		$default_settings = WC_Compare_Product_Page_Tab::get_settings_default();
		
		$woo_compare_product_page_tab = array_merge($default_settings, $woo_compare_product_page_tab);
		
		if ($reset) {
			update_option('woo_compare_product_page_tab', $default_settings);
		} else {
			update_option('woo_compare_product_page_tab', $woo_compare_product_page_tab);
		}
				
	}
	
	public static function get_settings() {
		global $woo_compare_product_page_tab;
		$woo_compare_product_page_tab = get_option('woo_compare_product_page_tab');
		if ( !is_array($woo_compare_product_page_tab) ) $woo_compare_product_page_tab = array();
		$default_settings = WC_Compare_Product_Page_Tab::get_settings_default();
		
		$woo_compare_product_page_tab = array_merge($default_settings, $woo_compare_product_page_tab);
		
		foreach ($woo_compare_product_page_tab as $key => $value) {
			if (trim($value) == '') $woo_compare_product_page_tab[$key] = $default_settings[$key];
			else $woo_compare_product_page_tab[$key] = esc_attr( stripslashes( $value ) );
		}
		
		return $woo_compare_product_page_tab;
	}
		
	public static function panel_page() {
		$message = '';
		if (isset($_REQUEST['bt_save_settings'])) {
			$woo_compare_product_page_tab = $_REQUEST['woo_compare_product_page_tab'];
			
			if ( !isset($woo_compare_product_page_tab['disable_compare_featured_tab']) ) $woo_compare_product_page_tab['disable_compare_featured_tab'] = 1;
						
			update_option('woo_compare_product_page_tab', $woo_compare_product_page_tab);
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			WC_Compare_Product_Page_Tab::set_settings_default(true);
		}
		
		$woo_compare_product_page_tab = get_option('woo_compare_product_page_tab');
		$default_settings = WC_Compare_Product_Page_Tab::get_settings_default();
		if ( !is_array($woo_compare_product_page_tab) ) $woo_compare_product_page_tab = $default_settings;
		else $woo_compare_product_page_tab = array_merge($default_settings, $woo_compare_product_page_tab);
		
		extract($woo_compare_product_page_tab);
		
		?>
        <h3><?php _e('Activate / Deactivate', 'woo_cp'); ?></h3>
        <table cellspacing="0" class="form-table">
			<tbody>
            	<tr valign="top">
					<th class="titledesc" scope="rpw"><label for="disable_compare_featured_tab"><?php _e('Compare Features Tab', 'woo_cp'); ?></label></th>
                    <td class="forminp"><label><input type="checkbox" name="woo_compare_product_page_tab[disable_compare_featured_tab]" id="disable_compare_featured_tab" value="0" <?php checked( $disable_compare_featured_tab, 0); ?> /> <?php _e('Check to activate the Compare features tab on product pages.', 'woo_cp'); ?></label></td>
                </tr>
            </tbody>
        </table>
        
        <h3><?php _e('Compare Tab Position', 'woo_cp'); ?></h3>
        <table class="form-table">
			<tbody>
				<tr valign="top">
					<th class="titledesc" scope="rpw"><label><?php _e('Compare Features Tab', 'woo_cp'); ?></label></th>
                    <td class="forminp">
                    	<div style="float:left; width:305px;">
                            <label><input type="radio" name="woo_compare_product_page_tab[auto_compare_featured_tab]" value="9" <?php if ( $auto_compare_featured_tab == 9) { echo 'checked="checked"';} ?> /> <?php _e('Before Description tab', 'woo_cp'); ?></label> <br />
                            <label><input type="radio" name="woo_compare_product_page_tab[auto_compare_featured_tab]" value="19" <?php if ( $auto_compare_featured_tab == 19) { echo 'checked="checked"';} ?> /> <?php _e('Between  Description and Additional tabs', 'woo_cp'); ?></label>  <br />
                            <label><input type="radio" name="woo_compare_product_page_tab[auto_compare_featured_tab]" value="29" <?php if ( $auto_compare_featured_tab == 29) { echo 'checked="checked"';} ?> /> <?php _e('Between  Additional and Reviews tabs', 'woo_cp'); ?> </label> <br />
                            <label><input type="radio" name="woo_compare_product_page_tab[auto_compare_featured_tab]" value="31" <?php if ( $auto_compare_featured_tab == 31) { echo 'checked="checked"';} ?> /> <?php _e('After Reviews tab', 'woo_cp'); ?></label>
                        </div> 
                        <img class="help_tip" tip='<?php _e('Select the position of the Compare Features tab on the default WooCommerce product page Nav bar. Products Compare feature list shows under the tab.', 'woo_cp') ?>' src="<?php echo WOOCP_IMAGES_URL; ?>/help.png" /></td>
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="compare_featured_tab"><?php _e('Compare Tab Name', 'woo_cp'); ?></label></th>
                    <td class="forminp"><input type="text" name="woo_compare_product_page_tab[compare_featured_tab]" id="compare_featured_tab" value="<?php esc_attr_e( stripslashes( $compare_featured_tab ) ); ?>" style="min-width:300px;" /></td>
                </tr>
                <!--<tr valign="top">
                    <th class="titledesc" scope="rpw"><label><?php //_e('Manually set Compare Features list', 'woo_cp'); ?></label></th>
                    <td class="forminp"><?php //_e('Show Compare Featured fields anywhere in your theme with this function', 'woo_cp'); ?> <br /><code>&lt;?php if(function_exists('woo_show_compare_fields')) echo woo_show_compare_fields(); ?&gt;</code></td>
                 </tr>-->
			</tbody>
		</table>
	<?php
	}
}
?>