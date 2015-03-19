<?php
/**
 * The Template for compare products
 *
 * Override this template by copying it to yourtheme/woocommerce/product-compare.php
 *
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

		$woo_compare_logo = get_option('woo_compare_logo');
		$suffix	= defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		global $woocommerce, $woo_compare_page_style, $woo_compare_close_window_button_style, $woo_compare_viewcart_style;
		global $woo_compare_comparison_page_global_settings;
		global $woo_compare_print_page_settings;

		$wc_frontend_script_path = str_replace( array( 'http:', 'https:' ), '', $woocommerce->plugin_url() ) . '/assets/js/frontend/';

		// Variables for JS scripts
		$woocommerce_params = array(
			'plugin_url'                       => $woocommerce->plugin_url(),
			'ajax_url'                         => $woocommerce->ajax_url(),
			'ajax_loader_url'                  => apply_filters( 'woocommerce_ajax_loader_url', str_replace( array( 'http:', 'https:' ), '', $woocommerce->plugin_url() ) . '/assets/images/ajax-loader@2x.gif' ),
			'i18n_view_cart'                   => $woo_compare_viewcart_style['viewcart_text'],
			'add_to_cart_nonce'                => wp_create_nonce( "add-to-cart" ),
			'cart_url'                         => get_permalink( woocommerce_get_page_id( 'cart' ) ),
			'cart_redirect_after_add'          => get_option( 'woocommerce_cart_redirect_after_add' )
		);

?>
<!doctype html>
<html>
<head>
<!-- <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> -->
<?php global $post; ?>
<?php $site_url = str_replace( array( 'http:', 'https:' ), '', get_option('siteurl') ); ?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width; initial-scale=0.8; maximum-scale=1.0; minimum-scale=0.5;">
<title><?php echo $post->post_title; ?> | <?php bloginfo('name'); ?></title>
<meta name="description" content="Default Description" />
<meta name="keywords" content="<?php bloginfo('name'); ?>" />
<meta name="robots" content="INDEX,FOLLOW" />
<script type="text/javascript" src="<?php echo $site_url; ?>/wp-includes/js/jquery/jquery.js"></script>
<script src="<?php echo WOOCP_JS_URL; ?>/jquery.printElement.js"></script>
<?php do_action('woocp_comparison_page_header'); ?>
<?php $woocommerce->frontend_scripts(); ?>
</head>
<body>
		<?php
			$print_button_class = 'compare_print_button_type';
			$print_custom_class = '';
			$print_button_text = $woo_compare_print_page_settings['button_text'];

			$close_button_class = 'compare_close_button_type';
			$close_custom_class = '';
			$close_button_text = $woo_compare_close_window_button_style['button_text'];
		?>
    	<div class="compare_print_container"><div id="compare_popup_container" class="compare_popup_container">
        <link type="text/css" href="<?php echo WOOCP_JS_URL; ?>/fixedcolumntable/fixedcolumntable.css" rel="stylesheet" />
        <?php
        $_upload_dir = wp_upload_dir();
		if ( file_exists( $_upload_dir['basedir'] . '/sass/wc_product_comparison.min.css' ) ) {
			echo '<link media="screen" type="text/css" href="' . $_upload_dir['baseurl'] . '/sass/wc_product_comparison.min.css" rel="stylesheet" />' . "\n";
		} else {
			include( WOOCP_DIR. '/templates/product_comparison_style.php' );
		}
		?>
        <?php do_action('woocp_comparison_table_before'); ?>
				<div class="compare_heading">
					<?php if ( $woo_compare_logo != '') { ?>
                    <img class="compare_logo" src="<?php echo $woo_compare_logo; ?>" alt="<?php _e('Compare Products', 'woo_cp'); ?>" />
                    <?php } else { ?>
                    <h1><?php _e('Compare Products', 'woo_cp'); ?></h1>
                    <?php } ?>
                    <div class="print_control">
                        <?php if ($woo_compare_comparison_page_global_settings['open_compare_type'] != 'new_page') { ?><a class="woo_compare_close <?php echo $close_button_class ;?> <?php echo $close_custom_class ;?>" href="#" onClick="window.close();"><span><?php echo $close_button_text ;?></span></a><?php } ?>
                        <?php if ( $woo_compare_print_page_settings['enable_print_page_feature'] == 1 ) { ?>
                        <a id="woo_compare_print" class="woo_compare_print <?php echo $print_button_class ;?> <?php echo $print_custom_class ;?>" href="#"><span><?php echo $print_button_text ;?></span></a>
                        <div style="clear:both;"></div>
                    	<div class="woo_compare_print_msg"><?php echo $woo_compare_print_page_settings['print_message_text'];?></div>
                        <?php } ?>
                    </div>
                </div>
            	<div style="clear:both;"></div>
                <div class="popup_woo_compare_widget_loader" style="display:none;"><img src="<?php echo WOOCP_IMAGES_URL; ?>/ajax-loader.gif" border=0 /></div>
                <div class="compare_popup_wrap">
                    <?php echo WC_Compare_Functions::get_compare_list_html_popup();?>
                </div>
        <?php do_action('woocp_comparison_table_after'); ?>
        </div>
        </div>
        <?php
			$woocp_compare_events = wp_create_nonce("woocp-compare-events");
		?>
        <script type="text/javascript">
			jQuery(document).ready(function($) {
						var ajax_url = "<?php echo admin_url( 'admin-ajax.php', 'relative' );?>";
						<?php if ( $woo_compare_print_page_settings['enable_print_page_feature'] == 1 ) { ?>
						$(document).on("click", "#woo_compare_print", function(){
							$(".compare_print_container").printElement({
								printBodyOptions:{
								styleToAdd:"overflow:visible !important;",
								classNameToAdd : "compare_popup_print"
								}
							});
						});
						<?php } ?>
						$(document).on("click", ".woo_compare_popup_remove_product", function(){
							var popup_remove_product_id = $(this).attr("rel");
							$(".popup_woo_compare_widget_loader").show();
							$(".compare_popup_wrap").html("");
							$("#bg-labels").remove();
							var data = {
								action: 		"woocp_remove_from_popup_compare",
								product_id: 	popup_remove_product_id,
								security: 		"<?php echo $woocp_compare_events; ?>"
							};
							$.post( ajax_url, data, function(response) {
								data = {
									action: 		"woocp_update_compare_popup",
									security: 		"<?php echo $woocp_compare_events; ?>"
								};
								$.post( ajax_url, data, function(response) {
									result = $.parseJSON( response );
									$(".popup_woo_compare_widget_loader").hide();
									$(".compare_popup_wrap").html(result);
								});

								data = {
									action: 		"woocp_update_compare_widget",
									security: 		"<?php echo $woocp_compare_events; ?>"
								};
								$.post( ajax_url, data, function(response) {
									new_widget = $.parseJSON( response );
									$(".woo_compare_widget_container").html(new_widget);
								});
							});
						});
						$(document).on( 'click', '.add_to_cart_button', function() {
							$(this).parent().find('.virtual_added_to_cart').remove();
							setTimeout(function(){ $(document).find('.added_to_cart').attr('target', 'parent'); }, 3000);
						});
			});
		</script>
        <?php do_action('woocp_comparison_page_footer'); ?>
        <script src="<?php echo WOOCP_JS_URL; ?>/fixedcolumntable/fixedcolumntable.js"></script>
        <script src="<?php echo $wc_frontend_script_path; ?>add-to-cart-variation<?php echo $suffix; ?>.js"></script>
        <script src="<?php echo $wc_frontend_script_path; ?>add-to-cart<?php echo $suffix; ?>.js"></script>
        <script src="<?php echo str_replace( array( 'http:', 'https:' ), '', $woocommerce->plugin_url() ); ?>/assets/js/jquery-blockui/jquery.blockUI<?php echo $suffix; ?>.js"></script>
<script type="text/javascript">
/* !![CDATA[ */
var woocommerce_params = <?php echo json_encode( $woocommerce_params, JSON_FORCE_OBJECT) ?>;
/* ]]> */
</script>
</body>
</html>
