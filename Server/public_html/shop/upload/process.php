<?php

require_once('../../../mysqli_connect_inspires.php');

function assertValidUpload($code)
    {
        if ($code == UPLOAD_ERR_OK) {
            return;
        }
 
        switch ($code) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $msg = 'Image is too large';
                break;
 
            case UPLOAD_ERR_PARTIAL:
                $msg = 'Image was only partially uploaded';
                break;
 
            case UPLOAD_ERR_NO_FILE:
                $msg = 'No image was uploaded';
                break;
 
            case UPLOAD_ERR_NO_TMP_DIR:
                $msg = 'Upload folder not found';
                break;
 
            case UPLOAD_ERR_CANT_WRITE:
                $msg = 'Unable to write uploaded file';
                break;
 
            case UPLOAD_ERR_EXTENSION:
                $msg = 'Upload failed due to extension';
                break;
 
            default:
                $msg = 'Unknown error';
        }
 
        throw new Exception($msg);
    }
	
	$errors = array();
 if(isset($_POST['img_added'])) {
    try {
		
		
        if (!array_key_exists('image', $_FILES)) {
            throw new Exception('Image not found in uploaded data');
        }
 
        $image = $_FILES['image'];
 
        // ensure the file was successfully uploaded
        assertValidUpload($image['error']);
 
        if (!is_uploaded_file($image['tmp_name'])) {
            throw new Exception('File is not an uploaded file');
        }
 
        $info = getImageSize($image['tmp_name']);
 
        if (!$info) {
            throw new Exception('File is not an image');
        }
		
		
		
		
	$slide = array();
	$i=0;
	while($i <= 4) {
		if (array_key_exists('slide' . $i, $_FILES)) {
			
        	$slide[] = $_FILES['slide' . $i];
 
        	// ensure the file was successfully uploaded
        	//assertValidUpload($slide[$i]['error']);
 
        	if (!is_uploaded_file($slide[$i]['tmp_name'])) {
            	unset($slide[$i]);
        	} else {
 
        	$info = getImageSize($slide[$i]['tmp_name']);
 
        	if (!$info) {
            	throw new Exception('File is not an image');
        	}
			}
		}
		$i++;
		
	}
 }
    catch (Exception $ex) {
        $errors[] = $ex->getMessage();
    }
 }//end if img_added
 
	if(empty($_POST['name'])){
		$errors[] = 'You forgot to enter an item name.';
	} else {
		$product = mysqli_real_escape_string($dbc,trim($_POST['name']));
	}
	if(!is_numeric($_POST['price'])){
		$errors[] = 'You forgot to enter a price.';
	} else {
		$price = mysqli_real_escape_string($dbc,trim($_POST['price']));
	}
	if(empty($_POST['desc'])){
		$errors[] = 'You forgot to enter a description.';
	} else {
		$description = mysqli_real_escape_string($dbc,trim($_POST['desc']));
	}
	if(empty($_POST['category'])){
		$errors[] = 'You forgot to enter a category.';
	} else {
		$category = "";
		foreach($_POST['category'] as $cat){
			$category .= $cat .',';
		}
		$category = substr($category,0,-1);
	}
	if(!empty($_POST['colours'])){
		$colours = "";
		foreach($_POST['colours'] as $col){
			$colours .= $col .',';
		}
		$colours = substr($colours,0,-1);
	} else {
		$colours = "";
	}
	if(!empty($_POST['sizes'])){
		$sizes = "";
		foreach($_POST['sizes'] as $size){
			$sizes .= $size .',';
		}
		$sizes = substr($sizes,0,-1);
	} else {
		$sizes = "";
	}
	if(!empty($_POST['stockA'])){
		$stockArray = explode(",",$_POST['stockA']);
		$stock = 0;
		foreach ($stockArray as $i) {
			$stock += $i;
		}
	}elseif(!is_numeric($_POST['in_stock'])){
		$errors[] = 'You forgot to enter number in stock.';
	} else {
		$stock = mysqli_real_escape_string($dbc,trim($_POST['in_stock']));
	}
	if(isset($_POST['on_sale'])){
		if(!is_numeric($_POST['reduced_from'])) {
			$errors[] = 'You forgot to enter a number for the original price.';
		} else {
			$reduced_from = $_POST['reduced_from'];
		}
		$on_sale = 1;
	} else {
		$on_sale = 0;
		$reduced_from = NULL;
	}
	
	//If there are no errors upload product
	if (count($errors) == 0) {
		
		if(isset($_POST['img_added'])) {
			
	$slide_id = array();		
	foreach($slide as $sl){
		$query = sprintf(
            "INSERT INTO slides (site, directory, filename, tn_directory, tn_filename)
                values ('%s', '%s', '%s', '%s', '%s')",
				"../",
				"images/products/large/",
            mysqli_real_escape_string($dbc,$sl['name']),
			"images/products/thumbs/",
            mysqli_real_escape_string($dbc,'tn_' . $sl['name'])
        );
 
        mysqli_query($dbc,$query);
		$slide_id[] = (int) mysqli_insert_id($dbc);
		move_uploaded_file($sl["tmp_name"], "../images/products/" . $sl["name"]);
		
	} // end foreach $slide.
		
		
		
		$query = sprintf(
            "INSERT INTO thumbs (site, directory, filename)
                values ('%s', '%s', '%s')",
				"../",
				"images/products/thumbs/",
            mysqli_real_escape_string($dbc,'tn_' . $image['name'])
        );

        mysqli_query($dbc,$query);
		
 
        
		
		$query = sprintf(
            "INSERT INTO images (site, directory, filename)
                values ('%s', '%s', '%s')",
				"../",
				"images/products/large/",
            mysqli_real_escape_string($dbc,$image['name'])
        );
 
        mysqli_query($dbc,$query);
		
		move_uploaded_file($_FILES["image"]["tmp_name"], "../images/products/" . $_FILES["image"]["name"]);
		
		
		
		include('image_generator.php');
		include('thumbnail_generator.php');
		
		} else {
			
			$query = sprintf(
            "INSERT INTO thumbs (site, directory, filename)
                values ('%s', '%s', '%s')",
				"../",
				"images/products/thumbs/",
            	"no_image.jpg"
        );

        mysqli_query($dbc,$query);
 
		
		$query = sprintf(
            "INSERT INTO images (site, directory, filename)
                values ('%s', '%s', '%s')",
				"../",
				"images/products/large/",
            	"no_image.jpg"
        );
 
        mysqli_query($dbc,$query);
			
		}//end if img_added
		
		
        $id = (int) mysqli_insert_id($dbc);
		
		//image_id was not set correctly
		if($id < 1){
			header("Location: id_not_created.php");
			exit();
		}
		
		
		//INSERT the main product
	   if(isset($reduced_from)) {
		   $query = "INSERT INTO products (`image_id`, `name`, `desc`, `price`, `category`, `size_options`, `colour_options`, `in_stock`, `show_item`, `on_sale`, `reduced_from`) VALUES ('$id', '$product', '$description', '$price', '$category', '$sizes', '$colours', '$stock', 1, '$on_sale', '$reduced_from')";
	   } else {
		   $query = "INSERT INTO products (`image_id`, `name`, `desc`, `price`, `category`, `size_options`, `colour_options`, `in_stock`, `show_item`, `on_sale`) VALUES ('$id', '$product', '$description', '$price', '$category', '$sizes', '$colours', '$stock', 1, '$on_sale')";
	   }
	   
	   $qu = @mysqli_query($dbc, $query);
	   if(!$qu){
		   header("Location: qu_not_created.php");
		   exit();
	   }
	   $p_id = (int) mysqli_insert_id($dbc);
	   
	   //SET product_id FOR images AND thumbs
	   $query = "UPDATE images SET product_id = $p_id WHERE image_id = '$id'";
	   @mysqli_query($dbc,$query);
	   $query = "UPDATE thumbs SET product_id = $p_id WHERE image_id = '$id'";
	   @mysqli_query($dbc,$query);
	   if(!empty($slide_id)) :
	   	 foreach($slide_id as $s_id) {
	   		$query = "UPDATE slides SET product_id = $p_id WHERE slide_id = '$s_id'";
	   		@mysqli_query($dbc,$query);
	     }
	   endif;
	   
	   
	   
	   //INSERT options of product
	   
	   if(!empty($_POST['colours']) && !empty($_POST['sizes'])){
			
			$index = 0;
			
			foreach ($_POST['colours'] as $col){
				foreach ($_POST['sizes'] as $size){
					if(isset($reduced_from)) {
					$query = "INSERT INTO product_opts 
					(`product_id`, `image_id`, `name`, `desc`, `price`, `category`, `size_options`, `colour_options`, `in_stock`, `show_item`, `on_sale`, `reduced_from`) 
					VALUES ('$p_id', '$id', '$product', '$description', '$price', '$category', '$size', '$col', '$stockArray[$index]', 0, '$on_sale', '$reduced_from')";
					} else {
						$query = "INSERT INTO product_opts 
					(`product_id`, `image_id`, `name`, `desc`, `price`, `category`, `size_options`, `colour_options`, `in_stock`, `show_item`, `on_sale`) 
					VALUES ('$p_id', '$id', '$product', '$description', '$price', '$category', '$size', '$col', '$stockArray[$index]', 0, '$on_sale')";
					}
	   
	   				$cs = @mysqli_query($dbc, $query);
	   				if(!$cs){
		   				header("Location: cs_not_created.php");
		   				exit();
	  				}
						  
					$index++;					
				}
			}
		} else if(!empty($_POST['colours'])){
			
			$index = 0;
			
			foreach ($_POST['colours'] as $col){
					if(isset($reduced_from)) {
					$query = "INSERT INTO product_opts 
					(`product_id`, `image_id`, `name`, `desc`, `price`, `category`, `colour_options`, `in_stock`, `show_item`, `on_sale`, `reduced_from`) 
					VALUES ('$p_id', '$id', '$product', '$description', '$price', '$category', '$col', '$stockArray[$index]', 0, 'on_sale', '$reduced_from')";
					} else {
						$query = "INSERT INTO product_opts 
					(`product_id`, `image_id`, `name`, `desc`, `price`, `category`, `colour_options`, `in_stock`, `show_item`, `on_sale`) 
					VALUES ('$p_id', '$id', '$product', '$description', '$price', '$category', '$col', '$stockArray[$index]', 0, '$on_sale')";
					}
	   
	   				$c = @mysqli_query($dbc, $query);
	   				if(!$c){
		   				header("Location: c_not_created.php");
		   				exit();
	  				}
						  
					$index++;
			}
		} else if(!empty($_POST['sizes'])){
			
			$index = 0;
			
				foreach ($_POST['sizes'] as $size){
					if(isset($reduced_from)) {
					$query = "INSERT INTO product_opts 
					(`product_id`, `image_id`, `name`, `desc`, `price`, `category`, `size_options`, `in_stock`, `show_item`, `on_sale`, `reduced_from`) 
					VALUES ('$p_id', '$id', '$product', '$description', '$price', '$category', '$size', '$stockArray[$index]', 0, '$on_sale', '$reduced_from')";
					} else {
						$query = "INSERT INTO product_opts 
					(`product_id`, `image_id`, `name`, `desc`, `price`, `category`, `size_options`, `in_stock`, `show_item`, `on_sale`) 
					VALUES ('$p_id', '$id', '$product', '$description', '$price', '$category', '$size', '$stockArray[$index]', 0, '$on_sale')";
					}
	   
	   				$s = @mysqli_query($dbc, $query);
	   				if(!$s){
		   				header("Location: s_not_created.php");
		   				exit();
	  				}
						  
					$index++;					
				}
		} else { //no size or colour options
		
		if(isset($reduced_from)) {
					$query = "INSERT INTO product_opts 
					(`product_id`, `image_id`, `name`, `desc`, `price`, `category`, `in_stock`, `show_item`, `on_sale`, `reduced_from`) 
					VALUES ('$p_id', '$id', '$product', '$description', '$price', '$category', '$stock', 0, '$on_sale', '$reduced_from')";
					} else {
						$query = "INSERT INTO product_opts 
					(`product_id`, `image_id`, `name`, `desc`, `price`, `category`, `in_stock`, `show_item`, `on_sale`) 
					VALUES ('$p_id', '$id', '$product', '$description', '$price', '$category', '$stock', 0, '$on_sale')";
					}
	   
	   				$ncs = @mysqli_query($dbc, $query);
	   				if(!$ncs){
		   				header("Location: ncs_not_created.php");
		   				exit();
	  				}
			
		}
	   
	   
	   // finally, redirect the user to view the new image
        header('Location: view.php?id=' . $id . '&p_id=' . $p_id);
		foreach($_FILES as $k => $v){
			//echo $k . '=' . $v . '<br />';
		}
        exit();
	   
	   
	}//END COUNT ERRORS
?>
<html>
    <head>
        <title>Error</title>
    </head>
    <body>
        <div>
            <p>
                The following errors occurred:
            </p>
 
            <ul>
                <?php foreach ($errors as $error) { ?>
                    <li>
                        <?php echo htmlSpecialChars($error) ?>
                    </li>
                <?php } ?>
            </ul>
 
            <p>
                <a href="upload.php">Try again</a>
            </p>
        </div>
    </body>
</html>