<?php
$is_image = true;
include "begin_caching.php";
include_once ("ini.php");
include_once("include.php");
include_once("bannerGen.php");
include_once("start.php");
if ((@$_GET['lang'] == "") 	|| (@$_GET['lang'] == 1))
{
	$text =  " ".utf8_strrev($SLOGAN[$HEB])."    ^       ^ ^aa 1234"."  KNots";
}
else
{
	$text =  " Jerusalem Now                          ";
}
//echo $text;
 bannerGen($text, "header/bannerlights.png", 120, 180, 66, 102, 125, 255, 255, 255, 20, null)
?>
<? include "end_caching.php"; ?>