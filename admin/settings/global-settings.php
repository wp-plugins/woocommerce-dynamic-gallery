<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
WC Dynamic Gallery Settings

TABLE OF CONTENTS

- var parent_tab
- var subtab_data
- var option_name
- var form_key
- var position
- var form_fields
- var form_messages

- __construct()
- subtab_init()
- set_default_settings()
- get_settings()
- subtab_data()
- add_subtab()
- settings_form()
- init_form_fields()

-----------------------------------------------------------------------------------*/

class WC_Dynamic_Gallery_Global_Settings extends WC_Dynamic_Gallery_Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = 'global-settings';
	
	/**
	 * @var array
	 */
	private $subtab_data;
	
	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = '';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'wc_dgallery_global_settings';
	
	/**
	 * @var string
	 * You can change the order show of this sub tab in list sub tabs
	 */
	private $position = 1;
	
	/**
	 * @var array
	 */
	public $form_fields = array();
	
	/**
	 * @var array
	 */
	public $form_messages = array();
	
	/*-----------------------------------------------------------------------------------*/
	/* __construct() */
	/* Settings Constructor */
	/*-----------------------------------------------------------------------------------*/
	public function __construct() {
		$this->init_form_fields();
		$this->subtab_init();
		
		$this->form_messages = array(
				'success_message'	=> __( 'Dynamic Gallery Settings successfully saved.', 'woo_dgallery' ),
				'error_message'		=> __( 'Error: Dynamic Gallery Settings can not save.', 'woo_dgallery' ),
				'reset_message'		=> __( 'Dynamic Gallery Settings successfully reseted.', 'woo_dgallery' ),
			);
			
		add_action( $this->plugin_name . '_set_default_settings' , array( $this, 'set_default_settings' ) );
		
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_init' , array( $this, 'reset_default_settings' ) );
		
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_init' , array( $this, 'after_save_settings' ) );
		//add_action( $this->plugin_name . '_get_all_settings' , array( $this, 'get_settings' ) );
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* subtab_init() */
	/* Sub Tab Init */
	/*-----------------------------------------------------------------------------------*/
	public function subtab_init() {
		
		add_filter( $this->plugin_name . '-' . $this->parent_tab . '_settings_subtabs_array', array( $this, 'add_subtab' ), $this->position );
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* set_default_settings()
	/* Set default settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function set_default_settings() {
		global $wc_dgallery_admin_interface;
		
		$wc_dgallery_admin_interface->reset_settings( $this->form_fields, $this->option_name, false );
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* reset_default_settings()
	/* Reset default settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function reset_default_settings() {
		global $wc_dgallery_admin_interface;
		
		$wc_dgallery_admin_interface->reset_settings( $this->form_fields, $this->option_name, true, true );
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* after_save_settings()
	/* Process when clean on deletion option is un selected */
	/*-----------------------------------------------------------------------------------*/
	public function after_save_settings() {
		if ( isset( $_POST['bt_save_settings'] ) && isset( $_POST[WOO_DYNAMIC_GALLERY_PREFIX.'reset_galleries_activate'] ) ) {
			delete_option( WOO_DYNAMIC_GALLERY_PREFIX.'reset_galleries_activate' );
			WC_Dynamic_Gallery_Functions::reset_products_galleries_activate();			
		}
		if ( ( isset( $_POST['bt_save_settings'] ) || isset( $_POST['bt_reset_settings'] ) ) && get_option( 'wc_dgallery_lite_clean_on_deletion' ) == 'no'  )  {
			$uninstallable_plugins = (array) get_option('uninstall_plugins');
			unset($uninstallable_plugins[WOO_DYNAMIC_GALLERY_NAME]);
			update_option('uninstall_plugins', $uninstallable_plugins);
		}
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* get_settings()
	/* Get settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function get_settings() {
		global $wc_dgallery_admin_interface;
		
		$wc_dgallery_admin_interface->get_settings( $this->form_fields, $this->option_name );
	}
	
	/**
	 * subtab_data()
	 * Get SubTab Data
	 * =============================================
	 * array ( 
	 *		'name'				=> 'my_subtab_name'				: (required) Enter your subtab name that you want to set for this subtab
	 *		'label'				=> 'My SubTab Name'				: (required) Enter the subtab label
	 * 		'callback_function'	=> 'my_callback_function'		: (required) The callback function is called to show content of this subtab
	 * )
	 *
	 */
	public function subtab_data() {
		
		$subtab_data = array( 
			'name'				=> 'global-settings',
			'label'				=> __( 'Settings', 'woo_dgallery' ),
			'callback_function'	=> 'wc_dgallery_global_settings_form',
		);
		
		if ( $this->subtab_data ) return $this->subtab_data;
		return $this->subtab_data = $subtab_data;
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* add_subtab() */
	/* Add Subtab to Admin Init
	/*-----------------------------------------------------------------------------------*/
	public function add_subtab( $subtabs_array ) {
	
		if ( ! is_array( $subtabs_array ) ) $subtabs_array = array();
		$subtabs_array[] = $this->subtab_data();
		
		return $subtabs_array;
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* settings_form() */
	/* Call the form from Admin Interface
	/*-----------------------------------------------------------------------------------*/
	public function settings_form() {
		global $wc_dgallery_admin_interface;
		
		$output = '';
		$output .= $wc_dgallery_admin_interface->admin_forms( $this->form_fields, $this->form_key, $this->option_name, $this->form_messages );
		
		return $output;
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* init_form_fields() */
	/* Init all fields of this form */
	/*-----------------------------------------------------------------------------------*/
	public function init_form_fields() {
		
  		// Define settings			
     	$this->form_fields = apply_filters( $this->option_name . '_settings_fields', array(
			array(
            	'name' => __('WooCommerce Product Gallery Meta Box', 'woo_dgallery'),
                'type' => 'heading',
           	),
			array(  
				'name' 		=> __( 'Disable it', 'woo_dgallery' ),
				'desc' 		=> __( 'ON to hide the default WooCommerce Product Gallery meta box on product edit pages. Do this to avoid confusion with the Dynamic Gallery meta box.', 'woo_dgallery' ),
				'id' 		=> WOO_DYNAMIC_GALLERY_PREFIX.'hide_woo_gallery',
				'default'	=> 'no',
				'type' 		=> 'onoff_checkbox',
				'free_version'		=> true,
				'checked_value'		=> 'yes',
				'unchecked_value'	=> 'no',
				'checked_label'		=> __( 'ON', 'woo_dgallery' ),
				'unchecked_label' 	=> __( 'OFF', 'woo_dgallery' ),
			),
		
			array(	'name' => __( 'Image Zoom Function', 'woo_dgallery' ), 'type' => 'heading'),
			array(  
				'name' => __( 'Gallery popup', 'woo_dgallery' ),
				'desc' 		=> '',
				'id' 		=> WOO_DYNAMIC_GALLERY_PREFIX.'popup_gallery',
				'default'	=> 'fb',
				'type' 		=> 'onoff_radio',
				'free_version'		=> true,
				'onoff_options' => array(
					array(
						'val' => 'fb',
						'text' => __( 'Fancybox', 'woo_dgallery' ),
						'checked_label'	=> 'ON',
						'unchecked_label' => 'OFF',
					),
					
					array(
						'val' => 'colorbox',
						'text' => __( 'ColorBox', 'woo_dgallery' ),
						'checked_label'	=> 'ON',
						'unchecked_label' => 'OFF',
					),
					
					array(
						'val' => 'deactivate',
						'text' => __( 'Deactivate', 'woo_dgallery' ),
						'checked_label'	=> 'ON',
						'unchecked_label' => 'OFF',
					),
					
				),
				
			),
			
      		array(
            	'name' => __('Gallery On / Off', 'woo_dgallery'),
                'type' => 'heading',
           	),
			array(  
				'name' 		=> __( 'Gallery Activation Default', 'woo_dgallery' ),
				'desc' 		=> __( 'ON = Gallery Activated on Product Pages. OFF = Deactivated. Note: Changing this setting will not over-ride any custom Gallery activation settings made on single product pages.', 'woo_dgallery' ),
				'id' 		=> WOO_DYNAMIC_GALLERY_PREFIX.'activate',
				'default'	=> 'yes',
				'type' 		=> 'onoff_checkbox',
				'free_version'		=> true,
				'checked_value'		=> 'yes',
				'unchecked_value'	=> 'no',
				'checked_label'		=> __( 'ON', 'woo_dgallery' ),
				'unchecked_label' 	=> __( 'OFF', 'woo_dgallery' ),
			),
			array(  
				'name' 		=> __( 'Reset Activation to default', 'woo_dgallery' ),
				'desc' 		=> __( "<strong>Warning:</strong> Set to ON and Save Changes will reset ALL products to the default 'Gallery Activation' status you set above including ALL individual custom Product Page Gallery activation settings.", 'woo_dgallery' ),
				'id' 		=> WOO_DYNAMIC_GALLERY_PREFIX.'reset_galleries_activate',
				'default'	=> 'no',
				'type' 		=> 'onoff_checkbox',
				'free_version'		=> true,
				'checked_value'		=> 'yes',
				'unchecked_value'	=> 'no',
				'checked_label'		=> __( 'ON', 'woo_dgallery' ),
				'unchecked_label' 	=> __( 'OFF', 'woo_dgallery' ),
			),
			
			array(	
				'name' 		=> __( 'Image Variation Feature', 'woo_dgallery' ), 
				'type' 		=> 'heading',
				'class'		=> 'pro_feature_fields',
			),
			array(  
				'name' 		=> __( 'Variations Activation Default', 'woo_dgallery' ),
				'desc' 		=> __( 'ON = Variation Images Activated on Product Pages. OFF = Deactivated. Note: Changing this setting will not over-ride any custom Variation Images activation settings made on single product pages.', 'woo_dgallery' ),
				'id' 		=> WOO_DYNAMIC_GALLERY_PREFIX.'show_variation',
				'default'	=> 'no',
				'type' 		=> 'onoff_checkbox',
				'checked_value'		=> 'yes',
				'unchecked_value'	=> 'no',
				'checked_label'		=> __( 'ON', 'woo_dgallery' ),
				'unchecked_label' 	=> __( 'OFF', 'woo_dgallery' ),
			),
			array(  
				'name' 		=> __( 'Reset Activation to default', 'woo_dgallery' ),
				'desc' 		=> __( "<strong>Warning:</strong> Set to ON and Save Changes will reset ALL products to the default 'Variations Activation' status you set above. NOTE:  ALL individual custom Product Page Variation Images Activation settings will be changed to the default.", 'woo_dgallery' ),
				'id' 		=> WOO_DYNAMIC_GALLERY_PREFIX.'reset_variation_activate',
				'default'	=> 'no',
				'type' 		=> 'onoff_checkbox',
				'checked_value'		=> 'yes',
				'unchecked_value'	=> 'no',
				'checked_label'		=> __( 'ON', 'woo_dgallery' ),
				'unchecked_label' 	=> __( 'OFF', 'woo_dgallery' ),
			),
			
			array(	'name' => __( 'House Keeping', 'woo_dgallery' ).' :', 'type' => 'heading'),
			array(  
				'name' 		=> __( 'Clean up on Deletion', 'woo_dgallery' ),
				'desc' 		=> __( 'On deletion (not deactivate) the plugin it will completely remove all of its code and tables it has created, leaving no trace it was ever here. It will not delete your product images! <strong>WARNING</strong> All of the gallery settings you have made will be deleted forever. If you ever reinstall the gallery you will have to reset them all.', 'woo_dgallery' ),
				'id' 		=> 'wc_dgallery_clean_on_deletion',
				'default'	=> 'no',
				'type' 		=> 'onoff_checkbox',
				'free_version'		=> true,
				'checked_value'		=> 'yes',
				'unchecked_value'	=> 'no',
				'checked_label'		=> __( 'ON', 'woo_dgallery' ),
				'unchecked_label' 	=> __( 'OFF', 'woo_dgallery' ),
			),
        ));
	}
}

global $wc_dgallery_global_settings;
$wc_dgallery_global_settings = new WC_Dynamic_Gallery_Global_Settings();

/** 
 * wc_dgallery_global_settings_form()
 * Define the callback function to show subtab content
 */
function wc_dgallery_global_settings_form() {
	global $wc_dgallery_global_settings;
	$wc_dgallery_global_settings->settings_form();
}

?>
