<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WooCommerce Compare Functions
 *
 * Table Of Contents
 *
 * get_variations()
 * get_variation_name()
 * get_product_url()
 * check_product_activate_compare()
 * check_product_have_cat()
 * add_product_to_compare_list()
 * get_compare_list()
 * get_total_compare_list()
 * delete_product_on_compare_list()
 * woocp_the_product_price()
 * get_compare_list_html_widget()
 * get_compare_list_html_popup()
 * add_meta_all_products()
 * auto_assign_master_category_to_all_products()
 * get_post_thumbnail()
 * modify_url()
 * printPage()
 * compare_extension()
 * categories_extension()
 * other_plugins_notice()
 */
class WC_Compare_Functions {

	/**
	 * Get variations or child product from variable product and grouped product
	 */
	function get_variations($product_id) {
		$product_avalibale = array();
		$terms = wp_get_object_terms( $product_id, 'product_type', array('fields' => 'names') );

		// If it is variable product
		if (sanitize_title($terms[0]) == 'variable') {
			$attributes = (array) maybe_unserialize( get_post_meta($product_id, '_product_attributes', true) );

			// See if any are set
			$variation_attribute_found = false;
			if ($attributes) foreach ($attributes as $attribute) {
					if (isset($attribute['is_variation'])) :
						$variation_attribute_found = true;
					break;
					endif;
				}
			if ($variation_attribute_found) {
				$args = array(
					'post_type' => 'product_variation',
					'post_status' => array('publish'),
					'numberposts' => -1,
					'orderby' => 'id',
					'order' => 'asc',
					'post_parent' => $product_id
				);
				$variations = get_posts($args);
				if ($variations) {
					foreach ($variations as $variation) {
						if (WC_Compare_Functions::check_product_activate_compare($variation->ID) && WC_Compare_Functions::check_product_have_cat($variation->ID)) {
							$product_avalibale[] = $variation->ID;
						}
					}
				}
			}
		}
		// If it is grouped product
		elseif (sanitize_title($terms[0]) == 'grouped') {
			$args = array(
				'post_type' => 'product',
				'post_status' => array('publish'),
				'numberposts' => -1,
				'orderby' => 'id',
				'order' => 'asc',
				'post_parent' => $product_id
			);
			$variations = get_posts($args);
			if ($variations) {
				foreach ($variations as $variation) {
					if (WC_Compare_Functions::check_product_activate_compare($variation->ID) && WC_Compare_Functions::check_product_have_cat($variation->ID)) {
						$product_avalibale[] = $variation->ID;
					}
				}
			}
		}

		return $product_avalibale;
	}

	/**
	 * Get variation name from variation id
	 */
	function get_variation_name($variation_id) {
		$mypost = get_post($variation_id);
		$product_name = '';
		if ($mypost != NULL) {
			if ($mypost->post_type == 'product_variation') {
				$attributes = (array) maybe_unserialize(get_post_meta($mypost->post_parent, '_product_attributes', true));
				$my_variation = new WC_Product_Variation($variation_id, $mypost->post_parent);
				$variation_data = $my_variation->variation_data;
				$variation_name = '';
				if (is_array($attributes) && count($attributes) > 0) {
					foreach ($attributes as $attribute) {
						if ( !$attribute['is_variation'] ) continue;
						$taxonomy = 'attribute_' . sanitize_title($attribute['name']);
						if (isset($variation_data[$taxonomy])) {
							if (taxonomy_exists(sanitize_title($attribute['name']))) {
								$term = get_term_by('slug', $variation_data[$taxonomy], sanitize_title($attribute['name']));
								if (!is_wp_error($term) && isset($term->name) && $term->name != '') {
									$value = $term->name;
									$variation_name .= ' '.$value;
								}
							}else {
								$variation_name .= ' '.$attribute['name'];
							}
						}

					}
				}

				$product_name = get_the_title($mypost->post_parent).' -'.$variation_name;
			}else {
				$product_name = get_the_title($variation_id);
			}
		}

		return $product_name;
	}

	/**
	 * Get product url
	 */
	function get_product_url($product_id) {
		$mypost = get_post($product_id);
		if ($mypost->post_type == 'product_variation') {
			$product_url = add_query_arg('variation_selected', $product_id, get_permalink($mypost->post_parent));
		}else {
			$product_url = get_permalink($product_id);
		}

		return $product_url;
	}

	/**
	 * check product or variation is deactivated or activated
	 */
	function check_product_activate_compare($product_id) {
		if (get_post_meta( $product_id, '_woo_deactivate_compare_feature', true ) != 'yes') {
			return true;
		}else {
			return false;
		}
	}

	/**
	 * Check product that is assigned the compare category for it
	 */
	function check_product_have_cat($product_id) {
		$compare_category = get_post_meta( $product_id, '_woo_compare_category', true );
		if ($compare_category > 0 && WC_Compare_Categories_Data::get_count("id='".$compare_category."'") > 0) {
			$compare_fields = WC_Compare_Categories_Fields_Data::get_fieldid_results($compare_category);
			if (is_array($compare_fields) && count($compare_fields)>0) {
				return true;
			}else {
				return false;
			}
		}else {
			return false;
		}
	}

	/**
	 * Add a product or variations of product into compare widget list
	 */
	function add_product_to_compare_list($product_id) {
		$product_list = WC_Compare_Functions::get_variations($product_id);
		if (count($product_list) < 1 && WC_Compare_Functions::check_product_activate_compare($product_id) && WC_Compare_Functions::check_product_have_cat($product_id)) $product_list = array($product_id);
		if (is_array($product_list) && count($product_list) > 0) {
			if (isset($_COOKIE['woo_compare_list']))
				$current_compare_list = (array) unserialize($_COOKIE['woo_compare_list']);
			else
				$current_compare_list = array();
			foreach ($product_list as $product_add) {
				if (!in_array($product_add, $current_compare_list)) {
					$current_compare_list[] = (int)$product_add;
				}
			}
			
			setcookie( "woo_compare_list", serialize($current_compare_list), 0, COOKIEPATH, COOKIE_DOMAIN, false, true );
		}
	}

	/**
	 * Get list product ids , variation ids
	 */
	function get_compare_list() {
		if (isset($_COOKIE['woo_compare_list']))
			$current_compare_list = (array) unserialize($_COOKIE['woo_compare_list']);
		else
			$current_compare_list = array();
		$return_compare_list = array();
		if (is_array($current_compare_list) && count($current_compare_list) > 0) {
			foreach ($current_compare_list as $product_id) {
				if (WC_Compare_Functions::check_product_activate_compare($product_id)) {
					$return_compare_list[] = (int)$product_id;
				}
			}
		}
		return $return_compare_list;
	}

	/**
	 * Get total products in complare list
	 */
	function get_total_compare_list() {
		if (isset($_COOKIE['woo_compare_list']))
			$current_compare_list = (array) unserialize($_COOKIE['woo_compare_list']);
		else
			$current_compare_list = array();
		$return_compare_list = array();
		if (is_array($current_compare_list) && count($current_compare_list) > 0) {
			foreach ($current_compare_list as $product_id) {
				if (WC_Compare_Functions::check_product_activate_compare($product_id)) {
					$return_compare_list[] = (int)$product_id;
				}
			}
		}
		return count($return_compare_list);
	}

	/**
	 * Remove a product out compare list
	 */
	function delete_product_on_compare_list($product_id) {
		if (isset($_COOKIE['woo_compare_list']))
			$current_compare_list = (array) unserialize($_COOKIE['woo_compare_list']);
		else
			$current_compare_list = array();
		$key = array_search($product_id, $current_compare_list);
		unset($current_compare_list[$key]);
		setcookie( "woo_compare_list", serialize($current_compare_list), 0, COOKIEPATH, COOKIE_DOMAIN, false, true );
	}

	/**
	 * Clear compare list
	 */
	function clear_compare_list() {
		setcookie( "woo_compare_list", serialize(array()), 0, COOKIEPATH, COOKIE_DOMAIN, false, true );
	}

	/**
	 * Get price of product, variation to show on popup compare
	 */
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
		if ($price > 0) {
			$output = woo_currency_display( $price, $args );
			return $output;
		}
	}

	/**
	 * Get compare widget on sidebar
	 */
	function get_compare_list_html_widget() {
		$compare_list = WC_Compare_Functions::get_compare_list();
		$html = '';
		if (is_array($compare_list) && count($compare_list)>0) {
			$html .= '<ul class="compare_widget_ul">';
			foreach ($compare_list as $product_id) {
				$html .= '<li class="compare_widget_item">';
				$html .= '<div class="compare_remove_column" style="float:right; margin-left:5px;"><a class="woo_compare_remove_product" rel="'.$product_id.'" style="cursor:pointer;"><img src="'.WOOCP_IMAGES_URL.'/compare_remove.png" border=0 /></a></div>';
				$html .= '<div class="compare_title_column"><a href="'.WC_Compare_Functions::get_product_url($product_id).'">'.WC_Compare_Functions::get_variation_name($product_id).'</a></div>';
				$html .= '</li>';
			}
			$html .= '</ul>';
			$html .= '<div class="compare_widget_action" style="margin-top:10px;"><a class="woo_compare_clear_all" style="cursor:pointer; float:left">'.__( 'Clear All', 'woo_cp' ).'</a> <input type="button" name="woo_compare_button_go" class="woo_compare_button_go" value="'.__( 'Compare', 'woo_cp' ).'" style="cursor:pointer; float:right" /><div style="clear:both"></div></div>';
		}else {
			$html .= '<div class="no_compare_list">'.__( 'You do not have any product to compare.', 'woo_cp' ).'</div>';
		}
		return $html;
	}

	/**
	 * Get compare list on popup
	 */
	function get_compare_list_html_popup() {
		$compare_list = WC_Compare_Functions::get_compare_list();
		$html = '';
		$product_cats = array();
		$products_fields = array();
		$products_prices = array();
		if (is_array($compare_list) && count($compare_list)>0) {
			$html .= '<table class="compare_popup_table" border="0" cellpadding="5" cellspacing="0" width="">';
			$html .= '<tr><td class="column_first first_row"></td>';
			foreach ($compare_list as $product_id) {
				$product_cat = get_post_meta( $product_id, '_woo_compare_category', true );
				$products_fields[$product_id] = WC_Compare_Categories_Fields_Data::get_fieldid_results($product_cat);
				if ($product_cat > 0) {
					$product_cats[] = $product_cat;
				}
				$html .= '<td class="first_row"><a class="woo_compare_popup_remove_product" rel="'.$product_id.'" style="cursor:pointer;"><img src="'.WOOCP_IMAGES_URL.'/compare_remove.png" border=0 /></a></td>';
			}
			$html .= '</tr>';
			$html .= '<tr class="row_1 row_product_detail"><td class="column_first"></td>';
			$i = 0;
			foreach ($compare_list as $product_id) {
				$i++;
				
				$current_db_version = get_option( 'woocommerce_db_version', null );
				if ( version_compare( $current_db_version, '2.0', '<' ) && null !== $current_db_version ) {
					$current_product = new WC_Product($product_id);
				} else {
					$current_product = get_product($product_id);
				}
				
				$product_name = WC_Compare_Functions::get_variation_name($product_id);
				
				$product_price = $current_product->get_price_html();
				
				/**
				 * Add code check show or hide price and add to cart button support for Woo Catalog Visibility Options plugin
				 */
				$show_add_to_cart = true;
				if (class_exists('WC_CVO_Visibility_Options')) {
					global $wc_cvo;
					/**
					 * Check show or hide price
					 */
					 if (($wc_cvo->setting('wc_cvo_prices') == 'secured' && !catalog_visibility_user_has_access()) || $wc_cvo->setting('wc_cvo_prices') == 'disabled') {
						 $product_price = '';
					 }
					 
					 /**
					 * Check show or hide add to cart button
					 */
					 if (($wc_cvo->setting('wc_cvo_atc') == 'secured' && !catalog_visibility_user_has_access()) || $wc_cvo->setting('wc_cvo_atc') == 'disabled') {
						 $show_add_to_cart = false;
					 }
				}
				$products_prices[$product_id] = $product_price;
				$image_src = WC_Compare_Functions::get_post_thumbnail($product_id, 220, 180);
				if (trim($image_src) == '') {
					$image_src = '<img alt="'.$product_name.'" src="'.woocommerce_placeholder_img_src().'" />';
				}
				$html .= '<td class="column_'.$i.'">';
				$html .= '<div class="compare_image_container">'.$image_src.'</div>';
				$html .= '<div class="compare_product_name">'.$product_name.'</div>';
				$html .= '<div class="compare_price">'.$products_prices[$product_id].'</div>';
				if ($show_add_to_cart && $current_product->is_in_stock() && $current_product->product_type != 'external' && trim($products_prices[$product_id]) != '') {
					$cart_url = add_query_arg('add-to-cart',$product_id, get_option('siteurl').'/?post_type=product');
					switch (get_post_type($product_id)) :
					case "product_variation" :
						$class 	= 'is_variation';
						$cart_url = WC_Compare_Functions::get_product_url($product_id);
					break;
				default :
					$class  = 'simple';
					break;
					endswitch;
					$html .= '<div class="compare_add_cart">';
					$html .= sprintf('<a href="%s" data-product_id="%s" class="button add_to_cart_button product_type_%s">%s</a>', $cart_url, $product_id, $class, __('Add to cart', 'woo_cp'));
					$html .= '</div>';
				}
				$html .= '</td>';
			}
			$html .= '</tr>';
			$product_cats = implode(",", $product_cats);
			$compare_fields = WC_Compare_Categories_Fields_Data::get_results('cat_id IN('.$product_cats.')', 'cf.cat_id ASC, cf.field_order ASC');
			if (is_array($compare_fields) && count($compare_fields)>0) {
				$j = 1;
				foreach ($compare_fields as $field_data) {
					$j++;
					$html .= '<tr class="row_'.$j.'">';
					if (trim($field_data->field_unit) != '')
						$html .= '<td class="column_first">'.stripslashes($field_data->field_name).' ('.trim(stripslashes($field_data->field_unit)).')</td>';
					else
						$html .= '<td class="column_first">'.stripslashes($field_data->field_name).'</td>';
					$i = 0;
					foreach ($compare_list as $product_id) {
						$i++;
						if (in_array($field_data->id, $products_fields[$product_id])) {
							$field_value = get_post_meta( $product_id, '_woo_compare_'.$field_data->field_key, true );
							if (is_serialized($field_value)) $field_value = maybe_unserialize($field_value);
							if (is_array($field_value) && count($field_value) > 0) $field_value = implode(', ', $field_value);
							elseif (is_array($field_value) && count($field_value) < 0) $field_value = __('N/A', 'woo_cp');
							if (trim($field_value) == '') $field_value = __('N/A', 'woo_cp');
						}else {
							$field_value = __('N/A', 'woo_cp');
						}
						$html .= '<td class="column_'.$i.'"><div class="compare_value compare_'.$field_data->field_key.'">'.$field_value.'</div></td>';
					}
					$html .= '</tr>';
					if ($j==2) $j=0;
				}
				$j++;
				if ($j>2) $j=1;
				$html .= '<tr class="row_'.$j.' row_end"><td class="column_first"></td>';
				$i = 0;
				foreach ($compare_list as $product_id) {
					$i++;
					$html .= '<td class="column_'.$i.'">';
					$html .= '<div class="compare_price">'.$products_prices[$product_id].'</div>';
					$html .= '</td>';
				}
			}
			$html .= '</table>';
		}else {
			$html .= '<div class="no_compare_list">'.__( 'You do not have any product to compare.', 'woo_cp' ).'</div>';
		}
		return $html;
	}

	function add_meta_all_products() {

		// Add deactivate compare feature meta for all products when activate this plugin
		$have_deactivate_meta = get_posts(array('numberposts' => -1, 'post_type' => array('product', 'product_variation'), 'post_status' => array('publish', 'private'), 'meta_key' => '_woo_deactivate_compare_feature'));
		$have_ids = array();
		if (is_array($have_deactivate_meta) && count($have_deactivate_meta) > 0) {
			foreach ($have_deactivate_meta as $product) {
				$have_ids[] = $product->ID;
			}
		}
		if (is_array($have_ids) && count($have_ids) > 0) {
			$no_deactivate_meta = get_posts(array('numberposts' => -1, 'post_type' => array('product', 'product_variation'), 'post_status' => array('publish', 'private'), 'post__not_in' => $have_ids));
		}else {
			$no_deactivate_meta = get_posts(array('numberposts' => -1, 'post_type' => array('product', 'product_variation'), 'post_status' => array('publish', 'private')));
		}
		if (is_array($no_deactivate_meta) && count($no_deactivate_meta) > 0) {
			foreach ($no_deactivate_meta as $product) {
				add_post_meta($product->ID, '_woo_deactivate_compare_feature', '');
			}
		}

		// Add deactivate compare feature meta for all products when activate this plugin
		$have_compare_category_meta = get_posts(array('numberposts' => -1, 'post_type' => array('product', 'product_variation'), 'post_status' => array('publish', 'private'), 'meta_key' => '_woo_compare_category_name'));
		$have_ids = array();
		if (is_array($have_compare_category_meta) && count($have_compare_category_meta) > 0) {
			foreach ($have_compare_category_meta as $product) {
				$have_ids[] = $product->ID;
			}
		}
		if (is_array($have_ids) && count($have_ids) > 0) {
			$no_compare_category_meta = get_posts(array('numberposts' => -1, 'post_type' => array('product', 'product_variation'), 'post_status' => array('publish', 'private'), 'post__not_in' => $have_ids));
		}else {
			$no_compare_category_meta = get_posts(array('numberposts' => -1, 'post_type' => array('product', 'product_variation'), 'post_status' => array('publish', 'private')));
		}
		if (is_array($no_compare_category_meta) && count($no_compare_category_meta) > 0) {
			foreach ($no_compare_category_meta as $product) {
				add_post_meta($product->ID, '_woo_compare_category_name', '');
			}
		}

		// Add compare category name into product have compare category id
		$have_compare_category_id_meta = get_posts(array('numberposts' => -1, 'post_type' => array('product', 'product_variation'), 'post_status' => array('publish', 'private'), 'meta_key' => '_woo_compare_category'));
		if (is_array($have_compare_category_id_meta) && count($have_compare_category_id_meta) > 0) {
			foreach ($have_compare_category_id_meta as $product) {
				$compare_category = get_post_meta( $product->ID, '_woo_compare_category', true );
				$category_data = WC_Compare_Categories_Data::get_row($compare_category);
				@update_post_meta($product->ID, '_woo_compare_category_name', stripslashes($category_data->category_name));
			}
		}

	}
	
	function auto_assign_master_category_to_all_products() {
		$master_category = 'Master Category';
		$master_category_id = get_option('master_category_compare');
		$all_products = get_posts(array('numberposts' => -1, 'post_type' => array('product', 'product_variation'), 'post_status' => array('publish', 'private')));		
		if (is_array($all_products) && count($all_products) > 0) {
			foreach ($all_products as $product) {
				update_post_meta( $product->ID, '_woo_compare_category', $master_category_id );
				update_post_meta( $product->ID, '_woo_compare_category_name', $master_category);
			}
		}

	}

	function get_post_thumbnail($postid=0, $width=220, $height=180) {
		$mediumSRC = '';
		// Get the product ID if none was passed
		if ( empty( $postid ) )
			$postid = get_the_ID();

		// Load the product
		$product = get_post( $postid );

		if (has_post_thumbnail($postid)) {
			$thumbid = get_post_thumbnail_id($postid);
			$attachmentArray = wp_get_attachment_image_src($thumbid, array(0 => $width, 1 => $height), false);
			$mediumSRC = $attachmentArray[0];
			if (trim($mediumSRC != '')) {
				return '<img src="'.$mediumSRC.'" />';
			}
		}
		if (trim($mediumSRC == '')) {
			$args = array( 'post_parent' => $postid , 'numberposts' => 1, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'DESC', 'orderby' => 'ID', 'post_status' => null);
			$attachments = get_posts($args);
			if ($attachments) {
				foreach ( $attachments as $attachment ) {
					$mediumSRC = wp_get_attachment_image( $attachment->ID, array(0 => $width, 1 => $height), true );
					break;
				}
			}
		}

		if (trim($mediumSRC == '')) {
			// Get ID of parent product if one exists
			if ( !empty( $product->post_parent ) )
				$postid = $product->post_parent;

			if (has_post_thumbnail($postid)) {
				$thumbid = get_post_thumbnail_id($postid);
				$attachmentArray = wp_get_attachment_image_src($thumbid, array(0 => $width, 1 => $height), false);
				$mediumSRC = $attachmentArray[0];
				if (trim($mediumSRC != '')) {
					return '<img src="'.$mediumSRC.'" />';
				}
			}
			if (trim($mediumSRC == '')) {
				$args = array( 'post_parent' => $postid , 'numberposts' => 1, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'DESC', 'orderby' => 'ID', 'post_status' => null);
				$attachments = get_posts($args);
				if ($attachments) {
					foreach ( $attachments as $attachment ) {
						$mediumSRC = wp_get_attachment_image( $attachment->ID, array(0 => $width, 1 => $height), true );
						break;
					}
				}
			}
		}
		return $mediumSRC;
	}
	
	function modify_url($mod=array()){
		$url = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https://' : 'http://';
 		$url .= isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : getenv('HTTP_HOST');
 		$url .= isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : getenv('REQUEST_URI');
		
		$query = explode("&", $_SERVER['QUERY_STRING']);
		if (!$_SERVER['QUERY_STRING']) {
			$queryStart = "?";
			foreach($mod as $key => $value){
				if($value != ''){
					$url .= $queryStart.$key.'='.$value;
					$queryStart = "&";
				}
			}
		} else {
		// modify/delete data
			foreach($query as $q){
				list($key, $value) = explode("=", $q);
				if(array_key_exists($key, $mod)){
					if($mod[$key]){
						$url = preg_replace('/'.$key.'='.$value.'/', $key.'='.$mod[$key], $url);
					}else{
						$url = preg_replace('/&?'.$key.'='.$value.'/', '', $url);
					}
				}
			}
			// add new data
			foreach($mod as $key => $value){
				if($value && !preg_match('/'.$key.'=/', $url)){
					$url .= '&'.$key.'='.$value;
				}
			}
		}
		return $url;
	}
	
	function printPage($link, $total = 0,$currentPage = 1,$div = 3,$rows = 5, $li = false, $a_class= ''){
		if(!$total || !$rows || !$div || $total<=$rows) return false;
		$nPage = floor($total/$rows) + (($total%$rows)?1:0);
		$nDiv  = floor($nPage/$div) + (($nPage%$div)?1:0);	
		$currentDiv = floor(($currentPage-1)/$div) ;	
		$sPage = '';	
		if($currentDiv) {	
			if($li){
				$sPage .= '<li><span class="pagenav"><a title="" class="page-numbers '.$a_class.'" href="'.add_query_arg('pp', 1, $link).'">&laquo;</a></span></li>';	
				$sPage .= '<li><span class="pagenav"><a title="" class="page-numbers '.$a_class.'" href="'.add_query_arg('pp', $currentDiv*$div, $link).'">'.__("Back", "woo_cp").'</a></span></li>';	
			}else{
				$sPage .= '<a title="" class="page-numbers '.$a_class.'" href="'.add_query_arg('pp', 1, $link).'">&laquo;</a> ';	
				$sPage .= '<a title="" class="page-numbers '.$a_class.'" href="'.add_query_arg('pp', $currentDiv*$div, $link).'">'.__("Back", "woo_cp").'</a> ';	
			}
		}
		$count =($nPage<=($currentDiv+1)*$div)?($nPage-$currentDiv*$div):$div;	
		for($i=1;$i<=$count;$i++){	
			$page = ($currentDiv*$div + $i);	
			if($li){
				$sPage .= '<li '.(($page==$currentPage)? 'class="current"':'class="page-numbers"').'><span class="pagenav"><a title="" href="'.add_query_arg('pp', ($currentDiv*$div + $i ), $link).'" '.(($page==$currentPage)? 'class="current '.$a_class.'"':'class="page-numbers '.$a_class.'"').'>'.$page.'</a></span></li>';
			}else{
				$sPage .= '<a title="" href="'.add_query_arg('pp', ($currentDiv*$div + $i ), $link).'" '.(($page==$currentPage)? 'class="current '.$a_class.'"':'class="page-numbers '.$a_class.'"').'>'.$page.'</a> ';
			}
		}	
		if($currentDiv < $nDiv - 1){	
			if($li){	
				$sPage .= '<li><span class="pagenav"><a title="" class="page-numbers '.$a_class.'" href="'.add_query_arg('pp', ((($currentDiv+1)*$div)+1), $link).'">'.__("Next", "woo_cp").'</a></span></li>';	
				$sPage .= '<li><span class="pagenav"><a title="" class="page-numbers '.$a_class.'" href="'.add_query_arg('pp', (($nDiv*$div )-2), $link).'">&raquo;</a></span></li>';	
			}else{
				$sPage .= '<a title="" class="page-numbers '.$a_class.'" href="'.add_query_arg('pp', ((($currentDiv+1)*$div)+1), $link).'">'.__("Next", "woo_cp").'</a> ';	
				$sPage .= '<a title="" class="page-numbers '.$a_class.'" href="'.add_query_arg('pp', (($nDiv*$div )-2), $link).'">&raquo;</a>';	
			}
		}	
		return 	$sPage;	
	}
	
	function compare_extension() {
		$html = '';
		$html .= '<div id="compare_extensions">'.__('See more quality WooCommerce plugins at the', 'woo_cp').' <a target="_blank" href="http://a3rev.com/product-category/woocommerce/">'.__('WooCommerce extensions', 'woo_cp').'</a>.</div>';
		return $html;	
	}
	
	function categories_extension() {
		$html = '';
		$html .= '<div class="upgrade_extensions">'.__('Your Product categories have been auto created as Compare Categories. All of your sites Parent Product Variations have been auto added as Compare Features to the Master category. Visit the plugins', 'woo_cp').' <a href="http://docs.a3rev.com/user-guides/woocommerce/compare-products/" target="_blank">'.__('Documents', 'woo_cp').'</a> '.__('to see how to use Compare categories and Compare features. Upgrade to the', 'woo_cp').' <a target="_blank" href="'.WOOCP_AUTHOR_URI.'">'.__('Pro Version', 'woo_cp').'</a> '.__('to activate Compare categories.', 'woo_cp').'</div>';
		return $html;	
	}
	
	function create_category_extension() {
		$html = '';
		$html .= '<div class="upgrade_extensions"><a href="http://a3rev.com/shop/" target="_blank" style="float:left; margin-right:10px;"><img src="'.WOOCP_IMAGES_URL.'/logo_a3blue.png" /></a>'.__('Please upgrade to the', 'woo_cp').' <a target="_blank" href="'.WOOCP_AUTHOR_URI.'">'.__('Pro Version', 'woo_cp').'</a> '.__('to activate the power of Compare Categories. Find out more', 'woo_cp').' <a href="http://docs.a3rev.com/user-guides/woocommerce/compare-products/" target="_blank">'.__('here.', 'woo_cp').'</a></div>';
		return $html;	
	}
	
	function products_tab_extension() {
		$html = '';
		$html .= '<div class="upgrade_extensions products_tab_extension"><a href="http://a3rev.com/shop/" target="_blank" style="float:left; margin-right:10px;"><img src="'.WOOCP_IMAGES_URL.'/logo_a3blue.png" /></a>'.__('Make managing the Compare products feature across your entire catalog a breeze. Upgrade to the', 'woo_cp').' <a target="_blank" href="'.WOOCP_AUTHOR_URI.'">'.__('Pro Version', 'woo_cp').'</a> '.__('to activate this feature.', 'woo_cp').'</div>';
		return $html;	
	}
	
	function other_plugins_notice() {
		$html = '';
		$html .= '<div id="a3rev_plugins_notice">';
		$html .= '<a href="http://a3rev.com/shop/" target="_blank" style="float:right;margin-top:5px; margin-left:10px;" ><img src="'.WOOCP_IMAGES_URL.'/a3logo.png" /></a>';
		$html .= '<h3>'.__('Upgrade to Compare Products Pro', 'woo_cp').'</h3>';
		$html .= '<p>'.__("Visit the", 'woo_cp').' <a href="http://a3rev.com/shop/woocommerce-compare-products/" target="_blank">'.__("a3rev website", 'woo_cp').'</a> '.__("to see all the extra features the Pro version of this plugin offers, like the Compare categories that you can see inside the yellow box. All of your Product Categories have been auto created here as Compare categories. The Lite Version uses only 1 category - The Master category. All of your product attributes have been auto created as Compare features under the Master category.", 'woo_cp').'</p>';
		$html .= '<h3>'.__('Plugin Documentation', 'woo_cp').'</h3>';
		$html .= '<p>'.__('All of our plugins have comprehensive online documentation. Please refer to the plugins docs before raising a support request', 'woo_cp').'. <a href="http://docs.a3rev.com/user-guides/woocommerce/compare-products/" target="_blank">'.__('Visit the a3rev wiki.', 'woo_cp').'</a></p>';
		$html .= '<h3>'.__('More a3rev Quality Plugins', 'woo_cp').'</h3>';
		$html .= '<p>'.__('Below is a list of the a3rev plugins that are available for free download from wordpress.org', 'woo_cp').'</p>';
		$html .= '<h3>'.__('WooCommerce Plugins', 'woo_cp').'</h3>';
		$html .= '<p>';
		$html .= '<ul style="padding-left:10px;">';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/woocommerce-dynamic-gallery/" target="_blank">'.__('WooCommerce Dynamic Products Gallery', 'woo_cp').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/woocommerce-predictive-search/" target="_blank">'.__('WooCommerce Predictive Search', 'woo_cp').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/woocommerce-compare-products/" target="_blank">'.__('WooCommerce Compare Products', 'woo_cp').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/woo-widget-product-slideshow/" target="_blank">'.__('WooCommerce Widget Product Slideshow', 'woo_cp').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/woocommerce-email-inquiry-cart-options/" target="_blank">'.__('WooCommerce Email Inquiry & Cart Options', 'woo_cp').'</a></li>';
		$html .= '</ul>';
		$html .= '</p>';
		$html .= '<h3>'.__('WordPress Plugins', 'woo_cp').'</h3>';
		$html .= '<p>';
		$html .= '<ul style="padding-left:10px;">';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/wp-email-template/" target="_blank">'.__('WordPress Email Template', 'woo_cp').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/page-views-count/" target="_blank">'.__('Page View Count', 'woo_cp').'</a></li>';
		$html .= '</ul>';
		$html .= '</p>';
		$html .= '<h3>'.__('WP e-Commerce Plugins', 'woo_cp').'</h3>';
		$html .= '<p>';
		$html .= '<ul style="padding-left:10px;">';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/wp-e-commerce-dynamic-gallery/" target="_blank">'.__('WP e-Commerce Dynamic Gallery', 'woo_cp').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/wp-e-commerce-predictive-search/" target="_blank">'.__('WP e-Commerce Predictive Search', 'woo_cp').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/wp-ecommerce-compare-products/" target="_blank">'.__('WP e-Commerce Compare Products', 'woo_cp').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/wp-e-commerce-catalog-visibility-and-email-inquiry/" target="_blank">'.__('WP e-Commerce Catalog Visibility & Email Inquiry', 'woo_cp').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/wp-e-commerce-grid-view/" target="_blank">'.__('WP e-Commerce Grid View', 'woo_cp').'</a></li>';
		$html .= '</ul>';
		$html .= '</p>';
		$html .= '<h3>'.__('Help spread the Word about this plugin', 'woo_cp').'</h3>';
		$html .= '<p>'.__("Things you can do to help others find this plugin", 'woo_cp');
		$html .= '<ul style="padding-left:10px;">';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/woocommerce-compare-products/" target="_blank">'.__('Rate this plugin 5', 'woo_cp').' <img src="'.WOOCP_IMAGES_URL.'/stars.png" align="top" /> '.__('on WordPress.org', 'woo_cp').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/woocommerce-compare-products/" target="_blank">'.__('Mark the plugin as a fourite', 'woo_cp').'</a></li>';
		$html .= '</ul>';
		$html .= '</p>';
		$html .= '</div>';
		return $html;	
	}
}
?>