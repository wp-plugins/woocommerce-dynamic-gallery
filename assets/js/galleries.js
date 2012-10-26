// JavaScript Document
jQuery(document).ready(function() {
	jQuery('.preview_gallery').click(function(){
		var url = jQuery(this).attr("href");
		var order = jQuery('#mainform').serialize();
		tb_show('Dynamic gallery preview', url+'&width=700&height=700&action=woo_dynamic_gallery&KeepThis=false&'+order);
		return false;
	});
});	
