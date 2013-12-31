<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * WooCommerce Compare Grid View Settings Class
 *
 * Table Of Contents
 *
 * get_settings()
 *
 */
class WC_Compare_Grid_View_Settings
{
	
	public static function get_settings() {
		global $woo_compare_grid_view_settings;
		
		if ( !is_array( $woo_compare_grid_view_settings ) || count( $woo_compare_grid_view_settings ) < 1 )
			$woo_compare_grid_view_settings = get_option('woo_compare_grid_view_settings');
		
		return $woo_compare_grid_view_settings;
	}
}
?>