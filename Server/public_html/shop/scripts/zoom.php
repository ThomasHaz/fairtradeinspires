<?php
session_start();
$_SESSION['zoom'] = 100;
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>