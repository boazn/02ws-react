
<?php
 require_once 'include.php';
 include_once("start.php");
class DB_Functions {
 
    private $db;
    
 function getForecastDays($param, $AscOrDesc, $maxormin, $condition){
     
     $query = "select * from forecast_days_archive ".$condition." order by ".$param." ".$AscOrDesc." LIMIT 0,200";
     //echo($query);
     $result = db_init($query, "");
     $JSON = "{\"jws\":";
     $JSON .= "{\"forecastDays\":[";
    while ($line = $result["result"]->fetch_array(MYSQLI_ASSOC)) {
        $lang_idx = 0;
        $JSON .= "{";
        $JSON .= "\"likes\":"."\"".$line['likes']."\"";
        $JSON .= ",";
        $JSON .= "\"dislikes\":"."\"".$line['dislikes']."\"";
        $JSON .= ",";
        $JSON .= "\"day_name0\":"."\"".$line['day_name']."\"";
        $JSON .= ",";
        $JSON .= "\"TempHighClothTitle0\":"."\"".getClothTitle($line['TempHighCloth'], $line['TempHigh'], 0,  $line['HumDay'])."\"";
        $JSON .= ",";
        $JSON .= "\"TempNightClothTitle0\":"."\"".getClothTitle($line['TempNightCloth'], $line['TempNight'], 0,  $line['HumDay'])."\"";
        $JSON .= ",";
        $lang_idx = 1;
        $JSON .= "\"day_name1\":"."\"".replaceDays($line['day_name']." ")."\"";
        $JSON .= ",";
        $JSON .= "\"date\":"."\"".$line['date']."\"";
        $JSON .= ",";
        $JSON .= "\"TempLow\":"."\"".$line['TempLow']."\"";
        $JSON .= ",";
        $JSON .= "\"TempHigh\":"."\"".$line['TempHigh']."\"";
        $JSON .= ",";
        $JSON .= "\"TempNight\":"."\"".$line['TempNight']."\"";
        $JSON .= ",";
        $JSON .= "\"TempHighCloth\":"."\""."images/clothes/".$line['TempHighCloth']."\"";
        $JSON .= ",";
        $JSON .= "\"TempHighClothTitle1\":"."\"".getClothTitle($line['TempHighCloth'], $line['TempHigh'], 0,  $line['HumNight'])."\"";
        $JSON .= ",";
        $JSON .= "\"TempNightCloth\":"."\""."images/clothes/".$line['TempNightCloth']."\"";
        $JSON .= ",";
        $JSON .= "\"TempNightClothTitle1\":"."\"".getClothTitle($line['TempNightCloth'], $line['TempNight'], 0,  $line['HumNight'])."\"";
        $JSON .= ",";
        $JSON .= "\"icon\":"."\""."images/icons/day/".$line['icon']."\"";
        $JSON .= ",";
        $JSON .= "\"lang1\":"."\"".str_replace('"', "&quot;",urldecode($line['lang1']))."\"";
         $JSON .= ",";
        $JSON .= "\"lang0\":"."\"".urldecode($line['lang0'])."\"";
         $JSON .= ",";
        $JSON .= "\"updated_at\":"."\"".explode('-', $line['Updated_at'])[0]."\"";
        $JSON .= "},";
    }
    $JSON = trim($JSON, ",");
    $JSON .= "]";
    $JSON .= "}}";
     return $JSON;
     @mysqli_free_result($result);
 }
 function updateForecastDayLikes ($idx)
{
    global $mem;
    $forecastDaysDB = $mem->get('forecastDaysDB');
     $day = $forecastDaysDB[$idx]['day'];
    $date = $forecastDaysDB[$idx]['date'];
    $day_name = $forecastDaysDB[$idx]['day_name'];
    $temp_low = $forecastDaysDB[$idx]['TempLow'];
    $temp_high = $forecastDaysDB[$idx]['TempHigh'];
    $temp_high_cloth = $forecastDaysDB[$idx]['TempHighCloth'];
    $temp_night = $forecastDaysDB[$idx]['TempNight'];
    $temp_night_cloth = $forecastDaysDB[$idx]['TempNightCloth'];
    $lang0 = $forecastDaysDB[$idx]['lang0'];
    $lang1 = $forecastDaysDB[$idx]['lang1'];
    $icon = $forecastDaysDB[$idx]['icon'];
    $active = 1;
    
    $key = array_search($_SERVER['REMOTE_ADDR'], $forecastDaysDB[$idx]['likes']);
    if (is_bool($key))
        array_push($forecastDaysDB[$idx]['likes'], $_SERVER['REMOTE_ADDR']);
    else
        unset($forecastDaysDB[$idx]['likes'][$key]); 
    //var_dump($forecastDaysDB[$idx]['likes']);
    $mem->set('forecastDaysDB',$forecastDaysDB);
    $likes = count($forecastDaysDB[$idx]['likes']);
    if ($likes > 0){
        $query = "UPDATE forecast_days_archive SET likes='{$likes}',lang0='{$lang0}',lang1='{$lang1}', Updated_at=SYSDATE() WHERE (idx=$idx)";
        //echo $query;
        $result = db_init($query, "");
        // Free resultset 
        //var_dump($result);
        if ($result["affectedrows"] == 0){
            $query = "INSERT INTO forecast_days_archive (day, day_name, date, TempLow, TempHigh, TempHighCloth, TempNight, TempNightCloth, lang0, lang1, active, icon, idx, likes) VALUES('{$day}', '{$day_name}', '{$date}', '{$temp_low}', '{$temp_high}', '{$temp_high_cloth}', '{$temp_night}', '{$temp_night_cloth}', '{$lang0}', '{$lang1}', '{$active}', '{$icon}', '{$idx}', '{$likes}');";
            $result = db_init($query, "");
            //var_dump($result);
        }
        @mysqli_free_result($result);
    }
    $likesJSON = "{\"likes\":[";
    $likesJSON .= "{\"count\":"."\"".$likes."\"".",\"idx\":"."\"".$idx."\"}";
    $likesJSON .= "]}";
    return $likesJSON;
}

function updateForecastDayDislikes ($idx)
{
    global $mem;
    $forecastDaysDB = $mem->get('forecastDaysDB');
    $day = $forecastDaysDB[$idx]['day'];
    $date = $forecastDaysDB[$idx]['date'];
    $day_name = $forecastDaysDB[$idx]['day_name'];
    $temp_low = $forecastDaysDB[$idx]['TempLow'];
    $temp_high = $forecastDaysDB[$idx]['TempHigh'];
    $temp_high_cloth = $forecastDaysDB[$idx]['TempHighCloth'];
    $temp_night = $forecastDaysDB[$idx]['TempNight'];
    $temp_night_cloth = $forecastDaysDB[$idx]['TempNightCloth'];
    $lang0 = $forecastDaysDB[$idx]['lang0'];
    $lang1 = $forecastDaysDB[$idx]['lang1'];
    $icon = $forecastDaysDB[$idx]['icon'];
    $active = 1;
     $key = array_search($_SERVER['REMOTE_ADDR'], $forecastDaysDB[$idx]['dislikes']);
      
    if (is_bool($key))
        array_push($forecastDaysDB[$idx]['dislikes'], $_SERVER['REMOTE_ADDR']);
    else
       unset($forecastDaysDB[$idx]['dislikes'][$key]); 
    //var_dump($forecastDaysDB[$idx]['dislikes']);
    $mem->set('forecastDaysDB',$forecastDaysDB);
    $dislikes = count($forecastDaysDB[$idx]['dislikes']);
    if ($dislikes > 0){
        $query = "UPDATE forecast_days_archive SET dislikes='{$dislikes}',lang0='{$lang0}',lang1='{$lang1}', Updated_at=SYSDATE()  WHERE (idx=$idx)";
        //echo $query;
        $result = db_init($query, "");
        // Free resultset 
        //var_dump($result);
        if ($result["affectedrows"] == 0){
            $query = "INSERT INTO forecast_days_archive (day, day_name, date, TempLow, TempHigh, TempHighCloth, TempNight, TempNightCloth, lang0, lang1, active, icon, idx, dislikes) VALUES('{$day}', '{$day_name}', '{$date}', '{$temp_low}', '{$temp_high}', '{$temp_high_cloth}', '{$temp_night}', '{$temp_night_cloth}', '{$lang0}', '{$lang1}', '{$active}', '{$icon}', '{$idx}', '{$dislikes}');";
            $result = db_init($query, "");

        }
        @mysqli_free_result($result);
    }
    $likesJSON = "{\"dislikes\":[";
    $likesJSON .= "{\"count\":"."\"".$dislikes."\"".",\"idx\":"."\"".$idx."\"}";
    $likesJSON .= "]}";
    return $likesJSON;
    return $likesJSON;
}
 
}

// response json
$json = array();
 
$empty = $post = array();
foreach ($_POST as $varname => $varvalue) {
   if (empty($varvalue)) {
       $empty[$varname] = $varvalue;
   } else {
       $post[$varname] = $varvalue;
   }
}

if (isset($_REQUEST["command"])) {
     
    $idx = $_REQUEST["idx"];
    $lang = $_REQUEST["lang"];
    $command = $_REQUEST["command"];
    $db = new DB_Functions();
    
    if ($command == "like")
        $res = $db->updateForecastDayLikes($idx);
    else if ($command == "dislike")
        $res = $db->updateForecastDayDislikes($idx);
    else 
        $res = $db->getForecastDays($_REQUEST["param"], $_POST["ascordesc"], $_POST["maxOrMin"], $_POST["condition"]);
    echo ($res);
} else {
 if (empty($empty)) {
   //print "None of the POSTed values are empty, posted:\n";
   //var_dump($post);
} else {
   $result .= "We have " . count($empty) . " empty values\n";
   $result .= "Posted:\n"; var_dump($post);
   $result .= "Empty:\n";  var_dump($empty);
   
}
}
?>
