<!-- average line -->
	<? if (!$error_db)
	{
		include_once ("requiredDBTasks.php");
	}?>
	<tr >
		<td class="grad">
			<fieldset style="width:85%;height:80px">
				<legend>
					<a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph&amp;graph=OutsideTempHistory.gif&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>">
						<? echo($DIFF_FROM[$lang_idx])." ".($AVERAGE[$lang_idx]);?>
					</a>
				</legend>
				<? echo($MAX[$lang_idx]);?>&nbsp;
				<a href="" title="<? echo($TODAY[$lang_idx]);?> <? echo $today->get_hightemp(),"<? echo $current->get_tempunit(); ?>";?> - <? echo $monthInWord." ".$AVERAGE[$lang_idx].": ".$monthAverge->get_hightemp(),"<? echo $current->get_tempunit(); ?>";?> ">
					<?php echo get_param_tag($hightemp_diffFromAv)."<? echo $current->get_tempunit(); ?>";?>
					
				</a>
				<br/>
				<? echo($MIN[$lang_idx]);?>&nbsp;
				<a href="" title="<? echo($TODAY[$lang_idx]);?> <? echo $today->get_lowtemp(),"<? echo $current->get_tempunit(); ?>";?> - <? echo $monthInWord." ".$AVERAGE[$lang_idx].": ".$monthAverge->get_lowtemp(),"<? echo $current->get_tempunit(); ?>";?> ">
					<? echo get_param_tag($lowtemp_diffFromAv)."<? echo $current->get_tempunit(); ?>"; ?>
					
				</a>
			</fieldset>
		</td>
		<td class="grad">
		<fieldset style="width:85%;height:80px">
			<legend>
				<a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph&amp;graph=OutsideHumidityHistory.gif&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>" title="<? if (isHeb()) echo "לחות היום בהשוואה למקסימום ומינימום של הממוצע החודשי"; else echo "humidity today compared to its month's average";?>">
					<? echo($DIFF_FROM[$lang_idx])." ".($AVERAGE[$lang_idx]);?>
				</a>
			
			</legend>
			<? echo($MAX[$lang_idx]);?>&nbsp;
			<a href="" title="<? echo($TODAY[$lang_idx]);?> <? echo $today->get_highhum(),"%";?> - <? echo $monthInWord." ".$AVERAGE[$lang_idx].": ".$monthAverge->get_highhum(),"%";?> ">
				<? echo get_img_tag ($highhum_diffFromAv).abs($highhum_diffFromAv)."%";?>
				
			</a>
			<br/>
			<? echo($MIN[$lang_idx]);?>&nbsp;
			<a href="" title="<? echo($TODAY[$lang_idx]);?> <?echo $today->get_lowhum(),"%";?> - <? echo $monthInWord." ".$AVERAGE[$lang_idx].": ".$monthAverge->get_lowhum(),"%";?>">
				<? echo get_img_tag ($lowhum_diffFromAv).abs($lowhum_diffFromAv)."%";?>
				
			</a>
		</fieldset>
		</td>
		<td class="grad">
		</td>
		<td class="grad">
		</td>
		<td class="grad">
			<fieldset style="width:85%;height:80px">
			<legend>
				<a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph&amp;graph=RainRateHistory.gif&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>">
						<? echo($DIFF_FROM[$lang_idx])." ".($AVERAGE[$lang_idx]);?>
				</a>
			</legend>
				<div style="float:<?echo get_s_align();?>">
					<? echo($RAIN[$lang_idx]);?>&nbsp;
				</div>
				<div dir="ltr" style="font-weight:bold" title="<? echo $TILL_NOW[$lang_idx].": ".$seasonTillNow->get_rain()." <--> ".$WHOLE_SEASON[$lang_idx]." ".$NORMAL[$lang_idx].": ".$wholeSeason->get_rain();?>" <? if ($wholeSeason->get_raindiffav() >0) echo "class=\"more \">+"; else echo " class=\"less \">";echo round($wholeSeason->get_raindiffav())."mm (".$wholeSeason->get_rainperc()."%)"; ?>
				</div>
				<div style="float:<?echo get_s_align();?>">
					<? echo($RAINY_DAYS[$lang_idx]);?>&nbsp;
				</div>
				<div dir="ltr" style="font-weight:bold" title="<? echo $TILL_NOW[$lang_idx].": ".$seasonTillNow->get_rainydays()." <--> ".$WHOLE_SEASON[$lang_idx]." ".$NORMAL[$lang_idx].": ".$wholeSeason->get_rainydays();?>" <? if ($wholeSeason->get_rainydaysdiffav() >0) echo "class=\"more \">+"; else echo " class=\"less \">";echo $wholeSeason->get_rainydaysdiffav();?>
				</div>
			</fieldset>
		</td>
		
	</tr>
	<!-- End average line -->
