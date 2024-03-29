<?php
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
function CalcCarCleaning ($dust, $idx_check){
	global $forecastDaysDB, $todayForecast, $tomorrowForecast, $nextTomorrowForecast;
	
	if ($dust > 300)
		return false;
	if ($todayForecast->get_rainTo() > 0)
		return false;
	$idx_f = 0;
	foreach ($forecastDaysDB as $day_f){
		if ($idx_f <= ($idx_check + CAR_CLEANING_WORTH)){
			if ($day_f['dustDay'] > 200)
				return false;
			if ($day_f['rainTo'] > 0)
				return false;
		}
		$idx_f++;
	}
	return true;
}

function isGoingToRain(){
	return false;
}
function isBecomingWindy(){
	return false;
}
function isBecomingDusty(){
	return false;
}
function getRecommendations($timeframe, $idx,  $temp, $wind10min, $humidity, $rainperc, $dust, $uv)
{
	global $mem, $current, $todayForecast, $forecastHour, $hour, $forecastDaysDB, $TEMP, $RAIN_EXISTS_IN24HF, $DUST_EXISTS_IN24HF, $KMH, $HUMIDITY, $HIGH_DUST, $VERY_HOT_HEAT_WAVE, $DUST, $GOOD_TIME, $CHANCE_OF, $OPEN, $lang_idx, $REMOVE_LAUNDRY, $IN, $HIGH_UV, $HOURS, $HOT_GROUND, $HIGH_ET, $LOW_RAD, $NO_WIND, $WINDY, $RAIN, $hour, $random_good_time, $sig;
	$reco = array();
	
	$laundry_con = array();

	$laundry_con = get_laundry_index(0);
	$laundry_con_title_eng = $laundry_con[1];
	$laundry_addon_eng = $laundry_con[1]." (".($laundry_con[2] != "" ?  $REMOVE_LAUNDRY[$lang_idx]." ".$IN[$lang_idx]." ".$laundry_con[2]." ".$HOURS[$lang_idx]: "").")";
	$laundry_con = get_laundry_index(1);
	$laundry_con_title_heb = $laundry_con[1];
	$laundry_addon_heb = $laundry_con[1]." (".($laundry_con[2] != "" ?  $REMOVE_LAUNDRY[$lang_idx]." ".$IN[$lang_idx]." ".$laundry_con[2]." ".$HOURS[$lang_idx]: "").")";
	$laundry_addon = array($laundry_addon_eng, $laundry_addon_heb);
	$is_now = false;
	$is_sig_forecast = false;
	$nextSigForecast = $mem->get('nextSigForecast');
	$idx_f = 0;
	foreach ($forecastDaysDB as $day_f){
		if ($idx_f == $idx - 1){
			$dailyDust = $day_f['dustDay'];
			$dailyRainTo = $day_f['rainTo'];
			$dailyWindNight = $day_f['windNight'];
			$dailyiconNight = $day_f['iconnight'];
			$dailyWindMorning = $day_f['windMorning'];
		}
		$idx_f++;
	}
	
	if ((dustExistsNow())||(dustExistsIn24hf())||(rainExistsIn24hf()))
		$is_sig_forecast = true;
	if (($timeframe == TimeFrame::Hourly)&&(($idx == $hour)||($idx == $hour+1)))
		$is_now = true;

	if (($rainperc > 0)||($dust > 100)||
		($nextSigForecast['hrs']<8 && $is_now && $is_sig_forecast)||
		(($timeframe == TimeFrame::Daily)&&(($dailyRainTo > 0)||$dailyDust > 100))){
			if ($timeframe == TimeFrame::Daily){
				if ($dailyDust > 100)
					$sigRecommendation = array($DUST[0].":".$dailyDust, $DUST[1].":".$dailyDust);
				if ($dailyRainTo > 0)
					$sigRecommendation = array($RAIN[0].":".$dailyRainTo, $RAIN[1].":".$dailyRainTo);
			}
			else
				$sigRecommendation = $laundry_addon;
			array_push($reco, array('sig0' => $sigRecommendation[0], 'sig1' => $sigRecommendation[1], 'activity' => Activities::Laundry, 'value' => Recommendations::No, 'timeframe' => $timeframe, 'idx' => $idx));
	}
	else {
		array_push($reco, array('sig0' => '', 'sig1' => '', 'activity' => Activities::Laundry, 'value' => Recommendations::Yes, 'timeframe' => $timeframe, 'idx' => $idx));
	}

	if (($timeframe == TimeFrame::Daily) && (!CalcCarCleaning($dust, $idx))){
		$sigRecommendation = array($RAIN[0].", ".$HIGH_DUST[0], $RAIN[1].", ".$HIGH_DUST[1]);
		array_push($reco, array('sig0' => $sigRecommendation[0], 'sig1' => $sigRecommendation[1], 'activity' => Activities::CARCLEANING, 'value' => Recommendations::No, 'timeframe' => $timeframe));
	}
	else if (($timeframe == TimeFrame::Hourly) && (!$is_sig_forecast)&& (CalcCarCleaning($dust, $idx)))
	{
		array_push($reco, array('sig0' => "", 'sig1' => "", 'activity' => Activities::CARCLEANING, 'value' => Recommendations::Yes, 'timeframe' => $timeframe));
	}
	else if (($timeframe == TimeFrame::Hourly) && (($is_sig_forecast)|| (!CalcCarCleaning($dust, $idx))))
	{
		$sigRecommendation = array($RAIN_EXISTS_IN24HF[0][0].", ".$DUST_EXISTS_IN24HF[0][0], $RAIN_EXISTS_IN24HF[1][1].", ".$DUST_EXISTS_IN24HF[0][1]);
		array_push($reco, array('sig0' => $sigRecommendation[0], 'sig1' => $sigRecommendation[1], 'activity' => Activities::CARCLEANING, 'value' => Recommendations::No, 'timeframe' => $timeframe));
	}
	

	if ((($temp<17)&&($timeframe == TimeFrame::Hourly))&&
		(in_array($LOW_RAD, $sig)&&($timeframe == TimeFrame::Hourly))){
		array_push($reco, array('sig0' => $LOW_RAD[0], 'sig1' => $LOW_RAD[1], 'activity' => Activities::Boiler, 'value' => Recommendations::Yes, 'timeframe' => $timeframe));
	}

	if (($temp >= 35)||
		($temp > 32)&&($humidity>45)||
		($temp > 30)&&($humidity>60)){
			$sigRecommendation = array($TEMP[0].":".$temp."°, ".$HUMIDITY[0].":".$humidity."%", $TEMP[1].":".$temp."°, ".$HUMIDITY[1].":".$humidity."%");
		array_push($reco, array('sig0' => $sigRecommendation[0], 'sig1' => $sigRecommendation[1], 'activity' => Activities::AC, 'value' => Recommendations::Yes, 'timeframe' => $timeframe));
	}

	if ($temp < 14){
		$sigRecommendation = array($TEMP[0].":".$temp."°", $TEMP[1].":".$temp."°");
		array_push($reco, array('sig0' => $sigRecommendation[0], 'sig1' => $sigRecommendation[1], 'activity' => Activities::HEATER, 'value' => Recommendations::Yes, 'timeframe' => $timeframe));
	}

	if (in_array($HIGH_ET, $sig)&&($timeframe == TimeFrame::Hourly)){
		array_push($reco, array('sig0' => $HIGH_ET[0], 'sig1' => $HIGH_ET[1], 'activity' => Activities::IRRIGATION, 'value' => Recommendations::Yes, 'timeframe' => $timeframe));
	}

	if (($timeframe == TimeFrame::Hourly) && (($rainperc > 50) || ($temp >= 35) || (($temp > 32)&&($humidity>45))|| ($is_now && (in_array($HOT_GROUND, $sig))) || ($dust > 350 ))){
		if ($dust > 350 )
			$sigRecommendation = array($DUST[0].":".$dust, $DUST[1].":".$dust);
		if ($is_now && (in_array($HOT_GROUND, $sig)))
			$sigRecommendation = array($HOT_GROUND[0], $HOT_GROUND[1]);
		if (($temp > 32)&&($humidity>45) )
			$sigRecommendation = array($TEMP[0].":".$temp."°".", ".$HUMIDITY[0].":".$humidity."%", $TEMP[1].":".$temp."°".", ".$HUMIDITY[1].":".$humidity."%");
		if ($rainperc > 50)
			$sigRecommendation = array($CHANCE_OF[0].$RAIN[0].":".$rainperc."%", $CHANCE_OF[1].$RAIN[1].":".$rainperc."%");
	
		array_push($reco, array('sig0' => $sigRecommendation[0], 'sig1' => $sigRecommendation[1], 'activity' => Activities::Dog, 'value' => Recommendations::No, 'timeframe' => $timeframe));
   	} else if ($timeframe == TimeFrame::Hourly)
	   {
		array_push($reco, array('sig0' => '', 'sig1' => '', 'activity' => Activities::Dog, 'value' => Recommendations::Yes, 'timeframe' => $timeframe));
	   }

	if (($rainperc > 0)||($dust > 100)||($temp<22)&&($current->get_intemp()<22)||($temp>29)&&($current->get_intemp()>25)||
		($nextSigForecast['hrs']<3&&$is_now&&$is_sig_forecast)){
			if ($dust > 100 )
				$sigRecommendation = array($DUST[0].":".$dust, $DUST[1].":".$dust);
			if ($rainperc > 0)
				$sigRecommendation = array($CHANCE_OF[0].$RAIN[0].":".$rainperc."%" , $CHANCE_OF[1].$RAIN[1].":".$rainperc."%");
			if ((($temp<22)&&($current->get_intemp()<22)))
				$sigRecommendation = array($TEMP[0].":".$temp."°", $TEMP[1].":".$temp."°");
			if ((($temp>29)&&($current->get_intemp()>25)))
				$sigRecommendation = array($TEMP[0].":".$temp."°", $TEMP[1].":".$temp."°");
			if ($nextSigForecast['hrs']<3&&$is_now&&$is_sig_forecast)
				$sigRecommendation = array($TEMP[0].":".$temp.", ".$HUMIDITY[0].":".$humidity.", ".$CHANCE_OF[0].$RAIN[0].":".$rainperc.", ".$DUST[0].":".$dust, $TEMP[1].":".$temp.", ".$HUMIDITY[1].":".$humidity.", ".$CHANCE_OF[1].$RAIN[1].":".$rainperc.", ".$DUST[1].":".$dust);
			
			array_push($reco, array('sig0' => $sigRecommendation[0], 'sig1' => $sigRecommendation[1], 'activity' => Activities::OpenWindow, 'value' => Recommendations::No, 'timeframe' => $timeframe));
	}
	else if (isOpenOrClose()==$OPEN[$lang_idx]) {
		array_push($reco, array('sig0' => '', 'sig1' => '', 'activity' => Activities::OpenWindow, 'value' => Recommendations::Yes, 'timeframe' => $timeframe));
	}

	if (($dust > (($timeframe == TimeFrame::Hourly) ? 250 : 300))||
		($rainperc > 60)||
		($temp>33)||
		($wind10min > (($timeframe == TimeFrame::Daily) ? 30 : 40))){
			if ($temp>30)
			$sigRecommendation = array($TEMP[0].":".$temp, $TEMP[1].":".$temp);
			if ($rainperc > 60)
			$sigRecommendation = array($CHANCE_OF[0].$RAIN[0].":".$rainperc, $CHANCE_OF[1].$RAIN[1].":".$rainperc);
			if ($dust > (($timeframe == TimeFrame::Hourly) ? 250 : 300))
			$sigRecommendation = array($DUST[0].":".$dust, $DUST[1].":".$dust);
			if ($wind10min > (($timeframe == TimeFrame::Daily) ? 30 : 40))
			$sigRecommendation = array($WINDY[0].":".$wind10min, $WINDY[1].":".$wind10min);
		array_push($reco, array('sig0' => $sigRecommendation[0], 'sig1' => $sigRecommendation[1], 'activity' => Activities::Sport, 'value' => Recommendations::No, 'timeframe' => $timeframe));
	}else if ($timeframe == TimeFrame::Hourly)
	{
		array_push($reco, array('sig0' => $sigRecommendation[0], 'sig1' => $sigRecommendation[1], 'activity' => Activities::Sport, 'value' => Recommendations::Yes, 'timeframe' => $timeframe));
	}
		
	if ($wind10min > (($timeframe == TimeFrame::Daily) ? 30 : 40)||
		(($timeframe == TimeFrame::Hourly) ? ($dust > 200) : false)||
		(($timeframe == TimeFrame::Daily) ? ($dailyDust > 200) : false)||
		(($timeframe == TimeFrame::Daily) ? ($dailyRainTo > 3) : false)){
			if ($timeframe == TimeFrame::Daily)
				$sigRecommendation = array($RAIN[0].":".$dailyRainTo, $RAIN[1].":".$dailyRainTo);
			if (($timeframe == TimeFrame::Daily) ? ($dailyDust > 200) : false)
				$sigRecommendation = array($HIGH_DUST[0].":".$dailyDust, $HIGH_DUST[1].":".$dailyDust);
			if (($timeframe == TimeFrame::Hourly) ? ($dust > 200) : false)
				$sigRecommendation = array($HIGH_DUST[0].":".$dust, $HIGH_DUST[1].":".$dust);
			if ($wind10min > (($timeframe == TimeFrame::Daily) ? 30 : 40))
				$sigRecommendation = array($WINDY[0].":".$wind10min, $WINDY[1].":".$wind10min);
		array_push($reco, array('sig0' => $sigRecommendation[0], 'sig1' => $sigRecommendation[1], 'activity' => Activities::Bicycle, 'value' => Recommendations::No, 'timeframe' => $timeframe));
	}
	else if ($timeframe == TimeFrame::Daily){
		array_push($reco, array('sig0' => '', 'sig1' => '', 'activity' => Activities::Bicycle, 'value' => Recommendations::Yes, 'timeframe' => $timeframe));
	}
		
	if ((($rainperc > 10)&&($wind10min > 10))||
		(($timeframe == TimeFrame::Daily) ? ($dailyWindNight > 15) : false)||
		(($timeframe == TimeFrame::Daily) ? ($dailyWindMorning > 15) : false)||
		(($timeframe == TimeFrame::Daily) ? ($dailyRainTo > 2) : false)){
			if (($timeframe == TimeFrame::Daily) ? ($dailyWindNight > 15) : false)
				$sigRecommendation = array($WINDY[0].":".$dailyWindNight, $WINDY[1].":".$dailyWindNight);
			if (($timeframe == TimeFrame::Daily) ? ($dailyWindMorning > 15) : false)
				$sigRecommendation = array($WINDY[0].":".$dailyWindMorning, $WINDY[1].":".$dailyWindMorning);
			if (($timeframe == TimeFrame::Daily) ? ($dailyRainTo > 2) : false)
				$sigRecommendation = array($RAIN[0].":".$dailyRainTo, $RAIN[1].":".$dailyRainTo);
			if (($rainperc > 10)&&($wind10min > 10))
				$sigRecommendation = array($WINDY[0].":".$wind10min, $WINDY[1].":".$wind10min);
		array_push($reco, array('sig0' => $sigRecommendation[0], 'sig1' => $sigRecommendation[1], 'activity' => Activities::Camping, 'value' => Recommendations::No, 'timeframe' => $timeframe));
	}
	else{
		array_push($reco, array('sig0' => '', 'sig1' => '', 'activity' => Activities::Camping, 'value' => Recommendations::Yes, 'timeframe' => $timeframe));
	}
	
	if ((($timeframe == TimeFrame::Daily) ? ($dailyWindNight > 10) : false)||
		(($timeframe == TimeFrame::Daily) ? (strpos($dailyiconNight,'rain') > 0) : false)){
			if ($timeframe == TimeFrame::Daily)
				$sigRecommendation = array($RAIN[0].":".$dailyRainTo."mm, ".$WINDY[0].":".$dailyWindNight.$KMH[0], $RAIN[1].":".$dailyRainTo."mm, ".$WINDY[1].":".$dailyWindNight.$KMH[1]);
		array_push($reco, array('sig0' => $sigRecommendation[0], 'sig1' => $sigRecommendation[1], 'activity' => Activities::DinnerAtBalcony, 'value' => Recommendations::No, 'timeframe' => $timeframe));
	}
	else if (($timeframe == TimeFrame::Daily)){
		$sigRecommendation = array($NO_WIND[0], $NO_WIND[1]);
		array_push($reco, array('sig0' => $sigRecommendation[0], 'sig1' => $sigRecommendation[1], 'activity' => Activities::DinnerAtBalcony, 'value' => Recommendations::Yes, 'timeframe' => $timeframe));
	}	

	if (($rainperc > 10)||
		($dust > 200)||
		(($timeframe == TimeFrame::Daily) ? ($dailyWindNight > 20) : false)||
		($nextSigForecast['hrs']<3&&$is_now&&$is_sig_forecast)){
			if (($timeframe == TimeFrame::Daily) ? ($dailyWindNight > 20) : false)
			$sigRecommendation = array($RAIN[0].":".$dailyRainTo.", ".$WINDY[0].":".$dailyWindNight.$KMH[0], $RAIN[1].":".$dailyRainTo."mm".", ".$WINDY[1].":".$dailyWindNight.$KMH[1]);
			if ($nextSigForecast['hrs']<3&&$is_now&&$is_sig_forecast)
			$sigRecommendation = array($RAIN[0].":".$dailyRainTo.", ".$WINDY[0].":".$dailyWindNight.$KMH[0], $RAIN[1].":".$dailyRainTo."mm, ".$WINDY[1].":".$dailyWindNight.$KMH[1]);
			if ($dust > 200)
			$sigRecommendation = array($DUST[0].":".$dust, $DUST[1].":".$dust);
			if ($rainperc > 10)
			$sigRecommendation = array($CHANCE_OF[0].$RAIN[0].":".$rainperc."%", $CHANCE_OF[1].$RAIN[1].":".$rainperc."%");
		array_push($reco, array('sig0' => $sigRecommendation[0], 'sig1' => $sigRecommendation[1], 'activity' => Activities::CAMPFIRE, 'value' => Recommendations::No, 'timeframe' => $timeframe));
	}

	if (($rainperc > 0)||
		($dust > 200)||
		($temp>32)||
		($wind10min > (($timeframe == TimeFrame::Daily) ? 30 : 20))||
		($nextSigForecast['hrs']<3&&$is_now&&$is_sig_forecast)){
			if ($wind10min > (($timeframe == TimeFrame::Daily) ? 30 : 20))
			$sigRecommendation = array($WINDY[0].":".$wind10min.$KMH[0], $WINDY[1].":".$wind10min.$KMH[1]);
			if ($nextSigForecast['hrs']<3&&$is_now&&$is_sig_forecast)
			$sigRecommendation = array($RAIN[0].":".$dailyRainTo.", ".$WINDY[0].":".$dailyWindNight.$KMH[0], $RAIN[1].":".$dailyRainTo."mm, ".$WINDY[1].":".$dailyWindNight.$KMH[1]);
			if ($dust > 200)
			$sigRecommendation = array($DUST[0].":".$dust, $DUST[1].":".$dust);
			if ($temp>32)
			$sigRecommendation = array($TEMP[0].":".$temp."°", $TEMP[1].":".$temp."°");
			if ($rainperc > 0)
			$sigRecommendation = array($CHANCE_OF[0].$RAIN[0].":".$rainperc."%", $CHANCE_OF[1].$RAIN[1].":".$rainperc."%");
		array_push($reco, array('sig0' => $sigRecommendation[0], 'sig1' => $sigRecommendation[1], 'activity' => Activities::Picnic, 'value' => Recommendations::No, 'timeframe' => $timeframe));
	}
	else if ((($timeframe == TimeFrame::Hourly) ? (in_array($GOOD_TIME[$random_good_time], $sig)) : false)) {
		array_push($reco, array('sig0' => '', 'sig1' => '', 'activity' => Activities::Picnic, 'value' => Recommendations::Yes, 'timeframe' => $timeframe));
	}
	

	if (($rainperc > 30)||
		($temp>32)||
		(($timeframe == TimeFrame::Hourly) ? (in_array($HIGH_UV, $sig)) : false)||
		($wind10min > (($timeframe == TimeFrame::Daily) ? 40 : 35))||
		(($timeframe == TimeFrame::Daily) ? ($dailyDust > 100) : false)||
		($dust > 100)||
		($nextSigForecast['hrs']<3&&$is_now&&$is_sig_forecast)){
			if ($wind10min > (($timeframe == TimeFrame::Daily) ? 30 : 20))
			$sigRecommendation = array($WINDY[0].":".$wind10min.$KMH[0], $WINDY[1].":".$wind10min.$KMH[1]);
			if ($nextSigForecast['hrs']<3&&$is_now&&$is_sig_forecast)
			$sigRecommendation = array($RAIN[0].":".$dailyRainTo.", ".$WINDY[0].":".$dailyWindNight.$KMH[0], $RAIN[1].":".$dailyRainTo."mm, ".$WINDY[1].":".$dailyWindNight.$KMH[1]);
			if (($dust > 100)||(($timeframe == TimeFrame::Daily) ? ($dailyDust > 100) : false))
			$sigRecommendation = array($DUST[0].":".$dust, $DUST[1].":".$dust);
			if ($temp>32)
			$sigRecommendation = array($TEMP[0].":".$temp."°", $TEMP[1].":".$temp."°");
			if ($rainperc > 30)
			$sigRecommendation = array($CHANCE_OF[0].$RAIN[0].":".$rainperc."%", $CHANCE_OF[1].$RAIN[1].":".$rainperc."%");
			if (($timeframe == TimeFrame::Hourly) ? (in_array($HIGH_UV, $sig)) : false)
			$sigRecommendation = array($HIGH_UV[0], $HIGH_UV[1]);
		array_push($reco, array('sig0' => $sigRecommendation[0], 'sig1' => $sigRecommendation[1], 'activity' => Activities::CHILDRENS, 'value' => Recommendations::No, 'timeframe' => $timeframe));
	}
	else
		array_push($reco, array('sig0' => '', 'sig1' => '', 'activity' => Activities::CHILDRENS, 'value' => Recommendations::Yes, 'timeframe' => $timeframe));

	if (($rainperc > 30)||
		($temp>32)||
		($wind10min > (($timeframe == TimeFrame::Daily) ? 40 : 35))||
		(($timeframe == TimeFrame::Daily) ? ($dailyDust > 400) : false)||
		($dust > 500)){
			if ($wind10min > (($timeframe == TimeFrame::Daily) ? 40 : 35))
			$sigRecommendation = array($WINDY[0].":".$wind10min.$KMH[0], $WINDY[1].":".$wind10min.$KMH[1]);
			if ($nextSigForecast['hrs']<3&&$is_now&&$is_sig_forecast)
			$sigRecommendation = array($RAIN[0].":".$dailyRainTo.", ".$WINDY[0].":".$dailyWindNight.$KMH[0], $RAIN[1].":".$dailyRainTo."mm, ".$WINDY[1].":".$dailyWindNight.$KMH[1]);
			if (($timeframe == TimeFrame::Daily) ? ($dailyDust > 400) : false)
			$sigRecommendation = array($DUST[0].":".$dailyDust, $DUST[1].":".$dailyDust);
			if ($dust > 500)
			$sigRecommendation = array($DUST[0].":".$dust, $DUST[1].":".$dust);
			if ($temp>32)
			$sigRecommendation = array($TEMP[0].":".$temp."°", $TEMP[1].":".$temp."°");
			if ($rainperc > 30)
			$sigRecommendation = array($CHANCE_OF[0].$RAIN[0].":".$rainperc."%", $CHANCE_OF[1].$RAIN[1].":".$rainperc."%");
		array_push($reco, array('sig0' => $sigRecommendation[0], 'sig1' => $sigRecommendation[1], 'activity' => Activities::EVENTOUTSIDE, 'value' => Recommendations::No, 'timeframe' => $timeframe));
	}
	else if (($rainperc < 10)&&
	($wind10min < (($timeframe == TimeFrame::Daily) ? 25 : 15))&&
	($dust < 130)) {
		if ($timeframe == TimeFrame::Daily)
			
		array_push($reco, array('sig0' => '', 'sig1' => '', 'activity' => Activities::EVENTOUTSIDE, 'value' => Recommendations::Yes, 'timeframe' => $timeframe));
	}

	if (($wind10min > (($timeframe == TimeFrame::Daily) ? 50 : 45))||
		(($timeframe == TimeFrame::Daily) ? ($dailyDust > 300) : false)||
		($dust > 300)||
		($nextSigForecast['hrs']<3&&$is_now&&$is_sig_forecast)){
			if ($wind10min > (($timeframe == TimeFrame::Daily) ? 50 : 45))
			$sigRecommendation = array($WINDY[0].":".$wind10min.$KMH[0], $WINDY[1].":".$wind10min.$KMH[1]);
			if ($nextSigForecast['hrs']<3&&$is_now&&$is_sig_forecast)
			$sigRecommendation = array($RAIN[0].":".$dailyRainTo.", ".$WINDY[0].":".$dailyWindNight.$KMH[0], $RAIN[1].":".$dailyRainTo."mm, ".$WINDY[1].":".$dailyWindNight.$KMH[1]);
			if (($timeframe == TimeFrame::Daily) ? ($dailyDust > 300) : false)
			$sigRecommendation = array($DUST[0].":".$dailyDust, $DUST[1].":".$dailyDust);
			if ($dust > 300)
			$sigRecommendation = array($DUST[0].":".$dust, $DUST[1].":".$dust);
			
		array_push($reco, array('sig0' => $sigRecommendation[0], 'sig1' => $sigRecommendation[1], 'activity' => Activities::GAZELLEPARK, 'value' => Recommendations::No, 'timeframe' => $timeframe));
	}
	else if (($wind10min < (($timeframe == TimeFrame::Daily) ? 40 : 35))&&
	($dust < 100)) {
		
		array_push($reco, array('sig0' => '', 'sig1' => '', 'activity' => Activities::GAZELLEPARK, 'value' => Recommendations::Yes, 'timeframe' => $timeframe));
	}
	
	

	if (($rainperc > 50)||
		($dust > 500)){
			if ($rainperc > 50)
			$sigRecommendation = array($CHANCE_OF[0].$RAIN[0].":".$rainperc."%", $CHANCE_OF[1].$RAIN[1].":".$rainperc."%");
			if ($dust > 500)
			$sigRecommendation = array($DUST[0].":".$dust, $DUST[1].":".$dust);
		array_push($reco, array('sig0' => $sigRecommendation[0], 'sig1' => $sigRecommendation[1], 'activity' => Activities::TEDY, 'value' => Recommendations::No, 'timeframe' => $timeframe));
	}

	if (($rainperc > 50)||
		($wind10min > (($timeframe == TimeFrame::Daily) ? 40 : 35))||
		($dust > 500)||
		($nextSigForecast['hrs']<3&&$is_now&&$is_sig_forecast)){
			if ($rainperc > 50)
			$sigRecommendation = array($CHANCE_OF[0].$RAIN[0].":".$rainperc."%", $CHANCE_OF[1].$RAIN[1].":".$rainperc."%");
			if ($dust > 500)
			$sigRecommendation = array($DUST[0].":".$dust, $DUST[1].":".$dust);
			if ($nextSigForecast['hrs']<3&&$is_now&&$is_sig_forecast)
			$sigRecommendation = array($RAIN[0].":".$dailyRainTo.", ".$WINDY[0].":".$dailyWindNight.$KMH[0], $RAIN[1].":".$dailyRainTo."mm, ".$WINDY[1].":".$dailyWindNight.$KMH[1]);
			if ($wind10min > (($timeframe == TimeFrame::Daily) ? 40 : 35))
			$sigRecommendation = array($WINDY[0].":".$wind10min.$KMH[0], $WINDY[1].":".$wind10min.$KMH[1]);
			
		array_push($reco, array('sig0' => $sigRecommendation[0], 'sig1' => $sigRecommendation[1], 'activity' => Activities::WESTERNWALL, 'value' => Recommendations::No, 'timeframe' => $timeframe));
	}

	if (($rainperc > 10)||
		($wind10min > (($timeframe == TimeFrame::Daily) ? 25 : 15))||
		($dust > 200)||
		($temp>32)||
		($nextSigForecast['hrs']<3&&$is_now&&$is_sig_forecast)){
			if ($rainperc > 10)
			$sigRecommendation = array($CHANCE_OF[0].$RAIN[0].":".$rainperc."%", $CHANCE_OF[1].$RAIN[1].":".$rainperc."%");
			if ($dust > 200)
			$sigRecommendation = array($DUST[0].":".$dust, $DUST[1].":".$dust);
			if ($nextSigForecast['hrs']<3&&$is_now&&$is_sig_forecast)
			$sigRecommendation = array($RAIN[0].":".$dailyRainTo.", ".$WINDY[0].":".$dailyWindNight.$KMH[0], $RAIN[1].":".$dailyRainTo."mm, ".$WINDY[1].":".$dailyWindNight.$KMH[1]);
			if ($temp>32)
			$sigRecommendation = array($TEMP[0].":".$temp."°", $TEMP[1].":".$temp."°");
			if ($wind10min > (($timeframe == TimeFrame::Daily) ? 25 : 15))
			$sigRecommendation = array($WINDY[0].":".$wind10min.$KMH[0], $WINDY[1].":".$wind10min.$KMH[1]);
			
		array_push($reco, array('sig0' => $sigRecommendation[0], 'sig1' => $sigRecommendation[1], 'activity' => Activities::YOGA, 'value' => Recommendations::No, 'timeframe' => $timeframe));
	}
	else
	{
		array_push($reco, array('sig0' => '', 'sig1' => '', 'activity' => Activities::YOGA, 'value' => Recommendations::Yes, 'timeframe' => $timeframe));
	}

	if (($rainperc > 50)||
		($wind10min > (($timeframe == TimeFrame::Daily) ? 40 : 35))){
			if ($rainperc > 50)
			$sigRecommendation = array($CHANCE_OF[0].$RAIN[0].":".$rainperc."%", $CHANCE_OF[1].$RAIN[1].":".$rainperc."%");
			if ($wind10min > (($timeframe == TimeFrame::Daily) ? 40 : 35))
			$sigRecommendation = array($WINDY[0].":".$wind10min.$KMH[0], $WINDY[1].":".$wind10min.$KMH[1]);
		array_push($reco, array('sig0' => $sigRecommendation[0], 'sig1' => $sigRecommendation[1], 'activity' => Activities::SACKER, 'value' => Recommendations::No, 'timeframe' => $timeframe));
	}
	else
	{
		array_push($reco, array('sig0' => '', 'sig1' => '', 'activity' => Activities::SACKER, 'value' => Recommendations::Yes, 'timeframe' => $timeframe));
	}
	
	
	
	return $reco;
}
function updateRecommendations($sigW, $r, $v)
{
	global $recommendations;
	array_push($recommendations, array('sig' => $sigW, 'activity' => $r, 'value' => $v));
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
$recommendations = array();
$extrainfo = array();
$extrainfoS = array();
$sig = array();
$primarySig = array();
$dew_over_night = false;
$isHeatWave = false;
$url= get_query_edited_url(get_url(), 'section', 'extended');
$forecastHour = $mem->get('forecasthour');
$current->set_rainchance(0);
foreach ($forecastHour as $hour_f){
	if ((abs($hour_f['currentDateTime']) - time()) < 3000){
		if ($_GET['debug'] > 0)
			echo "<br/>currentDateTime=".date("H:i", $hour_f['currentDateTime'])."~".date("H:i", time())." rain:".$hour_f['rain']."% cloud:". $hour_f['cloudiness']." time:".$hour_f['time'];
		$current->set_rainchance($hour_f['rain']);
		$mem->set("cloudiness", $hour_f['cloudiness']);
		break;
	}
	else if ($_GET['debug'] > 0)
		echo "<br/>currentDateTime=".date("H:i", $hour_f['currentDateTime'])."!~".date("H:i", time())." rain:".$hour_f['rain']."% cloud:". $hour_f['cloudiness']." time:".$hour_f['time'];
}

///////////////////////////  hightemp ////////////////////////////
if (($today->get_hightemp() == $thisYear->get_hightemp())
	&&($today->get_hightemp() - $current->get_temp() > 1.5))
		setBrokenData("yearly", "high", 
					  $today->get_hightemp()."°"." ".$AT[$lang_idx]." ".$today->get_hightemp_time(), 
					  "temp");
else if (($today->get_hightemp() == $thisMonth->get_hightemp())
	    &&($today->get_hightemp() - $current->get_temp() > 1.5))
			setBrokenData("monthly", "high", 
							$today->get_hightemp()."°"." ".$AT[$lang_idx]." ".$today->get_hightemp_time(), 
							"temp");
///////////////////////////  lowtemp ////////////////////////////
if (($today->get_lowtemp() == $thisYear->get_lowtemp())
    &&($today->get_lowtemp() - $current->get_temp() < -1.5))
		setBrokenData("yearly", "low", 
					  $today->get_lowtemp()."°"." ".$AT[$lang_idx]." ".$today->get_lowtemp_time(), 
					  "temp");
else if (($today->get_lowtemp() == $thisMonth->get_lowtemp())
         &&($today->get_lowtemp() - $current->get_temp() < -1.5))
			setBrokenData("monthly", "low", 
						  $today->get_lowtemp()."°"." ".$AT[$lang_idx]." ".$today->get_lowtemp_time(), 
							"temp");
///////////////////////////  highrainrate ////////////////////////////
if (($today->get_highrainrate() !== "0.0") 
    &&($today->get_highrainrate() !== "")
     &&($today->get_highrainrate() > 0.3)){
	  if ($today->get_highrainrate() >= $thisYear->get_highrainrate())
		 setBrokenData("yearly", "high", 
						$today->get_highrainrate()." ".$RAINRATE_UNIT[$lang_idx]." ".$AT[$lang_idx]." ".$today->get_highrainrate_time(), 
						"rainrate");
	  else if (($today->get_highrainrate() >= $thisMonth->get_highrainrate()) 
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
					  $today->get_highbar()." ".$MB[$lang_idx], 
					  "pressure");
else if (($today->get_highbar() === $thisMonth->get_highbar())
         &&($min30->get_prschange() < -0.4))
            setBrokenData("monthly", "high", 
							$today->get_highbar()." ".$MB[$lang_idx], 
							"pressure");
///////////////////////////  lowbar ////////////////////////////
if (($today->get_lowbar() === $thisYear->get_lowbar())
    &&($min30->get_prschange() > 0.4))
		setBrokenData("yearly", "low", 
					 $today->get_lowbar()." ".$MB[$lang_idx], 
					 "pressure");
else if (($today->get_lowbar() === $thisMonth->get_lowbar())
         &&($min30->get_prschange() > 0.4))
			setBrokenData("monthly", "low", 
						  $today->get_lowbar()." ".$MB[$lang_idx], 
						"pressure");
///////////////////////////  highwind ////////////////////////////        
if (($today->get_highwind() == $thisYear->get_highwind())
   &&($min30->get_windspdchange() < -4) 
   &&($today->get_highwind() != ""))
		setBrokenData("yearly", "high",  
						$today->get_highwind()." ".$KMH[$lang_idx]." ".$AT[$lang_idx]." ".$today->get_highwind_time(), 
						"wind");
else if (($today->get_highwind() == $thisMonth->get_highwind())
		&&($min30->get_windspdchange() < -4))
			setBrokenData("monthly", "high", 
							$today->get_highwind()." ".$KMH[$lang_idx]." ".$AT[$lang_idx]." ".$today->get_highwind_time(), 
							"wind");


      /************************************************************************/

$latestalert_passedts = time() - $mem->get('latestalerttime1');
$LATEST_ALERT = array(explode("\n", strip_tags($mem->get('latestalert0'))), explode("\n",strip_tags($mem->get('latestalert1'))));
$LATEST_ALERT_TITLE = array(str_replace('"', "", $mem->get('latestalert_title0')), str_replace('"', "", $mem->get('latestalert_title1')));
$LATEST_ALERT_BODY = array(str_replace("\n", "",replaceDays(date('D H:i ', $mem->get('latestalerttime1')))." ".$LATEST_ALERT[$EN][0]." ".$LATEST_ALERT[$EN][2]), 
                           str_replace("\n", "",replaceDays(date('D H:i ', $mem->get('latestalerttime1')))." ".$LATEST_ALERT[$HEB][0]." ".$LATEST_ALERT[$HEB][2]), 
                           str_replace("\n", "",$LATEST_ALERT[$RU][0]." ".$LATEST_ALERT[$RU][2]), 
                           str_replace("\n", "",$LATEST_ALERT[$FR][0]." ".$LATEST_ALERT[$FR][2]), 
                           str_replace("\n", "",$LATEST_ALERT[$AR][0]." ".$LATEST_ALERT[$AR][2]));
$LATEST_ALERT_BODY_CUT = array(mb_substr($LATEST_ALERT_BODY[$EN], 0, 105, "UTF-8"), 
							   mb_substr($LATEST_ALERT_BODY[$HEB], 0, 105, "UTF-8"), 
							   mb_substr($LATEST_ALERT_BODY[$RU], 0, 105, "UTF-8"), 
							   mb_substr($LATEST_ALERT_BODY[$FR], 0, 105, "UTF-8"), 
							   mb_substr($LATEST_ALERT_BODY[$AR], 0, 105, "UTF-8"));

if ((max($today->get_highrainrate(),$today->get_highrainrate2())  == "0.2") && 
    ($current->get_rainrate() == "0.0")&&(IS_SNOWING != 1))
{
	  $dew_over_night = true;
}
/*if ($current->get_hum() > 99)
{
	updateSigWeather(
		"fog1.jpg", 
		$FOG, 
		array($HUMIDITY[$EN].": ".$current->get_hum(), $HUMIDITY[$HEB].": ".$current->get_hum()), "?section=graph.php&amp;graph=OutsideHumidityHistory.gif&amp;profile=2");
    //update_action ("Fog", $extrainfo, $ALT);
}*/
if (($latestalert_passedts < 3600)&&(!empty(trim($LATEST_ALERT_BODY_CUT[$HEB]))))
{
	/*updateSigWeather(
		"profile1/rain.php?level=1&freq=1&amp;lang={$lang_idx}", 
		$LATEST_ALERT_TITLE, 
		array(array($LATEST_ALERT_BODY_CUT[$EN],$LATEST_ALERT_BODY_CUT[$EN]), 
				array($LATEST_ALERT_BODY_CUT[$HEB],$LATEST_ALERT_BODY_CUT[$HEB]), 
				array($LATEST_ALERT_BODY_CUT[$RU],$LATEST_ALERT_BODY_CUT[$RU]), 
				array($LATEST_ALERT_BODY_CUT[$FR],$LATEST_ALERT_BODY_CUT[$FR]), 
				array($LATEST_ALERT_BODY_CUT[$AR],$LATEST_ALERT_BODY_CUT[$AR])), 
                "?section=alerts&amp;lang={$lang_idx}");*/
}

if (($hour < 10)&&($dew_over_night))
{
	updateSigWeather(
		"hum.jpg", 
		$HIGH_DEW_OVER_NIGHT, 
		array(array($today->get_highhum()." ".$HUMIDITY[$EN],$today->get_highhum()." ".$HUMIDITY[$EN]), 
                      array($today->get_highhum()." ".$HUMIDITY[$HEB],$today->get_highhum()." ".$HUMIDITY[$HEB]), 
                      array($today->get_highhum()." ".$HUMIDITY[$RU],$today->get_highhum()." ".$HUMIDITY[$RU]), 
                      array($today->get_highhum()." ".$HUMIDITY[$FR],$today->get_highhum()." ".$HUMIDITY[$FR]), 
                      array($today->get_highhum()." ".$HUMIDITY[$AR],$today->get_highhum()." ".$HUMIDITY[$AR])), 
                "?section=graph&amp;graph=OutsideHumidityHistory.gif&amp;profile=2");
}
if (isRaining()||(IS_SNOWING == 1))
{
	$rainOrSnow = $ITS_RAINING;
	if (($current->get_rainrate2() > 20)||($current->get_windspd() > 26))
		$rainOrSnow =  $STORMY;
	if (isSnowing())
		$rainOrSnow =  $ITS_SNOWING;
	updateSigWeather(
		"rain1.jpg", 
		$rainOrSnow, 
		array(array($current->get_rainrate2()." ".$RAINRATE_UNIT[$EN].", ".$DAILY_RAIN[$EN].": ".$today->get_rain2().$RAIN_UNIT[$EN], 
					$current->get_rainrate2()." ".$RAINRATE_UNIT[$EN].", ".$DAILY_RAIN[$EN].": ".$today->get_rain2().$RAIN_UNIT[$EN]), 
              array($current->get_rainrate2()." ".$RAINRATE_UNIT[$HEB].", ".$DAILY_RAIN[$HEB].": ".$today->get_rain2()." ".$RAIN_UNIT[$HEB], 
			  	    $current->get_rainrate2()." ".$RAINRATE_UNIT[$HEB].", ".$DAILY_RAIN[$HEB].": ".$today->get_rain2()." ".$RAIN_UNIT[$HEB]), 
			   array($current->get_rainrate2()." ".$RAINRATE_UNIT[$RU].", ".$DAILY_RAIN[$RU].": ".$today->get_rain2()." ".$RAIN_UNIT[$RU], 
					 $current->get_rainrate2()." ".$RAINRATE_UNIT[$RU].", ".$DAILY_RAIN[$RU].": ".$today->get_rain2()." ".$RAIN_UNIT[$RU]), 
			   array($current->get_rainrate2()." ".$RAINRATE_UNIT[$FR].", ".$DAILY_RAIN[$FR].": ".$today->get_rain2()." ".$RAIN_UNIT[$FR], 
					 $current->get_rainrate2()." ".$RAINRATE_UNIT[$FR].", ".$DAILY_RAIN[$FR].": ".$today->get_rain2()." ".$RAIN_UNIT[$FR]), 
			   array($current->get_rainrate2()." ".$RAINRATE_UNIT[$AR].", ".$DAILY_RAIN[$AR].": ".$today->get_rain2()." ".$RAIN_UNIT[$AR], 
					$current->get_rainrate2()." ".$RAINRATE_UNIT[$AR].", ".$DAILY_RAIN[$AR].": ".$today->get_rain2()." ".$RAIN_UNIT[$AR])), 
				"?section=graph&amp;graph=rain.php&amp;profile=1");
	if ($hour > 7)
    	update_action ("RainStarted", $extrainfo, $ALT);
}
if (($rainrateHour !== "0.0") && 
		 (!isRaining()) && 
		 (!$dew_over_night))
{
	updateSigWeather(
		"profile1/rain.php?level=1&freq=1&amp;lang={$lang_idx}", 
		$RAIN_HAS_JUST_STOPPED, 
		array(array($DAILY_RAIN[$EN].": ".$today->get_rain2().$RAIN_UNIT[$lang_idx].", ".$TOTAL_RAIN[$EN].": ".$seasonTillNow->get_rain2()." ".$RAIN_UNIT[$EN], 
					$DAILY_RAIN[$EN].": ".$today->get_rain2().$RAIN_UNIT[$EN].", ".$TOTAL_RAIN[$EN].": ".$seasonTillNow->get_rain2()." ".$RAIN_UNIT[$EN]), 
			array($DAILY_RAIN[$HEB].": ".$today->get_rain2()." ".$RAIN_UNIT[$HEB].", ".$TOTAL_RAIN[$HEB].": ".$seasonTillNow->get_rain2()." ".$RAIN_UNIT[$HEB], 
				 $DAILY_RAIN[$HEB].": ".$today->get_rain2()." ".$RAIN_UNIT[$HEB].", ".$TOTAL_RAIN[$HEB].": ".$seasonTillNow->get_rain2()." ".$RAIN_UNIT[$HEB]), 
			array($DAILY_RAIN[$RU].": ".$today->get_rain2()." ".$RAIN_UNIT[$RU].", ".$TOTAL_RAIN[$RU].": ".$seasonTillNow->get_rain2()." ".$RAIN_UNIT[$RU], 
				  $DAILY_RAIN[$RU].": ".$today->get_rain2()." ".$RAIN_UNIT[$RU].", ".$TOTAL_RAIN[$RU].": ".$seasonTillNow->get_rain2()." ".$RAIN_UNIT[$RU]), 
			array($DAILY_RAIN[$FR].": ".$today->get_rain2()." ".$RAIN_UNIT[$FR].", ".$TOTAL_RAIN[$FR].": ".$seasonTillNow->get_rain2()." ".$RAIN_UNIT[$FR], 
				  $DAILY_RAIN[$FR].": ".$today->get_rain2()." ".$RAIN_UNIT[$FR].", ".$TOTAL_RAIN[$FR].": ".$seasonTillNow->get_rain2()." ".$RAIN_UNIT[$FR]), 
			array($DAILY_RAIN[$AR].": ".$today->get_rain2()." ".$RAIN_UNIT[$AR].", ".$TOTAL_RAIN[$AR].": ".$seasonTillNow->get_rain2()." ".$RAIN_UNIT[$AR], 
				  $DAILY_RAIN[$AR].": ".$today->get_rain2()." ".$RAIN_UNIT[$AR].", ".$TOTAL_RAIN[$AR].": ".$seasonTillNow->get_rain2()." ".$RAIN_UNIT[$AR])), 
                "?section=graph&amp;graph=rain.php&amp;profile=1");
     //update_action ("RainStopped", $extrainfo, $ALT);
}
else if (($today->get_highrainrate() !== "0.0") && 
		 (!isRaining()) && 
		 (!$dew_over_night)&&
		 (($today->get_rain2() > 0.3)&&
		 ($current->get_rainrate2() == 0)))
{
	updateSigWeather(
		"profile1/rain.php?level=1&freq=1&amp;lang={$lang_idx}", 
		$RAIN_HAS_GONE, 
		array(array($DAILY_RAIN[$EN].": ".$today->get_rain2().$RAIN_UNIT[$lang_idx].", ".$TOTAL_RAIN[$EN].": ".$seasonTillNow->get_rain2()." ".$RAIN_UNIT[$EN], 
					$DAILY_RAIN[$EN].": ".$today->get_rain2().$RAIN_UNIT[$EN].", ".$TOTAL_RAIN[$EN].": ".$seasonTillNow->get_rain2()." ".$RAIN_UNIT[$EN]), 
			array($DAILY_RAIN[$HEB].": ".$today->get_rain2()." ".$RAIN_UNIT[$HEB].", ".$TOTAL_RAIN[$HEB].": ".$seasonTillNow->get_rain2()." ".$RAIN_UNIT[$HEB], 
				  $DAILY_RAIN[$HEB].": ".$today->get_rain2()." ".$RAIN_UNIT[$HEB].", ".$TOTAL_RAIN[$HEB].": ".$seasonTillNow->get_rain2()." ".$RAIN_UNIT[$HEB]), 
			array($DAILY_RAIN[$RU].": ".$today->get_rain2()." ".$RAIN_UNIT[$RU].", ".$TOTAL_RAIN[$RU].": ".$seasonTillNow->get_rain2()." ".$RAIN_UNIT[$RU], 
				  $DAILY_RAIN[$RU].": ".$today->get_rain2()." ".$RAIN_UNIT[$RU].", ".$TOTAL_RAIN[$RU].": ".$seasonTillNow->get_rain2()." ".$RAIN_UNIT[$RU]), 
			array($DAILY_RAIN[$FR].": ".$today->get_rain2()." ".$RAIN_UNIT[$FR].", ".$TOTAL_RAIN[$FR].": ".$seasonTillNow->get_rain2()." ".$RAIN_UNIT[$FR], 
				  $DAILY_RAIN[$FR].": ".$today->get_rain2()." ".$RAIN_UNIT[$FR].", ".$TOTAL_RAIN[$FR].": ".$seasonTillNow->get_rain2()." ".$RAIN_UNIT[$FR]), 
			array($DAILY_RAIN[$AR].": ".$today->get_rain2()." ".$RAIN_UNIT[$AR].", ".$TOTAL_RAIN[$AR].": ".$seasonTillNow->get_rain2()." ".$RAIN_UNIT[$AR], 
				  $DAILY_RAIN[$AR].": ".$today->get_rain2()." ".$RAIN_UNIT[$AR].", ".$TOTAL_RAIN[$AR].": ".$seasonTillNow->get_rain2()." ".$RAIN_UNIT[$AR])), 
              "?section=graph&amp;graph=rain.php&amp;profile=1");
}

if (($current->get_temp('C') < 3)&&($current->get_temp() != ""))
{
	updateSigWeather(
		"cold.gif", 
		$VERY_COLD, 
		array(array($TEMP[$EN].": ".$current->get_temp()."°",
					$TEMP[$EN].": ".$current->get_temp()."°"), 
                      array($TEMP[$HEB].": ".$current->get_temp()."°",
					  		$TEMP[$HEB].": ".$current->get_temp()."°"), 
                      array($TEMP[$RU].": ".$current->get_temp()."°",
					  		$TEMP[$RU].": ".$current->get_temp()."°"), 
                      array($TEMP[$FR].": ".$current->get_temp()."°",
					  		$TEMP[$FR].": ".$current->get_temp()."°"), 
                      array($TEMP[$AR].": ".$current->get_temp()."°",
					  		$TEMP[$AR].": ".$current->get_temp()."°")), 
                "?section=graph&amp;graph=tempLatestArchive.php&amp;profile=2");
    update_action ("Cold", 
                   array("<div class=\"loading float\"><img src=\"".BASE_URL."/images/$pic\" alt=\"$ALT[$EN]\" width=\"150px\" border=\"0\"></div><div class=\"loading float\">&nbsp;$CURRENT_SIG_WEATHER[$EN]&nbsp;<strong>".$ALT[$EN]."</strong><div class=\"loading float big\">&nbsp;{$extrainfo[$EN]}</div></div>", 
				         "<div class=\"loading float\"><img src=\"".BASE_URL."/images/$pic\" alt=\"$ALT[$HEB]\" width=\"150px\" border=\"0\"></div><div class=\"loading float\">&nbsp;$CURRENT_SIG_WEATHER[$HEB]&nbsp;<strong>".$ALT[$HEB]."</strong><div class=\"loading float big\">&nbsp;{$extrainfo[$HEB]}</div></div>", 
				         "<div class=\"loading float\"><img src=\"".BASE_URL."/images/$pic\" alt=\"$ALT[$RU]\" width=\"150px\" border=\"0\"></div><div class=\"loading float\">&nbsp;$CURRENT_SIG_WEATHER[$RU]&nbsp;<strong>".$ALT[$RU]."</strong><div class=\"loading float big\">&nbsp;{$extrainfo[$RU]}</div></div>", 
				         "<div class=\"loading float\"><img src=\"".BASE_URL."/images/$pic\" alt=\"$ALT[$FR]\" width=\"150px\" border=\"0\"></div><div class=\"loading float\">&nbsp;$CURRENT_SIG_WEATHER[$FR]&nbsp;<strong>".$ALT[$FR]."</strong><div class=\"loading float big\">&nbsp;{$extrainfo[$FR]}</div></div>", 
				         "<div class=\"loading float\"><img src=\"".BASE_URL."/images/$pic\" alt=\"$ALT[$AR]\" width=\"150px\" border=\"0\"></div><div class=\"loading float\">&nbsp;$CURRENT_SIG_WEATHER[$AR]&nbsp;<strong>".$ALT[$AR]."</strong><div class=\"loading float big\">&nbsp;{$extrainfo[$AR]}</div></div>"),
                           $ALT);
}
if ($current->get_pm10() > 130 || $current->get_pm25() > 50)
{
    $DUST_ARR = $HIGH_DUST;
	if ($current->isLowDust()) 
		$DUST_ARR = array($HIGH_DUST[$EN]." ".$A_BIT[$EN], 
						  $HIGH_DUST[$HEB]." ".$A_BIT[$HEB], 
						  $HIGH_DUST[$RU]." ".$A_BIT[$EU], 
						  $HIGH_DUST[$FR]." ".$A_BIT[$FR], 
						  $HIGH_DUST[$AR]." ".$A_BIT[$AR]);
	
	updateSigWeather(
		"dust.gif", 
		$DUST_ARR, 
		array(array($DUSTPM10[$EN].": ".$current->get_pm10()."   ".$DUSTPM25[$EN].": ".$current->get_pm25()." µg/m3",
					$DUSTPM10[$EN].": ".$current->get_pm10()."   ".$DUSTPM25[$EN].": ".$current->get_pm25()." µg/m3"), 
                      array($DUSTPM10[$HEB].": ".$current->get_pm10()."   ".$DUSTPM25[$HEB].": ".$current->get_pm25()." µg/m3",
					  		$DUSTPM10[$HEB].": ".$current->get_pm10()."   ".$DUSTPM25[$HEB].": ".$current->get_pm25()." µg/m3"), 
                      array($DUSTPM10[$RU].": ".$current->get_pm10()."   ".$DUSTPM25[$RU].": ".$current->get_pm25()." µg/m3",
					  		$DUSTPM10[$RU].": ".$current->get_pm10()."   ".$DUSTPM25[$RU].": ".$current->get_pm25()." µg/m3"), 
                      array($DUSTPM10[$FR].": ".$current->get_pm10()."   ".$DUSTPM25[$FR].": ".$current->get_pm25()." µg/m3",
					  		$DUSTPM10[$FR].": ".$current->get_pm10()."   ".$DUSTPM25[$FR].": ".$current->get_pm25()." µg/m3"), 
                      array($DUSTPM10[$AR].": ".$current->get_pm10()."   ".$DUSTPM25[$AR].": ".$current->get_pm25()." µg/m3",
					  		$DUSTPM10[$AR].": ".$current->get_pm10()."   ".$DUSTPM25[$AR].": ".$current->get_pm25()." µg/m3")), 
                     "?section=dust");
		if ($current->isLowDust())
			update_action (CustomAlert::Dust, $extrainfo, $ALT);
		else
			update_action (CustomAlert::HighDust, $extrainfo, $ALT);

}
if ($current->get_uv() >= 8)
{
	
	if ($current->get_uv() > 10.5){
		updateSigWeather("hot.gif" , $EXTREME_UV,
		array(array($UV[$EN].": ".$current->get_uv().", ".$SUNSCREEN_UV[$EN], $UV[$EN].": ".$current->get_uv().", ".$SUNSCREEN_UV[$EN]), 
              array($UV[$HEB].": ".$current->get_uv().", ".$SUNSCREEN_UV[$HEB],$UV[$HEB].": ".$current->get_uv().", ".$SUNSCREEN_UV[$HEB]), 
              array($UV[$RU].": ".$current->get_uv().", ".$SUNSCREEN_UV[$RU],$UV[$RU].": ".$current->get_uv().", ".$SUNSCREEN_UV[$RU]), 
              array($UV[$FR].": ".$current->get_uv().", ".$SUNSCREEN_UV[$FR],$UV[$FR].": ".$current->get_uv().", ".$SUNSCREEN_UV[$FR]), 
              array($UV[$AR].": ".$current->get_uv().", ".$SUNSCREEN_UV[$AR],$UV[$AR].": ".$current->get_uv().", ".$SUNSCREEN_UV[$AR])), 
               "?section=graph&amp;graph=UVHistory.gif&amp;profile=2");
		update_action (CustomAlert::ExtremeUV, $extrainfo, $ALT);
	}
  	else{
		updateSigWeather("hot.gif" , $HIGH_UV,
		array(array($UV[$EN].": ".$current->get_uv(), $UV[$EN].": ".$current->get_uv()), 
              array($UV[$HEB].": ".$current->get_uv()."",$UV[$HEB].": ".$current->get_uv()), 
              array($UV[$RU].": ".$current->get_uv()."",$UV[$RU].": ".$current->get_uv()), 
              array($UV[$FR].": ".$current->get_uv()."",$UV[$FR].": ".$current->get_uv()), 
              array($UV[$AR].": ".$current->get_uv()."",$UV[$AR].": ".$current->get_uv())), 
               "?section=graph&amp;graph=UVHistory.gif&amp;profile=2");
		update_action (CustomAlert::HighUV, $extrainfo, $ALT);
	}
		
}
if (($current->get_dew() > c_or_f(15))&&(true))
{
		$ToDisplay = array();
		$ToDisplay = $HIGH_HUMIDITY;
		if ($current->get_dew() > c_or_f(22.5))
			$ToDisplay = $SAUNA3;
		else if ($current->get_dew() > c_or_f(20))
			$ToDisplay = $SAUNA2;
		else if ($current->get_dew() > c_or_f(18))
			$ToDisplay = $SAUNA1;
    $extrainfoS = array (
		array($DEW[$EN].": ".$current->get_dew() , $DEW[$EN].": ".$current->get_dew()) ,
		array($DEW[$HEB].": ".$current->get_dew(),$DEW[$HEB].": ".$current->get_dew()),
		array($DEW[$RU].": ".$current->get_dew(),$DEW[$RU].": ".$current->get_dew()),
		array($DEW[$FR].": ".$current->get_dew(),$DEW[$FR].": ".$current->get_dew()),
		array($DEW[$AR].": ".$current->get_dew(),$DEW[$AR].": ".$current->get_dew()));
        updateSigWeather(
		"hum.jpg", 
		$ToDisplay, 
		$extrainfoS, 
		"?section=graph&amp;graph=dewpt.php&amp;profile=1");
}
if (($current->get_solarradiation() > 450)&&($current->get_temp('C') <= 10)&&($min10->get_windspd() >= 10)&&($current->get_thsw()-$current->get_temp() < 5))
{
  updateSigWeather(
    "cold.gif", 
    $COLD_SUN, 
    array(array("",""),array("","")), 
    "?section=graph&amp;graph=tempLatestArchive.php&amp;profile=1");

}
if (($current->get_solarradiation() > 450)&&($current->get_temp('C') < 14)&&($current->get_temp('C') > 10)&&($min10->get_windspd() >= 10)&&($current->get_thsw()-$current->get_temp() < 5))
{
  updateSigWeather(
    "cold.gif", 
    $HALF_COLD_SUN, 
    array(array("",""),array("","")), 
    "?section=graph&amp;graph=tempLatestArchive.php&amp;profile=1");

}
if (abs($current->get_temp() - $current->get_temp2()) >= 2)
{
	$extrainfoS = array (
		array($MOUNTAIN[$EN].": ".$current->get_temp()." ".$VALLEY[$EN].": ".$current->get_temp2(), 
			  $MOUNTAIN[$EN].": ".$current->get_temp()." ".$VALLEY[$EN].": ".$current->get_temp2()) ,
		array($MOUNTAIN[$HEB].": ".$current->get_temp()." ".$VALLEY[$HEB].": ".$current->get_temp2(), 
			  $MOUNTAIN[$HEB].": ".$current->get_temp()." ".$VALLEY[$HEB].": ".$current->get_temp2()),
		array($MOUNTAIN[$RU].": ".$current->get_temp()." ".$VALLEY[$RU].": ".$current->get_temp2(), 
			  $MOUNTAIN[$RU].": ".$current->get_temp()." ".$VALLEY[$RU].": ".$current->get_temp2()),
		array($MOUNTAIN[$FR].": ".$current->get_temp()." ".$VALLEY[$FR].": ".$current->get_temp2(), 
			  $MOUNTAIN[$FR].": ".$current->get_temp()." ".$VALLEY[$FR].": ".$current->get_temp2()),
		array($MOUNTAIN[$AR].": ".$current->get_temp()." ".$VALLEY[$AR].": ".$current->get_temp2(), 
			  $MOUNTAIN[$AR].": ".$current->get_temp()." ".$VALLEY[$AR].": ".$current->get_temp2()));
	updateSigWeather(
		"profile1/temp.php?datasource=downld02&amp;lang={$lang_idx}", 
		$MOUNTAIN_VALLEY_DIF, 
		$extrainfoS, 
		"?section=graph&amp;graph=temp.php&amp;profile=1");
}
if (abs($current->get_hum() - $current->get_hum2()) >= 20)
{
	$extrainfoS = array (
		array($MOUNTAIN[$EN].": ".$current->get_hum()."% ".$VALLEY[$EN].": ".$current->get_hum2()."%", 
			  $MOUNTAIN[$EN].": ".$current->get_hum()."% ".$VALLEY[$EN].": ".$current->get_hum2()."%") ,
		array($MOUNTAIN[$HEB].": ".$current->get_hum()."% ".$VALLEY[$HEB].": ".$current->get_hum2()."%", 
			  $MOUNTAIN[$HEB].": ".$current->get_hum()."% ".$VALLEY[$HEB].": ".$current->get_hum2()."%"),
		array($MOUNTAIN[$RU].": ".$current->get_hum()."% ".$VALLEY[$RU].": ".$current->get_hum2()."%", 
			  $MOUNTAIN[$RU].": ".$current->get_hum()."% ".$VALLEY[$RU].": ".$current->get_hum2()."%"),
		array($MOUNTAIN[$FR].": ".$current->get_hum()."% ".$VALLEY[$FR].": ".$current->get_hum2()."%", 
			  $MOUNTAIN[$FR].": ".$current->get_hum()."% ".$VALLEY[$FR].": ".$current->get_hum2()."%"),
		array($MOUNTAIN[$AR].": ".$current->get_hum()."% ".$VALLEY[$AR].": ".$current->get_hum2()."%", 
			  $MOUNTAIN[$AR].": ".$current->get_hum()."% ".$VALLEY[$AR].": ".$current->get_hum2()."%"));
	updateSigWeather(
		"profile1/temp.php?datasource=downld02&amp;lang={$lang_idx}", 
		$MOUNTAIN_VALLEY_DIF, 
		$extrainfoS, 
		"?section=graph&amp;graph=temp.php&amp;profile=1");
}
$itfeels = $current->get_itfeels();
if (($current->get_solarradiation() > 500)&&($itfeels[1] > 11)&&($itfeels[1] <= 15)&&($min10->get_windspd() < 5)&&($current->get_thsw()-$current->get_temp() > 4))
{
  updateSigWeather(
    "nowind.jpg", 
    $SUN_SHADE, 
    array(array("",""),array("",""),array("",""),array("",""),array("","")), 
    "?section=graph.php&amp;graph=tempLatestArchive.php&amp;profile=1");

}
if (($current->get_solarradiation() > 500)&&($itfeels[1] > 15)&&($itfeels[1] < 19)&&($min10->get_windspd() < 11)&&($current->get_hum() > 40)&&($current->get_thsw()-$current->get_temp() > 4))
{
  updateSigWeather(
    "nowind.jpg", 
    $SUN_SHADE, 
    array(array("",""),array("",""),array("",""),array("",""),array("","")), 
    "?section=graph&amp;graph=tempLatestArchive.php&amp;profile=1");

}

if	((($min15->get_prschange() < -0.3)||
	 ($min30->get_prschange() < -0.5)||
	 ($oneHour->get_prschange() < -1)) && (notnull()))
{
	if ($min15->get_prschange() < -0.3)
	{
		$extrainfoS = array (
		array(getLastUpdateMin()." ".$MINTS[$EN].": ".get_param_tag($min15->get_prschange(), true, $BAR_UNIT[$EN])." ", 
			  getLastUpdateMin()." ".$MINTS[$EN].": ".get_param_tag($min15->get_prschange(), false, $BAR_UNIT[$EN])) ,
                array(getLastUpdateMin()." ".$MINTS[$HEB].": ".get_param_tag($min15->get_prschange(), true, $BAR_UNIT[$HEB])." ",
					  getLastUpdateMin()." ".$MINTS[$HEB].": ".get_param_tag($min15->get_prschange(), false, $BAR_UNIT[$HEB])." "),
                array(getLastUpdateMin()." ".$MINTS[$RU].": ".get_param_tag($min15->get_prschange(), true, $BAR_UNIT[$RU])." ",
					  getLastUpdateMin()." ".$MINTS[$RU].": ".get_param_tag($min15->get_prschange(), false, $BAR_UNIT[$RU])." "),
                array(getLastUpdateMin()." ".$MINTS[$FR].": ".get_param_tag($min15->get_prschange(), true, $BAR_UNIT[$FR])." ",
					  getLastUpdateMin()." ".$MINTS[$FR].": ".get_param_tag($min15->get_prschange(), false, $BAR_UNIT[$FR])." "),
                array(getLastUpdateMin()." ".$MINTS[$AR].": ".get_param_tag($min15->get_prschange(), true, $BAR_UNIT[$AR])." ",
					  getLastUpdateMin()." ".$MINTS[$AR].": ".get_param_tag($min15->get_prschange(), false, $BAR_UNIT[$AR])." "));
	}
	else if ($min30->get_prschange() < -0.5)
	{
		$extrainfoS = array (
		array("30 ".$MINTS[$EN].": ".get_param_tag($min30->get_prschange(), true, $BAR_UNIT[$EN]) , 
			  "30 ".$MINTS[$EN].": ".get_param_tag($min30->get_prschange(), false, $BAR_UNIT[$EN])),
		array("30 ".$MINTS[$HEB].": ".get_param_tag($min30->get_prschange(), true, $BAR_UNIT[$HEB])." ",
			  "30 ".$MINTS[$HEB].": ".get_param_tag($min30->get_prschange(), false, $BAR_UNIT[$HEB])." "),
		array("30 ".$MINTS[$RU].": ".get_param_tag($min30->get_prschange(), true, $BAR_UNIT[$RU])." ",
			  "30 ".$MINTS[$RU].": ".get_param_tag($min30->get_prschange(), false, $BAR_UNIT[$RU])." "),
		array("30 ".$MINTS[$FR].": ".get_param_tag($min30->get_prschange(), true, $BAR_UNIT[$FR])." ",
			  "30 ".$MINTS[$FR].": ".get_param_tag($min30->get_prschange(), false, $BAR_UNIT[$FR])." "),
		array("30 ".$MINTS[$AR].": ".get_param_tag($min30->get_prschange(), true, $BAR_UNIT[$AR])." ",
			  "30 ".$MINTS[$AR].": ".get_param_tag($min30->get_prschange(), false, $BAR_UNIT[$AR])." "));
	}
	else if ($oneHour->get_prschange() < -1)
	{
		$extrainfoS = array (
		array($HOUR[$EN].": ".get_param_tag($oneHour->get_prschange(), true, $BAR_UNIT[$EN]) , 
			  $HOUR[$EN].": ".get_param_tag($oneHour->get_prschange(), false, $BAR_UNIT[$EN])),
		array($HOUR[$HEB].": ".get_param_tag($oneHour->get_prschange(), true, $BAR_UNIT[$HEB])." ", 
			  $HOUR[$HEB].": ".get_param_tag($oneHour->get_prschange(), false, $BAR_UNIT[$HEB])." "),
		array($HOUR[$RU].": ".get_param_tag($oneHour->get_prschange(), true, $BAR_UNIT[$RU])." ", 
			  $HOUR[$RU].": ".get_param_tag($oneHour->get_prschange(), false, $BAR_UNIT[$RU])." "),
		array($HOUR[$FR].": ".get_param_tag($oneHour->get_prschange(), true, $BAR_UNIT[$FR])." ", 
			  $HOUR[$FR].": ".get_param_tag($oneHour->get_prschange(), false, $BAR_UNIT[$FR])." "),
		array($HOUR[$AR].": ".get_param_tag($oneHour->get_prschange(), true, $BAR_UNIT[$AR])." ", 
			  $HOUR[$AR].": ".get_param_tag($oneHour->get_prschange(), false, $BAR_UNIT[$AR])." "));
	}
	updateSigWeather(
		"profile1/baro.php?datasource=downld02&amp;lang={$lang_idx}", 
		$PRESSURE_IS_FALLING, 
		$extrainfoS, 
		"?section=graph.php&amp;graph=baro.php&amp;profile=1");
 	//update_action ("PrsSinking", $extrainfo, $ALT);
}
if (($current->get_hum() < 20)&&($current->get_hum() != "")&&($current->get_temp() > 25)&&($current->get_windspd() > 20))
{
	$extrainfoS = array (
		array($HUMIDITY[$EN].": ".$current->get_hum() , 
			  $HUMIDITY[$EN].": ".$current->get_hum()) ,
		array($HUMIDITY[$HEB].": ".$current->get_hum(),
			  $HUMIDITY[$HEB].": ".$current->get_hum()),
		array($HUMIDITY[$RU].": ".$current->get_hum(),
			  $HUMIDITY[$RU].": ".$current->get_hum()),
		array($HUMIDITY[$FR].": ".$current->get_hum(),
			  $HUMIDITY[$FR].": ".$current->get_hum()),
		array($HUMIDITY[$AR].": ".$current->get_hum(),
			  $HUMIDITY[$AR].": ".$current->get_hum()));
   updateSigWeather(
		"dry_ground_1.jpg", 
		$FIRE_INDEX, 
		 $extrainfoS, 
		 "?section=graph&amp;graph=OutsideHumidityHistory.gif&amp;profile=1");
		 update_action (CustomAlert::FireIndex, $extrainfo, $ALT);
}
if (($current->get_hum() < 20)&&($current->get_hum() != ""))
{
	$extrainfoS = array (
		array($HUMIDITY[$EN].": ".$current->get_hum() , 
			  $HUMIDITY[$EN].": ".$current->get_hum()) ,
		array($HUMIDITY[$HEB].": ".$current->get_hum(),
			  $HUMIDITY[$HEB].": ".$current->get_hum()),
		array($HUMIDITY[$RU].": ".$current->get_hum(),
			  $HUMIDITY[$RU].": ".$current->get_hum()),
		array($HUMIDITY[$FR].": ".$current->get_hum(),
			  $HUMIDITY[$FR].": ".$current->get_hum()),
		array($HUMIDITY[$AR].": ".$current->get_hum(),
			  $HUMIDITY[$AR].": ".$current->get_hum()));
   updateSigWeather(
		"dry_ground_1.jpg", 
		$VERY_DRY, 
		 $extrainfoS, 
		 "?section=graphp&amp;graph=OutsideHumidityHistory.gif&amp;profile=1");
		 update_action (CustomAlert::Dry, $extrainfo, $ALT);
}

if ((($min15->get_prschange() > 0.2)||
	 ($min30->get_prschange() > 0.5)||
	 ($oneHour->get_prschange() > 1))&& (notnull()))
{
	if (($min15->get_prschange()  > 0.2)&&($min15->get_prschange()  < 1000))
	{
		$extrainfoS = array (
		array(getLastUpdateMin()." ".$MINTS[$EN].": ".get_param_tag($min15->get_prschange(), true, $BAR_UNIT[$EN])." " , 
			  getLastUpdateMin()." ".$MINTS[$EN].": ".get_param_tag($min15->get_prschange(), false, $BAR_UNIT[$EN])." ".$BAR_UNIT[$EN]) ,
    	array(getLastUpdateMin()." ".$MINTS[$HEB].": ".get_param_tag($min15->get_prschange(), true, $BAR_UNIT[$HEB])." ",
			  getLastUpdateMin()." ".$MINTS[$HEB].": ".get_param_tag($min15->get_prschange(), false, $BAR_UNIT[$HEB])." ".$BAR_UNIT[$EN]),
    	array(getLastUpdateMin()." ".$MINTS[$RU].": ".get_param_tag($min15->get_prschange(), true, $BAR_UNIT[$RU])." ",
			  getLastUpdateMin()." ".$MINTS[$RU].": ".get_param_tag($min15->get_prschange(), false, $BAR_UNIT[$RU])." ".$BAR_UNIT[$EN]),
    	array(getLastUpdateMin()." ".$MINTS[$FR].": ".get_param_tag($min15->get_prschange(), true, $BAR_UNIT[$FR])." ",
			  getLastUpdateMin()." ".$MINTS[$FR].": ".get_param_tag($min15->get_prschange(), false, $BAR_UNIT[$FR])." ".$BAR_UNIT[$EN]),
    	array(getLastUpdateMin()." ".$MINTS[$AR].": ".get_param_tag($min15->get_prschange(), true, $BAR_UNIT[$AR])." ",
			  getLastUpdateMin()." ".$MINTS[$AR].": ".get_param_tag($min15->get_prschange(), false, $BAR_UNIT[$AR])." ".$BAR_UNIT[$EN]));
	}
	else if (($min30->get_prschange() > 0.5)&&($min30->get_prschange()  < 1000))
	{
		$extrainfoS = array (
		array("30 ".$MINTS[$EN].": ".get_param_tag($min30->get_prschange(), true, $BAR_UNIT[$EN])." " , 
			  "30 ".$MINTS[$EN].": ".get_param_tag($min30->get_prschange(), false, $BAR_UNIT[$EN])." ".$BAR_UNIT[$EN]) , 
		array("30 ".$MINTS[$HEB].": ".get_param_tag($min30->get_prschange(), true, $BAR_UNIT[$HEB])." ",
			  "30 ".$MINTS[$HEB].": ".get_param_tag($min30->get_prschange(), false, $BAR_UNIT[$EN])." ".$BAR_UNIT[$EN]), 
		array("30 ".$MINTS[$RU].": ".get_param_tag($min30->get_prschange(), true, $BAR_UNIT[$RU])." ",
			  "30 ".$MINTS[$RU].": ".get_param_tag($min30->get_prschange(), false, $BAR_UNIT[$EN])." ".$BAR_UNIT[$EN]), 
		array("30 ".$MINTS[$FR].": ".get_param_tag($min30->get_prschange(), true, $BAR_UNIT[$FR])." ",
			  "30 ".$MINTS[$FR].": ".get_param_tag($min30->get_prschange(), false, $BAR_UNIT[$EN])." ".$BAR_UNIT[$EN]), 
		array("30 ".$MINTS[$AR].": ".get_param_tag($min30->get_prschange(), true, $BAR_UNIT[$AR])." ",
			  "30 ".$MINTS[$AR].": ".get_param_tag($min30->get_prschange(), false, $BAR_UNIT[$EN])." ".$BAR_UNIT[$EN]));
	}
	else if (($oneHour->get_prschange()  > 1)&&($oneHour->get_prschange()  < 1000))
	{
		$extrainfoS = array (
		array($HOUR[$EN].": ".get_param_tag($oneHour->get_prschange(), true, $BAR_UNIT[$EN])." " , 
			  $HOUR[$EN].": ".get_param_tag($oneHour->get_prschange(), false, $BAR_UNIT[$EN])." ".$BAR_UNIT[$EN]) ,
		array($HOUR[$HEB].": ".get_param_tag($oneHour->get_prschange(), true, $BAR_UNIT[$HEB])." ",
			  $HOUR[$HEB].": ".get_param_tag($oneHour->get_prschange(), false, $BAR_UNIT[$HEB])." ".$BAR_UNIT[$EN]),
		array($HOUR[$RU].": ".get_param_tag($oneHour->get_prschange(), true, $BAR_UNIT[$RU])." ",
			  $HOUR[$RU].": ".get_param_tag($oneHour->get_prschange(), false, $BAR_UNIT[$RU])." ".$BAR_UNIT[$EN]),
		array($HOUR[$FR].": ".get_param_tag($oneHour->get_prschange(), true, $BAR_UNIT[$FR])." ",
			  $HOUR[$FR].": ".get_param_tag($oneHour->get_prschange(), false, $BAR_UNIT[$FR])." ".$BAR_UNIT[$EN]),
		array($HOUR[$AR].": ".get_param_tag($oneHour->get_prschange(), true, $BAR_UNIT[$AR])." ",
			  $HOUR[$AR].": ".get_param_tag($oneHour->get_prschange(), false, $BAR_UNIT[$AR])." ".$BAR_UNIT[$EN]));
	}
	
	updateSigWeather(
		"profile1/baro.php?datasource=downld02&amp;lang={$lang_idx}", 
		$DRASTIC_PRESSURE_RISE, 
		$extrainfoS, 
		"?section=graph&amp;graph=baro.php&amp;profile=1");
	//update_action ("PrsRise", $extrainfo, $ALT);
}
if ((($min15->get_tempchange() <= -0.7)||
	 ($min30->get_tempchange() <= -1.5)||
	 ($oneHour->get_tempchange() <= -2.5)||
	  (($threeHours->get_tempchange() <= -3.5) && ($hour > 7) && ($hour < 15)))&& (notnull()))
{
	if ($min15->get_tempchange() <= -0.7)
	{
		$extrainfoS = array (
		array(getLastUpdateMin()." ".$MINTS[$EN].": ".get_param_tag($min15->get_tempchange(), true)."°" , 
			  getLastUpdateMin()." ".$MINTS[$EN].": ".get_param_tag($min15->get_tempchange(), false)."°") , 
                array(getLastUpdateMin()." ".$MINTS[$HEB].": ".get_param_tag($min15->get_tempchange(), true)."°",
					  getLastUpdateMin()." ".$MINTS[$HEB].": ".get_param_tag($min15->get_tempchange(), false)."°"), 
                array(getLastUpdateMin()." ".$MINTS[$RU].": ".get_param_tag($min15->get_tempchange(), true)."°",
					  getLastUpdateMin()." ".$MINTS[$RU].": ".get_param_tag($min15->get_tempchange(), false)."°"), 
                array(getLastUpdateMin()." ".$MINTS[$FR].": ".get_param_tag($min15->get_tempchange(), true)."°",
					  getLastUpdateMin()." ".$MINTS[$FR].": ".get_param_tag($min15->get_tempchange(), false)."°"), 
                array(getLastUpdateMin()." ".$MINTS[$AR].": ".get_param_tag($min15->get_tempchange(), true)."°",
					  getLastUpdateMin()." ".$MINTS[$AR].": ".get_param_tag($min15->get_tempchange(), false)."°"));
		//update_action ("TempDrop", $extrainfo, $ALT);
	}
	else if ($min30->get_tempchange() <= -1.5)
	{
		$extrainfoS = array (
		array("30 ".$MINTS[$EN].": ".get_param_tag($min30->get_tempchange(), true)."°" , 
			  "30 ".$MINTS[$EN].": ".get_param_tag($min30->get_tempchange(), false)."°") , 
		array("30 ".$MINTS[$HEB].": ".get_param_tag($min30->get_tempchange(), true)."°",
			  "30 ".$MINTS[$HEB].": ".get_param_tag($min30->get_tempchange(), false)."°"), 
		array("30 ".$MINTS[$RU].": ".get_param_tag($min30->get_tempchange(), true)."°",
			  "30 ".$MINTS[$RU].": ".get_param_tag($min30->get_tempchange(), false)."°"), 
		array("30 ".$MINTS[$FR].": ".get_param_tag($min30->get_tempchange(), true)."°",
			  "30 ".$MINTS[$FR].": ".get_param_tag($min30->get_tempchange(), false)."°"), 
		array("30 ".$MINTS[$AR].": ".get_param_tag($min30->get_tempchange(), true)."°",
			  "30 ".$MINTS[$AR].": ".get_param_tag($min30->get_tempchange(), false)."°"));
		//update_action ("TempDrop", $extrainfo, $ALT);
	}
	else if ($oneHour->get_tempchange() <= -2.5)
	{
		$extrainfoS = array (
		array($HOUR[$EN].": ".get_param_tag($oneHour->get_tempchange(), true)."°" , 
			  $HOUR[$EN].": ".get_param_tag($oneHour->get_tempchange(), false)."°" ),
		array($HOUR[$HEB].": ".get_param_tag($oneHour->get_tempchange(), true)."°", 
			  $HOUR[$HEB].": ".get_param_tag($oneHour->get_tempchange(), false)."°"),
		array($HOUR[$RU].": ".get_param_tag($oneHour->get_tempchange(), true)."°", 
			  $HOUR[$RU].": ".get_param_tag($oneHour->get_tempchange(), false)."°"),
		array($HOUR[$FR].": ".get_param_tag($oneHour->get_tempchange(), true)."°", 
			  $HOUR[$FR].": ".get_param_tag($oneHour->get_tempchange(), false)."°"),
		array($HOUR[$AR].": ".get_param_tag($oneHour->get_tempchange(), true)."°", 
			  $HOUR[$AR].": ".get_param_tag($oneHour->get_tempchange(), false)."°"));
		//update_action ("TempDrop", $extrainfo, $ALT);
	}
	else if (($threeHours->get_tempchange() <= -3.5) && ($hour > 7) && ($hour < 15))
	{
		$extrainfoS = array (
		array("3 ".$HOURS[$EN].": ".get_param_tag($threeHours->get_tempchange(), true)."°" , 
			  "3 ".$HOURS[$EN].": ".get_param_tag($threeHours->get_tempchange(), false)."°") ,
		array("3 ".$HOURS[$HEB].": ".get_param_tag($threeHours->get_tempchange(), true)."°",
			  "3 ".$HOURS[$HEB].": ".get_param_tag($threeHours->get_tempchange(), false)."°"),
		array("3 ".$HOURS[$RU].": ".get_param_tag($threeHours->get_tempchange(), true)."°",
			  "3 ".$HOURS[$RU].": ".get_param_tag($threeHours->get_tempchange(), false)."°"),
		array("3 ".$HOURS[$FR].": ".get_param_tag($threeHours->get_tempchange(), true)."°",
			  "3 ".$HOURS[$FR].": ".get_param_tag($threeHours->get_tempchange(), false)."°"),
		array("3 ".$HOURS[$AR].": ".get_param_tag($threeHours->get_tempchange(), true)."°",
			  "3 ".$HOURS[$AR].": ".get_param_tag($threeHours->get_tempchange(), false)."°"));
	}
	updateSigWeather(
		"profile1/temp.php?datasource=downld02&amp;lang={$lang_idx}", 
		$DRASTIC_TEMP_DROP, 
		$extrainfoS, 
		"?section=graph&amp;graph=tempLatestArchive.php&amp;profile=1");
	
}
if (((($min15->get_tempchange() >= 1) && ($hour > 9) && ($hour < 7))   ||
	 (($min30->get_tempchange()  >= 2) && ($hour > 9) && ($hour < 7))  ||
	 (($oneHour->get_tempchange() >= 3) && ($hour > 9) && ($hour < 7)) ||
	  (($threeHours->get_tempchange() >= 3) && ($hour > 14) && ($hour < 7)))&& (notnull()))
{
	if (($min15->get_tempchange() >= 1)&&($min15->get_tempchange()  < 10))
	{
		$extrainfoS = array (
		array(getLastUpdateMin()." ".$MINTS[$EN].": ".get_param_tag($min15->get_tempchange(), true)."°" , 
			  getLastUpdateMin()." ".$MINTS[$EN].": ".get_param_tag($min15->get_tempchange(), false)."°") , 
                array(getLastUpdateMin()." ".$MINTS[$HEB].": ".get_param_tag($min15->get_tempchange(), true)."°",
					  getLastUpdateMin()." ".$MINTS[$HEB].": ".get_param_tag($min15->get_tempchange(), false)."°"), 
                array(getLastUpdateMin()." ".$MINTS[$RU].": ".get_param_tag($min15->get_tempchange(), true)."°",
					  getLastUpdateMin()." ".$MINTS[$RU].": ".get_param_tag($min15->get_tempchange(), false)."°"), 
                array(getLastUpdateMin()." ".$MINTS[$FR].": ".get_param_tag($min15->get_tempchange(), true)."°",
					  getLastUpdateMin()." ".$MINTS[$FR].": ".get_param_tag($min15->get_tempchange(), false)."°"), 
                array(getLastUpdateMin()." ".$MINTS[$AR].": ".get_param_tag($min15->get_tempchange(), true)."°",
					  getLastUpdateMin()." ".$MINTS[$AR].": ".get_param_tag($min15->get_tempchange(), false)."°"));
		
	}
	else if (($min30->get_tempchange() >= 2)&&($min30->get_tempchange() < 10))
	{
		$extrainfoS = array (
		array("30 ".$MINTS[$EN].": ".get_param_tag($min30->get_tempchange(), true)."°" , 
		      "30 ".$MINTS[$EN].": ".get_param_tag($min30->get_tempchange(), false)."°") , 
		array("30 ".$MINTS[$HEB].": ".get_param_tag($min30->get_tempchange(), true)."°",
			  "30 ".$MINTS[$HEB].": ".get_param_tag($min30->get_tempchange(), false)."°"), 
		array("30 ".$MINTS[$RU].": ".get_param_tag($min30->get_tempchange(), true)."°",
			  "30 ".$MINTS[$RU].": ".get_param_tag($min30->get_tempchange(), false)."°"), 
		array("30 ".$MINTS[$FR].": ".get_param_tag($min30->get_tempchange(), true)."°",
			  "30 ".$MINTS[$FR].": ".get_param_tag($min30->get_tempchange(), false)."°"), 
		array("30 ".$MINTS[$AR].": ".get_param_tag($min30->get_tempchange(), true)."°",
			  "30 ".$MINTS[$AR].": ".get_param_tag($min30->get_tempchange(), false)."°"));
		
	}
	else if (($oneHour->get_tempchange() >= 3)&&($oneHour->get_tempchange() < 15))
	{
		$extrainfoS = array (
		array($HOUR[$EN].": ".get_param_tag($oneHour->get_tempchange(), true)."°" , 
		      $HOUR[$EN].": ".get_param_tag($oneHour->get_tempchange(), false)."°") , 
		array($HOUR[$HEB].": ".get_param_tag($oneHour->get_tempchange(), true)."°", 
		      $HOUR[$HEB].": ".get_param_tag($oneHour->get_tempchange(), false)."°"), 
		array($HOUR[$RU].": ".get_param_tag($oneHour->get_tempchange(), true)."°", 
		      $HOUR[$RU].": ".get_param_tag($oneHour->get_tempchange(), false)."°"), 
		array($HOUR[$FR].": ".get_param_tag($oneHour->get_tempchange(), true)."°", 
		      $HOUR[$FR].": ".get_param_tag($oneHour->get_tempchange(), false)."°"), 
		array($HOUR[$AR].": ".get_param_tag($oneHour->get_tempchange(), true)."°", 
		      $HOUR[$AR].": ".get_param_tag($oneHour->get_tempchange(), false)."°"));
	}
	else if (($threeHours->get_tempchange() >= 3)&&($threeHours->get_tempchange() < 15))
	{
		$extrainfoS = array (
		array("3 ".$HOURS[$EN].": ".get_param_tag($threeHours->get_tempchange(), true)."°" , 
		      "3 ".$HOURS[$EN].": ".get_param_tag($threeHours->get_tempchange(), false)."°" ),
		array("3 ".$HOURS[$HEB].": ".get_param_tag($threeHours->get_tempchange(), true)."°", 
		      "3 ".$HOURS[$HEB].": ".get_param_tag($threeHours->get_tempchange(), false)."°"),
		array("3 ".$HOURS[$RU].": ".get_param_tag($threeHours->get_tempchange(), true)."°", 
		      "3 ".$HOURS[$RU].": ".get_param_tag($threeHours->get_tempchange(), false)."°"),
		array("3 ".$HOURS[$FR].": ".get_param_tag($threeHours->get_tempchange(), true)."°", 
		      "3 ".$HOURS[$FR].": ".get_param_tag($threeHours->get_tempchange(), false)."°"),
		array("3 ".$HOURS[$AR].": ".get_param_tag($threeHours->get_tempchange(), true)."°", 
		      "3 ".$HOURS[$AR].": ".get_param_tag($threeHours->get_tempchange(), false)."°"));
		
	}
	updateSigWeather(
		"profile1/temp.php?datasource=downld02&amp;lang={$lang_idx}", 
		$DRASTIC_TEMP_RISE, 
		$extrainfoS, 
		"?section=graph&amp;graph=tempLatestArchive.php&amp;profile=1");
	update_action ("TempRise", $extrainfo, $ALT);
}
if ((($min15->get_humchange() >= 15)||
	 ($min30->get_humchange()  >= 20)||
	 ($oneHour->get_humchange() >= 25)||
	  ($threeHours->get_humchange() >= 30))&& (notnull()))
{
	if (($min15->get_humchange() >= 15)&&($min15->get_humchange() < 50))
	{
		$extrainfoS = array (
		array(getLastUpdateMin()." ".$MINTS[$EN].": ".get_param_tag($min15->get_humchange(), true, "%") , 
		      getLastUpdateMin()." ".$MINTS[$EN].": ".get_param_tag($min15->get_humchange(), false, "%")) ,
         array(getLastUpdateMin()." ".$MINTS[$HEB].": ".get_param_tag($min15->get_humchange(), true, "%"), 
			   getLastUpdateMin()." ".$MINTS[$HEB].": ".get_param_tag($min15->get_humchange(), false, "%")),
         array(getLastUpdateMin()." ".$MINTS[$RU].": ".get_param_tag($min15->get_humchange(), true, "%"), 
			   getLastUpdateMin()." ".$MINTS[$RU].": ".get_param_tag($min15->get_humchange(), false, "%")),
         array(getLastUpdateMin()." ".$MINTS[$FR].": ".get_param_tag($min15->get_humchange(), true, "%"), 
			   getLastUpdateMin()." ".$MINTS[$FR].": ".get_param_tag($min15->get_humchange(), false, "%")),
         array(getLastUpdateMin()." ".$MINTS[$AR].": ".get_param_tag($min15->get_humchange(), true, "%"), 
			   getLastUpdateMin()." ".$MINTS[$AR].": ".get_param_tag($min15->get_humchange(), false, "%")));
	}
	else if (($min30->get_humchange() >= 20)&&($min30->get_humchange() < 60))
	{
		$extrainfoS = array (
		array("30 ".$MINTS[$EN].": ".get_param_tag($min30->get_humchange(), true, "%") , 
		      "30 ".$MINTS[$EN].": ".get_param_tag($min30->get_humchange(), false, "%")) , 
		array("30 ".$MINTS[$HEB].": ".get_param_tag($min30->get_humchange(), true, "%"), 
		      "30 ".$MINTS[$HEB].": ".get_param_tag($min30->get_humchange(), false, "%")), 
		array("30 ".$MINTS[$RU].": ".get_param_tag($min30->get_humchange(), true, "%"), 
		      "30 ".$MINTS[$RU].": ".get_param_tag($min30->get_humchange(), false, "%")), 
		array("30 ".$MINTS[$FR].": ".get_param_tag($min30->get_humchange(), true, "%"), 
		      "30 ".$MINTS[$FR].": ".get_param_tag($min30->get_humchange(), false, "%")), 
		array("30 ".$MINTS[$AR].": ".get_param_tag($min30->get_humchange(), true, "%"), 
		      "30 ".$MINTS[$AR].": ".get_param_tag($min30->get_humchange(), false, "%")));
	}
	else if (($oneHour->get_humchange() >= 25)&&($oneHour->get_humchange() < 70))
	{
		$extrainfoS = array (
		array($HOUR[$EN].": ".get_param_tag($oneHour->get_humchange(), true, "%") , 
		      $HOUR[$EN].": ".get_param_tag($oneHour->get_humchange(), false, "%")) ,
		array($HOUR[$HEB].": ".get_param_tag($oneHour->get_humchange(), true, "%"), 
		      $HOUR[$HEB].": ".get_param_tag($oneHour->get_humchange(), false, "%")),
		array($HOUR[$RU].": ".get_param_tag($oneHour->get_humchange(), true, "%"), 
		      $HOUR[$RU].": ".get_param_tag($oneHour->get_humchange(), false, "%")),
		array($HOUR[$FR].": ".get_param_tag($oneHour->get_humchange(), true, "%"), 
		      $HOUR[$FR].": ".get_param_tag($oneHour->get_humchange(), false, "%")),
		array($HOUR[$AR].": ".get_param_tag($oneHour->get_humchange(), true, "%"), 
		      $HOUR[$AR].": ".get_param_tag($oneHour->get_humchange(), false, "%")));
	}
	else if (($threeHours->get_humchange() >= 30)&&($threeHours->get_humchange() < 80))
	{
		$extrainfoS = array (
		array("3 ".$HOURS[$EN].": ".get_param_tag($threeHours->get_humchange(), true, "%") , 
		      "3 ".$HOURS[$EN].": ".get_param_tag($threeHours->get_humchange(), false, "%") ),
		array("3 ".$HOURS[$HEB].": ".get_param_tag($threeHours->get_humchange(), true, "%"), 
		      "3 ".$HOURS[$HEB].": ".get_param_tag($threeHours->get_humchange(), false, "%")),
		array("3 ".$HOURS[$RU].": ".get_param_tag($threeHours->get_humchange(), true, "%"), 
		      "3 ".$HOURS[$RU].": ".get_param_tag($threeHours->get_humchange(), false, "%")),
		array("3 ".$HOURS[$FR].": ".get_param_tag($threeHours->get_humchange(), true, "%"), 
		      "3 ".$HOURS[$FR].": ".get_param_tag($threeHours->get_humchange(), false, "%")),
		array("3 ".$HOURS[$AR].": ".get_param_tag($threeHours->get_humchange(), true, "%"), 
		      "3 ".$HOURS[$AR].": ".get_param_tag($threeHours->get_humchange(), false, "%")));
	}
	updateSigWeather(
		"profile1/humwind.php?level=1&amp;freq=2&amp;datasource=downld02", 
		$DRASTIC_HUM_RISE, 
		$extrainfoS, 
		"?section=graph&amp;graph=OutsideHumidityHistory.gif&amp;profile=1");
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
		array(getLastUpdateMin()." ".$MINTS[$EN].": ".get_param_tag($min15->get_humchange(), true)."%" , 
		      getLastUpdateMin()." ".$MINTS[$EN].": ".get_param_tag($min15->get_humchange(), false)."%"),
        array(getLastUpdateMin()." ".$MINTS[$HEB].": ".get_param_tag($min15->get_humchange(), true)."%", 
			  getLastUpdateMin()." ".$MINTS[$HEB].": ".get_param_tag($min15->get_humchange(), false)."%"),
        array(getLastUpdateMin()." ".$MINTS[$RU].": ".get_param_tag($min15->get_humchange(), true)."%", 
			  getLastUpdateMin()." ".$MINTS[$RU].": ".get_param_tag($min15->get_humchange(), false)."%"),
        array(getLastUpdateMin()." ".$MINTS[$FR].": ".get_param_tag($min15->get_humchange(), true)."%", 
			  getLastUpdateMin()." ".$MINTS[$FR].": ".get_param_tag($min15->get_humchange(), false)."%"),
        array(getLastUpdateMin()." ".$MINTS[$AR].": ".get_param_tag($min15->get_humchange(), true)."%", 
			  getLastUpdateMin()." ".$MINTS[$AR].": ".get_param_tag($min15->get_humchange(), false)."%"));
	}
	else if ($min30->get_humchange() < -20)
	{
		$extrainfoS = array (
		array("30 ".$MINTS[$EN].": ".get_param_tag($min30->get_humchange(), true)."%" , 
		      "30 ".$MINTS[$EN].": ".get_param_tag($min30->get_humchange(), false)."%" ),
		array("30 ".$MINTS[$HEB].": ".get_param_tag($min30->get_humchange(), true)."%", 
		      "30 ".$MINTS[$HEB].": ".get_param_tag($min30->get_humchange(), false)."%"),
		array("30 ".$MINTS[$RU].": ".get_param_tag($min30->get_humchange(), true)."%", 
		      "30 ".$MINTS[$RU].": ".get_param_tag($min30->get_humchange(), false)."%"),
		array("30 ".$MINTS[$FR].": ".get_param_tag($min30->get_humchange(), true)."%", 
		      "30 ".$MINTS[$FR].": ".get_param_tag($min30->get_humchange(), false)."%"),
		array("30 ".$MINTS[$AR].": ".get_param_tag($min30->get_humchange(), true)."%", 
		      "30 ".$MINTS[$AR].": ".get_param_tag($min30->get_humchange(), false)."%"));
	}
	else if ($oneHour->get_humchange() < -25)
	{
		$extrainfoS = array (
		array($HOUR[$EN].": ".get_param_tag($oneHour->get_humchange(), true)."%" , 
			  $HOUR[$EN].": ".get_param_tag($oneHour->get_humchange(), false)."%" ),
		array($HOUR[$HEB].": ".get_param_tag($oneHour->get_humchange(), true)."%", 
		     $HOUR[$HEB].": ".get_param_tag($oneHour->get_humchange(), false)."%"),
		array($HOUR[$RU].": ".get_param_tag($oneHour->get_humchange(), true)."%", 
		     $HOUR[$RU].": ".get_param_tag($oneHour->get_humchange(), false)."%"),
		array($HOUR[$FR].": ".get_param_tag($oneHour->get_humchange(), true)."%", 
		     $HOUR[$FR].": ".get_param_tag($oneHour->get_humchange(), false)."%"),
		array($HOUR[$AR].": ".get_param_tag($oneHour->get_humchange(), true)."%", 
		     $HOUR[$AR].": ".get_param_tag($oneHour->get_humchange(), false)."%"));
	}
	else if (($threeHours->get_humchange() < -30) && ($hour > 15) && ($hour < 7))
	{
		$extrainfoS = array (
		array("3 ".$HOURS[$EN].": ".get_param_tag($threeHours->get_humchange(), true)."%" , 
		      "3 ".$HOURS[$EN].": ".get_param_tag($threeHours->get_humchange(), false)."%") ,
		array("3 ".$HOURS[$HEB].": ".get_param_tag($threeHours->get_humchange(), true)."%", 
		      "3 ".$HOURS[$HEB].": ".get_param_tag($threeHours->get_humchange(), false)."%"),
		array("3 ".$HOURS[$RU].": ".get_param_tag($threeHours->get_humchange(), true)."%", 
		      "3 ".$HOURS[$RU].": ".get_param_tag($threeHours->get_humchange(), false)."%"),
		array("3 ".$HOURS[$FR].": ".get_param_tag($threeHours->get_humchange(), true)."%", 
		      "3 ".$HOURS[$FR].": ".get_param_tag($threeHours->get_humchange(), false)."%"),
		array("3 ".$HOURS[$AR].": ".get_param_tag($threeHours->get_humchange(), true)."%", 
		      "3 ".$HOURS[$AR].": ".get_param_tag($threeHours->get_humchange(), false)."%"));
	}
	updateSigWeather(
		"profile1/humwind.php?level=1&amp;freq=2&amp;datasource=downld02", 
		$DRASTIC_HUM_DROP, 
		$extrainfoS, 
		"?section=graph&amp;graph=OutsideHumidityHistory.gif&amp;profile=1");
	update_action ("HumDrop", $extrainfo, $ALT);
}
//logger("get_temp: ".$current->get_temp('C'));
if ((($current->get_temp('C') > 27)&&
		  ($hightemp_diffFromAv >= 5)&&
                  ($current->get_hum() <= 30))||
		  ((!$current->is_light())&&
		   ($lowtemp_diffFromAv >= 5)&&
		   ($today->get_lowtemp('&#176;c') > 19)&&
                  ($current->get_hum() <= 30)))
{
	$isHeatWave = true;
	if ($hour > 6)
	$extrainfoS = array (
		array($TODAY[$EN]." ".$today->get_hightemp()."°" , 
			  $TODAY[$EN]." ".$today->get_hightemp()."°") ,
		array($TODAY[$HEB]." ".$today->get_hightemp()."°", 
		      $TODAY[$HEB]." ".$today->get_hightemp()."°"),
		array($TODAY[$RU]." ".$today->get_hightemp()."°", 
		      $TODAY[$RU]." ".$today->get_hightemp()."°"),
		array($TODAY[$FR]." ".$today->get_hightemp()."°", 
		      $TODAY[$FR]." ".$today->get_hightemp()."°"),
		array($TODAY[$AR]." ".$today->get_hightemp()."°", 
		      $TODAY[$AR]." ".$today->get_hightemp()."°"));
	else
	$extrainfoS = array (
		array($TODAY[$EN]." ".$today->get_hightemp()."°" , 
		      $TODAY[$EN]." ".$today->get_hightemp()."°") ,
		array($TODAY[$HEB]." ".$today->get_hightemp()."°", 
		      $TODAY[$HEB]." ".$today->get_hightemp()."°"),
		array($TODAY[$RU]." ".$today->get_hightemp()."°", 
		      $TODAY[$RU]." ".$today->get_hightemp()."°"),
		array($TODAY[$FR]." ".$today->get_hightemp()."°", 
		      $TODAY[$FR]." ".$today->get_hightemp()."°"),
		array($TODAY[$AR]." ".$today->get_hightemp()."°", 
		      $TODAY[$AR]." ".$today->get_hightemp()."°"));
	updateSigWeather(
		"heat.jpg", 
		$VERY_HOT_HEAT_WAVE, 
		$extrainfoS, 
		"?section=graph&amp;graph=temp.php&amp;profile=3");
	//update_action ("HeatWave", $extrainfo, $ALT);
}

if (((($min15->get_windspdchange() > 12))||
	 ($min30->get_windspdchange()  > 10)||
	 ($oneHour->get_windspdchange() > 10))&& (notnull()))
{
	if ($min15->get_windspdchange() > 12)
	{
		$extrainfoS = array (
		array(getLastUpdateMin()." ".$MINTS[$EN].": ".get_param_tag($min15->get_windspdchange(), true, $KMH[$lang_idx])." ".$KMH[$lang_idx] , 
			  getLastUpdateMin()." ".$MINTS[$EN].": ".get_param_tag($min15->get_windspdchange(), false, $KMH[$lang_idx])." ".$KMH[$lang_idx]),
                array(getLastUpdateMin()." ".$MINTS[$HEB].": ".get_param_tag($min15->get_windspdchange(), true)." ".$KMH[$lang_idx], 
				      getLastUpdateMin()." ".$MINTS[$HEB].": ".get_param_tag($min15->get_windspdchange(), false, $KMH[$lang_idx])." ".$KMH[$lang_idx]),
                array(getLastUpdateMin()." ".$MINTS[$RU].": ".get_param_tag($min15->get_windspdchange(), true)." ".$KMH[$lang_idx], 
				      getLastUpdateMin()." ".$MINTS[$RU].": ".get_param_tag($min15->get_windspdchange(), false, $KMH[$lang_idx])." ".$KMH[$lang_idx]),
                array(getLastUpdateMin()." ".$MINTS[$FR].": ".get_param_tag($min15->get_windspdchange(), true)." ".$KMH[$lang_idx], 
				      getLastUpdateMin()." ".$MINTS[$FR].": ".get_param_tag($min15->get_windspdchange(), false, $KMH[$lang_idx])." ".$KMH[$lang_idx]),
                array(getLastUpdateMin()." ".$MINTS[$AR].": ".get_param_tag($min15->get_windspdchange(), true)." ".$KMH[$lang_idx], 
				      getLastUpdateMin()." ".$MINTS[$AR].": ".get_param_tag($min15->get_windspdchange(), false, $KMH[$lang_idx])." ".$KMH[$lang_idx]));
	}
	else if ($min30->get_windspdchange() > 10)
	{
		$extrainfoS = array (
		array("30 ".$MINTS[$EN].": ".get_param_tag($min30->get_windspdchange(), true, $KMH[$lang_idx])." " , 
		      "30 ".$MINTS[$EN].": ".get_param_tag($min30->get_windspdchange(), false, $KMH[$lang_idx])." ".$KMH[$lang_idx] ),
		array("30 ".$MINTS[$HEB].": ".get_param_tag($min30->get_windspdchange(), true, $KMH[$lang_idx])." ", 
		      "30 ".$MINTS[$HEB].": ".get_param_tag($min30->get_windspdchange(), false, $KMH[$lang_idx])." ".$KMH[$lang_idx]),
		array("30 ".$MINTS[$RU].": ".get_param_tag($min30->get_windspdchange(), true, $KMH[$lang_idx])." ", 
		      "30 ".$MINTS[$RU].": ".get_param_tag($min30->get_windspdchange(), false, $KMH[$lang_idx])." ".$KMH[$lang_idx]),
		array("30 ".$MINTS[$FR].": ".get_param_tag($min30->get_windspdchange(), true, $KMH[$lang_idx])." ", 
		      "30 ".$MINTS[$FR].": ".get_param_tag($min30->get_windspdchange(), false, $KMH[$lang_idx])." ".$KMH[$lang_idx]),
		array("30 ".$MINTS[$AR].": ".get_param_tag($min30->get_windspdchange(), true, $KMH[$lang_idx])." ", 
		      "30 ".$MINTS[$AR].": ".get_param_tag($min30->get_windspdchange(), false, $KMH[$lang_idx])." ".$KMH[$lang_idx]));
	}
	else if ($oneHour->get_windspdchange() > 10)
	{
		$extrainfoS = array (
		array($HOUR[$EN].": ".get_param_tag($oneHour->get_windspdchange(), true, $KMH[$lang_idx])." " , 
		      $HOUR[$EN].": ".get_param_tag($oneHour->get_windspdchange(), false, $KMH[$lang_idx])." ".$KMH[$lang_idx] ),
		array($HOUR[$HEB].": ".get_param_tag($oneHour->get_windspdchange(), true, $KMH[$lang_idx])." ", 
		      $HOUR[$HEB].": ".get_param_tag($oneHour->get_windspdchange(), false, $KMH[$lang_idx])." ".$KMH[$lang_idx]),
		array($HOUR[$RU].": ".get_param_tag($oneHour->get_windspdchange(), true, $KMH[$lang_idx])." ", 
		      $HOUR[$RU].": ".get_param_tag($oneHour->get_windspdchange(), false, $KMH[$lang_idx])." ".$KMH[$lang_idx]),
		array($HOUR[$FR].": ".get_param_tag($oneHour->get_windspdchange(), true, $KMH[$lang_idx])." ", 
		      $HOUR[$FR].": ".get_param_tag($oneHour->get_windspdchange(), false, $KMH[$lang_idx])." ".$KMH[$lang_idx]),
		array($HOUR[$AR].": ".get_param_tag($oneHour->get_windspdchange(), true, $KMH[$lang_idx])." ", 
		      $HOUR[$AR].": ".get_param_tag($oneHour->get_windspdchange(), false, $KMH[$lang_idx])." ".$KMH[$lang_idx]));
	}
	
	updateSigWeather(
		"profile1/wind.php?level=1&amp;freq=2&amp;datasource=downld02", 
		$DRASTIC_WIND_RISE, 
		$extrainfoS, 
		"?section=graph&amp;graph=wind.php&amp;profile=1");
	//update_action ("WindRise", $extrainfo, $ALT);
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
		array("<div class=\"float\" >"."60 ".$MINTS[$EN].":</div> <div class=\"float winddir ".$oneHour->get_winddir()."\"></div> <div class=\"float\" >-></div> <div class=\"float winddir ".$current->get_winddir()."\"></div>",
                "60 ".$MINTS[$EN].":".$oneHour->get_winddir()."->".$current->get_winddir()), 
		array("<div class=\"float\" >"."60 ".$MINTS[$HEB].":</div> <div class=\"float winddir ".$oneHour->get_winddir()."\"></div> <div class=\"float\" >-></div> <div class=\"float winddir ".$current->get_winddir()."\"></div>",
                "60 ".$MINTS[$HEB].":".$oneHour->get_winddir()."->".$current->get_winddir()), 
		array("<div class=\"float\" >"."60 ".$MINTS[$RU].":</div> <div class=\"float winddir ".$oneHour->get_winddir()."\"></div> <div class=\"float\" >-></div> <div class=\"float winddir ".$current->get_winddir()."\"></div>",
                "60 ".$MINTS[$RU].":".$oneHour->get_winddir()."->".$current->get_winddir()), 
		array("<div class=\"float\" >"."60 ".$MINTS[$FR].":</div> <div class=\"float winddir ".$oneHour->get_winddir()."\"></div> <div class=\"float\" >-></div> <div class=\"float winddir ".$current->get_winddir()."\"></div>",
                "60 ".$MINTS[$FR].":".$oneHour->get_winddir()."->".$current->get_winddir()), 
		array("<div class=\"float\" >"."60 ".$MINTS[$AR].":</div> <div class=\"float winddir ".$oneHour->get_winddir()."\"></div> <div class=\"float\" >-></div> <div class=\"float winddir ".$current->get_winddir()."\"></div>",
                "60 ".$MINTS[$AR].":".$oneHour->get_winddir()."->".$current->get_winddir())), 
		 "?section=graph&amp;graph=winddir.php&amp;profile=1");
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
		array("<div class=\"float\" >"."30 ".$MINTS[$EN].":</div> <div class=\"float winddir ".$min30->get_winddir()."\"></div> <div class=\"float\" >-></div> <div class=\"float winddir ".$current->get_winddir()."\"></div>",
                     "30 ".$MINTS[$EN].":".$min30->get_winddir()."->".$current->get_winddir()),
		array("<div class=\"float\" >"."30 ".$MINTS[$HEB].":</div> <div class=\"float winddir ".$min30->get_winddir()."\"></div> <div class=\"float\" >-></div> <div class=\"float winddir ".$current->get_winddir()."\"></div>",
                     "30 ".$MINTS[$HEB].":".$min30->get_winddir()."->".$current->get_winddir()),
		array("<div class=\"float\" >"."30 ".$MINTS[$RU].":</div> <div class=\"float winddir ".$min30->get_winddir()."\"></div> <div class=\"float\" >-></div> <div class=\"float winddir ".$current->get_winddir()."\"></div>",
                     "30 ".$MINTS[$RU].":".$min30->get_winddir()."->".$current->get_winddir()),
		array("<div class=\"float\" >"."30 ".$MINTS[$FR].":</div> <div class=\"float winddir ".$min30->get_winddir()."\"></div> <div class=\"float\" >-></div> <div class=\"float winddir ".$current->get_winddir()."\"></div>",
                     "30 ".$MINTS[$FR].":".$min30->get_winddir()."->".$current->get_winddir()),
		array("<div class=\"float\" >"."30 ".$MINTS[$AR].":</div> <div class=\"float winddir ".$min30->get_winddir()."\"></div> <div class=\"float\" >-></div> <div class=\"float winddir ".$current->get_winddir()."\"></div>",
                     "30 ".$MINTS[$AR].":".$min30->get_winddir()."->".$current->get_winddir())), 
		 "?section=graph&amp;graph=winddir.php&amp;profile=1");
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
		array("<div class=\"float\" >".INTERVAL." ".$MINTS[$EN].":</div> <div class=\"float winddir ".$min15->get_winddir()."\"></div> <div class=\"float\" >-></div> <div class=\"float winddir ".$current->get_winddir()."\"></div>", 
                     INTERVAL." ".$MINTS[$EN].":".$min15->get_winddir()."->".$current->get_winddir()), 
		array("<div class=\"float\" >".INTERVAL." ".$MINTS[$HEB].":</div> <div class=\"float winddir ".$min15->get_winddir()."\"></div> <div class=\"float\" >-></div> <div class=\"float winddir ".$current->get_winddir()."\"></div>",
                     INTERVAL." ".$MINTS[$HEB].":".$min15->get_winddir()."->".$current->get_winddir()), 
		array("<div class=\"float\" >".INTERVAL." ".$MINTS[$RU].":</div> <div class=\"float winddir ".$min15->get_winddir()."\"></div> <div class=\"float\" >-></div> <div class=\"float winddir ".$current->get_winddir()."\"></div>",
                     INTERVAL." ".$MINTS[$RU].":".$min15->get_winddir()."->".$current->get_winddir()), 
		array("<div class=\"float\" >".INTERVAL." ".$MINTS[$FR].":</div> <div class=\"float winddir ".$min15->get_winddir()."\"></div> <div class=\"float\" >-></div> <div class=\"float winddir ".$current->get_winddir()."\"></div>",
                     INTERVAL." ".$MINTS[$FR].":".$min15->get_winddir()."->".$current->get_winddir()), 
		array("<div class=\"float\" >".INTERVAL." ".$MINTS[$AR].":</div> <div class=\"float winddir ".$min15->get_winddir()."\"></div> <div class=\"float\" >-></div> <div class=\"float winddir ".$current->get_winddir()."\"></div>",
                     INTERVAL." ".$MINTS[$AR].":".$min15->get_winddir()."->".$current->get_winddir())), 
		 "?section=graph&amp;graph=winddir.php&amp;profile=1");
	//update_action ("WindShift", $extrainfo, $ALT);
}
if (($yestsametime->get_tempchange() > 3)&&($yestsametime->get_tempchange() < 20))
{
    updateSigWeather(
		"profile2/temp.php?lang={$lang_idx}", 
		$DRASTIC_TEMP_RISE, 
		 array (
		array("24 ".$HOURS[$EN].": ".get_param_tag($yestsametime->get_tempchange(), true, "°") , 
              "24 ".$HOURS[$EN].": ".get_param_tag($yestsametime->get_tempchange(), false, "°")) , 
		array("24 ".$HOURS[$HEB].": ".get_param_tag($yestsametime->get_tempchange(), true, "°"),
              "24 ".$HOURS[$HEB].": ".get_param_tag($yestsametime->get_tempchange(), false, "°")), 
		array("24 ".$HOURS[$RU].": ".get_param_tag($yestsametime->get_tempchange(), true, "°"),
              "24 ".$HOURS[$RU].": ".get_param_tag($yestsametime->get_tempchange(), false, "°")), 
		array("24 ".$HOURS[$FR].": ".get_param_tag($yestsametime->get_tempchange(), true, "°"),
              "24 ".$HOURS[$FR].": ".get_param_tag($yestsametime->get_tempchange(), false, "°")), 
		array("24 ".$HOURS[$AR].": ".get_param_tag($yestsametime->get_tempchange(), true, "°"),
              "24 ".$HOURS[$AR].": ".get_param_tag($yestsametime->get_tempchange(), false, "°"))), 
		 "?section=graph&amp;graph=temp.php&amp;profile=2");
	//update_action ("TempRise", $extrainfo, $ALT);
}
if (($yestsametime->get_tempchange() < -4)&&($yestsametime->get_tempchange() != ""))
{
    updateSigWeather(
		"profile2/temp.php?lang={$lang_idx}", 
		$DRASTIC_TEMP_DROP, 
		 array (
		array("24 ".$HOURS[$EN].": ".get_param_tag($yestsametime->get_tempchange(), true, "°") ,
              "24 ".$HOURS[$EN].": ".get_param_tag($yestsametime->get_tempchange(), false, "°")."°") ,
		array("24 ".$HOURS[$HEB].": ".get_param_tag($yestsametime->get_tempchange(), true, "°"),
              "24 ".$HOURS[$HEB].": ".get_param_tag($yestsametime->get_tempchange(), false, "°")."°"),
		array("24 ".$HOURS[$RU].": ".get_param_tag($yestsametime->get_tempchange(), true, "°"),
              "24 ".$HOURS[$RU].": ".get_param_tag($yestsametime->get_tempchange(), false, "°")."°"),
		array("24 ".$HOURS[$FR].": ".get_param_tag($yestsametime->get_tempchange(), true, "°"),
              "24 ".$HOURS[$FR].": ".get_param_tag($yestsametime->get_tempchange(), false, "°")."°"),
		array("24 ".$HOURS[$AR].": ".get_param_tag($yestsametime->get_tempchange(), true, "°"),
              "24 ".$HOURS[$AR].": ".get_param_tag($yestsametime->get_tempchange(), false, "°")."°")), 
		 "?section=graph&amp;graph=temp.php&amp;profile=2");
	//update_action ("TempDrop", $extrainfo, $ALT);
}
if (($yestsametime->get_humchange() >= 30)&&($yestsametime->get_humchange() < 90))
{
	updateSigWeather(
	"profile2/humwind.php?level=1&amp;freq=2&amp;datasource=downld02", 
	$DRASTIC_HUM_RISE, 
	 array (
	array("24 ".$HOURS[$EN].": ".get_param_tag($yestsametime->get_humchange(), true, "%") ,
          "24 ".$HOURS[$EN].": ".get_param_tag($yestsametime->get_humchange(), false, "%")."%") ,
	array("24 ".$HOURS[$HEB].": ".get_param_tag($yestsametime->get_humchange(), true, "%"),
          "24 ".$HOURS[$HEB].": ".get_param_tag($yestsametime->get_humchange(), false, "%")."%"),
	array("24 ".$HOURS[$RU].": ".get_param_tag($yestsametime->get_humchange(), true, "%"),
          "24 ".$HOURS[$RU].": ".get_param_tag($yestsametime->get_humchange(), false, "%")."%"),
	array("24 ".$HOURS[$FR].": ".get_param_tag($yestsametime->get_humchange(), true, "%"),
          "24 ".$HOURS[$FR].": ".get_param_tag($yestsametime->get_humchange(), false, "%")."%"),
	array("24 ".$HOURS[$AR].": ".get_param_tag($yestsametime->get_humchange(), true, "%"),
          "24 ".$HOURS[$AR].": ".get_param_tag($yestsametime->get_humchange(), false, "%")."%")), 
	 "?section=graph&amp;graph=OutsideHumidityHistory.gif&amp;profile=2");
	//update_action ("HumRise", $extrainfo, $ALT);
}
if (($yestsametime->get_humchange() <= -30)&&($yestsametime->get_humchange() != ""))
{
	updateSigWeather(
	"profile2/humwind.php?level=1&amp;freq=2&amp;datasource=downld02", 
	$DRASTIC_HUM_DROP, 
	 array (
	array("24 ".$HOURS[$EN].": ".get_param_tag($yestsametime->get_humchange(), true, "%") ,
          "24 ".$HOURS[$EN].": ".get_param_tag($yestsametime->get_humchange(), false)."%" ),
	array("24 ".$HOURS[$HEB].": ".get_param_tag($yestsametime->get_humchange(), true, "%"),
          "24 ".$HOURS[$HEB].": ".get_param_tag($yestsametime->get_humchange(), false, "%")."%"),
	array("24 ".$HOURS[$RU].": ".get_param_tag($yestsametime->get_humchange(), true, "%"),
          "24 ".$HOURS[$RU].": ".get_param_tag($yestsametime->get_humchange(), false, "%")."%"),
	array("24 ".$HOURS[$FR].": ".get_param_tag($yestsametime->get_humchange(), true, "%"),
          "24 ".$HOURS[$FR].": ".get_param_tag($yestsametime->get_humchange(), false, "%")."%"),
	array("24 ".$HOURS[$AR].": ".get_param_tag($yestsametime->get_humchange(), true, "%"),
          "24 ".$HOURS[$AR].": ".get_param_tag($yestsametime->get_humchange(), false, "%")."%")), 
	 "?section=graph&amp;graph=OutsideHumidityHistory.gif&amp;profile=2");
	//update_action ("HumDrop", $extrainfo, $ALT);
}
if ((($current->get_windspd() > 30)&&($min10->get_windspd() > 22))||($current->get_windspd() > 45)){
    
	$extrainfoS = array(array ($current->get_windspd().$KMH[$EN]." ".$WIND_GUST[$EN].":".$today->get_highwind(), 
								$current->get_windspd().$KMH[$EN]." ".$WIND_GUST[$EN].":".$today->get_highwind()),
	                     array($current->get_windspd().$KMH[$HEB].$KMH[$HEB]." ".$WIND_GUST[$HEB].":".$today->get_highwind().$KMH[$HEB], 
						 	  $current->get_windspd().$KMH[$HEB].$KMH[$HEB]." ".$WIND_GUST[$HEB].":".$today->get_highwind().$KMH[$HEB]),
	                     array($current->get_windspd().$KMH[$RU].$KMH[$RU]." ".$WIND_GUST[$RU].":".$today->get_highwind().$KMH[$RU], 
						 	   $current->get_windspd().$KMH[$RU].$KMH[$RU]." ".$WIND_GUST[$RU].":".$today->get_highwind().$KMH[$RU]),
	                     array($current->get_windspd().$KMH[$FR].$KMH[$FR]." ".$WIND_GUST[$FR].":".$today->get_highwind().$KMH[$FR], 
						 	   $current->get_windspd().$KMH[$FR].$KMH[$FR]." ".$WIND_GUST[$FR].":".$today->get_highwind().$KMH[$FR]),
	                     array($current->get_windspd().$KMH[$AR].$KMH[$AR]." ".$WIND_GUST[$AR].":".$today->get_highwind().$KMH[$AR], 
						 	   $current->get_windspd().$KMH[$AR].$KMH[$AR]." ".$WIND_GUST[$AR].":".$today->get_highwind().$KMH[$AR]));
	updateSigWeather(
	"wind1.jpg", 
	$WINDY, 
	$extrainfoS, 
	"?section=graph&amp;graph=WindSpeedHistory.gif&amp;profile=1");
	update_action ("Windy", $extrainfo, $ALT);
	
}
else if (($current->get_windspd() == 0)&&($min10->get_windspd() == 0))
{
     /*   $pic = "nowind.jpg";
        $ALT = $NO_WIND;
		$url = "?section=graph.php&amp;graph=wind.php&amp;profile=1";
		$extrainfo = "";
		updateSigWeather($pic, $NO_WIND, $extrainfo, $url);*/
		//if ($hour > 6)
		//	update_action ("NoWind", $extrainfo, $ALT);
}
if ($today->get_et() > 7)
{
   updateSigWeather(
	"dry.gif", 
	array ($HIGH_ET[$EN], $HIGH_ET[$HEB], $HIGH_ET[$RU], $HIGH_ET[$FR], $HIGH_ET[$AR]), 
	 array (
			array($ET[$EN]." ".$TILL_NOW[$EN]." ".$today->get_et()." mm", 
                  $ET[$EN]." ".$TILL_NOW[$EN]." ".$today->get_et()." mm"), 
			array($ET[$HEB]." ".$TILL_NOW[$HEB]." ".$today->get_et()." מ'מ",
                  $ET[$HEB]." ".$TILL_NOW[$HEB]." ".$today->get_et()." מ'מ"), 
			array($ET[$RU]." ".$TILL_NOW[$RU]." ".$today->get_et()." מ'מ",
                  $ET[$RU]." ".$TILL_NOW[$RU]." ".$today->get_et()." מ'מ"), 
			array($ET[$FR]." ".$TILL_NOW[$FR]." ".$today->get_et()." מ'מ",
                  $ET[$FR]." ".$TILL_NOW[$FR]." ".$today->get_et()." מ'מ"), 
			array($ET[$AR]." ".$TILL_NOW[$AR]." ".$today->get_et()." מ'מ",
                  $ET[$AR]." ".$TILL_NOW[$AR]." ".$today->get_et()." מ'מ")), 
	"?section=graph&amp;graph=ETHistory.gif&amp;profile=1"); 
        update_action (CustomAlert::HighET, $extrainfo, $ALT);
}
if ($hour > 16 && $hour < 21 && $today->get_sunshinehours() < 2.3 && $today->get_sunshinehours() != "")
{
   updateSigWeather(
	"cold.gif", 
	array ($LOW_RAD[$EN], $LOW_RAD[$HEB], $LOW_RAD[$RU], $LOW_RAD[$FR], $LOW_RAD[$AR]), 
	 array (
			array($today->get_sunshinehours()." ".$SUNSHINEHOURS[$EN]." ".$TODAY[$EN]." ", 
				  $today->get_sunshinehours()." ".$SUNSHINEHOURS[$EN]." ".$TODAY[$EN]." "),
			array($today->get_sunshinehours()." ".$SUNSHINEHOURS[$HEB]." ".$TODAY[$HEB]." ",
			      $today->get_sunshinehours()." ".$SUNSHINEHOURS[$HEB]." ".$TODAY[$HEB]." "),
			array($today->get_sunshinehours()." ".$SUNSHINEHOURS[$RU]." ".$TODAY[$RU]." ",
			      $today->get_sunshinehours()." ".$SUNSHINEHOURS[$RU]." ".$TODAY[$RU]." "),
			array($today->get_sunshinehours()." ".$SUNSHINEHOURS[$FR]." ".$TODAY[$FR]." ",
			      $today->get_sunshinehours()." ".$SUNSHINEHOURS[$FR]." ".$TODAY[$FR]." "),
			array($today->get_sunshinehours()." ".$SUNSHINEHOURS[$AR]." ".$TODAY[$AR]." ",
			      $today->get_sunshinehours()." ".$SUNSHINEHOURS[$AR]." ".$TODAY[$AR]." ")), 
	"?section=graph&amp;graph=rad.php&amp;profile=1"); 
        update_action (CustomAlert::LowRadiation, $extrainfo, $ALT);
}
if (($lowtemp_diffFromAv > 2) 
	&& ($hightemp_diffFromAv > 3) 
	&& (!$isHeatWave) 
	&& ($monthAverge->get_hightemp() != ""))
{
       
	updateSigWeather(
	"hot.gif", 
	array ($WARMER_THAN_AVERAGE[$EN]." ".$TODAY[$EN], $WARMER_THAN_AVERAGE[$HEB]." ".$TODAY[$HEB], $WARMER_THAN_AVERAGE[$RU]." ".$TODAY[$RU], $WARMER_THAN_AVERAGE[$FR]." ".$TODAY[$FR], $WARMER_THAN_AVERAGE[$AR]." ".$TODAY[$AR]), 
	 array (
			array($TILL_NOW[$EN]." ".$MAX[$EN]." ".$today->get_hightemp(), 
                  $TILL_NOW[$EN]." ".$MAX[$EN]." ".$today->get_hightemp()."°"), 
			array($TILL_NOW[$HEB]." ".$MAX[$HEB]." ".$today->get_hightemp(),
                  $TILL_NOW[$HEB]." ".$MAX[$HEB]." ".$today->get_hightemp()."°"), 
			array($TILL_NOW[$RU]." ".$MAX[$RU]." ".$today->get_hightemp(),
                  $TILL_NOW[$RU]." ".$MAX[$RU]." ".$today->get_hightemp()."°"), 
			array($TILL_NOW[$FR]." ".$MAX[$FR]." ".$today->get_hightemp(),
                  $TILL_NOW[$FR]." ".$MAX[$FR]." ".$today->get_hightemp()."°"), 
			array($TILL_NOW[$AR]." ".$MAX[$AR]." ".$today->get_hightemp(),
                  $TILL_NOW[$AR]." ".$MAX[$AR]." ".$today->get_hightemp()."°")), 
	"?section=graph&amp;graph=temp.php&amp;profile=2");
		//update_action ("Warmer", $extrainfo, $ALT);
}
if ($current->get_temp3() > c_or_f(50))
{
	updateSigWeather("hot.gif" , $HOT_GROUND,
	array(array($ROAD[$EN]." ".$TEMP[$EN].": ".$current->get_temp3(), 
	            $ROAD[$EN]." ".$TEMP[$EN].": ".$current->get_temp3()), 
          array($TEMP[$HEB]." ".$ROAD[$HEB].": ".$current->get_temp3(),
			    $TEMP[$HEB]." ".$ROAD[$HEB].": ".$current->get_temp3()), 
          array($TEMP[$RU]." ".$ROAD[$RU].": ".$current->get_temp3(),
			    $TEMP[$RU]." ".$ROAD[$RU].": ".$current->get_temp3()), 
          array($TEMP[$FR]." ".$ROAD[$FR].": ".$current->get_temp3(),
			    $TEMP[$FR]." ".$ROAD[$FR].": ".$current->get_temp3()), 
          array($TEMP[$AR]." ".$ROAD[$AR].": ".$current->get_temp3(),
			    $TEMP[$AR]." ".$ROAD[$AR].": ".$current->get_temp3())), 
               "?section=graph&amp;graph=temp3LatestArchive.php&amp;profile=2");
    //update_action (CustomAlert::HotGround, $extrainfo, $ALT);
}
if (($current->get_rainchance() == 0)&&
	($current->get_pm10() < 80) &&
 ((($current->get_temp('C') > 14)&&($current->get_temp('C') <= 18)&&($min10->get_windspd() == 0))||
        (($current->get_temp('C') > 18)&&($current->get_temp('C') <= 24)&&($min10->get_windspd() < 4))||
        (($current->get_temp('C') > 24)&&($current->get_temp('C') < 28)&&($min10->get_windspd() > 15))))
{
  $random_good_time = rand(0, count($GOOD_TIME)-1);
  updateSigWeather(
    "nowind.jpg", 
    $GOOD_TIME[$random_good_time], 
    array(array("",""),array("","")), 
    "?section=graph&amp;graph=temp.php&amp;profile=1");

}
if (isOpenOrClose() == $CLOSE[$lang_idx])
{
	updateRecommendations(isOpenOrClose(), Activities::OpenWindow, Recommendations::No);
}
else
{
	updateRecommendations(isOpenOrClose(), Activities::OpenWindow, Recommendations::Yes);
}
$monthToExplore = ($day > 3 ? $month : getPrevMonth($month));
$yearToExplore = ($month == 1 && $day <= 3 ? $year - 1 : $year);
$monthW = ($day > 3 ? $monthInWord : $prevMonthInWord);
$dep = getDepFromNorm($monthToExplore);
$warmcold = ($dep >= 0 ? $WARMER_THAN_AVERAGE : $COLDER_THAN_AVERAGE);
if ($dep == 0)
{
		$warmcold = $LIKE_AVERAGE;
}
$monthSituation = array();
array_push($monthSituation, array('sig' => array($warmcold[$EN], $warmcold[$HEB], $warmcold[$RU], $warmcold[$FR], $warmcold[$AR]), 'pic' => $picP, 
		'extrainfo' => array($monthW." ".$yearToExplore." is ".$warmcold[$EN]." ".$ON[$EN]." ".abs($dep)."°"."",
							 $monthW." ".$yearToExplore." ".$warmcold[$HEB]." ".$ON[$HEB]." ".abs($dep)."°",
							 $monthW." ".$yearToExplore." ".$warmcold[$RU]." ".$ON[$RU]." ".abs($dep)."°",
							 $monthW." ".$yearToExplore." ".$warmcold[$FR]." ".$ON[$FR]." ".abs($dep)."°",
							 $monthW." ".$yearToExplore." ".$warmcold[$AR]." ".$ON[$AR]." ".abs($dep)."°"), 'url' => $urlP));
if (false) 
{
	
	updateSigWeather(
	($dep >= 0 ? "hot.gif" : "cold.jpg"), 
	array($warmcold[$EN], $warmcold[$HEB], $warmcold[$RU], $warmcold[$FR], $warmcold[$AR]), 
	($dep >= 0 ? (abs($dep) > 0 ?
			array(array($monthW." ".$yearToExplore." is ".$warmcold[$EN]." ".$ON[$EN]." ".abs($dep)."°"."",
                        $monthW." ".$yearToExplore." is ".$warmcold[$EN]." ".$ON[$EN]." ".abs($dep)."°"),
			array($monthW." ".$yearToExplore." ".$warmcold[$HEB]." ".$ON[$HEB]."".abs($dep)."°"."",
                  $monthW." ".$yearToExplore." ".$warmcold[$HEB]." ".$ON[$HEB]." ".abs($dep)."°"),
			array($monthW." ".$yearToExplore." ".$warmcold[$RU]." ".$ON[$RU]."".abs($dep)."°"."",
                  $monthW." ".$yearToExplore." ".$warmcold[$RU]." ".$ON[$RU]." ".abs($dep)."°"),
			array($monthW." ".$yearToExplore." ".$warmcold[$FR]." ".$ON[$FR]."".abs($dep)."°"."",
                  $monthW." ".$yearToExplore." ".$warmcold[$FR]." ".$ON[$FR]." ".abs($dep)."°"),
			array($monthW." ".$yearToExplore." ".$warmcold[$AR]." ".$ON[$AR]."".abs($dep)."°"."",
                  $monthW." ".$yearToExplore." ".$warmcold[$AR]." ".$ON[$AR]." ".abs($dep)."°")) : array("", "", "", "", ""))
			: 
			array(array($monthW." ".$yearToExplore." is ".$warmcold[$EN]." ".$ON[$EN]." ".abs($dep)."°"."",
                        $monthW." ".$yearToExplore." is ".$warmcold[$EN]." ".$ON[$EN]." ".abs($dep)."°"),
			array($monthW." ".$yearToExplore." ".$warmcold[$HEB]." ".$ON[$HEB]."".abs($dep)."°"."",
                  $monthW." ".$yearToExplore." ".$warmcold[$HEB]." ".$ON[$HEB]." ".abs($dep)."°"),
			array($monthW." ".$yearToExplore." ".$warmcold[$RU]." ".$ON[$RU]."".abs($dep)."°"."",
                  $monthW." ".$yearToExplore." ".$warmcold[$RU]." ".$ON[$RU]." ".abs($dep)."°"),
			array($monthW." ".$yearToExplore." ".$warmcold[$FR]." ".$ON[$FR]."".abs($dep)."°"."",
                  $monthW." ".$yearToExplore." ".$warmcold[$FR]." ".$ON[$FR]." ".abs($dep)."°"),
			array($monthW." ".$yearToExplore." ".$warmcold[$AR]." ".$ON[$AR]."".abs($dep)."°"."",
                  $monthW." ".$yearToExplore." ".$warmcold[$AR]." ".$ON[$AR]." ".abs($dep)."°"))), 
							"?section=".FILE_THIS_MONTH);
	
}
//update_action ("Warmer", $extrainfo, $ALT);





/******** generating message to Email *********/
$messageToSend = array();
if (count($messageAction) > 0) {
    foreach ($messageAction as $message) {
        //logger ("messageAction:".implode(" || ",$message));
        array_push ($messageToSend , $message);
    }
}


for ($i=0 ; $i < count($messageBrokenToSend) ; $i++)
{
    logger("extracting messageBrokenToSend: ". implode(" || ",$messageBrokenToSend), 0, "sigweatherCalc", "sigweather", "messageBrokenToSend");
    for ($j=0 ; $j < count($messageBrokenToSend[$i]) ; $j++)
    {
        array_push($messageToSend, $messageBrokenToSend[$i][$j]);//$messageBrokenToSend[$i][$j][$HEB]
        logger("pushing messageBrokenToSend: ". implode(" || ",$messageBrokenToSend[$i][$j]), 0, "sigweatherCalc", "sigweather", "messageBrokenToSend");
    }
}

if 	(count($EmailSubject) == 0)
        $EmailSubject = array("02ws Update Service", "שירות עדכון ירושמיים");

if (count($messageToSend) > 0) 
{
        logger("messageToSend count:".count($messageToSend), 0, "sigweatherCalc", "sigweather", "messageBrokenToSend");
        foreach ($messageToSend as $message) {
            $message = str_replace("\"", "'", $message);
            logger ("messageToSend:".implode(" || ",$EmailSubject)." ".implode(" / ",$message), 0, "sigweatherCalc", "sigweather", "messageBrokenToSend");
        }
        send_Email($messageToSend, ALL, EMAIL_ADDRESS, "", "", $EmailSubject);
 
 } 
	
/************************************************************************/



    $sub = $_GET['sub'];
   
?>