<?
$targetTable="ar200407";
 


 /* Connecting, selecting database */
	$link = mysql_connect("62.128.42.9", "boaz", "854456", false, 128);
    //   or print($php_errormsg);
    mysql_select_db("boaz");
	//	   or print($php_errormsg);

	 $query2 = "select count(*) from $targetTable";
	 $result = mysql_query($query2); 
		
	$line = mysql_fetch_array($result, MYSQL_ASSOC) or $error_db = true;
	print $targetTable.": ";
	print "\t<table><tr align=\"center\"><td COLSPAN=19 class=big>$MaxOrMin $param</td></tr>\n";
		print "\t<tr align=\"center\">\n";
		foreach ($line as $col_value) {
				print "\t\t<td>$col_value</td>\n";
		}
		print "\t</tr></table>\n";
	 /* Free resultset */
	  mysql_free_result($result);
	
    /* Closing connection */
       mysql_close($link);
	
?>