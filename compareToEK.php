<?
$currentEK = new FixedTime();
$todayEK = new TimeRange(); 
//////////////////////////////////////////////
// parsing XML data
//////////////////////////////////////////////
// Array to store current xml path    
$ary_path = array();    
// Array to store parsed data    
$ary_parsed_file = array();    
// Starting level - Set to 0 to display all levels. Set to 1 or higher    
// to skip a level that is common to all the fields.    
$int_starting_level = 2; 
$ary_parsed_file = getXMLInArray("http://proxy.maabarot.org.il/~EinKarem/weather/fulldata.xml");
//////////////////////////////////////////////
// filling with XML data
//////////////////////////////////////////////
$currentEK->set_date($ary_parsed_file['DATE']);    
$currentEK->set_time($ary_parsed_file['TIME']);      
$currentEK->set_temp($ary_parsed_file['OUTSIDETEMP']);   
$todayEK->set_hightemp($ary_parsed_file['HIOUTSIDETEMP'],$ary_parsed_file['HIOUTSIDETEMPTIME']);    
$todayEK->set_lowtemp($ary_parsed_file['LOWOUTSIDETEMP'],$ary_parsed_file['LOWOUTSIDETEMPTIME']);
$currentEK->set_hum($ary_parsed_file['OUTSIDEHUMIDITY']);    
$todayEK->set_highhum($ary_parsed_file['HIHUMIDITY'],$ary_parsed_file['HIHUMTIME']);    
$todayEK->set_lowhum($ary_parsed_file['LOWHUMIDITY'],$ary_parsed_file['LOWHUMTIME']);    
$currentEK->set_pressure($ary_parsed_file['BAROMETER']);    
$currentEK->set_winddir($ary_parsed_file['WINDDIRECTION']);    
$currentEK->set_windspd($ary_parsed_file['WINDSPEED']); 
$currentEK->set_cloudbase((($currentEK->get_temp()-$currentEK->get_dew())* 125) + ELEVATION);
$currentEK->set_windchill($ary_parsed_file['WINDCHILL']);
$currentEK->set_heatidx($ary_parsed_file['OUTSIDEHEATINDEX']);
$currentEK->set_rainrate($ary_parsed_file['RAINRATE']);
$todayEK->set_highrainrate($ary_parsed_file['HIRAINRATE'],$ary_parsed_file['HIRAINRATETIME']);  
$todayEK->set_lowwindchill($ary_parsed_file['LOWWINDCHILL'],$ary_parsed_file['LOWWINDCHILLTIME']);
$todayEK->set_highheatindex($ary_parsed_file['HIHEATINDEX'],$ary_parsed_file['HIHEATINDEXTIME']);
$todayEK->set_highbar($ary_parsed_file['HIBAROMETER'],$ary_parsed_file['HIBAROMETERTIME']);    
$todayEK->set_lowbar($ary_parsed_file['LOWBAROMETER'],$ary_parsed_file['LOWBAROMETERTIME']); 
$hourEK = (int)strtok($currentEK->get_time(), ":");
$windUnitsEK = $ary_parsed_file['WINDUNIT'];
//if ($currentEK->get_date() != $current->get_date()) return false;
if ($hourEK != $hour) return false;
?>

	
<tr class="smalltbl" id="mouseover">
	
	<td class="grad">
	<fieldset style="padding:0.5em"><legend><a href="http://weather.maabarot.org.il/~EinKarem/weather/<?=basename($_SERVER['PHP_SELF'])?>" align="right" title="לאתר"><? echo $EIN_KEREM[$lang_idx];?></a></legend>
	<a class="info" href="#">
		<? echo $currentEK->get_temp(),"&#176;C";?>
		<span class="info" style="width:12em">
		<table <? if (isHeb()) echo "dir=\"rtl\""; ?> class="tbl">
		<tr>
			<td class="toptbl"><? echo "".$todayEK->get_hightemp_time().""; ?></td>
			<td><? echo $HIGH[$lang_idx].": "; ?></td>
			<td class="high"><? echo toLeft($todayEK->get_hightemp()."&#176;C"); ?></td>
		</tr>
		<tr>
			<td class="toptbl"><? echo "".$todayEK->get_lowtemp_time()." "; ?></td>
			<td><? echo $LOW[$lang_idx].": "; ?></td>
			<td class="low"><? echo toLeft($todayEK->get_lowtemp()."&#176;C"); ?></td>
		</tr>
		</table>
		</span>
	</a>
	</fieldset> 
	</td>
	<td class="grad">
	<fieldset style="padding:0.5em"><legend><a href="http://weather.maabarot.org.il/~EinKarem/weather/<?=basename($_SERVER['PHP_SELF'])?>" align="right" title="לאתר"><? echo $EIN_KEREM[$lang_idx];?></a></legend>
	<a class="info" href="#">
		<? echo $currentEK->get_hum(),"%";?>
		<span <? if (isHeb()) echo "dir=\"rtl\""; ?> class="info" style="width:12em">
		<table <? if (isHeb()) echo "dir=\"rtl\""; ?> class="tbl" >
			<tr>
				<td class="toptbl"><? echo "".$todayEK->get_highhum_time().""; ?></td>
				<td><? echo $HIGH[$lang_idx].": "; ?></td>
				<td><? echo $todayEK->get_highhum(); ?>%</td>
			</tr>
			<tr>
				<td class="toptbl"><? echo "".$todayEK->get_lowhum_time().""; ?></td>
				<td><? echo $LOW[$lang_idx].": "; ?></td>
				<td><? echo $todayEK->get_lowhum(); ?>%</td>
			</tr>
		</table>
		</span>
	</a>
	</fieldset> 
	</td>
	<td class="grad">
	<fieldset style="padding:0.5em"><legend><a href="http://weather.maabarot.org.il/~EinKarem/weather/<?=basename($_SERVER['PHP_SELF'])?>" align="right" title="לאתר"><? echo $EIN_KEREM[$lang_idx];?></a></legend>
	<a class=info href="#">
		<? echo $currentEK->get_pressure(),"mb";?>
		<span <? if (isHeb()) echo "dir=\"rtl\""; ?> class="info" style="width:12em">
		<table <? if (isHeb()) echo "dir=\"rtl\""; ?> class="tbl">
	<tr>
		<td class="toptbl"><? echo "".$todayEK->get_highbar_time().""; ?></td>
		<td><? echo $HIGH[$lang_idx].": "; ?></td>
		<td><? echo $todayEK->get_highbar(); ?>mb</td>
	</tr>
	<tr>
		<td class="toptbl"><? echo "".$todayEK->get_lowbar_time().""; ?></td>
		<td><? echo $LOW[$lang_idx].": "; ?></td>
		<td><? echo $todayEK->get_lowbar(); ?>mb</td>
	</tr>
	</table>
	</span>
	</a>
	</fieldset> 
	</td>
	<td class="grad">
	<fieldset style="padding:0.5em"><legend><a href="http://weather.maabarot.org.il/~EinKarem/weather/<?=basename($_SERVER['PHP_SELF'])?>" align="right" title="לאתר"><? echo $EIN_KEREM[$lang_idx];?></a></legend>
	<a class="info" href="#" <? if (isHeb()) echo "dir=\"rtl\""; ?>>
			<? echo $currentEK->get_winddir();?>
			<span class="info"><? echo $HIGH[$lang_idx].": ".$todayEK->get_highwind()." ".$windUnitsEK." ".$ON[$lang_idx]." ".$todayEK->get_highwind_time(); ?></span>
			&nbsp;
			<? echo $currentEK->get_windspd()." ".$windUnitsEK;?>
			
			
	</a>
	</fieldset> 
	</td>
	<td class="grad">
	<fieldset style="padding:0.5m"><legend><a href="http://weather.maabarot.org.il/~EinKarem/weather/<?=basename($_SERVER['PHP_SELF'])?>" align="right" title="לאתר"><? echo $EIN_KEREM[$lang_idx];?></a></legend> 
	<a class="info" href="#">
		<? echo $currentEK->get_rainrate(),"mm/hr";?>
		<span style="top:4em" <? if (isHeb()) echo "dir=\"rtl\""; ?> class="info"><? echo $HIGH[$lang_idx].": ".$todayEK->get_highrainrate(); ?>mm/hr&nbsp;<? echo $ON[$lang_idx]." ".$todayEK->get_highrainrate_time(); ?></span>
	</a>
	 </fieldset> 
	</td>
</tr>