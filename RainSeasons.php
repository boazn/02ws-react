<a name="rainSeasons"></a>

<h1>
<? echo $RAIN_SEASONS[$lang_idx];?>
</h1>

<table align="center" <? if (isHeb()) echo "dir=\"rtl\""; ?>>
<tr>
<td>
<form method="post" action="#rainSeasons">
	<select NAME="seasons[]" size="23" multiple>
		<?
		for ($year = 2020; $year >= 1847; $year--)
		{
			echo sprintf ("<option value=\"%04d-%04d\">%04d-%04d</option>",$year-1, $year , $year-1, $year);  
		}
		?>
	
	<option selected value="1980-2010">1980-2010</option>
	<option		 value="1970-2000">1970-2000</option>  
	<option		 value="1950-2001">1950-2001</option> 
	<option		 value="1950-1965">1950-1965</option>	
	</select> 
	<input type="submit" name="submit" value="<? echo $SHOW[$lang_idx];?>" class="topbase big"> 	
</form>
</td>
<td valign="top">
	<div <?=get_align()?> style="width:80%;margin:1em">
		<div class="inv_plain_3_zebra" style="width:200px;padding:1em;float:<?echo get_s_align();?>" >
		בחר כמה עונות בעזרת מקש ctrl כדי להשוות.
		</div>&nbsp;&nbsp;&nbsp;&nbsp;
		<div style="width:300px;padding:1em;float:<?echo get_s_align();?>" <? if (isHeb()) echo "dir=\"rtl\""; ?>><?=$LEGEND[$lang_idx]?>:
			<div class="inv_plain_2" style="width:100px;display:inline;padding:1em"><?=$RAIN_UNIT[$lang_idx]?></div><div class="inv_plain_3_zebra" style="width:100px;display:inline;padding:1em"><? echo($RAINY_DAYS[$lang_idx]);?></div></div>
		</div>
	</div>
	
	<table summary="" align="center" <? if (isHeb()) echo "dir=\"rtl\""; ?> id="mouseover" style="clear:both;border:1px solid"> 
	<!--<tr bgcolor="#808080" style="color: #deb887;" align="center" ><td>Season</td><td><? echo $TOTAL[$lang_idx];?></td></tr>-->
	<?php
	if ($error_db)
		   echo("<font color=\"red\" class=\"big\">Could not connect to database - try again later</font>");	

	if (isset( $_POST['submit'])){
		
	 
        
	/* Performing SQL query */
	
	$result = db_init("", "");
	
	
	/*******************************************/
	/* Printing row from table*/
	foreach ($_POST['seasons'] as $season){
	$raintotal = 0;
	$daystotal = 0;
	print "\t<tr >\n";
	$query = "SELECT season, year, month, mm, RainyDays, Max(station) FROM rainseason where season='$season' group by year, month order by year, month";
	$result = mysqli_query($link, $query) ;
		if (mysqli_affected_rows($link) <= 0)
		echo "couldn't get data : ".mysqli_error($link);
	$line = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$season = $line["season"];

	$result = mysqli_query($link, $query) ;
	if (mysqli_affected_rows($link) <= 0)
		echo "couldn't get data : ".mysqli_error($link);
	print "\t\t<td class=\"topbase\" align=\"center\"><strong>$season</strong></td>\n";	
	while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		$rain = $line["mm"];
		$days = $line["RainyDays"];
		$raintotal += $rain;
		$daystotal += $days;
		 print "\t\t<td style=\"border: solid 1px\"><table style=\"width:100%\"><tr class=\"topbase\"><td align=\"center\" colspan=2>".getMonthName($line["month"])."</td></tr><tr><td class=\"inv_plain_2\">$rain</td><td class=\"inv_plain_3_zebra\" align=\"center\">$days</td></tr></table></td>\n";
		
	}
	 print "\t\t<td><table style=\"width:100%\"><tr class=\"topbase\"><td align=\"center\">".$TOTAL_RAIN[$lang_idx]."</td></tr><tr align=\"center\" ><td class=\"inv_plain_2\">$raintotal</td><td align=\"center \" class=\"inv_plain_3_zebra\">$daystotal</td></tr></table></td>\n\t</tr>\n";
	/*********************************************/
	}
	/* Free resultset */
	mysqli_free_result($result);

	/* Closing connection */
	mysqli_close($link);

	
	}
	?>
	</table>
	<? if (isset( $_POST['submit'])){?>
	<div class="inv_plain_3_zebra" style="padding:1em" align="right" dir="rtl">
	<? echo $SOURCE[$lang_idx]; ?>:<br/>
	אחרי 2001: <? echo $LOGO[$lang_idx]; ?><br/>
	לפני 2001: <? echo $IMS[$lang_idx]; ?><br/>
	1980-2010: ממוצע 30 שנה - ירושלים מרכז (יום גשם 0.1ממ)<br/>
	לפני 2001: יום גשם 1ממ<br/>
	לפני 1999: נמל תעופה עטרות (קצת יותר מירושלים מרכז)<br/>

	<? } ?>
	</div>
</td>
</tr>
</table>

<div class="hr">&nbsp;</div>
<img src="images/rain19552004.jpg">
<img src="images/rain19051954.jpg">
<img src="images/rain18551904.jpg">
<div class="hr">&nbsp;</div>
<div align="center">באדיבות נועם חלפון - נלקח מספרו של דוד עמרן</div>
<div class="hr">&nbsp;</div>
<script language="JavaScript" type="text/javascript">
trMouseOver();
</script>

</BODY>
</HTML>
