<?php
header('Content-type: text/html; charset=utf-8');
//ini_set("display_errors","On");
if ($_GET['debug'] == '')
    include "begin_caching.php";
set_include_path(get_include_path() . PATH_SEPARATOR . "/home/boazn/02ws.com/public". PATH_SEPARATOR ."./");
include_once("include.php"); 
include_once("start.php");
include_once("requiredDBTasks.php");
include_once "sigweathercalc.php";
include_once "runwalkcalc.php";
$sigforecastHour = $mem->get('sigforecastHour');

?>
 <!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <title><? echo getPageTitle()?></title>
        <meta name="description" content="<? if (isHeb()) {?>מתעדכן כל דקה מתחנה פיזית על הגג. תחזית ל-24 שעות, לימים הבאים , ארכיון וכל מה שרצית לדעת<?} else {?>What is the weather in Jerusalem, Israel? Here you have 6 days forecast, current significant conditions, live pictures, weather graphs,  detailed archive and much more. This is online weather station which updates every minute. <?} ?>"/>
        <meta name="keywords" content="climate, forecast, weather, jerusalem תחזית מזג אויר , אקלים, שלג, ממוצע, ארכיון"/>
        <meta name="author" content="Boaz" />
	<meta property="og:image" content="https://www.02ws.co.il/02ws_short<?if (!isHeb()) echo "_eng";?>.png?r=<?=time()?>" />
        <meta property="og:image:width" content="1200" />
        <meta property="og:image:height" content="628" />
        <meta property="og:description" content="<? echo "{$sig[0]['sig'][$lang_idx]}"; ?>" /> 
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
        <link rel="stylesheet" href="css/bootstrap<?=$lang_idx; ?>.css" type="text/css" >
        
	<!--<link rel="stylesheet" href="css/bootstrap-responsive.min.css">
	<link rel="stylesheet" href="css/bootstrap-responsive.css">-->
        <style id="style_in_head">
            body {
                padding-top: 40px;
                padding-bottom: 40px;
            }
        </style>
        <link rel="stylesheet"  href="css/main<?=$lang_idx;?>.css" type="text/css">
        <? if ($current->is_sunset()) { ?>
        <link rel="stylesheet" title="mystyle" href="css/sunset.min.css" type="text/css">
        <? }?>
        <? if ($current->is_sunrise()) { ?>
        <link rel="stylesheet" title="mystyle" href="css/sunrise.min.css" type="text/css">
        <? }?>
        <? if (($current->is_light())&&($current->get_cloudiness() > 6)) {?>
             <link rel="stylesheet" title="mystyle" href="css/cloudy.min.css" type="text/css" media="screen">
        <? }?>
        <? if ($current->get_pm10() > 300) { ?>
        <link rel="stylesheet" title="mystyle" href="css/dust.min.css" type="text/css">
        <? }?>
        <? if (!$current->is_light()){  ?>       
            <link rel="stylesheet" title="mystyle" href="css/night<?=$lang_idx?>.min.css" type="text/css">
            <? if ($current->get_pm10() > 300) { ?>
            <link rel="stylesheet" title="mystyle" href="css/dust-night.min.css" type="text/css">
            <? }?>
        <? }?>
        <? if (isRaining()){ ?>
	<link rel="stylesheet" title="mystyle" href="css/rain.min.css" type="text/css">
        <? }?>
        <? if (isSnowing()) { ?>
        <? if ($current->is_light()){?>
        <link rel="stylesheet" title="mystyle" href="css/snow.min.css" type="text/css">
        <? } else {?>
        <link rel="stylesheet" title="mystyle" href="css/snow_night.min.css" type="text/css">
        <? }?>
        <? }?>
        <link rel="icon" type="image/png" href="img/favicon_sun.png">
         <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-647172-1', 'auto');
            ga('send', 'pageview');

        </script>
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <script id="adsense_start">
                (adsbygoogle = window.adsbygoogle || []).push({
                google_ad_client: "ca-pub-2706630587106567",
                enable_page_level_ads: false
                });
                </script>
    </head>
    <body>
        <!--[if lt IE 9 ]>	
	<div class="topbase" id="topmessage" class="big" style="z-index:9999">
        Please update you browser. The site does not support internet explorer 6-8.<br /><br />אנא עדכן את הדפדפן<a href="https://www.mozilla.com"><img border="0" alt="Firefox 3" title="Firefox 3" src="https://sfx-images.mozilla.org/affiliates/Buttons/firefox3/120x240.png" /></a>
	<a href="https://www.google.com/chrome/"><img src="https://www.techdigest.tv/assets_c/2009/02/google-chrome-logo-thumb-300x300-75857.jpg" alt="Chrome" width="150px"></a>
        <br />
        <br />
        <a href="stationo.php?lang=<?=$lang_idx?>">Old 02WS site ירושמיים הישן</a>
	<a href="#" title="close" onclick="toggle('topmessage')"><div class='sprite stop1'></div></a>
        </div>
        <![endif]-->
        
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container row">
		    <div class="nav">	
			<ul id="top_links">
                            <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'faq.php');?>" title="<?=$FAQ[$lang_idx]?>"><?=$FAQ[$lang_idx ]?></a></li>
                            <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'tips.php');?>" title="<?=$TIPS[$lang_idx]?>"><?=$TIPS[$lang_idx ]?></a></li>
			    <li><a href="javascript:void(0)" ><? echo $WHAT_ELSE[$lang_idx];?>&nbsp;<span class="arrow_down">&#9660;</span></a>
                                    <ul style="<?echo get_s_align();?>: -2em;">
                                                        <li>
                                                                <a href="<? echo get_query_edited_url($url_cur, 'section', 'radar.php');?>">
                                                                        <? echo $RAIN_RADAR[$lang_idx].get_arrow();?>
                                                                </a>
                                                        </li>
                                                        <li>
                                                                <a href="https://en.sat24.com/en/is" title="<? echo  $SATELLITE[$lang_idx];?>" rel="external">		
                                                                        <? echo  $SATELLITE[$lang_idx].get_arrow();?>
                                                                </a>
                                                        </li>
                                                        <li>										
                                                                        <? if (!$error_db){ $licount = $licount + 1;?>
                                                                        <a href="<?=BASE_URL;?>?section=graph&amp;graph=RainHistory.gif&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>" title="<? echo $TILL_NOW[$lang_idx].": ".$seasonTillNow->get_rain2()." ; ".$NORMAL[$lang_idx]." ".$TILL_NOW[$lang_idx].": ".$averageTillNow->get_rain();?>">
                                                                            <? if ($daysWithoutRain >= 4){ echo $daysWithoutRain." ".$DAYS_WITHOUT_RAIN[$lang_idx]." - "; } ?>  
                                                                                <? echo " <span>";
                                                                                 if ($seasonTillNow->get_raindiffav() > 0) echo $LEFTOVER[$lang_idx]; else echo $LACK[$lang_idx];
                                                                                 echo " ".round(abs($seasonTillNow->get_raindiffav()))." ".$RAIN_UNIT[$lang_idx]."</span>".get_arrow(); ?>
                                                                        </a>
                                                                        <? } ?>
                                                        </li>
                                                   <li id="airqli">
                                                                        <span id="airqtitle">
                                                                                <a href="<?=$airq_link?>" rel="external"><? echo $AIR_QUALITY[$lang_idx].get_arrow(); ?></a>
                                                                        </span>
                                                                        <!-- <div id="airqstorage" style="display:none;"> 
                                                                        </div>
                                                                        <span id="airqtitle">
                                                                                <a href="javascript:void(0)" onclick="accessByDOM('<?=$airq_path?>');"><? echo $AIR_QUALITY[$lang_idx]; ?></a>
                                                                        </span>
                                                                        <a href="<?=$airq_link?>" rel="external">
                                                                                <span id="airqdisplayed"></span>
                                                                                <span id="dustitle"><? echo $DUST[$lang_idx]; ?>?</span>
                                                                                <span id="dustdisplayed"></span>
                                                                        </a> -->

                                                        </li>
                                                        <? 
                                                             /*   if (($lowtemp_diffFromAv > 3) && ($hightemp_diffFromAv > 3) && (!isRaining()))
                                                                {											
                                                                        $res = getRadioData();
                                                                        if ($res)
                                                                        { ?>
                                                                        <li style="width:160px">
                                                                                        <a class="hlink" href="https://en.wikipedia.org/wiki/Haines_Index" target="_blank">
                                                                                                        <?echo $FIRE_INDEX[$lang_idx];?>
                                                                                                        <?SortIndex ("", $FireIdx."", 4 , 5 , 6 , true, true);?>
                                                                                        </a>

                                                                        </li>
                                                                        <? }
                                                                }*/
                                                                ?>
                                                    <li>
                                                       
                                                        <li><a href="JWSBanner.html" class="hlink"><? echo $BANNER_FLASH_VIEW[$lang_idx];?></a></li>
                                                        <li>
                                                                <a class="hlink" href="<? echo get_query_edited_url(get_url(), 'section', 'radiosonde.php');?>" title="<?echo $STORM_POWER[$lang_idx];?>">
                                                                        <? echo $CURRENT_ENERGY[$lang_idx].get_arrow();?>
                                                                </a>
                                                        </li>
                                                        <li><a class="hlink" href="https://www.svivaaqm.net/DynamicTable.aspx?G_ID=14" title="Additional stations in Jerusalem עוד תחנות בי-ם" rel='external' >
                                                                                                                 <?  echo $STATIONS_NEARBY[$lang_idx].get_arrow(); ?></a>
                                                        </li>
                                                        <li><a class="hlink" href="https://www.wunderground.com/stationmaps/gmap.asp?zip=00000&amp;wmo=40184" title="Nearby stations עוד תחנות באזור" rel='external' >
                                                                <?  echo $WEATHER_NEARBY[$lang_idx].get_arrow(); ?></a>
                                                        </li>
                                                        <!-- Global Warming -->
                                                        <li >
                                                                <a class="hlink" href="<? echo get_query_edited_url(get_url(), 'section', 'globalwarm.php');?>" onmouseover="toggle('globalwarmanomaly')" onmouseout="toggle('globalwarmanomaly')"><? echo $GLOBAL_WARMING[$lang_idx]; ?>:<span dir="ltr">
                                                                        <?	
                                                                           $gw =  number_format($mem->get('avganomaly'), 2, '.', '');
                                                                           $gw_plus_minus = $gw >= 0 ? "+" : "";
                                                                           echo $gw_plus_minus.$gw;
                                                                           echo $current->get_tempunit(); ?>
                                                                        </span><? echo get_arrow();?></a>
                                                                </li>

                                                        <!-- End Global Warming -->
                                                        <li><a href="runningtreks.php?lang=<? echo $lang_idx;?>" class="hlink"><? echo $RUNNING_TREKS[$lang_idx].get_arrow();?></a></li>
                                                        <li><a href="<?=BASE_URL;?>?section=models.php&amp;model=&amp;hours=24&amp;lang=<? echo $lang_idx;?>" class="hlink"><? echo $MODELS[$lang_idx].get_arrow();?></a></li>
                                                        <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'lightning.php');?>" class="hlink"><? echo $LIGHTS[$lang_idx].get_arrow();?></a></li>
                                                        <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'radiosonde.php');?>" class="hlink"><? echo $RADIOSONDE[$lang_idx].get_arrow();?></a></li>
                                                        <li><a href="http://www.kineret.org.il" class="hlink" rel="external"><? echo $KINNERET[$lang_idx].get_arrow();?></a></li>
                                   </ul>
                             </li>
                            <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'chooseMonthYear');?>" title="<? echo $HISTORY[$lang_idx].", ".$YESTERDAY[$lang_idx].", ".$CHOOSE[$lang_idx]."...";?>"><? echo $WHAT_HAPPEND[$lang_idx];?>&nbsp;<span class="arrow_down">&#9660;</span></a>
                                    <ul style="<?echo get_s_align();?>: -2em;">
                                        <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'yesterday.php');?>" class="hlink"> <? echo $YESTERDAY[$lang_idx];?></a></li>
                                                        <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'averages.php');?>" class="hlink"><? echo $YEARLY_AVERAGE[$lang_idx].get_arrow();?></a></li>  
                                                        <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'reports/downld02.txt');?>" class="hlink"> <? echo $DETAILED_TABLE[$lang_idx].get_arrow();?></a></li>
                                                        <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'reports/downld08.txt');?>" class="hlink"> <? echo $DETAILED_TABLE08[$lang_idx].get_arrow();?></a></li>
                                                        <li><a href="<? echo get_query_edited_url($url_cur, 'section', FILE_THIS_MONTH);?>" ><? echo $monthInWord." ".$year." - ".$SUMMARY[$lang_idx].get_arrow(); ?></a></li>
                                                        <li><a href="<? echo get_query_edited_url($url_cur, 'section', FILE_THIS_YEAR);?>" ><? echo $year." - ".$SUMMARY[$lang_idx].get_arrow(); ?></a></li>    
                                                        <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'chooseMonthYear');?>" ><? echo $CHOOSE[$lang_idx].get_arrow(); ?></a></li>
                                                        <li><a href="<? echo get_query_edited_url($url_cur, 'section', '2weeks.php');?>" class="hlink"><? echo $ALL_GRAPHS[$lang_idx]." - ".$LAST_WEEK[$lang_idx].get_arrow();?></a></li>
                                                        <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'month.php');?>" class="hlink"><? echo $ALL_GRAPHS[$lang_idx]." - ".$LAST_MONTH[$lang_idx].get_arrow();?></a></li>
                                                        <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'allTimeRecords.php');?>" class="hlink" title="<?=$RECORDS_LINK[$lang_idx];?>"><? echo $RECORDS[$lang_idx].get_arrow();?></a></li>
                                                        <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'RainSeasons.php');?>" class="hlink">170 <? echo $RAIN_SEASONS[$lang_idx].get_arrow();?></a></li>
                                                        <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'forecastDays.php');?>" class="hlink"><? echo $LIKED_FORECAST[$lang_idx].get_arrow();?></a></li>
                                                        <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'radar.php');?>"><? echo $RAIN_RADAR[$lang_idx]." - ".$ARCHIVE[$lang_idx].get_arrow();?></a></li>
                                                        <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'browsedate.php');?>" class="hlink"><? echo $ARCHIVE[$lang_idx].get_arrow();?></a></li>
                                                        <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'reports.php');?>" class="hlink"><? echo $REPORTS[$lang_idx].get_arrow();?></a></li>
                                                        <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'snow.php');?>" class="hlink"><? echo $SNOW_JER[$lang_idx].get_arrow();?></a></li>
                                                        <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'climate.php');?>" title="<? echo $CLIMATE_TITLE[$lang_idx];?>" class="hlink"><? echo $CLIMATE[$lang_idx].get_arrow();?></a></li>
                                   </ul>
                             </li>
			    <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'SendFeedback.php');?>" class="hlink" title="<? echo $CONTACT_ME[$lang_idx];?>"><? echo $CONTACT_ME[$lang_idx];?></a></li>
			</ul>
		    </div>
        	     <div>
			<ul class="nav" id="user_info">
			      <li><p id="user_name"></p><div id="user_icon"></div><span class="arrow_down">&#9660;</span>
					  <ul style="<?echo get_s_align();?>: -2em;">
						<li>
							<div id="notloggedin" style="display:none">
								<div><a href="javascript: void(0)" id="login" title="<?=$LOGIN[$lang_idx]?>" ><?=$LOGIN[$lang_idx]?></a></div>
								<div><a href="javascript: void(0)" class="register" id="register" title="<?=$REGISTER[$lang_idx]?>"><?=$REGISTER[$lang_idx]?></a></div>
								
							</div>
							<div id="loggedin" style="display:none">
								<input id="updateprofile" class="button inv_plain_3_zebra" title="<?=$UPDATE_PROFILE[$lang_idx]?>" value="<?=$UPDATE_PROFILE[$lang_idx]?>" /><br />
                                                                <input id="myvotes" class="button inv_plain_3_zebra" title="<?=$MY_VOTES[$lang_idx]?>" value="<?=$MY_VOTES[$lang_idx]?>" onclick="redirect('<? echo substr(get_query_edited_url($url_cur, 'section', 'myVotes.php'), 1);?>')" /><br />
                                                                <input value="<?=$SIGN_OUT[$lang_idx]?>" onclick="signout_from_server(<?=$lang_idx?>, <?=$limitLines?>, '<?=$_GET['update']?>')" id="signout" class="button inv_plain_3_zebra"/>
							</div>
						</li>
					  </ul>
				  </li>
				          
			 </ul>
                         <script>
                            (function() {
                              var cx = '015797918429786803740:3gypbrujmfc';
                              var gcse = document.createElement('script');
                              gcse.type = 'text/javascript';
                              gcse.async = true;
                              gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
                              var s = document.getElementsByTagName('script')[0];
                              s.parentNode.insertBefore(gcse, s);
                            })();
                          </script>

                          
                      
                         <div class="gcse-searchbox">
                            
                         </div>
                         	
			
                         <? if ($lang_idx == 1) {?>
								<p id="english"><a href="#" title="switch to english" onclick="changeLang('0')">English</a></p>
								<?} 
								else {?>
								<p id="hebrew"><a href="#" onclick="changeLang('1')" title="switch to hebrew">עברית</a></p>
				<?} ?>
                         <? if (!isHeb()) {?>
				<div dir="ltr" class="il_image" id="tempunitconversion">
				<form method="post" action="<?=BASE_URL;?>?lang=<? echo $lang_idx;?>&amp;tempunit=<? if (strpos(strtoupper($current->get_tempunit()), 'F') !== False) echo 'C'; else echo 'F';?>" id="tempconversion">
					<input type="hidden" name="tocorf" value="<? if (strpos(strtoupper($current->get_tempunit()), 'F') !== False) echo '&#176;C'; else echo '&#176;F';?>" /> 
					<?  if (strpos(strtoupper($current->get_tempunit()), 'F') !== False) { ?>
					<a href="javascript:void(0)" onclick="document.getElementById('tempconversion').submit();">&#176;C</a>
					<?  } else { ?>
					&#176;C
					<?  } ?>
					| 
					<?  if (strpos(strtoupper($current->get_tempunit()), 'C') !== False)  { ?>
					<a href="javascript:void(0)" onclick="document.getElementById('tempconversion').submit();">&#176;F</a>
					<?  } else {  ?>
					&#176;F
					<?  } ?>
				</form>
				</div>
				<?}	?>

                    </div>
                </div>
            </div>
        </div>
        <div class="container row">
            <input type="button" id="CloseCircles" style="top:40px;left:650px;display:none;position:absolute;cursor:pointer;width:150px;z-index:999"  title="להחזיר למקום" onclick="javascript:closeAllCircles()" value="להחזיר למקום" />
            <div id="slogan">
                <span><? echo $SLOGAN[$lang_idx];?></span>&nbsp;&nbsp;
               <? echo $ELEVATION[$lang_idx]." ".ELEVATION." ".$METERS[$lang_idx]; ?>&nbsp;&nbsp;
               <span id="date" <? if (time() - filemtime($fulldatatotake) > 3600) echo "class=\"high afont\"";?>>
               <? if (isHeb()) echo $dateInHeb; else echo $date;?>
               </span>
                 <div id="fb_like" class="invfloat">
            	 <iframe src="https://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2Fpages%2FJerusalem-Israel%2F02ws-yrwsmyym-mzg-hwwyr-bzmn-mt%2F118726368187010&amp;layout=button_count&amp;show_faces=true&amp;width=100&amp;action=like&amp;colorscheme=light&amp;height=21" style="border:none; overflow:hidden; width:100px; height:21px;allowTransparency:true"></iframe>
                         
                </div> 
               <ul id="ftr_icons" class="invfloat">
                    <li><a href="<? echo get_query_edited_url(get_url(), 'section', 'Api.php');?>" id="rss"></a></li>
                    <li><a href="https://twitter.com/YERU02WS" target="_blank" id="twitter"></a></li>
                    <li><a href="https://www.facebook.com/pages/02ws-ירושמיים-מזג-האוויר-בזמן-אמת/118726368187010" target="_blank" id="facebook"></a></li>
                </ul>
               <a id="about" href="<? echo get_query_edited_url($url_cur, 'section', 'contact.php');?>"><?=$CONTACT_INFO[$lang_idx ]?></a>
            </div>
            
				<? if ((first_page())||($template_routing=="frommobile")) { ?>
            <div class="fixed_nav span2">
                 <div id="logo">
                     			
		 </div>
                 <ul class="main_nav">
                    <li>
						<a class="now active" href="#now"><?=$CURRENT_SIG_WEATHER[$lang_idx]?></a>
                    </li>
                    <li>
						<a class="forecast" href="#forecast"><?=$FORECAST_TITLE[$lang_idx]?></a>
                    </li>
                    <li>
						<a class="whatmore" href="#whatmore"><?=$WHAT_MORE[$lang_idx]?></a>
                    </li>
                    <li>
						<a class="pics" href="#pics"><?=$LIVE_PICTURE[$lang_idx]?></a>
                    </li>
                    <li>
						<a class="forum" href="#forum"><?=$CHAT_TITLE[$lang_idx]?></a>
                    </li>
                 </ul>
            </div>
			<?} else {?>
			<div id="to_home" class="not_fixed_nav span2">
				<div id="logo">
                                    <a href="<? echo BASE_URL."?lang=".$lang_idx;?>" >&nbsp;&nbsp;&nbsp;</a>
                                </div>
				<ul class="main_nav">
					<li>
						<a class="now active" href="javascript:void(0)" onclick="window.history.back();"><?=$BACK[$lang_idx]?></a>
                                        </li>
				</ul>
			 </div>
			<?}?>
        </div>
 <div class="container">
        <div class="cover_clouds">
                               
         <? if (first_page()) { ?>
                <div id="cover_clouds-1" class="cloud-big"><div class="cloud-big-more"></div></div>
                <div id="cover_clouds-2" class="cloud-big"><div class="cloud-big-more"></div></div>
                <div id="cover_clouds-3" class="cloud-big"><div class="cloud-big-more"></div></div>
                <div id="cover_clouds-4" class="cloud-big"><div class="cloud-big-more"></div></div>
		 <?}?>
	    </div>
        <div id="content">
            <article id="now">
               <div class="row"> 
		<div id="currentrow" class="main_info span8 offset3">
                        <hr id="now_line" style="display:none"/>
                       <hr id="aq_line" />
                        <hr id="temp3_line" />
                        <hr id="temp2_line" />
                        <hr id="temp_line" />
                        <hr id="moist_line" />
                        <hr id="dew_line" />
                        <hr id="air_line" />
                        <hr id="wind_line" />
                        <hr id="rain_line" />
                        <hr id="rad_line" />
                        <hr id="uv_line" />
                        <hr id="window_line" />
                        <hr id="moon_line" />
                        <hr id="runwalk_line" />
                        <hr id="otherstations_line" />

                    <ul id="sidebar" >
                            <li id="all_btn" onclick="showAllCircles()" class="span-value" data-value="<? echo $FULL[$lang_idx];?>"></li>
                            <li id="temp2_btn" onclick="change_circle('temp2_line', 'latesttemp')"  class="span-value" data-value="<? echo $TEMP[$lang_idx]." ".$MOUNTAIN[$lang_idx];?>"></li>
                            <li id="temp_btn" onclick="change_circle('temp_line', 'latesttemp2')" class="span-value" data-value="<? echo $TEMP[$lang_idx]." ".$VALLEY[$lang_idx];?>"></li>
                            <li id="temp3_btn" onclick="change_circle('temp3_line', 'latesttemp3')" class="span-value" data-value="<? echo $TEMP[$lang_idx]." ".$ROAD[$lang_idx];?>"></li>
			    <li id="moist_btn" onclick="change_circle('moist_line', 'latesthumidity')" class="span-value" data-value="<? echo $HUMIDITY[$lang_idx];?>"></li>
			    <li id="dew_btn" onclick="change_circle('dew_line', 'latestdewpoint')" class="span-value" data-value="<? echo $DEW[$lang_idx];?>"></li>
			    <li id="window_btn" onclick="change_circle('window_line', 'latestwindow')" data-value="<? echo $YOU_BETTER[$lang_idx]." ".isOpenOrClose()." ".$THE_WINDOW[$lang_idx];?>" class="span-value <?if (isOpenOrClose()==$OPEN[$lang_idx]){echo"window_open";}else{echo"window_closed";};?>"></li>	
                            
                    </ul>
                    <div id="current_info">
                        <ul id="topbar" >
                            <li id="now_btn" onclick="change_circle('now_line', 'latestnow')" class="span-value" data-value="<? echo $NOW[$lang_idx];?>"></li>
                            <li id="runwalk_btn" onclick="change_circle('runwalk_line', 'latestrunwalk')" class="span-value" data-value="<?=$RUN_WALK[$lang_idx]?>"></li>
                            <li id="wind_btn" onclick="change_circle('wind_line', 'latestwind')" class="span-value" data-value="<? echo $WIND[$lang_idx];?>"></li>
			    <li id="rain_btn" onclick="change_circle('rain_line', 'latestrain')" class="span-value" data-value="<? echo $RAIN[$lang_idx];?>"></li>
			    <li id="rad_btn" onclick="change_circle('rad_line', 'latestradiation')" class="span-value" data-value="<? echo $RADIATION[$lang_idx];?>"></li>
			    <li id="uv_btn" onclick="change_circle('uv_line', 'latestuv')" class="span-value" data-value="<? echo $UV[$lang_idx];?>"></li>
			    <li id="aq_btn" onclick="change_circle('aq_line', 'latestairq')" class="span-value" data-value="<? echo $AIR_QUALITY[$lang_idx];?>"></li>
                            <li id="air_btn" onclick="change_circle('air_line', 'latestpressure')" class="span-value" data-value="<? echo $BAR[$lang_idx];?>"></li>
                            <li id="more_stations_btn" class="span-value" onclick="change_circle('otherstations_line', 'latestotherstations');getLatest('ראש-צורים', '77', 'IMS');getLatest('צובה', '188', 'IMS');getLatest('חוף מערבי', '178', 'IMS');getLatest('עין גדי','211', 'IMS');getLatest('מעלה אדומים', '218', 'IMS');" data-value="<? echo $STATIONS_NEARBY[$lang_idx];?>"></li>
                            <li id="moon_btn" onclick="change_circle('moon_line', 'latestmoon')" class="span-value" data-value="<?=$MOON[$lang_idx]?>"></li>
                            
                       </ul>
                       
		   
                      
		    <div id="info_circle_new">
                        <div id="latestnow" class="inparamdiv">
                            
                            <div id="tempdivvalue" title="<?if ($current->is_light()){ echo " ".$SHADE[$lang_idx]." "; }?>">
                            <? echo $current->get_temp();?><div class="paramunit">&#176;</div><div class="param"><? echo $current->get_tempunit(); ?></div>
                           </div>
                            <div class="" id="itfeels">
                            
                             <?$itfeels = array();
                               $itfeels = $current->get_itfeels();
                               
                                if ($current->is_sun()) { ?>
                                        <? echo $IT_FEELS[$lang_idx]; ?><br/>
                                         <a title="<?=$THSW[$lang_idx]?>"  href="<?=BASE_URL?>?section=graph&amp;graph=THSWHistory.gif&amp;profile=1&amp;lang=<?=$lang_idx?>" class="info"> 
                                               
                                                <span id="itfeels_thsw" dir="ltr" ><span class="value" data-value="<?=$THSW[$lang_idx]?>"><? echo $current->get_thsw();  ?></span></span><span class="info"><?=$THSW[$lang_idx]?></span> 
                                         </a><a href="javascript:void()" class="info"><span class="info"><? echo $IN_THE_SUN[$lang_idx]."/".$SHADE[$lang_idx]; ?></span><img src="images/shadow.png" width="18" title="<? echo $IN_THE_SUN[$lang_idx]."/".$SHADE[$lang_idx]; ?>" alt="<? echo $SHADE[$lang_idx]."/".$IN_THE_SUN[$lang_idx]; ?>" /></a><? }
                                else if (!empty($itfeels[0]))
                                        echo "<span>".$IT_FEELS[$lang_idx]."</span>"; 
                                if ($itfeels[0] == "windchill" ){ ?>
                                         <a href="<? echo BASE_URL; ?>?section=graph&amp;graph=tempwchill.php&amp;profile=1&amp;lang=<?=$lang_idx?>" class="info"> 
                                                <span id="itfeels_windchill" dir="ltr"><span dir="ltr" class="value" data-value="<?=$THSW[$lang_idx]?>" ><? echo $itfeels[1];  ?></span></span><span class="info"><?=$THSW[$lang_idx]?></span> 
                                         </a>
                                 <? } 
                                else if ($itfeels[0] == "heatindex"){ ?>
                                <a  href="<?=BASE_URL?>?section=graph&amp;graph=tempheat.php&amp;profile=1&amp;lang=<?=$lang_idx?>" class="info"> 
                                <span id="itfeels_heatidx" dir="ltr"><span class="value" data-value="<?=$HEAT_IDX[$lang_idx]?>"><? echo $itfeels[1];  ?></span></span><span class="info"><?=$HEAT_IDX[$lang_idx]?></span> 
                                </a>
                                <?}else if ($itfeels[0] == "thw"){?>
                                <a  href="<?=BASE_URL?>?section=graph&amp;graph=thw.php&amp;profile=1&amp;lang=<?=$lang_idx?>" class="info"> 
                                <span id="itfeels_thw" dir="ltr" ><span class="value" data-value="<?=$THW[$lang_idx]?>"><? echo $itfeels[1];  ?></span></span><span class="info"><?=$THW[$lang_idx]?></span> 
                                </a>
                              <?}?>
                            <? if ($current->is_sun()) { ?>
                            <div class="sunshade"></div> 
                            <? } ?>
                            
                            </div>
                            <div id="status">
                            <div  id="coldmeter">
                            <a href="<?=BASE_URL;?>?section=survey.php&amp;survey_id=2&amp;lang=<? echo $lang_idx;?>"> <span id="current_feeling_link">...</span>
                            </a>
                            </div>
                            <div id="cm_dislike"><a onclick="change_circle('cold_line', 'coldmetersurvey')" class="info"><span class="info"><?=$COLD_METER[$lang_idx]?></span> <img src="images/icons/cm_dislike.svg" width="40" height="40"></a></div>
                            <div id="cm_like"><a onclick="vote_cm_like()" class="info"><span class="info"><?=$COLD_METER_YES[$lang_idx]?></span> <img src="images/icons/cm_like.svg" width="40" height="40"></a></div>
                            <div id="cm_result" style="display:none"><div id="cm_result_msg"></div><div><input type="button" value="<?=$DONE[$lang_idx]?>" onclick="$('#cboxClose').click();" id="cm_result_OK" class="info  inv_plain_3 button" /></div></div>
                            </div>
                            
                            
                            <div  id="windy">
                            <? echo getWindStatus($lang_idx);?>
                            </div>
                           <? if ($current->get_rainchance()>0) { ?>
                            <div class="rainpercent"><? echo $current->get_rainchance();?>%</div>
                           <? } ?> 		
			</div>
                     
                      <div id="latesttemp" class="inparamdiv">
                               <div class="paramtitle slogan">
                                    <a  href="<?=BASE_URL;?>?section=graph&amp;graph=temp<?if ($PRIMARY_TEMP == 2) echo "Latest";?>.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>&amp;style=<?=$_GET["style"]?>" title=""><? echo $TEMP[$lang_idx];?></a>
                                </div>
                               <div class="paramvalue">
                                    
                                       <? echo $current->get_temp();?><div class="paramunit">&#176;</div><div class="param"><? echo $current->get_tempunit(); ?>&nbsp;<? if ($PRIMARY_TEMP == 1) echo " $VALLEY[$lang_idx]"; else echo " $MOUNTAIN[$lang_idx]";?></div>
                                    
                                </div>
                                <div class="highlows">
                                        <div class="highparam"><? echo toLeft($today->get_hightemp()); ?></div>&nbsp;<img src="img/peak_max.png" width="15" height="14" alt="<? echo $HIGH[$lang_idx]; ?>"/>&nbsp;<span class="high_time"><? echo $today->get_hightemp_time()." "; ?></span>
                                        <div class="lowparam"><? echo toLeft($today->get_lowtemp()); ?></div>&nbsp;<img src="img/peak_min.png" width="15" height="14" alt="<? echo $LOW[$lang_idx]; ?>"/>&nbsp;<span class="low_time"><? echo $today->get_lowtemp_time()." "; ?></span>
                                </div> 
                                <div class="paramtrend">
                                    <div class="innertrendvalue">
                                       <? echo getLastUpdateMin()." ".($MINTS[$lang_idx]).": ".get_param_tag($min15->get_tempchange(), true); ?>
                                    </div>
                                </div>  
                          <div class="trendstable"> 
                               <table>
                                        <tr class="trendstitles">
                                                <td  class="box" title="24 <? echo $HOURS[$lang_idx];?>"><img src="img/24_icon.png" width="21" alt="24 <? echo $HOURS[$lang_idx];?>"/></td>
                                                <td  class="box" title="<? echo($HOUR[$lang_idx]);?>"><img src="img/hour_icon.png" width="21" alt="hour"/></td>
                                                <td  class="box" title="30<? echo($MINTS[$lang_idx]);?>"><img src="img/half_icon.png" width="21" alt="half hour"/></td>
                                        </tr>
                                        <tr class="trendsvalues"><td><div class="trendvalue"><div class="innertrendvalue"> <? echo get_param_tag($yestsametime->get_tempchange(), true)."</div></div></td><td ><div class=\"trendvalue\"><div class=\"innertrendvalue\">".get_param_tag($oneHour->get_tempchange(), true)."</div></div></td><td ><div class=\"trendvalue\"><div class=\"innertrendvalue\">".get_param_tag($min30->get_tempchange(), true); ?></div></div></td></tr>
                                </table>
                           </div>
						   <div class="graphslink">
								<a  href="<?=BASE_URL;?>?section=graph&amp;graph=temp<?if ($PRIMARY_TEMP == 2) echo "LatestArchive";?>.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>&amp;style=<?=$_GET["style"]?>" title=""><? echo $MORE_INFO[$lang_idx].get_arrow();?></a>
						   </div>
		       </div>
                        <div id="latesttemp2" class="inparamdiv">
                               <div class="paramtitle slogan">
                                    <a  href="<?=BASE_URL;?>?section=graph&amp;graph=temp<?if ($PRIMARY_TEMP == 1) echo "LatestArchive";?>.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>&amp;style=<?=$_GET["style"]?>" title=""><? echo $TEMP[$lang_idx];?></a>
                                </div>
                               <div class="paramvalue">
                                    
                                   <? if ($current->is_light()) echo $current->get_temp2(); else echo $current->get_temp2();?><div class="paramunit">&#176;</div><div class="param"><? echo $current->get_tempunit(); ?>&nbsp;<?if ($PRIMARY_TEMP == 1) echo " $MOUNTAIN[$lang_idx]"; else echo " $VALLEY[$lang_idx]";?></div>
                                   &nbsp;<div class="param small valley"><? if (!$current->is_light()) echo $LOW_VALLEY[$lang_idx].": ".$current->get_temp3();?>&nbsp;</div>
                                </div>
                                <div class="highlows">
                                        <div class="highparam"><? echo toLeft($today->get_hightemp2()); ?></div>&nbsp;<img src="img/peak_max.png" width="15" height="14" alt="<? echo $HIGH[$lang_idx]; ?>"/>&nbsp;<span class="high_time"><? echo $today->get_hightemp2_time()." "; ?></span>
                                        <div class="lowparam"><? echo toLeft($today->get_lowtemp2()); ?></div>&nbsp;<img src="img/peak_min.png" width="15" height="14" alt="<? echo $LOW[$lang_idx]; ?>"/>&nbsp;<span class="low_time"><? echo $today->get_lowtemp2_time()." "; ?></span>
                                </div> 
                                <div class="paramtrend">
                                    <div class="innertrendvalue">
                                       <? echo getLastUpdateMin()." ".($MINTS[$lang_idx]).": ".get_param_tag($min15->get_temp2change(), true); ?>
                                    </div>
                                </div>  
                          <div class="trendstable"> 
                               <table>
                                        <tr class="trendstitles">
                                                <td  class="box" title="24 <? echo $HOURS[$lang_idx];?>"><img src="img/24_icon.png" width="21" alt="24 <? echo $HOURS[$lang_idx];?>"/></td>
                                                <td  class="box" title="<? echo($HOUR[$lang_idx]);?>"><img src="img/hour_icon.png" width="21" alt="hour"/></td>
                                                <td  class="box" title="30<? echo($MINTS[$lang_idx]);?>"><img src="img/half_icon.png" width="21" alt="half hour"/></td>
                                        </tr>
                                        <tr class="trendsvalues"><td><div class="trendvalue"><div class="innertrendvalue"><? echo get_param_tag($yestsametime->get_temp2change(), true)."</div></div></td><td ><div class=\"trendvalue\"><div class=\"innertrendvalue\">".get_param_tag($oneHour->get_temp2change(), true)."</div></div></td><td ><div class=\"trendvalue\"><div class=\"innertrendvalue\">".get_param_tag($min30->get_temp2change(), true); ?></div></div></td></tr>
                                </table>
                           </div>
						   <div class="graphslink">
								<a  href="<?=BASE_URL;?>?section=graph&amp;graph=temp<?if ($PRIMARY_TEMP == 1) echo "LatestArchive";?>.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>&amp;style=<?=$_GET["style"]?>" title=""><? echo $MORE_INFO[$lang_idx].get_arrow();?></a>
						   </div>
			</div>
                        <div id="latesttemp3" class="inparamdiv">
                               <div class="paramtitle slogan">
                                    <a  href="<?=BASE_URL;?>?section=graph&amp;graph=temp3LatestArchive.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>&amp;style=<?=$_GET["style"]?>" title=""><? echo $TEMP[$lang_idx];?></a>
                                </div>
                               <div class="paramvalue">
                                    
                                   <? echo $current->get_temp3();?><div class="paramunit">&#176;</div><div class="param"><? echo $current->get_tempunit(); ?>&nbsp;<?echo " $ROAD[$lang_idx]";?></div>
                                    
                                </div>
                                <div class="highlows">
                                        <div class="highparam"><? echo toLeft($today->get_hightemp3()); ?></div>&nbsp;<img src="img/peak_max.png" width="15" height="14" alt="<? echo $HIGH[$lang_idx]; ?>"/>&nbsp;<span class="high_time"><? echo $today->get_hightemp3_time()." "; ?></span>
                                        <div class="lowparam"><? echo toLeft($today->get_lowtemp3()); ?></div>&nbsp;<img src="img/peak_min.png" width="15" height="14" alt="<? echo $LOW[$lang_idx]; ?>"/>&nbsp;<span class="low_time"><? echo $today->get_lowtemp3_time()." "; ?></span>
                                </div> 
                                <div class="paramtrend">
                                    <div class="innertrendvalue">
                                       
                                    </div>
                                </div>  
                          <div class="trendstable"> 
                               <table>
                                        <tr class="trendstitles">
                                                <td  class="box" title="24 <? echo $HOURS[$lang_idx];?>"><img src="img/24_icon.png" width="21" alt="24 <? echo $HOURS[$lang_idx];?>"/></td>
                                                <td  class="box" title="<? echo($HOUR[$lang_idx]);?>"><img src="img/hour_icon.png" width="21" alt="hour"/></td>
                                                <td  class="box" title="30<? echo($MINTS[$lang_idx]);?>"><img src="img/half_icon.png" width="21" alt="half hour"/></td>
                                        </tr>
                                        <tr class="trendsvalues"><td><div class="trendvalue"><div class="innertrendvalue"><? echo get_param_tag($yestsametime->get_temp3change(), true)."</div></div></td><td ><div class=\"trendvalue\"><div class=\"innertrendvalue\">".get_param_tag($oneHour->get_temp3change(), true)."</div></div></td><td ><div class=\"trendvalue\"><div class=\"innertrendvalue\">".get_param_tag($min30->get_temp3change(), true); ?></div></div></td></tr>
                                </table>                
                           </div>
						   <div class="graphslink">
                                                   <? if ($current->is_light())  echo " $ROAD_EXP[$lang_idx]"; else echo " $ROAD_EXP_NIGHT[$lang_idx]";?>
								<a  href="<?=BASE_URL;?>?section=graph&amp;graph=temp3LatestArchive.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>&amp;style=<?=$_GET["style"]?>" title=""><? echo $MORE_INFO[$lang_idx].get_arrow();?></a>
						   </div>
			</div>
                        <div id="latesthumidity" class="inparamdiv" <? if (isHeb()) echo "dir=\"rtl\" ";?>>
                            <div class="paramtitle slogan">
                                    <a  href="<?=BASE_URL;?>?section=graph&amp;graph=humwind.php&amp;level=1&amp;freq=2&amp;datasource=downld02&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>&amp;style=<?=$_GET["style"]?>" title=""><? echo $HUMIDITY[$lang_idx];?></a>
                            </div>
                            <div class="paramvalue">
                                    <a href="<?=BASE_URL;?>?section=graph&amp;graph=humwind.php&amp;level=1&amp;freq=2&amp;datasource=downld02&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>&amp;style=<?=$_GET["style"]?>"  class="info"><? echo $current->get_hum();?>%&nbsp;</a>
                                    &nbsp;<div class="param small valley"><? echo $VALLEY[$lang_idx].":".$current->get_hum2();?>%&nbsp;</div>
                            </div>
                            
                            <div class="highlows">
                                     <span><div class="highparam"><? echo $today->get_highhum(); ?></div>&nbsp;<img src="img/peak_max.png" width="15" height="14" alt="<? echo $HIGH[$lang_idx]; ?>"/></span>&nbsp;<span class="high_time"><? echo $today->get_highhum_time()." "; ?></span>
                                     &nbsp;&nbsp;&nbsp;&nbsp;<span><div class="lowparam"><? echo $today->get_lowhum(); ?></div>&nbsp;<img src="img/peak_min.png" width="15" height="14" alt="<? echo $LOW[$lang_idx]; ?>"/></span>&nbsp;<span class="low_time"><? echo $today->get_lowhum_time()." "; ?></span>
                             </div>
                           <div class="paramtrend">
                                <div class="innertrendvalue">
                                <? echo getLastUpdateMin()." ".($MINTS[$lang_idx]).": ".get_img_tag($min15->get_humchange(), true).abs($min15->get_humchange())."%"; ?>
                                </div>
                            </div>
                            <div class="trendstable">
                            <table>
                            <tr class="trendstitles">
                                    <td  class="box" title="24 <? echo $HOURS[$lang_idx];?>"><img src="img/24_icon.png" width="21" alt="24 <? echo $HOURS[$lang_idx];?>"/></td>
                                    <td  class="box" title="<? echo($HOUR[$lang_idx]);?>"><img src="img/hour_icon.png" width="21" alt="hour"/></td>
                                    <td  class="box" title="30<? echo($MINTS[$lang_idx]);?>"><img src="img/half_icon.png" width="21" alt="half hour"/></td>
                            </tr>
                             <tr class="trendsvalues">
                                 <td><div class="trendvalue"><div class="innertrendvalue">
                                     <? echo get_img_tag($yestsametime->get_humchange(), true).abs($yestsametime->get_humchange());?>
                                      </div></div>
                                 </td>
                                 <td><div class="trendvalue"><div class="innertrendvalue">
                                            <? echo get_img_tag($oneHour->get_humchange(), true).abs($oneHour->get_humchange());?>
                                    </div></div>
                                 </td>
                                 <td><div class="trendvalue"><div class="innertrendvalue">
                                     <? echo get_img_tag($min30->get_humchange(), true).abs($min30->get_humchange());?>
                                    </div></div>
                                </td>
                            </tr>
                            </table>
                            </div>
							<div class="graphslink">
								<a  href="<?=BASE_URL;?>?section=graph&amp;graph=humwind.php&amp;level=1&amp;freq=2&amp;datasource=downld02&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>&amp;style=<?=$_GET["style"]?>" title=""><? echo $MORE_INFO[$lang_idx].get_arrow();?></a>
						   </div>
                        </div>
                        <div id="latestdewpoint" class="inparamdiv" <? if (isHeb()) echo "dir=\"rtl\" ";?>>
                            <div class="paramtitle slogan">
                                    <a  href="<?=BASE_URL;?>?section=graph&amp;graph=dewptLatestArchive.php&amp;level=1&amp;freq=2&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>&amp;style=<?=$_GET["style"]?>" title=""><? echo $DEW[$lang_idx];?></a>
                            </div>
                            <div class="paramvalue">
                                    <a href="<?=BASE_URL;?>?section=graph&amp;graph=dewptLatestArchive.php&amp;level=1&amp;freq=2&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>&amp;style=<?=$_GET["style"]?>"  class="info"><? echo $current->get_dew()."<div class=\"paramunit\">&#176;</div><div class=\"param\">".$current->get_tempunit()."</div>";?>&nbsp;</a>
                            </div>
                            <div class="highlows">
                                     <span><strong><div class="highparam"><? echo $today->get_highdew(); ?></div></strong>&nbsp;<img src="img/peak_max.png" width="15" height="14" alt="<? echo $HIGH[$lang_idx]; ?>"/></span>&nbsp;<span class="high_time"><? echo $today->get_highdew_time()." "; ?></span>
                                     &nbsp;&nbsp;&nbsp;&nbsp;<span><strong><div class="lowparam"><? echo $today->get_lowdew(); ?></div></strong>&nbsp;<img src="img/peak_min.png" width="15" height="14" alt="<? echo $LOW[$lang_idx]; ?>"/></span>&nbsp;<span class="low_time"><? echo $today->get_lowdew_time()." "; ?></span>
                             </div>
                           <!--<div class="paramtrend">
                                <div class="innertrendvalue">
                                <? echo getLastUpdateMin()." ".($MINTS[$lang_idx]).": ".get_img_tag($min15->get_dewchange(), true).abs($min15->get_humchange()).$tu; ?>
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
                                     <? echo get_img_tag($yestsametime->get_dewchange(), true).abs($yestsametime->get_dewchange());?>
                                      </div></div>
                                 </td>
                                 <td><div class="trendvalue"><div class="innertrendvalue">
                                            <? echo get_img_tag($oneHour->get_dewchange(), true).abs($oneHour->get_dewchange());?>
                                    </div></div>
                                 </td>
                                 <td><div class="trendvalue"><div class="innertrendvalue">
                                     <? echo get_img_tag($min30->get_dewchange(), true).abs($min30->get_dewchange());?>
                                    </div></div>
                                </td>
                            </tr>
                            </table>
                            </div>
							<div class="graphslink">
                                                       <?=$DEW_DESC[$lang_idx]?><br/>
								<a  href="<?=BASE_URL;?>?section=graph&amp;graph=dewptLatestArchive.php&amp;level=1&amp;freq=2&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>&amp;style=<?=$_GET["style"]?>" title=""><? echo $MORE_INFO[$lang_idx].get_arrow();?></a>
						   </div>
                        </div>
                        <div id="latestpressure" class="inparamdiv" <? if (isHeb()) echo "dir=\"rtl\" ";?>>
                            <div class="paramtitle slogan">
                                    <a  href="<?=BASE_URL;?>?section=graph&amp;graph=baro.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>"><? echo $BAR[$lang_idx];?></a>
                            </div>
                            <div id="pressure_value" class="paramvalue">
                                    <a href="<?=BASE_URL;?>?section=graph&amp;graph=baro.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>" class="info">
                                    <? echo $current->get_pressure()." <div class=\"param\">".$BAR_UNIT[$lang_idx]."</div>";?>
                                     </a>
                                     </div>
                            <div class="highlows">
                                     <span><strong><div class="highparam"><? echo $today->get_highbar(); ?></div></strong>&nbsp;<img src="img/peak_max.png" width="15" height="14" alt="<? echo $HIGH[$lang_idx]; ?>"/></span>&nbsp;<span class="high_time"><? echo $today->get_highbar_time()." "; ?></span>
                                    &nbsp;&nbsp;<span><strong><div class="lowparam"><? echo $today->get_lowbar(); ?></div></strong>&nbsp;<img src="img/peak_min.png" width="15" height="14" alt="<? echo $LOW[$lang_idx]; ?>"/></span>&nbsp;<span class="high_time"><? echo $today->get_lowbar_time()." "; ?></span>
                           </div>
                            <div class="trendstable">
                            <table>
                                <tr class="trendstitles">
                                        <td  class="box" title="<? echo($HOUR[$lang_idx]);?>"><img src="img/hour_icon.png" width="21" alt="24 <? echo $HOURS[$lang_idx];?>"/></td>
                                        <td  class="box" title="30<? echo($MINTS[$lang_idx]);?>"><img src="img/half_icon.png" width="21" alt="half hour"/></td>
                                        <td class="box" title="<? echo getLastUpdateMin().($MINTS[$lang_idx]);?>"><img src="img/quarter_icon.png" width="21" alt="quarter hour"/></td>
                                </tr>
                                <? echo "<tr class=\"trendsvalues\"  ><td><div class=\"trendvalue\"><div class=\"innertrendvalue\">".get_param_tag($oneHour->get_prschange(), true)."</div></div></td><td><div class=\"trendvalue\"><div class=\"innertrendvalue\">".get_param_tag($min30->get_prschange(), true)."</div></div></td><td><div class=\"trendvalue\"><div class=\"innertrendvalue\">".get_param_tag($min15->get_prschange(), true)."</div></div></td></tr>"; ?>
                            </table>
                            </div>
							<div class="graphslink">
								<a  href="<?=BASE_URL;?>?section=graph&amp;graph=baro.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>"><? echo $MORE_INFO[$lang_idx].get_arrow();?></a>
						   </div>
                        </div>
                        <div id="latestwebcam" class="inparamdiv" style="display:none">
                        </div>
                        <div id="latestwind" class="inparamdiv">
                                <div class="paramtitle slogan">
                                        <a  href="<?=BASE_URL;?>?section=graph&amp;graph=wind.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;style=<?=$_GET["style"]?>" title="" >
                                                        <? echo $WIND[$lang_idx];?>
                                        </a>
                                </div>
                                <div id="windvalue" class="paramvalue">
                                        <div id="winddir" class="paramunit">
                                                <a href="<?=BASE_URL;?>?section=graph&amp;graph=winddir.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;style=<?=$_GET["style"]?>"   title="<? echo $WIND_DIR[$lang_idx];?>">
                                                <?if (!stristr($current->get_winddir(),"---")&&($current->get_winddir() != "")){?>
                                                <div class="winddir <? echo $current->get_winddir(); ?>"></div>
                                                <?}?>
                                                </a>
                                        </div>
                                        <div  id="windspeed">
                                                <a href="<?=BASE_URL;?>?section=graph&amp;graph=wind.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;style=<?=$_GET["style"]?>" >
                                                <span class="<? if (isHeb()) echo "heb"; ?>"><? echo $current->get_windspd()." <div class=\"param\">".$KMH[$lang_idx]."</div>";?></span>
                                                </a>
                                        </div>
                                </div>
                                <div class="highlows">
                                        <span><strong><div class="highparam"><? echo $today->get_highwind(); ?></div></strong>&nbsp;<img src="img/peak_max.png" width="15" height="14" alt="<? echo $HIGH[$lang_idx]; ?>"/></span>&nbsp;<span class="high_time"><? echo $today->get_highwind_time()." "; ?></span>
                                </div>
                                <div class="paramtrend">
                                        <div class="">  
                                        <? echo " 10 ".$MINTS[$lang_idx]." ".$AVERAGE[$lang_idx].": <strong>".$min10->get_windspd()."</strong> ".$KMH[$lang_idx];?>
                                        </div>
                                </div>
                                        <div class="trendstable">	
                                <table>
                                <tr class="trendstitles">
                                                <td  class="box" title="<? echo($HOUR[$lang_idx]);?>"><img src="img/hour_icon.png" width="21" alt="hour" /></td>
                                                <td  class="box" title="30<? echo($MINTS[$lang_idx]);?>"><img src="img/half_icon.png" width="21" alt="half hour"/></td>
                                                <td class="box" title="<? echo getLastUpdateMin().($MINTS[$lang_idx]);?>"><img src="img/quarter_icon.png" width="21" alt="quarter hour"/></td>
                                </tr>
                                <? echo "<tr class=\"trendsvalues\" ><td><div class=\"trendvalue\"><div class=\"innertrendvalue\">".get_img_tag($oneHour->get_windspdchange(), true).abs($oneHour->get_windspdchange())."</div></div></td><td><div class=\"trendvalue\"><div class=\"innertrendvalue\">".get_img_tag($min30->get_windspdchange(), true).abs($min30->get_windspdchange())."</div></div></td><td><div class=\"trendvalue\"><div class=\"innertrendvalue\">".get_img_tag($min15->get_windspdchange(), true).abs($min15->get_windspdchange())."</div></div></td></tr>"; ?>
                                        </table>
                                        </div>
                                <div class="graphslink">
                                                <a href="<?=BASE_URL;?>?section=graph&amp;graph=wind.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;style=<?=$_GET["style"]?>" ><? echo $MORE_INFO[$lang_idx].get_arrow();?></a>
                                </div>
                        </div>
                        <div id="latestrain" class="inparamdiv" <? if (isHeb()) echo "dir=\"rtl\" ";?> title="<? echo $RAIN_RATE[$lang_idx]; ?>">
                            <div class="paramtitle slogan">
                                    <a  href="<?=BASE_URL;?>?section=graph&amp;graph=rain.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;style=<?=$_GET["style"]?>" title="">
                                            <? echo $RAIN_RATE[$lang_idx];?>
                                    </a>
                            </div>
                            <div id="rainratevalue" class="paramvalue">
                                    <a href="<?=BASE_URL;?>?section=graph&amp;graph=rain.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;style=<?=$_GET["style"]?>" title="">
                                            <? echo $current->get_rainrate2()." <div class=\"param\">".$RAINRATE_UNIT[$lang_idx]."</div>";?>
                                    </a> 
                            </div>
                            <div class="highlows">
                                <span><strong><div class="highparam"><? echo $today->get_highrainrate2(); ?></div></strong>&nbsp;<img src="img/peak_max.png" width="15" height="14" alt="<? echo $HIGH[$lang_idx]; ?>"/></span>&nbsp;<span class="high_time"><? echo $today->get_highrainrate2_time()." "; ?></span>
                            </div>
                            
                            <div class="trendstable">
                            <? echo $DAILY_RAIN[$lang_idx].":&nbsp;".$today->get_rain2();?>&nbsp;&nbsp;<br/>
                            <? echo $TOTAL_RAIN[$lang_idx].": ".$seasonTillNow->get_rain2()." ".$RAIN_UNIT[$lang_idx];?>
                             <table id="rainrate15min">
                            <tr class="trendstitles">
                                    <td  class="box" title="<? echo($HOUR[$lang_idx]);?>"><img src="img/hour_icon.png" width="21" alt="hour"/></td>
                                    <td  class="box" title="30<? echo($MINTS[$lang_idx]);?>"><img src="img/half_icon.png" width="21" alt="half hour"/></td>
                                    <td class="box" title="<? echo getLastUpdateMin().($MINTS[$lang_idx]);?>"><img src="img/quarter_icon.png" width="21" alt="quarter hour"/></td>
                            </tr>
                            <tr class="trendsvalues">
                                    <td><div class="trendvalue"><div class="innertrendvalue">
                                            <? echo get_img_tag($oneHour->get_rainratechange(), true).abs(round($oneHour->get_rainratechange())); ?>
                                            </div></div></td>
                                    <td><div class="trendvalue"><div class="innertrendvalue">
                                            <? echo get_img_tag($min30->get_rainratechange(), true).abs(round($min30->get_rainratechange())); ?>
                                    </div></div></td>
                                    <td ><div class="trendvalue"><div class="innertrendvalue">
                                            <? echo get_img_tag($min15->get_rainratechange(), true).abs(round($min15->get_rainratechange())); ?>

                                    </div></div>
                                        
                                    </td>
                            </tr>
                            </table>
                            </div>
                                                        
                            <div class="graphslink">
                                    <a  href="<?=BASE_URL;?>?section=graph&amp;graph=rain.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;style=<?=$_GET["style"]?>" title=""><? echo $MORE_INFO[$lang_idx].get_arrow();?></a>
                            </div>
                        </div>
                        <div id="latestradiation" class="inparamdiv" <? if (isHeb()) echo "dir=\"rtl\" ";?> title="<? echo $SUN[$lang_idx]; ?>">
                            <div class="paramtitle slogan">
                                    <a  href="<?=BASE_URL;?>?section=graph&amp;graph=rad.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;style=<?=$_GET["style"]?>" title="">
                                            <? echo $RADIATION[$lang_idx];?>
                                    </a>
                            </div>
                            <div id="sunvalues" class="paramvalue">
                                    <a href="<?=BASE_URL;?>?section=graph&amp;graph=rad.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;style=<?=$_GET["style"]?>" title="">
                                            <? echo $current->get_solarradiation()."<span class=\"paramunit\"> W/m2</span>";?>
                                    </a>
                            </div>
                            <div class="highlows">
                            <span><strong><div class="highparam"><? echo $today->get_highradiation(); ?></div></strong>&nbsp;<img src="img/peak_max.png" width="15" height="14" alt="<? echo $HIGH[$lang_idx]; ?>"/></span>&nbsp;<span class="high_time"><? echo $today->get_highradiation_time()." "; ?></span><br/>
                                <? echo $today->get_sunshinehours();?>
				<? echo $SUNSHINEHOURS[$lang_idx]." ".$TILL_NOW[$lang_idx];?> <br />
                               <? echo $RISE[$lang_idx]; ?>: <? echo $sunrise; ?>&nbsp;&nbsp;&nbsp;<? echo $SET[$lang_idx]; ?>: <? echo $sunset; ?>
                                
                            </div>
                            <div class="trendstable">
                            <table>
                            <tr class="trendstitles">
                                    <td  class="box" title="24 <? echo $HOURS[$lang_idx];?>"><img src="img/24_icon.png" width="21" alt="24 <? echo $HOURS[$lang_idx];?>"/></td>
                                    <td  class="box" title="30<? echo($MINTS[$lang_idx]);?>"><img src="img/half_icon.png" width="21" alt="half hour"/></td>
                                    <td class="box" title="<? echo getLastUpdateMin().($MINTS[$lang_idx]);?>"><img src="img/quarter_icon.png" width="21" alt="quarter hour"/></td>
                            </tr>
                            <tr class="trendsvalues" >
                                <td><div class="trendvalue"><div class="innertrendvalue">
                                    <? echo get_img_tag($yestsametime->get_srchange(), true).abs($yestsametime->get_srchange());?>
                                        </div></div></td>
                                <td><div class="trendvalue"><div class="innertrendvalue">
                                    <? echo get_img_tag($min30->get_srchange(), true).abs($min30->get_srchange());?>
                                </div></div></td>
                                <td><div class="trendvalue"><div class="innertrendvalue">
                                    <? echo get_img_tag($min15->get_srchange(), true).abs($min15->get_srchange());?>
                                </div></div></td>
                            </tr>
                            </table>
                            </div>
                            <div class="graphslink">
                                    <a  href="<?=BASE_URL;?>?section=graph&amp;graph=rad.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;style=<?=$_GET["style"]?>" title=""><? echo $MORE_INFO[$lang_idx].get_arrow();?></a>
                            </div>
                        </div>
                        <div id="chartjs-tooltip" class="inparamdiv" <? if (isHeb()) echo "dir=\"rtl\" ";?> style="display:none">
                        </div>
                        <div id="latestmoon" class="inparamdiv" <? if (isHeb()) echo "dir=\"rtl\" ";?>>
                                <div class="paramtitle slogan">
                                <? echo $MOON[$lang_idx];?>
                                </div>
                                <div class="moon_sun span2">
                                <div id="moon_rise" onclick="window.open('http://wise-obs.tau.ac.il/cgi-bin/eran/calen.html?MO=<? echo $month;?>&amp;YE=<? echo $year;?>&amp;TI=Wise+Observatory+Schedule&amp;LO=35.167&amp;LA=31.783&amp;TZ=<?=GMT_TZ?>&amp;PLACE=2');">
                                <div id="moon_img" class="float">
                                <a href="http://wise-obs.tau.ac.il/cgi-bin/eran/calen.html?MO=<? echo $month;?>&amp;YE=<? echo $year;?>&amp;TI=Wise+Observatory+Schedule&amp;LO=35.167&amp;LA=31.783&amp;TZ=<?=GMT_TZ?>&amp;PLACE=2" rel="external" title="<? echo $MORE_INFO[$lang_idx];?>">
                                                <?
                                                $moonurl = "images/moonriseset.png";
                                                /*
                                                if ($moon=="ne")
                                                {
                                                        echo $FULL_MOON[$lang_idx];
                                                        //update_action ("MoonFullNew", "<br/><b>".$FULL_MOON[$HEB]."</b><br/><img src=\"$moonurl\" width=\"50\">", $FULL_MOON);
                                                }
                                                else if ($moon=="ny") 
                                                {
                                                        echo $NEW_MOON[$lang_idx];
                                                }
                                                else echo $MOON[$lang_idx]." ".$TODAY[$lang_idx];*/
                                                ?>
                                                <img src="<?=$moonurl?>" width="40" height="40" alt="<? echo $MOON[$lang_idx];?>"/>
                                        </a>
                                </div>
                                <div class="float">
                                                &nbsp;<? echo $RISE[$lang_idx]; ?>:<br />&nbsp;<? echo $SET[$lang_idx]; ?>:
                                </div>
                                <div id="moonriseset_values" class="float">
                                                                                
                                </div>
                                </div>
                                
                                </div>               
                        </div>
                        <div id="latestuv" class="inparamdiv" <? if (isHeb()) echo "dir=\"rtl\" ";?> title="<? echo $SUN[$lang_idx]; ?>">
                            <div class="paramtitle slogan">
                                    <a  href="<?=BASE_URL;?>?section=graph&amp;graph=UVHistory.gif&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;style=<?=$_GET["style"]?>" title="">
                                            <? echo $UV[$lang_idx];?>
                                    </a>
                            </div>
                            <div id="uvvalues" class="paramvalue">
                                    <a href="<?=BASE_URL;?>?section=graph&amp;graph=UVHistory.gif&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;style=<?=$_GET["style"]?>" title="">
                                            <? echo $current->get_uv()." ";?>
                                   
                                    </a> 
                            </div>
                            <div class="highlows">
                                <span><strong><div class="highparam"><? echo $today->get_highuv(); ?></div></strong>&nbsp;<img src="img/peak_max.png" width="15" height="14" alt="<? echo $HIGH[$lang_idx]; ?>"/></span>&nbsp;<span class="high_time"><? echo $today->get_highuv_time()." "; ?></span>
                            </div>
                            <div class="trendstable">
                             <table>
                            <tr class="trendstitles">
                                    <td  class="box" title="24 <? echo $HOURS[$lang_idx];?>"><img src="img/24_icon.png" width="21" alt="24 <? echo $HOURS[$lang_idx];?>"/></td>
                                    <td  class="box" title="30<? echo($MINTS[$lang_idx]);?>"><img src="img/half_icon.png" width="21" alt="half hour"/></td>
                                    <td class="box" title="<? echo getLastUpdateMin().($MINTS[$lang_idx]);?>"><img src="img/quarter_icon.png" width="21" alt="quarter hour"/></td>
                            </tr>
                            <tr class="trendsvalues">
                                <td><div class="trendvalue"><div class="innertrendvalue">
                                    <? echo get_img_tag($yestsametime->get_uvchange(), true).abs($yestsametime->get_uvchange());?>
                                        </div></div></td>
                                <td><div class="trendvalue"><div class="innertrendvalue">
                                    <? echo get_img_tag($min30->get_uvchange(), true).abs($min30->get_uvchange());?>
                                </div></div></td>
                                <td><div class="trendvalue"><div class="innertrendvalue">
                                    <? echo get_img_tag($min15->get_uvchange(), true).abs($min15->get_uvchange());?>
                                </div></div></td>
                            </tr>

                            </table>
                            </div>
							<div class="graphslink">
								<a  href="<?=BASE_URL;?>?section=graph&amp;graph=UVHistory.gif&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;style=<?=$_GET["style"]?>" title=""><? echo $MORE_INFO[$lang_idx].get_arrow();?></a>
							</div>
                    </div>
                    <div id="latestairq" class="inparamdiv">
                        <div class="paramtitle slogan">
                            <?=$DUST[$lang_idx]?>
                        </div>
                        <div id="aqvalues">
                             <ul>
                             <li class="line"><ul><li></li><li></li><li class="dustexp"><?=$DUST_THRESHOLD1[$lang_idx]?></li><li class="dustexp"><?=$DUST_THRESHOLD2[$lang_idx]?></li></ul></li>
                             <li class="line" title="PM10 -> <? echo "&plusmn;".$current->get_pm10sd();?>"><ul><li><?=$DUSTPM10[$lang_idx]?></li><li><span class="number"><? echo $current->get_pm10();?></span>&nbsp;<span class="small">µg/m3</span></li><li>+130</li><li>+300</li></ul></li>
                             <li class="line" title="PM2.5 -> <? echo "&plusmn;".$current->get_pm25sd();?>"><ul><li><?=$DUSTPM25[$lang_idx]?></li><li><span class="number"><? echo $current->get_pm25();?></span>&nbsp;<span class="small">µg/m3</span></li><li>+38</li><li>+100</li></ul></li>
                             <li ><?=$DUST_THRESHOLD3[$lang_idx]?></li>
                             </ul>
                            
                                    
                        </div>
                        
                        <div class="trendstable">
                             <table>
                            <tr class="trendstitles">
                                    <td  class="box" title="24 <? echo $HOURS[$lang_idx];?>"><img src="img/24_icon.png" width="21" alt="24 <? echo $HOURS[$lang_idx];?>"/></td>
                                    <td  class="box" title="<? echo($HOUR[$lang_idx]);?>"><img src="img/hour_icon.png" width="21" alt="24 <? echo $HOURS[$lang_idx];?>"/></td>
                                    <td  class="box" title="30<? echo($MINTS[$lang_idx]);?>"><img src="img/half_icon.png" width="21" alt="half hour"/></td>
                                    
                            </tr>
                            <tr class="trendsvalues">
                                <td><div class="trendvalue"><div class="innertrendvalue">
                                    <? echo get_img_tag($yestsametime->get_pm10change(), true).abs($yestsametime->get_pm10change());?>
                                        </div></div></td>
                                <td><div class="trendvalue"><div class="innertrendvalue">
                                    <? echo get_img_tag($oneHour->get_pm10change(), true).abs($oneHour->get_pm10change());?>
                                </div></div></td>
                                <td><div class="trendvalue"><div class="innertrendvalue">
                                    <? echo get_img_tag($min30->get_pm10change(), true).abs($min30->get_pm10change());?>
                                </div></div></td>
                            </tr>

                            </table>
                            </div>
                        <div class="graphslink">
                            <a href="<? echo get_query_edited_url(get_url(), 'section', 'dust.php');?>" title="<? echo($FORECAST_TITLE[$lang_idx]." ".$FOR[$lang_idx]." ".$DUST[$lang_idx]); ?>"><? echo $MORE_INFO[$lang_idx].get_arrow();?></a>
                        </div>
                       
                    </div>
                    <div id="latestwindow" class="inparamdiv">
                        <div class="paramtitle slogan">
                        <? echo $YOU_BETTER[$lang_idx]." <span>";
                                echo isOpenOrClose();
                                echo " </span>".$THE_WINDOW[$lang_idx];?>
                                       
                        </div>
                        <div class="exp">
                                <div>
                                        <? echo $INSIDE[$lang_idx].": ".$current->get_intemp()." <br/ > ".$OUTSIDE[$lang_idx].": ".$current->get_temp();?>
                                </div>
                                <div>
                                        <? echo $PIVOT_DESC[$lang_idx]." ".$PIVOT_TEMP."<? echo $current->get_tempunit(); ?>"; ?>
                                </div>
                        </div>                      
                    </div>
                    <div id="latestotherstations" class="inparamdiv">
                        <div class="WUNowRes" id="WUNowRes_short"></div>
                        <div class="ImsNowRes" id="ImsNowRes_short"></div>
                        <div class="graphslink">
                                <a href="<? echo get_query_edited_url(get_url(), 'section', 'IsraelNow.php');?>" title=""><? echo $MORE_INFO[$lang_idx].get_arrow();?></a>
                        </div>
                    </div>
                    <div id="latestrunwalk" class="inparamdiv">
                        <div class="paramtitle slogan">
                                <?=$RUN_WALK[$lang_idx]?>
                        </div>
                        <div class="exp">
                        <ul id="sigrunwalkweather">
                                <li class="firstlinerunwalk"><?if ($current->get_solarradiation()>50) echo $MOUNTAIN[$lang_idx].":<span class=\"number\">".$current->get_temp()."</span>°&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$VALLEY[$lang_idx].":<span class=\"number\">".$current->get_temp2()."</span>°"; else echo $MOUNTAIN[$lang_idx].":<span class=\"number\">".$current->get_temp2()."°-".$current->get_temp()."°</span>&nbsp;&nbsp;&nbsp;&nbsp;".$VALLEY[$lang_idx].":<span class=\"number\">".$current->get_temp3()."°</span>"; ?></li>
                                <li class="itfeels"></li>
                                <?
                                //if (count($sigRun) > 2)
                                        for ($i = 1; $i < count($sigRun); $i++) {
                                        if ($i == 1) {$class = "class=\"windhumsituation\"";} else{$class = "";}                       
                                        echo "<li ".$class.">";
                                        echo "<a class=\"hlink\" title=\"\" href=\"".BASE_URL.$sigRun[$i]['url']."\" >{$sigRun[$i]['sig'][$lang_idx]} "." <br/> ".$sigRun[$i]['extrainfo'][$lang_idx][0]."</a></li>\n";          
                                } 
                                ?> 
                                </ul>            
                        </div>
                        <div class="graphslink">
                            <a href="<? echo get_query_edited_url(get_url(), 'section', 'runwalk.php');?>" title=""><? echo $MORE_INFO[$lang_idx].get_arrow();?></a>
                        </div>
                    </div>
                    <div class="inparamdiv" id="coldmetersurvey">
                            <div class="colmeterq">
                                <?=$HOTORCOLD_Q[$lang_idx];?>
                            </div>
                            
                            <div class="colmetercontainer">
                                <?
                                $result = getSurvey(2);
                                foreach ($result as $row) {
                                    print "\n\t\t<input name=\"survey\" onclick=\"toggle('genderchoose');$('#votechosen').val(".$row["field_id"].");$('#survey_id').val(2);\" class=\"coldmeterline color".($row["field_id"])."\" value=\"".get_name($row["field_name"])."\"";
                                    echo " />";
                                 
                                }
                                ?>
                                
                            </div>
                            
                            
                    </div>
                    <div class="inparamdiv" id="fseasonsurvey">
                            <div class="colmeterq">
                                <?=$FSEASON[$lang_idx];?>
                            </div>
                            
                            <div class="colmetercontainer">
                                <?
                                $result = getSurvey(1);
                                foreach ($result as $row) {
                                    print "\n\t\t<input name=\"survey\" onclick=\"toggle('genderchoose');$('#votechosen').val(".$row["field_id"].");$('#survey_id').val(2);\" class=\"coldmeterline color".($row["field_id"])."\" value=\"".get_name($row["field_name"])."\"";
                                    echo " />";
                                 
                                }
                                ?>
                                
                            </div>
                            
                            
                    </div>
                    <div id="genderchoose" style="display:none">
                    		<form method="post" action="<?=BASE_URL;?>?section=survey.php&amp;lang=<? echo $lang_idx;?>">
                                <div class="inv_plain_3_zebra float" style="margin:0em;width:200px;padding:1em;text-align:<? echo get_s_align(); ?>">
                                    <? if (isHeb()) echo "עוד משהו רציתי להגיד"; else echo "one more thing";?><br />
                                    <textarea name="comments" rows="4" <?if (isHeb()) echo " dir=\"rtl\"";?>  style="width:180px;height:50px"></textarea>
                                </div>
                    		<div class="inv_plain_3_zebra float" style="padding: 1em;text-align:<? echo get_s_align(); ?>" <? if (isHeb()) echo "dir=\"rtl\""; ?>><?=$GENDER[$lang_idx];?>: 
                                <input type="radio" value="m" name="gender" checked /><?=$MALE[$lang_idx];?>
                                <input type="radio" value="f" name="gender" /><?=$FEMALE[$lang_idx];?>
                                <input type="radio" value="" name="gender" /><?=$NOR_MALE_NOR_FEMALE[$lang_idx];?>
                                </div>
                                <div class="float clear" style="padding: 0.5em;margin:0em 2.5em;">
                                <input type="submit" class="slogan inv_plain_3_zebra big button"  style="padding: 0.5em;" name="SendSurveyButton" value="<? if (isHeb()) echo "הצבעה"; else echo "Vote"; ?>"/>
                                <input type="hidden" id="votechosen" name="survey" />
                                <input type="hidden" id="cm_current" name="cm_current" />
                                <input type="hidden" id="survey_id" name="survey_id" />
                                </div>
                                </form>
                    </div>
                        
		    </div> <!-- info circle -->
		    <ul id="bottombar" >
                            
                      </ul>
                    </div>
		    <ul id="seker_btns">
			<!--<li id="cold_btn" onclick="change_circle('cold_line', 'coldmetersurvey')" title="<?=$COLD_METER[$lang_idx]?>"><?=$HOTORCOLD_T[$lang_idx]?>                               
                        </li>-->
			
<!--			<li id="mood_btn" onclick="change_circle('-2200px', 'mood_line')">סקר מצב רוח</li>
			<hr id="mood_line"></hr>-->
			<li id="now_stuff" onmouseover="javascript:$('#more_sigweather').show();$('#sigweather').show();" onmouseout="javascript:$('#more_sigweather').hide();$('#sigweather').hide();">
                        <div id="what_is_h">
                        <a href="<? echo BASE_URL.$sig[0]['url'];?>" class="hlink"  title="<?echo $WHAT_ELSE[$lang_idx];?>">
			 	<? echo "{$sig[0]['sig'][$lang_idx]}"; ?>; 
				<div id="extrainfo"><? echo $sig[0]['extrainfo'][$lang_idx][0]; if ($sig[0]['extrainfo'][$lang_idx][0] != "") echo " ";?>&nbsp;<? if (count($sig) > 1) echo "<div class=\"high number\">&nbsp;".(count($sig)-1)."&nbsp;</div>&nbsp;<span class=\"arrow_down\">&#9660;</span>";?></div>
                         </a>
                         </div>
                           <ul id="more_sigweather" class="">
                                <li>
                                <ul id="sigweather">
                                <? if ($boolbroken) {?>
                                        <li class="">
                                                <div id="brokenlatesttemp"></div>
                                                <div id="brokenlatesthumidity"></div>
                                                <div id="brokenlatestpressure"></div>
                                                <div id="brokenlatestwind"></div>
                                                <div id="brokenlatestrainrate" ></div>
                                        </li>
                                <? } ?>
                                
                                <?
                                if (count($sig) > 1)
                                        for ($i = 1; $i < count($sig); $i++) {

                                        echo "<li>";
                                        echo "<a class=\"hlink\" style=\"font-weight:normal\" title=\"\" href=\"".BASE_URL.$sig[$i]['url']."\" >{$sig[$i]['sig'][$lang_idx]} "." - ".$sig[$i]['extrainfo'][$lang_idx][0].get_arrow()."</a></li>\n";          
                                } ?> 
                                </ul>
                                </li>
                           </ul>
                                                  
                        </li>
                        
			
		    </ul>
                            
                    <hr id="cold_line" />
                    <hr id="fseason_line" />
		</div>

    </div>
                 </article>
	       
<?    if ($error_update==true) {
echo "{$error_desc}";
}  

$height = 1000;
$width = "100%";

if ((first_page())||($template_routing=="frommobile"))                      
	include "prime.php";    
else {  ?>
<article id="section" style="<?if (stristr($template_routing, 'downld')) echo "width:1920";?>">
<? 
	if  (!stristr($template_routing, 'jpg'))
		echo "<div class=\"clear float \" id=\"print\" onclick=\"tpopup('print.php?".$_SERVER['QUERY_STRING']."')\"></div>";
	$include = true; 
         /* prevent Url injection  */
        if (stristr($template_routing, 'http'))
             $url = "BLOCKED FOR INCLUSION";
	else if  (stristr($template_routing, 'htm')||stristr($template_routing, 'php'))           
		$url = $template_routing;
  
	else if  (stristr(strtolower($template_routing), 'cam'))           
		$url = "webcam.php";
	else if  ((stristr($template_routing, 'jpg'))||(stristr($template_routing, 'gif')))            
		$url = "pic.php";
	else if  ($template_routing == "graph")            
		$url = "graph.php";         
	else if ($template_routing == "radiosonde")
	{
		$height = 800;
		$url = getRadioSondeLink(); 
		$include = false;
	}
	else if  ($template_routing == "metar")            
		$url = "http://weather.noaa.gov/pub/data/observations/metar/decoded/LLJR.TXT";
	else if  ((stristr($template_routing, 'txt'))||(stristr($template_routing, 'TXT')))	{
		if (stristr ($template_routing, $year))
			$template_routing  = "reports/NOAAYR.TXT";
		$url = $template_routing; 
		echo "<div align=\"left\" class=\"report\"><pre>";
	}
	else if ($template_routing == "chooseMonthYear") {         
		$url = "chooseHeader.php";
		$include = true;
	}
	else if ($template_routing == "Taf"){            
		$url = $taf_decoded; 
		$height = 800; 
		$include = false;
	}
	else if  ($template_routing == "radar"){
	   $url = $radar_link;
	   $height = 600;
	   $include = false;
	}        
	else if ($template_routing == "pics"){            
		$url = "images/spgm-1.3.2/index.php";  
		$include = false;
	}        
	else if ($template_routing == "animation"){            
		$url = $animation_link;            
		$include = false;
		$height = 480;
	}
	else if ($template_routing == "nearby"){            
		$url = "https://www.wunderground.com/stationmaps/gmap.asp?zip=00000&amp;wmo=40184&amp;lang=".$lang_idx;            
		$include = false;

	}
	else if ($template_routing == "dust"){            
		$url = "http://forecast.uoa.gr/LINKS/DUST/dload/anim.html";            
		$include = false;
	}
	else {            
		$url = $template_routing;             
		$include = false;
	}
	if ($_GET['height'] != "") 
		$height = $_GET['height']; 
	if ($_GET['width'] != "") 
		$width = $_GET['width'];
	if ($include)             
		include("{$url}");        
	else              
		//echo "<p>".get_file_string($url)."</p>";              
		echo "<iframe src=\"{$url}\" scrolling=\"auto\" id=\"iframemain\" class=\"base\" allowtransparency=\"true\" marginHeight=\"0\" marginWidth=\"0\" width=\"{$width}\" height=\"{$height}\" frameborder=\"0\" ></iframe>\n</td>"; 
	
	if  ((stristr($template_routing, 'txt'))||(stristr($template_routing, 'TXT')))
		echo "</pre></div>";
	if ($template_routing == "nearby"){            
		//set units to metric
		/*echo "<script language=\"JavaScript\" type=\"text/javascript\"image";
		echo "document.getElementById('iframe').location.href='http://www.wunderground.com/cgi-bin/findweather/getForecast?setunits=metric';";
		echo "</script>";*/
        }
        
	echo "<footer class=\"footer footerinsection\">Designed by <a target=\"_blank\" href=\"https://www.behance.net/galizorea\">Gali Zorea</a>, <a target=\"_blank\" href=\"javascript:void()\">Efrat Shiloach</a><br/>";	 
        echo "Icons made by <a href=\"https://www.flaticon.com/authors/alfredo-hernandez\" title=\"Alfredo Hernandez\">Alfredo Hernandez</a>, <a href=\"http://www.freepik.com/\" title=\"Freepik\">Freepik</a>, <a href=\"hhttps://creativemarket.com/eucalyp\" title=\"eucalyp\">eucalyp</a> from <a href=\"https://www.flaticon.com/\" title=\"Flaticon\"> www.flaticon.com</a>	";
        echo "</footer>";
        echo "</article>";	
			
} 
	
        
	?>   
	
        </div>
       
		 
        </div> <!-- /container -->
	<div id="chartjs-tooltip" class="inparamdiv" <? if (isHeb()) echo "dir=\"rtl\" ";?> style="display:none">
                    </div>	
        <?if (first_page()){?>
        <div id="bottom_bg">
                <div  id="bg_backHills"></div>
                <div id="bg_hills"></div>
                <div id="bg_map"></div>
                <div id="bg_grass"></div>
                <? if (!$current->is_light()) { ?> 
                <div id="stars"></div>
                <? }?>
       </div>
        <?}?>
	<!-- SNOW EFFECT-->
	<canvas id="canvas"></canvas>
	
		
	<!-- Parallax  midground clouds -->
	<div id="parallax-bg2">
        <div id="bg2-1" class="cloud3" style="display:none"><div class="cloud3-more"></div></div>
        <div id="bg2-4" class="cloud1" style="display:none"><div class="cloud1-more"></div></div>
        <div id="bg2-6" class="cloud4" style="display:none"><div class="cloud4-more"></div></div>
        <div id="bg2-7" class="cloud2" style="display:none"><div class="cloud2-more"></div></div>
	<div id="bg2-2" class="cloud4" style="display:none"><div class="cloud4-more"></div></div>
	<div id="bg2-8" class="cloud-big" style="display:none"><div class="cloud-big-more"></div></div>
        <div id="bg2-5" class="cloud-big" style="display:none"><div class="cloud-big-more"></div></div>
        <div id="bg2-9" class="cloud-big" style="display:none"><div class="cloud-big-more"></div></div>
        <div id="bg2-10" class="cloud-big" style="display:none"><div class="cloud-big-more"></div></div>					
       </div>
	
	<!-- Parallax  background clouds -->
	<div id="parallax-bg1">
	<div id="bg1-3" class="cloud4" style="display:none"><div class="cloud4-more"></div></div>
        <div id="bg1-4" class="cloud-big" style="display:none"><div class="cloud-big-more"></div></div>
        <div id="bg1-5" class="cloud3" style="display:none"><div class="cloud3-more"></div></div>
        <div id="bg1-6" class="cloud2" style="display:none"><div class="cloud2-more"></div></div>
        <div id="bg1-1" class="cloud4" style="display:none"><div class="cloud4-more"></div></div>
        <div id="bg1-2" class="cloud3" style="display:none"><div class="cloud3-more"></div></div>
        <div id="bg1-7" class="cloud-big" style="display:none"><div class="cloud-big-more"></div></div>
        <div id="bg1-8" class="cloud-big" style="display:none"><div class="cloud-big-more"></div></div>
        <div id="bg1-9" class="cloud-big" style="display:none"><div class="cloud-big-more"></div></div>
        <div id="bg1-10" class="cloud-big" style="display:none"><div class="cloud-big-more"></div></div>					
       </div>
        <div id="last_comments" style="display:none">
            <?
                /*foreach ($last_comments as $comment) {
                    echo $comment["comment"]." ";
                }*/
            ?>
            
        </div>
        <div id="mobile_redirect" class="big inv_plain_3_zebra" style="opacity:1;text-align:center;z-index:9999;display:none;position:absolute;top:50px;left:0px;width:400px;height:850px;margin:0 auto" >
        <button type="button" id="cboxCloseMobileRedirect" style="top:20px" class="close_icon" onclick="$( this ).parent().hide();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
        <br /><br /><br /><br />
        <h2 class="big inv_plain_2"><br /><a   onclick="redirect_to_mobile(<?=$lang_idx?>)" id="mobile_redirect_submit" class="clear inv_plain_3" style="width:100%"><?=$MOBILE_REDIRECT[$lang_idx].get_arrow()?></a><br /><br /></h2><br/><br/><br/>      
        <!--<h2 class="big inv_plain_2"><a   onclick="$( this ).parent().parent().hide();" class="clear inv_plain_3" style="width:100%"><?=$STAY[$lang_idx]?></a></h2><br/> <br/><br/><br/>-->  
        
        <div>
                <a href="https://play.google.com/store/apps/details?id=il.co.jws.app" target="_blank">
                        <img src="images/getitongp.svg" alt="Google play App" width="150" height="60"/>
                </a>
                </div>
                <div>
                <a href="https://apksfull.com/%D7%99%D7%A8%D7%95%D7%A9%D7%9E%D7%99%D7%99%D7%9D-il-co-jws-app/" target="_blank">
                APK
                </a>
                </div>
                <div>
                <a href="https://itunes.apple.com/us/app/yrwsmyym/id925504632?ls=1&mt=8" target="_blank">
                        <img src="images/Available_on_the_App_Store.svg" alt="App Store App" width="150" height="60"/>
                </a>
                </div>
        </div>
        <div style="display:none" class="loading"><img src="img/loading.gif" alt="loading" width="32" height="32" /></div>
        <input type="hidden" id="current_feeling" value="<?=$current_feeling?>"/>
        <input type="hidden" id="chosen_user_icon" value=""/>
                        <div style="display:none">
                        <div id="profileform" style="padding:0.5em" >
                            <div class="float">

                            <table>
                            <tr><td><?=$EMAIL[$lang_idx]?>:</td><td><input type="text" name="email" value="" readonly="readonly" id="profileform_email" size="30"/></td></tr>
                            <tr><td><?=$PASSWORD[$lang_idx]?>:</td><td><input type="password" name="password" value="" id="profileform_password"/></td></tr>
                            <tr><td><?=$USER_ICON[$lang_idx]?>:</td><td><div><div class="user_icon_frame">
                        <div id="user_icon_contentbox" class="contentbox-wrapper"> 
                             <? $user_icons = array(); $user_icons = array_reverse(getfilesFromdir("img/user_icon")); 
                             foreach ($user_icons as $user_icon) { ?>
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
                            <!--<tr><td><?=$NICE_NAME[$lang_idx]?>:</td><td><input type="text" name="user_nice_name" value="" id="profileform_nicename"/></td></tr>-->
                            </table>
                            <input type="checkbox" name="priority" value="" id="profileform_priority"/><?=$GET_UPDATES[$lang_idx]?><br />
                            <input type="checkbox" name="personal_coldmeter" value="" id="profileform_personal_coldmeter" disabled/><?=$PERSONAL_COLD_METER[$lang_idx]?><a href="javascript:void(0)" class="info">(?)<span class="info" style="top:-50px;<? echo get_s_align()?>:-100px"><?=$PERSONAL_COLD_METER_EXP[$lang_idx]?></span></a>
                            </div>


                            
                            <div id="profileform_result" class="float"></div>
                            <div style="clear:both;height:20px">&nbsp;</div>
                            <input type="submit" value="<?=$SEND[$lang_idx]?>" onclick="updateprofile_to_server(<?=$lang_idx?>)" id="profileform_submit" class=" clear inv_plain_3_zebra"/>
                            <input type="submit" value="<?=$DONE[$lang_idx]?>" onclick="$('#cboxClose').click();window.location.reload()" id="profileform_OK" class="info  inv_plain_3" style="display:none"/>


                         </div>

                        </div>
                         <div style="display:none">

                            <div id="loginform" style="padding:1em">
                                    <div class="float">
                                    <input type="text" placeholder="<?=$EMAIL[$lang_idx]?>" name="email" value="" id="loginform_email" size="30" tabindex="1" /><br /><br />
                                    <input type="password" placeholder="<?=$PASSWORD[$lang_idx]?>" name="password" value="" id="loginform_password" tabindex="2" size="15"/><br />&nbsp;&nbsp;
                                    <input type="checkbox" name="rememberme" value="" id="loginform_rememberme"/><?=$REMEMBER_ME[$lang_idx]?><br /><br />
                                    <a href="<?=BASE_URL?>/login_form.php?action=passforgotform" id="forgotpass" title="<?=$FORGOT_PASS[$lang_idx]?>"><?echo $FORGOT_PASS[$lang_idx].get_arrow();?></a><br />
                                    </div>
                                    <div style="display:none" class="float loading"><img src="img/loading.gif" alt="loading" width="32" height="32"/></div>
                                    <div id="loginform_result" class="float"></div>
                                    <div style="clear:both;height:30px">&nbsp;</div>
                                            <input type="submit" value="<?=$LOGIN[$lang_idx]?>" class="float clear inv_plain_3" onclick="login_to_server(<?=$lang_idx?>, <?=$limitLines?>, '<?=$_GET['update']?>')" id="loginform_submit"/>
                                    <input type="submit" value="Success!" onclick="$('#cboxClose').click();window.location.reload();" id="loginform_OK" class="info invfloat" style="display:none"/>

                            </div>
                            <div id="registerform" style="padding:0.5em">
                                <div id="registerinput" class="float">
                                <table>
                                <tr><td></td><td><input type="text" placeholder="<?=$EMAIL[$lang_idx]?>" name="email" value="" id="registerform_email" size="30" tabindex="3" style="direction:ltr"/></td></tr>
                                <tr><td></td><td><input type="password" placeholder="<?=$PASSWORD[$lang_idx]?>" name="password" value="" id="registerform_password" tabindex="4"/></td></tr>
                                <tr><td></td><td><input type="password" placeholder="<?=$PASSWORD_VERIFICATION[$lang_idx]?>" name="password_verif" value="" id="registerform_password_verif" tabindex="5"/></td></tr>
                                <tr><td></td><td><input type="text" name="username" placeholder="<?=$USER_ID[$lang_idx]?>" value="" id="registerform_userid" tabindex="6"/><a href="javascript:void(0)" class="info">(?)<span class="info" style="top:-50px;<?echo get_s_align();?>:-100px"><?=$USER_ID_EXP[$lang_idx]?></span></a></td></tr>
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
                                <tr><td></td><td><input type="text" placeholder="<?=$DISPLAY_NAME[$lang_idx]?>" name="user_display_name" value="" id="registerform_displayname" tabindex="7"/><a href="javascript:void(0)" class="info">(?)<span class="info" style="top:-50px;<?echo get_s_align();?>:-100px"><?=$DISPLAY_NAME_EXP[$lang_idx]?></span></a></td></tr>
                                <!--<tr><td></td><td><input type="text" placeholder="<?=$NICE_NAME[$lang_idx]?>" name="user_nice_name" value="" id="registerform_nicename" tabindex="8"/><a href="javascript:void(0)" class="info">(?)<span class="info" style="top:-50px;<?echo get_s_align();?>:-100px"><?=$NICENAME_EXP[$lang_idx]?></span></a></td></tr>-->
                                </table>
                                <input type="checkbox" name="priority" value="" id="registerform_priority"/><?=$GET_UPDATES[$lang_idx]?><br />
                                <input type="checkbox" name="personal_coldmeter" value="" id="registerform_personal_coldmeter" disabled/><?=$PERSONAL_COLD_METER[$lang_idx]?><a href="javascript:void(0)" class="info">(?)<span class="info" style="top:-50px;<?echo get_s_align();?>:-100px"><?=$PERSONAL_COLD_METER_EXP[$lang_idx]?></span></a>
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

<? if (isRaining()) {?>
<audio autoplay>
        <source src="sound/rain/RAINFIBL.mp3"></source>
</audio>
<? }
//////////////////////////////////////////////////////////////////
if ($boolbroken)
{
        //logger("intended to print broken record: count=".count($messageBroken)." ");
	for ($i=0 ; $i < count($messageBroken) ; $i++)
	{
		echo $messageBroken[$i][$lang_idx];
	}
}
?>
<!-- Default Statcounter code for Jerusalem Weather Station
http://02ws.co.il -->
<script type="text/javascript">
var sc_project=548696; 
var sc_invisible=1; 
var sc_security=""; 
</script>
<script type="text/javascript"
src="https://www.statcounter.com/counter/counter.js"
async></script>
<noscript><div class="statcounter"><a title="Web Analytics
Made Easy - StatCounter" href="https://statcounter.com/"
target="_blank"><img class="statcounter"
src="https://c.statcounter.com/548696/0//1/" alt="Web
Analytics Made Easy - StatCounter"></a></div></noscript>
<!-- End of Statcounter Code -->
<!-- Grab Google CDN's jQuery. fall back to local if necessary --> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script> 
<script>!window.jQuery && document.write('<script src="/js/jquery-1.6.1.min.js"><\/script>')</script>
<script type="text/javascript">
var lang=<?=$lang_idx?>;
</script>
<?if (first_page()){?>
<script src="js/parallax.js"></script>
<?}?>

 <? if (isRaining()&&(!isSnowing())){ ?>
<script src="js/rain.js"></script>
<? }?>
<? if (isSnowing()) { ?>
<script src="js/snow.js"></script>
<? }?>
<script src="js/tinymce/tinymce.min.07032017.js"></script>
<script src="js/modernizr.custom.37797.js"></script> 
<script src="footerScripts011221.php?lang=<?=$lang_idx?>&temp_unit=<?echo $current->get_tempunit();?>&guid=<?=$_GET['guid']?>"  type="text/javascript"></script>
<script type="text/javascript">
/* <![CDATA[ */
<? if ($current->get_cloudiness() > 2) {?>
        $("#bg2-1").show();
        $("#bg2-4").show();
        $("#bg2-6").show();
        $("#bg2-7").show();
        $("#bg1-3").show();
        $("#bg1-4").show();
        $("#bg1-5").show();
        $("#bg1-6").show();
        
<?}?>
<? if ($current->get_cloudiness() > 5) {?>
        $("#bg2-2").show();
        $("#bg2-8").show();
        $("#bg1-1").show();
        $("#bg1-2").show();
        $("#bg1-7").show();
        $("#bg1-8").show();

<?}?>
<? if ($current->get_cloudiness() > 6) {?>
        $("#bg2-5").show();
        $("#bg2-9").show();
        $("#bg2-10").show();
        $("#bg1-9").show();
        $("#bg1-10").show();
<?}?>
    mj = mjd(<? echo $day;?>, <? echo $month;?>, <? echo $year;?>, 0.0);
    var mrs = find_moonrise_set(mj, <?=GMT_TZ?>, 35.2, 31.7);
    var div_moon = document.getElementById('moonriseset_values');
    if (div_moon != null)
            div_moon.innerHTML = mrs;
    <?if (first_page()){?>
       if( isMobile.any() ){
              // window.location.replace('https://www.02ws.co.il/small.php?size=l&amp;lang='+lang);
           }
    <?}?>
    startup(<?=$lang_idx?>, <?=$limitLines?>, "<?=(isset($_GET['update'])?$_GET['update']:'')?>");
    if (isUserAdApproved){
         $("#mainadsense").hide();
    }

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
                console.error ('error in refreshContent:' + e);
        }
        });
    }
    
    setInterval(refreshContent, 60000);
    
/* ]]> */
</script>
<script>
    var apiKey = "83b355eb58c30fd0b8dae36a4e47877706609da9";
    var storeId = "0E3C23CCEEFF44";
</script>
<!-- <script type="text/javascript" src="ajaxEmail.js"></script>
        <script type="text/javascript">
                // startEmailService(message_from, message_subject, message_body, target , info_back)
                var messageBody = escape(encodeURI("<?=$messageToSend?>"));
                var message_action = escape(encodeURI("<?=$actionActive?>"));
                <? echo "startEmailService(escape(encodeURI('".EMAIL_ADDRESS."')) , escape(encodeURI('02ws Update Service')) , messageBody , 'ALL' , false, message_action);"; ?>
        </script> -->
</body>
</html>
<? if (($_GET['debug'] == '')||(!$error_update)) include "end_caching.php"; ?>