<?
ini_set("display_errors","On");
$altClass = 'inv_plain_3_zebra half_zebra';
function getAlternateClass()
{
	global $altClass;
	if ($altClass == '')
    	$altClass = 'inv_plain_3_zebra half_zebra';
	else
		$altClass = 'inv_plain_3_zebra half_zebra';
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
		include "forecast.php";
		?>
                
	   	<div id="footerads">
			<div id="googlemainads">
			     	
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
                       </div>
			<div class="inv_plain_3" id="myfootermenu">
				<?
					// ///////////////////////////////
					//  moon
					// ///////////////////////////////
					$moon=GetMoonPhase(time());
					?>
					<ul class="list float">
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
								<img src="<?=$moonurl?>" width="55" height="55" alt="<? echo $MOON[$lang_idx];?>"/>
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
				<ul class="list float">
				<!-- //  sunset sunrise -->
				<li class="<?=getAlternateClass()?>">
				<div id="sun">
						<div>
						<a href="http://www.gaisma.com/en/location/jerusalem.html" rel="external" title="<? echo $MORE_INFO[$lang_idx];?>">	
								<? echo $SUN_PHASE[$lang_idx]; ?>
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
							<a href="http://www.gaisma.com/en/location/jerusalem.html" rel="external" title="<? echo $MORE_INFO[$lang_idx];?>">
                                                        <? echo $MORE_INFO[$lang_idx];?><?=get_arrow()?>
                            </a>
                            </div>
						</div>
				</div>
				</li>
				<!-- END  sunset sunrise -->
				</ul>
				<ul class="list float" style="width:35%">
				<li class="<?=getAlternateClass()?>"><? echo $GENDER_NOTICE[$lang_idx]." <em id=\"gendertype\"></em>. ".$GENDER_NOTICE2[$lang_idx]; ?></li>
				<li class="<?=getAlternateClass()?>">
						<a class="hlink" href="<?=$_SERVER['SCRIPT_NAME'];?>?section=survey.php&amp;survey_id=1&amp;lang=<? echo $lang_idx;?>" title="<? echo($FSEASON[$lang_idx].", ".$VOTE[$lang_idx]);?>" >
					<?echo $FSEASON[$lang_idx];?><?=get_arrow()?>
					</a>
				</li>
				<!--
				<li class="<?=getAlternateClass()?>"><a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=temp.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>&amp;style=<?=$_GET["style"]?>" title=""><?=$GRAPH[$lang_idx]." ".$FOR[$lang_idx]." ".$TEMP[$lang_idx]."/".$HUMIDITY[$lang_idx];?><?=get_arrow()?></a></li>
				-->
				<!--
				<li class="<?=getAlternateClass()?>"><a href="<? echo get_query_edited_url($url_cur, 'section', FILE_THIS_MONTH);?>" class="hlink" title="<?=$month?>"><? echo $MONTHLY_SUMMARY_LINK[$lang_idx];?><?=get_arrow()?></a></li>
				-->
				<!--
				<li class="<?=getAlternateClass()?>"><a href="<? echo get_query_edited_url($url_cur, 'section', FILE_THIS_YEAR);?>" class="hlink" title="<?=$year?>"><? echo $YEARLY_SUMMARY_LINK[$lang_idx];?><?=get_arrow()?></a></li>
				-->
				
				</ul>
			</div>
			
			
		</div>
		
	</div>
	
 	
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