<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * Install Database, settings option and auto add widget to sidebar
 */
function woocp_install() {
	update_option('a3rev_woocp_pro_version', '2.2.0');
	update_option('a3rev_woocp_lite_version', '2.1.9.4');
	$product_compare_id = WC_Compare_Functions::create_page( esc_sql( 'product-comparison' ), '', __('Product Comparison', 'woo_cp'), '[product_comparison_page]' );
	update_option('product_compare_id', $product_compare_id);
	
	// Set Settings Default from Admin Init
	global $wc_compare_admin_init;
	$wc_compare_admin_init->set_default_settings();
	
	WC_Compare_Data::install_database();
	WC_Compare_Categories_Data::install_database();
	WC_Compare_Categories_Fields_Data::install_database();
	
	update_option('a3rev_woocp_just_installed', true);
}

update_option('a3rev_woocp_plugin', 'woo_compare');

if ( is_admin() ) {
	
	// Includes files for Dashboard
	include 'classes/class-wc-compare-categories.php';
	include 'classes/class-wc-compare-fields.php';
	include 'classes/class-wc-compare-features-panel.php';
	include 'classes/class-wc-compare-products.php';
	
	include_once( WOOCP_DIR. '/classes/class-wc-compare-categories.php' );
	include_once( WOOCP_DIR. '/classes/class-wc-compare-features.php' );
	
	include_once ( WOOCP_DIR. '/classes/class-wc-compare-metabox.php' );	
	
	// Editor
	include_once ( WOOCP_DIR. '/tinymce3/tinymce.php' );
	
}

function woocp_init() {
	if ( get_option('a3rev_woocp_just_installed') ) {
		delete_option('a3rev_woocp_just_installed');
		
		update_option( 'a3rev_woocp_install_default_data_start', true );
		wp_redirect( admin_url( 'admin.php?page=woo-compare-features', 'relative' ) );
		exit;
	}
	
	if ( get_option( 'a3rev_woocp_install_default_data_start' ) ) {
		delete_option( 'a3rev_woocp_install_default_data_start' );
		include_once( WOOCP_DIR. '/includes/class-wc-compare-install.php' );
	}
	load_plugin_textdomain( 'woo_cp', false, WOOCP_FOLDER.'/languages' );
}

// Add language
add_action('init', 'woocp_init');

// Add custom style to dashboard
add_action( 'admin_enqueue_scripts', array( 'WC_Compare_Hook_Filter', 'a3_wp_admin' ) );

// Add admin sidebar menu css
add_action( 'admin_enqueue_scripts', array( 'WC_Compare_Hook_Filter', 'admin_sidebar_menu_css' ) );

// Plugin loaded
add_action( 'plugins_loaded', array( 'WC_Compare_Functions', 'plugins_loaded' ), 8 );

// Add text on right of Visit the plugin on Plugin manager page
add_filter( 'plugin_row_meta', array('WC_Compare_Hook_Filter', 'plugin_extra_links'), 10, 2 );

// Need to call Admin Init to show Admin UI
global $wc_compare_admin_init;
$wc_compare_admin_init->init();

// Set nocache constants to comparision page
add_action('init', array( 'WC_Compare_Hook_Filter', 'nocache_ours_page' ), 0 );

// Add upgrade notice to Dashboard pages
add_filter( $wc_compare_admin_init->plugin_name . '_plugin_extension', array( 'WC_Compare_Functions', 'plugin_pro_notice' ) );
	
$current_db_version = get_option( 'woocommerce_db_version', null );

// Replace the template file from plugin
add_filter('template_include', array('WC_Compare_Hook_Filter', 'template_loader') );

// Add Admin Menu
add_action('admin_menu', array( 'WC_Compare_Hook_Filter', 'register_admin_screen' ), 9 );

// AJAX add to cart for variable products
add_action('wp_ajax_woocp_variable_add_to_cart', array('WC_Compare_Hook_Filter', 'woocp_variable_ajax_add_to_cart') );
add_action('wp_ajax_nopriv_woocp_variable_add_to_cart', array('WC_Compare_Hook_Filter', 'woocp_variable_ajax_add_to_cart') );
add_action('get_footer', array('WC_Compare_Hook_Filter', 'woocp_variable_add_to_cart_script') );

// AJAX add to compare
add_action('wp_ajax_woocp_add_to_compare', array('WC_Compare_Hook_Filter', 'woocp_add_to_compare') );
add_action('wp_ajax_nopriv_woocp_add_to_compare', array('WC_Compare_Hook_Filter', 'woocp_add_to_compare') );

// AJAX remove product from compare popup
add_action('wp_ajax_woocp_remove_from_popup_compare', array('WC_Compare_Hook_Filter', 'woocp_remove_from_popup_compare') );
add_action('wp_ajax_nopriv_woocp_remove_from_popup_compare', array('WC_Compare_Hook_Filter', 'woocp_remove_from_popup_compare') );

// AJAX update compare popup
add_action('wp_ajax_woocp_update_compare_popup', array('WC_Compare_Hook_Filter', 'woocp_update_compare_popup') );
add_action('wp_ajax_nopriv_woocp_update_compare_popup', array('WC_Compare_Hook_Filter', 'woocp_update_compare_popup') );

// AJAX update compare widget
add_action('wp_ajax_woocp_update_compare_widget', array('WC_Compare_Hook_Filter', 'woocp_update_compare_widget') );
add_action('wp_ajax_nopriv_woocp_update_compare_widget', array('WC_Compare_Hook_Filter', 'woocp_update_compare_widget') );

// AJAX update total compare
add_action('wp_ajax_woocp_update_total_compare', array('WC_Compare_Hook_Filter', 'woocp_update_total_compare') );
add_action('wp_ajax_nopriv_woocp_update_total_compare', array('WC_Compare_Hook_Filter', 'woocp_update_total_compare') );

// AJAX remove product from compare widget
add_action('wp_ajax_woocp_remove_from_compare', array('WC_Compare_Hook_Filter', 'woocp_remove_from_compare') );
add_action('wp_ajax_nopriv_woocp_remove_from_compare', array('WC_Compare_Hook_Filter', 'woocp_remove_from_compare') );

// AJAX clear compare widget
add_action('wp_ajax_woocp_clear_compare', array('WC_Compare_Hook_Filter', 'woocp_clear_compare') );
add_action('wp_ajax_nopriv_woocp_clear_compare', array('WC_Compare_Hook_Filter', 'woocp_clear_compare') );

// AJAX get compare feature fields for variations of product
add_action('wp_ajax_woocp_get_variation_compare', array('WC_Compare_MetaBox', 'woocp_get_variation_compare') );
add_action('wp_ajax_nopriv_woocp_get_variation_compare', array('WC_Compare_MetaBox', 'woocp_get_variation_compare') );

// AJAX get compare feature fields for variation when change compare category
add_action('wp_ajax_woocp_variation_get_fields', array('WC_Compare_MetaBox', 'woocp_variation_get_fields') );
add_action('wp_ajax_nopriv_woocp_variation_get_fields', array('WC_Compare_MetaBox', 'woocp_variation_get_fields') );

// AJAX get compare feature fields for product when change compare category
add_action('wp_ajax_woocp_product_get_fields', array('WC_Compare_MetaBox', 'woocp_product_get_fields') );
add_action('wp_ajax_nopriv_woocp_product_get_fields', array('WC_Compare_MetaBox', 'woocp_product_get_fields') );

// AJAX update orders for compare fields in dashboard
add_action('wp_ajax_woocp_update_orders', array('WC_Compare_Fields_Class', 'woocp_update_orders') );
add_action('wp_ajax_nopriv_woocp_update_orders', array('WC_Compare_Fields_Class', 'woocp_update_orders') );

// AJAX update orders for compare categories in dashboard
add_action('wp_ajax_woocp_update_cat_orders', array('WC_Compare_Categories_Class', 'woocp_update_cat_orders') );
add_action('wp_ajax_nopriv_woocp_update_cat_orders', array('WC_Compare_Categories_Class', 'woocp_update_cat_orders') );

// AJAX get compare products
add_action('wp_ajax_woocp_get_products', array('WC_Compare_Products_Class', 'woocp_get_products') );
add_action('wp_ajax_nopriv_woocp_get_products', array('WC_Compare_Products_Class', 'woocp_get_products') );

// Include google fonts into header
add_action( 'wp_head', array( 'WC_Compare_Hook_Filter', 'add_google_fonts'), 11 );

// Include google fonts into header
add_action( 'woocp_comparison_page_header', array( 'WC_Compare_Hook_Filter', 'add_google_fonts_comparison_page'), 11 );

// Add Custom style on frontend
add_action( 'wp_head', array( 'WC_Compare_Hook_Filter', 'include_customized_style'), 11);

// Add script into footer to hanlde the event from widget, popup
add_action('get_footer', array('WC_Compare_Hook_Filter', 'woocp_footer_script') );

// Set selected attributes for variable products
add_filter('woocommerce_product_default_attributes', array('WC_Compare_Hook_Filter', 'woocp_set_selected_attributes') );

// Add Compare Button on Shop page
$woo_compare_grid_view_settings = get_option( 'woo_compare_grid_view_settings', array() );
if ($woo_compare_grid_view_settings['disable_grid_view_compare'] != 1 ) {
	if ($woo_compare_grid_view_settings['grid_view_button_position'] == 'above' )
		add_action('woocommerce_before_template_part', array('WC_Compare_Hook_Filter', 'woocp_shop_add_compare_button'), 10, 3);
	else
		add_action('woocommerce_after_shop_loop_item', array('WC_Compare_Hook_Filter', 'woocp_shop_add_compare_button_below_cart'), 11);
}

// Add Compare Button on Product Details page
$woo_compare_product_page_settings = get_option( 'woo_compare_product_page_settings', array() );
if ($woo_compare_product_page_settings['disable_product_page_compare'] != 1 ) {
	if (!isset($woo_compare_product_page_settings['product_page_button_position']) || $woo_compare_product_page_settings['product_page_button_position'] == 'above' ) {
		add_action('woocommerce_before_add_to_cart_button', array('WC_Compare_Hook_Filter', 'woocp_details_add_compare_button') );
	} else {
		if ( version_compare( $current_db_version, '2.0', '<' ) && null !== $current_db_version ) {
			add_action('woocommerce_after_template_part', array('WC_Compare_Hook_Filter', 'woocp_details_add_compare_button_below_cart'), 1, 3);
		} else {
			add_action('woocommerce_after_add_to_cart_button', array('WC_Compare_Hook_Filter', 'woocp_details_add_compare_button'), 1);
		}
	}
}

// Add Compare Featured Field tab into Product Details page
$woo_compare_product_page_tab = get_option( 'woo_compare_product_page_tab', array() );
if ($woo_compare_product_page_settings['disable_product_page_compare'] != 1 && $woo_compare_product_page_tab['disable_compare_featured_tab'] != 1 ) {
	if ( version_compare( $current_db_version, '2.0', '<' ) && null !== $current_db_version ) {
		add_action( 'woocommerce_product_tabs', array('WC_Compare_Hook_Filter', 'woocp_product_featured_tab'), $woo_compare_product_page_tab['auto_compare_featured_tab'] );
		add_action( 'woocommerce_product_tab_panels', array('WC_Compare_Hook_Filter', 'woocp_product_featured_panel'), $woo_compare_product_page_tab['auto_compare_featured_tab']);
	} else {
		// woo 2.0
		add_filter( 'woocommerce_product_tabs', array('WC_Compare_Hook_Filter', 'woocp_product_featured_tab_woo_2_0') );
	}
}

// Create Compare Category when Product Category is created
add_action( 'create_product_cat',  array('WC_Compare_Hook_Filter', 'auto_create_compare_category'), 10, 2 );
	
// Create Compare Feature when Product Variation is created
add_action( 'admin_init', array('WC_Compare_Hook_Filter', 'auto_create_compare_feature'), 1);

// Add compare feature fields box into Edit product page
add_action( 'admin_menu', array('WC_Compare_MetaBox', 'compare_meta_boxes'), 1 );
if (in_array(basename($_SERVER['PHP_SELF']), array('post.php', 'page.php', 'page-new.php', 'post-new.php'))) {
	add_action('admin_footer', array('WC_Compare_MetaBox', 'variable_compare_meta_boxes'));
}

if (in_array(basename($_SERVER['PHP_SELF']), array('post.php', 'page.php', 'page-new.php', 'post-new.php'))) {
	add_action('save_post', array('WC_Compare_MetaBox', 'save_compare_meta_boxes' ) );
}

if (in_array(basename($_SERVER['PHP_SELF']), array('admin.php')) && isset($_REQUEST['page']) && in_array($_REQUEST['page'], array('woo-compare-products'))) {
	add_action('admin_footer', array('WC_Compare_Products_Class', 'woocp_compare_products_script'));
}

// Check upgrade functions
add_action( 'init', 'woo_cp_lite_upgrade_plugin' );
function woo_cp_lite_upgrade_plugin () {
	
	// Upgrade to 2.0.0
	if(version_compare(get_option('a3rev_woocp_pro_version'), '2.0.0') === -1){
		include( WOOCP_DIR. '/includes/updates/compare-update-2.0.0.php' );
		update_option('a3rev_woocp_pro_version', '2.0.0');
	}
	// Upgrade to 2.0.1
	if(version_compare(get_option('a3rev_woocp_pro_version'), '2.0.1') === -1){
		include( WOOCP_DIR. '/includes/updates/compare-update-2.0.0.php' );
		update_option('a3rev_woocp_pro_version', '2.0.1');
	}
	// Upgrade to 2.0.6
	if(version_compare(get_option('a3rev_woocp_pro_version'), '2.0.6') === -1){
		include( WOOCP_DIR. '/includes/updates/compare-update-2.0.0.php' );
		update_option('a3rev_woocp_pro_version', '2.0.6');
	}
	// Upgrade to 2.1.0
	if(version_compare(get_option('a3rev_woocp_pro_version'), '2.1.0') === -1){
		include( WOOCP_DIR. '/includes/updates/compare-update-2.0.0.php' );
		update_option('a3rev_woocp_pro_version', '2.1.0');
	}
	
	// Upgrade to 2.1.8
	if(version_compare(get_option('a3rev_woocp_pro_version'), '2.1.8') === -1){
		include( WOOCP_DIR. '/includes/updates/compare-update-2.0.0.php' );
		WC_Compare_Functions::lite_upgrade_version_2_1_8();
		
		update_option('a3rev_woocp_pro_version', '2.1.8');
		update_option('a3rev_woocp_lite_version', '2.1.8');
	}
	
	// Upgrade to 2.2.0
	if( version_compare(get_option('a3rev_woocp_lite_version'), '2.1.9.3') === -1 ) {
		include( WOOCP_DIR. '/includes/updates/compare-update-2.1.9.3.php' );
		update_option('a3rev_woocp_lite_version', '2.1.9.3');
	}
	
	update_option('a3rev_woocp_pro_version', '2.1.9.2');
	update_option('a3rev_woocp_lite_version', '2.1.9.4');

}

?>