<?php
$is_image = true;
include_once("include.php");
include_once("bannerGen.php");
include "begin_caching.php";
include "start.php";
$res = true;
$res = getRadioData();
$VerticalIdx = str_replace("\n", "", $VerticalIdx);
$path_to_cache = "cachedRadiosonde.png";
$colorVerticalIdx = "";
if ($VerticalIdx > 26.5)
	$colorVerticalIdx = "ffffff";
else
	$colorVerticalIdx = "ffffff";
if ($t850 > 0)
	$color850 = "ffffff";
else
	$color850 = "ffffff";
if ($t700 > 0)
	$color700 = "ffffff";
else
	$color700 = "ffffff";
if ($t500 > 0)
	$color500 = "ffffff";
else
	$color500 = "ffffff";
$text = array();
if (isHeb())
{
	array_push($text, array('txt' => sprintf("%02dZ ", $hoursonde), 'color' => "ffffff"));
	array_push($text, array('txt' => $t850."C = 850T     ", 'color' => $color850));
	array_push($text, array('txt' => $t700."C = 700T     ", 'color' => $color700));
	array_push($text, array('txt' => $t500."C = 500T     ", 'color' => $color500));
	if ($inversionThickness > 0)
	{
		array_push($text, array('txt' => $baseInversionHeight."m = ".utf8_strrev($BASE[$HEB]), 'color' => "ffffff"));
		array_push($text, array('txt' => $inversionThickness."m"." = ".utf8_strrev($THICKNESS[$HEB]), 'color' => "ffffff"));
	}
	if (($month > 9) || ($month < 4))
		array_push($text, array('txt' => "    ".$VerticalIdx."C = ".utf8_strrev($CURRENT_INSTABLITY[$HEB]), 'color' => $colorVerticalIdx));
	else if ($FireIdx > 4)
		array_push($text, array('txt' => "     ".$FireIdx." = ".utf8_strrev($FIRE_INDEX[$HEB]), 'color' => "ffffff"));
	
	
}
else
{
	array_push($text, array('txt' => sprintf("%02dZ ", $hoursonde), 'color' => "ffffff"));
	array_push($text, array('txt' => $t850."C = 850T     ", 'color' => $color850));
	array_push($text, array('txt' => $t700."C = 700T     ", 'color' => $color700));
	array_push($text, array('txt' => $t500."C = 500T     ", 'color' => $color500));
	if ($inversionThickness > 0)
	{
		array_push($text, array('txt' => $baseInversionHeight."m = ".$BASE[$EN], 'color' => "ffffff"));
		array_push($text, array('txt' => $inversionThickness."m"." = ".$THICKNESS[$EN], 'color' => "ffffff"));
	}
	if (($month > 9) || ($month < 4))
		array_push($text, array('txt' => "    ".$VerticalIdx."C = ".$CURRENT_INSTABLITY[$EN], 'color' => "ffffff"));
	else if ($FireIdx > 4)
		array_push($text, array('txt' => "     ".$FireIdx." = ".$FIRE_INDEX[$EN], 'color' => "ffffff"));
	
	
}
if ($res)
	bannerGen($text, null, 130, 187, 124, 154, 214, 10, "images/".$path_to_cache);
else
	bannerGen(null, $path_to_cache, 130, 187, 124, 154, 214, 10, null);
?>
<? include "end_caching.php"; ?>