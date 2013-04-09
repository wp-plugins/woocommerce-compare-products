<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WooCommerce Compare Grid View Button Style Class
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 *
 */
class WC_Compare_Grid_View_Button_Style{
	function get_settings_default() {
		$default_settings = array(
			'grid_view_button_type'			=> 'button',
			
			'button_text'					=> __('Compare This', 'woo_cp'),
			'button_bg_colour'				=> '#476381',
			'button_bg_colour_from'			=> '#538bbc',
			'button_bg_colour_to'			=> '#476381',
			
			'button_border_size'			=> '1px',
			'button_border_style'			=> 'solid',
			'button_border_colour'			=> '#476381',
			'button_border_rounded'			=> 'rounded',
			'button_border_rounded_value'	=> 3,
			
			'button_font'					=> '',
			'button_font_size'				=> '',
			'button_font_style'				=> '',
			'button_font_colour'			=> '#FFFFFF',
			'button_class'					=> '',
			
			'link_text'						=> __('Compare This', 'woo_cp'),
			'link_font'						=> '',
			'link_font_size'				=> '',
			'link_font_style'				=> '',
			'link_font_colour'				=> '',
			'link_font_hover_colour'		=> '',
		);
		
		return $default_settings;
	}
	
	function set_settings_default($reset=false) {
		
		$default_settings = WC_Compare_Grid_View_Button_Style::get_settings_default();
				
		if ($reset) {
			update_option('woo_compare_grid_view_button_style', $default_settings);
			update_option('woo_compare_gridview_product_success_icon', '');
		} else {
			update_option('woo_compare_grid_view_button_style', $default_settings);
			update_option('woo_compare_gridview_product_success_icon', '');
		}
				
	}
	
	function get_settings() {
		global $woo_compare_grid_view_button_style;
		$woo_compare_grid_view_button_style = WC_Compare_Grid_View_Button_Style::get_settings_default();
		
		return $woo_compare_grid_view_button_style;
	}
		
	function panel_page() {
		$message = '';
		if (isset($_REQUEST['bt_save_settings'])) {
			WC_Compare_Grid_View_Button_Style::set_settings_default(true);
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			WC_Compare_Grid_View_Button_Style::set_settings_default(true);
		}
		
		$woo_compare_grid_view_button_style = $default_settings = WC_Compare_Grid_View_Button_Style::get_settings_default();
		
		extract($woo_compare_grid_view_button_style);
		$fonts = WC_Compare_Functions::get_font();
		
		?>
        <script type="text/javascript">
			(function($){		
				$(function(){	
					$('.grid_view_button_type').click(function(){
						if ($("input[name='woo_compare_grid_view_button_style[grid_view_button_type]']:checked").val() == 'link') {
							$(".grid_view_compare_link_styling").show();
							$(".grid_view_compare_button_styling").hide();
						} else {
							$(".grid_view_compare_link_styling").hide();
							$(".grid_view_compare_button_styling").show();
						}
					});
				});		  
			})(jQuery);
		</script>
        <h3><?php _e('Settings', 'woo_cp'); ?></h3>
        <table cellspacing="0" class="form-table">
			<tbody>
            	<tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="grid_view_button_type1"><?php _e('Button or Text', 'woo_cp'); ?></label></th>
                    <td class="forminp"><label><input type="radio" class="grid_view_button_type" name="woo_compare_grid_view_button_style[grid_view_button_type]" id="grid_view_button_type1" value="button" checked="checked" /> <?php _e('Button', 'woo_cp'); ?></label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <label><input type="radio" class="grid_view_button_type" name="woo_compare_grid_view_button_style[grid_view_button_type]" id="grid_view_button_type2" value="link" <?php if ($grid_view_button_type == 'link') { echo 'checked="checked"';} ?> /> <?php _e('Linked Text', 'woo_cp'); ?></label> 
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="woo_compare_gridview_product_success_icon"><?php _e('Compare Success Icon', 'woo_cp'); ?></label></th>
                    <td class="forminp"><?php echo WC_Compare_Uploader::upload_input('woo_compare_gridview_product_success_icon', __('Compare Product Success', 'woo_cp'), '', '<img class="help_tip" tip="'.__('Upload a 16px x 16px image, support .jpg, .pgn, .jpeg, .gif formats.', 'woo_cp').'" src="'.WOOCP_IMAGES_URL.'/help.png" />' ); ?></td>
               	</tr>
            </tbody>
        </table>
        
        <h3 class="grid_view_compare_button_styling" style=" <?php if($grid_view_button_type == 'link') { echo 'display:none'; } ?>"><?php _e('Grid View Compare Button Styling', 'woo_cp'); ?></h3>
        <table cellspacing="0" class="form-table grid_view_compare_button_styling" style=" <?php if($grid_view_button_type == 'link') { echo 'display:none'; } ?>">
			<tbody>
            	<tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="grid_view_button_text"><?php _e('Button Text','woo_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" value="<?php esc_attr_e( stripslashes( $button_text ) );?>" style="width:300px;" id="grid_view_button_text" name="woo_compare_grid_view_button_style[button_text]" /> <span class="description"><?php _e('For default', 'woo_cp');?> <code>'<?php echo $default_settings['button_text']; ?>'</code> <?php _e('or enter text', 'woo_cp');?></span>
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="grid_view_button_bg_colour"><?php _e('Background Colour','woo_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" value="<?php esc_attr_e( stripslashes( $button_bg_colour ) );?>" style="width:120px;" id="grid_view_button_bg_colour" name="woo_compare_grid_view_button_style[button_bg_colour]" /> <span class="description"><?php _e('Button colour. Default', 'woo_cp');?> <code><?php echo $default_settings['button_bg_colour']; ?></code></span>
            			<div id="colorPickerDiv_grid_view_button_bg_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="grid_view_button_bg_colour_from"><?php _e('Background Colour Gradient From','woo_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" value="<?php esc_attr_e( stripslashes( $button_bg_colour_from ) );?>" style="width:120px;" id="grid_view_button_bg_colour_from" name="woo_compare_grid_view_button_style[button_bg_colour_from]" /> <span class="description"><?php _e('Default', 'woo_cp');?> <code><?php echo $default_settings['button_bg_colour_from']; ?></code></span>
            			<div id="colorPickerDiv_grid_view_button_bg_colour_from" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="grid_view_button_bg_colour_to"><?php _e('Background Colour Gradient To','woo_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" value="<?php esc_attr_e( stripslashes( $button_bg_colour_to ) );?>" style="width:120px;" id="grid_view_button_bg_colour_to" name="woo_compare_grid_view_button_style[button_bg_colour_to]" /> <span class="description"><?php _e('Default', 'woo_cp');?> <code><?php echo $default_settings['button_bg_colour_to']; ?></code></span>
            			<div id="colorPickerDiv_grid_view_button_bg_colour_to" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
                <tr valign="top">
					<th class="titledesc" scope="rpw"><label for="grid_view_button_border_size"><?php _e('Border Size','woo_cp'); ?></label></th>
					<td class="forminp">
						<select class="chzn-select" style="width:120px;" id="grid_view_button_border_size" name="woo_compare_grid_view_button_style[button_border_size]">
							<option value="" selected="selected"><?php _e('Select Size', 'woo_cp');?></option>
                                <?php
                                for( $i = 0 ; $i <= 10 ; $i++ ){
                                    if( $button_border_size ==  $i.'px' ){
                                    ?>
                                        <option value='<?php echo ($i); ?>px' selected='selected'><?php echo $i; ?>px</option>
                                    <?php }else{ ?>
                                        <option value='<?php echo ($i); ?>px'><?php echo $i; ?>px</option>
                                    <?php
                                    }
                                }
                                ?>                                  
						</select> <span class="description"><?php _e('Default', 'woo_cp');?> <code><?php echo $default_settings['button_border_size'] ?></code></span>
					</td>
				</tr>
				<tr>
					<th class="titledesc" scope="row"><label for="grid_view_button_border_style"><?php _e('Border Style', 'woo_cp');?></label></th>
					<td class="forminp">
						<select class="chzn-select" style="width:120px;" id="grid_view_button_border_style" name="woo_compare_grid_view_button_style[button_border_style]">
                                  <option selected="selected" value="solid"><?php _e('Solid', 'woo_cp');?></option>
                                  <option <?php if( $button_border_style == 'double'){ echo 'selected="selected" ';} ?>value="double"><?php _e('Double', 'woo_cp');?></option>
                                  <option <?php if( $button_border_style == 'dashed'){ echo 'selected="selected" ';} ?>value="dashed"><?php _e('Dashed', 'woo_cp');?></option>
                                  <option <?php if( $button_border_style == 'dotted'){ echo 'selected="selected" ';} ?>value="dotted"><?php _e('Dotted', 'woo_cp');?></option>
						</select> <span class="description"><?php _e('Default', 'woo_cp');?> <code><?php _e('Solid', 'woo_cp');?></code></span>
					</td>
				</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="grid_view_button_border_colour"><?php _e('Border Colour','woo_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" value="<?php esc_attr_e( stripslashes( $button_border_colour ) );?>" style="width:120px;" id="grid_view_button_border_colour" name="woo_compare_grid_view_button_style[button_border_colour]" /> <span class="description"><?php _e('Border colour. Default', 'woo_cp');?> <code><?php echo $default_settings['button_border_colour']; ?></code></span>
            			<div id="colorPickerDiv_grid_view_button_border_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="grid_view_button_rounded_corner"><?php _e('Border Rounded','woo_cp'); ?></label></th>
                    <td class="forminp">
                    <input type="radio" name="woo_compare_grid_view_button_style[button_border_rounded]" value="rounded" id="grid_view_button_rounded_corner" checked="checked" /> <label for="grid_view_button_rounded_corner"><?php _e('Rounded Corners','woo_cp'); ?></label> <span class="description">(<?php _e('Default', 'woo_cp');?>)</span> &nbsp;&nbsp;&nbsp;&nbsp;
                    <label><?php _e('Rounded Value','woo_cp'); ?></label> <input type="text" name="woo_compare_grid_view_button_style[button_border_rounded_value]" value="<?php esc_attr_e( stripslashes( $button_border_rounded_value) );?>" style="width:120px;" />px <span class="description"><?php _e('Default', 'woo_cp');?> <code><?php echo $default_settings['button_border_rounded_value']; ?></code>px</span>
                    <br />
                    <input type="radio" name="woo_compare_grid_view_button_style[button_border_rounded]" value="square" id="grid_view_button_square_corner" <?php if($button_border_rounded == 'square'){ echo 'checked="checked"'; } ?> /> <label for="grid_view_button_square_corner"><?php _e('Square Corners','woo_cp'); ?></label>
                    </td>
               	</tr>
                <tr>
					<th class="titledesc" scope="row"><label for="grid_view_button_font"><?php _e('Font', 'woo_cp');?></label></th>
					<td class="forminp">
						<select class="chzn-select" style="width:120px;" id="grid_view_button_font" name="woo_compare_grid_view_button_style[button_font]">
							<option value="" selected="selected"><?php _e('Select Font', 'woo_cp');?></option>
								<?php
                                foreach($fonts as $key=>$value){
                                    if( htmlspecialchars( $button_font ) ==  htmlspecialchars($key) ){
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
                    <th class="titledesc" scope="row"><label for="grid_view_button_font_size"><?php _e('Button Font Size', 'woo_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="grid_view_button_font_size" name="woo_compare_grid_view_button_style[button_font_size]">
                        <option value="" selected="selected"><?php _e('Select Size', 'woo_cp');?></option>
                        <?php
                        for( $i = 9 ; $i <= 40 ; $i++ ){
                            if( $button_font_size ==  $i.'px' ){
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
                    <th class="titledesc" scope="row"><label for="grid_view_button_font_style"><?php _e('Button Font Style', 'woo_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="grid_view_button_font_style" name="woo_compare_grid_view_button_style[button_font_style]">
                          <option value="" selected="selected"><?php _e('Select Style', 'woo_cp');?></option>
                          <option <?php if( $button_font_style == 'normal'){ echo 'selected="selected" ';} ?>value="normal"><?php _e('Normal', 'woo_cp');?></option>
                          <option <?php if( $button_font_style == 'italic'){ echo 'selected="selected" ';} ?>value="italic"><?php _e('Italic', 'woo_cp');?></option>
                          <option <?php if( $button_font_style == 'bold'){ echo 'selected="selected" ';} ?>value="bold"><?php _e('Bold', 'woo_cp');?></option>
                          <option <?php if( $button_font_style == 'bold_italic'){ echo 'selected="selected" ';} ?>value="bold_italic"><?php _e('Bold/Italic', 'woo_cp');?></option>
                        </select> <span class="description"><?php _e('&lt;empty&gt; to use theme style', 'woo_cp');?></span>
                    </td>
				</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="grid_view_button_font_colour"><?php _e('Button Font Colour','woo_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" name="woo_compare_grid_view_button_style[button_font_colour]" id="grid_view_button_font_colour" value="<?php esc_attr_e( stripslashes( $button_font_colour ) );?>" style="width:120px;" /> <span class="description"><?php _e('Default', 'woo_cp');?> <code><?php echo $default_settings['button_font_colour'] ?></code></span>
            			<div id="colorPickerDiv_grid_view_button_font_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="grid_view_button_class"><?php _e('CSS Class','woo_cp'); ?></label></th>
                    <td class="forminp"><input type="text" name="woo_compare_grid_view_button_style[button_class]" id="grid_view_button_class" value="<?php esc_attr_e( stripslashes( $button_class ) );?>" style="min-width:300px" /> <span class="description"><?php _e("Enter your own button CSS class", 'woo_cp'); ?></span>
                    </td>
               	</tr>
			</tbody>
		</table>
        
        <h3 class="grid_view_compare_link_styling" style=" <?php if($grid_view_button_type != 'link') { echo 'display:none'; } ?>"><?php _e('Grid View Compare Linked Text Styling', 'woo_cp'); ?></h3>
        <table cellspacing="0" class="form-table grid_view_compare_link_styling" style=" <?php if($grid_view_button_type != 'link') { echo 'display:none'; } ?>">
			<tbody>
            	<tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="grid_view_compare_link_text"><?php _e('Compare Link Text','woo_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" value="<?php esc_attr_e( stripslashes( $link_text ) );?>" style="width:300px;" id="grid_view_compare_link_text" name="woo_compare_grid_view_button_style[link_text]" /> <span class="description"><?php _e('For default', 'woo_cp');?> <code>'<?php echo $default_settings['link_text']; ?>'</code> <?php _e('or enter text', 'woo_cp');?></span>
                    </td>
               	</tr>
                <tr>
					<th class="titledesc" scope="row"><label for="grid_view_compare_link_font"><?php _e('Link Text Font', 'woo_cp');?></label></th>
					<td class="forminp">
						<select class="chzn-select" style="width:120px;" id="grid_view_compare_link_font" name="woo_compare_grid_view_button_style[link_font]">
							<option value="" selected="selected"><?php _e('Select Font', 'woo_cp');?></option>
								<?php
                                foreach($fonts as $key=>$value){
                                    if( htmlspecialchars( $link_font ) ==  htmlspecialchars($key) ){
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
                    <th class="titledesc" scope="row"><label for="grid_view_compare_link_font_size"><?php _e('Link Text Font Size', 'woo_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="grid_view_compare_link_font_size" name="woo_compare_grid_view_button_style[link_font_size]">
                        <option value="" selected="selected"><?php _e('Select Size', 'woo_cp');?></option>
                        <?php
                        for( $i = 9 ; $i <= 40 ; $i++ ){
                            if( $link_font_size ==  $i.'px' ){
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
                    <th class="titledesc" scope="row"><label for="grid_view_compare_link_font_style"><?php _e('Link Text Font Style', 'woo_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="grid_view_compare_link_font_style" name="woo_compare_grid_view_button_style[link_font_style]">
                          <option value="" selected="selected"><?php _e('Select Style', 'woo_cp');?></option>
                          <option <?php if( $link_font_style == 'normal'){ echo 'selected="selected" ';} ?>value="normal"><?php _e('Normal', 'woo_cp');?></option>
                          <option <?php if( $link_font_style == 'italic'){ echo 'selected="selected" ';} ?>value="italic"><?php _e('Italic', 'woo_cp');?></option>
                          <option <?php if( $link_font_style == 'bold'){ echo 'selected="selected" ';} ?>value="bold"><?php _e('Bold', 'woo_cp');?></option>
                          <option <?php if( $link_font_style == 'bold_italic'){ echo 'selected="selected" ';} ?>value="bold_italic"><?php _e('Bold/Italic', 'woo_cp');?></option>
                        </select> <span class="description"><?php _e('&lt;empty&gt; to use theme style', 'woo_cp');?></span>
                    </td>
				</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="grid_view_compare_link_font_colour"><?php _e('Link Text Font Colour','woo_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" name="woo_compare_grid_view_button_style[link_font_colour]" id="grid_view_compare_link_font_colour" value="<?php esc_attr_e( stripslashes( $link_font_colour ) );?>" style="width:120px;" /> <span class="description"><?php _e('&lt;empty&gt; to use theme style', 'woo_cp');?></span>
            			<div id="colorPickerDiv_grid_view_compare_link_font_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="grid_view_compare_link_font_hover_colour"><?php _e('Link Text Font Hover Colour','woo_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" name="woo_compare_grid_view_button_style[link_font_hover_colour]" id="grid_view_compare_link_font_hover_colour" value="<?php esc_attr_e( stripslashes( $link_font_hover_colour ) );?>" style="width:120px;" /> <span class="description"><?php _e('&lt;empty&gt; to use theme style', 'woo_cp');?></span>
            			<div id="colorPickerDiv_grid_view_compare_link_font_hover_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
			</tbody>
		</table>
	<?php
	}
}
?>