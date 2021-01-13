<?
//error_reporting(E_ERROR | E_PARSE);
//ini_set("error_reporting", E_ALL);
include_once("start.php");
include_once("requiredDBTasks.php");
$sig_url = $sig[0]['url'];
$sig_title = $sig[0]['sig'][$lang_idx];
$imagefile = "phpThumb.php?src=".getUpdatedPic()."&amp;w=600&amp;h=292&amp;zc=C&amp;fltr[]=gam|0.8";//&amp;fltr[]=cont|50
/////////////////////////////////////////
$floated = false;
 
 
 
////////////////////////////////////////
	$overlook_d = $OVERLOOK[$lang_idx]." "."<a href=\"javascript:void(0)\" class=\"info\">(?)<span class=\"info\">".$OVERLOOK_EXP[$lang_idx]."</span></a><br />";
?>
                <div id="forcast_title">
			<div class="forcast_title_btns for_active" onClick="change_main('#forcast_days', this, '<?=$lang_idx?>');"><? echo($FORECAST_4D[$lang_idx]); ?></div>
			<div class="forcast_title_btns" onClick="getTempForecast(<?=$timetaf?>, '<?=$dayF."/".$monthF."/".$yearF?>');change_main('#forcast_hours', this, '<?=$lang_idx?>');"><? echo(" 24 ".$HOURS[$lang_idx]);?></div>
			<div class="forcast_title_btns"><a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=forecast/getForecast.php&amp;lang=<? echo $lang_idx;?>" title="<? echo($FORECAST_ABROD[$lang_idx]); ?>" ><? echo($WORLD[$lang_idx]); ?></a></div>		
                        <div class="forcast_title_btns"><a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=forecast/getForecast.php&amp;region=isr&amp;lang=<? echo $lang_idx;?>" title="<? echo($FORECAST_ISR[$lang_idx]); ?>"><? echo($FORECAST_ISR[$lang_idx]); ?></a></div>
		    </div>
		
		<div class="contentbox-wrapper">
			  
			    
			     <div id="forcast_hours" class="contentbox">
				 <? echo($GIVEN[$lang_idx]." ".$AT[$lang_idx]." ".$timetaf.":00 ".$dayF."/".$monthF."/".$yearF);?>
				 <div id="for24_literal">
					<span id="tempForecastDiv" style="display:none">
					</span>
				</div>
				<ul id="for24_hours" style="display:none">
				 <? 
                                 $forecastHour = $mem->get("forecasthour");
				 foreach ($forecastHour as $hour_f){
				 if (($hour_f['time'] % 3 == 0) || ($hour_f['plusminus'] > 0))
				 {
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
				<div id="forcast_hours">
                                <ul id="for24_hours">
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

                                

                                 echo "<li style=\"margin-top:0;\"><div title=\"". getWindInfo($hour_f['wind'], $lang_idx)['windtitle']."\" class=\"wind_icon ".getWindInfo($hour_f['wind'], $lang_idx)['wind_class']." \"></div></li>";
                                 echo "<li>".$hour_f['title'][$lang_idx]."</li>";
                                 echo "</ul></li>";
                                 }
                                 
                                
                                 ?>
                                </ul>
                                </div>
				</div>
				 
			    
						    <div id="forcast_hours" class="contentbox">
							<div id="legends"><ul>
                               <li><span id="legend1" style="" onclick="showHourlyParam('rain', 1)" ><?=$CHANCE_OF[$lang_idx]." ".$RAIN[$lang_idx]?></span></li>
                               <li><span id="legend2" style="" onclick="showHourlyParam('humidity', 2)" ><?=$HUMIDITY[$lang_idx]?></span></li>
                               <li><span id="legend0" style="text-decoration: underline;" onclick="showHourlyParam('temp', 0)" ><?=$TEMP[$lang_idx]?></span></li>
                           		</ul></div>
                            <div id="graph_forcast" class="metric-chart h-bar-chart">
                                
								
								   <ul class="for24_graph_ng x-axis-bar-list count-10">
										<? 

											$forecastHour = $mem->get('forecasthour');
											//if ($_GET['debug'] > 0)
											//   var_dump($forecastHour);
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
                                
							</div>
								</div>
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
							<li class="forcast_each <?if ($i >= 5) echo "tashkif";?>" id="<?=$key?>" name="<?=$key?>">
							<ul>
                                                                <li class="forcast_off_day">
                                                                    <?if ($i == 0) {?>
                                                                    <a hrf="javascript:void(0)" onclick="toggle('yesterday_line');">
                                                                        <img src="images/yesterday.png" width="14" height="14" title="<?=$LAST_DAY[$lang_idx]?>" />
                                                                    </a>
                                                                    <?}?>
                                                                </li>
								<li class="forcast_day">
								<? echo replaceDays($forecastday['day_name']." ");?><? if ($i >= 5) echo "<p>".$overlook_d."</p>";?>
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
                                                                <li><a href="legend.php" rel="external" ><img src="<? echo "images/icons/day/".$forecastday['icon']; ?>" width="40" height="40" alt="<?=$forecastday['date']?>" /></a></li>
								<li class="forcast_text">
									<? if (isHeb()) $dscpIdx = "lang1"; else $dscpIdx = "lang0"; echo urldecode($forecastday[$dscpIdx]);?>
                                   				<?if ($i < 5) {?>
                                                                <div id="divlikes<?=$key?>" style="float:<?echo get_inv_s_align();?>;padding:0.2em;">		
                                                                        <img src="js/tinymce/plugins/emoticons/img/good.png" width="16px" onclick="updateLikes(this.parentNode.parentNode.parentNode.parentNode.id, 'like')" style="cursor:pointer" />
                                                                        <span class="likes" style="font-size: 1.1em"><?=count($forecastDaysDB[$key]["likes"])?></span>
                                                                        <img src="js/tinymce/plugins/emoticons/img/bad.png" width="16px" onclick="updateLikes(this.parentNode.parentNode.parentNode.parentNode.id, 'dislike')" style="cursor:pointer" />
                                                                        <span class="dislikes" style="font-size: 1.1em"><?=count($forecastDaysDB[$key]["dislikes"])?></span>
                                                                </div>
                                                                <?}?>
                                                                </li>
							</ul>
							 </li>
						<? 
								$i++;}
						   
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
                                               <img src="images/midrag.png" width="40" height="45" alt="מדרג"/>
                                            </li>
                                            <li class="forcast_text" style="text-decoration:underline">
                                                 <a href="<? echo get_query_edited_url($url_cur, 'section', 'midrag.php');?>">בעלי מקצוע לפי עונה</a>
                                            </li>
                                            <?}?> 
					     
					</ul>
				    </li>
				    				    
			    
				</ul>
					
			    </div> <!-- forcast_days -->
			</div><!-- contentbox-wrapper -->
                        
           