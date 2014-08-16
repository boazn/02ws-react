<?
//error_reporting(E_ERROR | E_PARSE);
//ini_set("error_reporting", E_ALL);
include_once("start.php");
include_once("requiredDBTasks.php");
include_once("forecastlib.php");
$sig_url = $sig[0]['url'];
$sig_title = $sig[0]['sig'][$lang_idx];
$imagefile = "phpThumb.php?src=".getUpdatedPic()."&amp;w=600&amp;h=292&amp;zc=C&amp;fltr[]=gam|0.8";//&amp;fltr[]=cont|50
/////////////////////////////////////////
$floated = false;
 
////////////////////////////////////////
	$overlook_d = $OVERLOOK[$lang_idx]." "."<a href=\"javascript:void(0)\" class=\"info\">(?)<span class=\"info\">".$OVERLOOK_EXP[$lang_idx]."</span></a><br />";
?>
		
		<div class="float" id="nextdays">
			
				<div id="for_title" class="float">
					<div id="forecastnextdays_title" class="float slogan inv_plain_3_zebra title_selected">
					<a href="javascript:void(0)" id="forecastnextdays_link" onclick="toggle('forecastnextdays');toggle('forecast24h');$('#forecastnextdays_title').removeClass('title_not_selected').addClass('title_selected');$('#forecast24h_title').removeClass('title_selected').addClass('title_not_selected');">
						<? echo($FORECAST_4D[$lang_idx]); ?>
					</a>
					<!-- <span class="small">
					<a href="whatisforecast.php?lang=<?=$lang_idx?>" title="<?=$WHAT_IS_FORECAST[$lang_idx]?>" rel="external">
						*
					</a>
					</span> -->
					</div>
					<div id="forecast24h_title" class="float slogan inv_plain_3_zebra title_not_selected">
						<a href="javascript:void(0)" onclick="toggle('forecast24h');toggle('forecastnextdays');getTempForecast(<?=$timetaf?>, '<?=$dayF."/".$monthF."/".$yearF?>');$('#forecast24h_title').removeClass('title_not_selected').addClass('title_selected');$('#forecastnextdays_title').removeClass('title_selected').addClass('title_not_selected');">
							<? echo($FORECAST_TITLE[$lang_idx]." ".$FOR[$lang_idx]." 24 ".$HOURS[$lang_idx]);?>
						</a>
					</div>
				</div>
				
 
			
			<div id="forecastnextdays" >
				<table id="tableForecastNextDays" class="inv_plain_3_zebra" style="border-spacing:2;border-padding:4">
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
 
						for ($i = 0; $i < count($forecastDaysDB); $i++) 
						{
						if ($i % 2 == 1)
							$class =  " class=\"inv_plain_3\" ";
						else
							$class =  " class=\"inv_plain_3 half_zebra\" ";
						
						?>
						<tr <?=$class?> style="height:<?=180/count($forecastDaysDB)?>px">
						<td class="forecastdate"><?if ($i == 5){
							
							echo "&nbsp;&nbsp;".$overlook_d."";
						}?>&nbsp;<strong><?echo replaceDays($forecastDaysDB[$i]['day_name']." ")." ".$forecastDaysDB[$i]['date'];?></strong></td>
						<td class="forecasttemp"><?=c_or_f($forecastDaysDB[$i]['TempLow'])?></td>
						<td class="forecasttemp"><?=c_or_f($forecastDaysDB[$i]['TempHigh'])?>&nbsp;<img style="vertical-align: middle" src="<? echo "images/clothes/".$forecastDaysDB[$i]['TempHighCloth']; ?>" width="30" height="30" title="<?=getClothTitle($forecastDaysDB[$i]['TempHighCloth'])?>" alt="<?=getClothTitle($forecastDaysDB[$i]['TempHighCloth'])?>" /></td>
						<td class="forecasttemp"><?=c_or_f($forecastDaysDB[$i]['TempNight'])?>&nbsp;<img style="vertical-align: middle"  src="<? echo "images/clothes/".$forecastDaysDB[$i]['TempNightCloth']; ?>" width="30" height="30" title="<?=getClothTitle($forecastDaysDB[$i]['TempNightCloth'])?>" alt="<?=getClothTitle($forecastDaysDB[$i]['TempNightCloth'])?>" /></td>
						<td style="text-align:center"><img src="<? echo "images/icons/day/".$forecastDaysDB[$i]['icon']; ?>" width="43" height="43" alt="<?=$forecastDaysDB[$i]['date']?>" /></td>
						<td class="forecastdesc"><? if (isHeb()) $dscpIdx = "lang1"; else $dscpIdx = "lang0"; echo urldecode($forecastDaysDB[$i][$dscpIdx]);?></td>
						</tr>
						<? }
					}
				?>
				<tr>
				<td style="padding:0.5em">
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
					<a href="legend.php" class="colorbox" title="<?=$LEGEND[$lang_idx]?>"><?=$LEGEND[$lang_idx]?><?=get_arrow()?></a>&nbsp;&nbsp;
					</div>
	   			</td>
                 </tr>
				</table> 
			</div>
			<div id="forecast24h" style="display:none" class="inv_plain_3_zebra">
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
						 if ($hour_f['time'] % 3 == 0)
						 {
						  echo "<ul class=\"nav forecasttimebox inv_plain_3_zebra\" >";
						 echo "<li class=\"tsfh\" style=\"text-align:center;width:3%;display:none\">".$hour_f['currentDateTime']."</li>";
                                                 echo "<li class=\"tsfh\" style=\"text-align:center;width:10%\">".date("j/m", $hour_f['currentDateTime'])."</li>";
						 echo "<li class=\"timefh\" style=\"text-align:center;width:8%\">".$hour_f['time']."</li>";
						 echo "<li class=\"forecasttemp\" style=\"text-align:center;width:7%\" id=\"tempfh".intval($hour_f['time']).intval(date("j", $hour_f['currentDateTime']))."\">"."</li>";
						 echo "<li class=\"\" style=\"text-align:center;width:7%\"><img src=\"images/icons/day/".$hour_f['icon']."\" height=\"30\" width=\"45\" alt=\"".$hour_f['icon']."\" /></li>";
						 echo "<li class=\"\" style=\"\">".$hour_f['wind'].",</li>";
						 echo "<li class=\"\" style=\"\">".$hour_f['title']."</li>";
						 echo "</ul>";
						 }
						 }
						 ?>
				</div>
				
			</div>
		</div>
		<? if (!stristr(get_url(), "forecast")) {include_once "picasaproxy.php";?>
		
		<div id="sigweather_slider">
				<ul id="sliderselector">
					
				</ul>
				<div id="sliderspacer">&nbsp;
				</div>
				<div id="slider">
 
				<div class="slideshow" id="sigweather_cycle" style="position: relative">
					<div class="sigweather inv_plain_3_zebra" id="second" style="height:100%">
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
									<img src="<?=$img_src?>" alt="<? echo $CURRENT_SIG_WEATHER[$lang_idx];?>" class="main_img" width="200" height="100"/>
							</a>
 
 
							<?} ?>
							<div class="overlay" style="top:20%">&nbsp;</div>
							<div class="title" style="top:20%">
								<a href="<? echo $sig[0]['url'];?>" class="hlink" title="<?echo $MORE_INFO[$lang_idx];?>">
 
										<? echo "{$sig[0]['sig'][$lang_idx]}"; ?>
										<div id="extrainfo"><? echo $sig[0]['extrainfo'][$lang_idx]; if ($sig[0]['extrainfo'][$lang_idx] != "") echo " - ";?><?echo $MORE_INFO[$lang_idx];?><?=get_arrow()?></div>
								</a>
							</div>
							
						</div>	
					</div>

					<div class="sigweather" id="forth">
						<div class="background">
							<a href="<?=$webcam_link?>">
								<img src="<?=$imagefile?>" alt="<? echo $PIC_DESC[$lang_idx];?>" id="webcampic" class="main_img" width="200" height="100"/>
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
									<img src="<?=$current_story_img_src?>" alt="<? echo $current_story_title;?>" class="main_img" width="200" height="100"/>
							</a>
							<div class="overlay" style="top:60%">&nbsp;</div>
							<div class="title" style="top:60%">
							<a href="<? echo "station.php?section=mainstory.php&amp;lang=".$lang_idx;?>" class="hlink">
								 <? echo mb_substr($current_story, 0, 46, "UTF-8");?>...<?echo $MORE_INFO[$lang_idx];?><?=get_arrow()?>
							</a>
							</div>
					</div>
                                    </div>
                                    <div class="sigweather" id="sixst">
                                            <div class="background">
							<a href="<? echo "station.php?section=picoftheday.php&amp;lang=".$lang_idx;?>">
									<img src="<?=$mediumSizeUrl?>" alt="<?=$photoEntry->title->text?>" class="main_img" width="200" height="100" />
 							</a>
							<div class="overlay" >&nbsp;</div>
							<div class="title" >
							<a href="<? echo "station.php?section=picoftheday.php&amp;lang=".$lang_idx;?>" class="hlink">
								<!-- <span class="big"><? echo $PIC_OF_THE_DAY[$lang_idx];?></span><br /> --><?=$caption?>&nbsp;- <?echo $MORE_INFO[$lang_idx];?><?=get_arrow()?>
							</a>
							</div>
					</div>
                                    </div>
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