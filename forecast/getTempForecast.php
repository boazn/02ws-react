<?
function fillForecastTime (&$pastTime, $found){
                global $tok, $current;
				if ($_GET['debug']  >= 2) {
					echo "<br>**** fillingPastTime ".$pastTime->get_time()." ****<br>";
				}
                if ($found) {
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
                    $pastTime->set_change(null, null, null, null, null, null, null, null);
                }
 }
ini_set("display_errors","On");
ini_set("include_path", ".;../");
$prefix = "../";
include("../include.php");
include("../start.php");
include_once("../requiredDBTasks.php");
list($fday, $fmonth, $fyear) = split('[/.-]', $_REQUEST['date']);
$yest_date = date (DATE_FORMAT, mktime (0, 0, 0, $fmonth, $fday , $fyear));
$todayForecast_date = date (DATE_FORMAT, mktime (0, 0, 0, $fmonth, $fday+1 , $fyear));
//echo $todayForecast_date;

$file_path = ".".FILE_ARCHIVE;
//echo $file_path;
$tok = getTokFromFile($file_path);
$forecastTime = new FixedTime();
if ($_GET['debug'] >= 1)
echo "<br>searching ", $yest_date," and ",$_REQUEST['time']," ";
if (searchNext ($tok, $yest_date))// found the date in the file
	fillForecastTime ($forecastTime, searchNext ($tok, $_REQUEST['time']));
if ($forecastTime->get_temp() == null)
	print "not found";


else
{
	$tempHour = round($forecastTime->get_temp() + $_REQUEST['tempDiff']);
	if ($_GET['debug'] >= 1){
		echo "<br>forecastTimeTemp= ",$forecastTime->get_temp();
		echo "<br>tempHour= ",$tempHour;
		echo "<br>get_lowtemp= ",$todayForecast->get_lowtemp();
		echo "<br>get_hightemp= ",$todayForecast->get_hightemp(),"<br>";
		
	}
	if ($todayForecast->get_lowtemp() != "")
	{
		if ($tempHour < $todayForecast->get_lowtemp())
			$tempHour = $todayForecast->get_lowtemp();
		if ($tempHour > $todayForecast->get_hightemp())
			$tempHour = $todayForecast->get_hightemp();
	}
	print $tempHour.$forecastTime->get_tempunit();
}
?>