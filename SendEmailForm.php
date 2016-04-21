<?
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
   exit;
}*/

//if (!isset($_POST['name'])) { $_POST['name']=""; $_POST['message']=""; }

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
$msgSent = false;
if (!empty($_SESSION['email']))
    $email = $_SESSION['email'];

if (isset($_POST['SendButton'])) {

	$name = $_POST['name'];

	$email = $_POST['email'];

	$message = $_POST['message'];

	if ($_POST['name']=="" || $_POST['message']=="") 

	{

		// wrong values

		echo("<fieldset><div class=\"logo\"><div class=\"high\">you have entered wrong values   חסרים שדות</div></div></fieldset>");

	}
	else if (!check_email_address($_POST['email']))
	{
		echo("<fieldset><div class=\"logo\"><div class=\"high\">Email is not valid אימייל לא חוקי</div></div></fieldset>");
	}

	else if((stristr($_SERVER['HTTP_REFERER'], "station.php") > -1 )||(stristr($_SERVER['HTTP_REFERER'], "small.php") > -1 )){

		$msgSent = true;
		$insert_msgdate = date('Y-m-d G:i:s', strtotime(SERVER_CLOCK_DIFF, time()));
		
		$message = str_replace("\"", "''", $message);
		$message = "<div class=\"float\">".$message."</div>";
		$msgBody = "{$insert_msgdate}\n"."<div class=\"float slogan\">".$name."</div>{$message}";
		
		$result = send_Email($msgBody, ME, $email, $name, "", array("New contact to 02WS", "הודעה חדשה לצרו קשר של ירושמיים"));
		if ($result == "")
			echo "<fieldset class=\"topbase slogan afont\" style=\"height:200px\"><br /><br />...The Message was sent ההודעה נשלחה...<br /><br />Thanks תודה<br /><br /><br /></fieldset>";
		else
			echo "<fieldset class=\"high\"><strong>$result</strong></fieldset>";
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

?>
<? if (!$msgSent) {?>

<form method="post">

<div class="inv_plain_3" style="padding:4em 0 1em;margin:auto;width:85%">
	<div style="padding:0.5em">
		<input name="name" size="30" maxlength="50" placeholder="<? if (isHeb()) echo "שם"; else echo "Name";?>" value="<? echo $name;?>" style="width:55%;text-align:<?if (isHeb()) echo "right"; else "left";?>" />
	</div>

	<div style="padding:0.5em">
		<input name="email" size="30" maxlength="50" placeholder="Email" style="width:55%;text-align:left" value="<? echo $email;?>" />
	</div>
</div>

<div class="inv_plain_3" style="clear:both;padding:1em 0;text-align:center;width:85%;margin:auto" <?if (isHeb()) echo " dir=\"rtl\"";?>>

	<strong><? if (isHeb()) echo "בא לי להגיד ש..."; else echo "I wanted to say:";?></strong><br/>

	<textarea name="message" rows="6"  value="<? echo $message; ?>" style="width:85%;font-size: 1.1em;"><? echo $message; ?></textarea>

</div>


    
<div style="clear:both;text-align:center;padding:1em 0;width:85%;margin:0.1em auto">
		<input type="submit" name="SendButton" style="width:85%;font-size: 1.2em;" class="inv_plain_3_zebra" value="<? if (isHeb()) echo "שליחת הודעה"; else echo "Send Message";?>"/>
</div>

</form>
<? } ?>


