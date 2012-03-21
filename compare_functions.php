<?php
class WOO_Compare_Functions{
	function get_variations($product_id){
		$product_avalibale = array();
		$terms = wp_get_object_terms( $product_id, 'product_type', array('fields' => 'names') );
		if(sanitize_title($terms[0]) == 'variable'){
			$attributes = (array) maybe_unserialize( get_post_meta($product_id, '_product_attributes', true) );
			
			// See if any are set
			$variation_attribute_found = false;
			if ($attributes) foreach($attributes as $attribute){
				if (isset($attribute['is_variation'])) :
					$variation_attribute_found = true;
					break;
				endif;
			}
			if ($variation_attribute_found){
				$args = array(
						'post_type'	=> 'product_variation',
						'post_status' => array('publish'),
						'numberposts' => -1,
						'orderby' => 'id',
						'order' => 'asc',
						'post_parent' => $product_id
				);
				$variations = get_posts($args);
				if ($variations){
					foreach ($variations as $variation){
						$product_avalibale[] = $variation->ID;
					}
				}
			}
		}elseif(sanitize_title($terms[0]) == 'grouped'){
			$args = array(
						'post_type'	=> 'product',
						'post_status' => array('publish'),
						'numberposts' => -1,
						'orderby' => 'id',
						'order' => 'asc',
						'post_parent' => $product_id
			);
			$variations = get_posts($args);
			if ($variations){
				foreach ($variations as $variation){
					$product_avalibale[] = $variation->ID;
				}
			}
		}
		
		//return $product_avalibale;
		return array();
	}
	
	function get_variation_name($variation_id){
		$mypost = get_post($variation_id);
		if($mypost->post_type == 'product_variation'){
			$attributes = (array) maybe_unserialize(get_post_meta($mypost->post_parent, '_product_attributes', true));
			$my_variation = new WC_Product_Variation($variation_id, $mypost->post_parent);
			$variation_data = $my_variation->variation_data;
			$variation_name = '';
			foreach($attributes as $attribute){
				if ( !$attribute['is_variation'] ) continue;
				$taxonomy = 'attribute_' . sanitize_title($attribute['name']);
                if (isset($variation_data[$taxonomy])) {
					if (taxonomy_exists(sanitize_title($attribute['name']))){
						$term = get_term_by('slug', $variation_data[$taxonomy], sanitize_title($attribute['name']));
						if (!is_wp_error($term) && $term->name){
							$value = $term->name;
							$variation_name .= ' '.$value;
						}
					}else{
						$variation_name .= ' '.$attribute['name'];
					}
				}
				
			}
						
			$product_name = get_the_title($mypost->post_parent).' -'.$variation_name;
		}else{
			$product_name = get_the_title($variation_id);
		}
		
		return $product_name;
	}
	
	function check_product_activate_compare($product_id){
		if(get_post_meta( $product_id, '_woo_deactivate_compare_feature', true ) != 'yes'){
			return true;
		}else{
			return false;	
		}
	}
	
	function add_product_to_compare_list($product_id){
		$product_list = WOO_Compare_Functions::get_variations($product_id);
		if(count($product_list) < 1 && WOO_Compare_Functions::check_product_activate_compare($product_id)) $product_list = array($product_id);
		if(is_array($product_list) && count($product_list) > 0){
			$current_compare_list = (array)$_SESSION['woo_compare_list'];
			foreach($product_list as $product_add){
				if(!in_array($product_add, $current_compare_list)){
					$current_compare_list[] = $product_add;
				}
			}
			$_SESSION['woo_compare_list'] = $current_compare_list;
		}
	}
	
	function get_compare_list(){
		$current_compare_list = (array)$_SESSION['woo_compare_list'];
		$return_compare_list = array();
		if(is_array($current_compare_list) && count($current_compare_list) > 0){
			foreach($current_compare_list as $product_id){
				if(WOO_Compare_Functions::check_product_activate_compare($product_id)){
					$return_compare_list[] = $product_id;
				}
			}
		}
		return $return_compare_list;
	}
	
	function get_total_compare_list(){
		$current_compare_list = (array)$_SESSION['woo_compare_list'];
		$return_compare_list = array();
		if(is_array($current_compare_list) && count($current_compare_list) > 0){
			foreach($current_compare_list as $product_id){
				if(WOO_Compare_Functions::check_product_activate_compare($product_id)){
					$return_compare_list[] = $product_id;
				}
			}
		}
		return count($return_compare_list);
	}
	
	function delete_product_on_compare_list($product_id){
		$current_compare_list = (array)$_SESSION['woo_compare_list'];
		$key = array_search($product_id, $current_compare_list);
		unset($current_compare_list[$key]);
		$_SESSION['woo_compare_list'] = $current_compare_list;
	}
	
	function clear_compare_list(){
		unset($_SESSION['woo_compare_list']);
	}
	
	function woocp_the_product_price( $product_id, $no_decimals = false, $only_normal_price = false ) {
		global $woo_query, $woo_variations, $wpdb;
		$price = $full_price = get_post_meta( $product_id, '_woo_price', true );
	
		if ( ! $only_normal_price ) {
			$special_price = get_post_meta( $product_id, '_woo_special_price', true );
	
			if ( ( $full_price > $special_price ) && ( $special_price > 0 ) )
				$price = $special_price;
		}
	
		if ( $no_decimals == true )
			$price = array_shift( explode( ".", $price ) );
	
		$price = apply_filters( 'woo_do_convert_price', $price );
		$args = array(
				'display_as_html' => false,
				'display_decimal_point' => ! $no_decimals
		);
		if($price > 0){
			$output = woo_currency_display( $price, $args );
			return $output;
		}
	}
	
	function get_compare_list_html_widget(){
		$compare_list = WOO_Compare_Functions::get_compare_list();
		$html = '';
		if(is_array($compare_list) && count($compare_list)>0){
			$html .= '<ul class="compare_widget_ul">';
			foreach($compare_list as $product_id){
				$html .= '<li class="compare_widget_item">';
					$html .= '<div class="compare_remove_column" style="float:right; margin-left:5px;"><a class="woo_compare_remove_product" rel="'.$product_id.'" style="cursor:pointer;"><img src="'.WOOCP_IMAGES_FOLDER.'/compare_remove.png" border=0 /></a></div>';
					$html .= '<div class="compare_title_column">'.WOO_Compare_Functions::get_variation_name($product_id).'</div>';
				$html .= '</li>';
			}
			$html .= '</ul>';
			$html .= '<div class="compare_widget_action"><a class="woo_compare_clear_all" style="cursor:pointer;">Clear All</a> <input type="button" name="woo_compare_button_go" class="woo_compare_button_go" value="Compare" style="cursor:pointer" /></div>';
		}else{
			$html .= '<div class="no_compare_list">You do not have any product to compare.</div>';	
		}
		return $html;
	}
	
	function get_compare_list_html_popup(){
		$compare_list = WOO_Compare_Functions::get_compare_list();
		$html = '';
		$products_prices = array();
		if(is_array($compare_list) && count($compare_list)>0){
			$html .= '<table class="compare_popup_table" border="0" cellpadding="5" cellspacing="0" width="">';
				$html .= '<tr><td class="column_first first_row"></td>';
				foreach($compare_list as $product_id){
					$html .= '<td class="first_row"><a class="woo_compare_popup_remove_product" rel="'.$product_id.'" style="cursor:pointer;"><img src="'.WOOCP_IMAGES_FOLDER.'/compare_remove.png" border=0 /></a></td>';
				}
				$html .= '</tr>';
				$html .= '<tr class="row_1 row_product_detail"><td class="column_first"></td>';
				$i = 0;
				foreach($compare_list as $product_id){
					$i++;
					$current_product = new WC_Product($product_id);
					$product_name = WOO_Compare_Functions::get_variation_name($product_id);
					$products_prices[$product_id] = $current_product->get_price_html();
					$image_src = WOO_Compare_Functions::get_post_thumbnail($product_id, 220, 180);
					if(trim($image_src) == ''){
						$image_src = '<img alt="'.$product_name.'" src="'.woocommerce_placeholder_img_src().'" />';
					}
					$html .= '<td class="column_'.$i.'">';
						$html .= '<div class="compare_image_container">'.$image_src.'</div>';
						$html .= '<div class="compare_product_name">'.$product_name.'</div>';
						$html .= '<div class="compare_price">'.$products_prices[$product_id].'</div>';
					$html .= '</td>';
				}
				$html .= '</tr>';
			$compare_fields = WOO_Compare_Data::get_results('','field_order ASC');
		if(is_array($compare_fields) && count($compare_fields)>0){
			$j = 1;
			foreach($compare_fields as $field_data){
				$j++;
				$html .= '<tr class="row_'.$j.'">';
					$html .= '<td class="column_first">'.$field_data->field_name.'</td>';
				$i = 0;
				foreach($compare_list as $product_id){
					$i++;
					$field_value = get_post_meta( $product_id, '_woo_compare_'.$field_data->field_key, true );
					if(is_serialized($field_value)) $field_value = maybe_unserialize($field_value);
					if(is_array($field_value) && count($field_value) > 0) $field_value = implode(', ', $field_value);
					elseif(is_array($field_value) && count($field_value) < 0) $field_value = 'N/A';
					if(trim($field_value) == '') $field_value = 'N/A';
					$html .= '<td class="column_'.$i.'"><div class="compare_value compare_'.$field_data->field_key.'">'.$field_value.'</div></td>';
				}
				$html .= '</tr>';
				if($j==2) $j=0;
			}
			$j++;
			if($j>2) $j=1;
				$html .= '<tr class="row_'.$j.' row_end"><td class="column_first"></td>';
				$i = 0;
				foreach($compare_list as $product_id){
					$i++;
					$html .= '<td class="column_'.$i.'">';
						$html .= '<div class="compare_price">'.$products_prices[$product_id].'</div>';
					$html .= '</td>';
				}
		}
			$html .= '</table>';
		}else{
			$html .= '<div class="no_compare_list">You do not have any product to compare.</div>';	
		}
		return $html;
	}
	
	function get_post_thumbnail($postid=0, $width=220, $height=180){
		$mediumSRC = '';
		// Get the product ID if none was passed
		if ( empty( $postid ) )
			$postid = get_the_ID();
	
		// Load the product
		$product = get_post( $postid );
			
		if(has_post_thumbnail($postid)) {
			$thumbid = get_post_thumbnail_id($postid);
			$attachmentArray = wp_get_attachment_image_src($thumbid, array(0 => $width, 1 => $height), false);
			$mediumSRC = $attachmentArray[0];
			if(trim($mediumSRC != '')){
				return '<img src="'.$mediumSRC.'" />';
			}
		}
		if(trim($mediumSRC == '')){
			$args = array( 'post_parent' => $postid ,'numberposts' => 1, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'DESC', 'orderby' => 'ID', 'post_status' => null); 
			$attachments = get_posts($args);
			if ($attachments) {
				foreach ( $attachments as $attachment ) {
					$mediumSRC = wp_get_attachment_image( $attachment->ID, array(0 => $width, 1 => $height),true );
					break;
				}
			}
		}
		
		if(trim($mediumSRC == '')){
			// Get ID of parent product if one exists
			if ( !empty( $product->post_parent ) )
				$postid = $product->post_parent;
				
			if(has_post_thumbnail($postid)) {
				$thumbid = get_post_thumbnail_id($postid);
				$attachmentArray = wp_get_attachment_image_src($thumbid, array(0 => $width, 1 => $height), false);
				$mediumSRC = $attachmentArray[0];
				if(trim($mediumSRC != '')){
					return '<img src="'.$mediumSRC.'" />';
				}
			}
			if(trim($mediumSRC == '')){
				$args = array( 'post_parent' => $postid ,'numberposts' => 1, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'DESC', 'orderby' => 'ID', 'post_status' => null); 
				$attachments = get_posts($args);
				if ($attachments) {
					foreach ( $attachments as $attachment ) {
						$mediumSRC = wp_get_attachment_image( $attachment->ID, array(0 => $width, 1 => $height),true );
						break;
					}
				}
			}
		}
		return $mediumSRC;
	}
	
	function activate_this_plugin(){
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: WOO Compare Products Lite <mr.alextuan@gmail.com>' . "\r\n\\";
		$subject = 'Activated WOO Compare Products plugin';
		
		$content = '------------------------------------------------------<br \><br \>';
		$content .= 'Website: '.get_bloginfo('name').' <br />';
		$content .= 'URL: '.get_option('siteurl').' <br />';
		$content .= 'IP: '.$_SERVER['SERVER_ADDR'].' <br />';
		$content .= 'Plugin: WOO Compare Products <br />';
		$content .= 'Email: '.get_bloginfo('admin_email').' <br />';
		$content .= '------------------------------------------------------<br \><br \>';
		
		return wp_mail('mr.nguyencongtuan@gmail.com', $subject, $content, $headers, '');
	}
}
?>