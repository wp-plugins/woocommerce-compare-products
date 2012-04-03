<?php
function woo_compare_set_settings(){
	woo_compare_install();
	WOO_Compare_Class::woocp_set_setting_default();
}

function woo_compare_install(){
	WOO_Compare_Data::install_database();
	WOO_Compare_Widget_Add::automatic_add_widget_to_sidebar();
}
update_option('a3rev_woocp_plugin', 'woo_compare');
	
	// Add Admin Menu
	add_action('admin_menu', 'woocp_add_menu_item_e_commerce', 11);
	
	// AJAX add to compare
	add_action('wp_ajax_woocp_add_to_compare', array('WOO_Compare_Hook_Filter', 'woocp_add_to_compare') );
	add_action('wp_ajax_nopriv_woocp_add_to_compare', array('WOO_Compare_Hook_Filter', 'woocp_add_to_compare') );
	
	// AJAX remove product from compare popup
	add_action('wp_ajax_woocp_remove_from_popup_compare', array('WOO_Compare_Hook_Filter', 'woocp_remove_from_popup_compare') );
	add_action('wp_ajax_nopriv_woocp_remove_from_popup_compare', array('WOO_Compare_Hook_Filter', 'woocp_remove_from_popup_compare') );
	
	// AJAX update compare widget
	add_action('wp_ajax_woocp_update_compare_widget', array('WOO_Compare_Hook_Filter', 'woocp_update_compare_widget') );
	add_action('wp_ajax_nopriv_woocp_update_compare_widget', array('WOO_Compare_Hook_Filter', 'woocp_update_compare_widget') );
	
	// AJAX update total compare
	add_action('wp_ajax_woocp_update_total_compare', array('WOO_Compare_Hook_Filter', 'woocp_update_total_compare') );
	add_action('wp_ajax_nopriv_woocp_update_total_compare', array('WOO_Compare_Hook_Filter', 'woocp_update_total_compare') );
	
	// AJAX remove product from compare widget
	add_action('wp_ajax_woocp_remove_from_compare', array('WOO_Compare_Hook_Filter', 'woocp_remove_from_compare') );
	add_action('wp_ajax_nopriv_woocp_remove_from_compare', array('WOO_Compare_Hook_Filter', 'woocp_remove_from_compare') );
	
	// AJAX clear compare widget
	add_action('wp_ajax_woocp_clear_compare', array('WOO_Compare_Hook_Filter', 'woocp_clear_compare') );
	add_action('wp_ajax_nopriv_woocp_clear_compare', array('WOO_Compare_Hook_Filter', 'woocp_clear_compare') );
	
	// AJAX get compare feature fields for variations of product
	add_action('wp_ajax_woocp_get_variation_compare', array('WOO_Compare_MetaBox', 'woocp_get_variation_compare') );
	add_action('wp_ajax_nopriv_woocp_get_variation_compare', array('WOO_Compare_MetaBox', 'woocp_get_variation_compare') );
	
	// AJAX update orders for compare fields in dashboard
	add_action('wp_ajax_woocp_update_orders', array('WOO_Compare_Class', 'woocp_update_orders') );
	add_action('wp_ajax_nopriv_woocp_update_orders', array('WOO_Compare_Class', 'woocp_update_orders') );
	
	// AJAX get compare popup 
	add_action('wp_ajax_woocp_get_popup', array('WOO_Compare_Hook_Filter', 'woocp_get_popup') );
	add_action('wp_ajax_nopriv_woocp_get_popup', array('WOO_Compare_Hook_Filter', 'woocp_get_popup') );
	
	// Add script into footer to hanlde the event from widget, popup
	add_action('get_footer', array('WOO_Compare_Hook_Filter', 'woo_compare_footer_script'));
	
	// Include script and style into theme to can load lightbox and print
	add_action('get_header', array('WOO_Compare_Hook_Filter','woocp_print_scripts'));
	add_action('wp_print_styles', array('WOO_Compare_Hook_Filter','woocp_print_styles'));
		
	// Add Compare Button on Shop page
	add_action('woocommerce_before_template_part', array('WOO_Compare_Hook_Filter','woo_shop_add_compare_button'), 10, 3);
	
	// Add Compare Button on Product Details page
	add_action('woocommerce_before_add_to_cart_button', array('WOO_Compare_Hook_Filter','woo_details_add_compare_button'));
	
	// Add Compare Featured Field tab into Product Details page
	$comparable_settings = get_option('woo_comparable_settings');
	if($comparable_settings['auto_compare_featured_tab'] > 0 ){
		add_action( 'woocommerce_product_tabs', array('WOO_Compare_Hook_Filter', 'woo_product_compare_featured_tab'), $comparable_settings['auto_compare_featured_tab'] );
		add_action( 'woocommerce_product_tab_panels', array('WOO_Compare_Hook_Filter', 'woo_product_compare_featured_panel'), $comparable_settings['auto_compare_featured_tab']);
	}
	
		
	// Add compare feature fields box into Edit product page
	add_action( 'admin_menu', array('WOO_Compare_MetaBox', 'compare_meta_boxes'), 1 );
	if(in_array(basename($_SERVER['PHP_SELF']), array('post.php', 'page.php', 'page-new.php', 'post-new.php'))){
		//add_action('admin_footer', array('WOO_Compare_MetaBox', 'variable_compare_meta_boxes'));
	}
	if(in_array(basename($_SERVER['PHP_SELF']), array('admin.php', 'edit.php')) && isset($_REQUEST['page']) && in_array($_REQUEST['page'], array('woo-comparable-settings', 'woo-compare-fields'))){
		add_action('admin_footer', array('WOO_Compare_Hook_Filter','woocp_admin_script'));
	}
	
	if(in_array(basename($_SERVER['PHP_SELF']), array('post.php', 'page.php', 'page-new.php', 'post-new.php'))){
		add_action('save_post', array('WOO_Compare_MetaBox','save_compare_meta_boxes' ) );
	}
	
// Add Menu Comparable Settings in E Commerce Plugins
function woocp_add_menu_item_e_commerce() {
	$woo_page = 'woocommerce';
	$comparable_settings_page = add_submenu_page( $woo_page , __( 'Compare Settings', 'woo_cp' ), __( 'Compare Settings', 'woo_cp' ), 'manage_options', 'woo-comparable-settings', 'woo_display_comparable_settings' );
}

function woo_display_comparable_settings(){
	WOO_Compare_Class::woo_compare_manager();
}
?>