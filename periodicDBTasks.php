<?
//////////////////////////////////////////////
// filling cached data - should be run every min
//////////////////////////////////////////////
 

//ini_set("display_errors","On");
//ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE);
//getting yestarday extremes 
function updatePeriodicCachedVars(){
    global $link, $yestsametime;
    
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
	//logger( "<br/>stored ".$row["TEMP"]." ".$row["TEMP2"].$row["Hum"]." ".$row["Dew"]." ".$row["SolarRadiation"]." "." in YestSameTime");

        $query = "SELECT ROUND(MIN(TEMP2), 1) temp FROM `archivelatest` WHERE `Date` = DATE_ADD(CURDATE(), INTERVAL -1 DAY) and Time BETWEEN '05:00:00' AND '08:00:00'";
    $result = mysqli_query($link, $query) ;
    $line = mysqli_fetch_array($result);
    apcu_store(YEST_MORNING_TEMP, $line["temp"]);
    if ($_GET['debug'] >= 1){
        echo( "<br/>stored ".$line["temp"]." in YestMorningTemp");
        print_r($line);
    }
    @mysqli_free_result($result);
	
	$query = "SELECT ROUND(AVG(TEMP2), 1) temp FROM `archivelatest` WHERE `Date` = DATE_ADD(CURDATE(), INTERVAL -1 DAY) and Time BETWEEN '19:00:00' AND '22:00:00'";
    $result = mysqli_query($link, $query) ;
    $row = mysqli_fetch_array($result);
    apcu_store(YEST_NIGHT_TEMP, $row[0]);
    if ($_GET['debug'] >= 1)
        echo ( "<br/>stored ".$row[0]." in YestNightTemp");

    @mysqli_free_result($result);
    

	$query = "SELECT ROUND(MAX(TEMP2), 1) temp FROM `archivelatest` WHERE `Date` = DATE_ADD(CURDATE(), INTERVAL -1 DAY) and Time BETWEEN '12:00:00' AND '15:00:00'";
    $result = mysqli_query($link, $query) ;
    $line = mysqli_fetch_array($result, MYSQLI_ASSOC);
    apcu_store(YEST_NOON_TEMP, $line["temp"]);
    if ($_GET['debug'] >= 1)
	echo( "<br/>stored ".$line["temp"]." in YestNoonTemp");
    @mysqli_free_result($result);

	$query = "SELECT ROUND(AVG(TEMP2), 1) temp FROM `archivelatest` WHERE `Date` = CURDATE()  and Time BETWEEN '19:00:00' AND '22:00:00'";
    $result = mysqli_query($link, $query) ;
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    apcu_store(TODAY_NIGHT_TEMP, $row["temp"]);
    if ($_GET['debug'] >= 1)
	echo( "<br/>stored ".$row["temp"]." in TodayNightTemp");
    
    $query = "SELECT ROUND(MIN(TEMP2), 1) temp FROM `archivelatest` WHERE `Date` = CURDATE()  and Time BETWEEN '05:00:00' AND '08:00:00'";
    $result = mysqli_query($link, $query) ;
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    apcu_store(TODAY_MORNING_TEMP, $row["temp"]);
    if ($_GET['debug'] >= 1)
	echo( "<br/>stored ".$row["temp"]." in TodayMorningTemp");

	$query = "SELECT ROUND(MAX(TEMP2), 1) temp FROM `archivelatest` WHERE `Date` = CURDATE()  and Time BETWEEN '12:00:00' AND '15:00:00'";
    $result = mysqli_query($link, $query) ;
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    apcu_store(TODAY_NOON_TEMP, $row["temp"]);
    if ($_GET['debug'] >= 1)
	echo( "<br/>stored ".$row["temp"]." in TodayNoonTemp");

	$query = "SELECT count(*) minutes FROM `archivelatest` WHERE `Date` = CURDATE() and `SolarRadiation` > 310";
    $result = mysqli_query($link, $query) ;
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    apcu_store(SUNSHINE_HOURS, round($row["minutes"]/60, 1));
    if ($_GET['debug'] >= 1)
	echo( "<br/>stored ".round($row["minutes"]/60)." in SunshineHours");
    
    $query = "SELECT MAX(`Rain`) dailyrain, Date FROM `archivelatest` group by Date Order by Date Desc";
    $last7daysDailyRain = array();
    $result = mysqli_query($link, $query) ;
    while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        array_push($last7daysDailyRain, array("DailyRain" => $line["dailyrain"], "Date" => $line["Date"]));
    }    
    apcu_store(LAST_7DAYS_DAILY_RAIN, $last7daysDailyRain);
    return true;
}
db_init("", "");
updatePeriodicCachedVars();
@mysqli_free_result($result);
mysqli_close($link);
?>