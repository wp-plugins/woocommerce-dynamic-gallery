=== WooCommerce Dynamic Gallery  ===
Contributors: a3rev, A3 Revolution Software Development team
Tags: WooCommerce image gallery, WooCommerce, WooCommerce Product images, woothemes, wordpress ecommerce
Requires at least: 3.3
Tested up to: 3.4.1
Stable tag: 1.0.3
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Bring your product pages and presentation alive with WooCommerce Dynamic Gallery. Beautifully.
 
== Description ==

As soon as you install WooCommerce Dynamic Gallery it <strong>brings your store to life</strong> with a beautifully stylish sliding image gallery on every product page.  
 
= Key Features =

* Instantly adds a scrolling gallery to every product page and adds all product images each gallery
* Gallery scales images to fit inside the container no matter what the size or shape.
* Search Engine friendly images. Image Alt tags if set are visible to search engines
* On-page Gallery easy manager greatly simplifies product image editing and gallery management.
* Lazy-load feature - means the gallery loads instantly - no matter how many images in the gallery. 
 
Having an image with your products creates more sales. WooCommerce Dynamic  Gallery not only enables you to show an unlimited number of images - it shows one image or lots of images in a beautiful and dynamic presentation.  

= More Feature =

* Add caption text to images
* Caption text fades in after image transition effect and out before the next transaction effect begins.
* Manual image click to scroll next or previous.
* ZOOM - shows full size image with caption text and manual scroll through entire gallery.
* START SLIDE SHOW | STOP SLIDESHOW control
* Gallery thumbnails scroll left and right on hover.

= Premium Upgrade =

A small once only Premium upgrade activates a total of 22 different settings that allows you to tweak and style the WooCommerce Dynamic Gallery to match your theme and your preferences to perfection. You will see all of the available upgrade features on the plugins admin panel. The Premium upgrade also gives you access to lifetime guaranteed same day one-on-one support by email. 

= Localization =
* English (default) - always include.
* .po file (woo_dgallery.po) in languages folder for translations.
* Your translation? Please do yours and [send it to us](http://www.a3rev.com/contact/) We'll acknowledge your work and link to your site.
Please [Contact us](http://www.a3rev.com/contact/) if you'd like to provide a translation or an update.

= Plugins resources =

[Home Page](http://a3rev.com/products-page/woocommerce/woocommerce-dynamic-gallery/) |
[Documentation](http://docs.a3rev.com/user-guides/woocommerce/woo-dynamic-gallery/) |
[Support](http://a3rev.com/products-page/woocommerce/woocommerce-dynamic-gallery/#help)


== Installation ==

= Minimum Requirements =

* WordPress 3.3 or greater
* PHP version 5.2.4 or greater
* MySQL version 5.0 or greater
 
= Automatic installation =

Automatic installation is the easiest option as WordPress handles the file transfers itself and you don't even need to leave your web browser. To do an automatic install of WooCommerce Dynamic Gallery, log in to your WordPress admin panel, navigate to the Plugins menu and click Add New. 

In the search field type "WooCommerce Dynamic Gallery" and click Search Plugins. Once you have found our plugin you can install it by simply clicking Install Now. After clicking that link you will be asked if you are sure you want to install the plugin. Click yes and WordPress will automatically complete the installation. 

= Manual installation =

The manual installation method involves downloading our plugin and uploading it to your web server via your favorite FTP application.

1. Download the plugin file to your computer and unzip it
2. Using an FTP program, or your hosting control panel, upload the unzipped plugin folder to your WordPress installations wp-content/plugins/ directory.
3. Activate the plugin from the Plugins menu within the WordPress admin.


== Screenshots ==

1. WooCommerce Dynamic Gallery
2. WooCommerce Dynamic Gallery activated admin settings (cut down view)
3. WooCommerce Dynamic Gallery on-page Gallery Image easy manager

== Usage ==

1. WP admin > WooCommerce > Settings > Dynamic Gallery

2. Set the wide and tall in px of the image gallery to match your theme.

3. Set the Wide and Tall in px of your gallery Thumbnails and the padding to show between them.

4. Use the Click here to preview gallery link to see a pop up preview of your work..

5. Save your changes.

6. Have fun.

== Frequently Asked Questions ==

= When can I use this plugin? =

You can use this plugin only when you have installed the WooCommerce plugin.
 
== Support ==

Support and access to this plugin documents are available from the [HELP tab](http://a3rev.com/products-page/woocommerce/woocommerce-dynamic-gallery/#help) on the Pro Versions Home page.

== Changelog ==

= 1.0.3 - 2012/08/03

* Fixed : Fixed: Gallery preview not working on sites that do not have wp_enqueue_script( 'thickbox' ) by default. Added call to wp_enqueue_script( 'thickbox' ) if it does not exist so that preview window can open.
* Fixed : Updated depreciated php function ereg() with stristr() so that Pro version auto plugin auto upgrade feature work without error for WordPress 3.4.0 and later
* Feature: Add fancybox script to plugin so that if the theme does not support fancybox or it is disabled in the admin panel then the gallery image zoom can still work.
* Feature: Enqueue plugin script into footer use wp_enqueue_script so that now it is only loaded when needed rather than site-wide and has zero impact on page load speeds.
* Feature: Enqueue plugin style into header use wp_enqueue_style so that now it is only loaded when needed rather than site-wide and has zero impact on page load speeds.
* Feature: Add plugin Documentation and Support links to the wp plugins dashboard description.
* Tweak: Add plugin description to wp plugins dashboard.
* Tweak: Change localization file path from actual to base path

= 1.0.2 - 2012/07/18 =

* Fix - Edit Javascript to fix Image Scaling Issue.

= 1.0.1 - 2012/07/17 =

* Fix - Set Gallery z index to a low number so that theme Nav bar dropdowns don't show behind the gallery.
* Fix - Remove gallery script that makes wide of block class to 100% which was causing some themes footer widgets to show 100% wide.

= 1.0 - 2012/07/14 =

* Initial release.

  