<?php
/**
 * WooCommerce Compare Upgrade
 *
 * Table Of Contents
 *
 * upgrade_version_1_0_5()
 */
class WOO_Compare_Upgrade{
	function upgrade_version_1_0_5(){
		WOO_Compare_Class::woocp_set_setting_default();
		update_option('a3rev_woocp_version', '1.0.5');
	}
}
?>