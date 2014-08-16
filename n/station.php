<?
header('Content-type: text/html; charset=utf-8');
ini_set("display_errors","On");
//if ($_GET['debug'] == '')
//    include "begin_caching.php";
set_include_path(get_include_path() . PATH_SEPARATOR . "/home/boazn/02ws.com/public". PATH_SEPARATOR ."./");
include_once("include.php"); 
include_once("start.php");
include_once("requiredDBTasks.php");
include_once "sigweathercalc.php";

?>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><? echo getPageTitle()?></title>
        <meta name="description" content=" ירושמים  . תחנה המדווחת על מזג-האויר בירושלים. יש כאן מצלמה דיגיטלית המצלמת את המתרחש בחוץ כל 10 דקות, תחזית לי-ם, חו''ל, גרפים, נתונים מפורטים , ארכיון וזו רק ההתחלה... What is the weather in Jerusalem, Israel? Here you have 6 days forecast, current significant conditions, live pictures, weather graphs,  detailed archive and much more. This is online weather station which updates every minute." />
        <meta name="keywords" content="climate, storm, snow, monthly, stat , תחזית מזג אויר , אקלים, קר , חם , טיולים, מפות, ירושמים "/>
        <meta name="author" content="Boaz" />
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
        <link rel="stylesheet" href="css/bootstrap.php<?echo "?lang=".$lang_idx; ?>" type="text/css" media="screen">
	<!--<link rel="stylesheet" href="css/bootstrap-responsive.min.css">
	<link rel="stylesheet" href="css/bootstrap-responsive.css">-->
        <style>
            body {
                padding-top: 40px;
                padding-bottom: 40px;
            }
        </style>
        <link rel="stylesheet" href="css/main.php<?echo "?lang=".$lang_idx."&amp;forground_color=".$forground_color."&amp;base_color=".$base_color;?>" type="text/css" media="screen">
        <? if (!$current->is_light()) { ?>
        <link rel="stylesheet" href="css/night.css">
        <? }?>
        <? if (isRaining()){ ?>
			<link rel="stylesheet" href="css/rain.css">
			<? if ($current->get_temp() < 2) { ?>
			<link rel="stylesheet" href="css/snow.css">
        <? }}?>
        <link rel="icon" type="image/png" href="img/favicon_sun.png">
        <script type="text/javascript">

                var _gaq = _gaq || [];
                _gaq.push(['_setAccount', 'UA-647172-1']);
                _gaq.push(['_trackPageview']);

                (function() {
                  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                  ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
                })();
                
        </script>
    </head>
    <body>
        <!--[if (gte IE 5.5)&(lt IE 9)]>	
	<div class="topbase" id="topmessage" style="z-index:9999"><div class="high">Please update you browser. The site does not support internet explorer 6 and 7.<br /><br />אנא עדכן את הדפדפן<a href="http://www.mozilla.com"><img border="0" alt="Firefox 3" title="Firefox 3" src="http://sfx-images.mozilla.org/affiliates/Buttons/firefox3/120x240.png" /></a>
	<a href="http://www.google.com/chrome/"><img src="http://www.techdigest.tv/assets_c/2009/02/google-chrome-logo-thumb-300x300-75857.jpg" alt="Chrome" width="150px"></a>
	<a href="#" title="close" onclick="toggle('topmessage')"><div class='sprite stop1'></div></a></div></div></div>
	<script type="text/javascript">
	show('topmessage', 'main_table', 'main_table', 0, 0);
	</script>
        <![endif]-->
        <!-- This code is taken from http://twitter.github.com/bootstrap/examples/hero.html -->
         <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container row">
		    <div class="span7 nav">	
			<ul id="top_links">
                            <? if (!(first_page())) {?>
                            <li id="tohomepage"><a href="<? echo BASE_URL.substr(strrchr($_SERVER["PHP_SELF"], "/"), 0)."?lang=".$lang_idx;?>" title="<?=$FAQ[$lang_idx]?>"><? echo $HOME_PAGE[$lang_idx];?></a></li>
                            <?}?>
                            <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'faq.php');?>" title="<?=$FAQ[$lang_idx]?>"><?=$FAQ[$lang_idx ]?></a></li>
			    <li><a href="javascript:void(0)" ><? echo $WHAT_ELSE[$lang_idx];?><? if (count($sig) > 2) echo "<span class=\"high\">".(count($sig)-1)."</span>";?>&nbsp;<span class="arrow_down">&#9660;</span></a>
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
                                                                if (($lowtemp_diffFromAv > 3) && ($hightemp_diffFromAv > 3) && (!isRaining()))
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
                                                                }
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
                                                                                if (!isset($_SESSION['gw'])){
                                                                                        global $link;
                                                                                        $result = db_init("SELECT avg(anomaly) FROM globalwarming");
                                                                                        $row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
                                                                                        $gw =  number_format($row['avg(anomaly)'], 2, '.', '');
                                                                                        $_SESSION['gw'] = $gw;
                                                                                        @mysqli_free_result($result);
                                                                                        //Closing connection 
                                                                                        @mysqli_close($link);

                                                                                }
                                                                                else
                                                                                        $gw = $_SESSION['gw'];
                                                                                $gw_plus_minus = $gw >= 0 ? "+" : "";
                                                                                echo $gw_plus_minus.$gw;
                                                                        ?><? echo $current->get_tempunit(); ?>
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
                                                        <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'allTimeRecords.php');?>" class="hlink" title="<?=$RECORDS[$lang_idx];?>"><? echo $RECORDS_LINK[$lang_idx];?><?=get_arrow()?></a></li>
                                                        <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'RainSeasons.php');?>" class="hlink">150 <? echo $RAIN_SEASONS[$lang_idx];?><?=get_arrow()?></a></li>
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
								<div><a href="javascript: void(0)" class="register" title="<?=$REGISTER[$lang_idx]?>"><?=$REGISTER[$lang_idx]?></a></div>
								<div><a href="javascript: void(0)" id="forgotpass" title="<?=$FORGOT_PASS[$lang_idx]?>"><?=$FORGOT_PASS[$lang_idx]?></a></div>
							</div>
							<div id="loggedin" style="display:none">
								<input id="updateprofile" class="button" title="<?=$UPDATE_PROFILE[$lang_idx]?>" value="<?=$UPDATE_PROFILE[$lang_idx]?>" /><br />
								<input value="<?=$SIGN_OUT[$lang_idx]?>" onclick="signout_from_server(<?=$lang_idx?>, <?=$limitLines?>, '<?=$_GET['update']?>')" id="signout" class="button"/>
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
                <? if (!(first_page())) {?>
                <span><? echo $LOGO[$lang_idx];?></span>&nbsp;&nbsp;
                <?}?>
                <span><? echo $SLOGAN[$lang_idx];?></span>&nbsp;&nbsp;
                            <? echo $ELEVATION[$lang_idx]." ".ELEVATION." ".$METERS[$lang_idx]; ?>&nbsp;&nbsp;
                            <span <? if (time() - filemtime($fulldatatotake) > 3600) echo "class=\"high afont\"";?>>
                            <? if (isHeb()) echo $dateInHeb; else echo $date;?>
                            </span>
                </div>
            <div class="fixed_nav span2">
                <? if ((first_page())||($template_routing=="frommobile")) { ?>
                 <img class="logo" src="img/logo<? if (!$current->is_light()) echo "_night"; ?>.png"/>
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
                  <?}?>
            </div>
        </div>
 <div class="container">
        <div class="cover_clouds">
                               
         <? if ($current->is_light()) { ?>
		<img id="cover_clouds-1" src="img/cloud_cover1.png" alt="cloud"/>
		<img id="cover_clouds-2" src="img/cloud_cover2.png" alt="cloud"/>
		<img id="cover_clouds-3" src="img/cloud_cover1.png" alt="cloud"/>
		<img id="cover_clouds-4" src="img/cloud_cover2.png" alt="cloud"/>
                <?} else { ?>
        <img id="cover_clouds-1" src="img/cloud_cover1_night.png" alt="cloud"/>
		<img id="cover_clouds-2" src="img/cloud_cover2_night.png" alt="cloud"/>
		<img id="cover_clouds-3" src="img/cloud_cover1_night.png" alt="cloud"/>
		<img id="cover_clouds-4" src="img/cloud_cover2_night.png" alt="cloud"/>
                <?}?>
	    </div>
        <div id="content">
            <article id="now">
               <div class="row"> 
		<div class="main_info span6 offset3">
		    <ul class="info_btns">
			    <li id="now_btn" onclick="change_circle('now_line', 'latestnow')"></li>
			     <hr id="now_line" />
			    <li id="temp_btn" onclick="change_circle('temp_line', 'latesttemp')" title="<? echo $TEMP[$lang_idx];?>"></li>
			    <hr id="temp_line" />
			    <li id="moist_btn" onclick="change_circle('moist_line', 'latesthumidity')" title="<? echo $HUMIDITY[$lang_idx];?>"></li>
			    <hr id="moist_line" />
			    <li id="air_btn" onclick="change_circle('air_line', 'latestpressure')" title="<? echo $BAR[$lang_idx];?>"></li>
			    <hr id="air_line" />
			    <li id="wind_btn" onclick="change_circle('wind_line', 'latestwind')" title="<? echo $WIND[$lang_idx];?>"></li>
			    <hr id="wind_line" />
			    <li id="rain_btn" onclick="change_circle('rain_line', 'latestrain')" title="<? echo $RAIN[$lang_idx];?>"></li>
			    <hr id="rain_line" />
			    <li id="rad_btn" onclick="change_circle('rad_line', 'latestradiation')" title="<? echo $RADIATION[$lang_idx];?>"></li>
			    <hr id="rad_line" />
			    <li id="uv_btn" onclick="change_circle('uv_line', 'latestuv')" title="<? echo $UV[$lang_idx];?>"></li>
			    <hr id="uv_line" />
                   <li id="aq_btn" onclick="change_circle('aq_line', 'latestairq')" title="<? echo $AIR_QUALITY[$lang_idx];?>"></li>
			    <hr id="aq_line" />
			</ul>
		    
		    <div id="info_circle">
                        <div id="latestnow" class="inparamdiv">
                            <div id="tempdivvalue">
                                <? echo $current->get_temp();?><span class="paramunit"><? echo $current->get_tempunit(); ?></span>
                           </div>
                            <div id="status">
				<? if (isRaining()) echo $ITS_RAINING[$lang_idx].", ";?><? echo getWindStatus();?>
			<div  id="coldmeter">
			<a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=survey.php&amp;survey_id=2&amp;lang=<? echo $lang_idx;?>"> <span id="current_feeling_link" title="<?=$HOTORCOLD_T[$lang_idx]?> - <?=$COLD_METER[$lang_idx]?>">...</span>
			</a>
			</div>
			   <?
					if (min($current->get_windchill(), $current->get_thw()) < ($current->get_temp() - 1) && $current->get_temp() < 20 ){ ?>
						<div id="itfeels_windchill"> 
						 <a title="<?=$WIND_CHILL[$lang_idx]?>" href="<? echo $_SERVER['SCRIPT_NAME']; ?>?section=graph.php&amp;graph=tempwchill.php&amp;profile=1&amp;lang=<?=$lang_idx?>"> 
							<? echo $IT_FEELS[$lang_idx]; ?>
							<span dir="ltr" class="low" title="<?=$WIND_CHILL[$lang_idx]?>"><? echo min($current->get_windchill(), $current->get_thw())."&#176;"; ?></span>
						 </a>
						</div>
					
					<? } 
					else if ($current->get_HeatIdx() > ($current->get_temp())){ ?>
						<div class="" id="itfeels_heatidx">
						 <a title="<?=$HEAT_IDX[$lang_idx]?>"  href="<?=$_SERVER['SCRIPT_NAME']?>?section=graph.php&amp;graph=tempheat.php&amp;profile=1&amp;lang=<?=$lang_idx?>"> 
							<? echo $IT_FEELS[$lang_idx]; ?>
							<span dir="ltr" class="high" title="<?=$HEAT_IDX[$lang_idx]?>"><? echo max($current->get_HeatIdx(), $current->get_thw())."&#176;";  ?></span>
						 </a> 
						</div>
					<?}?>
		
					
			</div>		
			</div>
                     
                      <div id="latesttemp" class="inparamdiv">
                               <div class="paramtitle slogan">
                                    <a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=temp.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>&amp;style=<?=$_GET["style"]?>" title=""><? echo $TEMP[$lang_idx];?></a>
                                </div>
                               <div class="paramvalue">
                                    <a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=temp.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>&amp;style=<?=$_GET["style"]?>">
                                        <? echo $current->get_temp();?><span class="paramunit"><? echo $current->get_tempunit(); ?></span>
                                    </a>
                                </div>
                                <div class="highlows">
                                        <span class="high"><strong><? echo toLeft($today->get_hightemp()); ?></strong></span>&nbsp;<img src="img/peak_max.png" width="15" height="14" alt="<? echo $HIGH[$lang_idx]; ?>"/>&nbsp;<? echo $today->get_hightemp_time()." "; ?>
                                        <span class="low"><strong><? echo toLeft($today->get_lowtemp()); ?></strong></span>&nbsp;<img src="img/peak_min.png" width="15" height="14" alt="<? echo $LOW[$lang_idx]; ?>"/>&nbsp;<? echo $today->get_lowtemp_time()." "; ?>
                                </div> 
                                <div class="paramtrend relative">
                                    <div class="innertrendvalue">
                                       <? echo getLastUpdateMin()." ".($MINTS[$lang_idx]).": ".get_param_tag($min15->get_tempchange()).$current->get_tempunit(); ?>
                                    </div>
                                </div>  
                          <div class="trendstable"> 
                               <table>
                                        <tr class="trendstitles">
                                                <td  class="box" title="24 <? echo $HOURS[$lang_idx];?>"><img src="img/24_icon.png" width="21"/></td>
                                                <td  class="box" title="<? echo($HOUR[$lang_idx]);?>"><img src="img/hour_icon.png" width="21"/></td>
                                                <td  class="box" title="30<? echo($MINTS[$lang_idx]);?>"><img src="img/half_icon.png" width="21"/></td>
                                        </tr>
                                        <tr class="trendsvalues"><td><div class="trendvalue"><div class="innertrendvalue"> <? echo get_param_tag($yestsametime->get_tempchange())."</div></div></td><td ><div class=\"trendvalue\"><div class=\"innertrendvalue\">".get_param_tag($oneHour->get_tempchange())."</div></div></td><td ><div class=\"trendvalue\"><div class=\"innertrendvalue\">".get_param_tag($min30->get_tempchange()); ?></div></div></td></tr>
                                </table>
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
                                    <td  class="box" title="24 <? echo $HOURS[$lang_idx];?>"><img src="img/24_icon.png" width="21"/></td>
                                    <td  class="box" title="<? echo($HOUR[$lang_idx]);?>"><img src="img/hour_icon.png" width="21"/></td>
                                    <td  class="box" title="30<? echo($MINTS[$lang_idx]);?>"><img src="img/half_icon.png" width="21"/></td>
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
                                        <td  class="box" title="<? echo($HOUR[$lang_idx]);?>"><img src="img/hour_icon.png" width="21"/></td>
                                        <td  class="box" title="30<? echo($MINTS[$lang_idx]);?>"><img src="img/half_icon.png" width="21"/></td>
                                        <td class="box" title="<? echo getLastUpdateMin().($MINTS[$lang_idx]);?>"><img src="img/quarter_icon.png" width="21"/></td>
                                </tr>
                                <? echo "<tr class=\"trendsvalues\"  ><td><div class=\"trendvalue\"><div class=\"innertrendvalue\">".get_param_tag($oneHour->get_prschange())."</div></div></td><td><div class=\"trendvalue\"><div class=\"innertrendvalue\">".get_param_tag($min30->get_prschange())."</div></div></td><td><div class=\"trendvalue\"><div class=\"innertrendvalue\">".get_param_tag($min15->get_prschange())."</div></div></td></tr>"; ?>
                            </table>
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
                                            <span class="<? if (isHeb()) echo "heb"; ?>"><? echo $current->get_windspd()." <span class=\"paramunit\">".$KNOTS[$lang_idx]."</span>";?></span>
					</a>
				</div>
                          </div>
                            <div class="highlows">
                                <span><strong><? echo $today->get_highwind(); ?></strong>&nbsp;<img src="img/peak_max.png" width="15" height="14" alt="<? echo $HIGH[$lang_idx]; ?>"/>&nbsp;<? echo $today->get_highwind_time()." "; ?></span>
                            </div>
                            	<div class="trendstable">	
                              <table>
                               <tr class="trendstitles">
                                       <td  class="box" title="<? echo($HOUR[$lang_idx]);?>"><img src="img/hour_icon.png" width="21"/></td>
                                       <td  class="box" title="30<? echo($MINTS[$lang_idx]);?>"><img src="img/half_icon.png" width="21"/></td>
                                       <td class="box" title="<? echo getLastUpdateMin().($MINTS[$lang_idx]);?>"><img src="img/quarter_icon.png" width="21"/></td>
                               </tr>
                               <? echo "<tr class=\"trendsvalues\" ><td><div class=\"trendvalue\"><div class=\"innertrendvalue\">".get_img_tag($oneHour->get_windspdchange()).abs($oneHour->get_windspdchange())."</div></div></td><td><div class=\"trendvalue\"><div class=\"innertrendvalue\">".get_img_tag($min30->get_windspdchange()).abs($min30->get_windspdchange())."</strong></div></div></td><td><div class=\"trendvalue\"><div class=\"innertrendvalue\">".get_img_tag($min15->get_windspdchange()).abs($min15->get_windspdchange())."</div></div></td></tr>"; ?>
                                </table>
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
                                    <td  class="box" title="<? echo($HOUR[$lang_idx]);?>"><img src="img/hour_icon.png" width="21"/></td>
                                    <td  class="box" title="30<? echo($MINTS[$lang_idx]);?>"><img src="img/half_icon.png" width="21"/></td>
                                    <td class="box" title="<? echo getLastUpdateMin().($MINTS[$lang_idx]);?>"><img src="img/quarter_icon.png" width="21"/></td>
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
                            <div class="trendstable">
                            <table>
                            <tr class="trendstitles">
                                    <td  class="box" title="24 <? echo $HOURS[$lang_idx];?>"><img src="img/24_icon.png" width="21"/></td>
                                    <td  class="box" title="30<? echo($MINTS[$lang_idx]);?>"><img src="img/half_icon.png" width="21"/></td>
                                    <td class="box" title="<? echo getLastUpdateMin().($MINTS[$lang_idx]);?>"><img src="img/quarter_icon.png" width="21"/></td>
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
                            <div class="trendstable">
                             <table>
                            <tr class="trendstitles">
                                    <td  class="box" title="24 <? echo $HOURS[$lang_idx];?>"><img src="img/24_icon.png" width="21"/></td>
                                    <td  class="box" title="30<? echo($MINTS[$lang_idx]);?>"><img src="img/half_icon.png" width="21"/></td>
                                    <td class="box" title="<? echo getLastUpdateMin().($MINTS[$lang_idx]);?>"><img src="img/quarter_icon.png" width="21"/></td>
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
                    </div>
                    <div id="latestairq" class="inparamdiv">
                        <div class="paramtitle slogan">
                            <?=$DUST[$lang_idx]?>
                        </div>
                        <div class="paramvalue relative">
                             <iframe id="pm10value" src="http://www.svivaaqm.net/Online.aspx?ST_ID=36;1" frameborder="0" seamless ></iframe>
                        <!--<object data="http://www.svivaaqm.net/StationInfo5.aspx?ST_ID=36" width="200" height="200">
                            <embed src="http://www.svivaaqm.net/StationInfo5.aspx?ST_ID=36" width="200" height="200"> </embed>
                            Error: Embedded data could not be displayed.
                        </object>-->
                        </div>
                        <div class="highlows">
                            
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
                    					<div class="inv_plain_3_zebra float" style="padding: 1em;margin:0em 3em;text-align:<? echo get_s_align(); ?>" <? if (isHeb()) echo "dir=\"rtl\""; ?>><?=$GENDER[$lang_idx];?>: 
                                <input type="radio" value="m" name="gender" checked /><?=$MALE[$lang_idx];?>
                                <input type="radio" value="f" name="gender" /><?=$FEMALE[$lang_idx];?>
                                <input type="radio" value="" name="gender" /><?=$NOR_MALE_NOR_FEMALE[$lang_idx];?>
                                </div>
                                <div class="float clear" style="padding: 0.5em;margin:0em 2.5em;">
                                <input type="submit" class="slogan inv_plain_3_zebra"  style="padding: 0.5em;" name="SendButton" value="<? if (isHeb()) echo "הצבעה"; else echo "Vote"; ?><?=get_arrow()?><?=get_arrow()?>"/>
                                <input style="display:none" id="votechosen" />
                                </div>
                                </form>
                            </div>
                        
		    </div>
		    
		    <ul class="seker_btns">
			<li id="cold_btn" onclick="change_circle('cold_line', 'coldmetersurvey')" title="<?=$COLD_METER[$lang_idx]?>"><?=$HOTORCOLD_T[$lang_idx]?>                               
                        </li>
			<hr id="cold_line" />
<!--			<li id="mood_btn" onclick="change_circle('-2200px', 'mood_line')">סקר מצב רוח</li>
			<hr id="mood_line"></hr>-->
			<li id="season_btn" >
                            <a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=survey.php&amp;survey_id=1&amp;lang=<? echo $lang_idx;?>">
                            <?=$FSEASON_T[$lang_idx]?>
                            </a>
                        </li>
			<hr id="season_line" />
		    </ul>
		</div>
                   <div id="now_stuff" class="span3">
			<a href="<? echo $sig[0]['url'];?>" class="hlink" title="<?echo $MORE_INFO[$lang_idx];?>">
			 	<h2><? echo "{$sig[0]['sig'][$lang_idx]}"; ?></h2>
				<div id="extrainfo"><? echo $sig[0]['extrainfo'][$lang_idx]; if ($sig[0]['extrainfo'][$lang_idx] != "") echo " - ";?><?echo $MORE_INFO[$lang_idx];?><?=get_arrow()?></div>
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
<article id="section">
<? 
	if  (!stristr($template_routing, 'jpg'))
		echo "<div class=\"clear float \" id=\"print\" onclick=\"tpopup('print.php?".$QUERY_STRING."')\"></div>";
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
		  echo "<p class=\"footer\">Designed by <a href=\"http://www.behance.net/galizorea\" target=\"_blank\">Gali Zorea</a></p>";
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
                        <? if (isRaining()): ?>
                        <img id="bg2-1" src="img/cloud-lg1_rain.png" alt="cloud"/>
                        <img id="bg2-2" src="img/cloud-lg2_night.png" alt="cloud"/>
                        <img id="bg2-3" src="img/cloud-lg2_big_rain.png" alt="cloud"/>
                        <img id="bg2-4" src="img/cloud-lg1_rain.png" alt="cloud"/>
                        <img id="bg2-5" src="img/cloud-lg1_rain.png" alt="cloud"/>
                        <? elseif ($current->is_light()) : ?>
			<img id="bg2-1" src="img/cloud-lg1.png" alt="cloud"/>
			<img id="bg2-2" src="img/cloud-lg3_big.png" alt="cloud"/>
			<img id="bg2-3" src="img/cloud-lg2.png" alt="cloud"/>
			<img id="bg2-4" src="img/cloud-lg1.png" alt="cloud"/>
			<img id="bg2-5" src="img/cloud-lg1.png" alt="cloud"/>
                        <?  else :?>
                         <img id="bg2-1" src="img/cloud-lg1_night.png" alt="cloud"/>
                        <img id="bg2-2" src="img/cloud-lg3_night.png" alt="cloud"/>
                        <img id="bg2-3" src="img/cloud-lg2_night.png" alt="cloud"/>
                        <img id="bg2-4" src="img/cloud-lg1_night.png" alt="cloud"/>
                        <img id="bg2-5" src="img/cloud-lg1_night.png" alt="cloud"/>
                        <? endif;?>
                        
	</div>
	
	<!-- Parallax  background clouds -->
	<div id="parallax-bg1">
                        <? if (isRaining()): ?>
                        <img id="bg1-1" src="img/cloud-lg3_rain.png" alt="cloud"/>
                        <img id="bg1-2" src="img/cloud-lg2_rain.png" alt="cloud"/>
                        <img id="bg1-3" src="img/cloud-lg2_night.png" alt="cloud"/>
                        <img id="bg1-4" src="img/cloud-lg2_rain.png" alt="cloud"/>
                        <? elseif ($current->is_light()) : ?>
			<img id="bg1-1" src="img/cloud-lg3.png" alt="cloud"/>
			<img id="bg1-2" src="img/cloud-lg4.png" alt="cloud"/>
			<img id="bg1-3" src="img/cloud-lg3.png" alt="cloud"/>
			<img id="bg1-4" src="img/cloud-lg4.png" alt="cloud"/>
                        <? else :?>
                        <img id="bg1-1" src="img/cloud-lg3_night.png" alt="cloud"/>
                        <img id="bg1-2" src="img/cloud-lg2_night.png" alt="cloud"/>
                        <img id="bg1-3" src="img/cloud-lg3_night.png" alt="cloud"/>
                        <img id="bg1-4" src="img/cloud-lg2_night.png" alt="cloud"/>
                        <? endif;?>
                        
                        
	</div>    
        <input type="hidden" id="current_feeling" value="<?=$current_feeling?>"/>
        <input type="hidden" id="chosen_user_icon" value=""/>

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
<?if (first_page()){?>
<script src="js/parallax.js"></script>
<?}?>
 <? if (isRaining()){ ?>
<script src="js/rain.js"></script>
<? }?>
<script src="js/tinymce/tinymce.min.js"></script>
<script src="footerScripts.php?lang=<?=$lang_idx?>"  type="text/javascript"></script>
<script src="jquery.colorbox.js"  type="text/javascript"></script>
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
       if( isMobile.any() )
               window.location.replace('http://www.02ws.co.il/small.php?size=l&amp;lang='+lang);
    <?}?>
    startup(<?=$lang_idx?>, <?=$limitLines?>, "<?=(isset($_GET['update'])?$_GET['update']:'')?>");
           
/* ]]> */
</script>	    
</body>
</html>
<? //if (($_GET['debug'] == '')||(!$error_update)) include "end_caching.php"; ?>