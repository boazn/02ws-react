<?
$RELYABLE_FORACST = array("The most reliable forecast", "התחזית האמינה ביותר ברשת");
if (isset( $_POST['forecastIn']))
{
	$locations = array($_POST['forecastIn']);
}
$locations = isset($_REQUEST['locations']) ? $_REQUEST['locations'] : "";

?>
<style>
    #forecastDetails table{
        direction:<?=getDirection()?>;
        border:1px rgba(0,0,0,0.2);
    }
    
    #wrapperforecast{
        float:right;text-align:center;padding:0 1em;margin-bottom: 1em;
    }
    #wrapperclimate{
        clear:both;padding:0.8em
    }
    #wrapperclimate td{
        box-shadow:0 1px 5px rgba(0,0,0,0.2)
    }
	#list_div{
		width:300px;text-align:center;float:<?echo get_s_align();?>;padding:0.2em;
	}
    #list_div select{
		width:240px
	}
    #res_div{
		text-align:center;width:315px;float:<?echo get_s_align();?>
	}
	@media only screen and (min-width: 1000px) {
		#res_div{
			width:930px;
		}
	}
	ul.select {
   list-style: none;
   margin:  0;
   padding: 2px;
   border: 1px solid grey;
}
#forecastTable td{
	font-size: 90%;
}
ul.select {
   list-style: none;
   margin:  0;
   padding: 2px;
   border: 1px solid grey;
   height: 150px;
    overflow-y: scroll;
}

ul.select li {
   padding: 2px 6px;
}
ul.select li:hover {
   cursor: pointer;
}
ul.select li.selected {
   background-color: blue;
   color: white;
}
#city_name1{
	text-align:center
} 
#forecastTable th.weatherField{
	text-align:right
}      
</style>
<?
$CLIMATOLOGICAL_INFO = array("Climatological Information", "מידע אקלימי", "");
$DAILY_MIN = array("Mean Daily Minimum Temperature", "ממוצע מינימום", "");
$DAILY_MAX = array("Mean Daily Max Temperature", "ממוצע מקסימום", "");
$RAIN_TOTAL = array("Mean Total Rainfall", "ממוצע גשם", "");
?>
<SCRIPT type="text/javascript" language="Javascript" SRC="ajax.js">
</SCRIPT>
	<br />
	<h2><? if (@$_GET['region'] == 'isr') echo $FORECAST_ISR[$lang_idx]; else echo $FORECAST_ABROD[$lang_idx]; ?></h2>
	<!--<h3><? if (@$_GET['region'] != 'isr') echo $TEMP[$lang_idx]." & ".$FORECAST[$lang_idx]." - ".$RELYABLE_FORACST[$lang_idx]; ?></h3>-->

<div <? if (isHeb()) echo "dir=\"rtl\" ";?> style="width:100%;margin:0 auto;float:<?echo get_inv_s_align();?>" class="inv_plain_3">


	<div id="list_div" >
		<form method="post" name="forecastSubmit">
		<input id="events" type="hidden" name="events" value="">

		<ul class="select" name="locations[]" >
		<? 
					if (@$_GET['region'] == 'isr')
						include "israel_list.php";
					else
						include "forecast_list.php";?>
		</ul>
			
		</form>
		<!--<div class="inv_plain_3_zebra" style="width: 60%;margin: 1em auto;padding:0.4em">
		<a href="<? echo get_query_edited_url(get_url(), 'section', 'SendEmailForm.php');?>" >
		<? if (isHeb()) echo "בקשו יעד משלכם"; else echo "Ask for other location"; ?>
		</a>
		</div>-->
		
		

	</div>
	<div id="res_div" >
            <div align="center">
		<div class="city_info">
			<table cellpadding="0" cellspacing="0" width="100%" border="0">
			<tr>
				<td style="" valign="top">
				<div id="city_name1" ></div>
				<div id="country_name2" ></div>
				<div id="website" ></div>
				<div id="current_local_time" >
				<span id="localTime"></span>
				</div>
				<div id="tourism" >
				<span id="tourismInfo"></span>
				</div>
				
				</td>
				<td style="" valign="top">
									
					<div id="map_instruction" ></div>
				</td>
			</tr>
			</table>
		</div>
	
		<div class="city_forecast_info">
			<div id="issue_date" ></div>
			<div>
				<div id="forecastDetails"></div>
				<table id="forecastTable" cellpadding="5" cellspacing="0" border="0">
				<tr>
					<th class="dateField"><?=$DATE[$lang_idx]?></th>
					<th class="temperatureField"><?=$TEMP[$lang_idx]?> (°<span id="forecast_unit">C</span>)</th>
					<th class="weatherField" colspan="2"><?=$FORECAST_TITLE[$lang_idx]?></th>
				</tr>
				</table>
			</div>
			
		</div>
		
		<div class="city_climate_info">
			<div class="item_title" ><?=$CLIMATOLOGICAL_INFO[$lang_idx]?></div>
			<div id="climateContainer"></div>
			
			<div id="climateTable"></div>
			<div id="remark" ></div>
	
			
		</div>
		<div style="">
		<script type="text/javascript"><!--
		google_ad_client = "ca-pub-2706630587106567";
		/* Ad for GetForecast page */
		google_ad_slot = "7705569841";
		google_ad_width = 336;
		google_ad_height = 280;
		google_color_border = ["<?= $forground->bg['+4'] ?>"];
		google_color_bg = ["<?= $forground->bg['+4'] ?>"];
		google_color_link = ["<?= $forground->bg['-9'] ?>"];
		google_color_url = ["<?= $forground->bg['-9'] ?>"];
		google_color_text = ["<?= $forground->bg['-9'] ?>"];
		//-->
		</script>
		<script type="text/javascript"
		src="https://pagead2.googlesyndication.com/pagead/show_ads.js">
		</script>
		</div>
	</div>
	</div>
	
</div>
<? echo "<div>".$SOURCE[$lang_idx].": ".$IMS[$lang_idx]."</div>"; ?>
 <script type="text/javascript">	var pageLang = "en";	var default_search_text = "Please enter city / country / territory name";	var cookie_msg = "Cookie has to be enabled on your browser to display the WMO's World Weather Information Services website.";	var wxinfo = "[#Place Name#] Weather Information";	var hello = "Hello,";	var share_msg = "Here is the weather information for [#Place Name#] on the WMO\'s WWIS.";	var share_msg1 = "Weather information for [#Place Name#] on the WMO\'s WWIS:";	var share_msg2 = "[#Place Name#] Weather Information on the WMO\'s WWIS.";	var share_fav = "Here is the weather information for you on the WMO\'s WWIS.";	var city_not_found = "No such city found!";	var isArLang = false;	var src_path = "..";	var base_layer = "The base layer";	var additional_layer = "Additional layers";	var gray_base_map = "Gray base map";	var color_base_map = "Color base map";</script>	
 <link rel="stylesheet" type="text/css" href="https://worldweather.wmo.int/styles/jquery-ui.css" />       
 <link rel="stylesheet" type="text/css" href="https://worldweather.wmo.int/styles/common.css" />
	<script type="text/javascript" src="https://worldweather.wmo.int/scripts/jquery-1.6.2.min.js"></script>
	<script type="text/javascript" src="https://worldweather.wmo.int/scripts/jquery-ui.js"></script>
	<script type="text/javascript" src="https://worldweather.wmo.int/scripts/sessvars.js"></script>
	<script type="text/javascript" src="https://worldweather.wmo.int/scripts/common.js"></script>
	<script type="text/javascript" src="https://worldweather.wmo.int/scripts/moment-with-langs.min.js"></script>
	<script type="text/javascript" src="https://worldweather.wmo.int/scripts/highcharts.js"></script>
	<script type="text/javascript" src="https://worldweather.wmo.int/scripts/OpenLayers.js"></script>
	<script type="text/javascript" src="https://worldweather.wmo.int/scripts/osm.js"></script>
        <style>
            .city_forecast_info, .city_climate_info, .city_info, #forecastTable, #climateContainer, #climateTable, .climateTable{
                width: 318px;
				<? if (isHeb()) echo "direction:rtl";?>
            }
			@media only screen and (min-width: 1000px) {
				.city_forecast_info, .city_climate_info, .city_info, #forecastTable, #climateContainer, #climateTable, .climateTable{
                width: 930px;
            	}
			}
        </style>
            
			<script type="text/javascript">
	function fillForecast(str)
	{
		var forecastDetails = document.getElementById('forecastDetails');
		 if (forecastDetails.firstChild) {
		   forecastDetails.removeChild(forecastDetails.firstChild);
		 }
		 newDiv = document.createElement("div");
		 newDiv.innerHTML = str;
		 //forecastDetails.appendChild(newDiv); 
		 forecastDetails.innerHTML = str;
	}
	function getForecastService(location)
	{	
		fillForecast('<img src="images/loading.gif" alt="loading" />');
		ajax_get_city_info(location);
		
		
	}
	function getForecastServiceIMS(location)
	{	
	   try {
			netscape.security.PrivilegeManager.enablePrivilege("UniversalBrowserRead UniversalPreferencesWrite");
	   } catch (e) {
			//alert("Permission UniversalBrowserRead denied.");
	   }
		var ajax = new Ajax();
		ajax.method = 'POST';
		ajax.setMimeType('text/html');
		ajax.setHandlerBoth(fillForecast);
		ajax.postData = "CF=C" + "&LangID=<?=$lang_idx?>" + "&DayAndDate=<?=$Day_And_Date[$lang_idx]?>" + "&LocationId=" + location + "&WeatherAndTemprature=<?=$Day_And_Date[$lang_idx]?>" + "&align=<?=get_s_align()?>";
		ajax.url = 'https://www.ims.gov.il/IMS/Pages/IsrCitiesForeCast.aspx';
		ajax.doReq();
		
	}
	
       
	var json_data;
	var regionArray = new Array();
	var t;
	var t1 = null;

	function check_climate(item) {
		var hvValue = false;
		var climate = cityObj[0].climate.climateMonth;
		for(var i = 0; i < climate.length; i++) {
			if(item == "maxTempC" && climate[i].maxTemp != null && climate[i].maxTemp != '') {
				hvValue = true;
				break;
			}
			if(item == "minTempC" && climate[i].minTemp != null && climate[i].minTemp != '') {
				hvValue = true;
				break;
			}
			if(item == "maxTempF" && climate[i].maxTempF != null && climate[i].maxTempF != '') {
				hvValue = true;
				break;
			}
			if(item == "minTempF" && climate[i].minTempF != null && climate[i].minTempF != '') {
				hvValue = true;
				break;
			}
			if(item == "meanTempC" && climate[i].meanTemp != null && climate[i].meanTemp != '') {
				hvValue = true;
				break;
			}
			if(item == "meanTempF" && climate[i].meanTempF != null && climate[i].meanTempF != '') {
				hvValue = true;
				break;
			}
			if(item == "raindays" && climate[i].raindays != null && climate[i].raindays != '') {
				hvValue = true;
				break;
			}
			if(item == "rainfall" && climate[i].rainfall != null && climate[i].rainfall != '') {
				hvValue = true;
				break;
			}
		}
		return hvValue;
	}

	function change_temp_unit() {
		var unit = getCookie('tempUnit_e') || sessvars.tempUnit;
		if(isCookieEnabled) {
			if(unit == "C") {
				setCookie('tempUnit_e', 'F', 30);
			} else {
				setCookie('tempUnit_e', 'C', 30);
			}
		} else {
			if(unit == "C") {
				sessvars.tempUnit = "F";
			} else {
				sessvars.tempUnit = "C";
			}
		}
		var currentTempUnit = getCookie('tempUnit_e') || sessvars.tempUnit;
		load_forecast(currentTempUnit);
		load_highchart(currentTempUnit);
		load_table(currentTempUnit);
		initialize_temp_unit(currentTempUnit);
	}
	function initialize_temp_unit(unit) {
		var c = (unit == "C") ? '<strong>°C</strong>' : '°C';
		var f = (unit == "F") ? '<strong>°F</strong>' : '°F';
		$('#temp_unit').html(c + '|' + f).attr({'title': 'Click here to show temperature in °' + ((unit == "C") ? "F" : "C")});
	}

	function hash_raintype(type, txt, sen) {
		var name = '';
		switch(type) {
			case 'rainfall':
				name = (txt == 'rf') ? 'Rainfall' : 'Rain';
				if(sen == 1) {name = (txt == 'rf') ? '<?=$RAIN_TOTAL[$lang_idx]?>' : '<?=$RAIN_TOTAL[$lang_idx]?>';}
				break;
			case 'PPT':
				name = '<?=$PRECIPITATION[$lang_idx]?>';
				if(sen == 1) {name = '<?=$RAIN_TOTAL[$lang_idx]?>';}
				break;
			default:
				name = (txt == 'rf') ? 'Rainfall' : 'Rain';
				if(sen == 1) {name = (txt == 'rf') ? '<?=$RAIN_TOTAL[$lang_idx]?>' : '<?=$RAIN_TOTAL[$lang_idx]?>';}
		}
		return name;
	}

	//Load Climatological Information in Table
	function load_table(unit) {
		if(!check_climate("minTemp" + unit) && !check_climate("maxTemp" + unit) && !check_climate("meanTemp" + unit) && !check_climate("raindays") && !check_climate("rainfall")) {
			$('#climateTable').html('<div class="not_available">Climatology information currently not available.</div>');
		} else {
		
			$('#climateTable').each(function() {
				$('table', this).remove();
			});
		
			var months = [ "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12" ];
			var na = false;
		
			var climate_tbl = $('<table></table>').attr({ class: "climateTable" });
			//table header
			var header = $('<tr></tr>').css({'color':'#FFFFFF','background-color':'#003366'}).appendTo(climate_tbl);
			$('<th></th>').attr({'style': 'width:66px;'}).html("<?=$MONTH[$lang_idx]?>").appendTo(header);
			
			if(check_climate("minTemp" + unit)) {
				$('<th></th>').attr({'style': 'width:200px;'}).html("<?=$DAILY_MIN[$lang_idx]?> (°" + unit + ")").appendTo(header);
			}
			if(check_climate("maxTemp" + unit)) {
				$('<th></th>').attr({'style': 'width:200px;'}).html("<?=$DAILY_MAX[$lang_idx]?> (°" + unit + ")").appendTo(header);
			}
			if(!check_climate("minTemp" + unit) && !check_climate("maxTemp" + unit) && check_climate("meanTemp" + unit)) {
				$('<th></th>').html("Mean Temperature (°" + unit + ")").appendTo(header);
			}
			if(check_climate("rainfall")) {
				$('<th></th>').html(hash_raintype(cityObj[0].climate.raintype, 'rf', 1) + "<br>(mm)").appendTo(header);
			}
			if(check_climate("raindays")) {
				$('<th></th>').html((cityObj[0].climate.raintype == 'PPT') ? '<?=$RAINY_DAYS[$lang_idx]?>' : '<?=$RAINY_DAYS[$lang_idx]?>').appendTo(header);
			}
			
			for(var i = 0; i < cityObj[0].climate.climateMonth.length; i++) {
				var rowbgcolor = (i % 2 == 0) ? '#FFFFFF' : '#ECF1FF';
				var row = $('<tr></tr>').appendTo(climate_tbl);
				$('<td></td>').attr({ 'align': 'center'}).css({'color':'#FFFFFF','background-color':'#003366'}).html(months[(cityObj[0].climate.climateMonth[i].month - 1)]).appendTo(row);
				if(unit == "C") {
					if(check_climate("minTemp" + unit)) {
						if(cityObj[0].climate.climateMonth[i].minTemp != '')
							$('<td></td>').attr({ 'align': 'center'}).css({'color':'#0000FF','background-color':rowbgcolor}).html(parseFloat(cityObj[0].climate.climateMonth[i].minTemp)).appendTo(row);
						else {
							$('<td></td>').attr({ 'align': 'center'}).css({'color':'#0000FF','background-color':rowbgcolor}).html('/').appendTo(row);
							na = true;
						}
					}
					if(check_climate("maxTemp" + unit)) {
						if(cityObj[0].climate.climateMonth[i].maxTemp != '') 
							$('<td></td>').attr({ 'align': 'center'}).css({'color':'#D70000','background-color':rowbgcolor}).html(parseFloat(cityObj[0].climate.climateMonth[i].maxTemp)).appendTo(row);
						else {
							$('<td></td>').attr({ 'align': 'center'}).css({'color':'#D70000','background-color':rowbgcolor}).html('/').appendTo(row);
							na = true;
						}
					}
					if(!check_climate("minTemp" + unit) && !check_climate("maxTemp" + unit) && check_climate("meanTemp" + unit)) {
						if(cityObj[0].climate.climateMonth[i].meanTemp != '') 
							$('<td></td>').attr({ 'align': 'center'}).css({'color':'#990000','background-color':rowbgcolor}).html(parseFloat(cityObj[0].climate.climateMonth[i].meanTemp)).appendTo(row);
						else {
							$('<td></td>').attr({ 'align': 'center'}).css({'color':'#990000','background-color':rowbgcolor}).html('/').appendTo(row);
							na = true;
						}
					}
				}
				if(unit == "F") {
					if(check_climate("minTemp" + unit)) {
						if(cityObj[0].climate.climateMonth[i].minTempF != '')
							$('<td></td>').attr({ 'align': 'center'}).css({'color':'#0000FF','background-color':rowbgcolor}).html(parseFloat(cityObj[0].climate.climateMonth[i].minTempF)).appendTo(row);
						else {
							$('<td></td>').attr({ 'align': 'center'}).css({'color':'#0000FF','background-color':rowbgcolor}).html('/').appendTo(row);
							na = true;
						}
					}
					if(check_climate("maxTemp" + unit)) {
						if(cityObj[0].climate.climateMonth[i].maxTempF != '') 
							$('<td></td>').attr({ 'align': 'center'}).css({'color':'#D70000','background-color':rowbgcolor}).html(parseFloat(cityObj[0].climate.climateMonth[i].maxTempF)).appendTo(row);
						else {
							$('<td></td>').attr({ 'align': 'center'}).css({'color':'#D70000','background-color':rowbgcolor}).html('/').appendTo(row);
							na = true;
						}
					}
					if(!check_climate("minTemp" + unit) && !check_climate("maxTemp" + unit) && check_climate("meanTemp" + unit)) {
						if(cityObj[0].climate.climateMonth[i].meanTempF != '') 
							$('<td></td>').attr({ 'align': 'center'}).css({'color':'#990000','background-color':rowbgcolor}).html(parseFloat(cityObj[0].climate.climateMonth[i].meanTempF)).appendTo(row);
						else {
							$('<td></td>').attr({ 'align': 'center'}).css({'color':'#990000','background-color':rowbgcolor}).html('/').appendTo(row);
							na = true;
						}
					}
				}
				if(check_climate("rainfall")) {
					if(cityObj[0].climate.climateMonth[i].rainfall != '') 
						$('<td></td>').attr({ 'align': 'center'}).css({'color':'#008000','background-color':rowbgcolor}).html(parseFloat(cityObj[0].climate.climateMonth[i].rainfall)).appendTo(row);
					else {
						$('<td></td>').attr({ 'align': 'center'}).css({'color':'#008000','background-color':rowbgcolor}).html('/').appendTo(row);
						na = true;
					}
				}
				if(check_climate("raindays")) {
					if(cityObj[0].climate.climateMonth[i].raindays != '') {
						if(cityObj[0].climate.climateMonth[i].raindays == 'NULL')
							$('<td></td>').attr({ 'align': 'center'}).css({'background-color':rowbgcolor}).html(cityObj[0].climate.climateMonth[i].raindays).appendTo(row);
						else
							$('<td></td>').attr({ 'align': 'center'}).css({'background-color':rowbgcolor}).html(parseFloat(cityObj[0].climate.climateMonth[i].raindays)).appendTo(row);
					} else {
						$('<td></td>').attr({ 'align': 'center'}).css({'background-color':rowbgcolor}).html('/').appendTo(row);
						na = true;
					}
				}
			}
			
			climate_tbl.appendTo($("#climateTable"));
			
						var remark = '<div align="left"><strong>Remark</strong></div>';
			remark += '<ol align="left" class="remark_container">';
			
			if(na)
				remark += '<li>"/" - Not available.</li>';
			
			if(cityObj[0].member.memId == 1)
				remark += '<li>Forecast is provided by the China Meteorological Administration.</li>';
			
			if(cityObj[0].climate.climatefromclino != '') {
				remark += '<li>Climatological information is based on WMO Climatological Normals(CLINO)';
				if(cityObj[0].climate.datab != '' && cityObj[0].climate.datae != '') {
					remark += ' for the ' + (parseInt(cityObj[0].climate.datae) - parseInt(cityObj[0].climate.datab) + 1) + '-year period ' + cityObj[0].climate.datab + '-' + cityObj[0].climate.datae;
				}
				remark += '.</li>';
			} else {
				if(cityObj[0].climate.datab != '' && cityObj[0].climate.datae != '') {
					remark += '<li>Climatological information is based on monthly averages for the ' + (parseInt(cityObj[0].climate.datae) - parseInt(cityObj[0].climate.datab) + 1) + '-year period ' + cityObj[0].climate.datab + '-' + cityObj[0].climate.datae + '.</li>';
				}
			}
			
			if(cityObj[0].climate.tempb != '' && cityObj[0].climate.tempe != '') {
				remark += '<li>Mean temperature is based on monthly averages for the period ' + cityObj[0].climate.tempb + '-' + cityObj[0].climate.tempe + '.</li>';
			}
			
			if(cityObj[0].climate.rdayb != '' && cityObj[0].climate.rdaye != '') {
				remark += '<li>Mean number of ' + hash_raintype(cityObj[0].climate.raintype, 'rd', 0).toLowerCase() + ' days is based on monthly averages for the period ' + cityObj[0].climate.rdayb + '-' + cityObj[0].climate.rdaye + '.</li>';
			}
			
			if(cityObj[0].climate.rainfallb != '' && cityObj[0].climate.rainfalle != '') {
				remark += '<li>Mean total ' + hash_raintype(cityObj[0].climate.raintype, 'rf', 0).toLowerCase() + ' is based on monthly averages for the period ' + cityObj[0].climate.rainfallb + '-' + cityObj[0].climate.rainfalle + '.</li>';
			}
			
			if(cityObj[0].climate.raindef != '') {
				var rainunit = (cityObj[0].climate.rainunit != '') ? ' ' + cityObj[0].climate.rainunit : ' ';
				remark += '<li>Mean number of ' + hash_raintype(cityObj[0].climate.raintype, 'rd', 0).toLowerCase() + ' days = Mean number of days with at least ' + cityObj[0].climate.raindef + rainunit + ' of ' + hash_raintype(cityObj[0].climate.raintype, 'rd', 0).toLowerCase() + '.</li>';
			}
			if(cityObj[0].climate.raintype == "PPT") {
				remark += '<li>Precipitation includes both rain and snow.</li>';
			}
			
			remark += '<li>Attention: Please note that the averaging period for climatological information and the definition of "Mean Number of ' + hash_raintype(cityObj[0].climate.raintype, 'rd', 0) + ' Days" quoted in this web site may be different for different countries. Hence, care should be taken when city climatologies are compared.</li>';
			
			remark += '</ol>';
			
			$('#remark').html(remark);
			
					}
	}

	//Load Climatological Information in High Chart API
	function load_highchart(unit) {
		if(!check_climate("minTemp" + unit) && !check_climate("maxTemp" + unit) && !check_climate("meanTemp" + unit) && !check_climate("rainfall")) {
			$('#climateContainer').css({'display': 'none'});
		} else {
			$('#climateContainer').css({'display': 'block'});
			var primary_yAxis = { // Primary yAxis
					labels: {
						format: '{value}°' + unit,
						style: {
							color: '#000000'
						}
					},
					title: {
						text: '<?=$TEMP[$lang_idx]?>',
						style: {
							color: '#000000',
							fontSize: '120%',
							fontWeight: 'bold',
							fontFamily: 'Verdana'
						}
					}
				};
			var secondary_yAxis = { // Secondary yAxis
					labels: {
						format: '{value} mm',
						style: {
							color: '#000000'
						}
					},
					title: {
						text: hash_raintype(cityObj[0].climate.raintype, 'rf', 0),
						style: {
							color: '#000000',
							fontSize: '120%',
							fontWeight: 'bold',
							fontFamily: 'Verdana'
						}
					},
					opposite: true
				};
			
			var mean_total_rf_or_ppt = {
					name: hash_raintype(cityObj[0].climate.raintype, 'rf', 1),
					color: '#008000',
					type: 'column',
					yAxis: 0,
					data: [null, null, null, null, null, null, null, null, null, null, null, null],
					tooltip: {
						valueSuffix: ' mm'
					}
				};
			var maximum_temperature = {
					name: '<?=$DAILY_MAX[$lang_idx]?>',
					color: '#D70000',
					type: 'spline',
					data: [null, null, null, null, null, null, null, null, null, null, null, null],
					tooltip: {
						valueSuffix: '°' + unit
					}
				};
			var minimum_temperature = {
					name: '<?=$DAILY_MIN[$lang_idx]?>',
					color: '#0000FF',
					type: 'spline',
					data: [null, null, null, null, null, null, null, null, null, null, null, null],
					tooltip: {
						valueSuffix: '°' + unit
					}
				};
			var mean_temperature = {
					name: 'Mean Temperature',
					color: '#990000',
					type: 'spline',
					data: [null, null, null, null, null, null, null, null, null, null, null, null],
					tooltip: {
						valueSuffix: '°' + unit
					}
				};
			
			var prepareChartData = {
				chart: {
					renderTo: 'climateContainer',
					zoomType: 'xy',
					backgroundColor: {
						linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1},
						stops: [
							[0, 'rgb(255, 255, 255)'],
							[1, 'rgb(252, 255, 197)']
						]
					},
					borderRadius: 10,
					style: {
						fontFamily: 'Verdana',
					}
				},
				title: {
					text: '',
					style: {
						fontSize: '150%',
						fontWeight: 'bold',
						fontFamily: 'Verdana'
					}
				},
				subtitle: {
					text: '30-year period'
				},
				xAxis: [{
					categories: ['01', '02', '03', '04', '05', '06',
						'07', '08', '09', '10', '11', '12'],
					title: {text: '<?=$MONTH[$lang_idx]?>', style: {fontWeight: 'bold', fontFamily: 'Verdana', color: '#000000'}}
				}],
				credits: {
						enabled: false,
				},
				yAxis: [],
				tooltip: {
						shared: true,
					style: {
						fontWeight: 'bold'
					}
				},
				legend: {
					layout: 'vertical',
					align: 'left',
					x: 70,
					verticalAlign: 'top',
					y: 20,
					floating: true,
					backgroundColor: 'transparent'
				},
				series: []
			};
			
			prepareChartData.title.text = cityObj[0].cityName;
			
			var yAxisOffset = 0;
			if((check_climate("minTemp" + unit) && check_climate("maxTemp" + unit)) || check_climate("meanTemp" + unit)) {
				prepareChartData.yAxis[yAxisOffset++] = primary_yAxis;
				mean_total_rf_or_ppt.yAxis = 1;
			}
			var seriesOffset = 0;
			if(check_climate("rainfall")) {
				prepareChartData.yAxis[yAxisOffset++] = secondary_yAxis;
				prepareChartData.series[seriesOffset++] = mean_total_rf_or_ppt;
			}
			if(check_climate("minTemp" + unit) && check_climate("maxTemp" + unit)) {
				prepareChartData.series[seriesOffset++] = maximum_temperature;
				prepareChartData.series[seriesOffset++] = minimum_temperature;
			} else {
				if(check_climate("meanTemp" + unit)) {
					prepareChartData.series[seriesOffset++] = mean_temperature;
				}
			}
			
			for(var i = 0; i < cityObj[0].climate.climateMonth.length; i++) {
				var offset = 0;
				if(check_climate("rainfall")) {
					prepareChartData.series[offset++].data[i] = parseFloat(cityObj[0].climate.climateMonth[i].rainfall);
				}
				if(unit == "C" && check_climate("maxTemp" + unit) && check_climate("minTemp" + unit)) {
					if(cityObj[0].climate.climateMonth[i].maxTemp != '')
						prepareChartData.series[offset].data[i] = parseFloat(cityObj[0].climate.climateMonth[i].maxTemp);
					offset++;
					if(cityObj[0].climate.climateMonth[i].minTemp != '')
						prepareChartData.series[offset].data[i] = parseFloat(cityObj[0].climate.climateMonth[i].minTemp);
				} else {
					if(unit == "C" && check_climate("meanTemp" + unit)) {
						prepareChartData.series[offset++].data[i] = parseFloat(cityObj[0].climate.climateMonth[i].meanTemp);
					}
				}
				if(unit == "F" && check_climate("maxTemp" + unit) && check_climate("minTemp" + unit)) {
					if(cityObj[0].climate.climateMonth[i].maxTempF != '')
						prepareChartData.series[offset].data[i] = parseFloat(cityObj[0].climate.climateMonth[i].maxTempF);
					offset++;
					if(cityObj[0].climate.climateMonth[i].minTempF != '')
						prepareChartData.series[offset].data[i] = parseFloat(cityObj[0].climate.climateMonth[i].minTempF);
				} else {
					if(unit == "F" && check_climate("meanTemp" + unit)) {
						prepareChartData.series[offset++].data[i] = parseFloat(cityObj[0].climate.climateMonth[i].meanTempF);
					}
				}
			}
			
			var chart = new Highcharts.Chart(prepareChartData);
		}
	}

	//Load Weather Forecast Information
	function load_forecast(unit) {
		if(cityObj[0].forecast.forecastDay.length == 0) {
			$('#forecastTable').css('display', 'none');
			$('#forecastDetails').css('display', 'block');
			$('#forecastDetails').html('<div class="not_available">Weather forecast information is not available at this moment.</div>');
		} else {
			$('#forecastDetails').html('');
			$('#forecastDetails').css('display', 'none');
			$('#forecastTable').css('display', 'block');
			var tz = '';
			switch(cityObj[0].forecast.timeZone) {
				case "Local":
					tz = "Local Time";
					break;
				case "UTC":
					tz = "Coordinated Universal Time";
					break;
				case "EDT":
					tz = "Eastern Daylight Time";
					break;
			}
			var i_d = moment(cityObj[0].forecast.issueDate).lang(localLang).format('ll');
			var i_t = moment(cityObj[0].forecast.issueDate).lang(localLang).format('LT');
						$('#issue_date').html('Issued at ' + i_t + ' \(' + tz + '\) ' + i_d);			$('#forecast_unit').html(unit);
			
			$('#forecastTable').each(function() {
				$('tr:not(:first)', this).remove();
			});
		
			for(var i = 0; i < cityObj[0].forecast.forecastDay.length; i++) {
				var icon = cityObj[0].forecast.forecastDay[i].weatherIcon.toString().substr(0, (cityObj[0].forecast.forecastDay[i].weatherIcon.toString().length - 2));
				if(icon.length == 1)
					icon = "0" + icon;
				var forecast_row = '<tr>';
				
				var f_d = moment(cityObj[0].forecast.forecastDay[i].forecastDate).lang(localLang).format('D/M<br/>ddd');
				f_d = replaceDays(f_d, <?=$lang_idx?>);
				forecast_row += '<td align="center" style="width: 80px;">' + f_d + '</td>';
				
				if(unit == "C") {
					forecast_row += '<td align="center"><span class="min_temp">' + ((cityObj[0].forecast.forecastDay[i].minTemp != null && cityObj[0].forecast.forecastDay[i].minTemp != '') ? cityObj[0].forecast.forecastDay[i].minTemp : ' - ') + '</span> / <span class="max_temp">' + ((cityObj[0].forecast.forecastDay[i].maxTemp != null && cityObj[0].forecast.forecastDay[i].maxTemp != '') ? cityObj[0].forecast.forecastDay[i].maxTemp : ' - ') + '</span></td>';
				}
				if(unit == "F") {
					forecast_row += '<td align="center"><span class="min_temp">' + ((cityObj[0].forecast.forecastDay[i].minTempF != null && cityObj[0].forecast.forecastDay[i].minTempF != '') ? cityObj[0].forecast.forecastDay[i].minTempF : ' - ') + '</span> / <span class="max_temp">' + ((cityObj[0].forecast.forecastDay[i].maxTempF != null && cityObj[0].forecast.forecastDay[i].maxTempF != '') ? cityObj[0].forecast.forecastDay[i].maxTempF : ' - ') + '</span></td>';
				}
				
				var wxdesc = cityObj[0].forecast.forecastDay[i].weather;
				if(cityObj[0].forecast.forecastDay[i].wxdesc.length > 0) {
					wxdesc = cityObj[0].forecast.forecastDay[i].wxdesc;
				}
								
				forecast_row += '<td style="width: 80px;" ><div style="margin-left: 45px;" class="img_set wxicon_div wxicon_' + icon + '" title="' + wxdesc + '"></div></td>';
				forecast_row += '<td >' + wxdesc + '</td>';
				
				forecast_row += '</tr>';
				$('#forecastTable tr:last').after(forecast_row);
			}
		}
	}

	//build the website breadcrumb
	function build_breadcrumb() {
		$('#breadcrumb').append('<li><a href="./region.html?ra=' + cityObj[0].member.ra + '">' + regionArray[(cityObj[0].member.ra - 1)] + '</a> &gt;</li>');
		$('#breadcrumb').append('<li><a href="./country.html?countryCode=' + cityObj[0].member.memId + '">' + cityObj[0].member.memName + '</a> &gt;</li>');
		$('#breadcrumb').append('<li><a href="./city.html?cityId=' + cityObj[0].cityId + '">' + cityObj[0].cityName + '</a></li>');
	}

	//make the favorite button become add to list/ remove from list
	function favButton_handler(cityId) {
		if(isCookieEnabled) {
			$('#add1').css("visibility", "visible");
			if(!isExistInCookie('myFavorite_e', '|', 'c#' + cityId)) {
				$('#add1').attr({'href': 'javascript:addToMyFavoriteList(' + cityId + ', \'c\', \'favButton\', false);', 'title': 'Click here to add city as my favourite'});
			} else {
				$('#add1').css("visibility", "hidden");
			}
		} else {
			$('#add1').css("visibility", "hidden");
		}
	}

	function loadCurrentLocalTime() {
		$('#localTime').html(moment(new Date()).lang(localLang).zone(cityObj[0].timeZone).format('llll'));
		if(t1!=null){clearTimeout(t1);t1=null;}
		t1 = setTimeout(function(){loadCurrentLocalTime()},500);
	}
	
	//setup content include city info, initialize fav button, initaialize map 
	//              and call function that load the weather forecast + climatological information + tourism information
	function setup_content() {
		
		$('title').html("World Weather Information Service - " + cityObj[0].cityName);
		
		$('#city_name1').html(cityObj[0].cityName + '<a id="add1" href="" title=""><span class="add"></span></a>');
		/*$('#country_name2').html('<a href="./country.html?countryCode=' + cityObj[0].member.memId + '">' + cityObj[0].member.memName + '</a>');
		if(cityObj[0].member.logo.length > 0)
			$('#logo').html('<a href="http://' + cityObj[0].member.url + '" target="_blank"><img src="../images/logo/' + cityObj[0].member.logo + '" alt="' + cityObj[0].member.orgName + '"></a>');
		if(cityObj[0].member.orgName != '' && cityObj[0].member.orgName != null)
			$('#website').html('<a href="http://' + cityObj[0].member.url + '" target="_blank">' + cityObj[0].member.orgName + '</a>');
		
		if(cityObj[0].tourismURL != '' && cityObj[0].tourismURL != null && cityObj[0].tourismBoardName != '' && cityObj[0].tourismBoardName != null) {
			$('#tourismInfo').append(
				$('<a>').attr({'href': 'http://' + cityObj[0].tourismURL, 'target': '_blank'}).html(cityObj[0].tourismBoardName)
			);
		} else {
			$('#tourism').hide();
		}
		
		//initialize fav button
		favButton_handler(cityObj[0].cityId);
		
		loadCurrentLocalTime();*/
		
		var currentTempUnit = getCookie('tempUnit_e') || sessvars.tempUnit;
                currentTempUnit = "C";
		load_forecast(currentTempUnit);
		load_highchart(currentTempUnit);
		load_table(currentTempUnit);
		//initialize_temp_unit(currentTempUnit);
		
		//t2 = setTimeout(function(){clearTimeout(t);ajax_get_member_info(cityObj[0].member.memId);},150);
	}
        
        function replaceDays(str, lang) {
    
            if (lang == 1) {
                str = str.replace("Sun", " א ");
                str = str.replace("Mon", " ב ");
                str = str.replace("Tue", " ג ");
                str = str.replace("Wed", " ד ");
                str = str.replace("Thu", " ה ");
                str = str.replace("Fri", " ו ");
                str = str.replace("Sat", " ש ");
            }
            return str;
        }
	//Get region name from JSON file
	function ajax_get_region_info() {
		$.ajax({
			url: "./json/Region_en.xml",
			type: "GET",
			dataType: "text",
			success: function(Jdata) {
				var regionObj = getObjects(JSON.parse(Jdata), 'id', '');
				if(regionObj.length > 0) {
					for(var i = 0; i < regionObj.length; i++) {
						regionArray.push(regionObj[i].name);
					}
					build_breadcrumb();
				} else {
					console.log('nothing');
				}
			},
			error: function() {
				console.log("ERROR!!!");
			}
		});
	}

	//Place marker of cities that belong to related country of selected city
	function ajax_get_member_info(memId) {
		$.ajax({
			url: "./json/Country_en.xml",
			type: "GET",
			dataType: "text",
			success: function(Jdata) {
				var memberCityObj = getObjects(JSON.parse(Jdata), 'memId', memId);
				
				if(memberCityObj[0].city.length > 0) {
					var currentMapType = getCookie('mapType_e') || sessvars.mapType;
					if(pageLang == 'zh')
						currentMapType = getCookie('mapTypeC_e') || sessvars.mapTypeC;
					switch(currentMapType) {
																								case 'openstreet':
							if(cityObj[0].cityId == 1954) {
								init_openstreetmap(parseFloat(cityObj[0].cityLatitude), parseFloat(cityObj[0].cityLongitude), 'country_openstreetmap_canvas', 3, memberCityObj[0].city, 'city');
							}else{					
								init_openstreetmap(parseFloat(memberCityObj[0].countryLatitude), parseFloat(memberCityObj[0].countryLongitude), 'country_openstreetmap_canvas', memberCityObj[0].szmlv, memberCityObj[0].city, 'city');
							}
							t = setTimeout(function(){clearTimeout(t);openstreetGetMarkerByCityID(GetURLParameter('cityId'));},500);
							break;
																		default:
							//do nothing;
					}
				} else {
					console.log("ERROR!!!");
				}
			},
			error: function() {
				console.log("ERROR!!!");
			}
		});
	}

	//Use city id to get city info from JSON file
	function ajax_get_city_info(cityId) {
		$.ajax({
			url: "<?=BASE_URL?>/forecast/getForecastService.php?location=https://worldweather.wmo.int/en/json/" + cityId + "_en.xml",
			type: "GET",
			dataType: "text",
			success: function(Jdata) {
				json_data = JSON.parse(Jdata);
				cityObj = getObjects(json_data, 'cityId', cityId);
				if(cityObj.length > 0) {
					//ajax_get_region_info();
					setup_content();
				} else {
					console.log('nothing');
				}
			},
			error: function() {
				console.log("ERROR!!!");
			}
		});
	}
		$(document).ready(function() {
		if(isCookieEnabled && getCookie('fontsize_e') != null)
			changeFontSize(getCookie('fontsize_e'));
		else {
			var fsv = sessvars.fontsize || '0';
			changeFontSize(fsv);
		}
								$('#country_openstreetmap_canvas').css({'display': 'none'});
						
		var currentMapType = getCookie('mapType_e') || sessvars.mapType;
		if(pageLang == 'zh')
			currentMapType = getCookie('mapTypeC_e') || sessvars.mapTypeC;
		$('#country_' + currentMapType + 'map_canvas').css({'display': 'block'});

		var param_val = GetURLParameter('cityId');

		$('.linktop').attr({'href': './city.html?cityId=' + param_val + '#top'});
		
		if((/^([1-9]|[1-9][0-9]|[1-9][0-9][0-9]|[1-9][0-9][0-9][0-9])$/.test(param_val))) {
			//console.log('match 1 - 4 digit');
			ajax_get_city_info(param_val);
		} else {
		//	alert ('not_found');
		}

		$('.add_fav_btn1').css({'margin-left': '160px'});
		
			});
		$('ul.select li').click(function(e){
		var item = $(e.target);
		item.addClass('selected');
		item.siblings().removeClass('selected');
		$('#events').val(item.text());
		<?if (@$_GET['region'] == 'isr'){?>
			getForecastService(item.attr('value'));
		<?}else{?>
			getForecastService(item.attr('value'));
		<?}?>
		
		});
	</script>
        
        
        
        
        
        
        
</script>

