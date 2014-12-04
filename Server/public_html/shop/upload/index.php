<?php
    require_once('../../../mysqli_connect_inspires.php');
 
    $query = "SELECT image_id, product_id, filename FROM images";
    $result = @mysqli_query($dbc,$query);
	$images = array();
	$row = array();
	$row2 = array();
	$products = array();
	while ($row = mysqli_fetch_array($result)) {
		$x = $row['product_id'];
		$q = "SELECT product_id, name FROM products WHERE product_id=" . $x . " ORDER BY `product_id` ASC";
		$r = @mysqli_query($dbc, $q);
		while ($row2 = mysqli_fetch_array($r)) {
			$id = $row['image_id'];
			$images[$id] = $row['product_id'];
			$p_id = $row2['product_id'];
			$products[$p_id] = $row2['name'];
		}
	}
 /*
    while ($row = mysqli_fetch_array($result)) {
		$x = $row['product_id'];
		$q = "SELECT product_id, name FROM products";// WHERE product_id=" . $x;
		$r = @mysqli_query($dbc, $q);
		$products = array();
		while ($row2 = mysqli_fetch_array($r)) {
			$id = $row['image_id'];
			$images[$id] = $row['filename'];
			$p_id = $row2['product_id'];
			$products[$p_id] = $row2['name'];
		}
    }*/
?>
<html>
    <head>
        <title>Uploaded Products</title>
    </head>
    <body>
        <div>
            <h1>Uploaded Images/Products</h1>
 
            <p>
                <a href="upload.php">Enter a product</a>
            </p>
 
            <ul>
                <?php if (count($images) == 0) { ?>
                    <li>No uploaded images found</li>
                <?php } else foreach ($images as $id => $product_id) { ?>
                <?php if (count($products) == 0) { ?>
                    <li>No uploaded products found</li>
                <?php } else foreach ($products as $p_id => $name) { ?>
                    <?php if($product_id == $p_id) { ?>
                        <li><a href="view.php?id=<?php echo $id ?>&p_id=<?php echo $p_id ?>">
                            <?php echo htmlSpecialChars($name);  ?>
                        </a></li><?php } ?>
                    
                <?php } ?>
                
                <?php } ?>
            </ul>
    </body>
</html>