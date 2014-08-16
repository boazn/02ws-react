<?php
include_once('include.php');
$string = $_GET['text'];
if (isset($_GET['image']))
	$im = imagecreatefrompng("images/{$_GET['image']}");
 else
	$im = imagecreatetruecolor ($_GET['width'],$_GET['height']);
$bg2 = $_GET['bg2'];
$bg = $_GET['bg'];

$textcolor = imagecolorallocate($im, 204, 204, 204);

$px    = (imagesx($im) - 7.5 * strlen($string)) / 2;
ImageRectangleGradientRoundedCorners($im, 0, 0, $_GET['width'], $_GET['height'], 10, $bg, $bg2);
if (isset($string))
	imagestring($im, 3, $px, 4, $string, $textcolor);
header("Content-type: image/png; charset=utf-8");
imagepng($im);
imagedestroy($im);
//drawRating(10);
?> 