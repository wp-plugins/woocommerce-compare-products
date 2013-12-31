<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
WC Compare Product Page Compare Tab Settings

TABLE OF CONTENTS

- var parent_tab
- var subtab_data
- var option_name
- var form_key
- var position
- var form_fields
- var form_messages

- __construct()
- subtab_init()
- set_default_settings()
- get_settings()
- subtab_data()
- add_subtab()
- settings_form()
- init_form_fields()

-----------------------------------------------------------------------------------*/

class WC_Compare_Product_Page_Compare_Tab_Settings extends WC_Compare_Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = 'product-page';
	
	/**
	 * @var array
	 */
	private $subtab_data;
	
	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = 'woo_compare_product_page_tab';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'woo_compare_product_page_tab';
	
	/**
	 * @var string
	 * You can change the order show of this sub tab in list sub tabs
	 */
	private $position = 4;
	
	/**
	 * @var array
	 */
	public $form_fields = array();
	
	/**
	 * @var array
	 */
	public $form_messages = array();
		
	/*-----------------------------------------------------------------------------------*/
	/* __construct() */
	/* Settings Constructor */
	/*-----------------------------------------------------------------------------------*/
	public function __construct() {
		
		$this->init_form_fields();
		$this->subtab_init();
		
		$this->form_messages = array(
				'success_message'	=> __( 'Product Page Compare Tab Settings successfully saved.', 'woo_cp' ),
				'error_message'		=> __( 'Error: Product Page Compare Tab Settings can not save.', 'woo_cp' ),
				'reset_message'		=> __( 'Product Page Compare Tab Settings successfully reseted.', 'woo_cp' ),
			);
			
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_end', array( $this, 'include_script' ) );
			
		add_action( $this->plugin_name . '_set_default_settings' , array( $this, 'set_default_settings' ) );
				
		add_action( $this->plugin_name . '_get_all_settings' , array( $this, 'get_settings' ) );
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* subtab_init() */
	/* Sub Tab Init */
	/*-----------------------------------------------------------------------------------*/
	public function subtab_init() {
		
		add_filter( $this->plugin_name . '-' . $this->parent_tab . '_settings_subtabs_array', array( $this, 'add_subtab' ), $this->position );
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* set_default_settings()
	/* Set default settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function set_default_settings() {
		global $wc_compare_admin_interface;
		
		$wc_compare_admin_interface->reset_settings( $this->form_fields, $this->option_name, false );
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* get_settings()
	/* Get settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function get_settings() {
		global $wc_compare_admin_interface;
		
		$wc_compare_admin_interface->get_settings( $this->form_fields, $this->option_name );
	}
	
	/**
	 * subtab_data()
	 * Get SubTab Data
	 * =============================================
	 * array ( 
	 *		'name'				=> 'my_subtab_name'				: (required) Enter your subtab name that you want to set for this subtab
	 *		'label'				=> 'My SubTab Name'				: (required) Enter the subtab label
	 * 		'callback_function'	=> 'my_callback_function'		: (required) The callback function is called to show content of this subtab
	 * )
	 *
	 */
	public function subtab_data() {
		
		$subtab_data = array( 
			'name'				=> 'compare-tab',
			'label'				=> __( 'Product Page Compare Tab', 'woo_cp' ),
			'callback_function'	=> 'wc_compare_product_page_compare_tab_settings_form',
		);
		
		if ( $this->subtab_data ) return $this->subtab_data;
		return $this->subtab_data = $subtab_data;
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* add_subtab() */
	/* Add Subtab to Admin Init
	/*-----------------------------------------------------------------------------------*/
	public function add_subtab( $subtabs_array ) {
	
		if ( ! is_array( $subtabs_array ) ) $subtabs_array = array();
		$subtabs_array[] = $this->subtab_data();
		
		return $subtabs_array;
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* settings_form() */
	/* Call the form from Admin Interface
	/*-----------------------------------------------------------------------------------*/
	public function settings_form() {
		global $wc_compare_admin_interface;
		
		$output = '';
		$output .= $wc_compare_admin_interface->admin_forms( $this->form_fields, $this->form_key, $this->option_name, $this->form_messages );
		
		return $output;
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* init_form_fields() */
	/* Init all fields of this form */
	/*-----------------------------------------------------------------------------------*/
	public function init_form_fields() {
		
  		// Define settings			
     	$this->form_fields = apply_filters( $this->option_name . '_settings_fields', array(
			array(
            	'name' 		=> __( "Product Page Compare Tab", 'woo_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( "Compare Features Tab", 'woo_cp' ),
				'class'		=> 'disable_compare_featured_tab',
				'id' 		=> 'disable_compare_featured_tab',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 0,
				'checked_value'		=> 0,
				'unchecked_value' 	=> 1,
				'checked_label'		=> __( 'ON', 'woo_cp' ),
				'unchecked_label' 	=> __( 'OFF', 'woo_cp' ),
			),
			
			array(
            	'name' 		=> __( "Compare Tab Position", 'woo_cp' ),
				'class'		=> 'produc_page_compare_tab_activate_container',
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Compare Features Tab', 'woo_cp' ),
				'desc_tip'	=> __( 'Select the position of the Compare Features tab on the default WooCommerce product page Nav bar. Products Compare feature list shows under the tab.', 'woo_cp' ),
				'id' 		=> 'auto_compare_featured_tab',
				'type' 		=> 'onoff_radio',
				'default'	=> 29,
				'onoff_options' => array(
					array(
						'val' 				=> 9,
						'text' 				=> __( 'Before Description tab', 'woo_cp' ),
						'checked_label'		=> __( 'ON', 'woo_cp') ,
						'unchecked_label' 	=> __( 'OFF', 'woo_cp') ,
					),
					array(
						'val' 				=> 19,
						'text' 				=> __( 'Between  Description and Additional tabs', 'woo_cp' ),
						'checked_label'		=> __( 'ON', 'woo_cp') ,
						'unchecked_label' 	=> __( 'OFF', 'woo_cp') ,
					),
					array(
						'val' 				=> 29,
						'text' 				=> __( 'Between  Additional and Reviews tabs', 'woo_cp' ),
						'checked_label'		=> __( 'ON', 'woo_cp') ,
						'unchecked_label' 	=> __( 'OFF', 'woo_cp') ,
					),
					array(
						'val' 				=> 31,
						'text' 				=> __( 'After Reviews tab', 'woo_cp' ),
						'checked_label'		=> __( 'ON', 'woo_cp') ,
						'unchecked_label' 	=> __( 'OFF', 'woo_cp') ,
					),
				),
			),
			array(  
				'name' 		=> __( 'Compare Tab Name', 'woo_cp' ),
				'id' 		=> 'compare_featured_tab',
				'type' 		=> 'text',
				'default'	=> __('Technical Details', 'woo_cp')
			),

        ));
	}
	
	public function include_script() {
	?>
<script>
(function($) {
	
	$(document).ready(function() {
		
		if ( $("input.disable_compare_featured_tab:checked").val() == '0') {
			$(".produc_page_compare_tab_activate_container").slideDown();
			//$(".produc_page_compare_tab_activate_container").css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
		} else {
			$(".produc_page_compare_tab_activate_container").slideUp();
			//$(".produc_page_compare_tab_activate_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
		}
		
		$(document).on( "a3rev-ui-onoff_checkbox-switch", '.disable_compare_featured_tab', function( event, value, status ) {
			//$(".produc_page_compare_tab_activate_container").hide().css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
			if ( status == 'true' ) {
				$(".produc_page_compare_tab_activate_container").slideDown();
			} else {
				$(".produc_page_compare_tab_activate_container").slideUp();
			}
		});
		
	});
	
})(jQuery);
</script>
    <?php	
	}
	
}

global $wc_compare_product_page_compare_tab_settings;
$wc_compare_product_page_compare_tab_settings = new WC_Compare_Product_Page_Compare_Tab_Settings();

/** 
 * wc_compare_product_page_compare_tab_settings_form()
 * Define the callback function to show subtab content
 */
function wc_compare_product_page_compare_tab_settings_form() {
	global $wc_compare_product_page_compare_tab_settings;
	$wc_compare_product_page_compare_tab_settings->settings_form();
}

?>