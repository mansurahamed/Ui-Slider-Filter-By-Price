// JavaScript Document
 var form_clean;
  var j;
  j =0;
 jQuery(document).ready(function($){
	// alert($("#sliderid").val());
	 if($("#sliderid").val()!=""){j++;}
	//CSS active menu class
	$('a.tabmenu').click(function(){
    $('a.tabmenu').removeClass("ulactive");
    $(this).addClass("ulactive");
});
	
	
/***************Slider type selection and input filter	**********************************/
	$('#sdName').filter_input({regex:'[a-z0-9]'});
	$('#sdWidth').filter_input({regex:'[0-9px%]'});
	$('#sdRangeStart').filter_input({regex:'[0-9]'});
	$('#sdRangeEnd').filter_input({regex:'[0-9]'});
	$('#sdSteps').filter_input({regex:'[0-9,]'});
	$('#sdDefault').filter_input({regex:'[0-9]'});
	$('#sdColor').filter_input({regex:'[a-z0-9#]'});
	/**************************************************************/ //Only to hide field for modern slider
	  if($('#radioModern').is(':checked')) {
		  $('#3dslider').show(); 
	  	 $('#sliderClassic').hide();
			}
			else
			{
				$('#3dslider').hide(); 
	  	 $('#sliderClassic').show();
			}
		$('#radioModern').click(function() {
   if($('#radioModern').is(':checked'))
   	 { 
		 $('#3dslider').show(); 
	  	 $('#sliderClassic').hide();
	  }
});
	$('#radioClassic').click(function() {
   if($('#radioClassic').is(':checked'))
   	 { 
 		$('#3dslider').hide(); 
	  	 $('#sliderClassic').show();
	  }
});

form_clean = $("#uiSliderFrm").serialize();  //Check if form value change

	/*********************Colorpicker******************************/
  $('.colorPick').each( function() {
           
                $(this).minicolors({
                    control: $(this).attr('data-control') || 'hue',
                    defaultValue: $(this).attr('data-defaultValue') || '',
                    inline: $(this).attr('data-inline') === 'true',
                    letterCase: $(this).attr('data-letterCase') || 'lowercase',
                    opacity: $(this).attr('data-opacity'),
                    position: $(this).attr('data-position') || 'bottom left',
                    change: function(hex, opacity) {
                        var log;
                        try {
                            log = hex ? hex : 'transparent';
                            if( opacity ) log += ', ' + opacity;
                            console.log(log);
                        } catch(e) {}
                    },
                    theme: 'default'
                });

            });
	

/***************Slider type selection and input filter	**********************************/
			var order = "recordsArray[]=1&recordsArray[]=2&recordsArray[]=3&recordsArray[]=4";
					   
	$(function() {
		$("#sortable").sortable({ update: function() {			
			order = $(this).sortable("serialize"); 										 
		}								  
		});
	});
 form_clean+="&output="+order.replace(/&/g , "@");

/********************************Ajax Call**************************/
 						   
$("input[name='uisave']").on("click", function(){
	
	$('.of-save-save').css('background-image','url("'+$("#siteurl").val()+'/images/button_check.png")');
	 var form_dirty = $("#uiSliderFrm").serialize();
	 form_dirty+="&sliderColorClassic="+$("#sdColor").val().replace('#', '');
	 //alert(form_clean);
	 form_dirty+="&output="+order.replace(/&/g , "@");
//alert(form_dirty);
    if(form_clean == form_dirty&&j) {
		$(".of-save-popup ").show();
		//$('.of-save-save').css('background-image','url("'+$("#siteurl").val()+'../images/stop.png")');
          $(".of-save-save").html("Saved");
		return false;
	}
	else
	{
		j++;
		
	
var ajaxRequest;
    /* Get from Form elements values */
    var values = $("#uiSliderFrm").serialize();

	values+="&output="+order.replace(/&/g , "@");
	if($("#sliderid").val()!=""){values+="&sliderid="+$("#sliderid").val();}
	values+="&sliderColorClassic="+$("#sdColor").val();
	form_clean = form_dirty;
//alert(values);
    /* Send the data using post and put the results in a div */
    /* I am not aborting previous request because It's an asynchronous request, meaning 
       Once it's sent it's out there. but in case you want to abort it  you can do it by  
       abort(). jQuery Ajax methods return an XMLHttpRequest object, so you can just use abort(). */
	   
	   var data = {
                action: "plugin_ajax_request",
                values: values
            }
       ajaxRequest= $.ajax({
            url: ajaxurl,
            type: "post",
            data: data
        });

      /*  request cab be abort by ajaxRequest.abort() */

     ajaxRequest.done(function (response, textStatus, jqXHR){
          // show successfully for submit message
		  $(".of-save-popup ").show();
          $(".of-save-save").html(response);
     });

     /* On failure of request this function will be called  */
     ajaxRequest.fail(function (){

       // show error
$('.of-save-save').css('background-image','url("'+$("#siteurl").val()+'/images/stop.png")');
       $(".of-save-save").html('Error');
     });
	}//endif
});//End of ajax call


/********************************Ajax Call**************************/
//Fadding the save message
 setInterval(function() {
        $(".of-save-popup").hide('blind', {}, 500)
    }, 4000);



});




