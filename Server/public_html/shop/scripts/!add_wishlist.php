<?php
session_start();
include('../../../mysqli_connect_inspires.php');


if(isset($_GET['id'])){
$id = $_GET['id'];
if(isset($_GET['colour']))
$col = $_GET['colour'];
if(isset($_GET['size']))
$size = $_GET['size'];



$q = 'SELECT `option_id` FROM `product_opts` WHERE `product_id` = "' . $id . '"';
if(isset($col)) $q .= ' AND `colour_options` = "' . $col . '"';
if(isset($size)) $q .= ' AND `size_options` = "' . $size . '"';
$r = mysqli_query($dbc, $q);
$row = mysqli_fetch_array($r, MYSQLI_ASSOC);

if(isset($_SESSION['user'])){
	$q = 'SELECT `product_id` FROM `wishlist` WHERE `product_id` = "' . $row['option_id'] . '" AND `email` LIKE "' . $_SESSION['user'] . '"';
	$r = mysqli_query($dbc, $q);
	if(mysqli_num_rows($r) < 1) {
		$q = "INSERT INTO `wishlist` (`product_id`, `email`) VALUES ('" . $row['option_id'] . "', '" . $_SESSION['user'] . "')";
		$r = mysqli_query($dbc, $q);
	}
}

header('Location: ../account.php?nav=4');
}
?>