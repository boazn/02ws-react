<?
header('Content-type: text/html; charset=utf-8');
$forecastHour = apc_fetch('forecasthour');
if (count($_SESSION) > 0)
foreach ($_SESSION as $key=>$value)
{
    $session .= " ".$key.":".$value;
}
foreach ($_COOKIE as $key=>$value)
{
    $cookie .= " ".$key.":".$value;
}
function get_laundry_index()
{   
    global $forecastHour, $current, $lang_idx, $GOOD_LAUNDRY, $SOSO_LAUNDRY, $BAD_LAUNDRY;
    if ((dustExistsNow())||(dustExistsIn24hf())||(rainExistsIn24hf()))
        return array("no_L", $BAD_LAUNDRY[$lang_idx]) ;
    else if (bestLaundryConditions())
        return array("good_L", $GOOD_LAUNDRY[$lang_idx]);
    else
       return array("semiLgrey", $SOSO_LAUNDRY[$lang_idx]);
}
    
function bestLaundryConditions()
{
   global $forecastHour, $current, $min10;
   $numberOfSoSO;
   
    foreach ($forecastHour as $hour_f){
        if (($hour_f['humidity'] > 80)&&($hour_f['wind'] < 10)&&($hour_f['temp'] < 19)&&($hour_f['currentDateTime']) > time()&&($hour_f['currentDateTime']) < (time()+(6*60*60))){
            // logger("found :".$hour_f['humidity']." ".$hour_f['wind']);
            $numberOfSoSO++;
        }
   }
   if (($current->get_hum() < 40)&&($min10->get_windspd() > 3)&&($current->get_pm10() < 130 && $current->get_pm25() < 40))
       return true;
   //logger("current hum:".$current->get_hum());
   if ($numberOfSoSO > 3)
       return false;
   return true; 
}
function averageLaundryConditions()
{
    global $forecastHour, $current;
    foreach ($forecastHour as $hour_f){
        if (($hour_f['humidity'] > 85)&&($hour_f['currentDateTime']) > time())
            return false;
    }
    if ($current->get_hum() > 90)
       return false;
    return true;
}
function rainExistsIn24hf ()
{
    global $forecastHour;
    //logger("rainExistsIn24hf ".count($forecastHour));
    foreach ($forecastHour as $hour_f){
        
       if (($hour_f['rain'] > 0)&&($hour_f['currentDateTime']) > time()){
            
            return true;
        }
    }
    return false;
}
function dustExistsIn24hf ()
{
    global $forecastHour;
    foreach ($forecastHour as $hour_f){
         if (($hour_f['icon'] == "dust.png")&&($hour_f['currentDateTime']) > time()){
             
            return true;
         }
    }
    return false;
}
function dustExistsNow()
{
    global $current;
    return (($current->get_pm10() > 250));
}
function checkAsterisk($row_verdict)
{
    global $CLOSE_TO, $lang_idx;
    $close_to_sec_coldmeter = $CLOSE_TO[$lang_idx].get_name($row_verdict[1]["field_name"]);
    if (count($row_verdict) < 2)
        return "";
    if ($row_verdict[0]["count"] < ($row_verdict[1]["count"] + 90))
        return "<a href=\"javascript:void(0)\" class=\"info\" >*<span class=\"info\">".$close_to_sec_coldmeter."</span></a>";
}
function get_heat_index($temp, $hum)
{
	global $EXTREME_HEAT_INDEX, $HEAVY_HEAT_INDEX, $MEDIUM_HEAT_INDEX, $LOW_HEAT_INDEX, $lang_idx;
        
	switch ($hum)
	{
		case ($hum <= 15):
			switch ($temp)
			{
				case ($temp <= 30.5):
					return "";
				case ($temp <= 33):
					return $LOW_HEAT_INDEX[$lang_idx];
				case ($temp <= 38):
					return $MEDIUM_HEAT_INDEX[$lang_idx];
				case ($temp <= 42):
					return $HEAVY_HEAT_INDEX[$lang_idx];
				default:
					return $EXTREME_HEAT_INDEX[$lang_idx];
			}	
			break;
		case ($hum <= 25):
			switch ($temp)
			{
				case ($temp <= 29):
					return "";
				case ($temp <= 31):
					return $LOW_HEAT_INDEX[$lang_idx];
				case ($temp <= 36):
					return $MEDIUM_HEAT_INDEX[$lang_idx];
				case ($temp <= 41):
					return $HEAVY_HEAT_INDEX[$lang_idx];
				default:
					return $EXTREME_HEAT_INDEX[$lang_idx];
			}
			break;
		case ($hum <= 35):
			switch ($temp)
			{
				case ($temp <= 27.5):
					return "";
				case ($temp <= 30):
					return $LOW_HEAT_INDEX[$lang_idx];
				case ($temp <= 34.5):
					return $MEDIUM_HEAT_INDEX[$lang_idx];
				case ($temp <= 39):
					return $HEAVY_HEAT_INDEX[$lang_idx];
				default:
					return $EXTREME_HEAT_INDEX[$lang_idx];
			}
			break;
		case ($hum <= 45):
			switch ($temp)
			{
				case ($temp <= 26.5):
					return "";
				case ($temp <= 29):
					return $LOW_HEAT_INDEX[$lang_idx];
				case ($temp <= 33):
					return $MEDIUM_HEAT_INDEX[$lang_idx];
				case ($temp <= 37.5):
					return $HEAVY_HEAT_INDEX[$lang_idx];
				default:
					return $EXTREME_HEAT_INDEX[$lang_idx];
			}
			break;
		case ($hum <= 55):
			switch ($temp)
			{
				case ($temp <= 25.5):
					return "";
				case ($temp <= 28):
					return $LOW_HEAT_INDEX[$lang_idx];
				case ($temp <= 32):
					return $MEDIUM_HEAT_INDEX[$lang_idx];
				case ($temp <= 36.5):
					return $HEAVY_HEAT_INDEX[$lang_idx];
				default:
					return $EXTREME_HEAT_INDEX[$lang_idx];
			}
			break;
		case ($hum <= 65):
			switch ($temp)
			{
				case ($temp <= 24.5):
					return "";
				case ($temp <= 27):
					return $LOW_HEAT_INDEX[$lang_idx];
				case ($temp <= 31):
					return $MEDIUM_HEAT_INDEX[$lang_idx];
				case ($temp <= 35.5):
					return $HEAVY_HEAT_INDEX[$lang_idx];
				default:
					return $EXTREME_HEAT_INDEX[$lang_idx];
			}
			break;
		case ($hum <= 75):
			switch ($temp)
			{
				case ($temp <= 24):
					return "";
				case ($temp <= 26):
					return $LOW_HEAT_INDEX[$lang_idx];
				case ($temp <= 30):
					return $MEDIUM_HEAT_INDEX[$lang_idx];
				case ($temp <= 34.5):
					return $HEAVY_HEAT_INDEX[$lang_idx];
				default:
					return $EXTREME_HEAT_INDEX[$lang_idx];
			}
			break;
		case ($hum <= 85):
			switch ($temp)
			{
				case ($temp <= 23):
					return "";
				case ($temp <= 25.5):
					return $LOW_HEAT_INDEX[$lang_idx];
				case ($temp <= 29.5):
					return $MEDIUM_HEAT_INDEX[$lang_idx];
				case ($temp <= 34):
					return $HEAVY_HEAT_INDEX[$lang_idx];
				default:
					return $EXTREME_HEAT_INDEX[$lang_idx];
			}
			break;
		case ($hum <= 95):
			switch ($temp)
			{
				case ($temp <= 22.5):
					return "";
				case ($temp <= 24.5):
					return $LOW_HEAT_INDEX[$lang_idx];
				case ($temp <= 28.5):
					return $MEDIUM_HEAT_INDEX[$lang_idx];
				case ($temp <= 33):
					return $HEAVY_HEAT_INDEX[$lang_idx];
				default:
					return $EXTREME_HEAT_INDEX[$lang_idx];
			}
			break;
	}
	
}
include_once("include.php");
include_once("start.php");
include_once("requiredDBTasks.php");
$pgender = $_COOKIE['gender'];
$personal_coldmeter = $_COOKIE[PERSONAL_COLD_METER];
$coldmeter_size = $_GET['coldmetersize'];
if ($coldmeter_size =="")
    $coldmeter_size = 15;
if ($current->get_temp() == "")
    exit;
$temp_to_cold_meter = $current->get_temp_to_coldmeter();
$temp_from = $temp_to_cold_meter - 0.5;
$temp_to = $temp_to_cold_meter + 0.5;
$row_verdict = array();$row_comment = array();
$is_personal = "";
//logger("coldmeter_service:".$personal_coldmeter." ".$_SESSION['loggedin']." ".$_SESSION['email']." ".$temp_from." ".$temp_to);
if (($personal_coldmeter == 1)&&($_SESSION['loggedin'] == "true")){
    $query_verdict = "call GetColdMeter({$temp_from}, {$temp_to}, '{$pgender}', '{$_SESSION['email']}');";
    //logger( $query_verdict);
    db_init("", "");
    $result = mysqli_query($link, $query_verdict) ;
    $idx = 1;
    
    while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        if ($idx <= 2) array_push($row_verdict, array("field_name" => $line["field_name"], "count" => $line["count( * )"]));
        $idx = $idx + 1;
    }
    $feeling_verdict = $row_verdict[0]["field_name"];
    if ($row_verdict[0]["count"] > 0)
        $is_personal = " style=\"font-style: italic\" ";
}
if (empty($is_personal)){
    if (!apcu_fetch($pgender.$temp_from."to".$temp_to)){
       //logger("calling GetColdMeter".$temp_from." ".$temp_to." ".$pgender);
       $query_verdict = "call GetColdMeter({$temp_from}, {$temp_to}, '{$pgender}', null);";
       $lastcomments = "call GetLastComments({$temp_from}, {$temp_to});";
       //echo $query_verdict;
       db_init("", "");
       $result = mysqli_query($link, $query_verdict) ;
       $idx = 1;
       while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
           if ($idx <= 2) array_push($row_verdict, array("field_name" => $line["field_name"], "count" => $line["count( * )"]));
           $idx = $idx + 1;
       }
        $resultcomments = db_init($lastcomments, "");
        $commentidx = 1;
        while ($line = mysqli_fetch_array($resultcomments["result"], MYSQLI_ASSOC)) {
            array_push($row_comment, array("comment" => $line["comments"], "gender" => $line["gender"], "temp" => $line["temp"], "update_time" => $line["update_time"]));
            $commentidx = $commentidx + 1;
        }
       $feeling_verdict = $row_verdict[0]["field_name"];
       apcu_store($pgender.$temp_from."to".$temp_to, $row_verdict[0]["field_name"], 300);
       apcu_store($pgender.$temp_from."to".$temp_to."verdict", $row_verdict, 300);
       apcu_store($temp_from."to".$temp_to."comments", $row_comment, 300);
   }
   else{
       $row_verdict = apc_fetch($pgender.$temp_from."to".$temp_to."verdict");
       $feeling_verdict = apc_fetch($pgender.$temp_from."to".$temp_to);
   }
}
$current_feeling = get_name($feeling_verdict);
//if ($current_feeling === $VVCOLD[$lang_idx])
//logger("coldmeter: ".$current_feeling.": ".$feeling_verdict." ".$_SESSION['email']);
 $cloth_name = getClothName($current_feeling);
 $arCloth_name =  explode('_', $cloth_name);
 $prefCloth_name = $arCloth_name[0];
$current_feeling = "<a href=\"WhatToWear.php#".$prefCloth_name."?lang=".$lang_idx."\" target=_blank  >"."<img src=\"images/clothes/".$cloth_name."\" title=\"".getClothTitle($cloth_name, $current->get_temp())."\" width=\"".$coldmeter_size*1.21."\" height=\"".$coldmeter_size."\" style=\"vertical-align: middle\" /></a>&nbsp;<a ".$_SERVER['SCRIPT_NAME']."?section=survey.php&amp;survey_id=2&amp;lang=".$lang_idx."\"".$is_personal." title=\"".$HOTORCOLD_T[$lang_idx]." - ".$COLD_METER[$lang_idx]."\">".$current_feeling."</a>".checkAsterisk($row_verdict);    

$current_heat_index = get_heat_index($current->get_temp(), $current->get_hum());
 
if ($current_heat_index != "")
	$current_feeling = $current_feeling."<div id=\"heatindex\">".$current_heat_index."</div>";


echo $current_feeling;
$laundry_con = array();
$laundry_con = get_laundry_index();
echo "<div id=\"laundryidx\"><a href=\"javascript:void(0)\" class=\"info\" ><img src=\"images/laundry/".$laundry_con[0].".svg\" width=\"36\" height=\"36\" alt=\"laundry\" title=\"".$laundry_con[1]."\" /><span class=\"info\">".$laundry_con[1]."</span></a></div>";    
?>