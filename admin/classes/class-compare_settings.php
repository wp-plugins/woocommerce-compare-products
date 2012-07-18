<?php
/**
 * WooCommerce Compare Settings page
 *
 * Table Of Contents
 *
 * woocp_set_setting_default()
 * woo_get_features_tab()
 * woo_get_settings_tab()
 * woo_right_sidebar()
 * woo_compare_manager()
 * woocp_update_orders()
 */
class WOO_Compare_Class{	
	public static $default_types = array(
									'input-text' => 'Input Text',
									'text-area' => 'Text Area', 
									'checkbox' => 'CheckBox', 
									'radio' => 'Radio button', 
									'drop-down' => 'Drop Down', 
									'multi-select' => 'Multi Select');
	
	function woocp_set_setting_default($reset=false){
		$comparable_settings = get_option('woo_comparable_settings');
		if(!is_array($comparable_settings) || count($comparable_settings) < 1){
			$comparable_settings = array();	
		}
		
		if(!isset($comparable_settings['compare_logo']) || trim($comparable_settings['compare_logo']) == ''){
			$comparable_settings['compare_logo'] = '';
		}
		if(!isset($comparable_settings['popup_width']) || trim($comparable_settings['popup_width']) == '' || $reset){
			$comparable_settings['popup_width'] = 1000;
		}
		if(!isset($comparable_settings['popup_height']) || trim($comparable_settings['popup_height']) == '' || $reset){
			$comparable_settings['popup_height'] = 650;
		}
		if(!isset($comparable_settings['compare_container_height']) || trim($comparable_settings['compare_container_height']) == '' || $reset){
			$comparable_settings['compare_container_height'] = 500;
		}
		if(!isset($comparable_settings['auto_add']) || trim($comparable_settings['auto_add']) == '' || $reset){
			$comparable_settings['auto_add'] = 'yes';
		}
		if(!isset($comparable_settings['button_text']) || trim($comparable_settings['button_text']) == '' || $reset){
			$comparable_settings['button_text'] = 'Compare This*';
		}
		if(!isset($comparable_settings['compare_featured_tab']) || trim($comparable_settings['compare_featured_tab']) == '' || $reset){
			$comparable_settings['compare_featured_tab'] = 'Technical Details';
		}
		if(!isset($comparable_settings['auto_compare_featured_tab']) || trim($comparable_settings['auto_compare_featured_tab']) == '' || $reset){
			$comparable_settings['auto_compare_featured_tab'] = '29';
		}
		if(!isset($comparable_settings['button_type']) || trim($comparable_settings['button_type']) == '' || $reset){
			$comparable_settings['button_type'] = 'button';
		}
		if(!isset($comparable_settings['popup_type']) || trim($comparable_settings['popup_type']) == '' || $reset){
			$comparable_settings['popup_type'] = 'fancybox';
		}
		if(!isset($comparable_settings['button_position']) || trim($comparable_settings['button_position']) == '' || $reset){
			$comparable_settings['button_position'] = 'above';
		}
		if(!isset($comparable_settings['above_padding']) || trim($comparable_settings['above_padding']) == '' || $reset){
			$comparable_settings['above_padding'] = '10';
		}
		if(!isset($comparable_settings['below_padding']) || trim($comparable_settings['below_padding']) == '' || $reset){
			$comparable_settings['below_padding'] = '10';
		}
		update_option('woo_comparable_settings', $comparable_settings);
	}
	
	function woo_get_features_tab($result_msg=''){
	?>
    	<?php echo $result_msg; ?>
    	<h3><?php _e('WooCommerce Compare Products Lite','woo_cp'); ?></h3>
        <p><?php _e('Compare Products Lite has only 1 Master Compare Product Category and all you have to do is add the Compare Features. Once you have created some Compare Products features you then can start adding data for those features to your products.','woo_cp'); ?></p>
        <ul>
            <li>
				<strong><?php _e('How to add/edit/deactivate Compare Features for each Product','woo_cp'); ?>.</strong> <span class="woocp_read_more"><?php _e("Read More",'woo_cp'); ?></span><br />
				<div class="woocp_description_text" style="display:none">
					<p><?php _e('Once you add a Compare Feature that feature is automatically added to the Compare Features section on every products edit page on your site. If you enter nothing in the Feature Field on product pages it will auto show N/A for that field when a user looks at the product in the compare Fly -out window. To add data for feature','woo_cp'); ?>:</p>
        			<ul><li><?php _e('1. Go to the Products page and click edit','woo_cp'); ?>.</li>
        			<li><?php _e('2. Scroll to the bottom of the edit screen and you will see the Compare Feature Fields section','woo_cp'); ?>.</li>
                    <li><?php _e('3. Enter data for each feature that is applicable to this product','woo_cp'); ?>.</li>
                    <li><?php _e('4. Update your product post and the feature fields are activated. Empty fields show N/A as default','woo_cp'); ?>.</li>
                    <li><?php _e('5. To edit Features/ Fields, open the the product edit page and update your Compare Fields data and update the post to save the changes','woo_cp'); ?>.</li>
                    <li><?php _e('6. Deactivate the feature. To deactivate the feature check the "Deactivate Compare Feature for this Product" section and update your post. This removes the Compare this button from the Product Page. Any data you have entered for the product is saved and if you choose to reactivate the feature on this product the data shows','woo_cp'); ?>.</li>
                    </ul>
                    <p>&nbsp;</p>
				</div>
			</li>
		</ul>
        <div style="clear:both;"></div>
        <form action="admin.php?page=woo-compare-settings&tab=features" method="post" name="form_add_compare" id="form_add_compare">
        <?php
			if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'edit'){
				$field_id = $_REQUEST['field_id'];
				$field = WOO_Compare_Data::get_row($field_id);
			}
			$have_value = false;
		?>
        <?php
			if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'edit'){
		?>
        	<input type="hidden" value="<?php echo $field_id; ?>" name="field_id" id="field_id" />
        <?php		
			}
		?>
        	<table cellspacing="0" class="widefat post fixed form-table">
            	<thead>
                	<tr><th class="manage-column" scope="col"><?php if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'edit'){ _e('Edit Compare Feature','woo_cp'); }else{ _e('Create New Compare Feature','woo_cp'); } ?></th></tr>
                </thead>
                <tbody>
                	<tr>
                    	<td>
                        	<div style="width:200px; float:left"><label for="field_name"><?php _e('Feature Name','woo_cp'); ?></label></div> <input type="text" name="field_name" id="field_name" value="<?php if(!empty($field)) echo stripslashes($field->field_name); ?>" style="min-width:300px" /> <img class="help_tip" tip='<?php _e('This is the Feature Name that users see in the Compare Fly-Out Window, for example - System Height', 'woo_cp') ?>' src="<?php echo WOOCP_IMAGES_URL; ?>/help.png" />
                            <div style="clear:both; height:20px;"></div>
                            <div style="width:200px; float:left"><label for="field_key"><?php _e('Feature Key','woo_cp'); ?></label></div> <input type="text" name="field_key" id="field_key" value="<?php if(!empty($field)) echo stripslashes($field->field_key); ?>" style="min-width:300px" /> <img class="help_tip" tip="<?php _e("Users don't see this - its the features unique name on your database.", 'woo_cp') ?>" src="<?php echo WOOCP_IMAGES_URL; ?>/help.png" />
							<div style="margin-left:200px;"><?php _e('Please do not enter spaces in the Feature key.','woo_cp'); ?></div>
                            <div style="clear:both; height:20px;"></div>
                            <div style="width:200px; float:left"><label for="field_type"><?php _e('Feature Input Type','woo_cp'); ?></label></div> 
                            <select style="min-width:300px;" name="field_type" id="field_type" class="chosen_select">
                            <?php
								foreach(WOO_Compare_Class::$default_types as $type => $type_name){
									if(!empty($field) && $type == $field->field_type){
										echo '<option value="'.$type.'" selected="selected">'.$type_name.'</option>';	
									}else{
										echo '<option value="'.$type.'">'.$type_name.'</option>';
									}
								}
								if(!empty($field) && in_array($field->field_type, array('checkbox' , 'radio', 'drop-down', 'multi-select'))){
									$have_value = true;	
								}
							?>
                            </select> <img class="help_tip" tip="<?php _e("Users don't see this. You use this to set the data input field type that you will use on the product page to enter the Products data for this feature.", 'woo_cp') ?>" src="<?php echo WOOCP_IMAGES_URL; ?>/help.png" />
                            	<div style="margin-left:200px;">
                                	<ul>
                                        <li>
                                            <strong><?php _e("Feature Input Types Explained",'woo_cp'); ?></strong> <span class="woocp_read_more"><?php _e("Read More",'woo_cp'); ?></span><br />
                                            <div class="woocp_description_text" style="display:none">
                                                <p>
													<?php _e("Input Text - Use when option is a single Line of Text",'woo_cp'); ?><br />
                                                    <?php _e("Text Area - Use when option is Multiple lines of Text",'woo_cp'); ?><br />
                                                    <?php _e("Check Box - Use when option is short like sizes eg XL - Select Multiple options",'woo_cp'); ?><br />
                                                    <?php _e("Radio Button - Use when option is short like size eg SM - Only select one option",'woo_cp'); ?><br />
                                                    <?php _e("Drop Down - Use when option is large eg Description - Only select one option",'woo_cp'); ?><br />
                                                    <?php _e("Multi Select - Like Drop Down but allows you to Mutiple select Options",'woo_cp'); ?>
                                                </p>
                                                <p>&nbsp;</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            <div style="clear:both; height:20px;"></div>
                            <div id="field_value" <?php if(!$have_value){ echo 'style="display:none"';} ?>>
                                <div style="width:200px; float:left"><label for="default_value"><?php _e('Enter Input Type Options','woo_cp'); ?></label></div> <textarea style="min-width:300px;height:100px" name="default_value" id="default_value"><?php if(!empty($field)) echo stripslashes($field->default_value); ?></textarea> <img class="help_tip" tip="<?php _e("You have selected one of the Check Box, Radio Button, Drop Down, Mutli Select Input Types. Type your Options here, one line for each option.", 'woo_cp') ?>" src="<?php echo WOOCP_IMAGES_URL; ?>/help.png" />
                                <div style="clear:both; height:20px;"></div>
                            </div>
                        	<div style="width:200px; float:left"><label for="field_unit"><?php _e('Feature Unit of Measurement','woo_cp'); ?></label></div> <input type="text" name="field_unit" id="field_unit" value="<?php if(!empty($field)) echo stripslashes($field->field_unit); ?>" style="min-width:300px" /> <img class="help_tip" tip='<?php _e("e.g kgs, mm, lbs, cm, inches - the unit of measurement shows after the Feature name in (brackets) on the Compare Feature List on the front end. If you leave this blank you will just see the Feature name.", 'woo_cp') ?>' src="<?php echo WOOCP_IMAGES_URL; ?>/help.png" />
                            <div style="clear:both; height:20px;"></div>
                            <div style="width:200px; float:left"><label for="field_description"><?php _e('Feature Description','woo_cp'); ?></label></div> <input type="text" style="min-width:300px;" name="field_description" id="field_description" value="<?php if(!empty($field)) echo stripslashes($field->field_description); ?>"  /> <img class="help_tip" tip='<?php _e("The front end user does not see this. It is a short note that shows on the Feature data entry field on the Products edit page to remind your what the feature is about.", 'woo_cp') ?>' src="<?php echo WOOCP_IMAGES_URL; ?>/help.png" />
                            <div style="clear:both; height:20px;"></div>
                            <p class="submit" style="padding-bottom:0px;">
                                <input type="submit" name="bt_save_field" id="bt_save_field" class="button-primary" value="<?php if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'edit'){ _e('Save','woo_cp'); }else{ _e('Create','woo_cp'); } ?>"  /> <?php if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'edit'){ ?><a href="admin.php?page=woo-compare-settings&tab=features"><input type="button" name="cancel" value="<?php _e('Cancel','woo_cp'); ?>" class="button-primary" /></a><?php } ?>
                            </p>
                    	</td>
                    </tr>
                </tbody>
            </table>
        </form>
        <div style="clear:both; margin-bottom:20px;"></div>
        <?php //if(!isset($_REQUEST['act']) || $_REQUEST['act'] != 'edit'){ ?>
		<h3><?php _e('Compare Products Lite Master Category Features List','woo_cp'); ?></h3>
        <ul>
        	<li>
            	<strong><?php _e("How to manage Master Category feature list",'woo_cp'); ?></strong> <span class="woocp_read_more"><?php _e("Read More",'woo_cp'); ?></span><br />
                <div class="woocp_description_text" style="display:none">
                	<p><?php _e("As soon as you create a Feature above you will see it appear at the bottom of the master category Feature list below. The features below are in the order that they will show for the Products in the Fly-Out window. You can change the order by dragging and dropping any feature up or down the list. You can edit any feature by clicking on the paper and pencil icon. You can delete any feature by clicking the RED X.",'woo_cp'); ?></p>
                </div>
            </li>
        </ul>
        <form action="admin.php?page=woo-compare-settings&tab=features" method="post" name="form_compare_order" id="form_compare_order">      
          <div class="update_order_message">&nbsp;</div>
  		  <table cellspacing="0" class="widefat post fixed">
            <thead>
            <tr>
              <th class="manage-column" scope="col"><span class="compare_sort"><?php _e('Order','woo_cp'); ?></span> <span class="c_field_name"><?php _e('Feature Name','woo_cp'); ?></span> <span class="c_field_action"><?php _e('Action','woo_cp'); ?></span> <span class="c_field_type"><?php _e('Feature Input Type','woo_cp'); ?></span></th>
            </tr>
            </thead>
            <tfoot>
            <tr>
              <th class="manage-column" scope="col"><span class="compare_sort"><?php _e('Order','woo_cp'); ?></span> <span class="c_field_name"><?php _e('Feature Name','woo_cp'); ?></span> <span class="c_field_action"><?php _e('Action','woo_cp'); ?></span> <span class="c_field_type"><?php _e('Feature Input Type','woo_cp'); ?></span></th>
            </tr>
            </tfoot>          
            <tbody>
            	<tr>
				  <td class="tags column-tags">
               	<?php 
				  	$compare_fields = WOO_Compare_Data::get_results('','field_order ASC');
					if(is_array($compare_fields) && count($compare_fields)>0){
				?>
                <?php wp_enqueue_script('jquery-ui-sortable'); ?>
                <?php $woocp_update_order = wp_create_nonce("woocp-update-order"); ?>
                <script type="text/javascript">
					(function($){
						$(function(){
							$("#compare_orders").sortable({ placeholder: "ui-state-highlight", opacity: 0.6, cursor: 'move', update: function() {
								var order = $(this).sortable("serialize") + '&action=woocp_update_orders&security=<?php echo $woocp_update_order; ?>';
								$.post("<?php echo admin_url('admin-ajax.php'); ?>", order, function(theResponse){
									$(".update_order_message").html(theResponse);
									$("#compare_orders").find(".compare_sort").each(function(index){
										$(this).html(index+1);
										$(this).parent("li").removeClass();
										if(index == 0){
											$(this).parent("li").addClass("first_record");	
										}
									});
								});
							}
							});
						});
					})(jQuery);
				</script>
                	<ul class="compare_orders feature_compare_orders" id="compare_orders">
                    <?php
						$i= 0;
						$first_li = 'first_record';
						foreach($compare_fields as $field_data){
							$i++;
							if($i>1) $first_li= '';
					?>
							<li id="recordsArray_<?php echo $field_data->id; ?>" class="<?php echo $first_li; ?>"><span class="compare_sort"><?php echo $i; ?>.</span><span class="c_field_name"><?php echo $field_data->field_name; ?></span><span class="c_field_action"><a href="admin.php?page=woo-compare-settings&tab=features&act=edit&field_id=<?php echo $field_data->id; ?>" class="c_field_edit">&nbsp;</a> | <a href="admin.php?page=woo-compare-settings&tab=features&act=delete&field_id=<?php echo $field_data->id; ?>&cat_id=<?php echo $cat->id; ?>" class="c_field_delete" onclick="javascript:return confirmation('Are you sure you want to delete #<?php echo htmlspecialchars($field_data->field_name); ?>');">&nbsp;</a></span> <span class="c_field_type"><?php echo WOO_Compare_Class::$default_types[$field_data->field_type]; ?></span></li>
					<?php
						}
					?>
                    </ul>	
                <?php
					}else{
						_e('Do not have any Features','woo_cp');
					}
				?>
                  </td>
				</tr>
            </tbody>          
          </table>
       	</form>
    <?php
	}
	
	function woo_get_settings_tab($comparable_setting_msg=''){
	?>
    	<h3><?php _e('WooCommerce Compare Products Lite Settings','woo_cp'); ?></h3>
        <?php $comparable_settings = get_option('woo_comparable_settings'); ?>
        <?php echo $comparable_setting_msg; ?>
        <p><?php _e('Thanks for installing WooCommerce Compare Products Lite Version. Set up and manage all the of the Plugins functions from this admin page. Click the Read More links to read detailed instructions and use the tool tips for more help.','woo_cp'); ?></p>
        <ul>
			<li>
				<strong><?php _e('How to use this page to set up and manage the Compare Products Plugin','woo_cp'); ?></strong> <span class="woocp_read_more"><?php _e("Read More",'woo_cp'); ?></span><br />
				<div class="woocp_description_text" style="display:none">
					<p><?php _e('Now you have Compare Products Lite activated it has auto added a Compare Button to all of your Products and the Compare sidebar widget. If you go to the front of your site and add any product to your Compare Products sidebar list and open the Compare Fly-Out by clicking the Compare Button you will see the product, but no Compare features. The PRO version does not auto add the Compare Button to Products and allows you to roll out the feature to each product as you add them, that is one of the reasons that PRO is more suitable for larger sites.','woo_cp'); ?></p>
        			<p><?php _e('Setting up the Compare Products Lite feature on your site is a simple 3 step process.','woo_cp'); ?></p>
        			<p><?php _e('STEP 1. Style your Compare Features. The Compare Lite plugin has auto added the Compare feature to all of your product pages. Follow the instructions below to style how the feature shows on your sites frontend.','woo_cp'); ?></p>
                    <p><?php _e('STEP 2. Create Compare Product Features. After you have done your set up - go to the FEATURES tab at the top to add your Compare Product features.','woo_cp'); ?></p>
                    <p><?php _e('STEP 3. Once you have Created some Compare Products features you then can start adding data for those features to your products OR if you do not want the Compare feature to show on that product you should deactivate the feature on that products page.','woo_cp'); ?></p>
                    <p>&nbsp;</p>
				</div>
			</li>
		</ul>
        <div style="clear:both;"></div>
        <form action="admin.php?page=woo-compare-settings" method="post" name="form_comparable_settings" id="form_comparable_settings">      
        <h3><?php _e('Compare Fly-Out Window Setup', 'woo_cp'); ?></h3>
        <table class="form-table">
			<tbody>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="compare_logo"><?php _e('Add Fly-Out Header Image','woo_cp'); ?></label></th>
                    <td class="forminp"><input type="text" name="compare_logo" id="compare_logo" value="<?php if(isset($comparable_settings['compare_logo'])) echo $comparable_settings['compare_logo'] ?>" style="min-width:300px" />
                    	<p class="description"><?php _e('To add a header image to your Compare Fly-Out screen put the full URL of the image you want to use in the text area above. Use file formats .jpg .png. jpeg Your image can be any size. If it is not as wide as the Fly-Out Container width you set below it will sit in the centre at the top of the Fly-Out screen. If it is wider the bottom scroll bar will come into play.','woo_cp'); ?></p>
                    </td>
               	</tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="popup_width"><?php _e('Comapre Fly-Out Width','woo_cp'); ?></label></th>
                    <td class="forminp"><input type="text" name="popup_width" id="popup_width" value="<?php echo $comparable_settings['popup_width'] ?>" size="3" /> px</td>
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="popup_height"><?php _e('Compare Fly-Out Height','woo_cp'); ?></label></th>
                    <td class="forminp"><input type="text" name="popup_height" id="popup_height" value="<?php echo $comparable_settings['popup_height'] ?>"  size="3" /> px</td>
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="compare_container_height"><?php _e('Fly-Out Inner Container Height','woo_cp'); ?></label></th>
                    <td class="forminp"><input type="text" name="compare_container_height" id="compare_container_height" value="<?php echo $comparable_settings['compare_container_height'] ?>" size="3" /> px 
                    <p class="description"><?php _e('Setting this at slightly less than the Fly-Out height will ensure that your Header Image and the Print button will always be visible as users scroll down the products list of features in the Fly-Out screen.','woo_cp'); ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="button_type"><?php _e('Compare Popup Type','woo_cp'); ?></label></th>
                    <td class="forminp"><input type="radio" name="popup_type" id="popup_type1" value="fancybox" <?php if($comparable_settings['popup_type'] == 'fancybox'){ echo 'checked="checked"';} ?> /> <label for="popup_type1"><?php _e('Fancybox','woo_cp'); ?></label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="popup_type" id="popup_type2" value="lightbox" <?php if($comparable_settings['popup_type'] == 'lightbox'){ echo 'checked="checked"';} ?> /> <label for="popup_type2"><?php _e('Lightbox','woo_cp'); ?></label>
                    <p class="description"><?php _e('Fancybox is the default tool used for the Fly-Out window when you install the Compare Products extension as it is the the tool used in the WooCommerce Plugin and Themes. Fancybox is an alternative to the widely used and popular Lightbox tool so we have included both options so you can decide which one you want to use. To test it select Lightbox, Save at the bottom of this page, add some products to the compare sidebar widget and click the compare button.','woo_cp'); ?></p>
                    </td>
                 </tr>
			</tbody>
		</table>
        <h3><?php _e('Compare Product Page Buttons', 'woo_cp'); ?></h3>
        <table class="form-table">
			<tbody>
            	<tr valign="top">
					<th class="titledesc" scope="rpw"><label for="button_position1"><?php _e('Button Position relative to Add to Cart Button','woo_cp'); ?></label></th>
                    <td class="forminp"><div style="width:160px; float:left;"><input type="radio" name="button_position" id="button_position1" value="above" <?php if(!isset($comparable_settings['button_position']) || $comparable_settings['button_position'] == 'above'){ echo 'checked="checked"';} ?> /> <label for="button_position1"><?php _e('Above','woo_cp'); ?></label></div> <div style="float:left; width:100px;"><label for="above_padding"><?php _e('Padding Bottom','woo_cp'); ?></label></div> <input type="text" name="above_padding" id="above_padding" value="<?php echo $comparable_settings['above_padding'] ?>" size="3" /> px
                    	<div style="clear:both;"></div>
                    	<div style="width:160px; float:left;"><input type="radio" name="button_position" id="button_position2" value="below" <?php if(isset($comparable_settings['button_position']) && $comparable_settings['button_position'] == 'below'){ echo 'checked="checked"';} ?> /> <label for="button_position2"><?php _e('Below','woo_cp'); ?></label></div> <div style="float:left; width:100px;"><label for="above_padding"><?php _e('Padding Top','woo_cp'); ?></label></div> <input type="text" name="below_padding" id="below_padding" value="<?php echo $comparable_settings['below_padding'] ?>" size="3" /> px
                        <div style="clear:both;"></div>
                    	<p class="description"><?php _e("Change position if Compare Button does not show on the frontend.", 'woo_cp'); ?></p>
                    </td>
                </tr>
				<tr valign="top">
					<th class="titledesc" scope="rpw"><label for="auto_add1"><?php _e('Default Button setting','woo_cp'); ?></label></th>
                    <td class="forminp"><input type="radio" name="auto_add" id="auto_add1" value="yes" <?php if($comparable_settings['auto_add'] == 'yes'){ echo 'checked="checked"';} ?> /> <label for="auto_add1"><?php _e('Yes','woo_cp'); ?></label>
                    	<p class="description"><?php _e("This feature must be set at YES in the FREE version for Compare Products to work. You can manually deactivate the Compare Button and features from any individual products page edit screen. If you'd prefer to be just able to just activate the Plugin and then add the Compare Products Button and Features to individual Products rather than ALL Products (and then have to deactivate on individual product pages) you can do that by upgrading to the PRO version. IMORTANT! If your theme does not auto show the Campare button on each product page you will need to activate the next option and take the necessary steps.", 'woo_cp'); ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="auto_add2"><?php _e('Manually set Show Compare button and/or Button Position','woo_cp'); ?></label></th>
                    <td class="forminp"><input type="radio" name="auto_add" id="auto_add2" value="no" <?php if($comparable_settings['auto_add'] == 'no'){ echo 'checked="checked"';} ?> /> <label for="auto_add2"><?php _e('Yes','woo_cp'); ?></label>
                    	<p class="description"><?php _e('IMPORTANT! - Selecting this option will mean that the Compare Button will not show on your Product Pages. YOU MUST know how to write code to do this. Select it if you want to manually set/change the default position of the Button on the product page or if by the remote chance your theme does not support auto show the compare button on product pages - Set this option to YES. Then use this function','woo_cp'); ?> <code>&lt;?php if(function_exists('woo_add_compare_button')) echo woo_add_compare_button(); ?&gt;</code> <?php _e('to put into your theme code to allow your theme to show the button. Set it in your theme where you want the Compare button to show on the product pages.','woo_cp'); ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="button_type"><?php _e('Button or Text','woo_cp'); ?></label></th>
                    <td class="forminp"><input type="radio" name="button_type" id="button_type1" value="button" <?php if($comparable_settings['button_type'] == 'button'){ echo 'checked="checked"';} ?> /> <label for="button_type1"><?php _e('Button','woo_cp'); ?></label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="button_type" id="button_type2" value="link" <?php if($comparable_settings['button_type'] == 'link'){ echo 'checked="checked"';} ?> /> <label for="button_type2"><?php _e('Link','woo_cp'); ?></label> <img class="help_tip" tip='<?php _e('Show Compare feature on products as a Button or Hyperlink Text.', 'woo_cp') ?>' src="<?php echo WOOCP_IMAGES_URL; ?>/help.png" />
  						<p class="description"><?php _e("If you select LINK - the hyperlinked text auto shows in the same font and colour as set by your themes style sheets. Unfortunately is not possible to auto know the Style and Colour of your themes BUTTONS as many themes have many different buttons. If you have a little coding knowledge you can easily manually change the style and Colour of the Compare button used as default by us. All objects in the plugin have a class so you can style them. The Compare button on the product pages class name is 'bt_compare_this' and the Compare button in the sidebar widget class name is 'compare_button_go'. Find the button style in you style sheets that you want to use and apply it to the plugin classes to change the buttons to your themes style.",'woo_cp'); ?></p>                  
                    </td>
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="button_text"><?php _e('BUTTON or LINK text','woo_cp'); ?></label></th>
                    <td class="forminp"><input type="text" name="button_text" id="button_text" value="<?php echo $comparable_settings['button_text']; ?>" style="min-width:300px;" /> <img class="help_tip" tip='<?php _e('Add the text you want to show on your Compare Button / Link on the Products pages', 'woo_cp') ?>' src="<?php echo WOOCP_IMAGES_URL; ?>/help.png" /></td>
                 </tr>
			</tbody>
		</table>
        <h3><?php _e('Compare Product Page Navigation Tab', 'woo_cp'); ?></h3></td>
        <table class="form-table">
			<tbody>
				<tr valign="top">
					<th class="titledesc" scope="rpw"><label for=""><?php _e('Compare Features Product Page Tab','woo_cp'); ?></label></th>
                    <td class="forminp"><div style="float:left; width:305px;">
                    	<input type="radio" name="auto_compare_featured_tab" value="9" <?php if($comparable_settings['auto_compare_featured_tab'] == '9'){ echo 'checked="checked"';} ?> /> <?php _e('Before Description tab','woo_cp'); ?>  <br />
                        <input type="radio" name="auto_compare_featured_tab" id="auto_compare_featured_tab1" value="19" <?php if($comparable_settings['auto_compare_featured_tab'] == '19'){ echo 'checked="checked"';} ?> /> <label for="auto_compare_featured_tab1"><?php _e('Between  Description and Additional tabs','woo_cp'); ?></label>  <br />
                        <input type="radio" name="auto_compare_featured_tab" id="auto_compare_featured_tab2" value="29" <?php if($comparable_settings['auto_compare_featured_tab'] == '29'){ echo 'checked="checked"';} ?> /> <label for="auto_compare_featured_tab2"><?php _e('Between  Additional and Reviews tabs','woo_cp'); ?> </label> <br />
                        <input type="radio" name="auto_compare_featured_tab" id="auto_compare_featured_tab3" value="31" <?php if($comparable_settings['auto_compare_featured_tab'] == '31'){ echo 'checked="checked"';} ?> /> <label for="auto_compare_featured_tab3"><?php _e('After Reviews tab','woo_cp'); ?></label>  <br />
                        <input type="radio" name="auto_compare_featured_tab" id="auto_compare_featured_tab4" value="0" <?php if($comparable_settings['auto_compare_featured_tab'] == '0'){ echo 'checked="checked"';} ?> /> <label for="auto_compare_featured_tab4"><?php _e('Do not auto show','woo_cp'); ?></label></div> <img class="help_tip" tip='<?php _e('Select the position of the Compare Features Tab on the default WooCommerce Product Page Nav bar. Products Compare feature list shows here.', 'woo_cp') ?>' src="<?php echo WOOCP_IMAGES_URL; ?>/help.png" /></td>
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for="compare_featured_tab"><?php _e('Compare Featured Tab','woo_cp'); ?></label></th>
                    <td class="forminp"><input type="text" name="compare_featured_tab" id="compare_featured_tab" value="<?php echo $comparable_settings['compare_featured_tab']; ?>" style="min-width:300px;" /> <img class="help_tip" tip='<?php _e('Give the tab you just created a name.', 'woo_cp') ?>' src="<?php echo WOOCP_IMAGES_URL; ?>/help.png" /></td>
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="rpw"><label for=""><?php _e('Manually Position Compare Features List','woo_cp'); ?></label></th>
                    <td class="forminp"><p class="description"><?php _e('If your theme does not use the WooCommerce Product Page Nav Bar You can use this function','woo_cp'); ?> <code>&lt;?php if(function_exists('woo_show_compare_fields')) echo woo_show_compare_fields(); ?&gt;</code> <?php _e('to put the code into your theme where you want to show Compare Featured fields to show.','woo_cp'); ?></p></td>
                 </tr>
			</tbody>
		</table>
        <p class="submit">
	        	<input type="submit" value="<?php _e('Save changes','woo_cp'); ?>" class="button-primary" name="bt_save_settings" id="bt_save_settings">
	        	<input type="submit" name="bt_reset_settings" id="bt_reset_settings" class="button-primary" value="<?php _e('Reset Settings','woo_cp'); ?>"  />
	    </p>
       	</form>
    <?php
	}
	
	function woo_right_sidebar(){
	?>
    	<div class="update_message">
        	<h3><?php _e('Rate This Plugin', 'woo_cp') ?></h3>
            <ul>
            	<li>* <a href=" http://wordpress.org/extend/plugins/woocommerce-compare-products/changelog/" target="_blank"><?php _e('Rate This Plugin', 'woo_cp') ?></a> - <?php _e('If you like this plugin please help other WooCommerce users by find it by giving it your star rating on Wordpress.org. Good ratings really on wordpress.org help others discover it as well.','woo_cp'); ?></li>
            </ul>
        	<h3><?php _e('SUPPORT', 'woo_cp'); ?></h3>
			<?php _e('Please post your support requests, questions or suggestions on the Plugins home page - Under the','woo_cp'); ?> <a href="http://a3rev.com/products-page/woocommerce/woocommerce-compare-products/#help" target="_blank"><?php _e('HELP','woo_cp'); ?></a> <?php _e('Tab','woo_cp'); ?>
        </div>
        <div class="update_message">
        	<h3><?php _e('Compare PRO Features','woo_cp'); ?></h3>
            <p><?php _e('Upgrade to WooCommerce Compare PRO you get these features','woo_cp'); ?>:</p>
            <ul>
            	<li>* <?php _e('NEW FEATURE! - Compare Products - Easily and quickly manage, activate / deactivate, add and edit Compare Features on every product and variations on your site from the Compare Products admin panel.','woo_cp'); ?></li>
            	<li>* <?php _e('Seamless Upgrade - you do not lose any of the Compare Features you have set up on the Lite Version when you upgrade.','woo_cp'); ?></li>
                <li>* <?php _e('Add to Cart Functionality from Compare Fly-Out Window.','woo_cp'); ?></li>
                <li>* <?php _e('Create Unlimited Compare Product Categories.','woo_cp'); ?></li>
                <li>* <?php _e('Assign Compare Features to Multiple categories.','woo_cp'); ?></li>
                <li>* <?php _e('Fly-Out Window only shows Compare Features for that Product - Not All.','woo_cp'); ?></li>
                <li>* <?php _e('Create Compare Features for Product "Variants" (Models).','woo_cp'); ?></li>
                <li>* <?php _e('Variants allows users to compare Model features side-by-side.','woo_cp'); ?></li>
                <li>* <?php _e('Managing the feature is much easier with the Pro Versions 3 Page dashboard and Compare Products manager.','woo_cp'); ?></li>
            </ul>
            <p><?php _e('PRO version available soon from the WooCommerce official Extensions site.'); ?>:</p>
        </div>
    <?php
	}
	
	function woo_compare_manager(){
		global $wpdb;	
		$result_msg = '';	
		$comparable_setting_msg = '';
		$current_tab = (isset($_REQUEST['tab'])) ? $_REQUEST['tab'] : 'settings';
		
		if(isset($_REQUEST['bt_save_settings'])){
			$comparable_settings = get_option('woo_comparable_settings');
			if(!isset($_REQUEST['auto_add'])) $comparable_settings['auto_add'] = 'no';
			$comparable_settings = array_merge((array)$comparable_settings, $_REQUEST);
			update_option('woo_comparable_settings', $comparable_settings);
			$comparable_setting_msg = '<div class="updated below-h2" id="comparable_settings_msg"><p>'.__('Compare Settings Successfully Saved','woo_cp').'.</p></div>';
		}elseif(isset($_REQUEST['bt_reset_settings'])){
			WOO_Compare_Class::woocp_set_setting_default(true);
			$comparable_setting_msg = '<div class="updated below-h2" id="comparable_settings_msg"><p>'.__('Compare Setting Successfully reset','woo_cp').'.</p></div>';
		}

		if(isset($_REQUEST['bt_save_field'])){
			if(isset($_REQUEST['field_id']) && $_REQUEST['field_id'] > 0){
				if(trim($_REQUEST['field_key']) == '' || WOO_Compare_Data::check_field_key_for_update($_REQUEST['field_id'], $_REQUEST['field_key'])){
					$result = WOO_Compare_Data::update_row($_REQUEST);
					$result_msg = '<div class="updated below-h2" id="result_msg"><p>'.__('Compare Feature edited successfully','woo_cp').'.</p></div>';
				}else{
					$result_msg = '<div class="error below-h2" id="result_msg"><p>'.__('This Feature Key already exists, please enter another unique Feature Key.','woo_cp').'.</p></div>';
				}
			}else{
				if(trim($_REQUEST['field_key']) == '' || WOO_Compare_Data::check_field_key($_REQUEST['field_key'])){
					$result = WOO_Compare_Data::insert_row($_REQUEST);	
					if($result > 0){
						$result_msg = '<div class="updated below-h2" id="result_msg"><p>'.__('Compare Feature Successfully created','woo_cp').'.</p></div>';
					}else{
						$result_msg = '<div class="error below-h2" id="result_msg"><p>'.__('Create Compare Feature error','woo_cp').'.</p></div>';
					}
				}else{
					$result_msg = '<div class="error below-h2" id="result_msg"><p>'.__('This Feature Key already exists, please enter another unique Feature Key.','woo_cp').'.</p></div>';
				}
			}
		}
		
		if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'delete'){
			$field_id = trim($_REQUEST['field_id']);
			WOO_Compare_Data::delete_row($field_id);
			$result_msg = '<div class="updated below-h2" id="result_msg"><p>'.__('Compare Feature Successfully deleted.','woo_cp').'.</p></div>';
		}
		?>
        <style>
			.form-table{margin:0;border-collapse:separate;}
			.help_tip{cursor: help;line-height: 1;margin: -4px 0 0 5px;padding: 0;vertical-align: middle;}
			.update_message{padding:10px; background-color:#FFFFCC;border:1px solid #DDDDDD;margin-bottom:15px;}
			.woocp_read_more{text-decoration:underline; cursor:pointer; margin-left:40px; color:#06F;}
			.ui-sortable-helper{background:#DDD; padding:8px 0 0;}
			.ui-state-highlight{background:#FFC; height:20px; padding:8px 0 0;}
			
			.update_order_message{color:#06C; margin:5px 0;}
			ul.compare_orders{float:left; margin:0; width:100%}
			ul.compare_orders li{padding-top:8px; border-top:1px solid #DFDFDF; margin:5px 0; line-height:20px;}
			ul.compare_orders li.first_record{border-top:none; padding-top:0;}
			ul.compare_orders .c_field_manager{background:url(<?php echo WOOCP_IMAGES_URL; ?>/icon_fields.png) no-repeat 0 0; width:16px; height:16px; display:inline-block;}
			.c_field_edit{background:url(<?php echo WOOCP_IMAGES_URL; ?>/icon_edit.png) no-repeat 0 0; width:16px; height:16px; display:inline-block;}
			.c_field_delete{background:url(<?php echo WOOCP_IMAGES_URL; ?>/icon_del.png) no-repeat 0 0; width:16px; height:16px; display:inline-block;}
			
			.compare_sort{margin-right:10px; float:none; width:50px; display:inline-block;}
			.c_field_name{background:url(<?php echo WOOCP_IMAGES_URL; ?>/icon_sort.png) no-repeat 0 center; margin-right:10px;padding:5px 0 5px 20px; float:none; width:auto;}
			.c_field_action{float:right; width:60px; text-align:right;}
			.c_field_type{float:right; margin-right:10px; width:130px; text-align:center;}
		</style>
        <script>
		(function($){
			$(function(){
				$(".woocp_read_more").toggle(
					function(){
						$(this).html('Read Less');
						$(this).siblings(".woocp_description_text").slideDown('slow');
					},
					function(){
						$(this).html('Read More');
						$(this).siblings(".woocp_description_text").slideUp('slow');
					}
				);
			});
		})(jQuery);
		function confirmation(text) {
			var answer = confirm(text)
			if (answer){
				return true;
			}else{
				return false;
			}
		}
		</script>
<div class="wrap">     
        <script type="text/javascript">
			(function($){
				$(function(){
					$("#field_type").change( function() {
						var field_type = $(this).val();
						if(field_type == 'checkbox' || field_type == 'radio' || field_type == 'drop-down' || field_type == 'multi-select'){
							$("#field_value").show();	
						}else{
							$("#field_value").hide();	
						}
					});
				});
			})(jQuery);
		</script>
    	<div class="icon32" id="icon-themes"><br></div><h2 class="nav-tab-wrapper">
		<?php
			$tabs = array(
				'settings' => __( 'Settings', 'woo_cp' ),
				'features' => __( 'Features', 'woo_cp' ),
			);
					
			foreach ($tabs as $name => $label) :
				echo '<a href="' . admin_url( 'admin.php?page=woo-compare-settings&tab=' . $name ) . '" class="nav-tab ';
				if( $current_tab==$name ) echo 'nav-tab-active';
				echo '">' . $label . '</a>';
			endforeach;
					
		?>
		</h2>
    <div style="float:right; width:25%; margin-left:5%; margin-top:30px;">
    	<?php WOO_Compare_Class::woo_right_sidebar(); ?>
    </div>
	<div style="width:70%; float:left;">
   	<?php
		switch ($current_tab) :
			case 'features':
				WOO_Compare_Class::woo_get_features_tab($result_msg);
				break;
			default :
				WOO_Compare_Class::woo_get_settings_tab($comparable_setting_msg);
				break;
		endswitch;
		
	?>        
        <div style="clear:both; margin-bottom:20px;"></div>
    </div>
</div>  
	<?php
	}
	
	function woocp_update_orders(){
		check_ajax_referer( 'woocp-update-order', 'security' );
				
		$updateRecordsArray 	= $_REQUEST['recordsArray'];
		$listingCounter = 1;
		foreach ($updateRecordsArray as $recordIDValue) {
			WOO_Compare_Data::update_order($recordIDValue, $listingCounter);
			$listingCounter++;
		}
		
		_e('You just save a new order for Compare Features.', 'woo_cp');
		die();
	}
		
}
?>
