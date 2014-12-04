<?php
$hidden = $_POST['shown'] == 0?1:0;
$id = $_POST['id'];

require_once('../../../mysqli_connect_inspires.php');

$query = "UPDATE products SET `show_item` = '$hidden' WHERE `product_id` = '$id'";
mysqli_query($dbc,$query);

header("Location: " . $_SERVER['HTTP_REFERER']);

?>