<?

ini_set("display_errors","On");
include_once("include.php");
$res = array();
function GetArchivelatest()
{
    global $RAIN_UNIT, $lang_idx, $seasonTillNow, $res;
    echo "ReceiverRecID,ChannelIndex,RecDate,Time,TempOut,HumOut,WindSpeed,HiWindSpeed,DewPoint,IntervalIndex<br />";
    $result = db_init("SELECT * FROM `archivelatest202312` where Date > '2023-12-05' and Date < '2023-12-09' ORDER BY `archivelatest202312`.`Date` DESC", "");
    while ($line = $result["result"]->fetch_array(MYSQLI_ASSOC)) {
		//2,0,2023-12-23 12:32:00,559,559,559,77,0,0,0,255,255,490,560,560,560,1,0.007874016,0,0,0,13,13,211,211,0 
        echo "2,0,".$line["Date"].", ".$line["Time"].", ".$line["Temp"].",".$line["Hum"].",".$line["WindSpd"].",".$line["HiWindSpeed"].",".$line["Dew"].",".$line["WindChill"].",1<br />";
        
    }
    echo "";
}
GetArchivelatest();
//echo json_encode($res);
?>