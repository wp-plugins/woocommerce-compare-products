<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $wpdb;
$collate = '';
if ( $wpdb->has_cap( 'collation' ) ) {
	if( ! empty($wpdb->charset ) ) $collate .= "DEFAULT CHARACTER SET $wpdb->charset";
	if( ! empty($wpdb->collate ) ) $collate .= " COLLATE $wpdb->collate";
}
$sql = "ALTER TABLE ".$wpdb->prefix . "woo_compare_fields $collate";
$wpdb->query($sql);

$sql = "ALTER TABLE ".$wpdb->prefix . "woo_compare_categories $collate";
$wpdb->query($sql);

$sql = "ALTER TABLE ".$wpdb->prefix . "woo_compare_cat_fields $collate";
$wpdb->query($sql);