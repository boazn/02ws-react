<?
header('Content-type: text/html; charset=utf-8');
include_once("include.php"); 
redirectToSite(get_url());
if ($_GET['debug'] == '')
	include "begin_caching.php";
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
else if ($_REQUEST['section'] != "")
    $width = "570px";
else
    $width = "320px";
$imagefile = getUpdatedPic();
?>
<!DOCTYPE html>
<html  <? if (isHeb()) echo "lang=\"he\" xml:lang=\"he\""; ?> xmlns="http://www.w3.org/1999/xhtml">
<head>
<link title="Default Colors" href="basestyle.php<?echo "?lang=".$lang_idx;?>" rel="stylesheet" type="text/css" media="screen" /> 
<link rel="stylesheet" href="css/main.php<?echo "?lang=".$lang_idx;?>" type="text/css" media="screen">
        <? if (!$current->is_light()) { ?>
        <link rel="stylesheet" href="css/night.css">
        <? }?>
		<? if ($current->is_sunset()) { ?>
        <link rel="stylesheet" href="css/sunset.css">
        <? }?>
        <? if ($current->is_sunrise()) { ?>
        <link rel="stylesheet" href="css/sunrise.css">
        <? }?>
        <? if (isRaining()){ ?>
			<link rel="stylesheet" href="css/rain.css">
			<? if ($current->get_temp() < 2) { ?>
			<link rel="stylesheet" href="css/snow.css">
        <? }}?>
<link rel="stylesheet" href="css/mobile.php<?echo "?lang=".$lang_idx."&amp;width=".$width;?>" type="text/css" media="screen">
        <link rel="icon" type="image/png" href="img/favicon_sun.png">
		
<meta http-equiv="Refresh" content="600" />
<meta property="og:image" content="http://www.02ws.co.il/02ws_short.png" />
<meta name="viewport" content="width=<?=$width?>,user-scalable=false" />
<title><? echo $LOGO[$lang_idx];?></title>

</head>
<body>
<!-- SNOW EFFECT-->
<canvas id="canvas"></canvas>
<? if (($current->is_light())&&(!isRaining())) {$adsense_color = "#4B6371"; if ($current->is_sunset()) $adsense_background = "#FDAC60"; else $adsense_background = "#BCE3EA";} elseif (isRaining()) {$adsense_color = "#FFFFFF";$adsense_background = "#6288A4";} else {$adsense_color = "#FFFFFF";$adsense_background = "#3A4D59";};?>
<? if ($width=="320px") {?>
<script type="text/javascript"><!--
google_ad_client = "ca-pub-2706630587106567";
/* Ad small page */
google_ad_slot = "6699246495";
google_ad_width = 320;
google_ad_height = 50;
google_color_border = ["<?= $adsense_background ?>"];
google_color_bg = ["<?= $adsense_background ?>"];
google_color_link = ["<?= $adsense_color ?>"];
google_color_url = ["<?= $adsense_color ?>"];
google_color_text = ["<?= $adsense_color ?>"];
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
<?}?>
<div style="width:<?=$width?>" <? if (isheb()) echo "dir=\"rtl\""; ?> id="main_cellphone_container">

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
<div id="tohome" class="invfloat topbase"><a href="<? echo BASE_URL.substr(strrchr($_SERVER["PHP_SELF"], "/"), 0)."?lang=".$lang_idx;?>"  title="<? echo $HOME_PAGE[$lang_idx];?>" class="hlink">
	<? echo $HOME_PAGE[$lang_idx];?>
	</a>
</div>
<? include($_GET['section']);}
else {?>
<div id="currentinfo_container">
<div id="latestnow" class="inparamdiv">
 <?
    if (min($current->get_windchill(), $current->get_thw()) < ($current->get_temp() - 1) && $current->get_temp() < 20 ){ ?>
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
			<div  id="windy">
			<? echo getWindStatus();?>
			</div>
			<div  id="coldmeter">
			<a href="<?=$_SERVER['SCRIPT_NAME']?>?section=survey.php&amp;survey_id=2&amp;lang=<? echo $lang_idx;?>"><span id="current_feeling_link" title="<?=$HOTORCOLD_T[$lang_idx]?> - <?=$COLD_METER[$lang_idx]?>">...</span>
			</a> 
			</div>
</div>
<? if (count($sig) > 1) { ?>
<div id="what_is_h"><? echo "{$sig[0]['sig'][$lang_idx]}"; ?><br /><? echo $sig[0]['extrainfo'][$lang_idx];?></div>
<?}?>
<div id="more_info_btn">	
<a href="javascript:void(0)" title="<? echo $HUMIDITY[$lang_idx];?>&nbsp;<? echo $WIND[$lang_idx];?>&nbsp;<? echo $RAIN[$lang_idx];?>" onclick="toggle('latestnow');toggle('extendedInfo');">
 <? echo $MORE_INFO[$lang_idx];?>&nbsp;<?=get_arrow()?>	
</a>
</div>
</div>
<div id="extendedInfo" class="inparamdiv" style="display:none;">
    <br />
    <br />
 <span class="big"><? echo $current->get_temp(),$current->get_tempunit();?></span>
 <div class="highlows">
        <span class="high"><strong><? echo toLeft($today->get_hightemp()); ?></strong></span>&nbsp;<img src="img/peak_max.png" width="15" height="14" alt="<? echo $HIGH[$lang_idx]; ?>"/>&nbsp;<? echo $today->get_hightemp_time()." "; ?>
        <span class="low"><strong><? echo toLeft($today->get_lowtemp()); ?></strong></span>&nbsp;<img src="img/peak_min.png" width="15" height="14" alt="<? echo $LOW[$lang_idx]; ?>"/>&nbsp;<? echo $today->get_lowtemp_time()." "; ?>
</div>
<a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=humwind.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>&amp;style=<?=$_GET["style"]?>"><span class="big"><? echo $current->get_hum(),"%&nbsp;";?></span></a>
<div class="highlows">
        <span><strong><? echo $today->get_highhum(); ?></strong>&nbsp;<img src="img/peak_max.png" width="15" height="14" alt="<? echo $HIGH[$lang_idx]; ?>"/>&nbsp;<? echo $today->get_highhum_time()." "; ?></span>
        &nbsp;&nbsp;&nbsp;&nbsp;<span><strong><? echo $today->get_lowhum(); ?></strong>&nbsp;<img src="img/peak_min.png" width="15" height="14" alt="<? echo $LOW[$lang_idx]; ?>"/>&nbsp;<? echo $today->get_lowhum_time()." "; ?></span>
</div>
<div class="big"><div class="winddir <? echo $current->get_winddir(); ?>"></div><? echo $current->get_windspd()." ".$KNOTS[$lang_idx];?></div>
<div>
<? echo $DAILY_RAIN[$lang_idx]; ?>:&nbsp;<a href="images/profile1/RainHistory.<?=IMAGE_TYPE?>"><? echo $today->get_rain()." ".$RAIN_UNIT[$lang_idx]; ?></a><br/>
<? echo $TOTAL_RAIN[$lang_idx]; ?>:&nbsp;<a href="images/profile1/RainHistory.<?=IMAGE_TYPE?>"><? echo $seasonTillNow->get_rain()." ".$RAIN_UNIT[$lang_idx]; ?></a>
</div>
<div class="graphslink">
    <a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=temp.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>&amp;style=<?=$_GET["style"]?>" title=""><img src="img/graph_icon.png" alt="to graphs"/></a>
</div>
</div>
<div style="clear:both;height:5px">&nbsp;</div>
<div id="shortforecast">
    <ul class="nav">
        <li style="border:none">
            <?echo "<span class=\"big\">".replaceDays($forecastDaysDB[0]['day_name']." ")."</span>".$forecastDaysDB[0]['date'];?><br/>
            <img src="<? echo "images/icons/day/".$forecastDaysDB[0]['icon']; ?>" width="28" height="27" alt="<? echo "images/icons/day/".$forecastDaysDB[0]['icon']; ?>" /><br/>
            <?=c_or_f($forecastDaysDB[0]['TempLow'])?>-<?=c_or_f($forecastDaysDB[0]['TempHigh'])?><br/>
        </li>
        <li>
            <?echo "<span class=\"big\">".replaceDays($forecastDaysDB[1]['day_name']." ")."</span>".$forecastDaysDB[1]['date'];?><br/>
            <img src="<? echo "images/icons/day/".$forecastDaysDB[1]['icon']; ?>" width="28" height="27" alt="<? echo "images/icons/day/".$forecastDaysDB[1]['icon']; ?>" /><br/>
            <?=c_or_f($forecastDaysDB[1]['TempLow'])?>-<?=c_or_f($forecastDaysDB[1]['TempHigh'])?><br/>
        </li>
        <li>
            <?echo "<span class=\"big\">".replaceDays($forecastDaysDB[2]['day_name']." ")."</span>".$forecastDaysDB[2]['date'];?><br/>
            <img src="<? echo "images/icons/day/".$forecastDaysDB[2]['icon']; ?>" width="28" height="27" alt="<? echo "images/icons/day/".$forecastDaysDB[2]['icon']; ?>" /><br/>
            <?=c_or_f($forecastDaysDB[2]['TempLow'])?>-<?=c_or_f($forecastDaysDB[2]['TempHigh'])?><br/>
        </li>
        <li>
            <?echo "<span class=\"big\">".replaceDays($forecastDaysDB[3]['day_name']." ")."</span>".$forecastDaysDB[3]['date'];?><br/>
            <img src="<? echo "images/icons/day/".$forecastDaysDB[3]['icon']; ?>" width="28" height="27" alt="<? echo "images/icons/day/".$forecastDaysDB[3]['icon']; ?>" /><br/>
            <?=c_or_f($forecastDaysDB[3]['TempLow'])?>-<?=c_or_f($forecastDaysDB[3]['TempHigh'])?><br/>
        </li>
    </ul>
</div>
<div style="clear:both;height:20px">&nbsp;</div>
<div class="float" id="nextdays">
    <div id="for_title" class="float">
           <div id="for24h_title" class="forcast_title_btns for_active">
           <a href="javascript:void(0)" onclick="toggle('forecast24h');toggle('forecastnextdays');$('#for24h_title').addClass('for_active');$('#fornextdays_title').removeClass('for_active')">
                   <? echo(" 24 ".$HOURS[$lang_idx]);?>
           </a>
           </div> 
           <div id="fornextdays_title" class="forcast_title_btns">
           <a href="javascript:void(0)" id="forecastnextdays_link" onclick="toggle('forecastnextdays');toggle('forecast24h');$('#fornextdays_title').addClass('for_active');$('#for24h_title').removeClass('for_active')">
                   <? echo($FORECAST_4D[$lang_idx]); ?>
           </a>
   </div>
					
</div>
<div style="display:none;padding:0.1em 0.2em" id="forecastnextdays">
        <ul id="forcast_icons">
            <li id="morning_icon"></li>
            <li id="noon_icon"></li>
            
        </ul>
	<table <? if (isHeb()) echo "dir=\"rtl\""; ?> style="border-spacing:2px;padding:3px;width:100%">
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
                            <td style="width:45px;text-align:center;font-weight:bold"><?echo replaceDays($forecastDaysDB[$i]['day_name']." ")." ".$forecastDaysDB[$i]['date'];?></td>
                            <td style="text-align:center;direction:ltr"><?=c_or_f($forecastDaysDB[$i]['TempLow'])?></td>
                            <td style="text-align:center;direction:ltr"><?=c_or_f($forecastDaysDB[$i]['TempHigh'])?></td>
                            <td style="width:32px"><img src="<? echo "images/icons/day/".$forecastDaysDB[$i]['icon']; ?>" width="32" alt="<? echo "images/icons/day/".$forecastDaysDB[$i]['icon']; ?>" /></td>
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
						 if ($hour_f['time'] % 3 == 0)
						 {
						 echo "<ul class=\"nav forecasttimebox\" >";
						 echo "<li class=\"tsfh\" style=\"text-align:center;display:none\"><span>".$hour_f['currentDateTime']."</span></li>";
                                                 echo "<li class=\"tsfh\" style=\"text-align:center;width:10%\"><span>".date("j/m", $hour_f['currentDateTime'])."</span></li>";
						 echo "<li class=\"timefh\" style=\"text-align:center;width:12%\"><span>".$hour_f['time']."</span></li>";
						 echo "<li class=\"forecasttemp\" style=\"text-align:center;width:10%\" id=\"tempfh".intval($hour_f['time'])."\"><span>"."</span></li>";
						 echo "<li class=\"\" style=\"text-align:center;width:9%\"><img src=\"images/icons/day/".$hour_f['icon']."\" height=\"30\" width=\"30\" alt=\"".$hour_f['icon']."\" /></li>";
						 //echo "<li class=\"\" style=\"width:15%\">".$hour_f['wind'].",</li>";
						 echo "<li class=\"\" style=\"width:35%\"><span>".$hour_f['title']."</span></li>";
						 echo "</ul>";
						 }
						 }
						 ?>
	</div>
</div>
<div style="padding:1em;clear:both">
<? echo $detailedforecast;?>
</div>
<? if (($current->is_light())&&(!isRaining())) {$adsense_color = "#4B6371"; if ($current->is_sunset()) $adsense_background = "#FDAC60"; else $adsense_background = "#BCE3EA";} elseif (isRaining()) {$adsense_color = "#FFFFFF";$adsense_background = "#6288A4";} else {$adsense_color = "#FFFFFF";$adsense_background = "#9CD5E0";};?>
<? if ($width=="320px") {?>
<script type="text/javascript"><!--
google_ad_client = "ca-pub-2706630587106567";
/* Ad small page */
google_ad_slot = "6699246495";
google_ad_width = 320;
google_ad_height = 50;
google_color_border = ["<?= $adsense_background ?>"];
google_color_bg = ["<?= $adsense_background ?>"];
google_color_link = ["<?= $adsense_color ?>"];
google_color_url = ["<?= $adsense_color ?>"];
google_color_text = ["<?= $adsense_color ?>"];
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
<?}?>
<div style="text-align: center"><a href="images/webCamera.jpg" title="<? echo($LIVE_PICTURE[$lang_idx]);?>"><img src="phpThumb.php?src=<?=$imagefile?>&amp;w=180" width="180" alt="<? echo($LIVE_PICTURE[$lang_idx]);?>" /></a></div>
<div style="clear:both">&nbsp;</div>
<? if (($current->is_light())&&(!isRaining())) {$adsense_color = "#4B6371"; if ($current->is_sunset()) $adsense_background = "#FDAC60"; else $adsense_background = "#BCE3EA";} elseif (isRaining()) {$adsense_color = "#FFFFFF";$adsense_background = "#6288A4";} else {$adsense_color = "#FFFFFF";$adsense_background = "#ADDBE4";};?>
<? if ($width=="320px") {?>
<script type="text/javascript"><!--
google_ad_client = "ca-pub-2706630587106567";
/* Ad small page */
google_ad_slot = "6699246495";
google_ad_width = 320;
google_ad_height = 50;
google_color_border = ["<?= $adsense_background ?>"];
google_color_bg = ["<?= $adsense_background ?>"];
google_color_link = ["<?= $adsense_color ?>"];
google_color_url = ["<?= $adsense_color ?>"];
google_color_text = ["<?= $adsense_color ?>"];
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
<?}?>
</div>

<div id="radarTab" class="big" style="padding:1em">
		
			<a href="<? echo BASE_URL;?>/station.php?section=radar.php&amp;lang=<?=$lang_idx;?>">
				<? echo $RAIN_RADAR[$lang_idx];?><?=get_arrow()?>
			</a>
		
</div>
</div>
 
<div class="chatmobile">
<? include "chat.php"; ?>
</div>
<?}// end  homepage?>
<? if ((!isSnowing())&&(isRaining())) { ?>
<script src="js/rain.js"></script>
<? }?>
<? if (isSnowing()||(stristr($template_routing, 'snow'))) { ?>
<script src="js/snow.js"></script>
<? }?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"  type="text/javascript"></script>
<script src="jquery.colorbox.js"  type="text/javascript"></script>
<script src="js/tinymce/tinymce.min.js"></script>
<script src="footerScripts.php?lang=<?=$lang_idx?>"  type="text/javascript"></script>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-647172-1";
urchinTracker();
startup(<?=$lang_idx?>, <?=$limitLines?>, "<?=(isset($_GET['update'])?$_GET['update']:'')?>");
getTempForecast(<?=$timetaf?>, '<?=$dayF."/".$monthF."/".$yearF?>'); 

</script>
</body>
</html>
<? if ($_GET['debug'] == '') include "end_caching.php"; ?>