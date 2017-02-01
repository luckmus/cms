<?php
header( "Content-Type: text/html; charset=windows-1251" );
session_start();
include "libs/helpers.php";
include "libs/vars.php";
include "config.php";
$ImgSrc= $_GET['imgsrc'];  
$Imgwdth= $_GET['imgwdth'];
$Imghght= $_GET['imghght'];

//$ImgSrc="http://127.0.0.1/test/$ImgSrc";
$host = rtrim(GetHost(), "/");
//$ImgSrc=$host._domen."/"._UploadDir."/$ImgSrc";
$ImgSrc=$host."/"._UploadDir."/$ImgSrc";
//$ImgSrc=$host."/"._UploadDir."/$ImgSrc";
addLog($ImgSrc);
if (($Imgwdth!='') && ($Imghght!=''))
    print "<img id='img_' height='$Imghght' width='$Imgwdth' src='$ImgSrc'>";
else
    print "<img id='img_' src='$ImgSrc'>";
?>