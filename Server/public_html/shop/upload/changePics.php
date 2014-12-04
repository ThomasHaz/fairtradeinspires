<?php
$id = $_POST['id'];


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
    try {
		if (!array_key_exists('thumb', $_FILES)) {
            throw new Exception('thumb not found in uploaded data');
        }
 
        $thumb = $_FILES['thumb'];
 
        // ensure the file was successfully uploaded
        assertValidUpload($thumb['error']);
 
        if (!is_uploaded_file($thumb['tmp_name'])) {
            throw new Exception('File is not an uploaded file');
        }
 
        $tn_info = getImageSize($thumb['tmp_name']);
 
        if (!$tn_info) {
            throw new Exception('File is not an image');
        }
		
		
		
		
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
    }
    catch (Exception $ex) {
        $errors[] = $ex->getMessage();
    }


//If there are no errors upload product
	if (count($errors) == 0) {
		
		
		//$query = "UPDATE thumbs SET `filename` = " . $thumb['name'] . " WHERE `image_id` = '$id'";

$query = "UPDATE thumbs SET `filename` = '$thumb[name]' WHERE `image_id` = '$id'";
        mysqli_query($dbc,$query);
		
		move_uploaded_file($_FILES["thumb"]["tmp_name"], "../img/thumbs/" . $_FILES["thumb"]["name"]);
 
 
 
        
		
		//$query = "UPDATE images SET `filename` = " . $image['name'] . " WHERE `image_id` = '$id'";
 $query = "UPDATE images SET `filename` = '$image[name]', `directory` = 'img/large/' WHERE `image_id` = '$id'";
        mysqli_query($dbc,$query);
		
		move_uploaded_file($_FILES["image"]["tmp_name"], "../img/large/" . $_FILES["image"]["name"]);
		
		
	} else {
		echo $errors[0];
	}

header("Location: " . $_SERVER['HTTP_REFERER']);


?>