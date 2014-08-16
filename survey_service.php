<?

$msgSent = false;
header('Content-type: text/html; charset=utf-8');
session_start();
define("MANAGER_NAME","bn");
ini_set("display_errors","On");
function insertNewMessage ($survey_id, $value)
{
		$now = date('Y-m-d G:i:s', strtotime("0 hours 0 minutes", time()));
		//$now = getLocalTime(time());
		$query = "INSERT INTO surveyresult (survey_id, value, ip, update_time) VALUES('{$survey_id}', '{$value}', '{$_SERVER['REMOTE_ADDR']}','{$now}');";
		//echo $query;
		$result = db_init($query);
		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}
		// Free resultset 
		@mysql_free_result($result);
		
	//}
}

if (isset($_POST['SendButton'])) {

		$msgSent = true;
		$result = insertNewMessage($_POST['survey_id'], $_POST['value_chosen']);
		if ($result == "")
			echo "<fieldset class=\"inv\"><b>... תודה...</b></fieldset>";
		else
			echo "<fieldset class=\"high\"><b>$result</b></fieldset>";
	?>
		<!-- <script type="text/javascript" src="ajaxEmail.js"></script>
		<script language="JavaScript" type="text/javascript">
			// startEmailService(message_from, message_subject, message_body, target , info_back)
			var messageBody = escape(encodeURI("<?=$msgSpecial?>"));
			<? echo "startEmailService(escape(encodeURI('".$email."')) , escape(encodeURI('mail from ".$name."')) , messageBody , 'ME' , true);"; ?>
		</script> -->
	<?
	}
	else{
	  echo("page came from...".$_SERVER['HTTP_REFERER']."");
	}

}
$query = "SELECT sf.`field_id` , sf.`field_name` , s.name FROM surveyfields sf, survey s WHERE s.survey_id = sf.survey_id";
$result = db_init($query);
while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	$lines++;
	$linesInColumn++;
	$col = 0;
	$timestamp_date = strtotime($line["date_chat"]);

		print "\n\t\t<div>";
		print "\n\t\t<input type=\"checkbox\" id=\"idx".($line["field_id"])."\" value=\"".$line["field_id"]."\" style=\"float:".get_s_align().";".$styleUpdate."\" />&nbsp;";
		print $line["field_name"];
		print "\n\t\t</div>";
		


	
}
?>

<form method="post">



<? if (!$msgSent) {?>
<div class="inv_plain_3" style="clear:both;text-align:center;padding:1em">
	<input type="submit" name="SendButton" value="Vote"/>
	<?=get_arrow()?><?=get_arrow()?>
</div>
<? } ?>
</div>
</form>
