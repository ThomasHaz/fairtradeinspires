<?php
$page_title = 'fairtradeinspires.com - Cart';
include('inc/php/title.inc.php');
include('inc/php/header.inc.php');
include('inc/php/left.inc.php');
?>

  <div class="content">
  <h1>Your Cart</h1>
  <p>
   
	
    <?php
	$bg = '#ffcccc';
	$subtotal = 0;
	$pp = 0.01;
	$discount = 0;
if(isset($_SESSION['cart'])){
	
	echo '<form action="scripts/update_cart.php" method="POST">
	<table border="0" width="100%" align="center" cellspacing="0" cellpadding="2">
	<tr bgcolor="#00ACF3" height="25px">
	<td width="40%" align="center"><span class="acc">Name</span></td>
	<td width="25%" align="center"><span class="acc">Options</span></td>
	<td width="10%" align="center"><span class="acc">Price</span></td>
	<td width="10%" align="center"><span class="acc">Quantity</span></td>
	<td width="10%" align="center"><span class="acc">Total Price</span></td>
	<td width="5%" align="center">&nbsp;</td>
	</tr>';
  foreach($_SESSION['cart'] as $c){
	if(isset($c['id'])){
	  if($bg == '#cccccc') {
		  $bg = '#ffcccc';
	  } else {
		  $bg = '#cccccc';
	  }
	  $options = '';
	  if(isset($c['colour'])) $options .= 'Colour: ' . $c['colour'] . ' ';
	  if(isset($c['size'])) $options .= 'Size: ' . $c['size'];
	  if($options == '') $options = 'N/A';
	  
	 // echo $_SESSION['cart']['0000000030']['from_wl'];
	  //echo $c['id'];
	  
	  echo '<tr bgcolor="' . $bg . '"><td align="center"><span class="acc">';
	  echo '<a href="productinfo.php?id=' . $c['link'] . '">' . $c['name'] . '</a>';
	  echo '</span></td><td align="center"><span class="acc">';
	  echo $options;//'Colour: ' . $c['colour'] . ' Size: ' . $c['size'];
	  echo '</span></td><td align="center"><span class="acc">';
	  echo '&pound;' . $c['price'];
	  echo '</span></td><td align="center"><span class="acc">';
	  echo '<input type="text" size="1" name="id' . $c['id'] . '" value="' . $c['qty'] . '" />';
	  echo '</span></td><td align="center"><span class="acc">';
	  echo '&pound;' . number_format($c['price'] * $c['qty'],2);
	  echo '</span></td><td align="center">';
	  echo '<a href="scripts/delete_item.php?id=' . $c['id'] . '"><img src="images/layout/delete.png" /></a>';
	  echo '</td></tr>';
	  $subtotal += $c['price'] * $c['qty'];
	  
	  if(isset($_SESSION['user'])){
		$q="SELECT `email`, `option_id`, `quantity` FROM `carts` WHERE `email` = '$_SESSION[user]' AND `option_id` = '$c[id]'";
		//$q = "INSERT INTO `carts` (`email`, `option_id`, `quantity`) VALUES ('$_SESSION[user]', '$c[id]', '$c[qty]')";
		$r = mysqli_query($dbc, $q);
		if(mysqli_num_rows($r) > 0){
			if($r){
				$q = "UPDATE `carts` SET `quantity`='$c[qty]' WHERE `email` = '$_SESSION[user]' AND `option_id` = '$c[id]'";
				mysqli_query($dbc, $q);
			}
		} else {
			$q = "INSERT INTO `carts` (`email`, `option_id`, `quantity`) VALUES ('$_SESSION[user]', '$c[id]', '$c[qty]')";
			mysqli_query($dbc, $q);
		}
	}}
  }
  echo '</table>';
  ?>
  <div style="width:45em; float:left; text-align:right; margin-top:1em; margin-right:1em;">
  <span class="cart"><br />Got a voucher code? Enter it here: </span><br />
	<input type="text" name="code" <?php if(isset($_SESSION['code']['code'])) echo 'value="' . $_SESSION['code']['code'] . '" '; ?>  />
    <input type="submit" name="sub" value="Apply" />
  </div>
  <div style="width:15em; float:right; height:10em; text-align:right; margin-top:1em; margin-right:1em; ">
<span class="cart">Subtotal: &pound;<?php echo number_format($subtotal,2); ?> <br /><br />
	Discount: 
	<?php 
	if(!isset($_SESSION['code'])) {
		echo '---';
	} else {
		if($_SESSION['code']['type'] == 'pct'){
			$discount = ($subtotal * $_SESSION['code']['discount']) / 100;
		} else {
			$discount = $_SESSION['code']['discount'];
		}
		echo '&pound;' . number_format($discount,2);
	}
	 
	?> <br /><br />
  P&P: &pound;<?php echo number_format($pp,2); ?> <br />

  <hr /><br />
  Total to pay: &pound;<?php echo number_format($subtotal+$pp-$discount,2); ?><br />
<br /></span><input type="submit" name="sub" value="Update Cart" />


  </div>
</form>
  
   <div style="width:15em; float:right; height:10em; text-align:right; margin-top:6em; margin-right:1em; clear:both;">
   <?php
   include('scripts/checkout.php');
   ?>
  </div>
  
  
  
 
  
  <?php
  
} else {
	echo '</p><p>Your cart is empty. </p> <p>If you keep seeing this message, or items don\'t stay in your cart, you need to enable cookies. You can follow the guide on how to do this <a href="help.php">here</a>.';
}
  ?>
    
  </p>
    <div class="content_bottom">&nbsp;</div>
    <!-- end .content --></div>
  
<?php
include('inc/php/right.inc.php');
include('inc/php/footer.inc.php');
?>
