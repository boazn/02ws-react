<?php
$is_xml = true;
include "begin_caching.php";
include "start.php";
include_once ("requiredDBTasks.php");
//logger("rss_forecast read");
?>
<? header("Content-type: text/xml"); ?>
<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/">
<channel>
	<title><? echo $LOGO[$EN]; ?></title>
	<link><? echo BASE_URL; ?></link>
	<description><? echo $UPDATES_INTERVAL[$EN];?></description>
	<language>en-us</language>
	<docs><? echo BASE_URL; ?></docs>
	<generator>Boaz Nechemia</generator>
	<managingEditor><? echo EMAIL_ADDRESS;?></managingEditor>
	<webMaster><? echo EMAIL_ADDRESS;?></webMaster>
	<ttl><? echo INTERVAL;?></ttl>
	<image>
	<width>144</width>
	<height>50</height>
	<url><? echo BASE_URL; ?>/<? echo $header_pic;?></url>
	<title>Jerusalem Live Pic</title>
	<link><? echo BASE_URL; ?>/station.php?section=webCamera.jpg</link>
	</image>
	<item>
		<title><? echo $date;?> <? echo $current->get_temp();?>&#176;C</title>
		<link><? echo BASE_URL; ?></link>
		<description>
				02ws.co.il 
		 </description>
		<content:encoded>
		<![CDATA[ <table <? echo get_align(); ?> <? if (isHeb()) echo "dir=\"rtl\""; ?> style="border-spacing: 0;padding:1em 0.2em" cellpadding="4" id="tableForecastNextDays" cellspacing="2">
				<tr style="height:5px" >
				<td width="100px" class="small" style="padding:0"><? echo $DATE[$lang_idx];?></td>
				<td width="50px" style="padding:0 0.5em" class="small" <? echo get_align(); ?>><? echo $MIN[$lang_idx];?></td>
				<td width="60px" style="padding:0 0.5em" class="small" <? echo get_align(); ?>><? echo $MAX[$lang_idx]." <span dir=\"ltr\">".$current->get_tempunit()."</span>";?></td>
				<td width="35px"></td>
				<td width="50%"></td>
				</tr>
				<? if  (count($forecastDaysDB) == 0) 
					{
						echo $frcstTable;
						echo "<tr style=\"height:5px\"><td colspan=\"4\">".$SOURCE[$lang_idx].": ".$IMS[$lang_idx]."</td></tr>";	

					}
					else 
					{
						//print_r($forecastDaysDB);
						
						for ($i = 0; $i < count($forecastDaysDB); $i++) 
						{
						if ($i % 2 == 1)
							$class =  " class=\"inv_plain_3_zebra\" ";
						else
							$class =  " class=\"inv_plain_3_minus\" ";
						?>
						<tr <?=$class?> style="height:<?=180/count($forecastDaysDB)?>px" id="day<?=$i+1?>">
						<td><?echo replaceDays($forecastDaysDB[$i]['day_name']." ")." ".$forecastDaysDB[$i]['date'];?></td>
						<td class="low" dir="ltr" id="lowtemp<?=$i+1?>" style="padding:0 1em" <? echo get_align(); ?>><?=c_or_f($forecastDaysDB[$i]['TempLow'])?></td>
						<td class="high" dir="ltr" id="hightemp<?=$i+1?>" style="padding:0 1em" <? echo get_align(); ?>><?=c_or_f($forecastDaysDB[$i]['TempHigh'])?></td>
						<td align="center" ><img id="icon<?=$i+1?>" src="<? echo "images/icons/day/".$forecastDaysDB[$i]['icon']; ?>" width="35px" title="<? if (isHeb()) $dscpIdx = "lang1"; else $dscpIdx = "lang0"; echo urldecode($forecastDaysDB[$i][$dscpIdx]);?>"/></td>
						<td id="desc<?=$i+1?>" style="padding:0 0.4em 0 0.4em"><? if (isHeb()) $dscpIdx = "lang1"; else $dscpIdx = "lang0"; echo urldecode($forecastDaysDB[$i][$dscpIdx]);?></td>
						</tr>
						<? }
					}
				?>
				
				</table>]]>
		</content:encoded>
		<author><? echo EMAIL_ADDRESS;?></author>
		<guid><? echo BASE_URL; ?></guid>
	</item>
	<? for ($i = 0; $i < count($forecastDaysDB); $i++) 
	{
	
	?>
	<item>
        <link><? echo BASE_URL; ?>/small.php</link>
	<guid><? echo BASE_URL; ?></guid>
	<title><?echo replaceDays($forecastDaysDB[$i]['day_name']." ")." ".$forecastDaysDB[$i]['date'];?>: <?=c_or_f($forecastDaysDB[$i]['TempLow'])?> <?=c_or_f($forecastDaysDB[$i]['TempHigh'])?></title>
	<description> <? if (isHeb()) $dscpIdx = "lang1"; else $dscpIdx = "lang0"; echo urldecode($forecastDaysDB[$i][$dscpIdx]);?></description>
	</item>
	<? } ?>
</channel>
</rss>
<? include "end_caching.php"; ?>