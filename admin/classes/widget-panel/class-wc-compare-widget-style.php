<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WooCommerce Compare Widget Style Class
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 *
 */
class WC_Compare_Widget_Style{
	function get_settings_default() {
		$default_settings = array(
			'widget_text'					=> __('You do not have any product to compare.', 'woo_cp'),
			'text_font'						=> '',
			'text_font_size'				=> '',
			'text_font_style'				=> '',
			'text_font_colour'				=> '',
		);
		
		return $default_settings;
	}
	
	function set_settings_default($reset=false) {
		
		$default_settings = WC_Compare_Widget_Style::get_settings_default();
				
		if ($reset) {
			update_option('woo_compare_widget_style', $default_settings);
			update_option('woo_compare_basket_icon', '');
		} else {
			update_option('woo_compare_widget_style', $default_settings);
			update_option('woo_compare_basket_icon', '');
		}	
	}
	
	function get_settings() {
		global $woo_compare_widget_style;
		$woo_compare_widget_style = WC_Compare_Widget_Style::get_settings_default();
		
		return $woo_compare_widget_style;
	}
		
	function panel_page() {
		$message = '';
		if (isset($_REQUEST['bt_save_settings'])) {
			WC_Compare_Widget_Style::set_settings_default(true);
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			WC_Compare_Widget_Style::set_settings_default(true);
		}
		
		$woo_compare_widget_style = $default_settings = WC_Compare_Widget_Style::get_settings_default();
		
		extract($woo_compare_widget_style);
		$fonts = WC_Compare_Functions::get_font();
		
		?>
        <h3><?php _e('Remove Single Item Icon', 'woo_cp'); ?></h3>
		<table cellspacing="0" class="form-table">
			<tbody>
            	<tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="woo_compare_basket_icon"><?php _e('Remove from widget Icon','woo_cp'); ?></label></th>
                    <td class="forminp">
                    	<?php echo WC_Compare_Uploader::upload_input('woo_compare_basket_icon', __('Basket Icon', 'woo_cp'), '', '<img class="help_tip" tip="'.__('Upload a 10px x 10px image, support .jpg, .pgn, .jpeg, .gif formats.', 'woo_cp').'" src="'.WOOCP_IMAGES_URL.'/help.png" />' ); ?>
                    </td>
               	</tr>
			</tbody>
		</table>
        
        <h3><?php _e('Widget "Nothing to Compare Text"', 'woo_cp'); ?></h3>
		<table cellspacing="0" class="form-table">
			<tbody>
            	<tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="compare_widget_text"><?php _e('Nothing to Compare Text','woo_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" value="<?php esc_attr_e( stripslashes( $widget_text ) );?>" style="width:300px;" id="compare_widget_text" name="woo_compare_widget_style[widget_text]" /> <span class="description"><?php _e('For default', 'woo_cp');?> <code>'<?php echo $default_settings['widget_text']; ?>'</code> <?php _e('or enter text', 'woo_cp');?></span>
                    </td>
               	</tr>
				<tr>
					<th class="titledesc" scope="row"><label for="compare_widget_text_font"><?php _e('Font', 'woo_cp');?></label></th>
					<td class="forminp">
						<select class="chzn-select" style="width:120px;" id="compare_widget_text_font" name="woo_compare_widget_style[text_font]">
							<option value="" selected="selected"><?php _e('Select Font', 'woo_cp');?></option>
								<?php
                                foreach($fonts as $key=>$value){
                                    if( htmlspecialchars( $text_font ) ==  htmlspecialchars($key) ){
                                        ?><option value='<?php echo htmlspecialchars($key); ?>' selected='selected'><?php echo $value; ?></option><?php
                                    }else{
                                        ?><option value='<?php echo htmlspecialchars($key); ?>'><?php echo $value; ?></option><?php
                                    }
                                }
                                ?>                                  
						</select> <span class="description"><?php _e('&lt;empty&gt; to use theme style', 'woo_cp');?></span>
					</td>
				</tr>
                <tr>
                    <th class="titledesc" scope="row"><label for="compare_widget_text_font_size"><?php _e('Font Size', 'woo_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="compare_widget_text_font_size" name="woo_compare_widget_style[text_font_size]">
                        <option value="" selected="selected"><?php _e('Select Size', 'woo_cp');?></option>
                        <?php
                        for( $i = 9 ; $i <= 40 ; $i++ ){
                            if( $text_font_size ==  $i.'px' ){
                            ?>
                                <option value='<?php echo ($i); ?>px' selected='selected'><?php echo $i; ?>px</option>
                            <?php }else{ ?>
                                <option value='<?php echo ($i); ?>px'><?php echo $i; ?>px</option>
                            <?php
                            }
                        }
                        ?>                                  
                        </select> <span class="description"><?php _e('&lt;empty&gt; to use theme style', 'woo_cp');?></span>
                    </td>
		  		</tr>
          		<tr>
                    <th class="titledesc" scope="row"><label for="compare_widget_text_font_style"><?php _e('Font Style', 'woo_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="compare_widget_text_font_style" name="woo_compare_widget_style[text_font_style]">
                          <option value="" selected="selected"><?php _e('Select Style', 'woo_cp');?></option>
                          <option <?php if( $text_font_style == 'normal'){ echo 'selected="selected" ';} ?>value="normal"><?php _e('Normal', 'woo_cp');?></option>
                          <option <?php if( $text_font_style == 'italic'){ echo 'selected="selected" ';} ?>value="italic"><?php _e('Italic', 'woo_cp');?></option>
                          <option <?php if( $text_font_style == 'bold'){ echo 'selected="selected" ';} ?>value="bold"><?php _e('Bold', 'woo_cp');?></option>
                          <option <?php if( $text_font_style == 'bold_italic'){ echo 'selected="selected" ';} ?>value="bold_italic"><?php _e('Bold/Italic', 'woo_cp');?></option>
                        </select> <span class="description"><?php _e('&lt;empty&gt; to use theme style', 'woo_cp');?></span>
                    </td>
				</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="compare_widget_text_font_colour"><?php _e('Font Colour','woo_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" name="woo_compare_widget_style[text_font_colour]" id="compare_widget_text_font_colour" value="<?php esc_attr_e( stripslashes( $text_font_colour ) );?>" style="width:120px;" /> <span class="description"><?php _e('&lt;empty&gt; to use theme style', 'woo_cp');?></span>
            			<div id="colorPickerDiv_compare_widget_text_font_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
			</tbody>
		</table>
	<?php
	}
}
?>