<?
/************************************************************************/
     /* checking if there is broken record ; first - year, second - month*/
    $broken = false;
    $period = "MIS";
    $unit = "MIS";
    $highorlow = "MIS";
    $extdata = "mis";
    $messageBroken = array();
	$messageBrokenToSend = array();
	$updateMessage = false;
    
/************************************************************************/    
function updateSigWeather ($picP, $sigW, $extrainfoP, $urlP)
{
	global $sig, $ALT, $pic, $extrainfo, $url;
	 
	$ALT = $sigW;
	$pic = $picP;
	$extrainfo = $extrainfoP;
	$url = $urlP;

	array_push($sig, array('sig' => $sigW, 'pic' => $picP, 'extrainfo' => $extrainfoP, 'url' => $urlP));
}

function notnull ()
{
	global $min15, $min30, $oneHour;
	return (($min15->get_prschange() != null)&&
		 ($min30->get_prschange() != null )&&
		 ($oneHour->get_prschange() != null));
}
$messageAction = array();
$EmailSubject = array();
$pic = "lights2.jpg";
$ALT = array();
$extrainfo = array();
$extrainfoS = array();
$sig = array();
$primarySig = array();
$dew_over_night = false;
$isHeatWave = false;
$url= get_query_edited_url(get_url(), 'section', 'extended');

///////////////////////////  hightemp ////////////////////////////
if (($today->get_hightemp() == $thisYear->get_hightemp())
	&&($today->get_hightemp() - $current->get_temp() > 1.5))
		setBrokenData("yearly", "high", 
					  $today->get_hightemp().$current->get_tempunit()." ".$AT[$lang_idx]." ".$today->get_hightemp_time(), 
					  "temp");
else if (($today->get_hightemp() == $thisMonth->get_hightemp())
	    &&($today->get_hightemp() - $current->get_temp() > 1.5))
			setBrokenData("monthly", "high", 
							$today->get_hightemp().$current->get_tempunit()." ".$AT[$lang_idx]." ".$today->get_hightemp_time(), 
							"temp");
///////////////////////////  lowtemp ////////////////////////////
if (($today->get_lowtemp() == $thisYear->get_lowtemp())
    &&($today->get_lowtemp() - $current->get_temp() < -1.5))
		setBrokenData("yearly", "low", 
					  $today->get_lowtemp().$current->get_tempunit()." ".$AT[$lang_idx]." ".$today->get_lowtemp_time(), 
					  "temp");
else if (($today->get_lowtemp() == $thisMonth->get_lowtemp())
         &&($today->get_lowtemp() - $current->get_temp() < -1.5))
			setBrokenData("monthly", "low", 
						  $today->get_lowtemp().$current->get_tempunit()." ".$AT[$lang_idx]." ".$today->get_lowtemp_time(), 
							"temp");
///////////////////////////  highrainrate ////////////////////////////
if (($today->get_highrainrate() !== "0.0") 
    &&($today->get_highrainrate() !== "")
     &&($today->get_highrainrate() > 0.3)){
	  if ($today->get_highrainrate() == $thisYear->get_highrainrate())
		 setBrokenData("yearly", "high", 
						$today->get_highrainrate()." ".$RAINRATE_UNIT[$lang_idx]." ".$AT[$lang_idx]." ".$today->get_highrainrate_time(), 
						"rainrate");
	  else if (($today->get_highrainrate() == $thisMonth->get_highrainrate()) 
			  &&(!$dew_over_night))
				setBrokenData("monthly", "high", 
							  $today->get_highrainrate()." ".$RAINRATE_UNIT[$lang_idx]." ".$AT[$lang_idx]." ".$today->get_highrainrate_time(), 
							  "rainrate");
}

///////////////////////////  highhum ////////////////////////////
if (($today->get_highhum() === $thisYear->get_highhum())
    &&($min30->get_humchange() < -5))
	  setBrokenData("yearly", "high", 
					$today->get_highhum()."% ".$AT[$lang_idx]." ".$today->get_highhum_time(), 
					"humidity");
else if (($today->get_highhum() === $thisMonth->get_highhum())
    &&($min30->get_humchange() < -5))
		setBrokenData("monthly", "high", 
						$today->get_highhum()."% ".$AT[$lang_idx]." ".$today->get_highhum_time(), 
						"humidity");
///////////////////////////  lowhum ////////////////////////////
if (($today->get_lowhum() == $thisYear->get_lowhum())
    &&($min30->get_humchange() > 5))
		setBrokenData("yearly", "low", 
						$today->get_lowhum()."% ".$AT[$lang_idx]." ".$today->get_lowhum_time(), 
						"humidity");
else if (($today->get_lowhum() == $thisMonth->get_lowhum())
        &&($min30->get_humchange() > 5))
			setBrokenData("monthly", "low", 
						  $today->get_lowhum()."% ".$AT[$lang_idx]." ".$today->get_lowhum_time(), 
						  "humidity");
///////////////////////////  highbar ////////////////////////////
if (($today->get_highbar() === $thisYear->get_highbar())
    &&($min30->get_prschange() < -0.4))
		setBrokenData("yearly", "high", 
					  $today->get_highbar()."mb", 
					  "pressure");
else if (($today->get_highbar() === $thisMonth->get_highbar())
         &&($min30->get_prschange() < -0.4))
            setBrokenData("monthly", "high", 
							$today->get_highbar()."mb", 
							"pressure");
///////////////////////////  lowbar ////////////////////////////
if (($today->get_lowbar() === $thisYear->get_lowbar())
    &&($min30->get_prschange() > 0.4))
		setBrokenData("yearly", "low", 
					 $today->get_lowbar()."mb", 
					 "pressure");
else if (($today->get_lowbar() === $thisMonth->get_lowbar())
         &&($min30->get_prschange() > 0.4))
			setBrokenData("monthly", "low", 
						  $today->get_lowbar()."mb", 
						"pressure");
///////////////////////////  highwind ////////////////////////////        
if (($today->get_highwind() == $thisYear->get_highwind())
   &&($min30->get_windspdchange() < -4) 
   &&($today->get_highwind() != ""))
		setBrokenData("yearly", "high",  
						$today->get_highwind()." ".$KNOTS[$lang_idx]." ".$AT[$lang_idx]." ".$today->get_highwind_time(), 
						"wind");
else if (($today->get_highwind() == $thisMonth->get_highwind())
		&&($min30->get_windspdchange() < -4))
			setBrokenData("monthly", "high", 
							$today->get_highwind()." ".$KNOTS[$lang_idx]." ".$AT[$lang_idx]." ".$today->get_highwind_time(), 
							"wind");


      /************************************************************************/
if (($today->get_highrainrate() == "0.3") && 
    ($current->get_rainrate() == "0.0")&&
	(($today->get_highrainrate_time() >= 4)&&
	($today->get_highrainrate_time() <= 8)))
{
	  $dew_over_night = true;
}
/*if ($current->get_hum() > 99)
{
	updateSigWeather(
		"fog1.jpg", 
		$FOG, 
		array($HUMIDITY[$EN].": ".$current->get_hum()."%", $HUMIDITY[$HEB].": ".$current->get_hum()."%"), "".BASE_URL."/".$_SERVER['SCRIPT_NAME']."?section=graph&amp;graph=OutsideHumidityHistory.gif&amp;profile=2&amp;lang=$lang_idx");
    //update_action ("Fog", $extrainfo, $ALT);
}*/

if (($hour < 11)&&($dew_over_night))
{
	updateSigWeather(
		"hum.jpg", 
		$HIGH_DEW_OVER_NIGHT, 
		array($today->get_highhum()."%"." ".$HUMIDITY[$EN], $today->get_highhum()."%"." ".$HUMIDITY[$HEB]), "".BASE_URL."/".$_SERVER['SCRIPT_NAME']."?section=graph&amp;graph=OutsideHumidityHistory.gif&amp;profile=2&amp;lang=$lang_idx");
}
if (isRaining()||(IS_SNOWING == 1))
{
	$rainOrSnow = $ITS_RAINING;
	if (($current->get_rainrate() > 20)||($current->get_windspd() > 15))
		$rainOrSnow =  $STORMY;
	if (isSnowing())
		$rainOrSnow =  $ITS_SNOWING;
	updateSigWeather(
		"rain1.jpg", 
		$rainOrSnow, 
		array($DAILY_RAIN[$EN].": ".$today->get_rain().$RAIN_UNIT[$lang_idx], $DAILY_RAIN[$HEB].": ".$today->get_rain()." ".$RAIN_UNIT[$lang_idx]), "".BASE_URL."/".$_SERVER['SCRIPT_NAME']."?section=graph&amp;graph=rain.php&amp;profile=1&amp;lang=$lang_idx");
    update_action ("RainStarted", $extrainfo, $ALT);
}
if (($rainrateHour !== "0.0") && 
		 (!isRaining()) && 
		 (!$dew_over_night))
{
	updateSigWeather(
		"profile1/rain.php?level=1&freq=1&amp;lang={$lang_idx}", 
		$RAIN_HAS_JUST_STOPPED, 
		array($DAILY_RAIN[$EN].": ".$today->get_rain().$RAIN_UNIT[$lang_idx], $DAILY_RAIN[$HEB].": ".$today->get_rain()." ".$RAIN_UNIT[$lang_idx]), "".BASE_URL."/".$_SERVER['SCRIPT_NAME']."?section=graph&amp;graph=rain.php&amp;profile=1&amp;lang=$lang_idx");
     //update_action ("RainStopped", $extrainfo, $ALT);
}
if (($today->get_highrainrate() !== "0.0") && 
		 (!isRaining()) && 
		 (!$dew_over_night)&&
		 (($today->get_rain() > 0.3)&&
		 ($current->get_rainrate() == 0)))
{
	updateSigWeather(
		"profile1/rain.php?level=1&freq=1&amp;lang={$lang_idx}", 
		$RAIN_HAS_GONE, 
		array($DAILY_RAIN[$EN].": ".$today->get_rain().$RAIN_UNIT[$lang_idx], $DAILY_RAIN[$HEB].": ".$today->get_rain()." ".$RAIN_UNIT[$lang_idx]), "".BASE_URL."/".$_SERVER['SCRIPT_NAME']."?section=graph&amp;graph=rain.php&amp;profile=1&amp;lang=$lang_idx");
}

if (($current->get_temp('&#176;c') < 2)&&($current->get_temp() != ""))
{
	updateSigWeather(
		"cold.gif", 
		$VERY_COLD, 
		array($TEMP[$EN].": ".$current->get_temp().$current->get_tempunit(), $TEMP[$HEB].": "."<div class=\"low\">".$current->get_temp().$current->get_tempunit()."</div>"), "".BASE_URL."/".$_SERVER['SCRIPT_NAME']."?section=graph&amp;graph=temp.php&amp;profile=2&amp;lang=$lang_idx");
    update_action ("Cold", 
                   array("<div class=\"loading float\"><img src=\"".BASE_URL."/images/$pic\" alt=\"$ALT[$EN]\" width=\"150px\" border=\"0\"></div><div class=\"loading float\">&nbsp;$CURRENT_SIG_WEATHER[$EN]&nbsp;<strong>".$ALT[$EN]."</strong><div class=\"loading float big\">&nbsp;{$extrainfo[$EN]}</div></div>", "<div class=\"loading float\"><img src=\"".BASE_URL."/images/$pic\" alt=\"$ALT[$HEB]\" width=\"150px\" border=\"0\"></div><div class=\"loading float\">&nbsp;$CURRENT_SIG_WEATHER[$HEB]&nbsp;<strong>".$ALT[$HEB]."</strong><div class=\"loading float big\">&nbsp;{$extrainfo[$HEB]}</div></div>"),
                           $ALT);
}
if ($current->get_pm10() > 100 || $current->get_pm25() > 50)
{
    updateSigWeather(
		"dust.gif", 
		$HIGH_DUST, 
		array($DUST[$EN].": ".$current->get_pm10()." µg/m3", $DUST[$HEB].": ".$current->get_pm10()." µg/m3"), get_query_edited_url(get_url(), 'section', 'dust.html'));
}
if ($current->get_uv() > 8)
{
	updateSigWeather("hot.gif" , $HIGH_UV,
	array($UV[$EN].": ".$current->get_uv(), $UV[$HEB].": "."<span style=\"direction:ltr\">".$current->get_uv()."</span>"), "".BASE_URL."/".$_SERVER['SCRIPT_NAME']."?section=graph&amp;graph=UVHistory.gif&amp;profile=2&amp;lang=$lang_idx");
    update_action ("UV", $extrainfo, $ALT);
}

if (($current->get_solarradiation() > 500)&&($current->get_temp('&#176;c') < 10)&&($min10->get_windspd() > 3))
{
  updateSigWeather(
    "cold.gif", 
    $COLD_SUN, 
    array("",""), 
    "".$_SERVER['SCRIPT_NAME']."?section=graph&amp;graph=temp.php&amp;profile=1&amp;lang=$lang_idx");

}
if (($current->get_solarradiation() > 500)&&($current->get_temp('&#176;c') < 14)&&($current->get_temp('&#176;c') > 10)&&($min10->get_windspd() > 3))
{
  updateSigWeather(
    "cold.gif", 
    $HALF_COLD_SUN, 
    array("",""), 
    "".$_SERVER['SCRIPT_NAME']."?section=graph&amp;graph=temp.php&amp;profile=1&amp;lang=$lang_idx");

}
if (($current->get_solarradiation() > 500)&&($current->get_temp('&#176;c') > 11)&&($current->get_temp('&#176;c') <= 15)&&($min10->get_windspd() < 0.8))
{
  updateSigWeather(
    "nowind.jpg", 
    $SUN_SHADE, 
    array("",""), 
    "".$_SERVER['SCRIPT_NAME']."?section=graph&amp;graph=temp.php&amp;profile=1&amp;lang=$lang_idx");

}
if (($current->get_solarradiation() > 500)&&($current->get_temp('&#176;c') > 15)&&($current->get_temp('&#176;c') < 19)&&($min10->get_windspd() < 4)&&($current->get_hum() > 40))
{
  updateSigWeather(
    "nowind.jpg", 
    $SUN_SHADE, 
    array("",""), 
    "".$_SERVER['SCRIPT_NAME']."?section=graph&amp;graph=temp.php&amp;profile=1&amp;lang=$lang_idx");

}
if ((($current->get_temp('&#176;c') > 12)&&($current->get_temp('&#176;c') < 25)&&($min10->get_windspd() < 1))||
        (($current->get_temp('&#176;c') > 24)&&($current->get_temp('&#176;c') < 28)&&($min10->get_windspd() > 3)))
{
  updateSigWeather(
    "nowind.jpg", 
    $GOOD_TIME, 
    array("",""), 
    "".$_SERVER['SCRIPT_NAME']."?section=graph&amp;graph=temp.php&amp;profile=1&amp;lang=$lang_idx");

}
if (($current->get_hum() < 40)&&($min10->get_windspd() > 3)&&($current->get_pm10() < 100 && $current->get_pm25() < 50))
{
  updateSigWeather(
    "wind1.jpg", 
    $GOOD_LAUNDRY, 
    array("",""), 
    "".$_SERVER['SCRIPT_NAME']."?section=graph&amp;graph=hum.php&amp;profile=1&amp;lang=$lang_idx");

}

if	((($min15->get_prschange() < -0.3)||
	 ($min30->get_prschange() < -0.5)||
	 ($oneHour->get_prschange() < -1)) && (notnull()))
{
	if ($min15->get_prschange() < -0.3)
	{
		$extrainfoS = array (
		getLastUpdateMin()." ".$MINTS[$EN].": ".get_param_tag($min15->get_prschange())." ".$BAR_UNIT[$EN] , getLastUpdateMin()." ".$MINTS[$HEB].": ".get_param_tag($min15->get_prschange())." ".$BAR_UNIT[$HEB]);
	}
	else if ($min30->get_prschange() < -0.5)
	{
		$extrainfoS = array (
		"30 ".$MINTS[$EN].": ".get_param_tag($min30->get_prschange())." ".$BAR_UNIT[$EN] , 
		"30 ".$MINTS[$HEB].": ".get_param_tag($min30->get_prschange())." ".$BAR_UNIT[$HEB]);
	}
	else if ($oneHour->get_prschange() < -1)
	{
		$extrainfoS = array (
		$HOUR[$EN].": ".get_param_tag($oneHour->get_prschange())." ".$BAR_UNIT[$EN] , 
		$HOUR[$HEB].": ".get_param_tag($oneHour->get_prschange())." ".$BAR_UNIT[$HEB]);
	}
	updateSigWeather(
		"profile1/baro.php?datasource=downld02&amp;lang={$lang_idx}", 
		$PRESSURE_IS_FALLING, 
		$extrainfoS, 
		"".$_SERVER['SCRIPT_NAME']."?section=graph&amp;graph=baro.php&amp;profile=1&amp;lang=$lang_idx");
 	//update_action ("PrsSinking", $extrainfo, $ALT);
}
if (($current->get_dew() > 16)&&($current->get_tempunit() == '&#176;c'))
{
    $extrainfoS = array (
		$DEW[$EN].": ".$current->get_dew() , 
		$DEW[$HEB].": ".$current->get_dew());
        updateSigWeather(
		"hum.jpg", 
		$HIGH_HUMIDITY, 
		$extrainfoS, 
		"".$_SERVER['SCRIPT_NAME']."?section=graph&amp;graph=dewpt.php&amp;profile=1&amp;lang=$lang_idx");
}
if (($current->get_hum() < 20)&&($current->get_hum() != ""))
{
	$extrainfoS = array (
		$HUMIDITY[$EN].": ".$current->get_hum()."%" , 
		$HUMIDITY[$HEB].": ".$current->get_hum()."%");
   updateSigWeather(
		"dry_ground_1.jpg", 
		$VERY_DRY, 
		 $extrainfoS, 
		 "".$_SERVER['SCRIPT_NAME']."?section=graph&amp;graph=OutsideHumidityHistory.gif&amp;profile=1&amp;lang=$lang_idx");
	update_action ("Dry", $extrainfo, $ALT);
}
if ((($min15->get_prschange() > 0.2)||
	 ($min30->get_prschange() > 0.5)||
	 ($oneHour->get_prschange() > 1))&& (notnull()))
{
	if ($min15->get_prschange()  > 0.2)
	{
		$extrainfoS = array (
		getLastUpdateMin()." ".$MINTS[$EN].": ".get_param_tag($min15->get_prschange())." ".$BAR_UNIT[$EN] , getLastUpdateMin()." ".$MINTS[$HEB].": ".get_param_tag($min15->get_prschange())." ".$BAR_UNIT[$HEB]);
	}
	else if ($min30->get_prschange() > 0.5)
	{
		$extrainfoS = array (
		"30 ".$MINTS[$EN].": ".get_param_tag($min30->get_prschange())." ".$BAR_UNIT[$EN] , 
		"30 ".$MINTS[$HEB].": ".get_param_tag($min30->get_prschange())." ".$BAR_UNIT[$HEB]);
	}
	else if ($oneHour->get_prschange()  > 1)
	{
		$extrainfoS = array (
		$HOUR[$EN].": ".get_param_tag($oneHour->get_prschange())." ".$BAR_UNIT[$EN] , 
		$HOUR[$HEB].": ".get_param_tag($oneHour->get_prschange())." ".$BAR_UNIT[$HEB]);
	}
	updateSigWeather(
		"profile1/baro.php?datasource=downld02&amp;lang={$lang_idx}", 
		$DRASTIC_PRESSURE_RISE, 
		$extrainfoS, 
		"".$_SERVER['SCRIPT_NAME']."?section=graph&amp;graph=baro.php&amp;profile=1&amp;lang=$lang_idx");
	//update_action ("PrsRise", $extrainfo, $ALT);
}
if ((($min15->get_tempchange() < -0.8)||
	 ($min30->get_tempchange() < -1.5)||
	 ($oneHour->get_tempchange() < -2.5)||
	  (($threeHours->get_tempchange() < -4) && ($hour > 7) && ($hour < 15)))&& (notnull()))
{
	if ($min15->get_tempchange() < -0.8)
	{
		$extrainfoS = array (
		getLastUpdateMin()." ".$MINTS[$EN].": ".get_param_tag($min15->get_tempchange()).$current->get_tempunit() , getLastUpdateMin()." ".$MINTS[$HEB].": ".get_param_tag($min15->get_tempchange()).$current->get_tempunit());
		//update_action ("TempDrop", $extrainfo, $ALT);
	}
	else if ($min30->get_tempchange() < -1.5)
	{
		$extrainfoS = array (
		"30 ".$MINTS[$EN].": ".get_param_tag($min30->get_tempchange()).$current->get_tempunit() , 
		"30 ".$MINTS[$HEB].": ".get_param_tag($min30->get_tempchange()).$current->get_tempunit());
		//update_action ("TempDrop", $extrainfo, $ALT);
	}
	else if ($oneHour->get_tempchange() < -2.5)
	{
		$extrainfoS = array (
		$HOUR[$EN].": ".get_param_tag($oneHour->get_tempchange()).$current->get_tempunit() , 
		$HOUR[$HEB].": ".get_param_tag($oneHour->get_tempchange()).$current->get_tempunit());
		//update_action ("TempDrop", $extrainfo, $ALT);
	}
	else if (($threeHours->get_tempchange() < -4) && ($hour > 7) && ($hour < 15))
	{
		$extrainfoS = array (
		"3 ".$HOURS[$EN].": ".get_param_tag($threeHours->get_tempchange()).$current->get_tempunit() , 
		"3 ".$HOURS[$HEB].": ".get_param_tag($threeHours->get_tempchange()).$current->get_tempunit());
	}
	updateSigWeather(
		"profile1/temp.php?datasource=downld02&amp;lang={$lang_idx}", 
		$DRASTIC_TEMP_DROP, 
		$extrainfoS, 
		"".$_SERVER['SCRIPT_NAME']."?section=graph&amp;graph=temp.php&amp;profile=1&amp;lang=$lang_idx");
	
}
if (((($min15->get_tempchange() > 1) && ($hour > 9) && ($hour < 7))   ||
	 (($min30->get_tempchange()  > 2) && ($hour > 9) && ($hour < 7))  ||
	 (($oneHour->get_tempchange() > 3) && ($hour > 9) && ($hour < 7)) ||
	  (($threeHours->get_tempchange() > 3) && ($hour > 14) && ($hour < 7)))&& (notnull()))
{
	if ($min15->get_tempchange() > 1)
	{
		$extrainfoS = array (
		getLastUpdateMin()." ".$MINTS[$EN].": ".get_param_tag($min15->get_tempchange()).$current->get_tempunit() , getLastUpdateMin()." ".$MINTS[$HEB].": ".get_param_tag($min15->get_tempchange()).$current->get_tempunit());
		
	}
	else if ($min30->get_tempchange() > 2)
	{
		$extrainfoS = array (
		"30 ".$MINTS[$EN].": ".get_param_tag($min30->get_tempchange()).$current->get_tempunit() , 
		"30 ".$MINTS[$HEB].": ".get_param_tag($min30->get_tempchange()).$current->get_tempunit());
		
	}
	else if ($oneHour->get_tempchange() > 3)
	{
		$extrainfoS = array (
		$HOUR[$EN].": ".get_param_tag($oneHour->get_tempchange()).$current->get_tempunit() , 
		$HOUR[$HEB].": ".get_param_tag($oneHour->get_tempchange()).$current->get_tempunit());
	}
	else if (($threeHours->get_tempchange() > 3.5))
	{
		$extrainfoS = array (
		"3 ".$HOURS[$EN].": ".get_param_tag($threeHours->get_tempchange()).$current->get_tempunit() , 
		"3 ".$HOURS[$HEB].": ".get_param_tag($threeHours->get_tempchange()).$current->get_tempunit());
		
	}
	updateSigWeather(
		"profile1/temp.php?datasource=downld02&amp;lang={$lang_idx}", 
		$DRASTIC_TEMP_RISE, 
		$extrainfoS, 
		"".$_SERVER['SCRIPT_NAME']."?section=graph&amp;graph=temp.php&amp;profile=1&amp;lang=$lang_idx");
	update_action ("TempRise", $extrainfo, $ALT);
}
if ((($min15->get_humchange() > 15)||
	 ($min30->get_humchange()  > 20)||
	 ($oneHour->get_humchange() > 25)||
	  ($threeHours->get_humchange() > 30))&& (notnull()))
{
	if ($min15->get_humchange() > 15)
	{
		$extrainfoS = array (
		getLastUpdateMin()." ".$MINTS[$EN].": ".get_param_tag($min15->get_humchange())."%" , getLastUpdateMin()." ".$MINTS[$HEB].": ".get_param_tag($min15->get_humchange())."%");
	}
	else if ($min30->get_humchange() > 20)
	{
		$extrainfoS = array (
		"30 ".$MINTS[$EN].": ".get_param_tag($min30->get_humchange())."%" , 
		"30 ".$MINTS[$HEB].": ".get_param_tag($min30->get_humchange())."%");
	}
	else if ($oneHour->get_humchange() > 25)
	{
		$extrainfoS = array (
		$HOUR[$EN].": ".get_param_tag($oneHour->get_humchange())."%" , 
		$HOUR[$HEB].": ".get_param_tag($oneHour->get_humchange())."%");
	}
	else if ($threeHours->get_humchange() > 30)
	{
		$extrainfoS = array (
		"3 ".$HOURS[$EN].": ".get_param_tag($threeHours->get_humchange())."%" , 
		"3 ".$HOURS[$HEB].": ".get_param_tag($threeHours->get_humchange())."%");
	}
	updateSigWeather(
		"profile1/humwind.php?level=1&amp;freq=2&amp;datasource=downld02", 
		$DRASTIC_HUM_RISE, 
		$extrainfoS, 
		"".$_SERVER['SCRIPT_NAME']."?section=graph&amp;graph=OutsideHumidityHistory.gif&amp;profile=1&amp;lang=$lang_idx");
	update_action ("HumRise", $extrainfo, $ALT);
}
if (((($min15->get_humchange() < -15)&& ($hour > 9) && ($hour < 7))||
	 (($min30->get_humchange()  < -20)&& ($hour > 9) && ($hour < 7))||
	 (($oneHour->get_humchange() < -25)&& ($hour > 9) && ($hour < 7))||
	  (($threeHours->get_humchange() < -30) && ($hour > 14) && ($hour < 7)))&& (notnull()))
{
	if ($min15->get_humchange() < -15)
	{
		$extrainfoS = array (
		getLastUpdateMin()." ".$MINTS[$EN].": ".get_param_tag($min15->get_humchange())."%" , getLastUpdateMin()." ".$MINTS[$HEB].": ".get_param_tag($min15->get_humchange()).$current->get_tempunit());
	}
	else if ($min30->get_humchange() < -20)
	{
		$extrainfoS = array (
		"30 ".$MINTS[$EN].": ".get_param_tag($min30->get_humchange())."%" , 
		"30 ".$MINTS[$HEB].": ".get_param_tag($min30->get_humchange())."%");
	}
	else if ($oneHour->get_humchange() < -25)
	{
		$extrainfoS = array (
		$HOUR[$EN].": ".get_param_tag($oneHour->get_humchange())."%" , 
		$HOUR[$HEB].": ".get_param_tag($oneHour->get_humchange())."%");
	}
	else if (($threeHours->get_humchange() < -30) && ($hour > 15) && ($hour < 7))
	{
		$extrainfoS = array (
		"3 ".$HOURS[$EN].": ".get_param_tag($threeHours->get_humchange())."%" , 
		"3 ".$HOURS[$HEB].": ".get_param_tag($threeHours->get_humchange())."%");
	}
	updateSigWeather(
		"profile1/humwind.php?level=1&amp;freq=2&amp;datasource=downld02", 
		$DRASTIC_HUM_DROP, 
		$extrainfoS, 
		"".$_SERVER['SCRIPT_NAME']."?section=graph&amp;graph=OutsideHumidityHistory.gif&amp;profile=1&amp;lang=$lang_idx");
	update_action ("HumDrop", $extrainfo, $ALT);
}
//logger("get_temp: ".$current->get_temp('&#176;c'));
if ((($current->get_temp('&#176;c') > 27)&&
		  ($hightemp_diffFromAv >= 5))||
		  ((!$current->is_light())&&
		   ($lowtemp_diffFromAv >= 5)&&
		   ($today->get_lowtemp('&#176;c') > 19)))
{
	$isHeatWave = true;
	if ($hour > 6)
	$extrainfoS = array (
		$TODAY[$EN]." ".$today->get_hightemp().$current->get_tempunit() , 
		$TODAY[$HEB]." ".$today->get_hightemp().$current->get_tempunit());
	else
	$extrainfoS = array (
		$TODAY[$EN]." ".$today->get_hightemp().$current->get_tempunit() , 
		$TODAY[$HEB]." ".$today->get_hightemp().$current->get_tempunit());
	updateSigWeather(
		"heat.jpg", 
		$VERY_HOT_HEAT_WAVE, 
		$extrainfoS, 
		"".$_SERVER['SCRIPT_NAME']."?section=graph&amp;graph=temp.php&amp;profile=3&amp;lang=$lang_idx");
	//update_action ("HeatWave", $extrainfo, $ALT);
}

if (stristr($current->get_winddir(), 'W')
		&& !stristr($min15->get_winddir(), 'W') && (strlen($min15->get_winddir()) > 0)
		&& !stristr($min30->get_winddir(), 'W') && (strlen($min30->get_winddir()) > 0)
		&& !stristr($oneHour->get_winddir(), 'W') && (strlen($oneHour->get_winddir()) > 0)
		&& ($current->get_windspd() > 0))
{
	if ($hour != 0) // prevent the bug on new day 
	updateSigWeather(
		"profile1/winddir.php?lang={$lang_idx}", 
		$WIND_SHIFT, 
		 array (
		"<div class=\"float\" >"."60 ".$MINTS[$EN].":</div> <div class=\"float winddir ".$oneHour->get_winddir()."\"></div> <div class=\"float\" >-></div> <div class=\"float winddir ".$current->get_winddir()."\"></div>", 
		"<div class=\"float\" >"."60 ".$MINTS[$HEB].":</div> <div class=\"float winddir ".$oneHour->get_winddir()."\"></div> <div class=\"float\" >-></div> <div class=\"float winddir ".$current->get_winddir()."\"></div>"), 
		 "".$_SERVER['SCRIPT_NAME']."?section=graph&amp;graph=winddir.php&amp;profile=1&amp;lang=$lang_idx");
	//update_action ("WindShift", $extrainfo, $ALT);
}
else if (stristr($current->get_winddir(), 'W')
		&& !stristr($min15->get_winddir(), 'W') && (strlen($min15->get_winddir()) > 0)
		&& !stristr($min30->get_winddir(), 'W') && (strlen($min30->get_winddir()) > 0)
		&& ($current->get_windspd() > 0))
{
	if ($hour != 0) // prevent the bug on new day 
	updateSigWeather(
		"profile1/winddir.php?lang={$lang_idx}", 
		$WIND_SHIFT, 
		 array (
		"<div class=\"float\" >"."30 ".$MINTS[$EN].":</div> <div class=\"float winddir ".$min30->get_winddir()."\"></div> <div class=\"float\" >-></div> <div class=\"float winddir ".$current->get_winddir()."\"></div>", 
		"<div class=\"float\" >"."30 ".$MINTS[$HEB].":</div> <div class=\"float winddir ".$min30->get_winddir()."\"></div> <div class=\"float\" >-></div> <div class=\"float winddir ".$current->get_winddir()."\"></div>"), 
		 "".$_SERVER['SCRIPT_NAME']."?section=graph&amp;graph=winddir.php&amp;profile=1&amp;lang=$lang_idx");
	//update_action ("WindShift", $extrainfo, $ALT);
}
else if (stristr($current->get_winddir(), 'W')
		&& !stristr($min15->get_winddir(), 'W') && (strlen($min15->get_winddir()) > 0)
		&& ($current->get_windspd() > 0))
{
	if ($hour != 0) // prevent the bug on new day 
	updateSigWeather(
		"profile1/winddir.php?lang={$lang_idx}", 
		$WIND_SHIFT, 
		 array (
		"<div class=\"float\" >".INTERVAL." ".$MINTS[$EN].":</div> <div class=\"float winddir ".$min15->get_winddir()."\"></div> <div class=\"float\" >-></div> <div class=\"float winddir ".$current->get_winddir()."\"></div>", 
		"<div class=\"float\" >".INTERVAL." ".$MINTS[$HEB].":</div> <div class=\"float winddir ".$min15->get_winddir()."\"></div> <div class=\"float\" >-></div> <div class=\"float winddir ".$current->get_winddir()."\"></div>"), 
		 "".$_SERVER['SCRIPT_NAME']."?section=graph&amp;graph=winddir.php&amp;profile=1&amp;lang=$lang_idx");
	//update_action ("WindShift", $extrainfo, $ALT);
}
if ($yestsametime->get_tempchange() > 3)
{
    updateSigWeather(
		"profile2/temp.php?lang={$lang_idx}", 
		$DRASTIC_TEMP_RISE, 
		 array (
		"24 ".$HOURS[$EN].": ".get_param_tag($yestsametime->get_tempchange()).$current->get_tempunit() , 
		"24 ".$HOURS[$HEB].": ".get_param_tag($yestsametime->get_tempchange()).$current->get_tempunit()), 
		 "".$_SERVER['SCRIPT_NAME']."?section=graph&amp;graph=temp.php&amp;profile=2&amp;lang=$lang_idx");
	//update_action ("TempRise", $extrainfo, $ALT);
}
if (($yestsametime->get_tempchange() < -4)&&($yestsametime->get_tempchange() != ""))
{
    updateSigWeather(
		"profile2/temp.php?lang={$lang_idx}", 
		$DRASTIC_TEMP_DROP, 
		 array (
		"24 ".$HOURS[$EN].": ".get_param_tag($yestsametime->get_tempchange()).$current->get_tempunit() ,
		"24 ".$HOURS[$HEB].": ".get_param_tag($yestsametime->get_tempchange()).$current->get_tempunit()), 
		 "".$_SERVER['SCRIPT_NAME']."?section=graph&amp;graph=temp.php&amp;profile=2&amp;lang=$lang_idx");
	//update_action ("TempDrop", $extrainfo, $ALT);
}
if ($yestsametime->get_humchange() >= 30)
{
	updateSigWeather(
	"profile2/humwind.php?level=1&amp;freq=2&amp;datasource=downld02", 
	$DRASTIC_HUM_RISE, 
	 array (
	"24 ".$HOURS[$EN].": ".get_param_tag($yestsametime->get_humchange())."%" ,
	"24 ".$HOURS[$HEB].": ".get_param_tag($yestsametime->get_humchange())."%"), 
	 "".$_SERVER['SCRIPT_NAME']."?section=graph&amp;graph=OutsideHumidityHistory.gif&amp;profile=2&amp;lang=$lang_idx");
	//update_action ("HumRise", $extrainfo, $ALT);
}
if (($yestsametime->get_humchange() <= -30)&&($yestsametime->get_humchange() != ""))
{
	updateSigWeather(
	"profile2/humwind.php?level=1&amp;freq=2&amp;datasource=downld02", 
	$DRASTIC_HUM_DROP, 
	 array (
	"24 ".$HOURS[$EN].": ".get_param_tag($yestsametime->get_humchange())."%" ,
	"24 ".$HOURS[$HEB].": ".get_param_tag($yestsametime->get_humchange())."%"), 
	 "".$_SERVER['SCRIPT_NAME']."?section=graph&amp;graph=OutsideHumidityHistory.gif&amp;profile=2&amp;lang=$lang_idx");
	//update_action ("HumDrop", $extrainfo, $ALT);
}
if (($current->get_windspd() > 7)&&($min10->get_windspd() > 7)){
    
	$extrainfoS = array ($current->get_windspd()." ".$KNOTS[$EN], $current->get_windspd()." ".$KNOTS[$HEB]);
	updateSigWeather(
	"wind1.jpg", 
	$WINDY, 
	$extrainfoS, 
	"".$_SERVER['SCRIPT_NAME']."?section=graph&amp;graph=WindSpeedHistory.gif&amp;profile=1&amp;lang=$lang_idx");
	update_action ("Windy", $extrainfo, $ALT);
}
else if (($current->get_windspd() == 0)&&($min10->get_windspd() == 0))
{
        $pic = "nowind.jpg";
        $ALT = $NO_WIND;
		$url = "".$_SERVER['SCRIPT_NAME']."?section=graph&amp;graph=wind.php&amp;profile=1&amp;lang=$lang_idx";
		$extrainfo = "";
		updateSigWeather($pic, $NO_WIND, $extrainfo, $url);
		//if ($hour > 6)
		//	update_action ("NoWind", $extrainfo, $ALT);
}
if ($today->get_et() > 5.6)
{
   updateSigWeather(
	"dry.gif", 
	array ($HIGH_ET[$EN], $HIGH_ET[$HEB]), 
	 array (
			$ET[$EN]." ".$TILL_NOW[$EN]." ".$today->get_et()." mm", 
			$ET[$HEB]." ".$TILL_NOW[$HEB]." ".$today->get_et()."מ'מ"), 
	"".$_SERVER['SCRIPT_NAME']."?section=graph&amp;graph=ETHistory.gif&amp;profile=1&amp;lang=$lang_idx"); 
        update_action ("HighET", $extrainfo, $ALT);
}
if ($hour > 16 && $today->get_sunshinehours() < 2 && $today->get_sunshinehours() != "")
{
   updateSigWeather(
	"cold.gif", 
	array ($LOW_RAD[$EN], $LOW_RAD[$HEB]), 
	 array (
			$SUNSHINEHOURS[$EN]." ".$TILL_NOW[$EN]." ".$today->get_sunshinehours(), 
			$SUNSHINEHOURS[$HEB]." ".$TILL_NOW[$HEB]." ".$today->get_sunshinehours()), 
	"".$_SERVER['SCRIPT_NAME']."?section=graph&amp;graph=rad.php&amp;profile=1&amp;lang=$lang_idx"); 
        update_action ("LowRad", $extrainfo, $ALT);
}
if (($lowtemp_diffFromAv > 2) 
	&& ($hightemp_diffFromAv > 3) 
	&& (!$isHeatWave) 
	&& ($monthAverge->get_hightemp() != ""))
{
       
	updateSigWeather(
	"hot.gif", 
	array ($WARMER_THAN_AVERAGE[$EN]." ".$TODAY[$EN], $WARMER_THAN_AVERAGE[$HEB]." ".$TODAY[$HEB]), 
	 array (
			$TILL_NOW[$EN]." ".$MAX[$EN]." ".$today->get_hightemp().$current->get_tempunit(), 
			$TILL_NOW[$HEB]." ".$MAX[$HEB]." ".$today->get_hightemp().$current->get_tempunit()), 
	"".$_SERVER['SCRIPT_NAME']."?section=graph&amp;graph=temp.php&amp;profile=2&amp;lang=$lang_idx");
		//update_action ("Warmer", $extrainfo, $ALT);
}

if (true) 
{
	$monthToExplore = ($day > 3 ? $month : getPrevMonth($month));
	$yearToExplore = ($month == 1 && $day <= 3 ? $year - 1 : $year);
	$monthW = ($day > 3 ? $monthInWord : $prevMonthInWord);
	$dep = getDepFromNorm($monthToExplore);
	$warmcold = ($dep >= 0 ? $WARMER_THAN_AVERAGE : $COLDER_THAN_AVERAGE);
	if ($dep == 0)
	{
			$warmcold = $LIKE_AVERAGE;
	}
	updateSigWeather(
	($dep >= 0 ? "hot.gif" : "cold.jpg"), 
	array($warmcold[$EN], $warmcold[$HEB]), 
	($dep >= 0 ? (abs($dep) > 0 ?
			array($monthW." ".$yearToExplore." is ".$warmcold[$EN]." ".$ON[$EN]." <span style=\"display:inline\" class=\"high\">".abs($dep).$current->get_tempunit()."</span>",
			$monthW." ".$yearToExplore." ".$warmcold[$HEB]." ".$ON[$HEB]."<span style=\"display:inline\" class=\"high\">".abs($dep).$current->get_tempunit()."</span>") : array("", ""))
			: 
			array($monthW." ".$yearToExplore." is ".$warmcold[$EN]." ".$ON[$EN]." <span style=\"display:inline\" class=\"low\">".abs($dep).$current->get_tempunit()."</span>",
			$monthW." ".$yearToExplore." ".$warmcold[$HEB]." ".$ON[$HEB]."<span style=\"display:inline\" class=\"low\">".abs($dep).$current->get_tempunit()."</span>")), 
	get_query_edited_url($url_cur, 'section', FILE_THIS_MONTH));
}
//update_action ("Warmer", $extrainfo, $ALT);



    $sub = $_GET['sub'];
   
?>