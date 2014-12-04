<?php
echo '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" >';

$i = 0;
$td = $discount;
foreach($_SESSION['cart'] as $c){
if(isset($c['id'])){
	$i++;
	$q = 'SELECT `option_id`, `name`, `price`, `in_stock`, `colour_options`, `size_options` FROM `product_opts` WHERE `option_id` = "' . $c['id'] . '"';
	$r = mysqli_query($dbc, $q);
	${'row' . $i} = mysqli_fetch_array($r, MYSQLI_ASSOC);
	$name = ${'row' . $i}['name'];
	if(isset(${'row' . $i}['size_options'])) $name .= ' Size: ' . ${'row' . $i}['size_options'];
	if(isset(${'row' . $i}['colour_options'])) $name .= ' Colour: ' . ${'row' . $i}['colour_options'];
	${'row' . $i};
	echo '<input type="hidden" name="item_name_' . $i . '" value="' . $name . '" />';
	echo '<input type="hidden" name="item_number_' . $i . '" value="' . ${'row' . $i}['option_id'] . '" />';
	echo '<input type="hidden" name="amount_' . $i . '" value="' . ${'row' . $i}['price'] . '" />';
	echo '<input type="hidden" name="quantity_' . $i . '" value="' . $c['qty'] . '" />';
	if(${'row' . $i}['price'] > $td) {
		//echo '<input type="hidden" name="discount_amount_' . $i .'" value="' . $td . '" />';
		//$td = 0;
	} else {
		//echo '<input type="hidden" name="discount_amount_' . $i .'" value="' . (${'row' . $i}['price'] - 0.01) . '" />';
		//$td -= ${'row' . $i}['price'] - 0.01;
	}
	echo '<input type="hidden" name="discount_amount_cart" value="' . number_format($discount,2) . '" />';
	echo '<input type="hidden" name="custom" value="' . number_format($discount,2) . ';' . $pp . '" />';
}
	
	
}


?>
	 
	<input type="hidden" name="cmd" value="_cart"> 
	<input type="hidden" name="upload" value="1"> 
	<input type="hidden" name="currency_code" value="GBP">
	<input type="hidden" name="handling_cart" value="<?php echo $pp; ?>">
	<input type="hidden" name="business" value="paypal@example.com">
	<input type="hidden" name="return" value="http://www.fairtradeinspires.com/thankyou.php">
	<input type="hidden" name="cancel_return" value="http://www.fairtradeinspires.co.uk/add_cart.php">
    
<input type="submit" value="Checkout" />
	</form>

<?php
if(isset($_SESSION['user'])){
	
}
?>