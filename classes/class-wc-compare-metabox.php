<?php
/**
 * WooCommerce Compare Meta Box
 *
 * Add Meta box into Product Edit screen page
 *
 * Table Of Contents
 *
 * compare_meta_boxes()
 * woocp_product_get_fields()
 * woo_compare_feature_box()
 * woo_show_field_of_cat()
 * woo_variations_compare_feature_box()
 * woo_variation_show_field_of_cat()
 * woocp_get_variation_compare()
 * woocp_variation_get_fields()
 * variable_compare_meta_boxes()
 * save_compare_meta_boxes()
 */
class WC_Compare_MetaBox {
	function compare_meta_boxes() {
		global $post;
		$pagename = 'product';
		add_meta_box( 'woo_compare_feature_box', __('Compare Feature Fields', 'woo_cp'), array('WC_Compare_MetaBox', 'woo_compare_feature_box'), $pagename, 'normal', 'high' );
	}

	function woocp_product_get_fields() {
		check_ajax_referer( 'woocp-product-compare', 'security' );
		$cat_id = $_REQUEST['cat_id'];
		$post_id = $_REQUEST['post_id'];
		WC_Compare_MetaBox::woo_show_field_of_cat($post_id, $cat_id);
		die();
	}

	function woo_compare_feature_box() {
		$woocp_product_compare = wp_create_nonce("woocp-product-compare");
		global $post;
		$master_category_id = get_option('master_category_compare');
		$post_id = $post->ID;
		$deactivate_compare_feature = get_post_meta( $post_id, '_woo_deactivate_compare_feature', true );
		$compare_category = get_post_meta( $post_id, '_woo_compare_category', true );
?>
        <script type="text/javascript">
		(function($){
			$(function(){
				$("#compare_category").change(function(){
					var cat_id = $(this).val();
					var post_id = <?php echo $post_id; ?>;
					$(".compare_widget_loader").show();
					var data = {
                        action: 'woocp_product_get_fields',
                        cat_id: cat_id,
                        post_id: post_id,
                        security: '<?php echo $woocp_product_compare; ?>'
                    };
                    $.post('<?php echo admin_url('admin-ajax.php'); ?>', data, function(response) {
						$(".compare_widget_loader").hide();
						$("#compare_cat_fields").html(response);
					});
				});
			});
		})(jQuery);
		</script>
        <p><input id='deactivate_compare_feature' type='checkbox' value='no' <?php if ( $deactivate_compare_feature == 'no' ) echo 'checked="checked"'; else echo ''; ?> name='_woo_deactivate_compare_feature' style="float:none; width:auto; display:inline-block;" />
		<label style="display:inline-block" for='deactivate_compare_feature' class='small'><?php _e( "Activate Compare Feature for this Product", 'woo_cp' ); ?></label></p>
        <p><label style="display:inline-block" for='compare_category' class='small'><?php _e( "Select a  Compare Category for this Product", 'woo_cp' ); ?></label> :
        	<select name="_woo_compare_category" id="compare_category" style="width:200px;">
            	<option value="0"><?php _e('Select...', 'woo_cp'); ?></option>
        <?php
		$compare_cats = WC_Compare_Categories_Data::get_results("id = '".$master_category_id."'", 'category_order ASC');
		if (is_array($compare_cats) && count($compare_cats)>0) {
			foreach ($compare_cats as $cat_data) {
				if ($compare_category == $cat_data->id) {
					echo '<option selected="selected" value="'.$cat_data->id.'">'.stripslashes($cat_data->category_name).'</option>';
				}else {
					echo '<option value="'.$cat_data->id.'">'.stripslashes($cat_data->category_name).'</option>';
				}
			}
		}
?>
            </select> <img class="compare_widget_loader" style="display:none;" src="<?php echo WOOCP_IMAGES_URL; ?>/ajax-loader.gif" border=0 />
        </p>
        <div id="compare_cat_fields"><?php WC_Compare_MetaBox::woo_show_field_of_cat($post_id, $compare_category); ?></div>
	<?php
	}

	function woo_show_field_of_cat($post_id=0, $cat_id=0) {
		if ($cat_id > 0 && WC_Compare_Categories_Data::get_count("id='".$cat_id."'") > 0) {
?>
    	<style>
			.form-table th{padding-left:0px !important;}
		</style>
        <table cellspacing="0" cellpadding="5" style="width: 100%;" class="form-table">
            <tbody>
        <?php
			$compare_fields = WC_Compare_Categories_Fields_Data::get_results("cat_id='".$cat_id."'", 'cf.field_order ASC');
			if (is_array($compare_fields) && count($compare_fields)>0) {

				foreach ($compare_fields as $field_data) {
?>
                <tr class="form-field">
                    <th valign="top" scope="row"><label style="display:inline-block" for="<?php echo $field_data->field_key; ?>"><strong><?php echo stripslashes($field_data->field_name); ?> : </strong></label><?php if (trim($field_data->field_unit) != '') { ?><br />(<?php echo trim(stripslashes($field_data->field_unit)); ?>)<?php } ?></th>
                    <td>
               	<?php
					$field_value = get_post_meta( $post_id, '_woo_compare_'.$field_data->field_key, true );
					switch ($field_data->field_type) {
					case "text-area":
						echo '<textarea style="width:400px" name="_woo_compare_'.$field_data->field_key.'" id="'.$field_data->field_key.'">'.$field_value.'</textarea>';
						break;

					case "checkbox":
						$default_value = nl2br($field_data->default_value);
						$field_option = explode('<br />', $default_value);
						if (is_serialized($field_value)) $field_value = maybe_unserialize($field_value);
						if (!is_array($field_value)) $field_value = array();
						if (is_array($field_option) && count($field_option) > 0) {
							foreach ($field_option as $option_value) {
								$option_value = trim(stripslashes($option_value));
								if (in_array($option_value, $field_value)) {
									echo '<input type="checkbox" name="_woo_compare_'.$field_data->field_key.'[]" value="'.htmlspecialchars($option_value).'" checked="checked" style="float:none; width:auto; display:inline-block;" /> '.$option_value.' &nbsp;&nbsp;&nbsp;';
								}else {
									echo '<input type="checkbox" name="_woo_compare_'.$field_data->field_key.'[]" value="'.htmlspecialchars($option_value).'" style="float:none; width:auto; display:inline-block;" /> '.$option_value.' &nbsp;&nbsp;&nbsp;';
								}
							}
						}
						break;

					case "radio":
						$default_value = nl2br($field_data->default_value);
						$field_option = explode('<br />', $default_value);
						if (is_array($field_option) && count($field_option) > 0) {
							foreach ($field_option as $option_value) {
								$option_value = trim(stripslashes($option_value));
								if ($option_value == $field_value) {
									echo '<input type="radio" name="_woo_compare_'.$field_data->field_key.'" value="'.htmlspecialchars($option_value).'" checked="checked" style="float:none; width:auto; display:inline-block;" /> '.$option_value.' &nbsp;&nbsp;&nbsp;';
								}else {
									echo '<input type="radio" name="_woo_compare_'.$field_data->field_key.'" value="'.htmlspecialchars($option_value).'" style="float:none; width:auto; display:inline-block;" /> '.$option_value.' &nbsp;&nbsp;&nbsp;';
								}
							}
						}
						break;

					case "drop-down":
						$default_value = nl2br($field_data->default_value);
						$field_option = explode('<br />', $default_value);
						echo '<select name="_woo_compare_'.$field_data->field_key.'" id="'.$field_data->field_key.'" style="width:400px">';
						echo '<option value="">'.__( "Select value", 'woo_cp' ).'</option>';
						if (is_array($field_option) && count($field_option) > 0) {
							foreach ($field_option as $option_value) {
								$option_value = trim(stripslashes($option_value));
								if ($option_value == $field_value) {
									echo '<option value="'.htmlspecialchars($option_value).'" selected="selected">'.$option_value.'</option>';
								}else {
									echo '<option value="'.htmlspecialchars($option_value).'">'.$option_value.'</option>';
								}
							}
						}
						echo '</select>';
						break;

					case "multi-select":
						$default_value = nl2br($field_data->default_value);
						$field_option = explode('<br />', $default_value);
						if (is_serialized($field_value)) $field_value = maybe_unserialize($field_value);
						if (!is_array($field_value)) $field_value = array();
						echo '<select multiple="multiple" name="_woo_compare_'.$field_data->field_key.'[]" id="'.$field_data->field_key.'" style="width:400px">';
						if (is_array($field_option) && count($field_option) > 0) {
							foreach ($field_option as $option_value) {
								$option_value = trim(stripslashes($option_value));
								if (in_array($option_value, $field_value)) {
									echo '<option value="'.htmlspecialchars($option_value).'" selected="selected">'.$option_value.'</option>';
								}else {
									echo '<option value="'.htmlspecialchars($option_value).'">'.$option_value.'</option>';
								}
							}
						}
						echo '</select>';
						break;

					default:
						echo '<input style="width:400px" type="text" name="_woo_compare_'.$field_data->field_key.'" id="'.$field_data->field_key.'" value="'.$field_value.'" />';
						break;
					}
?>
                    </td>
                </tr>
        <?php
				}
			}else {
?>
        		<tr><td><i style="text-decoration:blink"><?php _e('There are no Features created for this category, please add some.', 'woo_cp'); ?> <a href="admin.php?page=woo-compare-settings&tab=features" target="_blank"><?php _e('This page', 'woo_cp'); ?></a></i></td></tr>
        <?php
			}
?>
        	</tbody>
        </table>
		<?php
		}
	}

	function woo_variations_compare_feature_box($post_id) {
		$deactivate_compare_feature = get_post_meta( $post_id, '_woo_deactivate_compare_feature', true );
		$compare_category = get_post_meta( $post_id, '_woo_compare_category', true );
?>
		<br />
        <p><input id='deactivate_compare_feature_<?php echo $post_id; ?>' type='checkbox' value='no' <?php if ( $deactivate_compare_feature == 'no' ) echo 'checked="checked"'; else echo ''; ?> name='variable_woo_deactivate_compare_feature[<?php echo $post_id; ?>]' style="float:none; width:auto; display:inline-block;" />
		<label style="display:inline-block" for='deactivate_compare_feature_<?php echo $post_id; ?>' class='small'><?php _e( "Activate Compare Feature for this Product", 'woo_cp' ); ?></label></p>
        <p><label style="display:inline-block" for='variable_woo_compare_category_<?php echo $post_id; ?>' class='small'><?php _e( "Select a  Compare Category for this Product", 'woo_cp' ); ?></label> :
        	<select name="variable_woo_compare_category[<?php echo $post_id; ?>]" class="variable_compare_category" id="variable_woo_compare_category_<?php echo $post_id; ?>" style="width:200px;" rel="<?php echo $post_id; ?>">
            	<option value="0"><?php _e('Select...', 'woo_cp'); ?></option>
        <?php
		$compare_cats = WC_Compare_Categories_Data::get_results('', 'category_order ASC');
		if (is_array($compare_cats) && count($compare_cats)>0) {
			foreach ($compare_cats as $cat_data) {
				if ($compare_category == $cat_data->id) {
					echo '<option selected="selected" value="'.$cat_data->id.'">'.stripslashes($cat_data->category_name).'</option>';
				}else {
					echo '<option value="'.$cat_data->id.'">'.stripslashes($cat_data->category_name).'</option>';
				}
			}
		}
?>
            </select> <img id="variable_compare_widget_loader_<?php echo $post_id; ?>" style="display:none;" src="<?php echo WOOCP_IMAGES_URL; ?>/ajax-loader.gif" border=0 />
        </p>
        <div id="variable_compare_cat_fields_<?php echo $post_id; ?>"><?php WC_Compare_MetaBox::woo_variation_show_field_of_cat($post_id, $compare_category); ?></div>

	<?php
	}

	function woo_variation_show_field_of_cat($post_id=0, $cat_id=0) {
		if ($cat_id > 0 && WC_Compare_Categories_Data::get_count("id='".$cat_id."'") > 0) {
?>
    	<style>
			.form-table th{padding-left:0px !important;}
		</style>
        <table cellspacing="0" cellpadding="5" style="width: 100%;" class="form-table">
            <tbody>
        <?php
			$compare_fields = WC_Compare_Categories_Fields_Data::get_results("cat_id='".$cat_id."'", 'cf.field_order ASC');
			if (is_array($compare_fields) && count($compare_fields)>0) {

				foreach ($compare_fields as $field_data) {
?>
                <tr class="form-field">
                    <th valign="top" scope="row"><label style="display:inline-block" for="<?php echo $field_data->field_key; ?>_<?php echo $post_id; ?>"><strong><?php echo stripslashes($field_data->field_name); ?> : </strong></label><?php if (trim($field_data->field_unit) != '') { ?><br /> (<?php echo trim(stripslashes($field_data->field_unit)); ?>)<?php } ?></th>
                    <td>
               	<?php
					$field_value = get_post_meta( $post_id, '_woo_compare_'.$field_data->field_key, true );
					switch ($field_data->field_type) {
					case "text-area":
						echo '<textarea style="width:400px" name="variable_woo_compare_'.$field_data->field_key.'['.$post_id.']" id="'.$field_data->field_key.'_'.$post_id.'">'.$field_value.'</textarea>';
						break;

					case "checkbox":
						$default_value = nl2br($field_data->default_value);
						$field_option = explode('<br />', $default_value);
						if (is_serialized($field_value)) $field_value = maybe_unserialize($field_value);
						if (!is_array($field_value)) $field_value = array();
						if (is_array($field_option) && count($field_option) > 0) {
							foreach ($field_option as $option_value) {
								$option_value = trim(stripslashes($option_value));
								if (in_array($option_value, $field_value)) {
									echo '<input type="checkbox" name="variable_woo_compare_'.$field_data->field_key.'['.$post_id.'][]" value="'.htmlspecialchars($option_value).'" checked="checked" style="float:none; width:auto; display:inline-block;" /> '.$option_value.' &nbsp;&nbsp;&nbsp;';
								}else {
									echo '<input type="checkbox" name="variable_woo_compare_'.$field_data->field_key.'['.$post_id.'][]" value="'.htmlspecialchars($option_value).'" style="float:none; width:auto; display:inline-block;" /> '.$option_value.' &nbsp;&nbsp;&nbsp;';
								}
							}
						}
						break;

					case "radio":
						$default_value = nl2br($field_data->default_value);
						$field_option = explode('<br />', $default_value);
						if (is_array($field_option) && count($field_option) > 0) {
							foreach ($field_option as $option_value) {
								$option_value = trim(stripslashes($option_value));
								if ($option_value == $field_value) {
									echo '<input type="radio" name="variable_woo_compare_'.$field_data->field_key.'['.$post_id.']" value="'.htmlspecialchars($option_value).'" checked="checked" style="float:none; width:auto; display:inline-block;" /> '.$option_value.' &nbsp;&nbsp;&nbsp;';
								}else {
									echo '<input type="radio" name="variable_woo_compare_'.$field_data->field_key.'['.$post_id.']" value="'.htmlspecialchars($option_value).'" style="float:none; width:auto; display:inline-block;" /> '.$option_value.' &nbsp;&nbsp;&nbsp;';
								}
							}
						}
						break;

					case "drop-down":
						$default_value = nl2br($field_data->default_value);
						$field_option = explode('<br />', $default_value);
						echo '<select name="variable_woo_compare_'.$field_data->field_key.'['.$post_id.']" id="'.$field_data->field_key.'_'.$post_id.'" style="width:400px">';
						echo '<option value="">'.__( "Select value", 'woo_cp' ).'</option>';
						if (is_array($field_option) && count($field_option) > 0) {
							foreach ($field_option as $option_value) {
								$option_value = trim(stripslashes($option_value));
								if ($option_value == $field_value) {
									echo '<option value="'.htmlspecialchars($option_value).'" selected="selected">'.$option_value.'</option>';
								}else {
									echo '<option value="'.htmlspecialchars($option_value).'">'.$option_value.'</option>';
								}
							}
						}
						echo '</select>';
						break;

					case "multi-select":
						$default_value = nl2br($field_data->default_value);
						$field_option = explode('<br />', $default_value);
						if (is_serialized($field_value)) $field_value = maybe_unserialize($field_value);
						if (!is_array($field_value)) $field_value = array();
						echo '<select multiple="multiple" name="variable_woo_compare_'.$field_data->field_key.'['.$post_id.'][]" id="'.$field_data->field_key.'_'.$post_id.'" style="width:400px">';
						if (is_array($field_option) && count($field_option) > 0) {
							foreach ($field_option as $option_value) {
								$option_value = trim(stripslashes($option_value));
								if (in_array($option_value, $field_value)) {
									echo '<option value="'.htmlspecialchars($option_value).'" selected="selected">'.$option_value.'</option>';
								}else {
									echo '<option value="'.htmlspecialchars($option_value).'">'.$option_value.'</option>';
								}
							}
						}
						echo '</select>';
						break;

					default:
						echo '<input style="width:400px" type="text" name="variable_woo_compare_'.$field_data->field_key.'['.$post_id.']" id="'.$field_data->field_key.'_'.$post_id.'" value="'.$field_value.'" />';
						break;
					}
?>
                    </td>
                </tr>
        <?php
				}
			}else {
?>
        		<tr><td><i style="text-decoration:blink"><?php _e('There are no Features created for this category, please add some.', 'woo_cp'); ?> <a href="admin.php?page=woo-compare-settings&tab=features" target="_blank"><?php _e('This page', 'woo_cp'); ?></a></i></td></tr>
        <?php
			}
?>
        	</tbody>
        </table>
<?php
		}
	}

	function woocp_get_variation_compare() {
		check_ajax_referer( 'woocp-variable-compare', 'security' );
		$variation_id = $_REQUEST['variation_id'];
		echo WC_Compare_MetaBox::woo_variations_compare_feature_box($variation_id);
		die();
	}

	function woocp_variation_get_fields() {
		check_ajax_referer( 'woocp-variable-compare', 'security' );
		$cat_id = $_REQUEST['cat_id'];
		$post_id = $_REQUEST['post_id'];
		WC_Compare_MetaBox::woo_variation_show_field_of_cat($post_id, $cat_id);
		die();
	}

	function variable_compare_meta_boxes() {
		global $post, $woocommerce;
		$post_status = get_post_status($post->ID);
		$post_type = get_post_type($post->ID);
		if ($post_type == 'product' && $post_status != false) {
			$woocp_variable_compare = wp_create_nonce("woocp-variable-compare");
			$attributes = (array) maybe_unserialize( get_post_meta($post->ID, '_product_attributes', true) );

			// See if any are set
			$variation_attribute_found = false;
			if ($attributes) foreach ($attributes as $attribute) {
					if (isset($attribute['is_variation'])) :
						$variation_attribute_found = true;
					break;
					endif;
				}
			if ($variation_attribute_found) {
				$args = array(
					'post_type' => 'product_variation',
					'post_status' => array('private', 'publish'),
					'numberposts' => -1,
					'orderby' => 'id',
					'order' => 'asc',
					'post_parent' => $post->ID
				);
				$variations = get_posts($args);
				$loop = 0;
				ob_start();
?>
			jQuery(function(){
			<?php
				if ($variations && count($variations) > 0) {?>
				jQuery('#variable_product_options .woocommerce_variation').each(function(){
					var current_variation = jQuery(this);
					if(current_variation.hasClass('have_compare_feature') == false){
						var variation_id = jQuery(this).find('.remove_variation').attr('rel');
						var data = {
							action: 'woocp_get_variation_compare',
							variation_id: variation_id,
							security: '<?php echo $woocp_variable_compare; ?>'
						};
						jQuery.post('<?php echo admin_url('admin-ajax.php'); ?>', data, function(response) {
							current_variation.find('table.woocommerce_variable_attributes').append('<tr><td colspan="7">'+response+'</td></tr>');
						});
						current_variation.addClass('have_compare_feature');
					}
				});
			<?php } ?>
				jQuery('#variable_product_options').on('click', 'button.add_variation', function(){
					setTimeout(function(){
						jQuery('#variable_product_options .woocommerce_variation').each(function(){
							var current_variation = jQuery(this);
							if(current_variation.hasClass('have_compare_feature') == false){
								var variation_id = jQuery(this).find('.remove_variation').attr('rel');
								var data = {
									action: 'woocp_get_variation_compare',
									variation_id: variation_id,
									security: '<?php echo $woocp_variable_compare; ?>'
								};
								jQuery.post('<?php echo admin_url('admin-ajax.php'); ?>', data, function(response) {
									current_variation.find('table.woocommerce_variable_attributes').append('<tr><td colspan="7">'+response+'</td></tr>');
								});
								current_variation.addClass('have_compare_feature');
							}
						});
					}, 1000);
				});
				jQuery('#variable_product_options').on('click', 'button.link_all_variations', function(){
					setTimeout(function(){
						jQuery('#variable_product_options .woocommerce_variation').each(function(){
							var current_variation = jQuery(this);
							if(current_variation.hasClass('have_compare_feature') == false){
								var variation_id = jQuery(this).find('.remove_variation').attr('rel');
								var data = {
									action: 'woocp_get_variation_compare',
									variation_id: variation_id,
									security: '<?php echo $woocp_variable_compare; ?>'
								};
								jQuery.post('<?php echo admin_url('admin-ajax.php'); ?>', data, function(response) {
									current_variation.find('table.woocommerce_variable_attributes').append('<tr><td colspan="7">'+response+'</td></tr>');
								});
								current_variation.addClass('have_compare_feature');
							}
						});
					}, 5000);
				});
				jQuery(".variable_compare_category").live("change", function(){
						var cat_id = jQuery(this).val();
						var post_id = jQuery(this).attr("rel");
						jQuery("#variable_compare_widget_loader_"+post_id).show();
						var data = {
							action: 'woocp_variation_get_fields',
							cat_id: cat_id,
							post_id: post_id,
							security: '<?php echo $woocp_variable_compare; ?>'
						};
						jQuery.post('<?php echo admin_url('admin-ajax.php'); ?>', data, function(response) {
							jQuery("#variable_compare_widget_loader_"+post_id).hide();
							jQuery("#variable_compare_cat_fields_"+post_id).html(response);
						});
				});
			});

	<?php
				$javascript = ob_get_clean();
				$woocommerce->add_inline_js( $javascript );
			}
		}
	}

	function save_compare_meta_boxes($post_id) {
		$post_status = get_post_status($post_id);
		$post_type = get_post_type($post_id);
		if ($post_type == 'product' && $post_status != false) {
			if (isset($_REQUEST['_woo_deactivate_compare_feature']) && $_REQUEST['_woo_deactivate_compare_feature'] == 'no') {
				update_post_meta($post_id, '_woo_deactivate_compare_feature', 'no');
			}else {
				update_post_meta($post_id, '_woo_deactivate_compare_feature', 'yes');
			}
			$compare_category = $_REQUEST['_woo_compare_category'];
			update_post_meta($post_id, '_woo_compare_category', $compare_category);

			$category_data = WC_Compare_Categories_Data::get_row($compare_category);
			update_post_meta($post_id, '_woo_compare_category_name', stripslashes($category_data->category_name));

			$compare_fields = WC_Compare_Categories_Fields_Data::get_results("cat_id='".$compare_category."'", 'cf.field_order ASC');
			if (is_array($compare_fields) && count($compare_fields)>0) {
				foreach ($compare_fields as $field_data) {
					update_post_meta($post_id, '_woo_compare_'.$field_data->field_key, $_REQUEST['_woo_compare_'.$field_data->field_key]);
				}
			}

			if (isset($_REQUEST['variable_post_id'])) {
				$variable_ids = $_REQUEST['variable_post_id'];
				foreach ($variable_ids as $variation_id) {
					$post_type = get_post_type($variation_id);
					if ($post_type == 'product_variation') {
						if ($_REQUEST['variable_woo_deactivate_compare_feature'][$variation_id] == 'no') {
							update_post_meta($variation_id, '_woo_deactivate_compare_feature', 'no');
						}else {
							update_post_meta($variation_id, '_woo_deactivate_compare_feature', 'yes');
						}
						$variation_compare_category = $_REQUEST['variable_woo_compare_category'][$variation_id];
						update_post_meta($variation_id, '_woo_compare_category', $variation_compare_category);

						$variation_category_data = WC_Compare_Categories_Data::get_row($variation_compare_category);
						update_post_meta($variation_id, '_woo_compare_category_name', stripslashes($variation_category_data->category_name));

						$compare_fields = WC_Compare_Categories_Fields_Data::get_results("cat_id='".$variation_compare_category."'", 'cf.field_order ASC');
						if (is_array($compare_fields) && count($compare_fields)>0) {
							foreach ($compare_fields as $field_data) {
								update_post_meta($variation_id, '_woo_compare_'.$field_data->field_key, $_REQUEST['variable_woo_compare_'.$field_data->field_key][$variation_id]);
							}
						}
					}
				}
			}
		}
	}
}
?>