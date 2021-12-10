<?php
//////////////////////////////////////////////
// filling yesterday data - should be reside after panel
//////////////////////////////////////////////
 
$monthAverge = new TimeRange();
$MainStory = New ContentSection();
//ini_set("display_errors","On");
//ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE);
//getting yestarday extremes 
function updateCachedVars(){
    global $mem, $month, $decade, $nextmonth, $nextdecade, $current_season, $monthAverge, $link;
    $monthAverge = new TimeRange();
    $query = "SELECT AccRain FROM raindailyaverage where ((month=$month) and (decade=$decade))";
    $result = mysqli_query($link, $query) ;
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $mem->set('currentDecadeRain', $row["AccRain"]);
    
    $query = "SELECT AccRain FROM raindailyaverage where ((month=$nextmonth) and (decade=$nextdecade))";
    $result = mysqli_query($link, $query) ;
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $mem->set('nextDecadeRain', $row["AccRain"]);
    
    // calculating current rainy days  accumulation
    $query = "SELECT SUM(RainyDays) FROM rainseason where (season='$current_season') ";
    $result = mysqli_query($link, $query) ;
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
     //need to know if today is rainy and the hour is before 23 --> add 1 to the sum
     $mem->set('totalRainyDays', $row["SUM(RainyDays)"]);
    
    $query = "SELECT * FROM average where (month=$month) ";
    $result = mysqli_query($link, $query) ;
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $monthAverge->set_hightemp ($row["HighTemp"],"");
    $monthAverge->set_hightemp2 ($row["HighTemp"],"");
    $monthAverge->set_lowtemp ($row["LowTemp"],"");
    $monthAverge->set_lowtemp2 ($row["LowTemp"],"");
    $monthAverge->set_highhum ($row["HighHum"],"");
    $monthAverge->set_lowhum ($row["LowHum"],"");
    $monthAverge->set_rain($row["Rain"]);
    $monthAverge->set_rainydays($row["RainyDays"]);
    $monthAverge->set_abshightemp($row["AbsHighTemp"], $row["AbsHighTempDate"]);
    $monthAverge->set_abslowtemp($row["AbsLowTemp"],$row["AbsLowTempDate"]);
    $monthAverge->set_absmaxrain($row["AbsMaxRain"]);
    $monthAverge->set_absminrain($row["AbsMinRain"]);
    $mem->set('monthAverage', $monthAverge);
    
    $query = "SELECT  lastSent FROM sendmailsms  where (Action='RainStarted') ";
    $result = mysqli_query($link, $query) ;
    $row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
    $mem->set('lastSentRainStarted', $row["lastSent"]);
    
    
    $query = "SELECT avg(anomaly) FROM globalwarming";
    $result = mysqli_query($link, $query) ;
    $row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
    $mem->set('avganomaly', $row['avg(anomaly)']);
    logger("updateCachedVars...done.", 0, "DB", "requiredDBTaska", "updateCachedVars");
    return true;
}
if ($_GET['debug'] >= 1)
	echo "<br /><b>getting yestarday extremes</b><br />";

$yest->set_temp_morning($mem->get(YEST_MORNING_TEMP), null);
$yest->set_temp_day($mem->get(YEST_NOON_TEMP), null);
$yest->set_temp_night($mem->get(YEST_NIGHT_TEMP), null);
$today->set_temp_morning($mem->get(TODAY_MORNING_TEMP), null);
$today->set_temp_day($mem->get(TODAY_NOON_TEMP), null);


// Connecting, selecting database
if ($_GET["debug"] >= 1)
	echo "<b>Stared DBTasks.....";

db_init("", "");


////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
/*
 * scheduled tasksa
 *
 */
// Update Rainy days and mm on day 
$thisMonth->set_rainydays($mem->get(THIS_MONTH_RAINY_DAYS));
$prevMonth->set_rainydays($mem->get(PREV_MONTH_RAINY_DAYS));
	try{
if (($hour == 2)&&($min<10)) {
    $tok = ($day > 1) ? getTokFromFile(FILE_THIS_MONTH) : getTokFromFile(FILE_PREV_MONTH);

    $found = searchNext ($tok, "Rain:");//max rain 
    if (searchNext ($tok, "Rain:"))//rainy days   
    {
        if ($day == 1)
        {
            $rdays = strtok(" \t");
            $mem->set(PREV_MONTH_RAINY_DAYS, $rdays);
            $prevMonth->set_rainydays($rdays); 
            $mrdays = ($today->get_rain() > 0) ? 1 : 0;
            $thisMonth->set_rainydays($mrdays);
            $mem->set(THIS_MONTH_RAINY_DAYS, $mrdays);    
            $prevMonth->set_rain(getPrevMonthRain());
            $mm = $prevMonth->get_rain();$month_to_update = getPrevMonth($month);$year_to_update = getPrevMonthYear($month, $year);
        }
        else
        {
            $rdays = strtok(" \t");
            $mem->set(THIS_MONTH_RAINY_DAYS, $rdays);
            $thisMonth->set_rainydays($rdays);
            $mm = $thisMonth->get_rain();$month_to_update = $month;$year_to_update = $year;
        }
    }

 $query = "UPDATE rainseason SET RainyDays=$rdays, mm=$mm WHERE ((month=$month_to_update) and (Year=$year_to_update))";
 $result = mysqli_query($link, $query); 
  //or print($php_errormsg);
    }
    }
catch (Exception $e){
    logger("set_rainydays:".$e->getMessage(), 4, "DB", "requiredDBTaska", "set_rainydays");
}

//reset mail/sms every day if 24 hours passed since last sent
if ($hour == 1) {
  $query = "SELECT * From dooncechecklist where Action='ResetMailSMS'";
  $result = mysqli_query($link, $query);
  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
  if ($row["Today"] != $datenotime)
  {
	/***********************************************************************/	

	/* getting data from thisYear file */        
	$tok = getTokFromFile(FILE_THIS_YEAR);
	getNextWordWith($tok, "---");
	$borderword = getNextWordWith($tok, "---");
	if ($borderword != "")
		$yearlyAnomaly = getNextWord($tok, 4, "year");
	else
		$yearlyAnomaly = 0;
	//echo "anomaly = ".$yearlyAnomaly;

	$query = "UPDATE dooncechecklist SET Today='$datenotime' where Action='ResetMailSMS'";
	$result = mysqli_query($link, $query);
	$query = "UPDATE sendmailsms SET Sent = '0' WHERE ((unix_timestamp(now())-unix_timestamp(lastSent))>".SENDMAIL_SLEEP_INTERVAL.")";
	$result = mysqli_query($link, $query); 
	$query = sprintf("UPDATE globalwarming SET anomaly=%d where year=%d", $yearlyAnomaly, $year);
	$result = mysqli_query($link, $query);
  }	
       
  //or print($php_errormsg);
}
    $query = "SELECT Date, Time, ROUND(MAX(TEMP),1) TEMP, ROUND(MAX(TEMP2), 1) TEMP2, ROUND(MAX(Hum)) Hum, Round(MAX(Dew),1) Dew, Round(MAX(TEMP3),1) TEMP3, Round(MAX(SolarRadiation)) SolarRadiation, Round(MAX(uv), 1) uv, MAX(pm10) pm10, MAX(pm25) pm25 FROM `archivelatest` WHERE Date = DATE_ADD(CURDATE(), INTERVAL -1 DAY) AND HOUR(`Time`) = HOUR(NOW()) AND (MINUTE(`Time`) = MINUTE(NOW()) or MINUTE(`Time`) = MINUTE(NOW()) - 1 or MINUTE(`Time`) = MINUTE(NOW()) + 1)";
        $result = mysqli_query($link, $query) ;
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $yestsametime->set_temp( $row["TEMP"]);
	$yestsametime->set_temp2 ($row["TEMP2"]);
	$yestsametime->set_hum ($row["Hum"]);
	$yestsametime->set_dew ($row["Dew"]);
	$yestsametime->set_solarradiation ($row["SolarRadiation"]);
	$yestsametime->set_uv($row["uv"]);
        $yestsametime->set_temp3($row["TEMP3"]);
        $yestsametime->set_pm10($row["pm10"]);
        $yestsametime->set_pm25($row["pm25"]);
        $yestsametime->set_change($current->get_temp2(), 
                                            $current->get_hum(),
                                            $current->get_dew(), 
                                            $current->get_windspd(), 
                                            $current->get_pressure(),
                                            $current->get_cloudbase(),
                                            $current->get_rainrate(),
                                            $current->get_solarradiation(),
                                            $current->get_uv(),
                                            $current->get_temp(),
                                            $current->get_temp3(),
                                            $current->get_pm10(),
                                            $current->get_pm25());
        if ($_GET["debug"] >= 1)
            echo "<br />set yestsametime(".$row["Time"]."): ".$row["pm10"]." ".$row["pm25"]." ".$row["TEMP"]." ".$row["TEMP2"]." ".$row["Hum"]." ".$row["Dew"];
        
     $query = "SELECT Date, Time, ROUND(MAX(TEMP),1) TEMP, ROUND(MAX(TEMP2), 1) TEMP2, ROUND(MAX(Hum)) Hum, Dew, Round(MAX(TEMP3),1) TEMP3, Round(MAX(SolarRadiation)) SolarRadiation, Round(MAX(uv), 1) uv, MAX(pm10) pm10, MAX(pm25) pm25 FROM `archivelatest` WHERE Date = DATE(SUBTIME(NOW(), '03:00:00')) AND HOUR(`Time`) = HOUR(SUBTIME(NOW(), '03:00:00')) AND (MINUTE(`Time`) = MINUTE(NOW()) or MINUTE(`Time`) = MINUTE(NOW()) - 1 or MINUTE(`Time`) = MINUTE(NOW()) + 1)";
        $result = mysqli_query($link, $query) ;
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $threeHours->set_temp( $row["TEMP"]);
	$threeHours->set_temp2 ($row["TEMP2"]);
	$threeHours->set_hum ($row["Hum"]);
	$threeHours->set_dew ($row["Dew"]);
	$threeHours->set_solarradiation ($row["SolarRadiation"]);
    $threeHours->set_uv($row["uv"]);
    $threeHours->set_pm10($row["pm10"]);
    $threeHours->set_pm25($row["pm25"]);
    $threeHours->set_change($current->get_temp2(), 
                                            $current->get_hum(),
                                            $current->get_dew(), 
                                            $current->get_windspd(), 
                                            $current->get_pressure(),
                                            $current->get_cloudbase(),
                                            $current->get_rainrate(),
                                            $current->get_solarradiation(),
                                            $current->get_uv(),
                                            $current->get_temp(),
                                            $current->get_temp3(),
                                            $current->get_pm10(),
                                            $current->get_pm25());
        if ($_GET["debug"] >= 1)
            echo "<br />set threeHours(".$row["Time"]."): ".$row["pm10"]." ".$row["pm25"]." ".$row["TEMP"]." ".$row["TEMP2"]." ".$row["Hum"]." ".$row["Dew"];


        $query = "SELECT Date, Time, ROUND(MAX(TEMP),1) TEMP, ROUND(MAX(TEMP2), 1) TEMP2, ROUND(MAX(Hum)) Hum, Dew, Round(MAX(TEMP3),1) TEMP3, Round(MAX(SolarRadiation)) SolarRadiation, Round(MAX(uv), 1) uv, MAX(pm10) pm10, MAX(pm25) pm25 FROM `archivelatest` WHERE Date = DATE(SUBTIME(NOW(), '01:00:00')) AND HOUR(`Time`) = HOUR(SUBTIME(NOW(), '01:00:00')) AND (MINUTE(`Time`) = MINUTE(NOW()) or MINUTE(`Time`) = MINUTE(NOW()) - 1 or MINUTE(`Time`) = MINUTE(NOW()) + 1)";
        $result = mysqli_query($link, $query) ;
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $oneHour->set_pm10($row["pm10"]);
        $oneHour->set_pm10change($current->get_pm10());
        $oneHour->set_pm25($row["pm10"]);
        $oneHour->set_pm25change($current->get_pm25());
        if ($_GET["debug"] >= 1)
            echo "<br />set oneHours(".$row["Time"]."): ".$row["pm10"]." ".$row["pm25"]." ".$row["Hum"]." ".$row["Dew"];

         $query = "SELECT Date, Time, ROUND(MAX(TEMP),1) TEMP, ROUND(MAX(TEMP2), 1) TEMP2, ROUND(MAX(Hum)) Hum, Dew, Round(MAX(TEMP3),1) TEMP3, Round(MAX(SolarRadiation)) SolarRadiation, Round(MAX(uv), 1) uv, MAX(pm10) pm10, MAX(pm25) pm25 FROM `archivelatest` WHERE Date = DATE(SUBTIME(NOW(), '00:30:00')) AND HOUR(`Time`) = HOUR(SUBTIME(NOW(), '00:30:00')) AND (MINUTE(`Time`) = MINUTE(NOW()-30) or MINUTE(`Time`) = MINUTE(NOW()) - 31 or MINUTE(`Time`) = MINUTE(NOW()) - 29)";
        $result = mysqli_query($link, $query) ;
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $min30->set_pm10($row["pm10"]);
        $min30->set_pm10change($current->get_pm10());
        $min30->set_pm25($row["pm10"]);
        $min30->set_pm25change($current->get_pm25());
        if ($_GET["debug"] >= 1)
            echo "<br />set min30(".$row["Time"]."): ".$row["pm10"]." ".$row["pm25"]." ".$row["Hum"]." ".$row["Dew"];

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// reading messages
$detailedforecast = "";
$forecastlevel = "";
$taf_contents = "";
$current_synop_desc = "";
$detailedforecast = $mem->get('descriptionforecast'.$lang_idx);
$latestalert = $mem->get('latestalert'.$lang_idx);
$synop = $mem->get('synop'.$lang_idx);
if ($detailedforecast){
    $_SESSION['detailedforecast'] = $detailedforecast;
    $_SESSION['latestalert'] = $latestalert;
}
else
{
    $result = db_init("SELECT * FROM  `content_sections` WHERE TYPE =  'forecast' and lang=?", $lang_idx);
    while ($line = mysqli_fetch_array($result["result"], MYSQLI_ASSOC)) {
        $detailedforecast = $line["Description"];
        $mem->set('descriptionforecast'.$line["lang"], $line["Description"]);
        $mem->set('descriptionforecasttime'.$line["lang"], strtotime($line["updatedTime"]));
    }
}
if ($latestalert){
    $_SESSION['latestalert'] = $latestalert;
}
else
{
    $result = db_init("SELECT * FROM  `content_sections` WHERE TYPE =  'LAlert' and lang=?", $lang_idx);
    while ($line = mysqli_fetch_array($result["result"], MYSQLI_ASSOC)) {
        $latestalert = $line["Description"];
        $mem->set('latestalert'.$line["lang"], $line["Description"]);
        $mem->set('latestalerttime'.$line["lang"], strtotime($line["updatedTime"]));
    }
}
if ($synop == ""){
     $result = db_init("SELECT * FROM  `content_sections` WHERE TYPE =  'synop' and lang=?", $lang_idx);
    while ($line = mysqli_fetch_array($result["result"], MYSQLI_ASSOC)) {
        $synop = $line["Description"];
        $mem->set('synop'.$line["lang"], $line["Description"]);
    }
}
$detailedforecast = str_replace("\"", "'", $detailedforecast);
$latestalert = str_replace("\"", "'", $latestalert);
$latestalert = "<div id=\"forecasttime\" class=\"invfloat\">"."</div>".$latestalert;
//$detailedforecast = "<div id=\"forecasttime\" class=\"invfloat\">".replaceDays(date('Y-m-d G:i D ', $mem->get('descriptionforecasttime'.$lang_idx)))."</div>".$detailedforecast;

if ($mem->get('taf')){
    $taf_contents = $mem->get('taf');
    if ($_REQUEST["debug"] >= 3)
        echo "<br/>taf taken from cache: ".$taf_contents; 
}
else
{
   
    $result = db_init("SELECT * FROM content_sections WHERE TYPE =  'taf' and lang=?", 0);
    while ($line = mysqli_fetch_array($result["result"], MYSQLI_ASSOC)) {
        if ($line["active"] == 1){
           $taf_contents = $line["Description"];
           $mem->set('taf', $taf_contents);
        }
    }
    if ($_REQUEST["debug"] >= 3)
        echo "<br/>taf taken from DB: ".$taf_contents; 
}

$MainStory = $mem->get('mainstory'.$lang_idx);
if ($MainStory)
    $_SESSION['current_story'] = $MainStory->get_description();
else {
    $query = "call GetCurrentStory";
    $result = mysqli_query($link, $query) or die("Error mysqli_query: ".mysqli_error($link));
    while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        if ($line["lang"] == $lang_idx){
        $_SESSION['current_story'] = $line["Description"];
        $MainStory = new ContentSection();
        $MainStory->set_description($line["Description"]);
        $MainStory->set_img_src($line["img_src"]);
        $MainStory->set_href($line["href"]);
        $MainStory->set_Title($line["Title"]);
        }
    }
    
    $mem->set('mainstory'.$lang_idx, $MainStory);
}



$forecastDaysDB = $mem->get('forecastDaysDB');

if ((!$forecastDaysDB)||(count($forecastDaysDB) == 0))
{
    $results = db_init("SELECT d.active, d.idx, d.lang0, d.lang1, d.TempLow, d.TempLowCloth, d.TempHigh, d.date, d.day_name, d.icon, d.visDay, d.uvmax, d.rainFrom, d.rainTo, d.iconmorning, d.iconnight, d.TempNight, d.TempNightCloth, d.TempHighCloth, d.humMorning, d.humDay, d.humNight, d.dustMorning, d.dustDay, d.dustNight, a.likes, a.dislikes From forecast_days d left join forecast_days_archive a on d.idx = a.idx ORDER BY d.idx", "");
    $forecastDaysDB = array();
    while ($line = $results["result"]->fetch_array(MYSQLI_ASSOC)) {
          
            if ($line["active"] == "1")
             {
                $forecastDaysDB[$line["idx"]] = array('likes' => array(), 
                                                    'dislikes' => array(), 
                                                    'lang0' => urlencode($line["lang0"]), 
                                                    'lang1' => urlencode($line["lang1"]),  
                                                    'TempLow' => $line["TempLow"], 
                                                    'TempHigh' => $line["TempHigh"], 
                                                    'date' => $line["date"], 
                                                    'day_name' => $line["day_name"], 
                                                    'icon' => $line["icon"], 
                                                    'visDay' => $line["visDay"],
                                                    'uvmax' => $line["uvmax"], 
                                                    'rainFrom' => $line["rainFrom"], 
                                                    'rainTo' => $line["rainTo"], 
                                                    'iconmorning' => $line["iconmorning"], 
                                                    'iconnight' => $line["iconnight"], 
                                                    'TempNight' => $line["TempNight"], 
                                                    'TempNightCloth' => $line["TempNightCloth"], 
                                                    'TempLowCloth' => $line["TempLowCloth"], 
                                                    'TempHighCloth' => $line["TempHighCloth"], 
                                                    'humMorning'=>$line["humMorning"], 
                                                    'humDay'=>$line["humDay"], 
                                                    'humNight'=>$line["humNight"], 
                                                    'dustMorning'=>$line["dustMorning"], 
                                                    'dustDay'=>$line["dustDay"], 
                                                    'dustNight'=>$line["dustNight"]);
                for ($i = 0;$i < $line["likes"];$i++)
                {
                    array_push($forecastDaysDB[$line["idx"]]["likes"], $i);
                }
                for ($i = 0;$i < $line["dislikes"];$i++)
                {
                    array_push($forecastDaysDB[$line["idx"]]["dislikes"], $i);
                }
             }
    }
    $mem->set('forecastDaysDB',$forecastDaysDB);
}

 $day_idx = 1;
 $fmonth_l = "";
 foreach ($forecastDaysDB as &$line)  {
     // $todayForecast_date is the previous day from temp forecast
     
    if ($day_idx == 1)
    {
           $todayForecast->set_lowtemp($line["TempLow"], null);
           $todayForecast->set_lowtemp2($line["TempLow"], null);
           $todayForecast->set_hightemp($line["TempHigh"], null);
           $todayForecast->set_hightemp2($line["TempHigh"], null);
           $todayForecast->set_temp_morning($line["TempLow"], null);
           $todayForecast->set_temp_day($line["TempHigh"], null);
           $todayForecast->set_temp_night($line["TempNight"], null);
           $todayForecast->set_hum_morning($line["humMorning"], null);
           $todayForecast->set_hum_day($line["humDay"], null);
           $todayForecast->set_hum_night($line["humNight"], null);
           $todayForecast->set_dust_morning($line["dustMorning"], null);
           $todayForecast->set_dust_day($line["dustDay"], null);
           $todayForecast->set_dust_night($line["dustNight"], null);
           $todayForecast->set_uvmax($line["uvmax"], null);
           $todayForecast->set_rainFrom($line["rainFrom"], null);
           $todayForecast->set_rainTo($line["rainTo"], null);
           $todayForecastShortDate = $line["date"];
           list($firstdayinforecast_l, $fmonth_l) = preg_split('[./-]', $line["date"]);
           list($fday, $fmonth) = explode('/', $firstdayinforecast_l);
           $todayForecast_date = date (DATE_FORMAT, mktime (0, 0, 0, $fmonth, $fday , $year));
           $fyear = $year;
            if ($_REQUEST['debug'] >= 1)
                {
                    echo "<br>date=".$line["date"];
                    echo "<br>fmonth_l=".$fmonth_l;
                    echo "<br>firstdayinforecast_l=".$firstdayinforecast_l;
                    echo "<br>fday=".$fday;
                    echo "<br>fmonth=".$fmonth;
                    echo "<br>fyear=".$fyear;
                    echo "<br>todayForecast_date=".$todayForecast_date."<br>";
                   
                }

    }
    else if ($day_idx == 2)
    {
           $tomorrowForecast->set_lowtemp($line["TempLow"], null);
           $tomorrowForecast->set_lowtemp2($line["TempLow"], null);
           $tomorrowForecast->set_hightemp($line["TempHigh"], null);
           $tomorrowForecast->set_hightemp2($line["TempHigh"], null);
           $tomorrowForecast->set_temp_morning($line["TempLow"], null);
           $tomorrowForecast->set_temp_day($line["TempHigh"], null);
           $tomorrowForecast->set_temp_night($line["TempNight"], null);
           $tomorrowForecast->set_hum_morning($line["humMorning"], null);
           $tomorrowForecast->set_hum_day($line["humDay"], null);
           $tomorrowForecast->set_hum_night($line["humNight"], null);
           $tomorrowForecast->set_dust_morning($line["dustMorning"], null);
           $tomorrowForecast->set_dust_day($line["dustDay"], null);
           $tomorrowForecast->set_dust_night($line["dustNight"], null);
           $tomorrowForecast->set_uvmax($line["uvmax"], null);
           $tomorrowForecast->set_rainFrom($line["rainFrom"], null);
           $tomorrowForecast->set_rainTo($line["rainTo"], null);

    }
    else if ($day_idx == 3)
    {
           $nextTomorrowForecast->set_lowtemp($line["TempLow"], null);
           $nextTomorrowForecast->set_lowtemp2($line["TempLow"], null);
           $nextTomorrowForecast->set_hightemp($line["TempHigh"], null);
           $nextTomorrowForecast->set_hightemp2($line["TempHigh"], null);
           $nextTomorrowForecast->set_temp_morning($line["TempLow"], null);
           $nextTomorrowForecast->set_temp_day($line["TempHigh"], null);
           $nextTomorrowForecast->set_temp_night($line["TempNight"], null);
           $nextTomorrowForecast->set_hum_morning($line["humMorning"], null);
           $nextTomorrowForecast->set_hum_day($line["humDay"], null);
           $nextTomorrowForecast->set_hum_night($line["humNight"], null);
           $nextTomorrowForecast->set_dust_morning($line["dustMorning"], null);
           $nextTomorrowForecast->set_dust_day($line["dustDay"], null);
           $nextTomorrowForecast->set_dust_night($line["dustNight"], null);
           $nextTomorrowForecast->set_uvmax($line["uvmax"], null);
           $nextTomorrowForecast->set_rainFrom($line["rainFrom"], null);
           $nextTomorrowForecast->set_rainTo($line["rainTo"], null);

    }
   $day_idx = $day_idx + 1;
        
 }

 $picname = $mem->get("picOfTheDayName");
 $comment = array($mem->get("picOfTheDaycomment0"), $mem->get("picOfTheDaycomment1"));
 if (!$picname){
    $result = db_init("SELECT * FROM PicOfTheDay order by uploadedAt DESC LIMIT 1","");
    while ($line = $result["result"]->fetch_array(MYSQLI_ASSOC)) { 
        $picname = "images/picOfTheDay/".$line["picname"];
        $comment0 = $line["comment0"];
        $comment1 = $line["comment1"];
        $mem->set("picname", $picname);
        $mem->set("picOfTheDaycomment0", $comment0);
        $mem->set("picOfTheDaycomment1", $comment1);
    }
 }
 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// reading current rain situation 

$daysWithoutRain = date_diff_days($mem->get('lastSentRainStarted'), "now");
$_SESSION['daysWithoutRain'] = $daysWithoutRain;

// take current decade prec and next decade prec
// do (next - current)/10 as one day precipitaion in the current decade
// add ((currentday index number) * (one day precipitaion)) to the current decade
if ($decade < 3)
{
        $nextmonth = $month;
        $nextdecade = $decade + 1;
}
else
{
        if ($month < 12)
                $nextmonth = $month + 1;
        else
                $nextmonth = 1;
        $nextdecade = 1;
}
$dayForPrec = $day - 1;
$idxDayNumber = $dayForPrec - (($decade - 1)*10);
//var_dump ($mem->get('monthAverage'));
$monthAverge = $mem->get('monthAverage');

if ((!$mem->get('monthAverage')) || (($hour == 4)&&($mem->get('updateCacheDay')!=$day))){
    updateCachedVars();
    $mem->set('updateCacheDay', $day);
}

$currentDecadeRain = $mem->get('currentDecadeRain');
$nextDecadeRain = $mem->get('nextDecadeRain');
if ($nextDecadeRain < $currentDecadeRain)
        $nextDecadeRain = $currentDecadeRain;
$oneDayPrec = ($nextDecadeRain - $currentDecadeRain)/10;
$precDelta = $idxDayNumber * $oneDayPrec;

$averageTillNow->set_rain($currentDecadeRain + $precDelta); 
$_SESSION['averageTillNow'] = $averageTillNow;



$seasonTillNow->set_rainydays($mem->get('totalRainyDays'));
$_SESSION['seasonTillNow'] = $seasonTillNow;
if ($_GET['debug'] >= 4){
        echo "<br/> nextDecadeRain=$nextDecadeRain <br/>currentDecadeRain=$currentDecadeRain <br/>idxDayNumber=$idxDayNumber <br/>oneDayPrec=$oneDayPrec <br/>dayForPrec=$dayForPrec <br/>precDelta=$precDelta <br/> rain=$currentDecadeRain + $precDelta<br/>";

}
$timetaf = $mem->get("timetaf");
$dayF = $mem->get("dayF");
$monthF = $mem->get("monthF");
$yearF = $mem->get("yearF");
 $seasonTillNow->set_raindiffav($seasonTillNow->get_rain2() - $averageTillNow->get_rain());
 if ($averageTillNow->get_rain() > 0)
    $seasonTillNow->set_rainperc (round($seasonTillNow->get_rain2()/$averageTillNow->get_rain()*100));
 $thisMonth->set_raindiffav($thisMonth->get_rain() - $monthAverge->get_rain());
 if ($monthAverge->get_rain() > 0)
    $thisMonth->set_rainperc(round($thisMonth->get_rain()/$monthAverge->get_rain()*100));
 $thisMonth->set_rainydaysdiffav($thisMonth->get_rainydays() - $monthAverge->get_rainydays());
 $wholeSeason->set_raindiffav($seasonTillNow->get_rain2() -  $wholeSeason->get_rain());
 $wholeSeason->set_rainydaysdiffav($seasonTillNow->get_rainydays() - $wholeSeason->get_rainydays());
 $wholeSeason->set_rainperc(round ($seasonTillNow->get_rain2()/$wholeSeason->get_rain()*100));
 $hightemp_diffFromAv = $today->get_hightemp() - $monthAverge->get_hightemp();
 $lowtemp_diffFromAv = $today->get_lowtemp() -      $monthAverge->get_lowtemp();
 $highhum_diffFromAv = $today->get_highhum() - $monthAverge->get_highhum();
 $lowhum_diffFromAv = $today->get_lowhum() - $monthAverge->get_lowhum();
 if ($_GET["debug"] >= 1)
    echo " get_rainydays =".$thisMonth->get_rainydays();
 if ($_GET["debug"] >= 1)
	echo "finished</b>";
// Free resultset 
@mysqli_free_result($result);
mysqli_close($link);
?>