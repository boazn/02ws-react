<?
ini_set("display_errors","On");
//redirectToSite(get_url());
//ini_set("display_errors","On");	
include_once("lang.php");
include_once("include.php"); 
$template_routing = @$_GET['section'];    
$profile = @$_GET['profile'];
$hoursForecast = @$_GET['hours'];
$limitLines = 7;
//
// url reset
//
$url_cur = get_url();
//$url_cur = get_query_edited_url($url_cur, 'hours', '');
//$url_cur = get_query_edited_url($url_cur, 'level', '');
//$url_cur = get_query_edited_url($url_cur, 'profile', '');
$url_cur = get_query_edited_url($url_cur, 'graph', '');
//echo $url_cur;
$error_update = false;
$boolbroken = false;    
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
$today = new TimeRange();
$todayForecast = new ForecastDay();
$tomorrowForecast = new ForecastDay();
$yest = new TimeRange();    
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
$ary_parsed_file = getXMLInArray($fulldatatotake);
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
$thisYear->set_hightemp($ary_parsed_file['HIYEARLYOUTSIDETEMP'],"");    
$thisYear->set_lowtemp($ary_parsed_file['LOWYEARLYOUTSIDETEMP'],"");    
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
$today->set_highheatindex($ary_parsed_file['HIHEATINDEX'],$ary_parsed_file['HIHEATINDEXTIME']);
$thisMonth->set_highheatindex($ary_parsed_file['HIMONTHLYHEATINDEX'],"");
$thisYear->set_highheatindex($ary_parsed_file['HIYEARLYHEATINDEX'],"");
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
$current->set_tempunit('&#176;c');
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
$style=$_GET['style'];
if ($style < 2) $style = "";

switch ($style) {
	case "":
		$forground_color = 'C5D4E9';//CBD8E6//ACC6D5//BCC7CD//B9C4CA//A3B1BA//A4CADD																				dec-216222226
		$base_color = '5171B7';//FEFEFE//3A5A70//BBC2BB//88938D//0E52A5//16435D//F2F7F5//B9D0D2
		break;
	case 2:
		$forground_color = 'D3E3E7';
		$base_color = 'D9E8C1';
		break;
	case 3:
		$forground_color = '0D1B2B';
		$base_color = 'CBEC80';
		break;
	case 4:
		$forground_color = 'E9EFF5';
		$base_color = 'FEFEFE';
		break;
	case 5:
		$forground_color = '456B4A';
		$base_color = 'A7ACB4';
		break;
	case 6:
		$forground_color = 'ff0000';
		$base_color = 'FEFEFE';
		break;
	case 7:
		$forground_color = '296F8F';
		$base_color = '5171B7';
		break;
	case 8:
		$forground_color = 'CDCE95';
		$base_color = '5171B7';//3A5A70//ACCBD5//DCDFE2//304A5C//466C86//42667D
		break;
	case 9:
		$forground_color = '836841';
		$base_color = '5171B7';
		break;
	default:
		$forground_color = 'ACC6D5';//ACC6D5//BCC7CD//B9C4CA//A3B1BA//A4CADD																				dec-216222226
		$base_color = 'B9D0D2';//FEFEFE//3A5A70//BBC2BB//88938D//0E52A5//16435D
}
$forground = new CSS_Color($forground_color);
$base = new CSS_Color($base_color);
$day = (int)strtok($current->get_date(), "/");    
$month = (int)strtok("/");    
$year = (int)strtok("/");    
$hour = (int)strtok($current->get_time(), ":");    
if (($hour >= 18)||($hour <= 7))           
$current->set_dark();	
$min = (int)strtok(":");    
$yhour = $hour;// maybe in the future it will be diffrent    
$offset = $min % INTERVAL;// maybe the update time is not like the times written in file        
$ymin = ($offset === 0 ? $min : $min - $offset);	
$yestsametime->set_time (getMinusHourTime(24));        
$yestsametime->set_date (getMinusHourDate(24));
$updatedStationDate = mktime ($hour, $min, 0, $month, $day ,$year);// Unix timestamp
$date = date("G:i D ".DATE_FORMAT, $updatedStationDate);
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
/*print_r($today);    
print("<br><br>");    
print_r($yest);    
print("<br><br>");    
print_r($thisMonth);    
print("<br><br>");    
print_r($thisYear);*/    
if ($current->get_rainrate() === "0.0")
	$current->set_rainrate("0");
		
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
echo "<br>searching ",$yestsametime->get_date()," and ",$yestsametime->get_time()," ";
if (searchNext ($tok, $yestsametime->get_date()))// found the date in the file
	fillPastTime ($yestsametime, searchNext ($tok, $yestsametime->get_time()));

//threeHours
if ($_GET['debug'] >= 1)
	echo "<br>searching ",$threeHours->get_date()," and ",$threeHours->get_time()," ";
if (searchNext ($tok, $threeHours->get_date()))// found the date in the file
	fillPastTime ($threeHours, searchNext ($tok, $threeHours->get_time()));

//oneHour
if ($_GET['debug'] >= 1)
	echo "<br>searching ",$oneHour->get_date()," and ",$oneHour->get_time()," ";
if (searchNext ($tok, $oneHour->get_date()))// found the date in the file
	fillPastTime ($oneHour, searchNext ($tok, $oneHour->get_time()));


// min30
if ($_GET['debug'] >= 1)
	echo "<br>searching ",$min30->get_date()," and ",$min30->get_time()," ";
if (searchNext ($tok, $min30->get_date()))// found the date in the file
	fillPastTime ($min30, searchNext ($tok, $min30->get_time()));

// min15
if ($_GET['debug'] >= 1)
	echo "<br>searching ",$min15->get_date()," and ",$min15->get_time()," ";
if (searchNext ($tok, $min15->get_date()))// found the date in the file
   fillPastTime ($min15, searchNext ($tok, $min15->get_time())); 

 // now
if ($_GET['debug'] >= 1)
	echo "<br>searching ",$now->get_date()," and ",$now->get_time()," ";
if (searchNext ($tok, $now->get_date()))// found the date in the file
   fillPastTime ($now, searchNext ($tok, $now->get_time())); 
// no current thsw value, so copy from min15
$current->set_thsw($min15->get_thsw());
logger("current:".$current->get_thsw()." min15:".$min15->get_thsw());
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