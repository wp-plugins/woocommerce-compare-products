<?php
/*
Plugin Name: WooCommerce Compare Products LITE
Description: Compare Products uses your existing WooCommerce Product Categories and Product Attributes to create Compare Product Features for all your products. A sidebar Compare basket is created that users add products to and view the Comparison in a Compare this pop-up screen.
Version: 2.1.0
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
	define( 'WOOCP_URL', WP_CONTENT_URL . '/plugins/' . WOOCP_FOLDER );
	define( 'WOOCP_DIR', WP_CONTENT_DIR . '/plugins/' . WOOCP_FOLDER );
	define( 'WOOCP_JS_URL',  WOOCP_URL . '/assets/js' );
	define( 'WOOCP_CSS_URL',  WOOCP_URL . '/assets/css' );
	define( 'WOOCP_IMAGES_URL',  WOOCP_URL . '/assets/images' );
	if(!defined("WOOCP_AUTHOR_URI"))
    	define("WOOCP_AUTHOR_URI", "http://a3rev.com/shop/woocommerce-compare-products/");

	include 'classes/class-wc-compare-filter.php';
	include 'classes/data/class-wc-compare-data.php';
	include 'classes/data/class-wc-compare-categories-data.php';
	include 'classes/data/class-wc-compare-categories-fields-data.php';
	include 'classes/class-wc-compare-metabox.php';
	include 'uploader/class-wc-compare-uploader.php';
	include 'widgets/compare_widget.php';

	include 'admin/classes/product_page-panel/class-wc-compare-product-page-settings.php';
	include 'admin/classes/product_page-panel/class-wc-compare-product-page-button-style.php';
	include 'admin/classes/product_page-panel/class-wc-compare-product-page-view-compare-style.php';
	include 'admin/classes/product_page-panel/class-wc-compare-product-page-tab.php';
	include 'admin/classes/class-wc-compare-product-page-panel.php';
	
	include 'admin/classes/class-wc-compare-categories.php';
	include 'admin/classes/class-wc-compare-fields.php';
	include 'admin/classes/class-wc-compare-products.php';
	
	include 'admin/classes/widget-panel/class-wc-compare-widget-style.php';
	include 'admin/classes/widget-panel/class-wc-compare-widget-title-style.php';
	include 'admin/classes/widget-panel/class-wc-compare-widget-button-style.php';
	include 'admin/classes/widget-panel/class-wc-compare-widget-clear-all-style.php';
	include 'admin/classes/widget-panel/class-wc-compare-thumbnail-style.php';
	include 'admin/classes/class-wc-compare-widget-style-panel.php';

	include 'admin/classes/grid_view-panel/class-wc-compare-grid-view-settings.php';
	include 'admin/classes/grid_view-panel/class-wc-compare-grid-view-button-style.php';
	include 'admin/classes/grid_view-panel/class-wc-compare-grid-view-view-compare-style.php';
	include 'admin/classes/class-wc-compare-grid-view-panel.php';
	
	include 'admin/classes/comparison_page-panel/class-wc-compare-comparison-page-global-settings.php';
	include 'admin/classes/comparison_page-panel/class-wc-compare-page-style.php';
	include 'admin/classes/comparison_page-panel/class-wc-compare-table-style.php';
	include 'admin/classes/comparison_page-panel/class-wc-compare-table-content-style.php';
	include 'admin/classes/comparison_page-panel/class-wc-compare-price-style.php';
	include 'admin/classes/comparison_page-panel/class-wc-compare-addtocart-style.php';
	include 'admin/classes/comparison_page-panel/class-wc-compare-viewcart-style.php';
	include 'admin/classes/comparison_page-panel/class-wc-compare-print-message-style.php';
	include 'admin/classes/comparison_page-panel/class-wc-compare-print-button-style.php';
	include 'admin/classes/comparison_page-panel/class-wc-compare-close-window-button-style.php';
	include 'admin/classes/class-wc-compare-page-panel.php';

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