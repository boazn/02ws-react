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
if ($current->get_temp() == "")
    exit;
$temp_to_cold_meter = $current->get_temp();
if (min($current->get_windchill(), $current->get_thw()) < ($current->get_temp()) && $current->get_temp() < 20 )
        $temp_to_cold_meter = min($current->get_windchill(), $current->get_thw());
 else if (max($current->get_HeatIdx(), $current->get_thw()) > ($current->get_temp()))
          $temp_to_cold_meter = max($current->get_HeatIdx(), $current->get_thw());
            
$temp_from = $temp_to_cold_meter - 0.5;
$temp_to = $temp_to_cold_meter + 0.5;
$query_verdict = "call GetColdMeter({$temp_from}, {$temp_to}, '{$pgender}');";
//echo $query_verdict;
db_init("");
$result = mysqli_query($link, $query_verdict) ;
$row_verdict = mysqli_fetch_array($result, MYSQLI_ASSOC);
$current_feeling = get_name($row_verdict["field_name"]);
if ($current_feeling == $VVCOLD[$lang_idx])
	logger("coldmeter: ".$row_verdict["field_name"].": ".$query_verdict);
$cloth_name = "";
if ($current_feeling == $VVHOT[$lang_idx])
    {$cloth_name = "shorts_n.png";}
    else if ($current_feeling == $VHOT[$lang_idx])
    {$cloth_name = "shorts_n.png";}
    else if ($current_feeling == $HOT[$lang_idx])
    {$cloth_name = "shorts_n.png";}
    else if ($current_feeling == $LHOT[$lang_idx])
    {$cloth_name = "tshirt_n.png";}
    else if ($current_feeling == $NHOTNCOLD[$lang_idx])
    {$cloth_name = "longsleeves_n.png";}
    else if ($current_feeling == $LCOLD[$lang_idx])
    {$cloth_name = "jacket_n.png";}
    else if ($current_feeling == $COLD[$lang_idx])
    {$cloth_name = "coat_n.png";}
    else if ($current_feeling == $VCOLD[$lang_idx])
    {$cloth_name = "coat_n.png";}
    else if ($current_feeling == $VVCOLD[$lang_idx])
    {$cloth_name = "coat_n.png";}
$current_feeling = "<img src=\"images/clothes/".$cloth_name."\" title=\"".getClothTitle($cloth_name)."\" width=\"30\" height=\"30\" style=\"vertical-align: middle\" />".$current_feeling;    

$current_heat_index = get_heat_index($current->get_temp(), $current->get_hum());
if ($current_heat_index != "")
	$current_feeling = $current_feeling."<br /> ".$current_heat_index;
mysqli_close($link);
echo $current_feeling;
?>