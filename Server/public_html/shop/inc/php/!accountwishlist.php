<?php 
$q = "SELECT `email`, `fname`, `lname`, `addr1`, `addr2`, `city`, `county`, `postcode`, `wlpass` FROM `users` WHERE `email` = '$_SESSION[user]' AND `wlpass` IS NOT NULL";
$r = mysqli_query($dbc, $q);
$row = mysqli_fetch_array($r, MYSQLI_ASSOC);

if(mysqli_num_rows($r) == 1) {
	$q = "SELECT `product_id`, `quantity`, `comment`, `in_stock` FROM `wishlist` WHERE `email` = '$_SESSION[user]'";
	$r = mysqli_query($dbc, $q);
	
	
	if(mysqli_num_rows($r) >= 1) {
		
		
		
		
		
		
		
		echo '<form action="scripts/update_wl.php" method="GET">
	<table border="0" width="100%" align="center" cellspacing="0" cellpadding="2">
	<tr bgcolor="#00ACF3" height="25px">
	<td width="40%" align="center">Name</td>
	<td width="25%" align="center">Options</td>
	<td width="10%" align="center">Price</td>
	<td width="10%" align="center">Quantity</td>
	<td width="10%" align="center">Total Price</td>
	<td width="5%" align="center">&nbsp;</td>
	</tr>';
	$bg = '';
	while($products = mysqli_fetch_array($r, MYSQLI_ASSOC)){
		
		if($bg == '#ccc') {
		  $bg = '#fcc';
	  	} else {
		  $bg = '#ccc';
	  	}
		$id = $products['product_id'];
		$q = "SELECT `name`, `price`, `size_options` as 'size', `colour_options` as 'colour', `in_stock`, `product_id` FROM `product_opts` WHERE `option_id` = {$id}";
		$result = mysqli_query($dbc, $q);
		if($result) {
			$item = mysqli_fetch_array($result, MYSQLI_ASSOC);
			$options = '';
	  		if(isset($item['colour'])) $options .= 'Colour: ' . $item['colour'] . ' ';
	  		if(isset($item['size'])) $options .= 'Size: ' . $item['size'];
	  		if($options == '') $options = 'N/A';
			
			echo '<tr bgcolor="' . $bg . '"><td align="center">';
	  echo $item['name'];
	  echo '</td><td align="center">';
	  echo $options;
	  echo '</td><td align="center">';
	  echo '&pound;' . $item['price'];
	  echo '</td><td align="center">';
	  echo '<input type="text" size="1" name="id' . $id . '" value="' . $products['quantity'] . '" />';
	  echo '</td><td align="center">';
	  echo '&pound;' . number_format($item['price'],2);// * $c['qty'],2);
	  echo '</td><td align="center">';
	  echo '<a href="scripts/update_wl.php?id' . $id . '=0"><img src="images/layout/delete.png" /></a>';
	  echo '</td></tr>';
		}
		
	}
	
/*	
  foreach($_SESSION['cart'] as $c){
	if(isset($c['id'])){
	  
	  
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
  */
  echo '</table> <div style="text-align:right; margin-right:5em; margin-top:1em;"><input type="submit" value="Update Quantities" /></div> </form>';
		
		
		
		
		
		
		
	} else {
		echo 'To add products here, click add to wishlist from the product page. You can do this even if the product is out of stock.';
	}
	
} else { //wlpass not set up
?>

	<form action="scripts/setwlpass.php" method="post">
    <table width="70%" style="margin:0 auto; text-align:justify;">
    <tr>
    <td colspan="2">
    <span class="acc">
    You have not yet set up your wishlist. To set it up choose and confirm your password which you will give to people you want to be able to view your wishlist along with your email.
    </span>
    </td>
    </tr>
    <tr>
    <td>
    <span class="acc">
    Choose wishlist password:
    </span>
    </td>
    <td>
    <input type="text" name="pass1" />
    </td>
    </tr>
    <tr>
    <td>
    <span class="acc">
    Confirm password:
    </span>
    </td>
    <td>
    <input type="text" name="pass2" />
    </td>
    </tr>
    <tr>
    <td style="text-align:right;">
    <input type="submit" value="Submit" />
    </td>
    <td>&nbsp;
    
    </td>
    </tr>
    </table>
    </form>
<?php
}
?>