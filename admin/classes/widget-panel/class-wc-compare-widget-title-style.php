<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WooCommerce Compare Widget Title Style Class
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 *
 */
class WC_Compare_Widget_Title_Style
{
	public static function get_settings_default() {
		$default_settings = array(
			'enable_widget_title_customized'=> 0,
			'widget_title_font'				=> '',
			'widget_title_font_size'		=> '',
			'widget_title_font_style'		=> '',
			'widget_title_font_colour'		=> '',
			'widget_title_align'			=> 'left',
			'widget_title_wide'				=> 'auto',
			'widget_title_padding_topbottom'=> 5,
			'widget_title_padding_leftright'=> 5,
			'widget_title_margin_top'		=> 0,
			'widget_title_margin_bottom'	=> 10,
			'widget_title_bg_colour'		=> '',
			'widget_title_border_size_top'	=> '0px',
			'widget_title_border_size_bottom' => '0px',
			'widget_title_border_size_left'	=> '0px',
			'widget_title_border_size_right'=> '0px',
			'widget_title_border_style'		=> 'solid',
			'widget_title_border_colour'	=> '',
			'widget_title_border_rounded'	=> 'square',
			'widget_title_border_rounded_value' => 10,
			
			'before_total_text'				=> '(',
			'after_total_text'				=> ')',
			'total_font'					=> '',
			'total_font_size'				=> '',
			'total_font_style'				=> '',
			'total_font_colour'				=> '',
		);
		
		return $default_settings;
	}
	
	public static function set_settings_default($reset=false) {
		
		$default_settings = WC_Compare_Widget_Title_Style::get_settings_default();
				
		if ($reset) {
			update_option('woo_compare_widget_title_style', $default_settings);
		} else {
			update_option('woo_compare_widget_title_style', $default_settings);
		}	
	}
	
	public static function get_settings() {
		global $woo_compare_widget_title_style;
		$woo_compare_widget_title_style = WC_Compare_Widget_Title_Style::get_settings_default();
		
		return $woo_compare_widget_title_style;
	}
		
	public static function panel_page() {
		$message = '';
		if (isset($_REQUEST['bt_save_settings'])) {
			WC_Compare_Widget_Title_Style::set_settings_default(true);
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			WC_Compare_Widget_Title_Style::set_settings_default(true);
		}
		
		$woo_compare_widget_title_style = $default_settings = WC_Compare_Widget_Title_Style::get_settings_default();
		
		extract($woo_compare_widget_title_style);
		$fonts = WC_Compare_Functions::get_font();
		
		?>
        <script type="text/javascript">
			(function($){		
				$(function(){	
					$('.enable_widget_title_customized').click(function(){
						if ($("input[name='woo_compare_widget_title_style[enable_widget_title_customized]']:checked").val() == 1) {
							$("#enable_widget_title_customized").show();
						} else {
							$("#enable_widget_title_customized").hide();
						}
					});
				});		  
			})(jQuery);
		</script>
        <h3><?php _e("Widget Title Setup", 'woo_cp'); ?></h3>
        <p class=""><?php _e("Custom settings below apply style to the 'Title' you add on the Woo Compare Widget.", 'woo_cp'); ?></p>
		<table cellspacing="0" class="form-table">
			<tbody>
            	<tr valign="top">
					<th class="titledesc" scope="rpw"><label><?php _e('Widget Title Style','woo_cp'); ?></label></th>
                    <td class="forminp">
                    	<div><label><input type="radio" class="enable_widget_title_customized" name="woo_compare_widget_title_style[enable_widget_title_customized]" value="0" checked="checked" /> <?php _e('Use Default Theme Style for Widget Title','woo_cp'); ?></label> <span class="description">(<?php _e('default', 'woo_cp');?>)</span></div>
                    	<div><label><input type="radio" class="enable_widget_title_customized" name="woo_compare_widget_title_style[enable_widget_title_customized]" value="1" <?php if ( $enable_widget_title_customized == 1) { echo 'checked="checked"';} ?> /> <?php _e('Customized Style for Widget Title','woo_cp'); ?></label></div>
                    </td>
                </tr>                
			</tbody>
		</table>
        
        <table cellspacing="0" class="form-table" id="enable_widget_title_customized" style=" <?php if($enable_widget_title_customized != 1) { echo 'display:none'; } ?>">
			<tbody>
				<tr>
					<th class="titledesc" scope="row"><label for="widget_title_font"><?php _e('Widget Title Text Font', 'woo_cp');?></label></th>
					<td class="forminp">
						<select class="chzn-select" style="width:120px;" id="widget_title_font" name="woo_compare_widget_title_style[widget_title_font]">
							<option value="" selected="selected"><?php _e('Select Font', 'woo_cp');?></option>
								<?php
                                foreach($fonts as $key=>$value){
									var_dump(htmlspecialchars( $widget_title_font )).' - '.var_dump(htmlspecialchars( $key )).'<br/>';
                                    if( htmlspecialchars( $widget_title_font ) ==  htmlspecialchars($key) ){
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
                    <th class="titledesc" scope="row"><label for="widget_title_font_size"><?php _e('Widget Title Text Font Size', 'woo_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="widget_title_font_size" name="woo_compare_widget_title_style[widget_title_font_size]">
                        <option value="" selected="selected"><?php _e('Select Size', 'woo_cp');?></option>
                        <?php
                        for( $i = 9 ; $i <= 40 ; $i++ ){
                            if( $widget_title_font_size ==  $i.'px' ){
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
                    <th class="titledesc" scope="row"><label for="widget_title_font_style"><?php _e('Widget Title Text Font Style', 'woo_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="widget_title_font_style" name="woo_compare_widget_title_style[widget_title_font_style]">
                          <option value="" selected="selected"><?php _e('Select Style', 'woo_cp');?></option>
                          <option <?php if( $widget_title_font_style == 'normal'){ echo 'selected="selected" ';} ?>value="normal"><?php _e('Normal', 'woo_cp');?></option>
                          <option <?php if( $widget_title_font_style == 'italic'){ echo 'selected="selected" ';} ?>value="italic"><?php _e('Italic', 'woo_cp');?></option>
                          <option <?php if( $widget_title_font_style == 'bold'){ echo 'selected="selected" ';} ?>value="bold"><?php _e('Bold', 'woo_cp');?></option>
                          <option <?php if( $widget_title_font_style == 'bold_italic'){ echo 'selected="selected" ';} ?>value="bold_italic"><?php _e('Bold/Italic', 'woo_cp');?></option>
                        </select> <span class="description"><?php _e('Default', 'woo_cp');?> <code><?php _e('Bold', 'woo_cp');?></code></span>
                    </td>
				</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="widget_title_font_colour"><?php _e('Widget Title Text Font Colour','woo_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" name="woo_compare_widget_title_style[widget_title_font_colour]" id="widget_title_font_colour" value="<?php esc_attr_e( stripslashes( $widget_title_font_colour ) );?>" style="width:120px;" /> <span class="description"><?php _e('&lt;empty&gt; to use theme style', 'woo_cp');?></span>
            			<div id="colorPickerDiv_widget_title_font_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="widget_title_align"><?php _e('Widget Title Container Align','woo_cp'); ?></label></th>
                    <td class="forminp">
						<select class="chzn-select" style="width:120px;" id="widget_title_align" name="woo_compare_widget_title_style[widget_title_align]">
                        	<option selected="selected" value="left"><?php _e('Left', 'woo_cp');?></option>
                            <option <?php if( $widget_title_align == 'center'){ echo 'selected="selected" ';} ?>value="center"><?php _e('Center', 'woo_cp');?></option>
                            <option <?php if( $widget_title_align == 'right'){ echo 'selected="selected" ';} ?>value="right"><?php _e('Right', 'woo_cp');?></option>
						</select> <span class="description"><?php _e('Default', 'woo_cp');?> <code><?php _e('Left', 'woo_cp');?></code></span>
					</td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="widget_title_wide"><?php _e('Widget Title Container Wide','woo_cp'); ?></label></th>
                    <td class="forminp">
						<select class="chzn-select" style="width:120px;" id="widget_title_wide" name="woo_compare_widget_title_style[widget_title_wide]">
                        	<option selected="selected" value="auto"><?php _e('Auto', 'woo_cp');?></option>
                            <option <?php if( $widget_title_wide == 'full'){ echo 'selected="selected" ';} ?>value="full"><?php _e('Full', 'woo_cp');?></option>
						</select> <span class="description"><?php _e('Default', 'woo_cp');?> <code><?php _e('Auto', 'woo_cp');?></code></span>
					</td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for=""><?php _e('Widget Title Container Padding','woo_cp'); ?></label></th>
                    <td class="forminp">
						<div style="float:left; width:120px;"><label id="widget_title_padding_topbottom"><?php _e('Padding Top/Bottom','woo_cp'); ?></label></div><input type="text" name="woo_compare_widget_title_style[widget_title_padding_topbottom]" id="widget_title_padding_topbottom" value="<?php esc_attr_e( stripslashes( $widget_title_padding_topbottom ) ); ?>" size="3" /> px
                        <div style="clear:both;"></div>
                        <div style="float:left; width:120px;"><label for="widget_title_padding_leftright"><?php _e('Padding Left/Right','woo_cp'); ?></label></div><input type="text" name="woo_compare_widget_title_style[widget_title_padding_leftright]" id="widget_title_padding_leftright" value="<?php esc_attr_e( stripslashes( $widget_title_padding_leftright ) ); ?>" size="3" /> px
                        <div style="clear:both;"></div>
					</td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="widget_title_margin_top"><?php _e('Widget Title Container Margin','woo_cp'); ?></label></th>
                    <td class="forminp">
						<div style="float:left; width:120px;"><label><?php _e('Margin Top','woo_cp'); ?></label></div><input type="text" name="woo_compare_widget_title_style[widget_title_margin_top]" id="widget_title_margin_top" value="<?php esc_attr_e( stripslashes( $widget_title_margin_top ) ); ?>" size="3" /> px
                        <div style="clear:both;"></div>
                        <div style="float:left; width:120px;"><label for="widget_title_margin_bottom"><?php _e('Margin Bottom','woo_cp'); ?></label></div><input type="text" name="woo_compare_widget_title_style[widget_title_margin_bottom]" id="widget_title_margin_bottom" value="<?php esc_attr_e( stripslashes( $widget_title_margin_bottom ) ); ?>" size="3" /> px
                        <div style="clear:both;"></div>
					</td>
               	</tr>
                <tr valign="top">
					<th class="titledesc" scope="rpw"><label for="widget_title_bg_colour"><?php _e('Widget Title Container Background Colour','woo_cp'); ?></label></th>
					<td class="forminp">
						<input type="text" class="colorpick" name="woo_compare_widget_title_style[widget_title_bg_colour]" id="widget_title_bg_colour" value="<?php esc_attr_e(stripslashes( $widget_title_bg_colour ) );?>" style="width:120px;" />
						<div id="colorPickerDiv_widget_title_bg_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
					</td>
				</tr>
                <tr valign="top">
					<th class="titledesc" scope="rpw"><label for="widget_title_border_size_top"><?php _e('Widget Title Container Border Size','woo_cp'); ?></label></th>
					<td class="forminp">
						<div style="float:left; width:120px;"><label for="widget_title_border_size_top"><?php _e('Border Top','woo_cp'); ?></label></div>
                        <select class="chzn-select" style="width:120px;" id="widget_title_border_size_top" name="woo_compare_widget_title_style[widget_title_border_size_top]">
                                <option value="" selected="selected"><?php _e('Select Size', 'woo_cp');?></option>
                                <?php
                                for( $i = 0 ; $i <= 10 ; $i++ ){
                                    if( $widget_title_border_size_top ==  $i.'px' ){
                                    ?>
                                        <option value='<?php echo ($i); ?>px' selected='selected'><?php echo $i; ?>px</option>
                                    <?php }else{ ?>
                                        <option value='<?php echo ($i); ?>px'><?php echo $i; ?>px</option>
                                    <?php
                                    }
                                }
                                ?>                                  
						</select> <span class="description"><?php _e('Default', 'woo_cp');?> <code><?php echo $default_settings['widget_title_border_size_top'] ?></code></span>
                        <div style="clear:both;"></div>
                        <div style="float:left; width:120px;"><label for="widget_title_border_size_bottom"><?php _e('Border Bottom','woo_cp'); ?></label></div>
                        <select class="chzn-select" style="width:120px;" id="widget_title_border_size_bottom" name="woo_compare_widget_title_style[widget_title_border_size_bottom]">
                                <option value="" selected="selected"><?php _e('Select Size', 'woo_cp');?></option>
                                <?php
                                for( $i = 0 ; $i <= 10 ; $i++ ){
                                    if( $widget_title_border_size_bottom ==  $i.'px' ){
                                    ?>
                                        <option value='<?php echo ($i); ?>px' selected='selected'><?php echo $i; ?>px</option>
                                    <?php }else{ ?>
                                        <option value='<?php echo ($i); ?>px'><?php echo $i; ?>px</option>
                                    <?php
                                    }
                                }
                                ?>                                  
						</select> <span class="description"><?php _e('Default', 'woo_cp');?> <code><?php echo $default_settings['widget_title_border_size_bottom'] ?></code></span>
                        <div style="clear:both;"></div>
                        <div style="float:left; width:120px;"><label for="widget_title_border_size_left"><?php _e('Border Left','woo_cp'); ?></label></div>
                        <select class="chzn-select" style="width:120px;" id="widget_title_border_size_left" name="woo_compare_widget_title_style[widget_title_border_size_left]">
                                <option value="" selected="selected"><?php _e('Select Size', 'woo_cp');?></option>
                                <?php
                                for( $i = 0 ; $i <= 10 ; $i++ ){
                                    if( $widget_title_border_size_left ==  $i.'px' ){
                                    ?>
                                        <option value='<?php echo ($i); ?>px' selected='selected'><?php echo $i; ?>px</option>
                                    <?php }else{ ?>
                                        <option value='<?php echo ($i); ?>px'><?php echo $i; ?>px</option>
                                    <?php
                                    }
                                }
                                ?>                                  
						</select> <span class="description"><?php _e('Default', 'woo_cp');?> <code><?php echo $default_settings['widget_title_border_size_left'] ?></code></span>
                        <div style="clear:both;"></div>
                        <div style="float:left; width:120px;"><label for="widget_title_border_size_right"><?php _e('Border Right','woo_cp'); ?></label></div>
                        <select class="chzn-select" style="width:120px;" id="widget_title_border_size_right" name="woo_compare_widget_title_style[widget_title_border_size_right]">
                                <option value="" selected="selected"><?php _e('Select Size', 'woo_cp');?></option>
                                <?php
                                for( $i = 0 ; $i <= 10 ; $i++ ){
                                    if( $widget_title_border_size_right ==  $i.'px' ){
                                    ?>
                                        <option value='<?php echo ($i); ?>px' selected='selected'><?php echo $i; ?>px</option>
                                    <?php }else{ ?>
                                        <option value='<?php echo ($i); ?>px'><?php echo $i; ?>px</option>
                                    <?php
                                    }
                                }
                                ?>                                  
						</select> <span class="description"><?php _e('Default', 'woo_cp');?> <code><?php echo $default_settings['widget_title_border_size_right'] ?></code></span>
                        <div style="clear:both;"></div>
					</td>
				</tr>
				<tr>
					<th class="titledesc" scope="row"><label for="widget_title_border_style"><?php _e('Widget Title Container Border Style', 'woo_cp');?></label></th>
					<td class="forminp">
						<select class="chzn-select" style="width:120px;" id="widget_title_border_style" name="woo_compare_widget_title_style[widget_title_border_style]">
                                  <option selected="selected" value="solid"><?php _e('Solid', 'woo_cp');?></option>
                                  <option <?php if( $widget_title_border_style == 'double'){ echo 'selected="selected" ';} ?>value="double"><?php _e('Double', 'woo_cp');?></option>
                                  <option <?php if( $widget_title_border_style == 'dashed'){ echo 'selected="selected" ';} ?>value="dashed"><?php _e('Dashed', 'woo_cp');?></option>
                                  <option <?php if( $widget_title_border_style == 'dotted'){ echo 'selected="selected" ';} ?>value="dotted"><?php _e('Dotted', 'woo_cp');?></option>
                                </select> <span class="description"><?php _e('Default', 'woo_cp');?> <code><?php _e('Solid', 'woo_cp');?></code></span>
					</td>
				</tr>
				<tr valign="top">
					<th class="titledesc" scope="rpw"><label for="widget_title_border_colour"><?php _e('Widget Title Container Border Colour','woo_cp'); ?></label></th>
					<td class="forminp">
						<input type="text" class="colorpick" name="woo_compare_widget_title_style[widget_title_border_colour]" id="widget_title_border_colour" value="<?php esc_attr_e(stripslashes( $widget_title_border_colour ) );?>" style="width:120px;" />
						<div id="colorPickerDiv_widget_title_border_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
					</td>
				</tr>
				<tr valign="top">
					<th class="titledesc" scope="rpw"><label for=""><?php _e('Widget Title Container Border Rounded','woo_cp'); ?></label></th>
					<td class="forminp">
                            <label><input type="radio" name="woo_compare_widget_title_style[widget_title_border_rounded]" value="rounded" <?php if( $widget_title_border_rounded == 'rounded'){ echo 'checked="checked"'; } ?> /> <?php _e('Rounded Corners','woo_cp'); ?></label> &nbsp;&nbsp;&nbsp;&nbsp;
                            <label><?php _e('Rounded Value','woo_cp'); ?> <input type="text" name="woo_compare_widget_title_style[widget_title_border_rounded_value]" value="<?php esc_attr_e( stripslashes( $widget_title_border_rounded_value ) );?>" style="width:120px;" /></label>px <span class="description"><?php _e('Default', 'woo_cp');?> <code><?php echo $default_settings['widget_title_border_rounded_value']; ?></code>px</span>
                            <br />
                            <label><input type="radio" name="woo_compare_widget_title_style[widget_title_border_rounded]" value="square" id="square_cornes" <?php if( $widget_title_border_rounded != 'rounded'){ echo 'checked="checked"'; } ?> /> <?php _e('Square Corners','woo_cp'); ?></label> <span class="description">(<?php _e('Default', 'woo_cp');?>)</span>
					</td>
				</tr>
			</tbody>
		</table>
        
        <h3><?php _e('Comparable Products Counter (0)', 'woo_cp'); ?></h3>
        <table cellspacing="0" class="form-table">
			<tbody>
            	<tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="compare_widget_before_total_text"><?php _e('To show before number','woo_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" value="<?php esc_attr_e( stripslashes( $before_total_text ) );?>" style="width:120px;" id="compare_widget_before_total_text" name="woo_compare_widget_title_style[before_total_text]" /> <span class="description"><?php _e('default', 'woo_cp');?> <code>'<?php echo $default_settings['before_total_text']; ?>'</code> <?php _e('or enter text', 'woo_cp');?></span>
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="compare_widget_after_total_text"><?php _e('To show after number','woo_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" value="<?php esc_attr_e( stripslashes( $after_total_text ) );?>" style="width:120px;" id="compare_widget_after_total_text" name="woo_compare_widget_title_style[after_total_text]" /> <span class="description"><?php _e('default', 'woo_cp');?> <code>'<?php echo $default_settings['after_total_text']; ?>'</code> <?php _e('or enter text', 'woo_cp');?></span>
                    </td>
               	</tr>
			</tbody>
		</table>
        
        <h3><?php _e('Compare Count Number Styling', 'woo_cp'); ?></h3>
		<table cellspacing="0" class="form-table">
			<tbody>
				<tr>
					<th class="titledesc" scope="row"><label for="compare_widget_total_font"><?php _e('Count Number Font', 'woo_cp');?></label></th>
					<td class="forminp">
						<select class="chzn-select" style="width:120px;" id="compare_widget_total_font" name="woo_compare_widget_title_style[total_font]">
							<option value="" selected="selected"><?php _e('Select Font', 'woo_cp');?></option>
								<?php
                                foreach($fonts as $key=>$value){
                                    if( htmlspecialchars( $total_font ) ==  htmlspecialchars($key) ){
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
                    <th class="titledesc" scope="row"><label for="compare_widget_total_font_size"><?php _e('Count Number Font Size', 'woo_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="compare_widget_total_font_size" name="woo_compare_widget_title_style[total_font_size]">
                        <option value="" selected="selected"><?php _e('Select Size', 'woo_cp');?></option>
                        <?php
                        for( $i = 9 ; $i <= 40 ; $i++ ){
                            if( $total_font_size ==  $i.'px' ){
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
                    <th class="titledesc" scope="row"><label for="compare_widget_total_font_style"><?php _e('Count Number Font Style', 'woo_cp');?></label></th>
                    <td class="forminp">
                        <select class="chzn-select" style="width:120px;" id="compare_widget_total_font_style" name="woo_compare_widget_title_style[total_font_style]">
                          <option value="" selected="selected"><?php _e('Select Style', 'woo_cp');?></option>
                          <option <?php if( $total_font_style == 'normal'){ echo 'selected="selected" ';} ?>value="normal"><?php _e('Normal', 'woo_cp');?></option>
                          <option <?php if( $total_font_style == 'italic'){ echo 'selected="selected" ';} ?>value="italic"><?php _e('Italic', 'woo_cp');?></option>
                          <option <?php if( $total_font_style == 'bold'){ echo 'selected="selected" ';} ?>value="bold"><?php _e('Bold', 'woo_cp');?></option>
                          <option <?php if( $total_font_style == 'bold_italic'){ echo 'selected="selected" ';} ?>value="bold_italic"><?php _e('Bold/Italic', 'woo_cp');?></option>
                        </select> <span class="description"><?php _e('&lt;empty&gt; to use theme style', 'woo_cp');?></span>
                    </td>
				</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="compare_widget_total_font_colour"><?php _e('Count Number Font Colour','woo_cp'); ?></label></th>
                    <td class="forminp">
                    	<input type="text" class="colorpick" name="woo_compare_widget_title_style[total_font_colour]" id="compare_widget_total_font_colour" value="<?php esc_attr_e( stripslashes( $total_font_colour ) );?>" style="width:120px;" /> <span class="description"><?php _e('&lt;empty&gt; to use theme style', 'woo_cp');?></span>
            			<div id="colorPickerDiv_compare_widget_total_font_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                    </td>
               	</tr>
			</tbody>
		</table>
	<?php
	}
}
?>