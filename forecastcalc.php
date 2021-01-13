<?php
    
/************************************************************************/    
function updateSigForecast ($picP, $sigW, $extrainfoP, $urlP)
{
	global $sigForecast, $ALT, $pic, $extrainfoForecast, $url;
	 
	$ALT = $sigW;
	$pic = $picP;
	$extrainfoForecast = $extrainfoP;
	$url = $urlP;

	array_push($sigForecast, array('sig' => $sigW, 'pic' => $picP, 'extrainfo' => $extrainfoP, 'url' => $urlP));
}

$pic = "lights2.jpg";
$ALT = array();
$extrainfoForecast = array();
$sigForecast = array();
$url= get_query_edited_url(get_url(), 'section', 'forecast');
$forecastHour = $mem->get('forecasthour');
$random_rainexists = rand(0, count($RAIN_EXISTS_IN24HF)-1);
$random_dustexits = rand(0, count($DUST_EXISTS_IN24HF)-1);
$random_windexists = rand(0, count($HIGHWIND_EXISTS_IN24HF)-1);

if (rainExistsIn24hf()&&($today->get_rain() == 0))
{
	updateSigForecast(
	"", 
	$RAIN_EXISTS_IN24HF[$random_rainexists], 
	array(array("",""),array("","")), 
	"?section=graph.php&amp;graph=rain.php&amp;profile=1");

}
if (highwindExistsIn24hf()&&($today->get_highwind() < 35))
{
	updateSigForecast(
	"", 
	$HIGHWIND_EXISTS_IN24HF[$random_windexists], 
	array(array("",""),array("","")), 
	"?section=graph.php&amp;graph=wind.php&amp;profile=1");

}
if (dustExistsIn24hf()&&($current->get_pm10() < 150))
{
    updateSigForecast(
		"dust.gif", 
		$DUST_EXISTS_IN24HF[$random_dustexits], 
		array(array("",""),array("","")), 
                     "?section=dust.html");
}
