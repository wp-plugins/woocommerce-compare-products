<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WooCommerce Compare Settings page
 *
 * Table Of Contents
 *
 * woocp_set_setting_default()
 * woocp_settings_display()
 */
class WC_Compare_Settings {

	/**
	 * Set default settings for first install
	 */
	function woocp_set_setting_default($reset=false) {
		$comparable_settings = get_option('woo_comparable_settings');
		if (!is_array($comparable_settings) || count($comparable_settings) < 1) {
			$comparable_settings = array();
		}

		if (!isset($comparable_settings['compare_logo']) || trim($comparable_settings['compare_logo']) == '') {
			$comparable_settings['compare_logo'] = '';
		}
		if (!isset($comparable_settings['popup_width']) || trim($comparable_settings['popup_width']) == '' || $reset) {
			$comparable_settings['popup_width'] = 1000;
		}
		if (!isset($comparable_settings['popup_height']) || trim($comparable_settings['popup_height']) == '' || $reset) {
			$comparable_settings['popup_height'] = 650;
		}
		if (!isset($comparable_settings['compare_container_height']) || trim($comparable_settings['compare_container_height']) == '' || $reset) {
			$comparable_settings['compare_container_height'] = 500;
		}
		if (!isset($comparable_settings['auto_add']) || trim($comparable_settings['auto_add']) == '' || $reset) {
			$comparable_settings['auto_add'] = 'yes';
		}
		if (!isset($comparable_settings['button_text']) || trim($comparable_settings['button_text']) == '' || $reset) {
			$comparable_settings['button_text'] = 'Compare This*';
		}
		if (!isset($comparable_settings['compare_featured_tab']) || trim($comparable_settings['compare_featured_tab']) == '' || $reset) {
			$comparable_settings['compare_featured_tab'] = 'Technical Details';
		}
		if (!isset($comparable_settings['auto_compare_featured_tab']) || trim($comparable_settings['auto_compare_featured_tab']) == '' || $reset) {
			$comparable_settings['auto_compare_featured_tab'] = '29';
		}
		if (!isset($comparable_settings['button_type']) || trim($comparable_settings['button_type']) == '' || $reset) {
			$comparable_settings['button_type'] = 'button';
		}
		if (!isset($comparable_settings['popup_type']) || trim($comparable_settings['popup_type']) == '' || $reset) {
			$comparable_settings['popup_type'] = 'fancybox';
		}
		if (!isset($comparable_settings['button_position']) || trim($comparable_settings['button_position']) == '' || $reset) {
			$comparable_settings['button_position'] = 'above';
		}
		if (!isset($comparable_settings['above_padding']) || trim($comparable_settings['above_padding']) == '' || $reset) {
			$comparable_settings['above_padding'] = '10';
		}
		if (!isset($comparable_settings['below_padding']) || trim($comparable_settings['below_padding']) == '' || $reset) {
			$comparable_settings['below_padding'] = '10';
		}
		update_option('woo_comparable_settings', $comparable_settings);
	}

	/**
	 * Settings page HTML
	 */
	function woocp_settings_display() {
		global $wpdb, $woocommerce;
		$result_msg = '';
		$comparable_setting_msg = '';

		if (isset($_REQUEST['bt_save_settings'])) {
			$comparable_settings = get_option('woo_comparable_settings');
			if (!isset($_REQUEST['auto_add'])) $comparable_settings['auto_add'] = 'no';
			$comparable_settings = array_merge((array)$comparable_settings, $_REQUEST);
			update_option('woo_comparable_settings', $comparable_settings);
			$comparable_setting_msg = '<div class="updated" id="comparable_settings_msg"><p>'.__('Compare Settings Successfully saved.', 'woo_cp').'</p></div>';
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			WC_Compare_Settings::woocp_set_setting_default(true);
			$comparable_setting_msg = '<div class="updated" id="comparable_settings_msg"><p>'.__('Compare Settings Successfully reseted.', 'woo_cp').'</p></div>';
		}
?>
        <?php $comparable_settings = get_option('woo_comparable_settings'); ?>
        <form action="admin.php?page=woo-compare-settings" method="post" name="form_comparable_settings" id="form_comparable_settings">
        <h3><?php _e('Compare Fly-Out Window Setup', 'woo_cp'); ?></h3>
        <?php echo $comparable_setting_msg; ?>
  		<table class="form-table">
			<tbody>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="compare_logo"><?php _e('Add Fly-Out Header Image', 'woo_cp'); ?></label></th>
                    <td class="forminp"><input type="text" name="compare_logo" id="compare_logo" value="<?php if (isset($comparable_settings['compare_logo'])) echo $comparable_settings['compare_logo'] ?>" style="min-width:300px" /> <img class="help_tip" tip='<?php _e('Full image URL. File formats .jpg, .pgn, .jpeg. Any size.', 'woo_cp') ?>' src="<?php echo WOOCP_IMAGES_URL; ?>/help.png" /></td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="popup_width"><?php _e('Compare Fly-Out Width', 'woo_cp'); ?></label></th>
                    <td class="forminp"><input type="text" name="popup_width" id="popup_width" value="<?php if (isset($comparable_settings['popup_width']) ) echo $comparable_settings['popup_width'] ?>" size="3" /> px</td>
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="popup_height"><?php _e('Compare Fly-Out Height', 'woo_cp'); ?></label></th>
                    <td class="forminp"><input type="text" name="popup_height" id="popup_height" value="<?php if (isset($comparable_settings['popup_height']) ) echo $comparable_settings['popup_height'] ?>"  size="3" /> px</td>
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="compare_container_height"><?php _e('Fly-Out Inner Container Height', 'woo_cp'); ?></label></th>
                    <td class="forminp"><input type="text" name="compare_container_height" id="compare_container_height" value="<?php if (isset($comparable_settings['compare_container_height']) ) echo $comparable_settings['compare_container_height'] ?>" size="3" /> px <img class="help_tip" tip='<?php _e('Set at less than the Fly-Out height so Header Image stays visible in the Fly-Out screen.', 'woo_cp') ?>' src="<?php echo WOOCP_IMAGES_URL; ?>/help.png" /></td>
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="button_type"><?php _e('Compare Fly-Out Type', 'woo_cp'); ?></label></th>
                    <td class="forminp"><input type="radio" name="popup_type" id="popup_type1" value="fancybox" <?php if (!isset($comparable_settings['popup_type']) || $comparable_settings['popup_type'] == 'fancybox') { echo 'checked="checked"';} ?> /> <label for="popup_type1"><?php _e('Fancybox', 'woo_cp'); ?></label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="popup_type" id="popup_type2" value="lightbox" <?php if ($comparable_settings['popup_type'] == 'lightbox') { echo 'checked="checked"';} ?> /> <label for="popup_type2"><?php _e('Lightbox', 'woo_cp'); ?></label> <img class="help_tip" tip='<?php _e('Choose to power the Fly-Out Screen with fancybox or lightbox tool.', 'woo_cp') ?>' src="<?php echo WOOCP_IMAGES_URL; ?>/help.png" /></td>
                 </tr>
			</tbody>
		</table>
        <h3><?php _e('Product Page Compare Buttons', 'woo_cp'); ?></h3>
        <table class="form-table">
			<tbody>
				<tr valign="top">
					<th class="titledesc" scope="rpw"><label for="button_position1"><?php _e('Button Position relative to Add to Cart Button','woo_cp'); ?></label></th>
                    <td class="forminp"><div style="width:160px; float:left;"><input type="radio" name="button_position" id="button_position1" value="above" <?php if (!isset($comparable_settings['button_position']) || $comparable_settings['button_position'] == 'above') { echo 'checked="checked"';} ?> /> <label for="button_position1"><?php _e('Above','woo_cp'); ?></label></div> <div style="float:left; width:100px;"><label for="above_padding"><?php _e('Padding Bottom','woo_cp'); ?></label></div> <input type="text" name="above_padding" id="above_padding" value="<?php if (isset($comparable_settings['above_padding']) ) echo $comparable_settings['above_padding'] ?>" size="3" /> px
                    	<div style="clear:both;"></div>
                    	<div style="width:160px; float:left;"><input type="radio" name="button_position" id="button_position2" value="below" <?php if (isset($comparable_settings['button_position']) && $comparable_settings['button_position'] == 'below') { echo 'checked="checked"';} ?> /> <label for="button_position2"><?php _e('Below','woo_cp'); ?></label></div> <div style="float:left; width:100px;"><label for="above_padding"><?php _e('Padding Top','woo_cp'); ?></label></div> <input type="text" name="below_padding" id="below_padding" value="<?php if (isset($comparable_settings['below_padding']) ) echo $comparable_settings['below_padding'] ?>" size="3" /> px
                        <div style="clear:both;"></div>
                    	<?php _e("Change position if Compare Button does not show on the frontend.", 'woo_cp'); ?>
                    </td>
                </tr>
                <tr valign="top">
					<th class="titledesc" scope="rpw"><label for="auto_add1"><?php _e('Default Button setting', 'woo_cp'); ?></label></th>
                    <td class="forminp"><input type="radio" name="auto_add" id="auto_add1" value="yes" <?php if (!isset($comparable_settings['auto_add']) || $comparable_settings['auto_add'] == 'yes') { echo 'checked="checked"';} ?> /> <label for="auto_add1"><?php _e('Yes', 'woo_cp'); ?></label></td>
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="auto_add2"><?php _e('Manually set Compare button position', 'woo_cp'); ?></label></th>
                    <td class="forminp"><input type="radio" name="auto_add" id="auto_add2" value="no" <?php if (isset($comparable_settings['auto_add']) && $comparable_settings['auto_add'] == 'no') { echo 'checked="checked"';} ?> /> <label for="auto_add2"><?php _e('Yes', 'woo_cp'); ?></label> <img class="help_tip" tip='<?php _e('Select to manually set / change the default position of the Compare Button on product pages', 'woo_cp') ?>' src="<?php echo WOOCP_IMAGES_URL; ?>/help.png" /><br />
                    <?php _e('Use this function to manually postion the Compare button on product pages', 'woo_cp'); ?> <br /><code>&lt;?php if(function_exists('woo_add_compare_button')) echo woo_add_compare_button(); ?&gt;</code></td>
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="button_type"><?php _e('Button or Text', 'woo_cp'); ?></label></th>
                    <td class="forminp"><input type="radio" name="button_type" id="button_type1" value="button" <?php if (!isset($comparable_settings['button_type']) || $comparable_settings['button_type'] == 'button') { echo 'checked="checked"';} ?> /> <label for="button_type1"><?php _e('Button', 'woo_cp'); ?></label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="button_type" id="button_type2" value="link" <?php if ($comparable_settings['button_type'] == 'link') { echo 'checked="checked"';} ?> /> <label for="button_type2"><?php _e('Link', 'woo_cp'); ?></label> <img class="help_tip" tip='<?php _e('Show Compare feature on products as a Button or Hyperlink Text.', 'woo_cp') ?>' src="<?php echo WOOCP_IMAGES_URL; ?>/help.png" /><br />
                    <?php _e("Manual styling Class names - Compare Button 'bt_compare_this', sidebar widget button 'compare_button_go'", 'woo_cp'); ?></td>
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="button_text"><?php _e('Button or hyperlink text', 'woo_cp'); ?></label></th>
                    <td class="forminp"><input type="text" name="button_text" id="button_text" value="<?php if (isset($comparable_settings['button_text']) ) echo $comparable_settings['button_text']; ?>" style="min-width:300px;" /> <img class="help_tip" tip='<?php _e('Set text to show on Compare Button / Link on Product pages', 'woo_cp') ?>' src="<?php echo WOOCP_IMAGES_URL; ?>/help.png" /></td>
                 </tr>
			</tbody>
		</table>
        <h3><?php _e('Compare product page navigation tab', 'woo_cp'); ?></h3></td>
        <table class="form-table">
			<tbody>
				<tr valign="top">
					<th class="titledesc" scope="rpw"><label for=""><?php _e('Compare Features tab', 'woo_cp'); ?></label></th>
                    <td class="forminp"><div style="float:left; width:305px;">
                    	<input type="radio" name="auto_compare_featured_tab" value="9" <?php if (isset($comparable_settings['auto_compare_featured_tab']) && $comparable_settings['auto_compare_featured_tab'] == '9') { echo 'checked="checked"';} ?> /> <?php _e('Before Description tab', 'woo_cp'); ?>  <br />
                        <input type="radio" name="auto_compare_featured_tab" id="auto_compare_featured_tab1" value="19" <?php if (!isset($comparable_settings['auto_compare_featured_tab']) || $comparable_settings['auto_compare_featured_tab'] == '19') { echo 'checked="checked"';} ?> /> <label for="auto_compare_featured_tab1"><?php _e('Between  Description and Additional tabs', 'woo_cp'); ?></label>  <br />
                        <input type="radio" name="auto_compare_featured_tab" id="auto_compare_featured_tab2" value="29" <?php if (isset($comparable_settings['auto_compare_featured_tab']) && $comparable_settings['auto_compare_featured_tab'] == '29') { echo 'checked="checked"';} ?> /> <label for="auto_compare_featured_tab2"><?php _e('Between  Additional and Reviews tabs', 'woo_cp'); ?> </label> <br />
                        <input type="radio" name="auto_compare_featured_tab" id="auto_compare_featured_tab3" value="31" <?php if (isset($comparable_settings['auto_compare_featured_tab']) && $comparable_settings['auto_compare_featured_tab'] == '31') { echo 'checked="checked"';} ?> /> <label for="auto_compare_featured_tab3"><?php _e('After Reviews tab', 'woo_cp'); ?></label>  <br />
                        <input type="radio" name="auto_compare_featured_tab" id="auto_compare_featured_tab4" value="0" <?php if (isset($comparable_settings['auto_compare_featured_tab']) && $comparable_settings['auto_compare_featured_tab'] == '0') { echo 'checked="checked"';} ?> /> <label for="auto_compare_featured_tab4"><?php _e('Do not auto show', 'woo_cp'); ?></label></div> <img class="help_tip" tip='<?php _e('Select the position of the Compare Features tab on the default WooCommerce product page Nav bar. Products Compare feature list shows under the tab.', 'woo_cp') ?>' src="<?php echo WOOCP_IMAGES_URL; ?>/help.png" /></td>
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="compare_featured_tab"><?php _e('Compare Featured tab', 'woo_cp'); ?></label></th>
                    <td class="forminp"><input type="text" name="compare_featured_tab" id="compare_featured_tab" value="<?php if (isset($comparable_settings['compare_featured_tab']) ) echo $comparable_settings['compare_featured_tab']; ?>" style="min-width:300px;" /> <img class="help_tip" tip='<?php _e('Set tab name', 'woo_cp') ?>' src="<?php echo WOOCP_IMAGES_URL; ?>/help.png" /></td>
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for=""><?php _e('Manually set Compare Features list', 'woo_cp'); ?></label></th>
                    <td class="forminp"><?php _e('Show Compare Featured fields anywhere in your theme with this function', 'woo_cp'); ?> <br /><code>&lt;?php if(function_exists('woo_show_compare_fields')) echo woo_show_compare_fields(); ?&gt;</code></td>
                 </tr>
			</tbody>
		</table>
        <p class="submit">
	        	<input type="submit" value="<?php _e('Save changes', 'woo_cp'); ?>" class="button-primary" name="bt_save_settings" id="bt_save_settings">
	        	<input type="submit" name="bt_reset_settings" id="bt_reset_settings" class="button" value="<?php _e('Reset Settings', 'woo_cp'); ?>"  />
	    </p>
    	</form>
	<?php
	}

}
?>
