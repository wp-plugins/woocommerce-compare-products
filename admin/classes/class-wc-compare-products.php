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
class WC_Compare_Products_Class {
	function woocp_get_products() {
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

	function woocp_popup_features() {
		check_ajax_referer( 'woocp-popup-features', 'security' );
		$post_id = 0;
		$paged = 1;
		$rp = 10;
		$sortname = 'title';
		$sortorder = 'asc';
		$cp_show_variations = 0;
		$query = false;
		$qtype = false;
		$product_data = explode('|', $_REQUEST['product_data']);
		if (is_array($product_data) && count($product_data) > 0) {
			$post_id = $product_data[0];
			$paged = $product_data[1];
			$rp = $product_data[2];
			$sortname = $product_data[3];
			$sortorder = $product_data[4];
			$cp_show_variations = $product_data[5];
			$qtype = $product_data[6];
		}
		if (isset($_REQUEST['search_string']) && trim($_REQUEST['search_string']) != '') $query = trim($_REQUEST['search_string']);

		$woocp_product_compare = wp_create_nonce("woocp-product-compare");
		$deactivate_compare_feature = get_post_meta( $post_id, '_woo_deactivate_compare_feature', true );
		$compare_category = get_post_meta( $post_id, '_woo_compare_category', true );
?>
		<style>
		#compare_cat_fields table td input[type="text"], #compare_cat_fields table td textare, #compare_cat_fields table td select{ width:250px !important; }
		</style>
        <script type="text/javascript">
		(function($){
			$(function(){
				$("#compare_category").change(function(){
					var cat_id = $(this).val();
					var post_id = <?php echo $post_id; ?>;
					$(".compare_widget_loader").show();
					var data = {
                        action: 'woocp_product_get_fields',
                        cat_id: cat_id,
                        post_id: post_id,
                        security: '<?php echo $woocp_product_compare; ?>'
                    };
                    $.post('<?php echo admin_url('admin-ajax.php'); ?>', data, function(response) {
						$(".compare_widget_loader").hide();
						$("#compare_cat_fields").html(response);
					});
				});
			});
		})(jQuery);
		</script>
		<div id="TB_iframeContent" style="position:relative;width:100%;">
        <div style="padding:10px 25px;">
        <form action="admin.php?page=woo-compare-settings&tab=compare-products" method="post" name="form_product_features">
        	<input type="hidden" name="paged" value="<?php echo $paged; ?>" />
            <input type="hidden" name="rp" value="<?php echo $rp; ?>" />
            <input type="hidden" name="sortname" value="<?php echo $sortname; ?>" />
            <input type="hidden" name="sortorder" value="<?php echo $sortorder; ?>" />
            <input type="hidden" name="cp_show_variations" value="<?php echo $cp_show_variations; ?>" />
            <input type="hidden" name="qtype" value="<?php echo $qtype; ?>" />
        	<input type="hidden" name="query" value="<?php echo $query; ?>" />
        	<h3 style="margin-top:0; padding-top:20px;"><?php echo WC_Compare_Functions::get_variation_name($post_id); ?></h3>
            <input type="hidden" name="productid" value="<?php echo $post_id; ?>" />
            <p><input id='deactivate_compare_feature' type='checkbox' value='no' <?php if ( $deactivate_compare_feature == 'no' ) echo 'checked="checked"'; else echo ''; ?> name='_woo_deactivate_compare_feature' style="float:none; width:auto; display:inline-block;" />
            <label style="display:inline-block" for='deactivate_compare_feature' class='small'><?php _e( "Activate Compare Feature for this Product", 'woo_cp' ); ?></label></p>
            <label style="display:inline-block; float:left;" for='compare_category' class='small'><?php _e( "Select a  Compare Category for this Product", 'woo_cp' ); ?> :</label>
            <p style="margin:0; padding:0; margin-left:290px;"><select name="_woo_compare_category" id="compare_category" style="width:180px; margin-top:-2px;">
                    <option value="0"><?php _e('Select...', 'woo_cp'); ?></option>
            <?php
		$compare_cats = WC_Compare_Categories_Data::get_results('', 'category_order ASC');
		if (is_array($compare_cats) && count($compare_cats)>0) {
			foreach ($compare_cats as $cat_data) {
				if ($compare_category == $cat_data->id) {
					echo '<option selected="selected" value="'.$cat_data->id.'">'.stripslashes($cat_data->category_name).'</option>';
				}else {
					echo '<option value="'.$cat_data->id.'">'.stripslashes($cat_data->category_name).'</option>';
				}
			}
		}
?>
                </select> <img class="compare_widget_loader" style="display:none;" src="<?php echo WOOCP_IMAGES_URL; ?>/ajax-loader.gif" border=0 />
            </p>
            <div style="clear:both; margin-bottom:10px;"></div>
            <div id="compare_cat_fields" style=""><?php WC_Compare_MetaBox::woo_show_field_of_cat($post_id, $compare_category); ?></div>

            <div style="text-align:left; display:inline-block; padding:10px 0 30px 0;">
            	<input type="submit" name="bt_update_product_features" id="bt_update_product_features" class="button" value="<?php _e( "Update", 'woo_cp' ); ?>" /> 
                <a onclick="tb_remove(); return false;" href="#" style="color:#21759B; margin-left:10px;"><?php _e( "Cancel", 'woo_cp' ); ?></a>
            </div>
        </form>
        </div>
        </div>
		<?php
		die();
	}

	function woocp_products_manager() {
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
						update_post_meta($post_id, '_woo_compare_category_name', stripslashes($category_data->category_name));

						$compare_fields = WC_Compare_Categories_Fields_Data::get_results("cat_id='".$compare_category."'", 'cf.field_order ASC');
						if (is_array($compare_fields) && count($compare_fields)>0) {
							foreach ($compare_fields as $field_data) {
								update_post_meta($post_id, '_woo_compare_'.$field_data->field_key, $_REQUEST['_woo_compare_'.$field_data->field_key]);
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
	<?php echo WC_Compare_Functions::products_tab_extension(); ?>
    <h3><?php _e('WooCommerce Compare Products Manager', 'woo_cp'); ?></h3>
    <?php echo $compare_product_message; ?>
    <div style="clear:both; margin-bottom:40px;"></div>
    <table id="woocp_products_manager" style="display:none"></table>
    <?php
		$woocp_products_manager = wp_create_nonce("woocp-products-manager");
		$woocp_popup_features = wp_create_nonce("woocp-popup-features");
?>
    <script type="text/javascript">
	(function($){
		$(function(){
			$("#woocp_products_manager").flexigrid({
				url: '<?php echo admin_url("admin-ajax.php").'?action=woocp_get_products&security='.$woocp_products_manager; ?>',
				dataType: 'json',
				width: 'auto',
				resizable: false,
				colModel : [
					{display: '<?php _e( "No", 'woo_cp' ); ?>', name : 'number', width : 30, sortable : false, align: 'right'},
					{display: '<?php _e( "Product Name", 'woo_cp' ); ?>', name : 'title', width : 380, sortable : true, align: 'left'},
					{display: '<?php _e( "Product Category", 'woo_cp' ); ?>', name : 'cat', width : 160, sortable : false, align: 'left'},
					{display: '<?php _e( "Compare Category", 'woo_cp' ); ?>', name : '_woo_compare_category_name', width : 160, sortable : true, align: 'left'},
					{display: '<?php _e( "Activated / Deactivated", 'woo_cp' ) ;?>', name : '_woo_deactivate_compare_feature', width : 110, sortable : false, align: 'center'},
					{display: '<?php _e( "Edit", 'woo_cp' ); ?>', name : 'edit', width : 50, sortable : false, align: 'center'}
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
				variations: <?php echo $cp_show_variations; ?>
			});
			$(".edit_product_compare").live("click", function(ev){
				return alert_upgrade('<?php _e( 'Please upgrade to the Pro Version to activate Products express Compare feature manager', 'woo_cp' ); ?>');
			});
		});
	})(jQuery);
	</script>
<?php
	}

	function woocp_compare_products_script() {
		//global $woocommerce;
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

		//wp_enqueue_style( 'woocommerce_fancybox_styles', $woocommerce->plugin_url() . '/assets/css/fancybox'.$woo_suffix.'.css' );
		//wp_enqueue_script( 'fancybox', $woocommerce->plugin_url() . '/assets/js/fancybox'.$woo_suffix.'.js');
		wp_enqueue_script('thickbox');
		wp_enqueue_style('thickbox');
	}
}
?>
