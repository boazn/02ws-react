<html>
<head>
<title>All Time records</title>
<meta name="keywords" content="extremes,שיא, עונתי, שנתי  ">
</head>
<body >
<table style="width:95%;border-spacing:0.1em">
<tr>
	<td>
		<h1 align="center"><? echo $EXTREME[$lang_idx]." ".$TEMP[$lang_idx]." ".$HUMIDITY[$lang_idx]." ".$RAIN[$lang_idx]." ".$WIND[$lang_idx];?></h1>
		<table style="text-align: center;width:360px;border-collapse: separate;border-spacing: 1px;<? if (isHeb()) echo "direction:rtl"; ?>"  >
		<tr >
			<td></td>
			<td class="topbase"><a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=reports/NOAAMO.TXT" class="hlink"><? echo $monthInWord." ".$year; ?></a></td>
			<td class="topbase"><a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=reports/NOAAYR.TXT" class="hlink"><? echo $year; ?></a></td>
		</tr>

			<tr class="inv_plain_3">
				<td <? if (isHeb()) echo "dir=\"rtl\" align=\"left\""; ?>><strong><? echo($MAX[$lang_idx]);?> <? echo $TEMP[$lang_idx];?></strong></td>
				<td><? echo(" <div class=\"high\">".toLeft($thisMonth->get_hightemp().$current->get_tempunit())."</div>");?> </td>
				<td><? echo(" <div class=\"high\">".toLeft($thisYear->get_hightemp().$current->get_tempunit())."</div>");?> </td>
			</tr>
			<tr  class="inv_plain_3">
				<td <? if (isHeb()) echo "dir=\"rtl\" align=\"left\""; ?>><strong><? echo($MIN[$lang_idx]);?> <? echo $TEMP[$lang_idx];?></strong></td>
				<td><? echo( " <div class=\"low\">".toLeft($thisMonth->get_lowtemp().$current->get_tempunit())."</div>");?> </td>
				<td><? echo( " <div class=\"low\">".toLeft($thisYear->get_lowtemp().$current->get_tempunit())."</div>");?> </td>
			</tr>
			<tr class="inv_plain_3">
				<td <? if (isHeb()) echo "dir=\"rtl\" align=\"left\""; ?>><strong><? echo($MAX[$lang_idx]);?> <? echo $HUMIDITY[$lang_idx];?></strong></td>
				<td><? echo( " ".toLeft($thisMonth->get_highhum()."%"));?> </td>
				<td><? echo( " ".toLeft($thisYear->get_highhum()."%"));?> </td>
			</tr>
			<tr class="inv_plain_3">
				<td <? if (isHeb()) echo "dir=\"rtl\" align=\"left\""; ?>><strong><? echo($MIN[$lang_idx]);?> <? echo $HUMIDITY[$lang_idx];?></strong></td>
				<td><? echo( " ".toLeft($thisMonth->get_lowhum()."%"));?> </td>
				<td><? echo( " ".toLeft($thisYear->get_lowhum()."%"));?> </td>
			</tr>
			<tr class="inv_plain_3">
				<td <? if (isHeb()) echo "dir=\"rtl\" align=\"left\""; ?>><strong><? echo($MAX[$lang_idx]);?> <? echo $WIND[$lang_idx];?></strong></td>
				<td><? echo( " ".toLeft($thisMonth->get_highwind().$windUnits));?> </td>
				<td><? echo( " ".toLeft($thisYear->get_highwind().$windUnits));?> </td>
			</tr>
			<tr class="inv_plain_3">
				<td <? if (isHeb()) echo "dir=\"rtl\" align=\"left\""; ?>><strong><? echo($MAX[$lang_idx]);?> <? echo $DEW[$lang_idx];?></strong></td>
				<td ><? echo( " <div class=\"high\">".toLeft($thisMonth->get_highdew().$current->get_tempunit())."</div>");?> </td>
				<td><? echo( " <div class=\"high\">".toLeft($thisYear->get_highdew().$current->get_tempunit())."</div>");?> </td>
			</tr>
			<tr  class="inv_plain_3">
				<td <? if (isHeb()) echo "dir=\"rtl\" align=\"left\""; ?>><strong><? echo($MIN[$lang_idx]);?> <? echo $DEW[$lang_idx];?></strong></td>
				<td ><? echo( " <div class=\"low\">".toLeft($thisMonth->get_lowdew().$current->get_tempunit())."</div>");?> </td>
				<td ><? echo( " <div class=\"low\">".toLeft($thisYear->get_lowdew().$current->get_tempunit())."</div>");?> </td>
			</tr>
			<tr class="inv_plain_3">
				<td <? if (isHeb()) echo "dir=\"rtl\" align=\"left\""; ?>><strong><? echo($MAX[$lang_idx]);?> <? echo $BAR[$lang_idx];?></strong></td>
				<td><? echo( " ".toLeft($thisMonth->get_highbar()."mb"));?> </td>
				<td><? echo( " ".toLeft($thisYear->get_highbar()."mb"));?> </td>
			</tr>
			<tr style="direction:ltr" class="inv_plain_3">
				<td <? if (isHeb()) echo "dir=\"rtl\" align=\"left\""; ?>><strong><? echo($MIN[$lang_idx]);?> <? echo $BAR[$lang_idx];?></strong></td>
				<td><? echo( " ".toLeft($thisMonth->get_lowbar()."mb"));?> </td>
				<td><? echo( " ".toLeft($thisYear->get_lowbar()."mb"));?> </td>
			</tr>
			<tr style="direction:ltr" class="inv_plain_3">
				<td <? if (isHeb()) echo "dir=\"rtl\" align=\"left\""; ?>><strong><? echo($MIN[$lang_idx]);?> <? echo $WIND_CHILL[$lang_idx];?></strong></td>
				<td ><? echo(" <div class=\"low\">".toLeft($thisMonth->get_lowwindchill()).$current->get_tempunit()."</div>");?> </td>
				<td ><? echo(" <div class=\"low\">".toLeft($thisYear->get_lowwindchill()).$current->get_tempunit()."</div>");?> </td>
			</tr>
			<tr class="inv_plain_3">
				<td <? if (isHeb()) echo "dir=\"rtl\" align=\"left\""; ?>><strong><? echo($MAX[$lang_idx]);?> <? echo $HEAT_IDX[$lang_idx];?></strong></td>
				<td><? echo(" <div class=\"high\">".toLeft($thisMonth->get_highheatindex().$current->get_tempunit())."</div>");?> </td>
				<td><? echo(" <div class=\"high\">".toLeft($thisYear->get_highheatindex().$current->get_tempunit())."</div>");?> </td>
			</tr>
			<tr class="inv_plain_3">
				<td <? if (isHeb()) echo "dir=\"rtl\" align=\"left\""; ?>><strong><? echo($MAX[$lang_idx]);?> <? echo $RAIN_RATE[$lang_idx];?></strong></td>
				<td <? if (isHeb()) echo "dir=\"rtl\""; ?>><? echo(" ".$thisMonth->get_highrainrate()." ".$RAINRATE_UNIT[$lang_idx]);?> </td>
				<td <? if (isHeb()) echo "dir=\"rtl\""; ?>><? echo(" ".$thisYear->get_highrainrate()." ".$RAINRATE_UNIT[$lang_idx]);?> </td>
			</tr>
			
		</table>
		
	</td>
	<td>
		
		<h1 <? if (isHeb()) echo "dir=\"rtl\""; ?>><? echo $RECORDS[$lang_idx];?></h1>
		<h3 class="clear">From The Books מהספרים</h3>
		<table style="text-align: center;width:460px;padding:3px;border-collapse: separate;border-spacing: 3px;<? if (isHeb()) echo "direction:rtl"; ?>">
		<tr class="inv_plain_3">
			<td <? if (isHeb()) echo "dir=\"rtl\" align=\"left\""; ?>><strong><? echo $MAX[$lang_idx]." ".$TEMP[$lang_idx];?></strong></td>
			<td>44<? echo $current->get_tempunit(); ?></td>
			<td>28/8/1881 & 30/8/1881</td>
		</tr>
		<tr class="inv_plain_3">
			<td <? if (isHeb()) echo "dir=\"rtl\" align=\"left\""; ?>><strong><? echo $MIN[$lang_idx]." ".$TEMP[$lang_idx];?></strong></td>
			<td dir="ltr">-6.7<? echo $current->get_tempunit(); ?></td>
			<td>25/1/1907</td>
		</tr>
		<tr class="inv_plain_3">
			<td <? if (isHeb()) echo "dir=\"rtl\" align=\"left\""; ?>><strong><? echo $MIN[$lang_idx]." ".$RAIN[$lang_idx];?></strong></td>
			<td>206 <?=$RAIN_UNIT[$lang_idx]?></td>
			<td>1959/60</td>
		</tr>
		<tr class="inv_plain_3">
			<td <? if (isHeb()) echo "dir=\"rtl\" align=\"left\""; ?>><strong><? echo $MAX[$lang_idx]." ".$RAIN[$lang_idx];?></strong></td>
			<td>1134 <?=$RAIN_UNIT[$lang_idx]?></td>
			<td>1991/1992</td>
		</tr>
		<tr class="inv_plain_3">
			<td <? if (isHeb()) echo "dir=\"rtl\" align=\"left\""; ?>><strong><? echo $MAX[$lang_idx]." ".$MONTHLY[$lang_idx]." ".$RAIN[$lang_idx];?></strong></td>
			<td>418 <?=$RAIN_UNIT[$lang_idx]?></td>
			<td>1/1974</td>
		</tr>
		<tr class="inv_plain_3">
			<td <? if (isHeb()) echo "dir=\"rtl\" align=\"left\""; ?>><strong><? echo $MAX[$lang_idx]." ".$DAILY_RAIN[$lang_idx]?></strong></td>
			<td>121 <?=$RAIN_UNIT[$lang_idx]?></td>
			<td>17/3/1916</td>
		</tr>
		</table>
		<div class="hr">&nbsp;</div>
		<table <? if (isHeb()) echo "dir=rtl"; ?>>
		<tr class="inv_plain_3">
			<td <? if (isHeb()) echo "dir=\"rtl\" align=\"left\""; ?>><strong><? echo $MAX[$lang_idx]." ".$TEMP[$lang_idx]." ".getMonthName(8) ;?></strong></td>
			<td>(20.08.10) 41.0</td>
		</tr>
		<tr class="inv_plain_3">
			<td <? if (isHeb()) echo "dir=\"rtl\" align=\"left\""; ?>><strong><? echo $MAX[$lang_idx]." ".$TEMP[$lang_idx]." ".getMonthName(7); ?></strong></td>
			<td>(30.7.00) 40.8</td>
		</tr>
		<tr class="inv_plain_3">
			<td <? if (isHeb()) echo "dir=\"rtl\" align=\"left\""; ?>><strong><? echo $MAX[$lang_idx]." ".$TEMP[$lang_idx]." 1925++"; ?></strong></td>
			<td>(21/6/42) 42.0</td>
		</tr>
		</table>
		<? echo $SOURCE[$lang_idx]; ?>: <? echo $IMS[$lang_idx]; ?><br />
		<div <? if (isHeb()) echo "dir=\"rtl\""; ?>>
		<a href="<? echo get_query_edited_url(get_url(), 'section', 'RainSeasons');?>">150 <? echo $RAIN_SEASONS[$lang_idx]; ?>...<span id="moreinfo"><?=get_arrow()?><?=get_arrow()?></span></a>
		</div>
	</td>
</tr>
</table>
<?
	error_reporting(E_ERROR);
	
	$virgin_condition = true;
	$condition="";
	$table="";
	$tables = array();
        db_init("", "");
        array_push ($tables,"archivemin");
        array_push ($tables,"archive");
        
?>

<table summary="" align="center" border="3" id="mouseover">
<tr valign="top"><td class="topbase">Date</td><td class="topbase">Time</td><td class="inv_plain_3"><? echo $TEMP[$lang_idx];?> (<? echo $current->get_tempunit(); ?>)</td><td class="inv_plain_3"><span class="high">High<br><? echo $TEMP[$lang_idx];?> (<? echo $current->get_tempunit(); ?>)</span></td><td class="inv_plain_3"><span class="low">Low<br><? echo $TEMP[$lang_idx];?> (<? echo $current->get_tempunit(); ?>)</span></td><td class="inv_plain_3"><? echo $HUMIDITY[$lang_idx];?><br>(%)</td><td class="inv_plain_3"><? echo $DEW[$lang_idx];?> (<? echo $current->get_tempunit(); ?>)</td><td class="inv_plain_3"><? echo $WIND_CHILL[$lang_idx];?> (<? echo $current->get_tempunit(); ?>)</td><td class="inv_plain_3"><? echo $WIND_DIR[$lang_idx];?></td><td class="inv_plain_3"><? echo $WIND_SPEED[$lang_idx];?> (Knots) </td><td class="inv_plain_3">High <? echo $WIND_DIR[$lang_idx];?></td><td class="inv_plain_3"><? echo $WIND_CHILL[$lang_idx];?><br>(<? echo $current->get_tempunit(); ?>)</td><td class="inv_plain_3"><? echo $HEAT_IDX[$lang_idx];?> (<? echo $current->get_tempunit(); ?>)</td><td class="inv_plain_3">THW (<? echo $current->get_tempunit(); ?>)</td><td class="inv_plain_3"><? echo $BAR[$lang_idx];?> (mb)</td><td class="inv_plain_3"><? echo $RAIN[$lang_idx];?> (mm)</td><td class="inv_plain_3"><? echo $RAINRATE[$lang_idx];?> (mm/hr)</td></tr>

<?	

	function getColumnName($columnNumber)
{
	global $lang_idx, $TEMP, $HUMIDITY, $DEW, $WIND_SPEED, $KNOTS, $WIND_DIR, $WIND_CHILL, $HEAT_IDX, $BAR, $RAIN,  $RAINRATE, $HIGH, $current;
	switch ($columnNumber):
		case 0:
			return "Date";
			break;
		case 1:
			return "time";
			break;
		case 2:
			return $TEMP[$lang_idx]." "."(".$current->get_tempunit().")";
			break;
		case 3:
			return "High ".$TEMP[$lang_idx]." "."(".$current->get_tempunit().")";
			break;
		case 4:
			return "Low ".$TEMP[$lang_idx]." "."(".$current->get_tempunit().")";
			break;
		case 5:
			return $HUMIDITY[$lang_idx]." "."(%)";
			break;
		case 6:
			return $DEW[$lang_idx]." "."(".$current->get_tempunit().")";
			break;
		case 7:
			return $WIND_SPEED[$lang_idx]." "."(".$KMH[$lang_idx].")";
			break;
		case 8:
			return $WIND_DIR[$lang_idx];
			break;
		case 9:
			return $HIGH[$lang_idx]." ".$WIND_SPEED[$lang_idx]." "."(".$KMH[$lang_idx].")";
			break;
		case 10:
			return "High ".$WIND_DIR[$lang_idx];
			break;
		case 11:
			return $WIND_CHILL[$lang_idx]." "."(".$current->get_tempunit().")";
			break;
		case 12:
			return $HEAT_IDX[$lang_idx]." "."(".$current->get_tempunit().")";
			break;
		case 13:
			return "THW"." "."(".$current->get_tempunit().")";
			break;
		case 14:
			return $BAR[$lang_idx]." "."(mb)";
			break;
		case 15:
			return $RAIN[$lang_idx]." "."(".$RAIN_UNIT[$lang_idx].")";
			break;
		case 16:
			return $RAINRATE[$lang_idx]." (".$RAINRATE_UNIT[$lang_idx].")";
			break;
		default:
			return "";
			break;
	endswitch;
	

}
	function getExtreme ($MaxOrMin, $param, $extra_data, $linetitle)
	{
		global $tables;
		$desc = "Desc";
                $minus = "";
		if ($MaxOrMin == "max")
			$ThreshParam = 0;
		else
		{
			$ThreshParam = 1500;
			$desc = "";
                        $minus = "-";
                        
		}
		$extremeParam = $ThreshParam;
                
		for ($i = 0;$tables[$i]!=null ;$i++) {
			$table = $tables[$i];
			//$condition = "Temp = (SELECT MAX(Temp) FROM $table)";
			//$query = "SELECT Date,Time,Temp,HiTemp,LowTemp,Hum,Dew,WindSpd,WindDir,HiSpeed,HiDir,WindChill,HeatIdx,THW,Bar,Rain,RainRate FROM $table WHERE $condition";
			
			if (strstr($table, "min")){
                            $query = "SELECT  Date,Temp,HiTemp,LowTemp,Hum,Rain FROM $table ORDER BY $minus$param DESC LIMIT 1";
                        }
                        else{
                            $query = "SELECT  Date,Time,Temp,HiTemp,LowTemp,Hum,Dew,WindSpd,WindDir,HiSpeed,HiDir,WindChill,HeatIdx,THW,Bar,Rain,RainRate FROM $table ORDER BY $param $desc LIMIT 1";
                        }
			//echo "<br>$query<br>";
                        if ((strstr($table, "min"))&&(($param == "Bar")||($param == "HeatIdx")||($param == "WindChill")||($param == "Dew")))
                                return ;
                        
			$result = db_init($query, "");
			$line = mysqli_fetch_array($result["result"], MYSQLI_ASSOC);
			$param_ret = $line[$param];

			/// debug /////
			//echo " ".$param_ret;
			foreach ($line as $col_value) {
							print "\t\t<td>$col_value</td>\n";
					}
			print "\t</tr>\n";
			//////////////

			if ($MaxOrMin == "max")
				if ($extremeParam < $param_ret){
					$extremeline = $line;
					$extremeParam = $param_ret;
				}
				else;
			else
				if ($param_ret != "")
					if ($extremeParam > $param_ret){
					  $extremeline = $line;
					  $extremeParam = $param_ret;
					  //echo " override by $table: ".$extremeParam;
					}
			
			   
		}
		print "\t<tr align=\"center\" ><td colspan=\"19\" style=\"padding:0.5em\"";
		if (isHeb()) echo " dir=\"rtl\" align=\"right\""; else echo "align=\"left\"";
		print ">$linetitle: <strong><span dir=\"ltr\">$extremeline[$param]$extra_data</span></strong></td></tr>\n";
		print "\t<tr>\n";
		foreach ($extremeline as $col_value) {
				if ($col < 2)
						print "\t\t<td class=\"topbase\"";
				else if ($extremeline[$param] == $col_value)
						print "\t\t<td class=\"inv_plain_3_zebra\" align=\"center\"";
				else
						print "\t\t<td class=\"inv_plain_3\"";
				print " title=\"".getColumnName($col)."\"";
				print ">$col_value</td>\n";
				$col++;
		}
		print "\t</tr>\n";
		print "<tr><td colspan=\"19\" height=\"18px\"></td></tr>";
		return ($extremeline[$param]);
	}

	 getExtreme ("max","HiTemp", "C", $MAX[$lang_idx]." ".$TEMP[$lang_idx]);
	 getExtreme ("min","LowTemp", "C", $MIN[$lang_idx]." ".$TEMP[$lang_idx]);
	 getExtreme ("min","Hum", "%", $MIN[$lang_idx]." ".$HUMIDITY[$lang_idx]);
	 getExtreme ("max","HiSpeed", "Knots", $MAX[$lang_idx]." ".$WIND[$lang_idx]);
	 getExtreme ("max","RainRate", $RAINRATE_UNIT[$lang_idx], $MAX[$lang_idx]." ".$RAIN_RATE[$lang_idx]);
	 $rain15min = getExtreme ("max","Rain", "mm (for 15 min)", $MAX[$lang_idx]." ".$RAIN[$lang_idx]);
	 echo "<tr><td colspan=\"19\" >calculated rain intensity : <strong>".($rain15min*4)." mm/hr</strong></td></tr>";
	 getExtreme ("max","Bar", "mb", $MAX[$lang_idx]." ".$BAR[$lang_idx]);
	 getExtreme ("min","Bar", "mb", $MIN[$lang_idx]." ".$BAR[$lang_idx]);
	 getExtreme ("max","HeatIdx", "C", $MAX[$lang_idx]." ".$HEAT_IDX[$lang_idx]);
	 getExtreme ("min","WindChill", "C", $MIN[$lang_idx]." ".$WIND_CHILL[$lang_idx]);
	 getExtreme ("max","Dew", "C", $MAX[$lang_idx]." ".$DEW[$lang_idx]);
	 getExtreme ("min","Dew", "C", $MIN[$lang_idx]." ".$DEW[$lang_idx]);



//////////////////////////////////////////////////////////////
    /* Free resultset */
    mysqli_free_result($result);

    /* Closing connection */
    mysqli_close($link);
?>
</table>
<table style="text-align: center">
						<tr class="topbase">
							<td>Source</td>
							<td>Year</td>
						</tr>
						<tr class="inv_plain_3">
							<td>my station</td>
							<td>2002+</td>
						</tr>
						<tr class="inv_plain_3">
							<td>Jerusalem centeral (Generali)</td>
							<td>1950-2016</td>
						</tr>
						<tr class="inv_plain_3">
							<td>Jerusalem - old city</td>
							<td>1948-1949</td>
						</tr>
						<tr class="inv_plain_3">
							<td>Jerusalem - Saint Anne</td>
							<td>1907-1948</td>
						</tr>
</table>
<script language="JavaScript" type="text/javascript">
trMouseOver();
</script>