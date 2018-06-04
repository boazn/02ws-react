<?
//////////////////////////////////////////////
// filling yesterday data - should be reside after panel
//////////////////////////////////////////////
 
$monthAverge = new TimeRange();
$MainStory = New ContentSection();
//ini_set("display_errors","On");
//ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE);
//getting yestarday extremes 
function updateCachedVars(){
    global $month, $decade, $nextmonth, $nextdecade, $current_season, $monthAverge, $link;
    $query = "SELECT AccRain FROM raindailyaverage where ((month=$month) and (decade=$decade))";
    $result = mysqli_query($link, $query) ;
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    apc_store('currentDecadeRain', $row["AccRain"]);
    
    $query = "SELECT AccRain FROM raindailyaverage where ((month=$nextmonth) and (decade=$nextdecade))";
    $result = mysqli_query($link, $query) ;
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    apc_store('nextDecadeRain', $row["AccRain"]);
    
    // calculating current rainy days  accumulation
    $query = "SELECT SUM(RainyDays) FROM rainseason where (season='$current_season') ";
    $result = mysqli_query($link, $query) ;
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
     //need to know if today is rainy and the hour is before 23 --> add 1 to the sum
    apc_store('totalRainyDays', $row["SUM(RainyDays)"]);
    
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
    $monthAverge->set_abshightemp($row["AbsHighTemp"]);
    $monthAverge->set_abslowtemp($row["AbsLowTemp"]);
    $monthAverge->set_absmaxrain($row["AbsMaxRain"]);
    $monthAverge->set_absminrain($row["AbsMinRain"]);
    apc_store('monthAverage', $monthAverge);
    
    $query = "SELECT  lastSent FROM sendmailsms  where (Action='RainStarted') ";
    $result = mysqli_query($link, $query) ;
    $row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
    apc_store('lastSentRainStarted', $row["lastSent"]);
    
    
    $query = "SELECT avg(anomaly) FROM globalwarming";
    $result = mysqli_query($link, $query) ;
    $row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
    apc_store('avganomaly', $row['avg(anomaly)']);
    return true;
}
if ($_GET['debug'] >= 1)
	echo "<br /><b>getting yestarday extremes</b><br />";

$yest->set_temp_morning(apcu_fetch(YEST_MORNING_TEMP), null);
$yest->set_temp_day(apcu_fetch(YEST_NOON_TEMP), null);
$yest->set_temp_night(apcu_fetch(YEST_NIGHT_TEMP), null);
$today->set_temp_morning(apcu_fetch(TODAY_MORNING_TEMP), null);
$today->set_temp_day(apcu_fetch(TODAY_NOON_TEMP), null);


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
$thisMonth->set_rainydays(apcu_fetch(THIS_MONTH_RAINY_DAYS));
$prevMonth->set_rainydays(apcu_fetch(PREV_MONTH_RAINY_DAYS));
	try{
if (($hour == 2)&&($min<10)) {
    $tok = ($day > 1) ? getTokFromFile(FILE_THIS_MONTH) : getTokFromFile(FILE_PREV_MONTH);

    $found = searchNext ($tok, "Rain:");//max rain 
    if (searchNext ($tok, "Rain:"))//rainy days   
    {
        if ($day == 1)
        {
            $rdays = strtok(" \t");
            apcu_store(PREV_MONTH_RAINY_DAYS, $rdays);
            $prevMonth->set_rainydays($rdays); 
            $mrdays = ($today->get_rain() > 0) ? 1 : 0;
            $thisMonth->set_rainydays($mrdays);
            apcu_store(THIS_MONTH_RAINY_DAYS, $mrdays);    
            $prevMonth->set_rain(getPrevMonthRain());
            $mm = $prevMonth->get_rain();$month_to_update = getPrevMonth($month);$year_to_update = getPrevMonthYear($month, $year);
        }
        else
        {
            $rdays = strtok(" \t");
            apcu_store(THIS_MONTH_RAINY_DAYS, $rdays);
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
    logger("set_rainydays:".$e->getMessage());
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
		$yearlyAnomaly = getNextWord($tok, 4);
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
    $query = "SELECT Date, Time, ROUND(MAX(TEMP),1) TEMP, ROUND(MAX(TEMP2), 1) TEMP2, ROUND(MAX(Hum)) Hum, Round(MAX(Dew),1) Dew, Round(MAX(TEMP3),1) TEMP3, Round(MAX(SolarRadiation)) SolarRadiation, Round(MAX(uv), 1) uv FROM `archivelatest` WHERE Date = DATE_ADD(CURDATE(), INTERVAL -1 DAY) AND HOUR(`Time`) = HOUR(NOW()) AND (MINUTE(`Time`) = MINUTE(NOW()) or MINUTE(`Time`) = MINUTE(NOW()) - 1 or MINUTE(`Time`) = MINUTE(NOW()) + 1)";
        $result = mysqli_query($link, $query) ;
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $yestsametime->set_temp( $row["TEMP"]);
	$yestsametime->set_temp2 ($row["TEMP2"]);
	$yestsametime->set_hum ($row["Hum"]);
	$yestsametime->set_dew ($row["Dew"]);
	$yestsametime->set_solarradiation ($row["SolarRadiation"]);
	$yestsametime->set_uv($row["uv"]);
        $yestsametime->set_temp3($row["TEMP3"]);
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
                                            $current->get_temp3());
        if ($_GET["debug"] >= 1)
            echo "<br />set yestsametime:".$row["TEMP"]." ".$row["TEMP2"]." ".$row["Hum"]." ".$row["Dew"];
        
     $query = "SELECT Date, Time, ROUND(MAX(TEMP),1) TEMP, ROUND(MAX(TEMP2), 1) TEMP2, ROUND(MAX(Hum)) Hum, Dew, Round(MAX(TEMP3),1) TEMP3, Round(MAX(SolarRadiation)) SolarRadiation, Round(MAX(uv), 1) uv FROM `archivelatest` WHERE Date = DATE(SUBTIME(NOW(), '03:00:00')) AND HOUR(`Time`) = HOUR(SUBTIME(NOW(), '03:00:00')) AND (MINUTE(`Time`) = MINUTE(NOW()) or MINUTE(`Time`) = MINUTE(NOW()) - 1 or MINUTE(`Time`) = MINUTE(NOW()) + 1)";
        $result = mysqli_query($link, $query) ;
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $threeHours->set_temp( $row["TEMP"]);
	$threeHours->set_temp2 ($row["TEMP2"]);
	$threeHours->set_hum ($row["Hum"]);
	$threeHours->set_dew ($row["Dew"]);
	$threeHours->set_solarradiation ($row["SolarRadiation"]);
	$threeHours->set_uv($row["uv"]);
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
                                            $current->get_temp3());
        if ($_GET["debug"] >= 1)
            echo "<br />set threeHours:".$row["TEMP"]." ".$row["TEMP2"]." ".$row["Hum"]." ".$row["Dew"];

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// reading messages
$detailedforecast = "";
$forecastlevel = "";
$taf_contents = "";
$detailedforecast = apc_fetch('descriptionforecast'.$lang_idx);

if ($detailedforecast){
	$_SESSION['detailedforecast'] = $detailedforecast;
}
else
{
    $result = db_init("SELECT * FROM  `content_sections` WHERE TYPE =  'forecast' and lang=?", $lang_idx);
    while ($line = mysqli_fetch_array($result["result"], MYSQLI_ASSOC)) {
        $detailedforecast = $line["Description"];
        apc_store('descriptionforecast'.$line["lang"], $line["Description"]);
        apc_store('descriptionforecasttime'.$line["lang"], $line["updatedTime"]);
    }
}
$detailedforecast = str_replace("\"", "'", $detailedforecast);
$detailedforecast = "<div id=\"forecasttime\" class=\"invfloat\">".replaceDays(getLocalTime(strtotime(apc_fetch('descriptionforecasttime'.$lang_idx))))."</div>".$detailedforecast;

if (apc_fetch('taf'))
   $taf_contents = apc_fetch('taf');
if ($taf_contents)
    $_SESSION['taf_contents'] = $taf_contents;
else
{
    $result = db_init("SELECT * FROM content_sections WHERE TYPE =  'taf' and lang=?", 0);
    while ($line = mysqli_fetch_array($result["result"], MYSQLI_ASSOC)) {
        if ($line["active"] == 1){
           $taf_contents = $line["Description"];
           apc_store('taf', $taf_contents);
        }
    }
}

$MainStory = apc_fetch('mainstory'.$lang_idx);
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
    
    apc_store('mainstory'.$lang_idx, $MainStory);
}


$forecastDaysDB = apc_fetch('forecastDaysDB');

if ((!$forecastDaysDB)||(count($forecastDaysDB) == 0))
{
    $results = db_init("SELECT d.active, d.idx, d.lang0, d.lang1, d.TempLow, d.TempHigh, d.date, d.day_name, d.icon, d.TempNight, d.TempNightCloth, d.TempHighCloth, d.humMorning, d.humDay, d.humNight, a.likes, a.dislikes From forecast_days d left join forecast_days_archive a on d.idx = a.idx ORDER BY d.idx", "");
    $forecastDaysDB = array();
    while ($line = $results["result"]->fetch_array(MYSQLI_ASSOC)) {
          
            if ($line["active"] == "1")
             {
                $forecastDaysDB[$line["idx"]] = array('likes' => array(), 'dislikes' => array(), 'lang0' => urlencode($line["lang0"]), 'lang1' => urlencode($line["lang1"]),  'TempLow' => $line["TempLow"], 'TempHigh' => $line["TempHigh"], 'date' => $line["date"], 'day_name' => $line["day_name"], 'icon' => $line["icon"], 'TempNight' => $line["TempNight"], 'TempNightCloth' => $line["TempNightCloth"], 'TempHighCloth' => $line["TempHighCloth"], 'humMorning'=>$line["humMorning"], 'humDay'=>$line["humDay"], 'humNight'=>$line["humNight"]);
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
    apc_store('forecastDaysDB',$forecastDaysDB);
}

 $day_idx = 1;
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
           $todayForecastShortDate = $line["date"];
           list($fday_l, $fmonth_l) = preg_split('[/.-]', $line["date"]);
            list($fday, $fmonth, $fyear) = preg_split('[/.-]', $todayForecast_date); 

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

    }
   $day_idx = $day_idx + 1;
        
 }
	 

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// reading current rain situation 

$daysWithoutRain = date_diff_days(apc_fetch('lastSentRainStarted'), "now");
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
//var_dump (apc_fetch('monthAverage'));
if ((!apc_fetch('currentDecadeRain')) || (!apc_fetch('monthAverage')) || ($hour == 4)){
    updateCachedVars();
}

$currentDecadeRain = apc_fetch('currentDecadeRain');
$nextDecadeRain = apc_fetch('nextDecadeRain');
if ($nextDecadeRain < $currentDecadeRain)
        $nextDecadeRain = $currentDecadeRain;
$oneDayPrec = ($nextDecadeRain - $currentDecadeRain)/10;
$precDelta = $idxDayNumber * $oneDayPrec;

$averageTillNow->set_rain($currentDecadeRain + $precDelta); 
$_SESSION['averageTillNow'] = $averageTillNow;

$monthAverge = apc_fetch('monthAverage');

$seasonTillNow->set_rainydays(apc_fetch('totalRainyDays'));
$_SESSION['seasonTillNow'] = $seasonTillNow;
if ($_GET['debug'] >= 4){
        echo "<br/> nextDecadeRain=$nextDecadeRain <br/>currentDecadeRain=$currentDecadeRain <br/>idxDayNumber=$idxDayNumber <br/>oneDayPrec=$oneDayPrec <br/>dayForPrec=$dayForPrec <br/>precDelta=$precDelta <br/> rain=$currentDecadeRain + $precDelta<br/>";

}
$timetaf = apc_fetch("timetaf");
$dayF = apc_fetch("dayF");
$monthF = apc_fetch("monthF");
$yearF = apc_fetch("yearF");
 $seasonTillNow->set_raindiffav($seasonTillNow->get_rain() - $averageTillNow->get_rain());
 if ($averageTillNow->get_rain() > 0)
    $seasonTillNow->set_rainperc (round($seasonTillNow->get_rain()/$averageTillNow->get_rain()*100));
 $thisMonth->set_raindiffav($thisMonth->get_rain() - $monthAverge->get_rain());
 if ($monthAverge->get_rain() > 0)
    $thisMonth->set_rainperc(round($thisMonth->get_rain()/$monthAverge->get_rain()*100));
 $thisMonth->set_rainydaysdiffav($thisMonth->get_rainydays() - $monthAverge->get_rainydays());
 $wholeSeason->set_raindiffav($seasonTillNow->get_rain() -  $wholeSeason->get_rain());
 $wholeSeason->set_rainydaysdiffav($seasonTillNow->get_rainydays() - $wholeSeason->get_rainydays());
 $wholeSeason->set_rainperc(round ($seasonTillNow->get_rain()/$wholeSeason->get_rain()*100));
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