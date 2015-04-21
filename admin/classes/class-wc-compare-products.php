<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WooCommerce Compare Products Manager
 *
 * Table Of Contents
 *
 * woocp_get_products()
 * woocp_popup_features()
 * woocp_products_manager()
 * woocp_compare_products_script()
 */
class WC_Compare_Products_Class 
{
	public static function woocp_get_products() {
		check_ajax_referer( 'woocp-products-manager', 'security' );

		$paged = isset($_POST['page']) ? $_POST['page'] : 1;
		$rp = isset($_POST['rp']) ? $_POST['rp'] : 10;
		$cp_show_variations = isset($_POST['cp_show_variations']) ? $_POST['cp_show_variations'] : 0;
		$start = ($paged-1)*$rp;
		$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'title';
		$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'asc';
		$query = isset($_POST['query']) ? $_POST['query'] : false;
		$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : false;

		$data_a = array();
		$data_a['s'] = $query;
		$data_a['numberposts'] = $rp;
		$data_a['offset'] = $start;
		if ($sortname == 'title') {
			$data_a['orderby'] = $sortname;
		}else {
			$data_a['orderby'] = 'meta_value';
			$data_a['meta_key'] = $sortname;
		}
		$data_a['order'] = strtoupper($sortorder);
		$data_a['post_type'] = 'product';
		$data_a['post_status'] = array('private', 'publish');

		$all_data = array();
		$all_data['s'] = $query;
		$all_data['posts_per_page'] = 1;
		$all_data['post_type'] = 'product';
		$all_data['post_status'] = array('private', 'publish');

		//$all_products = get_posts($all_data);
		//$total = count($all_products);
		$query = new WP_Query($all_data);
		$total = $query->found_posts;
		//$total = $wpdb->get_var("SELECT COUNT(ID) FROM {$wpdb->posts} WHERE post_title LIKE '%{$query}%' AND post_type='wpsc-product' AND post_status IN ('private', 'publish') ;");
		$products = get_posts($data_a);

		$jsonData = array('page'=>$paged, 'total'=>$total, 'rows'=>array());
		$number = $start;

		foreach ($products as $product) {
			$number++;
			//If cell's elements have named keys, they must match column names
			//Only cell's with named keys and matching columns are order independent.
			$terms = get_the_terms( $product->ID, 'product_cat' );
			$on_cats = '';
			if ( $terms && ! is_wp_error( $terms ) ) {
				$cat_links = array();
				foreach ( $terms as $term ) {
					$cat_links[] = $term->name;
				}
				$on_cats = join( ", ", $cat_links );
			}
			$compare_category = get_post_meta( $product->ID, '_woo_compare_category_name', true );
			$deactivate_compare_feature = get_post_meta( $product->ID, '_woo_deactivate_compare_feature', true );
			if ($deactivate_compare_feature == 'no' && $compare_category != '') $status = '<font style="color:green">'.__( "Activated", 'woo_cp' ).'</font>';
			else $status = '<font style="color:red">'.__( "Deactivated", 'woo_cp' ).'</font>';

			$entry = array(
				'id' => $product->ID,
				'cell' => array(
					'number' => $number,
					'title' => $product->post_title,
					'cat' => $on_cats,
					'_woo_compare_category_name' => $compare_category,
					'_woo_deactivate_compare_feature' => $status,
					'edit' => '<span rel="'.$product->ID.'|'.$paged.'|'.$rp.'|'.$sortname.'|'.$sortorder.'|'.$cp_show_variations.'|'.$qtype.'" class="edit_product_compare">'.__( "Edit", 'woo_cp' ).'</span>'
				),
			);
			$jsonData['rows'][] = $entry;
			if ($cp_show_variations == 1) {
				$args = array(
					'post_type' => 'product_variation',
					'post_status' => array('publish'),
					'numberposts' => -1,
					'orderby' => 'id',
					'order' => 'asc',
					'post_parent' => $product->ID
				);
				$variations = get_posts($args);
				if ($variations && is_array($variations) && count($variations) > 0) {
					$sub = 0;
					foreach ($variations as $variation) {
						$sub++;
						$compare_category = get_post_meta( $variation->ID, '_woo_compare_category_name', true );
						$deactivate_compare_feature = get_post_meta( $variation->ID, '_woo_deactivate_compare_feature', true );
						if ($deactivate_compare_feature == 'no' && $compare_category != '') $status = '<font style="color:green">'.__( "Activated", 'woo_cp' ).'</font>';
						else $status = '<font style="color:red">'.__( "Deactivated", 'woo_cp' ).'</font>';

						$entry = array(
							'id' => $variation->ID,
							'cell' => array(
								'number' => '',
								'title' => '-- '.WC_Compare_Functions::get_variation_name($variation->ID),
								'cat' => $on_cats,
								'_woo_compare_category_name' => $compare_category,
								'_woo_deactivate_compare_feature' => $status,
								'edit' => '<span rel="'.$variation->ID.'|'.$paged.'|'.$rp.'|'.$sortname.'|'.$sortorder.'|'.$cp_show_variations.'|'.$qtype.'" class="edit_product_compare">'.__( "Edit", 'woo_cp' ).'</span>'
							),
						);
						$jsonData['rows'][] = $entry;
					}
				}
			}
		}
		echo json_encode($jsonData);
		die();
	}

	public static function woocp_products_manager() {
		$compare_product_message = '';
		$paged = isset($_POST['paged']) ? $_POST['paged'] : 1;
		$rp = isset($_POST['rp']) ? $_POST['rp'] : 10;
		$cp_show_variations = isset($_POST['cp_show_variations']) ? $_POST['cp_show_variations'] : 0;
		$sortname = isset($_POST['sortname']) ? $_POST['sortname'] : 'title';
		$sortorder = isset($_POST['sortorder']) ? $_POST['sortorder'] : 'asc';
		$query = isset($_POST['query']) ? $_POST['query'] : '';
		$qtype = isset($_POST['qtype']) ? $_POST['qtype'] : '';
		if (isset($_REQUEST['bt_update_product_features'])) {
			if (isset($_REQUEST['productid']) && $_REQUEST['productid'] > 0) {
				$post_id = $_REQUEST['productid'];
				$post_status = get_post_status($post_id);
				$post_type = get_post_type($post_id);
				if (($post_type == 'product' || $post_type == 'product_variation') && $post_status != false) {
					if (isset($_REQUEST['_woo_deactivate_compare_feature']) && $_REQUEST['_woo_deactivate_compare_feature'] == 'no') {
						update_post_meta($post_id, '_woo_deactivate_compare_feature', 'no');
					}else {
						update_post_meta($post_id, '_woo_deactivate_compare_feature', 'yes');
					}
					$compare_category = $_REQUEST['_woo_compare_category'];
					update_post_meta($post_id, '_woo_compare_category', $compare_category);

					if ($compare_category > 0) {
						$category_data = WC_Compare_Categories_Data::get_row($compare_category);
						if ( $category_data != NULL ) update_post_meta($post_id, '_woo_compare_category_name', stripslashes($category_data->category_name));

						$compare_fields = WC_Compare_Categories_Fields_Data::get_results("cat_id='".$compare_category."'", 'cf.field_order ASC');
						if (is_array($compare_fields) && count($compare_fields)>0) {
							foreach ($compare_fields as $field_data) {
								if ( isset($_REQUEST['_woo_compare_'.$field_data->field_key]) ) {
									update_post_meta($post_id, '_woo_compare_'.$field_data->field_key, $_REQUEST['_woo_compare_'.$field_data->field_key]);
								}
							}
						}
					}else {
						update_post_meta($post_id, '_woo_compare_category_name', '');
					}
				}
				$compare_product_message = '<div class="updated" id="result_msg"><p>'.__('Compare Product Feature Fields Successfully updated.', 'woo_cp').'.</p></div>';
			}
		}
?>
<style>
	.update_message{padding:10px; background-color:#FFFFCC;border:1px solid #DDDDDD;margin-bottom:15px;}
	body .flexigrid div.sDiv{display:block;}
	.flexigrid div.sDiv .sDiv2 select{display:none;}
	.flexigrid div.sDiv .cp_search, .flexigrid div.sDiv .cp_reset{cursor:pointer;}
	.edit_product_compare{cursor:pointer; text-decoration:underline; color:#06F;}
	.icon32-compare-product {
		background:url(<?php echo WOOCP_IMAGES_URL; ?>/a3-plugins.png) no-repeat left top !important;
	}
	.pro_feature_fields {
		padding:0 10px 10px 10px;	
	}
</style>
<div id="htmlForm">
<div style="clear:both"></div>
<div class="wrap a3rev_panel_container a3rev_manager_panel_container">
	<div id="a3_plugin_panel_container"><div id="a3_plugin_panel_fields">
	<div class="icon32 icon32-compare-product" id="icon32-compare-product"><br></div>
	<h2><?php _e('WooCommerce Compare Products Manager', 'woo_cp'); ?></h2>
    <?php echo $compare_product_message; ?>
    <div style="clear:both; margin-bottom:20px;"></div>
    <div class="pro_feature_fields">
    <?php global $wc_compare_admin_init; $wc_compare_admin_init->upgrade_top_message(true); ?>
    <table id="woocp_products_manager" style="display:none"></table>
    </div>
    <?php
		$woocp_products_manager = wp_create_nonce("woocp-products-manager");
	?>
    <script type="text/javascript">
		function alert_upgrade(text) {
			var answer = confirm(text)
			if (answer){
				window.open("<?php echo WOOCP_AUTHOR_URI; ?>", '_blank')
			}else{
				return false;
			}
		}
	(function($){
		$(function(){
			$("#woocp_products_manager").flexigrid({
				url: '<?php echo admin_url( 'admin-ajax.php', 'relative' ) .'?action=woocp_get_products&security='.$woocp_products_manager; ?>',
				dataType: 'json',
				width: 'auto',
				resizable: false,
				colModel : [
					{display: '<?php _e( "No", 'woo_cp' ); ?>', name : 'number', width : 20, sortable : false, align: 'right'},
					{display: '<?php _e( "Product Name", 'woo_cp' ); ?>', name : 'title', width : 200, sortable : true, align: 'left'},
					{display: '<?php _e( "Product Category", 'woo_cp' ); ?>', name : 'cat', width : 110, sortable : false, align: 'left'},
					{display: '<?php _e( "Compare Category", 'woo_cp' ); ?>', name : '_woo_compare_category_name', width : 110, sortable : true, align: 'left'},
					{display: '<?php _e( "Activated / Deactivated", 'woo_cp' ) ;?>', name : '_woo_deactivate_compare_feature', width : 110, sortable : false, align: 'center'},
					{display: '<?php _e( "Edit", 'woo_cp' ); ?>', name : 'edit', width : 30, sortable : false, align: 'center'}
					],
				searchitems : [
					{display: '<?php _e( "Product Name", 'woo_cp' ); ?>', name : 'title', isdefault: true}
					],
				sortname: "title",
				sortorder: "asc",
				usepager: true,
				title: '<?php _e( "Products", 'woo_cp' ); ?>',
				findtext: '<?php _e( "Find Product Name", 'woo_cp' ); ?>',
				useRp: true,
				rp: <?php echo $rp; ?>, //results per page
				newp: <?php echo $paged; ?>,
				page: <?php echo $paged; ?>,
				query: '<?php echo $query; ?>',
				qtype: '<?php echo $qtype; ?>',
				sortname: '<?php echo $sortname; ?>',
				sortorder: '<?php echo $sortorder; ?>',
				rpOptions: [10, 15, 20, 30, 50, 100], //allowed per-page values
				showToggleBtn: false, //show or hide column toggle popup
				showTableToggleBtn: false,
				height: 'auto',
				variations: '<?php echo $cp_show_variations; ?>'
			});
			$(document).on("click", ".edit_product_compare", function(ev){
				return alert_upgrade('<?php _e( 'Please upgrade to the Pro Version to activate Products express Compare feature manager', 'woo_cp' ); ?>');
			});
		});
	})(jQuery);
	</script>
</div><div id="a3_plugin_panel_upgrade_area"><div id="a3_plugin_panel_extensions"><?php echo WC_Compare_Functions::plugin_pro_notice(); ?></div></div></div>
</div>
</div>
<?php
	}

	public static function woocp_compare_products_script() {
		echo'<style>
			#TB_ajaxContent{padding-bottom:0 !important; padding-right:0 !important; height:auto !important; width:auto !important;}
			#TB_iframeContent{width:auto !important; padding-right:10px !important; margin-bottom:0px !important; max-height:480px !important;}
		</style>';
		$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.pack';
		$woo_suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

		//wp_enqueue_script('jquery');
		// validate
		wp_enqueue_script('woocp_flexigrid_script', WOOCP_JS_URL . '/flexigrid/js/flexigrid'.$suffix.'.js');
		wp_enqueue_style( 'woocp_flexigrid_style', WOOCP_JS_URL . '/flexigrid/css/flexigrid'.$suffix.'.css' );

		//wp_enqueue_script('thickbox');
		//wp_enqueue_style('thickbox');
	}
}
?>
