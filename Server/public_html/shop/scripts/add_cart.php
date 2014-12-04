<?php
session_start();
include('../../../mysqli_connect_inspires.php');


if(isset($_GET['id']))
{
	$id = (int) $_GET['id'];
	if(isset($_GET['colour']))
	$col = $_GET['colour'];
	if(isset($_GET['size']))
	$size = $_GET['size'];
	if(isset($_GET['qty']))
	$qty = $_GET['qty'];



	$q = 'SELECT `option_id`, `image_id`, `name`, `price`, `in_stock` FROM `product_opts` WHERE `product_id` = "' . $id . '"';
	if(isset($col)) $q .= ' AND `colour_options` = "' . $col . '"';
	if(isset($size)) $q .= ' AND `size_options` = "' . $size . '"';
	$r = mysqli_query($dbc, $q);
	$row = mysqli_fetch_array($r, MYSQLI_ASSOC);


	if($_GET['submit'] == 'Add To Cart') {
		
		if($row['in_stock'] > 0) {
			if(isset($_SESSION['cart'][$row['option_id']])) {
				if(isset($qty)) {
					if(($_SESSION['cart'][$row['option_id']]['qty'] + $qty) <= $row['in_stock']){
						$_SESSION['cart'][$row['option_id']]['qty']+=$qty;
						$_SESSION['cart'][$row['option_id']]['from_wl'] += $qty;
					} else {
						$_SESSION['cart'][$row['option_id']]['from_wl'] = $row['in_stock']-$_SESSION['cart'][$row['option_id']]['qty'];
						$_SESSION['cart'][$row['option_id']]['qty'] = $row['in_stock'];
					}
				} else if($_SESSION['cart'][$row['option_id']]['qty'] < $row['in_stock']){
					$_SESSION['cart'][$row['option_id']]['qty']++;
				}
			} else {
				$_SESSION['cart'][$row['option_id']] = array('id' => $row['option_id'], 'qty' => 1, 'price' => $row['price'], 'thumb' => $row['image_id'], 'name' => $row['name'], 'colour' => $col, 'size' => $size, 'link' => $id);
				if(isset($qty)){
					if($qty <= $row['in_stock']) {
						$_SESSION['cart'][$row['option_id']]['qty'] = $qty;
						$_SESSION['cart'][$row['option_id']]['from_wl'] = $qty;
					} else {
						$_SESSION['cart'][$row['option_id']]['from_wl'] = $row['in_stock'];
					}
				}
			}
		}
		

		header('Location: ../cart.php');

	} else { //Add to wishlist
		if(isset($_SESSION['user'])){
		$q = 'SELECT `product_id` FROM `product_opts` WHERE `option_id` = "' . $row['option_id'] . '"';
		$r = mysqli_query($dbc, $q);
		//echo mysqli_num_rows($r);
		if(mysqli_num_rows($r) == 1) {
			$p_id = mysqli_fetch_array($r);
			$q = 'SELECT `option_id` FROM `wishlist` WHERE `option_id` = "' . $row['option_id'] . '" AND `email` LIKE "' . $_SESSION['user'] . '"';
			$r = mysqli_query($dbc, $q);
			if(mysqli_num_rows($r) < 1) {
				$q = "INSERT INTO `wishlist` (`product_id`, `option_id`, `email`) VALUES ('{$p_id['product_id']}', '{$row['option_id']}', '{$_SESSION['user']}')";
				$r = mysqli_query($dbc, $q);
			}
		}
	}

header('Location: ../account.php?nav=4');
}
}
?>