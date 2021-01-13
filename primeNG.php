<article id="forecast">
	<?
        // fetch once again because it is cut otherwise
    
        $forecastDaysDB = $mem->get('forecastDaysDB'); 
          $sig_url = $sig[0]['url'];
        $sig_title = $sig[0]['sig'][$lang_idx];
        $imagefile = "phpThumb.php?src=".getUpdatedPic()."&amp;w=200&amp;h=200&amp;zc=C&amp;fltr%5B%5D=gam%7C0.8";//&amp;fltr[]=cont|50
        $current_story_img_src = "phpThumb.php?src=".$current_story_img_src."&amp;w=200&amp;h=200&amp;zc=C";//&amp;fltr[]=cont|50 ;
        /////////////////////////////////////////
        $floated = false;
        
        $MIDRAG_T = array("ירושלמים לירושלמים – לא בוחרים בעל מקצוע בלי לבדוק חוות דעת קודמות.", 
                          "400,000 חוות דעת. בוחרים בעל מקצוע רק אחרי שקראנו חוות דעת קודמות.  ", 
                          "פעם אמרו שבירושלים לא צריך מזגן. אז אמרו..  ירושלמים ממליצים על מתקיני מזגנים", 
                          "גם לחום וגם לקור...  טכנאי מזגנים שירושלמים אחר המליצו עליהם פה",
                          "עוברים דירה? ירושלמים ממליצים על מובילים אמינים",
                        "קיבלתם ספה מהדודה של השכן? מובילים מומלצים גם להובלות קטנות פה", 
                        "כל הבית נמלים? ירושלמים אחרים כבר בדקו מדבירים ונתנו חוות דעת במידרג", 
                        "הג'וקים עשו את כל העליות לירושלים ונחתו אצלך בחצר? מדבירים מומלצים פה", 
                        "גם אתם יודעים מה זה אבו-יויו? לתיקונים ושיפוצים קחו המלצות מירושלמים שמדברים את השפה שלכם");
        $MIDRAG_I = array("images/midragdefault.png", 
                            "images/midragdefault.png", 
                            "images/midragairCondition.png", 
                            "images/midragairCondition.png", 
                            "images/midragmoving.png", 
                            "images/midragmoving.png", 
                            "images/midragexterminator.png", 
                            "images/midragexterminator.png", 
                            "images/midragrenovation.png");
        $MIDRAG_L = array($_SERVER['SCRIPT_NAME']."?section=midrag.php", 
                            $_SERVER['SCRIPT_NAME']."?section=midrag.php", 
                            $_SERVER['SCRIPT_NAME']."?section=midrag.php&l=E6127R0GV18085LY64028", 
                            $_SERVER['SCRIPT_NAME']."?section=midrag.php&l=761NTJ0B5493O9UO0RMR7",
                            $_SERVER['SCRIPT_NAME']."?section=midrag.php&l=BT9IUX8K91S012K27W1J77448J85YI9G102",
                            $_SERVER['SCRIPT_NAME']."?section=midrag.php&l=V798L487715GC3QX1GB7135750C7X94L7J7", 
                            $_SERVER['SCRIPT_NAME']."?section=midrag.php&l=6971312JF0K8S79J5", 
                            $_SERVER['SCRIPT_NAME']."?section=midrag.php&l=J276473B00Z0A0N28", 
                            $_SERVER['SCRIPT_NAME']."?section=midrag.php&l=9N15LH0X372TP75W550614Z7NC24152U438NI3");
        $random_midrag = rand(0,count($MIDRAG_T)-1);
        $random_did_you_know = rand(0, count($DID_YOU_KNOW_EX)-1);
        $DID_YOU_KNOW_LINK = array(get_query_edited_url($url_cur, 'section', 'allTimeRecords.php'), get_query_edited_url($url_cur, 'section', 'myVotes.php'), get_query_edited_url($url_cur, 'section', 'snow.php'));
        $DID_YOU_KNOW_TITLE = array($RECORDS[$lang_idx], $MY_VOTES[$lang_idx], $SNOW_JER[$lang_idx]);
        ////////////////////////////////////////
                $overlook_d = "<a href=\"javascript:void(0)\" class=\"info\">".$OVERLOOK[$lang_idx]."<span class=\"info\">".$OVERLOOK_EXP[$lang_idx]."</span></a>";
        ?>
		<div class="row">
		    <div id="forcast_title">
			<div class="forcast_title_btns for_active" onClick="change_main('#forcast_days', this, '<?=$lang_idx?>');"><? echo($FORECAST_4D[$lang_idx]); ?></div>
			<div class="forcast_title_btns" onClick="change_main('#forcast_hours', this, '<?=$lang_idx?>');"><? echo($HOURLY[$lang_idx]);?></div>
            <div class="forcast_title_btns"><a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=forecast/getForecast.php&amp;lang=<? echo $lang_idx;?>" title="<? echo($FORECAST_ABROD[$lang_idx]); ?>" ><? echo($WORLD[$lang_idx]); ?></a></div>		
            <div class="forcast_title_btns"><a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=forecast/getForecast.php&amp;region=isr&amp;lang=<? echo $lang_idx;?>" title="<? echo($FORECAST_ISR[$lang_idx]); ?>"><? echo($FORECAST_ISR[$lang_idx]); ?></a></div>
            <div class="forcast_title_btns"><a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=survey.php&amp;lang=<? echo $lang_idx;?>&amp;survey_id=1" title="<?=$FSEASON[$lang_idx]?>"><?=$FSEASON_T[$lang_idx]?></a></div>
            <div class="forcast_title_btns"><a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=ForecasterJob.php&amp;lang=<? echo $lang_idx;?>" title="<?=$WHAT_IS_FORECAST?>"><?=$FORECASTER_JOB[$lang_idx]?></a></div>
        </div>
		    
		    <div id="forcast_main">
			
			<div class="contentbox-wrapper">
			    <div id="forcast_days" class="contentbox">
				<ul id="forcast_icons">
				    <li id="morning_icon" class="forcast_morning" title="<? echo $EARLY_MORNING[$lang_idx];?>"></li>
				    <li id="noon_icon" class="forcast_noon" title="<? echo $NOON[$lang_idx];?>"></li>
				    <li id="night_icon" class="forcast_night" title="<?=$NIGHT_TEMP_EXP[$lang_idx]?>"></li>
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
								<li class="forcast_morning number">
								<?=c_or_f($lowtemp_value)?>
								</li>
								<li class="forcast_noon number">
								<?=c_or_f($hightemp_value)?>
								</li>
								<li class="forcast_night number">
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
                                                           $arTempLowCloth =  explode('_', $forecastday['TempLowCloth']);
                                                           $prefTempLowCloth = $arTempLowCloth[0];
                                                           $arTempNightCloth =  explode('_', $forecastday['TempNightCloth']);
                                                           $prefTempNightCloth = $arTempNightCloth[0];
                                                           
					 ?>     
                            <? if (($forecastday['day_name'] == "Mon")&&(isHeb())) {?>
                            <!--<li class="forcast_each invfloat" style="padding-left:2em">
                                <a href="http://shaon-horef.co.il" target=_blank >ששאון חורף > פעם אחרונה לטירוף של החורף!</a>
                            </li>-->
                            <? }?>
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
                                <li>
                                <div id="<?=$i?>" class="open-close-button" index="<?=$i?>"></div>
                                </li>
								<li class="forcast_morning">
                                
                                <div class="number"><?=c_or_f($forecastday['TempLow'])?></div><div class="cloth extra<?=$i?>"><a href="WhatToWear.php#<?=$prefTempLowCloth?>" rel="external" ><img style="vertical-align: middle" src="<? echo "images/clothes/".$forecastday['TempLowCloth']; ?>" width="28" height="25" title="<?=getClothTitle($forecastday['TempLowCloth'], $forecastday['TempLow'])?>" alt="<?=getClothTitle($forecastday['TempLowCloth'], $forecastday['TempLow'])?>" /></a></div>
                                <div class="icon extra<?=$i?>" ><div class="humidity"><?=$forecastday['humMorning']?>%</div></div>
                                <div class="icon cloth extra<?=$i?>"><img style="vertical-align: middle" src="images/clothes/<?=$forecastday['TempLowCloth']?>" width="20" height="20" title="<?=getClothTitle($forecastday['TempLowCloth'], $forecastday['TempLow'])?>" alt=""></div>
                                <div class="icon extra<?=$i?>" id="morning_icon<?=$i?>"><img src="images/icons/day/<?=c_or_f($forecastday['iconmorning'])?>" width="30" height="30" alt="images/icons/day/<?=c_or_f($forecastday['iconmorning'])?>"></div>
								<div class="icon extra<?=$i?>" ><div class="wind_icon <?echo getWindInfo($forecastday['windMorning'], $lang_idx)['wind_class'];?>" title="<?echo getWindInfo($forecastday['windMorning'], $lang_idx)['windtitle']." - ".getWindInfo($forecastday['windMorning'], $lang_idx)['winddesc'];?>"></div></div>
                                </li>
								<li class="forcast_noon">
								<div class="number"><?=c_or_f($forecastday['TempHigh'])?></div><div class="cloth extra<?=$i?>"><a href="WhatToWear.php#<?=$prefTempHighCloth?>" rel="external" ><img style="vertical-align: middle" src="<? echo "images/clothes/".$forecastday['TempHighCloth']; ?>" width="28" height="25" title="<?=getClothTitle($forecastday['TempHighCloth'], $forecastday['TempHigh'])?>" alt="<?=getClothTitle($forecastday['TempHighCloth'], $forecastday['TempHigh'])?>" /></a></div>
								<div class="icon extra<?=$i?>" ><div class="humidity"><?=$forecastday['humDay']?>%</div></div>
                                <div class="icon cloth extra<?=$i?>"><img style="vertical-align: middle" src="images/clothes/<?=$forecastday['TempHighCloth']?>" width="20" height="20" title="<?=getClothTitle($forecastday['TempHighCloth'], $forecastday['TempHigh'])?>" alt=""></div>
                                <div class="icon extra<?=$i?>" id="day_icon<?=$i?>"><img src="images/icons/day/<?=c_or_f($forecastday['icon'])?>" width="30" height="30" alt="images/icons/day/<?=c_or_f($forecastday['icon'])?>"></div>
                                <div class="icon extra<?=$i?>" ><div class="wind_icon <?echo getWindInfo($forecastday['windDay'], $lang_idx)['wind_class'];?>" title="<?echo getWindInfo($forecastday['windDay'], $lang_idx)['windtitle']." - ".getWindInfo($forecastday['windDay'], $lang_idx)['winddesc'];?>"></div></div>
                                </li>
								<li class="forcast_night">
								<div class="number"><?=c_or_f($forecastday['TempNight'])?></div><div class="cloth extra<?=$i?>"><a href="WhatToWear.php#<?=$prefTempNightCloth?>" rel="external" ><img style="vertical-align: middle"  src="<? echo "images/clothes/".$forecastday['TempNightCloth']; ?>" width="28" height="25" title="<?=getClothTitle($forecastday['TempNightCloth'], $forecastday['TempNight'])?>" alt="<?=getClothTitle($forecastday['TempNightCloth'], $forecastday['TempNight'])?>" /></a></div>
                                <div class="icon extra<?=$i?>" ><div class="humidity"><?=$forecastday['humNight']?>%</div></div>
                                <div class="icon cloth extra<?=$i?>"><img style="vertical-align: middle" src="images/clothes/<?=$forecastday['TempNightCloth']?>" width="20" height="20" title="<?=getClothTitle($forecastday['TempNightCloth'], $forecastday['TempNight'])?>" alt=""></div>
                                <div class="icon extra<?=$i?>" id="night_icon<?=$i?>"><img src="images/icons/day/<?=c_or_f($forecastday['iconnight'])?>" width="30" height="30" alt="images/icons/day/<?=c_or_f($forecastday['iconnight'])?>"></div>
                                <div class="icon extra<?=$i?>" ><div class="wind_icon <?echo getWindInfo($forecastday['windNight'], $lang_idx)['wind_class'];?>" title="<?echo getWindInfo($forecastday['windNight'], $lang_idx)['windtitle']." - ".getWindInfo($forecastday['windNight'], $lang_idx)['winddesc'];?>"></div></div>
								</li>
                                <li class="icon_day"><?if ($i == 0) echo get_param_tag($forecastday['TempHigh'] - round($hightemp_value), true, "", false);?>
                                    <a href="legend.php" rel="external" >
                                    <? if (getWindInfo($forecastday['windDay'], $lang_idx)['wind_class'] == "high_wind") { ?>
                                    <div class="wind_icon <?echo getWindInfo($forecastday['windDay'], $lang_idx)['wind_class'];?>"></div>
                                    <?}?>
                                    <img src="<? echo "images/icons/day/".$forecastday['icon']; ?>" width="40" height="40" alt="<?=$forecastday['date']?>" />
                                    
                                    </a>
                                </li>
								<li class="forcast_text">
									<? if (isHeb()) $dscpIdx = "lang1"; else $dscpIdx = "lang0"; echo urldecode($forecastday[$dscpIdx]);$textsum = $textsum + strlen(urldecode($forecastday[$dscpIdx]));?>
                                    <?if ($i < 5) {?>
                                                    <div id="divlikes<?=$key?>" class="likedislike">		
                                                            <img src="images/like_white.png" width="15px" height="15px" onclick="updateLikes(this.parentNode.parentNode.parentNode.parentNode.id, 'like')" style="cursor:pointer" />
                                                            <span class="likes"><?=count($forecastDaysDB[$key]["likes"])?></span>&nbsp;
                                                            <img src="images/dislike_white.png" width="15px" height="15px" onclick="updateLikes(this.parentNode.parentNode.parentNode.parentNode.id, 'dislike')" style="cursor:pointer" />
                                                            <span class="dislikes"><?=count($forecastDaysDB[$key]["dislikes"])?></span>
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
					    <li class="forcast_morning number">
							<? echo $monthAverge->get_lowtemp(); ?><br /><br />
                                                        <? echo $monthAverge->get_abslowtemp(); ?>
					    </li>
					    <li class="forcast_noon number">
							<? echo $monthAverge->get_hightemp(); ?><br /><br />
                                                        <? echo $monthAverge->get_abshightemp(); ?>
					    </li>
                                            <li class="forcast_night">
                                                
                                            </li>
                                            
                                           <li>
                                               <img src="<?=$MIDRAG_I[$random_midrag]?>" width="45" height="55" alt="מדרג"/>
                                            </li>
                                            <li class="forcast_text below_forecast" style="line-height: 15px;direction:rtl;width:180px">
                                                 <a href="https://www.google.com/maps?q=%D7%91%D7%99%D7%9C%D7%95+16+%D7%99%D7%A8%D7%95%D7%A9%D7%9C%D7%99%D7%9D&entry=gmail&source=g" target="_blank" >
                                                     <? if (isHeb()) {?> 
                                                         <a href="<?=$MIDRAG_L[$random_midrag]?>"><?=$MIDRAG_T[$random_midrag]?></a>
                       
                                                     <?} else {?>
                                                       
                                                     <?}?>
												 </a>
                                            </li>
                                            
					     
					</ul>
				    </li>
				    				    
			    
				</ul>
					
			    </div> <!-- forcast_days -->
			    
			     <div id="forcast_hours" class="contentbox">
                        <div id="table24" class="forcast_title_btns" onClick="change_main('#forcast_hours_table', this, '<?=$lang_idx?>');"><? echo(" 24 ".$HOURS[$lang_idx]." ".$IN_TABLE[$lang_idx]);?></div>           
                                
                       <div id="legends">
                           <ul>
                               <li><span id="legend1" style="" onclick="showHourlyParam('rain', 1)" ><?=$CHANCE_OF[$lang_idx]." ".$RAIN[$lang_idx]?></span></li>
                               <li><span id="legend2" style="" onclick="showHourlyParam('humidity', 2)" ><?=$HUMIDITY[$lang_idx]?></span></li>
                               <li><span id="legend0" style="text-decoration: underline;" onclick="showHourlyParam('temp', 0)" ><?=$TEMP[$lang_idx]?></span></li>
                           </ul>
                       </div>            
                      <div id="graph_forcast" class="metric-chart h-bar-chart">
                      <ul class="for24_graph_ng x-axis-bar-list count-10">

                   
                      <? 

                                 $forecastHour = $mem->get('forecasthour');
                                 $nowIndex = $mem->get("nowHourIndex");
                                 $max_temp = -10; $min_temp = 110;
                                 $max_hum = -10; $min_hum = 110;
                                 foreach ($forecastHour as $key => &$hour_f) {
                                     if (($hour_f['currentDateTime'] - time() > 0)){
                                         if ($hour_f['temp'] > $max_temp) $max_temp = $hour_f['temp']; 
                                         if ($hour_f['temp'] < $min_temp) $min_temp = $hour_f['temp'];
                                         if ($hour_f['humidity'] > $max_hum) $max_hum = $hour_f['humidity']; 
                                         if ($hour_f['humidity'] < $min_hum) $min_hum = $hour_f['humidity'];
                                         
                                     }
                                 }
                                 $index_hr = 0;
                                 $top = 100;
                                 foreach ($forecastHour as $hour_f){
                                    $index_hr++;
                                    
                                     if ($index_hr >= $nowIndex) {
                                        echo "<li class=\"x-axis-bar-item\">";
                                        $toptime =  ($index_hr % 4 == 0) ? replaceDays(date("D ", $hour_f['currentDateTime']))."</br>".$hour_f['time'].":00" : $hour_f['time'].":00";
                                        echo "<div class=\"x-axis-bar-item-container\" onclick=\"showcircleperhour('".$toptime."','".$hour_f['icon']."',".$hour_f['temp'].",".$hour_f['wind'].",'".$hour_f['cloth']."',".$hour_f['rain'].",".$hour_f['humidity'].")\">";
                                        echo "<div class=\"x-axis-bar primary\" style=\"height: 100%\">".$toptime."</div>";
                                        $bottom = 92;
                                        echo "<div class=\"x-axis-bar tertiary icon\" style=\"height: ".$bottom."%;\"><img style=\"vertical-align: middle\" src=\"images/icons/day/".$hour_f['icon']."\" height=\"25\" width=\"28\" alt=\"".$hour_f['icon']."\" /></div>";
                                        $bottom = (($hour_f['temp']-$min_temp)*90)/($max_temp - $min_temp);
                                         if ($bottom < 10) $bottom = 12;
                                         else if ($bottom < 20) $bottom = $bottom + 3;

                                        $tempclass = ($index_hr % 2 == 0) ? "secondary" : "secondaryalt";
                                        echo "<div class=\"x-axis-bar ".$tempclass." temp\" style=\"height: ".$bottom."%;\"><span class=\"x-axis-bar-value\" data-value=\"".$hour_f['temp']."° ".$hour_f['humidity']."%\">".$hour_f['temp']."°</span></div>";
                                         $bottom = 40;
                                        if ($hour_f['plusminus'] > 0)
                                            echo "<div class=\"x-axis-bar tertiary\" style=\"height: ".$bottom."%;\"><span class=\"x-axis-bar-value\" data-value="."&nbsp;&plusmn;".$hour_f['plusminus']."></span></div>";
                                        $bottom = 82;
                                        if ($index_hr == $nowIndex || ($hour_f['wind'] != $prev_wind))
                                        echo "<div class=\"x-axis-bar tertiary wind\" style=\"height: ".$bottom."%;\"><div title=\"".getWindInfo($hour_f['wind'], $lang_idx)['windtitle']."\" class=\"wind_icon ".getWindInfo($hour_f['wind'], $lang_idx)['wind_class']." \"></div></div>";
                                        $bottom = $hour_f['rain'];
                                        if ($bottom > 0)
                                            echo "<div class=\"x-axis-bar tertiary rain\" style=\"height: ".$bottom."%;\"><span class=\"x-axis-bar-value\" data-value=\"".$CHANCE_OF[$lang_idx]." ".$RAIN[$lang_idx]."\">".$hour_f['rain']."%</span></div>";
                                        $bottom = $hour_f['humidity'];
                                        echo "<div class=\"x-axis-bar tertiary humidity\" style=\"display:none;height: ".$bottom."%;\"><span class=\"x-axis-bar-value\" data-value=\"".$HUMIDITY[$lang_idx]."\">".$hour_f['humidity']."%</span></div>";
                                        //echo "<span class=\"x-axis-bar-target-line\" style=\"bottom: ".$bottom."%;\"></span>";
                                        echo "</div>";
                                        echo "</li>";
                                        $prev_wind = $hour_f['wind'];

                                     }
				 }?>                                 
                 </ul>               
                                
				<div id="for24_literal">
					<span id="tempForecastDiv" style="display:none">
					</span>
				</div>
                 
                <div id="chartjs-tooltip" class="inv_plain_3_zebra"></div>                                         
				<ul class="for24_hours" style="display:none">
				 <? 
                                 $sigforecastHour = $mem->get('sigforecastHour');
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
                <div id="table24text" class="float forcast_title_btns" onClick="change_main('#forcast_hours', this, '<?=$lang_idx?>');"><? echo(" 24 ".$HOURS[$lang_idx]." - ".$GRAPH[$lang_idx]);?></div>
                <div id="rainprobexp" class="invfloat"><a href="javascript:void(0)" class="info"><?=$RAIN_PROB_EXP_TITLE[$lang_idx]?><span class="info"><?=$RAIN_PROB_EXP[$lang_idx]?></span></a></div>
                <ul class="for24_hours">
                <? 
                                 $forecastHour = $mem->get('forecasthour');
                                 $nowIndex = $mem->get("nowHourIndex");
                                 $index_hr = 0;
                                 foreach ($forecastHour as $hour_f){
                                    $index_hr++;
                                     if ($index_hr == 6) {
                                        //echo "<li class=\"nav forecasttimebox forcast_each\" ><ul><li class=\"forcast_each invfloat\" style=\"padding-left:2em\"><a href=\"http://shaon-horef.co.il\" target=_blank >שאון חורף > פעם אחרונה לטירוף של החורף!/a></li></ul></li>  ";
                                        }
                                     if ($index_hr >= $nowIndex)
                                     if (shouldDisplayForecastHour($index_hr)){
                                        echo "<li class=\"nav forecasttimebox forcast_each\" index=\"".$index_hr."\" ><ul>";
                                        echo "<li class=\"plus\"><div class=\"open-close-button\" index=\"".$index_hr."\"></div></li>";
                                        echo "<li class=\"tsfh\" style=\"text-align:center;width:0%;display:none\">".$hour_f['currentDateTime']."</li>";
                                        echo "<li class=\"tsfh\" style=\"text-align:center;width:10%\">".date("j/m", $hour_f['currentDateTime'])."</li>";
                                        echo "<li class=\"timefh\" style=\"direction:ltr;text-align:right;width:12%\"><span>".$hour_f['time'].":00";
                                           if ($hour_f['plusminus'] > 0)
                                               echo "&nbsp;&plusmn;".$hour_f['plusminus']."";
                                        echo "</span></li>";
                                        echo "<li class=\"forecasttemp forcast_morning\" style=\"text-align:center;direction:ltr;\" id=\"tempfh".intval($hour_f['time']).intval(date("j", $hour_f['currentDateTime']))."\"><div class=\"number\">".$hour_f['temp']."°</div><div class=\"feelslike number extra".$index_hr."\"></div></li>";
                                        echo "<li style=\"margin-top:6px;width:7%\"><img style=\"vertical-align: middle\" src=\"images/icons/day/".$hour_f['icon']."\" height=\"25\" width=\"28\" alt=\"".$hour_f['icon']."\" /><div class=\"dust number extra".$index_hr."\">".$hour_f['dust']."</div></li>";
                                        echo "<li><div>&nbsp;<img style=\"vertical-align: middle\"  src=\"images/clothes/".$hour_f['cloth']."\" width=\"24.3\" height=\"20\" /></div><div class=\"UV extra".$index_hr."\">".$hour_f['uv']."</div></li>";
                                        echo "<li class=\"wind\"><div title=\"".getWindInfo($hour_f['wind'], $lang_idx)['windtitle']."\" class=\"wind_icon ".getWindInfo($hour_f['wind'], $lang_idx)['wind_class']." \"></div><div class=\"humidity extra".$index_hr."\">".$HUMIDITY[$lang_idx]."  ".$hour_f['humidity']."%</div></li>";
                                        echo "<li><div>".$hour_f['title'][$lang_idx]."</div><div class=\"extra".$index_hr."\"></div></li>";
                                        echo "</ul></li>";

                                     }
				 }
				 ?>
				</ul>
               
                              
			    </div>
			    
			</div><!-- contentbox-wrapper -->
			
            </div> <!-- forcast_main -->
                     
		    <div id="mainadsense" style="line-height: 0;">
            <div id="bg3-1" class="cloud2" >
            <a href="https://runnerswithoutborders.org/race/" style="line-height: 10px;
    position: absolute;
    margin-left: 20px;
    margin-top: -5px;
    z-index: 9999;">המרוץ שמנפץ את חומות השנאה</a>
            <div class="cloud2-more">
            
            </div></div>
            <hr id="leftline_cloud" /><hr id="rightline_cloud" />
            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- Main Desktop -->
            
            <ins class="adsbygoogle"
                style="display:block"
                data-ad-client="ca-pub-2706630587106567"
                data-ad-slot="1816548745"
                data-ad-format="rectangle"></ins>
            <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
            
            <div id="if1">
            
    
            </div>
            <div id="if4">
            
            </div>
            <?if (isHeb()){?>
            <div style="width:270px;padding:10px 15px;line-height: 15px;text-align:right">
            <a href="https://runnerswithoutborders.org/race/" style="">המרוץ שמנפץ את חומות השנאה:
קבלו פרטים על המרוץ היהודי-ערבי הגדול שיתקיים ב-2021 בירושלים</a>
	        </div>
            <?}?>                
                               
			</div>
                   
                         
            </div>
              <!-- row -->
		
            </article>
            
	    
	    
<article id="whatmore" style="<? if (($textsum >= 580)||(count($forecastDaysDB) > 6)) echo "top:820px";?>">
	    
		
		    <div class="row">
            <div class="now_messages">       
		    <div id="alerts" class="span7 offset3 white_box">
			<h2><? echo $MESSAGES[$lang_idx];?></h2>
                        <p></p>
                        <div id="message" class="box_text"><? echo $latestalert."<br/>".$detailedforecast;?></div>
                        <p id="personal_message" class="box_text"></p>
  		    </div>
            </div>
           <div class="span3">
           

		    </div>
		    </div>
			
		    <div class="row" style="margin-bottom: 0.2em">
		    <!--
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
		    </div>-->
                        
                    <div id="adexternal" class="span2">
                       <!--<a data-p1xtr="widget-button" data-p1xtr-image="https://www.02ws.co.il/img/logo_rain.svg"></a>-->
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
                               
                               <div id="more_icons_container">
                                    <a id="weather_movies" class="more_icons" href="<? echo get_query_edited_url($url_cur, 'section', 'weatherclips.php');?>" title="<? echo $WEATHER_CLIPS[$lang_idx];?>" class="hlink"><? echo $WEATHER_CLIPS[$lang_idx];?></a>
                                    <a id="weather_songs" class="more_icons" href="<? echo get_query_edited_url($url_cur, 'section', 'songs.php');?>"><?=$SONGS[$lang_idx]?></a>
                                    <a id="snow_poems" class="more_icons" href="<? echo get_query_edited_url($url_cur, 'section', 'snow.php');?>" class="hlink"><? echo $SNOW_JER[$lang_idx];?></a>
                                    <?if (isHeb()){?>
                                    <a id="myths" class="more_icons" href="<? echo get_query_edited_url($url_cur, 'section', 'myths.php');?>" class="hlink"><? echo $MYTHS[$lang_idx];?></a>
                                    <?}?>
                                    <a id="weather_hul" class="more_icons" href="<?=$_SERVER['SCRIPT_NAME'];?>?section=forecast/getForecast.php&amp;lang=<? echo $lang_idx;?>" title="<? echo($FORECAST_ABROD[$lang_idx]); ?>" ><? echo($WORLD[$lang_idx]); ?></a>
                                    <a id="weather_israel" class="more_icons" href="<?=$_SERVER['SCRIPT_NAME'];?>?section=forecast/getForecast.php&amp;region=isr&amp;lang=<? echo $lang_idx;?>" title="<? echo($FORECAST_ISR[$lang_idx]); ?>"><? echo($FORECAST_ISR[$lang_idx]); ?></a>
                                    <a id="likeddislikedforecasts" class="more_icons" href="<? echo get_query_edited_url($url_cur, 'section', 'forecastDays.php');?>"><? echo $LIKED_FORECAST[$lang_idx];?></a>

                               </div>
                            </div>
                            <?if (isHeb()) {?>
                            
                            <ul id="outside_links">
                               <li><a href="http://shabat.open.org.il/?fbclid=IwAR34It8gX-qQFVGGLmnHYlCiBhduy0y-XsHcw30rUjs3kCpFvO7NVMoBUX4" title='open02' target="_blank">פתוח בשבת</a></li>
                               <li><a href="http://www.weather2day.co.il" title='Weather2day' target="_blank">מזג האוויר - Weather2day</a></li>
                               <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'tracks.php');?>">טיולים בירושלים</a></li>
                            </ul>
                           <?}?>
                    </div>
                    <div class="row"> 
                        

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
			    <div id="album"><a href="ubergallery/index.php"  title="<?=$ALBUM_DESC[$lang_idx]?>" target="_blank"><? echo $PICTURES[$lang_idx];?></a></div>
                            <div id="userpic"><a href="<?=$_SERVER['SCRIPT_NAME']?>?section=userPics.php&amp;lang=<?=$lang_idx?>"  title="<?=$USERS_PICS[$lang_idx]?>"><? echo $USERS_PICS[$lang_idx];?></a></div>		    
			    <div id="pic_empty"></div>
			    
			    <div id="map_thumbs">
				<img id="pic_thumb1" onclick="change_pic_to('0px')" src="<?=$picname?>" alt="<? echo $PIC_OF_THE_DAY[$lang_idx];?>" />
				<img id="pic_thumb2" onclick="change_pic_to('0px')" src="<?=$imagefile?>" alt="<? echo $LIVE_PICTURE[$lang_idx];?>" />
	    
			    </div>
			    		    
			    <div class="span5 offset9 white_box2" id="pic_frame">
				
				<div id="pic_contentbox" class="contentbox-wrapper">
				    <div id="live_pic" class="contentbox pic_user">
					<div class="avatar live_avatar"></div>
					<h3><? echo $LIVE_PICTURE[$lang_idx];?></h3>
                                        <h4></h4>
					<a href="<? echo "station.php?section=webCamera.jpg&amp;lang=".$lang_idx;?>"><p><? echo $PIC_DESC[$lang_idx];?><?=get_arrow()?></p>
					<img title="שידור חי  - מצלמה 2" src="phpThumb.php?src=<?=getUpdatedPic()?>&amp;sx=550&amp;w=1550&amp;sy=250&amp;sw=850&amp;sh=550&amp;fltr%5B%5D=gam%7C0.8" alt="live pic" />
					</a>
					
				    </div>
			
				</div>
				 <div id="picoftheday" class="contentbox pic_user">
					<div class="avatar picoftheday_avatar"></div>
					<h3><? echo $PIC_OF_THE_DAY[$lang_idx];?></h3>
					<h4></h4>
                    <a href="<? echo "station.php?section=picoftheday.php&amp;lang=".$lang_idx;?>">
					<p><?=$comment[$lang_idx]?>&nbsp;- <?echo $MORE_INFO[$lang_idx];?><?=get_arrow()?></p>
					</a>
                     <a href="<? echo "station.php?section=picoftheday.php&amp;lang=".$lang_idx;?>">                   
					<img src="phpThumb.php?src=<?=$picname?>&amp;w=350&amp;fltr%5B%5D=gam%7C0.8" alt="<?=$comment[$lang_idx]?>" />
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
			<div class="offset3 white_box" id="new_post">
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
    			<div id="new_post_okay" onclick="closeNewPost();getMessageService(<?=$limitLines?>, '', 0, 1, <?=$lang_idx?>, $('#current_forum_filter').attr('data-key'));"><?=$SEND[$lang_idx]?></div>
			    <div id="new_post_cancel" onclick="closeNewPost();restoreTopDiv();"><?=$CANCEL[$lang_idx]?></div>
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

                        <div class="span11 offset3" id="msgDetails">

                        </div>
                        <div class="span8 offset3 ">
                            <div class='invfloat big'>
                                <a href='javascript:void(0)' onclick="getNextPage(<?=$lang_idx?>, <?=$limitLines?>)">עוד הודעות</a>
                           </div>
                        </div>
						<div class="span12 offset3 ">&nbsp;
						</div>
                        
                        
                        
	    </div> <!-- posts -->
	    <footer class="footer">Designed by <a href="http://www.behance.net/galizorea" target="_blank">Gali Zorea</a></footer>
		
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
    <script type="text/javascript">
    function showHourlyParam(param, idx){
        $('#legends span').css('text-decoration', 'none');
        $('#legend' + idx).css('text-decoration', 'underline');
        $('.x-axis-bar-item .temp, .x-axis-bar-item .humidity, .x-axis-bar-item .rain ').hide(0);
        $('.x-axis-bar-item .' + param).show(0);
    }

    function showcircleperhour(toptime, icon, temp, wind, cloth, rain, humidity){
      
      $('#chartjs-tooltip').css({
          opacity: 1,
          width:'250px',
          fontSize: '1.5em',
          margin:'0 auto',
          marginTop:-102,
          padding: '4px 11px 14px',
        });
        $('#chartjs-tooltip').html( toptime + "<br/><img style=\"vertical-align: middle\" src=\"images/icons/day/" + icon + "\" height=\"25\" width=\"28\" alt=\""  + icon + "\">"  + "<br/>" + temp + "°<br/>" + wind + " קמש<br/><img src=\"images/clothes/" + cloth + "\" width=\"30.25\" height=\"25\" style=\"vertical-align: middle\"><br/>div class=\"rainpercent\">" + rain + "%</div><br/>" + humidity + "%" );
      change_circle('now_line', 'chartjs-tooltip');
        
    }
</script>