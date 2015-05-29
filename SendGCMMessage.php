<?
ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE);
$empty = $post = array();
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
}
echo "contentens: ".file_get_contents('php://input');
//if (!isset($_POST['name'])) { $_POST['name']=""; $_POST['message']=""; }


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
		$msgSpecial = $_POST['message'];
						
		//post_to_bufferApp($msgSpecial);    
                $result = sendAPNMessage($msgSpecial, $_POST['title'], $_POST['picture_url'], $_POST['embedded_url']);               
		//$EmailSubject = array("02ws Update Service", "שירות עדכון ירושמיים");
		
		//$result = send_Email($msgSpecial, ALL, EMAIL_ADDRESS, $EmailSubject[$HEB], "");
		if ($result == "")
			echo "<fieldset class=\"topbase slogan afont\" style=\"height:200px\"><br /><br />...The Message was sent ההודעה נשלחה...<br /><br />Thanks תודה<br /><br /><br /></fieldset>";
		else
			echo "<fieldset class=\"high\"><strong>$result</strong></fieldset>";
	
	}
	

}

else {?>

<form method="post">


<div class="inv_plain_3_minus" style="clear:both;padding:1em;float:<?echo get_s_align();?>;width:90%;height:300px">
	<strong>Your message כאן כתוב את הודעתך</strong><br/>
	<textarea name="message" cols="80" rows="6" <?if (isHeb()) echo " dir=\"rtl\"";?>  value="<? echo $message; ?>" style="font-size: 1.2em;width:800px"><? echo $message; ?></textarea>
         title<input id="title" name="title" size="18"  value="" style="width:800px;"  /><br />
	picture url<input id="picture_url" name="picture_url" size="40"  value="" style="width:800px;text-align:left"  /><br />
	external url<input id="embedded_url" name="embedded_url" size="40"  value="" style="width:800px;text-align:left"  /><br />
</div>


<div class="inv_plain_3" style="clear:both;text-align:center;padding:1em">
	<input type="submit" name="SendButton" value="Go"/>
	<?=get_arrow()?><?=get_arrow()?>
</div>


</form>
<? } ?>