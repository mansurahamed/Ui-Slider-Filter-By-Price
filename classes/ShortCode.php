<?php
add_shortcode("uislider",array('Shortcode','uiSliderSc'));
add_action( 'wp_ajax_ajax_response_ui_slider', array('ShortCode','ajax_response_ui_sliderfn') );
add_action( 'wp_ajax_nopriv_ajax_response_ui_slider',array('ShortCode','ajax_response_ui_sliderfn') );

class ShortCode {
	static $sliderType;
	static $sliderCategories;
	public function __construct(){
	//	$this->pluginEnqueueScripts();
	}
	public function pluginEnqueueScripts()
	{
	}
	
	static function ajax_response_ui_sliderfn(){
	if ( isset( $_POST["post_var"] ) ) {
		// now set our response var equal to that of the POST var (this will need to be sanitized based on what you're doing with with it)
		$response = intval($_POST["post_var"]); // This contains the Slider Send active range value
		$sliderID = intval($_POST["slider_id"]);
		$height = intval($_POST["height"]);
		//Getting Current slider values from DB
		$dbOperation = new DBHandler();
				$results = $dbOperation->getDbValues("*"," where id='$sliderID'");
				foreach ($results as $result) {
					self::$sliderCategories =  $result->sliderCategories;
				}
	
				//Getting Category id array from Category String
				
		$categoryArray = explode(",", self::$sliderCategories);
		$category = array();
		$i=0;
		foreach($categoryArray as $cat) {
		$category[$i] = get_cat_ID($cat);
		$i++;
		}

		if( $category != array_filter( $category)){
		$category = get_terms(
    array( 'category' ), // Taxonomies
    array( 'fields' => 'ids' ) // Fields
);
	} //If no cat select assign all cat
	?>

        <?php
		// send the response back to the front end

		  global $post;
	   $i=1;
	   
	   //Query to filter post !important
 	$args = array(
	'post_type'  => 'post',
	'meta_key'   => 'priceSliderPrice',
	'posts_per_page' => -1,
	'orderby' => 'meta_value', 
	'order'      => 'ASC',
	'category__in' => $category,
	'meta_query' => array(
		array(
			'key'     => 'priceSliderPrice',
			'value'   => $response,
			'type' => 'numeric',
			'compare' => '<',
		),
	),
);
?>


<style>
.section_ui_slider{
	width:100%;
	clear: both;
	padding: 0px;
	margin: 0px;
}

/*  COLUMN SETUP  */
.col_ui_slider {
	display: block;
	float:left;
	margin: 1% 0 1% 1.6%;
}
.col_ui_slider img{ 
	width:100% !important;
	border:solid 1px #eee;
	padding:7px !important;
	
 }
 .col_ui_slider p{
 text-align:center;
  font-family: 'Exo', sans-serif;
  font-weight:600;
  margin-top:10px !important;
  font-size:2rem;
  color:#529e0e;
  background:transparent;
  margin:0 auto;
  overflow:visible;
  }
.col_ui_slider:first-child { margin-left: 0; }


/*  GROUPING  */
.group_ui_slider:before,
.group_ui_slider:after {
	content:"";
	display:table;
}
.group_ui_slider:after {
	clear:both;
}
.group_ui_slider {
    zoom:1; /* For IE 6/7 */
}
.group_ui_slider a{
	line-height:45px; 
  font-weight:600;
  font-size:2rem;
  color:#666;
  background:transparent;
   }
/*  GRID OF THREE  */
.span_3_of_3 {
	width: 100%;
}
.span_1_of_1 {
	width: 50%;
}
.span_2_of_3 {
	width: 66.1%;
}
.span_1_of_3 {
	width: 31.2% !important;
}
.span_1_of_3 img {
	height: auto !important;
}

.ui_slider_title 
{
	margin-bottom:8px !important;
}
.ui_slider_title a
{
	  font-size:1.8rem !important;
	  text-decoration:none !important;
}
.ui_slider_content{
	margin-top:10px;
font-size:1.4rem !important;
text-align:justify !important;
line-height:1.6rem !important;
min-height:90px !important;
margin-bottom:18px !important;
}
.slider_price_ui{
	 font-size:1.6rem !important;
}

/*  GO FULL WIDTH AT LESS THAN 480 PIXELS */

@media only screen and (max-width: 770px) {
	.col_ui_slider { margin: 1% 0 1% 0% !important;}
	.col_ui_slider img{width:100% !important;}
	.span_3_of_3, .span_2_of_3, .span_1_of_3 { min-width: 100% !important; }
	.ui_slider_title a{
	  font-size:1.2rem !important;
	  text-decoration:none !important;
}
.ui_slider_content{
font-size:1.2rem !important;
text-align:justify !important;
line-height:1.4rem !important;
}
.slider_price_ui{
	 font-size:1.2rem !important;
}
.ui_slider_hr{
	display:none !important;

}

</style>







<?php
	$i=1;
	$j=1;
	$query = new WP_Query( $args );
 
 		if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
		$price = get_post_meta( $post->ID,"priceSliderPrice",true );
		if(($i%3)==1){
			echo '<div class="section_ui_slider group_ui_slider">';
        }

 		 ?>
	<div class="col_ui_slider span_1_of_3" style="">
    <?php
	$title = substr( get_the_title($post->ID),0,18);
	
	$dbOperation = new DBHandler();
				$results = $dbOperation->getDbValues("*"," where id='".$sliderID."'");
				foreach ($results as $result) {
					$sliderOutput =  explode(",",$result->sliderOutput);
				}
	
	 ?>
     
  
    
    <?php $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
	if(!$feat_image) {
		  global $post, $posts;
  $first_img = '';
  ob_start();
  ob_end_clean();
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  if (isset($matches[1][0])) {
	  $first_img = $matches[1][0];
  }

  if(empty($first_img)){ //Defines a default image
    $first_img =  plugins_url( 'images/default.jpg' , dirname(__FILE__) );
  }
		$feat_image = $first_img;
	}
?>

<?php 
if(isset($sliderOutput)){ 
 foreach($sliderOutput as $output) {
	if($output == "1") {
	?>
	<div class='ui_slider_title'> <a href="<?php the_permalink(); ?>"><?php echo substr( get_the_title($post->ID),0,18);if(strlen(get_the_title($post->ID))>18){ echo ".."; } ?></a></div>
    <?php
	}
	$content =  wp_trim_words( get_the_content($post->ID), 12 );
	if($output == "2"){
		 echo '<a href="'.get_permalink().'"><img src="'.$feat_image.'"  /></a>'; 
	}
		 	 if($output == "3") { echo"<div class='ui_slider_content'>  $content </div>";}
			 	 if($output == "4") {
		 echo '<p class="slider_price_ui"><span style="color:#999;" class="slider_price_ui">Price : </span>$'.$price.'</p>'; }

	} // End of loop
} //endif
	?>
	</div>   
  


 	<!-- Display the date (November 16th, 2009 format) and a link to other posts by this posts author. -->

 	<!-- Display the Post's content in a div box. -->

    <?php
	if(($i%3)==0){
		echo '</div>';
		echo '<hr class="ui_slider_hr" />';
		$j=0;
	}
			$i++;
			endwhile; 
			endif;
			if($j){echo "</div>";}
	wp_reset_postdata();
		die();
	}
} // END OF METHOD

	static function uiSliderSc( $atts ) {
	 ob_start(); // begin output buffering
	$id = $atts['id'];
	if ($id) { //We can show slider now
	$dbOperation = new DbHandler();
	$results = $dbOperation->getDbValues("*"," where id='$id'");
				foreach ($results as $result) {
					self::$sliderType = $result->sliderStyle;
				
				}
	
			switch(self::$sliderType)
			{
				case "3d":   // Code block for Modern style Slider
					$slider3d = new Slider3d($id);
					$slider3d->slider3d();
					echo '<div class="priceSliderContent" ><div class="section_ui_slider group_ui_slider">
<div class="col_ui_slider span_1_of_3">
</div>
</div></div>';
					?>
 <input id="ajaxURL" type="hidden" value="<?php echo admin_url('admin-ajax.php'); ?>" />
<input id="sliderID" type="hidden" value="<?php echo $id; ?>" />       



<?php

					
				break;
				case "classic":   // Code block for classic style Slider
					$sliderClassic = new SliderClassic($id);
					$sliderClassic->sliderClassic();
					echo '<div class="priceSliderContent" ><div class="section_ui_slider group_ui_slider">
<div class="col_ui_slider span_1_of_3">
</div>
</div></div>';
				?>
             <input id="ajaxURL" type="hidden" value="<?php echo admin_url('admin-ajax.php'); ?>" />
<input id="sliderID" type="hidden" value="<?php echo $id; ?>" /> 
                <?php              
				break;
			}
		
		}
		
		else {return;} // Wrong Shortcode Parameter
		
	$output = ob_get_contents(); // end output buffering
    ob_end_clean(); // grab the buffer contents and empty the buffer
	return $output;
	}
}  // END OF CLASS
?>