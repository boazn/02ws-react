<div style="display:inline-block;padding:0;margin:0;width:12%;float:<?echo get_s_align();?>" id="leftCol" >
<table summary="" width="100%" <? if (isHeb()) echo "dir=\"rtl\""; ?> id="compareToYesterday">
	<tr border="0">
			<td colspan="2" class="toptbl">
				<? echo($DIFF_FROM[$lang_idx]);?> <a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=reports/downld02.txt" ><? echo($YESTERDAY[$lang_idx]);?></a><br /><?php  echo $yestsametime->get_time(); ?> 

			</td>
	</tr>
	<tr>
	<td class="box">
		<table width="100%">
		<tr class="smalltbl tbl">
			<td title="change in temparture from yesterday same time" >
			<fieldset style="width:90%">
				<legend>
					<a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph&amp;graph=OutsideTempHistory&amp;profile=<? echo $profile;?>" title="show graph" onmouseover="showImage('OutsideTempHistory')" onmouseout="hideImage()"  class="hlink">
						<? echo($CHANGE[$lang_idx]);?> <? echo($TEMP[$lang_idx]);?>
					</a>
				</legend>
				<b><? echo (get_param_tag($yestsametime->get_tempchange())),"&#176;C";?>
				</b>
			</fieldset>
			</td>
		</tr>
		<tr class="smalltbl tbl">
			<td title="change in humidity from yesterday same time" >
				<fieldset style="width:90%">
					<legend>
						<a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph&amp;graph=OutsideHumidityHistory&amp;profile=<? echo $profile;?>" onmouseover="showImage('OutsideHumidityHistory')" onmouseout="hideImage()"  class="hlink" alt="show graph">
							<? echo($CHANGE[$lang_idx]);?> <? echo($HUMIDITY[$lang_idx]);?> 
						</a>
					</legend>
					<? echo (get_img_tag($yestsametime->get_humchange())),abs($yestsametime->get_humchange()),"%"; ?>
				</fieldset>
			
			</td>
		</tr>
		<tr class="smalltbl tbl">
			<td title="change in wind speed from yesterday same time" >
				<fieldset style="width:90%">
					<legend>
						<a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph&amp;graph=WindSpeedHistory&amp;profile=<? echo $profile;?>"  onmouseover="showImage('WindSpeedHistory')" onmouseout="hideImage()"  class="hlink"  alt="show graph">
							<? echo($CHANGE[$lang_idx]);?> <? echo($WIND[$lang_idx]);?> 
						</a> 
					</legend>
					<? echo (get_img_tag($yestsametime->get_windspdchange())),abs($yestsametime->get_windspdchange()),"Kt";?>
				</fieldset>
			</td>
		</tr>
		<tr class="smalltbl tbl" >
			<td title="change in wind dir from yesterday same time" >
				<fieldset style="width:90%">
					<legend>
					<a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph&amp;graph=WindDirectionHistory&amp;profile=<? echo $profile;?>"  onmouseover="showImage('WindDirectionHistory')" onmouseout="hideImage()"  class="hlink" alt="show graph">
						<? echo($CHANGE[$lang_idx]);?> <? echo($WIND[$lang_idx]);?> 
					</a>
					</legend>
					<? echo $yestsametime->get_winddir()?>&nbsp;<img alt="became to" src="images/arroww.gif" /><? echo $current->get_winddir();?>
				</fieldset>
			 
			</td>
		</tr>
		<tr title="change in pressure from yesterday same time" class="smalltbl tbl">
			<td title="change in pressure from yesterday same time" >
				<fieldset style="width:90%">
					<legend>
						<a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph&amp;graph=BarometerHistory&amp;profile=<? echo $profile;?>"  onmouseover="showImage('BarometerHistory')" onmouseout="hideImage()"  class="hlink" alt="show graph">
							<? echo($CHANGE[$lang_idx]);?> <? echo($BAR[$lang_idx]);?> 
						</a>
					</legend>
					<? echo (get_img_tag($yestsametime->get_prschange()))."&nbsp;",abs($yestsametime->get_prschange()),"mb"?>
				</fieldset>
			</td>
		</tr>
		<tr>
			<td class="tbl">
				
						<a href="#" title="<? if (isHeb()) echo "טמפרטורה היום בהשוואה למקסימום ומינימום של אתמול"; else echo "temp today compared to yestarday max/min";?>">
							<? echo($TEMP[$lang_idx]);?>
						</a>
						&nbsp;<img src="images/thermometer.gif" height="25" width="35" alt="" />
					</legend>
					<? echo($MAX[$lang_idx]);?>&nbsp;
					<a href="#" title="<? echo($TODAY[$lang_idx]);?> <? echo $today->get_hightemp()."&#176;C";?> - <? echo($YESTERDAY[$lang_idx]);?> <?echo $yest->get_hightemp()."&#176;C";?>">
						<? echo get_param_tag($today->get_hightemp() - $yest->get_hightemp())."&#176;C";?>
						
					</a>
					<br/>
					<? echo($MIN[$lang_idx]);?>&nbsp;
					<a href="#" title="<? echo($TODAY[$lang_idx]);?> <? echo $today->get_lowtemp(),"&#176;C";?> - <? echo $YESTERDAY[$lang_idx]." ".$yest->get_lowtemp(),"&#176;C";?> ">
						<? echo get_param_tag($today->get_lowtemp() - $yest->get_lowtemp())."&#176;C";?>
						
					</a>
				
			</td>
		</tr>
		</table>
		
		<!--<table width=100%>
		<tr class="toptbl">
			<td colspan="3" class=small>Humidity</td>
		</tr>
		<tr class="tbl">
			<td width=50% title="Max hum till now compared to yesterday's Max Hum" >Max Hum</td>
			<td width=50%>
			<a href="" class=info>
				<?php if(($today->get_highhum() - $yest->get_highhum()) > 0)
					echo("+");
				echo ($today->get_highhum() - $yest->get_highhum()),"%";?>
			</a>
			</td>
		</tr>
		<tr class="tbl">
			<td title="Low Hum till now compared to yesterday's low Hum">Low Hum</td>
			<td>
			<a href="" class=info>
				<?php if (($today->get_lowhum() - $yest->get_lowhum()) > 0)
					echo("+");
				echo ($today->get_lowhum() - $yest->get_lowhum()),"%";?>
		   </a>
			</td>
		</tr>
		 </table>-->
	</td>
	</tr>
</table>
<table width="100%" >
        <tr>
        <td class="toptbl">
        <? echo($SPECIAL_NOTICE[$lang_idx]);?>
        </td>
        </tr>
        <tr class="inv"><td class="box">
		<object type="application/x-shockwave-flash" data="TextTicker.swf" width="100%" height="180">
			<param name="wmode" value="transparent" />
			<param name="movie" value="TextTicker.swf" />
		</object>	
        </td></tr>
</table>
</div>
    