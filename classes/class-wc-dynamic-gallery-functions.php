<?php
/**
 * WC Dynamic Gallery Functions
 *
 * Table Of Contents
 *
 * reset_products_galleries_activate()
 * html2rgb()
 * rgb2html()
 * get_font()
 * get_font_sizes()
 * wc_dynamic_gallery_extension()
 * plugin_extra_links()
 * upgrade_1_2_1()
 */
class WC_Dynamic_Gallery_Functions 
{	
	public function reset_products_galleries_activate() {
		global $wpdb;
		$wpdb->query( "DELETE FROM ".$wpdb->postmeta." WHERE meta_key='_actived_d_gallery' " );
	}
	
	public static function html2rgb($color,$text = false){
		if ($color[0] == '#')
			$color = substr($color, 1);
	
		if (strlen($color) == 6)
			list($r, $g, $b) = array($color[0].$color[1],
									 $color[2].$color[3],
									 $color[4].$color[5]);
		elseif (strlen($color) == 3)
			list($r, $g, $b) = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
		else
			return false;
	
		$r = hexdec($r); $g = hexdec($g); $b = hexdec($b);
		if($text){
			return $r.','.$g.','.$b;
		}else{
			return array($r, $g, $b);
		}
	}
	
	public static function rgb2html($r, $g=-1, $b=-1){
		if (is_array($r) && sizeof($r) == 3)
			list($r, $g, $b) = $r;
	
		$r = intval($r); $g = intval($g);
		$b = intval($b);
	
		$r = dechex($r<0?0:($r>255?255:$r));
		$g = dechex($g<0?0:($g>255?255:$g));
		$b = dechex($b<0?0:($b>255?255:$b));
	
		$color = (strlen($r) < 2?'0':'').$r;
		$color .= (strlen($g) < 2?'0':'').$g;
		$color .= (strlen($b) < 2?'0':'').$b;
		return '#'.$color;
	}
	
	public static function get_font() {
		$fonts = array( 
			'Arial, sans-serif'													=> __( 'Arial', 'woo_dgallery' ),
			'Verdana, Geneva, sans-serif'										=> __( 'Verdana', 'woo_dgallery' ),
			'Trebuchet MS, Tahoma, sans-serif'								=> __( 'Trebuchet', 'woo_dgallery' ),
			'Georgia, serif'													=> __( 'Georgia', 'woo_dgallery' ),
			'Times New Roman, serif'											=> __( 'Times New Roman', 'woo_dgallery' ),
			'Tahoma, Geneva, Verdana, sans-serif'								=> __( 'Tahoma', 'woo_dgallery' ),
			'Palatino, Palatino Linotype, serif'								=> __( 'Palatino', 'woo_dgallery' ),
			'Helvetica Neue, Helvetica, sans-serif'							=> __( 'Helvetica*', 'woo_dgallery' ),
			'Calibri, Candara, Segoe, Optima, sans-serif'						=> __( 'Calibri*', 'woo_dgallery' ),
			'Myriad Pro, Myriad, sans-serif'									=> __( 'Myriad Pro*', 'woo_dgallery' ),
			'Lucida Grande, Lucida Sans Unicode, Lucida Sans, sans-serif'	=> __( 'Lucida', 'woo_dgallery' ),
			'Arial Black, sans-serif'											=> __( 'Arial Black', 'woo_dgallery' ),
			'Gill Sans, Gill Sans MT, Calibri, sans-serif'					=> __( 'Gill Sans*', 'woo_dgallery' ),
			'Geneva, Tahoma, Verdana, sans-serif'								=> __( 'Geneva*', 'woo_dgallery' ),
			'Impact, Charcoal, sans-serif'										=> __( 'Impact', 'woo_dgallery' ),
			'Courier, Courier New, monospace'									=> __( 'Courier', 'woo_dgallery' ),
			'Century Gothic, sans-serif'										=> __( 'Century Gothic', 'woo_dgallery' ),
		);
		
		return apply_filters('wc_dynamic_gallery_fonts_support', $fonts );
	}
	
	public static function get_font_sizes($start = 9, $end = 30, $unit = 'px') {
		$font_sizes = array();
		for ($start; $start <= $end; $start ++) {
			$font_sizes[$start.''.$unit] = $start.''.$unit;
		}
		
		return $font_sizes;
	}
	
	public static function wc_dynamic_gallery_extension() {
		$html = '';
		$html .= '<div id="wc_dynamic_gallery_extensions">';
		$html .= '<a href="http://a3rev.com/shop/" target="_blank" style="float:right;margin-top:5px; margin-left:10px;" ><img src="'.WOO_DYNAMIC_GALLERY_IMAGES_URL.'/a3logo.png" /></a>';
		$html .= '<h3>'.__('Upgrade to Dynamic Gallery Pro', 'woo_dgallery').'</h3>';
		$html .= '<p>'.__("<strong>NOTE:</strong> Settings inside the Yellow border are Pro Version advanced Features and are not activated. Visit the", 'woo_dgallery').' <a href="http://a3rev.com/shop/woocommerce-dynamic-gallery/" target="_blank">'.__("a3rev site", 'woo_dgallery').'</a> '.__("if you wish to upgrade to activate these features", 'woo_dgallery').':</p>';
		$html .= '<p>';
		$html .= '<ul style="padding-left:10px;">';
		$html .= '<li>1. '.__('Show Multiple Product Variation images in Gallery. As users selects options from the drop down menu that options product image auto shows in the Dynamic Gallery complete with caption text.', 'woo_dgallery').'</li>';
		$html .= '<li>2. '.__('Fully Responsive Gallery option. Set gallery wide to % and it becomes fully responsive image product gallery including the image zoom pop up.', 'woo_dgallery').'</li>';
		$html .= '<li>3. '.__('Activate all of the Gallery customization settings to style and fine tune your product image presentation.', 'woo_dgallery').'</li>';
		$html .= '<li>4. '.__('Option to Deactivate the Gallery on any Single product page - default WooCommerce product image will show.', 'woo_dgallery').'</li>';
		$html .= '</ul>';
		$html .= '</p>';
		$html .= '<h3>'.__('Plugin Documentation', 'woo_dgallery').'</h3>';
		$html .= '<p>'.__('All of our plugins have comprehensive online documentation. Please refer to the plugins docs before raising a support request', 'woo_dgallery').'. <a href="http://docs.a3rev.com/user-guides/woocommerce/woo-dynamic-gallery/" target="_blank">'.__('Visit the a3rev wiki.', 'woo_dgallery').'</a></p>';
		$html .= '<h3>'.__('More a3rev Quality Plugins', 'woo_dgallery').'</h3>';
		$html .= '<p>'.__('Below is a list of the a3rev plugins that are available for free download from wordpress.org', 'woo_dgallery').'</p>';
		$html .= '<h3>'.__('WooCommerce Plugins', 'woo_dgallery').'</h3>';
		$html .= '<p>';
		$html .= '<ul style="padding-left:10px;">';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/woocommerce-dynamic-gallery/" target="_blank">'.__('WooCommerce Dynamic Products Gallery', 'woo_dgallery').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/woocommerce-predictive-search/" target="_blank">'.__('WooCommerce Predictive Search', 'woo_dgallery').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/woocommerce-compare-products/" target="_blank">'.__('WooCommerce Compare Products', 'woo_dgallery').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/woo-widget-product-slideshow/" target="_blank">'.__('WooCommerce Widget Product Slideshow', 'woo_dgallery').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/woocommerce-email-inquiry-cart-options/" target="_blank">'.__('WooCommerce Email Inquiry & Cart Options', 'woo_dgallery').'</a></li>';
		$html .= '</ul>';
		$html .= '</p>';
		$html .= '<h3>'.__('WordPress Plugins', 'woo_dgallery').'</h3>';
		$html .= '<p>';
		$html .= '<ul style="padding-left:10px;">';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/wp-email-template/" target="_blank">'.__('WordPress Email Template', 'woo_dgallery').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/page-views-count/" target="_blank">'.__('Page View Count', 'woo_dgallery').'</a></li>';
		$html .= '</ul>';
		$html .= '</p>';
		$html .= '<h3>'.__('Help spread the Word about this plugin', 'woo_dgallery').'</h3>';
		$html .= '<p>'.__("Things you can do to help others find this plugin", 'woo_dgallery');
		$html .= '<ul style="padding-left:10px;">';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/woocommerce-dynamic-gallery/" target="_blank">'.__('Rate this plugin 5', 'woo_dgallery').' <img src="'.WOO_DYNAMIC_GALLERY_IMAGES_URL.'/stars.png" align="top" /> '.__('on WordPress.org', 'woo_dgallery').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/woocommerce-dynamic-gallery/" target="_blank">'.__('Mark the plugin as a fourite', 'woo_dgallery').'</a></li>';
		$html .= '</ul>';
		$html .= '</p>';
		$html .= '</div>';
		return $html;
	}
	
	public static function plugin_extra_links($links, $plugin_name) {
		if ( $plugin_name != WOO_DYNAMIC_GALLERY_NAME) {
			return $links;
		}
		$links[] = '<a href="http://docs.a3rev.com/user-guides/woocommerce/woo-dynamic-gallery/" target="_blank">'.__('Documentation', 'woo_dgallery').'</a>';
		$links[] = '<a href="http://wordpress.org/support/plugin/woocommerce-dynamic-gallery/" target="_blank">'.__('Support', 'woo_dgallery').'</a>';
		return $links;
	}
	
	public static function upgrade_1_2_1() {
		update_option( WOO_DYNAMIC_GALLERY_PREFIX.'activate', get_option('wc_dgallery_activate') );
		update_option( WOO_DYNAMIC_GALLERY_PREFIX.'product_gallery_width', get_option('product_gallery_width') );
		update_option( WOO_DYNAMIC_GALLERY_PREFIX.'width_type', get_option('woo_dg_width_type') );
		update_option( WOO_DYNAMIC_GALLERY_PREFIX.'show_variation', get_option('dynamic_gallery_show_variation') );
		update_option( WOO_DYNAMIC_GALLERY_PREFIX.'stop_scroll_1image', get_option('dynamic_gallery_stop_scroll_1image') );
		update_option( WOO_DYNAMIC_GALLERY_PREFIX.'product_gallery_height', get_option('product_gallery_height') );
		update_option( WOO_DYNAMIC_GALLERY_PREFIX.'thumb_width', get_option('thumb_width') );
		update_option( WOO_DYNAMIC_GALLERY_PREFIX.'thumb_height', get_option('thumb_height') );
		update_option( WOO_DYNAMIC_GALLERY_PREFIX.'thumb_spacing', get_option('thumb_spacing') );
		update_option( WOO_DYNAMIC_GALLERY_PREFIX.'product_gallery_speed', get_option('product_gallery_speed') );
		update_option( WOO_DYNAMIC_GALLERY_PREFIX.'product_gallery_effect', get_option('product_gallery_effect') );
		update_option( WOO_DYNAMIC_GALLERY_PREFIX.'product_gallery_auto_start', get_option('product_gallery_auto_start') );
		update_option( WOO_DYNAMIC_GALLERY_PREFIX.'product_gallery_animation_speed', get_option('product_gallery_animation_speed') );
		update_option( WOO_DYNAMIC_GALLERY_PREFIX.'bg_image_wrapper', get_option('bg_image_wrapper') );
		update_option( WOO_DYNAMIC_GALLERY_PREFIX.'border_image_wrapper_color', get_option('border_image_wrapper_color') );
		update_option( WOO_DYNAMIC_GALLERY_PREFIX.'product_gallery_text_color', get_option('product_gallery_text_color') );
		update_option( WOO_DYNAMIC_GALLERY_PREFIX.'product_gallery_bg_des', get_option('product_gallery_bg_des') );
		update_option( WOO_DYNAMIC_GALLERY_PREFIX.'product_gallery_nav', get_option('product_gallery_nav') );
		update_option( WOO_DYNAMIC_GALLERY_PREFIX.'bg_nav_color', get_option('bg_nav_color') );
		update_option( WOO_DYNAMIC_GALLERY_PREFIX.'bg_nav_text_color', get_option('bg_nav_text_color') );
		update_option( WOO_DYNAMIC_GALLERY_PREFIX.'popup_gallery', get_option('popup_gallery') );
		update_option( WOO_DYNAMIC_GALLERY_PREFIX.'enable_gallery_thumb', get_option('enable_gallery_thumb') );
		update_option( WOO_DYNAMIC_GALLERY_PREFIX.'transition_scroll_bar', get_option('transition_scroll_bar') );
		update_option( WOO_DYNAMIC_GALLERY_PREFIX.'lazy_load_scroll', get_option('lazy_load_scroll') );
		update_option( WOO_DYNAMIC_GALLERY_PREFIX.'caption_font', get_option('caption_font') );
		update_option( WOO_DYNAMIC_GALLERY_PREFIX.'caption_font_size', get_option('caption_font_size') );
		update_option( WOO_DYNAMIC_GALLERY_PREFIX.'caption_font_style', get_option('caption_font_style') );
		update_option( WOO_DYNAMIC_GALLERY_PREFIX.'navbar_font', get_option('navbar_font') );
		update_option( WOO_DYNAMIC_GALLERY_PREFIX.'navbar_font_size', get_option('navbar_font_size') );
		update_option( WOO_DYNAMIC_GALLERY_PREFIX.'navbar_font_style', get_option('navbar_font_style') );
		update_option( WOO_DYNAMIC_GALLERY_PREFIX.'navbar_height', get_option('navbar_height') );
		update_option( WOO_DYNAMIC_GALLERY_PREFIX.'hide_thumb_1image', get_option('dynamic_gallery_hide_thumb_1image') );
		update_option( WOO_DYNAMIC_GALLERY_PREFIX.'clean_on_deletion', get_option('wc_dgallery_clean_on_deletion') );
		update_option( WOO_DYNAMIC_GALLERY_PREFIX.'reset_galleries_activate', get_option('wc_dgallery_reset_galleries_activate') );
		update_option( WOO_DYNAMIC_GALLERY_PREFIX.'reset_variation_activate', get_option('wc_dgallery_reset_variation_activate') );
		
		global $wpdb;
		$wpdb->query( "UPDATE ".$wpdb->postmeta." SET meta_key='_wc_dgallery_show_variation' WHERE meta_key='_show_variation' " );
		$wpdb->query( "UPDATE ".$wpdb->postmeta." SET meta_key='_wc_dgallery_in_variations' WHERE meta_key='_in_variations' " );
	}
}
?>
