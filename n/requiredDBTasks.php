<?
//////////////////////////////////////////////
// filling yesterday data - should be reside after panel
//////////////////////////////////////////////
session_start();   
//getting yestarday extremes 
if ($_GET['debug'] >= 1)
	echo "<br /><b>getting yestarday extremes</b><br />";
if ($day > 1)
	$tok = getTokFromFile(FILE_THIS_MONTH); 
else
	$tok = getTokFromFile(FILE_PREV_MONTH);

if (searchNext ($tok, getMinusDayDay(1))){        
	$yest->set_hightemp(getNextWord($tok, 2),getNextWord($tok, 1));//high temp        
	$yest->set_lowtemp(getNextWord($tok, 1),getNextWord($tok, 1));//low temp        
	//print(getNextWord($tok, 1));//high hum        
	//print(getNextWord($tok, 1));//low hum        
	$yest->set_rain (getNextWord($tok, 3),"");//yest rain    
}    
else{        
	$yest->set_hightemp(null, null);$yest->set_lowtemp(null, null);$yest->set_rain(null, null);    
}  

$found = searchNext ($tok, "Rain:");//max rain    
if (searchNext ($tok, "Rain:"))//rainy days   
{
	if ($day > 1)
	{
		$thisMonth->set_rainydays(strtok(" \t"));
	}
	else
	{
		$prevMonth->set_rainydays(strtok(" \t")); 
		if ($today->get_rain() > 0) $thisMonth->set_rainydays(1); else $thisMonth->set_rainydays(0);
	}
}		

// Connecting, selecting database
if ($_GET["debug"] >= 1)
	echo "<b>Stared DBTasks.....";

db_init("");

if ($error_db) {
	 $seasonTillNow->set_raindiffav("MIS"); 
	 $seasonTillNow->set_rainperc ("MIS"); 
	 $hightemp_diffFromAv = "MIS"; 
	 $lowtemp_diffFromAv ="MIS"; 
	 $highhum_diffFromAv="MIS"; 
	 $lowhum_diffFromAv="MIS";
	 $thisMonth->set_raindiffav("MIS");
	 $thisMonth->set_rainperc("MIS");
	 $thisMonth->set_rainydaysdiffav("MIS");
	 $wholeSeason->set_rainperc("MIS");
	 if ($_GET["debug"] >= 1)
		echo "<b>MIS.....Finshed</b>";
	 return;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
/*
 * scheduled tasks
 *
 */
// Update Rainy days and mm on day 
if ($hour == 6) {
	if ($day == 1)
	{
		$prevMonth->set_rain(getPrevMonthRain());
		$rdays = $prevMonth->get_rainydays();$mm = $prevMonth->get_rain();$month_to_update = getPrevMonth($month);$year_to_update = getPrevMonthYear($month, $year);
	}
	else
	{
		$rdays = $thisMonth->get_rainydays();$mm = $thisMonth->get_rain();$month_to_update = $month;$year_to_update = $year;
	}
 $query = "UPDATE rainseason SET RainyDays=$rdays, mm=$mm WHERE ((month=$month_to_update) and (Year=$year_to_update))";
 $result = mysqli_query($link, $query); 
  //or print($php_errormsg);
}
//loaddata once every day
/*
if (($hour <= 5)&&($hour >= 1)) {
$query = "SELECT * From DoOnceCheckList where Action='LoadArchiveData'";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
if ($row["Today"] != $datenotime){
	if ($day == 1)
		$targetTable = sprintf("ar%04d%02d", $year, getMinusDayMonth(1));
	else
		$targetTable = sprintf("ar%04d%02d", $year, $month);
	$ignoreLines = 3;
	$sourcefile = FILE_ARCHIVE;
	$query2 = "LOAD DATA LOCAL INFILE '{$sourcefile}' REPLACE INTO TABLE {$targetTable} FIELDS TERMINATED BY ' ' LINES TERMINATED BY '\r\n' IGNORE {$ignoreLines} LINES";
	$result = mysqli_query($link, $query2); 
	$query = "UPDATE DoOnceCheckList SET Today='$datenotime' where Action='LoadArchiveData'";
	$result = mysqli_query($link, $query);
}
}*/
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
	$query = "UPDATE globalwarming SET anomaly=$yearlyAnomaly where year=$year";
	$result = mysqli_query($link, $query);
  }	

  //or print($php_errormsg);
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// reading messages
$detailedforecast = "";
$forecastlevel = "";
$taf_contents = "";
$startup = "";
//if (!isset($_SESSION['detailedforecast'])) {
	$query = "SELECT * FROM messages where (type='forecast' and lang='{$lang_idx}')";
	$result = mysqli_query($link, $query) ;
	//      or print($php_errormsg);
	$row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
	$forecastlevel = $row["active"];
	if ($row["active"] > 0)
		$detailedforecast = $row["Description"];
	$detailedforecast = str_replace("\"", "'", $detailedforecast);
	$detailedforecast = replaceDays(getLocalTime(strtotime($row["updatedTime"])))."<br/>".$detailedforecast;
	$_SESSION['detailedforecast'] = $detailedforecast;
//}
//else
//	$detailedforecast = $_SESSION['detailedforecast'];

if (!isset($_SESSION['startup'])) {
	$query = "SELECT * FROM messages where (type='startup' and lang='{$lang_idx}')";
	$result = mysqli_query($link, $query) ;
	//      or print($php_errormsg);
	$row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
	if ($row["active"] > 0)
		$startup = $row["Description"]; 
	$_SESSION['startup'] = $startup;
}
else
	$startup = $_SESSION['startup'];

//if (!isset($_SESSION['taf_contents'])) {
	$query = "SELECT * FROM messages where (type='taf' and lang='{$lang_idx}')";
	$result = mysqli_query($link, $query) ;
	//      or print($php_errormsg);
	$row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
	if ($row["active"] > 0)
		$taf_contents = $row["Description"];
	$_SESSION['taf_contents'] = $taf_contents;
//}
//else
//	$taf_contents = $_SESSION['taf_contents'];

//if (!isset($_SESSION['current_story'])) {
	$query = "SELECT * FROM mainstory where (lang='{$lang_idx}') order by Idx Desc limit 1";
	$result = mysqli_query($link, $query) ;
	//      or print($php_errormsg);
	$row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
	if ($row["active"] > 0)
	{
		$current_story = $row["Description"];
		$current_story_img_src = $row["img_src"];
		$current_story_href = $row["href"];
		$current_story_title = $row["Title"];
	}
	$_SESSION['current_story'] = $current_story;
//}
//else
//	$taf_contents = $_SESSION['taf_contents'];

$forecastDaysDB = array();
//if (!isset($_SESSION['forecastDaysDB'])) {
	$query = "SELECT * FROM forecast ORDER BY day";
	$result = mysqli_query($link, $query) ;
	//      or print($php_errormsg);
        $day_idx = 1;
	 while ($line = mysqli_fetch_array($result, MYSQL_ASSOC)) {
		 if ($line["active"] == "1")
		 {
			array_push($forecastDaysDB, array('lang0' => urlencode($line["lang0"]), 'lang1' => urlencode($line["lang1"]),  'TempLow' => $line["TempLow"], 'TempHigh' => $line["TempHigh"], 'date' => $line["date"], 'day_name' => $line["day_name"], 'icon' => $line["icon"], 'TempNight' => $line["TempNight"], 'TempNightCloth' => $line["TempNightCloth"], 'TempHighCloth' => $line["TempHighCloth"]));
			
                                                
                         // $todayForecast_date is the previous day from temp forecast
			 if ($day_idx == 1)
			 {
				$todayForecast->set_lowtemp($line["TempLow"], null);
				$todayForecast->set_hightemp($line["TempHigh"], null);
				$todayForecast->set_temp_morning($line["TempLow"], null);
				$todayForecast->set_temp_day($line["TempHigh"], null);
				$todayForecast->set_temp_night($line["TempNight"], null);
				$todayForecastShortDate = $line["date"];
				list($fday_l, $fmonth_l) = split('[/.-]', $line["date"]);
                list($fday, $fmonth, $fyear) = split('[/.-]', $todayForecast_date); 
                                
			 }
			 else if ($day_idx == 2)
			 {
				$tomorrowForecast->set_lowtemp($line["TempLow"], null);
				$tomorrowForecast->set_hightemp($line["TempHigh"], null);
				$tomorrowForecast->set_temp_morning($line["TempLow"], null);
				$tomorrowForecast->set_temp_day($line["TempHigh"], null);
				$tomorrowForecast->set_temp_night($line["TempNight"], null);
				
			 }
			$day_idx = $day_idx + 1;
		 }
		}
	 //print_r($forecastDaysDB);
//	$_SESSION['forecastDaysDB'] = $forecastDaysDB;
//}
//else
//	$forecastDaysDB = $_SESSION['forecastDaysDB'];

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// reading current rain situation 
if (!isset($_SESSION['daysWithoutRain'])) {
	$query = "SELECT  lastSent FROM sendmailsms  where (Action='RainStarted') ";
	$result = mysqli_query($link, $query) ;
	//      or print($php_errormsg);
	$row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
	$lastSent = $row["lastSent"];
	$daysWithoutRain = date_diff_days($lastSent, "now");
	//echo $daysWithoutRain;
	$_SESSION['daysWithoutRain'] = $daysWithoutRain;
}
else
	$daysWithoutRain = $_SESSION['daysWithoutRain'];


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
	
	$query = "SELECT AccRain FROM raindailyaverage where ((month=$month) and (decade=$decade))";
	$result = mysqli_query($link, $query) ;
	$row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
	$currentDecadeRain = $row["AccRain"];

	$query = "SELECT AccRain FROM raindailyaverage where ((month=$nextmonth) and (decade=$nextdecade))";
	$result = mysqli_query($link, $query) ;
	$row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
	$nextDecadeRain = $row["AccRain"];
	if ($nextDecadeRain < $currentDecadeRain)
		$nextDecadeRain = $currentDecadeRain;
	$oneDayPrec = ($nextDecadeRain - $currentDecadeRain)/10;
	$precDelta = $idxDayNumber * $oneDayPrec;
	if ($_GET['debug'] >= 4)
		echo "<br/> nextDecadeRain=$nextDecadeRain <br/>currentDecadeRain=$currentDecadeRain <br/>idxDayNumber=$idxDayNumber <br/>oneDayPrec=$oneDayPrec <br/>dayForPrec=$dayForPrec <br/>precDelta=$precDelta <br/> rain=$currentDecadeRain + $precDelta<br/>";
	$averageTillNow->set_rain($currentDecadeRain + $precDelta); 
	$_SESSION['averageTillNow'] = $averageTillNow;

$monthAverge = new TimeRange();

	// reading this month's average 
	$query = "SELECT * FROM average where (month=$month) ";
	$result = mysqli_query($link, $query) ;
	//   or print($php_errormsg);
	$row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
	$monthAverge->set_hightemp ($row["HighTemp"],"");
	$monthAverge->set_lowtemp ($row["LowTemp"],"");
	$monthAverge->set_highhum ($row["HighHum"],"");
	$monthAverge->set_lowhum ($row["LowHum"],"");
	$monthAverge->set_rain($row["Rain"]);
	$monthAverge->set_rainydays($row["RainyDays"]);
        $monthAverge->set_abshightemp($row["AbsHighTemp"]);
        $monthAverge->set_abslowtemp($row["AbsLowTemp"]);
        $monthAverge->set_absmaxrain($row["AbsMaxRain"]);
        $monthAverge->set_absminrain($row["AbsMinRain"]);
	$_SESSION['monthAverge'] = $monthAverge; 

// calculating current rainy days  accumulation

	$query = "SELECT SUM(RainyDays) FROM rainseason where (season='$current_season') ";
	$result = mysqli_query($link, $query) ;
	//   or print($php_errormsg);
	$row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
	 //need to know if today is rainy and the hour is before 23 --> add 1 to the sum
	$seasonTillNow->set_rainydays($row["SUM(RainyDays)"]);
	$_SESSION['seasonTillNow'] = $seasonTillNow;


 $seasonTillNow->set_raindiffav($seasonTillNow->get_rain() - $averageTillNow->get_rain());
 @$seasonTillNow->set_rainperc (round($seasonTillNow->get_rain()/$averageTillNow->get_rain()*100));
 $thisMonth->set_raindiffav($thisMonth->get_rain() - $monthAverge->get_rain());
 @$thisMonth->set_rainperc(round($thisMonth->get_rain()/$monthAverge->get_rain()*100));
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