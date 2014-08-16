<?
include_once("include.php");
include_once("lang.php");
ini_set("display_errors","On");
$messageToSend = urldecode($_POST['message_body']);
$subject = urldecode($_POST['message_subject']);
$from = urldecode($_POST['message_from']);
$action = urldecode($_POST['message_action']);
if (($action != "") && ($action != "undefined"))
{
	if (isActionAlreadyActivated($action))
	{
		exit;
	}
}
$result = "";
if ($_POST['target'] == "ALL")
	$result = send_Email($messageToSend, ALL, $from, $subject);
else if ($_POST['target'] == "SPECIAL")
	$result = send_Email($messageToSend, SPECIAL, $from, $subject);
else
	$result = send_Email($messageToSend, ME, $from, $subject);
//send_Email("Just for testing", ME, EMAIL_ADDRESS);
if (($_POST['info_back']) && ($result == ""))
	print "...The Message was sent ההודעה נשלחה...";
else if (!($_POST['info_back']))
	print $result;
?>