<?
header('Content-type: text/html; charset=utf-8');
header("Access-Control-Allow-Origin: null");

ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE);
ini_set("display_errors","Off");
include_once("include.php"); 
include_once "start.php";
include_once ("requiredDBTasks.php");
include_once "sigweathercalc.php";
include_once "picasaproxy.php";$mediumSizeUrl = "phpThumb.php?src=".$contentUrl."&amp;w=350&amp;zc=C";
$forecastHour = apc_fetch('forecasthour');
$sigforecastHour = apc_fetch('sigforecastHour');
if (empty($forecastHour)){
    $forecastlib_origin = "02wsjson.php";
    include_once("forecastlib.php");
    $forecastHour = apc_fetch("forecasthour");
}
//include_once("lastdaylib.php");
include_once("periodicDBTasks.php");
$output_json_file_path = "/home/boazn/public/02ws.com/public/02wsjson.txt";
$JSON = "{\"jws\":";

$JSON .= "{\"current\":";
$JSON .= "{";
$JSON .= "\"date0\":"."\"".$date."\"";
$JSON .= ",";
$JSON .= "\"date1\":"."\"".$dateInHeb."\"";
$JSON .= ",";
$JSON .= "\"time\":"."\"".$current->get_time()."\"";
$JSON .= ",";
$JSON .= "\"temp\":"."\"".$current->get_temp()."\"";
$JSON .= ",";
$JSON .= "\"temp2\":"."\"".$current->get_temp2()."\"";
$JSON .= ",";
$JSON .= "\"primary_temp\":"."\"".$PRIMARY_TEMP."\"";
$JSON .= ",";
$JSON .= "\"hum\":"."\"".$current->get_hum()."\"";
$JSON .= ",";
$JSON .= "\"pressure\":"."\"".$current->get_pressure()."\"";
$JSON .= ",";
$JSON .= "\"winddir\":"."\"".$current->get_winddir()."\"";
$JSON .= ",";
$JSON .= "\"windspd\":"."\"".$current->get_windspd()."\"";
$JSON .= ",";
$JSON .= "\"windspd10min\":"."\"".$min10->get_windspd()."\"";
$JSON .= ",";
$JSON .= "\"rainrate\":"."\"".$current->get_rainrate()."\"";
$JSON .= ",";
$JSON .= "\"cloudbase\":"."\"".$current->get_cloudbase()."\"";
$JSON .= ",";
$JSON .= "\"windchill\":"."\"".$current->get_windchill()."\"";
$JSON .= ",";
$JSON .= "\"heatidx\":"."\"".$current->get_heatidx()."\"";
$JSON .= ",";
$JSON .= "\"thw\":"."\"".$current->get_thw()."\"";
$JSON .= ",";
$JSON .= "\"intemp\":"."\"".$current->get_intemp()."\"";
$JSON .= ",";
$JSON .= "\"tempunit\":"."\"".$current->get_tempunit()."\"";
$JSON .= ",";
$JSON .= "\"solarradiation\":"."\"".$current->get_solarradiation()."\"";
$JSON .= ",";
$JSON .= "\"pm10\":"."\"".$current->get_pm10()."\"";
$JSON .= ",";
$JSON .= "\"pm25\":"."\"".$current->get_pm25()."\"";
$JSON .= ",";
$JSON .= "\"pm10sd\":"."\"".$current->get_pm10sd()."\"";
$JSON .= ",";
$JSON .= "\"pm25sd\":"."\"".$current->get_pm25sd()."\"";
$JSON .= ",";
$JSON .= "\"cloudiness\":"."\"".$current->get_cloudiness()."\"";
$JSON .= ",";
$JSON .= "\"islight\":"."\"".$current->is_light()."\"";
$JSON .= ",";
$JSON .= "\"issunset\":"."\"".$current->is_sunset()."\"";
$JSON .= ",";
$JSON .= "\"issunrise\":"."\"".$current->is_sunrise()."\"";
$JSON .= "}";

$JSON .= ",\"min15\":";
$JSON .= "{";
$JSON .= "\"date\":"."\"".$min15->get_date()."\"";
$JSON .= ",";
$JSON .= "\"time\":"."\"".$min15->get_time()."\"";
$JSON .= ",";
$JSON .= "\"minutes\":"."\"".getLastUpdateMin()."\"";
$JSON .= ",";
$JSON .= "\"temp\":"."\"".$min15->get_temp()."\"";
$JSON .= ",";
$JSON .= "\"temp2\":"."\"".$min15->get_temp2()."\"";
$JSON .= ",";
$JSON .= "\"hum\":"."\"".$min15->get_hum()."\"";
$JSON .= ",";
$JSON .= "\"pressure\":"."\"".$min15->get_pressure()."\"";
$JSON .= ",";
$JSON .= "\"winddir\":"."\"".$min15->get_winddir()."\"";
$JSON .= ",";
$JSON .= "\"windspd\":"."\"".$min15->get_windspd()."\"";
$JSON .= ",";
$JSON .= "\"rainrate\":"."\"".$min15->get_rainrate()."\"";
$JSON .= ",";
$JSON .= "\"cloudbase\":"."\"".$min15->get_cloudbase()."\"";
$JSON .= ",";
$JSON .= "\"windchill\":"."\"".$min15->get_windchill()."\"";
$JSON .= ",";
$JSON .= "\"heatidx\":"."\"".$min15->get_heatidx()."\"";
$JSON .= ",";
$JSON .= "\"thw\":"."\"".$min15->get_thw()."\"";
$JSON .= ",";
$JSON .= "\"tempchange\":"."\"".$min15->get_tempchange().",".str_replace('"', '\"',get_img_tag($min15->get_tempchange(), true)).",".str_replace('"', '\"',get_param_tag($min15->get_tempchange(), true))."\"";
$JSON .= ",";
$JSON .= "\"temp2change\":"."\"".$min15->get_temp2change().",".str_replace('"', '\"',get_img_tag($min15->get_temp2change(), true)).",".str_replace('"', '\"',get_param_tag($min15->get_temp2change(), true))."\"";
$JSON .= ",";
$JSON .= "\"humchange\":"."\"".number_format($min15->get_humchange()).",".str_replace('"', '\"',get_img_tag($min15->get_humchange(), true)).",".str_replace('"', '\"',get_img_tag($min15->get_humchange(), true).abs($min15->get_humchange()))."\"";
$JSON .= ",";
$JSON .= "\"tempunit\":"."\"".$min15->get_tempunit()."\"";
$JSON .= ",";
$JSON .= "\"solarradiation\":"."\"".$min15->get_solarradiation()."\"";
$JSON .= ",";
$JSON .= "\"pm10\":"."\"".$min15->get_pm10()."\"";
$JSON .= ",";
$JSON .= "\"cloudiness\":"."\"".$min15->get_cloudiness()."\"";
$JSON .= "}";

$JSON .= ",\"min30\":";
$JSON .= "{";
$JSON .= "\"date\":"."\"".$min30->get_date()."\"";
$JSON .= ",";
$JSON .= "\"time\":"."\"".$min30->get_time()."\"";
$JSON .= ",";
$JSON .= "\"temp\":"."\"".$min30->get_temp()."\"";
$JSON .= ",";
$JSON .= "\"temp2\":"."\"".$min30->get_temp2()."\"";
$JSON .= ",";
$JSON .= "\"hum\":"."\"".$min30->get_hum()."\"";
$JSON .= ",";
$JSON .= "\"pressure\":"."\"".$min30->get_pressure()."\"";
$JSON .= ",";
$JSON .= "\"winddir\":"."\"".$min30->get_winddir()."\"";
$JSON .= ",";
$JSON .= "\"windspd\":"."\"".$min30->get_windspd()."\"";
$JSON .= ",";
$JSON .= "\"rainrate\":"."\"".$min30->get_rainrate()."\"";
$JSON .= ",";
$JSON .= "\"cloudbase\":"."\"".$min30->get_cloudbase()."\"";
$JSON .= ",";
$JSON .= "\"windchill\":"."\"".$min30->get_windchill()."\"";
$JSON .= ",";
$JSON .= "\"heatidx\":"."\"".$min30->get_heatidx()."\"";
$JSON .= ",";
$JSON .= "\"thw\":"."\"".$min30->get_thw()."\"";
$JSON .= ",";
$JSON .= "\"tempchange\":"."\"".$min30->get_tempchange().",".str_replace('"', '\"',get_img_tag($min30->get_tempchange(), true)).",".str_replace('"', '\"',get_param_tag($min30->get_tempchange(), true))."\"";
$JSON .= ",";
$JSON .= "\"temp2change\":"."\"".$min30->get_temp2change().",".str_replace('"', '\"',get_img_tag($min30->get_temp2change(), true)).",".str_replace('"', '\"',get_param_tag($min30->get_temp2change(), true))."\"";
$JSON .= ",";
$JSON .= "\"humchange\":"."\"".number_format($min30->get_humchange()).",".str_replace('"', '\"',get_img_tag($min30->get_humchange(), true)).",".str_replace('"', '\"',get_img_tag($min30->get_humchange(), true).abs($min30->get_humchange()))."\"";
$JSON .= ",";
$JSON .= "\"tempunit\":"."\"".$min30->get_tempunit()."\"";
$JSON .= ",";
$JSON .= "\"solarradiation\":"."\"".$min30->get_solarradiation()."\"";
$JSON .= ",";
$JSON .= "\"pm10\":"."\"".$min30->get_pm10()."\"";
$JSON .= ",";
$JSON .= "\"cloudiness\":"."\"".$min30->get_cloudiness()."\"";
$JSON .= "}";

$JSON .= ",\"oneHour\":";
$JSON .= "{";
$JSON .= "\"date\":"."\"".$oneHour->get_date()."\"";
$JSON .= ",";
$JSON .= "\"time\":"."\"".$oneHour->get_time()."\"";
$JSON .= ",";
$JSON .= "\"temp\":"."\"".$oneHour->get_temp()."\"";
$JSON .= ",";
$JSON .= "\"temp2\":"."\"".$oneHour->get_temp2()."\"";
$JSON .= ",";
$JSON .= "\"hum\":"."\"".$oneHour->get_hum()."\"";
$JSON .= ",";
$JSON .= "\"pressure\":"."\"".$oneHour->get_pressure()."\"";
$JSON .= ",";
$JSON .= "\"winddir\":"."\"".$oneHour->get_winddir()."\"";
$JSON .= ",";
$JSON .= "\"windspd\":"."\"".$oneHour->get_windspd()."\"";
$JSON .= ",";
$JSON .= "\"rainrate\":"."\"".$oneHour->get_rainrate()."\"";
$JSON .= ",";
$JSON .= "\"cloudbase\":"."\"".$oneHour->get_cloudbase()."\"";
$JSON .= ",";
$JSON .= "\"windchill\":"."\"".$oneHour->get_windchill()."\"";
$JSON .= ",";
$JSON .= "\"heatidx\":"."\"".$oneHour->get_heatidx()."\"";
$JSON .= ",";
$JSON .= "\"thw\":"."\"".$oneHour->get_thw()."\"";
$JSON .= ",";
$JSON .= "\"tempchange\":"."\"".$oneHour->get_tempchange().",".str_replace('"', '\"',get_img_tag($oneHour->get_tempchange(), true)).",".str_replace('"', '\"',get_param_tag($oneHour->get_tempchange(), true))."\"";
$JSON .= ",";
$JSON .= "\"temp2change\":"."\"".$oneHour->get_temp2change().",".str_replace('"', '\"',get_img_tag($oneHour->get_temp2change(), true)).",".str_replace('"', '\"',get_param_tag($oneHour->get_temp2change(), true))."\"";
$JSON .= ",";
$JSON .= "\"humchange\":"."\"".number_format($oneHour->get_humchange()).",".str_replace('"', '\"',get_img_tag($oneHour->get_humchange(), true)).",".str_replace('"', '\"',get_img_tag($oneHour->get_humchange(), true).abs($oneHour->get_humchange()))."\"";
$JSON .= ",";
$JSON .= "\"tempunit\":"."\"".$oneHour->get_tempunit()."\"";
$JSON .= ",";
$JSON .= "\"solarradiation\":"."\"".$oneHour->get_solarradiation()."\"";
$JSON .= ",";
$JSON .= "\"pm10\":"."\"".$oneHour->get_pm10()."\"";
$JSON .= ",";
$JSON .= "\"cloudiness\":"."\"".$oneHour->get_cloudiness()."\"";
$JSON .= "}";

$JSON .= ",\"threeHours\":";
$JSON .= "{";
$JSON .= "\"date\":"."\"".$threeHours->get_date()."\"";
$JSON .= ",";
$JSON .= "\"time\":"."\"".$threeHours->get_time()."\"";
$JSON .= ",";
$JSON .= "\"temp\":"."\"".$threeHours->get_temp()."\"";
$JSON .= ",";
$JSON .= "\"temp2\":"."\"".$threeHours->get_temp2()."\"";
$JSON .= ",";
$JSON .= "\"hum\":"."\"".$threeHours->get_hum()."\"";
$JSON .= ",";
$JSON .= "\"pressure\":"."\"".$threeHours->get_pressure()."\"";
$JSON .= ",";
$JSON .= "\"winddir\":"."\"".$threeHours->get_winddir()."\"";
$JSON .= ",";
$JSON .= "\"windspd\":"."\"".$threeHours->get_windspd()."\"";
$JSON .= ",";
$JSON .= "\"rainrate\":"."\"".$threeHours->get_rainrate()."\"";
$JSON .= ",";
$JSON .= "\"cloudbase\":"."\"".$threeHours->get_cloudbase()."\"";
$JSON .= ",";
$JSON .= "\"windchill\":"."\"".$threeHours->get_windchill()."\"";
$JSON .= ",";
$JSON .= "\"heatidx\":"."\"".$threeHours->get_heatidx()."\"";
$JSON .= ",";
$JSON .= "\"thw\":"."\"".$threeHours->get_thw()."\"";
$JSON .= ",";
$JSON .= "\"intemp\":"."\"".$threeHours->get_intemp()."\"";
$JSON .= ",";
$JSON .= "\"tempunit\":"."\"".$threeHours->get_tempunit()."\"";
$JSON .= ",";
$JSON .= "\"solarradiation\":"."\"".$threeHours->get_solarradiation()."\"";
$JSON .= ",";
$JSON .= "\"pm10\":"."\"".$threeHours->get_pm10()."\"";
$JSON .= ",";
$JSON .= "\"cloudiness\":"."\"".$threeHours->get_cloudiness()."\"";
$JSON .= "}";

$JSON .= ",\"yestsametime\":";
$JSON .= "{";
$JSON .= "\"date\":"."\"".$yestsametime->get_date()."\"";
$JSON .= ",";
$JSON .= "\"time\":"."\"".$yestsametime->get_time()."\"";
$JSON .= ",";
$JSON .= "\"temp\":"."\"".$yestsametime->get_temp()."\"";
$JSON .= ",";
$JSON .= "\"temp2\":"."\"".$yestsametime->get_temp2()."\"";
$JSON .= ",";
$JSON .= "\"hum\":"."\"".$yestsametime->get_hum()."\"";
$JSON .= ",";
$JSON .= "\"pressure\":"."\"".$yestsametime->get_pressure()."\"";
$JSON .= ",";
$JSON .= "\"winddir\":"."\"".$yestsametime->get_winddir()."\"";
$JSON .= ",";
$JSON .= "\"windspd\":"."\"".$yestsametime->get_windspd()."\"";
$JSON .= ",";
$JSON .= "\"rainrate\":"."\"".$yestsametime->get_rainrate()."\"";
$JSON .= ",";
$JSON .= "\"cloudbase\":"."\"".$yestsametime->get_cloudbase()."\"";
$JSON .= ",";
$JSON .= "\"windchill\":"."\"".$yestsametime->get_windchill()."\"";
$JSON .= ",";
$JSON .= "\"heatidx\":"."\"".$yestsametime->get_heatidx()."\"";
$JSON .= ",";
$JSON .= "\"thw\":"."\"".$yestsametime->get_thw()."\"";
$JSON .= ",";
$JSON .= "\"tempchange\":"."\"".$yestsametime->get_tempchange().",".str_replace('"', '\"', get_img_tag($yestsametime->get_tempchange(), true)).",".str_replace('"', '\"', get_param_tag($yestsametime->get_tempchange(), true))."\"";
$JSON .= ",";
$JSON .= "\"temp2change\":"."\"".$yestsametime->get_temp2change().",".str_replace('"', '\"', get_img_tag($yestsametime->get_temp2change(), true)).",".str_replace('"', '\"', get_param_tag($yestsametime->get_temp2change(), true))."\"";
$JSON .= ",";
$JSON .= "\"humchange\":"."\"".number_format($yestsametime->get_humchange()).",".get_img_tag($yestsametime->get_humchange(), true).",".get_img_tag($yestsametime->get_humchange(), true).abs($yestsametime->get_humchange())."\"";
$JSON .= ",";
$JSON .= "\"tempunit\":"."\"".$yestsametime->get_tempunit()."\"";
$JSON .= ",";
$JSON .= "\"solarradiation\":"."\"".$yestsametime->get_solarradiation()."\"";
$JSON .= ",";
$JSON .= "\"pm10\":"."\"".$yestsametime->get_pm10()."\"";
$JSON .= ",";
$JSON .= "\"cloudiness\":"."\"".$yestsametime->get_cloudiness()."\"";
$JSON .= "}";

$JSON .= ",\"thisMonth\":";
$JSON .= "{";
$JSON .= "\"hightemp\":"."\"".$thisMonth->get_hightemp()."\"";
$JSON .= ",";
$JSON .= "\"lowtemp\":"."\"".$thisMonth->get_lowtemp()."\"";
$JSON .= ",";
$JSON .= "\"highhum\":"."\"".$thisMonth->get_highhum()."\"";
$JSON .= ",";
$JSON .= "\"lowhum\":"."\"".$thisMonth->get_lowhum()."\"";
$JSON .= ",";
$JSON .= "\"highdew\":"."\"".$thisMonth->get_highdew()."\"";
$JSON .= ",";
$JSON .= "\"lowdew\":"."\"".$thisMonth->get_lowdew()."\"";
$JSON .= ",";
$JSON .= "\"highbar\":"."\"".$thisMonth->get_highbar()."\"";
$JSON .= ",";
$JSON .= "\"lowbar\":"."\"".$thisMonth->get_lowbar()."\"";
$JSON .= ",";
$JSON .= "\"highwind\":"."\"".$thisMonth->get_highwind()."\"";
$JSON .= ",";
$JSON .= "\"lowwindchill\":"."\"".$thisMonth->get_lowwindchill()."\"";
$JSON .= ",";
$JSON .= "\"highheatindex\":"."\"".$thisMonth->get_highheatindex()."\"";
$JSON .= ",";
$JSON .= "\"hightemp_av\":"."\"".$monthAverge->get_hightemp()."\"";
$JSON .= ",";
$JSON .= "\"hightemp_ab\":"."\"".$monthAverge->get_abshightemp()."\"";
$JSON .= ",";
$JSON .= "\"lowtemp_av\":"."\"".$monthAverge->get_lowtemp()."\"";
$JSON .= ",";
$JSON .= "\"lowtemp_ab\":"."\"".$monthAverge->get_abslowtemp()."\"";
$JSON .= ",";
$JSON .= "\"rain\":"."\"".$thisMonth->get_rain()."\"";
$JSON .= ",";
$JSON .= "\"rainydays\":"."\"".$thisMonth->get_rainydays()."\"";
$JSON .= ",";
$JSON .= "\"raindiffav\":"."\"".$thisMonth->get_raindiffav()."\"";
$JSON .= ",";
$JSON .= "\"rainydaysdiffav\":"."\"".$thisMonth->get_rainydaysdiffav()."\"";
$JSON .= ",";
$JSON .= "\"rainperc\":"."\"".$thisMonth->get_rainperc()."\"";
$JSON .= "}";

$JSON .= ",\"prevMonth\":";
$JSON .= "{";
$JSON .= "\"hightemp\":"."\"".$prevMonth->get_hightemp()."\"";
$JSON .= ",";
$JSON .= "\"lowtemp\":"."\"".$prevMonth->get_lowtemp()."\"";
$JSON .= ",";
$JSON .= "\"highhum\":"."\"".$prevMonth->get_highhum()."\"";
$JSON .= ",";
$JSON .= "\"lowhum\":"."\"".$prevMonth->get_lowhum()."\"";
$JSON .= ",";
$JSON .= "\"highdew\":"."\"".$prevMonth->get_highdew()."\"";
$JSON .= ",";
$JSON .= "\"lowdew\":"."\"".$prevMonth->get_lowdew()."\"";
$JSON .= ",";
$JSON .= "\"highbar\":"."\"".$prevMonth->get_highbar()."\"";
$JSON .= ",";
$JSON .= "\"lowbar\":"."\"".$prevMonth->get_lowbar()."\"";
$JSON .= ",";
$JSON .= "\"highwind\":"."\"".$prevMonth->get_highwind()."\"";
$JSON .= ",";
$JSON .= "\"lowwindchill\":"."\"".$prevMonth->get_lowwindchill()."\"";
$JSON .= ",";
$JSON .= "\"highheatindex\":"."\"".$prevMonth->get_highheatindex()."\"";
$JSON .= ",";
$JSON .= "\"rain\":"."\"".$prevMonth->get_rain()."\"";
$JSON .= ",";
$JSON .= "\"rainydays\":"."\"".$prevMonth->get_rainydays()."\"";
$JSON .= ",";
$JSON .= "\"raindiffav\":"."\"".$prevMonth->get_raindiffav()."\"";
$JSON .= ",";
$JSON .= "\"rainydaysdiffav\":"."\"".$prevMonth->get_rainydaysdiffav()."\"";
$JSON .= ",";
$JSON .= "\"rainperc\":"."\"".$prevMonth->get_rainperc()."\"";
$JSON .= "}";

$JSON .= ",\"thisYear\":";
$JSON .= "{";
$JSON .= "\"hightemp\":"."\"".$thisYear->get_hightemp()."\"";
$JSON .= ",";
$JSON .= "\"lowtemp\":"."\"".$thisYear->get_lowtemp()."\"";
$JSON .= ",";
$JSON .= "\"highhum\":"."\"".$thisYear->get_highhum()."\"";
$JSON .= ",";
$JSON .= "\"lowhum\":"."\"".$thisYear->get_lowhum()."\"";
$JSON .= ",";
$JSON .= "\"highdew\":"."\"".$thisYear->get_highdew()."\"";
$JSON .= ",";
$JSON .= "\"lowdew\":"."\"".$thisYear->get_lowdew()."\"";
$JSON .= ",";
$JSON .= "\"highbar\":"."\"".$thisYear->get_highbar()."\"";
$JSON .= ",";
$JSON .= "\"lowbar\":"."\"".$thisYear->get_lowbar()."\"";
$JSON .= ",";
$JSON .= "\"highwind\":"."\"".$thisYear->get_highwind()."\"";
$JSON .= ",";
$JSON .= "\"lowwindchill\":"."\"".$thisYear->get_lowwindchill()."\"";
$JSON .= ",";
$JSON .= "\"highheatindex\":"."\"".$thisYear->get_highheatindex()."\"";
$JSON .= ",";
$JSON .= "\"rain\":"."\"".$thisYear->get_rain()."\"";
$JSON .= ",";
$JSON .= "\"rainydays\":"."\"".$thisYear->get_rainydays()."\"";
$JSON .= ",";
$JSON .= "\"raindiffav\":"."\"".$thisYear->get_raindiffav()."\"";
$JSON .= ",";
$JSON .= "\"rainydaysdiffav\":"."\"".$thisYear->get_rainydaysdiffav()."\"";
$JSON .= ",";
$JSON .= "\"rainperc\":"."\"".$thisYear->get_rainperc()."\"";
$JSON .= "}";

$JSON .= ",\"today\":";
$JSON .= "{";
$JSON .= "\"date\":"."\"".date("j/n",  mktime ($hour, $min, 0, $month, $day ,$year))."\"";
$JSON .= ",";
$JSON .= "\"morningtemp\":"."\"".$today->get_temp_morning()."\"";
$JSON .= ",";
$JSON .= "\"noontemp\":"."\"".$today->get_temp_day()."\"";
$JSON .= ",";
$JSON .= "\"hightemp\":"."\"".$today->get_hightemp()."\"";
$JSON .= ",";
$JSON .= "\"hightemp_time\":"."\"".$today->get_hightemp_time()."\"";
$JSON .= ",";
$JSON .= "\"hightemp_change\":"."\"".get_param_tag($todayForecast->get_hightemp() - round($today->get_hightemp()), true, false)."\"";
$JSON .= ",";
$JSON .= "\"lowtemp\":"."\"".$today->get_lowtemp()."\"";
$JSON .= ",";
$JSON .= "\"lowtemp_time\":"."\"".$today->get_lowtemp_time()."\"";
$JSON .= ",";
$JSON .= "\"hightemp2\":"."\"".$today->get_hightemp2()."\"";
$JSON .= ",";
$JSON .= "\"hightemp2_time\":"."\"".$today->get_hightemp2_time()."\"";
$JSON .= ",";
$JSON .= "\"lowtemp2\":"."\"".$today->get_lowtemp2()."\"";
$JSON .= ",";
$JSON .= "\"lowtemp2_time\":"."\"".$today->get_lowtemp2_time()."\"";
$JSON .= ",";
$JSON .= "\"highhum\":"."\"".$today->get_highhum()."\"";
$JSON .= ",";
$JSON .= "\"highhum_time\":"."\"".$today->get_highhum_time()."\"";
$JSON .= ",";
$JSON .= "\"lowhum\":"."\"".$today->get_lowhum()."\"";
$JSON .= ",";
$JSON .= "\"lowhum_time\":"."\"".$today->get_lowhum_time()."\"";
$JSON .= ",";
$JSON .= "\"highdew\":"."\"".$today->get_highdew()."\"";
$JSON .= ",";
$JSON .= "\"lowdew\":"."\"".$today->get_lowdew()."\"";
$JSON .= ",";
$JSON .= "\"highbar\":"."\"".$today->get_highbar()."\"";
$JSON .= ",";
$JSON .= "\"lowbar\":"."\"".$today->get_lowbar()."\"";
$JSON .= ",";
$JSON .= "\"highwind\":"."\"".$today->get_highwind()."\"";
$JSON .= ",";
$JSON .= "\"highwind_time\":"."\"".$today->get_highwind_time()."\"";
$JSON .= ",";
$JSON .= "\"lowwindchill\":"."\"".$today->get_lowwindchill()."\"";
$JSON .= ",";
$JSON .= "\"highheatindex\":"."\"".$today->get_highheatindex()."\"";
$JSON .= ",";
$JSON .= "\"highrainrate\":"."\"".$today->get_highrainrate()."\"";
$JSON .= ",";
$JSON .= "\"highrainrate_time\":"."\"".$today->get_highrainrate_time()."\"";
$JSON .= ",";
$JSON .= "\"rain\":"."\"".$today->get_rain()."\"";
$JSON .= "}";

$JSON .= ",\"yest\":";
$JSON .= "{";
$JSON .= "\"date\":"."\"".date("j/n",  mktime ($hour, $min, 0, $month, $day-1 ,$year))."\"";
$JSON .= ",";
$JSON .= "\"morningtemp\":"."\"".$yest->get_temp_morning()."\"";
$JSON .= ",";
$JSON .= "\"noontemp\":"."\"".$yest->get_temp_day()."\"";
$JSON .= ",";
$JSON .= "\"nighttemp\":"."\"".$yest->get_temp_night()."\"";
$JSON .= ",";
$JSON .= "\"hightemp\":"."\"".$yest->get_hightemp()."\"";
$JSON .= ",";
$JSON .= "\"hightemp_change\":"."\"".get_param_tag($todayForecast->get_hightemp() - round($yest->get_hightemp()), true, false)."\"";
$JSON .= ",";
$JSON .= "\"lowtemp\":"."\"".$yest->get_lowtemp()."\"";
$JSON .= ",";
$JSON .= "\"highhum\":"."\"".$yest->get_highhum()."\"";
$JSON .= ",";
$JSON .= "\"lowhum\":"."\"".$yest->get_lowhum()."\"";
$JSON .= ",";
$JSON .= "\"highdew\":"."\"".$yest->get_highdew()."\"";
$JSON .= ",";
$JSON .= "\"lowdew\":"."\"".$yest->get_lowdew()."\"";
$JSON .= ",";
$JSON .= "\"highbar\":"."\"".$yest->get_highbar()."\"";
$JSON .= ",";
$JSON .= "\"lowbar\":"."\"".$yest->get_lowbar()."\"";
$JSON .= ",";
$JSON .= "\"highwind\":"."\"".$yest->get_highwind()."\"";
$JSON .= ",";
$JSON .= "\"lowwindchill\":"."\"".$yest->get_lowwindchill()."\"";
$JSON .= ",";
$JSON .= "\"highheatindex\":"."\"".$yest->get_highheatindex()."\"";
$JSON .= ",";
$JSON .= "\"rain\":"."\"".$yest->get_rain()."\"";
$JSON .= "}";

$JSON .= ",\"wholeSeason\":";
$JSON .= "{";
$JSON .= "\"rain\":"."\"".$wholeSeason->get_rain()."\"";
$JSON .= ",";
$JSON .= "\"rainydays\":"."\"".$wholeSeason->get_rainydays()."\"";
$JSON .= ",";
$JSON .= "\"raindiffav\":"."\"".$wholeSeason->get_raindiffav()."\"";
$JSON .= ",";
$JSON .= "\"rainydaysdiffav\":"."\"".$wholeSeason->get_rainydaysdiffav()."\"";
$JSON .= ",";
$JSON .= "\"rainperc\":"."\"".$wholeSeason->get_rainperc()."\"";
$JSON .= "}";

$JSON .= ",\"seasonTillNow\":";
$JSON .= "{";
$JSON .= "\"rain\":"."\"".$seasonTillNow->get_rain()."\"";
$JSON .= ",";
$JSON .= "\"rainydays\":"."\"".$seasonTillNow->get_rainydays()."\"";
$JSON .= ",";
$JSON .= "\"raindiffav\":"."\"".$seasonTillNow->get_raindiffav()."\"";
$JSON .= ",";
$JSON .= "\"rainydaysdiffav\":"."\"".$seasonTillNow->get_rainydaysdiffav()."\"";
$JSON .= ",";
$JSON .= "\"rainperc\":"."\"".$seasonTillNow->get_rainperc()."\"";
$JSON .= "}";

$JSON .= ",\"averageTillNow\":";
$JSON .= "{";
$JSON .= "\"rain\":"."\"".$averageTillNow->get_rain()."\"";
$JSON .= ",";
$JSON .= "\"rainydays\":"."\"".$averageTillNow->get_rainydays()."\"";
$JSON .= ",";
$JSON .= "\"raindiffav\":"."\"".$averageTillNow->get_raindiffav()."\"";
$JSON .= ",";
$JSON .= "\"rainydaysdiffav\":"."\"".$averageTillNow->get_rainydaysdiffav()."\"";
$JSON .= ",";
$JSON .= "\"rainperc\":"."\"".$averageTillNow->get_rainperc()."\"";
$JSON .= "}";

$JSON .= ",\"storm\":";
$JSON .= "{";
$JSON .= "\"rain\":"."\"".$storm->get_rain()."\"";
$JSON .= "}";

$JSON .= ",\"todayForecast\":";
$JSON .= "{";
$JSON .= "\"hightemp\":"."\"".$todayForecast->get_hightemp()."\"";
$JSON .= ",";
$JSON .= "\"lowtemp\":"."\"".$todayForecast->get_lowtemp()."\"";
$JSON .= ",";
$JSON .= "\"temp_morning\":"."\"".$todayForecast->get_temp_morning()."\"";
$JSON .= ",";
$JSON .= "\"temp_day\":"."\"".$todayForecast->get_temp_day()."\"";
$JSON .= ",";
$JSON .= "\"temp_night\":"."\"".$todayForecast->get_temp_night()."\"";
$JSON .= "}";

$JSON .= ",\"tomorrowForecast\":";
$JSON .= "{";
$JSON .= "\"hightemp\":"."\"".$tomorrowForecast->get_hightemp()."\"";
$JSON .= ",";
$JSON .= "\"lowtemp\":"."\"".$tomorrowForecast->get_lowtemp()."\"";
$JSON .= ",";
$JSON .= "\"temp_morning\":"."\"".$tomorrowForecast->get_temp_morning()."\"";
$JSON .= ",";
$JSON .= "\"temp_day\":"."\"".$tomorrowForecast->get_temp_day()."\"";
$JSON .= ",";
$JSON .= "\"temp_night\":"."\"".$tomorrowForecast->get_temp_night()."\"";
$JSON .= "}";

$JSON .= ",\"forecastHours\":[";
foreach ($forecastHour as $hour_f){
$JSON .= "{";
$JSON .= "\"currentDateTime\":"."\"".$hour_f['currentDateTime']."\"";
$JSON .= ",";
$JSON .= "\"date\":"."\"".date("j/m", $hour_f['currentDateTime'])."\"";
$JSON .= ",";
$JSON .= "\"plusminus\":"."\"".$hour_f['plusminus']."\"";
$JSON .= ",";
$JSON .= "\"time\":"."\"".$hour_f['time']."\"";
$JSON .= ",";
$JSON .= "\"wind\":"."\"".$hour_f['wind']."\"";
$JSON .= ",";
$JSON .= "\"wind_class\":"."\"".getWindInfo($hour_f['wind'], $lang_idx)['wind_class']."\"";
$JSON .= ",";
$JSON .= "\"wind_title0\":"."\"".getWindInfo($hour_f['wind'], 0)['windtitle']."\"";
$JSON .= ",";
$JSON .= "\"wind_title1\":"."\"".getWindInfo($hour_f['wind'], 1)['windtitle']."\"";
$JSON .= ",";
$JSON .= "\"icon\":"."\"".$hour_f['icon']."\"";
$JSON .= ",";
$JSON .= "\"temp\":"."\"".$hour_f['temp']."\"";
$JSON .= ",";
$JSON .= "\"cloth\":"."\""."images/clothes/".$hour_f['cloth']."\"";
$JSON .= ",";
$JSON .= "\"title0\":"."\"".$hour_f['title'][0]."\"";
$JSON .= ",";
$JSON .= "\"title1\":"."\"".str_replace('\"', "&quot;", $hour_f['title'][1])."\"";
$lang_idx = 0;
$JSON .= ",";
$JSON .= "\"cloth_title0\":"."\"".getClothTitle($hour_f['cloth'], $hour_f['temp'])."\"";
$lang_idx = 1;
$JSON .= ",";
$JSON .= "\"cloth_title1\":"."\"".getClothTitle($hour_f['cloth'], $hour_f['temp'])."\"";
$JSON .= "},";
}

$JSON = trim($JSON, ",");
$JSON .= "]";
$JSON .= ",\"sigforecastHours\":[";
foreach ($sigforecastHour as $hour_f){
$JSON .= "{";
$JSON .= "\"currentDateTime\":"."\"".$hour_f['currentDateTime']."\"";
$JSON .= ",";
$JSON .= "\"date\":"."\"".date("j/m", $hour_f['currentDateTime'])."\"";
$JSON .= ",";
$JSON .= "\"plusminus\":"."\"".$hour_f['plusminus']."\"";
$JSON .= ",";
$JSON .= "\"time\":"."\"".$hour_f['time']."\"";
$JSON .= ",";
$JSON .= "\"wind\":"."\"".$hour_f['wind']."\"";
$JSON .= ",";
$JSON .= "\"wind_class\":"."\"".getWindInfo($hour_f['wind'], $lang_idx)['wind_class']."\"";
$JSON .= ",";
$JSON .= "\"wind_title0\":"."\"".getWindInfo($hour_f['wind'], 0)['windtitle']."\"";
$JSON .= ",";
$JSON .= "\"wind_title1\":"."\"".getWindInfo($hour_f['wind'], 1)['windtitle']."\"";
$JSON .= ",";
$JSON .= "\"icon\":"."\"".$hour_f['icon']."\"";
$JSON .= ",";
$JSON .= "\"temp\":"."\"".$hour_f['temp']."\"";
$JSON .= ",";
$JSON .= "\"cloth\":"."\"".$hour_f['cloth']."\"";
$JSON .= ",";
$JSON .= "\"title0\":"."\"".$hour_f['title'][0]."\"";
$JSON .= ",";
$JSON .= "\"title1\":"."\"".str_replace('\"', "&quot;", $hour_f['title'][1])."\"";
$JSON .= "},";
}

$JSON = trim($JSON, ",");
$JSON .= "]";
$JSON .= ",\"forecastDays\":[";
foreach ($forecastDaysDB as $day_f){
    $lang_idx = 0;
    $JSON .= "{";
    $JSON .= "\"day_name0\":"."\"".$day_f['day_name']."\"";
    $JSON .= ",";
    $JSON .= "\"TempHighClothTitle0\":"."\"".getClothTitle($day_f['TempHighCloth'], $day_f['TempHigh'])."\"";
    $JSON .= ",";
    $JSON .= "\"TempNightClothTitle0\":"."\"".getClothTitle($day_f['TempNightCloth'], $day_f['TempNight'])."\"";
    $JSON .= ",";
    $lang_idx = 1;
    $JSON .= "\"day_name1\":"."\"".replaceDays($day_f['day_name']." ")."\"";
    $JSON .= ",";
    $JSON .= "\"date\":"."\"".$day_f['date']."\"";
    $JSON .= ",";
    $JSON .= "\"TempLow\":"."\"".$day_f['TempLow']."\"";
    $JSON .= ",";
    $JSON .= "\"TempHigh\":"."\"".$day_f['TempHigh']."\"";
    $JSON .= ",";
    $JSON .= "\"TempNight\":"."\"".$day_f['TempNight']."\"";
    $JSON .= ",";
    $JSON .= "\"TempHighCloth\":"."\""."images/clothes/".$day_f['TempHighCloth']."\"";
    $JSON .= ",";
    $JSON .= "\"TempHighClothTitle1\":"."\"".getClothTitle($day_f['TempHighCloth'], $day_f['TempHigh'])."\"";
    $JSON .= ",";
    $JSON .= "\"TempNightCloth\":"."\""."images/clothes/".$day_f['TempNightCloth']."\"";
    $JSON .= ",";
    $JSON .= "\"TempNightClothTitle1\":"."\"".getClothTitle($day_f['TempNightCloth'], $day_f['TempNight'])."\"";
    $JSON .= ",";
    $JSON .= "\"icon\":"."\""."images/icons/day/".$day_f['icon']."\"";
    $JSON .= ",";
    $JSON .= "\"lang1\":"."\"".str_replace('"', '',urldecode($day_f['lang1']))."\"";
     $JSON .= ",";
    $JSON .= "\"lang0\":"."\"".urldecode($day_f['lang0'])."\"";
    $JSON .= "},";
}
$JSON = trim($JSON, ",");
$JSON .= "]";
$JSON .= ",\"Messages\":";
$JSON .= "{";
$JSON .= "\"detailedforecast0\":"."\"".urlencode(apc_fetch('descriptionforecast0'))."\"";
$JSON .= ",";
$JSON .= "\"detailedforecast1\":"."\"".urlencode(apc_fetch('descriptionforecast1'))."\"";
$JSON .= "}";

$JSON .= ",\"windstatus\":";
$JSON .= "{";
$windstatus = str_replace('"', "'", getWindStatus(0));
$JSON .= "\"lang0\":"."\"".$windstatus."\"";
$JSON .= ",";
$windstatus = str_replace('"', "'", getWindStatus(1));
$JSON .= "\"lang1\":"."\"".$windstatus."\"";
$JSON .= "}";

$itfeels = array();
$itfeels = $current->get_itfeels();
$JSON .= ",\"feelslike\":";
$JSON .= "{";
$JSON .= "\"state\":"."\"".$itfeels[0]."\"";
$JSON .= ",";
$JSON .= "\"value\":"."\"".$itfeels[1]."\"";
$JSON .= "}";

$JSON .= ",\"states\":";
$JSON .= "{";
$JSON .= "\"israining\":"."\"".isRaining()."\"";
$JSON .= ",";
$JSON .= "\"issnowing\":"."\"".isSnowing()."\"";
$JSON .= ",";
$JSON .= "\"lastUpdateMin\":"."\"".getLastUpdateMin()."\"";
$JSON .= ",";
if ((count($sig) > 1)){
    $sigtitle0 = $sig[0]['sig'][0];
    $sigtitle1 = $sig[0]['sig'][1];
    $sigext0 = $sig[0]['extrainfo'][0][0];
    $sigext0plain = $sig[0]['extrainfo'][0][1];
    $sigext1 = $sig[0]['extrainfo'][1][0];
    $sigext1plain = $sig[0]['extrainfo'][1][1];
}
$JSON .= "\"sigtitle0\":"."\"".$sigtitle0."\"";
$JSON .= ",";
$JSON .= "\"sigtitle1\":"."\"".$sigtitle1."\"";
$JSON .= ",";
$JSON .= "\"sigexthtml0\":"."\"".str_replace('"', "&quot;", $sigext0)."\"";
$JSON .= ",";
$JSON .= "\"sigext0\":"."\"".str_replace('"', "&quot;", $sigext0plain)."\"";
$JSON .= ",";
$JSON .= "\"sigexthtml1\":"."\"".str_replace('"', "&quot;", $sigext1)."\"";
$JSON .= ",";
$JSON .= "\"sigext1\":"."\"".str_replace('"', "&quot;", $sigext1plain)."\"";
$JSON .= "}";

$result = db_init("SELECT * FROM UserPicture where approved=1 order by uploadedAt DESC LIMIT 1","");
while ($line = $result["result"]->fetch_array(MYSQLI_ASSOC)) {
    $picname = "images/userpic/".$line["picname"];
    $JSON .= ",\"LatestUserPic\":";
    $JSON .= "{";
    $JSON .= "\"picname\":"."\"".$picname."\"";
    $JSON .= ",";
    $JSON .= "\"comment\":"."\"".urlencode($line["comment"])."\"";
    $JSON .= ",";
    $JSON .= "\"name\":"."\"".str_replace('"', "&quot;", $line["name"])."\"";
    $JSON .= ",";
    $JSON .= "\"passedts\":"."\"".(time() - filemtime($picname))."\"";
    $JSON .= "}";
}
try
{
if ($photoEntry != null) {
            $dateTakents = ($photoEntry->getExifTags()->getTime()->text)/1000;
             $dateTaken = getLocalTime($dateTakents);
}
}
catch (Exception $ex) {
    logger( "02wsjson exception:".$ex->getMessage());
}  
 
$JSON .= ",\"LatestPicOfTheDay\":";
    $JSON .= "{";
    $JSON .= "\"picurl\":"."\"".$mediumSizeUrl."\"";
    $JSON .= ",";
    $JSON .= "\"caption\":"."\"".urlencode($caption)."\"";
    $JSON .= ",";
    $JSON .= "\"passedts\":"."\"".(time() - $dateTakents)."\"";
    $JSON .= "}";

$JSON .= ",\"TAF\":";
$JSON .= "{";
$JSON .= "\"timetaf\":"."\"".apc_fetch("timetaf")."\"";
$JSON .= ",";
$JSON .= "\"dayF\":"."\"".$dayF."\"";
$JSON .= ",";
$JSON .= "\"monthF\":"."\"".$monthF."\"";
$JSON .= ",";
$JSON .= "\"yearF\":"."\"".$yearF."\"";
$JSON .= "}";

$JSON .= ",\"Adsense\":";
$JSON .= "{";
$JSON .= "\"adsense_color\":"."\"".$adsense_color."\"";
$JSON .= ",";
$JSON .= "\"adsense_background\":"."\"".$adsense_background."\"";
$JSON .= "}";

$JSON .= ",\"logo\":";
$JSON .= "{";
$JSON .= "\"logo0\":"."\"".$LOGO[0]."\"";
$JSON .= ",";
$JSON .= "\"logo1\":"."\"".$LOGO[1]."\"";
$JSON .= "}";

$JSON .= "}";
$JSON .= "}";
//$file = fopen($output_json_file_path,"w");
//@fwrite ($file, $JSON);
//@fclose ($file);
echo $JSON;
 ?>