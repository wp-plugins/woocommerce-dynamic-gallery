<?php
/**
 * WooCommerce Dynamic Gallery Meta_Boxes Class
 *
 * Class Function into woocommerce plugin
 *
 * Table Of Contents
 *
 * woocommerce_meta_boxes_image()
 * woocommerce_product_image_box()
 */
class WC_Dynamic_Gallery_Meta_Boxes{

	function woocommerce_meta_boxes_image() {
		global $post;
		// Products
		add_meta_box( 'woocommerce-product-image', __('Gallery Images', 'woo_dgallery'), array('WC_Dynamic_Gallery_Meta_Boxes','woocommerce_product_image_box'), 'product', 'normal', 'high' );
	}
	function woocommerce_product_image_box() {
		
		global $post, $thepostid;
		
		$thepostid = $post->ID;
		echo '<script type="text/javascript">
		
		jQuery(\'.upload_image_button\').live(\'click\', function(){
			var post_id = '.$post->ID.';
			//window.send_to_editor = window.send_to_termmeta;
			tb_show(\'\', \'media-upload.php?post_id=\' + post_id + \'&type=image&tab=gallery&TB_iframe=true\');
			return false;
		});
		
		</script>';
		echo '<div class="woocommerce_options_panel">';
		$attached_images = (array)get_posts( array(
			'post_type'   => 'attachment',
			'numberposts' => -1,
			'post_status' => null,
			'post_parent' => $post->ID ,
			'orderby'     => 'menu_order',
			'order'       => 'ASC',
		) );	
		
		if(is_array($attached_images) && count($attached_images)>0){
			
			echo '<a href="#" onclick="tb_show(\'\', \'media-upload.php?post_id='.$post->ID.'&type=image&TB_iframe=true\');return false;" style="margin-right:10px;margin-bottom:10px;"class="upload_image_button1" rel="'.$post->ID.'"><img src="'.woocommerce_placeholder_img_src().'" style="width:73px;" /><input type="hidden" name="upload_image_id[1]" class="upload_image_id" value="0" /></a>';
			
			$i = 0 ;
			foreach($attached_images as $item_thumb){
				$i++;
				if ( get_post_meta( $item_thumb->ID, '_woocommerce_exclude_image', true ) == 1 ) continue;
				$image_attribute = wp_get_attachment_image_src( $item_thumb->ID, 'thumbnail');
				echo '<a href="#" style="margin-right:10px;margin-bottom:10px;" class="upload_image_button" rel="'.$post->ID.'"><img src="'.$image_attribute[0].'" style="width:69px;border:2px solid #CCC" /><input type="hidden" name="upload_image_id['.$i.']" class="upload_image_id" value="'.$item_thumb->ID.'" /></a>';
			}
		}else{
			echo '<a href="#" class="upload_image_button" rel="'.$post->ID.'"><img src="'.woocommerce_placeholder_img_src().'" style="width:73px;" /><input type="hidden" name="upload_image_id[1]" class="upload_image_id" value="0" /></a>';
		}
		
		echo '</div>';
				
	}
}
add_action( 'add_meta_boxes', array('WC_Dynamic_Gallery_Meta_Boxes','woocommerce_meta_boxes_image') );
?>