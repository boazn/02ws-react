<?
header('Content-type: text/html; charset=utf-8');
header("Access-Control-Allow-Origin: null");
ini_set("display_errors","Off");
ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE);
if ($_GET['debug'] == '')
include "begin_caching.php";
$HOME_PAGE = array("To home page","לעמוד הראשי");
$HOTORCOLD_T = array("Cold meter", "מדד הקור");
$IT_FEELS = array("feels like", "מרגיש כמו");
$IN_THE_SUN = array("in the sun", "בשמש");
$MINTS = array("min", "דק'");
$DAILY_RAIN = array("Daily rain", "גשם היום מחצות");
$TOTAL_RAIN = array("Total", "סה'כ");
$RAIN_RATE = array("Rain rate" , "עוצמת גשם");
$TEMP = array("Temperature" , "טמפרטורה");
$WIND = array("wind" , "רוח");
$HUMIDITY = array("humidity" , "לחות");
$HOURS = array("hrs", "שעות");
$FORECAST_4D = array("Next Days", "הימים הבאים");
$GIVEN = array("given", "ניתנה");
$AT = array("at ", "ב-");
$MESSAGES = array("Messages and alerts", "הודעות והתראות");
$LIVE_PICTURE = array("Live Air", "שידור חי");
$RAIN_UNIT = array("mm", "מ''מ");
$WIND_UNIT = array("knots", "קשר");
$RAINRATE_UNIT = array("mm/hr", "מ''מ\שעה");
$MALE = array("Male", "גבר");
$FEMALE = array("Female", "אישה");
$NOR_MALE_NOR_FEMALE = array("no male nor female", "לא רוצה לציין");
$CHAT_TITLE = array("Forum", "פורום");
$RAIN_RADAR = array("Radar", "מכ''ם גשם");
$VALLEY = array("valley", "בעמק");
$MOUNTAIN = array("hill", "בהר");
$AVERAGE = array("average", "ממוצע");
$MOBILE_FRIENDLY = array("Mobile friendly" , "מותאם לנייד");
$CONTACT_ME = array("Contact", "צרו קשר");
function mainPage()
{
    return ($_REQUEST['section'] == "");
}
if (mainPage()) 
{}
else if (!isFastPage())
{
    include_once("include.php"); 
    include "start.php";
    include_once ("requiredDBTasks.php");
    include "sigweathercalc.php";
    include_once("forecastlib.php");
}
if (!function_exists('get_arrow')){
function get_arrow(){
	if (isHeb())
		return "&nbsp;&#8250;&#8250;"; //"&#9668;";
	else
		return "&nbsp;&#8250;&#8250;"; //"&#9658;";
}}
if (!function_exists('isHeb')){
function isHeb()
{
	global $lang_idx;
	return ($lang_idx == 1);
}
}
$lang_idx = $_REQUEST['lang'];
$adFree = $_REQUEST['ad'];
if ($lang_idx == "")
    $lang_idx = 1;

if (($_REQUEST['section'] != "")&&($_REQUEST['section'] != "SendEmailForm.php")&&($_REQUEST['section'] != "smallwebcam.php")&&($_REQUEST['section'] != "SendSpecial.php")&&($_REQUEST['section'] != "alerts.php")&&($_REQUEST['section'] != "chat.php")&&($_REQUEST['section'] != "graph.php"))
    $width = "570";
else if ($_REQUEST['section'] == "graph.php")
    $width = "960";
else
    $width = "320";

function isFastPage(){
    return (($_REQUEST['section'] == "alerts.php")||($_REQUEST['section'] == ""));
}
?>
<!DOCTYPE html>
<html  <? if (isHeb()) echo "lang=\"he\" xml:lang=\"he\"" ; ?> xmlns="http://www.w3.org/1999/xhtml">
<head>

<link rel="stylesheet" href="css/main.php?lang=<?=$lang_idx;?>&type=" type="text/css">
<link rel="stylesheet" href="css/mobile.php<?echo "?lang=".$lang_idx."&amp;width=".$width."&amp;fullt=".$_REQUEST['fullt']."&amp;c=".$_REQUEST['c'];?>" type="text/css" />

<link rel="icon" type="image/png" href="img/favicon_sun.png" />
<meta http-equiv="Refresh" content="1800" />
<meta property="og:image" content="http://www.02ws.co.il/02ws_short.png" />
<meta name="viewport" content="width=<?=$width?><? if (isFastPage()) echo ",user-scalable=no";?>" />
<title><?=$MOBILE_FRIENDLY[$lang_idx]?></title>
<script id="loadGA">
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-647172-1', 'auto');
    ga('send', 'pageview');

</script>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-2706630587106567",
    enable_page_level_ads: true
  });
</script>
</head>
<body >
<!-- SNOW EFFECT-->
<canvas id="canvas" style="display:none"></canvas>
<div style="" id="main_cellphone_container">
<div class="loading"><img src="img/loading.gif" alt="loading" width="32" height="32" /></div>
<? if (!$adFree==1) {?>
<div id="adunit1">
<div class="crayze_placement" placement="02ws-main">
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- Ad small page -->
    <ins class="adsbygoogle"
         style="display:inline-block;width:320px;height:50px"
         data-ad-client="ca-pub-2706630587106567"
         data-ad-slot="6699246495"></ins>
    <script>
    (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
</div>
</div>
<?}?>
<div id="logo" <?if (!mainPage()) echo " class=\"logo_secondary\"";?>>
<a href="station.php?section=frommobile&amp;lang=<? echo $lang_idx;?>" id="logotitle" title="<? echo $HOME_PAGE[$lang_idx];?>" onclick="showLoading()">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
<div id="date"></div>&nbsp;&nbsp;&nbsp;

<? if (!isHeb()) {?>
<div dir="ltr" class="il_image" id="tempunitconversion">
       <a id="postc" href="javascript:void(0)" onclick="redirect('small.php?lang=<? echo $lang_idx;?>&amp;tempunit=&#176;C')" style="display:none;text-decoration:underline">&#176;C</a>
        <span id="spanc" style="display:none">&#176;C</span>
        &nbsp;&nbsp;&nbsp; 
        <a id="postf" href="javascript:void(0)" onclick="redirect('small.php?lang=<? echo $lang_idx;?>&amp;tempunit=&#176;F')" style="display:none;text-decoration:underline">&#176;F</a>
        <span id="spanf" style="display:none">&#176;F</span>
 </div>
<?}	?>
</div>
<? if ($_GET['section'] != "") { ?>
<div id="tohome" class="invfloat inv_plain_3">
<a href="<? echo BASE_URL.substr(strrchr($_SERVER["PHP_SELF"], "/"), 0)."?lang=".$lang_idx."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c'];?>"  title="<? echo $HOME_PAGE[$lang_idx];?>" class="hlink">
<? echo $HOME_PAGE[$lang_idx];?>
</a>
</div>
<? include($_GET['section']);}
else {?>
<div id="currentinfo_container">
<ul class="info_btns" style="display:none">
   <li id="temp_btn" onclick="change_circle('temp_line', 'latesttemp')" title=""></li>
   <li id="moist_btn" onclick="change_circle('moist_line', 'latesthumidity')" title=""></li>
   <li id="rain_btn" onclick="change_circle('rain_line', 'latestrain')" title=""></li>
   <li id="wind_btn" onclick="change_circle('wind_line', 'latestwind')" title=""></li>
</ul>
<ul class="seker_btns" style="display:none">
<li id="cold_btn">
    <a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=survey.php&amp;survey_id=2&amp;lang=<? echo $lang_idx."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c'];?>" onclick="showLoading()">
    <?=$HOTORCOLD_T[$lang_idx]?>
    </a>
</li>
</ul>
<div id="latestnow" class="inparamdiv">
 <div  id="windy">

 </div>
    
<div id="itfeels_windchill" style="display:none;"> 
<a title="" href="<?=$_SERVER['SCRIPT_NAME']?>?section=graph.php&amp;graph=tempwchill.php&amp;profile=1&amp;lang=<?=$lang_idx."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c']?>" onclick="showLoading()"> 
        <? echo $IT_FEELS[$lang_idx]; ?>
        <span dir="ltr" class="low value" title="<?=$WIND_CHILL[$lang_idx]?>">&#176;</span>
 </a> 
</div>


<div class="" id="itfeels_heatidx" style="display:none;">
<a title="" href="<?=$_SERVER['SCRIPT_NAME']?>?section=graph.php&amp;graph=tempheat.php&amp;profile=1&amp;lang=<?=$lang_idx."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c']?>" onclick="showLoading()"> 
        <? echo $IT_FEELS[$lang_idx]; ?>
        <span dir="ltr" class="high value" title="<?=$HEAT_IDX[$lang_idx]?>">&#176;</span>
 </a> 
</div>
<div class="" id="itfeels_thsw" style="display:none;">
    <a title="<?=$THSW[$lang_idx]?>"  href="<?=$_SERVER['SCRIPT_NAME']?>?section=graph.php&amp;graph=THSWHistory.gif&amp;profile=1&amp;lang=<?=$lang_idx."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c']?>"> 
           <? echo $IT_FEELS[$lang_idx]; ?>
           <span dir="ltr" class="high value" title="<?=$THSW[$lang_idx]?>"><? echo $itfeels[1]."&#176;";  ?></span>
           <? echo " ".$IN_THE_SUN[$lang_idx];; ?>
    </a> 
</div>  
<div id="tempdivvalue" style="visibility:hidden">

</div>
<div id="statusline" style="visibility:hidden">
    <div  id="coldmeter">
    <span id="current_feeling_link" title="<?=$HOTORCOLD_T[$lang_idx]?>">&nbsp;</span>
    </div>
</div>
<div id="what_is_h" style="visibility:hidden"></div>
</div>
<div id="latesttemp" class="inparamdiv" style="display:none;">
        <div class="paramtitle slogan">
             <a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=tempLatest.php&amp;profile=1&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c']?>" title="" onclick="showLoading()"><? echo $TEMP[$lang_idx];?></a>
         </div>
        <div class="paramvalue">
             
         </div>
         <div class="highlows">
                 <div class="high"><strong></strong></div>&nbsp;<img src="img/peak_max.png" width="15" height="14" alt=""/>&nbsp;<span class="high_time"></span>
                 <div class="low"><strong></strong></div>&nbsp;<img src="img/peak_min.png" width="15" height="14" alt=""/>&nbsp;<span class="low_time"></span>
         </div> 
         <div class="paramtrend relative">
             <div class="innertrendvalue">
                <? echo " ".($MINTS[$lang_idx]).": "; ?>
             </div>
         </div>  
   <div class="trendstable"> 
        <table>
                 <tr class="trendstitles">
                         <td  class="box" title=""><img src="img/24_icon.png" width="21" height="21" alt=""/></td>
                         <td  class="box" title=""><img src="img/hour_icon.png" width="21" height="21" alt="hour"/></td>
                         <td  class="box" title=""><img src="img/half_icon.png" width="21" height="21" alt="half hour"/></td>
                 </tr>
                 <tr class="trendsvalues">
                     <td><div class="trendvalue"><div class="innertrendvalue"></div></div></td>
                     <td ><div class="trendvalue"><div class="innertrendvalue"></div></div></td>
                     <td ><div class="trendvalue"><div class="innertrendvalue"></div></div></td>
                 </tr>
         </table>
    </div>
    <div class="graphslink">
                 <a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=tempLatest.php&amp;profile=1&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c']?>" title="" onclick="showLoading()"><img src="img/graph_icon.png" width="35" height="18" alt="to graphs"/></a>
    </div>
 </div>
<div id="latesttemp2" class="inparamdiv" style="display:none;">
    
</div>
<div id="latesthumidity" class="inparamdiv" <? if (isHeb()) echo "dir=\"rtl\" ";?> style="display:none">
    <div class="paramtitle slogan">
                <a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=humwind.php&amp;level=1&amp;freq=2&amp;datasource=downld02&amp;profile=1&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>&amp;style=<?=$_GET["style"]?>" title="" onclick="showLoading()"><? echo $HUMIDITY[$lang_idx];?></a>
        </div>
        <div class="paramvalue">
                
        </div>
        <div class="highlows">
            <div class="highparam"><strong></strong></div>&nbsp;<img src="img/peak_max.png" width="15" height="14" alt=""/>&nbsp;<span class="high_time"></span>
            &nbsp;&nbsp;&nbsp;&nbsp;<div class="lowparam"><strong></strong></div>&nbsp;<img src="img/peak_min.png" width="15" height="14" alt=""/>&nbsp;<span class="low_time"></span>
         </div>
       <div class="paramtrend relative">
            <div class="innertrendvalue">
            
            </div>
        </div>
        <div class="trendstable">
        <table>
        <tr class="trendstitles">
                <td  class="box" title=""><img src="img/24_icon.png" width="21" height="21" alt=""/></td>
                <td  class="box" title=""><img src="img/hour_icon.png" width="21" height="21" alt="hour"/></td>
                <td  class="box" title=""><img src="img/half_icon.png" width="21" height="21" alt="half hour"/></td>
        </tr>
         <tr class="trendsvalues">
                     <td><div class="trendvalue"><div class="innertrendvalue"></div></div></td>
                     <td ><div class="trendvalue"><div class="innertrendvalue"></div></div></td>
                     <td ><div class="trendvalue"><div class="innertrendvalue"></div></div></td>
       </tr>
        </table>
        </div>
        <div class="graphslink">
                <a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=humwind.php&amp;level=1&amp;freq=2&amp;datasource=downld02&amp;profile=1&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>&amp;style=<?=$_GET["style"]?>" title="" onclick="showLoading()"><img src="img/graph_icon.png" width="35" height="18" alt="to graphs"/></a>
   </div>
</div>
<div id="latestpressure" class="inparamdiv" <? if (isHeb()) echo "dir=\"rtl\" ";?> style="display:none">
</div>
<div id="latestwind" class="inparamdiv" <? if (isHeb()) echo "dir=\"rtl\" ";?> style="display:none">
    <div class="paramtitle slogan">
        <? echo $WIND[$lang_idx];?>
   </div>
   <div id="windvalue" class="paramvalue">
        <div id="winddir" class="paramunit">
                 <div class="winddir"></div>
        </div>
        <div  id="windspeed">
        </div>
  </div>
    <div class="highlows">
            <div class="highparam"><strong></strong></div>&nbsp;<img src="img/peak_max.png" width="15" height="14" alt=""/>&nbsp;<span class="high_time"></span>
    </div>
    <div class="paramtrend relative">
            <div class="">  
              
            </div>
    </div>
    <div class="trendstable">	
      <table>
       <tr class="trendstitles">
            <td  class="box" title=""><img src="img/hour_icon.png" width="21" alt="hour" /></td>
            <td  class="box" title=""><img src="img/half_icon.png" width="21" alt="half hour"/></td>
            <td class="box" title=""><img src="img/quarter_icon.png" width="21" alt="quarter hour"/></td>
       </tr>
      </table>
    </div>
    <div class="graphslink">
                    <a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=wind.php&amp;profile=1&amp;lang=<? echo $lang_idx;?>&amp;style=<?=$_GET["style"]?>" ><img src="img/graph_icon.png" alt="to graphs"/></a>
    </div>
</div>
<div id="latestrain" class="inparamdiv" style="display:none" <? if (isHeb()) echo "dir=\"rtl\" ";?> title="">
<div class="paramtitle slogan">
    <? echo $RAIN_RATE[$lang_idx];?>
</div>
<div id="rainratevalue" class="paramvalue">

           

</div>
<div class="highlows">
    <div class="highparam"><strong></strong></div>&nbsp;<img src="img/peak_max.png" width="15" height="14" alt=""/><span class="high_time"></span>
</div>
<div class="paramtrend relative">
    <? echo $DAILY_RAIN[$lang_idx]; ?>:&nbsp;<span id="dailyrain"></span><br/>
<? echo $TOTAL_RAIN[$lang_idx]; ?>:&nbsp;<span id="totalrain"></span>
</div>
<div class="trendstable">
 <table id="rainrate15min">
<tr class="trendstitles">
        <td  class="box" title=""><img src="img/hour_icon.png" width="21" height="21" alt="hour"/></td>
        <td  class="box" title=""><img src="img/half_icon.png" width="21" height="21" alt="half hour"/></td>
        <td class="box" title=""><img src="img/quarter_icon.png" width="21" height="21" alt="quarter hour"/></td>
</tr>
<tr class="trendsvalues">
        <td><div class="trendvalue"><div class="innertrendvalue"></div></div></td>
        <td><div class="trendvalue"><div class="innertrendvalue"></div></div></td>
        <td><div class="trendvalue"><div class="innertrendvalue"></div></div></td>
</tr>
</table>
</div>
    <div class="graphslink">
            <a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=RainRateHistory.gif&amp;profile=1&amp;lang=<? echo $lang_idx;?>&amp;style=<?=$_GET["style"]?>" title="" onclick="showLoading()"><img src="img/graph_icon.png" width="35" height="18" alt="to graphs"/></a>
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
<a href="#forecastnextdays">
<div id="shortforecast" style="display:none">
    <ul class="nav"><li class="tsfh" style="border:none"></li><li class="tsfh"></li><li class="tsfh"></li><li class="tsfh"></li></ul>
 </div>
</a>
<div style="clear:both;height:20px">&nbsp;</div>
<div id="nextdays" style="display:none">
    <div id="for_title" class="float">
           <div id="for24h_title" class="forcast_title_btns for_active">
           <a href="javascript:void(0)" onclick="$('#forecast24h').show();$('#forecastnextdays').hide();$('#for24h_title').addClass('for_active');$('#fornextdays_title').removeClass('for_active')">
                   <? echo(" 24 ".$HOURS[$lang_idx]);?>
           </a>
           </div> 
           <div id="fornextdays_title" class="forcast_title_btns">
           <a href="javascript:void(0)" id="forecastnextdays_link" onclick="$('#forecastnextdays').show();$('#forecast24h').hide();$('#fornextdays_title').addClass('for_active');$('#for24h_title').removeClass('for_active')">
                   <? echo($FORECAST_4D[$lang_idx]); ?>
           </a>
   </div>
					
</div>

<div style="display:none;padding:0.1em 0.2em" id="forecastnextdays">
        <table id="forecastnextdays_table" <? if (isHeb()) echo "dir=\"rtl\""; ?> style="border-spacing:1px 8px;padding:3px;width:100%">
        
	</table> 
    <div id="adunit2" style="display:none">
    <? if (!$adFree==1) {?>
    <div class="crayze_placement" placement="02ws-week">
        <ins class="adsbygoogle"
     style="display:inline-block;width:320px;height:50px"
     data-ad-client="ca-pub-2706630587106567"
     data-ad-slot="5203551891"></ins>
        <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>
    <?}?>
    </div>
</div>
<div id="forcast_hours">
        
	<div id="for24_given">
							<? echo($GIVEN[$lang_idx]." ".$AT[$lang_idx]." ");?>
	</div>
	<div id="for24_details" style="display:none">
		<span id="tempForecastDiv" style="display:none">
		</span>
	</div>
            <div id="graph_forcast" >

            <canvas id="graphForcastContainer" style="position: relative"></canvas>
           <div id="chartjs-tooltip" class="inv_plain_3_zebra"></div>
           
            <div id="for24_hours">
        
            </div>
        
        </div>
    <div id="adunit3" style="display:none">
    <? if (!$adFree==1) {?>
    <!-- Ad small unit 3-->
       <div class="crayze_placement" placement="02ws-24">
            <!-- small unit 2 -->
            <ins class="adsbygoogle"
                 style="display:inline-block;width:320px;height:50px"
                 data-ad-client="ca-pub-2706630587106567"
                 data-ad-slot="3726818696"></ins>
            <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
    <?}?>
    </div>
  
</div>
</div>

<div id="messages_box" class="white_box" style="display:none">
    <h2><? echo $MESSAGES[$lang_idx];?></h2>
    <p class="box_text">
     
    </p>
</div>
<div id="livepic_box" class="white_box" style="display:none">
    <div class="avatar live_avatar"></div>
    
    <h3>&nbsp;&nbsp;</h3>
    <a href="<?=$_SERVER['SCRIPT_NAME']?>?section=smallwebcam.php&amp;lang=<?=$lang_idx."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c'];?>" title="<? echo($LIVE_PICTURE[$lang_idx]);?>" onclick="showLoading()"><div class="play"><img src="images/splay.png" width="30" height="30" alt="play" /></div><img src="phpThumb.php?src=images/webCameraB.jpg&amp;w=400" width="300" height="225" alt="<? echo($LIVE_PICTURE[$lang_idx]);?>" /></a>
</div>
<div id="rainradar_box" class="inv_plain_3_zebra half_zebra" style="display:none">
    <h2><a id="radar" href="<?=$_SERVER['SCRIPT_NAME']?>?section=radar.php&amp;lang=<?=$lang_idx."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c'];?>" class="info">
				<? echo $RAIN_RADAR[$lang_idx];?><?=get_arrow()?><span class="info"><img src="img/loading.gif" alt="loading" width="32" height="32" /></span></a>
    </h2>
</div>
<div id="forum_box" class="inv_plain_3_zebra" style="display:none">
    <h2><a id="forum_title" href="<?=$_SERVER['SCRIPT_NAME']?>?section=chat.php&amp;lang=<?=$lang_idx."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c'];?>" class="info"> 
				<? echo $CHAT_TITLE[$lang_idx];?><?=get_arrow()?><span class="info"><img src="img/loading.gif" alt="loading" width="32" height="32" /></span></a>
    </h2>
</div>
<div id="contact_box" class="inv_plain_3_zebra  half_zebra" style="display:none">
    <h2><a id="contact" href="<?=$_SERVER['SCRIPT_NAME']?>?section=SendEmailForm.php&amp;lang=<?=$lang_idx."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c'];?>" class="info">
				<?=$CONTACT_ME[$lang_idx]?><?=get_arrow()?>
                                <span class="info"><img src="img/loading.gif" alt="loading" width="32" height="32" /></span>    
        </a>
    </h2>
</div>
<div style="clear:both">&nbsp;</div>
</div>
<!-- Parallax  midground clouds -->
<div id="parallax-bg2">
    <div id="cloudiness4bg2" style="display:none">
    <div id="bg2-4" class="cloud1"><div class="cloud1-more"></div></div>
    <div id="bg2-5" class="cloud-big"><div class="cloud-big-more"></div></div>
     <div id="bg2-6" class="cloud4"><div class="cloud4-more"></div></div>
    <div id="bg2-7" class="cloud2"><div class="cloud2-more"></div></div>
    </div>
    <div id="cloudiness6bg2" style="display:none">
    <div id="bg2-8" class="cloud-big"><div class="cloud-big-more"></div></div>
    </div>
    <div id="cloudiness8bg2" style="display:none">
    <div id="bg2-9" class="cloud-big"><div class="cloud-big-more"></div></div>
    <div id="bg2-10" class="cloud-big"><div class="cloud-big-more"></div></div>
    </div>
</div>
<!-- Parallax  background clouds -->
<div id="parallax-bg1">
    <div id="cloudiness4bg1" style="display:none">  
    <div id="bg1-3" class="cloud4"><div class="cloud4-more"></div></div>
    <div id="bg1-4" class="cloud-big"><div class="cloud-big-more"></div></div>
    <div id="bg1-5" class="cloud3"><div class="cloud3-more"></div></div>
    <div id="bg1-6" class="cloud2"><div class="cloud2-more"></div></div>
    </div>
    <div id="cloudiness6bg1" style="display:none">
    <div id="bg1-7" class="cloud-big"><div class="cloud-big-more"></div></div>
    <div id="bg1-8" class="cloud-big"><div class="cloud-big-more"></div></div>
    </div>
    <div id="cloudiness8bg1" style="display:none">
    <div id="bg1-9" class="cloud-big"><div class="cloud-big-more"></div></div>
    <div id="bg1-10" class="cloud-big"><div class="cloud-big-more"></div></div>
    </div>
    
</div>

 <?}// end  homepage?>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript">
    crayze_app_token = "578b9e65d6042";
</script>
<script async src="http://api.crayze.io/sdk/crayze.js">
</script>


<script type="text/javascript">
<!--
    /*!
loadCSS: load a CSS file asynchronously.
[c]2014 @scottjehl, Filament Group, Inc.
Licensed MIT
*/

/* exported loadCSS */
    function loadCSS( href, before, media, callback ){
	"use strict";
	// Arguments explained:
	// `href` is the URL for your CSS file.
	// `before` optionally defines the element we'll use as a reference for injecting our <link>
	// By default, `before` uses the first <script> element in the page.
	// However, since the order in which stylesheets are referenced matters, you might need a more specific location in your document.
	// If so, pass a different reference element to the `before` argument and it'll insert before that instead
	// note: `insertBefore` is used instead of `appendChild`, for safety re: http://www.paulirish.com/2011/surefire-dom-element-insertion/
	var ss = window.document.createElement( "link" );
	var ref = before || window.document.getElementsByTagName( "script" )[ 0 ];
	var sheets = window.document.styleSheets;
	ss.rel = "stylesheet";
	ss.href = href;
	// temporarily, set media to something non-matching to ensure it'll fetch without blocking render
	ss.media = "only x";
	// DEPRECATED
	if( callback ) {
		ss.onload = callback;
	}
	// inject link
	ref.parentNode.insertBefore( ss, ref );
	// This function sets the link's media back to `all` so that the stylesheet applies once it loads
	// It is designed to poll until document.styleSheets includes the new sheet.
	ss.onloadcssdefined = function( cb ){
		var defined;
		for( var i = 0; i < sheets.length; i++ ){
			if( sheets[ i ].href && sheets[ i ].href === ss.href ){
				defined = true;
			}
		}
		if( defined ){
			cb();
		} else {
			setTimeout(function() {
				ss.onloadcssdefined( cb );
			});
		}
	};
	ss.onloadcssdefined(function() {
		ss.media = media || "all";
	});
	return ss;
}
    function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }
	
    function redirect(url)
    {
        top.location.href = url;
    }
    
    function c_or_f(temp, tempunit) {
        if (tempunit == '°F') {
            return ( Math.round(((9 * temp) / 5) + 32));
        }
        return temp;
    }
    function loadData(json)
    {
        var cssstyle_str = "";
        if (json.jws.current.issunset == 1) { 
            cssstyle_str += "sunset"; 
            loadCSS("css/sunset.min.css", document.getElementById('loadGA'));
       }
       if (json.jws.current.issunrise == 1) { 
                cssstyle_str += "sunrise"; 
                loadCSS("css/sunset.min.css", document.getElementById('loadGA'));
        } 
       if ((json.jws.current.islight == 1)&&(json.jws.current.cloudiness > 6)) { 
                cssstyle_str += ",cloudy"; 
                loadCSS("css/cloudy.min.css", document.getElementById('loadGA'));
        }
       if (json.jws.current.pm10 > 250) { 
                cssstyle_str += ",dust"; 
                loadCSS("css/dust.min.css", document.getElementById('loadGA'));
        } 
       if (json.jws.current.islight == '') { 
            cssstyle_str += ",night";
            loadCSS("css/night<? echo $lang_idx;?>.min.css", document.getElementById('loadGA')); 
           if (json.jws.current.pm10 > 250) { 
               cssstyle_str += ",dust-night"; 
               loadCSS("css/dust-night.min.css", document.getElementById('loadGA'));
           }
       }
      if (json.jws.states.israining == 1){ 
            cssstyle_str += ",rain"; 
            loadCSS("css/rain.min.css", document.getElementById('loadGA'));
    }
      if (json.jws.states.issnowing == 1) { 
            if (json.jws.current.islight){ 
                cssstyle_str += ",snow"; 
                loadCSS("css/snow.min.css", document.getElementById('loadGA'));
           } else { 
                cssstyle_str += ",snow_night"; 
                loadCSS("css/snow_night.min.css", document.getElementById('loadGA'));
           } 
      }
      cssstyle_str += ",mobile";
        var tempunit = getParameterByName('tempunit');
        if (tempunit == '°F')
        {$("#postc").show();$("#postf").hide();$("#spanc").hide();$("#spanf").show();}
        else
        {$("#postf").show();$("#postc").hide();$("#spanf").hide();$("#spanc").show();tempunit = '°C';}  
        $('#date').html(json.jws.current.date<?=$lang_idx?>);
        $('#messages_box').children('.box_text').html(json.jws.Messages.detailedforecast<?=$lang_idx?>);
        $('#tempdivvalue').html(c_or_f(json.jws.current.temp, tempunit)+'<span class="paramunit">'+tempunit+'</span>');
        $('#tempdivvalue').css('visibility', 'visible');
        $('#windy').html(json.jws.windstatus.lang<? echo $lang_idx;?>);
        
       var cur_feel_link=document.getElementById('current_feeling_link');
       if (typeof coldmeter_size == 'undefined') 
                coldmeter_size = 14;
         if (cur_feel_link)
         {
                $.ajax({
                type: "GET",
                url: 'coldmeter_service.php?lang='+<?=$lang_idx?> + '&coldmetersize=' + coldmeter_size,
                beforeSend: function(){$(".loading").show();}
              }).done(function( jsonstr  ) {
						$.getScript( "footerScripts240716.php?lang=<?=$lang_idx?>&temp_unit=<?if (empty($_GET['tempunit'])) echo "&#176;c"; else echo $_GET['tempunit'];?>" , function( data, textStatus, jqxhr) {
							fillcoldmeter(jsonstr);
							$(".loading").hide();
						});
                        
              });
        }
        if (json.jws.feelslike.state == "windchill")
        {$("#itfeels_windchill").show();$("#itfeels_windchill .value").html(c_or_f(json.jws.feelslike.value, tempunit) + "&#176;")}
        else if (json.jws.feelslike.state == "heatindex")
        {$("#itfeels_heatidx").show();$("#itfeels_heatidx .value").html(c_or_f(json.jws.feelslike.value, tempunit) + "&#176;")}
        else if (json.jws.feelslike.state == "thsw")
        {$("#itfeels_thsw").show();$("#itfeels_thsw .value").html(c_or_f(json.jws.feelslike.value, tempunit) + "&#176;")}
        $('#what_is_h').html(json.jws.states.sigtitle<? echo $lang_idx;?>+'<br/>'+json.jws.states.sigext<? echo $lang_idx;?>);
        var title_secondary_temp;
        if (json.jws.current.primary_temp == 1)
           title_secondary_temp = '&nbsp;<?=$MOUNTAIN[$lang_idx];?>';
        else
           title_secondary_temp = '&nbsp;<?=$VALLEY[$lang_idx];?>';
        $("#latesttemp .paramvalue").html(c_or_f(json.jws.current.temp, tempunit)+'<span class="paramunit">'+tempunit+'</span>' + '&nbsp;<span id=\"valleytemp\" title=\"\">'+ c_or_f(json.jws.current.temp2, tempunit) + title_secondary_temp + '</span>');
        $("#latesttemp .highlows .high").html('<strong>' + c_or_f(json.jws.today.hightemp, tempunit) + '</strong>');
        $("#latesttemp .highlows .high_time").html(json.jws.today.hightemp_time);
        $("#latesttemp .highlows .low").html('<strong>' + c_or_f(json.jws.today.lowtemp, tempunit) + '</strong>');
        $("#latesttemp .highlows .low_time").html(json.jws.today.lowtemp_time);
        $("#latesttemp .trendstable .trendsvalues .innertrendvalue").eq(0).html(json.jws.yestsametime.tempchange.split(",")[2]);
        $("#latesttemp .trendstable .trendsvalues .innertrendvalue").eq(1).html(json.jws.oneHour.tempchange.split(",")[2]);
        $("#latesttemp .trendstable .trendsvalues .innertrendvalue").eq(2).html(json.jws.min30.tempchange.split(",")[2]);
        $("#latesttemp .paramtrend .innertrendvalue").html(json.jws.min15.minutes + " " + "<?=$MINTS[$lang_idx]?>: " + json.jws.min15.tempchange.split(",")[2]);
        $("#latesthumidity .paramvalue").html(json.jws.current.hum+'%');
        $("#latesthumidity .highlows .highparam").html('<strong>' + json.jws.today.highhum + '</strong>');
        $("#latesthumidity .highlows .high_time").html(json.jws.today.highhum_time);
        $("#latesthumidity .highlows .lowparam").html('<strong>' + json.jws.today.lowhum + '</strong>');
        $("#latesthumidity .highlows .low_time").html(json.jws.today.lowhum_time);
        $("#latesthumidity .trendstable .trendsvalues .innertrendvalue").eq(0).html(json.jws.yestsametime.humchange.split(",")[2]);
        $("#latesthumidity .trendstable .trendsvalues .innertrendvalue").eq(1).html(json.jws.oneHour.humchange.split(",")[2]);
        $("#latesthumidity .trendstable .trendsvalues .innertrendvalue").eq(2).html(json.jws.min30.humchange.split(",")[2]);
        $("#latesthumidity .paramtrend .innertrendvalue").html(json.jws.min15.minutes + " " + "<?=$MINTS[$lang_idx]?>: " + json.jws.min15.humchange.split(",")[2]+"%");
        $("#latestwind .paramvalue").html("<div id=\"winddir\" class=\"paramunit\"><div class=\"winddir\"></div></div><div id=\"windspeed\">" + json.jws.current.windspd + " <span class=\"paramunit\"><?=$WIND_UNIT[$lang_idx]?></span></div>");
        $("#latestwind .winddir").addClass(json.jws.current.winddir);
        $("#latestwind .highlows .highparam").html('<strong>' + json.jws.today.highwind + '</strong>');
        $("#latestwind .highlows .high_time").html(json.jws.today.highwind_time);
        $("#latestwind .paramtrend div").html("10 <?=$MINTS[$lang_idx]." ".$AVERAGE[$lang_idx]?> : <strong>" + json.jws.current.windspd10min + '</strong>' + ' <?=$WIND_UNIT[$lang_idx]?> ');
        $("#latestrain .highlows .highparam").html('<strong>'+ json.jws.today.highrainrate + '</strong>');
        $("#latestrain .highlows .high_time").html(json.jws.today.highrainrate_time);
        $("#latestrain .paramvalue").html(json.jws.current.rainrate+'<span class="paramunit">' + " <?=$RAINRATE_UNIT[$lang_idx]?>" +'</span>');
        $("#latestrain .paramtrend").html("<?=$DAILY_RAIN[$lang_idx]?>:&nbsp;" + json.jws.today.rain + " <?=$RAIN_UNIT[$lang_idx]?>" + "<br/>" + "<?=$TOTAL_RAIN[$lang_idx]?>:&nbsp;" + json.jws.seasonTillNow.rain + " <?=$RAIN_UNIT[$lang_idx]?>");
        for (i = 0; i< 4; i++){ 
        $('#shortforecast').children('.nav').children().eq(i).html(json.jws.forecastDays[i].day_name<?=$lang_idx?>+"  "+json.jws.forecastDays[i].date+"</br>"+"<img src=\"" + json.jws.forecastDays[i].icon + "\" onclick=\"showNextDays()\" width=\"32\" height=\"32\" alt=\"" + json.jws.forecastDays[i].icon +"\" /></br>"+c_or_f(json.jws.forecastDays[i].TempLow, tempunit)+" - "+c_or_f(json.jws.forecastDays[i].TempHigh, tempunit));
        }
        var forecastHours = "";
        for (i = 0; i< json.jws.sigforecastHours.length; i++){
       
           forecastHours += "<ul class=\"nav forecasttimebox\" >";
           forecastHours += "<li class=\"tsfh currentts\" style=\"display:none\"><span>" + json.jws.forecastHours[i].currentDateTime + "</span></li>";
           forecastHours += "<li class=\"tsfh forcast_date\"><span>" + json.jws.forecastHours[i].date + "</span></li>";
           forecastHours += "<li class=\"timefh forcast_time\"><span>" + json.jws.forecastHours[i].time + ":00" + (json.jws.forecastHours[i].plusminus > 0 ? "&nbsp;&plusmn;"+json.jws.forecastHours[i].plusminus : "") +"</span></li>";
           forecastHours += "<li class=\"forecasttemp\" id=\"tempfh"+ json.jws.forecastHours[i].time + "\"><span>" + json.jws.forecastHours[i].temp + "<img style=\"vertical-align: middle\" src=\"images/clothes/"+json.jws.forecastHours[i].cloth+"\" height=\"15\" width=\"20\" /></span></li>";
           forecastHours += "<li style=\"margin-top:0;\"><div title=\"" + json.jws.forecastHours[i].wind_title<? echo $lang_idx;?>+"\" class=\"wind_icon "+json.jws.forecastHours[i].wind_class+" \"></div></li>";
           forecastHours += "<li class=\"forcast_icon\"><span><img src=\"images/icons/day/"+json.jws.forecastHours[i].icon+"\" height=\"30\" width=\"30\" /></span></li>";
           forecastHours += "<li class=\"forcast_title\"><span>"+json.jws.forecastHours[i].title<? echo $lang_idx;?>+"</span></li>";
           forecastHours += "</ul>";
       }
       $('#for24_given').html('<? echo $GIVEN[$lang_idx]." ".$AT[$lang_idx]." ";?>' + json.jws.TAF.timetaf + ':00 ' + json.jws.TAF.dayF + '/' + json.jws.TAF.monthF + '/' + json.jws.TAF.yearF);
       $('#for24_hours').html(forecastHours);

       var forecastDays;
       var fulltextforecast;
       var textforecast;
       var textforecastwidth = "100px";
       var partialtext;
       var TempHighCloth, TempNightCloth;
       var lastindex = 28;
       var link_for_yest;
       var get_cloth = '<?=$_GET['c']?>';
       var get_sound = '<?=$_GET['s']?>';
       var morning_value = json.jws.yest.morningtemp;
       var noon_value = json.jws.yest.noontemp;
       var night_value = json.jws.yest.nighttemp;
       var date_value = json.jws.yest.date;
       var dayF_a =  json.jws.forecastDays[0].date.split("/")[0];
       var day_a =  json.jws.current.date0.split(" ")[4].split("/")[0];
       if (dayF_a != day_a)
       {
         morning_value = json.jws.today.morningtemp;
         noon_value = json.jws.today.noontemp;
         night_value = json.jws.current.temp;
         date_value = json.jws.today.date;
       }
       forecastDays = "<table style=\"border-spacing:4px;width:100%\">";
       forecastDays += "<tr style=\"height:2em\">";
       forecastDays += "<td></td>";
       forecastDays += "<td id=\"morning_icon\"></td>";
       forecastDays += "<td id=\"noon_icon\"></td>";
       forecastDays += "<td id=\"night_icon\"></td>";
       forecastDays += "<td></td>";
       forecastDays += "<td></td>";
       forecastDays += "</tr>";
       forecastDays += "<tr id=\"yesterday_line\" style=\"display:none\">";
       forecastDays += "<td class=\"tsfh\" style=\"text-align:center;\">" + date_value + "</td>";
       forecastDays += "<td class=\"tsfh\" style=\"text-align:center;direction:ltr\">" + c_or_f(morning_value) + "</td>";
       forecastDays += "<td class=\"tsfh\" style=\"text-align:center;direction:ltr\">" + c_or_f(noon_value) +"</td>";
       forecastDays += "<td class=\"tsfh\" style=\"text-align:center;direction:ltr\">" + c_or_f(night_value) + "</td>";
       forecastDays += "<td></td>";
       forecastDays += "<td></td>";
       forecastDays += "</tr>";
        for (i = 0; i< json.jws.forecastDays.length; i++){
            TempHighCloth = '&nbsp;<a href=\"javascript:void(0)\" class=\"info\" ><img style=\"vertical-align: middle\" src=\"'+json.jws.forecastDays[i].TempHighCloth+'\" width=\"20\" height=\"15\" title=\"'+json.jws.forecastDays[i].TempHighClothTitle<? echo $lang_idx;?>+'\" alt=\"\" /><span class=\"info\">'+json.jws.forecastDays[i].TempHighClothTitle<? echo $lang_idx;?>+'</span></a>';
            TempNightCloth = '&nbsp;<a href=\"javascript:void(0)\" class=\"info\" ><img style=\"vertical-align: middle\" src=\"'+json.jws.forecastDays[i].TempNightCloth+'\" width=\"20\" height=\"15\" title=\"'+json.jws.forecastDays[i].TempNightClothTitle<? echo $lang_idx;?>+'\" alt=\"\" /><span class=\"info\">'+json.jws.forecastDays[i].TempNightClothTitle<? echo $lang_idx;?>+'</span></a>';
            if ((get_cloth)&&(get_cloth == 0)){
                TempHighCloth = "";
                TempNightCloth = "";
            }
            forecastDays += "<tr style=\"height:4em\">";
            if (i==0)
              link_for_yest = "<a hrf=\"javascript:void(0)\" onclick=\"$('#yesterday_line').show();\"><img src=\"images/yesterday.png\" width=\"14\" height=\"14\" title=\"<?=$LAST_DAY[$lang_idx]?>\" /></a>&nbsp;&nbsp;";
            else
                link_for_yest = "";
            forecastDays += "<td class=\"tsfh\" style=\"text-align:center;line-height: 0.9em;\">" + link_for_yest + json.jws.forecastDays[i].day_name<?=$lang_idx?> + "<br />" + json.jws.forecastDays[i].date + "</td>";
            forecastDays += "<td class=\"tsfh\" style=\"text-align:center;direction:ltr\">" + c_or_f(json.jws.forecastDays[i].TempLow, tempunit) +"</td>";
            forecastDays += "<td class=\"tsfh\" style=\"text-align:center;direction:ltr\">" + c_or_f(json.jws.forecastDays[i].TempHigh, tempunit) + TempHighCloth + "</td>";
            forecastDays += "<td class=\"tsfh\" style=\"text-align:center;direction:ltr\">" + c_or_f(json.jws.forecastDays[i].TempNight, tempunit) + TempNightCloth + "</td>";
            forecastDays += "<td style=\"width:32px\"><img src=\"" + json.jws.forecastDays[i].icon + "\" width=\"32\" height=\"32\" alt=\"" + json.jws.forecastDays[i].icon +"\" />"+"</td>";
            fulltextforecast = json.jws.forecastDays[i].lang<? echo $lang_idx;?>;
            partialtext = fulltextforecast.substring(0,lastindex);
            if (fulltextforecast.length > lastindex)
                textforecast = "<a href=\"javascript:void(0)\" class=\"info\" >" + fulltextforecast.substring(0, partialtext.lastIndexOf(" ")) + "..." + "<span class=\"info\">"+fulltextforecast+"</span></a>" + "</td>";
            else
                textforecast = fulltextforecast;
            var get_fullt = '<?=$_GET['fullt']?>';
            if ((get_fullt)&&(get_fullt > 0)){
                textforecast = fulltextforecast;
                textforecastwidth = "130px";
            }
            forecastDays += "<td class=\"text\" style=\"width:" + textforecastwidth + ";padding:0 0.2em 0 0.2em\">" + textforecast +"</td>";
            forecastDays += "</tr>";
       }
       forecastDays += "<tr><td style=\"text-align:center\"><?=$AVERAGE[$lang_idx]?></td><td class=\"tsfh\" style=\"text-align:center\">" + json.jws.thisMonth.lowtemp_av + "</td><td class=\"tsfh\" style=\"text-align:center\">" + json.jws.thisMonth.hightemp_av + "</td><td></td><td></td><td></td></tr>";
       forecastDays += "</table>";
       $('#forecastnextdays_table').html(forecastDays);

       if (json.jws.current.cloudiness > 2){
           $('#cloudiness4bg2').show();
           $('#cloudiness4bg1').show();
       }
       if (json.jws.current.cloudiness > 5){
           $('#cloudiness6bg2').show();
           $('#cloudiness6bg1').show(); 
      }
       if (json.jws.current.cloudiness > 6){
           $('#cloudiness8bg2').show();
           $('#cloudiness8bg2').show();
       }
                       $(".info_btns").show();
                       $(".seker_btns").show();
                       $("#shortforecast").show();
       $('#nextdays').show();
       $('#messages_box').show();
       $('#livepic_box').show();
       $('#rainradar_box').show();
       $('#forum_box').show();
       $('#contact_box').show();
       $('#canvas').show();
       if (('#adunit2').length)
           $('#adunit2').show();
       if (('#adunit3').length)
           $('#adunit3').show();
       
       if ((json.jws.states.issnowing != 1) && (json.jws.states.israining == 1))    
       {/*$.getScript( "js/rain.js" );*/
           if (get_sound == 1){
               playSound();
           }
       }
       else if (json.jws.states.issnowing == 1)    
          {$.getScript( "js/snow.js" );};
    }
    function playSound()
    {
        var audio = {};
        audio["rain"] = new Audio();
        audio["rain"].src = "sound/rain/RAINFIBL.mp3";
        audio["rain"].addEventListener('canplaythrough', function() {
            audio["rain"].play();
        });
    }
    function fillAllJson(jsonstr)
    {
      try{var json = JSON.parse(jsonstr);} catch (e) {alert('parsing json: ' + e);}
      try{loadData(json);} catch (e) {alert('extracting json to page: ' + e);}
   }
   function showNextDays()
   {
       $('#forecastnextdays').show();$('#forecast24h').hide();$('#fornextdays_title').addClass('for_active');$('#for24h_title').removeClass('for_active');
   }
   function showLoading()
   {
       $(".loading").show();
   }
   <? if (mainPage()||($_REQUEST['section'] == "alerts.php")) {?>
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
          alert ('error:' + e);
      }
    });
   <?}else{?> $(".loading").hide(); <?}?>
//-->
</script>
<? if (!isFastPage()) { ?>
<script src="js/tinymce/tinymce.min.110216.js" type="text/javascript"></script>
<script type="text/javascript">
startup(<?=$lang_idx?>, <?=$limitLines?>, "<?=(isset($_GET['update'])?$_GET['update']:'')?>");
</script>
<?}?>
</body>
</html>
<? if ($_GET['debug'] == '') include "end_caching.php"; ?>