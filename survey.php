<?
include_once("include.php");
include_once("start.php");
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
		{
			return $ONLYONEVOTE[$lang_idx];
		}
		setcookie("gender", $_POST['gender'], strtotime( '+90 days' ));
                $comments = str_replace('delete', '', $comments);
                $comments = str_replace('select', '', $comments);
                 $comments = str_replace('insert', '', $comments);
                 $comments = str_replace('update', '', $comments);
                //$comments = preg_replace("/[^a-zA-Z0-9]+/", "", html_entity_decode($comments));
	
		$query = "call SaveSurveyEntry('{$survey_id}', '{$_SESSION['email']}', '{$_REQUEST['reg_id']}', '{$value}', '{$_SERVER['REMOTE_ADDR']}', '{$_REQUEST['gender']}', '{$temp}', '{$comments}');";
		//logger($query);
		$result = db_init($query, "");
  		@mysqli_free_result($result);
		
	//}
}  
if (isset($_REQUEST['SendSurveyButton'])&&($_REQUEST['survey']!='')) {

	$msgSent = true;
	$displayVotes = false;
			$itfeels = array();
			$itfeels = $current->get_itfeels();
			$temp_to_cold_meter = $itfeels[1];
			$result = insertNewMessage($_REQUEST['survey_id'], $_REQUEST['survey'], $temp_to_cold_meter, $_REQUEST['comments']);
	
	if (isset($_REQUEST['json_res'])) {
				$surveyJSON = "{\"result\":";
				$surveyJSON .= "{"; 
				if ($result == ""){
					$surveyJSON .= "\"success\":\"true\"";
					$result = $VOTE_INSERTED[$lang_idx];
				}
				else
					$surveyJSON .= "\"success\":\"".$result."\"";	
				$surveyJSON .= ",";
				$surveyJSON .= "\"value_inserted\":\"".$_REQUEST['survey']."\"";
				$surveyJSON .= ",";
				$surveyJSON .= "\"temp_to_cold_meter\":\"".$temp_to_cold_meter."\"";
				$surveyJSON .= ",";
				$surveyJSON .= "\"email\":\"".$_SESSION['email']."\"";
				$surveyJSON .= ",";
				$surveyJSON .= "\"message\":\"".$result."\"";
				$surveyJSON .= "}";
				$surveyJSON .= "}";
				echo $surveyJSON;
				exit;
	}
	
	else if ($result == ""){
		echo "<div class=\"alert-success big clear\">... תודה...</div>";
		?>
		<div id="voteAccepted">
		<label id="voteInserted">
			<?=$VOTE_INSERTED[$lang_idx]?>
		</label>
		<div style="clear:both;height:10px">&nbsp;</div>
		<div style="clear:both;height:10px">&nbsp;</div>
		<label id="coldmeter_exp_2">
			<?=$PERSONAL_COLD_METER[$lang_idx]?>
		</label>
		
		<div style="clear:both;height:10px">&nbsp;</div>
		<? if (isset($_SESSION['email'])){ ?>
			
		<?} else {?>
			<label id="coldmeter_suggest">
				<?=$PERSONAL_COLD_METER_SUGG[$lang_idx]?>
			</label>
			<label id="coldmeter_exp">
				<?=$DID_YOU_KNOW_SUMMER[1][$lang_idx]?>
			</label>
			<div class="float clear" >
			<label id="newto02ws" class="float clear"><?=$NEW_TO_02WS[$lang_idx]?></label> <a href="<?=BASE_URL?>/login_form.php?action=registerform" id="clicktoregister" class="float clear big"><?echo $REGISTER[$lang_idx].get_arrow();?></a>
			</div>
		<?}?>
		<div style="clear:both;height:10px">&nbsp;</div>
		<div style="clear:both;height:10px">&nbsp;</div>
		<form method="post">
		<div class="float clear" >
		<input type="submit" class="slogan inv_plain_3_zebra big"  style="width: 280px;padding: 0.5em;" name="displayResultsButton" value="<? if (isHeb()) echo "צפייה בתוצאות"; else echo "Display Results"; ?>&nbsp;&#8250;&#8250;"/>
		<input type="hidden" id="survey_id" name="survey_id" value="<?=$_REQUEST['survey_id']?>"/>
		</div>
		</form>
	</div>
		<?}
	else
		echo "<div class=\"inv_plain_3_zebra big\"><div class=\"text-error alert big clear\">$result</div></div>";
	
}
else
{
	foreach ($_POST as $varname => $varvalue) {
		if (empty($varvalue)) {
			$empty[$varname] = $varvalue;
			$res_post=$res_post." ".$varname."=".$varvalue;
		} else {
			$post[$varname] = $varvalue;
			$res_post=$res_post." ".$varname."=".$varvalue;
		}
	 }
	//logger("res_post=".$res_post);
}

?>
<style>
	body{ 
		background:white; 
	}
#user_info{ 
	<?=get_s_align()?>: 2.8em;
}
#coldmeter_exp, #coldmeter_exp_2, #voteInserted{
	<? if (isHeb()) echo "direction:\"rtl\"";?>;
	font-size:1.8em;
}
</style>
<div class="survey">
<form method="post">
<?
$itfeels = array();
$itfeels = $current->get_itfeels();

header('Content-type: text/html; charset=utf-8');
session_start();
//ini_set("display_errors","On");

if ((isset($_POST['SendSurveyButton']))&&(($_POST['survey']=='not')||($_POST['survey']=='')))
    echo "<div class=\"high big\">יש לבחור ערך</div>";
else if (isset($_POST['displayResultsButton'])) {
	$displayVotes = true;
	
}
$survey_id = isset($_REQUEST['survey_id']) ? $_REQUEST['survey_id']: 2;

$result = getSurvey($survey_id);
if ((!$msgSent)&&(!$displayVotes)) {
foreach ($result as $row) {
	$lines++;
        if ($lines == 1){
            print "<h1 class=\"title\">".get_title($row['name'])."</h1><br/><br/>";
            print "<h2 class=\"question\" style=\"clear:both;direction:".getDirection()."\">".get_name($row['name'])."</h2>";
            print "<div id=\"radio_toolbar_container\" class=\"float\" >";
        }
        print "\n\t\t<div class=\"radio-toolbar color".$row["field_id"]."\"";
        if (isHeb()) echo "dir=\"rtl\"";
        echo " style=\"\">";
        print "\n\t\t<input type=\"radio\" name=\"survey\" id=\"idx".($row["field_id"])."\" value=\"".$row["field_id"]."\" ";
        echo " /><label for=\"idx".($row["field_id"])."\">".get_name($row["field_name"])."</label>";
        print "\n\t\t</div>";
}
print "</div>";
?>
    <div class="float survey_container" style="text-align:<? echo get_s_align(); ?>">
        <? if (isHeb()) echo "עוד משהו רציתי להגיד"; else echo "one more thing";?><br />
        <textarea name="comments" rows="2" <?if (isHeb()) echo " dir=\"rtl\"";?>  value="" style="width:275px;font-size: 1.1em;"></textarea>
    </div>
<div class="float survey_container" style="text-align:<? echo get_s_align(); ?>">
	<div class="radio-toolbar float big" id="genderchooseradio" style="padding: 0.1em 1em;text-align:<? echo get_s_align(); ?>" <? if (isHeb()) echo "dir=\"rtl\""; ?>><?=$IM[$lang_idx];?> 
        <input type="radio" value="m" name="gender" id="male"  /><label for="male"><?=$MALE[$lang_idx];?></label>
	<input type="radio" value="f" name="gender" id="female" /><label for="female"><?=$FEMALE[$lang_idx];?></label>
	<input type="radio" value="" name="gender" id="none" <? if (!isset($_POST['SendSurveyButton'])) echo "checked";?> /><label for="none"><?=$NOR_MALE_NOR_FEMALE[$lang_idx];?></label>
	</div>
	<div class="float clear" >
	<input type="submit" class="slogan inv_plain_3_zebra big"  style="width: 280px;padding: 0.5em;" name="SendSurveyButton" value="<? if (isHeb()) echo "הצבעה"; else echo "Vote"; ?>&nbsp;&#8250;&#8250;"/>
	
	</div>
	
</div>
    <script type="text/javascript">
    /*    $(document).ready(function () {
            $("input[name='survey']").val('not');
        });*/
        
    </script>
<?}
 if ($displayVotes)
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
	if ($total > 0){
?>
<div class="spacer" style="clear:both">&nbsp;</div>
<h2><?=$MALE[$lang_idx]." - ".$MOST_POPULAR[$lang_idx];?>: <span <? if (isHeb()) echo "dir=\"rtl\""; ?>><? echo get_name($row_verdict["field_name"]);?></span></h2><span <? if (isHeb()) echo "dir=\"rtl\""; ?> ><br/>(<? echo $TOTAL_VOTERS[$lang_idx].": ".$total;?>)</span>
<a class="enlarge" href="<?=BASE_URL?>/imageSQLGraph.php?title=<?=urlencode($title)?>&Xtitle=&Ytitle=&lang_idx=<?=$lang_idx?>&query=<?=urlencode($query_m)?>&total=<?=$total?>&width=1000" target="_system" title="click to enlarge">
<img src="<?=BASE_URL?>/imageSQLGraph.php?title=<?=urlencode($title)?>&survey_id=<?=$_REQUEST['survey_id']?>&g=m&temp_from=<?=$temp_from?>&temp_to=<?=$temp_to?>&Xtitle=&Ytitle=&lang_idx=<?=$lang_idx?>&query=<?=urlencode($query_m)?>&total=<?=$total?>&width=320" /><br/>
</a>
<?
	}
	$result = mysqli_query($link, $query_total_f);
	$row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
	$total = $row["count( * )"];
	$result = mysqli_query($link, $query_verdict_f);
	$row_verdict = @mysqli_fetch_array($result, MYSQLI_ASSOC);
	if ($total > 0){
	?>
<h2><?=$FEMALE[$lang_idx]." - ".$MOST_POPULAR[$lang_idx];?>: <span <? if (isHeb()) echo "dir=\"rtl\""; ?> ><? echo get_name($row_verdict["field_name"]);?></span> </h2><span <? if (isHeb()) echo "dir=\"rtl\""; ?>><br/>(<? echo $TOTAL_VOTERS_FEMALE[$lang_idx].": ".$total;?>)</span>
<a class="enlarge" href="<?=BASE_URL?>/imageSQLGraph.php?title=<?=urlencode($title)?>&Xtitle=&Ytitle=&lang_idx=<?=$lang_idx?>&query=<?=urlencode($query_f)?>&total=<?=$total?>&width=1000" target="_system" title="click to enlarge">
<img src="<?=BASE_URL?>/imageSQLGraph.php?title=<?=urlencode($title)?>&survey_id=<?=$_REQUEST['survey_id']?>&g=f&temp_from=<?=$temp_from?>&temp_to=<?=$temp_to?>&Xtitle=&Ytitle=&lang_idx=<?=$lang_idx?>&query=<?=urlencode($query_f)?>&total=<?=$total?>&width=320" /><br/>
</a>
    <?
	}
	$result = mysqli_query($link, $query_total);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$total = $row["count( * )"];
	$result = mysqli_query($link, $query_verdict);
	$row_verdict = mysqli_fetch_array($result, MYSQLI_ASSOC);
	
	?>

<h2><?=$GENERAL[$lang_idx]." - ".$MOST_POPULAR[$lang_idx];?>: <span <? if (isHeb()) echo "dir=\"rtl\""; ?>><? echo get_name($row_verdict["field_name"]);?></span> </h2><span <? if (isHeb()) echo "dir=\"rtl\""; ?> ><br/>(<? echo $TOTAL_VOTERS[$lang_idx].": ".$total;?>)</span>
<a class="enlarge" href="<?=BASE_URL?>/imageSQLGraph.php?title=<?=urlencode($title)?>&Xtitle=&Ytitle=&lang_idx=<?=$lang_idx?>&query=<?=urlencode($query)?>&total=<?=$total?>&width=1000" target="_system" title="click to enlarge">
<img src="<?=BASE_URL?>/imageSQLGraph.php?title=<?=urlencode($title)?>&survey_id=<?=$_REQUEST['survey_id']?>&temp_from=<?=$temp_from?>&temp_to=<?=$temp_to?>&Xtitle=&Ytitle=&lang_idx=<?=$lang_idx?>&query=<?=urlencode($query)?>&total=<?=$total?>&width=320" /><br/>
</a>
<? } @mysqli_free_result($result);?>
</div>
</form>
</div>