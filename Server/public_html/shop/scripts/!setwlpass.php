<?php
session_start();
include('../../../mysqli_connect_inspires.php');
$errors = array();
$pass_match = '*';
$errors_empty = 1;
//if(isset($_POST['submitted'])){

	if($_POST['pass2'] != $_POST['pass1']) {
		$errors[] = 'Your passwords did not match.';
		$pass_match = '<img src="images/layout/error.jpg" alt="Your passwords did not match." />';
	} else {
		$pass_match = '*';
	}
	
	if(empty($errors)){
	//Do database entries
	$query = "UPDATE `users` SET `wlpass` = '{$_POST[pass1]}' WHERE `email` LIKE '{$_SESSION[user]}'";
	@mysqli_query($dbc, $query);
	} else { //errors not empty
		$errors_empty = 0;
	}
//}
header('Location:../account.php?nav=4');


?>