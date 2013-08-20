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
class WC_Compare_Product_Page_Settings
{
	public static function get_settings_default() {
		$default_settings = array(
			'product_page_button_position'	=> 'above',
			'product_page_button_below_padding'=> 10,
			'product_page_button_above_padding'=> 10,
			'disable_product_page_compare'	=> 0,
			
			'auto_add'						=> 'yes',
		);
		
		return $default_settings;
	}
	
	public static function set_settings_default($reset=false) {
		$woo_compare_product_page_settings = get_option('woo_compare_product_page_settings');
		if ( !is_array($woo_compare_product_page_settings) ) $woo_compare_product_page_settings = array();
		
		$default_settings = WC_Compare_Product_Page_Settings::get_settings_default();
		
		$woo_compare_product_page_settings = array_merge($default_settings, $woo_compare_product_page_settings);
		
		if ($reset) {
			update_option('woo_compare_product_page_settings', $default_settings);
		} else {
			update_option('woo_compare_product_page_settings', $woo_compare_product_page_settings);
		}
				
	}
	
	public static function get_settings() {
		global $woo_compare_product_page_settings;
		$woo_compare_product_page_settings = get_option('woo_compare_product_page_settings');
		if ( !is_array($woo_compare_product_page_settings) ) $woo_compare_product_page_settings = array();
		$default_settings = WC_Compare_Product_Page_Settings::get_settings_default();
		
		$woo_compare_product_page_settings = array_merge($default_settings, $woo_compare_product_page_settings);
		
		foreach ($woo_compare_product_page_settings as $key => $value) {
			if (trim($value) == '') $woo_compare_product_page_settings[$key] = $default_settings[$key];
			else $woo_compare_product_page_settings[$key] = esc_attr( stripslashes( $value ) );
		}
		
		return $woo_compare_product_page_settings;
	}
		
	public static function panel_page() {
		$message = '';
		if (isset($_REQUEST['bt_save_settings'])) {
			$woo_compare_product_page_settings = $_REQUEST['woo_compare_product_page_settings'];
			
			if ( !isset($woo_compare_product_page_settings['disable_product_page_compare']) ) $woo_compare_product_page_settings['disable_product_page_compare'] = 0;
			if ( !isset($woo_compare_product_page_settings['auto_add']) ) $woo_compare_product_page_settings['auto_add'] = 'yes';
						
			update_option('woo_compare_product_page_settings', $woo_compare_product_page_settings);
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			WC_Compare_Product_Page_Settings::set_settings_default(true);
		}
		
		$woo_compare_product_page_settings = get_option('woo_compare_product_page_settings');
		$default_settings = WC_Compare_Product_Page_Settings::get_settings_default();
		if ( !is_array($woo_compare_product_page_settings) ) $woo_compare_product_page_settings = $default_settings;
		else $woo_compare_product_page_settings = array_merge($default_settings, $woo_compare_product_page_settings);
		
		extract($woo_compare_product_page_settings);
		
		?>
        <h3><?php _e('Product Page Compare Button/Link Position', 'woo_cp'); ?></h3>
        <table class="form-table">
			<tbody>
				<tr valign="top">
					<th class="titledesc" scope="rpw"><label><?php _e('Button/Link Position relative to Add to Cart Button','woo_cp'); ?></label></th>
                    <td class="forminp">
                    	<div style="width:160px; float:left;"><label><input type="radio" name="woo_compare_product_page_settings[product_page_button_position]" value="above" <?php if ( $product_page_button_position == 'above') { echo 'checked="checked"';} ?> /> <?php _e('Above','woo_cp'); ?></label></div> <div style="float:left; width:100px;"><label for="product_page_button_above_padding"><?php _e('Padding Bottom','woo_cp'); ?></label></div> <input type="text" name="woo_compare_product_page_settings[product_page_button_above_padding]" id="product_page_button_above_padding" value="<?php esc_attr_e( stripslashes( $product_page_button_above_padding ) ); ?>" size="3" /> px
                    	<div style="clear:both;"></div>
                    	<div style="width:160px; float:left;"><label><input type="radio" name="woo_compare_product_page_settings[product_page_button_position]" value="below" <?php if ( $product_page_button_position == 'below') { echo 'checked="checked"';} ?> /> <?php _e('Below','woo_cp'); ?></label></div> <div style="float:left; width:100px;"><label for="product_page_button_below_padding"><?php _e('Padding Top','woo_cp'); ?></label></div> <input type="text" name="woo_compare_product_page_settings[product_page_button_below_padding]" id="product_page_button_below_padding" value="<?php esc_attr_e( stripslashes( $product_page_button_below_padding ) ); ?>" size="3" /> px
                        <div style="clear:both;"></div>
                    	<?php _e("Change position if Compare Button/Link does not show on Product Page.", 'woo_cp'); ?>
                    </td>
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="auto_add2"><?php _e('Manually set Compare button position', 'woo_cp'); ?></label></th>
                    <td class="forminp"><label><input type="checkbox" name="woo_compare_product_page_settings[auto_add]" id="auto_add2" value="no" <?php if ( $auto_add == 'no') { echo 'checked="checked"';} ?> /> <?php _e('Check to deactivate default button position settings created by the plugin.', 'woo_cp'); ?></label><br />
                    <?php _e('Then use this function to manually postion the Compare button on product pages', 'woo_cp'); ?> <br /><code>&lt;?php if(function_exists('woo_add_compare_button')) echo woo_add_compare_button(); ?&gt;</code></td>
                </tr>
			</tbody>
		</table>
        
        <h3><?php _e('Activate / Deactivate', 'woo_cp'); ?></h3>
        <table cellspacing="0" class="form-table">
			<tbody>
            	<tr valign="top">
					<th class="titledesc" scope="rpw"><label for="disable_product_page_compare"><?php _e('Product Page Compare', 'woo_cp'); ?></label></th>
                    <td class="forminp"><label><input type="checkbox" name="woo_compare_product_page_settings[disable_product_page_compare]" id="disable_product_page_compare" value="1" <?php if ( $disable_product_page_compare == 1) { echo 'checked="checked"';} ?> /> <?php _e('Check to deactivate the Compare feature on all product pages.', 'woo_cp'); ?></label></td>
                </tr>
            </tbody>
        </table>
	<?php
	}
}
?>