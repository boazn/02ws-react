<?
header('Content-type: text/html; charset=utf-8');
if ($_GET['debug'] == '')
    include "begin_caching.php";
//if (@$_GET['section'] == '')		
//	include "wapredirect.php";
	
include_once("include.php"); 
redirectToSite(get_url());

include "start.php";
include_once("requiredDBTasks.php");
include_once "sigweathercalc.php";
ini_set("display_errors","On");

$site_width = "950px";
$offset_exp = 1800;
$ExpireString = gmdate("D, d M Y H:i:s", time() + $offset_exp) . " GMT";

?>
<!DOCTYPE html>
<html xml:lang="<? if (isHeb()) echo "he"; else echo "en"; ?>" lang="<? if (isHeb()) echo "he"; else echo "en"; ?>" >
<head>
<title <? if (isHeb()) echo "dir=\"rtl\""; ?>><? echo getPageTitle()?></title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
<meta name="description" content=" ירושמים  . תחנה המדווחת על מזג-האויר בירושלים. יש כאן מצלמה דיגיטלית המצלמת את המתרחש בחוץ כל 10 דקות, תחזית לי-ם, חו''ל, גרפים, נתונים מפורטים , ארכיון וזו רק ההתחלה... Jerusalem weather station in Israel. Here you have live pictures, 6 days forecast, live stream, weather graphs, current significant conditions, detailed archive and much more. This is online weather station which updates frequently.  " />
<meta name="keywords" content="climate, storm, snow, monthly, stat , תחזית מזג אויר , אקלים, קר , חם , טיולים, מפות, ירושמים "/>
<meta name="author" content="בועז נחמיה" />
<? 
	$style=$_GET['style'];
	if ($style < 2) $style = "";

?> 
<link title="Default Colors" href="generalstyle.php<?echo "?lang=".$lang_idx."&amp;forground_color=".$forground_color."&amp;base_color=".$base_color;?>" rel="stylesheet" type="text/css" media="screen" />
<? if ($mySite) { ?>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-647172-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<? } ?>
</head>
<!-- no onload in body because dailypicloop -->
<body>
<div style="width:<?= $site_width ?>"  id="header" class="inv_plain_3" >
	
	<div class="background" id="header_bg">
	</div>
	<div class="foreground">
		
		<div id="website_title">
				<a href="<? echo get_query_edited_url(get_url(), 'section', '');?>"  title="<? echo $HOME_PAGE[$lang_idx];?>" class="hlink" >	 
					<span class="logo"><? echo $LOGO[$lang_idx];?></span>&nbsp;
					
					<div id="slogan"><span><? echo $SLOGAN[$lang_idx];?></span>&nbsp;&nbsp;
					<? echo $ELEVATION[$lang_idx]." ".ELEVATION." ".$METERS[$lang_idx]; ?>&nbsp;&nbsp;
					<span <? if (time() - filemtime($fulldatatotake) > 3600) echo "class=\"high afont\"";?>>
					<? if (isHeb()) echo $dateInHeb; else echo $date;?>
					</span>
					</div>
				
				
    			       </a>
				
				<div id="search_box">
				<form action="<? echo get_query_edited_url($url_cur, 'section', 'search.php');?>" id="cse-search-box">
				  <div>
					<input type="hidden" name="section" value="search.php" />
					<input type="hidden" name="cx" value="partner-pub-2706630587106567:b8ng7y2q8ny" />
					<input type="hidden" name="cof" value="FORID:11" />
					<input type="hidden" name="ie" value="UTF-8" />
					<input type="text" name="q" size="24" class="inv_plain_3"/>
					<input type="submit" name="sa" value="<?=$SEARCH_IN[$lang_idx]?>" class="inv_plain_3"/>
				  </div>
				</form>
				<script type="text/javascript" src="http://www.google.co.il/cse/brand?form=cse-search-box&amp;lang=iw"></script>
				</div>
				<div class="il_image" id="changelang">
				<? if ($lang_idx == 1) {?>
								<a href="#" title="to english" onclick="changeLang('0')"><div class='spriteB eng' title="switch to english"></div></a>
								<?} 
								else {?>
								<a href="#" onclick="changeLang('1')"><div class='sprite eng' title="switch to hebrew"></div></a>
				<?} ?>
				</div>
				<? if (isRaining()){
				       $sound = get_fileFromdir('sound/rain');
				?>
				<div id="rainaudio" style="direction:ltr">
				<audio controls="controls" height="20px" width="250px"  autoplay="autoplay" >
				   <source src="<?=$sound?>" type="audio/mpeg" />
				   <embed height="20px" width="250px" src="<?=$sound?>" playcount="2" autostart="false"/>
				</audio>
				</div>
				<? }?>
				
		</div>
	</div>
	<ul class="nav grad" id="menu" style="width:<?= $site_width ?>">
	<li  class="il_first" >
	</li>
	<li  class="il_first" id="statusline" onclick="toggle('top_table');toggle('tempdiv_moreinfo');toggle('trends');">
			
				<div id="templabel" class="paramtitle big">
				 		
						<? echo $NOW[$lang_idx];?> 
					
				</div>
				<div id="tempdivvalue">
								
					<a href="javascript:void(0)"  class="info">
						<span id="tempvalue" class="tempvalue high">
							<? echo $current->get_temp();?><? echo $current->get_tempunit(); ?>
						</span>
						<span class="info" style="top:-100px">
							<span><? echo $HIGH[$lang_idx].": "; ?></span>
							<span class="high"><? echo toLeft($today->get_hightemp().$current->get_tempunit()); ?></span>&nbsp;<? echo $ON[$lang_idx]." ".$today->get_hightemp_time()." "; ?>
							<br/><br/>
							<span><? echo $LOW[$lang_idx].": "; ?></span>
							<span class="low"><? echo toLeft($today->get_lowtemp().$current->get_tempunit()); ?></span>&nbsp;<? echo $ON[$lang_idx]." ".$today->get_lowtemp_time()." "; ?>
						</span> 
						<? echo get_img_tag($min15->get_tempchange());?>
						<span class="info" style="top:-33px">
								<? echo getLastUpdateMin()." ".($MINTS[$lang_idx]).": ".get_param_tag($min15->get_tempchange()).$current->get_tempunit(); ?>
						</span>  
					</a>
				
				</div>
				<? if ((!isHeb())&&(first_page())) {?>
				<div dir="ltr" class="small float" id="tempunitconversion">
				<form method="post" action="<?=$_SERVER['SCRIPT_NAME'];?>?lang=<? echo $lang_idx;?>&amp;tempunit=<? if ($current->get_tempunit() == '&#176;C') echo 'F'; else echo 'C';?>">
					<input type="submit" name="tocorf" value="<? if ($current->get_tempunit() == '&#176;C') echo '&#176;F'; else echo '&#176;C';?>" title="switch to <? if ($current->get_tempunit() == '&#176;C') echo '&#176;F'; else echo '&#176;C';?>" class="inv_plain_3" />
				</form>
				</div>
				<?}	?>
				
			
			<div id="windstatus">
			
			<div id="windy">
			<? echo getWindStatus();?>
			</div>
			<div  id="coldmeter">
			<a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=survey.php&amp;survey_id=2&amp;lang=<? echo $lang_idx;?>">, <span id="current_feeling_link" title="<?=$HOTORCOLD_T[$lang_idx]?> - <?=$COLD_METER[$lang_idx]?>">...</span>
			</a>
			</div>
			   <?
					if (min($current->get_windchill(), $current->get_thw()) < ($current->get_temp() - 1) && $current->get_temp() < 20 ){ ?>
						<div id="itfeels_windchill"> 
						 <a title="<?=$WIND_CHILL[$lang_idx]?>" href="<? echo $_SERVER['SCRIPT_NAME']; ?>?section=graph.php&amp;graph=tempwchill.php&amp;profile=1&amp;lang=<?=$lang_idx?>"> 
							, <? echo $IT_FEELS[$lang_idx]; ?>
							<span dir="ltr" class="low" title="<?=$WIND_CHILL[$lang_idx]?>"><? echo min($current->get_windchill(), $current->get_thw())."&#176;"; ?></span>
						 </a>
						</div>
					
					<? } 
					else if ($current->get_HeatIdx() > ($current->get_temp())){ ?>
						<div class="" id="itfeels_heatidx">
						 <a title="<?=$HEAT_IDX[$lang_idx]?>"  href="<?=$_SERVER['SCRIPT_NAME']?>?section=graph.php&amp;graph=tempheat.php&amp;profile=1&amp;lang=<?=$lang_idx?>"> 
							, <? echo $IT_FEELS[$lang_idx]; ?>
							<span dir="ltr" class="high" title="<?=$HEAT_IDX[$lang_idx]?>"><? echo max($current->get_HeatIdx(), $current->get_thw())."&#176;";  ?></span>
						 </a> 
						</div>
					<?}?>
		
					
					
			</div>
			<div class="float" id="tempdiv_moreinfo">
				<a href="javascript:void(0)" title="<?=$TRENDS[$lang_idx]?>&nbsp;<? echo $HUMIDITY[$lang_idx];?>&nbsp;<? echo $WIND[$lang_idx];?>&nbsp;<? echo $BAR[$lang_idx];?>&nbsp;<? echo $RAIN[$lang_idx];?>&nbsp;<? echo $RAIN_RADAR[$lang_idx];?>&nbsp;<? echo $SATELLITE[$lang_idx];?>">
				, <? echo $MORE_INFO[$lang_idx];?>&nbsp;<?=get_arrow()?>	
				</a>
			</div>
		
		
	</li>
	<li class="il_image">
	</li>
	
	<li class="il_image"><a href="<? echo get_query_edited_url($url_cur, 'section', 'chooseMonthYear');?>" title="<? echo $HISTORY[$lang_idx].", ".$YESTERDAY[$lang_idx].", ".$CHOOSE[$lang_idx]."...";?>"><? echo $WHAT_HAPPEND[$lang_idx];?>&nbsp;&#9660;</a>
            <ul style="<?echo get_s_align();?>: -4em;">
                <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'yesterday.php');?>" class="hlink"> <? echo $YESTERDAY[$lang_idx];?><?=get_arrow()?></a></li>
				<li><a href="<? echo get_query_edited_url($url_cur, 'section', 'averages.php');?>" class="hlink"><? echo $AVERAGE[$lang_idx];?><?=get_arrow()?></a></li>  
				<li><a href="<? echo get_query_edited_url($url_cur, 'section', 'reports/downld02.txt');?>" class="hlink"> <? echo $DETAILED_TABLE[$lang_idx];?><?=get_arrow()?></a></li>
				<li><a href="<? echo get_query_edited_url($url_cur, 'section', 'reports/downld08.txt');?>" class="hlink"> <? echo $DETAILED_TABLE08[$lang_idx];?><?=get_arrow()?></a></li>
				<li><a href="<? echo get_query_edited_url($url_cur, 'section', FILE_THIS_MONTH);?>" ><? echo $monthInWord." ".$year." - ".$SUMMARY[$lang_idx]; ?><?=get_arrow()?></a></li>
				<li><a href="<? echo get_query_edited_url($url_cur, 'section', FILE_THIS_YEAR);?>" ><? echo $year." - ".$SUMMARY[$lang_idx]; ?><?=get_arrow()?></a></li>    
				<li><a href="<? echo get_query_edited_url($url_cur, 'section', 'chooseMonthYear');?>" ><? echo $CHOOSE[$lang_idx]; ?><?=get_arrow()?></a></li>
				<li><a href="<? echo get_query_edited_url($url_cur, 'section', '2weeks.php');?>" class="hlink"><? echo $ALL_GRAPHS[$lang_idx]." - ".$LAST_WEEK[$lang_idx];?><?=get_arrow()?></a></li>
				<li><a href="<? echo get_query_edited_url($url_cur, 'section', 'month.php');?>" class="hlink"><? echo $ALL_GRAPHS[$lang_idx]." - ".$LAST_MONTH[$lang_idx];?><?=get_arrow()?></a></li>
				<li><a href="<? echo get_query_edited_url($url_cur, 'section', 'allTimeRecords.php');?>" class="hlink" title="<?=$RECORDS[$lang_idx];?>"><? echo $RECORDS_LINK[$lang_idx];?><?=get_arrow()?></a></li>
				<li><a href="<? echo get_query_edited_url($url_cur, 'section', 'RainSeasons.php');?>" class="hlink">150 <? echo $RAIN_SEASONS[$lang_idx];?><?=get_arrow()?></a></li>
				<li><a href="<? echo get_query_edited_url($url_cur, 'section', 'browsedate.php');?>" class="hlink"><? echo $ARCHIVE[$lang_idx];?><?=get_arrow()?></a></li>
				<li><a href="<? echo get_query_edited_url($url_cur, 'section', 'reports.php');?>" class="hlink"><? echo $REPORTS[$lang_idx];?><?=get_arrow()?></a></li>
				<li><a href="<? echo get_query_edited_url($url_cur, 'section', 'snow.php');?>" class="hlink"><? echo $SNOW_JER[$lang_idx];?><?=get_arrow()?></a></li>
				<li><a href="<? echo get_query_edited_url($url_cur, 'section', 'climate.php');?>" title="<? echo $CLIMATE_TITLE[$lang_idx];?>" class="hlink"><? echo $CLIMATE[$lang_idx];?><?=get_arrow()?></a></li>
           </ul>
     </li>
	 <li class="il_image"><a href="javascript:void(0)" ><? echo $WHAT_ELSE[$lang_idx];?>&nbsp;&#9660;</a>
            <ul>
				<? if ($boolbroken) {?>
						<li class="">
							<div id="brokenlatesttemp"></div>
							<div id="brokenlatesthumidity"></div>
							<div id="brokenlatestpressure"></div>
							<div id="brokenlatestwind"></div>
							<div id="brokenlatestrainrate" ></div>
						</li>
				<? } ?>
				<?
					for ($i = 0; $i < count($sig); $i++) {
					
					echo "<li>";
					echo "<a class=\"hlink\" style=\"font-weight:normal\" title=\"\" href=\"{$sig[$i]['url']}\" >{$sig[$i]['sig'][$lang_idx]} "." - ".$sig[$i]['extrainfo'][$lang_idx].get_arrow()."</a></li>\n";          
				} ?>
				<li>										
						<? if (!$error_db){ $licount = $licount + 1;?>
						<a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph&amp;graph=RainHistory.gif&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>" title="<? echo $TILL_NOW[$lang_idx].": ".$seasonTillNow->get_rain()." ; ".$NORMAL[$lang_idx]." ".$TILL_NOW[$lang_idx].": ".$averageTillNow->get_rain();?>">
						    <? if ($daysWithoutRain >= 4){ echo $daysWithoutRain." ".$DAYS_WITHOUT_RAIN[$lang_idx]." - "; } ?>  
							<? echo $THERE_IS[$lang_idx]." <span>";
							 if ($seasonTillNow->get_raindiffav() > 0) echo $LEFTOVER[$lang_idx]; else echo $LACK[$lang_idx];
							 echo " ".round(abs($seasonTillNow->get_raindiffav()))." ".$RAIN_UNIT[$lang_idx]."</span>"; ?><?=get_arrow()?>
						</a>
						<? } ?>
				</li>
			   <li id="airqli">
						<span id="airqtitle">
							<a href="<?=$airq_link?>" rel="external"><? echo $AIR_QUALITY[$lang_idx]; ?><?=get_arrow()?></a>
						</span>
						<!-- <div id="airqstorage" style="display:none;"> 
						</div>
						<span id="airqtitle">
							<a href="javascript:void(0)" onclick="accessByDOM('<?=$airq_path?>');"><? echo $AIR_QUALITY[$lang_idx]; ?></a>
						</span>
						<a href="<?=$airq_link?>" rel="external">
							<span id="airqdisplayed"></span>
							<span id="dustitle"><? echo $DUST[$lang_idx]; ?>?</span>
							<span id="dustdisplayed"></span>
						</a> -->

				</li>
				<? 
					if (($lowtemp_diffFromAv > 3) && ($hightemp_diffFromAv > 3) && (!isRaining()))
					{											
						$res = getRadioData();
						if ($res)
						{ ?>
						<li style="width:160px">
								<a class="hlink" href="http://en.wikipedia.org/wiki/Haines_Index" target="_blank">
										<?echo $FIRE_INDEX[$lang_idx];?>
										<?SortIndex ("", $FireIdx."", 4 , 5 , 6 , true, true);?>
								</a>

						</li>
						<? }
					}
					?>
               <li>
				<a class="hlink" href="<? echo get_query_edited_url($url_cur, 'section', 'openclosewindow.php');?>" title="<? echo $INSIDE[$lang_idx].": ".$current->get_intemp()." ; ".$OUTSIDE[$lang_idx].": ".$current->get_temp();?>">
					<? echo $YOU_BETTER[$lang_idx]." <span>";
					 echo isOpenOrClose();
						 echo " </span>".$THE_WINDOW[$lang_idx];?><?=get_arrow()?>
					</a>
				</li>
				<li>
					<a class="hlink" href="<? echo get_query_edited_url(get_url(), 'section', 'radiosonde.php');?>" title="<?echo $STORM_POWER[$lang_idx];?>">
						<? echo $CURRENT_ENERGY[$lang_idx];?><?=get_arrow()?>
					</a>
				</li>
				<li><a class="hlink" href="http://www.svivaaqm.net/DynamicTable.aspx?G_ID=14" title="Additional stations in Jerusalem עוד תחנות בי-ם" rel='external' >
											 <?  echo $STATIONS_NEARBY[$lang_idx]; ?><?=get_arrow()?></a>
				</li>
				<li><a class="hlink" href="http://www.wunderground.com/stationmaps/gmap.asp?zip=00000&amp;wmo=40184" title="Nearby stations עוד תחנות באזור" rel='external' >
					<?  echo $WEATHER_NEARBY[$lang_idx]; ?><?=get_arrow()?></a>
				</li>
				<!-- Global Warming -->
										
										<li >
											<a class="hlink" href="<? echo get_query_edited_url(get_url(), 'section', 'globalwarm.php');?>" onmouseover="toggle('globalwarmanomaly')" onmouseout="toggle('globalwarmanomaly')"><? echo $GLOBAL_WARMING[$lang_idx]; ?>:<span dir="ltr">
												<?	
													if (!isset($_SESSION['gw'])){
														global $link;
														$result = db_init("SELECT avg(anomaly) FROM globalwarming");
														$row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
														$gw =  number_format($row['avg(anomaly)'], 2, '.', '');
														$_SESSION['gw'] = $gw;
														@mysqli_free_result($result);
														//Closing connection 
														@mysqli_close($link);
 
													}
													else
														$gw = $_SESSION['gw'];
													$gw_plus_minus = $gw >= 0 ? "+" : "";
													echo $gw_plus_minus.$gw;
												?><? echo $current->get_tempunit(); ?>
												</span><?=get_arrow()?></a>
											</li>
										
										<!-- End Global Warming -->
				<li>
					<a class="hlink" onmouseover="toggle('cloudbasetimes')" onmouseout="toggle('cloudbasetimes')" href="#">
						<?=$CLOUD_BASE[$lang_idx]?>: <? echo $current->get_cloudbase()." ".$METERS[$lang_idx];?>
					</a>
					<ul style="display:none;padding:0em;" id="cloudbasetimes">
						<li>
							<table>
								<tr class="inv">
									<td <?  if (isHeb()) echo "dir=\"rtl\"" ?>>15 <?=$MINTS[$lang_idx]?></td>
									<td <?  if (isHeb()) echo "dir=\"rtl\"" ?>>30 <?=$MINTS[$lang_idx]?></td>
									<td <?  if (isHeb()) echo "dir=\"rtl\"" ?>><?=$HOUR[$lang_idx]?></td>
								</tr>
								<tr class="inv">
									<td><? echo get_img_tag($min15->get_cloudbasechange()).abs(round($min15->get_cloudbasechange()));?></td>
									<td><? echo get_img_tag($min30->get_cloudbasechange()).abs(round($min30->get_cloudbasechange()));?></td>
									<td><? echo get_img_tag($oneHour->get_cloudbasechange()).abs(round($oneHour->get_cloudbasechange()));?></td>
								</tr>
							</table>
						</li>
					</ul>
				</li> 
           </ul>
     </li>
	</ul>
</div>

<a id="start"></a>

<?
if ($current->get_tempunit() == '&#176;C') $tu='C'; else $tu= 'F';
?>
<!-- 
*****
*****
parameters bar
*****
*****
-->
<div id="mobileredirect" style="width:<?= $site_width ?>;display:none;height:110px" class="base big">
<div class="float">&nbsp;
<a href="small.php?size=l<?echo "&amp;lang=".$lang_idx;?>">
<img src="images/qrcode.png" width="100" height="100" alt="02ws for smartphone" />
<? echo $CELL_VIEW[$lang_idx].", ".$IPHONE[$lang_idx];?><?=get_arrow()?><?=get_arrow()?>
</a>&nbsp;
</div>
<div class="float">&nbsp;&nbsp;
<a href="small.php?size=l<?echo "&amp;lang=".$lang_idx;?>">
<img src="images/qrcode.png" width="100" height="100" alt="02ws for smartphone" />
<? echo $CELL_VIEW[$lang_idx].", ".$IPHONE[$lang_idx];?><?=get_arrow()?><?=get_arrow()?>
</a>&nbsp;
</div>
<div class="float">&nbsp;&nbsp;
<a href="small.php?size=l<?echo "&amp;lang=".$lang_idx;?>">
<img src="images/qrcode.png" width="100" height="100" alt="02ws for smartphone" />
<? echo $CELL_VIEW[$lang_idx].", ".$IPHONE[$lang_idx];?><?=get_arrow()?><?=get_arrow()?>
</a>&nbsp;
</div>
<!-- <div class="invfloat">&nbsp;
<a href="small.php?size=l<?echo "&amp;lang=".$lang_idx;?>">
<? echo $CELL_VIEW[$lang_idx].", ".$IPHONE[$lang_idx];?><?=get_arrow()?>
</a>&nbsp;
</div> -->
<br />
</div>
<a id="parameters"></a>
<div id="top_table" style="width:<?= $site_width ?>;display:none">
	
	<div id="paramsdiv">    
	<table id="paramstable" >    
	<tbody >
	<tr>		
	<td id="latesttemp" class="inv_plain_3_zebra">
			<div id="temptable" class="inparamdiv">
				<div class="paramtitle big">
				 					
					<a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=temp.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>&amp;style=<?=$_GET["style"]?>" title="" class="info">
						<? echo $NOW[$lang_idx];?> 
					</a>
				</div>
				<div style="width:60%;margin:0 auto">
								
					<a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=temp.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>&amp;style=<?=$_GET["style"]?>"  class="info">
						<span class="high">
							<? echo $current->get_temp();?><? echo $current->get_tempunit(); ?>
						</span>
						<span class="info" >
							<span><? echo $HIGH[$lang_idx].": "; ?></span>
							<span class="high"><? echo toLeft($today->get_hightemp().$current->get_tempunit()); ?></span>&nbsp;<? echo $ON[$lang_idx]." ".$today->get_hightemp_time()." "; ?>
							<br/><br/>
							<span><? echo $LOW[$lang_idx].": "; ?></span>
							<span class="low"><? echo toLeft($today->get_lowtemp().$current->get_tempunit()); ?></span>&nbsp;<? echo $ON[$lang_idx]." ".$today->get_lowtemp_time()." "; ?>
						</span> 
						<? echo get_img_tag($min15->get_tempchange());?>
							  <span class="info" style="top:-33px">
								<? echo getLastUpdateMin()." ".($MINTS[$lang_idx]).": ".get_param_tag($min15->get_tempchange()).$current->get_tempunit(); ?>
							</span>  
					</a>
					
				</div>
				
				
			</div>
		
	</td>        
	<td id="latesthumidity" class="inv_plain_3_zebra" title="">
		<div class="inparamdiv" <? if (isHeb()) echo "dir=\"rtl\" ";?>>
			<div class="paramtitle slogan">
				<a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=humwind.php&amp;level=1&amp;freq=2&amp;datasource=downld02&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>&amp;style=<?=$_GET["style"]?>" title=""><? echo $HUMIDITY[$lang_idx];?></a>
			</div>
			<div dir="ltr" style="width:60%;margin:0 auto">
				<a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=humwind.php&amp;level=1&amp;freq=2&amp;datasource=downld02&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;tempunit=<?=$tu?>&amp;style=<?=$_GET["style"]?>"  class="info"><? echo $current->get_hum();?>%&nbsp;
				<span class="info">

					<span><? echo $HIGH[$lang_idx].": "; ?></span>
					<span><? echo $today->get_highhum(); ?>%&nbsp;<? echo $ON[$lang_idx]." ".$today->get_highhum_time()." "; ?></span>
					<br/><br/>
					<span><? echo $LOW[$lang_idx].": "; ?></span>
					<span><? echo $today->get_lowhum(); ?>%&nbsp;<? echo $ON[$lang_idx]." ".$today->get_lowhum_time()." "; ?></span>
				
				</span>
				<? echo get_img_tag($min15->get_humchange());?>
				   <span class="info" style="top:-40px">
						<? echo getLastUpdateMin()." ".($MINTS[$lang_idx]).": ".get_img_tag($min15->get_humchange()).abs($min15->get_humchange())."%"; ?>
					</span>
				</a>
				
			</div>
		</div>
	</td>        
	<td id="latestpressure" class="inv_plain_3_zebra" title="">
		<div class="inparamdiv" <? if (isHeb()) echo "dir=\"rtl\" ";?>>
			<div class="paramtitle slogan">
				<a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=baro.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>"><? echo $BAR[$lang_idx];?></a>
			</div>
			<div id="pressure_value">
				<a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=baro.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>" class="info">
				<? echo $current->get_pressure()." ".$BAR_UNIT[$lang_idx];?>
				<span class="info">
				
					<span><? echo $HIGH[$lang_idx].":"; ?></span>
					<span><? echo $today->get_highbar()." ".$BAR_UNIT[$lang_idx]; ?>&nbsp;<? echo $ON[$lang_idx]." ".$today->get_highbar_time()." "; ?></span>
					<br/><br/>
					<span><? echo $LOW[$lang_idx].":"; ?></span>&nbsp;
					<span><? echo $today->get_lowbar()." ".$BAR_UNIT[$lang_idx]; ?>&nbsp;<? echo $ON[$lang_idx]." ".$today->get_lowbar_time()." "; ?></span>
				
				</span>
				<? echo get_img_tag($min15->get_prschange());?>
					<span class="info" style="top:-40px"><? echo getLastUpdateMin()." ".($MINTS[$lang_idx]).": ".get_param_tag($min15->get_prschange()).$BAR_UNIT[$lang_idx]; ?></span>
				</a>
				
			</div>
		</div>
	</td>
	<td id="latestwind" class="inv_plain_3_zebra" title="">
		<div class="inparamdiv">
			<div class="paramtitle slogan">
				<a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=wind.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;style=<?=$_GET["style"]?>" title="" >
						<? echo $WIND[$lang_idx];?>
				</a>
			</div>
			<div id="windvalue">
				<div  id="windspeed">
					<a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=wind.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;style=<?=$_GET["style"]?>" >
					<span style="font-size:95%" <? if (isHeb()) echo "dir=\"rtl\""; ?>><? echo $current->get_windspd()." ".$KNOTS[$lang_idx];?></span>
					<!-- <span class="info" <? if (isHeb()) echo "dir=\"rtl\""; ?> style="left:-0.5em"><? echo $HIGH[$lang_idx].": ".$today->get_highwind()." ".$KNOTS[$lang_idx]." ".$ON[$lang_idx]." "." ".$today->get_highwind_time(); ?></span> -->
					</a>
				</div>
				<!-- <div id="windtrend">
					<a href="#" class="info">
					<? echo get_img_tag($min15->get_windspdchange());?>
					<span class="info" <? if (isHeb()) echo "dir=\"rtl\""; ?>><? echo getLastUpdateMin()." ".($MINTS[$lang_idx]).": ".get_param_tag($min15->get_windspdchange()).$windUnits; ?></span>
					</a>
				</div> -->
				<div id="winddir">
					<a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=winddir.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;style=<?=$_GET["style"]?>"   title="<? echo $WIND_DIR[$lang_idx];?>">
					<?if (($current->get_winddir() != "---")&&($current->get_winddir() != "")){?>
					   <img src="images/winddir/wr-<? echo $current->get_winddir(); ?>.png" alt="<? echo $current->get_winddir(); ?>" width="28" height="28" />
					  <?}?>
					</a>
				</div>
			</div>
		</div>
	</td>		
	<td id="latestrain" class="inv_plain_3_zebra" title=""  >
		<div class="inparamdiv" <? if (isHeb()) echo "dir=\"rtl\" ";?> title="<? echo $RAIN_RATE[$lang_idx]; ?>">
			<div class="paramtitle slogan">
				<a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=RainRateHistory.gif&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;style=<?=$_GET["style"]?>" title="">
					<? echo $RAIN_RATE[$lang_idx];?>
				</a>
			</div>
			<div id="rainratevalue">
				<a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=rain.php&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;style=<?=$_GET["style"]?>" class="info"  title="">
					<? echo $current->get_rainrate()." ".$RAINRATE_UNIT[$lang_idx];?>
					<span class="info">
						<? echo $MAX[$lang_idx]." ".$RAINRATE[$lang_idx].": ".$today->get_highrainrate()." ".$RAINRATE_UNIT[$lang_idx]; ?>&nbsp;<? echo $ON[$lang_idx]." "." ".$today->get_highrainrate_time(); ?>
					</span>
				</a> 
			</div>
		</div>
	</td>
	<td id="latestradiation" class="inv_plain_3_zebra" title="">
		<div class="inparamdiv" <? if (isHeb()) echo "dir=\"rtl\" ";?> title="<? echo $SUN[$lang_idx]; ?>">
			<div class="paramtitle slogan">
				<a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=SolarRadHistory.gif&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;style=<?=$_GET["style"]?>" title="">
					<? echo $RADIATION[$lang_idx];?>
				</a>
			</div>
			<div id="sunvalues">
				<a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=SolarRadHistory.gif&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;style=<?=$_GET["style"]?>" class="info"  title="">
					<? echo $current->get_solarradiation()." W/m2";?>
					<span class="info">
						
					</span>
				</a>
			</div>
		</div>
	</td>
	<td id="latestuv" class="inv_plain_3_zebra" title="">
		<div class="inparamdiv" <? if (isHeb()) echo "dir=\"rtl\" ";?> title="<? echo $SUN[$lang_idx]; ?>">
			<div class="paramtitle slogan">
				<a  href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=UVHistory.gif&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;style=<?=$_GET["style"]?>" title="">
					<? echo $UV[$lang_idx];?>
				</a>
			</div>
			<div id="uvvalues">
				<a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph.php&amp;graph=UVHistory.gif&amp;profile=<? echo $profile;?>&amp;lang=<? echo $lang_idx;?>&amp;style=<?=$_GET["style"]?>" class="info"  title="">
					<? echo $current->get_uv()." ";?>
					<span class="info">
						
					</span>
				</a> 
			</div>
		</div>
	</td>
	</tr>
	<tr style="display:none" id="trends" class="smalltbl">
	<td style="vertical-align:top" class="inv_plain_3_zebra" id="temptrends">
		<table>
			<tr class="trendstitles">
				<td  class="box">24 <? echo $HOURS[$lang_idx];?></td>
				<td  class="box"><? echo($HOUR[$lang_idx]);?></td>
				<td  class="box">30<? echo($MINTS[$lang_idx]);?></td>
			</tr>
			<tr class="trendsvalues"><td> <? echo get_param_tag($yestsametime->get_tempchange())."</td><td>".get_param_tag($oneHour->get_tempchange())."</td><td>".get_param_tag($min30->get_tempchange()); ?></td></tr>
		</table>
	</td>
	<td style="vertical-align:top" class="inv_plain_3_zebra" id="humtrends">
		<table>
			<tr class="trendstitles">
				<td class="box">24 <? echo $HOURS[$lang_idx];?></td>
				<td class="box"><? echo($HOUR[$lang_idx]);?></td>
				<td class="box">30<? echo($MINTS[$lang_idx]);?></td>
			</tr>
			<? echo "<tr class=\"trendsvalues\"><td>".get_img_tag($yestsametime->get_humchange()).abs($yestsametime->get_humchange())."</td><td>".get_img_tag($oneHour->get_humchange()).abs($oneHour->get_humchange())."</td><td>".get_img_tag($min30->get_humchange()).abs($min30->get_humchange())."</td></tr>"; ?>
		</table>
	</td>
	<td style="vertical-align:top" class="inv_plain_3_zebra" id="bartrends">
		<table>
			<tr class="trendstitles">
				<td class="box"><? echo($HOUR[$lang_idx]);?></td>
				<td class="box">30<? echo($MINTS[$lang_idx]);?></td>
				<td class="box"><? echo getLastUpdateMin().($MINTS[$lang_idx]);?></td>
			</tr>
			<? echo "<tr class=\"trendsvalues\"  ><td>".get_img_tag($oneHour->get_prschange()).abs($oneHour->get_prschange())."</td><td>".get_img_tag($min30->get_prschange()).abs($min30->get_prschange())."</td><td>".get_img_tag($min15->get_prschange()).abs($min15->get_prschange())."</td></tr>"; ?>
		</table>
	</td>
	<td style="vertical-align:top" class="inv_plain_3_zebra" id="windtrends" >
		 <table>
			<tr class="trendstitles">
				<td class="box"><? echo($HOUR[$lang_idx]);?></td>
				<td class="box">30<? echo($MINTS[$lang_idx]);?></td>
				<td class="box"><? echo getLastUpdateMin().($MINTS[$lang_idx]);?></td>
			</tr>
			<? echo "<tr class=\"trendsvalues\" ><td>".get_img_tag($oneHour->get_windspdchange()).abs($oneHour->get_windspdchange())."</td><td>".get_img_tag($min30->get_windspdchange()).abs($min30->get_windspdchange())."</td><td>".get_img_tag($min15->get_windspdchange()).abs($min15->get_windspdchange())."</td></tr>"; ?>
		</table>
	</td>
	<td style="vertical-align:top" id="raintrends"  class="inv_plain_3_zebra">
		<table id="rainrate15min">
			<tr class="trendstitles">
				<td class="box"><? echo($HOUR[$lang_idx]);?></td>
				<td class="box">30<? echo($MINTS[$lang_idx]);?></td>
				<td class="box"><? echo getLastUpdateMin().($MINTS[$lang_idx]);?></td>
			</tr>
			<tr class="trendsvalues">
				<td>
					<? echo get_img_tag($oneHour->get_rainratechange()).abs(round($oneHour->get_rainratechange())); ?>
				</td>
				<td>
					<? echo get_img_tag($min30->get_rainratechange()).abs(round($min30->get_rainratechange())); ?>
				</td>
				<td >
					<? echo get_img_tag($min15->get_rainratechange()).abs(round($min15->get_rainratechange())); ?>
					
                                </td>
			</tr>
		</table>
	</td>
	<td style="vertical-align:top" class="inv_plain_3_zebra" id="radiationtrends">
		 <table>
			<tr class="trendstitles">
				<td class="box">24 <? echo($HOURS[$lang_idx]);?></td>
				<td class="box">30<? echo($MINTS[$lang_idx]);?></td>
				<td class="box"><? echo getLastUpdateMin().($MINTS[$lang_idx]);?></td>
			</tr>
			<? echo "<tr class=\"trendsvalues\" ><td>".get_img_tag($yestsametime->get_srchange()).abs($yestsametime->get_srchange())."</td><td>".get_img_tag($min30->get_srchange()).abs($min30->get_srchange())."</td><td>".get_img_tag($min15->get_srchange()).abs($min15->get_srchange())."</td></tr>"; ?>
		</table>
	</td>
	<td style="vertical-align:top" class="inv_plain_3_zebra" id="uvtrends">
		 <table>
			<tr class="trendstitles">
				<td class="box">24 <? echo($HOURS[$lang_idx]);?></td>
				<td class="box">30<? echo($MINTS[$lang_idx]);?></td>
				<td class="box"><? echo getLastUpdateMin().($MINTS[$lang_idx]);?></td>
			</tr>
			<? echo "<tr class=\"trendsvalues\" ><td>".get_img_tag($yestsametime->get_uvchange()).abs($yestsametime->get_uvchange())."</td><td>".get_img_tag($min30->get_uvchange()).abs($min30->get_uvchange())."</td><td>".get_img_tag($min15->get_uvchange()).abs($min15->get_uvchange())."</td></tr>"; ?>
			
		</table>
	</td>
	</tr>
	<!-- diffFromYest -->
	<tr id="diffFromYest" style="display:none;">
			<td title="<? echo($CHANGE[$lang_idx]);?> <? echo($TEMP[$lang_idx]);?> " class="inv_plain_3_zebra">
				<fieldset style="width:85%;height:80px">
					<legend>
						<a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph&amp;graph=OutsideTempHistory.gif&amp;profile=<? echo $profile;?>" title="show graph"  >
							<? echo($DIFF_FROM[$lang_idx])." ".($YESTERDAY[$lang_idx])." ".$yestsametime->get_time();?> 
						</a>
					</legend>
					<? echo($HIGH[$lang_idx]);?>&nbsp;
					<a href="#" title="<? echo($TODAY[$lang_idx]);?> <? echo $today->get_hightemp().$current->get_tempunit();?> - <? echo($YESTERDAY[$lang_idx]);?> <?echo $yest->get_hightemp().$current->get_tempunit();?>">
						<? echo get_param_tag($today->get_hightemp() - $yest->get_hightemp()).$current->get_tempunit();?>
						
					</a>
					<br/>
					<? echo($LOW[$lang_idx]);?>&nbsp;
					<a href="#" title="<? echo($TODAY[$lang_idx]);?> <? echo $today->get_lowtemp(),$current->get_tempunit();?> - <? echo $YESTERDAY[$lang_idx]." ".$yest->get_lowtemp(),$current->get_tempunit();?> ">
						<? echo get_param_tag($today->get_lowtemp() - $yest->get_lowtemp()).$current->get_tempunit();?>
						
					</a>
				</fieldset>
			</td>
			<td title="<? echo($CHANGE[$lang_idx]);?> <? echo($HUMIDITY[$lang_idx]);?> " style="vertical-align:middle" class="inv_plain_3_zebra">
				<fieldset style="width:85%;height:80px">
					<legend>
						<a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph&amp;graph=OutsideHumidityHistory.gif&amp;profile=<? echo $profile;?>">
							<? echo($DIFF_FROM[$lang_idx])." ".($YESTERDAY[$lang_idx])." ".$yestsametime->get_time();?> 
						</a>
					</legend>
					<? echo (get_img_tag($yestsametime->get_humchange())),abs($yestsametime->get_humchange()),"%"; ?>
					<!--<table width=100%>
					<tr class="toptbl">
						<td colspan="3" class=small>Humidity</td>
					</tr>
					<tr class="tbl">
						<td width=50% title="Max hum till now compared to yesterday's Max Hum" >Max Hum</td>
						<td width=50%>
						<a href="" class=info>
							<?php if(($today->get_highhum() - $yest->get_highhum()) > 0)
								echo("+");
							echo ($today->get_highhum() - $yest->get_highhum()),"%";?>
						</a>
						</td>
					</tr>
					<tr class="tbl">
						<td title="Low Hum till now compared to yesterday's low Hum">Low Hum</td>
						<td>
						<a href="" class=info>
							<?php if (($today->get_lowhum() - $yest->get_lowhum()) > 0)
								echo("+");
							echo ($today->get_lowhum() - $yest->get_lowhum()),"%";?>
					   </a>
						</td>
					</tr>
					 </table>-->
				</fieldset>
			</td>
			<td title="<? echo($CHANGE[$lang_idx]);?> <? echo($BAR[$lang_idx]);?> " style="vertical-align:middle" class="inv_plain_3_zebra">
				<fieldset style="width:85%;height:80px">
					<legend>
						<a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph&amp;graph=BarometerHistory.gif&amp;profile=<? echo $profile;?>" >
							<? echo($DIFF_FROM[$lang_idx])." ".($YESTERDAY[$lang_idx])." ".$yestsametime->get_time();?> 
						</a>
					</legend>
					<? echo (get_img_tag($yestsametime->get_prschange()))."&nbsp;",abs($yestsametime->get_prschange()),"mb"?>
				</fieldset>
			</td>
			<td title="<? echo($CHANGE[$lang_idx]);?> <? echo($WIND[$lang_idx]);?> " style="vertical-align:middle" class="inv_plain_3_zebra">
				<fieldset style="width:85%;height:80px">
					<legend>
						<a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph&amp;graph=WindSpeedHistory.gif&amp;profile=<? echo $profile;?>"  >
							<? echo($DIFF_FROM[$lang_idx])." ".($YESTERDAY[$lang_idx])." ".$yestsametime->get_time();?>  
						</a> 
					</legend>
					<? echo (get_img_tag($yestsametime->get_windspdchange())),abs($yestsametime->get_windspdchange()),"Kt";?>
					<br />
					<img src="images/winddir/wr-<? echo $yestsametime->get_winddir(); ?>.png" alt="<? echo $current->get_winddir(); ?>" width="28" height="28" />&nbsp;<?=get_arrow()?>&nbsp;<img src="images/winddir/wr-<? echo $current->get_winddir(); ?>.png" alt="<? echo $current->get_winddir(); ?>" width="28" height="28" />
					
				</fieldset>
			 
			</td>
			<td class="inv_plain_3_zebra">
				
			</td>
			
			<td class="inv_plain_3_zebra">
                            <fieldset style="width:85%;height:80px">
					<legend>
						<a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph&amp;graph=WindSpeedHistory.gif&amp;profile=<? echo $profile;?>" >
							<? echo($DIFF_FROM[$lang_idx])." ".($YESTERDAY[$lang_idx])." ".$yestsametime->get_time();?>  
						</a> 
					</legend>
				
					
					
				</fieldset>
			</td>
			<td class="inv_plain_3_zebra">
                            <fieldset style="width:85%;height:80px">
					<legend>
						<a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=graph&amp;graph=WindSpeedHistory.gif&amp;profile=<? echo $profile;?>" >
							<? echo($DIFF_FROM[$lang_idx])." ".($YESTERDAY[$lang_idx])." ".$yestsametime->get_time();?>  
						</a> 
					</legend>
					
					
				</fieldset>
			</td>
		</tr>
	<!-- End diffFromYest -->
	
	</tbody>
	</table>
	<div id="closetrends">
	<a class="float" href="#" title="<? echo($DIFF_FROM[$lang_idx])." ".($YESTERDAY[$lang_idx])." ".$yestsametime->get_time();?>" onclick="toggle('diffFromYest');">
		<div class='spriteB plus'></div>
	</a>
	<a class="float" href="#" title="<?=$CLOSE[$lang_idx]?>" onclick="toggle('trends');toggle('top_table');toggle('tempdiv_moreinfo');">
		<div class='sprite stop1'></div>
	</a>
	</div>
	</div>
	<!-- end paramsdiv -->
	<!-- SATELLITE -->
	<div id="satelliteLink" class="inv_plain_3_zebra inparamdiv">
		<!--<div style="height:70%;" ></div>-->
		<div >
			<a href="http://www.sat24.com/en/is?ir=true" title="<? echo  $SATELLITE[$lang_idx];?>" rel="external">		
				<? echo  $SATELLITE[$lang_idx];?>
			</a>
		</div>
	</div> 
	<!-- END SATELLITE -->
	<!-- radar -->
	<? $radar_gif = ""; ?>
	<div id="radarTab" class="inv_plain_3_zebra inparamdiv" >
		<div>
			<a href="<? echo get_query_edited_url($url_cur, 'section', 'radar.php');?>">
				<? echo $RAIN_RADAR[$lang_idx];?>
			</a>
		</div>
	</div>
	<!-- end radar -->
</div> <!-- END top_table -->

<div id="waiting" class="topbase" <? if (isHeb()) echo "dir=\"rtl\""; ?> style="display:none;">
<? if (isHeb()) echo "טוען..."; else echo "Loading...";?>&nbsp;
<img src="images/loading.gif" alt="loading" width="32" height="32"/>
</div>


<!-- 
*****
*****
main table
*****
*****
-->
<a id="maintable"></a>

<div style="width:<?= $site_width ?>" id="main_table" class="inv_plain_3">
<div id="EmailDelivering" class="big"></div>
<?    if ($error_update==true) {
echo "{$error_desc}</div>";
?>
<div class="base" id="error_update">
<a href="http://www.wunderground.com/weatherstation/WXDailyHistory.asp?ID=IJERUSAL1" rel='external' title='my station at weather underground'>
	<img id="imageWU" height="160px" width="160px" alt="my station at weather underground (graphs, archive and live update)" src="http://banners.wunderground.com/cgi-bin/banner/ban/wxBanner?bannertype=wxstnsticker_both&weatherstationcount=IJERUSAL1"/>
</a><br /><br />
<div class="inv_plain">
<a href="http://www.findu.com/cgi-bin/wxpage.cgi?call=CW0641&amp;units=metric" rel='external' title='alternative site'>אתר חלופי לנתוני ירושמיים</a>
</div>
</div>
<?
   
}  

$height = 1000;
$width = "100%";
if ((first_page())&&(!$error_update))                      
	include "hometable.php";    
else { ?>
	<div id="tohome" class="invfloat topbase"><a href="<? echo BASE_URL.substr(strrchr($_SERVER["PHP_SELF"], "/"), 0)."?lang=".$lang_idx;?>"  title="<? echo $HOME_PAGE[$lang_idx];?>" class="hlink">
						<? echo $HOME_PAGE[$lang_idx];?>
	</a></div>
<? 
	if  (!stristr($template_routing, 'jpg'))
		echo "<div id=\"imagedisplay\"><a href=\"\" onclick=\"tpopup('print.php?".$QUERY_STRING."')\"><img src=\"images/print.gif\" alt=\"".$PRINT[$lang_idx]."\"/></a></div>";
	$include = true; 
         /* prevent Url injection  */
        if (stristr($template_routing, 'http'))
             $url = "BLOCKED FOR INCLUSION";
	else if  (stristr($template_routing, 'htm')||stristr($template_routing, 'php'))           
		$url = $template_routing;
  
	else if  (stristr(strtolower($template_routing), 'cam'))           
		$url = "webcam.php";
	else if  ((stristr($template_routing, 'jpg'))||(stristr($template_routing, 'gif')))            
		$url = "pic.php";
	else if  ($template_routing == "graph")            
		$url = "graph.php";         
	else if ($template_routing == "radiosonde")
	{
		$height = 800;
		$url = getRadioSondeLink(); 
		$include = false;
	}
	else if  ($template_routing == "metar")            
		$url = "http://weather.noaa.gov/pub/data/observations/metar/decoded/LLJR.TXT";
	else if  ((stristr($template_routing, 'txt'))||(stristr($template_routing, 'TXT')))	{
		if (stristr ($template_routing, $year))
			$template_routing  = "reports/NOAAYR.TXT";
		$url = $template_routing; 
		echo "<div align=\"left\" class=\"report\"><pre>";
	}
	else if ($template_routing == "chooseMonthYear") {         
		$url = "chooseHeader.php";
		$include = true;
	}
	else if ($template_routing == "Taf"){            
		$url = $taf_decoded; 
		$height = 800; 
		$include = false;
	}
	else if  ($template_routing == "radar"){
	   $url = $radar_link;
	   $height = 600;
	   $include = false;
	}        
	else if ($template_routing == "pics"){            
		$url = "images/spgm-1.3.2/index.php";  
		$include = false;
	}        
	else if ($template_routing == "animation"){            
		$url = $animation_link;            
		$include = false;
		$height = 480;
	}
	else if ($template_routing == "nearby"){            
		$url = "http://www.wunderground.com/stationmaps/gmap.asp?zip=00000&amp;wmo=40184&amp;lang=".$lang_idx;            
		$include = false;

	}
	else if ($template_routing == "dust"){            
		$url = "http://forecast.uoa.gr/LINKS/DUST/dload/anim.html";            
		$include = false;
	}
	else {            
		$url = $template_routing;             
		$include = false;
	}
	if ($_GET['height'] != "") 
		$height = $_GET['height']; 
	if ($_GET['width'] != "") 
		$width = $_GET['width'];
	if ($include)             
		include("{$url}");        
	else              
		//echo "<p>".get_file_string($url)."</p>";              
		echo "<iframe src=\"{$url}\" scrolling=\"auto\" id=\"iframemain\" class=\"base\" allowtransparency=\"true\" marginHeight=\"0\" marginWidth=\"0\" width=\"{$width}\" height=\"{$height}\" frameborder=\"0\" ></iframe>\n</td>"; 
	
} 
	if  ((stristr($template_routing, 'txt'))||(stristr($template_routing, 'TXT')))
		echo "</pre></div>";
	if ($template_routing == "nearby"){            
		//set units to metric
		/*echo "<script language=\"JavaScript\" type=\"text/javascript\"image";
		echo "document.getElementById('iframe').location.href='http://www.wunderground.com/cgi-bin/findweather/getForecast?setunits=metric';";
		echo "</script>";*/
	}
	?>
</div>

<!-- 
*****
*****
below table bar
*****
*****
-->


<!-- 
*****
*****
bottom bar - sitemap
*****
*****
-->

<div style="width:<?= $site_width ?>" id="footermenu">
	
		
	<div class="inv_plain_3 unitfootermenu" id="footergraphsmenu">
		<ul class="list">
			<li class="big"><? echo $MY[$lang_idx];?></li>
			<li >
				<a href="javascript: void(0)" class="register" title="<?=$REGISTER[$lang_idx]?>"><? echo $GET_UPDATES[$lang_idx]; ?></a>
			</li>
			<li id="change_style"> 
			<select size="1" id="styleSwithcer"  onchange="changeStyle(this.options[this.selectedIndex].value)">  
				<option     value="" <?if (isStyleSubmited("")) echo "selected=\"selected\"";?>><? echo $CHANGE_STYLE[$lang_idx];?></option>
				<option     value="" >רגיל</option>
				<option     value="2" <?if (isStyleSubmited("2")) echo "selected=\"selected\"";?>>bright 2</option>
				<option     value="3" <?if (isStyleSubmited("3")) echo "selected=\"selected\"";?>>dark 3</option>
				<option     value="4" <?if (isStyleSubmited("4")) echo "selected=\"selected\"";?>>bright 4</option>
				<option     value="5" <?if (isStyleSubmited("5")) echo "selected=\"selected\"";?>>green 5</option>
				<option     value="6" <?if (isStyleSubmited("6")) echo "selected=\"selected\"";?>>red 6</option>
				<option     value="7" <?if (isStyleSubmited("7")) echo "selected=\"selected\"";?>>blue 7</option>
				<option     value="8" <?if (isStyleSubmited("8")) echo "selected=\"selected\"";?>>pastel 8</option>
				<option     value="9" <?if (isStyleSubmited("9")) echo "selected=\"selected\"";?>>ground 9</option>
			</select>        
			</li>
			<li >
					<img src="http://www.manwithoutfear.com/rss.png" alt="RSS" height="14" width="36"/>
					<ul>
						<li><a href="rss.php<?echo "?lang=".$lang_idx;?>" class="right">RSS</a></li>
						<li><a href="rss_forecast.php<?echo "?lang=".$lang_idx;?>" class="right"><? echo $FORECAST_TITLE[$lang_idx];?></a></li>
					</ul>
			</li>
                        <li><a href="small.php<?echo "?lang=".$lang_idx;?>" ><? echo $CELL_VIEW[$lang_idx];?></a> , <a href="small.php?size=l<?echo "&amp;lang=".$lang_idx;?>"><? echo $IPHONE[$lang_idx];?></a> , <a href="wap.php" ><? echo $WAP_VIEW[$lang_idx];?></a></li>
                        <li><img src="images/qrcode.png" width="100" height="100" alt="02ws for smartphone" /></li>
		</ul>
	</div>
	<div class="inv_plain_3 unitfootermenu" id="generalfootermenu">
		<ul class="list">
			<li class="big"><? echo $GENERAL[$lang_idx];?></li>
			<li>
				<a href="<? echo get_query_edited_url($url_cur, 'section', 'faq.php');?>"  title="<?=$FAQ[$lang_idx]?>"><? echo $FAQ[$lang_idx];?></a>
			</li>
			<li><a href="<? echo get_query_edited_url($url_cur, 'section', 'contact.php');?>" class="hlink" title="<? echo $CONTACT_INFO[$lang_idx];?>"><? echo $CONTACT_INFO[$lang_idx];?></a></li>
			<li><a href="<? echo get_query_edited_url($url_cur, 'section', 'SendFeedback.php');?>" class="hlink" title="<? echo $CONTACT_ME[$lang_idx];?>"><? echo $CONTACT_ME[$lang_idx];?></a></li>
			<li><a href="spgm-1.3.2/index.php"  title="<?=$ALBUM_DESC[$lang_idx]?>"><? echo $PICTURES[$lang_idx];?></a></li>
			<li><a href="JWSBanner.html" class="hlink"><? echo $BANNER_FLASH_VIEW[$lang_idx];?></a></li>
			<li><a href="<? echo get_query_edited_url($url_cur, 'section', 'songs.php');?>" title="<? echo $SONGS[$lang_idx];?>" class="hlink"><? echo $SONGS[$lang_idx];?></a></li>
			<? if (isHeb()) { ?>
			<li><a href="<? echo get_query_edited_url($url_cur, 'section', 'poetry.php');?>" title="חמשירים" class="hlink">חמשירי שלג ועוד</a></li>
			<? }?>
			<li><a href="<? echo get_query_edited_url($url_cur, 'section', 'weatherclips.php');?>" title="<? echo $WEATHER_CLIPS[$lang_idx];?>" class="hlink"><? echo $WEATHER_CLIPS[$lang_idx];?></a></li>
			<li><a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=models.php&amp;model=&amp;hours=24&amp;lang=<? echo $lang_idx;?>" class="hlink"><? echo $MODELS[$lang_idx];?></a></li>
			<li><a href="<? echo get_query_edited_url($url_cur, 'section', 'lightning.php');?>" class="hlink"><? echo $LIGHTS[$lang_idx];?></a></li>
			<li><a href="<? echo get_query_edited_url($url_cur, 'section', 'radiosonde.php');?>" class="hlink"><? echo $RADIOSONDE[$lang_idx];?></a></li>
			<li><a href="http://www.kineret.org.il/main.asp" class="hlink" rel="external"><? echo $KINNERET[$lang_idx];?></a></li>
		</ul>
	</div>
	<div class="float inv_plain_3 unitfootermenu" id="footergooglead">
		<script type="text/javascript"><!--
		google_ad_client = "pub-2706630587106567";
		/* 336x280, created 10/24/10 */
		google_ad_slot = "6973088336";
		google_ad_width = 336;
		google_ad_height = 280;
		google_color_border = ["<?= $forground->bg['+4'] ?>"];
		google_color_bg = ["<?= $forground->bg['+4'] ?>"];
		google_color_link = ["<?= $forground->bg['-9'] ?>"];
		google_color_url = ["<?= $forground->bg['-9'] ?>"];
		google_color_text = ["<?= $forground->bg['-9'] ?>"];
		//--></script>
		<script type="text/javascript"
		  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
		</script>
	</div>
	<div class="inv_plain_3 unitfootermenu" id="footerlinksmenu">
	
			<ul class="list">
				<li class="big"><? echo $LINKS[$lang_idx];?></li>
				<li><a href="http://www.jlm.israel.net/home/" title='מה יש היום בירושלים' rel='external'>מה יש היום בירושלים</a></li>
				<li><a href="http://www.jerusalemtour.co.il" title='Jerusalem Tour סיורים בירושלים' rel='external'>סיורים בירושלים Jerusalem Tour</a></li>
				<li><a href="http://www.tiulim-israel.com/103641/tour-jerusalem" title='Jerusalem Tour ארגון והדרכת סיורים בירושלים' rel='external'>טיולים בירושלים</a></li>
				<li><a href="http://hair2.co.il" title="מרכז האפילציה" rel='external'>הסרת שיער לצמיתות</a></li>
				<li><a href="http://www.seotop.co.il" title="קידום אתרים" rel='external'>קידום אתרים</a></li>
				<li><a href="http://israelweather.co.il" title="Israel Weather" rel='external'>Israel Weather</a></li>
			</ul>
			<div id="webringdesc">
					<div>
						<a href="http://F.webring.com/go?ring=davisvantageprow&amp;id=33&amp;random" target="_blank">
						<? if (isHeb()) echo "תחנות נוספות מרחבי הגלובוס"; else echo "More stations worldwide:"; ?>
						</a>
					</div>
					<div>
					<a href="http://F.webring.com/go?ring=davisvantageprow&amp;id=33&amp;prev" target="_blank">&lt;&lt;</a> |
					<a href="http://www.webring.com/t/Davis-Vantage-Pro-Weather-Station-Ring?sid=33" target="_blank">Hub</a> |
					<a href="http://www.webring.org/hub?ring=davisvantageprow;sid=33;sid=33" target="_blank">Sites</a> |
					<a href="http://F.webring.com/go?ring=davisvantageprow&amp;id=33&amp;next" target="_blank">&gt;&gt;</a> 
					</div>
			</div>
			
			
    </div>
	
	
</div>

<input type="hidden" id="current_feeling" value="<?=$current_feeling?>"/>

<!--[if (gte IE 5.5)&(lt IE 8)]>	
	<div class="topbase" id="topmessage"><div class="high">Please update you browser. The site does not support internet explorer 6 and 7.<br /><br />אנא עדכן את הדפדפן<a href="http://www.mozilla.com"><img border="0" alt="Firefox 3" title="Firefox 3" src="http://sfx-images.mozilla.org/affiliates/Buttons/firefox3/120x240.png" /></a>
	<a href="http://www.google.com/chrome/"><img src="http://www.techdigest.tv/assets_c/2009/02/google-chrome-logo-thumb-300x300-75857.jpg" alt="Chrome" width="150px"></a>
	<a href="#" title="close" onclick="toggle('topmessage')"><div class='sprite stop1'></div></a></div></div></div>
	<script type="text/javascript">
	show('topmessage', 'main_table', 'main_table', 0, 0);
	</script>
<![endif]-->
<? if ($mySite) { ?>
	
	<div class="spacer">
	<pre>
	<? if (isHeb()) { ?>
		<? echo getPageTitle()?>
	<? } else { ?>
	This site intended to give the feeling of what is happening outside.
	The data is from a station standing out there - at the cold fronts and the heat waves.
	You can search in the archive for weather history or to ow when there was a very extensive weather (hot or  cold).
	<? }?>
	</pre>
	</div>
	<!-- Start of StatCounter Code -->
	<script type="text/javascript">
	var sc_project=548696; 
	var sc_invisible=1; 
	var sc_security="";
	(function() {
	  var st = document.createElement('script'); st.type = 'text/javascript'; st.async = true;
	  st.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://') + 'www.statcounter.com/counter/counter_xhtml.js';
	  var s = document.getElementsByTagName('script')[1]; s.parentNode.insertBefore(st, s);
	})();
	</script>
	<!-- End of StatCounter Code -->
	

<? } ?>
<!-- 
*****
*****
client scripting
*****
*****
-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"  type="text/javascript"></script>
<script src="jquery.cycle.all.min.js"  type="text/javascript"></script>
<script src="jquery.colorbox.js"  type="text/javascript"></script>
<script src="footerScripts.min.js"  type="text/javascript"></script>
<script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=boazn"></script>
<script type="text/javascript">

function changeLang (lang)
{
	var loc = '<? echo get_url();?>';
	changeUrlLang(lang, loc);
}
</script>

<? 
if ($_GET['section'] == "") {
	
	/******** generating message to Email *********/
	
	$messageToSend = "{$messageAction}";
	
	for ($i=0 ; $i < count($messageBrokenToSend) ; $i++)
	{
		$messageToSend .= $messageBrokenToSend[$i][$HEB];
	}

	if 	(count($EmailSubject) == 0)
		$EmailSubject = array("02ws Update Service", "שירות עדכון ירושמיים");

	if ($messageToSend !== "") 
	{
		$messageToSend = str_replace("\"", "'", $messageToSend);
		send_Email($messageToSend, ALL, EMAIL_ADDRESS, $EmailSubject[$HEB], "");
		?>
		
		<!-- <script type="text/javascript" src="ajaxEmail.js"></script>
		<script type="text/javascript">
			// startEmailService(message_from, message_subject, message_body, target , info_back)
			var messageBody = escape(encodeURI("<?=$messageToSend?>"));
			var message_action = escape(encodeURI("<?=$actionActive?>"));
			<? echo "startEmailService(escape(encodeURI('".EMAIL_ADDRESS."')) , escape(encodeURI('02ws Update Service')) , messageBody , 'ALL' , false, message_action);"; ?>
		</script> -->
		
	<? }
	
	/****** End generating message to Email ********/
	?>	
	
<? } @mysqli_close($link);?>


<? 
	if (stristr($template_routing, 'models'))
	{
		
	?>
	<script type="text/javascript">
		activateMenu('modelsnav');
		top.location.href="#maintable";
	</script>
<? } ?>
<script type="text/javascript">
/* <![CDATA[ */
	mj = mjd(<? echo $day;?>, <? echo $month;?>, <? echo $year;?>, 0.0);
	var mrs = find_moonrise_set(mj, <?=GMT_TZ?>, 35.2, 31.7);
	var div_moon = document.getElementById('moonriseset_values');
	if (div_moon != null)
		div_moon.innerHTML = mrs;
		
	function fillForecastTemp(jsonstr)
	{
		var foreacastTempDetails = document.getElementById('tempForecastDiv');
		 if (foreacastTempDetails.firstChild) {
		   foreacastTempDetails.removeChild(foreacastTempDetails.firstChild);
		 }
                 try{
                     
                     var jsonT = JSON.parse( jsonstr  );
                     $(".timefh").each(function(index) {
                           // alert(index + ': ' + $(this).text());
                            var requestedtime = $("#timeSwithcer").val() + ":00";
                            for (i = 0 ; i < jsonT.forecasthours.length; i++)
                             {
                                 //alert("from json: " + jsonT.forecasthours[i].time);
                                  if (jsonT.forecasthours[i].time ==  $(this).text())
                                      $(this).next().html(jsonT.forecasthours[i].temp);
                                  if (jsonT.forecasthours[i].time == requestedtime) 
                                    foreacastTempDetails.innerHTML = jsonT.forecasthours[i].temp;    
                             }
                      });
                     
                 }
                 catch (e) {
                     //alert(e);
                     foreacastTempDetails.innerHTML = jsonstr;
                  }
                 
		 
	}
	function getTempForecast(time, div_id)
	{	
		fillForecastTemp("<?=$LOADING[$lang_idx]?>", div_id);
		var ajax = new Ajax();
		var postData = decodeURI('date=<?=$yestsametime->get_date()?>&amp;time=' + time + '&amp;tempDiff=<?=$yestsametime->get_tempchange()?>');
		ajax.method = 'POST';
                ajax.setMimeType('text/xml');
		postData = postData.replace(/\&amp;/g,'&');
		ajax.postData = postData;
		ajax.url = 'forecast/getAllTempForecast.php';
		ajax.setHandlerBoth(fillForecastTemp);
                
		ajax.doReq();

		/*$.ajax({
		 type: "POST",url: "forecast/getAllTempForecast.php",
		 data: { "date":<?=$yestsametime->get_date()?>,
                  "time": time , "tempDiff":<?=$yestsametime->get_tempchange()?>  },
		 complete: function(){ }, //manage the complete if needed
		 success: fillForecastTemp//get some data back to the screen if needed
		});*/
		
	}

	function getdAirqDisplay (airq_value)
	{
		//alert (airq_value);
		var title;
		var index;
		if (airq_value >  50)
		   {
			  index = "indexlow";
			   title = "<?=$LOW[$lang_idx]?>";
		   }
		   else if (airq_value >  0)
		   {
			   index = "indexmedium";
			    title = "<?=$MEDIUM[$lang_idx]?>";
		   }
		   else if (airq_value >  -200)
		   {
			   index = "indexhigh";
			    title = "<?=$HIGH[$lang_idx]?>";
		   }
		   else 
		   {
			   index = "indexextreme";
			    title = "<?=$EXTREME[$lang_idx]?>";
		   }
		  
		return "<span class='" + index + "'>" + title + "</span>" ;
	}

	function fillAirqValue (str)
	{
		 var responseHTML = document.getElementById("airqstorage");
         var y = document.getElementById("airqdisplayed");
		 var d = document.getElementById("dustdisplayed");
		 responseHTML.innerHTML = getBody(str);
		 var airq_value = responseHTML.getElementById('lblIndexValue').innerHTML; 
		 //var dust_value = responseHTML.getElementsByTagName('span').item(4).innerHTML;
		 y.innerHTML = getdAirqDisplay(airq_value);
		 //d.innerHTML = dust_value + " µg/m3 ";
	}

        function build850data(str)
        {
            var responseHTML = getBody(str);
        }
	 function loadHTML(url, fun)
	{
		 var y = document.getElementById("airqdisplayed");
		 y.innerHTML = "<?=$LOADING[$lang_idx]?>...";
		 var ajax = new Ajax();
		 ajax.setMimeType('text/xml');
		 ajax.doGet(url, fun);
		

	}

	 function accessByDOM(url)
	 {
		 loadHTML(url, fillAirqValue);
	 }
         function load850Data(url)
         {
             loadHTML(url, build850data);
         }

	function getMessageService(filter, start, update)
	{	
		
		var name = document.getElementById('name').innerHTML;
		var body = document.getElementById('body').value;
		var mood_img = document.getElementById('mood_img');
		var mood_elm = "";
		if ((mood_img != null)&&(mood_img != 'undfined')) 
		{
			mood_elm = "<div class=\"" + mood_img.className + "\" title=\"" + mood_img.title + "\" ></div>";
		}
		
		var searchname = document.getElementById('searchname');
		if (searchname != null)
			searchname = searchname.value;
			else
				 searchname = '';
		
		if ((filter == '') && 
			((searchname == '') || (searchname == null)) && 
			((name == '' ||  body == '' || body == '<?=$BODY[$lang_idx]?>' || name == '<?=$NAME[$lang_idx]?>')))
		{
			return false;
		}
		
		var idx = "";
                var msgDetails = document.getElementById('msgDetails');
		var idxs = msgDetails.getElementsByTagName("input"); 
		for (var i = 0; i < idxs.length; i++) { 
			if (idxs[i].type=="checkbox")  
				if (idxs[i].checked) { 
					idx = idxs[i].value; 
				}
		}
		var limit = "<?=$limitLines?>";
		if ((filter != "") && (filter != "undefined"))
			limit = filter;
		if (update == 0)
		{
			body = '';
			name = '';
		}
		
		restoreTopDiv();
		
		var postData = "lang=" + "<?=$lang_idx?>" + "&limit=" + limit + "&startLine=" + start + "&name=" + escape(encodeURI(name)) + "&searchname=" + escape(encodeURI(searchname)) + "&body=" + escape(encodeURI(body)) + "&mood=" + escape(encodeURI(mood_elm)) + "&idx=" + idx + "&update=<?=$_GET['update']?>";
		fillMessage('<img src="images/loading.gif" alt="loading" />');
		$('input[name="SendButton"]').attr("disabled", "disabled");
		var ajax = new Ajax();
		ajax.method = 'POST';
		ajax.setMimeType('text/html');
		ajax.postData = postData;
		ajax.setHandlerBoth(fillMessage);
		ajax.url = 'chat_service.php';
		ajax.doReq();
		
	}

       
        function startup(page)
        {
        	if (document.getElementById('chatWrapper'))
		{
                        $.ajax({
			  type: "GET",
			  url: "checkauth.php?action=getuser&lang=<?=$lang_idx?>"
			}).done(function( jsonstr ) {
			  try{
	                     
	                     var jsonT = JSON.parse( jsonstr  );
	                     if (!jsonT.user.loggedin)
	                         {
	                            toggle('notloggedin');
	                            if (jsonT.user.locked)
	                                alert('<?=$USER_LOCKED[$lang_idx]?>');
	                         }
	                       else {
	                         toggle('loggedin'); 
	                         fillUserDetails (jsonstr );
	                       }
	                       if (page > 0)
				{
					getMessageService(<?=$limitLines?>, <?echo ($p*$numberofPages*$limitLines);?>, 0);
				}
				else
				{
	                                fillMessage('<img src="images/loading.gif" alt="loading" />');
					var ajax = new Ajax();
					ajax.method = 'POST';
					ajax.setMimeType('text/html');
					ajax.setHandlerBoth(fillMessage);
					ajax.postData = "lang=" + "<?=$lang_idx?>" + "&limit=" + "<?=$limitLines?>" + "&update=<?=$_GET['update']?>";
					ajax.url = 'chat_service.php';
					ajax.doReq();
				}
		                                                           
		                 }
		                 catch (e) {
		                     alert("error:" + e);
		                     
		                  }
			});
			attachEnter();
			
		}
           
            
        }
	function onLoad(page)
	{
		var cur_feel_link=document.getElementById('current_feeling_link');
		if (cur_feel_link)
		{
			var ajax = new Ajax();
			ajax.setHandlerBoth(fillcoldmeter);
			ajax.url = 'coldmeter_service.php?lang=<?=$lang_idx?>';
			ajax.doReq();
		}
		 startup(page);
		
	}
	function fillcoldmeter(str)
	{
		var cur_feel_link=document.getElementById('current_feeling_link');
		var tickText=document.createElement('text');
		tickText.innerHTML=str;
		cur_feel_link.replaceChild(tickText,cur_feel_link.firstChild);
		var gendertype=document.getElementById('gendertype');

		if (gendertype)
		{
			var gendercookie = getCookie('gender');
			var gender_m = '<?=$MALE[$lang_idx]?>';
			var gender_f = '<?=$FEMALE[$lang_idx]?>';
			var gender_none = '<?=$NOR_MALE_NOR_FEMALE[$lang_idx]?>';
			var gendertodisplay = '';
			if (gendercookie == 'm')
				gendertodisplay = gender_m;
			else if (gendercookie == 'f')
				gendertodisplay = gender_f;
			else
				gendertodisplay = gender_none;
			var tickText=document.createElement('text');
			tickText.innerHTML=gendertodisplay;
			//gendertype.replaceChild(tickText,gendertype.firstChild);
			gendertype.innerHTML=gendertodisplay;
		}
	}
	function changeStyle(style){
		toggle('waiting');
		var loc = "<? echo get_url();?>";
		loc = loc.replace(/style=<?=$_GET['style']?>/g, "style=" + style);
		if (loc.indexOf("?") == -1)
		{
			loc = loc + "?";
		}
		if (loc.indexOf("style") == -1)
		{
				loc = loc + "&style=" + style; 
		}
		top.location.href=loc;
	}
	onLoad(<?=$p?>);
                <? 	if ($template_routing == "graph.php") { ?>
	toggle('top_table');toggle('tempdiv_moreinfo');toggle('trends');
	<? } ?>
/* ]]> */
</script>	
</body>
</html>
<? if ($_GET['debug'] == '') include "end_caching.php"; ?>