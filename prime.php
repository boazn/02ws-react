 <article id="forecast">
	<?include_once("forecastlib.php");
         include_once "picasaproxy.php";$mediumSizeUrl = "phpThumb.php?src=".$contentUrl."&amp;w=180&amp;h=180&amp;zc=C";
          $sig_url = $sig[0]['url'];
        $sig_title = $sig[0]['sig'][$lang_idx];
        $imagefile = "phpThumb.php?src=".getUpdatedPic()."&amp;w=200&amp;h=200&amp;zc=C&amp;fltr[]=gam|0.8";//&amp;fltr[]=cont|50
        $current_story_img_src = "phpThumb.php?src=".$current_story_img_src."&amp;w=200&amp;h=200&amp;zc=C";//&amp;fltr[]=cont|50 ;
        /////////////////////////////////////////
        $floated = false;

        ////////////////////////////////////////
                $overlook_d = "<a href=\"javascript:void(0)\" class=\"info\">".$OVERLOOK[$lang_idx]."<span class=\"info\">".$OVERLOOK_EXP[$lang_idx]."</span></a>";
        ?>
		<div class="row">
		    <div id="forcast_title">
			<div class="forcast_title_btns for_active" onClick="change_main('#forcast_days', this, '<?=$lang_idx?>');"><? echo($FORECAST_4D[$lang_idx]); ?></div>
			<div class="forcast_title_btns" onClick="getTempForecast(<?=$timetaf?>, '<?=$dayF."/".$monthF."/".$yearF?>');change_main('#forcast_hours', this, '<?=$lang_idx?>');"><? echo(" 24 ".$HOURS[$lang_idx]);?></div>
			<div class="forcast_title_btns" onClick="change_main('#what_is_forcast', this, '<?=$lang_idx?>');"><?=$WHAT_IS_FORECAST[$lang_idx]?></div>
					
		    </div>
		    
		    <div id="forcast_main">
			
			<div class="contentbox-wrapper">
			    <div id="forcast_days" class="contentbox">
				<ul id="forcast_icons">
				    <li id="morning_icon"></li>
				    <li id="noon_icon" alt="צהריים"></li>
				    <li id="night_icon" alt="ערב"></li>
				</ul>
				<ul id="forcast_table">
					<? if  (count($forecastDaysDB) == 0) 
						{
							echo $frcstTable;
							echo "<ul style=\"height:5px\"><li colspan=\"4\">".$SOURCE[$lang_idx].": ".$IMS[$lang_idx]."</li></ul>";	
	 
						}
						else 
						{
							//print_r($forecastDaysDB);
	 
							for ($i = 0; $i < count($forecastDaysDB); $i++) 
							{
							
					 ?>
							<li class="forcast_each <?if ($i >= 5) echo "tashkif";?>" id="<?=$i?>">
							<ul>
								<li class="forcast_day">
								<? echo replaceDays($forecastDaysDB[$i]['day_name']." ");?><? if ($i >= 5) echo "<p>".$overlook_d."</p>";?>
								</li>
								<li class="forcast_date">
								<? echo $forecastDaysDB[$i]['date'];?>
								</li>
								<li class="forcast_morning">
								<?=c_or_f($forecastDaysDB[$i]['TempLow'])?>
								</li>
								<li class="forcast_noon">
								<?=c_or_f($forecastDaysDB[$i]['TempHigh'])?>&nbsp;<img style="vertical-align: middle" src="<? echo "images/clothes/".$forecastDaysDB[$i]['TempHighCloth']; ?>" width="30" height="30" title="<?=getClothTitle($forecastDaysDB[$i]['TempHighCloth'])?>" alt="<?=getClothTitle($forecastDaysDB[$i]['TempHighCloth'])?>" />
								</li>
								<li class="forcast_night">
								<?=c_or_f($forecastDaysDB[$i]['TempNight'])?>&nbsp;<img style="vertical-align: middle"  src="<? echo "images/clothes/".$forecastDaysDB[$i]['TempNightCloth']; ?>" width="30" height="30" title="<?=getClothTitle($forecastDaysDB[$i]['TempNightCloth'])?>" alt="<?=getClothTitle($forecastDaysDB[$i]['TempNightCloth'])?>" />
								</li>
								 <li><img src="<? echo "images/icons/day/".$forecastDaysDB[$i]['icon']; ?>" width="37" height="37" alt="<?=$forecastDaysDB[$i]['date']?>" /></li>
								 <li class="forcast_text">
									<? if (isHeb()) $dscpIdx = "lang1"; else $dscpIdx = "lang0"; echo urldecode($forecastDaysDB[$i][$dscpIdx]);?>
								</li>
							</ul>
							 </li>
						<?
								}
						   }
						?>
				    <li class="forcast_each extra" style="margin-top:0.8em">
					<ul>
					    <li style="border-top:1px dashed">
							<a href="<? echo get_query_edited_url($url_cur, 'section', 'averages.php');?>" title="<? echo $monthInWord." ".$AVERAGE[$lang_idx]; ?>">
									<? echo $AVERAGE[$lang_idx];?>
								</a>
					    </li>
					    <li class="forcast_date">
							
					    </li>
					    <li class="forcast_morning">
							<? echo $monthAverge->get_lowtemp(); ?>
					    </li>
					    <li class="forcast_noon" style="text-align:<?=get_s_align()?>">
							<? echo $monthAverge->get_hightemp(); ?>
					    </li>
					    <li class="forcast_night">
						
					    </li>
					     <li ></li>
					     <li class="forcast_text">
						
					    </li>
					</ul>
				    </li>
				    
				    <li class="forcast_each extra" >
					<ul>
					    <li style="padding:0.2em 0">
							<a href="<? echo get_query_edited_url($url_cur, 'section', 'reports.php');?>" title="<? echo $monthInWord." ".$RECORDS[$lang_idx]; ?>">
									<? echo $RECORDS[$lang_idx];?>
								</a>
					    </li>
					    <li class="forcast_date">
							
					    </li>
					    <li class="forcast_morning" >
							<? echo $monthAverge->get_abslowtemp(); ?>
					    </li>
					    <li class="forcast_noon" style="text-align:<?=get_s_align()?>">
							<? echo $monthAverge->get_abshightemp(); ?>
					    </li>
					    <li class="forcast_night">
						
					    </li>
					     <li ></li>
					     <li class="forcast_text">
						
					    </li>
					</ul>
				    </li>
			    
				</ul>
					
			    </div> <!-- forcast_days -->
			    
			     <div id="forcast_hours" class="contentbox">
				 <? echo($GIVEN[$lang_idx]." ".$AT[$lang_idx]." ".$timetaf.":00 ".$dayF."/".$monthF."/".$yearF);?>
				 <div id="for24_literal">
										<?=$forcastTicker?>
					<span id="tempForecastDiv" style="display:none">
					</span>
				</div>
				<ul id="for24_hours">
				 <? 
				 foreach ($forecastHour as $hour_f){
				 if ($hour_f['time'] % 3 == 0)
				 {
				 echo "<li class=\"nav forecasttimebox forcast_each\" ><ul>";
				 echo "<li class=\"tsfh\" style=\"text-align:center;width:3%;display:none\">".$hour_f['currentDateTime']."</li>";
				 echo "<li class=\"timefh forcast_date\" style=\"text-align:center;width:8%\">".$hour_f['time']."</li>";
				 echo "<li class=\"forecasttemp forcast_morning\" style=\"text-align:center;width:7%\" id=\"tempfh".intval($hour_f['time']).intval(date("j", $hour_f['currentDateTime']))."\">"."</li>";
				 echo "<li style=\"text-align:center;width:7%\"><img src=\"images/icons/day/".$hour_f['icon']."\" height=\"25\" width=\"28\" alt=\"".$hour_f['icon']."\" /></li>";
				 echo "<li>".$hour_f['wind'].",</li>";
				 echo "<li>".$hour_f['title']."</li>";
				 echo "</ul></li>";
				 }
				 }
				 ?>
				</ul>
			    </div>
			    
			    <div id="what_is_forcast" class="contentbox">
				
				   <strong>
				<?=$WHAT_IS_FORECAST[$lang_idx]?>
				    </strong>
				<?=$FORECAST_DESC[$lang_idx]?>
                               
			    </div>
			    
			</div><!-- contentbox-wrapper -->
			
		    </div> <!-- forcast_main -->
			<? if (($current->is_light())&&(!isRaining())) {$adsense_color = "#4B6371"; if ($current->is_sunset()) $adsense_background = "#FDAC60"; else $adsense_background = "#BCE3EA";} elseif (isRaining()) {$adsense_color = "#FFFFFF";$adsense_background = "#6288A4";} else {$adsense_color = "#FFFFFF";$adsense_background = "#5B6A92";};?>
		    <div id="mainadsense" style="box-shadow:3px 3px 15px 15px <?=$adsense_background?>">
			    <script type="text/javascript"><!--
				google_ad_client = "pub-2706630587106567";
				/* 300x250, created 10/20/10 */
				google_ad_slot = "2164253176";
				google_ad_width = 300;
				google_ad_height = 250;
				google_color_border = ["<?=$adsense_background?>"];
				google_color_bg = ["<?=$adsense_background?>"];
				google_color_link = ["<?=$adsense_color?>"];
				google_color_url = ["<?=$adsense_color?>"];
				google_color_text = ["<?=$adsense_color?>"];
				//-->
				</script>
				<script type="text/javascript"
				src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
				</script>
				</div>
                   </div>
		    
                    
		    
		<!-- row -->
		
            </article>
            
	    
	    
<article id="more">
	    
		<div class="now_messages">
		    <div class="row">
		    <div class="span5 offset4 white_box">
			<h2><? echo $MESSAGES[$lang_idx];?></h2>
                        <p class="box_text">
			<? echo $detailedforecast;?>
                        </p>
		    </div>
                    <div class="moon_sun span2">
			 <div id="moon_rise" onclick="window.open('http://wise-obs.tau.ac.il/cgi-bin/eran/calen.html?MO=6&YE=2013&TI=Wise+Observatory+Schedule&LO=35.167&LA=31.783&TZ=2&PLACE=2');">
                             <div id="moon_img" class="float">
                             <a href="http://wise-obs.tau.ac.il/cgi-bin/eran/calen.html?MO=<? echo $month;?>&amp;YE=<? echo $year;?>&amp;TI=Wise+Observatory+Schedule&amp;LO=35.167&amp;LA=31.783&amp;TZ=2&amp;PLACE=2" rel="external" title="<? echo $MORE_INFO[$lang_idx];?>">
                                        <?
                                        $moonurl = "http://www.almanac.com/sites/new.almanac.com/files/moon.gif";
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
			    
			    <div id="sun_rise" class="clear" onClick="window.open('<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=SolarRadHistory.gif&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;style=<?=$_GET["style"]?>');">
			    <p><? echo $RISE[$lang_idx]; ?>: <? echo $sunrise; ?></p>
			    <p><? echo $SET[$lang_idx]; ?>: <? echo $sunset; ?></p>
			    </div>
			    <div id="sun_hours">
				<h3><? echo $today->get_sunshinehours();?></h3>
				<p><? echo $SUNSHINEHOURS[$lang_idx]." ".$TILL_NOW[$lang_idx];?> </p>
			    </div>
			</div>
		    </div>
		    <br>
			
		    <div class="row">
		    <a href="<? echo "station.php?section=mainstory.php&amp;lang=".$lang_idx;?>">
		    <div class="span5 offset4 white_box">
			<h2><? echo $current_story_title;?></h2>
			<p class="box_text">
			 <? echo mb_substr($current_story, 0, 68, "UTF-8");?>...<?echo $MORE_INFO[$lang_idx];?><?=get_arrow()?>
			</p>
		    </div>
		    </a>
		    </div>
		    
		    <div class="row more_stuff">
<!--			<div id="newsletter">
			    <h2>רשימת תפוצה</h2>
			    <form class="email_form" method="get" action="">
				<input type="text"  class="search-query" name="q" value="youremail@domain.com" onfocus="if(this.value == 'youremail@domain.com') { this.value = ''; }" onfocusout="if(this.value == '') { this.value = 'youremail@domain.com'; }"/>
				 <input type="submit" value="שליחה" />
			    </form>
			</div>-->
			<h2 id="about"><a href="<? echo get_query_edited_url($url_cur, 'section', 'contact.php');?>"><?=$CONTACT_INFO[$lang_idx ]?></a></h2>
			
			
			<div class="span7 offset1 more_icons">
			    <ul>
				<li><a id="weather_israel" href="<?=$_SERVER['SCRIPT_NAME'];?>?section=forecast/getForecast.php&amp;region=isr&amp;lang=<? echo $lang_idx;?>" title="<? echo($FORECAST_ISR[$lang_idx]); ?>"><? echo($FORECAST_ISR[$lang_idx]); ?></a></li>
				<li><a id="weather_hul" href="<?=$_SERVER['SCRIPT_NAME'];?>?section=forecast/getForecast.php&amp;lang=<? echo $lang_idx;?>" title="<? echo($FORECAST_ABROD[$lang_idx]); ?>" ><? echo($WORLD[$lang_idx]); ?></a></li>
				<li><a id="weather_movies" href="<? echo get_query_edited_url($url_cur, 'section', 'weatherclips.php');?>" title="<? echo $WEATHER_CLIPS[$lang_idx];?>" class="hlink"><? echo $WEATHER_CLIPS[$lang_idx];?></a></li>
                <li><a id="weather_songs" href="<? echo get_query_edited_url($url_cur, 'section', 'songs.php');?>"><?=$SONGS[$lang_idx]?></a></li>
				<li><a id="snow_poems" href="<? echo get_query_edited_url($url_cur, 'section', 'snowpoetry.php');?>" title="חמשירים" class="hlink">חמשירי שלג ועוד</a></li>
			    </ul>
			    
                <ul id="share_icons">
				<li><a href="rss_forecast.php<?echo "?lang=".$lang_idx;?>" id="rss"></a></li>
				<li><a href="https://twitter.com/YERU02WS" target="_blank" id="twitter"></a></li>
				<li><a href="https://www.facebook.com/pages/02ws-ירושמיים-מזג-האוויר-בזמן-אמת/118726368187010" target="_blank" id="facebook"></a></li>
			    </ul>
                            
			</div>
			<div id="did_you_know" class="span3 offset11">
			    <h2><?=$DID_YOU_KNOW[$lang_idx]?></h2>
			    <p><?=$DID_YOU_KNOW_EX1[$lang_idx]?></p>
			    <a href="<? echo get_query_edited_url($url_cur, 'section', 'allTimeRecords.php');?>"><?=$RECORDS[$lang_idx];?></a>
			</div>

		    </div>
            <div class="row">
            <ul id="share_mixed" class="offset3 span4">
            	<li >
            	<div class="addthis_toolbox addthis_default_style ">
                <a class="addthis_button_compact"></a>
                <iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2Fpages%2FJerusalem-Israel%2F02ws-yrwsmyym-mzg-hwwyr-bzmn-mt%2F118726368187010&amp;layout=button_count&amp;show_faces=true&amp;width=100&amp;action=like&amp;colorscheme=light&amp;height=21" style="border:none; overflow:hidden; width:100px; height:21px;allowTransparency:true"></iframe>
                </div>
					</li>
					<li>
						
					</li>
            </ul> 
            </div>      
             <div class="row">  
                 <div id="qrcode" class="span2"> 
                         <a href="small.php<?echo "?lang=".$lang_idx;?>" title="<? echo $IPHONE[$lang_idx];?>"><img src="images/qrcode.png" width="68" height="68" /></a>
                 </div>
				
            </div>
			<div class="row"> 
				 <?if (isHeb()) {?>
				 <ul id="outside_links">
                            <li><a href="http://www.jlm.israel.net/home/" title='מה יש היום בירושלים' rel='external'>מה יש היום בירושלים</a></li>
                            <li><a href="http://www.open02.com" title='open02' target="_blank">פתוח בשבת</a></li>
                            <li><a href="http://www.weather2day.co.il" title='Weather2day' target="_blank">מזג האוויר - Weather2day</a></li>
                            <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'tracks.php');?>">טיולים בירושלים</a></li>
                            <li><a href="http://hair2.co.il" title="מרכז האפילציה" rel='external'>הסרת שיער לצמיתות</a></li>
                            <li><a href="http://www.seotop.co.il" title="קידום אתרים" rel='external'>קידום אתרים</a></li>
                            <li><a href="http://israelweather.co.il" title="Israel Weather" rel='external'>Israel Weather</a></li>
				</ul>
				<?}?>
			</div>

	</div>
					
	</article>
			
	
				
	<article id="pics">
					<div class="row">
					<div id="middleadsense_container" class="span11" >
					<div id="middleadsense">
                        <script type="text/javascript"><!--
                        google_ad_client = "ca-pub-2706630587106567";
                        /* 728x90, created 3/31/10 */
                        google_ad_slot = "4039563889";
                        google_ad_width = 728;
                        google_ad_height = 90;
                        google_color_border = ["#D4F3F7"];
                        google_color_bg = ["#D4F3F7"];
                        google_color_link = ["#000000"];
                        google_color_url = ["#000000"];
                        google_color_text = ["#000000"];
                        //-->
                        </script>
                        <script type="text/javascript"
                        src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
                        </script>
                    </div>
					 <div id="plane">
						<img src="img/plane.png" width="101" height="114" alt="plane"/>
					 </div>
                     </div>
					</div>
			  <div id="tree"></div>
			<div id="crow" onMouseOver="playSound('crow_sound')"></div>
			<audio id="crow_sound">
                            <? if ($current->is_light()) { ?>
			    <source src="audio/crow.mp3"></source>
                            <?} else {?>
                            <source src="audio/owl.mp3"></source>
                            <?}?>
			</audio>
                        
                        
			
			<div class="row" id="pic_stuff">
			    <div id="album"><a href="spgm-1.3.2/index.php"  title="<?=$ALBUM_DESC[$lang_idx]?>" target="_blank"><? echo $PICTURES[$lang_idx];?></a></div>		    
			    <div id="pic_empty"></div>
			    
			    <div id="map_thumbs">
				<img id="pic_thumb1" onclick="change_pic_to('0px')" src="<?=$mediumSizeUrl?>" alt="<? echo $PIC_OF_THE_DAY[$lang_idx];?>"></img>
				<img id="pic_thumb2" onclick="change_pic_to('0px')" src="<?=$imagefile?>" alt="<? echo $LIVE_PICTURE[$lang_idx];?>"></img>
	    
			    </div>
			    		    
			    <div class="span5 offset9 white_box2" id="pic_frame">
				
				<div id="pic_contentbox" class="contentbox-wrapper">
				    <div id="live_pic" class="contentbox pic_user">
					<div class="avatar live_avatar"></div>
					<h3><? echo $LIVE_PICTURE[$lang_idx];?></h3>
                                        <h4></h4>
					<a href="<? echo "station.php?section=webCamera.jpg&amp;lang=".$lang_idx;?>"><p><? echo $PIC_DESC[$lang_idx];?><?=get_arrow()?></p>
					<img title="שידור חי  - מצלמה 2" src="phpThumb.php?src=images/webCameraB.jpg&amp;sx=200&amp;sy=150&amp;sw=350&amp;sh=350&amp;fltr[]=gam|0.4" />
					</a>
					
					
					
				    </div>
			
				</div>
				 <div id="picoftheday" class="contentbox pic_user">
					<div class="avatar picoftheday_avatar"></div>
					<h3><? echo $PIC_OF_THE_DAY[$lang_idx];?></h3>
					<h4></h4>
                    <a href="<? echo "station.php?section=picoftheday.php&amp;lang=".$lang_idx;?>">
					<p><?=$caption?>&nbsp;- <?echo $MORE_INFO[$lang_idx];?><?=get_arrow()?></p>
					</a>
                     <a href="<? echo "station.php?section=picoftheday.php&amp;lang=".$lang_idx;?>">                   
					<img src="<?=$mediumSizeUrl?>" alt="<?=$photoEntry->title->text?>" />
					</a>
				    </div>
				    
			    </div>
			</div>
					
	</article>
				
	<article id="forum">		
		<div class="container">
		    <div id="forum_grass"></div>
		      <div id="forum_sidebar">
			<h2><?=$SEARCH_IN[$lang_idx]?></h2>
			
			    <input type="text"  class="search-query" id='searchname' name="searchname" size="20" maxlength="255" value="" />
			    <input type="button" name="SearchSendButton" class="button" value="<?=$SEARCH_IN[$lang_idx]?>" onclick="getMessageService(<?=$limitLines?>, 0, 1, <?=$lang_idx?>)" />
                        
    		      <h2><?=$FILTERRING_BY_SUBJECT[$lang_idx]?></h2>
			<div id="forum_filter">
			    <div class='filter_icon1' title="Questions" key='1' onclick='getMessageService(<?=$limitLines?>, 0, 0, <?=$lang_idx?>, 1 )'></div>
			    <div class='filter_icon2' title="Hot or Cold" key='2' onclick='getMessageService(<?=$limitLines?>, 0, 0, <?=$lang_idx?>, 2 )'></div>
			    <div class='filter_icon3' title="Picture" key='3' onclick='getMessageService(<?=$limitLines?>, 0, 0, <?=$lang_idx?>, 3 )'></div>
			    <div class='filter_icon4' title="Rain" key='4' onclick='getMessageService(<?=$limitLines?>, 0, 0, <?=$lang_idx?>, 4 )'></div>
			    <div class='filter_icon5' title="Snow" key='5' onclick='getMessageService(<?=$limitLines?>, 0, 0, <?=$lang_idx?>, 5 )'></div>
			    <div class='filter_icon6' title="Wind" key='6' onclick='getMessageService(<?=$limitLines?>, 0, 0, <?=$lang_idx?>, 6 )'></div>
			    <div class='filter_icon7' title="Heat or sun" key='7' onclick='getMessageService(<?=$limitLines?>, 0, 0, <?=$lang_idx?>, 7 )'></div>
			    <div class='filter_icon8' title="Link" key='8' onclick='getMessageService(<?=$limitLines?>, 0, 0, <?=$lang_idx?>, 8 )'></div>
			</div>
			<ul>
                            <li onclick="$('#current_forum_update_display').val('R');$(this).parent().children('.selected').removeClass('selected');$(this).addClass('selected');getMessageService(<? echo date("dmY", mktime(0, 0, 0, date("m"), date("d")-1, date("y"))); ?>, 0, 0, <?=$lang_idx?>)"><?=$LAST_DAY[$lang_idx]?></li>
                            <li onclick="$('#current_forum_update_display').val('R');$(this).parent().children('.selected').removeClass('selected');$(this).addClass('selected');getMessageService(<? echo date("dmY", mktime(0, 0, 0, date("m"), date("d")-3, date("y"))); ?>, 0, 0, <?=$lang_idx?>)">3 <?=$DAYS[$lang_idx]?></li>
                            <li onclick="$('#current_forum_update_display').val('R');$(this).parent().children('.selected').removeClass('selected');$(this).addClass('selected');getMessageService(<? echo date("dmY", mktime(0, 0, 0, date("m"), date("d")-7, date("y"))); ?>, 0, 0, <?=$lang_idx?>)">7 <?=$DAYS[$lang_idx]?></li>
			    <li onclick="$('#current_forum_update_display').val('R');$(this).parent().children('.selected').removeClass('selected');$(this).addClass('selected');getMessageService('<? echo date("dmY", mktime(0, 0, 0, $month, 1, $year)); ?>', 0, 0,  <?=$lang_idx?>)"><? echo $monthInWord." ".$year; ?></li>
			    <li onclick="$('#current_forum_update_display').val('R');$(this).parent().children('.selected').removeClass('selected');$(this).addClass('selected');getMessageService('<? echo date("dmY", mktime(0, 0, 0, getPrevMonth($month), 1, getPrevMonthYear($month, $year))); ?>', 0, 0,  <?=$lang_idx?>)"><? echo $prevMonthInWord." ".getPrevMonthYear($month, $year); ?></li>
                            <!--<li onclick="$(this).parent().children('selected').removeClass('selected');$(this).addClass('selected');getMessageService('<? echo date("dmY", mktime(0, 0, 0, 1, 1, $year)); ?>', 0, 0,  <?=$lang_idx?>)"><? echo  $year; ?></li>-->
			    
			</ul>
		    </div>
		    
		    <div class="row">
			<div class="span1 offset3">
			    <div id="new_post_btn" onclick="alert('<?=$NEED_TO_REGISTER[$lang_idx]?>')">
				<?=$CREATE_NEW_MSG[$lang_idx]?>
			    </div>
			</div>
			
			<div class="span8">
                            <ul id="forum_rules">
                            <?=$MAN_EXP[$lang_idx]?>
                            </ul>
			</div>
                        
		    </div>
                    
		    <div class="row">
			<div class="span9 offset3 white_box" id="new_post">
			    <div id="new_post_user"></div>
			    <div id="new_post_container" class="span7">
				                               
				<textarea id="new_post_ta"></textarea>
                               
			    </div>
			    <div  class="span2">
                                <div id="subject_container">
				<p><?=$MSG_SUBJECT[$lang_idx]?></p>
				<div id="subject_icon"></div>
				<div id="subject_left" onclick="change_subject('left')"></div>
				<div id="subject_right" onclick="change_subject('right')"></div>
                                </div>
    				<div id="new_post_cancel" onclick="closeNewPost();restoreTopDiv();"><?=$CANCEL[$lang_idx]?></div>
				<div id="new_post_okay" onclick="getMessageService(<?=$limitLines?>, 0, 1, <?=$lang_idx?>, $('#current_forum_filter').attr('key'));closeNewPost()"><?=$SEND[$lang_idx]?></div>
			    </div>
			</div>
		    </div>
		    
		    <hr id="forum_hr" />
		    <div class="row">
		    <div class="span9 offset3">
			<script async src="http://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                        <!-- forum -->
                        <ins class="adsbygoogle"
                             style="display:inline-block;width:728px;height:90px"
                             data-ad-client="ca-pub-2706630587106567"
                             data-ad-slot="4125506694"></ins>
                        <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
                    </div>
		    </div>
		    <div class="row" id="posts">
			<a id="chat" ></a>	
                        <input type="hidden" value="" name="current_new_msg_idx" id="current_new_msg_idx" />
                        <input type="hidden" value="" id="current_display_name" />
                        <input type="hidden" value="0" id="current_forum_startline" />
                        <input type="hidden" value="" id="current_forum_filter" />
                        <input type="hidden" value="R" id="current_forum_update_display" />
						<input type="hidden" value="" id="current_post_idx" />

                        <div class="span9 offset3" id="msgDetails">

                        </div>
                        <div class="span6 offset3 ">
                            <div class='invfloat big'>
                                <a href='javascript:void(0)' onclick="getNextPage(<?=$lang_idx?>, <?=$limitLines?>)">עוד הודעות</a>
                           </div>
                        </div>
						<div class="span12 offset3 ">&nbsp;
						</div>
                        
                        
                        
	   </div> <!-- posts -->
	    <footer class="footer">Designed by <a href="http://www.behance.net/galizorea" target="_blank">Gali Zorea</a></footer>
		</div>
		<? if ($current->is_light()) { ?>  
		<img id="hill1" src="img/hill3.png" alt="hill"/>
		<img id="hill2" src="img/hill2.png" alt="hill"/>
		<img id="hill3" src="img/hill1.png" alt="hill"/>
		<img id="hill4" src="img/hill3.png" alt="hill"/>
		<img id="hill5" src="img/hill1.png" alt="hill"/>
		<img id="hill6" src="img/hill2.png" alt="hill"/>
		<? } else {?>
                <img id="hill1" src="img/hill3_night.png" alt="hill"/>
		<img id="hill2" src="img/hill2_night.png" alt="hill"/>
		<img id="hill3" src="img/hill1_night.png" alt="hill"/>
		<img id="hill4" src="img/hill3_night.png" alt="hill"/>
		<img id="hill5" src="img/hill1_night.png" alt="hill"/>
		<img id="hill6" src="img/hill2_night.png" alt="hill"/>
                <?}?>
		  	
	    </article>