<?php 
class Slider3d extends Sliders implements SliderProperties{
	public $sliderName = "My Slider";
	public $sliderRangeStart = "1";
	public $sliderRangeEnd = "10000";
	public $sliderDefaultValue = "5000";
	public $sliderCategories = "";
	public function __construct($sliderId){
	//	$this->pluginEnqueueScripts();
		if($sliderId!=""){
				$id = $sliderId;
				$dbOperation = new DBHandler();
				$results = $dbOperation->getDbValues("*"," where id='$id'");
				foreach ($results as $result) {
				$this->sliderName = $result->sliderName;
				$this->sliderRangeStart = $result->sliderRangeStart;
				$this->sliderRangeEnd = $result->sliderRangeEnd;
				$this->sliderDefaultValue = $result->sliderDefaultValue;
				$this->sliderCategories = $result->sliderCategories;
				}
				
		}//endif
		
	}
	public function pluginEnqueueScripts(){
		//wp_register_script( 'ui_slider_jquery_ui', UI_SLIDER_PLUGIN_URL.'/js/ui-sliderfbp.js', array(), null, false );
		//wp_enqueue_script( 'ui_slider_jquery_ui' );
		wp_register_script( 'ui_slider_3d_js', plugins_url( 'js/3dslider.js' , dirname(__FILE__) ),  array(), null, false );
		//wp_enqueue_script( 'ui_slider_jquery_include' );
		//wp_enqueue_script( 'ui_slider_jquery_ui' );
		wp_enqueue_script( 'ui_slider_3d_js' );
		wp_register_style( 'ui_slider_3d_css', plugins_url('css/3dslider.css', dirname(__FILE__)), false, null, 'all');
		wp_enqueue_style( 'ui_slider_3d_css' );
	}
	public function thumbNail(){
		echo '<img src="'.plugins_url('images/icon.png', dirname(__FILE__)).'" />';
	}
	public function getSliderProperties(){
		?>
	<table id="3dslider" style="width:500px;">
     <tr><td>Slider Name</td><td><input id="sdName" class="SliderInput" type="text" name="sliderName3d" value="<?php echo $this->sliderName; ?>" /></td></tr>
        <tr><td>Range Starts</td><td><input class="SliderInput" type="text" id="sdRangeStart"  name="sliderRangeStart3d" value="<?php echo $this->sliderRangeStart; ?>"/></td></tr>
  <tr><td>Range Ends</td><td><input id="sdRangeEnd" class="SliderInput" type="text"  name="sliderRangeEnd3d" value="<?php echo $this->sliderRangeEnd; ?>" /></td></tr>
     <tr><td>Default Step</td><td><input id="sdDefault" class="SliderInput" type="text"  name="sliderDefaultValue3d" value="<?php echo $this->sliderDefaultValue; ?>" /></td></tr>
 
      <tr><td>Filter Categories</td><td><select name="sliderCategories3d[]" multiple>
  <?php   //Categories in add new
  
   $args = array(
  'orderby' => 'name',
  'parent' => 0,
  'hide_empty' => 0,
  );
$categories = get_categories( $args );
  foreach ($categories as $cat) {
	  //Make sure Saved cats selected by default
	   $ifSelected ="";
	  	  if(strpos($this->sliderCategories,$cat->name)!== false) {
		 $ifSelected = 'selected="selected"';
	  		}
		else {
				$ifSelected = '';
			}
	   echo '<option value="'.$cat->name.'" '.$ifSelected.'>'.$cat->name.'</option>';
	   
	   } ?>
  
</select><br/><br/><span style="font-size:12px;">* Leave to show all & press Ctlr for multiple selection.</span></td></tr>
 
	</table>

    <?PHP
	} //END OF METHOD
	
	public function slider3d()
	{
				?>
<?php $this->pluginEnqueueScripts(); ?>
<input id="sliderDefaultValue" type="hidden" value="<?php echo $this->sliderDefaultValue; ?>" />
<input id="sliderRangeStart" type="hidden" value="<?php echo $this->sliderRangeStart; ?>" />
<input id="sliderRangeEnd" type="hidden" value="<?php echo $this->sliderRangeEnd; ?>" />
  <div class="cubeModern">
    <div class="aModern"></div>
    <div class="bModern"></div>
    <div class="cModern"></div>
    <div class="dModern"></div>
    <div id="slider-range-min"></div>
  </div>
  <div id="amount"></div>

	<?php
	} //END OF METHOD
}
?>