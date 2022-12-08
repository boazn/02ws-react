<?

$sent = false;
$emailnotvalid = false;
if (!empty($_SESSION['email']))
    $email = $_SESSION['email'];
?>
<html>

<head>
<style>
h1 {
	text-align:center
}
#feedbacktable td {
	text-align: <? echo get_align(); ?>;
}
</style>
</head>

<body>
<h1>
<? if (isHeb()) echo "משוב על האתר"; else echo "Feedback about the site";?>	
</h1>
<?
function verifyUserResponse ()
{
	$ch = curl_init();
	global $recapcha_secret_key;
	curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,
				"secret=".$recapcha_secret_key."&response=".$_POST["g-recaptcha-response"]);
	// Receive server response ...
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$server_output = curl_exec($ch);
	//print_r($server_output);
	curl_close ($ch);
	return json_decode($server_output);
	
}
/*$empty = $post = array();
foreach ($_POST as $varname => $varvalue) {
   if (empty($varvalue)) {
       $empty[$varname] = $varvalue;
   } else {
       $post[$varname] = $varvalue;
   }
}

print "<pre>";
if (empty($empty)) {
   print "None of the POSTed values are empty, posted:\n";
   var_dump($post);
} else {
   print "We have " . count($empty) . " empty values\n";
   print "Posted:\n"; var_dump($post);
   print "Empty:\n";  var_dump($empty);
   //exit;
}*/
//include ("ini.php");
if (isset($_POST['message'])) {

		$email = $_POST['email'];

		if (!check_email_address($_POST['email']))
		{
			echo("<div><div class=\"text-error alert\">Email is not valid אימייל לא חוקי</div></div>");
			$emailnotvalid = true;
			
		}
		else
		{
			$res_j = verifyUserResponse();
			//print_r($res_j);
			if (($res_j->success != 1) || ($res_j->score < 0.5)){
				echo "I am robot";
				exit;
			}
			$msgSpecial = "";
								
			if (isset( $_POST['sigweather']))
				$msgSpecial .= "";
			if (isset( $_POST['forecast']))
				$msgSpecial .= "";
			if (isset( $_POST['globalwarm']))
				$msgSpecial .= "";
			if (isset( $_POST['radiosonde']))
				$msgSpecial .= "";
			if (isset( $_POST['comboforecast']))
				$msgSpecial .= "<br/>"."<b>forecast</b> --> ".$_POST['comboforecast'];
			if (isset( $_POST['combowarming']))
				$msgSpecial .= "<br/>"."<b>global warming</b> --> ".$_POST['combowarming'];
			if (isset( $_POST['combofirstpage']))
				$msgSpecial .= "<br/>"."<b>first page</b> --> ".$_POST['combofirstpage'];
			if (isset( $_POST['comboradio']))
				$msgSpecial .= "<br/>"."<b>radiosonde</b> --> ".$_POST['comboradio'];
			if (isset( $_POST['combographs']))
				$msgSpecial .= "<br/>"."<b>graphs</b> --> ".$_POST['combographs'];
			if (isset( $_POST['comborecords']))
				$msgSpecial .= "<br/>"."<b>history</b> --> ".$_POST['comborecords'];
			if (isset( $_POST['coldmeter']))
				$msgSpecial .= "<br/>"."<b>coldmeter</b> --> ".$_POST['coldmeter'];
			$msgSpecial = str_replace("\"", "''", $msgSpecial);
			$msgSpecial = $msgSpecial."<br /><br />".$_POST['message'];
			$result = send_Email($msgSpecial, ME, $email, $email, "", array('feedback to 02ws', 'משוב על ירושמיים'));
		//if ($result == ""){
			echo "<div class=\"alert-success big\" style=\"text-align: center\"><br /><br />...The message was sent ההודעה נשלחה...<br /><br />Thanks תודה<br /><br /><br /></div>";
			$sent = true;
		//}
		//else
			//echo "<fieldset class=\"high\"><strong>$result</strong></fieldset>";
			?>
			<script type="text/javascript" src="ajaxEmail.js"></script>
			<script language="JavaScript" type="text/javascript">
				// startEmailService(message_from, message_subject, message_body, target , info_back)
				var messageBody = escape(encodeURI("<?=$msgSpecial?>"));
				<? //echo "startEmailService(escape(encodeURI('".$email."')) , escape(encodeURI('feedback from 02ws')) , messageBody , 'ME' , true);"; ?>
			</script>
		<?}

		
		

}

?>

<form method="post" id="feedback_form">
<div class="clear float" style="width:50%">
	<div style="direction:rtl">
		<a href="<? echo get_query_edited_url($url_cur, 'section', 'AdsPromotion.php');?>" target="_self">פנייה לבקשת פרסום באתר ובאפליקציית ירושמיים הקישו כאן <?=get_arrow()?></a>
	</div>
	<br/>
<table id="feedbacktable" width="100%" cellspacing="10" <? if (isHeb()) echo "dir=\"rtl\""; ?>>

<tr >
	<td>
		<? if (isHeb()) echo "העמוד הראשי הוא" ; else echo "The first page (02ws.co.il/station.php) is";?>
	</td>
	<td <? echo get_align(); ?>>
	
	<select size="1" name="combofirstpage" id="combofirstpage" class="inv_plain_2" style="width:300px;font-size: 1.1em;<? if (isHeb()) echo "direction:rtl";?>">  
		<option	 class="inv_plain_2"	 value=""><? if (isHeb()) echo "בחר" ; else echo "choose"; ?></option>
		<option	 class="inv_plain_2"	 value="too informative"><? if (isHeb()) echo "  עמוס מידי - יותר מידי מידע"; else echo "too informative";?></option>
		<option	 class="inv_plain_2"	 value="more colors"><? if (isHeb()) echo " צריך להוסיף צבעים וסדר"; else echo "need to add colors";?></option>
		<option	 class="inv_plain_2"	 value="exactly what I need"><? if (isHeb()) echo " בדיוק מה שאני צריך"; else echo "exactly what I need";?></option>
		<option	 class="inv_plain_2"	 value="messed up"><? if (isHeb()) echo "מבולגן"; else echo "is without order";?></option>
		<option	 class="inv_plain_2"	 value="ugly"><? if (isHeb()) echo "מכוער"; else echo "is ugly";?></option>
		<option	 class="inv_plain_2"	 value="It would be nice to have more info & graphs"><? if (isHeb()) echo " עם מעט מידי מידע"; else echo "It would be nice to have more info";?></option>
		<option	 class="inv_plain_2"	 value="I don't understand"><? if (isHeb()) echo "אני לא מבין כלום"; else echo "I don't understand the first page";?> </option>
		<option	 class="inv_plain_2"	 value="I can't find it"><? if (isHeb()) echo "  איפה אפשר למצוא את זה"; else echo "where do I find it?";?></option>
	</select>	
	</td>

</tr>



<tr  >

<td>
	<? if (isHeb()) echo "התחזית עצמה" ; else echo "The forecast is";?>
	</td>
<td  <? echo get_align(); ?>>
	
	<select size="1" name="comboforecast" id="comboforecast" class="inv_plain_2" style="width:300px;font-size: 1.1em;<? if (isHeb()) echo "direction:rtl";?>">  
		<option	 class="inv_plain_2"	 value=""><? if (isHeb()) echo "בחר" ; else echo "choose"; ?></option>
		<option	 class="inv_plain_2"	 value="too informative"><? if (isHeb()) echo "  עמוס מידי - יותר מידי מידע"; else echo "too informative";?></option>
		<option	 class="inv_plain_2"	 value="more colors"><? if (isHeb()) echo " צריך להוסיף צבעים וסדר"; else echo "need to add colors";?></option>
		<option	 class="inv_plain_2"	 value="exactly what I need"><? if (isHeb()) echo " בדיוק מה שאני צריך"; else echo "exactly what I need";?></option>
		<option	 class="inv_plain_2"	 value="messed up"><? if (isHeb()) echo "מבולגן"; else echo "is without order";?></option>
		<option	 class="inv_plain_2"	 value="ugly"><? if (isHeb()) echo "מכוער"; else echo "is ugly";?></option>
		<option	 class="inv_plain_2"	 value="It would be nice to have more info"><? if (isHeb()) echo " עם מעט מידי מידע"; else echo "It would be nice to have more info";?></option>
		<option	 class="inv_plain_2"	 value="I don't understand the forecast"><? if (isHeb()) echo "אני לא מבין כלום"; else echo "I don't understand the forecast";?></option>
		<option	 class="inv_plain_2"	 value="I can't find it"><? if (isHeb()) echo "  איפה אפשר למצוא את זה"; else echo "where do I find it?";?></option>
	</select>	
	</td>

</tr>

<tr  >
	<td>
		<? if (isHeb()) echo "הגרפים של הטמפרטורה הלחות והגשם"; else echo "The graphs section";?>
	</td>
	<td  dir="ltr" <? echo get_align(); ?>>
	
	<select size="1" name="combographs" id="combographs" class="inv_plain_2" style="width:300px;font-size: 1.1em;<? if (isHeb()) echo "direction:rtl";?>">  
		<option	 class="inv_plain_2"	 value=""><? if (isHeb()) echo "בחר" ; else echo "choose"; ?></option>
		<option	 class="inv_plain_2"	 value="too informative"><? if (isHeb()) echo "  עמוס מידי - יותר מידי מידע"; else echo "too informative";?></option>
		<option	 class="inv_plain_2"	 value="more colors"><? if (isHeb()) echo " צריך להוסיף צבעים וסדר"; else echo "need to add colors";?></option>
		<option	 class="inv_plain_2"	 value="exactly what I need"><? if (isHeb()) echo " בדיוק מה שאני צריך"; else echo "exactly what I need";?></option>
		<option	 class="inv_plain_2"	 value="messed up"><? if (isHeb()) echo "מבולגן"; else echo "is without order";?></option>
		<option	 class="inv_plain_2"	 value="ugly"><? if (isHeb()) echo "מכוער"; else echo "is ugly";?></option>
		<option	 class="inv_plain_2"	 value="It would be nice"><? if (isHeb()) echo " עם מעט מידי מידע"; else echo "It would be nice to have more info";?></option>
		<option	 class="inv_plain_2"	 value="I don't understand"><? if (isHeb()) echo "אני לא מבין כלום"; else echo "I don't understand";?></option>
		<option	 class="inv_plain_2"	 value="I can't find it"><? if (isHeb()) echo "  איפה אפשר למצוא את זה"; else echo "where do I find it?";?></option>
	</select>
	</td>

</tr>

<tr  >
	<td>
		<? if (isHeb()) echo "החלק של ההיסטוריה והדוחות"; else echo "The history and archive reports section";?>
	</td>
	<td <? echo get_align(); ?>>
	
	<select size="1" name="comborecords" id="comborecords" class="inv_plain_2" style="width:300px;font-size: 1.1em;<? if (isHeb()) echo "direction:rtl";?>">  
		<option	 class="inv_plain_2"	 value=""><? if (isHeb()) echo "בחר" ; else echo "choose"; ?></option>
		<option	 class="inv_plain_2"	 value="too informative"><? if (isHeb()) echo "  עמוס מידי - יותר מידי מידע"; else echo "too informative";?></option>
		<option	 class="inv_plain_2"	 value="more colors"><? if (isHeb()) echo " צריך להוסיף צבעים וסדר"; else echo "need to add colors";?></option>
		<option	 class="inv_plain_2"	 value="exactly what I need"><? if (isHeb()) echo " בדיוק מה שאני צריך"; else echo "exactly what I need";?></option>
		<option	 class="inv_plain_2"	 value="messed up"><? if (isHeb()) echo "מבולגן"; else echo "is without order";?></option>
		<option	 class="inv_plain_2"	 value="ugly"><? if (isHeb()) echo "מכוער"; else echo "is ugly";?></option>
		<option	 class="inv_plain_2"	 value="It would be nice"><? if (isHeb()) echo " עם מעט מידי מידע"; else echo "It would be nice to have more info";?></option>
		<option	 class="inv_plain_2"	 value="I don't understand"><? if (isHeb()) echo "אני לא מבין כלום"; else echo "I don't understand";?></option>
		<option	 class="inv_plain_2"	 value="I can't find it"><? if (isHeb()) echo "  איפה אפשר למצוא את זה"; else echo "where do I find it?";?></option>
	</select>
	</td>

</tr>
<tr  >
	<td>
		<? if (isHeb()) echo "מדד הקור"; else echo "The cold meter";?>
	</td>
	<td   <? echo get_align(); ?>>
	
	<select size="1" name="coldmeter" id="coldmeterf" class="inv_plain_2" style="width:300px;font-size: 1.1em;<? if (isHeb()) echo "direction:rtl";?>">  
		<option	 class="inv_plain_2"	 value=""><? if (isHeb()) echo "בחר" ; else echo "choose"; ?></option>
		<option	 class="inv_plain_2"	 value="too informative"><? if (isHeb()) echo "  עמוס מידי - יותר מידי מידע"; else echo "too informative";?></option>
		<option	 class="inv_plain_2"	 value="more colors"><? if (isHeb()) echo " צריך להוסיף צבעים וסדר"; else echo "need to add colors";?></option>
		<option	 class="inv_plain_2"	 value="exactly what I need"><? if (isHeb()) echo " בדיוק מה שאני צריך"; else echo "exactly what I need";?></option>
		<option	 class="inv_plain_2"	 value="messed up"><? if (isHeb()) echo "מבולגן"; else echo "is without order";?></option>
		<option	 class="inv_plain_2"	 value="ugly"><? if (isHeb()) echo "מכוער"; else echo "is ugly";?></option>
		<option	 class="inv_plain_2"	 value="It would be nice"><? if (isHeb()) echo " עם מעט מידי מידע"; else echo "It would be nice to have  more info";?></option>
		<option	 class="inv_plain_2"	 value="I don't understand"><? if (isHeb()) echo "אני לא מבין כלום"; else echo "I don't understand";?></option>
		<option	 class="inv_plain_2"	 value="I can't find it"><? if (isHeb()) echo "  איפה אפשר למצוא את זה"; else echo "where do I find it?";?></option>
	</select>
	</td>

</tr>
<tr  >
	<td>
		<? if (isHeb()) echo "עמוד ההתחממות הגלובלית הוא"; else echo "The global warming section is";?>
	</td>
	<td  <? echo get_align(); ?>>
	
	<select size="1" name="combowarming" id="combowarming" class="inv_plain_2" style="width:300px;font-size: 1.1em;<? if (isHeb()) echo "direction:rtl";?>">  
		<option	 class="inv_plain_2"	 value=""><? if (isHeb()) echo "בחר" ; else echo "choose"; ?></option>
		<option	 class="inv_plain_2"	 value="too informative"><? if (isHeb()) echo "  עמוס מידי - יותר מידי מידע"; else echo "too informative";?></option>
		<option	 class="inv_plain_2"	 value="more colors"><? if (isHeb()) echo " צריך להוסיף צבעים וסדר"; else echo "need to add colors";?></option>
		<option	 class="inv_plain_2"	 value="exactly what I need"><? if (isHeb()) echo " בדיוק מה שאני צריך"; else echo "exactly what I need";?></option>
		<option	 class="inv_plain_2"	 value="messed up"><? if (isHeb()) echo "מבולגן"; else echo "is without order";?></option>
		<option	 class="inv_plain_2"	 value="ugly"><? if (isHeb()) echo "מכוער"; else echo "is ugly";?></option>
		<option	 class="inv_plain_2"	 value="It would be nice to have more info and graphs"><? if (isHeb()) echo " עם מעט מידי מידע"; else echo "It would be nice to have more info";?></option>
		<option	 class="inv_plain_2"	 value="I don't understand"><? if (isHeb()) echo "אני לא מבין כלום"; else echo "I don't understand";?></option>
		<option	 class="inv_plain_2"	 value="I can't find it"><? if (isHeb()) echo "  איפה אפשר למצוא את זה"; else echo "where do I find it?";?></option>
	</select>
	</td>

</tr>
<tr  >
	<td>
		<? if (isHeb()) echo "הרדיוסונדה"; else echo "The radiosonde is";?>
	</td>
	<td   <? echo get_align(); ?>>
	
	<select size="1" name="comboradio" id="comboradio" class="inv_plain_2" style="width:300px;font-size: 1.1em;<? if (isHeb()) echo "direction:rtl";?>">  
		<option	 class="inv_plain_2"	 value=""><? if (isHeb()) echo "בחר" ; else echo "choose"; ?></option>
		<option	 class="inv_plain_2"	 value="too informative"><? if (isHeb()) echo "  עמוס מידי - יותר מידי מידע"; else echo "too informative";?></option>
		<option	 class="inv_plain_2"	 value="more colors"><? if (isHeb()) echo " צריך להוסיף צבעים וסדר"; else echo "need to add colors";?></option>
		<option	 class="inv_plain_2"	 value="exactly what I need"><? if (isHeb()) echo " בדיוק מה שאני צריך"; else echo "exactly what I need";?></option>
		<option	 class="inv_plain_2"	 value="messed up"><? if (isHeb()) echo "מבולגן"; else echo "is without order";?></option>
		<option	 class="inv_plain_2"	 value="ugly"><? if (isHeb()) echo "מכוער"; else echo "is ugly";?></option>
		<option	 class="inv_plain_2"	 value="It would be nice"><? if (isHeb()) echo " עם מעט מידי מידע"; else echo "It would be nice to have  more info";?></option>
		<option	 class="inv_plain_2"	 value="I don't understand"><? if (isHeb()) echo "אני לא מבין כלום"; else echo "I don't understand";?></option>
		<option	 class="inv_plain_2"	 value="I can't find it"><? if (isHeb()) echo "  איפה אפשר למצוא את זה"; else echo "where do I find it?";?></option>
	</select>
	</td>

</tr>
</table>

</div>
<div class="float" style="margin:1em 2em">
Email:
<input name="email"  id="inputemail" maxlength="50" style="width:350px;text-align:left" value="<? echo $email;?>" />
</div>
<div class="float" style="margin:0.2em 0.5em 0.2em 2em">
	<? if (isHeb()) echo "עוד משהו רציתי להגיד"; else echo "one more thing";?><br />
	<? if (!$sent) {?>
	<textarea name="message" cols="40" rows="10" <?if (isHeb()) echo " dir=\"rtl\"";?>  value="<?=$_POST['message']?>" style="width:400px;border:1px solid #ccc;font-size: 1.2em;"><?=$_POST['message']?></textarea>
	<?} else {?>
		<pre><?=$_POST['message']?></pre>
	<?} ?>
	
</div>
<div class="invfloat">
	<? if (!$sent) {?>
	<button
		
		id="SendButton" 
		name="SendButton"
		style="width:300px;font-size: 1.5m;margin:0 11em;padding:0.3em 1.2em;cursor:pointer" 
		class="base big inv g-recaptcha" 
        data-sitekey="6LcQXKMcAAAAADMZ52L6dJrMMzvnKaJzyT8RGnqO" 
        data-callback='onSubmit' 
        data-action='submit'><? if (isHeb()) echo "שליחת הודעה"; else echo "Send";?></button>

	<?} ?>
</div>
</form>
<? 
if ($emailnotvalid)
{
	echo("<script language=\"JavaScript\" type=\"text/javascript\">");
	echo("var inputemail = document.getElementById('inputemail');");
	echo("inputemail.style.border = \"2px solid red\";");
	echo("inputemail.focus();");
	echo("</script>");
}
?>
<script src="https://www.google.com/recaptcha/api.js"></script>
<script>
   function onSubmit(token) {
     document.getElementById("feedback_form").submit();
   }
 </script>

</body>

</html>