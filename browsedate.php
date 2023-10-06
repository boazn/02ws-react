
<?php

include_once("include.php"); 
include_once("lang.php");
include_once("start.php");
ini_set("display_errors","On");
$empty = $post = array();
foreach ($_POST as $varname => $varvalue) {
   if (empty($varvalue)) {
       $empty[$varname] = $varvalue;
   } else {
       $post[$varname] = $varvalue;
   }
}
if (empty($empty)) {
   //print "None of the POSTed values are empty, posted:\n";
   //var_dump($post);
} else {
   $result .= "We have " . count($empty) . " empty values\n";
   $result .= "Posted:\n"; var_dump($post);
   $result .= "Empty:\n";  var_dump($empty);
   
}
$current_year = $year;
$min_year = 1909;
function isDaySubmited($value_day){
	global $_POST;
	if (!isset($_POST['browseday']))
		$_POST['browseday'] = "";
	if ($_POST['browseday']=== $value_day)
			return true;
	return false;
}
function isMonthSubmited($value_month){
	global $_POST;
	if (!isset($_POST['browsemonth']))
		$_POST['browsemonth'] = "";
	if ($_POST['browsemonth']=== $value_month)
			return true;
		return false;
}
function isYearSubmited($value_year){
	global $_POST;
	
	if (!isset($_POST['browseyear']))
		$_POST['browseyear'] = "";
	if ($_POST['browseyear']== $value_year)
		return true;
	
	return false;
}
?>
<?
				$yearToSearch =  sprintf ( "%04d", $_POST['browseyear']);
				$date = sprintf ( "%d-%02d-%02d", $yearToSearch, $_POST['browsemonth'] ,$_POST['browseday']);
				$shortyear = sprintf ("%02d", $_POST['browseyear'] - 2000);
				$shortdate = sprintf ( "%02d/%02d/%02d", $_POST['browseday'], $_POST['browsemonth'] , $shortyear);
				$date_db = sprintf ( "%04d-%02d-%02d", $yearToSearch, $_POST['browsemonth'], $_POST['browseday']);
				// take values from input form of the homepage
				if (isset( $_POST['inputtext_search']))
					if ($_POST['browsesearch']=='temp_search'){
						$_POST['temp_search'] = "on";
						$_POST['low_temp'] = $_POST['inputtext_search'];
						$_POST['high_temp'] = $_POST['inputtext_search'];
					}
					if ($_POST['browsesearch']=='hum_search'){
						$_POST['hum_search'] = "on";
						$_POST['low_hum'] = $_POST['inputtext_search'] - 1;
						$_POST['high_hum'] = $_POST['inputtext_search'] + 1;
					}
					if ($_POST['browsesearch']=='rainrate_search'){
						$_POST['rainrate_search'] = "on";
						$_POST['low_rainrate'] = $_POST['inputtext_search'] - 0.1;
						$_POST['high_rainrate'] = $_POST['inputtext_search'] + 0.2;
					}
					if ($_POST['browsesearch']=='windSpeed_search'){
						$_POST['windSpeed_search'] = "on";
						$_POST['low_windSpeed'] = $_POST['inputtext_search'] - 1;
						$_POST['high_windSpeed'] = $_POST['inputtext_search'] + 1;
					}

?>
<? if (!isset($_POST['submitdata'])) { ?>
<h1><? echo $ARCHIVE[$lang_idx];?></h1>
<div style="width:62%" class="float">
<table class="box" style="padding:0;margin:0" cellpadding="0" cellspacing="1" <? if (isHeb()) echo "dir=\"rtl\""; ?>>
<tr>
	<td>
	</td>
	<td>
	</td>
	<td>
	</td>
	<td><? echo $MIN[$lang_idx];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;&nbsp;<? echo $MAX[$lang_idx];?></td>
</tr>
<tr>
	<td <? echo get_inv_align(); ?> style="padding:0 1em 0 1em;margin:0"> 
				
				<P style="line-height:100%; margin-top:0; margin-bottom:0;text-align:center" dir="ltr">
				<select size="1" name="browseday" style="width:80px">
				<option value='' <?if (isDaySubmited("")) echo "selected";?>><? echo $DAY[$lang_idx];?></option>
				<option value='01' <?if (isDaySubmited("01")) echo "selected";?>>1</option>
				<option value='02' <?if (isDaySubmited("02")) echo "selected";?>>2</option>
				<option value='03' <?if (isDaySubmited("03")) echo "selected";?>>3</option>
				<option value='04' <?if (isDaySubmited("04")) echo "selected";?>>4</option>
				<option value='05' <?if (isDaySubmited("05")) echo "selected";?>>5</option>
				<option value='06' <?if (isDaySubmited("06")) echo "selected";?>>6</option>
				<option value='07' <?if (isDaySubmited("07")) echo "selected";?>>7</option>
				<option value='08' <?if (isDaySubmited("08")) echo "selected";?>>8</option>
				<option value='09' <?if (isDaySubmited("09")) echo "selected";?>>9</option>
				<option value='10' <?if (isDaySubmited("10")) echo "selected";?>>10</option>
				<option value='11' <?if (isDaySubmited("11")) echo "selected";?>>11</option>
				<option value='12' <?if (isDaySubmited("12")) echo "selected";?>>12</option>
				<option value='13' <?if (isDaySubmited("13")) echo "selected";?>>13</option>
				<option value='14' <?if (isDaySubmited("14")) echo "selected";?>>14</option>
				<option value='15' <?if (isDaySubmited("15")) echo "selected";?>>15</option>
				<option value='16' <?if (isDaySubmited("16")) echo "selected";?>>16</option>
				<option value='17' <?if (isDaySubmited("17")) echo "selected";?>>17</option>
				<option value='18' <?if (isDaySubmited("18")) echo "selected";?>>18</option>
				<option value='19' <?if (isDaySubmited("19")) echo "selected";?>>19</option>
				<option value='20' <?if (isDaySubmited("20")) echo "selected";?>>20</option>
				<option value='21' <?if (isDaySubmited("21")) echo "selected";?>>21</option>
				<option value='22' <?if (isDaySubmited("22")) echo "selected";?>>22</option>
				<option value='23' <?if (isDaySubmited("23")) echo "selected";?>>23</option>
				<option value='24' <?if (isDaySubmited("24")) echo "selected";?>>24</option>
				<option value='25' <?if (isDaySubmited("25")) echo "selected";?>>25</option>
				<option value='26' <?if (isDaySubmited("26")) echo "selected";?>>26</option>
				<option value='27' <?if (isDaySubmited("27")) echo "selected";?>>27</option>
				<option value='28' <?if (isDaySubmited("28")) echo "selected";?>>28</option>
				<option value='29' <?if (isDaySubmited("29")) echo "selected";?>>29</option>
				<option value='30' <?if (isDaySubmited("20")) echo "selected";?>>30</option>
				<option value='31' <?if (isDaySubmited("31")) echo "selected";?>>31</option>
				</select>/
				<select size="1" name="browsemonth" style="width:80px">
				<option value='' <?if (isMonthSubmited("")) echo "selected";?>><? echo $MONTH[$lang_idx];?></option>
				<option value='01' <?if (isMonthSubmited("01")) echo "selected";?>>1</option>
				<option value='02' <?if (isMonthSubmited("02")) echo "selected";?>>2</option>
				<option value='03' <?if (isMonthSubmited("03")) echo "selected";?>>3</option>
				<option value='04' <?if (isMonthSubmited("04")) echo "selected";?>>4</option>
				<option value='05' <?if (isMonthSubmited("05")) echo "selected";?>>5</option>
				<option value='06' <?if (isMonthSubmited("06")) echo "selected";?>>6</option>
				<option value='07' <?if (isMonthSubmited("07")) echo "selected";?>>7</option>
				<option value='08' <?if (isMonthSubmited("08")) echo "selected";?>>8</option>
				<option value='09' <?if (isMonthSubmited("09")) echo "selected";?>>9</option>
				<option value='10' <?if (isMonthSubmited("10")) echo "selected";?>>10</option>
				<option value='11' <?if (isMonthSubmited("11")) echo "selected";?>>11</option>
				<option value='12' <?if (isMonthSubmited("12")) echo "selected";?>>12</option>
				</select>/
				<select size="1" name="browseyear" style="width:80px">
				<option value=''><? echo $YEAR[$lang_idx];?></option>
				<?
				 for ($i_year = $current_year;$i_year >= $min_year ;$i_year--) 
				 {
					 echo  "<option value='".$i_year."' ";
					 if (isYearSubmited($i_year)) echo "selected";
					 echo ">".$i_year."</option>\n";
				 }
				?>
				</select>&nbsp;


				
	</td>
	<td <? echo get_align(); ?>>
		<input type="checkbox" name="time_search" id="time_search" <?if (isset( $_POST['time_search'])) echo "checked"; ?>> <? echo $SEARCH_IN[$lang_idx]; ?> <? echo $BETWEEN[$lang_idx]; ?>
		
	</td>
	<td <? echo get_inv_align(); ?>>
		 
	</td>
	<td <? echo get_align(); ?>>
		<input type="text" name="low_time" value=<?if ((isset( $_POST['low_time']))&&(isset( $_POST['time_search']))) echo $_POST['low_time']; else echo "00:00";?> SIZE="4">
		-- 
		<input type="text" name="high_time" value=<?if (isset( $_POST['high_time'])) echo $_POST['high_time']; else echo "23:45";?> SIZE="4">
		
	</td>
</tr>
<tr>
	<td <? echo get_inv_align(); ?>> </td>
	<td <? echo get_align(); ?>>
		<input type="checkbox" id="temp_search" <?if (isset( $_POST['temp_search'])) echo "checked"; ?>>  <? echo $TEMP[$lang_idx];?>  
		
	</td>
	<td <? echo get_inv_align(); ?>>
		
	</td>
	<td <? echo get_align(); ?>>
		<input type="text" name="low_temp" value=<?if ((isset( $_POST['low_temp']))&&(isset( $_POST['temp_search']))) echo $_POST['low_temp']; else echo "0";?> SIZE="4">
		-- 
		<input type="text" name="high_temp" value=<?if (isset( $_POST['high_temp'])) echo $_POST['high_temp']; else echo "100";?> SIZE="4">C
	</td>
</tr>
<tr>
	<td <? echo get_inv_align(); ?>> </td>
	<td <? echo get_align(); ?>>
		<input type="checkbox" id="high_temp_search" <?if (isset( $_POST['high_temp_search'])) echo "checked"; ?>>  <? echo $TEMP[$lang_idx]." ".$MAX[$lang_idx];?>  
		
	</td>
	<td <? echo get_inv_align(); ?>>
		
	</td>
	<td <? echo get_align(); ?>>
		<input type="text" name="low_high_temp" value=<?if ((isset( $_POST['low_high_temp']))&&(isset( $_POST['high_temp_search']))) echo $_POST['low_high_temp']; else echo "0";?> SIZE="4">
		-- 
		<input type="text" name="high_high_temp" value=<?if (isset( $_POST['high_high_temp'])) echo $_POST['high_high_temp']; else echo "100";?> SIZE="4">C
	</td>
</tr>
<tr>
	<td <? echo get_inv_align(); ?>> </td>
	<td <? echo get_align(); ?>>
		<input type="checkbox" id="low_temp_search" <?if (isset( $_POST['low_temp_search'])) echo "checked"; ?>>  <? echo $TEMP[$lang_idx]." ".$MIN[$lang_idx];?>  
		
	</td>
	<td <? echo get_inv_align(); ?>>
		
	</td>
	<td <? echo get_align(); ?>>
		<input type="text" name="low_low_temp" value=<?if ((isset( $_POST['low_low_temp']))&&(isset( $_POST['low_temp_search']))) echo $_POST['low_low_temp']; else echo "0";?> SIZE="4">
		-- 
		<input type="text" name="high_low_temp" value=<?if (isset( $_POST['high_low_temp'])) echo $_POST['high_low_temp']; else echo "100";?> SIZE="4">C
	</td>
</tr>
<tr>
	<td></td>
	<td <? echo get_align(); ?>>
		<input type="checkbox" id="hum_search" <?if (isset( $_POST['hum_search'])) echo "checked"; ?>> <? echo $HUMIDITY[$lang_idx];?> 
		
	</td>
	<td <? echo get_inv_align(); ?>>
		
	</td>
	<td <? echo get_align(); ?>>
		<input type="text" name="low_hum" value=<?if ((isset( $_POST['low_hum']))&&(isset( $_POST['hum_search']))) echo $_POST['low_hum']; else echo "0";?> SIZE=4>
		-- 
		<input type="text" name="high_hum" value=<?if (isset( $_POST['high_hum'])) echo $_POST['high_hum']; else echo "100";?> SIZE="4">%
	</td>
</tr>
<tr>
	<td></td>
	<td <? echo get_align(); ?>>
		<input type="checkbox" id="dew_search" <?if (isset( $_POST['dew_search'])) echo "checked"; ?>> <? echo $DEW[$lang_idx];?> 
		
	</td>
	<td <? echo get_inv_align(); ?>>
		
	</td>
	<td <? echo get_align(); ?>>
		<input type="text" name="low_dew" value=<?if ((isset( $_POST['low_dew']))&&(isset( $_POST['dew_search']))) echo $_POST['low_dew']; else echo "0";?> SIZE=4>
		-- 
		<input type="text" name="high_dew" value=<?if (isset( $_POST['high_dew'])) echo $_POST['high_dew']; else echo "100";?> SIZE="4">%
	</td>
</tr>
<tr>
	<td></td>
	<td <? echo get_align(); ?>>
		<input type="checkbox" id="rainrate_search" <? if (isset( $_POST['rainrate_search'])) echo "checked"; ?>> <? echo $RAIN_RATE[$lang_idx];?> 
		
	</td>
	<td <? echo get_inv_align(); ?>>
		
	</td>
	<td <? echo get_align(); ?>>
		<input type="text" name="low_rainrate" value=<?if (isset( $_POST['low_rainrate'])) echo $_POST['low_rainrate']; else echo "0";?> SIZE="4">
		-- 
		<input type="text" name="high_rainrate" value=<?if (isset( $_POST['high_rainrate'])) echo $_POST['high_rainrate']; else echo "100";?> SIZE="4">mm/hr
	</td>
</tr>
<tr>
	<td></td>
	<td <? echo get_align(); ?>>
		<input type="checkbox" id="windSpeed_search" <? if (isset( $_POST['windSpeed_search'])) echo "checked"; ?>> <? echo $WIND_SPEED[$lang_idx];?> 
		
	</td>
	<td <? echo get_inv_align(); ?>>
		 
	</td>
	<td <? echo get_align(); ?>>
		<input type="text" name="low_windSpeed" value=<?if (isset( $_POST['low_windSpeed'])) echo $_POST['low_windSpeed']; else echo "0";?> SIZE="4">
		-- 
		<input type="text" name="high_windSpeed" value=<?if (isset( $_POST['high_windSpeed'])) echo $_POST['high_windSpeed']; else echo "100";?> SIZE="4">Knots
	</td>
</tr>
<tr>
	<td></td>
	<td <? echo get_align(); ?>>
		<input type="checkbox" id="bar_search" <? if (isset( $_POST['bar_search'])) echo "checked"; ?>> <? echo $BAR[$lang_idx];?>
		
	</td>
	<td <? echo get_inv_align(); ?>>
	    
	</td>
	<td <? echo get_align(); ?> >
		<input type="text" name="low_bar" value=<?if (isset( $_POST['low_bar'])) echo $_POST['low_bar']; else echo "1000";?> SIZE="4">
		--
		<input type="text" name="high_bar" value=<?if (isset( $_POST['high_bar'])) echo $_POST['high_bar']; else echo "1020";?> SIZE="4">mb
		
		
	</td>
</tr>
<tr>
	<td></td>
	<td colspan="3"><input type="submit" name="submitdata" class="inv base big" value="<? echo $SHOW[$lang_idx];?>" style="width:150px;margin:0.5em 3em 0.5em 1em;padding:0.5em" onclick="searchDB()" /></td>
</tr>
</table>
</div>

<script>
	function searchDB(){
		var formData = new FormData();
		
		formData.append("submitdata", 1 );
		formData.append("browseyear", $('select[name="browseyear"]').val() );
		formData.append("browsemonth", $('select[name="browsemonth"]').val());
		formData.append("browseday", $('select[name="browseday"]').val());
		if ($("#temp_search").is(":checked")){
			formData.append("temp_search", 1);
			formData.append("low_temp", $('input[name="low_temp"]').val() );
			formData.append("high_temp", $('input[name="high_temp"]').val() );
		}
		if ($("#time_search").is(":checked")){
			formData.append("time_search", 1);
			formData.append("low_time",  $('input[name="low_time"]').val());
			formData.append("high_time", $('input[name="high_time"]').val());
		}	
		if ($("#dew_search").is(":checked")){
			formData.append("dew_search", 1);
			formData.append("low_dew",  $('input[name="low_dew"]').val());
			formData.append("high_dew", $('input[name="high_dew"]').val() );
		}
		if ($("#windSpeed_search").is(":checked")){
			formData.append("windSpeed_search", 1);
			formData.append("low_windSpeed",  $('input[name="low_windSpeed"]').val());
			formData.append("high_windSpeed",  $('input[name="high_windSpeed"]').val() );
		}
		if ($("#hum_search").is(":checked")){
			formData.append("hum_search", 1);
			formData.append("low_hum",  $('input[name="low_hum"]').val() );
			formData.append("high_hum",  $('input[name="high_hum"]').val() );
		}
		if ($("#bar_search").is(":checked")){
			formData.append("bar_search", 1);
			formData.append("low_bar", $('input[name="low_bar"]').val() );
			formData.append("high_bar", $('input[name="high_bar"]').val() );
		}
		if ($("#rainrate_search").is(":checked")){
			formData.append("rainrate_search", 1);
			formData.append("high_rainrate",  $('input[name="high_rainrate"]').val());
		}
		
		if ($("#high_temp_search").is(":checked")){
			formData.append("high_temp_search", 1);
			formData.append("high_high_temp",  $('input[name="high_high_temp"]').val() );
			formData.append("low_high_temp",  $('input[name="low_high_temp"]').val() );
		}
		

		$.ajax({
			type: "POST",
			url: "<?=BASE_URL?>/browsedate.php#archive",
			beforeSend: function(){$(".loading").show();},
			success: function (data) {
				$(".loading").hide();
				$("#browseresult").html(data);

				
			},
			error: function (error) {
				alert('error:' + error.status + ' ' + error.statusText);
			},
			async: true,
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			timeout: 10000
		});
		}
	

</script>

<div id="browseresult"></div>
<?}?>
<?if ((isset( $_POST['submitdata'])||($_POST['browseday']!=""))){?>

<div class="spacer">&nbsp;</div>
<a name="archive"></a>
<table summary="" style="text-align:center;borde:3" id="mouseover">

<tr><td class="topbase" style="width:100px">Date</td><td class="topbase">Time</td><td class="base"><? echo $TEMP[$lang_idx];?> (C)</td><td class="base"><span>High<br /><? echo $TEMP[$lang_idx];?> (C)</span></td><td class="base"><span class="low">Low<br /><? echo $TEMP[$lang_idx];?> (C)</span></td><td class="base"><? echo $RAIN[$lang_idx];?><br />(mm)</td><td class="base"><? echo $DEW[$lang_idx];?> (C)</td><td class="base"><? echo $WIND_SPEED[$lang_idx];?>(Kt)</td><td class="base"><? echo $WIND_DIR[$lang_idx];?></td><td class="base"><? echo $WIND_SPEED[$lang_idx]." ".$HIGH[$lang_idx];?> (Knots) </td><td class="base"><? echo $WIND_DIR[$lang_idx]." ".$HIGH[$lang_idx];?></td><td class="base"><? echo $WIND_CHILL[$lang_idx];?><br />(C)</td><td class="base"><? echo $HEAT_IDX[$lang_idx];?> (C)</td><td class="base">THW (C)</td><td class="base"><? echo $BAR[$lang_idx];?> (mb)</td><td class="base"><? echo $HUMIDITY[$lang_idx];?> (%)</td><td class="base"><? echo $RAINRATE[$lang_idx];?> (mm/hr)</td></tr>

<?php
 /* Connecting, selecting database */
 function pushAllDB($elementInTableName)
	{
		global $result, $tables;
		array_push ($tables,"archive");
				
		
	} 
	//$start_time = (times)[0];
	 
	db_init("", "");
	$virgin_condition = true;
	$condition="";
	$table="";
	$tables = array();
	

	if ($_POST['browseday']!== "") {//day ONLY
		$virgin_condition = false;
		$dayTosearch = sprintf ( "%02d/", $_POST['browseday']);
		$condition = "WHERE date like '%$dayTosearch%'";
		if ($_POST['browsemonth']!== ""){//day and  month ONLY
			$dayMonth = sprintf ( "%02d/%02d/", $_POST['browseday'], $_POST['browsemonth']);
			$condition = "WHERE date like '%$dayMonth%'";
			if ( $_POST['browseyear']!==""){//day and  month and year
				$condition = "WHERE (date='{$date}')";
				$table = "archive";
				$tables = array(); //empty the array
				array_push ($tables,$table);
				if ($_POST['browseyear'] < 2002)
					$condition = "WHERE date='{$date_db}'";
				
			}
		}
		else if ( $_POST['browseyear']!=="") {//day and  year ONLY
			
			$condition .= " AND date like '%$yearToSearch%'";
		}
	}
	else if (($_POST['browsemonth']!== "")&&( $_POST['browseyear']!=="")){// month and year ONLY
		$table = "archive";
			array_push ($tables,$table);
		$date_db = sprintf ( "%04d-%02d", $_POST['browseyear'], $_POST['browsemonth']);
		$datediff = sprintf(" ( DATEDIFF(  `Date` , DATE(  '%d-%02d-01' ) ) >=0 AND DATEDIFF(  `Date` , DATE(  '%d-%02d-01' ) ) <0) ", $_POST['browseyear'] , $_POST['browsemonth'] , getNextMonthYear($_POST['browsemonth'], $_POST['browseyear']) , getNextMonth($_POST['browsemonth']));
                $condition = "WHERE ".$datediff;
                $virgin_condition = false;
		
	}
	else//no date selected or ONLY month OR year selected
	{
		$table = "archive";
		array_push ($tables,$table);
			if ($_POST['browsemonth']!==""){//month ONLY 
				$date_db = sprintf ( "-%02d-", $_POST['browsemonth']);
			    $condition = "WHERE date like '%$date_db%'";
				$virgin_condition = false;
			}
			else if ($_POST['browseyear']!==""){//year ONLY 
			    $date_db = sprintf ( "%04d-", $_POST['browseyear']);
			    $condition = "WHERE date like '%$date_db%'";
				$virgin_condition = false;
			}
			else 
				pushAllDB("");
			
		
	}
	$date_condition = $condition;	
	//*********  debug  ******************
	//print_r($tables);
	//************************************
        $posted_low_temp = $_POST['low_temp'];
        $posted_high_temp = $_POST['high_temp'];
        $posted_low_hum = $_POST['low_hum'];
		$posted_high_hum = $_POST['high_hum'];
		$posted_low_dew = $_POST['low_dew'];
        $posted_high_dew = $_POST['high_dew'];
        $posted_low_rainrate = $_POST['low_rainrate'];
        $posted_high_rainrate = $_POST['high_rainrate'];
        $posted_low_windSpeed = $_POST['low_windSpeed'];
        $posted_high_windSpeed = $_POST['high_windSpeed'];
        $posted_low_time = $_POST['low_time'];
        $posted_high_time = $_POST['high_time'];
        
	if (isset( $_POST['temp_search'])){
		if (!$virgin_condition)
			$condition .= " AND ";
		else
			$condition="WHERE ";
		$condition .= sprintf("((Temp>=%d AND Temp<=%d)", $_POST['low_temp'], $_POST['high_temp']);
		$condition .= sprintf(" OR (LowTemp>=%d AND LowTemp<=%d )", $_POST['low_temp'], $_POST['high_temp']);
		$condition .= sprintf(" OR (HiTemp>=%d  AND HiTemp<=%d ))", $_POST['low_temp'], $_POST['high_temp']);
		$virgin_condition = false;
	}
	if (isset( $_POST['hum_search'])){
		if (!$virgin_condition)
			$condition .= " AND ";
		else
			$condition="WHERE ";
		$condition .= sprintf("Hum>=%d AND Hum<=%d", $_POST['low_hum'] , $_POST['high_hum']);
		$virgin_condition = false;
	}
	if (isset( $_POST['dew_search'])){
		if (!$virgin_condition)
			$condition .= " AND ";
		else
			$condition="WHERE ";
		$condition .= sprintf("Dew>=%d AND Dew<=%d", $_POST['low_dew'] , $_POST['high_dew']);
		$virgin_condition = false;
	}
	if (isset( $_POST['rainrate_search'])){
		if (!$virgin_condition)
			$condition .= " AND ";
		else
			$condition="WHERE ";
		$rainI = $_POST['low_rainrate']/INTERVAL;
		$condition .= sprintf("((RainRate>=%d AND RainRate<=%d) OR Rain>%d)", $_POST['low_rainrate'], $_POST['high_rainrate'], $rainI);
		$virgin_condition = false;
	}
	if (isset( $_POST['windSpeed_search'])){
		if (!$virgin_condition)
			$condition .= " AND ";
		else
			$condition="WHERE ";
		$condition .= sprintf("((WindSpd>=%d AND WindSpd<=%d) OR (HiSpeed>=%d AND HiSpeed<=%d))",$_POST['low_windSpeed'] , $_POST['high_windSpeed'], $_POST['low_windSpeed'], $_POST['high_windSpeed']);
		$virgin_condition = false;
	}
	if (isset( $_POST['time_search'])){
		if (!$virgin_condition)
			$condition .= " AND ";
		else
			$condition="WHERE ";
		$condition .= sprintf("Time>='%d:00:00' AND Time<='%d:00:00'",$_POST['low_time'] , $_POST['high_time']);
		$virgin_condition = false;
	}
	if (isset( $_POST['bar_search'])){
		if (!$virgin_condition)
			$condition .= " AND ";
		else
			$condition="WHERE ";
		$condition .= sprintf("Bar>=%d AND Bar<=%d", $_POST['low_bar'] ,$_POST['high_bar']);
		$virgin_condition = false;
	}
	if (isset( $_POST['high_temp_search'])){
		if (!$virgin_condition)
			$condition .= " AND ";
		else
			$condition="WHERE ";
		$condition .= sprintf("HiTemp>=%d AND HiTemp<=%d", $_POST['low_high_temp'] ,$_POST['high_high_temp']);
		$virgin_condition = false;
	}
	if (isset( $_POST['low_temp_search'])){
		if (!$virgin_condition)
			$condition .= " AND ";
		else
			$condition="WHERE ";
		$condition .= sprintf("LowTemp>=%d AND LowTemp<=%d", $_POST['low_low_temp'] ,$_POST['high_low_temp']);
		$virgin_condition = false;
	}
	    
    $lines = 0;
	echo "<br />";
    /* Performing SQL query */
	for ($i = 0;$tables[$i]!=null ;$i++) {
		$table = $tables[$i];
		$query = "SELECT Date,Time,Temp,HiTemp,LowTemp,Rain,Dew,WindSpd,WindDir,HiSpeed,HiDir,WindChill,HeatIdx,THW,Bar,Hum,RainRate FROM $table $condition";
		
			$query .= " union SELECT Date,null as Time, null as Temp, HiTemp,LowTemp,Rain ,null as Dew,null as WindSpd,null as WindDir,null as HiSpeed,null as HiDir,null as WindChill,null as HeatIdx,null as THW,null as Bar,null as Hum,null as RainRate FROM archivemin $date_condition";
			
				
		//*********  debug  ******************
		//print_r("<br/> day:".$_POST['browseday']);
		//print_r(" month:".$_POST['browsemonth']);
		//print_r(" year:".$_POST['browseyear']);
		//print_r(" yearToSearch:".$yearToSearch);
		//print_r( "<br />$query<br />");
		//************************************
                
		$result = mysqli_query($link, $query) or die(".........Query failed..........check your query........");

		/* Printing results in HTML */
		while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$lines++;
			$col = 0;
			print "\t<tr style=\"text-align:center\" class=\"inv_plain_3\">\n";
			foreach ($line as $col_value) {
				print "\t\t<td";
				if ($col < 1)
						print " class=\"topbase\"";
				//if (($isArchiveMin)&&($col == 1))
				//	print "></td><td></td><td\n";
						
				print " title=\"".getColumnName($col)."\"";
				print ">$col_value</td>\n";
					
				$col++;
			}
			print "\t</tr>\n";
		}
		
	}
	
	if ($lines==0) {
	    echo "<div style=\"clear:both\" class=\"big indexextreme\">...No results for your query  לא נמצאו נתונים...</div>";
	}
	else {
		echo "<div style=\"clear:both\" class=\"topbase big\">...number of records: <strong>$lines</strong> :מספר רשומות שנמצאו...</div>";
	}
    

    /* Free resultset */
    mysqli_free_result($result);

    /* Closing connection */
    mysqli_close($link);
	


//$end_time = (times)[0];

$total_time = $end_time - $start_time;
?>
<div style="padding:1em;width:30%;direction:ltr;text-align:left" class="float">
					<table style="width:100%">
						<tr class="topbase">
							<td>Source</td>
							<td>Year</td>
							
						</tr>
						<tr class="inv_plain_3">
							<td>my station</td>
							<td>2002+</td>
							
						</tr>
						<tr class="inv_plain_3">
							<td>Jerusalem centeral (Generali)</td>
							<td>1950-2004</td>
							
						</tr>
						<tr class="inv_plain_3">
							<td>Jerusalem - old city</td>
							<td>1948-1949</td>
							
						</tr>
						<tr class="inv_plain_3">
							<td>Jerusalem - Saint Anne</td>
							<td>1907-1948</td>
							
						</tr>
					</table>
</div>
<?
}//issubmitted

function getColumnName($columnNumber)
{
	global $lang_idx, $TEMP, $HUMIDITY, $DEW, $WIND_SPEED, $KNOTS, $WIND_DIR, $WIND_CHILL, $HEAT_IDX, $BAR, $RAIN,  $RAINRATE, $HIGH, $current;
	if ($_POST['browseyear'] < 2002)
		return "";
	switch ($columnNumber):
		case 0:
			return "Date";
			break;
		case 1:
			return "time";
			break;
		case 2:
			return $TEMP[$lang_idx]." "."(".$current->get_tempunit().")";
			break;
		case 3:
			return "High ".$TEMP[$lang_idx]." "."(".$current->get_tempunit().")";
			break;
		case 4:
			return "Low ".$TEMP[$lang_idx]." "."(".$current->get_tempunit().")";
			break;
		case 5:
			return $RAIN[$lang_idx]." "."(mm)";
			break;
		case 6:
			return $DEW[$lang_idx]." "."(".$current->get_tempunit().")";
			break;
		case 7:
			return $WIND_SPEED[$lang_idx]." "."(".$KNOTS[$lang_idx].")";
			break;
		case 8:
			return $WIND_DIR[$lang_idx];
			break;
		case 9:
			return $HIGH[$lang_idx]." ".$WIND_SPEED[$lang_idx]." "."(".$KNOTS[$lang_idx].")";
			break;
		case 10:
			return "High ".$WIND_DIR[$lang_idx];
			break;
		case 11:
			return $WIND_CHILL[$lang_idx]." "."(".$current->get_tempunit().")";
			break;
		case 12:
			return $HEAT_IDX[$lang_idx]." "."(".$current->get_tempunit().")";
			break;
		case 13:
			return "THW"." "."(".$current->get_tempunit().")";
			break;
		case 14:
			return $BAR[$lang_idx]." "."(mb)";
			break;
		case 15:
			return $HUMIDITY[$lang_idx]." "."(%)";
			break;
		case 16:
			return $RAINRATE[$lang_idx]." "."(mm/hr)";
			break;
		default:
			return "";
			break;
	endswitch;
	

}
?>
</table>


<?
	if (($_POST['browseyear'] > 2008) && ($_POST['browsemonth']!== "") && ($_POST['browseday']!== ""))
                                            
					echo "<iframe src=\"https://www.wunderground.com/personal-weather-station/dashboard?ID=IJERUSAL1#history/s".$_POST['browseyear'].$_POST['browsemonth'].$_POST['browseday']."/e".$_POST['browseyear'].$_POST['browsemonth'].$_POST['browseday']."/mdaily\" width=1050 height=1500 seamless></iframe>" ;
?>

