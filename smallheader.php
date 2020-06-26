<?
header('Content-type: text/html; charset=utf-8');
if ($_GET['debug'] == '')
	include "begin_caching.php";
include_once("include.php"); 
include "start.php";
include_once ("requiredDBTasks.php");
include "sigweathercalc.php";

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
    $width = "1100px";
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
.spriteB.up, .spriteB.down{
    width: 15px;
    height: 20px;
    background-size: 0.3em;
}
 body, .inparamdiv{   
     font-size:38px;
     font-weight:bold;
 }
 .inparamdiv{
     width:500px;
     height:380px
 }
 #latestnow
 {
     padding: 2em 0.2em 1em 0.2em;
     margin: 0 auto;
    
 }
 #itfeels_windchill, #itfeels_heatidx, #itfeels_thsw, #itfeels_thw{
     width:100%;top:0.2em;
 }
 #statusline{
     font-size: 1.8em;margin-top:-3.9em;font-weight:bold;
 }
 #laundryidx{
     position:absolute;
    left: 9.2em;
    top: 6.9em;
 }
 #laundryidx img{
     width:120px;height:120px
 }
 .smalllogo
 {
     height:50px;margin-top: 0.6em;
     <? if (!$current->is_light()||isRaining()) { ?>
    color:#ffffff
    <?}?>
 }
 #date
 {
     font-size:1em;
     margin-top: 0.1em; 
 }
 #itfeels_windchill, #itfeels_heatidx, #itfeels_thsw, #itfeels_thw, #itfeels{
    position: initial;
    font-size: 1.6em;
 }
 .wind_icon{
 background-size: 390%;
    width: 100px;
    height: 34px;
 }
 .moderate_wind{
    background-position: -100px -5px;
 }
 .light_wind{
    background-position: -180px -5px;
 }
 .strong_wind{
    background-position: -10px -5px;
 }
 #logo
 {
     
    height: 90px;
    background-size: 90px;
    margin-<?echo get_s_align();?>: 395px;
    margin-top: 0.3em;
    padding-top: 0.35em;
     width:45%;
     position:relative;
     text-align: center;
     display: inline-block;
     font-family: nextexitfotlight;
     font-size: 1.8em;
    
      background-position: <?echo get_s_align();?> 0px top;
 }
 #currentinfo_container
 {
     margin-top: -1.5em;
     margin: auto 9em;
 }
 #what_is_h{
     font-size: 1.5em;
     line-height: 1em;
     margin-<?=get_s_align()?>:-250px;
     top: -190px;
     width:50%;
     font-weight: bold;
     position: absolute;
    <? if (!$current->is_light()||isRaining()) { ?>
    color:#ffffff
    <?}?>
     
 }
 .paramunit{
     font-family: Alef;
     font-size:0.2em
     
 }
 #tempdivvalue
{
    font-weight: normal;
    font-family: nextexitfotlight;
    font-size:6.5em;
    margin-top: -20px;
}
#heatindex
{
    margin-top:140px;
}
#windy
{
    width: 10%;
    left: 4em;
    top: 0.2em;
}
#curerentcloth
{
    left:6em;
}   
#shortforecast
{
    width: 33%;
    position:absolute;
    font-family:nextexitfotlight;
    font-size: 1.3em;
    <?=get_inv_s_align()?>:-30px;
    margin-top: -410px;
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
<span id="date">
<? if (isHeb()) echo $dateInHeb; else echo $date;?>
</span>
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
<div id="itfeels">
 <?$itfeels = array();
   $itfeels = $current->get_itfeels();
   if ($current->is_sun()) { ?>
    <? echo $IT_FEELS[$lang_idx]; ?>
     <a title="<?=$THSW[$lang_idx]?>"  href="<?=$_SERVER['SCRIPT_NAME']?>?section=graph.php&amp;graph=THSWHistory.gif&amp;profile=1&amp;lang=<?=$lang_idx?>"> 
           
            <span dir="ltr" class="high" title="<?=$THSW[$lang_idx]?>"><? echo $current->get_thsw();  ?></span>
     </a><img src="images/shadow.png" width="15" title="<? echo $IN_THE_SUN[$lang_idx]."/".$SHADE[$lang_idx]; ?>" alt="<? echo $SHADE[$lang_idx]."/".$IN_THE_SUN[$lang_idx]; ?>" /><? }
else if (!empty($itfeels[0]))
    echo $IT_FEELS[$lang_idx]; 
if ($itfeels[0] == "windchill" ){ ?>
     <a title="<?=$WIND_CHILL[$lang_idx]?>" href="<? echo $_SERVER['SCRIPT_NAME']; ?>?section=graph.php&amp;graph=tempwchill.php&amp;profile=1&amp;lang=<?=$lang_idx?>"> 
            <span dir="ltr" class="low" title="<?=$WIND_CHILL[$lang_idx]?>"><? echo $itfeels[1]; ?></span> 
     </a>
<? } 
else if ($itfeels[0] == "heatindex"){ ?>
<a title="<?=$HEAT_IDX[$lang_idx]?>"  href="<?=$_SERVER['SCRIPT_NAME']?>?section=graph.php&amp;graph=tempheat.php&amp;profile=1&amp;lang=<?=$lang_idx?>"> 
<span dir="ltr" class="high" title="<?=$HEAT_IDX[$lang_idx]?>"><? echo $itfeels[1];  ?></span> 
</a>

<?}else if ($itfeels[0] == "thw"){?>
                                <a title="<?=$THW[$lang_idx]?>"  href="<?=$_SERVER['SCRIPT_NAME']?>?section=graph.php&amp;graph=thw.php&amp;profile=1&amp;lang=<?=$lang_idx?>"> 
                                <span id="itfeels_thw" dir="ltr" class="value" title="<?=$THW[$lang_idx]?>"><? echo $itfeels[1];  ?></span> 
                                </a>
                              <?}?>
    </div>
<div id="tempdivvalue">
<a href="<?=$_SERVER['SCRIPT_NAME']?>?section=graph.php&amp;graph=temp.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>&amp;style=<?=$_GET["style"]?>"><? echo $current->get_temp()."<div class=\"paramunit\">&#176;</div><div class=\"param\">".$current->get_tempunit()."</div></a>"; ?>
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
<div id="what_is_h"><? echo "{$sig[0]['sig'][$lang_idx]}"; ?><br /><? echo $sig[0]['extrainfo'][$lang_idx][0];?></div>
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
            <? $firstDay = reset($forecastDaysDB);$secondDay = array_slice($forecastDaysDB, 1, 1)[0];?>
            <?echo "".replaceDays($firstDay['day_name']." ")."&nbsp;&nbsp;&nbsp;&nbsp;".$firstDay['date'];?><br/><br/><br/>
            <img src="<? echo "images/icons/day/".$firstDay['icon']; ?>" width="80" height="80" alt="<? echo "images/icons/day/".$firstDay['icon']; ?>" /><br/><br/><br/>
            <?=c_or_f($firstDay['TempLow'])?>&nbsp;-&nbsp;<?=c_or_f($firstDay['TempHigh'])?>
        </li>
        <!--<li>
            <?echo "".replaceDays($secondDay['day_name']." ")."&nbsp;&nbsp;&nbsp;&nbsp;".$secondDay['date'];?><br/><br/><br/>
            <img src="<? echo "images/icons/day/".$secondDay['icon']; ?>" width="80" height="80" alt="<? echo "images/icons/day/".$secondDay['icon']; ?>" /><br/><br/><br/>
            <?=c_or_f($secondDay['TempLow'])?>&nbsp;-&nbsp;<?=c_or_f($secondDay['TempHigh'])?>
        </li>-->
        
    </ul>
</div>
</div>
<div id="spacer" style="line-height: 0.1em;clear:both">&nbsp;</div>    
    
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
                        

<? if ($current->get_cloudiness() > 2) {?>
                        <div id="bg1-2" class="cloud3"><div class="cloud3-more"></div></div>
                        <div id="bg1-3" class="cloud4"><div class="cloud4-more"></div></div>
                        <div id="bg1-4" class="cloud-big"><div class="cloud-big-more"></div></div>
                        <div id="bg1-5" class="cloud3"><div class="cloud3-more"></div></div>
                        <div id="bg1-6" class="cloud2"><div class="cloud2-more"></div></div>
                        <?}?>
                        <? if ($current->get_cloudiness() > 5) {?>
                        <div id="bg1-1" class="cloud4"><div class="cloud4-more"></div></div>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"  type="text/javascript"></script>
<script src="footerScripts250320.php?lang=<?=$lang_idx?>"  type="text/javascript"></script>
<script type="text/javascript">
var coldmeter_size = 40;
startup(<?=$lang_idx?>, <?=$limitLines?>, "<?=(isset($_GET['update'])?$_GET['update']:'')?>");
function refreshContent(){
        $.ajax({
        type: "GET",
        url: "02wsjson.txt",
        beforeSend: function(){$(".loading").show();}
        }).done(function( jsonstr  ) {
        try{

                fillAllJson(jsonstr);
                $(".loading").hide();
        }
        catch (e) {
                //alert ('error:' + e);
        }
        });
    }
    
    setInterval(refreshContent, 60000);
</script>
</body>
</html>
<? if ($_GET['debug'] == '') include "end_caching.php"; ?>