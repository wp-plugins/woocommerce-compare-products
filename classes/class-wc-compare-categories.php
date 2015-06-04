<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Handles compare categories in admin
 *
 */
class WC_Admin_Compare_Categories {

	/**
	 * Constructor
	 */
	public function __construct() {
		
		// Include script
		$this->include_script();

		// Add form
		add_action( 'product_cat_add_form_fields', array( $this, 'add_category_fields' ) );
		add_action( 'product_cat_edit_form', array( $this, 'edit_category_fields' ), 10, 2 );

	}
	
	/**
	 * Include script and style to show plugin framework for Category page.
	 *
	 */
	public function include_script( ) {
		if ( ! in_array( basename( $_SERVER['PHP_SELF'] ), array( 'edit-tags.php' ) ) ) return;
		if ( ! isset( $_REQUEST['taxonomy'] ) || ! in_array( $_REQUEST['taxonomy'], array( 'product_cat' ) ) ) return;
		
		global $wc_compare_admin_interface;
		add_action( 'admin_footer', array( $wc_compare_admin_interface, 'admin_script_load' ) );
		add_action( 'admin_footer', array( $wc_compare_admin_interface, 'admin_css_load' ) );
		add_action( 'admin_footer', array( $this, 'include_style' ) );
	}
	
	/**
	 * Include script to append the Compare Feature meta fields into Product Attribute page.
	 *
	 */
	public function include_style( ) {
		?>
        <style>
		div.a3rev_panel_container {
			border-top:1px dotted #666;
			border-bottom:1px dotted #666;
			margin-bottom:20px;
		}
		tr.compare-category-field-start {
			border-top:1px dotted #666;
		}
		tr.compare-category-field-end {
			border-bottom:1px dotted #666;
		}
		.a3rev_panel_container label {
			padding: 0 !important;	
		}
		</style>
	<?php
    }

	/**
	 * Add Compare Category fields.
	 *
	 * @access public
	 * @return void
	 */
	public function add_category_fields() {
		?>
        <div class="a3rev_panel_container">
        	<div class="a3_wc_compare_plugin_meta_upgrade_area_box">
        	<?php global $wc_compare_admin_init; $wc_compare_admin_init->upgrade_top_message(true); ?>
            <h3><?php _e( 'Comparison Category', 'woo_cp' ); ?></h3>
            <div class="form-field">
                <input type="hidden" name="have_compare_category_field" value="yes"  />
                <input type="checkbox" class="a3rev-ui-onoff_checkbox" checked="checked" id="is_compare_cat" name="is_compare_cat" value="yes" style="width:auto;a" /> <label for="is_compare_cat"><?php _e( 'ON to activate as a Compare Category', 'woo_cp' ); ?></label>
            </div>
            </div>
        </div>
		<?php
	}

	/**
	 * Edit Compare Category field.
	 *
	 * @access public
	 * @param mixed $term Term (category) being edited
	 * @param mixed $taxonomy Taxonomy of the term being edited
	 */
	public function edit_category_fields( $term, $taxonomy ) {

		?>
        <div class="a3rev_panel_container">
        	<div class="a3_wc_compare_plugin_meta_upgrade_area_box">
        	<?php global $wc_compare_admin_init; $wc_compare_admin_init->upgrade_top_message(true); ?>
        	<h3><?php _e( 'Comparison Category', 'woo_cp' ); ?></h3>
            <input type="hidden" name="have_compare_feature_field" value="yes"  />
            <table class="form-table">
                <tbody>
                    <tr class="form-field">
                        <th scope="row" valign="top"><label for="is_compare_cat"><?php _e( 'Compare Category', 'woo_cp' ); ?></label></th>
                        <td>
                            <input type="hidden" name="have_compare_category_field" value="yes"  />
                            <input type="checkbox" class="a3rev-ui-onoff_checkbox" name="is_compare_cat" id="is_compare_cat" value="yes" style="width:auto;" /><label for="is_compare_cat"><?php _e( 'ON to activate as a Compare Category', 'woo_cp' ); ?></label>
                        </td>
                    </tr>
            	</tbody>
            </table>
			</div>
        </div>
		<?php
	}
}

new WC_Admin_Compare_Categories();
