function fillMessage(str)
{
	var emailDetails = document.getElementById('EmailDelivering');
	 if (emailDetails.firstChild) {
	   emailDetails.removeChild(emailDetails.firstChild);
	 }
	 newDiv = document.createElement("div");
	 newDiv.innerHTML = "<fieldset class=\"inv\"><b>" + str + "</b></fieldset>";
	 emailDetails.appendChild(newDiv); 
}
function startEmailService(message_from, message_subject, message_body, target , info_back, message_action)
{	
	var postData = "message_body=" + message_body + "&message_subject=" + message_subject + "&message_from=" + message_from + "&target=" + target + "&message_action=" + message_action + "&info_back=" + info_back;
	fillMessage('<img src="images/loading.gif" alt="loading" />');
	var ajax = new Ajax();
	ajax.method = 'POST';
	ajax.setMimeType('text/html');
	ajax.postData = postData;
	ajax.setHandlerBoth(fillMessage);
	ajax.url = 'mail_service.php';
	ajax.doReq();
	
}