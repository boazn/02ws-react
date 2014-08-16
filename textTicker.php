<? include_once ("include.php"); ?>
<script language="javascript">
var arrNewsItems = new Array();
arrNewsItems.push(new Array("test1", "<? echo get_query_edited_url(get_url(), 'section', 'Taf');?>"));
arrNewsItems.push(new Array("test2", "<? echo get_query_edited_url(get_url(), 'section', 'forecast.php');?>"));
var intTickSpeed = 5000;
var intTickPos = 0;
var tickLocked = false;
var fadeTimerID;
var autoTimerID = 0;
var intTypeSpeed = 16;
var intCurrentPos = 0;
var currentText = '';
var currentLink = '';
var strText = '';
var isFirstPass = true;
getLinkElems();
playFirstTicker();
//function prevArticle() {
//	if (tickLocked == false) {
//	if (intTickPos == 0) {
//		intTickPos = arrNewsItems.length-1;
//	} else {
//		intTickPos--;
//	}
//	setArticle(intTickPos);
// }
//}
function nextArticle() {
 if (tickLocked == false) {
	if (intTickPos == arrNewsItems.length-1) {
		intTickPos = 0;
	} else {
		intTickPos++;
	}
 setArticle(intTickPos);
 }
}
function typeText() {
	if(intCurrentPos < currentText.length) {
	 strText += currentText.charAt(intCurrentPos);
	 setSpan(strText,currentLink);
	 intCurrentPos++;
 } else if (intCurrentPos == currentText.length) {
	 strText += currentText.charAt(intCurrentPos);
	 setSpan(strText,currentLink);
	 clearInterval(typeInterval);
 } else if (intCurrentPos > currentText.length){
	 setSpan(strText,currentLink);
	 clearInterval(typeInterval);
 }
}
function setSpan(strText, strLink) {
 var tickElem = document.getElementById("tick");
 var tickFirstChild = tickElem.firstChild;
 var tickLinkElem = document.createElement("a");
 tickLinkElem.setAttribute('href', strLink);
 tickLinkElem.setAttribute('target', '_top');
 //tickLinkElem.setAttribute('id', 'tickContentLink');
 tickText = document.createTextNode(strText);
 tickLinkElem.appendChild(tickText);
 tickElem.replaceChild(tickLinkElem,tickFirstChild);
 getLinkElems();
}
function setArticle(intPos) {
 if(arrNewsItems[intPos]!=null) {
 tickLocked = true;
 intCurrentPos = 0;
 strText = '';
 setSpan('', '#');
 
 currentText = arrNewsItems[intPos][0];
 currentLink = arrNewsItems[intPos][1];
 typeInterval = setInterval( "typeText()", intTypeSpeed);
 tickLocked = false;
 }
}
function playTicker() {
 isInFirstTimeout = false;
 if (autoTimerID != 0) {
 clearInterval(typeInterval);
 nextArticle();
 }
 autoTimerID = self.setTimeout("playTicker()", intTickSpeed);
}
function playFirstTicker() {
 if(isFirstPass == true) {
  setSpan(arrNewsItems[0][0],arrNewsItems[0][1]);
 isFirstPass = false;
 typeInterval = setInterval('',0);
 isInFirstTimeout = true;
 autoTimerID = self.setTimeout("playFirstTicker()", intTickSpeed);
 }
 else if(isFirstPass == false) {
 clearTimeout(autoTimerID);
 isInFirstTimeout = false;
 setArticle(intTickPos);
 playTicker();
 }
}
function stopTicker() {
 clearTimeout(autoTimerID);
}
function resumeTicker() {
 clearTimeout(autoTimerID);
 autoTimerID = self.setTimeout("playTicker()", intTickSpeed);
}
function delayTicker() {
 clearTimeout(autoTimerID);
 clearInterval(typeInterval);
 autoTimerID = self.setTimeout("playTicker()", intTickSpeed * 2);
}
function getLinkElems() {
 var tickerElem = document.getElementById("tick");
 var tickerAElem = tickerElem.getElementsByTagName("a");
 for (var i=0; i < tickerAElem.length; i++) {
 tickerAElem[i].onmouseover = stopTicker;
 tickerAElem[i].onmouseout = resumeTicker;
 }
}
</script>