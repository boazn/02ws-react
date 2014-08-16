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
 $SITE['cvalues'] = array("date","Rain");
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
	 echo "t is missing";
	 exit;
 }
  if ($nameOfParam == "")
 {
	 echo "p is missing";
	 exit;
 }
  if ($sourcefile == "")
 {
	 echo "f is missing";
	 exit;
 }

foreach($rawdata as $key) {
	$DATA = preg_split($key_split, $key);
	//echo ret_value("date")."B".ret_value("HiTemp")."B".ret_value("LowTemp");
	//echo "<br />";
	if (ret_value("date") != "date")
	{
	$value = ret_value($nameOfParam);
	$date = ret_value("date");
	if ($insertOrUpdate == "I")
				 echo "insert into `archivemin`  ( `Date` , `".$nameOfParam."` ) VALUES ('".$date."' , ".$value.");<br>";
				else if ($insertOrUpdate == "U")
				 echo ("update `archivemin`  set `".$nameOfParam."`=$value  where `Date`='$date';<br>");
                                else
				  echo "insert or update?";
	}
}




//echo "end<br />";
?>