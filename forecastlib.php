<?
$station_code = TAF_STATION;//TAF_STATION; 
$shift_forecast_time = 0;
$taf_file = "cache/".$station_code.".txt"; 
$taf_server_file = "/data/forecasts/taf/stations/".$station_code.".TXT"; 
$taf_decoded = "http://www8.landings.com/cgi-bin/parse_wthr_script.pl?pass=37875119&amp;apt_id=".$station_code."&amp;type=TAF";  
$taf_decode_help = "http://aviationweather.gov/static/help/taf-decode.shtml";  
$taf_txt = "http://weather.noaa.gov/pub/data/forecasts/taf/stations/".$station_code.".TXT"; 
$taf_link = "http://weather.hometownlocator.com/Local-Weather.php?config=&amp;forecast=zandh&amp;pands=".$station_code."";
$forecast_link = get_query_edited_url(get_url(), 'section', 'forecast.php');
$webcam_link = get_query_edited_url(get_url(), 'section', 'webCamera.jpg');
$forecastHour = array();
$startTime = "";
$endTime = "";
$startDateTime = "";
$endDateTime = "";
$plusminus = 0;

function rainExistsInTaf ($forecast_title, $priority)
	{
		global $BETWEEN, $FROM, $TO, $RAIN_WILL_STOP, $lang_idx, $RAIN, $DRIZZLE, $HAIL;
		$rainStoppedExists = false;
		// if rain is on the same segment - it does not exist
		if ($_GET["debug"] >= 3)
			echo "rainExistsInTaf: last: ".$forecast_title[count($forecast_title) - 1]." beforelast: ".$forecast_title[count($forecast_title) - 2]."<br/>";
 
		if ((stristr($forecast_title[count($forecast_title) - 1], $RAIN[$lang_idx])) ||
			(stristr($forecast_title[count($forecast_title) - 2], $RAIN[$lang_idx])) ||
			(stristr($forecast_title[count($forecast_title) - 1], $DRIZZLE[$lang_idx])) ||
			(stristr($forecast_title[count($forecast_title) - 2], $DRIZZLE[$lang_idx])) ||
			(stristr($forecast_title[count($forecast_title) - 1], $HAIL[$lang_idx])) ||
			(stristr($forecast_title[count($forecast_title) - 2], $HAIL[$lang_idx]))) 
			return false;
 
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
		global $BETWEEN, $FROM, $TO, $RAIN_WILL_STOP, $lang_idx;
 
		for ($i = 0; $i < count($forecast_title); $i++) {
			if (stristr ($forecast_title[$i], $BETWEEN[$lang_idx]) && stristr ($forecast_title[$i], $TO[$lang_idx]))
				return true;
		}
		return false;
	}
 
	function getWindSpeed($windstr)
	{
		return substr($windstr, 3, 2);
	}
	function getStartTime ($timerange)
	{
		// daylight saving = + 2; regular = + 1
		if (strlen($timerange) == 4)
			$startpos = 0;
		else
			$startpos = 2;
		$startTime = substr($timerange, $startpos, 2) + 2 + $shift_forecast_time;
		$startTime = ($startTime >= 24 ? $startTime - 24 : $startTime);
		return $startTime;
	}
        function getPlusMinus ($starthour, $endhour)
        {
            $avTime = getAverageTime ($starthour, $endhour);
            if ($_GET['debug'] > 3)
           echo "avtime=".$avTime." start=".$starthour." end=".$endhour;
            if ($avTime < $starthour)
             return ($avTime + 24) - $starthour;
            else
             return $avTime - $starthour;
        }
        function getAverageTime ($starthour, $endhour)
        {
            if ($endhour < $starthour){
                $average = round((($endhour + 24) + $starthour) / 2);
                if ($average > 24)
                    return $average - 24;
                 else
                     return $average;
                
            }
            else {
                return round(($endhour + $starthour)/2) ;
            }
        }
	function getStartDateTime ($timerange, $plusminus)
	{
            global $yearF, $monthF, $shift_forecast_time;
            if (strlen($timerange) < 2)
                    return null;

            // daylight saving = + 2; regular = + 1
            if (strlen($timerange) == 4)
                    $startpos = 0;
            else
                    $startpos = 2;
            $startHour = substr($timerange, $startpos, 2) + 2 + $shift_forecast_time;
            $startday = substr($timerange, 0, 2);
            if ($startHour >= 24)
            {
                    $startHour = $startHour - 24;
                    $startday = $startday + 1;
            }
            $endHour = getEndTime($timerange);
            if ($plusminus)
            {
                 $startHourAv = getAverageTime($startHour, $endHour);
                 if ($startHourAv < $startHour)
                     $startday = $startday + 1;
                 $startHour = $startHourAv;
            }
            
            return mktime ($startHour, 0, 0, $monthF, $startday , $yearF);
	}
	function getEndDateTime ($timerange)
	{
            global $yearF, $monthF, $shift_forecast_time;
            // daylight saving = + 2; regular = + 1
            if (strlen($timerange) == 4)
                    $endpos = 2;
            else
                    $endpos = 7;
            $endHour = substr($timerange, $endpos, 2) + 2 + $shift_forecast_time;
            $endday = substr($timerange, 5, 2);
            if ($endHour >= 24)
            {
                    $endHour = $endHour - 24;
                    $endday = $endday + 1;
            }

            return  mktime ($endHour, 0, 0, $monthF, $endday , $yearF);
	}
	function getEndTime ($timerange)
	{
		global $shift_forecast_time;
		// daylight saving = + 2; regular = + 1
		if (strlen($timerange) == 4)
			$endpos = 2;
		else
			$endpos = 7;
		$endTime = substr($timerange, $endpos, 2) + 2 + $shift_forecast_time;
		$endTime = ($endTime >= 24 ? $endTime - 24 : $endTime);
		return $endTime;
	}
 
	function isTom ($timetaf, $timeFromTo)
	{
		global $TOMORROW, $lang_idx;
		if ($timeFromTo < $timetaf)
			return " ".$TOMORROW[$lang_idx]." ";
		else
			return "";
	}
	function isLastTokenIsProb()
	{
		global $lang_idx, $forecast_title, $GOOD_CHANCE_FOR, $LOW_CHANCE_FOR;
		//if ($_GET["debug"] >= 3)
                //    echo "<br />LastToken:".trim($forecast_title[count($forecast_title)-2]);
	    return (trim($forecast_title[count($forecast_title)-2])==trim($LOW_CHANCE_FOR[$lang_idx])||trim($forecast_title[count($forecast_title)-2])==trim($GOOD_CHANCE_FOR[$lang_idx]));
	}
 
        function updateForecastHour($currentPri, $title, $icon){
            global $forecastHour, $startDateTime, $plusminus, $endDateTime, $new_line, $same_sigment, $year, $priority, $forecast_title, $isProb;
 
			if ($_GET["debug"] >= 3)
				{
					echo "inUpdateForecastHour--> startDateTime=";
					if ($startDateTime > 0)
						echo date(" H d/m/Y", $startDateTime);
					echo " endDateTime=";
					if ($endDateTime > 0)
						echo date(" H d/m/Y", $endDateTime);
						
					echo  "title=".$title." CurrentPri=".$currentPri;
				}
	   
            foreach ($forecastHour as &$hour_f){
				$currentDateTime = $hour_f['currentDateTime'];
		if (($currentDateTime == $startDateTime) && $plusminus > 0)	
                    $hour_f['plusminus'] = $plusminus;
                if ((($currentDateTime >= $startDateTime) &&
                    ($currentDateTime <= $endDateTime))||
					(($currentDateTime >= $startDateTime) &&
                    ($endDateTime==""))||
                    (($startDateTime=="")&&($endDateTime==""))){
                    if ($_GET["debug"] >= 3)
                    echo "<br />newline=".$new_line." forecast_title=".count($forecast_title)." p=".$hour_f['priority']." icon=".$icon." plusminus=".$hour_f['plusminus']." in ".date("H d/m/y", $hour_f['currentDateTime'])." (".$hour_f['time']."): ";
                    /*if (($icon != "")&&($new_line))
					{
                        $hour_f['icon'] = $icon;
						if ($_GET["debug"] >= 3)
							 echo " icon into ".$icon;
					}*/
					if ($icon == "wind"){
						$hour_f['wind'] = $title;
						if ($_GET["debug"] >= 3){
							echo " wind into ".$title;
						}
						continue;
					}
		     
		     $last_priority = $hour_f['priority'];
		     if (($icon != "")
				 &&(($currentPri > $hour_f['priority'] )||($new_line)))
			{
				$forecast_img = $icon;
				if (($currentPri <= 55)&&(($hour_f['time']>19)||($hour_f['time']<6)))
					$forecast_img = "forcast_moon.png";
				$hour_f['icon'] = $forecast_img;
				if ($_GET["debug"] >= 3){
					 echo " icon into ".$forecast_img;
					 echo " p into ".$hour_f['priority'];
					 }
			}
                        
			 if ((($last_priority <= 35)&&(!$isProb))||(($new_line)&&(!isLastTokenIsProb())))
			 {
			 	$hour_f['title'] = $title;
				if ($_GET["debug"] >= 3)
				 echo	" + title ".$title." truncated"; 
			 }
                         else if (($currentPri > $hour_f['priority'] )||(isLastTokenIsProb()))
			{   
				$comatoappend = " ";
				if ((!isLastTokenIsProb())&&($hour_f['title']!=="")) $comatoappend = ", ";
				$hour_f['title'] .= $comatoappend.$title;
				if ($_GET["debug"] >= 3)
				 echo	" + title ".$title." appended"; 
			 }
			
			 $hour_f['priority'] = $currentPri;
			
                    if ((((!$new_line)||($same_sigment))&&($currentPri > 40))||(($currentPri > $hour_f['priority'])&&($hour_f['priority']>50)))
					{
                                            
                                            /* if (($icon != "")&&($currentPri > $hour_f['priority'] ))
						{
							$hour_f['icon'] = $icon;
							$hour_f['priority'] = $currentPri;
							if ($_GET["debug"] >= 3){
								 echo " icon into ".$icon;
								 echo " p into ".$hour_f['priority'];
								 }
						}   
                                                $hour_f['title'] .= $title."<br />";
						if ($_GET["debug"] >= 3)
						 echo	" + title appended<br />";*/
					}
                          else
					{
					   /* if (($icon != "")&&($currentPri > $hour_f['priority']))
						{
							$hour_f['icon'] = $icon;
							if ($_GET["debug"] >= 3)
								 echo " icon into ".$icon;
						}
						$hour_f['title'] = $title."<br />";
						$hour_f['priority'] = $currentPri;
						if ($_GET["debug"] >= 3){
								  echo " p into ".$hour_f['priority'];
								 echo	" + title appended<br />";
								 }*/
						 
					}
 
                }
 
            }
 
        }
 
	function updateForecast($currentPri, $title, $pic)
	{
		global $priority, $forecast_title, $taf_pic, $last_priority, $title_pic, $new_line, $isProb, $prob_mag, $GOOD_CHANCE_FOR, $LOW_CHANCE_FOR, $lang_idx, $forecastHour, $same_sigment, $startTime, $endTimeForFH, $current, $hour;
 
		 $last_priority = $priority;
		 if ($_GET["debug"] >= 3)
		{
			echo "<br/>inUpdateForecast--> title=".$title." currentPri=".$currentPri." last_priority=".$last_priority." priority=".$priority." taf_pic=".$taf_pic." count=".count($forecast_title)."  new_line=".$new_line."  isProb=".$isProb."<br/>";
		}
		if (count($forecast_title) == 1){
			if ($currentPri<=20)
				$current->set_cloudiness(0);
			else if ($currentPri<=25)
				$current->set_cloudiness(2);
			else if ($currentPri<=35)
				$current->set_cloudiness(4);
			else if ($currentPri<=40)
				$current->set_cloudiness(6);
			else if (($currentPri==50)||($currentPri==55)) // dust
				$current->set_cloudiness(2);
			else
				$current->set_cloudiness(8);
		}
                
                if ($hour > 9 &&  ((get_sunset_ut() - $current->get_current_time_ut()) > 4000) && $current->get_solarradiation() < 400)
                    $current->set_cloudiness(6);
                 if ($hour > 9 && ((get_sunset_ut() - $current->get_current_time_ut()) > 4000) && $current->get_solarradiation() < 200)
                 {
                     $current->set_cloudiness(8);
                 }
                  if ($_GET["debug"] >= 3)
		{
                      echo "<br/>cloudiness=".$current->get_cloudiness()." ".get_sunset_ut() - $current->get_current_time_ut()." ";
                }
                    
                
		 if ($pic == "wind")
		  {
			updateForecastHour($currentPri, $title, $pic);
			return;
		  }
		  if ($isProb)
		  {
                    $same_sigment = false;
                //if ((stristr ($forecast_title[count($forecast_title) - 1], $TO[$lang_idx]))&&
                      //(stristr ($forecast_title[count($forecast_title) - 1], $FROM[$lang_idx])))
                      //{

                      if ($prob_mag == Chance::Low)
                          $prob_to_put = $LOW_CHANCE_FOR[$lang_idx];
                      else if ($prob_mag == Chance::Good)
                          $prob_to_put = $GOOD_CHANCE_FOR[$lang_idx];
                      else
                          $prob_to_put = $LOW_CHANCE_FOR[$lang_idx];
                      array_push($forecast_title, "$prob_to_put");
                      updateForecastHour($currentPri, "$prob_to_put", "");
                      if ($_GET["debug"] >= 3)
                              echo "<br/>added ".$prob_to_put."<br/>";
                      $isProb = false;
                    $same_sigment = true;
				//}
 
		 }
		 if ($currentPri >= $priority)
		 {
			 if (($priority == 0)||($priority >= 50) || ($currentPri >= 35))
			 {
				 array_push($forecast_title, $title);
				  if ($_GET["debug"] >= 3)
					echo "currentPri >= priority --> added ".$title."<br/>";
			 }
			 else if (!$new_line)
			 {
				  if (count($forecast_title) > 1)
				 {
					$removed = array_pop($forecast_title);
					if ($_GET["debug"] >= 3)
						echo "not new line: removed ".$removed."<br/>";
				 } 
				 array_push($forecast_title, $title);
				  if ($_GET["debug"] >= 3)
					echo "not new line: added ".$title."<br/>";
			 }

                    updateForecastHour($currentPri, $title, $pic);
                                $taf_pic = $pic;
                                $title_pic = $title;
                                $priority = $currentPri;
			 
		 }
		 else if (($new_line)&&($currentPri != $priority))
		 {
				array_push($forecast_title, $title);
				if ($_GET["debug"] >= 3)
				   echo "new_line + currentPri != priority --> added ".$title."<br/>";
				updateForecastHour($currentPri, $title, $pic);
		 }
		 else if (!$same_sigment)
		 { 
			 updateForecastHour($currentPri, $title, "");
	     }
 
		 $new_line = false;
         $same_sigment = true;
	}
 
 
 
 
	if ($_GET["debug"] >= 1)
	echo "<br/><strong>Stared forecast section.....</strong>";
	if ($_GET["debug"] >= 3)
		echo "<br/></b><div align=left>";
 
         $hourindex = 0;
 
 
 
	if ($taf_contents == ""){
		if ((!file_exists($taf_file))||(filesize($taf_file) == 0)||(((time() - filemtime($taf_file)) > 3600)))
		{
			//echo "downloading forecast...<br/>";
			//$ftp = ftp_connect('tgftp.nws.noaa.gov', 21, 10);
			//@ftp_login($ftp, 'anonymous', 'password');
			//@ftp_get($ftp, $taf_file, $taf_server_file, FTP_ASCII);
			//@ftp_close($ftp);
			//echo "downloading file...".$sat_link;
			//echo "downloading file...".$sat_link;
			 $ip = @fopen($taf_txt, "rb");
			 $tp = fopen($taf_file, "wb");
			 while(fwrite($tp,@fread($ip, 4095)));
			   fclose($tp);
			   @fclose($ip);
		}
		$taf_contents = @file_get_contents($taf_file);
		//$_SESSION['taf_contents'] = $taf_contents;
	}
 
	$source = $taf_contents;
	$forecast_title = array();
	$generally="";
        $same_sigment = false;
	$taf_contents = str_replace("<br/>", "", $taf_contents);
	$taf_contents = str_replace("/>", "", $taf_contents);
	$taf_contents = str_replace("<br", "", $taf_contents);
 
	$taf_tokens = tokenizeQuoted($taf_contents);
	//print_r($taf_tokens);
	for ($i = 0; $i < count($taf_tokens); $i++)
	{
		if ($_GET["debug"] >= 3)
			echo "<br/>examining <strong>".$taf_tokens[$i]."</strong>";
		if ($i == 0)
		{
			list($yearF, $monthF, $dayF) = split('[/.-]', $taf_tokens[$i]);
 
          }
                //if ($new_line) $priority = 0;
		$dayC = $dayF;
		if (stristr ($taf_tokens[$i], ":")) {
			$taf_pic = "clear.png";
			$title_pic = "$MOSTLY[$lang_idx] $CLEAR[$lang_idx]";
			$current->set_cloudiness(0);
			$priority = 0;
			$new_line = true;
			$timetaf = (int)$taf_tokens[$i];
                        if ($_GET["debug"] >= 3)
                            echo "<br/>time of taf:".$timetaf;
			array_push($forecast_title, "<span>".$GENERALLY[$lang_idx]." "."</span>");
			 for ($t=$timetaf + 1; $t <= $timetaf+30 ; $t++)
			 {

				  $h = $t % 24;
				 
				  if ($t % 24 == 0)
				 {
					  $time = "00";
				 }
				  else 
					  $time = sprintf("%d", $h);
				 if ($t % 24 == 0)
					 $dayC = $dayC + 1;
				 $currentDateTime =  mktime ($h, 0, 0, $monthF, $dayC , $yearF);
				 array_push($forecastHour, array('id' => $hourindex, 'time' => $time, 'currentDateTime' => $currentDateTime, 'plusminus' => 0, 'change' => 0, 'temp' => "", 'wind' => 0, 'icon' => "", 'title' => "", 'cloth' => "", 'priority' => 0));
				 $hourindex += 1;
				 
			 }
             		 
 
		}
		if (stristr ($taf_tokens[$i], "KT")) {
			if ($_GET["debug"] >= 3)
				echo " In  WIND<br/>";
			$windspeed = getWindSpeed($taf_tokens[$i]);
			/*if ($windspeed > 30)
				updateForecast($currentPri, $EXTREME_WINDS[$lang_idx], "wind");
			else if ($windspeed > 20)
				updateForecast($currentPri, $STRONG_WINDS[$lang_idx], "wind");
			else if ($windspeed > 10)
				updateForecast($currentPri, $MODERATE_WINDS[$lang_idx], "wind");
			else
				updateForecast($currentPri, $WEAK_WINDS[$lang_idx], "wind");*/
                        updateForecast($currentPri, $windspeed, "wind");
		}
		if (stristr ($taf_tokens[$i], "PROB30")) {
			$isProb = true;
                        $prob_mag = Chance::Low;
		}
                if (stristr ($taf_tokens[$i], "PROB40")) {
			$isProb = true;
                        $prob_mag = Chance::Good;
		}
		if (stristr ($taf_tokens[$i], "RASN")) {
			updateForecast(95, "$RAIN[$lang_idx] $SNOW[$lang_idx]", "rainSnow.png");
 
		}
		else if (stristr ($taf_tokens[$i], "SN"))     {
			updateForecast(100, $SNOW[$lang_idx], "snow.gif");
 
		}
		if ((stristr ($taf_tokens[$i], "GR"))||
			 (stristr ($taf_tokens[$i], "GS")))        {
			updateForecast(90, $HAIL[$lang_idx], "hail.gif");
 
		}
		if (stristr ($taf_tokens[$i], "TSRA"))   {
			updateForecast(85, $THUNDERSTORM[$lang_idx].", ".$RAIN[$lang_idx], "TSRA.gif");
 
		}
		else if (stristr ($taf_tokens[$i], "TS"))   {
			updateForecast(80,$THUNDERSTORM[$lang_idx], "TS.gif");
 
		}
		else if ((stristr ($taf_tokens[$i], "-SHRA"))||
			(stristr ($taf_tokens[$i], "-RA"))){
			updateForecast(75, $LIGHT_RAIN[$lang_idx], "lightrain.gif");
 
		}
		else if (stristr ($taf_tokens[$i], "RA"))    {
			updateForecast(78, $RAIN[$lang_idx], "rainy.gif");
 
		}
		if (stristr ($taf_tokens[$i], "DZ")){
			updateForecast(68, $DRIZZLE[$lang_idx], "showersl2.png");
 
		}
		if (stristr ($taf_tokens[$i], "CB"))   {
			updateForecast(62, $SEVERE_CLOUDS[$lang_idx], "mostlycloudy.png");
 
		}
		if ((stristr ($taf_tokens[$i], "FG")))     {
			updateForecast(60, $FOG[$lang_idx], "fog2.png");
 
		}
		if (stristr ($taf_tokens[$i], "SA")) {
			updateForecast(55, $SANDSTORM[$lang_idx], "dust.png");
 
		}
		if (stristr ($taf_tokens[$i], "DU")) {
			updateForecast(50, $DUST[$lang_idx], "dust.png");
 
		}
		if (stristr ($taf_tokens[$i], "TCU"))   {
			updateForecast(48, $SEVERE_CLOUDS[$lang_idx], "mostlycloudy.png");
 
		}
		if (stristr ($taf_tokens[$i], "BKN"))   {
			$currentPri = 40;
 
			if ($currentPri != $priority){
			     $last_priority = $currentPri;
				// need to delete less important PC lines
				 if (($forecast_title[count($forecast_title) - 1] == $FEW_CLOUDS[$lang_idx])||
					 ($forecast_title[count($forecast_title) - 1] == $PARTLY_CLOUDY[$lang_idx]))
				{
					$removed = array_pop($forecast_title);
					if ($_GET["debug"] >= 3)
						echo "<br/>need to delete less important PC lines: removed ".$removed."<br/>";
				}
 				updateForecast(40, "$MOSTLY[$lang_idx] $CLOUDY[$lang_idx]", "mostlycloudy.png");
				
				if ($priority < $currentPri)
				{
					$priority = $currentPri;
					$taf_pic = "cloudym2.png";
				}
			}
		}
		if (stristr ($taf_tokens[$i], "SCT"))  {
			$currentPri = 35;
 
			if ($currentPri != $priority){
				 // need to delete less important PC lines
				 if ($forecast_title[sizeof($forecast_title) - 1] == $FEW_CLOUDS[$lang_idx])
				{
					$removed = array_pop($forecast_title);
					if ($_GET["debug"] >= 3)
						echo "<br/>need to delete less important PC lines: removed ".$removed."<br/>";
				}
 
				 updateForecast(35, $PARTLY_CLOUDY[$lang_idx], "partlycloudy.png");
				 $last_priority = $currentPri;
				 if ($priority < $currentPri)
				 {
					$priority = $currentPri;
					$taf_pic = "partlycloudy.png";
				 }
 
			}
    	}
		if (stristr ($taf_tokens[$i], "FEW"))  {
 
 
			updateForecast(25, $FEW_CLOUDS[$lang_idx], "pcFew.png");	
		}
		if (stristr ($taf_tokens[$i], "CAVOK")) {
 
			// need to put it anyway becasue of the case when the sky becomes clear
			updateForecast(20, "$MOSTLY[$lang_idx] $CLEAR[$lang_idx]", "clear.png");
 
		}
		if (stristr ($taf_tokens[$i], "NSC"))  {
 
			// need to put it anyway becasue of the case when the sky becomes clear
			updateForecast(18, "$MOSTLY[$lang_idx] $CLEAR[$lang_idx]", "clear.png");
 
		}
		if (stristr ($taf_tokens[$i], "SKC"))  {
 
			// need to put it anyway becasue of the case when the sky becomes clear
			updateForecast(15, "$MOSTLY[$lang_idx] $CLEAR[$lang_idx]", "clear.png");
 
		}
		if (stristr ($taf_tokens[$i], "HZ"))  {
 
//			updateForecast(61, "$HAZE[$lang_idx]", "clear.png");
 
		}
		if ((stristr ($taf_tokens[$i], "FU"))) {
 
			updateForecast(62, "$HAZE[$lang_idx]", "clear.png");
			
		}
                if ((stristr ($taf_tokens[$i], "BL"))) {
 
//			updateForecast(64, "$STRONG_WINDS[$lang_idx]", "");
			
		}
		if ((stristr ($taf_tokens[$i], "BR"))&&(!stristr ($taf_tokens[$i], "<"))) {
 
			updateForecast(63, "$FOG[$lang_idx]", "fogy.png");
 
		}
		if (stristr ($taf_tokens[$i], "TEMPO"))    {
			if ($_GET["debug"] >= 3)
				echo " In  TEMPO<br/>";
			$same_sigment = false;
			if (stristr($taf_tokens[$i+1], "/"))
			{
				$timerange = $taf_tokens[$i+1];
				$startTime = getStartTime($timerange);
				$endTime = getEndTime($timerange);
				$startDateTime = getStartDateTime($timerange, true);
                                
				$endDateTime = getEndDateTime($timerange);
				if ($_GET["debug"] >= 3)
					echo "<br/>examining <strong>".$timerange."</strong>";
			}
			$new_line = true;
			//if (rainExistsInTaf ($forecast_title, $priority)) 
			//	array_push($forecast_title, $RAIN_WILL_STOP[$lang_idx]);
 
			// need to delete irrelavent lines
			// delete the last lines 
			if ((stristr ($forecast_title[count($forecast_title) - 1], $TO[$lang_idx]))&&
				(stristr ($forecast_title[count($forecast_title) - 1], $BETWEEN[$lang_idx])))
			{
				$removed = array_pop($forecast_title); // tempo becmg
				if ($_GET["debug"] >= 3)
					"removed ".$removed."<br/>";
 
			}
			else if (stristr ($forecast_title[count($forecast_title) - 1], $PROB[$lang_idx]))
			{	
				/*$removed = array_pop($forecast_title); // PROB
				if ($_GET["debug"] >= 3)
					echo "removed ".$removed."<br/>";
				$removed = array_pop($forecast_title); // tempo becmg
				if ($_GET["debug"] >= 3)
					echo "removed ".$removed."<br/>";*/
			}
			//array_push($forecast_title,  "<br style=\"line-height:1px\"/>");
 
			$tempotime =  "";
			if ((strlen($timerange) == 9))
			{
				$tempotime .= $BETWEEN[$lang_idx]." ".$startTime.".00 ".isTom($timetaf, $startTime)."-".$endTime.".00: ";
				$i = $i+1;
			}
			else
				$tempotime .= $TEMPO[$lang_idx].": ";
			$tempotime .= "";
 
			array_push($forecast_title, $tempotime);
			if ($_GET["debug"] >= 3)
				echo "<br/> added ".$tempotime;
 
 
		}
 
		if (stristr ($taf_tokens[$i], "BECMG"))    {
 
			$same_sigment = false;
			$timerange = $taf_tokens[$i+1];
			$startTime = getStartTime($timerange);
			$endTime = getEndTime($timerange);
			$startDateTime = getStartDateTime($timerange, true);
                        $plusminus = getPlusMinus($startTime, $endTime);
                        $endDateTime = "";
			$new_line = true;
			if ($_GET["debug"] >= 3)
					echo "<br/>examining <strong>".$timerange."</strong>";
			$i = $i+1;
			//if (rainExistsInTaf ($forecast_title, $priority)) 
			//	array_push($forecast_title, $RAIN_WILL_STOP[$lang_idx]);
 
			// need to delete irrelavent lines without any weather
			// delete the last lines 
			if (((stristr ($forecast_title[count($forecast_title) - 1], $TO[$lang_idx]))&&
				(stristr ($forecast_title[count($forecast_title) - 1], $BETWEEN[$lang_idx])))||(stristr ($forecast_title[count($forecast_title) - 1], $TEMPO[$lang_idx])))
			{
				$removed = array_pop($forecast_title); // tempo becmg
				if ($_GET["debug"] >= 3)
					echo "need to delete irrelavent lines without any weather: removed ".$removed."<br/>";
 
			}
			else if (stristr ($forecast_title[count($forecast_title) - 1], $PROB[$lang_idx]))
			{	
				/*$removed = array_pop($forecast_title); // PROB
				if ($_GET["debug"] >= 3)
					echo "removed ".$removed."<br/>";
				$removed = array_pop($forecast_title); // tempo becmg
				if ($_GET["debug"] >= 3)
					echo "removed ".$removed."<br/>";*/
			}
			//array_push($forecast_title,  "<br style=\"line-height:1px\"/>");
			if ($_GET["debug"] >= 3)
				echo " In  BECMG<br/>";
			
			if ($startTime < 24)
				$tempotime = $BETWEEN[$lang_idx]." ".$startTime.".00".isTom($timetaf, $startTime)."-".$endTime.".00 ";
			$tempotime .=  " ".$BECMG[$lang_idx]." ".$BECMG_TO[$lang_idx];
			$tempotime .= "";
			array_push($forecast_title, $tempotime);
			if ($_GET["debug"] >= 3)
				echo " added ".$tempotime."<br/>";
 
 
		}
 
		if ($_GET["debug"] >= 3)
		{
			echo " <br /> last_priority=".$last_priority." priority=".$priority." taf_pic=".$taf_pic." count=".count($forecast_title)." last=".$forecast_title[count($forecast_title) - 1]." new_line=".$new_line." startTime=".$startDateTime." endTime=".$endDateTime."<br/>";
		}
 
 
	}
	//if (rainExistsInTaf ($forecast_title, $priority)) 
	//		array_push($forecast_title, $RAIN_WILL_STOP[$lang_idx]);
	// remove tempo or becmg if remaining last
	if ((stristr ($forecast_title[sizeof($forecast_title) - 1], $TO[$lang_idx]))||(stristr ($forecast_title[count($forecast_title) - 1], $TEMPO[$lang_idx])))
	{
		$removed = array_pop($forecast_title); // tempo becmg
		if ($_GET["debug"] >= 3)
			echo "removed the last line: ".$removed."<br/>";
 
	}
	if (count($forecast_title) == 1) // generally
	{
		updateForecast(20, "$MOSTLY[$lang_idx] $CLEAR[$lang_idx]", "clear.png");
	}
	if ($_GET["debug"] >= 3)
	{
		echo "number of items in forecast: ".count($forecast_title)."<br/>";
		for ($i = 0; $i < count($forecast_title); $i++) {
			echo $forecast_title[$i]."<br />";
		}
	}	
	//$IMSforecast = get_file_string("http://www.worldweather.org/013/c00043.htm");
	//$IMSforecast =  substr($IMSforecast, strrpos($IMSforecast, "Date"), 300);
	//echo $IMSforecast;
	if ($_GET["debug"] >= 3)
		echo "</div>";
	if ($_GET["debug"] >= 1)
		echo "<strong>finished</strong>";
 
 
	$forcastTicker = "";
	for ($i = 0; $i < count($forecast_title); $i++) {
 
		if ((stristr($forecast_title[$i], ":"))
			||(stristr($forecast_title[$i], $BECMG[$lang_idx]))
			||($i == count($forecast_title) - 1)
			||($i == 0))
		{
			if ($i == count($forecast_title) - 1)
				$forcastTicker .= "<strong>".$forecast_title[$i]."</strong>.";
			else
				$forcastTicker .= $forecast_title[$i];
		}
		else if (stristr($forecast_title[$i], $PROB[$lang_idx]))
			$forcastTicker .= $forecast_title[$i];
		else if (($i < count($forecast_title) - 1) 
				  && ((stristr($forecast_title[$i+1], ":"))
				  || (stristr($forecast_title[$i+1], $BECMG[$lang_idx]))))
		{
			$forcastTicker .= "<strong>".$forecast_title[$i]."</strong>";
			$forcastTicker .= ".&nbsp;";
		}
		else if ((!stristr($forecast_title[$i], "&nbsp;"))
			   &&(!stristr($forecast_title[$i], $PROB[$lang_idx])))
		{
			$forcastTicker .= "<strong>".$forecast_title[$i]."</strong>";
			$forcastTicker .= ", ";
		}
 
 
	}
	$forcastTicker = str_replace("\"", "'", $forcastTicker);
	?>