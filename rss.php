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
		<title><? echo $date;?> <? echo $current->get_temp();?><? echo $current->get_tempunit(); ?></title>
		<link><? echo BASE_URL; ?></link>
		<description>Jerusalem: <? echo $TEMP[$EN];?> <? echo $current->get_temp();?> ; <? echo "[".$today->get_hightemp_time()."] "; ?> <? echo $HIGH[$EN].":"; ?> <? echo $today->get_hightemp().$current->get_tempunit(); ?> ; <? echo "[".$today->get_lowtemp_time()."] "; ?> <? echo $LOW[$EN].":"; ?> <? echo $today->get_lowtemp().$current->get_tempunit(); ?></description>
		<content:encoded>
		<![CDATA[
		<br /><? echo $ELEVATION[$EN]." ".ELEVATION ; ?>m<br />
		<? echo $date;?><br />
		<img src="<? echo BASE_URL; ?>/images/profile1/OutsideTempHistory.<?=IMAGE_TYPE?>"></img><br />
		<br /> 
		<? echo $BAR[$EN];?> <? echo $current->get_pressure();?>mb <br />
		<? echo $WIND[$EN];?> <? echo $current->get_windspd()." ".$windUnits;?><? echo $current->get_winddir();?><br />
				
		]]>
		</content:encoded>
		<author><? echo EMAIL_ADDRESS;?></author>
		<guid><? echo BASE_URL; ?>/station.php#webCamera</guid>
	</item>
	<item>
		<title><? echo $HUMIDITY[$EN];?>: <? echo $current->get_hum();?>%</title>
		<link><? echo BASE_URL; ?></link>
		<description>Jerusalem: <? echo $HUMIDITY[$EN];?>: <? echo "[".$today->get_highhum_time()."] "; ?> <? echo $HIGH[$EN].":"; ?> <? echo $today->get_highhum(); ?>% ; 
		<? echo "[".$today->get_lowhum_time()."] "; ?> <? echo $LOW[$EN].": "; ?> <? echo $today->get_lowhum(); ?>%</description>
		<content:encoded>
		<![CDATA[
		<br /><? echo $ELEVATION[$EN]." ".ELEVATION ; ?>m<br />
		<? echo $date;?><br />
		<img src="<? echo BASE_URL; ?>/images/profile1/OutsideHumidityHistory.<?=IMAGE_TYPE?>"></img>
		
		]]>
		</content:encoded>
		<author><? echo EMAIL_ADDRESS;?></author>
		<guid><? echo BASE_URL; ?>/station.php#OutsideHumidityHistory</guid>
	</item>
	<item>
		<title><? echo $DAILY_RAIN[$EN].": ".$today->get_rain(); ?> mm</title>
		<link><? echo BASE_URL; ?></link>
		<description><? echo $DAILY_RAIN[$EN].": ".$today->get_rain(); ?> mm</description>
		<content:encoded>
		<![CDATA[
		<? echo $date;?><br />
		<img src="<? echo BASE_URL; ?>/images/profile1/RainHistory.<?=IMAGE_TYPE?>"></img>
		
		
		]]>
		</content:encoded>
		<author><? echo EMAIL_ADDRESS;?></author>
		<guid><? echo BASE_URL; ?>/station.php#OutsideRainHistory</guid>
	</item>
	<item>
		<title><? echo $RADIATION[$EN].": ".$current->get_solarradiation(); ?>W/m2</title>
		<link><? echo BASE_URL; ?></link>
		<description><? echo $RADIATION[$EN];?> <? echo $current->get_solarradiation();?></description>
		<content:encoded>
		<![CDATA[
		<? echo $date;?><br />
		<img src="<? echo BASE_URL; ?>/images/profile1/SolarRadHistory.<?=IMAGE_TYPE?>"></img>
		
		
		]]>
		</content:encoded>
		<author><? echo EMAIL_ADDRESS;?></author>
		<guid><? echo BASE_URL; ?>/station.php#SolarRadHistory.gif</guid>
	</item>
	<item>
		<title>Sunrise: <? echo $sunrise;?> Sunset: <? echo $sunset;?></title>
		<link><? echo BASE_URL; ?></link>
		<description>Sunrise: <? echo $sunrise;?> Sunset: <? echo $sunset;?></description>
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