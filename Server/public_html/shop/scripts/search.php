<?php
if(isset($_GET['search'])){
	header('Location: ../products.php?search=' . $_GET['search']);
} else {
	header('Location: ../index.php?error');
}
?>