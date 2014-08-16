 <?
 $rdays = 9;
 $mm = 55.1;
 $month = 3;
 $year = 2002;

 /* Connecting, selecting database */
	$link = mysql_connect("62.128.42.9", "boaz", "854456", false, 128);
    //   or print($php_errormsg);
    mysql_select_db("boaz");
	//	   or print($php_errormsg);
 
 
    // Update Rainy days and mm on day 
    
    
          
         $query = "UPDATE RainSeason SET RainyDays=$rdays, mm=$mm WHERE ((month=$month) and (Year=$year))";
         $result = mysql_query($query); 
          //or print($php_errormsg);
		  print ("number of updated rows: ".$result);
    
     
?>