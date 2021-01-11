

/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	//Ajax
jQuery(document).ready(function($) {

	$("#submitbrand").click(function(){
	var id=$("#getid").val();
	var name=$("#getname").val();
	jQuery.ajax({
		type:'POST',
		url:frontendajax.ajaxurl,
		data:{
			action:'brand_action',
			id:id,
			name:name
			},
			success:function(data){
				console.log(data);
			}
		})
	});
});
	


