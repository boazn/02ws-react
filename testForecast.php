<?
//error_reporting(E_ERROR | E_PARSE);
//ini_set("error_reporting", E_ALL);
include_once ("requiredDBTasks.php");

	function rainExistsInTaf ($forecast_title, $priority)
	{
		global $FROM, $TO, $RAIN_WILL_STOP, $lang_idx;
		$rainStoppedExists = false;
		for ($i = 0; $i < count($forecast_title); $i++) {
			if (stristr ($forecast_title[$i], $RAIN_WILL_STOP[$lang_idx]))
				$rainStoppedExists = true;
		}

		if ((FromExistsInTaf($forecast_title)) && ($priority > 60) && (!$rainStoppedExists)) {
			return true;
		}
		return false;
	}

	function FromExistsInTaf ($forecast_title)
	{
		global $FROM, $TO, $RAIN_WILL_STOP, $lang_idx;
		
		for ($i = 0; $i < count($forecast_title); $i++) {
			if (stristr ($forecast_title[$i], $FROM[$lang_idx]) && stristr ($forecast_title[$i], $TO[$lang_idx]))
				return true;
		}
		return false;
	}

	function isTom ($timetaf, $timeFromTo)
	{
		global $TOMORROW, $lang_idx;
		if ($timeFromTo < $timetaf)
			return $TOMORROW[$lang_idx]." ";
		else
			return "";
	}

	if ($_GET["debug"] >= 1)
	echo "<br/><b>Stared forecast section.....";
	if ($_GET["debug"] >= 3)
		echo "<br/></b>";

	if ($taf_contents == ""){
		if ((!file_exists($taf_file))||(((time() - filemtime($taf_file)) > 3600)))
		{
			$ftp = ftp_connect('tgftp.nws.noaa.gov');
			@ftp_login($ftp, 'anonymous', 'password');
			@ftp_get($ftp, $taf_file, $taf_server_file, FTP_ASCII);
			@ftp_close($ftp);
		}
		$taf_contents = @file_get_contents($taf_file);
		$_SESSION['taf_contents'] = $taf_contents;
	}
	
	$source = $taf_contents;
	$forecast_title = array();
	$generally="";
	
	$taf_pic = "";
	$priority = 0;

	$taf_contents = strtok($taf_contents, " \n\t");
	
	while (getNextWord($taf_contents, 1))
	{
		if (stristr ($taf_contents, ":")) {
			$timetaf = (int)$taf_contents;
			$timetaf = $timetaf + 2;
			//array_push($forecast_title, "<span class=\"small\">".$GENERALLY[$lang_idx]." "."</span>");
		}
		if (stristr ($taf_contents, "PROB")) {
			$isProb = true;
		}
		if (stristr ($taf_contents, "RASN")) {
			
			$currentPri = 100;
			if ($priority < $currentPri)
				 $taf_pic = "rainSnow.gif";
			
			array_push($forecast_title, "$RAIN[$lang_idx] $SNOW[$lang_idx]");
			$priority = $currentPri;
		}
		else if (stristr ($taf_contents, "SN"))     {
			$currentPri = 95;
			if ($priority != $currentPri){
				
				array_push($forecast_title,  $SNOW[$lang_idx]);
			}
			if ($priority < $currentPri){
				 $taf_pic = "snow.gif";
				$priority = $currentPri;
			}
		}
		if ((stristr ($taf_contents, "GR"))||
			 (stristr ($taf_contents, "GS")))        {
			 $currentPri = 90;
			 if ($priority != $currentPri){
				 
				 array_push($forecast_title, $HAIL[$lang_idx]);
			 }
			 if ($priority < $currentPri){
				 $taf_pic = "rainSHB.gif";
				 $priority = $currentPri;
			 }
		}
		if (stristr ($taf_contents, "TSRA"))   {
			$currentPri = 85;
			if ($priority != $currentPri){
				
				array_push($forecast_title,  $THUNDERSTORM[$lang_idx]);
			}
			if ($priority < $currentPri){
				 $taf_pic = "rainTS.gif";
				 $priority = $currentPri;
			}
		}
		else if (stristr ($taf_contents, "TS"))   {
			$currentPri = 80;
			if ($priority != $currentPri){
				
				array_push($forecast_title,  $THUNDERSTORM[$lang_idx]);
			}
			if ($priority < $currentPri){
				 $taf_pic = "TS.gif";
				$priority = $currentPri;
			}
		}
		else if ((stristr ($taf_contents, "-SHRA"))||
			(stristr ($taf_contents, "-RA"))){
			
			$currentPri = 75;
			if ($priority != $currentPri){
				
				array_push($forecast_title, $LIGHT_RAIN[$lang_idx]);
			}
			if ($priority < $currentPri){
				$taf_pic = "lightrain.gif";
				$priority = $currentPri;
			}
		}
		else if (stristr ($taf_contents, "RA"))    {

			$currentPri = 78;
			if ($priority != $currentPri){
				
				array_push($forecast_title, $RAIN[$lang_idx]);
			}
			if ($priority < $currentPri){
				$taf_pic = "rain.gif";
				$priority = $currentPri;
			}
		}
		if (stristr ($taf_contents, "DZ")){
			$currentPri = 68;
			if ($priority != $currentPri){
				
				array_push($forecast_title, "$DRIZZLE[$lang_idx]");
			}
			if ($priority < $currentPri){
				$taf_pic = "lightrain.gif";
				$priority = $currentPri;
			}
		}
		if (stristr ($taf_contents, "CB"))   {
			$currentPri = 62;
			if ($priority != $currentPri){
				
				array_push($forecast_title,  $SEVERE_CLOUDS[$lang_idx]);
			}
			if ($priority < $currentPri){
				$taf_pic = "TCu.gif";
				$priority = $currentPri;
			}
		}
		if (stristr ($taf_contents, "TEMPO"))    {
			$timerange = getNextWord($tok, 1);
			// daylight saving = + 2; regular = + 1
			$startTime = substr($timerange, 0, 2) + 2 + $shift_forecast_time;
			$startTime = ($startTime >= 24 ? $startTime - 24 : $startTime);
			$endTime = substr($timerange, 2, 2) + 2 + $shift_forecast_time;
			$endTime = ($endTime >= 24 ? $endTime - 24 : $endTime);
			// need to delete irrelavent lines
			// delete the last lines 
			if ((stristr ($forecast_title[sizeof($forecast_title) - 1], $TO[$lang_idx]))&&
				(stristr ($forecast_title[sizeof($forecast_title) - 1], $FROM[$lang_idx])))
			{
				$removed = array_pop($forecast_title); // tempo becmg
				if ($_GET["debug"] >= 3)
					"removed ".$removed."<br/>";
				
			}
			//array_push($forecast_title,  "<br style=\"line-height:1px\"/>");

			$tempotime =  "<strong>";
			if (substr($timerange, 0, 2) < 24)
				$tempotime .= $FROM[$lang_idx].$HOUR[$lang_idx]." ".$startTime." ".isTom($timetaf, $startTime).$TO[$lang_idx]." ".$endTime.": ";
			else
				$tempotime .= $TEMPO[$lang_idx].":";
			$tempotime .= "</strong>";

			array_push($forecast_title, $tempotime);
			if ($isProb)
			{
				array_push($forecast_title, "$PROB[$lang_idx] ");
				$isProb = false;
			}
		}
		if (stristr ($taf_contents, "BECMG"))    {
			$timerange = getNextWord($tok, 1);
			$startTime = substr($timerange, 0, 2) + 2 + $shift_forecast_time;
			$startTime = ($startTime >= 24 ? $startTime - 24 : $startTime);
			$endTime = substr($timerange, 2, 2) + 2 + $shift_forecast_time;
			$endTime = ($endTime >= 24 ? $endTime - 24 : $endTime);
			// need to delete irrelavent lines without any weather
			// delete the last lines 
			if ((stristr ($forecast_title[sizeof($forecast_title) - 1], $TO[$lang_idx]))&&
				(stristr ($forecast_title[sizeof($forecast_title) - 1], $FROM[$lang_idx])))
			{
				$removed = array_pop($forecast_title); // tempo becmg
				if ($_GET["debug"] >= 3)
					echo "removed ".$removed."<br/>";
				
			}
			//array_push($forecast_title,  "<br style=\"line-height:1px\"/>");
			$tempotime =  "<strong>".$BECMG[$lang_idx]." ";
			if ($startTime < 24)
				$tempotime .= $FROM[$lang_idx].$HOUR[$lang_idx]." ".$startTime." ".isTom($timetaf, $startTime).$TO[$lang_idx]." ".$endTime." ".$BECMG_TO[$lang_idx];
			$tempotime .= "</strong>";
			array_push($forecast_title, $tempotime);
			if ($isProb)
			{
				array_push($forecast_title, "$PROB[$lang_idx]");
				$isProb = false;
			}
		}
		

		if ((stristr ($taf_contents, "FG")))     {
			
			$currentPri = 60;
			if ($priority != $currentPri){
				
				array_push($forecast_title, $FOG[$lang_idx]);
			}
			if ($priority < $currentPri){
				$taf_pic = "fog.gif";
				$priority = $currentPri;
			}
		}
		if (stristr ($taf_contents, "SA")) {
			$currentPri = 55;
			
			if ($priority != $currentPri){
				
				array_push($forecast_title, $SANDSTORM[$lang_idx]);
			}
			if ($priority < $currentPri){
				 $taf_pic = "sand.gif";
				 $priority = $currentPri;
			}
			
			
		}
		if (stristr ($taf_contents, "DU")) {
			$currentPri = 50;
			
			if ($priority != $currentPri){
				
				array_push($forecast_title,  $DUST[$lang_idx]);
			}
			if ($priority < $currentPri){
				$taf_pic = "dust.gif";
				$priority = $currentPri;
			}
		}
		if (stristr ($taf_contents, "TCU"))   {
			$currentPri = 48;

			if ($priority != $currentPri){
				
				array_push($forecast_title, $SEVERE_CLOUDS[$lang_idx]);
			}
			if ($priority < $currentPri){
				 $taf_pic = "TCu.jpg";
				 $priority = $currentPri;
			}
			
		}
		if (stristr ($taf_contents, "BKN"))   {
			$currentPri = 40;
			if (rainExistsInTaf ($forecast_title, $priority)) 
				array_push($forecast_title, $RAIN_WILL_STOP[$lang_idx]);
			if ($priority != $currentPri){
			    
				if ((stristr ($forecast_title[sizeof($forecast_title) - 1], $TO[$lang_idx]))&&
				(stristr ($forecast_title[sizeof($forecast_title) - 1], $FROM[$lang_idx])))
					array_push($forecast_title, $MORE_CLOUDS[$lang_idx]);
				else
					array_push($forecast_title, "$MOSTLY[$lang_idx] $CLOUDY[$lang_idx]");
				 // need to delete less important PC lines
				 if (($forecast_title[sizeof($forecast_title) - 1] == $FEW_CLOUDS[$lang_idx])||
					 ($forecast_title[sizeof($forecast_title) - 1] == "$PARTLY[$lang_idx] $CLOUDY[$lang_idx]"))
					array_pop($forecast_title);
				if ($priority < $currentPri)
				{
					$priority = $currentPri;
					$taf_pic = "PC.gif";
				}
			}
		}
		if (stristr ($taf_contents, "SCT"))  {
			$currentPri = 35;
			if (rainExistsInTaf ($forecast_title, $priority)) 
				array_push($forecast_title, $RAIN_WILL_STOP[$lang_idx]);
				
			if ($priority != $currentPri){
				 // need to delete less important PC lines
				 if ($forecast_title[sizeof($forecast_title) - 1] == $FEW_CLOUDS[$lang_idx])
					array_pop($forecast_title);
				 
				 array_push($forecast_title, "$PARTLY[$lang_idx] $CLOUDY[$lang_idx]");
				 if ($priority < $currentPri)
				 {
					$priority = $currentPri;
					$taf_pic = "PC.gif";
				 }
				
			}
    	}
		if (stristr ($taf_contents, "FEW"))  {
			$currentPri = 25;
			if (rainExistsInTaf ($forecast_title, $priority)) 
				array_push($forecast_title, $RAIN_WILL_STOP[$lang_idx]);
				
			if ($priority != $currentPri){
				 
				 array_push($forecast_title, $FEW_CLOUDS[$lang_idx]);
				 if ($priority < $currentPri)
				 {
					$priority = $currentPri;
					$taf_pic = "fewTzirus.gif";
				 }
			}
		}
		if (stristr ($taf_contents, "CAVOK")) {
			
			$currentPri = 20;
			if (rainExistsInTaf ($forecast_title, $priority)) 
				array_push($forecast_title, $RAIN_WILL_STOP[$lang_idx]);
			// need to put it anyway becasue of the case when the sky becomes clear
			if ($priority != $currentPri){
				array_push($forecast_title, "$MOSTLY[$lang_idx] $CLEAR[$lang_idx]");
			}
			if ($priority < $currentPri){
				 $taf_pic = "fare.gif";
				 $priority = $currentPri;
			}
		}
		if (stristr ($taf_contents, "NSC"))  {
			
			$currentPri = 18;
			if (rainExistsInTaf ($forecast_title, $priority)) 
				array_push($forecast_title, $RAIN_WILL_STOP[$lang_idx]);
				
			// need to put it anyway becasue of the case when the sky becomes clear
			if ($priority != $currentPri){
				array_push($forecast_title, "$MOSTLY[$lang_idx] $CLEAR[$lang_idx]");
			}
			if ($priority < $currentPri){
				 $taf_pic = "fare.gif";
				 $priority = $currentPri;
			}
		}
		if (stristr ($taf_contents, "SKC"))  {
			
			$currentPri = 15;
			if (rainExistsInTaf ($forecast_title, $priority)) 
				array_push($forecast_title, $RAIN_WILL_STOP[$lang_idx]);
				
			// need to put it anyway becasue of the case when the sky becomes clear
			if ($priority != $currentPri){
				
				array_push($forecast_title,  $CLEAR[$lang_idx]);
			}
			if ($priority < $currentPri){
				$taf_pic = "fare.gif";
				$priority = $currentPri;
			}
			
			
		}
//		if (stristr ($taf_contents, "HZ"))  {
//			
//			$currentPri = 10;
//			if ($priority != $currentPri){
//				
//				array_push($forecast_title, $HAZE[$lang_idx]);
//			}
//			if ($priority < $currentPri){
//				$taf_pic = "haze.gif";
//				$priority = $currentPri;
//			}
//		}
		if ((stristr ($taf_contents, "FU"))) {
			
			$currentPri = 8;
			if ($priority != $currentPri){
				
				array_push($forecast_title,  $FOG[$lang_idx]);
			}
			if ($priority < $currentPri){
				$taf_pic = "mist.gif";
				$priority = $currentPri;
			}
			
			
		}
		if ((stristr ($taf_contents, "BR"))) {
			
			$currentPri = 5;
			if ($priority != $currentPri){
				
				array_push($forecast_title,  $FOG[$lang_idx]);
			}
			if ($priority < $currentPri){
				$taf_pic = "mist.gif";
				$priority = $currentPri;
			}
		}
		if ($_GET["debug"] >= 3)
		{
			echo "currentPri=".$currentPri." priority=".$priority." taf_pic=".$taf_pic." count=".count($forecast_title)." last=".$forecast_title[sizeof($forecast_title) - 1]."<br/>";
		}

	}

	// remove tempo or becmg if remaining last
	if (stristr ($forecast_title[sizeof($forecast_title) - 1], $TO[$lang_idx]))
	{
		$removed = array_pop($forecast_title); // tempo becmg
		if ($_GET["debug"] >= 3)
			echo "removed the last line: ".$removed."<br/>";
		
	}
	if (count($forecast_title) == 0)
	{
		$taf_pic = "fare.gif";
		$forecast_title = array_push($forecast_title,  $CLEAR[$lang_idx]);
		if ($_GET["debug"] >= 3)
		{
			echo "currentPri=".$currentPri." priority=".$priority." taf_pic=".$taf_pic." count=".count($forecast_title)." last=".$forecast_title[sizeof($forecast_title) - 1]."<br/>";
		}
	}
	if ($_GET["debug"] >= 3)
	{
		echo "number of items in forecast: ".count($forecast_title)."<br/>";
		for ($i = 0; $i < count($forecast_title); $i++) {
			echo $forecast_title[$i];
		}
	}	
	//$IMSforecast = get_file_string("http://www.worldweather.org/013/c00043.htm");
	//$IMSforecast =  substr($IMSforecast, strrpos($IMSforecast, "Date"), 300);
	//echo $IMSforecast;
	if ($_GET["debug"] >= 3)
		echo "<br/><b>";
	if ($_GET["debug"] >= 1)
		echo "finished</b>";
?>
<div style="clear:both;width:100%;padding:0.8em 0 0.8em 0;" <? if (isHeb()) echo "dir=\"rtl\""; ?> class="bg2">					
		<div style="clear:both;width:50%;float:<?echo get_s_align();?>;margin:1%;padding:0em 0.5em 0em 0.5em;" <? if (isHeb()) echo "dir=\"rtl\""; ?> class="bg2">
				
				<div style="clear:both;float:<?echo get_s_align();?>;padding:0.3em 0.6em 0.1em 0.3em;width:35%;"  id="for_title">
					<div style="text-align:<?echo get_s_align();?>;" class="big">
						<a href="<? echo get_query_edited_url(get_url(), 'section', 'forecast.php');?>" title="<? echo($FORECAST_TITLE[$lang_idx]." ".$FOR[$lang_idx]." 24 ".$HOURS[$lang_idx]);?>">
							<? echo($FORECAST_TITLE[$lang_idx]);?>&nbsp;
						</a>
					</div>
					<img src="images/icons/day/<?echo $taf_pic;?>" height="60" width="75" alt="<? echo($FORECAST_TITLE[$lang_idx]." ".$FOR[$lang_idx]." 24 ".$HOURS[$lang_idx]);?>" />
					<br/>
					<? echo($FORECAST_TITLE[$lang_idx]." ".$FOR[$lang_idx]." 24 ".$HOURS[$lang_idx]);?><br/>
					<? echo $GIVEN[$lang_idx]." ".$AT[$lang_idx]."<em>{$timetaf}:00</em>";?><br/>
				</div>
				<div style="text-align:<?echo get_s_align();?>;float:<?echo get_s_align();?>;width:55%;height:100%;padding:1.2em 0em 0em 0em">
					
						<div id="tick" style="width:100%;height:80%">
						<a href="#" style="font-weight:normal">&nbsp;</a>
						<?
						$forcastTicker = "";
						for ($i = 0; $i < count($forecast_title); $i++) {
							$forcastTicker .= $forecast_title[$i];
							if ((stristr($forecast_title[$i], ":"))
								||(stristr($forecast_title[$i], $BECMG[$lang_idx]))
								||($i == count($forecast_title) - 1))
							{
								// do nothing
							}
							else if (($i < count($forecast_title) - 1) 
									  && ((stristr($forecast_title[$i+1], ":"))
									  || (stristr($forecast_title[$i+1], $BECMG[$lang_idx]))))
							{
								$forcastTicker .= "<br />";
							}
							else if ((!stristr($forecast_title[$i], "<br"))
								   &&(!stristr($forecast_title[$i], $PROB[$lang_idx])))
							{
								$forcastTicker .= ", ";
							}
							
						}
						$forcastTicker = str_replace("\"", "'", $forcastTicker);
						?>
						</div>
					<!-- <span class="info">
						<?echo $source;?>
					</span>  -->
						<div style="padding:2em 0em 0em 0em">
							<a href="" style="font-weight:normal">
							<? echo($FORECAST_TEMP[$lang_idx]); ?>
							</a>
							<select size="1" id="timeSwithcer" onchange="getTempForecast(this.options[this.selectedIndex].value)" style="font-size: 10px;">
								<? for ($i=0; $i < 24 ; $i++)
								   {
										$time = sprintf("%d:00", $i);
										echo "<option ";
										if ($i == $hour)
											echo "selected";
										echo " value=".$time.">".$time."</option>";
								   }
								?>
								
							</select>
							<a href="" style="font-weight:normal">
							?
							<span id="tempForecastDiv">
							</span>
							</a>
						</div>
				</div>
		</div>
		
			
		<div style="float:<?echo get_s_align();?>;width:45%;padding:0em 0.2em 0em 0.2em;text-align:center" <? if (isHeb()) echo "dir=\"rtl\""; ?> class="bg2" id="baseGraph">
			<div style="padding:0.3em 1.3em 0.1em 1.3em;" class="big" id="for_title">
				<div style="float:<?echo get_s_align();?>;text-align:<?echo get_s_align();?>;">
					<? echo($FORECAST_4D[$lang_idx]); ?>
				</div>
			</div>
			<div style="clear:both" <? if (isHeb()) echo "dir=\"rtl\""; ?> <? echo get_align(); ?> title="<? echo($FORECAST_4D[$lang_idx]); ?>" style="padding:0em 0.2em 0em 0.3em;">
				<table <? echo get_align(); ?> <? if (isHeb()) echo "dir=\"rtl\""; ?> style="border-spacing: 0" cellpadding="0" id="tableForecastNextDays">
				<tr style="height:5px">
				<td width="75px"></td>
				<td colspan="2" class="small" valign="bottom"><? echo $TEMP[$lang_idx];?></td>
				<td></td>
				<td></td>
				</tr>
				<? if  (count($forecastDaysDB) == 0) echo $frcstTable;
					else 
					{
						//print_r($forecastDaysDB);
						for ($i = 0; $i < count($forecastDaysDB); $i++) 
						{ ?>
						<tr>
						<td width="75px"><?echo replaceDays($forecastDaysDB[$i][5]." ")." ".$forecastDaysDB[$i][4];?></td>
						<td class="low"><?=$forecastDaysDB[$i][2]?></td>
						<td class="high"><?=$forecastDaysDB[$i][3]?></td>
						<td></td>
						<td><?=urldecode($forecastDaysDB[$i][$lang_idx])?></td>
						</tr>
						<? }
					}
				?>
				
				</table> 
			</div>
		</div>
</div>

<? if ($_GET['section'] == "forecast.php") {?>
<div style="clear:both;text-align:center;padding:0 2em 2em 2em" <? if (isHeb()) echo "dir=\"rtl\""; ?> class="bg2">
			<ul class="nav">
				<li <? if (isHeb()) echo "class=\"heb\""; ?> style="padding:0 1em 0 1em">
					<a class="hlink" href="<?=$_SERVER['SCRIPT_NAME'];?>?section=forecast/getForecast.php&amp;region=isr&amp;lang=<? echo $lang_idx;?>" title="Forecast for other places"
					style="font-weight:normal">
						<? echo($FORECAST_ISR[$lang_idx]); ?>
					</a>
				</li>
				<li <? if (isHeb()) echo "class=\"heb\""; ?> style="padding:0 1em 0 1em">
					<a href="<? echo get_query_edited_url(get_url(), 'section', 'dust.html');?>" title="<? echo($FORECAST_TITLE[$lang_idx]." ".$FOR[$lang_idx]." ".$DUST[$lang_idx]); ?>" class="hlink" style="font-weight:normal">
						<? echo($FORECAST_TITLE[$lang_idx]." ".$FOR[$lang_idx]." ".$DUST[$lang_idx]); ?>
					</a>
				</li>
				<li <? if (isHeb()) echo "class=\"heb\""; ?> style="border-<? if (isHeb()) echo "left"; else echo "right" ;?>:none;padding:0 1em 0 1em">
					<a class="hlink" href="<?=$_SERVER['SCRIPT_NAME'];?>?section=forecast/getForecast.php&amp;lang=<? echo $lang_idx;?>" title="Forecast for other places" style="font-weight:normal">
						<? echo($FORECAST_ABROD[$lang_idx]); ?>
					</a>
				</li>
				<!-- <li style="padding:0.2em">
					<a href="<? echo get_query_edited_url(get_url(), 'section', 'allTimeRecords.php'); ?>" class="hlink" title="Records archive ׳˜׳‘׳׳× ׳©׳™׳׳™׳"><? echo($RECORDS_LINK[$lang_idx]); ?></a>
				</li> -->
				
			</ul>
</div>
<div style="clear:both;padding:0.8em 0 0.8em 0;" <? if (isHeb()) echo "dir=\"rtl\""; ?> class="inv">
<?=$FORECAST_DESC[$lang_idx]?>
</div>
<? } ?>
<script language="javascript">
var arrNewsItems = new Array();
<? if  ($forecastlevel < 2){ ?>
arrNewsItems.push(new Array("<?=$forcastTicker?>", "<? echo get_query_edited_url(get_url(), 'section', 'Taf');?>"));
<? } ?>
<? if  ($detailedforecast != ""){ ?>
arrNewsItems.push(new Array("<? echo $detailedforecast[$lang_idx];?>", "<? echo get_query_edited_url(get_url(), 'section', 'forecast.php');?>"));
<? } ?>
<? if  (count($forecastDaysDB) > 0){ ?>
	var daysForecast = new Array();
	<? for ($i = 0; $i < count($forecastDaysDB); $i++) { ?>
		daysForecast[<?=$i?>] = new Array();
	     daysForecast[<?=$i?>] = ['<?=$forecastDaysDB[$i][$lang_idx]?>', '<?=$forecastDaysDB[$i][2]?>', '<?=$forecastDaysDB[$i][3]?>', '<?=$forecastDaysDB[$i][4]?>', '<?=$forecastDaysDB[$i][5]?>'];
	<? } ?>
	//updateForecastFromDB(daysForecast);
<? } ?>
function fillForecastTemp(str)
{
	var foreacastTempDetails = document.getElementById('tempForecastDiv');
	 if (foreacastTempDetails.firstChild) {
	   foreacastTempDetails.removeChild(foreacastTempDetails.firstChild);
	 }
	 foreacastTempDetails.innerHTML = str;
}
function getTempForecast(time, div_id)
{	
	fillForecastTemp('<img src="images/loading.gif" alt="loading" />', div_id);
	var ajax = new Ajax();
	ajax.setMimeType('text/xml');
	ajax.doGet('forecast/getTempForecast.php?date=<?=$yestsametime->get_date()?>&time=' + time + '&tempDiff=<?=$yestsametime->get_tempchange()?>', fillForecastTemp);
	
}
function updateForecastFromDB(days)
{
	var forecastTable = document.getElementById('tableForecastNextDays');
	var forecastDescriptions = forecastTable.getElementsByTagName('table');
	for (var i = 0; i < forecastDescriptions.length; i++) { 
		var trForecast = forecastDescriptions[i].lastChild.firstChild;
		var tdForecast = trForecast.getElementsByTagName('td')[0];
		var newF = new String();
		newF = unescape(decodeURI(days[i][0]));
		newF = newF.replace("+", " ");
		if (days[i] != "")
		{	
			tdForecast.innerHTML = newF;
		}
	}
}
function updateForecastFromDB(days)
{
}

function getBody(content)
{
 test = content.toLowerCase(); // to eliminate case sensitivity
 var x = test.indexOf("<body");
 if(x == -1) return "";

 x = test.indexOf(">", x);
 if(x == -1) return "";

 var y = test.lastIndexOf("</body>");
 if(y == -1) y = test.lastIndexOf("</html>");
 if(y == -1) y = content.length; // If no HTML then just grab everything till end

 return content.slice(x + 1, y);
}
 
</script>
<script language="javascript" src="textTicker.js"></script>