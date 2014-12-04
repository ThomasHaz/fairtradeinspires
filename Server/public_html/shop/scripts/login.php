<?php
session_start();
include('../../../mysqli_connect_inspires.php');
$errors = array();
if(isset($_POST['signin'])){
	//Check form data
	if(empty($_POST['txt_email'])) $errors[] = 'No email address specified.';
	if(empty($_POST['txt_pass'])) $errors[] = 'No password specified.';
	
	
	if(empty($errors)){
		//Do database queries
		$query = "SELECT `pass`, `fname`, `lname`, `telephone` FROM `users` WHERE `email` LIKE '" . $_POST['txt_email'] . "'";
		$pass = sha1($_POST['txt_pass']);
		$result = mysqli_query($dbc, $query);
		//$array = mysqli_fetch_array($result);
		//$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		//$row = $array[0];
		if($result){
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			if($pass == $row['pass']){ //VALID SIGN IN DETAILS
				$_SESSION['user'] = $_POST['txt_email'];
				$_SESSION['name'] = $row['fname'] . ' ' . $row['lname'];
				$_SESSION['telephone'] = $row['telephone'];
				
				
				
				
				//NO ITEMS BEFORE SIGN IN
				//if(!isset($_SESSION['cart'])){
					$q = "SELECT `option_id`, `quantity` FROM `carts` WHERE '$_SESSION[user]' = `email`";
					$r = mysqli_query($dbc, $q);
					if($r) {
						while($row = mysqli_fetch_array($r)){
							
							$q2 = "SELECT `price`, `image_id`, `name`, `colour_options`, `size_options`, `in_stock` FROM `product_opts` WHERE `option_id` = '$row[option_id]'";
							$r2 = mysqli_query($dbc, $q2);
							if($r2){
								$row2 = mysqli_fetch_array($r2, MYSQLI_ASSOC);
								if(!empty($row2['colour_options'])) $col = $row2['colour_options']; else $col = NULL;
								if(!empty($row2['size_options'])) $size = $row2['size_options']; else $size = NULL;
								$qty = $row['quantity'];
								if($row2['in_stock'] < $qty) $qty = $row2['in_stock'];
								if($row2['in_stock'] > 0) {
									if(!isset($_SESSION['cart'][$row['option_id']])){
										$_SESSION['cart'][$row['option_id']] = array('id' => $row['option_id'], 'qty' => $qty, 'price' => $row2['price'], 'thumb' => $row2['image_id'], 'name' => $row2['name'], 'colour' => $col, 'size' => $size);
									} elseif($_SESSION['cart'][$row['option_id']]['qty'] < $qty){
										$_SESSION['cart'][$row['option_id']]['qty'] = $qty;
									}
								}
							}
						}
					}
				//}
				
				
				
				
				
				
				
				
				
				
				
				
				
				header('Location: ../account.php?nav=2');
			} else {
				header('Location: ../signin.php?error=invalid');
			}
		} else {
			echo 'error';
			header('Location: ../signin.php?error=invalid');
		}
		
	} else {
	header('Location: ../signin.php?error=invalid');
	}
}else {
	header('Location: ../index.php?error=invalid_signin');
	}



?>