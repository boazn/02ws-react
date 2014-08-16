<?
//error_reporting(E_ERROR | E_PARSE);
//ini_set("error_reporting", E_ALL);
// taf links
///////////////////////////////////////////////////////
include_once "picasaproxy.php";
$station_code = "LFPG";//TAF_STATION; 
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
$sig_url = $sig[0]['url'];
$sig_title = $sig[0]['sig'][$lang_idx];
$imagefile = "phpThumb.php?src=".getUpdatedPic()."&amp;w=600&amp;h=292&amp;zc=C";
/* $season_title = "";
if (($month < 4)||($month === 12))//winter 
{
	$pic = get_fileFromdir('images/winter');
	$season_title = $WINTER[$lang_idx];
}
 else if ($month < 6) //spring
{
 
	  $pic = get_fileFromdir('images/spring');
	  $season_title = $SPRING[$lang_idx];
}
 else if ($month > 9) //automn
{
	$pic = get_fileFromdir('images/automn');
	$season_title = $AUTOMN[$lang_idx];
}
 else // summer
{
	$pic = get_fileFromdir('images/summer');
	$season_title = $SUMMER[$lang_idx];
}*/
 
 
 
/////////////////////////////////////////
$floated = false;
 
////////////////////////////////////////
function checktofloatList ($licount)
{
	global $floated;
	if (($licount % 3 == 1)&&($licount > 1))
	{
 
		//echo "</ul><ul style=\"margin:0em;padding:0.2em 1.25em 0em 1.25em;float:";
		//if (isHeb()) echo "right"; else echo "left";
		//echo "\">";
	}
}
 
 
 
 
 
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
 
	function getStartDateTime ($timerange)
	{
		if (strlen($timerange) < 2)
			return null;
		global $yearF, $monthF, $shift_forecast_time;
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
			return $TOMORROW[$lang_idx]." ";
		else
			return "";
	}
	function isLastTokenIsProb()
	{
		global $lang_idx, $forecast_title, $PROB;
		
	    return (trim($forecast_title[count($forecast_title)-2])==trim($PROB[$lang_idx]));
	}
 
        function updateForecastHour($currentPri, $title, $icon){
            global $forecastHour, $startDateTime, $endDateTime, $new_line, $same_sigment, $year, $priority, $forecast_title, $isProb;
 
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
				
                if ((($currentDateTime >= $startDateTime) &&
                    ($currentDateTime <= $endDateTime))||
					(($currentDateTime >= $startDateTime) &&
                    ($endDateTime==""))||
                    (($startDateTime=="")&&($endDateTime==""))){
                    if ($_GET["debug"] >= 3)
                    echo "<br />newline=".$new_line." forecast_title=".count($forecast_title)." p=".$hour_f['priority']." icon=".$icon." in ".date("H d/m/y", $hour_f['currentDateTime'])." (".$hour_f['time']."): ";
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
				$hour_f['icon'] = $icon;
				if ($_GET["debug"] >= 3){
					 echo " icon into ".$icon;
					 echo " p into ".$hour_f['priority'];
					 }
			}
			 if ((($last_priority <= 35)&&(!$isProb))||($new_line))
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
		global $priority, $forecast_title, $taf_pic, $last_priority, $title_pic, $new_line, $isProb, $PROB, $lang_idx, $forecastHour, $same_sigment, $startTime, $endTimeForFH;
 
		 $last_priority = $priority;
		 if ($_GET["debug"] >= 3)
		{
			echo "<br/>inUpdateForecast--> currentPri=".$currentPri." last_priority=".$last_priority." priority=".$priority." taf_pic=".$taf_pic." count=".count($forecast_title)."  new_line=".$new_line."  isProb=".$isProb."<br/>";
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
					  array_push($forecast_title, "$PROB[$lang_idx] ");
					  updateForecastHour($currentPri, "$PROB[$lang_idx] ", "");
					if ($_GET["debug"] >= 3)
						echo "<br/>added ".$PROB[$lang_idx]."<br/>";
					$isProb = false;
                    $same_sigment = true;
				//}
 
		 }
		 if ($currentPri > $priority)
		 {
			 if (($priority == 0)||($priority >= 50) || ($currentPri >= 35))
			 {
				 array_push($forecast_title, $title);
				  if ($_GET["debug"] >= 3)
					echo "added ".$title."<br/>";
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
					echo "added ".$title."<br/>";
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
				   echo "added ".$title."<br/>";
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
		if ((!file_exists($taf_file))||(((time() - filemtime($taf_file)) > 3600)))
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
					  $time = "00:00";
				 }
				  else 
					  $time = sprintf("%d:00", $h);
				 if ($t % 24 == 0)
					 $dayC = $dayC + 1;
				 $currentDateTime =  mktime ($h, 0, 0, $monthF, $dayC , $yearF);
				 array_push($forecastHour, array('id' => $hourindex, 'time' => $time, 'currentDateTime' => $currentDateTime, 'temp' => "", 'wind' => 0, 'icon' => "", 'title' => "", 'cloth' => "", 'priority' => 0));
				 $hourindex += 1;
				 
			 }
             updateForecast(20, "$MOSTLY[$lang_idx] $CLEAR[$lang_idx]", "clear.png");
			 
 
		}
		if (stristr ($taf_tokens[$i], "KT")) {
			if ($_GET["debug"] >= 3)
				echo " In  WIND<br/>";
			$windspeed = getWindSpeed($taf_tokens[$i]);
			if ($windspeed > 15)
				updateForecast($currentPri, $STRONG_WINDS[$lang_idx], "wind");
			else
				updateForecast($currentPri, $WEAK[$lang_idx], "wind");
		}
		if (stristr ($taf_tokens[$i], "PROB")) {
			$isProb = true;
		}
		if (stristr ($taf_tokens[$i], "RASN")) {
			updateForecast(95, "$RAIN[$lang_idx] $SNOW[$lang_idx]", "rainSnow.png");
 
		}
		else if (stristr ($taf_tokens[$i], "SN"))     {
			updateForecast(100, $SNOW[$lang_idx], "snowshow2.png");
 
		}
		if ((stristr ($taf_tokens[$i], "GR"))||
			 (stristr ($taf_tokens[$i], "GS")))        {
			updateForecast(90, $HAIL[$lang_idx], "Hail.png");
 
		}
		if (stristr ($taf_tokens[$i], "TSRA"))   {
			updateForecast(85, $THUNDERSTORM[$lang_idx].", ".$RAIN[$lang_idx], "thunshowers2.png");
 
		}
		else if (stristr ($taf_tokens[$i], "TS"))   {
			updateForecast(80,$THUNDERSTORM[$lang_idx], "rainTS.png");
 
		}
		else if ((stristr ($taf_tokens[$i], "-SHRA"))||
			(stristr ($taf_tokens[$i], "-RA"))){
			updateForecast(75, $LIGHT_RAIN[$lang_idx], "rainlightPC.gif");
 
		}
		else if (stristr ($taf_tokens[$i], "RA"))    {
			updateForecast(78, $RAIN[$lang_idx], "rain.png");
 
		}
		if (stristr ($taf_tokens[$i], "DZ")){
			updateForecast(68, $DRIZZLE[$lang_idx], "showersl2.png");
 
		}
		if (stristr ($taf_tokens[$i], "CB"))   {
			updateForecast(62, $SEVERE_CLOUDS[$lang_idx], "TCu.jpg");
 
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
			updateForecast(48, $SEVERE_CLOUDS[$lang_idx], "TCu.jpg");
 
		}
		if (stristr ($taf_tokens[$i], "BKN"))   {
			$currentPri = 40;
 
			if ($currentPri != $last_priority){
			     $last_priority = $currentPri;
				// need to delete less important PC lines
				 if (($forecast_title[count($forecast_title) - 1] == $FEW_CLOUDS[$lang_idx])||
					 ($forecast_title[count($forecast_title) - 1] == $PARTLY_CLOUDY[$lang_idx]))
				{
					$removed = array_pop($forecast_title);
					if ($_GET["debug"] >= 3)
						echo "<br/>need to delete less important PC lines: removed ".$removed."<br/>";
				}
 				updateForecast(40, "$MOSTLY[$lang_idx] $CLOUDY[$lang_idx]", "cloudym2.png");
				
				if ($priority < $currentPri)
				{
					$priority = $currentPri;
					$taf_pic = "cloudym2.png";
				}
			}
		}
		if (stristr ($taf_tokens[$i], "SCT"))  {
			$currentPri = 35;
 
			if ($currentPri != $last_priority){
				 // need to delete less important PC lines
				 if ($forecast_title[sizeof($forecast_title) - 1] == $FEW_CLOUDS[$lang_idx])
				{
					$removed = array_pop($forecast_title);
					if ($_GET["debug"] >= 3)
						echo "<br/>need to delete less important PC lines: removed ".$removed."<br/>";
				}
 
				 updateForecast(35, $PARTLY_CLOUDY[$lang_idx], "PC.png");
				 $last_priority = $currentPri;
				 if ($priority < $currentPri)
				 {
					$priority = $currentPri;
					$taf_pic = "PC.png";
				 }
 
			}
    	}
		if (stristr ($taf_tokens[$i], "FEW"))  {
 
 
			updateForecast(25, $FEW_CLOUDS[$lang_idx], "fare.png");	
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
 
			updateForecast(63, "$FOG[$lang_idx]", "fog.png");
 
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
				$startDateTime = getStartDateTime($timerange);
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
				$tempotime .= $BETWEEN[$lang_idx]." ".$startTime.".00 ".isTom($timetaf, $startTime).$TO[$lang_idx]." ".$endTime.".00: ";
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
			$startDateTime = getStartDateTime($timerange);
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
			$tempotime =  "".$BECMG[$lang_idx]." ";
			if ($startTime < 24)
				$tempotime .= $BETWEEN[$lang_idx]." ".$startTime.".00 ".isTom($timetaf, $startTime).$TO[$lang_idx]." ".$endTime.".00 ".$BECMG_TO[$lang_idx];
 
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
						<a href="javascript:void(0)" onclick="toggle('forecast24h');toggle('forecastnextdays');$('#forecast24h_title').removeClass('title_not_selected').addClass('title_selected');$('#forecastnextdays_title').removeClass('title_selected').addClass('title_not_selected');">
							<? echo($FORECAST_TITLE[$lang_idx]." ".$FOR[$lang_idx]." 24 ".$HOURS[$lang_idx]);?>
						</a>
					</div>
				</div>
				
 
			
			<div id="forecastnextdays" >
				<table id="tableForecastNextDays" class="inv_plain_3_zebra" style="border-spacing:2;border-padding:4">
				<tr style="height:5px" >
				<th style="padding:0;width:128px;text-align:<?=get_inv_s_align()?>" class="small" colspan="2"><? echo $EARLY_MORNING[$lang_idx]."&nbsp;<span dir=\"ltr\">".$current->get_tempunit()."</span>";?></th>
				<th style="padding:0;width:80px;text-align:center" class="small"><? echo $NOON[$lang_idx]."&nbsp;<span dir=\"ltr\">".$current->get_tempunit()."</span>";?></th>
				<? if  (count($forecastDaysDB) > 0) { ?>
                                <th style="padding:0;width:80px;text-align:center" class="small"><? echo $EVENING[$lang_idx]."&nbsp;<span dir=\"ltr\">".$current->get_tempunit()."</span>";?> <a href="javascript:viod(0)" class="info">(?)<span class="info"><?=$NIGHT_TEMP_EXP[$lang_idx]?></span></a></th>
				<? } ?>
				<th style="width:60px"></th>
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
							$class =  " class=\"inv_plain_3_zebra\" ";
						else
							$class =  " class=\"inv_plain_3_zebra half_zebra\" ";
						if ($i == 5){
							$overlook_d = $OVERLOOK[$lang_idx]." "."<a href=\"javascript:void(0)\" class=\"info\">(?)<span class=\"info\">".$OVERLOOK_EXP[$lang_idx]."</span></a><br />";
							echo "<tr ><td colspan=\"6\">&nbsp;".$overlook_d."</td></tr>";
						}
						?>
						<tr <?=$class?> style="height:<?=180/count($forecastDaysDB)?>px">
						<td>&nbsp;<strong><?echo replaceDays($forecastDaysDB[$i]['day_name']." ")." ".$forecastDaysDB[$i]['date'];?></strong></td>
						<td class="low"><?=c_or_f($forecastDaysDB[$i]['TempLow'])?></td>
						<td class="high"><?=c_or_f($forecastDaysDB[$i]['TempHigh'])?>&nbsp;<img style="vertical-align: middle" src="<? echo "images/clothes/".$forecastDaysDB[$i]['TempHighCloth']; ?>" width="30" height="30" title="<?=getClothTitle($forecastDaysDB[$i]['TempHighCloth'])?>" alt="<?=getClothTitle($forecastDaysDB[$i]['TempHighCloth'])?>" /></td>
						<td class="low"><?=c_or_f($forecastDaysDB[$i]['TempNight'])?>&nbsp;<img style="vertical-align: middle"  src="<? echo "images/clothes/".$forecastDaysDB[$i]['TempNightCloth']; ?>" width="30" height="30" title="<?=getClothTitle($forecastDaysDB[$i]['TempNightCloth'])?>" alt="<?=getClothTitle($forecastDaysDB[$i]['TempNightCloth'])?>" /></td>
						<td style="text-align:center"><img src="<? echo "images/icons/day/".$forecastDaysDB[$i]['icon']; ?>" width="55" height="40" alt="<?=$forecastDaysDB[$i]['date']?>" /></td>
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
				<td class="low">
					<? echo $monthAverge->get_lowtemp(); ?>
				</td>
				<td class="high">
					<? echo $monthAverge->get_hightemp(); ?>
				</td>
				<td colspan="3">&nbsp;&nbsp;
				    <a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=forecast/getForecast.php&amp;region=isr&amp;lang=<? echo $lang_idx;?>" title="<? echo($FORECAST_ISR[$lang_idx]); ?>"><? echo($FORECAST_ISR[$lang_idx]); ?><?=get_arrow()?></a>&nbsp;&nbsp;
					<a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=forecast/getForecast.php&amp;lang=<? echo $lang_idx;?>" title="<? echo($FORECAST_ABROD[$lang_idx]); ?>" ><? echo($WORLD[$lang_idx]); ?><?=get_arrow()?></a>&nbsp;&nbsp;
					<a href="<? echo get_query_edited_url(get_url(), 'section', 'dust.html');?>" title="<? echo($FORECAST_TITLE[$lang_idx]." ".$FOR[$lang_idx]." ".$DUST[$lang_idx]); ?>"><? echo($DUST[$lang_idx]); ?><?=get_arrow()?></a><br />
				</td>
				</tr>
                 <tr>
				<td style="padding:0.5em">
					<a href="<? echo get_query_edited_url($url_cur, 'section', 'reports.php');?>" title="<? echo $monthInWord." ".$RECORDS[$lang_idx]; ?>">
						<? echo $RECORDS[$lang_idx];?>
 					</a>
				</td>
				<td class="low" style="direction:ltr">
					<? echo $monthAverge->get_abslowtemp(); ?>
				</td>
				<td class="high">
					<? echo $monthAverge->get_abshightemp(); ?>
				</td>
				
                <td colspan="3">&nbsp;&nbsp;
					<a href="http://www.sviva.gov.il/bin/en.jsp?enPage=BlankPage&amp;enDisplay=view&amp;enDispWhat=Zone&amp;enDispWho=elergens_flowers&amp;enZone=elergens_flowers&amp;" title="<? echo($FORECAST_TITLE[$lang_idx]." ".$FOR[$lang_idx]." ".$ALERGY[$lang_idx]); ?>" rel="external"><? echo($ALERGY[$lang_idx]); ?><?=get_arrow()?>
					</a>&nbsp;&nbsp;
					<a href="whatisforecast.php?lang=<?=$lang_idx?>" title="<?=$WHAT_IS_FORECAST[$lang_idx]?>" rel="external">
						<?=$WHAT_IS_FORECAST[$lang_idx]?>
					<?=get_arrow()?></a>&nbsp;&nbsp;
					<a href="legend.php" class="colorbox" title="<?=$LEGEND[$lang_idx]?>"><?=$LEGEND[$lang_idx]?><?=get_arrow()?></a>&nbsp;&nbsp;
	   			</td>
                 </tr>
				</table> 
			</div>
			<div id="forecast24h" style="display:none" class="inv_plain_3_zebra">
						&nbsp;&nbsp;<? echo($GIVEN[$lang_idx]." ".$AT[$lang_idx]." ".$timetaf.":00 ".$dayF."/".$monthF."/".$yearF);?>
						<div id="for24_details">
							<?=$forcastTicker?>
						</div>
						<div id="hourtempforecast">
								<? echo($FORECAST_TEMP[$lang_idx]); ?>
								<select size="1" id="timeSwithcer" onchange="getTempForecast(<?=$hour?>)">
								<? for ($i=$hour; $i < $hour+14 ; $i++)
								   {
									if ($i>24)
										$h = $i - 24;
									else
										$h = $i;
									if ($i==24)
										$time = "00:00";
									else 
										$time = sprintf("%d:00", $h);
 
									echo "<option ";
									if ($h == $hour)
										echo "selected=\"selected\"";
									echo " value=\"".$h."\">".$time."</option>";
								   }
								?>
 
								</select>
								?
								<span id="tempForecastDiv">
								</span>
						</div>    
						<!--<div id="for24_icon">
							<img src="images/icons/day/<?echo $taf_pic;?>" height="50" width="60" alt="<? echo $title_pic;?>" align="middle"/>&nbsp;&nbsp;<? echo($GIVEN[$lang_idx]." ".$AT[$lang_idx]." ".$timetaf.":00");?>
						</div>-->
						<div id="forecasthours" style="clear:both;width:100%;padding:0.5em 0.5em 0;height: 300px;">
						 <? 
						 foreach ($forecastHour as $hour_f){
						 if ($hour_f['time'] % 3 == 0)
						 {
						 echo "<ul class=\"nav forecasttimebox inv_plain_3_zebra\" >";
						 echo "<li class=\"timefh\" style=\"text-align:center;width:12%\">".$hour_f['time']."</li>";
						 echo "<li class=\"\" style=\"text-align:center\" id=\"tempfh".intval($hour_f['time'])."\">".$hour_f['temp']."</li>";
						 echo "<li class=\"\" style=\"text-align:center;width:7%\"><img src=\"images/icons/day/".$hour_f['icon']."\" height=\"30\" width=\"45\" alt=\"".$hour_f['icon']."\" /></li>";
						 echo "<li class=\"\" style=\"width:55%\">".$hour_f['title']."</li>";
						 echo "</ul>";
						 }
						 }
						 ?>
				</div>
				
			</div>
		</div>
		
				
				
		
		<? if (!stristr(get_url(), "forecast")) {?>
		
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
						<div class="overlay">&nbsp;</div>
							<div class="title">
							<a href="#" class="hlink">
								<span class="big"><? echo $MESSAGES[$lang_idx];?></span>
							</a>
							</div>
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
									<img src="<?=$img_src?>" alt="<? echo $CURRENT_SIG_WEATHER[$lang_idx];?>" class="main_img" width="200px" height="100px"/>
							</a>
 
 
							<?} ?>
							<div class="overlay">&nbsp;</div>
							<div class="title">
								<a href="<? echo $sig[0]['url'];?>" class="hlink" title="<?echo $MORE_INFO[$lang_idx];?>">
 
										<span class="big"><? echo "{$sig[0]['sig'][$lang_idx]}"; ?></span>
										<br />
										<span id="extrainfo"><? echo $sig[0]['extrainfo'][$lang_idx]; if ($sig[0]['extrainfo'][$lang_idx] != "") echo " - ";?></span><span id="moreinfo"><?echo $MORE_INFO[$lang_idx];?><?=get_arrow()?></span>
								</a>
							</div>
							
						</div>	
					</div>

					<div class="sigweather" id="forth">
						<div class="background">
							<a href="<?=$webcam_link?>">
								<img src="<?=$imagefile?>" alt="<? echo $PIC_DESC[$lang_idx];?>" id="webcampic" class="main_img" width="200px" height="100px"/>
							</a>
							<div class="overlay">&nbsp;</div>
							<div class="title">
							<a href="<?=$webcam_link?>" class="hlink">
								<span class="big"><? echo $LIVE_PICTURE[$lang_idx];?></span><br /><? echo $PIC_DESC[$lang_idx];?><?=get_arrow()?>
							</a>
							</div>
						</div>
					</div>
					<div class="sigweather" id="fifth">
                                            <div class="background">
							<a href="<? echo "station.php?section=mainstory.php&amp;lang=".$lang_idx;?>">
									<img src="<?=$current_story_img_src?>" alt="<? echo $current_story_title;?>" class="main_img" width="200px" height="100px"/>
							</a>
							<div class="overlay">&nbsp;</div>
							<div class="title">
							<a href="<? echo "station.php?section=mainstory.php&amp;lang=".$lang_idx;?>" class="hlink">
								<span class="big"><? echo $current_story_title;?></span> -&nbsp;<?echo $MORE_INFO[$lang_idx];?><?=get_arrow()?>
							</a>
							</div>
					</div>
                                    </div>
                                    <div class="sigweather" id="sixst">
                                            <div class="background">
							<a href="<? echo "station.php?section=picoftheday.php&amp;lang=".$lang_idx;?>">
									<img src="<?=$mediumSizeUrl?>" alt="<?=$photoEntry->title->text?>" class="main_img" width="200px" height="100px" />
 							</a>
							<div class="overlay">&nbsp;</div>
							<div class="title">
							<a href="<? echo "station.php?section=picoftheday.php&amp;lang=".$lang_idx;?>" class="hlink">
								<span class="big"><? echo $PIC_OF_THE_DAY[$lang_idx];?></span><br /><?=$caption?>&nbsp;- <?echo $MORE_INFO[$lang_idx];?><?=get_arrow()?>
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
               (ind == 0) return '<li><a href="#" title=""><? echo $MESSAGES[$lang_idx];?></a></li>';
              else if (ind == 1) return '<li><a href="<?=$sig_url?>" title="<?=$CURRENT_SIG_WEATHER[$lang_idx]?>"><?=$sig_title?></a></li>';
	       else if (ind == 2) return '<li><a href="<?=$webcam_link?>" title="<? echo $PIC_DESC[$lang_idx];?>"><? echo $LIVE_PICTURE[$lang_idx];?></a></li>';
		  else if (ind == 3) return '<li><a href="<? echo "station.php?section=mainstory.php&amp;lang=".$lang_idx;?>" title="<? echo $current_story_title;?>"><? echo $current_story_title;?></a></li>';
		  else if (ind == 4) return '<li><a href="#" title="<? echo $PIC_OF_THE_DAY[$lang_idx]?>"><? echo $PIC_OF_THE_DAY[$lang_idx]?></a></li>';
		  else
			return "";
 
	}
//-->
</script>