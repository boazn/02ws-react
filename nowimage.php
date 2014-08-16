<?
$is_image = true;
include_once("include.php");
include_once("bannerGen.php");
//include "begin_caching.php";
include "start.php";
include "sigweathercalc.php";
$path_to_cache = "cachednow.png";
$colorTemp = "";
if (isHeb()) $date = $dateInHeb; 

if ($current->get_temp() <= 0)
	$colorTemp = "0000ff"; // blue
else if ($current->get_temp() > 20)
	$colorTemp = "ffffff"; // white
else 
	$colorTemp = "ffffff"; // white
$it_feels_title = "";
if (min($current->get_windchill(), $current->get_thw()) < ($current->get_temp() - 1) && $current->get_temp() < 20 ){

$it_feels_title = $IT_FEELS[$lang_idx]." ".min($current->get_windchill(), $current->get_thw())."&#176;";
}
else if ($current->get_HeatIdx() > ($current->get_temp())){
  $it_feels_title = $IT_FEELS[$lang_idx]." ".max($current->get_HeatIdx(), $current->get_thw())."&#176;"; 
}
$text = array(); 
if (isHeb())
{
	array_push($text, array('txt' => "   ".$date." ".utf8_strrev($LOGO[$HEB]),  'color' => "ffffff", 'size' => 10));
	array_push($text, array('txt' => $current->get_temp().$current->get_tempunit(),  'color' => $colorTemp, 'size' => 30));
	array_push($text, array('txt' => utf8_strrev(getWindStatus()), 'color' => "ffffff", 'size' => 15));
        array_push($text, array('txt' => "cold_meter", 'color' => "ffffff", 'size' => 10));
	array_push($text, array('txt' => $it_feels_title, 'color' => "ffffff" , 'size' => 10));
	array_push($text, array('txt' => "  ".utf8_strrev($sig[0]['sig'][$HEB]), 'color' => "ffffff", 'size' => 10));
        array_push($text, array('txt' => "  ".utf8_strrev($sig[0]['extrainfo'][$HEB]), 'color' => "ffffff", 'size' => 10));
	
}
else
{
	array_push($text, array('txt' => "   ".$date." ".$LOGO[$HEB],  'color' => "ffffff", 'size' => 10));
	array_push($text, array('txt' => $current->get_temp().$current->get_tempunit(),  'color' => $colorTemp, 'size' => 30));
	array_push($text, array('txt' => getWindStatus(), 'color' => "ffffff", 'size' => 15));
        array_push($text, array('txt' => "cold_meter", 'color' => "ffffff", 'size' => 10));
	array_push($text, array('txt' => $it_feels_title, 'color' => "ffffff" , 'size' => 10));
	array_push($text, array('txt' => $sig[0]['sig'][$EN], 'color' => "ffffff", 'size' => 10));
        array_push($text, array('txt' => $sig[0]['extrainfo'][$EN], 'color' => "ffffff", 'size' => 10));
	
}
bannerGen($text, null, 300, 300, 124, 154, 214, 10, "images/".$path_to_cache)
?>
<? //include "end_caching.php"; ?>