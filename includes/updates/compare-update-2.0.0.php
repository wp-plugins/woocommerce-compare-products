<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $wpdb;
$sql = "ALTER TABLE ". $wpdb->prefix . "woo_compare_fields CHANGE `field_name` `field_name` blob NOT NULL";
$wpdb->query($sql);

$sql = "ALTER TABLE ". $wpdb->prefix . "woo_compare_fields CHANGE `field_unit` `field_unit` blob NOT NULL";
$wpdb->query($sql);

$sql = "ALTER TABLE ". $wpdb->prefix . "woo_compare_fields CHANGE `field_description` `field_description` blob NOT NULL";
$wpdb->query($sql);

$sql = "ALTER TABLE ". $wpdb->prefix . "woo_compare_categories CHANGE `category_name` `category_name` blob NOT NULL";
$wpdb->query($sql);

$sql = "ALTER TABLE ". $wpdb->prefix . "woo_compare_fields CHANGE `default_value` `default_value` blob NOT NULL";
$wpdb->query($sql);