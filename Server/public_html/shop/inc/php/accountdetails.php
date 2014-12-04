
<?php 
$q = "SELECT `email`, `fname`, `lname`, `addr1`, `addr2`, `city`, `county`, `postcode`, `telephone`, `marketing`, `wlpass` FROM `users` WHERE `email` = '$_SESSION[user]'";
$r = mysqli_query($dbc, $q);
$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
?>
  <table style="margin: 0 auto; margin-top:2em;">
  	<tr>
	  <td><span class="acc">Name:</span></td>
      <td width="20px">&nbsp;</td>
      <td><span class="acc"><?php echo $row['fname'] . ' ' . $row['lname']; ?></span></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><span class="acc">Email:</span></td>
      <td>&nbsp;</td>
      <td><span class="acc"><?php echo $row['email']; ?></span></td>
      <td><span class="acc"><a href="change.php?email">change</a></span></td>
    </tr>
    <tr>
      <td><span class="acc">Address:</span></td>
      <td>&nbsp;</td>
      <td rowspan="3"><span class="acc"><?php echo $row['addr1'] . '<br />' . $row['city'] . '<br />' . $row['postcode']; ?></span></td>
      <td><span class="acc"><a href="change.php?address">change</a></span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><span class="acc">Telephone:</span></td>
      <td>&nbsp;</td>
      <td><span class="acc"><?php echo $row['telephone']; ?></span></td>
      <td><span class="acc"><a href="change.php?tel">change</a></span></td>
    </tr>
    <!--<tr>
      <td><span class="acc">Newsletter:</span></td>
      <td>&nbsp;</td>
      <td><span class="acc"><?php //echo (($row['marketing'] == 1) ? 'yes - <a href="scripts/unsubscribe.php">unsubscribe</a>' : 'no - <a href="scripts/subscribe.php">subscribe</a>'); ?></span></td>
    </tr>!-->
    <tr>
      <td><span class="acc">Account Password:</span></td>
      <td>&nbsp;</td>
      <td><span class="acc">********</span></td>
      <td><span class="acc"><a href="change.php?password">change</a></span></td>
    </tr>
    <!--<tr>
      <td><span class="acc">Wishlist Password:</span></td>
      <td>&nbsp;</td>
      <td><span class="acc"><?php echo (isset($row['wlpass']) ? $row['wlpass'] . '</span></td><td><span class="acc"><a href="change.php?wlpass">change</a></span></td>' : 'Wishlist not set up.</span></td><td><span class="acc"><a href="account.php?nav=4">setup now</a></span></td>'); ?></td>
    </tr>!-->
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>