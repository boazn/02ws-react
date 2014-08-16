<?php
session_start();
$passlen = 6;
$height = 30;
$width = 200;
$possiblechars =
"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
$code = "";

// generate random letters
for($i = 0; $i<$passlen; $i++){
   $code = $code .
substr($possiblechars,rand(0,strlen($possiblechars)-1),1);
}

// lowercase > hash > store in session-variable
$_SESSION['code'] = md5(strtolower($code));

$image = imageCreateTrueColor($width, $height);

// make a gradient
for($i=0; $i<$width; $i++){
   $color = imagecolorallocate($image, $i*180/$width+75,
$i*180/$width+75, $i*180/$width+75);
   imageline($image, $i, 0, $i, $height, $color);
}

// print out the letters
for($i=0; $i<$passlen; $i++){
   $r = rand($i*13,$i*15);
   $textcolor = imageColorAllocate($image, $r, $r, $r);
   $font = rand(3,5);
   imagestring($image, $font, $width/$passlen*$i+rand(4,7),
$height/2-rand(imagefontheight($font)/2, imagefontheight($font)),
substr($code,$i,1), $textcolor);
}

// draw border
$bordercolor = imagecolorallocate($image, 80, 80, 80);
imagerectangle($image,0,0,$width-1,$height-1,$bordercolor);

// fix headers to avoid caching
header("Expires: Wed, 1 Jan 1997 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

header('Content-type: image/gif'); // set content-type
imageGIF($image); // output the image
imageDestroy($image); // destroy image to free memory
?>