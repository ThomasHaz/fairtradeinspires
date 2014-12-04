
</head>

<body<?php if(strpos($_SERVER['PHP_SELF'],'info.php') > -1) echo " onload=\"javascript:animatedcollapse.toggle('asha');\""; //if $_SERVER['PHP_SELF'] == 'info.php'?>>
<div class="container">
  <div class="bgfull"><img src="images/layout/bgfull.jpg" class="img_bg" /><div class="bgfull_top">
  <div class="header"><!--<img src="images/layout/top.jpg" class="img_top" />!-->
  <div class="header_top">
  <div class="mag">
  <a href="scripts/zoom_mi.php"><img src="images/layout/mag_min.jpg" class="img_mag_mi" alt="Zoom out" /></a>
  <a href="scripts/zoom_pl.php"><img src="images/layout/mag_plus.jpg" class="img_mag_pl" alt="Zoom in" /></a>
  </div> &nbsp;
  <div class="header_links"><a href="index.php">home</a> | <a href="info.php">info</a> | <!--<a href="resources.php">resources</a> |!--> <?php if(!isset($_SESSION['user'])) echo '<a href="signin.php">sign in</a>'; else echo '<a href="account.php">my account</a> | <a href="scripts/logout.php">sign out</a>'; ?> | <a href="cart.php">shopping cart</a> <!--| <a href="wishlist.php">find a wishlist</a> !-->| <a href="contact.php">contact us</a></div> 
  <div class="header_cart">Your cart has 
  <?php 
  if(isset($_SESSION['cart'])){
	  /*$total = 0;
	  foreach($_SESSION['cart'] as $c) {
		  $total+=$c['qty'];
		  //echo count($_SESSION['cart']);
	  }*/
	  echo count($_SESSION['cart']);//$total;
  } else {
	  echo '0'; 
  }
  ?> item(s)</div> 
  <div class="header_search"><form action="scripts/search.php" method="get">
  <input type="text" id="search" name="search" width="10" value="Product search..." onBlur="clearText(this)" onFocus="clearText(this)" /><input type="submit" value="Go!" /></form></div>
  
  <!-- end .header_top --></div>  <!-- end .header --></div>