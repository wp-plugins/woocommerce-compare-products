<?php
class WOO_Compare_Hook_Filter{
	
	function woo_shop_add_compare_button($template_name, $template_path, $located){
		global $post;
		global $product;
		if($template_name == 'loop/add-to-cart.php'){
			$product_id = $product->id;
			$comparable_settings = get_option('woo_comparable_settings');
			$button_text = $comparable_settings['button_text'];
			$compare_fields = WOO_Compare_Data::get_results('','field_order ASC');
			if(is_array($compare_fields) && count($compare_fields)>0){
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
	}
	
	function woo_details_add_compare_button(){
		global $post;
		global $product;
		$product_id = $product->id;
		$comparable_settings = get_option('woo_comparable_settings');
		$button_text = $comparable_settings['button_text'];
		if($button_text == '') $button_text = __('Compare this', 'woo_cp');
		$compare_fields = WOO_Compare_Data::get_results('','field_order ASC');
		if(is_array($compare_fields) && count($compare_fields)>0){
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
	
	function add_compare_button($product_id=''){
		global $post;
		if(trim($product_id) == '') $product_id = $post->ID;
		$comparable_settings = get_option('woo_comparable_settings');
		$button_text = $comparable_settings['button_text'];
		if($button_text == '') $button_text = __('Compare this', 'woo_cp');
		$post_type = get_post_type($product_id);
		$html = '';
		$compare_fields = WOO_Compare_Data::get_results('','field_order ASC');
		if(is_array($compare_fields) && count($compare_fields)>0){
			if(($post_type == 'product' || $post_type == 'product_variation') && WOO_Compare_Functions::check_product_activate_compare($product_id)){
				if($comparable_settings['button_type'] == 'button'){
					$html .= '<div class="woo_compare_button_container"><input type="button" value="'.$button_text.'" class="button woo_bt_compare_this" id="woo_bt_compare_this_'.$product_id.'" style="cursor:pointer" /> <img class="woo_add_compare_success" style="display:none !important; width:16px !important; height:14px !important;" src="'.WOOCP_IMAGES_FOLDER.'/compare_success.png" border=0 /><input type="hidden" id="input_woo_bt_compare_this_'.$product_id.'" name="product_compare_'.$product_id.'" value="'.$product_id.'" /></div>';			
				}else{
					$html .= '<div class="woo_compare_button_container"><a class="woo_bt_compare_this" id="woo_bt_compare_this_'.$product_id.'" style="cursor:pointer">'.$button_text.'</a> <img class="woo_add_compare_success" style="display:none !important; width:16px !important; height:14px !important;" src="'.WOOCP_IMAGES_FOLDER.'/compare_success.png" border=0 /><input type="hidden" id="input_woo_bt_compare_this_'.$product_id.'" name="product_compare_'.$product_id.'" value="'.$product_id.'" /></div>';
				}
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
					if(is_array($compare_fields) && count($compare_fields)>0){
						$html .= '<div class="compare_product_variation"><h2>'.WOO_Compare_Functions::get_variation_name($variation_id).'</h2></div>';
						$html .= '<ul class="compare_featured_fields">';
						foreach($compare_fields as $field_data){
							$field_value = get_post_meta( $variation_id, '_woo_compare_'.$field_data->field_key, true );
							if(is_serialized($field_value)) $field_value = maybe_unserialize($field_value);
							if(is_array($field_value) && count($field_value) > 0) $field_value = implode(', ', $field_value);
							elseif(is_array($field_value) && count($field_value) < 0) $field_value = 'N/A';
							if(trim($field_value) == '') $field_value = 'N/A';
							if(trim($field_data->field_unit) != '')
								$html .= '<li class="compare_featured_item"><span class="compare_featured_name"><strong>'.$field_data->field_name.'</strong> ('.$field_data->field_unit.')</span> : <span class="compare_featured_value">'.$field_value.'</span></li>';
							else 
								$html .= '<li class="compare_featured_item"><span class="compare_featured_name"><strong>'.$field_data->field_name.'</strong></span> : <span class="compare_featured_value">'.$field_value.'</span></li>';
						}
						$html .= '</ul>';
					}
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
					if(trim($field_data->field_unit) != '')
						$html .= '<li class="compare_featured_item"><span class="compare_featured_name"><strong>'.$field_data->field_name.'</strong> ('.$field_data->field_unit.')</span> : <span class="compare_featured_value">'.$field_value.'</span></li>';
					else
						$html .= '<li class="compare_featured_item"><span class="compare_featured_name"><strong>'.$field_data->field_name.'</strong></span> : <span class="compare_featured_value">'.$field_value.'</span></li>';
				}
				$html .= '</ul>';
			}
		}
		return $html;
	}
	
	function woocp_add_to_compare(){
		check_ajax_referer( 'woocp-compare-events', 'security' );
		
		$product_id 	= $_REQUEST['product_id'];
		WOO_Compare_Functions::add_product_to_compare_list($product_id);
		$result = WOO_Compare_Functions::get_compare_list_html_widget();
		
		echo json_encode( $result );
		die();
	}
	
	function woocp_remove_from_popup_compare(){
		check_ajax_referer( 'woocp-compare-events', 'security' );
		
		$product_id 	= $_REQUEST['product_id'];
		WOO_Compare_Functions::delete_product_on_compare_list($product_id);
		$result = WOO_Compare_Functions::get_compare_list_html_popup();
		
		echo json_encode( $result );
		die();
	}
	
	function woocp_update_compare_widget(){
		check_ajax_referer( 'woocp-compare-events', 'security' );
		$result = WOO_Compare_Functions::get_compare_list_html_widget();
		echo json_encode( $result );
		die();
	}
	
	function woocp_update_total_compare(){
		check_ajax_referer( 'woocp-compare-events', 'security' );
		$result = WOO_Compare_Functions::get_total_compare_list();
		echo json_encode( $result );
		die();
	}
	
	function woocp_remove_from_compare(){
		check_ajax_referer( 'woocp-compare-events', 'security' );
		$product_id 	= $_REQUEST['product_id'];
		WOO_Compare_Functions::delete_product_on_compare_list($product_id);
		$result = WOO_Compare_Functions::get_compare_list_html_widget();
		echo json_encode( $result );
		die();
	}
	
	function woocp_clear_compare(){
		check_ajax_referer( 'woocp-compare-events', 'security' );
		WOO_Compare_Functions::clear_compare_list();
		$result = WOO_Compare_Functions::get_compare_list_html_widget();
		echo json_encode( $result );
		die();
	}
	
	function woocp_get_popup(){
		check_ajax_referer( 'woocp-compare-popup', 'security' );
		$comparable_settings = get_option('woo_comparable_settings');
		if(trim($comparable_settings['compare_container_height']) != '') $compare_container_height = $comparable_settings['compare_container_height']; else $compare_container_height = 500;
	?>
    	<div class="compare_popup_container">
			<style type="text/css">
            .compare_popup_container{
                font-size:12px;
                margin:auto;
                width:960px;
            }
            .compare_popup_wrap{
                overflow:auto;
                width:940px;
                height:<?php echo $compare_container_height; ?>px;
                margin:0 10px;
                padding-bottom:10px;
            }
            .compare_logo{
                text-align:center;	
            }
            .compare_logo img{
                max-width:940px;
            }
            .compare_heading{
                float:left;
                width:940px;
                margin:10px 10px 0;	
            }
            .compare_heading h1{
                font-size:20px;
                font-weight:bold;
                float:left;
            }
            .woo_compare_print{
                float:right;
                background:url(<?php echo WOOCP_IMAGES_FOLDER; ?>/icon_print.png) no-repeat 0 center;
                padding-left:20px;	
                cursor:pointer;
            }
            .woo_compare_print_msg{
                float:right;
                clear:right;
            }
            .compare_popup_table{
                border:1px solid #325EBF; 
                border-radius:8px; 
                -khtml-border-radius: 8px; 
                -webkit-border-radius: 8px; 
                -moz-border-radius: 8px;
                box-shadow:2px 3px 2px #333333;
                -moz-box-shadow: 2px 3px 2px #333333;
                -webkit-box-shadow: 2px 3px 2px #333333;
                margin:auto;
            }
            .compare_popup_table td{
                font-size:12px;
                text-align:center;
                padding:2px 10px;
                vertical-align:middle;
            }
            .compare_popup_table tr.row_product_detail td{
                vertical-align:top;	
            }
            .compare_popup_table .column_first{
                background:#f6f6f6;
                font-size:13px;
                font-weight:bold;
            }
            .compare_popup_table .first_row{
                width:220px; 
                min-width:220px;
                height:20px;
                text-align:right;
                /* fallback (opera, ie<=7) */
                background: #EEEEEE;
                /* Mozilla: */
                background: -moz-linear-gradient(top, #FFFFFF, #EEEEEE);
                /* Chrome, safari:*/
                background: -webkit-gradient(linear, left top, left bottom, from(#FFFFFF), to(#EEEEEE));
                /* MSIE 8+ */
                filter: progid:DXImageTransform.Microsoft.Gradient(StartColorStr='#FFFFFF', EndColorStr='#EEEEEE', GradientType=0);
            }
            .compare_popup_table .column_first.first_row{
                width:190px;
                min-width:190px;	
            }
            .compare_popup_table .row_1{
                background:#FFF;
            }
            .compare_popup_table .row_2{
                background:#f6f6f6;
                border-top:1px solid #CCC;
                border-bottom:1px solid #CCC;
            }
            .compare_popup_table .row_2 td{
                border-top:1px solid #CCC;
                border-bottom:1px solid #CCC;
            }
            .compare_popup_table .row_end td{
                border-bottom:none;	
                padding-bottom:10px;
                padding-top:10px;
            }
            .compare_image_container{
                /*width:220px;*/ 
                height:180px; 
                /*display:table-cell;*/ 
                overflow:hidden; 
                text-align:center; 
                line-height:180px; 
                vertical-align:middle;
            }
            .compare_image_container img{
                max-width:220px; 
                max-height:180px; 
                border:0;
                vertical-align:middle;
            }
            .compare_product_name{
                color:#C30;
                font-weight:bold;
                font-size:16px;
                line-height:21px;
                margin-bottom:5px;
            }
            .compare_avg_rating{
                margin-bottom:5px;	
            }
            .compare_avg_rating .votetext{
                height:auto;
            }
            .compare_price{
                color:#C30;
                font-weight:bold;
                font-size:16px;
                margin-bottom:5px;
            }
            .compare_price del{
                color:#999;
                font-size:13px;
                font-weight:normal;	
            }
            </style>
                <div class="compare_logo"><?php if(trim($comparable_settings['compare_logo']) != ''){ ?><img src="<?php echo $comparable_settings['compare_logo']; ?>" alt="" /><?php } ?></div>
                <div class="compare_heading"><h1><?php _e('Compare Products', 'woo_cp'); ?></h1> <span class="woo_compare_print"><?php _e('Print This Page', 'woo_cp'); ?></span><span class="woo_compare_print_msg"><?php _e('Narrow your selection to 3 products and print!', 'woo_cp'); ?></span></div>
                <div style="clear:both;"></div>
                <div class="popup_woo_compare_widget_loader" style="display:none; text-align:center"><img src="<?php echo WOOCP_IMAGES_FOLDER; ?>/ajax-loader.gif" border=0 /></div>
                <div class="compare_popup_wrap">
                    <?php echo WOO_Compare_Functions::get_compare_list_html_popup();?>
                </div>
        </div>
    <?php
		die();
	}
	
	function woo_compare_footer_script(){
		$woocp_compare_events = wp_create_nonce("woocp-compare-events");
		$woocp_compare_popup = wp_create_nonce("woocp-compare-popup");
		$comparable_settings = get_option('woo_comparable_settings');
		if(trim($comparable_settings['popup_width']) != '') $popup_width = $comparable_settings['popup_width'];
		else $popup_width = 1000;
		
		if(trim($comparable_settings['popup_height']) != '') $popup_height = $comparable_settings['popup_height'];
		else $popup_height = 650;
		
		$script_add_on = '';
		$script_add_on .= '<script type="text/javascript">
				(function($){		
					$(function(){
						var ajax_url = "'.admin_url('admin-ajax.php').'"';
		if(trim($comparable_settings['popup_type']) == 'lightbox'){
			$script_add_on .= '				
						$(".woo_compare_button_go").live("click", function(ev){
							  $.lightbox(ajax_url+"?action=woocp_get_popup&security='.$woocp_compare_popup.'", {
								"width"       : '.$popup_width.',
								"height"      : '.$popup_height.'
							  });
							  ev.preventDefault();
						});';
		}else{
			$script_add_on .= '				
						$(".woo_compare_button_go").live("click", function(ev){
							$.fancybox({
								href: ajax_url+"?action=woocp_get_popup&security='.$woocp_compare_popup.'",
								title: "Compare Products",
								maxWidth: '.$popup_width.',
								maxHeight: '.$popup_height.',
								openEffect	: "none",
								closeEffect	: "none"
							});
							ev.preventDefault();
						});';
		}
		$script_add_on .= '				
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
							var data = {
								action: 		"woocp_add_to_compare",
								product_id: 	product_id,
								security: 		"'.$woocp_compare_events.'"
							};
							$.post( ajax_url, data, function(response) {
								result = $.parseJSON( response );
								woo_bt_compare_current.siblings(".woo_add_compare_success").show();
								setTimeout(function(){
									woo_bt_compare_current.siblings(".woo_add_compare_success").hide();	
								}, 3000);
								$(".woo_compare_widget_loader").hide();
								$(".woo_compare_widget_container").html(result);
								woo_update_total_compare_list();
							});
						});
						
						$(".woo_compare_popup_remove_product").live("click", function(){
							var popup_remove_product_id = $(this).attr("rel");
							$(".popup_woo_compare_widget_loader").show();
							$(".compare_popup_wrap").html("");
							var data = {
								action: 		"woocp_remove_from_popup_compare",
								product_id: 	popup_remove_product_id,
								security: 		"'.$woocp_compare_events.'"
							};
							$.post( ajax_url, data, function(response) {
								result = $.parseJSON( response );
								$(".popup_woo_compare_widget_loader").hide();
								$(".compare_popup_wrap").html(result);
								data = {
									action: 		"woocp_update_compare_widget",
									security: 		"'.$woocp_compare_events.'"
								};
								$.post( ajax_url, data, function(response) {
									new_widget = $.parseJSON( response );
									$(".woo_compare_widget_container").html(new_widget);
								});
								woo_update_total_compare_list();
							});
						});
						
						$(".woo_compare_remove_product").live("click", function(){
							var remove_product_id = $(this).attr("rel");
							$(".woo_compare_widget_loader").show();
							$(".woo_compare_widget_container").html("");
							var data = {
								action: 		"woocp_remove_from_compare",
								product_id: 	remove_product_id,
								security: 		"'.$woocp_compare_events.'"
							};
							$.post( ajax_url, data, function(response) {
								result = $.parseJSON( response );
								$(".woo_compare_widget_loader").hide();
								$(".woo_compare_widget_container").html(result);
								woo_update_total_compare_list();
							});
						});
						$(".woo_compare_clear_all").live("click", function(){
							$(".woo_compare_widget_loader").show();
							$(".woo_compare_widget_container").html("");
							var data = {
								action: 		"woocp_clear_compare",
								security: 		"'.$woocp_compare_events.'"
							};
							$.post( ajax_url, data, function(response) {
								result = $.parseJSON( response );
								$(".woo_compare_widget_loader").hide();
								$(".woo_compare_widget_container").html(result);
								woo_update_total_compare_list();
							});
						});
						
						function woo_update_total_compare_list(){
							var data = {
								action: 		"woocp_update_total_compare",
								security: 		"'.$woocp_compare_events.'"
							};
							$.post( ajax_url, data, function(response) {
								total_compare = $.parseJSON( response );
								$("#total_compare_product").html("("+total_compare+")");
							});
						}
					});		  
				})(jQuery);
				</script>';
		echo $script_add_on;
	}
	
	function woocp_print_scripts(){
		wp_enqueue_script('jquery');
		$comparable_settings = get_option('woo_comparable_settings');
		if(trim($comparable_settings['popup_type']) == 'lightbox'){
			// light box
			wp_enqueue_script('lightbox2_script', WOOCP_URL . '/js/lightbox/jquery.lightbox.js');
		}else{
			//mousewheel
			//wp_enqueue_script('mousewheel_script', WOOCP_URL . '/js/jquery.mousewheel-3.0.4.pack.js');
			//wp_enqueue_script('fancybox_script', WOOCP_URL . '/js/fancybox/jquery.fancybox.js');
		}
		wp_enqueue_script('a3_print_element', WOOCP_URL . '/js/jquery.printElement.js');
	}
	
	function woocp_print_styles(){
		$comparable_settings = get_option('woo_comparable_settings');
		if(trim($comparable_settings['popup_type']) == 'lightbox'){
			// light box
			wp_enqueue_style('a3_lightbox_style', WOOCP_URL . '/js/lightbox/themes/default/jquery.lightbox.css');
		}else{
			// fancy box
			//wp_enqueue_style('fancybox_style', WOOCP_URL . '/js/fancybox/jquery.fancybox.css');
		}
		echo '<style>.woo_compare_button_container{margin-bottom:10px;}</style>';
	}
	
	function woo_product_compare_featured_tab(){
		global $post;
		$compare_fields = WOO_Compare_Data::get_results('','field_order ASC');
		if(is_array($compare_fields) && count($compare_fields)>0){
			$comparable_settings = get_option('woo_comparable_settings');
			$compare_featured_tab = trim($comparable_settings['compare_featured_tab']);
			if($compare_featured_tab == '') $compare_featured_tab = 'Technical Details';
			$show_compare_featured_tab = false;
			$product_id = $post->ID;
			$variations_list = WOO_Compare_Functions::get_variations($product_id);
			if(is_array($variations_list) && count($variations_list) > 0){
				foreach($variations_list as $variation_id){
					if(WOO_Compare_Functions::check_product_activate_compare($variation_id)){
						$show_compare_featured_tab = true;
						break;
					}
				}
			}elseif(WOO_Compare_Functions::check_product_activate_compare($product_id)){
				$show_compare_featured_tab = true;
			}
			
			if($show_compare_featured_tab) echo '<li><a href="#tab-compare-featured">'.$compare_featured_tab.'</a></li>';
		}
	}
	
	function woo_product_compare_featured_panel(){
		global $woocommerce, $post;
		?>
		<div class="panel" id="tab-compare-featured">
			<?php echo WOO_Compare_Hook_Filter::show_compare_fields($post->ID); ?>
		</div>
        <?php
	}
	
	function woocp_admin_script(){
		global $woocommerce;
		$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.minified';

		wp_enqueue_style( 'woocommerce_admin_styles', $woocommerce->plugin_url() . '/assets/css/admin.css' );
		echo '<script src="'.WOOCP_URL . '/js/tipTip/jquery.tipTip'.$suffix.'.js" type="text/javascript"></script>';	
		echo '<script type="text/javascript">
(function($){		
	$(function(){
		// Tooltips
		jQuery(".help_tip").tipTip({
			"attribute" : "tip",
			"fadeIn" : 50,
			"fadeOut" : 50
		});
	});		  
})(jQuery);
		</script>';
	}
}
?>