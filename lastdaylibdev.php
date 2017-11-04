<?
function only_today($array)
{
    $today  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
    return ($array["RecDateTime"] == date('d/m/Y'));
}
function only_yesterday($array)
{
    $yesterday  = mktime(0, 0, 0, date("m")  , date("d")-1, date("Y"));
    //logger(date('d/m/Y', $yesterday));
    return ($array["RecDateTime"] == date('d/m/Y', $yesterday));
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
    return min($TempOut);
}

function get_noon_temp($array)
{
    $TempOut = array_column(array_filter($array, 'only_noon'), "TempOut");
    //print_r($TempOut); 
    return max($TempOut);
}

function get_max_temp($array)
{
    $TempOut = array_column($array, "TempOut");
    //print_r($TempOut); 
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
    return number_format(array_sum($TempOut) / count($TempOut),  1, '.', '');
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
if ((count($yestday_array) == 0)||(count($today_array) == 0))
{
    logger("empty today or yest array: ".count($yestday_array)." ".count($today_array));
}else{
    $yest->set_temp_morning(get_morning_temp($yestday_array), null);
    $yest->set_temp_day(get_noon_temp($yestday_array), null);
    $yest->set_temp_night(get_night_temp($yestday_array), null);
    $today->set_temp_morning(get_morning_temp($today_array), null);
    $today->set_temp_day(get_noon_temp($today_array), null);
    $today->set_hightemp2(get_max_temp($today_array), $today->get_hightemp2_time());
    $today->set_lowtemp2(get_min_temp($today_array), $today->get_lowtemp2_time());
}

?>
