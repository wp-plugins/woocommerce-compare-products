<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WooCommerce Compare Widget Thumbnails Style Class
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 *
 */
class WC_Compare_Widget_Thumbnail_Style{
	function get_settings_default() {
		$default_settings = array(
			'activate_thumbnail'			=> 1,
			'thumb_wide'					=> 64,
			'thumb_padding'					=> 2,
			'thumb_align'					=> 'right',
			'thumb_bg_colour'				=> '#FFFFFF',
			'thumb_border_size'				=> '1px',
			'thumb_border_style'			=> 'solid',
			'thumb_border_colour'			=> '#CDCDCE',
			'thumb_border_rounded'			=> 'square',
			'thumb_border_rounded_value' 	=> 10,
		);
		
		return $default_settings;
	}
	
	function set_settings_default($reset=false) {		
		$default_settings = WC_Compare_Widget_Thumbnail_Style::get_settings_default();
				
		if ($reset) {
			update_option('woo_compare_widget_thumbnail_style', $default_settings);
		} else {
			update_option('woo_compare_widget_thumbnail_style', $default_settings);
		}	
	}
	
	function get_settings() {
		global $woo_compare_widget_thumbnail_style;
		$woo_compare_widget_thumbnail_style = WC_Compare_Widget_Thumbnail_Style::get_settings_default();
		
		return $woo_compare_widget_thumbnail_style;
	}
		
	function panel_page() {
		$message = '';
		if (isset($_REQUEST['bt_save_settings'])) {											
			WC_Compare_Widget_Thumbnail_Style::set_settings_default(true);
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			WC_Compare_Widget_Thumbnail_Style::set_settings_default(true);
		}
		
		$woo_compare_widget_thumbnail_style = $default_settings = WC_Compare_Widget_Thumbnail_Style::get_settings_default();
		
		extract($woo_compare_widget_thumbnail_style);
		
		?>
		<h3><?php _e('Product Thumbnails in Widget', 'woo_cp'); ?></h3>
		<table cellspacing="0" class="form-table">
			<tbody>
            	<tr valign="top">
					<th class="titledesc" scope="rpw"><label for="compare_widget_activate_thumbnail"><?php _e('Product Thumbnails', 'woo_cp'); ?></label></th>
                    <td class="forminp"><label><input type="checkbox" name="woo_compare_widget_thumbnail_style[activate_thumbnail]" id="compare_widget_activate_thumbnail" value="1" <?php if ( $activate_thumbnail == 1) { echo 'checked="checked"';} ?> /> <?php _e('Check to show Product Thumbnails when items added to the Compare Widget.', 'woo_cp'); ?></label></td>
                </tr>
				<tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="compare_widget_thumb_wide"><?php _e('Thumbnail Wide','woo_cp'); ?></label></th>
                    <td class="forminp">
                        <input type="text" id="compare_widget_thumb_wide" name="woo_compare_widget_thumbnail_style[thumb_wide]" value="<?php esc_attr_e( $thumb_wide );?>" style="width:120px;" />px <span class="description"><?php _e('Default','woo_cp'); ?> <code><?php echo $default_settings['thumb_wide']; ?></code>px</span>
                    </td>
				</tr>
                <tr valign="top">
					<th class="titledesc" scope="rpw"><label for="compare_widget_thumb_padding"><?php _e('Thumbnail Padding','woo_cp'); ?></label></th>
					<td class="forminp">
						<input type="text" id="compare_widget_thumb_padding" name="woo_compare_widget_thumbnail_style[thumb_padding]" value="<?php esc_attr_e( $thumb_padding );?>" style="width:120px;" />px <span class="description"><?php _e('Default','woo_cp'); ?> <code><?php echo $default_settings['thumb_padding']; ?></code>px</span>
					</td>
				</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="compare_widget_thumb_align"><?php _e('Thumbnail Alignment','woo_cp'); ?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="compare_widget_thumb_align" name="woo_compare_widget_thumbnail_style[thumb_align]">
							<option selected="selected" value="left"><?php _e('Left', 'woo_cp'); ?></option>
                            <option <?php if($thumb_align == 'right'){ echo 'selected="selected"';} ?> value="right"><?php _e('Right', 'woo_cp'); ?></option>
						</select>
                    </td>
				</tr>
                <tr valign="top">
					<th class="titledesc" scope="rpw"><label for="compare_widget_thumb_bg_colour"><?php _e('Thumbnail Background Colour','woo_cp'); ?></label></th>
					<td class="forminp">
						<input type="text" class="colorpick" name="woo_compare_widget_thumbnail_style[thumb_bg_colour]" id="compare_widget_thumb_bg_colour" value="<?php esc_attr_e(stripslashes( $thumb_bg_colour ) );?>" style="width:120px;" /> <span class="description"><?php _e('Default', 'woo_cp');?> <code><?php echo $default_settings['thumb_bg_colour'] ?></code></span>
						<div id="colorPickerDiv_compare_widget_thumb_bg_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
					</td>
				</tr>
                <tr valign="top">
					<th class="titledesc" scope="rpw"><label for="compare_widget_thumb_border_size"><?php _e('Thumbnail Border Size','woo_cp'); ?></label></th>
					<td class="forminp">
						<select class="chzn-select" style="width:120px;" id="compare_widget_thumb_border_size" name="woo_compare_widget_thumbnail_style[thumb_border_size]">
                                <option value="" selected="selected"><?php _e('Select Size', 'woo_cp');?></option>
                                <?php
                                for( $i = 0 ; $i <= 10 ; $i++ ){
                                    if( $thumb_border_size ==  $i.'px' ){
                                    ?>
                                        <option value='<?php echo ($i); ?>px' selected='selected'><?php echo $i; ?>px</option>
                                    <?php }else{ ?>
                                        <option value='<?php echo ($i); ?>px'><?php echo $i; ?>px</option>
                                    <?php
                                    }
                                }
                                ?>                                  
						</select> <span class="description"><?php _e('Default', 'woo_cp');?> <code><?php echo $default_settings['thumb_border_size'] ?></code></span>
					</td>
				</tr>
				<tr>
					<th class="titledesc" scope="row"><label for="compare_widget_thumb_border_style"><?php _e('Thumbnail Border Style', 'woo_cp');?></label></th>
					<td class="forminp">
						<select class="chzn-select" style="width:120px;" id="compare_widget_thumb_border_style" name="woo_compare_widget_thumbnail_style[thumb_border_style]">
                                  <option selected="selected" value="solid"><?php _e('Solid', 'woo_cp');?></option>
                                  <option <?php if( $thumb_border_style == 'double'){ echo 'selected="selected" ';} ?>value="double"><?php _e('Double', 'woo_cp');?></option>
                                  <option <?php if( $thumb_border_style == 'dashed'){ echo 'selected="selected" ';} ?>value="dashed"><?php _e('Dashed', 'woo_cp');?></option>
                                  <option <?php if( $thumb_border_style == 'dotted'){ echo 'selected="selected" ';} ?>value="dotted"><?php _e('Dotted', 'woo_cp');?></option>
                                </select> <span class="description"><?php _e('Default', 'woo_cp');?> <code><?php _e('Solid', 'woo_cp');?></code></span>
					</td>
				</tr>
				<tr valign="top">
					<th class="titledesc" scope="rpw"><label for="compare_widget_thumb_border_colour"><?php _e('Thumbnail Border Colour','woo_cp'); ?></label></th>
					<td class="forminp">
						<input type="text" class="colorpick" name="woo_compare_widget_thumbnail_style[thumb_border_colour]" id="compare_widget_thumb_border_colour" value="<?php esc_attr_e(stripslashes( $thumb_border_colour ) );?>" style="width:120px;" /> <span class="description"><?php _e('Default', 'woo_cp');?> <code><?php echo $default_settings['thumb_border_colour'] ?></code></span>
						<div id="colorPickerDiv_compare_widget_thumb_border_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
					</td>
				</tr>
				<tr valign="top">
					<th class="titledesc" scope="rpw"><label for=""><?php _e('Thumbnail Border Rounded','woo_cp'); ?></label></th>
					<td class="forminp">
                            <label><input type="radio" name="woo_compare_widget_thumbnail_style[thumb_border_rounded]" value="rounded" <?php if( $thumb_border_rounded == 'rounded'){ echo 'checked="checked"'; } ?> /> <?php _e('Rounded Corners','woo_cp'); ?></label> &nbsp;&nbsp;&nbsp;&nbsp;
                            <label><?php _e('Rounded Value','woo_cp'); ?> <input type="text" name="woo_compare_widget_thumbnail_style[thumb_border_rounded_value]" value="<?php esc_attr_e( stripslashes( $thumb_border_rounded_value ) );?>" style="width:120px;" /></label>px <span class="description"><?php _e('Default', 'woo_cp');?> <code><?php echo $default_settings['thumb_border_rounded_value']; ?></code>px</span>
                            <br />
                            <label><input type="radio" name="woo_compare_widget_thumbnail_style[thumb_border_rounded]" value="square" id="square_cornes" <?php if( $thumb_border_rounded != 'rounded'){ echo 'checked="checked"'; } ?> /> <?php _e('Square Corners','woo_cp'); ?></label> <span class="description">(<?php _e('Default', 'woo_cp');?>)</span>
					</td>
				</tr>
			</tbody>
		</table>
	<?php
	}
}
?>