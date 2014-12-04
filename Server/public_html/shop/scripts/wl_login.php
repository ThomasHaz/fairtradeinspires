<?php
session_start();
include('../../../mysqli_connect_inspires.php');
$errors = array();
if(isset($_POST['submitted'])){
	//Check form data
	if(empty($_POST['email'])) $errors[] = 'No email address specified.';
	if(empty($_POST['pass'])) $errors[] = 'No password specified.';
	
	
	if(empty($errors)){
		//Do database queries
		$query = "SELECT `fname`, `lname` FROM `users` WHERE `email` LIKE '" . $_POST['email'] . "' AND `wlpass` = '" . $_POST['pass'] . "'";
		$result = mysqli_query($dbc, $query);
		if(mysqli_num_rows($result) == 1){
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			$_SESSION['wishlist']['email'] = $_POST['email'];
			$_SESSION['wishlist']['name'] = $row['fname'] . ' ' . $row['lname'];
			header('Location:../wishlist.php');
		} else {
			header('Location:../wishlist.php?error=404');
		}
	} else {
		header('Location:../wishlist.php?error=404');
	}
} else {
	header('Location:../wishlist.php?error=404');
}


	
?>