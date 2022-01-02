<?php
$station_code = TAF_STATION;//TAF_STATION; 
$shift_forecast_time = 0;
$taf_file = "cache/".$station_code.".txt"; 
$taf_server_file = "/data/forecasts/taf/stations/".$station_code.".TXT"; 
$taf_decoded = "http://www8.landings.com/cgi-bin/parse_wthr_script.pl?pass=37875119&amp;apt_id=".$station_code."&amp;type=TAF";  
$taf_decode_help = "http://aviationweather.gov/static/help/taf-decode.shtml";  
$taf_txt = "http://weather.noaa.gov/pub/data/forecasts/taf/stations/".$station_code.".TXT"; 
$taf_link = "http://weather.hometownlocator.com/Local-Weather.php?config=&amp;forecast=zandh&amp;pands=".$station_code."";
$forecast_link = get_query_edited_url(get_url(), 'section', 'forecast.php');
$webcam_link = get_query_edited_url(get_url(), 'section', 'webCamera.jpg');
$forecastHour = array();
$startTime = "";
$endTime = "";
$startDateTime = "";
$endDateTime = "";
$plusminus = 0;
$currentDay = new ForecastDay();
$currentDay->set_temp_day($today->get_hightemp(), null);
$currentDay->set_temp_night(round($current->get_temp()), null);
$currentDay->set_temp_morning($today->get_lowtemp(), null);
$currentDay->set_hum_day($today->get_hum_day(), null);
$currentDay->set_hum_night($todayForecast->get_hum_night(), null);
$currentDay->set_hum_morning($today->get_hum_morning(), null);
$currentDay->set_dust_day($today->get_dust_day(), null);
$currentDay->set_dust_night($todayForecast->get_dust_night(), null);
$currentDay->set_dust_morning($today->get_dust_morning(), null);
$currentDay->set_uvmax($today->get_uvmax(), null);
logger("starting forecastlib...from ".$forecastlib_origin, 0, "lib", "Forecastlib", "Forecastlib");
function getForecastDay($fday, $firstdayinforecast){
        global $todayForecast, $currentDay, $passedMidnight, $nextTomorrowForecast, $forcastday, $tomorrowForecast;
        
        if ($fday != $firstdayinforecast){
                //24h starts in yesterday
                switch ($passedMidnight){
                        case 2:
                        $forcastday = $nextTomorrowForecast;
                        break;
                        case 1:
                        $forcastday = $todayForecast;
                        break;
                        default:
                        $forcastday = $currentDay;
                        break;
                }
             
       }        
        else if ($fday == $firstdayinforecast) //24h starts in todayForecast
                $forcastday = ($passedMidnight? $tomorrowForecast : $todayForecast);
               
        //logger("forcastday null returned=".is_null($forcastday)." ".$fday." ".$firstdayinforecast." ".$passedMidnight);
             
        return $forcastday;
}
function calcForecastTemp($time_at_day, $tsh, $prev_temp, $forcastday, $MAX_TIME, $MULTIPLE_FACTOR)
 {
        global $todayForecast, $passedMidnight, $nextTomorrowForecast, $tomorrowForecast, $fday, $todayForecast_date, $tommorrowForecast_day, $today, $current, $firstdayinforecast;
                
        //if ($passedMidnight && ($firstdayinforecast == $tommorrowForecast_day))
	//		$forcastday = $todayForecast;
       
        if ($_REQUEST['debug'] >= 1){
                echo "<br>";
                echo "MAX_TIME=", $MAX_TIME;
                echo "<br>MULTIPLE_FACTOR= ",$MULTIPLE_FACTOR;
                echo "<br>time_at_day= <strong>".$time_at_day."</strong>";
                echo "<br>current temp=".$current->get_temp();
                echo "<br>today high temp=".$today->get_hightemp();
                echo "<br>today low temp=".$today->get_lowtemp();
                echo "<br>tommorrowForecast_day=".$tommorrowForecast_day;
                echo "<br>firstdayinforecast=".$firstdayinforecast;
                echo "<br>fday=".$fday;
                echo "<br>passedMidnight=".$passedMidnight;
                echo "<br>get_temp_morning= ",$forcastday->get_temp_morning();
                echo "<br>get_temp_day= ",$forcastday->get_temp_day();
                echo "<br>get_temp_night= ",$forcastday->get_temp_night();
                echo "<br>tsh - time()= ",($tsh - time());
                echo "<br>prevTempHour= ",$prev_temp;
               

        }
           
        
       if ($time_at_day <= 1){
                $tempHour = round(($prev_temp + $forcastday->get_temp_morning())/2); 
       }
        elseif ($time_at_day > 1 && $time_at_day <= 3)
                $tempHour = round(($prev_temp + $forcastday->get_temp_morning())/2);
        elseif ($time_at_day > 3 && $time_at_day < 7)
                $tempHour = $forcastday->get_temp_morning();

        elseif ($time_at_day >= 7 && $time_at_day <= $MAX_TIME - 1){
                        $diff = $forcastday->get_temp_day() - $forcastday->get_temp_morning();
                        $tempHour = round($forcastday->get_temp_morning() + (($time_at_day - ($MAX_TIME - 1 - ($MAX_TIME - 8)))/($MAX_TIME - 1 - ($MAX_TIME - 8)))*$diff*$MULTIPLE_FACTOR);
        }
        elseif ($time_at_day == ($MAX_TIME)){
                
                $tempHour = round(($prev_temp + $forcastday->get_temp_day())/2);
        }
               

        elseif ($time_at_day >= $MAX_TIME+1 && $time_at_day <= 21){
                        $diff = $forcastday->get_temp_day() - $forcastday->get_temp_night();
                        $tempHour = round($forcastday->get_temp_day() - (($time_at_day - $MAX_TIME)/(20 - $MAX_TIME + 1))*$diff);
        }
       elseif ($time_at_day >= 22 && $time_at_day <= 23)
                $tempHour = $forcastday->get_temp_night() - 1;
       if ($_REQUEST['debug'] >= 1){
              echo "<br>average of tempHour and current temp:".round(($tempHour + $current->get_temp())/2);
              echo "<br>average of tempHour and 2current temp:".round(($tempHour + (2*$current->get_temp()))/3);
       }
        
       if ($tsh - time() <= 3000){
                $tempHour =   round($prev_temp);
       }
        elseif  ($tsh - time() <= 4800){
                $tempHour = round(($tempHour + (2*$current->get_temp()))/3);
        }
       elseif  ($tsh - time() <= 9600)
               $tempHour = round(($tempHour + $current->get_temp())/2);
      if ($_REQUEST['debug'] >= 1)
                echo "<br><strong>tempHour</strong>=".$tempHour;
       

      return $tempHour;
 }
 function calcForecastHum($time_at_day, $forcastday, $MAX_TIME, $MULTIPLE_FACTOR)
 {
        global $currentDay, $todayForecast, $passedMidnight, $threeHours, $nextTomorrowForecast, $tomorrowForecast, $fday, $todayForecast_date, $tommorrowForecast_day, $today, $current, $firstdayinforecast;
        
        $forcastday = new ForecastDay();
        $forcastday = $todayForecast;      
        
        if ($_REQUEST['debug'] >= 1){
                
                echo "<br>get_hum_morning= ",$forcastday->get_hum_morning();
                echo "<br>get_hum_day= ",$forcastday->get_hum_day();
		echo "<br>get_hum_night= ",$forcastday->get_hum_night();
                echo "<br>currentDay get_hum_night= ",$currentDay->get_hum_night();

        }
           
        
        if ($time_at_day <= 4 ){
            
            $diff = $currentDay->get_hum_night() - $forcastday->get_hum_morning();
             if ($diff > 0)
                 $hourHum = round($forcastday->get_hum_morning() + ((4 - $time_at_day)/4)*$diff);
             elseif ($diff < 0)
                  $hourHum = round($currentDay->get_hum_night() + ((4 - $time_at_day)/4)*$diff);
             else
                 $hourHum = $forcastday->get_hum_morning();
            
            
        }
                
        elseif ($time_at_day > 4 && $time_at_day < 7)
                $hourHum = $forcastday->get_hum_morning();

        elseif ($time_at_day >= 7 && $time_at_day <= $MAX_TIME - 2){
                        $diff = $forcastday->get_hum_day() - $forcastday->get_hum_morning();
                        if ($diff > 0)
                            $hourHum = round($forcastday->get_hum_day() + (($time_at_day - ($MAX_TIME - 1 - 7))/($MAX_TIME - 1 - 7))*$diff*$MULTIPLE_FACTOR);
                        elseif ($diff < 0){
                            $hourHum = round($forcastday->get_hum_morning() + (($time_at_day - ($MAX_TIME - 1 - 7))/($MAX_TIME - 1 - 7))*$diff*$MULTIPLE_FACTOR);
                        }
                        else {
                            $hourHum = $forcastday->get_hum_morning();
                        }
        }
        elseif ($time_at_day >= ($MAX_TIME - 1) && $time_at_day <= $MAX_TIME)
                $hourHum = $forcastday->get_hum_day();

        elseif ($time_at_day > $MAX_TIME && $time_at_day <= 21){
                        $diff = $forcastday->get_hum_day() - $forcastday->get_hum_night();
                        if ($diff > 0)
                            $hourHum = round($forcastday->get_hum_night() - (($time_at_day - $MAX_TIME)/(20 - $MAX_TIME + 1))*$diff);
                        else{
                            $hourHum = round($forcastday->get_hum_day() - (($time_at_day - $MAX_TIME)/(20 - $MAX_TIME + 1))*$diff);
                        }
        }
       elseif ($time_at_day >= 22 && $time_at_day <= 23)
                $hourHum = $forcastday->get_hum_night();
        if ($_REQUEST['debug'] >= 1){
                 echo "<br>diff=".$diff;
         }
      return $hourHum;
 }
 function calcForecastDust($time_at_day, $forcastday, $MAX_TIME, $MULTIPLE_FACTOR)
 {
        global $currentDay, $todayForecast, $passedMidnight, $threeHours, $nextTomorrowForecast, $tomorrowForecast, $fday, $todayForecast_date, $tommorrowForecast_day, $today, $current, $firstdayinforecast;
        
        $forcastday = new ForecastDay();
        $forcastday = $todayForecast;      
        
        if ($_REQUEST['debug'] >= 1){
                
                echo "<br>get_dust_morning= ",$forcastday->get_dust_morning();
                echo "<br>get_dust_day= ",$forcastday->get_dust_day();
		echo "<br>get_dust_night= ",$forcastday->get_dust_night();
                echo "<br>currentDay get_dust_night= ",$currentDay->get_dust_night();

        }
           
        
        if ($time_at_day <= 3 ){
            
            $diff = $currentDay->get_dust_night() - $forcastday->get_dust_morning();
             if ($diff > 0)
                 $hourdust = round($forcastday->get_dust_morning() + ((3 - $time_at_day)/3)*$diff);
             elseif ($diff < 0)
                  $hourdust = round($currentDay->get_dust_night() - ((3 - $time_at_day)/3)*$diff);
             else
                 $hourdust = $forcastday->get_dust_morning();
            
            
        }
                
        elseif ($time_at_day > 3 && $time_at_day < 7)
                $hourdust = $forcastday->get_dust_morning();

        elseif ($time_at_day >= 7 && $time_at_day <= $MAX_TIME - 2){
                        $diff = $forcastday->get_dust_day() - $forcastday->get_dust_morning();
                        if ($diff > 0)
                            $hourdust = round($forcastday->get_dust_day() + (($time_at_day - ($MAX_TIME - 1 - 7))/($MAX_TIME - 1 - 7))*$diff*$MULTIPLE_FACTOR);
                        elseif ($diff < 0){
                            $hourdust = round($forcastday->get_dust_morning() + (($time_at_day - ($MAX_TIME - 1 - 7))/($MAX_TIME - 1 - 7))*$diff*$MULTIPLE_FACTOR);
                        }
                        else {
                            $hourdust = $forcastday->get_dust_morning();
                        }
        }
        elseif ($time_at_day >= ($MAX_TIME - 1) && $time_at_day <= $MAX_TIME)
                $hourdust = $forcastday->get_dust_day();

        elseif ($time_at_day > $MAX_TIME && $time_at_day <= 21){
                        $diff = $forcastday->get_dust_day() - $forcastday->get_dust_night();
                        if ($diff > 0)
                            $hourdust = round($forcastday->get_dust_night() - (($time_at_day - $MAX_TIME)/(20 - $MAX_TIME + 1))*$diff);
                        else{
                            $hourdust = round($forcastday->get_dust_day() - (($time_at_day - $MAX_TIME)/(20 - $MAX_TIME + 1))*$diff);
                        }
        }
       elseif ($time_at_day >= 22 && $time_at_day <= 23)
                $hourdust = $forcastday->get_dust_night();
        if ($_REQUEST['debug'] >= 1){
                 echo "<br>diff=".$diff;
         }
      return $hourdust;
 }
 function calcForecastUV($time_at_day, $forcastday, $MAX_TIME, $MULTIPLE_FACTOR)
 {
        global $sunrise, $sunset, $currentDay, $todayForecast, $passedMidnight, $threeHours, $nextTomorrowForecast, $tomorrowForecast, $fday, $todayForecast_date, $tommorrowForecast_day, $today, $current, $firstdayinforecast;

        $forcastday = new ForecastDay();
        $forcastday = $todayForecast;      

        if ($_REQUEST['debug'] >= 1){
                
                echo "<br>get_uv_max= ",$forcastday->get_uvmax();
        }
        if ($time_at_day <= $sunrise || $time_at_day > $sunset){
                $hourUV = 0;
                        
        }
        elseif ($time_at_day >= 7 && $time_at_day < $MAX_TIME - 2){
                $diff = $forcastday->get_uvmax();
                $hourUV = round(0 + (($time_at_day - ($MAX_TIME - 2 - 7))/($MAX_TIME - 2 - 7))*$diff*$MULTIPLE_FACTOR);
                
        }
        elseif ($time_at_day >= ($MAX_TIME - 2) && $time_at_day <= ($MAX_TIME - 1))
                $hourUV = $forcastday->get_uvmax();

        elseif ($time_at_day >  ($MAX_TIME - 1) && $time_at_day <= $sunset){
                $diff = $forcastday->get_uvmax();
                $hourUV = round($forcastday->get_uvmax() - (($time_at_day - $MAX_TIME)/(($sunset) - $MAX_TIME + 1))*$diff);
                        
        }
        if ($_REQUEST['debug'] >= 1){
                        echo "<br>diff=".$diff;
                        echo "<br>time_at_day=".$time_at_day." UV=".$hourUV;
                }
        return $hourUV;
 }
 
 
 function getCloth($temp)
 {
     global $link;
    $temp_from = $temp - 0.5;
    $temp_to = $temp + 0.5;
    $temp_from2 = $temp - 0.5;
    $temp_to2 = $temp + 0.5;
    $pgender = "";
     //logger("calling GetColdMeter in getCloth in forecastlib");
     $query_verdict = "call GetColdMeter({$temp_from}, {$temp_to}, {$temp_from2}, {$temp_to2}, '{$pgender}', null);";
    db_init("", "");
    $result = mysqli_query($link, $query_verdict) ;
    $row_verdict = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $current_feeling = get_name($row_verdict["field_name"]);
    //logger($current_feeling);
     $cloth_name = getClothName($current_feeling, "");
     $arCloth_name =  explode('_', $cloth_name);
    $prefCloth_name = $arCloth_name[0];
     return $cloth_name;
 }
function rainExistsInTaf ($forecast_title, $priority)
{
        global $BETWEEN, $FROM, $TO, $RAIN_WILL_STOP, $lang_idx, $RAIN, $DRIZZLE, $HAIL;
        $rainStoppedExists = false;
        // if rain is on the same segment - it does not exist
        if ($_REQUEST["debug"] >= 3)
                echo "rainExistsInTaf: last: ".$forecast_title[count($forecast_title) - 1]." beforelast: ".$forecast_title[count($forecast_title) - 2]."<br/>";

        if ((stristr($forecast_title[count($forecast_title) - 1], $RAIN[$lang_idx])) ||
                (stristr($forecast_title[count($forecast_title) - 2], $RAIN[$lang_idx])) ||
                (stristr($forecast_title[count($forecast_title) - 1], $DRIZZLE[$lang_idx])) ||
                (stristr($forecast_title[count($forecast_title) - 2], $DRIZZLE[$lang_idx])) ||
                (stristr($forecast_title[count($forecast_title) - 1], $HAIL[$lang_idx])) ||
                (stristr($forecast_title[count($forecast_title) - 2], $HAIL[$lang_idx]))) 
                return false;

        for ($i = 0; $i < count($forecast_title); $i++) {
                if (stristr ($forecast_title[$i], $RAIN_WILL_STOP[$lang_idx]))
                        $rainStoppedExists = true;
        }

        if ((FromExistsInTaf($forecast_title)) && ($priority > 60) && (!$rainStoppedExists)) {
                return true;
        }
        return false;
}


function FromExistsInTaf ($forecast_title)
{
        global $BETWEEN, $FROM, $TO, $RAIN_WILL_STOP, $lang_idx;

        for ($i = 0; $i < count($forecast_title); $i++) {
                if (stristr ($forecast_title[$i], $BETWEEN[$lang_idx]) && stristr ($forecast_title[$i], $TO[$lang_idx]))
                        return true;
        }
        return false;
}

function getWindSpeed($windstr)
{
        return substr($windstr, 3, 2)*2;
}
function getStartTime ($timerange)
{
        // daylight saving = + 2; regular = + 1
        if (strlen($timerange) == 4)
                $startpos = 0;
        else
                $startpos = 2;
        $startTime = substr($timerange, $startpos, 2) + 2 + $shift_forecast_time;
        $startTime = ($startTime >= 24 ? $startTime - 24 : $startTime);
        return $startTime;
}
function getPlusMinus ($starthour, $endhour)
{
    $avTime = getAverageTime ($starthour, $endhour);
    if ($_REQUEST['debug'] > 3)
   echo "avtime=".$avTime." start=".$starthour." end=".$endhour;
    if ($avTime < $starthour)
     return ($avTime + 24) - $starthour;
    else
     return $avTime - $starthour;
}
function getAverageTime ($starthour, $endhour)
{
    if ($endhour < $starthour){
        $average = round((($endhour + 24) + $starthour) / 2);
        if ($average > 24)
            return $average - 24;
         else
             return $average;

    }
    else {
        return round(($endhour + $starthour)/2) ;
    }
}
function getStartDateTime ($timerange, $plusminus)
{
    global $yearF, $monthF, $shift_forecast_time;
    if (strlen($timerange) < 2)
            return null;

    // daylight saving = + 2; regular = + 1
    if (strlen($timerange) == 4)
            $startpos = 0;
    else
            $startpos = 2;
    $startHour = substr($timerange, $startpos, 2) + 2 + $shift_forecast_time;
    $startday = substr($timerange, 0, 2);
    if ($startHour >= 24)
    {
            $startHour = $startHour - 24;
            $startday = $startday + 1;
    }
    $endHour = getEndTime($timerange);
    if ($plusminus)
    {
         $startHourAv = getAverageTime($startHour, $endHour);
         if ($startHourAv < $startHour)
             $startday = $startday + 1;
         $startHour = $startHourAv;
    }

    return mktime ($startHour, 0, 0, $monthF, $startday , $yearF);
}
function getEndDateTime ($timerange)
{
    global $yearF, $monthF, $shift_forecast_time;
    // daylight saving = + 2; regular = + 1
    if (strlen($timerange) == 4)
            $endpos = 2;
    else
            $endpos = 7;
    $endHour = substr($timerange, $endpos, 2) + 2 + $shift_forecast_time;
    $endday = substr($timerange, 5, 2);
    if ($endHour >= 24)
    {
            $endHour = $endHour - 24;
            $endday = $endday + 1;
    }

    return  mktime ($endHour, 0, 0, $monthF, $endday , $yearF);
}
function getEndTime ($timerange)
{
        global $shift_forecast_time;
        // daylight saving = + 2; regular = + 1
        if (strlen($timerange) == 4)
                $endpos = 2;
        else
                $endpos = 7;
        $endTime = substr($timerange, $endpos, 2) + 2 + $shift_forecast_time;
        $endTime = ($endTime >= 24 ? $endTime - 24 : $endTime);
        return $endTime;
}

function isTom ($timetaf, $timeFromTo)
{
        global $TOMORROW, $lang_idx;
        if ($timeFromTo < $timetaf)
                return " ".$TOMORROW[$lang_idx]." ";
        else
                return "";
}
function isLastTokenIsProb()
{
        global $lang_idx, $forecast_title, $GOOD_CHANCE_FOR, $LOW_CHANCE_FOR;
        //if ($_REQUEST["debug"] >= 3)
        //    echo "<br />LastToken:".trim($forecast_title[count($forecast_title)-2]);
    return (trim($forecast_title[count($forecast_title)-2][$lang_idx])==trim($LOW_CHANCE_FOR[$lang_idx])||trim($forecast_title[count($forecast_title)-2][$lang_idx])==trim($GOOD_CHANCE_FOR[$lang_idx]));
}
 


function extendValuesForPlusMinus(){
    //extend rain to plusminus values
    global $forecastHour;
    $index_hour = 0;
    if ($_REQUEST["debug"] >= 3)
    echo( "<br/>"."extend rain to plusminus values...");
    foreach ($forecastHour as &$hour_f){
                if ($hour_f['plusminus'] > 0){
                        for ($i=1; $i <= $hour_f['plusminus'] ; $i++){
                                //logger("forecastHour".$forecastHour[$index_hour]['time']." ".$index_hour." ".$i." priority:".$forecastHour[$index_hour]['priority']);
                                if ($forecastHour[$index_hour]['priority'] >= $forecastHour[$index_hour-1]['priority']) {//priority going up
                                        if ($index_hour-$i > 0){
                                                $forecastHour[$index_hour-$i]['rain'] = $hour_f['rain'];
                                                if ($_REQUEST["debug"] >= 3)
                                                echo( "<br/>".$forecastHour[$index_hour]['time'].": priority going up plusminus=".$hour_f['plusminus']." set forecast time=".$forecastHour[$index_hour-$i]['time']." into rain=".$hour_f['rain']);
                                      
                                         }
                                        
                                }else{//priority going down
                                        if ($index_hour+$i < count($forecastHour)){
                                               //$forecastHour[$index_hour+$i]['rain'] = $hour_f['rain'];
                                              if ($_REQUEST["debug"] >= 3)
                                              echo("<br/>".$forecastHour[$index_hour]['time'].": priority going down, set nothing");
                                        
                                        }
        
                                }
                                
                        }
                }
       $index_hour++;  
    }
    return $forecastHour;
}
function updateForecastHour($currentPri, $title, $icon){
    global $forecastHour, $startDateTime, $plusminus, $endDateTime, $new_line, $same_sigment, $year, $priority, $forecast_title, $isProb, $prob_mag;

        if ($_REQUEST["debug"] >= 3)
        {
                echo "inUpdateForecastHour--> startDateTime=";
                if ($startDateTime > 0)
                     echo date(" H d/m/Y", $startDateTime);
                echo " endDateTime=";
                if ($endDateTime > 0)
                     echo date(" H d/m/Y", $endDateTime);

                echo  "title=".$title[0]." CurrentPri=".$currentPri;
        }
    
    foreach ($forecastHour as &$hour_f){
        
        $currentDateTime = $hour_f['currentDateTime'];
        if (($currentDateTime == $startDateTime) && $plusminus > 0)	
            $hour_f['plusminus'] = $plusminus;
        if ((($currentDateTime >= $startDateTime) && ($currentDateTime <= $endDateTime))||
            (($currentDateTime >= $startDateTime) && ($endDateTime==""))||
            (($startDateTime=="")&&($endDateTime==""))){
               if ($_REQUEST["debug"] >= 3)
                echo "<br />newline=".$new_line." forecast_title=".count($forecast_title)." p=".$hour_f['priority']." icon=".$icon." plusminus=".$hour_f['plusminus']." in ".date("H d/m/y", $hour_f['currentDateTime'])." (".$hour_f['time']."): ";
            
                if ($icon == "wind"){
                        $hour_f['wind'] = $title;
                        if ($_REQUEST["debug"] >= 3){
                                echo " wind into ".$title;
                        }
                        continue;
                }

              $last_priority = $hour_f['priority'];
              if (($icon != "") &&(($currentPri > $hour_f['priority'] )||($new_line))){
                        $forecast_img = $icon;
                        if (($currentPri <= 55)&&(($hour_f['time']>19)||($hour_f['time']<6)))
                              $forecast_img =  ($currentPri < 30) ? "n4_moon.svg" : "n4_moonpc2.svg";
                          $hour_f['icon'] = $forecast_img;
                        if ($_REQUEST["debug"] >= 3){
                                 echo " icon into ".$forecast_img;
                                 echo " p into ".$currentPri;
                                 }
                }
                if ($currentPri > 65){
                        $hour_f['rain'] = 80;
                        if ($isProb){
                            if ($prob_mag == Chance::Low) $hour_f['rain'] = 30;
                            elseif ($prob_mag == Chance::VLow) $hour_f['rain'] = 10;
                            elseif ($prob_mag == Chance::Good) $hour_f['rain'] = 60;
                        }
                }
                else
                    $hour_f['rain'] = 0;
                 if ((($last_priority <= 35)&&(!$isProb))||(($new_line)&&(!isLastTokenIsProb()))){
                        $hour_f['title'] = $title;
                        if ($_REQUEST["debug"] >= 3)
                         echo	" + title ".$title[0]." truncated"; 
                 }
                 else if (($currentPri > $hour_f['priority'] )||(isLastTokenIsProb())){   
                        $comatoappend = " ";
                        if ((!isLastTokenIsProb())&&(count($hour_f['title'])>0)) $comatoappend = ", ";{
                            $hour_f['title'][0] .= $comatoappend.$title[0];
                            $hour_f['title'][1] .= $comatoappend.$title[1];
                       }
                       if ($hour_f['rain'] > 0){
                        $hour_f['title'][0] .= $comatoappend.$hour_f['rain']."%";
                        $hour_f['title'][1] .= $comatoappend.$hour_f['rain']."%"; 
                       }
                       
                        if ($_REQUEST["debug"] >= 3)
                         echo	" + title ".$title[0]." appended"; 
                 }
                 
                 if ($_REQUEST["debug"] >= 3)
                    echo " + rain=".$hour_f['rain'];
                 
                 $hour_f['priority'] = $currentPri;

            if ((((!$new_line)||($same_sigment))&&($currentPri > 40))||(($currentPri > $hour_f['priority'])&&($hour_f['priority']>50))){

                        /* if (($icon != "")&&($currentPri > $hour_f['priority'] ))
                        {
                                $hour_f['icon'] = $icon;
                                $hour_f['priority'] = $currentPri;
                                if ($_REQUEST["debug"] >= 3){
                                                echo " icon into ".$icon;
                                                echo " p into ".$hour_f['priority'];
                                                }
                        }   
                        $hour_f['title'] .= $title."<br />";
                        if ($_REQUEST["debug"] >= 3)
                                echo	" + title appended<br />";*/
                }
              else{
                        /* if (($icon != "")&&($currentPri > $hour_f['priority']))
                        {
                                $hour_f['icon'] = $icon;
                                if ($_REQUEST["debug"] >= 3)
                                                echo " icon into ".$icon;
                        }
                        $hour_f['title'] = $title."<br />";
                        $hour_f['priority'] = $currentPri;
                        if ($_REQUEST["debug"] >= 3){
                                                echo " p into ".$hour_f['priority'];
                                                echo	" + title appended<br />";
                                                }*/

                }

        }

    }//foreach
    

}
 
function updateForecast($currentPri, $title, $pic)
{
        global $mem, $priority, $forecast_title, $taf_pic, $last_priority, $title_pic, $new_line, $isProb, $prob_mag, $GOOD_CHANCE_FOR, $LOW_CHANCE_FOR, $lang_idx, $forecastHour, $same_sigment, $startTime, $endTimeForFH, $current, $hour;

         $last_priority = $priority;
         if ($_REQUEST["debug"] >= 3)
        {
                echo "<br/>inUpdateForecast--> title=".$title[0]." currentPri=".$currentPri." last_priority=".$last_priority." priority=".$priority." taf_pic=".$taf_pic." count=".count($forecast_title)."  new_line=".$new_line."  isProb=".$isProb."<br/>";
        }
        if (count($forecast_title) == 1){
            if ($currentPri<=20)
                    $mem->set("cloudiness", 0);
            else if ($currentPri<=25)
                    $mem->set("cloudiness", 2);
            else if ($currentPri<=35)
                    $mem->set("cloudiness", 4);
            else if ($currentPri<=40)
                    $mem->set("cloudiness", 6);
            else if (($currentPri==50)||($currentPri==55)) // dust
                    $mem->set("cloudiness", 2);
            else
                    $mem->set("cloudiness", 8);
        }

        //logger("cloudiness= ".$current->get_cloudiness()." sunset_ut:".get_sunset_ut()." get_current_time_ut:".$current->get_current_time_ut()." ".(get_sunset_ut() - $current->get_current_time_ut())." rad:".$current->get_solarradiation()." is sunset:".$current->is_sunset());
         if ($pic == "wind")
          {
                updateForecastHour($currentPri, $title, $pic);
                return;
          }
          if ($isProb)
          {
            $same_sigment = false;
        //if ((stristr ($forecast_title[count($forecast_title) - 1], $TO[$lang_idx]))&&
              //(stristr ($forecast_title[count($forecast_title) - 1], $FROM[$lang_idx])))
              //{

              if ($prob_mag == Chance::Low)
                  $prob_to_put = $LOW_CHANCE_FOR;
              else if ($prob_mag == Chance::Good)
                  $prob_to_put = $GOOD_CHANCE_FOR;
              else
                  $prob_to_put = $LOW_CHANCE_FOR;
              array_push($forecast_title, $prob_to_put);
              updateForecastHour($currentPri, $prob_to_put, "");
              if ($_REQUEST["debug"] >= 3)
                      echo "<br/>added ".$prob_to_put[0]."<br/>";
              
            $same_sigment = true;
                        //}

         }
         if ($currentPri >= $priority)
         {
                 if (($priority == 0)||($priority >= 50) || ($currentPri >= 35))
                 {
                         array_push($forecast_title, $title);
                          if ($_REQUEST["debug"] >= 3)
                                echo "currentPri >= priority --> added ".$title[0]."<br/>";
                 }
                 else if (!$new_line)
                 {
                          if (count($forecast_title) > 1)
                         {
                                $removed = array_pop($forecast_title);
                                if ($_REQUEST["debug"] >= 3)
                                        echo "not new line: removed ".$removed[0]."<br/>";
                         } 
                         array_push($forecast_title, $title);
                          if ($_REQUEST["debug"] >= 3)
                                echo "not new line: added ".$title[0]."<br/>";
                 }

            updateForecastHour($currentPri, $title, $pic);
                        $taf_pic = $pic;
                        $title_pic = $title;
                        $priority = $currentPri;

         }
         else if (($new_line)&&($currentPri != $priority))
         {
                        array_push($forecast_title, $title);
                        if ($_REQUEST["debug"] >= 3)
                           echo "new_line + currentPri != priority --> added ".$title[0]."<br/>";
                        updateForecastHour($currentPri, $title, $pic);
         }
         else if (!$same_sigment)
         { 
                 updateForecastHour($currentPri, $title, "");
     }
    $isProb = false;
     $new_line = false;
    $same_sigment = true;
}

 //////////////////////////////////////////////////////
 // start processing
/////////////////////////////////////////////////////////
 
 
if ($_REQUEST["debug"] >= 1)
echo "<br/></b><div align=left><br/><strong>Started forecastlib section.....</strong>";

 $hourindex = 0;
/*
if ($taf_contents == ""){
        if ((!file_exists($taf_file))||(filesize($taf_file) == 0)||(((time() - filemtime($taf_file)) > 3600)))
        {
                //echo "downloading forecast...<br/>";
                //$ftp = ftp_connect('tgftp.nws.noaa.gov', 21, 10);
                //@ftp_login($ftp, 'anonymous', 'password');
                //@ftp_get($ftp, $taf_file, $taf_server_file, FTP_ASCII);
                //@ftp_close($ftp);
                //echo "downloading file...".$sat_link;
                //echo "downloading file...".$sat_link;
                 $ip = @fopen($taf_txt, "rb");
                 $tp = fopen($taf_file, "wb");
                 while(fwrite($tp,@fread($ip, 4095)));
                   fclose($tp);
                   @fclose($ip);
        }
        $taf_contents = @file_get_contents($taf_file);
        //$_SESSION['taf_contents'] = $taf_contents;
}*/

$source = $taf_contents;
$forecast_title = array();
$generally="";
$same_sigment = false;
$taf_contents = str_replace("<br/>", " ", $taf_contents);
$taf_contents = str_replace("/>", " ", $taf_contents);
$taf_contents = str_replace("<br", " ", $taf_contents);
$MAX_TIME = $_REQUEST['MAX_TIME'];
$MULTIPLE_FACTOR = $_REQUEST['MULTIPLE_FACTOR'];
if (empty($MAX_TIME)) {$MAX_TIME = 14;}
if (empty($MULTIPLE_FACTOR)) {$MULTIPLE_FACTOR = 1.0;}
$taf_tokens = tokenizeQuoted($taf_contents);
//print_r($taf_tokens);
for ($i = 0; $i < count($taf_tokens); $i++)
{
    if ($_REQUEST["debug"] >= 3)
            echo "<br/>examining <strong>".$taf_tokens[$i]."</strong>";
    if ($i == 0)
    {
        list($yearF, $monthF, $dayF) = explode('/', $taf_tokens[$i]);
        list($fday, $fmonth, $fyear) = explode('/', $dayF."/".$monthF."/".$yearF);
        $fday = $day;
        $fmonth = $month;
        $fyear = $year;
        $dayF = $day;
        $monthF = $month;
        $yearF = $year;
        list($firstdayinforecast, $firstdayinforecast_month) = explode('/', $firstdayinforecast_l);
        $yest_date = @mktime (0, 0, 0, $fmonth, $fday-1 , $fyear);
        $todayForecast_date = date ("Y-m-d", @mktime (0, 0, 0, $fmonth, $fday , $fyear));
        $tommorrowForecast_date = date ("Y-m-d", @mktime (0, 0, 0, $fmonth, $fday+1 , $fyear));
        $tommorrowForecast_day = date ("d", @mktime (0, 0, 0, $fmonth, $fday+1 , $fyear));
        $atommorrowForecast_date = date ("Y-m-d", @mktime (0, 0, 0, $fmonth, $fday+2 , $fyear));
        $mem->set("dayF", $dayF);
        $mem->set("monthF", $monthF);
        $mem->set("yearF", $yearF);
        if ($_REQUEST['debug'] >= 1){
                echo "<br>in reading first token in taf:".$taf_tokens[$i];
                echo "<br>firstdayinforecast_l=".$firstdayinforecast_l;
                echo "<br>firstdayinforecast_month=".$firstdayinforecast_month;
                echo "<br>firstdayinforecast=".$firstdayinforecast;
                echo "<br>yest_date=".$yest_date;
                echo "<br>tommorrowForecast_date=".$tommorrowForecast_date;
                echo "<br>tommorrowForecast_day=".$tommorrowForecast_day;
                
                echo "<br>fday=".$fday;
                echo "<br>fmonth=".$fmonth;
                echo "<br>fyear=".$fyear;
         }
    }
    $dayC = $dayF;
    if ($i == 0) {
        
            $taf_pic = "n4_clear.svg";
            $title_pic = array("$MOSTLY[$EN] $CLEAR[$EN]", "$MOSTLY[$HEB] $CLEAR[$HEB]");
            $current->set_cloudiness(0);
            $priority = 0;
            $new_line = true;
            //$timetaf = (int)$taf_tokens[$i];
            $timetaf = $hour;
            $mem->set("timetaf", $timetaf);
            $mem->set("datetaf", $dayC."/".$monthF."/".$yearF);
            if ($_REQUEST["debug"] >= 3)
                echo "<br/>time of taf:".$timetaf;
            array_push($forecast_title, array("<span>".$GENERALLY[$EN]." "."</span>", "<span>".$GENERALLY[$HEB]." "."</span>"));
            $passedMidnight = 0;
            $prev_temp = $current->get_temp();
             for ($t=$timetaf + 1; $t <= $timetaf+30 ; $t++)
             {

                $h = $t % 24;
                
                if ($t % 24 == 0)
               {
                        $time = "00";
                        $passedMidnight = $passedMidnight + 1;
               }
                else 
                   $time = sprintf("%d", $h);
               if ($t % 24 == 0)
                       $dayC = $dayC + 1;
               $currentDateTime =  mktime ($h, 0, 0, $monthF, $dayC , $yearF);
               $forcastday = getForecastDay($fday, $firstdayinforecast);
               $tempHour = calcForecastTemp($h, $currentDateTime, $prev_temp, $forcastday, $MAX_TIME, $MULTIPLE_FACTOR); 
               $prev_temp = $tempHour;
               $clothHour = getCloth($tempHour);
               $humHour = calcForecastHum($h, $forcastday, $MAX_TIME, $MULTIPLE_FACTOR);
               $dustHour = calcForecastDust($h, $forcastday, $MAX_TIME, $MULTIPLE_FACTOR);
               $uvHour = calcForecastUV($h, $forcastday, $MAX_TIME, $MULTIPLE_FACTOR);
               if ($_REQUEST["debug"] >= 3){
                echo "<br/> forecastHour:".$hourindex." time=".$time." ".$currentDateTime." temp=".$tempHour." ".$clothHour;
                echo "<br/>-------------------------------------------------------------------------------------------";
               }
                   
               array_push($forecastHour, array('id' => $hourindex, 'time' => $time, 'currentDateTime' => $currentDateTime, 'plusminus' => 0, 'change' => 0, 'temp' => $tempHour, 'dust' => $dustHour, 'UV' => $uvHour, 'wind' => 0, 'humidity' => $humHour ,'rain' => 0, 'icon' => "", 'title' => array(), 'cloth' => $clothHour, 'priority' => 0));
               $hourindex += 1;
        }
        

           
   }
    if (stristr ($taf_tokens[$i], "KT")) {
           updateForecast($currentPri, getWindSpeed($taf_tokens[$i]), "wind");
    }
    if (stristr ($taf_tokens[$i], "PROB10")) {
        $isProb = true;
        $prob_mag = Chance::VLow;
    }
    if (stristr ($taf_tokens[$i], "PROB20")) {
        $isProb = true;
        $prob_mag = Chance::VLow;
    }
    if (stristr ($taf_tokens[$i], "PROB30")) {
            $isProb = true;
            $prob_mag = Chance::Low;
    }
    if (stristr ($taf_tokens[$i], "PROB40")) {
            $isProb = true;
            $prob_mag = Chance::Good;
    }
    if (stristr ($taf_tokens[$i], "RASN"))      updateForecast(95, array("$RAIN[$EN] $SNOW[$EN]", "$RAIN[$HEB] $SNOW[$HEB]"), "n4_rainSnow.svg");
     else if (stristr ($taf_tokens[$i], "SN"))  updateForecast(100, $SNOW, "n4_snow.svg");

    if ((stristr ($taf_tokens[$i], "GR"))||
             (stristr ($taf_tokens[$i], "GS"))) updateForecast(90, $HAIL, "n4_hail.svg");

    if (stristr ($taf_tokens[$i], "TSRA")) updateForecast(85, array($THUNDERSTORM[$EN].", ".$RAIN[$EN], $THUNDERSTORM[$HEB].", ".$RAIN[$HEB]), "n4_TSRA.svg");
    else if (stristr ($taf_tokens[$i], "TS")) updateForecast(80,$THUNDERSTORM, "n4_TS.svg");
    else if ((stristr ($taf_tokens[$i], "-SHRA"))||
            (stristr ($taf_tokens[$i], "-RA"))) updateForecast(75, $LIGHT_RAIN, "n4_sun_lightrain.svg");
    else if (stristr ($taf_tokens[$i], "RA")) updateForecast(78, $RAIN, "n4_rain2.svg");

    if (stristr ($taf_tokens[$i], "DZ")) updateForecast(68, $DRIZZLE, "n4_rainPC.svg");
    if (stristr ($taf_tokens[$i], "CB")) updateForecast(62, $SEVERE_CLOUDS, "n4_mostlycloudy.svg");
    if (stristr ($taf_tokens[$i], "FG")) updateForecast(60, $FOG, "n4_fog2.svg");
    if (stristr ($taf_tokens[$i], "SA")) updateForecast(55, $SANDSTORM, "dust.svg");
    if (stristr ($taf_tokens[$i], "DU")) updateForecast(50, $DUST, "dust.svg");
    if (stristr ($taf_tokens[$i], "TCU")) updateForecast(48, $SEVERE_CLOUDS, "n4_mostlycloudy.svg");
    if (stristr ($taf_tokens[$i], "OVC"))   {
        $currentPri = 45;

        if ($currentPri != $priority){
             $last_priority = $currentPri;
                // need to delete less important PC lines
                if (($forecast_title[count($forecast_title) - 1] == $FEW_CLOUDS)||
                        ($forecast_title[count($forecast_title) - 1] == $PARTLY_CLOUDY))
               {
                       $removed = array_pop($forecast_title);
                       if ($_REQUEST["debug"] >= 3)
                               echo "<br/>need to delete less important PC lines: removed ".$removed."<br/>";
               }
               updateForecast(40, array("$CLOUDY[$EN]", "$CLOUDY[$HEB]"), "n4_cloudy2.svg");

               if ($priority < $currentPri)
               {
                       $priority = $currentPri;
                       $taf_pic = "n4_mostlycloud.svg";
               }
        }
    }
    if (stristr ($taf_tokens[$i], "BKN"))   {
        $currentPri = 40;

        if ($currentPri != $priority){
             $last_priority = $currentPri;
                // need to delete less important PC lines
                if (($forecast_title[count($forecast_title) - 1] == $FEW_CLOUDS)||
                        ($forecast_title[count($forecast_title) - 1] == $PARTLY_CLOUDY))
               {
                       $removed = array_pop($forecast_title);
                       if ($_REQUEST["debug"] >= 3)
                               echo "<br/>need to delete less important PC lines: removed ".$removed."<br/>";
               }
               updateForecast(40, array("$MOSTLY[$EN] $CLOUDY[$EN]", "$MOSTLY[$HEB] $CLOUDY[$HEB]"), "n4_mostlycloudy.svg");

               if ($priority < $currentPri)
               {
                       $priority = $currentPri;
                       $taf_pic = "n4_mostlycloud.svg";
               }
        }
    }
    if (stristr ($taf_tokens[$i], "SCT"))  {
            $currentPri = 35;
        if ($currentPri != $priority){
            // need to delete less important PC lines
            if ($forecast_title[sizeof($forecast_title) - 1] == $FEW_CLOUDS)
           {
                   $removed = array_pop($forecast_title);
                   if ($_REQUEST["debug"] >= 3)
                           echo "<br/>need to delete less important PC lines: removed ".$removed."<br/>";
           }

            updateForecast(35, $PARTLY_CLOUDY, "n4_partlycloudy.svg");
            $last_priority = $currentPri;
            if ($priority < $currentPri)
            {
                   $priority = $currentPri;
                   $taf_pic = "n4_partlycloudy.svg";
            }

       }
    }
    if (stristr ($taf_tokens[$i], "FEW"))  updateForecast(25, $FEW_CLOUDS, "n4_pcFew.svg");	
    if (stristr ($taf_tokens[$i], "CAVOK"))  updateForecast(20, array("$MOSTLY[$EN] $CLEAR[$EN]", "$MOSTLY[$HEB] $CLEAR[$HEB]"), "n4_clear.svg");
    if (stristr ($taf_tokens[$i], "NSC")) updateForecast(18, array("$MOSTLY[$EN] $CLEAR[$EN]", "$MOSTLY[$HEB] $CLEAR[$HEB]"), "n4_clear.svg");
    if (stristr ($taf_tokens[$i], "SKC")) updateForecast(15, array("$MOSTLY[$EN] $CLEAR[$EN]", "$MOSTLY[$HEB] $CLEAR[$HEB]"), "n4_clear.svg");
    if (stristr ($taf_tokens[$i], "HZ"))  {/*			updateForecast(61, "$HAZE[$lang_idx]", "clear.png");*/}
    if ((stristr ($taf_tokens[$i], "FU"))) updateForecast(62, $HAZE, "n4_clear.svg");
    if ((stristr ($taf_tokens[$i], "BL"))) {/*			updateForecast(64, "$STRONG_WINDS[$lang_idx]", "");*/}
    if ((stristr ($taf_tokens[$i], "BR"))&&(!stristr ($taf_tokens[$i], "<"))) updateForecast(63, $FOG, "fogy.png");

    if (stristr ($taf_tokens[$i], "TEMPO"))    {
        if ($_REQUEST["debug"] >= 3)
                echo "<br/>In  TEMPO:";
        $same_sigment = false;
      
        $timerange = $taf_tokens[$i+1];
        $startTime = getStartTime($timerange);
        $endTime = getEndTime($timerange);
        $startDateTime = getStartDateTime($timerange, false);
        $endDateTime = getEndDateTime($timerange);
        if ($_REQUEST["debug"] >= 3){
                echo "<br/>examining <strong>".$timerange."</strong>";
                echo "<br/>startTime=".$startTime;
                echo "<br/>endTime=".$endTime;
                echo "<br/>startDateTime=".date(" H d/m/Y", $startDateTime);
                echo "<br/>endDateTime=".date(" H d/m/Y", $endDateTime);
        }
        $new_line = true;
        //if (rainExistsInTaf ($forecast_title, $priority)) 
        //	array_push($forecast_title, $RAIN_WILL_STOP[$lang_idx]);

        // need to delete irrelavent lines
        // delete the last lines 
        if ((stristr ($forecast_title[count($forecast_title) - 1][$lang_idx], $TO[$lang_idx])&&
                (stristr ($forecast_title[count($forecast_title) - 1][$lang_idx], $BETWEEN[$lang_idx]))))
        {
                $removed = array_pop($forecast_title); // tempo becmg
                if ($_REQUEST["debug"] >= 3)
                        "removed ".$removed."<br/>";

        }
        $tempotime =  "";
        if ((strlen($timerange) == 9))
        {
            $tempotime .= $BETWEEN[$lang_idx]." ".$startTime.".00 ".isTom($timetaf, $startTime)."-".$endTime.".00: ";
            $i = $i+1;
        }
        else
                $tempotime .= $TEMPO[$lang_idx].": ";
        $tempotime .= "";

        array_push($forecast_title, $tempotime);
        if ($_REQUEST["debug"] >= 3)
                echo "<br/> added ".$tempotime;
  }

    if (stristr ($taf_tokens[$i], "BECMG"))    {
         $same_sigment = false;
        $timerange = $taf_tokens[$i+1];
        $startTime = getStartTime($timerange);
        $endTime = getEndTime($timerange);
        $startDateTime = getStartDateTime($timerange, true);
        $plusminus = getPlusMinus($startTime, $endTime);
        $endDateTime = "";
        $new_line = true;
        if ($_REQUEST["debug"] >= 3)
                        echo "<br/>examining <strong>".$timerange."</strong>";
        $i = $i+1;
        //if (rainExistsInTaf ($forecast_title, $priority)) 
        //	array_push($forecast_title, $RAIN_WILL_STOP[$lang_idx]);

        // need to delete irrelavent lines without any weather
        // delete the last lines 
        if (((stristr ($forecast_title[count($forecast_title) - 1][$lang_idx], $TO[$lang_idx]))&&
                (stristr ($forecast_title[count($forecast_title) - 1][$lang_idx], $BETWEEN[$lang_idx])))||(stristr ($forecast_title[count($forecast_title) - 1][$lang_idx], $TEMPO[$lang_idx])))
        {
            $removed = array_pop($forecast_title); // tempo becmg
            if ($_REQUEST["debug"] >= 3)
                    echo "need to delete irrelavent lines without any weather: removed ".$removed."<br/>";

        }
        
        if ($_REQUEST["debug"] >= 3)
                echo "<br/>In  BECMG:";

        if ($startTime < 24)
                $tempotime = $BETWEEN[$lang_idx]." ".$startTime.".00".isTom($timetaf, $startTime)."-".$endTime.".00 ";
        $tempotime .=  " ".$BECMG[$lang_idx]." ".$BECMG_TO[$lang_idx];
        $tempotime .= "";
        array_push($forecast_title, $tempotime);
        if ($_REQUEST["debug"] >= 3)
                echo " added ".$tempotime."<br/>";


    }
    if ($_REQUEST["debug"] >= 3)
    {
     echo " <br />token:".$i." last_priority=".$last_priority." priority=".$priority." taf_pic=".$taf_pic." count=".count($forecast_title)." last=".$forecast_title[count($forecast_title) - 1][1]." new_line=".$new_line." startTime=".$startDateTime." endTime=".$endDateTime."<br/>";
    }
}
//if (rainExistsInTaf ($forecast_title, $priority)) 
//		array_push($forecast_title, $RAIN_WILL_STOP[$lang_idx]);
// remove tempo or becmg if remaining last
if ((stristr ($forecast_title[sizeof($forecast_title) - 1][0], $TO[0]))||(stristr ($forecast_title[count($forecast_title) - 1][0], $TEMPO[0])))
{
    $removed = array_pop($forecast_title); // tempo becmg
    if ($_REQUEST["debug"] >= 3)
            echo "removed the last line: ".$removed[0]."<br/>";

}
if (count($forecast_title) == 1) // generally
{
    updateForecast(20, array("$MOSTLY[$EN] $CLEAR[$EN]", "$MOSTLY[$HEB] $CLEAR[$HEB]"), "n4_clear.svg");
}
if ($_REQUEST["debug"] >= 3)
{
    echo "number of items in forecast: ".count($forecast_title)."<br/>";
    for ($i = 0; $i < count($forecast_title); $i++) {
            echo $forecast_title[$i][0]."<br />";
    }
}	
if ($_REQUEST["debug"] >= 3)
        echo "</div>";
 $forecastHour = extendValuesForPlusMinus();
if ($_REQUEST["debug"] >= 1)
        echo "<strong>finished</strong>";


$forcastTicker = "";
for ($i = 0; $i < count($forecast_title); $i++) {
   if ((stristr($forecast_title[$i][0], ":"))
            ||(stristr($forecast_title[$i][0], $BECMG[0]))
            ||($i == count($forecast_title) - 1)
            ||($i == 0))
    {
            if ($i == count($forecast_title) - 1)
                    $forcastTicker .= "<strong>".$forecast_title[$i]."</strong>.";
            else
                    $forcastTicker .= $forecast_title[$i];
    }
    else if (stristr($forecast_title[$i][0], $PROB[0]))
            $forcastTicker .= $forecast_title[$i];
    else if (($i < count($forecast_title) - 1) 
                      && ((stristr($forecast_title[$i+1][0], ":"))
                      || (stristr($forecast_title[$i+1][0], $BECMG[0]))))
    {
            $forcastTicker .= "<strong>".$forecast_title[$i]."</strong>";
            $forcastTicker .= ".&nbsp;";
    }
    else if ((!stristr($forecast_title[$i][0], "&nbsp;"))
               &&(!stristr($forecast_title[$i][0], $PROB[0])))
    {
            $forcastTicker .= "<strong>".$forecast_title[$i]."</strong>";
            $forcastTicker .= ", ";
    }
}
$forcastTicker = str_replace("\"", "'", $forcastTicker);
if ($forecastlib_origin != "hometable.php"){
        $mem->set("forecasthour", $forecastHour, 60*60*24);
        foreach ($forecastHour as $hour_f)
        {
        $strTemp .= $hour_f['temp']." ";
        }
       // logger("forecasthour saved:".$strTemp);
}
        
$sigforecastHour = array();
$i = 0;
foreach ($forecastHour as $hour_f){
    if (($hour_f === reset($forecastHour)) || (($hour_f['plusminus'] > 0) && enoughSignificant($i)) || (weatherSignificant($i)))
    {
        array_push($sigforecastHour, $hour_f);
    }
$i++;
}
$mem->set("sigforecastHour", $sigforecastHour, 60*60*24);


$sigWindHour = array();
$i = 0;
foreach ($forecastHour as $hour_f){
    if (windSignificant($i))
    {
        array_push($sigWindHour, $hour_f);
    }
$i++;
}
$mem->set("sigWindHour", $sigWindHour, 60*60*24);

?>