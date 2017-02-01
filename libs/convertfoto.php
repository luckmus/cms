<?php
 
   include "vars.php";
   //include "libs/helpers.php"; 
   //@session_start();
    global $jpeg_file; 
    global $jpeg_file_newname;
   //$jpeg_file = "C:/xampplite/htdocs/briz/uploadfiles/foto_144.jpg";
   //$jpeg_file    = $_SESSION['jpeg_file'];
   //$jpeg_newName = 'small_'.$_SESSION['jpeg_file_newname']; 
    
   //$jpeg_newName = $jpeg_file_newname;
   //$jpeg_newName  =    
   //addLog($jpeg_file);
   if (subStr(strtolower($jpeg_file),StrLen($jpeg_file)-4,StrLen($jpeg_file)) != '.jpg')
    return;

   $img = imagecreatefromjpeg($jpeg_file);
  
  $w = imageSX($img);
  $h = imageSY($img);
  if ($w>$h)
  {
    $w_n = $width_n;
    $h_n = $height_n;
  }
  else
  {
    $h_n = $width_n;
    $w_n = $height_n;
  }             
  if ($jpeg_file_newname != '')
  {
     $jpeg_newName = 'small_'.$jpeg_file_newname;
     if (subStr(strtolower($jpeg_newName),StrLen($jpeg_newName)-4,StrLen($jpeg_newName)) != '.jpg')
        $jpeg_newName = "$jpeg_newName.jpg";  
     $imgSmall = imagecreatetruecolor ($w_n,$h_n);
     imagecopyresized ($imgSmall,$img,0,0,0,0,$w_n,$h_n,$w,$h); 
  
    if ($imgSmall)
    {
        // ¬ыводим изображение в браузер с качеством равным 50
        //header("Content-type: " .image_type_to_mime_type(IMAGETYPE_JPEG));
        //$jpeg_newName = GetHost()._UploadDir.'/'._SmallFoto."/$jpeg_newName";
        $uri = $_SERVER['REQUEST_URI'];
        $uri = subStr($uri,1);
        $uri = subStr($uri,0,strPos($uri,"/"));  
        //$jpeg_newName = $_SERVER['DOCUMENT_ROOT']."/".$uri.'/'._UploadDir.'/'._SmallFoto."/$jpeg_newName";
        $jpeg_newName = $_SERVER['DOCUMENT_ROOT'].'/'._UploadDir.'/'._SmallFoto."/$jpeg_newName";
        //addLog($jpeg_newName);
        imagejpeg($imgSmall, "$jpeg_newName");
        //imagejpeg($imgSmall);
        imagedestroy($imgSmall);
        imagedestroy($img);
    
  }  
  }
  else
  {
        if ($imgSmall)
        {
            header("Content-type: " .image_type_to_mime_type(IMAGETYPE_JPEG));   
            imagejpeg($img);
            imagedestroy($imgSmall);
            imagedestroy($img);
        }
  }
?>