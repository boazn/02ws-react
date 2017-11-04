<?
ini_set("display_errors","On");
ini_set("include_path", ".;../");
$prefix = "../";
include_once("../include.php"); 
include_once("../start.php");
include_once("../requiredDBTasks.php");
list($fday, $fmonth, $fyear) = explode('/', $_REQUEST['date']);
list($firstdayinforecast, $firstdayinforecast_month) = explode('/', $fday_l);
$yest_date = mktime (0, 0, 0, $fmonth, $fday-1 , $fyear);
$todayForecast_date = date ("Y-m-d", mktime (0, 0, 0, $fmonth, $fday , $fyear));
$tommorrowForecast_date = date ("Y-m-d", mktime (0, 0, 0, $fmonth, $fday+1 , $fyear));
$tommorrowForecast_day = date ("d", mktime (0, 0, 0, $fmonth, $fday+1 , $fyear));
$atommorrowForecast_date = date ("Y-m-d", mktime (0, 0, 0, $fmonth, $fday+2 , $fyear));

function fillForecastTime (&$pastTime, $found){
                global $tok, $current;
                
				if ($_GET['debug']  >= 2) {
					echo "<br>**** fillingPastTime ".$pastTime->get_time()." ****<br>";
				}
                if ($found) {
                    $timeFound = $tok;
                    $pastTime->set_temp(getNextWord($tok, 1));
                      $pastTime->set_hum(getNextWord($tok, 3));
		      $pastTime->set_dew(getNextWord($tok, 1));
                      $pastTime->set_windspd(getNextWord($tok, 1));
                      $pastTime->set_winddir(getNextWord($tok, 1));
                      $pastTime->set_pressure(getNextWord($tok, 7));
					  $pastTime->set_cloudbase((($pastTime->get_temp()-$pastTime->get_dew()) * 125) + ELEVATION);
					  $pastTime->set_rainrate(getNextWord($tok, 2));
                 
                }
                else{
                    $pastTime->set_temp(null);
                    $pastTime->set_hum(null);
                    $pastTime->set_windspd(null);
                    $pastTime->set_winddir(null);
                    $pastTime->set_pressure(null);
					$pastTime->set_rainrate(null);
                    $pastTime->set_change(null, null, null, null, null, null);
                }
                return $timeFound;
 }
 function build850Data()
 {
     
 }
 function calcForecastTemp($yestTemp, $time_at_day)
 {
         global $todayForecast, $passedMidnight, $tomorrowForecast, $fday, $fday_l, $todayForecast_date, $tommorrowForecast_day, $today, $current, $firstdayinforecast;
        $currentDay = new ForecastDay();
        $currentDay->set_temp_day($today->get_hightemp(), null);
        $currentDay->set_temp_night(round($current->get_temp()), null);
        $currentDay->set_temp_morning($today->get_lowtemp(), null);
         if ($fday != $firstdayinforecast)            //24h starts in yesterday
		$forcastday = ($passedMidnight? $todayForecast : $currentDay);
        else if ($fday == $firstdayinforecast) //24h starts in todayForecast
		$forcastday = ($passedMidnight? $tomorrowForecast : $todayForecast);
       
	$MAX_TIME = 14;
        $MULTIPLE_FACTOR = 0.9; //how quickly temp rise 0.9 - 1.2
        if (GMT_TZ == 3) {$MAX_TIME = 15;$MULTIPLE_FACTOR = 1.1;}
	//if ($passedMidnight && ($fday_l == $tommorrowForecast_day))
	//		$forcastday = $todayForecast;
       
        if ($_GET['debug'] >= 1){
                echo "<br>";
                echo "<br>time_at_day= ",$time_at_day;
                echo "<br>current temp=".$current->get_temp();
                echo "<br>today high temp=".$today->get_hightemp();
                echo "<br>today low temp=".$today->get_lowtemp();
                echo "<br>tommorrowForecast_day=".$tommorrowForecast_day;
                echo "<br>firstdayinforecast=".$firstdayinforecast;
                echo "<br>fday=".$fday;
                echo "<br>passedMidnight=".$passedMidnight;
                echo "<br>get_temp_morning= ",$forcastday->get_temp_morning();
                echo "<br>get_temp_day= ",$forcastday->get_temp_day();
		echo "<br>get_temp_night= ",$forcastday->get_temp_night();

        }
           
        
       if ($time_at_day <= 3)
                $tempHour = $forcastday->get_temp_morning() + 1;

        elseif ($time_at_day > 3 && $time_at_day < 7)
                $tempHour = $forcastday->get_temp_morning();

        elseif ($time_at_day >= 7 && $time_at_day <= $MAX_TIME - 2){
                        $diff = $forcastday->get_temp_day() - $forcastday->get_temp_morning();
                        $tempHour = round($forcastday->get_temp_morning() + (($time_at_day - ($MAX_TIME - 1 - 7))/($MAX_TIME - 1 - 7))*$diff*$MULTIPLE_FACTOR);
        }
        elseif ($time_at_day >= ($MAX_TIME - 1) && $time_at_day <= $MAX_TIME)
                $tempHour = $forcastday->get_temp_day();

        elseif ($time_at_day > $MAX_TIME && $time_at_day <= 21){
                        $diff = $forcastday->get_temp_day() - $forcastday->get_temp_night();
                        $tempHour = round($forcastday->get_temp_day() - (($time_at_day - $MAX_TIME)/(20 - $MAX_TIME + 1))*$diff);
        }
       elseif ($time_at_day >= 22 && $time_at_day <= 23)
                $tempHour = $forcastday->get_temp_night() - 1;
      return $tempHour;
 }
 function getCloth($temp)
 {
     return "";
     global $link;
    $temp_from = $temp - 0.5;
    $temp_to = $temp + 0.5;
    $pgender = "";
    logger ("calling GetColdMeter in getAllTempFOrecast");
     $query_verdict = "call GetColdMeter({$temp_from}, {$temp_to}, '{$pgender}');";
    db_init("", "");
    $result = mysqli_query($link, $query_verdict) ;
    $row_verdict = mysqli_fetch_array($result["result"], MYSQLI_ASSOC);
    $current_feeling = get_name($row_verdict["field_name"]);
    logger($current_feeling);
     $cloth_name = getClothName($current_feeling);
     $arCloth_name =  explode('_', $cloth_name);
    $prefCloth_name = $arCloth_name[0];
     return $cloth_name;
 }
 function buildJSONForecastAllTime($timeoff)
 {
     global $forecastTime, $tok, $yest_date, $forecastResult, $todayForecast, $todayForecast_date, $tommorrowForecast_date, $passedMidnight, $current;
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
		$tempHour = calcForecastTemp($forecastTime->get_temp(), $timeoff); 
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