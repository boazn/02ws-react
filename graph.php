<style>
	.trendstable
	{
		top:150px;
	}
	.paramvalue{
		font-size: 2.3em;
	}
    #baseGraph, #rainDailyGraph, .imgresponsive, iframe {
            width:315px
        }
    @media only screen and (min-width: 1500px) {
        #baseGraph, #rainDailyGraph, .imgresponsive, iframe {
            width:930px
        }
    }
    #moregraphs{ 
		list-style-type: bullet;float:<?=get_s_align();?>;margin-<?=get_s_align();?>:2em;margin-top:1em
	}
	#relatedgraphs{ 
		list-style-type: bullet;width: 180px;margin-<?=get_s_align();?>:3em;;margin-top:1em
	}
	#currentinfo_container
	{
		font-size: 1.2em;
		float:none;
		margin-bottom: 2em;
		background: white;
	}
	#latestrain .trendstable
	{
		top: 6.5em
	}
	#latestrain .paramtrend
	{
		top: 5.7em;
		font-size: 0.8em;
	}
	#latestrain .highlows
	{
		top:3.6em
	}
	.graphslink
	{
		visibility:hidden;
	}
    .inparamdiv{
		height:280px;
	}    
    #graphnav li a:hover{
		text-decoration: underline

	}
	#moregraphs li{
		line-height: 30px
	}
    
    
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
<script language="JavaScript" type="text/javascript">



function changeProfile (inprofile)
{
	//alert (inprofile);
	toggle('waiting');
	document.getElementById('hiddenProfile').value=inprofile;
	var loc = "<? echo get_url();?>";
	loc = loc.replace(/profile=\d/g, "profile=" + inprofile);
	top.location.href=loc;
	//document.profileChanger.action=loc;
	//document.profileChanger.submit();
	
}

</script>
<?
	ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE);
	if ($_GET['graph']=="OutsideTempHistory")
		$_GET['graph'] = 'temp.php';
	if ($_GET['graph']=="RainRateHistory")
		$_GET['graph'] = 'RainRateHistory.gif';
		
	function isMobile() {
		$useragent=$_SERVER['HTTP_USER_AGENT'];
		if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
		return true;
		else
		return false;
	}
		
	function getTrendID()
	{
		$trendID = "";
		if (strstr($_GET['graph'], 'Temp'))
			$trendID = "temptrends";
		else if (strstr($_GET['graph'], 'Hum'))
			$trendID = "humtrends";
		else if (strstr($_GET['graph'], 'Bar'))
			$trendID = "bartrends";
		else if (strstr($_GET['graph'], 'Wind'))
			$trendID = "windtrends";
		else if (strstr(strtolower($_GET['graph']), 'rain'))
			$trendID = "raintrends";

		return $trendID;
	}
 
function getLatestMaxMinTemp(){
	global $lang_idx;
	$query = "call getLatestMaxMinTemp()";
	$result = db_init($query, "");
	
	while ($line = $result["result"]->fetch_array(MYSQLI_ASSOC)) {
        echo "<tr class=\"inv_plain_2\"><td class=\"number\">".date("j/m/y", strtotime($line["Date"]))."</td><td style=\"text-align:center\"><span class=\"big number\">".$line["maxtemp2"]."</span></td><td style=\"text-align:center\"><span class=\"big number\">".$line["mintemp2"]."</span></td></tr>";
        
    }
	
}
function getLatestDailyRain()
{
    global $RAIN_UNIT, $lang_idx;
    echo "<table style=\"width:100%;text-align: center\">";
    $result = db_init("call GetLastDaysDailyRain()", "");
    while ($line = $result["result"]->fetch_array(MYSQLI_ASSOC)) {
        echo "<tr><td class=\"number\">".date("j/m/y", strtotime($line["Date"]))."</td><td><span class=\"big number\">".$line["dailyrain"]." ".$RAIN_UNIT[$lang_idx]."</span></td></tr>";
        
    }
    echo "</table>";
}
function GetLatestYearsRainForToday()
{
    global $RAIN_UNIT, $lang_idx, $seasonTillNow;
    echo "<table style=\"width:100%;text-align: center\">";
    $result = db_init("call GetLatestYearsRainForToday()", "");
    while ($line = $result["result"]->fetch_array(MYSQLI_ASSOC)) {
		 if ($line["rain"] > $seasonTillNow->get_rain2()) $diff_rain = "less"; else $diff_rain = "more";
        echo "<tr><td class=\"number\">".$line["dateAsToday"]."</td><td><span class=\"big number ".$diff_rain."\">".$line["rain"]." ".$RAIN_UNIT[$lang_idx]."</span></td></tr>";
        
    }
    echo "</table>";
}
function getExp()
{
		
		if (strstr(strtolower($_GET['graph']), 'chill'))
		{
			if (isHeb()) 
			{ 
				return "אפקט קרור הרוח הוא הטמפרטורה המוחשית שגוף האדם מרגיש. הטמפרטורה מתקבלת אחרי שקלול עוצמת הרוח עם הטמפרטורה האבסלוטית.<br/><div class=\"tbl\"><a href=\"http://www.nws.noaa.gov/om/windchill/\" target=\"_blank\">טבלת ווינד צ'יל והנוסחה לחישוב</a></div>";
			}
			else
			{
				return "WindChill is the temperature that the human body feels. It is calculated when we take into account the wind speed into the absolute temperature.<br/><div class=\"tbl\"><a href=\"http://www.nws.noaa.gov/om/windchill/\" target=\"_blank\">The wind chill formula and chart</a></div>";
			}
		}
		else if (strstr(strtolower($_GET['graph']), 'heat'))
		{
			if (isHeb()) 
			{ 
				return "עומס חום מתקבל אחרי שקלול הלחות היחסית עם הטמפרטורה האבסלוטית.		במצב של עומס חום כבד, עשויים עבודה גופנית או מאמץ גופני אחר לערער את המנגנונים האחראים לשמירת חום הגוף.		<div class=\"tbl\"><a href=\"http://www.wpc.ncep.noaa.gov/html/heatindex.shtml\" target=\"_blank\">מידע נוסף והנוסחה לחישוב עומס חום</a></div>";
			}
			else
			{
				return "Heat Index is the apparent temperature of exposed skin when exposed to air. Dry air allows evaporative cooling of the skin human body's surface. The higher the humidity, the less the skin can cool itself by evaporation. <div class=\"tbl\">	<a href=\"http://www.hpc.ncep.noaa.gov/html/heatindex.shtml\" target=\"_blank\">The formula and more info</a></div>";
			}
		}
		else if (strstr(strtolower($_GET['graph']), 'dew'))
		{
			if (isHeb()) 
			{ 
				return "נקודת הטל היא הטמפרטורה שתשרור אם נתקרר בלחץ קבוע וובכמות קבועה של לחות עד שנגיע ל-100% לחות יחסית. זהו מדד שמתאר את כמות הלחות, להבדיל מלחות יחסית. ככל שנקודת הטל גבוהה יותר כך כמות הלחות גבוהה יותר. ערכים של מעל 20 מעלות  הם לחות גבוהה. ערכים שליליים הם לחות נמוכה.";
			}
			else
			{
				return "Dew point is the temperature in which the relative humidity reaches 100%.";
			}
		}
		else if (strstr(strtolower($_GET['graph']), 'thw'))
		{
			if (isHeb()) 
			{ 
				return "זהו מדד המשלב  טמפרטורה ולחות המכניס לשכלול את אפקט הקרור של הרוח על הטמפרטורה המוחשית. במילים אחרות זהו מדד המראה את הטמפרטורה שאנו מרגישים על גופנו.";
			}
			else
			{
				return "The THW index uses humidity, temperature and wind to calculate an ambient temperature that incorporates the cooling impact of wind on our perception of temperature.";
			}
		}
		else if (strstr(strtolower($_GET['graph']), 'airdensity'))
		{
			if (isHeb()) 
			{ 
				return "צפיפות אוויר היא המסה ליחידת נפח של האטמוספירה.	<br/>	<div class=\"tbl\"><a href=\"http://selair.selkirk.bc.ca/aerodynamics1/Lift/Page4.html\" target=\"_blank\">השפעה של צפיפות אוויר על עילוי</a></div>";
			}
			else
			{
				return "Air density, is the mass per unit volume of Earth's atmosphere, and is a useful value in aeronautics.<br/><div class=\"tbl\"><a href=\"http://selair.selkirk.bc.ca/aerodynamics1/Lift/Page4.html\" target=\"_blank\">The effect of density of air on lift</a></div>";
			}
		}
		else if (strstr(strtolower($_GET['graph']), 'bar'))
		{
			if (isHeb()) 
			{ 
				return "לחץ-אטמוספרי הוא הכוח אשר מפעיל עמוד האוויר הנמצא מעל מקום מסוים על יחידת שטח. לחץ תקני: הלחץ הממוצע בגובה פני הים. 1013.3 מיליבר.";
			}
			else
			{
				return "Atmospheric pressure is the pressure above any area in the Earth's atmosphere caused by the weight of air on a square unit of the earth.";
			}
		}
		else if (strstr(strtolower($_GET['graph']), 'hum'))
		{
			if (isHeb()) 
			{ 
				return "לחות יחסית היא היחס בין כמות אדי המים באוויר לבין הכמות המקסימלית של אדי מים שיכול האוויר להכיל בטמפרטורה נתונה. ניתן לביטוי באמצעות יחס העירוב או לחץ האדים של המים. ";
			}
			else
			{
				return "Relative humidity is the ratio of the current vapor pressure of water in the air to the equilibrium vapor pressure, at which the gas is called saturated at the current temperature, expressed as a percentage. ";
			}
		}
		else if (strstr(strtolower($_GET['graph']), 'temp'))
		{
			if (isHeb()) 
			{ 
				return "מבחינה פיסיקלית הטמפרטורה הינה גודל המבטא את 'רמת התנועה' של חלקיקי החומר ומהווה מדד לאנרגיה הקינטית של החלקיקים";
			}
			else
			{
				return "Temperature is , physically, a measure of \"motion level\" of matter and ambiant photons, under the effect of thermal fluctuations.";
			}
		}
		else if (strstr(strtolower($_GET['graph']), 'rad'))
		{
			if (isHeb()) 
			{ 
				return "קרינת השמש הגלובלית, מידה של עוצמת קרני השמש הפוגעות בשטח אופקי";
			}
			else
			{
				return "Global Solar Radiation, a measure of the intensity of the sun’s radiation reaching a horizontal surface.";
			}
		}
		else if (strstr(strtolower($_GET['graph']), 'eth'))
		{
			if (isHeb()) 
			{ 
				return "אידוי פוטנציאלי הוא הסכום של אידוי מהאוויר והאדמה והאידוי מהצמחים. משמש בעיקר לצורכי חקלאות ותכנון השקיה. יכול לשמש גם ליעילות ייבוש כביסה";
			}
			else
			{
				return "Evapotranspiration (ET) is the sum of evaporation and plant transpiration from the Earth's land surface to atmosphere.";
			}
		}
                else if (strstr(strtolower($_GET['graph']), 'thsw'))
		{
			if (isHeb()) 
			{ 
				return "Parameters Used: Temperature, Humidity, Solar Radiation, Wind Speed, Latitude & Longitude,
Time and Date<br />
What is it:<br />
Like Heat Index, the THSW Index uses humidity and temperature to calculate an apparent
temperature. In addition, THSW incorporates the heating effects of solar radiation and the
cooling effects of wind (like wind chill) on our perception of temperature.<br />
Formula:<br />
The formula was developed by Steadman (1979). The following describes the series of
formulas used to determine the THSW or Temperature-Humidity-Sun-Wind Index. Thus, this
index indicates the level of thermal comfort including the effects of all these values.
This Index is calculated by adding a series of successive terms. Each term represents one of
the three parameters: (Humidity, Sun & Wind). The humidity term serves as the base from
which increments for sun and wind effects are added.<br />
The Vantage Pro and Vantage Pro2 calculation is an improvement over the THSW Index in the
Health EnviroMonitor because the Health system:<br />
• only calculates THSW Index when air temperature is at or above 68°F.<br />
• assumes the sky is clear.<br />
• assumes the elevation is sea level.<br />
<br />
HUMIDITY FACTOR<br />
<br />
The first term is humidity. This term is determined in the same manner as the Heat Index. This
term serves as a base number to which increments of wind and sun are added to come up with
the final THSW Index temperature.<br />
Note: Heat Index has also been referred to as \"Temperature-Humidity Index\" and \"Thermal
Index\" in some Davis products<br />
WIND FACTOR<br />
<br />
The second term is wind. Depending upon your version of firmware or software, this term is
determined in part by a lookup table (for temperatures above 50°F) and in part by the wind chill
calculation, or uses an integrated table that is used both for calculation of this term and for wind
chill. With this in mind, the following criterion apply with later versions referring to Vantage Pro2
console firmware revision May 2005 or later or WeatherLink version 5.6 or later:<br />
• At 0 mph, this term is equal to zero.<br />
• For temperatures at or above 68°F and wind speeds above 40 mph, the wind speed is set to
40 mph. For later versions, there is no upper limit on wind speed.<br />
• For temperatures at or above 130°F, this term is set equal to zero. For later versions of this
algorithm: WeatherLink uses 144°F as the threshold; Vantage Pro2 console firmware
143°F. This is based on a best-fit regression of the Steadman 1979 wind table. The
differences are reflective of the higher resolution used in the WeatherLink software. 
28 - 8 Rev A 5/11/06<br />
• For temperatures below 50°F (later versions use the new wind chill formula result here
(calculate the wind chill increment using the difference between the air temperature and
wind chill)):<br />
<br />
SUN FACTOR<br />
The third term is sun. This term, Qg, is actually a combination of four terms (direct incoming
solar, indirect incoming solar, terrestrial, and sky radiation). The term depends upon wind speed
to determine how strong an effect it is. The value is limited to between −20 and +130 W/m2
 in the Vantage Pro2 console firmware and WeatherLink software versions 5.6 or later.<br />
REFERENCES<br />
Steadman, R.G., 1979: The Assessment of Sultriness, Part II: Effects of Wind, Extra Radiation
and Barometric Pressure on Apparent Temperature. Journal of Applied Meteorology,
July 1979. ";
			}
			else
			{
				return "Parameters Used: Temperature, Humidity, Solar Radiation, Wind Speed, Latitude & Longitude,
Time and Date<br />
What is it:<br />
Like Heat Index, the THSW Index uses humidity and temperature to calculate an apparent
temperature. In addition, THSW incorporates the heating effects of solar radiation and the
cooling effects of wind (like wind chill) on our perception of temperature.<br />
Formula:<br />
The formula was developed by Steadman (1979). The following describes the series of
formulas used to determine the THSW or Temperature-Humidity-Sun-Wind Index. Thus, this
index indicates the level of thermal comfort including the effects of all these values.
This Index is calculated by adding a series of successive terms. Each term represents one of
the three parameters: (Humidity, Sun & Wind). The humidity term serves as the base from
which increments for sun and wind effects are added.<br />
The Vantage Pro and Vantage Pro2 calculation is an improvement over the THSW Index in the
Health EnviroMonitor because the Health system:<br />
• only calculates THSW Index when air temperature is at or above 68°F.<br />
• assumes the sky is clear.<br />
• assumes the elevation is sea level.<br />
<br />
HUMIDITY FACTOR<br />
<br />
The first term is humidity. This term is determined in the same manner as the Heat Index. This
term serves as a base number to which increments of wind and sun are added to come up with
the final THSW Index temperature.<br />
Note: Heat Index has also been referred to as \"Temperature-Humidity Index\" and \"Thermal
Index\" in some Davis products<br />
WIND FACTOR<br />
<br />
The second term is wind. Depending upon your version of firmware or software, this term is
determined in part by a lookup table (for temperatures above 50°F) and in part by the wind chill
calculation, or uses an integrated table that is used both for calculation of this term and for wind
chill. With this in mind, the following criterion apply with later versions referring to Vantage Pro2
console firmware revision May 2005 or later or WeatherLink version 5.6 or later:<br />
• At 0 mph, this term is equal to zero.<br />
• For temperatures at or above 68°F and wind speeds above 40 mph, the wind speed is set to
40 mph. For later versions, there is no upper limit on wind speed.<br />
• For temperatures at or above 130°F, this term is set equal to zero. For later versions of this
algorithm: WeatherLink uses 144°F as the threshold; Vantage Pro2 console firmware
143°F. This is based on a best-fit regression of the Steadman 1979 wind table. The
differences are reflective of the higher resolution used in the WeatherLink software. 
28 - 8 Rev A 5/11/06<br />
• For temperatures below 50°F (later versions use the new wind chill formula result here
(calculate the wind chill increment using the difference between the air temperature and
wind chill)):<br />
<br />
SUN FACTOR<br />
The third term is sun. This term, Qg, is actually a combination of four terms (direct incoming
solar, indirect incoming solar, terrestrial, and sky radiation). The term depends upon wind speed
to determine how strong an effect it is. The value is limited to between −20 and +130 W/m2
 in the Vantage Pro2 console firmware and WeatherLink software versions 5.6 or later.<br />
REFERENCES<br />
Steadman, R.G., 1979: The Assessment of Sultriness, Part II: Effects of Wind, Extra Radiation
and Barometric Pressure on Apparent Temperature. Journal of Applied Meteorology,
July 1979. ";
			}
		}
		else if (strstr(strtolower($_GET['graph']), 'uvdose'))
		{
			if (isHeb()) 
			{ 
				return "הכמות של החשיפה לשמש הדרושה להפיכת העור לאדום. ";
			}
			else
			{
				return "MED stands for Minimum Erythemal Dose, defined as the amount of sunlight exposure necessary to induce a barely perceptible redness of the skin within 24 hours after sun exposure. In other words, exposure to 1 MED will result in a reddening of the skin. Because different skin types burn at different rates, 1 MED for persons with very dark skin is different from 1 MED for persons with very light skin.";
			}
		}
		else if (strstr(strtolower($_GET['graph']), 'uv'))
		{
			if (isHeb()) 
			{ 
				return "אינדקס מ-0 ועד 16 הנועד לציין את הסיכון לעור חשוף בשמש ללא הגנה. ערכים מעל 8 הם כבר גבוהים. הסכנה לעור תלויה בסוג העור ובמשך החשיפה.";
			}
			else
			{
				return "Energy from the sun reaches the earth as visible, infrared, and ultraviolet (UV) rays. Exposure to UV rays can cause numerous health problems, such as sun burn, skin cancer, skin aging, and cataracts, and can suppress the immune system. A scale ranging from 0 to 16, used in estimating the risk for sunburn that an unprotected fair-skinned person would have if exposed to the ultraviolet radiation";
			}
		}
		else if (strstr(strtolower($_GET['graph']), 'solarenergy'))
		{
			if (isHeb()) 
			{ 
				return "הכמות המצטברת של קרינת השמש על פני זמן";
			}
			else
			{
				return "The amount of accumulated solar radiation energy over a period of time is measured in Langleys. 

1 Langley  = 11.622 Watt-hours per square meter

 = 3.687 BTUs per square foot

 = 41.84 kilojoules per square meter

";
			}
		}
		return "";

}
function getBorder ($graphUrl)
{
			
	if (strstr($_GET['graph'],$graphUrl))
	{
		if (isHeb())
		return " class=\"heb inv_plain_2\"";
			else
		return " class=\"inv_plain_2\"";
	}
	if (isHeb())
		return " class=\"heb inv_plain_3_zebra\"";
			else
		return " class=\"inv_plain_3_zebra\"";
}
?>
<div id="latestparam" class="inparamdiv" <? if (isHeb()) echo "dir=\"rtl\" ";?> style="display:none">
    <div class="paramtitle slogan">
             
         </div>
        <div class="paramvalue">
             
         </div>
         <div class="highlows">
                 <div class="highparam"><strong></strong></div>&nbsp;<img src="img/peak_max.png" width="15" height="14" alt=""/>&nbsp;<span class="high_time"></span>
                 <div class="lowparam"><strong></strong></div>&nbsp;<img src="img/peak_min.png" width="15" height="14" alt=""/>&nbsp;<span class="low_time"></span>
         </div> 
         <div class="paramtrend relative">
             <div class="innertrendvalue">
                <? echo " ".($MINTS[$lang_idx]).": "; ?>
             </div>
         </div>  
   <div class="trendstable"> 
        <table>
                 <tr class="trendstitles">
                         <td  class="box" title=""><img src="img/24_icon.png" width="21" height="21" alt=""/></td>
                         <td  class="box" title=""><img src="img/hour_icon.png" width="21" height="21" alt="hour"/></td>
                         <td  class="box" title=""><img src="img/half_icon.png" width="21" height="21" alt="half hour"/></td>
                 </tr>
                 <tr class="trendsvalues">
                     <td><div class="trendvalue"><div class="innertrendvalue"></div></div></td>
                     <td ><div clas s="trendvalue"><div class="innertrendvalue"></div></div></td>
                     <td ><div class="trendvalue"><div class="innertrendvalue"></div></div></td>
                 </tr>
         </table>
    </div>
</div>
<?
if ((strstr(strtolower($_GET['graph']), 'temp'))||
	(strstr(strtolower($_GET['graph']), 'windchill'))||
	(strstr(strtolower($_GET['graph']), 'heatindex'))||
        (strstr(strtolower($_GET['graph']), 'thsw'))||
	(strstr(strtolower($_GET['graph']), 'dew'))||
	(strstr(strtolower($_GET['graph']), 'thw'))||
	(strstr(strtolower($_GET['graph']), 'airdensity')))
{
	echo "<ul id=\"graphnav\" class=\"nav\" ";
	if (isHeb()) echo "dir=\"rtl\"";
	echo ">";
	echo "<li".getBorder("temp.php")." ><a href=\"".get_query_edited_url(get_url(), 'graph', 'temp.php')."\" title=\"".$GRAPH[$lang_idx]."\">".$TEMP[$lang_idx]." ".$VALLEY[$lang_idx].": <span dir=\"ltr\" >".$current->get_temp2()."&#176; </span>"."</a></li>";
	echo "<li".getBorder("tempLatestArchive.php")." ><a href=\"".get_query_edited_url(get_url(), 'graph', 'tempLatestArchive.php')."\" title=\"".$GRAPH[$lang_idx]."\">".$TEMP[$lang_idx]." ".$MOUNTAIN[$lang_idx].": <span dir=\"ltr\" >".$current->get_temp()."&#176; </span>"."</a></li>";
	echo "<li".getBorder("temp3.php")." ><a href=\"".get_query_edited_url(get_url(), 'graph', 'temp3.php')."\" title=\"".$GRAPH[$lang_idx]."\">".$TEMP[$lang_idx]." ".$ROAD[$lang_idx].": <span dir=\"ltr\" >".$current->get_temp3()."&#176;</span>"."</a></li>";
	if (($current->get_temp2() <= 16)||($current->get_temp() <= 16))
            echo "  <li".getBorder("tempwchill.php")." ><a href=\"".get_query_edited_url(get_url(), 'graph', 'tempwchill.php')."\" title=\"".$GRAPH[$lang_idx]."\">".$WIND_CHILL[$lang_idx]." ".$VALLEY[$lang_idx].": <span dir=\"ltr\" >".$current->get_windchill()."&#176;"."</span>"."</a></li>";
	if (($current->get_temp2() > 23)||($current->get_temp() > 23))
            echo "  <li".getBorder("tempheat.php")." ><a href=\"".get_query_edited_url(get_url(), 'graph', 'tempheat.php')."\" title=\"".$GRAPH[$lang_idx]."\">".$HEAT_IDX[$lang_idx].": <span dir=\"ltr\" >".$current->get_HeatIdx()."&#176;"."</span>"."</a></li>";
	echo "  <li id=\"thwtab\" ".getBorder("THWHistory.gif")." ><a href=\"".get_query_edited_url(get_url(), 'graph', 'THWHistory.gif')."\" title=\"".$GRAPH[$lang_idx]."\">".$THW[$lang_idx]." ".$VALLEY[$lang_idx].": <span dir=\"ltr\" >".$current->get_thw()."&#176;"."</span>"."</a></li>";
        echo "  <li id=\"thswtab\" ".getBorder("THSWHistory.gif")." ><a href=\"".get_query_edited_url(get_url(), 'graph', 'THSWHistory.gif')."\" title=\"".$GRAPH[$lang_idx]."\">".$THSW[$lang_idx].": <span dir=\"ltr\" >".$current->get_thsw()."&#176;"."</span>"."</a></li>";
	echo "  <li".getBorder("dewptLatestArchive.php")." ><a href=\"".get_query_edited_url(get_url(), 'graph', 'dewptLatestArchive.php')."\" title=\"".$GRAPH[$lang_idx]."\">".$DEW[$lang_idx].": <span dir=\"ltr\" >".$current->get_dew()."&#176;"."</span>"."</a></li>";
	echo "  <li".getBorder("AirDensityHistory.gif")." ><a href=\"".get_query_edited_url(get_url(), 'graph', 'AirDensityHistory.gif')."\" title=\"".$GRAPH[$lang_idx]."\">".$AIR_DENSITY[$lang_idx]."</a></li>";
	echo "</ul>";
}
else if (strstr(strtolower($_GET['graph']), 'rain'))
{
	echo "<ul id=\"graphnav\" class=\"nav\" ";
	if (isHeb()) echo "dir=\"rtl\"";
	echo ">";
	echo "<li".getBorder("rain.php")." ><a href=".get_query_edited_url(get_url(), 'graph', 'rain.php&level='.($_REQUEST['profile'])).">".$RAIN[$lang_idx]."</a></li>";
	echo "<li".getBorder("RainRateHistory.gif")." ><a href=".get_query_edited_url(get_url(), 'graph', 'RainRateHistory.gif').">".$RAINRATE[$lang_idx]."</a></li>";
	echo "</ul>";
}
else if (strstr(strtolower($_GET['graph']), 'wind')&&(!strstr(strtolower($_GET['graph']), 'humwind')))
{
	echo "<ul id=\"graphnav\" class=\"nav\" ";
	if (isHeb()) echo "dir=\"rtl\"";
	echo ">";
	echo "<li".getBorder("wind.php")."><a href=".get_query_edited_url(get_url(), 'graph', 'wind.php?level='.($_REQUEST['profile'])).">".$WIND_SPEED[$lang_idx]."</a></li>";
	echo "<li".getBorder("WindDirectionHistory.gif")."><a href=".get_query_edited_url(get_url(), 'graph', 'WindDirectionHistory.gif?level='.($_REQUEST['profile'])).">".$WIND_DIR[$lang_idx]."</a></li>";
	echo "<li".getBorder("HiWindSpeedHistory.gif")."><a href=".get_query_edited_url(get_url(), 'graph', 'HiWindSpeedHistory.gif').">".$WIND_HIGH[$lang_idx]."</a></li>";
	echo "<li".getBorder("HighWindDirHistory.gif")."><a href=".get_query_edited_url(get_url(), 'graph', 'HighWindDirHistory.gif').">".$WIND_HIGH_DIR[$lang_idx]."</a></li>";
	echo "<li".getBorder("WindRunHistory.gif")."><a href=".get_query_edited_url(get_url(), 'graph', 'WindRunHistory.gif').">".$WIND_RUN[$lang_idx]."</a></li>";
	echo "</ul>";
}
else if ((strstr(strtolower($_GET['graph']), 'uv'))||
         (strstr(strtolower($_GET['graph']), 'rad'))||
	(strstr(strtolower($_GET['graph']), 'solar'))||
	(strstr(strtolower($_GET['graph']), 'eth')))
{
	echo "<ul id=\"graphnav\" class=\"nav\" ";
	if (isHeb()) echo "dir=\"rtl\"";
	echo ">";
	echo "  <li".getBorder("UVHistory.gif")." ><a href=\"".get_query_edited_url(get_url(), 'graph', 'UVHistory.gif')."\" title=\"".$GRAPH[$lang_idx]."\">".$UV[$lang_idx].": <span dir=\"ltr\" >".$current->get_uv()."</span>"."</a></li>";
	echo "  <li".getBorder("HighUVHistory.gif")." ><a href=\"".get_query_edited_url(get_url(), 'graph', 'HighUVHistory.gif')."\" title=\"".$GRAPH[$lang_idx]."\">".$UV[$lang_idx]." - ".$HIGH[$lang_idx]."<span dir=\"ltr\" >"."</span>"."</a></li>";
	echo "  <li".getBorder("UVDoseHistory.gif")." ><a href=\"".get_query_edited_url(get_url(), 'graph', 'UVDoseHistory.gif')."\" title=\"".$GRAPH[$lang_idx]."\">".$UV_DOSE[$lang_idx]."<span dir=\"ltr\" >"."</span>"."</a></li>";
	echo " <li".getBorder("rad.php")." ><a href=\"".get_query_edited_url(get_url(), 'graph', 'rad.php?level='.($_REQUEST['profile']))."\" title=\"".$GRAPH[$lang_idx]."\">".$RADIATION[$lang_idx].": <span dir=\"ltr\" >".$current->get_solarradiation()." W/m2"."</span>"."</a></li>";
	echo " <li".getBorder("HighSolarRadHistory.gif")." ><a href=\"".get_query_edited_url(get_url(), 'graph', 'HighSolarRadHistory.gif')."\" title=\"".$GRAPH[$lang_idx]."\">".$RADIATION[$lang_idx]." - ".$HIGH[$lang_idx]."</a></li>";
	echo " <li".getBorder("SolarEnergyHistory.gif")." ><a href=\"".get_query_edited_url(get_url(), 'graph', 'SolarEnergyHistory.gif')."\" title=\"".$GRAPH[$lang_idx]."\">".$SOLAR_ENERGY[$lang_idx]."</a></li>";
	echo "<li".getBorder("ETHistory.gif")." ><a href=\"".get_query_edited_url(get_url(), 'graph', 'ETHistory.gif')."\" title=\"".$GRAPH[$lang_idx]."\">".$ET[$lang_idx].": <span dir=\"ltr\" >".$today->get_et()." mm"."</span>"."</a></li>";
	echo "</ul>";
}
?>
 
<div id="graphmain"  class="<?if ($_GET["graph"] != "AirDensityHistory.gif") echo "inv_plain_2"; ?>">
<hr id="graphs_line" style="display:none" />
<div id="exp" class="float exp inv_plain_3_zebra" style="width:95%;">
		<? echo getExp();?>
 </div>
<div id="graphsportal" class="float " >	
	 <div id="graphImage" class="float"> 
		<? 
                        $graph = $_GET['graph'];
			if (isset($_POST['profile'])){
				$profile = $_POST['profile'];
			}
			if ($profile == 1)
			  $datasource = "&amp;datasource=downld02";
			  else
		    if ($profile == 2)
			  $datasource = "&amp;datasource=downld08"; //$datasource = "&amp;datasource=downld08";
			  else
			  $datasource = "&amp;datasource=downld08";
                   if ((strstr($_GET['graph'], 'Latest'))&&($profile <3))
                           $datasource = "&amp;datasource=LatestArchive.csv"; 
                   
                   if ((strstr($graph, 'tempLatest'))&&($profile >3))
                       $graph  = "temp.php";   
                           
                           
                 ?>
		<? if (($profile <=3)|| ((strstr(strtolower($_GET['graph']), 'uv'))||
	(strstr(strtolower($_GET['graph']), 'solar'))||
	(strstr(strtolower($_GET['graph']), 'eth')))) {?>
                <a class="enlarge" href="images/profile<? echo $_REQUEST['profile']."/".$graph;?>?level=<?=($_REQUEST['profile'])?>&amp;freq=2<?=$datasource?>&amp;w=1600&amp;lang=<?=$lang_idx?>" target="_system" title="click to enlarge">
                <span></span>
		<img name="baseGraph" id="baseGraph" src="https://www.02ws.co.il/images/profile<? echo $_REQUEST['profile']."/".$graph;?>?level=<?=($_REQUEST['profile'])?>&amp;freq=2<?=$datasource?>&amp;lang=<?=$lang_idx?>" alt="<? echo getPageTitle()?>" <? if (strstr($_GET['graph'], 'Hum')) echo "class=\"inv_plain\"";?> style="padding:0;margin:0"/>
                </a>
		<?} else{ if (isHeb()) $lang="&lang=he"; if (isMobile()) $w = "290"; else $w="850"; ?>
		<iframe src="https://www.02ws.co.il/wxwugraphs/graphy1a.php?y=<?=$year?>&theme=default&w=<?=$w.$lang?>" height="482"></iframe>
		<?} ?>
		</div>
                <form method="post" name="profileChanger" action="" style="" <? if (isHeb()) echo "dir=\"rtl\""; ?> style="padding:1em">
				<? echo "&nbsp;&nbsp;".$GRAPH[$lang_idx]." ".$FOR[$lang_idx];?>
				<select size="1" id="profile" name="profile" class="inv_plain_3_zebra" onchange="changeProfile(this.options[this.selectedIndex].value)" <? if (isHeb()) echo "dir=\"rtl\""; ?>> 
						<option	<? if ($_REQUEST['profile'] == "1") echo " selected ";?> value="1"><? echo $TODAY[$lang_idx];?></option>
						<option	<? if ($_REQUEST['profile'] == "2") echo " selected ";?> value="2">3 <? echo $DAYS[$lang_idx];?></option>
						<option	<? if ($_REQUEST['profile'] == "3") echo " selected ";?> value="3"><? echo $LAST_WEEK[$lang_idx];?></option>
						<option	<? if ($_REQUEST['profile'] == "4") echo " selected ";?> value="4"><? echo $LAST_MONTH[$lang_idx];?></option>
						<option	<? if ($_REQUEST['profile'] == "5") echo " selected ";?> value="5">3 <? echo $MONTHS[$lang_idx];?></option>
						<option	<? if ($_REQUEST['profile'] == "6") echo " selected ";?> value="6"><? echo $YEARLY[$lang_idx];?></option>
				</select>
                <input type="hidden" name="myPHPvar" id="hiddenProfile" value="" />
                </form>
                <ul id="moregraphs">
                <li><a href="/wxwugraphs/graphy1a.php?y=<?=$year?>&theme=default&w=1020&h=500" rel="external"><? echo $BY_DATE[$lang_idx];?></a></li>
                <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'latest.php');?>" class="hlink"><? echo $ALL_GRAPHS[$lang_idx]." - ".$TODAY[$lang_idx];?></a></li>
                <li><a href="<? echo get_query_edited_url($url_cur, 'section', '2weeks.php');?>" class="hlink"><? echo $ALL_GRAPHS[$lang_idx]." - ".$LAST_WEEK[$lang_idx];?></a></li>
                <li><a href="<? echo get_query_edited_url($url_cur, 'section', 'month.php');?>" class="hlink"><? echo $ALL_GRAPHS[$lang_idx]." - ".$LAST_MONTH[$lang_idx];?></a></li>
                <li><a href="<? echo get_query_edited_url($url_cur, 'section', '3months.php');?>" class="hlink"><? echo $ALL_GRAPHS[$lang_idx]." - 3 ".$MONTHS[$lang_idx];?></a></li>
                </ul>
				<ul class="float" id="relatedgraphs">
                    <li><a href="<? echo get_query_edited_url($url_cur, 'graph', 'tempheat.php');?>"><?=$TEMP[$lang_idx]."/".$HEAT_IDX[$lang_idx];?></a></li>
                    <li><a href="<? echo get_query_edited_url($url_cur, 'graph', 'temp.php');?>"><?=$TEMP[$lang_idx]." ".$VALLEY[$lang_idx]."/".$HUMIDITY[$lang_idx];?></a></li>
					<li><a href="<? echo get_query_edited_url($url_cur, 'graph', 'tempMtempV.php');?>"><?=$TEMP[$lang_idx]." ".$VALLEY[$lang_idx]."/".$MOUNTAIN[$lang_idx];?></a></li>
					<li><a href="<? echo get_query_edited_url($url_cur, 'graph', 'temp3temp1.php');?>"><?=$TEMP[$lang_idx]." ".$ROAD[$lang_idx]."/".$MOUNTAIN[$lang_idx];?></a></li>
                    <li><a href="<? echo get_query_edited_url($url_cur, 'graph', 'windtemp.php');?>"><?=$TEMP[$lang_idx]."/".$WIND[$lang_idx];?></a></li>
                    <li><a href="<? echo get_query_edited_url($url_cur, 'graph', 'barorain.php');?>"><?=$RAIN[$lang_idx]."/".$BAR[$lang_idx];?></a></li>
              </ul>
                <?
			
            if (strstr(strtolower($_GET['graph']), 'hum'))
            { $alternategraph = "OutsideHumidityHistory.gif";$alternategraphtitle=$HUMIDITY[$lang_idx];}
            else if (strstr(strtolower($_GET['graph']), 'rain'))
            { $alternategraph = "RainHistory.gif";$alternategraphtitle=$RAIN[$lang_idx];}
            else if (strstr(strtolower($_GET['graph']), 'bar'))
            { $alternategraph = "BarometerHistory.gif";$alternategraphtitle=$BAR[$lang_idx];}
            else if (strstr(strtolower($_GET['graph']), 'heat'))
            { $alternategraph = "HeatIndexHistory.gif";$alternategraphtitle=$HEAT_IDX[$lang_idx];}
            else if (strstr(strtolower($_GET['graph']), 'chill'))
            { $alternategraph = "WindChillHistory.gif";$alternategraphtitle=$WIND_CHILL[$lang_idx];}
            else if (strstr(strtolower($_GET['graph']), 'wind'))
            { $alternategraph = "WindSpeedHistory.gif";$alternategraphtitle=$WIND_SPEED[$lang_idx];}
            else if (strstr(strtolower($_GET['graph']), 'dew'))
            { $alternategraph = "DewPointHistory.gif";$alternategraphtitle=$DEW[$lang_idx];}
            else
            { $alternategraph = "OutsideTempHistory.gif"; $alternategraphtitle=$TEMP[$lang_idx];}
            ?>
            <div class="float" id="additionalgraphs" style="padding:1em 1em">
                    <a href="images/profile<? echo $_REQUEST['profile']."/".$alternategraph;?>" class='colorbox' title="<?=$alternategraphtitle?>">
                    <img name="alternateGraph" id="alternateGraph" src="./images/profile<? echo $_REQUEST['profile']."/".$alternategraph;?>" width="290" alt="<?=$alternategraphtitle?>" style="padding:0;margin:0"/>
                    </a>
                    <div class="small" style="padding:0"><?=$alternategraphtitle?></div>
            </div>
                       
	  

<!--
<div class="float" style="margin:1.8em 0.1em">
		<div id="adunit2">
		<!-- small unit 2 --><!--
            <ins class="adsbygoogle"
                 style="display:inline-block;width:320px;height:50px"
                 data-ad-client="ca-pub-2706630587106567"
                 data-ad-slot="3726818696"></ins>
            <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
		</div>
</div>
-->
<?
/*
*  temp extensions
*
*/
if ((strstr(strtolower($_GET['graph']), 'temp'))||
	(strstr(strtolower($_GET['graph']), 'windchill'))||
	(strstr(strtolower($_GET['graph']), 'heatindex'))||
	(strstr(strtolower($_GET['graph']), 'thw'))||
        (strstr(strtolower($_GET['graph']), 'thsw'))||
	(strstr(strtolower($_GET['graph']), 'airdensity')))
{ 
	$temptHours = 24;
	if (isset($_POST['button']))
		$temptHours = $_POST['temptHours'];
	if (!$error_db)
	{
		include_once ("requiredDBTasks.php");
	}
?>

<? }
if (strstr(strtolower($_GET['graph']), 'temp'))
{	 ?>
	<div class="float" style="margin:1em 0.5em;<? if (isHeb()) echo "direction:rtl"; ?>" class="inv_plain_2_zebra" >
	<table <? if (isHeb()) echo "dir=\"rtl\""; ?> id="mouseover" cellpadding="4">
	
	<tr>
		
		
		<td class="topbase"></td>
		<td  class="topbase"><? echo($MAX[$lang_idx]);?> <? echo($TEMP[$lang_idx]);?></td>
		<td  class="topbase"><? echo($MIN[$lang_idx]);?> <? echo($TEMP[$lang_idx]);?></td>
	</tr>
	
	<tr class="inv_plain_2">
		<td><a href="<? echo get_query_edited_url(get_url(), 'section', 'averages');?>"  class="hlink" target="_self" title="<? echo $AVERAGE[$lang_idx];?>"><? echo($NORMAL[$lang_idx])." - ".$monthInWord;?></a></td>
		<td class=" number"><? if (!$error_db) echo $monthAverge->get_hightemp();?><div class="paramunit">&#176;</div><div class="param"><? echo $current->get_tempunit(); ?></div></td>
		<td class=" number"><?  if (!$error_db) echo $monthAverge->get_lowtemp();?><div class="paramunit">&#176;</div><div class="param"><? echo $current->get_tempunit(); ?></div></td>
	</tr>
	<tr class="inv_plain_2">
		
		<td><? echo($TODAY[$lang_idx]);?></td>
        <td class=" number"><? echo toLeft($today->get_hightemp()); ?><div class="paramunit">&#176;</div><div class="param"><? echo $current->get_tempunit(); ?></div><br/> <? echo " [".$today->get_hightemp_time()."] "; ?></td>
		<td class=" number"><? echo toLeft($today->get_lowtemp()); ?><div class="paramunit">&#176;</div><div class="param"><? echo $current->get_tempunit(); ?></div><br/><? echo " [".$today->get_lowtemp_time()."] "; ?></td>
	</tr>
	<tr class="inv_plain_2">
		<td><a href="<? echo get_query_edited_url($url_cur, 'section', 'reports/downld02.txt');?>" class="hlink" target="_self" title="temp today compared to its month's average"><? echo($YESTERDAY[$lang_idx]);?></a></td>
        <td class=" number"><?echo $yest->get_hightemp();?><div class="paramunit">&#176;</div><div class="param"><? echo $current->get_tempunit(); ?></div></td>
		<td class=" number"> <?echo $yest->get_lowtemp();?><div class="paramunit">&#176;</div><div class="param"><? echo $current->get_tempunit(); ?></div></td>
		
		</tr>
		
                    <? getLatestMaxMinTemp(); ?>
     
	</table>
	
</div>	
	<!-- <form method="POST" name="temptHoursDist" style="background:transparent;" <? if (isHeb()) echo "DIR=rtl"; ?>>
	<input type="submit" name="button" value="<? echo $SHOW[$lang_idx];?>" width=22 title="go" border=0>
	<INPUT TYPE="text" NAME="temptHours" VALUE='<? echo $temptHours;?>' SIZE=1 border=1 style="background:transparent;color:white">
	<? echo $HOURS[$lang_idx]; ?> <? echo $TEMP[$lang_idx]; ?>/<? echo $DEW[$lang_idx]; ?>
	</form> -->

	<!-- <img src=\"http://www.findu.com/cgi-bin/temp.cgi?call=CW0641&last=<? echo $temptHours; ?>&xsize=480&ysize=200&units=metric\" style=\"background:white\"> -->
<? } ?>
	
<? 
	
						

/*
*  Humidity extensions
*
*/
if (strstr(strtolower($_GET['graph']), 'hum')){
	 if (!$error_db)
	{
		include_once ("requiredDBTasks.php");
	}
	?>
       
	<div class="float" style="margin:1em;<? if (isHeb()) echo "direction:rtl"; ?>" class="inv_plain_2_zebra">
	<table <? if (isHeb()) echo "dir=\"rtl\""; ?> id="mouseover" cellpadding="4">
	<tr>
		<td></td>
		<td></td>
		<td class="topbase"><? echo($TODAY[$lang_idx]);?></td>
		<td  class="topbase"><a href="<? echo get_query_edited_url(get_url(), 'section', 'averages');?>"  class="hlink" target="_self" ><? echo($NORMAL[$lang_idx])." - ".$monthInWord;?></a></td>
		<td  class="topbase"><? echo($DIFF_FROM[$lang_idx]);?> <a href="<? echo get_query_edited_url(get_url(), 'section', 'averages');?>" ><? echo($NORMAL[$lang_idx]);?></a></td>
	
	</tr>
	<tr class="inv_plain_2">
		<td class="inv_plain_2"><? echo "[".$today->get_highhum_time()."] "; ?></td>
		<td><? echo($MAX[$lang_idx]);?> <? echo($HUMIDITY[$lang_idx]);?></td>
		<td class="high"><? echo toLeft($today->get_highhum()."%"); ?></td>
		 <td><a href="" class="info">
				<?echo $monthAverge->get_highhum(),"%";?>
				<span class="info"></span>
			 </a>
		 </td>
		
		<td><a href="" class="info">
				<? if (!$error_db) echo get_param_tag($highhum_diffFromAv, true)."%";?>
				<span class="info"><? echo($TODAY[$lang_idx]);?> <?echo $today->get_highhum(),"%";?>  <br /><?  if (!$error_db) echo $monthInWord.": ".$monthAverge->get_highhum(),"%";?> </span>
			</a>
		</td>
		
		
	</tr>
	<tr class="inv_plain_2">
		<td class="inv_plain_2"><? echo "[".$today->get_lowhum_time()."] "; ?></td>
		<td><? echo($MIN[$lang_idx]);?> <? echo($HUMIDITY[$lang_idx]);?></td>
		<td class="low"><? echo toLeft($today->get_lowhum()."%"); ?></td>
		<td><a href="" class="info">
				<?echo $monthAverge->get_lowhum(),"%";?>
				<span class="info"></span>
			 </a>
		</td>
		<td>
			<a href="" class="info">
					<? if (!$error_db) echo get_param_tag($lowhum_diffFromAv, true)."%"; ?>
					<span class="info"><? echo($TODAY[$lang_idx]);?> <?echo $today->get_lowhum(),"%";?><br /><? if (!$error_db) echo $monthInWord.": ".$monthAverge->get_lowhum(),"%";?> </span>
				</a>
		</td>
		
		
	</tr>
	</table>
	</div>
<? } 
/*
*  Wind extensions
*
*/
if ((strstr(strtolower($_GET['graph']), 'wind'))&&(!strstr(strtolower($_GET['graph']), 'windchill'))&&(!strstr(strtolower($_GET['graph']), 'humwind')))
{
	
	$windDisH = 6;
	if (isset($_POST['button']))
		$windDisH = $_POST['WindDistHours'];
?>

<a name="windd"></a>

<script language="JavaScript" type="text/javascript">
		var expDiv = document.getElementById('exp');
		var highWind = document.getElementById('highWind');
		expDiv.innerHTML = highWind.innerHTML;
		expDiv.style.height = "70px";
		highWind.style.display = 'none';
				
</script>
<div style="float:<?echo get_s_align();?>;margin:2em">
<form method="post" name="WindDist" style="background:transparent;" action="#windd">
	<input type="submit" name="button" value="<? echo $SHOW[$lang_idx];?>" width="22" title="go" border="0" />
	<input type="text" name="WindDistHours" value='<? echo $windDisH;?>' size="1" border="1" style="background:transparent;" class="inv_plain_2" />
	<?=$WIND_DISTRIBUTION[$lang_idx]?>
</form>

<?
	
	echo "<img src=\"http://www.findu.com/cgi-bin/windstar.cgi?call=CW0641&last=$windDisH&xsize=200&ysize=200&units=metric\" alt=\"\" /></div>";
	

}

/*
*  Rain extensions
*
*/
if (strstr(strtolower($_GET['graph']), 'rain'))
{
        $storm->set_rain(getStormRain());
	$rainAcc = 12;
	if (isset($_POST['button']))
		$rainAcc = $_POST['rainAccHours'];
  
               
?>

<div id="avRain" class="float inv_plain_2_zebra number" style="margin:1em 2em;width:400px;">
	<?	include "averageRain.php";?>
</div>
<div class="float">
<a class="enlarge" href="dailyRainGraph.php?datasource=RainDaily&amp;w=1600" target="_system" title="click to enlarge">
		<span></span>
<img name="rainDailyGraph" id="rainDailyGraph" src="dailyRainGraph.php?datasource=RainDaily" alt="rain-average" style="padding:0;margin:0"/>
</a>
</div>

<div class="inv_plain_2 float " id="highRainRate" style="margin:0em;padding:0.1em;width:315px;clear:both" <? if (isHeb()) echo "dir=\"rtl\""; ?>>
	
	   
        <div class="inv_plain_3_zebra" >
        <? echo $MAX[$lang_idx]." ".$RAINRATE[$lang_idx]." ".$TODAY[$lang_idx].": <br/ ><span class=\"number\">".$today->get_highrainrate()." ".$RAINRATE_UNIT[$lang_idx]; ?>&nbsp;<? echo $ON[$lang_idx]." ".$today->get_highrainrate_time(); ?></span><br/>
		<? echo $MAX[$lang_idx]." ".$RAINRATE[$lang_idx]."(2) ".$TODAY[$lang_idx].": <br/ ><span class=\"number\">".$today->get_highrainrate2()." ".$RAINRATE_UNIT[$lang_idx]; ?>&nbsp;<? echo $ON[$lang_idx]." ".$today->get_highrainrate2_time(); ?></span>
	   </div>
        <div class="inv_plain_3_zebra" >
			<? echo $MAX[$lang_idx]." ".$RAINRATE[$lang_idx]." ".$monthInWord.":<br/ > <span class=\"number\">".$thisMonth->get_highrainrate()." ".$RAINRATE_UNIT[$lang_idx]; ?></span>
		</div>
        <div class="inv_plain_3_zebra">
                 <? echo $MAX[$lang_idx]." ".$RAINRATE[$lang_idx]." ".$TILL_NOW[$lang_idx].":<br/ > <span class=\"number\">".$seasonTillNow->get_highrainrate()." ".$RAINRATE_UNIT[$lang_idx]; ?></span>
        </div>
    <div class="inv_plain_3_zebra" >
        <a href="<? echo get_query_edited_url($url_cur, 'section', './reports/NOAAMO.TXT');?>">
		<? echo $DETAILED_BY_DAY[$lang_idx]; ?>...
		</a>
        <br />
        
	<a href="<? echo get_query_edited_url($url_cur, 'section', 'RainSeasons.php');?>">
		150 <? echo $RAIN_SEASONS[$lang_idx]; ?>...
	</a>
		</div>
		<script language="JavaScript" type="text/javascript">
		var rainwrapper = document.getElementById('rainwrapper');
		var expDiv = document.getElementById('exp');
		var avRain = document.getElementById('avRain');
		expDiv.innerHTML = avRain.innerHTML;
		avRain.style.display = 'none';
				
</script>
<a name="rainacc"></a>
<div style="padding:1em">
<form method="post" name="rainAccHours" action="#rainacc" style="clear:both;background:transparent;" <? if (isHeb()) echo "dir=\"rtl\""; ?>>
	
	<input type="text" name="rainAccHours" value='<? echo $rainAcc;?>'  border="1" style="width:2em" class="inv_plain_2"/>
	(1 - <? echo $hour + 24; ?>) <? echo $HOURS[$lang_idx]." ".$RAIN[$lang_idx]; ?>&nbsp;&nbsp;&nbsp;
	<input type="submit" name="button" value="<? echo $SHOW[$lang_idx];?>" width="22" title="go" border="0" style="cursor:hand" />
</form>

<?
	//echo "<img src=\"button.php?text=$rainAcc hours accumulated rain&R=66&G=102&B=125&width=300&height=20\">";
?>

<?
	//echo "<td class=verysmall>".getRainAccArrayTable($rainAcc)."</td>";
	$rainarray = array();
	$rainarray = getRainAccArray($rainAcc, 0, 0);
	$timearray = array();
	if ($rainarray){
		for ($i=0 ; $i < count($rainarray) ; $i++)
		{
			if ($rainarray[$i]['time'] == "00:00")
				array_push ($timearray, sprintf("%s 00:00",$rainarray[$i]['date']));
			else
				array_push ($timearray, $rainarray[$i]['time']);
		}
		$accarray = array();
		for ($i=0 ; $i < count($rainarray) ; $i++)
		{
			array_push ($accarray, $rainarray[$i]['rainacc']);
		}
		$timearrayE = implode(" ", $timearray);
		$rainarrayE = implode(" ", $accarray);
		//echo $timearrayE;
			echo "<a class=\"enlarge\" href=\"imageGraph.php?title=Last $rainAcc hours of accumulated rain &Xtitle=&Ytitle=mm&interval=$rainAcc&rainarray=$rainarrayE&timearray=$timearrayE\" target=\"_system\" title=\"click to enlarge\">";
		echo "<img src=\"imageGraph.php?title=Last $rainAcc hours of accumulated rain &Xtitle=&Ytitle=mm&interval=$rainAcc&rainarray=$rainarrayE&timearray=$timearrayE\" alt=\"Last $rainAcc hours of accumulated rain\" width=\"320\"/>";
			echo "</a>";           
	}
	
?>

</div>
</div>
<div id="rainwrapper" class="inv_plain_2 float " style="margin:0em;padding:0.1em;width:315px;">
        <? if (strstr($_GET['graph'], 'Rain')) echo getRainAccTable();?>
        <div style="clear:both" <? if (isHeb()) echo "dir=\"rtl\""; ?>>
                <div class="inv_plain_3_zebra big" >
                        <? echo $DAILY_RAIN[$lang_idx].": <span class=\"number\">".$today->get_rain()." ".$RAIN_UNIT[$lang_idx]; ?></span><br/>
						<? echo $DAILY_RAIN[$lang_idx]."(2): <span class=\"number\">".$today->get_rain2()." ".$RAIN_UNIT[$lang_idx]; ?></span>
                </div>
                <div class="inv_plain_3_zebra big" >
                        <? echo $YESTERDAY[$lang_idx].": <span class=\"number\">".$yest->get_rain()." ".$RAIN_UNIT[$lang_idx]; ?></span><br/>
						<? echo $YESTERDAY[$lang_idx]."(2): <span class=\"number\">".$yest->get_rain2()." ".$RAIN_UNIT[$lang_idx]; ?></span>
                </div>
                <div class="inv_plain_3_zebra big" >
                        <? echo $STORM_RAIN[$lang_idx]."(2): <span class=\"number\">".$storm->get_rain()." ".$RAIN_UNIT[$lang_idx]; ?></span>
                </div>
                <div class="inv_plain_3_zebra big" >
                        <? echo $MONTHLY_RAIN[$lang_idx].": <span class=\"number\">".$thisMonth->get_rain()." ".$RAIN_UNIT[$lang_idx]; ?></span>
                </div>
                <div class="inv_plain_3_zebra big" >
                    <? getLatestDailyRain(); ?>
                </div>
                
        </div>
		

</div>
		<div id="rainwrappertotal" class="inv_plain_2 float " style="margin:0em;padding:0.1em;width:315px;">
				<div class="inv_plain_3_zebra big" >
					<table style="width:100%;text-align: center">
						<tr>
							<td><? echo $TOTAL_RAIN[$lang_idx].":";?></td>
							<td><? echo" <span class=\"number\">".$seasonTillNow->get_rain()." ".$RAIN_UNIT[$lang_idx]; ?></span></td>
						</tr>
						<tr>
							<td> <? echo $TOTAL_RAIN[$lang_idx]."2:";?></td>
							<td><? echo "<span class=\"number\">".$seasonTillNow->get_rain2()." ".$RAIN_UNIT[$lang_idx]; ?></span></td>
						</tr>
					</table>
                       
						
                </div>
                <div class="inv_plain_3_zebra big" >
                <? GetLatestYearsRainForToday(); ?>
                </div>
		</div>




<? } ?>
<?
/*
*  Solar extensions
*
*/
if ((strstr(strtolower($_GET['graph']), 'uv'))||
	(strstr(strtolower($_GET['graph']), 'solar'))||
        (strstr(strtolower($_GET['graph']), 'rad'))||
	(strstr(strtolower($_GET['graph']), 'eth')))
{ $forecastDaysDB = $mem->get('forecastDaysDB');?>

	<div id="sun" style="position: relative;left: -20px;width: 300px;padding: 0.2em;">
				<div>
				<a href="https://www.gaisma.com/en/location/jerusalem.html" target="_blank" title="<? echo $MORE_INFO[$lang_idx];?>">	
						<? echo $SUN_PHASE[$lang_idx]." ".$TODAY[$lang_idx]; ?>
						
				</a>	
				</div>
			
				<div>
				<? echo $RISE[$lang_idx]; ?>
				&nbsp;<? echo $sunrise; ?><br />
				<? echo $SET[$lang_idx]; ?> 
				&nbsp;<? echo $sunset; ?><br />
				<a href="https://www.sunrisesunset.com/calendar.asp?comb_city_info=Jerusalem,%20Israel;-35.25;31.75;2;9&amp;month=<?echo $month; ?>&amp;year=<?echo $year; ?>&amp;time_type=0" rel="external" title="<? echo $MORE_INFO[$lang_idx];?>"><? echo $MORE_INFO[$lang_idx];?><?=get_arrow()?></a> <br/>
				 <? echo $today->get_sunshinehours()." ".$SUNSHINEHOURS[$lang_idx]." ".$TILL_NOW[$lang_idx];?>                                                                                
				</div>
				<div class="float">
				<a href="https://www.timeanddate.com/worldclock/astronomy.html?n=110" target="_blank" title="<? echo $MORE_INFO[$lang_idx];?>">
											<? echo $MORE_INFO[$lang_idx];?><?=get_arrow()?>
				</a>
				</div>
			
	</div>
    <div style="text-align: center;margin:0 auto">
    <img class="imgresponsive" src="images/UVDoseSkinType.PNG" width="710" height="535" /><br />
    <? if (!isHeb()) { ?>
    MED dose leading to sunburn.A person with Type II skin type might choose 0.75 MED as the maximum for the day
    <table style="width:320px;direction:rtl;border:1px solid">
        <tr><td>Skin Type</td><td>Skin Color</td><td>Tanning & Sunburning</td></tr>
        <tr><td>I</td><td>White</td><td>Always burns easily, never tans</td></tr>
        <tr><td>II</td><td>White</td><td>Always burns easily, tans minimally</td></tr>
        <tr><td>III</td><td>Light Brown</td><td>Burns moderately, tans gradually</td></tr>
        <tr><td>IV</td><td>Moderate Brown</td><td>Burns minimally, tans well</td></tr>
        <tr><td>V</td><td>Dark Brown</td><td>Burns rarely, tans profusely</td></tr>
        <tr><td>VI</td><td>Black</td><td>Never burns, deep pigmentation</td></tr>
    </table>
    <?} else {?>
    מנות  יו-וי המובילות לעור שרוף<br />
    לדוגמא בעל עור מסוג 2 יבחר 0.75 מנות לכמות מקסימלית ליום<br />
    <table style="width:320px;direction:rtl;border:1px solid;margin:0 auto">
        <tr><td>סוג עור</td><td>צבע עור</td><td>נשרף או משתזף</td></tr>
        <tr><td>I</td><td>לבן</td><td>תמיד נשרף, אף פעם לא משתזף</td></tr>
        <tr><td>II</td><td>לבן</td><td>תמיד נשרף בקלות, משתזף בקושי</td></tr>
        <tr><td>III</td><td>חום בהיר</td><td>נשרף במידה בינונית, משתזף בהדרגה</td></tr>
        <tr><td>IV</td><td>חום בינוני</td><td>נשרף באופן מינימלי, משתזף מהר</td></tr>
        <tr><td>V</td><td>חום כהה</td><td>כמעט אף פעם לא נשרף, משתזף היטב</td></tr>
        <tr><td>VI</td><td>שחור</td><td>אף פעם לא נשרף, צבע עמוק</td></tr>
    </table>
    <?}?>
    <br /><img class="imgresponsive" src="images/SolarDist.PNG" width="938" height="682" /><br />
    <? if (isHeb()) { ?>
    מתוך 100% קרינה מהשמש<br />
-----------------------------------<br />
30% - מוחזר לחלל<br />
70% - נספג בעננים, אטמוספירה, אדמה וים<br />
<br />
<br />
כמות האנרגיה בכדור-הארץ שנספגת בשעה גדולה יותר מכמות האנרגיה הנצרכת בשנה
    <?} else {?>
Out of 100% sun radiation: 30% is transfered back to space, 70% absorbed into clouds, atmosphere, land and sea.
    <?}?>
    </div>
<? }?>
</div>
</div>

<script language="JavaScript" type="text/javascript">	

colorTrends();

function colorTrends()
{
	var trendToColor = document.getElementById('<?=getTrendID()?>');
	if (trendToColor)
		trendToColor.className = 'inv_plain_2';
		
}
$('#startinfo_container').hide();
$('#info_btns').hide();
$('#legends').hide();
$('#for24_given').hide();
$('#graph_forcastWrapper').hide();
$('#adunit3').hide();
$('#for24_hours').hide();
$('#currentinfo_container').css("margin-top", "7em").show();
$('#spacer1, #spacer2, #spacer3, #spacer4').hide();

</script>

<?
if (strstr(strtolower($_GET['graph']), 'dew')){
	$btn = "dew_btn";
}
else if (strstr(strtolower($_GET['graph']), 'hum')){
	$btn = "moist_btn";
}
else if (strstr(strtolower($_GET['graph']), 'uv')){
	$btn = "uv_btn";
}
else if (strstr(strtolower($_GET['graph']), 'rain')){
	$btn = "rain_btn";
}
else if (strstr(strtolower($_GET['graph']), 'wind')){
	$btn = "wind_btn";
}
else if (strstr(strtolower($_GET['graph']), 'solar')){
	$btn = "rad_btn";
}
else if (strstr(strtolower($_GET['graph']), 'temp.php')){
	$btn = "temp_btn";
}
else if (strstr(strtolower($_GET['graph']), 'temp3')){
	$btn = "temp3_btn";
}
else if (strstr(strtolower($_GET['graph']), 'dust')){
	$btn = "aq_btn";
}
else if (strstr(strtolower($_GET['graph']), 'baro')){
	$btn = "air_btn";
}
else{
	$btn = "temp2_btn";
}
?>
<script type="text/javascript">
    $(document).ready(function() {
    $('#<?=$btn?>').click();
    });
</script>

