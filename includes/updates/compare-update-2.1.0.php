<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$comparable_settings = get_option('woo_comparable_settings');
$woo_compare_comparison_page_global_settings = get_option('woo_compare_comparison_page_global_settings', array() );
$woo_compare_comparison_page_global_settings['open_compare_type'] = $comparable_settings['open_compare_type'];
update_option('woo_compare_comparison_page_global_settings', $woo_compare_comparison_page_global_settings);

$woo_compare_product_page_button_style = get_option('woo_compare_product_page_button_style', array() );
$woo_compare_product_page_button_style['product_compare_button_type'] = $comparable_settings['button_type'];
$woo_compare_product_page_button_style['product_compare_button_text'] = $comparable_settings['button_text'];
$woo_compare_product_page_button_style['product_compare_link_text'] = $comparable_settings['button_text'];
update_option('woo_compare_product_page_button_style', $woo_compare_product_page_button_style);

$woo_compare_product_page_settings = get_option('woo_compare_product_page_settings', array() );
$woo_compare_product_page_settings['product_page_button_position'] = $comparable_settings['button_position'];
$woo_compare_product_page_settings['product_page_button_below_padding'] = $comparable_settings['below_padding'];
$woo_compare_product_page_settings['product_page_button_above_padding'] = $comparable_settings['above_padding'];
$woo_compare_product_page_settings['auto_add'] = $comparable_settings['auto_add'];
update_option('woo_compare_product_page_settings', $woo_compare_product_page_settings);

$woo_compare_product_page_tab = get_option('woo_compare_product_page_tab', array() );
$woo_compare_product_page_tab['compare_featured_tab'] = $comparable_settings['compare_featured_tab'];
if ($comparable_settings['auto_compare_featured_tab'] == 0) {
	$woo_compare_product_page_tab['disable_compare_featured_tab'] = 1;
} else {
	$woo_compare_product_page_tab['auto_compare_featured_tab'] = $comparable_settings['auto_compare_featured_tab'];
}
update_option('woo_compare_product_page_tab', $woo_compare_product_page_tab);