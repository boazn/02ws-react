<html>
<head></head>
<form method=POST><table border=0 cellspacing=0 cellpadding=3>
<table width=100%>
<tr class=tbl>
	<td><b>Name</b>
	<input name="name" size=30 maxlength=50 style="text-align:left" <?if (isset($_POST['name'])) echo("value=".$_POST['name']);?>></td>
	<td>&nbsp;</td>
	<td align=right><b>Email</b>
	<input name="email" size=30 maxlength=50 style="text-align:left" <?if (isset($_POST['email'])) echo("value=".$_POST['email']);?>>
	</td>
</tr>
<tr class=tbl >
	<td colspan="3">
	<b>Your message (in hebrew or english)</b><br>
	<textarea name="message" cols=80 rows=10 style="text-align:left" <?if (isset($_POST['message'])) echo("value=".$_POST['message']);?>></textarea>
	</td>
</tr>
<tr class=tbl>
	<td colspan=3 align=right>
	<input type="submit" name="SendButton" value="Send Message!">
	</td>
</tr>
</table>
</form>
	
<?

if (isset($_POST['SendButton'])) {
	if ($_POST['name']=="" || $_POST['message']=="") 
	{
		// wrong values
		echo("you have entered wrong values");
	}
	else{
		
		$insert_msgdate = date( "dS F Y - h:i:s" );
		$headers  = "MIME-Version: 1.0\r\n";		
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";		
		$headers .= "From: {$source}\r\n";		
		$headers .= "Reply-To: {$source}\r\n";
		$email = "dn@savion.cc.huji.ac.il";
		mail($email, "JWS test for Moshe from 012", "From: {$_POST['name']} ({$_POST['email']})\n$insert_msgdate\n\n{$_POST['message']}"  , $headers);
		echo("Mail was sent to...".$email);
	}
}
?>
</body>
</html>
