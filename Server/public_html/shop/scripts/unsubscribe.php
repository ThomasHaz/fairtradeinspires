<?php
session_start();
include('../../../mysqli_connect_inspires.php');
$query = 'UPDATE `users` SET `marketing` = 0 WHERE `email` LIKE ' . "'$_SESSION[user]'";
@mysqli_query($dbc, $query);
header('Location: ../account.php');
?>