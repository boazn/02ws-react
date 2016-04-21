<?
header('Content-type: text/html; charset=utf-8');
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
else if ($_REQUEST['section'] != "")
    $width = "570px";
else
    $width = "1200px";
?>
<!DOCTYPE html>
<html  <? if (isHeb()) echo "lang=\"he\" xml:lang=\"he\""; ?> xmlns="http://www.w3.org/1999/xhtml">
<head>
<link title="Default Colors" href="basestyle.php<?echo "?lang=".$lang_idx;?>" rel="stylesheet" type="text/css" media="screen" /> 
 <link rel="stylesheet" href="css/main.php?lang=<?=$lang_idx;?>" type="text/css">
        <? if ($current->is_sunset()) { ?>
        <link rel="stylesheet" href="css/sunset.min.css" type="text/css">
        <? }?>
        <? if ($current->is_sunrise()) { ?>
        <link rel="stylesheet" href="css/sunrise.min.css" type="text/css">
        <? }?>
        <? if (($current->is_light())&&($current->get_cloudiness() > 6)) {?>
             <link rel="stylesheet" href="css/cloudy.min.css" type="text/css" media="screen">
        <? }?>
        <? if ($current->get_pm10() > 250) { ?>
        <link rel="stylesheet" href="css/dust.min.css" type="text/css">
        <? }?>
        <? if (!$current->is_light()) { ?>
        <link rel="stylesheet" href="css/night.min.css" type="text/css">
            <? if ($current->get_pm10() > 250) { ?>
            <link rel="stylesheet" href="css/dust-night.min.css" type="text/css">
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
<link rel="stylesheet" href="css/mobile.php<?echo "?lang=".$lang_idx."&amp;width=".$width;?>" type="text/css" media="screen">
        <link rel="icon" type="image/png" href="img/favicon_sun.png">
		
<meta http-equiv="Refresh" content="600" />

<title><? echo $LOGO[$lang_idx];?></title>
<style>
    
#main_cellphone_container::before{
    content:' ';
     
    overflow-y: hidden;
    overflow-x: hidden;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
    opacity: 0.4;
    display: block;
    position: absolute;
    -ms-background-size: cover;
    -o-background-size: cover;
    -moz-background-size: cover;
    -webkit-background-size: cover;
     background-size: cover;
    
}
 body, .inparamdiv{   
     font-size:34px
 }
 .inparamdiv{
     width:500px;
     height:380px
 }
 #latestnow
 {
     padding: 2.5em 0.2em 1em 0.2em;
     margin: 0 auto;
    
 }
 #itfeels_windchill, #itfeels_heatidx, #itfeels_thsw{
     font-size:58px;width:100%;top:2em
 }
 #statusline{
     font-size: 1.9em;margin-top:-0.8em;
 }
 .smalllogo
 {
     height:50px;margin-top: 0.6em;
     <? if (!$current->is_light()||isRaining()) { ?>
    color:#ffffff
    <?}?>
 }
 #logo
 {
     
    height: 112px;
    background-size: 112px;
    margin-<?echo get_s_align();?>:10px;
     width:85%;
     position:relative;
     text-align: center;
     display: inline-block;
     font-family: nextexitfotlight;
     font-size: 1.5em;
 }
 #currentinfo_container
 {
     margin-top: -1.5em
 }
 #what_is_h{
     font-size: 1.4em;
     line-height: 1.2em;
     margin-<?=get_s_align()?>:-380px;
     top: 165px;
     position: absolute;
    <? if (!$current->is_light()||isRaining()) { ?>
    color:#ffffff
    <?}?>
     
 }
 .paramunit{
     font-family: Alef;
     font-size:0.7em
     
 }
 #tempdivvalue
{
    font-weight: normal;
    font-family: nextexitfotlight;
    font-size:6.5em
}
#windy
{
    width: 10%;
    left: 6.5em;
    top: 2.8em;
}   
#shortforecast
{
    width: 30%;
    position:absolute;
    font-family:nextexitfotlight;
    font-size: 1.3em;
    <?=get_inv_s_align()?>:<? if (isHeb()) echo "-";?>100px;
    margin-top: -480px;
    <? if (!$current->is_light()||isRaining()) { ?>
    color:#ffffff
    <?}?>
}
#shortforecast .nav li{
    width: auto;
    padding:0.1em;
    margin: 0.8em 1em;
}
.nav
{
    font-size:1.2em
}
</style>
</head>
<body>
<!-- SNOW EFFECT-->
<canvas id="canvas"></canvas>
<canvas id="toimage"></canvas>
<div style="width:<?=$width?>" <? if (isheb()) echo "dir=\"rtl\""; ?> id="main_cellphone_container">

<div class="smalllogo" id="logo">
<? if (isHeb()) echo $dateInHeb; else echo $date;?>
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
 <?$itfeels = array();
   $itfeels = $current->get_itfeels();
    if ($itfeels[0] == "windchill" ){ ?>
            <div id="itfeels_windchill"> 
            <a title="<?=$WIND_CHILL[$lang_idx]?>" href="<?=$_SERVER['SCRIPT_NAME']?>?section=graph.php&amp;graph=tempwchill.php&amp;profile=1&amp;lang=<?=$lang_idx?>"> 
                    <? echo $IT_FEELS[$lang_idx]; ?>
                    <span dir="ltr" class="low" title="<?=$WIND_CHILL[$lang_idx]?>"><? echo min($current->get_windchill(), $current->get_thw())."&#176;"; ?></span>
             </a> 
            </div>

    <? } 
    else if ($itfeels[0] == "heatindex"){  ?>
            <div class="" id="itfeels_heatidx">
            <a title="<?=$HEAT_IDX[$lang_idx]?>"  href="<?=$_SERVER['SCRIPT_NAME']?>?section=graph.php&amp;graph=tempheat.php&amp;profile=1&amp;lang=<?=$lang_idx?>"> 
                    <? echo $IT_FEELS[$lang_idx]; ?>
                    <span dir="ltr" class="high" title="<?=$HEAT_IDX[$lang_idx]?>"><? echo max($current->get_HeatIdx(), $current->get_thw())."&#176;";  ?></span>
             </a> 
            </div>
    <?} else if ($itfeels[0] == "thsw"){?>
                                        <div class="" id="itfeels_thsw">
                                         <a title="<?=$THSW[$lang_idx]?>"  href="<?=$_SERVER['SCRIPT_NAME']?>?section=graph.php&amp;graph=THSWHistory.gif&amp;profile=1&amp;lang=<?=$lang_idx?>"> 
                                                <? echo $IT_FEELS[$lang_idx]; ?>
                                                <span dir="ltr" class="high" title="<?=$THSW[$lang_idx]?>"><? echo $itfeels[1]."&#176;";  ?></span>
                                                <? echo " ".$IN_THE_SUN[$lang_idx]; ?>
                                         </a> 
                                        </div>
                            <?}?>
<div id="tempdivvalue">
<a href="<?=$_SERVER['SCRIPT_NAME']?>?section=graph.php&amp;graph=temp.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>&amp;style=<?=$_GET["style"]?>"><? echo $current->get_temp()."<span class=\"paramunit\">&#176;c"; ?></span></a>
</div>

<div id="statusline">
        <div  id="windy">
        <? echo getWindStatus($lang_idx);?>
        </div>
        <div  id="coldmeter">
        <a href="<?=$_SERVER['SCRIPT_NAME']?>?section=survey.php&amp;survey_id=2&amp;lang=<? echo $lang_idx;?>"><span id="current_feeling_link" title="<?=$HOTORCOLD_T[$lang_idx]?> - <?=$COLD_METER[$lang_idx]?>">...</span>
        </a> 
        </div>
</div>
<? if (count($sig) > 1) { ?>
<div id="what_is_h"><? echo "{$sig[0]['sig'][$lang_idx]}"; ?><br /><? echo $sig[0]['extrainfo'][$lang_idx];?></div>
<?}?>
<!--<div id="more_info_btn">	
<a href="javascript:void(0)" title="<? echo $HUMIDITY[$lang_idx];?>&nbsp;<? echo $WIND[$lang_idx];?>&nbsp;<? echo $RAIN[$lang_idx];?>" onclick="toggle('latestnow');toggle('extendedInfo');">
 <? echo $MORE_INFO[$lang_idx];?>&nbsp;<?=get_arrow()?>	
</a>
</div>-->
</div>
<div id="shortforecast">
    <ul class="nav">
        <li style="border:none">
            <?echo "".replaceDays($forecastDaysDB[0]['day_name']." ")."&nbsp;&nbsp;&nbsp;&nbsp;".$forecastDaysDB[0]['date'];?><br/><br/><br/>
            <img src="<? echo "images/icons/day/".$forecastDaysDB[0]['icon']; ?>" width="80" height="80" alt="<? echo "images/icons/day/".$forecastDaysDB[0]['icon']; ?>" /><br/><br/><br/>
            <?=c_or_f($forecastDaysDB[0]['TempLow'])?>&nbsp;-&nbsp;<?=c_or_f($forecastDaysDB[0]['TempHigh'])?>
        </li>
        <li>
            <?echo "".replaceDays($forecastDaysDB[1]['day_name']." ")."&nbsp;&nbsp;&nbsp;&nbsp;".$forecastDaysDB[1]['date'];?><br/><br/><br/>
            <img src="<? echo "images/icons/day/".$forecastDaysDB[1]['icon']; ?>" width="80" height="80" alt="<? echo "images/icons/day/".$forecastDaysDB[1]['icon']; ?>" /><br/><br/><br/>
            <?=c_or_f($forecastDaysDB[1]['TempLow'])?>&nbsp;-&nbsp;<?=c_or_f($forecastDaysDB[1]['TempHigh'])?>
        </li>
        
    </ul>
</div>
</div>
<div id="spacer" style="line-hight:4em;clear:both">&nbsp;</div>    
    
<!-- Parallax  midground clouds -->
	<!-- Parallax  midground clouds -->
	<div id="parallax-bg2">
                       
                    <div id="bg2-1" class="cloud3"><div class="cloud3-more"></div></div>


<? if ($current->get_cloudiness() > 2) {?>
                    <div id="bg2-3" class="cloud2"><div class="cloud2-more"></div></div>
                    <div id="bg2-2" class="cloud4"><div class="cloud4-more"></div></div>
                    <div id="bg2-4" class="cloud1"><div class="cloud1-more"></div></div>
                    <div id="bg2-5" class="cloud-big"><div class="cloud-big-more"></div></div>
                     <div id="bg2-6" class="cloud4"><div class="cloud4-more"></div></div>

                    <?}?>
                    <? if ($current->get_cloudiness() > 5) {?>
                    <div id="bg2-7" class="cloud2"><div class="cloud2-more"></div></div>
                    <div id="bg2-8" class="cloud-big"><div class="cloud-big-more"></div></div>
                    <?}?>
                    <? if ($current->get_cloudiness() > 6) {?>
                    <div id="bg2-9" class="cloud-big"><div class="cloud-big-more"></div></div>
                    <div id="bg2-10" class="cloud-big"><div class="cloud-big-more"></div></div>
                    <?}?>
                        
                        
	</div>
	<? if (($current->is_light())&&($current->get_cloudiness() > 6)) {?>
        <link rel="stylesheet" href="css/cloudy.css" type="text/css" media="screen">
        <? }?>
	<!-- Parallax  background clouds -->
	<div id="parallax-bg1">
                        <div id="bg1-1" class="cloud4"><div class="cloud4-more"></div></div>

<? if ($current->get_cloudiness() > 2) {?>
                        <div id="bg1-2" class="cloud3"><div class="cloud3-more"></div></div>
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
</div>

<?}// end  homepage?>
<? if ((!isSnowing())&&(isRaining())) { ?>
<script src="js/rain.js"></script>
<? }?>
<? if (isSnowing()||(stristr($template_routing, 'snow'))) { ?>
<script src="js/snow.js"></script>
<? }?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"  type="text/javascript"></script>
<script src="footerScripts.php?lang=<?=$lang_idx?>"  type="text/javascript"></script>
<script type="text/javascript">
var coldmeter_size = 40;
startup(<?=$lang_idx?>, <?=$limitLines?>, "<?=(isset($_GET['update'])?$_GET['update']:'')?>");
</script>
</body>
</html>
<? if ($_GET['debug'] == '') include "end_caching.php"; ?>