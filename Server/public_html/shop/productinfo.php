<?php
function indexOf($needle, $haystack) {                // conversion of JavaScripts most awesome
        for ($i=0;$i<count($haystack);$i++) {         // indexOf function.  Searches an array for
                if ($haystack[$i] == $needle) {       // a value and returns the index of the *first*
                        return $i;                    // occurance
                }
        }
        return false;
}

$page_title = 'fairtradeinspires.com - Products';
include('inc/php/title.inc.php');
//HEADER TAG STILL OPEN


?>

<script type="text/javascript">

function changePic(i){
	document.getElementById('picsDiv').innerHTML = '<img src="' + i + '" width="400" height="400" alt="epona" />';
}

</script>

<?php

echo '<script type="text/javascript" src="scripts/stock_check.js"></script>';

//
include('inc/php/header.inc.php');
include('inc/php/left.inc.php');


$id = $_GET['id'];

	$q = "SELECT `option_id` AS id,`image_id` AS img, `name` AS title, `desc` AS des, `price` AS price, `category`, `size_options`, `colour_options`, `in_stock` AS in_stock, `reduced_from` FROM product_opts WHERE `product_id` = '$id'";
	$q2 = "SELECT `name` AS title, `desc` AS des, `price` AS price, `in_stock` AS in_stock, `reduced_from`, `size_options`, `colour_options` FROM products WHERE `product_id` = '$id'";
	$num_pros = "SELECT `option_id` FROM product_opts WHERE `product_id` LIKE '$id'";



$products = @mysqli_query($dbc,$q);
$product = @mysqli_query($dbc,$q2);
$num = mysqli_num_rows(@mysqli_query($dbc,$num_pros));






?>

<script type="text/javascript">

var stock = new Array();
stock[0] = new Array();
stock[1] = new Array();
stock[2] = new Array();
stock[3] = new Array(); //INDEX ON VIEWABLE PAGE

var num_products = <?php echo $num; ?>;

var item_name = "yes";
var stck;

stock[0].push("");
stock[1].push("");
stock[2].push("");
stock[0].push("");
stock[1].push("");
stock[2].push("");
stock[0].push("");
stock[1].push("");
stock[2].push("");
stock[0].push("");
stock[1].push("");
stock[2].push("");
</script>

<?php






		$img_query = "SELECT `directory`, `filename` FROM images WHERE `product_id` = '$id'";
		$thumb_query = "SELECT `directory`, `filename` FROM thumbs WHERE `product_id` = '$id'";
		$slide_query = "SELECT `directory`, `filename`, `tn_directory`, `tn_filename` FROM slides WHERE `product_id` = '$id'";
		
		$img_result = @mysqli_query($dbc,$img_query);
		$thumb_result = @mysqli_query($dbc,$thumb_query);
		$slide_result = @mysqli_query($dbc,$slide_query);
		
		$img_r = mysqli_fetch_array($img_result, MYSQLI_ASSOC);
		$thumb_r = mysqli_fetch_array($thumb_result, MYSQLI_ASSOC);
		
		
		$imgsrc = $img_r['directory'] . $img_r['filename'];
		$thumbsrc = $thumb_r['directory'] . $thumb_r['filename'];
		
		$slidesrc = array();
		$slidetnsrc = array();
		
		while($slide_r = mysqli_fetch_array($slide_result, MYSQLI_ASSOC)) {
			$slidesrc[] = $slide_r['directory'] . $slide_r['filename'];
			$slidetnsrc[] = $slide_r['tn_directory'] . $slide_r['tn_filename'];
		}
		
		
		
		


?>


<div class="content" style="position:relative; filter: alpha(opacity=100); -moz-opacity: 1; KhtmlOpacity: 1; opacity: 1;">


<?php
	$row = mysqli_fetch_array($product, MYSQLI_ASSOC)	
?>
    
    <div style="width:100%; text-align:center;"><h1><?php echo $row['title']; ?></h1></div>
    <div id="picsDiv" style="border: 1px solid #999; width:40em; height:39.9em; margin:0; padding:0.5em; float:right; position:absolute; top:5em; left:0.5em;">
    <img src="<?php echo $imgsrc; //430 ... 43em?>" class="img_main_product" alt="epona" />
    </div>
    <div style="width:26em; height:41em; margin:0; padding:0; float:left; position:absolute; top:5em; left:41.5em; clear:both;">
    
    <?php
    if(count($slidetnsrc) > 3){
		echo '<div style=" height:41em; width:10em;">';
	} else {
		echo '<div style="height:41em; width:10em;">';
	}
    
	
	$slide_output2 = '';
	if(count($slidetnsrc) > 0){
	$slide_output1 = '
    <div style=" width:10em; float:left;margin-left:2.8em;margin-bottom:0.1em;border:1px solid #999; cursor:pointer;"><img src="' . $thumbsrc . '" class="img_slide" alt="epona" onclick="changePic(\'' . $imgsrc . '\')" /></div>';
	} else {
		$slide_output1 = '';
	}
	?>
    <?php
	$num_of_slides = 0;
	foreach($slidetnsrc as $src) {
		$num_of_slides++;
		
		if($num_of_slides< 4) {
			$slide_output1 .= '<div style="width:10em; position:absolute; margin-left:2.8em;margin-bottom:0.1em; border:1px solid #999; cursor:pointer;';
			if($num_of_slides == 1){
				$slide_output1 .= 'top:0; left:11.1em;';
			}
			if($num_of_slides == 2){
				$slide_output1 .= 'top:10.8em; left:0;';
			}
			if($num_of_slides == 3){
				$slide_output1 .= 'top:10.8em; left:11.1em;';
			}
		
		$slide_output1 .= '"><img src="' . $src . '" class="img_slide" alt="epona" onclick="changePic(\'' . $slidesrc[indexOf($src,$slidetnsrc)] . '\')"  /></div>';
			
		} else {
			$slide_output1 .= '<div style=" width:10em; float:left;left:11.1em;margin-left:0;margin-bottom:0.1em; position:absolute;border:1px solid #999; cursor:pointer;';
			if($num_of_slides == 4)
				$slide_output1 .= 'top:0; ';
			if($num_of_slides == 5)
				$slide_output1 .= 'top:10.3em;';
			$slide_output1 .= '"><img src="' . $src . '" class="img_slide" alt="epona" onclick="changePic(\'' . $slidesrc[indexOf($src,$slidetnsrc)] . '\')" /></div>';
		}
	}
	if(isset($_GET['sl'])){
		$test = 'slide_output';
		echo ${$test . $_GET['sl']};
	} else {
		echo $slide_output1;
	}
	
	?>
    
    </div>
    
    
    
    
    <form method="get" action="scripts/add_cart.php">
    <div style=" width:25em; height:18em; position:absolute; <?php echo (count($slidetnsrc) < 2) ? 'top:':'bottom:'; ?>0em; right:0em;padding-top:1em;border:1px solid #999;text-align:center;">

    <p>
   <?php 
   
   if(isset($row['reduced_from'])) {
	   echo 'Was: &pound;' . $row['reduced_from'] . ' Now: &pound;' . $row['price']; 
   } else {
	   echo 'Price: &pound;' . $row['price'];
   }
   
	?>
    <br />
    </p>
    
    
        
    <?php
	
	$name = $row['title'];
		$name = str_replace(' ', '_', $name);
		$name = str_replace('(', '', $name);
		$name = str_replace(')', '', $name);
		$name = str_replace('/', '-', $name);
		$col = $row['colour_options'];
		$sz = $row['size_options'];
		$st = $row['in_stock'];
		$val = $col . $sz;
		
		
	while ($row2 = mysqli_fetch_array($products, MYSQLI_ASSOC)){
		
		$name2 = $row2['title'];
		$name2 = str_replace(' ', '_', $name2);
		$name2 = str_replace('(', '', $name2);
		$name2 = str_replace(')', '', $name2);
		$name2 = str_replace('/', '-', $name2);
		$col = $row2['colour_options'];
		$sz = $row2['size_options'];
		$st = $row2['in_stock'];
		$val = $col . $sz;
		?>
        
        <script type="text/javascript">
			stock.push("<?php echo $name;?>");
			stock[0].push("<?php echo $col;?>");
			stock[1].push("<?php echo $sz;?>");
			stock[2].push("<?php echo $st;?>");
			stock[3].push("<?php echo $name;?>");
        </script>
        
     <?php
	}
	
	if(($row['size_options'] != NULL) && ($row['colour_options'] != NULL)){
			?>
            
            <script type="text/javascript">
			var item_name = <?php echo $name;?>
			</script>
            
            <?php
			echo '<p><select size="1" name="size" id="' . $name . '" onchange="stck = OnChangeSizeC(this.form.size, this.form.colour);">';
			?>
            <?php
			$options = explode(',',$row['size_options']);
			echo '<option selected="selected">Select size...</option>';
			foreach ($options as $opt)
			{
				echo '<option>' . $opt . '</option>';
			}
			
			echo '</select> </p>';
		
			?>
            
			<?php
			
			echo '<p><select size="1" name="colour" id="' . $name . '2" onchange="stck = OnChangeColourS(this.form.colour, this.form.size);">';
			?>
            
            <?php
			$options = explode(',',$row['colour_options']);
			echo '<option selected="selected">Select colour...</option>';
			foreach ($options as $opt)
			{
				echo '<option>' . $opt . '</option>';
			}
			echo '</select></p>';
		
		} else if($row['size_options'] != NULL){//END BOTH COLOUR AND SIZE != NULL
			?>
             
        
		<?php
			echo '<select size="1" name="size" id="' . $name . '" onchange="item_name = this.form.size.id;stck = OnChangeSize(this.form.size);">';
		?>
        <?php
			$options = explode(',',$row['size_options']);
			echo '<option selected="selected">Select size...</option>';
			foreach ($options as $opt)
			{
				echo '<option>' . $opt . '</option>';
			}
			echo '</select> ';
		} else if($row['colour_options'] != NULL)
		{
			?>
            
			<?php
			echo '<select size="1" name="colour" id="' . $name . '" onchange="item_name = this.form.colour.id;stck = OnChangeColour(this.form.colour);">';
			?>
            <?php
			$options = explode(',',$row['colour_options']);
			echo '<option selected="selected">Select colour...</option>';
			foreach ($options as $opt)
			{
				echo '<option>' . $opt . '</option>';
			}
			echo '</select>';	
		}    
	   
   
	//}
   ?>
		<p id="stok" style="font-family:'Courier New', Courier, monospace; font-size:12px; color:#F00;">&nbsp;</p>
    <input type="hidden" name="id" value="<?php echo $id ?> '" />
		<input type="hidden" name="name" value="<?php echo $row['title']; ?>" />
		<?php //if(isset($_SESSION['user'])) echo '<input type="submit" value="Add To Wishlist" name="submit" />'; ?>
        <input type="submit" value="Add To Cart" name="submit" />
  
    
    </div>
    </form>
    </div>
    <div style="width:66.5em; min-height:2em; padding:0.2em; position:relative; top:43em; right:0.5em; left:0.5em;">
    <p><?php echo $row['des']; ?></p>
   <div style="clear:both;">&nbsp;</div> 
   
   <div class="content_bottom">&nbsp;</div>
  
  </div><!-- end bottombox !-->
  
</div><!--end content !-->

<?php

	
	mysqli_free_result($products);

    mysqli_close($dbc);    



include('inc/php/right.inc.php');
include('inc/php/footer.inc.php');
?>
