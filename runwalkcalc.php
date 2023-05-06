<?php
    
/************************************************************************/    
function updateSigRunWeather ($picP, $sigW, $extrainfoP, $urlP)
{
	global $sigRun, $ALT, $pic, $extrainfoRun, $url;
	 
	$ALT = $sigW;
	$pic = $picP;
	$extrainfo = $extrainfoP;
	$url = $urlP;

	array_push($sigRun, array('sig' => $sigW, 'pic' => $picP, 'extrainfo' => $extrainfo, 'url' => $urlP));
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
function getWindHumExp($currenttemp, $currenthum, $currentdew, $windspd, $windspd10min, $solarradiation)
{
	global $HEB, $EN, $HIGH_HUM_EXP, $LOW_HUM_LOW_TEMP_EXP, $LOW_HUM_HIGH_TEMP_EXP, $HIGH_WIND_HIGH_TEMP_EXP, $HIGH_WIND_EXP, $LIGHT_WIND_NIGHT_EXP, $NO_WIND_LOW_TEMP_EXP, $HIGH_WIND_HIGH_TEMP_EXP;
	$windhum_exp = array();
	if ((($windspd10min < 2)&&($currenttemp > 12))&&(($currenthum > 85)||($currentdew > c_or_f(16))))
	{
		$windhum_exp = $HIGH_HUM_EXP;
	}
	if (($currenthum < 50)&&($currenttemp < 15))
	{
		$windhum_exp = $LOW_HUM_LOW_TEMP_EXP; 
	}
	if (($currenthum < 35)&&($currenttemp > 20))
	{
		$windhum_exp = $LOW_HUM_HIGH_TEMP_EXP; 
	}
	if ((($windspd10min > 25)||($windspd > 35))&&($currenttemp > 20))
	{
		$windhum_exp = $HIGH_WIND_HIGH_TEMP_EXP;
	}
	elseif (($windspd10min > 25)||($windspd > 35))
	{
		$windhum_exp = $HIGH_WIND_EXP; 
	}elseif (($windspd10min > 2)&&($windspd > 3)&&($solarradiation < 100))
	{
		$windhum_exp = $LIGHT_WIND_NIGHT_EXP;
	}
	if (($windspd == 0)&&($windspd10min == 0)&&($currenttemp < 20)&&($solarradiation < 300))
	{
		$windhum_exp = $NO_WIND_LOW_TEMP_EXP;
	}
	if (($solarradiation > 500)&&($currenttemp > 20)&&($windspd10min > 18))
	{
		$windhum_exp = $HIGH_WIND_HIGH_TEMP_EXP;
	}
	$windHumExp = array(array($windhum_exp[$EN],$windhum_exp[$EN]),array($windhum_exp[$HEB],$windhum_exp[$HEB]));
	return $windHumExp;
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
	getWindHumSituation($current->get_hum(), $current->get_dew(), $min10->get_windspd()), 
	getWindHumExp($current->get_temp('C'), $current->get_hum(), $current->get_dew(), $current->get_windspd(), $min10->get_windspd(), $current->get_solarradiation()), 
	"?section=graph.php&amp;graph=temp.php&amp;profile=1");
if (($current->get_solarradiation() > 200)&&($current->get_thsw()-$current->get_temp() > 5)&&($min10->get_windspd() < 10))
{
	updateSigRunWeather(
    "", 
    $SUN_SHADE_DIFF_EXP, 
    array(array($IT_FEELS[$EN]." ".$current->get_thsw()."°",$IT_FEELS[$EN]." ".$current->get_thsw()."°"),array($IT_FEELS[$HEB]." ".$current->get_thsw()."°",$IT_FEELS[$HEB]." ".$current->get_thsw()."°")), 
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



/*if ($current->get_solarradiation() > 200)
	updateSigRunWeather(
			"", 
		$SUN_EXP, 
			array(array("",""),array("","")), 
			"?section=graph.php&amp;graph=rad.php&amp;profile=1");
   
?>*/