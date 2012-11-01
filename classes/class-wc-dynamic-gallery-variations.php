<?php
/**
 * WooCommerce Dynamic Gallery Meta_Boxes Class
 *
 * Class Function into woocommerce plugin
 *
 * Table Of Contents
 *
 * media_fields()
 */
class WC_Dynamic_Gallery_Variations{
	
	function media_fields( $form_fields, $attachment ) {
	
		global $woocommerce;
		
		$product_id = $_GET['post_id'];
		
		if( get_post_type($product_id) == 'product' ) {
			
			$woocommerce_exclude_image_fields = $form_fields['woocommerce_exclude_image'];
			
			$form_fields['woocommerce_exclude_image']['helps'] = __('Enabling this option will hide it from the product page image gallery.', 'woocommerce').' '.__('If assigned to variations below the image will show when option is selected. (Show Product Variations in Gallery is a', 'woo_dgallery').' <a href="http://a3rev.com/products-page/woocommerce/woocommerce-dynamic-gallery/" target="_blank">'.__('Pro Version', 'woo_dgallery').'</a> '.__('only feature', 'woo_dgallery').')';
					
			$attributes = (array) maybe_unserialize(get_post_meta($product_id, '_product_attributes', true) );
						
			$have_variation = false;
			
			if (is_array( $attributes ) && count($attributes) > 0 ) {
				foreach($attributes as $attribute => $data) {
					if($data['is_variation']) {
						$have_variation = true;
						break;
					}
				}
			}
			if ($have_variation) {
				$form_fields['start_variation'] = array(
						'label' => __('Variations', 'woo_dgallery'),
						'input' => 'html',
						'html' => '<style>.start_variation {border-width:2px 2px 0} .end_variation {border-width:0 2px 2px} .start_variation, .end_variation {border-style:solid ;border-color:#E6DB55;-webkit-border-radius:10px;-moz-border-radius:10px;-o-border-radius:10px; border-radius: 10px;position:relative;}</style>',
						'value' => '',
						'helps'	=> __('Upgrade to the PRO version to use this feature.', 'woo_dgallery'),
					);
				foreach($attributes as $attribute => $data) {
					
					if($data['is_variation']) {
					
						if (strpos($data['name'], 'pa_') !== false) {
							
							$terms = wp_get_post_terms( $product_id, $data['name'] );
							
							$values = array();
							foreach($terms as $term) {
								$values[] = $term->name;
							}
							
							$data['name'] = str_replace('pa_','',$data['name']);
							$data['name'] = ucwords($data['name']);
							
						} else {
				
							$values = explode('|', $data['value']);
							
						} // End check to see if attribute is defined through woocomm, or manually
						
							$html = "<style>.in_variations_".$attribute." {border-width:0 2px;border-style:solid ;border-color:#E6DB55;}</style>";
							
							$i = 0; foreach($values as $value) {
								$slug = sanitize_title($value);
								$html .= "<input disabled='disabled' type='checkbox' id='".$attachment->ID."_".$attribute."_".$i."'> <label for='".$attachment->ID."_".$attribute."_".$i."'>".$value."</label><br />";
							$i++; }
						
							$form_fields['in_variations_'.$attribute] = array(
								'label' => $data['name'],
								'input' => 'html',
								'html' => $html,
								'value' => ''
							);
					
					}
				}	
				$form_fields['end_variation'] = array(
						'label' => '',
						'input' => 'html',
						'html' => '&nbsp;',
						'value' => ''
					);
			}
			
		} // if('product')
	
		return $form_fields;
	}
}
?>