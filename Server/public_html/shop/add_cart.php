<?php
require_once('../../mysqli_connect_inspires.php');//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!


$page_title = "Shopping Cart";
include("inc/title.inc.php");
?>
<!-- HEADER TAG STILL OPEN HERE!-->

<?php
include("inc/header.inc.html");
?>
        <?php
include("inc/categories.inc.html");
?>
        <div id="contentHolder">
          <div class="space2" style="width:100%; line-height: 3.5em;"> &nbsp; </div>
          <!-- End space2 !-->
          <div class="content2short" style="width:100%;">
            <div class="h1short">
              <h1>Shopping Cart</h1>
            </div>
          </div>
          <!-- End content2short !-->
          
          
          <div class="content31x">
          
          
          
<?php          
if(isset($_GET['id']) && isset($_GET['name'])){///////GET statements for options
$pid = $_GET['id'];
$na = $_GET['name'];
$q = "SELECT price FROM `products` WHERE `product_id` = '$pid' AND `name` = '$na'";
$r = mysqli_query ($dbc,$q);
if(mysqli_num_rows($r) == 1){
	$col = "";
	$size = "";
	$sold_out_size = "";
	$sold_out_col = "";
	$q = "SELECT `product_id` AS id, `price`, `in_stock`, `name` FROM `products` WHERE `name` = '$na'";
	if(isset($_GET['size'])){
		$size = $_GET['size'];
		$q .= " AND `size_options` = '$size'";
		$sold_out_size = ', Size: ' . $size;
	}
	
	if(isset($_GET['colour'])){
		$col = $_GET['colour'];
		$q .= " AND `colour_options` = '$col'";
		$sold_out_col = ', Colour: ' . $col;
	}
	
	$r = mysqli_query ($dbc,$q);
	if(mysqli_num_rows($r) == 1){
		$id_price = mysqli_fetch_array($r, MYSQLI_ASSOC);
		$pid = $id_price['id'];
		$price = $id_price['price'];
		$instock = $id_price['in_stock'];
		$sold_out = '<p>We are sorry, we have sold out of ' . $id_price['name'] . $sold_out_size . $sold_out_col . '<br />
					Sorry for your inconvenience. Your cart remains unchanged.</p>';
		if($instock > 0){
			$_SESSION['cart'][$pid] = array('quantity' => 1, 'price' => $price, 'colour' => $col, 'size' => $size);
		} else {
			echo $sold_out;
			unset($_SESSION['cart'][$pid]);
		}
	}
}
}

if(isset($_POST['submitted'])){
	foreach($_POST['qty'] AS $k => $v){
		$pid = $k;
		$qty = (int) $v;
		
		$q = "SELECT `in_stock`, `name` FROM `products` WHERE `product_id` = $pid";
		$r = mysqli_query ($dbc,$q);
		$row_instock = mysqli_fetch_array($r);
		$instock = $row_instock['in_stock'];
		$instock_name = $row_instock['name'];
		if($qty == 0){
			unset($_SESSION['cart'][$pid]);
		} elseif ($qty > 0 && $qty <= $instock) {
			$_SESSION['cart'][$pid]['quantity'] = $qty;
		} elseif ($qty > 0 && $qty > $instock) {
			echo '<p>Sorry, we only have ' . $instock . ' ' . $instock_name . ' in stock.</p><br />';
			$_SESSION['cart'][$pid]['quantity'] = $instock;
		}
	}
}

if (!empty($_SESSION['cart']))
{
	
	$q = "SELECT `product_id`, `name`, `category`, `size_options`, `colour_options`, `price` FROM `products` WHERE `product_id` IN (";
	
	foreach ($_SESSION['cart'] as $pid => $value) 
	{
		$q .= $pid . ",";
	}
	$q = substr($q,0,-1) . ")";
	
	$r = mysqli_query($dbc,$q);
	
	echo '
	<form action="add_cart.php" method="POST">
	<table border="0" width="90%" align="center" cellspacing="0" cellpadding="2">
	<tr bgcolor="#00ACF3">
	<td width="30%" align="center">Name</td>
	<td width="25%" align="center">Options</td>
	<td width="15%" align="center">Price</td>
	<td width="15%" align="center">Quantity</td>
	<td width="15%" align="center">Total Price</td>
	</tr>
	';
	
	$total = 0;
	$sizes_order = array();
	$colour_order = array();
	$count = 0;
if($r){
	
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
		$count++;
		$output[] = $count;
		$name_size_col = $row['name'];
		//$output[] = $row['name'];
		if(isset($_SESSION['cart'][$row['product_id']]['size'])){
			$name_size_col .= ' Size:'.$_SESSION['cart'][$row['product_id']]['size'];
		}
		if(isset($_SESSION['cart'][$row['product_id']]['colour'])){
			$name_size_col .= ' Colour:'.$_SESSION['cart'][$row['product_id']]['colour'];
		}
		$output[] = $name_size_col;
		//$output[] = $_SESSION['cart'][$row['product_id']]['size_options'];
		//$output[] = $_SESSION['cart'][$row['product_id']]['colour_options'];
		$output[] = $_SESSION['cart'][$row['product_id']]['price'];
		$output[] = $_SESSION['cart'][$row['product_id']]['quantity'];
		
		$subtotal = $_SESSION['cart'][$row['product_id']]['quantity'] * $_SESSION['cart'][$row['product_id']]['price'];
		$total += $subtotal;
		
		if(isset($_SESSION['cart'][$row['product_id']]['price'])){
		echo "<tr><td colspan=\"5\">&nbsp;</td></tr><tr>
		<td valign=\"top\" align=\"center\" style=\"border-top: 1px solid black; border-left: 1px solid black; border-bottom: 1px solid black;\">{$row['name']}</td>
		<td valign=\"top\" align=\"center\" style=\"border-top: 1px solid black; border-bottom: 1px solid black;\">";
		if($row['size_options'] != NULL)
		{
			echo 'Size: ' . $_SESSION['cart'][$row['product_id']]['size'] . " ";
		}
		if($row['colour_options'] != NULL)
		{
			echo 'Colour: '. $_SESSION['cart'][$row['product_id']]['colour']; 
		}
		echo "</td>
		<td valign=\"top\" align=\"center\" style=\"border-top: 1px solid black; border-bottom: 1px solid black;\">&pound;{$_SESSION['cart'][$row['product_id']]['price']}</td>
		<td valign=\"top\" align=\"center\" style=\"border-top: 1px solid black; border-bottom: 1px solid black;\"><input type=\"text\" size=\"3\" name=\"qty[{$row['product_id']}]\" value=\"{$_SESSION['cart'][$row['product_id']]['quantity']}\" /></td>
		<td valign=\"top\" align=\"center\" style=\"border-top: 1px solid black; border-bottom: 1px solid black; border-right: 1px solid black;\">&pound;" . number_format($subtotal,2) . "</td></tr>\n";
		}
		
	}
}//END IF num_rows

	
	echo '<tr> 
	<td colspan="4" align="right">Sub Total:</td>
	<td align="center">&pound;' . number_format($total, 2) . '</td>
	</tr>
	<tr> 
	<td align="right">Buy now, Collect in-store?</td>
	<td align="right"><input type="checkbox" name="collect" value="1" ';
	if(isset($_POST['collect'])) {
		echo 'checked="checked"';
	}
	echo ' />  </td>
	<td colspan="2" align="right">Postage & Packaging:</td>
	<td align="center">&pound;';
	if(isset($_POST['collect'])) {
		$pp = 0.00;
	} else {
		$pp = 3.95;
	}
	$total += $pp;
	echo number_format($pp, 2) . '</td>
	</tr>
	<tr> 
	<td colspan="4" align="right">Total:</td>
	<td align="center">&pound;' . number_format($total, 2) . '</td>
	</tr>
	</table>
	<div align="center">';

	echo '<p><input type="submit" value="Update Cart" /></p></div>
	<input type="hidden" name="submitted" value="TRUE" />
	</form>';
	echo '<p align="center">Enter 0 (zero) as quantity and update to remove a product.</p>';

	echo '
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post" > 
	<input type="hidden" name="cmd" value="_cart"> 
	<input type="hidden" name="upload" value="1"> 
	<input type="hidden" name="currency_code" value="GBP">
	<input type="hidden" name="handling_cart" value="' . $pp . '">
	<input type="hidden" name="business" value="sales@fairtradeinspires.co.uk">
	<input type="hidden" name="return" value="http://www.fairtradeinspires.co.uk/updateStock.php">
	<input type="hidden" name="cancel_return" value="http://www.fairtradeinspires.co.uk/add_cart.php">';
	for($i = 0; $i < count($output); $i+=4){
		$item_num = $output[$i];
		$item_name = $output[$i+1];
		$item_value = $output[$i+2];
		$item_qty = $output[$i+3];
		echo '<input type="hidden" name="item_name_' . $item_num . '" value="' . $item_name . '">
		<input type="hidden" name="amount_' . $item_num . '" value="' . $item_value . '">
		<INPUT TYPE="hidden" name="quantity_' . $item_num . '" value="' . $item_qty . '">';
	} 
	echo '<div align="center"><input type="submit" value="Checkout" /></div>
	</form>
	<p align="center">You will be returned to this site once payment is complete.</p>
	';
	
} else {
	echo '<p>Your cart is currently empty.</p>';
}

mysqli_close($dbc);
?>          
          
          
          
          
          
          </div>
          
          
          
          
        </div>
        <!-- End contentHolder !-->
      </div>
      <!-- End mainContent from header.inc !-->
      <?php
include("inc/right.inc.php");
?>
    <?php
include("inc/footer.inc.html");
?>
