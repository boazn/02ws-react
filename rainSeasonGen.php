<?
include ("include.php");
ini_set('display_errors', 'on' );
error_reporting(E_ERROR | E_WARNING | E_PARSE);

 $file=$_REQUEST['f'];
 /*if (stristr($file,"TX"))
   $nameOfParam = "HiTemp";
   else if (stristr($file,"TN"))
   $nameOfParam = "LowTemp";
   else if (stristr($file,"RR"))
   $nameOfParam = "Rain";
   else
   {
   	print "no valid parameter";
   	exit;
   }*/
 $nameOfParam = $_REQUEST['p'];
 $insertOrUpdate = $_REQUEST['t'];
 $sourcefile = sprintf('reports/%s', $file) ;
 //////////////////////////////////////
 //
 // change that according to file
 //
 //
 $SITE['cvalues'] = array("station","monthyear", "raintotal", "raincodemonthly","rainydays", "rainydayscode", "dailyrainmax","dailyrainmaxcode");
 $key_split = "/,+/";
 function ret_value($lookup) {
	global $SITE, $DATA;
	
	$rtn = array_search  ( $lookup  , $SITE['cvalues'] );
	
	if ($rtn !== FALSE) {
		return( $DATA[$rtn] );
	} else {
		return("'-'");
	}
}
 $rawdata = file( $sourcefile);
 //$sourcefile="reports/TX.txt";
 if ($insertOrUpdate == "")
 {
	 echo "t is missing (I or U)";
	 exit;
 }
  if ($nameOfParam == "")
 {
	 echo "p is missing (e.g. HiTemp or LowTemp or Rain)";
	 exit;
 }
  if ($file == "")
 {
	 echo "f is missing (e.g. IMS_DATA)";
	 exit;
 }
function getSeason($year, $month)
{
	//return $month;
	
	if (intval($month) < 9)
		return sprintf("%04d-%04d", (intval(trim($year))-1), $year);
	else
		return sprintf("%04d-%04d", $year, (intval(trim($year))+1));
}
foreach($rawdata as $key) {
	$DATA = preg_split($key_split, $key);
	//echo ret_value("date")."B".ret_value("HiTemp")."B".ret_value("LowTemp");
	//echo "<br />";
	if (ret_value("date") != "date")
	{
	$value = ret_value($nameOfParam);
	$date = ret_value("date");
	$date = str_replace('/', '-', $date);
	$date = date("Y-m-d", strtotime($date) );
	$year = explode("-", ret_value("monthyear"))[1];
	$month = explode("-", ret_value("monthyear"))[0];
	$season = getSeason($year, $month);
	 echo "insert into `rainseason`  ( `season` , `Year`, `month`, `mm`, `RainyDays`, `Station`, `MaxDaymm` ) VALUES ('".$season."' , ".$year.", ".$month.", ".ret_value("raintotal").", ".ret_value("rainydays").", ".ret_value("station").", ".ret_value("dailyrainmax").");<br>";
				
	}
}




//echo "end<br />";
?>