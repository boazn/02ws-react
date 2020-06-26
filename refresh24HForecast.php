<?php
define("MANAGER_NAME","bn");
define("ICONS_PATH","images/icons/day");
define("CLOTHES_PATH","images/clothes");
ini_set("display_errors","On");
ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE);
// Connecting, selecting database
include_once("include.php"); 
include_once("lang.php");
include_once "start.php";
include_once ("requiredDBTasks.php");
include_once "sigweathercalc.php";
$forecastlib_origin = "refresh24HForecast.php";
$_REQUEST['MULTIPLE_FACTOR'] = $mem->get('MULTIPLE_FACTOR');//how quickly temp rise 0.9 - 1.2
$_REQUEST['MAX_TIME'] = $mem->get('max_time'); 
include_once("forecastlib.php");

$toDelete = new APCIterator('user', '/_new/', APC_ITER_VALUE);
$toStore = array();
//echo "\nkeys in cache\n-------------<br/>";
foreach ($toDelete AS $key => $value) {
    //echo $key ." ". $mem->get($key)."<br/>";
    //$mem->delete($key);
}
echo "\n<br/>keys in cache renewed";
foreach ($forecastHour as $hour_f)
    {
        $strTemp .= $hour_f['temp']." ";
    }
logger("refresh 24HForecast done. current temp=".$current->get_temp()." factor=".$mem->get('MULTIPLE_FACTOR')." max_time=".$mem->get('max_time')." ".$strTemp);
//echo "-------------<br/>";
//var_dump($forecastHour);
//var_dump($sigforecastHour);
//$mem->set($toStore);
//var_dump($mem->delete($toDelete));
?>