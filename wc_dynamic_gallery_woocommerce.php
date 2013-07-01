<?php
/*
Plugin Name: WooCommerce Dynamic Gallery LITE
Plugin URI: http://a3rev.com/shop/woocommerce-dynamic-gallery/
Description: Auto adds a fully customizable dynamic images gallery to every single product page with thumbnails, caption text and lazy-load. Over 28 settings to fine tune every aspect of the gallery. Creates an image gallery manager on every product edit page - greatly simplifies managing product images. Search engine optimized images with WooCommerce Dynamic Gallery Pro.
Version: 1.2.0
Author: A3 Revolution
Author URI: http://www.a3rev.com/
License: GPLv2 or later
*/

/*
	WooCommerce Dynamic Gallery. Plugin for the WooCommerce plugin.
	Copyright © 2011 A3 Revolution Software Development team
	
	A3 Revolution Software Development team
	admin@a3rev.com
	PO Box 1170
	Gympie 4570
	QLD Australia
*/
?>
<?php
define( 'WOO_DYNAMIC_GALLERY_FILE_PATH', dirname(__FILE__) );
define( 'WOO_DYNAMIC_GALLERY_DIR_NAME', basename(WOO_DYNAMIC_GALLERY_FILE_PATH) );
define( 'WOO_DYNAMIC_GALLERY_FOLDER', dirname(plugin_basename(__FILE__)) );
define( 'WOO_DYNAMIC_GALLERY_NAME', plugin_basename(__FILE__) );
define( 'WOO_DYNAMIC_GALLERY_URL', WP_CONTENT_URL.'/plugins/'.WOO_DYNAMIC_GALLERY_FOLDER );
define( 'WOO_DYNAMIC_GALLERY_DIR', WP_CONTENT_DIR.'/plugins/'.WOO_DYNAMIC_GALLERY_FOLDER );
define( 'WOO_DYNAMIC_GALLERY_IMAGES_URL',  WOO_DYNAMIC_GALLERY_URL . '/assets/images' );
define( 'WOO_DYNAMIC_GALLERY_JS_URL',  WOO_DYNAMIC_GALLERY_URL . '/assets/js' );

include('classes/class-wc-dynamic-gallery-variations.php');
include('classes/class-wc-dynamic-gallery.php');
include('classes/class-wc-dynamic-gallery-preview.php');
include('classes/class-wc-dynamic-gallery-metaboxes.php');
include('admin/class-wc-dynamic-gallery-admin.php');
include('admin/wc_gallery_woocommerce_admin.php');

/**
* Call when the plugin is activated
*/
register_activation_hook(__FILE__,'wc_dynamic_gallery_install');

function wc_dynamic_gallery_uninstall() {
	if ( get_option('wc_dgallery_clean_on_deletion') == 'yes' ) {
		delete_option('product_gallery_width');
		delete_option('woo_dg_width_type');
		delete_option('product_gallery_height');
		delete_option('product_gallery_auto_start');
		delete_option('product_gallery_speed');
		delete_option('product_gallery_effect');
		delete_option('product_gallery_animation_speed');
		delete_option('dynamic_gallery_stop_scroll_1image');
		delete_option('bg_image_wrapper');
		delete_option('border_image_wrapper_color');
		
		delete_option('popup_gallery');
		delete_option('wc_dgallery_activate');
		delete_option('wc_dgallery_reset_galleries_activate');
		delete_option('dynamic_gallery_show_variation');
		delete_option('wc_dgallery_reset_variation_activate');
		
		delete_option('caption_font');
		delete_option('caption_font_size');
		delete_option('caption_font_style');
		delete_option('product_gallery_text_color');
		delete_option('product_gallery_bg_des');
		
		delete_option('product_gallery_nav');
		delete_option('navbar_font');
		delete_option('navbar_font_size');
		delete_option('navbar_font_style');
		delete_option('bg_nav_color');
		delete_option('bg_nav_text_color');
		delete_option('navbar_height');
		
		delete_option('lazy_load_scroll');
		delete_option('transition_scroll_bar');
		
		delete_option('enable_gallery_thumb');
		delete_option('dynamic_gallery_hide_thumb_1image');
		delete_option('thumb_width');
		delete_option('thumb_height');
		delete_option('thumb_spacing');
		
		delete_option('wc_dgallery_clean_on_deletion');
		
		delete_post_meta_by_key('_actived_d_gallery');
		delete_post_meta_by_key('_show_variation');
		delete_post_meta_by_key('_woocommerce_exclude_image');
		delete_post_meta_by_key('_in_variations');
	}
}
if ( get_option('wc_dgallery_clean_on_deletion') == 'yes' ) {
	register_uninstall_hook( __FILE__, 'wc_dynamic_gallery_uninstall' );
}
?>