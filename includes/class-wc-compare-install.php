<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WooCommerce Compare Install Class
 *
 */
class WC_Compare_Install
{
	/**
	 * Init.
	 */
	public function __construct() {
		
		add_action( 'admin_init', array( $this, 'automatic_add_compare_categories' ) );
		add_action( 'admin_init', array( $this, 'automatic_add_features' ) );
		add_action( 'admin_init', array( $this, 'add_meta_all_products' ) );
		add_action( 'admin_init', array( $this, 'automatic_add_widget_to_sidebar' ) );
	}
	
	/**
	 * Automatic Set all Product Categories as Compare Categories
	 *
	 */
	public function automatic_add_compare_categories() {
		$terms = get_terms("product_cat", array('hide_empty' => 0));
		if ( count($terms) > 0 ) {
			foreach ($terms as $category_product) {
				$check_existed = WC_Compare_Categories_Data::get_count("category_name='".trim(addslashes($category_product->name))."'");
				if ($check_existed < 1 ) {
					WC_Compare_Categories_Data::insert_row(array('category_name' => trim(addslashes($category_product->name))));
				}
			}
		}
	}
	
	/**
	 * Automatic Set all Product Attribute as Compare Features
	 *
	 */
	public function automatic_add_features() {
		$current_db_version = get_option( 'woocommerce_db_version', null );
		if ( version_compare( $current_db_version, '2.1.0', '<' ) && null !== $current_db_version ) {
			global $woocommerce;
			$top_variations = $woocommerce->get_attribute_taxonomies();
		} else {
			$top_variations = wc_get_attribute_taxonomies();
		}
		if ( $top_variations ) {
			foreach ($top_variations as $top_variation) {
				$check_existed = WC_Compare_Data::get_count("field_name='".trim(addslashes($top_variation->attribute_label))."'");
				if ($check_existed < 1 ) {
					$child_variations = get_terms( ( ( version_compare( $current_db_version, '2.1.0', '<' ) && null !== $current_db_version ) ? $woocommerce->attribute_taxonomy_name($top_variation->attribute_name) : wc_attribute_taxonomy_name($top_variation->attribute_name) ) , array('parent' => 0, 'hide_empty' => 0, 'hierarchical' => 0) );
					$default_value = '';
					if ( count($child_variations) > 0 ) {
						$line = '';
						foreach ($child_variations as $child_variation) {
							$default_value .= $line.addslashes($child_variation->name);
							$line = '
';
						}
					}
					if ( trim($default_value) != '')
						$feature_id = WC_Compare_Data::insert_row(array('field_name' => trim(addslashes($top_variation->attribute_label)), 'field_type' => 'checkbox', 'field_unit' => '', 'default_value' => $default_value) );
					else
						$feature_id = WC_Compare_Data::insert_row(array('field_name' => trim(addslashes($top_variation->attribute_label)), 'field_type' => 'input-text', 'field_unit' => '', 'default_value' => '') );
				}
			}
		}
	}
	
	public function add_meta_all_products() {

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
	
	public function automatic_add_widget_to_sidebar() {
		$add_to_sidebars = array('primary', 'primary-widget-area', 'sidebar-1');
		$widget_name = 'woo_compare_widget';
		$sidebar_options = get_option('sidebars_widgets');
		$compare_widget = get_option('widget_'.$widget_name);
		$have_widget = false;
		foreach ($sidebar_options as $siderbar_name => $sidebar_widgets) {
			if ($siderbar_name == 'wp_inactive_widgets') continue;
			if (is_array($sidebar_widgets) && count($sidebar_widgets) > 0) {
				foreach ($sidebar_widgets as $sidebar_widget) {
					if (stristr($sidebar_widget, $widget_name) !== false) {
						$have_widget = true;
						break;
					}
				}
			}
			if ($have_widget) break;
		}
		if (!$have_widget) {
			if (!is_array($compare_widget)) $compare_widget = array();
			$count = count($compare_widget)+1;
			$added_widget = false;
			$new_sidebar_options = $sidebar_options;
			foreach ($add_to_sidebars as $sidebar_name) {
				if (isset($sidebar_options[$sidebar_name])) {
					$sidebar_options[$sidebar_name][] = $widget_name.'-'.$count;
					$added_widget = true;
					break;
				}
			}
			if (!$added_widget) {
				foreach ($new_sidebar_options as $siderbar_name => $sidebar_widgets) {
					if ($siderbar_name == 'wp_inactive_widgets') continue;
					$sidebar_options[$siderbar_name][] = $widget_name.'-'.$count;
					break;
				}
			}

			// add widget to sidebar:
			$compare_widget[$count] = array(
				'title' => ''
			);
			update_option('sidebars_widgets', $sidebar_options);
			update_option('widget_'.$widget_name, $compare_widget);
		}
	}
	
}

return new WC_Compare_Install();
?>