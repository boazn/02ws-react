<?
header('Content-type: text/html; charset=utf-8');
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
$coldmeter_size = $_GET['coldmetersize'];
if ($coldmeter_size =="")
    $coldmeter_size = 15;
if ($current->get_temp() == "")
    exit;
$temp_to_cold_meter = $current->get_temp();
$itfeels = array();
$itfeels = $current->get_itfeels();
if (!empty($itfeels[0]))
	$temp_to_cold_meter = $itfeels[1];
       
$temp_from = $temp_to_cold_meter - 0.5;
$temp_to = $temp_to_cold_meter + 0.5;
$query_verdict = "call GetColdMeter({$temp_from}, {$temp_to}, '{$pgender}');";
//echo $query_verdict;
db_init("", "");
$result = mysqli_query($link, $query_verdict) ;
$row_verdict = mysqli_fetch_array($result, MYSQLI_ASSOC);
$current_feeling = get_name($row_verdict["field_name"]);
//if ($current_feeling === $VVCOLD[$lang_idx])
//logger("coldmeter: ".$row_verdict["field_name"].": ".$query_verdict." ".$_SESSION['email']);
 $cloth_name = getClothName($current_feeling);
 $arCloth_name =  explode('_', $cloth_name);
 $prefCloth_name = $arCloth_name[0];
$current_feeling = "<a href=\"WhatToWear.php#".$prefCloth_name."?lang=".$lang_idx."\" target=_blank >"."<img src=\"images/clothes/".$cloth_name."\" title=\"".getClothTitle($cloth_name)."\" width=\"".$coldmeter_size*1.21."\" height=\"".$coldmeter_size."\" style=\"vertical-align: middle\" /></a>&nbsp;<a ".$_SERVER['SCRIPT_NAME']."?section=survey.php&amp;survey_id=2&amp;lang=".$lang_idx."\" >".$current_feeling."</a>";    

$current_heat_index = get_heat_index($current->get_temp(), $current->get_hum());
 
if ($current_heat_index != "")
	$current_feeling = $current_feeling."<br /> ".$current_heat_index;
mysqli_close($link);
echo $current_feeling;
?>