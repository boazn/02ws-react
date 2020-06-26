<?
ini_set("display_errors","On");
ini_set("include_path", ".;../");
$prefix = "../";
include_once("../include.php"); 
include_once("../start.php");
include_once("../requiredDBTasks.php");
include_once("../forecastlib.php");
list($fday, $fmonth, $fyear) = explode('/', $_REQUEST['date']);
list($firstdayinforecast, $firstdayinforecast_month) = explode('/', $firstdayinforecast_l);
$yest_date = mktime (0, 0, 0, $fmonth, $fday-1 , $fyear);
$todayForecast_date = date ("Y-m-d", mktime (0, 0, 0, $fmonth, $fday , $fyear));
$tommorrowForecast_date = date ("Y-m-d", mktime (0, 0, 0, $fmonth, $fday+1 , $fyear));
$tommorrowForecast_day = date ("d", mktime (0, 0, 0, $fmonth, $fday+1 , $fyear));
$atommorrowForecast_date = date ("Y-m-d", mktime (0, 0, 0, $fmonth, $fday+2 , $fyear));
$prev_temp = $current->get_temp();

 function buildJSONForecastAllTime($timeoff)
 {
     global $monthF, $dayC , $yearF, $forecastTime, $tok, $yest_date, $forecastResult, $todayForecast, $todayForecast_date, $tommorrowForecast_date, $passedMidnight, $current, $prev_temp;
     $timeForJSON = sprintf("%d:00", intval($timeoff));
     
     if (intval($timeoff) == 0)
     {
         $timeForJSON = "00:00";
      }
	  if ($passedMidnight)
		  $dateToWorkOn = new DateTime($tommorrowForecast_date." ".$timeForJSON);
	  else
		  $dateToWorkOn = new DateTime($todayForecast_date." ".$timeForJSON);

		$ts = $dateToWorkOn->getTimestamp();
		$currentDateTime =  mktime ($timeoff, 0, 0, $monthF, $dayC , $yearF);
                $tempHour = calcForecastTemp($timeoff, $currentDateTime, $prev_temp); 
                $prev_temp = $tempHour;
                $clothHour = getCloth($tempHour);
		if ($forecastResult != "")
			$forecastResult .= ",";
		$forecastResult .= "{";
		if ($_GET['debug'] >= 1){
			$forecastResult .= "\"time\":"."\"".$timeForJSON."\"";
			$forecastResult .= ",";
			$forecastResult .= "\"date\":"."\"".date(DATE_FORMAT, $ts)."\"";
			$forecastResult .= ",";
		}
		$forecastResult .= "\"ts\":"."\"".$ts."\"";
		$forecastResult .= ",";
                $forecastResult .= "\"cloth\":"."\"".$clothHour."\"";
		$forecastResult .= ",";
		$forecastResult .= "\"temp\":"."\"".$tempHour."\"";
		$forecastResult .= "}";
   
 }


$file_path = ".".FILE_ARCHIVE;
//echo $file_path;
$tok = getTokFromFile($file_path);
$forecastTime = new FixedTime();
$forecastResult = "";
$timearr = array();
for ($i=$_REQUEST['time'] + 1; $i < $_REQUEST['time']+36 ; $i++)
{
    if ($i>24)
            $h = $i % 24;
    else
            $h = $i;
    if ($i==24)
            $time = "0:";
    else 
            $time = sprintf("%d:", $h);

    array_push($timearr, $time);
    
}
$forecastResult = "";
$passedMidnight = false;
foreach ($timearr as $specifictime) {
	if (intval($specifictime) == 0) 
	{
		$passedMidnight = true;
	}
	buildJSONForecastAllTime($specifictime);
}
$forecastJSON = "{\"forecasthours\":[";
$forecastJSON .= $forecastResult;
$forecastJSON .= "]}";
print $forecastJSON;

?>