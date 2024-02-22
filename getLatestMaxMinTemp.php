<?

ini_set("display_errors","On");
include_once("include.php");

$res = array();
function getLatestMaxMinTemp(){
	global $lang_idx, $res;
	$query = "call getLatestMaxMinTemp()";
	$result = db_init($query, "");
	//echo "<table style=\"width:100%;text-align: center\">";
	while ($line = $result["result"]->fetch_array(MYSQLI_ASSOC)) {
       // echo "<tr class=\"inv_plain_2\"><td class=\"number\">".date("j/m/y", strtotime($line["Date"]))."</td><td style=\"text-align:center\"><span class=\"big number\">".$line["maxtemp2"]."</span></td><td style=\"text-align:center\"><span class=\"big number\">".$line["mintemp2"]."</span></td></tr>";
        array_push($res, array($line["Date"], $line["mintemp2"], $line["maxtemp2"] ));
		
    }
	//echo "</table>";
	
}
getLatestMaxMinTemp();
//var_dump($res );
echo json_encode($res);
?>