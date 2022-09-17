<?
ini_set("display_errors","On");
$altClass = 'half_zebra';
function getAlternateClass()
{
	global $altClass;
	if ($altClass == '')
    	$altClass = '';
	else
		$altClass = '';
	return $altClass;
}
  
?>

<!-- 
*****
*****
mainCol
*****
*****
-->
<div id="mainCol">
	<div id="forecast">
			<?
			//error_reporting(E_ERROR | E_PARSE);
			//ini_set("error_reporting", E_ALL);
                        // fetch once again because it is cut otherwise
                        $forecastDaysDB = $mem->get('forecastDaysDB');
                        $forecastlib_origin = "hometable.php";
			include_once("forecastlib.php");
			$sig_url = $sig[0]['url'];
			$sig_title = $sig[0]['sig'][$lang_idx];
			$imagefile = "phpThumb.php?src=".getUpdatedPic()."&amp;w=550&amp;h=220&amp;zc=C&amp;fltr[]=gam|0.8";//&amp;fltr[]=cont|50
			$current_story_img_src = "phpThumb.php?src=".$current_story_img_src."&amp;w=550&amp;h=220&amp;zc=C";//&amp;fltr[]=cont|50 ;
			/////////////////////////////////////////
			$floated = false;
			 
			////////////////////////////////////////
				$overlook_d = $OVERLOOK[$lang_idx]." "."<a href=\"javascript:void(0)\" class=\"info\">(?)<span class=\"info\">".$OVERLOOK_EXP[$lang_idx]."</span></a><br />";
			?>
					
					<div class="float" id="nextdays">
						
							<div id="for_title" class="float">
								<div id="forecastnextdays_title" class="float slogan title_selected">
								<a href="javascript:void(0)" id="forecastnextdays_link" onclick="toggle('forecastnextdays');toggle('forecast24h');$('#forecastnextdays_title').removeClass('title_not_selected').addClass('title_selected');$('#forecast24h_title').removeClass('title_selected').addClass('title_not_selected');">
									<? echo($FORECAST_4D[$lang_idx]); ?>
								</a>
								<!-- <span class="small">
								<a href="whatisforecast.php?lang=<?=$lang_idx?>" title="<?=$WHAT_IS_FORECAST[$lang_idx]?>" rel="external">
									*
								</a>
								</span> -->
								</div>
								<div id="forecast24h_title" class="float slogan title_not_selected">
									<a href="javascript:void(0)" onclick="toggle('forecast24h');toggle('forecastnextdays');getTempForecast(<?=$timetaf?>, '<?=$dayF."/".$monthF."/".$yearF?>');$('#forecast24h_title').removeClass('title_not_selected').addClass('title_selected');$('#forecastnextdays_title').removeClass('title_selected').addClass('title_not_selected');">
										<? echo($FORECAST_TITLE[$lang_idx]." ".$FOR[$lang_idx]." 24 ".$HOURS[$lang_idx]);?>
									</a>
								</div>
							</div>
							
			 
						
						<div id="forecastnextdays" >
							<table id="tableForecastNextDays" style="border-spacing:2;border-padding:4">
							<tr style="height:5px" >
							<th style="padding:0;width:90px"></th>
							<th style="padding:0;width:70px;text-align:<?=get_inv_s_align()?>" class="small"><? echo $EARLY_MORNING[$lang_idx];?></th>
							<th style="padding:0;width:70px;text-align:center" class="small"><? echo $NOON[$lang_idx];?></th>
							<? if  (count($forecastDaysDB) > 0) { ?>
											<th style="padding:0;width:80px;text-align:center" class="small"><? echo $EVENING[$lang_idx];?> <a href="javascript:viod(0)" class="info">(?)<span class="info"><?=$NIGHT_TEMP_EXP[$lang_idx]?></span></a></th>
							<? } ?>
							<th style="width:50px" class="small"><? echo "<span dir=\"ltr\">".$current->get_tempunit()."</span>";?></th>
							<th></th>
							</tr>
							<? if  (count($forecastDaysDB) == 0) 
								{
									echo $frcstTable;
									echo "<tr style=\"height:5px\"><td colspan=\"4\">".$SOURCE[$lang_idx].": ".$IMS[$lang_idx]."</td></tr>";	
			 
								}
								else 
								{
									//print_r($forecastDaysDB);
			 
									 foreach ($forecastDaysDB as $key => &$forecastday) 
                                                                        {
									if ($i % 2 == 1)
										$class =  " class=\"\" ";
									else
										$class =  " class=\"\" ";
									
									?>
									<tr <?=$class?> style="height:<?=180/count($forecastDaysDB)?>px">
									<td class="forecastdate"><?if ($i == 5){
										
										echo "&nbsp;&nbsp;".$overlook_d."";
									}?>&nbsp;<strong><?echo "<span class=\"big\">".replaceDays($forecastday['day_name']." ")."</span> ".$forecastday['date'];?></strong></td>
									<td class="forecasttemp"><?=c_or_f($forecastday['TempLow'])?></td>
									<td class="forecasttemp"><?=c_or_f($forecastday['TempHigh'])?>&nbsp;<img style="vertical-align: middle" src="<? echo "images/clothes/".$forecastday['TempHighCloth']; ?>" width="30" height="30" title="<?=getClothTitle($forecastday['TempHighCloth'], $forecastday['TempHigh'],$forecastday['WindDay'], $forecastday['HumDay'])?>" alt="<?=getClothTitle($forecastday['TempHighCloth'], $forecastday['Temphigh'],$forecastday['WindDay'], $forecastday['HumDay'])?>" /></td>
									<td class="forecasttemp"><?=c_or_f($forecastday['TempNight'])?>&nbsp;<img style="vertical-align: middle"  src="<? echo "images/clothes/".$forecastday['TempNightCloth']; ?>" width="30" height="30" title="<?=getClothTitle($forecastday['TempNightCloth'], $forecastday['TempNight'],$forecastday['WindNight'], $forecastday['HumNight'])?>" alt="<?=getClothTitle($forecastday['TempNightCloth'], $forecastday['TempNight'],$forecastday['WindNight'], $forecastday['HumNight'])?>" /></td>
									<td style="text-align:center"><img src="<? echo "images/icons/day/".$forecastday['icon']; ?>" width="43" height="43" alt="<?=$forecastday['date']?>" /></td>
									<td class="forecastdesc"><? if (isHeb()) $dscpIdx = "lang1"; else $dscpIdx = "lang0"; echo urldecode($forecastday[$dscpIdx]);?></td>
									</tr>
									<? }
								}
							?>
							<tr>
							<td style="padding:0.5em;border-top:1px dashed">
								<a href="<? echo get_query_edited_url($url_cur, 'section', 'averages.php');?>" title="<? echo $monthInWord." ".$AVERAGE[$lang_idx]; ?>">
									<? echo $AVERAGE[$lang_idx];?>
								</a>
							</td>
							<td class="forecasttemp">
								<? echo $monthAverge->get_lowtemp(); ?>
							</td>
							<td class="forecasttemp">
								<? echo $monthAverge->get_hightemp(); ?>
							</td>
							<td colspan="3">&nbsp;&nbsp;
								
							</td>
							</tr>
							 <tr>
							<td style="padding:0.5em">
								<a href="<? echo get_query_edited_url($url_cur, 'section', 'reports.php');?>" title="<? echo $monthInWord." ".$RECORDS[$lang_idx]; ?>">
									<? echo $RECORDS[$lang_idx];?>
								</a>
							</td>
							<td class="forecasttemp" style="direction:ltr">
								<? echo $monthAverge->get_abslowtemp(); ?>
							</td>
							<td class="forecasttemp">
								<? echo $monthAverge->get_abshightemp(); ?>
							</td>
							
							<td colspan="3">&nbsp;&nbsp;
								<div class="invfloat">
								<a href="whatisforecast.php?lang=<?=$lang_idx?>" title="<?=$WHAT_IS_FORECAST[$lang_idx]?>" rel="external">
									<?=$WHAT_IS_FORECAST[$lang_idx]?>
								<?=get_arrow()?></a>&nbsp;&nbsp;
								<a href="legend.php?lang=<?=$lang_idx?>" class="colorbox" title="<?=$LEGEND[$lang_idx]?>"><?=$LEGEND[$lang_idx]?><?=get_arrow()?></a>&nbsp;&nbsp;
								</div>
							</td>
							 </tr>
							</table> 
						</div>
						<div id="forecast24h" style="display:none">
                                                            <div id="for24_given">
                                                                    <? echo($GIVEN[$lang_idx]." ".$AT[$lang_idx]." ".$timetaf.":00 ".$dayF."/".$monthF."/".$yearF);?>
                                                            </div>
                                                            <div id="for24_details">
                                                                    <?=$forcastTicker?>
                                                                    <span id="tempForecastDiv" style="display:none">
                                                                    </span>
                                                            </div>
                                                            <div id="forecasthours" style="clear:both;width:100%;padding:0.5em 0.5em 0;height: 300px;">
                                                             <? 
                                                             foreach ($forecastHour as $hour_f){
                                                             if (($hour_f['time'] % 3 == 0)|| ($hour_f['plusminus'] > 0))
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
                                                             echo "<li class=\"\" style=\"width:45%\">".$hour_f['title'][$lang_idx]."</li>";
                                                             echo "</ul>";
                                                             }
                                                             }
                                                             ?>
                                                             <div style="clear:both">&nbsp;</div>
                                                             <div class="invfloat">
                                                                    <a href="legend.php" class="colorbox" title="<?=$LEGEND[$lang_idx]?>"><?=$LEGEND[$lang_idx]?><?=get_arrow()?></a>&nbsp;&nbsp;
                                                            </div>
							</div>
							
						</div>
					</div>
					<? if (!stristr(get_url(), "forecast")) {$mediumSizeUrl = "phpThumb.php?src=".$contentUrl."&amp;w=550&amp;h=220&amp;zc=C";?>
					
					<div id="sigweather_slider">
							<ul id="sliderselector">
								
							</ul>
							<div id="sliderspacer">&nbsp;
							</div>
							<div id="slider">
			 
							<div class="slideshow" id="sigweather_cycle" style="position: relative">
								<div class="sigweather" id="second" style="height:100%">
								 <div class="background">
									<div id="messagescorner">
										<? echo $detailedforecast;?>
									</div>
									<!-- <div class="overlay">&nbsp;</div>
										<div class="title">
										<a href="#" class="hlink">
											<span class="big"><? echo $MESSAGES[$lang_idx];?></span>
										</a>
										</div> -->
									</div>
								
									</div>
								<div class="sigweather" id="third" >
									<div class="background">		
										<?
										//$img_src = "phpThumb.php?src=images/{$sig[0]['pic']}&amp;w=400&amp;h=242&amp;zc=C";
										$img_src = "images/{$sig[0]['pic']}";
										if (isRaining())
										{
											$pathToFile = "images/randomrain";
											if ($current->get_temp() < 2)
												$pathToFile = "images/randomsnow";
											$flashFile = get_fileFromdir($pathToFile);
										?>
											
												
											
											<script type="text/javascript" src="swfobject.js"></script>
											<div id="flashcontent">
											  This text is replaced by the Flash movie.
											</div>
											<script type="text/javascript">
											   var so = new SWFObject("<?=$flashFile?>", "rainsnow", "560", "242", "6.0.29.0", "#336699");
											   so.addParam("wmode", "transparent");
											   so.addParam("loop", "true");
											   so.write("flashcontent");
											</script>
										<?
										}
										else
										{
										?>
			 
										<a href="<? echo $sig[0]['url'];?>">
												<img src="<?=$img_src?>" alt="<? echo $CURRENT_SIG_WEATHER[$lang_idx];?>" class="main_img" width="550" height="200"/>
										</a>
			 
			 
										<?} ?>
										<div class="overlay" style="top:20%">&nbsp;</div>
										<div class="title" style="top:20%">
											<a href="<? echo $sig[0]['url'];?>" class="hlink" title="<?echo $MORE_INFO[$lang_idx];?>">
			 
													<? echo "{$sig[0]['sig'][$lang_idx]}"; ?>
													<div id="extrainfo"><? echo $sig[0]['extrainfo'][$lang_idx][0]; if ($sig[0]['extrainfo'][$lang_idx][0] != "") echo " - ";?><?echo $MORE_INFO[$lang_idx];?><?=get_arrow()?></div>
											</a>
										</div>
										
									</div>	
								</div>

								<div class="sigweather" id="forth">
									<div class="background">
										<a href="<?=$webcam_link?>">
											<img src="<?=$imagefile?>" alt="<? echo $PIC_DESC[$lang_idx];?>" id="webcampic" class="main_img" width="550" height="200"/>
										</a>
										<div class="overlay" style="top:40%">&nbsp;</div>
										<div class="title" style="top:40%">
										<a href="<?=$webcam_link?>" class="hlink">
											<!-- <span class="big"><? echo $LIVE_PICTURE[$lang_idx];?></span> <br />--><? echo $PIC_DESC[$lang_idx];?><?=get_arrow()?>
										</a>
										</div>
									</div>
								</div>
								<div class="sigweather" id="fifth">
														<div class="background">
										<a href="<? echo "station.php?section=mainstory.php&amp;lang=".$lang_idx;?>">
												<img src="<?=$current_story_img_src?>" alt="<? echo $current_story_title;?>" class="main_img" width="550" height="200"/>
										</a>
										<div class="overlay" style="top:60%">&nbsp;</div>
										<div class="title" style="top:60%">
										<a href="<? echo "station.php?section=mainstory.php&amp;lang=".$lang_idx;?>" class="hlink">
											 <? echo mb_substr($current_story, 0, 68, "UTF-8");?>...<?echo $MORE_INFO[$lang_idx];?><?=get_arrow()?>
										</a>
										</div>
								</div>
												</div>
								<?  if (isHeb()) {?>
								<div class="sigweather" id="sixst">
										<div class="background">
											<a href="<? echo "station.php?section=picoftheday.php&amp;lang=".$lang_idx;?>">
													<img src="<?=$mediumSizeUrl?>" alt="<?=$photoEntry->title->text?>" class="main_img" width="550" height="200" />
											</a>
											<div class="overlay" >&nbsp;</div>
											<div class="title" >
											<a href="<? echo "station.php?section=picoftheday.php&amp;lang=".$lang_idx;?>" class="hlink">
												<!-- <span class="big"><? echo $PIC_OF_THE_DAY[$lang_idx];?></span><br /> --><?=$caption?>&nbsp;- <?echo $MORE_INFO[$lang_idx];?><?=get_arrow()?>
											</a>
											</div>
										</div>
								</div>
								<?  }?>
												
							</div>	
							
						</div>
							</div>
					<? } ?>
			 
			 
			<script type="text/javascript">
			<!--
				function getpagercaptions(ind, el)
				{
					if 
						   (ind == 0) return '<li><div><a href="#" title=""><? echo $MESSAGES[$lang_idx];?></a></div></li>';
						  else if (ind == 1) return '<li><div><a href="<?=$sig_url?>" title="<?=$CURRENT_SIG_WEATHER[$lang_idx]?>"><?=$sig_title?></a></div></li>';
					   else if (ind == 2) return '<li><div><a href="<?=$webcam_link?>" title="<? echo $PIC_DESC[$lang_idx];?>"><? echo $LIVE_PICTURE[$lang_idx];?></a></div></li>';
					  else if (ind == 3) return '<li><div><a href="<? echo "station.php?section=mainstory.php&amp;lang=".$lang_idx;?>" title="<? echo $current_story_title;?>"><? echo $current_story_title;?></a></div></li>';
					  else if (ind == 4) return '<li><div><a href="#" title="<? echo $PIC_OF_THE_DAY[$lang_idx]?>"><? echo $PIC_OF_THE_DAY[$lang_idx]?></a></div></li>';
					  else
						return "";
			 
				}
			//-->
			</script>
 	</div> <!-- forecast -->
	<div id="side_bar" class="float">
	    
		<div class="float" id="slider_ad" >
			   <div class="float" style="margin-bottom:<? if (count($forecastDaysDB) == 5) echo "2.5"; else if (count($forecastDaysDB) == 6) echo "5.5"; else echo "9";?>em">
			   <script type="text/javascript"><!--
				google_ad_client = "pub-2706630587106567";
				/* 300x250, created 10/20/10 */
				google_ad_slot = "2164253176";
				google_ad_width = 300;
				google_ad_height = 250;
				google_color_border = ["<?= $forground->bg['+4'] ?>"];
				google_color_bg = ["<?= $forground->bg['+4'] ?>"];
				google_color_link = ["<?= $forground->bg['-8'] ?>"];
				google_color_url = ["<?= $forground->bg['-8'] ?>"];
				google_color_text = ["<?= $forground->bg['-8'] ?>"];
				//-->
				</script>
				<script type="text/javascript"
				src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
				</script>
				</div>
				<ul class="nav invfloat" style="margin:0 1em">
				<li class="il_image">
					<!-- AddThis Button BEGIN -->
					<div class="addthis_toolbox addthis_default_style">
					<a href="http://www.addthis.com/bookmark.php?v=250&amp;username=boazn" class="addthis_button_compact"><?=$SHARE[$lang_idx];?></a>
					<a class="addthis_button_facebook"></a>
					<a class="addthis_button_twitter"></a>
					</div>
					<!-- AddThis Button END -->
				</li>
				<li class="il_image">
					<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2Fpages%2FJerusalem-Israel%2F02ws-yrwsmyym-mzg-hwwyr-bzmn-mt%2F118726368187010&amp;layout=button_count&amp;show_faces=true&amp;width=100&amp;action=like&amp;colorscheme=light&amp;height=21" style="border:none; overflow:hidden; width:100px; height:21px;allowTransparency:true"></iframe>
				</li>
				</ul>
    	</div>
		    
			
			
		<?
					// ///////////////////////////////
					//  moon
					// ///////////////////////////////
					$moon=GetMoonPhase(time());
					?>
					<ul class="list float" style="width:90%;margin:0">
					<li class="<?=getAlternateClass()?>">
					<div id="moon">
						<div id="moontitle" >
							<a href="http://wise-obs.tau.ac.il/cgi-bin/eran/calen.html?MO=<? echo $month;?>&amp;YE=<? echo $year;?>&amp;TI=Wise+Observatory+Schedule&amp;LO=35.167&amp;LA=31.783&amp;TZ=2&amp;PLACE=2" rel="external" title="<? echo $MORE_INFO[$lang_idx];?>">
								<?
								$moonurl = "http://www.almanac.com/sites/new.almanac.com/files/moon.gif";
								
								if ($moon=="ne")
								{
									echo $FULL_MOON[$lang_idx];
									//update_action ("MoonFullNew", "<br/><b>".$FULL_MOON[$HEB]."</b><br/><img src=\"$moonurl\" width=\"50\">", $FULL_MOON);
								}
								else if ($moon=="ny") 
								{
									echo $NEW_MOON[$lang_idx];
								}
								else echo $MOON[$lang_idx]." ".$TODAY[$lang_idx];
								?>
							</a>
						</div>
						<div>
							<div id="moonimage">
								<img src="<?=$moonurl?>" width="60" height="60" alt="<? echo $MOON[$lang_idx];?>"/>
							</div>
							<div id="moonriseset">
								<div>
									<a href="http://wise-obs.tau.ac.il/cgi-bin/eran/calen.html?MO=<? echo $month;?>&amp;YE=<? echo $year;?>&amp;TI=Wise+Observatory+Schedule&amp;LO=35.167&amp;LA=31.783&amp;TZ=2&amp;PLACE=2" rel="external" title="<? echo $MORE_INFO[$lang_idx];?>">
										<? echo $RISE[$lang_idx]; ?>
									</a>
									<br />
									<a href="http://wise-obs.tau.ac.il/cgi-bin/eran/calen.html?MO=<? echo $month;?>&amp;YE=<? echo $year;?>&amp;TI=Wise+Observatory+Schedule&amp;LO=35.167&amp;LA=31.783&amp;TZ=2&amp;PLACE=2" rel="external" title="<? echo $MORE_INFO[$lang_idx];?>">
										<? echo $SET[$lang_idx]; ?>
									</a>
								</div>
								<div id="moonriseset_values">
									
								</div>
								
							</div>
							
							<div class="float">
								<a href="http://wise-obs.tau.ac.il/cgi-bin/eran/calen.html?MO=<? echo $month;?>&amp;YE=<? echo $year;?>&amp;TI=Wise+Observatory+Schedule&amp;LO=35.167&amp;LA=31.783&amp;TZ=2&amp;PLACE=2" rel="external" title="<? echo $MORE_INFO[$lang_idx];?>">
								<? echo $MORE_INFO[$lang_idx];?><?=get_arrow()?>
								</a>
							  </div>
						</div>
					</div>
					</li>
					<? ?>
					<!--  /moon  -->
				</ul>
			<ul class="list float" style="width:90%;margin:0">
				<!-- //  sunset sunrise -->
				<li class="<?=getAlternateClass()?>">
				<div id="sun">
						<div>
						<a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=SolarRadHistory.gif&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;style=<?=$_GET["style"]?>" title="<? echo $MORE_INFO[$lang_idx];?>">	
								<? echo $SUN_PHASE[$lang_idx]." ".$TODAY[$lang_idx]; ?>
						</a>	
						</div>
						<div>
							
							<div class="float">
							<img src="<? echo "images/icons/day/".$forecastDaysDB[0]['icon']; ?>" width="60" height="60" alt="<?=$forecastDaysDB[0]['date']?>" />
							</div>
							<div class="float">
							<a href="http://www.sunrisesunset.com/calendar.asp?comb_city_info=Jerusalem,%20Israel;-35.25;31.75;2;9&amp;month=<?echo $month; ?>&amp;year=<?echo $year; ?>&amp;time_type=0" rel="external" title="<? echo $MORE_INFO[$lang_idx];?>"><? echo $RISE[$lang_idx]; ?></a> 
							&nbsp;<? echo $sunrise; ?><br />
							<a href="http://www.sunrisesunset.com/calendar.asp?comb_city_info=Jerusalem,%20Israel;-35.25;31.75;2;9&amp;month=<?echo $month; ?>&amp;year=<?echo $year; ?>&amp;time_type=0" rel="external" title="<? echo $MORE_INFO[$lang_idx];?>"><? echo $SET[$lang_idx]; ?></a> 
							&nbsp;<? echo $sunset; ?><br />
                                                                                                            
							</div>
							<div class="float">
							<a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=SolarRadHistory.gif&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;style=<?=$_GET["style"]?>" title="<? echo $MORE_INFO[$lang_idx];?>">
                                                        <? echo $MORE_INFO[$lang_idx];?><?=get_arrow()?>
                            </a>
                            </div>
							<div class="float">
							<? echo $today->get_sunshinehours()." ".$SUNSHINEHOURS[$lang_idx]." ".$TILL_NOW[$lang_idx];?> 
							</div>
						</div>
				</div>
				</li>
				<!-- END  sunset sunrise -->
				</ul>
				
		</div>
		
	 <div id="googlemainads">
			    	
				
				
				
				<!--<div class="float" style="padding:0 0.5em">
				<img src="http://www.homeinj.co.il/_/rsrc/1371368946223/hauma/%D7%94%D7%93%D7%9E%D7%99%D7%99%D7%AA%20%D7%9E%D7%A9%D7%9B%D7%A0%D7%95%D7%AA%20%D7%94%D7%9C%D7%90%D7%95%D7%9D.jpg?height=300&width=400" width="120" height="80" />
				</div>
				<div class="float big" style="padding:0.3em 0.5em;direction:rtl;width:50%">
				<a href="http://www.homeinj.co.il/hauma" target="_blank">רוצה לחסוך עשרות אלפי שקלים בפרוייקט משכנות הלאום שבמשכנות האומה? לפרטים לחץ כאן</a>
				
				</div> -->
				<script type="text/javascript"><!--
				google_ad_client = "ca-pub-2706630587106567";
				/* 728x90, created 3/31/10 */
				google_ad_slot = "4039563889";
				google_ad_width = 728;
				google_ad_height = 90;
				google_color_border = ["<?= $forground->bg['+4'] ?>"];
				google_color_bg = ["<?= $forground->bg['+4'] ?>"];
				google_color_link = ["<?= $forground->bg['-8'] ?>"];
				google_color_url = ["<?= $forground->bg['-8'] ?>"];
				google_color_text = ["<?= $forground->bg['-8'] ?>"];
				//-->
				</script>
				<script type="text/javascript"
				src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
				</script>
			<!--
 	<div class="invfloat" style="width:33%;padding:1.2em 0em">
		<script type="text/javascript"><!--
		google_ad_client = "ca-pub-2706630587106567";
		/* hometable short */
		google_ad_slot = "4330877090";
		google_ad_width = 320;
		google_ad_height = 50;
		google_color_border = ["<?= $forground->bg['+4'] ?>"];
		google_color_bg = ["<?= $forground->bg['+4'] ?>"];
		google_color_link = ["<?= $forground->bg['-8'] ?>"];
		google_color_url = ["<?= $forground->bg['-8'] ?>"];
		google_color_text = ["<?= $forground->bg['-8'] ?>"];
		//-->
		<!--</script>
		<script type="text/javascript"
		src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
		</script>
	</div>
	-->
</div>
<? 
    $limitLines=4; 
	include("chat.php");
?>
<?
//////////////////////////////////////////////////////////////////

if ($boolbroken)
{
	for ($i=0 ; $i < count($messageBroken) ; $i++)
	{
		echo $messageBroken[$i][$lang_idx];
	}
}

	
		
/************************************************************************/
?>