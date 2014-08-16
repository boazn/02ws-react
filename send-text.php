<?php
/*****************************************************************
 * Copyright (c) 1999-2002 Simplewire, Inc. All Rights Reserved.
 *
 * Simplewire grants you ("Licensee") a non-exclusive, royalty
 * free, license to use, modify and redistribute this software
 * in source and binary code form, provided that i) Licensee
 * does not utilize the software in a manner which is
 * disparaging to Simplewire.
 *
 * This software is provided "AS IS," without a warranty of any
 * kind. ALL EXPRESS OR IMPLIED CONDITIONS, REPRESENTATIONS AND
 * WARRANTIES, INCLUDING ANY IMPLIED WARRANTY OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE OR NON-INFRINGEMENT, ARE
 * HEREBY EXCLUDED. SIMPLEWIRE AND ITS LICENSORS SHALL NOT BE
 * LIABLE FOR ANY DAMAGES SUFFERED BY LICENSEE AS A RESULT OF
 * USING, MODIFYING OR DISTRIBUTING THE SOFTWARE OR ITS
 * DERIVATIVES. IN NO EVENT WILL SIMPLEWIRE OR ITS LICENSORS BE
 * LIABLE FOR ANY LOST REVENUE, PROFIT OR DATA, OR FOR DIRECT,
 * INDIRECT, SPECIAL, CONSEQUENTIAL, INCIDENTAL OR PUNITIVE
 * DAMAGES, HOWEVER CAUSED AND REGARDLESS OF THE THEORY OF
 * LIABILITY, ARISING OUT OF THE USE OF OR INABILITY TO USE
 * SOFTWARE, EVEN IF SIMPLEWIRE HAS BEEN ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGES.
 *****************************************************************/

/*****************************************************************
 * Shows how to send a text message in PHP.
 *
 * Please visit www.simplewire.com for sales and support.
 *
 * @author Simplewire, Inc.
 * @version 3.0.0
 *****************************************************************/
?>

<?php
	if ($SMSmessage=="")
		$SMSmessage="SMS test from JWS";
	//dl("D:\\php-4.3.4-Win32\\extensions\\php_swsms.dll");
	// Create
	$sms = swsms_create();

	// Subscriber Settings
	$sms->subscriberID = "295-441-631-80994";
	$sms->subscriberPassword = "416B9469";

	// Message Settings
	$sms->msgPin = "+972 54 4854456";
	$sms->msgPin = $number;
	$sms->msgFrom = "JWS";
	$sms->msgCallback = "+972 54 4854456";
	$sms->msgText = $SMSmessage;

	// Print Debug Information
	/*print("<b>User Agent:</b> " . $sms->userAgent . "<br>\n");
	print("<b>Subscriber ID:</b> " . $sms->subscriberID . "<br>\n");
	print("<b>Subscriber Password:</b> " . $sms->subscriberPassword . "<br><br>\n\n");
	print("<b>Sending message to the Simplewire Wireless Messaging Network...</b><br><br>\n\n");*/

	// Send Message
	swsms_msg_send(&$sms);

	// Check For Errors
	if ($sms->success)
	{
		//print("<b>Message was queued for delivery!</b><br>\n");
	}
	else
	{
		print("<b>Message was not queued for delivery!</b><br>\n");
		print("<b>Error Code:</b> $sms->errorCode<br>\n");
		print("<b>Error Description:</b> $sms->errorDesc<br>\n");
		print("<b>Error Resolution:</b> $sms->errorResolution<br>\n");
	}
?>
