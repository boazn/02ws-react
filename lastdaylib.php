<?
ini_set("display_errors","Off");
function only_today($array)
{
    $today  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
    $tom  = mktime(0, 0, 0, date("m")  , date("d")+1, date("Y"));
	// for the case of last day of month
	
	if (date('d/m/Y') < date('d/m/Y', $tom))
		$tom_str = date('d/m/Y', $tom);
	else
		$tom_str = "999";
	return ($array["RecDateTime"] >= date('d/m/Y') && $array["RecDateTime"] < $tom_str);
}
function only_yesterday($array)
{
    $yesterday  = mktime(0, 0, 0, date("m")  , date("d")-1, date("Y"));
    //logger(date('d/m/Y', $yesterday));
    return ($array["RecDateTime"] >= date('d/m/Y', $yesterday) && $array["RecDateTime"] < date('d/m/Y'));
}

function only_night($array)
{
    $time = explode(" ", $array["RecDateTime"])[1];
    return ($time == "22:00:00")||($time == "21:00:00")||($time == "20:00:00");
}
function only_noon($array)
{
    $time = explode(" ", $array["RecDateTime"])[1];
    return ($time > "12:00:00")&&($time <= "15:00:00");
}
function only_morning($array)
{
    $time = explode(" ", $array["RecDateTime"])[1];
    return ($time > "05:00:00")&&($time <= "08:00:00");
}

function get_morning_temp($array)
{
    $TempOut = array_column(array_filter($array, 'only_morning'), "TempOut");
    //print_r($TempOut); 
    if (count($TempOut) == 0)
        return "";
    return min($TempOut);
}

function get_noon_temp($array)
{
    $TempOut = array_column(array_filter($array, 'only_noon'), "TempOut");
    //print_r($TempOut);
    if (count($TempOut) == 0)
        return "";
    return max($TempOut);
}

function get_max_temp($array)
{
    $TempOut = array_column($array, "TempOut");
    //print_r($TempOut); 
    if (count($TempOut) == 0)
        return "";
    return max($TempOut);
}

function get_min_temp($array)
{
    $TempOut = array_column($array, "TempOut");
    //print_r($TempOut); 
    return min($TempOut);
}

function get_night_temp($array)
{
    $TempOut = array_column(array_filter($array, 'only_night'), "TempOut");
    //print_r($TempOut);
    if (count($TempOut) == 0)
        return "";
    return number_format(array_sum($TempOut) / count($TempOut),  1, '.', '');
}
function get_morning_hum($array)
{
   
    $HumOut = array_column(array_filter($array, 'only_morning'), "HumOut");
    //print_r($TempOut); 
    if (count($HumOut) == 0)
        return "";
    return round(array_sum($HumOut) / count($HumOut));
}

function get_noon_hum($array)
{
    $HumOut = array_column(array_filter($array, 'only_noon'), "HumOut");
    //print_r($TempOut); 
    return round(array_sum($HumOut) / count($HumOut));
}

function get_night_hum($array)
{
    $HumOut = array_column(array_filter($array, 'only_night'), "HumOut");
    //print_r($TempOut);  
    return round(array_sum($HumOut) / count($HumOut));
}
$path_to_file = "reports/LatestArchive.csv";
$lastday_array = array_map('str_getcsv', file($path_to_file));
array_walk($lastday_array, function(&$a) use ($lastday_array) {
      $a = array_combine($lastday_array[0], $a);
      $a["TempOut"] = number_format(((intval($a["TempOut"])/10) -32)*(5/9), 1, '.', '');
      $a["HeatIndex"] = number_format(((intval($a["HeatIndex"])/10) -32)*(5/9), 1, '.', '');
      $a["DewPoint"] = number_format(((intval($a["DewPoint"])/10) -32)*(5/9), 1, '.', '');
    });
array_shift($lastday_array); # remove column header
$yestday_array = array_filter($lastday_array, 'only_yesterday');
$today_array = array_filter($lastday_array, 'only_today');

$today->set_lowtemp2(get_min_temp($today_array), $today->get_lowtemp2_time());
$today->set_temp_morning(get_morning_temp($today_array), null);
$today->set_temp_day(get_noon_temp($today_array), null);
$today->set_hightemp2(get_max_temp($today_array), $today->get_hightemp2_time());
$today->set_hum_morning(get_morning_hum($today_array), null);
$today->set_hum_day(get_noon_hum($today_array), null);
if ((count($yestday_array) == 0))
{
    //logger("empty today or yest array: ".count($yestday_array));
    
    
}else{
    $yest->set_temp_morning(get_morning_temp($yestday_array), null);
    $yest->set_temp_day(get_noon_temp($yestday_array), null);
    $yest->set_temp_night(get_night_temp($yestday_array), null);
    $yest->set_hightemp2(get_max_temp($yestday_array), $yest->get_hightemp2_time());
    $yest->set_lowtemp2(get_min_temp($yestday_array), $yest->get_lowtemp2_time());
    $yest->set_hum_morning(get_morning_hum($yestday_array), null);
    $yest->set_hum_day(get_noon_hum($yestday_array), null);
    $yest->set_hum_night(get_night_hum($yestday_array), null);
    
}

?>
