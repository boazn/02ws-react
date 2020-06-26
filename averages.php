<html>
<head>
<title><? echo $AVERAGE[$lang_idx]; ?> & <? echo $RECORDS[$lang_idx]; ?> <? echo $TEMP[$lang_idx]; ?> <? echo $HUMIDITY[$lang_idx]; ?> <? echo $RAIN[$lang_idx]; ?> - <? echo $MONTHLY[$lang_idx]; ?></title>
<META name="keywords" content="September, October, November, December, January, February , March, April, May, June, cam,  July, August, אוגוסט, ינואר, פברואר, מרץ, אפריל, מאי, יוני, יולי, ממוצע, גשם, טמפרטורה, לחות, ירושלים">
</head>
<body >
<h1 align="center"><? echo $AVERAGE[$lang_idx]; ?> - <? echo $TEMP[$lang_idx]; ?>, <? echo $HUMIDITY[$lang_idx]; ?>, <? echo $PRECIPITATION[$lang_idx]; ?></h1>
<? if (isHeb()) { ?>
<div class="clear" style="direction:rtl">
<a href="<? echo get_query_edited_url(get_url(), 'section', 'RainSeasons.php');?>"><? echo $RAIN_SEASONS[$lang_idx]; ?><?=get_arrow()?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="http://www.ims.gov.il/NR/rdonlyres/FEE1B975-72C5-45EF-B67A-672FC83C6FE2/0/%D7%9E%D7%A4%D7%95%D7%AA%D7%9E%D7%A9%D7%A7%D7%A2%D7%99%D7%9D19812010%D7%9E%D7%A4%D7%95%D7%AA19.pdf" rel="external" class="colorbox">מפות ממוצעי כמות גשם שנתית<?=get_arrow()?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="http://www.ims.gov.il/NR/rdonlyres/6C644572-AC12-4B7D-A084-342771C43527/0/%D7%9E%D7%A4%D7%95%D7%AA%D7%99%D7%9E%D7%99%D7%92%D7%A9%D7%9D19812010%D7%9E%D7%A4%D7%95%D7%AA1015.pdf" rel="external" class="colorbox">מפות ממוצעי ימי גשם<?=get_arrow()?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</div>
<br />
<br />
<? } ?>

<table summary="" border="5" id="mouseover" <? if (isHeb()) echo "dir=rtl"; ?> width="100%" style="text-align: center">
<tr class="inv">
    <td><? echo $MONTH[$lang_idx];?></td>
    <td><? echo($MIN[$lang_idx])."<br /> ".($TEMP[$lang_idx]);?><br/> <div class="paramunit big">&#176;</div><div class="param big"><? echo $current->get_tempunit(); ?></div></td>
    <td><? echo($MAX[$lang_idx])."<br /> ".($TEMP[$lang_idx]);?><br/> <div class="paramunit big">&#176;</div><div class="param big"><? echo $current->get_tempunit(); ?></div></td>
    <td><? echo($MID[$lang_idx])."<br /> ".($TEMP[$lang_idx]);?><br/> <div class="paramunit big">&#176;</div><div class="param big"><? echo $current->get_tempunit(); ?></div></td>
    <td><? echo($MIN[$lang_idx])."<br /> ".($RECORD[$lang_idx]);?><br/><div class="paramunit big">&#176;</div><div class="param big"><? echo $current->get_tempunit(); ?></div></td>
    <td><? echo($MAX[$lang_idx])."<br /> ".($RECORD[$lang_idx]);?><br/><div class="paramunit big">&#176;</div><div class="param big"><? echo $current->get_tempunit(); ?></div></td>
    <td><? echo($MAX[$lang_idx])."<br /> ". ($HUMIDITY[$lang_idx]);?><br/> %</td>
    <td><? echo($MIN[$lang_idx])."<br /> ".($HUMIDITY[$lang_idx]);?><br/> %</td>
    <td><? echo($MID[$lang_idx])."<br /> ".($HUMIDITY[$lang_idx]);?><br/> %</td>
    <td><? echo $RAIN[$lang_idx];?><br/> mm</td>
    <td><? echo $RAINY_DAYS[$lang_idx];?></td>
    <td><? echo($MIN[$lang_idx])."<br /> ".($RAIN[$lang_idx]);?></td>
    <td><? echo($MAX[$lang_idx])."<br /> ".($RAIN[$lang_idx]);?></td>
</tr>
<!--
<tr align="center"><td>September</td><td></td><td></td><td>23.3</td><td>86</td><td>38</td><td>63</td><td>0.0</td></tr>
<tr align="center"><td>October</td><td></td><td></td><td>20.5</td><td>78</td><td>36</td><td>58</td><td>9.9</td></tr>
<tr align="center"><td>November</td><td></td><td></td><td>16.0</td><td>77</td><td>43</td><td>60</td><td>59.9</td></tr>
<tr align="center"><td>December</td><td></td><td></td><td>10.5</td><td>84</td><td>54</td><td>69</td><td>106.9</td></tr>
<tr align="center"><td>January</td><td></td><td></td><td>8.7</td><td>85</td><td>55</td><td>70</td><td>134.1</td></tr>
<tr align="center"><td>February</td><td></td><td></td><td>9.5</td><td>83</td><td>48</td><td>66</td><td>112.0</td></tr>
<tr align="center"><td>March</td><td></td><td></td><td>12.5</td><td>81</td><td>44</td><td>62</td><td>95.0</td></tr>
<tr align="center"><td>April</td><td></td><td></td><td>16.0</td><td>74</td><td>36</td><td>54</td><td>29.0</td></tr>
<tr align="center"><td>May</td><td></td><td></td><td>20.0</td><td>69</td><td>29</td><td>47</td><td>3.3</td></tr>
<tr align="center"><td>June</td><td></td><td></td><td>22.3</td><td>73</td><td>31</td><td>50</td><td>0.0</td></tr>
<tr align="center"><td>July</td><td></td><td></td><td>24.3</td><td>79</td><td>34</td><td>54</td><td>0.0</td></tr>
<tr align="center"><td>August</td><td></td><td></td><td>24.5</td><td>82</td><td>35</td><td>58</td><td>0.0</td></tr>
-->
<?
	function getColTitle($colNum)
	{
		global $MAX, $MIN, $HIGH, $MID, $TEMP, $HUMIDITY, $RAIN, $RAINY_DAYS, $lang_idx, $RECORD;
		if ($colNum == 1)
			return "";
		else if ($colNum == 2)
			return "{$MIN[$lang_idx]}&nbsp;{$TEMP[$lang_idx]}";
		else if ($colNum == 3)
			return "{$MAX[$lang_idx]}&nbsp;{$TEMP[$lang_idx]}";
		else if ($colNum == 4)
			return "{$MID[$lang_idx]}&nbsp;{$TEMP[$lang_idx]}";
		else if ($colNum == 5)
			return "{$MIN[$lang_idx]}&nbsp;{$RECORD[$lang_idx]}";
		else if ($colNum == 6)
			return "{$MAX[$lang_idx]}&nbsp;{$RECORD[$lang_idx]}";
		else if ($colNum == 7)
			return "{$MAX[$lang_idx]}&nbsp;{$HUMIDITY[$lang_idx]}";
		else if ($colNum == 8)
			return "{$MIN[$lang_idx]}&nbsp;{$HUMIDITY[$lang_idx]}";
		else if ($colNum == 9)
			return "{$MID[$lang_idx]}&nbsp;{$HUMIDITY[$lang_idx]}";
		else if ($colNum == 10)
			return "{$RAIN[$lang_idx]}";
		else if ($colNum == 11)
			return "{$RAINY_DAYS[$lang_idx]}";
                else if ($colNum == 12)
			return "{$MIN[$lang_idx]}&nbsp;{$RAIN[$lang_idx]}";
                else if ($colNum == 13)
			return "{$MAX[$lang_idx]}&nbsp;{$RAIN[$lang_idx]}";
		else
			return "";
	}

    /* Connecting, selecting database */
	
	
   

    /* Performing SQL query */
    $result = db_init("SELECT * FROM average ORDER BY Month ASC", "");
    /* Printing results in HTML */
    
    while ($line = mysqli_fetch_array($result["result"], MYSQLI_ASSOC)) {
		$col_num = 0;
		print "\t<tr class=\"inv_plain_3\">\n";
        foreach ($line as $col_value) {
		    $col_num++;
			if ($col_num == 1)
			{
				if (date("n") ==  $col_value)
					print "\t\t<td class=\"inv_plain\" style=\"height:4em\"><strong>".getMonthName($col_value)."</strong></td>\n";
				else
					print "\t\t<td class=\"topbase\">".getMonthName($col_value)."</td>\n";
			}
			else if ($col_num == 5)
			    print "\t\t<td style=\"direction:ltr\" title=\"".getColTitle($col_num)."\" class=\"number\"><a href=# class=\"info\"><span style=\"direction:ltr\">".round($col_value, 1)." <br/>".$line["AbsLowTempDate"]."</span><span class=\"info\">".getColTitle($col_num)."</span></a></td>\n";
			else if ($col_num == 6)
			   print "\t\t<td style=\"direction:ltr\" title=\"".getColTitle($col_num)."\" class=\"number\"><a href=# class=\"info\"><span style=\"direction:ltr\">".round($col_value, 1)." <br/>".$line["AbsHighTempDate"]."</span><span class=\"info\">".getColTitle($col_num)."</span></a></td>\n";
			else if ($col_num <= 13)
				print "\t\t<td style=\"direction:ltr\" title=\"".getColTitle($col_num)."\" class=\"number\"><a href=# class=\"info\"><span style=\"direction:ltr\">".round($col_value, 1)."</span><span class=\"info\">".getColTitle($col_num)."</span></a></td>\n";
        }
        print "\t</tr>\n";
    }
    
	print "\t<tr class=\"inv_plain_2\" style=\"height:3em\" class=\"number\"><td>".$AVERAGE[$lang_idx]." - ".$WHOLE_SEASON[$lang_idx]."</td>\n";
	 /* Performing SQL query */
    $query = "SELECT avg(LowTemp) FROM average";
    $result = mysqli_query($link, $query);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC) or $error = true;
	$num = number_format($row['avg(LowTemp)'], 1, '.', '');
	print "<td title=\"".$MIN[$lang_idx]." ".$TEMP[$lang_idx]."\">$num</td>\n";
	 /* Performing SQL query */
    $query = "SELECT avg(HighTemp) FROM average";
    $result = mysqli_query($link, $query) or die("Query failed");
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC) or $error = true;
	$num = number_format($row['avg(HighTemp)'], 1, '.', '');
	print "<td title=\"".$MAX[$lang_idx]." ".$TEMP[$lang_idx]."\">$num</td>\n";
	 /* Performing SQL query */
    $query = "SELECT avg(MidTemp) FROM average";
    $result =mysqli_query($link, $query);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC) or $error = true;
	$num = number_format($row['avg(MidTemp)'], 1, '.', '');
	print "<td title=\"".$MID[$lang_idx]." ".$TEMP[$lang_idx]."\">$num</td>\n";
        $query = "SELECT avg(AbsLowTemp) FROM average";
    $result = mysqli_query($link, $query);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC) or $error = true;
	$num = number_format($row['avg(AbsLowTemp)'], 1, '.', '');
        print "<td title=\"".$MIN[$lang_idx]." ".$TEMP[$lang_idx]."\">$num</td>\n";
        $query = "SELECT avg(AbsHighTemp) FROM average";
    $result = mysqli_query($link, $query);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC) or $error = true;
	$num = number_format($row['avg(AbsHighTemp)'], 1, '.', '');
        print "<td title=\"".$MAX[$lang_idx]." ".$TEMP[$lang_idx]."\">$num</td>\n";
	$query = "SELECT avg(HighHum) FROM average";
    $result = mysqli_query($link, $query);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC) or $error = true;
	$num = number_format($row['avg(HighHum)'], 1, '.', '');
	print "<td title=\"".$MAX[$lang_idx]." ".$HUMIDITY[$lang_idx]."\">$num</td>\n";
	$query = "SELECT avg(LowHum) FROM average";
    $result = mysqli_query($link, $query);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC) or $error = true;
	$num = number_format($row['avg(LowHum)'], 1, '.', '');
	print "<td title=\"".$MIN[$lang_idx]." ".$HUMIDITY[$lang_idx]."\">$num</td>\n";
	$query = "SELECT avg(MidHum) FROM average";
    $result = mysqli_query($link, $query);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC) or $error = true;
	$num = number_format($row['avg(MidHum)'], 1, '.', '');
	print "<td title=\"".$MID[$lang_idx]." ".$HUMIDITY[$lang_idx]."\">$num</td>\n";
	$query = "SELECT SUM(Rain) FROM average";
    $result = mysqli_query($link, $query);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC) or $error = true;
	$num = number_format($row['SUM(Rain)'], 1, '.', '');
	print "<td title=\"".$RAIN[$lang_idx]."\">$num</td>\n";
	$query = "SELECT SUM(RainyDays) FROM average";
    $result = mysqli_query($link, $query);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC) or $error = true;
	$num = number_format($row['SUM(RainyDays)'], 1, '.', '');
	print "<td title=\"".$RAINY_DAYS[$lang_idx]."\">$num</td>\n";
        $query = "SELECT SUM(MinRain) FROM average";
        $result =mysqli_query($link, $query);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC) or $error = true;
	$num = number_format($row['SUM(MinRain)'], 1, '.', '');
        print "<td title=\"".$MIN[$lang_idx]." ".$RAIN[$lang_idx]."\">$num</td>\n";
        $query = "SELECT SUM(MaxRain) FROM average";
        $result = mysqli_query($link, $query);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC) or $error = true;
	$num = number_format($row['SUM(MaxRain)'], 1, '.', '');
        print "<td title=\"".$MAX[$lang_idx]." ".$RAIN[$lang_idx]."\">$num</td>\n";
	print "\t</tr>\n";
    /* Free resultset */
    mysqli_free_result($result);

    /* Closing connection */
    mysqli_close($link);
?>
</table>

<br/>
<div><? echo $SOURCE[$lang_idx]; ?>: <? echo $IMS[$lang_idx]; ?> </div>
<br/>

<script language="JavaScript" type="text/javascript">
trMouseOver();
</script>
</body>
</html>
