var x;
function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

(function($) {
  /////////////////////////////////Start of Drag ajaxcall////////////////////
  var $range = $("#priceSlider");
			var value = $range.val();
			jQuery(document).ready( function($) {
			uiajaxCall( value,imageHeight() );
			});	 // Loading deafult values
				
			$range.on("change", function (){    //Load ajax value on slider Handle Change
			var value = $range.val();
			uiajaxCall( value,imageHeight() );
	});
 //Ajax call function	
	function uiajaxCall( value,height) {
		
		var ajaxurl = $("#ajaxURL").val();
		var sliderID = $("#sliderID").val();
			 var data = {
			action: 'ajax_response_ui_slider',
            post_var: value,
			slider_id: sliderID,
			height: height
			};
		// the_ajax_script.ajaxurl is a variable that will contain the url to the ajax processing file
	 	$.post(ajaxurl, data, function(response) {
			 $('.priceSliderContent').html(response);
	 	});
	 	return false;
  }
  
  /***************************************************/
  //Calculate the width of each column then send image height by ajax
  /******************************************************/
  function imageHeight() {
	  var width = $('.col_ui_slider').width();
	 return (70*width)/100;
  }
 })( jQuery );	