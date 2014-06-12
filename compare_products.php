<?php
/*
Plugin Name: WooCommerce Compare Products LITE
Description: Compare Products uses your existing WooCommerce Product Categories and Product Attributes to create Compare Product Features for all your products. A sidebar Compare basket is created that users add products to and view the Comparison in a Compare this pop-up screen.
Version: 2.1.9.2
Author: A3 Revolution
Author URI: http://www.a3rev.com/
License: This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007

	WooCommerce Compare Products PRO. Plugin for the WooCommerce plugin.
	Copyright © 2011 A3 Revolution

	A3 Revolution
	admin@a3rev.com
	PO Box 1170
	Gympie 4570
	QLD Australia
*/


	define( 'WOOCP_FILE_PATH', dirname( __FILE__ ) );
	define( 'WOOCP_DIR_NAME', basename( WOOCP_FILE_PATH ) );
	define( 'WOOCP_FOLDER', dirname( plugin_basename( __FILE__ ) ) );
	define(	'WOOCP_NAME', plugin_basename(__FILE__) );
	define( 'WOOCP_URL', untrailingslashit( plugins_url( '/', __FILE__ ) ) );
	define( 'WOOCP_DIR', WP_CONTENT_DIR . '/plugins/' . WOOCP_FOLDER );
	define( 'WOOCP_JS_URL',  WOOCP_URL . '/assets/js' );
	define( 'WOOCP_CSS_URL',  WOOCP_URL . '/assets/css' );
	define( 'WOOCP_IMAGES_URL',  WOOCP_URL . '/assets/images' );
	if(!defined("WOOCP_AUTHOR_URI"))
    	define("WOOCP_AUTHOR_URI", "http://a3rev.com/shop/woocommerce-compare-products/");
	
	include('admin/admin-ui.php');
	include('admin/admin-interface.php');
	
	include('admin/admin-pages/admin-product-comparison-page.php');
	
	include('admin/admin-init.php');
	
	// Old code
	include 'old/class-wc-compare-grid-view-settings.php';
	
	include 'classes/class-wc-compare-filter.php';
	include 'classes/data/class-wc-compare-data.php';
	include 'classes/data/class-wc-compare-categories-data.php';
	include 'classes/data/class-wc-compare-categories-fields-data.php';
	include 'classes/class-wc-compare-metabox.php';
	include 'widgets/compare_widget.php';
	
	include 'admin/classes/class-wc-compare-categories.php';
	include 'admin/classes/class-wc-compare-fields.php';
	include 'admin/classes/class-wc-compare-features-panel.php';
	include 'admin/classes/class-wc-compare-products.php';

	include 'classes/class-wc-compare-functions.php';
	
	// Editor
	include 'tinymce3/tinymce.php';

	include 'admin/compare_init.php';
	
	/**
	 * Show compare button
	 */
	function woo_add_compare_button($product_id='', $echo=false) {
		$html = WC_Compare_Hook_Filter::add_compare_button($product_id);
		if ($echo) echo $html;
		else return $html;
	}

	/**
	 * Show compare fields panel
	 */
	function woo_show_compare_fields($product_id='', $echo=false) {
		$html = WC_Compare_Hook_Filter::show_compare_fields($product_id);
		if ($echo) echo $html;
		else return $html;
	}

	/**
	 * Call when the plugin is activated
	 */
	register_activation_hook(__FILE__, 'woocp_install');
	
	function woo_compare_lite_product_uninstall(){
		if ( get_option('woo_compare_product_lite_clean_on_deletion') == 1 ) {
			
			delete_option( 'woo_compare_product_page_settings' );
			delete_option( 'woo_compare_product_page_button_style' );
			delete_option( 'woo_compare_product_page_tab' );
			delete_option( 'woo_compare_product_page_view_compare_style' );
			delete_option( 'woo_compare_widget_clear_all_style' );
			delete_option( 'woo_compare_widget_button_style' );
			delete_option( 'woo_compare_widget_style' );
			delete_option( 'woo_compare_widget_thumbnail_style' );
			delete_option( 'woo_compare_widget_title_style' );
			delete_option( 'woo_compare_grid_view_button_style' );
			delete_option( 'woo_compare_grid_view_settings' );
			delete_option( 'woo_compare_gridview_view_compare_style' );
			delete_option( 'woo_compare_addtocart_style' );
			delete_option( 'woo_compare_close_window_button_style' );
			delete_option( 'woo_compare_comparison_page_global_settings' );
			delete_option( 'woo_compare_page_style' );
			delete_option( 'woo_compare_print_page_settings' );
			delete_option( 'woo_compare_product_prices_style' );
			delete_option( 'woo_compare_table_content_style' );
			delete_option( 'woo_compare_table_style' );
			delete_option( 'woo_compare_viewcart_style' );
			
			delete_option( 'woo_compare_addtocart_success' );
			delete_option( 'woo_compare_logo' );
			delete_option( 'woo_compare_gridview_product_success_icon' );
			delete_option( 'woo_compare_product_success_icon' );
			delete_option( 'woo_compare_basket_icon' );
			
			delete_option( 'woo_compare_product_lite_clean_on_deletion' );
			
			delete_post_meta_by_key('_woo_deactivate_compare_feature');
			delete_post_meta_by_key('_woo_compare_category');
			delete_post_meta_by_key('_woo_compare_category_name');
		
			wp_delete_post( get_option('product_compare_id') , true );
			
			global $wpdb;
			$wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'woo_compare_fields');
			$wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'woo_compare_categories');
			$wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'woo_compare_cat_fields');
		}
	}
	
	if ( get_option('woo_compare_product_lite_clean_on_deletion') == 1 ) {
		register_uninstall_hook( __FILE__, 'woo_compare_lite_product_uninstall' );
	}
