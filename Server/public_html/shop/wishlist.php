<?php
$page_title = 'fairtradeinspires.com - Cart';
include('inc/php/title.inc.php');
include('inc/php/header.inc.php');
include('inc/php/left.inc.php');
?>

  <div class="content">
  
	
    <?php
	if(!isset($_SESSION['wishlist']['email'])) {
		//form to access wishlist
		?>
        <h1>find a wishlist</h1>
        <p>
        Please enter the email address and password of the wishlist you would like to view.
        </p>
        
        <form action="scripts/wl_login.php" method="post">
        <div style="margin:0 auto; width:40%;">
        <table width="100%">
        <tr>
        <td>
        <span class="acc">
        Email
        </span>
        </td>
        <td>&nbsp;
        
        </td>
        <td>
        <input type="text" name="email" />
        </td>
        </tr>
        <tr>
        <td>
        <span class="acc">
        Password
        </span>
        </td>
        <td>&nbsp;
        
        </td>
        <td>
        <input type="password" name="pass" />
        </td>
        </tr>
        <tr>
        <td colspan="3" style="text-align:center;">
        <input type="submit" value="Submit" />
        </td>
        </tr>
        </table>
        </div>
        <input type="hidden" name="submitted" value="yes" />
        </form>
        
        <?php
	} else {
		//display wishlist
		echo "<h1>{$_SESSION['wishlist']['name']}'s Wishlist</h1>";
		$bg = '#fcc';
		echo '
	<table border="0" width="100%" align="center" cellspacing="0" cellpadding="2">
	<tr bgcolor="#00ACF3" height="25px">
	<td width="35%" align="center">Name</td>
	<td width="20%" align="center">Options</td>
	<td width="10%" align="center">Price</td>
	<td width="10%" align="center">Quantity Wanted</td>
	<td width="10%" align="center">Quantity in stock</td>
	<td width="10%" align="center">Quantity to buy</td>
	<td width="5%" align="center">&nbsp;</td>
	</tr>';
	
		$q = "SELECT `product_id`, `option_id`, `quantity`, `comment` FROM `wishlist` WHERE `email` = '{$_SESSION['wishlist']['email']}'";
		$r = mysqli_query($dbc,$q);
		while($pro = mysqli_fetch_array($r, MYSQLI_ASSOC)){
			$q = "SELECT `name`, `price`, `size_options`, `colour_options`, `in_stock` FROM `product_opts` WHERE `option_id` = '{$pro['option_id']}'";
			$result = mysqli_query($dbc, $q);
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			
			if($bg == '#ccc') {
		  		$bg = '#fcc';
	  		} else {
		  		$bg = '#ccc';
	  		}
			
			$options = '';
			if(isset($row['colour_options'])) $options .= 'Colour: ' . $row['colour_options'] . ' ';
	  		if(isset($row['size_options'])) $options .= 'Size: ' . $row['size_options'];
	  		if($options == '') $options = 'N/A';
			
			echo '<tr bgcolor="' . $bg . '"><td align="center">';
		  	echo $row['name'];
	  		echo '</td><td align="center">';
	  		echo $options;//'Colour: ' . $c['colour'] . ' Size: ' . $c['size'];
	  		echo '</td><td align="center">';
	  		echo '&pound;' . $row['price'];
	  		echo '</td><td align="center">';
	  		echo $pro['quantity'];
	  		echo '</td><td align="center">';
	  		echo $row['in_stock'];
			echo '</td><td colspan="2">';
			echo '<form action="scripts/add_cart.php" method="get">';
			echo '<div style="width:66%; float:left; text-align:center;>"';
			
			//echo $_SESSION['cart'][$pro['option_id']]['from_wl'];
	  		echo '<select size="1" name="qty">';
			$max = $pro['quantity'];
			if(isset($_SESSION['cart'][$pro['option_id']]['from_wl'])){
				$max -= $_SESSION['cart'][$pro['option_id']]['from_wl'];
				
			}
			
			if($max > $row['in_stock']) $max = $row['in_stock'];
			for($i = 0; $i <= $max; $i++) {
				echo "<option>$i</option>";
			}
			echo '</select></div>';
	  		echo '<!--</td><td align="center">!--><div style="width:33%; float:left; text-align:center;">';
			//echo '<input type="hidden" name="submit" value="Add To Cart" />';
			echo '<input type="hidden" name="submit" value="Add To Cart" />';
			echo '<input type="hidden" name="id" value="' . $pro['product_id'] . '" />';
			echo '<input type="hidden" name="colour" value="' . $row['colour_options'] . '" />';
			echo '<input type="hidden" name="size" value="' . $row['size_options'] . '" />';
	  		//echo '<a href="scripts/add_cart.php?submit=Add+To+Cart&id=' . $pro['product_id'] . '&colour=' . $row['colour_options'] . '&size=' . $row['size_options'] . '&qty=2"><img src="images/layout/delete.png" /></a>';
			echo '<input type="image" src="images/layout/cart.jpg" border="0" width="30" height="15" alt="Add this item to cart" />';
	  		echo '</div></form></td></tr>';
			
			
		}
        
		echo '</table>';
		
        
	}
	
	?>
    
    <!-- end .content --></div>
  
<?php
include('inc/php/right.inc.php');
include('inc/php/footer.inc.php');
?>
