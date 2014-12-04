<?php
$id = $_POST['id'];
$price = $_POST['price'];

$on_sale = isset($_POST['on_sale'])?1:0;
$reduced_from = ($on_sale == 1)?$_POST['reduced_from']:'NULL';


require_once('../../../mysqli_connect_inspires.php');

$query = "UPDATE products SET `price` = '$price', `on_sale` = '$on_sale', `reduced_from` = $reduced_from WHERE `image_id` = '$id'";
mysqli_query($dbc,$query);

header("Location: " . $_SERVER['HTTP_REFERER']);


?>