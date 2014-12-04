<?php
$page_title = 'fairtradeinspires.co.uk - Thanks you for your purchase';
include('inc/php/title.inc.php');
include('scripts/return.php');
if((isset($_SESSION['cart'])) && $valid == 1) {
	unset($_SESSION['cart']);
}
include('inc/php/header.inc.php');
include('inc/php/left.inc.php');

?>

  <div class="content">
  <div style="margin:0 auto; text-align:center;">
  <?php 
  if(strpos($_SESSION['tx'],'alse123')) $valid = 0;
  if($valid == 1) {
	  $q = "INSERT INTO `orders` (`email`, `total_price`, `order_date`) VALUES ('{$response['payer_email']}', '{$response['mc_gross']}', NOW())";
	  mysqli_query($dbc, $q);
	  $order_id = mysqli_insert_id($dbc);
	  	for($i = 1; $i <= $response['num_cart_items']; $i++){
			$q = "SELECT `product_id` FROM `product_opts` WHERE `option_id` = {$response['item_number' . $i]}";
			$r = mysqli_query($dbc, $q);
			$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
			$total = $response['mc_gross_' . $i] * $response['quantity' . $i];
			$q = "INSERT INTO `order_details` (`order_id`, `product_id`, `option_id`, `quantity`, `total_price`) VALUES('$order_id', {$row['product_id']}, {$response['item_number' . $i]}, {$response['quantity' . $i]}, '$total')";
			mysqli_query($dbc, $q);
		}
	  
	  
	  
	  
	  
	  echo '<h1>Thank you for your purchase</h1>';
	  $body = '<pre style="font-size:1.8em; border:1px dashed #cccccc;">You have successfully purchased the following items:<br /><br />';
for($i = 1; $i <= $response['num_cart_items']; $i++){
	$body .= $response['item_name' . $i] . ' * ' . $response['quantity' . $i] . ' @ &pound;' . $response['mc_gross_' . $i] . '<br /><br />';
}
$body .= 'Discount: &pound;' . $response['custom'] . '<br />'; 
$body .= 'Your order total is: &pound;' . $response['mc_gross'] . '<br />'; 
$body .= '<br />This will be shipped via 1st class post, within the next 24-48 hours, to:<br />';
$body .= $response['address_name'] . '<br />';
$body .= $response['address_street'] . '<br />';
$body .= $response['address_city'] . '<br />';
$body .= $response['address_state'] . '<br />';
$body .= $response['address_country'] . '<br />';
$body .= $response['address_zip'] . '<br /><br />';
$body .= 'You will recieve a confirmation email shortly to:<br />';
$body .= $response['payer_email'];
$body .= '</pre>';
echo $body;
echo '<h3>Thank you again for your custom. We hope you shop with us again.</h3>';

$email = "Dear {$response['address_name']},\nThank you for choosing to shop with fairtrade inspires. Your order details are below:\n\n";
$shopEmail = $order_id . ";";
$shopEmail .= $response['mc_gross'] . ";";
$shopEmail .= $response['custom'] . ";";
$shopEmail .= $response['address_name'] . ";";
$shopEmail .= $response['payer_email'] . ";";
$shopEmail .= $response['address_street'] . ';';
$shopEmail .= $response['address_city'] . ';';
$shopEmail .= $response['address_state'] . ';';
$shopEmail .= $response['address_country'] . ';';
$shopEmail .= $response['address_zip'];

for($i = 1; $i <= $response['num_cart_items']; $i++){
	$email .= $response['item_number' . $i] . ' - ' . $response['item_name' . $i] . ' * ' . $response['quantity' . $i] . ' @ £' . $response['mc_gross_' . $i] . " \n\n";
	
	$shopEmail .= "^" . $response['item_number' . $i] . ';' . $response['item_name' . $i] . ';' . $response['quantity' . $i] . ';' . $response['mc_gross_' . $i];
	
	//UPDATE STOCKs
	$q = "SELECT `product_id`, `in_stock` FROM `product_opts` WHERE `option_id` = {$response['item_number' . $i]}";
	$r = mysqli_query($dbc, $q);
	$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
	$new = $row['in_stock'] - $response['quantity' . $i];
	$q = "UPDATE `product_opts` SET `in_stock` = '$new' WHERE `option_id` = {$response['item_number' . $i]}";
	mysqli_query($dbc, $q);
	$q = "UPDATE `products` SET `in_stock` = `in_stock`-'{$response['quantity' . $i]}' WHERE `product_id` = {$row['product_id']}";
	mysqli_query($dbc, $q);
	
}
$email .= 'Your order total is (including P&P): £' . $response['mc_gross'] . " \n\n";
$email .= 'This will be shipped via 1st class post within the next day or two. If you have an account on fairtradeinspires.co.uk and used the same email for your paypal checkout you can track your order progress via your account.';
$email = wordwrap($email, 120);
mail($response['payer_email'],'Your order number: ' . $order_id,$email,"From: no-reply@fairtradeinspires.co.uk");
mail('sales@fairtradeinspires.co.uk','Order Recieved:' . $order_id,$email,"From: {$response['payer_email']}");
mail('n.t.hazlett@gmail.com','Please purchase Mail.dll license at http://www.lesnikowski.com/mail/',$shopEmail,"From: no-reply@fairtradeinspires.co.uk");




  }else{
	  echo '<h1>Sorry, there was a problem with your order</h1>';
	  echo '<p>Please check your emails to see if a confirmation email was sent from paypal. If we have recieved the payment we will send the order on to you.</p><p>We have been notifited of this error, although without any contact details.</p>';
	  mail('sales@fairtradeinspires.co.uk','Error processing order','There was an error processing an order.',"From: no-reply@fairtradeinspires.co.uk");
  }
  ?>


          


<?php
for($i = 1; $i <= $response['num_cart_items']; $i++){
	
}
?>
</div>



    
    <div class="content_bottom">&nbsp;</div>
    <!-- end .content --></div>
  
<?php
$_SESSION['tx'] = 'false123' . $_SESSION['tx'];
include('inc/php/right.inc.php');
include('inc/php/footer.inc.php');
?>
