<?php
/************************************************************************/	
	// Connecting, selecting database 
	$error = false;
    $link = @mysql_connect("sql-01.portlandpremium.co.uk", "boazn", "bn19za72");
    //   or print($php_errormsg);
    @mysql_select_db("boazn");
	//	   or print($php_errormsg);

	// Update Rainy days and mm on day 
	
	 if ($hour == 23) {
	 	 $rdays = $thisMonth->get_rainydays();$mm = $thisMonth->get_rain();
		 $query = "UPDATE RainSeason SET RainyDays=$rdays, mm=$mm WHERE ((month=$month) and (Year=$year))";
		 $result = @mysql_query($query); 
		  //or print($php_errormsg);
	 }
	 // Update Rainy days and mm on every month start 
	 $prevMonthToUpdate = getPrevMonth($month);$prevMonthYearToUpdate = 
	 if ($day == 1) {
	 	 $rdays = $prevMonth->get_rainydays();$mm = $prevMonth->get_rain();
		 $query = "UPDATE RainSeason SET RainyDays=$rdays, mm=$mm WHERE ((month=$prevMonthToUpdate) and (Year=$yearForPrevMonth))";
		 $result = @mysql_query($query) ;
		  //or print($php_errormsg);
	 }

    // reading current rain situation 
	
	  $query = "SELECT AccRain FROM RainDailyAverage where ((month=$month) and (decade=$decade))";
	  $result = @mysql_query($query) ;
	  //	  or print($php_errormsg);
	  $row = @mysql_fetch_array($result, MYSQLI_ASSOC);
	  $average_rainTillNow = $row["AccRain"];
	    
	  // reading this month's average 
	 
	  $query = "SELECT * FROM average where (month=$month) ";
	  $result = @mysql_query($query) ;
		//   or print($php_errormsg);
	  $row = @mysql_fetch_array($result, MYSQLI_ASSOC) or $error = true;
	  
		$monthAverge = new TimeRange();
		
	  $monthAverge->set_hightemp ($row["HighTemp"]);
	  $monthAverge->set_lowtemp ($row["LowTemp"]);
	  $monthAverge->set_highhum ($row["HighHum"]);
	  $monthAverge->set_lowhum ($row["LowHum"]);
	  $monthAverge->set_rain($row["Rain"]);
	  $monthAverge->set_rainydays($row["RainyDays"]);
	
	  // calculating current rainy days  accumulation
	
	  $query = "SELECT SUM(RainyDays) FROM RainSeason where (season='$current_season') ";
	   $result = @mysql_query($query) ;
	   //   or print($php_errormsg);
	   $row = @mysql_fetch_array($result, MYSQLI_ASSOC) or $error = true;
		 //need to know if today is rainy and the hour is before 23 --> add 1 to the sum
	   $seasonTillNow->set_rainydays($row["SUM(RainyDays)"]);
	 
	  // Free resultset 
	   @mysql_free_result($result);
	
    //Closing connection 
       @mysql_close($link);
	   if (!$error){
		     
	 		 $seasonTillNow->set_raindiffav($seasonTillNow->get_rain() - $average_rainTillNow);
			 $seasonTillNow->set_rainperc (round($seasonTillNow->get_rain()/$average_rainTillNow*100));
			 $thisMonth->set_raindiffav($thisMonth->get_rain() - $monthAverge->get_rain());
			 @$thisMonth->set_rainperc(round($thisMonth->get_rain()/$monthAverge->get_rain()*100));
			 $thisMonth->set_rainydaysdiffav($thisMonth->get_rainydays() - $monthAverge->get_rainydays());
			 $wholeSeason->set_raindiffav($seasonTillNow->get_rain() -  $YearAverage->get_rain());
			 $wholeSeason->set_rainydaysdiffav($seasonTillNow->get_rainydays() - $YearAverage->get_rainydays());
			 $wholeSeason->set_rainperc(round ($seasonTillNow->get_rain()/$YearAverage->get_rain()*100));
			 $hightemp_diffFromAv = $today->get_hightemp() - $monthAverge->get_hightemp();
	 		 $lowtemp_diffFromAv = $today->get_lowtemp() - 	 $monthAverge->get_lowtemp();
	 		 $highhum_diffFromAv = $today->get_highhum() - $monthAverge->get_highhum();
	 		 $lowhum_diffFromAv = $today->get_lowhum() - $monthAverge->get_lowhum();
	  }
	  else {
			 $seasonTillNow->set_raindiffav("MIS"); $seasonTillNow->set_rainperc ("MIS"); $hightemp_diffFromAv = "MIS"; $lowtemp_diffFromAv ="MIS"; $highhum_diffFromAv="MIS"; $lowhum_diffFromAv="MIS";$thisMonth->set_raindiffav("MIS");$thisMonth->set_rainperc("MIS");$thisMonth->set_rainydaysdiffav("MIS");$wholeSeason->set_rainperc("MIS");
	  }
	  /************************************************************************/
?>
<center>
	<b>Compare&nbsp;to<br><a href="station.php?section=averages" class=hlink target="_self">average</a></b></center>
	
	<table width=100% id="mouseover"> 
	    <tr height=1></tr>
		<tr class="topbase">
			<td COLSPAN="4" ALIGN="center">
			<a title="" ALIGN="center" target="_blank" href="javascript:void(0)" class=hlink onclick=tpopup('./images/profile2/RainHistory.gif')>Rain</a>
			</td>
		</tr>
		<tr ALIGN="center" CLASS="smalltbl">
			<td width=35>&nbsp;</td>
			<td title="accumulation in mm"><b>mm</b></td>
			<td title="compared to the mm accumulation till now"><b>%</b></td>
			<td title="number of rainy days"><b>days</b></td>
			
		</tr> 
		
		<tr ALIGN="center" CLASS="smalltbl" height=25>
			<td width=35 title="compared to its decade accumulation from the season start (1/9)"><b>Till<br>now</b></td>
			<td title="mm"><?php if ($seasonTillNow->get_raindiffav() > 0) echo "+"; echo round($seasonTillNow->get_raindiffav());?></td>
			<td title="compared to this month"><?php echo $seasonTillNow->get_rainperc();?></td>
			<td title="rainy days compared to current situation">&nbsp;</td>
		</tr>
		
		<tr ALIGN="center" CLASS="smalltbl" height=25>
			<td width=35 title="This month's rain"><b>Month</b></td>
			<td title="mm"><?php if ($thisMonth->get_raindiffav() > 0) echo "+"; echo round($thisMonth->get_raindiffav());?></td>
			<td><?php echo $thisMonth->get_rainperc(); ?></td>
			<td title="the average is not a whole number"><?php if ($thisMonth->get_rainydaysdiffav() > 0) echo "+"; echo $thisMonth->get_rainydaysdiffav();?></td>
			
		</tr>
		<tr ALIGN="center" CLASS="smalltbl" height=25>
			<td width=35 title="This season's rain"><b>Total</b></td>
			<td title="mm compared to the whole season"><?php if ($wholeSeason->get_raindiffav() >0) echo "+";echo round($wholeSeason->get_raindiffav()); ?></td>
			<td title="% comparison to whole season"><?php echo $wholeSeason->get_rainperc() ; ?></td>
			<td title="rainy days compared to the whole season"><?php if ($wholeSeason->get_rainydaysdiffav() >0) echo "+";echo $wholeSeason->get_rainydaysdiffav();?></td>
		</tr>
	</table>
	<table width="100%">
		<tr class="topbase">
			<td COLSPAN="3" ALIGN="center" class=hlink>Temp</td>
		</tr>
		<tr ALIGN="center" VALIGN="center" CLASS="tbl">
			<td>
				<a title="High temp today compared to its month's High temp average" align=center target="_blank" >High Temp</a>
			</td>
			<td>
				<?php if ($hightemp_diffFromAv > 0) echo "<font class=high>+";
							else
									echo "<font class=low>";
							echo $hightemp_diffFromAv,$current->get_tempunit(),"</font>";?>
			</td>
		</tr>
		<tr ALIGN="center" VALIGN="center" CLASS="tbl">
			<td>
				<a title="Low temp today compared to its month's low temp average" align=center target="_blank" >Low Temp</a>
			</td>
			<td>
				<?php if ($lowtemp_diffFromAv > 0) echo "<font class=high>+";
							else
									echo "<font class=low>";
							echo $lowtemp_diffFromAv,$current->get_tempunit(),"</font>";?>
			</td>
		</tr>
	</table>
	<table width=100%>
		<tr class="topbase">
			<td COLSPAN="3" ALIGN="center" class=hlink>Humidity</td>
		</tr>
		<tr ALIGN="center" VALIGN="center" CLASS="tbl">
			<td width=50%>
				<a title="High hum today compared to its month's High Hum average" align=center target="_blank" >High Hum</a>
			</td>
			<td width=50%>
				<?php if ($highhum_diffFromAv > 0) echo "+"; echo $highhum_diffFromAv,"%";?>
			</td>
		</tr>
		<tr ALIGN="center" VALIGN="center" CLASS="tbl">
			<td>
				<a title="Low Hum today compared to its month's Low Hum average" align=center target="_blank" >Low Hum</a>
			</td>
			<td>
				<?php if ($lowhum_diffFromAv > 0) echo "+"; echo $lowhum_diffFromAv,"%";?>
			</td>
		</tr>
	</table>
	