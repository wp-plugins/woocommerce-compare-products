<?php
class WOO_Compare_MetaBox{
	function compare_meta_boxes(){
		global $post;
		$pagename = 'product';
		add_meta_box( 'woo_compare_feature_box', __('Compare Feature Fields', 'woo_cp'), array('WOO_Compare_MetaBox', 'woo_compare_feature_box'), $pagename, 'advanced', 'high' );
	}
	
	function woo_compare_feature_box() {
		global $post;
		$post_id = $post->ID;
		$deactivate_compare_feature = get_post_meta( $post_id, '_woo_deactivate_compare_feature', true );
		?>
		<br /><input id='deactivate_compare_feature' type='checkbox' value='yes' <?php if ( $deactivate_compare_feature == 'yes' ) echo 'checked="checked"'; else echo ''; ?> name='_woo_deactivate_compare_feature' style="float:none; width:auto; display:inline-block;" />
		<label style="display:inline-block" for='deactivate_compare_feature' class='small'><?php _e( "Deactivate Compare Feature for this Product", 'woo_cp' ); ?></label>
        <table cellspacing="2" cellpadding="5" style="width: 100%;" class="form-table">
            <tbody>
        <?php
		$compare_fields = WOO_Compare_Data::get_results('','field_order ASC');
		if(is_array($compare_fields) && count($compare_fields)>0){
			
			foreach($compare_fields as $field_data){
		?>
                <tr class="form-field">
                    <th valign="top" scope="row"><label style="display:inline-block" for="<?php echo $field_data->field_key; ?>"><strong><?php echo $field_data->field_name; ?> : </strong> <?php if(trim($field_data->field_unit) != ''){ ?>(<?php echo $field_data->field_unit; ?>)<?php } ?></label><br /><?php echo $field_data->field_description; ?></th>
                    <td>
               	<?php
					$field_value = get_post_meta( $post_id, '_woo_compare_'.$field_data->field_key, true );
					switch($field_data->field_type){
						case "text-area":
							echo '<textarea style="width:400px" name="_woo_compare_'.$field_data->field_key.'" id="'.$field_data->field_key.'">'.$field_value.'</textarea>';
							break;
							
						case "checkbox":
							$default_value = nl2br($field_data->default_value);
							$field_option = explode('<br />', $default_value);
							if(is_serialized($field_value)) $field_value = maybe_unserialize($field_value);
							if(!is_array($field_value)) $field_value = array();
							if(is_array($field_option) && count($field_option) > 0){
								foreach($field_option as $option_value){
									if(in_array($option_value, $field_value)){
										echo '<input type="checkbox" name="_woo_compare_'.$field_data->field_key.'[]" value="'.$option_value.'" checked="checked" style="float:none; width:auto; display:inline-block;" /> '.$option_value.' &nbsp;&nbsp;&nbsp;';
									}else{
										echo '<input type="checkbox" name="_woo_compare_'.$field_data->field_key.'[]" value="'.$option_value.'" style="float:none; width:auto; display:inline-block;" /> '.$option_value.' &nbsp;&nbsp;&nbsp;';
									}
								}
							}
							break;
							
						case "radio":
							$default_value = nl2br($field_data->default_value);
							$field_option = explode('<br />', $default_value);
							if(is_array($field_option) && count($field_option) > 0){
								foreach($field_option as $option_value){
									if($option_value == $field_value){
										echo '<input type="radio" name="_woo_compare_'.$field_data->field_key.'" value="'.$option_value.'" checked="checked" style="float:none; width:auto; display:inline-block;" /> '.$option_value.' &nbsp;&nbsp;&nbsp;';
									}else{
										echo '<input type="radio" name="_woo_compare_'.$field_data->field_key.'" value="'.$option_value.'" style="float:none; width:auto; display:inline-block;" /> '.$option_value.' &nbsp;&nbsp;&nbsp;';
									}
								}
							}
							break;
						
						case "drop-down":
							$default_value = nl2br($field_data->default_value);
							$field_option = explode('<br />', $default_value);
							echo '<select name="_woo_compare_'.$field_data->field_key.'" id="'.$field_data->field_key.'" style="width:400px">';
								echo '<option value="">'.__( "Select value", 'woo_cp' ).'</option>';
							if(is_array($field_option) && count($field_option) > 0){
								foreach($field_option as $option_value){
									if($option_value == $field_value){
										echo '<option value="'.$option_value.'" selected="selected">'.$option_value.'</option>';
									}else{
										echo '<option value="'.$option_value.'">'.$option_value.'</option>';
									}
								}
							}
							echo '</select>';
							break;
						
						case "multi-select":
							$default_value = nl2br($field_data->default_value);
							$field_option = explode('<br />', $default_value);
							if(is_serialized($field_value)) $field_value = maybe_unserialize($field_value);
							if(!is_array($field_value)) $field_value = array();
							echo '<select multiple="multiple" name="_woo_compare_'.$field_data->field_key.'[]" id="'.$field_data->field_key.'" style="width:400px">';
							if(is_array($field_option) && count($field_option) > 0){
								foreach($field_option as $option_value){
									if(in_array($option_value, $field_value)){
										echo '<option value="'.$option_value.'" selected="selected">'.$option_value.'</option>';
									}else{
										echo '<option value="'.$option_value.'">'.$option_value.'</option>';
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
		}
		?>
        	</tbody>
        </table>
<?php
	}
	
	function woo_variations_compare_feature_box($post_id) {
		$deactivate_compare_feature = get_post_meta( $post_id, '_woo_deactivate_compare_feature', true );
		?>
		<br /><input id='deactivate_compare_feature_<?php echo $post_id; ?>' type='checkbox' value='yes' <?php if ( $deactivate_compare_feature == 'yes' ) echo 'checked="checked"'; else echo ''; ?> name='variable_woo_deactivate_compare_feature[<?php echo $post_id; ?>]' style="float:none; width:auto; display:inline-block;" />
		<label style="display:inline-block" for='deactivate_compare_feature_<?php echo $post_id; ?>' class='small'><?php _e( "Deactivate Compare Feature for this Product", 'woo_cp' ); ?></label>
        <table cellspacing="2" cellpadding="5" style="width: 100%;" class="form-table">
            <tbody>
        <?php
		$compare_fields = WOO_Compare_Data::get_results('','field_order ASC');
		if(is_array($compare_fields) && count($compare_fields)>0){
			
			foreach($compare_fields as $field_data){
		?>
                <tr class="form-field">
                    <th valign="top" scope="row"><label style="display:inline-block" for="<?php echo $field_data->field_key; ?>_<?php echo $post_id; ?>"><strong><?php echo $field_data->field_name; ?> : </strong> <?php if(trim($field_data->field_unit) != ''){ ?>(<?php echo $field_data->field_unit; ?>)<?php } ?></label><br /><?php echo $field_data->field_description; ?></th>
                    <td>
               	<?php
					$field_value = get_post_meta( $post_id, '_woo_compare_'.$field_data->field_key, true );
					switch($field_data->field_type){
						case "text-area":
							echo '<textarea style="width:400px" name="variable_woo_compare_'.$field_data->field_key.'['.$post_id.']" id="'.$field_data->field_key.'_'.$post_id.'">'.$field_value.'</textarea>';
							break;
							
						case "checkbox":
							$default_value = nl2br($field_data->default_value);
							$field_option = explode('<br />', $default_value);
							if(is_serialized($field_value)) $field_value = maybe_unserialize($field_value);
							if(!is_array($field_value)) $field_value = array();
							if(is_array($field_option) && count($field_option) > 0){
								foreach($field_option as $option_value){
									if(in_array($option_value, $field_value)){
										echo '<input type="checkbox" name="variable_woo_compare_'.$field_data->field_key.'['.$post_id.'][]" value="'.$option_value.'" checked="checked" style="float:none; width:auto; display:inline-block;" /> '.$option_value.' &nbsp;&nbsp;&nbsp;';
									}else{
										echo '<input type="checkbox" name="variable_woo_compare_'.$field_data->field_key.'['.$post_id.'][]" value="'.$option_value.'" style="float:none; width:auto; display:inline-block;" /> '.$option_value.' &nbsp;&nbsp;&nbsp;';
									}
								}
							}
							break;
							
						case "radio":
							$default_value = nl2br($field_data->default_value);
							$field_option = explode('<br />', $default_value);
							if(is_array($field_option) && count($field_option) > 0){
								foreach($field_option as $option_value){
									if($option_value == $field_value){
										echo '<input type="radio" name="variable_woo_compare_'.$field_data->field_key.'['.$post_id.']" value="'.$option_value.'" checked="checked" style="float:none; width:auto; display:inline-block;" /> '.$option_value.' &nbsp;&nbsp;&nbsp;';
									}else{
										echo '<input type="radio" name="variable_woo_compare_'.$field_data->field_key.'['.$post_id.']" value="'.$option_value.'" style="float:none; width:auto; display:inline-block;" /> '.$option_value.' &nbsp;&nbsp;&nbsp;';
									}
								}
							}
							break;
						
						case "drop-down":
							$default_value = nl2br($field_data->default_value);
							$field_option = explode('<br />', $default_value);
							echo '<select name="variable_woo_compare_'.$field_data->field_key.'['.$post_id.']" id="'.$field_data->field_key.'_'.$post_id.'" style="width:400px">';
								echo '<option value="">'.__( "Select value", 'woo_cp' ).'</option>';
							if(is_array($field_option) && count($field_option) > 0){
								foreach($field_option as $option_value){
									if($option_value == $field_value){
										echo '<option value="'.$option_value.'" selected="selected">'.$option_value.'</option>';
									}else{
										echo '<option value="'.$option_value.'">'.$option_value.'</option>';
									}
								}
							}
							echo '</select>';
							break;
						
						case "multi-select":
							$default_value = nl2br($field_data->default_value);
							$field_option = explode('<br />', $default_value);
							if(is_serialized($field_value)) $field_value = maybe_unserialize($field_value);
							if(!is_array($field_value)) $field_value = array();
							echo '<select multiple="multiple" name="variable_woo_compare_'.$field_data->field_key.'['.$post_id.'][]" id="'.$field_data->field_key.'_'.$post_id.'" style="width:400px">';
							if(is_array($field_option) && count($field_option) > 0){
								foreach($field_option as $option_value){
									if(in_array($option_value, $field_value)){
										echo '<option value="'.$option_value.'" selected="selected">'.$option_value.'</option>';
									}else{
										echo '<option value="'.$option_value.'">'.$option_value.'</option>';
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
		}
		?>
        	</tbody>
        </table>
<?php
	}
	
	function variable_compare_meta_boxes(){
		global $post, $woocommerce;
	
		$attributes = (array) maybe_unserialize( get_post_meta($post->ID, '_product_attributes', true) );
		
		// See if any are set
		$variation_attribute_found = false;
		if ($attributes) foreach($attributes as $attribute){
			if (isset($attribute['is_variation'])) :
				$variation_attribute_found = true;
				break;
			endif;
		}
		if ($variation_attribute_found){
			$args = array(
					'post_type'	=> 'product_variation',
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
			if ($variations && count($variations) > 0){?>
			jQuery('#variable_product_options .woocommerce_variation').each(function(){
            	var current_variation = jQuery(this); 
                if(current_variation.hasClass('have_compare_feature') == false){
                    var variation_id = jQuery(this).find('.remove_variation').attr('rel');
                    var data = {
                        action: 'get_variation_compare',
                        variation_id: variation_id                
                    };
                    jQuery.post('<?php echo WOOCP_URL.'/compare_process_ajax.php'; ?>', data, function(response) {
                        current_variation.find('table.woocommerce_variable_attributes').append('<tr><td colspan="7">'+response+'</td></tr>');
                    });
                    current_variation.addClass('have_compare_feature');
                }
           	});
        <?php } ?>
        	jQuery('#variable_product_options').on('click', 'button.link_all_variations, button.add_variation', function(){
            	setTimeout(function(){
                    jQuery('#variable_product_options .woocommerce_variation').each(function(){
                        var current_variation = jQuery(this); 
                        if(current_variation.hasClass('have_compare_feature') == false){
                            var variation_id = jQuery(this).find('.remove_variation').attr('rel');
                            var data = {
                                action: 'get_variation_compare',
                                variation_id: variation_id                
                            };
                            jQuery.post('<?php echo WOOCP_URL.'/compare_process_ajax.php'; ?>', data, function(response) {
                                current_variation.find('table.woocommerce_variable_attributes').append('<tr><td colspan="7">'+response+'</td></tr>');
                            });
                            current_variation.addClass('have_compare_feature');
                        }
                    });
            	}, 1000);
            });
        });
		
<?php
		$javascript = ob_get_clean();
		$woocommerce->add_inline_js( $javascript );
		}
	}
	
	function save_compare_meta_boxes($post_id){
		$post_status = get_post_status($post_id);
		$post_type = get_post_type($post_id);
		if($post_type == 'product' && $post_status != false){
			if(isset($_REQUEST['_woo_deactivate_compare_feature']) && $_REQUEST['_woo_deactivate_compare_feature'] == 'yes'){
				update_post_meta($post_id, '_woo_deactivate_compare_feature', 'yes');
			}else{
				update_post_meta($post_id, '_woo_deactivate_compare_feature', 'no');
			}
			$compare_fields = WOO_Compare_Data::get_results('','field_order ASC');
			if(is_array($compare_fields) && count($compare_fields)>0){
				foreach($compare_fields as $field_data){
					update_post_meta($post_id, '_woo_compare_'.$field_data->field_key, $_REQUEST['_woo_compare_'.$field_data->field_key]);
				}
			}
			
			/*if(isset($_REQUEST['variable_post_id'])){
				$variable_ids = $_REQUEST['variable_post_id'];
				foreach($variable_ids as $variation_id){
					$post_type = get_post_type($variation_id);
					if($post_type == 'product_variation'){
						if($_REQUEST['variable_woo_deactivate_compare_feature'][$variation_id] == 'yes'){
							update_post_meta($variation_id, '_woo_deactivate_compare_feature', 'yes');
						}else{
							update_post_meta($variation_id, '_woo_deactivate_compare_feature', 'no');
						}
						if(is_array($compare_fields) && count($compare_fields)>0){
							foreach($compare_fields as $field_data){
								update_post_meta($variation_id, '_woo_compare_'.$field_data->field_key, $_REQUEST['variable_woo_compare_'.$field_data->field_key][$variation_id]);
							}
						}
					}
				}
			}*/
		}
	}
}
?>