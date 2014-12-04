<?php
session_start();
include('../../../mysqli_connect_inspires.php');
if(!isset($_SESSION['cart'])){
	header('Location: ../index.php');
}
if(!isset($_GET['id'])){
//header('Location: ../cart.php');
}
if(isset($_GET['id'])) $id = $_GET['id'];
		if(count($_SESSION['cart']) <= 1){
			unset($_SESSION['cart']);
		} else {
			unset($_SESSION['cart'][$id]);
		}






if(isset($_SESSION['user'])){
	$q="SELECT `email`, `option_id`, `quantity` FROM `carts` WHERE `email` = '$_SESSION[user]' AND `option_id` = '$id'";
		//$q = "INSERT INTO `carts` (`email`, `option_id`, `quantity`) VALUES ('$_SESSION[user]', '$c[id]', '$c[qty]')";
		$r = mysqli_query($dbc, $q);
		if(mysqli_num_rows($r) > 0){
		if($r){
			$q = "DELETE FROM `carts` WHERE `email` = '$_SESSION[user]' AND `option_id` = '$id'";
			if(!mysqli_query($dbc, $q)) header('Location: ../cart.php?234234324');
		} else {
			header('Location: ../cart.php?234234324');
		}
		} else {
			header('Location: ../cart.php?234234324');
		}
}
header('Location: ../cart.php');

?>