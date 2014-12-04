<?php
$id = $_POST['id'];

require_once('../../../mysqli_connect_inspires.php');

$query = "DELETE FROM products WHERE `product_id` = '$id'";
mysqli_query($dbc,$query);

header("Location: index.php");

?>