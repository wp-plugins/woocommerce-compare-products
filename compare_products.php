<?php
/*
Plugin Name: WooCommerce Compare Products LITE
Plugin URI: http://a3rev.com/shop/woocommerce-compare-products/
Description: Compare Products uses your existing WooCommerce Product Categories and Product Attributes to create Compare Product Features for all your products. A sidebar Compare basket is created that users add products to and view the Comparison in a Compare this pop-up screen.
Version: 2.0.3
Author: A3 Revolution
Author URI: http://www.a3rev.com/
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, <http://www.gnu.org/licenses/>.
*/

/*
	WooCommerce Compare Products LITE. Plugin for the WooCommerce plugin.
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
	define( 'WOOCP_JS_URL',  WOOCP_URL . '/assets/js' );
	define( 'WOOCP_IMAGES_URL',  WOOCP_URL . '/assets/images' );
	if(!defined("WOOCP_AUTHOR_URI"))
    	define("WOOCP_AUTHOR_URI", "http://a3rev.com/shop/woocommerce-compare-products/");

	include 'classes/class-wc-compare-filter.php';
	include 'classes/data/class-wc-compare-data.php';
	include 'classes/data/class-wc-compare-categories-data.php';
	include 'classes/data/class-wc-compare-categories-fields-data.php';
	include 'classes/class-wc-compare-metabox.php';
	include 'widgets/compare_widget.php';

	include 'admin/classes/class-wc-compare-settings.php';
	include 'admin/classes/class-wc-compare-categories.php';
	include 'admin/classes/class-wc-compare-fields.php';
	include 'admin/classes/class-wc-compare-products.php';

	include 'classes/class-wc-compare-functions.php';
	
	include('classes/class-wc-compare-upgrade.php');

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