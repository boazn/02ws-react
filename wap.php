<?php
header ("Content-type: text/vnd.wap.wml; charset=UTF-8");
//include "begin_caching.php";
include "start.php"; 
?>
<? echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"; ?>
<!DOCTYPE wml PUBLIC "-//WAPFORUM//DTD WML 1.1//EN" "http://www.wapforum.org/DTD/wml_1.1.xml">
<wml>
<card id="latest" title="Jerusalem Weather station">
<p>
<? echo $TITLE[$EN]; ?> <br></br>
<? echo ELEVATION ; ?>m <br></br>
<? echo $date;?> <br></br>
<br></br>
<? echo $TEMP[$EN];?> <? echo $current->get_temp();?><? echo $current->get_tempunit(); ?> <br></br>
<? echo $HUMIDITY[$EN];?>: <? echo $current->get_hum();?>% <br></br>
<? echo $WIND[$EN];?>: <? echo $current->get_windspd()." ".$windUnits;?> <br></br>
Dir:  <? echo $current->get_winddir();?><br/>
<? echo $BAR[$EN];?>: <? echo $current->get_pressure();?>mb <br></br>
<? echo $DAILY_RAIN[$EN].": ".$today->get_rain().$RAIN_UNIT[$lang_idx]; ?><br></br>
maxTemp: <? echo $today->get_hightemp()."<? echo $current->get_tempunit(); ?>"; ?> <? echo "[".$today->get_hightemp_time()."] "; ?> <br></br>
minTemp:<? echo $today->get_lowtemp()."<? echo $current->get_tempunit(); ?>"; ?> <? echo "[".$today->get_lowtemp_time()."] "; ?><br></br>
<br></br>
</p>
</card>

<card id="sun" title="Sun and Moon">
<p>
sun rise:  <? echo $sunrise;?> <br></br>
sun set: <? echo $sunset;?> <br></br>
</p>
</card>

<card id="contact" title="Contact">
<p>
phone: 054-4854456 <br></br>
</p>
</card>
</wml>
<? //include "end_caching.php"; ?>