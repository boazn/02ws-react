<?  
    header("Content-type: text/javascript");
    
    if ($_GET['debug'] == '') include "begin_caching.php";
    ini_set("display_errors","Off");
    ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE);
    include_once('lang.php');
    $mem = new Memcached();
    $mem->addServer('localhost', 11211);
$lang_idx = @$_GET['lang'];
function get_arrow(){
	if (isHeb())
		return "&nbsp;&#8250;&#8250;"; //"&#9668;";
	else
		return "&nbsp;&#8250;&#8250;"; //"&#9658;";
}
function getWindInfo($windspeed, $lang_idx){
     global $WEAK_WINDS, $MODERATE_WINDS, $STRONG_WINDS, $EXTREME_WINDS;
     if ($windspeed > 30){
                $windtitle=$EXTREME_WINDS[$lang_idx];
                $wind_class="high_wind";
                $windimg = "wind2.svg";
       }

      else if ($windspeed > 20){
                $windtitle=$STRONG_WINDS[$lang_idx];
                $wind_class="high_wind";
                $windimg = "wind2.svg";
       }

      else if ($windspeed > 10){
                $windtitle=$MODERATE_WINDS[$lang_idx];
                $wind_class="moderate_wind";
                $windimg = "wind1.svg";
       }

      else{
                $windtitle=$WEAK_WINDS[$lang_idx];
                $wind_class="light_wind";
                $windimg = "wind0.svg";
       }
       return array('windtitle' => $windtitle, 'wind_class' => $wind_class, 'wind_img' =>$windimg);
 }
function replaceDays($str) {
    global $lang_idx;
    if (isHeb()) {
        $str = str_replace("Sun ", " א ", $str);
        $str = str_replace("Mon ", " ב ", $str);
        $str = str_replace("Tue ", " ג ", $str);
        $str = str_replace("Wed ", " ד ", $str);
        $str = str_replace("Thu ", " ה ", $str);
        $str = str_replace("Fri ", " ו ", $str);
        $str = str_replace("Sat ", " ש ", $str);
    }
    return $str;
}
function logger($msg) {
    //echo "<br>in Logger<br>";
    $datafile = "log/log.txt";
    //$msg = getLocalTime(time()) . " " . $msg;
    $file = @fopen($datafile, "a+");
    @fwrite($file, $msg . " \n");
    @fclose($file);
}
function getCorF($temp){
    $temp_unit = $_GET['temp_unit'];
    
    $pos = strpos($temp_unit, 'F');
    //logger("getCorF: ".$temp_unit)." ".$pos);
    if ($pos !== false){
        $temp =  round(((9 * $temp) / 5) + 32);
        //logger("get_temp: ".$temp_unit." ".$temp);
      }
    return  $temp;
}
function isHeb()
{
	global $lang_idx;
	return ($lang_idx == 1);
}
?>
/*!
 * fastclick
 */
!function(){"use strict";function t(e,o){function i(t,e){return function(){return t.apply(e,arguments)}}var r;if(o=o||{},this.trackingClick=!1,this.trackingClickStart=0,this.targetElement=null,this.touchStartX=0,this.touchStartY=0,this.lastTouchIdentifier=0,this.touchBoundary=o.touchBoundary||10,this.layer=e,this.tapDelay=o.tapDelay||200,this.tapTimeout=o.tapTimeout||700,!t.notNeeded(e)){for(var a=["onMouse","onClick","onTouchStart","onTouchMove","onTouchEnd","onTouchCancel"],c=this,s=0,u=a.length;u>s;s++)c[a[s]]=i(c[a[s]],c);n&&(e.addEventListener("mouseover",this.onMouse,!0),e.addEventListener("mousedown",this.onMouse,!0),e.addEventListener("mouseup",this.onMouse,!0)),e.addEventListener("click",this.onClick,!0),e.addEventListener("touchstart",this.onTouchStart,!1),e.addEventListener("touchmove",this.onTouchMove,!1),e.addEventListener("touchend",this.onTouchEnd,!1),e.addEventListener("touchcancel",this.onTouchCancel,!1),Event.prototype.stopImmediatePropagation||(e.removeEventListener=function(t,n,o){var i=Node.prototype.removeEventListener;"click"===t?i.call(e,t,n.hijacked||n,o):i.call(e,t,n,o)},e.addEventListener=function(t,n,o){var i=Node.prototype.addEventListener;"click"===t?i.call(e,t,n.hijacked||(n.hijacked=function(t){t.propagationStopped||n(t)}),o):i.call(e,t,n,o)}),"function"==typeof e.onclick&&(r=e.onclick,e.addEventListener("click",function(t){r(t)},!1),e.onclick=null)}}var e=navigator.userAgent.indexOf("Windows Phone")>=0,n=navigator.userAgent.indexOf("Android")>0&&!e,o=/iP(ad|hone|od)/.test(navigator.userAgent)&&!e,i=o&&/OS 4_\d(_\d)?/.test(navigator.userAgent),r=o&&/OS [6-7]_\d/.test(navigator.userAgent),a=navigator.userAgent.indexOf("BB10")>0;t.prototype.needsClick=function(t){switch(t.nodeName.toLowerCase()){case"button":case"select":case"textarea":if(t.disabled)return!0;break;case"input":if(o&&"file"===t.type||t.disabled)return!0;break;case"label":case"iframe":case"video":return!0}return/\bneedsclick\b/.test(t.className)},t.prototype.needsFocus=function(t){switch(t.nodeName.toLowerCase()){case"textarea":return!0;case"select":return!n;case"input":switch(t.type){case"button":case"checkbox":case"file":case"image":case"radio":case"submit":return!1}return!t.disabled&&!t.readOnly;default:return/\bneedsfocus\b/.test(t.className)}},t.prototype.sendClick=function(t,e){var n,o;document.activeElement&&document.activeElement!==t&&document.activeElement.blur(),o=e.changedTouches[0],n=document.createEvent("MouseEvents"),n.initMouseEvent(this.determineEventType(t),!0,!0,window,1,o.screenX,o.screenY,o.clientX,o.clientY,!1,!1,!1,!1,0,null),n.forwardedTouchEvent=!0,t.dispatchEvent(n)},t.prototype.determineEventType=function(t){return n&&"select"===t.tagName.toLowerCase()?"mousedown":"click"},t.prototype.focus=function(t){var e;o&&t.setSelectionRange&&0!==t.type.indexOf("date")&&"time"!==t.type&&"month"!==t.type?(e=t.value.length,t.setSelectionRange(e,e)):t.focus()},t.prototype.updateScrollParent=function(t){var e,n;if(e=t.fastClickScrollParent,!e||!e.contains(t)){n=t;do{if(n.scrollHeight>n.offsetHeight){e=n,t.fastClickScrollParent=n;break}n=n.parentElement}while(n)}e&&(e.fastClickLastScrollTop=e.scrollTop)},t.prototype.getTargetElementFromEventTarget=function(t){return t.nodeType===Node.TEXT_NODE?t.parentNode:t},t.prototype.onTouchStart=function(t){var e,n,r;if(t.targetTouches.length>1)return!0;if(e=this.getTargetElementFromEventTarget(t.target),n=t.targetTouches[0],o){if(r=window.getSelection(),r.rangeCount&&!r.isCollapsed)return!0;if(!i){if(n.identifier&&n.identifier===this.lastTouchIdentifier)return t.preventDefault(),!1;this.lastTouchIdentifier=n.identifier,this.updateScrollParent(e)}}return this.trackingClick=!0,this.trackingClickStart=t.timeStamp,this.targetElement=e,this.touchStartX=n.pageX,this.touchStartY=n.pageY,t.timeStamp-this.lastClickTime<this.tapDelay&&t.preventDefault(),!0},t.prototype.touchHasMoved=function(t){var e=t.changedTouches[0],n=this.touchBoundary;return Math.abs(e.pageX-this.touchStartX)>n||Math.abs(e.pageY-this.touchStartY)>n?!0:!1},t.prototype.onTouchMove=function(t){return this.trackingClick?((this.targetElement!==this.getTargetElementFromEventTarget(t.target)||this.touchHasMoved(t))&&(this.trackingClick=!1,this.targetElement=null),!0):!0},t.prototype.findControl=function(t){return void 0!==t.control?t.control:t.htmlFor?document.getElementById(t.htmlFor):t.querySelector("button, input:not([type=hidden]), keygen, meter, output, progress, select, textarea")},t.prototype.onTouchEnd=function(t){var e,a,c,s,u,l=this.targetElement;if(!this.trackingClick)return!0;if(t.timeStamp-this.lastClickTime<this.tapDelay)return this.cancelNextClick=!0,!0;if(t.timeStamp-this.trackingClickStart>this.tapTimeout)return!0;if(this.cancelNextClick=!1,this.lastClickTime=t.timeStamp,a=this.trackingClickStart,this.trackingClick=!1,this.trackingClickStart=0,r&&(u=t.changedTouches[0],l=document.elementFromPoint(u.pageX-window.pageXOffset,u.pageY-window.pageYOffset)||l,l.fastClickScrollParent=this.targetElement.fastClickScrollParent),c=l.tagName.toLowerCase(),"label"===c){if(e=this.findControl(l)){if(this.focus(l),n)return!1;l=e}}else if(this.needsFocus(l))return t.timeStamp-a>100||o&&window.top!==window&&"input"===c?(this.targetElement=null,!1):(this.focus(l),this.sendClick(l,t),o&&"select"===c||(this.targetElement=null,t.preventDefault()),!1);return o&&!i&&(s=l.fastClickScrollParent,s&&s.fastClickLastScrollTop!==s.scrollTop)?!0:(this.needsClick(l)||(t.preventDefault(),this.sendClick(l,t)),!1)},t.prototype.onTouchCancel=function(){this.trackingClick=!1,this.targetElement=null},t.prototype.onMouse=function(t){return this.targetElement?t.forwardedTouchEvent?!0:t.cancelable&&(!this.needsClick(this.targetElement)||this.cancelNextClick)?(t.stopImmediatePropagation?t.stopImmediatePropagation():t.propagationStopped=!0,t.stopPropagation(),t.preventDefault(),!1):!0:!0},t.prototype.onClick=function(t){var e;return this.trackingClick?(this.targetElement=null,this.trackingClick=!1,!0):"submit"===t.target.type&&0===t.detail?!0:(e=this.onMouse(t),e||(this.targetElement=null),e)},t.prototype.destroy=function(){var t=this.layer;n&&(t.removeEventListener("mouseover",this.onMouse,!0),t.removeEventListener("mousedown",this.onMouse,!0),t.removeEventListener("mouseup",this.onMouse,!0)),t.removeEventListener("click",this.onClick,!0),t.removeEventListener("touchstart",this.onTouchStart,!1),t.removeEventListener("touchmove",this.onTouchMove,!1),t.removeEventListener("touchend",this.onTouchEnd,!1),t.removeEventListener("touchcancel",this.onTouchCancel,!1)},t.notNeeded=function(t){var e,o,i,r;if("undefined"==typeof window.ontouchstart)return!0;if(o=+(/Chrome\/([0-9]+)/.exec(navigator.userAgent)||[,0])[1]){if(!n)return!0;if(e=document.querySelector("meta[name=viewport]")){if(-1!==e.content.indexOf("user-scalable=no"))return!0;if(o>31&&document.documentElement.scrollWidth<=window.outerWidth)return!0}}if(a&&(i=navigator.userAgent.match(/Version\/([0-9]*)\.([0-9]*)/),i[1]>=10&&i[2]>=3&&(e=document.querySelector("meta[name=viewport]")))){if(-1!==e.content.indexOf("user-scalable=no"))return!0;if(document.documentElement.scrollWidth<=window.outerWidth)return!0}return"none"===t.style.msTouchAction||"manipulation"===t.style.touchAction?!0:(r=+(/Firefox\/([0-9]+)/.exec(navigator.userAgent)||[,0])[1],r>=27&&(e=document.querySelector("meta[name=viewport]"),e&&(-1!==e.content.indexOf("user-scalable=no")||document.documentElement.scrollWidth<=window.outerWidth))?!0:"none"===t.style.touchAction||"manipulation"===t.style.touchAction?!0:!1)},t.attach=function(e,n){return new t(e,n)},"function"==typeof define&&"object"==typeof define.amd&&define.amd?define(function(){return t}):"undefined"!=typeof module&&module.exports?(module.exports=t.attach,module.exports.FastClick=t):window.FastClick=t}();
/*!
 * Chart.js v2.8.0
 * https://www.chartjs.org
 * (c) 2019 Chart.js Contributors
 * Released under the MIT License
 */
!function(t,e){"object"==typeof exports&&"undefined"!=typeof module?module.exports=e():"function"==typeof define&&define.amd?define(e):t.Chart=e()}(this,function(){"use strict";var t={rgb2hsl:e,rgb2hsv:i,rgb2hwb:n,rgb2cmyk:a,rgb2keyword:o,rgb2xyz:s,rgb2lab:l,rgb2lch:function(t){return v(l(t))},hsl2rgb:u,hsl2hsv:function(t){var e=t[0],i=t[1]/100,n=t[2]/100;if(0===n)return[0,0,0];return[e,100*(2*(i*=(n*=2)<=1?n:2-n)/(n+i)),100*((n+i)/2)]},hsl2hwb:function(t){return n(u(t))},hsl2cmyk:function(t){return a(u(t))},hsl2keyword:function(t){return o(u(t))},hsv2rgb:d,hsv2hsl:function(t){var e,i,n=t[0],a=t[1]/100,r=t[2]/100;return e=a*r,[n,100*(e=(e/=(i=(2-a)*r)<=1?i:2-i)||0),100*(i/=2)]},hsv2hwb:function(t){return n(d(t))},hsv2cmyk:function(t){return a(d(t))},hsv2keyword:function(t){return o(d(t))},hwb2rgb:h,hwb2hsl:function(t){return e(h(t))},hwb2hsv:function(t){return i(h(t))},hwb2cmyk:function(t){return a(h(t))},hwb2keyword:function(t){return o(h(t))},cmyk2rgb:c,cmyk2hsl:function(t){return e(c(t))},cmyk2hsv:function(t){return i(c(t))},cmyk2hwb:function(t){return n(c(t))},cmyk2keyword:function(t){return o(c(t))},keyword2rgb:_,keyword2hsl:function(t){return e(_(t))},keyword2hsv:function(t){return i(_(t))},keyword2hwb:function(t){return n(_(t))},keyword2cmyk:function(t){return a(_(t))},keyword2lab:function(t){return l(_(t))},keyword2xyz:function(t){return s(_(t))},xyz2rgb:f,xyz2lab:m,xyz2lch:function(t){return v(m(t))},lab2xyz:p,lab2rgb:y,lab2lch:v,lch2lab:x,lch2xyz:function(t){return p(x(t))},lch2rgb:function(t){return y(x(t))}};function e(t){var e,i,n=t[0]/255,a=t[1]/255,r=t[2]/255,o=Math.min(n,a,r),s=Math.max(n,a,r),l=s-o;return s==o?e=0:n==s?e=(a-r)/l:a==s?e=2+(r-n)/l:r==s&&(e=4+(n-a)/l),(e=Math.min(60*e,360))<0&&(e+=360),i=(o+s)/2,[e,100*(s==o?0:i<=.5?l/(s+o):l/(2-s-o)),100*i]}function i(t){var e,i,n=t[0],a=t[1],r=t[2],o=Math.min(n,a,r),s=Math.max(n,a,r),l=s-o;return i=0==s?0:l/s*1e3/10,s==o?e=0:n==s?e=(a-r)/l:a==s?e=2+(r-n)/l:r==s&&(e=4+(n-a)/l),(e=Math.min(60*e,360))<0&&(e+=360),[e,i,s/255*1e3/10]}function n(t){var i=t[0],n=t[1],a=t[2];return[e(t)[0],100*(1/255*Math.min(i,Math.min(n,a))),100*(a=1-1/255*Math.max(i,Math.max(n,a)))]}function a(t){var e,i=t[0]/255,n=t[1]/255,a=t[2]/255;return[100*((1-i-(e=Math.min(1-i,1-n,1-a)))/(1-e)||0),100*((1-n-e)/(1-e)||0),100*((1-a-e)/(1-e)||0),100*e]}function o(t){return w[JSON.stringify(t)]}function s(t){var e=t[0]/255,i=t[1]/255,n=t[2]/255;return[100*(.4124*(e=e>.04045?Math.pow((e+.055)/1.055,2.4):e/12.92)+.3576*(i=i>.04045?Math.pow((i+.055)/1.055,2.4):i/12.92)+.1805*(n=n>.04045?Math.pow((n+.055)/1.055,2.4):n/12.92)),100*(.2126*e+.7152*i+.0722*n),100*(.0193*e+.1192*i+.9505*n)]}function l(t){var e=s(t),i=e[0],n=e[1],a=e[2];return n/=100,a/=108.883,i=(i/=95.047)>.008856?Math.pow(i,1/3):7.787*i+16/116,[116*(n=n>.008856?Math.pow(n,1/3):7.787*n+16/116)-16,500*(i-n),200*(n-(a=a>.008856?Math.pow(a,1/3):7.787*a+16/116))]}function u(t){var e,i,n,a,r,o=t[0]/360,s=t[1]/100,l=t[2]/100;if(0==s)return[r=255*l,r,r];e=2*l-(i=l<.5?l*(1+s):l+s-l*s),a=[0,0,0];for(var u=0;u<3;u++)(n=o+1/3*-(u-1))<0&&n++,n>1&&n--,r=6*n<1?e+6*(i-e)*n:2*n<1?i:3*n<2?e+(i-e)*(2/3-n)*6:e,a[u]=255*r;return a}function d(t){var e=t[0]/60,i=t[1]/100,n=t[2]/100,a=Math.floor(e)%6,r=e-Math.floor(e),o=255*n*(1-i),s=255*n*(1-i*r),l=255*n*(1-i*(1-r));n*=255;switch(a){case 0:return[n,l,o];case 1:return[s,n,o];case 2:return[o,n,l];case 3:return[o,s,n];case 4:return[l,o,n];case 5:return[n,o,s]}}function h(t){var e,i,n,a,o=t[0]/360,s=t[1]/100,l=t[2]/100,u=s+l;switch(u>1&&(s/=u,l/=u),n=6*o-(e=Math.floor(6*o)),0!=(1&e)&&(n=1-n),a=s+n*((i=1-l)-s),e){default:case 6:case 0:r=i,g=a,b=s;break;case 1:r=a,g=i,b=s;break;case 2:r=s,g=i,b=a;break;case 3:r=s,g=a,b=i;break;case 4:r=a,g=s,b=i;break;case 5:r=i,g=s,b=a}return[255*r,255*g,255*b]}function c(t){var e=t[0]/100,i=t[1]/100,n=t[2]/100,a=t[3]/100;return[255*(1-Math.min(1,e*(1-a)+a)),255*(1-Math.min(1,i*(1-a)+a)),255*(1-Math.min(1,n*(1-a)+a))]}function f(t){var e,i,n,a=t[0]/100,r=t[1]/100,o=t[2]/100;return i=-.9689*a+1.8758*r+.0415*o,n=.0557*a+-.204*r+1.057*o,e=(e=3.2406*a+-1.5372*r+-.4986*o)>.0031308?1.055*Math.pow(e,1/2.4)-.055:e*=12.92,i=i>.0031308?1.055*Math.pow(i,1/2.4)-.055:i*=12.92,n=n>.0031308?1.055*Math.pow(n,1/2.4)-.055:n*=12.92,[255*(e=Math.min(Math.max(0,e),1)),255*(i=Math.min(Math.max(0,i),1)),255*(n=Math.min(Math.max(0,n),1))]}function m(t){var e=t[0],i=t[1],n=t[2];return i/=100,n/=108.883,e=(e/=95.047)>.008856?Math.pow(e,1/3):7.787*e+16/116,[116*(i=i>.008856?Math.pow(i,1/3):7.787*i+16/116)-16,500*(e-i),200*(i-(n=n>.008856?Math.pow(n,1/3):7.787*n+16/116))]}function p(t){var e,i,n,a,r=t[0],o=t[1],s=t[2];return r<=8?a=(i=100*r/903.3)/100*7.787+16/116:(i=100*Math.pow((r+16)/116,3),a=Math.pow(i/100,1/3)),[e=e/95.047<=.008856?e=95.047*(o/500+a-16/116)/7.787:95.047*Math.pow(o/500+a,3),i,n=n/108.883<=.008859?n=108.883*(a-s/200-16/116)/7.787:108.883*Math.pow(a-s/200,3)]}function v(t){var e,i=t[0],n=t[1],a=t[2];return(e=360*Math.atan2(a,n)/2/Math.PI)<0&&(e+=360),[i,Math.sqrt(n*n+a*a),e]}function y(t){return f(p(t))}function x(t){var e,i=t[0],n=t[1];return e=t[2]/360*2*Math.PI,[i,n*Math.cos(e),n*Math.sin(e)]}function _(t){return k[t]}var k={aliceblue:[240,248,255],antiquewhite:[250,235,215],aqua:[0,255,255],aquamarine:[127,255,212],azure:[240,255,255],beige:[245,245,220],bisque:[255,228,196],black:[0,0,0],blanchedalmond:[255,235,205],blue:[0,0,255],blueviolet:[138,43,226],brown:[165,42,42],burlywood:[222,184,135],cadetblue:[95,158,160],chartreuse:[127,255,0],chocolate:[210,105,30],coral:[255,127,80],cornflowerblue:[100,149,237],cornsilk:[255,248,220],crimson:[220,20,60],cyan:[0,255,255],darkblue:[0,0,139],darkcyan:[0,139,139],darkgoldenrod:[184,134,11],darkgray:[169,169,169],darkgreen:[0,100,0],darkgrey:[169,169,169],darkkhaki:[189,183,107],darkmagenta:[139,0,139],darkolivegreen:[85,107,47],darkorange:[255,140,0],darkorchid:[153,50,204],darkred:[139,0,0],darksalmon:[233,150,122],darkseagreen:[143,188,143],darkslateblue:[72,61,139],darkslategray:[47,79,79],darkslategrey:[47,79,79],darkturquoise:[0,206,209],darkviolet:[148,0,211],deeppink:[255,20,147],deepskyblue:[0,191,255],dimgray:[105,105,105],dimgrey:[105,105,105],dodgerblue:[30,144,255],firebrick:[178,34,34],floralwhite:[255,250,240],forestgreen:[34,139,34],fuchsia:[255,0,255],gainsboro:[220,220,220],ghostwhite:[248,248,255],gold:[255,215,0],goldenrod:[218,165,32],gray:[128,128,128],green:[0,128,0],greenyellow:[173,255,47],grey:[128,128,128],honeydew:[240,255,240],hotpink:[255,105,180],indianred:[205,92,92],indigo:[75,0,130],ivory:[255,255,240],khaki:[240,230,140],lavender:[230,230,250],lavenderblush:[255,240,245],lawngreen:[124,252,0],lemonchiffon:[255,250,205],lightblue:[173,216,230],lightcoral:[240,128,128],lightcyan:[224,255,255],lightgoldenrodyellow:[250,250,210],lightgray:[211,211,211],lightgreen:[144,238,144],lightgrey:[211,211,211],lightpink:[255,182,193],lightsalmon:[255,160,122],lightseagreen:[32,178,170],lightskyblue:[135,206,250],lightslategray:[119,136,153],lightslategrey:[119,136,153],lightsteelblue:[176,196,222],lightyellow:[255,255,224],lime:[0,255,0],limegreen:[50,205,50],linen:[250,240,230],magenta:[255,0,255],maroon:[128,0,0],mediumaquamarine:[102,205,170],mediumblue:[0,0,205],mediumorchid:[186,85,211],mediumpurple:[147,112,219],mediumseagreen:[60,179,113],mediumslateblue:[123,104,238],mediumspringgreen:[0,250,154],mediumturquoise:[72,209,204],mediumvioletred:[199,21,133],midnightblue:[25,25,112],mintcream:[245,255,250],mistyrose:[255,228,225],moccasin:[255,228,181],navajowhite:[255,222,173],navy:[0,0,128],oldlace:[253,245,230],olive:[128,128,0],olivedrab:[107,142,35],orange:[255,165,0],orangered:[255,69,0],orchid:[218,112,214],palegoldenrod:[238,232,170],palegreen:[152,251,152],paleturquoise:[175,238,238],palevioletred:[219,112,147],papayawhip:[255,239,213],peachpuff:[255,218,185],peru:[205,133,63],pink:[255,192,203],plum:[221,160,221],powderblue:[176,224,230],purple:[128,0,128],rebeccapurple:[102,51,153],red:[255,0,0],rosybrown:[188,143,143],royalblue:[65,105,225],saddlebrown:[139,69,19],salmon:[250,128,114],sandybrown:[244,164,96],seagreen:[46,139,87],seashell:[255,245,238],sienna:[160,82,45],silver:[192,192,192],skyblue:[135,206,235],slateblue:[106,90,205],slategray:[112,128,144],slategrey:[112,128,144],snow:[255,250,250],springgreen:[0,255,127],steelblue:[70,130,180],tan:[210,180,140],teal:[0,128,128],thistle:[216,191,216],tomato:[255,99,71],turquoise:[64,224,208],violet:[238,130,238],wheat:[245,222,179],white:[255,255,255],whitesmoke:[245,245,245],yellow:[255,255,0],yellowgreen:[154,205,50]},w={};for(var M in k)w[JSON.stringify(k[M])]=M;var S=function(){return new O};for(var D in t){S[D+"Raw"]=function(e){return function(i){return"number"==typeof i&&(i=Array.prototype.slice.call(arguments)),t[e](i)}}(D);var C=/(\w+)2(\w+)/.exec(D),P=C[1],T=C[2];(S[P]=S[P]||{})[T]=S[D]=function(e){return function(i){"number"==typeof i&&(i=Array.prototype.slice.call(arguments));var n=t[e](i);if("string"==typeof n||void 0===n)return n;for(var a=0;a<n.length;a++)n[a]=Math.round(n[a]);return n}}(D)}var O=function(){this.convs={}};O.prototype.routeSpace=function(t,e){var i=e[0];return void 0===i?this.getValues(t):("number"==typeof i&&(i=Array.prototype.slice.call(e)),this.setValues(t,i))},O.prototype.setValues=function(t,e){return this.space=t,this.convs={},this.convs[t]=e,this},O.prototype.getValues=function(t){var e=this.convs[t];if(!e){var i=this.space,n=this.convs[i];e=S[i][t](n),this.convs[t]=e}return e},["rgb","hsl","hsv","cmyk","keyword"].forEach(function(t){O.prototype[t]=function(e){return this.routeSpace(t,arguments)}});var I=S,A={aliceblue:[240,248,255],antiquewhite:[250,235,215],aqua:[0,255,255],aquamarine:[127,255,212],azure:[240,255,255],beige:[245,245,220],bisque:[255,228,196],black:[0,0,0],blanchedalmond:[255,235,205],blue:[0,0,255],blueviolet:[138,43,226],brown:[165,42,42],burlywood:[222,184,135],cadetblue:[95,158,160],chartreuse:[127,255,0],chocolate:[210,105,30],coral:[255,127,80],cornflowerblue:[100,149,237],cornsilk:[255,248,220],crimson:[220,20,60],cyan:[0,255,255],darkblue:[0,0,139],darkcyan:[0,139,139],darkgoldenrod:[184,134,11],darkgray:[169,169,169],darkgreen:[0,100,0],darkgrey:[169,169,169],darkkhaki:[189,183,107],darkmagenta:[139,0,139],darkolivegreen:[85,107,47],darkorange:[255,140,0],darkorchid:[153,50,204],darkred:[139,0,0],darksalmon:[233,150,122],darkseagreen:[143,188,143],darkslateblue:[72,61,139],darkslategray:[47,79,79],darkslategrey:[47,79,79],darkturquoise:[0,206,209],darkviolet:[148,0,211],deeppink:[255,20,147],deepskyblue:[0,191,255],dimgray:[105,105,105],dimgrey:[105,105,105],dodgerblue:[30,144,255],firebrick:[178,34,34],floralwhite:[255,250,240],forestgreen:[34,139,34],fuchsia:[255,0,255],gainsboro:[220,220,220],ghostwhite:[248,248,255],gold:[255,215,0],goldenrod:[218,165,32],gray:[128,128,128],green:[0,128,0],greenyellow:[173,255,47],grey:[128,128,128],honeydew:[240,255,240],hotpink:[255,105,180],indianred:[205,92,92],indigo:[75,0,130],ivory:[255,255,240],khaki:[240,230,140],lavender:[230,230,250],lavenderblush:[255,240,245],lawngreen:[124,252,0],lemonchiffon:[255,250,205],lightblue:[173,216,230],lightcoral:[240,128,128],lightcyan:[224,255,255],lightgoldenrodyellow:[250,250,210],lightgray:[211,211,211],lightgreen:[144,238,144],lightgrey:[211,211,211],lightpink:[255,182,193],lightsalmon:[255,160,122],lightseagreen:[32,178,170],lightskyblue:[135,206,250],lightslategray:[119,136,153],lightslategrey:[119,136,153],lightsteelblue:[176,196,222],lightyellow:[255,255,224],lime:[0,255,0],limegreen:[50,205,50],linen:[250,240,230],magenta:[255,0,255],maroon:[128,0,0],mediumaquamarine:[102,205,170],mediumblue:[0,0,205],mediumorchid:[186,85,211],mediumpurple:[147,112,219],mediumseagreen:[60,179,113],mediumslateblue:[123,104,238],mediumspringgreen:[0,250,154],mediumturquoise:[72,209,204],mediumvioletred:[199,21,133],midnightblue:[25,25,112],mintcream:[245,255,250],mistyrose:[255,228,225],moccasin:[255,228,181],navajowhite:[255,222,173],navy:[0,0,128],oldlace:[253,245,230],olive:[128,128,0],olivedrab:[107,142,35],orange:[255,165,0],orangered:[255,69,0],orchid:[218,112,214],palegoldenrod:[238,232,170],palegreen:[152,251,152],paleturquoise:[175,238,238],palevioletred:[219,112,147],papayawhip:[255,239,213],peachpuff:[255,218,185],peru:[205,133,63],pink:[255,192,203],plum:[221,160,221],powderblue:[176,224,230],purple:[128,0,128],rebeccapurple:[102,51,153],red:[255,0,0],rosybrown:[188,143,143],royalblue:[65,105,225],saddlebrown:[139,69,19],salmon:[250,128,114],sandybrown:[244,164,96],seagreen:[46,139,87],seashell:[255,245,238],sienna:[160,82,45],silver:[192,192,192],skyblue:[135,206,235],slateblue:[106,90,205],slategray:[112,128,144],slategrey:[112,128,144],snow:[255,250,250],springgreen:[0,255,127],steelblue:[70,130,180],tan:[210,180,140],teal:[0,128,128],thistle:[216,191,216],tomato:[255,99,71],turquoise:[64,224,208],violet:[238,130,238],wheat:[245,222,179],white:[255,255,255],whitesmoke:[245,245,245],yellow:[255,255,0],yellowgreen:[154,205,50]},F={getRgba:R,getHsla:L,getRgb:function(t){var e=R(t);return e&&e.slice(0,3)},getHsl:function(t){var e=L(t);return e&&e.slice(0,3)},getHwb:W,getAlpha:function(t){var e=R(t);if(e)return e[3];if(e=L(t))return e[3];if(e=W(t))return e[3]},hexString:function(t,e){var e=void 0!==e&&3===t.length?e:t[3];return"#"+H(t[0])+H(t[1])+H(t[2])+(e>=0&&e<1?H(Math.round(255*e)):"")},rgbString:function(t,e){if(e<1||t[3]&&t[3]<1)return Y(t,e);return"rgb("+t[0]+", "+t[1]+", "+t[2]+")"},rgbaString:Y,percentString:function(t,e){if(e<1||t[3]&&t[3]<1)return N(t,e);var i=Math.round(t[0]/255*100),n=Math.round(t[1]/255*100),a=Math.round(t[2]/255*100);return"rgb("+i+"%, "+n+"%, "+a+"%)"},percentaString:N,hslString:function(t,e){if(e<1||t[3]&&t[3]<1)return z(t,e);return"hsl("+t[0]+", "+t[1]+"%, "+t[2]+"%)"},hslaString:z,hwbString:function(t,e){void 0===e&&(e=void 0!==t[3]?t[3]:1);return"hwb("+t[0]+", "+t[1]+"%, "+t[2]+"%"+(void 0!==e&&1!==e?", "+e:"")+")"},keyword:function(t){return E[t.slice(0,3)]}};function R(t){if(t){var e=[0,0,0],i=1,n=t.match(/^#([a-fA-F0-9]{3,4})$/i),a="";if(n){a=(n=n[1])[3];for(var r=0;r<e.length;r++)e[r]=parseInt(n[r]+n[r],16);a&&(i=Math.round(parseInt(a+a,16)/255*100)/100)}else if(n=t.match(/^#([a-fA-F0-9]{6}([a-fA-F0-9]{2})?)$/i)){a=n[2],n=n[1];for(r=0;r<e.length;r++)e[r]=parseInt(n.slice(2*r,2*r+2),16);a&&(i=Math.round(parseInt(a,16)/255*100)/100)}else if(n=t.match(/^rgba?\(\s*([+-]?\d+)\s*,\s*([+-]?\d+)\s*,\s*([+-]?\d+)\s*(?:,\s*([+-]?[\d\.]+)\s*)?\)$/i)){for(r=0;r<e.length;r++)e[r]=parseInt(n[r+1]);i=parseFloat(n[4])}else if(n=t.match(/^rgba?\(\s*([+-]?[\d\.]+)\%\s*,\s*([+-]?[\d\.]+)\%\s*,\s*([+-]?[\d\.]+)\%\s*(?:,\s*([+-]?[\d\.]+)\s*)?\)$/i)){for(r=0;r<e.length;r++)e[r]=Math.round(2.55*parseFloat(n[r+1]));i=parseFloat(n[4])}else if(n=t.match(/(\w+)/)){if("transparent"==n[1])return[0,0,0,0];if(!(e=A[n[1]]))return}for(r=0;r<e.length;r++)e[r]=V(e[r],0,255);return i=i||0==i?V(i,0,1):1,e[3]=i,e}}function L(t){if(t){var e=t.match(/^hsla?\(\s*([+-]?\d+)(?:deg)?\s*,\s*([+-]?[\d\.]+)%\s*,\s*([+-]?[\d\.]+)%\s*(?:,\s*([+-]?[\d\.]+)\s*)?\)/);if(e){var i=parseFloat(e[4]);return[V(parseInt(e[1]),0,360),V(parseFloat(e[2]),0,100),V(parseFloat(e[3]),0,100),V(isNaN(i)?1:i,0,1)]}}}function W(t){if(t){var e=t.match(/^hwb\(\s*([+-]?\d+)(?:deg)?\s*,\s*([+-]?[\d\.]+)%\s*,\s*([+-]?[\d\.]+)%\s*(?:,\s*([+-]?[\d\.]+)\s*)?\)/);if(e){var i=parseFloat(e[4]);return[V(parseInt(e[1]),0,360),V(parseFloat(e[2]),0,100),V(parseFloat(e[3]),0,100),V(isNaN(i)?1:i,0,1)]}}}function Y(t,e){return void 0===e&&(e=void 0!==t[3]?t[3]:1),"rgba("+t[0]+", "+t[1]+", "+t[2]+", "+e+")"}function N(t,e){return"rgba("+Math.round(t[0]/255*100)+"%, "+Math.round(t[1]/255*100)+"%, "+Math.round(t[2]/255*100)+"%, "+(e||t[3]||1)+")"}function z(t,e){return void 0===e&&(e=void 0!==t[3]?t[3]:1),"hsla("+t[0]+", "+t[1]+"%, "+t[2]+"%, "+e+")"}function V(t,e,i){return Math.min(Math.max(e,t),i)}function H(t){var e=t.toString(16).toUpperCase();return e.length<2?"0"+e:e}var E={};for(var B in A)E[A[B]]=B;var j=function(t){return t instanceof j?t:this instanceof j?(this.valid=!1,this.values={rgb:[0,0,0],hsl:[0,0,0],hsv:[0,0,0],hwb:[0,0,0],cmyk:[0,0,0,0],alpha:1},void("string"==typeof t?(e=F.getRgba(t))?this.setValues("rgb",e):(e=F.getHsla(t))?this.setValues("hsl",e):(e=F.getHwb(t))&&this.setValues("hwb",e):"object"==typeof t&&(void 0!==(e=t).r||void 0!==e.red?this.setValues("rgb",e):void 0!==e.l||void 0!==e.lightness?this.setValues("hsl",e):void 0!==e.v||void 0!==e.value?this.setValues("hsv",e):void 0!==e.w||void 0!==e.whiteness?this.setValues("hwb",e):void 0===e.c&&void 0===e.cyan||this.setValues("cmyk",e)))):new j(t);var e};j.prototype={isValid:function(){return this.valid},rgb:function(){return this.setSpace("rgb",arguments)},hsl:function(){return this.setSpace("hsl",arguments)},hsv:function(){return this.setSpace("hsv",arguments)},hwb:function(){return this.setSpace("hwb",arguments)},cmyk:function(){return this.setSpace("cmyk",arguments)},rgbArray:function(){return this.values.rgb},hslArray:function(){return this.values.hsl},hsvArray:function(){return this.values.hsv},hwbArray:function(){var t=this.values;return 1!==t.alpha?t.hwb.concat([t.alpha]):t.hwb},cmykArray:function(){return this.values.cmyk},rgbaArray:function(){var t=this.values;return t.rgb.concat([t.alpha])},hslaArray:function(){var t=this.values;return t.hsl.concat([t.alpha])},alpha:function(t){return void 0===t?this.values.alpha:(this.setValues("alpha",t),this)},red:function(t){return this.setChannel("rgb",0,t)},green:function(t){return this.setChannel("rgb",1,t)},blue:function(t){return this.setChannel("rgb",2,t)},hue:function(t){return t&&(t=(t%=360)<0?360+t:t),this.setChannel("hsl",0,t)},saturation:function(t){return this.setChannel("hsl",1,t)},lightness:function(t){return this.setChannel("hsl",2,t)},saturationv:function(t){return this.setChannel("hsv",1,t)},whiteness:function(t){return this.setChannel("hwb",1,t)},blackness:function(t){return this.setChannel("hwb",2,t)},value:function(t){return this.setChannel("hsv",2,t)},cyan:function(t){return this.setChannel("cmyk",0,t)},magenta:function(t){return this.setChannel("cmyk",1,t)},yellow:function(t){return this.setChannel("cmyk",2,t)},black:function(t){return this.setChannel("cmyk",3,t)},hexString:function(){return F.hexString(this.values.rgb)},rgbString:function(){return F.rgbString(this.values.rgb,this.values.alpha)},rgbaString:function(){return F.rgbaString(this.values.rgb,this.values.alpha)},percentString:function(){return F.percentString(this.values.rgb,this.values.alpha)},hslString:function(){return F.hslString(this.values.hsl,this.values.alpha)},hslaString:function(){return F.hslaString(this.values.hsl,this.values.alpha)},hwbString:function(){return F.hwbString(this.values.hwb,this.values.alpha)},keyword:function(){return F.keyword(this.values.rgb,this.values.alpha)},rgbNumber:function(){var t=this.values.rgb;return t[0]<<16|t[1]<<8|t[2]},luminosity:function(){for(var t=this.values.rgb,e=[],i=0;i<t.length;i++){var n=t[i]/255;e[i]=n<=.03928?n/12.92:Math.pow((n+.055)/1.055,2.4)}return.2126*e[0]+.7152*e[1]+.0722*e[2]},contrast:function(t){var e=this.luminosity(),i=t.luminosity();return e>i?(e+.05)/(i+.05):(i+.05)/(e+.05)},level:function(t){var e=this.contrast(t);return e>=7.1?"AAA":e>=4.5?"AA":""},dark:function(){var t=this.values.rgb;return(299*t[0]+587*t[1]+114*t[2])/1e3<128},light:function(){return!this.dark()},negate:function(){for(var t=[],e=0;e<3;e++)t[e]=255-this.values.rgb[e];return this.setValues("rgb",t),this},lighten:function(t){var e=this.values.hsl;return e[2]+=e[2]*t,this.setValues("hsl",e),this},darken:function(t){var e=this.values.hsl;return e[2]-=e[2]*t,this.setValues("hsl",e),this},saturate:function(t){var e=this.values.hsl;return e[1]+=e[1]*t,this.setValues("hsl",e),this},desaturate:function(t){var e=this.values.hsl;return e[1]-=e[1]*t,this.setValues("hsl",e),this},whiten:function(t){var e=this.values.hwb;return e[1]+=e[1]*t,this.setValues("hwb",e),this},blacken:function(t){var e=this.values.hwb;return e[2]+=e[2]*t,this.setValues("hwb",e),this},greyscale:function(){var t=this.values.rgb,e=.3*t[0]+.59*t[1]+.11*t[2];return this.setValues("rgb",[e,e,e]),this},clearer:function(t){var e=this.values.alpha;return this.setValues("alpha",e-e*t),this},opaquer:function(t){var e=this.values.alpha;return this.setValues("alpha",e+e*t),this},rotate:function(t){var e=this.values.hsl,i=(e[0]+t)%360;return e[0]=i<0?360+i:i,this.setValues("hsl",e),this},mix:function(t,e){var i=t,n=void 0===e?.5:e,a=2*n-1,r=this.alpha()-i.alpha(),o=((a*r==-1?a:(a+r)/(1+a*r))+1)/2,s=1-o;return this.rgb(o*this.red()+s*i.red(),o*this.green()+s*i.green(),o*this.blue()+s*i.blue()).alpha(this.alpha()*n+i.alpha()*(1-n))},toJSON:function(){return this.rgb()},clone:function(){var t,e,i=new j,n=this.values,a=i.values;for(var r in n)n.hasOwnProperty(r)&&(t=n[r],"[object Array]"===(e={}.toString.call(t))?a[r]=t.slice(0):"[object Number]"===e?a[r]=t:console.error("unexpected color value:",t));return i}},j.prototype.spaces={rgb:["red","green","blue"],hsl:["hue","saturation","lightness"],hsv:["hue","saturation","value"],hwb:["hue","whiteness","blackness"],cmyk:["cyan","magenta","yellow","black"]},j.prototype.maxes={rgb:[255,255,255],hsl:[360,100,100],hsv:[360,100,100],hwb:[360,100,100],cmyk:[100,100,100,100]},j.prototype.getValues=function(t){for(var e=this.values,i={},n=0;n<t.length;n++)i[t.charAt(n)]=e[t][n];return 1!==e.alpha&&(i.a=e.alpha),i},j.prototype.setValues=function(t,e){var i,n,a=this.values,r=this.spaces,o=this.maxes,s=1;if(this.valid=!0,"alpha"===t)s=e;else if(e.length)a[t]=e.slice(0,t.length),s=e[t.length];else if(void 0!==e[t.charAt(0)]){for(i=0;i<t.length;i++)a[t][i]=e[t.charAt(i)];s=e.a}else if(void 0!==e[r[t][0]]){var l=r[t];for(i=0;i<t.length;i++)a[t][i]=e[l[i]];s=e.alpha}if(a.alpha=Math.max(0,Math.min(1,void 0===s?a.alpha:s)),"alpha"===t)return!1;for(i=0;i<t.length;i++)n=Math.max(0,Math.min(o[t][i],a[t][i])),a[t][i]=Math.round(n);for(var u in r)u!==t&&(a[u]=I[t][u](a[t]));return!0},j.prototype.setSpace=function(t,e){var i=e[0];return void 0===i?this.getValues(t):("number"==typeof i&&(i=Array.prototype.slice.call(e)),this.setValues(t,i),this)},j.prototype.setChannel=function(t,e,i){var n=this.values[t];return void 0===i?n[e]:i===n[e]?this:(n[e]=i,this.setValues(t,n),this)},"undefined"!=typeof window&&(window.Color=j);var U,G=j,q={noop:function(){},uid:(U=0,function(){return U++}),isNullOrUndef:function(t){return null==t},isArray:function(t){if(Array.isArray&&Array.isArray(t))return!0;var e=Object.prototype.toString.call(t);return"[object"===e.substr(0,7)&&"Array]"===e.substr(-6)},isObject:function(t){return null!==t&&"[object Object]"===Object.prototype.toString.call(t)},isFinite:function(t){return("number"==typeof t||t instanceof Number)&&isFinite(t)},valueOrDefault:function(t,e){return void 0===t?e:t},valueAtIndexOrDefault:function(t,e,i){return q.valueOrDefault(q.isArray(t)?t[e]:t,i)},callback:function(t,e,i){if(t&&"function"==typeof t.call)return t.apply(i,e)},each:function(t,e,i,n){var a,r,o;if(q.isArray(t))if(r=t.length,n)for(a=r-1;a>=0;a--)e.call(i,t[a],a);else for(a=0;a<r;a++)e.call(i,t[a],a);else if(q.isObject(t))for(r=(o=Object.keys(t)).length,a=0;a<r;a++)e.call(i,t[o[a]],o[a])},arrayEquals:function(t,e){var i,n,a,r;if(!t||!e||t.length!==e.length)return!1;for(i=0,n=t.length;i<n;++i)if(a=t[i],r=e[i],a instanceof Array&&r instanceof Array){if(!q.arrayEquals(a,r))return!1}else if(a!==r)return!1;return!0},clone:function(t){if(q.isArray(t))return t.map(q.clone);if(q.isObject(t)){for(var e={},i=Object.keys(t),n=i.length,a=0;a<n;++a)e[i[a]]=q.clone(t[i[a]]);return e}return t},_merger:function(t,e,i,n){var a=e[t],r=i[t];q.isObject(a)&&q.isObject(r)?q.merge(a,r,n):e[t]=q.clone(r)},_mergerIf:function(t,e,i){var n=e[t],a=i[t];q.isObject(n)&&q.isObject(a)?q.mergeIf(n,a):e.hasOwnProperty(t)||(e[t]=q.clone(a))},merge:function(t,e,i){var n,a,r,o,s,l=q.isArray(e)?e:[e],u=l.length;if(!q.isObject(t))return t;for(n=(i=i||{}).merger||q._merger,a=0;a<u;++a)if(e=l[a],q.isObject(e))for(s=0,o=(r=Object.keys(e)).length;s<o;++s)n(r[s],t,e,i);return t},mergeIf:function(t,e){return q.merge(t,e,{merger:q._mergerIf})},extend:function(t){for(var e=function(e,i){t[i]=e},i=1,n=arguments.length;i<n;++i)q.each(arguments[i],e);return t},inherits:function(t){var e=this,i=t&&t.hasOwnProperty("constructor")?t.constructor:function(){return e.apply(this,arguments)},n=function(){this.constructor=i};return n.prototype=e.prototype,i.prototype=new n,i.extend=q.inherits,t&&q.extend(i.prototype,t),i.__super__=e.prototype,i}},Z=q;q.callCallback=q.callback,q.indexOf=function(t,e,i){return Array.prototype.indexOf.call(t,e,i)},q.getValueOrDefault=q.valueOrDefault,q.getValueAtIndexOrDefault=q.valueAtIndexOrDefault;var $={linear:function(t){return t},easeInQuad:function(t){return t*t},easeOutQuad:function(t){return-t*(t-2)},easeInOutQuad:function(t){return(t/=.5)<1?.5*t*t:-.5*(--t*(t-2)-1)},easeInCubic:function(t){return t*t*t},easeOutCubic:function(t){return(t-=1)*t*t+1},easeInOutCubic:function(t){return(t/=.5)<1?.5*t*t*t:.5*((t-=2)*t*t+2)},easeInQuart:function(t){return t*t*t*t},easeOutQuart:function(t){return-((t-=1)*t*t*t-1)},easeInOutQuart:function(t){return(t/=.5)<1?.5*t*t*t*t:-.5*((t-=2)*t*t*t-2)},easeInQuint:function(t){return t*t*t*t*t},easeOutQuint:function(t){return(t-=1)*t*t*t*t+1},easeInOutQuint:function(t){return(t/=.5)<1?.5*t*t*t*t*t:.5*((t-=2)*t*t*t*t+2)},easeInSine:function(t){return 1-Math.cos(t*(Math.PI/2))},easeOutSine:function(t){return Math.sin(t*(Math.PI/2))},easeInOutSine:function(t){return-.5*(Math.cos(Math.PI*t)-1)},easeInExpo:function(t){return 0===t?0:Math.pow(2,10*(t-1))},easeOutExpo:function(t){return 1===t?1:1-Math.pow(2,-10*t)},easeInOutExpo:function(t){return 0===t?0:1===t?1:(t/=.5)<1?.5*Math.pow(2,10*(t-1)):.5*(2-Math.pow(2,-10*--t))},easeInCirc:function(t){return t>=1?t:-(Math.sqrt(1-t*t)-1)},easeOutCirc:function(t){return Math.sqrt(1-(t-=1)*t)},easeInOutCirc:function(t){return(t/=.5)<1?-.5*(Math.sqrt(1-t*t)-1):.5*(Math.sqrt(1-(t-=2)*t)+1)},easeInElastic:function(t){var e=1.70158,i=0,n=1;return 0===t?0:1===t?1:(i||(i=.3),n<1?(n=1,e=i/4):e=i/(2*Math.PI)*Math.asin(1/n),-n*Math.pow(2,10*(t-=1))*Math.sin((t-e)*(2*Math.PI)/i))},easeOutElastic:function(t){var e=1.70158,i=0,n=1;return 0===t?0:1===t?1:(i||(i=.3),n<1?(n=1,e=i/4):e=i/(2*Math.PI)*Math.asin(1/n),n*Math.pow(2,-10*t)*Math.sin((t-e)*(2*Math.PI)/i)+1)},easeInOutElastic:function(t){var e=1.70158,i=0,n=1;return 0===t?0:2==(t/=.5)?1:(i||(i=.45),n<1?(n=1,e=i/4):e=i/(2*Math.PI)*Math.asin(1/n),t<1?n*Math.pow(2,10*(t-=1))*Math.sin((t-e)*(2*Math.PI)/i)*-.5:n*Math.pow(2,-10*(t-=1))*Math.sin((t-e)*(2*Math.PI)/i)*.5+1)},easeInBack:function(t){var e=1.70158;return t*t*((e+1)*t-e)},easeOutBack:function(t){var e=1.70158;return(t-=1)*t*((e+1)*t+e)+1},easeInOutBack:function(t){var e=1.70158;return(t/=.5)<1?t*t*((1+(e*=1.525))*t-e)*.5:.5*((t-=2)*t*((1+(e*=1.525))*t+e)+2)},easeInBounce:function(t){return 1-$.easeOutBounce(1-t)},easeOutBounce:function(t){return t<1/2.75?7.5625*t*t:t<2/2.75?7.5625*(t-=1.5/2.75)*t+.75:t<2.5/2.75?7.5625*(t-=2.25/2.75)*t+.9375:7.5625*(t-=2.625/2.75)*t+.984375},easeInOutBounce:function(t){return t<.5?.5*$.easeInBounce(2*t):.5*$.easeOutBounce(2*t-1)+.5}},X={effects:$};Z.easingEffects=$;var K=Math.PI,J=K/180,Q=2*K,tt=K/2,et=K/4,it=2*K/3,nt={clear:function(t){t.ctx.clearRect(0,0,t.width,t.height)},roundedRect:function(t,e,i,n,a,r){if(r){var o=Math.min(r,a/2,n/2),s=e+o,l=i+o,u=e+n-o,d=i+a-o;t.moveTo(e,l),s<u&&l<d?(t.arc(s,l,o,-K,-tt),t.arc(u,l,o,-tt,0),t.arc(u,d,o,0,tt),t.arc(s,d,o,tt,K)):s<u?(t.moveTo(s,i),t.arc(u,l,o,-tt,tt),t.arc(s,l,o,tt,K+tt)):l<d?(t.arc(s,l,o,-K,0),t.arc(s,d,o,0,K)):t.arc(s,l,o,-K,K),t.closePath(),t.moveTo(e,i)}else t.rect(e,i,n,a)},drawPoint:function(t,e,i,n,a,r){var o,s,l,u,d,h=(r||0)*J;if(!e||"object"!=typeof e||"[object HTMLImageElement]"!==(o=e.toString())&&"[object HTMLCanvasElement]"!==o){if(!(isNaN(i)||i<=0)){switch(t.beginPath(),e){default:t.arc(n,a,i,0,Q),t.closePath();break;case"triangle":t.moveTo(n+Math.sin(h)*i,a-Math.cos(h)*i),h+=it,t.lineTo(n+Math.sin(h)*i,a-Math.cos(h)*i),h+=it,t.lineTo(n+Math.sin(h)*i,a-Math.cos(h)*i),t.closePath();break;case"rectRounded":u=i-(d=.516*i),s=Math.cos(h+et)*u,l=Math.sin(h+et)*u,t.arc(n-s,a-l,d,h-K,h-tt),t.arc(n+l,a-s,d,h-tt,h),t.arc(n+s,a+l,d,h,h+tt),t.arc(n-l,a+s,d,h+tt,h+K),t.closePath();break;case"rect":if(!r){u=Math.SQRT1_2*i,t.rect(n-u,a-u,2*u,2*u);break}h+=et;case"rectRot":s=Math.cos(h)*i,l=Math.sin(h)*i,t.moveTo(n-s,a-l),t.lineTo(n+l,a-s),t.lineTo(n+s,a+l),t.lineTo(n-l,a+s),t.closePath();break;case"crossRot":h+=et;case"cross":s=Math.cos(h)*i,l=Math.sin(h)*i,t.moveTo(n-s,a-l),t.lineTo(n+s,a+l),t.moveTo(n+l,a-s),t.lineTo(n-l,a+s);break;case"star":s=Math.cos(h)*i,l=Math.sin(h)*i,t.moveTo(n-s,a-l),t.lineTo(n+s,a+l),t.moveTo(n+l,a-s),t.lineTo(n-l,a+s),h+=et,s=Math.cos(h)*i,l=Math.sin(h)*i,t.moveTo(n-s,a-l),t.lineTo(n+s,a+l),t.moveTo(n+l,a-s),t.lineTo(n-l,a+s);break;case"line":s=Math.cos(h)*i,l=Math.sin(h)*i,t.moveTo(n-s,a-l),t.lineTo(n+s,a+l);break;case"dash":t.moveTo(n,a),t.lineTo(n+Math.cos(h)*i,a+Math.sin(h)*i)}t.fill(),t.stroke()}}else t.drawImage(e,n-e.width/2,a-e.height/2,e.width,e.height)},_isPointInArea:function(t,e){return t.x>e.left-1e-6&&t.x<e.right+1e-6&&t.y>e.top-1e-6&&t.y<e.bottom+1e-6},clipArea:function(t,e){t.save(),t.beginPath(),t.rect(e.left,e.top,e.right-e.left,e.bottom-e.top),t.clip()},unclipArea:function(t){t.restore()},lineTo:function(t,e,i,n){var a=i.steppedLine;if(a){if("middle"===a){var r=(e.x+i.x)/2;t.lineTo(r,n?i.y:e.y),t.lineTo(r,n?e.y:i.y)}else"after"===a&&!n||"after"!==a&&n?t.lineTo(e.x,i.y):t.lineTo(i.x,e.y);t.lineTo(i.x,i.y)}else i.tension?t.bezierCurveTo(n?e.controlPointPreviousX:e.controlPointNextX,n?e.controlPointPreviousY:e.controlPointNextY,n?i.controlPointNextX:i.controlPointPreviousX,n?i.controlPointNextY:i.controlPointPreviousY,i.x,i.y):t.lineTo(i.x,i.y)}},at=nt;Z.clear=nt.clear,Z.drawRoundedRectangle=function(t){t.beginPath(),nt.roundedRect.apply(nt,arguments)};var rt={_set:function(t,e){return Z.merge(this[t]||(this[t]={}),e)}};rt._set("global",{defaultColor:"rgba(0,0,0,0.1)",defaultFontColor:"#666",defaultFontFamily:"'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",defaultFontSize:12,defaultFontStyle:"normal",defaultLineHeight:1.2,showLines:!0});var ot=rt,st=Z.valueOrDefault;var lt={toLineHeight:function(t,e){var i=(""+t).match(/^(normal|(\d+(?:\.\d+)?)(px|em|%)?)$/);if(!i||"normal"===i[1])return 1.2*e;switch(t=+i[2],i[3]){case"px":return t;case"%":t/=100}return e*t},toPadding:function(t){var e,i,n,a;return Z.isObject(t)?(e=+t.top||0,i=+t.right||0,n=+t.bottom||0,a=+t.left||0):e=i=n=a=+t||0,{top:e,right:i,bottom:n,left:a,height:e+n,width:a+i}},_parseFont:function(t){var e=ot.global,i=st(t.fontSize,e.defaultFontSize),n={family:st(t.fontFamily,e.defaultFontFamily),lineHeight:Z.options.toLineHeight(st(t.lineHeight,e.defaultLineHeight),i),size:i,style:st(t.fontStyle,e.defaultFontStyle),weight:null,string:""};return n.string=function(t){return!t||Z.isNullOrUndef(t.size)||Z.isNullOrUndef(t.family)?null:(t.style?t.style+" ":"")+(t.weight?t.weight+" ":"")+t.size+"px "+t.family}(n),n},resolve:function(t,e,i){var n,a,r;for(n=0,a=t.length;n<a;++n)if(void 0!==(r=t[n])&&(void 0!==e&&"function"==typeof r&&(r=r(e)),void 0!==i&&Z.isArray(r)&&(r=r[i]),void 0!==r))return r}},ut=Z,dt=X,ht=at,ct=lt;ut.easing=dt,ut.canvas=ht,ut.options=ct;var ft=function(t){ut.extend(this,t),this.initialize.apply(this,arguments)};ut.extend(ft.prototype,{initialize:function(){this.hidden=!1},pivot:function(){var t=this;return t._view||(t._view=ut.clone(t._model)),t._start={},t},transition:function(t){var e=this,i=e._model,n=e._start,a=e._view;return i&&1!==t?(a||(a=e._view={}),n||(n=e._start={}),function(t,e,i,n){var a,r,o,s,l,u,d,h,c,f=Object.keys(i);for(a=0,r=f.length;a<r;++a)if(u=i[o=f[a]],e.hasOwnProperty(o)||(e[o]=u),(s=e[o])!==u&&"_"!==o[0]){if(t.hasOwnProperty(o)||(t[o]=s),(d=typeof u)==typeof(l=t[o]))if("string"===d){if((h=G(l)).valid&&(c=G(u)).valid){e[o]=c.mix(h,n).rgbString();continue}}else if(ut.isFinite(l)&&ut.isFinite(u)){e[o]=l+(u-l)*n;continue}e[o]=u}}(n,a,i,t),e):(e._view=i,e._start=null,e)},tooltipPosition:function(){return{x:this._model.x,y:this._model.y}},hasValue:function(){return ut.isNumber(this._model.x)&&ut.isNumber(this._model.y)}}),ft.extend=ut.inherits;var gt=ft,mt=gt.extend({chart:null,currentStep:0,numSteps:60,easing:"",render:null,onAnimationProgress:null,onAnimationComplete:null}),pt=mt;Object.defineProperty(mt.prototype,"animationObject",{get:function(){return this}}),Object.defineProperty(mt.prototype,"chartInstance",{get:function(){return this.chart},set:function(t){this.chart=t}}),ot._set("global",{animation:{duration:1e3,easing:"easeOutQuart",onProgress:ut.noop,onComplete:ut.noop}});var vt={animations:[],request:null,addAnimation:function(t,e,i,n){var a,r,o=this.animations;for(e.chart=t,e.startTime=Date.now(),e.duration=i,n||(t.animating=!0),a=0,r=o.length;a<r;++a)if(o[a].chart===t)return void(o[a]=e);o.push(e),1===o.length&&this.requestAnimationFrame()},cancelAnimation:function(t){var e=ut.findIndex(this.animations,function(e){return e.chart===t});-1!==e&&(this.animations.splice(e,1),t.animating=!1)},requestAnimationFrame:function(){var t=this;null===t.request&&(t.request=ut.requestAnimFrame.call(window,function(){t.request=null,t.startDigest()}))},startDigest:function(){this.advance(),this.animations.length>0&&this.requestAnimationFrame()},advance:function(){for(var t,e,i,n,a=this.animations,r=0;r<a.length;)e=(t=a[r]).chart,i=t.numSteps,n=Math.floor((Date.now()-t.startTime)/t.duration*i)+1,t.currentStep=Math.min(n,i),ut.callback(t.render,[e,t],e),ut.callback(t.onAnimationProgress,[t],e),t.currentStep>=i?(ut.callback(t.onAnimationComplete,[t],e),e.animating=!1,a.splice(r,1)):++r}},yt=ut.options.resolve,bt=["push","pop","shift","splice","unshift"];function xt(t,e){var i=t._chartjs;if(i){var n=i.listeners,a=n.indexOf(e);-1!==a&&n.splice(a,1),n.length>0||(bt.forEach(function(e){delete t[e]}),delete t._chartjs)}}var _t=function(t,e){this.initialize(t,e)};ut.extend(_t.prototype,{datasetElementType:null,dataElementType:null,initialize:function(t,e){this.chart=t,this.index=e,this.linkScales(),this.addElements()},updateIndex:function(t){this.index=t},linkScales:function(){var t=this,e=t.getMeta(),i=t.getDataset();null!==e.xAxisID&&e.xAxisID in t.chart.scales||(e.xAxisID=i.xAxisID||t.chart.options.scales.xAxes[0].id),null!==e.yAxisID&&e.yAxisID in t.chart.scales||(e.yAxisID=i.yAxisID||t.chart.options.scales.yAxes[0].id)},getDataset:function(){return this.chart.data.datasets[this.index]},getMeta:function(){return this.chart.getDatasetMeta(this.index)},getScaleForId:function(t){return this.chart.scales[t]},_getValueScaleId:function(){return this.getMeta().yAxisID},_getIndexScaleId:function(){return this.getMeta().xAxisID},_getValueScale:function(){return this.getScaleForId(this._getValueScaleId())},_getIndexScale:function(){return this.getScaleForId(this._getIndexScaleId())},reset:function(){this.update(!0)},destroy:function(){this._data&&xt(this._data,this)},createMetaDataset:function(){var t=this.datasetElementType;return t&&new t({_chart:this.chart,_datasetIndex:this.index})},createMetaData:function(t){var e=this.dataElementType;return e&&new e({_chart:this.chart,_datasetIndex:this.index,_index:t})},addElements:function(){var t,e,i=this.getMeta(),n=this.getDataset().data||[],a=i.data;for(t=0,e=n.length;t<e;++t)a[t]=a[t]||this.createMetaData(t);i.dataset=i.dataset||this.createMetaDataset()},addElementAndReset:function(t){var e=this.createMetaData(t);this.getMeta().data.splice(t,0,e),this.updateElement(e,t,!0)},buildOrUpdateElements:function(){var t,e,i=this,n=i.getDataset(),a=n.data||(n.data=[]);i._data!==a&&(i._data&&xt(i._data,i),a&&Object.isExtensible(a)&&(e=i,(t=a)._chartjs?t._chartjs.listeners.push(e):(Object.defineProperty(t,"_chartjs",{configurable:!0,enumerable:!1,value:{listeners:[e]}}),bt.forEach(function(e){var i="onData"+e.charAt(0).toUpperCase()+e.slice(1),n=t[e];Object.defineProperty(t,e,{configurable:!0,enumerable:!1,value:function(){var e=Array.prototype.slice.call(arguments),a=n.apply(this,e);return ut.each(t._chartjs.listeners,function(t){"function"==typeof t[i]&&t[i].apply(t,e)}),a}})}))),i._data=a),i.resyncElements()},update:ut.noop,transition:function(t){for(var e=this.getMeta(),i=e.data||[],n=i.length,a=0;a<n;++a)i[a].transition(t);e.dataset&&e.dataset.transition(t)},draw:function(){var t=this.getMeta(),e=t.data||[],i=e.length,n=0;for(t.dataset&&t.dataset.draw();n<i;++n)e[n].draw()},removeHoverStyle:function(t){ut.merge(t._model,t.$previousStyle||{}),delete t.$previousStyle},setHoverStyle:function(t){var e=this.chart.data.datasets[t._datasetIndex],i=t._index,n=t.custom||{},a=t._model,r=ut.getHoverColor;t.$previousStyle={backgroundColor:a.backgroundColor,borderColor:a.borderColor,borderWidth:a.borderWidth},a.backgroundColor=yt([n.hoverBackgroundColor,e.hoverBackgroundColor,r(a.backgroundColor)],void 0,i),a.borderColor=yt([n.hoverBorderColor,e.hoverBorderColor,r(a.borderColor)],void 0,i),a.borderWidth=yt([n.hoverBorderWidth,e.hoverBorderWidth,a.borderWidth],void 0,i)},resyncElements:function(){var t=this.getMeta(),e=this.getDataset().data,i=t.data.length,n=e.length;n<i?t.data.splice(n,i-n):n>i&&this.insertElements(i,n-i)},insertElements:function(t,e){for(var i=0;i<e;++i)this.addElementAndReset(t+i)},onDataPush:function(){var t=arguments.length;this.insertElements(this.getDataset().data.length-t,t)},onDataPop:function(){this.getMeta().data.pop()},onDataShift:function(){this.getMeta().data.shift()},onDataSplice:function(t,e){this.getMeta().data.splice(t,e),this.insertElements(t,arguments.length-2)},onDataUnshift:function(){this.insertElements(0,arguments.length)}}),_t.extend=ut.inherits;var kt=_t;ot._set("global",{elements:{arc:{backgroundColor:ot.global.defaultColor,borderColor:"#fff",borderWidth:2,borderAlign:"center"}}});var wt=gt.extend({inLabelRange:function(t){var e=this._view;return!!e&&Math.pow(t-e.x,2)<Math.pow(e.radius+e.hoverRadius,2)},inRange:function(t,e){var i=this._view;if(i){for(var n=ut.getAngleFromPoint(i,{x:t,y:e}),a=n.angle,r=n.distance,o=i.startAngle,s=i.endAngle;s<o;)s+=2*Math.PI;for(;a>s;)a-=2*Math.PI;for(;a<o;)a+=2*Math.PI;var l=a>=o&&a<=s,u=r>=i.innerRadius&&r<=i.outerRadius;return l&&u}return!1},getCenterPoint:function(){var t=this._view,e=(t.startAngle+t.endAngle)/2,i=(t.innerRadius+t.outerRadius)/2;return{x:t.x+Math.cos(e)*i,y:t.y+Math.sin(e)*i}},getArea:function(){var t=this._view;return Math.PI*((t.endAngle-t.startAngle)/(2*Math.PI))*(Math.pow(t.outerRadius,2)-Math.pow(t.innerRadius,2))},tooltipPosition:function(){var t=this._view,e=t.startAngle+(t.endAngle-t.startAngle)/2,i=(t.outerRadius-t.innerRadius)/2+t.innerRadius;return{x:t.x+Math.cos(e)*i,y:t.y+Math.sin(e)*i}},draw:function(){var t,e=this._chart.ctx,i=this._view,n=i.startAngle,a=i.endAngle,r="inner"===i.borderAlign?.33:0;e.save(),e.beginPath(),e.arc(i.x,i.y,Math.max(i.outerRadius-r,0),n,a),e.arc(i.x,i.y,i.innerRadius,a,n,!0),e.closePath(),e.fillStyle=i.backgroundColor,e.fill(),i.borderWidth&&("inner"===i.borderAlign?(e.beginPath(),t=r/i.outerRadius,e.arc(i.x,i.y,i.outerRadius,n-t,a+t),i.innerRadius>r?(t=r/i.innerRadius,e.arc(i.x,i.y,i.innerRadius-r,a+t,n-t,!0)):e.arc(i.x,i.y,r,a+Math.PI/2,n-Math.PI/2),e.closePath(),e.clip(),e.beginPath(),e.arc(i.x,i.y,i.outerRadius,n,a),e.arc(i.x,i.y,i.innerRadius,a,n,!0),e.closePath(),e.lineWidth=2*i.borderWidth,e.lineJoin="round"):(e.lineWidth=i.borderWidth,e.lineJoin="bevel"),e.strokeStyle=i.borderColor,e.stroke()),e.restore()}}),Mt=ut.valueOrDefault,St=ot.global.defaultColor;ot._set("global",{elements:{line:{tension:.4,backgroundColor:St,borderWidth:3,borderColor:St,borderCapStyle:"butt",borderDash:[],borderDashOffset:0,borderJoinStyle:"miter",capBezierPoints:!0,fill:!0}}});var Dt=gt.extend({draw:function(){var t,e,i,n,a=this._view,r=this._chart.ctx,o=a.spanGaps,s=this._children.slice(),l=ot.global,u=l.elements.line,d=-1;for(this._loop&&s.length&&s.push(s[0]),r.save(),r.lineCap=a.borderCapStyle||u.borderCapStyle,r.setLineDash&&r.setLineDash(a.borderDash||u.borderDash),r.lineDashOffset=Mt(a.borderDashOffset,u.borderDashOffset),r.lineJoin=a.borderJoinStyle||u.borderJoinStyle,r.lineWidth=Mt(a.borderWidth,u.borderWidth),r.strokeStyle=a.borderColor||l.defaultColor,r.beginPath(),d=-1,t=0;t<s.length;++t)e=s[t],i=ut.previousItem(s,t),n=e._view,0===t?n.skip||(r.moveTo(n.x,n.y),d=t):(i=-1===d?i:s[d],n.skip||(d!==t-1&&!o||-1===d?r.moveTo(n.x,n.y):ut.canvas.lineTo(r,i._view,e._view),d=t));r.stroke(),r.restore()}}),Ct=ut.valueOrDefault,Pt=ot.global.defaultColor;function Tt(t){var e=this._view;return!!e&&Math.abs(t-e.x)<e.radius+e.hitRadius}ot._set("global",{elements:{point:{radius:3,pointStyle:"circle",backgroundColor:Pt,borderColor:Pt,borderWidth:1,hitRadius:1,hoverRadius:4,hoverBorderWidth:1}}});var Ot=gt.extend({inRange:function(t,e){var i=this._view;return!!i&&Math.pow(t-i.x,2)+Math.pow(e-i.y,2)<Math.pow(i.hitRadius+i.radius,2)},inLabelRange:Tt,inXRange:Tt,inYRange:function(t){var e=this._view;return!!e&&Math.abs(t-e.y)<e.radius+e.hitRadius},getCenterPoint:function(){var t=this._view;return{x:t.x,y:t.y}},getArea:function(){return Math.PI*Math.pow(this._view.radius,2)},tooltipPosition:function(){var t=this._view;return{x:t.x,y:t.y,padding:t.radius+t.borderWidth}},draw:function(t){var e=this._view,i=this._chart.ctx,n=e.pointStyle,a=e.rotation,r=e.radius,o=e.x,s=e.y,l=ot.global,u=l.defaultColor;e.skip||(void 0===t||ut.canvas._isPointInArea(e,t))&&(i.strokeStyle=e.borderColor||u,i.lineWidth=Ct(e.borderWidth,l.elements.point.borderWidth),i.fillStyle=e.backgroundColor||u,ut.canvas.drawPoint(i,n,r,o,s,a))}}),It=ot.global.defaultColor;function At(t){return t&&void 0!==t.width}function Ft(t){var e,i,n,a,r;return At(t)?(r=t.width/2,e=t.x-r,i=t.x+r,n=Math.min(t.y,t.base),a=Math.max(t.y,t.base)):(r=t.height/2,e=Math.min(t.x,t.base),i=Math.max(t.x,t.base),n=t.y-r,a=t.y+r),{left:e,top:n,right:i,bottom:a}}function Rt(t,e,i){return t===e?i:t===i?e:t}function Lt(t,e,i){var n,a,r,o,s=t.borderWidth,l=function(t){var e=t.borderSkipped,i={};return e?(t.horizontal?t.base>t.x&&(e=Rt(e,"left","right")):t.base<t.y&&(e=Rt(e,"bottom","top")),i[e]=!0,i):i}(t);return ut.isObject(s)?(n=+s.top||0,a=+s.right||0,r=+s.bottom||0,o=+s.left||0):n=a=r=o=+s||0,{t:l.top||n<0?0:n>i?i:n,r:l.right||a<0?0:a>e?e:a,b:l.bottom||r<0?0:r>i?i:r,l:l.left||o<0?0:o>e?e:o}}function Wt(t,e,i){var n=null===e,a=null===i,r=!(!t||n&&a)&&Ft(t);return r&&(n||e>=r.left&&e<=r.right)&&(a||i>=r.top&&i<=r.bottom)}ot._set("global",{elements:{rectangle:{backgroundColor:It,borderColor:It,borderSkipped:"bottom",borderWidth:0}}});var Yt=gt.extend({draw:function(){var t=this._chart.ctx,e=this._view,i=function(t){var e=Ft(t),i=e.right-e.left,n=e.bottom-e.top,a=Lt(t,i/2,n/2);return{outer:{x:e.left,y:e.top,w:i,h:n},inner:{x:e.left+a.l,y:e.top+a.t,w:i-a.l-a.r,h:n-a.t-a.b}}}(e),n=i.outer,a=i.inner;t.fillStyle=e.backgroundColor,t.fillRect(n.x,n.y,n.w,n.h),n.w===a.w&&n.h===a.h||(t.save(),t.beginPath(),t.rect(n.x,n.y,n.w,n.h),t.clip(),t.fillStyle=e.borderColor,t.rect(a.x,a.y,a.w,a.h),t.fill("evenodd"),t.restore())},height:function(){var t=this._view;return t.base-t.y},inRange:function(t,e){return Wt(this._view,t,e)},inLabelRange:function(t,e){var i=this._view;return At(i)?Wt(i,t,null):Wt(i,null,e)},inXRange:function(t){return Wt(this._view,t,null)},inYRange:function(t){return Wt(this._view,null,t)},getCenterPoint:function(){var t,e,i=this._view;return At(i)?(t=i.x,e=(i.y+i.base)/2):(t=(i.x+i.base)/2,e=i.y),{x:t,y:e}},getArea:function(){var t=this._view;return At(t)?t.width*Math.abs(t.y-t.base):t.height*Math.abs(t.x-t.base)},tooltipPosition:function(){var t=this._view;return{x:t.x,y:t.y}}}),Nt={},zt=wt,Vt=Dt,Ht=Ot,Et=Yt;Nt.Arc=zt,Nt.Line=Vt,Nt.Point=Ht,Nt.Rectangle=Et;var Bt=ut.options.resolve;ot._set("bar",{hover:{mode:"label"},scales:{xAxes:[{type:"category",categoryPercentage:.8,barPercentage:.9,offset:!0,gridLines:{offsetGridLines:!0}}],yAxes:[{type:"linear"}]}});var jt=kt.extend({dataElementType:Nt.Rectangle,initialize:function(){var t;kt.prototype.initialize.apply(this,arguments),(t=this.getMeta()).stack=this.getDataset().stack,t.bar=!0},update:function(t){var e,i,n=this.getMeta().data;for(this._ruler=this.getRuler(),e=0,i=n.length;e<i;++e)this.updateElement(n[e],e,t)},updateElement:function(t,e,i){var n=this,a=n.getMeta(),r=n.getDataset(),o=n._resolveElementOptions(t,e);t._xScale=n.getScaleForId(a.xAxisID),t._yScale=n.getScaleForId(a.yAxisID),t._datasetIndex=n.index,t._index=e,t._model={backgroundColor:o.backgroundColor,borderColor:o.borderColor,borderSkipped:o.borderSkipped,borderWidth:o.borderWidth,datasetLabel:r.label,label:n.chart.data.labels[e]},n._updateElementGeometry(t,e,i),t.pivot()},_updateElementGeometry:function(t,e,i){var n=this,a=t._model,r=n._getValueScale(),o=r.getBasePixel(),s=r.isHorizontal(),l=n._ruler||n.getRuler(),u=n.calculateBarValuePixels(n.index,e),d=n.calculateBarIndexPixels(n.index,e,l);a.horizontal=s,a.base=i?o:u.base,a.x=s?i?o:u.head:d.center,a.y=s?d.center:i?o:u.head,a.height=s?d.size:void 0,a.width=s?void 0:d.size},_getStacks:function(t){var e,i,n=this.chart,a=this._getIndexScale().options.stacked,r=void 0===t?n.data.datasets.length:t+1,o=[];for(e=0;e<r;++e)(i=n.getDatasetMeta(e)).bar&&n.isDatasetVisible(e)&&(!1===a||!0===a&&-1===o.indexOf(i.stack)||void 0===a&&(void 0===i.stack||-1===o.indexOf(i.stack)))&&o.push(i.stack);return o},getStackCount:function(){return this._getStacks().length},getStackIndex:function(t,e){var i=this._getStacks(t),n=void 0!==e?i.indexOf(e):-1;return-1===n?i.length-1:n},getRuler:function(){var t,e,i=this._getIndexScale(),n=this.getStackCount(),a=this.index,r=i.isHorizontal(),o=r?i.left:i.top,s=o+(r?i.width:i.height),l=[];for(t=0,e=this.getMeta().data.length;t<e;++t)l.push(i.getPixelForValue(null,t,a));return{min:ut.isNullOrUndef(i.options.barThickness)?function(t,e){var i,n,a,r,o=t.isHorizontal()?t.width:t.height,s=t.getTicks();for(a=1,r=e.length;a<r;++a)o=Math.min(o,Math.abs(e[a]-e[a-1]));for(a=0,r=s.length;a<r;++a)n=t.getPixelForTick(a),o=a>0?Math.min(o,n-i):o,i=n;return o}(i,l):-1,pixels:l,start:o,end:s,stackCount:n,scale:i}},calculateBarValuePixels:function(t,e){var i,n,a,r,o,s,l=this.chart,u=this.getMeta(),d=this._getValueScale(),h=d.isHorizontal(),c=l.data.datasets,f=+d.getRightValue(c[t].data[e]),g=d.options.minBarLength,m=d.options.stacked,p=u.stack,v=0;if(m||void 0===m&&void 0!==p)for(i=0;i<t;++i)(n=l.getDatasetMeta(i)).bar&&n.stack===p&&n.controller._getValueScaleId()===d.id&&l.isDatasetVisible(i)&&(a=+d.getRightValue(c[i].data[e]),(f<0&&a<0||f>=0&&a>0)&&(v+=a));return r=d.getPixelForValue(v),s=(o=d.getPixelForValue(v+f))-r,void 0!==g&&Math.abs(s)<g&&(s=g,o=f>=0&&!h||f<0&&h?r-g:r+g),{size:s,base:r,head:o,center:o+s/2}},calculateBarIndexPixels:function(t,e,i){var n=i.scale.options,a="flex"===n.barThickness?function(t,e,i){var n,a=e.pixels,r=a[t],o=t>0?a[t-1]:null,s=t<a.length-1?a[t+1]:null,l=i.categoryPercentage;return null===o&&(o=r-(null===s?e.end-e.start:s-r)),null===s&&(s=r+r-o),n=r-(r-Math.min(o,s))/2*l,{chunk:Math.abs(s-o)/2*l/e.stackCount,ratio:i.barPercentage,start:n}}(e,i,n):function(t,e,i){var n,a,r=i.barThickness,o=e.stackCount,s=e.pixels[t];return ut.isNullOrUndef(r)?(n=e.min*i.categoryPercentage,a=i.barPercentage):(n=r*o,a=1),{chunk:n/o,ratio:a,start:s-n/2}}(e,i,n),r=this.getStackIndex(t,this.getMeta().stack),o=a.start+a.chunk*r+a.chunk/2,s=Math.min(ut.valueOrDefault(n.maxBarThickness,1/0),a.chunk*a.ratio);return{base:o-s/2,head:o+s/2,center:o,size:s}},draw:function(){var t=this.chart,e=this._getValueScale(),i=this.getMeta().data,n=this.getDataset(),a=i.length,r=0;for(ut.canvas.clipArea(t.ctx,t.chartArea);r<a;++r)isNaN(e.getRightValue(n.data[r]))||i[r].draw();ut.canvas.unclipArea(t.ctx)},_resolveElementOptions:function(t,e){var i,n,a,r=this.chart,o=r.data.datasets[this.index],s=t.custom||{},l=r.options.elements.rectangle,u={},d={chart:r,dataIndex:e,dataset:o,datasetIndex:this.index},h=["backgroundColor","borderColor","borderSkipped","borderWidth"];for(i=0,n=h.length;i<n;++i)u[a=h[i]]=Bt([s[a],o[a],l[a]],d,e);return u}}),Ut=ut.valueOrDefault,Gt=ut.options.resolve;ot._set("bubble",{hover:{mode:"single"},scales:{xAxes:[{type:"linear",position:"bottom",id:"x-axis-0"}],yAxes:[{type:"linear",position:"left",id:"y-axis-0"}]},tooltips:{callbacks:{title:function(){return""},label:function(t,e){var i=e.datasets[t.datasetIndex].label||"",n=e.datasets[t.datasetIndex].data[t.index];return i+": ("+t.xLabel+", "+t.yLabel+", "+n.r+")"}}}});var qt=kt.extend({dataElementType:Nt.Point,update:function(t){var e=this,i=e.getMeta().data;ut.each(i,function(i,n){e.updateElement(i,n,t)})},updateElement:function(t,e,i){var n=this,a=n.getMeta(),r=t.custom||{},o=n.getScaleForId(a.xAxisID),s=n.getScaleForId(a.yAxisID),l=n._resolveElementOptions(t,e),u=n.getDataset().data[e],d=n.index,h=i?o.getPixelForDecimal(.5):o.getPixelForValue("object"==typeof u?u:NaN,e,d),c=i?s.getBasePixel():s.getPixelForValue(u,e,d);t._xScale=o,t._yScale=s,t._options=l,t._datasetIndex=d,t._index=e,t._model={backgroundColor:l.backgroundColor,borderColor:l.borderColor,borderWidth:l.borderWidth,hitRadius:l.hitRadius,pointStyle:l.pointStyle,rotation:l.rotation,radius:i?0:l.radius,skip:r.skip||isNaN(h)||isNaN(c),x:h,y:c},t.pivot()},setHoverStyle:function(t){var e=t._model,i=t._options,n=ut.getHoverColor;t.$previousStyle={backgroundColor:e.backgroundColor,borderColor:e.borderColor,borderWidth:e.borderWidth,radius:e.radius},e.backgroundColor=Ut(i.hoverBackgroundColor,n(i.backgroundColor)),e.borderColor=Ut(i.hoverBorderColor,n(i.borderColor)),e.borderWidth=Ut(i.hoverBorderWidth,i.borderWidth),e.radius=i.radius+i.hoverRadius},_resolveElementOptions:function(t,e){var i,n,a,r=this.chart,o=r.data.datasets[this.index],s=t.custom||{},l=r.options.elements.point,u=o.data[e],d={},h={chart:r,dataIndex:e,dataset:o,datasetIndex:this.index},c=["backgroundColor","borderColor","borderWidth","hoverBackgroundColor","hoverBorderColor","hoverBorderWidth","hoverRadius","hitRadius","pointStyle","rotation"];for(i=0,n=c.length;i<n;++i)d[a=c[i]]=Gt([s[a],o[a],l[a]],h,e);return d.radius=Gt([s.radius,u?u.r:void 0,o.radius,l.radius],h,e),d}}),Zt=ut.options.resolve,$t=ut.valueOrDefault;ot._set("doughnut",{animation:{animateRotate:!0,animateScale:!1},hover:{mode:"single"},legendCallback:function(t){var e=[];e.push('<ul class="'+t.id+'-legend">');var i=t.data,n=i.datasets,a=i.labels;if(n.length)for(var r=0;r<n[0].data.length;++r)e.push('<li><span style="background-color:'+n[0].backgroundColor[r]+'"></span>'),a[r]&&e.push(a[r]),e.push("</li>");return e.push("</ul>"),e.join("")},legend:{labels:{generateLabels:function(t){var e=t.data;return e.labels.length&&e.datasets.length?e.labels.map(function(i,n){var a=t.getDatasetMeta(0),r=e.datasets[0],o=a.data[n],s=o&&o.custom||{},l=t.options.elements.arc;return{text:i,fillStyle:Zt([s.backgroundColor,r.backgroundColor,l.backgroundColor],void 0,n),strokeStyle:Zt([s.borderColor,r.borderColor,l.borderColor],void 0,n),lineWidth:Zt([s.borderWidth,r.borderWidth,l.borderWidth],void 0,n),hidden:isNaN(r.data[n])||a.data[n].hidden,index:n}}):[]}},onClick:function(t,e){var i,n,a,r=e.index,o=this.chart;for(i=0,n=(o.data.datasets||[]).length;i<n;++i)(a=o.getDatasetMeta(i)).data[r]&&(a.data[r].hidden=!a.data[r].hidden);o.update()}},cutoutPercentage:50,rotation:-.5*Math.PI,circumference:2*Math.PI,tooltips:{callbacks:{title:function(){return""},label:function(t,e){var i=e.labels[t.index],n=": "+e.datasets[t.datasetIndex].data[t.index];return ut.isArray(i)?(i=i.slice())[0]+=n:i+=n,i}}}});var Xt=kt.extend({dataElementType:Nt.Arc,linkScales:ut.noop,getRingIndex:function(t){for(var e=0,i=0;i<t;++i)this.chart.isDatasetVisible(i)&&++e;return e},update:function(t){var e,i,n=this,a=n.chart,r=a.chartArea,o=a.options,s=r.right-r.left,l=r.bottom-r.top,u=Math.min(s,l),d={x:0,y:0},h=n.getMeta(),c=h.data,f=o.cutoutPercentage,g=o.circumference,m=n._getRingWeight(n.index);if(g<2*Math.PI){var p=o.rotation%(2*Math.PI),v=(p+=2*Math.PI*(p>=Math.PI?-1:p<-Math.PI?1:0))+g,y={x:Math.cos(p),y:Math.sin(p)},b={x:Math.cos(v),y:Math.sin(v)},x=p<=0&&v>=0||p<=2*Math.PI&&2*Math.PI<=v,_=p<=.5*Math.PI&&.5*Math.PI<=v||p<=2.5*Math.PI&&2.5*Math.PI<=v,k=p<=-Math.PI&&-Math.PI<=v||p<=Math.PI&&Math.PI<=v,w=p<=.5*-Math.PI&&.5*-Math.PI<=v||p<=1.5*Math.PI&&1.5*Math.PI<=v,M=f/100,S={x:k?-1:Math.min(y.x*(y.x<0?1:M),b.x*(b.x<0?1:M)),y:w?-1:Math.min(y.y*(y.y<0?1:M),b.y*(b.y<0?1:M))},D={x:x?1:Math.max(y.x*(y.x>0?1:M),b.x*(b.x>0?1:M)),y:_?1:Math.max(y.y*(y.y>0?1:M),b.y*(b.y>0?1:M))},C={width:.5*(D.x-S.x),height:.5*(D.y-S.y)};u=Math.min(s/C.width,l/C.height),d={x:-.5*(D.x+S.x),y:-.5*(D.y+S.y)}}for(e=0,i=c.length;e<i;++e)c[e]._options=n._resolveElementOptions(c[e],e);for(a.borderWidth=n.getMaxBorderWidth(),a.outerRadius=Math.max((u-a.borderWidth)/2,0),a.innerRadius=Math.max(f?a.outerRadius/100*f:0,0),a.radiusLength=(a.outerRadius-a.innerRadius)/(n._getVisibleDatasetWeightTotal()||1),a.offsetX=d.x*a.outerRadius,a.offsetY=d.y*a.outerRadius,h.total=n.calculateTotal(),n.outerRadius=a.outerRadius-a.radiusLength*n._getRingWeightOffset(n.index),n.innerRadius=Math.max(n.outerRadius-a.radiusLength*m,0),e=0,i=c.length;e<i;++e)n.updateElement(c[e],e,t)},updateElement:function(t,e,i){var n=this,a=n.chart,r=a.chartArea,o=a.options,s=o.animation,l=(r.left+r.right)/2,u=(r.top+r.bottom)/2,d=o.rotation,h=o.rotation,c=n.getDataset(),f=i&&s.animateRotate?0:t.hidden?0:n.calculateCircumference(c.data[e])*(o.circumference/(2*Math.PI)),g=i&&s.animateScale?0:n.innerRadius,m=i&&s.animateScale?0:n.outerRadius,p=t._options||{};ut.extend(t,{_datasetIndex:n.index,_index:e,_model:{backgroundColor:p.backgroundColor,borderColor:p.borderColor,borderWidth:p.borderWidth,borderAlign:p.borderAlign,x:l+a.offsetX,y:u+a.offsetY,startAngle:d,endAngle:h,circumference:f,outerRadius:m,innerRadius:g,label:ut.valueAtIndexOrDefault(c.label,e,a.data.labels[e])}});var v=t._model;i&&s.animateRotate||(v.startAngle=0===e?o.rotation:n.getMeta().data[e-1]._model.endAngle,v.endAngle=v.startAngle+v.circumference),t.pivot()},calculateTotal:function(){var t,e=this.getDataset(),i=this.getMeta(),n=0;return ut.each(i.data,function(i,a){t=e.data[a],isNaN(t)||i.hidden||(n+=Math.abs(t))}),n},calculateCircumference:function(t){var e=this.getMeta().total;return e>0&&!isNaN(t)?2*Math.PI*(Math.abs(t)/e):0},getMaxBorderWidth:function(t){var e,i,n,a,r,o,s,l,u=0,d=this.chart;if(!t)for(e=0,i=d.data.datasets.length;e<i;++e)if(d.isDatasetVisible(e)){t=(n=d.getDatasetMeta(e)).data,e!==this.index&&(r=n.controller);break}if(!t)return 0;for(e=0,i=t.length;e<i;++e)a=t[e],"inner"!==(o=r?r._resolveElementOptions(a,e):a._options).borderAlign&&(s=o.borderWidth,u=(l=o.hoverBorderWidth)>(u=s>u?s:u)?l:u);return u},setHoverStyle:function(t){var e=t._model,i=t._options,n=ut.getHoverColor;t.$previousStyle={backgroundColor:e.backgroundColor,borderColor:e.borderColor,borderWidth:e.borderWidth},e.backgroundColor=$t(i.hoverBackgroundColor,n(i.backgroundColor)),e.borderColor=$t(i.hoverBorderColor,n(i.borderColor)),e.borderWidth=$t(i.hoverBorderWidth,i.borderWidth)},_resolveElementOptions:function(t,e){var i,n,a,r=this.chart,o=this.getDataset(),s=t.custom||{},l=r.options.elements.arc,u={},d={chart:r,dataIndex:e,dataset:o,datasetIndex:this.index},h=["backgroundColor","borderColor","borderWidth","borderAlign","hoverBackgroundColor","hoverBorderColor","hoverBorderWidth"];for(i=0,n=h.length;i<n;++i)u[a=h[i]]=Zt([s[a],o[a],l[a]],d,e);return u},_getRingWeightOffset:function(t){for(var e=0,i=0;i<t;++i)this.chart.isDatasetVisible(i)&&(e+=this._getRingWeight(i));return e},_getRingWeight:function(t){return Math.max($t(this.chart.data.datasets[t].weight,1),0)},_getVisibleDatasetWeightTotal:function(){return this._getRingWeightOffset(this.chart.data.datasets.length)}});ot._set("horizontalBar",{hover:{mode:"index",axis:"y"},scales:{xAxes:[{type:"linear",position:"bottom"}],yAxes:[{type:"category",position:"left",categoryPercentage:.8,barPercentage:.9,offset:!0,gridLines:{offsetGridLines:!0}}]},elements:{rectangle:{borderSkipped:"left"}},tooltips:{mode:"index",axis:"y"}});var Kt=jt.extend({_getValueScaleId:function(){return this.getMeta().xAxisID},_getIndexScaleId:function(){return this.getMeta().yAxisID}}),Jt=ut.valueOrDefault,Qt=ut.options.resolve,te=ut.canvas._isPointInArea;function ee(t,e){return Jt(t.showLine,e.showLines)}ot._set("line",{showLines:!0,spanGaps:!1,hover:{mode:"label"},scales:{xAxes:[{type:"category",id:"x-axis-0"}],yAxes:[{type:"linear",id:"y-axis-0"}]}});var ie=kt.extend({datasetElementType:Nt.Line,dataElementType:Nt.Point,update:function(t){var e,i,n=this,a=n.getMeta(),r=a.dataset,o=a.data||[],s=n.getScaleForId(a.yAxisID),l=n.getDataset(),u=ee(l,n.chart.options);for(u&&(void 0!==l.tension&&void 0===l.lineTension&&(l.lineTension=l.tension),r._scale=s,r._datasetIndex=n.index,r._children=o,r._model=n._resolveLineOptions(r),r.pivot()),e=0,i=o.length;e<i;++e)n.updateElement(o[e],e,t);for(u&&0!==r._model.tension&&n.updateBezierControlPoints(),e=0,i=o.length;e<i;++e)o[e].pivot()},updateElement:function(t,e,i){var n,a,r=this,o=r.getMeta(),s=t.custom||{},l=r.getDataset(),u=r.index,d=l.data[e],h=r.getScaleForId(o.yAxisID),c=r.getScaleForId(o.xAxisID),f=o.dataset._model,g=r._resolvePointOptions(t,e);n=c.getPixelForValue("object"==typeof d?d:NaN,e,u),a=i?h.getBasePixel():r.calculatePointY(d,e,u),t._xScale=c,t._yScale=h,t._options=g,t._datasetIndex=u,t._index=e,t._model={x:n,y:a,skip:s.skip||isNaN(n)||isNaN(a),radius:g.radius,pointStyle:g.pointStyle,rotation:g.rotation,backgroundColor:g.backgroundColor,borderColor:g.borderColor,borderWidth:g.borderWidth,tension:Jt(s.tension,f?f.tension:0),steppedLine:!!f&&f.steppedLine,hitRadius:g.hitRadius}},_resolvePointOptions:function(t,e){var i,n,a,r=this.chart,o=r.data.datasets[this.index],s=t.custom||{},l=r.options.elements.point,u={},d={chart:r,dataIndex:e,dataset:o,datasetIndex:this.index},h={backgroundColor:"pointBackgroundColor",borderColor:"pointBorderColor",borderWidth:"pointBorderWidth",hitRadius:"pointHitRadius",hoverBackgroundColor:"pointHoverBackgroundColor",hoverBorderColor:"pointHoverBorderColor",hoverBorderWidth:"pointHoverBorderWidth",hoverRadius:"pointHoverRadius",pointStyle:"pointStyle",radius:"pointRadius",rotation:"pointRotation"},c=Object.keys(h);for(i=0,n=c.length;i<n;++i)u[a=c[i]]=Qt([s[a],o[h[a]],o[a],l[a]],d,e);return u},_resolveLineOptions:function(t){var e,i,n,a=this.chart,r=a.data.datasets[this.index],o=t.custom||{},s=a.options,l=s.elements.line,u={},d=["backgroundColor","borderWidth","borderColor","borderCapStyle","borderDash","borderDashOffset","borderJoinStyle","fill","cubicInterpolationMode"];for(e=0,i=d.length;e<i;++e)u[n=d[e]]=Qt([o[n],r[n],l[n]]);return u.spanGaps=Jt(r.spanGaps,s.spanGaps),u.tension=Jt(r.lineTension,l.tension),u.steppedLine=Qt([o.steppedLine,r.steppedLine,l.stepped]),u},calculatePointY:function(t,e,i){var n,a,r,o=this.chart,s=this.getMeta(),l=this.getScaleForId(s.yAxisID),u=0,d=0;if(l.options.stacked){for(n=0;n<i;n++)if(a=o.data.datasets[n],"line"===(r=o.getDatasetMeta(n)).type&&r.yAxisID===l.id&&o.isDatasetVisible(n)){var h=Number(l.getRightValue(a.data[e]));h<0?d+=h||0:u+=h||0}var c=Number(l.getRightValue(t));return c<0?l.getPixelForValue(d+c):l.getPixelForValue(u+c)}return l.getPixelForValue(t)},updateBezierControlPoints:function(){var t,e,i,n,a=this.chart,r=this.getMeta(),o=r.dataset._model,s=a.chartArea,l=r.data||[];function u(t,e,i){return Math.max(Math.min(t,i),e)}if(o.spanGaps&&(l=l.filter(function(t){return!t._model.skip})),"monotone"===o.cubicInterpolationMode)ut.splineCurveMonotone(l);else for(t=0,e=l.length;t<e;++t)i=l[t]._model,n=ut.splineCurve(ut.previousItem(l,t)._model,i,ut.nextItem(l,t)._model,o.tension),i.controlPointPreviousX=n.previous.x,i.controlPointPreviousY=n.previous.y,i.controlPointNextX=n.next.x,i.controlPointNextY=n.next.y;if(a.options.elements.line.capBezierPoints)for(t=0,e=l.length;t<e;++t)i=l[t]._model,te(i,s)&&(t>0&&te(l[t-1]._model,s)&&(i.controlPointPreviousX=u(i.controlPointPreviousX,s.left,s.right),i.controlPointPreviousY=u(i.controlPointPreviousY,s.top,s.bottom)),t<l.length-1&&te(l[t+1]._model,s)&&(i.controlPointNextX=u(i.controlPointNextX,s.left,s.right),i.controlPointNextY=u(i.controlPointNextY,s.top,s.bottom)))},draw:function(){var t,e=this.chart,i=this.getMeta(),n=i.data||[],a=e.chartArea,r=n.length,o=0;for(ee(this.getDataset(),e.options)&&(t=(i.dataset._model.borderWidth||0)/2,ut.canvas.clipArea(e.ctx,{left:a.left,right:a.right,top:a.top-t,bottom:a.bottom+t}),i.dataset.draw(),ut.canvas.unclipArea(e.ctx));o<r;++o)n[o].draw(a)},setHoverStyle:function(t){var e=t._model,i=t._options,n=ut.getHoverColor;t.$previousStyle={backgroundColor:e.backgroundColor,borderColor:e.borderColor,borderWidth:e.borderWidth,radius:e.radius},e.backgroundColor=Jt(i.hoverBackgroundColor,n(i.backgroundColor)),e.borderColor=Jt(i.hoverBorderColor,n(i.borderColor)),e.borderWidth=Jt(i.hoverBorderWidth,i.borderWidth),e.radius=Jt(i.hoverRadius,i.radius)}}),ne=ut.options.resolve;ot._set("polarArea",{scale:{type:"radialLinear",angleLines:{display:!1},gridLines:{circular:!0},pointLabels:{display:!1},ticks:{beginAtZero:!0}},animation:{animateRotate:!0,animateScale:!0},startAngle:-.5*Math.PI,legendCallback:function(t){var e=[];e.push('<ul class="'+t.id+'-legend">');var i=t.data,n=i.datasets,a=i.labels;if(n.length)for(var r=0;r<n[0].data.length;++r)e.push('<li><span style="background-color:'+n[0].backgroundColor[r]+'"></span>'),a[r]&&e.push(a[r]),e.push("</li>");return e.push("</ul>"),e.join("")},legend:{labels:{generateLabels:function(t){var e=t.data;return e.labels.length&&e.datasets.length?e.labels.map(function(i,n){var a=t.getDatasetMeta(0),r=e.datasets[0],o=a.data[n].custom||{},s=t.options.elements.arc;return{text:i,fillStyle:ne([o.backgroundColor,r.backgroundColor,s.backgroundColor],void 0,n),strokeStyle:ne([o.borderColor,r.borderColor,s.borderColor],void 0,n),lineWidth:ne([o.borderWidth,r.borderWidth,s.borderWidth],void 0,n),hidden:isNaN(r.data[n])||a.data[n].hidden,index:n}}):[]}},onClick:function(t,e){var i,n,a,r=e.index,o=this.chart;for(i=0,n=(o.data.datasets||[]).length;i<n;++i)(a=o.getDatasetMeta(i)).data[r].hidden=!a.data[r].hidden;o.update()}},tooltips:{callbacks:{title:function(){return""},label:function(t,e){return e.labels[t.index]+": "+t.yLabel}}}});var ae=kt.extend({dataElementType:Nt.Arc,linkScales:ut.noop,update:function(t){var e,i,n,a=this,r=a.getDataset(),o=a.getMeta(),s=a.chart.options.startAngle||0,l=a._starts=[],u=a._angles=[],d=o.data;for(a._updateRadius(),o.count=a.countVisibleElements(),e=0,i=r.data.length;e<i;e++)l[e]=s,n=a._computeAngle(e),u[e]=n,s+=n;for(e=0,i=d.length;e<i;++e)d[e]._options=a._resolveElementOptions(d[e],e),a.updateElement(d[e],e,t)},_updateRadius:function(){var t=this,e=t.chart,i=e.chartArea,n=e.options,a=Math.min(i.right-i.left,i.bottom-i.top);e.outerRadius=Math.max(a/2,0),e.innerRadius=Math.max(n.cutoutPercentage?e.outerRadius/100*n.cutoutPercentage:1,0),e.radiusLength=(e.outerRadius-e.innerRadius)/e.getVisibleDatasetCount(),t.outerRadius=e.outerRadius-e.radiusLength*t.index,t.innerRadius=t.outerRadius-e.radiusLength},updateElement:function(t,e,i){var n=this,a=n.chart,r=n.getDataset(),o=a.options,s=o.animation,l=a.scale,u=a.data.labels,d=l.xCenter,h=l.yCenter,c=o.startAngle,f=t.hidden?0:l.getDistanceFromCenterForValue(r.data[e]),g=n._starts[e],m=g+(t.hidden?0:n._angles[e]),p=s.animateScale?0:l.getDistanceFromCenterForValue(r.data[e]),v=t._options||{};ut.extend(t,{_datasetIndex:n.index,_index:e,_scale:l,_model:{backgroundColor:v.backgroundColor,borderColor:v.borderColor,borderWidth:v.borderWidth,borderAlign:v.borderAlign,x:d,y:h,innerRadius:0,outerRadius:i?p:f,startAngle:i&&s.animateRotate?c:g,endAngle:i&&s.animateRotate?c:m,label:ut.valueAtIndexOrDefault(u,e,u[e])}}),t.pivot()},countVisibleElements:function(){var t=this.getDataset(),e=this.getMeta(),i=0;return ut.each(e.data,function(e,n){isNaN(t.data[n])||e.hidden||i++}),i},setHoverStyle:function(t){var e=t._model,i=t._options,n=ut.getHoverColor,a=ut.valueOrDefault;t.$previousStyle={backgroundColor:e.backgroundColor,borderColor:e.borderColor,borderWidth:e.borderWidth},e.backgroundColor=a(i.hoverBackgroundColor,n(i.backgroundColor)),e.borderColor=a(i.hoverBorderColor,n(i.borderColor)),e.borderWidth=a(i.hoverBorderWidth,i.borderWidth)},_resolveElementOptions:function(t,e){var i,n,a,r=this.chart,o=this.getDataset(),s=t.custom||{},l=r.options.elements.arc,u={},d={chart:r,dataIndex:e,dataset:o,datasetIndex:this.index},h=["backgroundColor","borderColor","borderWidth","borderAlign","hoverBackgroundColor","hoverBorderColor","hoverBorderWidth"];for(i=0,n=h.length;i<n;++i)u[a=h[i]]=ne([s[a],o[a],l[a]],d,e);return u},_computeAngle:function(t){var e=this,i=this.getMeta().count,n=e.getDataset(),a=e.getMeta();if(isNaN(n.data[t])||a.data[t].hidden)return 0;var r={chart:e.chart,dataIndex:t,dataset:n,datasetIndex:e.index};return ne([e.chart.options.elements.arc.angle,2*Math.PI/i],r,t)}});ot._set("pie",ut.clone(ot.doughnut)),ot._set("pie",{cutoutPercentage:0});var re=Xt,oe=ut.valueOrDefault,se=ut.options.resolve;ot._set("radar",{scale:{type:"radialLinear"},elements:{line:{tension:0}}});var le=kt.extend({datasetElementType:Nt.Line,dataElementType:Nt.Point,linkScales:ut.noop,update:function(t){var e,i,n=this,a=n.getMeta(),r=a.dataset,o=a.data||[],s=n.chart.scale,l=n.getDataset();for(void 0!==l.tension&&void 0===l.lineTension&&(l.lineTension=l.tension),r._scale=s,r._datasetIndex=n.index,r._children=o,r._loop=!0,r._model=n._resolveLineOptions(r),r.pivot(),e=0,i=o.length;e<i;++e)n.updateElement(o[e],e,t);for(n.updateBezierControlPoints(),e=0,i=o.length;e<i;++e)o[e].pivot()},updateElement:function(t,e,i){var n=this,a=t.custom||{},r=n.getDataset(),o=n.chart.scale,s=o.getPointPositionForValue(e,r.data[e]),l=n._resolvePointOptions(t,e),u=n.getMeta().dataset._model,d=i?o.xCenter:s.x,h=i?o.yCenter:s.y;t._scale=o,t._options=l,t._datasetIndex=n.index,t._index=e,t._model={x:d,y:h,skip:a.skip||isNaN(d)||isNaN(h),radius:l.radius,pointStyle:l.pointStyle,rotation:l.rotation,backgroundColor:l.backgroundColor,borderColor:l.borderColor,borderWidth:l.borderWidth,tension:oe(a.tension,u?u.tension:0),hitRadius:l.hitRadius}},_resolvePointOptions:function(t,e){var i,n,a,r=this.chart,o=r.data.datasets[this.index],s=t.custom||{},l=r.options.elements.point,u={},d={chart:r,dataIndex:e,dataset:o,datasetIndex:this.index},h={backgroundColor:"pointBackgroundColor",borderColor:"pointBorderColor",borderWidth:"pointBorderWidth",hitRadius:"pointHitRadius",hoverBackgroundColor:"pointHoverBackgroundColor",hoverBorderColor:"pointHoverBorderColor",hoverBorderWidth:"pointHoverBorderWidth",hoverRadius:"pointHoverRadius",pointStyle:"pointStyle",radius:"pointRadius",rotation:"pointRotation"},c=Object.keys(h);for(i=0,n=c.length;i<n;++i)u[a=c[i]]=se([s[a],o[h[a]],o[a],l[a]],d,e);return u},_resolveLineOptions:function(t){var e,i,n,a=this.chart,r=a.data.datasets[this.index],o=t.custom||{},s=a.options.elements.line,l={},u=["backgroundColor","borderWidth","borderColor","borderCapStyle","borderDash","borderDashOffset","borderJoinStyle","fill"];for(e=0,i=u.length;e<i;++e)l[n=u[e]]=se([o[n],r[n],s[n]]);return l.tension=oe(r.lineTension,s.tension),l},updateBezierControlPoints:function(){var t,e,i,n,a=this.getMeta(),r=this.chart.chartArea,o=a.data||[];function s(t,e,i){return Math.max(Math.min(t,i),e)}for(t=0,e=o.length;t<e;++t)i=o[t]._model,n=ut.splineCurve(ut.previousItem(o,t,!0)._model,i,ut.nextItem(o,t,!0)._model,i.tension),i.controlPointPreviousX=s(n.previous.x,r.left,r.right),i.controlPointPreviousY=s(n.previous.y,r.top,r.bottom),i.controlPointNextX=s(n.next.x,r.left,r.right),i.controlPointNextY=s(n.next.y,r.top,r.bottom)},setHoverStyle:function(t){var e=t._model,i=t._options,n=ut.getHoverColor;t.$previousStyle={backgroundColor:e.backgroundColor,borderColor:e.borderColor,borderWidth:e.borderWidth,radius:e.radius},e.backgroundColor=oe(i.hoverBackgroundColor,n(i.backgroundColor)),e.borderColor=oe(i.hoverBorderColor,n(i.borderColor)),e.borderWidth=oe(i.hoverBorderWidth,i.borderWidth),e.radius=oe(i.hoverRadius,i.radius)}});ot._set("scatter",{hover:{mode:"single"},scales:{xAxes:[{id:"x-axis-1",type:"linear",position:"bottom"}],yAxes:[{id:"y-axis-1",type:"linear",position:"left"}]},showLines:!1,tooltips:{callbacks:{title:function(){return""},label:function(t){return"("+t.xLabel+", "+t.yLabel+")"}}}});var ue={bar:jt,bubble:qt,doughnut:Xt,horizontalBar:Kt,line:ie,polarArea:ae,pie:re,radar:le,scatter:ie};function de(t,e){return t.native?{x:t.x,y:t.y}:ut.getRelativePosition(t,e)}function he(t,e){var i,n,a,r,o;for(n=0,r=t.data.datasets.length;n<r;++n)if(t.isDatasetVisible(n))for(a=0,o=(i=t.getDatasetMeta(n)).data.length;a<o;++a){var s=i.data[a];s._view.skip||e(s)}}function ce(t,e){var i=[];return he(t,function(t){t.inRange(e.x,e.y)&&i.push(t)}),i}function fe(t,e,i,n){var a=Number.POSITIVE_INFINITY,r=[];return he(t,function(t){if(!i||t.inRange(e.x,e.y)){var o=t.getCenterPoint(),s=n(e,o);s<a?(r=[t],a=s):s===a&&r.push(t)}}),r}function ge(t){var e=-1!==t.indexOf("x"),i=-1!==t.indexOf("y");return function(t,n){var a=e?Math.abs(t.x-n.x):0,r=i?Math.abs(t.y-n.y):0;return Math.sqrt(Math.pow(a,2)+Math.pow(r,2))}}function me(t,e,i){var n=de(e,t);i.axis=i.axis||"x";var a=ge(i.axis),r=i.intersect?ce(t,n):fe(t,n,!1,a),o=[];return r.length?(t.data.datasets.forEach(function(e,i){if(t.isDatasetVisible(i)){var n=t.getDatasetMeta(i).data[r[0]._index];n&&!n._view.skip&&o.push(n)}}),o):[]}var pe={modes:{single:function(t,e){var i=de(e,t),n=[];return he(t,function(t){if(t.inRange(i.x,i.y))return n.push(t),n}),n.slice(0,1)},label:me,index:me,dataset:function(t,e,i){var n=de(e,t);i.axis=i.axis||"xy";var a=ge(i.axis),r=i.intersect?ce(t,n):fe(t,n,!1,a);return r.length>0&&(r=t.getDatasetMeta(r[0]._datasetIndex).data),r},"x-axis":function(t,e){return me(t,e,{intersect:!1})},point:function(t,e){return ce(t,de(e,t))},nearest:function(t,e,i){var n=de(e,t);i.axis=i.axis||"xy";var a=ge(i.axis);return fe(t,n,i.intersect,a)},x:function(t,e,i){var n=de(e,t),a=[],r=!1;return he(t,function(t){t.inXRange(n.x)&&a.push(t),t.inRange(n.x,n.y)&&(r=!0)}),i.intersect&&!r&&(a=[]),a},y:function(t,e,i){var n=de(e,t),a=[],r=!1;return he(t,function(t){t.inYRange(n.y)&&a.push(t),t.inRange(n.x,n.y)&&(r=!0)}),i.intersect&&!r&&(a=[]),a}}};function ve(t,e){return ut.where(t,function(t){return t.position===e})}function ye(t,e){t.forEach(function(t,e){return t._tmpIndex_=e,t}),t.sort(function(t,i){var n=e?i:t,a=e?t:i;return n.weight===a.weight?n._tmpIndex_-a._tmpIndex_:n.weight-a.weight}),t.forEach(function(t){delete t._tmpIndex_})}function be(t,e){ut.each(t,function(t){e[t.position]+=t.isHorizontal()?t.height:t.width})}ot._set("global",{layout:{padding:{top:0,right:0,bottom:0,left:0}}});var xe={defaults:{},addBox:function(t,e){t.boxes||(t.boxes=[]),e.fullWidth=e.fullWidth||!1,e.position=e.position||"top",e.weight=e.weight||0,t.boxes.push(e)},removeBox:function(t,e){var i=t.boxes?t.boxes.indexOf(e):-1;-1!==i&&t.boxes.splice(i,1)},configure:function(t,e,i){for(var n,a=["fullWidth","position","weight"],r=a.length,o=0;o<r;++o)n=a[o],i.hasOwnProperty(n)&&(e[n]=i[n])},update:function(t,e,i){if(t){var n=t.options.layout||{},a=ut.options.toPadding(n.padding),r=a.left,o=a.right,s=a.top,l=a.bottom,u=ve(t.boxes,"left"),d=ve(t.boxes,"right"),h=ve(t.boxes,"top"),c=ve(t.boxes,"bottom"),f=ve(t.boxes,"chartArea");ye(u,!0),ye(d,!1),ye(h,!0),ye(c,!1);var g,m=u.concat(d),p=h.concat(c),v=m.concat(p),y=e-r-o,b=i-s-l,x=(e-y/2)/m.length,_=y,k=b,w={top:s,left:r,bottom:l,right:o},M=[];ut.each(v,function(t){var e,i=t.isHorizontal();i?(e=t.update(t.fullWidth?y:_,b/2),k-=e.height):(e=t.update(x,k),_-=e.width),M.push({horizontal:i,width:e.width,box:t})}),g=function(t){var e=0,i=0,n=0,a=0;return ut.each(t,function(t){if(t.getPadding){var r=t.getPadding();e=Math.max(e,r.top),i=Math.max(i,r.left),n=Math.max(n,r.bottom),a=Math.max(a,r.right)}}),{top:e,left:i,bottom:n,right:a}}(v),ut.each(m,I),be(m,w),ut.each(p,I),be(p,w),ut.each(m,function(t){var e=ut.findNextWhere(M,function(e){return e.box===t}),i={left:0,right:0,top:w.top,bottom:w.bottom};e&&t.update(e.width,k,i)}),be(v,w={top:s,left:r,bottom:l,right:o});var S=Math.max(g.left-w.left,0);w.left+=S,w.right+=Math.max(g.right-w.right,0);var D=Math.max(g.top-w.top,0);w.top+=D,w.bottom+=Math.max(g.bottom-w.bottom,0);var C=i-w.top-w.bottom,P=e-w.left-w.right;P===_&&C===k||(ut.each(m,function(t){t.height=C}),ut.each(p,function(t){t.fullWidth||(t.width=P)}),k=C,_=P);var T=r+S,O=s+D;ut.each(u.concat(h),A),T+=_,O+=k,ut.each(d,A),ut.each(c,A),t.chartArea={left:w.left,top:w.top,right:w.left+_,bottom:w.top+k},ut.each(f,function(e){e.left=t.chartArea.left,e.top=t.chartArea.top,e.right=t.chartArea.right,e.bottom=t.chartArea.bottom,e.update(_,k)})}function I(t){var e=ut.findNextWhere(M,function(e){return e.box===t});if(e)if(e.horizontal){var i={left:Math.max(w.left,g.left),right:Math.max(w.right,g.right),top:0,bottom:0};t.update(t.fullWidth?y:_,b/2,i)}else t.update(e.width,k)}function A(t){t.isHorizontal()?(t.left=t.fullWidth?r:w.left,t.right=t.fullWidth?e-o:w.left+_,t.top=O,t.bottom=O+t.height,O=t.bottom):(t.left=T,t.right=T+t.width,t.top=w.top,t.bottom=w.top+k,T=t.right)}}};"undefined"!=typeof window?window:"undefined"!=typeof global?global:"undefined"!=typeof self&&self;function _e(){throw new Error("Dynamic requires are not currently supported by rollup-plugin-commonjs")}var ke,we=(ke=Object.freeze({default:"@keyframes chartjs-render-animation{from{opacity:.99}to{opacity:1}}.chartjs-render-monitor{animation:chartjs-render-animation 1ms}.chartjs-size-monitor,.chartjs-size-monitor-expand,.chartjs-size-monitor-shrink{position:absolute;direction:ltr;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1}.chartjs-size-monitor-expand>div{position:absolute;width:1000000px;height:1000000px;left:0;top:0}.chartjs-size-monitor-shrink>div{position:absolute;width:200%;height:200%;left:0;top:0}"}))&&ke.default||ke,Me="$chartjs",Se="chartjs-size-monitor",De="chartjs-render-monitor",Ce="chartjs-render-animation",Pe=["animationstart","webkitAnimationStart"],Te={touchstart:"mousedown",touchmove:"mousemove",touchend:"mouseup",pointerenter:"mouseenter",pointerdown:"mousedown",pointermove:"mousemove",pointerup:"mouseup",pointerleave:"mouseout",pointerout:"mouseout"};function Oe(t,e){var i=ut.getStyle(t,e),n=i&&i.match(/^(\d+)(\.\d+)?px$/);return n?Number(n[1]):void 0}var Ie=!!function(){var t=!1;try{var e=Object.defineProperty({},"passive",{get:function(){t=!0}});window.addEventListener("e",null,e)}catch(t){}return t}()&&{passive:!0};function Ae(t,e,i){t.addEventListener(e,i,Ie)}function Fe(t,e,i){t.removeEventListener(e,i,Ie)}function Re(t,e,i,n,a){return{type:t,chart:e,native:a||null,x:void 0!==i?i:null,y:void 0!==n?n:null}}function Le(t){var e=document.createElement("div");return e.className=t||"",e}function We(t,e,i){var n,a,r,o,s=t[Me]||(t[Me]={}),l=s.resizer=function(t){var e=Le(Se),i=Le(Se+"-expand"),n=Le(Se+"-shrink");i.appendChild(Le()),n.appendChild(Le()),e.appendChild(i),e.appendChild(n),e._reset=function(){i.scrollLeft=1e6,i.scrollTop=1e6,n.scrollLeft=1e6,n.scrollTop=1e6};var a=function(){e._reset(),t()};return Ae(i,"scroll",a.bind(i,"expand")),Ae(n,"scroll",a.bind(n,"shrink")),e}((n=function(){if(s.resizer){var n=i.options.maintainAspectRatio&&t.parentNode,a=n?n.clientWidth:0;e(Re("resize",i)),n&&n.clientWidth<a&&i.canvas&&e(Re("resize",i))}},r=!1,o=[],function(){o=Array.prototype.slice.call(arguments),a=a||this,r||(r=!0,ut.requestAnimFrame.call(window,function(){r=!1,n.apply(a,o)}))}));!function(t,e){var i=t[Me]||(t[Me]={}),n=i.renderProxy=function(t){t.animationName===Ce&&e()};ut.each(Pe,function(e){Ae(t,e,n)}),i.reflow=!!t.offsetParent,t.classList.add(De)}(t,function(){if(s.resizer){var e=t.parentNode;e&&e!==l.parentNode&&e.insertBefore(l,e.firstChild),l._reset()}})}function Ye(t){var e=t[Me]||{},i=e.resizer;delete e.resizer,function(t){var e=t[Me]||{},i=e.renderProxy;i&&(ut.each(Pe,function(e){Fe(t,e,i)}),delete e.renderProxy),t.classList.remove(De)}(t),i&&i.parentNode&&i.parentNode.removeChild(i)}var Ne={disableCSSInjection:!1,_enabled:"undefined"!=typeof window&&"undefined"!=typeof document,_ensureLoaded:function(){var t,e,i;this._loaded||(this._loaded=!0,this.disableCSSInjection||(e=we,i=(t=this)._style||document.createElement("style"),t._style||(t._style=i,e="/* Chart.js */\n"+e,i.setAttribute("type","text/css"),document.getElementsByTagName("head")[0].appendChild(i)),i.appendChild(document.createTextNode(e))))},acquireContext:function(t,e){"string"==typeof t?t=document.getElementById(t):t.length&&(t=t[0]),t&&t.canvas&&(t=t.canvas);var i=t&&t.getContext&&t.getContext("2d");return this._ensureLoaded(),i&&i.canvas===t?(function(t,e){var i=t.style,n=t.getAttribute("height"),a=t.getAttribute("width");if(t[Me]={initial:{height:n,width:a,style:{display:i.display,height:i.height,width:i.width}}},i.display=i.display||"block",null===a||""===a){var r=Oe(t,"width");void 0!==r&&(t.width=r)}if(null===n||""===n)if(""===t.style.height)t.height=t.width/(e.options.aspectRatio||2);else{var o=Oe(t,"height");void 0!==r&&(t.height=o)}}(t,e),i):null},releaseContext:function(t){var e=t.canvas;if(e[Me]){var i=e[Me].initial;["height","width"].forEach(function(t){var n=i[t];ut.isNullOrUndef(n)?e.removeAttribute(t):e.setAttribute(t,n)}),ut.each(i.style||{},function(t,i){e.style[i]=t}),e.width=e.width,delete e[Me]}},addEventListener:function(t,e,i){var n=t.canvas;if("resize"!==e){var a=i[Me]||(i[Me]={});Ae(n,e,(a.proxies||(a.proxies={}))[t.id+"_"+e]=function(e){i(function(t,e){var i=Te[t.type]||t.type,n=ut.getRelativePosition(t,e);return Re(i,e,n.x,n.y,t)}(e,t))})}else We(n,i,t)},removeEventListener:function(t,e,i){var n=t.canvas;if("resize"!==e){var a=((i[Me]||{}).proxies||{})[t.id+"_"+e];a&&Fe(n,e,a)}else Ye(n)}};ut.addEvent=Ae,ut.removeEvent=Fe;var ze=Ne._enabled?Ne:{acquireContext:function(t){return t&&t.canvas&&(t=t.canvas),t&&t.getContext("2d")||null}},Ve=ut.extend({initialize:function(){},acquireContext:function(){},releaseContext:function(){},addEventListener:function(){},removeEventListener:function(){}},ze);ot._set("global",{plugins:{}});var He={_plugins:[],_cacheId:0,register:function(t){var e=this._plugins;[].concat(t).forEach(function(t){-1===e.indexOf(t)&&e.push(t)}),this._cacheId++},unregister:function(t){var e=this._plugins;[].concat(t).forEach(function(t){var i=e.indexOf(t);-1!==i&&e.splice(i,1)}),this._cacheId++},clear:function(){this._plugins=[],this._cacheId++},count:function(){return this._plugins.length},getAll:function(){return this._plugins},notify:function(t,e,i){var n,a,r,o,s,l=this.descriptors(t),u=l.length;for(n=0;n<u;++n)if("function"==typeof(s=(r=(a=l[n]).plugin)[e])&&((o=[t].concat(i||[])).push(a.options),!1===s.apply(r,o)))return!1;return!0},descriptors:function(t){var e=t.$plugins||(t.$plugins={});if(e.id===this._cacheId)return e.descriptors;var i=[],n=[],a=t&&t.config||{},r=a.options&&a.options.plugins||{};return this._plugins.concat(a.plugins||[]).forEach(function(t){if(-1===i.indexOf(t)){var e=t.id,a=r[e];!1!==a&&(!0===a&&(a=ut.clone(ot.global.plugins[e])),i.push(t),n.push({plugin:t,options:a||{}}))}}),e.descriptors=n,e.id=this._cacheId,n},_invalidate:function(t){delete t.$plugins}},Ee={constructors:{},defaults:{},registerScaleType:function(t,e,i){this.constructors[t]=e,this.defaults[t]=ut.clone(i)},getScaleConstructor:function(t){return this.constructors.hasOwnProperty(t)?this.constructors[t]:void 0},getScaleDefaults:function(t){return this.defaults.hasOwnProperty(t)?ut.merge({},[ot.scale,this.defaults[t]]):{}},updateScaleDefaults:function(t,e){this.defaults.hasOwnProperty(t)&&(this.defaults[t]=ut.extend(this.defaults[t],e))},addScalesToLayout:function(t){ut.each(t.scales,function(e){e.fullWidth=e.options.fullWidth,e.position=e.options.position,e.weight=e.options.weight,xe.addBox(t,e)})}},Be=ut.valueOrDefault;ot._set("global",{tooltips:{enabled:!0,custom:null,mode:"nearest",position:"average",intersect:!0,backgroundColor:"rgba(0,0,0,0.8)",titleFontStyle:"bold",titleSpacing:2,titleMarginBottom:6,titleFontColor:"#fff",titleAlign:"left",bodySpacing:2,bodyFontColor:"#fff",bodyAlign:"left",footerFontStyle:"bold",footerSpacing:2,footerMarginTop:6,footerFontColor:"#fff",footerAlign:"left",yPadding:6,xPadding:6,caretPadding:2,caretSize:5,cornerRadius:6,multiKeyBackground:"#fff",displayColors:!0,borderColor:"rgba(0,0,0,0)",borderWidth:0,callbacks:{beforeTitle:ut.noop,title:function(t,e){var i="",n=e.labels,a=n?n.length:0;if(t.length>0){var r=t[0];r.label?i=r.label:r.xLabel?i=r.xLabel:a>0&&r.index<a&&(i=n[r.index])}return i},afterTitle:ut.noop,beforeBody:ut.noop,beforeLabel:ut.noop,label:function(t,e){var i=e.datasets[t.datasetIndex].label||"";return i&&(i+=": "),ut.isNullOrUndef(t.value)?i+=t.yLabel:i+=t.value,i},labelColor:function(t,e){var i=e.getDatasetMeta(t.datasetIndex).data[t.index]._view;return{borderColor:i.borderColor,backgroundColor:i.backgroundColor}},labelTextColor:function(){return this._options.bodyFontColor},afterLabel:ut.noop,afterBody:ut.noop,beforeFooter:ut.noop,footer:ut.noop,afterFooter:ut.noop}}});var je={average:function(t){if(!t.length)return!1;var e,i,n=0,a=0,r=0;for(e=0,i=t.length;e<i;++e){var o=t[e];if(o&&o.hasValue()){var s=o.tooltipPosition();n+=s.x,a+=s.y,++r}}return{x:n/r,y:a/r}},nearest:function(t,e){var i,n,a,r=e.x,o=e.y,s=Number.POSITIVE_INFINITY;for(i=0,n=t.length;i<n;++i){var l=t[i];if(l&&l.hasValue()){var u=l.getCenterPoint(),d=ut.distanceBetweenPoints(e,u);d<s&&(s=d,a=l)}}if(a){var h=a.tooltipPosition();r=h.x,o=h.y}return{x:r,y:o}}};function Ue(t,e){return e&&(ut.isArray(e)?Array.prototype.push.apply(t,e):t.push(e)),t}function Ge(t){return("string"==typeof t||t instanceof String)&&t.indexOf("\n")>-1?t.split("\n"):t}function qe(t){var e=ot.global;return{xPadding:t.xPadding,yPadding:t.yPadding,xAlign:t.xAlign,yAlign:t.yAlign,bodyFontColor:t.bodyFontColor,_bodyFontFamily:Be(t.bodyFontFamily,e.defaultFontFamily),_bodyFontStyle:Be(t.bodyFontStyle,e.defaultFontStyle),_bodyAlign:t.bodyAlign,bodyFontSize:Be(t.bodyFontSize,e.defaultFontSize),bodySpacing:t.bodySpacing,titleFontColor:t.titleFontColor,_titleFontFamily:Be(t.titleFontFamily,e.defaultFontFamily),_titleFontStyle:Be(t.titleFontStyle,e.defaultFontStyle),titleFontSize:Be(t.titleFontSize,e.defaultFontSize),_titleAlign:t.titleAlign,titleSpacing:t.titleSpacing,titleMarginBottom:t.titleMarginBottom,footerFontColor:t.footerFontColor,_footerFontFamily:Be(t.footerFontFamily,e.defaultFontFamily),_footerFontStyle:Be(t.footerFontStyle,e.defaultFontStyle),footerFontSize:Be(t.footerFontSize,e.defaultFontSize),_footerAlign:t.footerAlign,footerSpacing:t.footerSpacing,footerMarginTop:t.footerMarginTop,caretSize:t.caretSize,cornerRadius:t.cornerRadius,backgroundColor:t.backgroundColor,opacity:0,legendColorBackground:t.multiKeyBackground,displayColors:t.displayColors,borderColor:t.borderColor,borderWidth:t.borderWidth}}function Ze(t,e){return"center"===e?t.x+t.width/2:"right"===e?t.x+t.width-t.xPadding:t.x+t.xPadding}function $e(t){return Ue([],Ge(t))}var Xe=gt.extend({initialize:function(){this._model=qe(this._options),this._lastActive=[]},getTitle:function(){var t=this._options.callbacks,e=t.beforeTitle.apply(this,arguments),i=t.title.apply(this,arguments),n=t.afterTitle.apply(this,arguments),a=[];return a=Ue(a,Ge(e)),a=Ue(a,Ge(i)),a=Ue(a,Ge(n))},getBeforeBody:function(){return $e(this._options.callbacks.beforeBody.apply(this,arguments))},getBody:function(t,e){var i=this,n=i._options.callbacks,a=[];return ut.each(t,function(t){var r={before:[],lines:[],after:[]};Ue(r.before,Ge(n.beforeLabel.call(i,t,e))),Ue(r.lines,n.label.call(i,t,e)),Ue(r.after,Ge(n.afterLabel.call(i,t,e))),a.push(r)}),a},getAfterBody:function(){return $e(this._options.callbacks.afterBody.apply(this,arguments))},getFooter:function(){var t=this._options.callbacks,e=t.beforeFooter.apply(this,arguments),i=t.footer.apply(this,arguments),n=t.afterFooter.apply(this,arguments),a=[];return a=Ue(a,Ge(e)),a=Ue(a,Ge(i)),a=Ue(a,Ge(n))},update:function(t){var e,i,n,a,r,o,s,l,u,d,h=this,c=h._options,f=h._model,g=h._model=qe(c),m=h._active,p=h._data,v={xAlign:f.xAlign,yAlign:f.yAlign},y={x:f.x,y:f.y},b={width:f.width,height:f.height},x={x:f.caretX,y:f.caretY};if(m.length){g.opacity=1;var _=[],k=[];x=je[c.position].call(h,m,h._eventPosition);var w=[];for(e=0,i=m.length;e<i;++e)w.push((n=m[e],a=void 0,r=void 0,o=void 0,s=void 0,l=void 0,u=void 0,d=void 0,a=n._xScale,r=n._yScale||n._scale,o=n._index,s=n._datasetIndex,l=n._chart.getDatasetMeta(s).controller,u=l._getIndexScale(),d=l._getValueScale(),{xLabel:a?a.getLabelForIndex(o,s):"",yLabel:r?r.getLabelForIndex(o,s):"",label:u?""+u.getLabelForIndex(o,s):"",value:d?""+d.getLabelForIndex(o,s):"",index:o,datasetIndex:s,x:n._model.x,y:n._model.y}));c.filter&&(w=w.filter(function(t){return c.filter(t,p)})),c.itemSort&&(w=w.sort(function(t,e){return c.itemSort(t,e,p)})),ut.each(w,function(t){_.push(c.callbacks.labelColor.call(h,t,h._chart)),k.push(c.callbacks.labelTextColor.call(h,t,h._chart))}),g.title=h.getTitle(w,p),g.beforeBody=h.getBeforeBody(w,p),g.body=h.getBody(w,p),g.afterBody=h.getAfterBody(w,p),g.footer=h.getFooter(w,p),g.x=x.x,g.y=x.y,g.caretPadding=c.caretPadding,g.labelColors=_,g.labelTextColors=k,g.dataPoints=w,b=function(t,e){var i=t._chart.ctx,n=2*e.yPadding,a=0,r=e.body,o=r.reduce(function(t,e){return t+e.before.length+e.lines.length+e.after.length},0);o+=e.beforeBody.length+e.afterBody.length;var s=e.title.length,l=e.footer.length,u=e.titleFontSize,d=e.bodyFontSize,h=e.footerFontSize;n+=s*u,n+=s?(s-1)*e.titleSpacing:0,n+=s?e.titleMarginBottom:0,n+=o*d,n+=o?(o-1)*e.bodySpacing:0,n+=l?e.footerMarginTop:0,n+=l*h,n+=l?(l-1)*e.footerSpacing:0;var c=0,f=function(t){a=Math.max(a,i.measureText(t).width+c)};return i.font=ut.fontString(u,e._titleFontStyle,e._titleFontFamily),ut.each(e.title,f),i.font=ut.fontString(d,e._bodyFontStyle,e._bodyFontFamily),ut.each(e.beforeBody.concat(e.afterBody),f),c=e.displayColors?d+2:0,ut.each(r,function(t){ut.each(t.before,f),ut.each(t.lines,f),ut.each(t.after,f)}),c=0,i.font=ut.fontString(h,e._footerFontStyle,e._footerFontFamily),ut.each(e.footer,f),{width:a+=2*e.xPadding,height:n}}(this,g),y=function(t,e,i,n){var a=t.x,r=t.y,o=t.caretSize,s=t.caretPadding,l=t.cornerRadius,u=i.xAlign,d=i.yAlign,h=o+s,c=l+s;return"right"===u?a-=e.width:"center"===u&&((a-=e.width/2)+e.width>n.width&&(a=n.width-e.width),a<0&&(a=0)),"top"===d?r+=h:r-="bottom"===d?e.height+h:e.height/2,"center"===d?"left"===u?a+=h:"right"===u&&(a-=h):"left"===u?a-=c:"right"===u&&(a+=c),{x:a,y:r}}(g,b,v=function(t,e){var i,n,a,r,o,s=t._model,l=t._chart,u=t._chart.chartArea,d="center",h="center";s.y<e.height?h="top":s.y>l.height-e.height&&(h="bottom");var c=(u.left+u.right)/2,f=(u.top+u.bottom)/2;"center"===h?(i=function(t){return t<=c},n=function(t){return t>c}):(i=function(t){return t<=e.width/2},n=function(t){return t>=l.width-e.width/2}),a=function(t){return t+e.width+s.caretSize+s.caretPadding>l.width},r=function(t){return t-e.width-s.caretSize-s.caretPadding<0},o=function(t){return t<=f?"top":"bottom"},i(s.x)?(d="left",a(s.x)&&(d="center",h=o(s.y))):n(s.x)&&(d="right",r(s.x)&&(d="center",h=o(s.y)));var g=t._options;return{xAlign:g.xAlign?g.xAlign:d,yAlign:g.yAlign?g.yAlign:h}}(this,b),h._chart)}else g.opacity=0;return g.xAlign=v.xAlign,g.yAlign=v.yAlign,g.x=y.x,g.y=y.y,g.width=b.width,g.height=b.height,g.caretX=x.x,g.caretY=x.y,h._model=g,t&&c.custom&&c.custom.call(h,g),h},drawCaret:function(t,e){var i=this._chart.ctx,n=this._view,a=this.getCaretPosition(t,e,n);i.lineTo(a.x1,a.y1),i.lineTo(a.x2,a.y2),i.lineTo(a.x3,a.y3)},getCaretPosition:function(t,e,i){var n,a,r,o,s,l,u=i.caretSize,d=i.cornerRadius,h=i.xAlign,c=i.yAlign,f=t.x,g=t.y,m=e.width,p=e.height;if("center"===c)s=g+p/2,"left"===h?(a=(n=f)-u,r=n,o=s+u,l=s-u):(a=(n=f+m)+u,r=n,o=s-u,l=s+u);else if("left"===h?(n=(a=f+d+u)-u,r=a+u):"right"===h?(n=(a=f+m-d-u)-u,r=a+u):(n=(a=i.caretX)-u,r=a+u),"top"===c)s=(o=g)-u,l=o;else{s=(o=g+p)+u,l=o;var v=r;r=n,n=v}return{x1:n,x2:a,x3:r,y1:o,y2:s,y3:l}},drawTitle:function(t,e,i){var n=e.title;if(n.length){t.x=Ze(e,e._titleAlign),i.textAlign=e._titleAlign,i.textBaseline="top";var a,r,o=e.titleFontSize,s=e.titleSpacing;for(i.fillStyle=e.titleFontColor,i.font=ut.fontString(o,e._titleFontStyle,e._titleFontFamily),a=0,r=n.length;a<r;++a)i.fillText(n[a],t.x,t.y),t.y+=o+s,a+1===n.length&&(t.y+=e.titleMarginBottom-s)}},drawBody:function(t,e,i){var n,a=e.bodyFontSize,r=e.bodySpacing,o=e._bodyAlign,s=e.body,l=e.displayColors,u=e.labelColors,d=0,h=l?Ze(e,"left"):0;i.textAlign=o,i.textBaseline="top",i.font=ut.fontString(a,e._bodyFontStyle,e._bodyFontFamily),t.x=Ze(e,o);var c=function(e){i.fillText(e,t.x+d,t.y),t.y+=a+r};i.fillStyle=e.bodyFontColor,ut.each(e.beforeBody,c),d=l&&"right"!==o?"center"===o?a/2+1:a+2:0,ut.each(s,function(r,o){n=e.labelTextColors[o],i.fillStyle=n,ut.each(r.before,c),ut.each(r.lines,function(r){l&&(i.fillStyle=e.legendColorBackground,i.fillRect(h,t.y,a,a),i.lineWidth=1,i.strokeStyle=u[o].borderColor,i.strokeRect(h,t.y,a,a),i.fillStyle=u[o].backgroundColor,i.fillRect(h+1,t.y+1,a-2,a-2),i.fillStyle=n),c(r)}),ut.each(r.after,c)}),d=0,ut.each(e.afterBody,c),t.y-=r},drawFooter:function(t,e,i){var n=e.footer;n.length&&(t.x=Ze(e,e._footerAlign),t.y+=e.footerMarginTop,i.textAlign=e._footerAlign,i.textBaseline="top",i.fillStyle=e.footerFontColor,i.font=ut.fontString(e.footerFontSize,e._footerFontStyle,e._footerFontFamily),ut.each(n,function(n){i.fillText(n,t.x,t.y),t.y+=e.footerFontSize+e.footerSpacing}))},drawBackground:function(t,e,i,n){i.fillStyle=e.backgroundColor,i.strokeStyle=e.borderColor,i.lineWidth=e.borderWidth;var a=e.xAlign,r=e.yAlign,o=t.x,s=t.y,l=n.width,u=n.height,d=e.cornerRadius;i.beginPath(),i.moveTo(o+d,s),"top"===r&&this.drawCaret(t,n),i.lineTo(o+l-d,s),i.quadraticCurveTo(o+l,s,o+l,s+d),"center"===r&&"right"===a&&this.drawCaret(t,n),i.lineTo(o+l,s+u-d),i.quadraticCurveTo(o+l,s+u,o+l-d,s+u),"bottom"===r&&this.drawCaret(t,n),i.lineTo(o+d,s+u),i.quadraticCurveTo(o,s+u,o,s+u-d),"center"===r&&"left"===a&&this.drawCaret(t,n),i.lineTo(o,s+d),i.quadraticCurveTo(o,s,o+d,s),i.closePath(),i.fill(),e.borderWidth>0&&i.stroke()},draw:function(){var t=this._chart.ctx,e=this._view;if(0!==e.opacity){var i={width:e.width,height:e.height},n={x:e.x,y:e.y},a=Math.abs(e.opacity<.001)?0:e.opacity,r=e.title.length||e.beforeBody.length||e.body.length||e.afterBody.length||e.footer.length;this._options.enabled&&r&&(t.save(),t.globalAlpha=a,this.drawBackground(n,e,t,i),n.y+=e.yPadding,this.drawTitle(n,e,t),this.drawBody(n,e,t),this.drawFooter(n,e,t),t.restore())}},handleEvent:function(t){var e,i=this,n=i._options;return i._lastActive=i._lastActive||[],"mouseout"===t.type?i._active=[]:i._active=i._chart.getElementsAtEventForMode(t,n.mode,n),(e=!ut.arrayEquals(i._active,i._lastActive))&&(i._lastActive=i._active,(n.enabled||n.custom)&&(i._eventPosition={x:t.x,y:t.y},i.update(!0),i.pivot())),e}}),Ke=je,Je=Xe;Je.positioners=Ke;var Qe=ut.valueOrDefault;function ti(){return ut.merge({},[].slice.call(arguments),{merger:function(t,e,i,n){if("xAxes"===t||"yAxes"===t){var a,r,o,s=i[t].length;for(e[t]||(e[t]=[]),a=0;a<s;++a)o=i[t][a],r=Qe(o.type,"xAxes"===t?"category":"linear"),a>=e[t].length&&e[t].push({}),!e[t][a].type||o.type&&o.type!==e[t][a].type?ut.merge(e[t][a],[Ee.getScaleDefaults(r),o]):ut.merge(e[t][a],o)}else ut._merger(t,e,i,n)}})}function ei(){return ut.merge({},[].slice.call(arguments),{merger:function(t,e,i,n){var a=e[t]||{},r=i[t];"scales"===t?e[t]=ti(a,r):"scale"===t?e[t]=ut.merge(a,[Ee.getScaleDefaults(r.type),r]):ut._merger(t,e,i,n)}})}function ii(t){return"top"===t||"bottom"===t}ot._set("global",{elements:{},events:["mousemove","mouseout","click","touchstart","touchmove"],hover:{onHover:null,mode:"nearest",intersect:!0,animationDuration:400},onClick:null,maintainAspectRatio:!0,responsive:!0,responsiveAnimationDuration:0});var ni=function(t,e){return this.construct(t,e),this};ut.extend(ni.prototype,{construct:function(t,e){var i=this;e=function(t){var e=(t=t||{}).data=t.data||{};return e.datasets=e.datasets||[],e.labels=e.labels||[],t.options=ei(ot.global,ot[t.type],t.options||{}),t}(e);var n=Ve.acquireContext(t,e),a=n&&n.canvas,r=a&&a.height,o=a&&a.width;i.id=ut.uid(),i.ctx=n,i.canvas=a,i.config=e,i.width=o,i.height=r,i.aspectRatio=r?o/r:null,i.options=e.options,i._bufferedRender=!1,i.chart=i,i.controller=i,ni.instances[i.id]=i,Object.defineProperty(i,"data",{get:function(){return i.config.data},set:function(t){i.config.data=t}}),n&&a?(i.initialize(),i.update()):console.error("Failed to create chart: can't acquire context from the given item")},initialize:function(){var t=this;return He.notify(t,"beforeInit"),ut.retinaScale(t,t.options.devicePixelRatio),t.bindEvents(),t.options.responsive&&t.resize(!0),t.ensureScalesHaveIDs(),t.buildOrUpdateScales(),t.initToolTip(),He.notify(t,"afterInit"),t},clear:function(){return ut.canvas.clear(this),this},stop:function(){return vt.cancelAnimation(this),this},resize:function(t){var e=this,i=e.options,n=e.canvas,a=i.maintainAspectRatio&&e.aspectRatio||null,r=Math.max(0,Math.floor(ut.getMaximumWidth(n))),o=Math.max(0,Math.floor(a?r/a:ut.getMaximumHeight(n)));if((e.width!==r||e.height!==o)&&(n.width=e.width=r,n.height=e.height=o,n.style.width=r+"px",n.style.height=o+"px",ut.retinaScale(e,i.devicePixelRatio),!t)){var s={width:r,height:o};He.notify(e,"resize",[s]),i.onResize&&i.onResize(e,s),e.stop(),e.update({duration:i.responsiveAnimationDuration})}},ensureScalesHaveIDs:function(){var t=this.options,e=t.scales||{},i=t.scale;ut.each(e.xAxes,function(t,e){t.id=t.id||"x-axis-"+e}),ut.each(e.yAxes,function(t,e){t.id=t.id||"y-axis-"+e}),i&&(i.id=i.id||"scale")},buildOrUpdateScales:function(){var t=this,e=t.options,i=t.scales||{},n=[],a=Object.keys(i).reduce(function(t,e){return t[e]=!1,t},{});e.scales&&(n=n.concat((e.scales.xAxes||[]).map(function(t){return{options:t,dtype:"category",dposition:"bottom"}}),(e.scales.yAxes||[]).map(function(t){return{options:t,dtype:"linear",dposition:"left"}}))),e.scale&&n.push({options:e.scale,dtype:"radialLinear",isDefault:!0,dposition:"chartArea"}),ut.each(n,function(e){var n=e.options,r=n.id,o=Qe(n.type,e.dtype);ii(n.position)!==ii(e.dposition)&&(n.position=e.dposition),a[r]=!0;var s=null;if(r in i&&i[r].type===o)(s=i[r]).options=n,s.ctx=t.ctx,s.chart=t;else{var l=Ee.getScaleConstructor(o);if(!l)return;s=new l({id:r,type:o,options:n,ctx:t.ctx,chart:t}),i[s.id]=s}s.mergeTicksOptions(),e.isDefault&&(t.scale=s)}),ut.each(a,function(t,e){t||delete i[e]}),t.scales=i,Ee.addScalesToLayout(this)},buildOrUpdateControllers:function(){var t=this,e=[];return ut.each(t.data.datasets,function(i,n){var a=t.getDatasetMeta(n),r=i.type||t.config.type;if(a.type&&a.type!==r&&(t.destroyDatasetMeta(n),a=t.getDatasetMeta(n)),a.type=r,a.controller)a.controller.updateIndex(n),a.controller.linkScales();else{var o=ue[a.type];if(void 0===o)throw new Error('"'+a.type+'" is not a chart type.');a.controller=new o(t,n),e.push(a.controller)}},t),e},resetElements:function(){var t=this;ut.each(t.data.datasets,function(e,i){t.getDatasetMeta(i).controller.reset()},t)},reset:function(){this.resetElements(),this.tooltip.initialize()},update:function(t){var e,i,n=this;if(t&&"object"==typeof t||(t={duration:t,lazy:arguments[1]}),i=(e=n).options,ut.each(e.scales,function(t){xe.removeBox(e,t)}),i=ei(ot.global,ot[e.config.type],i),e.options=e.config.options=i,e.ensureScalesHaveIDs(),e.buildOrUpdateScales(),e.tooltip._options=i.tooltips,e.tooltip.initialize(),He._invalidate(n),!1!==He.notify(n,"beforeUpdate")){n.tooltip._data=n.data;var a=n.buildOrUpdateControllers();ut.each(n.data.datasets,function(t,e){n.getDatasetMeta(e).controller.buildOrUpdateElements()},n),n.updateLayout(),n.options.animation&&n.options.animation.duration&&ut.each(a,function(t){t.reset()}),n.updateDatasets(),n.tooltip.initialize(),n.lastActive=[],He.notify(n,"afterUpdate"),n._bufferedRender?n._bufferedRequest={duration:t.duration,easing:t.easing,lazy:t.lazy}:n.render(t)}},updateLayout:function(){!1!==He.notify(this,"beforeLayout")&&(xe.update(this,this.width,this.height),He.notify(this,"afterScaleUpdate"),He.notify(this,"afterLayout"))},updateDatasets:function(){if(!1!==He.notify(this,"beforeDatasetsUpdate")){for(var t=0,e=this.data.datasets.length;t<e;++t)this.updateDataset(t);He.notify(this,"afterDatasetsUpdate")}},updateDataset:function(t){var e=this.getDatasetMeta(t),i={meta:e,index:t};!1!==He.notify(this,"beforeDatasetUpdate",[i])&&(e.controller.update(),He.notify(this,"afterDatasetUpdate",[i]))},render:function(t){var e=this;t&&"object"==typeof t||(t={duration:t,lazy:arguments[1]});var i=e.options.animation,n=Qe(t.duration,i&&i.duration),a=t.lazy;if(!1!==He.notify(e,"beforeRender")){var r=function(t){He.notify(e,"afterRender"),ut.callback(i&&i.onComplete,[t],e)};if(i&&n){var o=new pt({numSteps:n/16.66,easing:t.easing||i.easing,render:function(t,e){var i=ut.easing.effects[e.easing],n=e.currentStep,a=n/e.numSteps;t.draw(i(a),a,n)},onAnimationProgress:i.onProgress,onAnimationComplete:r});vt.addAnimation(e,o,n,a)}else e.draw(),r(new pt({numSteps:0,chart:e}));return e}},draw:function(t){var e=this;e.clear(),ut.isNullOrUndef(t)&&(t=1),e.transition(t),e.width<=0||e.height<=0||!1!==He.notify(e,"beforeDraw",[t])&&(ut.each(e.boxes,function(t){t.draw(e.chartArea)},e),e.drawDatasets(t),e._drawTooltip(t),He.notify(e,"afterDraw",[t]))},transition:function(t){for(var e=0,i=(this.data.datasets||[]).length;e<i;++e)this.isDatasetVisible(e)&&this.getDatasetMeta(e).controller.transition(t);this.tooltip.transition(t)},drawDatasets:function(t){var e=this;if(!1!==He.notify(e,"beforeDatasetsDraw",[t])){for(var i=(e.data.datasets||[]).length-1;i>=0;--i)e.isDatasetVisible(i)&&e.drawDataset(i,t);He.notify(e,"afterDatasetsDraw",[t])}},drawDataset:function(t,e){var i=this.getDatasetMeta(t),n={meta:i,index:t,easingValue:e};!1!==He.notify(this,"beforeDatasetDraw",[n])&&(i.controller.draw(e),He.notify(this,"afterDatasetDraw",[n]))},_drawTooltip:function(t){var e=this.tooltip,i={tooltip:e,easingValue:t};!1!==He.notify(this,"beforeTooltipDraw",[i])&&(e.draw(),He.notify(this,"afterTooltipDraw",[i]))},getElementAtEvent:function(t){return pe.modes.single(this,t)},getElementsAtEvent:function(t){return pe.modes.label(this,t,{intersect:!0})},getElementsAtXAxis:function(t){return pe.modes["x-axis"](this,t,{intersect:!0})},getElementsAtEventForMode:function(t,e,i){var n=pe.modes[e];return"function"==typeof n?n(this,t,i):[]},getDatasetAtEvent:function(t){return pe.modes.dataset(this,t,{intersect:!0})},getDatasetMeta:function(t){var e=this.data.datasets[t];e._meta||(e._meta={});var i=e._meta[this.id];return i||(i=e._meta[this.id]={type:null,data:[],dataset:null,controller:null,hidden:null,xAxisID:null,yAxisID:null}),i},getVisibleDatasetCount:function(){for(var t=0,e=0,i=this.data.datasets.length;e<i;++e)this.isDatasetVisible(e)&&t++;return t},isDatasetVisible:function(t){var e=this.getDatasetMeta(t);return"boolean"==typeof e.hidden?!e.hidden:!this.data.datasets[t].hidden},generateLegend:function(){return this.options.legendCallback(this)},destroyDatasetMeta:function(t){var e=this.id,i=this.data.datasets[t],n=i._meta&&i._meta[e];n&&(n.controller.destroy(),delete i._meta[e])},destroy:function(){var t,e,i=this,n=i.canvas;for(i.stop(),t=0,e=i.data.datasets.length;t<e;++t)i.destroyDatasetMeta(t);n&&(i.unbindEvents(),ut.canvas.clear(i),Ve.releaseContext(i.ctx),i.canvas=null,i.ctx=null),He.notify(i,"destroy"),delete ni.instances[i.id]},toBase64Image:function(){return this.canvas.toDataURL.apply(this.canvas,arguments)},initToolTip:function(){var t=this;t.tooltip=new Je({_chart:t,_chartInstance:t,_data:t.data,_options:t.options.tooltips},t)},bindEvents:function(){var t=this,e=t._listeners={},i=function(){t.eventHandler.apply(t,arguments)};ut.each(t.options.events,function(n){Ve.addEventListener(t,n,i),e[n]=i}),t.options.responsive&&(i=function(){t.resize()},Ve.addEventListener(t,"resize",i),e.resize=i)},unbindEvents:function(){var t=this,e=t._listeners;e&&(delete t._listeners,ut.each(e,function(e,i){Ve.removeEventListener(t,i,e)}))},updateHoverStyle:function(t,e,i){var n,a,r,o=i?"setHoverStyle":"removeHoverStyle";for(a=0,r=t.length;a<r;++a)(n=t[a])&&this.getDatasetMeta(n._datasetIndex).controller[o](n)},eventHandler:function(t){var e=this,i=e.tooltip;if(!1!==He.notify(e,"beforeEvent",[t])){e._bufferedRender=!0,e._bufferedRequest=null;var n=e.handleEvent(t);i&&(n=i._start?i.handleEvent(t):n|i.handleEvent(t)),He.notify(e,"afterEvent",[t]);var a=e._bufferedRequest;return a?e.render(a):n&&!e.animating&&(e.stop(),e.render({duration:e.options.hover.animationDuration,lazy:!0})),e._bufferedRender=!1,e._bufferedRequest=null,e}},handleEvent:function(t){var e,i=this,n=i.options||{},a=n.hover;return i.lastActive=i.lastActive||[],"mouseout"===t.type?i.active=[]:i.active=i.getElementsAtEventForMode(t,a.mode,a),ut.callback(n.onHover||n.hover.onHover,[t.native,i.active],i),"mouseup"!==t.type&&"click"!==t.type||n.onClick&&n.onClick.call(i,t.native,i.active),i.lastActive.length&&i.updateHoverStyle(i.lastActive,a.mode,!1),i.active.length&&a.mode&&i.updateHoverStyle(i.active,a.mode,!0),e=!ut.arrayEquals(i.active,i.lastActive),i.lastActive=i.active,e}}),ni.instances={};var ai=ni;ni.Controller=ni,ni.types={},ut.configMerge=ei,ut.scaleMerge=ti;function ri(){throw new Error("This method is not implemented: either no adapter can be found or an incomplete integration was provided.")}function oi(t){this.options=t||{}}ut.extend(oi.prototype,{formats:ri,parse:ri,format:ri,add:ri,diff:ri,startOf:ri,endOf:ri,_create:function(t){return t}}),oi.override=function(t){ut.extend(oi.prototype,t)};var si={_date:oi},li={formatters:{values:function(t){return ut.isArray(t)?t:""+t},linear:function(t,e,i){var n=i.length>3?i[2]-i[1]:i[1]-i[0];Math.abs(n)>1&&t!==Math.floor(t)&&(n=t-Math.floor(t));var a=ut.log10(Math.abs(n)),r="";if(0!==t)if(Math.max(Math.abs(i[0]),Math.abs(i[i.length-1]))<1e-4){var o=ut.log10(Math.abs(t));r=t.toExponential(Math.floor(o)-Math.floor(a))}else{var s=-1*Math.floor(a);s=Math.max(Math.min(s,20),0),r=t.toFixed(s)}else r="0";return r},logarithmic:function(t,e,i){var n=t/Math.pow(10,Math.floor(ut.log10(t)));return 0===t?"0":1===n||2===n||5===n||0===e||e===i.length-1?t.toExponential():""}}},ui=ut.valueOrDefault,di=ut.valueAtIndexOrDefault;function hi(t){var e,i,n=[];for(e=0,i=t.length;e<i;++e)n.push(t[e].label);return n}function ci(t,e,i){return ut.isArray(e)?ut.longestText(t,i,e):t.measureText(e).width}ot._set("scale",{display:!0,position:"left",offset:!1,gridLines:{display:!0,color:"rgba(0, 0, 0, 0.1)",lineWidth:1,drawBorder:!0,drawOnChartArea:!0,drawTicks:!0,tickMarkLength:10,zeroLineWidth:1,zeroLineColor:"rgba(0,0,0,0.25)",zeroLineBorderDash:[],zeroLineBorderDashOffset:0,offsetGridLines:!1,borderDash:[],borderDashOffset:0},scaleLabel:{display:!1,labelString:"",padding:{top:4,bottom:4}},ticks:{beginAtZero:!1,minRotation:0,maxRotation:50,mirror:!1,padding:0,reverse:!1,display:!0,autoSkip:!0,autoSkipPadding:0,labelOffset:0,callback:li.formatters.values,minor:{},major:{}}});var fi=gt.extend({getPadding:function(){return{left:this.paddingLeft||0,top:this.paddingTop||0,right:this.paddingRight||0,bottom:this.paddingBottom||0}},getTicks:function(){return this._ticks},mergeTicksOptions:function(){var t=this.options.ticks;for(var e in!1===t.minor&&(t.minor={display:!1}),!1===t.major&&(t.major={display:!1}),t)"major"!==e&&"minor"!==e&&(void 0===t.minor[e]&&(t.minor[e]=t[e]),void 0===t.major[e]&&(t.major[e]=t[e]))},beforeUpdate:function(){ut.callback(this.options.beforeUpdate,[this])},update:function(t,e,i){var n,a,r,o,s,l,u=this;for(u.beforeUpdate(),u.maxWidth=t,u.maxHeight=e,u.margins=ut.extend({left:0,right:0,top:0,bottom:0},i),u._maxLabelLines=0,u.longestLabelWidth=0,u.longestTextCache=u.longestTextCache||{},u.beforeSetDimensions(),u.setDimensions(),u.afterSetDimensions(),u.beforeDataLimits(),u.determineDataLimits(),u.afterDataLimits(),u.beforeBuildTicks(),s=u.buildTicks()||[],s=u.afterBuildTicks(s)||s,u.beforeTickToLabelConversion(),r=u.convertTicksToLabels(s)||u.ticks,u.afterTickToLabelConversion(),u.ticks=r,n=0,a=r.length;n<a;++n)o=r[n],(l=s[n])?l.label=o:s.push(l={label:o,major:!1});return u._ticks=s,u.beforeCalculateTickRotation(),u.calculateTickRotation(),u.afterCalculateTickRotation(),u.beforeFit(),u.fit(),u.afterFit(),u.afterUpdate(),u.minSize},afterUpdate:function(){ut.callback(this.options.afterUpdate,[this])},beforeSetDimensions:function(){ut.callback(this.options.beforeSetDimensions,[this])},setDimensions:function(){var t=this;t.isHorizontal()?(t.width=t.maxWidth,t.left=0,t.right=t.width):(t.height=t.maxHeight,t.top=0,t.bottom=t.height),t.paddingLeft=0,t.paddingTop=0,t.paddingRight=0,t.paddingBottom=0},afterSetDimensions:function(){ut.callback(this.options.afterSetDimensions,[this])},beforeDataLimits:function(){ut.callback(this.options.beforeDataLimits,[this])},determineDataLimits:ut.noop,afterDataLimits:function(){ut.callback(this.options.afterDataLimits,[this])},beforeBuildTicks:function(){ut.callback(this.options.beforeBuildTicks,[this])},buildTicks:ut.noop,afterBuildTicks:function(t){var e=this;return ut.isArray(t)&&t.length?ut.callback(e.options.afterBuildTicks,[e,t]):(e.ticks=ut.callback(e.options.afterBuildTicks,[e,e.ticks])||e.ticks,t)},beforeTickToLabelConversion:function(){ut.callback(this.options.beforeTickToLabelConversion,[this])},convertTicksToLabels:function(){var t=this.options.ticks;this.ticks=this.ticks.map(t.userCallback||t.callback,this)},afterTickToLabelConversion:function(){ut.callback(this.options.afterTickToLabelConversion,[this])},beforeCalculateTickRotation:function(){ut.callback(this.options.beforeCalculateTickRotation,[this])},calculateTickRotation:function(){var t=this,e=t.ctx,i=t.options.ticks,n=hi(t._ticks),a=ut.options._parseFont(i);e.font=a.string;var r=i.minRotation||0;if(n.length&&t.options.display&&t.isHorizontal())for(var o,s=ut.longestText(e,a.string,n,t.longestTextCache),l=s,u=t.getPixelForTick(1)-t.getPixelForTick(0)-6;l>u&&r<i.maxRotation;){var d=ut.toRadians(r);if(o=Math.cos(d),Math.sin(d)*s>t.maxHeight){r--;break}r++,l=o*s}t.labelRotation=r},afterCalculateTickRotation:function(){ut.callback(this.options.afterCalculateTickRotation,[this])},beforeFit:function(){ut.callback(this.options.beforeFit,[this])},fit:function(){var t=this,e=t.minSize={width:0,height:0},i=hi(t._ticks),n=t.options,a=n.ticks,r=n.scaleLabel,o=n.gridLines,s=t._isVisible(),l=n.position,u=t.isHorizontal(),d=ut.options._parseFont,h=d(a),c=n.gridLines.tickMarkLength;if(e.width=u?t.isFullWidth()?t.maxWidth-t.margins.left-t.margins.right:t.maxWidth:s&&o.drawTicks?c:0,e.height=u?s&&o.drawTicks?c:0:t.maxHeight,r.display&&s){var f=d(r),g=ut.options.toPadding(r.padding),m=f.lineHeight+g.height;u?e.height+=m:e.width+=m}if(a.display&&s){var p=ut.longestText(t.ctx,h.string,i,t.longestTextCache),v=ut.numberOfLabelLines(i),y=.5*h.size,b=t.options.ticks.padding;if(t._maxLabelLines=v,t.longestLabelWidth=p,u){var x=ut.toRadians(t.labelRotation),_=Math.cos(x),k=Math.sin(x)*p+h.lineHeight*v+y;e.height=Math.min(t.maxHeight,e.height+k+b),t.ctx.font=h.string;var w,M,S=ci(t.ctx,i[0],h.string),D=ci(t.ctx,i[i.length-1],h.string),C=t.getPixelForTick(0)-t.left,P=t.right-t.getPixelForTick(i.length-1);0!==t.labelRotation?(w="bottom"===l?_*S:_*y,M="bottom"===l?_*y:_*D):(w=S/2,M=D/2),t.paddingLeft=Math.max(w-C,0)+3,t.paddingRight=Math.max(M-P,0)+3}else a.mirror?p=0:p+=b+y,e.width=Math.min(t.maxWidth,e.width+p),t.paddingTop=h.size/2,t.paddingBottom=h.size/2}t.handleMargins(),t.width=e.width,t.height=e.height},handleMargins:function(){var t=this;t.margins&&(t.paddingLeft=Math.max(t.paddingLeft-t.margins.left,0),t.paddingTop=Math.max(t.paddingTop-t.margins.top,0),t.paddingRight=Math.max(t.paddingRight-t.margins.right,0),t.paddingBottom=Math.max(t.paddingBottom-t.margins.bottom,0))},afterFit:function(){ut.callback(this.options.afterFit,[this])},isHorizontal:function(){return"top"===this.options.position||"bottom"===this.options.position},isFullWidth:function(){return this.options.fullWidth},getRightValue:function(t){if(ut.isNullOrUndef(t))return NaN;if(("number"==typeof t||t instanceof Number)&&!isFinite(t))return NaN;if(t)if(this.isHorizontal()){if(void 0!==t.x)return this.getRightValue(t.x)}else if(void 0!==t.y)return this.getRightValue(t.y);return t},getLabelForIndex:ut.noop,getPixelForValue:ut.noop,getValueForPixel:ut.noop,getPixelForTick:function(t){var e=this,i=e.options.offset;if(e.isHorizontal()){var n=(e.width-(e.paddingLeft+e.paddingRight))/Math.max(e._ticks.length-(i?0:1),1),a=n*t+e.paddingLeft;i&&(a+=n/2);var r=e.left+a;return r+=e.isFullWidth()?e.margins.left:0}var o=e.height-(e.paddingTop+e.paddingBottom);return e.top+t*(o/(e._ticks.length-1))},getPixelForDecimal:function(t){var e=this;if(e.isHorizontal()){var i=(e.width-(e.paddingLeft+e.paddingRight))*t+e.paddingLeft,n=e.left+i;return n+=e.isFullWidth()?e.margins.left:0}return e.top+t*e.height},getBasePixel:function(){return this.getPixelForValue(this.getBaseValue())},getBaseValue:function(){var t=this.min,e=this.max;return this.beginAtZero?0:t<0&&e<0?e:t>0&&e>0?t:0},_autoSkip:function(t){var e,i,n=this,a=n.isHorizontal(),r=n.options.ticks.minor,o=t.length,s=!1,l=r.maxTicksLimit,u=n._tickSize()*(o-1),d=a?n.width-(n.paddingLeft+n.paddingRight):n.height-(n.paddingTop+n.PaddingBottom),h=[];for(u>d&&(s=1+Math.floor(u/d)),o>l&&(s=Math.max(s,1+Math.floor(o/l))),e=0;e<o;e++)i=t[e],s>1&&e%s>0&&delete i.label,h.push(i);return h},_tickSize:function(){var t=this,e=t.isHorizontal(),i=t.options.ticks.minor,n=ut.toRadians(t.labelRotation),a=Math.abs(Math.cos(n)),r=Math.abs(Math.sin(n)),o=i.autoSkipPadding||0,s=t.longestLabelWidth+o||0,l=ut.options._parseFont(i),u=t._maxLabelLines*l.lineHeight+o||0;return e?u*a>s*r?s/a:u/r:u*r<s*a?u/a:s/r},_isVisible:function(){var t,e,i,n=this.chart,a=this.options.display;if("auto"!==a)return!!a;for(t=0,e=n.data.datasets.length;t<e;++t)if(n.isDatasetVisible(t)&&((i=n.getDatasetMeta(t)).xAxisID===this.id||i.yAxisID===this.id))return!0;return!1},draw:function(t){var e=this,i=e.options;if(e._isVisible()){var n,a,r,o=e.chart,s=e.ctx,l=ot.global.defaultFontColor,u=i.ticks.minor,d=i.ticks.major||u,h=i.gridLines,c=i.scaleLabel,f=i.position,g=0!==e.labelRotation,m=u.mirror,p=e.isHorizontal(),v=ut.options._parseFont,y=u.display&&u.autoSkip?e._autoSkip(e.getTicks()):e.getTicks(),b=ui(u.fontColor,l),x=v(u),_=x.lineHeight,k=ui(d.fontColor,l),w=v(d),M=u.padding,S=u.labelOffset,D=h.drawTicks?h.tickMarkLength:0,C=ui(c.fontColor,l),P=v(c),T=ut.options.toPadding(c.padding),O=ut.toRadians(e.labelRotation),I=[],A=h.drawBorder?di(h.lineWidth,0,0):0,F=ut._alignPixel;"top"===f?(n=F(o,e.bottom,A),a=e.bottom-D,r=n-A/2):"bottom"===f?(n=F(o,e.top,A),a=n+A/2,r=e.top+D):"left"===f?(n=F(o,e.right,A),a=e.right-D,r=n-A/2):(n=F(o,e.left,A),a=n+A/2,r=e.left+D);if(ut.each(y,function(n,s){if(!ut.isNullOrUndef(n.label)){var l,u,d,c,v,y,b,x,k,w,C,P,T,R,L,W,Y=n.label;s===e.zeroLineIndex&&i.offset===h.offsetGridLines?(l=h.zeroLineWidth,u=h.zeroLineColor,d=h.zeroLineBorderDash||[],c=h.zeroLineBorderDashOffset||0):(l=di(h.lineWidth,s),u=di(h.color,s),d=h.borderDash||[],c=h.borderDashOffset||0);var N=ut.isArray(Y)?Y.length:1,z=function(t,e,i){var n=t.getPixelForTick(e);return i&&(1===t.getTicks().length?n-=t.isHorizontal()?Math.max(n-t.left,t.right-n):Math.max(n-t.top,t.bottom-n):n-=0===e?(t.getPixelForTick(1)-n)/2:(n-t.getPixelForTick(e-1))/2),n}(e,s,h.offsetGridLines);if(p){var V=D+M;z<e.left-1e-7&&(u="rgba(0,0,0,0)"),v=b=k=C=F(o,z,l),y=a,x=r,T=e.getPixelForTick(s)+S,"top"===f?(w=F(o,t.top,A)+A/2,P=t.bottom,L=((g?1:.5)-N)*_,W=g?"left":"center",R=e.bottom-V):(w=t.top,P=F(o,t.bottom,A)-A/2,L=(g?0:.5)*_,W=g?"right":"center",R=e.top+V)}else{var H=(m?0:D)+M;z<e.top-1e-7&&(u="rgba(0,0,0,0)"),v=a,b=r,y=x=w=P=F(o,z,l),R=e.getPixelForTick(s)+S,L=(1-N)*_/2,"left"===f?(k=F(o,t.left,A)+A/2,C=t.right,W=m?"left":"right",T=e.right-H):(k=t.left,C=F(o,t.right,A)-A/2,W=m?"right":"left",T=e.left+H)}I.push({tx1:v,ty1:y,tx2:b,ty2:x,x1:k,y1:w,x2:C,y2:P,labelX:T,labelY:R,glWidth:l,glColor:u,glBorderDash:d,glBorderDashOffset:c,rotation:-1*O,label:Y,major:n.major,textOffset:L,textAlign:W})}}),ut.each(I,function(t){var e=t.glWidth,i=t.glColor;if(h.display&&e&&i&&(s.save(),s.lineWidth=e,s.strokeStyle=i,s.setLineDash&&(s.setLineDash(t.glBorderDash),s.lineDashOffset=t.glBorderDashOffset),s.beginPath(),h.drawTicks&&(s.moveTo(t.tx1,t.ty1),s.lineTo(t.tx2,t.ty2)),h.drawOnChartArea&&(s.moveTo(t.x1,t.y1),s.lineTo(t.x2,t.y2)),s.stroke(),s.restore()),u.display){s.save(),s.translate(t.labelX,t.labelY),s.rotate(t.rotation),s.font=t.major?w.string:x.string,s.fillStyle=t.major?k:b,s.textBaseline="middle",s.textAlign=t.textAlign;var n=t.label,a=t.textOffset;if(ut.isArray(n))for(var r=0;r<n.length;++r)s.fillText(""+n[r],0,a),a+=_;else s.fillText(n,0,a);s.restore()}}),c.display){var R,L,W=0,Y=P.lineHeight/2;if(p)R=e.left+(e.right-e.left)/2,L="bottom"===f?e.bottom-Y-T.bottom:e.top+Y+T.top;else{var N="left"===f;R=N?e.left+Y+T.top:e.right-Y-T.top,L=e.top+(e.bottom-e.top)/2,W=N?-.5*Math.PI:.5*Math.PI}s.save(),s.translate(R,L),s.rotate(W),s.textAlign="center",s.textBaseline="middle",s.fillStyle=C,s.font=P.string,s.fillText(c.labelString,0,0),s.restore()}if(A){var z,V,H,E,B=A,j=di(h.lineWidth,y.length-1,0);p?(z=F(o,e.left,B)-B/2,V=F(o,e.right,j)+j/2,H=E=n):(H=F(o,e.top,B)-B/2,E=F(o,e.bottom,j)+j/2,z=V=n),s.lineWidth=A,s.strokeStyle=di(h.color,0),s.beginPath(),s.moveTo(z,H),s.lineTo(V,E),s.stroke()}}}}),gi=fi.extend({getLabels:function(){var t=this.chart.data;return this.options.labels||(this.isHorizontal()?t.xLabels:t.yLabels)||t.labels},determineDataLimits:function(){var t,e=this,i=e.getLabels();e.minIndex=0,e.maxIndex=i.length-1,void 0!==e.options.ticks.min&&(t=i.indexOf(e.options.ticks.min),e.minIndex=-1!==t?t:e.minIndex),void 0!==e.options.ticks.max&&(t=i.indexOf(e.options.ticks.max),e.maxIndex=-1!==t?t:e.maxIndex),e.min=i[e.minIndex],e.max=i[e.maxIndex]},buildTicks:function(){var t=this,e=t.getLabels();t.ticks=0===t.minIndex&&t.maxIndex===e.length-1?e:e.slice(t.minIndex,t.maxIndex+1)},getLabelForIndex:function(t,e){var i=this,n=i.chart;return n.getDatasetMeta(e).controller._getValueScaleId()===i.id?i.getRightValue(n.data.datasets[e].data[t]):i.ticks[t-i.minIndex]},getPixelForValue:function(t,e){var i,n=this,a=n.options.offset,r=Math.max(n.maxIndex+1-n.minIndex-(a?0:1),1);if(null!=t&&(i=n.isHorizontal()?t.x:t.y),void 0!==i||void 0!==t&&isNaN(e)){t=i||t;var o=n.getLabels().indexOf(t);e=-1!==o?o:e}if(n.isHorizontal()){var s=n.width/r,l=s*(e-n.minIndex);return a&&(l+=s/2),n.left+l}var u=n.height/r,d=u*(e-n.minIndex);return a&&(d+=u/2),n.top+d},getPixelForTick:function(t){return this.getPixelForValue(this.ticks[t],t+this.minIndex,null)},getValueForPixel:function(t){var e=this,i=e.options.offset,n=Math.max(e._ticks.length-(i?0:1),1),a=e.isHorizontal(),r=(a?e.width:e.height)/n;return t-=a?e.left:e.top,i&&(t-=r/2),(t<=0?0:Math.round(t/r))+e.minIndex},getBasePixel:function(){return this.bottom}}),mi={position:"bottom"};gi._defaults=mi;var pi=ut.noop,vi=ut.isNullOrUndef;var yi=fi.extend({getRightValue:function(t){return"string"==typeof t?+t:fi.prototype.getRightValue.call(this,t)},handleTickRangeOptions:function(){var t=this,e=t.options.ticks;if(e.beginAtZero){var i=ut.sign(t.min),n=ut.sign(t.max);i<0&&n<0?t.max=0:i>0&&n>0&&(t.min=0)}var a=void 0!==e.min||void 0!==e.suggestedMin,r=void 0!==e.max||void 0!==e.suggestedMax;void 0!==e.min?t.min=e.min:void 0!==e.suggestedMin&&(null===t.min?t.min=e.suggestedMin:t.min=Math.min(t.min,e.suggestedMin)),void 0!==e.max?t.max=e.max:void 0!==e.suggestedMax&&(null===t.max?t.max=e.suggestedMax:t.max=Math.max(t.max,e.suggestedMax)),a!==r&&t.min>=t.max&&(a?t.max=t.min+1:t.min=t.max-1),t.min===t.max&&(t.max++,e.beginAtZero||t.min--)},getTickLimit:function(){var t,e=this.options.ticks,i=e.stepSize,n=e.maxTicksLimit;return i?t=Math.ceil(this.max/i)-Math.floor(this.min/i)+1:(t=this._computeTickLimit(),n=n||11),n&&(t=Math.min(n,t)),t},_computeTickLimit:function(){return Number.POSITIVE_INFINITY},handleDirectionalChanges:pi,buildTicks:function(){var t=this,e=t.options.ticks,i=t.getTickLimit(),n={maxTicks:i=Math.max(2,i),min:e.min,max:e.max,precision:e.precision,stepSize:ut.valueOrDefault(e.fixedStepSize,e.stepSize)},a=t.ticks=function(t,e){var i,n,a,r,o=[],s=t.stepSize,l=s||1,u=t.maxTicks-1,d=t.min,h=t.max,c=t.precision,f=e.min,g=e.max,m=ut.niceNum((g-f)/u/l)*l;if(m<1e-14&&vi(d)&&vi(h))return[f,g];(r=Math.ceil(g/m)-Math.floor(f/m))>u&&(m=ut.niceNum(r*m/u/l)*l),s||vi(c)?i=Math.pow(10,ut._decimalPlaces(m)):(i=Math.pow(10,c),m=Math.ceil(m*i)/i),n=Math.floor(f/m)*m,a=Math.ceil(g/m)*m,s&&(!vi(d)&&ut.almostWhole(d/m,m/1e3)&&(n=d),!vi(h)&&ut.almostWhole(h/m,m/1e3)&&(a=h)),r=(a-n)/m,r=ut.almostEquals(r,Math.round(r),m/1e3)?Math.round(r):Math.ceil(r),n=Math.round(n*i)/i,a=Math.round(a*i)/i,o.push(vi(d)?n:d);for(var p=1;p<r;++p)o.push(Math.round((n+p*m)*i)/i);return o.push(vi(h)?a:h),o}(n,t);t.handleDirectionalChanges(),t.max=ut.max(a),t.min=ut.min(a),e.reverse?(a.reverse(),t.start=t.max,t.end=t.min):(t.start=t.min,t.end=t.max)},convertTicksToLabels:function(){var t=this;t.ticksAsNumbers=t.ticks.slice(),t.zeroLineIndex=t.ticks.indexOf(0),fi.prototype.convertTicksToLabels.call(t)}}),bi={position:"left",ticks:{callback:li.formatters.linear}},xi=yi.extend({determineDataLimits:function(){var t=this,e=t.options,i=t.chart,n=i.data.datasets,a=t.isHorizontal();function r(e){return a?e.xAxisID===t.id:e.yAxisID===t.id}t.min=null,t.max=null;var o=e.stacked;if(void 0===o&&ut.each(n,function(t,e){if(!o){var n=i.getDatasetMeta(e);i.isDatasetVisible(e)&&r(n)&&void 0!==n.stack&&(o=!0)}}),e.stacked||o){var s={};ut.each(n,function(n,a){var o=i.getDatasetMeta(a),l=[o.type,void 0===e.stacked&&void 0===o.stack?a:"",o.stack].join(".");void 0===s[l]&&(s[l]={positiveValues:[],negativeValues:[]});var u=s[l].positiveValues,d=s[l].negativeValues;i.isDatasetVisible(a)&&r(o)&&ut.each(n.data,function(i,n){var a=+t.getRightValue(i);isNaN(a)||o.data[n].hidden||(u[n]=u[n]||0,d[n]=d[n]||0,e.relativePoints?u[n]=100:a<0?d[n]+=a:u[n]+=a)})}),ut.each(s,function(e){var i=e.positiveValues.concat(e.negativeValues),n=ut.min(i),a=ut.max(i);t.min=null===t.min?n:Math.min(t.min,n),t.max=null===t.max?a:Math.max(t.max,a)})}else ut.each(n,function(e,n){var a=i.getDatasetMeta(n);i.isDatasetVisible(n)&&r(a)&&ut.each(e.data,function(e,i){var n=+t.getRightValue(e);isNaN(n)||a.data[i].hidden||(null===t.min?t.min=n:n<t.min&&(t.min=n),null===t.max?t.max=n:n>t.max&&(t.max=n))})});t.min=isFinite(t.min)&&!isNaN(t.min)?t.min:0,t.max=isFinite(t.max)&&!isNaN(t.max)?t.max:1,this.handleTickRangeOptions()},_computeTickLimit:function(){var t;return this.isHorizontal()?Math.ceil(this.width/40):(t=ut.options._parseFont(this.options.ticks),Math.ceil(this.height/t.lineHeight))},handleDirectionalChanges:function(){this.isHorizontal()||this.ticks.reverse()},getLabelForIndex:function(t,e){return+this.getRightValue(this.chart.data.datasets[e].data[t])},getPixelForValue:function(t){var e=this,i=e.start,n=+e.getRightValue(t),a=e.end-i;return e.isHorizontal()?e.left+e.width/a*(n-i):e.bottom-e.height/a*(n-i)},getValueForPixel:function(t){var e=this,i=e.isHorizontal(),n=i?e.width:e.height,a=(i?t-e.left:e.bottom-t)/n;return e.start+(e.end-e.start)*a},getPixelForTick:function(t){return this.getPixelForValue(this.ticksAsNumbers[t])}}),_i=bi;xi._defaults=_i;var ki=ut.valueOrDefault;var wi={position:"left",ticks:{callback:li.formatters.logarithmic}};function Mi(t,e){return ut.isFinite(t)&&t>=0?t:e}var Si=fi.extend({determineDataLimits:function(){var t=this,e=t.options,i=t.chart,n=i.data.datasets,a=t.isHorizontal();function r(e){return a?e.xAxisID===t.id:e.yAxisID===t.id}t.min=null,t.max=null,t.minNotZero=null;var o=e.stacked;if(void 0===o&&ut.each(n,function(t,e){if(!o){var n=i.getDatasetMeta(e);i.isDatasetVisible(e)&&r(n)&&void 0!==n.stack&&(o=!0)}}),e.stacked||o){var s={};ut.each(n,function(n,a){var o=i.getDatasetMeta(a),l=[o.type,void 0===e.stacked&&void 0===o.stack?a:"",o.stack].join(".");i.isDatasetVisible(a)&&r(o)&&(void 0===s[l]&&(s[l]=[]),ut.each(n.data,function(e,i){var n=s[l],a=+t.getRightValue(e);isNaN(a)||o.data[i].hidden||a<0||(n[i]=n[i]||0,n[i]+=a)}))}),ut.each(s,function(e){if(e.length>0){var i=ut.min(e),n=ut.max(e);t.min=null===t.min?i:Math.min(t.min,i),t.max=null===t.max?n:Math.max(t.max,n)}})}else ut.each(n,function(e,n){var a=i.getDatasetMeta(n);i.isDatasetVisible(n)&&r(a)&&ut.each(e.data,function(e,i){var n=+t.getRightValue(e);isNaN(n)||a.data[i].hidden||n<0||(null===t.min?t.min=n:n<t.min&&(t.min=n),null===t.max?t.max=n:n>t.max&&(t.max=n),0!==n&&(null===t.minNotZero||n<t.minNotZero)&&(t.minNotZero=n))})});this.handleTickRangeOptions()},handleTickRangeOptions:function(){var t=this,e=t.options.ticks;t.min=Mi(e.min,t.min),t.max=Mi(e.max,t.max),t.min===t.max&&(0!==t.min&&null!==t.min?(t.min=Math.pow(10,Math.floor(ut.log10(t.min))-1),t.max=Math.pow(10,Math.floor(ut.log10(t.max))+1)):(t.min=1,t.max=10)),null===t.min&&(t.min=Math.pow(10,Math.floor(ut.log10(t.max))-1)),null===t.max&&(t.max=0!==t.min?Math.pow(10,Math.floor(ut.log10(t.min))+1):10),null===t.minNotZero&&(t.min>0?t.minNotZero=t.min:t.max<1?t.minNotZero=Math.pow(10,Math.floor(ut.log10(t.max))):t.minNotZero=1)},buildTicks:function(){var t=this,e=t.options.ticks,i=!t.isHorizontal(),n={min:Mi(e.min),max:Mi(e.max)},a=t.ticks=function(t,e){var i,n,a=[],r=ki(t.min,Math.pow(10,Math.floor(ut.log10(e.min)))),o=Math.floor(ut.log10(e.max)),s=Math.ceil(e.max/Math.pow(10,o));0===r?(i=Math.floor(ut.log10(e.minNotZero)),n=Math.floor(e.minNotZero/Math.pow(10,i)),a.push(r),r=n*Math.pow(10,i)):(i=Math.floor(ut.log10(r)),n=Math.floor(r/Math.pow(10,i)));var l=i<0?Math.pow(10,Math.abs(i)):1;do{a.push(r),10==++n&&(n=1,l=++i>=0?1:l),r=Math.round(n*Math.pow(10,i)*l)/l}while(i<o||i===o&&n<s);var u=ki(t.max,r);return a.push(u),a}(n,t);t.max=ut.max(a),t.min=ut.min(a),e.reverse?(i=!i,t.start=t.max,t.end=t.min):(t.start=t.min,t.end=t.max),i&&a.reverse()},convertTicksToLabels:function(){this.tickValues=this.ticks.slice(),fi.prototype.convertTicksToLabels.call(this)},getLabelForIndex:function(t,e){return+this.getRightValue(this.chart.data.datasets[e].data[t])},getPixelForTick:function(t){return this.getPixelForValue(this.tickValues[t])},_getFirstTickValue:function(t){var e=Math.floor(ut.log10(t));return Math.floor(t/Math.pow(10,e))*Math.pow(10,e)},getPixelForValue:function(t){var e,i,n,a,r,o=this,s=o.options.ticks,l=s.reverse,u=ut.log10,d=o._getFirstTickValue(o.minNotZero),h=0;return t=+o.getRightValue(t),l?(n=o.end,a=o.start,r=-1):(n=o.start,a=o.end,r=1),o.isHorizontal()?(e=o.width,i=l?o.right:o.left):(e=o.height,r*=-1,i=l?o.top:o.bottom),t!==n&&(0===n&&(e-=h=ki(s.fontSize,ot.global.defaultFontSize),n=d),0!==t&&(h+=e/(u(a)-u(n))*(u(t)-u(n))),i+=r*h),i},getValueForPixel:function(t){var e,i,n,a,r=this,o=r.options.ticks,s=o.reverse,l=ut.log10,u=r._getFirstTickValue(r.minNotZero);if(s?(i=r.end,n=r.start):(i=r.start,n=r.end),r.isHorizontal()?(e=r.width,a=s?r.right-t:t-r.left):(e=r.height,a=s?t-r.top:r.bottom-t),a!==i){if(0===i){var d=ki(o.fontSize,ot.global.defaultFontSize);a-=d,e-=d,i=u}a*=l(n)-l(i),a/=e,a=Math.pow(10,l(i)+a)}return a}}),Di=wi;Si._defaults=Di;var Ci=ut.valueOrDefault,Pi=ut.valueAtIndexOrDefault,Ti=ut.options.resolve,Oi={display:!0,animate:!0,position:"chartArea",angleLines:{display:!0,color:"rgba(0, 0, 0, 0.1)",lineWidth:1,borderDash:[],borderDashOffset:0},gridLines:{circular:!1},ticks:{showLabelBackdrop:!0,backdropColor:"rgba(255,255,255,0.75)",backdropPaddingY:2,backdropPaddingX:2,callback:li.formatters.linear},pointLabels:{display:!0,fontSize:10,callback:function(t){return t}}};function Ii(t){var e=t.options;return e.angleLines.display||e.pointLabels.display?t.chart.data.labels.length:0}function Ai(t){var e=t.ticks;return e.display&&t.display?Ci(e.fontSize,ot.global.defaultFontSize)+2*e.backdropPaddingY:0}function Fi(t,e,i,n,a){return t===n||t===a?{start:e-i/2,end:e+i/2}:t<n||t>a?{start:e-i,end:e}:{start:e,end:e+i}}function Ri(t){return 0===t||180===t?"center":t<180?"left":"right"}function Li(t,e,i,n){var a,r,o=i.y+n/2;if(ut.isArray(e))for(a=0,r=e.length;a<r;++a)t.fillText(e[a],i.x,o),o+=n;else t.fillText(e,i.x,o)}function Wi(t,e,i){90===t||270===t?i.y-=e.h/2:(t>270||t<90)&&(i.y-=e.h)}function Yi(t){return ut.isNumber(t)?t:0}var Ni=yi.extend({setDimensions:function(){var t=this;t.width=t.maxWidth,t.height=t.maxHeight,t.paddingTop=Ai(t.options)/2,t.xCenter=Math.floor(t.width/2),t.yCenter=Math.floor((t.height-t.paddingTop)/2),t.drawingArea=Math.min(t.height-t.paddingTop,t.width)/2},determineDataLimits:function(){var t=this,e=t.chart,i=Number.POSITIVE_INFINITY,n=Number.NEGATIVE_INFINITY;ut.each(e.data.datasets,function(a,r){if(e.isDatasetVisible(r)){var o=e.getDatasetMeta(r);ut.each(a.data,function(e,a){var r=+t.getRightValue(e);isNaN(r)||o.data[a].hidden||(i=Math.min(r,i),n=Math.max(r,n))})}}),t.min=i===Number.POSITIVE_INFINITY?0:i,t.max=n===Number.NEGATIVE_INFINITY?0:n,t.handleTickRangeOptions()},_computeTickLimit:function(){return Math.ceil(this.drawingArea/Ai(this.options))},convertTicksToLabels:function(){var t=this;yi.prototype.convertTicksToLabels.call(t),t.pointLabels=t.chart.data.labels.map(t.options.pointLabels.callback,t)},getLabelForIndex:function(t,e){return+this.getRightValue(this.chart.data.datasets[e].data[t])},fit:function(){var t=this.options;t.display&&t.pointLabels.display?function(t){var e,i,n,a=ut.options._parseFont(t.options.pointLabels),r={l:0,r:t.width,t:0,b:t.height-t.paddingTop},o={};t.ctx.font=a.string,t._pointLabelSizes=[];var s,l,u,d=Ii(t);for(e=0;e<d;e++){n=t.getPointPosition(e,t.drawingArea+5),s=t.ctx,l=a.lineHeight,u=t.pointLabels[e]||"",i=ut.isArray(u)?{w:ut.longestText(s,s.font,u),h:u.length*l}:{w:s.measureText(u).width,h:l},t._pointLabelSizes[e]=i;var h=t.getIndexAngle(e),c=ut.toDegrees(h)%360,f=Fi(c,n.x,i.w,0,180),g=Fi(c,n.y,i.h,90,270);f.start<r.l&&(r.l=f.start,o.l=h),f.end>r.r&&(r.r=f.end,o.r=h),g.start<r.t&&(r.t=g.start,o.t=h),g.end>r.b&&(r.b=g.end,o.b=h)}t.setReductions(t.drawingArea,r,o)}(this):this.setCenterPoint(0,0,0,0)},setReductions:function(t,e,i){var n=this,a=e.l/Math.sin(i.l),r=Math.max(e.r-n.width,0)/Math.sin(i.r),o=-e.t/Math.cos(i.t),s=-Math.max(e.b-(n.height-n.paddingTop),0)/Math.cos(i.b);a=Yi(a),r=Yi(r),o=Yi(o),s=Yi(s),n.drawingArea=Math.min(Math.floor(t-(a+r)/2),Math.floor(t-(o+s)/2)),n.setCenterPoint(a,r,o,s)},setCenterPoint:function(t,e,i,n){var a=this,r=a.width-e-a.drawingArea,o=t+a.drawingArea,s=i+a.drawingArea,l=a.height-a.paddingTop-n-a.drawingArea;a.xCenter=Math.floor((o+r)/2+a.left),a.yCenter=Math.floor((s+l)/2+a.top+a.paddingTop)},getIndexAngle:function(t){return t*(2*Math.PI/Ii(this))+(this.chart.options&&this.chart.options.startAngle?this.chart.options.startAngle:0)*Math.PI*2/360},getDistanceFromCenterForValue:function(t){var e=this;if(null===t)return 0;var i=e.drawingArea/(e.max-e.min);return e.options.ticks.reverse?(e.max-t)*i:(t-e.min)*i},getPointPosition:function(t,e){var i=this.getIndexAngle(t)-Math.PI/2;return{x:Math.cos(i)*e+this.xCenter,y:Math.sin(i)*e+this.yCenter}},getPointPositionForValue:function(t,e){return this.getPointPosition(t,this.getDistanceFromCenterForValue(e))},getBasePosition:function(){var t=this.min,e=this.max;return this.getPointPositionForValue(0,this.beginAtZero?0:t<0&&e<0?e:t>0&&e>0?t:0)},draw:function(){var t=this,e=t.options,i=e.gridLines,n=e.ticks;if(e.display){var a=t.ctx,r=this.getIndexAngle(0),o=ut.options._parseFont(n);(e.angleLines.display||e.pointLabels.display)&&function(t){var e=t.ctx,i=t.options,n=i.angleLines,a=i.gridLines,r=i.pointLabels,o=Ci(n.lineWidth,a.lineWidth),s=Ci(n.color,a.color),l=Ai(i);e.save(),e.lineWidth=o,e.strokeStyle=s,e.setLineDash&&(e.setLineDash(Ti([n.borderDash,a.borderDash,[]])),e.lineDashOffset=Ti([n.borderDashOffset,a.borderDashOffset,0]));var u=t.getDistanceFromCenterForValue(i.ticks.reverse?t.min:t.max),d=ut.options._parseFont(r);e.font=d.string,e.textBaseline="middle";for(var h=Ii(t)-1;h>=0;h--){if(n.display&&o&&s){var c=t.getPointPosition(h,u);e.beginPath(),e.moveTo(t.xCenter,t.yCenter),e.lineTo(c.x,c.y),e.stroke()}if(r.display){var f=0===h?l/2:0,g=t.getPointPosition(h,u+f+5),m=Pi(r.fontColor,h,ot.global.defaultFontColor);e.fillStyle=m;var p=t.getIndexAngle(h),v=ut.toDegrees(p);e.textAlign=Ri(v),Wi(v,t._pointLabelSizes[h],g),Li(e,t.pointLabels[h]||"",g,d.lineHeight)}}e.restore()}(t),ut.each(t.ticks,function(e,s){if(s>0||n.reverse){var l=t.getDistanceFromCenterForValue(t.ticksAsNumbers[s]);if(i.display&&0!==s&&function(t,e,i,n){var a,r=t.ctx,o=e.circular,s=Ii(t),l=Pi(e.color,n-1),u=Pi(e.lineWidth,n-1);if((o||s)&&l&&u){if(r.save(),r.strokeStyle=l,r.lineWidth=u,r.setLineDash&&(r.setLineDash(e.borderDash||[]),r.lineDashOffset=e.borderDashOffset||0),r.beginPath(),o)r.arc(t.xCenter,t.yCenter,i,0,2*Math.PI);else{a=t.getPointPosition(0,i),r.moveTo(a.x,a.y);for(var d=1;d<s;d++)a=t.getPointPosition(d,i),r.lineTo(a.x,a.y)}r.closePath(),r.stroke(),r.restore()}}(t,i,l,s),n.display){var u=Ci(n.fontColor,ot.global.defaultFontColor);if(a.font=o.string,a.save(),a.translate(t.xCenter,t.yCenter),a.rotate(r),n.showLabelBackdrop){var d=a.measureText(e).width;a.fillStyle=n.backdropColor,a.fillRect(-d/2-n.backdropPaddingX,-l-o.size/2-n.backdropPaddingY,d+2*n.backdropPaddingX,o.size+2*n.backdropPaddingY)}a.textAlign="center",a.textBaseline="middle",a.fillStyle=u,a.fillText(e,0,-l),a.restore()}}})}}}),zi=Oi;Ni._defaults=zi;var Vi=ut.valueOrDefault,Hi=Number.MIN_SAFE_INTEGER||-9007199254740991,Ei=Number.MAX_SAFE_INTEGER||9007199254740991,Bi={millisecond:{common:!0,size:1,steps:[1,2,5,10,20,50,100,250,500]},second:{common:!0,size:1e3,steps:[1,2,5,10,15,30]},minute:{common:!0,size:6e4,steps:[1,2,5,10,15,30]},hour:{common:!0,size:36e5,steps:[1,2,3,6,12]},day:{common:!0,size:864e5,steps:[1,2,5]},week:{common:!1,size:6048e5,steps:[1,2,3,4]},month:{common:!0,size:2628e6,steps:[1,2,3]},quarter:{common:!1,size:7884e6,steps:[1,2,3,4]},year:{common:!0,size:3154e7}},ji=Object.keys(Bi);function Ui(t,e){return t-e}function Gi(t){var e,i,n,a={},r=[];for(e=0,i=t.length;e<i;++e)a[n=t[e]]||(a[n]=!0,r.push(n));return r}function qi(t,e,i,n){var a=function(t,e,i){for(var n,a,r,o=0,s=t.length-1;o>=0&&o<=s;){if(a=t[(n=o+s>>1)-1]||null,r=t[n],!a)return{lo:null,hi:r};if(r[e]<i)o=n+1;else{if(!(a[e]>i))return{lo:a,hi:r};s=n-1}}return{lo:r,hi:null}}(t,e,i),r=a.lo?a.hi?a.lo:t[t.length-2]:t[0],o=a.lo?a.hi?a.hi:t[t.length-1]:t[1],s=o[e]-r[e],l=s?(i-r[e])/s:0,u=(o[n]-r[n])*l;return r[n]+u}function Zi(t,e){var i=t._adapter,n=t.options.time,a=n.parser,r=a||n.format,o=e;return"function"==typeof a&&(o=a(o)),ut.isFinite(o)||(o="string"==typeof r?i.parse(o,r):i.parse(o)),null!==o?+o:(a||"function"!=typeof r||(o=r(e),ut.isFinite(o)||(o=i.parse(o))),o)}function $i(t,e){if(ut.isNullOrUndef(e))return null;var i=t.options.time,n=Zi(t,t.getRightValue(e));return null===n?n:(i.round&&(n=+t._adapter.startOf(n,i.round)),n)}function Xi(t){for(var e=ji.indexOf(t)+1,i=ji.length;e<i;++e)if(Bi[ji[e]].common)return ji[e]}function Ki(t,e,i,n){var a,r=t._adapter,o=t.options,s=o.time,l=s.unit||function(t,e,i,n){var a,r,o,s=ji.length;for(a=ji.indexOf(t);a<s-1;++a)if(o=(r=Bi[ji[a]]).steps?r.steps[r.steps.length-1]:Ei,r.common&&Math.ceil((i-e)/(o*r.size))<=n)return ji[a];return ji[s-1]}(s.minUnit,e,i,n),u=Xi(l),d=Vi(s.stepSize,s.unitStepSize),h="week"===l&&s.isoWeekday,c=o.ticks.major.enabled,f=Bi[l],g=e,m=i,p=[];for(d||(d=function(t,e,i,n){var a,r,o,s=e-t,l=Bi[i],u=l.size,d=l.steps;if(!d)return Math.ceil(s/(n*u));for(a=0,r=d.length;a<r&&(o=d[a],!(Math.ceil(s/(u*o))<=n));++a);return o}(e,i,l,n)),h&&(g=+r.startOf(g,"isoWeek",h),m=+r.startOf(m,"isoWeek",h)),g=+r.startOf(g,h?"day":l),(m=+r.startOf(m,h?"day":l))<i&&(m=+r.add(m,1,l)),a=g,c&&u&&!h&&!s.round&&(a=+r.startOf(a,u),a=+r.add(a,~~((g-a)/(f.size*d))*d,l));a<m;a=+r.add(a,d,l))p.push(+a);return p.push(+a),p}var Ji=fi.extend({initialize:function(){this.mergeTicksOptions(),fi.prototype.initialize.call(this)},update:function(){var t=this.options,e=t.time||(t.time={}),i=this._adapter=new si._date(t.adapters.date);return e.format&&console.warn("options.time.format is deprecated and replaced by options.time.parser."),ut.mergeIf(e.displayFormats,i.formats()),fi.prototype.update.apply(this,arguments)},getRightValue:function(t){return t&&void 0!==t.t&&(t=t.t),fi.prototype.getRightValue.call(this,t)},determineDataLimits:function(){var t,e,i,n,a,r,o=this,s=o.chart,l=o._adapter,u=o.options.time,d=u.unit||"day",h=Ei,c=Hi,f=[],g=[],m=[],p=s.data.labels||[];for(t=0,i=p.length;t<i;++t)m.push($i(o,p[t]));for(t=0,i=(s.data.datasets||[]).length;t<i;++t)if(s.isDatasetVisible(t))if(a=s.data.datasets[t].data,ut.isObject(a[0]))for(g[t]=[],e=0,n=a.length;e<n;++e)r=$i(o,a[e]),f.push(r),g[t][e]=r;else{for(e=0,n=m.length;e<n;++e)f.push(m[e]);g[t]=m.slice(0)}else g[t]=[];m.length&&(m=Gi(m).sort(Ui),h=Math.min(h,m[0]),c=Math.max(c,m[m.length-1])),f.length&&(f=Gi(f).sort(Ui),h=Math.min(h,f[0]),c=Math.max(c,f[f.length-1])),h=$i(o,u.min)||h,c=$i(o,u.max)||c,h=h===Ei?+l.startOf(Date.now(),d):h,c=c===Hi?+l.endOf(Date.now(),d)+1:c,o.min=Math.min(h,c),o.max=Math.max(h+1,c),o._horizontal=o.isHorizontal(),o._table=[],o._timestamps={data:f,datasets:g,labels:m}},buildTicks:function(){var t,e,i,n=this,a=n.min,r=n.max,o=n.options,s=o.time,l=[],u=[];switch(o.ticks.source){case"data":l=n._timestamps.data;break;case"labels":l=n._timestamps.labels;break;case"auto":default:l=Ki(n,a,r,n.getLabelCapacity(a))}for("ticks"===o.bounds&&l.length&&(a=l[0],r=l[l.length-1]),a=$i(n,s.min)||a,r=$i(n,s.max)||r,t=0,e=l.length;t<e;++t)(i=l[t])>=a&&i<=r&&u.push(i);return n.min=a,n.max=r,n._unit=s.unit||function(t,e,i,n,a){var r,o;for(r=ji.length-1;r>=ji.indexOf(i);r--)if(o=ji[r],Bi[o].common&&t._adapter.diff(a,n,o)>=e.length)return o;return ji[i?ji.indexOf(i):0]}(n,u,s.minUnit,n.min,n.max),n._majorUnit=Xi(n._unit),n._table=function(t,e,i,n){if("linear"===n||!t.length)return[{time:e,pos:0},{time:i,pos:1}];var a,r,o,s,l,u=[],d=[e];for(a=0,r=t.length;a<r;++a)(s=t[a])>e&&s<i&&d.push(s);for(d.push(i),a=0,r=d.length;a<r;++a)l=d[a+1],o=d[a-1],s=d[a],void 0!==o&&void 0!==l&&Math.round((l+o)/2)===s||u.push({time:s,pos:a/(r-1)});return u}(n._timestamps.data,a,r,o.distribution),n._offsets=function(t,e,i,n,a){var r,o,s=0,l=0;return a.offset&&e.length&&(a.time.min||(r=qi(t,"time",e[0],"pos"),s=1===e.length?1-r:(qi(t,"time",e[1],"pos")-r)/2),a.time.max||(o=qi(t,"time",e[e.length-1],"pos"),l=1===e.length?o:(o-qi(t,"time",e[e.length-2],"pos"))/2)),{start:s,end:l}}(n._table,u,0,0,o),o.ticks.reverse&&u.reverse(),function(t,e,i){var n,a,r,o,s=[];for(n=0,a=e.length;n<a;++n)r=e[n],o=!!i&&r===+t._adapter.startOf(r,i),s.push({value:r,major:o});return s}(n,u,n._majorUnit)},getLabelForIndex:function(t,e){var i=this,n=i._adapter,a=i.chart.data,r=i.options.time,o=a.labels&&t<a.labels.length?a.labels[t]:"",s=a.datasets[e].data[t];return ut.isObject(s)&&(o=i.getRightValue(s)),r.tooltipFormat?n.format(Zi(i,o),r.tooltipFormat):"string"==typeof o?o:n.format(Zi(i,o),r.displayFormats.datetime)},tickFormatFunction:function(t,e,i,n){var a=this._adapter,r=this.options,o=r.time.displayFormats,s=o[this._unit],l=this._majorUnit,u=o[l],d=+a.startOf(t,l),h=r.ticks.major,c=h.enabled&&l&&u&&t===d,f=a.format(t,n||(c?u:s)),g=c?h:r.ticks.minor,m=Vi(g.callback,g.userCallback);return m?m(f,e,i):f},convertTicksToLabels:function(t){var e,i,n=[];for(e=0,i=t.length;e<i;++e)n.push(this.tickFormatFunction(t[e].value,e,t));return n},getPixelForOffset:function(t){var e=this,i=e.options.ticks.reverse,n=e._horizontal?e.width:e.height,a=e._horizontal?i?e.right:e.left:i?e.bottom:e.top,r=qi(e._table,"time",t,"pos"),o=n*(e._offsets.start+r)/(e._offsets.start+1+e._offsets.end);return i?a-o:a+o},getPixelForValue:function(t,e,i){var n=null;if(void 0!==e&&void 0!==i&&(n=this._timestamps.datasets[i][e]),null===n&&(n=$i(this,t)),null!==n)return this.getPixelForOffset(n)},getPixelForTick:function(t){var e=this.getTicks();return t>=0&&t<e.length?this.getPixelForOffset(e[t].value):null},getValueForPixel:function(t){var e=this,i=e._horizontal?e.width:e.height,n=e._horizontal?e.left:e.top,a=(i?(t-n)/i:0)*(e._offsets.start+1+e._offsets.start)-e._offsets.end,r=qi(e._table,"pos",a,"time");return e._adapter._create(r)},getLabelWidth:function(t){var e=this.options.ticks,i=this.ctx.measureText(t).width,n=ut.toRadians(e.maxRotation),a=Math.cos(n),r=Math.sin(n);return i*a+Vi(e.fontSize,ot.global.defaultFontSize)*r},getLabelCapacity:function(t){var e=this,i=e.options.time.displayFormats.millisecond,n=e.tickFormatFunction(t,0,[],i),a=e.getLabelWidth(n),r=e.isHorizontal()?e.width:e.height,o=Math.floor(r/a);return o>0?o:1}}),Qi={position:"bottom",distribution:"linear",bounds:"data",adapters:{},time:{parser:!1,format:!1,unit:!1,round:!1,displayFormat:!1,isoWeekday:!1,minUnit:"millisecond",displayFormats:{}},ticks:{autoSkip:!1,source:"auto",major:{enabled:!1}}};Ji._defaults=Qi;var tn,en={category:gi,linear:xi,logarithmic:Si,radialLinear:Ni,time:Ji},nn=(function(t,e){t.exports=function(){var e,i;function n(){return e.apply(null,arguments)}function a(t){return t instanceof Array||"[object Array]"===Object.prototype.toString.call(t)}function r(t){return null!=t&&"[object Object]"===Object.prototype.toString.call(t)}function o(t){return void 0===t}function s(t){return"number"==typeof t||"[object Number]"===Object.prototype.toString.call(t)}function l(t){return t instanceof Date||"[object Date]"===Object.prototype.toString.call(t)}function u(t,e){var i,n=[];for(i=0;i<t.length;++i)n.push(e(t[i],i));return n}function d(t,e){return Object.prototype.hasOwnProperty.call(t,e)}function h(t,e){for(var i in e)d(e,i)&&(t[i]=e[i]);return d(e,"toString")&&(t.toString=e.toString),d(e,"valueOf")&&(t.valueOf=e.valueOf),t}function c(t,e,i,n){return Oe(t,e,i,n,!0).utc()}function f(t){return null==t._pf&&(t._pf={empty:!1,unusedTokens:[],unusedInput:[],overflow:-2,charsLeftOver:0,nullInput:!1,invalidMonth:null,invalidFormat:!1,userInvalidated:!1,iso:!1,parsedDateParts:[],meridiem:null,rfc2822:!1,weekdayMismatch:!1}),t._pf}function g(t){if(null==t._isValid){var e=f(t),n=i.call(e.parsedDateParts,function(t){return null!=t}),a=!isNaN(t._d.getTime())&&e.overflow<0&&!e.empty&&!e.invalidMonth&&!e.invalidWeekday&&!e.weekdayMismatch&&!e.nullInput&&!e.invalidFormat&&!e.userInvalidated&&(!e.meridiem||e.meridiem&&n);if(t._strict&&(a=a&&0===e.charsLeftOver&&0===e.unusedTokens.length&&void 0===e.bigHour),null!=Object.isFrozen&&Object.isFrozen(t))return a;t._isValid=a}return t._isValid}function m(t){var e=c(NaN);return null!=t?h(f(e),t):f(e).userInvalidated=!0,e}i=Array.prototype.some?Array.prototype.some:function(t){for(var e=Object(this),i=e.length>>>0,n=0;n<i;n++)if(n in e&&t.call(this,e[n],n,e))return!0;return!1};var p=n.momentProperties=[];function v(t,e){var i,n,a;if(o(e._isAMomentObject)||(t._isAMomentObject=e._isAMomentObject),o(e._i)||(t._i=e._i),o(e._f)||(t._f=e._f),o(e._l)||(t._l=e._l),o(e._strict)||(t._strict=e._strict),o(e._tzm)||(t._tzm=e._tzm),o(e._isUTC)||(t._isUTC=e._isUTC),o(e._offset)||(t._offset=e._offset),o(e._pf)||(t._pf=f(e)),o(e._locale)||(t._locale=e._locale),p.length>0)for(i=0;i<p.length;i++)n=p[i],o(a=e[n])||(t[n]=a);return t}var y=!1;function b(t){v(this,t),this._d=new Date(null!=t._d?t._d.getTime():NaN),this.isValid()||(this._d=new Date(NaN)),!1===y&&(y=!0,n.updateOffset(this),y=!1)}function x(t){return t instanceof b||null!=t&&null!=t._isAMomentObject}function _(t){return t<0?Math.ceil(t)||0:Math.floor(t)}function k(t){var e=+t,i=0;return 0!==e&&isFinite(e)&&(i=_(e)),i}function w(t,e,i){var n,a=Math.min(t.length,e.length),r=Math.abs(t.length-e.length),o=0;for(n=0;n<a;n++)(i&&t[n]!==e[n]||!i&&k(t[n])!==k(e[n]))&&o++;return o+r}function M(t){!1===n.suppressDeprecationWarnings&&"undefined"!=typeof console&&console.warn&&console.warn("Deprecation warning: "+t)}function S(t,e){var i=!0;return h(function(){if(null!=n.deprecationHandler&&n.deprecationHandler(null,t),i){for(var a,r=[],o=0;o<arguments.length;o++){if(a="","object"==typeof arguments[o]){for(var s in a+="\n["+o+"] ",arguments[0])a+=s+": "+arguments[0][s]+", ";a=a.slice(0,-2)}else a=arguments[o];r.push(a)}M(t+"\nArguments: "+Array.prototype.slice.call(r).join("")+"\n"+(new Error).stack),i=!1}return e.apply(this,arguments)},e)}var D,C={};function P(t,e){null!=n.deprecationHandler&&n.deprecationHandler(t,e),C[t]||(M(e),C[t]=!0)}function T(t){return t instanceof Function||"[object Function]"===Object.prototype.toString.call(t)}function O(t,e){var i,n=h({},t);for(i in e)d(e,i)&&(r(t[i])&&r(e[i])?(n[i]={},h(n[i],t[i]),h(n[i],e[i])):null!=e[i]?n[i]=e[i]:delete n[i]);for(i in t)d(t,i)&&!d(e,i)&&r(t[i])&&(n[i]=h({},n[i]));return n}function I(t){null!=t&&this.set(t)}n.suppressDeprecationWarnings=!1,n.deprecationHandler=null,D=Object.keys?Object.keys:function(t){var e,i=[];for(e in t)d(t,e)&&i.push(e);return i};var A={};function F(t,e){var i=t.toLowerCase();A[i]=A[i+"s"]=A[e]=t}function R(t){return"string"==typeof t?A[t]||A[t.toLowerCase()]:void 0}function L(t){var e,i,n={};for(i in t)d(t,i)&&(e=R(i))&&(n[e]=t[i]);return n}var W={};function Y(t,e){W[t]=e}function N(t,e,i){var n=""+Math.abs(t),a=e-n.length,r=t>=0;return(r?i?"+":"":"-")+Math.pow(10,Math.max(0,a)).toString().substr(1)+n}var z=/(\[[^\[]*\])|(\\)?([Hh]mm(ss)?|Mo|MM?M?M?|Do|DDDo|DD?D?D?|ddd?d?|do?|w[o|w]?|W[o|W]?|Qo?|YYYYYY|YYYYY|YYYY|YY|gg(ggg?)?|GG(GGG?)?|e|E|a|A|hh?|HH?|kk?|mm?|ss?|S{1,9}|x|X|zz?|ZZ?|.)/g,V=/(\[[^\[]*\])|(\\)?(LTS|LT|LL?L?L?|l{1,4})/g,H={},E={};function B(t,e,i,n){var a=n;"string"==typeof n&&(a=function(){return this[n]()}),t&&(E[t]=a),e&&(E[e[0]]=function(){return N(a.apply(this,arguments),e[1],e[2])}),i&&(E[i]=function(){return this.localeData().ordinal(a.apply(this,arguments),t)})}function j(t,e){return t.isValid()?(e=U(e,t.localeData()),H[e]=H[e]||function(t){var e,i,n,a=t.match(z);for(e=0,i=a.length;e<i;e++)E[a[e]]?a[e]=E[a[e]]:a[e]=(n=a[e]).match(/\[[\s\S]/)?n.replace(/^\[|\]$/g,""):n.replace(/\\/g,"");return function(e){var n,r="";for(n=0;n<i;n++)r+=T(a[n])?a[n].call(e,t):a[n];return r}}(e),H[e](t)):t.localeData().invalidDate()}function U(t,e){var i=5;function n(t){return e.longDateFormat(t)||t}for(V.lastIndex=0;i>=0&&V.test(t);)t=t.replace(V,n),V.lastIndex=0,i-=1;return t}var G=/\d/,q=/\d\d/,Z=/\d{3}/,$=/\d{4}/,X=/[+-]?\d{6}/,K=/\d\d?/,J=/\d\d\d\d?/,Q=/\d\d\d\d\d\d?/,tt=/\d{1,3}/,et=/\d{1,4}/,it=/[+-]?\d{1,6}/,nt=/\d+/,at=/[+-]?\d+/,rt=/Z|[+-]\d\d:?\d\d/gi,ot=/Z|[+-]\d\d(?::?\d\d)?/gi,st=/[0-9]{0,256}['a-z\u00A0-\u05FF\u0700-\uD7FF\uF900-\uFDCF\uFDF0-\uFF07\uFF10-\uFFEF]{1,256}|[\u0600-\u06FF\/]{1,256}(\s*?[\u0600-\u06FF]{1,256}){1,2}/i,lt={};function ut(t,e,i){lt[t]=T(e)?e:function(t,n){return t&&i?i:e}}function dt(t,e){return d(lt,t)?lt[t](e._strict,e._locale):new RegExp(ht(t.replace("\\","").replace(/\\(\[)|\\(\])|\[([^\]\[]*)\]|\\(.)/g,function(t,e,i,n,a){return e||i||n||a})))}function ht(t){return t.replace(/[-\/\\^$*+?.()|[\]{}]/g,"\\$&")}var ct={};function ft(t,e){var i,n=e;for("string"==typeof t&&(t=[t]),s(e)&&(n=function(t,i){i[e]=k(t)}),i=0;i<t.length;i++)ct[t[i]]=n}function gt(t,e){ft(t,function(t,i,n,a){n._w=n._w||{},e(t,n._w,n,a)})}function mt(t,e,i){null!=e&&d(ct,t)&&ct[t](e,i._a,i,t)}var pt=0,vt=1,yt=2,bt=3,xt=4,_t=5,kt=6,wt=7,Mt=8;function St(t){return Dt(t)?366:365}function Dt(t){return t%4==0&&t%100!=0||t%400==0}B("Y",0,0,function(){var t=this.year();return t<=9999?""+t:"+"+t}),B(0,["YY",2],0,function(){return this.year()%100}),B(0,["YYYY",4],0,"year"),B(0,["YYYYY",5],0,"year"),B(0,["YYYYYY",6,!0],0,"year"),F("year","y"),Y("year",1),ut("Y",at),ut("YY",K,q),ut("YYYY",et,$),ut("YYYYY",it,X),ut("YYYYYY",it,X),ft(["YYYYY","YYYYYY"],pt),ft("YYYY",function(t,e){e[pt]=2===t.length?n.parseTwoDigitYear(t):k(t)}),ft("YY",function(t,e){e[pt]=n.parseTwoDigitYear(t)}),ft("Y",function(t,e){e[pt]=parseInt(t,10)}),n.parseTwoDigitYear=function(t){return k(t)+(k(t)>68?1900:2e3)};var Ct,Pt=Tt("FullYear",!0);function Tt(t,e){return function(i){return null!=i?(It(this,t,i),n.updateOffset(this,e),this):Ot(this,t)}}function Ot(t,e){return t.isValid()?t._d["get"+(t._isUTC?"UTC":"")+e]():NaN}function It(t,e,i){t.isValid()&&!isNaN(i)&&("FullYear"===e&&Dt(t.year())&&1===t.month()&&29===t.date()?t._d["set"+(t._isUTC?"UTC":"")+e](i,t.month(),At(i,t.month())):t._d["set"+(t._isUTC?"UTC":"")+e](i))}function At(t,e){if(isNaN(t)||isNaN(e))return NaN;var i,n=(e%(i=12)+i)%i;return t+=(e-n)/12,1===n?Dt(t)?29:28:31-n%7%2}Ct=Array.prototype.indexOf?Array.prototype.indexOf:function(t){var e;for(e=0;e<this.length;++e)if(this[e]===t)return e;return-1},B("M",["MM",2],"Mo",function(){return this.month()+1}),B("MMM",0,0,function(t){return this.localeData().monthsShort(this,t)}),B("MMMM",0,0,function(t){return this.localeData().months(this,t)}),F("month","M"),Y("month",8),ut("M",K),ut("MM",K,q),ut("MMM",function(t,e){return e.monthsShortRegex(t)}),ut("MMMM",function(t,e){return e.monthsRegex(t)}),ft(["M","MM"],function(t,e){e[vt]=k(t)-1}),ft(["MMM","MMMM"],function(t,e,i,n){var a=i._locale.monthsParse(t,n,i._strict);null!=a?e[vt]=a:f(i).invalidMonth=t});var Ft=/D[oD]?(\[[^\[\]]*\]|\s)+MMMM?/,Rt="January_February_March_April_May_June_July_August_September_October_November_December".split("_"),Lt="Jan_Feb_Mar_Apr_May_Jun_Jul_Aug_Sep_Oct_Nov_Dec".split("_");function Wt(t,e){var i;if(!t.isValid())return t;if("string"==typeof e)if(/^\d+$/.test(e))e=k(e);else if(!s(e=t.localeData().monthsParse(e)))return t;return i=Math.min(t.date(),At(t.year(),e)),t._d["set"+(t._isUTC?"UTC":"")+"Month"](e,i),t}function Yt(t){return null!=t?(Wt(this,t),n.updateOffset(this,!0),this):Ot(this,"Month")}var Nt=st,zt=st;function Vt(){function t(t,e){return e.length-t.length}var e,i,n=[],a=[],r=[];for(e=0;e<12;e++)i=c([2e3,e]),n.push(this.monthsShort(i,"")),a.push(this.months(i,"")),r.push(this.months(i,"")),r.push(this.monthsShort(i,""));for(n.sort(t),a.sort(t),r.sort(t),e=0;e<12;e++)n[e]=ht(n[e]),a[e]=ht(a[e]);for(e=0;e<24;e++)r[e]=ht(r[e]);this._monthsRegex=new RegExp("^("+r.join("|")+")","i"),this._monthsShortRegex=this._monthsRegex,this._monthsStrictRegex=new RegExp("^("+a.join("|")+")","i"),this._monthsShortStrictRegex=new RegExp("^("+n.join("|")+")","i")}function Ht(t){var e;if(t<100&&t>=0){var i=Array.prototype.slice.call(arguments);i[0]=t+400,e=new Date(Date.UTC.apply(null,i)),isFinite(e.getUTCFullYear())&&e.setUTCFullYear(t)}else e=new Date(Date.UTC.apply(null,arguments));return e}function Et(t,e,i){var n=7+e-i,a=(7+Ht(t,0,n).getUTCDay()-e)%7;return-a+n-1}function Bt(t,e,i,n,a){var r,o,s=(7+i-n)%7,l=Et(t,n,a),u=1+7*(e-1)+s+l;return u<=0?o=St(r=t-1)+u:u>St(t)?(r=t+1,o=u-St(t)):(r=t,o=u),{year:r,dayOfYear:o}}function jt(t,e,i){var n,a,r=Et(t.year(),e,i),o=Math.floor((t.dayOfYear()-r-1)/7)+1;return o<1?(a=t.year()-1,n=o+Ut(a,e,i)):o>Ut(t.year(),e,i)?(n=o-Ut(t.year(),e,i),a=t.year()+1):(a=t.year(),n=o),{week:n,year:a}}function Ut(t,e,i){var n=Et(t,e,i),a=Et(t+1,e,i);return(St(t)-n+a)/7}function Gt(t,e){return t.slice(e,7).concat(t.slice(0,e))}B("w",["ww",2],"wo","week"),B("W",["WW",2],"Wo","isoWeek"),F("week","w"),F("isoWeek","W"),Y("week",5),Y("isoWeek",5),ut("w",K),ut("ww",K,q),ut("W",K),ut("WW",K,q),gt(["w","ww","W","WW"],function(t,e,i,n){e[n.substr(0,1)]=k(t)}),B("d",0,"do","day"),B("dd",0,0,function(t){return this.localeData().weekdaysMin(this,t)}),B("ddd",0,0,function(t){return this.localeData().weekdaysShort(this,t)}),B("dddd",0,0,function(t){return this.localeData().weekdays(this,t)}),B("e",0,0,"weekday"),B("E",0,0,"isoWeekday"),F("day","d"),F("weekday","e"),F("isoWeekday","E"),Y("day",11),Y("weekday",11),Y("isoWeekday",11),ut("d",K),ut("e",K),ut("E",K),ut("dd",function(t,e){return e.weekdaysMinRegex(t)}),ut("ddd",function(t,e){return e.weekdaysShortRegex(t)}),ut("dddd",function(t,e){return e.weekdaysRegex(t)}),gt(["dd","ddd","dddd"],function(t,e,i,n){var a=i._locale.weekdaysParse(t,n,i._strict);null!=a?e.d=a:f(i).invalidWeekday=t}),gt(["d","e","E"],function(t,e,i,n){e[n]=k(t)});var qt="Sunday_Monday_Tuesday_Wednesday_Thursday_Friday_Saturday".split("_"),Zt="Sun_Mon_Tue_Wed_Thu_Fri_Sat".split("_"),$t="Su_Mo_Tu_We_Th_Fr_Sa".split("_"),Xt=st,Kt=st,Jt=st;function Qt(){function t(t,e){return e.length-t.length}var e,i,n,a,r,o=[],s=[],l=[],u=[];for(e=0;e<7;e++)i=c([2e3,1]).day(e),n=this.weekdaysMin(i,""),a=this.weekdaysShort(i,""),r=this.weekdays(i,""),o.push(n),s.push(a),l.push(r),u.push(n),u.push(a),u.push(r);for(o.sort(t),s.sort(t),l.sort(t),u.sort(t),e=0;e<7;e++)s[e]=ht(s[e]),l[e]=ht(l[e]),u[e]=ht(u[e]);this._weekdaysRegex=new RegExp("^("+u.join("|")+")","i"),this._weekdaysShortRegex=this._weekdaysRegex,this._weekdaysMinRegex=this._weekdaysRegex,this._weekdaysStrictRegex=new RegExp("^("+l.join("|")+")","i"),this._weekdaysShortStrictRegex=new RegExp("^("+s.join("|")+")","i"),this._weekdaysMinStrictRegex=new RegExp("^("+o.join("|")+")","i")}function te(){return this.hours()%12||12}function ee(t,e){B(t,0,0,function(){return this.localeData().meridiem(this.hours(),this.minutes(),e)})}function ie(t,e){return e._meridiemParse}B("H",["HH",2],0,"hour"),B("h",["hh",2],0,te),B("k",["kk",2],0,function(){return this.hours()||24}),B("hmm",0,0,function(){return""+te.apply(this)+N(this.minutes(),2)}),B("hmmss",0,0,function(){return""+te.apply(this)+N(this.minutes(),2)+N(this.seconds(),2)}),B("Hmm",0,0,function(){return""+this.hours()+N(this.minutes(),2)}),B("Hmmss",0,0,function(){return""+this.hours()+N(this.minutes(),2)+N(this.seconds(),2)}),ee("a",!0),ee("A",!1),F("hour","h"),Y("hour",13),ut("a",ie),ut("A",ie),ut("H",K),ut("h",K),ut("k",K),ut("HH",K,q),ut("hh",K,q),ut("kk",K,q),ut("hmm",J),ut("hmmss",Q),ut("Hmm",J),ut("Hmmss",Q),ft(["H","HH"],bt),ft(["k","kk"],function(t,e,i){var n=k(t);e[bt]=24===n?0:n}),ft(["a","A"],function(t,e,i){i._isPm=i._locale.isPM(t),i._meridiem=t}),ft(["h","hh"],function(t,e,i){e[bt]=k(t),f(i).bigHour=!0}),ft("hmm",function(t,e,i){var n=t.length-2;e[bt]=k(t.substr(0,n)),e[xt]=k(t.substr(n)),f(i).bigHour=!0}),ft("hmmss",function(t,e,i){var n=t.length-4,a=t.length-2;e[bt]=k(t.substr(0,n)),e[xt]=k(t.substr(n,2)),e[_t]=k(t.substr(a)),f(i).bigHour=!0}),ft("Hmm",function(t,e,i){var n=t.length-2;e[bt]=k(t.substr(0,n)),e[xt]=k(t.substr(n))}),ft("Hmmss",function(t,e,i){var n=t.length-4,a=t.length-2;e[bt]=k(t.substr(0,n)),e[xt]=k(t.substr(n,2)),e[_t]=k(t.substr(a))});var ne,ae=Tt("Hours",!0),re={calendar:{sameDay:"[Today at] LT",nextDay:"[Tomorrow at] LT",nextWeek:"dddd [at] LT",lastDay:"[Yesterday at] LT",lastWeek:"[Last] dddd [at] LT",sameElse:"L"},longDateFormat:{LTS:"h:mm:ss A",LT:"h:mm A",L:"MM/DD/YYYY",LL:"MMMM D, YYYY",LLL:"MMMM D, YYYY h:mm A",LLLL:"dddd, MMMM D, YYYY h:mm A"},invalidDate:"Invalid date",ordinal:"%d",dayOfMonthOrdinalParse:/\d{1,2}/,relativeTime:{future:"in %s",past:"%s ago",s:"a few seconds",ss:"%d seconds",m:"a minute",mm:"%d minutes",h:"an hour",hh:"%d hours",d:"a day",dd:"%d days",M:"a month",MM:"%d months",y:"a year",yy:"%d years"},months:Rt,monthsShort:Lt,week:{dow:0,doy:6},weekdays:qt,weekdaysMin:$t,weekdaysShort:Zt,meridiemParse:/[ap]\.?m?\.?/i},oe={},se={};function le(t){return t?t.toLowerCase().replace("_","-"):t}function ue(e){var i=null;if(!oe[e]&&t&&t.exports)try{i=ne._abbr;var n=_e;n("./locale/"+e),de(i)}catch(t){}return oe[e]}function de(t,e){var i;return t&&((i=o(e)?ce(t):he(t,e))?ne=i:"undefined"!=typeof console&&console.warn&&console.warn("Locale "+t+" not found. Did you forget to load it?")),ne._abbr}function he(t,e){if(null!==e){var i,n=re;if(e.abbr=t,null!=oe[t])P("defineLocaleOverride","use moment.updateLocale(localeName, config) to change an existing locale. moment.defineLocale(localeName, config) should only be used for creating a new locale See http://momentjs.com/guides/#/warnings/define-locale/ for more info."),n=oe[t]._config;else if(null!=e.parentLocale)if(null!=oe[e.parentLocale])n=oe[e.parentLocale]._config;else{if(null==(i=ue(e.parentLocale)))return se[e.parentLocale]||(se[e.parentLocale]=[]),se[e.parentLocale].push({name:t,config:e}),null;n=i._config}return oe[t]=new I(O(n,e)),se[t]&&se[t].forEach(function(t){he(t.name,t.config)}),de(t),oe[t]}return delete oe[t],null}function ce(t){var e;if(t&&t._locale&&t._locale._abbr&&(t=t._locale._abbr),!t)return ne;if(!a(t)){if(e=ue(t))return e;t=[t]}return function(t){for(var e,i,n,a,r=0;r<t.length;){for(a=le(t[r]).split("-"),e=a.length,i=(i=le(t[r+1]))?i.split("-"):null;e>0;){if(n=ue(a.slice(0,e).join("-")))return n;if(i&&i.length>=e&&w(a,i,!0)>=e-1)break;e--}r++}return ne}(t)}function fe(t){var e,i=t._a;return i&&-2===f(t).overflow&&(e=i[vt]<0||i[vt]>11?vt:i[yt]<1||i[yt]>At(i[pt],i[vt])?yt:i[bt]<0||i[bt]>24||24===i[bt]&&(0!==i[xt]||0!==i[_t]||0!==i[kt])?bt:i[xt]<0||i[xt]>59?xt:i[_t]<0||i[_t]>59?_t:i[kt]<0||i[kt]>999?kt:-1,f(t)._overflowDayOfYear&&(e<pt||e>yt)&&(e=yt),f(t)._overflowWeeks&&-1===e&&(e=wt),f(t)._overflowWeekday&&-1===e&&(e=Mt),f(t).overflow=e),t}function ge(t,e,i){return null!=t?t:null!=e?e:i}function me(t){var e,i,a,r,o,s=[];if(!t._d){for(a=function(t){var e=new Date(n.now());return t._useUTC?[e.getUTCFullYear(),e.getUTCMonth(),e.getUTCDate()]:[e.getFullYear(),e.getMonth(),e.getDate()]}(t),t._w&&null==t._a[yt]&&null==t._a[vt]&&function(t){var e,i,n,a,r,o,s,l;if(null!=(e=t._w).GG||null!=e.W||null!=e.E)r=1,o=4,i=ge(e.GG,t._a[pt],jt(Ie(),1,4).year),n=ge(e.W,1),((a=ge(e.E,1))<1||a>7)&&(l=!0);else{r=t._locale._week.dow,o=t._locale._week.doy;var u=jt(Ie(),r,o);i=ge(e.gg,t._a[pt],u.year),n=ge(e.w,u.week),null!=e.d?((a=e.d)<0||a>6)&&(l=!0):null!=e.e?(a=e.e+r,(e.e<0||e.e>6)&&(l=!0)):a=r}n<1||n>Ut(i,r,o)?f(t)._overflowWeeks=!0:null!=l?f(t)._overflowWeekday=!0:(s=Bt(i,n,a,r,o),t._a[pt]=s.year,t._dayOfYear=s.dayOfYear)}(t),null!=t._dayOfYear&&(o=ge(t._a[pt],a[pt]),(t._dayOfYear>St(o)||0===t._dayOfYear)&&(f(t)._overflowDayOfYear=!0),i=Ht(o,0,t._dayOfYear),t._a[vt]=i.getUTCMonth(),t._a[yt]=i.getUTCDate()),e=0;e<3&&null==t._a[e];++e)t._a[e]=s[e]=a[e];for(;e<7;e++)t._a[e]=s[e]=null==t._a[e]?2===e?1:0:t._a[e];24===t._a[bt]&&0===t._a[xt]&&0===t._a[_t]&&0===t._a[kt]&&(t._nextDay=!0,t._a[bt]=0),t._d=(t._useUTC?Ht:function(t,e,i,n,a,r,o){var s;return t<100&&t>=0?(s=new Date(t+400,e,i,n,a,r,o),isFinite(s.getFullYear())&&s.setFullYear(t)):s=new Date(t,e,i,n,a,r,o),s}).apply(null,s),r=t._useUTC?t._d.getUTCDay():t._d.getDay(),null!=t._tzm&&t._d.setUTCMinutes(t._d.getUTCMinutes()-t._tzm),t._nextDay&&(t._a[bt]=24),t._w&&void 0!==t._w.d&&t._w.d!==r&&(f(t).weekdayMismatch=!0)}}var pe=/^\s*((?:[+-]\d{6}|\d{4})-(?:\d\d-\d\d|W\d\d-\d|W\d\d|\d\d\d|\d\d))(?:(T| )(\d\d(?::\d\d(?::\d\d(?:[.,]\d+)?)?)?)([\+\-]\d\d(?::?\d\d)?|\s*Z)?)?$/,ve=/^\s*((?:[+-]\d{6}|\d{4})(?:\d\d\d\d|W\d\d\d|W\d\d|\d\d\d|\d\d))(?:(T| )(\d\d(?:\d\d(?:\d\d(?:[.,]\d+)?)?)?)([\+\-]\d\d(?::?\d\d)?|\s*Z)?)?$/,ye=/Z|[+-]\d\d(?::?\d\d)?/,be=[["YYYYYY-MM-DD",/[+-]\d{6}-\d\d-\d\d/],["YYYY-MM-DD",/\d{4}-\d\d-\d\d/],["GGGG-[W]WW-E",/\d{4}-W\d\d-\d/],["GGGG-[W]WW",/\d{4}-W\d\d/,!1],["YYYY-DDD",/\d{4}-\d{3}/],["YYYY-MM",/\d{4}-\d\d/,!1],["YYYYYYMMDD",/[+-]\d{10}/],["YYYYMMDD",/\d{8}/],["GGGG[W]WWE",/\d{4}W\d{3}/],["GGGG[W]WW",/\d{4}W\d{2}/,!1],["YYYYDDD",/\d{7}/]],xe=[["HH:mm:ss.SSSS",/\d\d:\d\d:\d\d\.\d+/],["HH:mm:ss,SSSS",/\d\d:\d\d:\d\d,\d+/],["HH:mm:ss",/\d\d:\d\d:\d\d/],["HH:mm",/\d\d:\d\d/],["HHmmss.SSSS",/\d\d\d\d\d\d\.\d+/],["HHmmss,SSSS",/\d\d\d\d\d\d,\d+/],["HHmmss",/\d\d\d\d\d\d/],["HHmm",/\d\d\d\d/],["HH",/\d\d/]],ke=/^\/?Date\((\-?\d+)/i;function we(t){var e,i,n,a,r,o,s=t._i,l=pe.exec(s)||ve.exec(s);if(l){for(f(t).iso=!0,e=0,i=be.length;e<i;e++)if(be[e][1].exec(l[1])){a=be[e][0],n=!1!==be[e][2];break}if(null==a)return void(t._isValid=!1);if(l[3]){for(e=0,i=xe.length;e<i;e++)if(xe[e][1].exec(l[3])){r=(l[2]||" ")+xe[e][0];break}if(null==r)return void(t._isValid=!1)}if(!n&&null!=r)return void(t._isValid=!1);if(l[4]){if(!ye.exec(l[4]))return void(t._isValid=!1);o="Z"}t._f=a+(r||"")+(o||""),Pe(t)}else t._isValid=!1}var Me=/^(?:(Mon|Tue|Wed|Thu|Fri|Sat|Sun),?\s)?(\d{1,2})\s(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)\s(\d{2,4})\s(\d\d):(\d\d)(?::(\d\d))?\s(?:(UT|GMT|[ECMP][SD]T)|([Zz])|([+-]\d{4}))$/;function Se(t){var e=parseInt(t,10);return e<=49?2e3+e:e<=999?1900+e:e}var De={UT:0,GMT:0,EDT:-240,EST:-300,CDT:-300,CST:-360,MDT:-360,MST:-420,PDT:-420,PST:-480};function Ce(t){var e,i,n,a,r,o,s,l=Me.exec(t._i.replace(/\([^)]*\)|[\n\t]/g," ").replace(/(\s\s+)/g," ").replace(/^\s\s*/,"").replace(/\s\s*$/,""));if(l){var u=(e=l[4],i=l[3],n=l[2],a=l[5],r=l[6],o=l[7],s=[Se(e),Lt.indexOf(i),parseInt(n,10),parseInt(a,10),parseInt(r,10)],o&&s.push(parseInt(o,10)),s);if(!function(t,e,i){if(t){var n=Zt.indexOf(t),a=new Date(e[0],e[1],e[2]).getDay();if(n!==a)return f(i).weekdayMismatch=!0,i._isValid=!1,!1}return!0}(l[1],u,t))return;t._a=u,t._tzm=function(t,e,i){if(t)return De[t];if(e)return 0;var n=parseInt(i,10),a=n%100,r=(n-a)/100;return 60*r+a}(l[8],l[9],l[10]),t._d=Ht.apply(null,t._a),t._d.setUTCMinutes(t._d.getUTCMinutes()-t._tzm),f(t).rfc2822=!0}else t._isValid=!1}function Pe(t){if(t._f!==n.ISO_8601)if(t._f!==n.RFC_2822){t._a=[],f(t).empty=!0;var e,i,a,r,o,s=""+t._i,l=s.length,u=0;for(a=U(t._f,t._locale).match(z)||[],e=0;e<a.length;e++)r=a[e],(i=(s.match(dt(r,t))||[])[0])&&((o=s.substr(0,s.indexOf(i))).length>0&&f(t).unusedInput.push(o),s=s.slice(s.indexOf(i)+i.length),u+=i.length),E[r]?(i?f(t).empty=!1:f(t).unusedTokens.push(r),mt(r,i,t)):t._strict&&!i&&f(t).unusedTokens.push(r);f(t).charsLeftOver=l-u,s.length>0&&f(t).unusedInput.push(s),t._a[bt]<=12&&!0===f(t).bigHour&&t._a[bt]>0&&(f(t).bigHour=void 0),f(t).parsedDateParts=t._a.slice(0),f(t).meridiem=t._meridiem,t._a[bt]=(d=t._locale,h=t._a[bt],null==(c=t._meridiem)?h:null!=d.meridiemHour?d.meridiemHour(h,c):null!=d.isPM?((g=d.isPM(c))&&h<12&&(h+=12),g||12!==h||(h=0),h):h),me(t),fe(t)}else Ce(t);else we(t);var d,h,c,g}function Te(t){var e=t._i,i=t._f;return t._locale=t._locale||ce(t._l),null===e||void 0===i&&""===e?m({nullInput:!0}):("string"==typeof e&&(t._i=e=t._locale.preparse(e)),x(e)?new b(fe(e)):(l(e)?t._d=e:a(i)?function(t){var e,i,n,a,r;if(0===t._f.length)return f(t).invalidFormat=!0,void(t._d=new Date(NaN));for(a=0;a<t._f.length;a++)r=0,e=v({},t),null!=t._useUTC&&(e._useUTC=t._useUTC),e._f=t._f[a],Pe(e),g(e)&&(r+=f(e).charsLeftOver,r+=10*f(e).unusedTokens.length,f(e).score=r,(null==n||r<n)&&(n=r,i=e));h(t,i||e)}(t):i?Pe(t):function(t){var e=t._i;o(e)?t._d=new Date(n.now()):l(e)?t._d=new Date(e.valueOf()):"string"==typeof e?function(t){var e=ke.exec(t._i);null===e?(we(t),!1===t._isValid&&(delete t._isValid,Ce(t),!1===t._isValid&&(delete t._isValid,n.createFromInputFallback(t)))):t._d=new Date(+e[1])}(t):a(e)?(t._a=u(e.slice(0),function(t){return parseInt(t,10)}),me(t)):r(e)?function(t){if(!t._d){var e=L(t._i);t._a=u([e.year,e.month,e.day||e.date,e.hour,e.minute,e.second,e.millisecond],function(t){return t&&parseInt(t,10)}),me(t)}}(t):s(e)?t._d=new Date(e):n.createFromInputFallback(t)}(t),g(t)||(t._d=null),t))}function Oe(t,e,i,n,o){var s,l={};return!0!==i&&!1!==i||(n=i,i=void 0),(r(t)&&function(t){if(Object.getOwnPropertyNames)return 0===Object.getOwnPropertyNames(t).length;var e;for(e in t)if(t.hasOwnProperty(e))return!1;return!0}(t)||a(t)&&0===t.length)&&(t=void 0),l._isAMomentObject=!0,l._useUTC=l._isUTC=o,l._l=i,l._i=t,l._f=e,l._strict=n,(s=new b(fe(Te(l))))._nextDay&&(s.add(1,"d"),s._nextDay=void 0),s}function Ie(t,e,i,n){return Oe(t,e,i,n,!1)}n.createFromInputFallback=S("value provided is not in a recognized RFC2822 or ISO format. moment construction falls back to js Date(), which is not reliable across all browsers and versions. Non RFC2822/ISO date formats are discouraged and will be removed in an upcoming major release. Please refer to http://momentjs.com/guides/#/warnings/js-date/ for more info.",function(t){t._d=new Date(t._i+(t._useUTC?" UTC":""))}),n.ISO_8601=function(){},n.RFC_2822=function(){};var Ae=S("moment().min is deprecated, use moment.max instead. http://momentjs.com/guides/#/warnings/min-max/",function(){var t=Ie.apply(null,arguments);return this.isValid()&&t.isValid()?t<this?this:t:m()}),Fe=S("moment().max is deprecated, use moment.min instead. http://momentjs.com/guides/#/warnings/min-max/",function(){var t=Ie.apply(null,arguments);return this.isValid()&&t.isValid()?t>this?this:t:m()});function Re(t,e){var i,n;if(1===e.length&&a(e[0])&&(e=e[0]),!e.length)return Ie();for(i=e[0],n=1;n<e.length;++n)e[n].isValid()&&!e[n][t](i)||(i=e[n]);return i}var Le=["year","quarter","month","week","day","hour","minute","second","millisecond"];function We(t){var e=L(t),i=e.year||0,n=e.quarter||0,a=e.month||0,r=e.week||e.isoWeek||0,o=e.day||0,s=e.hour||0,l=e.minute||0,u=e.second||0,d=e.millisecond||0;this._isValid=function(t){for(var e in t)if(-1===Ct.call(Le,e)||null!=t[e]&&isNaN(t[e]))return!1;for(var i=!1,n=0;n<Le.length;++n)if(t[Le[n]]){if(i)return!1;parseFloat(t[Le[n]])!==k(t[Le[n]])&&(i=!0)}return!0}(e),this._milliseconds=+d+1e3*u+6e4*l+1e3*s*60*60,this._days=+o+7*r,this._months=+a+3*n+12*i,this._data={},this._locale=ce(),this._bubble()}function Ye(t){return t instanceof We}function Ne(t){return t<0?-1*Math.round(-1*t):Math.round(t)}function ze(t,e){B(t,0,0,function(){var t=this.utcOffset(),i="+";return t<0&&(t=-t,i="-"),i+N(~~(t/60),2)+e+N(~~t%60,2)})}ze("Z",":"),ze("ZZ",""),ut("Z",ot),ut("ZZ",ot),ft(["Z","ZZ"],function(t,e,i){i._useUTC=!0,i._tzm=He(ot,t)});var Ve=/([\+\-]|\d\d)/gi;function He(t,e){var i=(e||"").match(t);if(null===i)return null;var n=i[i.length-1]||[],a=(n+"").match(Ve)||["-",0,0],r=60*a[1]+k(a[2]);return 0===r?0:"+"===a[0]?r:-r}function Ee(t,e){var i,a;return e._isUTC?(i=e.clone(),a=(x(t)||l(t)?t.valueOf():Ie(t).valueOf())-i.valueOf(),i._d.setTime(i._d.valueOf()+a),n.updateOffset(i,!1),i):Ie(t).local()}function Be(t){return 15*-Math.round(t._d.getTimezoneOffset()/15)}function je(){return!!this.isValid()&&this._isUTC&&0===this._offset}n.updateOffset=function(){};var Ue=/^(\-|\+)?(?:(\d*)[. ])?(\d+)\:(\d+)(?:\:(\d+)(\.\d*)?)?$/,Ge=/^(-|\+)?P(?:([-+]?[0-9,.]*)Y)?(?:([-+]?[0-9,.]*)M)?(?:([-+]?[0-9,.]*)W)?(?:([-+]?[0-9,.]*)D)?(?:T(?:([-+]?[0-9,.]*)H)?(?:([-+]?[0-9,.]*)M)?(?:([-+]?[0-9,.]*)S)?)?$/;function qe(t,e){var i,n,a,r,o,l,u=t,h=null;return Ye(t)?u={ms:t._milliseconds,d:t._days,M:t._months}:s(t)?(u={},e?u[e]=t:u.milliseconds=t):(h=Ue.exec(t))?(i="-"===h[1]?-1:1,u={y:0,d:k(h[yt])*i,h:k(h[bt])*i,m:k(h[xt])*i,s:k(h[_t])*i,ms:k(Ne(1e3*h[kt]))*i}):(h=Ge.exec(t))?(i="-"===h[1]?-1:1,u={y:Ze(h[2],i),M:Ze(h[3],i),w:Ze(h[4],i),d:Ze(h[5],i),h:Ze(h[6],i),m:Ze(h[7],i),s:Ze(h[8],i)}):null==u?u={}:"object"==typeof u&&("from"in u||"to"in u)&&(r=Ie(u.from),o=Ie(u.to),a=r.isValid()&&o.isValid()?(o=Ee(o,r),r.isBefore(o)?l=$e(r,o):((l=$e(o,r)).milliseconds=-l.milliseconds,l.months=-l.months),l):{milliseconds:0,months:0},(u={}).ms=a.milliseconds,u.M=a.months),n=new We(u),Ye(t)&&d(t,"_locale")&&(n._locale=t._locale),n}function Ze(t,e){var i=t&&parseFloat(t.replace(",","."));return(isNaN(i)?0:i)*e}function $e(t,e){var i={};return i.months=e.month()-t.month()+12*(e.year()-t.year()),t.clone().add(i.months,"M").isAfter(e)&&--i.months,i.milliseconds=+e-+t.clone().add(i.months,"M"),i}function Xe(t,e){return function(i,n){var a;return null===n||isNaN(+n)||(P(e,"moment()."+e+"(period, number) is deprecated. Please use moment()."+e+"(number, period). See http://momentjs.com/guides/#/warnings/add-inverted-param/ for more info."),a=i,i=n,n=a),Ke(this,qe(i="string"==typeof i?+i:i,n),t),this}}function Ke(t,e,i,a){var r=e._milliseconds,o=Ne(e._days),s=Ne(e._months);t.isValid()&&(a=null==a||a,s&&Wt(t,Ot(t,"Month")+s*i),o&&It(t,"Date",Ot(t,"Date")+o*i),r&&t._d.setTime(t._d.valueOf()+r*i),a&&n.updateOffset(t,o||s))}qe.fn=We.prototype,qe.invalid=function(){return qe(NaN)};var Je=Xe(1,"add"),Qe=Xe(-1,"subtract");function ti(t,e){var i,n,a=12*(e.year()-t.year())+(e.month()-t.month()),r=t.clone().add(a,"months");return e-r<0?(i=t.clone().add(a-1,"months"),n=(e-r)/(r-i)):(i=t.clone().add(a+1,"months"),n=(e-r)/(i-r)),-(a+n)||0}function ei(t){var e;return void 0===t?this._locale._abbr:(null!=(e=ce(t))&&(this._locale=e),this)}n.defaultFormat="YYYY-MM-DDTHH:mm:ssZ",n.defaultFormatUtc="YYYY-MM-DDTHH:mm:ss[Z]";var ii=S("moment().lang() is deprecated. Instead, use moment().localeData() to get the language configuration. Use moment().locale() to change languages.",function(t){return void 0===t?this.localeData():this.locale(t)});function ni(){return this._locale}var ai=1e3,ri=60*ai,oi=60*ri,si=3506328*oi;function li(t,e){return(t%e+e)%e}function ui(t,e,i){return t<100&&t>=0?new Date(t+400,e,i)-si:new Date(t,e,i).valueOf()}function di(t,e,i){return t<100&&t>=0?Date.UTC(t+400,e,i)-si:Date.UTC(t,e,i)}function hi(t,e){B(0,[t,t.length],0,e)}function ci(t,e,i,n,a){var r;return null==t?jt(this,n,a).year:(r=Ut(t,n,a),e>r&&(e=r),function(t,e,i,n,a){var r=Bt(t,e,i,n,a),o=Ht(r.year,0,r.dayOfYear);return this.year(o.getUTCFullYear()),this.month(o.getUTCMonth()),this.date(o.getUTCDate()),this}.call(this,t,e,i,n,a))}B(0,["gg",2],0,function(){return this.weekYear()%100}),B(0,["GG",2],0,function(){return this.isoWeekYear()%100}),hi("gggg","weekYear"),hi("ggggg","weekYear"),hi("GGGG","isoWeekYear"),hi("GGGGG","isoWeekYear"),F("weekYear","gg"),F("isoWeekYear","GG"),Y("weekYear",1),Y("isoWeekYear",1),ut("G",at),ut("g",at),ut("GG",K,q),ut("gg",K,q),ut("GGGG",et,$),ut("gggg",et,$),ut("GGGGG",it,X),ut("ggggg",it,X),gt(["gggg","ggggg","GGGG","GGGGG"],function(t,e,i,n){e[n.substr(0,2)]=k(t)}),gt(["gg","GG"],function(t,e,i,a){e[a]=n.parseTwoDigitYear(t)}),B("Q",0,"Qo","quarter"),F("quarter","Q"),Y("quarter",7),ut("Q",G),ft("Q",function(t,e){e[vt]=3*(k(t)-1)}),B("D",["DD",2],"Do","date"),F("date","D"),Y("date",9),ut("D",K),ut("DD",K,q),ut("Do",function(t,e){return t?e._dayOfMonthOrdinalParse||e._ordinalParse:e._dayOfMonthOrdinalParseLenient}),ft(["D","DD"],yt),ft("Do",function(t,e){e[yt]=k(t.match(K)[0])});var fi=Tt("Date",!0);B("DDD",["DDDD",3],"DDDo","dayOfYear"),F("dayOfYear","DDD"),Y("dayOfYear",4),ut("DDD",tt),ut("DDDD",Z),ft(["DDD","DDDD"],function(t,e,i){i._dayOfYear=k(t)}),B("m",["mm",2],0,"minute"),F("minute","m"),Y("minute",14),ut("m",K),ut("mm",K,q),ft(["m","mm"],xt);var gi=Tt("Minutes",!1);B("s",["ss",2],0,"second"),F("second","s"),Y("second",15),ut("s",K),ut("ss",K,q),ft(["s","ss"],_t);var mi,pi=Tt("Seconds",!1);for(B("S",0,0,function(){return~~(this.millisecond()/100)}),B(0,["SS",2],0,function(){return~~(this.millisecond()/10)}),B(0,["SSS",3],0,"millisecond"),B(0,["SSSS",4],0,function(){return 10*this.millisecond()}),B(0,["SSSSS",5],0,function(){return 100*this.millisecond()}),B(0,["SSSSSS",6],0,function(){return 1e3*this.millisecond()}),B(0,["SSSSSSS",7],0,function(){return 1e4*this.millisecond()}),B(0,["SSSSSSSS",8],0,function(){return 1e5*this.millisecond()}),B(0,["SSSSSSSSS",9],0,function(){return 1e6*this.millisecond()}),F("millisecond","ms"),Y("millisecond",16),ut("S",tt,G),ut("SS",tt,q),ut("SSS",tt,Z),mi="SSSS";mi.length<=9;mi+="S")ut(mi,nt);function vi(t,e){e[kt]=k(1e3*("0."+t))}for(mi="S";mi.length<=9;mi+="S")ft(mi,vi);var yi=Tt("Milliseconds",!1);B("z",0,0,"zoneAbbr"),B("zz",0,0,"zoneName");var bi=b.prototype;function xi(t){return t}bi.add=Je,bi.calendar=function(t,e){var i=t||Ie(),a=Ee(i,this).startOf("day"),r=n.calendarFormat(this,a)||"sameElse",o=e&&(T(e[r])?e[r].call(this,i):e[r]);return this.format(o||this.localeData().calendar(r,this,Ie(i)))},bi.clone=function(){return new b(this)},bi.diff=function(t,e,i){var n,a,r;if(!this.isValid())return NaN;if(!(n=Ee(t,this)).isValid())return NaN;switch(a=6e4*(n.utcOffset()-this.utcOffset()),e=R(e)){case"year":r=ti(this,n)/12;break;case"month":r=ti(this,n);break;case"quarter":r=ti(this,n)/3;break;case"second":r=(this-n)/1e3;break;case"minute":r=(this-n)/6e4;break;case"hour":r=(this-n)/36e5;break;case"day":r=(this-n-a)/864e5;break;case"week":r=(this-n-a)/6048e5;break;default:r=this-n}return i?r:_(r)},bi.endOf=function(t){var e;if(void 0===(t=R(t))||"millisecond"===t||!this.isValid())return this;var i=this._isUTC?di:ui;switch(t){case"year":e=i(this.year()+1,0,1)-1;break;case"quarter":e=i(this.year(),this.month()-this.month()%3+3,1)-1;break;case"month":e=i(this.year(),this.month()+1,1)-1;break;case"week":e=i(this.year(),this.month(),this.date()-this.weekday()+7)-1;break;case"isoWeek":e=i(this.year(),this.month(),this.date()-(this.isoWeekday()-1)+7)-1;break;case"day":case"date":e=i(this.year(),this.month(),this.date()+1)-1;break;case"hour":e=this._d.valueOf(),e+=oi-li(e+(this._isUTC?0:this.utcOffset()*ri),oi)-1;break;case"minute":e=this._d.valueOf(),e+=ri-li(e,ri)-1;break;case"second":e=this._d.valueOf(),e+=ai-li(e,ai)-1}return this._d.setTime(e),n.updateOffset(this,!0),this},bi.format=function(t){t||(t=this.isUtc()?n.defaultFormatUtc:n.defaultFormat);var e=j(this,t);return this.localeData().postformat(e)},bi.from=function(t,e){return this.isValid()&&(x(t)&&t.isValid()||Ie(t).isValid())?qe({to:this,from:t}).locale(this.locale()).humanize(!e):this.localeData().invalidDate()},bi.fromNow=function(t){return this.from(Ie(),t)},bi.to=function(t,e){return this.isValid()&&(x(t)&&t.isValid()||Ie(t).isValid())?qe({from:this,to:t}).locale(this.locale()).humanize(!e):this.localeData().invalidDate()},bi.toNow=function(t){return this.to(Ie(),t)},bi.get=function(t){return T(this[t=R(t)])?this[t]():this},bi.invalidAt=function(){return f(this).overflow},bi.isAfter=function(t,e){var i=x(t)?t:Ie(t);return!(!this.isValid()||!i.isValid())&&("millisecond"===(e=R(e)||"millisecond")?this.valueOf()>i.valueOf():i.valueOf()<this.clone().startOf(e).valueOf())},bi.isBefore=function(t,e){var i=x(t)?t:Ie(t);return!(!this.isValid()||!i.isValid())&&("millisecond"===(e=R(e)||"millisecond")?this.valueOf()<i.valueOf():this.clone().endOf(e).valueOf()<i.valueOf())},bi.isBetween=function(t,e,i,n){var a=x(t)?t:Ie(t),r=x(e)?e:Ie(e);return!!(this.isValid()&&a.isValid()&&r.isValid())&&(("("===(n=n||"()")[0]?this.isAfter(a,i):!this.isBefore(a,i))&&(")"===n[1]?this.isBefore(r,i):!this.isAfter(r,i)))},bi.isSame=function(t,e){var i,n=x(t)?t:Ie(t);return!(!this.isValid()||!n.isValid())&&("millisecond"===(e=R(e)||"millisecond")?this.valueOf()===n.valueOf():(i=n.valueOf(),this.clone().startOf(e).valueOf()<=i&&i<=this.clone().endOf(e).valueOf()))},bi.isSameOrAfter=function(t,e){return this.isSame(t,e)||this.isAfter(t,e)},bi.isSameOrBefore=function(t,e){return this.isSame(t,e)||this.isBefore(t,e)},bi.isValid=function(){return g(this)},bi.lang=ii,bi.locale=ei,bi.localeData=ni,bi.max=Fe,bi.min=Ae,bi.parsingFlags=function(){return h({},f(this))},bi.set=function(t,e){if("object"==typeof t)for(var i=function(t){var e=[];for(var i in t)e.push({unit:i,priority:W[i]});return e.sort(function(t,e){return t.priority-e.priority}),e}(t=L(t)),n=0;n<i.length;n++)this[i[n].unit](t[i[n].unit]);else if(T(this[t=R(t)]))return this[t](e);return this},bi.startOf=function(t){var e;if(void 0===(t=R(t))||"millisecond"===t||!this.isValid())return this;var i=this._isUTC?di:ui;switch(t){case"year":e=i(this.year(),0,1);break;case"quarter":e=i(this.year(),this.month()-this.month()%3,1);break;case"month":e=i(this.year(),this.month(),1);break;case"week":e=i(this.year(),this.month(),this.date()-this.weekday());break;case"isoWeek":e=i(this.year(),this.month(),this.date()-(this.isoWeekday()-1));break;case"day":case"date":e=i(this.year(),this.month(),this.date());break;case"hour":e=this._d.valueOf(),e-=li(e+(this._isUTC?0:this.utcOffset()*ri),oi);break;case"minute":e=this._d.valueOf(),e-=li(e,ri);break;case"second":e=this._d.valueOf(),e-=li(e,ai)}return this._d.setTime(e),n.updateOffset(this,!0),this},bi.subtract=Qe,bi.toArray=function(){var t=this;return[t.year(),t.month(),t.date(),t.hour(),t.minute(),t.second(),t.millisecond()]},bi.toObject=function(){var t=this;return{years:t.year(),months:t.month(),date:t.date(),hours:t.hours(),minutes:t.minutes(),seconds:t.seconds(),milliseconds:t.milliseconds()}},bi.toDate=function(){return new Date(this.valueOf())},bi.toISOString=function(t){if(!this.isValid())return null;var e=!0!==t,i=e?this.clone().utc():this;return i.year()<0||i.year()>9999?j(i,e?"YYYYYY-MM-DD[T]HH:mm:ss.SSS[Z]":"YYYYYY-MM-DD[T]HH:mm:ss.SSSZ"):T(Date.prototype.toISOString)?e?this.toDate().toISOString():new Date(this.valueOf()+60*this.utcOffset()*1e3).toISOString().replace("Z",j(i,"Z")):j(i,e?"YYYY-MM-DD[T]HH:mm:ss.SSS[Z]":"YYYY-MM-DD[T]HH:mm:ss.SSSZ")},bi.inspect=function(){if(!this.isValid())return"moment.invalid(/* "+this._i+" */)";var t="moment",e="";this.isLocal()||(t=0===this.utcOffset()?"moment.utc":"moment.parseZone",e="Z");var i="["+t+'("]',n=0<=this.year()&&this.year()<=9999?"YYYY":"YYYYYY",a=e+'[")]';return this.format(i+n+"-MM-DD[T]HH:mm:ss.SSS"+a)},bi.toJSON=function(){return this.isValid()?this.toISOString():null},bi.toString=function(){return this.clone().locale("en").format("ddd MMM DD YYYY HH:mm:ss [GMT]ZZ")},bi.unix=function(){return Math.floor(this.valueOf()/1e3)},bi.valueOf=function(){return this._d.valueOf()-6e4*(this._offset||0)},bi.creationData=function(){return{input:this._i,format:this._f,locale:this._locale,isUTC:this._isUTC,strict:this._strict}},bi.year=Pt,bi.isLeapYear=function(){return Dt(this.year())},bi.weekYear=function(t){return ci.call(this,t,this.week(),this.weekday(),this.localeData()._week.dow,this.localeData()._week.doy)},bi.isoWeekYear=function(t){return ci.call(this,t,this.isoWeek(),this.isoWeekday(),1,4)},bi.quarter=bi.quarters=function(t){return null==t?Math.ceil((this.month()+1)/3):this.month(3*(t-1)+this.month()%3)},bi.month=Yt,bi.daysInMonth=function(){return At(this.year(),this.month())},bi.week=bi.weeks=function(t){var e=this.localeData().week(this);return null==t?e:this.add(7*(t-e),"d")},bi.isoWeek=bi.isoWeeks=function(t){var e=jt(this,1,4).week;return null==t?e:this.add(7*(t-e),"d")},bi.weeksInYear=function(){var t=this.localeData()._week;return Ut(this.year(),t.dow,t.doy)},bi.isoWeeksInYear=function(){return Ut(this.year(),1,4)},bi.date=fi,bi.day=bi.days=function(t){if(!this.isValid())return null!=t?this:NaN;var e=this._isUTC?this._d.getUTCDay():this._d.getDay();return null!=t?(t=function(t,e){return"string"!=typeof t?t:isNaN(t)?"number"==typeof(t=e.weekdaysParse(t))?t:null:parseInt(t,10)}(t,this.localeData()),this.add(t-e,"d")):e},bi.weekday=function(t){if(!this.isValid())return null!=t?this:NaN;var e=(this.day()+7-this.localeData()._week.dow)%7;return null==t?e:this.add(t-e,"d")},bi.isoWeekday=function(t){if(!this.isValid())return null!=t?this:NaN;if(null!=t){var e=function(t,e){return"string"==typeof t?e.weekdaysParse(t)%7||7:isNaN(t)?null:t}(t,this.localeData());return this.day(this.day()%7?e:e-7)}return this.day()||7},bi.dayOfYear=function(t){var e=Math.round((this.clone().startOf("day")-this.clone().startOf("year"))/864e5)+1;return null==t?e:this.add(t-e,"d")},bi.hour=bi.hours=ae,bi.minute=bi.minutes=gi,bi.second=bi.seconds=pi,bi.millisecond=bi.milliseconds=yi,bi.utcOffset=function(t,e,i){var a,r=this._offset||0;if(!this.isValid())return null!=t?this:NaN;if(null!=t){if("string"==typeof t){if(null===(t=He(ot,t)))return this}else Math.abs(t)<16&&!i&&(t*=60);return!this._isUTC&&e&&(a=Be(this)),this._offset=t,this._isUTC=!0,null!=a&&this.add(a,"m"),r!==t&&(!e||this._changeInProgress?Ke(this,qe(t-r,"m"),1,!1):this._changeInProgress||(this._changeInProgress=!0,n.updateOffset(this,!0),this._changeInProgress=null)),this}return this._isUTC?r:Be(this)},bi.utc=function(t){return this.utcOffset(0,t)},bi.local=function(t){return this._isUTC&&(this.utcOffset(0,t),this._isUTC=!1,t&&this.subtract(Be(this),"m")),this},bi.parseZone=function(){if(null!=this._tzm)this.utcOffset(this._tzm,!1,!0);else if("string"==typeof this._i){var t=He(rt,this._i);null!=t?this.utcOffset(t):this.utcOffset(0,!0)}return this},bi.hasAlignedHourOffset=function(t){return!!this.isValid()&&(t=t?Ie(t).utcOffset():0,(this.utcOffset()-t)%60==0)},bi.isDST=function(){return this.utcOffset()>this.clone().month(0).utcOffset()||this.utcOffset()>this.clone().month(5).utcOffset()},bi.isLocal=function(){return!!this.isValid()&&!this._isUTC},bi.isUtcOffset=function(){return!!this.isValid()&&this._isUTC},bi.isUtc=je,bi.isUTC=je,bi.zoneAbbr=function(){return this._isUTC?"UTC":""},bi.zoneName=function(){return this._isUTC?"Coordinated Universal Time":""},bi.dates=S("dates accessor is deprecated. Use date instead.",fi),bi.months=S("months accessor is deprecated. Use month instead",Yt),bi.years=S("years accessor is deprecated. Use year instead",Pt),bi.zone=S("moment().zone is deprecated, use moment().utcOffset instead. http://momentjs.com/guides/#/warnings/zone/",function(t,e){return null!=t?("string"!=typeof t&&(t=-t),this.utcOffset(t,e),this):-this.utcOffset()}),bi.isDSTShifted=S("isDSTShifted is deprecated. See http://momentjs.com/guides/#/warnings/dst-shifted/ for more information",function(){if(!o(this._isDSTShifted))return this._isDSTShifted;var t={};if(v(t,this),(t=Te(t))._a){var e=t._isUTC?c(t._a):Ie(t._a);this._isDSTShifted=this.isValid()&&w(t._a,e.toArray())>0}else this._isDSTShifted=!1;return this._isDSTShifted});var _i=I.prototype;function ki(t,e,i,n){var a=ce(),r=c().set(n,e);return a[i](r,t)}function wi(t,e,i){if(s(t)&&(e=t,t=void 0),t=t||"",null!=e)return ki(t,e,i,"month");var n,a=[];for(n=0;n<12;n++)a[n]=ki(t,n,i,"month");return a}function Mi(t,e,i,n){"boolean"==typeof t?(s(e)&&(i=e,e=void 0),e=e||""):(i=e=t,t=!1,s(e)&&(i=e,e=void 0),e=e||"");var a,r=ce(),o=t?r._week.dow:0;if(null!=i)return ki(e,(i+o)%7,n,"day");var l=[];for(a=0;a<7;a++)l[a]=ki(e,(a+o)%7,n,"day");return l}_i.calendar=function(t,e,i){var n=this._calendar[t]||this._calendar.sameElse;return T(n)?n.call(e,i):n},_i.longDateFormat=function(t){var e=this._longDateFormat[t],i=this._longDateFormat[t.toUpperCase()];return e||!i?e:(this._longDateFormat[t]=i.replace(/MMMM|MM|DD|dddd/g,function(t){return t.slice(1)}),this._longDateFormat[t])},_i.invalidDate=function(){return this._invalidDate},_i.ordinal=function(t){return this._ordinal.replace("%d",t)},_i.preparse=xi,_i.postformat=xi,_i.relativeTime=function(t,e,i,n){var a=this._relativeTime[i];return T(a)?a(t,e,i,n):a.replace(/%d/i,t)},_i.pastFuture=function(t,e){var i=this._relativeTime[t>0?"future":"past"];return T(i)?i(e):i.replace(/%s/i,e)},_i.set=function(t){var e,i;for(i in t)T(e=t[i])?this[i]=e:this["_"+i]=e;this._config=t,this._dayOfMonthOrdinalParseLenient=new RegExp((this._dayOfMonthOrdinalParse.source||this._ordinalParse.source)+"|"+/\d{1,2}/.source)},_i.months=function(t,e){return t?a(this._months)?this._months[t.month()]:this._months[(this._months.isFormat||Ft).test(e)?"format":"standalone"][t.month()]:a(this._months)?this._months:this._months.standalone},_i.monthsShort=function(t,e){return t?a(this._monthsShort)?this._monthsShort[t.month()]:this._monthsShort[Ft.test(e)?"format":"standalone"][t.month()]:a(this._monthsShort)?this._monthsShort:this._monthsShort.standalone},_i.monthsParse=function(t,e,i){var n,a,r;if(this._monthsParseExact)return function(t,e,i){var n,a,r,o=t.toLocaleLowerCase();if(!this._monthsParse)for(this._monthsParse=[],this._longMonthsParse=[],this._shortMonthsParse=[],n=0;n<12;++n)r=c([2e3,n]),this._shortMonthsParse[n]=this.monthsShort(r,"").toLocaleLowerCase(),this._longMonthsParse[n]=this.months(r,"").toLocaleLowerCase();return i?"MMM"===e?-1!==(a=Ct.call(this._shortMonthsParse,o))?a:null:-1!==(a=Ct.call(this._longMonthsParse,o))?a:null:"MMM"===e?-1!==(a=Ct.call(this._shortMonthsParse,o))?a:-1!==(a=Ct.call(this._longMonthsParse,o))?a:null:-1!==(a=Ct.call(this._longMonthsParse,o))?a:-1!==(a=Ct.call(this._shortMonthsParse,o))?a:null}.call(this,t,e,i);for(this._monthsParse||(this._monthsParse=[],this._longMonthsParse=[],this._shortMonthsParse=[]),n=0;n<12;n++){if(a=c([2e3,n]),i&&!this._longMonthsParse[n]&&(this._longMonthsParse[n]=new RegExp("^"+this.months(a,"").replace(".","")+"$","i"),this._shortMonthsParse[n]=new RegExp("^"+this.monthsShort(a,"").replace(".","")+"$","i")),i||this._monthsParse[n]||(r="^"+this.months(a,"")+"|^"+this.monthsShort(a,""),this._monthsParse[n]=new RegExp(r.replace(".",""),"i")),i&&"MMMM"===e&&this._longMonthsParse[n].test(t))return n;if(i&&"MMM"===e&&this._shortMonthsParse[n].test(t))return n;if(!i&&this._monthsParse[n].test(t))return n}},_i.monthsRegex=function(t){return this._monthsParseExact?(d(this,"_monthsRegex")||Vt.call(this),t?this._monthsStrictRegex:this._monthsRegex):(d(this,"_monthsRegex")||(this._monthsRegex=zt),this._monthsStrictRegex&&t?this._monthsStrictRegex:this._monthsRegex)},_i.monthsShortRegex=function(t){return this._monthsParseExact?(d(this,"_monthsRegex")||Vt.call(this),t?this._monthsShortStrictRegex:this._monthsShortRegex):(d(this,"_monthsShortRegex")||(this._monthsShortRegex=Nt),this._monthsShortStrictRegex&&t?this._monthsShortStrictRegex:this._monthsShortRegex)},_i.week=function(t){return jt(t,this._week.dow,this._week.doy).week},_i.firstDayOfYear=function(){return this._week.doy},_i.firstDayOfWeek=function(){return this._week.dow},_i.weekdays=function(t,e){var i=a(this._weekdays)?this._weekdays:this._weekdays[t&&!0!==t&&this._weekdays.isFormat.test(e)?"format":"standalone"];return!0===t?Gt(i,this._week.dow):t?i[t.day()]:i},_i.weekdaysMin=function(t){return!0===t?Gt(this._weekdaysMin,this._week.dow):t?this._weekdaysMin[t.day()]:this._weekdaysMin},_i.weekdaysShort=function(t){return!0===t?Gt(this._weekdaysShort,this._week.dow):t?this._weekdaysShort[t.day()]:this._weekdaysShort},_i.weekdaysParse=function(t,e,i){var n,a,r;if(this._weekdaysParseExact)return function(t,e,i){var n,a,r,o=t.toLocaleLowerCase();if(!this._weekdaysParse)for(this._weekdaysParse=[],this._shortWeekdaysParse=[],this._minWeekdaysParse=[],n=0;n<7;++n)r=c([2e3,1]).day(n),this._minWeekdaysParse[n]=this.weekdaysMin(r,"").toLocaleLowerCase(),this._shortWeekdaysParse[n]=this.weekdaysShort(r,"").toLocaleLowerCase(),this._weekdaysParse[n]=this.weekdays(r,"").toLocaleLowerCase();return i?"dddd"===e?-1!==(a=Ct.call(this._weekdaysParse,o))?a:null:"ddd"===e?-1!==(a=Ct.call(this._shortWeekdaysParse,o))?a:null:-1!==(a=Ct.call(this._minWeekdaysParse,o))?a:null:"dddd"===e?-1!==(a=Ct.call(this._weekdaysParse,o))?a:-1!==(a=Ct.call(this._shortWeekdaysParse,o))?a:-1!==(a=Ct.call(this._minWeekdaysParse,o))?a:null:"ddd"===e?-1!==(a=Ct.call(this._shortWeekdaysParse,o))?a:-1!==(a=Ct.call(this._weekdaysParse,o))?a:-1!==(a=Ct.call(this._minWeekdaysParse,o))?a:null:-1!==(a=Ct.call(this._minWeekdaysParse,o))?a:-1!==(a=Ct.call(this._weekdaysParse,o))?a:-1!==(a=Ct.call(this._shortWeekdaysParse,o))?a:null}.call(this,t,e,i);for(this._weekdaysParse||(this._weekdaysParse=[],this._minWeekdaysParse=[],this._shortWeekdaysParse=[],this._fullWeekdaysParse=[]),n=0;n<7;n++){if(a=c([2e3,1]).day(n),i&&!this._fullWeekdaysParse[n]&&(this._fullWeekdaysParse[n]=new RegExp("^"+this.weekdays(a,"").replace(".","\\.?")+"$","i"),this._shortWeekdaysParse[n]=new RegExp("^"+this.weekdaysShort(a,"").replace(".","\\.?")+"$","i"),this._minWeekdaysParse[n]=new RegExp("^"+this.weekdaysMin(a,"").replace(".","\\.?")+"$","i")),this._weekdaysParse[n]||(r="^"+this.weekdays(a,"")+"|^"+this.weekdaysShort(a,"")+"|^"+this.weekdaysMin(a,""),this._weekdaysParse[n]=new RegExp(r.replace(".",""),"i")),i&&"dddd"===e&&this._fullWeekdaysParse[n].test(t))return n;if(i&&"ddd"===e&&this._shortWeekdaysParse[n].test(t))return n;if(i&&"dd"===e&&this._minWeekdaysParse[n].test(t))return n;if(!i&&this._weekdaysParse[n].test(t))return n}},_i.weekdaysRegex=function(t){return this._weekdaysParseExact?(d(this,"_weekdaysRegex")||Qt.call(this),t?this._weekdaysStrictRegex:this._weekdaysRegex):(d(this,"_weekdaysRegex")||(this._weekdaysRegex=Xt),this._weekdaysStrictRegex&&t?this._weekdaysStrictRegex:this._weekdaysRegex)},_i.weekdaysShortRegex=function(t){return this._weekdaysParseExact?(d(this,"_weekdaysRegex")||Qt.call(this),t?this._weekdaysShortStrictRegex:this._weekdaysShortRegex):(d(this,"_weekdaysShortRegex")||(this._weekdaysShortRegex=Kt),this._weekdaysShortStrictRegex&&t?this._weekdaysShortStrictRegex:this._weekdaysShortRegex)},_i.weekdaysMinRegex=function(t){return this._weekdaysParseExact?(d(this,"_weekdaysRegex")||Qt.call(this),t?this._weekdaysMinStrictRegex:this._weekdaysMinRegex):(d(this,"_weekdaysMinRegex")||(this._weekdaysMinRegex=Jt),this._weekdaysMinStrictRegex&&t?this._weekdaysMinStrictRegex:this._weekdaysMinRegex)},_i.isPM=function(t){return"p"===(t+"").toLowerCase().charAt(0)},_i.meridiem=function(t,e,i){return t>11?i?"pm":"PM":i?"am":"AM"},de("en",{dayOfMonthOrdinalParse:/\d{1,2}(th|st|nd|rd)/,ordinal:function(t){var e=t%10,i=1===k(t%100/10)?"th":1===e?"st":2===e?"nd":3===e?"rd":"th";return t+i}}),n.lang=S("moment.lang is deprecated. Use moment.locale instead.",de),n.langData=S("moment.langData is deprecated. Use moment.localeData instead.",ce);var Si=Math.abs;function Di(t,e,i,n){var a=qe(e,i);return t._milliseconds+=n*a._milliseconds,t._days+=n*a._days,t._months+=n*a._months,t._bubble()}function Ci(t){return t<0?Math.floor(t):Math.ceil(t)}function Pi(t){return 4800*t/146097}function Ti(t){return 146097*t/4800}function Oi(t){return function(){return this.as(t)}}var Ii=Oi("ms"),Ai=Oi("s"),Fi=Oi("m"),Ri=Oi("h"),Li=Oi("d"),Wi=Oi("w"),Yi=Oi("M"),Ni=Oi("Q"),zi=Oi("y");function Vi(t){return function(){return this.isValid()?this._data[t]:NaN}}var Hi=Vi("milliseconds"),Ei=Vi("seconds"),Bi=Vi("minutes"),ji=Vi("hours"),Ui=Vi("days"),Gi=Vi("months"),qi=Vi("years"),Zi=Math.round,$i={ss:44,s:45,m:45,h:22,d:26,M:11},Xi=Math.abs;function Ki(t){return(t>0)-(t<0)||+t}function Ji(){if(!this.isValid())return this.localeData().invalidDate();var t,e,i=Xi(this._milliseconds)/1e3,n=Xi(this._days),a=Xi(this._months);t=_(i/60),e=_(t/60),i%=60,t%=60;var r=_(a/12),o=a%=12,s=n,l=e,u=t,d=i?i.toFixed(3).replace(/\.?0+$/,""):"",h=this.asSeconds();if(!h)return"P0D";var c=h<0?"-":"",f=Ki(this._months)!==Ki(h)?"-":"",g=Ki(this._days)!==Ki(h)?"-":"",m=Ki(this._milliseconds)!==Ki(h)?"-":"";return c+"P"+(r?f+r+"Y":"")+(o?f+o+"M":"")+(s?g+s+"D":"")+(l||u||d?"T":"")+(l?m+l+"H":"")+(u?m+u+"M":"")+(d?m+d+"S":"")}var Qi=We.prototype;return Qi.isValid=function(){return this._isValid},Qi.abs=function(){var t=this._data;return this._milliseconds=Si(this._milliseconds),this._days=Si(this._days),this._months=Si(this._months),t.milliseconds=Si(t.milliseconds),t.seconds=Si(t.seconds),t.minutes=Si(t.minutes),t.hours=Si(t.hours),t.months=Si(t.months),t.years=Si(t.years),this},Qi.add=function(t,e){return Di(this,t,e,1)},Qi.subtract=function(t,e){return Di(this,t,e,-1)},Qi.as=function(t){if(!this.isValid())return NaN;var e,i,n=this._milliseconds;if("month"===(t=R(t))||"quarter"===t||"year"===t)switch(e=this._days+n/864e5,i=this._months+Pi(e),t){case"month":return i;case"quarter":return i/3;case"year":return i/12}else switch(e=this._days+Math.round(Ti(this._months)),t){case"week":return e/7+n/6048e5;case"day":return e+n/864e5;case"hour":return 24*e+n/36e5;case"minute":return 1440*e+n/6e4;case"second":return 86400*e+n/1e3;case"millisecond":return Math.floor(864e5*e)+n;default:throw new Error("Unknown unit "+t)}},Qi.asMilliseconds=Ii,Qi.asSeconds=Ai,Qi.asMinutes=Fi,Qi.asHours=Ri,Qi.asDays=Li,Qi.asWeeks=Wi,Qi.asMonths=Yi,Qi.asQuarters=Ni,Qi.asYears=zi,Qi.valueOf=function(){return this.isValid()?this._milliseconds+864e5*this._days+this._months%12*2592e6+31536e6*k(this._months/12):NaN},Qi._bubble=function(){var t,e,i,n,a,r=this._milliseconds,o=this._days,s=this._months,l=this._data;return r>=0&&o>=0&&s>=0||r<=0&&o<=0&&s<=0||(r+=864e5*Ci(Ti(s)+o),o=0,s=0),l.milliseconds=r%1e3,t=_(r/1e3),l.seconds=t%60,e=_(t/60),l.minutes=e%60,i=_(e/60),l.hours=i%24,o+=_(i/24),a=_(Pi(o)),s+=a,o-=Ci(Ti(a)),n=_(s/12),s%=12,l.days=o,l.months=s,l.years=n,this},Qi.clone=function(){return qe(this)},Qi.get=function(t){return t=R(t),this.isValid()?this[t+"s"]():NaN},Qi.milliseconds=Hi,Qi.seconds=Ei,Qi.minutes=Bi,Qi.hours=ji,Qi.days=Ui,Qi.weeks=function(){return _(this.days()/7)},Qi.months=Gi,Qi.years=qi,Qi.humanize=function(t){if(!this.isValid())return this.localeData().invalidDate();var e=this.localeData(),i=function(t,e,i){var n=qe(t).abs(),a=Zi(n.as("s")),r=Zi(n.as("m")),o=Zi(n.as("h")),s=Zi(n.as("d")),l=Zi(n.as("M")),u=Zi(n.as("y")),d=a<=$i.ss&&["s",a]||a<$i.s&&["ss",a]||r<=1&&["m"]||r<$i.m&&["mm",r]||o<=1&&["h"]||o<$i.h&&["hh",o]||s<=1&&["d"]||s<$i.d&&["dd",s]||l<=1&&["M"]||l<$i.M&&["MM",l]||u<=1&&["y"]||["yy",u];return d[2]=e,d[3]=+t>0,d[4]=i,function(t,e,i,n,a){return a.relativeTime(e||1,!!i,t,n)}.apply(null,d)}(this,!t,e);return t&&(i=e.pastFuture(+this,i)),e.postformat(i)},Qi.toISOString=Ji,Qi.toString=Ji,Qi.toJSON=Ji,Qi.locale=ei,Qi.localeData=ni,Qi.toIsoString=S("toIsoString() is deprecated. Please use toISOString() instead (notice the capitals)",Ji),Qi.lang=ii,B("X",0,0,"unix"),B("x",0,0,"valueOf"),ut("x",at),ut("X",/[+-]?\d+(\.\d{1,3})?/),ft("X",function(t,e,i){i._d=new Date(1e3*parseFloat(t,10))}),ft("x",function(t,e,i){i._d=new Date(k(t))}),n.version="2.24.0",e=Ie,n.fn=bi,n.min=function(){return Re("isBefore",[].slice.call(arguments,0))},n.max=function(){return Re("isAfter",[].slice.call(arguments,0))},n.now=function(){return Date.now?Date.now():+new Date},n.utc=c,n.unix=function(t){return Ie(1e3*t)},n.months=function(t,e){return wi(t,e,"months")},n.isDate=l,n.locale=de,n.invalid=m,n.duration=qe,n.isMoment=x,n.weekdays=function(t,e,i){return Mi(t,e,i,"weekdays")},n.parseZone=function(){return Ie.apply(null,arguments).parseZone()},n.localeData=ce,n.isDuration=Ye,n.monthsShort=function(t,e){return wi(t,e,"monthsShort")},n.weekdaysMin=function(t,e,i){return Mi(t,e,i,"weekdaysMin")},n.defineLocale=he,n.updateLocale=function(t,e){if(null!=e){var i,n,a=re;null!=(n=ue(t))&&(a=n._config),e=O(a,e),(i=new I(e)).parentLocale=oe[t],oe[t]=i,de(t)}else null!=oe[t]&&(null!=oe[t].parentLocale?oe[t]=oe[t].parentLocale:null!=oe[t]&&delete oe[t]);return oe[t]},n.locales=function(){return D(oe)},n.weekdaysShort=function(t,e,i){return Mi(t,e,i,"weekdaysShort")},n.normalizeUnits=R,n.relativeTimeRounding=function(t){return void 0===t?Zi:"function"==typeof t&&(Zi=t,!0)},n.relativeTimeThreshold=function(t,e){return void 0!==$i[t]&&(void 0===e?$i[t]:($i[t]=e,"s"===t&&($i.ss=e-1),!0))},n.calendarFormat=function(t,e){var i=t.diff(e,"days",!0);return i<-6?"sameElse":i<-1?"lastWeek":i<0?"lastDay":i<1?"sameDay":i<2?"nextDay":i<7?"nextWeek":"sameElse"},n.prototype=bi,n.HTML5_FMT={DATETIME_LOCAL:"YYYY-MM-DDTHH:mm",DATETIME_LOCAL_SECONDS:"YYYY-MM-DDTHH:mm:ss",DATETIME_LOCAL_MS:"YYYY-MM-DDTHH:mm:ss.SSS",DATE:"YYYY-MM-DD",TIME:"HH:mm",TIME_SECONDS:"HH:mm:ss",TIME_MS:"HH:mm:ss.SSS",WEEK:"GGGG-[W]WW",MONTH:"YYYY-MM"},n}()}(tn={exports:{}},tn.exports),tn.exports),an={datetime:"MMM D, YYYY, h:mm:ss a",millisecond:"h:mm:ss.SSS a",second:"h:mm:ss a",minute:"h:mm a",hour:"hA",day:"MMM D",week:"ll",month:"MMM YYYY",quarter:"[Q]Q - YYYY",year:"YYYY"};si._date.override("function"==typeof nn?{_id:"moment",formats:function(){return an},parse:function(t,e){return"string"==typeof t&&"string"==typeof e?t=nn(t,e):t instanceof nn||(t=nn(t)),t.isValid()?t.valueOf():null},format:function(t,e){return nn(t).format(e)},add:function(t,e,i){return nn(t).add(e,i).valueOf()},diff:function(t,e,i){return nn.duration(nn(t).diff(nn(e))).as(i)},startOf:function(t,e,i){return t=nn(t),"isoWeek"===e?t.isoWeekday(i).valueOf():t.startOf(e).valueOf()},endOf:function(t,e){return nn(t).endOf(e).valueOf()},_create:function(t){return nn(t)}}:{}),ot._set("global",{plugins:{filler:{propagate:!0}}});var rn={dataset:function(t){var e=t.fill,i=t.chart,n=i.getDatasetMeta(e),a=n&&i.isDatasetVisible(e)&&n.dataset._children||[],r=a.length||0;return r?function(t,e){return e<r&&a[e]._view||null}:null},boundary:function(t){var e=t.boundary,i=e?e.x:null,n=e?e.y:null;return function(t){return{x:null===i?t.x:i,y:null===n?t.y:n}}}};function on(t,e,i){var n,a=t._model||{},r=a.fill;if(void 0===r&&(r=!!a.backgroundColor),!1===r||null===r)return!1;if(!0===r)return"origin";if(n=parseFloat(r,10),isFinite(n)&&Math.floor(n)===n)return"-"!==r[0]&&"+"!==r[0]||(n=e+n),!(n===e||n<0||n>=i)&&n;switch(r){case"bottom":return"start";case"top":return"end";case"zero":return"origin";case"origin":case"start":case"end":return r;default:return!1}}function sn(t){var e,i=t.el._model||{},n=t.el._scale||{},a=t.fill,r=null;if(isFinite(a))return null;if("start"===a?r=void 0===i.scaleBottom?n.bottom:i.scaleBottom:"end"===a?r=void 0===i.scaleTop?n.top:i.scaleTop:void 0!==i.scaleZero?r=i.scaleZero:n.getBasePosition?r=n.getBasePosition():n.getBasePixel&&(r=n.getBasePixel()),null!=r){if(void 0!==r.x&&void 0!==r.y)return r;if(ut.isFinite(r))return{x:(e=n.isHorizontal())?r:null,y:e?null:r}}return null}function ln(t,e,i){var n,a=t[e].fill,r=[e];if(!i)return a;for(;!1!==a&&-1===r.indexOf(a);){if(!isFinite(a))return a;if(!(n=t[a]))return!1;if(n.visible)return a;r.push(a),a=n.fill}return!1}function un(t){var e=t.fill,i="dataset";return!1===e?null:(isFinite(e)||(i="boundary"),rn[i](t))}function dn(t){return t&&!t.skip}function hn(t,e,i,n,a){var r;if(n&&a){for(t.moveTo(e[0].x,e[0].y),r=1;r<n;++r)ut.canvas.lineTo(t,e[r-1],e[r]);for(t.lineTo(i[a-1].x,i[a-1].y),r=a-1;r>0;--r)ut.canvas.lineTo(t,i[r],i[r-1],!0)}}var cn={id:"filler",afterDatasetsUpdate:function(t,e){var i,n,a,r,o=(t.data.datasets||[]).length,s=e.propagate,l=[];for(n=0;n<o;++n)r=null,(a=(i=t.getDatasetMeta(n)).dataset)&&a._model&&a instanceof Nt.Line&&(r={visible:t.isDatasetVisible(n),fill:on(a,n,o),chart:t,el:a}),i.$filler=r,l.push(r);for(n=0;n<o;++n)(r=l[n])&&(r.fill=ln(l,n,s),r.boundary=sn(r),r.mapper=un(r))},beforeDatasetDraw:function(t,e){var i=e.meta.$filler;if(i){var n=t.ctx,a=i.el,r=a._view,o=a._children||[],s=i.mapper,l=r.backgroundColor||ot.global.defaultColor;s&&l&&o.length&&(ut.canvas.clipArea(n,t.chartArea),function(t,e,i,n,a,r){var o,s,l,u,d,h,c,f=e.length,g=n.spanGaps,m=[],p=[],v=0,y=0;for(t.beginPath(),o=0,s=f+!!r;o<s;++o)d=i(u=e[l=o%f]._view,l,n),h=dn(u),c=dn(d),h&&c?(v=m.push(u),y=p.push(d)):v&&y&&(g?(h&&m.push(u),c&&p.push(d)):(hn(t,m,p,v,y),v=y=0,m=[],p=[]));hn(t,m,p,v,y),t.closePath(),t.fillStyle=a,t.fill()}(n,o,s,r,l,a._loop),ut.canvas.unclipArea(n))}}},fn=ut.noop,gn=ut.valueOrDefault;function mn(t,e){return t.usePointStyle&&t.boxWidth>e?e:t.boxWidth}ot._set("global",{legend:{display:!0,position:"top",fullWidth:!0,reverse:!1,weight:1e3,onClick:function(t,e){var i=e.datasetIndex,n=this.chart,a=n.getDatasetMeta(i);a.hidden=null===a.hidden?!n.data.datasets[i].hidden:null,n.update()},onHover:null,onLeave:null,labels:{boxWidth:40,padding:10,generateLabels:function(t){var e=t.data;return ut.isArray(e.datasets)?e.datasets.map(function(e,i){return{text:e.label,fillStyle:ut.isArray(e.backgroundColor)?e.backgroundColor[0]:e.backgroundColor,hidden:!t.isDatasetVisible(i),lineCap:e.borderCapStyle,lineDash:e.borderDash,lineDashOffset:e.borderDashOffset,lineJoin:e.borderJoinStyle,lineWidth:e.borderWidth,strokeStyle:e.borderColor,pointStyle:e.pointStyle,datasetIndex:i}},this):[]}}},legendCallback:function(t){var e=[];e.push('<ul class="'+t.id+'-legend">');for(var i=0;i<t.data.datasets.length;i++)e.push('<li><span style="background-color:'+t.data.datasets[i].backgroundColor+'"></span>'),t.data.datasets[i].label&&e.push(t.data.datasets[i].label),e.push("</li>");return e.push("</ul>"),e.join("")}});var pn=gt.extend({initialize:function(t){ut.extend(this,t),this.legendHitBoxes=[],this._hoveredItem=null,this.doughnutMode=!1},beforeUpdate:fn,update:function(t,e,i){var n=this;return n.beforeUpdate(),n.maxWidth=t,n.maxHeight=e,n.margins=i,n.beforeSetDimensions(),n.setDimensions(),n.afterSetDimensions(),n.beforeBuildLabels(),n.buildLabels(),n.afterBuildLabels(),n.beforeFit(),n.fit(),n.afterFit(),n.afterUpdate(),n.minSize},afterUpdate:fn,beforeSetDimensions:fn,setDimensions:function(){var t=this;t.isHorizontal()?(t.width=t.maxWidth,t.left=0,t.right=t.width):(t.height=t.maxHeight,t.top=0,t.bottom=t.height),t.paddingLeft=0,t.paddingTop=0,t.paddingRight=0,t.paddingBottom=0,t.minSize={width:0,height:0}},afterSetDimensions:fn,beforeBuildLabels:fn,buildLabels:function(){var t=this,e=t.options.labels||{},i=ut.callback(e.generateLabels,[t.chart],t)||[];e.filter&&(i=i.filter(function(i){return e.filter(i,t.chart.data)})),t.options.reverse&&i.reverse(),t.legendItems=i},afterBuildLabels:fn,beforeFit:fn,fit:function(){var t=this,e=t.options,i=e.labels,n=e.display,a=t.ctx,r=ut.options._parseFont(i),o=r.size,s=t.legendHitBoxes=[],l=t.minSize,u=t.isHorizontal();if(u?(l.width=t.maxWidth,l.height=n?10:0):(l.width=n?10:0,l.height=t.maxHeight),n)if(a.font=r.string,u){var d=t.lineWidths=[0],h=0;a.textAlign="left",a.textBaseline="top",ut.each(t.legendItems,function(t,e){var n=mn(i,o)+o/2+a.measureText(t.text).width;(0===e||d[d.length-1]+n+i.padding>l.width)&&(h+=o+i.padding,d[d.length-(e>0?0:1)]=i.padding),s[e]={left:0,top:0,width:n,height:o},d[d.length-1]+=n+i.padding}),l.height+=h}else{var c=i.padding,f=t.columnWidths=[],g=i.padding,m=0,p=0,v=o+c;ut.each(t.legendItems,function(t,e){var n=mn(i,o)+o/2+a.measureText(t.text).width;e>0&&p+v>l.height-c&&(g+=m+i.padding,f.push(m),m=0,p=0),m=Math.max(m,n),p+=v,s[e]={left:0,top:0,width:n,height:o}}),g+=m,f.push(m),l.width+=g}t.width=l.width,t.height=l.height},afterFit:fn,isHorizontal:function(){return"top"===this.options.position||"bottom"===this.options.position},draw:function(){var t=this,e=t.options,i=e.labels,n=ot.global,a=n.defaultColor,r=n.elements.line,o=t.width,s=t.lineWidths;if(e.display){var l,u=t.ctx,d=gn(i.fontColor,n.defaultFontColor),h=ut.options._parseFont(i),c=h.size;u.textAlign="left",u.textBaseline="middle",u.lineWidth=.5,u.strokeStyle=d,u.fillStyle=d,u.font=h.string;var f=mn(i,c),g=t.legendHitBoxes,m=t.isHorizontal();l=m?{x:t.left+(o-s[0])/2+i.padding,y:t.top+i.padding,line:0}:{x:t.left+i.padding,y:t.top+i.padding,line:0};var p=c+i.padding;ut.each(t.legendItems,function(n,d){var h=u.measureText(n.text).width,v=f+c/2+h,y=l.x,b=l.y;m?d>0&&y+v+i.padding>t.left+t.minSize.width&&(b=l.y+=p,l.line++,y=l.x=t.left+(o-s[l.line])/2+i.padding):d>0&&b+p>t.top+t.minSize.height&&(y=l.x=y+t.columnWidths[l.line]+i.padding,b=l.y=t.top+i.padding,l.line++),function(t,i,n){if(!(isNaN(f)||f<=0)){u.save();var o=gn(n.lineWidth,r.borderWidth);if(u.fillStyle=gn(n.fillStyle,a),u.lineCap=gn(n.lineCap,r.borderCapStyle),u.lineDashOffset=gn(n.lineDashOffset,r.borderDashOffset),u.lineJoin=gn(n.lineJoin,r.borderJoinStyle),u.lineWidth=o,u.strokeStyle=gn(n.strokeStyle,a),u.setLineDash&&u.setLineDash(gn(n.lineDash,r.borderDash)),e.labels&&e.labels.usePointStyle){var s=f*Math.SQRT2/2,l=t+f/2,d=i+c/2;ut.canvas.drawPoint(u,n.pointStyle,s,l,d)}else 0!==o&&u.strokeRect(t,i,f,c),u.fillRect(t,i,f,c);u.restore()}}(y,b,n),g[d].left=y,g[d].top=b,function(t,e,i,n){var a=c/2,r=f+a+t,o=e+a;u.fillText(i.text,r,o),i.hidden&&(u.beginPath(),u.lineWidth=2,u.moveTo(r,o),u.lineTo(r+n,o),u.stroke())}(y,b,n,h),m?l.x+=v+i.padding:l.y+=p})}},_getLegendItemAt:function(t,e){var i,n,a,r=this;if(t>=r.left&&t<=r.right&&e>=r.top&&e<=r.bottom)for(a=r.legendHitBoxes,i=0;i<a.length;++i)if(t>=(n=a[i]).left&&t<=n.left+n.width&&e>=n.top&&e<=n.top+n.height)return r.legendItems[i];return null},handleEvent:function(t){var e,i=this,n=i.options,a="mouseup"===t.type?"click":t.type;if("mousemove"===a){if(!n.onHover&&!n.onLeave)return}else{if("click"!==a)return;if(!n.onClick)return}e=i._getLegendItemAt(t.x,t.y),"click"===a?e&&n.onClick&&n.onClick.call(i,t.native,e):(n.onLeave&&e!==i._hoveredItem&&(i._hoveredItem&&n.onLeave.call(i,t.native,i._hoveredItem),i._hoveredItem=e),n.onHover&&e&&n.onHover.call(i,t.native,e))}});function vn(t,e){var i=new pn({ctx:t.ctx,options:e,chart:t});xe.configure(t,i,e),xe.addBox(t,i),t.legend=i}var yn={id:"legend",_element:pn,beforeInit:function(t){var e=t.options.legend;e&&vn(t,e)},beforeUpdate:function(t){var e=t.options.legend,i=t.legend;e?(ut.mergeIf(e,ot.global.legend),i?(xe.configure(t,i,e),i.options=e):vn(t,e)):i&&(xe.removeBox(t,i),delete t.legend)},afterEvent:function(t,e){var i=t.legend;i&&i.handleEvent(e)}},bn=ut.noop;ot._set("global",{title:{display:!1,fontStyle:"bold",fullWidth:!0,padding:10,position:"top",text:"",weight:2e3}});var xn=gt.extend({initialize:function(t){ut.extend(this,t),this.legendHitBoxes=[]},beforeUpdate:bn,update:function(t,e,i){var n=this;return n.beforeUpdate(),n.maxWidth=t,n.maxHeight=e,n.margins=i,n.beforeSetDimensions(),n.setDimensions(),n.afterSetDimensions(),n.beforeBuildLabels(),n.buildLabels(),n.afterBuildLabels(),n.beforeFit(),n.fit(),n.afterFit(),n.afterUpdate(),n.minSize},afterUpdate:bn,beforeSetDimensions:bn,setDimensions:function(){var t=this;t.isHorizontal()?(t.width=t.maxWidth,t.left=0,t.right=t.width):(t.height=t.maxHeight,t.top=0,t.bottom=t.height),t.paddingLeft=0,t.paddingTop=0,t.paddingRight=0,t.paddingBottom=0,t.minSize={width:0,height:0}},afterSetDimensions:bn,beforeBuildLabels:bn,buildLabels:bn,afterBuildLabels:bn,beforeFit:bn,fit:function(){var t=this,e=t.options,i=e.display,n=t.minSize,a=ut.isArray(e.text)?e.text.length:1,r=ut.options._parseFont(e),o=i?a*r.lineHeight+2*e.padding:0;t.isHorizontal()?(n.width=t.maxWidth,n.height=o):(n.width=o,n.height=t.maxHeight),t.width=n.width,t.height=n.height},afterFit:bn,isHorizontal:function(){var t=this.options.position;return"top"===t||"bottom"===t},draw:function(){var t=this,e=t.ctx,i=t.options;if(i.display){var n,a,r,o=ut.options._parseFont(i),s=o.lineHeight,l=s/2+i.padding,u=0,d=t.top,h=t.left,c=t.bottom,f=t.right;e.fillStyle=ut.valueOrDefault(i.fontColor,ot.global.defaultFontColor),e.font=o.string,t.isHorizontal()?(a=h+(f-h)/2,r=d+l,n=f-h):(a="left"===i.position?h+l:f-l,r=d+(c-d)/2,n=c-d,u=Math.PI*("left"===i.position?-.5:.5)),e.save(),e.translate(a,r),e.rotate(u),e.textAlign="center",e.textBaseline="middle";var g=i.text;if(ut.isArray(g))for(var m=0,p=0;p<g.length;++p)e.fillText(g[p],0,m,n),m+=s;else e.fillText(g,0,0,n);e.restore()}}});function _n(t,e){var i=new xn({ctx:t.ctx,options:e,chart:t});xe.configure(t,i,e),xe.addBox(t,i),t.titleBlock=i}var kn={},wn=cn,Mn=yn,Sn={id:"title",_element:xn,beforeInit:function(t){var e=t.options.title;e&&_n(t,e)},beforeUpdate:function(t){var e=t.options.title,i=t.titleBlock;e?(ut.mergeIf(e,ot.global.title),i?(xe.configure(t,i,e),i.options=e):_n(t,e)):i&&(xe.removeBox(t,i),delete t.titleBlock)}};for(var Dn in kn.filler=wn,kn.legend=Mn,kn.title=Sn,ai.helpers=ut,function(){function t(t,e,i){var n;return"string"==typeof t?(n=parseInt(t,10),-1!==t.indexOf("%")&&(n=n/100*e.parentNode[i])):n=t,n}function e(t){return null!=t&&"none"!==t}function i(i,n,a){var r=document.defaultView,o=ut._getParentNode(i),s=r.getComputedStyle(i)[n],l=r.getComputedStyle(o)[n],u=e(s),d=e(l),h=Number.POSITIVE_INFINITY;return u||d?Math.min(u?t(s,i,a):h,d?t(l,o,a):h):"none"}ut.where=function(t,e){if(ut.isArray(t)&&Array.prototype.filter)return t.filter(e);var i=[];return ut.each(t,function(t){e(t)&&i.push(t)}),i},ut.findIndex=Array.prototype.findIndex?function(t,e,i){return t.findIndex(e,i)}:function(t,e,i){i=void 0===i?t:i;for(var n=0,a=t.length;n<a;++n)if(e.call(i,t[n],n,t))return n;return-1},ut.findNextWhere=function(t,e,i){ut.isNullOrUndef(i)&&(i=-1);for(var n=i+1;n<t.length;n++){var a=t[n];if(e(a))return a}},ut.findPreviousWhere=function(t,e,i){ut.isNullOrUndef(i)&&(i=t.length);for(var n=i-1;n>=0;n--){var a=t[n];if(e(a))return a}},ut.isNumber=function(t){return!isNaN(parseFloat(t))&&isFinite(t)},ut.almostEquals=function(t,e,i){return Math.abs(t-e)<i},ut.almostWhole=function(t,e){var i=Math.round(t);return i-e<t&&i+e>t},ut.max=function(t){return t.reduce(function(t,e){return isNaN(e)?t:Math.max(t,e)},Number.NEGATIVE_INFINITY)},ut.min=function(t){return t.reduce(function(t,e){return isNaN(e)?t:Math.min(t,e)},Number.POSITIVE_INFINITY)},ut.sign=Math.sign?function(t){return Math.sign(t)}:function(t){return 0==(t=+t)||isNaN(t)?t:t>0?1:-1},ut.log10=Math.log10?function(t){return Math.log10(t)}:function(t){var e=Math.log(t)*Math.LOG10E,i=Math.round(e);return t===Math.pow(10,i)?i:e},ut.toRadians=function(t){return t*(Math.PI/180)},ut.toDegrees=function(t){return t*(180/Math.PI)},ut._decimalPlaces=function(t){if(ut.isFinite(t)){for(var e=1,i=0;Math.round(t*e)/e!==t;)e*=10,i++;return i}},ut.getAngleFromPoint=function(t,e){var i=e.x-t.x,n=e.y-t.y,a=Math.sqrt(i*i+n*n),r=Math.atan2(n,i);return r<-.5*Math.PI&&(r+=2*Math.PI),{angle:r,distance:a}},ut.distanceBetweenPoints=function(t,e){return Math.sqrt(Math.pow(e.x-t.x,2)+Math.pow(e.y-t.y,2))},ut.aliasPixel=function(t){return t%2==0?0:.5},ut._alignPixel=function(t,e,i){var n=t.currentDevicePixelRatio,a=i/2;return Math.round((e-a)*n)/n+a},ut.splineCurve=function(t,e,i,n){var a=t.skip?e:t,r=e,o=i.skip?e:i,s=Math.sqrt(Math.pow(r.x-a.x,2)+Math.pow(r.y-a.y,2)),l=Math.sqrt(Math.pow(o.x-r.x,2)+Math.pow(o.y-r.y,2)),u=s/(s+l),d=l/(s+l),h=n*(u=isNaN(u)?0:u),c=n*(d=isNaN(d)?0:d);return{previous:{x:r.x-h*(o.x-a.x),y:r.y-h*(o.y-a.y)},next:{x:r.x+c*(o.x-a.x),y:r.y+c*(o.y-a.y)}}},ut.EPSILON=Number.EPSILON||1e-14,ut.splineCurveMonotone=function(t){var e,i,n,a,r,o,s,l,u,d=(t||[]).map(function(t){return{model:t._model,deltaK:0,mK:0}}),h=d.length;for(e=0;e<h;++e)if(!(n=d[e]).model.skip){if(i=e>0?d[e-1]:null,(a=e<h-1?d[e+1]:null)&&!a.model.skip){var c=a.model.x-n.model.x;n.deltaK=0!==c?(a.model.y-n.model.y)/c:0}!i||i.model.skip?n.mK=n.deltaK:!a||a.model.skip?n.mK=i.deltaK:this.sign(i.deltaK)!==this.sign(n.deltaK)?n.mK=0:n.mK=(i.deltaK+n.deltaK)/2}for(e=0;e<h-1;++e)n=d[e],a=d[e+1],n.model.skip||a.model.skip||(ut.almostEquals(n.deltaK,0,this.EPSILON)?n.mK=a.mK=0:(r=n.mK/n.deltaK,o=a.mK/n.deltaK,(l=Math.pow(r,2)+Math.pow(o,2))<=9||(s=3/Math.sqrt(l),n.mK=r*s*n.deltaK,a.mK=o*s*n.deltaK)));for(e=0;e<h;++e)(n=d[e]).model.skip||(i=e>0?d[e-1]:null,a=e<h-1?d[e+1]:null,i&&!i.model.skip&&(u=(n.model.x-i.model.x)/3,n.model.controlPointPreviousX=n.model.x-u,n.model.controlPointPreviousY=n.model.y-u*n.mK),a&&!a.model.skip&&(u=(a.model.x-n.model.x)/3,n.model.controlPointNextX=n.model.x+u,n.model.controlPointNextY=n.model.y+u*n.mK))},ut.nextItem=function(t,e,i){return i?e>=t.length-1?t[0]:t[e+1]:e>=t.length-1?t[t.length-1]:t[e+1]},ut.previousItem=function(t,e,i){return i?e<=0?t[t.length-1]:t[e-1]:e<=0?t[0]:t[e-1]},ut.niceNum=function(t,e){var i=Math.floor(ut.log10(t)),n=t/Math.pow(10,i);return(e?n<1.5?1:n<3?2:n<7?5:10:n<=1?1:n<=2?2:n<=5?5:10)*Math.pow(10,i)},ut.requestAnimFrame="undefined"==typeof window?function(t){t()}:window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame||window.oRequestAnimationFrame||window.msRequestAnimationFrame||function(t){return window.setTimeout(t,1e3/60)},ut.getRelativePosition=function(t,e){var i,n,a=t.originalEvent||t,r=t.target||t.srcElement,o=r.getBoundingClientRect(),s=a.touches;s&&s.length>0?(i=s[0].clientX,n=s[0].clientY):(i=a.clientX,n=a.clientY);var l=parseFloat(ut.getStyle(r,"padding-left")),u=parseFloat(ut.getStyle(r,"padding-top")),d=parseFloat(ut.getStyle(r,"padding-right")),h=parseFloat(ut.getStyle(r,"padding-bottom")),c=o.right-o.left-l-d,f=o.bottom-o.top-u-h;return{x:i=Math.round((i-o.left-l)/c*r.width/e.currentDevicePixelRatio),y:n=Math.round((n-o.top-u)/f*r.height/e.currentDevicePixelRatio)}},ut.getConstraintWidth=function(t){return i(t,"max-width","clientWidth")},ut.getConstraintHeight=function(t){return i(t,"max-height","clientHeight")},ut._calculatePadding=function(t,e,i){return(e=ut.getStyle(t,e)).indexOf("%")>-1?i*parseInt(e,10)/100:parseInt(e,10)},ut._getParentNode=function(t){var e=t.parentNode;return e&&"[object ShadowRoot]"===e.toString()&&(e=e.host),e},ut.getMaximumWidth=function(t){var e=ut._getParentNode(t);if(!e)return t.clientWidth;var i=e.clientWidth,n=i-ut._calculatePadding(e,"padding-left",i)-ut._calculatePadding(e,"padding-right",i),a=ut.getConstraintWidth(t);return isNaN(a)?n:Math.min(n,a)},ut.getMaximumHeight=function(t){var e=ut._getParentNode(t);if(!e)return t.clientHeight;var i=e.clientHeight,n=i-ut._calculatePadding(e,"padding-top",i)-ut._calculatePadding(e,"padding-bottom",i),a=ut.getConstraintHeight(t);return isNaN(a)?n:Math.min(n,a)},ut.getStyle=function(t,e){return t.currentStyle?t.currentStyle[e]:document.defaultView.getComputedStyle(t,null).getPropertyValue(e)},ut.retinaScale=function(t,e){var i=t.currentDevicePixelRatio=e||"undefined"!=typeof window&&window.devicePixelRatio||1;if(1!==i){var n=t.canvas,a=t.height,r=t.width;n.height=a*i,n.width=r*i,t.ctx.scale(i,i),n.style.height||n.style.width||(n.style.height=a+"px",n.style.width=r+"px")}},ut.fontString=function(t,e,i){return e+" "+t+"px "+i},ut.longestText=function(t,e,i,n){var a=(n=n||{}).data=n.data||{},r=n.garbageCollect=n.garbageCollect||[];n.font!==e&&(a=n.data={},r=n.garbageCollect=[],n.font=e),t.font=e;var o=0;ut.each(i,function(e){null!=e&&!0!==ut.isArray(e)?o=ut.measureText(t,a,r,o,e):ut.isArray(e)&&ut.each(e,function(e){null==e||ut.isArray(e)||(o=ut.measureText(t,a,r,o,e))})});var s=r.length/2;if(s>i.length){for(var l=0;l<s;l++)delete a[r[l]];r.splice(0,s)}return o},ut.measureText=function(t,e,i,n,a){var r=e[a];return r||(r=e[a]=t.measureText(a).width,i.push(a)),r>n&&(n=r),n},ut.numberOfLabelLines=function(t){var e=1;return ut.each(t,function(t){ut.isArray(t)&&t.length>e&&(e=t.length)}),e},ut.color=G?function(t){return t instanceof CanvasGradient&&(t=ot.global.defaultColor),G(t)}:function(t){return console.error("Color.js not found!"),t},ut.getHoverColor=function(t){return t instanceof CanvasPattern||t instanceof CanvasGradient?t:ut.color(t).saturate(.5).darken(.1).rgbString()}}(),ai._adapters=si,ai.Animation=pt,ai.animationService=vt,ai.controllers=ue,ai.DatasetController=kt,ai.defaults=ot,ai.Element=gt,ai.elements=Nt,ai.Interaction=pe,ai.layouts=xe,ai.platform=Ve,ai.plugins=He,ai.Scale=fi,ai.scaleService=Ee,ai.Ticks=li,ai.Tooltip=Je,ai.helpers.each(en,function(t,e){ai.scaleService.registerScaleType(e,t,t._defaults)}),kn)kn.hasOwnProperty(Dn)&&ai.plugins.register(kn[Dn]);ai.platform.initialize();var Cn=ai;return"undefined"!=typeof window&&(window.Chart=ai),ai.Chart=ai,ai.Legend=kn.legend._element,ai.Title=kn.title._element,ai.pluginService=ai.plugins,ai.PluginBase=ai.Element.extend({}),ai.canvasHelpers=ai.helpers.canvas,ai.layoutService=ai.layouts,ai.LinearScaleBase=yi,ai.helpers.each(["Bar","Bubble","Doughnut","Line","PolarArea","Radar","Scatter"],function(t){ai[t]=function(e,i){return new ai(e,ai.helpers.merge(i||{},{type:t.charAt(0).toLowerCase()+t.slice(1)}))}}),Cn});
/*!
 * Masonry PACKAGED v3.1.1
 * Cascading grid layout library
 * http://masonry.desandro.com
 * MIT License
 * by David DeSandro
 */

(function(t){"use strict";function e(t){if(t){if("string"==typeof n[t])return t;t=t.charAt(0).toUpperCase()+t.slice(1);for(var e,o=0,r=i.length;r>o;o++)if(e=i[o]+t,"string"==typeof n[e])return e}}var i="Webkit Moz ms Ms O".split(" "),n=document.documentElement.style;"function"==typeof define&&define.amd?define(function(){return e}):t.getStyleProperty=e})(window),function(t){"use strict";function e(t){var e=parseFloat(t),i=-1===t.indexOf("%")&&!isNaN(e);return i&&e}function i(){for(var t={width:0,height:0,innerWidth:0,innerHeight:0,outerWidth:0,outerHeight:0},e=0,i=s.length;i>e;e++){var n=s[e];t[n]=0}return t}function n(t){function n(t){if("string"==typeof t&&(t=document.querySelector(t)),t&&"object"==typeof t&&t.nodeType){var n=r(t);if("none"===n.display)return i();var h={};h.width=t.offsetWidth,h.height=t.offsetHeight;for(var u=h.isBorderBox=!(!a||!n[a]||"border-box"!==n[a]),p=0,f=s.length;f>p;p++){var d=s[p],c=n[d],l=parseFloat(c);h[d]=isNaN(l)?0:l}var m=h.paddingLeft+h.paddingRight,y=h.paddingTop+h.paddingBottom,g=h.marginLeft+h.marginRight,v=h.marginTop+h.marginBottom,_=h.borderLeftWidth+h.borderRightWidth,b=h.borderTopWidth+h.borderBottomWidth,E=u&&o,L=e(n.width);L!==!1&&(h.width=L+(E?0:m+_));var S=e(n.height);return S!==!1&&(h.height=S+(E?0:y+b)),h.innerWidth=h.width-(m+_),h.innerHeight=h.height-(y+b),h.outerWidth=h.width+g,h.outerHeight=h.height+v,h}}var o,a=t("boxSizing");return function(){if(a){var t=document.createElement("div");t.style.width="200px",t.style.padding="1px 2px 3px 4px",t.style.borderStyle="solid",t.style.borderWidth="1px 2px 3px 4px",t.style[a]="border-box";var i=document.body||document.documentElement;i.appendChild(t);var n=r(t);o=200===e(n.width),i.removeChild(t)}}(),n}var o=document.defaultView,r=o&&o.getComputedStyle?function(t){return o.getComputedStyle(t,null)}:function(t){return t.currentStyle},s=["paddingLeft","paddingRight","paddingTop","paddingBottom","marginLeft","marginRight","marginTop","marginBottom","borderLeftWidth","borderRightWidth","borderTopWidth","borderBottomWidth"];"function"==typeof define&&define.amd?define(["get-style-property/get-style-property"],n):t.getSize=n(t.getStyleProperty)}(window),function(t){"use strict";var e=document.documentElement,i=function(){};e.addEventListener?i=function(t,e,i){t.addEventListener(e,i,!1)}:e.attachEvent&&(i=function(e,i,n){e[i+n]=n.handleEvent?function(){var e=t.event;e.target=e.target||e.srcElement,n.handleEvent.call(n,e)}:function(){var i=t.event;i.target=i.target||i.srcElement,n.call(e,i)},e.attachEvent("on"+i,e[i+n])});var n=function(){};e.removeEventListener?n=function(t,e,i){t.removeEventListener(e,i,!1)}:e.detachEvent&&(n=function(t,e,i){t.detachEvent("on"+e,t[e+i]);try{delete t[e+i]}catch(n){t[e+i]=void 0}});var o={bind:i,unbind:n};"function"==typeof define&&define.amd?define(o):t.eventie=o}(this),function(t){"use strict";function e(t){"function"==typeof t&&(e.isReady?t():r.push(t))}function i(t){var i="readystatechange"===t.type&&"complete"!==o.readyState;if(!e.isReady&&!i){e.isReady=!0;for(var n=0,s=r.length;s>n;n++){var a=r[n];a()}}}function n(n){return n.bind(o,"DOMContentLoaded",i),n.bind(o,"readystatechange",i),n.bind(t,"load",i),e}var o=t.document,r=[];e.isReady=!1,"function"==typeof define&&define.amd?(e.isReady="function"==typeof requirejs,define(["eventie/eventie"],n)):t.docReady=n(t.eventie)}(this),function(){"use strict";function t(){}function e(t,e){for(var i=t.length;i--;)if(t[i].listener===e)return i;return-1}var i=t.prototype;i.getListeners=function(t){var e,i,n=this._getEvents();if("object"==typeof t){e={};for(i in n)n.hasOwnProperty(i)&&t.test(i)&&(e[i]=n[i])}else e=n[t]||(n[t]=[]);return e},i.flattenListeners=function(t){var e,i=[];for(e=0;t.length>e;e+=1)i.push(t[e].listener);return i},i.getListenersAsObject=function(t){var e,i=this.getListeners(t);return i instanceof Array&&(e={},e[t]=i),e||i},i.addListener=function(t,i){var n,o=this.getListenersAsObject(t),r="object"==typeof i;for(n in o)o.hasOwnProperty(n)&&-1===e(o[n],i)&&o[n].push(r?i:{listener:i,once:!1});return this},i.on=i.addListener,i.addOnceListener=function(t,e){return this.addListener(t,{listener:e,once:!0})},i.once=i.addOnceListener,i.defineEvent=function(t){return this.getListeners(t),this},i.defineEvents=function(t){for(var e=0;t.length>e;e+=1)this.defineEvent(t[e]);return this},i.removeListener=function(t,i){var n,o,r=this.getListenersAsObject(t);for(o in r)r.hasOwnProperty(o)&&(n=e(r[o],i),-1!==n&&r[o].splice(n,1));return this},i.off=i.removeListener,i.addListeners=function(t,e){return this.manipulateListeners(!1,t,e)},i.removeListeners=function(t,e){return this.manipulateListeners(!0,t,e)},i.manipulateListeners=function(t,e,i){var n,o,r=t?this.removeListener:this.addListener,s=t?this.removeListeners:this.addListeners;if("object"!=typeof e||e instanceof RegExp)for(n=i.length;n--;)r.call(this,e,i[n]);else for(n in e)e.hasOwnProperty(n)&&(o=e[n])&&("function"==typeof o?r.call(this,n,o):s.call(this,n,o));return this},i.removeEvent=function(t){var e,i=typeof t,n=this._getEvents();if("string"===i)delete n[t];else if("object"===i)for(e in n)n.hasOwnProperty(e)&&t.test(e)&&delete n[e];else delete this._events;return this},i.emitEvent=function(t,e){var i,n,o,r,s=this.getListenersAsObject(t);for(o in s)if(s.hasOwnProperty(o))for(n=s[o].length;n--;)i=s[o][n],r=i.listener.apply(this,e||[]),(r===this._getOnceReturnValue()||i.once===!0)&&this.removeListener(t,i.listener);return this},i.trigger=i.emitEvent,i.emit=function(t){var e=Array.prototype.slice.call(arguments,1);return this.emitEvent(t,e)},i.setOnceReturnValue=function(t){return this._onceReturnValue=t,this},i._getOnceReturnValue=function(){return this.hasOwnProperty("_onceReturnValue")?this._onceReturnValue:!0},i._getEvents=function(){return this._events||(this._events={})},"function"==typeof define&&define.amd?define(function(){return t}):"undefined"!=typeof module&&module.exports?module.exports=t:this.EventEmitter=t}.call(this),function(t){"use strict";function e(){}function i(t){function i(e){e.prototype.option||(e.prototype.option=function(e){t.isPlainObject(e)&&(this.options=t.extend(!0,this.options,e))})}function o(e,i){t.fn[e]=function(o){if("string"==typeof o){for(var s=n.call(arguments,1),a=0,h=this.length;h>a;a++){var u=this[a],p=t.data(u,e);if(p)if(t.isFunction(p[o])&&"_"!==o.charAt(0)){var f=p[o].apply(p,s);if(void 0!==f)return f}else r("no such method '"+o+"' for "+e+" instance");else r("cannot call methods on "+e+" prior to initialization; "+"attempted to call '"+o+"'")}return this}return this.each(function(){var n=t.data(this,e);n?(n.option(o),n._init()):(n=new i(this,o),t.data(this,e,n))})}}if(t){var r="undefined"==typeof console?e:function(t){console.error(t)};t.bridget=function(t,e){i(e),o(t,e)}}}var n=Array.prototype.slice;"function"==typeof define&&define.amd?define(["jquery"],i):i(t.jQuery)}(window),function(t,e){"use strict";function i(t,e){return t[a](e)}function n(t){if(!t.parentNode){var e=document.createDocumentFragment();e.appendChild(t)}}function o(t,e){n(t);for(var i=t.parentNode.querySelectorAll(e),o=0,r=i.length;r>o;o++)if(i[o]===t)return!0;return!1}function r(t,e){return n(t),i(t,e)}var s,a=function(){if(e.matchesSelector)return"matchesSelector";for(var t=["webkit","moz","ms","o"],i=0,n=t.length;n>i;i++){var o=t[i],r=o+"MatchesSelector";if(e[r])return r}}();if(a){var h=document.createElement("div"),u=i(h,"div");s=u?i:r}else s=o;"function"==typeof define&&define.amd?define(function(){return s}):window.matchesSelector=s}(this,Element.prototype),function(t){"use strict";function e(t,e){for(var i in e)t[i]=e[i];return t}function i(t,i,n){function r(t,e){t&&(this.element=t,this.layout=e,this.position={x:0,y:0},this._create())}var s=n("transition"),a=n("transform"),h=s&&a,u=!!n("perspective"),p={WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"otransitionend",transition:"transitionend"}[s],f=["transform","transition","transitionDuration","transitionProperty"],d=function(){for(var t={},e=0,i=f.length;i>e;e++){var o=f[e],r=n(o);r&&r!==o&&(t[o]=r)}return t}();e(r.prototype,t.prototype),r.prototype._create=function(){this.css({position:"absolute"})},r.prototype.handleEvent=function(t){var e="on"+t.type;this[e]&&this[e](t)},r.prototype.getSize=function(){this.size=i(this.element)},r.prototype.css=function(t){var e=this.element.style;for(var i in t){var n=d[i]||i;e[n]=t[i]}},r.prototype.getPosition=function(){var t=o(this.element),e=this.layout.options,i=e.isOriginLeft,n=e.isOriginTop,r=parseInt(t[i?"left":"right"],10),s=parseInt(t[n?"top":"bottom"],10);r=isNaN(r)?0:r,s=isNaN(s)?0:s;var a=this.layout.size;r-=i?a.paddingLeft:a.paddingRight,s-=n?a.paddingTop:a.paddingBottom,this.position.x=r,this.position.y=s},r.prototype.layoutPosition=function(){var t=this.layout.size,e=this.layout.options,i={};e.isOriginLeft?(i.left=this.position.x+t.paddingLeft+"px",i.right=""):(i.right=this.position.x+t.paddingRight+"px",i.left=""),e.isOriginTop?(i.top=this.position.y+t.paddingTop+"px",i.bottom=""):(i.bottom=this.position.y+t.paddingBottom+"px",i.top=""),this.css(i),this.emitEvent("layout",[this])};var c=u?function(t,e){return"translate3d("+t+"px, "+e+"px, 0)"}:function(t,e){return"translate("+t+"px, "+e+"px)"};r.prototype._transitionTo=function(t,e){this.getPosition();var i=this.position.x,n=this.position.y,o=parseInt(t,10),r=parseInt(e,10),s=o===this.position.x&&r===this.position.y;if(this.setPosition(t,e),s&&!this.isTransitioning)return this.layoutPosition(),void 0;var a=t-i,h=e-n,u={},p=this.layout.options;a=p.isOriginLeft?a:-a,h=p.isOriginTop?h:-h,u.transform=c(a,h),this.transition({to:u,onTransitionEnd:this.layoutPosition,isCleaning:!0})},r.prototype.goTo=function(t,e){this.setPosition(t,e),this.layoutPosition()},r.prototype.moveTo=h?r.prototype._transitionTo:r.prototype.goTo,r.prototype.setPosition=function(t,e){this.position.x=parseInt(t,10),this.position.y=parseInt(e,10)},r.prototype._nonTransition=function(t){this.css(t.to),t.isCleaning&&this._removeStyles(t.to),t.onTransitionEnd&&t.onTransitionEnd.call(this)},r.prototype._transition=function(t){var e=this.layout.options.transitionDuration;if(!parseFloat(e))return this._nonTransition(t),void 0;var i=t.to,n=[];for(var o in i)n.push(o);var r={};if(r.transitionProperty=n.join(","),r.transitionDuration=e,this.element.addEventListener(p,this,!1),(t.isCleaning||t.onTransitionEnd)&&this.on("transitionEnd",function(e){return t.isCleaning&&e._removeStyles(i),t.onTransitionEnd&&t.onTransitionEnd.call(e),!0}),t.from){this.css(t.from);var s=this.element.offsetHeight;s=null}this.css(r),this.css(i),this.isTransitioning=!0},r.prototype.transition=r.prototype[s?"_transition":"_nonTransition"],r.prototype.onwebkitTransitionEnd=function(t){this.ontransitionend(t)},r.prototype.onotransitionend=function(t){this.ontransitionend(t)},r.prototype.ontransitionend=function(t){t.target===this.element&&(this.removeTransitionStyles(),this.element.removeEventListener(p,this,!1),this.isTransitioning=!1,this.emitEvent("transitionEnd",[this]))},r.prototype._removeStyles=function(t){var e={};for(var i in t)e[i]="";this.css(e)};var l={transitionProperty:"",transitionDuration:""};return r.prototype.removeTransitionStyles=function(){this.css(l)},r.prototype.removeElem=function(){this.element.parentNode.removeChild(this.element),this.emitEvent("remove",[this])},r.prototype.remove=function(){if(!s||!parseFloat(this.layout.options.transitionDuration))return this.removeElem(),void 0;var t=this;this.on("transitionEnd",function(){return t.removeElem(),!0}),this.hide()},r.prototype.reveal=function(){delete this.isHidden,this.css({display:""});var t=this.layout.options;this.transition({from:t.hiddenStyle,to:t.visibleStyle,isCleaning:!0})},r.prototype.hide=function(){this.isHidden=!0,this.css({display:""});var t=this.layout.options;this.transition({from:t.visibleStyle,to:t.hiddenStyle,isCleaning:!0,onTransitionEnd:function(){this.css({display:"none"})}})},r.prototype.destroy=function(){this.css({position:"",left:"",right:"",top:"",bottom:"",transition:"",transform:""})},r}var n=document.defaultView,o=n&&n.getComputedStyle?function(t){return n.getComputedStyle(t,null)}:function(t){return t.currentStyle};"function"==typeof define&&define.amd?define(["eventEmitter/EventEmitter","get-size/get-size","get-style-property/get-style-property"],i):(t.Outlayer={},t.Outlayer.Item=i(t.EventEmitter,t.getSize,t.getStyleProperty))}(window),function(t){"use strict";function e(t,e){for(var i in e)t[i]=e[i];return t}function i(t){return"[object Array]"===p.call(t)}function n(t){var e=[];if(i(t))e=t;else if(t&&"number"==typeof t.length)for(var n=0,o=t.length;o>n;n++)e.push(t[n]);else e.push(t);return e}function o(t){return t.replace(/(.)([A-Z])/g,function(t,e,i){return e+"-"+i}).toLowerCase()}function r(i,r,p,c,l,m){function y(t,i){if("string"==typeof t&&(t=s.querySelector(t)),!t||!f(t))return a&&a.error("Bad "+this.settings.namespace+" element: "+t),void 0;this.element=t,this.options=e({},this.options),e(this.options,i);var n=++v;this.element.outlayerGUID=n,_[n]=this,this._create(),this.options.isInitLayout&&this.layout()}function g(t,i){t.prototype[i]=e({},y.prototype[i])}var v=0,_={};return y.prototype.settings={namespace:"outlayer",item:m},y.prototype.options={containerStyle:{position:"relative"},isInitLayout:!0,isOriginLeft:!0,isOriginTop:!0,isResizeBound:!0,transitionDuration:"0.4s",hiddenStyle:{opacity:0,transform:"scale(0.001)"},visibleStyle:{opacity:1,transform:"scale(1)"}},e(y.prototype,p.prototype),y.prototype._create=function(){this.reloadItems(),this.stamps=[],this.stamp(this.options.stamp),e(this.element.style,this.options.containerStyle),this.options.isResizeBound&&this.bindResize()},y.prototype.reloadItems=function(){this.items=this._getItems(this.element.children)},y.prototype._getItems=function(t){for(var e=this._filterFindItemElements(t),i=this.settings.item,n=[],o=0,r=e.length;r>o;o++){var s=e[o],a=new i(s,this,this.options.itemOptions);n.push(a)}return n},y.prototype._filterFindItemElements=function(t){t=n(t);for(var e=this.options.itemSelector,i=[],o=0,r=t.length;r>o;o++){var s=t[o];if(f(s))if(e){l(s,e)&&i.push(s);for(var a=s.querySelectorAll(e),h=0,u=a.length;u>h;h++)i.push(a[h])}else i.push(s)}return i},y.prototype.getItemElements=function(){for(var t=[],e=0,i=this.items.length;i>e;e++)t.push(this.items[e].element);return t},y.prototype.layout=function(){this._resetLayout(),this._manageStamps();var t=void 0!==this.options.isLayoutInstant?this.options.isLayoutInstant:!this._isLayoutInited;this.layoutItems(this.items,t),this._isLayoutInited=!0},y.prototype._init=y.prototype.layout,y.prototype._resetLayout=function(){this.getSize()},y.prototype.getSize=function(){this.size=c(this.element)},y.prototype._getMeasurement=function(t,e){var i,n=this.options[t];n?("string"==typeof n?i=this.element.querySelector(n):f(n)&&(i=n),this[t]=i?c(i)[e]:n):this[t]=0},y.prototype.layoutItems=function(t,e){t=this._getItemsForLayout(t),this._layoutItems(t,e),this._postLayout()},y.prototype._getItemsForLayout=function(t){for(var e=[],i=0,n=t.length;n>i;i++){var o=t[i];o.isIgnored||e.push(o)}return e},y.prototype._layoutItems=function(t,e){if(!t||!t.length)return this.emitEvent("layoutComplete",[this,t]),void 0;this._itemsOn(t,"layout",function(){this.emitEvent("layoutComplete",[this,t])});for(var i=[],n=0,o=t.length;o>n;n++){var r=t[n],s=this._getItemLayoutPosition(r);s.item=r,s.isInstant=e,i.push(s)}this._processLayoutQueue(i)},y.prototype._getItemLayoutPosition=function(){return{x:0,y:0}},y.prototype._processLayoutQueue=function(t){for(var e=0,i=t.length;i>e;e++){var n=t[e];this._positionItem(n.item,n.x,n.y,n.isInstant)}},y.prototype._positionItem=function(t,e,i,n){n?t.goTo(e,i):t.moveTo(e,i)},y.prototype._postLayout=function(){var t=this._getContainerSize();t&&(this._setContainerMeasure(t.width,!0),this._setContainerMeasure(t.height,!1))},y.prototype._getContainerSize=u,y.prototype._setContainerMeasure=function(t,e){if(void 0!==t){var i=this.size;i.isBorderBox&&(t+=e?i.paddingLeft+i.paddingRight+i.borderLeftWidth+i.borderRightWidth:i.paddingBottom+i.paddingTop+i.borderTopWidth+i.borderBottomWidth),t=Math.max(t,0),this.element.style[e?"width":"height"]=t+"px"}},y.prototype._itemsOn=function(t,e,i){function n(){return o++,o===r&&i.call(s),!0}for(var o=0,r=t.length,s=this,a=0,h=t.length;h>a;a++){var u=t[a];u.on(e,n)}},y.prototype.ignore=function(t){var e=this.getItem(t);e&&(e.isIgnored=!0)},y.prototype.unignore=function(t){var e=this.getItem(t);e&&delete e.isIgnored},y.prototype.stamp=function(t){if(t=this._find(t)){this.stamps=this.stamps.concat(t);for(var e=0,i=t.length;i>e;e++){var n=t[e];this.ignore(n)}}},y.prototype.unstamp=function(t){if(t=this._find(t))for(var e=0,i=t.length;i>e;e++){var n=t[e],o=d(this.stamps,n);-1!==o&&this.stamps.splice(o,1),this.unignore(n)}},y.prototype._find=function(t){return t?("string"==typeof t&&(t=this.element.querySelectorAll(t)),t=n(t)):void 0},y.prototype._manageStamps=function(){if(this.stamps&&this.stamps.length){this._getBoundingRect();for(var t=0,e=this.stamps.length;e>t;t++){var i=this.stamps[t];this._manageStamp(i)}}},y.prototype._getBoundingRect=function(){var t=this.element.getBoundingClientRect(),e=this.size;this._boundingRect={left:t.left+e.paddingLeft+e.borderLeftWidth,top:t.top+e.paddingTop+e.borderTopWidth,right:t.right-(e.paddingRight+e.borderRightWidth),bottom:t.bottom-(e.paddingBottom+e.borderBottomWidth)}},y.prototype._manageStamp=u,y.prototype._getElementOffset=function(t){var e=t.getBoundingClientRect(),i=this._boundingRect,n=c(t),o={left:e.left-i.left-n.marginLeft,top:e.top-i.top-n.marginTop,right:i.right-e.right-n.marginRight,bottom:i.bottom-e.bottom-n.marginBottom};return o},y.prototype.handleEvent=function(t){var e="on"+t.type;this[e]&&this[e](t)},y.prototype.bindResize=function(){this.isResizeBound||(i.bind(t,"resize",this),this.isResizeBound=!0)},y.prototype.unbindResize=function(){i.unbind(t,"resize",this),this.isResizeBound=!1},y.prototype.onresize=function(){function t(){e.resize()}this.resizeTimeout&&clearTimeout(this.resizeTimeout);var e=this;this.resizeTimeout=setTimeout(t,100)},y.prototype.resize=function(){var t=c(this.element),e=this.size&&t;e&&t.innerWidth===this.size.innerWidth||(this.layout(),delete this.resizeTimeout)},y.prototype.addItems=function(t){var e=this._getItems(t);if(e.length)return this.items=this.items.concat(e),e},y.prototype.appended=function(t){var e=this.addItems(t);e.length&&(this.layoutItems(e,!0),this.reveal(e))},y.prototype.prepended=function(t){var e=this._getItems(t);if(e.length){var i=this.items.slice(0);this.items=e.concat(i),this._resetLayout(),this.layoutItems(e,!0),this.reveal(e),this.layoutItems(i)}},y.prototype.reveal=function(t){if(t&&t.length)for(var e=0,i=t.length;i>e;e++){var n=t[e];n.reveal()}},y.prototype.hide=function(t){if(t&&t.length)for(var e=0,i=t.length;i>e;e++){var n=t[e];n.hide()}},y.prototype.getItem=function(t){for(var e=0,i=this.items.length;i>e;e++){var n=this.items[e];if(n.element===t)return n}},y.prototype.getItems=function(t){if(t&&t.length){for(var e=[],i=0,n=t.length;n>i;i++){var o=t[i],r=this.getItem(o);r&&e.push(r)}return e}},y.prototype.remove=function(t){t=n(t);var e=this.getItems(t);if(e&&e.length){this._itemsOn(e,"remove",function(){this.emitEvent("removeComplete",[this,e])});for(var i=0,o=e.length;o>i;i++){var r=e[i];r.remove();var s=d(this.items,r);this.items.splice(s,1)}}},y.prototype.destroy=function(){var t=this.element.style;t.height="",t.position="",t.width="";for(var e=0,i=this.items.length;i>e;e++){var n=this.items[e];n.destroy()}this.unbindResize(),delete this.element.outlayerGUID,h&&h.removeData(this.element,this.settings.namespace)},y.data=function(t){var e=t&&t.outlayerGUID;return e&&_[e]},y.create=function(t,i){function n(){y.apply(this,arguments)}return e(n.prototype,y.prototype),g(n,"options"),g(n,"settings"),e(n.prototype.options,i),n.prototype.settings.namespace=t,n.data=y.data,n.Item=function(){m.apply(this,arguments)},n.Item.prototype=new m,n.prototype.settings.item=n.Item,r(function(){for(var e=o(t),i=s.querySelectorAll(".js-"+e),r="data-"+e+"-options",u=0,p=i.length;p>u;u++){var f,d=i[u],c=d.getAttribute(r);try{f=c&&JSON.parse(c)}catch(l){a&&a.error("Error parsing "+r+" on "+d.nodeName.toLowerCase()+(d.id?"#"+d.id:"")+": "+l);continue}var m=new n(d,f);h&&h.data(d,t,m)}}),h&&h.bridget&&h.bridget(t,n),n},y.Item=m,y}var s=t.document,a=t.console,h=t.jQuery,u=function(){},p=Object.prototype.toString,f="object"==typeof HTMLElement?function(t){return t instanceof HTMLElement}:function(t){return t&&"object"==typeof t&&1===t.nodeType&&"string"==typeof t.nodeName},d=Array.prototype.indexOf?function(t,e){return t.indexOf(e)}:function(t,e){for(var i=0,n=t.length;n>i;i++)if(t[i]===e)return i;return-1};"function"==typeof define&&define.amd?define(["eventie/eventie","doc-ready/doc-ready","eventEmitter/EventEmitter","get-size/get-size","matches-selector/matches-selector","./item"],r):t.Outlayer=r(t.eventie,t.docReady,t.EventEmitter,t.getSize,t.matchesSelector,t.Outlayer.Item)}(window),function(t){"use strict";function e(t,e){var n=t.create("masonry");return n.prototype._resetLayout=function(){this.getSize(),this._getMeasurement("columnWidth","outerWidth"),this._getMeasurement("gutter","outerWidth"),this.measureColumns();var t=this.cols;for(this.colYs=[];t--;)this.colYs.push(0);this.maxY=0},n.prototype.measureColumns=function(){var t=this._getSizingContainer(),i=this.items[0],n=i&&i.element;this.columnWidth||(this.columnWidth=n?e(n).outerWidth:this.size.innerWidth),this.columnWidth+=this.gutter,this._containerWidth=e(t).innerWidth,this.cols=Math.floor((this._containerWidth+this.gutter)/this.columnWidth),this.cols=Math.max(this.cols,1)},n.prototype._getSizingContainer=function(){return this.options.isFitWidth?this.element.parentNode:this.element},n.prototype._getItemLayoutPosition=function(t){t.getSize();var e=Math.ceil(t.size.outerWidth/this.columnWidth);e=Math.min(e,this.cols);for(var n=this._getColGroup(e),o=Math.min.apply(Math,n),r=i(n,o),s={x:this.columnWidth*r,y:o},a=o+t.size.outerHeight,h=this.cols+1-n.length,u=0;h>u;u++)this.colYs[r+u]=a;return s},n.prototype._getColGroup=function(t){if(1===t)return this.colYs;for(var e=[],i=this.cols+1-t,n=0;i>n;n++){var o=this.colYs.slice(n,n+t);e[n]=Math.max.apply(Math,o)}return e},n.prototype._manageStamp=function(t){var i=e(t),n=this._getElementOffset(t),o=this.options.isOriginLeft?n.left:n.right,r=o+i.outerWidth,s=Math.floor(o/this.columnWidth);s=Math.max(0,s);var a=Math.floor(r/this.columnWidth);a=Math.min(this.cols-1,a);for(var h=(this.options.isOriginTop?n.top:n.bottom)+i.outerHeight,u=s;a>=u;u++)this.colYs[u]=Math.max(h,this.colYs[u])},n.prototype._getContainerSize=function(){this.maxY=Math.max.apply(Math,this.colYs);var t={height:this.maxY};return this.options.isFitWidth&&(t.width=this._getContainerFitWidth()),t},n.prototype._getContainerFitWidth=function(){for(var t=0,e=this.cols;--e&&0===this.colYs[e];)t++;return(this.cols-t)*this.columnWidth-this.gutter},n.prototype.resize=function(){var t=this._getSizingContainer(),i=e(t),n=this.size&&i;n&&i.innerWidth===this._containerWidth||(this.layout(),delete this.resizeTimeout)},n}var i=Array.prototype.indexOf?function(t,e){return t.indexOf(e)}:function(t,e){for(var i=0,n=t.length;n>i;i++){var o=t[i];if(o===e)return i}return-1};"function"==typeof define&&define.amd?define(["outlayer/outlayer","get-size/get-size"],e):t.Masonry=e(t.Outlayer,t.getSize)}(window);
/*!
 * imagesLoaded PACKAGED v3.2.0
 * JavaScript is all like "You images are done yet or what?"
 * MIT License
 */

(function(){"use strict";function e(){}function t(e,t){for(var n=e.length;n--;)if(e[n].listener===t)return n;return-1}function n(e){return function(){return this[e].apply(this,arguments)}}var i=e.prototype,r=this,s=r.EventEmitter;i.getListeners=function(e){var t,n,i=this._getEvents();if("object"==typeof e){t={};for(n in i)i.hasOwnProperty(n)&&e.test(n)&&(t[n]=i[n])}else t=i[e]||(i[e]=[]);return t},i.flattenListeners=function(e){var t,n=[];for(t=0;t<e.length;t+=1)n.push(e[t].listener);return n},i.getListenersAsObject=function(e){var t,n=this.getListeners(e);return n instanceof Array&&(t={},t[e]=n),t||n},i.addListener=function(e,n){var i,r=this.getListenersAsObject(e),s="object"==typeof n;for(i in r)r.hasOwnProperty(i)&&-1===t(r[i],n)&&r[i].push(s?n:{listener:n,once:!1});return this},i.on=n("addListener"),i.addOnceListener=function(e,t){return this.addListener(e,{listener:t,once:!0})},i.once=n("addOnceListener"),i.defineEvent=function(e){return this.getListeners(e),this},i.defineEvents=function(e){for(var t=0;t<e.length;t+=1)this.defineEvent(e[t]);return this},i.removeListener=function(e,n){var i,r,s=this.getListenersAsObject(e);for(r in s)s.hasOwnProperty(r)&&(i=t(s[r],n),-1!==i&&s[r].splice(i,1));return this},i.off=n("removeListener"),i.addListeners=function(e,t){return this.manipulateListeners(!1,e,t)},i.removeListeners=function(e,t){return this.manipulateListeners(!0,e,t)},i.manipulateListeners=function(e,t,n){var i,r,s=e?this.removeListener:this.addListener,o=e?this.removeListeners:this.addListeners;if("object"!=typeof t||t instanceof RegExp)for(i=n.length;i--;)s.call(this,t,n[i]);else for(i in t)t.hasOwnProperty(i)&&(r=t[i])&&("function"==typeof r?s.call(this,i,r):o.call(this,i,r));return this},i.removeEvent=function(e){var t,n=typeof e,i=this._getEvents();if("string"===n)delete i[e];else if("object"===n)for(t in i)i.hasOwnProperty(t)&&e.test(t)&&delete i[t];else delete this._events;return this},i.removeAllListeners=n("removeEvent"),i.emitEvent=function(e,t){var n,i,r,s,o=this.getListenersAsObject(e);for(r in o)if(o.hasOwnProperty(r))for(i=o[r].length;i--;)n=o[r][i],n.once===!0&&this.removeListener(e,n.listener),s=n.listener.apply(this,t||[]),s===this._getOnceReturnValue()&&this.removeListener(e,n.listener);return this},i.trigger=n("emitEvent"),i.emit=function(e){var t=Array.prototype.slice.call(arguments,1);return this.emitEvent(e,t)},i.setOnceReturnValue=function(e){return this._onceReturnValue=e,this},i._getOnceReturnValue=function(){return this.hasOwnProperty("_onceReturnValue")?this._onceReturnValue:!0},i._getEvents=function(){return this._events||(this._events={})},e.noConflict=function(){return r.EventEmitter=s,e},"function"==typeof define&&define.amd?define("eventEmitter/EventEmitter",[],function(){return e}):"object"==typeof module&&module.exports?module.exports=e:this.EventEmitter=e}).call(this),function(e){function t(t){var n=e.event;return n.target=n.target||n.srcElement||t,n}var n=document.documentElement,i=function(){};n.addEventListener?i=function(e,t,n){e.addEventListener(t,n,!1)}:n.attachEvent&&(i=function(e,n,i){e[n+i]=i.handleEvent?function(){var n=t(e);i.handleEvent.call(i,n)}:function(){var n=t(e);i.call(e,n)},e.attachEvent("on"+n,e[n+i])});var r=function(){};n.removeEventListener?r=function(e,t,n){e.removeEventListener(t,n,!1)}:n.detachEvent&&(r=function(e,t,n){e.detachEvent("on"+t,e[t+n]);try{delete e[t+n]}catch(i){e[t+n]=void 0}});var s={bind:i,unbind:r};"function"==typeof define&&define.amd?define("eventie/eventie",s):e.eventie=s}(this),function(e,t){"use strict";"function"==typeof define&&define.amd?define(["eventEmitter/EventEmitter","eventie/eventie"],function(n,i){return t(e,n,i)}):"object"==typeof module&&module.exports?module.exports=t(e,require("wolfy87-eventemitter"),require("eventie")):e.imagesLoaded=t(e,e.EventEmitter,e.eventie)}(window,function(e,t,n){function i(e,t){for(var n in t)e[n]=t[n];return e}function r(e){return"[object Array]"==f.call(e)}function s(e){var t=[];if(r(e))t=e;else if("number"==typeof e.length)for(var n=0;n<e.length;n++)t.push(e[n]);else t.push(e);return t}function o(e,t,n){if(!(this instanceof o))return new o(e,t,n);"string"==typeof e&&(e=document.querySelectorAll(e)),this.elements=s(e),this.options=i({},this.options),"function"==typeof t?n=t:i(this.options,t),n&&this.on("always",n),this.getImages(),u&&(this.jqDeferred=new u.Deferred);var r=this;setTimeout(function(){r.check()})}function h(e){this.img=e}function a(e,t){this.url=e,this.element=t,this.img=new Image}var u=e.jQuery,c=e.console,f=Object.prototype.toString;o.prototype=new t,o.prototype.options={},o.prototype.getImages=function(){this.images=[];for(var e=0;e<this.elements.length;e++){var t=this.elements[e];this.addElementImages(t)}},o.prototype.addElementImages=function(e){"IMG"==e.nodeName&&this.addImage(e),this.options.background===!0&&this.addElementBackgroundImages(e);var t=e.nodeType;if(t&&d[t]){for(var n=e.querySelectorAll("img"),i=0;i<n.length;i++){var r=n[i];this.addImage(r)}if("string"==typeof this.options.background){var s=e.querySelectorAll(this.options.background);for(i=0;i<s.length;i++){var o=s[i];this.addElementBackgroundImages(o)}}}};var d={1:!0,9:!0,11:!0};o.prototype.addElementBackgroundImages=function(e){for(var t=m(e),n=/url\(['"]*([^'"\)]+)['"]*\)/gi,i=n.exec(t.backgroundImage);null!==i;){var r=i&&i[1];r&&this.addBackground(r,e),i=n.exec(t.backgroundImage)}};var m=e.getComputedStyle||function(e){return e.currentStyle};return o.prototype.addImage=function(e){var t=new h(e);this.images.push(t)},o.prototype.addBackground=function(e,t){var n=new a(e,t);this.images.push(n)},o.prototype.check=function(){function e(e,n,i){setTimeout(function(){t.progress(e,n,i)})}var t=this;if(this.progressedCount=0,this.hasAnyBroken=!1,!this.images.length)return void this.complete();for(var n=0;n<this.images.length;n++){var i=this.images[n];i.once("progress",e),i.check()}},o.prototype.progress=function(e,t,n){this.progressedCount++,this.hasAnyBroken=this.hasAnyBroken||!e.isLoaded,this.emit("progress",this,e,t),this.jqDeferred&&this.jqDeferred.notify&&this.jqDeferred.notify(this,e),this.progressedCount==this.images.length&&this.complete(),this.options.debug&&c&&c.log("progress: "+n,e,t)},o.prototype.complete=function(){var e=this.hasAnyBroken?"fail":"done";if(this.isComplete=!0,this.emit(e,this),this.emit("always",this),this.jqDeferred){var t=this.hasAnyBroken?"reject":"resolve";this.jqDeferred[t](this)}},h.prototype=new t,h.prototype.check=function(){var e=this.getIsImageComplete();return e?void this.confirm(0!==this.img.naturalWidth,"naturalWidth"):(this.proxyImage=new Image,n.bind(this.proxyImage,"load",this),n.bind(this.proxyImage,"error",this),n.bind(this.img,"load",this),n.bind(this.img,"error",this),void(this.proxyImage.src=this.img.src))},h.prototype.getIsImageComplete=function(){return this.img.complete&&void 0!==this.img.naturalWidth},h.prototype.confirm=function(e,t){this.isLoaded=e,this.emit("progress",this,this.img,t)},h.prototype.handleEvent=function(e){var t="on"+e.type;this[t]&&this[t](e)},h.prototype.onload=function(){this.confirm(!0,"onload"),this.unbindEvents()},h.prototype.onerror=function(){this.confirm(!1,"onerror"),this.unbindEvents()},h.prototype.unbindEvents=function(){n.unbind(this.proxyImage,"load",this),n.unbind(this.proxyImage,"error",this),n.unbind(this.img,"load",this),n.unbind(this.img,"error",this)},a.prototype=new h,a.prototype.check=function(){n.bind(this.img,"load",this),n.bind(this.img,"error",this),this.img.src=this.url;var e=this.getIsImageComplete();e&&(this.confirm(0!==this.img.naturalWidth,"naturalWidth"),this.unbindEvents())},a.prototype.unbindEvents=function(){n.unbind(this.img,"load",this),n.unbind(this.img,"error",this)},a.prototype.confirm=function(e,t){this.isLoaded=e,this.emit("progress",this,this.element,t)},o.makeJQueryPlugin=function(t){t=t||e.jQuery,t&&(u=t,u.fn.imagesLoaded=function(e,t){var n=new o(this,e,t);return n.jqDeferred.promise(u(this))})},o.makeJQueryPlugin(),o});/*!
	Colorbox 1.5.14
	license: MIT
	http://www.jacklmoore.com/colorbox
*/
(function(t,e,i){function n(i,n,o){var r=e.createElement(i);return n&&(r.id=Z+n),o&&(r.style.cssText=o),t(r)}function o(){return i.innerHeight?i.innerHeight:t(i).height()}function r(e,i){i!==Object(i)&&(i={}),this.cache={},this.el=e,this.value=function(e){var n;return void 0===this.cache[e]&&(n=t(this.el).attr("data-cbox-"+e),void 0!==n?this.cache[e]=n:void 0!==i[e]?this.cache[e]=i[e]:void 0!==X[e]&&(this.cache[e]=X[e])),this.cache[e]},this.get=function(e){var i=this.value(e);return t.isFunction(i)?i.call(this.el,this):i}}function h(t){var e=W.length,i=(z+t)%e;return 0>i?e+i:i}function a(t,e){return Math.round((/%/.test(t)?("x"===e?E.width():o())/100:1)*parseInt(t,10))}function s(t,e){return t.get("photo")||t.get("photoRegex").test(e)}function l(t,e){return t.get("retinaUrl")&&i.devicePixelRatio>1?e.replace(t.get("photoRegex"),t.get("retinaSuffix")):e}function d(t){"contains"in y[0]&&!y[0].contains(t.target)&&t.target!==v[0]&&(t.stopPropagation(),y.focus())}function c(t){c.str!==t&&(y.add(v).removeClass(c.str).addClass(t),c.str=t)}function g(e){z=0,e&&e!==!1&&"nofollow"!==e?(W=t("."+te).filter(function(){var i=t.data(this,Y),n=new r(this,i);return n.get("rel")===e}),z=W.index(_.el),-1===z&&(W=W.add(_.el),z=W.length-1)):W=t(_.el)}function u(i){t(e).trigger(i),ae.triggerHandler(i)}function f(i){var o;if(!G){if(o=t(i).data(Y),_=new r(i,o),g(_.get("rel")),!$){$=q=!0,c(_.get("className")),y.css({visibility:"hidden",display:"block",opacity:""}),L=n(se,"LoadedContent","width:0; height:0; overflow:hidden; visibility:hidden"),b.css({width:"",height:""}).append(L),D=T.height()+k.height()+b.outerHeight(!0)-b.height(),j=C.width()+H.width()+b.outerWidth(!0)-b.width(),A=L.outerHeight(!0),N=L.outerWidth(!0);var h=a(_.get("initialWidth"),"x"),s=a(_.get("initialHeight"),"y"),l=_.get("maxWidth"),f=_.get("maxHeight");_.w=(l!==!1?Math.min(h,a(l,"x")):h)-N-j,_.h=(f!==!1?Math.min(s,a(f,"y")):s)-A-D,L.css({width:"",height:_.h}),J.position(),u(ee),_.get("onOpen"),O.add(F).hide(),y.focus(),_.get("trapFocus")&&e.addEventListener&&(e.addEventListener("focus",d,!0),ae.one(re,function(){e.removeEventListener("focus",d,!0)})),_.get("returnFocus")&&ae.one(re,function(){t(_.el).focus()})}var p=parseFloat(_.get("opacity"));v.css({opacity:p===p?p:"",cursor:_.get("overlayClose")?"pointer":"",visibility:"visible"}).show(),_.get("closeButton")?B.html(_.get("close")).appendTo(b):B.appendTo("<div/>"),w()}}function p(){y||(V=!1,E=t(i),y=n(se).attr({id:Y,"class":t.support.opacity===!1?Z+"IE":"",role:"dialog",tabindex:"-1"}).hide(),v=n(se,"Overlay").hide(),S=t([n(se,"LoadingOverlay")[0],n(se,"LoadingGraphic")[0]]),x=n(se,"Wrapper"),b=n(se,"Content").append(F=n(se,"Title"),I=n(se,"Current"),P=t('<button type="button"/>').attr({id:Z+"Previous"}),K=t('<button type="button"/>').attr({id:Z+"Next"}),R=n("button","Slideshow"),S),B=t('<button type="button"/>').attr({id:Z+"Close"}),x.append(n(se).append(n(se,"TopLeft"),T=n(se,"TopCenter"),n(se,"TopRight")),n(se,!1,"clear:left").append(C=n(se,"MiddleLeft"),b,H=n(se,"MiddleRight")),n(se,!1,"clear:left").append(n(se,"BottomLeft"),k=n(se,"BottomCenter"),n(se,"BottomRight"))).find("div div").css({"float":"left"}),M=n(se,!1,"position:absolute; width:9999px; visibility:hidden; display:none; max-width:none;"),O=K.add(P).add(I).add(R)),e.body&&!y.parent().length&&t(e.body).append(v,y.append(x,M))}function m(){function i(t){t.which>1||t.shiftKey||t.altKey||t.metaKey||t.ctrlKey||(t.preventDefault(),f(this))}return y?(V||(V=!0,K.click(function(){J.next()}),P.click(function(){J.prev()}),B.click(function(){J.close()}),v.click(function(){_.get("overlayClose")&&J.close()}),t(e).bind("keydown."+Z,function(t){var e=t.keyCode;$&&_.get("escKey")&&27===e&&(t.preventDefault(),J.close()),$&&_.get("arrowKey")&&W[1]&&!t.altKey&&(37===e?(t.preventDefault(),P.click()):39===e&&(t.preventDefault(),K.click()))}),t.isFunction(t.fn.on)?t(e).on("click."+Z,"."+te,i):t("."+te).live("click."+Z,i)),!0):!1}function w(){var e,o,r,h=J.prep,d=++le;if(q=!0,U=!1,u(he),u(ie),_.get("onLoad"),_.h=_.get("height")?a(_.get("height"),"y")-A-D:_.get("innerHeight")&&a(_.get("innerHeight"),"y"),_.w=_.get("width")?a(_.get("width"),"x")-N-j:_.get("innerWidth")&&a(_.get("innerWidth"),"x"),_.mw=_.w,_.mh=_.h,_.get("maxWidth")&&(_.mw=a(_.get("maxWidth"),"x")-N-j,_.mw=_.w&&_.w<_.mw?_.w:_.mw),_.get("maxHeight")&&(_.mh=a(_.get("maxHeight"),"y")-A-D,_.mh=_.h&&_.h<_.mh?_.h:_.mh),e=_.get("href"),Q=setTimeout(function(){S.show()},100),_.get("inline")){var c=t(e);r=t("<div>").hide().insertBefore(c),ae.one(he,function(){r.replaceWith(c)}),h(c)}else _.get("iframe")?h(" "):_.get("html")?h(_.get("html")):s(_,e)?(e=l(_,e),U=new Image,t(U).addClass(Z+"Photo").bind("error",function(){h(n(se,"Error").html(_.get("imgError")))}).one("load",function(){d===le&&setTimeout(function(){var e;t.each(["alt","longdesc","aria-describedby"],function(e,i){var n=t(_.el).attr(i)||t(_.el).attr("data-"+i);n&&U.setAttribute(i,n)}),_.get("retinaImage")&&i.devicePixelRatio>1&&(U.height=U.height/i.devicePixelRatio,U.width=U.width/i.devicePixelRatio),_.get("scalePhotos")&&(o=function(){U.height-=U.height*e,U.width-=U.width*e},_.mw&&U.width>_.mw&&(e=(U.width-_.mw)/U.width,o()),_.mh&&U.height>_.mh&&(e=(U.height-_.mh)/U.height,o())),_.h&&(U.style.marginTop=Math.max(_.mh-U.height,0)/2+"px"),W[1]&&(_.get("loop")||W[z+1])&&(U.style.cursor="pointer",U.onclick=function(){J.next()}),U.style.width=U.width+"px",U.style.height=U.height+"px",h(U)},1)}),U.src=e):e&&M.load(e,_.get("data"),function(e,i){d===le&&h("error"===i?n(se,"Error").html(_.get("xhrError")):t(this).contents())})}var v,y,x,b,T,C,H,k,W,E,L,M,S,F,I,R,K,P,B,O,_,D,j,A,N,z,U,$,q,G,Q,J,V,X={html:!1,photo:!1,iframe:!1,inline:!1,transition:"elastic",speed:300,fadeOut:300,width:!1,initialWidth:"600",innerWidth:!1,maxWidth:!1,height:!1,initialHeight:"450",innerHeight:!1,maxHeight:!1,scalePhotos:!0,scrolling:!0,opacity:.9,preloading:!0,className:!1,overlayClose:!0,escKey:!0,arrowKey:!0,top:!1,bottom:!1,left:!1,right:!1,fixed:!1,data:void 0,closeButton:!0,fastIframe:!0,open:!1,reposition:!0,loop:!0,slideshow:!1,slideshowAuto:!0,slideshowSpeed:2500,slideshowStart:"start slideshow",slideshowStop:"stop slideshow",photoRegex:/\.(gif|png|jp(e|g|eg)|bmp|ico|webp|jxr|svg)((#|\?).*)?$/i,retinaImage:!1,retinaUrl:!1,retinaSuffix:"@2x.$1",current:"image {current} of {total}",previous:"previous",next:"next",close:"close",xhrError:"This content failed to load.",imgError:"This image failed to load.",returnFocus:!0,trapFocus:!0,onOpen:!1,onLoad:!1,onComplete:!1,onCleanup:!1,onClosed:!1,rel:function(){return this.rel},href:function(){return t(this).attr("href")},title:function(){return this.title}},Y="colorbox",Z="cbox",te=Z+"Element",ee=Z+"_open",ie=Z+"_load",ne=Z+"_complete",oe=Z+"_cleanup",re=Z+"_closed",he=Z+"_purge",ae=t("<a/>"),se="div",le=0,de={},ce=function(){function t(){clearTimeout(h)}function e(){(_.get("loop")||W[z+1])&&(t(),h=setTimeout(J.next,_.get("slideshowSpeed")))}function i(){R.html(_.get("slideshowStop")).unbind(s).one(s,n),ae.bind(ne,e).bind(ie,t),y.removeClass(a+"off").addClass(a+"on")}function n(){t(),ae.unbind(ne,e).unbind(ie,t),R.html(_.get("slideshowStart")).unbind(s).one(s,function(){J.next(),i()}),y.removeClass(a+"on").addClass(a+"off")}function o(){r=!1,R.hide(),t(),ae.unbind(ne,e).unbind(ie,t),y.removeClass(a+"off "+a+"on")}var r,h,a=Z+"Slideshow_",s="click."+Z;return function(){r?_.get("slideshow")||(ae.unbind(oe,o),o()):_.get("slideshow")&&W[1]&&(r=!0,ae.one(oe,o),_.get("slideshowAuto")?i():n(),R.show())}}();t[Y]||(t(p),J=t.fn[Y]=t[Y]=function(e,i){var n,o=this;if(e=e||{},t.isFunction(o))o=t("<a/>"),e.open=!0;else if(!o[0])return o;return o[0]?(p(),m()&&(i&&(e.onComplete=i),o.each(function(){var i=t.data(this,Y)||{};t.data(this,Y,t.extend(i,e))}).addClass(te),n=new r(o[0],e),n.get("open")&&f(o[0])),o):o},J.position=function(e,i){function n(){T[0].style.width=k[0].style.width=b[0].style.width=parseInt(y[0].style.width,10)-j+"px",b[0].style.height=C[0].style.height=H[0].style.height=parseInt(y[0].style.height,10)-D+"px"}var r,h,s,l=0,d=0,c=y.offset();if(E.unbind("resize."+Z),y.css({top:-9e4,left:-9e4}),h=E.scrollTop(),s=E.scrollLeft(),_.get("fixed")?(c.top-=h,c.left-=s,y.css({position:"fixed"})):(l=h,d=s,y.css({position:"absolute"})),d+=_.get("right")!==!1?Math.max(E.width()-_.w-N-j-a(_.get("right"),"x"),0):_.get("left")!==!1?a(_.get("left"),"x"):Math.round(Math.max(E.width()-_.w-N-j,0)/2),l+=_.get("bottom")!==!1?Math.max(o()-_.h-A-D-a(_.get("bottom"),"y"),0):_.get("top")!==!1?a(_.get("top"),"y"):Math.round(Math.max(o()-_.h-A-D,0)/2),y.css({top:c.top,left:c.left,visibility:"visible"}),x[0].style.width=x[0].style.height="9999px",r={width:_.w+N+j,height:_.h+A+D,top:l,left:d},e){var g=0;t.each(r,function(t){return r[t]!==de[t]?(g=e,void 0):void 0}),e=g}de=r,e||y.css(r),y.dequeue().animate(r,{duration:e||0,complete:function(){n(),q=!1,x[0].style.width=_.w+N+j+"px",x[0].style.height=_.h+A+D+"px",_.get("reposition")&&setTimeout(function(){E.bind("resize."+Z,J.position)},1),t.isFunction(i)&&i()},step:n})},J.resize=function(t){var e;$&&(t=t||{},t.width&&(_.w=a(t.width,"x")-N-j),t.innerWidth&&(_.w=a(t.innerWidth,"x")),L.css({width:_.w}),t.height&&(_.h=a(t.height,"y")-A-D),t.innerHeight&&(_.h=a(t.innerHeight,"y")),t.innerHeight||t.height||(e=L.scrollTop(),L.css({height:"auto"}),_.h=L.height()),L.css({height:_.h}),e&&L.scrollTop(e),J.position("none"===_.get("transition")?0:_.get("speed")))},J.prep=function(i){function o(){return _.w=_.w||L.width(),_.w=_.mw&&_.mw<_.w?_.mw:_.w,_.w}function a(){return _.h=_.h||L.height(),_.h=_.mh&&_.mh<_.h?_.mh:_.h,_.h}if($){var d,g="none"===_.get("transition")?0:_.get("speed");L.remove(),L=n(se,"LoadedContent").append(i),L.hide().appendTo(M.show()).css({width:o(),overflow:_.get("scrolling")?"auto":"hidden"}).css({height:a()}).prependTo(b),M.hide(),t(U).css({"float":"none"}),c(_.get("className")),d=function(){function i(){t.support.opacity===!1&&y[0].style.removeAttribute("filter")}var n,o,a=W.length;$&&(o=function(){clearTimeout(Q),S.hide(),u(ne),_.get("onComplete")},F.html(_.get("title")).show(),L.show(),a>1?("string"==typeof _.get("current")&&I.html(_.get("current").replace("{current}",z+1).replace("{total}",a)).show(),K[_.get("loop")||a-1>z?"show":"hide"]().html(_.get("next")),P[_.get("loop")||z?"show":"hide"]().html(_.get("previous")),ce(),_.get("preloading")&&t.each([h(-1),h(1)],function(){var i,n=W[this],o=new r(n,t.data(n,Y)),h=o.get("href");h&&s(o,h)&&(h=l(o,h),i=e.createElement("img"),i.src=h)})):O.hide(),_.get("iframe")?(n=e.createElement("iframe"),"frameBorder"in n&&(n.frameBorder=0),"allowTransparency"in n&&(n.allowTransparency="true"),_.get("scrolling")||(n.scrolling="no"),t(n).attr({src:_.get("href"),name:(new Date).getTime(),"class":Z+"Iframe",allowFullScreen:!0}).one("load",o).appendTo(L),ae.one(he,function(){n.src="//about:blank"}),_.get("fastIframe")&&t(n).trigger("load")):o(),"fade"===_.get("transition")?y.fadeTo(g,1,i):i())},"fade"===_.get("transition")?y.fadeTo(g,0,function(){J.position(0,d)}):J.position(g,d)}},J.next=function(){!q&&W[1]&&(_.get("loop")||W[z+1])&&(z=h(1),f(W[z]))},J.prev=function(){!q&&W[1]&&(_.get("loop")||z)&&(z=h(-1),f(W[z]))},J.close=function(){$&&!G&&(G=!0,$=!1,u(oe),_.get("onCleanup"),E.unbind("."+Z),v.fadeTo(_.get("fadeOut")||0,0),y.stop().fadeTo(_.get("fadeOut")||0,0,function(){y.hide(),v.hide(),u(he),L.remove(),setTimeout(function(){G=!1,u(re),_.get("onClosed")},1)}))},J.remove=function(){y&&(y.stop(),t[Y].close(),y.stop(!1,!0).remove(),v.remove(),G=!1,y=null,t("."+te).removeData(Y).removeClass(te),t(e).unbind("click."+Z).unbind("keydown."+Z))},J.element=function(){return t(_.el)},J.settings=X)})(jQuery,document,window);

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
function toggleClass(innerDiv)
{if(innerDiv.className=="chatmainbody")
{innerDiv=$(innerDiv).next("div").next("div").get(0).firstChild;}
if(innerDiv.className=="chosenreply")
{innerDiv.className=innerDiv.getAttribute('oldClass');}
else
{innerDiv.setAttribute('oldClass',innerDiv.className);innerDiv.className="chosenreply";}
var parentDiv=innerDiv.parentNode.parentNode;if(parentDiv.className=="chosenreply")
{parentDiv.className=parentDiv.getAttribute('oldClass');}
else
{parentDiv.setAttribute('oldClass',parentDiv.className);parentDiv.className="chosenreply";}}
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
newDiv.className = "white_box span3";
$("#new_post_alert").toggle();
$("#new_post_private").toggle();
$("#new_post_container").removeClass("span7").addClass("span3");
$("#subject_container").hide();
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
        move_to_other_div = true;
    }
	
}
var existingDiv=document.getElementById('replyInputsDiv');
if(existingDiv)
{prevDiv.removeChild(existingDiv);topDiv.innerHTML=existingDiv.innerHTML;currentdividxflag.value = ""; 
if (move_to_other_div)
{
newDiv.innerHTML=existingDiv.innerHTML;
topDiv.innerHTML="";
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
$(".href").colorbox({maxWidth:'95%', maxHeight:'95%', width:"35%", inline:true, href:"#href_dialog"});$("a[rel='external']").colorbox({maxWidth:'95%', maxHeight:'95%', iframe:true});$(".mood").colorbox({width:"35%", inline:true, href:"#moods_dialog"});}
function restoreTopDiv()
{var topDiv=document.getElementById('new_post');var existingDiv=document.getElementById('replyInputsDiv');if(existingDiv)
{topDiv.innerHTML=existingDiv.innerHTML;
    toggleClass($(existingDiv).parent().children('.chatmainbody').get(0));
    toggle($(existingDiv).parent().children('.pivotpointer').get(0).id);
    $('#current_new_msg_idx').val('');
    $('#current_post_idx').val('');
    existingDiv.parentNode.removeChild(existingDiv);}}
function fillMessage(str)
{
try {
var msgDetails=document.getElementById('msgDetails');
var currentPosts = msgDetails.innerHTML;
if ($('#current_forum_update_display').val() == 'R')
{
    if(msgDetails.firstChild)
        msgDetails.removeChild(msgDetails.firstChild);
    msgDetails.innerHTML=str;
}
else
{
    msgDetails.innerHTML= currentPosts.concat(str);
}

closeNewPost();

 var container = document.querySelector('#msgDetails');
var msnry = new Masonry( container, {
itemSelector: '.white_box2',
isOriginLeft: false,
columnWidth: '#msgDetails .white_box2',
gutter: 8
});
$('#msgDetails').imagesLoaded( function() {
msnry.layout();
});

}
catch (e){
alert (e);
}
}

$(document).ready(function(){$(".colorbox").colorbox({maxWidth:"95%"});
$("a[rel='external']").colorbox({width:"99%", height:"85%", iframe:true});
$("a[title='legend']").colorbox({width:"85%"});02/03/2018
$(".href").colorbox({width:"35%", inline:true, href:"#href_dialog"});
$(".imghref").colorbox({width:"35%", inline:true, href:"#href_img_dialog"});
$(".mood").colorbox({width:"35%", inline:true, href:"#moods_dialog"});
$(".user_icon").colorbox({width:"35%", inline:true, href:"#user_icon_dialog"});
$("#login").colorbox({width:"290px", height:"290px", inline:true, top:"40px", href:"#loginform"});
$(".register").colorbox({width:"290px", height:"420px", inline:true, top:"40px", fixed:true,href:"#registerform"});
$("#forgotpass").colorbox({width:"290px", height:"200px", inline:true, top:"40px", fixed:true, href:"#passforgotform",onOpen:function(){}});
$("#updateprofile").colorbox({width:"290px", inline:true, top:"40px",fixed:true, href:"#profileform"});
$(".icon_forecast").colorbox({width:"35%", inline:true, href:"#icons_dialog"});
$(".temphigh").colorbox({width:"35%", inline:true, href:"#clothes_dialog"});
$(".tempnight").colorbox({width:"35%", inline:true, href:"#clothes_dialog"});
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
function show(id){$('#'+id).show("slow");}
function hide(id){$('#'+id).hide("slow");}
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
function change_main(id, t, lang){
 var direction = "left";
 var moveTo = "";
 var animationProperties = {};
 if (lang == 1)
    direction = "right";
else
    direction = "left";
 animationProperties[direction] = moveTo;   
 
 if (id == "#forcast_days") {
	 $('#mainadsense').show("slow");
     animationProperties[direction] = "0px";
 } else if (id == "#forcast_hours") {
	 $('#mainadsense').show("slow");
     animationProperties[direction] = "-560px";
 } else {
	 $('#mainadsense').hide("slow");$('#forcast_main').css('width','860px');
     animationProperties[direction] = "-1170px";
 }
 $("#forcast_main .contentbox-wrapper").animate(animationProperties, 600);

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
     if (info_id != "latestnow")
        document.getElementById("now_btn").style.backgroundPosition = "left";
     else
        document.getElementById("now_btn").style.backgroundPosition = "right";
     document.getElementById("latestnow").style.display = "none";
     document.getElementById("latesttemp").style.display = "none";
     document.getElementById("latesttemp2").style.display = "none";
     document.getElementById("latesttemp3").style.display = "none";
     document.getElementById("latestpressure").style.display = "none";
     document.getElementById("latesthumidity").style.display = "none";
     document.getElementById("latestuv").style.display = "none";
     document.getElementById("latestdewpoint").style.display = "none";
     document.getElementById("latestradiation").style.display = "none";
     document.getElementById("latestrain").style.display = "none";
     document.getElementById("latestwind").style.display = "none";
     document.getElementById("latestairq").style.display = "none";
     document.getElementById("latestwindow").style.display = "none";
     document.getElementById("latestwebcam").style.display = "none";
     document.getElementById("latestmoon").style.display = "none";
     document.getElementById("chartjs-tooltip").style.display = "none";
	 var desktop = document.getElementById("now_line");
	 if (desktop){
                document.getElementById("coldmetersurvey").style.display = "none";
                 document.getElementById("fseasonsurvey").style.display = "none";
		 document.getElementById("now_line").style.visibility = "hidden";
                 document.getElementById("temp2_line").style.visibility = "hidden";
                 document.getElementById("temp3_line").style.visibility = "hidden";
		 document.getElementById("temp_line").style.visibility = "hidden";
		 document.getElementById("moist_line").style.visibility = "hidden";
                 document.getElementById("dew_line").style.visibility = "hidden";
		 document.getElementById("wind_line").style.visibility = "hidden";
		 document.getElementById("air_line").style.visibility = "hidden";
		 document.getElementById("rain_line").style.visibility = "hidden";
		 document.getElementById("rad_line").style.visibility = "hidden";
		 document.getElementById("uv_line").style.visibility = "hidden";
		 document.getElementById("cold_line").style.visibility = "hidden";
		 document.getElementById("aq_line").style.visibility = "hidden";
		 document.getElementById("fseason_line").style.visibility = "hidden";
         document.getElementById("window_line").style.visibility = "hidden";
         document.getElementById("moon_line").style.visibility = "hidden";
		 document.getElementById(line_id).style.visibility = "visible";
	 }
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
  
function change_subject(whichSide) {
    var started_subject = $("#current_forum_filter").val();
    var startedNode = $("#forum_filter").find("." + started_subject);
    var newNode = startedNode;
    if (whichSide == "left") {
        if (!($(startedNode).is(':first-child'))){
        newNode = $(startedNode).prev("div");
        }
    } else if (whichSide == "right") {
       if (!($(startedNode).is(':last-child'))){
        newNode = $(startedNode).next("div");
       }
    }
    $("#current_forum_filter").val($(newNode).attr("class"));
    $("#current_forum_filter").attr('data-key',$(newNode).attr("data-key"));
    $("#subject_icon").attr('class', '');
    $("#subject_icon").addClass($(newNode).attr("class"));
}


function changeBg(id, color) {
    document.getElementById(id).style.backgroundColor=color;
}

function openNewPost(lang) {
    document.getElementById("new_post").style.visibility = "visible";
    document.getElementById("forum_hr").style.marginTop = "270px";
    document.getElementById("new_post_ta").value = "";
    $('#new_post_user').addClass($('#user_icon').attr('class'));
    $('#subject_icon').addClass($('#current_forum_filter').val());
    initTinyMCE(lang);
}

function closeNewPost() {
    //tinyMCE.execCommand('mceFocus', false, 'new_post_ta');      
    //tinyMCE.execCommand('mceRemoveControl', false, 'new_post_ta');
    //$('#new_post_ta').tinymce().remove();
    tinyMCE.remove();
    
    document.getElementById("new_post").style.visibility = "hidden";
    document.getElementById("forum_hr").style.marginTop = "10px";
}

 function change_icon(whichSide, arrowdiv) {
    var user_icon_contentbox = $(arrowdiv).parent().find("#user_icon_contentbox");
    var rightVal = user_icon_contentbox.css("right");
    
    var x;
    if (rightVal == "")
        x=0;
    else
        x = parseInt(rightVal);
    var w = user_icon_contentbox.width();
    var started_icon = $("#chosen_user_icon").val();
    var startedNode = $("#user_icon_contentbox").find("." + started_icon);
    if ((whichSide == "left") && (x<0)) {
        //user_icon_contentbox.animate({"right": (x+36) + "px"}, "fast");
        user_icon_contentbox.css("right", (x+36) + "px");
         var newclass = $(startedNode).parent().prev("div").children().first().attr("class");
         $("#chosen_user_icon").val(newclass);
    } else if ( (whichSide == "right") && (x>(50-w)) ) {
        //user_icon_contentbox.animate({"right": (x-36) + "px"}, "fast");
        user_icon_contentbox.css("right", (x-36) + "px");
        var newclass = $(startedNode).parent().next("div").children().first().attr("class");
        $("#chosen_user_icon").val(newclass);
    }
    return newclass;
}
function change_icon_to(rightValue) {
$("#user_icon_contentbox").animate({"right": rightValue}, 400, "swing");
}
function  fillForecastTemp  (jsonstr)
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
                                  $(this).next().next().next().html('<span>' + jsonT.forecasthours[i].temp + '</span>');
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
function addlinkToMessage(as_image)
{
        var target;
        var img = "";
        var href;
        var innerhref;
        if (as_image){
            href = $("#imghref").val();
			target = "\" rel=\"external\"";
            innerhref = "<img src=\"" + $("#imghref").val() + "\" title=\"" + $("#imgtitle").val() + "\" width=\"150\" />";
        }
        else{
            
            if (($("#linkhref").val().indexOf("youtu") > 0)||
                    ($("#linkhref").val().indexOf("facebook") > 0))
              target = "\" target=\"_blank\""; else target = "\" rel=\"external\"";
              href = $("#linkhref").val();
              innerhref = $("#linktitle").val();
         }
        $("#new_post_ta").val($("#new_post_ta").val() + " <a href=\"" + href + "\"" + target + ">" + innerhref + "</a> ");
        $("#cboxClose").click();
        $("#new_post_ta").focus();
}
function closeLinktoMessage()
{
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
                var PERSONAL_COLD_METER_VOTES_THRESHHOLD = 0;
        	var jsonT = JSON.parse( jsonstr  );
        	 $("#profileform_email").val(jsonT.user.email);
                 $("#name").html(jsonT.user.display);updateprofile_to_server
                 $("#user_name").html(jsonT.user.display);
                 $("#user_icon").addClass(jsonT.user.icon);
                 // chosen_user_icon should be the first - change_icon will update this to the DB value
                 $("#chosen_user_icon").val($("#user_icon_contentbox").children().first().children().first().attr('class'));
                 $("#profileform_user_icon").addClass(jsonT.user.icon);
                 $("#profileform_displayname").val(jsonT.user.display);
                 $("#current_display_name").val(jsonT.user.display);
                 $("#profileform_nicename").val(jsonT.user.nicename);
                 $("#profileform_priority").prop("checked", jsonT.user.priority);
                 $("#profileform_personal_coldmeter").prop("checked", jsonT.user.PersonalColdMeter);
                 $("#profileform_personal_coldmeter").prop("disabled", (jsonT.user.voteCount < PERSONAL_COLD_METER_VOTES_THRESHHOLD));
                 if ((jsonT.user.voteCount >= PERSONAL_COLD_METER_VOTES_THRESHHOLD)&&(jsonT.user.PersonalColdMeter == 0)&&($("#personal_message")))
                    $("#personal_message").html('<?=$PERSONAL_COLD_METER_ALERT[$lang_idx]?>');
                 var nextClass = $("#profileform #user_icon_contentbox").children().first().children().first().attr('class');
                 if ((jsonT.user.icon != "" )&& (jsonT.user.icon != "admin_avatar"))
                    while (jsonT.user.icon != nextClass){
                       nextClass = change_icon('right', $("#profileform .icon_right"));
                    }
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
                 $("#user_name").html('<?=$LOGIN[$lang_idx]?>/<?=$REGISTER[$lang_idx]?>');
                 $("#user_icon").attr('class', '');
                 toggle('loggedin');
                 toggle('notloggedin');
                 if ($("#msgDetailes")){
                 fillMessage('<img src="img/loading_white.gif" alt="loading" width="50" height="50"/>');
                $.ajax({
                    type: "POST",
                    url: "chat_service.php",
                    data: {lang:lang, from:limit, update:update},
               }).done(function(str){fillMessage(str);});
               }
            }



        });
        }
        function getMessageService(from, to, start, update, lang, category)
	{	
        localStorage.setItem("category",category); 
		if (update==1)
                    tinyMCE.triggerSave();
		var name = $('#profileform_displayname').val();
		var body = $('#new_post_ta').val();
                var mood_elm = "";
                var private = 0;
                var alert_to_sender = 0;
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
		
		if ((from == '') && 
			((searchname == '') || (searchname == null)) && 
			((name == '' ||  body == '')))
		{
			return false;
		}
                
                if ($('#check_private_msg').is(':checked')){
                    private = 1;
                    };
                 if ($('#check_alert_msg').is(':checked')){
                    alert_to_sender = 1;
                    };
		
		var idx = $('#current_post_idx').val();
                var msgDetails = document.getElementById('msgDetails');
		var limit = limit;
		if ((from != "") && (from != "undefined"))
			limit = from;
                if (typeof category === "undefined") 
                    category = "";
		if (update == 0)
		{
			body = '';
			name = '';
		}
		
		restoreTopDiv();
		
		var postData = "lang=" + lang + "&from=" + limit + "&to=" + to + "&alert=" + alert_to_sender + "&private=" + private +"&startLine=" + start + "&category=" + category + "&idx=" + idx + "&name=" + escape(encodeURI(name)) + "&searchname=" + escape(encodeURI(searchname)) + "&body=" + escape(encodeURI(body)) + "&mood=" + escape(encodeURI(mood_elm))  + "&update=" + update;
		if ($('#current_forum_update_display').val() == 'R')
                    fillMessage('<img src="img/loading.gif" alt="loading" width="50" height="50"/>');
		$('input[name="SendButton"]').attr("disabled", "disabled");
		var ajax = new Ajax();
		ajax.method = 'POST';
		ajax.setMimeType('text/html');
		ajax.postData = postData;
		ajax.setHandlerBoth(fillMessage);
		ajax.url = 'chat_service.php';
		ajax.doReq();
                
		
	}
        function getNextPage(lang, limit)
        {
            $('#current_forum_update_display').val('A');
            $('#current_forum_startline').val(parseInt($('#current_forum_startline').val())+limit);
            category = localStorage.getItem("category"); 
            getMessageService(limit, '', $('#current_forum_startline').val(), 0, lang, category);
        }
        function changeLang (lang)
        {
                var loc = document.URL;
                changeUrlLang(lang, loc);
        }
        function login_to_server(lang, limit, update)
        {
        	$("#loginform_result").html("");
                if ($("#loginform_email").val().length == 0){
                	alert('<?=$EMAIL[$lang_idx]?> <?=$EMPTY[$lang_idx]?>');
                	$("#loginform_email").focus();
                	return false;
                }
                   
                 if ($("#loginform_password").val().length == 0){
                 	alert('<?=$PASSWORD[$lang_idx]?> <?=$EMPTY[$lang_idx]?>');
                 	$("#loginform_password").focus();
                 	return false;
                 }
                   
        	$.ajax({
		  type: "POST",
		  url: "checkauth.php?action=login&lang="+lang,
		  data: { email: $("#loginform_email").val(), password: $("#loginform_password").val(), isrememberme:$("#loginform_rememberme").is(':checked') ? 1 : 0 },
                  beforeSend: function(){$(".loading").show();}
		}).done(function( jsonstr  ) {
		  try{
                     $(".loading").hide();
                     var jsonT = JSON.parse( jsonstr  );
                     if (!jsonT.user.loggedin)
                         {
                             toggle('new_post_btn');
                             if (jsonT.user.locked)
                                $("#loginform_result").text('<?=$USER_LOCKED[$lang_idx]?>');
                             else
                                $("#loginform_result").text(jsonT.user.display);
                             $("#loginform_result").addClass('high');
                         }
                       else {
                         $("#cboxClose").click();
                         $("#colorbox").hide();
                         $("#cboxOverlay").hide();
                         fillUserDetails (jsonstr );
                         toggle('loggedin');
                         toggle('notloggedin');
                            if (document.getElementById('new_post_btn')){
                                   $('#new_post_btn').attr('onclick','openNewPost('+lang+')');
                            }
                          if (document.getElementById('forum'))
							{                    
							fillMessage('<img src="img/loading.gif" alt="loading" width="50" height="50"/>');
                                                        $.ajax({
                                                            type: "POST",
                                                            url: "chat_service.php",
                                                            data: {lang:lang, from:limit, update:update},
                                                       }).done(function(str){fillMessage(str);});
                                                        
						 }
                       }
                                                         
                 }
                 catch (e) {
                     
                     alert(e);
                     
                  }
		    
		});
        }
		
        function updateprofile_to_server(lang)
        {
                 $("#profileform_result").html("");                  
                 if ($("#profileform_password").val().length == 0){
                 	alert('<?=$PASSWORD[$lang_idx]?> <?=$EMPTY[$lang_idx]?>');
                 	$("#profileform_password").focus();
                 	return false;
                 }
                 
                  if ($("#profileform_displayname").val().length == 0){
                 	alert('<?=$DISPLAY_NAME[$lang_idx]?> <?=$EMPTY[$lang_idx]?>');
                 	$("#profileform_displayname").focus();
                 	return false;
                 }
                 
                  if ($("#profileform_nicename").val().length == 0){
                 	alert('<?=$NICE_NAME[$lang_idx]?> <?=$EMPTY[$lang_idx]?>');
                 	$("#profileform_nicename").focus();
                 	return false;
                 }
                   
        	$.ajax({
		  type: "POST",
		  url: "checkauth.php?action=updateprofile&lang="+lang,
		  data: { email: $("#profileform_email").val(), 
		          password: $("#profileform_password").val(), 
		          user_display_name: $("#profileform_displayname").val(), 
		          user_nice_name:$("#profileform_nicename").val(),
                          user_icon:$("#chosen_user_icon").val(),
		          priority:$("#profileform_priority").is(':checked') ? 1 : 0,
                          personal_coldmeter:$("#profileform_personal_coldmeter").is(':checked') ? 1 : 0}
		}).done(function( msg ) {
		   if (msg.indexOf("uniq_name") > 0){
		  	$("#profileform_result").html("<div class=\"high\"><?=$DISPLAY_NAME[$lang_idx]." ".$IS_TAKEN[$lang_idx]?></div>");
		  	$("#profileform_displayname").focus();
		   }
		   else if (msg==0)
		   {
		      toggle('profileform_submit');
		      toggle('profileform_OK');
		      $("#profileform_OK").addClass("text-success");
		      
		   }
		  else
		     $("#profileform_result").html( msg );
		});
        }
        function register_to_server(lang)
        {
        	$("#registerform_result").html("");
                 if ($("#registerform_userid").val().length == 0){
                 	alert('<?=$USER_ID[$lang_idx]?> <?=$EMPTY[$lang_idx]?>');
                 	$("#registerform_userid").focus();
                 	return false;
                 }
                 if ($("#registerform_email").val().length == 0){
                 	alert('<?=$EMAIL[$lang_idx]?> <?=$EMPTY[$lang_idx]?>');
                 	$("#registerform_email").focus();
                 	return false;
                 }               
                 if ($("#registerform_password").val().length == 0){
                 	alert('<?=$PASSWORD[$lang_idx]?> <?=$EMPTY[$lang_idx]?>');
                 	$("#registerform_password").focus();
                 	return false;
                 }
                 if ($("#registerform_password_verif").val().length == 0){
                 	alert('<?=$PASSWORD_VERIFICATION[$lang_idx]?> <?=$EMPTY[$lang_idx]?>');
                 	$("#registerform_password_verif").focus();
                 	return false;
                 }
                 
                 
                  if ($("#registerform_displayname").val().length == 0){
                 	alert('<?=$DISPLAY_NAME[$lang_idx]?> <?=$EMPTY[$lang_idx]?>');
                 	$("#registerform_displayname").focus();
                 	return false;
                 }
                 
                  if ($("#registerform_nicename").val().length == 0){
                 	alert('<?=$NICE_NAME[$lang_idx]?> <?=$EMPTY[$lang_idx]?>');
                 	$("#registerform_nicename").focus();
                 	return false;
                 }
                 
                 if ($("#registerform_password").val() != $("#registerform_password_verif").val()){
                 	alert('Passwords do not match סיסמאות לא זהות');
                 	$("#registerform_password_verif").focus();
                 	return false;
                 }
                   
        	$.ajax({
		  type: "POST",
		  url: "checkauth.php?action=register&lang="+lang,
                  beforeSend: function(){$(".loading").show();},
		  data: { username:$("#registerform_userid").val(),
		  	  email: $("#registerform_email").val(), 
		          password: $("#registerform_password").val(), 
		          user_display_name: $("#registerform_displayname").val(),
                          user_icon:$("#chosen_user_icon").val(), 
		          user_nice_name:$("#registerform_nicename").val(), 
		          priority:$("#registerform_priority").is(':checked') ? 1 : 0 }
		}).done(function( msg ) {
                  $(".loading").hide();
		  if (msg.indexOf("User_login_Uniq") > 0){
		        $("#registerform_result").html("<div class=\"high\"><?=$USER_ID[$lang_idx]." ".$IS_TAKEN[$lang_idx]?></div>");
		  	$("#registerform_userid").focus();
		  }
		   else if (msg.indexOf("uniq_name") > 0){
		  	$("#registerform_result").html("<div class=\"high\"><?=$DISPLAY_NAME[$lang_idx]." ".$IS_TAKEN[$lang_idx]?></div>");
		  	$("#registerform_displayname").focus();
		  }
		  else if (msg==0){
		  	 toggle('registerform_submit');
		  	 toggle('registerform_OK');
                         toggle('registerinput');
                         $("#registerform_result").html("<?=$CHECK_EMAIL[$lang_idx]?>");
                         $("#registerform_result").addClass("text-success");
		  	 $("#registerform_OK").val("<?=$CLOSE[$lang_idx]?>");
		  }
		  else
		      $("#registerform_result").html( msg );
		    
		  
		     
		});
        }
        function passforgot_to_server(lang)
        {
                if ($("#passforgotform_email").val().length == 0){
                	alert('<?=$EMAIL[$lang_idx]?> <?=$EMPTY[$lang_idx]?>');
                	$("#passforgotform_email").focus();
                	return false;
                }
                $("#passforgotform_result").html("");
                 
                   
        	$.ajax({
		  type: "POST",
		  url: "checkauth.php?action=forgotpass&lang="+lang,
		  data: { email: $("#passforgotform_email").val() }
		}).done(function( msg ) {
		    toggle('passforgotform_OK');
		    toggle('passforgotform_submit');
		    $("#passforgotform_result").text(msg );
		    $("#passforgotform_result").addClass("indexlow");
		});
        }
       
	function getMoodTitle(imagename)
{
	
	var title = "";
	if (imagename.indexOf('hot') > 0)
		title = "<?=$IMHOT[$lang_idx]?>";
	else if (imagename.indexOf('kiss')> 0)
		title = "<?=$KISS[$lang_idx]?>";
	else if (imagename.indexOf('confuse')> 0)
		title = "<?=$CONFUSE[$lang_idx]?>";
	else if (imagename.indexOf('amazed')> 0)
		title = "<?=$AMAZED[$lang_idx]?>";
	else if (imagename.indexOf('cold')> 0)
		title = "<?=$IMCOLD[$lang_idx]?>";
	else if (imagename.indexOf('angry')> 0)
		title = "<?=$ANGRY[$lang_idx]?>";	
	else if (imagename.indexOf('tire')> 0)
		title = "<?=$TIRE[$lang_idx]?>";
	else if (imagename.indexOf('smiley')> 0)
		title = "<?=$HAPPY[$lang_idx]?>";
	else if (imagename.indexOf('embarrassed')> 0)
		title = "<?=$EMBARRASED[$lang_idx]?>";
	else if (imagename.indexOf('wink')> 0)
		title = "<?=$WINK[$lang_idx]?>";
	else if (imagename.indexOf('sad')> 0)
		title = "<?=$SAD[$lang_idx]?>";
	else if (imagename.indexOf('satisfied')> 0)
		title = "<?=$SATISFIED[$lang_idx]?>";
	else if (imagename.indexOf('doubt')> 0)
		title = "<?=$DOUBT[$lang_idx]?>";
	else if (imagename.indexOf('cool')> 0)
		title = "<?=$COOL[$lang_idx]?>";
	else if (imagename.indexOf('curious')> 0)
		title = "<?=$CURIOUS[$lang_idx]?>";
	else if (imagename.indexOf('digging')> 0)
		title = "<?=$DIGGING[$lang_idx]?>";
	else if (imagename.indexOf('pudency')> 0)
		title = "<?=$PUDENCY[$lang_idx]?>";
	else if (imagename.indexOf('hell')> 0)
		title = "<?=$HELL[$lang_idx]?>";
	return title;
}
function updateLikes(event, idx, command)
{
   event.preventDefault();
   $.ajax({
        type: "POST",
        url: "forecastlikes_service.php",
        data: {idx:idx,command:command},
   }).done(function(str){if (command == "like")  fillLikes(str);
                            else fillDislikes(str)});
}
function fillDislikes(jsonstr)
{
    var jsonD = JSON.parse( jsonstr  );
    $("#divlikes" + jsonD.dislikes[0].idx + " .dislikes").html(jsonD.dislikes[0].count);
}
function fillLikes(jsonstr)
{
    var jsonL = JSON.parse( jsonstr  );
    $("#divlikes" + jsonL.likes[0].idx + " .likes").html(jsonL.likes[0].count);
}
    function fillcoldmeter(str)
    {
            var cur_feel_link=document.getElementById('current_feeling_link');
            var tickText=document.createElement('text');
            tickText.innerHTML=str;
            cur_feel_link.replaceChild(tickText,cur_feel_link.firstChild);
            var gendertype=document.getElementById('gendertype');

            if (gendertype)
            {
                    var gendercookie = getCookie('gender');
                    var gender_m = '<?=$MALE[$lang_idx]?>';
                    var gender_f = '<?=$FEMALE[$lang_idx]?>';
                    var gender_none = '<?=$NOR_MALE_NOR_FEMALE[$lang_idx]?>';
                    var gendertodisplay = '';
                    if (gendercookie == 'm')
                            gendertodisplay = gender_m;
                    else if (gendercookie == 'f')
                            gendertodisplay = gender_f;
                    else
                            gendertodisplay = gender_none;
                    var tickText=document.createElement('text');
                    tickText.innerHTML=gendertodisplay;
                    //gendertype.replaceChild(tickText,gendertype.firstChild);
                    gendertype.innerHTML=gendertodisplay;
            }
			if ($('#statusline').length){
			$('#statusline, #statuslinestart').css('visibility', 'visible');
			$('#what_is_h, #what_is_h_start').show();
            $('#current_feeling_link_start').html(cur_feel_link.innerHTML);
			}
    }
     function expand(idx)
    {
        $("#" + idx + " .chatmainbody").hide();
        $("#" + idx + " .alternatebody").show();
        var container = document.querySelector('#msgDetails');
        var msnry = new Masonry( container, {
        itemSelector: '.white_box2',
        isOriginLeft: false,
        columnWidth: '#msgDetails .white_box2',
        gutter: 8
        });
        
    }
    function contract(idx)
    {
        $("#" + idx + " .chatmainbody").show();
        $("#" + idx + " .alternatebody").hide();
         var container = document.querySelector('#msgDetails');
        var msnry = new Masonry( container, {
        itemSelector: '.white_box2',    
        isOriginLeft: false,
        columnWidth: '#msgDetails .white_box2',
        gutter: 8
        });
    }
    function redirect(url)
   {
       top.location.href = url;
   }
   function showAllCircles()
   {
        $("#CloseCircles").show();
        $("#latestnow").show();
        $("#latesttemp").show();
        $("#latesttemp2").show();
        $("#latesttemp3").show();
        $("#latesthumidity").show();
        $("#latestpressure").show();
        $("#latestwind").show();
        $("#latestrain").show();
        $("#latestradiation").show();
        $("#latestuv").show();
        $("#latestairq").show();
        $(".inparamdiv").css({"background": "rgba(255,255,255,0.9)"});
        $(".inparamdiv").css({"position": "absolute"});
        $("#now_stuff").css({"margin-top": "260px"});
        $("#cover_clouds-4").hide();
        $("#logo").css({"z-index": "1"});
        $(".info_btns").hide();
        $(".main_nav").hide();
        var mq = window.matchMedia( "(min-width: 1400px)" );
        if (mq.matches) {
         
          $("#latestnow").animate({
    marginLeft: "-600px",
    marginTop: "-100px"
        }, 1500 );
        
        $("#latesttemp").animate({
    marginLeft: "-400px",
    marginTop: "-100px"
        }, 1500 );
        
        $("#latesttemp2").animate({
    marginLeft: "-200px",
    marginTop: "-100px"
        }, 1500 );
        $("#latesttemp3").animate({
    marginLeft: "600px",
    marginTop: "720px"
        }, 1500 );
        
        $("#latesthumidity").animate({
    marginLeft: "0px",
    marginTop: "-100px"
        }, 1500 );
        
        $("#latestpressure").animate({
    marginLeft: "200px",
    marginTop: "-100px"
        }, 1500 );
        
        $("#latestwind").animate({
    marginLeft: "400px",
    marginTop: "-100px"
        }, 1500 );
        
        $("#latestrain").animate({
    marginLeft: "600px",
    marginTop: "-100px"
        }, 1500 );
        
        $("#latestradiation").animate({
    marginLeft: "600px",
    marginTop: "100px"
        }, 1500 );
        
        $("#latestuv").animate({
    marginLeft: "600px",
    marginTop: "300px"
        }, 1500 );
        
        $("#latestairq").animate({
    marginLeft: "600px",
    marginTop: "500px"
        }, 1500 );
        }
        //small screen
        else{
         $("#now_stuff").animate({
    marginLeft: "-60px",
    marginTop: "65px"
        }, 1500 );
        $("#latestnow").animate({
    marginLeft: "-400px",
    marginTop: "-100px"
        }, 1500 );
        
        $("#latesttemp").animate({
    marginLeft: "-200px",
    marginTop: "-100px"
        }, 1500 );
        
        $("#latesttemp2").animate({
    marginLeft: "-0px",
    marginTop: "-100px"
        }, 1500 );
        
        $("#latesthumidity").animate({
    marginLeft: "200px",
    marginTop: "-100px"
        }, 1500 );
        
        $("#latestpressure").animate({
    marginLeft: "400px",
    marginTop: "-100px"
        }, 1500 );
        
        $("#latestwind").animate({
    marginLeft: "-400px",
    marginTop: "100px"
        }, 1500 );
        
        $("#latestrain").animate({
    marginLeft: "-200px",
    marginTop: "100px"
        }, 1500 );
        
        $("#latestradiation").animate({
    marginLeft: "0px",
    marginTop: "100px"
        }, 1500 );
        
        $("#latestuv").animate({
    marginLeft: "200px",
    marginTop: "100px"
        }, 1500 );
        
        $("#latestairq").animate({
    marginLeft: "400px",
    marginTop: "100px"
        }, 1500 );
        }
         
   }
   function closeAllCircles()
   {
    $("#latestnow, #latestairq, #latestuv, #latestradiation, #latestrain, #latestwind, #latestpressure, #latesthumidity, #latesttemp2, #latesttemp, #latesttemp3, #latestnow").animate({
    marginLeft: "0",
    marginTop: "0"
        }, 1500 , function() {
            $(".inparamdiv").css({"background": "rgba(255,255,255,0.6)"});
        $(".inparamdiv").css({"position": "relative"});
        $("#now_stuff").css({"margin-top": "39px"});
        $("#cover_clouds-4").show();
        $("#logo").css({"z-index": "9999"});
        $(".info_btns").show();
        $(".main_nav").show();
        $("#latestnow").show();
        $("#latesttemp").hide();
        $("#latesttemp2").hide();
        $("#latesttemp3").hide();
        $("#latesthumidity").hide();
        $("#latestpressure").hide();
        $("#latestwind").hide();
        $("#latestrain").hide();
        $("#latestradiation").hide();
        $("#latestuv").hide();
        $("#latestairq").hide();
        $("#CloseCircles").hide();
  }); 
       
   }
  
function startup(lang, from, update)
     {
            
       $("#current_forum_filter").val($("#forum_filter").children().first().attr('class'));
       $("#current_forum_filter").attr('data-key',$("#forum_filter").children().first().attr('data-key'));
       var cur_feel_link=document.getElementById('current_feeling_link');
       if (typeof coldmeter_size == 'undefined') 
          coldmeter_size = 14;
       if (cur_feel_link)
       {
               var ajax = new Ajax();
               ajax.setHandlerBoth(fillcoldmeter);
               ajax.url = 'coldmeter_service.php?lang='+lang + '&coldmetersize=' + coldmeter_size;
               ajax.doReq();
               
              
                
       }
        
                $.ajax({
                  type: "GET",
                  url: "checkauth.php?action=getuser&lang=" + lang +"&guid=<?=$_GET['guid']?>"
                }).done(function( jsonstr ) {
                  try{

                     var jsonT = JSON.parse( jsonstr  );
                     if (jsonT.user.approved == 1)
                        isUserAdApproved = true;
                     if (!jsonT.user.loggedin)
                         {
                            toggle('notloggedin');
                            $("#user_name").html('<?=$LOGIN[$lang_idx]?>/<?=$REGISTER[$lang_idx]?>');
                            $("#chosen_user_icon").val($("#user_icon_contentbox").children().first().children().first().attr('class'));
                            if (jsonT.user.locked)
                                $("#user_name").html('<?=$USER_LOCKED[$lang_idx]?>');
                         }
                       else {
                         toggle('loggedin'); 
                         fillUserDetails (jsonstr );
                        if (document.getElementById('new_post_btn')){
                               $('#new_post_btn').attr('onclick','openNewPost('+lang+')');
                        }
                       }
                    if (document.getElementById('forum'))
                    {
                    fillMessage('<img src="img/loading.gif" alt="loading" width="50" height="50"/>');
                    $.ajax({
                        type: "POST",
                        url: "chat_service.php",
                        data: {lang:lang, from:from, update:update},
                   }).done(function(str){fillMessage(str);});
                   }
                    

                }
                catch (e) {
                    alert("error:" + e);

                 }
                });
                attachEnter();
                 
     }
     function tinyExecCommand(editor_id, elm, command, user_interface, value) {
        var editor = tinyMCE.get(editor_id);
        switch (command.toLowerCase()) {
            case "createlink":
                $(editor.getBody()).find('a').attr('target', '_blank');
                break;
        }
    }
     function initTinyMCE(lang)
     {
		var dir = 'rtl';
		if (lang!=1)
			dir='ltr';
        //if (tinyMCE.getInstanceById('new_post_ta'))
        //    tinymce.show();
        //else
            tinymce.init({selector:'textarea',menubar : false, height : "80px", theme: "modern", skin: 'light', forced_root_block : false, directionality : dir, execcommand_callback: "tinyExecCommand", valid_elements: "*[*]", extended_valid_elements : 'iframe[title|class|type|width|height|src|frameborder|allowFullScreen]', content_css : "css/main.php?lang=<?=$lang_idx?>", language: 'he_IL', statusbar: false, toolbar: "emoticons | styleselect | bullist numlist | link image | bold italic | preview | code",plugins : 'autolink advlist link image emoticons media preview code advcode table save advhr '});
            
            
            
     }
     function forummonth_goto_byselect(sel)
     {
        var index = sel.selectedIndex;
        if (sel.options[index].value != '') {
        var arr = sel.options[index].value.split("/");
        var month = arr[0]; var year = arr[1]; 
         getMessageService('01' + month.toString() + year.toString(), '31' + month.toString() + year.toString(), 0, 0,  <?=$lang_idx?>);
        }
        else {}
     }
     
     function getWindInfo(windspeed){
        var wind_class = "";
        var wind_img = "";
        if (windspeed > 30){
           wind_class="high_wind";
           wind_img = "wind2.svg";
       }

      else if (windspeed > 20){
          wind_class="high_wind";
          wind_img = "wind2.svg";
       }

      else if (windspeed > 10){
          wind_class="moderate_wind";
          wind_img = "wind1.svg";
       }
     else{
          wind_class="light_wind";
          wind_img = "wind0.svg";
       }
       return [wind_class, wind_img];
   }
        var customTooltips = function(tooltip) {
      // Tooltip Element
      var tooltipEl = $('#chartjs-tooltip');
      if (!tooltipEl[0]) {
        $('body').append('<div id="chartjs-tooltip"></div>');
        tooltipEl = $('#chartjs-tooltip');
      }
      // Hide if no tooltip
      if (!tooltip.opacity) {
        change_circle('now_line', 'latestnow');
        tooltipEl.css({
          opacity: 0
        });
        $('.chartjs-wrap canvas')
          .each(function(index, el) {
            $(el).css('cursor', 'default');
          });
        return;
      }
      
      //$(this._chart.canvas).css('cursor', 'pointer');
      // Set caret Position
      tooltipEl.removeClass('above below no-transform');
      if (tooltip.yAlign) {
        tooltipEl.addClass(tooltip.yAlign);
      } else {
        tooltipEl.addClass('no-transform');
      }
      // Set Text
      if (tooltip.body) {
          var theBody = "";
          /*tooltip.body.forEach(function(p) {
              theBody = theBody + "<br />" + p.lines[0];
          });*/
        var innerHtml = [
          (tooltip.beforeTitle || []).join('\n'), (tooltip.title || []).join('\n'), (tooltip.afterTitle || []).join('\n'), (tooltip.beforeBody || []).join('\n'), theBody, (tooltip.afterBody || []).join('\n'), (tooltip.beforeFooter || [])
          .join('\n'), (tooltip.footer || []).join('\n'), (tooltip.afterFooter || []).join('\n')
        ];
        tooltipEl.html(innerHtml.join('\n'));
      }
      else
      {
        return;
      }
      // Find Y Location on page
      var top = 0;
      if (tooltip.yAlign) {
        if (tooltip.yAlign == 'above') {
          top = tooltip.y - tooltip.caretSize - tooltip.caretPadding;
        } else {
          top = tooltip.y + tooltip.caretSize + tooltip.caretPadding;
        }
      }
      
       var position = $(this._chart.canvas)[0].getBoundingClientRect();
	   var tooltipwidth = 200;
	   var tooltipx = tooltip.x + (position.width/3);
	   var tooltipleft = position.left + tooltipx;
	   
           if (tooltip.x < -4.5*tooltipwidth){
            tooltipleft = tooltip.x + (6.5*tooltipwidth);
            console.log("1. tooltipleft:" + tooltipleft + " positionwidth:" + position.width + " tooltipx:" + tooltip.x); 
           }
			          
            else if (tooltip.x < -2*tooltipwidth){
                tooltipleft = tooltip.x + (5.8*tooltipwidth);
                console.log("2. tooltipleft:" + tooltipleft + " positionwidth:" + position.width + " tooltipx:" + tooltip.x); 
            }
            else if (tooltip.x < -tooltipwidth){
                tooltipleft = tooltip.x + (6.1*tooltipwidth);	
                console.log("3. tooltipleft:" + tooltipleft + " positionwidth:" + position.width + " tooltipx:" + tooltip.x); 
            }
			
	    	
			
		else if (tooltip.x < -(tooltipwidth/3)){
            tooltipleft = tooltip.x + (2*tooltipwidth);	
            console.log("4. tooltipleft:" + tooltipleft + " positionwidth:" + position.width + " tooltipx:" + tooltip.x); 
        }
			
       
	    //else if (tooltip.x < tooltipwidth)
		//    tooltipleft = tooltip.x + tooltipwidth;
		if (tooltip.x > (position.width - (tooltipwidth/2))){
            tooltipleft = tooltip.x - tooltipwidth;
            console.log("5. tooltipleft:" + tooltipleft + " positionwidth:" + position.width + " tooltipx:" + tooltip.x); 
        }
		 
        
        tooltipleft = 150;

      // Display, position, and set styles for font
      change_circle('now_line', 'chartjs-tooltip');
        tooltipEl.css({
          opacity: 1,
          width:tooltipwidth + 'px',
          //height:140 + 'px',
          //top:100+'px',
          //left:tooltipleft + 'px',
          fontFamily: tooltip._fontFamily,
          fontSize: tooltip.fontSize,
          fontStyle: tooltip._fontStyle,
          margin:'0 auto',
          marginTop:-102,
          padding: '4px 11px 14px',
        });
        
    };
    var size = 22;
    var cv = document.getElementById("graphForcastContainer"); 
    if (cv !== null){
        var ctx = cv.getContext("2d");
        /*** Gradient 
    var gradient = ctx.createLinearGradient(0, 0, 0, 200);
        gradient.addColorStop(0, 'rgba(247,148,30,0)');
        gradient.addColorStop(0.4, 'rgba(247,148,30,0.05)');      
        gradient.addColorStop(1, 'rgba(247,148,30,0.4)');
    var gradient2 = ctx.createLinearGradient(0, 0, 0, 200);
        gradient2.addColorStop(0, 'rgba(247,148,30,0)');
        gradient2.addColorStop(0.45, 'rgba(247,148,30,0.05)');      
        gradient2.addColorStop(1, 'rgba(247,148,30,0.5)');
    ************/
    }
    
    
    var barChartData = {
            labels: [<?
            function shouldShowWeatherIcon($hour_f){
                return true;
                global $sigforecastHour;
                if (count($sigforecastHour) > 2)
                    $intervalhours = 6;
                else if (count($sigforecastHour) > 1)
                    $intervalhours = 4;
                else
                    $intervalhours = 3;
                if (($hour_f['plusminus'] > 0)||($hour_f['time'] % $intervalhours == 0))
                    return true;
                return false;
            }
            $forecastHour = $mem->get("forecasthour");
			if (!$forecastHour) {$forecastHour = array();}
            $last_key = end(array_keys($forecastHour));
        foreach ($forecastHour as $key => &$hour_f) {
            if (($hour_f['currentDateTime'] - time() > 0)){
                echo "[\" " .replaceDays(date("D ", $hour_f['currentDateTime']))." \",\" ".date("j/m", $hour_f['currentDateTime']) . "\",\" " . $hour_f['time'] . ":00";
                if ($hour_f['plusminus'] > 0)
                    echo "\",\" &plusmn; ".$hour_f['plusminus'] . "\",\"".$hour_f['temp'];
                echo "\"]";
                if ($key != $last_key) {
                    echo ",";
                }
            }
            
        }
        ?>],
            datasets: [{
                    label: "<?= $TEMP[$lang_idx] ?>",
                    type: 'bar',
                   data: [<? $max_temp = -10; $min_temp = 110;
        foreach ($forecastHour as $key => &$hour_f) {
            if (($hour_f['currentDateTime'] - time() > 0)){
                echo getCorF($hour_f['temp']); if ($hour_f['temp'] > $max_temp) $max_temp = $hour_f['temp']; if ($hour_f['temp'] < $min_temp) $min_temp = $hour_f['temp'];
                if ($key != $last_key) 
                    echo ",";
            }
            
            
        }
        ?>],
                    fill: true,
                    backgroundColor: [<? 

                    $on = "['rgba(247,148,30,0.6)', 'rgba(247,148,30,0)']";
                    $off = "['rgba(247,148,30,0.5)', 'rgba(247,148,30,0)']";
                        foreach ($forecastHour as $key => &$hour_f) {
                            $index++;
                    if (($hour_f['currentDateTime'] - time() > 0)){
                    if  ($index % 2 == 0) echo $off; else echo $on;
                    if ($key != $last_key) {
                    echo ",";
                    }
                    }

                    }
                    ?>],
                    borderColor: 'rgba(255,101,80,0.2)',
                    hoverBackgroundColor: 'rgba(255,101,80,0)',
                    hoverBorderColor: 'rgba(255,101,80,0)',
                    yAxisID: 'y-axis-1'
            }, {
                label: "<?= $WIND[$lang_idx] ?>",
                    type:'line',
                    data: [<?
        foreach ($forecastHour as $key => &$hour_f) {
            if (($hour_f['currentDateTime'] - time() > 0)){
                    echo "\"" . getWindInfo($hour_f['wind'], $lang_idx)['windtitle'] . "\"";
                //echo $hour_f['wind'];
                if ($key != $last_key) {
                    echo ",";
                }
            }

            
        }
        ?>],
                    fill: false,
                    backgroundColor: 'rgba(255,0,0,0)',
                    borderColor: 'rgba(255,0,0,0)',
                    hoverBackgroundColor: 'rgba(255,0,0,0)',
                    hoverBorderColor: 'rgba(255,0,0,0)',    
                    yAxisID: 'y-axis-2',
                    
            } , {
                label: "<?= $CHANCE_OF[$lang_idx]."".$RAIN[$lang_idx] ?>",
                    type:'line',
                    hidden:true,
                    data: [<?
        foreach ($forecastHour as $key => &$hour_f) {
            if (($hour_f['currentDateTime'] - time() > 0)){
                    echo $hour_f['rain'];
                if ($key != $last_key) {
                    echo ",";
                }
            }
            
        }
        ?>],
                    fill: false,
                    backgroundColor: 'rgba(255,255,255,0.2)',
                    borderColor: 'rgba(255,255,255,0.2)',
                    hoverBackgroundColor: 'rgba(255,255,255,0.2)',
                    hoverBorderColor: 'rgba(255,255,255,0.2)',
                    yAxisID: 'y-axis-3'
            }, {
                label: "",
                    type:'bar',
                    data: [<?
        foreach ($forecastHour as $key => &$hour_f) {
            if (($hour_f['currentDateTime'] - time() > 0)){
                echo "\"" . str_replace("'", "", $hour_f['title'][$lang_idx]) . "\"";
                if ($key != $last_key) {
                    echo ",";
                }
            }
            
        }
        ?>],
                    fill: false,
                    backgroundColor: 'rgba(255,0,0,0)',
                    borderColor: 'rgba(255,0,0,0)',
                    hoverBackgroundColor: 'rgba(255,0,0,0)',
                    hoverBorderColor: 'rgba(255,0,0,0)',
                    yAxisID: 'y-axis-4'
            }, {
                label: "",
                    type:'bar',
                    data: [<?
        foreach ($forecastHour as $key => &$hour_f) {
            if (($hour_f['currentDateTime'] - time() > 0)){
                echo "\"" . $hour_f['icon'] . "\"";
                if ($key != $last_key) {
                    echo ",";
                }
            }
            
        }
        ?>],
                    fill: false,
                     backgroundColor: 'rgba(255,0,0,0)',
                    borderColor: 'rgba(255,0,0,0)',
                    hoverBackgroundColor: 'rgba(255,0,0,0)',
                    hoverBorderColor: 'rgba(255,0,0,0)',
            }, {
                label: "",
                    type:'bar',
                    data: [<?
        foreach ($forecastHour as $key => &$hour_f) {
            if (($hour_f['currentDateTime'] - time() > 0)){
                echo "\"" . $hour_f['cloth'] . "\"";
                if ($key != $last_key) {
                    echo ",";
                }
            }
            
        }
        ?>],
                    fill: false,
                    backgroundColor: 'rgba(255,0,0,0)',
                    borderColor: 'rgba(255,0,0,0)',
                    hoverBackgroundColor: 'rgba(255,0,0,0)',
                    hoverBorderColor: 'rgba(255,0,0,0)',
            }, {
                label: "<?= $HUMIDITY[$lang_idx] ?>",
                    type:'line',
                    hidden:true,
                    data: [<?
        foreach ($forecastHour as $key => &$hour_f) {
            if (($hour_f['currentDateTime'] - time() > 0)){
                echo  $hour_f['humidity'];
                if ($key != $last_key) {
                    echo ",";
                }
            }
           
        }
        ?>],
                    fill: true,
                    borderColor: 'rgba(139,127,254,0.2)',
                    backgroundColor: 'rgba(139,127,254,0.2)',
                    pointBorderColor: 'rgba(139,127,254,0.2)',
                    pointBackgroundColor: 'rgba(139,127,254,0.2)',
                    pointRadius:1,
                    pointHitRadius:12,
                    yAxisID: 'y-axis-5',
                    showLine:true
            }, {
                label: "",
                    type:'bar',
                    data: [<? $index = 0;
        foreach ($forecastHour as $key => &$hour_f) {
            $index++;
            if (($hour_f['currentDateTime'] - time() > 0)){
                if  ($index % 2 == 0) echo "100"; else echo "100";
                if ($key != $last_key) {
                    echo ",";
                }
            }

                }
        ?>],
                    fill: false,
                    hoverBackgroundColor: 'rgba(255,255,255,0.7)',
                    hoverBorderColor: 'rgba(255,255,255,1)',
                    backgroundColor: [<? 

                        $selected  = "'rgba(255,255,255,0.8)'";
                        $on = "'rgba(255,255,255,0)'";
                        $off = "'rgba(255,255,255,0)'";
                            foreach ($forecastHour as $key => &$hour_f) {
                                $index++;
            if (($hour_f['currentDateTime'] - time() > 0)){
                if  ($index % 2 == 0) echo $off; else echo $on;
                if ($key != $last_key) {
                    echo ",";
                }
            }

                }
                    ?>],
                    yAxisID: 'y-axis-6'
            }]
        };
         <? 
		$imgi = 1;
                $imgw = 1;
                $sigforecastHour = $mem->get("sigforecastHour");
                $sigWindHour = $mem->get("sigWindHour");
                foreach ($forecastHour as $key => &$hour_f) {
                    if (($hour_f['currentDateTime'] - time() > 0)){
                        if (shouldShowWeatherIcon($hour_f)){
                            echo "var img".$imgi." = new Image();";
                            echo "img".$imgi.".src =\"images/icons/day/".$hour_f['icon']."\";";
                            $imgi++;
                        }
                    }

                    
                }
                echo "var images = [";
                for ($i = 1;$i <= $imgi-1;$i++){
                    echo "img".$i;
                    if ($i < $imgi-1)
                        echo ", ";
                }
                echo "];";
                
                foreach ($forecastHour as $key => &$hour_f) {
                    if (($hour_f['currentDateTime'] - time() > 0)){
                        if ($prev_wind_img != getWindInfo($hour_f['wind'], $lang_idx)['wind_img']){
                            echo "var imgw".$imgw." = new Image();";
                            echo "imgw".$imgw.".src =\"images/".getWindInfo($hour_f['wind'], $lang_idx)['wind_img']."\";";
                            $imgw++;
                       }
                        $prev_wind_img = getWindInfo($hour_f['wind'], $lang_idx)['wind_img'];
                    }
                    
                }
                echo "var windimages = [";
                for ($i = 1;$i <= $imgw-1;$i++){
                    echo "imgw".$i;
                    if ($i < $imgw-1)
                        echo ", ";
                }
                echo "];";
             ?>
            
            img<?=$imgi-1?>.onload = function() {
            var originalBarDraw = Chart.controllers.bar.prototype.draw;
            Chart.helpers.extend(Chart.controllers.bar.prototype, {
                name: 'barWithImage',
                draw: function() {
                        originalBarDraw.apply(this, arguments);
                        var chart = this.chart;
                        var ctx = chart.chart.ctx;
                        var xaxis = chart.scales['x-axis-0'];
                        var yaxis = chart.scales['y-axis-1'];
                        var imgi = 0;var imgw = 0;
                        var offset = 2;
                        [
                            <? $y_image = getCorF($max_temp);
                            $forecastHour = $mem->get("forecasthour");
                            $id = 0;
                            foreach ($forecastHour as $key => &$hour_f) {
                                
                                if (($hour_f['currentDateTime'] - time() > 0)){
                                    
                                    if (shouldShowWeatherIcon($hour_f)){
                                        echo "{ x: ".(($id)).", y: ".(getCorF($hour_f['temp'])+ 2.8)."}";
                                        if ($hour_f != end($forecastHour))
                                            echo ",";
                                    }
                                    $id++;
                                }
                            
                            }
                            ?>
                          
                        ].forEach(function(p) {
                          ctx.drawImage(images[imgi], xaxis.getPixelForValue(undefined,p.x) - size/2, yaxis.getPixelForValue(p.y) - size/3, size, size);
                          imgi++;
                        });
                        try{
                        [
                            <? 
                            $sigWindHour = $mem->get("sigWindHour");
                            foreach ($sigWindHour as $hour_f){
                                if (getCorF($hour_f['temp']) == getCorF($min_temp)) $y_image = getCorF($hour_f['temp']) + 5.5; else $y_image = getCorF($hour_f['temp']) - 1;
                                echo "{ x: ".(($hour_f['id'])).", y: ".$y_image."}";
                                if ($hour_f != end($sigWindHour))
                                    echo ",";
                            }
                            ?>
                          
                        ].forEach(function(p) {
                          ctx.drawImage(windimages[imgw], xaxis.getPixelForValue(undefined,p.x) -  size/2, yaxis.getPixelForValue(p.y) - size/3, size, size);
                          imgw++;
                        });} catch(e){}
                        ctx.textAlign = "center";
                        ctx.textBaseline = "bottom";
                        var prev_value;
                        var prev_index;
                        var offset_y;
                        this.chart.config.data.datasets.forEach(function (dataset) {
                             dataset._meta[0].data.forEach(function(p) {
                            if (p._datasetIndex === 0)
                            {
                                    ctx.fillStyle = "#fff";//"#6B89A1"
                                    var current = p._chart.config.data.datasets[p._datasetIndex].data[p._index];
                                    var xoffset = 0;
                                    if (current < prev_value)
                                        xoffset = 0;
                                    //if (current !== prev_value)
                                        ctx.font="11.5px Arial";
                                        ctx.fillText(current + "°", p._model.x - xoffset, yaxis.getPixelForValue(parseInt(p._chart.config.data.datasets[0].data[p._index]) + 0.5));
                                    prev_value = p._chart.config.data.datasets[p._datasetIndex].data[p._index];
                            }
                            
                            if (p._datasetIndex === 2)
                            {
                                    ctx.fillStyle = "#fff";//"#668bb9"
                                    var current = p._chart.config.data.datasets[p._datasetIndex].data[p._index];
                                   var offset_y = 3.5;
                                        ctx.font="11px";
                                        if (current > 0)
                                        ctx.fillText(current + "%", p._model.x , yaxis.getPixelForValue(parseInt(p._chart.config.data.datasets[0].data[p._index]) + offset_y));
                                   
                            }
                            if (p._datasetIndex === 6)
                            {
                                    ctx.fillStyle = "#fff";//"#668bb9"
                                    var current = p._chart.config.data.datasets[p._datasetIndex].data[p._index];
                                   var offset_y = 3.5;
                                        ctx.font="11px";
                                       ctx.fillText(current + "%", p._model.x , yaxis.getPixelForValue(parseInt(p._chart.config.data.datasets[p._datasetIndex].data[p._index]) + offset_y));
                                   
                            }
                            if ((p._chart.config.data.labels[p._index].length > 3) && (p._datasetIndex === 3)){
                                    if ((prev_index >= p._index - 2)&&(p._index > 0))
                                        offset_y = 1;
                                    else
                                        offset_y = 1;
                                    var xlabel = p._chart.config.data.labels[p._index][2] + "" + p._chart.config.data.labels[p._index][3].replace(" &plusmn;", ""+String.fromCharCode(177));
				                    ctx.font="9px Arial"; 
                                    ctx.fillStyle = "#000";
                                    ctx.fillText(xlabel, p._model.x, yaxis.getPixelForValue(parseInt(p._chart.config.data.labels[p._index][4])  - offset_y));
                                    prev_index = p._index;
				}
                                
                             });
                        }) 
                    
                }
            });
            if (cv){
            
            ctx.canvas.width = 1600;
            ctx.canvas.height = 205;
            var prev_active_index;
            // Disable automatic style injection
            Chart.platform.disableCSSInjection = true;
            Chart.pluginService.register({
                beforeRender: function(chart, options) {
                        // We store the temp dataset
                        var dataset = chart.config.data.datasets[0];
                        var meta = chart.getDatasetMeta(0);
                        // For every data in this dataset
                        for (var j = 0; j < dataset.data.length; j++) {
                            
                            // We store the data model (graph information)
                            var model = meta.data[j]._model;

                            // We use the model to get the left & right borders X position 
                            // and to create the gradient
                            var start = model.x,
                                end = model.x + model.width,    
                                height = model.y,
                                gradient = ctx.createLinearGradient(0, 200, 0, height);
                               
                            // The colors of the gradient that were defined in the data
                            gradient.addColorStop(0, dataset.backgroundColor[j][0]);
                            gradient.addColorStop(1, dataset.backgroundColor[j][1]);
                            //gradient.addColorStop(0, 'red');
                            //gradient.addColorStop(1, 'white');
							//console.log("data:" + j + " height:" + height + " start:" + start + " end:" + end);
                            // We set this new color to the data background
                            model.backgroundColor = gradient;
                        }
                    
                }
            });
            var mybarChart = new Chart(ctx, {
                type: 'bar',
                data: barChartData,
                	
                options: {
                    responsive:false,
                    maintainAspectRatio: false,
                    tooltipEvents: ["mousemove", "touchstart", "touchmove", "click"],
                    animation: false,
                    chartArea: {
                        backgroundColor: 'rgba(251, 251, 251, 0.3)'
                    },
                    legendCallback: function(chart) {
                        var text = [];
                        text.push('<ul>');
                        for (var i=0; i<chart.data.datasets.length; i++) {
                        console.log(chart.data.datasets[i]); // see what's inside the obj.
                        if (i!=1){
                        text.push('<li>');
                        text.push('<span id="legend' + i +'" style="" onclick="updateDataset(event, chart, ' + '\'' + i + '\'' + ',\'' + chart.data.datasets[i].label + '\')">' + chart.data.datasets[i].label + '</span>');
                        text.push('</li>');
                        }
                        }
                        text.push('</ul>');
                        return text.join("");
                    },
                    onClick: function(e){
                    var selected = <?=$selected?>;
                    var zebra_off = <?=$off?>;
                    var zebra_on = <?=$on?>;
                    var element = this.getElementAtEvent(e);
                    if(element.length > 0){
                        
                        /*var current = element[0]._chart.controller.config.data.datasets[7]._meta[0].data[element[0]._index]._model.backgroundColor;
                        if (current == selected)
                            {
                                if (element[0]._index % 2 == 0)
                                element[0]._chart.controller.config.data.datasets[7]._meta[0].data[element[0]._index]._model.backgroundColor = zebra_on;
                                else
                                element[0]._chart.controller.config.data.datasets[7]._meta[0].data[element[0]._index]._model.backgroundColor = zebra_off;
                            }
                            else{
                                element[0]._chart.controller.config.data.datasets[7]._meta[0].data[element[0]._index]._model.backgroundColor = selected;
                                if (prev_active_index != null)
                                if (prev_active_index % 2 == 0)
                                    element[0]._chart.controller.config.data.datasets[7]._meta[0].data[prev_active_index]._model.backgroundColor = zebra_on;
                                else
                                    element[0]._chart.controller.config.data.datasets[7]._meta[0].data[prev_active_index]._model.backgroundColor = zebra_off; 
                            }*/
                            
                        prev_active_index = element[0]._index;
                        //mybarChart.render(0,true);
                        
                    }
                    },
                    layout: {
                        padding: {
                            left: 0,
                            right: 0,
                            top: 0,
                            bottom: 0
                        }
                    },     
               title: {
                    display: false
                    } ,
               legend: {
                   display:true,
                   position:'bottom',
                   fullWidth:false,
                   
                   labels: {
                        fontColor: '#000',
                        fontFamily: 'Alef',
                        boxWidth:10,
                        fontSize:10,
                        padding:5
                    }
               },
                hover:{
                     mode:'x',
                },
                
               tooltips: {
					mode:'single',
                    enabled: false,
                    custom: customTooltips,
                    callbacks: {
                        
                        footer: function(tooltipItems, data) {
                             
                            //tooltipItems[0].index
                            //data.datasets[0].data[tooltipItems[0].index] + '<br />' +
                        return '<br />' +  data.datasets[0].data[tooltipItems[0].index] + '<?=$_GET['temp_unit'];?><br />' 
                                             + data.datasets[1].data[tooltipItems[0].index]   
                                            + '<!--<div title=\"""\" class=\"wind_icon ' +  data.datasets[1].data[tooltipItems[0].index] + '\"></div>--><br />' 
                                            + data.datasets[2].label + ": " + data.datasets[2].data[tooltipItems[0].index] + '%<br />' 
                                            + '<?=$HUMIDITY[$lang_idx];?>: ' + data.datasets[6].data[tooltipItems[0].index] + '%<br />'
                                            +'<ul class=\"tooltipline\"><li><img width=\"24\" height=\"24\" src=\"images/clothes/' + data.datasets[5].data[tooltipItems[0].index] + '\" />&nbsp;&nbsp;&nbsp;<img width=\"24\" height=\"24\" src=\"images/icons/day/' + data.datasets[4].data[tooltipItems[0].index] + '\" /></li><li>' +	
                                data.datasets[3].data[tooltipItems[0].index] + '</li></ul>';
                    }
                
                }
                
                },
                hoverAnimationDuration: 400,
                stacked: true,
                scales: {
                xAxes: [{
                    display: true,
                    id: "x-axis-0",
                    categoryPercentage:1,
                    barPercentage:1,
                    position:'top',
                    gridLines: {
                        display: false,
                        tickMarkLength:10,
                        drawBorder: false
                    },
                    
                    stacked:true,
                    ticks: {
                         display:true,
                         maxRotation:0,
                         fontColor: '#fff',
                         lineHeight:1,
                         fontSize:11,
                         fontStyle:'bold',
                         padding: -28,
                         mirror:true,
                         autoSkip: false,
                         userCallback: function(dataLabel, index) {
                             
                         if (dataLabel[2].indexOf('00:00') > 0){
                                 datacut = [dataLabel[0], dataLabel[1]];
                                 return datacut;
                          }
                          else if (index % 4 === 0)
                         {
                                datacut = [dataLabel[0], dataLabel[2]];
                                 return datacut;   
                         }
                         else if (index % 1 === 0)
                         {
                             var ret;
                             //if ((parseInt(dataLabel[2]) <= 2) ||
                             //          (parseInt(dataLabel[2]) >= 22))
                              //     return  '';
                               ret = dataLabel[2];
                               //if (index % 6 === 0) //  8  16
                               //   ret = ret + String.fromCharCode(8594);
                               return ret;
                         }
                         else
                             return '';
                         }
                     }
					
                }],
                yAxes: [{
                    display: false,
                    position: "left",
                    id: "y-axis-1",
                    gridLines:{
                        display: false
                    },
                     scaleLabel: {
                            display: true,
                            labelString: '<?=$TEMP[$lang_idx]?>'
                     },
                    ticks: {
                       suggestedMax:<?=getCorF($max_temp)+6?>,
                       suggestedMin:<?=getCorF($min_temp)-1?>
                    }
                },
                {
                    
                    display: false,
                    id: "y-axis-2",
                    gridLines:{
                        display: false
                    },
                    ticks: {
                       suggestedMax:40,
                       suggestedMin:0
                    }
                   
                },
                {
                    
                    display: false,
                    id: "y-axis-3",
                    gridLines:{
                        display: false
                    },
                    ticks: {
                       suggestedMax:100,
                       suggestedMin:0
                    }
                },
                {
                    
                    display: false,
                    id: "y-axis-4",
                    gridLines:{
                        display: false
                    }
                },
                {
                    
                    display: false,
                    id: "y-axis-5",
                    gridLines:{
                        display: false
                    },
                    ticks: {
                       suggestedMax:100,
                       suggestedMin:0
                    }
                },
                {
                    
                    display: false,
                    id: "y-axis-6",
                    gridLines:{
                        display: false
                    },
                    ticks: {
                       suggestedMax:110,
                       suggestedMin:0
                    }
                }]
            }
            }
            });
             //cv.addEventListener('touchstart', cvOnclick, false);
             document.getElementById('legends').innerHTML = mybarChart.generateLegend();
             // Show/hide chart by click legend
            updateDataset = function (e, chart, datasetIndex, label) {  
                var activePoints = chart.getElementsAtEvent(e);
                var activeDataset = chart.getDatasetAtEvent(e);  
                var index = datasetIndex;
                var ci = this.chart;
                var meta = ci.getDatasetMeta(datasetIndex);    
                var result= (meta.hidden == true) ? false : true;
                if(result==true)
                {
                    meta.hidden = true;
                    $('#' + e.path[0].id).css("text-decoration", "line-through");
                }else{
                    $('#' + e.path[0].id).css("text-decoration","");
                    meta.hidden = false;
                }
                var alreadyHidden = (ci.getDatasetMeta(datasetIndex).hidden === null) ? false : ci.getDatasetMeta(datasetIndex).hidden;
                mybarChart.clear();
                ci.data.datasets.forEach(function(e, i) {
                    var meta = ci.getDatasetMeta(i);

                    if ((i != datasetIndex)) {   
                        meta.hidden = true;
                        $('#legend' + i).css("text-decoration", "");
                        $('#legend' + i).fadeTo(0.3);
                    } else  {
                        meta.hidden = null;
                        chart.data.datasets[i].hidden = false;
                        $('#legend' + i).css("text-decoration", "underline");
                        $('#legend' + i).fadeTo(1);
                        console.log(chart.data.datasets[i]); 
                    }
                    
                });
             
                
                ci.update();   
            };
            function cvOnclick(evt){
                var activePoints = mybarChart.getElementsAtEvent(evt);
                var activeDataset = mybarChart.getDatasetAtEvent(evt);
                // => activePoints is an array of points on the canvas that are at the same position as the click event.
                customTooltips($('#chartjs-tooltip'));
                //alert(barChartData.datasets[3].data[activePoints[0]._index]);
                
            };
            window.chart = mybarChart;
            

            }
        }
function redirect_to_mobile(lang){
    var loc = document.URL;
    top.location.href="small.php?size=l&lang="+lang;
}
function isOnMobilePage(){
    var loc = document.URL;
    return(loc.indexOf('small') > 0);
}

function loadPostData(jsonstr)
	{
            var C_STARTUP_AD_INTERVAL = 5;
		 $.getScript( "footerScripts160816.php?lang=<?=$lang_idx?>&temp_unit=<?if (empty($_GET['tempunit'])) echo "°c"; else echo $_GET['tempunit'];?>" , function( data, textStatus, jqxhr) {
							if (jsonstr  != undefined)
								fillcoldmeter(jsonstr);
                             $('#latestalert').css('visibility', 'visible');
							 $('#arrowdown').show();
							 
							 $(".loading").hide();
                            <?if ($_GET['reg_id'] != "") {?>
                            $.ajax({
                                type: "GET",
                                url: "checkauth.php?action=getuser&reg_id=<?=$_GET['reg_id']?>&qs=<?=$_SERVER['QUERY_STRING']?>"
                              }).done(function( jsonstr ) {

                                   var jsonT = JSON.parse( jsonstr  );
                                   if (jsonT.user.approved == 1)
                                      isUserAdApproved = true;
                                    if (!isUserAdApproved)
                                    {   
                                    $(".adunit").show();
                                        if (sessions % C_STARTUP_AD_INTERVAL == 0)
                                        {
                                            $("#startupdiv").show();
                                        }
                                    }  
                                    else{
                                        $('#adsense_start').remove();
                                        $(".adunit").remove();
                                        $("#adunit1").css('visibility', 'hidden');
                                    }
                                   
                              });
                            <?}else{?>
                            if (!isUserAdApproved)
                            {
                               //$(".adunit").show();
                                if (sessions % C_STARTUP_AD_INTERVAL == 0)
                                {
                                    //$("#startupdiv").show();
                                    should_show_startupdiv = true;
                                }
                            }
                            else{
                              $('#adunit2').remove();  
                              $('#adsense_start').remove();
                            }
                            <?}?>
                            $("#nextdays").css('visibility', 'visible');
                            if (sessions % 2 == 0)
                            {
                                $("#if1").show();
                                $("#if2").hide();
                                $("#if3").show();
                                $("#if4").hide();
                            }
                            else 
                            {
                                $("#if1").hide();
                                $("#if2").show();
                                $("#if3").hide();
                                $("#if4").show();
                                
                            }

                            if (isMobile.iOS()){
                                $(".removeadlink a").attr("href", "https://www.patreon.com/02ws");
                                $(".removeadlink a").attr("target", "_blank");

                            }
                                
							
                    });
	}
    /*!
loadCSS: load a CSS file asynchronously.
[c]2014 @scottjehl, Filament Group, Inc.
Licensed MIT
*/

/* exported loadCSS */
    function loadCSS( href, before, media, callback ){
	"use strict";
	// Arguments explained:
	// `href` is the URL for your CSS file.
	// `before` optionally defines the element we'll use as a reference for injecting our <link>
	// By default, `before` uses the first <script> element in the page.
	// However, since the order in which stylesheets are referenced matters, you might need a more specific location in your document.
	// If so, pass a different reference element to the `before` argument and it'll insert before that instead
	// note: `insertBefore` is used instead of `appendChild`, for safety re: http://www.paulirish.com/2011/surefire-dom-element-insertion/
    
    var ss = window.document.createElement( "link" );
    var head = document.getElementsByTagName('head')[0];    
	var ref = before || window.document.getElementsByTagName( "link" )[ 1 ];
	var sheets = window.document.styleSheets;
    ss.title = "mystyle";
	ss.rel = "stylesheet";
	ss.href = href;
	// temporarily, set media to something non-matching to ensure it'll fetch without blocking render
	ss.media = "only x";
	// DEPRECATED
	if( callback ) {
		ss.onload = callback;
	}
	// inject link
	//ref.parentNode.insertBefore( ss, ref.nextSibling );
    head.appendChild(ss);
	// This function sets the link's media back to `all` so that the stylesheet applies once it loads
	// It is designed to poll until document.styleSheets includes the new sheet.
	ss.onloadcssdefined = function( cb ){
		var defined;
		for( var i = 0; i < sheets.length; i++ ){
			if( sheets[ i ].href && sheets[ i ].href === ss.href ){
				defined = true;
			}
		}
		if( defined ){
			cb();
		} else {
			setTimeout(function() {
				ss.onloadcssdefined( cb );
			});
		}
	};
	ss.onloadcssdefined(function() {
		ss.media = media || "all";
	});
	return ss;
}
 function c_or_f(temp, tempunit) {
        if ((tempunit == '°F')||(tempunit == '°Fnull')||(tempunit == 'F')) {
            return ( Math.round(((9 * temp) / 5) + 32)) + '<div class="paramunit">°</div>';
        }
        if (tempunit == 'none')
            return temp;
        return temp + '<div class="paramunit">°</div>' ;
    }
    function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
        return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }
    function loadData(json)
    {
        var cssstyle_str = "";  
        $('link[rel=stylesheet][title=mystyle]').remove();
        //loadCSS("css/main.php?lang=<?=$lang_idx;?>", document.getElementById('loadGA'));
        if (json.jws.current.issunset == 1) { 
            cssstyle_str += "sunset"; 
            loadCSS("css/sunset.min.css", document.getElementById('loadGA'));
       }
       if (json.jws.current.issunrise == 1) { 
                cssstyle_str += "sunrise"; 
                loadCSS("css/sunrise.min.css", document.getElementById('loadGA'));
        } 
       if ((json.jws.current.islight == 1)&&(json.jws.current.cloudiness > 6)) { 
                cssstyle_str += ",cloudy"; 
                loadCSS("css/cloudy.min.css", document.getElementById('loadGA'));
        }
       if (json.jws.current.pm10 > 300) { 
                cssstyle_str += ",dust"; 
                loadCSS("css/dust.min.css", document.getElementById('loadGA'));
        } 
       if (json.jws.current.islight == '') { 
            cssstyle_str += ",night";
            loadCSS("css/night<? echo $lang_idx;?>.min.css", document.getElementById('loadGA')); 
           if (json.jws.current.pm10 > 300) { 
               cssstyle_str += ",dust-night"; 
               loadCSS("css/dust-night.min.css", document.getElementById('loadGA'));
           }
       }
      if (json.jws.states.israining == 1){ 
            cssstyle_str += ",rain"; 
            loadCSS("css/rain.min.css", document.getElementById('loadGA'));
    }
      if (json.jws.states.issnowing == 1) { 
            if (json.jws.current.islight){ 
                cssstyle_str += ",snow"; 
                loadCSS("css/snow.min.css", document.getElementById('loadGA'));
           } else { 
                cssstyle_str += ",snow_night"; 
                loadCSS("css/snow_night.min.css", document.getElementById('loadGA'));
           } 
      }
      cssstyle_str += ",mobile";
        var tempunit = getParameterByName('tempunit');
        if ((tempunit == '°Fnull')||(tempunit == '°F'))
            tempunit = 'F';
        else if (tempunit.indexOf("C") > 0)
            tempunit = 'C';
        $('#date').html(json.jws.current.date<?=$lang_idx?>);
        var latestalerttext = decodeURIComponent(json.jws.Messages.latestalert<?=$lang_idx?>).replace(/\+/g, ' ');
        var latest_user_pic = "<a href=\"<?=$_SERVER['SCRIPT_NAME']?>?section=userPics.php&amp;lang=<?=$lang_idx."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c'];?>\"><img src=\"" +  json.jws.LatestUserPic.picname + "\" width=\"320\" title=\"userpic\" /></br>" + decodeURIComponent(json.jws.LatestUserPic.name.replace(/\+/g, " ")) + ": " + decodeURIComponent(json.jws.LatestUserPic.comment.replace(/\+/g, " ")) + "</a>&nbsp;&nbsp;";      
        var latest_pic_of_the_day = "<div class=\"txtindiv\"><?=$PIC_OF_THE_DAY[$lang_idx]?>" + "<br/>" + decodeURIComponent(json.jws.LatestPicOfTheDay.caption<?=$lang_idx?>.replace(/\+/g, " ")) + "</div><a href=\"<?=$_SERVER['SCRIPT_NAME']?>?section=picoftheday.php&amp;lang=<?=$lang_idx."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c'];?>\"><img src=\"" +  json.jws.LatestPicOfTheDay.picurl + "\" width=\"320\" title=\"pic of the day\" /></a>";
        var latest_pic_of_the_day_text = "<a href=\"javascript:void(0)\" class=\"info\" ><div class=\"title\">" + decodeURIComponent(json.jws.LatestPicOfTheDay.caption<?=$lang_idx?>.replace(/\+/g, " ")).substring(0, 30) + "...</div>" + "<span class=\"info\"> <div class=\"\"><?=$PIC_OF_THE_DAY[$lang_idx]?>: " + decodeURIComponent(json.jws.LatestPicOfTheDay.caption<?=$lang_idx?>.replace(/\+/g, " ")) + "</div><img src=\"" +  json.jws.LatestPicOfTheDay.picurl + "\" width=\"320\" title=\"pic of the day\" /></span></a>";

        $('#alerts').children('#message').html(decodeURIComponent(json.jws.Messages.latestalert<?=$lang_idx?>+json.jws.Messages.detailedforecast<?=$lang_idx?>).replace(/\+/g, ' '));
        $('#tempdivvalue, #tempdivvaluestart').html('<div class="shade">' + ((json.jws.current.islight == 1) ? "" : "") + '</div>' + c_or_f(json.jws.current.temp, tempunit)+'<div class="param">'+tempunit+'</div>');
        $('#tempdivvalue').css('visibility', 'visible');
        $('#tempdivvaluestart').fadeIn(30);
        if (json.jws.Messages.passedts < 7000){
            var lastindex = 81;
            var lastindexoftime = 29;
            var lastindexplainmode = 30;
            var containsanchor = latestalerttext.indexOf("<a");
            var containstitle = latestalerttext.indexOf("title", lastindexoftime);
            var containsalert = latestalerttext.indexOf("alerttxt");
            lastindex = (containsalert > 0) ? lastindex : lastindexplainmode;
            partialtextlastindex = (containsanchor > 0) ? containsanchor - 1 : lastindex;
            partialtextlastindex = (containstitle > 0) ? (latestalerttext.indexOf("</div>", containstitle) + 6) : partialtextlastindex;
            //partialtextlastindex = Math.min(partialtextlastindex, lastindex);
            partialtext = latestalerttext.substring(0, partialtextlastindex);
            if ((latestalerttext.length > partialtextlastindex))
                latestalerttext = "<a href=\"javascript:void(0)\" class=\"info\" >" + latestalerttext.substring(0, partialtext.length) + "<div class=\"title\">...</div>" + "<span class=\"info\"> " + latestalerttext + "</span></a>";
            $('#latestalert').html(latestalerttext);
        }
        else if (json.jws.LatestPicOfTheDay.passedts < 7200){
            $('#latestalert').html(latest_pic_of_the_day_text);
        }
        
        if (json.jws.LatestUserPic.passedts < 7200){
           $('#latest_user_pic').html(latest_user_pic);
        }
        if (json.jws.LatestPicOfTheDay.passedts < 9600){
            $('#latest_picoftheday').html(latest_pic_of_the_day);
        }
        $('#windy, #windystart').html(json.jws.windstatus.lang<? echo $lang_idx;?>);
      
       var cur_feel_link=document.getElementById('current_feeling_link');
       if (typeof coldmeter_size == 'undefined') 
                coldmeter_size = 20;
         if (cur_feel_link)
         {
                $.ajax({
                type: "GET",
                url: 'coldmeter_service.php?lang='+<?=$lang_idx?> + '&coldmetersize=' + coldmeter_size,
                beforeSend: function(){$(".loading").show();}
              }).done(function( jsonstr  ) {
                  
                    loadPostData(jsonstr);
              });
        }else
			loadPostData();
        
        if (json.jws.current.issun == 1)
        {
            $("#itfeels").show();$("#itfeels_thsw").show();$("#itfeels_thsw .value").html(c_or_f(json.jws.current.thsw, tempunit) + "");$(".sunshade").show();
        }
        else
            $("#itfeels").show();
        if (json.jws.feelslike.state == "windchill")
        {$("#itfeels_windchill").show();$("#itfeels_windchill .value").html(c_or_f(json.jws.feelslike.value, tempunit) + "")}
        else if (json.jws.feelslike.state == "heatindex")
        {$("#itfeels_heatidx").show();$("#itfeels_heatidx .value").html(c_or_f(json.jws.feelslike.value, tempunit) + "")}
        if (json.jws.states.sigweather.length > 1)
        $('#what_is_h, #what_is_h_start ').html(json.jws.states.sigweather[0].sigtitle<? echo $lang_idx;?>+
                                 '&nbsp;<div class=\"invhigh\">&nbsp;' + 
                                  (json.jws.states.sigweather.length - 1) + 
                                  '&nbsp;</div>'
                                   + '<div class="rainpercent">' + (json.jws.current.rainchance > 0 ? (json.jws.current.rainchance + '%') : '') + '</div>');
        $('#what_is_h').css('visibility', 'visible');                          
        var title_temp;
        var title_temp2;
        var title_temp3 = '<?=$ROAD[$lang_idx]?>';
        if (json.jws.current.primary_temp == 1){
           title_temp2 = '&nbsp;<?=$MOUNTAIN[$lang_idx];?>';
           title_temp = '&nbsp;<?=$VALLEY[$lang_idx];?>';
       }
        else{
           title_temp2 = '&nbsp;<?=$VALLEY[$lang_idx];?>';
           title_temp = '&nbsp;<?=$MOUNTAIN[$lang_idx];?>';
       }
        $("#latesttemp .paramvalue").html(c_or_f(json.jws.current.temp, tempunit)+'<div class="param">'+tempunit+'</div>' + '&nbsp;<div class="param"><span id=\"valleytemp\" title=\"\">'+ title_temp + '</span></div>');
        $("#latesttemp .highlows .highparam").html('<strong>' + c_or_f(json.jws.today.hightemp, tempunit) + '</strong>');
        $("#latesttemp .highlows .high_time").html(json.jws.today.hightemp_time);
        $("#latesttemp .highlows .lowparam").html('<strong>' + c_or_f(json.jws.today.lowtemp, tempunit) + '</strong>');
        $("#latesttemp .highlows .low_time").html(json.jws.today.lowtemp_time);
        $("#latesttemp .trendstable .trendsvalues .innertrendvalue").eq(0).html(json.jws.yestsametime.tempchange.split(",")[2]);
        $("#latesttemp .trendstable .trendsvalues .innertrendvalue").eq(1).html(json.jws.oneHour.tempchange.split(",")[2]);
        $("#latesttemp .trendstable .trendsvalues .innertrendvalue").eq(2).html(json.jws.min30.tempchange.split(",")[2]);
        $("#latesttemp .paramtrend .innertrendvalue").html(json.jws.min15.minutes + " " + "<?=$MINTS[$lang_idx]?>: " + json.jws.min15.tempchange.split(",")[2]);
        $("#latesttemp2 .paramvalue").html(c_or_f(json.jws.current.temp2, tempunit)+'<div class="param">'+tempunit+'</div>' + '&nbsp;<div class="param"><span id=\"valleytemp\" title=\"\">'+ title_temp2 + '</span></div>');
        $("#latesttemp2 .highlows .highparam").html('<strong>' + c_or_f(json.jws.today.hightemp2, tempunit) + '</strong>');
        $("#latesttemp2 .highlows .high_time").html(json.jws.today.hightemp2_time);
        $("#latesttemp2 .highlows .lowparam").html('<strong>' + c_or_f(json.jws.today.lowtemp2, tempunit) + '</strong>');
        $("#latesttemp2 .highlows .low_time").html(json.jws.today.lowtemp2_time);
        $("#latesttemp2 .trendstable .trendsvalues .innertrendvalue").eq(0).html(json.jws.yestsametime.temp2change.split(",")[2]);
        $("#latesttemp2 .trendstable .trendsvalues .innertrendvalue").eq(1).html(json.jws.oneHour.temp2change.split(",")[2]);
        $("#latesttemp2 .trendstable .trendsvalues .innertrendvalue").eq(2).html(json.jws.min30.temp2change.split(",")[2]);
        $("#latesttemp2 .paramtrend .innertrendvalue").html(json.jws.min15.minutes + " " + "<?=$MINTS[$lang_idx]?>: " + json.jws.min15.temp3change.split(",")[2]);
        $("#latestradiation .paramvalue").html(json.jws.current.solarradiation+'<span class="paramunit">'+'W/m2' + '</span>');
        $("#latestradiation .highlows .highparam").html('<strong>' + json.jws.today.highradiation + '</strong>');
        $("#latestradiation .highlows .high_time").html(json.jws.today.highradiation_time);
        $("#latestradiation .trendstable .trendsvalues .innertrendvalue").eq(0).html(json.jws.yestsametime.srchange.split(",")[2]);
        $("#latestradiation .trendstable .trendsvalues .innertrendvalue").eq(1).html(json.jws.oneHour.srchange.split(",")[2]);
        $("#latestradiation .trendstable .trendsvalues .innertrendvalue").eq(2).html(json.jws.min15.srchange.split(",")[2]);
        $("#latestradiation .paramtrend .innertrendvalue").html("<strong><?=$RISE[$lang_idx]?>:</strong> " + json.jws.today.sunrise + " <strong><?=$SET[$lang_idx]?>:</strong> " +  json.jws.today.sunset + "<br />" + json.jws.today.sunshinehours + " <?=$SUNSHINEHOURS[$lang_idx]?>" + "  <?=$TILL_NOW[$lang_idx]?>");
       
        $("#latesttemp3 .paramvalue").html(c_or_f(json.jws.current.temp3, tempunit)+'<div class="param">'+tempunit+'</div>' + '&nbsp;<div class="param"><span id=\"valleytemp\" title=\"\">' + title_temp3 + '</span></div>');
        $("#latesttemp3 .highlows .highparam").html('<strong>' + c_or_f(json.jws.today.hightemp3, tempunit) + '</strong>');
        $("#latesttemp3 .highlows .high_time").html(json.jws.today.hightemp3_time);
        $("#latesttemp3 .highlows .lowparam").html('<strong>' + c_or_f(json.jws.today.lowtemp3, tempunit) + '</strong>');
        $("#latesttemp3 .highlows .low_time").html(json.jws.today.lowtemp3_time);
        $("#latesttemp3 .trendstable .trendsvalues .innertrendvalue").eq(0).html(json.jws.yestsametime.temp3change.split(",")[2]);
        $("#latesttemp3 .trendstable .trendsvalues .innertrendvalue").eq(1).html(json.jws.oneHour.temp3change.split(",")[2]);
        $("#latesttemp3 .trendstable .trendsvalues .innertrendvalue").eq(2).html(json.jws.min30.temp3change.split(",")[2]);
        $("#latesttemp3 .paramtrend .innertrendvalue").html(json.jws.min15.minutes + " " + "<?=$MINTS[$lang_idx]?>: " + json.jws.min15.temp3change.split(",")[2]);
        if (json.jws.current.islight == 1)
            $("#temp3_desc").html(json.jws.desc.temp3_desc<?=$lang_idx?>);
        else
            $("#temp3_desc").html(json.jws.desc.temp3_night_desc<?=$lang_idx?>);
        $("#latesthumidity .paramvalue").html(json.jws.current.hum+'&nbsp;<div class="param">%</div>');
        $("#latesthumidity .highlows .highparam").html('<strong>' + json.jws.today.highhum + '</strong>');
        $("#latesthumidity .highlows .high_time").html(json.jws.today.highhum_time);
        $("#latesthumidity .highlows .lowparam").html('<strong>' + json.jws.today.lowhum + '</strong>');
        $("#latesthumidity .highlows .low_time").html(json.jws.today.lowhum_time);
        $("#latesthumidity .trendstable .trendsvalues .innertrendvalue").eq(0).html(json.jws.yestsametime.humchange.split(",")[2]);
        $("#latesthumidity .trendstable .trendsvalues .innertrendvalue").eq(1).html(json.jws.oneHour.humchange.split(",")[2]);
        $("#latesthumidity .trendstable .trendsvalues .innertrendvalue").eq(2).html(json.jws.min30.humchange.split(",")[2]);
        $("#latesthumidity .paramtrend .innertrendvalue").html(json.jws.min15.minutes + " " + "<?=$MINTS[$lang_idx]?>: " + json.jws.min15.humchange.split(",")[2]+"%");
        $("#latestwind .paramvalue").html("<div id=\"winddir\" class=\"paramunit\"><div class=\"winddir\"></div></div><div id=\"windspeed\">" + json.jws.current.windspd + " <div class=\"param\"><?=$WIND_UNIT[$lang_idx]?></div></div>");
        $("#latestwind .winddir").addClass(json.jws.current.winddir);
        $("#latestwind .highlows .highparam").html('<strong>' + json.jws.today.highwind + '</strong>');
        $("#latestwind .highlows .high_time").html(json.jws.today.highwind_time);
        $("#latestwind .paramtrend div").html("10 <?=$MINTS[$lang_idx]." ".$AVERAGE[$lang_idx]?> : <strong>" + json.jws.current.windspd10min + '</strong>' + ' <?=$WIND_UNIT[$lang_idx]?> ');
        $("#latestrain .highlows .highparam").html('<strong>'+ json.jws.today.highrainrate + '</strong>');
        $("#latestrain .highlows .high_time").html(json.jws.today.highrainrate_time);
        $("#latestrain .trendstable .trendsvalues .innertrendvalue").eq(0).html(json.jws.oneHour.rainratechange.split(",")[2]);
        $("#latestrain .trendstable .trendsvalues .innertrendvalue").eq(1).html(json.jws.min30.rainratechange.split(",")[2]);
        $("#latestrain .trendstable .trendsvalues .innertrendvalue").eq(2).html(json.jws.min15.rainratechange.split(",")[2]);
        $("#latestrain .paramvalue").html(json.jws.current.rainrate+'<div class="param">' + " <?=$RAINRATE_UNIT[$lang_idx]?>" +'</div>');
        $("#latestrain .paramtrend").html("<?=$DAILY_RAIN[$lang_idx]?>:&nbsp;" + json.jws.today.rain + " " + "&nbsp;&nbsp;" + "<?=$TOTAL_RAIN[$lang_idx]?>:&nbsp;" + json.jws.seasonTillNow.rain + " <?=$RAIN_UNIT[$lang_idx]?>");
		$("#latestairq .paramvalue").html(json.jws.current.pm10 + '<div class=\"param\">&plusmn;' + json.jws.current.pm10sd + '&nbsp;µg/m3&nbsp;(PM10)</div><br />' + 
                             json.jws.current.pm25  + '<div class=\"param\">&plusmn;'+ json.jws.current.pm25sd + '&nbsp;µg/m3&nbsp;(PM2.5)</div>');
        $("#latestairq .trendstable .trendsvalues .innertrendvalue").eq(0).html(json.jws.yestsametime.pm10change.split(",")[2]);
        $("#latestairq .trendstable .trendsvalues .innertrendvalue").eq(1).html(json.jws.oneHour.pm10change.split(",")[2]);
        $("#latestairq .trendstable .trendsvalues .innertrendvalue").eq(2).html(json.jws.min30.pm10change.split(",")[2]);
        $("#window_btn").addClass(json.jws.states.window_class);
        $("#latestwindow .paramtitle").html(json.jws.states.windowtitle<?=$lang_idx?>);
        $("#latestwindow .highlows").html(json.jws.states.windowdesc<?=$lang_idx?>);
        var sigweatherstates = "";
        sigweatherstates += "<li><button type=\"button\" id=\"xClose\" style=\"background-image: url(../img/close.png); border: none;height: 32px;width: 32px;left: 5px;position: absolute;top: 5px\" onclick=\"$( '#sigweather' ).hide();\"></button></li>";
        for (i = 0; i< json.jws.states.sigweather.length; i++){
            sigweatherstates += "<li><a href=\"" + json.jws.states.sigweather[i].url + "\" >" + json.jws.states.sigweather[i].sigtitle<?=$lang_idx?> + " - " +  json.jws.states.sigweather[i].sigexthtml<?=$lang_idx?> + '<? echo get_arrow();?>' + "</a></li>";
        }
        $('#sigweather').html(sigweatherstates);

        /*
        var forecastDays;
       var fulltextforecast;
       var textforecast;
       var textforecastwidth = "100px";
       var partialtext;
       var partialtextlastindex;
       var TempHighCloth, TempNightCloth;
       var lastindex = 28;
       var link_for_yest;
       var containsanchor;
       var get_cloth = '<?=$_GET['c']?>';
       var get_sound = '<?=$_GET['s']?>';
       var morning_value = json.jws.yest.morningtemp;
       var noon_value = json.jws.yest.noontemp;
       var noon_value_change = json.jws.yest.hightemp_change;
       var night_value = json.jws.yest.nighttemp;
       var date_value = json.jws.yest.date;
       var dayF_a =  json.jws.forecastDays[0].date.split("/")[0];
       var day_a =  json.jws.current.date0.split(" ")[4].split("/")[0];
       if (dayF_a != day_a)
       {
         morning_value = json.jws.today.morningtemp;
         noon_value = json.jws.today.noontemp;
         noon_value_change = json.jws.today.hightemp_change;
         night_value = json.jws.current.temp;
         date_value = json.jws.today.date;
       }
       forecastDays = "";
       forecastDays += "<li class=\"forcast_each\">";
       forecastDays += "<ul><li></li><li id=\"plus\"></li>";
       forecastDays += "<li id=\"morning\"><a href=\"javascript:void(0)\" class=\"info\" ><img src=\"../img/morning_icon.png\" width=\"30\" /><span class=\"info\">" + json.jws.desc.early_morning<? echo $lang_idx;?> + "</span></a></li>";
       forecastDays += "<li id=\"noon\"><a href=\"javascript:void(0)\" class=\"info\" ><img src=\"../img/noon_icon.png\" width=\"18\" /><span class=\"info\">" + json.jws.desc.noon<? echo $lang_idx;?> + "</span></a></li>";
       forecastDays += "<li id=\"night\"><a href=\"javascript:void(0)\" class=\"info\" ><img src=\"../img/night_icon.png\" width=\"18\" /><span class=\"info\">" + json.jws.desc.night_temp_exp<? echo $lang_idx;?> + "</span></a></li>";
       forecastDays += "<li></li>";
       forecastDays += "<li></li>";
       forecastDays += "</ul></li>";
       forecastDays += "<li id=\"yesterday_line\" class=\"forcast_each\" style=\"display:none\">";
       forecastDays += "<ul><li class=\"tsfh\" style=\"text-align:center;\">" + date_value + "</li><li></li>";
       forecastDays += "<li class=\"tsforecastDaysfh\" style=\"text-align:center;direction:ltr\">" + c_or_f(morning_value, tempunit) + "</li>";
       forecastDays += "<li class=\"tsfh\" style=\"text-align:center;direction:ltr\">" + c_or_f(noon_value, tempunit) +"</li>";
       forecastDays += "<li class=\"tsfh\" style=\"text-align:center;direction:ltr\">" + c_or_f(night_value, tempunit) + "</li>";
       forecastDays += "<li></li>";
       forecastDays += "<li></li>";
       forecastDays += "</ul></li>";
        for (i = 0; i< json.jws.forecastDays.length; i++){
            TempLowClothfull = '<div class=\"cloth extra' + i + '\"><a href=\"javascript:void(0)\" class=\"info\" ><img style=\"vertical-align: middle\" src=\"'+json.jws.forecastDays[i].TempLowCloth+'\" width=\"20\" height=\"20\" title=\"'+json.jws.forecastDays[i].TempLowClothTitle<? echo $lang_idx;?>+'\" alt=\"\" /><span class=\"info\">'+json.jws.forecastDays[i].TempLowClothTitle<? echo $lang_idx;?>+'</span></a></div>';
            TempHighClothfull = '<div class=\"cloth extra' + i + '\"><a href=\"javascript:void(0)\" class=\"info\" ><img style=\"vertical-align: middle\" src=\"'+json.jws.forecastDays[i].TempHighCloth+'\" width=\"20\" height=\"20\" title=\"'+json.jws.forecastDays[i].TempHighClothTitle<? echo $lang_idx;?>+'\" alt=\"\" /><span class=\"info\">'+json.jws.forecastDays[i].TempHighClothTitle<? echo $lang_idx;?>+'</span></a></div>';
            TempNightClothfull = '<div class=\"cloth extra' + i + '\"><a href=\"javascript:void(0)\" class=\"info\" ><img style=\"vertical-align: middle\" src=\"'+json.jws.forecastDays[i].TempNightCloth+'\" width=\"20\" height=\"20\" title=\"'+json.jws.forecastDays[i].TempNightClothTitle<? echo $lang_idx;?>+'\" alt=\"\" /><span class=\"info\">'+json.jws.forecastDays[i].TempNightClothTitle<? echo $lang_idx;?>+'</span></a></div>';
        
            TempLowCloth = "";
            TempHighCloth = "";
            TempNightCloth = "";
            if ((get_cloth)&&(get_cloth == 1)){
                TempLowCloth = TempLowClothfull;
                TempHighCloth = TempHighClothfull;
                TempNightCloth = TempNightClothfull;
            }
            <? if (isHeb()) {?>
             if (i == 4) {
            //    forecastDays += "<li class=\"adunit\"><li colspan=\"6\" style=\"padding:0 8px 0 0\"><a href=\"https://m.facebook.com/events/2354090778162660/\" target=_blank >וָאקוּם • פעולות אמנות בשכונה נסתרת</a></li><li><a href=\"https://m.facebook.com/events/2354090778162660/\" target=_blank ><img src=\"images/vacum.png\" width=\"32\" height=\"32\" alt=\"זאזא\" /></a></li></li>  ";
                            }
                            <?}?>
             forecastDays += "<li class=\"forcast_each\">";
            if (i==0)
              link_for_yest = "<a id=\"linkyesterday\" hrf=\"javascript:void(0)\" onclick=\"$('#yesterday_line').show();\"><img src=\"images/yesterday.png\" width=\"14\" height=\"14\" title=\"<?=$LAST_DAY[$lang_idx]?>\" /></a>";
            else
                link_for_yest = "";
            forecastDays += "<ul><li class=\"forcast_date\" >"  + link_for_yest + json.jws.forecastDays[i].day_name<?=$lang_idx?> + "<div class=\"datetext\">" + json.jws.forecastDays[i].date + "<div></li><li>" + "<div id=\"" + i + "\" class='open-close-button'></div>" + "</li>";
            forecastDays += "<li class=\"tsfh forcast_morning\" style=\"text-align:center;direction:ltr\">" + c_or_f(json.jws.forecastDays[i].TempLow, tempunit) + TempLowCloth +  "<div class=\"icon extra" + i + "\" id=\"morning_icon" + i + "\">" + TempLowClothfull + "<img src=\"" + json.jws.forecastDays[i].morning_icon + "\" width=\"28\" height=\"28\" alt=\"" + json.jws.forecastDays[i].morning_icon +"\" /></siv></li>";
            forecastDays += "<li class=\"tsfh forcast_noon\" style=\"text-align:center;direction:ltr\">" + c_or_f(json.jws.forecastDays[i].TempHigh, tempunit) + TempHighCloth + "<div class=\"icon extra" + i + "\" id=\"day_icon" + i + "\">" + TempHighClothfull + "<img src=\"" + json.jws.forecastDays[i].icon + "\" width=\"28\" height=\"28\" alt=\"" + json.jws.forecastDays[i].icon +"\" /></div></li>";
            forecastDays += "<li class=\"tsfh forcast_night\" style=\"text-align:center;direction:ltr\">" + c_or_f(json.jws.forecastDays[i].TempNight, tempunit) + TempNightCloth + "<div class=\"icon extra" + i + "\" id=\"night_icon" + i + "\">" + TempNightClothfull + "<img src=\"" + json.jws.forecastDays[i].night_icon + "\" width=\"28\" height=\"28\" alt=\"" + json.jws.forecastDays[i].night_icon +"\" /></div></li>";
            forecastDays += "<li class=\"forcast_each\" >";
            if (i==0)
                forecastDays += noon_value_change;
            forecastDays += "<span class=\"icon extra" + i + "\" id=\"icon" + i + "\"><img src=\"" + json.jws.forecastDays[i].icon + "\" width=\"32\" height=\"32\" alt=\"" + json.jws.forecastDays[i].icon +"\" /></span>"+"</li>";
            fulltextforecast = json.jws.forecastDays[i].lang<? echo $lang_idx;?>;
            containsanchor = fulltextforecast.indexOf("<a");
            partialtextlastindex = (containsanchor > 0) ? containsanchor - 1 : lastindex;
            partialtext = fulltextforecast.substring(0, partialtextlastindex);
            if ((fulltextforecast.length > lastindex)&&!(containsanchor > 0))
                textforecast = "<span class=\"extra" + i + "\"><a href=\"javascript:void(0)\" class=\"info\" >" + fulltextforecast.substring(0, partialtext.lastIndexOf(" ")) + "..." + "<span class=\"info\"> " + fulltextforecast + "</span></a>" + "<span>";
            else
                textforecast = "<span class=\"extra" + i + "\">" + fulltextforecast + "</span>";
            var get_fullt = '<?=$_GET['fullt']?>';
            if ((get_fullt)&&(get_fullt > 0)){
                textforecast = fulltextforecast;
                textforecastwidth = "130px";
            }
            forecastDays += "<li class=\"text\" ><span class=\"extra" + i + " fulltext\">" + fulltextforecast + "</span>" +  textforecast +"</li>";
            forecastDays += "</ul></li>";
       }
       forecastDays += "<li><ul><li style=\"text-align:center\">" + json.jws.desc.month_in_word<?=$lang_idx?> + " <?=$AVERAGE[$lang_idx]?></li><li></li><li class=\"tsfh average\" style=\"text-align:center\">" + json.jws.thisMonth.lowtemp_av + "</li><li class=\"tsfh average\" style=\"text-align:center\">" + json.jws.thisMonth.hightemp_av + "</li><li></li><li></li><li></li></ul></li>";
       
       */

            $("#bg2-1").hide();$("#bg2-4").hide();$("#bg2-6").hide();$("#bg2-7").hide();$("#bg1-3").hide();$("#bg1-4").hide();$("#bg1-5").hide();$("#bg1-6").hide();$("#bg2-2").hide();$("#bg2-8").hide();$("#bg1-1").hide();$("#bg1-2").hide();$("#bg1-7").hide();$("#bg1-8").hide();$("#bg2-5").hide();$("#bg2-9").hide();$("#bg2-10").hide();$("#bg1-9").hide();$("#bg1-10").hide();     
       if (json.jws.current.cloudiness > 2){
           $('#cloudiness4bg2').show();
           $('#cloudiness4bg1').show();
           $("#bg2-1").show();
            $("#bg2-4").show();
            $("#bg2-6").show();
            $("#bg2-7").show();
            $("#bg1-3").show();
            $("#bg1-4").show();
            $("#bg1-5").show();
            $("#bg1-6").show();
       }
       if (json.jws.current.cloudiness > 5){
           $('#cloudiness6bg2').show();
           $('#cloudiness6bg1').show();
           $("#bg2-2").show();
            $("#bg2-8").show();
            $("#bg1-1").show();
            $("#bg1-2").show();
            $("#bg1-7").show();
            $("#bg1-8").show(); 
      }
       if (json.jws.current.cloudiness > 6){
           $('#cloudiness8bg2').show();
           $('#cloudiness8bg2').show();
           $("#bg2-5").show();
            $("#bg2-9").show();
            $("#bg2-10").show();
            $("#bg1-9").show();
            $("#bg1-10").show();
       }
        $(".info_btns").show();
        $(".seker_btns").show();
        
       $('#logo').show();
      
        if ((json.jws.states.issnowing != 1) && (json.jws.states.israining == 1))    
       {$.getScript( "js/rain.js" );
           if (get_sound == 1){
               playSound();
           }
       }
       else if (json.jws.states.issnowing == 1)    
          {$.getScript( "js/snow.js" );};
      $("#now_btn").css("background-position", "right");
    }
    function fillAllJson(jsonstr)
    {
      try{var json = JSON.parse(jsonstr);} catch (e) {
          //alert('parsing json: ' + e);
          }
      try{loadData(json);} catch (e) {
          //alert('extracting json to page: ' + e);
          }
      
   }
//
// startup script
//
var isUserAdApproved = false;
var sessions = getCookie('sessions');
if (sessions == 'NaN') {sessions = 0};
sessions = parseInt(sessions) + 1;
rememberCookie ('sessions', sessions);
window.addEventListener('load', function () {
		FastClick.attach(document.body);
	}, false);
if(navigator.userAgent.match(/iPad/i)) {
        viewport = document.querySelector("meta[name=viewport]");
        viewport.setAttribute('content', 'width=1050');
}
trMouseOver();
(function ($) {
    if ($('html').is('.lt-ie9')) {
        var loc = document.URL;
      //  top.location.href="stationo.php?lang="+<?=$lang_idx?>;
    }
}(jQuery));
if ((isMobile.any())&&(!isOnMobilePage())){
    
    //$.colorbox({href:"#mobile_redirect"});
    $("#mobile_redirect").show();
    //redirect_to_mobile(<?=$lang_idx?>);
}
function toggleForecastDay(index){
	$('.extra' + index).toggle(0);
	//$('#' + 'morning_icon' + index).toggle("slow");
	//$('#' + 'day_icon' + index).toggle("slow");
	//$('#' + 'night_icon' + index).toggle("slow");
	//$('#' + 'icon' + index).toggle("slow");
}
function openForecastDay(index){
    $('.extra' + index).show(0);
}
 $(".open-close-button").click(function () {
	  toggleForecastDay($(this).attr("id"));
      return $(this).toggleClass("open");
    });
$(".date").click(function () {
    toggleForecastDay($(this).next('td').find('.open-close-button').attr("id"));
    return $(this).next('td').find('.open-close-button').toggleClass("open");
});
$(".text, .forcast_each").click(function () {
    toggleForecastDay($(this).prevAll('.plus').find('.open-close-button').attr("id"));
    return $(this).prevAll('.plus').find('.open-close-button').toggleClass("open");
});
$(".tsfh .number").click(function () {
    toggleForecastDay($(this).parent().prevAll('.plus').find('.open-close-button').attr("id"));
    return $(this).parent().prevAll('.plus').find('.open-close-button').toggleClass("open");
});
$("#startpage_chb").click(function () {
    //alert(current_tab);
    rememberCookie ('start_container', current_tab, 0.1);
    rememberCookie ('start_nodeid', current_nideid, 0.1);
    $("#startpage_chb").hide();
});
    
var view = $("#graphForcastContainer");
var move = "100px";
var sliderLimit = -500

$("#rightArrow").click(function(){
    
    var currentPosition = parseInt(view.css("left"));
    if (currentPosition >= sliderLimit) view.stop(false,true).animate({left:"-="+move},{ duration: 400})

});

$("#leftArrow").click(function(){

    var currentPosition = parseInt(view.css("left"));
    if (currentPosition < 0) view.stop(false,true).animate({left:"+="+move},{ duration: 400})

});
<? if ($_GET['debug'] == '') include "end_caching.php"; ?>