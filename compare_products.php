<?php
/*
Plugin Name: WooCommerce Compare Products Lite
Plugin URI: http://www.a3rev.com/
Description: WooCommerce Compare Products Lite plugin.
Version: 1.0.2
Author: A3 Revolution Software Development team
Author URI: http://www.a3rev.com/
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, <http://www.gnu.org/licenses/>.
*/

/*
	WooCommerce Compare Products Lite. Plugin for the WooCommerce plugin.
	Copyright © 2011 A3 Revolution Software Development team
	
	A3 Revolution Software Development team
	admin@a3rev.com
	PO Box 1170
	Gympie 4570
	QLD Australia
*/

/*
== Changelog ==

= 1.0.2 - 02/04/2012 =
* Use wp_ajax and wp_ajax_nopriv instead of custom ajax handlers
* Add the Fancybox - lightbox Fly-Out screen option
* remove the fading update message script. Use default wordpress 'updated' messages
* Auto add Compare Widget into a sidebar. Support for sidebar has names : primary, primary-widget-area, sidebar-1. If do not see them then auto add to first sidebar
* Add Tool Tips and Guide into Settings page
* Use wp_ajax and wp_ajax_nopriv for popup, remove popup file.
* Update Settings page

= 1.0.1 - 22/03/2012 =
* Remove srcipt don't need for this plugin

= 1.0.0 - 15/03/2012 =
* First working release of the modification

*/
?>
<?php
define('WOOCP_FILE_PATH', dirname(__FILE__));
define('WOOCP_DIR_NAME', basename(WOOCP_FILE_PATH));
define('WOOCP_FOLDER', dirname(plugin_basename(__FILE__)));
define('WOOCP_URL', WP_CONTENT_URL.'/plugins/'.WOOCP_FOLDER);
define( 'WOOCP_CORE_IMAGES_URL',  WOOCP_URL . '/images' );
define( 'WOOCP_IMAGES_FOLDER',  WOOCP_URL . '/images' );

update_option('a3rev_woocp_version', '1.0.2');
include('compare_class.php');
include('compare_filter.php');
include('compare_data.php');
include('compare_functions.php');
include('compare_metabox.php');
include('compare_widget.php');
include('compare_admin.php');

function woo_add_compare_button($product_id='', $echo=false){
	$html = WOO_Compare_Hook_Filter::add_compare_button($product_id);	
	if($echo) echo $html;
	else return $html;
}

function woo_show_compare_fields($product_id='', $echo=false){
	$html = WOO_Compare_Hook_Filter::show_compare_fields($product_id);
	if($echo) echo $html;
	else return $html;
}

register_activation_hook(__FILE__,'woo_compare_set_settings');
?>
