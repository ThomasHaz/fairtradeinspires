<?php
session_start();
include('../../../mysqli_connect_inspires.php');

if(isset($_SESSION['user'])){
foreach($_GET as $k => $v) {
	//echo $k . ' ' . $v;
	$id = substr($k,2);
	if($v <=0) {
		//include('scripts/delete_wlitem.php?' . $id);
		$q = "DELETE FROM `wishlist` WHERE `email` = '{$_SESSION[user]}' AND `product_id` = '$id'";
		mysqli_query($dbc, $q);
	} else {
		$email = $_SESSION['user'];
		$q = "UPDATE `wishlist` SET `quantity` = '$v' WHERE `email` = '$email' AND `product_id` = '$id'";
		$r = mysqli_query($dbc, $q);
		//if($r) echo 'noooo';
	}
}
}


header('Location: ../account.php?nav=4');

?>