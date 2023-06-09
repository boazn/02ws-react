<?
header('Content-type: text/html; charset=utf-8');
header("Access-Control-Allow-Origin: null");
ini_set("display_errors","Off");
ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE);
if ($_GET['debug'] == '')
include "begin_caching.php";
define("BASE_URL","http://www.02ws.co.il");
$HOME_PAGE = array("To home page","לעמוד הראשי");
$HOTORCOLD_T = array("Cold meter", "מדד הקור");
$FSEASON_T = array("Best season", "העונה הטובה");
$IT_FEELS = array("feels like", "מרגיש כמו");
$IN_THE_SUN = array("sun", "שמש");
$MINTS = array("min", "דק'");
$DAILY_RAIN = array("Daily rain", "גשם היום מחצות");
$TOTAL_RAIN = array("Total", "סה'כ");
$RAIN_RATE = array("Rain rate" , "עוצמת גשם");
$TEMP = array("Temperature" , "טמפרטורה");
$WIND = array("wind" , "רוח");
$HUMIDITY = array("humidity" , "לחות");
$RADIATION = array("radiation" , "קרינה", "излучение ");
$DUST = array("dust", "אבק", "пыль");
$DUST_THRESHOLD = array("PM10 - above 130 not healthy. Above 300 sport activity is not recommended<br/>PM2.5 - above 38 not healthy. Above 100 sport activity is not recommended<br/>PM2.5 is more dangerous", "PM10 - מעל 130 לא בריא. מעל 300 לא מומלץ לעשות פעילות גופנית<br/>PM2.5 - מעל 38 לא בריא. מעל 100 לא מומלץ לעשות פעילות גופנית<br/>PM2.5 מסוכן יותר", " PM10 - выше 130 вредно для здоровья. Выше 300 не рекомендуется заниматься спортом<br/>PM2.5 - выше 38 вредно для здоровьям. Выше 100 не рекомендуется заниматься спортом<br/>PM2.5 более опасный");
$HOURS = array("hrs", "שעות");
$FORECAST_4D = array("Next Days", "הימים הבאים");
$GIVEN = array("given", "ניתנה");
$AT = array("at ", "ב-");
$MESSAGES = array("Messages and alerts", "הודעות והתראות");
$REMOVE_ADS = array("Want to remove ads? click here!", "רוצה להסיר פרסומות? כאן!");
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
$ROAD = array("at road", "בכביש");
$AVERAGE = array("average", "ממוצע");
$MOBILE_FRIENDLY = array("Mobile friendly" , "מותאם לנייד");
$CONTACT_ME = array("Contact", "צרו קשר");
$EXPAND = array("In table", "בטבלה");
$PIC_OF_THE_DAY = array("Pic of the day", "תמונת היום", "");
$USERS_PICS = array("Users Pics", "תמונות הגולשים", "");
$NOW = array("now", "עכשיו", "");
$SHADE = array("shade", "צל", "");

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
function isFastPage(){
    return (($_REQUEST['section'] == "alerts.php")||($_REQUEST['section'] == ""));
}
function isAlertsPage(){
    return ($_REQUEST['section'] == "alerts.php");
}
function isGraphsPage(){
    return (($_REQUEST['section'] == "graph.php"));
}
function isContactPage(){
    return (($_REQUEST['section'] == "SendEmailForm.php"));
}
function isRadarPage(){
    return (($_REQUEST['section'] == "radar.php"));
}
$lang_idx = $_REQUEST['lang'];
$adFree = $_REQUEST['ad'];
if ($lang_idx == "")
    $lang_idx = 1;


$width = "320";
if (isRadarPage())
{
  $width = "570";  
}

?>
<!DOCTYPE html>
<html  <? if (isHeb()) echo "lang=\"he\" xml:lang=\"he\"" ; ?> xmlns="http://www.w3.org/1999/xhtml">
<head>

<link rel="stylesheet" href="css/main.php?lang=<?=$lang_idx;?>&type=" type="text/css">
<link rel="stylesheet" href="css/mobile.php<?echo "?lang=".$lang_idx."&amp;width=".$width."&amp;fullt=".$_REQUEST['fullt']."&amp;c=".$_REQUEST['c'];?>" type="text/css" />

<link rel="icon" type="image/png" href="img/favicon_sun.png" />
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
</head>
<body >
<!-- SNOW EFFECT-->
<canvas id="canvas" style="display:none"></canvas>
<div style="" id="main_cellphone_container">
<div class="loading"><img src="img/loading.gif" alt="loading" width="32" height="32" /></div>
<? if (empty($_GET['email'])) {?>
<div id="adunit1" class="adunit" style="display:none">
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
<?}?>
<? if (mainPage()) {?>
<div id="nextdays" style="display:none">
    <div id="for_title" class="float">
        <div id="now_title" class="forcast_title_btns for_active">
        <a href="javascript:void(0)" onclick="navMain('currentinfo_container', $(this).parent().attr('id'))">
                <? echo($NOW[$lang_idx]);?>
        </a>
        </div>
        <div id="for24h_title" class="forcast_title_btns">
        <a href="javascript:void(0)" onclick="navMain('forcast_hours', $(this).parent().attr('id'))">
                <? echo(" 24 ".$HOURS[$lang_idx]);?>
        </a>
        </div>
        <div id="expand" class="forcast_title_btns">
        <a href="javascript:void(0)" onclick="navMain('for24_hours_D', $(this).parent().attr('id'))">
            <?=$EXPAND[$lang_idx]?>
        </a>
        </div>
        <div id="fornextdays_title" class="forcast_title_btns">
        <a href="javascript:void(0)" id="" onclick="navMain('forecastnextdays', $(this).parent().attr('id'))">
                <? echo($FORECAST_4D[$lang_idx]); ?>
        </a>
        </div>
   </div>
</div>
<?}?>
<div id="logo" <?if (!mainPage()) echo " class=\"logo_secondary\"";?> style="display:none">
<a href="station.php?section=frommobile&amp;lang=<? echo $lang_idx;?>" id="logotitle" title="<? echo $HOME_PAGE[$lang_idx];?>" onclick="showLoading()">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
<div id="date"></div>
</div>
<? if (isAlertsPage()) { ?>

<div id="tohome" class="invfloat inv_plain_3">
<a href="<? echo BASE_URL.substr(strrchr($_SERVER["PHP_SELF"], "/"), 0)."?lang=".$lang_idx."&amp;tempunit=".$_GET['tempunit']."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c'];?>"  title="<? echo $HOME_PAGE[$lang_idx];?>" class="hlink">
<? echo $HOME_PAGE[$lang_idx];?>
</a>
</div>
<?}?>
<? if (!isFastPage()&&!isGraphsPage()&&!isContactPage()&&!isRadarPage()) {?>
<ul class="nav" id="user_info">
    <li><div id="user_icon"></div><p id="user_name"></p><span class="arrow_down">▼</span>
                <ul style="<?echo get_s_align();?>: -2em;">
                      <li>
                              <div id="notloggedin" style="display:none">
                                      <div class="clear"><a href="javascript: void(0)" class="button" id="login" title="<?=$LOGIN[$lang_idx]?>" ><?=$LOGIN[$lang_idx]?></a></div>
                                      <div class="clear"><a href="javascript: void(0)" class="button register" id="register" title="<?=$REGISTER[$lang_idx]?>"><?=$REGISTER[$lang_idx]?></a></div>

                              </div>
                              <div id="loggedin" style="display:none">
                                      <input id="updateprofile" class="button" title="<?=$UPDATE_PROFILE[$lang_idx]?>" value="<?=$UPDATE_PROFILE[$lang_idx]?>" /><br />
                                      <input id="myvotes" class="button" title="<?=$MY_VOTES[$lang_idx]?>" value="<?=$MY_VOTES[$lang_idx]?>" onclick="redirect('<? echo substr(get_query_edited_url($url_cur, 'section', 'myVotes.php'), 1);?>')" /><br />
                                      <input value="<?=$SIGN_OUT[$lang_idx]?>" onclick="signout_from_server(<?=$lang_idx?>, <?=$limitLines?>, '<?=$_GET['update']?>')" id="signout" class="button"/>
                              </div>
                      </li>
                </ul>
        </li>

</ul>
<?} if (!mainPage()) {
    ?>
<article id="section" >
   <? include($_GET['section']);?>
</article>
<? }
else {?>
<div id="currentinfo_container" style="display:none">
<ul class="info_btns" style="display:none">
    <li id="now_btn" onclick="change_circle('now_line', 'latestnow')"></li>
   <li id="temp_btn" onclick="change_circle('temp_line', 'latesttemp')" title=""></li>
   <li id="temp2_btn" onclick="change_circle('temp_line', 'latesttemp2')" title=""></li>
   <li id="moist_btn" onclick="change_circle('moist_line', 'latesthumidity')" title=""></li>
   <li id="rain_btn" onclick="change_circle('rain_line', 'latestrain')" title=""></li>
   <li id="wind_btn" onclick="change_circle('wind_line', 'latestwind')" title=""></li>
   <li id="aq_btn" onclick="change_circle('aq_line', 'latestairq')" title=""></li>
   <li id="rad_btn" onclick="change_circle('rad_line', 'latestradiation')" title=""></li>
   <li id="temp3_btn" onclick="change_circle('temp_line', 'latesttemp3')" title=""></li>
   
</ul>
<ul class="seker_btns" style="display:none">
<li id="season_btn">
 <a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=survey.php&amp;survey_id=1&amp;lang=<? echo $lang_idx."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c'];?>" onclick="showLoading()">
    <?=$FSEASON_T[$lang_idx]?>
    </a>
                        </li>
<li id="cold_btn">
    <a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=survey.php&amp;survey_id=2&amp;lang=<? echo $lang_idx."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c'];?>" onclick="showLoading()">
    <?=$HOTORCOLD_T[$lang_idx]?>
    </a>
</li>

</ul>
<div id="latestnow" class="inparamdiv">
 <div  id="windy">

 </div>
<div class="" id="itfeels" style="display:none;">
<? echo $IT_FEELS[$lang_idx]; ?>
 <span class="" id="itfeels_thsw" style="display:none;">
    <a title="<?=$THSW[$lang_idx]?>"  href="<?=$_SERVER['SCRIPT_NAME']?>?section=graph.php&amp;graph=THSWHistory.gif&amp;profile=1&amp;lang=<?=$lang_idx."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c']?>"> 
           <span dir="ltr" class="high value" title="<?=$THSW[$lang_idx]?>"><? echo $itfeels[1];  ?></span> <span class="sunshade" style="display:none;"><? echo $IN_THE_SUN[$lang_idx]; ?></span>
    </a>| 
</span>
<span id="itfeels_windchill" style="display:none;"> 
<a title="" href="<?=$_SERVER['SCRIPT_NAME']?>?section=graph.php&amp;graph=tempwchill.php&amp;profile=1&amp;lang=<?=$lang_idx."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c']?>" onclick="showLoading()"> 
        <span dir="ltr" class="low value" title="<?=$WIND_CHILL[$lang_idx]?>">&#176;</span> <span class="sunshade" style="display:none;"><? echo $SHADE[$lang_idx]; ?></span>
 </a> 
</span>
<span class="" id="itfeels_heatidx" style="display:none;">
<a title="" href="<?=$_SERVER['SCRIPT_NAME']?>?section=graph.php&amp;graph=tempheat.php&amp;profile=1&amp;lang=<?=$lang_idx."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c']?>" onclick="showLoading()"> 
        <span dir="ltr" class="high value" title="<?=$HEAT_IDX[$lang_idx]?>">&#176;</span> <span class="sunshade" style="display:none;"><? echo $SHADE[$lang_idx]; ?></span>
 </a> 
</span>
</div>
<div id="tempdivvalue" style="visibility:hidden">

</div>
<div id="statusline" style="visibility:hidden">
    <div  id="coldmeter">
    <a href="/small.php?section=survey.php&amp;survey_id=2&amp;lang=<?=$lang_idx?>"> 
    <span id="current_feeling_link" title="<?=$HOTORCOLD_T[$lang_idx]?>">&nbsp;</span>
     </a>
    </div>
</div>
<div id="what_is_h" style="visibility:hidden"></div>
</div>
<div id="latesttemp" class="inparamdiv" style="display:none;">
        <div class="paramtitle slogan">
             <a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=tempLatestArchive.php&amp;profile=1&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c']?>" title="" onclick="showLoading()"><? echo $TEMP[$lang_idx];?></a>
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
                 <a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=tempLatestArchive.php&amp;profile=1&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c']?>" title="" onclick="showLoading()"><img src="img/graph_icon.png" width="35" height="18" alt="to graphs"/></a>
    </div>
 </div>
<div id="latesttemp2" class="inparamdiv" style="display:none;">
    <div class="paramtitle slogan">
             <a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=temp<?if ($PRIMARY_TEMP == 1) echo "LatestArchive";?>.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>&amp;style=<?=$_GET["style"]?>" title=""><? echo $TEMP[$lang_idx];?></a>
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
                 <a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=temp<?if ($PRIMARY_TEMP == 1) echo "LatestArchive";?>.php&amp;profile=1&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c']?>" title="" onclick="showLoading()"><img src="img/graph_icon.png" width="35" height="18" alt="to graphs"/></a>
    </div>
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
                <a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=humwind.php&amp;level=1&amp;freq=2&amp;datasource=downld02&amp;profile=1&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>" title="" onclick="showLoading()"><img src="img/graph_icon.png" width="35" height="18" alt="to graphs"/></a>
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
                    <a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=wind.php&amp;profile=1&amp;lang=<? echo $lang_idx;?>" ><img src="img/graph_icon.png" alt="to graphs"/></a>
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
            <a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=RainRateHistory.gif&amp;profile=1&amp;lang=<? echo $lang_idx;?>" title="" onclick="showLoading()"><img src="img/graph_icon.png" width="35" height="18" alt="to graphs"/></a>
    </div>
</div>  
<div id="latestradiation" class="inparamdiv" <? if (isHeb()) echo "dir=\"rtl\" ";?> style="display:none">
<div class="paramtitle slogan">
        <? echo $RADIATION[$lang_idx];?>
   </div>
   <div id="sunvalues" class="paramvalue">
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
            <td  class="box" title=""><img src="img/24_icon.png" width="21" alt="24 hours" /></td>
            <td  class="box" title=""><img src="img/half_icon.png" width="21" alt="half hour"/></td>
            <td class="box" title=""><img src="img/quarter_icon.png" width="21" alt="quarter hour"/></td>
       </tr>
      </table>
    </div>
    <div class="graphslink">
      <a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=rad.php&amp;profile=1&amp;lang=<? echo $lang_idx;?>" ><img src="img/graph_icon.png" alt="to graphs"/></a>
    </div>
</div>
<div id="latestuv" class="inparamdiv" <? if (isHeb()) echo "dir=\"rtl\" ";?> style="display:none">
</div>
<div id="latestairq" class="inparamdiv" <? if (isHeb()) echo "dir=\"rtl\" ";?> style="display:none">
	<div class="paramtitle slogan">
		<?=$DUST[$lang_idx]?>
	</div>
	<div class="paramvalue">
		 
	</div>
	<div class="highlows">
		<?=$DUST_THRESHOLD[$lang_idx]?>
	</div>
    
	<div class="paramtrend relative"></div>
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
		<a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=dust.html&amp;lang=<? echo $lang_idx;?>" title="to graph"><img src="img/graph_icon.png" alt="to graphs"/></a>
	</div>
</div>
<div id="latestdewpoint" class="inparamdiv" <? if (isHeb()) echo "dir=\"rtl\" ";?> style="display:none">
</div>
<div id="latesttemp3" class="inparamdiv" <? if (isHeb()) echo "dir=\"rtl\" ";?> style="display:none">
    <div class="paramtitle slogan">
             <a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=temp3<?if ($PRIMARY_TEMP == 1) echo "LatestArchive";?>.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>&amp;style=<?=$_GET["style"]?>" title=""><? echo $TEMP[$lang_idx];?></a>
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
            <span id="temp3_desc"></span>
                 <a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=temp3<?if ($PRIMARY_TEMP == 1) echo "LatestArchive";?>.php&amp;profile=1&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c']?>" title="" onclick="showLoading()"><img src="img/graph_icon.png" width="35" height="18" alt="to graphs"/></a>
    </div>
</div>
<div class="inparamdiv" id="coldmetersurvey" style="display:none">
    
</div>
    
<div style="clear:both;height:35px">&nbsp;</div>
<a href="#forecastnextdays">
<div id="shortforecast" style="display:none">
    <ul class="nav"><li class="tsfh" style="border:none"></li><li class="tsfh"></li><li class="tsfh"></li><li class="tsfh"></li></ul>
 </div>
</a>
</div>
<div style="clear:both;height:10px">&nbsp;</div>


<div style="display:none;padding:0.1em 0.2em" id="forecastnextdays">
        <table id="forecastnextdays_table" <? if (isHeb()) echo "dir=\"rtl\""; ?> style="border-spacing:1px 8px;padding:3px;width:100%">
        
	</table> 
    
</div>
<div id="forcast_hours" style="display:none">
        
	<div id="for24_given">
							
	</div>
	<div id="for24_details" style="display:none">
		<span id="tempForecastDiv" style="display:none">
		</span>
	</div>
        <div id="graph_forcastWrapper" >
        <div id="graph_forcast" >
            <canvas id="graphForcastContainer"></canvas>
            <div id="chartjs-tooltip" class="inv_plain_3_zebra"></div>
        </div>
        </div>
        <div id="for24_hours"></div>
 
</div>
<div id="for24_hours_D" style="display:none"></div>
<div id="adunit2" class="adunit" style="display:none">
    <div class="removeadlink">
            <a href="https://www.patreon.com/bePatron?c=1347814&rid=2162701" target="_blank"><?=$REMOVE_ADS[$lang_idx];?></a>
    </div> 
    <!-- 
    <div id="if1">
        <a href="https://goo.gl/5WrA5J" target="_blank">
            <img width="320" height="100" src="images/if_320x100.png" />
        </a>
    </div>
    <div id="if2">
        <a href="https://goo.gl/5WrA5J" target="_blank">
            <img width="320" height="100" src="images/if_320x100.png" />
        </a>
    </div>
    -->	
<!-- Large Mobile Banner 2 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:320px;height:100px"
     data-ad-client="ca-pub-2706630587106567"
     data-ad-slot="4198340247"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>
<div id="messages_box" class="white_box" style="display:none">
    <h2><? echo $MESSAGES[$lang_idx];?></h2>
    <div id="livepic_box" class="invfloat" style="display:none">
    <div class="avatar live_avatar"></div>
    
    <a href="<?=$_SERVER['SCRIPT_NAME']?>?section=smallwebcam.php&amp;lang=<?=$lang_idx."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c'];?>" title="<? echo($LIVE_PICTURE[$lang_idx]);?>" onclick="showLoading()"><div class="play"><img src="images/splay.png" width="20" height="20" alt="play" /></div><img src="phpThumb.php?src=images/webCamera.jpg&sx=850&sy=180&sw=500&sh=500&fltr%5B%5D=gam%7C0.8" width="150" height="125" alt="<? echo($LIVE_PICTURE[$lang_idx]);?>" /></a>
    </div>
    <p class="box_text">
     
    </p>
    <p id="personal_message" >
     
    </p>
	
    <p id="latest_picoftheday" >
     
    </p>
    <p id="latest_user_pic" >
     
    </p>
    <!-- Ad small unit 3-->
</div>
<div id="adunit3" class="adunit" style="display:none">
  	<!-- Large Mobile Banner 1 -->
	<ins class="adsbygoogle"
		 style="display:inline-block;width:320px;height:100px"
		 data-ad-client="ca-pub-2706630587106567"
		 data-ad-slot="3647675909"></ins>
	<script>
	(adsbygoogle = window.adsbygoogle || []).push({});
	</script>
</div>

 <?}// end  homepage?>

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
<div id="startupdiv" style="display:none;top: 72px; left: 8px;z-index:999999; position: absolute;background-color:#fff" class role="dialog">
<button type="button" id="cboxClose" style="background-image: url(../img/close.png);
    border: none;
    height: 32px;
    width: 32px;
    left: 5px;position: absolute;top: 5px;" onclick="$( this ).parent().hide();">close</button><br />
 <div class="removeadlink">
            <a href="https://www.patreon.com/bePatron?c=1347814&rid=2162701" target="_blank"><?=$REMOVE_ADS[$lang_idx];?></a>
    </div>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- startup mobile -->
<ins class="adsbygoogle"
     style="display:inline-block;width:300px;height:250px"
     data-ad-client="ca-pub-2706630587106567"
     data-ad-slot="5793963685"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
 <div class="removeadlink">
            <a href="https://www.patreon.com/bePatron?c=1347814&rid=2162701" target="_blank"><?=$REMOVE_ADS[$lang_idx];?></a>
    </div>
</div>
<? if (!isFastPage()){ ?>
<input type="hidden" id="chosen_user_icon" value=""/>
<div style="display:none">
<div id="profileform" style="padding:0.5em" >
                            <div class="float">

                            <table>
                            <tr><td><?=$EMAIL[$lang_idx]?>:</td><td><input type="text" name="email" value="" readonly="readonly" id="profileform_email" size="30"/></td></tr>
                            <tr><td><?=$PASSWORD[$lang_idx]?>:</td><td><input type="password" name="password" value="" id="profileform_password"/></td></tr>
                            <tr><td><?=$USER_ICON[$lang_idx]?>:</td><td><div><div class="user_icon_frame">
                        <div id="user_icon_contentbox" class="contentbox-wrapper"> <? $user_icons = array(); $user_icons = array_reverse(getfilesFromdir("img/user_icon")); foreach ($user_icons as $user_icon)
                                    { ?>
                            <div class="contentbox">
                                    <div class='<? $user_icon_name =explode(".", end(explode("/",$user_icon[1]))); echo $user_icon_name[0];?>'>&nbsp;</div>

                            </div>
                                <? }?></div>
                         </div>
                         <div class="icon_left" onclick="change_icon('left', this); return false"></div>
                        <div class="icon_right" onclick="change_icon('right', this); return false"></div>
                                    </div>
                        </td></tr>
                            <tr><td><?=$DISPLAY_NAME[$lang_idx]?>:</td><td><input type="text" name="user_display_name" value="" id="profileform_displayname"/></td></tr>
                            <tr><td><?=$NICE_NAME[$lang_idx]?>:</td><td><input type="text" name="user_nice_name" value="" id="profileform_nicename"/></td></tr>
                            </table>
                            <input type="checkbox" name="priority" value="" id="profileform_priority" /><?=$GET_UPDATES[$lang_idx]?><br />
                            <input type="checkbox" name="personal_coldmeter" value="" id="profileform_personal_coldmeter" /><?=$PERSONAL_COLD_METER[$lang_idx]?><br />
                            </div>

                            <div style="display:none" class="float loading"><img src="img/loading.gif" alt="loading" width="32" height="32" /></div>
                            <div id="profileform_result" class="float"></div>
                            <input type="submit" value="<?=$UPDATE_PROFILE[$lang_idx]?>" onclick="updateprofile_to_server(<?=$lang_idx?>)" id="profileform_submit" class="invfloat clear inv_plain_3"/>
                            <input type="submit" value="<?=$DONE[$lang_idx]?>" onclick="$('#cboxClose').click();window.location.reload()" id="profileform_OK" class="info invfloat inv_plain_3" style="display:none"/>


   </div>
</div>

 <div style="display:none">
      
<div id="loginform" style="padding:1em">
	<div class="float">
        <input type="text" name="email" value="" placeholder="<?=$EMAIL[$lang_idx]?>" id="loginform_email" size="30" tabindex="1" style="direction:ltr"/><br /><br />
        <input type="password" name="password" placeholder="<?=$PASSWORD[$lang_idx]?>" value="" id="loginform_password" tabindex="2" size="15"/><br /><br />
        </div>
        <div class="clear float big" style="padding:1em 0">
        <input type="checkbox" name="rememberme" value="" id="loginform_rememberme"/><?=$REMEMBER_ME[$lang_idx]?>
        </div>  
	<div style="display:none" class="float loading"><img src="images/loading.gif" alt="loading" width="32" height="32"/></div>
        <div id="loginform_result" class="float"></div>
	<input type="submit" value="<?=$LOGIN[$lang_idx]?>" class="invfloat clear inv_plain_3 big" onclick="login_to_server(<?=$lang_idx?>)" id="loginform_submit"/>
        <input type="submit" value="Success!" onclick="$('#cboxClose').click();window.location.reload();" id="loginform_OK" class="info invfloat" style="display:none"/>
        <div class="clear float big" style="margin-top:0.8em"><a href="javascript: void(0)" id="forgotpass" title="<?=$FORGOT_PASS[$lang_idx]?>"><?=$FORGOT_PASS[$lang_idx]?></a></div>
 	
</div>
<div id="registerform" style="padding:0.5em">
<div id="registerinput" class="float">
<table>
<tr><td></td><td><input type="text" placeholder="<?=$EMAIL[$lang_idx]?>" name="email" value="" id="registerform_email" size="30" tabindex="3" style="direction:ltr"/></td></tr>
<tr><td></td><td><input type="password" placeholder="<?=$PASSWORD[$lang_idx]?>" name="password" value="" id="registerform_password" tabindex="4"/></td></tr>
<tr><td></td><td><input type="password" placeholder="<?=$PASSWORD_VERIFICATION[$lang_idx]?>" name="password_verif" value="" id="registerform_password_verif" tabindex="5"/></td></tr>
<tr><td></td><td><input type="text" name="username" placeholder="<?=$USER_ID[$lang_idx]?>" value="" id="registerform_userid" tabindex="6"/><a href="javascript:void(0)" class="info">(?)<span class="info" style="top:-50px;<?=get_s_align()?>:-100px"><?=$USER_ID_EXP[$lang_idx]?></span></a></td></tr>
<tr><td></td><td><?=$USER_ICON[$lang_idx]?>:<div style="display:inline-block"><div class="user_icon_frame">
<div id="user_icon_contentbox" class="contentbox-wrapper"> <? $user_icons = array(); $user_icons = array_reverse(getfilesFromdir("img/user_icon")); foreach ($user_icons as $user_icon)
            { ?>
    <div class="contentbox">
            <div class='<? $user_icon_name =explode(".", end(explode("/",$user_icon[1]))); echo $user_icon_name[0];?>'>&nbsp;</div>

    </div>
        <? }?></div>
 </div>
 <div class="icon_left" onclick="change_icon('left', this); return false"></div>
<div class="icon_right" onclick="change_icon('right', this); return false"></div>
            </div>
</td></tr>
<tr><td></td><td><input type="text" placeholder="<?=$DISPLAY_NAME[$lang_idx]?>" name="user_display_name" value="" id="registerform_displayname" tabindex="7"/><a href="javascript:void(0)" class="info">(?)<span class="info" style="top:-50px;<?=get_s_align()?>:-100px"><?=$DISPLAY_NAME_EXP[$lang_idx]?></span></a></td></tr>
<tr><td></td><td><input type="text" placeholder="<?=$NICE_NAME[$lang_idx]?>" name="user_nice_name" value="" id="registerform_nicename" tabindex="8"/><a href="javascript:void(0)" class="info">(?)<span class="info" style="top:-50px;<?=get_s_align()?>:-100px"><?=$NICENAME_EXP[$lang_idx]?></span></a></td></tr>
</table>
<input type="checkbox" name="priority" value="" id="registerform_priority"/><?=$GET_UPDATES[$lang_idx]?><br />
<input type="checkbox" name="personal_coldmeter" value="" id="registerform_personal_coldmeter" disabled/><?=$PERSONAL_COLD_METER[$lang_idx]?><a href="javascript:void(0)" class="info">(?)<span class="info" style="top:-50px;<?=get_s_align()?>:-100px"><?=$PERSONAL_COLD_METER_EXP[$lang_idx]?></span></a>
</div>
<div style="display:none" class="float loading"><img src="img/loading.gif" alt="loading" width="32" height="32" /></div>
<div id="registerform_result" class="float">
</div>
<input type="submit" value="<?=$REGISTER[$lang_idx]?>" class="invfloat clear inv_plain_3" onclick="register_to_server(<?=$lang_idx?>)" id="registerform_submit"/>
<input type="submit" value="Success!" onclick="$('#cboxClose').click();" id="registerform_OK" class="info invfloat" style="display:none"/>

</div>

<div id="passforgotform" style="padding:1em">
    <?=$EMAIL[$lang_idx]?>:<input type="text" name="email" value="" id="passforgotform_email" size="30" style="direction:ltr"/><br /><br />
    <div id="passforgotform_result"></div>
    <input type="submit" value="<?=$FORGOT_PASS[$lang_idx]?>" onclick="passforgot_to_server(<?=$lang_idx?>)" id="passforgotform_submit" class="info invfloat"/>
    <input type="submit" value="<?=$CLOSE[$lang_idx]?>" onclick="$('#cboxClose').click();" id="passforgotform_OK" class="info invfloat" style="display:none"/>

 </div>
 </div>

<?}?>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript">
  var isUserAdApproved = false;
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
        if ((tempunit == '°F')||(tempunit == '°Fnull')) {
            return ( Math.round(((9 * temp) / 5) + 32));
        }
        return temp;
    }
	function loadPostData(jsonstr)
	{
            var C_STARTUP_AD_INTERVAL = 3;
		 $.getScript( "footerScripts160816.php?lang=<?=$lang_idx?>&temp_unit=<?if (empty($_GET['tempunit'])) echo "°c"; else echo $_GET['tempunit'];?>" , function( data, textStatus, jqxhr) {
							if (jsonstr  != undefined)
								fillcoldmeter(jsonstr);
							 $(".loading").hide();
                            <?if ($_GET['reg_id'] != "") {?>
                            $.ajax({
                                type: "GET",
                                url: "checkauth.php?action=getuser&reg_id=<?=$_GET['reg_id']?>&qs=<?=$_SERVER['QUERY_STRING']?>"
                              }).done(function( jsonstr ) {

                                   var jsonT = JSON.parse( jsonstr  );
                                   if (jsonT.user.approved == 1)
                                      isUserAdApproved = true;
                                    if (!isUserAdApproved)
                                    {   
                                        $(".adunit").show();
                                        if (sessions % C_STARTUP_AD_INTERVAL == 0)
                                        {
                                            $("#startupdiv").show();
                                        }
                                    }  
                                    else
                                    $('#adsense_start').remove();
                              });
                            <?}else{?>
                            if (!isUserAdApproved)
                            {
                               $(".adunit").show();
                                if (sessions % C_STARTUP_AD_INTERVAL == 0)
                                {
                                    $("#startupdiv").show();
                                }
                            }
                            else{
                              $('#adunit2').hide();  
                              $('#adsense_start').remove();
                            }
                            <?}?>
                            $('#nextdays').show();
                            if (sessions % 2 == 0)
                            {
                                $("#if1").show();
                                $("#if2").hide();
                            }
                            else 
                            {
                                $("#if1").hide();
                                $("#if2").show();
                            }
							
                    });
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
       if (json.jws.current.pm10 > 300) { 
                cssstyle_str += ",dust"; 
                loadCSS("css/dust.min.css", document.getElementById('loadGA'));
        } 
       if (json.jws.current.islight == '') { 
            cssstyle_str += ",night";
            loadCSS("css/night<? echo $lang_idx;?>.min.css", document.getElementById('loadGA')); 
           if (json.jws.current.pm10 > 300) { 
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
        if (tempunit == '°Fnull')
            tempunit = '°F';
        else if (tempunit == '°Cnull')
            tempunit = '°C';
        $('#date').html(json.jws.current.date<?=$lang_idx?>);
        $('#messages_box').children('.box_text').html(decodeURIComponent(json.jws.Messages.detailedforecast<?=$lang_idx?>).replace(/\+/g, ' '));
        $('#tempdivvalue').html('<div class="shade">' + ((json.jws.current.islight == 1) ? "<?=$SHADE[$lang_idx]?>" : "") + '</div>' + c_or_f(json.jws.current.temp, tempunit)+'<span class="paramunit">'+tempunit+'</span>');
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
                  
                    loadPostData(jsonstr);
              });
        }else
			loadPostData();
        
        if (json.jws.current.issun == 1)
        {
            $("#itfeels").show();$("#itfeels_thsw").show();$("#itfeels_thsw .value").html(c_or_f(json.jws.current.thsw, tempunit) + "");$(".sunshade").show();
        }
        else
            $("#itfeels").show();
        if (json.jws.feelslike.state == "windchill")
        {$("#itfeels_windchill").show();$("#itfeels_windchill .value").html(c_or_f(json.jws.feelslike.value, tempunit) + "")}
        else if (json.jws.feelslike.state == "heatindex")
        {$("#itfeels_heatidx").show();$("#itfeels_heatidx .value").html(c_or_f(json.jws.feelslike.value, tempunit) + "")}
        
        $('#what_is_h').html(json.jws.states.sigtitle<? echo $lang_idx;?>+'<br/>'+json.jws.states.sigexthtml<? echo $lang_idx;?>);
        var title_temp;
        var title_temp2;
        var title_temp3 = '<?=$ROAD[$lang_idx]?>';
        if (json.jws.current.primary_temp == 1){
           title_temp2 = '&nbsp;<?=$MOUNTAIN[$lang_idx];?>';
           title_temp = '&nbsp;<?=$VALLEY[$lang_idx];?>';
       }
        else{
           title_temp2 = '&nbsp;<?=$VALLEY[$lang_idx];?>';
           title_temp = '&nbsp;<?=$MOUNTAIN[$lang_idx];?>';
       }
        $("#latesttemp .paramvalue").html(c_or_f(json.jws.current.temp, tempunit)+'<span class="paramunit">'+tempunit+'</span>' + '&nbsp;<span id=\"valleytemp\" title=\"\">'+ title_temp + '</span>');
        $("#latesttemp .highlows .high").html('<strong>' + c_or_f(json.jws.today.hightemp, tempunit) + '</strong>');
        $("#latesttemp .highlows .high_time").html(json.jws.today.hightemp_time);
        $("#latesttemp .highlows .low").html('<strong>' + c_or_f(json.jws.today.lowtemp, tempunit) + '</strong>');
        $("#latesttemp .highlows .low_time").html(json.jws.today.lowtemp_time);
        $("#latesttemp .trendstable .trendsvalues .innertrendvalue").eq(0).html(json.jws.yestsametime.tempchange.split(",")[2]);
        $("#latesttemp .trendstable .trendsvalues .innertrendvalue").eq(1).html(json.jws.oneHour.tempchange.split(",")[2]);
        $("#latesttemp .trendstable .trendsvalues .innertrendvalue").eq(2).html(json.jws.min30.tempchange.split(",")[2]);
        $("#latesttemp .paramtrend .innertrendvalue").html(json.jws.min15.minutes + " " + "<?=$MINTS[$lang_idx]?>: " + json.jws.min15.tempchange.split(",")[2]);
        $("#latesttemp2 .paramvalue").html(c_or_f(json.jws.current.temp2, tempunit)+'<span class="paramunit">'+tempunit+'</span>' + '&nbsp;<span id=\"valleytemp\" title=\"\">'+ title_temp2 + '</span>');
        $("#latesttemp2 .highlows .high").html('<strong>' + c_or_f(json.jws.today.hightemp2, tempunit) + '</strong>');
        $("#latesttemp2 .highlows .high_time").html(json.jws.today.hightemp2_time);
        $("#latesttemp2 .highlows .low").html('<strong>' + c_or_f(json.jws.today.lowtemp2, tempunit) + '</strong>');
        $("#latesttemp2 .highlows .low_time").html(json.jws.today.lowtemp2_time);
        $("#latesttemp2 .trendstable .trendsvalues .innertrendvalue").eq(0).html(json.jws.yestsametime.temp2change.split(",")[2]);
        $("#latesttemp2 .trendstable .trendsvalues .innertrendvalue").eq(1).html(json.jws.oneHour.temp2change.split(",")[2]);
        $("#latesttemp2 .trendstable .trendsvalues .innertrendvalue").eq(2).html(json.jws.min30.temp2change.split(",")[2]);
        $("#latesttemp2 .paramtrend .innertrendvalue").html(json.jws.min15.minutes + " " + "<?=$MINTS[$lang_idx]?>: " + json.jws.min15.temp3change.split(",")[2]);
        $("#latestradiation .paramvalue").html(json.jws.current.solarradiation+'<span class="paramunit">'+'W/m2' + '</span>');
        $("#latestradiation .highlows .highparam").html('<strong>' + json.jws.today.highradiation + '</strong>');
        $("#latestradiation .highlows .high_time").html(json.jws.today.highradiation_time);
        $("#latestradiation .trendstable .trendsvalues .innertrendvalue").eq(0).html(json.jws.yestsametime.srchange.split(",")[2]);
        $("#latestradiation .trendstable .trendsvalues .innertrendvalue").eq(1).html(json.jws.oneHour.srchange.split(",")[2]);
        $("#latestradiation .trendstable .trendsvalues .innertrendvalue").eq(2).html(json.jws.min30.srchange.split(",")[2]);
        $("#latestradiation .paramtrend .innertrendvalue").html(json.jws.min15.minutes + " " + "<?=$MINTS[$lang_idx]?>: " + json.jws.min15.srchange.split(",")[2]+"%");
       
        $("#latesttemp3 .paramvalue").html(c_or_f(json.jws.current.temp3, tempunit)+'<span class="paramunit">'+tempunit+'</span>' + '&nbsp;<span id=\"valleytemp\" title=\"\">' + title_temp3 + '</span>');
        $("#latesttemp3 .highlows .high").html('<strong>' + c_or_f(json.jws.today.hightemp3, tempunit) + '</strong>');
        $("#latesttemp3 .highlows .high_time").html(json.jws.today.hightemp3_time);
        $("#latesttemp3 .highlows .low").html('<strong>' + c_or_f(json.jws.today.lowtemp3, tempunit) + '</strong>');
        $("#latesttemp3 .highlows .low_time").html(json.jws.today.lowtemp3_time);
        $("#latesttemp3 .trendstable .trendsvalues .innertrendvalue").eq(0).html(json.jws.yestsametime.temp3change.split(",")[2]);
        $("#latesttemp3 .trendstable .trendsvalues .innertrendvalue").eq(1).html(json.jws.oneHour.temp3change.split(",")[2]);
        $("#latesttemp3 .trendstable .trendsvalues .innertrendvalue").eq(2).html(json.jws.min30.temp3change.split(",")[2]);
        $("#latesttemp3 .paramtrend .innertrendvalue").html(json.jws.min15.minutes + " " + "<?=$MINTS[$lang_idx]?>: " + json.jws.min15.temp3change.split(",")[2]);
        if (json.jws.current.islight == 1)
            $("#temp3_desc").html(json.jws.desc.temp3_desc<?=$lang_idx?>);
        else
            $("#temp3_desc").html(json.jws.desc.temp3_night_desc<?=$lang_idx?>);
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
		$("#latestairq .paramvalue").html(json.jws.current.pm10 + '<span class=\"paramunit\">&plusmn;' + json.jws.current.pm10sd + '&nbsp;µg/m3&nbsp;(PM10)</span><br />' + 
                             json.jws.current.pm25  + '<span class=\"paramunit\">&plusmn;'+ json.jws.current.pm25sd + '&nbsp;µg/m3&nbsp;(PM2.5)</span>');
        for (i = 0; i< 4; i++){ 
        $('#shortforecast').children('.nav').children().eq(i).html(json.jws.forecastDays[i].day_name<?=$lang_idx?>+"  "+json.jws.forecastDays[i].date+"</br>"+"<img src=\"" + json.jws.forecastDays[i].icon + "\" onclick=\"showNextDays()\" width=\"32\" height=\"32\" alt=\"" + json.jws.forecastDays[i].icon +"\" /></br>"+c_or_f(json.jws.forecastDays[i].TempLow, tempunit)+" - "+c_or_f(json.jws.forecastDays[i].TempHigh, tempunit));
        }
        var forecastHours = "";
        for (i = 0; i< json.jws.sigforecastHours.length; i++){
       
           forecastHours += "<ul class=\"nav forecasttimebox\" >";
           forecastHours += "<li class=\"tsfh currentts\" style=\"display:none\"><span>" + json.jws.sigforecastHours[i].currentDateTime + "</span></li>";
           forecastHours += "<li class=\"tsfh forcast_date\"><span>" + json.jws.sigforecastHours[i].date + "</span></li>";
           forecastHours += "<li class=\"timefh forcast_time\"><span>" + json.jws.sigforecastHours[i].time + ":00" + (json.jws.sigforecastHours[i].plusminus > 0 ? "&nbsp;&plusmn;"+json.jws.sigforecastHours[i].plusminus : "") +"</span></li>";
           forecastHours += "<li class=\"forecasttemp\" id=\"tempfh"+ json.jws.sigforecastHours[i].time + "\"><span>" + c_or_f(json.jws.sigforecastHours[i].temp, tempunit) + "<img style=\"vertical-align: middle\" src=\"images/clothes/"+json.jws.sigforecastHours[i].cloth+"\" height=\"15\" width=\"20\" /></span></li>";
           forecastHours += "<li style=\"padding:0;\"><div title=\"" + json.jws.sigforecastHours[i].wind_title<? echo $lang_idx;?>+"\" class=\"wind_icon "+json.jws.sigforecastHours[i].wind_class+" \"></div></li>";
           forecastHours += "<li class=\"forcast_icon\"><span><img src=\"images/icons/day/"+json.jws.sigforecastHours[i].icon+"\" height=\"30\" width=\"30\" /></span></li>";
           forecastHours += "<li class=\"forcast_title\"><span>"+json.jws.sigforecastHours[i].title<? echo $lang_idx;?>+"</span></li>";
           forecastHours += "</ul>";
       }
       
       var forecastHoursD = "";
        for (i = 0; i< json.jws.forecastHours.length; i++){
        if ((json.jws.forecastHours[i].time % 3 == 0) || (json.jws.forecastHours[i].plusminus > 0))
        {
           var  TempCloth = '&nbsp;<a href=\"javascript:void(0)\" class=\"info\" ><img style=\"vertical-align: middle\" src=\"'+json.jws.forecastHours[i].cloth+'\" width=\"20\" height=\"15\" title=\"'+json.jws.forecastHours[i].cloth_title<? echo $lang_idx;?>+'\" alt=\"\" /><span class=\"info\">'+json.jws.forecastHours[i].cloth_title<? echo $lang_idx;?>+'</span></a>';
           forecastHoursD += "<ul class=\"nav forecasttimebox\" >";
           forecastHoursD += "<li class=\"tsfh currentts\" style=\"display:none\"><span>" + json.jws.forecastHours[i].currentDateTime + "</span></li>";
           forecastHoursD += "<li class=\"tsfh forcast_date\"><span>" + json.jws.forecastHours[i].date + "</span></li>";
           forecastHoursD += "<li class=\"timefh forcast_time\"><span>" + json.jws.forecastHours[i].time + ":00" + (json.jws.forecastHours[i].plusminus > 0 ? "&nbsp;&plusmn;"+json.jws.forecastHours[i].plusminus : "") +"</span></li>";
           forecastHoursD += "<li class=\"forecasttemp\" id=\"tempfh"+ json.jws.forecastHours[i].time + "\"><span>" + c_or_f(json.jws.forecastHours[i].temp, tempunit) + " " +TempCloth + "</li>";
           forecastHoursD += "<li style=\"padding:0;\"><div title=\"" + json.jws.forecastHours[i].wind_title<? echo $lang_idx;?>+"\" class=\"wind_icon "+json.jws.forecastHours[i].wind_class+" \"></div></li>";
           forecastHoursD += "<li class=\"forcast_icon\"><span><img src=\"images/icons/day/"+json.jws.forecastHours[i].icon+"\" height=\"30\" width=\"30\" /></span></li>";
           forecastHoursD += "<li class=\"forcast_title\"><span>"+json.jws.forecastHours[i].title<? echo $lang_idx;?>+"</span></li>";
           forecastHoursD += "</ul>";
       }
       }
       //$('#for24_given').html('<? echo $GIVEN[$lang_idx]." ".$AT[$lang_idx]." ";?>' + json.jws.TAF.timetaf + ':00 ' + json.jws.TAF.dayF + '/' + json.jws.TAF.monthF + '/' + json.jws.TAF.yearF);
       $('#for24_hours').html(forecastHours);
       $('#for24_hours_D').html(forecastHoursD);

       var forecastDays;
       var fulltextforecast;
       var textforecast;
       var textforecastwidth = "100px";
       var partialtext;
       var partialtextlastindex;
       var TempHighCloth, TempNightCloth;
       var lastindex = 28;
       var link_for_yest;
       var containsanchor;
       var get_cloth = '<?=$_GET['c']?>';
       var get_sound = '<?=$_GET['s']?>';
       var morning_value = json.jws.yest.morningtemp;
       var noon_value = json.jws.yest.noontemp;
       var noon_value_change = json.jws.yest.hightemp_change;
       var night_value = json.jws.yest.nighttemp;
       var date_value = json.jws.yest.date;
       var dayF_a =  json.jws.forecastDays[0].date.split("/")[0];
       var day_a =  json.jws.current.date0.split(" ")[4].split("/")[0];
       if (dayF_a != day_a)
       {
         morning_value = json.jws.today.morningtemp;
         noon_value = json.jws.today.noontemp;
         noon_value_change = json.jws.today.hightemp_change;
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
       forecastDays += "<td class=\"tsfh\" style=\"text-align:center;direction:ltr\">" + c_or_f(morning_value, tempunit) + "</td>";
       forecastDays += "<td class=\"tsfh\" style=\"text-align:center;direction:ltr\">" + c_or_f(noon_value, tempunit) +"</td>";
       forecastDays += "<td class=\"tsfh\" style=\"text-align:center;direction:ltr\">" + c_or_f(night_value, tempunit) + "</td>";
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
            forecastDays += "<td class=\"forcast_each\" style=\"width:32px\">";
            if (i==0)
                forecastDays += noon_value_change;
            forecastDays += "<img src=\"" + json.jws.forecastDays[i].icon + "\" width=\"32\" height=\"32\" alt=\"" + json.jws.forecastDays[i].icon +"\" />"+"</td>";
            fulltextforecast = json.jws.forecastDays[i].lang<? echo $lang_idx;?>;
            containsanchor = fulltextforecast.indexOf("<a");
            partialtextlastindex = (containsanchor > 0) ? containsanchor - 1 : lastindex;
            partialtext = fulltextforecast.substring(0, partialtextlastindex);
            if ((fulltextforecast.length > lastindex)&&!(containsanchor > 0))
                textforecast = "<a href=\"javascript:void(0)\" class=\"info\" >" + fulltextforecast.substring(0, partialtext.lastIndexOf(" ")) + "..." + "<span class=\"info\"> " + fulltextforecast + "</span></a>" + "</td>";
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
       $('#logo').show();
       $('#currentinfo_container').show();
       
       $('#messages_box').show();
       if (json.jws.LatestUserPic.passedts < 7200){
           var latest_user_pic = "<a href=\"small.php?section=userPics.php&amp;lang=<?=$lang_idx."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c'];?>\"><img src=\"" +  json.jws.LatestUserPic.picname + "\" width=\"290\" title=\"userpic\" /></br>" + decodeURIComponent(json.jws.LatestUserPic.name.replace(/\+/g, " ")) + ": " + decodeURIComponent(json.jws.LatestUserPic.comment.replace(/\+/g, " ")) + "</a>&nbsp;&nbsp;";
           $('#latest_user_pic').html(latest_user_pic);
       }
       if (json.jws.LatestPicOfTheDay.passedts < 9600){
           var latest_pic_of_the_day = "<a href=\"small.php?section=picoftheday.php&amp;lang=<?=$lang_idx."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c'];?>\"><img src=\"" +  json.jws.LatestPicOfTheDay.picurl + "\" width=\"290\" title=\"pic of the day\" /></br><?=$PIC_OF_THE_DAY[$lang_idx]?><br/>" + decodeURIComponent(json.jws.LatestPicOfTheDay.caption.replace(/\+/g, " ")) + "</a>&nbsp;&nbsp;";
           $('#latest_picoftheday').html(latest_pic_of_the_day);
       }
       $('#livepic_box').show();
       $('#canvas').show();
        if ((json.jws.states.issnowing != 1) && (json.jws.states.israining == 1))    
       {$.getScript( "js/rain.js" );
           if (get_sound == 1){
               playSound();
           }
       }
       else if (json.jws.states.issnowing == 1)    
          {$.getScript( "js/snow.js" );};
    }
    function navMain(tabcontainer, nodeid){
        
        $('#now_title').removeClass('for_active');
        $('#for24h_title').removeClass('for_active');
        $('#fornextdays_title').removeClass('for_active');
        $('#expand').removeClass('for_active');
        $('#for24_hours_D').hide();
        $('#forcast_hours').hide();
        $('#forecastnextdays').hide();
        $('#currentinfo_container').hide();
        
        $('#' + nodeid).addClass('for_active');
        $('#' + tabcontainer).show();
        if (!isUserAdApproved)
             $('#adunit2').show();
        
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
   window.addEventListener('load', function () {
    $('.adsbygoogle iframe').on('click', 'a[target="_system"],a[target="_blank"],a[target="_top"]', function (e) {
      e.preventDefault();
      var url = this.href;
      window.open(url,"_system");
    });
  }, false);
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
<script src="js/tinymce/tinymce.min.07032017.js" type="text/javascript"></script>
<script src="footerScripts160816.php?lang=<?=$lang_idx?>&temp_unit=<?if (empty($_GET['tempunit'])) echo "°c"; else echo $_GET['tempunit'];?>"  type="text/javascript"></script>
<script type="text/javascript">
startup(<?=$lang_idx?>, <?=$limitLines?>, "<?=(isset($_GET['update'])?$_GET['update']:'')?>");
if (!isUserAdApproved)
	{
		$("#adunit1").show();
		if (('#adunit3').length)
			 $('#adunit3').show();
		 $('#adunit2').show();
	}
	else{
	  $('#adunit2').hide();  
      $('#adsense_start').remove();
    }
</script>
<?}?>
</body>
</html>
<? if ($_GET['debug'] == '') include "end_caching.php"; ?>