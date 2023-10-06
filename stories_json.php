<?
header('Content-type: text/html; charset=utf-8');
header("Access-Control-Allow-Origin: null");
ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE);
ini_set("display_errors","On");
include_once("include.php"); 
include_once("lang.php");
include('start.php');
include_once('requiredDBTasks.php');

?>

<?

$output_json_file_path_short = "/home/boazn/public/02ws.com/public/stories.json";
$JSON_ROOT = "{\"jws\":{";

    $MainStory_eng = $mem->get('mainstory0');
    $MainStory_heb = $mem->get('mainstory1');
$ACTIVITIES_JSON = " \"Stories\": [";

     $ACTIVITIES_JSON .= "{\"Description1\":"."\"".preg_replace( "`<br(?: /)?>([\\n\\r])`", " ", $MainStory_heb->get_description())."\",
                \"img_src1\":"."\"".$MainStory_heb->get_img_src()."\",  
               \"href1\":"."\"".$MainStory_heb->get_href()."\", 
               \"Title1\":"."\"".$MainStory_heb->get_Title()."\",
               \"Description0\":"."\"".$MainStory_eng->get_description()."\",
               \"img_src0\":"."\"".$MainStory_eng->get_img_src()."\",  
              \"href0\":"."\"".$MainStory_eng->get_href()."\", 
              \"Title0\":"."\"".$MainStory_eng->get_Title()."\" }";
               $ACTIVITIES_JSON .= ",";

$ACTIVITIES_JSON = rtrim($ACTIVITIES_JSON, ",");
$ACTIVITIES_JSON .= "]}";



$JSON_SHORT = $JSON_ROOT.$ACTIVITIES_JSON."}";

$file = fopen($output_json_file_path_short,"w");
fwrite ($file, $JSON_SHORT);
fclose ($file);
echo $JSON_SHORT;

 ?>