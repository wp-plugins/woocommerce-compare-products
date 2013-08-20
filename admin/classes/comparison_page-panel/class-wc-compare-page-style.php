<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WooCommerce Compare Page Style Class
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 *
 */
class WC_Compare_Page_Style
{
	public static function get_settings_default() {
		$default_settings = array(
			'header_bg_colour'				=> '#FFFFFF',
			'header_bottom_border_size'		=> '3px',
			'header_bottom_border_style'	=> 'solid',
			'header_bottom_border_colour'	=> '#666666',
			
			'body_bg_colour'				=> '#FFFFFF',
			
			'no_product_message_text'		=> __('You do not have any product to compare.', 'woo_cp'),
			'no_product_message_align'		=> 'center',
			'no_product_message_font'		=> 'Tahoma, Geneva, Verdana, sans-serif',
			'no_product_message_font_size'	=> '12px',
			'no_product_message_font_style'	=> 'normal',
			'no_product_message_font_colour'=> '#000000',
		);
		
		return $default_settings;
	}
	
	public static function set_settings_default($reset=false) {
		$woo_compare_page_style = get_option('woo_compare_page_style');
		if ( !is_array($woo_compare_page_style) ) $woo_compare_page_style = array();
		
		$default_settings = WC_Compare_Page_Style::get_settings_default();
		
		$woo_compare_page_style = array_merge($default_settings, $woo_compare_page_style);
		
		if ($reset) {
			update_option('woo_compare_page_style', $default_settings);
		} else {
			update_option('woo_compare_page_style', $woo_compare_page_style);
		}
				
	}
	
	public static function get_settings() {
		global $woo_compare_page_style;
		$woo_compare_page_style = get_option('woo_compare_page_style');
		if ( !is_array($woo_compare_page_style) ) $woo_compare_page_style = array();
		$default_settings = WC_Compare_Page_Style::get_settings_default();
		
		$woo_compare_page_style = array_merge($default_settings, $woo_compare_page_style);
		
		foreach ($woo_compare_page_style as $key => $value) {
			if (trim($value) == '') $woo_compare_page_style[$key] = $default_settings[$key];
			else $woo_compare_page_style[$key] = esc_attr( stripslashes( $value ) );
		}
		
		return $woo_compare_page_style;
	}
		
	public static function panel_page() {
		$message = '';
		if (isset($_REQUEST['bt_save_settings'])) {
			$woo_compare_page_style = $_REQUEST['woo_compare_page_style'];
						
			update_option('woo_compare_page_style', $woo_compare_page_style);
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			WC_Compare_Page_Style::set_settings_default(true);
		}
		
		$woo_compare_page_style = get_option('woo_compare_page_style');
		$default_settings = WC_Compare_Page_Style::get_settings_default();
		if ( !is_array($woo_compare_page_style) ) $woo_compare_page_style = $default_settings;
		else $woo_compare_page_style = array_merge($default_settings, $woo_compare_page_style);
		
		extract($woo_compare_page_style);
		$fonts = WC_Compare_Functions::get_font();
		
		?>
        <h3><?php _e('Comparison Page Header', 'woo_cp'); ?></h3>
        <table cellspacing="0" class="form-table">
			<tbody>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="header_bg_colour"><?php _e('Background Colour','woo_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" value="<?php esc_attr_e( stripslashes( $header_bg_colour ) );?>" style="width:120px;" id="header_bg_colour" name="woo_compare_page_style[header_bg_colour]" /> <span class="description"><?php _e('Default', 'woo_cp');?> <code><?php echo $default_settings['header_bg_colour']; ?></code></span>
            			<div id="colorPickerDiv_header_bg_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
                <tr valign="top">
					<th class="titledesc" scope="rpw"><label for="header_bottom_border_size"><?php _e('Bottom Border Size','woo_cp'); ?></label></th>
					<td class="forminp">
						<select class="chzn-select" style="width:120px;" id="header_bottom_border_size" name="woo_compare_page_style[header_bottom_border_size]">
							<option value="" selected="selected"><?php _e('Select Size', 'woo_cp');?></option>
                                <?php
                                for( $i = 0 ; $i <= 10 ; $i++ ){
                                    if( $header_bottom_border_size ==  $i.'px' ){
                                    ?>
                                        <option value='<?php echo ($i); ?>px' selected='selected'><?php echo $i; ?>px</option>
                                    <?php }else{ ?>
                                        <option value='<?php echo ($i); ?>px'><?php echo $i; ?>px</option>
                                    <?php
                                    }
                                }
                                ?>                                  
						</select> <span class="description"><?php _e('Default', 'woo_cp');?> <code><?php echo $default_settings['header_bottom_border_size'] ?></code></span>
					</td>
				</tr>
				<tr>
					<th class="titledesc" scope="row"><label for="header_bottom_border_style"><?php _e('Bottom Border Style', 'woo_cp');?></label></th>
					<td class="forminp">
						<select class="chzn-select" style="width:120px;" id="header_bottom_border_style" name="woo_compare_page_style[header_bottom_border_style]">
                                  <option selected="selected" value="solid"><?php _e('Solid', 'woo_cp');?></option>
                                  <option <?php if( $header_bottom_border_style == 'double'){ echo 'selected="selected" ';} ?>value="double"><?php _e('Double', 'woo_cp');?></option>
                                  <option <?php if( $header_bottom_border_style == 'dashed'){ echo 'selected="selected" ';} ?>value="dashed"><?php _e('Dashed', 'woo_cp');?></option>
                                  <option <?php if( $header_bottom_border_style == 'dotted'){ echo 'selected="selected" ';} ?>value="dotted"><?php _e('Dotted', 'woo_cp');?></option>
						</select> <span class="description"><?php _e('Default', 'woo_cp');?> <code><?php _e('Solid', 'woo_cp');?></code></span>
					</td>
				</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="header_bottom_border_colour"><?php _e('Bottom Border Colour','woo_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" value="<?php esc_attr_e( stripslashes( $header_bottom_border_colour ) );?>" style="width:120px;" id="header_bottom_border_colour" name="woo_compare_page_style[header_bottom_border_colour]" /> <span class="description"><?php _e('Border colour. Default', 'woo_cp');?> <code><?php echo $default_settings['header_bottom_border_colour']; ?></code></span>
            			<div id="colorPickerDiv_header_bottom_border_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
			</tbody>
		</table>

        <h3><?php _e('Comparison Page Body', 'woo_cp'); ?></h3>
        <table cellspacing="0" class="form-table">
			<tbody>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="body_bg_colour"><?php _e('Background Colour','woo_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" value="<?php esc_attr_e( stripslashes( $body_bg_colour ) );?>" style="width:120px;" id="body_bg_colour" name="woo_compare_page_style[body_bg_colour]" /> <span class="description"><?php _e('Default', 'woo_cp');?> <code><?php echo $default_settings['body_bg_colour']; ?></code></span>
            			<div id="colorPickerDiv_body_bg_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
			</tbody>
		</table>
        
        <h3><?php _e('Comparison Empty Window Message', 'woo_cp'); ?></h3>
        <table cellspacing="0" class="form-table">
			<tbody>
            	<tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="no_product_message_text"><?php _e('Comparison Empty Window Message Text','woo_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" value="<?php esc_attr_e( stripslashes( $no_product_message_text ) );?>" style="width:300px;" id="empty_text" name="woo_compare_page_style[no_product_message_text]" /> <span class="description"><?php _e('Default', 'woo_cp');?> '<code><?php echo $default_settings['no_product_message_text']; ?></code>'</span>
                    </td>
               	</tr>
                <tr>
                    <th class="titledesc" scope="row"><label for="no_product_message_align"><?php _e('Text Alignment', 'woo_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="no_product_message_align" name="woo_compare_page_style[no_product_message_align]">
                          <option value="center" selected="selected"><?php _e('Center', 'woo_cp');?></option>
                          <option <?php if( $no_product_message_align == 'left'){ echo 'selected="selected"';} ?> value="left"><?php _e('Left', 'woo_cp');?></option>
                          <option <?php if( $no_product_message_align == 'right'){ echo 'selected="selected"';} ?> value="right"><?php _e('Right', 'woo_cp');?></option>
                        </select> <span class="description"><?php _e('Default', 'woo_cp');?> <code><?php _e('Center', 'woo_cp');?></code></span>
                    </td>
				</tr>
                <tr>
					<th class="titledesc" scope="row"><label for="no_product_message_font"><?php _e('Font', 'woo_cp');?></label></th>
					<td class="forminp">
						<select class="chzn-select" style="width:120px;" id="no_product_message_font" name="woo_compare_page_style[no_product_message_font]">
							<option value="" selected="selected"><?php _e('Select Font', 'woo_cp');?></option>
								<?php
                                foreach($fonts as $key=>$value){
                                    if( htmlspecialchars( $no_product_message_font ) ==  htmlspecialchars($key) ){
                                        ?><option value='<?php echo htmlspecialchars($key); ?>' selected='selected'><?php echo $value; ?></option><?php
                                    }else{
                                        ?><option value='<?php echo htmlspecialchars($key); ?>'><?php echo $value; ?></option><?php
                                    }
                                }
                                ?>                                  
						</select> <span class="description"><?php _e('Default', 'woo_cp');?> <code><?php _e( 'Tahoma', 'woo_cp' ); ?></code></span>
					</td>
				</tr>
                <tr>
                    <th class="titledesc" scope="row"><label for="no_product_message_font_size"><?php _e('Font Size', 'woo_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="no_product_message_font_size" name="woo_compare_page_style[no_product_message_font_size]">
                        <option value="" selected="selected"><?php _e('Select Size', 'woo_cp');?></option>
                        <?php
                        for( $i = 9 ; $i <= 40 ; $i++ ){
                            if( $no_product_message_font_size ==  $i.'px' ){
                            ?>
                                <option value='<?php echo ($i); ?>px' selected='selected'><?php echo $i; ?>px</option>
                            <?php }else{ ?>
                                <option value='<?php echo ($i); ?>px'><?php echo $i; ?>px</option>
                            <?php
                            }
                        }
                        ?>                                  
                        </select> <span class="description"><?php _e('Default', 'woo_cp');?> <code><?php echo $default_settings['no_product_message_font_size']; ?></code></span>
                    </td>
		  		</tr>
          		<tr>
                    <th class="titledesc" scope="row"><label for="no_product_message_font_style"><?php _e('Font Style', 'woo_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="no_product_message_font_style" name="woo_compare_page_style[no_product_message_font_style]">
                          <option value="" selected="selected"><?php _e('Select Style', 'woo_cp');?></option>
                          <option <?php if( $no_product_message_font_style == 'normal'){ echo 'selected="selected" ';} ?>value="normal"><?php _e('Normal', 'woo_cp');?></option>
                          <option <?php if( $no_product_message_font_style == 'italic'){ echo 'selected="selected" ';} ?>value="italic"><?php _e('Italic', 'woo_cp');?></option>
                          <option <?php if( $no_product_message_font_style == 'bold'){ echo 'selected="selected" ';} ?>value="bold"><?php _e('Bold', 'woo_cp');?></option>
                          <option <?php if( $no_product_message_font_style == 'bold_italic'){ echo 'selected="selected" ';} ?>value="bold_italic"><?php _e('Bold/Italic', 'woo_cp');?></option>
                        </select> <span class="description"><?php _e('Default', 'woo_cp');?> <code><?php _e('Normal', 'woo_cp');?></code></span>
                    </td>
				</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="no_product_message_font_colour"><?php _e('Font Colour','woo_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" name="woo_compare_page_style[no_product_message_font_colour]" id="no_product_message_font_colour" value="<?php esc_attr_e( stripslashes( $no_product_message_font_colour ) );?>" style="width:120px;" /> <span class="description"><?php _e('Default', 'woo_cp');?> <code><?php echo $default_settings['no_product_message_font_colour'] ?></code></span>
            			<div id="colorPickerDiv_no_product_message_font_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
			</tbody>
		</table>
	<?php
	}
}
?>