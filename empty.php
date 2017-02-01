<?php
header("Cache-Control: no-cache, must-revalidate");
$img = imageCreate(150, 65);

$black = imageColorAllocate($img, 0, 0, 0);
$white = imageColorAllocate($img, 255, 255, 255);
$orange = imageColorAllocate($img, 255, 128, 64);
$green = imageColorAllocate($img, 0, 255, 150);
$lightorange = imageColorAllocate($img, 255, 220, 164);

imageFilledRectangle($img, 0, 0, 150, 65, $green);

imageRectangle($img, 0, 0, 149, 64, $black);

//imageRectangle($img, 5, 5, 94, 64, $black);

imagefontheight(500);
//imageString ($img, 7, 20, 40, $s, $black);

imagePNG($img);

?>

