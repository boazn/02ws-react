 <?
 $month=$_REQUEST['m'];
 $year=$_REQUEST['y'];
 //for ($month = 7 ; $month <= 11 ; $month++){
	 $targetTable= sprintf("ar%d%02d", $year, $month) ;
	 $sourcefile=sprintf("reports/%d-%02d.txt", $year, $month) ;


	 /* Connecting, selecting database */
		$link = mysql_connect("www.02ws.com", "zertwows_boazn", "854456", false, 128);
		//   or print($php_errormsg);
		mysql_select_db("zertwows_02ws");
		//	   or print($php_errormsg);
	 
	  $query2 = "DELETE FROM {$targetTable}";
		 $result = mysql_query($query2); 
			
		if (mysql_affected_rows() < 0) {
			echo "<br>didn't delete rows : ".mysql_error();
		}
		else {
			echo "<br>deleted rows before loading the data: ".mysql_affected_rows()." from ".$targetTable;
		}

	  $query2 = "LOAD DATA LOCAL INFILE '{$sourcefile}' INTO TABLE {$targetTable} FIELDS TERMINATED BY '\t' LINES TERMINATED BY '\r\n' IGNORE 2 LINES";
		 $result = mysql_query($query2); 
			
		if (mysql_affected_rows() <= 0) {
			echo "<br>didn't load data : ".mysql_error();
		}
		else {
			echo "<br>loaded number of rows: ".mysql_affected_rows(). " to ".$targetTable."<br>**************************************";
		}
		 /* Free resultset */
		 //  mysql_free_result($result);
// }//for
    /* Closing connection */
       @mysql_close($link);
	   //(Date,Time,Temp,HiTemp,LowTemp,Hum,Dew,WindSpd,WindDir,WindRun,HiSpeed,HiDir,WindChill,HeatIdx,THW,Bar,Rain,RainRate,HeatDD,CoolDD,InTemp,InHum,WindSamp,WindTx,ISSReception)
?>