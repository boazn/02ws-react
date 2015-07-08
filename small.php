<?
header('Content-type: text/html; charset=utf-8');
header("Access-Control-Allow-Origin: null");
if ($_GET['debug'] == '')
	include "begin_caching.php";
include_once("include.php"); 
include "start.php";
include_once ("requiredDBTasks.php");
include "sigweathercalc.php";
include_once("forecastlib.php");
$size = $_REQUEST['size'];
if ($size == 's')
	$width = "150px";
else if ($size == 'm')
	$width = "230px";
else if ($size == 'l')
	$width = "320px";
else if (($_REQUEST['section'] != "")&&($_REQUEST['section'] != "SendEmailForm.php")&&($_REQUEST['section'] != "alerts.php"))
    $width = "570px";
else
    $width = "320px";
$imagefile = getUpdatedPic();
function isFastPage(){
    return ($_REQUEST['section'] == "alerts.php");
}
?>
<!DOCTYPE html>
<html  <? if (isHeb()) echo "lang=\"he\" xml:lang=\"he\"" ; ?> xmlns="http://www.w3.org/1999/xhtml">
<head>
 <? $cssstyle_str = "";
    if ($current->is_sunset()) { $cssstyle_str .= "sunset"; }
    if ($current->is_sunrise()) { $cssstyle_str .= "sunrise"; } 
    if (($current->is_light())&&($current->get_cloudiness() > 6)) { $cssstyle_str .= ",cloudy"; }
    if ($current->get_pm10() > 250) { $cssstyle_str .= ",dust"; } 
    if (!$current->is_light()) { $cssstyle_str .= ",night"; 
        if ($current->get_pm10() > 250) { $cssstyle_str .= ",dust-night"; }
    }
   if (isRaining()){ $cssstyle_str .= ",rain"; }
   if (((isRaining())&&($current->get_temp() < 2))||(stristr($template_routing, 'snow'))||(IS_SNOWING == 1)) { 
         if ($current->is_light()){ $cssstyle_str .= ",snow";
        } else { $cssstyle_str .= ",snow_night";} 
   }
   $cssstyle_str .= ",mobile"
  ?>
       
  
<link rel="stylesheet" href="css/main.php?lang=<?=$lang_idx;?>&type=" type="text/css">
        <? if ($current->is_sunset()) { ?>
        <link rel="stylesheet" href="css/sunset.min.css" type="text/css">
        <? }?>
        <? if ($current->is_sunrise()) { ?>
        <link rel="stylesheet" href="css/sunrise.min.css" type="text/css">
        <? }?>
        <? if (($current->is_light())&&($current->get_cloudiness() > 6)) {?>
             <link rel="stylesheet" href="css/cloudy.min.css" type="text/css" media="screen">
        <? }?>
        <? if (($current->get_pm10() > 250)&&($current->is_light())) { ?>
        <link rel="stylesheet" href="css/dust.min.css" type="text/css">
        <? }?>
        <? if (!$current->is_light()) { ?>
        <link rel="stylesheet" href="css/night.min.css" type="text/css">
            <? if ($current->get_pm10() > 250) { ?>
            <!--does not work on galaxy<link rel="stylesheet" href="css/dust-night.min.css" type="text/css">-->
            <? }?>
        <? }?>
        <? if (isRaining()){ ?>
	<link rel="stylesheet" href="css/rain.min.css" type="text/css">
        <? }?>
        <? if (((isRaining())&&($current->get_temp() < 2))||(stristr($template_routing, 'snow'))||(IS_SNOWING == 1)) { ?>
        <? if ($current->is_light()){?>
        <link rel="stylesheet" href="css/snow.min.css" type="text/css">
        <? } else {?>
        <link rel="stylesheet" href="css/snow_night.min.css" type="text/css">
        <? }?>
        <? }?>
        <link rel="stylesheet" href="css/mobile.php<?echo "?lang=".$lang_idx."&amp;width=".$width;?>" type="text/css" />
        
        <link rel="icon" type="image/png" href="img/favicon_sun.png" />
        <meta http-equiv="Refresh" content="1800" />
        <meta property="og:image" content="http://www.02ws.co.il/02ws_short.png" />
        <meta name="viewport" content="width=<?=$width?> <? if ($_REQUEST['section'] != "") echo ""; else echo  ",user-scalable=no";?>" />
        <title><? echo $LOGO[$lang_idx]." - ".$MOBILE_FRIENDLY[$lang_idx];?></title>
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-647172-1', 'auto');
            ga('send', 'pageview');

        </script>
</head>
<body >
<!-- SNOW EFFECT-->
<canvas id="canvas"></canvas>

<? if (($current->is_light())&&(!isRaining())) {$adsense_color = "#4B6371"; if ($current->is_sunset()) $adsense_background = "#FDAC60"; else $adsense_background = "#BCE3EA";} elseif (isRaining()) {$adsense_color = "#FFFFFF";$adsense_background = "#6288A4";} else {$adsense_color = "#FFFFFF";$adsense_background = "#3A4D59";};?>
<? if ($width=="320px") {?>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Ad small page -->
<ins class="adsbygoogle"
     style="display:inline-block;width:320px;height:50px"
     data-ad-client="ca-pub-2706630587106567"
     data-ad-slot="6699246495"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
<?}?>
<div style="" id="main_cellphone_container">

<div class="smalllogo" id="mobileslogan">
<a href="<? echo BASE_URL;?>/station.php?section=frommobile&amp;lang=<? echo $lang_idx;?>"  title="<? echo $HOME_PAGE[$lang_idx];?>" >	
	<? echo $LOGO[$lang_idx];?>
</a>&nbsp;&nbsp;&nbsp;
<? if (isHeb()) echo $dateInHeb; else echo $date;?>
<? if (!isHeb()) {?>
<div dir="ltr" class="il_image" id="tempunitconversion">
<form method="post" action="<?=$_SERVER['SCRIPT_NAME'];?>?lang=<? echo $lang_idx;?>&amp;size=<?=$size?>&amp;tempunit=<? if ($current->get_tempunit() == '&#176;c') echo 'F'; else echo 'c';?>" id="tempconversion">
        <input type="hidden" name="tocorf" value="<? if ($current->get_tempunit() == '&#176;C') echo '&#176;F'; else echo '&#176;C';?>" /> 
        <?  if ($current->get_tempunit() == '&#176;F') { ?>
        <a href="javascript:void(0)" onclick="document.getElementById('tempconversion').submit();" style="text-decoration:underline">&#176;C</a>
        <?  } else { ?>
        &#176;C
        <?  } ?>
        | 
        <?  if ($current->get_tempunit() == '&#176;c') { ?>
        <a href="javascript:void(0)" onclick="document.getElementById('tempconversion').submit();" style="text-decoration:underline">&#176;F</a>
        <?  } else { ?>
        &#176;F
        <?  } ?>
</form>
</div>
<?}	?>
</div>
<? if ($_GET['section'] != "") { ?>
<div id="tohome" class="invfloat inv_plain_3"><a href="<? echo BASE_URL.substr(strrchr($_SERVER["PHP_SELF"], "/"), 0)."?lang=".$lang_idx;?>"  title="<? echo $HOME_PAGE[$lang_idx];?>" class="hlink">
	<? echo $HOME_PAGE[$lang_idx];?>
	</a>
</div>
<? include($_GET['section']);}
else {?>
<div id="currentinfo_container">
<ul class="info_btns">
   <li id="temp_btn" onclick="change_circle('temp_line', 'latesttemp')" title="<? echo $TEMP[$lang_idx];?>"></li>
   <li id="moist_btn" onclick="change_circle('moist_line', 'latesthumidity')" title="<? echo $HUMIDITY[$lang_idx];?>"></li>
    <li id="rain_btn" onclick="change_circle('rain_line', 'latestrain')" title="<? echo $RAIN[$lang_idx];?>"></li>
</ul>
<hr id="now_line" />
<hr id="aq_line" />
<hr id="temp_line" />
<hr id="moist_line" />
<hr id="air_line" />
<hr id="wind_line" />
<hr id="rain_line" />
<hr id="rad_line" />
<hr id="uv_line" />
<hr id="cold_line" />
<hr id="season_line" />
<ul class="seker_btns">
<li id="cold_btn">
    <a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=survey.php&amp;survey_id=2&amp;lang=<? echo $lang_idx;?>">
    <?=$HOTORCOLD_T[$lang_idx]?>
    </a>
</li>
</ul>
<div id="latestnow" class="inparamdiv">
<div  id="windy">
<? echo getWindStatus($lang_idx);?>
</div>
 <?
    if (min($current->get_windchill(), $current->get_thw()) < ($current->get_temp()) && $current->get_temp() < 23 ){ ?>
            <div id="itfeels_windchill"> 
            <a title="<?=$WIND_CHILL[$lang_idx]?>" href="<?=$_SERVER['SCRIPT_NAME']?>?section=graph.php&amp;graph=tempwchill.php&amp;profile=1&amp;lang=<?=$lang_idx?>"> 
                    <? echo $IT_FEELS[$lang_idx]; ?>
                    <span dir="ltr" class="low" title="<?=$WIND_CHILL[$lang_idx]?>"><? echo min($current->get_windchill(), $current->get_thw())."&#176;"; ?></span>
             </a> 
            </div>

    <? } 
    else if (max($current->get_HeatIdx(), $current->get_thw()) > ($current->get_temp())){ ?>
            <div class="" id="itfeels_heatidx">
            <a title="<?=$HEAT_IDX[$lang_idx]?>"  href="<?=$_SERVER['SCRIPT_NAME']?>?section=graph.php&amp;graph=tempheat.php&amp;profile=1&amp;lang=<?=$lang_idx?>"> 
                    <? echo $IT_FEELS[$lang_idx]; ?>
                    <span dir="ltr" class="high" title="<?=$HEAT_IDX[$lang_idx]?>"><? echo max($current->get_HeatIdx(), $current->get_thw())."&#176;";  ?></span>
             </a> 
            </div>
    <?}?>
<div id="tempdivvalue">
<a href="<?=$_SERVER['SCRIPT_NAME']?>?section=graph.php&amp;graph=temp.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>&amp;style=<?=$_GET["style"]?>"><? echo $current->get_temp()."<span class=\"paramunit\">".$current->get_tempunit(); ?></span></a>
</div>

<div id="statusline">
          
<div  id="coldmeter">
<span id="current_feeling_link" title="<?=$HOTORCOLD_T[$lang_idx]?> - <?=$COLD_METER[$lang_idx]?>">...</span>
</div>
</div>
<? if (count($sig) > 1) { ?>
    <div id="what_is_h"><? echo "{$sig[0]['sig'][$lang_idx]}"; ?><br/><? echo "{$sig[0]['extrainfo'][$lang_idx]}"; ?></div>
<?}?>
</div>
<div id="latesttemp" class="inparamdiv" style="display:none;">
        <div class="paramtitle slogan">
             <a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=temp.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>&amp;style=<?=$_GET["style"]?>" title=""><? echo $TEMP[$lang_idx];?></a>
         </div>
        <div class="paramvalue">
                                      <? echo $current->get_temp();?><span class="paramunit"><? echo $current->get_tempunit(); ?></span>&nbsp;<span id="valleytemp" title="<?=$MOUNTAIN[$lang_idx]?>"><? echo $current->get_temp2()."&nbsp;".$MOUNTAIN[$lang_idx];?></span>
         </div>
         <div class="highlows">
                 <div class="high"><strong><? echo toLeft($today->get_hightemp()); ?></strong></div>&nbsp;<img src="img/peak_max.png" width="15" height="14" alt="<? echo $HIGH[$lang_idx]; ?>"/>&nbsp;<? echo $today->get_hightemp_time()." "; ?>
                 <div class="low"><strong><? echo toLeft($today->get_lowtemp()); ?></strong></div>&nbsp;<img src="img/peak_min.png" width="15" height="14" alt="<? echo $LOW[$lang_idx]; ?>"/>&nbsp;<? echo $today->get_lowtemp_time()." "; ?>
         </div> 
         <div class="paramtrend relative">
             <div class="innertrendvalue">
                <? echo getLastUpdateMin()." ".($MINTS[$lang_idx]).": ".get_param_tag($min15->get_tempchange()).$current->get_tempunit(); ?>
             </div>
         </div>  
   <div class="trendstable"> 
        <table>
                 <tr class="trendstitles">
                         <td  class="box" title="24 <? echo $HOURS[$lang_idx];?>"><img src="img/24_icon.png" width="21" height="21" alt="24 <? echo $HOURS[$lang_idx];?>"/></td>
                         <td  class="box" title="<? echo($HOUR[$lang_idx]);?>"><img src="img/hour_icon.png" width="21" height="21" alt="hour"/></td>
                         <td  class="box" title="30<? echo($MINTS[$lang_idx]);?>"><img src="img/half_icon.png" width="21" height="21" alt="half hour"/></td>
                 </tr>
                 <tr class="trendsvalues"><td><div class="trendvalue"><div class="innertrendvalue"> <? echo get_param_tag($yestsametime->get_tempchange())."</div></div></td><td ><div class=\"trendvalue\"><div class=\"innertrendvalue\">".get_param_tag($oneHour->get_tempchange())."</div></div></td><td ><div class=\"trendvalue\"><div class=\"innertrendvalue\">".get_param_tag($min30->get_tempchange()); ?></div></div></td></tr>
         </table>
    </div>
    <div class="graphslink">
        <a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=temp.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>&amp;style=<?=$_GET["style"]?>" title=""><img src="img/graph_icon.png" width="35" height="18" alt="to graphs"/></a>
    </div>
 </div>
<div id="latesttemp2" class="inparamdiv" style="display:none;">
    
</div>
<div id="latesthumidity" class="inparamdiv" <? if (isHeb()) echo "dir=\"rtl\" ";?> style="display:none">
    <div class="paramtitle slogan">
                <a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=humwind.php&amp;level=1&amp;freq=2&amp;datasource=downld02&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>&amp;style=<?=$_GET["style"]?>" title=""><? echo $HUMIDITY[$lang_idx];?></a>
        </div>
        <div class="paramvalue">
                <a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=humwind.php&amp;level=1&amp;freq=2&amp;datasource=downld02&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>&amp;style=<?=$_GET["style"]?>"  class="info"><? echo $current->get_hum();?>%&nbsp;</a>
        </div>
        <div class="highlows">
                 <span><strong><? echo $today->get_highhum(); ?></strong>&nbsp;<img src="img/peak_max.png" width="15" height="14" alt="<? echo $HIGH[$lang_idx]; ?>"/>&nbsp;<? echo $today->get_highhum_time()." "; ?></span>
                 &nbsp;&nbsp;&nbsp;&nbsp;<span><strong><? echo $today->get_lowhum(); ?></strong>&nbsp;<img src="img/peak_min.png" width="15" height="14" alt="<? echo $LOW[$lang_idx]; ?>"/>&nbsp;<? echo $today->get_lowhum_time()." "; ?></span>
         </div>
       <div class="paramtrend relative">
            <div class="innertrendvalue">
            <? echo getLastUpdateMin()." ".($MINTS[$lang_idx]).": ".get_img_tag($min15->get_humchange()).abs($min15->get_humchange())."%"; ?>
            </div>
        </div>
        <div class="trendstable">
        <table>
        <tr class="trendstitles">
                <td  class="box" title="24 <? echo $HOURS[$lang_idx];?>"><img src="img/24_icon.png" width="21" height="21" alt="24 <? echo $HOURS[$lang_idx];?>"/></td>
                <td  class="box" title="<? echo($HOUR[$lang_idx]);?>"><img src="img/hour_icon.png" width="21" height="21" alt="hour"/></td>
                <td  class="box" title="30<? echo($MINTS[$lang_idx]);?>"><img src="img/half_icon.png" width="21" height="21" alt="half hour"/></td>
        </tr>
         <tr class="trendsvalues">
             <td><div class="trendvalue"><div class="innertrendvalue">
                 <? echo get_img_tag($yestsametime->get_humchange()).abs($yestsametime->get_humchange());?>
                  </div></div>
             </td>
             <td><div class="trendvalue"><div class="innertrendvalue">
                        <? echo get_img_tag($oneHour->get_humchange()).abs($oneHour->get_humchange());?>
                </div></div>
             </td>
             <td><div class="trendvalue"><div class="innertrendvalue">
                 <? echo get_img_tag($min30->get_humchange()).abs($min30->get_humchange());?>
                </div></div>
            </td>
        </tr>
        </table>
        </div>
        <div class="graphslink">
                <a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=humwind.php&amp;level=1&amp;freq=2&amp;datasource=downld02&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>&amp;style=<?=$_GET["style"]?>" title=""><img src="img/graph_icon.png" width="35" height="18" alt="to graphs"/></a>
   </div>
</div>
<div id="latestpressure" class="inparamdiv" <? if (isHeb()) echo "dir=\"rtl\" ";?> style="display:none">
</div>
<div id="latestwind" class="inparamdiv" <? if (isHeb()) echo "dir=\"rtl\" ";?> style="display:none">
</div>
<div id="latestrain" class="inparamdiv" style="display:none" <? if (isHeb()) echo "dir=\"rtl\" ";?> title="<? echo $RAIN_RATE[$lang_idx]; ?>">
<div class="paramtitle slogan">
    <? echo $RAIN_RATE[$lang_idx];?>
</div>
<div id="rainratevalue" class="paramvalue">

            <? echo $current->get_rainrate()." <span class=\"paramunit\">".$RAINRATE_UNIT[$lang_idx]."</span>";?>

</div>
<div class="highlows">
    <span><strong><? echo $today->get_highrainrate(); ?></strong>&nbsp;<img src="img/peak_max.png" width="15" height="14" alt="<? echo $HIGH[$lang_idx]; ?>"/>&nbsp;<? echo $today->get_highrainrate_time()." "; ?></span>
</div>
<div class="paramtrend relative">
<? echo $DAILY_RAIN[$lang_idx]; ?>:&nbsp;<? echo $today->get_rain()." ".$RAIN_UNIT[$lang_idx]; ?><br/>
<? echo $TOTAL_RAIN[$lang_idx]; ?>:&nbsp;<? echo $seasonTillNow->get_rain()." ".$RAIN_UNIT[$lang_idx]; ?>
</div>
<div class="trendstable">
 <table id="rainrate15min">
<tr class="trendstitles">
        <td  class="box" title="<? echo($HOUR[$lang_idx]);?>"><img src="img/hour_icon.png" width="21" height="21" alt="hour"/></td>
        <td  class="box" title="30<? echo($MINTS[$lang_idx]);?>"><img src="img/half_icon.png" width="21" height="21" alt="half hour"/></td>
        <td class="box" title="<? echo getLastUpdateMin().($MINTS[$lang_idx]);?>"><img src="img/quarter_icon.png" width="21" height="21" alt="quarter hour"/></td>
</tr>
<tr class="trendsvalues">
        <td><div class="trendvalue"><div class="innertrendvalue">
                <? echo get_img_tag($oneHour->get_rainratechange()).abs(round($oneHour->get_rainratechange())); ?>
                </div></div></td>
        <td><div class="trendvalue"><div class="innertrendvalue">
                <? echo get_img_tag($min30->get_rainratechange()).abs(round($min30->get_rainratechange())); ?>
        </div></div></td>
        <td ><div class="trendvalue"><div class="innertrendvalue">
                <? echo get_img_tag($min15->get_rainratechange()).abs(round($min15->get_rainratechange())); ?>

        </div></div></td>
</tr>
</table>
</div>
    <div class="graphslink">
            <a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=RainRateHistory.gif&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;style=<?=$_GET["style"]?>" title=""><img src="img/graph_icon.png" width="35" height="18" alt="to graphs"/></a>
    </div>
</div>  
<div id="latestradiation" class="inparamdiv" <? if (isHeb()) echo "dir=\"rtl\" ";?> style="display:none">
</div>
<div id="latestuv" class="inparamdiv" <? if (isHeb()) echo "dir=\"rtl\" ";?> style="display:none">
</div>
<div id="latestairq" class="inparamdiv" <? if (isHeb()) echo "dir=\"rtl\" ";?> style="display:none">
</div>
<div class="inparamdiv" id="coldmetersurvey" style="display:none">
    
</div>
<div style="clear:both;height:5px">&nbsp;</div>
<div id="shortforecast">
    <ul class="nav"> 
       <li class="tsfh" style="border:none">
            <?echo "".replaceDays($forecastDaysDB[0]['day_name']." ")."&nbsp;&nbsp;".$forecastDaysDB[0]['date'];?><br/>
            <img src="<? echo "images/icons/day/".$forecastDaysDB[0]['icon']; ?>" width="28" height="27" alt="<? echo "images/icons/day/".$forecastDaysDB[0]['icon']; ?>" /><br/>
            <?=c_or_f($forecastDaysDB[0]['TempLow'])?>&nbsp;-&nbsp;<?=c_or_f($forecastDaysDB[0]['TempHigh'])?><br/>
        </li>
        <li class="tsfh">
            <?echo "".replaceDays($forecastDaysDB[1]['day_name']." ")."&nbsp;&nbsp;".$forecastDaysDB[1]['date'];?><br/>
            <img src="<? echo "images/icons/day/".$forecastDaysDB[1]['icon']; ?>" width="28" height="27" alt="<? echo "images/icons/day/".$forecastDaysDB[1]['icon']; ?>" /><br/>
            <?=c_or_f($forecastDaysDB[1]['TempLow'])?>&nbsp;-&nbsp;<?=c_or_f($forecastDaysDB[1]['TempHigh'])?><br/>
        </li>
        <li class="tsfh">
            <?echo "".replaceDays($forecastDaysDB[2]['day_name']." ")."&nbsp;&nbsp;".$forecastDaysDB[2]['date'];?><br/>
            <img src="<? echo "images/icons/day/".$forecastDaysDB[2]['icon']; ?>" width="28" height="27" alt="<? echo "images/icons/day/".$forecastDaysDB[2]['icon']; ?>" /><br/>
            <?=c_or_f($forecastDaysDB[2]['TempLow'])?>&nbsp;-&nbsp;<?=c_or_f($forecastDaysDB[2]['TempHigh'])?><br/>
        </li>
        <li class="tsfh">
            <?echo "".replaceDays($forecastDaysDB[3]['day_name']." ")."&nbsp;&nbsp;".$forecastDaysDB[3]['date'];?><br/>
            <img src="<? echo "images/icons/day/".$forecastDaysDB[3]['icon']; ?>" width="28" height="27" alt="<? echo "images/icons/day/".$forecastDaysDB[3]['icon']; ?>" /><br/>
            <?=c_or_f($forecastDaysDB[3]['TempLow'])?>&nbsp;-&nbsp;<?=c_or_f($forecastDaysDB[3]['TempHigh'])?><br/>
        </li>
    </ul>
</div>
<div style="clear:both;height:20px">&nbsp;</div>
<div id="nextdays">
    <div id="for_title" class="float">
           <div id="for24h_title" class="forcast_title_btns for_active">
           <a href="javascript:void(0)" onclick="show('forecast24h');hide('forecastnextdays');$('#for24h_title').addClass('for_active');$('#fornextdays_title').removeClass('for_active')">
                   <? echo(" 24 ".$HOURS[$lang_idx]);?>
           </a>
           </div> 
           <div id="fornextdays_title" class="forcast_title_btns">
           <a href="javascript:void(0)" id="forecastnextdays_link" onclick="show('forecastnextdays');hide('forecast24h');$('#fornextdays_title').addClass('for_active');$('#for24h_title').removeClass('for_active')">
                   <? echo($FORECAST_4D[$lang_idx]); ?>
           </a>
   </div>
					
</div>
<div style="display:none;padding:0.1em 0.2em" id="forecastnextdays">
        <ul id="forcast_icons">
            <li id="morning_icon"></li>
            <li id="noon_icon"></li>
            <li id="night_icon"></li>
            
        </ul>
	<table <? if (isHeb()) echo "dir=\"rtl\""; ?> style="border-spacing:4px;width:100%">
        <? if  (count($forecastDaysDB) == 0) echo $frcstTable;
                    else 
                    {
                            //print_r($forecastDaysDB);

                            for ($i = 0; $i < count($forecastDaysDB); $i++) 
                            {
                            if ($i % 2 == 1)
                                    $class =  " class=\"\" ";
                            else
                                    $class =  " class=\"\" ";
                            ?>
                            <tr <?=$class?> style="height:<?=180/count($forecastDaysDB)?>px">
                            <td class="tsfh" style="text-align:center;line-height: 0.9em;"><?echo replaceDays($forecastDaysDB[$i]['day_name']." ")."<br />".$forecastDaysDB[$i]['date'];?></td>
                            <td class="tsfh" style="text-align:center;direction:ltr"><?=c_or_f($forecastDaysDB[$i]['TempLow'])?></td>
                            <td class="tsfh" style="text-align:center;direction:ltr"><?=c_or_f($forecastDaysDB[$i]['TempHigh'])?><a href="WhatToWear.php#<?=$prefTempHighCloth?>" rel="external" ><img style="vertical-align: middle" src="<? echo "images/clothes/".$forecastDaysDB[$i]['TempHighCloth']; ?>" width="20" height="15" title="<?=getClothTitle($forecastDaysDB[$i]['TempHighCloth'])?>" alt="<?=getClothTitle($forecastDaysDB[$i]['TempHighCloth'])?>" /></a></td>
                            <td class="tsfh" style="text-align:center;direction:ltr"><?=c_or_f($forecastDaysDB[$i]['TempNight'])?></td>
                            <td style="width:32px"><img src="<? echo "images/icons/day/".$forecastDaysDB[$i]['icon']; ?>" width="32" height="32" alt="<? echo "images/icons/day/".$forecastDaysDB[$i]['icon']; ?>" /></td>
                            <td style="width:130px;padding:0 0.2em 0 0.2em"><? if (isHeb()) $dscpIdx = "lang1"; else $dscpIdx = "lang0"; echo urldecode($forecastDaysDB[$i][$dscpIdx]);?></td>
                            </tr>
                            <? }
                    }
          ?>

	</table> 
</div>
<div id="forecast24h">
	<div id="for24_given">
							<? echo($GIVEN[$lang_idx]." ".$AT[$lang_idx]." ".$timetaf.":00 ".$dayF."/".$monthF."/".$yearF);?>
	</div>
	<div id="for24_details" style="display:none">
		<?//=$forcastTicker?>
		<span id="tempForecastDiv" style="display:none">
		</span>
	</div>
	<div id="forecasthours">
        <? 
        foreach ($forecastHour as $hour_f){
        if (($hour_f['time'] % 3 == 0) || ($hour_f['plusminus'] > 0))
        {
        echo "<ul class=\"nav forecasttimebox\" >";
        echo "<li class=\"tsfh\" style=\"display:none\"><span>".$hour_f['currentDateTime']."</span></li>";
        echo "<li class=\"tsfh forcast_date\"><span>".date("j/m", $hour_f['currentDateTime'])."</span></li>";
        echo "<li class=\"timefh forcast_time\"><span>".$hour_f['time'].":00";
           if ($hour_f['plusminus'] > 0)
               echo "&nbsp;&nbsp;&plusmn;".$hour_f['plusminus']."";
        echo "</span></li>";
        echo "<li class=\"forecasttemp\" id=\"tempfh".intval($hour_f['time'])."\"><span>"."</span></li>";
         if ($hour_f['wind'] > 30){
                   $windtitle=$EXTREME_WINDS[$lang_idx];
                   $wind_class="high_wind";
          }

         else if ($hour_f['wind'] > 20){
                   $windtitle=$STRONG_WINDS[$lang_idx];
                   $wind_class="high_wind";
          }

         else if ($hour_f['wind'] > 10){
                   $windtitle=$MODERATE_WINDS[$lang_idx];
                   $wind_class="moderate_wind";
          }

         else{
                   $windtitle=$WEAK_WINDS[$lang_idx];
                   $wind_class="light_wind";
          }

          echo "<li style=\"margin-top:0;\"><div title=\"".$windtitle."\" class=\"wind_icon ".$wind_class." \"></div></li>";
        echo "<li class=\"forcast_icon\"><img src=\"images/icons/day/".$hour_f['icon']."\" height=\"30\" width=\"30\" alt=\"".$hour_f['icon']."\" /></li>";
        //echo "<li class=\"\" style=\"width:15%\">".$hour_f['wind'].",</li>";
        echo "<li class=\"forcast_title\"><span>".$hour_f['title']."</span></li>";
        echo "</ul>";
        }
        }
        ?>
	</div>
</div>
</div>
<div style="clear:both;padding:0.3em">&nbsp;</div>
<!-- Ad small page -->
<ins class="adsbygoogle"
     style="display:inline-block;width:320px;height:50px"
     data-ad-client="ca-pub-2706630587106567"
     data-ad-slot="6699246495"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
<div id="messages_box" class="white_box">
    <h2><? echo $MESSAGES[$lang_idx];?></h2>
    <p class="box_text">
        <? echo $detailedforecast;?>
    </p>
</div>
<!-- small's large -->
<ins class="adsbygoogle"
     style="display:inline-block;width:320px;height:100px"
     data-ad-client="ca-pub-2706630587106567"
     data-ad-slot="7272921896"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>

<div id="livepic_box" class="white_box">
    <div class="avatar live_avatar"></div>
    <h3><? echo $LIVE_PICTURE[$lang_idx];?></h3>
    <a href="images/webCamera.jpg" title="<? echo($LIVE_PICTURE[$lang_idx]);?>"><img src="phpThumb.php?src=<?=$imagefile?>&amp;w=180" width="180" height="135" alt="<? echo($LIVE_PICTURE[$lang_idx]);?>" /></a>
    <br/>
    <h3><a id="radar" href="<?=$_SERVER['SCRIPT_NAME']?>?section=radar.php&amp;lang=<?=$lang_idx;?>">
				<? echo $RAIN_RADAR[$lang_idx];?><?=get_arrow()?>
    </h3>		</a>
</div>
<div style="clear:both">&nbsp;</div>

</div>
<!-- Parallax  midground clouds -->
<div id="parallax-bg2">
  
    <? if ($current->get_cloudiness() > 2) {?>
    <div id="bg2-4" class="cloud1"><div class="cloud1-more"></div></div>
    <div id="bg2-5" class="cloud-big"><div class="cloud-big-more"></div></div>
     <div id="bg2-6" class="cloud4"><div class="cloud4-more"></div></div>
    <div id="bg2-7" class="cloud2"><div class="cloud2-more"></div></div>
    <?}?>
    <? if ($current->get_cloudiness() > 5) {?>
    <div id="bg2-8" class="cloud-big"><div class="cloud-big-more"></div></div>
    <?}?>
    <? if ($current->get_cloudiness() > 6) {?>
    <div id="bg2-9" class="cloud-big"><div class="cloud-big-more"></div></div>
    <div id="bg2-10" class="cloud-big"><div class="cloud-big-more"></div></div>
    <?}?>
</div>
<!-- Parallax  background clouds -->
<div id="parallax-bg1">
    
    <? if ($current->get_cloudiness() > 2) {?>
    <div id="bg1-3" class="cloud4"><div class="cloud4-more"></div></div>
    <div id="bg1-4" class="cloud-big"><div class="cloud-big-more"></div></div>
    <div id="bg1-5" class="cloud3"><div class="cloud3-more"></div></div>
    <div id="bg1-6" class="cloud2"><div class="cloud2-more"></div></div>
    <?}?>
    <? if ($current->get_cloudiness() > 5) {?>
    <div id="bg1-7" class="cloud-big"><div class="cloud-big-more"></div></div>
    <div id="bg1-8" class="cloud-big"><div class="cloud-big-more"></div></div>
    <?}?>
    <? if ($current->get_cloudiness() > 6) {?>
    <div id="bg1-9" class="cloud-big"><div class="cloud-big-more"></div></div>
    <div id="bg1-10" class="cloud-big"><div class="cloud-big-more"></div></div>
    <?}?>
</div>
 <? if (isHeb()) include "chat.php"; ?>
<?}// end  homepage?>
</div>
<? if ((!isSnowing())&&(isRaining())) { ?>
<script src="js/rain.js"></script>
<? }?>
<? if (isSnowing()||(stristr($template_routing, 'snow'))) { ?>
<script src="js/snow.js"></script>
<? }?>
<? if (!isFastPage()) { ?>
<script src="js/jquery-1.6.1.min.js"  type="text/javascript"></script>
<script src="js/tinymce/tinymce.min.js" type="text/javascript"></script>
<script src="footerScripts.php?lang=<?=$lang_idx?>"  type="text/javascript"></script>
<script type="text/javascript">
startup(<?=$lang_idx?>, <?=$limitLines?>, "<?=(isset($_GET['update'])?$_GET['update']:'')?>");
getTempForecast(<?=$timetaf?>, '<?=$dayF."/".$monthF."/".$yearF?>'); 
$.fx.off = true;
</script>
<?}?>
</body>
</html>
<? if ($_GET['debug'] == '') include "end_caching.php"; ?>