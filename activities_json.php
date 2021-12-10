<?
header('Content-type: text/html; charset=utf-8');
header("Access-Control-Allow-Origin: null");
ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE);
ini_set("display_errors","On");
include_once("activities.php"); 

$output_json_file_path_short = "/home/boazn/public/02ws.com/public/activities.json";
$JSON_ROOT = "{\"jws\":{";


$ACTIVITIES_JSON = " \"Activities\": [";
foreach ($ACTIVITIES_ARR as $activity){
     $ACTIVITIES_JSON .= "{\"name\":"."\"".$activity['name']."\",
                \"title0\":"."\"".$activity['title0']."\",  
               \"lang0\":"."\"".$activity['lang0']."\", 
               \"title1\":"."\"".$activity['title1']."\", 
               \"lang1\":"."\"".$activity['lang1']."\"  }";
               $ACTIVITIES_JSON .= ",";
}
$ACTIVITIES_JSON = rtrim($ACTIVITIES_JSON, ",");
$ACTIVITIES_JSON .= "]}";



$JSON_SHORT = $JSON_ROOT.$ACTIVITIES_JSON."}";

$file = fopen($output_json_file_path_short,"w");
fwrite ($file, $JSON_SHORT);
fclose ($file);
echo $JSON_SHORT;

 ?>