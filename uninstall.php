<?php
/**
 * Plugin Uninstall
 *
 * Uninstalling deletes options, tables, and pages.
 *
 */
if( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) 
	exit();

if ( get_option('wc_dgallery_lite_clean_on_deletion') == 'yes' ) {
	delete_option( 'wc_dgallery_product_gallery_width' );
	delete_option( 'wc_dgallery_width_type' );
	delete_option( 'wc_dgallery_product_gallery_height' );
	delete_option( 'wc_dgallery_product_gallery_auto_start' );
	delete_option( 'wc_dgallery_product_gallery_speed' );
	delete_option( 'wc_dgallery_product_gallery_effect' );
	delete_option( 'wc_dgallery_product_gallery_animation_speed' );
	delete_option( 'wc_dgallery_stop_scroll_1image' );
	delete_option( 'wc_dgallery_bg_image_wrapper' );
	delete_option( 'wc_dgallery_border_image_wrapper_color' );

	delete_option( 'wc_dgallery_hide_woo_gallery' );
	delete_option( 'wc_dgallery_popup_gallery' );
	delete_option( 'wc_dgallery_activate' );
	delete_option( 'wc_dgallery_reset_galleries_activate' );
	delete_option( 'wc_dgallery_show_variation' );
	delete_option( 'wc_dgallery_reset_variation_activate' );

	delete_option( 'wc_dgallery_caption_font' );
	delete_option( 'wc_dgallery_caption_font_size' );
	delete_option( 'wc_dgallery_caption_font_style' );
	delete_option( 'wc_dgallery_product_gallery_text_color' );
	delete_option( 'wc_dgallery_product_gallery_bg_des' );

	delete_option( 'wc_dgallery_product_gallery_nav' );
	delete_option( 'wc_dgallery_navbar_font' );
	delete_option( 'wc_dgallery_navbar_font_size' );
	delete_option( 'wc_dgallery_navbar_font_style' );
	delete_option( 'wc_dgallery_bg_nav_color' );
	delete_option( 'wc_dgallery_bg_nav_text_color' );
	delete_option( 'wc_dgallery_navbar_height' );

	delete_option( 'wc_dgallery_lazy_load_scroll' );
	delete_option( 'wc_dgallery_transition_scroll_bar' );

	delete_option( 'wc_dgallery_enable_gallery_thumb' );
	delete_option( 'wc_dgallery_hide_thumb_1image' );
	delete_option( 'wc_dgallery_thumb_width' );
	delete_option( 'wc_dgallery_thumb_height' );
	delete_option( 'wc_dgallery_thumb_spacing' );

	delete_option( 'wc_dgallery_product_gallery_width_responsive' );
	delete_option( 'wc_dgallery_product_gallery_width_fixed' );

	delete_option('wc_dgallery_lite_clean_on_deletion');

	delete_post_meta_by_key('_actived_d_gallery');
	delete_post_meta_by_key('_wc_dgallery_show_variation');
	delete_post_meta_by_key('_woocommerce_exclude_image');
	delete_post_meta_by_key('_wc_dgallery_in_variations');
}