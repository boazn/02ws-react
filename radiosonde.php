<?
/////////////////////////////////////////////////////////////////////////////////////////////
	// radiosonde data
	/////////////////////////////////////////////////////////////////////////////////////////////
 
	function getRadioData()
	{
		global $t850, $t500, $t700, $inversionThickness, $baseInversionHeight, $inversionTemp, $FireIdx, $VerticalIdx, $CAPE, $CrossIdx, $Showalter, $KIdx, $LiftedIdx, $SWEATIdx, $TotalsIdx, $BulkRichNum;
		// *********** radio sonde calculation ***********
		if (!isset($_SESSION['radio_contents'])){
			$radio_contents = get_file_string(getRadioSondeLink());
			$_SESSION['radio_contents'] = $radio_contents;
		}
		else
			$radio_contents = $_SESSION['radio_contents'];
		if (strlen($radio_contents) < 3200){
			//if (($_GET['section'] == "extended") || (strstr (get_url(), "radio")))
			//echo "radiosonde: corrupted data";
			return false;
		}
		$radio_contents_tok = strtok($radio_contents, " \n\t");
		//echo $radio_contents;
		/*while (!($radio_contents_tok === FALSE)) {
		   echo "Word=$radio_contents_tok<br />";
		   $radio_contents_tok = strtok(" \n\t");
		}*/
		// ********** inversion calculation *************

		$found = searchDoubleNext ($radio_contents_tok, "1000.0", "999.0");//skipping ground inversion
		if ($found)
		{
			$nextHeight = getNextWord($radio_contents_tok, 1, "Height");
			$nextTemp = getNextWord($radio_contents_tok, 1, "Temp");
			$nextHum = getNextWord($radio_contents_tok, 2, "Hum");
			
			do {
				$baseHeight = $nextHeight;
				$baseTemp = $nextTemp;
				$baseHum = $nextHum;
				$nextPres = getNextWord($radio_contents_tok, 7, "Pres");//next level pres
				$nextHeight = getNextWord($radio_contents_tok, 1, "Height");//next level height
				$nextTemp = getNextWord($radio_contents_tok, 1, "Nextword");
				$nextDP = getNextWord($radio_contents_tok, 1, "Nextword");
				$nextHum = getNextWord($radio_contents_tok, 1, "Nextword");
				if ($nextPres == "850.0"){ 
					$t850 = $nextTemp;
					$dp850 = $nextDP;
				}
				if ($nextPres == "700.0") 
					$t700 = $nextTemp;
				if ($nextPres == "500.0") 
					$t500 = $nextTemp;
			} while ((($nextTemp <= $baseTemp)||false)&&($nextHeight < 5000)||($baseHeight<150));// checking that next level is with more hum and less temp
			$baseInversionHeight = $baseHeight;
			$baseInversionTemp = $baseTemp;
			$baseInversionHum = $baseHum;
			//echo "base inversion : ".$baseHeight." ".$baseTemp." ".$baseHum;
			do {
				$baseHeight = $nextHeight;
				$baseTemp = $nextTemp;
				$baseHum = $nextHum;
				$nextPres = getNextWord($radio_contents_tok, 7, "Pres");//next level pres
				$nextHeight = getNextWord($radio_contents_tok, 1, "Height");//next level height
				$nextTemp = getNextWord($radio_contents_tok, 1, "Nextword");
				$nextDP = getNextWord($radio_contents_tok, 1, "Nextword");
				$nextHum = getNextWord($radio_contents_tok, 1, "Nextword");
				if ($nextPres == "850.0"){ 
					$t850 = $nextTemp;
					$dp850 = $nextDP;
				}
				if ($nextPres == "700.0") 
					$t700 = $nextTemp;
				if ($nextPres == "500.0") 
					$t500 = $nextTemp;
			} while ((($nextTemp >= $baseTemp)||false)&&($nextHeight < 5000));// checking that next level is with less hum and more temp
			//echo "top inversion : ".$baseHeight." ".$baseTemp." ".$baseHum;
			$topInversionHeight = $baseHeight;
			$topInversionTemp = $baseTemp;
			$topInversionHum = $baseHum;
			// if inversion is below 850mb level
			if ($t850=="") 
				if (searchNext ($radio_contents_tok, "850.0")) {
					$t850 = getNextWord($radio_contents_tok, 2, "Nextword");
					$dp850 = getNextWord($radio_contents_tok, 1, "Nextword");
				}
			if ($t700=="")
				if (searchNext ($radio_contents_tok, "700.0")) 
					$t700 = getNextWord($radio_contents_tok, 2, "Nextword");
			if ($t500=="") 
				if (searchNext ($radio_contents_tok, "500.0")) 
					$t500 = getNextWord($radio_contents_tok, 2, "Nextword");

			$inversionThickness = $topInversionHeight - $baseInversionHeight;
			$inversionTemp =  $topInversionTemp - $baseInversionTemp;
			if ($nextHeight>5000) {
				$inversionThickness = "0";
				$inversionTemp  = "0";
				$baseInversionHeight = "5000(none)";

			}

			//echo $t850." 700: ".$t700." dp850: ".$dp850." <br />";
			// fire index http://weather.jsums.edu/~coamps/fire_index.html
			$FireIdx = getFireIdx($t850, $t700, $dp850);

			// ************** index claculation ***************
			//Showalter index
			if (searchNext ($radio_contents_tok, "index:"))//Showalter index
				$Showalter = getNextWord($radio_contents_tok, 1, "Showalter");
			if (searchNext ($radio_contents_tok, "index:"))// Lifted index
				$LiftedIdx = getNextWord($radio_contents_tok, 1), "Showalter";
			if (searchNext ($radio_contents_tok, "index:"))//SWEAT index
				$SWEATIdx = getNextWord($radio_contents_tok, 1, "Showalter");
			if (searchNext ($radio_contents_tok, "index:"))//K index
				$KIdx = getNextWord($radio_contents_tok, 1, "K index");
			if (searchNext ($radio_contents_tok, "index:"))//Cross totals index
				$CrossIdx = getNextWord($radio_contents_tok, 1, "Cross");
			if (searchNext ($radio_contents_tok, "index:"))//Vertical totals index
				$VerticalIdx = getNextWord($radio_contents_tok, 1, "Vertical");
			if (searchNext ($radio_contents_tok, "index:"))//Totals totals index
				$TotalsIdx = getNextWord($radio_contents_tok, 1, "Totals");
			if (searchNext ($radio_contents_tok, "Energy:"))//CAPE
				$CAPE = getNextWord($radio_contents_tok, 1, "CAPE");
			if (searchNext ($radio_contents_tok, "Inhibition:"))//Convective Inhibition
				$ConIn = getNextWord($radio_contents_tok, 1, "Convective");
			if (searchNext ($radio_contents_tok, "Number:"))//Bulk Richardson Number
				$BulkRichNum = getNextWord($radio_contents_tok, 1, "Bulk");
			
			return true;
		}
		else
			return false;

		
	}

	function SortIndex ($paramName, $actualValue, $bar1, $bar2, $bar3, $Asc, $displayTitleInsteadOfValue)// Asc==true --> $bar1 < $bar2 < $bar3 
	{
		global $LOW, $HIGH, $EXTREME, $MEDIUM, $lang_idx;
		if ($Asc){
		   if ((float)$actualValue <  (float)$bar1)
			{
			   $index = "indexlow";
			   $title = $LOW;
			}
		   else if ((float)$actualValue <  (float)$bar2)
			{
			   $index = "indexmedium";
			    $title = $MEDIUM;

			}
		   else if ((float)$actualValue <  (float)$bar3)
			{
			   $index = "indexhigh";
			    $title = $HIGH;
			}
		   else
			{
			   $index = "indexextreme";
			    $title = $EXTREME;
			}
	   }
	   else{//descending
			
			if ((float)$actualValue >  (float)$bar1)
		   {
			  $index = "indexlow";
			   $title = $LOW;
		   }
		   else if ((float)$actualValue >  (float)$bar2)
		   {
			   $index = "indexmedium";
			    $title = $MEDIUM;
		   }
		   else if ((float)$actualValue >  (float)$bar3)
		   {
			   $index = "indexhigh";
			    $title = $HIGH;
		   }
		   else 
		   {
			   $index = "indexextreme";
			    $title = $EXTREME;
		   }
	   }
	   if ($displayTitleInsteadOfValue)
		  $actualValue = $title[$lang_idx];
		
	   echo "<span class=\"small\">".$paramName."</span>&nbsp;<span class=\"".$index."\"><strong>".$actualValue."</strong></span>";

	}

$res = getRadioData();

//SortIndex ("Con In", $ConIn, , , , , false);

if (!$res)
echo "<div><fieldset><span class=\"high\">no radiosonde data - try again later</span></fieldset></div>";
?>
<div class="inv_plain_3 float" <? if (isHeb()) echo "dir=\"rtl\""; ?> style="width:50%;padding:1em;text-align:center">
<table width="100%" >
<tr><td class="inv_plain_3_minus" colspan="3"><a href="http://weather.wpafb.af.mil/forecast-tools/indices.html" title="Storm Intensity - based on radio sonde indexes"><?echo $CURRENT_INSTABLITY[$lang_idx];?></a>
<br /><span class="indexlow"><?echo $LOW[$lang_idx];?></span>&nbsp;<span class="indexmedium"><?echo $MEDIUM[$lang_idx];?></span>&nbsp;<span class="indexhigh"><?echo $HIGH[$lang_idx];?></span>&nbsp;<span class="indexextreme"><?echo $EXTREME[$lang_idx];?></span></td></tr>
<tr>
	<td class="box">
		
			<table width="100%" >
			<tr class="inv_plain_3_zebra">
				<td align="center">
					<a href="<? echo get_query_edited_url(get_url(), 'section', 'radiosonde');?>"><?echo sprintf("%02dZ ", $hoursonde).$RADIOSONDE[$lang_idx];?>
					</a>
					<a href="<? echo get_query_edited_url(get_url(), 'section', 'radiosonde');?>">
					<div>850T = <?echo $t850;?><? echo $current->get_tempunit(); ?><br />700T = <?echo $t700;?><? echo $current->get_tempunit(); ?><br/>500T = <?echo $t500;?><? echo $current->get_tempunit(); ?></div>
					</a>
				</td>
				<td align="center">
						
					<a class="hlink" href="http://www.fs.fed.us/land/wfas/wfas25.html" title="<? echo $MORE_INFO[$lang_idx];?>" target="_blank">
					<?echo $FIRE_INDEX[$lang_idx];?>
					</a>
				
					<a class="info" href="http://www.fs.fed.us/land/wfas/wfas25.html" target="_blank">
					<? if (isHeb()) { ?>
					<span class="info" style="width:300px;left:-5em" dir="rtl">Haines Index<br />מדד ליציבות ויובש האוויר</span>
					<? } else { ?>
					<span class="info" style="width:300px;left:-5em">Haines Index<br/>It is used to indicate the potential for wildfire growth by measuring the stability and dryness of the air over a fire.</span>
					<? } ?>
					<?SortIndex ("Haines Index", $FireIdx."", 4 , 5 , 6 , true, false);?>
					</a>
							
				</td>
			</tr>
			</table>
			<table width="100%" >
			<tr class="inv_plain_3_minus">
			<td>
			<a class="info" href="#">
			<? if (isHeb()) { ?>
			<span class="info" style="width:300px;left:-5em" dir="rtl">Vertical Total Totals<br />מדד יציבות סטאטית בין מפלס 850mb למלס 500mb. זהו הפרש טמפרטורות בין המפלסים.</span>
			<? } else { ?>
			<span class="info" style="width:300px;left:-5em">Vertical Total Totals is a measure of the thunderstorm potential. VT represents static stability between 850 mb and 500 mb.</span>
			<? } ?>
			<? SortIndex ("Vertical", $VerticalIdx, 25 , 28 , 33 , true, false);?>
			</a>
			</td>
		   <td>
			<a class="info" href="#">
			<? if (isHeb()) { ?>
			<span class="info" style="width:300px;left:-15em" dir="rtl">Convective Available Potential Energy <br />מייצג את כמות האנרגיה שהיתה לגוש אוויר אם היו מרימים אותו. לעיתים קרובות זה מראה את עוצמת הזרמים העולים בתוך סופת רעמים.<br /><u>2000 - 3000</u><br /> -> מספיק אנרגיה כדי לייצר סופות רעמים<br /> <U>3000+</U> <br />-> מספיק אנרגיה כדי לייצר סופת רעמים חזקה <br /><U>0</U><br /> -> אטמוספירה יציבה</span>
			<? } else { ?>
			<span class="info" style="width:300px;left:-15em">Convective Available Potential Energy (CAPE) represents the amount of energy a parcel might have if it were lifted. Often this reflects the strength of updrafts within a thunderstorm. <br /><u> > 2000 </u><br /> -> enough energy to produce thunderstorms.<br /> <U>> 3000</U> <br />-> enough energy to produce strong thunderstorms. <br /><U>0</U><br /> -> stable atmosphere</span>
			<? } ?>
			<?SortIndex ("CAPE", $CAPE, 1000 , 2000 , 3000 , true, false);?>
			</a>
			</td>
			<td>
			<a class="info" href="#">
			<? if (isHeb()) { ?>
			<span class="info" style="width:300px;left:-15em" dir="rtl">Cross Totals Index<br />מודד את התדירות והעוצמה של סופת הרעמים. הוא מביא בחשבון את נקודת הטל של מפלס 850mb.</span>
			<? } else { ?>
			<span class="info" style="width:300px;left:-15em">Cross Totals Index is a measure of the frequency and intensity of thunderstorms. The CT includes the 850 mb dew point.</span>
			<? } ?>
			<?SortIndex ("Cross", $CrossIdx, 18, 24, 28 , true, false);?>
			</a>
			</td>
			
			
			</tr>
			<tr class="inv_plain_3_minus">
			<td>
			<a class="info" href="#">
			<? if (isHeb()) { ?>
			<span class="info" style="width:30em;left:-15em" dir="rtl">Showalter Index<br />מדד לפוטנציאל של סופת רעמים. יעיל כאשר גוש רדוד של אוויר קר מתחת ל-850mb לא מפתח קונבקציה מעל השכבה. 
			המדד מראה אי יציבות בין מפלסים 850 ל 500.
			המדד לא קיים אם יש לחות רק מתחת ל 850mb.</span>
			<? } else { ?>
			<span class="info" style="width:30em;left:-15em">Showalter Index is a measure of thunderstorm potential and severity. Especially useful when a shallow, cool layer of air below 850 mb conceals greater convective potential above. The SSI is a measure of the potential instability in the 850mb to 500 mb layer. The SSI is unrepresentative if the available low level moisture occurs below 850mb.</span>
			<? } ?>
			<?SortIndex ("Showalter", $Showalter, 3 , 1 , -2 ,false, false);?>
			</a>
			</td>
			<td>
			<a class="info" href="#">
			<? if (isHeb()) { ?>
			<span class="info" style="width:30em;left:-15em" dir="rtl">K Index<br />מודד פוטנציאל של סופת רעמים.<br /> <U>35+</U> <br />-> צפויות סופות רעמים<br /> <U>0 - 10</U> <br />-> שמיים בהירים</span>
			<? } else { ?>
			<span class="info" style="width:30em;left:-15em">K Index is a measure of the thunderstorm potential.<br /> <U>35+</U> <br />-> thunderstorms are likely.<br /> <U>< 10</U> <br />-> skies are clear.</span>
			<? } ?>
			<?SortIndex ("K", $KIdx, 10 , 20  , 35 , true, false);?>
			</a>
			</td>
			<td>
			<a class="info" href="#">
			<? if (isHeb()) { ?>
			<span class="info" style="width:40em;left:-20em" dir="rtl">Lifted Index<br /> מידת הפוטנציאל של סופת רעמים, הלוקחת בחשבון את הזמינות של הלחות בשכבות הנמוכות. לוקחים גוש אוויר מהקרקע ועד מפלס 500mb ומשווים את הטמפרטורה שלו לשל הסביבה.<br /> <U>0 - 4-</U> <br />-> ייתכנו סופות רעמים <br /> <U>> 4-</U> <br /> -> ייתכנו סופות רעמים חמורות<br /><U>10+</U> <br />-> שמיים בהירים</span>
			<? } else { ?>
			<span class="info" style="width:40em;left:-20em">Lifted Index is a measure of the thunderstorm potential which takes into account the low level moisture availability. The LI field shows instability in the atmosphere by lifting a parcel of air from the surface to 500 mb and comparing its temperature to that of the environment.<br /> <U>< 0</U> <br />-> thunderstorms are possible. <br /> <U>0 - -4</U> <br /> -> severe thunderstorms are possible.<br /><U>10+</U> <br />-> skies are clear.</span>
			<? } ?>
			<?SortIndex ("Lifted", $LiftedIdx, 10 , 0 , -4, false, false);?>
			</a>
			</td>
			
			
			</tr>
			<tr class="inv_plain_3_minus">
			
			<td>
			<a class="info" href="#">
			<? if (isHeb()) { ?>
			<span class="info" style="width:40em;left:-15em" dir="rtl">SWEAT Index<br />פרמטר המשלב את התנועה  (קינמטיקה) והטרמודינמיקה. מכיל בתוכו לחות בשכבות הנמוכות, אי יציבות סטאטית, מהירויות רוח ותנועה של אוייר חם. בניגוד ל-K אינדקס, משתמשים בו רק להערכת סופות רעמים חמורות בלבד.</span>
			<? } else { ?>
			<span class="info" style="width:40em;left:-15em">The SWEAT Index evaluates the potential for severe weather by examining both kinematic and thermodynamic information into one index. Parameters include low-level moisture (850 mb dewpoint), instability (Total Totals Index), lower and middle-level (850 and 500 mb) wind speeds, and warm air advection (veering between 850 and 500 mb). Unlike the K Index, the SWEAT index should be used to assess severe weather potential, not ordinary thunderstorm potential.</span>
			<? } ?>
			<?SortIndex ("SWEAT", $SWEATIdx, 272 , 300 , 600, true, false);?>
			</a>
			</td>
			<td>
			<a class="info" href="#">
			<? if (isHeb()) { ?>
			<span class="info" style="width:40em;left:-15em" dir="rtl"> מודד את הפוטנציאל לסופת רעמים. הוא מורכב משני ים: VERTICAL ו CROSS. כתוצאה מזה - הוא מושפע מיציבות סטאטית ומהלחות במפלס 850mb. <br /><U>40 - 45</U> <br />-> ייתכנו סופות רעמים.<br /><U>52+</U> <br /> -> ייתכנו סופות רעמים חמורות.<br /><U> 40-</U> <br />-> שמיים בהירים.</span>
			<? } else { ?>
			<span class="info" style="width:40em;left:-15em">Total Totals Index is a measure of thunderstorm potential. The Total Totals Index consists of two components: Vertical Totals (VT) and Cross Totals (CT). As a result, TT accounts for both static stability and 850 mb moisture. However, TT would be unrepresentative in situations where the low-level moisture resides below the 850 mb level.<br /><U>< 45</U> <br />-> thunderstorms are possible.<br /><U>> 52</U> <br /> -> severe thunderstorms are possible.<br /><U>< 40</U> <br />-> skies are clear.</span>
			<? } ?>
			<?SortIndex ("Totals", $TotalsIdx, 40, 45 , 52, true, false);?>
			</a>
			</td>
			
			<td>
			<a class="info" href="http://homepage.ntlworld.com/booty.weather/metinfo/CAPE_SHEAR_TS.htm" target="_blank">
			<? if (isHeb()) { ?>
			<span class="info" style="width:30em;left:-15em" dir="rtl">באלק ריצ'רדסון מלמד על סוג סופת הרעמים. הוא נמצא ביחס ישר לכאפה וביחס הפוך לשינויים בעוצמת הרוח.</span>
			<? } else { ?>
			<span class="info" style="width:30em;left:-15em">Bulk Richardson Number is a measure of thunderstorm type. BRN is proportional to CAPE and inversely proportional to shear difference.</span>
			<? } ?>
			<?SortIndex ("Bulk", $BulkRichNum, 10 , 35 , 50 , true, false);?>
			</a>
			</td>
			
			</tr>
			</table>
	</td>
</tr>
</table>
<div class="inv_plain_3 float" <? if (isHeb()) echo "dir=\"rtl\""; ?> style="width:80%;padding:1em;text-align:center">
<a class="hlink" href="http://www.blackhillsweather.com/inversions.html" target="_blank" title="The temperature increases the farther up you go from the earth - the oposite of instability.
אינברסיה של טמפרטורה - הטמפרטורה עולה ככל שעולים בגובה. ההיפך מאי יציבות.">
<? echo $INVERSION[$lang_idx];?>
</a>
<span class="indexlow"><?echo $WEAK[$lang_idx];?></span>&nbsp;<span class="indexmedium"><?echo $MEDIUM[$lang_idx];?></span>&nbsp;<span class="indexhigh"><?echo $STRONG[$lang_idx];?></span>&nbsp;<span class="indexextreme"><?echo $EXTREME[$lang_idx];?></span>
<table width="100%">
<tr class="inv_plain_3_zebra">
<td><?SortIndex ($THICKNESS[$lang_idx], $inversionThickness."m", 130 , 50 , 10 , true, false);?></td>
<td><?SortIndex ($BASE[$lang_idx], $baseInversionHeight."m", 1000 , 3000 , 4000 , false, false);?></td>
<td><?SortIndex ($DELTA[$lang_idx], $inversionTemp."<? echo $current->get_tempunit(); ?>", 2 , 1 , 0.5 , true, false);?></td>
</tr>
</table>
</div>
</div>
<div class="inv_plain_3 float" style="padding:1em">
<script type="text/javascript"><!--
google_ad_client = "pub-2706630587106567";
/* 300x250, created 9/12/10 */
google_ad_slot = "7748861760";
google_ad_width = 300;
google_ad_height = 250;
google_color_border = ["<?= $forground->bg['+4'] ?>"];
google_color_bg = ["<?= $forground->bg['+4'] ?>"];
google_color_link = ["<?= $forground->bg['-9'] ?>"];
google_color_url = ["<?= $forground->bg['-9'] ?>"];
google_color_text = ["<?= $forground->bg['-9'] ?>"];

//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>
<div style="clear:both;text-align:left;padding:2em">
<? 
	if (strstr (get_url(), "radio")){
		$indices = get_file_string("http://weather.uwyo.edu/upperair/indices.html");
		echo $indices;
	}
	?>
</div>


