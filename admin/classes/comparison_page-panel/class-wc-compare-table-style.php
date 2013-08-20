<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WooCommerce Compare Table Row Style Class
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 *
 */
class WC_Compare_Table_Row_Style
{
	public static function get_settings_default() {
		$default_settings = array(
			'table_border_size'				=> '1px',
			'table_border_style'			=> 'solid',
			'table_border_colour'			=> '#D6D6D6',
			
			'table_heading_bg_colour'		=> '#FFFFE0',
			'alt_row_bg_colour'				=> '#F6F6F6',
			
			'row_padding_topbottom'			=> 10,
			'row_padding_leftright'			=> 10,
		);
		
		return $default_settings;
	}
	
	public static function set_settings_default($reset=false) {
		
		$default_settings = WC_Compare_Table_Row_Style::get_settings_default();
				
		if ($reset) {
			update_option('woo_compare_table_style', $default_settings);
		} else {
			update_option('woo_compare_table_style', $default_settings);
		}
				
	}
	
	public static function get_settings() {
		global $woo_compare_table_style;
		$woo_compare_table_style = WC_Compare_Table_Row_Style::get_settings_default();
		
		return $woo_compare_table_style;
	}
		
	public static function panel_page() {
		$message = '';
		if (isset($_REQUEST['bt_save_settings'])) {
			WC_Compare_Table_Row_Style::set_settings_default(true);
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			WC_Compare_Table_Row_Style::set_settings_default(true);
		}
		
		$woo_compare_table_style = $default_settings = WC_Compare_Table_Row_Style::get_settings_default();
		
		extract($woo_compare_table_style);
		$fonts = WC_Compare_Functions::get_font();
		
		?>
        <h3><?php _e('Table Background', 'woo_cp'); ?></h3>
        <table cellspacing="0" class="form-table">
			<tbody>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="table_heading_bg_colour"><?php _e('Table Heading Background Colour','woo_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" value="<?php esc_attr_e( stripslashes( $table_heading_bg_colour ) );?>" style="width:120px;" id="table_heading_bg_colour" name="woo_compare_table_style[table_heading_bg_colour]" /> <span class="description"><?php _e('Default', 'woo_cp');?> <code><?php echo $default_settings['table_heading_bg_colour']; ?></code></span>
            			<div id="colorPickerDiv_table_heading_bg_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="alt_row_bg_colour"><?php _e('Alternate Rows Background Colour','woo_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" value="<?php esc_attr_e( stripslashes( $alt_row_bg_colour ) );?>" style="width:120px;" id="alt_row_bg_colour" name="woo_compare_table_style[alt_row_bg_colour]" /> <span class="description"><?php _e('Default', 'woo_cp');?> <code><?php echo $default_settings['alt_row_bg_colour']; ?></code></span>
            			<div id="colorPickerDiv_alt_row_bg_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
			</tbody>
		</table>
        
        <h3><?php _e('Table Border', 'woo_cp'); ?></h3>
        <table cellspacing="0" class="form-table">
			<tbody>
                <tr valign="top">
					<th class="titledesc" scope="rpw"><label for="table_border_size"><?php _e('Border Size','woo_cp'); ?></label></th>
					<td class="forminp">
						<select class="chzn-select" style="width:120px;" id="table_border_size" name="woo_compare_table_style[table_border_size]">
							<option value="" selected="selected"><?php _e('Select Size', 'woo_cp');?></option>
                                <?php
                                for( $i = 0 ; $i <= 10 ; $i++ ){
                                    if( $table_border_size ==  $i.'px' ){
                                    ?>
                                        <option value='<?php echo ($i); ?>px' selected='selected'><?php echo $i; ?>px</option>
                                    <?php }else{ ?>
                                        <option value='<?php echo ($i); ?>px'><?php echo $i; ?>px</option>
                                    <?php
                                    }
                                }
                                ?>                                  
						</select> <span class="description"><?php _e('Default', 'woo_cp');?> <code><?php echo $default_settings['table_border_size'] ?></code></span>
					</td>
				</tr>
				<tr>
					<th class="titledesc" scope="row"><label for="table_border_style"><?php _e('Border Style', 'woo_cp');?></label></th>
					<td class="forminp">
						<select class="chzn-select" style="width:120px;" id="table_border_style" name="woo_compare_table_style[table_border_style]">
                                  <option selected="selected" value="solid"><?php _e('Solid', 'woo_cp');?></option>
                                  <option <?php if( $table_border_style == 'double'){ echo 'selected="selected" ';} ?>value="double"><?php _e('Double', 'woo_cp');?></option>
                                  <option <?php if( $table_border_style == 'dashed'){ echo 'selected="selected" ';} ?>value="dashed"><?php _e('Dashed', 'woo_cp');?></option>
                                  <option <?php if( $table_border_style == 'dotted'){ echo 'selected="selected" ';} ?>value="dotted"><?php _e('Dotted', 'woo_cp');?></option>
						</select> <span class="description"><?php _e('Default', 'woo_cp');?> <code><?php _e('Solid', 'woo_cp');?></code></span>
					</td>
				</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="table_border_colour"><?php _e('Border Colour','woo_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" value="<?php esc_attr_e( stripslashes( $table_border_colour ) );?>" style="width:120px;" id="table_border_colour" name="woo_compare_table_style[table_border_colour]" /> <span class="description"><?php _e('Border colour. Default', 'woo_cp');?> <code><?php echo $default_settings['table_border_colour']; ?></code></span>
            			<div id="colorPickerDiv_table_border_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
			</tbody>
		</table>
        
        <h3><?php _e('Table Row Padding', 'woo_cp'); ?></h3>
        <table cellspacing="0" class="form-table">
			<tbody>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="row_padding_topbottom"><?php _e('Padding Top/Bottom','woo_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" value="<?php esc_attr_e( stripslashes( $row_padding_topbottom ) );?>" style="width:120px;" id="row_padding_topbottom" name="woo_compare_table_style[row_padding_topbottom]" />px <span class="description"><?php _e('Default', 'woo_cp');?> <code><?php echo $default_settings['row_padding_topbottom']; ?></code>px</span>
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="row_padding_leftright"><?php _e('Padding Left/Right','woo_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" value="<?php esc_attr_e( stripslashes( $row_padding_leftright ) );?>" style="width:120px;" id="row_padding_leftright" name="woo_compare_table_style[row_padding_leftright]" />px <span class="description"><?php _e('Default', 'woo_cp');?> <code><?php echo $default_settings['row_padding_leftright']; ?></code>px</span>
                    </td>
               	</tr>
			</tbody>
		</table>
	<?php
	}
}
?>