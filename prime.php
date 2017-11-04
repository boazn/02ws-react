<article id="forecast">
	<?
        // fetch once again because it is cut otherwise
        $forecastDaysDB = apc_fetch('forecastDaysDB');
         include_once "picasaproxy.php";$mediumSizeUrl = "phpThumb.php?src=".$contentUrl."&amp;w=180&amp;h=180&amp;zc=C";
          $sig_url = $sig[0]['url'];
        $sig_title = $sig[0]['sig'][$lang_idx];
        $imagefile = "phpThumb.php?src=".getUpdatedPic()."&amp;w=200&amp;h=200&amp;zc=C&amp;fltr%5B%5D=gam%7C0.8";//&amp;fltr[]=cont|50
        $current_story_img_src = "phpThumb.php?src=".$current_story_img_src."&amp;w=200&amp;h=200&amp;zc=C";//&amp;fltr[]=cont|50 ;
        /////////////////////////////////////////
        $floated = false;
        $random_midrag = rand(0,9);
        $random_did_you_know = rand(0, count($DID_YOU_KNOW_EX)-1);
        $MIDRAG_T = array("ירושלמים לירושלמים – לא בוחרים בעל מקצוע בלי לבדוק חוות דעת קודמות.", 
                          "400,000 חוות דעת. בוחרים בעל מקצוע רק אחרי שקראנו חוות דעת קודמות.  ", 
                          "פעם לכל הירושלמים הייתה הסקה מרכזית, היום כולם עוברים למזגן... מתקיני מזגנים מומלצים פה", 
                          "לא לשכוח להעביר את המזגן מקור לחום...!  טכנאי מזגנים שירושלמים אחרים המליצו עליהם פה ",
                          "מחפשים מוביל מגילה לנחלאות? ירושלמים ממליצים על מובילים אמינים ",
                        "קיבלתם ספה מהדודה של השכן? מובילים מומלצים גם להובלות קטנות פה", 
                        "הגשם נכנס אליכם הביתה? תגידו די לרטיבות! אנשי איטום אמינים עם מאות המלצות במידרג", 
                        "הגשם כבר פה ואיתו הרטיבות. טפלו עכשיו עם מומחי איטום שירושלמים אחרים המליצו עליהם ", 
                        "לא נכנסים לשיפוץ בלי לדעת בוודאות שבחרנו בעל מקצוע מעולה. ירושלמים עוזרים לירושלמים- מאות חוות דעת על שיפוצים קודמים. ", 
                        "גשם, רוח, גראופל... לתיקונים ושיפוצים קחו המלצות מירושלמים שמדברים את השפה שלכם");
        $MIDRAG_I = array("images/midragdefault.png", 
                            "images/midragdefault.png", 
                            "images/midragairCondition.png", 
                            "images/midragairCondition.png", 
                            "images/midragmoving.png", 
                            "images/midragmoving.png", 
                            "images/midragsealing.png", 
                            "images/midragsealing.png", 
                            "images/midragrenovation.png", 
                            "images/midragrenovation.png");
        $MIDRAG_L = array($_SERVER['SCRIPT_NAME']."?section=midrag.php", 
                            $_SERVER['SCRIPT_NAME']."?section=midrag.php", 
                            $_SERVER['SCRIPT_NAME']."?section=midrag.php&l=E6127R0GV18085LY64028", 
                            $_SERVER['SCRIPT_NAME']."?section=midrag.php&l=761NTJ0B5493O9UO0RMR7",
                            $_SERVER['SCRIPT_NAME']."?section=midrag.php&l=BT9IUX8K91S012K27W1J77448J85YI9G102",
                            $_SERVER['SCRIPT_NAME']."?section=midrag.php&l=V798L487715GC3QX1GB7135750C7X94L7J7", 
                            $_SERVER['SCRIPT_NAME']."?section=midrag.php&l=V584G432065L06RO7#filter", 
                            $_SERVER['SCRIPT_NAME']."?section=midrag.php&l=OX8Y224XC6Y6Q75Q2", 
                            $_SERVER['SCRIPT_NAME']."?section=midrag.php&l=Z737BA86D34WJ02W7", 
                            $_SERVER['SCRIPT_NAME']."?section=midrag.php&l=9N15LH0X372TP75W550614Z7NC24152U438NI3");
        $DID_YOU_KNOW_LINK = array(get_query_edited_url($url_cur, 'section', 'allTimeRecords.php'), get_query_edited_url($url_cur, 'section', 'myVotes.php'), get_query_edited_url($url_cur, 'section', 'snow.php'));
        $DID_YOU_KNOW_TITLE = array($RECORDS[$lang_idx], $MY_VOTES[$lang_idx], $SNOW_JER[$lang_idx]);
        ////////////////////////////////////////
                $overlook_d = "<a href=\"javascript:void(0)\" class=\"info\">".$OVERLOOK[$lang_idx]."<span class=\"info\">".$OVERLOOK_EXP[$lang_idx]."</span></a>";
        ?>
		<div class="row">
		    <div id="forcast_title">
			<div class="forcast_title_btns for_active" onClick="change_main('#forcast_days', this, '<?=$lang_idx?>');"><? echo($FORECAST_4D[$lang_idx]); ?></div>
			<div class="forcast_title_btns" onClick="change_main('#forcast_hours', this, '<?=$lang_idx?>');"><? echo(" 24 ".$HOURS[$lang_idx]);?></div>
                        <div class="forcast_title_btns" onClick="getTempForecast(<?=$timetaf?>, '<?=$dayF."/".$monthF."/".$yearF?>');change_main('#forcast_hours_table', this, '<?=$lang_idx?>');"><? echo(" 24 ".$HOURS[$lang_idx]." ".$IN_TABLE[$lang_idx]);?></div>
			<div class="forcast_title_btns"><a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=forecast/getForecast.php&amp;lang=<? echo $lang_idx;?>" title="<? echo($FORECAST_ABROD[$lang_idx]); ?>" ><? echo($WORLD[$lang_idx]); ?></a></div>		
                        <div class="forcast_title_btns"><a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=forecast/getForecast.php&amp;region=isr&amp;lang=<? echo $lang_idx;?>" title="<? echo($FORECAST_ISR[$lang_idx]); ?>"><? echo($FORECAST_ISR[$lang_idx]); ?></a></div>
                        <div class="forcast_title_btns"><a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=ForecasterJob.php&amp;lang=<? echo $lang_idx;?>" title="<?=$WHAT_IS_FORECAST?>"><?=$FORECASTER_JOB[$lang_idx]?></a></div>
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
                                                    $textsum = 0;
                                                    $date_a = explode("/", array_slice($forecastDaysDB, 0, 1)[0]['date']);
                                                      if ($date_a[0] == $day)//passed midnight
                                                      {
                                                          $hightemp_value = $yest->get_temp_day();
                                                          $lowtemp_value = $yest->get_temp_morning();
                                                          $nighttemp_value = $yest->get_temp_night();
                                                          $day_value = replaceDays(date("D ",  mktime ($hour, $min, 0, $month, $day-1 ,$year)));
                                                          $date_value = date("j/n",  mktime ($hour, $min, 0, $month, $day-1 ,$year));
                                                      }
                                                      else
                                                      {
                                                          $hightemp_value = $today->get_temp_day();
                                                          $lowtemp_value = $today->get_temp_morning();
                                                          $nighttemp_value = $current->get_temp();
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
								<?=c_or_f($nighttemp_value)?>
								</li>
								 <li>
                                                                     
                                                                 </li>
								 <li class="forcast_text">
									
								</li>
							</ul>
							 </li>
                                            <?
                                                         $i = 0; 
                                                         
							 foreach ($forecastDaysDB as $key => &$forecastday) 
							{
                                                           $arTempHighCloth =  explode('_', $forecastday['TempHighCloth']);
                                                           $prefTempHighCloth = $arTempHighCloth[0];
                                                           $arTempNightCloth =  explode('_', $forecastday['TempNightCloth']);
                                                           $prefTempNightCloth = $arTempNightCloth[0];
                                                           
					 ?>             
							<li class="forcast_each <?if ($i >= TASHKIF_START) echo "tashkif";?>" id="<?=$key?>" name="<?=$key?>">
							<ul>
                                                                <li class="forcast_off_day">
                                                                    <?if ($i == 0) {?>
                                                                    <a hrf="javascript:void(0)" onclick="toggle('yesterday_line');">
                                                                        <img src="images/yesterday.png" width="14" height="14" title="<?=$LAST_DAY[$lang_idx]?>" />
                                                                    </a>
                                                                    <?}?>
                                                                </li>
								<li class="forcast_day">
								<? echo replaceDays($forecastday['day_name']." ");?><? if ($i >= TASHKIF_START) echo "<p>".$overlook_d."</p>";?>
								</li>
								<li class="forcast_date">
								<? echo $forecastday['date'];?>
								</li>
								<li class="forcast_morning">
								<?=c_or_f($forecastday['TempLow'])?>
								</li>
								<li class="forcast_noon">
								<?=c_or_f($forecastday['TempHigh'])?>&nbsp;<a href="WhatToWear.php#<?=$prefTempHighCloth?>" rel="external" ><img style="vertical-align: middle" src="<? echo "images/clothes/".$forecastday['TempHighCloth']; ?>" width="24.3" height="20" title="<?=getClothTitle($forecastday['TempHighCloth'], $forecastday['TempHigh'])?>" alt="<?=getClothTitle($forecastday['TempHighCloth'], $forecastday['TempHigh'])?>" /></a>
								</li>
								<li class="forcast_night">
								<?=c_or_f($forecastday['TempNight'])?>&nbsp;<a href="WhatToWear.php#<?=$prefTempNightCloth?>" rel="external" ><img style="vertical-align: middle"  src="<? echo "images/clothes/".$forecastday['TempNightCloth']; ?>" width="24.3" height="20" title="<?=getClothTitle($forecastday['TempNightCloth'], $forecastday['TempNight'])?>" alt="<?=getClothTitle($forecastday['TempNightCloth'], $forecastday['TempNight'])?>" /></a>
								</li>
                                                                <li><?if ($i == 0) echo get_param_tag($forecastday['TempHigh'] - round($hightemp_value), true, false);?>
                                                                    <a href="legend.php" rel="external" ><img src="<? echo "images/icons/day/".$forecastday['icon']; ?>" width="40" height="40" alt="<?=$forecastday['date']?>" /></a>
                                                                </li>
								<li class="forcast_text">
									<? if (isHeb()) $dscpIdx = "lang1"; else $dscpIdx = "lang0"; echo urldecode($forecastday[$dscpIdx]);$textsum = $textsum + strlen(urldecode($forecastday[$dscpIdx]));?>
                                   				<?if ($i < 5) {?>
                                                                <div id="divlikes<?=$key?>" style="float:<?echo get_inv_s_align();?>;padding:0.2em;">		
                                                                        <img src="js/tinymce/plugins/emoticons/img/good.png" width="16px" onclick="updateLikes(this.parentNode.parentNode.parentNode.parentNode.id, 'like')" style="cursor:pointer" />
                                                                        <span class="likes" style="font-size: 0.85em"><?=count($forecastDaysDB[$key]["likes"])?></span>
                                                                        <img src="js/tinymce/plugins/emoticons/img/bad.png" width="16px" onclick="updateLikes(this.parentNode.parentNode.parentNode.parentNode.id, 'dislike')" style="cursor:pointer" />
                                                                        <span class="dislikes" style="font-size: 0.85em"><?=count($forecastDaysDB[$key]["dislikes"])?></span>
                                                                </div>
                                                                <?}?>
                                                                </li>
							</ul>
							 </li>
						<?
								$i++;}
                                                                
						?>
				    <li class="forcast_each extra" style="margin-top:0.4em">
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
                                               <img src="<?=$MIDRAG_I[$random_midrag]?>" width="45" height="55" alt="מדרג"/>
                                            </li>
                                            <li class="forcast_text below_forecast">
                                                 <a href="<?=$MIDRAG_L[$random_midrag]?>"><?=$MIDRAG_T[$random_midrag]?></a>
                                            </li>
                                            <?}?> 
					     
					</ul>
				    </li>
				    				    
			    
				</ul>
					
			    </div> <!-- forcast_days -->
			    
			     <div id="forcast_hours" class="contentbox">
                                 <div id="graph_forcast" >
				 <canvas id="graphForcastContainer" style="position: relative"></canvas>
                                <div id="chartjs-tooltip" class="inv_plain_3_zebra"></div>
				<div id="for24_literal">
					<span id="tempForecastDiv" style="display:none">
					</span>
				</div>
				<ul class="for24_hours">
				 <? 
                                 $sigforecastHour = apc_fetch('sigforecastHour');
                                 foreach ($sigforecastHour as $hour_f){
				 echo "<li class=\"nav forecasttimebox forcast_each\" ><ul>";
				 echo "<li class=\"tsfh\" style=\"text-align:center;width:0%;display:none\">".$hour_f['currentDateTime']."</li>";
                                 echo "<li class=\"tsfh\" style=\"text-align:center;width:10%\">".date("j/m", $hour_f['currentDateTime'])."</li>";
				 echo "<li class=\"timefh forcast_date\" style=\"direction:ltr;text-align:right;width:12%\"><span>".$hour_f['time'].":00";
                                    if ($hour_f['plusminus'] > 0)
                                        echo "&nbsp;&plusmn;".$hour_f['plusminus']."";
                                 echo "</span></li>";
				 echo "<li class=\"forecasttemp forcast_morning\" style=\"text-align:center;direction:ltr;width:7%\" id=\"tempfh".intval($hour_f['time']).intval(date("j", $hour_f['currentDateTime']))."\">"."</li>";
				 echo "<li>&nbsp;<img style=\"vertical-align: middle\"  src=\"images/clothes/".$hour_f['cloth']."\" width=\"24.3\" height=\"20\" /></li>";
                                 echo "<li style=\"margin-top:0;width:7%\"><img src=\"images/icons/day/".$hour_f['icon']."\" height=\"25\" width=\"28\" alt=\"".$hour_f['icon']."\" /></li>";
				 echo "<li style=\"margin-top:0;\"><div title=\"".getWindInfo($hour_f['wind'], $lang_idx)['windtitle']."\" class=\"wind_icon ".getWindInfo($hour_f['wind'], $lang_idx)['wind_class']." \"></div></li>";
				 echo "<li>".$hour_f['title'][$lang_idx]."</li>";
				 echo "</ul></li>";
				 }
				 ?>
				</ul>
                                 </div>
			    </div>
			    
			    <div id="forcast_hours_table" class="contentbox">
				<ul class="for24_hours">
				 <? 
                                 $forecastHour = apc_fetch('forecasthour');
                                 foreach ($forecastHour as $hour_f){
                                     if (($hour_f['plusminus'] != "") || ($hour_f['time'] % 3 == 0)){
                                        echo "<li class=\"nav forecasttimebox forcast_each\" ><ul>";
                                        echo "<li class=\"tsfh\" style=\"text-align:center;width:0%;display:none\">".$hour_f['currentDateTime']."</li>";
                                        echo "<li class=\"tsfh\" style=\"text-align:center;width:10%\">".date("j/m", $hour_f['currentDateTime'])."</li>";
                                        echo "<li class=\"timefh forcast_date\" style=\"direction:ltr;text-align:right;width:12%\"><span>".$hour_f['time'].":00";
                                           if ($hour_f['plusminus'] > 0)
                                               echo "&nbsp;&plusmn;".$hour_f['plusminus']."";
                                        echo "</span></li>";
                                        echo "<li class=\"forecasttemp forcast_morning\" style=\"text-align:center;direction:ltr;width:7%\" id=\"tempfh".intval($hour_f['time']).intval(date("j", $hour_f['currentDateTime']))."\">"."</li>";
                                        echo "<li>&nbsp;<img style=\"vertical-align: middle\"  src=\"images/clothes/".$hour_f['cloth']."\" width=\"24.3\" height=\"20\" /></li>";
                                        echo "<li style=\"margin-top:0;width:7%\"><img src=\"images/icons/day/".$hour_f['icon']."\" height=\"25\" width=\"28\" alt=\"".$hour_f['icon']."\" /></li>";
                                        echo "<li style=\"margin-top:0;\"><div title=\"".getWindInfo($hour_f['wind'], $lang_idx)['windtitle']."\" class=\"wind_icon ".getWindInfo($hour_f['wind'], $lang_idx)['wind_class']." \"></div></li>";
                                        echo "<li>".$hour_f['title'][$lang_idx]."</li>";
                                        echo "</ul></li>";
                                     }
				 }
				 ?>
				</ul>
                               
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
                                        {$slot = "6243829498";//day
                                        if ($current->get_pm10() > 250) $slot = "9197295893";//dust
                                        elseif ($current->get_cloudiness() == 8) $slot = "4627495496";//cloudy
                                         elseif ($current->is_sunset()) $slot = "3150762292";//sunset
                                        elseif ($current->is_sunrise()) $slot = "1674029096";//sunrise
                                        else $slot = "6243829498";}//day
                                 elseif (($current->is_light())&&(isSnowing())) {$slot = "7580961891";}//snow
                                 elseif (isRaining()) {$slot = "6104228694";}//rain 
                                 else {if ($current->get_pm10() > 250) $slot = "7720562695"; else $slot = "7720562695";};//night
                        ?>
		    <div id="mainadsense" style="background:<?=$adsense_background?>; line-height: 0;box-shadow:3px 3px 15px 15px <?=$adsense_background?>">
			        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                                <!-- responsive main - cloudy -->
                                <ins class="adsbygoogle"
                                     style="display:block"
                                     data-ad-client="ca-pub-2706630587106567"
                                     data-ad-slot="<?=$slot?>"
                                     data-ad-format="rectangle"></ins>
                                <script>
                                (adsbygoogle = window.adsbygoogle || []).push({});
                                </script>
                                <div style="vertical-align: text-bottom;bottom: 0px;position: absolute;line-height: 20px;
    width: 28%;text-align: right;">
                                <a href="http://bit.ly/2zLxUj4" target="_blank" style="direction:rtl">
                                    מעל ל-800 רצים נרשמו למרוץ היהודי-ערבי הגדול!<br />
קחו חלק בחוויה - 
                                </a>
                                </div>
			</div>
                   
                         
                   </div>
              <!-- row -->
		
            </article>
            
	    
	    
<article id="more" style="<? if (($textsum >= 580)||(count($forecastDaysDB) > 6)) echo "top:790px";?>">
	    
		<div class="now_messages">
		    <div class="row">
                   
		    <div id="alerts" class="span5 offset4 white_box">
			<h2><? echo $MESSAGES[$lang_idx];?></h2>
                        <p class="box_text">
			<? echo $detailedforecast;?>
                        </p>
                        <p id="personal_message" class="box_text">
     
                        </p>
                     
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
			
		    <div class="row" style="margin-bottom: 0.2em">
		    
		    <div class="span5 offset4 white_box">
			<? if (isHeb()) { ?><h2><? echo $MainStory->get_title();?></h2>
			<p class="box_text">
                            <a href="<? echo "station.php?section=mainstory.php&amp;lang=".$lang_idx;?>">
			 <? echo mb_substr($MainStory->get_description(), 0, 68, "UTF-8");?>...<?echo $MORE_INFO[$lang_idx];?><?=get_arrow()?>
                            </a>
                            <a href="<?=$href?>" href="<? echo "station.php?section=mainstory.php&amp;lang=".$lang_idx;?>" class="invfloat">
                            <?
                             $box_img_src = $MainStory->get_img_src();$img_title = $MainStory->get_title();
                             echo "<img src=\"$box_img_src\" title=\"".$img_title."\" id=\"mainpic\" alt=\"".$img_title."\" width=\"40px\" />";
                            ?>
                            </a>
			</p>
			<?}?>
		    </div>
                        
                    <div id="adexternal" class="span2">
                       <a data-p1xtr="widget-button" data-p1xtr-image="http://www.02ws.co.il/img/logo_rain.svg"></a>
                    </div>
                         
		    
		    </div>
		    
		    <div class="row more_stuff">
                        
			<div id="did_you_know" class="span3">
                            
                            <h2><?=$DID_YOU_KNOW[$lang_idx]?></h2>
			    <p><?=$DID_YOU_KNOW_EX[$random_did_you_know][$lang_idx]?></p>
			    <a href="<?=$DID_YOU_KNOW_LINK[$random_did_you_know]?>"><?=$DID_YOU_KNOW_TITLE[$random_did_you_know];?></a>
			</div>
			<div class="span7 offset1 more_icons">
                            
			    <ul>
				<li></li>
                                <li></li>
				<li></li>
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
                               
                            </div>
                            <?if (isHeb()) {?>
                            
                            <ul id="outside_links">
                               <li><a href="https://www.facebook.com/openopeninjerusalem/?fref=ts" title='open02' target="_blank">פתוח בשבת</a></li>
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
                        <div id="train" onMouseOver="playSound('train_sound')"></div>
                        <div id="train2" onMouseOver="playSound('train2_sound')"></div>
			<audio id="train_sound">
           		    <source src="audio/lightrain.wav" />
 			</audio>
                        <audio id="train2_sound">
           		    <source src="audio/lightrainbell.wav" />
                            <source src="audio/lightrainpassing.wav" />
 			</audio>
			
			<div class="row" id="pic_stuff">
			    <div id="album"><a href="spgm-1.3.2/index.php"  title="<?=$ALBUM_DESC[$lang_idx]?>" target="_blank"><? echo $PICTURES[$lang_idx];?></a></div>
                            <div id="userpic"><a href="<?=$_SERVER['SCRIPT_NAME']?>?section=userPics.php&amp;lang=<?=$lang_idx?>"  title="<?=$USERS_PICS[$lang_idx]?>"><? echo $USERS_PICS[$lang_idx];?></a></div>		    
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
			    <select size="1" OnChange="forummonth_goto_byselect(this)" name="chooseMonth" style="width: 120px;">
                                <option selected><? echo $MONTH[$lang_idx];?></option>
                                <?
                                for ($y = $year; $y >= 2010; $y--)
                                {
                                    for ($m = 12; $m >= 1; $m--)
                                    {
                                        if ((($y == $year) && ($m <= $month)) || ($y < $year))
                                            echo sprintf ("<option value=\"%02d/%02d\">%s %d</option>",$m, $y , getMonthName(date("n",  mktime (0, 0, 0, $m, 1 ,$year))), $y);  
                                    }
                                }
                                ?>	
                            </select>
                            <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'snowpoetry.php');?>" title="חמשירים" class="hlink">חמשירי שלג ועוד</a></li>
                            <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'dictionary.php');?>" class="hlink"><?=$DICTIONARY[$lang_idx]?></a></li>
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