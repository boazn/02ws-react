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
        float:right;text-align:center;padding:0 1em
    }
    #wrapperclimate{
        clear:both;padding:0.8em
    }
    #wrapperclimate td{
        box-shadow:0 1px 5px rgba(0,0,0,0.2)
    }
        
</style>
<SCRIPT type="text/javascript" language="Javascript" SRC="ajax.js">
</SCRIPT>
	<br />
	<h2><? if (@$_GET['region'] == 'isr') echo $FORECAST_ISR[$lang_idx]; else echo $FORECAST_ABROD[$lang_idx]; ?></h2>
	<h3><? if (@$_GET['region'] != 'isr') echo $TEMP[$lang_idx]." & ".$FORECAST[$lang_idx]." - ".$RELYABLE_FORACST[$lang_idx]; ?></h3>

<div <? if (isHeb()) echo "dir=\"rtl\" ";?> style="width:100%;margin:0 auto;float:<?echo get_inv_s_align();?>" class="inv_plain_3">


	<div style="width:40%;text-align:center;float:<?echo get_s_align();?>;padding:1em" >
		<form method="post" name="forecastSubmit">
			<select style="width:340px" name="locations[]" size="14" multiple align="center" 
			  onchange="getForecastService<? if (@$_GET['region'] == 'isr') echo "";?>(this[this.selectedIndex].value)"  <? if (!isHeb()) echo "dir=\"ltr\" ";?>>
					<? 
					if (@$_GET['region'] == 'isr')
						include "israel_list.php";
					else
						include "forecast_list.php";?>
			</select>
		</form>
		<div class="inv_plain_3_zebra" style="width: 60%;margin: 0 auto;padding:0.2em">
		<a href="<? echo get_query_edited_url(get_url(), 'section', 'SendEmailForm.php');?>" >
		<? if (isHeb()) echo "בקשו יעד משלכם"; else echo "Ask for other location"; ?>
		</a>
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
		src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
		</script>
		</div>
		

	</div>
	<div id="forecastDetails" style="width:55%;text-align:center;float:<?echo get_s_align();?>">
	</div>
	
</div>
<? echo "<div>".$SOURCE[$lang_idx].": ".$IMS[$lang_idx]."</div>"; ?>
<script>
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
		var ajax = new Ajax();
		ajax.setMimeType('text/xml');
		ajax.doGet('forecast/getForecastService.php?lang=<?=$lang_idx?>&location=' + location, fillForecast);
		
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
		ajax.url = 'http://www.ims.gov.il/IMS/Pages/IsrCitiesForeCast.aspx';
		ajax.doReq();
		
	}
	
</script>

