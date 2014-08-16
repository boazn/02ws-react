<?php
$is_xml = true;
include "begin_caching.php";
include "start.php";
getRadioData();
?>
<? header("Content-type: text/xml"); ?>
<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/">
<channel>
	<title><? echo $LOGO[$EN]; ?></title>
	<link><? echo BASE_URL; ?></link>
	<description><? echo $UPDATES_INTERVAL[$EN];?></description>
	<language>en-us</language>
	<docs><? echo BASE_URL; ?>/station.php</docs>
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
		<title><? echo $current->get_temp();?><? echo $current->get_tempunit(); ?></title>
		<link><? echo BASE_URL; ?></link>
		<description>Latest Data from Jerusalem on <? echo $date;?></description>
		<content:encoded>
		<![CDATA[
		<table><tr><td><? echo $ELEVATION[$EN]." ".ELEVATION ; ?>m</td></tr>
		<tr><td><? echo $date;?></td></tr>
		<tr><td> <? echo $TEMP[$EN];?> <? echo $current->get_temp();?><font size="-1"><? echo $current->get_tempunit(); ?></font> </td><td><img src="<? echo BASE_URL; ?>/images/profile1/OutsideTempHistory.<?=IMAGE_TYPE?>"></img></td></tr>
		<tr><td> 
		<table align="center">
			<tr>
				<td class="topbase"><? echo "[".$today->get_hightemp_time()."] "; ?></td>
				<td><? echo $HIGH[$EN].": "; ?></TD>
				<td class="high"><? echo $today->get_hightemp()."<? echo $current->get_tempunit(); ?>"; ?></td>
			</tr>
			<tr>
				<td class="topbase"><? echo "[".$today->get_lowtemp_time()."] "; ?></td>
				<td><? echo $LOW[$EN].": "; ?></td>
				<td class="low"><? echo $today->get_lowtemp()."<? echo $current->get_tempunit(); ?>"; ?></td>
			</tr>
		</table>
		</td></tr>
		<tr><td> <? echo $HUMIDITY[$EN];?> <? echo $current->get_hum();?><font size="-1">%</font>  </td><td><img src="<? echo BASE_URL; ?>/images/profile1/OutsideHumidityHistory.<?=IMAGE_TYPE?>"></img></td></tr>
		<tr><td></td></tr>
		<tr><td> 
				<table <? if (isHeb()) echo "DIR=rtl"; ?> align="center">
				<tr>
					<td class="topbase"><? echo "[".$today->get_highhum_time()."] "; ?></td>
					<td><? echo $HIGH[$EN].": "; ?></td>
					<td><? echo $today->get_highhum(); ?>%</td>
				</TR>
				<TR>
					<td class="topbase"><? echo "[".$today->get_lowhum_time()."] "; ?></td>
					<td><? echo $LOW[$EN].": "; ?></td>
					<td><? echo $today->get_lowhum(); ?>%</td>
				</tr>
				</table>
		</td></tr>
		<tr><td> <? echo $BAR[$EN];?> <? echo $current->get_pressure();?><font size="-2">mb</font> </td></tr>
		<tr><td> <? echo $WIND[$EN];?> <? echo $current->get_windspd()." ".$windUnits;?>  <font size="-2"><? echo $current->get_winddir();?></font> </td></tr>
		<tr><td><? echo $DAILY_RAIN[$EN].": ".$today->get_rain(); ?>mm </td></tr>
		<tr><td>sun rise:  <? echo $sunrise;?> sun set: <? echo $sunset;?> </td></tr>
		</table>
		]]>
		</content:encoded>
		<author><? echo EMAIL_ADDRESS;?></author>
		<guid><? echo BASE_URL; ?>/station.php</guid>
	</item>
</channel>
</rss>
<? include "end_caching.php"; ?>