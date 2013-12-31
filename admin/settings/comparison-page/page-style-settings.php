<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
WC Comparison Page Style Settings

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

class WC_Compare_Comparison_Page_Style_Settings extends WC_Compare_Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = 'comparison-page';
	
	/**
	 * @var array
	 */
	private $subtab_data;
	
	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = 'woo_compare_page_style';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'woo_compare_page_style';
	
	/**
	 * @var string
	 * You can change the order show of this sub tab in list sub tabs
	 */
	private $position = 2;
	
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
				'success_message'	=> __( 'Comparison Page Style successfully saved.', 'woo_cp' ),
				'error_message'		=> __( 'Error: Comparison Page Styles can not save.', 'woo_cp' ),
				'reset_message'		=> __( 'Comparison Page Style successfully reseted.', 'woo_cp' ),
			);
			
			
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
			'name'				=> 'comparison-page-style',
			'label'				=> __( 'Page Style', 'woo_cp' ),
			'callback_function'	=> 'wc_compare_comparison_page_style_settings_form',
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
            	'name' 		=> __( 'Comparison Page Header', 'woo_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Background Colour', 'woo_cp' ),
				'desc' 		=> __( 'Default', 'woo_cp' ) . ' [default_value]',
				'id' 		=> 'header_bg_colour',
				'type' 		=> 'color',
				'default'	=> '#FFFFFF'
			),
			array(  
				'name' 		=> __( 'Bottom Border', 'woo_cp' ),
				'id' 		=> 'header_bottom_border',
				'type' 		=> 'border_styles',
				'default'	=> array( 'width' => '3px', 'style' => 'solid', 'color' => '#666666' ),
			),
			
			array(
            	'name' 		=> __( 'Comparison Page Body', 'woo_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Background Colour', 'woo_cp' ),
				'desc' 		=> __( 'Default', 'woo_cp' ) . ' [default_value]',
				'id' 		=> 'body_bg_colour',
				'type' 		=> 'color',
				'default'	=> '#FFFFFF'
			),
			
			array(
            	'name' 		=> __( 'Comparison Empty Window Message', 'woo_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Comparison Empty Window Message Text', 'woo_cp' ),
				'desc' 		=> __( "Default <code>'[default_value]'</code>", 'woo_cp' ),
				'id' 		=> 'no_product_message_text',
				'type' 		=> 'text',
				'default'	=> __('You do not have any product to compare.', 'woo_cp')
			),
			array(  
				'name' 		=> __( "Text Alignment", 'woo_cp' ),
				'desc' 		=> __( "Default <code>Center</code>.", 'woo_cp' ),
				'id' 		=> 'no_product_message_align',
				'css' 		=> 'width:80px;',
				'type' 		=> 'select',
				'default'	=> 'center',
				'options'	=> array(
						'left'			=> __( 'Left', 'woo_cp' ) ,	
						'center'		=> __( 'Center', 'woo_cp' ) ,	
						'right'			=> __( 'Right', 'woo_cp' ) ,
					),
			),
			array(  
				'name' 		=> __( 'Message Font', 'woo_cp' ),
				'id' 		=> 'no_product_message_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '12px', 'face' => 'Arial, sans-serif', 'style' => 'normal', 'color' => '#000000' )
			),
			
        ));
	}
	
}

global $wc_compare_comparison_page_style_settings;
$wc_compare_comparison_page_style_settings = new WC_Compare_Comparison_Page_Style_Settings();

/** 
 * wc_compare_comparison_page_style_settings_form()
 * Define the callback function to show subtab content
 */
function wc_compare_comparison_page_style_settings_form() {
	global $wc_compare_comparison_page_style_settings;
	$wc_compare_comparison_page_style_settings->settings_form();
}

?>