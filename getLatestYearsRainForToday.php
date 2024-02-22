<?

ini_set("display_errors","On");
include_once("include.php");
$res = array();
function GetLatestYearsRainForToday()
{
    global $RAIN_UNIT, $lang_idx, $seasonTillNow, $res;
   // echo "<table style=\"width:100%;text-align: center\">";
    $result = db_init("call GetLatestYearsRainForToday()", "");
    while ($line = $result["result"]->fetch_array(MYSQLI_ASSOC)) {
		 if ($line["rain"] > $seasonTillNow->get_rain2()) $diff_rain = "less"; else $diff_rain = "more";
     //   echo "<tr><td class=\"number\">".$line["dateAsToday"]."</td><td><span class=\"big number ".$diff_rain."\">".$line["rain"]." ".$RAIN_UNIT[$lang_idx]."</span></td></tr>";
        array_push($res, array($line["dateAsToday"], $line["rain"]));
    }
   // echo "</table>";
}
GetLatestYearsRainForToday();
echo json_encode($res);
?>