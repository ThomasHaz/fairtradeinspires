<?php 
$imagefolder='../images/products/';
$thumbsfolder='../images/products/large/';
$tn_w = 500;
$tn_h = 500;
$pics=directory2($imagefolder,"jpg,jpeg,gif");
if ($pics[0]!="")
{
	foreach ($pics as $p)
	{
		createimage($p,$p,$tn_w,$tn_h);
	}
}


/*
	Function createthumb($name,$filename,$new_w,$new_h)
	creates a resized image
	variables:
	$name		Original filename
	$filename	Filename of the resized image
	$new_w		width of resized image
	$new_h		height of resized image
*/	
function createimage($name,$filename,$new_w,$new_h)
{
	$tn_h = 500;
	$tn_w = 500; 
	$system=explode(".",$name);
	$sys=pathinfo($name);
	$dir = "../images/products/";
	$tn_dir = "../images/products/large/";
	if (preg_match("/jpeg|jpg/",$sys['extension'])){$src_img=imagecreatefromjpeg($dir . $name);}
	if (preg_match("/gif/",$sys['extension'])){$src_img=imagecreatefromgif($dir . $name);}
	//$src_img=imagecreatefromjpeg("../../../img/large/" . $name);
	$old_x=imageSX($src_img);
	$old_y=imageSY($src_img);
	$disp_x = 0;
	$disp_y = 0;
	if ($old_x > $old_y) 
	{
		$thumb_w=$new_w;
		$thumb_h=$old_y*($new_h/$old_x);
		$disp_y = ($tn_h - $thumb_h)/2;
	}
	if ($old_x < $old_y) 
	{
		$thumb_w=$old_x*($new_w/$old_y);
		$thumb_h=$new_h;
		$disp_x = ($tn_w - $thumb_w)/2;
	}
	if ($old_x == $old_y) 
	{
		$thumb_w=$new_w;
		$thumb_h=$new_h;
	}
	$dst_img=ImageCreateTrueColor($tn_w,$tn_h);//($thumb_w,$thumb_h);
	$white = imagecolorallocate($dst_img, 255, 255, 255);
imagefill($dst_img, 0, 0, $white);
	
	imagecopyresampled($dst_img,$src_img,$disp_x,$disp_y,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 
	if (preg_match("/gif/",$sys['extension']))
	{
		imagegif($dst_img,$filename); 
	} else {
		imagejpeg($dst_img,$tn_dir . $filename); 
	}
	imagedestroy($dst_img); 
	imagedestroy($src_img); 
}

/*
        Function directory($directory,$filters)
        reads the content of $directory, takes the files that apply to $filter 
		and returns an array of the filenames.
        You can specify which files to read, for example
        $files = directory(".","jpg,gif");
                gets all jpg and gif files in this directory.
        $files = directory(".","all");
                gets all files.
*/
function directory2($dir,$filters)
{
	$handle=opendir($dir);
	$files=array();
	if ($filters == "all"){while(($file = readdir($handle))!==false){$files[] = $file;}}
	if ($filters != "all")
	{
		$filters=explode(",",$filters);
		while (($file = readdir($handle))!==false)
		{
			for ($f=0;$f<sizeof($filters);$f++):
				//$system=explode(".",$file);
				//if ($system[1] == $filters[$f]){$files[] = $file;}
				$sys=pathinfo($file);
				if($sys['extension'] == $filters[$f]){$files[] = $file;}
				
			endfor;
		}
	}
	closedir($handle);
	return $files;
}
?>
