<?php 
class SliderManager {
	 public function __construct(){
		 $this->pluginEnqueueScripts();
	 } //END OF METHOD
	 public function pluginEnqueueScripts(){
		wp_register_style( 'ui_slider_manger_style', plugins_url('css/slider-manager-style.css',dirname(__FILE__) ), false, null, 'all');
		wp_enqueue_style( 'ui_slider_manger_style' );
	 } //END OF METHOD
	 public function sliderManagerBody(){
		$dbOperations = new DbHandler();
		$task = "";
		$id = 0;
		$page = 1;
		if(isset($_GET["pagination"])) {
			$page = $_GET["pagination"];
		}
		
		if(isset( $_GET["task"] )) {
			$task = $_GET["task"];
			if(isset( $_GET["id"] )) { $id = $_GET["id"]; }
		}
		switch($task) {
			case "delete_slider":
				$dbOperations->deleteDbEntry($id);
			default
			
	?>
	<div class="wrap">
		<div class="slider-options-head">
		<div style="float: left;">
			<div><a href="http://www.wolopress.com/ui-slider-filter-by-price/documentation/" target="_blank">Documentation</a></div>
			<div>This user manual allows you to configure the Slider options. <a style="font-size:16px; font-weight:bold;" href="http://www.wolopress.com/ui-slider-filter-by-price/demo/" target="_blank">View Demo Slider Here</a></div>
		</div>
		<div style="float: right;">
			<a class="header-logo-text" href="http://www.wolopress.com/donate/" target="_blank">
				<div><img width="200px" src="<?php echo plugins_url('images/DONATE.png',dirname(__FILE__) ); ?>" /></div>
				<div>Buy me a cup of Cofee!</div>
			</a>
		</div>
	</div>
	<div style="clear:both;"></div>
	<div id="poststuff">
		<div id="sliders-list-page">
			<form method="post"  onkeypress="doNothing()" action="admin.php?page=ui-sliders" id="admin_form" name="admin_form">
			<h2>Ui Slider Filter by Price
				<a onclick="window.location.href='admin.php?page=add-slider'" class="add-new-h2" >Add New Slider</a>
			</h2>
	<?php  //$this->message(); ?>
    <div class="tablenav top" style="width:95%">
    <div class="alignleft actions"">
				<label for="search_events_by_title" style="font-size:14px">Filter: </label>
					<input type="text" name="searchText" value="" id="search_events_by_title" onchange="clear_serch_texts()">
			</div>
			<div class="alignleft actions">
				<input type="button" value="Search" onclick="document.getElementById('page_number').value='1'; document.getElementById('search_or_not').value='search';
				 document.getElementById('admin_form').submit();" class="button-secondary action">
				 <input type="button" value="Reset" onclick="window.location.href='admin.php?page=ui-sliders'" class="button-secondary action">
			</div>	<div class="tablenav-pages">
            <?php  // Geting All Sliders from Database
			
			if(isset($_POST["searchText"]) && ($_POST["searchText"]!="") ) {
				 $result = $dbOperations->getDbValues("*"," where sliderName like '%".$_POST["searchText"]."%'");
				}
			else {
				 $result = $dbOperations->getDbValues("*"," order by id DESC");
				}
				$itemCount =  $dbOperations->countLastQuery();
				?>
    <span class="displaying-num"><?php echo  $itemCount ; ?> items</span>
		</span>
	</div>
  </div >
    <input type="hidden" id="page_number" name="page_number" value="1"  />
    
    <input type="hidden" id="search_or_not" name="search_or_not" value=""    />
			<table class="wp-list-table widefat fixed pages" style="width:95%;">
				<thead>
				 <tr>
					<th scope="col" id="id" style="width:30px" ><span>ID</span><span class="sorting-indicator"></span></th>
					<th scope="col" id="name" style="width:85px" ><span>Name</span><span class="sorting-indicator"></span></th>
					<th scope="col" id="prod_count"  style="width:75px;" ><span>Shortcode</span><span class="sorting-indicator"></span></th>
					<th style="width:40px">Delete</th>
				 </tr>
				</thead>
				<tbody>
                <?php  // Geting Sliders from Database
				//echo "soikot".$wpdb->num_rows;
				if (!$itemCount) { //Show blank template if no item
				?>
					<tr class="has-background">
                    <td></td><td></td><td></td><td></td>
					</tr> 
                    <?php
					}
					$i=1; //min
					$range = 12;  //Pagination  min - max per single page
					$min = (($page-1)*$range );
					$max = $page*$range;
				foreach( $result as $results ) {
						
					if($i>$min&&$i<=$max) {
 					$id = $results->id;
					$slideName = $results->sliderName;
 					 //Showing sliders as rows?> 
                    
				 					<tr <?php if($i%2) echo 'class="has-background"'; ?>>
						<td><?php echo $i; ?></td>
						<td><a title="edit <?php echo $slideName; ?>" href="admin.php?page=add-slider&id=<?php echo $id; ?>"><span style="font-weight:bold;font-size:14px;"><?php echo $slideName; ?></span></a></td>
						<td><input type="text" style="width:120px;" onClick="this.select();" value='[uislider id="<?php echo $id; ?>"]' /></td>
						<td><a title="delete <?php echo $slideName; ?>" href="admin.php?page=ui-sliders&task=delete_slider&id=<?php echo $id; ?>">Delete</a></td>
					</tr> 
                    
                    <?php 
							
					} //endif

					$i++;							} //End of loop						
						?>
				 				</tbody>
			</table>
				 			
			
		   
			</form>
            <!--Pagination-->
            <?php if ($itemCount){ ?>
           <div id="uiPgcontainer">
	<div class="uipagination">
    	<?php
		$i = 1;echo "Page >> ";
		while($itemCount/$range >0) { ?>
         <?php if($i == $page) {
			 echo '<span class="uipage active">'.$i.'</span>';
		 } else {
			 echo '<a href="admin.php?page=ui-sliders&pagination='.$i.'" class="uipage">'.$i.'</a>';
		 }
		$i++; $itemCount-=$range; } //endwhile
	
	 } //endif ?>
	
	</div> 
  
    <!--Pagination End-->
		</div>
	</div>
</div>

	<?php	
		} //End of the Switch Statement
		
	} // END OF METHOD
	
 } //END OF CLASS