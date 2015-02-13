<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( get_option( 'a3rev_woocp_lite_is_updating_2_1_8' ) ) return;

update_option( 'a3rev_woocp_lite_is_updating_2_1_8', true );

$woo_compare_product_page_settings = get_option('woo_compare_product_page_settings', array() );
$woo_compare_product_page_settings['product_page_button_margin_top'] = $woo_compare_product_page_settings['product_page_button_below_padding'];
$woo_compare_product_page_settings['product_page_button_margin_bottom'] = $woo_compare_product_page_settings['product_page_button_above_padding'];
update_option('woo_compare_product_page_settings', $woo_compare_product_page_settings);

$woo_compare_product_page_button_style = get_option('woo_compare_product_page_button_style', array() );
$woo_compare_product_page_button_style['product_compare_link_font'] = array(
				'size'					=> $woo_compare_product_page_button_style['product_compare_link_font_size'],
				'face'					=> $woo_compare_product_page_button_style['product_compare_link_font'],
				'style'					=> $woo_compare_product_page_button_style['product_compare_link_font_style'],
				'color'					=> $woo_compare_product_page_button_style['product_compare_link_font_colour'],
	);
$woo_compare_product_page_button_style['button_font'] = array(
				'size'					=> $woo_compare_product_page_button_style['button_font_size'],
				'face'					=> $woo_compare_product_page_button_style['button_font'],
				'style'					=> $woo_compare_product_page_button_style['button_font_style'],
				'color'					=> $woo_compare_product_page_button_style['button_font_colour'],
	);
$woo_compare_product_page_button_style['button_border'] = array(
				'width'					=> $woo_compare_product_page_button_style['button_border_size'],
				'style'					=> $woo_compare_product_page_button_style['button_border_style'],
				'color'					=> $woo_compare_product_page_button_style['button_border_colour'],
				'corner'				=> $woo_compare_product_page_button_style['button_border_rounded'],
				'top_left_corner'		=> $woo_compare_product_page_button_style['button_border_rounded_value'],
				'top_right_corner'		=> $woo_compare_product_page_button_style['button_border_rounded_value'],
				'bottom_left_corner'	=> $woo_compare_product_page_button_style['button_border_rounded_value'],
				'bottom_right_corner'	=> $woo_compare_product_page_button_style['button_border_rounded_value'],
	);
update_option('woo_compare_product_page_button_style', $woo_compare_product_page_button_style);

$woo_compare_product_page_view_compare_style = get_option('woo_compare_product_page_view_compare_style', array() );
$woo_compare_product_page_view_compare_style['product_view_compare_link_font'] = array(
				'size'					=> $woo_compare_product_page_view_compare_style['product_view_compare_link_font_size'],
				'face'					=> $woo_compare_product_page_view_compare_style['product_view_compare_link_font'],
				'style'					=> $woo_compare_product_page_view_compare_style['product_view_compare_link_font_style'],
				'color'					=> $woo_compare_product_page_view_compare_style['product_view_compare_link_font_colour'],
	);
$woo_compare_product_page_view_compare_style['button_font'] = array(
				'size'					=> $woo_compare_product_page_view_compare_style['button_font_size'],
				'face'					=> $woo_compare_product_page_view_compare_style['button_font'],
				'style'					=> $woo_compare_product_page_view_compare_style['button_font_style'],
				'color'					=> $woo_compare_product_page_view_compare_style['button_font_colour'],
	);
$woo_compare_product_page_view_compare_style['button_border'] = array(
				'width'					=> $woo_compare_product_page_view_compare_style['button_border_size'],
				'style'					=> $woo_compare_product_page_view_compare_style['button_border_style'],
				'color'					=> $woo_compare_product_page_view_compare_style['button_border_colour'],
				'corner'				=> $woo_compare_product_page_view_compare_style['button_border_rounded'],
				'top_left_corner'		=> $woo_compare_product_page_view_compare_style['button_border_rounded_value'],
				'top_right_corner'		=> $woo_compare_product_page_view_compare_style['button_border_rounded_value'],
				'bottom_left_corner'	=> $woo_compare_product_page_view_compare_style['button_border_rounded_value'],
				'bottom_right_corner'	=> $woo_compare_product_page_view_compare_style['button_border_rounded_value'],
	);
update_option('woo_compare_product_page_view_compare_style', $woo_compare_product_page_view_compare_style);

$woo_compare_widget_style = get_option('woo_compare_widget_style', array() );	
$woo_compare_widget_style['text_font'] = array(
				'size'					=> $woo_compare_widget_style['text_font_size'],
				'face'					=> $woo_compare_widget_style['text_font'],
				'style'					=> $woo_compare_widget_style['text_font_style'],
				'color'					=> $woo_compare_widget_style['text_font_colour'],
	);
update_option('woo_compare_widget_style', $woo_compare_widget_style);

$woo_compare_widget_title_style = get_option('woo_compare_widget_title_style', array() );
$woo_compare_widget_title_style['widget_title_font'] = array(
				'size'					=> $woo_compare_widget_title_style['widget_title_font_size'],
				'face'					=> $woo_compare_widget_title_style['widget_title_font'],
				'style'					=> $woo_compare_widget_title_style['widget_title_font_style'],
				'color'					=> $woo_compare_widget_title_style['widget_title_font_colour'],
	);
$woo_compare_widget_title_style['total_font'] = array(
				'size'					=> $woo_compare_widget_title_style['total_font_size'],
				'face'					=> $woo_compare_widget_title_style['total_font'],
				'style'					=> $woo_compare_widget_title_style['total_font_style'],
				'color'					=> $woo_compare_widget_title_style['total_font_colour'],
	);
$woo_compare_widget_title_style['widget_title_border'] = array(
				'width'					=> $woo_compare_widget_title_style['widget_title_border_size_bottom'],
				'style'					=> $woo_compare_widget_title_style['widget_title_border_style'],
				'color'					=> $woo_compare_widget_title_style['widget_title_border_colour'],
				'corner'				=> $woo_compare_widget_title_style['widget_title_border_rounded'],
				'top_left_corner'		=> $woo_compare_widget_title_style['widget_title_border_rounded_value'],
				'top_right_corner'		=> $woo_compare_widget_title_style['widget_title_border_rounded_value'],
				'bottom_left_corner'	=> $woo_compare_widget_title_style['widget_title_border_rounded_value'],
				'bottom_right_corner'	=> $woo_compare_widget_title_style['widget_title_border_rounded_value'],
	);
update_option('woo_compare_widget_title_style', $woo_compare_widget_title_style);

$woo_compare_widget_button_style = get_option('woo_compare_widget_button_style', array() );
$woo_compare_widget_button_style['compare_widget_link_font'] = array(
				'size'					=> $woo_compare_widget_button_style['compare_widget_link_font_size'],
				'face'					=> $woo_compare_widget_button_style['compare_widget_link_font'],
				'style'					=> $woo_compare_widget_button_style['compare_widget_link_font_style'],
				'color'					=> $woo_compare_widget_button_style['compare_widget_link_font_colour'],
	);
$woo_compare_widget_button_style['button_font'] = array(
				'size'					=> $woo_compare_widget_button_style['button_font_size'],
				'face'					=> $woo_compare_widget_button_style['button_font'],
				'style'					=> $woo_compare_widget_button_style['button_font_style'],
				'color'					=> $woo_compare_widget_button_style['button_font_colour'],
	);
$woo_compare_widget_button_style['button_border'] = array(
				'width'					=> $woo_compare_widget_button_style['button_border_size'],
				'style'					=> $woo_compare_widget_button_style['button_border_style'],
				'color'					=> $woo_compare_widget_button_style['button_border_colour'],
				'corner'				=> $woo_compare_widget_button_style['button_border_rounded'],
				'top_left_corner'		=> $woo_compare_widget_button_style['button_border_rounded_value'],
				'top_right_corner'		=> $woo_compare_widget_button_style['button_border_rounded_value'],
				'bottom_left_corner'	=> $woo_compare_widget_button_style['button_border_rounded_value'],
				'bottom_right_corner'	=> $woo_compare_widget_button_style['button_border_rounded_value'],
	);
update_option('woo_compare_widget_button_style', $woo_compare_widget_button_style);

$woo_compare_widget_clear_all_style = get_option('woo_compare_widget_clear_all_style', array() );
$woo_compare_widget_clear_all_style['clear_text_font'] = array(
				'size'					=> $woo_compare_widget_clear_all_style['clear_text_font_size'],
				'face'					=> $woo_compare_widget_clear_all_style['clear_text_font'],
				'style'					=> $woo_compare_widget_clear_all_style['clear_text_font_style'],
				'color'					=> $woo_compare_widget_clear_all_style['clear_text_font_colour'],
	);
$woo_compare_widget_clear_all_style['clear_all_button_font'] = array(
				'size'					=> $woo_compare_widget_clear_all_style['clear_all_button_font_size'],
				'face'					=> $woo_compare_widget_clear_all_style['clear_all_button_font'],
				'style'					=> $woo_compare_widget_clear_all_style['clear_all_button_font_style'],
				'color'					=> $woo_compare_widget_clear_all_style['clear_all_button_font_colour'],
	);
$woo_compare_widget_clear_all_style['clear_all_button_border'] = array(
				'width'					=> $woo_compare_widget_clear_all_style['clear_all_button_border_size'],
				'style'					=> $woo_compare_widget_clear_all_style['clear_all_button_border_style'],
				'color'					=> $woo_compare_widget_clear_all_style['clear_all_button_border_colour'],
				'corner'				=> $woo_compare_widget_clear_all_style['clear_all_button_border_rounded'],
				'top_left_corner'		=> $woo_compare_widget_clear_all_style['clear_all_button_border_rounded_value'],
				'top_right_corner'		=> $woo_compare_widget_clear_all_style['clear_all_button_border_rounded_value'],
				'bottom_left_corner'	=> $woo_compare_widget_clear_all_style['clear_all_button_border_rounded_value'],
				'bottom_right_corner'	=> $woo_compare_widget_clear_all_style['clear_all_button_border_rounded_value'],
	);
update_option('woo_compare_widget_clear_all_style', $woo_compare_widget_clear_all_style);
	
$woo_compare_widget_thumbnail_style = get_option('woo_compare_widget_thumbnail_style', array() );
$woo_compare_widget_thumbnail_style['thumb_border'] = array(
				'width'					=> $woo_compare_widget_thumbnail_style['thumb_border_size'],
				'style'					=> $woo_compare_widget_thumbnail_style['thumb_border_style'],
				'color'					=> $woo_compare_widget_thumbnail_style['thumb_border_colour'],
				'corner'				=> $woo_compare_widget_thumbnail_style['thumb_border_rounded'],
				'top_left_corner'		=> $woo_compare_widget_thumbnail_style['thumb_border_rounded_value'],
				'top_right_corner'		=> $woo_compare_widget_thumbnail_style['thumb_border_rounded_value'],
				'bottom_left_corner'	=> $woo_compare_widget_thumbnail_style['thumb_border_rounded_value'],
				'bottom_right_corner'	=> $woo_compare_widget_thumbnail_style['thumb_border_rounded_value'],
	);
update_option('woo_compare_widget_thumbnail_style', $woo_compare_widget_thumbnail_style);
	
$woo_compare_grid_view_settings = get_option('woo_compare_grid_view_settings', array() );
$woo_compare_grid_view_settings['grid_view_button_margin_top'] = $woo_compare_grid_view_settings['grid_view_button_below_padding'];
$woo_compare_grid_view_settings['grid_view_button_margin_bottom'] = $woo_compare_grid_view_settings['grid_view_button_above_padding'];
update_option('woo_compare_grid_view_settings', $woo_compare_grid_view_settings);

$woo_compare_grid_view_button_style = get_option('woo_compare_grid_view_button_style', array() );
$woo_compare_grid_view_button_style['link_font'] = array(
				'size'					=> $woo_compare_grid_view_button_style['link_font_size'],
				'face'					=> $woo_compare_grid_view_button_style['link_font'],
				'style'					=> $woo_compare_grid_view_button_style['link_font_style'],
				'color'					=> $woo_compare_grid_view_button_style['link_font_colour'],
	);
$woo_compare_grid_view_button_style['button_font'] = array(
				'size'					=> $woo_compare_grid_view_button_style['button_font_size'],
				'face'					=> $woo_compare_grid_view_button_style['button_font'],
				'style'					=> $woo_compare_grid_view_button_style['button_font_style'],
				'color'					=> $woo_compare_grid_view_button_style['button_font_colour'],
	);
$woo_compare_grid_view_button_style['button_border'] = array(
				'width'					=> $woo_compare_grid_view_button_style['button_border_size'],
				'style'					=> $woo_compare_grid_view_button_style['button_border_style'],
				'color'					=> $woo_compare_grid_view_button_style['button_border_colour'],
				'corner'				=> $woo_compare_grid_view_button_style['button_border_rounded'],
				'top_left_corner'		=> $woo_compare_grid_view_button_style['button_border_rounded_value'],
				'top_right_corner'		=> $woo_compare_grid_view_button_style['button_border_rounded_value'],
				'bottom_left_corner'	=> $woo_compare_grid_view_button_style['button_border_rounded_value'],
				'bottom_right_corner'	=> $woo_compare_grid_view_button_style['button_border_rounded_value'],
	);
update_option('woo_compare_grid_view_button_style', $woo_compare_grid_view_button_style);

$woo_compare_gridview_view_compare_style = get_option('woo_compare_gridview_view_compare_style', array() );
$woo_compare_gridview_view_compare_style['gridview_view_compare_link_font'] = array(
				'size'					=> $woo_compare_gridview_view_compare_style['gridview_view_compare_link_font_size'],
				'face'					=> $woo_compare_gridview_view_compare_style['gridview_view_compare_link_font'],
				'style'					=> $woo_compare_gridview_view_compare_style['gridview_view_compare_link_font_style'],
				'color'					=> $woo_compare_gridview_view_compare_style['gridview_view_compare_link_font_colour'],
	);
update_option('woo_compare_gridview_view_compare_style', $woo_compare_gridview_view_compare_style);

$woo_compare_page_style = get_option('woo_compare_page_style', array() );
$woo_compare_page_style['no_product_message_font'] = array(
				'size'					=> $woo_compare_page_style['no_product_message_font_size'],
				'face'					=> $woo_compare_page_style['no_product_message_font'],
				'style'					=> $woo_compare_page_style['no_product_message_font_style'],
				'color'					=> $woo_compare_page_style['no_product_message_font_colour'],
	);
$woo_compare_page_style['header_bottom_border'] = array(
				'width'					=> $woo_compare_page_style['header_bottom_border_size'],
				'style'					=> $woo_compare_page_style['header_bottom_border_style'],
				'color'					=> $woo_compare_page_style['header_bottom_border_colour'],
	);
update_option('woo_compare_page_style', $woo_compare_page_style);

$woo_compare_table_style = get_option('woo_compare_table_style', array() );
$woo_compare_table_style['table_border'] = array(
				'width'					=> $woo_compare_table_style['table_border_size'],
				'style'					=> $woo_compare_table_style['table_border_style'],
				'color'					=> $woo_compare_table_style['table_border_colour'],
	);
$woo_compare_table_style['table_row_padding_top'] = $woo_compare_table_style['row_padding_topbottom'];
$woo_compare_table_style['table_row_padding_bottom'] = $woo_compare_table_style['row_padding_topbottom'];
$woo_compare_table_style['table_row_padding_left'] = $woo_compare_table_style['row_padding_leftright'];
$woo_compare_table_style['table_row_padding_right'] = $woo_compare_table_style['row_padding_leftright'];
update_option('woo_compare_table_style', $woo_compare_table_style);

$woo_compare_table_content_style = get_option('woo_compare_table_content_style', array() );
$woo_compare_table_content_style['feature_title_font'] = array(
				'size'					=> $woo_compare_table_content_style['feature_title_font_size'],
				'face'					=> $woo_compare_table_content_style['feature_title_font'],
				'style'					=> $woo_compare_table_content_style['feature_title_font_style'],
				'color'					=> $woo_compare_table_content_style['feature_title_font_colour'],
	);
$woo_compare_table_content_style['content_font'] = array(
				'size'					=> $woo_compare_table_content_style['content_font_size'],
				'face'					=> $woo_compare_table_content_style['content_font'],
				'style'					=> $woo_compare_table_content_style['content_font_style'],
				'color'					=> $woo_compare_table_content_style['content_font_colour'],
	);
$woo_compare_table_content_style['empty_font'] = array(
				'size'					=> $woo_compare_table_content_style['empty_font_size'],
				'face'					=> $woo_compare_table_content_style['empty_font'],
				'style'					=> $woo_compare_table_content_style['empty_font_style'],
				'color'					=> $woo_compare_table_content_style['empty_font_colour'],
	);
$woo_compare_table_content_style['product_name_font'] = array(
				'size'					=> $woo_compare_table_content_style['product_name_font_size'],
				'face'					=> $woo_compare_table_content_style['product_name_font'],
				'style'					=> $woo_compare_table_content_style['product_name_font_style'],
				'color'					=> $woo_compare_table_content_style['product_name_font_colour'],
	);
update_option('woo_compare_table_content_style', $woo_compare_table_content_style);

$woo_compare_product_prices_style = get_option('woo_compare_product_prices_style', array() );
$woo_compare_product_prices_style['price_font'] = array(
				'size'					=> $woo_compare_product_prices_style['price_font_size'],
				'face'					=> $woo_compare_product_prices_style['price_font'],
				'style'					=> $woo_compare_product_prices_style['price_font_style'],
				'color'					=> $woo_compare_product_prices_style['price_font_colour'],
	);
update_option('woo_compare_product_prices_style', $woo_compare_product_prices_style);

$woo_compare_addtocart_style = get_option('woo_compare_addtocart_style', array() );
$woo_compare_addtocart_style['addtocart_link_font'] = array(
				'size'					=> $woo_compare_addtocart_style['addtocart_link_font_size'],
				'face'					=> $woo_compare_addtocart_style['addtocart_link_font'],
				'style'					=> $woo_compare_addtocart_style['addtocart_link_font_style'],
				'color'					=> $woo_compare_addtocart_style['addtocart_link_font_colour'],
	);
$woo_compare_addtocart_style['addtocart_button_font'] = array(
				'size'					=> $woo_compare_addtocart_style['addtocart_button_font_size'],
				'face'					=> $woo_compare_addtocart_style['addtocart_button_font'],
				'style'					=> $woo_compare_addtocart_style['addtocart_button_font_style'],
				'color'					=> $woo_compare_addtocart_style['addtocart_button_font_colour'],
	);
$woo_compare_addtocart_style['addtocart_button_border'] = array(
				'width'					=> $woo_compare_addtocart_style['addtocart_button_border_size'],
				'style'					=> $woo_compare_addtocart_style['addtocart_button_border_style'],
				'color'					=> $woo_compare_addtocart_style['addtocart_button_border_colour'],
				'corner'				=> $woo_compare_addtocart_style['addtocart_button_border_rounded'],
				'top_left_corner'		=> $woo_compare_addtocart_style['addtocart_button_border_rounded_value'],
				'top_right_corner'		=> $woo_compare_addtocart_style['addtocart_button_border_rounded_value'],
				'bottom_left_corner'	=> $woo_compare_addtocart_style['addtocart_button_border_rounded_value'],
				'bottom_right_corner'	=> $woo_compare_addtocart_style['addtocart_button_border_rounded_value'],
	);
update_option('woo_compare_addtocart_style', $woo_compare_addtocart_style);

$woo_compare_viewcart_style = get_option('woo_compare_viewcart_style', array() );
$woo_compare_viewcart_style['viewcart_link_font'] = array(
				'size'					=> $woo_compare_viewcart_style['viewcart_link_font_size'],
				'face'					=> $woo_compare_viewcart_style['viewcart_link_font'],
				'style'					=> $woo_compare_viewcart_style['viewcart_link_font_style'],
				'color'					=> $woo_compare_viewcart_style['viewcart_link_font_colour'],
	);
update_option('woo_compare_viewcart_style', $woo_compare_viewcart_style);

$woo_compare_print_message_style = get_option('woo_compare_print_message_style', array() );
$woo_compare_print_button_style = get_option('woo_compare_print_button_style', array() );
$woo_compare_print_page_settings = array();
$woo_compare_print_page_settings = array_merge( $woo_compare_print_page_settings, $woo_compare_print_message_style );
$woo_compare_print_page_settings = array_merge( $woo_compare_print_page_settings, $woo_compare_print_button_style );
$woo_compare_print_page_settings['print_message_font'] = array(
				'size'					=> $woo_compare_print_message_style['print_message_font_size'],
				'face'					=> $woo_compare_print_message_style['print_message_font'],
				'style'					=> $woo_compare_print_message_style['print_message_font_style'],
				'color'					=> $woo_compare_print_message_style['print_message_font_colour'],
	);
$woo_compare_print_page_settings['print_link_font'] = array(
				'size'					=> $woo_compare_print_button_style['print_link_font_size'],
				'face'					=> $woo_compare_print_button_style['print_link_font'],
				'style'					=> $woo_compare_print_button_style['print_link_font_style'],
				'color'					=> $woo_compare_print_button_style['print_link_font_colour'],
	);
$woo_compare_print_page_settings['button_font'] = array(
				'size'					=> $woo_compare_print_button_style['button_font_size'],
				'face'					=> $woo_compare_print_button_style['button_font'],
				'style'					=> $woo_compare_print_button_style['button_font_style'],
				'color'					=> $woo_compare_print_button_style['button_font_colour'],
	);
$woo_compare_print_page_settings['button_border'] = array(
				'width'					=> $woo_compare_print_button_style['button_border_size'],
				'style'					=> $woo_compare_print_button_style['button_border_style'],
				'color'					=> $woo_compare_print_button_style['button_border_colour'],
				'corner'				=> $woo_compare_print_button_style['button_border_rounded'],
				'top_left_corner'		=> $woo_compare_print_button_style['button_border_rounded_value'],
				'top_right_corner'		=> $woo_compare_print_button_style['button_border_rounded_value'],
				'bottom_left_corner'	=> $woo_compare_print_button_style['button_border_rounded_value'],
				'bottom_right_corner'	=> $woo_compare_print_button_style['button_border_rounded_value'],
	);
update_option('woo_compare_print_page_settings', $woo_compare_print_page_settings);

$woo_compare_close_window_button_style = get_option('woo_compare_close_window_button_style', array() );
$woo_compare_close_window_button_style['close_link_font'] = array(
				'size'					=> $woo_compare_close_window_button_style['close_link_font_size'],
				'face'					=> $woo_compare_close_window_button_style['close_link_font'],
				'style'					=> $woo_compare_close_window_button_style['close_link_font_style'],
				'color'					=> $woo_compare_close_window_button_style['close_link_font_colour'],
	);
$woo_compare_close_window_button_style['button_font'] = array(
				'size'					=> $woo_compare_close_window_button_style['button_font_size'],
				'face'					=> $woo_compare_close_window_button_style['button_font'],
				'style'					=> $woo_compare_close_window_button_style['button_font_style'],
				'color'					=> $woo_compare_close_window_button_style['button_font_colour'],
	);
$woo_compare_close_window_button_style['button_border'] = array(
				'width'					=> $woo_compare_close_window_button_style['button_border_size'],
				'style'					=> $woo_compare_close_window_button_style['button_border_style'],
				'color'					=> $woo_compare_close_window_button_style['button_border_colour'],
				'corner'				=> $woo_compare_close_window_button_style['button_border_rounded'],
				'top_left_corner'		=> $woo_compare_close_window_button_style['button_border_rounded_value'],
				'top_right_corner'		=> $woo_compare_close_window_button_style['button_border_rounded_value'],
				'bottom_left_corner'	=> $woo_compare_close_window_button_style['button_border_rounded_value'],
				'bottom_right_corner'	=> $woo_compare_close_window_button_style['button_border_rounded_value'],
	);
update_option('woo_compare_close_window_button_style', $woo_compare_close_window_button_style);