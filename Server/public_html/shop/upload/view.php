<?php

    require_once('../../../mysqli_connect_inspires.php');
	
	$shown;
 
    try {
        if (!isset($_GET['id'])) {
            //throw new Exception('ID not specified');
			$id = 46;
        } else {
			$id = (int) $_GET['id'];
		}
		
		if (!isset($_GET['p_id'])) {
            //throw new Exception('P_ID not specified');
			$p_id=197;
        } else {
			$p_id = $_GET['p_id'];
		}
 
        if ($id <= 0) {
            throw new Exception('Invalid ID specified');
        }
 
        $query  = sprintf('select * from images where image_id = %d', $id);
        $result = mysqli_query($dbc,$query);
		$q  = sprintf('SELECT * FROM products WHERE product_id = %d',$p_id);
        $r = @mysqli_query($dbc,$q);
		$product_opts_query  = sprintf('SELECT * FROM `product_opts` WHERE product_id = %d',$p_id);
		$product_opts_result = @mysqli_query($dbc,$product_opts_query);
 
        if (mysqli_num_rows($result) == 0) {
            throw new Exception('Image with specified ID not found');
			echo 'Image with specified ID not found';
        }
		if (mysqli_num_rows($r) == 0) {
            throw new Exception('Product with specified ID not found');
			echo 'Product with specified ID not found';
        }
		if (mysqli_num_rows($product_opts_result) == 0) {
            throw new Exception('Product with specified ImageID not found');
			echo 'Product with specified ImageID not found';
        }
 
        $image = mysqli_fetch_array($result);
		$product = mysqli_fetch_array($r);
		$shown = $product['show_item'];
		//$product_opts = mysqli_fetch_array($product_opts_result);
    }
    catch (Exception $ex) {
        header('HTTP/1.0 404 Not Found');
        exit;
    }
	
	
	//IMAGE DETAILS
	$query  = sprintf('select * from images where image_id = %d', $id);
        $result = mysqli_query($dbc,$query);
 
        $image = mysqli_fetch_array($result);
		
		$imgsrc = /*$image['site'] . */"../" . $image['directory'] . $image['filename'];
		
		
	//THUMB DETAILS
	$query  = sprintf('select * from thumbs where image_id = %d', $id);
        $result = mysqli_query($dbc,$query);
 
        $image = mysqli_fetch_array($result);
		
		$thumbsrc = /*$image['site'] . */"../" . $image['directory'] . $image['filename'];
		
		
	
	
	
?>
<html><head><script type="text/javascript">
		function showHide(box,id1){
			var elm1 = document.getElementById(id1);
			elm1.style.display = box.checked? "":"none";
		}
		function showHidePrices(box, id1, id2){
			var elm1 = document.getElementById(id1); //sale price
			var elm2 = document.getElementById(id2); //price reduced from
			var tmp = elm2.value > elm1.value?elm2.value:elm1.value;
			elm1.style.display = box.checked? "":"none";
			if(elm1.style.display==""){
				
				elm1.value = elm2.value;
				tmp = elm2.value;
				elm2.focus();
				elm2.value = '';
				
			} else {
				elm2.value = tmp;
				elm2.focus();
			}
			
		}
		</script></head><body>
<img src="<?php echo $imgsrc ?>"><br />

<table border="1" width="600">
<tr><td width="150">Name:</td><td width="450px" colspan="2"><?php echo stripslashes($product['name']); ?>
<form method="post" action="showHideItem.php"><div style="float:right"><input type="hidden" name="id" value="<?php echo $p_id; ?>" /><input type="hidden" value="<?php echo $shown; ?>" name="shown" /><input type="submit" value="<?php echo $shown == 0?'Show Item on Site':'Hide Item from Site'; ?>" /></div></form>
<form method="post" action="deleteItem.php"><div style="float:right"><input type="hidden" name="id" value="<?php echo $p_id; ?>" /><input type="submit" value="Delete Item" /></div></form>
</td></tr>
<tr><td height="150"><img src="<?php echo $thumbsrc ?>"></td><td valign="top" colspan="2"><?php echo stripslashes($product['desc']); ?></td></tr>

<form method="post" action="changePics.php" enctype="multipart/form-data">
<tr><td>Change Pics:</td><td>large:<input type="file" name="image" /></td><td>thumb:<input type="file" name="thumb" /></td></tr><tr><td colspan="3" align="right">
<input type="hidden" name="id" value="<?php echo $id; ?>" />
<input type="submit" value="Change Pictures" /></td></tr></form>

<form method="post" action="updatePrice.php">
<tr><td>Price:</td><td>&pound;<?php echo $product['price']; ?></td>
<td>
<div align="left" style="float:left;">
<?php 
echo isset($product['reduced_from']) 
	? 'Reduced From: &pound;' . $product['reduced_from'] 
	: 'Not Reduced'; 
?>
</div>
<div align="right" style="float:right;">On Sale? 
<input type="checkbox" name="on_sale"
<?php if($product['on_sale'] == 1) echo 'checked="checked"'; ?> 
onClick="showHidePrices(this, 'sale_txt', 'price_txt')" />
</div></td></tr>
<tr id="sale_tr">
<td>Update Prices:<br />(Selling Price/Non-Reduced Price)</td>
<td>&pound;<input type="text" name="price" id="price_txt" size="4" <?php echo 'value="' . $product['price'] . '"';?> /></td>
<td>&pound;<input id="sale_txt"  type="text" size="4" name="reduced_from" <?php if($product['on_sale'] == 0) echo 'style="display:none"'; 
echo 'value="' . $product['reduced_from'] . '"';
?> /><input type="hidden" name="id" value="<?php echo $id; ?>" />
<div style="float:right"><input type="submit" value="Update Prices" /></div></td></tr>
</form>
<tr><td>In stock:</td><td colspan="2"><?php echo $product['in_stock']; ?></td></tr>
<form method="post" action="updateStock.php">
<?php

while ($product_opts = mysqli_fetch_array($product_opts_result)) {
	if(($product_opts['size_options']!=NULL) && ($product_opts['colour_options']!=NULL))
	{
		echo '<tr><td>Colour: ' . $product_opts['colour_options'] . '<br />Size: ' . $product_opts['size_options'] . '</td><td>' . $product_opts['in_stock'] . '</td><td>          
		<input type="text" name="id' . $product_opts['product_id'] . '" value="' . $product_opts['in_stock'] . '" /></td></tr>';
	} 
	else if ($product_opts['size_options']!=NULL) 
	{
		echo '<tr><td>Size: ' . $product_opts['size_options'] . '</td><td>' . $product_opts['in_stock'] . '</td><td>    <input type="text" name="id' . $product_opts['product_id'] . '" value="' . $product_opts['in_stock'] . '" />      </td></tr>';
	} 
	else if ($product_opts['colour_options']!=NULL) 
	{
		echo '<tr><td>Colour: ' . $product_opts['colour_options'] . '</td><td>' . $product_opts['in_stock'] . '</td><td>     <input type="text" name="id' . $product_opts['product_id'] . '" value="' . $product_opts['in_stock'] . '" />     </td></tr>';
	}
	
	
	if(($product_opts['size_options']==NULL) && ($product_opts['colour_options']==NULL))
	echo '<tr><td>Update Stock: </td><td colspan="2"> <input type="text" name="id' . $product_opts['product_id'] . '" value="' . $product_opts['in_stock'] . '" />     </td></tr>';

}


?>

<tr><td></td><td></td><td><input type="submit" value="Update Stock" /></td></tr></form></table>
<br />
<br />
<a href="index.php">Add More</a>
</body></html>