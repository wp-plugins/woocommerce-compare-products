<?php
include( '../../../wp-config.php');
if(isset($_REQUEST['action']) && trim($_REQUEST['action']) == 'update_orders'){
	$updateRecordsArray 	= $_REQUEST['recordsArray'];
		
	$listingCounter = 1;
	foreach ($updateRecordsArray as $recordIDValue) {
		WOO_Compare_Data::update_order($recordIDValue, $listingCounter);
		$listingCounter++;
	}
	
	_e('You just save the order for compare fields.', 'woo_cp');
}elseif(isset($_REQUEST['action']) && trim($_REQUEST['action']) == 'add_to_compare'){
	$product_id 	= $_REQUEST['product_id'];
	WOO_Compare_Functions::add_product_to_compare_list($product_id);
	echo WOO_Compare_Functions::get_compare_list_html_widget();
}elseif(isset($_REQUEST['action']) && trim($_REQUEST['action']) == 'remove_from_compare'){
	$product_id 	= $_REQUEST['product_id'];
	WOO_Compare_Functions::delete_product_on_compare_list($product_id);
	echo WOO_Compare_Functions::get_compare_list_html_widget();
}elseif(isset($_REQUEST['action']) && trim($_REQUEST['action']) == 'remove_from_popup_compare'){
	$product_id 	= $_REQUEST['product_id'];
	WOO_Compare_Functions::delete_product_on_compare_list($product_id);
	echo WOO_Compare_Functions::get_compare_list_html_popup();
}elseif(isset($_REQUEST['action']) && trim($_REQUEST['action']) == 'clear_compare'){
	WOO_Compare_Functions::clear_compare_list();
	echo WOO_Compare_Functions::get_compare_list_html_widget();
}elseif(isset($_REQUEST['action']) && trim($_REQUEST['action']) == 'update_compare_widget'){
	echo WOO_Compare_Functions::get_compare_list_html_widget();
}elseif(isset($_REQUEST['action']) && trim($_REQUEST['action']) == 'update_total_compare'){
	echo WOO_Compare_Functions::get_total_compare_list();
}elseif(isset($_REQUEST['action']) && trim($_REQUEST['action']) == 'get_variation_compare'){
	$variation_id = $_REQUEST['variation_id'];
	echo WOO_Compare_MetaBox::woo_variations_compare_feature_box($variation_id);
}
?>