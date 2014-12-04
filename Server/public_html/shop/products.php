<?php
if(isset($_GET['search'])){
	$page_title = "Search reults for: " . $_GET['search'];
} else if(isset($_GET['cat'])){
	$page_title = $_GET['cat'];
} else {
	$page_title = "fairtradeinspires.com - Products";
}

include('inc/php/title.inc.php');
include('inc/php/header.inc.php');
include('inc/php/left.inc.php');
?>




<?php

$order = 'ASC';
if(isset($_GET['order'])) {
	if($_GET['order'] == 'ASC') {
		$order='DESC';
	} else {
		$order = 'ASC';
	}
}

?>



<?php

$num_prod_page = 9;

if(isset($_GET['cat'])) {
	$cat = strtolower($_GET['cat']);
} else {
	$cat = 'all';
}
if(isset($_GET['pg'])){
	$pg = $_GET['pg'];
} else {
	$pg = 1;
}
if(isset($_GET['search'])){
	$sch = $_GET['search'];
	$q = "SELECT `product_id`, `show_item` FROM products WHERE (`name` LIKE '%$sch%' OR `desc` LIKE '%$sch%' OR `category` LIKE '%$sch%') AND `show_item` = 1 ORDER BY `on_sale` DESC, category, `price` ASC, `name`, `in_stock`";

} else {
if ($cat=="all"){
	$q = "SELECT `product_id`, `show_item` FROM products WHERE `show_item` = 1";
} else {
	$q = "SELECT `product_id`, `show_item` FROM products WHERE `category` LIKE '%$cat%' AND `show_item` = 1";
}
}
//$_GET['cat']);
$products = @mysqli_query($dbc,$q);
$num = mysqli_num_rows($products);
$num_pages = ceil($num / $num_prod_page);

$start_from = (($num_prod_page * $pg) - $num_prod_page);
if(isset($_GET['search'])){
	$q = "SELECT `product_id` AS id,`image_id` AS img, `name` AS title, `desc` AS des, `price` AS price, `category`, `size_options`, `colour_options`, `in_stock` AS in_stock, `show_item` FROM products WHERE (`name` LIKE '%$sch%' OR `desc` LIKE '%$sch%' OR `category` LIKE '%$sch%' OR `image_id` = '$sch') ORDER BY ";
	if(isset($_GET['sort'])) {
		$q .= "`{$_GET['sort']}`";
		if(isset($_GET['order'])) {
			$q .= $_GET['order'];
		} else {
			$q .= 'ASC, ';
		}
	}
	$q .= "`on_sale` DESC, category";
	
	$q2 = "SELECT `product_id` AS id,`image_id` AS img, `name` AS title, `desc` AS des, `price` AS price, `category`, `size_options`, `colour_options`, `in_stock` AS in_stock, `reduced_from` FROM products WHERE (`name` LIKE '%$sch%' OR `desc` LIKE '%$sch%' OR `category` LIKE '%$sch%' OR `image_id` = '$sch') AND `show_item` = 1 ORDER BY ";
	if(isset($_GET['sort'])) {
		$q2 .= "`{$_GET['sort']}`";
		if(isset($_GET['order'])) {
			$q2 .= $_GET['order'];
		} else {
			$q2 .= 'ASC, ';
		}
	}
	$q2 .= "`on_sale` DESC, category LIMIT $start_from, $num_prod_page";
	
	$num_pros = "SELECT `product_id` FROM products WHERE (`name` LIKE '%$sch%' OR `desc` LIKE '%$sch%' OR `category` LIKE '%$sch%' OR `image_id` = '$sch') AND `show_item` = 1";
	
} else {
if ($cat=="all"){
	$q = "SELECT `product_id` AS id,`image_id` AS img, `name` AS title, `desc` AS des, `price` AS price, `category`, `size_options`, `colour_options`, `in_stock` AS in_stock, `show_item` FROM products ORDER BY ";
	if(isset($_GET['sort'])) {
		$q .= "`{$_GET['sort']}`";
		if(isset($_GET['order'])) {
			$q .= $_GET['order'] . ', ';
		} else {
			$q .= 'ASC, ';
		}
	}
	$q .= "`on_sale` DESC, category, `in_stock`";
	
	$q2 = "SELECT `product_id` AS id,`image_id` AS img, `name` AS title, `desc` AS des, `price` AS price, `category`, `size_options`, `colour_options`, `in_stock` AS in_stock, `reduced_from` FROM products WHERE `show_item` = 1 ORDER BY ";
	if(isset($_GET['sort'])) {
		$q2 .= "`{$_GET['sort']}`";
		if(isset($_GET['order'])) {
			$q2 .= $_GET['order'] . ', ';
		} else {
			$q2 .= 'ASC, ';
		}
	}
	$q2 .= "`on_sale` DESC, category, `in_stock` LIMIT $start_from, $num_prod_page";
	
	$num_pros = "SELECT `product_id` FROM products WHERE `show_item` = 1";
} else if ($cat=="specials"){
	$q = "SELECT `product_id` AS id,`image_id` AS img, `name` AS title, `desc` AS des, `price` AS price, `category`, `size_options`, `colour_options`, `in_stock` AS in_stock, `show_item` FROM products WHERE `on_sale` = 1 ORDER BY ";
	if(isset($_GET['sort'])) {
		$q .= "`{$_GET['sort']}`";
		if(isset($_GET['order'])) {
			$q .= $_GET['order'] . ', ';
		} else {
			$q .= 'ASC, ';
		}
	}
	$q .= "`category`, `in_stock`";
	$q2 = "SELECT `product_id` AS id,`image_id` AS img, `name` AS title, `desc` AS des, `price` AS price, `category`, `size_options`, `colour_options`, `in_stock` AS in_stock, `reduced_from` FROM products WHERE `on_sale` = 1 AND `show_item` = 1 ORDER BY ";
	if(isset($_GET['sort'])) {
		$q2 .= "`{$_GET['sort']}`";
		if(isset($_GET['order'])) {
			$q2 .= $_GET['order'] . ', ';
		} else {
			$q2 .= 'ASC, ';
		}
	}
	$q2 .= "`category`, `in_stock` LIMIT $start_from, $num_prod_page";
	$num_pros = "SELECT `product_id` FROM products WHERE `on_sale` = 1 AND `show_item` = 1";
	
} else {
	
	$q = "SELECT `product_id` AS id,`image_id` AS img, `name` AS title, `desc` AS des, `price` AS price, `category`, `size_options`, `colour_options`, `in_stock` AS in_stock, `show_item` FROM products WHERE `category` LIKE '%$cat%' ORDER BY ";
	if(isset($_GET['sort'])) {
		$q .= "`{$_GET['sort']}`";
		if(isset($_GET['order'])) {
			$q .= $_GET['order'] . ', ';
		} else {
			$q .= 'ASC, ';
		}
	}
	$q .= "`category`, `in_stock`";
	$q2 = "SELECT `product_id` AS id,`image_id` AS img, `name` AS title, `desc` AS des, `price` AS price, `category`, `size_options`, `colour_options`, `in_stock` AS in_stock, `reduced_from` FROM products WHERE `show_item` = 1 AND `category` LIKE '%$cat%' ORDER BY ";
	if(isset($_GET['sort'])) {
		$q2 .= "`{$_GET['sort']}`";
		if(isset($_GET['order'])) {
			$q2 .= $_GET['order'] . ', ';
		} else {
			$q2 .= 'ASC, ';
		}
	}
	$q2 .= "`category`, `in_stock` LIMIT $start_from, $num_prod_page";
	$num_pros = "SELECT `product_id` FROM products WHERE `show_item` = 1 AND `category` LIKE '%$cat%'";
}
}

$products = @mysqli_query($dbc,$q);
$products2 = @mysqli_query($dbc,$q2);
$num = mysqli_num_rows($products);
$num2 = mysqli_num_rows($products2);
$num3 = mysqli_num_rows(@mysqli_query($dbc,$num_pros));

$query = "SHOW COLUMNS FROM products LIKE 'category'";
$result=mysqli_query($dbc,$query);
	if(mysqli_num_rows($result)>0)
	{
		

?>

        
 <div class="content" style="position:relative;">   
    
<?php
if(!isset($sch))
{
	if($cat == "all"){
	?>

				<h1>All products</h1>

    <?php
	} else if($cat == "womanswear"){
	?>

				<h1>Womenswear</h1>

    <?php
	} else if($cat == "accessory"){
	?>

				<h1>Accessories</h1>

    <?php
	} else {
	?>

				<h1><?php echo ucwords($cat); ?></h1>

    <?php
	}
	if($num3 == 0) {
	?>

				<?php echo "<p>(Sorry, no products found)</p>"; ?>

    	
    <?php
	}
} else if($num3 > 0){
	?>
			<h1>Search results for &quot;<?php echo $sch; ?>&quot;</h1><?php echo "<p>($num3 product(s) found)</p>"; ?>

<?php
} else {
	?>

			<h1>Search results for &quot;<?php echo $sch; ?>&quot;</h1><?php echo "<p>(Sorry, no products found)</p>"; }
			
			$current = "cat=$cat&pg=$pg&order=$order";
if(isset($_GET['search'])) {
	$current .= "&search={$_GET['search']}";
}
?>







<div class="product_sort">
<span class="acc">sort by: 
<a href="products.php?<?php echo $current; ?>&sort=name">name</a> | <a href="products.php?<?php echo $current; ?>&sort=price">price</a> | <a href="products.php?<?php echo $current; ?>&sort=date_added">date added</a>
</span></div>
<?php

	
	
	while ($row = mysqli_fetch_array($products2, MYSQLI_ASSOC)){

		
		$imgsrc = "view_thumb.php?id=" . $row['img'] . "&p_id=" . $row['id'];
		$img_roll = "view_image_rollover.php?id=" . $row['img'] . "&p_id=" . $row['id'];
		
		$img_query = "SELECT * FROM images WHERE `image_id` = '$row[img]'";
		$thumb_query = "SELECT * FROM thumbs WHERE `image_id` = '$row[img]'";
		$img_result = @mysqli_query($dbc,$img_query);
		$thumb_result = @mysqli_query($dbc,$thumb_query);
		
		$img_r = mysqli_fetch_array($img_result, MYSQLI_ASSOC);
		$thumb_r = mysqli_fetch_array($thumb_result, MYSQLI_ASSOC);
		
		//$imgsrc = $img_r['site'] . $img_r['directory'] . $img_r['filename'];
		//$thumbsrc = $thumb_r['site'] . $thumb_r['directory'] . $thumb_r['filename'];
		
		$imgsrc = $img_r['directory'] . $img_r['filename'];
		$thumbsrc = $thumb_r['directory'] . $thumb_r['filename'];
		
		
?>




    
    
    
    
    <div style="border: 1px solid black; width:20.4em; height:30em; margin:.8em; padding:0.2em; float:left;">
    <?php echo '<a href="productinfo.php?id=' . $row['id'] . '"><img src="' . $thumbsrc . '" class="img_products" alt="' . $row['title'] . '" class="img_products" /></a>';
		?>
    <h3><?php echo stripslashes($row['title']); ?></h3>
    <p>
	<?php 
	if(isset($row['reduced_from'])) {
		echo 'Was: &pound;' . $row['reduced_from'] . ' Now: ';
	} else {
		echo 'Price: ';
	}
	echo '&pound;' . $row['price']; 
	?>
    </p><p><a href="productinfo.php?id=<?php echo $row['id']; ?>">more</a></p></div>
    
    
    
    
    
  
  
  
  
  
  
  
  
  
  
  





        
        
<?php
	}//END WHILE
	
	
	
	
	
	
	
	
	//Page numbers and links
	echo '<div style="float:left; width:100%; text-align:center; margin-top:2em;"><span class="acc">Go To Page: ';
	$i;
	
	for($i = 1; $i < $num_pages; $i++) 
	{
		$link = '<a href="products.php?';
		if(isset($sch)){
			$link .= 'search=' . $sch . '&';
		}
		if($cat != 'all'){
			$link .= 'cat=' . $cat . '&';
		}
		$link .='pg=' . $i . '">' . $i . '</a>';
		if($i ==$pg){
			echo $i . ' | ';
		} else {
			echo $link . ' | ';
		}
	} 
	
	if($i ==$pg){
		echo $i;
	} else {
		if(isset($sch)){
			$link .= 'search=' . $sch . '&';
			echo '<a href="products.php?search=' . $sch . '&pg=' . $i . '">' . $i . '</a>';
		} else {
			echo '<a href="products.php?cat=' . $cat . '&pg=' . $i . '">' . $i . '</a>';
		}
	}
	

	echo '</span></div>';
	
	mysqli_free_result($products);
}

    mysqli_close($dbc);    
?>



<div class="content_bottom">&nbsp;</div>
<!-- end .content --></div>



  
<?php
include('inc/php/right.inc.php');
include('inc/php/footer.inc.php');
?>
