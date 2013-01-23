<?php
/**
 * WooCommerce Dynamic Gallery Class
 *
 * Class Function into woocommerce plugin
 *
 * Table Of Contents
 *
 * wc_dynamic_gallery_set_setting()
 * __construct()
 * on_add_tab()
 * settings_tab_action()
 * add_settings_fields()
 * get_tab_in_view()
 * init_form_fields()
 * save_settings()
 * setting()
 * wc_dynamic_gallery_extension()
 * wc_dynamic_gallery_upgrade_area_start()
 * wc_dynamic_gallery_upgrade_area_end()
 * plugin_extra_links()
 */
class WC_Dynamic_Gallery {
	public function wc_dynamic_gallery_set_setting($reset=false, $free_version=false){
		global $wpdb;
		if( ( trim(get_option('product_gallery_width')) == '' || $reset) && !$free_version){
			update_option('product_gallery_width','320');
		}
		if( (trim(get_option('product_gallery_height')) == '' || $reset) && !$free_version ){
			update_option('product_gallery_height',215);
		}
		if( (trim(get_option('thumb_width')) == '' || $reset) && !$free_version){
			update_option('thumb_width',105);
		}
		if( (trim(get_option('thumb_height')) == '' || $reset) && !$free_version){
			update_option('thumb_height',75);
		}
		if( (trim(get_option('thumb_spacing')) == '' || $reset) && !$free_version){
			update_option('thumb_spacing',2);
		}
		if( trim(get_option('product_gallery_speed')) == '' || $reset ){
			update_option('product_gallery_speed',4);
		}
		if( trim(get_option('product_gallery_effect')) == '' || $reset ){
			update_option('product_gallery_effect','slide-vert');
		}
		if( trim(get_option('product_gallery_auto_start')) == '' || $reset ){
			update_option('product_gallery_auto_start','true');
		}
		if( trim(get_option('product_gallery_animation_speed')) == '' || $reset ){
			update_option('product_gallery_animation_speed',2);
		}
		if( trim(get_option('bg_image_wrapper')) == '' || $reset ){
			update_option('bg_image_wrapper','#FFFFFF');
		}
		if( trim(get_option('border_image_wrapper_color')) == '' || $reset ){
			update_option('border_image_wrapper_color','#CCCCCC');
		}
		if( trim(get_option('product_gallery_text_color')) == '' || $reset ){
			update_option('product_gallery_text_color','#FFFFFF');
		}
		if( trim(get_option('product_gallery_bg_des')) == '' || $reset ){
			update_option('product_gallery_bg_des','#886bab');
		}
		if( trim(get_option('product_gallery_nav')) == '' || $reset ){
			update_option('product_gallery_nav','yes');
		}
		if( trim(get_option('bg_nav_color')) == '' || $reset ){
			update_option('bg_nav_color','#FFFFFF');
		}
		if( trim(get_option('bg_nav_text_color')) == '' || $reset ){
			update_option('bg_nav_text_color','#886bab');
		}
		if( trim(get_option('popup_gallery')) == '' || $reset ){
			update_option('popup_gallery','fb');
		}
		if( trim(get_option('enable_gallery_thumb')) == '' || $reset ){
			update_option('enable_gallery_thumb','yes');
		}
		if( trim(get_option('transition_scroll_bar')) == '' || $reset ){
			update_option('transition_scroll_bar','#886bab');
		}
		if( trim(get_option('lazy_load_scroll')) == '' || $reset ){
			update_option('lazy_load_scroll','yes');
		}
		
		if( trim(get_option('caption_font')) == '' || $reset ){
			update_option('caption_font','Arial, sans-serif');
		}
		if( trim(get_option('caption_font_size')) == '' || $reset ){
			update_option('caption_font_size','12px');
		}
		if( trim(get_option('caption_font_style')) == '' || $reset ){
			update_option('caption_font_style','normal');
		}
		
		if( trim(get_option('navbar_font')) == '' || $reset ){
			update_option('navbar_font','Arial, sans-serif');
		}
		if( trim(get_option('navbar_font_size')) == '' || $reset ){
			update_option('navbar_font_size','12px');
		}
		if( trim(get_option('navbar_font_style')) == '' || $reset ){
			update_option('navbar_font_style','bold');
		}
		if( trim(get_option('navbar_height')) == '' || $reset ){
			update_option('navbar_height','25');
		}
		
	}
	
	public function __construct() {
   		$this->current_tab = ( isset($_GET['tab']) ) ? $_GET['tab'] : 'general';
    	$this->settings_tabs = array(
        	'dynamic_gallery' => __('Dynamic Gallery', 'woothemes')
        );
        add_action('woocommerce_settings_tabs', array(&$this, 'on_add_tab'), 10);

        // Run these actions when generating the settings tabs.
        foreach ( $this->settings_tabs as $name => $label ) {
        	add_action('woocommerce_settings_tabs_' . $name, array(&$this, 'settings_tab_action'), 10);
          	add_action('woocommerce_update_options_' . $name, array(&$this, 'save_settings'), 10);
        }
		
		add_action( 'woocommerce_settings_dynamic_gallery_upgrade_start', array(&$this, 'wc_dynamic_gallery_upgrade_area_start') );
		add_action( 'woocommerce_settings_dynamic_gallery_upgrade_end', array(&$this, 'wc_dynamic_gallery_upgrade_area_end') );

        // Add the settings fields to each tab.
        add_action('woocommerce_dynamic_gallery_settings', array(&$this, 'add_settings_fields'), 10);
		
		add_action('wp_ajax_woo_dynamic_gallery', array('WC_Gallery_Preview_Display','wc_dynamic_gallery_preview'));
		add_action('wp_ajax_nopriv_woo_dynamic_gallery', array('WC_Gallery_Preview_Display','wc_dynamic_gallery_preview'));

	}
	
	function wc_dynamic_gallery_add_script(){
		wp_enqueue_script('jquery');
		wp_enqueue_script('farbtastic');
		wp_enqueue_style('farbtastic');
		wp_enqueue_script( 'thickbox' );
		wp_enqueue_style( 'thickbox' );
		wp_register_script( 'dynamic-gallery-script', WOO_DYNAMIC_GALLERY_JS_URL.'/galleries.js' );
		wp_enqueue_script( 'dynamic-gallery-script' );
		
		wp_enqueue_style( 'ad-gallery-style', WOO_DYNAMIC_GALLERY_JS_URL . '/mygallery/jquery.ad-gallery.css' );
		wp_enqueue_script( 'ad-gallery-script', WOO_DYNAMIC_GALLERY_JS_URL . '/mygallery/jquery.ad-gallery.js', array(), false, true );
		
		wp_enqueue_style( 'a3_lightbox_style', WOO_DYNAMIC_GALLERY_JS_URL . '/lightbox/themes/default/jquery.lightbox.css' );
		wp_enqueue_script( 'lightbox2_script', WOO_DYNAMIC_GALLERY_JS_URL . '/lightbox/jquery.lightbox.min.js', array(), false, true );
			
		wp_enqueue_style( 'woocommerce_fancybox_styles', WOO_DYNAMIC_GALLERY_JS_URL . '/fancybox/fancybox.css' );
		wp_enqueue_script( 'fancybox', WOO_DYNAMIC_GALLERY_JS_URL . '/fancybox/fancybox.min.js', array(), false, true );
	}

    /*
    * Admin Functions
    */

    /* ----------------------------------------------------------------------------------- */
    /* Admin Tabs */
    /* ----------------------------------------------------------------------------------- */
	function on_add_tab() {
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
    function settings_tab_action() {
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
	   #wc_dgallery_upgrade_area { border:2px solid #E6DB55;-webkit-border-radius:10px;-moz-border-radius:10px;-o-border-radius:10px; border-radius: 10px; padding:0 40% 0 0; position:relative; background:#FFFBCC;}
	   #wc_dgallery_upgrade_inner { background:#FFF; -webkit-border-radius:10px 0 0 10px;-moz-border-radius:10px 0 0 10px;-o-border-radius:10px 0 0 10px; border-radius: 10px 0 0 10px;}
	   #wc_dgallery_upgrade_inner h3{ margin-left:10px;}
	   #wc_dynamic_gallery_extensions { -webkit-border-radius:4px;-moz-border-radius:4px;-o-border-radius:4px; border-radius: 4px 4px 4px 4px; color: #555555; float: right; margin: 0px; padding: 5px; position: absolute; text-shadow: 0 1px 0 rgba(255, 255, 255, 0.8); width: 38%; right:0; top:0px;}
	   </style>
		<?php
       // Display settings for this tab (make sure to add the settings to the tab).
       woocommerce_admin_fields($woocommerce_settings[$current_tab]);
	   ?>
       <script>
	   (function($){
			$(function(){
				$("#dynamic_gallery_show_variation").attr('disabled', 'disabled');
				$("#product_gallery_auto_start").attr('disabled', 'disabled');
				$("#product_gallery_speed").attr('disabled', 'disabled');
				$("#product_gallery_effect").attr('disabled', 'disabled');
				$("#product_gallery_animation_speed").attr('disabled', 'disabled');
				$("#dynamic_gallery_stop_scroll_1image").attr('disabled', 'disabled');
				$("#bg_image_wrapper").attr('disabled', 'disabled');
				$("#border_image_wrapper_color").attr('disabled', 'disabled');
				$("#popup_gallery").attr('disabled', 'disabled');
				$("#caption_font").attr('disabled', 'disabled');
				$("#caption_font_size").attr('disabled', 'disabled');
				$("#caption_font_style").attr('disabled', 'disabled');
				$("#product_gallery_text_color").attr('disabled', 'disabled');
				$("#product_gallery_bg_des").attr('disabled', 'disabled');
				$("#product_gallery_nav").attr('disabled', 'disabled');
				$("#navbar_font").attr('disabled', 'disabled');
				$("#navbar_font_size").attr('disabled', 'disabled');
				$("#navbar_font_style").attr('disabled', 'disabled');
				$("#bg_nav_color").attr('disabled', 'disabled');
				$("#bg_nav_text_color").attr('disabled', 'disabled');
				$("#navbar_height").attr('disabled', 'disabled');
				$("#lazy_load_scroll").attr('disabled', 'disabled');
				$("#transition_scroll_bar").attr('disabled', 'disabled');
				$("#enable_gallery_thumb").attr('disabled', 'disabled');
			});
	   })(jQuery);
	   </script>
       <?php
	}

	/**
     * add_settings_fields()
     *
     * Add settings fields for each tab.
    */
    function add_settings_fields() {
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
    function get_tab_in_view($current_filter, $filter_base) {
    	return str_replace($filter_base, '', $current_filter);
    }

    /**
     * init_form_fields()
     *
     * Prepare form fields to be used in the various tabs.
     */
	function init_form_fields() {
		global $wpdb;
		$woo_dynamic_gallery = wp_create_nonce("woo_dynamic_gallery");
		
		$with_type_html = '<select name="width_type" id="width_type" style="margin: 0px; height: 21px;">
          <option value="%">%</option>
          <option value="px" selected="selected">px</option>
        </select> <span class="description">'.__('Set at 100 and choose % to activate responsive gallery (Pro version feature)', 'woo_dgallery').'</span>';
		
  		// Define settings			
     	$this->fields['dynamic_gallery'] = apply_filters('woocommerce_dynamic_gallery_settings_fields', array(
      		array(
            	'name' => __('Gallery', 'woo_dgallery'),
                'type' => 'title',
                'desc' => '',
          		'id' => 'dynamic_gallery_settings_start'
           	),
			array(  
				'name' => __( 'Gallery width', 'woo_dgallery' ),
				'desc' 		=> $with_type_html,
				'id' 		=> 'product_gallery_width',
				'type' 		=> 'text',
				'css' 		=> 'width:7em;',
				'std' 		=> '320'
			),
			array(  
				'name' => __( 'Gallery height', 'woo_dgallery' ),
				'desc' 		=> 'px',
				'id' 		=> 'product_gallery_height',
				'type' 		=> 'text',
				'css' 		=> 'width:7em;',
				'std' 		=> '215'
			),
			array('type' => 'sectionend', 'id' => 'dynamic_gallery_settings_end'),
			array(
            	'name' => '',
                'type' => 'title',
                'desc' => '',
          		'id' => 'dynamic_gallery_upgrade_start'
           	),
			array(
            	'name' => '',
                'type' => 'title',
                'desc' => '',
          		'id' => 'dynamic_gallery_settings_start'
           	),
			array(  
				'name' 		=> __( 'Product Variation images', 'woo_dgallery' ),
				'desc' 		=> __( 'Show Product Variation images in Gallery. Can disable this feature of individual products from product edit page.', 'woo_dgallery' ),
				'id' 		=> 'dynamic_gallery_show_variation',
				'std' 		=> '0',
				'type' 		=> 'checkbox',
				'checkboxgroup'		=> 'start'
			),
			array(  
				'name' => __( 'Auto start', 'woo_dgallery' ),
				'desc' 		=> '',
				'id' 		=> 'product_gallery_auto_start',
				'css' 		=> 'width:7em;',
				'std' 		=> 'true',
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
				'id' 		=> 'product_gallery_speed',
				'type' 		=> 'text',
				'css' 		=> 'width:7em;',
				'std' 		=> '5'
			),
			array(  
				'name' => __( 'Slide transition effect', 'woo_dgallery' ),
				'desc' 		=> '',
				'id' 		=> 'product_gallery_effect',
				'css' 		=> 'width:7em;',
				'std' 		=> 'slide-hori',
				'type' 		=> 'select',
				'options' => array( 
					'none'  			=> __( 'None', 'woo_dgallery' ),
					'fade'		=> __( 'Fade', 'woo_dgallery' ),
					'slide-hori'		=> __( 'Slide Hori', 'woo_dgallery' ),
					'slide-vert'		=> __( 'Slide vert', 'woo_dgallery' ),
					'resize'		=> __( 'Resize', 'woo_dgallery' ),
				),
				'desc_tip'	=>  false,
			),
			
			array(  
				'name' => __( 'Transition effect speed', 'woo_dgallery' ),
				'desc' 		=> 'seconds',
				'id' 		=> 'product_gallery_animation_speed',
				'css' 		=> 'width:7em;',
				'std' 		=> '2',
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
				'desc' 		=> __( '<em class="description">Check to auto deactivate image transition effect when only 1 image is loaded to gallery.</em>', 'woo_dgallery' ),
				'id' 		=> 'dynamic_gallery_stop_scroll_1image',
				'std' 		=> '0',
				'type' 		=> 'checkbox',
			),
			
			array(  
				'name' => __( 'Image background colour', 'woo_dgallery' ),
				'desc' 		=> __( 'Gallery image background colour. Default <code>#FFFFFF</code>.', 'woo_dgallery' ),
				'id' 		=> 'bg_image_wrapper',
				'type' 		=> 'color',
				'css' 		=> 'width:7em;text-transform: uppercase;',
				'std' 		=> '#FFFFFF'
			),
			array(  
				'name' => __( 'Border colour', 'woo_dgallery' ),
				'desc' 		=> __( 'Gallery border colour. Default <code>#CCCCCC</code>.', 'woo_dgallery' ),
				'id' 		=> 'border_image_wrapper_color',
				'type' 		=> 'color',
				'css' 		=> 'width:7em;text-transform: uppercase;',
				'std' 		=> '#CCCCCC'
			),array(  
				'name' => __( 'Gallery popup', 'woo_dgallery' ),
				'desc' 		=> '',
				'id' 		=> 'popup_gallery',
				'css' 		=> 'width:7em;',
				'std' 		=> 'fb',
				'type' 		=> 'select',
				'options' => array( 
					'fb'			=> __( 'Fancybox', 'woo_dgallery' ),
					'lb'			=> __( 'Lightbox', 'woo_dgallery' ),
					'deactivate'	=> __( 'Deactivate', 'woo_dgallery' ),
				),
				'desc_tip'	=>  false,
			),
			array('type' => 'sectionend', 'id' => 'dynamic_gallery_settings_end'),
			
			
			
			array(
            	'name' => __('Caption text', 'woothemes'),
                'type' => 'title',
                'desc' => '',
          		'id' => 'dynamic_gallery_caption_start'
           	),
			array(  
				'name' => __( 'Font', 'woo_dgallery' ),
				'desc' 		=> '',
				'id' 		=> 'caption_font',
				'css' 		=> 'width:7em;',
				'std' 		=> 'Arial, sans-serif',
				'type' 		=> 'select',
				'options' => array( 
					'Arial, sans-serif'  			=> __( 'Arial', 'woo_dgallery' ),
					'Verdana, Geneva, sans-serif'		=> __( 'Verdana', 'woo_dgallery' ),
					'"Trebuchet MS", Tahoma, sans-serif'		=> __( 'Trebuchet', 'woo_dgallery' ),
					'Georgia, serif'		=> __( 'Georgia', 'woo_dgallery' ),
					'"Times New Roman", serif'		=> __( 'Times New Roman', 'woo_dgallery' ),
					'Tahoma, Geneva, Verdana, sans-serif'		=> __( 'Tahoma', 'woo_dgallery' ),
					'Palatino, "Palatino Linotype", serif'		=> __( 'Palatino', 'woo_dgallery' ),
					'"Helvetica Neue", Helvetica, sans-serif'		=> __( 'Helvetica*', 'woo_dgallery' ),
					'Calibri, Candara, Segoe, Optima, sans-serif'		=> __( 'Calibri*', 'woo_dgallery' ),
					'"Myriad Pro", Myriad, sans-serif'		=> __( 'Myriad Pro*', 'woo_dgallery' ),
					'"Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", sans-serif'		=> __( 'Lucida', 'woo_dgallery' ),
					'"Arial Black", sans-serif'		=> __( 'Arial Black', 'woo_dgallery' ),
					'"Gill Sans", "Gill Sans MT", Calibri, sans-serif'		=> __( 'Gill Sans*', 'woo_dgallery' ),
					'Geneva, Tahoma, Verdana, sans-serif'		=> __( 'Geneva*', 'woo_dgallery' ),
					'Impact, Charcoal, sans-serif'		=> __( 'Impact', 'woo_dgallery' ),
					'Courier, "Courier New", monospace'		=> __( 'Courier', 'woo_dgallery' ),
					'"Century Gothic", sans-serif'		=> __( 'Century Gothic', 'woo_dgallery' ),
				),
				'desc_tip'	=>  false,
			),
			array(  
				'name' => __( 'Font size', 'woo_dgallery' ),
				'desc' 		=> '',
				'id' 		=> 'caption_font_size',
				'css' 		=> 'width:7em;',
				'std' 		=> '12px',
				'type' 		=> 'select',
				'options' => array( 
					'9px'  				=> __( '9px', 'woo_dgallery' ),
					'10px'  			=> __( '10px', 'woo_dgallery' ),
					'11px'  			=> __( '11px', 'woo_dgallery' ),
					'12px'  			=> __( '12px', 'woo_dgallery' ),
					'13px'  			=> __( '13px', 'woo_dgallery' ),
					'14px'  			=> __( '14px', 'woo_dgallery' ),
					'15px'  			=> __( '15px', 'woo_dgallery' ),
					'16px'  			=> __( '16px', 'woo_dgallery' ),
					'17px'  			=> __( '17px', 'woo_dgallery' ),
					'18px'  			=> __( '18px', 'woo_dgallery' ),
					'19px'  			=> __( '19px', 'woo_dgallery' ),
					'20px'  			=> __( '20px', 'woo_dgallery' ),
					'21px'  			=> __( '21px', 'woo_dgallery' ),
					'22px'  			=> __( '22px', 'woo_dgallery' ),
					'23px'  			=> __( '23px', 'woo_dgallery' ),
					'24px'  			=> __( '24px', 'woo_dgallery' ),
					'25px'  			=> __( '25px', 'woo_dgallery' ),
					'26px'  			=> __( '26px', 'woo_dgallery' ),
					'27px'  			=> __( '27px', 'woo_dgallery' ),
					'28px'  			=> __( '28px', 'woo_dgallery' ),
					'29px'  			=> __( '29px', 'woo_dgallery' ),
					'30px'  			=> __( '29px', 'woo_dgallery' ),
				),
			'desc_tip'	=>  false,
			),
			array(  
				'name' => __( 'Font style', 'woo_dgallery' ),
				'desc' 		=> '',
				'id' 		=> 'caption_font_style',
				'css' 		=> 'width:7em;',
				'std' 		=> 'normal',
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
				'id' 		=> 'product_gallery_text_color',
				'type' 		=> 'color',
				'css' 		=> 'width:7em;text-transform: uppercase;',
				'std' 		=> '#FFFFFF'
			),
			array(  
				'name' => __( 'Background', 'woo_dgallery' ),
				'desc' 		=> __( 'Caption text background colour. Default <code>#000000</code>.', 'woo_dgallery' ),
				'id' 		=> 'product_gallery_bg_des',
				'type' 		=> 'color',
				'css' 		=> 'width:7em;text-transform: uppercase;',
				'std' 		=> '#000000'
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
				'id' 		=> 'product_gallery_nav',
				'std' 		=> 'yes',
				'type' 		=> 'checkbox',
				'checkboxgroup'		=> 'start'
			),
			array(  
				'name' => __( 'Font', 'woo_dgallery' ),
				'desc' 		=> '',
				'id' 		=> 'navbar_font',
				'css' 		=> 'width:7em;',
				'std' 		=> 'Arial, sans-serif',
				'type' 		=> 'select',
				'options' => array( 
					'Arial, sans-serif'  			=> __( 'Arial', 'woo_dgallery' ),
					'Verdana, Geneva, sans-serif'		=> __( 'Verdana', 'woo_dgallery' ),
					'"Trebuchet MS", Tahoma, sans-serif'		=> __( 'Trebuchet', 'woo_dgallery' ),
					'Georgia, serif'		=> __( 'Georgia', 'woo_dgallery' ),
					'"Times New Roman", serif'		=> __( 'Times New Roman', 'woo_dgallery' ),
					'Tahoma, Geneva, Verdana, sans-serif'		=> __( 'Tahoma', 'woo_dgallery' ),
					'Palatino, "Palatino Linotype", serif'		=> __( 'Palatino', 'woo_dgallery' ),
					'"Helvetica Neue", Helvetica, sans-serif'		=> __( 'Helvetica*', 'woo_dgallery' ),
					'Calibri, Candara, Segoe, Optima, sans-serif'		=> __( 'Calibri*', 'woo_dgallery' ),
					'"Myriad Pro", Myriad, sans-serif'		=> __( 'Myriad Pro*', 'woo_dgallery' ),
					'"Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", sans-serif'		=> __( 'Lucida', 'woo_dgallery' ),
					'"Arial Black", sans-serif'		=> __( 'Arial Black', 'woo_dgallery' ),
					'"Gill Sans", "Gill Sans MT", Calibri, sans-serif'		=> __( 'Gill Sans*', 'woo_dgallery' ),
					'Geneva, Tahoma, Verdana, sans-serif'		=> __( 'Geneva*', 'woo_dgallery' ),
					'Impact, Charcoal, sans-serif'		=> __( 'Impact', 'woo_dgallery' ),
					'Courier, "Courier New", monospace'		=> __( 'Courier', 'woo_dgallery' ),
					'"Century Gothic", sans-serif'		=> __( 'Century Gothic', 'woo_dgallery' ),
				),
				'desc_tip'	=>  false,
			),
			array(  
				'name' => __( 'Font size', 'woo_dgallery' ),
				'desc' 		=> '',
				'id' 		=> 'navbar_font_size',
				'css' 		=> 'width:7em;',
				'std' 		=> '13px',
				'type' 		=> 'select',
				'options' => array( 
					'9px'  				=> __( '9px', 'woo_dgallery' ),
					'10px'  			=> __( '10px', 'woo_dgallery' ),
					'11px'  			=> __( '11px', 'woo_dgallery' ),
					'12px'  			=> __( '12px', 'woo_dgallery' ),
					'13px'  			=> __( '13px', 'woo_dgallery' ),
					'14px'  			=> __( '14px', 'woo_dgallery' ),
					'15px'  			=> __( '15px', 'woo_dgallery' ),
					'16px'  			=> __( '16px', 'woo_dgallery' ),
					'17px'  			=> __( '17px', 'woo_dgallery' ),
					'18px'  			=> __( '18px', 'woo_dgallery' ),
					'19px'  			=> __( '19px', 'woo_dgallery' ),
					'20px'  			=> __( '20px', 'woo_dgallery' ),
					'21px'  			=> __( '21px', 'woo_dgallery' ),
					'22px'  			=> __( '22px', 'woo_dgallery' ),
					'23px'  			=> __( '23px', 'woo_dgallery' ),
					'24px'  			=> __( '24px', 'woo_dgallery' ),
					'25px'  			=> __( '25px', 'woo_dgallery' ),
					'26px'  			=> __( '26px', 'woo_dgallery' ),
					'27px'  			=> __( '27px', 'woo_dgallery' ),
					'28px'  			=> __( '28px', 'woo_dgallery' ),
					'29px'  			=> __( '29px', 'woo_dgallery' ),
					'30px'  			=> __( '29px', 'woo_dgallery' ),
				),
			'desc_tip'	=>  false,
			),
			array(  
				'name' => __( 'Font style', 'woo_dgallery' ),
				'desc' 		=> '',
				'id' 		=> 'navbar_font_style',
				'css' 		=> 'width:7em;',
				'std' 		=> 'bold',
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
				'id' 		=> 'bg_nav_color',
				'type' 		=> 'color',
				'css' 		=> 'width:7em;text-transform: uppercase;',
				'std' 		=> '#FFFFFF'
			),
			array(  
				'name' => __( 'Text', 'woo_dgallery' ),
				'desc' 		=> __( 'Nav bar text color. Default <code>#000000</code>.', 'woo_dgallery' ),
				'id' 		=> 'bg_nav_text_color',
				'type' 		=> 'color',
				'css' 		=> 'width:7em;text-transform: uppercase;',
				'std' 		=> '#000000'
			),
			array(  
				'name' => __( 'Container height', 'woo_dgallery' ),
				'desc' 		=> 'px',
				'id' 		=> 'navbar_height',
				'type' 		=> 'text',
				'css' 		=> 'width:7em;',
				'std' 		=> '25'
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
				'id' 		=> 'lazy_load_scroll',
				'std' 		=> 'yes',
				'type' 		=> 'checkbox',
				'checkboxgroup'		=> 'start'
			),
			array(  
				'name' => __( 'Colour', 'woo_dgallery' ),
				'desc' 		=> __( 'Scroll bar colour. Default <code>#000000</code>.', 'woo_dgallery' ),
				'id' 		=> 'transition_scroll_bar',
				'type' 		=> 'color',
				'css' 		=> 'width:7em;text-transform: uppercase;',
				'std' 		=> '#000000'
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
				'id' 		=> 'enable_gallery_thumb',
				'std' 		=> 'yes',
				'type' 		=> 'checkbox',
				'checkboxgroup'		=> 'start'
			),
			array('type' => 'sectionend', 'id' => 'dynamic_gallery_thumb_end'),
			
			array('type' => 'sectionend', 'id' => 'dynamic_gallery_upgrade_end'),
			
			array(
            	'name' => '',
                'type' => 'title',
                'desc' => '',
          		'id' => 'dynamic_gallery_thumbnail_settings'
           	),
			array(  
				'name' => __( 'Thumbnail width', 'woo_dgallery' ),
				'desc' 		=> 'px. '.__("IMPORTANT! Do not set this value to '0' or empty. A &lt;not divisible by 0&gt; error will show instead of the Gallery if you do.", 'woo_dgallery'),
				'id' 		=> 'thumb_width',
				'type' 		=> 'text',
				'css' 		=> 'width:7em;',
				'std' 		=> '105'
			),
			array(  
				'name' => __( 'Thumbnail height', 'woo_dgallery' ),
				'desc' 		=> 'px. '.__("IMPORTANT! Do not set this value to '0' or empty. A &lt;not divisible by 0&gt; error will show instead of the Gallery if you do.", 'woo_dgallery'),
				'id' 		=> 'thumb_height',
				'type' 		=> 'text',
				'css' 		=> 'width:7em;',
				'std' 		=> '75'
			),
			array(  
				'name' => __( 'Thumbnail spacing', 'woo_dgallery' ),
				'desc' 		=> 'px',
				'id' 		=> 'thumb_spacing',
				'type' 		=> 'text',
				'css' 		=> 'width:7em;',
				'std' 		=> '2'
			),
			array('type' => 'sectionend', 'id' => 'dynamic_gallery_thumb_end'),
			
			array(	'name' => __( 'Preview', 'woo_dgallery' ), 'type' => 'title', 'desc' => '<a href="'.admin_url("admin-ajax.php").'?security='.$woo_dynamic_gallery.'" class="preview_gallery">'.__( 'Click here to preview gallery', 'woo_dgallery' ).'</a>. ', 'id' => 'preview_gallery' ),
			array('type' => 'sectionend', 'id' => 'dynamic_gallery_preview_end')
        ));
	}

    /**
     * save_settings()
     *
     * Save settings in a single field in the database for each tab's fields (one field per tab).
     */
     function save_settings() {
     	global $woocommerce_settings;

        // Make sure our settings fields are recognised.
        $this->add_settings_fields();

        $current_tab = $this->get_tab_in_view(current_filter(), 'woocommerce_update_options_');

		woocommerce_update_options($woocommerce_settings[$current_tab]);
		WC_Dynamic_Gallery::wc_dynamic_gallery_set_setting(true, true);
	}

    /** Helper functions ***************************************************** */
         
    /**
     * Gets a setting
     */
    public function setting($key) {
		return get_option($key);
	}
	
	function wc_dynamic_gallery_extension() {
		$html = '';
		$html .= '<div id="wc_dynamic_gallery_extensions">';
		$html .= '<a href="http://a3rev.com/shop/" target="_blank" style="float:right;margin-top:5px; margin-left:10px;" ><img src="'.WOO_DYNAMIC_GALLERY_IMAGES_URL.'/a3logo.png" /></a>';
		$html .= '<h3>'.__('Upgrade to Dynamic Gallery Pro', 'woo_dgallery').'</h3>';
		$html .= '<p>'.__("Visit the", 'woo_dgallery').' <a href="http://a3rev.com/shop/woocommerce-dynamic-gallery/" target="_blank">'.__("a3rev website", 'woo_dgallery').'</a> '.__("to see all the extra features the Pro version of this plugin offers like", 'woo_dgallery').':</p>';
		$html .= '<p>';
		$html .= '<ul style="padding-left:10px;">';
		$html .= '<li>1. '.__('Show Multiple Product Variation images in Gallery. As users selects options from the drop down menu that options product image auto shows in the Dynamic Gallery complete with caption text.', 'woo_dgallery').'</li>';
		$html .= '<li>2. '.__('Fully Responsive Gallery option. Set gallery wide to % and it becomes fully responsive image product gallery including the image zoom pop up.', 'woo_dgallery').'</li>';
		$html .= '<li>3. '.__('Activate all of the Gallery customization settings you see here on this page to style and fine tune your product presentation.', 'woo_dgallery').'</li>';
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
		$html .= '<li>* <a href="http://a3rev.com/shop/woocommerce-email-inquiry-and-cart-options/" target="_blank">'.__('WooCommerce Email Inquiry & Cart Options', 'woo_dgallery').'</a>'.__(' - Pro Version only from a3rev', 'woo_dgallery').'</li>';
		$html .= '</ul>';
		$html .= '</p>';
		$html .= '<h3>'.__('WordPress Plugins', 'woo_dgallery').'</h3>';
		$html .= '<p>';
		$html .= '<ul style="padding-left:10px;">';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/wp-email-template/" target="_blank">'.__('WordPress Email Template', 'woo_dgallery').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/page-views-count/" target="_blank">'.__('Page View Count', 'woo_dgallery').'</a></li>';
		$html .= '</ul>';
		$html .= '</p>';
		$html .= '<h3>'.__('WP e-Commerce Plugins', 'woo_dgallery').'</h3>';
		$html .= '<p>';
		$html .= '<ul style="padding-left:10px;">';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/wp-e-commerce-dynamic-gallery/" target="_blank">'.__('WP e-Commerce Dynamic Gallery', 'woo_dgallery').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/wp-e-commerce-predictive-search/" target="_blank">'.__('WP e-Commerce Predictive Search', 'woo_dgallery').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/wp-ecommerce-compare-products/" target="_blank">'.__('WP e-Commerce Compare Products', 'woo_dgallery').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/wp-e-commerce-catalog-visibility-and-email-inquiry/" target="_blank">'.__('WP e-Commerce Catalog Visibility & Email Inquiry', 'woo_dgallery').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/extend/plugins/wp-e-commerce-grid-view/" target="_blank">'.__('WP e-Commerce Grid View', 'woo_dgallery').'</a></li>';
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
	
	function wc_dynamic_gallery_upgrade_area_start() {
		echo '<tr valign="top"><td style="padding:0;"><div id="wc_dgallery_upgrade_area">'.$this->wc_dynamic_gallery_extension().'<div id="wc_dgallery_upgrade_inner">';
	}
	
	function wc_dynamic_gallery_upgrade_area_end() {
		echo '</div></div></td></tr>';
	}
	
	function plugin_extra_links($links, $plugin_name) {
		if ( $plugin_name != WOO_DYNAMIC_GALLERY_NAME) {
			return $links;
		}
		$links[] = '<a href="http://docs.a3rev.com/user-guides/woocommerce/woo-dynamic-gallery/" target="_blank">'.__('Documentation', 'woo_dgallery').'</a>';
		$links[] = '<a href="http://a3rev.com/shop/woocommerce-dynamic-gallery/#tab-reviews" target="_blank">'.__('Support', 'woo_dgallery').'</a>';
		return $links;
	}
}
?>