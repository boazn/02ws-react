 <article id="forecast">
	<?
         include_once "picasaproxy.php";$mediumSizeUrl = "phpThumb.php?src=".$contentUrl."&amp;w=200&amp;h=200&amp;zc=C";
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
			<div class="forcast_title_btns for_active" onClick="change_main('#forcast_days', this, '<?=$lang_idx?>'); return false"><? echo($FORECAST_4D[$lang_idx]); ?></div>
			<div class="forcast_title_btns" onClick="getTempForecast(<?=$timetaf?>, '<?=$dayF."/".$monthF."/".$yearF?>');change_main('#forcast_hours', this, '<?=$lang_idx?>'); return false"><? echo(" 24 ".$HOURS[$lang_idx]);?></div>
			<div class="forcast_title_btns" onClick="change_main('#what_is_forcast', this, '<?=$lang_idx?>');toggle('mainadsense');$('#forcast_main').css('width','860px'); return false"><?=$WHAT_IS_FORECAST[$lang_idx]?></div>
					
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
								<?=c_or_f($forecastDaysDB[$i]['TempHigh'])?>&nbsp;<img style="vertical-align: middle" src="<? echo "images/clothes/".$forecastDaysDB[$i]['TempHighCloth']; ?>" width="30" height="30" title="<?=getClothTitle($forecastDaysDB[$i]['TempHighCloth'], $forecastDaysDB[$i]['TempHigh'])?>" alt="<?=getClothTitle($forecastDaysDB[$i]['TempHighCloth'],$forecastDaysDB[$i]['TempHigh'])?>" />
								</li>
								<li class="forcast_night">
								<?=c_or_f($forecastDaysDB[$i]['TempNight'])?>&nbsp;<img style="vertical-align: middle"  src="<? echo "images/clothes/".$forecastDaysDB[$i]['TempNightCloth']; ?>" width="30" height="30" title="<?=getClothTitle($forecastDaysDB[$i]['TempNightCloth'], $forecastDaysDB[$i]['TempNight'])?>" alt="<?=getClothTitle($forecastDaysDB[$i]['TempNightCloth'], $forecastDaysDB[$i]['TempNight'])?>" />
								</li>
								 <li><img src="<? echo "images/icons/day/".$forecastDaysDB[$i]['icon']; ?>" width="43" height="43" alt="<?=$forecastDaysDB[$i]['date']?>" /></li>
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
				 <div id="for24_details">
										<?=$forcastTicker?>
					<span id="tempForecastDiv" style="display:none">
					</span>
				</div>
				<ul>
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
			<? if (($current->is_light())&&(!isRaining())) {$adsense_color = "#4B6371";$adsense_background = "#BCE3EA";} elseif (isRaining()) {$adsense_color = "#FFFFFF";$adsense_background = "#6288A4";} else {$adsense_color = "#FFFFFF";$adsense_background = "#5B6A92";};?>
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
			
			<ul id="outside_links">
                            <li class="big"><a href="<? echo get_query_edited_url($url_cur, 'section', 'contact.php');?>"><?=$CONTACT_INFO[$lang_idx ]?></a></li>
			    <li><a href="http://www.jlm.israel.net/home/" title='מה יש היום בירושלים' rel='external'>מה יש היום בירושלים</a></li>
                            <li><a href="http://www.open02.com" title='open02' target="_blank">פתוח בשבת</a></li>
                            <li><a href="http://www.weather2day.co.il" title='Weather2day' target="_blank">מזג האוויר - Weather2day</a></li>
                            <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'tracks.php');?>">טיולים בירושלים</a></li>
                            <li><a href="http://hair2.co.il" title="מרכז האפילציה" rel='external'>הסרת שיער לצמיתות</a></li>
                            <li><a href="http://www.seotop.co.il" title="קידום אתרים" rel='external'>קידום אתרים</a></li>
                            <li><a href="http://israelweather.co.il" title="Israel Weather" rel='external'>Israel Weather</a></li>
			</ul>
			
			<div class="span7 offset3 more_icons">
			    <ul>
				<li><a id="weather_israel" href="<?=$_SERVER['SCRIPT_NAME'];?>?section=forecast/getForecast.php&amp;region=isr&amp;lang=<? echo $lang_idx;?>" title="<? echo($FORECAST_ISR[$lang_idx]); ?>"><? echo($FORECAST_ISR[$lang_idx]); ?></a></li>
				<li><a id="weather_hul" href="<?=$_SERVER['SCRIPT_NAME'];?>?section=forecast/getForecast.php&amp;lang=<? echo $lang_idx;?>" title="<? echo($FORECAST_ABROD[$lang_idx]); ?>" ><? echo($WORLD[$lang_idx]); ?></a></li>
				<li><a id="weather_movies" href="<? echo get_query_edited_url($url_cur, 'section', 'weatherclips.php');?>" title="<? echo $WEATHER_CLIPS[$lang_idx];?>" class="hlink"><? echo $WEATHER_CLIPS[$lang_idx];?></a></li>
                                <li><a id="weather_songs"><?=$SONGS[$lang_idx]?></a></li>
				<li><a id="snow_poems" href="<? echo get_query_edited_url($url_cur, 'section', 'poetry.php');?>" title="חמשירים" class="hlink">חמשירי שלג ועוד</a></li>
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
			    <div id="album"><a href="spgm-1.3.2/index.php"  title="<?=$ALBUM_DESC[$lang_idx]?>"><? echo $PICTURES[$lang_idx];?></a></div>		    
			    <div id="pic_empty"></div>
			    
			    <div id="map_thumbs">
				<img id="pic_thumb1" onclick="change_pic_to('0px')" src="<?=$mediumSizeUrl?>" alt="<? echo $PIC_OF_THE_DAY[$lang_idx];?>"></img>
				<img id="pic_thumb2" onclick="change_pic_to('0px')" src="<?=$imagefile?>" alt="<? echo $LIVE_PICTURE[$lang_idx];?>"></img>
	    
			    </div>
			    		    
			    <div class="span5 offset9 white_box2" id="pic_frame">
				
				<div id="pic_contentbox" class="contentbox-wrapper">
				    
				     <div id="picoftheday" class="contentbox pic_user">
					<div class="avatar picoftheday_avatar"></div>
					<h3><? echo $PIC_OF_THE_DAY[$lang_idx];?></h3>
					<h4></h4>
                                        <a href="<? echo "station.php?section=picoftheday.php&amp;lang=".$lang_idx;?>">
					<p><?=$caption?>&nbsp;- <?echo $MORE_INFO[$lang_idx];?><?=get_arrow()?></p>
                                        </a>
					<img src="<?=$mediumSizeUrl?>" alt="<?=$photoEntry->title->text?>" />
				    </div>
				    <div id="live_pic" class="contentbox pic_user">
					<div class="avatar live_avatar"></div>
					<h3><? echo $LIVE_PICTURE[$lang_idx];?></h3>
                                        <h4></h4>
					<a href="<? echo "station.php?section=webCamera.jpg&amp;lang=".$lang_idx;?>"><p><? echo $PIC_DESC[$lang_idx];?><?=get_arrow()?></p></a>
					<!--<object width="280" height="280" data="http://www.wunderground.com/swf/flowplayer.commercial-3.2.8.swf" type="application/x-shockwave-flash"><param name="movie" value="http://www.wunderground.com/swf/flowplayer.commercial-3.2.8.swf"><param name="allowfullscreen" value="true"><param name="allowscriptaccess" value="always"><param name="flashvars" value="config={&quot;key&quot;:&quot;#@8d339434b223613a374&quot;,&quot;clip&quot;:{&quot;url&quot;:&quot;http://icons.wunderground.com/webcamcurrent/b/o/boazn1/2/current.mp4&quot;,&quot;autoPlay&quot;:false,&quot;autoBuffering&quot;:true},&quot;plugins&quot;:{&quot;controls&quot;:{&quot;all&quot;:true,&quot;mute&quot;:true,&quot;play&quot;:true}},&quot;playlist&quot;:[{&quot;url&quot;:&quot;http://icons.wunderground.com/webcamcurrent/b/o/boazn1/2/current.mp4&quot;,&quot;autoPlay&quot;:false,&quot;autoBuffering&quot;:true}]}"></object>
				    -->
					<img src="<?=$imagefile?>" alt="<? echo $PIC_DESC[$lang_idx];?>" />
				    </div>
			
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
			    <div class='filter_icon1' key='1' onclick='getMessageService(<?=$limitLines?>, 0, 0, <?=$lang_idx?>, 1 )'></div>
			    <div class='filter_icon2' key='2' onclick='getMessageService(<?=$limitLines?>, 0, 0, <?=$lang_idx?>, 2 )'></div>
			    <div class='filter_icon3' key='3' onclick='getMessageService(<?=$limitLines?>, 0, 0, <?=$lang_idx?>, 3 )'></div>
			    <div class='filter_icon4' key='4' onclick='getMessageService(<?=$limitLines?>, 0, 0, <?=$lang_idx?>, 4 )'></div>
			    <div class='filter_icon5' key='5' onclick='getMessageService(<?=$limitLines?>, 0, 0, <?=$lang_idx?>, 5 )'></div>
			    <div class='filter_icon6' key='6' onclick='getMessageService(<?=$limitLines?>, 0, 0, <?=$lang_idx?>, 6 )'></div>
			    <div class='filter_icon7' key='7' onclick='getMessageService(<?=$limitLines?>, 0, 0, <?=$lang_idx?>, 7 )'></div>
			    <div class='filter_icon8' key='8' onclick='getMessageService(<?=$limitLines?>, 0, 0, <?=$lang_idx?>, 8 )'></div>
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
			    <div id="new_post_btn" onclick="openNewPost(<?=$lang_idx?>)">
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
			    <div class="span7">
				                               
				<textarea id="new_post_ta"></textarea>
                               
			    </div>
			    <div class="span2">
				<p><?=$SUBJECT[$lang_idx]?></p>
				<div id="subject_icon"></div>
				<div id="subject_left" onclick="change_subject('left')"></div>
				<div id="subject_right" onclick="change_subject('right')"></div>
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
                        <div style='display:none'>
                                <div id='href_dialog' >
                                        <div id="link_title_div">
                                                <div><?=$LINK_TITLE[$lang_idx]?> </div>
                                                <input id="linktitle" name="linktitle" size="50" maxlength="50" value=""  />

                                        </div>
                                        <div id="link_href_div">
                                                <div><?=$LINK[$lang_idx]?> </div>
                                                <input id="linkhref" name="linkhref" size="50" maxlength="500" value=""  />

                                        </div>
                                        <div class="spacer">&nbsp;</div>
                                        <div class="spacer">&nbsp;</div>
                                        <div class="float">
                                                <input type="button" name="SendButton" value="<? if (isHeb()) echo "שליחה"; else echo "Send"; ?>" class="" onclick="addlinkToMessage(false)"/>
                                        </div>
                                        <div class="float">
                                    <input type="button" name="SendButton" value="<? if (isHeb()) echo "ביטול"; else echo "Cancel"; ?>" class="" onclick="closeLinktoMessage()"/>
                                </div>
                             </div>
                        </div>
                        <div style='display:none'>
                                <div id='href_img_dialog' >
                                        <div id="img_title_div">
                                                <div><?=$LINK_TITLE[$lang_idx]?> </div>
                                                <input id="imgtitle" name="linktitle" size="50" maxlength="50" value=""  />

                                        </div>
                                        <div id="img_href_div">
                                                <div><?=$LINK[$lang_idx]?> </div>
                                                <input id="imghref" name="linkhref" size="50" maxlength="500" value=""  />

                                        </div>
                                        <div class="spacer">&nbsp;</div>
                                        <div class="spacer">&nbsp;</div>
                                        <div class="float">
                                                <input type="button" name="SendButton" value="<? if (isHeb()) echo "שליחה"; else echo "Send"; ?>" class="" onclick="addlinkToMessage(true)"/>
                                        </div>
                                        <div class="float">
                                    <input type="button" name="SendButton" value="<? if (isHeb()) echo "ביטול"; else echo "Cancel"; ?>" class="" onclick="closeLinktoMessage()"/>
                                </div>
                             </div>
                        </div>
                        <div style="display:none">
                        <div id="profileform" style="padding:1em" >
                            <div class="float">

                            <table>
                            <tr><td><?=$EMAIL[$lang_idx]?>:</td><td><input type="text" name="email" value="" readonly="readonly" id="profileform_email" size="30"/></td></tr>
                            <tr><td><?=$PASSWORD[$lang_idx]?>:</td><td><input type="password" name="password" value="" id="profileform_password"/></td></tr>
                            <tr><td><?=$USER_ICON[$lang_idx]?>:</td><td><div><div class="user_icon_frame">
                        <div id="user_icon_contentbox" class="contentbox-wrapper"> <? $user_icons = array(); $user_icons = getfilesFromdir("img/user_icon"); foreach ($user_icons as $user_icon)
                                    { ?>
                            <div class="contentbox">
                                    <div class='<? $user_icon_name =explode(".", end(explode("/",$user_icon[1]))); echo $user_icon_name[0];?>' style="width:36px;height:36px">&nbsp;</div>

                            </div>
                                <? }?></div>
                         </div>
                         <div class="icon_left" onclick="change_icon('left'); return false"></div>
                        <div class="icon_right" onclick="change_icon('right'); return false"></div>
                                    </div>
                        </td></tr>
                            <tr><td><?=$DISPLAY_NAME[$lang_idx]?>:</td><td><input type="text" name="user_display_name" value="" id="profileform_displayname"/></td></tr>
                            <tr><td><?=$NICE_NAME[$lang_idx]?>:</td><td><input type="text" name="user_nice_name" value="" id="profileform_nicename"/></td></tr>
                            </table>
                            <input type="checkbox" name="priority" value="" id="profileform_priority"/><?=$GET_UPDATES[$lang_idx]?><br /><br />
                            </div>

                            <div style="display:none" class="float loading"><img src="img/loading.gif" alt="loading" width="32" height="32" /></div>
                            <div id="profileform_result" class="float"></div>
                            <input type="submit" value="<?=$UPDATE_PROFILE[$lang_idx]?>" onclick="updateprofile_to_server(<?=$lang_idx?>)" id="profileform_submit" class="invfloat clear"/>
                            <input type="submit" value="OK" onclick="$('#cboxClose').click();window.location.reload()" id="profileform_OK" class="info invfloat" style="display:none"/>


                         </div>

                        </div>
                         <div style="display:none">

                            <div id="loginform" style="padding:1em">
                                    <div class="float">
                                    <?=$EMAIL[$lang_idx]?>:<input type="text" name="email" value="" id="loginform_email" size="30" tabindex="1" style="direction:ltr"/><br /><br />
                                    <?=$PASSWORD[$lang_idx]?>:<input type="password" name="password" value="" id="loginform_password" tabindex="2" size="15"/><br />&nbsp;&nbsp;
                                    <input type="checkbox" name="rememberme" value="" id="loginform_rememberme"/><?=$REMEMBER_ME[$lang_idx]?>
                                    </div>
                                    <div style="display:none" class="float loading"><img src="img/loading.gif" alt="loading" width="32" height="32"/></div>
                                    <div id="loginform_result" class="float"></div>
                                            <input type="submit" value="<?=$LOGIN[$lang_idx]?>" class="invfloat clear" onclick="login_to_server(<?=$lang_idx?>, <?=$limitLines?>, '<?=$_GET['update']?>')" id="loginform_submit"/>
                                    <input type="submit" value="Success!" onclick="$('#cboxClose').click();window.location.reload();" id="loginform_OK" class="info invfloat" style="display:none"/>

                            </div>
                            <div id="registerform" style="padding:1em">
                                <div id="registerinput" class="float">
                                <table>
                                <tr><td><?=$EMAIL[$lang_idx]?>:</td><td><input type="text" name="email" value="" id="registerform_email" size="30" tabindex="3" style="direction:ltr"/></td></tr>
                                <tr><td><?=$PASSWORD[$lang_idx]?>:</td><td><input type="password" name="password" value="" id="registerform_password" tabindex="4"/></td></tr>
                                <tr><td><?=$PASSWORD_VERIFICATION[$lang_idx]?>:</td><td><input type="password" name="password_verif" value="" id="registerform_password_verif" tabindex="5"/></td></tr>
                                <tr><td><?=$USER_ID[$lang_idx]?>:</td><td><input type="text" name="username" value="" id="registerform_userid" tabindex="6"/><a href="javascript:void(0)" class="info">(?)<span class="info" style="top:-50px;right:-100px"><?=$USER_ID_EXP[$lang_idx]?></span></a></td></tr>
                                <tr><td><?=$USER_ICON[$lang_idx]?>:</td><td><div><div class="user_icon_frame">
                                <div id="user_icon_contentbox" class="contentbox-wrapper"> <? $user_icons = array(); $user_icons = getfilesFromdir("img/user_icon"); foreach ($user_icons as $user_icon)
                                            { ?>
                                    <div class="contentbox">
                                            <div class='<? $user_icon_name =explode(".", end(explode("/",$user_icon[1]))); echo $user_icon_name[0];?>' style="width:36px;height:36px">&nbsp;</div>

                                    </div>
                                        <? }?></div>
                                 </div>
                                 <div class="icon_left" onclick="change_icon('left'); return false"></div>
                                <div class="icon_right" onclick="change_icon('right'); return false"></div>
                                            </div>
                                </td></tr>
                                <tr><td><?=$DISPLAY_NAME[$lang_idx]?>:</td><td><input type="text" name="user_display_name" value="" id="registerform_displayname" tabindex="7"/><a href="javascript:void(0)" class="info">(?)<span class="info" style="top:-50px;right:-100px"><?=$DISPLAY_NAME_EXP[$lang_idx]?></span></a></td></tr>
                                <tr><td><?=$NICE_NAME[$lang_idx]?>:</td><td><input type="text" name="user_nice_name" value="" id="registerform_nicename" tabindex="8"/><a href="javascript:void(0)" class="info">(?)<span class="info" style="top:-50px;right:-100px"><?=$NICENAME_EXP[$lang_idx]?></span></a></td></tr>
                                </table>
                                <input type="checkbox" name="priority" value="" id="registerform_priority"/><?=$GET_UPDATES[$lang_idx]?>
                                </div>
                                <div style="display:none" class="float loading"><img src="img/loading.gif" alt="loading" width="32" height="32" /></div>
                                <div id="registerform_result" class="float">
                                </div>
                                <input type="submit" value="<?=$REGISTER[$lang_idx]?>" class="invfloat clear" onclick="register_to_server(<?=$lang_idx?>)" id="registerform_submit"/>
                                <input type="submit" value="Success!" onclick="$('#cboxClose').click();" id="registerform_OK" class="info invfloat" style="display:none"/>

                            </div>

                            <div id="passforgotform" style="padding:1em">
                                <?=$EMAIL[$lang_idx]?>:<input type="text" name="email" value="" id="passforgotform_email" size="30" style="direction:ltr"/><br /><br />
                                <input type="submit" value="<?=$FORGOT_PASS[$lang_idx]?>" onclick="passforgot_to_server(<?=$lang_idx?>)" id="passforgotform_submit"/>
                                <input type="submit" value="Success!" onclick="$('#cboxClose').click();" id="passforgotform_OK" class="info invfloat" style="display:none"/>
                                    <div id="passforgotform_result"></div>
                             </div>
                       </div>
	   </div> <!-- posts -->
	    <p class="footer">Designed by <a href="http://www.behance.net/galizorea" target="_blank">Gali Zorea</a></p>
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