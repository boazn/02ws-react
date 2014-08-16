IncludeJavaScript('jquery.elastic.js');
function Ajax(){this.req=null;this.url=null;this.method='GET';this.async=true;this.status=null;this.statusText='';this.postData=null;this.readyState=null;this.responseText=null;this.responseXML=null;this.handleResp=null;this.responseFormat='text',this.mimeType=null;this.setMimeType=function(mimeType){this.mimeType=mimeType;};this.setHandlerErr=function(funcRef){this.handleErr=funcRef;}
this.setHandlerBoth=function(funcRef){this.handleResp=funcRef;this.handleErr=funcRef;};this.init=function(){if(!this.req){try{this.req=new XMLHttpRequest();}
catch(e){try{this.req=new ActiveXObject('MSXML2.XMLHTTP');}
catch(e){try{this.req=new ActiveXObject('Microsoft.XMLHTTP');}
catch(e){return false;}}}}
return this.req;};this.doReq=function(){if(!this.init()){alert('Could not create XMLHttpRequest object.');return;}
this.req.open(this.method,this.url,this.async);if(this.mimeType){try{this.req.overrideMimeType(this.mimeType);}
catch(e){}}
var self=this;this.req.onreadystatechange=function(){var resp=null;if(self.req.readyState==4){switch(self.responseFormat){case'text':resp=self.req.responseText;break;case'xml':resp=self.req.responseXML;break;case'object':resp=req;break;}
if(self.req.status>=200&&self.req.status<=299){self.handleResp(resp);}
else{self.handleErr(resp);}}};this.req.setRequestHeader("Content-type","application/x-www-form-urlencoded");
this.req.send(this.postData);};this.handleErr=function(){var errorWin;try{errorWin=window.open('','errorWin');errorWin.document.body.innerHTML=this.responseText;}
catch(e){alert('An error occurred, but the error message cannot be '
+'displayed. This is probably because of your browser\'s '
+'pop-up blocker.\n'
+'Please allow pop-ups from this web site if you want to '
+'see the full error messages.\n'
+'\n'
+'Status Code: '+this.req.status+'\n'
+'Status Description: '+this.req.statusText);}};this.doGet=function(url,hand,format){this.url=url;this.handleResp=hand;this.responseFormat=format||'text';this.doReq();};}
function additalic(strSelected)
{var body=document.getElementById('new_post_ta');var locSelection=body.value.indexOf(strSelected);if(strSelected!='')
body.value=body.value.substr(0,locSelection)+'<em>'+strSelected+'</em>'+body.value.substr(locSelection+strSelected.length,body.value.length);else
body.value=body.value+'<em>'+'</em>';}
function addbold(strSelected)
{var body=document.getElementById('new_post_ta');var locSelection=body.value.indexOf(strSelected);if(strSelected!='')
body.value=body.value.substr(0,locSelection)+'<strong>'+strSelected+'</strong>'+body.value.substr(locSelection+strSelected.length,body.value.length);else
body.value=body.value+'<strong>'+'</strong>';}
function getSelectionStart(o){if(o.createTextRange){var r=document.selection.createRange().duplicate()
r.moveEnd('character',o.value.length)
if(r.text=='')return o.value.length
return o.value.lastIndexOf(r.text)}else return o.selectionStart}
function getSelectionEnd(o){if(o.createTextRange){var r=document.selection.createRange().duplicate()
r.moveStart('character',-o.value.length)
return r.text.length}else return o.selectionEnd}
function getSelText()
{var body=document.getElementById('new_post_ta');var t=body.value,s=getSelectionStart(body),e=getSelectionEnd(body);if(s==0&&e==0)
{var txt='';if(window.getSelection)
{txt=window.getSelection();}
else if(document.getSelection)
{txt=document.getSelection();}
else if(document.selection)
{txt=document.selection.createRange().text;}
return txt;}
else
return t.substring(s,e).replace(/ /g,'\xa0')||'\xa0';}
function empty(txtBox,startvalue)
{if(txtBox.value==startvalue)
txtBox.value='';}
function disableOthers(checkbox)
{var currentIdx=checkbox.value;var idxs=document.getElementsByTagName("input");for(var i=0;i<idxs.length;i++){if(idxs[i].type=="checkbox")
if(idxs[i].value!=currentIdx){if(checkbox.checked)
idxs[i].disabled=true;else
idxs[i].disabled=false;}}}
function check(checkbox)
{var check=document.getElementById(checkbox);if(!check.checked)
check.checked=true;else
check.checked=false;}
function toggleClass(innerDiv)
{if(innerDiv.className=="chatmainbody")
{innerDiv=$(innerDiv).next("div").next("div").get(0).firstChild;}

if(innerDiv.className=="base")
{innerDiv.className=innerDiv.getAttribute('oldClass');}
else
{innerDiv.setAttribute('oldClass',innerDiv.className);innerDiv.className="base";}
parentDiv=innerDiv.parentNode.parentNode;if(parentDiv.className=="base")
{parentDiv.className=parentDiv.getAttribute('oldClass');}
else
{parentDiv.setAttribute('oldClass',parentDiv.className);parentDiv.className="base";}}
function moveDivInOut(anchor)
{
toggleClass(anchor);
var name = document.getElementById('current_display_name').value;
var move_to_other_div = false;
if(anchor.className=="chatmainbody")
{anchor=$(anchor).parent().children('.pivotpointer').first().get(0);}
var currentdividxflag = document.getElementById('current_new_msg_idx');
var topDiv=document.getElementById('new_post');
var newDiv=document.createElement("div");
var prevDiv;
newDiv.id="replyInputsDiv";
newDiv.className = "white_box span9";
newDiv.innerHTML=topDiv.innerHTML;
$("#new_post_user").addClass($("#user_icon").attr('class'));
newDiv.style.visibility = "visible";
var parentDiv=anchor.parentNode;
prevDiv = parentDiv;
if (currentdividxflag.value != "")
{
	prevDiv = document.getElementById(currentdividxflag.value);
	if (parentDiv.id != currentdividxflag.value)
	{
			move_to_other_div = true;//remove from prevDiv;append to parentDiv
	}
	
}
var existingDiv=document.getElementById('replyInputsDiv');
if(existingDiv)
{prevDiv.removeChild(existingDiv);topDiv.innerHTML=existingDiv.innerHTML;currentdividxflag.value = ""; 
if (move_to_other_div)
{
newDiv.innerHTML=existingDiv.innerHTML;
topDiv.innerHTML='';
parentDiv.appendChild(newDiv);
currentdividxflag.value = parentDiv.id;
//document.getElementById('user_name').value = name;
toggleClass(prevDiv);
}}
else
{parentDiv.appendChild(newDiv);
topDiv.innerHTML='';
currentdividxflag.value = parentDiv.id;}
//document.getElementById('user_name').value = name;
$('textarea').elastic();$(".href").colorbox({width:"35%", inline:true, href:"#href_dialog"});$("a[rel='external']").colorbox({width:"85%", height:"90%", iframe:true});$(".mood").colorbox({width:"35%", inline:true, href:"#moods_dialog"});}
function restoreTopDiv()
{var topDiv=document.getElementById('new_post');var existingDiv=document.getElementById('replyInputsDiv');if(existingDiv)
{topDiv.innerHTML=existingDiv.innerHTML;
    toggleClass($(existingDiv).parent().children('.chatmainbody').get(0));
    toggle($(existingDiv).parent().children('.pivotpointer').get(0).id);
    toggle($(existingDiv).parent().children('.pivotpointer').children().get(1).id);
    $('#current_new_msg_idx').val('');
    existingDiv.parentNode.removeChild(existingDiv);}}
function fillMessage(str)
{var forecastDetails=document.getElementById('msgDetails');if(forecastDetails!=null)
{if(forecastDetails.firstChild){forecastDetails.removeChild(forecastDetails.firstChild);}}
newDiv=document.createElement("div");newDiv.innerHTML=str;if(forecastDetails!=null)
{forecastDetails.innerHTML=str;}$('input[name="SendButton"]').removeAttr("disabled");}

$(document).ready(function(){$(".colorbox").colorbox();
$("a[rel='external']").colorbox({width:"80%", height:"80%", iframe:true});$("a[title='legend']").colorbox({width:"85%"});
$(".href").colorbox({width:"35%", inline:true, href:"#href_dialog"});
$(".mood").colorbox({width:"35%", inline:true, href:"#moods_dialog"});
$(".user_icon").colorbox({width:"35%", inline:true, href:"#user_icon_dialog"});
$("#login").colorbox({width:"285px", height:"234px", inline:true, href:"#loginform"});
$(".register").colorbox({width:"320px", height:"420px", inline:true, href:"#registerform"});
$("#forgotpass").colorbox({width:"280px", inline:true, href:"#passforgotform"});
$("#updateprofile").colorbox({width:"300px", inline:true, href:"#profileform"});
$(".icon_forecast").colorbox({width:"35%", inline:true, href:"#icons_dialog"});
$(".temphigh").colorbox({width:"35%", inline:true, href:"#clothes_dialog"});
$(".tempnight").colorbox({width:"35%", inline:true, href:"#clothes_dialog"});
$('textarea').elastic();
});
var isMobile = {
    Android: function() {
        return ((navigator.userAgent.match(/Android/i))&&(navigator.userAgent.match(/mobile/i))) ? true : false;
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i) ? true : false;
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPod/i) ? true : false;
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i) ? true : false;
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Windows());
    }
};
function hideImage(){if(window.currImage)
window.spanImage.style.visibility="hidden";else if(document.currImage){document.getElementById('spanImage').style.visibility="hidden";}}
function tpopup(s){newwin=window.open(s,"Graph","scrollbars=no,status=no,toolbar=no,directories=no,menubar=no,location=no,resizable=yes,width=350,height=230,top=300,left=500");newwin.focus();}
function tpopupclose(){newwin.close();}
function get_Width(){var myWidth=0;if(typeof(window.innerWidth)=='number')
myWidth=window.innerWidth;else if(document.documentElement&&(document.documentElement.clientWidth||document.documentElement.clientHeight))
myWidth=document.documentElement.clientWidth;else if(document.body&&(document.body.clientWidth||document.body.clientHeight))
myWidth=document.body.clientWidth;return myWidth;}
function get_Height(){var myHeight=0;if(typeof(window.innerWidth)=='number')
myHeight=window.innerHeight;else if(document.documentElement&&(document.documentElement.clientWidth||document.documentElement.clientHeight))
myHeight=document.documentElement.clientHeight;else if(document.body&&(document.body.clientWidth||document.body.clientHeight))
myHeight=document.body.clientHeight;return myHeight;}
function getRealTop(imgElem){try
{yPos=eval(imgElem).offsetTop;tempEl=eval(imgElem).offsetParent;while(tempEl!=null){yPos+=tempEl.offsetTop;tempEl=tempEl.offsetParent;}
return yPos;}
catch(e)
{return null;}}
function getRealLeft(imgElem){try
{xPos=eval(imgElem).offsetLeft;tempEl=eval(imgElem).offsetParent;while(tempEl!=null){xPos+=tempEl.offsetLeft;tempEl=tempEl.offsetParent;}
return xPos;}
catch(e)
{return null;}}
function getRealWidth(imgElem){try
{xPos=eval(imgElem).offsetWidth;tempEl=eval(imgElem).offsetParent;return xPos;}
catch(e)
{return null;}}
function getRealHeight(imgElem){try
{xPos=eval(imgElem).offsetHeight;tempEl=eval(imgElem).offsetParent;return xPos;}
catch(e)
{return null;}}
function show(object,left,top,offsetleft,offsettop){try
{if(offsetleft==null)
offsetleft=0;if(offsettop==null)
offsettop=0;if(document.getElementById(left))
document.getElementById(object).style.left=getRealLeft(document.getElementById(left))+offsetleft+'px';else
document.getElementById(object).style.left=getRealLeft(left)+offsetleft+'px';if(document.getElementById(top))
document.getElementById(object).style.top=getRealTop(document.getElementById(top))+offsettop+'px';else
document.getElementById(object).style.top=getRealTop(top)+offsettop+'px';if(document.getElementById&&document.getElementById(object)!=null)
node=document.getElementById(object).style.visibility='visible';else if(document.layers&&document.layers[object]!=null)
document.layers[object].visibility='visible';if(document.getElementById(object).style.display=='none')
{document.getElementById(object).style.display='';}}
catch(e)
{}}
function hide(object){if(document.getElementById&&document.getElementById(object)!=null)
node=document.getElementById(object).style.visibility='hidden';else if(document.layers&&document.layers[object]!=null)
document.layers[object].visibility='hidden';}
function toggle(id)
{if(document.getElementById(id))
{if(document.getElementById(id).style.display=='none')
{$('#'+id).show("slow");}
else
$('#'+ id).hide("slow");}}
function IncludeJavaScript(jsFile)
{document.write('<script language="javascript" type="text/javascript" src="'
+jsFile+'"></script>');}
function trMouseOver()
{var c,i=0;var tab=document.getElementById('mouseover');if(tab!=null)
{var tds=tab.getElementsByTagName('tr');if(tds==null)
{tds=tab.getElementsByTagName('TR');}
while(c=tds.item(i++))
{c.onmouseover=function(){this.setAttribute('fbg',this.className);this.className='base';}
c.onmouseout=function(){this.className=this.getAttribute('fbg');}}}}
function toggle_zebra(elm,class1)
{if(elm!=null)
{elm.onmouseover=function(){this.setAttribute('fbg',this.className);this.className=class1;}
elm.onmouseout=function(){this.className=this.getAttribute('fbg');}}}
function dd_goto(targetstr)
{top.location.href=targetstr;}
function getCookie(cookieName){for(var x=0;x<document.cookie.split("; ").length;x++){var oneCookie=document.cookie.split("; ")[x].split("=");if(oneCookie[0]==escape(cookieName)){return unescape(oneCookie[1]);}}
return'';}
function rememberCookie(cookieName,cookieValue){var cookieLife=20;document.cookie=escape(cookieName)+'='+escape(cookieValue)+(cookieLife?';expires='+new Date((new Date()).getTime()+(cookieLife*86400000)).toGMTString():'')+';path=/';}
function toggleHeaderData()
{toggle('latesthumidity');toggle('latestpressure');toggle('latestwind');toggle('latestrain');toggle('radarTab');toggle('satelliteLink');toggle('headerdatatoggler');
}
function toggleBrokenData(ahref)
{var tdOfTitle=ahref.parentNode;var nextTR=tdOfTitle.nextSibling;while(nextTR)
{if(nextTR.style.display=="none")
nextTR.style.display="";else
nextTR.style.display="none";nextTR=nextTR.nextSibling;}}
function find_moonrise_set(mjd,tz,glong,glat){var sglong,sglat,date,ym,yz,above,utrise,utset,j;var yp,nz,rise,sett,hour,z1,z2,iobj,rads=0.0174532925;var quadout=new Array;var sinho;var always_up=" ****";var always_down=" ....";var outstring="";sinho=Math.sin(rads*8/60);sglat=Math.sin(rads*glat);cglat=Math.cos(rads*glat);date=mjd-tz/24;rise=false;sett=false;above=false;hour=1.0;ym=sin_alt(1,date,hour-1.0,glong,cglat,sglat)-sinho;if(ym>0.0)above=true;while(hour<25&&(sett==false||rise==false)){yz=sin_alt(1,date,hour,glong,cglat,sglat)-sinho;yp=sin_alt(1,date,hour+1.0,glong,cglat,sglat)-sinho;quadout=quad(ym,yz,yp);nz=quadout[0];z1=quadout[1];z2=quadout[2];xe=quadout[3];ye=quadout[4];if(nz==1){if(ym<0.0){utrise=hour+z1;rise=true;}
else{utset=hour+z1;sett=true;}}
if(nz==2){if(ye<0.0){utrise=hour+z2;utset=hour+z1;}
else{utrise=hour+z1;utset=hour+z2;}}
ym=yp;hour+=2.0;}
if(rise==true||sett==true){if(rise==true)outstring+=" "+hrsmin(utrise);else outstring+="";if(sett==true)outstring+="<br/>"+hrsmin(utset);else outstring+="";}
else{if(above==true)outstring+=always_up+always_up;else outstring+=always_down+always_down;}
return outstring;}
function hrsmin(hours){var hrs,h,m,dum;hrs=Math.floor(hours*60+0.5)/60.0;h=Math.floor(hrs);m=Math.floor(60*(hrs-h)+0.5);dum=h*100+m;if(dum<1000)dum="0"+dum;if(dum<100)dum="0"+dum;if(dum<10)dum="0"+dum;dumstr=dum.toString();dumstr=dumstr.substr(0,2) + ":" + dumstr.substr(2,2);return dumstr;}
function sin_alt(iobj,mjd0,hour,glong,cglat,sglat){var mjd,t,ra,dec,tau,salt,rads=0.0174532925;var objpos=new Array;mjd=mjd0+hour/24.0;t=(mjd-51544.5)/36525.0;if(iobj==1){objpos=minimoon(t);}
ra=objpos[2];dec=objpos[1];tau=15.0*(lmst(mjd,glong)-ra);salt=sglat*Math.sin(rads*dec)+cglat*Math.cos(rads*dec)*Math.cos(rads*tau);return salt;}
function mjd(day,month,year,hour){var a,b;if(month<=2){month=month+12;year=year-1;}
a=10000.0*year+100.0*month+day;if(a<=15821004.1){b=-2*Math.floor((year+4716)/4)-1179;}
else{b=Math.floor(year/400)-Math.floor(year/100)+Math.floor(year/4);}
a=365.0*year-679004.0;return(a+b+Math.floor(30.6001*(month+1))+day+hour/24.0);}
function lmst(mjd,glong){var lst,t,d;d=mjd-51544.5
t=d/36525.0;lst=range(280.46061837+360.98564736629*d+0.000387933*t*t-t*t*t/38710000);return(lst/15.0+glong/15);}
function minimoon(t){var p2=6.283185307,arc=206264.8062,coseps=0.91748,sineps=0.39778;var L0,L,LS,F,D,H,S,N,DL,CB,L_moon,B_moon,V,W,X,Y,Z,RHO;var mooneq=new Array;L0=frac(0.606433+1336.855225*t);L=p2*frac(0.374897+1325.552410*t)
LS=p2*frac(0.993133+99.997361*t);D=p2*frac(0.827361+1236.853086*t);F=p2*frac(0.259086+1342.227825*t);DL=22640*Math.sin(L)
DL+=-4586*Math.sin(L-2*D);DL+=+2370*Math.sin(2*D);DL+=+769*Math.sin(2*L);DL+=-668*Math.sin(LS);DL+=-412*Math.sin(2*F);DL+=-212*Math.sin(2*L-2*D);DL+=-206*Math.sin(L+LS-2*D);DL+=+192*Math.sin(L+2*D);DL+=-165*Math.sin(LS-2*D);DL+=-125*Math.sin(D);DL+=-110*Math.sin(L+LS);DL+=+148*Math.sin(L-LS);DL+=-55*Math.sin(2*F-2*D);S=F+(DL+412*Math.sin(2*F)+541*Math.sin(LS))/arc;H=F-2*D;N=-526*Math.sin(H);N+=+44*Math.sin(L+H);N+=-31*Math.sin(-L+H);N+=-23*Math.sin(LS+H);N+=+11*Math.sin(-LS+H);N+=-25*Math.sin(-2*L+F);N+=+21*Math.sin(-L+F);L_moon=p2*frac(L0+DL/1296000);B_moon=(18520.0*Math.sin(S)+N)/arc;CB=Math.cos(B_moon);X=CB*Math.cos(L_moon);V=CB*Math.sin(L_moon);W=Math.sin(B_moon);Y=coseps*V-sineps*W;Z=sineps*V+coseps*W
RHO=Math.sqrt(1.0-Z*Z);dec=(360.0/p2)*Math.atan(Z/RHO);ra=(48.0/p2)*Math.atan(Y/(X+RHO));if(ra<0)ra+=24;mooneq[1]=dec;mooneq[2]=ra;return mooneq;}
function range(x){var a,b;b=x/360;a=360*(b-ipart(b));if(a<0){a=a+360}
return a}
function ipart(x){var a;if(x>0){a=Math.floor(x);}
else{a=Math.ceil(x);}
return a;}
function frac(x){var a;a=x-Math.floor(x);if(a<0)a+=1;return a;}
function quad(ym,yz,yp){var nz,a,b,c,dis,dx,xe,ye,z1,z2,nz;var quadout=new Array;nz=0;a=0.5*(ym+yp)-yz;b=0.5*(yp-ym);c=yz;xe=-b/(2*a);ye=(a*xe+b)*xe+c;dis=b*b-4.0*a*c;if(dis>0){dx=0.5*Math.sqrt(dis)/Math.abs(a);z1=xe-dx;z2=xe+dx;if(Math.abs(z1)<=1.0)nz+=1;if(Math.abs(z2)<=1.0)nz+=1;if(z1<-1.0)z1=z2;}
quadout[0]=nz;quadout[1]=z1;quadout[2]=z2;quadout[3]=xe;quadout[4]=ye;return quadout;}
function getBody(content)
{test=content.toLowerCase();var x=test.indexOf("<body");if(x==-1)return"";x=test.indexOf(">",x);if(x==-1)return"";var y=test.lastIndexOf("</body>");if(y==-1)y=test.lastIndexOf("</html>");if(y==-1)y=content.length;return content.slice(x+1,y);}
function changeUrlLang(lang,loc)
{loc=loc.replace(/lang=\d/g,"lang="+lang);
if(lang==1){loc=loc.replace(/tempunit=F/g,"");}   if(loc.indexOf('?')==-1)
{loc=loc+"?";}
if(loc.indexOf('lang')==-1)
{loc=loc+"&lang="+lang;}
top.location.href=loc;}
function changeBack() {
            document.getElementById("lion").style.backgroundPosition = "left";
            document.getElementById("long_text").style.visibility = "hidden";
            document.getElementById("short_text").style.visibility = "hidden";
            document.getElementById("clothes_line").style.visibility = "hidden";
        }
function change_main(id, t){
 //animate to the div id.

 if (id == "#forcast_days") {
     $("#forcast_main .contentbox-wrapper").animate({"right": "0px"}, 600);
 } else if (id == "#forcast_hours") {
     $("#forcast_main .contentbox-wrapper").animate({"right": "-700px"}, 600);
 } else {
     $("#forcast_main .contentbox-wrapper").animate({"right": "-1420px"}, 600);
 }


 // remove "active" class from all links inside #nav
 $('#forcast_title div').removeClass('for_active');

 // add active class to the current link
 $(t).addClass('for_active');
 }

 function change_pic(whichSide) {
      var x = document.getElementById("pic_contentbox").offsetLeft;
      var w = document.getElementById("pic_contentbox").offsetWidth;
     //alert(x);
     if ((whichSide == "left") && (x<0)) {
         $("#pic_contentbox").animate({"right": -(x+w) + "px"}, 400, "swing");
     } else if ( (whichSide == "right") && (x > -(w-300) ) ) {;
         $("#pic_frame .contentbox-wrapper").animate({"right": -(x+w-600) + "px"}, 400, "swing");
     }
 }

 function change_pic_to(rightValue) {
      $("#pic_contentbox").animate({"right": rightValue}, 400, "swing");
 }


 function change_circle(line_id, info_id) {
     document.getElementById("latestnow").style.display = "none";
     document.getElementById("latesttemp").style.display = "none";
     document.getElementById("latestpressure").style.display = "none";
     document.getElementById("latesthumidity").style.display = "none";
     document.getElementById("latestuv").style.display = "none";
     document.getElementById("latestradiation").style.display = "none";
     document.getElementById("latestrain").style.display = "none";
     document.getElementById("latestwind").style.display = "none";
     document.getElementById("coldmetersurvey").style.display = "none";

     document.getElementById("now_line").style.visibility = "hidden";
     document.getElementById("temp_line").style.visibility = "hidden";
     document.getElementById("moist_line").style.visibility = "hidden";
     document.getElementById("wind_line").style.visibility = "hidden";
     document.getElementById("air_line").style.visibility = "hidden";
     document.getElementById("rain_line").style.visibility = "hidden";
     document.getElementById("rad_line").style.visibility = "hidden";
     document.getElementById("uv_line").style.visibility = "hidden";
     document.getElementById("cold_line").style.visibility = "hidden";
     //document.getElementById("mood_line").style.visibility = "hidden";
     document.getElementById("season_line").style.visibility = "hidden";

     document.getElementById(line_id).style.visibility = "visible";
     document.getElementById(info_id).style.display = "block";


 }

 function playSound(id) {
     var audio = document.getElementById(id);
     audio.currentTime = 0;
     audio.play();
     if (id == "purr_sound") {
        document.getElementById("lion").style.backgroundPosition = "-800px";
     }

 }

 function stopSound(id) {
     var audio = document.getElementById(id);
     //alert(id);
     audio.pause();
     if (id == "purr_sound") {
        document.getElementById("lion").style.backgroundPosition = "left";
     }
 }

 function chooseLocation(){
     //var d = document.getElementById("pic_stuff");
     document.getElementById("pic_empty").addEventListener("click", addLocation);
     document.getElementById("pic_empty").style.cursor = "url(img/cursor_upload.png), auto";
     document.getElementById("upload_text").style.visibility = "visible";
     document.body.addEventListener("mousemove", bodyMove);
 }

 function bodyMove() {
     document.body.addEventListener("click", removeHover);
 }

 function removeHover() {
     //alert("click");
     document.getElementById("pic_empty").style.cursor = "auto";
     document.getElementById("upload_text").style.visibility = "hidden";
     document.getElementById("pic_empty").removeEventListener("click", addLocation);
     document.body.removeEventListener("click", removeHover);
     document.body.removeEventListener("mousemove", bodyMove);
 }

 function addLocation() {
     //alert("click");
     var e = window.event;
     //alert("y: "+e.clientY);
     document.getElementById("upload_form").location.value = "";
     document.getElementById("upload_form").description.value = "";
     document.getElementById("upload_window").style.visibility = "visible";
     document.getElementById("upload_window").style.left = (e.clientX-580)+"px";
     document.getElementById("upload_window").style.top = (1500+ e.clientY-180)+"px";

 }
  
function subjectLeft() {
myPos = $('#subject_icon').css("background-position").split(" ")
//now contains an array like ["0%", "50px"]
var xPos = myPos[0];
var yPos = myPos[1];
//alert(xPos + "," + yPos);
if (parseInt(xPos) > 0) {
 $("#subject_icon").css('background-position', (parseInt(xPos) -14.5) + "%" + " 50%")
}
}
function subjectRight() {
var backgroundPos = $("#subject_icon").css('backgroundPosition').split(" ");
//now contains an array like ["0%", "50px"]
var xPos = backgroundPos[0];
var yPos = backgroundPos[1];
//alert(xPos + "," + yPos);
if (parseInt(xPos) < 100) {
 $("#subject_icon").css('background-position', (parseInt(xPos) +14.5) + "%" + " 50%")
}
}

function changeBg(id, color) {
    document.getElementById(id).style.backgroundColor=color;
}

function openNewPost() {
    document.getElementById("new_post").style.visibility = "visible";
    document.getElementById("forum_hr").style.marginTop = "210px";
    document.getElementById("new_post_ta").value = "";
    $('#new_post_user').addClass($('#user_icon').attr('class'));
}

function closeNewPost() {
    document.getElementById("new_post").style.visibility = "hidden";
    document.getElementById("forum_hr").style.marginTop = "10px";
}

 function change_icon(whichSide) {
    var rightVal = document.getElementById("user_icon_contentbox").style.right;
    var x;
    if (rightVal == "")
        x=0;
    else
        x = parseInt(document.getElementById("user_icon_contentbox").style.right);
    var w = document.getElementById("user_icon_contentbox").offsetWidth;
    var started_icon = $("#chosen_user_icon").val();
    var startedNode = $("#user_icon_contentbox").find("." + started_icon);
    if ((whichSide == "left") && (x<0)) {
        $("#user_icon_contentbox").animate({"right": (x+36) + "px"}, 200, "swing");
        // movestartedNode down
        var newclass = $(startedNode).parent().prev("div").children().first().attr("class")
         $("#chosen_user_icon").val(newclass);
    } else if ( (whichSide == "right") && (x>(50-w)) ) {;
        $("#user_icon_contentbox").animate({"right": (x-36) + "px"}, 200, "swing");
         // movestartedNode down
        var newclass = $(startedNode).parent().next("div").children().first().attr("class")
         $("#chosen_user_icon").val(newclass);
    }
}
function change_icon_to(rightValue) {
$("#user_icon_contentbox").animate({"right": rightValue}, 400, "swing");
}
function fillForecastTemp(jsonstr)
    {
            var foreacastTempDetails = document.getElementById('tempForecastDiv');
             if (foreacastTempDetails.firstChild) {
               foreacastTempDetails.removeChild(foreacastTempDetails.firstChild);
             }
             try{

                 var jsonT = JSON.parse( jsonstr  );
                 $(".tsfh").each(function(index) {
                       // alert(index + ': ' + $(this).text());
                         for (i = 0 ; i < jsonT.forecasthours.length; i++)
                         {
                             //alert("from json: " + jsonT.forecasthours[i].time);
                              if (jsonT.forecasthours[i].ts ==  $(this).text())
                                  $(this).next().next().html(jsonT.forecasthours[i].temp);
                         }
                  });
             }
             catch (e) {
                 //alert(e);
                 foreacastTempDetails.innerHTML = jsonstr;
              }
   }
    function getTempForecast(time, datet, div_id)
    {	
            fillForecastTemp("...", div_id);
            var ajax = new Ajax();
            var postData = decodeURI('date=' + datet + '&amp;time=' + time + '&amp;tempDiff=0');
            ajax.method = 'POST';
            ajax.setMimeType('text/xml');
            postData = postData.replace(/\&amp;/g,'&');
            ajax.postData = postData;
            ajax.url = 'forecast/getAllTempForecast.php';
            ajax.setHandlerBoth(fillForecastTemp);

            ajax.doReq();
    }
function addlinkToMessage()
{
        var target;
        if (($("#linkhref").val().indexOf("youtu") > 0)||
                ($("#linkhref").val().indexOf("facebook") > 0))
        {
                target = "\" target=\"_blank\">";
        }
        else
                 target = "\" rel=\"external\">";

        $("#new_post_ta").val($("#new_post_ta").val() + " <a href=\"" + $("#linkhref").val() + target + $("#linktitle").val() + "</a> ");
        $("#cboxClose").click();
        $("#new_post_ta").focus();
}
function closeLinktoMessage()
{
        $("#cboxClose").click();
}
function addMoodToMessage(mood)
{
        $("#new_post_emoticon").html("<a class=\"mood\" title=\"אייקון שמתאים למצב רוחך\" href=\"javascript:void(0)\">" + "<div class='" + mood.className + "' id=\"mood_img\" title=\"" + getMoodTitle(mood.className) + "\" />" + "</a>");
        $("#cboxClose").click();
}
function attachEnter(){
		   $("#loginform_password").keyup(function(event){
		   if(event.keyCode == 13){
			  $("#loginform_submit").click();
		   }
		   });
		   $("#passforgotform_email").keyup(function(event){
		   if(event.keyCode == 13){
			  $("#passforgotform_submit").click();
		   }
		   });
			$("#registerform_nicename").keyup(function(event){
		   if(event.keyCode == 13){
			  $("#registerform_submit").click();
		   }
		   });
       }	
        function fillUserDetails (jsonstr )
        {
        	var jsonT = JSON.parse( jsonstr  );
        	 $("#profileform_email").val(jsonT.user.email);
                 $("#name").html(jsonT.user.display);
                 $("#user_name").html(jsonT.user.nicename);
                 $("#user_icon").addClass(jsonT.user.icon);
                 if (jsonT.user.icon != "")
                    $("#chosen_user_icon").val(jsonT.user.icon);
                else
                    $("#chosen_user_icon").val($("#user_icon_contentbox").children().first().children().first().attr('class'));
                 $("#profileform_user_icon").addClass(jsonT.user.icon);
                 $("#profileform_displayname").val(jsonT.user.display);
                 $("#current_display_name").val(jsonT.user.display);
                 $("#profileform_nicename").val(jsonT.user.nicename);
                 $("#profileform_priority").prop("checked", jsonT.user.priority);
        }
        function signout_from_server(lang, limit, update)
        {
                $.ajax({
          type: "POST",
          url: "checkauth.php?action=signout",
          data: { },
  beforeSend: function(){$(".loading").show();}
        }).done(function( result  ) {

             $(".loading").hide();

             if (result == 0)
             {
                 $("#user_name").html('');                      
                 toggle('loggedin');
                 toggle('notloggedin');

                 fillMessage('<img src="images/loading.gif" alt="loading" width="32" height="32"/>');
                                        var ajax = new Ajax();
                                        ajax.method = 'POST';
                                        ajax.setMimeType('text/html');
                                        ajax.setHandlerBoth(fillMessage);
                                        ajax.postData = "lang=" + lang + "&limit=" + limit + "&update=" + update;
                                        ajax.url = 'chat_service.php';
                                        ajax.doReq();  
            }



        });
        }
        function getMessageService(filter, start, update, lang)
	{	
		
		var name = $('#profileform_displayname').val();
		var body = $('#new_post_ta').val();
                var mood_elm = "";
		var mood_img = document.getElementById('mood_img');
		if ((mood_img != null)&&(mood_img != 'undfined')) 
		{
			mood_elm = "<div class=\"" + mood_img.className + "\" title=\"" + mood_img.title + "\" ></div>";
		}
		
		var searchname = document.getElementById('searchname');
		if (searchname != null)
			searchname = searchname.value;
			else
				 searchname = '';
		
		if ((filter == '') && 
			((searchname == '') || (searchname == null)) && 
			((name == '' ||  body == '')))
		{
			return false;
		}
		
		var idx = "";
                var msgDetails = document.getElementById('msgDetails');
		var idxs = msgDetails.getElementsByTagName("input"); 
		for (var i = 0; i < idxs.length; i++) { 
			if (idxs[i].type=="checkbox")  
				if (idxs[i].checked) { 
					idx = idxs[i].value; 
				}
		}
		var limit = limit;
		if ((filter != "") && (filter != "undefined"))
			limit = filter;
		if (update == 0)
		{
			body = '';
			name = '';
		}
		
		restoreTopDiv();
		
		var postData = "lang=" + lang + "&limit=" + limit + "&startLine=" + start + "&idx=" + idx + "&name=" + escape(encodeURI(name)) + "&searchname=" + escape(encodeURI(searchname)) + "&body=" + escape(encodeURI(body)) + "&mood=" + escape(encodeURI(mood_elm))  + "&update=<?=$_GET['update']?>";
		fillMessage('<img src="images/loading.gif" alt="loading" />');
		$('input[name="SendButton"]').attr("disabled", "disabled");
		var ajax = new Ajax();
		ajax.method = 'POST';
		ajax.setMimeType('text/html');
		ajax.postData = postData;
		ajax.setHandlerBoth(fillMessage);
		ajax.url = 'chat_service.php';
		ajax.doReq();
		
	}
        function changeLang (lang)
        {
                var loc = document.URL;
                changeUrlLang(lang, loc);
        }
//
// startup script
//
if(navigator.userAgent.match(/iPad/i)) {
        viewport = document.querySelector("meta[name=viewport]");
        viewport.setAttribute('content', 'width=1050');
}
trMouseOver();if( isMobile.any() ){toggle('mobileredirect');}