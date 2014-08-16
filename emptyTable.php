 <?
 $targetTable="ar200310";

 /* Connecting, selecting database */
	$link = mysql_connect("62.128.42.9", "boaz", "854456", false, 128);
    //   or print($php_errormsg);
    mysql_select_db("boaz");
	//	   or print($php_errormsg);
 
 
  $query2 = "DELETE FROM {$targetTable}";
	 $result = mysql_query($query2); 
		
	if (mysql_affected_rows() <= 0) {
		echo "didn't make it : ".mysql_error();
	}
	else {
	    echo mysql_affected_rows();
	}
	 /* Free resultset */
	 //  mysql_free_result($result);
	
    /* Closing connection */
       @mysql_close($link);
	   //(Date,Time,Temp,HiTemp,LowTemp,Hum,Dew,WindSpd,WindDir,WindRun,HiSpeed,HiDir,WindChill,HeatIdx,THW,Bar,Rain,RainRate,HeatDD,CoolDD,InTemp,InHum,WindSamp,WindTx,ISSReception)
?>