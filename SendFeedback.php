<?
function check_email_address($email) {
  // First, we check that there's one @ symbol, and that the lengths are right
  if (!ereg("[^@]{1,64}@[^@]{1,255}", $email)) {
    // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
    return false;
  }
  // Split it into sections to make life easier
  $email_array = explode("@", $email);
  $local_array = explode(".", $email_array[0]);
  
  for ($i = 0; $i < sizeof($local_array); $i++) {
     if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
      return false;
    }
  }  
  if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
    $domain_array = explode(".", $email_array[1]);
    if (sizeof($domain_array) < 2) {
        return false; // Not enough parts to domain
    }
    for ($i = 0; $i < sizeof($domain_array); $i++) {
      if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
        return false;
      }
    }
  }
  return true;
}
$sent = false;
$emailnotvalid = false;
?>
<html>

<head></head>

<body>
<h1 align="center">
<? if (isHeb()) echo "משוב על האתר"; else echo "Feedback about the site";?>	
</h1>
<?
//include ("ini.php");
if (isset($_POST['SendButton'])) {

		$email = $_POST['email'];

		if (!check_email_address($_POST['email']))
		{
			echo("<fieldset><div><div class=\"high\">Email is not valid אימייל לא חוקי</div></div></fieldset>");
			$emailnotvalid = true;
			
		}
		else
		{
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
		if ($result == ""){
			echo "<fieldset class=\"topbase slogan afont\" style=\"height:200px\"><br /><br />...The Message was sent ההודעה נשלחה...<br /><br />Thanks תודה<br /><br /><br /></fieldset>";
			$sent = true;
		}
		else
			echo "<fieldset class=\"high\"><strong>$result</strong></fieldset>";
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

<form method="post">
<div class="clear float" style="width:50%">
<table width="100%" cellspacing="10" <? if (isHeb()) echo "dir=\"rtl\""; ?>>

<tr  >
	<td align="<? if (isHeb()) echo "left"; else echo "right";?>">
		<? if (isHeb()) echo "העמוד הראשי הוא" ; else echo "The first page (02ws.co.il/station.php) is";?>
	</td>
	<td dir="ltr" <? echo get_align(); ?>>
	
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

<td align="<? if (isHeb()) echo "left"; else echo "right";?>">
	<? if (isHeb()) echo "התחזית עצמה" ; else echo "The forecast is";?>
	</td>
<td  dir="ltr" <? echo get_align(); ?>>
	
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
	<td align="<? if (isHeb()) echo "left"; else echo "right";?>">
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
	<td align="<? if (isHeb()) echo "left"; else echo "right";?>">
		<? if (isHeb()) echo "החלק של ההיסטוריה והדוחות"; else echo "The history and reoprts section";?>
	</td>
	<td  dir="ltr" <? echo get_align(); ?>>
	
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
	<td align="<? if (isHeb()) echo "left"; else echo "right";?>">
		<? if (isHeb()) echo "מדד הקור"; else echo "The cold meter";?>
	</td>
	<td  dir="ltr" <? echo get_align(); ?>>
	
	<select size="1" name="coldmeter" id="coldmeter" class="inv_plain_2" style="width:300px;font-size: 1.1em;<? if (isHeb()) echo "direction:rtl";?>">  
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
	<td align="<? if (isHeb()) echo "left"; else echo "right";?>">
		<? if (isHeb()) echo "עמוד ההתחממות הגלובלית הוא"; else echo "The global warming section is";?>
	</td>
	<td  dir="ltr" <? echo get_align(); ?>>
	
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
	<td align="<? if (isHeb()) echo "left"; else echo "right";?>">
		<? if (isHeb()) echo "הרדיוסונדה"; else echo "The radiosonde is";?>
	</td>
	<td  dir="ltr" <? echo get_align(); ?>>
	
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
<div class="float">
	<? if (!$sent) {?>
	<input type="submit" name="SendButton" value="<? if (isHeb()) echo "שליחת הודעה"; else echo "Send";?>" style="width:300px;font-size: 1.5m;margin:0 1em;padding:0.3em 1.2em;cursor:pointer" class="base big inv"/>
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
</body>

</html>