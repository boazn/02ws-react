<?php
define("SEPERATOR", "");
define("HIDDENSEPERATOR", "<!---->");
define("PERSONAL_COLD_METER", "PersonalColdMeter");
function isCommandLineInterface()
{
    return (php_sapi_name() === 'cli');
}
$self = pathinfo(__FILE__, PATHINFO_BASENAME);
$document_root = rtrim(str_replace($self, '', __FILE__), '/');
include_once (isCommandLineInterface()? $document_root."/ini.php": $_SERVER['DOCUMENT_ROOT']."/ini.php");
ini_set("display_errors","Off");
class FixedTime {

    var $date;
    var $time;
    var $day;
    var $temp;
    var $temp2;
    var $temp3;
    var $tempunit;
    var $intemp;
    var $dew;
    var $dew2;
    var $pressure;
    var $hum;
    var $hum2;
    var $thw;
    var $thsw;
    var $rain; // rain in the interval
    var $rain2;
    var $rainpercent;
    var $rain2percent;
    var $windspd;
    var $windspd10min;
    var $winddir;
    var $windchill;
    var $solarradiation;
    var $uv;
    var $pm10;
    var $pm10sd;
    var $pm25;
    var $pm25sd;
    var $cloudiness;
    var $heatidx;
    var $heatidx2;
    var $rainrate;
    var $rainrate2;
    var $rainratechange;
    var $rainrate2change;
    var $light = true;
    var $tempchange;
    var $temp2change;
    var $temp3change;
    var $dewchange;
    var $humchange;
    var $hum2change;
    var $windspdchange;
    var $prschange;
    var $cloudbase;
    var $cloudBaseChange;
    var $uvchange;
    var $solarradiationchange;
    var $pm10change;
    var $pm25change;

    /* function FixedTime(
      $ddate,
      $ttime,
      $dday,
      $ttemp,
      $ddew,
      $ppressure,
      $hhum,
      $wwindspd,
      $wwinddir,
      $r
      rate,
      $ttempchange,
      $hhumchange,
      $wwindspdchange,
      $pprschange)
      {
      $date = $ddate;
      $time = $ttime;
      $day  = $dday;
      $temp = $ttemp;
      $dew = $ddew;
      $pressure = $ppressure;
      $hum = $hhum;
      $windspd = $wwindsp;
      $winddir = $wwinddir;
      $rainrate = $rrainrate;
      $light = true;
      $tempchange = $ttempchage;
      $humchange = $hhumchange;
      $windspdchange = $wwindspdchange;
      $prschange = $pprschange;
      } */

     
    function set_tempchange($temp) {
        if (isset($_GET["debug"]))
        if ($_GET["debug"] >= 4)
            echo "<br > set_tempchange $temp -".$this->temp.": ".number_format($temp - $this->temp, 1, '.', '');
        if ($temp == "miss")
            $this->tempchange = "miss";
        else
            $this->tempchange = number_format($temp - $this->temp, 1, '.', '');
    }
    
    function set_temp2change($temp) {
        if (isset($_GET["debug"])) 
        if ($_GET["debug"] >= 4)
            echo "<br > set_temp2change $temp - ".$this->temp2.": ".number_format($temp - $this->temp2, 1, '.', '');;
        if ($temp == "miss")
            $this->temp2change = "miss";
        else
            $this->temp2change = number_format($temp - $this->temp2, 1, '.', '');
    }
    
    function set_temp3change($temp) {
        if (isset($_GET["debug"])) 
        if ($_GET["debug"] >= 4)
            echo "<br > set_temp3change $temp - ".$this->temp3.": ".number_format($temp - $this->temp3, 1, '.', '');;
        if ($temp == "miss")
            $this->temp3change = "miss";
        else
            $this->temp3change = number_format($temp - $this->temp3, 1, '.', '');
    }

     function set_dewchange($dew) {
        if ($dew == "miss")
            $this->dewchange = "miss";
        else
            $this->dewchange = number_format($dew - $this->dew, 1, '.', '');
    }
    
    function set_humchange($hum) {
        if ($hum == "miss")
            $this->humchange = "miss";
        else
            $this->humchange = intval($hum - $this->hum);
    }
    
    function set_hum2change($hum) {
        if ($hum == "miss")
            $this->hum2change = "miss";
        else
            $this->hum2change = intval($hum - $this->hum2);
    }

    function set_windspdchange($windspd) {
        $this->windspdchange = round($windspd - $this->windspd);
    }

    function set_rainratechange($rainrate) {
        $this->rainratechange = $rainrate - $this->rainrate;
    }

    function set_rainrate2change($rainrate) {
        $this->rainrate2change = $rainrate - $this->rainrate2;
    }

    function set_prschange($prs) {
        $this->prschange = number_format($prs - $this->pressure, 1, '.', '');
    }

    function set_cloudBaseChange($cloudbase) {
        if ($cloudbase == "miss")
            $this->cloudBaseChange = "miss";
        else
            $this->cloudBaseChange = $cloudbase - $this->cloudbase;
    }

    function set_uvchange($uv) {
        $this->uvchange = $uv - $this->uv;
    }

    function set_srchange($sr) {
        $this->solarradiationchange = $sr - $this->solarradiation;
    }

    function set_pm10change($sr) {
        $this->pm10change = $sr - $this->pm10;
    }

    function set_pm25change($sr) {
        $this->pm25change = $sr - $this->pm25;
    }

    function get_pm10change() {
       return $this->pm10change;
    }

    function get_pm25change() {
       return $this->pm25change;
    }

    function set_change($temp, $hum, $dew, $windspd, $prs, $cldbase, $rainrate, $solarradiation, $uv, $temp2, $temp3, $pm10, $pm25) {
        if (intval($this->hum) > 0){
            $this->set_tempchange($temp);
            $this->set_temp2change($temp2);
            $this->set_temp3change($temp3);
            $this->set_dewchange($dew);
            $this->set_humchange($hum);
            $this->set_windspdchange($windspd);
            $this->set_prschange($prs);
            $this->set_cloudBaseChange($cldbase);
            $this->set_rainratechange($rainrate);
            $this->set_uvchange($uv);
            $this->set_srchange($solarradiation);
            $this->set_pm10change($pm10);
            $this->set_pm25change($pm25);
        }
        
       
    }

    function isLowDust(){
        return ($this->get_pm10() < 200 && $this->get_pm25() < 100);
    }
    function get_windspdchange() {
        return round($this->windspdchange, 0);
    }

    function get_rainratechange() {
        return $this->rainratechange;
    }

    function get_prschange() {
        return $this->prschange;
    }
    
    function get_dewchange() {
        return $this->dewchange;
    }

    function get_humchange() {
        return $this->humchange;
    }

    function get_tempchange() {
        global $PRIMARY_TEMP;
        if ($PRIMARY_TEMP == 1)
            return $this->tempchange;
        else
            return $this->temp2change;  
    }
    
    function get_temp2change() {
        global $PRIMARY_TEMP;
        if ($PRIMARY_TEMP == 1)
            return $this->temp2change;
        else
            return $this->tempchange;
    }
    
    function get_temp3change() {
            return $this->temp3change;
    }

    function get_srchange() {
        return $this->solarradiationchange;
    }

    function get_uvchange() {
        return $this->uvchange;
    }

    function get_cloudbasechange() {
        return $this->cloudBaseChange;
    }

    function get_cloudbase() {
        return $this->cloudbase;
    }

    function set_time($time) {
        $this->time = $time;
    }

    function set_date($date) {
        $this->date = $date;
    }

    function set_day($day) {
        $this->day = $day;
    }

    function set_temp($temp) {
        $this->temp = c_or_f($temp);
    }

    function set_tempunit($tempunit) {
        $this->tempunit = $tempunit;
    }

    function set_temp2($temp) {
        $this->temp2 = c_or_f($temp);
    }
    
    function set_temp3($temp) {
        $this->temp3 = c_or_f($temp);
    }
    
    function set_hum2($hum) {
        $this->hum2 = $hum;
    }
    
    function set_intemp($temp) {
        $this->intemp = c_or_f($temp);
    }

    function set_dew($dew) {
        $this->dew = c_or_f($dew);
    }
    function set_dew2($dew) {
        $this->dew2 = c_or_f($dew);
    }

    function set_hum($hum) {
        $this->hum = $hum;
    }

    function set_pm10($pm10) {
        $this->pm10 = $pm10;
    }
    
    function set_pm25($pm25) {
        $this->pm25 = $pm25;
    }
    
    function set_pm10sd($pm10sd) {
        $this->pm10sd = $pm10sd;
    }
    
    function set_pm25sd($pm25sd) {
        $this->pm25sd = $pm25sd;
    }
    function getCalcTHW($base_temp){
        $w = $this->windspd10min == "" ? $this->windspd : $this->windspd10min;
        $Ta = isTempF() ? ($base_temp - 32)*5/9 : $base_temp;          /* Dry bulb temperature [°C] */
        $e = 0;                 /* Watter vapour pressure [hPa] (humidity) */
        $ws = 0.514444*$w;        /* Wind speed [m/s] at an elevation of 10 meters */
        $rh = $this->hum;           /* Relative humidity [%] */
        $Q = $this->solarradiation;       /* Net radiation absorbed per unit area of body surface [w/m2] */
        $e = ($rh / 100) * 6.105 * exp (17.27 * $Ta / (237.7 + $Ta));
        $ATthw = $Ta + 0.33 * $e - 0.70 * $ws - 4.00;
        $ATthwr = round($ATthw, 1);
        
        $thw3 = ($this->windspd10min * 1.15 * -0.31224) + ($rh * 0.02518) +($Ta * 1.101299) - 2.73521;
        $thw3 = round($thw3, 1);
        $heatidx = isTempF() ? ($this->heatidx - 32)*5/9 : $this->heatidx;
        $windchill = isTempF() ? ($this->windchill - 32)*5/9 : $this->windchill;
        if ($this->windspd10min == 0)
            $thw4 = $heatidx;
        else
        {
            $thw4 = $heatidx + $windchill - $Ta;
        }
        $thw4 = round($thw4, 1);
        $final_thw = round(array_sum(array(floatval($ATthwr),floatval($thw3),floatval($thw4) ))/3, 1);
        //logger("base_temp:".$base_temp."  final:".$final_thw);
        return $final_thw;
    }
    function set_thw($thw) {
        $calc_thw = $this->getCalcTHW($this->temp);
        //if (abs($final_thw-$thw) >= 1)
        //    logger("thw:".$thw."  final:".$calc_thw);
        $this->thw = c_or_f($calc_thw);
    }
    function set_thw2($thw) {
        $final_thw = getCalcTHW($this->temp2);
        $this->thw = c_or_f($final_thw);
    }
    function set_cloudiness($cloudiness) {
        $this->cloudiness = $cloudiness;
    }

    function set_thsw($thsw) {
        global $hour;
        $w = $this->windspd10min == "" ? $this->windspd : $this->windspd10min;
        if (empty($w)) $w = 0;
        $Ta = isTempF() ? ($this->temp2 - 32)*5/9 : $this->temp2;            /* Dry bulb temperature [°C] */
        $ws = 0.514444*$w;        /* Wind speed [m/s] at an elevation of 10 meters */
        $rh = $this->hum;           /* Relative humidity [%] */
        $Q = $this->solarradiation;       /* Net radiation absorbed per unit area of body surface [w/m2] */
        $e = ($rh / 100) * 6.105 * exp (17.27 * $Ta / (237.7 + $Ta)); /* Watter vapour pressure [hPa] (humidity) */
        
        $ATthsw = $Ta + 0.348 * $e - 0.70 * $ws + 0.70 * $Q / ($ws + 10) - 4.25;
        $ATthswr = round($ATthsw, 1);
        
        //if (($ATthswr > 21)&&($thsw > 0))
        //    logger("thsw:".$thsw." ".$ATthswr." (".$w." ".$Ta." ".$rh." ".$Q.")");
        $this->thsw = c_or_f($thsw);
        // for the morning hours
        //if ((c_or_f($thsw) == "")&&($this->solarradiation > 150)&&($hour<8))
        //    $this->thsw = $this->temp2 + 1; 
    }

    function set_windspd($wind) {
        $this->windspd = round($wind);
    }
    
    function set_windspd10min($wind) {
        $this->windspd10min = round($wind);
    }

    function set_winddir($wind) {
        $this->winddir = $wind;
    }

    function set_windchill($temp) {
        $this->windchill = c_or_f($temp);
    }

    function set_heatidx($temp) {
        $this->heatidx = c_or_f($temp);
    }

    function set_heatidx2($temp) {
        $this->heatidx2 = c_or_f($temp);
    }

    function set_rainrate($rrate) {
        $this->rainrate = $rrate;
    }

    function set_rainrate2($rrate) {
        $this->rainrate2 = $rrate;
    }

    function set_rain($rain) {
        $this->rain = $rain;
    }
    function set_rain2($rain) {
        $this->rain2 = $rain;
    }
    function set_rainchance($rain) {
        $this->rainpercent = $rain;
    }
    function set_rain2chance($rain) {
        $this->rainpercent2 = $rain;
    }

    function set_solarradiation($sr) {
        $this->solarradiation = $sr;
    }

    function set_uv($uv) {
        $this->uv = $uv;
    }

    function set_pressure($bar) {
        $this->pressure = $bar;
    }

    function set_cloudbase($cloudbase) {
        $this->cloudbase = $cloudbase;
    }

    function set_dark() {
        $this->light = false;
    }

    function set_light() {
        $this->light = true;
    }

    function get_date() {
        return $this->date;
    }

    function get_time() {
        return $this->time;
    }
    function get_temp_to_coldmeter(){
        $temp_to_cold_meter = $this->get_temp();
        $itfeels = array();
        $itfeels = $this->get_itfeels();
        if (!empty($itfeels[0]))
            $temp_to_cold_meter = $itfeels[1];
        return $temp_to_cold_meter;
    }
    function get_temp2_to_coldmeter(){
        $temp_to_cold_meter = $this->get_thsw();
        if (empty($temp_to_cold_meter))
            $temp_to_cold_meter = $this->get_temp_to_coldmeter();
        return $temp_to_cold_meter;
    }
    function get_temp($temp_unit = "") {
         global $PRIMARY_TEMP, $current;
          if ($this->temp2 > 1000)
              $PRIMARY_TEMP = 1;
          if ($PRIMARY_TEMP == 1)
               $temp = $this->temp;
            else
               $temp = $this->temp2;
         if (!empty($temp_unit)&&($current->get_tempunit()!=$temp_unit))
         {
             if (strpos($temp_unit, 'F') !== false){
               $temp =  round(((9 * $temp) / 5) + 32);
               //logger("get_temp: ".$temp_unit." ".$temp);
             }
            else{
               $temp = ($temp - 32)*5/9;
               //logger("get_temp: ".$temp_unit." ".$temp);
             }
         }
        return floatval($temp);
    }
    function get_tempunit() {
        return $this->tempunit;
    }

    function get_temp2() {
        global $PRIMARY_TEMP;
        if ($PRIMARY_TEMP == 1)
            return $this->temp2;
        else
            return $this->temp;
    }
    
    function get_temp3() {
            return $this->temp3;
    }
    
    function get_hum2() {
        return $this->hum2;
    }
    
    function get_intemp() {
        return $this->intemp;
    }

    function get_dew() {
        global $last2, $PRIMARY_TEMP;
        return $this->dew;
        
    }
    function get_dew2() {
        global $last2, $PRIMARY_TEMP;
        return $this->dew2;
        
    }

    function get_hum() {
        return $this->hum;
    }

    function get_pm10() {
        return $this->pm10;
    }
    
    function get_pm25() {
        return $this->pm25;
    }
    
    function get_pm10sd() {
        return $this->pm10sd;
    }
    
    function get_pm25sd() {
        return $this->pm25sd;
    }

    function get_windspd() {
        return $this->windspd;
    }

    function get_winddir() {
        return $this->winddir;
    }

    function get_windchill() {
        return $this->windchill;
    }

    function get_heatidx() {
        global $PRIMARY_TEMP;
        return $this->heatidx;
       
    }

    function get_heatidx2() {
        global $PRIMARY_TEMP;
        return $this->heatidx2;
       
    }

    function get_pressure() {
        return number_format($this->pressure, 1, '.', '');
    }

    function get_thw() {
        return $this->thw;
    }

    function get_cloudiness() {
        return $this->cloudiness;
    }

    function get_thsw() {
        return $this->thsw;
    }
    function get_itfeels_avg(){
        global $mem;
        $itfeels_array = array();
        if ($mem->get('itfeels_array'))
            $itfeels_array = $mem->get('itfeels_array');
        array_push($itfeels_array, $this->get_itfeels());
        if (count($itfeels_array) > 10)
            array_shift($itfeels_array);
        $mem->set('itfeels_array', $itfeels_array);
        $index_if = 0;
        $itfeels_sum = 0;
        foreach ($itfeels_array as $if){
            $index_if++;
            if ($index_if > 5)
                $itfeels_sum += $if[1];
        }
        return round($itfeels_sum/5, 1);
    }
    function get_itfeels(){
        global $PRIMARY_TEMP;
        if ($PRIMARY_TEMP == 1)
           $temp_to_mompare_to = $this->temp;
        else
           $temp_to_mompare_to = $this->temp2;

        if (min($this->windchill, $this->thw) < ($temp_to_mompare_to) && ($temp_to_mompare_to < 20 ) && ($this->thw != 0) && ($this->windchill != 0)){
            $itfeels_state = "windchill";
            $itfeels_array = array($this->windchill, $this->thw);
            $itfeels = round(array_sum($itfeels_array)/count($itfeels_array), 1);
            if ($temp_to_mompare_to < 14)
                $itfeels = $this->windchill;
            if ($this->hum < 50){
                $itfeels = $this->thw;
                $itfeels_state = "thw";
            }
                
        }
        else if (max($this->HeatIdx, $this->thw) != ($temp_to_mompare_to)){
            $itfeels_state = "heatindex";
            $itfeels = max($this->heatidx, $this->thw);
        }
        /*else if (($this->solarradiation > 200)&&($this->thsw > $temp_to_mompare_to)){
            $itfeels_state = "thsw";
            $itfeels = $temp_to_mompare_to + number_format(0.4*($this->thsw - $temp_to_mompare_to), 1, '.', '');
        }*/
        else{
            $itfeels_state = "";
            $itfeels = $temp_to_mompare_to;
        }
        return array($itfeels_state, $itfeels, date("Y-m-j h:i", time()));
    }
    
    function get_rainrate() {
        return $this->rainrate;
    }

    function get_rainrate2() {
        return $this->rainrate2;
    }

    function get_rain() {
        return $this->rain;
    }

    function get_rainchance() {
        return $this->rainpercent;
    }

    function get_solarradiation() {
        return $this->solarradiation;
    }

    function get_uv() {
        return $this->uv;
    }

    function is_light() {
        return $this->light;
    }
    function is_sun(){
        return ($this->is_light()&&
                $this->get_thsw()!=""&&
                //($this->get_thsw()>$this->get_heatidx())&&
                ($this->get_thsw()>$this->get_windchill()));
    }

    function is_sunset() {
        if (abs(get_sunset_ut() - $this->get_current_time_ut()) < 2900)
            return true;
        else
            return false;
    }

    function is_sunrise() {
        if (abs(get_sunrise_ut() - $this->get_current_time_ut()) < 2900)
            return true;
        else
            return false;
    }

    function get_current_time_ut() {
        $time_a = explode(":", $this->time);
        $current_hh = intval($time_a[0]);
        $current_mm = intval($time_a[1]);
        $current_time_ut = mktime($current_hh, $current_mm);
        return $current_time_ut;
    }

}

class Parameter {

    var $_value;
    var $_time;

    function get_time() {
        Return $this->_time;
    }

    function get_value() {
        Return $this->_value;
    }

    function set_value($value) {
        $this->_value = $value;
    }

    function set_time($time) {
        $this->_time = $time;
    }

}

class Period {

    var $hightemp;
    var $hightemp2;
    var $hightemp3;
    var $lowtemp;
    var $lowtemp2;
    var $lowtemp3;
    var $highhum;
    var $lowhum;
    var $highbar;
    var $lowbar;
    var $highdew;
    var $lowdew;
    var $highwind;
    var $highrainrate;
    var $highheatindex;
    var $lowwindchill;
    var $highuv;
    var $lowuv;
    var $highradiation;
    var $lowradiation;

    /* function Period($hitemp, $lowtemp, $highhum, $lowhum, $highbar, $lowbar, $highwind, $highrainrate) {
      $this->hightemp = $hitemp;
      $this->lowtemp  = $lowtemp;
      $this->highhum = $highhum;
      $this->lowhum = $lowhum;
      $this->highbar = $highbar;
      $this->lowbar = $lowbar;
      $this->highwind = $highwind;
      $this->highrainrate = $highrainrate;

      } */

    function __construct() {
        $this->hightemp = new Parameter();
        $this->lowtemp = new Parameter();
        $this->hightemp2 = new Parameter();
        $this->lowtemp2 = new Parameter();
        $this->hightemp3 = new Parameter();
        $this->lowtemp3 = new Parameter();
        $this->highhum = new Parameter();
        $this->lowhum = new Parameter();
        $this->highhum2 = new Parameter();
        $this->lowhum2 = new Parameter();
        $this->highbar = new Parameter();
        $this->lowbar = new Parameter();
        $this->highdew = new Parameter();
        $this->lowdew = new Parameter();
        $this->highwind = new Parameter();
        $this->highrainrate = new Parameter();
        $this->highrainrate2 = new Parameter();
        $this->lowwindchill = new Parameter();
        $this->highheatindex = new Parameter();
        $this->highuv = new Parameter();
        $this->lowuv = new Parameter();
        $this->highradiation = new Parameter();
        $this->lowradiation = new Parameter();
    }

    function get_hightemp() {
        global $PRIMARY_TEMP;
        if ($PRIMARY_TEMP == 1)
            return $this->hightemp->get_value();
        else 
            return $this->hightemp2->get_value();
        
    }
    
     function get_hightemp2() {
         global $PRIMARY_TEMP;
        if ($PRIMARY_TEMP == 1) 
            return $this->hightemp2->get_value();
        else
            return $this->hightemp->get_value();
    }
    
    function get_hightemp3() {
       
       return $this->hightemp3->get_value();
        
    }

    function get_highbar() {
        return number_format($this->highbar->get_value(), 1);
    }

    function get_lowtemp($temp_unit = "") {
        global $PRIMARY_TEMP, $current;
        if ($PRIMARY_TEMP == 1)
            $temp =  $this->lowtemp->get_value();
        else
             $temp = $this->lowtemp2->get_value();
        if (!empty($temp_unit)&&($current->get_tempunit()!=$temp_unit))
         {
             if ($temp_unit == '&#176;F'){
               $temp =  round(((9 * $temp) / 5) + 32);
               //logger("get_temp: ".$temp_unit." ".$temp);
             }
            else{
               $temp = ($temp - 32)*5/9;
               //logger("get_temp: ".$temp_unit." ".$temp);
             }
         }
        return $temp;
     }
    
     function get_lowtemp2() {
         global $PRIMARY_TEMP;
        if ($PRIMARY_TEMP == 1)
            return $this->lowtemp2->get_value();
        else
             return $this->lowtemp->get_value();
    }
    
    function get_lowtemp3() {
            return $this->lowtemp3->get_value();
    }

    function get_highhum() {
        return $this->highhum->get_value();
    }

    function get_lowhum() {
        return $this->lowhum->get_value();
    }

    function get_highwind() {
        return $this->highwind->get_value();
    }

    function get_highuv() {
        return $this->highuv->get_value();
    }

    function get_highuv_time() {
        return $this->highuv->get_time();
    }

    function get_highradiation() {
        return $this->highradiation->get_value();
    }

    function get_highradiation_time() {
        return $this->highradiation->get_time();
    }

    function get_lowbar() {
        return number_format($this->lowbar->get_value(), 1);
    }

    function get_highdew() {
        return $this->highdew->get_value();
    }

    function get_lowdew() {
        return $this->lowdew->get_value();
    }

    function get_highrainrate() {
        return $this->highrainrate->get_value();
    }
    function get_highrainrate2() {
        return $this->highrainrate2->get_value();
    }
    function get_highheatindex() {
        return $this->highheatindex->get_value();
    }

    function get_lowwindchill() {
        return $this->lowwindchill->get_value();
    }

    function get_hightemp_time() {
        global $PRIMARY_TEMP;
        if ($PRIMARY_TEMP == 1){
            if (strlen($this->hightemp->get_time()) < 5)
                return "0" . $this->hightemp->get_time();
            return $this->hightemp->get_time();
        }
        else{
            if (strlen($this->hightemp2->get_time()) < 5)
                return "0".$this->hightemp2->get_time();
            return $this->hightemp2->get_time();
        }
     }
    
    function get_hightemp2_time() {
        global $PRIMARY_TEMP;
        if ($PRIMARY_TEMP == 1){
            if (strlen($this->hightemp2->get_time()) < 5)
                return "0".$this->hightemp2->get_time();
            return $this->hightemp2->get_time();
        }
        else{
            if (strlen($this->hightemp->get_time()) < 5)
                return "0".$this->hightemp->get_time();
            return $this->hightemp->get_time();
        }
            
    }
    
    function get_hightemp3_time() {
        
            if (strlen($this->hightemp3->get_time()) < 5)
                return "0".$this->hightemp3->get_time();
            return $this->hightemp3->get_time();
        
            
    }

    function get_highbar_time() {
        return $this->highbar->get_time();
    }

    function get_lowtemp_time() {
        global $PRIMARY_TEMP;
        if ($PRIMARY_TEMP == 1){
            if (strlen($this->lowtemp->get_time()) < 5)
                return "0" . $this->lowtemp->get_time();
            return $this->lowtemp->get_time();
        }
        else{
            if (strlen($this->lowtemp2->get_time()) < 5)
                return "0" . $this->lowtemp2->get_time();
            return $this->lowtemp2->get_time();
        }
        
    }
    
    function get_lowtemp2_time() {
        global $PRIMARY_TEMP;
        if ($PRIMARY_TEMP == 1){
            if (strlen($this->lowtemp2->get_time()) < 5)
                return "0" . $this->lowtemp2->get_time();
            return $this->lowtemp2->get_time();
        }
        else {
            if (strlen($this->lowtemp->get_time()) < 5)
                return "0" . $this->lowtemp->get_time();
            return $this->lowtemp->get_time();
        }
        
    }

    function get_lowtemp3_time() {
        
            if (strlen($this->lowtemp3->get_time()) < 5)
                return "0" . $this->lowtemp3->get_time();
            return $this->lowtemp3->get_time();
        
        
    }
    
    function get_highhum_time() {
        return $this->highhum->get_time();
    }
    
    function get_highdew_time() {
        return $this->highdew->get_time();
    }

    function get_lowhum_time() {
        return $this->lowhum->get_time();
    }
    function get_lowdew_time() {
        return $this->lowdew->get_time();
    }
    function get_lowwindchill_time() {
        return $this->lowwindchill->get_time();
    }

    function get_highwind_time() {
        return $this->highwind->get_time();
    }

    function get_lowbar_time() {
        return $this->lowbar->get_time();
    }

    function get_highrainrate_time() {
        return $this->highrainrate->get_time();
    }

    function get_highrainrate2_time() {
        return $this->highrainrate2->get_time();
    }

    function get_highheatindex_time() {
        return $this->highheatindex->get_time();
    }

    function set_hightemp($hightemp, $time) {
        $this->hightemp->set_value(c_or_f($hightemp));
        $this->hightemp->set_time($time);
        //if ($_GET['tempunit'] == 'F') 
        //logger('set_hightemp: '.$hightemp." ".c_or_f($hightemp)." ".$time);
    }

    function set_lowtemp($lowtemp, $time) {
        $this->lowtemp->set_value(c_or_f($lowtemp));
        $this->lowtemp->set_time($time);
    }
    
    function set_hightemp2($hightemp2, $time2) {
        $this->hightemp2->set_value(c_or_f($hightemp2));
        $this->hightemp2->set_time($time2);
        //if ($_GET['tempunit'] == 'F') 
        //logger('set_hightemp2: '.$hightemp2." ".c_or_f($hightemp2)." ".$time2);
        
    }
    function set_hightemp3($hightemp3, $time3) {
        $this->hightemp3->set_value(c_or_f($hightemp3));
        $this->hightemp3->set_time($time3);
       // logger('set_hightemp2: '.$hightemp." ".$time);
        
    }

    function set_lowtemp2($lowtemp, $time) {
        $this->lowtemp2->set_value(c_or_f($lowtemp));
        $this->lowtemp2->set_time($time);
         
    }
    
    function set_lowtemp3($lowtemp, $time) {
        $this->lowtemp3->set_value(c_or_f($lowtemp));
        $this->lowtemp3->set_time($time);
         
    }

    function set_highhum($highhum, $time) {
        $this->highhum->set_value($highhum);
        $this->highhum->set_time($time);
    }

    function set_lowhum($lowhum, $time) {
        $this->lowhum->set_value($lowhum);
        $this->lowhum->set_time($time);
    }
    
    function set_highhum2($highhum, $time) {
        $this->highhum2->set_value($highhum);
        $this->highhum2->set_time($time);
    }

    function set_lowhum2($lowhum, $time) {
        $this->lowhum2->set_value($lowhum);
        $this->lowhum2->set_time($time);
    }

    function set_lowbar($lowbar, $time) {
        $this->lowbar->set_value($lowbar);
        $this->lowbar->set_time($time);
    }

    function set_highbar($highbar, $time) {
        $this->highbar->set_value($highbar);
        $this->highbar->set_time($time);
    }

    function set_highdew($highdew, $time) {
        $this->highdew->set_value($highdew);
        $this->highdew->set_time($time);
    }

    function set_lowdew($lowdew, $time) {
        $this->lowdew->set_value($lowdew);
        $this->lowdew->set_time($time);
    }

    function set_highwind($highwind, $time) {
        $this->highwind->set_value($highwind);
        $this->highwind->set_time($time);
    }

    function set_highrainrate($rainrate, $time) {
        $this->highrainrate->set_value($rainrate);
        $this->highrainrate->set_time($time);
    }

    function set_highrainrate2($rainrate, $time) {
        $this->highrainrate2->set_value($rainrate);
        $this->highrainrate2->set_time($time);
    }

    function set_highheatindex($heatIdx, $time) {
        $this->highheatindex->set_value(c_or_f($heatIdx));
        $this->highheatindex->set_time($time);
    }

    function set_lowwindchill($windchill, $time) {
        $this->lowwindchill->set_value(c_or_f($windchill));
        $this->lowwindchill->set_time($time);
    }

    function set_highuv($uv, $time) {
        $this->highuv->set_value($uv);
        $this->highuv->set_time($time);
    }

    function set_lowuv($uv, $time) {
        $this->lowuv->set_value($uv);
        $this->lowuv->set_time($time);
    }

    function set_highradiation($sr, $time) {
        $this->highradiation->set_value($sr);
        $this->highradiation->set_time($time);
    }

    function set_lowradiation($sr, $time) {
        $this->lowradiation->set_value($sr);
        $this->lowradiation->set_time($time);
    }

    function get_info($paramvalue, $loworhigh, $paramtime) {
        global $ON, $LOW, $HIGH;
        return ($LOW[$lang_idx] . ": " . $paramvalue . " " . $ON[$lang_idx] . " " . $paramtime);
    }

}

class TimeRange extends Period {

    var $et;
    var $sunshinehours;
    var $rain;
    var $rainydays;
    var $raindiffav;
    var $rainperc;
    var $rainydaysdiffav;
    var $abslowtemp;
    var $abslowtempdate;
    var $abshightemp;
    var $abshightempdate;
    var $absminrain;
    var $absminraindate;
    var $absmaxrain;
    var $absmaxraindate;

    function get_rainperc() {
        return $this->rainperc;
    }

    function set_rainperc($rainperc) {
        $this->rainperc = $rainperc;
    }
    function set_rainperc2($rainperc) {
        $this->rainperc2 = $rainperc;
    }

    function set_rainydaysdiffav($raindays) {
        $this->rainydaysdiffav = $raindays;
    }

    function get_rainydaysdiffav() {
        return $this->rainydaysdiffav;
    }

    function set_raindiffav($raindiffav) {
        $this->raindiffav = $raindiffav;
    }

    function get_raindiffav() {
        return $this->raindiffav;
    }

    function set_rain($rain) {
        $this->rain = $rain;
    }

    function set_rain2($rain) {
        $this->rain2 = $rain;
    }

    function set_et($et) {
        $this->et = $et;
    }

    function set_sunshinehours($sunshinehours) {
        $this->sunshinehours = $sunshinehours;
    }

    function get_rain() {
        return $this->rain;
    }

    function get_rain2() {
        return $this->rain2;
    }

    function get_et() {
        return $this->et;
    }

    function get_sunshinehours() {
        return $this->sunshinehours;
    }

    function set_rainydays($rainydays) {
        $this->rainydays = $rainydays;
    }

    function get_rainydays() {
        return $this->rainydays;
    }

    function get_abslowtemp() {
        return c_or_f($this->abslowtemp);
    }

    function get_abslowtempDate() {
        return c_or_f($this->abslowtempdate);
    }

    function get_abshightemp() {
        return c_or_f($this->abshightemp);
    }

    function get_abshightempDate() {
        return c_or_f($this->abshightempdate);
    }

    function get_absminrain() {
        return $this->absminrain;
    }

    function get_absmaxrain() {
        return $this->absmaxrain;
    }

    function set_abslowtemp($abslowtemp, $abslowtempdate) {
        $this->abslowtemp = c_or_f($abslowtemp);
        $this->abslowtempdate = $abslowtempdate;
    }

    function set_abshightemp($abshightemp, $abshightempdate) {
        $this->abshightemp = c_or_f($abshightemp);
        $this->abshightempdate = $abshightempdate;
    }

    function set_absminrain($absminrain) {
        $this->absminrain = $absminrain;
    }

    function set_absmaxrain($absmaxrain) {
        $this->absmaxrain = $absmaxrain;
    }

}

class ForecastDay extends TimeRange {

    var $temp_morning;
    var $temp_day;
    var $temp_night;
    var $hum_morning;
    var $hum_day;
    var $hum_night;
    var $dust_morning;
    var $dust_day;
    var $dust_night;
    var $visDay;
    var $uvmax;
    var $rainFrom;
    var $rainTo;
    function get_rainFrom() {
        return $this->rainFrom;
    }

    function set_rainFrom($rainFrom) {
        $this->rainFrom = $rainFrom;
    }
    function get_rainTo() {
        return $this->rainTo;
    }

    function set_rainTo($rainTo) {
        $this->rainTo = $rainTo;
    }

    function get_temp_morning() {
        return $this->temp_morning;
    }

    function set_temp_morning($temp_morning) {
        $this->temp_morning = $temp_morning;
    }

    function get_temp_day() {
        return $this->temp_day;
    }

    function set_temp_day($temp_day) {
        $this->temp_day = $temp_day;
    }

    function get_temp_night() {
        return $this->temp_night;
    }

    function set_temp_night($temp_night) {
        $this->temp_night = $temp_night;
    }
    
    function get_hum_morning() {
        return $this->hum_morning;
    }

    function set_hum_morning($hum_morning) {
        $this->hum_morning = $hum_morning;
    }

    function get_hum_day() {
        return $this->hum_day;
    }

    function set_hum_day($hum_day) {
        $this->hum_day = $hum_day;
    }

    function get_hum_night() {
        return $this->hum_night;
    }

    function set_hum_night($hum_night) {
        $this->hum_night = $hum_night;
    }
    function get_dust_morning() {
        return $this->dust_morning;
    }

    function set_dust_morning($dust_morning) {
        $this->dust_morning = $dust_morning;
    }

    function get_dust_day() {
        return $this->dust_day;
    }

    function set_dust_day($dust_day) {
        $this->dust_day = $dust_day;
    }

    function get_dust_night() {
        return $this->dust_night;
    }

    function set_dust_night($dust_night) {
        $this->dust_night = $dust_night;
    }
    function get_uvmax() {
        return $this->uvmax;
    }

    function set_uvmax($uvmax) {
        $this->uvmax = $uvmax;
    }
    function get_visday() {
        return $this->visday;
    }

    function set_visday($visday) {
        $this->visday = $visday;
    }

}

class ContentSection {

    var $Description;
    var $img_src;
    var $href;
    var $Title;

    function get_description() {
        return $this->Description;
    }

    function set_description($desc) {
        $this->Description = $desc;
    }

    function get_img_src() {
        return $this->img_src;
    }

    function set_img_src($img_src) {
        $this->img_src = $img_src;
    }

    function get_href() {
        return $this->href;
    }

    function set_href($href) {
        $this->href = $href;
    }

    function get_Title() {
        return $this->Title;
    }

    function set_Title($Title) {
        $this->Title = $Title;
    }

}

function randomFile($file) {
    $items = file($file);
    $item = rand(0, sizeof($items) - 1);
    return $items[$item];
}

function getLocalTime($time) {
    return date(" D j/m/y H:i", strtotime(SERVER_CLOCK_DIFF, $time));
}

function getLocalDay($time) {
    return date(" D j/m/y", strtotime(SERVER_CLOCK_DIFF, $time));
}

function getLocalHour($time) {
    return date("H", strtotime(SERVER_CLOCK_DIFF, $time));
}
function getLocalHourMin($time) {
    return date("H:i", strtotime(SERVER_CLOCK_DIFF, $time));
}

function searchNext(&$tok, $strTofind) {
    if ($_GET['debug'] >= 4)
        echo "<br>SearchingNext (" . $strTofind . ")<br>";
    if ($tok === $strTofind)
        $tok = strtok("  \n\t"); // It is meant for searching the next, not current
    $firsttok = $tok;
    $prevtok = "prv";

    while ((!($tok === $strTofind)) && (!($tok === FALSE))) {
        $prevtok = $tok;
        $tok = strtok("  \n\t");
        if ($_GET['debug'] >= 4)
            echo ".'" . $tok . "'";
    }

    if ($tok) {
        if ($_GET['debug'] >= 4)
            echo " found<br>";
        return true;
    }
    else {
        if ($_GET['debug'] >= 4)
            echo " not found<br>";
        $tok = strtok($firsttok, " \n\t"); // need to get the previous token - change it
        return false;
    }
}

function searchNextLike(&$tok, $strTofind) {
    if ($_GET['debug'] >= 4)
        echo "<br>SearchingNext (" . $strTofind . ")<br>";
    if ($tok === $strTofind)
        $tok = strtok("  \n\t"); // It is meant for searching the next, not current
    $firsttok = $tok;
    $prevtok = "prv";

    while ((!stristr($tok, $strTofind)) && (!($tok === FALSE))) {
        $prevtok = $tok;
        $tok = strtok("  \n\t");
        if ($_GET['debug'] >= 4)
            echo ".'" . $tok . "'";
    }

    if ($tok) {
        if ($_GET['debug'] >= 4)
            echo " found<br>";
        return true;
    }
    else {
        if ($_GET['debug'] >= 4)
            echo " not found<br>";
        $tok = strtok($firsttok, " \n\t"); // need to get the previous token - change it
        return false;
    }
}

function searchDoubleNext(&$tok, $strTofind, $str2Tofind) {
    if ($_GET['debug'] >= 4)
        echo "<br>SearchingNext (" . $strTofind . ")<br>";
    if ($tok === $strTofind)
        $tok = strtok("  \n\t"); // It is meant for searching the next, not current
    $firsttok = $tok;
    $prevtok = "prv";
    while (($tok !== $strTofind) && ($tok !== $str2Tofind) && (!($tok === FALSE))) {
        $prevtok = $tok;
        $tok = strtok("  \n\t");
        if ($_GET['debug'] >= 4)
            echo ".";
    }

    if ($tok) {
        if ($_GET['debug'] >= 4)
            echo "found<br>";
        return true;
    }
    else {
        if ($_GET['debug'] >= 4)
            echo "not found<br>";
        $tok = strtok($firsttok, " \n\t"); // need to get the previous token - change it
        return false;
    }
}

function getTokFromFile($file) {
    $timeout = 2;
    $fp = fopen($file, "r");
    stream_set_timeout($fp, $timeout);
    $filecontents = fread($fp, filesize($file));
    @fclose($fp);
    $tok = strtok($filecontents, " \n\t");
    return $tok;
}

// end func ()

function getNextWord(&$tok, $intNextWord, $title) {

    if ($_GET['debug'] >= 4)
        echo "SearchingNextWord = " . $intNextWord . "<br>";

    for ($i = 0; $i < $intNextWord; $i++) {
        $tok = strtok("  \t");
        if ($_GET['debug'] >= 4)
            echo "tok = " . $tok . "<br>";

        while ($tok === "") {//searching for next meaningfull tok
            $tok = strtok("  \t");
            if ($_GET['debug'] >= 4)
                echo "tok = " . $tok . "<br>";
        }
    }
    if ($_GET['debug'] >= 4)
        echo "<b>$title tok found = " . $tok . "</b><br>";
    return $tok;
}

// end func	

function getNextWordWith(&$tok, $str) {

    if ($_GET['debug'] >= 4)
        echo "<br>SearchingNextWordWith = " . $str . "<br>";

    $tok = strtok("  \n\t"); // It is meant for searching the next, not current
    if ($_GET['debug'] >= 4)
        echo "tok = " . $tok . "<br>";

    while (!strstr($tok, $str)) {
        $tok = strtok("  \t");
        if ($_GET['debug'] >= 4)
            echo "tok = " . $tok . "<br>";
    }
    if ($_GET['debug'] >= 4)
        echo "<b>found = " . $tok . "</b><br>";
    return $tok;
}

// end func
// split a string into an array of space-delimited tokens, taking double-quoted strings into account
function tokenizeQuoted($string) {
    for ($tokens = array(), $nextToken = strtok($string, ' \r\n\t'); $nextToken !== false; $nextToken = strtok(' \r\n\t')) {
        if ($nextToken{0} == '"')
            $nextToken = $nextToken{strlen($nextToken) - 1} == '"' ?
                    substr($nextToken, 1, -1) : substr($nextToken, 1) . ' ' . strtok('"');
        $tokens[] = $nextToken;
    }
    return $tokens;
}

function date_diff_hours($str_start, $str_end) {

    $str_start = strtotime($str_start); // The start date becomes a timestamp
    $str_end = strtotime($str_end); // The end date becomes a timestamp

    $nseconds = $str_end - $str_start; // Number of seconds between the two dates
    $ndays = round($nseconds / 86400); // One day has 86400 seconds
    $nseconds = $nseconds % 86400; // The remainder from the operation
    $nhours = round($nseconds / 3600); // One hour has 3600 seconds
    $nseconds = $nseconds % 3600;
    $nminutes = round($nseconds / 60); // One minute has 60 seconds, duh!
    $nseconds = $nseconds % 60;
    return $nhours;
}
function is_in_twilight()
{
    global $current;
    return ((get_sunset_ut() - $current->get_current_time_ut() > 8600) && ($current->get_current_time_ut() - get_sunrise_ut() > 8600));
}
function isTempF(){
    if (!isset($_GET['tempunit']))
        return false;
    return ($_GET['tempunit'] == 'F');
}
function c_or_f($temp) {
    if (isset($_GET['tempunit']))
    if ($_GET['tempunit'] == 'F') {

        return ( round(((9 * $temp) / 5) + 32));
    }

    return $temp;
}

function date_diff_sec($str_start, $str_end) {

    $str_start = strtotime($str_start); // The start date becomes a timestamp
    $str_end = strtotime($str_end); // The end date becomes a timestamp

    $nseconds = $str_end - $str_start; // Number of seconds between the two dates
    return $nseconds;
}

function date_diff_days($str_start, $str_end) {

    $str_start = strtotime($str_start); // The start date becomes a timestamp
    $str_end = strtotime($str_end); // The end date becomes a timestamp

    $nseconds = $str_end - $str_start; // Number of seconds between the two dates
    $ndays = round($nseconds / 86400); // One day has 86400 seconds
    return $ndays;
}

function getLastUpdateMin() {
    global $offset;
    return $offset + INTERVAL;
}

/**
  util function that get the minus hour time in string
 */
function getMinusHourTime($minusHour) {
    global $hour, $ymin;
    return sprintf("%d:%02d", $hour < $minusHour ? $hour + (24 - $minusHour) : $hour - $minusHour, $ymin);
}

// end func

function getMinusHourDate($minusHour) {
    global $day, $month, $year, $hour;
    return date(DATE_FORMAT, mktime($hour - $minusHour, 0, 0, $month, $day, $year));
}

// end func

function getMinusHourDay($minusHour) {
    global $day, $month, $year, $hour;
    return date("j", mktime($hour - $minusHour, 0, 0, $month, $day, $year));
}

// end func

function getMinusHourMonth($minusHour) {
    global $day, $month, $year, $hour;
    return date("m", mktime($hour - $minusHour, 0, 0, $month, $day, $year));
}

// end func

function getMinusMinTime($minusMin) {
    global $hour, $min, $offset;
    if (isset($_GET['debug']))
    if ($_GET['debug'] >= 3)
        echo "<br>getMinusMinTime: hour=" . $hour . " min=" . $min . " minusMin=" . $minusMin . " offest=" . $offset;
    $ret_date = date("G:i", mktime($hour, $min - $minusMin - $offset));
    if ($ret_date == "0:00")
        $ret_date = "00:00";
    return $ret_date;
}

// end func

function getMinusMinDate($minusMin) {
    global $day, $month, $year, $hour, $min;
    return @date(DATE_FORMAT, mktime($hour, $min - $minusMin, 0, $month, $day, $year));
}

// end func*/

function getMinusDayDay($minusDay) {
    global $day, $month, $year, $hour, $min;
    return date("j", mktime(0, 0, 0, $month, $day - $minusDay, $year));
}

// end func*/

function getMinusDayMonth($minusDay) {
    global $day, $month, $year, $hour, $min;
    return date("m", mktime(0, 0, 0, $month, $day - $minusDay, $year));
}

// end func*/

function enum() {
    $ArgC = func_num_args();
    $ArgV = func_get_args();

    for ($Int = 0; $Int < $ArgC; $Int++)
        define($ArgV[$Int], $Int);
}

enum("ME", "ALL", "GroupA", "SPECIAL", "HS");

class Chance {
    const VLow = 0;
    const Low = 1;
    const Good = 2;
    const High = 3;

}
class Activities {
    const Sport = "Sport";
    const Laundry ="Laundry";
    const Picnic = "Picnic";
    const Boiler = "Boiler";
    const Bicycle = "Bicycle";
    const Camping = "Camping";
    const OpenWindow = "OpenWindow";
    const DinnerAtBalcony = "DinnerAtBalcony";
    const Dog = "Dog";
    const AC = "AC";
    const SACKER = "SACKER";
    const TEDY = "TEDY";
    const CAMPFIRE = "CAMPFIRE";
    const EVENTOUTSIDE = "EVENTOUTSIDE";
    const YOGA = "YOGA";
    const CHILDRENS = "CHILDREN";
    const WESTERNWALL = "WESTERNWALL";
    const GAZELLEPARK = "GAZELLEPARK";
    const IRRIGATION = "IRRIGATION";
    const HEATER = "HEATER";
    const CARCLEANING = "CAR";
}
class Parameters {
    const Temp = "Temp";
    const Humidity ="Humidity";
    const Wind = "Wind";
    const UV = "UV";
    const DewPoint = "DewPoint";
    const Dust = "Dust";
    const ValleyTemp = "ValleyTemp";
    const RoadTemp = "RoadTemp";
    const AirPressure = "AirPressure";
    const Radiation = "Radiation";
    const RainChance = "RainChance";
    
}
class Recommendations {
    const Yes = 1;
    const No = 0;
    const Maybe = 2;
    
}
class TimeFrame {
    const Current = 0;
    const Hourly = 1;
    const Daily = 2;
    const Monthly = 3;
    
}
Class CustomAlert {
    const HighUV = "UV";
    const ExtremeUV = "ExtremeUV";
    const HighET = "HighET";
    const Dry = "Dry";
    const LowRadiation = "LowRad";
    const Dust = "Dust";
    const HighDust = "HighDust";
    const FireIndex = "FireIndex";
    const HotGround = "HotGround";
}
/********************************************************************/
	// This function is called for every opening XML tag. We
// need to keep track of our path in the XML file, so we
// will use this function to add the tag name to an array
function startElement($parser, $name, $attrs=''){

   // Make sure we can access the path array
   global $ary_path;
  
   // Push the tag into the array
   array_push($ary_path, $name);

   }

// This function is called for every closing XML tag. We
// need to keep track of our path in the XML file, so we
// will use this function to remove the last item of the array.
function endElement($parser, $name, $attrs=''){

   // Make sure we can access the path array
   global $ary_path;
  
   // Push the tag into the array
   array_pop($ary_path);

   }

// This function is called for every data portion found between
// opening and closing tags. We will use it to insert values
// into the array.
function characterData($parser, $data){
  
   // Make sure we can access the path and parsed file arrays
   // and the starting level value
   global $ary_parsed_file, $ary_path, $int_starting_level;

   // Remove extra white space from the data (so we can tell if it's empty)
   $str_trimmed_data = trim($data);
  
   // Since this function gets called whether there is text data or not,
   // we need to prevent it from being called when there is no text data
   // or it overwrites previous legitimate data.
   if (!empty($str_trimmed_data)) {

       // Build the array definition string
       $str_array_define = '$ary_parsed_file';
              
       // Add a [''] and data for each level. (Starting level can be defined.)
       for ($i = $int_starting_level; $i < count($ary_path); $i++) {
      
           $str_array_define .= '[\'' . $ary_path[$i] . '\']';
          
           }
      
       // Add the value portion of the statement
       $str_array_define .= " = '" . $str_trimmed_data . "';";
      
       // Evaluate the statement we just created
       eval($str_array_define);
      
       // DEBUG
       //echo "\n" . $str_array_define;
      
       } // if

   }
/***************************************************************
		initialize all variables
***************************************************************/
function init()
{
			
}

function first_page(){        
	global $template_routing;        
	return (($template_routing == '')||($template_routing == "home")||($template_routing == "extended"));    
}
function extended()
{
	global $template_routing;
	return ($template_routing == "extended");
}
function first_enter(){        
	return (isset($_POST['button']));    
}

function isNoBackground()
{
	global $template_routing;
	return ((!strstr($template_routing, "jpg"))&&(!strstr($template_routing, "gif"))&&(!($template_routing == "graph"))&&(!strstr($template_routing, "pic")));
	
}

function isRaining()
{
	global $mem, $current, $now, $hour;
	if ($_GET['debug'] >= 2)
		echo "<br>now rain:".$now->get_rain();
    if (SNOW_IS_MELTING == 1)
            return false;
    if ($current->get_solarradiation() > 310)
        return false;
	if (($current->get_rainrate2() !== "0.0")&& ($current->get_rainrate2() !== "")&& ($current->get_rainrate2() > 0))
    {
        $mem->set('lastSentRainStarted', date('Y-m-d'));
		return true;
    }
	if (($now->get_rain() != "0.00")&& ($now->get_rain() != "")&& ($now->get_rain() > 0)&& ($current->get_windspd() > 0))	return true;
	return false;
}
function getStormRain()
{
    global $mem;
    $DailyRain = $mem->get(LAST_7DAYS_DAILY_RAIN);
    $stormrain = 0;
    foreach ($DailyRain as $key => &$day) 
    {
        //echo $day['Date']." ";
        if ($day['DailyRain'] != 0)
            $stormrain = $stormrain + $day['DailyRain'];
        else
            return $stormrain;
    }
    return $stormrain;
    
}
function isSnowing()
{
	global $current, $template_routing;
	return (((isRaining())&&($current->get_temp('C') < 1.9))||(stristr($template_routing, 'snow'))||(IS_SNOWING == 1));
}


function isHeb()
{
	global $lang_idx;
	return ($lang_idx == 1);
}
	
function get_fileFromdir($path){    
		 
	$items = getfilesFromdir($path);
	$item = @rand(0, sizeof($items)-1);	  
	return $items[$item][1];
	#done! Show the files sorted by modification date
	 //foreach ($files as $file)
	 //   echo "$file[0] $file[1]<br>\n";  #file[0]=Unix timestamp; file[1]=filename
}

function getfilesFromdir($path){    
	$dirToOpen = $path;    
	$files = array();    
	if ($handle = @opendir($dirToOpen)) {      
	   while (false !== ($file=readdir($handle)))
	   {
		  if (substr($file,0,1)!=".")
			 $files[]=array(filemtime($path."/".$file),$path."/".$file);   #2-D arraysend
	   }
	   @closedir($handle);
	   if ($files)
	   {
		  rsort($files); #sorts by filemtime
	   }
	}
	return $files;
}  

function getLastFilesFromDir($path, $numberOfLast)
{
	$files = getfilesFromdir($path);
	$files_ret = array();
	$idx = 0;
	foreach ($files as $file)
	{
	   if ($idx < $numberOfLast)
			array_push($files_ret, $file); 
		$idx = $idx + 1;
	}
	return $files_ret;
}

function get_file_string($full_search_url){        
	
//	$ch = curl_init();
//	$timeout = 8; 
//	curl_setopt ($ch, CURLOPT_URL, $full_search_url);
//	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
//	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
//	$full_page = curl_exec($ch);
//	curl_close($ch);
//	return $full_page;
	$full_page = @file_get_contents($full_search_url);
    return $full_page;    
}  

 function fillPastTime (&$pastTime, $ary_parsed_file, $prefix){
                global $tok, $current, $PRIMARY_TEMP;
				if ($_GET['debug']  >= 2) {
					echo "<br>**** fillingPastTime ".$pastTime->get_time()." ****<br>";
                                        //print_r($ary_parsed_file);
                                        echo 'TEMP3'.$prefix.":".$ary_parsed_file['TEMP3'.$prefix];
				}
                
                    $pastTime->set_temp($ary_parsed_file['TEMP'.$prefix]);
                    $pastTime->set_hum($ary_parsed_file['HUMIDITY'.$prefix]);
                    $pastTime->set_dew($ary_parsed_file['DEWPT'.$prefix]);
                    $pastTime->set_windspd($ary_parsed_file['WINDSPEED'.$prefix]);
                    $pastTime->set_winddir($ary_parsed_file['WINDDIRECTION'.$prefix]);
                    $pastTime->set_windchill($ary_parsed_file['WINDCHILL'.$prefix]);
                    $pastTime->set_heatidx($ary_parsed_file['HEATINDEX'.$prefix]);
                    $pastTime->set_thw($ary_parsed_file['THW'.$prefix]);
                    $pastTime->set_thsw($ary_parsed_file['THSW'.$prefix]);
                    $pastTime->set_pressure($ary_parsed_file['BAR'.$prefix]);
                    $pastTime->set_cloudbase((($pastTime->get_temp()-$pastTime->get_dew()) * 125) + ELEVATION);
                    $pastTime->set_rainrate($ary_parsed_file['RAINRATE'.$prefix]);
                    $pastTime->set_solarradiation($ary_parsed_file['SOLARRAD'.$prefix]);
                    $pastTime->set_uv($ary_parsed_file['UV'.$prefix]);
                    $pastTime->set_temp2($ary_parsed_file['TEMP2'.$prefix]);
                    $pastTime->set_temp3($ary_parsed_file['TEMP3'.$prefix]);
                    $pastTime->set_hum2($ary_parsed_file['HUMIDITY'.$prefix]);
                    if ($PRIMARY_TEMP == 1)
                        $pastTime->set_change($current->get_temp(), 
                                            $current->get_hum(), 
                                            $current->get_dew(), 
                                            $current->get_windspd(), 
                                            $current->get_pressure(),
                                            $current->get_cloudbase(),
                                            $current->get_rainrate(),
                                            $current->get_solarradiation(),
                                            $current->get_uv(),
                                            $current->get_temp2(),
                                            $current->get_temp3(),
                                            $current->get_pm10(),
                                            $current->get_pm25());
                    else if ($PRIMARY_TEMP == 2)
                        $pastTime->set_change($current->get_temp2(), 
                                            $current->get_hum(),
                                            $current->get_dew(), 
                                            $current->get_windspd(), 
                                            $current->get_pressure(),
                                            $current->get_cloudbase(),
                                            $current->get_rainrate(),
                                            $current->get_solarradiation(),
                                            $current->get_uv(),
                                            $current->get_temp(),
                                            $current->get_temp3(),
                                            $current->get_pm10(),
                                            $current->get_pm25());
 }
                
 

/*****************************************************************/
// returns array of rain accumulation
function getRainAcc($thedate, $fromTime, $toTime) {

    global $datenotime;
    $rainaccA = array();
    if ($_GET['debug'] >= 1)
        echo "<br>searching from ", $thedate, " ", $fromTime, " to ", $datenotime, " " . $toTime . "<br>";
    $tok = getTokFromFile(FILE_ARCHIVE);
    if (searchNext($tok, $thedate)) {
        if (searchNext($tok, $fromTime)) {

            for ($rainTime = $fromTime, $rainAcc = 0, $rainDate = $thedate; (($rainTime != $toTime) ) || ((ltrim($rainDate) != $datenotime) && ($rainTime == $toTime)); $rainDate = getNextWordWith($tok, "/"), $rainTime = getNextWordWith($tok, ":")) {

                $rainAcc = $rainAcc + getNextWord($tok, 16, "rainAcc");
                array_push($rainaccA, array('date' => $rainDate, 'time' => $rainTime, 'rainacc' => $rainAcc));
                if ($_GET['debug'] >= 2)
                    echo "<br>'" . $rainDate . "' " . $rainTime . " : " . $rainAcc;
            }
            $rainAcc = $rainAcc + getNextWord($tok, 16, "rainAcc"); // the last line of accumulation
            array_push($rainaccA, array('date' => $rainDate, 'time' => $rainTime, 'rainacc' => $rainAcc));
            if ($_GET['debug'] >= 2) {
                //echo "<br>".$rainTime."<>".$toTime." ".$rainDate."<>".$datenotime;
                echo "<br>last: " . $rainDate . " " . $rainTime . " : " . $rainAcc;
            }
            return $rainaccA;
        } else
            return "(records weren't found)";
    } else
        return "(records weren't found)";
}

function getRainAccInterval($rainInterval) {

    $MinusBaseHours = 0;
    $MinusBaseMin = 0;
    global $HOURS, $HOUR, $lang_idx, $RAIN_UNIT;

    $arrayrain = getRainAccArray($rainInterval, $MinusBaseHours, $MinusBaseMin);
    $rainAcc = number_format($arrayrain[count($arrayrain) - 1]['rainacc'], 1, '.', '');

    if ($rainAcc > 0) {
        $result .= $rainInterval . " " . $HOURS[$lang_idx] . ": ";
        $result .= "";
        $result .= "" . $rainAcc . " " . $RAIN_UNIT[$lang_idx];
        //$result  .= "<span>".getRainIntesity($rainInterval, $rainAcc)." mm/hr</span>";
        $result .= "\n";
    }
    return $result;
}

function getRainAccArray($rainInterval, $MinusBaseHours, $MinusBaseMin) {

    $tok = getTokFromFile(FILE_ARCHIVE);
    if ($_GET['debug'] >= 1)
        echo "<br>getRainAccInterval = " . $rainInterval . "<br>";

    if ($_GET['debug'] >= 2)
        echo "<br>searching" . getMinusMinDate($MinusBaseMin) . " " . getMinusMinTime($MinusBaseMin);
    if (searchNext($tok, getMinusMinDate($MinusBaseMin)))
        $found = searchNext($tok, getMinusMinTime($MinusBaseMin));
    else
        return false;
    if ($found) {
        $arrayrain = getRainAcc(getMinusMinDate($MinusBaseMin + $rainInterval * 60), getMinusMinTime($MinusBaseMin + $rainInterval * 60), getMinusMinTime($MinusBaseMin));
        return $arrayrain;
    } else
        return false;
}

function getRainIntesity($rainIntervalHour, $rainAcc) {
    return number_format(($rainAcc / $rainIntervalHour), 1, '.', '');
}

function getRainAccTable() {
    $result .= "<div><div class=\"inv_plain_3_zebra\" ";
    if (isHeb())
        $result .= "dir=\"rtl\" style=\"text-align:left\"";
    $result .= ">";
    $result .= getRainAccInterval(0.5);
    $result .= "</div>";
    $result .= "<div class=\"inv_plain_3_minus\" ";
    if (isHeb())
        $result .= "dir=\"rtl\" style=\"text-align:left\"";
    $result .= ">";
    $result .= getRainAccInterval(1);
    $result .= "</div>";
    $result .= "<div class=\"inv_plain_3_zebra\" ";
    if (isHeb())
        $result .= "dir=\"rtl\" style=\"text-align:left\"";
    $result .= ">";
    $result .= getRainAccInterval(6);
    $result .= "</div>";
    $result .= "<div class=\"inv_plain_3_minus\" ";
    if (isHeb())
        $result .= "dir=\"rtl\" style=\"text-align:left\"";
    $result .= ">";
    $result .= getRainAccInterval(12);
    $result .= "</div>";
    $result .= "<div style=\"text-align:left\" class=\"inv_plain_3_zebra\" ";
    if (isHeb())
        $result .= "dir=\"rtl\" style=\"text-align:left\"";
    $result .= ">";
    $result .= getRainAccInterval(24);
    $result .= "</div></div>";
    return ($result);
}

function extractRainAccArray($arrayrain) {

    if ($_GET['debug'] >= 2)
        echo "<br> array count = " . count($arrayrain);
    for ($i = 0; $i < count($arrayrain); $i++) {
        $result .= "<tr class=base><td>";
        $result .= $arrayrain[$i]['date'] . "</td><td>" . $arrayrain[$i]['time'] . "</td><td>" . number_format($arrayrain[$i]['rainacc'], 1, '.', '') . "mm";
        $result .= "</td></tr>";
    }
    return $result;
}

function getRainAccArrayTable($interval) {
    $result = "<table>";
    //$result .= "<tr class=topbase><td>Hours</td><td>mm</td></tr>";
    $arrayrain = getRainAccArray($interval, 0, 0);
    if (count($arrayrain) == 1)
        $result .= "<tr class=\"base\"><td> invalid input </td></tr>";
    else
        $result .= extractRainAccArray($arrayrain);
    $result .= "</table>";
    return ($result);
}

function extract_Array($array) {
    $res = "";
    $keys = array_keys($array);
    $values = array_values($array);
    print("<table>");
    for ($i = 0; $i < count($keys); $i++) {
        print("<tr class=base><td>$keys[$i]:</td><td>");
        if (is_array($values[$i]))
            extract_Array($values[$i]);
        else
            print($values[$i]);
        print("</td></tr>");
    }
    print("</table><hr>");

    return $res;
}

function extract_Weather($array) {
    $res = "";
    $keys = array_keys($array);
    $values = array_values($array);
    print("<table>");
    for ($i = 0; $i < count($keys); $i++) {
        print("<tr class=base><td>$keys[$i]:</td><td>");
        if (is_array($values[$i])) {// find string
            $innerKeys = array_keys($values[$i]);
            $innerValues = array_values($values[$i]);
            for ($j = 0; $j < count($innerKeys); $j++) {
                if ($innerKeys[$j] == "string")
                    print($innerValues[$j]);
            }
        } else
            print($values[$i]);
        print("</td></tr>");
    }
    print("</table><hr>");

    return $res;
}

function getDepFromNorm($month) {
    global $day;
    /* getting data from thisYear file */
    if ($_GET['debug'] > 2)
        echo "<br> searching getDepFromNorm for month = " . $month . "<br>";
    if (($day <= 3) && ($month == 12))
        $tok = getTokFromFile(FILE_PREV_YEAR);
    else
        $tok = getTokFromFile(FILE_THIS_YEAR);
    getNextWordWith($tok, "---");
    getNextWord($tok, 6, "Dep.From NORM"); // Dep.From NORM OF January
    $dep = $tok;
    for ($i = 1; $i < $month; $i++) {
        $dep = getNextWord($tok, 16, "Dep.From NORM"); // Next Dep.From NORM OF January
    }
    return $dep;
}

function getPrevMonthRain() {
    if ($_GET['debug'] > 2)
        echo "<br> searching getPrevMonthRain for Rain <br>";
    $tok = getTokFromFile(FILE_PREV_YEAR);
    getNextWordWith($tok, "---");
    getNextWord($tok, 2, "MonthRain");
    getNextWordWith($tok, "---");
    getNextWord($tok, 8, "MonthRain"); // RAIN
    return $tok;
}


function send_SMS($number, $text) {
    
}

function send_Email($messageBody, $target, $source, $sourcename, $attachment, $subject) {
    global $header_pic;
    $footer_pic = "images/header/header_small1_text.jpg";
    $lines = 0;
    $result = "";
    //$target=ME;
    require("phpmailer/class.phpmailer.php");
    $mail = new PHPMailer();
    $mail->From = EMAIL_ADDRESS;
    //$mail->From = $source;
    $mail->FromName = $sourcename;
    //$mail->Host = "mailgw.netvision.net.il";
    //$mail->Mailer = "smtp";
    $mail->IsSMTP();
    $mail->IsHTML(true);
    $mail->Sender = $source;
    $mail->AddReplyTo($source, $sourcename);
    $mail->SMTPDebug  = 1;  
    //$mail->SMTPAuth   = TRUE;
    //$mail->SMTPSecure = "tls";

    if ((stristr($source, "mymail-in.net")) || (stristr($source, "list.ru")) || (stristr($source, "trasteembable")) || (stristr($source, "76up.com"))|| (stristr($target, "email.tst")))
        return false;
    global $MORE_INFO, $WEBSITE_TITLE, $EN, $HEB, $lang_idx, $forground_color, $base_color;
    $EmailsToSend = array();
    $textToSend = array();
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Subject: =?UTF-8?Q?".base64_encode($sourcename)."?=";
    //$headers .= "Content-Language: he\r\n";
    //$headers .= "From: {$source}\r\n";
   // $headers .= "Reply-To: {$source}\r\n";
    $headers .= "Return-Path: {$source}\r\n";
    $headers .= "Organization: 02WS\r\n";
    //$headers .= "Message-ID: <" . md5(uniqid(time())) . "@{$_SERVER['SERVER_NAME']}>";
    $headers .= "X-MSmail-Priority: Normal";
    $headers .= "X-Priority: 3\r\n";
    $headers .= "X-Mailer: PHP" . phpversion() . "\r\n";
    $headers .= "X-AntiAbuse: This is a solicited email for 02WS.co.il website\r\n";
   // $headers .= "X-AntiAbuse: Servername - {$_SERVER['SERVER_NAME']}\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "Content-Transfer-Encoding: quoted-printable\r\n";


    
    //echo("message body = ".$messageBody);
    $now = replaceDays(date('D H:i'));
    
    $multiLangBody = array();
    if (is_array($messageBody)) {
        for ($i = 0; $i < count($messageBody); $i++) {
            if (is_array($messageBody[$i])) {
                for ($j = 0; $j < count($messageBody[$i]); $j++)
                    array_push($multiLangBody, $messageBody[$i][$j]);
            } else {
                array_push($multiLangBody, $now." ".$messageBody[$EN]);
                array_push($multiLangBody, $now." ".$messageBody[$HEB]);
                // exit for
                $i = count($messageBody);
            }
        }
    }

    
    
    $genTxtToBuild = "<!DOCTYPE html><html ";
    if (($source !== EMAIL_ADDRESS) || (isHeb()))
        $genTxtToBuild .= " dir=\"rtl\" ";
    $genTxtToBuild .= "><head><style>.inv_plain_3_zebra     {        border: 1px solid #2C3A42; 	        background: rgba(228, 249, 251, 0.4);        color: #2C3A42;        padding: 12px;        margin: 0;        -webkit-border-radius: 8px;        border-radius: 8px;          
    }</style><link href=\"" . BASE_URL . "/main.php?lang=%d\" rel=\"stylesheet\" type=\"text/css\"> </head><body class=\"mailbody\" style=\"width:500px;margin:0 auto\"><img src=\"" . BASE_URL . "/" . $header_pic . "\" /><h3 style=\"padding:1em;width:400px;margin:0 auto\" class=\"mailheader\">%s</h3><p class=\"mailcontainer\"><div style=\"padding:1em\" class=\"clear inv_plain_3_zebra\">%s</div></p>";
    
    array_push($textToSend, sprintf($genTxtToBuild, $EN, $WEBSITE_TITLE[$EN], is_array($messageBody) ? $multiLangBody[$EN] : $messageBody ));
    array_push($textToSend, sprintf($genTxtToBuild, $HEB, $WEBSITE_TITLE[$HEB], is_array($messageBody) ? $multiLangBody[$HEB] : $messageBody));
    //$textToSend = '=?UTF-8?B?'.base64_encode($textToSend).'?=';
    if (!is_array($subject))
        $subject = "=?UTF-8?B?" . base64_encode($subject) . "?=";


    if ($target === ME) {
        //$subject = "*** " . $WEBSITE_TITLE[$EN] . " ***" . " from " . $source;
    } else {
        global $link;
        db_init("", "");
    }

    if ($target === SPECIAL) {
        $subject = "* Special Update from " . $WEBSITE_TITLE[$EN] . " *";
        $query = "SELECT * From users WHERE priority < '1'";
        $res = mysqli_query($link, $query);
        while ($line = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
            $lines++;
            array_push($EmailsToSend, array('email' => $line["email"], 'lang' => $line["lang"]));
        }
    } else if ($target == ALL) {
        $query = "SELECT * From users WHERE priority > '0'";
        $res = mysqli_query($link, $query);
        while ($line = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
            $lines++;
            array_push($EmailsToSend, array('email' => $line["email"], 'lang' => $line["lang"]));
        }
    } else if ($target == HS) {
        $query = "SELECT * FROM `users` WHERE `HS` = 0 and `user_status` =1 order by `user_registered` DESC LIMIT 500";
       //$query = "SELECT * FROM `users` WHERE `HS` = 0 and `user_status` =1 and email='boazn1@gmail.com'";
        $res = mysqli_query($link, $query);
        while ($line = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
            $lines++;
            array_push($EmailsToSend, array('email' => $line["email"], 'lang' => $line["lang"]));
        }

    } else if ($target === ME) {
        $mail->From = $source;
        array_push($EmailsToSend, array('email' => EMAIL_ADDRESS, 'lang' => $HEB));
    } else {//target = email
        $lang = $_GET['lang'] == "" ? $HEB : $_GET['lang'];
        array_push($EmailsToSend, array('email' => $target, 'lang' => $lang));
    }
    
       
    $textToSend = str_replace(array("display:none", "\n"), array("", "<br/>"), $textToSend);
    $emailsSent = 0;
    //logger("Sending mail: " . $source."(".$sourcename.")"." --> " . $target . " - " . implode(" / ", $subject). " lang:".$EmailsToSend[0]['lang']);
    foreach ($EmailsToSend as $email) {
        $body = $textToSend[$email['lang']];
        $body .= "\n<br /><footer><div style=\"clear:both;direction:rtl\" class=\"inv big\">" . $MORE_INFO[$email['lang']] . " - <a href=\"" . BASE_URL . "\">" . BASE_URL . "</a>.  <a href=\"" . BASE_URL . "/unsubscribe.php?email=".$email['email']."\">Unsubscribe</a></div><img src=\"" . BASE_URL . "/" . $footer_pic . "\" /></footer></body></html>";
        $mail->Body = $body;
        $mail->AltBody = strip_tags($textToSend[$email['lang']]);
        if ($target === ME)
            $mail->AddAddress($email['email'], "");
        else
            $mail->addBcc($email['email'], "");
    }
    $subjectToMail = "";
    if (is_array($subject)) {
        $mail->Subject = $subject[$email['lang']];
        $subjectToMail = $subject[$email['lang']];
    } else {
        $mail->Subject = $subject;
        $subjectToMail = $subject;
    }

    $mail->CharSet = "UTF-8";
    //$mail->AddStringAttachment("path/to/photo", "YourPhoto.jpg");
    //$mail->AddAttachment("c:/temp/11-10-00.zip", "new_name.zip");  // optional name
    $emailsSent++;
     if (!$mail->Send()) {
        mail("boazn1@gmail.com", "JWS mail failure", "failed sending to " . $email['email'], $headers);
        $result = "<br />failed sending to " . $email['email'] . " check your Email.";
    }else if ($target == HS)
    {
        $query = "UPDATE `users` SET `HS` = 1 WHERE email='".$email['email']."'";
        //logger("target=HS: ".$query);
        $res = mysqli_query($link, $query);
        
    }
    /*if (!mail($email['email'], $subjectToMail, $textToSend[$email['lang']], $headers)) {
        //ini_set("SMTP","mailgw.netvision.net.il");
        mail("boazn1@gmail.com", "JWS mail failure", "failed sending to " . $email['email'], $headers);
        $result = "<br />failed sending to " . $email['email'] . " check your Email.";
    }*/

    // Clear all addresses and attachments for next loop
    $mail->ClearAddresses();
    $mail->ClearAttachments();
    
    @mysqli_close($link);
    $result .= " ->".$emailsSent." emails Sent";
    return $result;
}

/**********************************************************************************************/

function user_login($user_id){
    // if is checked "remember me" when registaring
   $key = base64_encode(mcrypt_create_iv(100,MCRYPT_DEV_URANDOM)); // 
   // Be sure to store the $key value in your database
   setcookie("rememberme", $key, time()+3600*24*360); // Set the cookie to expire after 360 days
   $result = db_init("update users set user_rememberme=$key where user_login=$user_id", "");
   @mysqli_free_result($result);
}

function get_img_tag($change_in_param, $html = true) {
    global $GOING_UP, $GOING_DOWN, $lang_idx;
    if (!$html)
        return "";
    if ($change_in_param > 0)
        return "<div class='spriteB up' title='" . $GOING_UP[$lang_idx] . "'></div>";
    else if ($change_in_param < 0)
        return "<div class='spriteB down' title='" . $GOING_DOWN[$lang_idx] . "'></div>";
}

function get_tag($change_in_param, $html = true, $fulldisplay = true, $units) {
    global $KMH, $lang_idx;
    if (!$fulldisplay)
        return get_img_tag($change_in_param, $html);
    if ((is_float($change_in_param))&&($units!=$KMH[$lang_idx]))
        $number = number_format(abs(($change_in_param)), 1, '.', '');
    else
        $number = abs($change_in_param);
    if (!$html)
        return $number;
    if (abs($change_in_param) > 0)
        return "<div style='display:inline-block'>" . $number .$units.get_img_tag($change_in_param, $html). "</div>";
     else
        return ($change_in_param.$units);
    //echo number_format($change_in_param,1, '.', ''),$current->get_tempunit(),"</font>";
}

function get_font_tag($change_in_param, $html = true) {
    if (!$html)
        return abs(($change_in_param));
    if ($change_in_param > 0)
        return "<font class=\"high\">" . abs(($change_in_param)) . "</font>";
    else if ($change_in_param < 0)
        return "<font class=\"low\">" . abs(($change_in_param)) . "</font>";
    else
        return ($change_in_param);
}

function get_param_tag($change_in_param, $html = true, $units = "", $fulldisplay = true) {
    return get_tag($change_in_param, $html, $fulldisplay, $units);
    
}

function get_align() {

    if (isHeb())
        return "align=\"right\"";
    else
        return "align=\"left\"";
}

function get_inv_align() {

    if (isHeb())
        return "align=\"left\"";
    else
        return "align=\"right\"";
}

function get_s_align() {

    if (isHeb())
        return "right";
    else
        return "left";
}

function get_inv_s_align() {

    if (isHeb())
        return "left";
    else
        return "right";
}

function getDirection() {
    if (isHeb())
        return "rtl";
    else
        return "ltr";
}

function get_sunset_ut() {
    global $sunset;
    $sunset_a = explode(":", $sunset);
    $sunset_hh = intval($sunset_a[0]);
    $sunset_mm = intval($sunset_a[1]);
    $sunset_time_ut = mktime($sunset_hh, $sunset_mm);
    return $sunset_time_ut;
}

function get_sunrise_ut() {
    global $sunrise;
    $sunrise_a = explode(":", $sunrise);
    $sunrise_hh = intval($sunrise_a[0]);
    $sunrise_mm = intval($sunrise_a[1]);
    $sunrise_time_ut = mktime($sunrise_hh, $sunrise_mm);
    return $sunrise_time_ut;
}

function get_flash_tag($flash, $width) {
    $widthFlash = $width;
    $heightFlash = $widthFlash / 2;
    if (!isRaining())
        $flashFile = "images/jws.swf";
    else
        $flashFile = $flash;
    return "\n<embed height={$heightFlash} width={$widthFlash} src=\"$flashFile\" play=true loop=true quality=high WMode=Transparent></embed>";
}

function getFireIdx($t850, $t700, $dp850) {

    if ($t850 == 0)
        return false;
    $A = $t850 - $t700;
    if ($A < 6)
        $A = 1;
    else if (($A >= 6) && ($A < 11))
        $A = 2;
    else if ($A >= 11)
        $A = 3;

    $B = $t850 - $dp850;
    if ($B < 6)
        $B = 1;
    else if (($B >= 6) && ($B < 13))
        $B = 2;
    else if ($B >= 13)
        $B = 3;

    //echo $t850." ".$t700." ".$dp850." <br />";
    //echo "A=".$A."B=".$B;
    return ($A + $B);
}
       ///////////////////////////////////////////////////////
// radiosonde link
///////////////////////////////////////////////////////
function getRadioSondeLink()
{
	global $hour, $year,  $month, $day, $hoursonde; 

	if ($hour<=14)	
		$hoursonde = 00;  
	else	
		$hoursonde = 12; 
	$day_radio = $day; 
	$month_radio = $month;  
	if ($hour<=3){	
		$hoursonde = 12;    
		$day_radio = getMinusDayDay(1);    
		$month_radio = getMinusDayMonth (1);   
	}  
	$stnNum = 40179;//first station 40179 bet dagan//2nd station: 40265 OJMF Mafraq //3rd station : 62337 ElArish  
	$radiosonde_link = sprintf ("http://weather.uwyo.edu/cgi-bin/sounding?region=naconf&TYPE=TEXT%02sALIST&YEAR=%d&MONTH=%02d&FROM=%02d%02d&TO=%02d%02d&STNM=%d","%3", $year, $month_radio, $day_radio, $hoursonde, $day_radio, $hoursonde, $stnNum);
	//echo $radiosonde_link;
	return ($radiosonde_link);
}
/////////////////////////////////////////////////////////////////////////////////////////////
// URL handling
/////////////////////////////////////////////////////////////////////////////////////////////

function get_url() {
    if ($_SERVER["QUERY_STRING"] != "")
        return ("https://" . $_SERVER["HTTP_HOST"] . $_SERVER["PHP_SELF"] . "?" . $_SERVER["QUERY_STRING"]);
    else
        return ("https://" . $_SERVER["HTTP_HOST"] . $_SERVER["PHP_SELF"]);
}

function replaceArgInIRL($url, $arg, $val) {
    global $lang_idx;
    $section = $_GET["section"];
    $profile = $_GET["profile"];
    $style = $_GET["style"];
    $tempunit = $_GET["tempunit"];
    $startargs = "";
    if (($arg != "section") && ($section != ""))
        $startargs .= "section=" . $section . "&amp;";
    if (($profile != "") && ($arg == "graph"))
        $startargs .= "profile=" . $profile . "&amp;";
    if ($style != "")
        $startargs .= "style=" . $style . "&amp;";
    if ($tempunit != "")
        $startargs .= "tempunit=" . $tempunit . "&amp;";
    //$url_pref = BASE_URL;
    $url_pref = $_SERVER['SCRIPT_NAME'];
    if (!stristr($url_pref, "php")) {
        $url_pref .= "/" . basename($_SERVER["PHP_SELF"]);
    }

    if ($val == "")
        return ($url_pref . "?" . $startargs . "lang=" . $lang_idx);
    else
        return ($url_pref . "?" . $startargs . $arg . "=" . $val . "&amp;lang=" . $lang_idx);
}

function get_query_edited_url($url, $arg, $val) {
    return replaceArgInIRL($url, $arg, $val);
    $parsed_url = parse_url($url);
    parse_str($parsed_url['query'], $url_query);
    // remove key if value is empty
    if ($val == '')
        unset($url_query[$arg]);
    else
        $url_query[$arg] = $val;
    $parsed_url['query'] = http_implode($url_query);
    //print_r ("parsed_url = ".$parsed_url."<br>");
    $url = glue_url($parsed_url);
    return $url;
}

function glue_url($parsed) {
    if (!is_array($parsed))
        return false;
    $uri = $parsed['scheme'] ? $parsed['scheme'] . ':' . ((strtolower($parsed['scheme']) == 'mailto') ? '' : '//') : '';
    $uri .= $parsed['user'] ? $parsed['user'] . ($parsed['pass'] ? ':' . $parsed['pass'] : '') . '@' : '';
    $uri .= $parsed['host'] ? $parsed['host'] : '';
    $uri .= $parsed['port'] ? ':' . $parsed['port'] : '';
    $uri .= $parsed['path'] ? $parsed['path'] : '';
    $uri .= $parsed['query'] ? '?' . $parsed['query'] : '';
    $uri .= $parsed['fragment'] ? '#' . $parsed['fragment'] : '';
    return $uri;
}

function http_implode($arrayInput) {
    if (!is_array($arrayInput))
        return false;

    $url_query = "";
    foreach ($arrayInput as $key => $value) {

        $url_query .=(strlen($url_query) > 1) ? "&amp;" : "";
        $url_query .= urlencode($key) . '=' . urlencode($value);
    }
    return $url_query;
}

/////////////////////////////////////////////////////////////////////////////////
function update_action($action, $extrainfoS, $messageTitle) {
    global $pic, $hour, $min, $CURRENT_SIG_WEATHER, $HEB, $EN, $messageAction, $actionActive, $EmailSubject, $link, $date, $dateInHeb, $EN, $HEB, $RU, $FR, $AR;
    $message = array("<div class=\"big\">" .$date . "<br/>" . "</div><div class=\"big loading\">" . "&nbsp;$CURRENT_SIG_WEATHER[$EN]&nbsp;<br/> <strong>" . $messageTitle[$EN] . "</strong><div class=\"loading  big\">&nbsp;{$extrainfoS[$EN][0]}<br/><br/><img src=\"" . BASE_URL . "/images/$pic\" alt=\"$messageTitle[$EN]\" width=\"600px\" border=\"0\" /></div></div>",
                     "<div class=\" big\">" . $dateInHeb . "<br/>" . "</div><div class=\" big loading\">" . "&nbsp;$CURRENT_SIG_WEATHER[$HEB]&nbsp;<br/> <strong>" . $messageTitle[$HEB] . "</strong><div class=\"loading  big\">&nbsp;{$extrainfoS[$HEB][0]}<br/><br/><img src=\"" . BASE_URL . "/images/$pic\" alt=\"$messageTitle[$HEB]\" width=\"600px\" border=\"0\" /></div></div>",
                     "<div class=\" big\">" . $dateInHeb . "<br/>" . "</div><div class=\" big loading\">" . "&nbsp;$CURRENT_SIG_WEATHER[$HEB]&nbsp;<br/> <strong>" . $messageTitle[$HEB] . "</strong><div class=\"loading  big\">&nbsp;{$extrainfoS[$HEB][0]}<br/><br/><img src=\"" . BASE_URL . "/images/$pic\" alt=\"$messageTitle[$HEB]\" width=\"600px\" border=\"0\" /></div></div>",
                     "<div class=\" big\">" . $dateInHeb . "<br/>" . "</div><div class=\" big loading\">" . "&nbsp;$CURRENT_SIG_WEATHER[$HEB]&nbsp;<br/> <strong>" . $messageTitle[$HEB] . "</strong><div class=\"loading  big\">&nbsp;{$extrainfoS[$HEB][0]}<br/><br/><img src=\"" . BASE_URL . "/images/$pic\" alt=\"$messageTitle[$HEB]\" width=\"600px\" border=\"0\" /></div></div>");
    if (!isActionAlreadyActivated($action)) {
        $sent = 1;
        $result = db_init("UPDATE sendmailsms SET Sent=$sent, lastSent=NOW() WHERE (Action='$action')", "");
        //echo "affected rows: ".mysql_affected_rows();
        array_push($messageAction, $message);
        //callTopicFirebaseSender($topic, $messageBody, $title, $picture_url, $embedded_url);
        $extraInfoAlert = array($extrainfoS[$EN][0], $extrainfoS[$HEB][0]);
        callCustomAlertSender($extraInfoAlert, $messageTitle, "", "", $action);
        $actionActive = $action;
        $EmailSubject = $messageTitle;
        logger("update_action :  " . implode(" / ", $EmailSubject) . ": " . implode(" || ", $message), 0, "actions", "", "update_action");
        @mysqli_close($link);
    } else
        return false;
    return true;
}

function isActionAlreadyActivated($action) {
    global $messageAction, $link;

    $result = db_init("SELECT * FROM sendmailsms WHERE (Action=?)", $action);
    $row = @mysqli_fetch_array($result["result"], MYSQLI_ASSOC);
    $sent = $row["Sent"];
    @mysqli_close($link);
    if ($sent == 0)
        logger("action " . $action . " sent=" . $sent, 0, "actions", "", "update_action");
    return ($sent == 1);
}

function setBrokenData($period, $highorlow, $extdata, $param) {
    global $mem, $year, $hour, $datenotime, $boolbroken, $day, $messageBroken, $error_db, $updateMessage, $month, $messageBrokenToSend, $NEW, $BROKEN, $RECORD, $YEARLY, $LAST_RECORD, $ON, $HIGH, $LOW, $EN, $HEB, $MAX, $MIN, $EXTREME, $SHOW, $EmailSubject;

    if (($param == "temp") && ($_GET['tempunit'] == 'F'))
        $extdata = number_format(($extdata - 32) * (5 / 9), 1, '.', '');
    if ($month == 0 || $year == 0)
        return false;
    $boolbroken = true;

    if ($highorlow == "high") {
        $highorlowm = array($NEW[$EN] . " " . $MAX[$EN] . " " . $RECORD[$EN] , 
                            $RECORD[$HEB] . " " . $MAX[$HEB] . " " . $NEW[$HEB] );
        $prefEmailSubject = array($NEW[$EN] . " " . $MAX[$EN] . " " . $RECORD[$EN], 
                                   $RECORD[$HEB] . " " . $MAX[$HEB] . " " . $NEW[$HEB]);
    } else {
        $highorlowm = array($NEW[$EN] . " " . $MIN[$EN] . " " . $RECORD[$EN] ,  
                            $RECORD[$HEB] . " " . $MIN[$HEB] . " " . $NEW[$HEB] );
        $prefEmailSubject = array($NEW[$EN] . " " . $MIN[$EN] . " " . $RECORD[$EN], 
                                 $RECORD[$HEB] . " " . $MIN[$HEB] . " " . $NEW[$HEB]);
    }

    $shortYear = sprintf("%02d", $year - 2000);
    if ($period == "yearly")
        $periodm = $year;
    else
        $periodm = sprintf("%02d", $month) . "/{$year}";

    array_push($messageBroken, array($highorlowm[$EN]." ".$ON[$EN]." ".$periodm.": ". $extdata,
                                     $highorlowm[$HEB]." ".$ON[$HEB]." ".$periodm.": ". $extdata));

    $EmailSubject = array($prefEmailSubject[$EN] . " $ON[$EN] $periodm", $prefEmailSubject[$HEB] . " $ON[$HEB] $periodm");

    if ($error_db) {
        array_push($messageBroken, array("</span>", "</span>"));
        return false;
    }

    $record_col = "{$period}_{$highorlow}";
    $date_col = "{$record_col}_date";
	$row = $mem->get("extreme_".$param);
	if (!$row){
		$result = db_init("SELECT * FROM extremes where (param=?)", $param);
		$row = @mysqli_fetch_array($result["result"], MYSQLI_ASSOC);
		$mem->set("extreme_".$param, $row);
		global $link;
	}
    $old_date = $row["$date_col"];
    if ($old_date != $datenotime) //already updated --> take from old_record & old_date columns
        $updateMessage = true;
    if (!$updateMessage) {
        $record_col = "old_{$period}_{$highorlow}_record";
        $date_col = "old_{$period}_{$highorlow}_date";
    }
    $old_record = round($row["$record_col"], 1);
    $old_date = $row["$date_col"];
    /**
      at the first entry to the table the old record is moved to the old_record/old_time columns
     */
    if ($updateMessage) {
        $extdata = str_replace(",", "", $extdata);
		$new_extreme = array($record_col => $extdata, $date_col=>$datenotime, 'old_'.$highorlow => $old_date, 'old_'.$highorlow.'_record'=>$old_record);
        $mem->set("extreme_".$param, $new_extreme);
        $query = "UPDATE extremes SET $record_col='$extdata', $date_col='$datenotime', old_{$period}_{$highorlow}_date', old_{$period}_{$highorlow}_record=$old_record WHERE (param='$param')";
        db_init($query, "");
        logger(sprintf("updating in setBrokenData: %s ".$query, mysqli_error($link)), 0, "broken", "", "setBrokenData");
    }
    logger($LAST_RECORD[$EN].": ".$old_record." ".$ON[$EN]." ".$old_date, 0, "broken", "", "setBrokenData");
   // array_push($messageBroken, array($LAST_RECORD[$EN].": ".$old_record." ".$ON[$EN]." ".$old_date, $LAST_RECORD[$HEB].": ".$old_record." ".$ON[$HEB]." ".$old_date));
    if ($period != "yearly") {
        $yearly_record = round($row["yearly_{$highorlow}"], 1);
        $yearly_date = $row["yearly_{$highorlow}_date"];
        logger($RECORD[$EN]," ".$ON[$EN]." ".$year.": ".$yearly_record." ".$ON[$EN]." ".$yearly_date, 0, "broken", "", "setBrokenData");
       // array_push($messageBroken, array($RECORD[$EN]," ".$ON[$EN]." ".$year.": ".$yearly_record." ".$ON[$EN]." ".$yearly_date, $RECORD[$HEB]," ".$ON[$HEB]." ".$year.": ".$yearly_record." ".$ON[$HEB]." ".$yearly_date));
    }
    // array_push($messageBroken, array("\n<script type=\"text/javascript\">\nvar tdBroken = document.getElementById('brokenlatest" . $param . "');\ndivBroken = document.getElementById('broken" . $highorlow . $param . "');\ntdBroken.appendChild(divBroken);\n</script>", "\n<script type=\"text/javascript\">\nvar tdBroken = document.getElementById('brokenlatest" . $param . "');\ndivBroken = document.getElementById('broken" . $highorlow . $param . "');\ntdBroken.appendChild(divBroken);\n</script>"));

    //if (ShouldSendMsg($highorlow, $param, $period))
    //	echo "should SEND - ".$highorlow." ".$param." ".$period." !!!!!!!!!!!!!!!!!";
    //logger($highorlow." ".$param." ".$period);
    if ($updateMessage) // to send only once
        if (ShouldSendMsg($highorlow, $param, $period)) {
            array_push($messageBrokenToSend, $messageBroken);
            for ($i = 0; $i < count($messageBroken); $i++) {
                $brokendata .= $messageBroken[$i][$HEB];
            }
            logger("Prepered to be sent: " . $highorlow . " " . $param . " " . $period . " " . $brokendata, 0, "broken", "", "setBrokenData");
        }

    // Free resultset 
    @mysqli_free_result($result);
    @mysqli_close($link);
}

// end func
/******************
			determine if extreme should be sent
    ******************/
 function ShouldSendMsg($highorlow, $param, $period) {
    return false;
    global $month, $day, $messageBroken;
    //echo "<br>count($messageBroken) = ".count($messageBroken);
    // do not send yearly records in January
    if (($period == "yearly") && ($month == 1) && ($day < 10))
        return false;
    // do not send monthly records
    if ($period != "yearly")
        return false;
    // do not send monthly records at the first and the second
    if (($period != "yearly") && ($day < 3))
        return false;
    // do not send monthly pressure max/min - happens to often
    if (($period != "yearly") && ($param == "pressure") && (count($messageBroken) == 4))
        return false;

    return true;
}

function logger($msg, $severirty, $category, $layer, $function) {
    //echo "<br>in Logger<br>";
    global $link;
    $datafile = "log/log.txt";
   /* $msgFile = getLocalTime(time()) . " " . $msg;
    $file = @fopen($datafile, "a+");
    @fwrite($file, $msgFile . " \n");
    @fclose($file);*/
    $msg = str_replace("'", "\"", $msg);
    $link = new mysqli(MYSQL_IP, MYSQL_USER, MYSQL_PASS, MYSQL_DB);
    $query = "call writeToLog ('$msg', $severirty, '$category', '$layer', '$function')";
    $result = mysqli_query($link, $query);
    if (!$result) {
        $file = @fopen($datafile, "a+");
        $msg = getLocalTime(time()) . " " .$query." ". mysqli_error($link);
        @fwrite($file, $msg . " \n");
        @fclose($file);
    }
    @mysqli_close($link);
}

function canUpdateExtreme() {
    global $min30;
    if ($highorlow == "high") {
        if ($param == "temp") {
            if ($min30->get_tempchange() < -0.2)
                return true;
            if ($today->get_hightemp() < $current->get_temp())
                return true;
        }
        if ($param == "humidity") {
            if ($min30->get_humchange() < -2)
                return true;
            if ($today->get_highhum() < $current->get_hum())
                return true;
        }
        if ($param == "wind") {
            if (($min30->get_windspdchange() < -2))
                return true;
            if ($today->get_highwind() < $current->get_windspd())
                return true;
        }
    }
    else if (($highorlow == "low")) {
        if ($param == "temp") {
            if ($min30->get_tempchange() > 0.2)
                return true;
            if ($today->get_hightemp() > $current->get_temp())
                return true;
        }
        if ($param == "humidity") {
            if ($min30->get_humchange() > 2)
                return true;
        }
    }
    return false;
}

function toLeft($input) {
    // lrm left-to-right mark
    //&lrm;
    //$ptag = "<div style=\"direction: ltr;\">\${1}</div>";
    //$tofind = "{^-[0-9]+$}";
    //return preg_replace($tofind, $ptag, $input);
    return $input;
    return "<span style=\"direction: ltr;\">$input</span>";
}

function isOpenOrClose ()
{
	
    global $lang_idx, $current, $OPEN, $CLOSE, $PIVOT_TEMP;
    if (($current->get_rainchance()>0)||($current->get_pm10() > 100)||($current->get_temp()>29)||($current->get_temp()<22))
        return $CLOSE[$lang_idx];
	if ($current->get_intemp() > $current->get_temp())
	{
		if ($current->get_intemp() > $PIVOT_TEMP)
			return $OPEN[$lang_idx];
		else return $CLOSE[$lang_idx];
	}
	else
	{
		if ($current->get_intemp() > $PIVOT_TEMP)
			return $CLOSE[$lang_idx];
		else return $OPEN[$lang_idx];
	}
	
	
}

function getMonthName ($month)
{
	global $lang_idx;
	
	if ($month == 1)
		$monthName = array("Jan", "ינואר");
	else if ($month == 2)
		$monthName = array("Feb", "פברואר");
	else if ($month == 3)
		$monthName = array("March", "מרץ");
	else if ($month == 4)
		$monthName = array("April", "אפריל");
	else if ($month == 5)
		$monthName = array("May", "מאי");
	else if ($month == 6)
		$monthName = array("June", "יוני");
	else if ($month == 7)
		$monthName = array("July", "יולי");
	else if ($month == 8)
		$monthName = array("Aug", "אוגוסט");
	else if ($month == 9)
		$monthName = array("Sep", "ספטמבר");
	else if ($month == 10)
		$monthName = array("Oct", "אוקטובר");
	else if ($month == 11)
		$monthName = array("Nov", "נובמבר");
	else if ($month == 12)
		$monthName = array("Dec", "דצמבר");
	else 
		return null;
	return $monthName[$lang_idx];
		
}
function getUpdatedPic()
{
	$primary_pic = $_SERVER['DOCUMENT_ROOT']."/images/webCameraB.jpg";
	$secondary_image = $_SERVER['DOCUMENT_ROOT']."/images/webCamera.jpg";

	if ((@filemtime($primary_pic) < @filemtime($secondary_image) - 900) || (!file_exists($primary_pic)))
		return $secondary_image;
	return $primary_pic;
	
}
function post_to_bufferApp($messageBody, $picture_url)
{
    require_once 'class.bufferapp.php';
    $buffer = new BufferPHP('2/b4ca20cdc59c36d91b095b2e10c7b29728dbf6788bb3b1168a48229be41251bdb2542a46a602670359dcff2efe7cdaf7fd8f8b0cfd4771cbff5451ce4464ca9d');//access token

    $data = array('profile_ids' => array());
    $data['profile_ids'][] = '529d7e1211243a4360000082'; //twitter profile ID
    $data['profile_ids'][] = '53ce668a03b018e36febc9c7'; //fb profile ID
    $data['profile_ids'][] = '58e1f9c3d05bd396024fb22c'; //Instagram profile ID
    if (empty($picture_url)){
        $picture_url = 'https://www.02ws.co.il/images/webCameraB.jpg';
        $picture_url = 'https://www.02ws.co.il/02ws_short.png';
    }
    else
        $data['profile_ids'][] = '58e1f9c3d05bd396024fb22c'; //IG profile ID
    $data['text'] = $messageBody." ";
    //echo "<br />picture_url=".$picture_url;
    //$data['media'] = array('link' => 'https://www.02ws.co.il/02ws_short.png');
    $data['media'] = array('photo' => $picture_url, 'picture' => $picture_url, 'thumbnail' => $picture_url);
    $data['client_id']='53f8f11aa9dc830067715093';
    $data['client_secret']= '228199ac982c39a26378a58a998d2f08';
    $data['redirect_uri']= "https://www.02ws.co.il";

    //if you want to share this immediately set this to true else set it to false if you wish to schedule it for sharing later
    $data['now']=true;
    //$ret = new stdClass();
    //var_dump($data);
    $ret = $buffer->post('updates/create', $data);
    //var_dump($ret);
    
     logger("bufferApp: ".$ret->message, 0, "buffer", "", "post_to_bufferApp");
    return $ret->message;
}
$errorMessage = array();
$remove_ids = array();
function handleInvalidTokens($jsonArray, $registration_ids, $header_key){
    global  $errorMessage, $remove_ids;
    
    //logger("handleInvalidTokens: header_key(SenderID)=".$header_key." success:".$jsonArray["success"]." + failure:".$jsonArray["failure"]." = ".count($jsonArray["results"]));
    $errors = 0; 
    for($i=0; $i<count($jsonArray["results"]);$i++){
        
        if(isset($jsonArray["results"][$i]["error"])){
            if($jsonArray["results"][$i]["error"] == "NotRegistered"){
                $remove_ids[$i] = $registration_ids[$i];
            }else{
                $errorMessage[$i] = array('id' => $registration_ids[$i], 'desc' => $jsonArray["results"][$i]["error"], 'idx' => $i);
            }
            $errors++;
        }
    }
    
    logger("handleInvalidTokens errors: ". $errors, 0, "handleInvalidTokens", "", "handleInvalidTokens");
    saveInvalidTokens();
}
function saveInvalidTokens() {
    global $link, $errorMessage, $remove_ids;
    logger("saveInvalidTokens errors: ". count($remove_ids), 0, "saveInvalidTokens", "", "saveInvalidTokens");
    db_init("", "");
    foreach ($remove_ids as $id){
         //print_r($regIDs);
         //$query = "update fcm_users set ResponseCode='9', ResponseMessage='NotRegistered' where gcm_regid='".$id."'";
         $query = "insert into InvalidTokens (regid, status, updated) values('".$id."', 9, SYSDATE())";
         $resultUpdate = mysqli_query($link, $query);
         //logger($query." ".$resultUpdate, 0, "saveInvalidTokens", "", "saveInvalidTokensQuery");
     }
     foreach ($errorMessage as $err){
         //print_r($regIDs);
         $query = "update fcm_users set ResponseCode='5', ResponseMessage='".$err['desc']."' where gcm_regid='".$err['id']."'";
         $resultUpdate = mysqli_query($link, $query);
         $query = "update apn_users set ResponseCode='5', ResponseMessage='".$err['desc']."' where apn_regid='".$err['id']."'";
         $resultUpdate = mysqli_query($link, $query);
         $query = "insert into InvalidTokens (regid, status, updated) values('".$err['id']."', 5, SYSDATE())";
         $resultUpdate = mysqli_query($link, $query);
        //logger($err['id']." ".$err['desc'], 4, "saveInvalidTokens", "", "saveInvalidTokensQuery");
     }
}
function getMsgAlert($picture_url, $message, $title) {
    $class_alerttxt = "";
    if (empty($picture_url))
        $img_tag = "";
    else{
        if((strtolower(end(explode(".",$picture_url))) =="mp4")||(($_POST["video"]=="true")))
        {
            $img_tag = "<video width=\"310\" height=\"240\" controls><source src=\"".$picture_url."\" type=\"video/mp4\"></video>";
        }   
        else{
            $img_tag = "<div id=\"alertbg\" style=\"background-image: url(phpThumb.php?src=".$picture_url."&w=400)\"></div>";
            $img_tag = "<div id=\"alertbg\" style=\"background-image: url(".$picture_url.")\"></div>";
            $class_alerttxt = " class=\"txtindiv\"";
            $class_alerttitle = " txtindiv";
            $img_tag = "<img id=\"alertimg\" src=\"".$picture_url."\" width=\"310\"><br/>";
        }
        
    }
    
    $msgformat = "<div id=\"alerttxt\" ".$class_alerttxt.">%s</div>".$img_tag;
    $msgformatNoImg = "<div id=\"alerttxt\" ".$class_alerttxt.">%s</div>";

    $msgformat = $img_tag.$message;
    $msgformatNoImg = $message;
    if (!sprintf($msgformat, $message))
        $msgToAlertSection = printf($msgformatNoImg, $message);
    else
        $msgToAlertSection = sprintf($msgformat, $message);
    if (strlen($title) > 0){
        //$msgformat = "<div class=\"title".$class_alerttitle."\">%s</div> %s";
        // no title is put
        //$msgToAlertSection = sprintf ($msgformat, "", $msgToAlertSection);
        $msgToAlertSection = $msgformat;
        
    }
    return  $msgToAlertSection;
}
function updateMessageFromMessages ($description, $active, $type, $lang, $href, $img_src, $title, $addon, $class, $messageType, $ttl)
{
    global $mem, $ALERTS_PAYMENT, $PATREON_LINK, $RU, $FR;
    if (empty($ttl))
    {
        $ttl = 360;
    }
    $messageType = "long_range";
    if ($_POST["short_range"]=="true"){
        $messageType = "short_range";
    }
    else if ($_POST["tip"]=="true"){
        $messageType = "tip";
    }
    try
    {
        global $lang_idx;
        $lang_idx = $lang;
        //$description = nl2br($description);
        $description = trim($description);
        $img_src = trim(strip_tags($img_src));
        
        $description = getMsgAlert($img_src, $description, $title);
        //$description = str_replace("'", "`", $description);
        //$description = str_replace("\"", "''", $description);
        $now = replaceDays(date('D H:i'));
        $append = true;
        $res = db_init("SELECT * FROM  `content_sections` WHERE (TYPE =  'forecast') and (lang=?)", $lang);
        while ($line = mysqli_fetch_array($res["result"], MYSQLI_ASSOC) ){
            $descriptionforecast = $line["Description"];
            $descriptionforecast_title = $line["Title"];
        }
        $res = db_init("SELECT * FROM  `content_sections` WHERE (TYPE =  'LAlert') and (lang=?)", $lang);
        while ($line = mysqli_fetch_array($res["result"], MYSQLI_ASSOC) ){
            $latestalert = $line["Description"];
            $latestalert_title = $line["Title"];
            $latestalert_time = replaceDays(date('D H:i', $mem->get('latestalerttime'.$lang)));
        }
        $description_appended = $latestalert_time."\n".trim($latestalert)."\n\n".$descriptionforecast_title."\n".trim($descriptionforecast);
        //$description = "<div class=\"alerttime ".$class."\">".$now."</div>".$description;
        if (!empty($description))
            $description = $description."\n";
        //$now = getLocalTime(time());
 
        $query = "UPDATE `content_sections` SET Description='{$description}', active={$active}, href='{$href}', img_src='{$img_src}', Title='{$title}'  WHERE (type='$type') and (lang=$lang)";
        $res = db_init($query, "" );
        if ($type == 'LAlert'){
            $mem->set('descriptionforecast'.$lang, $description_appended);
            $mem->set('descriptionforecast_title'.$lang, $latestalert_title);
            $mem->set('latestalert'.$lang, $description);
            $mem->set('latestalert_title'.$lang, $title);
            $mem->set('latestalert_img', $img_src);
            $mem->set('addonalert'.$lang, $addon);
            $mem->set('latestalerttime'.$lang, time());
            $mem->set('latestalertttl', $ttl*60);
            $mem->set('latestalerttype', $messageType);
            $query = "UPDATE `content_sections` SET Description='{$description_appended}', active={$active}, href='{$href}', img_src='{$img_src}', Title='{$latestalert_title}'  WHERE (type='forecast') and (lang=$lang)";
            $res = db_init($query, "" );
            logger($query, 0, "Push", "updateMessageFromMessages", "updateMessageFromMessages");
        }
        else if ($type == 'forecast'){
            $mem->set('descriptionforecast'.$lang, $description);
            $mem->set('descriptionforecasttime'.$lang, time());
            $mem->set('descriptionforecast_title'.$lang, $title);
            echo "descriptionforecast".$lang."=".date('Y-m-d G:i D', $mem->get('descriptionforecasttime'.$lang));
            logger($description, 0, "descriptionforecast", "updateMessageFromMessages", "updateMessageFromMessages");
        }
       /* if ($lang == 0)
        {
            $mem->set('latestalert'.$RU, translateText(urlencode($description), 'ru'));
            $mem->set('latestalert_title'.$RU, translateText(urlencode($title), 'ru'));
            $mem->set('latestalert'.$FR, translateText(urlencode($description), 'fr'));
            $mem->set('latestalert_title'.$FR, translateText(urlencode($title), 'fr'));
            $mem->set('descriptionforecast'.$RU, translateText(urlencode($description_appended), 'ru'));
            $mem->set('descriptionforecast_title'.$RU, translateText(urlencode($latestalert_title), 'ru'));
            $mem->set('descriptionforecast'.$FR, translateText(urlencode($description_appended), 'fr'));
            $mem->set('descriptionforecast_title'.$FR, translateText(urlencode($latestalert_title), 'fr'));
        }*/
        
        if (!empty(trim($description))&&($type=='LAlert')){
            $query = "INSERT INTO  `AlertsArchive` (Description, active, href,  img_src, Title, updatedTime, lang) Values('{$description}', '$active', '$href', '$img_src', '{$title}', SYSDATE(),  $lang)";
            $res = db_init($query, "" );
            logger($query, 0, "Push", "AlertsArchive", "updateMessageFromMessages");
        }
       
        // Free resultset 
        @mysqli_free_result($res);
    }
    catch (Exception $ex) {
        $result .= " exception:".$ex->getMessage();
    }   
	
}
function callAPNSender($key, $registrationIDs, $messageBody, $title, $picture_url, $embedded_url){
     
       // Set POST variables
    $url = 'https://fcm.googleapis.com/fcm/send';

    $fields = array(
        'registration_ids' => $registrationIDs,
        'notification' => array( "message" => $messageBody, "title" => $title, "picture_url" => $picture_url, "embedded_url" => $embedded_url),
        'priority' => 'high'
    );
        
    $headers = array(
        'Authorization: key=' . $key, 
        'Content-Type: application/json'
    );

    // Open connection
    $ch = curl_init();
    //print_r($headers);
    //print_r($registrationIDs);
    // Set the URL, number of POST vars, POST data
    curl_setopt( $ch, CURLOPT_URL, $url);
    curl_setopt( $ch, CURLOPT_POST, true);
    curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( $fields));

    // Execute post
    $result = curl_exec($ch);
    $resultHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    logger("sendFCMMessage res: ".$result, 0, "APN", "", "callAPNSender");
    // Close connection
    curl_close($ch);
    
    switch ($resultHttpCode) {
            case "200":
                //All fine. Continue response processing.
                break;

            case "400":
                logger("curl_getinfo GCM: ".$resultHttpCode." ".$result, 0, "APN", "", "callAPNSender");
                break;

            case "401":
                logger("curl_getinfo GCM: ".$resultHttpCode." ".$result, 0, "APN", "", "callAPNSender");
                break;

            default:
                //TODO: Retry-after
                logger("curl_getinfo GCM: ".$resultHttpCode." ".$result, 0, "APN", "", "callAPNSender");
                break;
        }
    return array($resultHttpCode, json_decode($result, true));
}
function callGCMSender($key, $registrationIDs, $messageBody, $title, $picture_url, $embedded_url){
     
    //logger("callGCMSender: header_key(SenderID)=".$key."  count=".count($registrationIDs)." ".$messageBody." ".$title." ".$picture_url." ".$embedded_url);
    // Set POST variables
    $url = 'https://fcm.googleapis.com/fcm/send';

    $fields = array(
        'priority' => 10,
        'apns' => array( "headers" => array( "apns-priority" => "5")),
        'android' => array("priority" => "high" ),
        'aps' => array("sound" => "default" ),
        'registration_ids' => $registrationIDs,
        'notification' => array( "body" => $messageBody, "title" => $title, "picture_url" => $picture_url, "embedded_url" => $embedded_url, "sound" => "default", "channelId"=>"default"),
        'data' => array( "body" => $messageBody, "title" => $title, "embedded_url" => $embedded_url, "sound" => "default", "channelId"=>"default"),
    );
        
    $headers = array(
        'Authorization: key=' . $key, 
        'Content-Type: application/json'
    );

    // Open connection
    $ch = curl_init();
    //print_r($headers);
    //print_r($registrationIDs);
    // Set the URL, number of POST vars, POST data
    curl_setopt( $ch, CURLOPT_URL, $url);
    curl_setopt( $ch, CURLOPT_POST, true);
    curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( $fields));

    // Execute post
    $result = curl_exec($ch);
    $resultHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    //logger("sendGCMMessage: ".$result);
    // Close connection
    curl_close($ch);
    
    switch ($resultHttpCode) {
            case "200":
                //All fine. Continue response processing.
                break;

            case "400":
                logger("curl_getinfo GCM: ".$resultHttpCode." ".$result, 0, "FCM", "", "callGCMSender");
                break;

            case "401":
                logger("curl_getinfo GCM: ".$resultHttpCode." ".$result, 0, "FCM", "", "callGCMSender");
                break;

            default:
                //TODO: Retry-after
                logger("curl_getinfo GCM: ".$resultHttpCode." ".$result, 0, "FCM", "", "callGCMSender");
                break;
        }
    return array($resultHttpCode, json_decode($result, true));
}

function callCustomAlertSender($messageBody, $title, $picture_url, $embedded_url, $customAlert){

    ////////////////////// Android //////////////////////////////////////
    $registrationIDs0 = array();$registrationIDs1 = array();$lines = 0;
    $query_extension = "";
    if (($customAlert == CustomAlert::Dust)||($customAlert == CustomAlert::HighDust)){
        $query = "select lang, gcm_regid  FROM fcm_users where active_dust=1 UNION select lang, apn_regid gcm_regid FROM apn_users where active_dust=1".$query_extension;
        
    }
    else if (($customAlert == CustomAlert::HighET)||($customAlert == CustomAlert::Dry)){
        $query = "select lang, gcm_regid  FROM fcm_users where active_dry=1 UNION select lang, apn_regid gcm_regid FROM apn_users where active_dry=1".$query_extension;
    }
    else if (($customAlert == CustomAlert::HighUV)||($customAlert == CustomAlert::ExtremeUV)){
        $query = "select lang, gcm_regid  FROM fcm_users where active_uv=1 UNION select lang, apn_regid gcm_regid FROM apn_users where active_uv=1".$query_extension;
    }
    else if (($customAlert == CustomAlert::LowRadiation)||($customAlert == CustomAlert::HotGround)){
        $query = "select lang, gcm_regid  FROM fcm_users where active_tips=1 UNION select lang, apn_regid gcm_regid FROM apn_users where active_tips=1".$query_extension;
    }
      
    $result = db_init($query, "");
    while ($line = mysqli_fetch_array($result["result"], MYSQLI_ASSOC)) {
	$lines++;
        //echo "<br />".$line["gcm_regid"]."<br />";
        if ($line["lang"] == 0)
            array_push ($registrationIDs0, $line["gcm_regid"]);
        elseif ($line["lang"] == 1)
            array_push ($registrationIDs1, $line["gcm_regid"]);
    }
    $result = "";
     $resultCall = array();
     $arrOfRegID0 = array_chunk($registrationIDs0, 1000);
     foreach ($arrOfRegID0 as $regIDs){
        $resultCall = callGCMSender (FCM_API_KEY, $regIDs, $messageBody[0], $title[0], $picture_url, $embedded_url);
        //handleInvalidTokens($resultCall[1], $regIDs, FCM_API_KEY);
      }
    
     $arrOfRegID1 = array_chunk($registrationIDs1, 1000);
     foreach ($arrOfRegID1 as $regIDs){
        $resultCall = callGCMSender (FCM_API_KEY, $regIDs, $messageBody[1], $title[1], $picture_url, $embedded_url);
        //handleInvalidTokens($resultCall[1], $regIDs, FCM_API_KEY);
     }
     logger($query." number of lines:".$lines." count:".count($arrOfRegID1)." "." Completed", 0, "FCM", "", "callCustomAlertSender"); 
     return $result;

}
function callTopicFirebaseSender($topic, $messageBody, $title, $picture_url, $embedded_url){
     
    //logger("callGCMSender: header_key(SenderID)=".$key."  count=".count($registrationIDs)." ".$messageBody." ".$title." ".$picture_url." ".$embedded_url);
    // Set POST variables
    $url = 'https://fcm.googleapis.com/fcm/send';

    $fields = array(
        'to'  => '/topics/'.$topic,
        'notification' => array( "message" => $messageBody, "title" => $title, "picture_url" => $picture_url, "embedded_url" => $embedded_url),
    );
        
    $headers = array(
        'Authorization: key=' . FCM_API_KEY, 
        'Content-Type: application/json'
    );

    // Open connection
    $ch = curl_init();
    //print_r($headers);
    //print_r($registrationIDs);
    // Set the URL, number of POST vars, POST data
    curl_setopt( $ch, CURLOPT_URL, $url);
    curl_setopt( $ch, CURLOPT_POST, true);
    curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( $fields));

    // Execute post
    $result = curl_exec($ch);
    $resultHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    //logger("sendGCMMessage: ".$result);
    // Close connection
    curl_close($ch);
    
    switch ($resultHttpCode) {
            case "200":
                //All fine. Continue response processing.
                break;

            case "400":
                logger("curl_getinfo GCM: ".$resultHttpCode." ".$result, 0, "FCM", "", "callTopicFirebaseSender");
                break;

            case "401":
                logger("curl_getinfo GCM: ".$resultHttpCode." ".$result, 0, "FCM", "", "callTopicFirebaseSender");
                break;

            default:
                //TODO: Retry-after
                logger("curl_getinfo GCM: ".$resultHttpCode." ".$result, 0, "FCM", "", "callTopicFirebaseSender");
                break;
        }
    return array($resultHttpCode, json_decode($result, true));
}

///////////////////////////////////////////////////////
// xml parser
///////////////////////////////////////////////////////
function getXMLInArray($xmlpath){

	global $ary_parsed_file;
	// what are we parsing?    
	$xml_file = $xmlpath;        
	// declare the character set - UTF-8 is the default    
	$type = 'UTF-8';            
	// create our parser    
	$xml_parser = xml_parser_create($type);   
	// set some parser options    
	xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, true);    
	xml_parser_set_option($xml_parser, XML_OPTION_TARGET_ENCODING, 'UTF-8');    
	// this tells PHP what functions to call when it finds an element    
	// these functions also handle the element's attributes    
	xml_set_element_handler($xml_parser, 'startElement','endElement');    
	// this tells PHP what function to use on the character data    
	xml_set_character_data_handler($xml_parser, 'characterData');        
	if (!($fp = @fopen($xml_file, 'r'))) {       
		//echo("Could not open $xml_file for parsing!\n");    
		return false;
	}    
	// loop through the file and parse baby!    
	while ($data = fread($fp, 4096)) {       
		if (!($data = utf8_encode($data))) {           
			logger('ERROR in getXMLInArray'."\n", 4, "XML", "", "getXMLInArray");      
		}       
		if (!xml_parse($xml_parser, $data, feof($fp))) {           
		logger(sprintf( "XML error: %s at line %d\n\n",           
		xml_error_string(xml_get_error_code($xml_parser)),           
		xml_get_current_line_number($xml_parser)), 4, "XML", "", "getXMLInArray");       
		}    
		}    
	// Display the array    
	//print_r($ary_parsed_file);        
	xml_parser_free($xml_parser);
    return $ary_parsed_file;
}

function implode_r ($glue, $pieces){
 $out = "";
 foreach ($pieces as $piece)
  if (is_array ($piece)) $out .= implode_r ($glue, $piece); // recurse
  else                  $out .= $glue.$piece;
 
 return $out;
 }

 function utf8_strrev($str){
   preg_match_all('/./us', $str, $ar);
   return join('',array_reverse($ar[0]));
}

// only > 5.1
function ftp_get_contents($ftp_stream, $remote_file, $mode, $resume_pos=null){
   $pipes=stream_socket_pair(STREAM_PF_UNIX, STREAM_SOCK_STREAM, STREAM_IPPROTO_IP);
   if($pipes===false) return false;
   if(!stream_set_blocking($pipes[1], 0)){
       fclose($pipes[0]); fclose($pipes[1]);
       return false;
   }
   $fail=false;
   $data='';
   if(is_null($resume_pos)){
       $ret=ftp_nb_fget($ftp_stream, $pipes[0], $remote_file, $mode);
   } else {
       $ret=ftp_nb_fget($ftp_stream, $pipes[0], $remote_file, $mode, $resume_pos);
   }
   while($ret==FTP_MOREDATA){
       while(!$fail && !feof($pipes[1])){
           $r=fread($pipes[1], 8192);
           if($r==='') break;
           if($r===false){ $fail=true; break; }
           $data.=$r;
       }
       $ret=ftp_nb_continue($ftp_stream);
   }
   while(!$fail && !feof($pipes[1])){
       $r=fread($pipes[1], 8192);
       if($r==='') break;
       if($r===false){ $fail=true; break; }
       $data.=$r;
   }
   fclose($pipes[0]); fclose($pipes[1]);
   if($fail || $ret!=FTP_FINISHED) return false;
   return $data;
}
function getSunriseSunset($date){
    $curl = curl_init();
    
    $fulldate = date("Y-m-d");
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.met.no/weatherapi/sunrise/2.0/.json?lat=31.8&lon=35.2&offset=0".GMT_TZ.":00&days=7&date=".$fulldate,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "accept-encoding: application/gzip",
            "content-type: application/x-www-form-urlencoded"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);
    //echo $response;
    curl_close($curl);

    if ($err) {
        return "cURL Error #:" . $err;
    } else {
        $result = json_decode($response);
        //var_dump($result_tr);
        return $result;
    }
}
function get_arrow(){
	if (isHeb())
		return "<span class=\"big\">&nbsp;&#8250;&#8250;</span>"; //"&#9668;";
	else
		return "<span class=\"big\">&nbsp;&#8250;&#8250;</span>"; //"&#9658;";
}
function get_name ($field_name)
{
	global $lang_idx, $VVHOT, $LHOT, $LCOLD, $VVCOLD, $VHOT, $HOT, $COLDISH, $NHOTNCOLD, $COLD, $VCOLD, $SPRING, $SUMMER, $AUTOMN, $WINTER, $HOTORCOLD_Q, $FSEASON;
	if ($field_name == "VHot")
		return $VHOT[$lang_idx];
	else if ($field_name == "VVHot")
		return $VVHOT[$lang_idx];
	else if ($field_name == "LHot")
		return $LHOT[$lang_idx];
	else if ($field_name == "LCold")
		return $LCOLD[$lang_idx];
	else if ($field_name == "VVCold")
		return $VVCOLD[$lang_idx];
	else if ($field_name == "Hot")
		return $HOT[$lang_idx];
	else if ($field_name == "Average")
		return $NHOTNCOLD[$lang_idx];
        else if ($field_name == "Cool")
		return $COLDISH[$lang_idx];
	else if ($field_name == "Cold")
		return $COLD[$lang_idx];
	else if ($field_name == "VCold")
		return $VCOLD[$lang_idx];
	else if ($field_name == "Spring")
		return $SPRING[$lang_idx];
	else if ($field_name == "Summer")
		return $SUMMER[$lang_idx];
	else if ($field_name == "Fall")
		return $AUTOMN[$lang_idx];
	else if ($field_name == "Winter")
		return $WINTER[$lang_idx];
	else if ($field_name == "favorite season")
		return $FSEASON[$lang_idx];
	else if ($field_name == "HotOrCold")
		return $HOTORCOLD_Q[$lang_idx];
}

function getClothName($current_feeling, $cloth_type){
    global $current, $lang_idx, $VVHOT, $LHOT, $LCOLD, $VVCOLD, $VHOT, $COLDISH, $HOT, $NHOTNCOLD, $COLD, $VCOLD, $SPRING, $SUMMER, $AUTOMN, $WINTER, $HOTORCOLD_Q, $FSEASON;
    $cloth_name = "";
    //logger("getClothName:". $cloth_type);
    $cloth_name_e = ($cloth_type == "e") ? "_e" : "";
    if ($current_feeling == $VVHOT[$lang_idx])
    {$cloth_name = "singlet".$cloth_name_e.".svg";}
    else if ($current_feeling == $VHOT[$lang_idx])
    {$cloth_name = "singlet".$cloth_name_e.".svg";}
    else if ($current_feeling == $HOT[$lang_idx])
    {$cloth_name = "shorts_n4".$cloth_name_e.".svg";}
    else if ($current_feeling == $LHOT[$lang_idx])
    {$cloth_name = "tshirt_n4".$cloth_name_e.".svg";}
    else if ($current_feeling == $NHOTNCOLD[$lang_idx])
    {$cloth_name = "longsleeves_n4".$cloth_name_e.".svg";}
    else if ($current_feeling == $COLDISH[$lang_idx])
    {$cloth_name = "jacketlight_n4".$cloth_name_e.".svg";}
    else if ($current_feeling == $LCOLD[$lang_idx])
    {$cloth_name = "jacket_n4".$cloth_name_e.".svg";}
    else if ($current_feeling == $COLD[$lang_idx])
    {$cloth_name = "coat_n4".$cloth_name_e.".svg";}
    else if ($current_feeling == $VCOLD[$lang_idx])
    {$cloth_name = "gloves".$cloth_name_e.".svg";}
    else if ($current_feeling == $VVCOLD[$lang_idx])
    {$cloth_name = "cold".$cloth_name_e.".svg";}
    if ($current != null)
    if (isRaining())
        $cloth_name = "coatrain_n4.svg";
    return $cloth_name;
}
function getPageTitle()
{
	global $lang_idx, $HEB, $EN, $WEBSITE_TITLE;
	include $_SERVER['DOCUMENT_ROOT']."/lang.php";

	if (stristr($_GET['section'], 'globalwarm'))
		$title .= $GLOBAL_WARMING[$lang_idx]." - ";
	else if (stristr($_GET['section'], 'snow'))
		$title .= $SNOW[$lang_idx]." - ";
	else if (stristr($_GET['section'], 'yesterday'))
		$title .= $YESTERDAY[$lang_idx]." - ";
	else if (stristr($_GET['section'], 'animation'))
		$title .= $SATELLITE[$lang_idx]." - ";
	else if (stristr($_GET['section'], 'contact'))
		$title .= $CONTACT_INFO[$lang_idx]." - ";
	else if (stristr($_GET['section'], 'maps'))
		$title .= $LOCATION[$lang_idx]." - ";
	else if (stristr($_GET['section'], 'averages'))
		$title .= $AVERAGE[$lang_idx]." - ";
	else if (stristr($_GET['section'], 'records'))
		$title .= $RECORDS[$lang_idx]." - ";
	else if (stristr($_GET['section'], 'RainSeasons'))
		$title .= $RAIN_SEASONS[$lang_idx]." - ";
	else if (stristr($_GET['section'], 'whatsnew'))
		$title .= $WHATS_NEW[$lang_idx]." - ";
	else if (stristr($_GET['section'], 'SendEmail'))
		$title .= $CONTACT_ME[$lang_idx]." - ";
	else if (stristr($_GET['section'], 'webcam'))
		$title .= $LIVE_PICTURE[$lang_idx]." - ";
	else if (stristr($_GET['section'], 'Choose'))
		$title .= $CHOOSE[$lang_idx]." - ";
	else if (stristr($_GET['section'], 'getWeather'))
		$title .= $WEATHER_NEARBY[$lang_idx]." - ";
	else if ((stristr($_GET['section'], 'getForecast'))&&(@$_GET['region'] == 'isr'))
		$title .= $FORECAST_ISR[$lang_idx]." - ";
	else if (stristr($_GET['section'], 'getForecast'))
		$title .= $FORECAST_ABROD[$lang_idx]." - ";
	else if (strstr($_GET['graph'], 'Temp'))
		$title .= $TEMP[$lang_idx]." - ";
	else if (strstr($_GET['graph'], 'WindChill'))
		$title .= $WIND_CHILL[$lang_idx]." - ";
	else if (strstr($_GET['graph'], 'HeatIndex'))
		$title .= $HEAT_IDX[$lang_idx]." - ";
	else if (strstr($_GET['graph'], 'Dew'))
		$title .= $DEW[$lang_idx]." - ";
	else if (strstr($_GET['graph'], 'AirDensity'))
		$title .= $AIR_DENSITY[$lang_idx]." - ";
	else if (strstr($_GET['graph'], 'Hum'))
		$title .= $HUMIDITY[$lang_idx]." - ";
	else if (strstr($_GET['graph'], 'Bar'))
		$title .= $BAR[$lang_idx]." - ";
	else if ((strstr($_GET['graph'], 'Wind'))&&(!strstr($_GET['graph'], 'WindChill')))
		$title .= $WIND[$lang_idx]." - ";
	else if (strstr($_GET['graph'], 'RainRate'))
		$title .= $RAINRATE[$lang_idx]." - ";
	else if (strstr($_GET['graph'], 'Rain'))
		$title .= $RAIN[$lang_idx]." - ";
	else if (strstr($_GET['graph'], 'Rad'))
		$title .= $RADIATION[$lang_idx]." - ";
	else if (strstr($_GET['graph'], 'UV'))
		$title .= $UV[$lang_idx]." - ";
	else if (stristr($_GET['section'], 'browse'))
		$title .= $ARCHIVE[$lang_idx]." - ";
	else if (stristr($_GET['section'], 'dailypicloop'))
		$title .= $DAILY_LOOP[$lang_idx]." - ";
	else if (stristr($_GET['section'], 'downld'))
		$title .= $RECENT_DAYS[$lang_idx]." - ";
	else if (stristr($_GET['section'], 'dust'))
		$title .= $FORECAST_TITLE[$lang_idx]." ".$FOR[$lang_idx]." ".$DUST[$lang_idx]." - ";
	else if (stristr($_GET['section'], 'NOAAMO'))
		$title .= $SUMMARY[$lang_idx]." - ".$MONTHLY[$lang_idx]." - ";
	else if (stristr($_GET['section'], 'NOAAPRMO'))
		$title .= $SUMMARY[$lang_idx]." - ".$MONTHLY[$lang_idx]." - ";
	else if (stristr($_GET['section'], 'NOAAYR'))
		$title .= $SUMMARY[$lang_idx]." - ".$YEARLY[$lang_idx]." - ";
	else if (stristr($_GET['section'], 'NOAAPRYR'))
		$title .= $SUMMARY[$lang_idx]." - ".$YEARLY[$lang_idx]." - ";
	else if (stristr($_GET['section'], 'reports'))
		$title .= $REPORTS[$lang_idx]." - ";
	
	
	$title .= (($lang_idx == $HEB)?  $WEBSITE_TITLE[$HEB] : $WEBSITE_TITLE[$EN]);

	return $title;

}

function getClothTitle($imagename, $temp, $wind, $hum)
{
	global $lang_idx, $HEB, $EN, $OR, $SUN_SHADE_CLOTH, $SUN_SHADE_JACKET, $TSHIRT, $JACKET, $COAT, $RAINCOAT, $UMBRELLA, $SWEATER, $SWEATSHIRT, $SHORTS, $LONGSLEEVES, $LIGHTJACKET, $LIGHTCOAT,$LAYERS_BELOW, $LAYERS_BELOW2, $LAYERS_BELOW3, $LAYERS_BELOW3_PLUS, $current;
	
	if (stristr(strtolower($imagename), 'tshirt'))
		$title = $TSHIRT[$lang_idx];
	else if (stristr(strtolower($imagename), 'jacketlight'))
		$title = $LIGHTJACKET[$lang_idx]." ".$OR[$lang_idx]." ".$SWEATER[$lang_idx];
	else if (stristr(strtolower($imagename), 'jacket')){
		$title = $JACKET[$lang_idx];
                if ($temp < 13)
                    $title .= ", ".$LAYERS_BELOW2[$lang_idx];
                 else if ($temp < 20)
                    $title .= ", ".$LAYERS_BELOW[$lang_idx];
            if ($temp > 16)
            $title .= ", ".$SUN_SHADE_JACKET[$lang_idx];
        }
	else if (stristr(strtolower($imagename), 'coatlight'))
		$title = $LIGHTCOAT[$lang_idx];
	else if (stristr(strtolower($imagename), 'coatrain')){
		$title = $RAINCOAT[$lang_idx];
                 if ($temp < 5)
                    $title .= ", ".$LAYERS_BELOW3_PLUS[$lang_idx];
                else if((($temp < 10) && ($wind > 10)) || ($temp <= 8))
                    $title .= ", ".$LAYERS_BELOW3[$lang_idx];
                else if (($temp < 13) || ($wind > 10))
                    $title .= ", ".$LAYERS_BELOW2[$lang_idx];
                else
                    $title .= ", ".$LAYERS_BELOW[$lang_idx];
        }
	else if (stristr(strtolower($imagename), 'coat')){
        $title = $COAT[$lang_idx];
        
                 if ($temp < 5)
                    $title .= ", ".$LAYERS_BELOW3_PLUS[$lang_idx];
                else if ((($temp < 10) && ($wind > 10)) || ($temp <= 8))
                    $title .= ", ".$LAYERS_BELOW3[$lang_idx];
                else if (($temp < 13) || ($wind > 10))
                    $title .= ", ".$LAYERS_BELOW2[$lang_idx];
                else
                    $title .= ", ".$LAYERS_BELOW[$lang_idx];
                if ($temp > 16)
                    $title .= ", ".$SUN_SHADE_JACKET[$lang_idx];
        }        
	else if (stristr(strtolower($imagename), 'umbrella'))
		$title = $UMBRELLA[$lang_idx];
	else if (stristr(strtolower($imagename), 'sweater'))
		$title = $LIGHTJACKET[$lang_idx]." ".$OR[$lang_idx]." ".$SWEATER[$lang_idx];
	else if (stristr(strtolower($imagename), 'sweatshirt'))
		$title = $SWEATSHIRT[$lang_idx];
	else if (stristr(strtolower($imagename), 'shorts'))
		$title = $SHORTS[$lang_idx];
    else if (stristr(strtolower($imagename), 'singlet'))
		$title = $SHORTS[$lang_idx];
    else if (stristr(strtolower($imagename), 'gloves'))
		$title = $COAT[$lang_idx].", ".$LAYERS_BELOW3[$lang_idx];
    else if (stristr(strtolower($imagename), 'cold'))
		$title = $COAT[$lang_idx].", ".$LAYERS_BELOW3_PLUS[$lang_idx];
	else if (stristr(strtolower($imagename), 'longsleeves')){
        $title = $LONGSLEEVES[$lang_idx];
        if ($temp > 21)
            $title .= ", ".$SUN_SHADE_CLOTH[$lang_idx];
    }
		
       
	return $title;

}

function getCssIdx ($lang_idx){
    switch ($lang_idx)
    {
        case ($lang_idx == 1):
            return $lang_idx;
        default:
            return 0;
    }
    return $lang_idx;
}

function db_init($query, $param) {
    global $link, $stmt, $error_db;
    $result = array();
    $link = new mysqli(MYSQL_IP, MYSQL_USER, MYSQL_PASS, MYSQL_DB);
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        $error_db = true;
        exit();
    }
    //mysqli_query($link, "SET CHARACTER SET utf8;");
    $link->query("SET NAMES utf8;");

    if ($query != "") {

        $stmt = $link->stmt_init();
        if (!$stmt->prepare($query)) {
            logger("query=" . $query . " param=" . $param . "; error in prepare: " . $stmt->error, 4, "db", "", "db_init");
        }
        if ((!empty($param)) || (is_int($param)) || ($param === "0")) {
            $param = $link->real_escape_string($param);
			
            if (is_float($param))
                $res = $stmt->bind_param('d', $param);
            else if (is_numeric($param))
                $res = $stmt->bind_param('d', $param);
            else
                $res = $stmt->bind_param('s', $param);
            if (!$res)
                logger("query=" . $query . " param=" . $param . "; error in binding: " . $stmt->error, 4, "db", "", "db_init");
        }
        $res = $stmt->execute();
        if (!$res)
            logger("query=" . $query . " param=" . $param . "; error in execute: " . $stmt->error, 4, "db", "", "db_init");
        $result = $stmt->get_result();
        //logger("mysql Audit: query=" . $query . " param=" . $param , 0, "db", "", "db_init");
        return array("result" =>$result, "error" =>$stmt->error, "query" =>$query, "affectedrows" => $link->affected_rows);
    }
    return null;
}

function replaceDays($str) {
    global $lang_idx;
    if (isHeb()) {
        $str = str_replace("Sun ", " א ", $str);
        $str = str_replace("Mon ", " ב ", $str);
        $str = str_replace("Tue ", " ג ", $str);
        $str = str_replace("Wed ", " ד ", $str);
        $str = str_replace("Thu ", " ה ", $str);
        $str = str_replace("Fri ", " ו ", $str);
        $str = str_replace("Sat ", " ש ", $str);
    }
    return $str;
}

function ieversion() {
    $match = preg_match('/MSIE ([0-9]\.[0-9])/', $_SERVER['HTTP_USER_AGENT'], $reg);
    if ($match == 0)
        return -1;
    else
        return floatval($reg[1]);
}

function getSurvey($surveyid) {
    global $mem;
    $survey = $mem->get("survey".$surveyid);
    if (!$survey){
        $query = "SELECT sf.`field_id` , sf.`field_name` , s.name FROM surveyfields sf, survey s WHERE s.survey_id = sf.survey_id and s.survey_id=? order by field_id DESC";
        $result = db_init($query, $surveyid);
        $survey = Array();
        while ($line = mysqli_fetch_array($result["result"], MYSQLI_ASSOC)) {
            array_push($survey, array('field_id' => $line["field_id"], 'name' => $line["name"], 'field_name' => $line["field_name"]));
        }
        $mem->set("survey".$surveyid, $survey, 86400);
    }
    return $survey;
}

function getSpecificChat($idx) {
    global $lang_idx, $HEB, $link;

    $result = db_init("SELECT * From chat where idx=?", $idx);
    while ($line = mysqli_fetch_array($result["result"], MYSQLI_ASSOC)) {
        $lines++;
        $linesInColumn++;
        $col = 0;
        $timestamp_date = strtotime($line["date_chat"]);

        $totalText = $totalText + strlen($line["name"]) + strlen($line["body"]);
        $dateInLineStart = date("D   H:i", strtotime("0 hours -0 minutes", $timestamp_date));

        print "\n\t<div class=\"chatthreadcell white_box2" . $class . "\" style=\"margin:0.3em\" ";
        print ">";
        print "<div class=\"filter_icon" . $line["Category"] . "\"></div>"; // category icon
        print "<div class=\"pic_user\">";
        print "<h3>" . urldecode($line["name"]) . "</h3>";
        print "<h4>" . "</h4>";
        print "</div>"; // user
        print "\n\t\t<div class=\"chatmainbody\">\n\t\t\t" . urldecode($line["body"]) . "\n\t\t</div>";
        print "\n\t</div>\n";
    }


// Free resultset 
    @mysqli_free_result($result);
    @mysqli_close($link);
}

function getCurrentChat($searchname, $filter_is_on, $startLine, $limitLines, $timestamp_from, $timestamp_to, $category) {

    global $lang_idx, $HEB, $NEED_TO_REGISTER, $REPLY, $REPLY_EXP, $link, $REPLYES;

//echo "limitlines:".$limitLines;

    if ($searchname != "")
        $query = "SELECT * FROM  `chat` c WHERE  `name` LIKE  '%" . $searchname . "%' OR `body` LIKE  '%" . $searchname . "%' ";
    else
        $query = "SELECT * FROM  `chat` c ";
    if ($category == "null")
        $category = "";
    if ($category != "") {
        if ($searchname != "")
            $query .= " and ";
        else
            $query .= " where ";
        $query .= "  Category=" . $category . " ";
    }

    $query .= " ORDER BY sticky Desc, last_date_chat Desc";

    if ((!$filter_is_on) && ($startLine > 0)) {
        $query .= " LIMIT " . $startLine . " , " . $limitLines;
        echo ($startLine + 1) . " - " . ($startLine + $limitLines) . "<br />";
    }
    //echo $query ;
    $result = db_init($query, "");
//if ($_SESSION['loggedin'] == "true")
//	echo "<div class=\"indexlow\" style=\"width:100%;\"></div>";
    /* Printing results in HTML */
    while ($line = mysqli_fetch_array($result["result"], MYSQLI_ASSOC)) {
        $lines++;
        $linesInColumn++;
        $col = 0;
        $timestamp_date = strtotime($line["date_chat"]);

        if ($limitLines == -1 && (!$filter_is_on) ||
                $limitLines == "" && (!$filter_is_on) ||
                (($lines <= $limitLines) && (!$filter_is_on)) ||
                ($timestamp_date > $timestamp_from) && ($timestamp_date < $timestamp_to) && ($filter_is_on)) {
            $totalText = $totalText + strlen($line["name"]) + strlen($line["body"]);
            $dateInLineStart = date("D   H:i", strtotime("0 hours -0 minutes", $timestamp_date));
            if (time() - $timestamp_date > 550000)
                $dateInLineStart = date("D G:i j/m/y", strtotime("0 hours -0 minutes", $timestamp_date));
            if ($lang_idx == $HEB)
                $dateInLineStart = replaceDays($dateInLineStart);


            print "\n\t<div id=\"" . $line["idx"] . "\" class=\"white_box2\" style=\"text-align:" . get_s_align() . "\"";
            $name = urldecode($line["name"]);
            //$name = str_replace("<s", "", $name);
            $old_body = urlencode($line["body"]);
            print ">";
            print "<div class=\"filter_icon" . $line["Category"] . "\"></div>"; // category icon
            print "<div class=\"pic_user\">";
            print "<div class=\"avatar " . $line["user_icon"] . "\"></div>";
            print "<h3><div class=\"postusername\">" . $name . "</div><div class=\"datestart\">".$dateInLineStart."</div><div class=\"replyesnumber\">".$REPLYES[$lang_idx].": " . ($line["count"]-1) . "</div></h3>";
            print "</div>"; // user
            if ($_SESSION['loggedin'] == "false")
                $onclickmain = "onclick='alert(\"" . $NEED_TO_REGISTER[$lang_idx] . "\")'";
            else
                $onclickmain = "onclick='toggle(\"replydiv" . ($line["idx"]) . "\");$(\"#current_post_idx\").val(" . $line["idx"] . ");moveDivInOut($(this).parent().children(\x22.chatmainbody\x22).get(0));$(\"#subject_icon\").addClass($(\"#current_forum_filter\").val());initTinyMCE(" . $lang_idx . ")'";
            $fullbody = urldecode($line["body"]);
            if ($line["length"] > 3000){
                $nodes = explode (HIDDENSEPERATOR, $fullbody);
                $shortbody = $nodes[0]."...<a id=\"expandclick\" href=\"javascript:void(0)\" onclick=\"expand({$line["idx"]})\">המשך".get_arrow()."</a>";
                print "\n\t\t<div style=\"display:none\" class=\"alternatebody\" >" . $fullbody . " <a id=\"contractclick\" href=\"javascript:void(0)\" onclick=\"contract({$line["idx"]})\"\">סגור</a></div>";
                $fullbody = $shortbody;
            }
            print "\n\t\t<div class=\"chatmainbody\" >" . $fullbody . "</div>";
            print "\n\t\t<div class=\"chatdate\" >";

            if (($line["sticky"]) == 1)
                print "<br />" . "<img src=\"images/pin.png\" alt=\"sticky\" width=\"32\" height=\"32\" />";
            if (($line["Locked"]) == 1)
                print "<br />" . "<img src=\"images/locked.png\" alt=\"locked\" width=\"32\" height=\"32\" />";
            print "</div>";
            if (($line["Locked"]) <> 1)
                print "\n\t\t<div class=\"pivotpointer\" id=\"replydiv" . $line["idx"] . "\" title=\"" . $REPLY_EXP[$lang_idx] . "\" " . $onclickmain . "><input class=\"comment_btn\" type='button' value=\"" . $REPLY[$lang_idx] . "\" style=\"cursor:pointer;\" /></div>";
            print "\n\t</div>\n";
        }
    }

// Free resultset 
    @mysqli_free_result($result);
    @mysqli_close($link);
}
function getWindInfo($windspeed, $lang_idx){
    global $WEAK_WINDS, $MODERATE_WINDS, $STRONG_WINDS, $EXTREME_WINDS, $WEAK_WINDS_DESC, $MODERATE_WINDS_DESC, $STRONG_WINDS_DESC, $EXTREME_WINDS_DESC, $NO_WIND, $WINDY, $min10;
    if ($windspeed > 45){
               $windtitle=$EXTREME_WINDS[$lang_idx];
               $winddesc = $EXTREME_WINDS_DESC[$lang_idx];
               $wind_class="high_wind";
               $windimg = "wind2.svg";
      }

     else if ($windspeed > 30){
               $windtitle=$STRONG_WINDS[$lang_idx];
               $winddesc = $STRONG_WINDS_DESC[$lang_idx];
               $wind_class="high_wind";
               $windimg = "wind2.svg";
      }

     else if ($windspeed > 18){
               $windtitle=$MODERATE_WINDS[$lang_idx];
               $winddesc = $MODERATE_WINDS_DESC[$lang_idx];
               $wind_class="moderate_wind";
               $windimg = "wind1.svg";
      }

     else if (($windspeed > 0)||($min10->get_windspd() > 0)){
               $windtitle=$WEAK_WINDS[$lang_idx];
               $winddesc = $WEAK_WINDS_DESC[$lang_idx];
               $wind_class="light_wind";
               $windimg = "wind0.svg";
      } else 
      {
           $windtitle=$NO_WIND[$lang_idx];
           $winddesc = $NO_WIND[$lang_idx];
           $wind_class="no_wind";
           $windimg = "wind0.svg";
      }
      return array('windtitle' => $windtitle, 'wind_class' => $wind_class, 'wind_img' =>$windimg, 'winddesc' => $winddesc);
}
function getWindStatus($lang_idx) {
    global $current, $min10, $NO_WIND, $LIGHT_WIND, $MODERATE_WIND, $WINDY;
    $windInfo = getWindInfo($current->get_windspd(), $lang_idx);
    $div_wind_icon = "<a href=\"javascript:void()\" class=\"info\"><div title=\"" . $windInfo['windtitle'] . "\" class=\"wind_icon " . $windInfo['wind_class'] . " \"></div><span class=\"info\">".$windInfo['windtitle']."</span></a>";
    $div_wind_title = "<div class=\"wind_title\" >" . $windInfo['windtitle'] . "</div>";
    return $div_wind_icon;
}

function getNextMonth($month) {
    if ($month == 12)
        return 1;
    else
        return ($month + 1);
}

function getNextMonthYear($month, $year) {
    if ($month == 12)
        return ($year + 1);
    else
        return $year;
}

function getPrevMonth($month) {
    if ($month == 1)
        return 12;
    else
        return ($month - 1);
}

function getPrevMonthYear($month, $year) {
    if ($month == 1)
        return ($year - 1);
    else
        return $year;
}
function check_email_address($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        return false;
    else
        return true;
    
}
//
//         moon calculator
//
//Returns an array with all the phases of the moon for a whole year
function CalculateMoonPhases($Y) {
    //Converted from Basic by Roger W. Sinnot, Sky & Telescope, March 1985.
    //Converted from javascript by Are Pedersen 2002
    //Javascript found at http://www.stellafane.com/moon_phase/moon_phase.htm

    $R1 = 3.14159265 / 180;
    $U = false;
    $s = ""; // Formatted Output String
    $K0 = intval(($Y - 1900) * 12.3685);
    $T = ($Y - 1899.5) / 100;
    $T2 = $T * $T;
    $T3 = $T * $T * $T;
    $J0 = 2415020 + 29 * $K0;
    $F0 = 0.0001178 * $T2 - 0.000000155 * $T3;
    $F0 += (0.75933 + 0.53058868 * $K0);
    $F0 -= (0.000837 * $T + 0.000335 * $T2);
    //X In the Line Below, F is not yet initialized, and J is not used before it set in the FOR loop.
    //X J += intval(F); F -= INT(F);
    //X Ken Slater, 2002-Feb-19 on advice of Pete Moore of Houston, TX
    $M0 = $K0 * 0.08084821133;
    $M0 = 360 * ($M0 - intval($M0)) + 359.2242;
    $M0 -= 0.0000333 * $T2;
    $M0 -= 0.00000347 * $T3;
    $M1 = $K0 * 0.07171366128;
    $M1 = 360 * ($M1 - intval($M1)) + 306.0253;
    $M1 += 0.0107306 * $T2;
    $M1 += 0.00001236 * $T3;
    $B1 = $K0 * 0.08519585128;
    $B1 = 360 * ($B1 - intval($B1)) + 21.2964;
    $B1 -= 0.0016528 * $T2;
    $B1 -= 0.00000239 * $T3;
    for ($K9 = 0; $K9 <= 28; $K9 = $K9 + 0.5) {
        $J = $J0 + 14 * $K9;
        $F = $F0 + 0.765294 * $K9;
        $K = $K9 / 2;
        $M5 = ($M0 + $K * 29.10535608) * $R1;
        $M6 = ($M1 + $K * 385.81691806) * $R1;
        $B6 = ($B1 + $K * 390.67050646) * $R1;
        $F -= 0.4068 * sin($M6);
        $F += (0.1734 - 0.000393 * $T) * sin($M5);
        $F += 0.0161 * sin(2 * $M6);
        $F += 0.0104 * sin(2 * $B6);
        $F -= 0.0074 * sin($M5 - $M6);
        $F -= 0.0051 * sin($M5 + $M6);
        $F += 0.0021 * sin(2 * $M5);
        $F += 0.0010 * sin(2 * $B6 - $M6);
        $F += 0.5 / 1440; //Adds 1/2 minute for proper rounding to minutes per Sky & Tel article
        $J += intval($F);
        $F -= intval($F);
        //Convert from JD to Calendar Date
        $julian = $J + round($F);
        $s = jdtogregorian($julian);
        //half K
        if (($K9 - floor($K9)) > 0) {
            if (!$U) {
                //New half
                $phases[$s] = "ny2";
            } else {
                //Full half
                $phases[$s] = "ne2";
            }
        } else {
            //full K
            if (!$U) {
                $phases[$s] = "ny";
            } else {
                $phases[$s] = "ne";
            }
            $U = !$U;
        }
    } // Next
    return $phases;
}

//End MoonPhase

function GetMoonPhase($timestamp) {

    static $moon_phases;
    if (count($moon_phases) == 0)
        $moon_phases = CalculateMoonPhases(date("Y", $timestamp));
    $day = date("n/j/Y", $timestamp);
    return $moon_phases[$day];
}
function windSignificant($index)
{
     global $forecastHour;
     if ($index == 0)
        return true;
     if ($forecastHour[$index]['wind'] != $forecastHour[$index - 1]['wind'])
         return true;
     return false;
 }
 function shouldDisplayForecastHour($index_hr){
     global $forecastHour;
     if ($forecastHour[$index_hr-1]['plusminus'] != "")
        return true;
     
     if (($index_hr > 1)&&($index_hr < count($forecastHour)-1)){

        if (($forecastHour[$index_hr-2]['plusminus'] == 1)||
            ($forecastHour[$index_hr]['plusminus'] == 1)||
            ($forecastHour[$index_hr-3]['plusminus'] == 2)||
            ($forecastHour[$index_hr+1]['plusminus'] == 2))
            return false;
        
     }
     return ($forecastHour[$index_hr-1]['time'] % 3 == 0);
         
     
 }
 function weatherSignificant($index)
{
     global $forecastHour;
     if ($index == 0)
        return true;
     if ($forecastHour[$index]['priority'] != $forecastHour[$index - 1]['priority'])
         return true;
    if (($forecastHour[$index]['rain'] != $forecastHour[$index - 1]['rain']))
         return true;
     return false;
 }
function enoughSignificant($index)
 {
     global $forecastHour;
     if ($index == 0)
        return true;
     if (($forecastHour[$index]['title'] != $forecastHour[$index - 1]['title']))
         return true;
     if (($forecastHour[$index]['rain'] != $forecastHour[$index - 1]['rain']))
         return true;
     if (($forecastHour[$index]['title'] == $forecastHour[$index - 1]['title']) &&
          ($forecastHour[$index]['wind'] != $forecastHour[$index - 1]['wind']))
         return true;
     return false;
 }
 function get_laundry_index($lang_idx)
{   
    global $forecastHour, $nextSigForecast, $current, $GOOD_LAUNDRY, $SOSO_LAUNDRY, $BAD_LAUNDRY, $START_IN;
    if ((dustExistsNow())||(dustExistsIn24hf())||(rainExistsIn24hf())){
		return array("no_L", $BAD_LAUNDRY[$lang_idx], $nextSigForecast['hrs']) ;
	}
    else if (bestLaundryConditions())
        return array("good_L", $GOOD_LAUNDRY[$lang_idx], $nextSigForecast['hrs']);
    else
       return array("semiLgrey", $SOSO_LAUNDRY[$lang_idx], $nextSigForecast['hrs']);
}
    
function bestLaundryConditions()
{
   global $forecastHour, $current, $min10;
   $numberOfSoSO = 0;
   
    foreach ($forecastHour as $hour_f){
        if (($hour_f['humidity'] > 80)&&($hour_f['wind'] < 10)&&($hour_f['temp'] < 19)&&($hour_f['currentDateTime']) > time()&&($hour_f['currentDateTime']) < (time()+(6*60*60))){
            // logger("found :".$hour_f['humidity']." ".$hour_f['wind']);
            $numberOfSoSO++;
        }
   }
   if (($current->get_hum() < 40)&&($min10->get_windspd() > 3)&&($current->get_pm10() < 130 && $current->get_pm25() < 40))
       return true;
   //logger("current hum:".$current->get_hum());
   if ($numberOfSoSO > 3)
       return false;
   return true; 
}
function averageLaundryConditions()
{
    global $forecastHour, $current;
    foreach ($forecastHour as $hour_f){
        if (($hour_f['humidity'] > 85)&&($hour_f['currentDateTime']) > time())
            return false;
    }
    if ($current->get_hum() > 90)
       return false;
    return true;
}
// is rain coming in 6 hours
function rainExistsIn24hf ()
{
    global $mem, $forecastHour, $nextSigForecast;
    //logger("rainExistsIn24hf ".count($forecastHour));
    foreach ($forecastHour as $hour_f){
        
       if (($hour_f['rain'] > 0)&&($hour_f['currentDateTime'] - time() > 0)&&($hour_f['currentDateTime'] - time() < 21600)){
			$nextSigForecast = array('rain' => $hour_f['rain'], 'hrs' => (round(($hour_f['currentDateTime'] - time())/3600)), 'dust' => null);
			$mem->set('nextSigForecast', $nextSigForecast);
			return true;
		}
		else if (($hour_f['rain'] > 0)&&($hour_f['currentDateTime'] - time() > 0)&&($hour_f['currentDateTime'] - time() < 44000)){
			$nextSigForecast = array('rain' => $hour_f['rain'], 'hrs' => (round(($hour_f['currentDateTime'] - time())/3600)), 'dust' => null);
			$mem->set('nextSigForecast', $nextSigForecast);
			return false;
		} 
    }
    return false;
}
// high wind coming in 6 hours
function highwindExistsIn24hf ()
{
    global $mem, $forecastHour, $nextSigForecast;
    //logger("rainExistsIn24hf ".count($forecastHour));
    foreach ($forecastHour as $hour_f){
        
       if (($hour_f['wind'] > 35)&&($hour_f['currentDateTime'] - time() > 0)&&($hour_f['currentDateTime'] - time() < 21600)){
			$nextSigForecast = array('rain' => $hour_f['rain'], 'hrs' => (round(($hour_f['currentDateTime'] - time())/3600)), 'dust' => null, 'wind' => $hour_f['wind']);
			$mem->set('nextSigForecast', $nextSigForecast);
			return true;
		}
		else if (($hour_f['rain'] > 35)&&($hour_f['currentDateTime'] - time() > 0)&&($hour_f['currentDateTime'] - time() < 44000)){
			$nextSigForecast = array('rain' => $hour_f['rain'], 'hrs' => (round(($hour_f['currentDateTime'] - time())/3600)), 'dust' => null, 'wind' => $hour_f['wind']);
			$mem->set('nextSigForecast', $nextSigForecast);
			return false;
		} 
    }
    return false;
}
// is dust coming in 6 hours
function dustExistsIn24hf ()
{
    global $mem, $forecastHour;
    foreach ($forecastHour as $hour_f){
         if ((strstr($hour_f['icon'], "dust"))&&($hour_f['currentDateTime'] - time() > 0)&&($hour_f['currentDateTime'] - time() < 21600)){
            $nextSigForecast = array('rain' => 0, 'hrs' => (round(($hour_f['currentDateTime'] - time())/3600)), 'dust' => $hour_f['icon']);
			$mem->set('nextSigForecast', $nextSigForecast);
            return true;
		 }
		 else if ((strstr($hour_f['icon'], "dust"))&&($hour_f['currentDateTime'] - time() > 0)&&($hour_f['currentDateTime'] - time() < 44600)){
            $nextSigForecast = array('rain' => 0, 'hrs' => (round(($hour_f['currentDateTime'] - time())/3600)), 'dust' => $hour_f['icon']);
			$mem->set('nextSigForecast', $nextSigForecast);
            return false;
		 }
    }
    return false;
}
function dustExistsNow()
{
    global $current;
    return (($current->get_pm10() > 200));
}
function checkAsterisk($row_verdict, $is_json)
{
    global $CLOSE_TO, $lang_idx;
    $close_to_sec_coldmeter = $CLOSE_TO[$lang_idx].get_name($row_verdict[1]["field_name"]);
    
    if (count($row_verdict) < 2)
        return "";
    
    if ($row_verdict[0]["count"] < ($row_verdict[1]["count"] + 90))
    {
        if ($is_json=="1")
            return $close_to_sec_coldmeter;
        else
            return "<a href=\"javascript:void(0)\" id=\"asterisk\" class=\"info\" >&#x002A;<span class=\"info\">".$close_to_sec_coldmeter."</span></a>";
    }
        
}
function get_heat_index($temp, $hum)
{
	global $EXTREME_HEAT_INDEX, $HEAVY_HEAT_INDEX, $MEDIUM_HEAT_INDEX, $LOW_HEAT_INDEX, $lang_idx;
        
	switch ($hum)
	{
		case ($hum <= 15):
			switch ($temp)
			{
				case ($temp <= 30.5):
					return "";
				case ($temp <= 33):
					return $LOW_HEAT_INDEX[$lang_idx];
				case ($temp <= 38):
					return $MEDIUM_HEAT_INDEX[$lang_idx];
				case ($temp <= 42):
					return $HEAVY_HEAT_INDEX[$lang_idx];
				default:
					return $EXTREME_HEAT_INDEX[$lang_idx];
			}	
			break;
		case ($hum <= 25):
			switch ($temp)
			{
				case ($temp <= 29):
					return "";
				case ($temp <= 31):
					return $LOW_HEAT_INDEX[$lang_idx];
				case ($temp <= 36):
					return $MEDIUM_HEAT_INDEX[$lang_idx];
				case ($temp <= 41):
					return $HEAVY_HEAT_INDEX[$lang_idx];
				default:
					return $EXTREME_HEAT_INDEX[$lang_idx];
			}
			break;
		case ($hum <= 35):
			switch ($temp)
			{
				case ($temp <= 27.5):
					return "";
				case ($temp <= 30):
					return $LOW_HEAT_INDEX[$lang_idx];
				case ($temp <= 34.5):
					return $MEDIUM_HEAT_INDEX[$lang_idx];
				case ($temp <= 39):
					return $HEAVY_HEAT_INDEX[$lang_idx];
				default:
					return $EXTREME_HEAT_INDEX[$lang_idx];
			}
			break;
		case ($hum <= 45):
			switch ($temp)
			{
				case ($temp <= 26.5):
					return "";
				case ($temp <= 29):
					return $LOW_HEAT_INDEX[$lang_idx];
				case ($temp <= 33):
					return $MEDIUM_HEAT_INDEX[$lang_idx];
				case ($temp <= 37.5):
					return $HEAVY_HEAT_INDEX[$lang_idx];
				default:
					return $EXTREME_HEAT_INDEX[$lang_idx];
			}
			break;
		case ($hum <= 55):
			switch ($temp)
			{
				case ($temp <= 25.5):
					return "";
				case ($temp <= 28):
					return $LOW_HEAT_INDEX[$lang_idx];
				case ($temp <= 32):
					return $MEDIUM_HEAT_INDEX[$lang_idx];
				case ($temp <= 36.5):
					return $HEAVY_HEAT_INDEX[$lang_idx];
				default:
					return $EXTREME_HEAT_INDEX[$lang_idx];
			}
			break;
		case ($hum <= 65):
			switch ($temp)
			{
				case ($temp <= 24.5):
					return "";
				case ($temp <= 27):
					return $LOW_HEAT_INDEX[$lang_idx];
				case ($temp <= 31):
					return $MEDIUM_HEAT_INDEX[$lang_idx];
				case ($temp <= 35.5):
					return $HEAVY_HEAT_INDEX[$lang_idx];
				default:
					return $EXTREME_HEAT_INDEX[$lang_idx];
			}
			break;
		case ($hum <= 75):
			switch ($temp)
			{
				case ($temp <= 24):
					return "";
				case ($temp <= 26):
					return $LOW_HEAT_INDEX[$lang_idx];
				case ($temp <= 30):
					return $MEDIUM_HEAT_INDEX[$lang_idx];
				case ($temp <= 34.5):
					return $HEAVY_HEAT_INDEX[$lang_idx];
				default:
					return $EXTREME_HEAT_INDEX[$lang_idx];
			}
			break;
		case ($hum <= 85):
			switch ($temp)
			{
				case ($temp <= 23):
					return "";
				case ($temp <= 25.5):
					return $LOW_HEAT_INDEX[$lang_idx];
				case ($temp <= 29.5):
					return $MEDIUM_HEAT_INDEX[$lang_idx];
				case ($temp <= 34):
					return $HEAVY_HEAT_INDEX[$lang_idx];
				default:
					return $EXTREME_HEAT_INDEX[$lang_idx];
			}
			break;
		case ($hum <= 95):
			switch ($temp)
			{
				case ($temp <= 22.5):
					return "";
				case ($temp <= 24.5):
					return $LOW_HEAT_INDEX[$lang_idx];
				case ($temp <= 28.5):
					return $MEDIUM_HEAT_INDEX[$lang_idx];
				case ($temp <= 33):
					return $HEAVY_HEAT_INDEX[$lang_idx];
				default:
					return $EXTREME_HEAT_INDEX[$lang_idx];
			}
			break;
	}
	
}
$lang_idx = 1;
$lang_idx = @$_GET['lang'];
$EN = 0;
$HEB = 1;
$RU = 2;
$FR = 3;
$AR = 4;
if ($_GET['lang'] == "") {
    /* if (stristr(get_url(), 'lang')){
      $new_url = str_replace ( "&amp;", "&", get_url());
      header("Location: ".$new_url);
      } */
    $lang_idx = $HEB;
} else
    $lang_idx = @$_GET['lang'];
if (($lang_idx != '0')&&($lang_idx != '1')&&($lang_idx != '2')&&($lang_idx != '3')&&($lang_idx != '4'))
{
    //logger("redirected to Heb:".$lang_idx);
    $lang_idx = $HEB;
}
?>