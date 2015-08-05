<?php
add_action("wp_enqueue_scripts", array('Sliders','addScriptToClassicSlider'));
add_action( 'wp_ajax_plugin_ajax_request', array('Sliders','sliderAjax') );

interface SliderProperties{
	public function getSliderProperties();
}

class Sliders{
	public $sliderName;
	public $sliderType;
	public $categories;
	public $sliderOutput = "1,2,3,4";
	public $sliderID = "";
	public function __construct(){
		$this->sliderType = "3d";
		$this->pluginEnqueueScripts();
		if(isset($_GET["id"])){
				$id = $_GET["id"];
				$this->sliderID = $id;
				$dbOperation = new DBHandler();
				$results = $dbOperation->getDbValues("*"," where id='$id'");
				foreach ($results as $result) {
					$this->sliderType =  $result->sliderStyle;
					$this->sliderOutput =  $result->sliderOutput;
				}
		}//endif
//	add_action( 'wp_ajax_nopriv_my_ajax',array('Sliders','sliderAjax') );
		}
				
				static function addScriptToClassicSlider(){
	wp_register_script( 'ui_slider_classic_js', plugins_url( 'sliders/classic/js/classicslider.js' , dirname(__FILE__) ),  array(), null, false );
			wp_enqueue_script( 'ui_slider_classic_js' );
			wp_enqueue_script('jquery-ui-slider'); //Default wordpress jquery UI 
	
		}	//This will add jquery ui
	static function sliderAjax() {
	
		parse_str($_POST['values'], $array_of_vars);
		$sliderID="";
   	    if(isset( $array_of_vars['sliderid'])){
				$sliderID = $array_of_vars['sliderid'];
		}
	   //if($sliderID=="") save else update
		$dbOperations = new DbHandler();
		$dbOperations->updateSlider($array_of_vars,$sliderID);
?>

<?php		

	die();
		} // END OF METHOD
	public function pluginEnqueueScripts(){
	wp_register_script( 'ui_slider_jquery_ui', plugins_url( 'js/ui-sliderfbp.js' , dirname(__FILE__) ), array(), null, false );

		wp_register_script( 'ui_slider_tabs_filter', plugins_url( 'js/tabs-filter.js' , dirname(__FILE__) ), array(), null, false );
		wp_register_script( 'ui_slider_input_filter', plugins_url( 'js/jquery_filter_input.js' , dirname(__FILE__) ),  array(), null, false );
		wp_register_script( 'ui_slider_color_picker',  plugins_url( 'extensions/colorpicker/jquery.minicolors.js' , dirname(__FILE__) ),  array(), null, false );
		//wp_enqueue_script( 'ui_slider_jquery_include' );
		wp_enqueue_script( 'ui_slider_jquery_ui' );
		wp_enqueue_script( 'ui_slider_color_picker' );
		wp_enqueue_script( 'ui_slider_tabs_filter' );
		wp_enqueue_script( 'ui_slider_input_filter' );
		wp_register_style( 'ui_slider_tabs', plugins_url('css/tabs.css', dirname(__FILE__)), false, null, 'all');
		wp_register_style( 'ui_slider_color_picker_css', plugins_url('extensions/colorpicker/jquery.minicolors.css', dirname(__FILE__)), false, null, 'all');
		wp_register_style( 'ui_sortable_css', plugins_url('css/ui-sortable.css', dirname(__FILE__)), false, null, 'all');
		wp_enqueue_style( 'ui_slider_tabs');
		wp_enqueue_style( 'ui_slider_color_picker_css' );
		wp_enqueue_style( 'ui_sortable_css' );
		
	}
	public function getSliderType(){
		$slider3d = new Slider3d($this->sliderID);
		$sliderClassic = new SliderClassic($this->sliderID);
		?>
        
        <script type='text/javascript' src='http://localhost/test/wp-includes/js/jquery/ui/core.min.js?ver=1.11.4'></script>
<script type='text/javascript' src='http://localhost/test/wp-includes/js/jquery/ui/slider.min.js?ver=1.11.4'></script>	
     
                    <div id="ie-test">
                    <?php // If Edit slider passing slider id
                    	if(isset($_GET["id"])){
				$id = $_GET["id"];
				
			} else $id = "";?>
            
                    <input id="sliderid" name="sliderID" type="hidden" value="<?php echo $id ?>" />
                    <input id="siteurl" name="siteUrl" type="hidden" value="<?php echo plugins_url( '' , dirname(__FILE__) ); ?>" />
                 <!-- Saved of fail to save message -->
				<div id="of-popup-save" class="of-save-popup">
		<div class="of-save-save"></div>
	</div> <!-- ...... -->
    
                <ul id="boxLinks" class="group">
                	<li><a class="tabmenu ulactive"  href="#slider-type">Slider Type</a></li>
                	<li><a class="tabmenu" href="#slider-properties">Properties</a></li>
                	<li><a class="tabmenu" href="#slider-output">Output</a></li>
                    <li><span class="submit_btn">
                    <form id="uiSliderFrm">
                    <input type="submit" name="uisave" class="button-primary" onclick="return false;" value="Save Slider" /></span></li>
                </ul>
                
                <div id="box">
                	<div id="slider-type" class="box">
		 <table width="500" >
    <tr>
      <td>
       <h2>Choose slider style</h2><br />

        <h1>What is your budget?</h1>
          <label>
          <?php	// Find the Slider Style from Database
		  	
		  ?>
            <input type="radio" id="radioModern" name="sliderStyle" value="3d" <?php if($this->sliderType == "3d") {echo 'checked';} ?>>
            <strong>3D Modern</strong></label> <div><?php $slider3d->thumbNail(); ?> </div>
          <br />
          <label>
            <input type="radio" id="radioClassic" name="sliderStyle" value="classic" <?php if($this->sliderType == "classic") {echo 'checked';} ?>  >
            <strong>Classic</strong></label> <br /> <br />

			<?php $sliderClassic->thumbNail(); ?>
                   <br />
           </td></tr>
    <tr><td> </td></tr>
  

    </table>

<h3 align="center" style="color:#eee;">UI Slider Filter By price 1.0 </h3>
                 
                       <!--[if IE]><b>.</b><![endif]-->
                     </div>
                	<div id="slider-properties" class="box"><?php
					$slider3d->getSliderProperties();
					$sliderClassic->getSliderProperties();
					
					?>
                    </form>

<h3 align="center" style="color:#eee;">UI Slider Filter By price 1.0 </h3>
                 
                     <!--[if IE]><b>.</b><![endif]--></div>

                	<div id="slider-output" class="box">

         
<h2 align="center">Drag And drop Output order :</h2>
<ul id="sortable">
<?php
$sliderOU = explode(",",$this->sliderOutput);
foreach($sliderOU as $key){
	if($key == 1) {echo '<li id="recordsArray_1" class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Post Title</li>';}
	if($key == 2) {echo '<li id="recordsArray_2" class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Featured image</li>';}
	if($key == 3) {echo '<li id="recordsArray_3" class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Post content</li>';}
	if($key == 4) {echo '<li id="recordsArray_4" class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Price</li>';}
}
?>

</ul>
* Automatically first image of post is grabbed if no featured image found!<br />
<br />

* Post content is automatically filtered to reduce length.
<br /><br />

<h3 align="center" style="color:#eee;">UI Slider Filter By price 1.0 </h3>
                 
                     <!--[if IE]><b>.</b><![endif]--></div>
                </div>
            
            </div> <!-- End of div ie-test-->
        
     
     
    <?php
	} //END OF METHOD
//	abstract public function getSliderProperties();
} //END OF CLASS


?>