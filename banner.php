<?
$is_image = true;
include_once("include.php");
include_once("bannerGen.php");
include "begin_caching.php";
include "start.php";
include "sigweathercalc.php";
$addSigWeather = false;
$path_to_cache = "cachedBanner.png";
if (($sig[0]['sig'] == $RAIN_HAS_JUST_STOPPED) ||
	($sig[0]['sig'] == $ITS_RAINING) ||
	($sig[0]['sig'] == $ITS_SNOWING))
	{
		if ($today->get_rain() > 0.3)
			$addSigWeather = true;
	}
$colorTemp = "";
if ($current->get_temp() <= 0)
	$colorTemp = "0000ff"; // blue
else if ($current->get_temp() > 20)
	$colorTemp = "ffffff"; // white
else 
	$colorTemp = "ffffff"; // white
$text = array(); 
if (isHeb())
{
	array_push($text, array('txt' => "   ".$hour.":".sprintf("%02d", $min)." ".utf8_strrev($PLACE[$HEB]),  'color' => "ffffff"));
	array_push($text, array('txt' => $current->get_temp()."&#176;C",  'color' => $colorTemp));
	array_push($text, array('txt' => $current->get_hum()."% ".utf8_strrev($HUMIDITY[$HEB]), 'color' => "ffffff"));
	array_push($text, array('txt' => $current->get_winddir()."    ".utf8_strrev($KNOTS[$HEB])." ".$current->get_windspd(), 'color' => "ffffff" ));
	array_push($text, array('txt' => "  ".$today->get_rain()."mm"." :".utf8_strrev($DAILY_RAIN[$HEB])."  ", 'color' => "ffffff"));
	if ($addSigWeather)
		array_push($text, array('txt' => "  ".utf8_strrev($sig[0]['sig'][$HEB]), 'color' => "ffffff"));
	else
		array_push($text, array('txt' => "  ".$seasonTillNow->get_rain()."mm"." :".utf8_strrev($TOTAL_RAIN[$HEB])."    ", 'color' => "ffffff"));
	array_push($text, array('txt' => "-----------------------------", 'color' => "ffffff"));
}
else
{
	array_push($text, array('txt' => $hour.":".sprintf("%02d", $min)." ".$PLACE[$EN],  'color' => "ffffff"));
	array_push($text, array('txt' => $current->get_temp()."&#176;C",  'color' => $colorTemp));
	array_push($text, array('txt' => $current->get_hum()."% ".$HUMIDITY[$EN], 'color' => "ffffff"));
	array_push($text, array('txt' => $current->get_winddir()."    ".$KNOTS[$EN]." ".$current->get_windspd(), 'color' => "ffffff" ));
	array_push($text, array('txt' => "	".$DAILY_RAIN[$EN].": ".$today->get_rain()."mm", 'color' => "ffffff"));
	if ($addSigWeather)
		array_push($text, array('txt' => $sig[0]['sig'][$EN], 'color' => "ffffff"));
	array_push($text, array('txt' => "	".$TOTAL_RAIN[$EN].": ".$seasonTillNow->get_rain()."mm", 'color' => "ffffff"));
}
bannerGen($text, null, 120, 187, 124, 154, 214, 10, "images/".$path_to_cache)
?>
<? include "end_caching.php"; ?>