<style>
#section{
    width:800px
}
</style>
<div id="personal_message" class="clear float box_text inv_plain_3_zebra white_box">
    
</div>
<div class="spacer" style="clear:both">&nbsp;</div>
<?
        $result = db_init("","");
        $email = $_SESSION['email'];
        $survey_id = $_REQUEST['survey_id'];
        
	if((isset($_COOKIE['gender']))&&($_COOKIE['gender'] != ""))
		$genderclause = " AND gender = '".$_COOKIE['gender']."'";
	if ($survey_id == 2)
	{
        $temp_to_cold_meter = $current->get_temp();
        $itfeels = array();
        $itfeels = $current->get_itfeels();
        if (!empty($itfeels[0]))
            $temp_to_cold_meter = $itfeels[1];
	$temp_from = $temp_to_cold_meter - 0.5;
	$temp_to = $temp_to_cold_meter + 0.5;
	$title = $temp_from."&#176;C - ".$temp_to."&#176;C";
	
	$query_verdict = "call GetColdMeter({$temp_from}, {$temp_to}, '', '');";
	$query_verdict_m = "call GetColdMeter({$temp_from}, {$temp_to}, 'm', '');";
	$query_verdict_f = "call GetColdMeter({$temp_from}, {$temp_to}, 'f', '');";
    $my_query_verdict_m = "call GetColdMeter({$temp_from}, {$temp_to}, 'm', '{$email}');";
    $my_query_verdict_f = "call GetColdMeter({$temp_from}, {$temp_to}, 'f', '{$email}');";
    
    
	$query_verdict = "SELECT sf.field_name, count( * ) FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sr.survey_id = sf.survey_id AND sf.survey_id =2 AND temp <={$temp_to} AND temp >={$temp_from} GROUP BY sf.field_name ORDER BY `count( * )` DESC";
	$query_verdict_m = "SELECT sf.field_name, count( * ) FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sr.survey_id = sf.survey_id AND sf.survey_id =2 AND temp <={$temp_to} AND temp >={$temp_from} AND gender = 'm' GROUP BY sf.field_name ORDER BY `count( * )` DESC";
	$query_verdict_f = "SELECT sf.field_name, count( * ) FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sr.survey_id = sf.survey_id AND sf.survey_id =2 AND temp <={$temp_to} AND temp >={$temp_from} AND gender = 'f' GROUP BY sf.field_name ORDER BY `count( * )` DESC";
        $my_query_verdict_m = "SELECT sf.field_name, count( * ) FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sr.survey_id = sf.survey_id AND sf.survey_id =2 AND temp <={$temp_to} AND temp >={$temp_from} AND gender = 'm' AND email='{$email}' GROUP BY sf.field_name ORDER BY `count( * )` DESC";
        $my_query_verdict_f = "SELECT sf.field_name, count( * ) FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sr.survey_id = sf.survey_id AND sf.survey_id =2 AND temp <={$temp_to} AND temp >={$temp_from} AND gender = 'f' AND email='{$email}' GROUP BY sf.field_name ORDER BY `count( * )` DESC";
	$query_total =  "SELECT count( * ) FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sr.survey_id = sf.survey_id AND sf.survey_id =2 AND temp <={$temp_to} AND temp >={$temp_from} ";
	$query_total_m =  "SELECT count( * ) FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sr.survey_id = sf.survey_id AND sf.survey_id =2 AND temp <={$temp_to} AND temp >={$temp_from} AND gender = 'm'";
	$query_total_f =  "SELECT count( * ) FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sr.survey_id = sf.survey_id AND sf.survey_id =2 AND temp <={$temp_to} AND temp >={$temp_from} AND gender = 'f'";
	$my_query_total_m =  "SELECT count( * ) FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sr.survey_id = sf.survey_id AND sf.survey_id =2 AND temp <={$temp_to} AND temp >={$temp_from} AND gender = 'm' AND email='{$email}'";
	$my_query_total_f =  "SELECT count( * ) FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sr.survey_id = sf.survey_id AND sf.survey_id =2 AND temp <={$temp_to} AND temp >={$temp_from} AND gender = 'f' AND email='{$email}'";
	
        
        }
	else
	{
		$title=$FSEASON[$lang_idx];
		
		$query_verdict = "SELECT count( * ) , sf.field_name FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sf.survey_id =1 AND sr.survey_id = sf.survey_id GROUP BY sf.field_name ORDER BY `count( * )` DESC";
		$query_verdict_m = "SELECT count( * ) , sf.field_name FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sf.survey_id =1 AND sr.survey_id = sf.survey_id AND gender = 'm' GROUP BY sf.field_name ORDER BY `count( * )` DESC";
		$query_verdict_f = "SELECT count( * ) , sf.field_name FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sf.survey_id =1 AND sr.survey_id = sf.survey_id AND gender = 'f' GROUP BY sf.field_name ORDER BY `count( * )` DESC";
		$my_query_verdict_m = "SELECT count( * ) , sf.field_name FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sf.survey_id =1 AND sr.survey_id = sf.survey_id AND gender = 'm' AND email='{$email}' GROUP BY sf.field_name ORDER BY `count( * )` DESC";
		$my_query_verdict_f = "SELECT count( * ) , sf.field_name FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sf.survey_id =1 AND sr.survey_id = sf.survey_id AND gender = 'f' AND email='{$email}' GROUP BY sf.field_name ORDER BY `count( * )` DESC";
		
                $query_total = "SELECT count( * ) FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sf.survey_id =1 AND sr.survey_id = sf.survey_id";
		$query_total_m = "SELECT count( * ) FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sf.survey_id =1 AND sr.survey_id = sf.survey_id AND gender = 'm'";
		$query_total_f = "SELECT count( * ) FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sf.survey_id =1 AND sr.survey_id = sf.survey_id AND gender = 'f'";
                $my_query_total_m = "SELECT count( * ) FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sf.survey_id =1 AND sr.survey_id = sf.survey_id AND gender = 'm' AND email='{$email}'";
		$my_query_total_f = "SELECT count( * ) FROM surveyresult sr, surveyfields sf WHERE sr.value = sf.field_id AND sf.survey_id =1 AND sr.survey_id = sf.survey_id AND gender = 'f' AND email='{$email}'";
	
	}
	


if (!empty($_SESSION['email'])){ 
    $result = mysqli_query($link, $my_query_total_m);
    $row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
    $total = $row["count( * )"];
    $result = mysqli_query($link, $my_query_verdict_m);
    $row_verdict = @mysqli_fetch_array($result, MYSQLI_ASSOC);
?>
<div class="float">
<div class="spacer" style="clear:both">&nbsp;</div>
<h3 class="inv_plain_2"><?=$MY_VOTES[$lang_idx]?></h3>
<h2 class="inv_plain_2"><?=$MALE[$lang_idx]?>: <span <? if (isHeb()) echo "dir=\"rtl\""; ?> class="big"><? echo get_name($row_verdict["field_name"]);?></span> <span <? if (isHeb()) echo "dir=\"rtl\""; ?> class="">(<? echo $TOTAL_VOTERS[$lang_idx].": ".$total;?>)</span></h2>
<a class="enlarge" href="imageSQLGraph.php?title=<?=urlencode($title)?>&survey_id=<?=$_REQUEST['survey_id']?>&g=m&temp_from=<?=$temp_from?>&temp_to=<?=$temp_to?>&Xtitle=&email=<?=$email?>&Ytitle=&lang_idx=<?=$lang_idx?>&total=<?=$total?>&width=1000" target="_system" title="click to enlarge">
<img src="imageSQLGraph.php?title=<?=urlencode($title)?>&survey_id=<?=$_REQUEST['survey_id']?>&g=m&temp_from=<?=$temp_from?>&temp_to=<?=$temp_to?>&Xtitle=&email=<?=$email?>&Ytitle=&lang_idx=<?=$lang_idx?>&total=<?=$total?>&width=320" /><br/>
</a>
</div>
<?
}
    $result = mysqli_query($link, $query_total_m);
    $row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
    $total = $row["count( * )"];
    $result = mysqli_query($link, $query_verdict_m);
    $row_verdict = @mysqli_fetch_array($result, MYSQLI_ASSOC);
?>
<div class="float">
<div class="spacer" style="clear:both">&nbsp;</div>
<h3 class="inv_plain_2">כולם </h3>
<h2 class="inv_plain_2"><?=$MALE[$lang_idx]?>: <span <? if (isHeb()) echo "dir=\"rtl\""; ?> class="big"><? echo get_name($row_verdict["field_name"]);?></span> <span <? if (isHeb()) echo "dir=\"rtl\""; ?> >(<? echo $TOTAL_VOTERS[$lang_idx].": ".$total;?>)</span></h2>
<a class="enlarge" href="imageSQLGraph.php?title=<?=urlencode($title)?>&survey_id=<?=$_REQUEST['survey_id']?>&g=m&temp_from=<?=$temp_from?>&temp_to=<?=$temp_to?>&Xtitle=&Ytitle=&lang_idx=<?=$lang_idx?>&total=<?=$total?>&width=1000" target="_system" title="click to enlarge">
<img src="imageSQLGraph.php?title=<?=urlencode($title)?>&survey_id=<?=$_REQUEST['survey_id']?>&g=m&temp_from=<?=$temp_from?>&temp_to=<?=$temp_to?>&Xtitle=&Ytitle=&lang_idx=<?=$lang_idx?>&total=<?=$total?>&width=320" /><br/>
</a>
</div>
<?
    if (!empty($_SESSION['email'])){
    $result = mysqli_query($link, $my_query_total_f);
    $row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
    $total = $row["count( * )"];
    $result = mysqli_query($link, $my_query_verdict_f);
    $row_verdict = @mysqli_fetch_array($result, MYSQLI_ASSOC);

    ?>
<div class="clear float">
<h3 class="inv_plain_2"><?=$MY_VOTES[$lang_idx]?></h3>
<h2 class="inv_plain_2"><?=$FEMALE[$lang_idx]?>: <span <? if (isHeb()) echo "dir=\"rtl\""; ?> class="big"><? echo get_name($row_verdict["field_name"]);?></span> <span <? if (isHeb()) echo "dir=\"rtl\""; ?> >(<? echo $TOTAL_VOTERS_FEMALE[$lang_idx].": ".$total;?>)</span></h2>
<? if ($total > 0) {?>
<a class="enlarge" href="imageSQLGraph.php?title=<?=urlencode($title)?>&survey_id=<?=$_REQUEST['survey_id']?>&g=f&temp_from=<?=$temp_from?>&temp_to=<?=$temp_to?>&Xtitle=&Ytitle=&email=<?=$email?>&lang_idx=<?=$lang_idx?>&total=<?=$total?>&width=1000" target="_system" title="click to enlarge">
<img src="imageSQLGraph.php?title=<?=urlencode($title)?>&survey_id=<?=$_REQUEST['survey_id']?>&g=f&temp_from=<?=$temp_from?>&temp_to=<?=$temp_to?>&Xtitle=&Ytitle=&email=<?=$email?>&lang_idx=<?=$lang_idx?>&total=<?=$total?>&width=320" /><br/>
</a>
<?}?>
</div>
<?
    }
    $result = mysqli_query($link, $query_total_f);
    $row = @mysqli_fetch_array($result, MYSQLI_ASSOC);
    $total = $row["count( * )"];
    $result = mysqli_query($link, $query_verdict_f);
    $row_verdict = @mysqli_fetch_array($result, MYSQLI_ASSOC);

    ?>
<div class="float">
<h3 class="inv_plain_2">כולם </h3>
<h2 class="inv_plain_2"><?=$FEMALE[$lang_idx]?>: <span <? if (isHeb()) echo "dir=\"rtl\""; ?> class="big"><? echo get_name($row_verdict["field_name"]);?></span> <span <? if (isHeb()) echo "dir=\"rtl\""; ?> >(<? echo $TOTAL_VOTERS_FEMALE[$lang_idx].": ".$total;?>)</span></h2>
<a class="enlarge" href="imageSQLGraph.php?title=<?=urlencode($title)?>&survey_id=<?=$_REQUEST['survey_id']?>&g=f&temp_from=<?=$temp_from?>&temp_to=<?=$temp_to?>&Xtitle=&Ytitle=&lang_idx=<?=$lang_idx?>&total=<?=$total?>&width=1000" target="_system" title="click to enlarge">
<img src="imageSQLGraph.php?title=<?=urlencode($title)?>&survey_id=<?=$_REQUEST['survey_id']?>&g=f&temp_from=<?=$temp_from?>&temp_to=<?=$temp_to?>&Xtitle=&Ytitle=&lang_idx=<?=$lang_idx?>&total=<?=$total?>&width=320" /><br/>
</a>
</div>
<h3 class="clear inv_plain_2"><?=$MY_VOTES[$lang_idx]?> </h3>
<table class="inv_plain_3_zebra float" style="width:330px;border:1px solid">
    <tr><th>הערות</th><th>מגדר</th><th>טמפ</th><th>הצבעה</th></tr>
<?
ini_set("display_errors","On");
$query = "SELECT * FROM `surveyresult` sr inner join `surveyfields` sf on sf.survey_id = sr.survey_id and sf.field_id = sr.value WHERE sr.survey_id=2 and `email` = ? ORDER BY `comments` DESC, `temp` DESC , `update_time` DESC  ";

if (!empty($_SESSION['email'])){ 
    $result = db_init($query, $_SESSION['email']);
    //echo $query;
    while ($line = mysqli_fetch_array($result["result"], MYSQLI_ASSOC)) {
    print "<tr >";
    print "<td class=\"inv_plain_3_zebra\">" . $line["comments"] . "</td>";
    print "<td class=\"inv_plain_3_zebra\">" . $line["gender"] . "</td>";
    print "<td class=\"inv_plain_3_zebra\">" . $line["temp"] . "</td>";
    print "<td class=\"inv_plain_3_zebra\">" . get_name($line["field_name"]) . "</td>";
    
    //print "<td >" . $line["update_time"] . "</td>";
    print "</tr >";
    }
    
}
else{
    print "<h2>צריך להתחבר</h2>";
}


?>
</table>
