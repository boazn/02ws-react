
<?

include_once("lang.php");
include_once("ini.php");
include_once("include.php"); 


for ($month = 1 ; $month <= 12 ; $month++){
	 

		for ($year = 1920 ; $year <= 2000 ; $year++){
	 /* Connecting, selecting database */
		$link = @mysql_connect(MYSQL_IP, MYSQL_USER, MYSQL_PASS) or $error_db = true;
		//   or print($php_errormsg);
		mysql_select_db("zertwows_02ws");
		//	   or print($php_errormsg);
	 
		$sql = sprintf("CREATE TABLE IF NOT EXISTS `ar%d%02dmin` (\n"
    . " `Date` text,\n"
    . " `Temp` float DEFAULT NULL,\n"
    . " `HiTemp` float DEFAULT NULL,\n"
    . " `LowTemp` float DEFAULT NULL,\n"
    . " `Hum` smallint(6) DEFAULT NULL,\n"
    . " `HiSpeed` float DEFAULT NULL,\n"
    . " `HiDir` text,\n"
    . " `Rain` float DEFAULT NULL,\n"
    . " `RainRate` float DEFAULT NULL\n"
    . ") ENGINE=MyISAM DEFAULT CHARSET=latin1;",$year, $month );
	  
		 $result = mysql_query($sql); 
			
	 
	
		}
	echo $year."...";		
 }//for
	 /* Free resultset */
	mysql_free_result($result);
    /* Closing connection */
       @mysql_close($link);
	   echo "done.";