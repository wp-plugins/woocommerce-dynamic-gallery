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
			update_option('product_gallery_speed',5);
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
			update_option('product_gallery_bg_des','#000000');
		}
		if( trim(get_option('product_gallery_nav')) == '' || $reset ){
			update_option('product_gallery_nav','yes');
		}
		if( trim(get_option('bg_nav_color')) == '' || $reset ){
			update_option('bg_nav_color','#FFFFFF');
		}
		if( trim(get_option('bg_nav_text_color')) == '' || $reset ){
			update_option('bg_nav_text_color','#000000');
		}
		if( trim(get_option('popup_gallery')) == '' || $reset ){
			update_option('popup_gallery','fb');
		}
		if( trim(get_option('enable_gallery_thumb')) == '' || $reset ){
			update_option('enable_gallery_thumb','yes');
		}
		if( trim(get_option('transition_scroll_bar')) == '' || $reset ){
			update_option('transition_scroll_bar','#000000');
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
		
		add_action('admin_head', array(&$this, 'wc_dynamic_gallery_add_script'), 10);
		
		add_action('wp_ajax_woo_dynamic_gallery', array('WC_Gallery_Display_Class','wc_dynamic_gallery_preview'));
		add_action('wp_ajax_nopriv_woo_dynamic_gallery', array('WC_Gallery_Display_Class','wc_dynamic_gallery_preview'));

	}
	
	function wc_dynamic_gallery_add_script(){
		wp_register_script( 'dynamic-gallery-script', WOO_DYNAMIC_GALLERY_URL.'/assets/js/galleries.js' );
		wp_enqueue_script( 'dynamic-gallery-script' );
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
	   ?>
       <style>
	   #wc_dgallery_upgrade_area { border:2px solid #FF0;-webkit-border-radius:10px;-moz-border-radius:10px;-o-border-radius:10px; border-radius: 10px; padding:0; position:relative}
	   #wc_dgallery_upgrade_area h3{ margin-left:10px;}
	   #wc_dynamic_gallery_extensions { background: url("<?php echo WOO_DYNAMIC_GALLERY_URL; ?>/assets/images/logo_a3blue.png") no-repeat scroll 4px 6px #FFFBCC; -webkit-border-radius:4px;-moz-border-radius:4px;-o-border-radius:4px; border-radius: 4px 4px 4px 4px; color: #555555; float: right; margin: 0px; padding: 4px 8px 4px 38px; position: absolute; text-shadow: 0 1px 0 rgba(255, 255, 255, 0.8); width: 300px; left:400px; top:10px; border:1px solid #E6DB55}
	   </style>
		<?php
       // Display settings for this tab (make sure to add the settings to the tab).
       woocommerce_admin_fields($woocommerce_settings[$current_tab]);
	   ?>
       <script>
	   (function($){
			$(function(){
				$("#product_gallery_auto_start").attr('disabled', 'disabled');
				$("#product_gallery_speed").attr('disabled', 'disabled');
				$("#product_gallery_effect").attr('disabled', 'disabled');
				$("#product_gallery_animation_speed").attr('disabled', 'disabled');
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
				'desc' 		=> 'px',
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
					'fb'  			=> __( 'Fancybox', 'woo_dgallery' ),
					'lb'		=> __( 'Lightbox', 'woo_dgallery' ),
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
				'desc' 		=> 'px',
				'id' 		=> 'thumb_width',
				'type' 		=> 'text',
				'css' 		=> 'width:7em;',
				'std' 		=> '105'
			),
			array(  
				'name' => __( 'Thumbnail height', 'woo_dgallery' ),
				'desc' 		=> 'px',
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
			
			array(	'name' => __( 'Preview', 'woo_dgallery' ), 'type' => 'title', 'desc' => '<a href="'.admin_url("admin-ajax.php").'?security='.$woo_dynamic_gallery.'" class="preview_allery">Click here to preview gallery</a>. ', 'id' => 'preview_gallery' ),
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
		$html .= '<div id="wc_dynamic_gallery_extensions">'.__('Introductory Offer! Activate these 22 advanced features with', 'woo_dgallery').' <a target="_blank" href="http://a3rev.com/products-page/woocommerce/woocommerce-dynamic-gallery/">'.__('WooCommerce Dynamic Gallery Pro', 'woo_dgallery').'</a> '.__('for just a tiny', 'woo_dgallery').' <strong>$5</strong> - '.__("Offer won't last, grab it while you can!", 'woo_dgallery').'</div>';
		return $html;	
	}
	
	function wc_dynamic_gallery_upgrade_area_start() {
		echo '<tr valign="top"><td style="padding:0;"><div id="wc_dgallery_upgrade_area">'.$this->wc_dynamic_gallery_extension();
	}
	
	function wc_dynamic_gallery_upgrade_area_end() {
		echo '</div></td></tr>';
	}
}
?>