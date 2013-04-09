<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WooCommerce Compare Grid View Settings Class
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 *
 */
class WC_Compare_Grid_View_Settings{
	function get_settings_default() {
		$default_settings = array(
			'grid_view_button_position'		=> 'above',
			'grid_view_button_below_padding'=> 10,
			'grid_view_button_above_padding'=> 10,
			'disable_grid_view_compare'		=> 0,
		);
		
		return $default_settings;
	}
	
	function set_settings_default($reset=false) {
		$woo_compare_grid_view_settings = get_option('woo_compare_grid_view_settings');
		if ( !is_array($woo_compare_grid_view_settings) ) $woo_compare_grid_view_settings = array();
		
		$default_settings = WC_Compare_Grid_View_Settings::get_settings_default();
		
		$woo_compare_grid_view_settings = array_merge($default_settings, $woo_compare_grid_view_settings);
		
		if ($reset) {
			update_option('woo_compare_grid_view_settings', $default_settings);
		} else {
			update_option('woo_compare_grid_view_settings', $woo_compare_grid_view_settings);
		}
				
	}
	
	function get_settings() {
		global $woo_compare_grid_view_settings;
		$woo_compare_grid_view_settings = get_option('woo_compare_grid_view_settings');
		if ( !is_array($woo_compare_grid_view_settings) ) $woo_compare_grid_view_settings = array();
		$default_settings = WC_Compare_Grid_View_Settings::get_settings_default();
		
		$woo_compare_grid_view_settings = array_merge($default_settings, $woo_compare_grid_view_settings);
		
		foreach ($woo_compare_grid_view_settings as $key => $value) {
			if (trim($value) == '') $woo_compare_grid_view_settings[$key] = $default_settings[$key];
			else $woo_compare_grid_view_settings[$key] = esc_attr( stripslashes( $value ) );
		}
		
		return $woo_compare_grid_view_settings;
	}
		
	function panel_page() {
		$message = '';
		if (isset($_REQUEST['bt_save_settings'])) {
			$woo_compare_grid_view_settings = $_REQUEST['woo_compare_grid_view_settings'];
			
			if ( !isset($woo_compare_grid_view_settings['disable_grid_view_compare']) ) $woo_compare_grid_view_settings['disable_grid_view_compare'] = 0;
						
			update_option('woo_compare_grid_view_settings', $woo_compare_grid_view_settings);
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			WC_Compare_Grid_View_Settings::set_settings_default(true);
		}
		
		$woo_compare_grid_view_settings = get_option('woo_compare_grid_view_settings');
		$default_settings = WC_Compare_Grid_View_Settings::get_settings_default();
		if ( !is_array($woo_compare_grid_view_settings) ) $woo_compare_grid_view_settings = $default_settings;
		else $woo_compare_grid_view_settings = array_merge($default_settings, $woo_compare_grid_view_settings);
		
		extract($woo_compare_grid_view_settings);
		
		?>
        <h3><?php _e('Grid View Compare Button/Link Position', 'woo_cp'); ?></h3>
        <p><?php _e('Configure how the Compare feature shows on products Grid View extracts on your themes Shop, Product Category and Product Tag Pages.', 'woo_cp'); ?></p>
        <table class="form-table">
			<tbody>
				<tr valign="top">
					<th class="titledesc" scope="rpw"><label><?php _e('Button/Link Position relative to Add to Cart Button','woo_cp'); ?></label></th>
                    <td class="forminp">
                    	<div style="width:160px; float:left;"><label><input type="radio" name="woo_compare_grid_view_settings[grid_view_button_position]" value="above" <?php if ( $grid_view_button_position == 'above') { echo 'checked="checked"';} ?> /> <?php _e('Above','woo_cp'); ?></label></div> <div style="float:left; width:100px;"><label for="grid_view_button_above_padding"><?php _e('Padding Bottom','woo_cp'); ?></label></div> <input type="text" name="woo_compare_grid_view_settings[grid_view_button_above_padding]" id="grid_view_button_above_padding" value="<?php esc_attr_e( stripslashes( $grid_view_button_above_padding ) ); ?>" size="3" /> px
                    	<div style="clear:both;"></div>
                    	<div style="width:160px; float:left;"><label><input type="radio" name="woo_compare_grid_view_settings[grid_view_button_position]" value="below" <?php if ( $grid_view_button_position == 'below') { echo 'checked="checked"';} ?> /> <?php _e('Below','woo_cp'); ?></label></div> <div style="float:left; width:100px;"><label for="grid_view_button_below_padding"><?php _e('Padding Top','woo_cp'); ?></label></div> <input type="text" name="woo_compare_grid_view_settings[grid_view_button_below_padding]" id="grid_view_button_below_padding" value="<?php esc_attr_e( stripslashes( $grid_view_button_below_padding ) ); ?>" size="3" /> px
                        <div style="clear:both;"></div>
                    	<?php _e("Change position if Compare Button/Link does not show on Grid View.", 'woo_cp'); ?>
                    </td>
                </tr>
			</tbody>
		</table>
        
        <h3><?php _e('Activate / Deactivate', 'woo_cp'); ?></h3>
        <table cellspacing="0" class="form-table">
			<tbody>
            	<tr valign="top">
					<th class="titledesc" scope="rpw"><label for="disable_grid_view_compare"><?php _e('Grid View Compare', 'woo_cp'); ?></label></th>
                    <td class="forminp"><label><input type="checkbox" name="woo_compare_grid_view_settings[disable_grid_view_compare]" id="disable_grid_view_compare" value="1" <?php if ( $disable_grid_view_compare == 1) { echo 'checked="checked"';} ?> /> <?php _e(' Check to deactivate the Compare feature on Grid View', 'woo_cp'); ?></label></td>
                </tr>
            </tbody>
        </table>
	<?php
	}
}
?>