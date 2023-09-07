
<?
header('Content-type: text/html; charset=utf-8');
//ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE);
ini_set("display_errors","On");
include_once("include.php"); 
include_once "start.php";
include_once ("requiredDBTasks.php");
include_once "sigweathercalc.php";
$surise_suset_json = getSunriseSunset('2023-09-03');
var_dump($surise_suset_json->properties->sunrise);
print_r($surise_suset_json->properties);
$daily_sunrise = $surise_suset_json->properties->sunrise->time;
$daily_sunset = $surise_suset_json->properties->sunset->time;
echo $daily_sunrise."<br/>";
echo $daily_sunset;
?>