<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * Install Database, settings option and auto add widget to sidebar
 */
function woocp_install() {
	update_option('a3rev_woocp_free_version', '2.0.1');
	WC_Compare_Settings::woocp_set_setting_default();
	WC_Compare_Data::install_database();
	WC_Compare_Categories_Data::install_database();
	WC_Compare_Categories_Fields_Data::install_database();
	WC_Compare_Categories_Data::auto_add_master_category();
	WC_Compare_Data::add_features_to_master_category();
	WC_Compare_Functions::add_meta_all_products();
	WC_Compare_Widget_Add::automatic_add_widget_to_sidebar();
	WC_Compare_Functions::auto_assign_master_category_to_all_products();
	update_option('a3rev_woocp_just_confirm', 1);
}

update_option('a3rev_woocp_plugin', 'woo_compare');

function woocp_init() {
	load_plugin_textdomain( 'woo_cp', false, WOOCP_FOLDER.'/languages' );
}
	
$comparable_settings = get_option('woo_comparable_settings');

// Add language
add_action('init', 'woocp_init');

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

// AJAX get compare popup
add_action('wp_ajax_woocp_get_popup', array('WC_Compare_Hook_Filter', 'woocp_get_popup') );
add_action('wp_ajax_nopriv_woocp_get_popup', array('WC_Compare_Hook_Filter', 'woocp_get_popup') );

// AJAX get compare products
add_action('wp_ajax_woocp_get_products', array('WC_Compare_Products_Class', 'woocp_get_products') );
add_action('wp_ajax_nopriv_woocp_get_products', array('WC_Compare_Products_Class', 'woocp_get_products') );

// AJAX get product compare feature fields popup
add_action('wp_ajax_woocp_popup_features', array('WC_Compare_Products_Class', 'woocp_popup_features') );
add_action('wp_ajax_nopriv_woocp_popup_features', array('WC_Compare_Products_Class', 'woocp_popup_features') );

// Add script into footer to hanlde the event from widget, popup
add_action('get_footer', array('WC_Compare_Hook_Filter', 'woocp_footer_script') );

// Include script and style into theme to can load lightbox and print
//add_action('get_header', array('WC_Compare_Hook_Filter', 'woocp_print_scripts') );
add_action('wp_print_styles', array('WC_Compare_Hook_Filter', 'woocp_print_styles') );

// Set selected attributes for variable products
add_filter('woocommerce_product_default_attributes', array('WC_Compare_Hook_Filter', 'woocp_set_selected_attributes') );

// Add Compare Button on Shop page
if (!isset($comparable_settings['button_position']) || $comparable_settings['button_position'] == 'above' )
	add_action('woocommerce_before_template_part', array('WC_Compare_Hook_Filter', 'woocp_shop_add_compare_button'), 10, 3);
else
	add_action('woocommerce_after_shop_loop_item', array('WC_Compare_Hook_Filter', 'woocp_shop_add_compare_button_below_cart'), 11);

// Add Compare Button on Product Details page
if (!isset($comparable_settings['button_position']) || $comparable_settings['button_position'] == 'above' )
	add_action('woocommerce_before_add_to_cart_button', array('WC_Compare_Hook_Filter', 'woocp_details_add_compare_button') );
else
	add_action('woocommerce_after_template_part', array('WC_Compare_Hook_Filter', 'woocp_details_add_compare_button_below_cart'), 1, 3);

// Add Compare Featured Field tab into Product Details page
if ($comparable_settings['auto_compare_featured_tab'] > 0 ) {
	add_action( 'woocommerce_product_tabs', array('WC_Compare_Hook_Filter', 'woocp_product_featured_tab'), $comparable_settings['auto_compare_featured_tab'] );
	add_action( 'woocommerce_product_tab_panels', array('WC_Compare_Hook_Filter', 'woocp_product_featured_panel'), $comparable_settings['auto_compare_featured_tab']);
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
	add_action('admin_footer', array('WC_Compare_Hook_Filter', 'woocp_admin_script'));
}
if (in_array(basename($_SERVER['PHP_SELF']), array('admin.php')) && isset($_REQUEST['page']) && in_array($_REQUEST['page'], array('woo-compare-settings')) && isset($_REQUEST['tab']) && in_array($_REQUEST['tab'], array('compare-products'))) {
	add_action('admin_footer', array('WC_Compare_Products_Class', 'woocp_compare_products_script'));
}

// Upgrade to 1.0.1
if(version_compare(get_option('a3rev_woocp_free_version'), '1.0.1') === -1){
	WC_Compare_Upgrade::upgrade_version_1_0_1();
	update_option('a3rev_woocp_free_version', '1.0.1');
}
// Upgrade to 2.0.0
if(version_compare(get_option('a3rev_woocp_free_version'), '2.0.0') === -1){
	WC_Compare_Upgrade::upgrade_version_2_0();
	update_option('a3rev_woocp_free_version', '2.0.0');
}
// Upgrade to 2.0.1
if(version_compare(get_option('a3rev_woocp_free_version'), '2.0.1') === -1){
	WC_Compare_Upgrade::upgrade_version_2_0_1();
	update_option('a3rev_woocp_free_version', '2.0.1');
}
update_option('a3rev_woocp_free_version', '2.0.1');

// Add text on right of Visit the plugin on Plugin manager page
add_filter( 'plugin_row_meta', array('WC_Compare_Hook_Filter', 'plugin_extra_links'), 10, 2 );

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

function woocp_right_sidebar() {
?>

<?php
}

/**
 * Show Dashboard page of plugin
 */
function woo_cp_dashboard() {
?>
	<style>
		#compare_extensions { background: url("<?php echo WOOCP_IMAGES_URL; ?>/logo_a3blue.png") no-repeat scroll 4px 6px #F1F1F1; -webkit-border-radius:4px;-moz-border-radius:4px;-o-border-radius:4px; border-radius: 4px 4px 4px 4px; color: #555555; float: right; margin: 10px 0 5px; padding: 4px 8px 4px 38px; position: relative; text-shadow: 0 1px 0 rgba(255, 255, 255, 0.8); width: 220px;
		}
		.compare_upgrade_area { border:2px solid #FF0;-webkit-border-radius:10px;-moz-border-radius:10px;-o-border-radius:10px; border-radius: 10px; margin-top:10px; padding:10px; position:relative}
	   	.upgrade_extensions { background: url("<?php echo WOOCP_IMAGES_URL; ?>/logo_a3blue.png") no-repeat scroll 4px 6px #FFFBCC; -webkit-border-radius:4px;-moz-border-radius:4px;-o-border-radius:4px; border-radius: 4px 4px 4px 4px; color: #555555; float: right; margin: 0px; padding: 4px 8px 4px 38px; position: absolute; text-shadow: 0 1px 0 rgba(255, 255, 255, 0.8); width: 400px; right:10px; top:10px; border:1px solid #E6DB55}
		.products_tab_extension{position:relative; float:right;}
	   
		.form-table{margin:0;border-collapse:separate;}
		.chzn-container{margin-right:2px;}
		.field_title{width:205px; padding:0 8px 0 10px; float:left;}
		.help_tip{cursor: help;line-height: 1;margin: -4px 0 0 5px;padding: 0;vertical-align: middle;}
		.compare_set_1{width:46%; float:left; margin-right:5%; margin-bottom:15px;}
		.compare_set_2{width:46%; float:left; margin-bottom:15px;}
		.update_message{padding:10px; background-color:#FFFFCC;border:1px solid #DDDDDD;margin-bottom:15px;}
		.woocp_read_more{text-decoration:underline; cursor:pointer; margin-left:40px; color:#06F;}
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

		ul.feature_compare_orders .compare_sort{margin-right:10px; float:none; width:auto;}
		ul.feature_compare_orders .c_field_name{margin-right:10px;padding:5px 0 5px 20px; float:none; width:auto;}
		ul.feature_compare_orders .c_field_action{float:right;}
		ul.feature_compare_orders .c_field_type{float:right; margin-right:10px; width:70px;}

		body .flexigrid div.sDiv{display:block;}
		.flexigrid div.sDiv .sDiv2 select{display:none;}
		.flexigrid div.sDiv .cp_search, .flexigrid div.sDiv .cp_reset{cursor:pointer;}
		.edit_product_compare{cursor:pointer; text-decoration:underline; color:#06F;}
		.upgrade_message {color:#F00; font-size:16px;}
	</style>
	<script>
		(function($){
			$(function(){
				$(".woocp_read_more").toggle(
					function(){
						$(this).html('Read Less');
						$(this).siblings(".woocp_description_text").slideDown('slow');
					},
					function(){
						$(this).html('Read More');
						$(this).siblings(".woocp_description_text").slideUp('slow');
					}
				);
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
    	<div class="icon32 icon32-woocommerce-settings" id="icon-woocommerce"><br></div><h2 class="nav-tab-wrapper">
		<?php
	$current_tab = (isset($_REQUEST['tab'])) ? $_REQUEST['tab'] : '';
	$tabs = array(
		'settings' => __( 'Settings', 'woo_cp' ),
		'features' => __( 'Features', 'woo_cp' ),
		'compare-products' => __( 'Products', 'woo_cp' ),
	);

	foreach ($tabs as $name => $label) :
		echo '<a href="' . admin_url( 'admin.php?page=woo-compare-settings&tab=' . $name ) . '" class="nav-tab ';
	if ($current_tab == '' && $name == 'settings') echo 'nav-tab-active';
	if ( $current_tab==$name ) echo 'nav-tab-active';
	echo '">' . $label . '</a>';
	endforeach;

?>
		</h2>
        <div style="float:right; width:0%; margin-left:0%; margin-top:30px;">
            <?php woocp_right_sidebar(); ?>
        </div>
        <div style="width:100%; float:left;">
        <?php
		//echo WC_Compare_Functions::compare_extension();
		switch ($current_tab) :
			case 'features':
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
				break;
			case 'compare-products':
				WC_Compare_Products_Class::woocp_products_manager();
				break;
			default :
				WC_Compare_Settings::woocp_settings_display();
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
