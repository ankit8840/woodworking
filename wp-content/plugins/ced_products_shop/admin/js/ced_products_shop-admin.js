
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
	
	jQuery(document).ready(function($) {
		$("#mess").hide();
		$("#publish").on('click',function(e){
			e.preventDefault();
			var rprice=$("#getrprice").val();
			var dprice=$("#getdprice").val();
			var invn=$("#invn").val();
			
			var rp = parseInt(rprice);
			var dp = parseInt(dprice);
			var inv = parseInt(invn);
			console.log(rprice);
			console.log(dprice);
			if(rp<dp){
				$("#mess").html("Regular price should be greater then discount price");
				$("#mess").css("color", "red");
				$("#mess").show();
			}
			else if(inv<0){
				$("#error").html("Inventroy should be Positive");
				$("#error").css("color", "red");
				$("#error").show();
			}else{
				$("#post").submit();
			}
			
		  });

});
