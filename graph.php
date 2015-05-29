<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
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
	ini_set("display_errors","On");
	if ($_GET['graph']=="OutsideTempHistory")
		$_GET['graph'] = 'temp.php';
	if ($_GET['graph']=="RainRateHistory")
		$_GET['graph'] = 'RainRateHistory.gif';
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
        
        function getStormRain()
        {
            $ary_path = array();    
            // Array to store parsed data    
            $ary_parsed_file = array();    
            // Starting level - Set to 0 to display all levels. Set to 1 or higher    
            // to skip a level that is common to all the fields.    
            $int_starting_level = 2; 
            $ary_parsed_file = getXMLInArray(FILE_XML_FULLDATA2);
            return $ary_parsed_file['STORMRAIN'];
            
        }
        
?>

<?
ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE);
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
				return "עומס חום מתקבל אחרי שקלול הלחות היחסית עם הטמפרטורה האבסלוטית.		במצב של עומס חום כבד, עשויים עבודה גופנית או מאמץ גופני אחר לערער את המנגנונים האחראים לשמירת חום הגוף.		<div class=\"tbl\"><a href=\"http://www.hpc.ncep.noaa.gov/html/heatindex.shtml\" target=\"_blank\">מידע נוסף והנוסחה לחישוב עומס חום</a></div>";
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
		else if (strstr(strtolower($_GET['graph']), 'uvdose'))
		{
			if (isHeb()) 
			{ 
				return "הכמות של החשיפה לשמש הדרושה להפיכת העור לאדום";
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
				return "אינדקס מ-0 ועד 16 הנועד לציין את הסיכון לעור חשוף בשמש ללא הגנה.";
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
<?
if ((strstr(strtolower($_GET['graph']), 'temp'))||
	(strstr(strtolower($_GET['graph']), 'windchill'))||
	(strstr(strtolower($_GET['graph']), 'heatindex'))||
	(strstr(strtolower($_GET['graph']), 'dew'))||
	(strstr(strtolower($_GET['graph']), 'thw'))||
	(strstr(strtolower($_GET['graph']), 'airdensity')))
{
	echo "<ul id=\"graphnav\" class=\"nav\" ";
	if (isHeb()) echo "dir=\"rtl\"";
	echo ">";
	echo "<li".getBorder("temp.php")." ><a href=\"".get_query_edited_url(get_url(), 'graph', 'temp.php')."\" title=\"".$GRAPH[$lang_idx]."\">".$TEMP[$lang_idx].": <span dir=\"ltr\" >".$current->get_temp()."&#176;"."</span>"."</a></li>";
	echo "  <li".getBorder("tempwchill.php")." ><a href=\"".get_query_edited_url(get_url(), 'graph', 'tempwchill.php')."\" title=\"".$GRAPH[$lang_idx]."\">".$WIND_CHILL[$lang_idx].": <span dir=\"ltr\" >".$current->get_windchill()."&#176;"."</span>"."</a></li>";
	echo "  <li".getBorder("tempheat.php")." ><a href=\"".get_query_edited_url(get_url(), 'graph', 'tempheat.php')."\" title=\"".$GRAPH[$lang_idx]."\">".$HEAT_IDX[$lang_idx].": <span dir=\"ltr\" >".$current->get_HeatIdx()."&#176;"."</span>"."</a></li>";
	echo "  <li id=\"thwtab\" ".getBorder("THWHistory.gif")." ><a href=\"".get_query_edited_url(get_url(), 'graph', 'THWHistory.gif')."\" title=\"".$GRAPH[$lang_idx]."\">".$THW[$lang_idx].": <span dir=\"ltr\" >".$current->get_thw()."&#176;"."</span>"."</a></li>";
	echo "  <li".getBorder("dewpt.php")." ><a href=\"".get_query_edited_url(get_url(), 'graph', 'dewpt.php')."\" title=\"".$GRAPH[$lang_idx]."\">".$DEW[$lang_idx].": <span dir=\"ltr\" >".$current->get_dew()."&#176;"."</span>"."</a></li>";
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
	echo "<li".getBorder("winddir.php")."><a href=".get_query_edited_url(get_url(), 'graph', 'winddir.php?level='.($_REQUEST['profile'])).">".$WIND_DIR[$lang_idx]."</a></li>";
	echo "<li".getBorder("HiWindSpeedHistory.gif")."><a href=".get_query_edited_url(get_url(), 'graph', 'HiWindSpeedHistory.gif').">".$WIND_HIGH[$lang_idx]."</a></li>";
	echo "<li".getBorder("HighWindDirHistory.gif")."><a href=".get_query_edited_url(get_url(), 'graph', 'HighWindDirHistory.gif').">".$WIND_HIGH_DIR[$lang_idx]."</a></li>";
	echo "<li".getBorder("WindRunHistory.gif")."><a href=".get_query_edited_url(get_url(), 'graph', 'WindRunHistory.gif').">".$WIND_RUN[$lang_idx]."</a></li>";
	echo "</ul>";
}
else if ((strstr(strtolower($_GET['graph']), 'uv'))||
	(strstr(strtolower($_GET['graph']), 'solar'))||
	(strstr(strtolower($_GET['graph']), 'eth')))
{
	echo "<ul id=\"graphnav\" class=\"nav\" ";
	if (isHeb()) echo "dir=\"rtl\"";
	echo ">";
	echo "  <li".getBorder("UVHistory.gif")." ><a href=\"".get_query_edited_url(get_url(), 'graph', 'UVHistory.gif')."\" title=\"".$GRAPH[$lang_idx]."\">".$UV[$lang_idx].": <span dir=\"ltr\" >".$current->get_uv()."</span>"."</a></li>";
	echo "  <li".getBorder("HighUVHistory.gif")." ><a href=\"".get_query_edited_url(get_url(), 'graph', 'HighUVHistory.gif')."\" title=\"".$GRAPH[$lang_idx]."\">".$UV[$lang_idx]." - ".$HIGH[$lang_idx]."<span dir=\"ltr\" >"."</span>"."</a></li>";
	echo "  <li".getBorder("UVDoseHistory.gif")." ><a href=\"".get_query_edited_url(get_url(), 'graph', 'UVDoseHistory.gif')."\" title=\"".$GRAPH[$lang_idx]."\">".$UV_DOSE[$lang_idx]."<span dir=\"ltr\" >"."</span>"."</a></li>";
	echo " <li".getBorder("SolarRadHistory.gif")." ><a href=\"".get_query_edited_url(get_url(), 'graph', 'SolarRadHistory.gif')."\" title=\"".$GRAPH[$lang_idx]."\">".$RADIATION[$lang_idx].": <span dir=\"ltr\" >".$current->get_solarradiation()." W/m2"."</span>"."</a></li>";
	echo " <li".getBorder("HighSolarRadHistory.gif")." ><a href=\"".get_query_edited_url(get_url(), 'graph', 'HighSolarRadHistory.gif')."\" title=\"".$GRAPH[$lang_idx]."\">".$RADIATION[$lang_idx]." - ".$HIGH[$lang_idx]."</a></li>";
	echo " <li".getBorder("SolarEnergyHistory.gif")." ><a href=\"".get_query_edited_url(get_url(), 'graph', 'SolarEnergyHistory.gif')."\" title=\"".$GRAPH[$lang_idx]."\">".$SOLAR_ENERGY[$lang_idx]."</a></li>";
	echo "<li".getBorder("ETHistory.gif")." ><a href=\"".get_query_edited_url(get_url(), 'graph', 'ETHistory.gif')."\" title=\"".$GRAPH[$lang_idx]."\">".$ET[$lang_idx].": <span dir=\"ltr\" >".$today->get_et()." mm"."</span>"."</a></li>";
	echo "</ul>";
}
?>

<div id="graphmain"  class="inv_plain_2">
<hr id="graphs_line" />
<div class="float" style="margin:1em;" >	
	 <div id="graphImage"> 
		<? 
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

		?>
		<? if (($profile <=3)|| ((strstr(strtolower($_GET['graph']), 'uv'))||
	(strstr(strtolower($_GET['graph']), 'solar'))||
	(strstr(strtolower($_GET['graph']), 'eth')))) {?>
                <a class="enlarge" href="images/profile<? echo $_REQUEST['profile']."/".$_GET['graph'];?>?level=<?=($_REQUEST['profile'])?>&amp;freq=2<?=$datasource?>&amp;w=1600" target="_blank" title="click to enlarge">
                <span></span>
		<img name="baseGraph" id="baseGraph" src="./images/profile<? echo $_REQUEST['profile']."/".$_GET['graph'];?>?level=<?=($_REQUEST['profile'])?>&amp;freq=2<?=$datasource?>" width="550" alt="<? echo getPageTitle()?>" <? if (strstr($_GET['graph'], 'Hum')) echo "class=\"inv_plain\"";?> style="padding:0;margin:0"/>
                </a>
		<?} else{?>
		<iframe src="http://www.02ws.co.il/wxwugraphs/graphy1a.php?y=<?=$year?>&theme=default&w=460&h=295"  width="550" height="488"></iframe>
		<?} ?>
	 </div> 
</div>
<div class="float" style="margin:1em 0.8em">
		<div>
		<script type="text/javascript"><!--
		google_ad_client = "pub-2706630587106567";
		/* 336x280, created 9/12/10 */
		google_ad_slot = "2475513899";
		google_ad_width = 336;
		google_ad_height = 280;
		google_color_border = ["<?= $forground->bg['+1'] ?>"];
		google_color_bg = ["<?= $forground->bg['+1'] ?>"];
		google_color_link = ["<?= $forground->bg['-9'] ?>"];
		google_color_url = ["<?= $forground->bg['-9'] ?>"];
		google_color_text = ["<?= $forground->bg['-9'] ?>"];
		//-->
		</script>
		<script type="text/javascript"
		src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
		</script>
		</div>
</div>
<div class="float" style="padding:0 1em;clear:both">
			<form method="post" name="profileChanger" action="" style="background:transparent;" <? if (isHeb()) echo "dir=\"rtl\""; ?>>
				<? echo $GRAPH[$lang_idx]." ".$FOR[$lang_idx];?>
				<select size="1" id="profile" name="profile" class="inv_plain_2" onchange="changeProfile(this.options[this.selectedIndex].value)" <? if (isHeb()) echo "dir=\"rtl\""; ?>> 
						<option	<? if ($_REQUEST['profile'] == "1") echo " selected ";?> value="1"><? echo $TODAY[$lang_idx];?></option>
						<option	<? if ($_REQUEST['profile'] == "2") echo " selected ";?> value="2">3 <? echo $DAYS[$lang_idx];?></option>
						<option	<? if ($_REQUEST['profile'] == "3") echo " selected ";?> value="3"><? echo $LAST_WEEK[$lang_idx];?></option>
						<option	<? if ($_REQUEST['profile'] == "4") echo " selected ";?> value="4"><? echo $LAST_MONTH[$lang_idx];?></option>
						<option	<? if ($_REQUEST['profile'] == "5") echo " selected ";?> value="5">3 <? echo $MONTHS[$lang_idx];?></option>
						<option	<? if ($_REQUEST['profile'] == "6") echo " selected ";?> value="6"><? echo $YEARLY[$lang_idx];?></option>
				</select>
			<input type="hidden" name="myPHPvar" id="hiddenProfile" value="" />
			</form>
			<ul id="moregraphs" style="list-style-type: bullet">
			<li><a href="wugraphs.php" rel="external"><? echo $BY_DATE[$lang_idx];?></a></li>
			<li><a href="<? echo get_query_edited_url($url_cur, 'section', 'latest.php');?>" class="hlink"><? echo $ALL_GRAPHS[$lang_idx]." - ".$TODAY[$lang_idx];?></a></li>
			<li><a href="<? echo get_query_edited_url($url_cur, 'section', '2weeks.php');?>" class="hlink"><? echo $ALL_GRAPHS[$lang_idx]." - ".$LAST_WEEK[$lang_idx];?></a></li>
			<li><a href="<? echo get_query_edited_url($url_cur, 'section', 'month.php');?>" class="hlink"><? echo $ALL_GRAPHS[$lang_idx]." - ".$LAST_MONTH[$lang_idx];?></a></li>
                        <li><a href="<? echo get_query_edited_url($url_cur, 'section', '3months.php');?>" class="hlink"><? echo $ALL_GRAPHS[$lang_idx]." - 3 ".$MONTHS[$lang_idx];?></a></li>
			</ul>
</div>
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
<div class="float" id="additionalgraphs">
	<a href="images/profile<? echo $_REQUEST['profile']."/".$alternategraph;?>" class='colorbox' title="<?=$alternategraphtitle?>">
	<img name="alternateGraph" id="alternateGraph" src="./images/profile<? echo $_REQUEST['profile']."/".$alternategraph;?>" width="120" alt="<?=$alternategraphtitle?>" style="padding:0;margin:0"/>
	</a>
	<div class="small" style="padding:0"><?=$alternategraphtitle?></div>
</div>
<ul class="float" id="relatedgraphs" style="list-style-type: bullet">
	<li><a href="<? echo get_query_edited_url($url_cur, 'graph', 'tempheat.php');?>"><?=$TEMP[$lang_idx]."/".$HEAT_IDX[$lang_idx];?></a></li>
	<li><a href="<? echo get_query_edited_url($url_cur, 'graph', 'temp.php');?>"><?=$TEMP[$lang_idx]."/".$HUMIDITY[$lang_idx];?></a></li>
	<li><a href="<? echo get_query_edited_url($url_cur, 'graph', 'windtemp.php');?>"><?=$TEMP[$lang_idx]."/".$WIND[$lang_idx];?></a></li>
	<li><a href="<? echo get_query_edited_url($url_cur, 'graph', 'barorain.php');?>"><?=$RAIN[$lang_idx]."/".$BAR[$lang_idx];?></a></li>
</ul>
<div style="margin:0em 2em;width:320px;" class="inv_plain_3 invfloat">
	<div id="exp" class="float" style="height:auto;padding:0.5em;position:relative;direction:rtl">
		<? echo getExp();?>

	</div>
	
</div>
<?
/*
*  temp extensions
*
*/
if ((strstr(strtolower($_GET['graph']), 'temp'))||
	(strstr(strtolower($_GET['graph']), 'windchill'))||
	(strstr(strtolower($_GET['graph']), 'heatindex'))||
	(strstr(strtolower($_GET['graph']), 'dew'))||
	(strstr(strtolower($_GET['graph']), 'thw'))||
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
<script type="text/javascript">
    $(document).ready(function() {
    $('#temp_btn').click();
    });
</script>
<? }
if (strstr(strtolower($_GET['graph']), 'temp'))
{	 ?>
	<div class="float" style="margin:1em 0.5em;<? if (isHeb()) echo "direction:rtl"; ?>" class="inv_plain_2_zebra" >
	<table <? if (isHeb()) echo "dir=\"rtl\""; ?> id="mouseover" cellpadding="4">
	<tr>
		<td></td>
		<td></td>
		<td class="topbase"><? echo($TODAY[$lang_idx]);?></td>
		<td  class="topbase"><a href="<? echo get_query_edited_url($url_cur, 'section', 'reports/downld02.txt');?>" class="hlink" target="_self" title="temp today compared to its month's average"><? echo($YESTERDAY[$lang_idx]);?></a></td>
		<td  class="topbase"><? echo($DIFF_FROM[$lang_idx]);?> <a href="#" title="temp today compared to yestarday max/min"><? echo($YESTERDAY[$lang_idx]);?></a></td>
		<td  class="topbase" title="temp today compared to its month's average"><a href="<? echo get_query_edited_url(get_url(), 'section', 'averages');?>"  class="hlink" target="_self" title="<? echo $AVERAGE[$lang_idx];?>"><? echo($NORMAL[$lang_idx])." - ".$monthInWord;?></a></td>
		<td  class="topbase"><? echo($DIFF_FROM[$lang_idx]);?> <a href="<? echo get_query_edited_url(get_url(), 'section', 'averages');?>" title="<? echo $AVERAGE[$lang_idx];?>"><? echo($NORMAL[$lang_idx]);?></a></td>
		
		
		
	</tr>
	<tr class="inv_plain_2">
		<td class="inv_plain_2"><? echo "[".$today->get_hightemp_time()."] "; ?></td>
		<td><? echo($MAX[$lang_idx]);?> <? echo($TEMP[$lang_idx]);?></td>
		<td class="high"><? echo toLeft($today->get_hightemp().$current->get_tempunit()); ?></td>
		<td><a href="" class="info">
				<?echo $yest->get_hightemp(),$current->get_tempunit();?>
			 </a></td>
		<td><a href="" class="info">
				<? echo get_param_tag($today->get_hightemp() - $yest->get_hightemp()).$current->get_tempunit();?>
		   <span class="info"><? echo($TODAY[$lang_idx]);?> <?echo $today->get_hightemp(),$current->get_tempunit();?>  <br /><? echo($YESTERDAY[$lang_idx]);?> <?echo $yest->get_hightemp(),$current->get_tempunit();?></span>
		   </a></td>
		 <td><a href="" class="info">
				<? if (!$error_db) echo $monthAverge->get_hightemp(),$current->get_tempunit();?>
			 </a></td>
		
		<td><a href="" class="info">
				<? if (!$error_db) echo get_param_tag($hightemp_diffFromAv).$current->get_tempunit();?>
				<span class="info"><? echo($TODAY[$lang_idx]);?> <?echo $today->get_hightemp(),$current->get_tempunit();?>  <br /><?  if (!$error_db) echo $monthInWord.": ".$monthAverge->get_hightemp(),$current->get_tempunit();?> </span>
			</a>
		</td>
		
		
	</tr>
	<tr class="inv_plain_2">
		<td class="inv_plain_2"><? echo "[".$today->get_lowtemp_time()."] "; ?></td>
		<td><? echo($MIN[$lang_idx]);?> <? echo($TEMP[$lang_idx]);?></td>
		<td class="low"><? echo toLeft($today->get_lowtemp().$current->get_tempunit()); ?></td>
		
		<td><a href="" class="info">
				<?echo $yest->get_lowtemp(),$current->get_tempunit();?>
			 </a></td>
		<td>
			<a href="" class="info">
					<? echo get_param_tag($today->get_lowtemp() - $yest->get_lowtemp()).$current->get_tempunit();?>
			   <span class="info"><? echo($TODAY[$lang_idx]);?> <?echo toLeft($today->get_lowtemp()),$current->get_tempunit();?>  <br /><? echo($YESTERDAY[$lang_idx]);?> <?echo toLeft($yest->get_lowtemp()),$current->get_tempunit();?></span>
			   </a>
		 </td>
		 <td><a href="" class="info">
				<?  if (!$error_db) echo $monthAverge->get_lowtemp(),$current->get_tempunit();?>
			 </a></td>
		<td>
			<a href="" class="info">
					<? if (!$error_db) echo get_param_tag($lowtemp_diffFromAv).$current->get_tempunit(); ?>
					<span class="info"><? echo($TODAY[$lang_idx]);?> <?echo $today->get_lowtemp(),$current->get_tempunit();?><br /><? if (!$error_db) echo $monthInWord.": ".$monthAverge->get_lowtemp(),$current->get_tempunit();?> </span>
				</a>
		</td>
		
		
	</tr>
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
        <script type="text/javascript">
    $(document).ready(function() {
    $('#moist_btn').click();
    });
    </script>
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
				<? if (!$error_db) echo get_param_tag($highhum_diffFromAv)."%";?>
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
					<? if (!$error_db) echo get_param_tag($lowhum_diffFromAv)."%"; ?>
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
<script type="text/javascript">
    $(document).ready(function() {
    $('#wind_btn').click();
    });
    </script>
<a name="windd"></a>
<div class="topbase" style="margin:1em;width:145px;position:absolute;" <? if (isHeb()) echo "dir=\"rtl\""; ?> id="highWind"><? echo $HIGH[$lang_idx]." ".$TODAY[$lang_idx].": ".$today->get_highwind()." ".$KNOTS[$lang_idx]." ".$ON[$lang_idx]." ".$today->get_highwind_time(); ?><br/><br/>
<? echo "1 ".$KNOTS[$lang_idx]." = "."1.8 ".$KMH[$lang_idx];?>
</div>
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
<script type="text/javascript">
    $(document).ready(function() {
    $('#rain_btn').click();
    });
    </script>
<div class="inv_plain_2" id="highRainRate" style="margin:1em;padding:1em;height:300px;width:145px;float:<?echo get_s_align();?>" <? if (isHeb()) echo "dir=\"rtl\""; ?>>
	<? echo $MAX[$lang_idx]." ".$RAINRATE[$lang_idx]." ".$TODAY[$lang_idx].": <br />".$today->get_highrainrate()." ".$RAINRATE_UNIT[$lang_idx]; ?>&nbsp;<? echo $ON[$lang_idx]." ".$today->get_highrainrate_time(); ?>
	<br />
	   <div id="rainwrapper" class="inv_plain_2 float" style="margin:0.1em">
		<? if (strstr($_GET['graph'], 'Rain')) echo getRainAccTable();?>
		<div style="clear:both" <? if (isHeb()) echo "dir=\"rtl\""; ?>>
			<div class="inv_plain_3_minus" align="left">
				<? echo $DAILY_RAIN[$lang_idx].": <strong>".$today->get_rain()." ".$RAIN_UNIT[$lang_idx]; ?></strong>
			</div>
                        <div class="inv_plain_3_minus" align="left">
				<? echo $YESTERDAY[$lang_idx].": <strong>".$yest->get_rain()." ".$RAIN_UNIT[$lang_idx]; ?></strong>
			</div>
			<div class="inv_plain_3_zebra" align="left">
				<? echo $STORM_RAIN[$lang_idx].", ".$UPDATES_INTERVAL[$lang_idx].": <strong>".$storm->get_rain()." ".$RAIN_UNIT[$lang_idx]; ?></strong>
			</div>
			<div class="inv_plain_3_minus" align="left">
				<? echo $MONTHLY_RAIN[$lang_idx].": <strong>".$thisMonth->get_rain()." ".$RAIN_UNIT[$lang_idx]; ?></strong>
			</div>
			<div class="inv_plain_3_zebra" align="left">
				<? echo $TOTAL_RAIN[$lang_idx].": <strong>".$seasonTillNow->get_rain()." ".$RAIN_UNIT[$lang_idx]; ?></strong>
			</div>
		</div>
		<div class="inv_plain_3_minus" align="left">
			<? echo $MAX[$lang_idx]." ".$RAINRATE[$lang_idx]." ".$monthInWord.": <strong>".$thisMonth->get_highrainrate()." ".$RAINRATE_UNIT[$lang_idx]; ?></strong>
		</div>
		<div class="inv_plain_3_minus" align="left">
			 <? echo $MAX[$lang_idx]." ".$RAINRATE[$lang_idx]." ".$year.": <strong>".$thisYear->get_highrainrate()." ".$RAINRATE_UNIT[$lang_idx]; ?></strong>
		</div>
 
	</div><br /><br />&nbsp;&nbsp;
	<a href="<? echo get_query_edited_url($url_cur, 'section', 'RainSeasons.php');?>">
		150 <? echo $RAIN_SEASONS[$lang_idx]; ?>...
	</a>
</div>

<?
		
if (!$error_db)
	{
		echo "<div id=\"avRain\" class=\"float inv_plain_2_zebra\" style=\"margin:1em 2em;width:400px;\">";
		include "averageRain.php";
		echo "</div>";
	}
		?>


<script language="JavaScript" type="text/javascript">
		var rainwrapper = document.getElementById('rainwrapper');
		var expDiv = document.getElementById('exp');
		var highRainRate = document.getElementById('highRainRate');
		expDiv.innerHTML = highRainRate.innerHTML;
		highRainRate.style.display = 'none';
				
</script>
<a name="rainacc"></a>
<div>
<form method="post" name="rainAccHours" action="#rainacc" style="clear:both;background:transparent;" <? if (isHeb()) echo "dir=\"rtl\""; ?>>
	<input type="submit" name="button" value="<? echo $SHOW[$lang_idx];?>" width="22" title="go" border="0" style="cursor:hand" />
	<input type="text" name="rainAccHours" value='<? echo $rainAcc;?>' size="1" border="1" style="" class="inv_plain_2"/>
	(1 - <? echo $hour + 24; ?>) <? echo $HOURS[$lang_idx]." ".$RAIN[$lang_idx]; ?>
</form>

<?
	//echo "<img src=\"button.php?text=$rainAcc hours accumulated rain&R=66&G=102&B=125&width=300&height=20\">";
?>

<?
	//echo "<td class=verysmall>".getRainAccArrayTable($rainAcc)."</td>";
	$rainarray = getRainAccArray($rainAcc, 0, 0);
	$timearray = array();
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
	echo "<img src=\"imageGraph.php?title=Last $rainAcc hours of accumulated rain &Xtitle=&Ytitle=mm&interval=$rainAcc&rainarray=$rainarrayE&timearray=$timearrayE\" alt=\"Last $rainAcc hours of accumulated rain\" />";
?>

</div>
<? } ?>
<?
/*
*  Solar extensions
*
*/
if ((strstr(strtolower($_GET['graph']), 'uv'))||
	(strstr(strtolower($_GET['graph']), 'solar'))||
	(strstr(strtolower($_GET['graph']), 'eth')))
{ ?>
<script type="text/javascript">
    $(document).ready(function() {
    $('#rad_btn').click();
    });
    </script>
	<div id="sun" class="clear invfloat" style="width:350px;padding:0.2em">
			
			
				
				<div>
				<div>
				<a href="http://www.gaisma.com/en/location/jerusalem.html" rel="external" title="<? echo $MORE_INFO[$lang_idx];?>">	
						<? echo $SUN_PHASE[$lang_idx]." ".$TODAY[$lang_idx]; ?>
				</a>	
				</div>
				<img src="<? echo "images/icons/day/".$forecastDaysDB[0]['icon']; ?>" width="60" height="60" alt="<?=$forecastDaysDB[0]['date']?>" />
				</div>
				<div>
				<a href="http://www.sunrisesunset.com/calendar.asp?comb_city_info=Jerusalem,%20Israel;-35.25;31.75;2;9&amp;month=<?echo $month; ?>&amp;year=<?echo $year; ?>&amp;time_type=0" rel="external" title="<? echo $MORE_INFO[$lang_idx];?>"><? echo $RISE[$lang_idx]; ?></a> 
				&nbsp;<? echo $sunrise; ?><br />
				<a href="http://www.sunrisesunset.com/calendar.asp?comb_city_info=Jerusalem,%20Israel;-35.25;31.75;2;9&amp;month=<?echo $month; ?>&amp;year=<?echo $year; ?>&amp;time_type=0" rel="external" title="<? echo $MORE_INFO[$lang_idx];?>"><? echo $SET[$lang_idx]; ?></a> 
				&nbsp;<? echo $sunset; ?><br />
				 <? echo $today->get_sunshinehours()." ".$SUNSHINEHOURS[$lang_idx]." ".$TILL_NOW[$lang_idx];?>                                                                                
				</div>
				<div class="float">
				<a href="http://www.timeanddate.com/worldclock/astronomy.html?n=110" rel="external" title="<? echo $MORE_INFO[$lang_idx];?>">
											<? echo $MORE_INFO[$lang_idx];?><?=get_arrow()?>
				</a>
				</div>
			
	</div>
<? }?>
</div>


<script language="JavaScript" type="text/javascript">	

colorTrends();

function colorTrends()
{
	var trendToColor = document.getElementById('<?=getTrendID()?>');
	if (trendToColor)
		trendToColor.className = 'inv_plain_2';
		
}

</script>
