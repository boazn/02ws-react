<form method="post">
<?

$msgSent = false;
header('Content-type: text/html; charset=utf-8');
session_start();
ini_set("display_errors","On");


function get_title ($field_name)
{
	global $lang_idx, $FSEASON_T, $HOTORCOLD_T; 
	if ($field_name == "favorite season")
		return $FSEASON_T[$lang_idx];
	else if ($field_name == "HotOrCold")
		return $HOTORCOLD_T[$lang_idx];
	else
	     return $field_name;
}


function validEntry()
{
	$query = "SELECT voting_interval FROM `survey` s WHERE s.survey_id={$_GET['survey_id']}";
	$result = db_init($query);
	global $link;
	$row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
	$v_interval = $row["voting_interval"];
	//print "v_interval=".$v_interval;
	$query = "SELECT value, `update_time` FROM `surveyresult` s WHERE ip = '{$_SERVER['REMOTE_ADDR']}' and s.survey_id={$_GET['survey_id']} ORDER BY `update_time` ASC LIMIT 0 , 1 ";
	$result = mysqli_query($link, $query);
	$row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
	//print "<br/>update_time=".$row["update_time"]." ip=".$_SERVER['REMOTE_ADDR']." id=".$_GET['survey_id'];
	if (!isset($row["update_time"]))
		return true;
	if ($v_interval == 0)
		return false;
	$secsWithoutVoting = date_diff_sec($row["update_time"], "now");
	//print "<br/>secsWithoutVoting=".$secsWithoutVoting;
	if ($secsWithoutVoting > $v_interval)
		return true;
	else
		return false;
}

function insertNewMessage ($survey_id, $value, $temp)
{
		global $ONLYONEVOTE, $lang_idx;
		if (!validEntry())
			return $ONLYONEVOTE[$lang_idx];
		setcookie("gender", $_POST['gender'], time() + 8640000000);
		$now = date('Y-m-d G:i:s', strtotime("0 hours 0 minutes", time()));
		//$now = getLocalTime(time());
		$query = "INSERT INTO surveyresult (survey_id, value, ip, gender, update_time, temp) VALUES('{$survey_id}', '{$value}', '{$_SERVER['REMOTE_ADDR']}', '{$_POST['gender']}', '{$now}', '
	{$temp}');";
		//echo $query;
		$result = db_init($query);
		// Free resultset 
		@mysqli_free_result($result);
		
	//}
}

if (isset($_POST['SendButton'])) {

		$msgSent = true;
		$result = insertNewMessage($_GET['survey_id'], $_POST['survey'], $current->get_temp());
		if ($result == "")
			echo "<div class=\"big success\">... תודה...</div>";
		else
			echo "<div class=\"high big\">$result</div>";
	
	
}

$result = getSurvey($_GET['survey_id']);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
print "<h1 class=\"topbase\">".get_title($row['name'])."</h1>";
print "<h2 style=\"margin:0em 2em;text-align:".get_s_align()."\" class=\"inv_plain_3\"";
if (isHeb()) echo "dir=\"rtl\"";
echo " >".get_name($row['name'])."</h2>";
if (!$msgSent) {
print "<div class=\"inv_plain_3_zebra float\" style=\"margin:1em 3em;padding:1em\" >";
while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	$lines++;
        print "\n\t\t<div ";
        if (isHeb()) echo "dir=\"rtl\"";
        echo " style=\"width:200px;margin:0em 2em;text-align:".get_s_align().";clear:both;float:".get_s_align()."\">";
        print "\n\t\t<input type=\"radio\" name=\"survey\" id=\"idx".($line["field_id"])."\" value=\"".$line["field_id"]."\" ";
        if (($lines == 5)&&(!isset($_POST['SendButton']))) echo "checked";
        echo " />&nbsp;".get_name($line["field_name"]);
        print "\n\t\t</div>";
}
print "</div>";
?>
<div class="inv_plain_3" style="clear:both;text-align:<? echo get_s_align(); ?>">
	<div class="inv_plain_3_zebra float" style="padding: 1em;margin:0em 3em;text-align:<? echo get_s_align(); ?>" <? if (isHeb()) echo "dir=\"rtl\""; ?>><?=$GENDER[$lang_idx];?>: 
	<input type="radio" value="m" name="gender" <? if (!isset($_POST['SendButton'])) echo "checked";?> /><?=$MALE[$lang_idx];?>
	<input type="radio" value="f" name="gender" /><?=$FEMALE[$lang_idx];?>
	<input type="radio" value="" name="gender" /><?=$NOR_MALE_NOR_FEMALE[$lang_idx];?>
	</div>
	<div class="float clear" style="padding: 0.5em;margin:0em 2.5em;">
	<input type="submit" class="slogan inv_plain_3_zebra"  style="padding: 0.5em;" name="SendButton" value="<? if (isHeb()) echo "הצבעה"; else echo "Vote"; ?><?=get_arrow()?><?=get_arrow()?>"/>
	
	</div>
	
</div>
<? } 
if (($msgSent) || (!validEntry()))
{
	if((isset($_COOKIE['gender']))&&($_COOKIE['gender'] != ""))
		$genderclause = " AND gender = '".$_COOKIE['gender']."'";
	if ($_GET['survey_id'] == 2)
	{
	$temp_from = $current->get_temp() - 0.5;
	$temp_to = $current->get_temp() + 0.5;
	$title = $temp_from."&#176;C - ".$temp_to."&#176;C";
	
	$query = "SELECT sf.field_name, count( * ) FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sr.survey_id = sf.survey_id AND sf.survey_id =2 AND temp <={$temp_to} AND temp >={$temp_from} GROUP BY sf.field_name order by sf.field_id";
	$query_m = "SELECT sf.field_name, count( * ) FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sr.survey_id = sf.survey_id AND sf.survey_id =2 AND temp <={$temp_to} AND temp >={$temp_from} AND gender = 'm' GROUP BY sf.field_name order by sf.field_id";
	$query_f = "SELECT sf.field_name, count( * ) FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sr.survey_id = sf.survey_id AND sf.survey_id =2 AND temp <={$temp_to} AND temp >={$temp_from} AND gender = 'f' GROUP BY sf.field_name order by sf.field_id";
	$query_verdict = "SELECT sf.field_name, count( * ) FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sr.survey_id = sf.survey_id AND sf.survey_id =2 AND temp <={$temp_to} AND temp >={$temp_from} GROUP BY sf.field_name ORDER BY `count( * )` DESC";
	$query_verdict_m = "SELECT sf.field_name, count( * ) FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sr.survey_id = sf.survey_id AND sf.survey_id =2 AND temp <={$temp_to} AND temp >={$temp_from} AND gender = 'm' GROUP BY sf.field_name ORDER BY `count( * )` DESC";
	$query_verdict_f = "SELECT sf.field_name, count( * ) FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sr.survey_id = sf.survey_id AND sf.survey_id =2 AND temp <={$temp_to} AND temp >={$temp_from} AND gender = 'f' GROUP BY sf.field_name ORDER BY `count( * )` DESC";
	$query_total =  "SELECT count( * ) FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sr.survey_id = sf.survey_id AND sf.survey_id =2 AND temp <={$temp_to} AND temp >={$temp_from} ";
	$query_total_m =  "SELECT count( * ) FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sr.survey_id = sf.survey_id AND sf.survey_id =2 AND temp <={$temp_to} AND temp >={$temp_from} AND gender = 'm'";
	$query_total_f =  "SELECT count( * ) FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sr.survey_id = sf.survey_id AND sf.survey_id =2 AND temp <={$temp_to} AND temp >={$temp_from} AND gender = 'f'";
	}
	else
	{
		$title=$FSEASON[$lang_idx];
		$query = "SELECT count( * ) , sf.field_name FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sf.survey_id =1 AND sr.survey_id = sf.survey_id GROUP BY sf.field_name";
		$query_m = "SELECT count( * ) , sf.field_name FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sf.survey_id =1 AND sr.survey_id = sf.survey_id AND gender = 'm' GROUP BY sf.field_name";
		$query_f = "SELECT count( * ) , sf.field_name FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sf.survey_id =1 AND sr.survey_id = sf.survey_id AND gender = 'f' GROUP BY sf.field_name";
		$query_verdict = "SELECT count( * ) , sf.field_name FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sf.survey_id =1 AND sr.survey_id = sf.survey_id GROUP BY sf.field_name ORDER BY `count( * )` DESC";
		$query_verdict_m = "SELECT count( * ) , sf.field_name FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sf.survey_id =1 AND sr.survey_id = sf.survey_id AND gender = 'm' GROUP BY sf.field_name ORDER BY `count( * )` DESC";
		$query_verdict_f = "SELECT count( * ) , sf.field_name FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sf.survey_id =1 AND sr.survey_id = sf.survey_id AND gender = 'f' GROUP BY sf.field_name ORDER BY `count( * )` DESC";
		$query_total = "SELECT count( * ) FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sf.survey_id =1 AND sr.survey_id = sf.survey_id";
		$query_total_m = "SELECT count( * ) FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sf.survey_id =1 AND sr.survey_id = sf.survey_id AND gender = 'm'";
		$query_total_f = "SELECT count( * ) FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sf.survey_id =1 AND sr.survey_id = sf.survey_id AND gender = 'f'";
	}
	$result = mysqli_query($link, $query_total_m);
	$row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
	$total = $row["count( * )"];
	$result = mysqli_query($link, $query_verdict_m);
	$row_verdict = @mysqli_fetch_array($result, MYSQLI_ASSOC);
	
?>
<div class="spacer" style="clear:both">&nbsp;</div>
<h2><?=$MALE[$lang_idx]." - ".$MOST_POPULAR[$lang_idx];?>: <span <? if (isHeb()) echo "dir=\"rtl\""; ?> class="big"><? echo get_name($row_verdict["field_name"]);?></span> <span <? if (isHeb()) echo "dir=\"rtl\""; ?> class="small">(<? echo $TOTAL_VOTERS[$lang_idx].": ".$total;?>)</span></h2>
<img src="imageSQLGraph.php?title=<?=urlencode($title)?>&Xtitle=&Ytitle=&lang_idx=<?=$lang_idx?>&query=<?=urlencode($query_m)?>&total=<?=$total?>" /><br/>
<?
	$result = mysqli_query($link, $query_total_f);
	$row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
	$total = $row["count( * )"];
	$result = mysqli_query($link, $query_verdict_f);
	$row_verdict = @mysqli_fetch_array($result, MYSQLI_ASSOC);
	
	?>
<h2><?=$FEMALE[$lang_idx]." - ".$MOST_POPULAR[$lang_idx];?>: <span <? if (isHeb()) echo "dir=\"rtl\""; ?> class="big"><? echo get_name($row_verdict["field_name"]);?></span> <span <? if (isHeb()) echo "dir=\"rtl\""; ?> class="small">(<? echo $TOTAL_VOTERS[$lang_idx].": ".$total;?>)</span></h2>
<img src="imageSQLGraph.php?title=<?=urlencode($title)?>&Xtitle=&Ytitle=&lang_idx=<?=$lang_idx?>&query=<?=urlencode($query_f)?>&total=<?=$total?>" /><br/>
<?
	$result = mysqli_query($link, $query_total);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$total = $row["count( * )"];
	$result = mysqli_query($link, $query_verdict);
	$row_verdict = mysqli_fetch_array($result, MYSQLI_ASSOC);
	
	?>

<h2><?=$GENERAL[$lang_idx]." - ".$MOST_POPULAR[$lang_idx];?>: <span <? if (isHeb()) echo "dir=\"rtl\""; ?> class="big"><? echo get_name($row_verdict["field_name"]);?></span> <span <? if (isHeb()) echo "dir=\"rtl\""; ?> class="small">(<? echo $TOTAL_VOTERS[$lang_idx].": ".$total;?>)</span></h2>
<img src="imageSQLGraph.php?title=<?=urlencode($title)?>&Xtitle=&Ytitle=&lang_idx=<?=$lang_idx?>&query=<?=urlencode($query)?>&total=<?=$total?>" /><br/>
<? } @mysql_free_result($result);?>
</div>


</form>