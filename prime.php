<article id="forecast">
	<?
         include_once "picasaproxy.php";$mediumSizeUrl = "phpThumb.php?src=".$contentUrl."&amp;w=180&amp;h=180&amp;zc=C";
          $sig_url = $sig[0]['url'];
        $sig_title = $sig[0]['sig'][$lang_idx];
        $imagefile = "phpThumb.php?src=".getUpdatedPic()."&amp;w=200&amp;h=200&amp;zc=C&amp;fltr%5B%5D=gam%7C0.8";//&amp;fltr[]=cont|50
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
				    <li id="morning_icon" title="<? echo $EARLY_MORNING[$lang_idx];?>"></li>
				    <li id="noon_icon" title="<? echo $NOON[$lang_idx];?>"></li>
				    <li id="night_icon" title="<?=$NIGHT_TEMP_EXP[$lang_idx]?>"></li>
				</ul>
				<ul id="forcast_table">
					<? if  (count($forecastDaysDB) == 0) 
						{
							echo $frcstTable;
							echo "<ul style=\"height:5px\"><li colspan=\"4\">".$SOURCE[$lang_idx].": ".$IMS[$lang_idx]."</li></ul>";	
	 
						}
						else 
						{
                                                    $date_a = explode("/", $forecastDaysDB[0]['date']);
                                                      if ($date_a[0] == $day)//passed midnight
                                                      {
                                                          $hightemp_value = $yest->get_hightemp();
                                                          $lowtemp_value = $yest->get_lowtemp();
                                                          $day_value = replaceDays(date("D ",  mktime ($hour, $min, 0, $month, $day-1 ,$year)));
                                                          $date_value = date("j/n",  mktime ($hour, $min, 0, $month, $day-1 ,$year));
                                                      }
                                                      else
                                                      {
                                                          $hightemp_value = $today->get_hightemp();
                                                          $lowtemp_value = $today->get_lowtemp();
                                                          $day_value = replaceDays(date("D ",  mktime ($hour, $min, 0, $month, $day ,$year)));
                                                          $date_value = date("j/n",  mktime ($hour, $min, 0, $month, $day ,$year));
                                                      }
                                                }  
							?>
                                                        <li class="forcast_each" id="yesterday_line" style="display:none">
							<ul>
                                                                <li class="forcast_off_day">

                                                                </li>
								<li class="forcast_day">
                                                                    <? echo $day_value;?>
								</li>
								<li class="forcast_date">
								<? echo $date_value;?>
								</li>
								<li class="forcast_morning">
								<?=c_or_f($lowtemp_value)?>
								</li>
								<li class="forcast_noon">
								<?=c_or_f($hightemp_value)?>
								</li>
								<li class="forcast_night">
								
								</li>
								 <li>
                                                                     
                                                                 </li>
								 <li class="forcast_text">
									
								</li>
							</ul>
							 </li>
                                            <?
							for ($i = 0; $i < count($forecastDaysDB); $i++) 
							{
                                                           $arTempHighCloth =  explode('_', $forecastDaysDB[$i]['TempHighCloth']);
                                                           $prefTempHighCloth = $arTempHighCloth[0];
                                                           $arTempNightCloth =  explode('_', $forecastDaysDB[$i]['TempNightCloth']);
                                                           $prefTempNightCloth = $arTempNightCloth[0];
							
					 ?>             
							<li class="forcast_each <?if ($i >= 5) echo "tashkif";?>" id="<?=$i?>">
							<ul>
                                                                <li class="forcast_off_day">
                                                                    <?if ($i == 0) {?>
                                                                    <a hrf="javascript:void(0)" onclick="toggle('yesterday_line');">
                                                                        <img src="images/yesterday.png" width="14" height="14" title="<?=$LAST_DAY[$lang_idx]?>" />
                                                                    </a>
                                                                    <?}?>
                                                                </li>
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
								<?=c_or_f($forecastDaysDB[$i]['TempHigh'])?>&nbsp;<a href="WhatToWear.php#<?=$prefTempHighCloth?>" rel="external" ><img style="vertical-align: middle" src="<? echo "images/clothes/".$forecastDaysDB[$i]['TempHighCloth']; ?>" width="24.3" height="20" title="<?=getClothTitle($forecastDaysDB[$i]['TempHighCloth'])?>" alt="<?=getClothTitle($forecastDaysDB[$i]['TempHighCloth'])?>" /></a>
								</li>
								<li class="forcast_night">
								<?=c_or_f($forecastDaysDB[$i]['TempNight'])?>&nbsp;<a href="WhatToWear.php#<?=$prefTempNightCloth?>" rel="external" ><img style="vertical-align: middle"  src="<? echo "images/clothes/".$forecastDaysDB[$i]['TempNightCloth']; ?>" width="24.3" height="20" title="<?=getClothTitle($forecastDaysDB[$i]['TempNightCloth'])?>" alt="<?=getClothTitle($forecastDaysDB[$i]['TempNightCloth'])?>" /></a>
								</li>
                                                                <li><a href="legend.php" rel="external" ><img src="<? echo "images/icons/day/".$forecastDaysDB[$i]['icon']; ?>" width="40" height="40" alt="<?=$forecastDaysDB[$i]['date']?>" /></a></li>
								 <li class="forcast_text">
									<? if (isHeb()) $dscpIdx = "lang1"; else $dscpIdx = "lang0"; echo urldecode($forecastDaysDB[$i][$dscpIdx]);?>
								</li>
							</ul>
							 </li>
						<?
								}
						   
						?>
				    <li class="forcast_each extra" style="margin-top:0.8em">
					<ul>
                                            <li class="forcast_off_day">
                                                
                                            </li>
					    <li style="border-top:1px dashed">
							<a href="<? echo get_query_edited_url($url_cur, 'section', 'averages.php');?>" title="<? echo $monthInWord." ".$AVERAGE[$lang_idx]; ?>">
									<? echo $AVERAGE[$lang_idx];?>
								</a><br /><br />
                                                        <a href="<? echo get_query_edited_url($url_cur, 'section', 'reports.php');?>" title="<? echo $monthInWord." ".$RECORDS[$lang_idx]; ?>">
									<? echo $RECORDS[$lang_idx];?>
								</a>
					    </li>
					    <li class="forcast_date">
							
					    </li>
					    <li class="forcast_morning">
							<? echo $monthAverge->get_lowtemp(); ?><br /><br />
                                                        <? echo $monthAverge->get_abslowtemp(); ?>
					    </li>
					    <li class="forcast_noon">
							<? echo $monthAverge->get_hightemp(); ?><br /><br />
                                                        <? echo $monthAverge->get_abshightemp(); ?>
					    </li>
                                            <li class="forcast_night">
                                                
                                            </li>
                                            <? if (isHeb()) {?>
                                           <li>
                                               <img src="images/midrag.png" width="55" height="50" alt="מדרג"/>
                                            </li>
                                            <li class="forcast_text" style="text-decoration:underline">
                                                 <a href="<? echo get_query_edited_url($url_cur, 'section', 'midrag.php');?>">בעלי מקצוע לפי עונה</a>
                                            </li>
                                            <?}?> 
					     
					</ul>
				    </li>
				    				    
			    
				</ul>
					
			    </div> <!-- forcast_days -->
			    
			     <div id="forcast_hours" class="contentbox">
				 <? echo($GIVEN[$lang_idx]." ".$AT[$lang_idx]." ".$timetaf.":00 ".$dayF."/".$monthF."/".$yearF);?>
				 <div id="for24_literal">
					<span id="tempForecastDiv" style="display:none">
					</span>
				</div>
				<ul id="for24_hours">
				 <? 
				 foreach ($forecastHour as $hour_f){
				 if (($hour_f['time'] % 3 == 0) || ($hour_f['plusminus'] > 0))
				 {
				 echo "<li class=\"nav forecasttimebox forcast_each\" ><ul>";
				 echo "<li class=\"tsfh\" style=\"text-align:center;width:0%;display:none\">".$hour_f['currentDateTime']."</li>";
                                 echo "<li class=\"tsfh\" style=\"text-align:center;width:10%\">".date("j/m", $hour_f['currentDateTime'])."</li>";
				 echo "<li class=\"timefh forcast_date\" style=\"direction:ltr;text-align:right;width:12%\"><span>".$hour_f['time'].":00";
                                    if ($hour_f['plusminus'] > 0)
                                        echo "&nbsp;&nbsp;&plusmn;".$hour_f['plusminus']."";
                                 echo "</span></li>";
				 echo "<li class=\"forecasttemp forcast_morning\" style=\"text-align:center;direction:ltr;width:7%\" id=\"tempfh".intval($hour_f['time']).intval(date("j", $hour_f['currentDateTime']))."\">"."</li>";
				 echo "<li style=\"margin-top:0;width:7%\"><img src=\"images/icons/day/".$hour_f['icon']."\" height=\"25\" width=\"28\" alt=\"".$hour_f['icon']."\" /></li>";
				
				 if ($hour_f['wind'] > 30){
					  $windtitle=$EXTREME_WINDS[$lang_idx];
					  $wind_class="high_wind";
				 }
					
				else if ($hour_f['wind'] > 20){
					  $windtitle=$STRONG_WINDS[$lang_idx];
					  $wind_class="high_wind";
				 }
					
				else if ($hour_f['wind'] > 10){
					  $windtitle=$MODERATE_WINDS[$lang_idx];
					  $wind_class="moderate_wind";
				 }
					
				else{
					  $windtitle=$WEAK_WINDS[$lang_idx];
					  $wind_class="light_wind";
				 }
					
				 echo "<li style=\"margin-top:0;\"><div title=\"".$windtitle."\" class=\"wind_icon ".$wind_class." \"></div></li>";
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
                     <? if (($current->is_light())&&(!isRaining())) 
                                    {$adsense_color = "#4B6371";
                                    if ($current->get_pm10() > 250) $adsense_background = "#C9CEB8";
                                    elseif ($current->get_cloudiness() == 8) $adsense_background = "#B8D2DC";
                                    elseif ($current->is_sunset()) $adsense_background = "#F1C3A2";
                                    elseif ($current->is_sunrise()) $adsense_background = "#E5E6C4";
                                    else $adsense_background = "#A4D2E7";}
                             elseif (($current->is_light())&&(isSnowing())) {$adsense_color = "#000000";$adsense_background = "#DAE9EA";}//D7E7E9
                             elseif (isRaining()) {$adsense_color = "#FFFFFF";$adsense_background = "#6288A4";} 
                             else {$adsense_color = "#FFFFFF"; if ($current->get_pm10() > 250) $adsense_background = "#4F5352"; else $adsense_background = "#5F6D94";};
                    ?>
                    <? if (($current->is_light())&&(!isRaining())) 
                                        {$slot = "6097239892";//day
                                        if ($current->get_pm10() > 250) $slot = "6097239892";//day
                                        elseif ($current->get_cloudiness() == 8) $slot = "1527439498";//cloudy
                                         elseif ($current->is_sunset()) $slot = "7573973091";//sunset
                                        elseif ($current->is_sunrise()) $slot = "9050706299";//sunrise
                                        else $slot = "6097239892";}
                                 elseif (($current->is_light())&&(isSnowing())) {$slot = "3004172697";}
                                 elseif (isRaining()) {$slot = "4480905893";} 
                                 else {if ($current->get_pm10() > 250) $slot = "3498857099"; else $slot = "3498857099";};//night
                        ?>
		    <div id="mainadsense" style="background:<?=$adsense_background?>; line-height: 0;box-shadow:3px 3px 15px 15px <?=$adsense_background?>">
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
                                <!-- Below forecast table -->
                                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                                <!-- Below forecast table -->
                                <ins class="adsbygoogle"
                                     style="display:inline-block;width:234px;height:60px;"
                                     data-ad-client="ca-pub-2706630587106567"
                                     data-ad-slot="<?=$slot?>"></ins>
                                <script>
                                (adsbygoogle = window.adsbygoogle || []).push({});
                                </script>          
			</div>
                   
                         
                   </div>
              <!-- row -->
		
            </article>
            
	    
	    
<article id="more">
	    
		<div class="now_messages">
		    <div class="row">
		    <div id="alerts" class="span5 offset4 white_box">
			<h2><? echo $MESSAGES[$lang_idx];?></h2>
                        <p class="box_text">
			<? echo $detailedforecast;?>
                        </p>
		    </div>
                    <div class="moon_sun span2">
			 <div id="moon_rise" onclick="window.open('http://wise-obs.tau.ac.il/cgi-bin/eran/calen.html?MO=<? echo $month;?>&amp;YE=<? echo $year;?>&amp;TI=Wise+Observatory+Schedule&amp;LO=35.167&amp;LA=31.783&amp;TZ=<?=GMT_TZ?>&amp;PLACE=2');">
                             <div id="moon_img" class="float">
                             <a href="http://wise-obs.tau.ac.il/cgi-bin/eran/calen.html?MO=<? echo $month;?>&amp;YE=<? echo $year;?>&amp;TI=Wise+Observatory+Schedule&amp;LO=35.167&amp;LA=31.783&amp;TZ=<?=GMT_TZ?>&amp;PLACE=2" rel="external" title="<? echo $MORE_INFO[$lang_idx];?>">
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
		    
		    <div class="span5 offset4 white_box">
			<h2><? echo $MainStory->get_title();?></h2>
			<p class="box_text">
                            <a href="<? echo "station.php?section=mainstory.php&amp;lang=".$lang_idx;?>">
			 <? echo mb_substr($MainStory->get_description(), 0, 68, "UTF-8");?>...<?echo $MORE_INFO[$lang_idx];?><?=get_arrow()?>
                            </a>
			</p>
		    </div>
                        
                    <div id="adexternal" class="span2">

                    </div>
                         
		    
		    </div>
		    
		    <div class="row more_stuff">
<!--			<div id="newsletter">
			    <h2>רשימת תפוצה</h2>
			    <form class="email_form" method="get" action="">
				<input type="text"  class="search-query" name="q" value="youremail@domain.com" onfocus="if(this.value == 'youremail@domain.com') { this.value = ''; }" onfocusout="if(this.value == '') { this.value = 'youremail@domain.com'; }"/>
				 <input type="submit" value="שליחה" />
			    </form>
			</div>-->
			<div id="did_you_know" class="span3">
			    <h2><?=$DID_YOU_KNOW[$lang_idx]?></h2>
			    <p><?=$DID_YOU_KNOW_EX1[$lang_idx]?></p>
			    <a href="<? echo get_query_edited_url($url_cur, 'section', 'allTimeRecords.php');?>"><?=$RECORDS[$lang_idx];?></a>
			</div>
			<div class="span7 offset1 more_icons">
			    <ul>
				<li><a id="weather_israel" href="<?=$_SERVER['SCRIPT_NAME'];?>?section=forecast/getForecast.php&amp;region=isr&amp;lang=<? echo $lang_idx;?>" title="<? echo($FORECAST_ISR[$lang_idx]); ?>"><? echo($FORECAST_ISR[$lang_idx]); ?></a></li>
				<li><a id="weather_hul" href="<?=$_SERVER['SCRIPT_NAME'];?>?section=forecast/getForecast.php&amp;lang=<? echo $lang_idx;?>" title="<? echo($FORECAST_ABROD[$lang_idx]); ?>" ><? echo($WORLD[$lang_idx]); ?></a></li>
				<li><a id="weather_movies" href="<? echo get_query_edited_url($url_cur, 'section', 'weatherclips.php');?>" title="<? echo $WEATHER_CLIPS[$lang_idx];?>" class="hlink"><? echo $WEATHER_CLIPS[$lang_idx];?></a></li>
                                <li><a id="weather_songs" href="<? echo get_query_edited_url($url_cur, 'section', 'songs.php');?>"><?=$SONGS[$lang_idx]?></a></li>
				<li><a id="snow_poems" href="<? echo get_query_edited_url($url_cur, 'section', 'snow.php');?>" class="hlink"><? echo $SNOW_JER[$lang_idx];?></a></li>
			    </ul>
			</div>
			
                   </div>
                    <div class="row">
                        &nbsp;
                    </div>  
                    <div class="row">
                        &nbsp;
                    </div>
                     <div class="row">
                        &nbsp;
                    </div>
                     <div class="row">
                        &nbsp;
                    </div>
                    <div class="row">
                        &nbsp;
                    </div>
                     <div class="row">
                        &nbsp;
                    </div>
                     <div class="row">
                        &nbsp;
                    </div>
                    <div class="row">
                        &nbsp;
                    </div>
                     <div class="row">
                        &nbsp;
                    </div>
             
                    <div class="row"> 
                           <div id="gp_icon" class="span8">
                                <a href="https://play.google.com/store/apps/details?id=il.co.jws.app" target="_blank">
                                    <img src="images/getitongp.svg" alt="Google play App" width="150" height="60"/>
                                </a>
                               <a href="https://apksfull.com/%D7%99%D7%A8%D7%95%D7%A9%D7%9E%D7%99%D7%99%D7%9D-il-co-jws-app/" target="_blank">
                               APK
                               </a>
                               <a href="https://itunes.apple.com/us/app/yrwsmyym/id925504632?ls=1&mt=8" target="_blank">
                                    <img src="images/Available_on_the_App_Store.svg" alt="App Store App" width="150" height="60"/>
                                </a>
                               <div id="qrcode" class="span4"> 
                                <a href="small.php<?echo "?lang=".$lang_idx;?>" title="<? echo $MOBILE_FRIENDLY[$lang_idx];?>"><img src="images/qrcode.png" width="68" height="68" alt="qrcode" /></a>
                                </div>
                            </div>
                            <?if (isHeb()) {?>
                            <ul id="outside_links">
                               <li><a href="http://www.open02.com" title='open02' target="_blank">פתוח בשבת</a></li>
                               <li><a href="https://www.boxiplus.com" title='boxiplus' target="_blank">boxiplus</a></li>        
                               <li><a href="http://www.weather2day.co.il" title='Weather2day' target="_blank">מזג האוויר - Weather2day</a></li>
                               <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'tracks.php');?>">טיולים בירושלים</a></li>
                               <li><a href="http://hair2.co.il" title="מרכז האפילציה" rel='external'>הסרת שיער לצמיתות</a></li>
                               <li><a href="http://www.seotop.co.il" title="קידום אתרים" rel='external'>קידום אתרים</a></li>
                           </ul>
                           <?}?>
                    </div>
                    <div class="row"> 
                        

                    </div>

	</div>
					
	</article>
			
	
				
	<article id="pics">
					<div class="row">
					<div id="middleadsense_container" class="span11" >
					<div id="middleadsense">
                                         <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                                         <!-- 728x90, created 3/31/10 -->
                                         <ins class="adsbygoogle"
                                              style="display:inline-block;width:728px;height:90px"
                                              data-ad-client="ca-pub-2706630587106567"
                                              data-ad-slot="4039563889"></ins>
                                         <script>
                                         (adsbygoogle = window.adsbygoogle || []).push({});
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
			    <source src="audio/crow.mp3" />
                            <?} else {?>
                            <source src="audio/owl.mp3" />
                            <?}?>
			</audio>
                        
                        
			
			<div class="row" id="pic_stuff">
			    <div id="album"><a href="spgm-1.3.2/index.php"  title="<?=$ALBUM_DESC[$lang_idx]?>" target="_blank"><? echo $PICTURES[$lang_idx];?></a></div>		    
			    <div id="pic_empty"></div>
			    
			    <div id="map_thumbs">
				<img id="pic_thumb1" onclick="change_pic_to('0px')" src="<?=$mediumSizeUrl?>" alt="<? echo $PIC_OF_THE_DAY[$lang_idx];?>" />
				<img id="pic_thumb2" onclick="change_pic_to('0px')" src="<?=$imagefile?>" alt="<? echo $LIVE_PICTURE[$lang_idx];?>" />
	    
			    </div>
			    		    
			    <div class="span5 offset9 white_box2" id="pic_frame">
				
				<div id="pic_contentbox" class="contentbox-wrapper">
				    <div id="live_pic" class="contentbox pic_user">
					<div class="avatar live_avatar"></div>
					<h3><? echo $LIVE_PICTURE[$lang_idx];?></h3>
                                        <h4></h4>
					<a href="<? echo "station.php?section=webCamera.jpg&amp;lang=".$lang_idx;?>"><p><? echo $PIC_DESC[$lang_idx];?><?=get_arrow()?></p>
					<img title="שידור חי  - מצלמה 2" src="phpThumb.php?src=<?=getUpdatedPic()?>&amp;sx=200&amp;sy=150&amp;sw=350&amp;sh=350&amp;fltr%5B%5D=gam%7C0.8" alt="live pic" />
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
			    <input type="button" name="SearchSendButton" class="button" value="<?=$SEARCH_IN[$lang_idx]?>" onclick="getMessageService(<?=$limitLines?>, '', 0, 1, <?=$lang_idx?>)" />
                        
    		      <h2><?=$FILTERRING_BY_SUBJECT[$lang_idx]?></h2>
			<div id="forum_filter">
			    <div class='filter_icon1' title="Questions" data-key='1' onclick='getMessageService(<?=$limitLines?>,"", 0, 0, <?=$lang_idx?>, 1 )'></div>
			    <div class='filter_icon2' title="Hot or Cold" data-key='2' onclick='getMessageService(<?=$limitLines?>,"", 0, 0, <?=$lang_idx?>, 2 )'></div>
			    <div class='filter_icon3' title="Picture" data-key='3' onclick='getMessageService(<?=$limitLines?>,"", 0, 0, <?=$lang_idx?>, 3 )'></div>
			    <div class='filter_icon4' title="Rain" data-key='4' onclick='getMessageService(<?=$limitLines?>,"", 0, 0, <?=$lang_idx?>, 4 )'></div>
			    <div class='filter_icon5' title="Snow" data-key='5' onclick='getMessageService(<?=$limitLines?>,"", 0, 0, <?=$lang_idx?>, 5 )'></div>
			    <div class='filter_icon6' title="Wind" data-key='6' onclick='getMessageService(<?=$limitLines?>,"", 0, 0, <?=$lang_idx?>, 6 )'></div>
			    <div class='filter_icon7' title="Heat or sun" data-key='7' onclick='getMessageService(<?=$limitLines?>,"", 0, 0, <?=$lang_idx?>, 7 )'></div>
			    <div class='filter_icon8' title="Link" data-key='8' onclick='getMessageService(<?=$limitLines?>,"", 0, 0, <?=$lang_idx?>, 8 )'></div>
			</div>
			<ul>
                            <li onclick="$('#current_forum_update_display').val('R');$(this).parent().children('.selected').removeClass('selected');$(this).addClass('selected');getMessageService('<? echo date("dmY", mktime(0, 0, 0, date("m"), date("d")-1, date("y"))); ?>', '', 0, 0, <?=$lang_idx?>)"><?=$LAST_DAY[$lang_idx]?></li>
                            <li onclick="$('#current_forum_update_display').val('R');$(this).parent().children('.selected').removeClass('selected');$(this).addClass('selected');getMessageService('<? echo date("dmY", mktime(0, 0, 0, date("m"), date("d")-3, date("y"))); ?>', '', 0, 0, <?=$lang_idx?>)">3 <?=$DAYS[$lang_idx]?></li>
                            <li onclick="$('#current_forum_update_display').val('R');$(this).parent().children('.selected').removeClass('selected');$(this).addClass('selected');getMessageService('<? echo date("dmY", mktime(0, 0, 0, date("m"), date("d")-7, date("y"))); ?>', '', 0, 0, <?=$lang_idx?>)">7 <?=$DAYS[$lang_idx]?></li>
			    <li onclick="$('#current_forum_update_display').val('R');$(this).parent().children('.selected').removeClass('selected');$(this).addClass('selected');getMessageService('<? echo date("dmY", mktime(0, 0, 0, $month, 1, $year)); ?>', '', 0, 0,  <?=$lang_idx?>)"><? echo $monthInWord." ".$year; ?></li>
			    <li onclick="$('#current_forum_update_display').val('R');$(this).parent().children('.selected').removeClass('selected');$(this).addClass('selected');getMessageService('<? echo date("dmY", mktime(0, 0, 0, getPrevMonth($month), 1, getPrevMonthYear($month, $year))); ?>','<? echo date("dmY", mktime(0, 0, 0, $month, 1, $year)); ?>', 0, 0,  <?=$lang_idx?>)"><? echo $prevMonthInWord." ".getPrevMonthYear($month, $year); ?></li>
                            <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'snowpoetry.php');?>" title="חמשירים" class="hlink">חמשירי שלג ועוד</a></li>
                            <li><a href="http://madeinjlm.org/" target="_blank"><img src="images/madeinjlm.png" width="146" height="144" alt="Made in Jerusalem" /></a></li>
			    
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
                                <div id="new_post_alert"><input type="checkbox" id="check_alert_msg" /><?=$ALERT_MSG_TO_SENDER[$lang_idx]?></div>
                                <div id="new_post_private" style="display:none"><input type="checkbox" id="check_private_msg" /><?=$PRIVATE_MSG_TO_SENDER[$lang_idx]?></div>
    				<div id="new_post_cancel" onclick="closeNewPost();restoreTopDiv();"><?=$CANCEL[$lang_idx]?></div>
				<div id="new_post_okay" onclick="closeNewPost();getMessageService(<?=$limitLines?>, '', 0, 1, <?=$lang_idx?>, $('#current_forum_filter').attr('data-key'));"><?=$SEND[$lang_idx]?></div>
			    </div>
			</div>
		    </div>
		    
		    <hr id="forum_hr" />
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