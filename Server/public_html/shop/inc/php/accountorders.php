<?php 

$q = "INSERT INTO `orders` (`order_id`, `product_id`, `option_id`, `quantity`, `email`, `order_date`) VALUES ('1', '1', '1','1','hello@yes.com', NOW())";





$bg = '#cccccc';

echo '<table border="0" width="100%" align="center" cellspacing="0" cellpadding="2">
	<tr bgcolor="#00ACF3" height="25px">
	<td width="25%" align="center"><span class="acc">Order Number</span></td>
	<td width="25%" align="center"><span class="acc">Order Date</span></td>
	<td width="25%" align="center"><span class="acc">Despatch Date</span></td>
	<td width="10%" align="center"><span class="acc">Total Price</span></td>
	<td width="15%" align="center">&nbsp;</td>
	</tr>';


$q = "SELECT `order_id`, `order_date`, `despatch_date`,`total_price` FROM `orders` WHERE `email` = '{$_SESSION['user']}'";
$r = mysqli_query($dbc, $q);
if(mysqli_num_rows($r) == 0) {
	echo '<h2>Orders Empty</h2><p>You have not placed an order as a registered user. Please <a href="contact.php">contact us</a> for any queries regarding an order you have placed or for any queries in general.</p>';
} else {
while($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
	  
	  $options = '';
	  if(isset($c['colour'])) $options .= 'Colour: ' . $c['colour'] . ' ';
	  if(isset($c['size'])) $options .= 'Size: ' . $c['size'];
	  if($options == '') $options = 'N/A';
	  
	  echo '<tr bgcolor="' . $bg . '"><td align="center"><span class="acc">';
	  //echo $options;//'Colour: ' . $c['colour'] . ' Size: ' . $c['size'];
	  echo $row['order_id'];
	  echo '</span></td><td align="center"><span class="acc">';
	  //echo '&pound;' . $c['price'];
	  echo $row['order_date'];
	  echo '</span></td><td align="center"><span class="acc">';
	  //echo '<input type="text" size="1" name="id' . $c['id'] . '" value="' . $c['qty'] . '" />';
	  if(isset($row['despatch_date'])){
		   echo $row['despatch_date'];
	  } else {
		  echo 'Not yet despatched';
	  }
	  echo '</span></td><td align="center"><span class="acc">';
	  //echo '&pound;' . number_format($c['price'] * $c['qty'],2);
	  echo '&pound;' . $row['total_price'];
	  echo '</span></td><td align="center"><span class="acc">';
	  //echo '<a href="scripts/delete_item.php?id=' . $c['id'] . '"><img src="images/layout/delete.png" /></a>';
	  echo '</span></td></tr>';
	  
	  if($bg == '#cccccc') {
		  $bg = '#ffcccc';
	  } else {
		  $bg = '#cccccc';
	  }
	  echo '<tr bgcolor="' . $bg . '"><td align="center" colspan="5"><table border="0" margin="2" width="90%">';
	  //echo '<tr><td><span class="acc">Name</span></td><td style="text-align:center;"><span class="acc">Options</span></td><td style="text-align:center;"><span class="acc">Quantity</span></td><td style="text-align:center;"><span class="acc">Total Price</span></td></tr>';
	  $q = "SELECT `product_id`, `option_id`, `quantity`, `total_price` FROM `order_details` WHERE `order_id` = '{$row['order_id']}'";
	  $result = mysqli_query($dbc, $q);
	  while($opts = mysqli_fetch_array($result, MYSQLI_ASSOC)){
		  $q = "SELECT * FROM `product_opts` WHERE `option_id` = '{$opts['option_id']}'";
		  $det = mysqli_query($dbc, $q);
		  $details = mysqli_fetch_array($det, MYSQLI_ASSOC);
		  $options = '';
	  	if(isset($details['colour_options'])) $options .= 'Colour: ' . $details['colour_options'] . ' ';
	  	if(isset($details['size_options'])) $options .= 'Size: ' . $details['size_options'];
		if($options == '') $options = 'N/A';
		  echo "<tr><td><span class=\"acc\"><ul><li>{$details['name']}</li></ul></span></td><td width=\"30%\" style=\"text-align:center;\"><span class=\"acc\">$options</span></td><td width=\"10%\" style=\"text-align:center;\"><span class=\"acc\">{$opts['quantity']} @</span></td><td width=\"10%\" style=\"text-align:center;\"><span class=\"acc\">&pound;{$opts['total_price']}</span></td></tr>";
	  }
	  
	  if($bg == '#cccccc') {
		  $bg = '#ffcccc';
	  } else {
		  $bg = '#cccccc';
	  }
	  
	  echo '</table>';
	  
}
echo '</table>';
}
?>