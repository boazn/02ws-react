<div class="survey">
<form method="post">
<?
$itfeels = array();
$itfeels = $current->get_itfeels();
$msgSent = false;
header('Content-type: text/html; charset=utf-8');
session_start();
//ini_set("display_errors","On");

function get_title ($field_name)
{
	global $lang_idx, $FSEASON_T, $HOTORCOLD_T, $itfeels;
        
        if ($field_name == "BestSeason")
		return $FSEASON_T[$lang_idx];
	else if ($field_name == "HotOrCold")
		return $HOTORCOLD_T[$lang_idx]." ".$itfeels[1]."&#176;";
	else
	     return $field_name;
}


function validEntry()
{
        if ($_SESSION['email'] != '')
            return true;
	$query = "SELECT voting_interval FROM `survey` s WHERE s.survey_id=?";
	$result = db_init($query, $_REQUEST['survey_id']);
	global $link;
	$row = @mysqli_fetch_array($result["result"], MYSQLI_ASSOC);
	$v_interval = $row["voting_interval"];
	//logger("v_interval=".$v_interval);
	$query = "SELECT value, `update_time` FROM `surveyresult` s WHERE ip = '{$_SERVER['REMOTE_ADDR']}' and s.survey_id=? ORDER BY `update_time` DESC LIMIT 0 , 1 ";
	$result = db_init($query, $_REQUEST['survey_id']);
	$row = @mysqli_fetch_array($result["result"], MYSQLI_ASSOC);
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
		global $ONLYONEVOTE, $lang_idx, $cookie, $session;
                if (($survey_id != 1)&&($survey_id != 2))
                       return $ONLYONEVOTE[$lang_idx]; 
		if (!validEntry())
			return $ONLYONEVOTE[$lang_idx];
		setcookie("gender", $_POST['gender'], strtotime( '+90 days' ));
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
		$result = db_init($query, '');
                
                if ($_SESSION['email'] != "")
                {    
                    
                    $query = "select count(*) cnt from surveyresult where email='".$_SESSION['email']."' and `survey_id` = 2;";
                    //logger($query);
                    $result = db_init($query, '');
                    $row = @mysqli_fetch_array($result["result"], MYSQLI_ASSOC);
                    
                    $query = "update  `users` set voteCount=? where email='".$_SESSION['email']."';";
                    //logger($query);
                    $result = db_init($query, $row['cnt']);
                }
                logger("Survey->insertNewMessage: ".$_SESSION['email']." ".$_SESSION['loggedin']." ".$_COOKIE[PERSONAL_COLD_METER]." ".$_COOKIE['rememberme']);
		// Free resultset 
		@mysqli_free_result($result);
		
	//}
}

if (isset($_POST['SendSurveyButton'])&&($_POST['survey']!='not')&&($_POST['survey']!='')) {

		$msgSent = true;
                $itfeels = array();
                $itfeels = $current->get_itfeels();
                $temp_to_cold_meter = $itfeels[1];
                $result = insertNewMessage($_REQUEST['survey_id'], $_POST['survey'], $temp_to_cold_meter, $_POST['comments']);
		if ($result == "")
			echo "<div class=\"alert-success\">... תודה...</div>";
		else
			echo "<div class=\"text-error alert\">$result</div>";
	
	
}
else if ((isset($_POST['SendSurveyButton']))&&(($_POST['survey']=='not')||($_POST['survey']=='')))
    echo "<div class=\"high big\">יש לבחור ערך</div>";
$result = getSurvey($_REQUEST['survey_id']);
if (!$msgSent) {
foreach ($result as $row) {
	$lines++;
        if ($lines == 1){
            print "<h1 class=\"title\">".get_title($row['name'])."</h1><br/><br/>";
            print "<h2 class=\"question\" style=\"clear:both;direction:".getDirection()."\">".get_name($row['name'])."</h2>";
            print "<div class=\" float\" style=\"margin:0em 1em;\" >";
        }
        print "\n\t\t<div class=\"radio-toolbar color".$row["field_id"]."\"";
        if (isHeb()) echo "dir=\"rtl\"";
        echo " style=\"\">";
        print "\n\t\t<input type=\"radio\" name=\"survey\" id=\"idx".($row["field_id"])."\" value=\"".$row["field_id"]."\" ";
        echo " />&nbsp;<label for=\"idx".($row["field_id"])."\">".get_name($row["field_name"])."</label>";
        print "\n\t\t</div>";
}
print "</div>";
?>
    <div class="" style="float:<? echo get_s_align(); ?>;margin-<? echo get_s_align(); ?>:1em;width:179px;padding:1em;text-align:<? echo get_s_align(); ?>">
        <? if (isHeb()) echo "עוד משהו רציתי להגיד"; else echo "one more thing";?><br />
        <textarea name="comments" rows="6" <?if (isHeb()) echo " dir=\"rtl\"";?>  value="" style="width:170px;font-size: 1.2em;"></textarea>
    </div>
<div class="" style="float:<? echo get_s_align(); ?>;margin-<? echo get_s_align(); ?>:1em;padding:0.2em;text-align:<? echo get_s_align(); ?>">
	<div class="radio-toolbar float big" id="genderchooseradio" style="padding: 1em;text-align:<? echo get_s_align(); ?>" <? if (isHeb()) echo "dir=\"rtl\""; ?>><?=$IM[$lang_idx];?> 
        <input type="radio" value="m" name="gender" id="male"  /><label for="male"><?=$MALE[$lang_idx];?></label>
	<input type="radio" value="f" name="gender" id="female" /><label for="female"><?=$FEMALE[$lang_idx];?></label>
	<input type="radio" value="" name="gender" id="none" <? if (!isset($_POST['SendSurveyButton'])) echo "checked";?> /><label for="none"><?=$NOR_MALE_NOR_FEMALE[$lang_idx];?></label>
	</div>
	<div class="float clear" style="margin:0.2em 0em;width: 200px">
	<input type="submit" class="slogan inv_plain_3_zebra big"  style="width: 200px;padding: 1em;" name="SendSurveyButton" value="<? if (isHeb()) echo "הצבעה"; else echo "Vote"; ?><?=get_arrow()?><?=get_arrow()?>"/>
	
	</div>
	
</div>
    <script type="text/javascript">
    /*    $(document).ready(function () {
            $("input[name='survey']").val('not');
        });*/
        
    </script>
<? } 
if (($msgSent) || (!validEntry()))
{
        if (isset($_SESSION['email'])){
            header("Location: https://www.02ws.co.il/".$_SERVER['SCRIPT_NAME']."?section=myVotes.php&lang=".$lang_idx."&survey_id=".$_REQUEST['survey_id']."&fullt=".$_GET['fullt']."&s=".$_GET['s']."&c=".$_GET['c']."\""); /* Redirect browser */
            exit();
        }   
	if((isset($_COOKIE['gender']))&&($_COOKIE['gender'] != ""))
		$genderclause = " AND gender = '".$_COOKIE['gender']."'";
	if ($_REQUEST['survey_id'] == 2)
	{
            
        $temp_to_cold_meter = $current->get_temp();
        $itfeels = array();
        $itfeels = $current->get_itfeels();
        if (!empty($itfeels[0]))
            $temp_to_cold_meter = $itfeels[1];
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
<h2><?=$MALE[$lang_idx]." - ".$MOST_POPULAR[$lang_idx];?>: <span <? if (isHeb()) echo "dir=\"rtl\""; ?>><? echo get_name($row_verdict["field_name"]);?></span></h2><span <? if (isHeb()) echo "dir=\"rtl\""; ?> >(<? echo $TOTAL_VOTERS[$lang_idx].": ".$total;?>)</span>
<a class="enlarge" href="imageSQLGraph.php?title=<?=urlencode($title)?>&Xtitle=&Ytitle=&lang_idx=<?=$lang_idx?>&query=<?=urlencode($query_m)?>&total=<?=$total?>&width=1000" target="_system" title="click to enlarge">
<img src="imageSQLGraph.php?title=<?=urlencode($title)?>&survey_id=<?=$_REQUEST['survey_id']?>&g=m&temp_from=<?=$temp_from?>&temp_to=<?=$temp_to?>&Xtitle=&Ytitle=&lang_idx=<?=$lang_idx?>&query=<?=urlencode($query_m)?>&total=<?=$total?>&width=320" /><br/>
</a>
<?
	$result = mysqli_query($link, $query_total_f);
	$row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
	$total = $row["count( * )"];
	$result = mysqli_query($link, $query_verdict_f);
	$row_verdict = @mysqli_fetch_array($result, MYSQLI_ASSOC);
	
	?>
<h2><?=$FEMALE[$lang_idx]." - ".$MOST_POPULAR[$lang_idx];?>: <span <? if (isHeb()) echo "dir=\"rtl\""; ?> ><? echo get_name($row_verdict["field_name"]);?></span> </h2><span <? if (isHeb()) echo "dir=\"rtl\""; ?>>(<? echo $TOTAL_VOTERS_FEMALE[$lang_idx].": ".$total;?>)</span>
<a class="enlarge" href="imageSQLGraph.php?title=<?=urlencode($title)?>&Xtitle=&Ytitle=&lang_idx=<?=$lang_idx?>&query=<?=urlencode($query_f)?>&total=<?=$total?>&width=1000" target="_system" title="click to enlarge">
<img src="imageSQLGraph.php?title=<?=urlencode($title)?>&survey_id=<?=$_REQUEST['survey_id']?>&g=f&temp_from=<?=$temp_from?>&temp_to=<?=$temp_to?>&Xtitle=&Ytitle=&lang_idx=<?=$lang_idx?>&query=<?=urlencode($query_f)?>&total=<?=$total?>&width=320" /><br/>
</a>
    <?
	$result = mysqli_query($link, $query_total);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$total = $row["count( * )"];
	$result = mysqli_query($link, $query_verdict);
	$row_verdict = mysqli_fetch_array($result, MYSQLI_ASSOC);
	
	?>

<h2><?=$GENERAL[$lang_idx]." - ".$MOST_POPULAR[$lang_idx];?>: <span <? if (isHeb()) echo "dir=\"rtl\""; ?>><? echo get_name($row_verdict["field_name"]);?></span> </h2><span <? if (isHeb()) echo "dir=\"rtl\""; ?> >(<? echo $TOTAL_VOTERS[$lang_idx].": ".$total;?>)</span>
<a class="enlarge" href="imageSQLGraph.php?title=<?=urlencode($title)?>&Xtitle=&Ytitle=&lang_idx=<?=$lang_idx?>&query=<?=urlencode($query)?>&total=<?=$total?>&width=1000" target="_system" title="click to enlarge">
<img src="imageSQLGraph.php?title=<?=urlencode($title)?>&survey_id=<?=$_REQUEST['survey_id']?>&temp_from=<?=$temp_from?>&temp_to=<?=$temp_to?>&Xtitle=&Ytitle=&lang_idx=<?=$lang_idx?>&query=<?=urlencode($query)?>&total=<?=$total?>&width=320" /><br/>
</a>
<? } @mysqli_free_result($result);?>
</div>
</form>
</div>