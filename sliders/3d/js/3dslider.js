var x;
function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

/////////////////////////////////Showing Slider with values/////////////////////////////
(function($) {

jQuery(document).ready(function(){
	var defaultval = parseInt($("#sliderDefaultValue").val());
	var start = parseInt($("#sliderRangeStart").val());
	var end = parseInt($("#sliderRangeEnd").val());
	
   $( "#slider-range-min" ).slider({
      range: "min",
      value: defaultval,
      min: start,
      max: end,
      slide: function( event, ui ) {
        //  setTimeout(delay, 1);
		var maximum;
		maximum = $("#slider-range-min").slider("option", "max");
		
        $( "#amount" ).text( "$" + numberWithCommas(ui.value) + "");
        $(".aModern, .bModern, .cModern, .dModern").width((ui.value/(maximum/100)) + "%");
		}
    });

    $(".ui-slider-handle").text("<>");

    $( "#amount" ).val( "$" + $( "#slider-range-min" ).slider( "value") + "");
	var startValue;
  startValue = defaultval;
  $( "#amount" ).text( "$" + numberWithCommas(startValue) + "");
  $(".aModern, .bModern, .cModern, .dModern").width( startValue/(end/100) + "%");
	
  });
  /////////////////////////////////Start of Drag ajaxcall////////////////////
  
  		var $range = $("#slider-range-min");
			
			jQuery(document).ready( function($) {
			var value = $range.slider("option", "value");
 				uiajaxCall( value,imageHeight() );
				}); // Loading deafult values
				
				$range.slider({
   change: function(event, ui) {
				var value = $range.slider("option", "value");
				//alert(value);
				uiajaxCall( value,imageHeight() );
 
	    }
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
	