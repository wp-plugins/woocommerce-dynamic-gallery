<?php
function wc_dynamic_gallery_show() {
	WC_Gallery_Display_Class::wc_dynamic_gallery_display();
}

function wc_dynamic_gallery_install(){
	update_option('a3rev_woo_dgallery_version', '1.0.9');
	WC_Dynamic_Gallery::wc_dynamic_gallery_set_setting(true, true);
}

/**
 * Load languages file
 */
function wc_dynamic_gallery_init() {
	load_plugin_textdomain( 'woo_dgallery', false, WOO_DYNAMIC_GALLERY_FOLDER.'/languages' );
	$thumb_width = get_option('thumb_width');
	$thumb_height = get_option('thumb_height');
	add_image_size( 'wc-dynamic-gallery-thumb', $thumb_width, $thumb_height, false  );
}
// Add language
add_action('init', 'wc_dynamic_gallery_init');

// Add text on right of Visit the plugin on Plugin manager page
add_filter( 'plugin_row_meta', array('WC_Dynamic_Gallery', 'plugin_extra_links'), 10, 2 );

add_filter( 'attachment_fields_to_edit', array('WC_Dynamic_Gallery_Variations', 'media_fields'), 10, 2 );

add_action( 'wp', 'setup_dynamic_gallery', 20);
function setup_dynamic_gallery() {
	if (is_product()) {
		global $post;
		
		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
		remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
		
		add_action( 'woocommerce_before_single_product_summary', 'wc_dynamic_gallery_show', 30);
		
		wp_enqueue_style( 'ad-gallery-style', WOO_DYNAMIC_GALLERY_JS_URL . '/mygallery/jquery.ad-gallery.css' );
		wp_enqueue_script( 'ad-gallery-script', WOO_DYNAMIC_GALLERY_JS_URL . '/mygallery/jquery.ad-gallery.js', array(), false, true );
		
		$popup_gallery = get_option('popup_gallery');
		if($popup_gallery == 'lb'){
			wp_enqueue_style( 'a3_lightbox_style', WOO_DYNAMIC_GALLERY_JS_URL . '/lightbox/themes/default/jquery.lightbox.css' );
			wp_enqueue_script( 'lightbox2_script', WOO_DYNAMIC_GALLERY_JS_URL . '/lightbox/jquery.lightbox.min.js', array(), false, true );
		}else{
			wp_enqueue_style( 'woocommerce_fancybox_styles', WOO_DYNAMIC_GALLERY_JS_URL . '/fancybox/fancybox.css' );
			wp_enqueue_script( 'fancybox', WOO_DYNAMIC_GALLERY_JS_URL . '/fancybox/fancybox.min.js', array(), false, true );
		}

		if ( in_array( 'woocommerce-professor-cloud/woocommerce-professor-cloud.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && get_option('woocommerce_cloud_enableCloud') == 'true' ) :
			remove_action( 'woocommerce_before_single_product_summary', 'wc_dynamic_gallery_show', 30);
		endif;
	}
}

// Upgrade to 1.0.4
if(version_compare(get_option('a3rev_woo_dgallery_version'), '1.0.4') === -1){
	update_option('width_type','px');
	WC_Dynamic_Gallery::wc_dynamic_gallery_set_setting(true, true);
	update_option('a3rev_woo_dgallery_version', '1.0.4');
}

update_option('a3rev_woo_dgallery_version', '1.0.9');

global $wc_dg;
$wc_dg = new WC_Dynamic_Gallery();
?>