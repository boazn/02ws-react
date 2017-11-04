<?
ini_set('error_reporting', E_ALL);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$prefix = "../";
include_once("../include.php");
include_once("../start.php");
header('Content-Type: application/json');
        
        
function fix_forecast ($frcstTable)
{
 global $lang_idx, $DRIZZLE, $PARTLY, $CLOUDY, $PARTLY_CLOUDY, $MOSTLY, $CLEAR, $HAZE, $LOCAL_RAIN, $LIGHT_RAIN, $RAIN, $VERY_HOT_HEAT_WAVE, $PROB, $AFTERNOON, $NIGHT, $DAY, $AND, $THE, $DURING, $CLOUDY, $WINDY, $AT_TIMES, $MORNING, $SNOW, $LIGHT_SNOW, $OR, $SLEET, $CHANCE_FOR, $GENERALLY, $STRONG_WINDS, $OCCASIONALLY, $HAZE, $THUNDERSTORM, $VERY_DRY, $WARMER_THAN_AVERAGE, $TO, $CHANCE_OF, $HEAVY_RAIN, $FOG, $LATER, $AT_FIRST, $STORMY, $BECMG, $FROM, $EVENING, $OCCASIONAL, $VERY, $WARM_WIND, $DUST, $ISOLATED;
 
 /*$frcstTable = str_replace ( " Jan", "/01&nbsp;&nbsp;", $frcstTable);
 $frcstTable = str_replace ( " Feb", "/02&nbsp;&nbsp;", $frcstTable);
 $frcstTable = str_replace ( " Mar", "/03&nbsp;&nbsp;", $frcstTable);
 $frcstTable = str_replace ( " Apr", "/04&nbsp;&nbsp;", $frcstTable);
 $frcstTable = str_replace ( " May", "/05&nbsp;&nbsp;", $frcstTable);
 $frcstTable = str_replace ( " Jun", "/06&nbsp;&nbsp;", $frcstTable);
 $frcstTable = str_replace ( " Jul", "/07&nbsp;&nbsp;", $frcstTable);
 $frcstTable = str_replace ( " Aug", "/08&nbsp;&nbsp;", $frcstTable);
 $frcstTable = str_replace ( " Sep", "/09&nbsp;&nbsp;", $frcstTable);
 $frcstTable = str_replace ( " Oct", "/10&nbsp;&nbsp;", $frcstTable);
 $frcstTable = str_replace ( " Nov", "/11&nbsp;&nbsp;", $frcstTable);
 $frcstTable = str_replace ( " Dec", "/12&nbsp;&nbsp;", $frcstTable);
 $frcstTable = replaceDays($frcstTable);*/
 //$frcstTable = strtolower($frcstTable);
 $frcstTable = str_replace ( "Isolated", $ISOLATED[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "Sunny", $CLEAR[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "WARMER THAN USUAL", $WARMER_THAN_AVERAGE[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "Drizzle", $DRIZZLE[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "Partly Cloudy", $PARTLY_CLOUDY[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "Fair", "$MOSTLY[$lang_idx] $CLEAR[$lang_idx]", $frcstTable);
 $frcstTable = str_replace ( "HAZE", $HAZE[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "LIGHT LOCAL RAIN", $LIGHT_RAIN[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "Local Rain", $LOCAL_RAIN[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "LOCAL SHOWERS", $LOCAL_RAIN[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "Local Shower", $LOCAL_RAIN[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "Light Rain Shower", $LIGHT_RAIN[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "Light Rain", $LIGHT_RAIN[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "Light Shower", $LIGHT_RAIN[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "Showers", $RAIN[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "Shower", $RAIN[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "Rainy", $RAIN[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "Dusty", $DUST[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "Dust", $DUST[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "Rain", $RAIN[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "Fog", $FOG[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "Periods", $OCCASIONALLY[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "LIGHT SNOW", $LIGHT_SNOW[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "Thundershowers", $THUNDERSTORM[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "Thunderstorms", $THUNDERSTORM[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "THUNDER", " ".$THUNDERSTORM[$lang_idx]." ", $frcstTable);
 $frcstTable = str_replace ( "Storm", " ", $frcstTable);
 $frcstTable = str_replace ( "Snow", $SNOW[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "Sleet", $SLEET[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "Clear", $CLEAR[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "Strong Winds", $STRONG_WINDS[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "Hot And Dry", $VERY_HOT_HEAT_WAVE[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "HEAT WAVE", $VERY_HOT_HEAT_WAVE[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "Haze", $HAZE[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "POSSIBILITY OF", $PROB[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "POSSIBLE", $PROB[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "AFTERNOON", $AFTERNOON[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "Morning", $MORNING[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "FROM EVENING", $FROM[$lang_idx]." ".$EVENING[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( " Night", $NIGHT[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( " Day", $DAY[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "And", $AND[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "THE", "", $frcstTable);
 $frcstTable = str_replace ( "Warm", "", $frcstTable);
 $frcstTable = str_replace ( "During", $DURING[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "Cloudy", $CLOUDY[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "Overcast", $CLOUDY[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "Windy", $WINDY[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "Dry", $VERY_DRY[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "CHANCE FOR", $CHANCE_FOR[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "AT TIMES", $AT_TIMES[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "OCCASIONAL", $OCCASIONAL[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "Generally", $GENERALLY[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( " OR ", " ".$OR[$lang_idx]." ", $frcstTable);
 $frcstTable = str_replace ( "LOCAL", "", $frcstTable);
 $frcstTable = str_replace ( "With", "", $frcstTable);
 $frcstTable = str_replace ( " To ", " ".$TO[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "A POSSIBILITY OF", $CHANCE_OF[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "Chance Of", $CHANCE_OF[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "Period", $OCCASIONAL[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "Intervals", $OCCASIONAL[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "Interval", $OCCASIONAL[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "Heavy Rain", $HEAVY_RAIN[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "Mostly", $GENERALLY[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "Spells", $FOG[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "FEW", " ", $frcstTable);
 $frcstTable = str_replace ( " IN ", " ", $frcstTable);
 $frcstTable = str_replace ( "MAINLY", $GENERALLY[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "LATER", $LATER[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "AT FIRST", $AT_FIRST[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "Scattered", " ", $frcstTable);
 $frcstTable = str_replace ( "Fine", $CLEAR[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "FLURRIES", $SNOW[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "BECOMING", $BECMG[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "Frequent", $OCCASIONAL[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "Very", "" , $frcstTable);
 if (isHeb())
	$frcstTable = str_replace ( "DESERT WIND", $WARM_WIND[$lang_idx] , $frcstTable);
 
 return $frcstTable;
}


        
        
	$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : "";
	//$forecast_full_page = @file_get_contents($location);
        $url = $location;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $output = curl_exec($curl);
        curl_close($curl);
              
        $output = fix_forecast($output);
        echo $output;
        //$DOM = new DOMDocument;
        //$DOM->loadHTML( $output);
        	
	
	
 ?>
