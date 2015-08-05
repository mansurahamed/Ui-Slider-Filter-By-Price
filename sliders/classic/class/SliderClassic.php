<?php
class SliderClassic extends Sliders implements SliderProperties{
	public $sliderName = "My Slider";
	public $sliderWidth = "100%";
	public $sliderRangeStart = "1";
	public $sliderRangeEnd = "10000";
	public $sliderSteps = "1,1000,3000,5000,8000,10000";
	public $sliderDefaultValue = "5000";
	public $sliderColor = "529e0e";
	public $sliderCategories = "";
	public function __construct($sliderId){
		//$this->pluginEnqueueScripts();
		if($sliderId!=""){
				$id = $sliderId;
				$dbOperation = new DBHandler();
				$results = $dbOperation->getDbValues("*"," where id='$id'");
				foreach ($results as $result) {
				$this->sliderName = $result->sliderName;
				$this->sliderWidth = $result->sliderWidth;
				$this->sliderRangeStart = $result->sliderRangeStart;
				$this->sliderRangeEnd = $result->sliderRangeEnd;
				$this->sliderDefaultValue = $result->sliderDefaultValue;
				$this->sliderSteps = $result->sliderSteps;
				$this->sliderColor = str_replace("#","",$result->sliderColor);
				
				$this->sliderCategories = $result->sliderCategories;
				}
				
		}//endif
		
		}
	public function pluginEnqueueScripts(){
			wp_register_script( 'ui_slider_classic_ajax_js', plugins_url( 'js/classicajax.js' , dirname(__FILE__) ),  array(), null, false );
		wp_enqueue_script( 'ui_slider_classic_ajax_js' );
		wp_register_style( 'ui_slider_classic_css1', plugins_url('css/ion.rangeSlider.css', dirname(__FILE__)), false, null, 'all');
		wp_register_style( 'ui_slider_classic_css2', plugins_url('css/ion.rangeSlider.skinHTML5.css', dirname(__FILE__)), false, null, 'all');
		wp_register_style( 'ui_slider_classic_css3', plugins_url('css/normalize.css', dirname(__FILE__)), false, null, 'all');
		wp_register_style( 'ui_slider_classic_css', plugins_url('css/classicslider.css', dirname(__FILE__)), false, null, 'all');
		wp_enqueue_style( 'ui_slider_classic_css' );
		wp_enqueue_style( 'ui_slider_classic_css1' );
		wp_enqueue_style( 'ui_slider_classic_css2' );
		wp_enqueue_style( 'ui_slider_classic_css3' );
	}
		public function thumbNail(){
			echo '<img src="'.plugins_url('images/icon.png', dirname(__FILE__)).'" />';
	}
	public function getSliderProperties(){
		?>
			<table id="sliderClassic">
     <tr><td>Slider Name</td><td><input id="sdName"  type="text" name="sliderNameClassic" value="<?php echo $this->sliderName; ?>" /></td></tr>
      <tr id="slider_width"><td>Slider Width</td><td><input id="sdWidth" type="text" name="sliderWidthClassic" value="<?php echo $this->sliderWidth; ?>" /><br />
 <span style="font-size:12px;"></span></td></tr>
  <tr><td>Range Starts</td><td><input  type="text" id="sdRangeStart"  name="sliderRangeStartClassic" value="<?php echo $this->sliderRangeStart; ?>" cols="20" rows="4" /></td></tr>
  <tr><td>Range Ends</td><td><input id="sdRangeEnd" type="text"  name="sliderRangeEndClassic" value="<?php echo $this->sliderRangeEnd; ?>" cols="20" rows="4" /></td></tr>
 <tr id="slider_steps"><td>Range steps</td><td><textarea id ="sdSteps"   name="sliderStepsClassic" cols="20" rows=""><?php echo $this->sliderSteps; ?></textarea><br /><span style="font-size:12px;"> * Seperated by comma </span></td></tr>
     <tr><td>Default Step</td><td><input id="sdDefault"  type="text"  name="sliderDefaultValueClassic" value="<?php echo $this->sliderDefaultValue; ?>" cols="20" rows="4"  /><br /><span id="default_step_span" style="font-size:12px;"> * Choose default step from above.</span></td></tr>
      <tr id="slider_color"><td>Slider Color </td><td>
       <input type="text" id="sdColor" name="sliderColorClassic" class="colorPick" style="height:30px; width:240px; letter-spacing:1.5px; font-weight:bold;" data-control="green" value="<?php echo $this->sliderColor; ?>"></td></tr>
      <tr><td>Filter Categories</td><td><select name="sliderCategoriesClassic[]" multiple>
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
  
</select><br /><span style="font-size:12px;">* Leave this to show all categories</span></td></tr>
</table>
<?php
	}
/*********************************************************************************/

		public function sliderClassic()
	{
		?>
<?php  $this->pluginEnqueueScripts(); 
$this->sliderColor = "#".$this->sliderColor;
?>

 <style>

 .irs {
		width:<?php	echo $this->sliderWidth;?> !important;
		margin:0 auto !important;
		margin-bottom:30px !important;
	}
    
	.irs-bar {
    border-top: 1px solid <?php echo $this->sliderColor; ?>;
    border-bottom: 1px solid <?php echo $this->sliderColor; ?>;
    background: <?php echo $this->sliderColor; ?>;
	}
    .irs-bar-edge {
    border: 1px solid <?php echo $this->sliderColor; ?>;
    background: <?php echo $this->sliderColor; ?>;
    }

.irs-from, .irs-to, .irs-single {

    background: <?php echo $this->sliderColor; ?>;
	}

.irs-grid-pol {
    background: <?php echo $this->sliderColor; ?>;
	}

.irs-grid-text {
    color: <?php echo $this->sliderColor; ?>;
	}
 </style>
		<?php


?>

        <input type="text" id="priceSlider" value="" name="range" />
		<script language="javascript">
     $("#priceSlider").ionRangeSlider({
     min: <?php echo $this->sliderRangeStart; ?>,
	 max: <?php echo $this->sliderRangeEnd; ?>,
	 from: <?php echo  $this->getDefaultStep($this->sliderDefaultValue,$this->sliderSteps); ?>,
     values: [<?php echo $this->sliderSteps; ?>],
	 prefix: "$"
});
 </script>
		<?php
        
	} // END OF METHOD
	public function getDefaultStep($stepName, $stepString) {
		$stepArray = explode(",",$stepString);
		$key = array_search($stepName, $stepArray);
		return $key;
	}
}
?>