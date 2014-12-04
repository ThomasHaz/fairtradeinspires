<?php 
$imagefolder='../images/products/large/';
$thumbsfolder='../images/products/thumbs/';
$tn_w = 200;
$tn_h = 200;
$pics=directory($imagefolder,"jpg");
$pics=ditchtn($pics,"tn_");
if ($pics[0]!="")
{
	foreach ($pics as $p)
	{
		createthumb($p,"tn_".$p,$tn_w,$tn_h);
	}
}

/*
	Function ditchtn($arr,$thumbname)
	filters out thumbnails
*/
function ditchtn($arr,$thumbname)
{
	foreach ($arr as $item)
	{
		if (!preg_match("/^".$thumbname."/",$item)){$tmparr[]=$item;}
	}
	return $tmparr;
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
function createthumb($name,$filename,$new_w,$new_h)
{
	$tn_h = 200;
	$tn_w = 200;
	$system=pathinfo($name);
	$dir = "../images/products/large/";
	$tn_dir = "../images/products/thumbs/";
	if (preg_match("/jpeg|jpg/",$system['extension'])){$src_img=imagecreatefromjpeg($dir . $name);}
	if (preg_match("/gif/",$system['extension'])){$src_img=imagecreatefromgif($dir . $name);}
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
	if (preg_match("/gif/",$system['extension']))
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
function directory($dir,$filters)
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
				$system=pathinfo($file);
				if ($system['extension'] == $filters[$f]){$files[] = $file;}
			endfor;
		}
	}
	closedir($handle);
	return $files;
}
?>
