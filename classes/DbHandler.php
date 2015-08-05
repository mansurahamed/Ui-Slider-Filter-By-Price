<?php
 class DbHandler{
	 private $dbtable;
	 private $wpdb;
	 public $sliderName = "Demo Slider";
	public $sliderWidth = "100%";
	public $sliderRangeStart = "1";
	public $sliderRangeEnd = "10000";
	public $sliderSteps = "1,1000,3000,5000,8000,10000";
	public $sliderDefaultValue = "5000";
	public $sliderColor = "#529e0e";
	public $sliderCategories = "";
	public $sliderStyle = "3d";
	public $sliderOutput = "1,2,3,4";
	 public function __construct(){
		global $wpdb;
		$this->wpdb = &$wpdb;
		$this->dbTable = $this->wpdb->prefix."price_ui_slider";
	 } //END OF METHOD
	 
	 public function createTable(){
		 if( $this->wpdb->get_var("SHOW TABLES LIKE '" . $this->dbTable  . "'") === $this->dbTable . '' ) {
 				// The database table exist
		} 
		else { //We create New table, Table does not exist

	$sqlQuery="CREATE TABLE ".$this->dbTable." (
  id INT NOT NULL AUTO_INCREMENT,
  PRIMARY KEY ( id ) ,
  sliderName VARCHAR( 200 ),
  sliderWidth VARCHAR( 30 ),
  sliderRangeStart VARCHAR( 30 ),
  sliderRangeEnd VARCHAR( 30 ),
  sliderDefaultValue VARCHAR( 30 ),
  sliderSteps VARCHAR( 400 ),
  sliderColor VARCHAR( 20 ),
  sliderCategories VARCHAR( 30 ),
  sliderStyle VARCHAR( 30 ),
  sliderOutput VARCHAR( 300 )
);";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sqlQuery );
		$rows_affected = $this->wpdb->insert( $this->dbTable, array('sliderName' => 'Demo Slider','sliderWidth' => $this->sliderWidth ,'sliderRangeStart' => $this->sliderRangeStart ,'sliderRangeEnd' => $this->sliderRangeEnd ,'sliderDefaultValue' => $this->sliderDefaultValue,'sliderSteps' => $this->sliderSteps,'sliderColor' => $this->sliderColor ,'sliderCategories' => $this->sliderCategories,'sliderStyle' => $this->sliderStyle,'sliderOutput' => $this->sliderOutput) ) or die(mysql_error());
				} //End of else
	 } //END OF METHOD
	 
	 public function getDbValues($column,$condition){
		  $sql = "SELECT $column FROM ".$this->dbTable."$condition";
		  $result = $this->wpdb->get_results($sql) ;
		  return $result;
	 }
	 public function countLastQuery(){
		  return $this->wpdb->num_rows;
	 }
	 public function deleteDbEntry($entryID){
		 $results = $this->wpdb->query("delete FROM ".$this->dbTable." where id='".$entryID."'");
		 return 0;
	 }
	 public function updateSlider($values,$sliderID){
		 $sliderName;
		 $sliderRangeStart;
		 $sliderRangeEnd;
		 $sliderDefaultValue ;
		 $sliderWidth = "500px";
		 $sliderSteps = "1,1000,3000,5000,8000,10000";
		 $sliderColor = "#529e0e";
		 $sliderCategories = "";
		 $sliderOutputRaw = preg_replace("/[^0-9]/","",$values['output']);
		 $arr = str_split($sliderOutputRaw, 1);
		 $sliderOutput = implode(",",$arr);
		 global $wpdb;
		 		$sliderType = $values['sliderStyle'];
				switch($sliderType){
					case "3d";
						$sliderName = $values['sliderName3d'];
						$sliderRangeStart = $values['sliderRangeStart3d'];
						$sliderRangeEnd = $values['sliderRangeEnd3d'];
						$sliderDefaultValue = $values['sliderDefaultValue3d'];
						if(intval($sliderDefaultValue)>intval($sliderRangeEnd)){
							$sliderDefaultValue = $sliderRangeEnd;
						}
						if(isset( $values['sliderCategories3d'])){
						$sliderCatArray = array();
						$sliderCatArray = $values['sliderCategories3d'];
						$sliderCategories = implode(",",$sliderCatArray);
						}
					break;
					case "classic":
						$sliderName = $values['sliderNameClassic'];
						$sliderRangeStart = $values['sliderRangeStartClassic'];
						$sliderRangeEnd = $values['sliderRangeEndClassic'];
						$sliderDefaultValue = $values['sliderDefaultValueClassic'];
						if(intval($sliderDefaultValue)>intval($sliderRangeEnd)){
							$sliderDefaultValue = $sliderRangeEnd;
						}
						$sliderWidth = $values['sliderWidthClassic'];
						$widthInt = intval($sliderWidth);
						
						if($widthInt<100){
						$sliderWidth = "400"."px";
						}
						$sliderSteps = $values['sliderStepsClassic'];
						$sliderColor = $values['sliderColorClassic'];	
						if(isset( $values['sliderCategoriesClassic'])){
						$sliderCatArray = array();
						$sliderCatArray = $values['sliderCategoriesClassic'];
						$sliderCategories = implode(",",$sliderCatArray);
						}
					break;
				}
		 
		 
		 if($sliderID == "") { //Save slider 
		 
		 $widthInt = intval($sliderWidth);
	$sliderWidth = $widthInt."px";
	  $result = $wpdb->insert( $this->dbTable, array('sliderName' => $sliderName ,'sliderWidth' => $sliderWidth ,'sliderRangeStart' => $sliderRangeStart ,'sliderRangeEnd' => $sliderRangeEnd ,'sliderDefaultValue' => $sliderDefaultValue,'sliderSteps' => $sliderSteps,'sliderColor' => $sliderColor ,'sliderCategories' => $sliderCategories,'sliderStyle' => $sliderType,'sliderOutput' => $sliderOutput),array( '%s', 
		'%s'  ))  ;
		if($result){
			echo "Saved";?>
            <script language="javascript">
			$("#sliderid").val(<?php echo $this->wpdb->insert_id; ?>);
		</script>
            <?php
		}
		else {
			?>
		<script>
  $('.of-save-save').css('background-image','url(<?php echo plugins_url( "images/stop.png" , dirname(__FILE__) );  ?>)');
</script>
<?php
echo "Error saving";
			die(mysql_error()); 
			}
		 }
		 else { //update Slider
		 
		 	$result = $wpdb->update( $this->dbTable, array('sliderName' => $sliderName ,'sliderWidth' => $sliderWidth ,'sliderRangeStart' => $sliderRangeStart ,'sliderRangeEnd' => $sliderRangeEnd ,'sliderDefaultValue' => $sliderDefaultValue,'sliderSteps' => $sliderSteps, 'sliderColor' => $sliderColor ,'sliderCategories' => $sliderCategories,'sliderStyle' => $sliderType,'sliderOutput' => $sliderOutput ),array( 'id' => intval($sliderID))  ) ;
			if($result){
			echo "Saved";
		}
		else{
		
echo "Saved";
			die(mysql_error()); 
			}
		 }
	 }
 } //END OF CLASS
 ?>