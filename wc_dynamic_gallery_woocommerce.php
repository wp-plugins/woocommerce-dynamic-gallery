<?php
/*
Plugin Name: WooCommerce Dynamic Gallery LITE
Plugin URI: http://www.a3rev.com/
Description: WooCommerce Dynamic Gallery LITE plugin.
Version: 1.0.1
Author: A3 Revolution Software Development team
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

/*
== Changelog ==

= 1.0.0 - 12/07/2012 =
* First working release of the modification
*/

?>
<?php
define( 'WOO_DYNAMIC_GALLERY_FILE_PATH', dirname(__FILE__) );
define( 'WOO_DYNAMIC_GALLERY_DIR_NAME', basename(WOO_DYNAMIC_GALLERY_FILE_PATH) );
define( 'WOO_DYNAMIC_GALLERY_FOLDER', dirname(plugin_basename(__FILE__)) );
define( 'WOO_DYNAMIC_GALLERY_URL', WP_CONTENT_URL.'/plugins/'.WOO_DYNAMIC_GALLERY_FOLDER );
define( 'WOO_DYNAMIC_GALLERY_DIR', WP_CONTENT_DIR.'/plugins/'.WOO_DYNAMIC_GALLERY_FOLDER );

include('classes/class-wc-dynamic-gallery.php');
include('classes/class-wc-dynamic-gallery-metaboxes.php');
include('admin/class-wc-dynamic-gallery-admin.php');
include('admin/wc_gallery_woocommerce_admin.php');

/**
* Call when the plugin is activated
*/
register_activation_hook(__FILE__,'wc_dynamic_gallery_install');
?>
