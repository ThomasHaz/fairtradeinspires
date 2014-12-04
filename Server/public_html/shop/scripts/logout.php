<?php
session_start();
if(isset($_SESSION['user'])){
	$_SESSION['user'] = NULL;
}
if(isset($_SESSION['cart'])){
	unset($_SESSION['cart']);
}
header('Location: ../index.php');
?>