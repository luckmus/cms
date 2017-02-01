<?php
//$upperLevel=$_GET['ulvl'];
include $upperLevel."libs/vars.php";

   $img_name=$_GET['imgname'];

    $jpeg_file = $img_name;

   if (subStr(strtolower($jpeg_file),StrLen($jpeg_file)-4,StrLen($jpeg_file)) != '.jpg')
    return;

   $img = imagecreatefromjpeg($upperLevel."uploadfiles/$jpeg_file");

  $w = imageSX($img);
  $h = imageSY($img);
  if ($w>$h)
  {
    $w_n = $width_n;
    $h_n = $height_n;
  }
  else
if ($w<$h)
  {
    $h_n = $width_n;
    $w_n = $height_n;
  }   
  else
if ($w=$h)          
  {
    $h_n = $width_n;
    $w_n = $height_n;
  }   
      
   $imgSmall = imagecreatetruecolor ($w_n,$h_n);
   imagecopyresized ($imgSmall,$img,0,0,0,0,$w_n,$h_n,$w,$h); 
   header("Content-type: " .image_type_to_mime_type(IMAGETYPE_JPEG));           
   imagejpeg($imgSmall);
?>