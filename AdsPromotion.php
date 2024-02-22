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


$msgSent = false;
if (!empty($_SESSION['email']))
    $email = $_SESSION['email'];
else {
    $email = $_REQUEST['email'];
}
if (isset($_POST['SendButton'])) {

	$name = $_POST['name'];

	$email = $_POST['email'];

	$message = $_POST['message'];

	if ($_POST['name']=="" || $_POST['message']=="") 

	{

		// wrong values

		echo("<div class=\"text-error alert\"><div class=\"high\">you have entered wrong values   חסרים שדות</div></div>");

	}
	else if (!check_email_address($_POST['email']))
	{
		echo("<div class=\"text-error alert\"><div class=\"high\">Email is not valid אימייל לא חוקי</div></div>");
	}

	else if((stristr($_SERVER['HTTP_REFERER'], "station.php") > -1 )||(stristr($_SERVER['HTTP_REFERER'], "small") > -1 )){

		$msgSent = true;
		$insert_msgdate = date('Y-m-d G:i:s', strtotime(SERVER_CLOCK_DIFF, time()));
		
		$message = str_replace("\"", "''", $message);
		$message = "<div class=\"float\">".$message."</div>";
		$msgBody = "{$insert_msgdate}\n"."<div class=\"float slogan\">".$name."</div>{$message}";
		
		$result = send_Email($msgBody, ME, $email, $name, "", array("New contact to 02WS", "הודעה חדשה לצרו קשר של ירושמיים"));
		
		if ($_GET['lang'] == 0)
			echo "<div style=\"height:100px;text-align: center;\" class=\"alert-success white-box big\" ><p>Message was sent</p></div>";
		else
			echo "<div style=\"height:100px;text-align: center;\" class=\"alert-success white-box big\" ><p>ההודעה נשלחה</p><p>נחזור אליך בקרוב</p><p>תודה</p></div>";
		
	?>
		<!-- <script type="text/javascript" src="ajaxEmail.js"></script>
		<script language="JavaScript" type="text/javascript">
			// startEmailService(message_from, message_subject, message_body, target , info_back)
			var messageBody = escape(encodeURI("<?=$msgSpecial?>"));
			<?// echo "startEmailService(escape(encodeURI('".$email."')) , escape(encodeURI('mail from ".$name."')) , messageBody , 'ME' , true);"; ?>
		</script> -->
	<?
	}
	else{
	  echo("page came from...".$_SERVER['HTTP_REFERER']."");
	}

}

?>
<? if (!$msgSent) {?>

<!--<form method="post">

<div class="inv_plain_3" style="padding:4em 0 1em;margin:auto;width:85%">
	<div style="padding:0.5em">
		<input name="name" size="30" maxlength="50" placeholder="<? if (isHeb()) echo "שם"; else echo "Name";?>" value="<? echo $name;?>" style="width:55%;text-align:<?if (isHeb()) echo "right"; else "left";?>" />
	</div>

	<div style="padding:0.5em">
            <input name="email" type="email" size="30" maxlength="50" placeholder="Email" style="width:55%;text-align:left" value="<? echo $email;?>" />
	</div>
</div>

<div class="inv_plain_3" style="clear:both;padding:1em 0;text-align:center;width:85%;margin:auto" <?if (isHeb()) echo " dir=\"rtl\"";?>>

	<strong><? if (isHeb()) echo "בא לי להגיד ש..."; else echo "I wanted to say:";?></strong><br/>

	<textarea name="message" rows="6"  value="<? echo $message; ?>" style="width:85%;font-size: 1.1em;"><? echo $message; ?></textarea>

</div>


    
<div style="clear:both;text-align:center;padding:1em 0;width:85%;margin:0.1em auto">
		<input type="submit" name="SendButton" style="width:85%;font-size: 1.2em;" class="inv_plain_3_zebra btn-primary" value="<? if (isHeb()) echo "שליחת הודעה"; else echo "Send Message";?>"/>
</div>

</form>-->


<div class="inv_plain_3_zebra">
<h2 class="big">  קמפיין פרסום בירושמיים</h2>

<br/>
	<div style="direction:rtl" class="inv_plain_3 big">
		
 פלטפורמת ירושמיים מציעה מגוון אפשרויות פרסום לבעלי עסקים ומוסדות תרבות.<br/>
לפרטים יש ליצור קשר במייל: <a href = "mailto: media@just-brief.com">לחצו כאן</a>
או לשלוח טופס הזמנה  <a href="https://forms.monday.com/forms/9c49d1eb497e423f5acc4df054de237d?r=euc1" target="_blank">בקישור זה</a> ונחזור אליכם


			
	</div>
	<br/><br/>
	
	
<div id="if_jerusky" style="display: block;"><a href="https://forms.monday.com/forms/9c49d1eb497e423f5acc4df054de237d?r=euc1" target="_blank"><img src="images/Brief.gif" width="820"  alt="Brief"/></a></div>
	<br/>

</div>

<? } ?>


