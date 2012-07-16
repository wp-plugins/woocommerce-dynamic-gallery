<?php
function wc_dynamic_gallery_show() {
	WC_Gallery_Display_Class::wc_dynamic_gallery_display();
}

function wc_dynamic_gallery_install(){
	WC_Dynamic_Gallery::wc_dynamic_gallery_set_setting();
}

/**
 * Load languages file
 */
function wc_dynamic_gallery_init() {
	load_plugin_textdomain( 'woo_dgallery', false, WOO_DYNAMIC_GALLERY_FOLDER.'/languages' );
}
// Add language
add_action('init', 'wc_dynamic_gallery_init');

add_action( 'wp', 'setup_dynamic_gallery', 20);
function setup_dynamic_gallery() {
	if (is_product()) {
		global $post;
		
		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
		remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
		
		add_action( 'woocommerce_before_single_product_summary', 'wc_dynamic_gallery_show', 30);

		if ( in_array( 'woocommerce-professor-cloud/woocommerce-professor-cloud.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && get_option('woocommerce_cloud_enableCloud') == 'true' ) :
			remove_action( 'woocommerce_before_single_product_summary', 'wc_dynamic_gallery_show', 30);
		endif;
	}
}

global $wc_dg;
$wc_dg = new WC_Dynamic_Gallery();
?>