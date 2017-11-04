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
ini_set("display_errors","On"); 
define ("EMAIL_ADDRESS", "boazn1@gmail.com");

//header('Content-type: application/html; charset=windows-1255');

function send_Email($messageBody, $source, $sourcename)	
{
	ini_set("display_errors","On"); 
	require("phpmailer/class.phpmailer.php");
	$mail = new PHPMailer();
	$mail->From     = $source;
	$mail->FromName = $sourcename;
	$mail->Host     = "mailgw.netvision.net.il";
	$mail->Mailer   = "smtp";
	$mail->IsSMTP();
	$mail->AddReplyTo($source, $sourcename);
	
	global $WEBSITE_TITLE, $EN, $HEB;
	$EmailsToSend = array();		
	$headers  = "MIME-Version: 1.0\r\n";		
	$headers .= "Content-type: text/html; charset=UTF-8\r\n";
	//$headers .= "Content-Language: he\r\n";
	$headers .= "From: {$source}\r\n";		
	$headers .= "Reply-To: {$source}\r\n";
	//echo("message body = ".$messageBody);		
	$messageBody = str_replace("\n", "<br />", $messageBody);
	$messageBody = str_replace("display:none", "", $messageBody);
	$textToSend = "<html";
	$textToSend .= " dir=\"rtl\" ";
	$textToSend .= "><head><link href=\"style.css\" rel=\"stylesheet\" type=\"text/css\"> </head><body ><br/><table><tr><td>".$messageBody."</td></tr>";
	$textToSend .= "\n<tr><td></td></tr>";
	$textToSend .= "</table></body></html>";
	//$textToSend = '=?UTF-8?B?'.base64_encode($textToSend).'?=';
	$subject = "Update from ".$WEBSITE_TITLE[$EN];		
    array_push ($EmailsToSend, EMAIL_ADDRESS);
	
	$subject = "*** הודעה לאתר של אבישי ***";		
	

	
		
	foreach ($EmailsToSend as $email){			
		//echo "sending to $email...<br/>body=$textToSend<br/>Subject=$subject<br/>from=$source";
		$mail->Body    = $textToSend;
		$mail->AltBody = $textToSend;
		$mail->AddAddress($email, "");
		$mail->Subject = $subject;
		//$mail->AddStringAttachment("path/to/photo", "YourPhoto.jpg");
		//$mail->AddAttachment("c:/temp/11-10-00.zip", "new_name.zip");  // optional name
		//$mail->Send();
		if(!mail($email, $subject, $textToSend, $headers))
		{
			//ini_set("SMTP","mailgw.netvision.net.il");
			mail("boazn1@gmail.com", "JWS mail failure", "failed sending to $email"  , $headers);
			$result =  "<br />failed sending to $email. check your Email.";
		}

		// Clear all addresses and attachments for next loop
		$mail->ClearAddresses();
		$mail->ClearAttachments();
	}
	
	return $result;
}
function check_email_address($email) {
  // First, we check that there's one @ symbol, and that the lengths are right
   if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        return false;
    else
        return true;
}
$msgSent = false;


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

	else if(stristr($_SERVER['HTTP_REFERER'], "SendEmail") > -1 ){

		$msgSent = true;
		$insert_msgdate = date( "dS F Y - G:i:s" );
		$name = "<div class=\"slogan\">".$name."</div>";
		$message = "<div class=\"big\">".$message."</div>";
		$msgBody = "{$insert_msgdate}\n\n{$name}:\n{$message}";
		$msgBody = str_replace("\"", "''", $msgBody);
		$result = send_Email($msgBody, $email, $name);
		if ($result == "")
			echo "<fieldset class=\"topbase\">**************...ההודעה נשלחה...**************</fieldset>";
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

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="he" lang="he">
<head>
	<title>אבישי הדסי</title>
	<meta name="description" content="אבישי הדסי" />
	<meta name="keywords" content="אבישי הדסי"/>
	<meta name="author" content="בועז נחמיה" />
	<link rel="Stylesheet" href="style.css" />
	<link rel="stylesheet" type="text/css" href="css/jquery.lightbox-0.5.css" media="screen" />
</head>
<form method="post">

<div class="inv_plain_3_zebra" style="padding:1em 0.8em 1em 0.8em;float:right;width:90%;height:100px">
	<div style="padding:1em 0 1em 0">
		<b>Name</b>&nbsp;&nbsp;<b>&nbsp;שם</b><br />

		<input name="name" size="30" maxlength="50" value="<? echo $name;?>" style="text-align:right" />
	</div>

	<div style="padding:1em">
		<b>Email</b><br />
		<input name="email" size="30" maxlength="50" style="text-align:left" value="<? echo $email;?>" />

	</div>
</div>

<div class="inv_plain_3_minus" style="clear:both;padding:1em;float:right;width:90%;height:200px">

	<b>Your message כאן כתוב את הודעתך</b><br/>

	<textarea name="message" cols="80" rows="10"  dir="rtl" <? echo $message; ?>><? echo $message; ?></textarea>

</div>

<? if (!$msgSent) {?>

<div class="inv_plain_3" style="clear:both;text-align:center;padding:1em">
	
	<input type="submit" name="SendButton" value="Send Message שלח הודעה"/>
	

</div>

<? } ?>

</div>
</form>

