<style>
    .radio-toolbar input[type="radio"] {
    display:none;
}

.radio-toolbar label {
    display:inline-block;
    background-color:#ddd;
    padding:14px;
    font-size:25px;
    margin: 0.1em;
}
#genderchooseradio label {
    display:block;
    margin: 0.3em 0.2em;
}
.radio-toolbar input[type="radio"]:checked + label {
    background-color:#bbb;
}


</style>
<form method="post">
<?

$msgSent = false;
header('Content-type: text/html; charset=utf-8');
session_start();
//ini_set("display_errors","On");

function get_title ($field_name)
{
	global $lang_idx, $FSEASON_T, $HOTORCOLD_T; 
        if ($field_name == "BestSeason")
		return $FSEASON_T[$lang_idx];
	else if ($field_name == "HotOrCold")
		return $HOTORCOLD_T[$lang_idx];
	else
	     return $field_name;
}


function validEntry()
{
        
	$query = "SELECT voting_interval FROM `survey` s WHERE s.survey_id=?";
	$result = db_init($query, $_GET['survey_id']);
	global $link;
	$row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
	$v_interval = $row["voting_interval"];
	//logger("v_interval=".$v_interval);
	$query = "SELECT value, `update_time` FROM `surveyresult` s WHERE ip = '{$_SERVER['REMOTE_ADDR']}' and s.survey_id=? ORDER BY `update_time` DESC LIMIT 0 , 1 ";
	$result = db_init($query, $_GET['survey_id']);
	$row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
	//logger( "update_time=".$row["update_time"]." ip=".$_SERVER['REMOTE_ADDR']." id=".$_GET['survey_id']);
	if (!isset($row["update_time"]))
		return true;
	if ($v_interval == 0)
		return false;
	$secsWithoutVoting = date_diff_sec($row["update_time"], "now");
	//logger("secsWithoutVoting=".$secsWithoutVoting);
	if ($secsWithoutVoting > $v_interval)
		return true;
	else
		return false;
}

function insertNewMessage ($survey_id, $value, $temp, $comments)
{
		global $ONLYONEVOTE, $lang_idx;
                if (($survey_id != 1)&&($survey_id != 2))
                       return $ONLYONEVOTE[$lang_idx]; 
		if (!validEntry())
			return $ONLYONEVOTE[$lang_idx];
		setcookie("gender", $_POST['gender'], time() + 8640000000);
                $comments = str_replace('delete', '', $comments);
                $comments = str_replace('select', '', $comments);
                 $comments = str_replace('insert', '', $comments);
                 $comments = str_replace('update', '', $comments);
                //$comments = preg_replace("/[^a-zA-Z0-9]+/", "", html_entity_decode($comments));
		$now = date('Y-m-d G:i:s', strtotime("0 hours 0 minutes", time()));
		//$now = getLocalTime(time());
		$query = "INSERT INTO surveyresult (survey_id, value, ip, gender, update_time, temp, comments, email) VALUES('{$survey_id}', '{$value}', '{$_SERVER['REMOTE_ADDR']}', '{$_POST['gender']}', '{$now}', '
	{$temp}', '{$comments}', '{$_SESSION['email']}');";
		//logger($query);
		$result = db_init($query);
		// Free resultset 
		@mysqli_free_result($result);
		
	//}
}

if (isset($_POST['SendSurveyButton'])&&($_POST['survey']!='not')&&($_POST['survey']!='')) {

		$msgSent = true;
                $temp_to_cold_meter = $current->get_temp();
                if (min($current->get_windchill(), $current->get_thw()) < ($current->get_temp()) && $current->get_temp() < 20 )
                        $temp_to_cold_meter = min($current->get_windchill(), $current->get_thw());
                 else if (max($current->get_HeatIdx(), $current->get_thw()) > ($current->get_temp()))
                          $temp_to_cold_meter = max($current->get_HeatIdx(), $current->get_thw());
		$result = insertNewMessage($_GET['survey_id'], $_POST['survey'], $temp_to_cold_meter, $_POST['comments']);
		if ($result == "")
			echo "<div class=\"big success\">... תודה...</div>";
		else
			echo "<div class=\"high big\">$result</div>";
	
	
}
else if ((isset($_POST['SendSurveyButton']))&&(($_POST['survey']=='not')||($_POST['survey']=='')))
    echo "<div class=\"high big\">יש לבחור ערך</div>";
$result = getSurvey($_GET['survey_id']);
if (!$msgSent) {
while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	$lines++;
        if ($lines == 1){
            print "<h1>".get_title($line['name'])."</h1>";
            print "<h2 style=\"clear:both;direction:".getDirection()."\">".get_name($line['name'])."</h2>";
            print "<div class=\"inv_plain_3 float\" style=\"margin:0em 1em;padding:0.5em\" >";
        }
        print "\n\t\t<div class=\"radio-toolbar\"";
        if (isHeb()) echo "dir=\"rtl\"";
        echo " style=\"\">";
        print "\n\t\t<input type=\"radio\" name=\"survey\" id=\"idx".($line["field_id"])."\" value=\"".$line["field_id"]."\" ";
        echo " />&nbsp;<label for=\"idx".($line["field_id"])."\">".get_name($line["field_name"])."</label>";
        print "\n\t\t</div>";
}
print "</div>";
?>
    <div class="inv_plain_3" style="float:<? echo get_s_align(); ?>;margin:0em;width:192px;padding:1em;font-size:1.3em;text-align:<? echo get_s_align(); ?>">
        <? if (isHeb()) echo "עוד משהו רציתי להגיד"; else echo "one more thing";?><br />
        <textarea name="comments" rows="6" <?if (isHeb()) echo " dir=\"rtl\"";?>  value="" style="width:190px;font-size: 1.2em;"></textarea>
    </div>
<div class="inv_plain_3" style="float:<? echo get_s_align(); ?>;margin:0em;padding:0.2em;text-align:<? echo get_s_align(); ?>">
	<div class="radio-toolbar float big" id="genderchooseradio" style="padding: 1em;text-align:<? echo get_s_align(); ?>" <? if (isHeb()) echo "dir=\"rtl\""; ?>><?=$IM[$lang_idx];?> 
        <input type="radio" value="m" name="gender" id="male" <? if (!isset($_POST['SendSurveyButton'])) echo "checked";?> /><label for="male"><?=$MALE[$lang_idx];?></label>
	<input type="radio" value="f" name="gender" id="female" /><label for="female"><?=$FEMALE[$lang_idx];?></label>
	<input type="radio" value="" name="gender" id="none" /><label for="none"><?=$NOR_MALE_NOR_FEMALE[$lang_idx];?></label>
	</div>
	<div class="float clear" style="margin:0.2em 0em;width: 200px">
	<input type="submit" class="slogan inv_plain_3_zebra big"  style="width: 222px;padding: 1em;" name="SendSurveyButton" value="<? if (isHeb()) echo "הצבעה"; else echo "Vote"; ?><?=get_arrow()?><?=get_arrow()?>"/>
	
	</div>
	
</div>
    <script type="text/javascript">
        $(document).ready(function () {
            $("input[name='survey']").val('not');
        }
        
    </script>
<? } 
if (($msgSent) || (!validEntry()))
{
	if((isset($_COOKIE['gender']))&&($_COOKIE['gender'] != ""))
		$genderclause = " AND gender = '".$_COOKIE['gender']."'";
	if ($_GET['survey_id'] == 2)
	{
        $temp_to_cold_meter = $current->get_temp();
        if (min($current->get_windchill(), $current->get_thw()) < ($current->get_temp()) && $current->get_temp() < 20 )
                $temp_to_cold_meter = min($current->get_windchill(), $current->get_thw());
         else if (max($current->get_HeatIdx(), $current->get_thw()) > ($current->get_temp()))
                  $temp_to_cold_meter = max($current->get_HeatIdx(), $current->get_thw());
	$temp_from = $temp_to_cold_meter - 0.5;
	$temp_to = $temp_to_cold_meter + 0.5;
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
<h2><?=$FEMALE[$lang_idx]." - ".$MOST_POPULAR[$lang_idx];?>: <span <? if (isHeb()) echo "dir=\"rtl\""; ?> class="big"><? echo get_name($row_verdict["field_name"]);?></span> <span <? if (isHeb()) echo "dir=\"rtl\""; ?> class="small">(<? echo $TOTAL_VOTERS_FEMALE[$lang_idx].": ".$total;?>)</span></h2>
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