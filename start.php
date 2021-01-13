<?php
//redirectToSite(get_url());
//ini_set("display_errors","On");	
include_once($_SERVER['DOCUMENT_ROOT']."/lang.php");
include_once($_SERVER['DOCUMENT_ROOT']."/include.php");
include_once($_SERVER['DOCUMENT_ROOT']."/ini.php");  
session_start();
define("YEST_NIGHT_TEMP", "YestNightTemp");
define("YEST_MORNING_TEMP", "YestMorningTemp");
define("YEST_NOON_TEMP", "YestNoonTemp");
define("TODAY_NIGHT_TEMP", "TodayNightTemp");
define("TODAY_MORNING_TEMP", "TodayMorningTemp");
define("TODAY_NOON_TEMP", "TodayNoonTemp");
define("SUNSHINE_HOURS", "SunshineHours");
define("LAST_7DAYS_DAILY_RAIN", "last7daysDailyRain");
define("PREV_MONTH_RAINY_DAYS", "prevMonthRainyDays");
define("THIS_MONTH_RAINY_DAYS", "thisMonthRainyDays");
if(!function_exists("get_url")) { 
function get_url() {
    if ($_SERVER["QUERY_STRING"] != "")
        return ("https://" . $_SERVER["HTTP_HOST"] . $_SERVER["PHP_SELF"] . "?" . $_SERVER["QUERY_STRING"]);
    else
        return ("https://" . $_SERVER["HTTP_HOST"] . $_SERVER["PHP_SELF"]);
}
}
function retrieveTemp2()
{
    global $current, $min15, $min30;
    $path_to_file = 'temp2.csv';
    $path_to_file_back = 'temptemp2.csv';
    if (stristr($_SERVER['SCRIPT_NAME'], 'getAllTempForecast'))
            $path_to_file = "../".$path_to_file;
    $temp2_array = array();
    try {
        $temp2_array = @array_map('str_getcsv', @file($path_to_file));
    } catch (Exception $ex) {
        $temp2_array = array_map('str_getcsv', file($path_to_file_back));
    }
    
    $temp2 = number_format(((intval($temp2_array[1][0])/10) -32)*(5/9), 1, '.', '');
    $dewpoint2 = number_format(((intval($temp2_array[1][3])/10) -32)*(5/9), 1, '.', '');
    $heatindex2 = number_format(((intval($temp2_array[1][4])/10) -32)*(5/9), 1, '.', '');
    $thsw = number_format(((intval($temp2_array[1][25])/10) -32)*(5/9), 1, '.', '');
    $datetime2_arr = explode(" ", $temp2_array[1][1]);
    $date2_arr = $datetime2_arr[0]; 
    $time2_arr = $datetime2_arr[1]; 
    list($day2, $month2, $year2) = explode('/', $date2_arr);
    list($hour2, $min2, $sec2) = explode(':', $time2_arr);
    $date2 = @mktime ($hour2, $min2, $sec2, $month2, $day2 , $year2);
    if ($_GET['debug'] >= 4){
        echo $path_to_file." ";
        print_r($temp2_array);
    }
    if (empty($temp2)||($temp2_array[1][0] == 0))
    {
       //logger("empty temp2 date2, taking current values...");
       $temp2 = $current->get_temp2();
       $date2 = time();
       $dewpoint2 = $current->get_dew();
       $heatindex2 = $current->get_heatidx();
       // no current thsw value, so copy from min15
       /* if (empty($min15->get_thsw()))
            $thsw = $min30->get_thsw();
        else {
            $thsw = $min15->get_thsw();
        }*/
       
    }
    
    return array("temp2" =>$temp2, "dewpoint2" =>$dewpoint2, "heatindex2" =>$heatindex2, "thsw"=> $thsw, "date2" => $date2);
    //var_dump ($temp2_array);
}
$template_routing = @$_GET['section'];    
$profile = @$_GET['profile'];
$hoursForecast = @$_GET['hours'];
$limitLines = LIMIT_CHAT_LINES;
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
$nextTomorrowForecast = new ForecastDay();
$yest = new ForecastDay();    
$wholeSeason = new TimeRange();    
$wholeSeason->set_rain(RAIN_TOTAL);    
$wholeSeason->set_rainydays(RAINYDAYS_TOTAL);    
$seasonTillNow = new TimeRange();
$averageTillNow = new TimeRange();  
$storm =  new TimeRange();
$tomorrow = new TimeRange();
$mem = new Memcached();
$mem->addServer('localhost', 11211);


//////////////////////////////////////////////
// parsing XML data
//////////////////////////////////////////////
// Array to store current xml path    
$ary_path = array();    
// Array to store parsed data    
$ary_parsed_file = array();
$ary_parsed_file_cum = array();
// Starting level - Set to 0 to display all levels. Set to 1 or higher    
// to skip a level that is common to all the fields.    
$int_starting_level = 2;
if (stristr($_SERVER['SCRIPT_NAME'], 'getAllTempForecast'))
    $fulldatatotake = "../".$fulldatatotake;

$ary_parsed_file = getXMLInArray($fulldatatotake);
$last2 = retrieveTemp2();
$temp2 = $last2['temp2'];

$current->set_temp2($ary_parsed_file['TEMP2']);

if ($_GET['debug'] >= 4){
    echo $fulldatatotake.": "; 
    print_r($ary_parsed_file);
}
//////////////////////////////////////////////
// filling with XML data
//////////////////////////////////////////////
$current->set_date($ary_parsed_file['DATE']);    
$current->set_time($ary_parsed_file['TIME']);      
$current->set_temp($ary_parsed_file['TEMP']);
$current->set_temp3($ary_parsed_file['TEMP3']);
$today->set_hightemp($ary_parsed_file['HITEMP'],$ary_parsed_file['HITEMPTIME']);    
$today->set_lowtemp($ary_parsed_file['LOWTEMP'],$ary_parsed_file['LOWTEMPTIME']);
$today->set_hightemp2($ary_parsed_file['HITEMP2'],$ary_parsed_file['HITEMP2TIME']);
$today->set_lowtemp2($ary_parsed_file['LOWTEMP2'],$ary_parsed_file['LOWTEMP2TIME']);
$today->set_hightemp3($ary_parsed_file['HITEMP3'],$ary_parsed_file['HITEMP3TIME']);
$today->set_lowtemp3($ary_parsed_file['LOWTEMP3'],$ary_parsed_file['LOWTEMP3TIME']);
$current->set_hum($ary_parsed_file['HUMIDITY']);
$current->set_hum2($ary_parsed_file['HUMIDITY2']);     
$today->set_highhum($ary_parsed_file['HIHUMIDITY'],$ary_parsed_file['HIHUMTIME']);    
$today->set_lowhum($ary_parsed_file['LOWHUMIDITY'],$ary_parsed_file['LOWHUMTIME']);
$today->set_highdew($ary_parsed_file['HIDEWPOINT'],$ary_parsed_file['HIDEWPOINTTIME']);    
$today->set_lowdew($ary_parsed_file['LOWDEWPOINT'],$ary_parsed_file['LOWDEWPOINTTIME']); 
$current->set_winddir($ary_parsed_file['WINDDIRECTION']);
$current->set_windspd($ary_parsed_file['WINDSPEED']);
$min10->set_windspd($ary_parsed_file['WIND10AVG']);
$current->set_windspd10min($ary_parsed_file['WIND10AVG']);
$today->set_highwind($ary_parsed_file['HIWINDSPEED'],$ary_parsed_file['HIWINDSPEEDTIME']); 
$current->set_pressure($ary_parsed_file['BAR']);    
$today->set_highbar($ary_parsed_file['HIBAR'],$ary_parsed_file['HIBARTIME']);    
$today->set_lowbar($ary_parsed_file['LOWBAR'],$ary_parsed_file['LOWBARTIME']); 
$storm->set_rain($ary_parsed_file['STORMRAIN']);    
$current->set_rainrate($ary_parsed_file['RAINRATE']);
$current->set_rainrate2($ary_parsed_file['RAINRATE2']);      
$today->set_highrainrate($ary_parsed_file['HIRAINRATE'],$ary_parsed_file['HIRAINRATETIME']);
$today->set_highrainrate2($ary_parsed_file['HIRAINRATE2'],$ary_parsed_file['HIRAINRATETIME']);  
$seasonTillNow->set_rain($ary_parsed_file['TOTALRAIN']);
$seasonTillNow->set_rain2($ary_parsed_file['TOTALRAIN2']); 
$today->set_rain($ary_parsed_file['DAILYRAIN']);
$today->set_rain2($ary_parsed_file['DAILYRAIN2']);
$current->set_dew($ary_parsed_file['DEWPT']);    
$current->set_cloudbase((($current->get_temp()-$current->get_dew())* 125) + ELEVATION);
$current->set_windchill($ary_parsed_file['WINDCHILL']);
$current->set_heatidx($ary_parsed_file['HEATINDEX']);
$today->set_highheatindex($ary_parsed_file['HIHEATINDEX'],$ary_parsed_file['HIHEATINDEXTIME']);
$today->set_lowwindchill($ary_parsed_file['LOWWINDCHILL'],$ary_parsed_file['LOWWINDCHILLTIME']);
$current->set_solarradiation($ary_parsed_file['SOLARRAD']);
$current->set_uv($ary_parsed_file['UV']);
$today->set_highuv($ary_parsed_file['HIUV'],$ary_parsed_file['HIUVTIME']);
$yest->set_rain($ary_parsed_file['YESTRAIN']);
$yest->set_rain2($ary_parsed_file['YESTRAIN2']);
$yest->set_hightemp($ary_parsed_file['YESTHITEMP'], null);
$yest->set_lowtemp($ary_parsed_file['YESTLOWTEMP'], null);
$yest->set_hightemp2($ary_parsed_file['YESTHITEMP2'], null);
$yest->set_lowtemp2($ary_parsed_file['YESTLOWTEMP2'], null);
$current->set_intemp($ary_parsed_file['INSIDETEMP']);
$windUnits = $ary_parsed_file['WINDUNIT'];
$sunset = $ary_parsed_file['SUNSETTIME'];
$sunrise = $ary_parsed_file['SUNRISETIME'];
$rainrateHour=($ary_parsed_file['HIRAINRATEHOUR']);
$today->set_highradiation($ary_parsed_file['HISOLARRAD'],$ary_parsed_file['HISOLARRADTIME']);
$ary_parsed_file = getXMLInArray(FILE_XML_MONTHLY_YEARLY);
$thisMonth->set_highhum($ary_parsed_file['HIMONTHLYHUMIDITY'],"");    
$thisMonth->set_lowhum($ary_parsed_file['LOWMONTHLYHUMIDITY'],"");    
$thisYear->set_highhum($ary_parsed_file['HIYEARLYHUMIDITY'],"");    
$thisYear->set_lowhum($ary_parsed_file['LOWYEARLYHUMIDITY'],"");    

$thisMonth->set_hightemp($ary_parsed_file['HIMONTHLYTEMP'],"");    
$thisMonth->set_lowtemp($ary_parsed_file['LOWMONTHLYTEMP'],"");
$thisMonth->set_hightemp2($ary_parsed_file['HIMONTHLYTEMP'],"");    
$thisMonth->set_lowtemp2($ary_parsed_file['LOWMONTHLYTEMP'],"");    
$thisYear->set_hightemp($ary_parsed_file['HIYEARLYTEMP'],"");    
$thisYear->set_lowtemp($ary_parsed_file['LOWYEARLYTEMP'],"");
$thisYear->set_hightemp2($ary_parsed_file['HIYEARLYTEMP'],"");    
$thisYear->set_lowtemp2($ary_parsed_file['LOWYEARLYTEMP'],""); 
$thisMonth->set_highbar($ary_parsed_file['HIMONTHLYBAROMETER'],"");    
$thisMonth->set_lowbar($ary_parsed_file['LOWMONTHLYBAROMETER'],"");    
$thisYear->set_highbar($ary_parsed_file['HIYEARLYBAROMETER'],"");    
$thisYear->set_lowbar($ary_parsed_file['LOWYEARLYBAROMETER'],"");
$thisMonth->set_highdew($ary_parsed_file['HIMONTHLYDEWPOINT'],"");    
$thisMonth->set_lowdew($ary_parsed_file['LOWMONTHLYDEWPOINT'],"");    
$thisYear->set_highdew($ary_parsed_file['HIYEARLYDEWPOINT'],"");    
$thisYear->set_lowdew($ary_parsed_file['LOWYEARLYDEWPOINT'],"");
$thisMonth->set_highwind($ary_parsed_file['HIMONTHLYWINDSPEED'],"");    
$thisYear->set_highwind($ary_parsed_file['HIYEARLYWINDSPEED'],"");    
   
$thisMonth->set_rain($ary_parsed_file['MONTHLYRAIN']);    
$thisMonth->set_highrainrate($ary_parsed_file['HIMONTHLYRAINRATE'],"");    
$seasonTillNow->set_highrainrate($ary_parsed_file['HIYEARLYRAINRATE'],"");    

$thisMonth->set_highheatindex($ary_parsed_file['HIMONTHLYHEATINDEX'],"");
$thisMonth->set_highheatindex($ary_parsed_file['HIYEARLYHEATINDEX'],"");

$thisMonth->set_lowwindchill($ary_parsed_file['LOWMONTHLYWINDCHILL'],"");
$thisYear->set_lowwindchill($ary_parsed_file['LOWYEARLYWINDCHILL'],"");


$thisMonth->set_highuv($ary_parsed_file['HIMONTHLYUV'],"");
$thisYear->set_highuv($ary_parsed_file['HIYEARLYUV'],"");

$thisMonth->set_highradiation($ary_parsed_file['HIMONTHLYSOLARRAD'],"");
$thisYear->set_highradiation($ary_parsed_file['HIYEARLYSOLARRAD'],"");
$current->set_tempunit('C');

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
$daytime = date("D  G:i  ", $updatedStationDate); 
$dateInHeb = replaceDays($date);
$daytimeInHeb = replaceDays($daytime);
$datenotime = date(DATE_FORMAT , $updatedStationDate);        
$year = date("Y",  $updatedStationDate);
$monthInWord = getMonthName(date("n",  $updatedStationDate));   
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
$tok = getTokFromFile($prefix.FILE_ARCHIVE);
// now
if ($_GET['debug'] >= 1)
	echo "<br>in ".$prefix.FILE_ARCHIVE."<br>searching ",$now->get_date()," and ",$now->get_time()," ";
if (searchNext ($tok, $now->get_date())){// found the date in the file{}
    if ( searchNext ($tok, $min15->get_time())){
        $min15->set_thsw(getNextWord($tok, 14, "thsw"));
    }
    if ( searchNext ($tok, $now->get_time())){
        $current->set_thsw(getNextWord($tok, 14, "thsw"));
    }
    if (($current->get_thsw()==""))
        $current->set_thsw($min15->get_thsw());
}
else if ($_GET['debug'] >= 1)
    echo "<strong>NOT FOUND</strong>";
fillPastTime ($oneHour, $ary_parsed_file, '60');
fillPastTime ($min30, $ary_parsed_file, '30');
fillPastTime ($min15, $ary_parsed_file, '15');




////////// filling pm10 //////////
$array_pm = @array_map('str_getcsv', @file("getAveragePM10.txt"));
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

 
$decade = ($day < 11 ? 1 : ($day < 21 ? 2 : 3));        
$current_season = ($month > 8 ? sprintf("%04d-%04d", $year, $year + 1) : sprintf("%04d-%04d", $year - 1, $year));  
$prevMonthInWord = getMonthName(date("n",  mktime ($hour, $min, 0, getPrevMonth($month), 1 ,getPrevMonthYear($month, $year))));

$now->set_rain($current->get_rain());
if ($current->get_rainrate() === "0.0")
	$current->set_rainrate("0");

$current->set_cloudiness($mem->get('cloudiness'));
$ary_parsed_file = getXMLInArray(FILE_XML_FULLDATA2);
if ($current->get_windspd() == "--")
{
    $current->set_winddir($ary_parsed_file['WINDDIRECTION']);
    $current->set_windspd($ary_parsed_file['WINDSPEED']);
    $min10->set_windspd($ary_parsed_file['WIND10AVG']);
    $current->set_windspd10min($ary_parsed_file['WIND10AVG']);
}
$current->set_intemp($ary_parsed_file['INSIDETEMP']);
$current->set_thw($ary_parsed_file['THW']);
$today->set_et($ary_parsed_file['DAILYET']);
//$current->set_thsw($ary_parsed_file['THSW']);
$today->set_sunshinehours($mem->get(SUNSHINE_HOURS));

$temp_to_cold_meter = $current->get_temp_to_coldmeter();
$temp_from = $temp_to_cold_meter - 0.5;
$temp_to = $temp_to_cold_meter + 0.5;
$last_comments = array();
$last_comments = $mem->get($temp_from."to".$temp_to."comments");
if (is_in_twilight() && ($current->get_solarradiation() < 400))
{
    //logger("set_cloudiness: 6. sunset_ut:".get_sunset_ut()." get_current_time_ut:".$current->get_current_time_ut()." ".(get_sunset_ut() - $current->get_current_time_ut())." sunrise_ut:".get_sunrise_ut()." ".($current->get_current_time_ut() - get_sunrise_ut())." rad:".$current->get_solarradiation()." is sunset:".$current->is_sunset());
    $current->set_cloudiness(6);
}
 if (is_in_twilight() && ($current->get_solarradiation() < 240))
 {
     //logger("set_cloudiness: 8. sunset_ut:".get_sunset_ut()." get_current_time_ut:".$current->get_current_time_ut()." ".(get_sunset_ut() - $current->get_current_time_ut())." sunrise_ut:".get_sunrise_ut()." ".($current->get_current_time_ut() - get_sunrise_ut())." rad:".$current->get_solarradiation()." is sunset:".$current->is_sunset());
     $current->set_cloudiness(8);
 }
// debug
if ($_GET['debug'] >= 4){
echo "<br/>cloudiness= ".$current->get_cloudiness()." ".get_sunset_ut() - $current->get_current_time_ut()." ";
print("<br><br> current: ");
print_r($current);
print("<br><br> min15: ");
print_r($min15);
print("<br><br> min30: ");
print_r($min30);
print("<br><br> oneHour: ");
print_r($oneHour);
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


if (empty($last2['thsw']))
$last2['thsw'] = $min15->get_thsw();



//logger("thsw:".$current->get_thsw()." ".$min15->get_thsw()." ".$min30->get_thsw()." ".$oneHour->get_thsw()." ".$threeHours->get_thsw()." ".$yestsametime->get_thsw());
/************ air quality ***********/
$airq_link="http://www.svivaaqm.net/Online.aspx?ST_ID=36;1";
$airq_path=$prefix."cache/airq.html";


/*********** forecast download *********/


$for_link="http://wxweb.meteostar.com/sample/sample_C.shtml?text=LLJR/";
$for_path = $prefix."cache/latestGFS.html";

$isRemoteFile = substr($sat_link,0,7)=="http://";

 ////////////////////////////////////
///// generating links  ////////////
////////////////////////////////////
if (($current->get_temp()=="")||($current->get_hum() == ""))		
	$error_update = true;
$hoursat = sprintf("%02d%02d", (($min > 45) || ($min < 15) ) ? $hour - 4 : $hour - 3, (($min > 45) || ($min < 15) ) ? 30 : 00);
$sat_link="http://www.sat24.com/images.php?country=eu&sat=ir&type=large&rnd=866974";
$animation_link = "<img src=\"http://www.sat24.com/image.ashx?country=afis&amp;type=slide&amp;index=12&amp;time=&amp;sat=ir\" style=\"position: absolute; top: 0px; left: 0px; width: 640px; height: 480px; z-index: 12; opacity: 0; display: none; \">";

?>