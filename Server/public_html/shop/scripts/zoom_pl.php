<?php
session_start();
$_SESSION['zoom'] += 10;
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>