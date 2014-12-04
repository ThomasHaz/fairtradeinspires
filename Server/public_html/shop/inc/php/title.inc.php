<?php
session_start(); 
include('../../mysqli_connect_inspires.php');
if(!isset($_SESSION['zoom'])){
	$_SESSION['zoom'] = 62.5;
}
if(basename($_SERVER['PHP_SELF']) == "account.php") {
	if(!isset($_SESSION['user'])) {
		header('Location:signin.php');
	}
}
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $page_title; ?></title>
<link href="inc/css/thrColLiqHdr.css?142" rel="stylesheet" type="text/css" />
<!--[if IE]>
<style>
ul.nav a { zoom: 1; }  /* the zoom property gives IE the hasLayout trigger it needs to correct extra whiltespace between the links */
</style>
<![endif]-->
<?php
if(isset($_SESSION['zoom'])){
	echo '<style> body { font-size: ' . $_SESSION['zoom'] . '%; } </style>';
}
?>
<script type="text/javascript">
function clearText(field){
	if(field.defaultValue == field.value) field.value = '';
	else if(field.value == '') field.value = field.defaultValue;
}
</script>
<script type="text/javascript" src="scripts/site.js"></script>
<?php
$page_name = $_SERVER['PHP_SELF'];
$page_name = str_replace('/fairtradeinspires.com/','', $page_name);
$page_name = str_replace('.php','',$page_name);
?>