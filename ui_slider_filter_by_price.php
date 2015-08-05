<?php
/**
 * Plugin Name: UI Slider Filter By Price
 Plugin URI: http://www.wolopress.com/ui-slider-filter-by-price/
 * Description: UI Slider Filter By Price is a perfect tool for filtering posts  of any categories by a post price field. Posts load instantly with jQuery ui slider drag. It automatically generates an item price custom field. You can modify and integrate 3D or classic ui slider in any post/page easily by shortcodes. Filter results are fully responsive.
 * Version: 1.0
 * Author: Mansur Ahamed
 * Author URI: http://www.wolopress.com/
 * License: GPLv2 http://www.gnu.org/licenses/gpl-2.0.html
 */
 define( 'UI_SLIDER_PLUGIN_URL', plugins_url('', __FILE__ ) );
 
 class PluginMenu{
	  private $dbtable;
	 public function __construct(){
		 global $wpdb;
		$this->wpdb = &$wpdb;
		$this->dbTable = $this->wpdb->prefix."price_ui_slider";
		 add_action( 'admin_menu', array(&$this,'registerPluginMenuPages') );
		 //register_activation_hook( __FILE__, array(&$this,'pluginActivate'));
	 } //END OF METHOD
	 static function pluginActivate() {   //CREATING TABLE FOR KEEPING PLUGIN DATA
		$pluginTableDefine = new DbHandler();
		$pluginTableDefine->createTable();
		}  // END OF METHOD

	 public function pluginDeactivate(){
	 } //END OF METHOD
	 
	 public function registerPluginMenuPages() { // ADMIN MENU PAGE REGISTER
		add_menu_page('UI Sliders', 'UI Sliders', 'edit_themes', 'ui-sliders', array(&$this,'manageSliders'),plugins_url('images/icon.png', __FILE__));
  		add_submenu_page('ui-sliders', 'Current Sliders Listings', 'All Sliders', 'edit_themes','ui-sliders',  array(&$this,'manageSliders'));
 	 	add_submenu_page('ui-sliders', 'Slider Properties', 'Add New', 'edit_themes', 'add-slider',  array(&$this,'addNewSlider') );
		add_submenu_page('ui-sliders', 'Uninstall Ui Slider', 'Uninstall', 'edit_themes', 'uninstall-ui-slider',  array(&$this,'unInstall') );
	}  // END OF METHOD
	
	public function manageSliders(){
		$sliderManager = new SliderManager();
		$sliderManager->sliderManagerBody();
	} //END OF METHOD
	public function addNewSlider(){
		$edit = false;
		if(isset($_GET["id"])){
				$id = $_GET["id"];
				$edit = true;
			}
			
		$slider = new Sliders();
		$slider->getSliderType();
	} //END OF METHOD
	public function unInstall() { // FUNCTION RUNS ON PLUGIN DEACTIVATION DROPPING TABLE OPTIONAL
	
	if(isset($_POST["hideme"])) {
		  global $wpdb;
		$result = $wpdb->query("DROP TABLE IF EXISTS ".$this->dbTable."") or die("Uninstallation Error.");
		 deactivate_plugins( plugin_basename(__FILE__) );
		 ?>
         <script>

    window.location.assign("<?php echo admin_url(); ?>")

</script>
         <?php
		}
	else {
		
	?>
    <div style="max-width:400px; background:#fff; border: solid 1px #666; padding:20px; margin-top:20px;">
    <h2>Uninstall Ui Slider Filter By Price</h2>
    <img style="float:right" src="<?php echo plugins_url('/images/uninstall.png', __FILE__)?>" />
    <p>This will remove <br />
<br />
<span style="color:red">* - Database Table <br />
<br />

* - All sliders <br />
<br />

* - All settings </span>

<br /><br /> Are you sure ? </p> <form id="unInstallFrm" action="admin.php?page=uninstall-ui-slider" method="post" />
 <input name="hideme" type="hidden" value="hide" />
 <input type="submit" class="button-primary" value="Uninstall" />
 
</form>
  </div>
    <?php
			} //End if
		}  // END OF METHOD
 } //END OF CLASS
 require_once( 'classes/SliderManager.php');
 require_once( 'classes/ShortCode.php');
 require_once( 'classes/DbHandler.php');
  require_once( 'classes/PriceCustomField.php');
 require_once(  'sliders/Sliders.php');
 require_once( 'sliders/3d/class/Slider3d.php');
 require_once( 'sliders/classic/class/SliderClassic.php');
 /***************************Statements Section**********************/
 

 register_activation_hook( __FILE__, array('PluginMenu','pluginActivate'));
  $pluginMenu = new PluginMenu();
  $piceField = new PriceCustomField();
 
 