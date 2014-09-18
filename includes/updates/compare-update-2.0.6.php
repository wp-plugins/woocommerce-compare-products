<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

WC_Compare_Functions::create_page( esc_sql( 'product-comparison' ), '', __('Product Comparison', 'woo_cp'), '[product_comparison_page]' );