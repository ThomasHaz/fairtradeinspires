<?php
$page_title = 'fairtradeinspires.com - Home';
include('inc/php/title.inc.php');
include('inc/php/header.inc.php');
include('inc/php/left.inc.php');
/*
//MOVED THIS TO title.inc.php
if(!isset($_SESSION['user'])) {
	header('Location:signin.php');
}*/
if(isset($_GET['nav'])){
	$nav = $_GET['nav'];
	if($nav != 2) $nav = 1; //ONLY ACCOUNT ORDERS AND DETAILS 
} else {
	$nav = 1;
}
$standard = '<div style="height:2em; border:1px solid black; text-align:center; line-height:1.8em;">';
$non = '<div style="height:2em; border:1px solid black; text-align:center; line-height:1.8em; border-bottom-color: #0033FF;background-color:#00ACF3;">';
?>

<div class="content">
<div style="margin-left:0; margin-top:-1em; margin-right:0;">
  <div style="float:left; width:49%;"><?php echo ($nav == 1) ?  $non : $standard; ?><a href="account.php?nav=1">My Details</a></div></div>
  <div style="float:right; width:49%;"><?php echo ($nav == 2) ?  $non : $standard; ?><a href="account.php?nav=2">My Orders</a></div></div>
  <?php //echo ($nav == 3) ?  $non : $standard; <a href="account.php?nav=3">My Questions</a></div>?>
  <?php //echo ($nav == 4) ?  $non : $standard; <a href="account.php?nav=4">My Wishlist</a></div>?>
  </div>
  <div style="width:100%; height:54em; margin:0 auto; clear:both;">
  <?php
  
	  switch($nav) {
		  case 1:
		  include('inc/php/accountdetails.php');
		  break;
		  case 2:
		  include('inc/php/accountorders.php');
		  break;
		  case 3:
		  include('inc/php/accountquestions.php');
		  break;
		  case 4:
		  include('inc/php/accountwishlist.php');
		  break;
	  }
  ?>
  &nbsp;</div>
    

<div class="content_bottom">&nbsp;</div>
<!-- end .content --></div>
  
<?php
include('inc/php/right.inc.php');
include('inc/php/footer.inc.php');
?>
