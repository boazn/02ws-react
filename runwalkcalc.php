<?php
    
/************************************************************************/    
function updateSigRunWeather ($picP, $sigW, $extrainfoP, $urlP)
{
	global $sigRun, $ALT, $pic, $extrainfoRun, $url;
	 
	$ALT = $sigW;
	$pic = $picP;
	$extrainfo = $extrainfoP;
	$url = $urlP;

	array_push($sigRun, array('sig' => $sigW, 'pic' => $picP, 'extrainfo' => $extrainfoP, 'url' => $urlP));
}

function getWindHumSituation($hum, $dew, $windspd)
{
	global $HEB, $EN, $HUM_NEUTRAL, $WIND, $HUMIDITY, $NOW, $HUM_HIGH, $HUM_LOW;
	if (($hum >= 50) && ($hum <= 80) && ($dew < c_or_f(15))){
		$hum_heb =  $HUM_NEUTRAL[$HEB];
		$hum_eng =  $HUM_NEUTRAL[$EN];
	}
	elseif (($hum > 80)||($dew > c_or_f(16))){
		$hum_heb =  $HUM_HIGH[$HEB];
		$hum_eng =  $HUM_HIGH[$EN];
	}
	elseif (($hum < 50)&& ($dew < c_or_f(10))){
		$hum_heb =  $HUM_LOW[$HEB];
		$hum_eng =  $HUM_LOW[$EN];
	}elseif (($hum < 35)&&($dew < c_or_f(12))){
		$hum_heb =  $HUM_LOW[$HEB];
		$hum_eng =  $HUM_LOW[$EN];
	}
	else{
		$hum_heb =  $HUM_NEUTRAL[$HEB];
		$hum_eng =  $HUM_NEUTRAL[$EN];
	}
			
	$wind_heb = getWindInfo($windspd, $HEB)['windtitle'];
	$wind_eng = getWindInfo($windspd, $EN)['windtitle'];
	$WindHum = array($hum_eng.", ".$wind_eng, $hum_heb.", ".$wind_heb);
	return $WindHum;
}
function getTempSituation($current)
{
	
}

$pic = "lights2.jpg";
$ALT = array();
$extrainfoRun = array();
$extrainfoS = array();
$sigRun = array();
$primarySig = array();
$url= get_query_edited_url(get_url(), 'section', 'extended');
$forecastHour = $mem->get('forecasthour');

updateSigRunWeather(
    "", 
    $RUN_GENERAL_EXP, 
    array(array("",""),array("","")), 
	"?section=graph.php&amp;graph=temp.php&amp;profile=1");
updateSigRunWeather(
	"", 
	getWindHumSituation($current->get_hum(), $current->get_dew(), $current->get_windspd()), 
	array(array("",""),array("","")), 
	"?section=graph.php&amp;graph=wind.php&amp;profile=1");
if (($current->get_hum() > 85)||($current->get_dew() > c_or_f(16)))
{
	updateSigRunWeather(
	"", 
	$HIGH_HUM_EXP, 
	array(array("",""),array("","")), 
	"?section=graph.php&amp;graph=temp.php&amp;profile=1");

}
if (($current->get_hum() < 50)&&($current->get_temp('C') < 15))
{
	updateSigRunWeather(
	"", 
	$LOW_HUM_LOW_TEMP_EXP, 
	array(array("",""),array("","")), 
	"?section=graph.php&amp;graph=temp.php&amp;profile=1");

}
if ($current->get_pm10() > 300 || $current->get_pm25() > 100)
{
    updateSigRunWeather(
		"dust.gif", 
		$HIGH_DUST, 
		array(array($SPORT_FORBIDEN[$EN],$SPORT_FORBIDEN[$EN]), 
                      array($SPORT_FORBIDEN[$HEB],$SPORT_FORBIDEN[$HEB])), 
                     "?section=dust.html");
}
if ($current->get_uv() > 9)
{
    updateSigRunWeather(
		"dust.gif", 
		$HIGH_UV, 
		array(array($SPORT_FORBIDEN[$EN],$SPORT_FORBIDEN[$EN]), 
                      array($SPORT_FORBIDEN[$HEB],$SPORT_FORBIDEN[$HEB])), 
                     "?section=graph.php&amp;graph=UVHistory.gif&amp;profile=2");
}
if (($current->get_hum() < 35)&&($current->get_temp('C') > 20))
{
	updateSigRunWeather(
	"", 
	$LOW_HUM_HIGH_TEMP_EXP, 
	array(array("",""),array("","")), 
	"?section=graph.php&amp;graph=temp.php&amp;profile=1");

}
if ((($min10->get_windspd() > 25)||($current->get_windspd() > 35))&&($current->get_temp('C') > 20))
{
	updateSigRunWeather(
    "", 
    $HIGH_WIND_HIGH_TEMP_EXP, 
    array(array("",""),array("","")), 
    "?section=graph.php&amp;graph=wind.php&amp;profile=1");

}
elseif (($min10->get_windspd() > 25)||($current->get_windspd() > 35))
{
	updateSigRunWeather(
    "", 
    $HIGH_WIND_EXP, 
    array(array("",""),array("","")), 
    "?section=graph.php&amp;graph=wind.php&amp;profile=1");

}elseif (($min10->get_windspd() > 2)&&($current->get_windspd() > 3)&&($current->get_solarradiation() < 100))
{
	updateSigRunWeather(
    "", 
    $LIGHT_WIND_NIGHT_EXP, 
    array(array("",""),array("","")), 
    "?section=graph.php&amp;graph=wind.php&amp;profile=1");

}
if (($current->get_windspd() == 0)&&($min10->get_windspd() == 0)&&($current->get_temp('C') < 20)&&($current->get_solarradiation() < 300))
{
	updateSigRunWeather(
    "", 
    $NO_WIND_LOW_TEMP_EXP, 
    array(array("",""),array("","")), 
    "?section=graph.php&amp;graph=temp.php&amp;profile=1");

}
if (($current->get_solarradiation() > 500)&&($current->get_temp('C') > 20)&&($min10->get_windspd() > 18))
{
	updateSigRunWeather(
    "", 
    $HIGH_WIND_HIGH_TEMP_EXP, 
    array(array("",""),array("","")), 
    "?section=graph.php&amp;graph=wind.php&amp;profile=1");

}

if (($current->get_solarradiation() > 200)&&($current->get_thsw()-$current->get_temp() > 5))
{
	updateSigRunWeather(
    "", 
    $SUN_SHADE_DIFF_EXP, 
    array(array("(".$current->get_thsw()."°)","(".$current->get_thsw()."°)"),array("(".$current->get_thsw()."°)","(".$current->get_thsw()."°)")), 
    "?section=graph.php&amp;graph=temp.php&amp;profile=1");

}



/*if ($current->get_solarradiation() > 200)
	updateSigRunWeather(
			"", 
		$SUN_EXP, 
			array(array("",""),array("","")), 
			"?section=graph.php&amp;graph=rad.php&amp;profile=1");
   
?>*/