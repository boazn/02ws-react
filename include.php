<?
include_once ("ini.php");
class FixedTime {

    var $date;
    var $time;
    var $day;
    var $temp;
    var $tempunit;
    var $intemp;
    var $dew;
    var $pressure;
    var $hum;
    var $thw;
    var $thws;
    var $rain; // rain in the interval
    var $windspd;
    var $winddir;
    var $windchill;
    var $solarradiation;
    var $uv;
    var $pm10;
    var $cloudiness;
    var $heatidx;
    var $rainrate;
    var $rainratechange;
    var $light = true;
    var $tempchange;
    var $humchange;
    var $windspdchange;
    var $prschange;
    var $cloudbase;
    var $cloudBaseChange;
    var $uvchange;
    var $solarradiationchange;

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
        if ($temp == "miss")
            $this->tempchange = "miss";
        else
            $this->tempchange = number_format($temp - $this->temp, 1, '.', '');
    }

    function set_humchange($hum) {
        if ($hum == "miss")
            $this->humchange = "miss";
        else
            $this->humchange = $hum - $this->hum;
    }

    function set_windspdchange($windspd) {
        $this->windspdchange = $windspd - $this->windspd;
    }

    function set_rainratechange($rainrate) {
        $this->rainratechange = $rainrate - $this->rainrate;
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

    function set_change($temp, $hum, $windspd, $prs, $cldbase, $rainrate, $solarradiation, $uv) {
        $this->set_tempchange($temp);
        $this->set_humchange($hum);
        $this->set_windspdchange($windspd);
        $this->set_prschange($prs);
        $this->set_cloudBaseChange($cldbase);
        $this->set_rainratechange($rainrate);
        $this->set_uvchange($uv);
        $this->set_srchange($solarradiation);
    }

    function get_windspdchange() {
        return $this->windspdchange;
    }

    function get_rainratechange() {
        return $this->rainratechange;
    }

    function get_prschange() {
        return $this->prschange;
    }

    function get_humchange() {
        return $this->humchange;
    }

    function get_tempchange() {
        return $this->tempchange;
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

    function set_intemp($temp) {
        $this->intemp = c_or_f($temp);
    }

    function set_dew($dew) {
        $this->dew = c_or_f($dew);
    }

    function set_hum($hum) {
        $this->hum = $hum;
    }

    function set_pm10($pm10) {
        $this->pm10 = $pm10;
    }

    function set_thw($thw) {
        $this->thw = c_or_f($thw);
    }

    function set_cloudiness($cloudiness) {
        $this->cloudiness = $cloudiness;
    }

    function set_thws($thws) {
        $this->thws = c_or_f($thws);
    }

    function set_windspd($wind) {
        $this->windspd = $wind;
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

    function set_rainrate($rrate) {
        $this->rainrate = $rrate;
    }

    function set_rain($rain) {
        $this->rain = $rain;
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

    function get_temp() {
        return $this->temp;
    }

    function get_tempunit() {
        return $this->tempunit;
    }

    function get_intemp() {
        return $this->intemp;
    }

    function get_dew() {
        return $this->dew;
    }

    function get_hum() {
        return $this->hum;
    }

    function get_pm10() {
        return $this->pm10;
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
        return $this->heatidx;
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

    function get_thws() {
        return $this->thws;
    }

    function get_rainrate() {
        return $this->rainrate;
    }

    function get_rain() {
        return $this->rain;
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
        $current_hh = $time_a[0];
        $current_mm = $time_a[1];
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
    var $lowtemp;
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

    function Period() {
        $this->hightemp = new Parameter();
        $this->lowtemp = new Parameter();
        $this->highhum = new Parameter();
        $this->lowhum = new Parameter();
        $this->highbar = new Parameter();
        $this->lowbar = new Parameter();
        $this->highdew = new Parameter();
        $this->lowdew = new Parameter();
        $this->highwind = new Parameter();
        $this->highrainrate = new Parameter();
        $this->lowwindchill = new Parameter();
        $this->highheatindex = new Parameter();
        $this->highuv = new Parameter();
        $this->lowuv = new Parameter();
        $this->highradiation = new Parameter();
        $this->lowradiation = new Parameter();
    }

    function get_hightemp() {
        return $this->hightemp->get_value();
    }

    function get_highbar() {
        return number_format($this->highbar->get_value(), 1);
    }

    function get_lowtemp() {
        return $this->lowtemp->get_value();
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

    function get_highheatindex() {
        return $this->highheatindex->get_value();
    }

    function get_lowwindchill() {
        return $this->lowwindchill->get_value();
    }

    function get_hightemp_time() {
        if (strlen($this->hightemp->get_time()) < 5)
            return "0" . $this->hightemp->get_time();
        else
            return $this->hightemp->get_time();
    }

    function get_highbar_time() {
        return $this->highbar->get_time();
    }

    function get_lowtemp_time() {
        if (strlen($this->lowtemp->get_time()) < 5)
            return "0" . $this->lowtemp->get_time();
        else
            return $this->lowtemp->get_time();
    }

    function get_highhum_time() {
        return $this->highhum->get_time();
    }

    function get_lowhum_time() {
        return $this->lowhum->get_time();
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

    function get_highheatindex_time() {
        return $this->highheatindex->get_time();
    }

    function set_hightemp($hightemp, $time) {
        $this->hightemp->set_value(c_or_f($hightemp));
        $this->hightemp->set_time($time);
    }

    function set_lowtemp($lowtemp, $time) {
        $this->lowtemp->set_value(c_or_f($lowtemp));
        $this->lowtemp->set_time($time);
    }

    function set_highhum($highhum, $time) {
        $this->highhum->set_value($highhum);
        $this->highhum->set_time($time);
    }

    function set_lowhum($lowhum, $time) {
        $this->lowhum->set_value($lowhum);
        $this->lowhum->set_time($time);
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
    var $abshightemp;
    var $absminrain;
    var $absmaxrain;

    function get_rainperc() {
        return $this->rainperc;
    }

    function set_rainperc($rainperc) {
        $this->rainperc = $rainperc;
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

    function set_et($et) {
        $this->et = $et;
    }

    function set_sunshinehours($sunshinehours) {
        $this->sunshinehours = $sunshinehours;
    }

    function get_rain() {
        return $this->rain;
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
        return $this->abslowtemp;
    }

    function get_abshightemp() {
        return $this->abshightemp;
    }

    function get_absminrain() {
        return $this->absminrain;
    }

    function get_absmaxrain() {
        return $this->absmaxrain;
    }

    function set_abslowtemp($abslowtemp) {
        $this->abslowtemp = c_or_f($abslowtemp);
    }

    function set_abshightemp($abshightemp) {
        $this->abshightemp = c_or_f($abshightemp);
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
    $fp = @fopen($file, "r");
    $filecontents = @fread($fp, filesize($file));
    @fclose($fp);
    $tok = strtok($filecontents, " \n\t");
    return $tok;
}

// end func ()

function getNextWord(&$tok, $intNextWord) {

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
        echo "<b>tok found = " . $tok . "</b><br>";
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
    for ($tokens = array(), $nextToken = strtok($string, ' \n\t'); $nextToken !== false; $nextToken = strtok(' \n\t')) {
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
    /*
      date_diff("1978-04-26", "2003-01-01");
      date_diff("1984-10-24 15:32:25", "2003-01-01");
      date_diff("2001-10-28 17:32:25", "2003-01-01 12:00:18");
     */
    return $nhours;
}

function c_or_f($temp) {

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

enum("ME", "ALL", "GroupA", "SPECIAL");

class Chance {

    const Low = 1;
    const Good = 2;
    const High = 3;

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
	global $current, $now, $hour;
	if ($_GET['debug'] >= 2)
		echo "<br>now rain:".$now->get_rain();
        if (SNOW_IS_MELTING == 1)
            return false;
	if (($current->get_rainrate() !== "0.0")&& ($current->get_rainrate() !== "")&& ($current->get_rainrate() > 0))
		return true;
	if (($now->get_rain() != "0.00")&& ($now->get_rain() != "")&& ($now->get_rain() > 0) && ($current->get_windspd() > 0))	return true;
	return false;
}

function isSnowing()
{
	global $current;
	return ((isRaining()&&($current->get_temp() < 2))||(IS_SNOWING == 1));
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

 function fillPastTime (&$pastTime, $found){
                global $tok, $current;
				if ($_GET['debug']  >= 2) {
					echo "<br>**** fillingPastTime ".$pastTime->get_time()." ****<br>";
				}
                if ($found) {
                    $pastTime->set_temp(getNextWord($tok, 1));
                      $pastTime->set_hum(getNextWord($tok, 3));
					  $pastTime->set_dew(getNextWord($tok, 1));
                      $pastTime->set_windspd(getNextWord($tok, 1));
                      $pastTime->set_winddir(getNextWord($tok, 1));
                      $pastTime->set_pressure(getNextWord($tok, 8));
					  $pastTime->set_cloudbase((($pastTime->get_temp()-$pastTime->get_dew()) * 125) + ELEVATION);
					  $pastTime->set_rain(getNextWord($tok, 1));
					  $pastTime->set_rainrate(getNextWord($tok, 1));
					  $pastTime->set_solarradiation(getNextWord($tok, 1));
					  $pastTime->set_uv(getNextWord($tok, 3));

                    $pastTime->set_change($current->get_temp(), 
											$current->get_hum(), 
											$current->get_windspd(), 
											$current->get_pressure(),
											$current->get_cloudbase(),
											$current->get_rainrate(),
											$current->get_solarradiation(),
											$current->get_uv());
                }
                else{
                    $pastTime->set_temp(null);
                    $pastTime->set_hum(null);
                    $pastTime->set_windspd(null);
                    $pastTime->set_winddir(null);
                    $pastTime->set_pressure(null);
					$pastTime->set_rainrate(null);
                    $pastTime->set_change(null, null, null, null, null, null, null, null);
                }
 }

/*****************************************************************/
// returns array of rain accumulation
function getRainAcc ($thedate, $fromTime, $toTime){

	global $datenotime;
	$rainaccA = array();
	if ($_GET['debug']  >= 1)
		 echo "<br>searching from ",$thedate," ",$fromTime," to ", $datenotime , " ". $toTime."<br>";
	$tok = getTokFromFile(FILE_ARCHIVE);
	if (searchNext ($tok, $thedate)) {
		if (searchNext ($tok, $fromTime)) {
				
			for ($rainTime = $fromTime, $rainAcc = 0, $rainDate = $thedate; 
				 (($rainTime != $toTime) ) || ((ltrim($rainDate) != $datenotime) && ($rainTime == $toTime));
				 $rainDate = getNextWordWith($tok, "/"), $rainTime = getNextWordWith($tok, ":") ){
				
				$rainAcc = $rainAcc + getNextWord($tok, 16);
				array_push ($rainaccA, array( 'date' => $rainDate,'time' => $rainTime,'rainacc' => $rainAcc));
				if ($_GET['debug']  >= 2)
					echo "<br>'".$rainDate."' ".$rainTime." : ".$rainAcc;
			}
			$rainAcc = $rainAcc + getNextWord($tok, 16); // the last line of accumulation
			array_push ($rainaccA, array( 'date' => $rainDate,'time' => $rainTime,'rainacc' => $rainAcc));
			if ($_GET['debug']  >= 2){
					//echo "<br>".$rainTime."<>".$toTime." ".$rainDate."<>".$datenotime;
					echo "<br>last: ".$rainDate." ".$rainTime." : ".$rainAcc;
			}
			return $rainaccA;
		}
		else
			return "(records weren't found)";
	}
	else
		return "(records weren't found)";
}

function getRainAccInterval($rainInterval) {
	 
	 $MinusBaseHours = 0;
	 $MinusBaseMin = 0;
	 global $HOURS, $HOUR, $lang_idx, $RAIN_UNIT;

	 $arrayrain = getRainAccArray($rainInterval, $MinusBaseHours, $MinusBaseMin);
	 $rainAcc = number_format($arrayrain[count($arrayrain) - 1]['rainacc'], 1, '.', '');

	 if ($rainAcc > 0) {
		$result  .= $rainInterval." ".$HOURS[$lang_idx].": ";
		$result .= "";
		$result  .= "".$rainAcc." ".$RAIN_UNIT[$lang_idx];   
		//$result  .= "<span>".getRainIntesity($rainInterval, $rainAcc)." mm/hr</span>";
		$result .= "\n";
	 }
	  return $result;
}

function getRainAccArray ($rainInterval, $MinusBaseHours, $MinusBaseMin) {
	
	  $tok = getTokFromFile(FILE_ARCHIVE);
	  if ($_GET['debug'] >= 1)
		 echo "<br>getRainAccInterval = ".$rainInterval."<br>";
	  
	  if ($_GET['debug'] >= 2)
		 echo "<br>searching".getMinusMinDate($MinusBaseMin)." ".getMinusMinTime($MinusBaseMin);
	  if (searchNext ($tok, getMinusMinDate($MinusBaseMin)))         
		$found = searchNext ($tok, getMinusMinTime($MinusBaseMin));
	  else
		 return false;
	  if ($found){
			$arrayrain  = getRainAcc (getMinusMinDate($MinusBaseMin+$rainInterval*60), getMinusMinTime($MinusBaseMin+$rainInterval*60),getMinusMinTime($MinusBaseMin));
			return $arrayrain;
	  }
	  else
		return false;
}

function getRainIntesity($rainIntervalHour, $rainAcc)
{
	return number_format(($rainAcc/$rainIntervalHour),1, '.', '');
}

function getRainAccTable()
{
	 $result  .= "<div><div class=\"inv_plain_3_zebra\" ";
	 if (isHeb()) $result  .= "dir=\"rtl\" style=\"text-align:left\""; 
	 $result  .= ">";
	 $result .=	 getRainAccInterval(0.5);
	 $result  .= "</div>";
	 $result  .= "<div class=\"inv_plain_3_minus\" ";
	 if (isHeb()) $result  .= "dir=\"rtl\" style=\"text-align:left\""; 
	 $result  .= ">";
	 $result .= getRainAccInterval(1);
	 $result  .= "</div>";
	  $result  .= "<div class=\"inv_plain_3_zebra\" ";
	 if (isHeb()) $result  .= "dir=\"rtl\" style=\"text-align:left\""; 
	 $result  .= ">";
	 $result .= getRainAccInterval(6);
	 $result  .= "</div>";
	 $result  .= "<div class=\"inv_plain_3_minus\" ";
	 if (isHeb()) $result  .= "dir=\"rtl\" style=\"text-align:left\""; 
	 $result  .= ">";
	 $result .= getRainAccInterval(12);
	 $result  .= "</div>";
	  $result  .= "<div style=\"text-align:left\" class=\"inv_plain_3_zebra\" ";
	 if (isHeb()) $result  .= "dir=\"rtl\" style=\"text-align:left\""; 
	 $result  .= ">";
	 $result .=  getRainAccInterval(24);
	  $result .= "</div></div>";
	  return ($result);
}

function extractRainAccArray($arrayrain)
{

	if ($_GET['debug']  >= 2)
		echo "<br> array count = ".count($arrayrain);
	for ($i=0 ; $i < count($arrayrain) ; $i++)
	{
		$result  .= "<tr class=base><td>";
		$result .= $arrayrain[$i]['date']."</td><td>".$arrayrain[$i]['time']."</td><td>".number_format($arrayrain[$i]['rainacc'], 1, '.', '')."mm";
		$result  .= "</td></tr>";
	}
	return $result;
}

function getRainAccArrayTable($interval)
{
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

function extract_Array($array)
{
	$res = "";
	$keys = array_keys($array);
	$values = array_values($array);
	print("<table>");
	for ($i=0 ; $i < count($keys) ; $i++)
	{
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

function extract_Weather($array)
{
	$res = "";
	$keys = array_keys($array);
	$values = array_values($array);
	print("<table>");
	for ($i=0 ; $i < count($keys) ; $i++)
	{
	        print("<tr class=base><td>$keys[$i]:</td><td>");
		if (is_array($values[$i])){// find string
                        $innerKeys = array_keys($values[$i]);
	                $innerValues = array_values($values[$i]);
			for ($j=0 ; $j < count($innerKeys) ; $j++)
	                {
	                        if  ($innerKeys[$j] == "string")
                                     print($innerValues[$j]);

	                }
		}
		else
			print($values[$i]);
		print("</td></tr>");
	}
	print("</table><hr>");

	return $res;
}

function getDepFromNorm($month)
{
	global $day;
	/* getting data from thisYear file */ 
	if ($_GET['debug'] > 2 )
		echo "<br> searching getDepFromNorm for month = ".$month."<br>";
	if (($day <= 3) && ($month == 12))
		$tok = getTokFromFile(FILE_PREV_YEAR);
	else
		$tok = getTokFromFile(FILE_THIS_YEAR);
	getNextWordWith($tok, "---");
	getNextWord($tok, 6);// Dep.From NORM OF January
	$dep = $tok;
	for($i=1; $i<$month ;$i++){
	 	$dep = getNextWord($tok, 16); // Next Dep.From NORM OF January
	}
	return $dep;
}

function getPrevMonthRain()
{
	if ($_GET['debug'] > 2 )
		echo "<br> searching getPrevMonthRain for Rain <br>";
	$tok = getTokFromFile(FILE_PREV_YEAR);
	getNextWordWith($tok, "---");
	getNextWord($tok, 2);
	getNextWordWith($tok, "---");
	getNextWord($tok, 8);// RAIN
	return $tok;
}

function send_SMS($number, $text)	
{	}	
function send_Email($messageBody, $target, $source, $sourcename, $attachment, $subject)	
{
	global $header_pic;
	$lines = 0;
        $result = "";
	//$target=ME;
	require("phpmailer/class.phpmailer.php");
	$mail = new PHPMailer();
	$mail->From     = $source;
	$mail->FromName = $sourcename;
	$mail->Host     = "mailgw.netvision.net.il";
	$mail->Mailer   = "smtp";
	$mail->IsSMTP();
	$mail->AddReplyTo($source, $sourcename);
	
	if ((stristr ($source, "mymail-in.net"))||(stristr ($source, "list.ru"))||(stristr ($source, "trasteembable"))||(stristr ($source, "76up.com")))
		return false;
	global $MORE_INFO, $WEBSITE_TITLE, $EN, $HEB, $lang_idx, $forground_color, $base_color;
	$EmailsToSend = array();
        $textToSend = array();
	$headers  = "MIME-Version: 1.0\r\n";		
	$headers .= "Content-type: text/html; charset=UTF-8\r\n";
	//$headers .= "Content-Language: he\r\n";
	$headers .= "From: {$source}\r\n";		
	$headers .= "Reply-To: {$source}\r\n";
        $headers .= "Return-Path: {$source}\r\n"; 
        $headers .= "Organization: 02WS\r\n"; 
        $headers .= "Message-ID: <".md5(uniqid(time()))."@{$_SERVER['SERVER_NAME']}>";
        $headers .=  "X-MSmail-Priority: Normal";
        $headers .= "X-Priority: 3\r\n";
        $headers .= "X-Mailer: PHP". phpversion() ."\r\n" ;
        $headers .= "X-Priority: 3\r\n";
        $headers .= "X-AntiAbuse: This is a solicited email for 02WS.co.il website\r\n";
        $headers .= "X-AntiAbuse: Servername - {$_SERVER['SERVER_NAME']}\r\n";
        
        
        //$headers .= "Subject: =?UTF-8?Q?".base64_encode($sourcename)."?=";

	//echo("message body = ".$messageBody);
        $multiLangBody = array();
        if (is_array($messageBody)){
            for ($i=0 ; $i < count($messageBody) ; $i++)
            {
                if (is_array($messageBody[$i]))
                {
                    for ($j=0 ; $j < count($messageBody[$i]) ; $j++)
                    array_push($multiLangBody, $messageBody[$i][$j]);
                }
                else
                {
                    array_push($multiLangBody, $messageBody[$EN]);
                    array_push($multiLangBody, $messageBody[$HEB]);
                    // exit for
                    $i = count($messageBody);
                }
                                
            }
             
        }
            
	$messageBody = str_replace("\n", "<br />", $messageBody);
	$messageBody = str_replace("display:none", "", $messageBody);
        
	$genTxtToBuild = "<html";
	if (($source !== EMAIL_ADDRESS)||(isHeb()))
			$genTxtToBuild .= " dir=\"rtl\" ";
	$genTxtToBuild .= "><head><link href=\"".BASE_URL."/main.php?lang=%d\" rel=\"stylesheet\" type=\"text/css\"> </head><body><div style=\"padding:1em\" class=\"topbase slogan float\"><img align=\"absmiddle\" src=\"".BASE_URL."/".$header_pic."\" />&nbsp;%s</div><div style=\"padding:1em\" class=\"clear float inv_plain_3 big\">%s</div></div>";
        if ($target!=ME)
		$genTxtToBuild .= "\n<div style=\"clear:both;direction:rtl\" class=\"inv big\">".$MORE_INFO[$HEB]." - <a href=\"".BASE_URL."\">".BASE_URL."</a><br />אשמח להערות ותגובות<br />Do you have something to say? reply to this Email</div>";
	$genTxtToBuild .= "</body></html>";
        array_push($textToSend , sprintf($genTxtToBuild, $EN, $WEBSITE_TITLE[$EN],  is_array($messageBody) ? $multiLangBody[$EN] : $messageBody ));
        array_push($textToSend , sprintf($genTxtToBuild, $HEB, $WEBSITE_TITLE[$HEB], is_array($messageBody) ? $multiLangBody[$HEB] : $messageBody));
	//$textToSend = '=?UTF-8?B?'.base64_encode($textToSend).'?=';
	if (!is_array($subject))
        $subject = "=?UTF-8?B?".base64_encode($subject)."?=";
   
	
	if ($target===ME){			
		$subject = "*** ".$WEBSITE_TITLE[$EN]." ***"." from ".$source;	
		
	}
	else
	{
		global $link;
		db_init("", "");

	}

	if ($target===SPECIAL) {
	    $subject = "* Special Update from ".$WEBSITE_TITLE[$EN]." *";
            $query = "SELECT * From users WHERE priority < '1'";
            $res = mysqli_query($link, $query);
            while ($line = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                    $lines++;
                    array_push ($EmailsToSend, array('email' => $line["email"], 'lang' => $line["lang"]));
            }
	}		
	else if ($target==ALL) {
            $query = "SELECT * From users WHERE priority > '0'";
            $res = mysqli_query($link, $query);
            while ($line = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                    $lines++;
                    array_push ($EmailsToSend, array('email' => $line["email"], 'lang' => $line["lang"]));
            } 
	}
        else if ($target===ME){ 
            array_push ($EmailsToSend, array('email' => EMAIL_ADDRESS, 'lang' => $HEB));
   
        }
        else {//target = email
           array_push ($EmailsToSend, array('email' => $target, 'lang' => $HEB));
        }
	logger("Sending mail: ".$sourcename." --> ".$target." - ".implode(" / ",$subject).": ".implode(" / ",$textToSend));	
	foreach ($EmailsToSend as $email){			
		//echo "sending to $email...<br/>body=$textToSend<br/>Subject=$subject<br/>from=$source";
                $mail->Body    = $textToSend[$email['lang']];
		$mail->AltBody = $textToSend[$email['lang']];
		$mail->AddAddress($email['email'], "");
                $subjectToMail = "";
                if (is_array($subject)){
                    $mail->Subject = $subject[$email['lang']];
                    $subjectToMail = $subject[$email['lang']];
                }
                else{ 
                    $mail->Subject = $subject;
                    $subjectToMail = $subject;
                }
                             
                $mail->CharSet="UTF-8";
		//$mail->AddStringAttachment("path/to/photo", "YourPhoto.jpg");
		//$mail->AddAttachment("c:/temp/11-10-00.zip", "new_name.zip");  // optional name
		//$mail->Send();
		if(!mail($email['email'], $subjectToMail, $textToSend[$email['lang']], $headers))
		{
			//ini_set("SMTP","mailgw.netvision.net.il");
			mail("boazn1@gmail.com", "JWS mail failure", "failed sending to ".$email['email']  , $headers);
			$result =  "<br />failed sending to ".$email['email']." check your Email.";
		}

		// Clear all addresses and attachments for next loop
		$mail->ClearAddresses();
		$mail->ClearAttachments();
	}
	@mysqli_close($link);
	return $result;
}

/**********************************************************************************************/
    function get_img_tag($change_in_param){
		global $GOING_UP, $GOING_DOWN, $lang_idx;
		if ($change_in_param>0)
			return "<div class='spriteB up invfloat' title=\"".$GOING_UP[$lang_idx]."\"></div>&nbsp;";
		else if ($change_in_param<0)
			return "<div class='spriteB down invfloat' title=\"".$GOING_DOWN[$lang_idx]."\"></div>&nbsp;";

	}

	function get_color_tag($change_in_param){
		if ($change_in_param>0)
			return "<span>".number_format(abs(($change_in_param)), 1, '.', '')."</span>";
		else if ($change_in_param<0)
			return "<span>".number_format(abs(($change_in_param)), 1, '.', '')."</span>";
		else
			return ($change_in_param);
		 //echo number_format($change_in_param,1, '.', ''),$current->get_tempunit(),"</font>";

	}

	function get_font_tag($change_in_param){
		if ($change_in_param>0)
			return "<font class=\"high\">".abs(($change_in_param))."</font>";
		else if ($change_in_param<0)
			return "<font class=\"low\">".abs(($change_in_param))."</font>";
		else
			return ($change_in_param);

	}

	function get_param_tag($change_in_param){
		return (get_img_tag($change_in_param)."<strong>".get_color_tag($change_in_param)."</strong>");
	}

	function get_align(){
		
		 if (isHeb()) 
			 return "align=\"right\"";
		 else
			 return "align=\"left\"";
	}
	
	function get_inv_align(){
		
		 if (isHeb()) 
			 return "align=\"left\"";
		 else
			 return "align=\"right\"";
	}

	function get_s_align(){
		
		 if (isHeb()) 
			 return "right";
		 else
			 return "left";
	}

	function get_inv_s_align(){
		
		 if (isHeb()) 
			 return "left";
		 else
			 return "right";
	}
        function getDirection(){
             if (isHeb()) 
			 return "rtl";
		 else
			 return "ltr";
        }
        function get_sunset_ut(){
            global $sunset;
             $sunset_a = explode(":",$sunset);
             $sunset_hh = $sunset_a[0];
             $sunset_mm = $sunset_a[1];
             $sunset_time_ut = mktime($sunset_hh, $sunset_mm);
             return $sunset_time_ut;
        }
        function get_sunrise_ut(){
            global $sunrise;
             $sunrise_a = explode(":",$sunrise);
             $sunrise_hh = $sunrise_a[0];
             $sunrise_mm = $sunrise_a[1];
             $sunrise_time_ut = mktime($sunrise_hh, $sunrise_mm);
             return $sunrise_time_ut;
        }
	function get_flash_tag($flash, $width){
		$widthFlash = $width;
		$heightFlash = $widthFlash/2;
		if (!isRaining())
			$flashFile = "images/jws.swf";
		else
			$flashFile = $flash;
		return	"\n<embed height={$heightFlash} width={$widthFlash} src=\"$flashFile\" play=true loop=true quality=high WMode=Transparent></embed>";
	}

	
	function getFireIdx($t850, $t700, $dp850)
	{
			
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
		

		


	/////////////////////////////////////////////////////////////////////////////////////////////
	// URL handling
	/////////////////////////////////////////////////////////////////////////////////////////////

	function get_url()
	{
		if ($_SERVER["QUERY_STRING"]	!= "")
			return ("http://".$_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"]."?".$_SERVER["QUERY_STRING"]);
		else
			return ("http://".$_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"]);
	}

	function replaceArgInIRL($url, $arg, $val)
	{
		global $lang_idx;
		$section = $_GET["section"];
		$profile = $_GET["profile"];
		$style = $_GET["style"];
		$tempunit = $_GET["tempunit"];
		$startargs = "";
		if (($arg != "section")&&($section != ""))
			$startargs .= "section=".$section."&amp;";
		if (($profile != "")&&($arg == "graph"))
			$startargs .= "profile=".$profile."&amp;";
		if ($style != "")
			$startargs .= "style=".$style."&amp;";
		if ($tempunit != "")
			$startargs .= "tempunit=".$tempunit."&amp;";
		//$url_pref = BASE_URL;
                $url_pref = $_SERVER['SCRIPT_NAME'];
		if (!stristr ($url_pref, "php"))
		{
			$url_pref .= "/".basename($_SERVER["PHP_SELF"]);
		}
				
		if ($val == "")
			return ($url_pref."?".$startargs."lang=".$lang_idx);
		else
			return ($url_pref."?".$startargs.$arg."=".$val."&amp;lang=".$lang_idx);
		
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
	   if (! is_array($parsed)) return false;
		   $uri = $parsed['scheme'] ? $parsed['scheme'].':'.((strtolower($parsed['scheme']) == 'mailto') ? '':'//'): '';
		   $uri .= $parsed['user'] ? $parsed['user'].($parsed['pass']? ':'.$parsed['pass']:'').'@':'';
		   $uri .= $parsed['host'] ? $parsed['host'] : '';
		   $uri .= $parsed['port'] ? ':'.$parsed['port'] : '';
		   $uri .= $parsed['path'] ? $parsed['path'] : '';
		   $uri .= $parsed['query'] ? '?'.$parsed['query'] : '';
		   $uri .= $parsed['fragment'] ? '#'.$parsed['fragment'] : '';
	  return $uri;
	} 

	function http_implode($arrayInput) {
	   if (! is_array($arrayInput))
		   return false;

	   $url_query="";
	   foreach ($arrayInput as $key=>$value) {
		  
		   $url_query .=(strlen($url_query)>1)?"&amp;":"";
		   $url_query .= urlencode($key).'='.urlencode($value);
	   }
	   return $url_query;
	}

	/////////////////////////////////////////////////////////////////////////////////
	function update_action ($action, $extrainfoS, $messageTitle)
	{
		global $pic, $hour, $min, $CURRENT_SIG_WEATHER, $HEB, $EN, $messageAction, $actionActive, $EmailSubject, $link;
		$message = array("<div class=\"float\">".$hour.":".$min."<br/>"."</div><div class=\"float loading\">"."&nbsp;$CURRENT_SIG_WEATHER[$EN]&nbsp; <strong>".$messageTitle[$EN]."</strong><div class=\"loading float big\">&nbsp;{$extrainfoS[$EN]}<img src=\"".BASE_URL."/images/$pic\" alt=\"$messageTitle[$EN]\" width=\"600px\" border=\"0\" /></div></div>",
                                "<div class=\"float\">".$hour.":".$min."<br/>"."</div><div class=\"float loading\">"."&nbsp;$CURRENT_SIG_WEATHER[$HEB]&nbsp; <strong>".$messageTitle[$HEB]."</strong><div class=\"loading float big\">&nbsp;{$extrainfoS[$HEB]}<img src=\"".BASE_URL."/images/$pic\" alt=\"$messageTitle[$HEB]\" width=\"600px\" border=\"0\" /></div></div>");
		if (!isActionAlreadyActivated($action))
		{
                        $sent = 1;
			$result = db_init("UPDATE sendmailsms SET Sent=$sent, lastSent=NOW() WHERE (Action='$action')");
			//echo "affected rows: ".mysql_affected_rows();
			array_push($messageAction ,$message);
			$actionActive = $action;
			$EmailSubject = $messageTitle;
			logger("update_action - ".$EmailSubject[$HEB].": ".implode(" || ",$message));
             @mysqli_close($link);
		}
		else
			return false;
		return true;
	}

	function isActionAlreadyActivated ($action)
	{
		global $messageAction, $link;
		
		$result = db_init("SELECT * FROM sendmailsms WHERE (Action=?)", $action);
		$row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
		$sent = $row["Sent"];
                @mysqli_close($link);
		if ($sent==0)
		  logger("action ".$action." sent=".$sent);
		return ($sent == 1);
	}

	function setBrokenData($period, $highorlow, $extdata, $param)
    {
        global $year, $hour, $datenotime,$boolbroken,$day,$messageBroken, $error_db, $updateMessage, $month ,  $messageBrokenToSend, $NEW, $BROKEN, $RECORD, $YEARLY, $LAST_RECORD, $ON, $HIGH, $LOW, $EN, $HEB, $MAX, $MIN, $EXTREME, $SHOW, $EmailSubject;
	  
	   if (($param == "temp") && ($_GET['tempunit'] == 'F'))
			$extdata = number_format(($extdata - 32)*(5/9), 1, '.', '');

       $boolbroken= true;
	   
	   if ($highorlow == "high")
		{
	   	  $highorlowm = array( "<span class=\"high\"><b>".$NEW[$EN]." ".$MAX[$EN]." ".$RECORD[$EN]."</b></span>" , "<span class=\"high\" dir=\"rtl\"><b>".$RECORD[$HEB]." ".$MAX[$HEB]." ".$NEW[$HEB]."</b></span>");
		  $prefEmailSubject =  array( $NEW[$EN]." ".$MAX[$EN]." ".$RECORD[$EN] , $RECORD[$HEB]." ".$MAX[$HEB]." ".$NEW[$HEB]);	
		}
	   else
		{
		  $highorlowm = array( "<span class=\"low\" ><b>".$NEW[$EN]." ".$MIN[$EN]." ".$RECORD[$EN]."</b></span>" , "<span class=\"low\" dir=\"rtl\"><b>".$RECORD[$HEB]." ".$MIN[$HEB]." ".$NEW[$HEB]."</b></span>");
		  $prefEmailSubject =  array( $NEW[$EN]." ".$MIN[$EN]." ".$RECORD[$EN] , $RECORD[$HEB]." ".$MIN[$HEB]." ".$NEW[$HEB]);
		}

		$shortYear = sprintf("%02d", $year - 2000);
	   if ($period == "yearly") 
		  $periodm = $year;
	   else
		  $periodm = sprintf("%02d", $month)."/{$year}";

	   array_push ($messageBroken, 
		   array("<div style=\"width:100%\" id=\"broken".$highorlow.$param."\" ><div class=\"innerbroken\"><a href=\"javascript:void(0)\" onmouseover=\"toggleBrokenData(this)\" onmouseout=\"toggleBrokenData(this)\">$highorlowm[$EN] $ON[$EN] $periodm ".get_arrow()."</a></div><div style=\"display:none\" class=\"grad big brokendatatitle\" >$extdata</div>",  
			     "<div id=\"broken".$highorlow.$param."\" style=\"text-align:right\"><div class=\"innerbroken\"><a href=\"javascript:void(0)\" onmouseover=\"toggleBrokenData(this)\" onmouseout=\"toggleBrokenData(this)\">$highorlowm[$HEB] $ON[$HEB] $periodm ".get_arrow()."</a></div><div style=\"display:none\" class=\"grad big brokendatatitle\" >$extdata</div>"));
	   
	   $EmailSubject = array( $prefEmailSubject[$EN]." $ON[$EN] $periodm", $prefEmailSubject[$HEB]." $ON[$HEB] $periodm");		  
	
       if ($error_db){
			 array_push ($messageBroken, array("</span>", "</span>"));
			return false;
		}

        $record_col = "{$period}_{$highorlow}";
	$date_col = "{$record_col}_date";
        $result = db_init("SELECT * FROM extremes where (param=?)", $param);
        $row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
        global $link;
        $old_date = $row["$date_col"];		
        if ($old_date != $datenotime) //already updated --> take from old_record & old_date columns
            $updateMessage = true;
        if (!$updateMessage){
            $record_col = "old_{$highorlow}_record";
            $date_col = "old_{$highorlow}_date";
        }
        $old_record = round($row["$record_col"], 1);
        $old_date = $row["$date_col"];
        /**
        at the first entry to the table the old record is moved to the old_record/old_time columns
           */
         if ($updateMessage) {
           $query = "UPDATE extremes SET $record_col='$extdata', $date_col='$datenotime', old_{$highorlow}_date='$old_date', old_{$highorlow}_record=$old_record WHERE (param='$param')";
               if (!mysqli_query($link, $query))
                       logger(sprintf("Error in setBrokenData: %s\n", mysqli_error($link)));
               
                

         }
        array_push ($messageBroken, array("<div style=\"display:none;text-align:left;paddign:0.3em\" class=\"grad\">$LAST_RECORD[$EN]: <strong>$old_record</strong> <br />$ON[$EN] $old_date</div>",
                "<div style=\"display:none;text-align:right;padding:0.3em\" class=\"grad\">$LAST_RECORD[$HEB]: <strong>$old_record</strong> <br />$ON[$HEB] $old_date </div>"));
        if ($period != "yearly") {
                        $yearly_record = round($row["yearly_{$highorlow}"], 1);
                        $yearly_date = $row["yearly_{$highorlow}_date"];
                        array_push ($messageBroken, array("<div style=\"display:none;text-align:left;padding:0.3em\" class=\"grad\">$RECORD[$EN] $ON[$EN] $year: <strong><span dir=\"ltr\">$yearly_record</span></strong> <br />$ON[$EN] $yearly_date </div>", 
                                "<div style=\"display:none;text-align:right;padding:0.3em\" class=\"grad\">$RECORD[$HEB] $ON[$HEB] $year: <strong><span dir=\"ltr\">$yearly_record</span></strong> <br />$ON[$HEB] $yearly_date </div>"));

        }
        array_push ($messageBroken, array("</div>","</div>"));
        array_push ($messageBroken, array("\n<script type=\"text/javascript\">\nvar tdBroken = document.getElementById('brokenlatest".$param."');\ndivBroken = document.getElementById('broken".$highorlow.$param."');\ntdBroken.appendChild(divBroken);\n</script>", "\n<script type=\"text/javascript\">\nvar tdBroken = document.getElementById('brokenlatest".$param."');\ndivBroken = document.getElementById('broken".$highorlow.$param."');\ntdBroken.appendChild(divBroken);\n</script>"));		

        //if (ShouldSendMsg($highorlow, $param, $period))
        //	echo "should SEND - ".$highorlow." ".$param." ".$period." !!!!!!!!!!!!!!!!!";
        //logger($highorlow." ".$param." ".$period);
        if ($updateMessage) // to send only once
           if (ShouldSendMsg($highorlow, $param, $period))
                {
                       array_push ($messageBrokenToSend, $messageBroken); 
                        for ($i=0 ; $i < count($messageBroken) ; $i++)
                        {
                                $brokendata .= $messageBroken[$i][$HEB];
                        }
                        logger("Prepered to be sent: ".$highorlow." ".$param." ".$period." ".$brokendata);
                }

         // Free resultset 
         @mysqli_free_result($result);
	 @mysqli_close($link);	 


    } // end func
	/******************
			determine if extreme should be sent
    ******************/
	function ShouldSendMsg($highorlow, $param, $period)
	{
		global $month, $day, $messageBroken;
		//echo "<br>count($messageBroken) = ".count($messageBroken);
		// do not send yearly records in January
		if (($period == "yearly")&&($month == 1)&&($day < 10))
			return false;
		// do not send monthly records
		if ($period != "yearly")
			return false;
		// do not send monthly records at the first and the second
		if (($period != "yearly")&&($day < 3))
			return false;
		// do not send monthly pressure max/min - happens to often
		if (($period != "yearly")&&($param == "pressure")&&(count($messageBroken) == 4))
			return false;
		
		return true;
		
     }
	function logger ($msg)
	{
		//echo "<br>in Logger<br>";
		$datafile = "log/log.txt";
		$msg = getLocalTime(time())." ".$msg;
		$file = @fopen($datafile,"a+");
		 @fwrite ($file, $msg." \n");
		 @fclose ($file);
		
	}
function canUpdateExtreme ()
{
	global $min30;
	if ($highorlow=="high") {
		if ($param=="temp") {
			if ($min30->get_tempchange()<-0.2)
				return true;
			if ($today->get_hightemp() < $current->get_temp())
				return true;
		}
		if ($param=="humidity") {
			if ($min30->get_humchange()<-2)
				return true;
			if ($today->get_highhum() < $current->get_hum())
				return true;
		}
		if ($param=="wind") {
			if (($min30->get_windspdchange()<-2)) 
				return true;
			if ($today->get_highwind() < $current->get_windspd())
				return true;
		}
	
	}
	else if (($highorlow=="low")) {
		if ($param=="temp") {
			if ($min30->get_tempchange()>0.2)
				return true;
			if ($today->get_hightemp() > $current->get_temp())
				return true;
		}
		if ($param=="humidity") {
			if ($min30->get_humchange()>2)
				return true;
		}
	}
	return false;
}

	  
function toLeft ($input) {
	// lrm left-to-right mark
	//&lrm;
	//$ptag = "<div style=\"direction: ltr;\">\${1}</div>";
	//$tofind = "{^-[0-9]+$}";
	//return preg_replace($tofind, $ptag, $input);
	return  "<span style=\"direction: ltr;\">$input</span>";
}

function isOpenOrClose ()
{
	
	global $lang_idx, $current, $OPEN, $CLOSE, $PIVOT_TEMP;
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
	$primary_pic = "images/webCameraB.jpg";
	$secondary_image = "images/webCamera.jpg";

	if ((@filemtime($primary_pic) < @filemtime($secondary_image) - 900) || (!file_exists($primary_pic)))
		return $secondary_image;
	return $primary_pic;
	
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
			echo 'ERROR'."\n";      
		}       
		if (!xml_parse($xml_parser, $data, feof($fp))) {           
		logger(sprintf( "XML error: %s at line %d\n\n",           
		xml_error_string(xml_get_error_code($xml_parser)),           
		xml_get_current_line_number($xml_parser)));       
		}    
		}    
	// Display the array    
	//print_r($ary_parsed_file);        
	xml_parser_free($xml_parser);
    return $ary_parsed_file;
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
function get_arrow(){
	if (isHeb())
		return "&nbsp;&#8250;&#8250;"; //"&#9668;";
	else
		return "&nbsp;&#8250;&#8250;"; //"&#9658;";
}
function get_name ($field_name)
{
	global $lang_idx, $VVHOT, $LHOT, $LCOLD, $VVCOLD, $VHOT, $HOT, $NHOTNCOLD, $COLD, $VCOLD, $SPRING, $SUMMER, $AUTOMN, $WINTER, $HOTORCOLD_Q, $FSEASON;
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

function getClothName($current_feeling){
    global $lang_idx, $VVHOT, $LHOT, $LCOLD, $VVCOLD, $VHOT, $HOT, $NHOTNCOLD, $COLD, $VCOLD, $SPRING, $SUMMER, $AUTOMN, $WINTER, $HOTORCOLD_Q, $FSEASON;
    $cloth_name = "";
    if ($current_feeling == $VVHOT[$lang_idx])
    {$cloth_name = "shorts_n2.png";}
    else if ($current_feeling == $VHOT[$lang_idx])
    {$cloth_name = "shorts_n2.png";}
    else if ($current_feeling == $HOT[$lang_idx])
    {$cloth_name = "shorts_n2.png";}
    else if ($current_feeling == $LHOT[$lang_idx])
    {$cloth_name = "tshirt_n2.png";}
    else if ($current_feeling == $NHOTNCOLD[$lang_idx])
    {$cloth_name = "longsleeves_n2.png";}
    else if ($current_feeling == $LCOLD[$lang_idx])
    {$cloth_name = "jacket_n2.png";}
    else if ($current_feeling == $COLD[$lang_idx])
    {$cloth_name = "coat_n2.png";}
    else if ($current_feeling == $VCOLD[$lang_idx])
    {$cloth_name = "coat_n2.png";}
    else if ($current_feeling == $VVCOLD[$lang_idx])
    {$cloth_name = "coat_n2.png";}
    if (isRaining())
        $cloth_name = "coatrain_n2.png";
    return $cloth_name;
}
function getPageTitle()
{
	global $lang_idx, $HEB, $EN, $WEBSITE_TITLE;
	include "lang.php";

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

function getClothTitle($imagename)
{
	global $lang_idx, $HEB, $EN, $TSHIRT, $JACKET, $COAT, $RAINCOAT, $UMBRELLA, $SWEATER, $SWEATSHIRT, $SHORTS, $LONGSLEEVES, $LIGHTJACKET, $LIGHTCOAT, $LAYERS_BELOW2, $LAYERS_BELOW3, $current;
	
	if (stristr(strtolower($imagename), 'tshirt'))
		$title = $TSHIRT[$lang_idx];
	else if (stristr(strtolower($imagename), 'jacketlight'))
		$title = $LIGHTJACKET[$lang_idx];
	else if (stristr(strtolower($imagename), 'jacket'))
		$title = $JACKET[$lang_idx];
	else if (stristr(strtolower($imagename), 'coatlight'))
		$title = $LIGHTCOAT[$lang_idx];
	else if (stristr(strtolower($imagename), 'coatrain')){
		$title = $RAINCOAT[$lang_idx];
                 if ($current->get_temp() < 10)
                    $title .= ", ".$LAYERS_BELOW3[$lang_idx];
                else
                    $title .= ", ".$LAYERS_BELOW2[$lang_idx];
        }
	else if (stristr(strtolower($imagename), 'coat')){
		$title = $COAT[$lang_idx];
                 if ($current->get_temp() < 10)
                    $title .= ", ".$LAYERS_BELOW3[$lang_idx];
                else
                    $title .= ", ".$LAYERS_BELOW2[$lang_idx];
        }        
	else if (stristr(strtolower($imagename), 'umbrella'))
		$title = $UMBRELLA[$lang_idx];
	else if (stristr(strtolower($imagename), 'sweater'))
		$title = $SWEATER[$lang_idx];
	else if (stristr(strtolower($imagename), 'sweatshirt'))
		$title = $SWEATSHIRT[$lang_idx];
	else if (stristr(strtolower($imagename), 'shorts'))
		$title = $SHORTS[$lang_idx];
	else if (stristr(strtolower($imagename), 'longsleeves'))
		$title = $LONGSLEEVES[$lang_idx];
       
	return $title;

}

function db_init($query, $param) {
    global $link, $stmt, $error_db;
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
            logger("query=" . $query . " param=" . $param . "; error in prepare: " . $stmt->error);
        }
        if ((!empty($param)) || (is_int($param))) {
            $param = $link->real_escape_string($param);
            if (is_float($param))
                $res = $stmt->bind_param('d', $param);
            else if (is_numeric($param))
                $res = $stmt->bind_param('d', $param);
            else
                $res = $stmt->bind_param('s', $param);
            if (!$res)
                logger("query=" . $query . " param=" . $param . "; error in binding: " . $stmt->error);
        }
        $res = $stmt->execute();
        if (!$res)
            logger("query=" . $query . " param=" . $param . "; error in execute: " . $stmt->error);
        $result = $stmt->get_result();
        return $result;
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
    $query = "SELECT sf.`field_id` , sf.`field_name` , s.name FROM surveyfields sf, survey s WHERE s.survey_id = sf.survey_id and s.survey_id=?";
    $result = db_init($query, $surveyid);
    return $result;
}

function getSpecificChat($idx) {
    global $lang_idx, $HEB, $link;

    $result = db_init("SELECT * From chat where idx=" . $idx);
    while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
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
    @mysql_free_result($result);
    @mysqli_close($link);
}

function getCurrentChat($searchname, $filter_is_on, $startLine, $limitLines, $timestamp_from, $timestamp_to, $category) {

    global $lang_idx, $HEB, $NEED_TO_REGISTER, $REPLY, $REPLY_EXP, $link;

//echo "limitlines:".$limitLines;

    if ($searchname != "")
        $query = "SELECT * FROM  `chat` c WHERE  `name` LIKE  '%" . $searchname . "%' OR `body` LIKE  '%" . $searchname . "%' ";
    else
        $query = "SELECT * FROM  `chat` c ";

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
    $result = db_init($query);
//if ($_SESSION['loggedin'] == "true")
//	echo "<div class=\"indexlow\" style=\"width:100%;\"></div>";
    /* Printing results in HTML */
    while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
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
            print "<h3>" . $name . "</h3>";
            print "<h4>" . $dateInLineStart . "</h4>";
            print "</div>"; // user
            if ($_SESSION['loggedin'] == "false")
                $onclickmain = "onclick='alert(\"" . $NEED_TO_REGISTER[$lang_idx] . "\")'";
            else
                $onclickmain = "onclick='toggle(\"replydiv" . ($line["idx"]) . "\");$(\"#current_post_idx\").val(" . $line["idx"] . ");moveDivInOut($(this).parent().children(\x22.chatmainbody\x22).get(0));$(\"#subject_icon\").addClass($(\"#current_forum_filter\").val());initTinyMCE(" . $lang_idx . ")'";

            print "\n\t\t<div class=\"chatmainbody\" >" . urldecode($line["body"]) . "</div>";
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

function getWindStatus() {
    global $current, $min10, $WITHOUT_WIND, $LIGHT_WIND, $MODERATE_WIND, $WINDY, $lang_idx;

    if (($current->get_windspd() == 0) && ($min10->get_windspd() == 0)) {
        $windtitle = $WITHOUT_WIND[$lang_idx];
        $wind_class = "light_wind";
    } else if ($min10->get_windspd() < 2.5) {
        $windtitle = $LIGHT_WIND[$lang_idx];
        $wind_class = "light_wind";
    } else if ($min10->get_windspd() < 10) {
        $windtitle = $MODERATE_WIND[$lang_idx];
        $wind_class = "moderate_wind";
    } else {
        $windtitle = $WINDY[$lang_idx];
        $wind_class = "high_wind";
    }
    $div_wind_icon = "<div title=\"" . $windtitle . "\" class=\"wind_icon " . $wind_class . " \"></div>";
    $div_wind_title = "<div class=\"wind_title\" >" . $windtitle . "</div>";
    return $div_wind_icon . $div_wind_title;
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
    $M0 -= 0.0000333 * T2;
    $M0 -= 0.00000347 * T3;
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

$lang_idx = @$_GET['lang'];
$EN = 0;
$HEB = 1;
if ($_GET['lang'] == "") {
    /* if (stristr(get_url(), 'lang')){
      $new_url = str_replace ( "&amp;", "&", get_url());
      header("Location: ".$new_url);
      } */
    $lang_idx = $HEB;
} else
    $lang_idx = @$_GET['lang'];
?>