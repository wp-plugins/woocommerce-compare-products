<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( get_option( 'a3rev_woocp_lite_is_updating_2_1_9_3' ) ) return;

update_option( 'a3rev_woocp_lite_is_updating_2_1_9_3', true );

global $wpdb;
$sql = "ALTER TABLE " . $wpdb->prefix . "woo_compare_cat_fields CHANGE `cat_id` `cat_id` BIGINT( 20 ) NOT NULL ;";
$wpdb->query( $sql );

$sql = "ALTER TABLE " . $wpdb->prefix . "woo_compare_cat_fields CHANGE `field_id` `field_id` BIGINT( 20 ) NOT NULL ;";
$wpdb->query( $sql );