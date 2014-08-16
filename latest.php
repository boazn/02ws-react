<?
include_once("lang.php");
include_once("include.php"); 
?>
<h1><? echo $ALL_GRAPHS[$lang_idx]." - ".$TODAY[$lang_idx];?></h1>
<table style="width:100%">
<tr>
		<td style="<? if (isHeb()) echo "direction:rtl"; ?>">
			<a href="station.php?section=graph&graph=OutsideTempHistory&profile=1" ><img width="410px" src="./images/profile1/OutsideTempHistory.<?=IMAGE_TYPE?>" alt="latest Outside Temp"><br /> <span class="high"> <? echo $HIGH[$lang_idx].": "; ?> <? echo toLeft($today->get_hightemp()."<? echo $current->get_tempunit(); ?>"); ?></span>&nbsp;&nbsp;<span class="low"><? echo $LOW[$lang_idx].": "; ?> <? echo toLeft($today->get_lowtemp()."<? echo $current->get_tempunit(); ?>"); ?></span><br />
			<span class="low"><? echo $WIND_CHILL[$lang_idx]; ?>: <? echo $LOW[$lang_idx].": ".toLeft($today->get_lowwindchill())."<? echo $current->get_tempunit(); ?> ".$ON[$lang_idx]." ".$today->get_lowwindchill_time(); ?></span><br />
			<span class="high"><? echo $HEAT_IDX[$lang_idx]; ?>: <? echo $HIGH[$lang_idx].": ".$today->get_highheatindex()."<? echo $current->get_tempunit(); ?> ".$ON[$lang_idx]." ".$today->get_highheatindex_time(); ?></span></img></a>
		</td>
		<td style="<? if (isHeb()) echo "direction:rtl"; ?>">
			<a href="station.php?section=graph&graph=BarometerHistory&profile=1" ><img width="410px" src="./images/profile1/BarometerHistory.<?=IMAGE_TYPE?>" alt="latest Barometer"><br /><? echo $HIGH[$lang_idx].": ".$today->get_highbar();?>mb&nbsp;&nbsp;<? echo $LOW[$lang_idx].": ".$today->get_lowbar();?>mb<br /><br /><br /></a>
		</td>
</tr>
<tr>
		
		<td style="<? if (isHeb()) echo "direction:rtl"; ?>">
			<a href="station.php?section=graph&graph=OutsideHumidityHistory&profile=1" ><img width="410px" src="./images/profile1/OutsideHumidityHistory.<?=IMAGE_TYPE?>" alt="latest Outside Humidity"><br /><span class="high" style="<? if (isHeb()) echo "direction:rtl"; ?>"><? echo "[".$today->get_highhum_time()."] ".$HIGH[$lang_idx].": ".$today->get_highhum(); ?>%</span>&nbsp;&nbsp;<span class="low" ><? echo "[".$today->get_lowhum_time()."] ".$LOW[$lang_idx].": ".$today->get_lowhum(); ?>%</span></img></a>
		</td>
		<td style="<? if (isHeb()) echo "direction:rtl"; ?>">
			<a href="station.php?section=graph&graph=DewPointHistory&profile=1"><img width="410px" src="./images/profile1/DewPointHistory.<?=IMAGE_TYPE?>" alt="latest Dew Point"><br /><span class="high"><? echo $HIGH[$lang_idx].": ".$today->get_highdew(); ?><? echo $current->get_tempunit(); ?></span><span class="low">&nbsp;&nbsp;<? echo $LOW[$lang_idx].": ".$today->get_lowdew(); ?><? echo $current->get_tempunit(); ?></span></img></a>
		</td>
</tr>
<tr>
		
		<td style="<? if (isHeb()) echo "direction:rtl"; ?>">
			<a href="station.php?section=graph&graph=HiWindSpeedHistory&profile=1"><img width="410px" src="./images/profile1/HiWindSpeedHistory.<?=IMAGE_TYPE?>" alt="latest High Wind"><br /><span ><? echo $HIGH[$lang_idx].": ".$today->get_highwind()." ".$KNOTS[$lang_idx]." ".$ON[$lang_idx]." ".$today->get_highwind_time(); ?></span></img></a>
		</td>
		<td>
			<a href="station.php?section=graph&graph=WindDirectionHistory&profile=1"><img width="410px" src="./images/profile1/WindDirectionHistory.<?=IMAGE_TYPE?>" alt="latest Wind Direction"></img></a>
		</td>
</tr>
<tr>
		<td>
			<a href="station.php?section=graph&graph=WindSpeedHistory&profile=1"><img width="410px" src="./images/profile1/WindSpeedHistory.<?=IMAGE_TYPE?>" alt="latest Wind speed"></img></a>
		</td>
		<td>
			<a href="station.php?section=graph&graph=HighWindDirHistory&profile=1"><img width="410px" src="./images/profile1/HighWindDirHistory.<?=IMAGE_TYPE?>" alt="latest High Wind Dir"></img></a>
		</td>
</tr>
<tr>
		 
		<td>
			<a href="station.php?section=graph&graph=RainHistory&profile=1"><img width="410px" src="./images/profile1/RainHistory.<?=IMAGE_TYPE?>" alt="latest Rain"></img></a>
		</td>
		<td style="<? if (isHeb()) echo "direction:rtl"; ?>">
			<a href="station.php?section=graph&graph=RainRateHistory&profile=1"><img width="410px" src="./images/profile1/RainRateHistory.<?=IMAGE_TYPE?>" alt="latest Rain Rate"><br />High Rain Rate: <span>0.0&nbsp;mm/hr&nbsp; &nbsp;at&nbsp;&nbsp;----</span></img></a>
		</td>
</tr>
<tr>
		
		<td>
			<a href="station.php?section=graph&graph=EMCHistory&profile=1"><img width="410px" src="./images/profile1/EMCHistory.<?=IMAGE_TYPE?>" alt="latest EMC"></img></a>
		</td>
		<td>
			<a href="station.php?section=graph&graph=THWHistory&profile=1"><img width="410px" src="./images/profile1/THWHistory.<?=IMAGE_TYPE?>" alt="latest THW"></img></a><br />
		</td>
</tr>
<tr>
		
		<td>
			<a href="station.php?section=graph&graph=AirDensityHistory&profile=1"><img width="410px" src="./images/profile1/AirDensityHistory.<?=IMAGE_TYPE?>" alt="latest Air density"></img></a>
		</td>
</tr>

</table>
</div>
