<?
//redirectToSite(get_url());
//ini_set("display_errors","On");	
include_once("lang.php");
include_once("include.php"); 
session_start();

function retrieveTemp2()
{
    global $current, $min15, $min30;
    $path_to_file = 'temp2.csv';
    if (stristr($_SERVER['SCRIPT_NAME'], 'getAllTempForecast'))
            $path_to_file = "../".$path_to_file;
    $temp2_array = array();
    $temp2_array = array_map('str_getcsv', file($path_to_file));
    $temp2 = number_format(((intval($temp2_array[1][0])/10) -32)*(5/9), 1, '.', '');
    $dewpoint2 = number_format(((intval($temp2_array[1][3])/10) -32)*(5/9), 1, '.', '');
    $heatindex2 = number_format(((intval($temp2_array[1][4])/10) -32)*(5/9), 1, '.', '');
    $thsw = number_format(((intval($temp2_array[1][25])/10) -32)*(5/9), 1, '.', '');
    if ($_GET['debug'] >= 4){
        echo $path_to_file." ";
        print_r($temp2_array);
    }
    if (empty($temp2)||($temp2_array[1][0] == 0))
    {
       $temp2 = $current->get_temp2();
       $dewpoint2 = $current->get_dew();
       $heatindex2 = $current->get_heatidx();
       // no current thsw value, so copy from min15
        if (empty($min15->get_thsw()))
            $thsw = $min30->get_thsw();
        else {
            $thsw = $min15->get_thsw();
        }
       
    }
    return array("temp2" =>$temp2, "dewpoint2" =>$dewpoint2, "heatindex2" =>$heatindex2, "thsw" => $thsw);
    //var_dump ($temp2_array);
}
$template_routing = @$_GET['section'];    
$profile = @$_GET['profile'];
$hoursForecast = @$_GET['hours'];
$limitLines = 8;
//
// url reset
//
$url_cur = get_url();
//$url_cur = get_query_edited_url($url_cur, 'hours', '');
//$url_cur = get_query_edited_url($url_cur, 'level', '');
//$url_cur = get_query_edited_url($url_cur, 'profile', '');
$url_cur = get_query_edited_url($url_cur, 'graph', '');
//echo $url_cur;
//
$error_update = false;
$boolbroken = false;
$messageBroken = array();
$error_desc = "...There was an error in update, Please try again later...<br/>...חלה טעות בעדכון, נסו שנית יותר מאוחר...";    
if ($profile == '')         
	$profile = 1;	
if ($template_routing == "extended")
	$profile = 2;
//if ($template_routing == '')    
//     $error = include "getUserDetailes.php";    
//******* debug ****************
//print_r ($GLOBALS);    
//var_dump ($GLOBALS); 
//******* debug ****************
//////////////////////////////////////////////
// ini objects
////////////////////////////////////////////// 
$current = new FixedTime();    
$yestsametime = new FixedTime();    
//$sixHours = new FixedTime();    
$threeHours = new FixedTime();    
$oneHour = new FixedTime();
$min10 = new FixedTime();    
$min15 = new FixedTime();    
$min30 = new FixedTime();
$now = new FixedTime();
$thisMonth = new TimeRange();   
$prevMonth = new TimeRange();    
$thisYear = new TimeRange();    
$today = new ForecastDay();
$todayForecast = new ForecastDay();
$tomorrowForecast = new ForecastDay();
$yest = new ForecastDay();    
$wholeSeason = new TimeRange();    
$wholeSeason->set_rain(RAIN_TOTAL);    
$wholeSeason->set_rainydays(RAINYDAYS_TOTAL);    
$seasonTillNow = new TimeRange();
$averageTillNow = new TimeRange();  
$storm =  new TimeRange();

//////////////////////////////////////////////
// parsing XML data
//////////////////////////////////////////////
// Array to store current xml path    
$ary_path = array();    
// Array to store parsed data    
$ary_parsed_file = array();    
// Starting level - Set to 0 to display all levels. Set to 1 or higher    
// to skip a level that is common to all the fields.    
$int_starting_level = 2;
if (stristr($_SERVER['SCRIPT_NAME'], 'getAllTempForecast'))
    $fulldatatotake = "../".$fulldatatotake;
$ary_parsed_file = getXMLInArray($fulldatatotake);
if ($_GET['debug'] >= 4){
    print_r($ary_parsed_file);
}
//////////////////////////////////////////////
// filling with XML data
//////////////////////////////////////////////
$current->set_date($ary_parsed_file['STATIONDATE']);    
$current->set_time($ary_parsed_file['STATIONTIME']);      
$current->set_temp($ary_parsed_file['OUTSIDETEMP']);
$today->set_hightemp($ary_parsed_file['HIOUTSIDETEMP'],$ary_parsed_file['HIOUTSIDETEMPTIME']);    
$today->set_lowtemp($ary_parsed_file['LOWOUTSIDETEMP'],$ary_parsed_file['LOWOUTSIDETEMPTIME']);
$thisMonth->set_hightemp($ary_parsed_file['HIMONTHLYOUTSIDETEMP'],"");    
$thisMonth->set_lowtemp($ary_parsed_file['LOWMONTHLYOUTSIDETEMP'],"");
$thisMonth->set_hightemp2($ary_parsed_file['HIMONTHLYOUTSIDETEMP'],"");    
$thisMonth->set_lowtemp2($ary_parsed_file['LOWMONTHLYOUTSIDETEMP'],"");    
$thisYear->set_hightemp($ary_parsed_file['HIYEARLYOUTSIDETEMP'],"");    
$thisYear->set_lowtemp($ary_parsed_file['LOWYEARLYOUTSIDETEMP'],"");
$thisYear->set_hightemp2($ary_parsed_file['HIYEARLYOUTSIDETEMP'],"");    
$thisYear->set_lowtemp2($ary_parsed_file['LOWYEARLYOUTSIDETEMP'],""); 
$current->set_hum($ary_parsed_file['OUTSIDEHUMIDITY']);    
$today->set_highhum($ary_parsed_file['HIHUMIDITY'],$ary_parsed_file['HIHUMTIME']);    
$today->set_lowhum($ary_parsed_file['LOWHUMIDITY'],$ary_parsed_file['LOWHUMTIME']);    
$thisMonth->set_highhum($ary_parsed_file['HIMONTHLYHUMIDITY'],"");    
$thisMonth->set_lowhum($ary_parsed_file['LOWMONTHLYHUMIDITY'],"");    
$thisYear->set_highhum($ary_parsed_file['HIYEARLYHUMIDITY'],"");    
$thisYear->set_lowhum($ary_parsed_file['LOWYEARLYHUMIDITY'],"");    
$current->set_pressure($ary_parsed_file['BAROMETER']);    
$today->set_highbar($ary_parsed_file['HIBAROMETER'],$ary_parsed_file['HIBAROMETERTIME']);    
$today->set_lowbar($ary_parsed_file['LOWBAROMETER'],$ary_parsed_file['LOWBAROMETERTIME']);    
$thisMonth->set_highbar($ary_parsed_file['HIMONTHLYBAROMETER'],"");    
$thisMonth->set_lowbar($ary_parsed_file['LOWMONTHLYBAROMETER'],"");    
$thisYear->set_highbar($ary_parsed_file['HIYEARLYBAROMETER'],"");    
$thisYear->set_lowbar($ary_parsed_file['LOWYEARLYBAROMETER'],"");
$thisMonth->set_highdew($ary_parsed_file['HIMONTHLYDEWPOINT'],"");    
$thisMonth->set_lowdew($ary_parsed_file['LOWMONTHLYDEWPOINT'],"");    
$thisYear->set_highdew($ary_parsed_file['HIYEARLYDEWPOINT'],"");    
$thisYear->set_lowdew($ary_parsed_file['LOWYEARLYDEWPOINT'],"");
$current->set_winddir($ary_parsed_file['WINDDIRECTION']);
$current->set_windspd($ary_parsed_file['WINDSPEED']);
$min10->set_windspd($ary_parsed_file['WIND10AVG']); 
$today->set_highwind($ary_parsed_file['HIWINDSPEED'],$ary_parsed_file['HIWINDSPEEDTIME']);    
$thisMonth->set_highwind($ary_parsed_file['HIMONTHLYWINDSPEED'],"");    
$thisYear->set_highwind($ary_parsed_file['HIYEARLYWINDSPEED'],"");    
$today->set_rain($ary_parsed_file['DAILYRAIN']);    
$thisMonth->set_rain($ary_parsed_file['MONTHLYRAIN']);    
$seasonTillNow->set_rain($ary_parsed_file['TOTALRAIN']);    
$storm->set_rain($ary_parsed_file['STORMRAIN']);    
$current->set_rainrate($ary_parsed_file['RAINRATE']);    
$today->set_highrainrate($ary_parsed_file['HIRAINRATE'],$ary_parsed_file['HIRAINRATETIME']);    
$thisMonth->set_highrainrate($ary_parsed_file['HIMONTHLYRAINRATE'],"");    
$thisYear->set_highrainrate($ary_parsed_file['HIYEARLYRAINRATE'],"");    
$current->set_dew($ary_parsed_file['OUTSIDEDEWPT']);    
$rainrateHour=($ary_parsed_file['HIRAINRATEHOUR']);	
$current->set_cloudbase((($current->get_temp()-$current->get_dew())* 125) + ELEVATION);
$current->set_windchill($ary_parsed_file['WINDCHILL']);
$current->set_heatidx($ary_parsed_file['OUTSIDEHEATINDEX']);
$current->set_thw($ary_parsed_file['THW']);
$current->set_thsw($ary_parsed_file['THSW']);
$today->set_highheatindex($ary_parsed_file['HIHEATINDEX'],$ary_parsed_file['HIHEATINDEXTIME']);
$thisMonth->set_highheatindex($ary_parsed_file['HIMONTHLYHEATINDEX'],"");
$thisMonth->set_highheatindex($ary_parsed_file['HIYEARLYHEATINDEX'],"");
$today->set_lowwindchill($ary_parsed_file['LOWWINDCHILL'],$ary_parsed_file['LOWWINDCHILLTIME']);
$thisMonth->set_lowwindchill($ary_parsed_file['LOWMONTHLYWINDCHILL'],"");
$thisYear->set_lowwindchill($ary_parsed_file['LOWYEARLYWINDCHILL'],"");
$current->set_intemp($ary_parsed_file['INSIDETEMP']);
$windUnits = $ary_parsed_file['WINDUNIT'];
$sunset = $ary_parsed_file['SUNSETTIME'];
$sunrise = $ary_parsed_file['SUNRISETIME'];
$today->set_sunshinehours($ary_parsed_file['SUNSHINEHOURS']);
$today->set_et($ary_parsed_file['DAILYET']);
$current->set_solarradiation($ary_parsed_file['SOLARRAD']);
$current->set_uv($ary_parsed_file['UV']);
$today->set_highuv($ary_parsed_file['HIUV'],$ary_parsed_file['HIUVTIME']);
$thisMonth->set_highuv($ary_parsed_file['HIMONTHLYUV'],"");
$thisYear->set_highuv($ary_parsed_file['HIYEARLYUV'],"");
$today->set_highradiation($ary_parsed_file['HISOLARRAD'],$ary_parsed_file['HISOLARRADTIME']);
$thisMonth->set_highradiation($ary_parsed_file['HIMONTHLYSOLARRAD'],"");
$thisYear->set_highradiation($ary_parsed_file['HIYEARLYSOLARRAD'],"");
$current->set_tempunit('&#176;c');

//second xml file to read secpndary highs and lows
$ary_parsed_file = getXMLInArray(FILE_XML_FULLDATA2);
$today->set_hightemp2($ary_parsed_file['HIOUTSIDETEMP2'],$ary_parsed_file['HIOUTSIDETEMP2TIME']);
$today->set_lowtemp2($ary_parsed_file['LOWOUTSIDETEMP2'],$ary_parsed_file['LOWOUTSIDETEMP2TIME']);

////////// filling pm10 //////////
$array_pm = array_map('str_getcsv', file("getAveragePM10.txt"));
$current->set_pm10($array_pm[0][0]);
$current->set_pm10sd(round($array_pm[0][1]));
$current->set_pm25($array_pm[0][2]);
$current->set_pm25sd(round($array_pm[0][3]));
//////////////////////////////////////////////
// filling time vars
//////////////////////////////////////////////
if (isset($_POST['tocorf'])) {
	//echo "setting cookie:".$_POST['tocorf'];
	setcookie('tempunit',$_POST['tocorf']);
}
if ($lang_idx == $HEB)
{
	/* Set locale to Hebrew */
	setlocale(LC_ALL, "he_IL");
}
else
if ($lang_idx == $EN)
{
	
		if ($_GET['tempunit'] == 'F')
		{
			$current->set_tempunit('&#176;F');
		}
	
}

$day = (int)strtok($current->get_date(), "/");    
$month = (int)strtok("/");    
$year = (int)strtok("/");    
$hour = (int)strtok($current->get_time(), ":");    
if ((get_sunrise_ut() > $current->get_current_time_ut())||(get_sunset_ut() < $current->get_current_time_ut()-1800))           
$current->set_dark();	
$min = (int)strtok(":");    
$yhour = $hour;// maybe in the future it will be diffrent    
$offset = $min % INTERVAL;// maybe the update time is not like the times written in file        
$ymin = ($offset === 0 ? $min : $min - $offset);	
$yestsametime->set_time (getMinusHourTime(24));        
$yestsametime->set_date (getMinusHourDate(24));
$updatedStationDate = mktime ($hour, $min, 0, $month, $day ,$year);// Unix timestamp
$date = date("D  G:i  ".DATE_FORMAT, $updatedStationDate);
$dateInHeb = replaceDays($date);
$datenotime = date(DATE_FORMAT , $updatedStationDate);        
$year = date("Y",  $updatedStationDate);
	$monthInWord = getMonthName(date("n",  $updatedStationDate));    
$decade = ($day < 11 ? 1 : ($day < 21 ? 2 : 3));        
$current_season = ($month > 8 ? sprintf("%04d-%04d", $year, $year + 1) : sprintf("%04d-%04d", $year - 1, $year));  
$prevMonthInWord = getMonthName(date("n",  mktime ($hour, $min, 0, getPrevMonth($month), 1 ,getPrevMonthYear($month, $year))));
$now->set_time(getMinusMinTime(0));    
$now->set_date(getMinusMinDate(0));  
$min15->set_time(getMinusMinTime(INTERVAL));    
$min15->set_date(getMinusMinDate(INTERVAL));        
$min30->set_time(getMinusMinTime(30));    
$min30->set_date(getMinusMinDate(30));        
$oneHour->set_time(getMinusMinTime(60));    
$oneHour->set_date(getMinusMinDate(60));
$threeHours->set_time(getMinusMinTime(180));    
$threeHours->set_date(getMinusMinDate(180)); 
if ($current->get_rainrate() === "0.0")
	$current->set_rainrate("0");
$last2 = retrieveTemp2();
$temp2 = $last2['temp2'];
$current->set_temp2($temp2);
$current->set_thsw($last2['thsw']);
if ($_GET['debug'] >= 4){
print("<br><br> current: ");
print_r($current);
print("<br><br> today:");
print_r($today);    
print("<br><br> yest:");    
print_r($yest);    
print("<br><br>");    
print_r($thisMonth);    
print("<br><br>");    
print_r($thisYear);    
}
 /******************************************************************************/
/* 

if (!isset($_SESSION['startTime']))
$_SESSION['startTime'] = time(); 
$minutesSession =  round((time() - $_SESSION['startTime']) / 60);
//echo "session minutes time = ". $minutesSession;
//assuming yesterday has the same interval

if ($minutesSession > 10){
@session_unset();
@session_destroy();
}
*/
//yestsametime
 // searching for data in the archive file
$tok = getTokFromFile($prefix.FILE_ARCHIVE);
if ($_GET['debug'] >= 1)
    echo "<br>parsing ".$prefix.FILE_ARCHIVE;
if ($_GET['debug'] >= 1)
echo "<br>searching ",$yestsametime->get_date()," and ",$yestsametime->get_time()," ";
if (searchNext ($tok, $yestsametime->get_date()))// found the date in the file
	fillPastTime ($yestsametime, searchNext ($tok, $yestsametime->get_time()));
else if ($_GET['debug'] >= 1)
    echo "<strong>NOT FOUND</strong>";
//threeHours
if ($_GET['debug'] >= 1)
	echo "<br>searching ",$threeHours->get_date()," and ",$threeHours->get_time()," ";
if (searchNext ($tok, $threeHours->get_date()))// found the date in the file
	fillPastTime ($threeHours, searchNext ($tok, $threeHours->get_time()));
else if ($_GET['debug'] >= 1)
    echo "<strong>NOT FOUND</strong>";
//oneHour
if ($_GET['debug'] >= 1)
	echo "<br>searching ",$oneHour->get_date()," and ",$oneHour->get_time()," ";
if (searchNext ($tok, $oneHour->get_date()))// found the date in the file
	fillPastTime ($oneHour, searchNext ($tok, $oneHour->get_time()));
else if ($_GET['debug'] >= 1)
    echo "<strong>NOT FOUND</strong>";

// min30
if ($_GET['debug'] >= 1)
	echo "<br>searching ",$min30->get_date()," and ",$min30->get_time()," ";
if (searchNext ($tok, $min30->get_date()))// found the date in the file
	fillPastTime ($min30, searchNext ($tok, $min30->get_time()));
else if ($_GET['debug'] >= 1)
    echo "<strong>NOT FOUND</strong>";
// min15
if ($_GET['debug'] >= 1)
	echo "<br>searching ",$min15->get_date()," and ",$min15->get_time()," ";
if (searchNext ($tok, $min15->get_date()))// found the date in the file
   fillPastTime ($min15, searchNext ($tok, $min15->get_time())); 
else if ($_GET['debug'] >= 1)
    echo "<strong>NOT FOUND</strong>";
 // now
if ($_GET['debug'] >= 1)
	echo "<br>searching ",$now->get_date()," and ",$now->get_time()," ";
if (searchNext ($tok, $now->get_date()))// found the date in the file
   fillPastTime ($now, searchNext ($tok, $now->get_time()));
else if ($_GET['debug'] >= 1)
    echo "<strong>NOT FOUND</strong>";
if (empty($last2['thsw']))
$last2['thsw'] = $min15->get_thsw();

if (empty($temp2) || !is_numeric($temp2)|| $temp2 > 50){
    $temp2 = $ary_parsed_file['OUTSIDETEMP2'];
    $PRIMARY_TEMP = 1;
}

//logger("thsw:".$current->get_thsw()." ".$min15->get_thsw()." ".$min30->get_thsw()." ".$oneHour->get_thsw()." ".$threeHours->get_thsw()." ".$yestsametime->get_thsw());
/************ air quality ***********/
$airq_link="http://www.svivaaqm.net/Online.aspx?ST_ID=36;1";
$airq_path=$prefix."cache/airq.html";


/*********** forecast download *********/
$tomorrow = new TimeRange();

$for_link="http://wxweb.meteostar.com/sample/sample_C.shtml?text=LLJR/";
$for_path = $prefix."cache/latestGFS.html";

$isRemoteFile = substr($sat_link,0,7)=="http://";

 $for_link = $for_path;
  
 $forecast_full_page = get_file_string($for_path);

 ////////////////////////////////////
///// generating links  ////////////
////////////////////////////////////
if (($current->get_temp()=="")||($current->get_hum() == ""))		
	$error_update = true;
$hoursat = sprintf("%02d%02d", (($min > 45) || ($min < 15) ) ? $hour - 4 : $hour - 3, (($min > 45) || ($min < 15) ) ? 30 : 00);
$sat_link="http://www.sat24.com/images.php?country=eu&sat=ir&type=large&rnd=866974";
$animation_link = "<img src=\"http://www.sat24.com/image.ashx?country=afis&amp;type=slide&amp;index=12&amp;time=&amp;sat=ir\" style=\"position: absolute; top: 0px; left: 0px; width: 640px; height: 480px; z-index: 12; opacity: 0; display: none; \">";
$isRemoteFile = substr($sat_link,0,7)=="http://";
?>