<?php
class WOO_Compare_Hook_Filter{
	
	function woo_shop_add_compare_button($template_name, $template_path, $located){
		global $post;
		global $product;
		if($template_name == 'loop/add-to-cart.php'){
			$product_id = $product->id;
			$comparable_settings = get_option('woo_comparable_settings');
			$button_text = $comparable_settings['button_text'];
			if($button_text == '') $button_text = __('Compare this', 'woo_cp');
			if(($post->post_type == 'product' || $post->post_type == 'product_variation') && WOO_Compare_Functions::check_product_activate_compare($product_id) && $comparable_settings['auto_add'] == 'yes'){
				if($comparable_settings['button_type'] == 'button'){
					$compare_html = '<div class="woo_compare_button_container"><input type="button" value="'.$button_text.'" class="button woo_bt_compare_this" id="woo_bt_compare_this_'.$product_id.'" style="cursor:pointer" /> <img class="woo_add_compare_success" style="display:none !important; width:16px !important; height:14px !important;" src="'.WOOCP_IMAGES_FOLDER.'/compare_success.png" border=0 /><input type="hidden" id="input_woo_bt_compare_this_'.$product_id.'" name="product_compare_'.$product_id.'" value="'.$product_id.'" /></div>';
					
					echo $compare_html;
				}else{
					$compare_html = '<div class="woo_compare_button_container"><a class="woo_bt_compare_this" id="woo_bt_compare_this_'.$product_id.'" style="cursor:pointer">'.$button_text.'</a> <img class="woo_add_compare_success" style="display:none !important; width:16px !important; height:14px !important;" src="'.WOOCP_IMAGES_FOLDER.'/compare_success.png" border=0 /><input type="hidden" id="input_woo_bt_compare_this_'.$product_id.'" name="product_compare_'.$product_id.'" value="'.$product_id.'" /></div>';
					echo $compare_html;
				}
			}
		}
	}
	
	function woo_details_add_compare_button(){
		global $post;
		global $product;
		$product_id = $product->id;
		$comparable_settings = get_option('woo_comparable_settings');
		$button_text = $comparable_settings['button_text'];
		if($button_text == '') $button_text = __('Compare this', 'woo_cp');
		if(($post->post_type == 'product' || $post->post_type == 'product_variation') && WOO_Compare_Functions::check_product_activate_compare($product_id) && $comparable_settings['auto_add'] == 'yes'){
				if($comparable_settings['button_type'] == 'button'){
					$compare_html = '<div class="woo_compare_button_container"><input type="button" value="'.$button_text.'" class="button woo_bt_compare_this" id="woo_bt_compare_this_'.$product_id.'" style="cursor:pointer" /> <img class="woo_add_compare_success" style="display:none !important; width:16px !important; height:14px !important;" src="'.WOOCP_IMAGES_FOLDER.'/compare_success.png" border=0 /><input type="hidden" id="input_woo_bt_compare_this_'.$product_id.'" name="product_compare_'.$product_id.'" value="'.$product_id.'" /></div>';
					
					echo $compare_html;
				}else{
					$compare_html = '<div class="woo_compare_button_container"><a class="woo_bt_compare_this" id="woo_bt_compare_this_'.$product_id.'" style="cursor:pointer">'.$button_text.'</a> <img class="woo_add_compare_success" style="display:none !important; width:16px !important; height:14px !important;" src="'.WOOCP_IMAGES_FOLDER.'/compare_success.png" border=0 /><input type="hidden" id="input_woo_bt_compare_this_'.$product_id.'" name="product_compare_'.$product_id.'" value="'.$product_id.'" /></div>';
					echo $compare_html;
				}
		}
	}
	
	function add_compare_button($product_id=''){
		global $post;
		if(trim($product_id) == '') $product_id = $post->ID;
		$comparable_settings = get_option('woo_comparable_settings');
		$button_text = $comparable_settings['button_text'];
		if($button_text == '') $button_text = __('Compare this', 'woo_cp');
		$post_type = get_post_type($product_id);
		$html = '';
		if(($post_type == 'product' || $post_type == 'product_variation') && WOO_Compare_Functions::check_product_activate_compare($product_id)){
			if($comparable_settings['button_type'] == 'button'){
				$html .= '<div class="woo_compare_button_container"><input type="button" value="'.$button_text.'" class="button woo_bt_compare_this" id="woo_bt_compare_this_'.$product_id.'" style="cursor:pointer" /> <img class="woo_add_compare_success" style="display:none !important; width:16px !important; height:14px !important;" src="'.WOOCP_IMAGES_FOLDER.'/compare_success.png" border=0 /><input type="hidden" id="input_woo_bt_compare_this_'.$product_id.'" name="product_compare_'.$product_id.'" value="'.$product_id.'" /></div>';			
			}else{
				$html .= '<div class="woo_compare_button_container"><a class="woo_bt_compare_this" id="woo_bt_compare_this_'.$product_id.'" style="cursor:pointer">'.$button_text.'</a> <img class="woo_add_compare_success" style="display:none !important; width:16px !important; height:14px !important;" src="'.WOOCP_IMAGES_FOLDER.'/compare_success.png" border=0 /><input type="hidden" id="input_woo_bt_compare_this_'.$product_id.'" name="product_compare_'.$product_id.'" value="'.$product_id.'" /></div>';
			}
		}
		
		return $html;
	}
	
	function show_compare_fields($product_id=''){
		global $post;
		if(trim($product_id) == '') $product_id = $post->ID;
		$html = '';
		$compare_fields = WOO_Compare_Data::get_results('','field_order ASC');
		$variations_list = WOO_Compare_Functions::get_variations($product_id);
		if(is_array($variations_list) && count($variations_list) > 0){
			foreach($variations_list as $variation_id){
				if(WOO_Compare_Functions::check_product_activate_compare($variation_id)){
					$html .= '<div class="compare_product_variation"><h2>'.WOO_Compare_Functions::get_variation_name($variation_id).'</h2></div>';
					$html .= '<ul class="compare_featured_fields">';
					foreach($compare_fields as $field_data){
						$field_value = get_post_meta( $variation_id, '_woo_compare_'.$field_data->field_key, true );
						if(is_serialized($field_value)) $field_value = maybe_unserialize($field_value);
						if(is_array($field_value) && count($field_value) > 0) $field_value = implode(', ', $field_value);
						elseif(is_array($field_value) && count($field_value) < 0) $field_value = 'N/A';
						if(trim($field_value) == '') $field_value = 'N/A';
						$html .= '<li class="compare_featured_item"><span class="compare_featured_name"><strong>'.$field_data->field_name.'</strong></span> : <span class="compare_featured_value">'.$field_value.'</span></li>';
					}
					$html .= '</ul>';
				}
			}
		}elseif(WOO_Compare_Functions::check_product_activate_compare($product_id)){
			if(is_array($compare_fields) && count($compare_fields)>0){
				$html .= '<ul class="compare_featured_fields">';
				foreach($compare_fields as $field_data){
					$field_value = get_post_meta( $product_id, '_woo_compare_'.$field_data->field_key, true );
					if(is_serialized($field_value)) $field_value = maybe_unserialize($field_value);
					if(is_array($field_value) && count($field_value) > 0) $field_value = implode(', ', $field_value);
					elseif(is_array($field_value) && count($field_value) < 0) $field_value = 'N/A';
					if(trim($field_value) == '') $field_value = 'N/A';
					$html .= '<li class="compare_featured_item"><span class="compare_featured_name"><strong>'.$field_data->field_name.'</strong></span> : <span class="compare_featured_value">'.$field_value.'</span></li>';
				}
				$html .= '</ul>';
			}
		}
		return $html;
	}
	
	function woo_compare_footer_script(){
		$comparable_settings = get_option('woo_comparable_settings');
		if(trim($comparable_settings['popup_width']) != '') $popup_width = $comparable_settings['popup_width'];
		else $popup_width = 1000;
		
		if(trim($comparable_settings['popup_height']) != '') $popup_height = $comparable_settings['popup_height'];
		else $popup_height = 650;
		
		$script_add_on = '';
		$script_add_on .= '<script type="text/javascript">
				(function($){		
					$(function(){
						$(".woo_compare_button_go").live("click", function(ev){
							  $.lightbox("'.WOOCP_URL.'/compare_popup.php", {
								"width"       : '.$popup_width.',
								"height"      : '.$popup_height.'
							  });
							  ev.preventDefault();
						});
						
						$(".woo_compare_print").live("click", function(){
							$(".compare_popup_container").printElement({
								printBodyOptions:{
									styleToAdd:"overflow:visible !important;",
									classNameToAdd : "compare_popup_wrap"
								}
							});
						});
						
						$(".woo_bt_compare_this").live("click", function(){
							var woo_bt_compare_current = $(this);
							var product_id = $("#input_"+$(this).attr("id")).val();
							$(".woo_compare_widget_loader").show();
							$(".woo_compare_widget_container").html("");
							$.ajax({
								type: "POST",
								url: "'.WOOCP_URL.'/compare_process_ajax.php",
								data: "action=add_to_compare&product_id="+product_id,
								success: function(result){
									woo_bt_compare_current.siblings(".woo_add_compare_success").show();
									setTimeout(function(){
										woo_bt_compare_current.siblings(".woo_add_compare_success").hide();	
									}, 3000);
									$(".woo_compare_widget_loader").hide();
									$(".woo_compare_widget_container").html(result);
									woo_update_total_compare_list();
								}
							});
						});
						
						$(".woo_compare_popup_remove_product").live("click", function(){
							var popup_remove_product_id = $(this).attr("rel");
							$(".popup_woo_compare_widget_loader").show();
							$(".compare_popup_wrap").html("");
							$.ajax({
								type: "POST",
								url: "'.WOOCP_URL.'/compare_process_ajax.php",
								data: "action=remove_from_popup_compare&product_id="+popup_remove_product_id,
								success: function(result){
									$(".popup_woo_compare_widget_loader").hide();
									$(".compare_popup_wrap").html(result);
									$.ajax({
										type: "POST",
										url: "'.WOOCP_URL.'/compare_process_ajax.php",
										data: "action=update_compare_widget",
										success: function(new_widget){
											$(".woo_compare_widget_container").html(new_widget);
										}
									});
									woo_update_total_compare_list();
								}
							});
						});
						
						$(".woo_compare_remove_product").live("click", function(){
							var remove_product_id = $(this).attr("rel");
							$(".woo_compare_widget_loader").show();
							$(".woo_compare_widget_container").html("");
							$.ajax({
								type: "POST",
								url: "'.WOOCP_URL.'/compare_process_ajax.php",
								data: "action=remove_from_compare&product_id="+remove_product_id,
								success: function(result){
									$(".woo_compare_widget_loader").hide();
									$(".woo_compare_widget_container").html(result);
									woo_update_total_compare_list();
								}
							});
						});
						$(".woo_compare_clear_all").live("click", function(){
							$(".woo_compare_widget_loader").show();
							$(".woo_compare_widget_container").html("");
							$.ajax({
								type: "POST",
								url: "'.WOOCP_URL.'/compare_process_ajax.php",
								data: "action=clear_compare",
								success: function(result){
									$(".woo_compare_widget_loader").hide();
									$(".woo_compare_widget_container").html(result);
									woo_update_total_compare_list();
								}
							});
						});
						
						function woo_update_total_compare_list(){
							$.ajax({
								type: "POST",
								url: "'.WOOCP_URL.'/compare_process_ajax.php",
								data: "action=update_total_compare",
								success: function(total_compare){
									$("#total_compare_product").html("("+total_compare+")");
								}
							});
						}
					});		  
				})(jQuery);
				</script>';
		echo $script_add_on;
	}
	
	function woocp_print_scripts(){
		wp_enqueue_script('jquery');
				
		// light box
		wp_enqueue_script('lightbox2_script', WOOCP_URL . '/js/lightbox/jquery.lightbox.js');
		wp_enqueue_script('a3_print_element', WOOCP_URL . '/js/jquery.printElement.js');
	}
	
	function woocp_print_styles(){
		wp_enqueue_style('a3_lightbox_style', WOOCP_URL . '/js/lightbox/themes/default/jquery.lightbox.css');
		echo '<style>.woo_compare_button_container{margin-bottom:10px;}</style>';
	}
	
	function woo_product_compare_featured_tab(){
		$comparable_settings = get_option('woo_comparable_settings');
		$compare_featured_tab = trim($comparable_settings['compare_featured_tab']);
		if($compare_featured_tab == '') $compare_featured_tab = 'Technical Details';
		echo '<li><a href="#tab-compare-featured">'.$compare_featured_tab.'</a></li>';
	}
	
	function woo_product_compare_featured_panel(){
		global $woocommerce, $post;
		?>
		<div class="panel" id="tab-compare-featured">
			<?php echo WOO_Compare_Hook_Filter::show_compare_fields($post->id); ?>
		</div>
        <?php
	}
}
?>