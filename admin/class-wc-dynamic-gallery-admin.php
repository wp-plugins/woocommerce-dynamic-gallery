<?php
/**
 * WooCommerce Dynamic Gallery Class
 *
 * Class Function into woocommerce plugin
 *
 * Table Of Contents
 *
 * custom_types()
 * wc_dynamic_gallery_set_setting()
 * __construct()
 * on_add_tab()
 * settings_tab_action()
 * add_settings_fields()
 * get_tab_in_view()
 * init_form_fields()
 * save_settings()
 * setting()
 * wc_dynamic_gallery_width()
 * wc_dynamic_gallery_upgrade_area_start()
 * wc_dynamic_gallery_upgrade_area_end()
 */
class WC_Dynamic_Gallery 
{
	public function custom_types() {
		$custom_type = array('wc_dynamic_gallery_width');
		
		return $custom_type;
	}
	public function wc_dynamic_gallery_set_setting($reset=false, $free_version=false) {
		global $wpdb;
		if ( ( get_option( WOO_DYNAMIC_GALLERY_PREFIX.'activate' ) === false || $reset) && !$free_version ) {
			update_option( WOO_DYNAMIC_GALLERY_PREFIX.'activate', 'yes' );
		}
		if ( ( trim( get_option( WOO_DYNAMIC_GALLERY_PREFIX.'product_gallery_width', '') ) == '' || $reset) && !$free_version ) {
			update_option( WOO_DYNAMIC_GALLERY_PREFIX.'product_gallery_width', '320' );
		}
		if ( ( trim( get_option( WOO_DYNAMIC_GALLERY_PREFIX.'product_gallery_height', '') ) == '' || $reset) && !$free_version ) {
			update_option( WOO_DYNAMIC_GALLERY_PREFIX.'product_gallery_height', 215 );
		}
		if ( ( trim( get_option( WOO_DYNAMIC_GALLERY_PREFIX.'thumb_width', '') ) == '' || $reset) && !$free_version) {
			update_option( WOO_DYNAMIC_GALLERY_PREFIX.'thumb_width', 105 );
		}
		if ( ( trim( get_option( WOO_DYNAMIC_GALLERY_PREFIX.'thumb_height', '') ) == '' || $reset) && !$free_version) {
			update_option( WOO_DYNAMIC_GALLERY_PREFIX.'thumb_height', 75 );
		}
		if ( ( trim( get_option( WOO_DYNAMIC_GALLERY_PREFIX.'thumb_spacing', '') ) == '' || $reset) && !$free_version) {
			update_option( WOO_DYNAMIC_GALLERY_PREFIX.'thumb_spacing', 2 );
		}
		if ( trim( get_option( WOO_DYNAMIC_GALLERY_PREFIX.'product_gallery_speed', '') ) == '' || $reset ) {
			update_option( WOO_DYNAMIC_GALLERY_PREFIX.'product_gallery_speed', 4 );
		}
		if ( trim( get_option( WOO_DYNAMIC_GALLERY_PREFIX.'product_gallery_effect', '') ) == '' || $reset ) {
			update_option( WOO_DYNAMIC_GALLERY_PREFIX.'product_gallery_effect', 'slide-vert' );
		}
		if ( trim( get_option( WOO_DYNAMIC_GALLERY_PREFIX.'product_gallery_auto_start', '') ) == '' || $reset ) {
			update_option( WOO_DYNAMIC_GALLERY_PREFIX.'product_gallery_auto_start', 'true' );
		}
		if ( trim( get_option( WOO_DYNAMIC_GALLERY_PREFIX.'product_gallery_animation_speed', '') ) == '' || $reset ) {
			update_option( WOO_DYNAMIC_GALLERY_PREFIX.'product_gallery_animation_speed', 2 );
		}
		if ( trim( get_option( WOO_DYNAMIC_GALLERY_PREFIX.'bg_image_wrapper', '') ) == '' || $reset ) {
			update_option( WOO_DYNAMIC_GALLERY_PREFIX.'bg_image_wrapper', '#FFFFFF' );
		}
		if ( trim( get_option( WOO_DYNAMIC_GALLERY_PREFIX.'border_image_wrapper_color', '') ) == '' || $reset ) {
			update_option( WOO_DYNAMIC_GALLERY_PREFIX.'border_image_wrapper_color', '#CCCCCC' );
		}
		if ( trim( get_option( WOO_DYNAMIC_GALLERY_PREFIX.'product_gallery_text_color', '') ) == '' || $reset ) {
			update_option( WOO_DYNAMIC_GALLERY_PREFIX.'product_gallery_text_color', '#FFFFFF' );
		}
		if ( trim( get_option( WOO_DYNAMIC_GALLERY_PREFIX.'product_gallery_bg_des', '') ) == '' || $reset ) {
			update_option( WOO_DYNAMIC_GALLERY_PREFIX.'product_gallery_bg_des', '#886bab' );
		}
		if ( get_option( WOO_DYNAMIC_GALLERY_PREFIX.'product_gallery_nav' ) === false || $reset ) {
			update_option( WOO_DYNAMIC_GALLERY_PREFIX.'product_gallery_nav', 'yes' );
		}
		if ( trim( get_option( WOO_DYNAMIC_GALLERY_PREFIX.'bg_nav_color', '') ) == '' || $reset ) {
			update_option( WOO_DYNAMIC_GALLERY_PREFIX.'bg_nav_color', '#FFFFFF' );
		}
		if ( trim( get_option( WOO_DYNAMIC_GALLERY_PREFIX.'bg_nav_text_color', '') ) == '' || $reset ) {
			update_option( WOO_DYNAMIC_GALLERY_PREFIX.'bg_nav_text_color', '#886bab' );
		}
		if ( (trim( get_option( WOO_DYNAMIC_GALLERY_PREFIX.'popup_gallery', '') ) == '' || $reset) && !$free_version ) {
			update_option( WOO_DYNAMIC_GALLERY_PREFIX.'popup_gallery', 'prettyphoto' );
		}
		if ( get_option( WOO_DYNAMIC_GALLERY_PREFIX.'enable_gallery_thumb' ) === false || $reset ) {
			update_option( WOO_DYNAMIC_GALLERY_PREFIX.'enable_gallery_thumb', 'yes' );
		}
		if ( trim( get_option( WOO_DYNAMIC_GALLERY_PREFIX.'transition_scroll_bar', '') ) == '' || $reset ) {
			update_option( WOO_DYNAMIC_GALLERY_PREFIX.'transition_scroll_bar', '#886bab' );
		}
		if ( get_option( WOO_DYNAMIC_GALLERY_PREFIX.'lazy_load_scroll' ) === fase || $reset ) {
			update_option( WOO_DYNAMIC_GALLERY_PREFIX.'lazy_load_scroll', 'yes' );
		}
		
		if ( trim( get_option( WOO_DYNAMIC_GALLERY_PREFIX.'caption_font', '') ) == '' || $reset ) {
			update_option( WOO_DYNAMIC_GALLERY_PREFIX.'caption_font', 'Arial, sans-serif' );
		}
		if ( trim( get_option( WOO_DYNAMIC_GALLERY_PREFIX.'caption_font_size', '') ) == '' || $reset ) {
			update_option( WOO_DYNAMIC_GALLERY_PREFIX.'caption_font_size', '12px' );
		}
		if ( trim( get_option( WOO_DYNAMIC_GALLERY_PREFIX.'caption_font_style', '') ) == '' || $reset ) {
			update_option( WOO_DYNAMIC_GALLERY_PREFIX.'caption_font_style', 'normal' );
		}
		
		if ( trim( get_option( WOO_DYNAMIC_GALLERY_PREFIX.'navbar_font', '') ) == '' || $reset ) {
			update_option( WOO_DYNAMIC_GALLERY_PREFIX.'navbar_font', 'Arial, sans-serif' );
		}
		if ( trim( get_option( WOO_DYNAMIC_GALLERY_PREFIX.'navbar_font_size', '') ) == '' || $reset ) {
			update_option( WOO_DYNAMIC_GALLERY_PREFIX.'navbar_font_size', '12px' );
		}
		if ( trim( get_option( WOO_DYNAMIC_GALLERY_PREFIX.'navbar_font_style', '') ) == '' || $reset ) {
			update_option( WOO_DYNAMIC_GALLERY_PREFIX.'navbar_font_style', 'bold' );
		}
		if ( trim( get_option( WOO_DYNAMIC_GALLERY_PREFIX.'navbar_height', '') ) == '' || $reset ) {
			update_option( WOO_DYNAMIC_GALLERY_PREFIX.'navbar_height', '25' );
		}
		if ( get_option( WOO_DYNAMIC_GALLERY_PREFIX.'clean_on_deletion' ) === false || $reset ) {
			update_option( WOO_DYNAMIC_GALLERY_PREFIX.'clean_on_deletion', 'no' );
		}
	}
	
	public function __construct() {
   		$this->current_tab = ( isset($_GET['tab']) ) ? $_GET['tab'] : 'general';
    	$this->settings_tabs = array(
        	'dynamic_gallery' => __('Dynamic Gallery', 'woothemes')
        );
        add_action('woocommerce_settings_tabs', array(&$this, 'on_add_tab'), 10);
		
		// add custom type to woocommerce fields
		foreach ($this->custom_types() as $custom_type) {
			add_action('woocommerce_admin_field_'.$custom_type, array(&$this, $custom_type) );
		}

        // Run these actions when generating the settings tabs.
        foreach ( $this->settings_tabs as $name => $label ) {
        	add_action('woocommerce_settings_tabs_' . $name, array(&$this, 'settings_tab_action'), 10);
          	add_action('woocommerce_update_options_' . $name, array(&$this, 'save_settings'), 10);
        }
				
		// Add sub tabs
		add_action('woocommerce_settings_dynamic_gallery_settings_end_after', array(&$this, 'dynamic_gallery_settings_end_after') );
		add_action('woocommerce_settings_dynamic_gallery_reset_activation_end_after', array(&$this, 'dynamic_gallery_reset_activation_end_after') );
		add_action('woocommerce_settings_dynamic_gallery_global_settings_end_after', array(&$this, 'dynamic_gallery_global_settings_end_after') );
		
		add_action('woocommerce_settings_dynamic_gallery_caption_end_after', array(&$this, 'dynamic_gallery_caption_end_after') );
		add_action('woocommerce_settings_dynamic_gallery_navbar_end_after', array(&$this, 'dynamic_gallery_navbar_end_after') );
		add_action('woocommerce_settings_dynamic_gallery_lazyload_end_after', array(&$this, 'dynamic_gallery_lazyload_end_after') );
		
		// Add disable fields container
		add_action('woocommerce_settings_dynamic_gallery_dimensions_end_after', array(&$this, 'dynamic_gallery_dimensions_end_after') );
		add_action('woocommerce_settings_dynamic_gallery_on_of_end_after', array(&$this, 'dynamic_gallery_on_of_end_after') );
		add_action('woocommerce_settings_dynamic_gallery_thumb_option_end_after', array(&$this, 'dynamic_gallery_thumb_option_end_after') );

        // Add the settings fields to each tab.
        add_action('woocommerce_dynamic_gallery_settings', array(&$this, 'add_settings_fields'), 10);
		
		add_action('wp_ajax_woo_dynamic_gallery', array('WC_Gallery_Preview_Display','wc_dynamic_gallery_preview'));
		add_action('wp_ajax_nopriv_woo_dynamic_gallery', array('WC_Gallery_Preview_Display','wc_dynamic_gallery_preview'));

	}
	
	public function wc_dynamic_gallery_add_script(){
		global $woocommerce;
		$current_db_version = get_option( 'woocommerce_db_version', null );
		$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
		wp_enqueue_script('jquery');
		wp_enqueue_script('farbtastic');
		wp_enqueue_style('farbtastic');
		wp_enqueue_script( 'thickbox' );
		wp_enqueue_style( 'thickbox' );
		wp_register_script( 'dynamic-gallery-script', WOO_DYNAMIC_GALLERY_JS_URL.'/galleries.js' );
		wp_enqueue_script( 'dynamic-gallery-script' );
		
		wp_enqueue_style( 'ad-gallery-style', WOO_DYNAMIC_GALLERY_JS_URL . '/mygallery/jquery.ad-gallery.css' );
		wp_enqueue_script( 'ad-gallery-script', WOO_DYNAMIC_GALLERY_JS_URL . '/mygallery/jquery.ad-gallery.js', array(), false, true );
		
		wp_enqueue_style( 'a3_colorbox_style', WOO_DYNAMIC_GALLERY_JS_URL . '/colorbox/colorbox.css' );
		wp_enqueue_script( 'colorbox_script', WOO_DYNAMIC_GALLERY_JS_URL . '/colorbox/jquery.colorbox'.$suffix.'.js', array(), false, true );
			
		wp_enqueue_style( 'woocommerce_fancybox_styles', WOO_DYNAMIC_GALLERY_JS_URL . '/fancybox/fancybox.css' );
		wp_enqueue_script( 'fancybox', WOO_DYNAMIC_GALLERY_JS_URL . '/fancybox/fancybox'.$suffix.'.js', array(), false, true );
		
		//if ( version_compare( $current_db_version, '2.0', '<' ) && null !== $current_db_version ) {
			wp_enqueue_style( 'woocommerce_prettyPhoto_css', WOO_DYNAMIC_GALLERY_JS_URL . '/prettyPhoto/prettyPhoto.css');
			wp_enqueue_script( 'prettyPhoto', WOO_DYNAMIC_GALLERY_JS_URL . '/prettyPhoto/jquery.prettyPhoto'.$suffix.'.js', array(), false, true);
		//} else {
		//	wp_enqueue_style( 'woocommerce_prettyPhoto_css', $woocommerce->plugin_url() . '/assets/css/prettyPhoto.css' );
		//	wp_enqueue_script( 'prettyPhoto', $woocommerce->plugin_url() . '/assets/js/prettyPhoto/jquery.prettyPhoto' . $suffix . '.js' );
		//}
		wp_enqueue_style( 'a3rev-chosen-style', WOO_DYNAMIC_GALLERY_JS_URL . '/chosen/chosen.css' );
		wp_enqueue_script( 'chosen', WOO_DYNAMIC_GALLERY_JS_URL . '/chosen/chosen.jquery'.$suffix.'.js', array(), false, true );
		
		wp_enqueue_script( 'a3rev-chosen-script-init', WOO_DYNAMIC_GALLERY_JS_URL.'/init-chosen.js', array(), false, true );
	}

    /*
    * Admin Functions
    */

    /* ----------------------------------------------------------------------------------- */
    /* Admin Tabs */
    /* ----------------------------------------------------------------------------------- */
	public function on_add_tab() {
    	foreach ( $this->settings_tabs as $name => $label ) :
        	$class = 'nav-tab';
      		if ( $this->current_tab == $name )
            	$class .= ' nav-tab-active';
      		echo '<a href="' . admin_url('admin.php?page=woocommerce&tab=' . $name) . '" class="' . $class . '">' . $label . '</a>';
     	endforeach;
	}

    /**
     * settings_tab_action()
     *
     * Do this when viewing our custom settings tab(s). One function for all tabs.
    */
    public function settings_tab_action() {
    	global $woocommerce_settings;
		
		// Determine the current tab in effect.
        $current_tab = $this->get_tab_in_view(current_filter(), 'woocommerce_settings_tabs_');

        // Hook onto this from another function to keep things clean.
        // do_action( 'woocommerce_newsletter_settings' );

       	do_action('woocommerce_dynamic_gallery_settings');
		add_action('admin_footer', array(&$this, 'wc_dynamic_gallery_add_script'), 10);
	   ?>
		<style>
		.form-table { margin:0; }
		#wc_dgallery_panel_container { position:relative; margin-top:10px;}
		#wc_dgallery_panel_fields {width:60%; float:left;}
		#wc_dgallery_upgrade_area { position:relative; margin-left: 60%; padding-left:10px;}
		#wc_dynamic_gallery_extensions { border:2px solid #E6DB55;-webkit-border-radius:10px;-moz-border-radius:10px;-o-border-radius:10px; border-radius: 10px; color: #555555; margin: 0px; padding: 5px; text-shadow: 0 1px 0 rgba(255, 255, 255, 0.8); background:#FFFBCC; }
		.pro_feature_fields { margin-right: -12px; position: relative; z-index: 10; border:2px solid #E6DB55;-webkit-border-radius:10px 0 0 10px;-moz-border-radius:10px 0 0 10px;-o-border-radius:10px 0 0 10px; border-radius: 10px 0 0 10px; border-right: 2px solid #FFFFFF; }
		.pro_feature_fields h3, .pro_feature_fields p { margin-left:5px; }
		</style>
        <div id="wc_dgallery_panel_container">
            <div id="wc_dgallery_panel_fields" class="a3_subsubsub_section">
                <ul class="subsubsub">
                    <li><a href="#gallery-settings" class="current"><?php _e('Gallery', 'woo_dgallery'); ?></a> | </li>
                    <li><a href="#global-settings"><?php _e('Global Settings', 'woo_dgallery'); ?></a> | </li>
                    <li><a href="#caption-text"><?php _e('Caption text', 'woo_dgallery'); ?></a> | </li>
                    <li><a href="#nav-bar"><?php _e('Nav Bar', 'woo_dgallery'); ?></a> | </li>
                    <li><a href="#lazy-load-scroll"><?php _e('Lazy-load scroll', 'woo_dgallery'); ?></a> | </li>
                    <li><a href="#image-thumbnails"><?php _e('Image Thumbnails', 'woo_dgallery'); ?></a></li>
                </ul>
                <br class="clear">
                <div class="section" id="gallery-settings">
                <?php
                // Display settings for this tab (make sure to add the settings to the tab).
                woocommerce_admin_fields($woocommerce_settings[$current_tab]);
                ?>
                </div>
            </div>
            <div id="wc_dgallery_upgrade_area"><?php echo WC_Dynamic_Gallery_Functions::wc_dynamic_gallery_extension(); ?></div>
        </div>
        <div style="clear:both;"></div>
		<script>
				jQuery(window).load(function(){
					// Subsubsub tabs
					jQuery('div.a3_subsubsub_section ul.subsubsub li a:eq(0)').addClass('current');
					jQuery('div.a3_subsubsub_section .section:gt(0)').hide();

					jQuery('div.a3_subsubsub_section ul.subsubsub li a').click(function(){
						var $clicked = jQuery(this);
						var $section = $clicked.closest('.a3_subsubsub_section');
						var $target  = $clicked.attr('href');

						$section.find('a').removeClass('current');

						if ( $section.find('.section:visible').size() > 0 ) {
							$section.find('.section:visible').fadeOut( 100, function() {
								$section.find( $target ).fadeIn('fast');
							});
						} else {
							$section.find( $target ).fadeIn('fast');
						}

						$clicked.addClass('current');
						jQuery('#last_tab').val( $target );

						return false;
					});

					<?php if (isset($_GET['subtab']) && $_GET['subtab']) echo 'jQuery("div.a3_subsubsub_section ul.subsubsub li a[href=#'.$_GET['subtab'].']").click();'; ?>
				});
		(function($){
			$(function(){
				$("#<?php echo WOO_DYNAMIC_GALLERY_PREFIX; ?>show_variation").attr('disabled', 'disabled');
				$("#<?php echo WOO_DYNAMIC_GALLERY_PREFIX; ?>reset_variation_activate").attr('disabled', 'disabled');
				$("#<?php echo WOO_DYNAMIC_GALLERY_PREFIX; ?>product_gallery_speed").attr('disabled', 'disabled');
				$("#<?php echo WOO_DYNAMIC_GALLERY_PREFIX; ?>stop_scroll_1image").attr('disabled', 'disabled');
				$("#<?php echo WOO_DYNAMIC_GALLERY_PREFIX; ?>bg_image_wrapper").attr('disabled', 'disabled');
				$("#<?php echo WOO_DYNAMIC_GALLERY_PREFIX; ?>border_image_wrapper_color").attr('disabled', 'disabled');
				$("#<?php echo WOO_DYNAMIC_GALLERY_PREFIX; ?>product_gallery_text_color").attr('disabled', 'disabled');
				$("#<?php echo WOO_DYNAMIC_GALLERY_PREFIX; ?>product_gallery_bg_des").attr('disabled', 'disabled');
				$("#<?php echo WOO_DYNAMIC_GALLERY_PREFIX; ?>product_gallery_nav").attr('disabled', 'disabled');
				$("#<?php echo WOO_DYNAMIC_GALLERY_PREFIX; ?>bg_nav_color").attr('disabled', 'disabled');
				$("#<?php echo WOO_DYNAMIC_GALLERY_PREFIX; ?>bg_nav_text_color").attr('disabled', 'disabled');
				$("#<?php echo WOO_DYNAMIC_GALLERY_PREFIX; ?>navbar_height").attr('disabled', 'disabled');
				$("#<?php echo WOO_DYNAMIC_GALLERY_PREFIX; ?>lazy_load_scroll").attr('disabled', 'disabled');
				$("#<?php echo WOO_DYNAMIC_GALLERY_PREFIX; ?>transition_scroll_bar").attr('disabled', 'disabled');
				$("#<?php echo WOO_DYNAMIC_GALLERY_PREFIX; ?>enable_gallery_thumb").attr('disabled', 'disabled');
				$("#<?php echo WOO_DYNAMIC_GALLERY_PREFIX; ?>hide_thumb_1image").attr('disabled', 'disabled');
			});
		})(jQuery);
		</script>
		<?php
	}
	
	public function dynamic_gallery_dimensions_end_after() {
		echo '<div class="pro_feature_fields">';
	}
	
	public function dynamic_gallery_settings_end_after() {
		echo '</div></div><div class="section" id="global-settings">';
	}
	
	public function dynamic_gallery_on_of_end_after() {
		echo '<div class="pro_feature_fields">';
	}
	
	public function dynamic_gallery_reset_activation_end_after() {
		echo '</div>';
	}
	
	public function dynamic_gallery_global_settings_end_after() {
		echo '</div><div class="section" id="caption-text"><div class="pro_feature_fields">';
	}
		
	public function dynamic_gallery_caption_end_after() {
		echo '</div></div><div class="section" id="nav-bar"><div class="pro_feature_fields">';
	}
	
	public function dynamic_gallery_navbar_end_after() {
		echo '</div></div><div class="section" id="lazy-load-scroll"><div class="pro_feature_fields">';
	}
	
	public function dynamic_gallery_lazyload_end_after() {
		echo '</div></div><div class="section" id="image-thumbnails"><div class="pro_feature_fields">';
	}
	
	public function dynamic_gallery_thumb_option_end_after() {
		echo '</div>';
	}

	/**
     * add_settings_fields()
     *
     * Add settings fields for each tab.
    */
    public function add_settings_fields() {
    	global $woocommerce_settings;

        // Load the prepared form fields.
        $this->init_form_fields();

        if ( is_array($this->fields) ) :
        	foreach ( $this->fields as $k => $v ) :
                $woocommerce_settings[$k] = $v;
            endforeach;
        endif;
	}

    /**
    * get_tab_in_view()
    *
    * Get the tab current in view/processing.
    */
    public function get_tab_in_view($current_filter, $filter_base) {
    	return str_replace($filter_base, '', $current_filter);
    }

    /**
     * init_form_fields()
     *
     * Prepare form fields to be used in the various tabs.
     */
	public function init_form_fields() {
		global $wpdb;
		$woo_dynamic_gallery = wp_create_nonce("woo_dynamic_gallery");
		
		$my_fonts = WC_Dynamic_Gallery_Functions::get_font();
				
  		// Define settings			
     	$this->fields['dynamic_gallery'] = apply_filters('woocommerce_dynamic_gallery_settings_fields', array(
			array(	'name' => __( 'Preview', 'woo_dgallery' ), 'type' => 'title', 'desc' => '<a href="'. admin_url( 'admin-ajax.php', 'relative') .'?security='.$woo_dynamic_gallery.'" class="preview_gallery">'.__( 'Click here to preview gallery', 'woo_dgallery' ).'</a>. ', 'id' => 'preview_gallery' ),
			
			array('type' => 'sectionend', 'id' => 'dynamic_gallery_preview_end'),
			
			array(	'name' => __('Gallery Dimensions', 'woo_dgallery'), 'type' => 'title'),
			array(  
				'name' => __( 'Gallery width', 'woo_dgallery' ),
				'desc' 		=> '',
				'id' 		=> WOO_DYNAMIC_GALLERY_PREFIX.'product_gallery_width',
				'type' 		=> 'wc_dynamic_gallery_width',
				'css' 		=> 'width:7em; float:left; margin-right:10px;',
				'std' 		=> '320',
				'default'	=> '320'
			),
			array(  
				'name' => __( 'Gallery height', 'woo_dgallery' ),
				'desc' 		=> 'px',
				'id' 		=> WOO_DYNAMIC_GALLERY_PREFIX.'product_gallery_height',
				'type' 		=> 'text',
				'css' 		=> 'width:7em;',
				'std' 		=> '215',
				'default'	=> '215'
			),
			array('type' => 'sectionend', 'id' => 'dynamic_gallery_dimensions_end'),
			
			array(	'name' => __('Gallery Special Effects', 'woo_dgallery'), 'type' => 'title'),
			array(  
				'name' => __( 'Auto start', 'woo_dgallery' ),
				'desc' 		=> '',
				'id' 		=> WOO_DYNAMIC_GALLERY_PREFIX.'product_gallery_auto_start',
				'css' 		=> 'width:120px;',
				'std' 		=> '1',
				'default'	=> 'true',
				'class'		=> 'chzn-select',
				'type' 		=> 'select',
				'options' => array( 
					'false'  			=> __( 'False', 'woo_dgallery' ),
					'true'		=> __( 'True', 'woo_dgallery' ),
				),
				'desc_tip'	=>  false,
			),
			array(  
				'name' => __( 'Time between transitions', 'woo_dgallery' ),
				'desc' 		=> 'seconds',
				'id' 		=> WOO_DYNAMIC_GALLERY_PREFIX.'product_gallery_speed',
				'type' 		=> 'text',
				'css' 		=> 'width:7em;',
				'std' 		=> '5',
				'default'	=> '5'
			),
			array(  
				'name' => __( 'Slide transition effect', 'woo_dgallery' ),
				'desc' 		=> '',
				'id' 		=> WOO_DYNAMIC_GALLERY_PREFIX.'product_gallery_effect',
				'css' 		=> 'width:120px;',
				'std' 		=> 'slide-hori',
				'default'	=> 'slide-hori',
				'class'		=> 'chzn-select',
				'type' 		=> 'select',
				'options' => array( 
					'none'  			=> __( 'None', 'woo_dgallery' ),
					'fade'		=> __( 'Fade', 'woo_dgallery' ),
					'slide-hori'		=> __( 'Slide Hori', 'woo_dgallery' ),
					'slide-vert'		=> __( 'Slide Vert', 'woo_dgallery' ),
					'resize'		=> __( 'Resize', 'woo_dgallery' ),
				),
				'desc_tip'	=>  false,
			),
			
			array(  
				'name' => __( 'Transition effect speed', 'woo_dgallery' ),
				'desc' 		=> 'seconds',
				'id' 		=> WOO_DYNAMIC_GALLERY_PREFIX.'product_gallery_animation_speed',
				'css' 		=> 'width:120px;',
				'std' 		=> '2',
				'default'	=> '2',
				'class'		=> 'chzn-select',
				'type' 		=> 'select',
				'options' => array( 
					'1'  			=> __( '1', 'woo_dgallery' ),
					'2'		=> __( '2', 'woo_dgallery' ),
					'3'		=> __( '3', 'woo_dgallery' ),
					'4'		=> __( '4', 'woo_dgallery' ),
					'5'		=> __( '5', 'woo_dgallery' ),
					'6'		=> __( '6', 'woo_dgallery' ),
					'7'		=> __( '7', 'woo_dgallery' ),
					'8'		=> __( '8', 'woo_dgallery' ),
					'9'		=> __( '9', 'woo_dgallery' ),
					'10'		=> __( '10', 'woo_dgallery' ),
				),
				'desc_tip'	=>  false,
			),
			
			array(  
				'name' 		=> __( 'Single Image Transition', 'woo_dgallery' ),
				'desc' 		=> __( 'Check to auto deactivate image transition effect when only 1 image is loaded to gallery.', 'woo_dgallery' ),
				'id' 		=> WOO_DYNAMIC_GALLERY_PREFIX.'stop_scroll_1image',
				'std' 		=> '0',
				'default'	=> 'no',
				'type' 		=> 'checkbox',
			),
			array('type' => 'sectionend'),
			
			array(	'name' => __('Gallery Style', 'woo_dgallery'), 'type' => 'title'),
			array(  
				'name' => __( 'Image background colour', 'woo_dgallery' ),
				'desc' 		=> __( 'Gallery image background colour. Default <code>#FFFFFF</code>.', 'woo_dgallery' ),
				'id' 		=> WOO_DYNAMIC_GALLERY_PREFIX.'bg_image_wrapper',
				'type' 		=> 'color',
				'css' 		=> 'width:7em;text-transform: uppercase;',
				'std' 		=> '#FFFFFF',
				'default'	=> '#FFFFFF'
			),
			array(  
				'name' => __( 'Border colour', 'woo_dgallery' ),
				'desc' 		=> __( 'Gallery border colour. Default <code>#CCCCCC</code>.', 'woo_dgallery' ),
				'id' 		=> WOO_DYNAMIC_GALLERY_PREFIX.'border_image_wrapper_color',
				'type' 		=> 'color',
				'css' 		=> 'width:7em;text-transform: uppercase;',
				'std' 		=> '#CCCCCC',
				'default'	=> '#CCCCCC'
			),
			
			array('type' => 'sectionend', 'id' => 'dynamic_gallery_settings_end'),
			
			array(	'name' => __( 'Image Zoom Function', 'woo_dgallery' ), 'type' => 'title'),
			array(  
				'name' => __( 'Gallery popup', 'woo_dgallery' ),
				'desc' 		=> '',
				'id' 		=> WOO_DYNAMIC_GALLERY_PREFIX.'popup_gallery',
				'css' 		=> 'width:120px;',
				'std' 		=> 'prettyphoto',
				'default'	=> 'prettyphoto',
				'class'		=> 'chzn-select',
				'type' 		=> 'select',
				'options' => array( 
					'prettyphoto'	=> __( 'PrettyPhoto', 'woo_dgallery' ),
					'fb'  			=> __( 'Fancybox', 'woo_dgallery' ),
					'colorbox'		=> __( 'ColorBox', 'woo_dgallery' ),
					'deactivate'	=> __( 'Deactivate', 'woo_dgallery' ),
				),
				'desc_tip'	=>  false,
			),
			array('type' => 'sectionend', 'id' => 'dynamic_gallery_popup_end'),
			
      		array(
            	'name' => __('Gallery On / Off', 'woo_dgallery'),
                'type' => 'title',
                'desc' => '',
          		'id' => 'dynamic_gallery_settings_start'
           	),
			array(  
				'name' 		=> __( 'Gallery Activation Default', 'woo_dgallery' ),
				'desc' 		=> __( 'Checked = Gallery Activated on Product Pages. Unchecked = Deactivated. Note: Changing this setting will not over-ride any custom Gallery activation settings made on single product pages.', 'woo_dgallery' ),
				'id' 		=> WOO_DYNAMIC_GALLERY_PREFIX.'activate',
				'std' 		=> '1',
				'default'	=> 'yes',
				'type' 		=> 'checkbox',
			),
			array(  
				'name' 		=> __( 'Reset Activation to default', 'woo_dgallery' ),
				'desc' 		=> __( "Checked this box and 'Save Changes' to reset ALL products to the default 'Gallery Activation' status you set above including ALL individual custom Product Page Gallery activation settings.", 'woo_dgallery' ),
				'id' 		=> WOO_DYNAMIC_GALLERY_PREFIX.'reset_galleries_activate',
				'std' 		=> '0',
				'default'	=> 'no',
				'type' 		=> 'checkbox',
			),
			array('type' => 'sectionend', 'id' => 'dynamic_gallery_on_of_end'),
			
			array(	'name' => __( 'Image Variation Feature', 'woo_dgallery' ), 'type' => 'title'),
			array(  
				'name' 		=> __( 'Variations Activation Default', 'woo_dgallery' ),
				'desc' 		=> __( 'Checked = Variation Images Activated on Product Pages. Unchecked = Deactivated. Note: Changing this setting will not over-ride any custom Variation Images activation settings made on single product pages.', 'woo_dgallery' ),
				'id' 		=> WOO_DYNAMIC_GALLERY_PREFIX.'show_variation',
				'std' 		=> '0',
				'default'	=> 'no',
				'type' 		=> 'checkbox',
				'checkboxgroup'		=> 'start'
			),
			array(  
				'name' 		=> __( 'Reset Activation to default', 'woo_dgallery' ),
				'desc' 		=> __( "Checked this box and 'Save Changes' to reset ALL products to the default 'Variations Activation' status you set above. NOTE:  ALL individual custom Product Page Variation Images Activation settings will be changed to the default.", 'woo_dgallery' ),
				'id' 		=> WOO_DYNAMIC_GALLERY_PREFIX.'reset_variation_activate',
				'std' 		=> '0',
				'default'	=> 'no',
				'type' 		=> 'checkbox',
			),
			array('type' => 'sectionend', 'id' => 'dynamic_gallery_reset_activation_end'),
			
			array(	'name' => __( 'House Keeping', 'woo_dgallery' ).' :', 'type' => 'title'),
			array(  
				'name' 		=> __( 'Clean up on Deletion', 'woo_dgallery' ),
				'desc' 		=> __( 'Check this box and if you ever delete this plugin it will completely remove all of its code and tables it has created, leaving no trace it was ever here. It will not delete your product images! <strong>CAUTION</strong> This setting is <strong>not recommended</strong> if you are upgrading to the Pro Version as you will want to keep any gallery settings you have already made.', 'woo_dgallery' ),
				'id' 		=> WOO_DYNAMIC_GALLERY_PREFIX.'clean_on_deletion',
				'std' 		=> '0',
				'default'	=> 'no',
				'type' 		=> 'checkbox',
			),
			array('type' => 'sectionend', 'id' => 'dynamic_gallery_global_settings_end'),
			
			
			array(
            	'name' => __('Caption text', 'woothemes'),
                'type' => 'title',
                'desc' => '',
          		'id' => 'dynamic_gallery_caption_start'
           	),
			array(  
				'name' => __( 'Font', 'woo_dgallery' ),
				'desc' 		=> '',
				'id' 		=> WOO_DYNAMIC_GALLERY_PREFIX.'caption_font',
				'css' 		=> 'width:120px;',
				'std' 		=> 'Arial, sans-serif',
				'default'	=> 'Arial, sans-serif',
				'class'		=> 'chzn-select',
				'type' 		=> 'select',
				'options' 	=> $my_fonts,
				'desc_tip'	=>  false,
			),
			array(  
				'name' => __( 'Font size', 'woo_dgallery' ),
				'desc' 		=> '',
				'id' 		=> WOO_DYNAMIC_GALLERY_PREFIX.'caption_font_size',
				'css' 		=> 'width:120px;',
				'std' 		=> '12px',
				'default'	=> '12px',
				'class'		=> 'chzn-select',
				'type' 		=> 'select',
				'options' 	=> WC_Dynamic_Gallery_Functions::get_font_sizes(),
			'desc_tip'	=>  false,
			),
			array(  
				'name' => __( 'Font style', 'woo_dgallery' ),
				'desc' 		=> '',
				'id' 		=> WOO_DYNAMIC_GALLERY_PREFIX.'caption_font_style',
				'css' 		=> 'width:120px;',
				'std' 		=> 'normal',
				'default'	=> 'normal',
				'class'		=> 'chzn-select',
				'type' 		=> 'select',
				'options' => array( 
					'normal'  				=> __( 'Normal', 'woo_dgallery' ),
					'italic'  			=> __( 'Italic', 'woo_dgallery' ),
					'bold'  			=> __( 'Bold', 'woo_dgallery' ),
					'bold_italic'  			=> __( 'Bold/Italic', 'woo_dgallery' ),
				),
			'desc_tip'	=>  false,
			),
			array(  
				'name' => __( 'Colour', 'woo_dgallery' ),
				'desc' 		=> __( 'Caption text color. Default <code>#FFFFFF</code>.', 'woo_dgallery' ),
				'id' 		=> WOO_DYNAMIC_GALLERY_PREFIX.'product_gallery_text_color',
				'type' 		=> 'color',
				'css' 		=> 'width:7em;text-transform: uppercase;',
				'std' 		=> '#FFFFFF',
				'default'	=> '#FFFFFF'
			),
			array(  
				'name' => __( 'Background', 'woo_dgallery' ),
				'desc' 		=> __( 'Caption text background colour. Default <code>#000000</code>.', 'woo_dgallery' ),
				'id' 		=> WOO_DYNAMIC_GALLERY_PREFIX.'product_gallery_bg_des',
				'type' 		=> 'color',
				'css' 		=> 'width:7em;text-transform: uppercase;',
				'std' 		=> '#000000',
				'default'	=> '#000000'
			),
			array('type' => 'sectionend', 'id' => 'dynamic_gallery_caption_end'),
			
			array(
            	'name' => __('Nav Bar', 'woothemes'),
                'type' => 'title',
                'desc' => '',
          		'id' => 'dynamic_gallery_navbar_start'
           	),
			array(  
				'name' 		=> __( 'Control', 'woo_dgallery' ),
				'desc' 		=> __( 'Enable Nav bar Control', 'woo_dgallery' ),
				'id' 		=> WOO_DYNAMIC_GALLERY_PREFIX.'product_gallery_nav',
				'std' 		=> '1',
				'default'	=> 'yes',
				'type' 		=> 'checkbox',
				'checkboxgroup'		=> 'start'
			),
			array(  
				'name' => __( 'Font', 'woo_dgallery' ),
				'desc' 		=> '',
				'id' 		=> WOO_DYNAMIC_GALLERY_PREFIX.'navbar_font',
				'css' 		=> 'width:120px;',
				'std' 		=> 'Arial, sans-serif',
				'default'	=> 'Arial, sans-serif',
				'class'		=> 'chzn-select',
				'type' 		=> 'select',
				'options' 	=> $my_fonts,
				'desc_tip'	=>  false,
			),
			array(  
				'name' => __( 'Font size', 'woo_dgallery' ),
				'desc' 		=> '',
				'id' 		=> WOO_DYNAMIC_GALLERY_PREFIX.'navbar_font_size',
				'css' 		=> 'width:120px;',
				'std' 		=> '13px',
				'default'	=> '13px',
				'class'		=> 'chzn-select',
				'type' 		=> 'select',
				'options' 	=> WC_Dynamic_Gallery_Functions::get_font_sizes(),
			'desc_tip'	=>  false,
			),
			array(  
				'name' => __( 'Font style', 'woo_dgallery' ),
				'desc' 		=> '',
				'id' 		=> WOO_DYNAMIC_GALLERY_PREFIX.'navbar_font_style',
				'css' 		=> 'width:120px;',
				'std' 		=> 'bold',
				'default'	=> 'bold',
				'class'		=> 'chzn-select',
				'type' 		=> 'select',
				'options' => array( 
					'normal'  				=> __( 'Normal', 'woo_dgallery' ),
					'italic'  			=> __( 'Italic', 'woo_dgallery' ),
					'bold'  			=> __( 'Bold', 'woo_dgallery' ),
					'bold_italic'  			=> __( 'Bold/Italic', 'woo_dgallery' ),
				),
			'desc_tip'	=>  false,
			),
			array(  
				'name' => __( 'Colour', 'woo_dgallery' ),
				'desc' 		=> __( 'Nav bar background colour. Default <code>#FFFFFF</code>.', 'woo_dgallery' ),
				'id' 		=> WOO_DYNAMIC_GALLERY_PREFIX.'bg_nav_color',
				'type' 		=> 'color',
				'css' 		=> 'width:7em;text-transform: uppercase;',
				'std' 		=> '#FFFFFF',
				'default'	=> '#FFFFFF'
			),
			array(  
				'name' => __( 'Text', 'woo_dgallery' ),
				'desc' 		=> __( 'Nav bar text color. Default <code>#000000</code>.', 'woo_dgallery' ),
				'id' 		=> WOO_DYNAMIC_GALLERY_PREFIX.'bg_nav_text_color',
				'type' 		=> 'color',
				'css' 		=> 'width:7em;text-transform: uppercase;',
				'std' 		=> '#000000',
				'default'	=> '#000000'
			),
			array(  
				'name' => __( 'Container height', 'woo_dgallery' ),
				'desc' 		=> 'px',
				'id' 		=> WOO_DYNAMIC_GALLERY_PREFIX.'navbar_height',
				'type' 		=> 'text',
				'css' 		=> 'width:7em;',
				'std' 		=> '25',
				'default'	=> '25'
			),
			array('type' => 'sectionend', 'id' => 'dynamic_gallery_navbar_end'),
			
			array(
            	'name' => __('Lazy-load scroll', 'woothemes'),
                'type' => 'title',
                'desc' => '',
          		'id' => 'dynamic_gallery_lazyload_start'
           	),
			array(  
				'name' 		=> __( 'Control', 'woo_dgallery' ),
				'desc' 		=> __( 'Enable lazy-load scroll', 'woo_dgallery' ),
				'id' 		=> WOO_DYNAMIC_GALLERY_PREFIX.'lazy_load_scroll',
				'std' 		=> '1',
				'default'	=> 'yes',
				'type' 		=> 'checkbox',
				'checkboxgroup'		=> 'start'
			),
			array(  
				'name' => __( 'Colour', 'woo_dgallery' ),
				'desc' 		=> __( 'Scroll bar colour. Default <code>#000000</code>.', 'woo_dgallery' ),
				'id' 		=> WOO_DYNAMIC_GALLERY_PREFIX.'transition_scroll_bar',
				'type' 		=> 'color',
				'css' 		=> 'width:7em;text-transform: uppercase;',
				'std' 		=> '#000000',
				'default'	=> '#000000'
			),
            array('type' => 'sectionend', 'id' => 'dynamic_gallery_lazyload_end'),
			
			array(
            	'name' => __('Image Thumbnails', 'woothemes'),
                'type' => 'title',
                'desc' => '',
          		'id' => 'dynamic_gallery_thumb_start'
           	),
			array(  
				'name' 		=> __( 'Show thumbnails', 'woo_dgallery' ),
				'desc' 		=> __( 'Enable thumbnail gallery', 'woo_dgallery' ),
				'id' 		=> WOO_DYNAMIC_GALLERY_PREFIX.'enable_gallery_thumb',
				'std' 		=> '1',
				'default'	=> 'yes',
				'type' 		=> 'checkbox',
				'checkboxgroup'		=> 'start'
			),
			array(  
				'name' 		=> __( 'Single Image Thumbnail', 'woo_dgallery' ),
				'desc' 		=> __( "Check to hide thumbnail when only 1 image is loaded to gallery.", 'woo_dgallery' ),
				'id' 		=> WOO_DYNAMIC_GALLERY_PREFIX.'hide_thumb_1image',
				'std' 		=> '1',
				'default'	=> 'yes',
				'type' 		=> 'checkbox',
			),
			array('type' => 'sectionend', 'id' => 'dynamic_gallery_thumb_option_end'),
			
			array(	'name' => '', 'type' => 'title'),
			array(  
				'name' => __( 'Thumbnail width', 'woo_dgallery' ),
				'desc' 		=> 'px. '.__("Setting 0px will show at default 105px. Hiding thumbnails is a Pro Version feature.", 'woo_dgallery'),
				'id' 		=> WOO_DYNAMIC_GALLERY_PREFIX.'thumb_width',
				'type' 		=> 'text',
				'css' 		=> 'width:7em;',
				'std' 		=> '105',
				'default'	=> '105'
			),
			array(  
				'name' => __( 'Thumbnail height', 'woo_dgallery' ),
				'desc' 		=> 'px. '.__("Setting 0px will show at default 75px. Hiding thumbnails is a Pro Version feature.", 'woo_dgallery'),
				'id' 		=> WOO_DYNAMIC_GALLERY_PREFIX.'thumb_height',
				'type' 		=> 'text',
				'css' 		=> 'width:7em;',
				'std' 		=> '75',
				'default'	=> '75'
			),
			array(  
				'name' => __( 'Thumbnail spacing', 'woo_dgallery' ),
				'desc' 		=> 'px',
				'id' 		=> WOO_DYNAMIC_GALLERY_PREFIX.'thumb_spacing',
				'type' 		=> 'text',
				'css' 		=> 'width:7em;',
				'std' 		=> '2',
				'default'	=> '2'
			),
			array('type' => 'sectionend', 'id' => 'dynamic_gallery_thumb_end'),
			
        ));
	}

    /**
     * save_settings()
     *
     * Save settings in a single field in the database for each tab's fields (one field per tab).
     */
     public function save_settings() {
     	global $woocommerce_settings;

        // Make sure our settings fields are recognised.
        $this->add_settings_fields();

        $current_tab = $this->get_tab_in_view(current_filter(), 'woocommerce_update_options_');

		woocommerce_update_options($woocommerce_settings[$current_tab]);

		// save custom type value
		update_option( WOO_DYNAMIC_GALLERY_PREFIX.'product_gallery_width', (int) $_REQUEST[WOO_DYNAMIC_GALLERY_PREFIX.'product_gallery_width']);
		WC_Dynamic_Gallery::wc_dynamic_gallery_set_setting(true, true);
		update_option( WOO_DYNAMIC_GALLERY_PREFIX.'reset_galleries_activate', 'no' );
		if ( isset($_POST[WOO_DYNAMIC_GALLERY_PREFIX.'reset_galleries_activate']) && $_POST[WOO_DYNAMIC_GALLERY_PREFIX.'reset_galleries_activate'] == '1') {
			WC_Dynamic_Gallery_Functions::reset_products_galleries_activate();
		}
		update_option( WOO_DYNAMIC_GALLERY_PREFIX.'reset_variation_activate', 'no' );
		
		if ( !get_option( WOO_DYNAMIC_GALLERY_PREFIX.'clean_on_deletion' ) || get_option( WOO_DYNAMIC_GALLERY_PREFIX.'clean_on_deletion' ) == 'no' ) {
			$uninstallable_plugins = (array) get_option('uninstall_plugins');
			unset($uninstallable_plugins[WOO_DYNAMIC_GALLERY_NAME]);
			update_option('uninstall_plugins', $uninstallable_plugins);
		}
		
	}

    /** Helper functions ***************************************************** */
         
    /**
     * Gets a setting
     */
    public function setting($key) {
		return get_option($key);
	}
	
	public function wc_dynamic_gallery_width($value) {
		global $woocommerce;
		// Custom attribute handling
		$custom_attributes = array();

		if ( ! empty( $value['custom_attributes'] ) && is_array( $value['custom_attributes'] ) )
			foreach ( $value['custom_attributes'] as $attribute => $attribute_value )
				$custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $attribute_value ) . '"';

		// Description handling
		if ( $value['desc_tip'] === true ) {
			$description = '';
			$tip = $value['desc'];
		} elseif ( ! empty( $value['desc_tip'] ) ) {
			$description = $value['desc'];
			$tip = $value['desc_tip'];
		} elseif ( ! empty( $value['desc'] ) ) {
			$description = $value['desc'];
			$tip = '';
		} else {
			$description = $tip = '';
		}
		
		if ( $description && in_array( $value['type'], array( 'textarea', 'radio' ) ) ) {
			$description = '<p style="margin-top:0">' . wp_kses_post( $description ) . '</p>';
		} elseif ( $description ) {
			$description = '<span class="description">' . wp_kses_post( $description ) . '</span>';
		}

		if ( $tip && in_array( $value['type'], array( 'checkbox' ) ) ) {

			$tip = '<p class="description">' . $tip . '</p>';

		} elseif ( $tip ) {

			$tip = '<img class="help_tip" data-tip="' . esc_attr( $tip ) . '" src="' . $woocommerce->plugin_url() . '/assets/images/help.png" height="16" width="16" />';

		}
		
		$option_value = get_option($value['id']);
		if (!$option_value && isset($value['default']) ) $option_value = $value['default'];
		elseif (!$option_value && isset($value['std']) ) $option_value = $value['std'];
		elseif (!$option_value) $option_value = 320;
		
	?>
    	<tr valign="top">
			<th scope="row" class="titledesc">
				<label for="<?php echo esc_attr( $value['id'] ); ?>"><?php echo esc_html( $value['name'] ); ?></label>
				<?php echo $tip; ?>
			</th>
			<td class="forminp forminp-<?php echo sanitize_title( $value['type'] ) ?>">
					<input
                    		name="<?php echo esc_attr( $value['id'] ); ?>"
                    		id="<?php echo esc_attr( $value['id'] ); ?>"
                    		type="text"
                    		style="<?php echo esc_attr( $value['css'] ); ?>"
                    		value="<?php echo esc_attr( $option_value ); ?>"
                    		class="<?php echo esc_attr( $value['class'] ); ?>"
                    		<?php echo implode( ' ', $custom_attributes ); ?>
                    		/> 
					<select name="<?php echo WOO_DYNAMIC_GALLERY_PREFIX; ?>width_type" id="<?php echo WOO_DYNAMIC_GALLERY_PREFIX; ?>width_type" style="width:120px; margin: 0px; height: 21px;" class="chzn-select">
          <option value="%">%</option>
          <option value="px" selected="selected">px</option>
        </select> <?php echo $description; ?>
			</td>
		</tr>
    <?php
	}
}
?>