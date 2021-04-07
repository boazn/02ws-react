<script language="JavaScript">
<!--
function namosw_goto_byselect(sel, targetstr)
{
  var index = sel.selectedIndex;
  if (sel.options[index].value != '') {
     if (targetstr == 'blank') {
       window.open(sel.options[index].value, 'win1');
     } else {
       var frameobj;
       if (targetstr == '') targetstr = 'self';
       $.get(sel.options[index].value, function(data) {
       $('#reportdiv').html('<pre>' + data + '</pre>');
  
      });
        
     }
  }
}
function namosw_goto_byclick(href, targetstr)
{
	$.get(href, function(data) {
       $('#' + targetstr).html('<pre>' + data + '</pre>');
       if (href.indexOf("txt") > -1)
            $('#' + targetstr).css('width', '200%');
        else
            $('#' + targetstr).css('width', '100%');
      });

}

// -->
</script>
<?
function getCurrentClass ($currentlink)
{
		
 if (stristr(get_url(), $currentlink))
	 return "inv_plain_3 big";
 else
	return "inv_plain_3_zebra";
}
function isReport()
{
	if ((stristr($_GET['subsection'], 'txt'))||(stristr($_GET['subsection'], 'TXT')))	
		return true;
	return false;
}
include_once("start.php");
include_once("include.php");
?>
<h1 style="width:20%;top:-150px;position:absolute;<?=get_s_align()?>:0"><? echo $HISTORY[$lang_idx];?></h1>
<ul class="nav" id="history_menu">
		<li class="inv_plain_3 il_first">
		<a href="#"><? echo $TEMP[$lang_idx]." & ".$RAIN[$lang_idx]." & ".$HUMIDITY[$lang_idx]." ".$FOR[$lang_idx];?></a>&nbsp;
		<select size="1" OnChange="namosw_goto_byselect(this, 'reportdiv')" name="chooseMonth" style="width: 120px;">
		<option selected><? echo $MONTH[$lang_idx];?></option>
		<?
		for ($y = $year; $y >= 2002; $y--)
		{
			for ($m = 12; $m >= 1; $m--)
			{
				if (($y == $year)&&($m == $month))
					echo sprintf ("<option value=\"reports/NOAAMO.TXT\">%s %d</option>", getMonthName(date("n",  mktime ($hour, $min, 0, $m, $day ,$year))), $y); 
				else if (($y == $year)&&($m == $month - 1))
					echo sprintf ("<option value=\"reports/NOAAPRMO.TXT\">%s %d</option>", getMonthName(date("n",  mktime ($hour, $min, 0, $m, $day ,$year))), $y);
				else if (($y < $year) || (($y == $year) && ($m < $month)))
				echo sprintf ("<option value=\"reports/%02d%02d.txt\">%s %d</option>",$m, $y - 2000,  getMonthName(date("n",  mktime (0, 0, 0, $m, 1 ,$year))), $y);  
			}
		}
		?>	
		</select>
		<select size="1" OnChange="namosw_goto_byselect(this, 'reportdiv')" name="chooseMonth" style="width: 80px;">
		<option selected><? echo $YEAR[$lang_idx];?></option>
		<?
		for ($y = $year; $y >= 2002; $y--)
			{
				if ($y != $year)  
					echo sprintf ("<option value=\"reports/%d.txt\">%d</option>",$y, $y);  
				else
					echo "<option value=\"reports/NOAAYR.TXT\">".$y."</option>";
			}
		?>

		</select>
		</li>
		<li class="<?=getCurrentClass("yesterday")?> il_first" style="clear:both"><a href="<? echo get_query_edited_url($url_cur, 'subsection', 'yesterday.php');?>" class="hlink"> <? echo $YESTERDAY[$lang_idx];?></a></li>
		<li class="<?=getCurrentClass("downld02")?>" ><a OnClick="namosw_goto_byclick('reports/downld02.txt', 'reportdiv')" href="javascript:void(0)" class="hlink"> <? echo $DETAILED_TABLE[$lang_idx];?></a></li>
		<li class="<?=getCurrentClass("downld08")?>"><a OnClick="namosw_goto_byclick('reports/downld08.txt', 'reportdiv')" href="javascript:void(0)" class="hlink"> <? echo $DETAILED_TABLE08[$lang_idx];?></a></li>
		<li class="<?=getCurrentClass("2weeks")?>"><a OnClick="namosw_goto_byclick('2weeks.php', 'reportdiv')" href="javascript:void(0)" class="hlink"><? echo $ALL_GRAPHS[$lang_idx]." - ".$LAST_WEEK[$lang_idx];?></a></li>
		<li class="<?=getCurrentClass("lastmonth")?>"><a OnClick="namosw_goto_byclick('month.php', 'reportdiv')" href="javascript:void(0)" class="hlink"><? echo $ALL_GRAPHS[$lang_idx]." - ".$LAST_MONTH[$lang_idx];?></a></li>
		<li class="<?=getCurrentClass("averages")?>"><a href="<? echo get_query_edited_url($url_cur, 'subsection', 'averages.php');?>" class="hlink"><? echo $AVERAGE[$lang_idx];?></a></li>    
		<li class="<?=getCurrentClass("allTimeRecords")?>"><a href="<? echo get_query_edited_url($url_cur, 'subsection', 'allTimeRecords.php');?>" class="hlink"><? echo $RECORDS[$lang_idx];?></a></li>
		<li class="<?=getCurrentClass("RainSeasons")?>"><a href="<? echo get_query_edited_url($url_cur, 'section', 'RainSeasons.php');?>" class="hlink">150 <? echo $RAIN_SEASONS[$lang_idx]."...";?></a></li>
		<li class="<?=getCurrentClass("snow")?>"><a href="<? echo get_query_edited_url($url_cur, 'section', 'snow.php');?>" class="hlink"><? echo $SNOW_JER[$lang_idx];?></a></li>
		<li class="<?=getCurrentClass("reports")?>"><a href="<? echo get_query_edited_url($url_cur, 'section', 'reports.php');?>" class="hlink"><? echo $REPORTS[$lang_idx];?>...</a></li>
		<li class="<?=getCurrentClass("climate")?>"><a href="<? echo get_query_edited_url($url_cur, 'subsection', 'climate.php');?>" title="<? echo $CLIMATE_TITLE[$lang_idx];?>" class="hlink"><? echo $CLIMATE[$lang_idx];?></a></li>
		<li class="<?=getCurrentClass("browsedate")?>"><a href="<? echo get_query_edited_url($url_cur, 'section', 'browsedate.php');?>" class="hlink"><? echo $ARCHIVE[$lang_idx];?>...</a></li>
		<li class="<?=getCurrentClass("<?=FILE_THIS_MONTH?>")?> il_first" style="width:10%"><a OnClick="namosw_goto_byclick('<?=BASE_URL.substr(FILE_THIS_MONTH, strpos(FILE_THIS_MONTH,"/reports"))?>', 'reportdiv')" href="javascript:void(0)" ><? echo $monthInWord." ".$year; ?></a></li>
		<li class="<?=getCurrentClass("<?=FILE_PREV_MONTH?>")?>" style="width:10%"><a OnClick="namosw_goto_byclick('<?=BASE_URL.substr(FILE_PREV_MONTH, strpos(FILE_PREV_MONTH,"/reports"))?>', 'reportdiv')" href="javascript:void(0)" ><? echo $prevMonthInWord." ".getPrevMonthYear($month, $year);?></a></li>
		<li class="<?=getCurrentClass("<?=FILE_THIS_YEAR?>")?>" style="width:10%"><a OnClick="namosw_goto_byclick('<?=BASE_URL.substr(FILE_THIS_YEAR, strpos(FILE_THIS_YEAR,"/reports"))?>', 'reportdiv')" href="javascript:void(0)" ><? echo $year; ?></a></li>    
		<li class="<?=getCurrentClass("<?=FILE_PREV_YEAR?>")?>" style="width:10%"><a OnClick="namosw_goto_byclick('<?=BASE_URL.substr(FILE_PREV_YEAR, strpos(FILE_PREV_YEAR,"/reports"))?>', 'reportdiv')" href="javascript:void(0)" ><? echo $year-1; ?></a></li> 
		
</ul>


<div id="reportdiv" class="report inv_plain_3_zebra" style="padding:2em;text-align:left;overflow:auto;direction:ltr">
<? if ($_GET['subsection'] != "")
{
echo "<div class=\"inv_plain_3_zebra\" style=\"text-align:center\">";
if (isReport())
	echo "<div align=\"left\" class=\"report\"><pre>";
include("{$_GET['subsection']}");
if (isReport())
	echo "</pre></div>";
echo "</div>";
}
?>
</div>