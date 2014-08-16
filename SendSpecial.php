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


if (isset($_POST['SendButton'])) {

	$name = $_POST['name'];

	$email = $_POST['email'];

	$message = $_POST['message'];

	if ($_POST['message']=="") 

	{

		// wrong values

		echo("<fieldset><div class=\"logo\"><div class=\"high\">you have entered wrong values   חסרים שדות</div></div></fieldset>");

	}
	

	else {

		$msgSent = true;
		$msgSpecial = "";
		$msgSpecial .= "<pre>".$_POST['message']."</pre>";
					
		if (isset( $_POST['sigweather']))
			$msgSpecial .= BASE_URL.substr(strrchr($_SERVER["PHP_SELF"], "/"), 0)."?lang=".$lang_idx."&section=sigweather.php".get_file_string(BASE_URL.substr(strrchr($_SERVER["PHP_SELF"], "/"), 0)."?lang=".$lang_idx."&section=sigweather.php");
		if (isset( $_POS['forecast']))
			$msgSpecial .= BASE_URL.substr(strrchr($_SERVER["PHP_SELF"], "/"), 0)."?lang=".$lang_idx."&section=forecast.php".get_file_string(BASE_URL.substr(strrchr($_SERVER["PHP_SELF"], "/"), 0)."?lang=".$lang_idx."&section=forecast.php");
		if (isset( $_POST['globalwarm']))
			$msgSpecial .= BASE_URL.substr(strrchr($_SERVER["PHP_SELF"], "/"), 0)."?lang=".$lang_idx."&section=globalwarm.php".get_file_string(BASE_URL.substr(strrchr($_SERVER["PHP_SELF"], "/"), 0)."?lang=".$lang_idx."&section=globalwarm.php");
		if (isset( $_POST['radiosonde']))
			$msgSpecial .= BASE_URL.substr(strrchr($_SERVER["PHP_SELF"], "/"), 0)."?lang=".$lang_idx."&section=radiosonde.php".get_file_string(BASE_URL.substr(strrchr($_SERVER["PHP_SELF"], "/"), 0)."?lang=".$lang_idx."&section=radiosonde.php");

		$EmailSubject = array("02ws Update Service", "שירות עדכון ירושמיים");
		
		$result = send_Email($msgSpecial, ALL, EMAIL_ADDRESS, $EmailSubject[$HEB], "");
		if ($result == "")
			echo "<fieldset class=\"topbase slogan afont\" style=\"height:200px\"><br /><br />...The Message was sent ההודעה נשלחה...<br /><br />Thanks תודה<br /><br /><br /></fieldset>";
		else
			echo "<fieldset class=\"high\"><strong>$result</strong></fieldset>";
	
	}
	

}

else {?>

<form method="post">
<input type="checkbox" name="sigweather" <? if (isset( $_POST['sigweather'])) echo " checked"; ?>/> sigweather
<input type="checkbox" name="forecast" <? if (isset( $_POST['forecast'])) echo " checked"; ?>/> Forecast
<input type="checkbox" name="globalwarm" <? if (isset( $_POST['globalwarm'])) echo " checked"; ?>/> globalwarm
<input type="checkbox" name="radiosonde" <? if (isset( $_POST['radiosonde'])) echo " checked"; ?>/> radiosonde

<div class="inv_plain_3_minus" style="clear:both;padding:1em;float:<?echo get_s_align();?>;width:90%;height:300px">
	<strong>Your message כאן כתוב את הודעתך</strong><br/>
	<textarea name="message" cols="80" rows="12" <?if (isHeb()) echo " dir=\"rtl\"";?>  value="<? echo $message; ?>" style="font-size: 1.2em;"><? echo $message; ?></textarea>
</div>


<div class="inv_plain_3" style="clear:both;text-align:center;padding:1em">
	<input type="submit" name="SendButton" value="Send Message שלח הודעה"/>
	<?=get_arrow()?><?=get_arrow()?>
</div>


</form>
<? } ?>