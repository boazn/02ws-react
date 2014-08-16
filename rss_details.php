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
		<title><? echo $date;?> <? echo $TEMP[$EN];?></title>
		<link><? echo BASE_URL; ?></link>
		<description><? echo $current->get_temp();?><? echo $current->get_tempunit(); ?></description>
		<content:encoded>
		</content:encoded>
		<author><? echo EMAIL_ADDRESS;?></author>
		<guid><? echo BASE_URL; ?>/station.php#webCamera</guid>
	</item>
	<item>
		<title><? echo $HUMIDITY[$EN];?>: <? echo $current->get_hum();?>%</title>
		<link><? echo BASE_URL; ?></link>
		<description><? echo $current->get_hum();?>%</description>
		<content:encoded>
		</content:encoded>
		<author><? echo EMAIL_ADDRESS;?></author>
		<guid><? echo BASE_URL; ?>/station.php#OutsideHumidityHistory</guid>
	</item>
	<item>
		<title><? echo $DAILY_RAIN[$EN].": ".$today->get_rain(); ?>mm</title>
		<link><? echo BASE_URL; ?></link>
		<description><? echo $DAILY_RAIN[$EN].": ".$today->get_rain(); ?>mm</description>
		<content:encoded>
		</content:encoded>
		<author><? echo EMAIL_ADDRESS;?></author>
		<guid><? echo BASE_URL; ?>/station.php#OutsideRainHistory</guid>
	</item>
	<item>
		<title>Jerusalem sun rise:  <? echo $sunrise;?> sun set: <? echo $sunset;?></title>
		<link><? echo BASE_URL; ?></link>
		<description>Jerusalem: <? echo $HUMIDITY[$EN];?>: <? echo $current->get_hum();?>% <? echo $DAILY_RAIN[$EN].": ".$today->get_rain(); ?>mm</description>
		<content:encoded>
		<![CDATA[
		]]>
		</content:encoded>
		<author><? echo EMAIL_ADDRESS;?></author>
		<guid><? echo BASE_URL; ?>/station.php</guid>
	</item>
</channel>
</rss>
<? include "end_caching.php"; ?>