<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
<title>browse result</title>
<link href="general.css" rel="stylesheet" type="text/css">
</head>
<body>
<br>
<form method="POST" name="date">
<P style="line-height:100%; margin-top:0; margin-bottom:0;" align="center" >
<select size="1" name="browseday" ><option value='' selected>Day</option>
<option value='01'>1</option>
<option value='02'>2</option>
<option value='03'>3</option>
<option value='04'>4</option>
<option value='05'>5</option>
<option value='06'>6</option>
<option value='07'>7</option>
<option value='08'>8</option>
<option value='09'>9</option>
<option value='10'>10</option>
<option value='11'>11</option>
<option value='12'>12</option>
<option value='13'>13</option>
<option value='14'>14</option>
<option value='15'>15</option>
<option value='16'>16</option>
<option value='17'>17</option>
<option value='18'>18</option>
<option value='19'>19</option>
<option value='20'>20</option>
<option value='21'>21</option>
<option value='22'>22</option>
<option value='23'>23</option>
<option value='24'>24</option>
<option value='25'>25</option>
<option value='26'>26</option>
<option value='27'>27</option>
<option value='28'>28</option>
<option value='29'>29</option>
<option value='30'>30</option>
<option value='31'>31</option>
</select>
<select size="1" name="browsemonth"><option value='' selected>Month</option>
<option value='01'>1</option>
<option value='02'>2</option>
<option value='03'>3</option>
<option value='04'>4</option>
<option value='05'>5</option>
<option value='06'>6</option>
<option value='07'>7</option>
<option value='08'>8</option>
<option value='09'>9</option>
<option value='10'>10</option>
<option value='11'>11</option>
<option value='12'>12</option>
</select>
<select size="1" name="browseyear"><option value='' selected>Year</option>
<option value='2001'>2001</option>
<option value='2002'>2002</option>
<option value='2003'>2003</option>
</select>&nbsp;<input type="submit" name="submit" value="Go">
<center>
<P><INPUT TYPE="checkbox" NAME="temp_search"> Search for temparture value
between: <INPUT TYPE="text" NAME="low_temp" VALUE="low" SIZE="4">
and <INPUT TYPE="text" NAME="high_temp" VALUE="high" SIZE="4">C
<br><INPUT TYPE="checkbox" NAME="hum_search"> Search for humidity value
between: <INPUT TYPE="text" NAME="low_hum" VALUE="low" SIZE="4">
and <INPUT TYPE="text" NAME="high_hum" VALUE="high" SIZE="4">%
<br><INPUT TYPE="checkbox" NAME="rainrate_search"> Search for rain rate value
between: <INPUT TYPE="text" NAME="low_rainrate" VALUE="low" SIZE="4">
and <INPUT TYPE="text" NAME="high_rainrate" VALUE="high" SIZE="4">mm/hr
</center>
</form>
<table summary="" align=center border="3">
<tr bgcolor="#808080" style="color: #deb887;" align="center" ><td>Date</td><td>Time</td><td>Temp (C)</td><td>High<br>Temp<br>(C)</td><td>Low<br>Temp(C)</td><td>Hum<br>(%)</td><td>Dew<br>point (C)</td><td>Wind<br>speed<br>(Kt)</td><td>Wind Dir (degree)</td><td>Wind<br>Run</td><td>HiSpeed<br>(Knots) </td><td>HiDir<br>(degree)</td><td>Wind<br>Chill<br>(C)</td><td>Heat<br>Idx (C)</td><td>THW</td><td>Bar (mb)</td><td>Rain (mm)</td><td>Rain<br>Rate (mm/hr)</td><td>Heat Degree Days </td><td>Cool<br>Degree<br>Days </td><td>InTemp<br>(C)</td><td>InHum<br>%</td><td>Wind<br>Samp</td><td>Wind<br>Tx</td></tr>

<?php
 /* Connecting, selecting database */
    $link = mysql_connect("sql-01.portlandpremium.co.uk", "boazn", "bn19za72")
        or die("Could not connect");

if (isset( $HTTP_POST_VARS['submit'])){
	$virgin_condition = true;
	$condition="";
	$table="";
	if (($HTTP_POST_VARS['browseday']!== "")&&( $HTTP_POST_VARS['browsemonth']!== "")&&( $HTTP_POST_VARS['browseyear']!=="")){
		$date = sprintf ( "%02d/%02d/%02d", $HTTP_POST_VARS['browseday'], $HTTP_POST_VARS['browsemonth'] , substr($HTTP_POST_VARS['browseyear'], 2));
		$condition = "date='{$date}'";
		$virgin_condition = false;
	}
	if ( ($HTTP_POST_VARS['browsemonth']!== "")&&( $HTTP_POST_VARS['browseyear']!==""))
		$table = sprintf ( "Ar%04d%02d", $HTTP_POST_VARS['browseyear'], $HTTP_POST_VARS['browsemonth']);
	else
		{
		$result = mysql_list_tables("boazn");
		for ($i = 0; $i < mysql_num_rows($result); $i++){
			$curr_table = mysql_tablename($result, $i);
			//printf ("Table: %s<br>", $curr_table);
			//if (strstr($curr_table,"Ar")){
			//	if ($i == 0)
			//		$table = "{$curr_table}";
			//	else
			//		$table.= ", {$curr_table}";
			//}
		}
		print ("choose a month and year");
		}	

	if (isset( $HTTP_POST_VARS['temp_search'])){
		if (!$virgin_condition)
			$condition .= " AND ";
		$condition .= "Temp>{$HTTP_POST_VARS['low_temp']} AND Temp<{$HTTP_POST_VARS['high_temp']}";
		$virgin_condition = false;
	}
	if (isset( $HTTP_POST_VARS['hum_search'])){
		if (!$virgin_condition)
			$condition .= " AND ";
		$condition .= "Hum>{$HTTP_POST_VARS['low_hum']} AND Hum<{$HTTP_POST_VARS['high_hum']}";
		$virgin_condition = false;
	}
	if (isset( $HTTP_POST_VARS['rainrate_search'])){
		if (!$virgin_condition)
			$condition .= " AND ";
		$condition .= "RainRate>{$HTTP_POST_VARS['low_rainrate']} AND RainRate<{$HTTP_POST_VARS['high_rainrate']}";
		$virgin_condition = false;
	}
	    
    mysql_select_db("boazn") or die("Could not select database");

    /* Performing SQL query */
    $query = "SELECT * FROM $table WHERE $condition";
	//echo "<br>$query<br>";
    $result = mysql_query($query) or die("Query failed");

    /* Printing results in HTML */
    
    while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
        print "\t<tr align=\"center\">\n";
        foreach ($line as $col_value) {
            print "\t\t<td>$col_value</td>\n";
        }
        print "\t</tr>\n";
    }
    

    /* Free resultset */
    mysql_free_result($result);

    /* Closing connection */
    mysql_close($link);
}
?>
</table>
<center>Source: My Station </center>

</body>
</html>
