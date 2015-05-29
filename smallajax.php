<?
header('Content-type: text/html; charset=utf-8');
header("Access-Control-Allow-Origin: null");
ini_set("display_errors","On");
ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE);
function isHeb()
{
	global $lang_idx;
	return ($lang_idx == 1);
}
//if ($_GET['debug'] == '')
//	include "begin_caching.php";
include_once ('lang.php');
$lang_idx = $_REQUEST['lang'];
if (empty($lang_idx))
    $lang_idx = 1;

if (($_REQUEST['section'] != "")&&($_REQUEST['section'] != "SendEmailForm.php")&&($_REQUEST['section'] != "alerts.php"))
    $width = "570px";
else
    $width = "320px";

function isFastPage(){
    return ($_REQUEST['section'] == "alerts.php");
}
?>
<!DOCTYPE html>
<html  <? if (isHeb()) echo "lang=\"he\" xml:lang=\"he\"" ; ?> xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="css/main.php?lang=<?=$lang_idx;?>&type=" type="text/css">
<link rel="stylesheet" href="css/mobile.php<?echo "?lang=".$lang_idx."&amp;width=".$width;?>" type="text/css" />
<link rel="icon" type="image/png" href="img/favicon_sun.png" />
<meta http-equiv="Refresh" content="1800" />
<meta property="og:image" content="http://www.02ws.co.il/02ws_short.png" />
<meta name="viewport" content="width=<?=$width?> <? if ($_REQUEST['section'] != "") echo ""; else echo  ",user-scalable=no";?>" />
<title><? echo $LOGO[$lang_idx];?></title>
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
<form method="post" action="<?=$_SERVER['SCRIPT_NAME'];?>?lang=<? echo $lang_idx;?>&amp;size=<?=$size?>&amp;tempunit=" id="tempconversion">
        <input type="hidden" name="tocorf" value="" /> 
        <a href="javascript:void(0)" onclick="document.getElementById('tempconversion').submit();" style="text-decoration:underline">&#176;C</a>
        | 
        <a href="javascript:void(0)" onclick="document.getElementById('tempconversion').submit();" style="text-decoration:underline">&#176;F</a>
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
 
    
<div id="itfeels_windchill" style="display:none;"> 
<a title="<?=$WIND_CHILL[$lang_idx]?>" href="<?=$_SERVER['SCRIPT_NAME']?>?section=graph.php&amp;graph=tempwchill.php&amp;profile=1&amp;lang=<?=$lang_idx?>"> 
        <? echo $IT_FEELS[$lang_idx]; ?>
        <span dir="ltr" class="low" title="<?=$WIND_CHILL[$lang_idx]?>">&#176;</span>
 </a> 
</div>


<div class="" id="itfeels_heatidx" style="display:none;">
<a title="<?=$HEAT_IDX[$lang_idx]?>"  href="<?=$_SERVER['SCRIPT_NAME']?>?section=graph.php&amp;graph=tempheat.php&amp;profile=1&amp;lang=<?=$lang_idx?>"> 
        <? echo $IT_FEELS[$lang_idx]; ?>
        <span dir="ltr" class="high" title="<?=$HEAT_IDX[$lang_idx]?>">&#176;</span>
 </a> 
</div>
   
<div id="tempdivvalue">
</div>

<div id="statusline">
    <div  id="windy">

    </div>
    <div  id="coldmeter">
    <span id="current_feeling_link" title="<?=$HOTORCOLD_T[$lang_idx]?> - <?=$COLD_METER[$lang_idx]?>">&nbsp;</span>
    </div>
</div>
<div id="what_is_h"></div>
</div>
<div id="latesttemp" class="inparamdiv" style="display:none;">
        <div class="paramtitle slogan">
             <a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=temp.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>&amp;style=<?=$_GET["style"]?>" title=""><? echo $TEMP[$lang_idx];?></a>
         </div>
        <div class="paramvalue">
             
         </div>
         <div class="highlows">
                 <div class="high"><strong></strong></div>&nbsp;<img src="img/peak_max.png" width="15" height="14" alt="<? echo $HIGH[$lang_idx]; ?>"/>&nbsp;
                 <div class="low"><strong></strong></div>&nbsp;<img src="img/peak_min.png" width="15" height="14" alt="<? echo $LOW[$lang_idx]; ?>"/>&nbsp;
         </div> 
         <div class="paramtrend relative">
             <div class="innertrendvalue">
                <? echo " ".($MINTS[$lang_idx]).": "; ?>
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
                     <td><div class="trendvalue"><div class="innertrendvalue"></div></div></td>
                     <td ><div class="trendvalue"><div class="innertrendvalue"></div></div></td>
                     <td ><div class="trendvalue"><div class="innertrendvalue"></div></div></td>
                 </tr>
         </table>
    </div>
    <div class="graphslink">
                 <a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=temp.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>&amp;style=<?=$_GET["style"]?>" title=""><img src="img/graph_icon.png" width="35" height="18" alt="to graphs"/></a>
    </div>
 </div>
<div id="latesthumidity" class="inparamdiv" <? if (isHeb()) echo "dir=\"rtl\" ";?> style="display:none">
    <div class="paramtitle slogan">
                <a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=humwind.php&amp;level=1&amp;freq=2&amp;datasource=downld02&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>&amp;style=<?=$_GET["style"]?>" title=""><? echo $HUMIDITY[$lang_idx];?></a>
        </div>
        <div class="paramvalue">
                
        </div>
        <div class="highlows">
                 <span><strong></strong>&nbsp;<img src="img/peak_max.png" width="15" height="14" alt="<? echo $HIGH[$lang_idx]; ?>"/>&nbsp;</span>
                 &nbsp;&nbsp;&nbsp;&nbsp;<span><strong></strong>&nbsp;<img src="img/peak_min.png" width="15" height="14" alt="<? echo $LOW[$lang_idx]; ?>"/>&nbsp;</span>
         </div>
       <div class="paramtrend relative">
            <div class="innertrendvalue">
            
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
                     <td><div class="trendvalue"><div class="innertrendvalue"></div></div></td>
                     <td ><div class="trendvalue"><div class="innertrendvalue"></div></div></td>
                     <td ><div class="trendvalue"><div class="innertrendvalue"></div></div></td>
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

           

</div>
<div class="highlows">
    <span><strong></strong>&nbsp;<img src="img/peak_max.png" width="15" height="14" alt="<? echo $HIGH[$lang_idx]; ?>"/></span>
</div>
<div class="paramtrend relative">
    <? echo $DAILY_RAIN[$lang_idx]; ?>:&nbsp;<span id="dailyrain"></span><br/>
<? echo $TOTAL_RAIN[$lang_idx]; ?>:&nbsp;<span id="totalrain"></span>
</div>
<div class="trendstable">
 <table id="rainrate15min">
<tr class="trendstitles">
        <td  class="box" title="<? echo($HOUR[$lang_idx]);?>"><img src="img/hour_icon.png" width="21" height="21" alt="hour"/></td>
        <td  class="box" title="30<? echo($MINTS[$lang_idx]);?>"><img src="img/half_icon.png" width="21" height="21" alt="half hour"/></td>
        <td class="box" title="<? echo ($MINTS[$lang_idx]);?>"><img src="img/quarter_icon.png" width="21" height="21" alt="quarter hour"/></td>
</tr>
<tr class="trendsvalues">
        <td><div class="trendvalue"><div class="innertrendvalue">
                
                </div></div></td>
        <td><div class="trendvalue"><div class="innertrendvalue">
                
        </div></div></td>
        <td ><div class="trendvalue"><div class="innertrendvalue">
                

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
       <li style="border:none">
           
        </li>
        <li>
            
        </li>
        <li>
            
        </li>
        <li>
            
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
            
        </ul>
	<table <? if (isHeb()) echo "dir=\"rtl\""; ?> style="border-spacing:2px;padding:3px;width:100%">
        
	</table> 
</div>
<div id="forecast24h">
	<div id="for24_given">
							<? echo($GIVEN[$lang_idx]." ".$AT[$lang_idx]." ");?>
	</div>
	<div id="for24_details" style="display:none">
		<span id="tempForecastDiv" style="display:none">
		</span>
	</div>
	<div id="forecasthours">
        
	</div>
</div>
</div>
<? if ($width=="320px") {?>

<!-- Ad small page -->
<ins class="adsbygoogle"
     style="display:inline-block;width:320px;height:50px"
     data-ad-client="ca-pub-2706630587106567"
     data-ad-slot="6699246495"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
<?}?>
<div id="messages_box" class="white_box">
    <h2><? echo $MESSAGES[$lang_idx];?></h2>
    <p class="box_text">
     
    </p>
</div>
<? if ($width=="320px") {?>
<!-- small's large -->
<ins class="adsbygoogle"
     style="display:inline-block;width:320px;height:100px"
     data-ad-client="ca-pub-2706630587106567"
     data-ad-slot="7272921896"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
<?}?>
<div id="livepic_box" class="white_box">
    <div class="avatar live_avatar"></div>
    <h3><? echo $LIVE_PICTURE[$lang_idx];?></h3>
    <a href="images/webCamera.jpg" title="<? echo($LIVE_PICTURE[$lang_idx]);?>"><img src="phpThumb.php?src=images/webCameraB.jpg&amp;w=180" width="180" height="135" alt="<? echo($LIVE_PICTURE[$lang_idx]);?>" /></a>
    <br/>
    <h3><a id="radar" href="<?=$_SERVER['SCRIPT_NAME']?>?section=radar.php&amp;lang=<?=$lang_idx;?>">
				<? echo $RAIN_RADAR[$lang_idx];?>
    </h3>		</a>
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
    <?}?>
</div>
 <? //if (isHeb()) include "chat.php"; ?>

</div>
<!--
<script src="js/rain.js" type="text/javascript"></script>

<script src="js/snow.js" type="text/javascript"></script>-->
<script src="js/jquery-1.6.1.min.js"  type="text/javascript"></script>
<? if (!isFastPage()) { ?>

<script src="js/tinymce/tinymce.min.js" type="text/javascript"></script>
<script src="footerScripts.php?lang=<?=$lang_idx?>"  type="text/javascript"></script>
<script type="text/javascript">
startup(<?=$lang_idx?>, 7, "<?=(isset($_GET['update'])?$_GET['update']:'')?>");
//getTempForecast(<?=$timetaf?>, '<?=$dayF."/".$monthF."/".$yearF?>'); 
</script>
<?}?>

<script type="text/javascript">
    function fillAllJson(jsonstr)
    {
           
             try{
                 var json = JSON.parse( jsonstr  );
             }
             catch (e) {
                 alert('parsing json: ' + e);
                 
              }
              try{
                 $('#tempdivvalue').html(json.jws.current.temp+'<span class="paramunit">'+json.jws.current.tempunit+'</span>');
                 $('#windy').html(json.jws.windstatus.lang1);
                 $('#what_is_h').html(json.jws.states.sigtitle1+'<br/>'+json.jws.states.sigext1);
                 //alert('wind:' + json.jws.forecastHours[2].wind);
                 //alert('title: ' + json.jws.forecastDays[2].lang1);
                 $('#messages_box').children('.box_text').html(json.jws.Messages.detailedforecast1);
                 $("#latesttemp .paramvalue").html(json.jws.current.temp+'<span class="paramunit">'+json.jws.current.tempunit+'</span>');
                 
                 $("#latesthumidity .paramvalue").html(json.jws.current.hum+'%');
                 $("#latestrain .paramvalue").html(json.jws.current.rainrate+'<span class="paramunit">mm/hr'+'</span>');
                 
             }
             catch (e) {
                 alert('extracting json to page: ' + e);
                 
              }
   }
   
    $.ajax({
      type: "GET",
      url: "02wsjson.txt",
      beforeSend: function(){$(".loading").show();}
    }).done(function( jsonstr  ) {
      try{

          fillAllJson(jsonstr);
      }
      catch (e) {
          alert ('error:' + e);
      }
    });
</script>
</body>
</html>
<? //if ($_GET['debug'] == '') include "end_caching.php"; ?>