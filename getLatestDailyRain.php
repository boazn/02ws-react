<?
ini_set("display_errors","On");
include_once("include.php");
$res = array();
function getLatestDailyRain()
{
    global $RAIN_UNIT, $lang_idx, $res;
    //echo "<table style=\"width:100%;text-align: center\">";
    $result = db_init("call GetLastDaysDailyRain()", "");
    while ($line = $result["result"]->fetch_array(MYSQLI_ASSOC)) {
        //echo "<tr><td class=\"number\">".date("j/m/y", strtotime($line["Date"]))."</td><td><span class=\"big number\">".$line["dailyrain"]." ".$RAIN_UNIT[$lang_idx]."</span></td></tr>";
        array_push($res, array($line["Date"], $line["dailyrain"]));
    }
    //echo "</table>";
}
getLatestDailyRain();
echo json_encode($res);
?>