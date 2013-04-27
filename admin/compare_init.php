<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * Install Database, settings option and auto add widget to sidebar
 */
function woocp_install() {
	update_option('a3rev_woocp_pro_version', '2.1.4');
	$product_compare_id = WC_Compare_Functions::create_page( esc_sql( 'product-comparison' ), '', __('Product Comparison', 'woo_cp'), '[product_comparison_page]' );
	update_option('product_compare_id', $product_compare_id);
	
	WC_Compare_Widget_Style::set_settings_default();
	WC_Compare_Widget_Title_Style::set_settings_default();
	WC_Compare_Widget_Button_Style::set_settings_default();
	WC_Compare_Widget_Clear_All_Style::set_settings_default();
	WC_Compare_Widget_Thumbnail_Style::set_settings_default();
	
	WC_Compare_Product_Page_Settings::set_settings_default();
	WC_Compare_Product_Page_Button_Style::set_settings_default();
	WC_Compare_Product_Page_View_Compare_Style::set_settings_default();
	WC_Compare_Product_Page_Tab::set_settings_default();
		
	WC_Compare_Grid_View_Settings::set_settings_default();
	WC_Compare_Grid_View_Button_Style::set_settings_default();
	WC_Compare_Grid_View_View_Compare_Style::set_settings_default();
	
	WC_Compare_Comparison_Page_Global_Settings::set_settings_default();
	WC_Compare_Page_Style::set_settings_default();
	WC_Compare_Table_Row_Style::set_settings_default();
	WC_Compare_Table_Content_Style::set_settings_default();
	WC_Compare_Price_Style::set_settings_default();
	WC_Compare_AddToCart_Style::set_settings_default();
	WC_Compare_ViewCart_Style::set_settings_default();
	WC_Compare_Print_Message_Style::set_settings_default();
	WC_Compare_Print_Button_Style::set_settings_default();
	WC_Compare_Close_Window_Button_Style::set_settings_default();
	
	WC_Compare_Data::install_database();
	WC_Compare_Categories_Data::install_database();
	WC_Compare_Categories_Fields_Data::install_database();
	WC_Compare_Functions::add_meta_all_products();
	WC_Compare_Widget_Add::automatic_add_widget_to_sidebar();
	update_option('a3rev_woocp_just_confirm', 1);
	
	update_option('a3rev_woocp_just_installed', true);
}

update_option('a3rev_woocp_plugin', 'woo_compare');

function woocp_init() {
	if ( get_option('a3rev_woocp_just_installed') ) {
		delete_option('a3rev_woocp_just_installed');
		wp_redirect( ( ( is_ssl() || force_ssl_admin() || force_ssl_login() ) ? str_replace( 'http:', 'https:', admin_url( 'admin.php?page=woo-compare-settings' ) ) : str_replace( 'https:', 'http:', admin_url( 'admin.php?page=woo-compare-settings' ) ) ) );
		exit;
	}
	load_plugin_textdomain( 'woo_cp', false, WOOCP_FOLDER.'/languages' );
}

// Add language
add_action('init', 'woocp_init');

// Plugin loaded
add_action( 'plugins_loaded', array( 'WC_Compare_Functions', 'plugins_loaded' ), 8 );

// Add text on right of Visit the plugin on Plugin manager page
add_filter( 'plugin_row_meta', array('WC_Compare_Hook_Filter', 'plugin_extra_links'), 10, 2 );
	
$current_db_version = get_option( 'woocommerce_db_version', null );

// Replace the template file from plugin
add_filter('template_include', array('WC_Compare_Hook_Filter', 'template_loader') );

// Add Admin Menu
add_action('admin_menu', 'woocp_add_menu_item_e_commerce', 11);

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

// Add Custom style on frontend
add_action( 'wp_head', array( 'WC_Compare_Hook_Filter', 'include_customized_style'), 11);

// Add script into footer to hanlde the event from widget, popup
add_action('get_footer', array('WC_Compare_Hook_Filter', 'woocp_footer_script') );

// Set selected attributes for variable products
add_filter('woocommerce_product_default_attributes', array('WC_Compare_Hook_Filter', 'woocp_set_selected_attributes') );

// Add Compare Button on Shop page
$woo_compare_grid_view_settings = WC_Compare_Grid_View_Settings::get_settings();
if ($woo_compare_grid_view_settings['disable_grid_view_compare'] != 1 ) {
	if ($woo_compare_grid_view_settings['grid_view_button_position'] == 'above' )
		add_action('woocommerce_before_template_part', array('WC_Compare_Hook_Filter', 'woocp_shop_add_compare_button'), 10, 3);
	else
		add_action('woocommerce_after_shop_loop_item', array('WC_Compare_Hook_Filter', 'woocp_shop_add_compare_button_below_cart'), 11);
}

// Add Compare Button on Product Details page
$woo_compare_product_page_settings = WC_Compare_Product_Page_Settings::get_settings();
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
$woo_compare_product_page_tab = WC_Compare_Product_Page_Tab::get_settings();
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
if (in_array(basename($_SERVER['PHP_SELF']), array('admin.php', 'edit.php')) && isset($_REQUEST['page']) && in_array($_REQUEST['page'], array('woo-compare-settings'))) {
	add_action('admin_head', array('WC_Compare_Hook_Filter', 'woocp_admin_header_script'));
	add_action('admin_footer', array('WC_Compare_Hook_Filter', 'woocp_admin_script'));
}
if (in_array(basename($_SERVER['PHP_SELF']), array('admin.php')) && isset($_REQUEST['page']) && in_array($_REQUEST['page'], array('woo-compare-settings')) && isset($_REQUEST['tab']) && in_array($_REQUEST['tab'], array('compare-products'))) {
	add_action('admin_footer', array('WC_Compare_Products_Class', 'woocp_compare_products_script'));
}

// Upgrade to 2.0.0
if(version_compare(get_option('a3rev_woocp_pro_version'), '2.0.0') === -1){
	WC_Compare_Functions::upgrade_version_2_0();
	update_option('a3rev_woocp_pro_version', '2.0.0');
}
// Upgrade to 2.0.1
if(version_compare(get_option('a3rev_woocp_pro_version'), '2.0.1') === -1){
	WC_Compare_Functions::upgrade_version_2_0_1();
	update_option('a3rev_woocp_pro_version', '2.0.1');
}
// Upgrade to 2.0.6
if(version_compare(get_option('a3rev_woocp_pro_version'), '2.0.6') === -1){
	WC_Compare_Functions::upgrade_version_2_0_6();
	update_option('a3rev_woocp_pro_version', '2.0.6');
}
// Upgrade to 2.1.0
if(version_compare(get_option('a3rev_woocp_pro_version'), '2.1.0') === -1){
	WC_Compare_Functions::upgrade_version_2_1_0();
	update_option('a3rev_woocp_pro_version', '2.1.0');
}
update_option('a3rev_woocp_pro_version', '2.1.4');

// Add Menu Comparable Settings in E Commerce Plugins
function woocp_add_menu_item_e_commerce() {
	if (get_option('a3rev_woocp_just_confirm') == 1) {
		WC_Compare_Data::automatic_add_features();
		WC_Compare_Categories_Data::automatic_add_compare_categories();
		update_option('a3rev_woocp_just_confirm', 0);
	}
	$woo_page = 'woocommerce';
	$comparable_settings_page = add_submenu_page( $woo_page , __( 'Compare Settings', 'woo_cp' ), __( 'Product Comparison', 'woo_cp' ), 'manage_options', 'woo-compare-settings', 'woo_cp_dashboard' );
	
	//$products_page = 'edit.php?post_type=product';
	//$compare_products_page = add_submenu_page( $products_page , __( 'Compare Products', 'woo_cp' ), __( 'Compare Products', 'woo_cp' ), 'manage_options', 'woo-compare-products', 'woocp_compare_products' );
	//add_action('admin_print_scripts-' . $compare_products_page, array('WC_Compare_Products_Class','woocp_compare_products_script'));
}

/**
 * Show Dashboard page of plugin
 */
function woo_cp_dashboard() {
?>
	<style>
	 	.code, code { font-family: inherit; font-size:inherit; }
		.form-table{margin:0;border-collapse:separate;}
		.chzn-container{margin-right:2px;}
		.field_title{width:205px; padding:0 8px 0 10px; float:left;}
		.help_tip{cursor: help;line-height: 1;margin: -4px 0 0 5px;padding: 0;vertical-align: middle;}
		.compare_set_1{width:46%; float:left; margin-right:5%; margin-bottom:15px;}
		.compare_set_2{width:46%; float:left; margin-bottom:15px;}
		.update_message{padding:10px; background-color:#FFFFCC;border:1px solid #DDDDDD;margin-bottom:15px;}
		.ui-sortable-helper{}
		.ui-state-highlight{background:#F6F6F6; height:24px; padding:8px 0 0; border:1px dotted #DDD; margin-bottom:20px;}
		ul.compare_orders{float:left; margin:0; width:100%}
		ul.compare_orders li{padding-top:8px; border-top:1px solid #DFDFDF; margin:5px 0; line-height:20px;}
		ul.compare_orders li.first_record{border-top:none; padding-top:0;}
		ul.compare_orders .compare_sort{float:left; width:60px;}
		.c_field_name{padding-left:20px; background:url(<?php echo WOOCP_IMAGES_URL; ?>/icon_sort.png) no-repeat 0 center;}
		.c_openclose_table{cursor:pointer;}
		.c_openclose_none{width:16px; height:16px; display:inline-block;}
		.c_close_table{background:url(<?php echo get_option('siteurl'); ?>/wp-admin/images/arrows.png) no-repeat center 0px; width:16px; height:16px; display:inline-block;}
		.c_open_table{background:url(<?php echo get_option('siteurl'); ?>/wp-admin/images/arrows.png) no-repeat center -35px; width:16px; height:16px; display:inline-block;}
		ul.compare_orders .c_field_type{width:120px; float:left;}
		ul.compare_orders .c_field_manager{background:url(<?php echo WOOCP_IMAGES_URL; ?>/icon_fields.png) no-repeat 0 0; width:16px; height:16px; display:inline-block;}
		.tablenav-pages{float:right;}
		.c_field_edit, .c_field_delete{cursor:pointer;}
		.widefat th input {
			vertical-align:middle;
			padding:3px 8px;
			margin:auto;
		}
		.widefat th, .widefat td {
			overflow: inherit !important;	
		}
		.chzn-container-multi .chzn-choices {
			min-height:100px;	
		}

		ul.feature_compare_orders .compare_sort{margin-right:10px; float:none; width:auto;}
		ul.feature_compare_orders .c_field_name{margin-right:10px;padding:5px 0 5px 20px; float:none; width:auto;}
		ul.feature_compare_orders .c_field_action{float:right;}
		ul.feature_compare_orders .c_field_type{float:right; margin-right:10px; width:70px;}

		body .flexigrid div.sDiv{display:block;}
		.flexigrid div.sDiv .sDiv2 select{display:none;}
		.flexigrid div.sDiv .cp_search, .flexigrid div.sDiv .cp_reset{cursor:pointer;}
		.edit_product_compare{cursor:pointer; text-decoration:underline; color:#06F;}
		
		.icon32-compare-product {
			background:url(<?php echo WOOCP_IMAGES_URL; ?>/a3-plugins.png) no-repeat left top !important;
		}
		.subsubsub { white-space:normal;}
		.subsubsub li { white-space:nowrap;}
		#wc_compare_product_panel_container { position:relative; margin-top:10px;}
		#wc_compare_product_panel_fields {width:60%; float:left;}
		#wc_compare_product_upgrade_area { position:relative; margin-left: 60%; padding-left:10px;}
		#wc_compare_product_extensions { border:2px solid #E6DB55;-webkit-border-radius:10px;-moz-border-radius:10px;-o-border-radius:10px; border-radius: 10px; color: #555555; margin: 0px; padding: 5px; text-shadow: 0 1px 0 rgba(255, 255, 255, 0.8); background:#FFFBCC; }
		.pro_feature_fields { margin-right: -12px; position: relative; z-index: 10; border:2px solid #E6DB55;-webkit-border-radius:10px 0 0 10px;-moz-border-radius:10px 0 0 10px;-o-border-radius:10px 0 0 10px; border-radius: 10px 0 0 10px; border-right: 2px solid #FFFFFF; }
		.pro_feature_fields h3, .pro_feature_fields p { margin-left:5px; }
	</style>
	<script>
		(function($){
			$(function(){
				$("#field_type").change( function() {
					var field_type = $(this).val();
					if(field_type == 'checkbox' || field_type == 'radio' || field_type == 'drop-down' || field_type == 'multi-select'){
						$("#field_value").show();
					}else{
						$("#field_value").hide();
					}
				});
				$('#toggle1').click(function(){
					if($('#toggle1').is(':checked')){
						$(".list_fields").attr("checked", "checked");
						$(".toggle2").attr("checked", "checked");
					}else{
						$(".list_fields").removeAttr("checked");
						$(".toggle2").removeAttr("checked");
					}
				});
				$('#toggle2').click(function(){
					if($('#toggle2').is(':checked')){
						$(".list_fields").attr("checked", "checked");
						$(".toggle1").attr("checked", "checked");
					}else{
						$(".list_fields").removeAttr("checked");
						$(".toggle1").removeAttr("checked");
					}
				});
			});
		})(jQuery);
		function confirmation(text) {
			var answer = confirm(text)
			if (answer){
				return true;
			}else{
				return false;
			}
		}
		
		function alert_upgrade(text) {
			var answer = confirm(text)
			if (answer){
				window.open("<?php echo WOOCP_AUTHOR_URI; ?>", '_blank')
			}else{
				return false;
			}
		}
	</script>
    <div class="wrap">
    	<div class="icon32 icon32-compare-product" id="icon32-compare-product"><br></div><h2 class="nav-tab-wrapper">
		<?php
	$current_tab = (isset($_REQUEST['tab'])) ? $_REQUEST['tab'] : '';
	$tabs = array(
		'features' => __( 'Features', 'woo_cp' ),
		'compare-products' => __( 'Products', 'woo_cp' ),
		'product-page' => __( 'Product Page', 'woo_cp' ),
		'widget-style' => __( 'Widget Style', 'woo_cp' ),
		'grid-view-style' => __( 'Grid View Style', 'woo_cp' ),
		'comparison-page' => __( 'Comparison Page', 'woo_cp' ),
	);

	foreach ($tabs as $name => $label) :
		echo '<a href="' . admin_url( 'admin.php?page=woo-compare-settings&tab=' . $name ) . '" class="nav-tab ';
	if ($current_tab == '' && $name == 'features') echo 'nav-tab-active';
	if ( $current_tab==$name ) echo 'nav-tab-active';
	echo '">' . $label . '</a>';
	endforeach;

?>
		</h2>
        <div style="width:100%; float:left;">
        <?php
		switch ($current_tab) :
			case 'product-page':
				WC_Compare_Product_Page_Panel::panel_manager();
				break;
			case 'compare-products':
				WC_Compare_Products_Class::woocp_products_manager();
				break;
			case 'widget-style':
				WC_Compare_Widget_Style_Panel::panel_manager();
				break;
			case 'grid-view-style':
				WC_Compare_Grid_View_Panel::panel_manager();
				break;
			case 'comparison-page':
				WC_Compare_Page_Panel::panel_manager();
				break;
			default :
				echo '<div id="wc_compare_product_panel_container"><div id="wc_compare_product_panel_fields">';
				echo WC_Compare_Fields_Class::init_features_actions();
				echo WC_Compare_Categories_Class::init_categories_actions();
				if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'add-new') {
					WC_Compare_Categories_Class::woocp_categories_manager();
					WC_Compare_Fields_Class::woocp_features_manager();
				} else if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'cat-edit') {
					WC_Compare_Categories_Class::woocp_categories_manager();
				} else if (isset($_REQUEST['act']) &&  $_REQUEST['act'] == 'field-edit') {
					WC_Compare_Fields_Class::woocp_features_manager();
				} else if (isset($_REQUEST['s_feature'])) {
					WC_Compare_Fields_Class::features_search_area();
				} else {
					WC_Compare_Fields_Class::features_search_area();
					WC_Compare_Fields_Class::woocp_features_orders();
				}
				echo '</div><div id="wc_compare_product_upgrade_area">'.WC_Compare_Functions::plugin_pro_notice().'</div></div>';
				break;
		endswitch;
?>
        </div>
        <div style="clear:both; margin-bottom:20px;"></div>
    </div>
<?php
}

/**
 * Show Compare Products Manager page
 */
function woocp_compare_products() {
?>
	<style type="text/css">
	body .flexigrid div.sDiv{display:block;}
	.flexigrid div.sDiv .sDiv2 select{display:none;}
	.flexigrid div.sDiv .cp_search, .flexigrid div.sDiv .cp_reset{cursor:pointer;}
	.edit_product_compare{cursor:pointer;}
	</style>
	<div class="wrap">

        <div style="">
		<?php WC_Compare_Products_Class::woocp_products_manager(); ?>
        </div>
        <div style="clear:both; margin-bottom:20px;"></div>
	</div>
<?php
}
?>