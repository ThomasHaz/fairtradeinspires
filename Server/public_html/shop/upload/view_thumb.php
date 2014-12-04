<?php

    require_once('../../../mysqli_connect_inspires.php');
 
    try {
        if (!isset($_GET['id'])) {
            throw new Exception('ID not specified');
        }
 
        $id = (int) $_GET['id'];
		
		if (!isset($_GET['p_id'])) {
            throw new Exception('P_ID not specified');
        }
		$p_id = (int) $_GET['p_id'];
 
        if ($id <= 0) {
            throw new Exception('Invalid ID specified');
        }
 
        $query  = sprintf('select * from thumbs where image_id = %d', $id);
        $result = mysqli_query($dbc,$query);
		$q  = sprintf('SELECT * FROM products WHERE product_id = %d',$p_id);
        $r = @mysqli_query($dbc,$q);
 
        if (mysqli_num_rows($result) == 0) {
            throw new Exception('Image with specified ID not found');
        }
		if (mysqli_num_rows($r) == 0) {
			//echo 'Product id not found.';
            throw new Exception('Product with specified ID not found');
        }
 
        $image = mysqli_fetch_array($result);
		$product = mysqli_fetch_array($r);
    }
    catch (Exception $ex) {
        header('HTTP/1.0 404 Not Found');
        exit;
    }
	
	header('Content-type: ' . $image['mime_type']);
    header('Content-length: ' . $image['file_size']);
 
    echo $image['file_data'];
	?>