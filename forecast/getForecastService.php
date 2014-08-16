<?
	$prefix = "../";
	include_once("../include.php");
	include_once("../start.php");
	
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