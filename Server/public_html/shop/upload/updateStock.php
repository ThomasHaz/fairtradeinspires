<?php
require_once('../../../mysqli_connect_inspires.php');
$idArray;
$valArray;
$myArray = array();
foreach ($_POST as $k => $v) {
	$idArray[] = substr($k,2);
	$valArray[] = $v;
	$myArray[substr($k,2)] = $v;
}
$update_id;
$total = 0;
$count = 0;
foreach ($myArray as $k => $v) {
	if($count == 0) $update_id = (int)$k - 1;
	$total += $v;
	if(is_numeric($_POST['id' . $k])) {
	$query = "UPDATE products SET `in_stock` = '$v' WHERE `product_id` = '$k'";
	mysqli_query($dbc,$query);
	}
	$count++;
}
$query = "UPDATE products SET `in_stock` = '$total' WHERE `product_id` = '$update_id'";
mysqli_query($dbc,$query);
header("Location: " . $_SERVER['HTTP_REFERER']);
?>