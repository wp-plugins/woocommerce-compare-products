<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WooCommerce Compare Categories
 *
 * Table Of Contents
 *
 * init_categories_actions()
 * woocp_categories_manager()
 * woocp_update_cat_orders()
 */
class WC_Compare_Categories_Class
{
	
	public static function init_categories_actions() {
		global $wpdb;
		$cat_msg = '';
		if(isset($_REQUEST['bt_save_cat'])){
			$category_name = trim(strip_tags(addslashes($_REQUEST['category_name'])));
			if(isset($_REQUEST['category_id']) && $_REQUEST['category_id'] > 0){
				$old_data = WC_Compare_Categories_Data::get_row($_REQUEST['category_id']);
				$count_category_name = WC_Compare_Categories_Data::get_count("category_name = '".$category_name."' AND id != '".$_REQUEST['category_id']."'");
				if ($category_name != '' && $count_category_name == 0) {
					$result = WC_Compare_Categories_Data::update_row($_REQUEST);
					$wpdb->query('UPDATE '.$wpdb->prefix.'postmeta SET meta_value="'.$category_name.'" WHERE meta_value="'.$old_data->category_name.'" AND meta_key="_wpsc_compare_category_name" ');
					$cat_msg = '<div class="updated below-h2" id="result_msg"><p>'.__('Compare Category Successfully edited', 'woo_cp').'.</p></div>';
				}else {
					$cat_msg = '<div class="error below-h2" id="result_msg"><p>'.__('Nothing edited! You already have a Compare Category with that name. Use unique names to edit each Compare Category.', 'woo_cp').'</p></div>';
				}
			}else{
				$count_category_name = WC_Compare_Categories_Data::get_count("category_name = '".$category_name."'");
				if ($category_name != '' && $count_category_name == 0) {
					$category_id = WC_Compare_Categories_Data::insert_row($_REQUEST);
					if ($category_id > 0) {
						$cat_msg = '<div class="updated below-h2" id="result_msg"><p>'.__('Compare Category Successfully created', 'woo_cp').'.</p></div>';
					}else {
						$cat_msg = '<div class="error below-h2" id="result_msg"><p>'.__('Compare Category Error created', 'woo_cp').'.</p></div>';
					}
				}else {
					$cat_msg = '<div class="error below-h2" id="result_msg"><p>'.__('Nothing created! You already have a Compare Category with that name. Use unique names to create each Compare Category.', 'woo_cp').'</p></div>';
				}
			}
		}
		
		if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'cat-delete'){
			$category_id = trim($_REQUEST['category_id']);
			WC_Compare_Categories_Data::delete_row($category_id);
			WC_Compare_Categories_Fields_Data::delete_row("cat_id='".$category_id."'");
			$cat_msg = '<div class="updated below-h2" id="result_msg"><p>'.__('Compare Category deleted','woo_cp').'.</p></div>';
		}
		return $cat_msg;
	}
	
	public static function woocp_categories_manager() {
		global $wpdb;
?>

        <h3><?php if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'cat-edit') { _e('Edit Compare Product Categories', 'woo_cp');}else { _e('Add Compare Product Categories', 'woo_cp'); } ?></h3>
        <?php if(isset($_REQUEST['act']) && $_REQUEST['act'] != 'cat-edit'){?><p><?php _e('Create Categories based on groups of products that share the same compare feature list.', 'woo_cp'); ?></p><?php } ?>
        <form action="admin.php?page=woo-compare-features" method="post" name="form_add_compare" id="form_add_compare">
        <?php
		if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'cat-edit') {
			$category_id = $_REQUEST['category_id'];
			$cat_data = WC_Compare_Categories_Data::get_row($category_id);
		?>
        	<input type="hidden" value="<?php echo $category_id; ?>" name="category_id" id="category_id" />
        <?php		
			}
		?>
        	<table class="form-table">
                <tbody>
                	<tr valign="top">
                    	<th class="titledesc" scope="rpw"><label for="category_name"><?php if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'cat-edit'){ _e('Edit Category Name', 'woo_cp'); } else { _e('Category Name', 'woo_cp'); } ?></label></th>
                        <td class="forminp"><input type="text" name="category_name" id="category_name" value="<?php if (!empty($cat_data)) { echo stripslashes($cat_data->category_name); } ?>" style="min-width:300px" /></td>
                    </tr>
                </tbody>
            </table>
            <p class="submit">
	        	<input type="submit" name="bt_save_cat" id="bt_save_cat" class="button button-primary" value="<?php if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'cat-edit') { _e('Save', 'woo_cp'); }else { _e('Create', 'woo_cp'); } ?>"  /> <?php if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'cat-edit') { ?><input type="button" class="button" onclick="window.location='admin.php?page=woo-compare-features'" value="<?php _e('Cancel', 'woo_cp'); ?>" /><?php } ?>
	    	</p>
        </form>
	<?php
	}

	public static function woocp_update_cat_orders() {
		check_ajax_referer( 'woocp-update-cat-order', 'security' );
		$updateRecordsArray  = $_REQUEST['recordsArray'];

		$listingCounter = 1;
		foreach ($updateRecordsArray as $recordIDValue) {
			WC_Compare_Categories_Data::update_order($recordIDValue, $listingCounter);
			$listingCounter++;
		}
		
		_e('You just save the order for compare categories.', 'woo_cp');
		die();
	}

}
?>