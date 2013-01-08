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
class WC_Compare_Categories_Class {
	
	function init_categories_actions() {
		global $wpdb;
		$cat_msg = '';
		if(isset($_REQUEST['bt_save_cat'])){
		}
		
		if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'cat-delete'){
		}
		return $cat_msg;
	}
	
	function woocp_categories_manager() {
		global $wpdb;
?>
		<div class="compare_upgrade_area"><?php echo WC_Compare_Functions::create_category_extension(); ?>
        <h3><?php if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'cat-edit') { _e('Edit Compare Product Categories', 'woo_cp');}else { _e('Add Compare Product Categories', 'woo_cp'); } ?></h3>
        <?php if(isset($_REQUEST['act']) && $_REQUEST['act'] != 'cat-edit'){?><p><?php _e('Create Categories based on groups of products that share the same compare feature list.', 'woo_cp'); ?></p><?php } ?>
        <form action="admin.php?page=woo-compare-settings&tab=features" method="post" name="form_add_compare" id="form_add_compare">
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
	        	<input type="button" onclick="javascript:return alert_upgrade('<?php _e('Please upgrade to the Pro Version to activate Compare categories', 'woo_cp') ; ?>');" name="bt_save_cat" id="bt_save_cat" class="button-primary" value="<?php if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'cat-edit') { _e('Save', 'woo_cp'); }else { _e('Create', 'woo_cp'); } ?>"  /> <a href="admin.php?page=woo-compare-settings&tab=features" style="text-decoration:none;"><input type="button" name="cancel" value="<?php _e('Cancel', 'woo_cp'); ?>" class="button" /></a>
	    	</p>
        </form>
        </div>
	<?php
	}

	function woocp_update_cat_orders() {
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
