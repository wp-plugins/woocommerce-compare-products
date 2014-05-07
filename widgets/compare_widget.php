<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * Create WOO Compare Widget
 */
add_action( 'widgets_init', create_function('', 'return register_widget("WC_Compare_Widget");') );

/**
 * WooCommerce Compare Widget
 *
 * Table Of Contents
 *
 * WC_Compare_Widget()
 * widget()
 * update()
 * form()
 */
class WC_Compare_Widget extends WP_Widget
{

	function WC_Compare_Widget() {
		$widget_ops = array('classname' => 'woo_compare_widget');
		$this->WP_Widget('woo_compare_widget', __('WOO Compare Products', 'woo_cp'), $widget_ops);

	}
	function widget($args, $instance) {
		global $woo_compare_widget_style, $woo_compare_widget_title_style;
		extract($woo_compare_widget_style);
		extract($woo_compare_widget_title_style);
		extract($args, EXTR_SKIP);
		$total_compare_product = 0;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		
		echo $before_widget;
		
		if ( $title != '')
			echo $before_title . $title . ' <span class="total_compare_product_container">'.$before_total_text.'<span id="total_compare_product">'.$total_compare_product.'</span>'.$after_total_text.'</span>' . $after_title;
		else
			echo $before_title . __( 'Compare Products', 'woo_cp' ).' <span class="total_compare_product_container">'.$before_total_text.'<span id="total_compare_product">'.$total_compare_product.'</span>'.$after_total_text.'</span>' . $after_title;


		echo '<div class="woo_compare_widget_container"></div><div class="woo_compare_widget_loader" style="display:none; text-align:center"><img src="'.WOOCP_IMAGES_URL.'/ajax-loader.gif" border=0 /></div>';

		echo $after_widget;

	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;

	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		$title = strip_tags($instance['title']);
?>

        <p>
          	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title', 'woo_cp' ); ?> :
            	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
          	</label>
        </p>
		<?php
	}
}

/**
 * Auto Add Compare Widget
 *
 * Table Of Contents
 *
 * automatic_add_widget_to_sidebar()
 */
class WC_Compare_Widget_Add 
{
	public static function automatic_add_widget_to_sidebar() {
		$add_to_sidebars = array('primary', 'primary-widget-area', 'sidebar-1');
		$widget_name = 'woo_compare_widget';
		$sidebar_options = get_option('sidebars_widgets');
		$compare_widget = get_option('widget_'.$widget_name);
		$have_widget = false;
		foreach ($sidebar_options as $siderbar_name => $sidebar_widgets) {
			if ($siderbar_name == 'wp_inactive_widgets') continue;
			if (is_array($sidebar_widgets) && count($sidebar_widgets) > 0) {
				foreach ($sidebar_widgets as $sidebar_widget) {
					if (stristr($sidebar_widget, $widget_name) !== false) {
						$have_widget = true;
						break;
					}
				}
			}
			if ($have_widget) break;
		}
		if (!$have_widget) {
			if (!is_array($compare_widget)) $compare_widget = array();
			$count = count($compare_widget)+1;
			$added_widget = false;
			$new_sidebar_options = $sidebar_options;
			foreach ($add_to_sidebars as $sidebar_name) {
				if (isset($sidebar_options[$sidebar_name])) {
					$sidebar_options[$sidebar_name][] = $widget_name.'-'.$count;
					$added_widget = true;
					break;
				}
			}
			if (!$added_widget) {
				foreach ($new_sidebar_options as $siderbar_name => $sidebar_widgets) {
					if ($siderbar_name == 'wp_inactive_widgets') continue;
					$sidebar_options[$siderbar_name][] = $widget_name.'-'.$count;
					break;
				}
			}

			// add widget to sidebar:
			$compare_widget[$count] = array(
				'title' => ''
			);
			update_option('sidebars_widgets', $sidebar_options);
			update_option('widget_'.$widget_name, $compare_widget);
		}
	}
}
?>
