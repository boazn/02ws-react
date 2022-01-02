<?
header('Content-type: text/html; charset=utf-8');
header("Access-Control-Allow-Origin: null");
ini_set("display_errors","Off");
ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE);
if ($_GET['debug'] == '')
include "../begin_caching.php";
define("BASE_URL","https://www.02ws.co.il");
$HOME_PAGE = array("To home page","לעמוד הראשי");
$HOTORCOLD_T = array("Cold meter", "מדד הקור");
$FSEASON_T = array("Best season", "העונה הטובה");
$IT_FEELS = array("Feels like", "מרגיש כמו");
$IN_THE_SUN = array("sun", "שמש");
$MINTS = array("min", "דק'");
$DAILY_RAIN = array("Daily rain", "גשם היום מחצות");
$SYSTEM = array("System", "מערכת");
$TOTAL_RAIN = array("Total", "סה'כ");
$RAIN = array("rain","גשם");
$CLOTH = array("cloth","לבוש");
$CHANCE_OF = array("Chance of", "סיכוי ל-");
$RAIN_RATE = array("Rain rate" , "עוצמת גשם");
$TEMP = array("Temperature" , "טמפרטורה");
$WIND = array("wind" , "רוח");
$HUMIDITY = array("humidity" , "לחות");
$RADIATION = array("radiation" , "קרינה", "излучение ");
$DUST = array("dust", "אבק", "пыль");
$RUN_WALK = array("Run and walk", "הליכה וריצה", "");
$DUSTPM25 = array("small ", "אבק קטן", "пыль");
$DUSTPM10 = array("large", "אבק גדול", "пыль");
$DUST_THRESHOLD1 = array("Not healthy", "לא בריא", "вредно для здоровья");
$DUST_THRESHOLD2 = array("Sport activity is not recommended", "לא לעשות ספורט", "не рекомендуется заниматься спортом, более опасный");
$DUST_THRESHOLD3 = array("small is more dangerous", "הקטן יותר מסוכן", "не рекомендуется заниматься спортом, более опасный"); 
$HOURLY = array("Hourly", "שעתי");
$FORECAST_4D = array("Daily", "יומי");
$GIVEN = array("given", "ניתנה");
$AT = array("at ", "ב-");
$MESSAGES = array("Alerts", "התראות");
$REMOVE_ADS = array("Want to remove ads? click here:", "רוצה להסיר פרסומות? כאן:");
$LIVE_PICTURE = array("Live Air", "שידור חי");
$RAIN_UNIT = array("mm", "מ''מ");
$WIND_UNIT = array("km/h", "קמש");
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
$WEBSITE_TITLE = array ("Jerusalem Weather Forecast Station", "ירושמים - תחזית ומזג-האוויר בירושלים בזמן אמת", "Иерусалимская метеорологическая станция");
$MORE_INFO = array("more", "עוד", "еще");
$EXPAND = array("In table", "בטבלה");
$PIC_OF_THE_DAY = array("Pic of the day", "תמונת היום", "");
$USERS_PICS = array("Users Pics", "תמונות הגולשים", "");
$NOW = array("Now", "עכשיו", "");
$SHADE = array("shade", "צל", "");
$SUNSHINEHOURS = array("sunshine hours" , "שעות שמש", "световой день ");
$TILL_NOW = array("till now", "עד עכשיו", "До настоящего времени");
$CHOOSE_STARTPAGE = array("choose this page as start page", "בחירת דף זה כדף פתיחה", "выберите эту страницу в качестве стартовой");
$RISE = array("Rise", "זריחה", "Восход");
$SET = array("Set", "שקיעה", "Закат");
$DESKTOP_REDIRECT = array("To website", "לאתר", "website");

function mainPage()
{
    return ($_REQUEST['section'] == "");
}
if (mainPage()) 
{}
else if (!isFastPage())
{
    include "../start.php";
    include_once ("../requiredDBTasks.php");
    include "../sigweathercalc.php";
    include "../runwalkcalc.php";
    
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
    
    return (($_REQUEST['section'] == "graph.php")||($_REQUEST['section'] == "dust.php"));
}
function isSurveyPage(){
    return (($_REQUEST['section'] == "survey.php"));
}
function isContactPage(){
    return (($_REQUEST['section'] == "SendEmailForm.php"));
}
function isRadarPage(){
    return (($_REQUEST['section'] == "radar.php"));
}
function isForumPage(){
    return (($_REQUEST['section'] == "chatmobile.php"));
}
function isForecastPage(){
    return (($_REQUEST['section'] == "forecast/getForecast.php"));
}
function isSnowPage(){
    return (($_REQUEST['section'] == "snow.php"));
}
function getUrl($page){
    global $lang_idx;
    if ($page != "")
        return BASE_URL.$_SERVER['SCRIPT_NAME']."?section=".$page."&amp;lang=".$lang_idx."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c'];
    else
        return BASE_URL.$_SERVER['SCRIPT_NAME']."lang=".$lang_idx."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c'];
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

<link rel="stylesheet" href="<?=BASE_URL?>/css/main<?=$lang_idx;?>.css" type="text/css" />
<link rel="stylesheet" href="<?=BASE_URL?>/css/mobile<?=$lang_idx;?>.css" type="text/css" />
<link rel="manifest" href="manifest.php?lang=<?=$lang_idx?>">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<link rel="apple-touch-icon" href="/img/logo.svg">
<link rel="icon" type="image/png" href="img/favicon_sun.png" />
<meta property="og:image" content="https://www.02ws.co.il/02ws_short.png" />
<meta name="viewport" content="width=<?=$width?><? if (isFastPage()) echo ",user-scalable=no";?>" />
<title><?=$WEBSITE_TITLE[$lang_idx]." - ".$MOBILE_FRIENDLY[$lang_idx]?></title>
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
<div id="navbar" style="display:none">
</div>
<div style="" id="main_cellphone_container">
<div class="loading"><img src="img/loading.gif" alt="loading" width="32" height="32" /></div>
<? if (isFastPage()) {?>

<div id="adunit1" class="adunit" style="visibility:hidden">
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Ad small page -->
<ins class="adsbygoogle"
     style="display:block;width:320px;height:50px"
     data-ad-format="fluid"
     data-ad-layout="image-top"
     data-ad-client="ca-pub-2706630587106567"
     data-ad-slot="6699246495" data-auto-ad-size="false" data-overlap-observer-io="false"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>

<?}?>
<? if (mainPage()) {?>
<div id="nextdays" style="visibility:hidden">
    <div id="for_title" class="float">
        <div id="now_title" class="now_title forcast_title_btns for_active">
        <a href="#main_cellphone_container" onclick="navMain('startinfo_container', $(this).parent().attr('id'), 'none')">
                <? echo($NOW[$lang_idx]);?>
        </a>
        </div>
        <div id="for24h_title" class="for24h_title forcast_title_btns">
        <a href="#main_cellphone_container" id="" onclick="navMain('forcast_hours_table', $(this).parent().attr('id'), 'none')">
                <? echo($HOURLY[$lang_idx]); ?>
        </a>
        </div>
        <div id="fornextdays_title" class="fornextdays_title forcast_title_btns" >
        <a href="#main_cellphone_container" id="" onclick="navMain('forecastnextdays', $(this).parent().attr('id'), 'none')">
                <? echo($FORECAST_4D[$lang_idx]); ?>
        </a>
        </div>
        <div id="alerts_title" class="alerts_title forcast_title_btns">
        <a href="#main_cellphone_container" id="" onclick="navMain('messages_box', $(this).parent().attr('id'), 'none')">
                <? echo($MESSAGES[$lang_idx]); ?>
        </a>
        </div>
        
   </div>
</div>

<?}?>
<div id="logo" <?if (!mainPage()) echo " class=\"logo_secondary\"";?> style="display:none">
<a href="station.php?section=frommobile&amp;lang=<? echo $lang_idx;?>" id="logotitle" title="<? echo $HOME_PAGE[$lang_idx];?>" onclick="showLoading()">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
<div id="date"></div>
</div>
<? if (isAlertsPage()||!isFastPage()) { ?>
<!--
<div id="tohome" class="float inv_plain_3">
<a href="<? echo BASE_URL.substr(strrchr($_SERVER["PHP_SELF"], "/"), 0)."?lang=".$lang_idx."&amp;tempunit=".$_GET['tempunit']."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c'];?>"  title="<? echo $HOME_PAGE[$lang_idx];?>" class="hlink">
&lsaquo;
</a>
</div>-->
<?}?>
<? if ($_GET['startpage'] == "1") {?>
<div id="startpage_con">
<input type="checkbox" name="startpage" value="" id="startpage_chb"/><?=$CHOOSE_STARTPAGE[$lang_idx]?>
</div>
<?}?>
<? if (isForumPage()) {?>
<ul class="nav" id="user_info">
    <li><div id="user_icon"></div><p id="user_name"></p><span class="arrow_down">▼</span>
                <ul style="<?echo get_s_align();?>: -2em;">
                      <li>
                              <div id="notloggedin" style="display:none" class="inv_plain_3_zebra">
                                      <div class="clear"><a href="javascript: void(0)" class="button" id="login" title="<?=$LOGIN[$lang_idx]?>" ><?=$LOGIN[$lang_idx]?></a></div>
                                      <div class="clear"><a href="javascript: void(0)" class="button register" id="register" title="<?=$REGISTER[$lang_idx]?>"><?=$REGISTER[$lang_idx]?></a></div>

                              </div>
                              <div id="loggedin" style="display:none" class="inv_plain_3_zebra">
                                      <input id="updateprofile" class="button" title="<?=$UPDATE_PROFILE[$lang_idx]?>" value="<?=$UPDATE_PROFILE[$lang_idx]?>" /><br />
                                      <input id="myvotes" class="button" title="<?=$MY_VOTES[$lang_idx]?>" value="<?=$MY_VOTES[$lang_idx]?>" onclick="redirect('<?=$_SERVER['SCRIPT_NAME']?>?section=myVotes.php&amp;lang=<?=$lang_idx?>')" /><br />
                                      <input value="<?=$SIGN_OUT[$lang_idx]?>" onclick="signout_from_server(<?=$lang_idx?>, <?=$limitLines?>, '<?=$_GET['update']?>')" id="signout" class="button"/>
                              </div>
                      </li>
                </ul>
        </li>

</ul>
<div id="register_suggest" style="display:none" class role="dialog">
<button type="button" class="close_icon" onclick="$( this ).parent().hide();"></button>
<h2><span id="register_suggest_title"><?=$HOTORCOLD_T[$lang_idx]?></span></h2>
<span id="register_suggest_desc"><?=$REGISTER_SUGGEST[$lang_idx]?></span>
<div class="clear"><a href="javascript: void(0)" class="button login" id="register_suggest_register" title="<?=$LOGIN[$lang_idx]?>" onclick="$( this ).parent().parent().hide();$('#loginform').show();"><?=$LOGIN[$lang_idx]?></a></div>
<div class="clear"><a href="javascript: void(0)" class="button register" id="register_suggest_register" title="<?=$REGISTER[$lang_idx]?>" onclick="$( this ).parent().parent().hide();$('#registerform').show()"><?=$REGISTER[$lang_idx]?></a></div>
<div class="clear"><a href="javascript: void(0)" class="button" id="register_suggest_anon" title="<?=$ANONYMOUS_COLDMETER[$lang_idx]?>" onclick="$( this ).parent().parent().hide();rememberCookie('anonymous_coldmeter', 1, 0.1)"><?=$ANONYMOUS_COLDMETER[$lang_idx]?></a></div>
<div class="clear"><a href="javascript: void(0)" class="button close" id="register_suggest_close" title="<?=$CANCEL[$lang_idx]?>" onclick="$( this ).parent().parent().hide();"><?=$CLOSE[$lang_idx]?></a></div>
</div>
<?} if (!mainPage()&&!isGraphsPage()) {
   ?>
<article id="section" >
   <? include('../'.$_GET['section']);?>
</article>
<? }
else {?>
<div id="startinfo_container" class="inparamdiv" style="display:none">
<div  id="windystart"></div>
<div id="tempdivvaluestart" style="display:none" onclick="navMain('currentinfo_container', 'now_title', 'down');">
</div>
<div id="statuslinestart">
    <div  id="coldmeterstart">
    <a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=survey.php&amp;survey_id=2&amp;lang=<? echo $lang_idx."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c'];?>"> 
    <span id="current_feeling_link_start"><img src="img/loading.gif" alt="loading" width="32" height="32" /></span>
     </a>
    </div>
</div>
<div id="what_is_h_start" style="display:none"></div>
<div id="latestalert" >
</div>
<div id="arrowdown" onclick="navMain('currentinfo_container', 'now_title', 'down');">
&#x2304;
</div>
<div style="clear:both;height:10px">&nbsp;</div>

</div>
<div id="currentinfo_container" style="display:none">
<ul class="info_btns" style="display:none">
    <li id="now_btn" onclick="change_circle('now_line', 'latestnow')"></li>
   <li id="temp_btn" onclick="change_circle('temp_line', 'latesttemp2')" title=""></li>
   <li id="temp2_btn" onclick="change_circle('temp_line', 'latesttemp')" title=""></li>
   <li id="temp3_btn" onclick="change_circle('temp_line', 'latesttemp3')" title=""></li>
    </li>
   <li id="rain_btn" onclick="change_circle('rain_line', 'latestrain')" title=""></li>
   <li id="wind_btn" onclick="change_circle('wind_line', 'latestwind')" title=""></li>
   <li id="aq_btn" onclick="change_circle('aq_line', 'latestairq')" title=""></li>
   <li id="rad_btn" onclick="change_circle('rad_line', 'latestradiation')" title=""></li>
   <li id="window_btn" onclick="change_circle('window_line', 'latestwindow')" title=""></li>
   <li id="moon_btn" onclick="change_circle('window_line', 'latestmoon')" title="" style="display:none"></li>
   <li id="dew_btn" onclick="change_circle('window_line', 'latestdewpoint')" title="" style="display:none"></li>
   <li id="air_btn" onclick="change_circle('window_line', 'latestpressure')" title="" style="display:none"></li>
   <li id="webcam_btn" onclick="change_circle('window_line', 'latestwebcam')" title="<?=$LIVE_PICTURE[$lang_idx]?>"></li>
   <li id="cold_btn">
    <a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=survey.php&amp;survey_id=2&amp;lang=<? echo $lang_idx."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c'];?>" onclick="showLoading()">
    <?=$HOTORCOLD_T[$lang_idx]?>
    </a>
    <li id="moist_btn" onclick="change_circle('moist_line', 'latesthumidity')" title=""></li>
    <li id="runwalk_btn" onclick="change_circle('runwalk_line', 'latestrunwalk')" title=""></li>
    </li>
    <li id="more_stations_btn" onclick="change_circle('otherstations_line', 'latestotherstations');getLatest('ראש-צורים', '77', 'IMS');getLatest('צובה', '188', 'IMS');getLatest('חוף מערבי', '178', 'IMS');getLatest('עין גדי','211', 'IMS');getLatest('מעלה אדומים', '218', 'IMS');" title=""></li>
    </li>
</ul>
<div id="latestnow" class="inparamdiv">
 <div  id="windy">

 </div>
<div class="" id="itfeels" style="display:none;">
<? echo $IT_FEELS[$lang_idx]; ?>
 <span class="" id="itfeels_thsw" style="display:none;">
    <a title="<?=$THSW[$lang_idx]?>"  href="<?=$_SERVER['SCRIPT_NAME']?>?section=graph.php&amp;graph=THSWHistory.gif&amp;profile=1&amp;lang=<?=$lang_idx."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c']?>"> 
    <span dir="ltr" class="high value" title="<?=$THSW[$lang_idx]?>"><? echo $itfeels[1];  ?></span> 
    </a></span>
    <span class="sunshade" style="display:none;"><img src="images/shadow.png" width="15" alt="<? echo $SHADE[$lang_idx]."/".$IN_THE_SUN[$lang_idx]; ?>" /></span>
<span id="itfeels_windchill" style="display:none;"> 
<a title="" href="<?=$_SERVER['SCRIPT_NAME']?>?section=graph.php&amp;graph=tempwchill.php&amp;profile=1&amp;lang=<?=$lang_idx."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c']?>" onclick="showLoading()"> 
 <span dir="ltr" class="value" title="<?=$WIND_CHILL[$lang_idx]?>"></span> 
 </a> 
</span>
<span id="itfeels_thw" style="display:none;"> 
<a title="" href="<?=$_SERVER['SCRIPT_NAME']?>?section=graph.php&amp;graph=thw.php&amp;profile=1&amp;lang=<?=$lang_idx."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c']?>" onclick="showLoading()"> 
 <span dir="ltr" class="value" title="<?=$WIND_CHILL[$lang_idx]?>"></span> 
 </a> 
</span>
<span class="" id="itfeels_heatidx" style="display:none;">
<a title="" href="<?=$_SERVER['SCRIPT_NAME']?>?section=graph.php&amp;graph=tempheat.php&amp;profile=1&amp;lang=<?=$lang_idx."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c']?>" onclick="showLoading()"> 
 <span dir="ltr" class="high value" title="<?=$HEAT_IDX[$lang_idx]?>"></span> 
 </a> 
</span>
</div>
<div id="tempdivvalue" style="visibility:hidden">

</div>
<div id="statusline" style="visibility:hidden">
    <div  id="coldmeter">
    <a href="<?=$_SERVER['SCRIPT_NAME']?>?section=survey.php&amp;survey_id=2&amp;lang=<?=$lang_idx?>&amp;email=<?=$_SESSION['email']?>"> 
    <span id="current_feeling_link">&nbsp;</span>
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
                 <div class="highparam"><strong></strong></div>&nbsp;<img src="img/peak_max.png" width="15" height="14" alt=""/>&nbsp;<span class="high_time"></span>
                 <div class="lowparam"><strong></strong></div>&nbsp;<img src="img/peak_min.png" width="15" height="14" alt=""/>&nbsp;<span class="low_time"></span>
         </div> 
         <div class="paramtrend">
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
                 <a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=tempLatestArchive.php&amp;profile=1&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c']?>" title="" onclick="showLoading()"><? echo $MORE_INFO[$lang_idx].get_arrow();?></a>
    </div>
 </div>
<div id="latesttemp2" class="inparamdiv" style="display:none;">
    <div class="paramtitle slogan">
             <a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=temp<?if ($PRIMARY_TEMP == 1) echo "LatestArchive";?>.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>&amp;style=<?=$_GET["style"]?>" title=""><? echo $TEMP[$lang_idx];?></a>
         </div>
        <div class="paramvalue">
             
         </div>
         <div class="highlows">
                 <div class="highparam"><strong></strong></div>&nbsp;<img src="img/peak_max.png" width="15" height="14" alt=""/>&nbsp;<span class="high_time"></span>
                 <div class="lowparam"><strong></strong></div>&nbsp;<img src="img/peak_min.png" width="15" height="14" alt=""/>&nbsp;<span class="low_time"></span>
         </div> 
         <div class="paramtrend">
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
                 <a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=temp<?if ($PRIMARY_TEMP == 1) echo "LatestArchive";?>.php&amp;profile=1&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c']?>" title="" onclick="showLoading()"><? echo $MORE_INFO[$lang_idx].get_arrow();?></a>
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
       <div class="paramtrend">
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
                <a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=humwind.php&amp;level=1&amp;freq=2&amp;datasource=downld02&amp;profile=1&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>" title="" onclick="showLoading()"><? echo $MORE_INFO[$lang_idx].get_arrow();?></a>
   </div>
</div>
<div id="latestpressure" class="inparamdiv" <? if (isHeb()) echo "dir=\"rtl\" ";?> style="display:none">
</div>
<div id="latestwebcam" class="inparamdiv" style="display:none;overflow: hidden;">
    <div id="livepic_box" class="" style="display:none">
    <a href="<?=$_SERVER['SCRIPT_NAME']?>?section=smallwebcam.php&amp;lang=<?=$lang_idx."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c'];?>" title="<? echo($LIVE_PICTURE[$lang_idx]);?>" onclick="showLoading()"><img src="<?=BASE_URL?>/phpThumb.php?src=images/webCameraB.jpg&w=600&fltr%5B%5D=gam%7C0.9" width="280" height="285" alt="<? echo($LIVE_PICTURE[$lang_idx]);?>" /></a>
    </div>
</div>
<div id="latestmoon" class="inparamdiv" style="display:none;">
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
    <div class="paramtrend">
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
       <tr class="trendsvalues">
        <td><div class="trendvalue"><div class="innertrendvalue"></div></div></td>
        <td><div class="trendvalue"><div class="innertrendvalue"></div></div></td>
        <td><div class="trendvalue"><div class="innertrendvalue"></div></div></td>
    </tr>
      </table>
    </div>
    <div class="graphslink">
                    <a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=wind.php&amp;profile=1&amp;lang=<? echo $lang_idx;?>" ><? echo $MORE_INFO[$lang_idx].get_arrow();?></a>
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
<div class="paramtrend">
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
            <a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=RainRateHistory.gif&amp;profile=1&amp;lang=<? echo $lang_idx;?>" title="" onclick="showLoading()"><? echo $MORE_INFO[$lang_idx].get_arrow();?></a>
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
    <div class="paramtrend">
            <div class="innertrendvalue">
            
            </div>
        </div>
    <div class="trendstable">	
      <table>
       <tr class="trendstitles">
            <td  class="box" title=""><img src="img/24_icon.png" width="21" alt="24 hours" /></td>
            <td  class="box" title=""><img src="img/half_icon.png" width="21" alt="half hour"/></td>
            <td class="box" title=""><img src="img/quarter_icon.png" width="21" alt="quarter hour"/></td>
       </tr>
       <tr class="trendsvalues">
        <td><div class="trendvalue"><div class="innertrendvalue"></div></div></td>
        <td><div class="trendvalue"><div class="innertrendvalue"></div></div></td>
        <td><div class="trendvalue"><div class="innertrendvalue"></div></div></td>
       </tr>
      </table>
    </div>
    <div class="graphslink">
      <a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=rad.php&amp;profile=1&amp;lang=<? echo $lang_idx;?>" ><? echo $MORE_INFO[$lang_idx].get_arrow();?></a>&nbsp;&nbsp;&nbsp;&nbsp;
      <div id="uv_btn" onclick="change_circle('rad_line', 'latestuv')" title=""></div>
    </div>
</div>
<div id="latestuv" class="inparamdiv" <? if (isHeb()) echo "dir=\"rtl\" ";?> style="display:none">
    <div class="paramtitle slogan">
                    UV
    </div>
    <div id="uvvalues" class="paramvalue">
            
    </div>
    <div class="highlows">
        <div class="highparam"><strong></strong></div>&nbsp;<img src="img/peak_max.png" width="15" height="14" alt=""/>&nbsp;<span class="high_time"></span>
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
        <a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=UVHistory.gif&amp;profile=1&amp;lang=<? echo $lang_idx;?>" title=""><? echo $MORE_INFO[$lang_idx].get_arrow();?></a>
    </div>
</div>
<div id="latestairq" class="inparamdiv" <? if (isHeb()) echo "dir=\"rtl\" ";?> style="display:none">
	<div class="paramtitle slogan">
		<?=$DUST[$lang_idx]?>
	</div>
	<div id="aqvalues">
		 
	</div>
	    
	<div class="paramtrend"></div>
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
		<a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=dust.php&amp;lang=<? echo $lang_idx;?>" title="to graph"><? echo $MORE_INFO[$lang_idx].get_arrow();?></a>
	</div>
</div>
<div id="latestdewpoint" class="inparamdiv" <? if (isHeb()) echo "dir=\"rtl\" ";?> style="display:none">
<div class="paramtitle slogan">
        <a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=dewptLatestArchive.php&amp;level=1&amp;freq=2&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>&amp;style=<?=$_GET["style"]?>" title=""><? echo $DEW[$lang_idx];?></a>
</div>
<div class="paramvalue">
        <a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=dewptLatestArchive.php&amp;level=1&amp;freq=2&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>&amp;style=<?=$_GET["style"]?>"  class="info"></a>
</div>
<div class="highlows">
            <span><strong><div class="highparam"></div></strong>&nbsp;<img src="img/peak_max.png" width="15" height="14" alt="<? echo $HIGH[$lang_idx]; ?>"/></span>&nbsp;<span class="high_time"></span>
            &nbsp;&nbsp;&nbsp;&nbsp;<span><strong><div class="lowparam"></div></strong>&nbsp;<img src="img/peak_min.png" width="15" height="14" alt="<? echo $LOW[$lang_idx]; ?>"/></span>&nbsp;<span class="low_time"></span>
    </div>
<!--<div class="paramtrend">
    <div class="innertrendvalue">
    
    </div>
</div>-->
<div class="trendstable">
<table>
<tr class="trendstitles">
        <td  class="box" title="24 <? echo $HOURS[$lang_idx];?>"><img src="img/24_icon.png" width="21" alt="24 <? echo $HOURS[$lang_idx];?>"/></td>
        <td  class="box" title="<? echo($HOUR[$lang_idx]);?>"><img src="img/hour_icon.png" width="21" alt="hour"/></td>
        <td  class="box" title="30<? echo($MINTS[$lang_idx]);?>"><img src="img/half_icon.png" width="21" alt="half hour"/></td>
</tr>
    <tr class="trendsvalues">
        <td><div class="trendvalue"><div class="innertrendvalue">
            
            </div></div>
        </td>
        <td><div class="trendvalue"><div class="innertrendvalue">
               
        </div></div>
        </td>
        <td><div class="trendvalue"><div class="innertrendvalue">
           
        </div></div>
    </td>
</tr>
</table>
</div>
<div class="graphslink">
                            <?=$DEW_DESC[$lang_idx]?><br/>
    <a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=dewptLatestArchive.php&amp;level=1&amp;freq=2&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>&amp;style=<?=$_GET["style"]?>" title=""><? echo $MORE_INFO[$lang_idx].get_arrow();?></a>
</div>
</div>
<div id="latesttemp3" class="inparamdiv" <? if (isHeb()) echo "dir=\"rtl\" ";?> style="display:none">
    <div class="paramtitle slogan">
             <a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=temp3LatestArchive.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>&amp;style=<?=$_GET["style"]?>" title=""><? echo $TEMP[$lang_idx];?></a>
         </div>
        <div class="paramvalue">
             
         </div>
         <div class="highlows">
                 <div class="highparam"><strong></strong></div>&nbsp;<img src="img/peak_max.png" width="15" height="14" alt=""/>&nbsp;<span class="high_time"></span>
                 <div class="lowparam"><strong></strong></div>&nbsp;<img src="img/peak_min.png" width="15" height="14" alt=""/>&nbsp;<span class="low_time"></span>
         </div> 
         <div class="paramtrend">
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
                     <td ><div clas s="trendvalue"><div class="innertrendvalue"></div></div></td>
                     <td ><div class="trendvalue"><div class="innertrendvalue"></div></div></td>
                 </tr>
         </table>
    </div>
    <div class="graphslink">
            <span id="temp3_desc"></span><br/>
                 <a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=temp3LatestArchive.php&amp;profile=1&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c']?>" title="" onclick="showLoading()"><? echo $MORE_INFO[$lang_idx].get_arrow();?></a>
    </div>
</div>
<div id="latestwindow" class="inparamdiv" style="display:none">
        <div class="paramtitle slogan"></div>
        <div class="paramvalue">
             
         </div>
         <div class="highlows"></div>
</div>
<div id="chartjs-tooltip" class="inparamdiv" <? if (isHeb()) echo "dir=\"rtl\" ";?> style="display:none">
</div>
<div class="inparamdiv" id="coldmetersurvey" style="display:none">
    
</div>
<div id="latestotherstations" class="inparamdiv">

<div class="WUNowRes" id="WUNowRes_short"></div>
<div class="ImsNowRes" id="ImsNowRes_short"></div>

    <div class="graphslink">
            <a href="<? echo getUrl("IsraelNow.php")?>" title="more"><? echo $MORE_INFO[$lang_idx].get_arrow();?></a>
        </div>
</div>
<div id="latestrunwalk" class="inparamdiv">
        <div class="paramtitle slogan">
        <? echo $RUN_WALK[$lang_idx];?>
        </div>
        <div class="exp">
                    
        </div>
        <div class="graphslink">
            <a href="<? echo getUrl("runwalk.php")?>" title="more"><? echo $MORE_INFO[$lang_idx].get_arrow();?></a>
        </div>
</div>    
<div id="spacer1" style="clear:both;height: 2px;">&nbsp;</div>
<div id="for24_given">
							
	</div>
	<div id="for24_details" style="display:none">
		<span id="tempForecastDiv" style="display:none">
		</span>
	</div>
        <div id="for24_hours_s" style="display:none"></div>
        <div id="legends">
            <ul>
                <li><span id="legend0" style="text-decoration: underline;" onclick="showHourlyParam('temp', 0)" ><?=$TEMP[$lang_idx]?></span></li>
                <li><span id="legend2" style="" onclick="showHourlyParam('humidity', 2)" ><?=$HUMIDITY[$lang_idx]?></span></li>
                <li><span id="legend1" style="" onclick="showHourlyParam('rain', 1)" ><?=$RAIN[$lang_idx]?></span></li>
                <li><span id="legend3" style="" onclick="showHourlyParam('cloth', 3)" ><?=$CLOTH[$lang_idx]?></span></li>
                
            </ul>
        </div>    
        <div id="graph_forcastWrapper" >
        <div id="graph_forcast" class="metric-chart h-bar-chart" >
        <ul id="for24_graph_ng" class="x-axis-bar-list">
        </ul>   
        </div>
        
        </div>
        <div id="spacer2" style="clear:both;height:10px">&nbsp;</div>
        
        <div id="adunit3" class="adunit" style="">
        <a href="https://www.riseup.co.il/riseupjerusalem?utm_source=jerusalem&utm_medium=site&utm_content=banner&utm_campaign=riseup_jerusalem"><img src="images/riseup_banner_100_3.png" alt="riseup" width="320" height="100" /></a>
            <!-- Large Mobile Banner 1 -->
           <ins class="adsbygoogle"
                style="display:inline-block;width:320px;height:50px"
                data-ad-client="ca-pub-2706630587106567"
                data-ad-slot="3647675909"></ins>
            <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
        <div id="spacer3" style="clear:both;height:10px">&nbsp;</div>
        <div id="for24_hours"></div>
        <div id="spacer4" style="clear:both;height:15px">&nbsp;</div>
        
 </div>

</div>
<div style="clear:both;height:1px">&nbsp;</div>
<div style="display:none;padding:0.1em 0.4em" id="forcast_hours_table">
</div>
<div style="display:none" id="forecastnextdays">
        <table id="forecastnextdays_table" <? if (isHeb()) echo "dir=\"rtl\""; ?> style="width:100%">
        
	</table> 
    
</div>
<div id="messages_box" style="display:none">
    <h2><? echo $MESSAGES[$lang_idx];?></h2>
    <p id="promotion">

    </p>
    <p class="box_text">
     
    </p>
    <p id="personal_message" >
     
    </p>
	
    <p id="latest_picoftheday" >
     
    </p>
    <p id="latest_user_pic" >
     
    </p>
    
</div>
<? if (isGraphsPage()) {
    ?>
<article id="section" >
   <? include('../'.$_GET['section']);?>
</article>
<? } ?>
<div id="adunit2" class="adunit" style="display:none">
    
    <div id="if1"> 
        <a href="https://www.riseup.co.il/riseupjerusalem?utm_source=jerusalem&utm_medium=site&utm_content=banner&utm_campaign=riseup_jerusalem"><img src="images/riseup_banner_100_3.png" alt="riseup" width="320" height="100" /></a>
    </div>
    <div id="if2">
        <a href="https://www.riseup.co.il/riseupjerusalem?utm_source=jerusalem&utm_medium=site&utm_content=banner&utm_campaign=riseup_jerusalem" ><img src="images/riseup_banner_100_3.png" alt="riseup" width="320" height="100" /></a>
    </div>
    <div id="if3">
        
      

    </div>
    <div id="if4">
       
         
    </div>
	
 <!-- small unit 2 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:320px;height:50px"
     data-ad-client="ca-pub-2706630587106567"
     data-ad-slot="3726818696"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>
<ul id="sigweather" class="white_box" style="display:none">

</ul>
<ul id="forecaststates" class="white_box" style="display:none">

</ul>

 <?}// end  homepage?>

<!-- Parallax  midground clouds -->
<div id="parallax-bg2">
    <div id="cloudiness4bg2" style="display:none">
     <div id="bg2-5" class="cloud-big"><div class="cloud-big-more"></div></div>
     <div id="bg2-6" class="cloud4"><div class="cloud4-more"></div></div>
    <div id="bg2-7" class="cloud1"><div class="cloud1-more"></div></div>
    </div>
    <div id="cloudiness6bg2" style="display:none">
     <div id="bg2-8" class="cloud1"><div class="cloud1-more"></div></div>
    </div>
    <div id="cloudiness8bg2" style="display:none">
    <div id="bg2-4" class="cloud1"><div class="cloud1-more"></div></div>
    <div id="bg2-9" class="cloud2"><div class="cloud2-more"></div></div>
    <div id="bg2-10" class="cloud3"><div class="cloud3-more"></div></div>
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
    <div id="bg1-7" class="cloud1"><div class="cloud1-more"></div></div>
    <div id="bg1-8" class="cloud2"><div class="cloud2-more"></div></div>
    </div>
    <div id="cloudiness8bg1" style="display:none">
    <div id="bg1-9" class="cloud1"><div class="cloud1-more"></div></div>
    <div id="bg1-10" class="cloud1"><div class="cloud1-more"></div></div>
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
        <input type="submit" value="<?=$UPDATE_PROFILE[$lang_idx]?>" onclick="updateprofile_to_server(<?=$lang_idx?>)" id="profileform_submit" class="clear inv_plain_3"/>
        <input type="submit" value="<?=$DONE[$lang_idx]?>" onclick="$('#cboxClose').click();window.location.reload()" id="profileform_OK" class="info inv_plain_3" style="display:none"/>


   </div>
</div>

 <div style="display:none">
    
<div id="loginform" style="padding:1em">
	<div class="float">
        <input type="text" name="email" value="" placeholder="<?=$EMAIL[$lang_idx]?>" id="loginform_email" size="30" tabindex="1" /><br /><br />
        <input type="password" name="password" placeholder="<?=$PASSWORD[$lang_idx]?>" value="" id="loginform_password" tabindex="2" size="15"/><br /><br />
        </div>
        <div class="clear float big" style="padding:1em 0">
        <input type="checkbox" name="rememberme" value="" id="loginform_rememberme"/><?=$REMEMBER_ME[$lang_idx]?>
        </div>  
	<div style="display:none" class="float loading"><img src="images/loading.gif" alt="loading" width="32" height="32"/></div>
        <div id="loginform_result" class="float"></div>
	<input type="submit" value="<?=$LOGIN[$lang_idx]?>" class="float clear inv_plain_3_zebra big" onclick="login_to_server(<?=$lang_idx?>)" id="loginform_submit"/>
        <input type="submit" value="Success!" onclick="$('#colorbox').hide();window.location.reload();" id="loginform_OK" class="info invfloat" style="display:none"/>
        <div class="clear inv_plain_3_zebra float big" style="margin-top:0.8em"><a href="javascript: void(0)" id="forgotpass" title="<?=$FORGOT_PASS[$lang_idx]?>"><?=$FORGOT_PASS[$lang_idx]?></a></div>
 	
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
    <input type="submit" value="<?=$FORGOT_PASS[$lang_idx]?>" onclick="passforgot_to_server(<?=$lang_idx?>)" id="passforgotform_submit" class="info invfloat inv_plain_3 big"/>
    <input type="submit" value="<?=$CLOSE[$lang_idx]?>" onclick="$('#cboxClose').click();" id="passforgotform_OK" class="info invfloat inv_plain_3 big" style="display:none"/>
 </div>
 </div>
 <?}?>
 <div id="mobile_redirect" class="big inv_plain_3_zebra" style="display:none;" class role="dialog">
        <button type="button" id="cboxCloseMobileRedirect" style="top:20px" class="close_icon" onclick="$( this ).parent().hide();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
        <br /><br />
        <h2 class="big inv_plain_2"><br /><a   onclick="redirect_to_desktop(<?=$lang_idx?>)" id="mobile_redirect_submit" class="clear inv_plain_3 big" style="width:100%"><?=$DESKTOP_REDIRECT[$lang_idx].get_arrow()?></a><br /><br /></h2><br/><br/><br/>      
                <div>
                <a href="https://play.google.com/store/apps/details?id=il.co.jws.app" target="_blank">
                        <img src="images/getitongp.svg" alt="Google play App" width="150" height="60"/>
                </a>
                </div>
                <div>
                <a href="https://itunes.apple.com/us/app/yrwsmyym/id925504632?ls=1&mt=8" target="_blank">
                        <img src="images/Available_on_the_App_Store.svg" alt="App Store App" width="150" height="60"/>
                </a>
                </div>
</div>
<div id="startupdiv" style="display:none;" class role="dialog">
<button type="button" id="cboxClose" style="top:20px" class="close_icon" onclick="$( this ).parent().hide();"></button>

<div class="removeadlink">&nbsp; 
</div>
 <div class="removeadlink">
            <?=$REMOVE_ADS[$lang_idx];?><a href="#opensettings.png"><img src="images/opensettings.png" width="35" /></a>
 </div>
 
 <a href="https://www.riseup.co.il/riseupjerusalem?utm_source=jerusalem&utm_medium=site&utm_content=banner&utm_campaign=riseup_jerusalem"><img src="images/riseup_banner_100.png" alt="riseup" width="320" height="100" /></a>
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
            <?=$REMOVE_ADS[$lang_idx];?><a href="#opensettings.png"><img src="images/opensettings.png" width="35" /></a>
    </div>
</div>
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
        if ((tempunit == '°F')||(tempunit == '°Fnull')||(tempunit == 'F')) {
            return ( Math.round(((9 * temp) / 5) + 32)) + '<div class="paramunit">°</div>';
        }
        if (tempunit == 'none')
            return temp;
        return temp + '<div class="paramunit">°</div>' ;
    }
	function loadPostData(jsonstr, coldmeter_size)
	{
            var C_STARTUP_AD_INTERVAL = 2;
		 $.getScript( "<?=BASE_URL?>/footerScripts011221.php?lang=<?=$lang_idx?>&temp_unit=<?if (empty($_GET['tempunit'])) echo "°c"; else echo $_GET['tempunit'];?>" , function( data, textStatus, jqxhr) {
							if (jsonstr  != undefined)
								fillcoldmeter_fromjson(jsonstr, coldmeter_size);
                             $('#latestalert').css('visibility', 'visible');
							 $('#arrowdown').show();
							 
							 $(".loading").hide();
                            <?if ($_GET['reg_id'] != "") {?>
                            $.ajax({
                                type: "GET",
                                url: "<?=BASE_URL?>/checkauth.php?action=getuser&reg_id=<?=$_GET['reg_id']?>&qs=<?=$_SERVER['QUERY_STRING']?>"
                              }).done(function( jsonstr ) {

                                   var jsonT = JSON.parse( jsonstr  );
                                   if (jsonT.user.approved == 1)
                                      isUserAdApproved = true;
                                    if (!isUserAdApproved)
                                    {   
                                    $(".adunit").show();
                                    var forceshow = false;
                                     <? if ($_REQUEST['section'] == "alerts.php") echo "forceshow=true;";?>
                                        if ((sessions % C_STARTUP_AD_INTERVAL == 0) || forceshow)
                                        {
                                            $("#startupdiv").show();
                                        }
                                    }  
                                    else{
                                        $('#adsense_start').remove();
                                        $(".adunit").remove();
                                        $("#adunit1").css('visibility', 'hidden');
                                    }
                                   
                              });
                            <?}else{?>
                            if (!isUserAdApproved)
                            {
                               //$(".adunit").show();
                               var forceshow = false;
                               <? if ($_REQUEST['section'] == "alerts.php") echo "forceshow=true;";?>
                                if ((sessions % C_STARTUP_AD_INTERVAL == 0) || forceshow)
                                {
                                    //$("#startupdiv").show();
                                    should_show_startupdiv = true;
                                }
                            }
                            else{
                              $('#adunit2').remove();  
                              $('#adsense_start').remove();
                            }
                            <?}?>
                            $("#nextdays").css('visibility', 'visible');
                            if (sessions % 2 == 0)
                            {
                                $("#if1").show();
                                $("#if2").hide();
                                $("#if3").show();
                                $("#if4").hide();
                            }
                            else 
                            {
                                $("#if1").hide();
                                $("#if2").show();
                                $("#if3").hide();
                                $("#if4").show();
                                
                            }

                            if (isMobile.iOS()){
                             //   $(".removeadlink a").attr("href", "https://www.patreon.com/02ws");
                             //   $(".removeadlink a").attr("target", "_blank");

                            }
                            if (isMobile.iOS()||(isMobile.Android()&&!isMobile.AndroidWV()))
                            {
                                 $('#mobile_redirect').show();
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
                loadCSS("css/sunrise.min.css", document.getElementById('loadGA'));
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
        if ((tempunit == '°Fnull')||(tempunit == '°F'))
            tempunit = 'F';
        else if (tempunit.indexOf("C") > 0)
            tempunit = 'C';
        $('#date').html(json.jws.current.date<?=$lang_idx?>);
        
        var latestalerttext = decodeURIComponent(json.jws.Messages.latestalert<?=$lang_idx?>).replace(/\+/g, ' ');
        var latest_user_pic = "<a href=\"<?=$_SERVER['SCRIPT_NAME']?>?section=userPics.php&amp;lang=<?=$lang_idx."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c'];?>\"><img src=\"" +  json.jws.LatestUserPic[0].picname + "\" width=\"320\" title=\"userpic\" /></br>" + decodeURIComponent(json.jws.LatestUserPic[0].name.replace(/\+/g, " ")) + ": " + decodeURIComponent(json.jws.LatestUserPic[0].comment.replace(/\+/g, " ")) + "</a>&nbsp;&nbsp;";      
        var latest_pic_of_the_day = "<div class=\"txtindiv\"><?=$PIC_OF_THE_DAY[$lang_idx]?>" + "<br/>" + decodeURIComponent(json.jws.LatestPicOfTheDay.caption<?=$lang_idx?>.replace(/\+/g, " ")) + "</div><a href=\"<?=$_SERVER['SCRIPT_NAME']?>?section=picoftheday.php&amp;lang=<?=$lang_idx."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c'];?>\"><img src=\"" +  json.jws.LatestPicOfTheDay.picurl + "\" width=\"320\" title=\"pic of the day\" /></a>";
        var latest_pic_of_the_day_text = "<a href=\"javascript:void(0)\" class=\"info\" ><div class=\"title\">" + decodeURIComponent(json.jws.LatestPicOfTheDay.caption<?=$lang_idx?>.replace(/\+/g, " ")).substring(0, 30) + '<? echo get_arrow();?>' + "</div>" + "<span class=\"info\"> <div class=\"\"><?=$PIC_OF_THE_DAY[$lang_idx]?>: " + decodeURIComponent(json.jws.LatestPicOfTheDay.caption<?=$lang_idx?>.replace(/\+/g, " ")) + "</div><img src=\"" +  json.jws.LatestPicOfTheDay.picurl + "\" width=\"320\" title=\"pic of the day\" /></span></a>";
        var latest_tip_of_the_day = "<a href=\"javascript:void(0)\" class=\"info\" ><div class=\"title\">" + decodeURIComponent(json.jws.Messages.tip<?=$lang_idx?>.replace(/\+/g, " ")).substring(0, 30) + '<? echo get_arrow();?>' + "</div>" + "<span class=\"info\"> <div class=\"inv_plain_3_zebra\">" + decodeURIComponent(json.jws.Messages.tip<?=$lang_idx?>.replace(/\+/g, " ")) + "</div></span></a>";
        var lastindex = 81;
        var lastindexoftime = 9;
        var lastindexplainmode = 30;
        var containsanchor = latestalerttext.indexOf("<a");
        var containstitle = latestalerttext.indexOf("\n", lastindexoftime);
        var containsalert = latestalerttext.indexOf("alerttxt");
        lastindex = (containsalert > 0) ? lastindex : lastindexplainmode;
        partialtextlastindex = (containsanchor > 0) ? containsanchor - 1 : lastindex;
        partialtextlastindex = (containstitle > 0) ? (latestalerttext.indexOf("\n", containstitle) + 2) : partialtextlastindex;
        //partialtextlastindex = Math.min(partialtextlastindex, lastindex);
        partialtext = latestalerttext.substring(0, partialtextlastindex);
        if ((latestalerttext.length > partialtextlastindex))
            latestalerttext = "<a href=\"javascript:void(0)\" class=\"info\" >" + latestalerttext.substring(0, partialtext.length-1) + "<div class=\"title\">" + '<? echo get_arrow();?>' + "</div>" + "<span class=\"info\"> " + latestalerttext.replace(/(\r\n|\r|\n)/g, '<br/>') + "</span></a>";

        $('#messages_box').children('.box_text').html(decodeURIComponent(json.jws.Messages.addonalert<?=$lang_idx?>+json.jws.Messages.latestalert<?=$lang_idx?>+json.jws.Messages.detailedforecast<?=$lang_idx?>).replace(/\+/g, ' ').replace(/(\r\n|\r|\n)/g, '<br/>'));
        $('#tempdivvalue, #tempdivvaluestart').html('<div class="shade">' + ((json.jws.current.islight == 1) ? "" : "") + '</div>' + c_or_f(json.jws.current.temp, tempunit)+'<div class="param">'+tempunit+'</div>');
        $('#tempdivvalue').css('visibility', 'visible');
        $('#tempdivvaluestart').fadeIn(30);
        var ttl = (json.jws.Messages.latestalertttl == 0) ? 180*60 : json.jws.Messages.latestalertttl;

        if (json.jws.Messages.passedts < (ttl)){
             $('#latestalert').html(latestalerttext);
        }
        else if (json.jws.LatestPicOfTheDay.passedts < 7200){
            $('#latestalert').html(latest_pic_of_the_day_text);
        }
        else if (json.jws.sigForecastCalc.length > 0){
            $('#latestalert').html(json.jws.sigForecastCalc[0].sigtitle<? echo $lang_idx;?>+
                                 '&nbsp;<div class=\"invhigh\">&nbsp;' + 
                                  ((json.jws.sigForecastCalc.length > 1) ? json.jws.sigForecastCalc.length : "") + 
                                         '&nbsp;</div>');
        }
        else{
            $('#latestalert').html(latest_tip_of_the_day);
        }
        
        if (json.jws.LatestUserPic.passedts < 7200){
           $('#latest_user_pic').html(latest_user_pic);
        }
        if (json.jws.LatestPicOfTheDay.passedts < 9600){
            $('#latest_picoftheday').html(latest_pic_of_the_day);
        }
        $('#windy, #windystart').html(json.jws.windstatus.lang<? echo $lang_idx;?>);
      
       var cur_feel_link=document.getElementById('current_feeling_link');
       if (typeof coldmeter_size == 'undefined') 
                coldmeter_size = 40;
         if (cur_feel_link)
         {
            $(".loading").show();
            fetch("<?=BASE_URL?>/coldmeter_service.php?lang="+<? echo $lang_idx;?> + "&json=1")
                .then(response => response.json())
                .then(data => loadPostData(data, coldmeter_size))
                .catch(error => console.log("error:" + error))
        } else loadPostData();
        
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
        else if (json.jws.feelslike.state == "thw")
        {$("#itfeels_thw").show();$("#itfeels_thw .value").html(c_or_f(json.jws.feelslike.value, tempunit) + "")}
        if (json.jws.states.sigweather.length > 1)
        $('#what_is_h, #what_is_h_start ').html(json.jws.states.sigweather[0].sigtitle<? echo $lang_idx;?> +
                                 '&nbsp;<div class=\"invhigh\">&nbsp;' + 
                                  (json.jws.states.sigweather.length - 1) + 
                                  '&nbsp;</div>'
                                   + '<div class="rainpercent">' + (json.jws.current.rainchance > 0 ? (json.jws.current.rainchance + '%') : '') + '</div>');
      
        //$('#what_is_h').css('visibility', 'visible');                          
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
        $("#latesttemp .paramvalue").html(c_or_f(json.jws.current.temp, tempunit)+'<div class="param">'+tempunit+'</div>' + '&nbsp;<span id=\"valleytemp\" title=\"\">'+ title_temp + '</span>');
        $("#latesttemp .highlows .highparam").html('<strong>' + c_or_f(json.jws.today.hightemp, tempunit) + '</strong>');
        $("#latesttemp .highlows .high_time").html(json.jws.today.hightemp_time);
        $("#latesttemp .highlows .lowparam").html('<strong>' + c_or_f(json.jws.today.lowtemp, tempunit) + '</strong>');
        $("#latesttemp .highlows .low_time").html(json.jws.today.lowtemp_time);
        $("#latesttemp .trendstable .trendsvalues .innertrendvalue").eq(0).html(json.jws.yestsametime.tempchange.split(",")[2]);
        $("#latesttemp .trendstable .trendsvalues .innertrendvalue").eq(1).html(json.jws.oneHour.tempchange.split(",")[2]);
        $("#latesttemp .trendstable .trendsvalues .innertrendvalue").eq(2).html(json.jws.min30.tempchange.split(",")[2]);
        $("#latesttemp .paramtrend .innertrendvalue").html(json.jws.min15.minutes + " " + "<?=$MINTS[$lang_idx]?>: " + json.jws.min15.tempchange.split(",")[2]);
        $("#latesttemp2 .paramvalue").html(c_or_f(json.jws.current.temp2, tempunit)+'<div class="param">'+tempunit+'</div>' + '&nbsp;<span id=\"valleytemp\" title=\"\">'+ title_temp2 + '</span>');
        $("#latesttemp2 .highlows .highparam").html('<strong>' + c_or_f(json.jws.today.hightemp2, tempunit) + '</strong>');
        $("#latesttemp2 .highlows .high_time").html(json.jws.today.hightemp2_time);
        $("#latesttemp2 .highlows .lowparam").html('<strong>' + c_or_f(json.jws.today.lowtemp2, tempunit) + '</strong>');
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
        $("#latestradiation .trendstable .trendsvalues .innertrendvalue").eq(2).html(json.jws.min15.srchange.split(",")[2]);
        $("#latestradiation .paramtrend .innertrendvalue").html("<strong><?=$RISE[$lang_idx]?>:</strong> " + json.jws.today.sunrise + " <strong><?=$SET[$lang_idx]?>:</strong> " +  json.jws.today.sunset + "<br />" + json.jws.today.sunshinehours + " <?=$SUNSHINEHOURS[$lang_idx]?>" + "  <?=$TILL_NOW[$lang_idx]?>");
       
        $("#latesttemp3 .paramvalue").html(c_or_f(json.jws.current.temp3, tempunit)+'<div class="param">'+tempunit+'</div>' + '&nbsp;<span id=\"valleytemp\" title=\"\">' + title_temp3 + '</span>');
        $("#latesttemp3 .highlows .highparam").html('<strong>' + c_or_f(json.jws.today.hightemp3, tempunit) + '</strong>');
        $("#latesttemp3 .highlows .high_time").html(json.jws.today.hightemp3_time);
        $("#latesttemp3 .highlows .lowparam").html('<strong>' + c_or_f(json.jws.today.lowtemp3, tempunit) + '</strong>');
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
        $("#latestwind .paramvalue").html("<div id=\"winddir\" class=\"paramunit\"><div class=\"winddir\"></div></div><div id=\"windspeed\">" + json.jws.current.windspd + " <div class=\"param\"><?=$WIND_UNIT[$lang_idx]?></div></div>");
        $("#latestwind .winddir").addClass(json.jws.current.winddir);
        $("#latestwind .highlows .highparam").html('<strong>' + json.jws.today.highwind + '</strong>');
        $("#latestwind .highlows .high_time").html(json.jws.today.highwind_time);
        $("#latestwind .paramtrend div").html("10 <?=$MINTS[$lang_idx]." ".$AVERAGE[$lang_idx]?> : <strong>" + json.jws.current.windspd10min + '</strong>' + ' <?=$WIND_UNIT[$lang_idx]?> ');
        $("#latestrain .highlows .highparam").html('<strong>'+ json.jws.today.highrainrate + '</strong>');
        $("#latestrain .highlows .high_time").html(json.jws.today.highrainrate_time);
        $("#latestrain .trendstable .trendsvalues .innertrendvalue").eq(0).html(json.jws.oneHour.rainratechange.split(",")[2]);
        $("#latestrain .trendstable .trendsvalues .innertrendvalue").eq(1).html(json.jws.min30.rainratechange.split(",")[2]);
        $("#latestrain .trendstable .trendsvalues .innertrendvalue").eq(2).html(json.jws.min15.rainratechange.split(",")[2]);
        $("#latestrain .paramvalue").html(json.jws.current.rainrate+'<siv class="param">' + " <?=$RAINRATE_UNIT[$lang_idx]?>" +'</siv>');
        $("#latestrain .paramtrend").html("<?=$DAILY_RAIN[$lang_idx]?>:&nbsp;" + json.jws.today.rain + " " + "&nbsp;&nbsp;<?=$SYSTEM[$lang_idx]?>:&nbsp;" + json.jws.storm.rain + "<br/><?=$TOTAL_RAIN[$lang_idx]?>:&nbsp;" + json.jws.seasonTillNow.rain + " <?=$RAIN_UNIT[$lang_idx]?>");
        $("#latestairq #aqvalues").html("<ul><li class=\"line\"><ul><li></li><li></li><li class=\"dustexp\"><?=$DUST_THRESHOLD1[$lang_idx]?></li><li class=\"dustexp\"><?=$DUST_THRESHOLD2[$lang_idx]?></li></ul></li>" +
                             "<li class=\"line\" title=\"&plusmn;"+json.jws.current.pm10sd+"\"><ul><li class=\"dusttitle\"><?=$DUSTPM10[$lang_idx]?></li><li><span class=\"number\">" + json.jws.current.pm10 + "</span>&nbsp;<span class=\"small\">µg/m3</span></li><li>+130</li><li>+300</li></ul></li>" +
                             "<li class=\"line\" title=\"&plusmn;"+json.jws.current.pm25sd+"\"><ul><li class=\"dusttitle\"><?=$DUSTPM25[$lang_idx]?></li><li><span class=\"number\">" + json.jws.current.pm25 + "</span>&nbsp;<span class=\"small\">µg/m3</span></li><li>+38</li><li>+100</li></ul></li>" +
                             "<li ><?=$DUST_THRESHOLD3[$lang_idx]?></li>" +
                             "</ul>");
               
        $("#latestairq .trendstable .trendsvalues .innertrendvalue").eq(0).html(json.jws.yestsametime.pm10change.split(",")[2]);
        $("#latestairq .trendstable .trendsvalues .innertrendvalue").eq(1).html(json.jws.oneHour.pm10change.split(",")[2]);
        $("#latestairq .trendstable .trendsvalues .innertrendvalue").eq(2).html(json.jws.min30.pm10change.split(",")[2]);
        $("#latestuv .paramvalue").html(json.jws.current.uv);
        $("#latestuv .highlows .highparam").html('<strong>' + json.jws.today.highuv + '</strong>');
        $("#latestuv .highlows .high_time").html(json.jws.today.highuv_time);
        $("#latestuv .trendstable .trendsvalues .innertrendvalue").eq(0).html(json.jws.yestsametime.uvchange.split(",")[2]);
        $("#latestuv .trendstable .trendsvalues .innertrendvalue").eq(1).html(json.jws.oneHour.uvchange.split(",")[2]);
        $("#latestuv .trendstable .trendsvalues .innertrendvalue").eq(2).html(json.jws.min30.uvchange.split(",")[2]);
        $("#window_btn").addClass(json.jws.states.window_class);
        $("#latestwindow .paramtitle").html(json.jws.states.windowtitle<?=$lang_idx?>);
        $("#latestwindow .highlows").html(json.jws.states.windowdesc<?=$lang_idx?>);
        $('#what_is_h, #what_is_h_start').click(function() {
            $('#sigweather').show();
        });
        for (i = 0; i< 4; i++){ 
        $('#shortforecast').children('.nav').children().eq(i).html(json.jws.forecastDays[i].day_name<?=$lang_idx?>+"  "+json.jws.forecastDays[i].date+"</br>"+"<img src=\"" + json.jws.forecastDays[i].icon + "\" onclick=\"showNextDays()\" width=\"32\" height=\"32\" alt=\"" + json.jws.forecastDays[i].icon +"\" /></br>"+c_or_f(json.jws.forecastDays[i].TempLow, tempunit)+" - "+c_or_f(json.jws.forecastDays[i].TempHigh, tempunit));
        }
        var sigweatherstates = "";
        sigweatherstates += "<li><button type=\"button\" id=\"xClose\" style=\"background-image: url(../img/close.png); border: none;height: 32px;width: 32px;left: 5px;position: absolute;top: 5px\" onclick=\"$( '#sigweather' ).hide();\"></button></li>";
        for (i = 0; i< json.jws.states.sigweather.length; i++){
            sigweatherstates += "<li><a href=\"" + json.jws.states.sigweather[i].url + "\" >" + json.jws.states.sigweather[i].sigtitle<?=$lang_idx?> + " - " +  json.jws.states.sigweather[i].sigexthtml<?=$lang_idx?> + '<? echo get_arrow();?>' + "</a></li>";
        }
        $('#sigweather').html(sigweatherstates);
        var forecaststates = "";
        forecaststates += "<li><button type=\"button\" id=\"xClose\" style=\"background-image: url(../img/close.png); border: none;height: 32px;width: 32px;left: 5px;position: absolute;top: 5px\" onclick=\"$( '#sigweather' ).hide();\"></button></li>";
        for (i = 0; i< json.jws.sigForecastCalc.length; i++){
            forecaststates += "<li>" + json.jws.sigForecastCalc[i].sigtitle<?=$lang_idx?> + " - " +  json.jws.sigForecastCalc[i].sigexthtml<?=$lang_idx?> + "</a></li>";
        }
        $('#forecaststates').html(forecaststates);
        var forecastHours = "";
        for (i = 0; i< json.jws.sigforecastHours.length; i++){
       
           forecastHours += "<ul class=\"forecasttimebox nav\" >";
           forecastHours += "<li class=\"tsfh currentts\" style=\"display:none\"><span>" + json.jws.sigforecastHours[i].currentDateTime + "</span></li>";
           forecastHours += "<li class=\"tsfh text timefh\"><span>" + json.jws.sigforecastHours[i].date + "</span></li>";
           forecastHours += "<li class=\"tsfh forecasttemp timefh\"><span>" + json.jws.sigforecastHours[i].time + ":00" + (json.jws.sigforecastHours[i].plusminus > 0 ? "&nbsp;&plusmn;"+json.jws.sigforecastHours[i].plusminus : "") +"</span></li>";
           //forecastHours += "<li class=\"forecasttemp\" id=\"tempfh"+ json.jws.sigforecastHours[i].time + "\"><span>" + c_or_f(json.jws.sigforecastHours[i].temp, tempunit) + "<img style=\"vertical-align: middle\" src=\"images/clothes/"+json.jws.sigforecastHours[i].cloth+"\" height=\"15\" width=\"20\" /></span></li>";
           forecastHours += "<li style=\"padding:0;\"><div title=\"" + json.jws.sigforecastHours[i].wind_title<? echo $lang_idx;?>+"\" class=\"wind_icon "+json.jws.sigforecastHours[i].wind_class+" \"></div></li>";
           forecastHours += "<li class=\"forcast_icon\"><span><img src=\"images/icons/day/"+json.jws.sigforecastHours[i].icon+"\" height=\"30\" width=\"30\" /></span></li>";
           forecastHours += "<li class=\"forcast_title\"><span>"+json.jws.sigforecastHours[i].title<? echo $lang_idx;?>+"</span></li>";
           forecastHours += "</ul>";
       }
       
       var forecastHoursD = "";
       var forecastHoursNG = "";
       var max_temp = -10; var min_temp = 110;
       var max_hum = -10; var min_hum = 110;
        for (i = 0; i< json.jws.forecastHours.length; i++){
        if (i >= json.jws.states.nowHourIndex){
            if (parseInt(json.jws.forecastHours[i].temp) > max_temp) max_temp = json.jws.forecastHours[i].temp; 
            if (parseInt(json.jws.forecastHours[i].temp) < min_temp) min_temp = json.jws.forecastHours[i].temp;
            if (json.jws.forecastHours[i].hum > max_hum) max_hum = json.jws.forecastHours[i].hum; 
            if (json.jws.forecastHours[i].hum < min_hum) min_hum = json.jws.forecastHours[i].hum;
            if ((json.jws.forecastHours[i].time % 3 == 0) || (json.jws.forecastHours[i].plusminus > 0))
            {
                var  TempCloth = '&nbsp;<a href=\"javascript:void(0)\" class=\"info\" ><img style=\"vertical-align: middle\" src=\"'+json.jws.forecastHours[i].cloth+'\" width=\"20\" height=\"15\" title=\"'+json.jws.forecastHours[i].cloth_title<? echo $lang_idx;?>+'\" alt=\"\" /><span class=\"info\">'+json.jws.forecastHours[i].cloth_title<? echo $lang_idx;?>+'</span></a>';
                forecastHoursD += "<li class=\"forecasttimebox nav \" index=\"" + i + "\" ><ul>";
                forecastHoursD += "<li class=\"plus\"><div class=\"open-close-button\" index=\"" + i + "\"></div></li>";
                forecastHoursD += "<li class=\"tsfh currentts text\" style=\"display:none\"><span>" + json.jws.forecastHours[i].currentDateTime + "</span></li>";
                var strDate = json.jws.forecastHours[i].time + ":00" + (json.jws.forecastHours[i].plusminus > 0 ? "&nbsp;&plusmn;"+json.jws.forecastHours[i].plusminus : "");
                if (json.jws.forecastHours[i].time == 0)
                        strDate = json.jws.forecastHours[i].day<? echo $lang_idx;?>;
                forecastHoursD += "<li class=\"tsfh text timefh \"><span>" + strDate + "</span></li>";
                //forecastHoursD += "<li class=\"timefh forcast_time\"><span>" + json.jws.forecastHours[i].time + ":00" + (json.jws.forecastHours[i].plusminus > 0 ? "&nbsp;&plusmn;"+json.jws.forecastHours[i].plusminus : "") +"</span></li>";
                forecastHoursD += "<li class=\"tsfh forecasttemp\" id=\"tempfh"+ json.jws.forecastHours[i].time + "\"><div class=\"number\">" + c_or_f(json.jws.forecastHours[i].temp, tempunit) + "" +TempCloth + "</div></li>";
                forecastHoursD += "<li class=\"wind\" style=\"padding:0;\"><div title=\"" + json.jws.forecastHours[i].wind_title<? echo $lang_idx;?>+"\" class=\"wind_icon "+json.jws.forecastHours[i].wind_class+" \"></div><div class=\"humidity extra"+i+"\"><?=$HUMIDITY[$lang_idx]?>" + "  " +json.jws.forecastHours[i].hum+"%</div></li>";
                forecastHoursD += "<li class=\"forcast_icon\"><span><img src=\"images/icons/day/"+json.jws.forecastHours[i].icon+"\" height=\"30\" width=\"30\" /></span></li>";
                forecastHoursD += "<li class=\"forcast_title text\"><span>"+json.jws.forecastHours[i].title<? echo $lang_idx;?>+"</span></li>";
                forecastHoursD += "</ul></li>";
                
            }
        }
        
       if (i == 4) {
               // forecastHoursD += "<ul class=\"nav \" ><li style=\"padding:0 10px 0 0\"><a style=\"text-decoration:none\" href=\"https://www.jerusalemoutoftheframe.com/graffiti/?fbclid=IwAR0GUeawNnjlWbFA5GkSEbEHL42jRW-0Hn-inyKlAOV73KRx2TF_lnPOFx8\" target=_blank >סיור גרפיטי ״50 גוונים של ירושלים״ <?=get_arrow();?> כאן</a></li></ul>  ";
        
        }
       }
       var prev_wind, bottom, tempclass, addonclass;
       for (i = 0; i< json.jws.forecastHours.length; i++){
        if (i >= json.jws.states.nowHourIndex)
        {
            forecastHoursNG += "<li class=\"x-axis-bar-item\">";
            toptime =  (json.jws.forecastHours[i].time % 4 == 0) ? json.jws.forecastHours[i].day<?=$lang_idx;?>+"&nbsp;"+json.jws.forecastHours[i].time+":00" : json.jws.forecastHours[i].time + ":00";
            forecastHoursNG += "<div class=\"x-axis-bar-item-container\" onclick=\"showcircleperhour('"+toptime+"','"+json.jws.forecastHours[i].icon+"',"+ json.jws.forecastHours[i].temp+","+json.jws.forecastHours[i].wind+",'"+json.jws.forecastHours[i].cloth.substring(json.jws.forecastHours[i].cloth.split('/', 2).join('/').length)+"',"+json.jws.forecastHours[i].rain+","+json.jws.forecastHours[i].hum+")\">";
            forecastHoursNG += "<div class=\"x-axis-bar primary\" style=\"height: 100%\">"+toptime+"</div>";    
            bottom = 88;
            forecastHoursNG += "<div class=\"x-axis-bar tertiary icon\" style=\"height: "+ bottom +"%;\"><img style=\"vertical-align: middle\" src=\"images/icons/day/"+json.jws.forecastHours[i].icon+"\" height=\"25\" width=\"28\" alt=\""+json.jws.forecastHours[i].icon+"\" /></div>";
            bottom = ((json.jws.forecastHours[i].temp-min_temp)*78)/(max_temp - min_temp);
            if (bottom < 10) bottom = 15;
            else if (bottom < 20) bottom = bottom + 3;
            else if (bottom > 60) addonclass = "uppervalue"; else addonclass = "";
            tempclass = (i % 2 == 0) ? "secondary" : "secondaryalt";
            forecastHoursNG += "<div class=\"x-axis-bar "+ tempclass + " " + addonclass+" temp\" style=\"height: "+bottom+"%;\"><span class=\"span-value\" data-value=\""+ json.jws.forecastHours[i].temp +"° "+json.jws.forecastHours[i].hum+"%\">"+ c_or_f(json.jws.forecastHours[i].temp, tempunit) + "°</span></div>";
            forecastHoursNG += "<div class=\"x-axis-bar tertiary cloth icon "+ addonclass + "\" style=\"display:none;height: "+ bottom +"%;\"><span class=\"span-value "+ addonclass + "\" data-value=\"" + json.jws.forecastHours[i].cloth_title<?=$lang_idx;?> +  "\"><img style=\"vertical-align: middle\" src=\""+json.jws.forecastHours[i].cloth+"\" height=\"30\" width=\"30\" /></span></div>";
            bottom = 40;
            if (json.jws.forecastHours[i].plusminus > 0)
                forecastHoursNG += "<div class=\"x-axis-bar tertiary\" style=\"height: "+ bottom +"%;\"><span class=\"span-value\" data-value=\""+"&nbsp;&plusmn;"+json.jws.forecastHours[i].plusminus+"\"></span></div>";
            bottom = 75;
            if (i == json.jws.states.nowHourIndex || (json.jws.forecastHours[i].wind != prev_wind))
                forecastHoursNG += "<div class=\"x-axis-bar tertiary wind\" style=\"height: "+ bottom +"%;\"><div title=\""+json.jws.forecastHours[i].wind_title<? echo $lang_idx;?>+"\" class=\"wind_icon "+json.jws.forecastHours[i].wind_class+" \"></div></div>";
            bottom = json.jws.forecastHours[i].rain;
            if (bottom > 0)
                forecastHoursNG += "<div class=\"x-axis-bar tertiary rain\" style=\"display:none;height: "+ bottom +"%;\"><span class=\"span-value\" data-value=\"\">"+json.jws.forecastHours[i].rain+"%</span></div>";
            bottom = json.jws.forecastHours[i].hum;
            forecastHoursNG += "<div class=\"x-axis-bar tertiary humidity\" style=\"display:none;height: "+ (bottom-5) +"%;\"><span class=\"span-value\" data-value=\"<?=$HUMIDITY[$lang_idx]?>\">"+json.jws.forecastHours[i].hum+"%</span></div>";
            forecastHoursNG += "</div>";
            forecastHoursNG += "</li>";
            prev_wind = json.jws.forecastHours[i].wind;
        }
       }
       //$('#for24_given').html('<? echo $GIVEN[$lang_idx]." ".$AT[$lang_idx]." ";?>' + json.jws.TAF.timetaf + ':00 ' + json.jws.TAF.dayF + '/' + json.jws.TAF.monthF + '/' + json.jws.TAF.yearF);
       $('#for24_hours_s').html(forecastHours);
       $('#for24_graph_ng').html(forecastHoursNG);
       $('#forcast_hours_table').html(forecastHoursD);
       $('#for24_hours').html(forecastHours);
       
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
       link_for_yest = "<a id=\"linkyesterday\" hrf=\"javascript:void(0)\" onclick=\"$('#yesterday_line').show();\"><img src=\"images/yesterday.png\" width=\"14\" height=\"14\" title=\"<?=$LAST_DAY[$lang_idx]?>\" /></a>";
       forecastDays += "<td></td><td id=\"plus\">" + link_for_yest + "</td>";
       forecastDays += "<td id=\"morning\"><a href=\"javascript:void(0)\" class=\"info\" ><img src=\"../img/morning_icon.png\" width=\"30\" /><span class=\"info\">" + json.jws.desc.early_morning<? echo $lang_idx;?> + "</span></a></td>";
       forecastDays += "<td id=\"noon\"><a href=\"javascript:void(0)\" class=\"info\" ><img src=\"../img/noon_icon.png\" width=\"18\" /><span class=\"info\">" + json.jws.desc.noon<? echo $lang_idx;?> + "</span></a></td>";
       forecastDays += "<td id=\"night\"><a href=\"javascript:void(0)\" class=\"info\" ><img src=\"../img/night_icon.png\" width=\"18\" /><span class=\"info\">" + json.jws.desc.night_temp_exp<? echo $lang_idx;?> + "</span></a></td>";
       forecastDays += "<td></td>";
       forecastDays += "<td></td>";
       forecastDays += "</tr>";
       forecastDays += "<tr id=\"yesterday_line\" style=\"display:none\">";
       forecastDays += "<td class=\"tsfh\" style=\"text-align:center;\">" + date_value + "</td><td></td>";
       forecastDays += "<td class=\"tsforecastDaysfh\"><div class=\"number\">" + c_or_f(morning_value, tempunit) + "</div></td>";
       forecastDays += "<td class=\"tsfh\">" + c_or_f(noon_value, tempunit) +"</td>";
       forecastDays += "<td class=\"tsfh\">" + c_or_f(night_value, tempunit) + "</td>";
       forecastDays += "<td></td>";
       forecastDays += "<td></td>";
       forecastDays += "</tr>";
        for (i = 0; i< json.jws.forecastDays.length; i++){
            TempLowClothfull = '<div class=\"cloth extra' + i + '\"><a href=\"javascript:void(0)\" class=\"info\" ><img style=\"vertical-align: middle\" src=\"'+json.jws.forecastDays[i].TempLowCloth+'\" width=\"20\" height=\"20\" title=\"'+json.jws.forecastDays[i].TempLowClothTitle<? echo $lang_idx;?>+'\" alt=\"\" /><span class=\"info\">'+json.jws.forecastDays[i].TempLowClothTitle<? echo $lang_idx;?>+'</span></a></div>';
            TempHighClothfull = '<div class=\"cloth extra' + i + '\"><a href=\"javascript:void(0)\" class=\"info\" ><img style=\"vertical-align: middle\" src=\"'+json.jws.forecastDays[i].TempHighCloth+'\" width=\"20\" height=\"20\" title=\"'+json.jws.forecastDays[i].TempHighClothTitle<? echo $lang_idx;?>+'\" alt=\"\" /><span class=\"info\">'+json.jws.forecastDays[i].TempHighClothTitle<? echo $lang_idx;?>+'</span></a></div>';
            TempNightClothfull = '<div class=\"cloth extra' + i + '\"><a href=\"javascript:void(0)\" class=\"info\" ><img style=\"vertical-align: middle\" src=\"'+json.jws.forecastDays[i].TempNightCloth+'\" width=\"20\" height=\"20\" title=\"'+json.jws.forecastDays[i].TempNightClothTitle<? echo $lang_idx;?>+'\" alt=\"\" /><span class=\"info\">'+json.jws.forecastDays[i].TempNightClothTitle<? echo $lang_idx;?>+'</span></a></div>';
        
            TempLowCloth = "";
            TempHighCloth = "";
            TempNightCloth = "";
            if ((get_cloth)&&(get_cloth == 1)){
                TempLowCloth = TempLowClothfull;
                TempHighCloth = TempHighClothfull;
                TempNightCloth = TempNightClothfull;
            }
            <? if (isHeb()) {?>
             if (i == 4) {
                //forecastDays += "<tr class=\"adunit\"><td colspan=\"6\" style=\"padding:0 8px 0 0\"><a style=\"text-decoration:none\" href=\"https://headstart.co.il/project/63080\" target=_blank >יש! אפליקציה חדשה לירושמיים<?=get_arrow();?></a></td></tr>  ";
                            }
                            <?}?>
             forecastDays += "<tr>";
             forecastDays += "<td class=\"date\" >"  + json.jws.forecastDays[i].day_name<?=$lang_idx?> + "<div class=\"datetext\">" + json.jws.forecastDays[i].date + "<div></td><td class=\"plus\">" + "<div index=\"" + i + "\" id=\"" + i + "\" class='open-close-button'></div>" + "</td>";
            forecastDays += "<td class=\"tsfh\"><div class=\"number\">" + c_or_f(json.jws.forecastDays[i].TempLow, tempunit) + TempLowCloth +  "</div><div class=\"icon extra" + i + "\"><div class=\"humidity\">" + json.jws.forecastDays[i].humMorning + "%</div></div>" + "<div class=\"icon extra" + i + "\" id=\"morning_icon" + i + "\">" + TempLowClothfull + "<a href=\"legend.php\" rel=\"external\"><img src=\"" + json.jws.forecastDays[i].morning_icon + "\" width=\"28\" height=\"28\" alt=\"" + json.jws.forecastDays[i].morning_icon +"\" /></a></div><div class=\"icon extra" + i + "\"><div class=\"wind_icon " + json.jws.forecastDays[i].windMorning + "\">" + json.jws.forecastDays[i].windMorningSpd + " <span class=\"param\"><?=$WIND_UNIT[$lang_idx]?></span></div></div></td>";
            forecastDays += "<td class=\"tsfh\"><div class=\"number\">" + c_or_f(json.jws.forecastDays[i].TempHigh, tempunit) + TempHighCloth + "</div><div class=\"icon extra" + i + "\"><div class=\"humidity\">" + json.jws.forecastDays[i].humDay +"%</div></div>" + "<div class=\"icon extra" + i + "\" id=\"day_icon" + i + "\">" + TempHighClothfull + "<a href=\"legend.php\" rel=\"external\"><img src=\"" + json.jws.forecastDays[i].icon + "\" width=\"28\" height=\"28\" alt=\"" + json.jws.forecastDays[i].icon +"\" /></a></div><div class=\"icon extra" + i + "\"><div class=\"wind_icon " + json.jws.forecastDays[i].windDay + "\">" + json.jws.forecastDays[i].windDaySpd + " <span class=\"param\"><?=$WIND_UNIT[$lang_idx]?></span></div></div></td>";
            forecastDays += "<td class=\"tsfh\"><div class=\"number\">" + c_or_f(json.jws.forecastDays[i].TempNight, tempunit) + TempNightCloth + "</div><div class=\"icon extra" + i + "\"><div class=\"humidity\">" + json.jws.forecastDays[i].humNight +"%</div></div>" + "<div class=\"icon extra" + i + "\" id=\"night_icon" + i + "\">" + TempNightClothfull + "<a href=\"legend.php\" rel=\"external\"><img src=\"" + json.jws.forecastDays[i].night_icon + "\" width=\"28\" height=\"28\" alt=\"" + json.jws.forecastDays[i].night_icon +"\" /></a></div><div class=\"icon extra" + i + "\"><div class=\"wind_icon " + json.jws.forecastDays[i].windNight + "\">" + json.jws.forecastDays[i].windNightSpd + " <span class=\"param\"><?=$WIND_UNIT[$lang_idx]?></span></div></div></td>";
            forecastDays += "<td class=\"forcast_each icon_day\" >";
            if (i==0)
                forecastDays += noon_value_change;
            if (json.jws.forecastDays[i].windDay == "high_wind")
                wind_extra = "<div class=\"wind_icon high_wind\"></div>";
            else
                wind_extra = "";                        
            forecastDays += "<span class=\"icon extra" + i + "\" id=\"icon" + i + "\">" + wind_extra + "<img src=\"" + json.jws.forecastDays[i].icon + "\" width=\"34\" height=\"34\" alt=\"" + json.jws.forecastDays[i].icon +"\" /></span><div class=\"tsfh\"><div class=\"humidity icon extra" + i + "\"><a href=\"<?=BASE_URL?>/dailydetailed.php?m=1&dayid=" + (i+1) + "\" rel=\"external\" ><img src=\"images/enlarge_64.png\" width=\"35\" alt=\"enlarge\"/></a></div></div>"+"</td>";
            fulltextforecast = json.jws.forecastDays[i].lang<? echo $lang_idx;?>;
            containsanchor = fulltextforecast.indexOf("<a");
            partialtextlastindex = (containsanchor > 0) ? containsanchor - 1 : lastindex;
            partialtext = fulltextforecast.substring(0, partialtextlastindex);
            if ((fulltextforecast.length > lastindex)&&!(containsanchor > 0))
                textforecast = "<span class=\"extra" + i + "\">" + fulltextforecast.substring(0, partialtext.lastIndexOf(" ")) + '<? echo get_arrow();?>' + "</span>";
            else
                textforecast = "<span class=\"extra" + i + "\">" + fulltextforecast + "</span>";
            var get_fullt = '<?=$_GET['fullt']?>';
            if ((get_fullt)&&(get_fullt > 0)){
                textforecast = fulltextforecast;
                textforecastwidth = "130px";
            }
            forecastDays += "<td class=\"text\" ><span class=\"extra" + i + " fulltext\">" + fulltextforecast + "</span>" +  textforecast +"</td>";
            forecastDays += "</tr>";
       }
       forecastDays += "<tr><td style=\"text-align:center\">" + json.jws.desc.month_in_word<?=$lang_idx?> + " <?=$AVERAGE[$lang_idx]?></td><td></td><td class=\"tsfh average\" style=\"text-align:center\">" + c_or_f(json.jws.thisMonth.lowtemp_av, tempunit) + "</td><td class=\"tsfh average\" style=\"text-align:center\">" + c_or_f(json.jws.thisMonth.hightemp_av, tempunit) + "</td><td></td><td></td><td></td></tr>";
       forecastDays += "</table>";
      
       if (json.jws.current.cloudiness > 1){
           $('#cloudiness4bg2').show();
          
       }
       if (json.jws.current.cloudiness > 3){
          $('#cloudiness4bg1').show();
           
      }
       if (json.jws.current.cloudiness > 5){
           $('#cloudiness8bg2').show();
           
       }
        $(".info_btns").show();
        $("#shortforecast").show();
       $('#logo').show();
       $('#startinfo_container').show();
       $('#livepic_box').show();
       $('#forecastnextdays_table').html(forecastDays);
       var cclass, sigRunWalkweatherstates = "";
       for (i = 1; i< json.jws.sigRunWalkweather.length; i++){
        if (i == 1) cclass = "class=\"windhumsituation\""; else cclass = "";  
            sigRunWalkweatherstates += "<li " + cclass + "><a href=\"" + json.jws.sigRunWalkweather[i].url + "\" >" + json.jws.sigRunWalkweather[i].sigtitle<?=$lang_idx?> + "  " +  json.jws.sigRunWalkweather[i].sigext<?=$lang_idx?> + '' + "</a></li>";
        }
        var firstlinerunwalk = "";
        if (json.jws.current.solarradiation < 50)
             firstlinerunwalk = "<li class=\"firstlinerunwalk\"><span class=\"number\">" +c_or_f(json.jws.current.temp2, tempunit) + '-' + c_or_f(json.jws.current.temp, tempunit)+'<div class="param">'+tempunit+'</div></span>' + '&nbsp;<span id=\"valleytemprunwalk\" title=\"\">'+ title_temp + '</span>' + '&nbsp;&nbsp;&nbsp;&nbsp;<span class=\"number\">' + c_or_f(json.jws.current.temp3, tempunit)+'<div class="param">'+tempunit+'</div></span>' + '&nbsp;<span id=\"mtemprunwalk\" title=\"\">'+ title_temp2 + '</span></li>';
        else
            firstlinerunwalk = "<li class=\"firstlinerunwalk\"><span class=\"number\">" + c_or_f(json.jws.current.temp, tempunit)+'<div class="param">'+tempunit+'</div></span>' + '&nbsp;<span id=\"valleytemprunwalk\" title=\"\">'+ title_temp + '</span>' + '&nbsp;&nbsp;&nbsp;&nbsp;<span class=\"number\">' + c_or_f(json.jws.current.temp2, tempunit)+'<div class="param">'+tempunit+'</div></span>' + '&nbsp;<span id=\"mtemprunwalk\" title=\"\">'+ title_temp2 + '</span></li><li class=\"itfeels\">' + $('#itfeels').html() + '</li>';
       $("#latestrunwalk .exp").html("<ul>"+firstlinerunwalk+sigRunWalkweatherstates+"</ul>");
       $('#alert_box_in_forecast').html($('#messages_box').html());
       $('#canvas').show();
        if ((json.jws.states.issnowing != 1) && (json.jws.states.israining == 1))    
       {$.getScript( "<?=BASE_URL?>/js/rain.js" );
           if (get_sound == 1){
               playSound();
           }
       }
       else if (json.jws.states.issnowing == 1)    
          {$.getScript( "<?=BASE_URL?>/js/snow.js" );};
      $("#now_btn").css("background-position", "right");
    }
    function navMain(tabcontainer, nodeid, dir){
        
        $('.now_title').removeClass('for_active');
        $('.for24h_title').removeClass('for_active');
        $('.fornextdays_title').removeClass('for_active');
        $('.alerts_title').removeClass('for_active');
        $('#forcast_hours_table').hide(0);
        $('#forcast_hours').hide(0);
        $('#forecastnextdays').hide(0);
        $('#currentinfo_container').hide(0);
        $('#startinfo_container').hide(0);
        $('#messages_box').hide(0);
        rememberCookie ('last_container', tabcontainer, 0.1);
        rememberCookie ('last_nodeid', nodeid, 0.1);
        $('.' + nodeid).addClass('for_active');
        if (current_tab == undefined){
           $('#' + tabcontainer).show(0);
        }
        else
           $('#' + tabcontainer).show(0);//fadeIn(500)
           if (tabcontainer == 'currentinfo_container'){
            //$('.dotstyle').hide();
            pageID = 5;
           // $('#' + 'dot_now').addClass('current');
        } 
        
        if (tabcontainer != 'startinfo_container'){
            
            if (!isUserAdApproved)
                {
                    $("#adunit1").css('visibility', 'visible').show();
                    if (('#adunit3').length)
                        $('#adunit3').show(0);
                    $('#adunit2').show(0);
                    if (should_show_startupdiv)
                        $("#startupdiv").show(0);
                    should_show_startupdiv = false;
                }
                else{
                    $('#adunit2').hide(0);
                    $('#adunit3').hide(0);  
                    $('#adsense_start').remove();
                }
        } else{
            
            //$('#startdot').addClass('active');
            //$('#adunit1').hide();
            //$('#adunit2').hide(0);
            //$('#adunit3').hide(0);
            $("#startupdiv").hide(0); 
            
        }
        current_tab = tabcontainer; 
        current_nideid = nodeid;
        $('#navbar').html($('#for_title').html()); 
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
    function getCookie(cookieName){for(var x=0;x<document.cookie.split("; ").length;x++){var oneCookie=document.cookie.split("; ")[x].split("=");if(oneCookie[0]==escape(cookieName)){return unescape(oneCookie[1]);}}
        return'';}
    function rememberCookie(cookieName,cookieValue, cookieLife){document.cookie=escape(cookieName)+'='+escape(cookieValue)+(cookieLife?';expires='+new Date((new Date()).getTime()+(cookieLife*86400000)).toGMTString():'')+';path=/';}
  
    function fillAllJson(jsonstr)
    {
      try{var json = JSON.parse(jsonstr);} catch (e) {alert('שגיאה, נסו מאוחר יותר');}
      try{loadData(json);} catch (e) {alert('שגיאה, נסו מאוחר יותר ' + e);}
      var last_container = getCookie('start_container');//or last_container
       var last_nodeid = getCookie('start_nodeid');//or last_nodeid
       if (last_container == ""){
        last_container = 'startinfo_container';
        last_nodeid = 'now_title';
        
       }
      <?if ($_REQUEST['section'] == "alerts.php") echo "last_container = 'messages_box';";?>
	   navMain(last_container, last_nodeid, 'none');
       if (last_container == 'startinfo_container')
            $('#currentinfo_container').show();
		$('#logo').show();
   }
   function showNextDays()
   {
      navMain('forecastnextdays', 'fornextdays', 'none');
      // $('#forecastnextdays').show();$('#forecast24h').hide();$('#fornextdays_title').addClass('for_active');$('#for24h_title').removeClass('for_active');
   }
   function showLoading()
   {
       $(".loading").show();
   }
   function addSickyToNavBar()
   {
    if (window.pageYOffset >= 72) {
       $('#navbar').show();
    } else {
       $('#navbar').hide();
    }
    
   }
   var should_show_startupdiv = false;
   var current_tab, current_nideid;
   // Get the navbar
    var navbar = document.getElementById("for_title");
    
    // Get the offset position of the navbar
    if (navbar != null){ 
        $('#navbar').html($('#for_title').html());
        $('#navbar').addClass('sticky');
        var sticky = navbar.offsetTop;
        window.onscroll = function() {addSickyToNavBar()};
    }
   window.addEventListener('load', function () {
    $('.adsbygoogle iframe').on('click', 'a[target="_system"],a[target="_blank"],a[target="_top"]', function (e) {
      e.preventDefault();
      var url = this.href;
      window.open(url,"_system");
    });
  }, false);
   <? if (mainPage()||isGraphsPage()||($_REQUEST['section'] == "alerts.php")) {?>
    $.ajax({
      type: "GET",
      url: "<?=BASE_URL?>/02wsjson.txt",
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
<script src="<?=BASE_URL?>/js/tinymce/tinymce.min.07032017.js" type="text/javascript"></script>
<script src="<?=BASE_URL?>/footerScripts011221.php?lang=<?=$lang_idx?>&temp_unit=<?if (empty($_GET['tempunit'])) echo "°c"; else echo $_GET['tempunit'];?>"  type="text/javascript"></script>
<script type="text/javascript">
startup(<?=$lang_idx?>, <?=$limitLines?>, "<?=(isset($_GET['update'])?$_GET['update']:'')?>");
</script>
<?} if (!isset($_GET['c'])){ ?>
<div style="clear:both;height:10px">&nbsp;</div>
<div id="toforum" class="float inv_plain_3_zebra big" style="display:none">
<a href="<? echo BASE_URL.substr(strrchr($_SERVER["PHP_SELF"], "/"), 0)."?section=chatmobile.php&lang=".$lang_idx."&amp;tempunit=".$_GET['tempunit']."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c'];?>"  title="<? echo $HOME_PAGE[$lang_idx];?>" class="hlink">
<? echo $CHAT_TITLE[$lang_idx];?>
</a>
</div>
<?}?>
</body>
</html>
<? if ($_GET['debug'] == '') include "../end_caching.php"; ?>