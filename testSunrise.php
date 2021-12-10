
<?
header('Content-type: text/html; charset=utf-8');
header("Access-Control-Allow-Origin: null");
ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE);
ini_set("display_errors","On");
include_once("include.php"); 
include_once "start.php";
include_once ("requiredDBTasks.php");
include_once "sigweathercalc.php";
$surise_suset_json = getSunriseSunset('');
//var_dump($surise_suset_json->location);
$daily_sunrise = $surise_suset_json->location->time[0]->sunrise->time;
$daily_sunset = $surise_suset_json->location->time[0]->sunset->time;
echo $daily_sunrise."<br/>";
echo $daily_sunset;
$daily_sunrise = $surise_suset_json->location->time[1]->sunrise->time;
$daily_sunset = $surise_suset_json->location->time[1]->sunset->time;
echo "<br/>".$daily_sunrise."<br/>";
echo $daily_sunset;
?>