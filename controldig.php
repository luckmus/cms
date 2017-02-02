<?php
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); 
@session_start();
$s=rand(1000,9999);
$_SESSION['contrdig']=$s;
$img = imageCreate(120, 65);

$black = imageColorAllocate($img, 0, 0, 0);
$white = imageColorAllocate($img, 255, 255, 255);
$orange = imageColorAllocate($img, 255, 128, 64);
$green = imageColorAllocate($img, 0, 255, 150);
$lightorange = imageColorAllocate($img, 255, 220, 164);

imageFilledRectangle($img, 0, 0, 120, 65, $green);

imageRectangle($img, 0, 0, 119, 64, $black);

//imageRectangle($img, 5, 5, 94, 64, $black);

imagefontheight(500);
//imageString ($img, 7, 20, 40, $s, $black);
for ($i=0; $i<4; $i++)
switch (rand(0,1))
{
       case 0:
        imagettftext ($img, 20, rand(0,70), 20+(20*$i), 40, $white, "font/arial.ttf", substr($s,$i,1));
       break;
       case 1:
        imagettftext ($img, 20, rand(290,360), 20+(20*$i), 40, $white, "font/arial.ttf", substr($s,$i,1));
       break;
}
imagePNG($img);

?>

