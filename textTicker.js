var isTickerON = false;
var intTickPos = 0;
var tickLocked = false;
var fadeTimerID;
var autoTimerID = 0;
var intTypeSpeed = 20;
var intCurrentPos = 0;
var currentText = '';
var currentLink = '';
var currentTitle = '';
var strText = '';
var isFirstPass = true;
var tickStepping = 6;
getLinkElems();
playFirstTicker();
function prevArticle() {
	if (tickLocked == false) {
	if (intTickPos == 0) {
		intTickPos = arrNewsItems.length-1;
	} else {
		intTickPos--;
	}
	setArticle(intTickPos);
 }
}
function nextArticle(){
 if (tickLocked == false) {
	if (intTickPos == arrNewsItems.length-1) {
		intTickPos = 0;
	} else {
		intTickPos++;
	}
 setArticle(intTickPos);
 }
}

function setSpan(strText, strLink, strTitle) {
 var tickElem = document.getElementById("tick");
 var tickLinkElem = tickElem.getElementsByTagName("a").item(0); // a 
  tickText = document.createElement('text');
 tickText.innerHTML = strText ;
 tickLinkElem.href = strLink;
 tickLinkElem.title= strTitle;
 tickLinkElem.replaceChild(tickText, tickLinkElem.firstChild);
 getLinkElems();
}
function setArticle(intPos) {
 if(arrNewsItems[intPos]!=null) {
 tickLocked = true;
 if (isTickerON)
	{
		intCurrentPos = 0; //0 to regular mode
		strText = ''; //'' to regular mode
	}
   else
   {
	 intCurrentPos = 0 ; //0 to regular mode //arrNewsItems[intPos][0].length for off
	 strText = ''; //'' to regular mode //arrNewsItems[intPos][0] for off
    }
 setSpan('', '#', '');
 
 currentText = arrNewsItems[intPos][0];
 currentLink = arrNewsItems[intPos][1];
 currentTitle = arrNewsItems[intPos][2];
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
  setSpan(arrNewsItems[0][0],arrNewsItems[0][1], arrNewsItems[0][2]);
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
function typeText(){
	if (intCurrentPos <= currentText.length - 1) {
		 strText += currentText.substring(intCurrentPos - tickStepping, intCurrentPos);
		 setSpan(strText,currentLink, currentTitle);
		 intCurrentPos = intCurrentPos + tickStepping;
	 //} else if (intCurrentPos == currentText.length - 1) {
	//	 strText += currentText.charAt(intCurrentPos);
	//	 setSpan(strText,currentLink, currentTitle);
	//	 clearInterval(typeInterval);
	 } else if (intCurrentPos > currentText.length - 1){
		 strText += currentText.substring((currentText.length - 1 )- (tickStepping - (intCurrentPos - (currentText.length - 1))));
		 setSpan(strText,currentLink, currentTitle);
		 clearInterval(typeInterval);
	 }
}
