function showImage(name){
  var graphWidthMin = 320;
  var pixesLeft = get_Width()/2 - (graphWidth/2);
  var pixesTop = 152;
  var graphHeightMin = 200;
  var graphHeight;
  var graphWidth;
	var imageSrc;
	var SourceIsHigher = false;
	try
	{
		if (name == "WindDirectionHistory")
			imageSrc = imgWind.src;
		else if (name == "WindSpeedHistory")
			imageSrc = imgWindSp.src;
		else if (name == "OutsideHumidityHistory")
			imageSrc = imgHum.src;
		else if (name == "OutsideTempHistory")
			imageSrc = imgTemp.src;
		else if (name == "BarometerHistory")
			imageSrc = imgBar.src;
		else if (name == "RainHistory")
			imageSrc = imgRain.src;
		else if (name == "meteosat-latest.gif")
			imageSrc = imgSat.src;
		else if (name == "radar")
			imageSrc = imgRadar.src;
		else{ 
			SourceIsHigher = true;
			imageSrc = 'images/' + name;
		}

		pixesTop = getRealTop(document.getElementById('main_table'));
		if (document.getElementById('baseGraph')){
			pixesTop = getRealTop(document.getElementById('baseGraph'));
			pixesLeft = getRealLeft(document.getElementById('baseGraph'));
			graphWidth = getRealWidth(document.getElementById('baseGraph'));
			graphHeight = getRealHeight(document.getElementById('baseGraph'));
			if (graphWidth < graphWidthMin)
			{
				graphWidth = graphWidthMin;
				pixesLeft = pixesLeft - 100;
			}
			if (graphHeight < graphHeightMin)
			{
				graphHeight = graphHeightMin;
			}
		}
		if (document.getElementById('baseGraph'))
		{
			document.images['currImage'].src = imageSrc;
			document.images['currImage'].style.width = graphWidth + 'px';
			document.images['currImage'].style.height = graphHeight + 'px';
			document.getElementById('spanImage').style.left = pixesLeft + 'px';
			document.getElementById('spanImage').style.top = pixesTop + 'px';
			document.getElementById('spanImage').style.visibility = 'visible';
		}			
		
	}
	catch (e)
	{//alert('showImage: ' + e);
	}
	
}

function hideImage(){
	if (window.currImage)	
		window.spanImage.style.visibility = "hidden";
	else if (document.currImage){
		document.getElementById('spanImage').style.visibility = "hidden";
	}
		
}

function tpopup(s){
  newwin = window.open(s, "Graph", "scrollbars=no,status=no,toolbar=no,directories=no,menubar=no,location=no,resizable=yes,width=350,height=230,top=300,left=500");
	newwin.focus();
}
function tpopupclose(){
	newwin.close();
}
function get_Width(){
	var myWidth = 0;
	  if( typeof( window.innerWidth ) == 'number' ) 
    		//Non-IE
    		myWidth = window.innerWidth;
  	else if( document.documentElement &&
			( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) 
  		  //IE 6+ in 'standards compliant mode'
  		  myWidth = document.documentElement.clientWidth;
		else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) 
  			//IE 4 compatible
  			myWidth = document.body.clientWidth;
		return myWidth;
}
function get_Height(){
		var myHeight = 0;
		if( typeof( window.innerWidth ) == 'number' ) 
						//Non-IE
						myHeight = window.innerHeight;
		else if( document.documentElement &&
			( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) 
		  		 //IE 6+ in 'standards compliant mode'
					 myHeight = document.documentElement.clientHeight;
		else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) 
				 	 //IE 4 compatible
					 myHeight = document.body.clientHeight;		
					 
		return myHeight;	
}
function getRealTop(imgElem) {
	try
	{
		yPos = eval(imgElem).offsetTop;
		tempEl = eval(imgElem).offsetParent;
		while (tempEl != null) {
			yPos += tempEl.offsetTop;
			tempEl = tempEl.offsetParent;
		}
		// for NS4 yPos = eval(imgID).y
		return yPos;
	}
	catch (e)
	{return null;}
}
function getRealLeft(imgElem) {
	try
	{
		xPos = eval(imgElem).offsetLeft;
		tempEl = eval(imgElem).offsetParent;
		while (tempEl != null) {
			xPos += tempEl.offsetLeft;
			tempEl = tempEl.offsetParent;
		}
		// for NS4 xPos = eval(imgID).x
		return xPos;
	}
	catch (e)
	{return null;}
}
function getRealWidth(imgElem) {
	try
	{
		xPos = eval(imgElem).offsetWidth;
		tempEl = eval(imgElem).offsetParent;
		
		// for NS4 xPos = eval(imgID).x
		return xPos;
	}
	catch (e)
	{return null;}
}
function getRealHeight(imgElem) {
	try
	{
		xPos = eval(imgElem).offsetHeight;
		tempEl = eval(imgElem).offsetParent;
		
		// for NS4 xPos = eval(imgID).x
		return xPos;
	}
	catch (e)
	{return null;}
}

function show(object, left, top, offsetleft, offsettop) {
	try
	{
		if (offsetleft==null)
			offsetleft=0;
		if (offsettop==null)
		   offsettop=0;
		
		if (document.getElementById(left))//mozilla
			 document.getElementById(object).style.left = getRealLeft(document.getElementById(left)) + offsetleft + 'px';
		else // IE
			document.getElementById(object).style.left = getRealLeft(left) + offsetleft + 'px'; 
		if (document.getElementById(top))//mozilla
			 document.getElementById(object).style.top = getRealTop(document.getElementById(top)) + offsettop + 'px';
		else // IE
			document.getElementById(object).style.top = getRealTop(top) + offsettop + 'px';
	  if (document.getElementById && document.getElementById(object) != null)
         node = document.getElementById(object).style.visibility='visible';
		else if (document.layers && document.layers[object] != null)
        document.layers[object].visibility = 'visible';
    //else if (document.all) //get error on page
    //    document.all[object].style.visibility = 'visible';
		if (document.getElementById(object).style.display=='none')
		{
			document.getElementById(object).style.display='';
		}
		
	}
	catch (e)
	{// alert('show: ' + e);
	}
}

function hide(object) {
    if (document.getElementById && document.getElementById(object) != null)
         node = document.getElementById(object).style.visibility='hidden';
    else if (document.layers && document.layers[object] != null)
        document.layers[object].visibility = 'hidden';
//    else if (document.all) //get error on page
//        document.all[object].style.visibility = 'hidden';
}

function toggle(id)
{

	if (document.getElementById(id))
	{
		if (document.getElementById(id).style.display=='none')
		{
			document.getElementById(id).style.display='';
		}
		else
			document.getElementById(id).style.display='none';
	}
}

function IncludeJavaScript(jsFile)
{
  document.write('<script type="text/javascript" src="'
    + jsFile + '"></script>'); 
}

function trMouseOver()
{ 
	var c, i =0;
	var tab= document.getElementById('mouseover');
	if (tab != null)
	{
		var tds = tab.getElementsByTagName('tr');
	    if (tds == null)
	    {
			tds = tab.getElementsByTagName('TR');
	    }
		while (c = tds.item(i++))
		{ 
			c.onmouseover = function() {this.setAttribute('fbg', this.className);this.className='base';}
			c.onmouseout = function() {this.className = this.getAttribute('fbg');}
		}
	}
	//alert(i);
	//for single row
	/*var tabtr = document.getElementById('mouseover');
	if (tabtr != null)
	{
		tabtr.onmouseover = function() {this.style.background='#466C86';}
		tabtr.onmouseout = function() {this.style.background='transparent';}
	}*/
	
	
}

function toggle_zebra(elm, class1)
{
	if (elm != null)
	{
		elm.onmouseover = function() {this.setAttribute('fbg', this.className);this.className=class1;}
		elm.onmouseout = function() {this.className = this.getAttribute('fbg');}
	}
}

function dd_goto(targetstr)
{
   top.location.href = targetstr;
 
}

function rememberStyle( cookieName, cookieLife ) {
	for( var viewUsed = false, ss = getAllSheets(), x = 0; window.MWJss && ss[x]; x++ ) { if( ss[x].disabled != MWJss[x] ) { viewUsed = true; break; } }
	if( !window.userHasChosen && !viewUsed ) { return; }
	for( var x = 0, outLine = '', doneYet = []; ss[x]; x++ ) {
		if( ss[x].title && ss[x].disabled == false && !doneYet[ss[x].title] ) { doneYet[ss[x].title] = true; outLine += ( outLine ? ' MWJ ' : '' ) + escape( ss[x].title ); } }
	if( ss.length ) { document.cookie = escape( cookieName ) + '=' + escape( outLine ) + ( cookieLife ? ';expires=' + new Date( ( new Date() ).getTime() + ( cookieLife * 86400000 ) ).toGMTString() : '' ) + ';path=/'; }
}

function useStyleAgain( cookieName ) {
	for( var x = 0; x < document.cookie.split( "; " ).length; x++ ) {
		var oneCookie = document.cookie.split( "; " )[x].split( "=" );
		if( oneCookie[0] == escape( cookieName ) ) {
			var styleStrings = unescape( oneCookie[1] ).split( " MWJ " );
			for( var y = 0, funcStr = ''; styleStrings[y]; y++ ) { funcStr += ( y ? ',' : '' ) + 'unescape( styleStrings[' + y + '] )'; }
			eval( 'changeStyle(' + funcStr + ');' ); break;
	} } window.MWJss = []; for( var ss = getAllSheets(), x = 0; ss[x]; x++ ) { MWJss[x] = ss[x].disabled; }
}

function getAllSheets() {
  if( !window.ScriptEngine && navigator.__ice_version ) { return document.styleSheets; }
  if( document.getElementsByTagName ) { var Lt = document.getElementsByTagName('link'), St = document.getElementsByTagName('style');
  } else if( document.styleSheets && document.all ) { var Lt = document.all.tags('LINK'), St = document.all.tags('STYLE');
  } else { return []; } for( var x = 0, os = []; Lt[x]; x++ ) {
    var rel = Lt[x].rel ? Lt[x].rel : Lt[x].getAttribute ? Lt[x].getAttribute('rel') : '';
    if( typeof( rel ) == 'string' && rel.toLowerCase().indexOf('style') + 1 ) { os[os.length] = Lt[x]; }
  } for( var x = 0; St[x]; x++ ) { os[os.length] = St[x]; } return os;
}

function changeStyle() {
  for( var x = 0, ss = getAllSheets(); ss[x]; x++ ) {
    if( ss[x].title ) { ss[x].disabled = true; }
    for( var y = 0; y < arguments.length; y++ ) {
     if( ss[x].title == arguments[y] ) { ss[x].disabled = false; }
} }
	rememberStyle( 'JWSstyle' , 20 );
}

function getChatNameAgain( cookieName ) {
	for( var x = 0; x < document.cookie.split( "; " ).length; x++ ) {
		var oneCookie = document.cookie.split( "; " )[x].split( "=" );
		if( oneCookie[0] == escape( cookieName ) ) {
			
			return unescape(oneCookie[1]);
		}
	}
	return '';
}

function rememberChatName( cookieName, cookieValue ) {
	
	var cookieLife = 20;
	document.cookie = escape( cookieName ) + '=' + escape(cookieValue) + ( cookieLife ? ';expires=' + new Date( ( new Date() ).getTime() + ( cookieLife * 86400000 ) ).toGMTString() : '' ) + ';path=/';
}

function toggleHeaderData ()
{
	toggle('latesthumidity');
	toggle('latestpressure');
	toggle('latestwind');
	toggle('latestrain');
	toggle('brokenlatesthumidity');
	toggle('brokenlatestpressure');
	toggle('brokenlatestwind');
	toggle('brokenlatestrainrate');
	toggle('radarTab');
	toggle('satelliteLink');
	toggle('headerdatatoggler');
	toggle('windstatus');
	toggle('itfeels');
	
	if (document.getElementById('paramstable').className == '')
	{
		document.getElementById('paramstable').className = 'grad';
		document.getElementById('paramsdiv').style.width = "100%";
		if (document.getElementById('trends').style.display == '')
		{
			toggle('trends');
		}
	}
	else
	{
		document.getElementById('tempdiv').className = 'grad';
		document.getElementById('paramstable').className = '';
		//document.getElementById('latesttemp').style.fontsize = '100%';
		document.getElementById('paramsdiv').style.width = "86%";
		/*document.getElementById('tempdiv').style.width = '220px';
		document.getElementById('latesthumidity').style.width = '115px';
		document.getElementById('latestpressure').style.width = '140px';
		document.getElementById('latestwind').style.width = '180px';
		document.getElementById('latestrain').style.width = '120px';*/
		
	}
}

function changeBGHeader()
{
	opac = 0;
	var verticalPosition = Math.round(100*Math.random());
	var header = document.getElementById('header_bg');
	var inURL = headerImages[currentHeaderIdx];
	header.style.backgroundImage = "url(" + inURL + ")";
	header.style.backgroundPosition = "0% " + verticalPosition + "%";
	//var Timer = setInterval("FadeIn()", 1);
	currentHeaderIdx++;
	if (currentHeaderIdx == numberOfHeaders)
		currentHeaderIdx = 0;
	fadeIn();
	setTimeout("changeBGHeader()", 10000);
}
function fadeOut() {
    if(opac > 0){
        opac-=10;
        if(ie5) document.getElementById('header_bg').style.filter = "Alpha(Opacity=" + opac + ")";
		else
         document.getElementById('header_bg').style.MozOpacity = opac/100;
        setTimeout('fadeOut()', 1);
    }
}
function fadeIn() {
    if(opac <= 50){
        opac+=10;
        if(ie5) document.getElementById('header_bg').style.filter = "Alpha(Opacity=" + opac + ")";
        else document.getElementById('header_bg').style.MozOpacity = opac/100;
        setTimeout('fadeIn()', 1);
    }
}

function toggleBrokenData (ahref)
{
	var tdOfTitle = ahref.parentNode;
	var trOfTitle = tdOfTitle.parentNode;
	var nextTR = trOfTitle.nextSibling;
	while(nextTR)
	{
		if (nextTR.style.display == "none")
			nextTR.style.display = "";
		else
			nextTR.style.display = "none";
		nextTR = nextTR.nextSibling;
	}
}



function cssJsMenu(nav) {
    /* currentStyle restricts the Javascript to IE only */
	if (document.all && document.getElementById(nav).currentStyle) {  
        var navroot = document.getElementById(nav);
        
        /* Get all the list items within the menu */
        var lis=navroot.getElementsByTagName("LI");  
        for (i=0; i<lis.length; i++) {
        
           /* If the LI has another menu level */
            if(lis[i].lastChild.tagName=="UL"){
            
                /* assign the function to the LI */
             	lis[i].onmouseover=function() {	
                
                   /* display the inner menu */
                   this.lastChild.style.display="block";
                }
                lis[i].onmouseout=function() {                       
                   this.lastChild.style.display="none";
                }
            }
        }
    }
  }
//
//
// moon rise set
//
//

function find_moonrise_set(mjd, tz, glong, glat) {
//
//	Im using a separate function for moonrise/set to allow for different tabulations
//  of moonrise and sun events ie weekly for sun and daily for moon. The logic of
//  the function is identical to find_sun_and_twi_events_for_date()
//
	var sglong, sglat, date, ym, yz, above, utrise, utset, j;
	var yp, nz, rise, sett, hour, z1, z2, iobj, rads = 0.0174532925;
	var quadout = new Array;
	var sinho;
	var   always_up = " ****";
	var always_down = " ....";
	var outstring = "";

	sinho = Math.sin(rads * 8/60);		//moonrise taken as centre of moon at +8 arcmin
	sglat = Math.sin(rads * glat);
	cglat = Math.cos(rads * glat);
	date = mjd - tz/24;
		rise = false;
		sett = false;
		above = false;
		hour = 1.0;
		ym = sin_alt(1, date, hour - 1.0, glong, cglat, sglat) - sinho;
		if (ym > 0.0) above = true;
		while(hour < 25 && (sett == false || rise == false)) {
			yz = sin_alt(1, date, hour, glong, cglat, sglat) - sinho;
			yp = sin_alt(1, date, hour + 1.0, glong, cglat, sglat) - sinho;
			quadout = quad(ym, yz, yp);
			nz = quadout[0];
			z1 = quadout[1];
			z2 = quadout[2];
			xe = quadout[3];
			ye = quadout[4];

			// case when one event is found in the interval
			if (nz == 1) {
				if (ym < 0.0) {
					utrise = hour + z1;
					rise = true;
					}
				else {
					utset = hour + z1;
					sett = true;
					}
				} // end of nz = 1 case

			// case where two events are found in this interval
			// (rare but whole reason we are not using simple iteration)
			if (nz == 2) {
				if (ye < 0.0) {
					utrise = hour + z2;
					utset = hour + z1;
					}
				else {
					utrise = hour + z1;
					utset = hour + z2;
					}
				}

			// set up the next search interval
			ym = yp;
			hour += 2.0;

			} // end of while loop

			if (rise == true || sett == true ) {
				if (rise == true) outstring += " " + hrsmin(utrise);
				else outstring += " ----";
				if (sett == true) outstring += "<br>" + hrsmin(utset);
				else outstring += " ----";
				}
			else {
				if (above == true) outstring += always_up + always_up;
				else outstring += always_down + always_down;
				}

		return outstring;
}

function hrsmin(hours) {
//
//	takes decimal hours and returns a string in hhmm format
//
	var hrs, h, m, dum;
	hrs = Math.floor(hours * 60 + 0.5)/ 60.0;
	h = Math.floor(hrs);
	m = Math.floor(60 * (hrs - h) + 0.5);
	dum = h*100 + m;
	//
	// the jiggery pokery below is to make sure that two minutes past midnight
	// comes out as 0002 not 2. Javascript does not appear to have 'format codes'
	// like C
	//
	if (dum < 1000) dum = "0" + dum;
	if (dum <100) dum = "0" + dum;
	if (dum < 10) dum = "0" + dum;
	return dum;
}

function sin_alt(iobj, mjd0, hour, glong, cglat, sglat) {
//
//	this rather mickey mouse function takes a lot of
//  arguments and then returns the sine of the altitude of
//  the object labelled by iobj. iobj = 1 is moon, iobj = 2 is sun
//
	var mjd, t, ra, dec, tau, salt, rads = 0.0174532925;
	var objpos = new Array;
	mjd = mjd0 + hour/24.0;
	t = (mjd - 51544.5) / 36525.0;
	if (iobj == 1) {
		objpos = minimoon(t);
				}
	ra = objpos[2];
	dec = objpos[1];
	// hour angle of object
	tau = 15.0 * (lmst(mjd, glong) - ra);
	// sin(alt) of object using the conversion formulas
	salt = sglat * Math.sin(rads*dec) + cglat * Math.cos(rads*dec) * Math.cos(rads*tau);
	return salt;
}

function mjd(day, month, year, hour) {
//
//	Takes the day, month, year and hours in the day and returns the
//  modified julian day number defined as mjd = jd - 2400000.5
//  checked OK for Greg era dates - 26th Dec 02
//
	var a, b;
	if (month <= 2) {
		month = month + 12;
		year = year - 1;
		}
	a = 10000.0 * year + 100.0 * month + day;
	if (a <= 15821004.1) {
		b = -2 * Math.floor((year + 4716)/4) - 1179;
		}
	else {
		b = Math.floor(year/400) - Math.floor(year/100) + Math.floor(year/4);
		}
	a = 365.0 * year - 679004.0;
	return (a + b + Math.floor(30.6001 * (month + 1)) + day + hour/24.0);
}

function lmst(mjd, glong) {
//
//	Takes the mjd and the longitude (west negative) and then returns
//  the local sidereal time in hours. Im using Meeus formula 11.4
//  instead of messing about with UTo and so on
//
	var lst, t, d;
	d = mjd - 51544.5
	t = d / 36525.0;
	lst = range(280.46061837 + 360.98564736629 * d + 0.000387933 *t*t - t*t*t / 38710000);
	return (lst/15.0 + glong/15);
}

function minimoon(t) {
//
// takes t and returns the geocentric ra and dec in an array mooneq
// claimed good to 5' (angle) in ra and 1' in dec
// tallies with another approximate method and with ICE for a couple of dates
//
	var p2 = 6.283185307, arc = 206264.8062, coseps = 0.91748, sineps = 0.39778;
	var L0, L, LS, F, D, H, S, N, DL, CB, L_moon, B_moon, V, W, X, Y, Z, RHO;
	var mooneq = new Array;

	L0 = frac(0.606433 + 1336.855225 * t);	// mean longitude of moon
	L = p2 * frac(0.374897 + 1325.552410 * t) //mean anomaly of Moon
	LS = p2 * frac(0.993133 + 99.997361 * t); //mean anomaly of Sun
	D = p2 * frac(0.827361 + 1236.853086 * t); //difference in longitude of moon and sun
	F = p2 * frac(0.259086 + 1342.227825 * t); //mean argument of latitude

	// corrections to mean longitude in arcsec
	DL =  22640 * Math.sin(L)
	DL += -4586 * Math.sin(L - 2*D);
	DL += +2370 * Math.sin(2*D);
	DL +=  +769 * Math.sin(2*L);
	DL +=  -668 * Math.sin(LS);
	DL +=  -412 * Math.sin(2*F);
	DL +=  -212 * Math.sin(2*L - 2*D);
	DL +=  -206 * Math.sin(L + LS - 2*D);
	DL +=  +192 * Math.sin(L + 2*D);
	DL +=  -165 * Math.sin(LS - 2*D);
	DL +=  -125 * Math.sin(D);
	DL +=  -110 * Math.sin(L + LS);
	DL +=  +148 * Math.sin(L - LS);
	DL +=   -55 * Math.sin(2*F - 2*D);

	// simplified form of the latitude terms
	S = F + (DL + 412 * Math.sin(2*F) + 541* Math.sin(LS)) / arc;
	H = F - 2*D;
	N =   -526 * Math.sin(H);
	N +=   +44 * Math.sin(L + H);
	N +=   -31 * Math.sin(-L + H);
	N +=   -23 * Math.sin(LS + H);
	N +=   +11 * Math.sin(-LS + H);
	N +=   -25 * Math.sin(-2*L + F);
	N +=   +21 * Math.sin(-L + F);

	// ecliptic long and lat of Moon in rads
	L_moon = p2 * frac(L0 + DL / 1296000);
	B_moon = (18520.0 * Math.sin(S) + N) /arc;

	// equatorial coord conversion - note fixed obliquity
	CB = Math.cos(B_moon);
	X = CB * Math.cos(L_moon);
	V = CB * Math.sin(L_moon);
	W = Math.sin(B_moon);
	Y = coseps * V - sineps * W;
	Z = sineps * V + coseps * W
	RHO = Math.sqrt(1.0 - Z*Z);
	dec = (360.0 / p2) * Math.atan(Z / RHO);
	ra = (48.0 / p2) * Math.atan(Y / (X + RHO));
	if (ra <0 ) ra += 24;
	mooneq[1] = dec;
	mooneq[2] = ra;
	return mooneq;
}

function range(x) {
//
//	returns an angle in degrees in the range 0 to 360
//
	var a, b;
	b = x / 360;
	a = 360 * (b - ipart(b));
	if (a  < 0 ) {
		a = a + 360
		}
	return a
}

function ipart(x) {
//
//	returns the integer part - like int() in basic
//
	var a;
	if (x> 0) {
	    a = Math.floor(x);
		}
	else {
		a = Math.ceil(x);
		}
	return a;
}

function frac(x) {
//
//	returns the fractional part of x as used in minimoon and minisun
//
	var a;
	a = x - Math.floor(x);
	if (a < 0) a += 1;
	return a;
}

function quad(ym, yz, yp) {
//
//	finds the parabola throuh the three points (-1,ym), (0,yz), (1, yp)
//  and returns the coordinates of the max/min (if any) xe, ye
//  the values of x where the parabola crosses zero (roots of the quadratic)
//  and the number of roots (0, 1 or 2) within the interval [-1, 1]
//
//	well, this routine is producing sensible answers
//
//  results passed as array [nz, z1, z2, xe, ye]
//
	var nz, a, b, c, dis, dx, xe, ye, z1, z2, nz;
	var quadout = new Array;

	nz = 0;
	a = 0.5 * (ym + yp) - yz;
	b = 0.5 * (yp - ym);
	c = yz;
	xe = -b / (2 * a);
	ye = (a * xe + b) * xe + c;
	dis = b * b - 4.0 * a * c;
	if (dis > 0)	{
		dx = 0.5 * Math.sqrt(dis) / Math.abs(a);
		z1 = xe - dx;
		z2 = xe + dx;
		if (Math.abs(z1) <= 1.0) nz += 1;
		if (Math.abs(z2) <= 1.0) nz += 1;
		if (z1 < -1.0) z1 = z2;
		}
	quadout[0] = nz;
	quadout[1] = z1;
	quadout[2] = z2;
	quadout[3] = xe;
	quadout[4] = ye;
	return quadout;
}

function getBody(content)
	{
		 test = content.toLowerCase(); // to eliminate case sensitivity
		 var x = test.indexOf("<body");
		 if(x == -1) return "";

		 x = test.indexOf(">", x);
		 if(x == -1) return "";

		 var y = test.lastIndexOf("</body>");
		 if(y == -1) y = test.lastIndexOf("</html>");
		 if(y == -1) y = content.length; // If no HTML then just grab everything till end

		 return content.slice(x + 1, y);
	}

function changeUrlLang(lang, loc)
{
	loc = loc.replace(/lang=\d/g, "lang=" + lang);
	if (loc.indexOf('?') == -1)
	{
		loc = loc + "?";
	}
	if (loc.indexOf('lang') == -1)
	{
		loc = loc + "&lang=" + lang;
	}
	top.location.href=loc;
}
//
//
//
//
//
 
activateMenu = function(nav) {

    /* currentStyle restricts the Javascript to IE only */
	if (document.all) {
		if (document.getElementById(nav))
		{
			if (document.getElementById(nav).currentStyle)
			{
				var navroot = document.getElementById(nav);
        
				/* Get all the list items within the menu */
				var lis=navroot.getElementsByTagName("LI");  
				for (i=0; i<lis.length; i++) {
				
				   /* If the LI has another menu level */
					if(lis[i].lastChild.tagName=="UL"){
					
						/* assign the function to the LI */
						lis[i].onmouseover=function() {	
						
						   /* display the inner menu */
						   this.lastChild.style.display="block";
						}
						lis[i].onmouseout=function() {                       
						   this.lastChild.style.display="none";
						}
					}
				}
			}
		}
        
    }
}

/*********************

	startup functions

*********************/

window.onload= function(){
    /* pass the function the id of the top level UL */
    /* remove one, when only using one menu */
    activateMenu('nav');
}

useStyleAgain( 'JWSstyle');
