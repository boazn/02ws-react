<?
	$prefix = "../";
	include_once("../include.php");
	include_once("../start.php");
	function fix_forecast ($frcstTable)
{
 global $lang_idx, $DRIZZLE, $PARTLY, $CLOUDY, $PARTLY_CLOUDY, $MOSTLY, $CLEAR, $HAZE, $LOCAL_RAIN, $LIGHT_RAIN, $RAIN, $VERY_HOT_HEAT_WAVE, $PROB, $AFTERNOON, $NIGHT, $DAY, $AND, $THE, $DURING, $CLOUDY, $WINDY, $AT_TIMES, $MORNING, $SNOW, $LIGHT_SNOW, $OR, $SLEET, $CHANCE_FOR, $GENERALLY, $STRONG_WINDS, $OCCASIONAL, $HAZE, $THUNDERSTORM, $VERY_DRY, $WARMER_THAN_AVERAGE, $TO, $CHANCE_OF, $HEAVY_RAIN, $FOG, $LATER, $AT_FIRST, $STORMY, $BECMG, $FROM, $EVENING, $VERY, $WARM_WIND, $DUST, $ISOLATED;
 $frcstTable = str_replace ( "width=\"45\" height=\"45\"", "", $frcstTable);
 //$frcstTable = str_replace ( "\"35\"", "\"25\"", $frcstTable);
 $frcstTable = str_replace ( "height=\"0\">", "/>", $frcstTable);
 $frcstTable = str_replace ( "width=\"70\"", "", $frcstTable);
 $frcstTable = str_replace ( "width=\"255\"", "", $frcstTable);
 $frcstTable = str_replace ( "<br>", "", $frcstTable);
 $frcstTable = str_replace ( "<b>", "", $frcstTable);
 $frcstTable = str_replace ( "</b>", "", $frcstTable);
 $frcstTable = str_replace ( "font", "span", $frcstTable);
 $frcstTable = str_replace ( "<td", "<td class=\"inv_plain_3_zebra\" style=\"padding:0 0.5em\" ", $frcstTable);
 $frcstTable = str_replace ( "height=\"25\">", "height=\"25\"/>", $frcstTable);
 $frcstTable = str_replace ( "(", "" , $frcstTable);
 $frcstTable = str_replace ( ")", "", $frcstTable);
 $frcstTable = str_replace ( "\"3\"", "\"0\"", $frcstTable);
 $frcstTable = str_replace ( "align=\"center\"", "dir=\"ltr\"", $frcstTable);
 $frcstTable = str_replace ( "align=\"left\"", "align=\"center\"", $frcstTable);
 $frcstTable = str_replace ( "#0000ff", "\"#0066CC\"", $frcstTable);
 $frcstTable = str_replace ( "#ff3300", "\"#FF0000\"", $frcstTable);
 $frcstTable = str_replace ( "color=\"#0066CC\"", "style=\"color:#0066CC;\"", $frcstTable);
 $frcstTable = str_replace ( "color=\"#FF0000\"", "style=\"color:#FF0000;\"", $frcstTable);
 $frcstTable = str_replace ( " Jan", "/01&nbsp;&nbsp;", $frcstTable);
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
 $frcstTable = replaceDays($frcstTable);
 //$frcstTable = strtolower($frcstTable);
 $frcstTable = str_replace ( "ISOLATED", $ISOLATED[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "SUNNY", $CLEAR[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "WARMER THAN USUAL", $WARMER_THAN_AVERAGE[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "DRIZZLE", $DRIZZLE[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "PARTLY CLOUDY", $PARTLY_CLOUDY[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "FAIR", "$MOSTLY[$lang_idx] $CLEAR[$lang_idx]", $frcstTable);
 $frcstTable = str_replace ( "HAZE", $HAZE[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "LIGHT LOCAL RAIN", $LIGHT_RAIN[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "LOCAL RAIN", $LOCAL_RAIN[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "LOCAL SHOWERS", $LOCAL_RAIN[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "LOCAL SHOWER", $LOCAL_RAIN[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "LIGHT RAIN SHOWER", $LIGHT_RAIN[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "LIGHT RAIN", $LIGHT_RAIN[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "LIGHT SHOWER", $LIGHT_RAIN[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "SHOWERS", $RAIN[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "SHOWER", $RAIN[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "RAINY", $RAIN[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "DUSTY", $DUST[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "RAIN", $RAIN[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "FOG", $FOG[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "LIGHT SNOW", $LIGHT_SNOW[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "THUNDERSTORMS", $THUNDERSTORM[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "THUNDER", " ".$THUNDERSTORM[$lang_idx]." ", $frcstTable);
 $frcstTable = str_replace ( "STORM", " ", $frcstTable);
 $frcstTable = str_replace ( "SNOW", $SNOW[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "SLEET", $SLEET[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "CLEAR", $CLEAR[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "STRONG WINDS", $STRONG_WINDS[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "HOT AND DRY", $VERY_HOT_HEAT_WAVE[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "HEAT WAVE", $VERY_HOT_HEAT_WAVE[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "HAZY", $HAZE[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "POSSIBILITY OF", $PROB[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "POSSIBLE", $PROB[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "AFTERNOON", $AFTERNOON[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "MORNING", $MORNING[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "FROM EVENING", $FROM[$lang_idx]." ".$EVENING[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "NIGHT", $NIGHT[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "DAY", $DAY[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "AND", $AND[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "THE", "", $frcstTable);
 $frcstTable = str_replace ( "WARM", "", $frcstTable);
 $frcstTable = str_replace ( "DURING", $DURING[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "CLOUDY", $CLOUDY[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "WINDY", $WINDY[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "DRY", $VERY_DRY[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "CHANCE FOR", $CHANCE_FOR[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "AT TIMES", $AT_TIMES[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "OCCASIONAL", $OCCASIONAL[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "GENERALLY", $GENERALLY[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( " OR ", " ".$OR[$lang_idx]." ", $frcstTable);
 $frcstTable = str_replace ( "LOCAL", "", $frcstTable);
 $frcstTable = str_replace ( "WITH", "", $frcstTable);
 $frcstTable = str_replace ( " TO ", " ".$TO[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "A POSSIBILITY OF", $CHANCE_OF[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "CHANCE OF", $CHANCE_OF[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "PERIOD", $OCCASIONAL[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "INTERVALS", $OCCASIONAL[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "INTERVAL", $OCCASIONAL[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "HEAVY RAIN", $HEAVY_RAIN[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "OVERCAST", $CLOUDY[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "MOSTLY", $GENERALLY[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "SPELLS", $FOG[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "FEW", " ", $frcstTable);
 $frcstTable = str_replace ( " IN ", " ", $frcstTable);
 $frcstTable = str_replace ( "MAINLY", $GENERALLY[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "LATER", $LATER[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "AT FIRST", $AT_FIRST[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "SCATTERED", " ", $frcstTable);
 $frcstTable = str_replace ( "FINE", $CLEAR[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "FLURRIES", $SNOW[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "BECOMING", $BECMG[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "FREQUENT", $OCCASIONAL[$lang_idx], $frcstTable);
 $frcstTable = str_replace ( "VERY", "" , $frcstTable);
 if (isHeb())
	$frcstTable = str_replace ( "DESERT WIND", $WARM_WIND[$lang_idx] , $frcstTable);
 
 return $frcstTable;
}
	header('Content-type: text/html; charset=utf-8');
	$location = isset($_REQUEST['location']) ? $_REQUEST['location'] : "";
	$forecast_full_page = get_file_string($location);
	//echo $forecast_full_page;
	$start = strpos($forecast_full_page, "Weather Information for");
	$placepos = $start + 47;
	//$end = strpos($forecast_full_page, "&gt;&gt;");
	//$frcstTable = substr ( $forecast_full_page, $start, $end - $start);
	//$frcstTable = str_replace ( "img src=\"", "img src=\"".$location."/../", $frcstTable);
	$start = strpos($forecast_full_page, "<td width=\"70\" align=\"center\">");
	 if ($start <= 0)
		$start = strpos($forecast_full_page, "Issued at");
	 $end = strpos($forecast_full_page, "<!--F");
	 // start: <td width=\"70\" align=\"center\"> end: </td>
	 if ($start > 0)
	 {
		 $frcstTable = substr ( $forecast_full_page, $start, $end - $start - 40);
		 $frcstTable = "<tr>".$frcstTable."</tr>";
		 $frcstTable = fix_forecast($frcstTable);
	 }
	 else
	 {
		$frcstTable = "";
	 }
	 $place = substr ( $forecast_full_page, $placepos, 25);
	 $endtagplace = strpos($place, "</");
	 if ($endtagplace > 0)
		$place = substr ( $forecast_full_page, $placepos, $endtagplace);
	 $climate_start = strpos($forecast_full_page, "Climatological Information") + 195;
	 $climate_data = substr ( $forecast_full_page, $climate_start);
	 $climate_end =  strpos($climate_data, "</table>");
	 $climate_data = substr ( $climate_data, 0, $climate_end + 8); // 8 = </table> 
	echo "<div id=\"wrapperforecast\">".$place."<table cellspacing=\"15\"><tr><td class=\"td\">\n<!-- td start -->\n".$frcstTable."\n<!-- td end -->\n</td></tr></table></div>";
	$climate_data = str_replace ( date("M"), "<span class=\"inv slogan\">".getMonthName(date("n"))."</span>", $climate_data);
	if (isHeb())
	{
		$climate_data = str_replace ( "Month", "חודש", $climate_data);
		$climate_data = str_replace ( "Mean Number of", "מספר ימים ממוצע", $climate_data);
		$climate_data = str_replace ( "Mean Total", "כמות ממוצעת" , $climate_data);
		$climate_data = str_replace ( "Precipitation", "של גשם" , $climate_data);
		$climate_data = str_replace ( "Rainfall", "של גשם" , $climate_data);
		$climate_data = str_replace ( "Rain", "של גשם" , $climate_data);
		$climate_data = str_replace ( "Days", "" , $climate_data);
		$climate_data = str_replace ( "Daily<br>Minimum", "מינימום" , $climate_data);
		$climate_data = str_replace ( "Daily<br>Maximum", "מקסימום" , $climate_data);
		$climate_data = str_replace ( "Mean Temperature", $TEMP[$lang_idx]." ממוצעת" , $climate_data);
	}
 ?>
<?
	echo "\n<div id=\"wrapperclimate\" class=\"inv_plain_3_zebra\">".$climate_data."</div>";
	

?>