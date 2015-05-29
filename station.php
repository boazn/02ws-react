<?
header('Content-type: text/html; charset=utf-8');
//ini_set("display_errors","On");
if ($_GET['debug'] == '')
    include "begin_caching.php";
set_include_path(get_include_path() . PATH_SEPARATOR . "/home/boazn/02ws.com/public". PATH_SEPARATOR ."./");
include_once("include.php"); 
include_once("start.php");
include_once("requiredDBTasks.php");
include_once "sigweathercalc.php";
include_once("forecastlib.php");

?>
 <!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <title><? echo getPageTitle()?></title>
        <meta name="description" content="<? if (isHeb()) {?>מתעדכן כל דקה מתחנה פיזית על הגג. תחזית ל-24 שעות, לימים הבאים , ארכיון וכל מה שרצית לדעת<?} else {?>What is the weather in Jerusalem, Israel? Here you have 6 days forecast, current significant conditions, live pictures, weather graphs,  detailed archive and much more. This is online weather station which updates every minute. <?} ?>"/>
        <meta name="keywords" content="climate, forecast, weather, jerusalem תחזית מזג אויר , אקלים, שלג, ממוצע, ארכיון"/>
        <meta name="author" content="Boaz" />
	<meta property="og:image" content="http://www.02ws.co.il/02ws_shor.tpng?r=<?=time()?>" />
        <meta property="og:image:width" content="1200" />
        <meta property="og:image:height" content="628" />
        <meta property="og:description" content="<? echo "{$sig[0]['sig'][$lang_idx]}"; ?>" /> 
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
        <link rel="stylesheet" href="css/bootstrap<?=$lang_idx; ?>.css" type="text/css" >
	<!--<link rel="stylesheet" href="css/bootstrap-responsive.min.css">
	<link rel="stylesheet" href="css/bootstrap-responsive.css">-->
        <style>
            body {
                padding-top: 40px;
                padding-bottom: 40px;
            }
        </style>
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
        <link rel="icon" type="image/png" href="img/favicon_sun.png">
         <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-647172-1', 'auto');
            ga('send', 'pageview');

        </script>
    </head>
    <body>
        <!--[if lt IE 9 ]>	
	<div class="topbase" id="topmessage" class="big" style="z-index:9999">
        Please update you browser. The site does not support internet explorer 6-8.<br /><br />אנא עדכן את הדפדפן<a href="http://www.mozilla.com"><img border="0" alt="Firefox 3" title="Firefox 3" src="http://sfx-images.mozilla.org/affiliates/Buttons/firefox3/120x240.png" /></a>
	<a href="http://www.google.com/chrome/"><img src="http://www.techdigest.tv/assets_c/2009/02/google-chrome-logo-thumb-300x300-75857.jpg" alt="Chrome" width="150px"></a>
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
			    <li><a href="javascript:void(0)" ><? echo $WHAT_ELSE[$lang_idx];?>&nbsp;<? if (count($sig) > 2) echo "<span class=\"invhigh\">&nbsp;".(count($sig)-1)."&nbsp;</span>";?>&nbsp;<span class="arrow_down">&#9660;</span></a>
                                    <ul style="<?echo get_s_align();?>: -2em;">
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
                                                                for ($i = 0; $i < count($sig); $i++) {

                                                                echo "<li>";
                                                                echo "<a class=\"hlink\" style=\"font-weight:normal\" title=\"\" href=\"{$sig[$i]['url']}\" >{$sig[$i]['sig'][$lang_idx]} "." - ".$sig[$i]['extrainfo'][$lang_idx].get_arrow()."</a></li>\n";          
                                                        } ?>
                                                        <li>
                                                                <a href="<? echo get_query_edited_url($url_cur, 'section', 'radar.php');?>">
                                                                        <? echo $RAIN_RADAR[$lang_idx].get_arrow();?>
                                                                </a>
                                                        </li>
                                                        <li>
                                                                <a href="http://www.sat24.com/en/is?ir=true" title="<? echo  $SATELLITE[$lang_idx];?>" rel="external">		
                                                                        <? echo  $SATELLITE[$lang_idx].get_arrow();?>
                                                                </a>
                                                        </li>
                                                        <li>										
                                                                        <? if (!$error_db){ $licount = $licount + 1;?>
                                                                        <a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph&amp;graph=RainHistory.gif&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>" title="<? echo $TILL_NOW[$lang_idx].": ".$seasonTillNow->get_rain()." ; ".$NORMAL[$lang_idx]." ".$TILL_NOW[$lang_idx].": ".$averageTillNow->get_rain();?>">
                                                                            <? if ($daysWithoutRain >= 4){ echo $daysWithoutRain." ".$DAYS_WITHOUT_RAIN[$lang_idx]." - "; } ?>  
                                                                                <? echo " <span>";
                                                                                 if ($seasonTillNow->get_raindiffav() > 0) echo $LEFTOVER[$lang_idx]; else echo $LACK[$lang_idx];
                                                                                 echo " ".round(abs($seasonTillNow->get_raindiffav()))." ".$RAIN_UNIT[$lang_idx]."</span>"; ?><?=get_arrow()?>
                                                                        </a>
                                                                        <? } ?>
                                                        </li>
                                                   <li id="airqli">
                                                                        <span id="airqtitle">
                                                                                <a href="<?=$airq_link?>" rel="external"><? echo $AIR_QUALITY[$lang_idx]; ?><?=get_arrow()?></a>
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
                                                                                        <a class="hlink" href="http://en.wikipedia.org/wiki/Haines_Index" target="_blank">
                                                                                                        <?echo $FIRE_INDEX[$lang_idx];?>
                                                                                                        <?SortIndex ("", $FireIdx."", 4 , 5 , 6 , true, true);?>
                                                                                        </a>

                                                                        </li>
                                                                        <? }
                                                                }*/
                                                                ?>
                                                    <li>
                                                        <a class="hlink" href="<? echo get_query_edited_url($url_cur, 'section', 'openclosewindow.php');?>" title="<? echo $INSIDE[$lang_idx].": ".$current->get_intemp()." ; ".$OUTSIDE[$lang_idx].": ".$current->get_temp();?>">
                                                                <? echo $YOU_BETTER[$lang_idx]." <span>";
                                                                 echo isOpenOrClose();
                                                                         echo " </span>".$THE_WINDOW[$lang_idx];?><?=get_arrow()?>
                                                                </a>
                                                        </li>
                                                        <li><a href="JWSBanner.html" class="hlink"><? echo $BANNER_FLASH_VIEW[$lang_idx];?></a></li>
                                                        <li>
                                                                <a class="hlink" href="<? echo get_query_edited_url(get_url(), 'section', 'radiosonde.php');?>" title="<?echo $STORM_POWER[$lang_idx];?>">
                                                                        <? echo $CURRENT_ENERGY[$lang_idx];?><?=get_arrow()?>
                                                                </a>
                                                        </li>
                                                        <li><a class="hlink" href="http://www.svivaaqm.net/DynamicTable.aspx?G_ID=14" title="Additional stations in Jerusalem עוד תחנות בי-ם" rel='external' >
                                                                                                                 <?  echo $STATIONS_NEARBY[$lang_idx]; ?><?=get_arrow()?></a>
                                                        </li>
                                                        <li><a class="hlink" href="http://www.wunderground.com/stationmaps/gmap.asp?zip=00000&amp;wmo=40184" title="Nearby stations עוד תחנות באזור" rel='external' >
                                                                <?  echo $WEATHER_NEARBY[$lang_idx]; ?><?=get_arrow()?></a>
                                                        </li>
                                                        <!-- Global Warming -->
                                                        <li >
                                                                <a class="hlink" href="<? echo get_query_edited_url(get_url(), 'section', 'globalwarm.php');?>" onmouseover="toggle('globalwarmanomaly')" onmouseout="toggle('globalwarmanomaly')"><? echo $GLOBAL_WARMING[$lang_idx]; ?>:<span dir="ltr">
                                                                        <?	
                                                                           $gw =  number_format(apc_fetch('avganomaly'), 2, '.', '');
                                                                           $gw_plus_minus = $gw >= 0 ? "+" : "";
                                                                           echo $gw_plus_minus.$gw;
                                                                           echo $current->get_tempunit(); ?>
                                                                        </span><?=get_arrow()?></a>
                                                                </li>

                                                        <!-- End Global Warming -->
                                                        <li><a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=models.php&amp;model=&amp;hours=24&amp;lang=<? echo $lang_idx;?>" class="hlink"><? echo $MODELS[$lang_idx];?><?=get_arrow()?></a></li>
                                                        <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'lightning.php');?>" class="hlink"><? echo $LIGHTS[$lang_idx];?><?=get_arrow()?></a></li>
                                                        <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'radiosonde.php');?>" class="hlink"><? echo $RADIOSONDE[$lang_idx];?><?=get_arrow()?></a></li>
                                                        <li><a href="http://www.kineret.org.il" class="hlink" rel="external"><? echo $KINNERET[$lang_idx];?><?=get_arrow()?></a></li>
                                   </ul>
                             </li>
                            <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'chooseMonthYear');?>" title="<? echo $HISTORY[$lang_idx].", ".$YESTERDAY[$lang_idx].", ".$CHOOSE[$lang_idx]."...";?>"><? echo $WHAT_HAPPEND[$lang_idx];?>&nbsp;<span class="arrow_down">&#9660;</span></a>
                                    <ul style="<?echo get_s_align();?>: -2em;">
                                        <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'yesterday.php');?>" class="hlink"> <? echo $YESTERDAY[$lang_idx];?><?=get_arrow()?></a></li>
                                                        <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'averages.php');?>" class="hlink"><? echo $YEARLY_AVERAGE[$lang_idx];?><?=get_arrow()?></a></li>  
                                                        <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'reports/downld02.txt');?>" class="hlink"> <? echo $DETAILED_TABLE[$lang_idx];?><?=get_arrow()?></a></li>
                                                        <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'reports/downld08.txt');?>" class="hlink"> <? echo $DETAILED_TABLE08[$lang_idx];?><?=get_arrow()?></a></li>
                                                        <li><a href="<? echo get_query_edited_url($url_cur, 'section', FILE_THIS_MONTH);?>" ><? echo $monthInWord." ".$year." - ".$SUMMARY[$lang_idx]; ?><?=get_arrow()?></a></li>
                                                        <li><a href="<? echo get_query_edited_url($url_cur, 'section', FILE_THIS_YEAR);?>" ><? echo $year." - ".$SUMMARY[$lang_idx]; ?><?=get_arrow()?></a></li>    
                                                        <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'chooseMonthYear');?>" ><? echo $CHOOSE[$lang_idx]; ?><?=get_arrow()?></a></li>
                                                        <li><a href="<? echo get_query_edited_url($url_cur, 'section', '2weeks.php');?>" class="hlink"><? echo $ALL_GRAPHS[$lang_idx]." - ".$LAST_WEEK[$lang_idx];?><?=get_arrow()?></a></li>
                                                        <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'month.php');?>" class="hlink"><? echo $ALL_GRAPHS[$lang_idx]." - ".$LAST_MONTH[$lang_idx];?><?=get_arrow()?></a></li>
                                                        <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'allTimeRecords.php');?>" class="hlink" title="<?=$RECORDS_LINK[$lang_idx];?>"><? echo $RECORDS[$lang_idx];?><?=get_arrow()?></a></li>
                                                        <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'RainSeasons.php');?>" class="hlink">150 <? echo $RAIN_SEASONS[$lang_idx];?><?=get_arrow()?></a></li>
                                                        <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'radar.php');?>"><? echo $RAIN_RADAR[$lang_idx]." - ".$ARCHIVE[$lang_idx].get_arrow();?></a></li>
                                                        <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'browsedate.php');?>" class="hlink"><? echo $ARCHIVE[$lang_idx];?><?=get_arrow()?></a></li>
                                                        <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'reports.php');?>" class="hlink"><? echo $REPORTS[$lang_idx];?><?=get_arrow()?></a></li>
                                                        <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'snow.php');?>" class="hlink"><? echo $SNOW_JER[$lang_idx];?><?=get_arrow()?></a></li>
                                                        <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'climate.php');?>" title="<? echo $CLIMATE_TITLE[$lang_idx];?>" class="hlink"><? echo $CLIMATE[$lang_idx];?><?=get_arrow()?></a></li>
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
								<input value="<?=$SIGN_OUT[$lang_idx]?>" onclick="signout_from_server(<?=$lang_idx?>, <?=$limitLines?>, '<?=$_GET['update']?>')" id="signout" class="button inv_plain_3_zebra"/>
							</div>
						</li>
					  </ul>
				  </li>
				          
			 </ul>
                         
				<form class="searchForm" action="<? echo get_query_edited_url($url_cur, 'section', 'search.php');?>" id="cse-search-box">
				  <div>
					<input type="hidden" name="section" value="search.php" />
					<input type="hidden" name="cx" value="partner-pub-2706630587106567:b8ng7y2q8ny" />
					<input type="hidden" name="cof" value="FORID:11" />
					<input type="hidden" name="ie" value="UTF-8" />
					<input class="search-query" name="q" size="24" maxlength="255" value=""/>
					<input type="submit" name="sa" value=""/>
				  </div>
				</form>
				<script type="text/javascript" src="http://www.google.co.il/cse/brand?form=cse-search-box&amp;lang=iw"></script>
			
			
                         <? if ($lang_idx == 1) {?>
								<p id="english"><a href="#" title="switch to english" onclick="changeLang('0')">English</a></p>
								<?} 
								else {?>
								<p id="hebrew"><a href="#" onclick="changeLang('1')" title="switch to hebrew">עברית</a></p>
				<?} ?>
                         <? if ((!isHeb())&&(first_page())) {?>
				<div dir="ltr" class="il_image" id="tempunitconversion">
				<form method="post" action="<?=$_SERVER['SCRIPT_NAME'];?>?lang=<? echo $lang_idx;?>&amp;tempunit=<? if ($current->get_tempunit() == '&#176;c') echo 'F'; else echo 'c';?>" id="tempconversion">
					<input type="hidden" name="tocorf" value="<? if ($current->get_tempunit() == '&#176;C') echo '&#176;F'; else echo '&#176;C';?>" /> 
					<?  if ($current->get_tempunit() == '&#176;F') { ?>
					<a href="javascript:void(0)" onclick="document.getElementById('tempconversion').submit();">&#176;C</a>
					<?  } else { ?>
					&#176;C
					<?  } ?>
					| 
					<?  if ($current->get_tempunit() == '&#176;c') { ?>
					<a href="javascript:void(0)" onclick="document.getElementById('tempconversion').submit();">&#176;F</a>
					<?  } else { ?>
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
            <div id="slogan">
                <span><? echo $SLOGAN[$lang_idx];?></span>&nbsp;&nbsp;
               <? echo $ELEVATION[$lang_idx]." ".ELEVATION." ".$METERS[$lang_idx]; ?>&nbsp;&nbsp;
               <span <? if (time() - filemtime($fulldatatotake) > 3600) echo "class=\"high afont\"";?>>
               <? if (isHeb()) echo $dateInHeb; else echo $date;?>
               </span>
               <div id="addthis_icon" class="addthis_toolbox addthis_default_style"><a class="addthis_button_compact"><?=$SHARE[$lang_idx];?></a></div>
               <div id="fb_like" class="invfloat">
            	 <iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2Fpages%2FJerusalem-Israel%2F02ws-yrwsmyym-mzg-hwwyr-bzmn-mt%2F118726368187010&amp;layout=button_count&amp;show_faces=true&amp;width=100&amp;action=like&amp;colorscheme=light&amp;height=21" style="border:none; overflow:hidden; width:100px; height:21px;allowTransparency:true"></iframe>
                         
                </div> 
               <ul id="ftr_icons" class="invfloat">
                    <li><a href="rss_forecast.php<?echo "?lang=".$lang_idx;?>" id="rss"></a></li>
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
						<a class="more" href="#more"><?=$WHAT_MORE[$lang_idx]?></a>
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
			<div class="not_fixed_nav span2">
				<div id="logo">
                                    <a href="<? echo BASE_URL.substr(strrchr($_SERVER["PHP_SELF"], "/"), 0)."?lang=".$lang_idx;?>" >&nbsp;&nbsp;&nbsp;</a>
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
		<div class="main_info span6 offset3">
		    <ul class="info_btns">
                            
			    <li id="now_btn" onclick="change_circle('now_line', 'latestnow')"></li>
			     
			    <li id="temp_btn" onclick="change_circle('temp_line', 'latesttemp')" title="<? echo $TEMP[$lang_idx];?>"></li>
			    
			    <li id="moist_btn" onclick="change_circle('moist_line', 'latesthumidity')" title="<? echo $HUMIDITY[$lang_idx];?>"></li>
			    
			    <li id="air_btn" onclick="change_circle('air_line', 'latestpressure')" title="<? echo $BAR[$lang_idx];?>"></li>
			    
			    <li id="wind_btn" onclick="change_circle('wind_line', 'latestwind')" title="<? echo $WIND[$lang_idx];?>"></li>
			    
			    <li id="rain_btn" onclick="change_circle('rain_line', 'latestrain')" title="<? echo $RAIN[$lang_idx];?>"></li>
			    
			    <li id="rad_btn" onclick="change_circle('rad_line', 'latestradiation')" title="<? echo $RADIATION[$lang_idx];?>"></li>
			    
			    <li id="uv_btn" onclick="change_circle('uv_line', 'latestuv')" title="<? echo $UV[$lang_idx];?>"></li>
			    
                            <li id="aq_btn" onclick="change_circle('aq_line', 'latestairq')" title="<? echo $AIR_QUALITY[$lang_idx];?>"></li>
                            
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
		    <div id="info_circle">
                        <div id="latestnow" class="inparamdiv">
                            <div  id="windy">
                            <? echo getWindStatus($lang_idx);?>
                            </div>
                             <?
                                if (min($current->get_windchill(), $current->get_thw()) < ($current->get_temp()) && $current->get_temp() < 23 ){ ?>
                                        <div id="itfeels_windchill"> 
                                         <a title="<?=$WIND_CHILL[$lang_idx]?>" href="<? echo $_SERVER['SCRIPT_NAME']; ?>?section=graph.php&amp;graph=tempwchill.php&amp;profile=1&amp;lang=<?=$lang_idx?>"> 
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
                                <? echo $current->get_temp();?><span class="paramunit"><? echo $current->get_tempunit(); ?></span>
                           </div>
                            <div id="status">
				<? if (isSnowing()) echo $ITS_SNOWING[$lang_idx]." "; else if (isRaining()) echo $ITS_RAINING[$lang_idx]." ";?>
			<div  id="coldmeter">
			<a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=survey.php&amp;survey_id=2&amp;lang=<? echo $lang_idx;?>"> <span id="current_feeling_link" title="<?=$HOTORCOLD_T[$lang_idx]?> - <?=$COLD_METER[$lang_idx]?>">...</span>
			</a>
			</div>
			</div>		
			</div>
                     
                      <div id="latesttemp" class="inparamdiv">
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
                                                <td  class="box" title="24 <? echo $HOURS[$lang_idx];?>"><img src="img/24_icon.png" width="21" alt="24 <? echo $HOURS[$lang_idx];?>"/></td>
                                                <td  class="box" title="<? echo($HOUR[$lang_idx]);?>"><img src="img/hour_icon.png" width="21" alt="hour"/></td>
                                                <td  class="box" title="30<? echo($MINTS[$lang_idx]);?>"><img src="img/half_icon.png" width="21" alt="half hour"/></td>
                                        </tr>
                                        <tr class="trendsvalues"><td><div class="trendvalue"><div class="innertrendvalue"> <? echo get_param_tag($yestsametime->get_tempchange())."</div></div></td><td ><div class=\"trendvalue\"><div class=\"innertrendvalue\">".get_param_tag($oneHour->get_tempchange())."</div></div></td><td ><div class=\"trendvalue\"><div class=\"innertrendvalue\">".get_param_tag($min30->get_tempchange()); ?></div></div></td></tr>
                                </table>
                           </div>
						   <div class="graphslink">
								<a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=temp.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>&amp;style=<?=$_GET["style"]?>" title=""><img src="img/graph_icon.png" alt="to graphs"/></a>
						   </div>
			</div>
                        <div id="latesthumidity" class="inparamdiv" <? if (isHeb()) echo "dir=\"rtl\" ";?>>
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
                                    <td  class="box" title="24 <? echo $HOURS[$lang_idx];?>"><img src="img/24_icon.png" width="21" alt="24 <? echo $HOURS[$lang_idx];?>"/></td>
                                    <td  class="box" title="<? echo($HOUR[$lang_idx]);?>"><img src="img/hour_icon.png" width="21" alt="hour"/></td>
                                    <td  class="box" title="30<? echo($MINTS[$lang_idx]);?>"><img src="img/half_icon.png" width="21" alt="half hour"/></td>
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
								<a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=humwind.php&amp;level=1&amp;freq=2&amp;datasource=downld02&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>&amp;style=<?=$_GET["style"]?>" title=""><img src="img/graph_icon.png" alt="to graphs"/></a>
						   </div>
                        </div>
                        <div id="latestpressure" class="inparamdiv" <? if (isHeb()) echo "dir=\"rtl\" ";?>>
                            <div class="paramtitle slogan">
                                    <a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=baro.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>"><? echo $BAR[$lang_idx];?></a>
                            </div>
                            <div id="pressure_value" class="paramvalue">
                                    <a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=baro.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>" class="info">
                                    <? echo $current->get_pressure()." <span class=\"paramunit\">".$BAR_UNIT[$lang_idx]."</span>";?>
                                     </a>
                                     </div>
                            <div class="highlows">
                                     <span><strong><? echo $today->get_highbar(); ?></strong>&nbsp;<img src="img/peak_max.png" width="15" height="14" alt="<? echo $HIGH[$lang_idx]; ?>"/>&nbsp;<? echo $today->get_highbar_time()." "; ?></span>
                                    &nbsp;&nbsp;<span><strong><? echo $today->get_lowbar(); ?></strong>&nbsp;<img src="img/peak_min.png" width="15" height="14" alt="<? echo $LOW[$lang_idx]; ?>"/>&nbsp;<? echo $today->get_lowbar_time()." "; ?></span>
                           </div>
                            <div class="trendstable">
                            <table>
                                <tr class="trendstitles">
                                        <td  class="box" title="<? echo($HOUR[$lang_idx]);?>"><img src="img/hour_icon.png" width="21" alt="24 <? echo $HOURS[$lang_idx];?>"/></td>
                                        <td  class="box" title="30<? echo($MINTS[$lang_idx]);?>"><img src="img/half_icon.png" width="21" alt="half hour"/></td>
                                        <td class="box" title="<? echo getLastUpdateMin().($MINTS[$lang_idx]);?>"><img src="img/quarter_icon.png" width="21" alt="quarter hour"/></td>
                                </tr>
                                <? echo "<tr class=\"trendsvalues\"  ><td><div class=\"trendvalue\"><div class=\"innertrendvalue\">".get_param_tag($oneHour->get_prschange())."</div></div></td><td><div class=\"trendvalue\"><div class=\"innertrendvalue\">".get_param_tag($min30->get_prschange())."</div></div></td><td><div class=\"trendvalue\"><div class=\"innertrendvalue\">".get_param_tag($min15->get_prschange())."</div></div></td></tr>"; ?>
                            </table>
                            </div>
							<div class="graphslink">
								<a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=baro.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>"><img src="img/graph_icon.png" alt="to graphs"/></a>
						   </div>
                        </div>
                        <div id="latestwind" class="inparamdiv">
			<div class="paramtitle slogan">
				<a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=wind.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;style=<?=$_GET["style"]?>" title="" >
						<? echo $WIND[$lang_idx];?>
				</a>
			</div>
			<div id="windvalue" class="paramvalue">
				<div id="winddir" class="paramunit">
					<a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=winddir.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;style=<?=$_GET["style"]?>"   title="<? echo $WIND_DIR[$lang_idx];?>">
					<?if (!stristr($current->get_winddir(),"---")&&($current->get_winddir() != "")){?>
					   <div class="winddir <? echo $current->get_winddir(); ?>"></div>
					  <?}?>
					</a>
				</div>
                                <div  id="windspeed">
					<a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=wind.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;style=<?=$_GET["style"]?>" >
                                            <span class="<? if (isHeb()) echo "heb"; ?>"><? echo $min10->get_windspd()." <span class=\"paramunit\">".$KNOTS[$lang_idx]."</span>";?></span>
					</a>
				</div>
                          </div>
					<div class="highlows">
						<span><strong><? echo $today->get_highwind(); ?></strong>&nbsp;<img src="img/peak_max.png" width="15" height="14" alt="<? echo $HIGH[$lang_idx]; ?>"/>&nbsp;<? echo $today->get_highwind_time()." "; ?></span>
					</div>
						<div class="trendstable">	
					  <table>
					   <tr class="trendstitles">
							   <td  class="box" title="<? echo($HOUR[$lang_idx]);?>"><img src="img/hour_icon.png" width="21" alt="hour" /></td>
							   <td  class="box" title="30<? echo($MINTS[$lang_idx]);?>"><img src="img/half_icon.png" width="21" alt="half hour"/></td>
							   <td class="box" title="<? echo getLastUpdateMin().($MINTS[$lang_idx]);?>"><img src="img/quarter_icon.png" width="21" alt="quarter hour"/></td>
					   </tr>
					   <? echo "<tr class=\"trendsvalues\" ><td><div class=\"trendvalue\"><div class=\"innertrendvalue\">".get_img_tag($oneHour->get_windspdchange()).abs($oneHour->get_windspdchange())."</div></div></td><td><div class=\"trendvalue\"><div class=\"innertrendvalue\">".get_img_tag($min30->get_windspdchange()).abs($min30->get_windspdchange())."</div></div></td><td><div class=\"trendvalue\"><div class=\"innertrendvalue\">".get_img_tag($min15->get_windspdchange()).abs($min15->get_windspdchange())."</div></div></td></tr>"; ?>
						</table>
						</div>
						<div class="graphslink">
								<a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=wind.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;style=<?=$_GET["style"]?>" ><img src="img/graph_icon.png" alt="to graphs"/></a>
						</div>
				</div>
                        <div id="latestrain" class="inparamdiv" <? if (isHeb()) echo "dir=\"rtl\" ";?> title="<? echo $RAIN_RATE[$lang_idx]; ?>">
                            <div class="paramtitle slogan">
                                    <a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=RainRateHistory.gif&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;style=<?=$_GET["style"]?>" title="">
                                            <? echo $RAIN_RATE[$lang_idx];?>
                                    </a>
                            </div>
                            <div id="rainratevalue" class="paramvalue">
                                    <a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=rain.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;style=<?=$_GET["style"]?>" title="">
                                            <? echo $current->get_rainrate()." <span class=\"paramunit\">".$RAINRATE_UNIT[$lang_idx]."</span>";?>
                                    </a> 
                            </div>
                            <div class="highlows">
                                <span><strong><? echo $today->get_highrainrate(); ?></strong>&nbsp;<img src="img/peak_max.png" width="15" height="14" alt="<? echo $HIGH[$lang_idx]; ?>"/>&nbsp;<? echo $today->get_highrainrate_time()." "; ?></span>
                            </div>
                            <div class="trendstable">
                             <table id="rainrate15min">
                            <tr class="trendstitles">
                                    <td  class="box" title="<? echo($HOUR[$lang_idx]);?>"><img src="img/hour_icon.png" width="21" alt="hour"/></td>
                                    <td  class="box" title="30<? echo($MINTS[$lang_idx]);?>"><img src="img/half_icon.png" width="21" alt="half hour"/></td>
                                    <td class="box" title="<? echo getLastUpdateMin().($MINTS[$lang_idx]);?>"><img src="img/quarter_icon.png" width="21" alt="quarter hour"/></td>
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
								<a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=RainRateHistory.gif&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;style=<?=$_GET["style"]?>" title=""><img src="img/graph_icon.png" alt="to graphs"/></a>
							</div>
                        </div>
                        <div id="latestradiation" class="inparamdiv" <? if (isHeb()) echo "dir=\"rtl\" ";?> title="<? echo $SUN[$lang_idx]; ?>">
                            <div class="paramtitle slogan">
                                    <a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=SolarRadHistory.gif&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;style=<?=$_GET["style"]?>" title="">
                                            <? echo $RADIATION[$lang_idx];?>
                                    </a>
                            </div>
                            <div id="sunvalues" class="paramvalue">
                                    <a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=SolarRadHistory.gif&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;style=<?=$_GET["style"]?>" title="">
                                            <? echo $current->get_solarradiation()."<span class=\"paramunit\"> W/m2</span>";?>
                                    </a>
                            </div>
                            <div class="highlows">
                                <span><strong><? echo $today->get_highradiation(); ?></strong>&nbsp;<img src="img/peak_max.png" width="15" height="14" alt="<? echo $HIGH[$lang_idx]; ?>"/>&nbsp;<? echo $today->get_highradiation_time()." "; ?></span>
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
                                    <? echo get_img_tag($yestsametime->get_srchange()).abs($yestsametime->get_srchange());?>
                                        </div></div></td>
                                <td><div class="trendvalue"><div class="innertrendvalue">
                                    <? echo get_img_tag($min30->get_srchange()).abs($min30->get_srchange());?>
                                </div></div></td>
                                <td><div class="trendvalue"><div class="innertrendvalue">
                                    <? echo get_img_tag($min15->get_srchange()).abs($min15->get_srchange());?>
                                </div></div></td>
                            </tr>
                            </table>
                            </div>
                            <div class="graphslink">
                                    <a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=SolarRadHistory.gif&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;style=<?=$_GET["style"]?>" title=""><img src="img/graph_icon.png" alt="to graphs"/></a>
                            </div>
                        </div>
                        <div id="latestuv" class="inparamdiv" <? if (isHeb()) echo "dir=\"rtl\" ";?> title="<? echo $SUN[$lang_idx]; ?>">
                            <div class="paramtitle slogan">
                                    <a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=UVHistory.gif&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;style=<?=$_GET["style"]?>" title="">
                                            <? echo $UV[$lang_idx];?>
                                    </a>
                            </div>
                            <div id="uvvalues" class="paramvalue">
                                    <a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=UVHistory.gif&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;style=<?=$_GET["style"]?>" title="">
                                            <? echo $current->get_uv()." ";?>
                                   
                                    </a> 
                            </div>
                            <div class="highlows">
                                <span><strong><? echo $today->get_highuv(); ?></strong>&nbsp;<img src="img/peak_max.png" width="15" height="14" alt="<? echo $HIGH[$lang_idx]; ?>"/>&nbsp;<? echo $today->get_highuv_time()." "; ?></span>
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
                                    <? echo get_img_tag($yestsametime->get_uvchange()).abs($yestsametime->get_uvchange());?>
                                        </div></div></td>
                                <td><div class="trendvalue"><div class="innertrendvalue">
                                    <? echo get_img_tag($min30->get_uvchange()).abs($min30->get_uvchange());?>
                                </div></div></td>
                                <td><div class="trendvalue"><div class="innertrendvalue">
                                    <? echo get_img_tag($min15->get_uvchange()).abs($min15->get_uvchange());?>
                                </div></div></td>
                            </tr>

                            </table>
                            </div>
							<div class="graphslink">
								<a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=UVHistory.gif&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;style=<?=$_GET["style"]?>" title=""><img src="img/graph_icon.png" alt="to graphs"/></a>
							</div>
                    </div>
                    <div id="latestairq" class="inparamdiv">
                        <div class="paramtitle slogan">
                            <?=$DUST[$lang_idx]?>
                        </div>
                        <div class="paramvalue">
                             <? echo $current->get_pm10()." <span class=\"paramunit\">µg/m3</span>";?>
                        
                        </div>
                        <div class="highlows">
                            <?=$DUST_THRESHOLD[$lang_idx]?>
                        </div>
                        <div class="paramtrend relative">
                            <a href="<? echo get_query_edited_url(get_url(), 'section', 'dust.html');?>" title="<? echo($FORECAST_TITLE[$lang_idx]." ".$FOR[$lang_idx]." ".$DUST[$lang_idx]); ?>"><?=$MORE_INFO[$lang_idx];?><?=get_arrow()?></a>
                        </div>
                       
                    </div>
                    <div class="inparamdiv" id="coldmetersurvey">
                            <div class="colmeterq">
                                <?=$HOTORCOLD_Q[$lang_idx];?>
                            </div>
                            
                            <div class="colmetercontainer">
                                <?
                                $result = getSurvey(2);
                                while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                    print "\n\t\t<input name=\"survey\" onclick=\"toggle('genderchoose');$('#votechosen').val(".$line["field_id"].");\" class=\"coldmeterline color".($line["field_id"])."\" value=\"".get_name($line["field_name"])."\"";
                                    echo " />";
                                 
                                }
                                ?>
                                
                            </div>
                            
                            
                    </div>
                    <div id="genderchoose" style="display:none">
                    		<form method="post" action="<?=$_SERVER['SCRIPT_NAME'];?>?section=survey.php&amp;survey_id=2&amp;lang=<? echo $lang_idx;?>">
                                <div class="inv_plain_3_zebra float" style="margin:0em;width:140px;padding:1em;text-align:<? echo get_s_align(); ?>">
                                    <? if (isHeb()) echo "עוד משהו רציתי להגיד"; else echo "one more thing";?><br />
                                    <textarea name="comments" rows="6" <?if (isHeb()) echo " dir=\"rtl\"";?>  value="" style="width:130px;"></textarea>
                                </div>
                    		<div class="inv_plain_3_zebra float" style="padding: 1em;text-align:<? echo get_s_align(); ?>" <? if (isHeb()) echo "dir=\"rtl\""; ?>><?=$GENDER[$lang_idx];?>: 
                                <input type="radio" value="m" name="gender" checked /><?=$MALE[$lang_idx];?>
                                <input type="radio" value="f" name="gender" /><?=$FEMALE[$lang_idx];?>
                                <input type="radio" value="" name="gender" /><?=$NOR_MALE_NOR_FEMALE[$lang_idx];?>
                                </div>
                                <div class="float clear" style="padding: 0.5em;margin:0em 2.5em;">
                                <input type="submit" class="slogan inv_plain_3_zebra"  style="padding: 0.5em;" name="SendSurveyButton" value="<? if (isHeb()) echo "הצבעה"; else echo "Vote"; ?><?=get_arrow()?><?=get_arrow()?>"/>
                                <input type="hidden" id="votechosen" name="survey" />
                                </div>
                                </form>
                            </div>
                        
		    </div>
		    
		    <ul class="seker_btns">
			<li id="cold_btn" onclick="change_circle('cold_line', 'coldmetersurvey')" title="<?=$COLD_METER[$lang_idx]?>"><?=$HOTORCOLD_T[$lang_idx]?>                               
                        </li>
			
<!--			<li id="mood_btn" onclick="change_circle('-2200px', 'mood_line')">סקר מצב רוח</li>
			<hr id="mood_line"></hr>-->
			<li id="season_btn" >
                            <a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=survey.php&amp;survey_id=1&amp;lang=<? echo $lang_idx;?>">
                            <?=$FSEASON_T[$lang_idx]?>
                            </a>
                        </li>
			
		    </ul>
                            
                    <hr id="cold_line" />
                    <hr id="season_line" />
		</div>
                   <div id="now_stuff" class="span3">
			<a href="<? echo $sig[0]['url'];?>" class="hlink" title="<?echo $WHAT_ELSE[$lang_idx];?>">
			 	<h2><? echo "{$sig[0]['sig'][$lang_idx]}"; ?></h2>
				<div id="extrainfo"><? echo $sig[0]['extrainfo'][$lang_idx]; if ($sig[0]['extrainfo'][$lang_idx] != "") echo ", ";?><?echo $MORE_INFO[$lang_idx];?><?=get_arrow()?></div>
			</a>
        
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
		$url = "http://www.wunderground.com/stationmaps/gmap.asp?zip=00000&amp;wmo=40184&amp;lang=".$lang_idx;            
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
	echo "<footer class=\"footer footerinsection\">Designed by <a target=\"_blank\" href=\"http://www.behance.net/galizorea\">Gali Zorea</a></footer>";	 
        echo "</article>";	
			
} 
	
        
	?>   
		
        </div>
       
		 
        </div> <!-- /container -->
		
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
                       
						<div id="bg2-1" class="cloud3"><div class="cloud3-more"></div></div>
                        <div id="bg2-2" class="cloud4"><div class="cloud4-more"></div></div>
                        <div id="bg2-3" class="cloud2"><div class="cloud2-more"></div></div>
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
						<div id="bg1-1" class="cloud4"><div class="cloud4-more"></div></div>
                        <div id="bg1-2" class="cloud3"><div class="cloud3-more"></div></div>
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
                            <tr><td><?=$NICE_NAME[$lang_idx]?>:</td><td><input type="text" name="user_nice_name" value="" id="profileform_nicename"/></td></tr>
                            </table>
                            <input type="checkbox" name="priority" value="" id="profileform_priority"/><?=$GET_UPDATES[$lang_idx]?><br />
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
                                    <input type="text" placeholder="<?=$EMAIL[$lang_idx]?>" name="email" value="" id="loginform_email" size="30" tabindex="1" style="direction:ltr"/><br /><br />
                                    <input type="password" placeholder="<?=$PASSWORD[$lang_idx]?>" name="password" value="" id="loginform_password" tabindex="2" size="15"/><br />&nbsp;&nbsp;
                                    <input type="checkbox" name="rememberme" value="" id="loginform_rememberme"/><?=$REMEMBER_ME[$lang_idx]?><br /><br />
                                    <a href="javascript: void(0)" id="forgotpass" title="<?=$FORGOT_PASS[$lang_idx]?>"><?=$FORGOT_PASS[$lang_idx].get_arrow()?></a><br />
                                    </div>
                                    <div style="display:none" class="float loading"><img src="img/loading.gif" alt="loading" width="32" height="32"/></div>
                                    <div id="loginform_result" class="float"></div>
                                            <input type="submit" value="<?=$LOGIN[$lang_idx]?>" class="invfloat clear inv_plain_3" onclick="login_to_server(<?=$lang_idx?>, <?=$limitLines?>, '<?=$_GET['update']?>')" id="loginform_submit"/>
                                    <input type="submit" value="Success!" onclick="$('#cboxClose').click();window.location.reload();" id="loginform_OK" class="info invfloat" style="display:none"/>

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
                                <input type="checkbox" name="priority" value="" id="registerform_priority"/><?=$GET_UPDATES[$lang_idx]?>
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
<!--<audio autoplay>
        <source src="sound/rain/RAINFIBL.mp3"></source>
</audio>-->
<? }?>
<!-- Start of StatCounter Code -->
<script type="text/javascript">
var sc_project=548696; 
var sc_invisible=1; 
var sc_security="";
(function() {
  var st = document.createElement('script'); st.type = 'text/javascript'; st.async = true;
  st.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://') + 'www.statcounter.com/counter/counter_xhtml.js';
  var s = document.getElementsByTagName('script')[1]; s.parentNode.insertBefore(st, s);
})();
</script>
<!-- End of StatCounter Code -->
<!-- Grab Google CDN's jQuery. fall back to local if necessary --> 
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script> 
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
<? if (isSnowing()||(stristr($template_routing, 'snow'))) { ?>
<script src="js/snow.js"></script>
<? }?>
<script src="js/tinymce/tinymce.min.js"></script>
<script src="footerScripts.php?lang=<?=$lang_idx?>"  type="text/javascript"></script>
<script src="js/modernizr.custom.37797.js"></script> 
<script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=boazn"></script>
<script type="text/javascript">
/* <![CDATA[ */
    mj = mjd(<? echo $day;?>, <? echo $month;?>, <? echo $year;?>, 0.0);
    var mrs = find_moonrise_set(mj, <?=GMT_TZ?>, 35.2, 31.7);
    var div_moon = document.getElementById('moonriseset_values');
    if (div_moon != null)
            div_moon.innerHTML = mrs;
    <?if (first_page()){?>
       if( isMobile.any() ){
              // window.location.replace('http://www.02ws.co.il/small.php?size=l&amp;lang='+lang);
           }
    <?}?>
    startup(<?=$lang_idx?>, <?=$limitLines?>, "<?=(isset($_GET['update'])?$_GET['update']:'')?>");
/* ]]> */
</script>
<?
//////////////////////////////////////////////////////////////////

if ($boolbroken)
{
        //logger("intended to print broken record: count=".count($messageBroken)." ");
	for ($i=0 ; $i < count($messageBroken) ; $i++)
	{
		echo $messageBroken[$i][$lang_idx];
	}
}
/******** generating message to Email *********/
$messageToSend = array();
if (count($messageAction) > 0) {
    foreach ($messageAction as $message) {
        //logger ("messageAction:".implode(" || ",$message));
        array_push ($messageToSend , $message);
    }
}


for ($i=0 ; $i < count($messageBrokenToSend) ; $i++)
{
    logger("extracting messageBrokenToSend: ". implode(" || ",$messageBrokenToSend));
    for ($j=0 ; $j < count($messageBrokenToSend[$i]) ; $j++)
    {
        array_push($messageToSend, $messageBrokenToSend[$i][$j]);//$messageBrokenToSend[$i][$j][$HEB]
        logger("pushing messageBrokenToSend: ". implode(" || ",$messageBrokenToSend[$i][$j]));
    }
}

if 	(count($EmailSubject) == 0)
        $EmailSubject = array("02ws Update Service", "שירות עדכון ירושמיים");

if (count($messageToSend) > 0) 
{
        logger("messageToSend count:".count($messageToSend));
        foreach ($messageToSend as $message) {
            $message = str_replace("\"", "'", $message);
            logger ("messageToSend:".implode(" || ",$EmailSubject)." ".implode(" / ",$message));
        }
        send_Email($messageToSend, ALL, EMAIL_ADDRESS, "", "", $EmailSubject);
        ?>

        <!-- <script type="text/javascript" src="ajaxEmail.js"></script>
        <script type="text/javascript">
                // startEmailService(message_from, message_subject, message_body, target , info_back)
                var messageBody = escape(encodeURI("<?=$messageToSend?>"));
                var message_action = escape(encodeURI("<?=$actionActive?>"));
                <? echo "startEmailService(escape(encodeURI('".EMAIL_ADDRESS."')) , escape(encodeURI('02ws Update Service')) , messageBody , 'ALL' , false, message_action);"; ?>
        </script> -->

<? } 
	
/************************************************************************/
?>
</body>
</html>
<? if (($_GET['debug'] == '')||(!$error_update)) include "end_caching.php"; ?>