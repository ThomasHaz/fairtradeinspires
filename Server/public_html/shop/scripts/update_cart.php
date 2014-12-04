<?php
session_start();
include('../../../mysqli_connect_inspires.php');


if(isset($_POST['sub'])){
	if($_POST['sub'] == 'Apply') {
		
		//
		//
		//GET CODE DETAILS
		//
		unset($_SESSION['code']);
		$q = "SELECT * FROM `codes` WHERE `code` LIKE '{$_POST['code']}'";
		$r = mysqli_query($dbc, $q);
		if($r) {
			
			$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
			$cur = date("Y-m-d H:i:s");
			if(($cur > $row['valid_from']) && ($cur < $row['expires'])){
				$_SESSION['code'] = array('code' => $row['code'], 'discount' => $row['discount'], 'type' => $row['type']);
				if(isset($row['email'])) {
					$_SESSION['code']['user'] = $row['email'];
					if(isset($_SESSION['user'])){
						if($_SESSION['user'] != $_SESSION['code']['user']){
							unset($_SESSION['code']);
						}
					}
				}
			}
		}
	} else {
if(!isset($_SESSION['cart'])){
	header('Location: ../index.php');
}

foreach($_POST as $k => $v) {
	$id = substr($k,2);
	if($v <=0) {
		include('scripts/delete_item.php?' . $id);
		if(count($_SESSION['cart']) <= 0){
			if(isset($_SESSION['user'])){
				$q = "DELETE FROM `carts` WHERE `email` = '$_SESSION[user]' AND `option_id` = '$id'";
				mysqli_query($dbc, $q);
			}
			unset($_SESSION['cart']);
			
		} else {
			if(isset($_SESSION['user'])){
				$q = "DELETE FROM `carts` WHERE `email` = '$_SESSION[user]' AND `option_id` = '$id'";
				mysqli_query($dbc, $q);
			}
			unset($_SESSION['cart'][$id]);
		}
	} else {
	
	//echo $k . '=' . $v ;
	$q = 'SELECT `in_stock` FROM `product_opts` WHERE `option_id` = "' . $id . '"';
	$r = mysqli_query($dbc, $q);
	$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
	
	if($row['in_stock'] >= $v) {
		//if(isset($_SESSION['cart'][$id]['from_wl'])) {
			//if($v < $_SESSION['cart'][$id]['from_wl']){
				//$_SESSION['cart'][$id]['from_wl'] = $v;
			//}
		//}
		$_SESSION['cart'][$id]['qty'] = $v;
	} else {
		$_SESSION['cart'][$id]['qty'] = $row['in_stock'];
	}
	}
}



	}
}


if(isset($_SESSION['user'])){
	
}
header('Location: ../cart.php');

?>