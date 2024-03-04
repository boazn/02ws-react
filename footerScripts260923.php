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
function get_s_align(){
    if (isHeb()) 
            return "right";
    else
            return "left";
}
function get_inv_s_align(){
        if (isHeb()) 
                return "left";
        else
                return "right";
}
function getWindInfo($windspeed, $lang_idx){
    global $WEAK_WINDS, $MODERATE_WINDS, $STRONG_WINDS, $EXTREME_WINDS, $NO_WIND, $WINDY, $min10;
    if ($windspeed > 60){
               $windtitle=$EXTREME_WINDS[$lang_idx];
               $wind_class="high_wind";
               $windimg = "wind2.svg";
      }

     else if ($windspeed > 35){
               $windtitle=$STRONG_WINDS[$lang_idx];
               $wind_class="high_wind";
               $windimg = "wind2.svg";
      }

     else if ($windspeed > 18){
               $windtitle=$MODERATE_WINDS[$lang_idx];
               $wind_class="moderate_wind";
               $windimg = "wind1.svg";
      }

     else if (($windspeed > 0)||($min10->get_windspd() > 0)){
               $windtitle=$WEAK_WINDS[$lang_idx];
               $wind_class="light_wind";
               $windimg = "wind0.svg";
      } else 
      {
           $windtitle=$NO_WIND[$lang_idx];
           $wind_class="no_wind";
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
$(".href").colorbox({maxWidth:'95%', maxHeight:'95%', width:"35%", inline:true, href:"#href_dialog"});$(".mood").colorbox({width:"35%", inline:true, href:"#moods_dialog"});}
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
if (msgDetails == null)
    return;
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
//alert (e);
}
}

$(document).ready(function(){$(".colorbox").colorbox({maxWidth:"95%"});
$("a[rel='external']").colorbox({width:"99%", height:"85%", iframe:true});
$("a[title='legend']").colorbox({width:"85%"});02/03/2018
$(".href").colorbox({width:"35%", inline:true, href:"#href_dialog"});
$(".imghref").colorbox({width:"35%", inline:true, href:"#href_img_dialog"});
$(".mood").colorbox({width:"35%", inline:true, href:"#moods_dialog"});
$(".user_icon").colorbox({width:"35%", inline:true, href:"#user_icon_dialog"});
$("#login").colorbox({width:"310px", height:"480px", inline:true, top:"40px", fixed:true,href:"#loginform"});
$(".register").colorbox({width:"310px", height:"600px", inline:true, top:"40px", fixed:true,href:"#registerform"});
$("#updateprofile").colorbox({width:"310px", height:"600px", top:"40px",inline:true, href:"#profileform"});
$(".icon_forecast").colorbox({width:"35%", inline:true, href:"#icons_dialog"});
$(".temphigh, .templow, .tempnight").colorbox({width:"35%", inline:true, href:"#clothes_dialog"});

});
var isMobile = {
    Android: function() {
        return ((navigator.userAgent.match(/Android/i))&&(navigator.userAgent.match(/mobile/i))) ? true : false;
    },
    AndroidWV: function() {
        return navigator.userAgent.includes ('wv') ? true : false;
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i) ? true : false;
    },
    safari: function() {
        return navigator.userAgent.match(/safari|Safari/i) ? true : false;
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
{$('#'+id).show(100);}
else
$('#'+ id).hide(50);}}
function show(id){$('#'+id).show(100);}
function hide(id){$('#'+id).hide(50);}
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
     animationProperties[direction] = "-820px";
 } else {
	 $('#mainadsense').hide("slow");$('#forcast_main').css('width','1120px');
     animationProperties[direction] = "-1690px";
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
     
    
    $('#runwalk_btn, #moon_btn, #more_stations_btn, #dew_btn, #laundry_btn, #heater_btn, #sport_btn, #car_btn, #openwindow_btn, #camping_btn, #children_btn, #eventoutside_btn, #gazellepark_btn, #irrigation_btn, #dog_btn, #picnic_btn, #sacker_btn, #westernwall_btn, #yoga_btn, #ac_btn, #bicycle_btn, #campfire_btn, #campfire_btn, #dinneratbalcony_btn').css('opacity','0.6');
        
    if (info_id == "latestdewpoint")
        $('#dew_btn').css('opacity','1');
    if (info_id == "latestrunwalk")
        $('#runwalk_btn').css('opacity','1');
    if (info_id == "latestotherstations")
        $('#more_stations_btn').css('opacity','1');   
    if (info_id == "latest_laundry")
        $('#laundry_btn').css('opacity','1');
    if (info_id == "latest_car")
        $('#car_btn').css('opacity','1');
    if (info_id == "latest_openwindow")
        $('#openwindow_btn').css('opacity','1');
    if (info_id == "latest_camping")
        $('#camping_btn').css('opacity','1');
    if (info_id == "latest_children")
        $('#children_btn').css('opacity','1');
    if (info_id == "latest_eventoutside")
        $('#eventoutside_btn').css('opacity','1');
    if (info_id == "latest_gazellepark")
        $('#gazellepark_btn').css('opacity','1');
    if (info_id == "latest_irrigation")
        $('#irrigation_btn').css('opacity','1');
    if (info_id == "latest_dog")
        $('#dog_btn').css('opacity','1');
    if (info_id == "latest_picnic")
        $('#picnic_btn').css('opacity','1');
    if (info_id == "latest_sacker")
        $('#sacker_btn').css('opacity','1');
    if (info_id == "latest_heater")
        $('#heater_btn').css('opacity','1');
    if (info_id == "latest_sport")
        $('#sport_btn').css('opacity','1');
    if (info_id == "latest_westernwall")
        $('#westernwall_btn').css('opacity','1');
    if (info_id == "latest_yoga")
        $('#yoga_btn').css('opacity','1');
    if (info_id == "latest_ac")
        $('#ac_btn').css('opacity','1');
    if (info_id == "latest_bicycle")
        $('#bicycle_btn').css('opacity','1');
    if (info_id == "latest_campfire")
        $('#campfire_btn').css('opacity','1');
    if (info_id == "latest_dinneratbalcony")
        $('#dinneratbalcony_btn').css('opacity','1');
    if (info_id != "latest_laundry")
        $('#now_btn').css('background-position', 'left');
     else
        $('#now_btn').css('background-position', 'right');
     if (info_id != "latestwind")
        $('#wind_btn').css('background-position', 'left');
     else
        $('#wind_btn').css('background-position', 'right');
     if (info_id != "latestrain")
        $('#rain_btn').css('background-position', 'left');
     else
        $('#rain_btn').css('background-position', 'right');
     if (info_id != "latestradiation")
        $('#rad_btn').css('background-position', 'left');
     else
        $('#rad_btn').css('background-position', 'right');
     if (info_id != "latestairq")
        $('#aq_btn').css('background-position', 'left');
     else
        $('#aq_btn').css('background-position', 'right');
     if (info_id != "latestpressure")
        $('#air_btn').css('background-position', 'left');
     else
        $('#air_btn').css('background-position', 'right');
     if (info_id != "latesttemp")
        $('#temp2_btn').css('background-position', 'left');
     else
        $('#temp2_btn').css('background-position', 'right');
     if (info_id != "latesttemp2")
        $('#temp_btn').css('background-position', 'left');
     else
        $('#temp_btn').css('background-position', 'right');
     if (info_id != "latesttemp3")
        $('#temp3_btn').css('background-position', 'left');
     else
        $('#temp3_btn').css('background-position', 'right');
    if (info_id != "latesthumidity")
        $('#moist_btn').css('background-position', 'left');
     else
        $('#moist_btn').css('background-position', 'right');
    if (info_id != "latestuv")
        $('#uv_btn').css('background-position', 'left');
     else
        $('#uv_btn').css('background-position', 'right');
     $('#latestnow, #latesttemp, #latesttemp2, #latesttemp3, #latestpressure, #latesthumidity, #latestuv, #latestdewpoint, #latestradiation, #latestrain, #latestwind, #latestairq, #latestwindow, #latestwebcam, #latestmoon, #latestotherstations, #latestrunwalk, #chartjs-tooltip, #latest_laundry,#latest_ac,#latest_bicycle,#latest_campfire,#latest_camping,#latest_car,#latest_children,#latest_dinneratbalcony,#latest_dog,#latest_eventoutside,#latest_gazellepark,#latest_heater,#latest_irrigation,#latest_openwindow,#latest_picnic,#latest_sport,#latest_sacker,#latest_westernwall,#latest_yoga').hide();
     var desktop = document.getElementById("now_line");
	 
     if (info_id == "latestnow")
        display_mode = "flex";
    else
        display_mode = "flow-root";
     $('#' + info_id).css('display', display_mode);
     $('.detailed #' + info_id).css('display', 'block');


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
        function fillUserDetails (jsonT )
        {
                var PERSONAL_COLD_METER_VOTES_THRESHHOLD = 0;
        	
        	 $("#profileform_email").val(jsonT.user.email);
                 $("#name").html(jsonT.user.display);
                 $("#user_name").html(jsonT.user.display);
                 $("#hello").html(jsonT.user.display);
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
                 console.assert(nextClass != undefined);
                 icon = decodeURIComponent(jsonT.user.icon).replace(/\+/g, ' ');
                  if ((icon != undefined )
                    &&(icon.indexOf('http') == -1 )
                    &&(nextClass != undefined )
                    &&(icon != "" )
                    &&(icon != "admin_avatar"))
                    while (jsonT.user.icon != nextClass){
                       nextClass = change_icon('right', $("#profileform .icon_right"));
                    }
                if  (icon.indexOf('http') > 0 ){
                    $("#user_icon").html(icon);
                }
        }
        function signout_from_server(lang, limit, update)
        {
                $.ajax({
          type: "POST",
          url: "<?=BASE_URL?>/checkauth.php?action=signout",
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
                 fillMessage('<img src="<?=BASE_URL?>/img/loading_white.gif" alt="loading" width="50" height="50"/>');
                $.ajax({
                    type: "POST",
                    headers: {  'Access-Control-Allow-Origin': '*' },
                    url: "<?=BASE_URL?>/chat_service.php?lang="+lang+"&from="+limit+"&update="+update,
                    data: {lang:lang, from:limit, update:update},
               }).done(function(str){fillMessage(str);});
               }
            }



        });
        }
        function getMessageService(from, to, start, update, lang, category)
	{	
        $("#current_forum_filter").val(category);
        $("#current_forum_filter").attr('data-key',category); 
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
                    fillMessage('<img src="<?=BASE_URL?>/img/loading.gif" alt="loading" width="50" height="50"/>');
		$('input[name="SendButton"]').attr("disabled", "disabled");
		var ajax = new Ajax();
		ajax.method = 'POST';
		ajax.setMimeType('text/html');
		ajax.postData = postData;
		ajax.setHandlerBoth(fillMessage);
		ajax.url = '<?=BASE_URL?>/chat_service.php?'+postData;
		ajax.doReq();
                
		
	}
        function getNextPage(lang, limit)
        {
            $('#current_forum_update_display').val('A');
            $('#current_forum_startline').val(parseInt($('#current_forum_startline').val())+limit);
            var category = localStorage.getItem("category");
            if  (category == "undefined")
                category = 1;
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
		  url: "<?=BASE_URL?>/checkauth.php?action=login&lang="+lang+"&reg_id=<?=$_GET['reg_id']?>&email="+$("#loginform_email").val() + "&password=" + $("#loginform_password").val() + "&isrememberme=" + ($("#loginform_rememberme").is(':checked') ? 1 : 0),
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
                    fillUserDetails (JSON.parse( jsonstr  ) );
                    toggle('loggedin');toggle('notloggedin');
                    
                    if (document.getElementById('new_post_btn')){
                            $('#new_post_btn').attr('onclick','openNewPost('+lang+')');
                    }
                    if (document.getElementById('forum'))
                    {                    
                    fillMessage('<img src="<?=BASE_URL?>/img/loading.gif" alt="loading" width="50" height="50"/>');
                                                $.ajax({
                                                    type: "POST",
                                                    headers: {  'Access-Control-Allow-Origin': '*' },
                                                    url: "<?=BASE_URL?>/chat_service.php?lang="+lang+"&from="+limit+"&update="+update,
                                                    data: {lang:lang, from:limit, update:update},
                                                }).done(function(str){fillMessage(str);});
                                                
                    }
                }
                                                    
            }
            catch (e) {
                
                console.error(e);
                
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
                 
                  /*if ($("#profileform_nicename").val().length == 0){
                 	alert('<?=$NICE_NAME[$lang_idx]?> <?=$EMPTY[$lang_idx]?>');
                 	$("#profileform_nicename").focus();
                 	return false;
                 }*/
                   
        	$.ajax({
		  type: "POST",
		  url: "<?=BASE_URL?>/checkauth.php?action=updateprofile&lang="+lang+"&email="+$("#profileform_email").val()+"&password="+$("#profileform_password").val()+"&user_display_name="+$("#profileform_displayname").val()+"&user_icon="+$("#chosen_user_icon").val()+"&user_nice_name="+$("#profileform_nicename").val()+"&personal_coldmeter=" + ($("#profileform_personal_coldmeter").is(':checked') ? 1 : 0) +"&priority="+ ($("#profileform_priority").is(':checked') ? 1 : 0),
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
              if (document.getElementById('cboxClose')==null)
                 parent.jQuery.colorbox.close();
		      
		   }
		  else
		     $("#profileform_result").html( msg );
		});
        }
        function register_to_server(lang)
        {
        	$("#registerform_result").html("");
            /*   if ($("#registerform_userid").val().length == 0){
                 	alert('<?=$USER_ID[$lang_idx]?> <?=$EMPTY[$lang_idx]?>');
                 	$("#registerform_userid").focus();
                 	return false;
                 }*/
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
                 
                /*  if ($("#registerform_nicename").val().length == 0){
                 	alert('<?=$NICE_NAME[$lang_idx]?> <?=$EMPTY[$lang_idx]?>');
                 	$("#registerform_nicename").focus();
                 	return false;
                 }*/
                 
                 if ($("#registerform_password").val() != $("#registerform_password_verif").val()){
                 	alert('Passwords do not match סיסמאות לא זהות');
                 	$("#registerform_password_verif").focus();
                 	return false;
                 }
                   
        	$.ajax({
		  type: "POST",
		  url: "<?=BASE_URL?>/checkauth.php?action=register&lang="+lang+"&username="+$("#registerform_userid").val()+"&email=" + $("#registerform_email").val()+"&password="+$("#registerform_password").val()+"&user_display_name="+$("#registerform_displayname").val()+"&user_icon="+$("#chosen_user_icon").val()+"&user_nice_name="+$("#registerform_nicename").val()+"&priority="+($("#registerform_priority").is(':checked') ? 1 : 0),
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
		  url: "<?=BASE_URL?>/checkauth.php?action=forgotpass&lang="+lang+"&email="+$("#passforgotform_email").val(),
		  data: {  }
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
    function fillcoldmeter(str, str_sun)
    {
            var cur_feel_link=document.getElementById('current_feeling_link');
            var tickText=document.createElement('text');
            tickText.innerHTML=str + str_sun;
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
    function fillcoldmeter_fromjson(json, coldmeter_size)
    {
        console.log("fillcoldmeter_fromjson json from fetch:" + JSON.stringify(json));
        $('#cm_current').val(json.coldmeter.current_value);
        var clothimage_sun, clothtitle_sun, coldmeter_title_sun, asterisk_sun = "";
        const clothimage = json.coldmeter.cloth_name;
        const clothtitle = json.coldmeter.clothtitle;
        const asterisk = json.coldmeter.asterisk;
        const coldmeter_title = json.coldmeter.current_feeling;
        if (json.coldmeter_sun)
        {
            $('#cm_current_sun').val(json.coldmeter_sun.current_value);
            clothimage_sun = json.coldmeter_sun.cloth_name;
            clothtitle_sun = json.coldmeter_sun.clothtitle;
            asterisk_sun = json.coldmeter_sun.asterisk;
            coldmeter_title_sun = json.coldmeter_sun.current_feeling;
        }
        
        const laundrytitle = json.laundryidx.laundry_con_title;
        const laundryimage = json.laundryidx.laundry_con_img;
        const coldmetersize = coldmeter_size;
        asterisk_title = (asterisk == "") ? "" : `<a href="javascript:void(0)" class="info shade" ><span class="info" style="cursor: default;">${asterisk}</span>*</a>`;
        asterisk_title_sun = (asterisk_sun == "") ? "" : `<a href="javascript:void(0)" class="info sun" style="display:none"><span class="info" style="cursor: default;">${asterisk_sun}</span>*</a>`;
        const output = `<a href="javascript:void(0)" class="info currentcloth shade" ><span class="info">${clothtitle}</span><img src="<?=BASE_URL?>/images/clothes/${clothimage}" height="${coldmeter_size}" style="vertical-align: middle" /></a><a class="info shade" id="coldmetertitle" href="javascript:void(0)" ><span class="info" style="cursor: default;" onclick="redirect('https://www.02ws.co.il?section=survey.php&amp;survey_id=2&amp;lang=1&amp;email=')">לא מסכימים? הצביעו!</span>${coldmeter_title}</a>${asterisk_title} <div id="laundryidx"><a href="javascript:void(0)" class="info" ><img src="images/laundry/${laundryimage}.svg" width="36" height="36" alt="laundry" title="${laundrytitle}" /><span class="info">${laundrytitle}</span></a><div><strong></strong></div></div>`;
        const output_sun = `<a href="javascript:void(0)" class="info currentcloth sun" style="display:none"><span class="info">${clothtitle_sun}</span><img src="<?=BASE_URL?>/images/clothes/${clothimage_sun}" height="${coldmeter_size}" style="vertical-align: middle" /></a><a class="info sun" id="coldmetertitle_sun" href="javascript:void(0)" style="display:none"><span class="info" style="cursor: default;" onclick="redirect('https://www.02ws.co.il?section=survey.php&amp;survey_id=2&amp;lang=1&amp;email=')">לא מסכימים? הצביעו!</span>${coldmeter_title_sun}</a>${asterisk_title_sun}`;
        fillcoldmeter(output, output_sun);
        $('#heatindex').html(json.coldmeter.heatindex);
        $('.shade_toggle').addClass( "active" );
        $('.sun_toggle').removeClass( "active" );

    }
    function vote_cm_like()
    {
        $('#survey_id').val(2);
        var gender = getCookie('gender');
        var SendSurveyButton = "1";
        var cm_value = $('.shade_toggle').hasClass( "active" ) ? $('#cm_current').val() : $('#cm_current_sun').val();
        console.assert(cm_value!="");
        let _data = {
            SendSurveyButton: 1,
            json_res: 1,
            survey: cm_value, 
            survey_id:2
        }
        /*fetch('survey.php', {
        method: "POST",
        body: JSON.stringify(_data),
        headers: {"Content-type": "application/json; charset=UTF-8"}
        })*/  
        fetch("<?=BASE_URL?>/survey.php?SendSurveyButton=1&json_res=1&survey="+cm_value + "&survey_id=2")    
        .then(response => response.json())
        .then(data => {console.log(data);
                       $('#cm_result_msg').html(data.result.message);
                       $.colorbox({html:"<div style=\"width:320px\" class=\"white_box big\">"+data.result.message+"</div>"});
                       })
        .catch(error => console.log("vote_cm_like error:" + error));
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
    function decodeJwtResponse(token) {
        var base64Url = token.split(".")[1];
        var base64 = base64Url.replace(/-/g, "+").replace(/_/g, "/");
        var jsonPayload = decodeURIComponent(
          atob(base64)
            .split("")
            .map(function (c) {
              return "%" + ("00" + c.charCodeAt(0).toString(16)).slice(-2);
            })
            .join("")
        );
       
        return JSON.parse(jsonPayload);
      }
      function google_to_signup(){
        localStorage.setItem("g_state", "signup");
      }
      function google_to_signin(){
        localStorage.setItem("g_state", "signin");
      }
      function google_su_OnSuccess(responsePayload){
        
        var C_STARTUP_AD_INTERVAL = 5;
        var g_email = responsePayload.email;
        $('#registerform_email').val(responsePayload.email);
        $('#registerform_displayname').val(responsePayload.given_name+responsePayload.family_name);
        $('#registerform_userid').val(responsePayload.family_name);
        $("#registerform_password").val(Math.floor(100000 + Math.random() * 900000));
        
        $.ajax({
		  type: "POST",
		  url: "<?=BASE_URL?>/checkauth.php?action=register_with_google&lang="+lang+"&username="+$("#registerform_userid").val()+"&email=" + $("#registerform_email").val()+"&password="+$("#registerform_password").val()+"&user_display_name="+$("#registerform_displayname").val()+"&user_icon="+$("#chosen_user_icon").val()+"&user_nice_name="+$("#registerform_nicename").val()+"&priority="+($("#registerform_priority").is(':checked') ? 1 : 0),
                  beforeSend: function(){$(".loading").show();},
		  data: { username:$("#registerform_userid").val(),
		  	  email: $("#registerform_email").val(), 
		          password: $("#registerform_password").val(), 
		          user_display_name: $("#registerform_displayname").val(),
                          user_icon:responsePayload.picture, 
		          user_nice_name:$("#registerform_nicename").val(), 
		          priority:$("#registerform_priority").is(':checked') ? 1 : 0 }
		}).done(function( msg ) {
                  $(".loading").hide();
		  $("#registerform_result").html( msg );
		  $('#cboxClose').click();  
          startup(<?=$lang_idx?>, 10, '');
		});
      }
      function google_si_OnSuccess(response){
        var g_state = localStorage.getItem("g_state");
       
        const responsePayload = decodeJwtResponse(response.credential);
        var C_STARTUP_AD_INTERVAL = 3;
        console.log("ID: " + responsePayload.sub);
        console.log('Full Name: ' + responsePayload.name);
        console.log('Given Name: ' + responsePayload.given_name);
        console.log('Family Name: ' + responsePayload.family_name);
        console.log("Image URL: " + responsePayload.picture);
        console.log("Email: " + responsePayload.email);
        $('#chosen_user_icon').val(responsePayload.picture);
        $('#user_name').html(responsePayload.given_name);
        $('#user_icon').html('<img src="' + responsePayload.picture + '" width=40 />');
        localStorage.setItem("g_email", responsePayload.email);
        localStorage.setItem("g_name", responsePayload.given_name);
        if (g_state == "signup")
                return google_su_OnSuccess(responsePayload);
        var g_email = responsePayload.email;
                $.ajax({
            type: "GET",
            headers: {  'Access-Control-Allow-Origin': 'https://www.02ws.co.il' },
            url: "<?=BASE_URL?>/checkauth.php?action=getuser&lang=" + lang +"&reg_id=<?=$_GET['reg_id']?>"+"&email=" + g_email
        })
        .done(function( jsonstr ) {
          
           try{
                var jsonT = JSON.parse( jsonstr  );
                if (jsonT.user.approved == 1)
                    isUserAdApproved = true;
                    if (!jsonT.user.loggedin){
                toggle('notloggedin');
                    $("#user_name").html('<?=$LOGIN[$lang_idx]?>/<?=$REGISTER[$lang_idx]?>');
                    $("#chosen_user_icon").val($("#user_icon_contentbox").children().first().children().first().attr('class'));
                    if (jsonT.user.locked)
                        $("#user_name").html('<?=$USER_LOCKED[$lang_idx]?>');
                }
                else {
                    toggle('loggedin'); 
                    fillUserDetails (JSON.parse( jsonstr  ) );
                    $('#cboxClose').click();
                    if (document.getElementById('new_post_btn')){
                            $('#new_post_btn').attr('onclick','openNewPost('+lang+')');
                    }
                    startup(<?=$lang_idx?>, 10, '');
                }
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
            }
            catch (e)
            {
                console.error(e);
            } 
        });
        }
    function google_si_onFailure()
    {
        console.log('google login failed ');  
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
        $("#latestdewpoint").show();
        $("#latestradiation").show();
        $("#latestuv").show();
        $("#latestairq").show();
        $("#latestrunwalk").show();
        $("#mainadsense").hide();
        $(".inparamdiv").css({"background": "rgba(255,255,255,0.9)"});
        $(".inparamdiv").css({"position": "absolute"});
        $("#now_stuff").css({"margin-top": "170px"});
        $("#cover_clouds-4").hide();
        $("#logo").css({"z-index": "1"});
        $(".info_btns").hide();
        $(".main_nav").hide();
        var mq = window.matchMedia( "(min-width: 1400px)" );
        if (mq.matches) {
         
          $("#latestnow").animate({
    left: "-1400px",
    top: "-100px"
        }, 1500 );
        
        $("#latesttemp").animate({
    left: "-1000px",
    top: "-100px"
        }, 1600 );
        
        $("#latesttemp2").animate({
    left: "-1400px",
    top: "400px"
        }, 2000 );
        $("#latesttemp3").animate({
    left: "-1400px",
    top: "150px"
        }, 1800 );
        $("#latestmoon").animate({
    left: "100px",
    top: "1100px"
        }, 1800 );
        
        $("#latesthumidity").animate({
    left: "-600px",
    top: "-100px"
        }, 1700 );
        
        $("#latestpressure").animate({
    left: "-250px",
    top: "-100px"
        }, 2000 );
        
        $("#latestwind").animate({
    left: "100px",
    top: "800px"
        }, 1400 );
        
        $("#latestrain").animate({
    left: "100px",
    top: "-100px"
        }, 1800 );
        
        $("#latestradiation").animate({
    left: "100px",
    top: "150px"
        }, 1200 );
        
        $("#latestuv").animate({
    left: "100px",
    top: "400px"
        }, 1400 );
        
        $("#latestairq").animate({
    left: "100px",
    top: "600px"
        }, 1900 );

       $("#latestrunwalk").animate({
    left: "-1000px",
    top: "150px"
        }, 1500 );

        $("#latestdewpoint").animate({
    left: "-1400px",
    top: "600px"
        }, 1500 );
        }
        //small screen
        else{
         $("#now_stuff").animate({
    left: "-460px",
    top: "-65px"
        }, 1500 );
        $("#latestnow").animate({
    left: "-800px",
    top: "-100px"
        }, 2000 );
        
        $("#latesttemp").animate({
    left: "-600px",
    top: "-100px"
        }, 1800 );
        
        $("#latesttemp2").animate({
    left: "-800px",
    top: "150px"
        }, 1900 );
        
        $("#latesthumidity").animate({
    left: "-200px",
    top: "-100px"
        }, 1700 );
        
        $("#latestpressure").animate({
    left: "0",
    top: "-100px"
        }, 1600 );
        
        $("#latestwind").animate({
    left: "300px",
    top: "800px"
        }, 1500 );
        
        $("#latestrain").animate({
    left: "-600px",
    top: "100px"
        }, 2000 );
        
        $("#latestradiation").animate({
    left: "-400px",
    top: "100px"
        }, 1400 );
        
        $("#latestuv").animate({
    left: "-200px",
    top: "100px"
        }, 1200 );
        
        $("#latestairq").animate({
    left: "0px",
    top: "100px"
        }, 1000 );

        $("#latestrunwalk").animate({
    left: "-200px",
    top: "420px"
        }, 2000 ).css("z-index", "99999");
        $("#latestdewpoint").animate({
    left: "-400px",
    top: "100px"
        }, 1000 ).css("z-index", "99999");
        }
       
         
   }
   function closeAllCircles()
   {
    $("#latestnow, #latestairq, #latestdewpoint, #latestuv, #latestradiation, #latestrain, #latestwind, #latestpressure, #latesthumidity, #latesttemp2, #latesttemp, #latesttemp3, #latestnow, #latestrunwalk").animate({
    left: "-400",
    top: "0"
        }, 2000 , function() {
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
        $("#latestrunwalk").hide();
        $("#latestmoon").hide();
        $("#latestdewpoint").hide();
        $("#latestotherstations").hide();
        $("#mainadsense").show();
        
  }); 
}
  
function startup(lang, from, update)
     {
           
       $("#current_forum_filter").val($("#forum_filter").children().first().attr('class'));
       $("#current_forum_filter").attr('data-key',$("#forum_filter").children().first().attr('data-key'));
       var cur_feel_link=document.getElementById('current_feeling_link');
       var email_i = "";
        if ('<?=$_GET['email']?>' != '')
            email_i = '<?=$_GET['email']?>';
       g_email = localStorage.getItem("g_email");
       console.log("logged in google account: " + g_email); 
       if ((email_i == "")&&(g_email != "")&&(g_email != null)&&g_email)
            email_i = g_email;  
       /*if (typeof coldmeter_size == 'undefined') 
          coldmeter_size = 60;
       if (cur_feel_link)
       {
              fetch("<?=BASE_URL?>/coldmeter_service.php?lang=<?=$lang_idx?>&json=1&cloth_type=e",{
                timeout: 3000
                })
                .then(response => response.json())
                .then(data => fillcoldmeter_fromjson(data, coldmeter_size))
                .catch(error => console.log("error:" + error))
                
         }*/
        
        $.ajax({
            type: "GET",
            headers: {  'Access-Control-Allow-Origin': 'https://www.02ws.co.il' },
            url: "<?=BASE_URL?>/checkauth.php?action=getuser&lang=" + lang +"&reg_id=<?=$_GET['reg_id']?>"+"&email=" + email_i
        })
        .done(function( jsonstr ) {
            try{
                var jsonT = JSON.parse( jsonstr  );
                if (jsonT.user.approved == 1)
                    isUserAdApproved = true;
                if (!jsonT.user.loggedin){
                    toggle('notloggedin');
                    $("#user_name").html('<?=$LOGIN[$lang_idx]?>/<?=$REGISTER[$lang_idx]?>');
                    $("#chosen_user_icon").val($("#user_icon_contentbox").children().first().children().first().attr('class'));
                    if (jsonT.user.locked)
                        $("#user_name").html('<?=$USER_LOCKED[$lang_idx]?>');
                }
                else {
                    toggle('loggedin'); 
                    fillUserDetails (JSON.parse( jsonstr  ) );
                    if (document.getElementById('new_post_btn')){
                            $('#new_post_btn').attr('onclick','openNewPost('+lang+')');
                    }
                }
                if (document.getElementById('forum')){
                    fillMessage('<img src="<?=BASE_URL?>/img/loading.gif" alt="loading" width="50" height="50"/>');
                    $.ajax({
                        type: "POST",
                        crossDomain: true,
                            headers: {  'Access-Control-Allow-Origin': '*' },
                        url: "<?=BASE_URL?>/chat_service.php?lang="+lang+"&from="+from+"&update="+update,
                        data: {lang:lang, from:from, update:update},
                    })
                    .done(function(str){fillMessage(str);});
                }
            }
            catch (e) {
                console.log("error:" + e);
            }
        });
        attachEnter();
     }


     function getLatest(city, station_id, station_type) {
        var that = this;
        var formData = new FormData();
        formData.append("wu_station_id", station_id);
        formData.append("ims_station_id", station_id);
        formData.append("StationType", station_type);
        formData.append("city", city);
            $.ajax({
                type: "POST",
                url: "<?=BASE_URL?>/IsraelNowService.php",
                xhr: function () {
                    var myXhr = $.ajaxSettings.xhr();
                    if (myXhr.upload) {
                        myXhr.upload.addEventListener('progress', that.progressHandling, false);
                    }
                    return myXhr;
                },
                beforeSend: function(){$(".loading").show();},
                success: function (data) {
                    $(".loading").hide();
                    if ((station_type == "IMS")||(station_type == "IMS2"))
                    $("#ImsNowRes").append(data);
                    else
                    $("#WUNowRes").append(data);
                    if (($("#ImsNowRes_short").text().length < 90)&&(station_type == "IMS"))
                        $("#ImsNowRes_short").append(data);
                    else if (($("#WUNowRes_short").text().length < 90)&&(station_type == "WU"))
                        $("#WUNowRes_short").append(data);
                    
                },
                error: function (error) {
                    $("#ImsNowRes").append(error);
                },
                async: true,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                timeout: 60000
            });
        };   
   

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
            tinymce.init({selector:'textarea',menubar : false, height : "80px", theme: "modern", skin: 'light', forced_root_block : false, directionality : dir, execcommand_callback: "tinyExecCommand", valid_elements: "*[*]", extended_valid_elements : 'iframe[title|class|type|width|height|src|frameborder|allowFullScreen]', content_css : "css/main.php?lang=<?=$lang_idx?>", language: 'he_IL', statusbar: false, toolbar: "emoticons | styleselect | bullist numlist | link image | bold italic | preview | code",plugins : 'autolink advlist link image emoticons media preview code table save '});
            
            
            
     }
     function forummonth_goto_byselect(sel)
     {
        var index = sel.selectedIndex;
        if (sel.options[index].value != '') {
        var arr = sel.options[index].value.split("/");
        var month = arr[0]; var year = arr[1]; 
        var category = localStorage.getItem("category");
         getMessageService('01' + month.toString() + year.toString(), '31' + month.toString() + year.toString(), 0, 0,  <?=$lang_idx?>,'');
        }
        else {}
     }
     function getActivityTitle(activity, lang, act_json, add_on){
        for (j = 0; j< act_json.jws.Activities.length; j++){
            if (act_json.jws.Activities[j].name == activity){
                if (lang == 0)
                    return add_on + ' ' + act_json.jws.Activities[j].title0;
                else
                    return add_on + ' ' + act_json.jws.Activities[j].title1;
            }

        }
       
     }
     function getActivityDesc(activity, lang, act_json, add_on){
        for (j = 0; j< act_json.jws.Activities.length; j++){
            if (act_json.jws.Activities[j].name == activity){
                if (lang == 0)
                    return add_on + '<br/>' + act_json.jws.Activities[j].lang0;
                else
                    return add_on + '<br/>' + act_json.jws.Activities[j].lang1;
            }

        }
       
     }
     function fillactivities(act_json, all_json){
        var activities_yes = "", activities_no = "";
       for (i = 0; i< all_json.jws.current.recommendations.length; i++){
        var act_container = 'latest_' + all_json.jws.current.recommendations[i].activity.toLowerCase();
        $('#' + act_container + ' .exp').html(getActivityDesc(all_json.jws.current.recommendations[i].activity, <?=$lang_idx?>, act_json, all_json.jws.current.recommendations[i].sig<?=$lang_idx?>));
        $('#' + act_container + ' .paramtitle').html(getActivityTitle(all_json.jws.current.recommendations[i].activity, <?=$lang_idx?>, act_json, (all_json.jws.current.recommendations[i].value == 1)? '<?=$NOT_GOOD_TIME_FOR[$lang_idx]?>' : ''));
          if (all_json.jws.current.recommendations[i].value == 1)
            activities_yes += "<li id=\"" + all_json.jws.current.recommendations[i].activity.toLowerCase() + "_btn\" class=\"span-value\"  data-value=\"" + getActivityTitle(all_json.jws.current.recommendations[i].activity, <?=$lang_idx?>, act_json, '') + "\"  onclick=\"change_circle('" + all_json.jws.current.recommendations[i].activity.toLowerCase() + "', '" + act_container + "')\"><img src=\"images/activities/" + all_json.jws.current.recommendations[i].activity.toLowerCase() + ".png\" width=\"25\" height=\"25\" /></li>" ;
         else
            activities_no += "<li id=\"" + all_json.jws.current.recommendations[i].activity.toLowerCase() + "_btn\" class=\"no span-value\" data-value=\"" + getActivityTitle(all_json.jws.current.recommendations[i].activity, <?=$lang_idx?>, act_json, '') + "\" onclick=\"change_circle('" + all_json.jws.current.recommendations[i].activity.toLowerCase() + "', '" + act_container + "')\"><img src=\"images/activities/" + all_json.jws.current.recommendations[i].activity.toLowerCase() + ".png\" width=\"25\" height=\"25\" /></li>"  ;
       }
      // $('#bottombar').html(activities_yes+activities_no);
        $('#activities_yes').html(activities_yes);
        $('#activities_no').html(activities_no);
        $('#activities_perhour').empty();
        for (hour_idx = 0; hour_idx< all_json.jws.forecastHours.length; hour_idx++){
            activities_yes = "";activities_no = "";
            for (i = 0; i< all_json.jws.forecastHours[hour_idx].recommendations.length; i++){
                var act_container = 'latest_' + all_json.jws.forecastHours[hour_idx].recommendations[i].activity.toLowerCase();
                $('#' + act_container + ' .exp').html(getActivityDesc(all_json.jws.forecastHours[hour_idx].recommendations[i].activity, <?=$lang_idx?>, act_json, all_json.jws.forecastHours[hour_idx].recommendations[i].sig<?=$lang_idx?>));
                $('#' + act_container + ' .paramtitle').html(getActivityTitle(all_json.jws.forecastHours[hour_idx].recommendations[i].activity, <?=$lang_idx?>, act_json, ''));
                if (all_json.jws.forecastHours[hour_idx].recommendations[i].value == 1)
                    activities_yes += "<li id=\"" + all_json.jws.forecastHours[hour_idx].recommendations[i].activity.toLowerCase() + "_btn\" class=\"span-value\"  data-value=\"" + getActivityTitle(all_json.jws.forecastHours[hour_idx].recommendations[i].activity, <?=$lang_idx?>, act_json) + "\"  onclick=\"change_circle('" + all_json.jws.forecastHours[hour_idx].recommendations[i].activity.toLowerCase() + "', '" + act_container + "')\"><img src=\"images/activities/" + all_json.jws.forecastHours[hour_idx].recommendations[i].activity.toLowerCase() + ".png\" width=\"25\" height=\"25\" /></li>" ;
                else
                    activities_no += "<li id=\"" + all_json.jws.forecastHours[hour_idx].recommendations[i].activity.toLowerCase() + "_btn\" class=\"no span-value\" data-value=\"" + getActivityTitle(all_json.jws.forecastHours[hour_idx].recommendations[i].activity, <?=$lang_idx?>, act_json) + "\" onclick=\"change_circle('" + all_json.jws.forecastHours[hour_idx].recommendations[i].activity.toLowerCase() + "', '" + act_container + "')\"><img src=\"images/activities/" + all_json.jws.forecastHours[hour_idx].recommendations[i].activity.toLowerCase() + ".png\" width=\"25\" height=\"25\" /></li>"  ;
            }

            $('#activities_perhour').append("<ul style=\"display:none\" class=\"activity\" id=\"activities_yes" + hour_idx + "\"></ul>");
            $('#activities_perhour').append("<ul style=\"display:none\" class=\"activity\" id=\"activities_no" + hour_idx + "\"></ul>");
            $('#activities_yes' + hour_idx).html(activities_yes);
            $('#activities_no' + hour_idx).html(activities_no);
        }
        
     }
     
     function getWindInfo(windspeed){
        var wind_class = "";
        var wind_img = "";
        if (windspeed > 60){
           wind_class="high_wind";
           wind_img = "wind2.svg";
       }

      else if (windspeed > 30){
          wind_class="high_wind";
          wind_img = "wind2.svg";
       }

      else if (windspeed > 15){
          wind_class="moderate_wind";
          wind_img = "wind1.svg";
       }
     else{
          wind_class="light_wind";
          wind_img = "wind0.svg";
       }
       return [wind_class, wind_img];
   }
       
function redirect_to_mobile(lang){
    var loc = document.URL;
    top.location.href="small/?lang="+lang;
}
function redirect_to_desktop(lang){
    var loc = document.URL;
    top.location.href="<?=BASE_URL?>/station.php?section=frommobile&lang="+lang;
}
function isOnMobilePage(){
    var loc = document.URL;
    return(loc.indexOf('small') > 0);
}
// Function to be called when the banner is in view
function handleIntersection(entries, observer) {
    entries.forEach(entry=>{
        if ((entry.isIntersecting)&&(entry.target.scrollHeight > 0)) {
            // Banner is fully visible, you can perform actions here
            console.log("Banner " + entry.target.id + " is visible! new_session=" + new_session);
            saveCount(entry.target.id, entry.target.attributes.idx.value);
            // Unobserve the banner since you're done with the observation
            observer.unobserve(entry.target);
        }
    }
    );
}

function saveCount(id, idx){
    var count = parseInt(localStorage.getItem("Banner" + idx + "Count"));
    localStorage.setItem("Banner" + idx + "Count", ++count);
    fetch("https://www.02ws.co.il/ads.php?debug=0&type=updatecounts&idx=" + idx,{
                timeout: 3000
                })
                .then(response => response.json())
                .then(data => console.log("banner " +  id + " index=" + idx + " count=" + data.count))
                .catch(error => console.log("error in saveCount:" + error))
    
}

function loadPostData(jsonstr, coldmeter_size)
	{
            var C_STARTUP_AD_INTERVAL = 5;
		
        if (jsonstr  != undefined)
            fillcoldmeter_fromjson(jsonstr, coldmeter_size);
            $('#latestalert').css('visibility', 'visible');
            $('#arrowdown').show();
            
            $(".loading").hide();
        <?if ($_GET['reg_id'] != "") {?>
        $.ajax({
            type: "GET",
            url: "<?=BASE_URL?>/checkauth.php?action=getuser&reg_id=<?=$_GET['reg_id']?>&qs=<?=$_SERVER['QUERY_STRING']?>&email=<?=$_GET['email']?>"
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
            $("#if2").show();
            $("#if3").show();
            $("#if4").show();
        }
        else 
        {
            $("#if1").show();
            $("#if2").show();
            $("#if3").show();
            $("#if4").show();
            
        }

        if (isMobile.iOS()){
          //  $(".removeadlink a").attr("href", "https://www.patreon.com/02ws");
          //  $(".removeadlink a").attr("target", "_blank");

        }
        // Check if sessionStorage has a session identifier
        if (!sessionStorage.getItem('sessionId')) {
        // Generate a random session identifier and store it in sessionStorage
        const sessionId = Math.random().toString(36).substring(2);
        sessionStorage.setItem('sessionId', sessionId);
        new_session = true;
        console.log('New session started. Session ID:', sessionId);
        } else {
        // Session identifier already exists in sessionStorage
        const storedSessionId = sessionStorage.getItem('sessionId');
        console.log('Existing session. Session ID:', storedSessionId);
        }
        // Create an observer instance
        const observer = new IntersectionObserver(handleIntersection, {
        root: null, // Use the viewport as the root
        threshold: 1.0, // Fully visible threshold
        });
        const banner = document.getElementById('if1');
         observer.observe(banner);
         const banner2 = document.getElementById('if2');
         observer.observe(banner2);
         const banner3 = document.getElementById('if3');
         observer.observe(banner3);     
         const banner4 = document.getElementById('if4');
         observer.observe(banner4);     
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
    function getClass(name, json){
        //<li>130</li><li>300</li></ul></li>
        //<li>38</li><li>100</li></ul></li>
        if (name == 'pm10')
        {
            if (json.jws.current.pm10 > 300)
                return "red";
            if (json.jws.current.pm10 > 130)
                return "orange";
            return "green";
        }
        else
        {
            if (json.jws.current.pm25 > 100)
                return "red";
            if (json.jws.current.pm25 > 38)
                return "orange";
            return "green";
        }
        return "";
    }
    function getWidth(name, json){
        var percDust;
        if (name == 'pm10')
        {
            percDust = (json.jws.current.pm10/300)*100;
            if (percDust > 100) {percDust = 100;}
            return percDust+"%";
        }
        else
        {
            percDust = (json.jws.current.pm25/100)*100;
            if (percDust > 100) {percDust = 100;}
            return percDust+"%";
        }
       return "30%";
    }
    function loadData(json)
    {
        var cssstyle_str = "";  
        $('link[rel=stylesheet][title=mystyle]').remove();
        //loadCSS("css/main.php?lang=<?=$lang_idx;?>", document.getElementById('loadGA'));
        if (json.jws.current.issunset == 1) { 
            cssstyle_str += "sunset"; 
            loadCSS("<?=BASE_URL?>/css/sunset.min.css", document.getElementById('loadGA'));
       }
       if (json.jws.current.issunrise == 1) { 
                cssstyle_str += "sunrise"; 
                loadCSS("<?=BASE_URL?>/css/sunrise.min.css", document.getElementById('loadGA'));
        } 
       if ((json.jws.current.islight == 1)&&(json.jws.current.cloudiness > 6)) { 
                cssstyle_str += ",cloudy"; 
                loadCSS("<?=BASE_URL?>/css/cloudy.min.css", document.getElementById('loadGA'));
        }
       if (json.jws.current.pm10 > 300) { 
                cssstyle_str += ",dust"; 
                loadCSS("<?=BASE_URL?>/css/dust.min.css", document.getElementById('loadGA'));
        } 
       if (json.jws.current.islight == '') { 
            cssstyle_str += ",night";
            loadCSS("<?=BASE_URL?>/css/night<? echo $lang_idx;?>.min.css", document.getElementById('loadGA')); 
           if (json.jws.current.pm10 > 300) { 
               cssstyle_str += ",dust-night"; 
               loadCSS("<?=BASE_URL?>/css/dust-night.min.css", document.getElementById('loadGA'));
           }
       }
      if (json.jws.states.israining == 1){ 
            cssstyle_str += ",rain"; 
            loadCSS("<?=BASE_URL?>/css/rain.min.css", document.getElementById('loadGA'));
    }
      if (json.jws.states.issnowing == 1) { 
            if (json.jws.current.islight){ 
                cssstyle_str += ",snow"; 
                loadCSS("<?=BASE_URL?>/css/snow.min.css", document.getElementById('loadGA'));
           } else { 
                cssstyle_str += ",snow_night"; 
                loadCSS("<?=BASE_URL?>/css/snow_night.min.css", document.getElementById('loadGA'));
           } 
      }
      cssstyle_str += ",mobile";
        var tempunit = getParameterByName('tempunit');
        if ((tempunit == '°Fnull')||(tempunit == '°F'))
            tempunit = 'F';
        else if (tempunit.indexOf("C") > 0)
            tempunit = 'C';
        
        var latestalerttext = decodeURIComponent(json.jws.Messages.latestalert<?=$lang_idx?>).replace(/\+/g, ' ');
        var latest_user_pic = "<a href=\"<?=$_SERVER['SCRIPT_NAME']?>?section=userPics&amp;lang=<?=$lang_idx."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c'];?>\"><img src=\"" +  json.jws.LatestUserPic[0].picname + "\" width=\"320\" title=\"userpic\" /></br>" + decodeURIComponent(json.jws.LatestUserPic[0].name.replace(/\+/g, " ")) + ": " + decodeURIComponent(json.jws.LatestUserPic[0].comment.replace(/\+/g, " ")) + "</a>&nbsp;&nbsp;";      
        var latest_pic_of_the_day = "<div class=\"txtindiv\"><?=$PIC_OF_THE_DAY[$lang_idx]?>" + "<br/>" + decodeURIComponent(json.jws.LatestPicOfTheDay.caption<?=$lang_idx?>.replace(/\+/g, " ")) + "</div><a href=\"<?=$_SERVER['SCRIPT_NAME']?>?section=picoftheday.php&amp;lang=<?=$lang_idx."&amp;fullt=".$_GET['fullt']."&amp;s=".$_GET['s']."&amp;c=".$_GET['c'];?>\"><img src=\"" +  json.jws.LatestPicOfTheDay.picurl + "\" width=\"320\" title=\"pic of the day\" /></a>";
        var latest_pic_of_the_day_text = "<a href=\"javascript:void(0)\" class=\"info\" ><div class=\"title\">" + decodeURIComponent(json.jws.LatestPicOfTheDay.caption<?=$lang_idx?>.replace(/\+/g, " ")).substring(0, 30) + "...</div>" + "<span class=\"info\"> <div class=\"\"><?=$PIC_OF_THE_DAY[$lang_idx]?>: " + decodeURIComponent(json.jws.LatestPicOfTheDay.caption<?=$lang_idx?>.replace(/\+/g, " ")) + "</div><img src=\"" +  json.jws.LatestPicOfTheDay.picurl + "\" width=\"320\" title=\"pic of the day\" /></span></a>";
        var alerts = "";
        var ImgOrVid = "";
        for (i = 0; i< json.jws.Messages.alerts.length; i++){
            ImgOrVid = "";
            var cur_alert = json.jws.Messages.alerts[i];
            var date = new Date(cur_alert.ts * 1000);
            var dateStr = date.toLocaleString('he-IL', { weekday: 'narrow' }) + ' ' + date.toLocaleString('he-IL');
            if ((cur_alert.img_src != "")&&(cur_alert.img_src != "null"))
            {
                ImgOrVid = (cur_alert.img_src.indexOf("mp4") > 0) ? "<video width=\"310\" height=\"240\" controls><source src=\""+ cur_alert.img_src + "\" type=\"video/mp4\"></video><br/>" : "<a hre=\"" + cur_alert.img_src + "\"><img src=\"" + cur_alert.img_src + "\" width=\"320\" /></a><br/>"
            }
            var should_display = true;
            if (cur_alert.ttl > 0){
                should_display =  ((cur_alert.ttl*60) - cur_alert.passedts > 0) ? true : false;
            }
                
            if (should_display)
                 alerts += '<h3>' + decodeURIComponent(cur_alert.title<?=$lang_idx?>).replace(/\+/g, ' ') + '</h3>'
                                                + dateStr + '<br/>'
                                                + ImgOrVid 
                                                + decodeURIComponent(cur_alert.desc<?=$lang_idx?>).replace(/\+/g, ' ').replace(/(\r\n|\r|\n)/g, '<br/>');
        }

        alerts += '<br/><br/>' + json.jws.Messages.tip<?=$lang_idx?>;
        $('#alerts').children('#message').html(alerts);
        $('#tempdivvalue, #tempdivvaluestart').html('<div class="shade">' + ((json.jws.current.islight == 1) ? "" : "") + '</div>' + c_or_f(json.jws.current.temp, tempunit)+'<div class="param">'+tempunit+'</div>').removeClass('glow');
        $('#tempdivvalue').css('visibility', 'visible').addClass('glow');
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
                coldmeter_size = 80;
         if (cur_feel_link)
         {
            $(".loading").show();
            fetch("coldmeter_service.php?lang=<? echo $lang_idx;?>&json=1&cloth_type=e",{
                timeout: 3000
                })
                .then(response => response.json())
                .then(data => loadPostData(data, coldmeter_size))
                .catch(error => console.log("error:" + error))
        } else loadPostData();
        
        $("#itfeels").show();$("#itfeels_thsw").hide();$("#itfeels_windchill").hide();$("#itfeels_heatidx").hide();$("#itfeels_thw").hide();
        if (json.jws.current.issun == "true")
        {
            $("#itfeels_thsw .value").html(c_or_f(json.jws.current.thsw, tempunit) + "");$(".sunshade").show();$("#itfeels_thsw").show();
        }
        
        if (json.jws.feelslike.state == "windchill")
            {$("#itfeels_windchill").show();$("#itfeels_windchill .value").html(c_or_f(json.jws.feelslike.avg, tempunit) + "")}
        else if (json.jws.feelslike.state == "heatindex")
            {$("#itfeels_heatidx").show();$("#itfeels_heatidx .value").html(c_or_f(json.jws.feelslike.avg, tempunit) + "")}
        else
            $("#itfeels_thw").show(); 
        $('.rainpercent').html((json.jws.current.rainchance > 0 ? (json.jws.current.rainchance + '%') : ''));
        if (json.jws.states.sigweather.length > 1)
        $('#what_is_h, #what_is_h_start ').html(json.jws.states.sigweather[0].sigtitle<? echo $lang_idx;?> + " - " + json.jws.states.sigweather[0].sigexthtml<? echo $lang_idx;?> +
                                 '&nbsp;&nbsp;<span class=\"arrow_down\">&#9660;</span>&nbsp;&nbsp;'
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
        $("#latesttemp .trendstable .trendsvalues .innertrendvalue").eq(3).html(json.jws.min15.tempchange.split(",")[2]);
        //$("#latesttemp .paramtrend .innertrendvalue").html(json.jws.min15.minutes + " " + "<?=$MINTS[$lang_idx]?>: " + json.jws.min15.tempchange.split(",")[2]);
        $("#latesttemp2 .paramvalue").html(c_or_f(json.jws.current.temp2, tempunit)+'<div class="param">'+tempunit+'</div>' + '&nbsp;<div class="param"><span id=\"valleytemp\" title=\"\">'+ title_temp2 + '</span></div>');
        $("#latesttemp2 .highlows .highparam").html('<strong>' + c_or_f(json.jws.today.hightemp2, tempunit) + '</strong>');
        $("#latesttemp2 .highlows .high_time").html(json.jws.today.hightemp2_time);
        $("#latesttemp2 .highlows .lowparam").html('<strong>' + c_or_f(json.jws.today.lowtemp2, tempunit) + '</strong>');
        $("#latesttemp2 .highlows .low_time").html(json.jws.today.lowtemp2_time);
        $("#latesttemp2 .trendstable .trendsvalues .innertrendvalue").eq(0).html(json.jws.yestsametime.temp2change.split(",")[2]);
        $("#latesttemp2 .trendstable .trendsvalues .innertrendvalue").eq(1).html(json.jws.oneHour.temp2change.split(",")[2]);
        $("#latesttemp2 .trendstable .trendsvalues .innertrendvalue").eq(2).html(json.jws.min30.temp2change.split(",")[2]);
        $("#latesttemp2 .trendstable .trendsvalues .innertrendvalue").eq(3).html(json.jws.min15.temp2change.split(",")[2]);
        //$("#latesttemp2 .paramtrend .innertrendvalue").html(json.jws.min15.minutes + " " + "<?=$MINTS[$lang_idx]?>: " + json.jws.min15.temp3change.split(",")[2]);
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
        //$("#latesttemp3 .paramtrend .innertrendvalue").html(json.jws.min15.minutes + " " + "<?=$MINTS[$lang_idx]?>: " + json.jws.min15.temp3change.split(",")[2]);
        if (json.jws.current.islight == 1)
            $("#temp3_desc").html(json.jws.desc.temp3_desc<?=$lang_idx?>);
        else
            $("#temp3_desc").html(json.jws.desc.temp3_night_desc<?=$lang_idx?>);
        $("#latesthumidity .paramvalue").html(json.jws.current.hum+'&nbsp;<div class="param">%</div><div class="param small valley"><?=$VALLEY[$lang_idx]?>:' + json.jws.current.hum2 + '%</div>');
        $("#latesthumidity .highlows .highparam").html('<strong>' + json.jws.today.highhum + '</strong>');
        $("#latesthumidity .highlows .high_time").html(json.jws.today.highhum_time);
        $("#latesthumidity .highlows .lowparam").html('<strong>' + json.jws.today.lowhum + '</strong>');
        $("#latesthumidity .highlows .low_time").html(json.jws.today.lowhum_time);
        $("#latesthumidity .trendstable .trendsvalues .innertrendvalue").eq(0).html(json.jws.yestsametime.humchange.split(",")[2]);
        $("#latesthumidity .trendstable .trendsvalues .innertrendvalue").eq(1).html(json.jws.oneHour.humchange.split(",")[2]);
        $("#latesthumidity .trendstable .trendsvalues .innertrendvalue").eq(2).html(json.jws.min30.humchange.split(",")[2]);
        $("#latesthumidity .trendstable .trendsvalues .innertrendvalue").eq(3).html(json.jws.min15.humchange.split(",")[2]);
        //$("#latesthumidity .paramtrend .innertrendvalue").html(json.jws.min15.minutes + " " + "<?=$MINTS[$lang_idx]?>: " + json.jws.min15.humchange.split(",")[2]+"%");
        $("#latestdewpoint .paramvalue").html(c_or_f(json.jws.current.dew, tempunit));
        $("#latestdewpoint .highlows .highparam").html('<strong>' + json.jws.today.highdew + '</strong>');
        $("#latestdewpoint .highlows .high_time").html(json.jws.today.highdew_time);
        $("#latestdewpoint .highlows .lowparam").html('<strong>' + json.jws.today.lowdew + '</strong>');
        $("#latestdewpoint .highlows .low_time").html(json.jws.today.lowdew_time);
        $("#latestdewpoint .trendstable .trendsvalues .innertrendvalue").eq(0).html(json.jws.yestsametime.dewchange.split(",")[2]);
        $("#latestdewpoint .trendstable .trendsvalues .innertrendvalue").eq(1).html(json.jws.oneHour.dewchange.split(",")[2]);
        $("#latestdewpoint .trendstable .trendsvalues .innertrendvalue").eq(2).html(json.jws.min30.dewchange.split(",")[2]);
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
		$("#latestairq #aqvalues").html("<ul><li class=\"line title\"><ul><li class=\"theshhold_spacer\"></li><li class=\"dustexp\"><?=$DUST_THRESHOLD0[$lang_idx]?></li><li class=\"dustexp\"><?=$DUST_THRESHOLD1[$lang_idx]?></li><li class=\"dustexp\"><?=$DUST_THRESHOLD2[$lang_idx]?></li></ul></li>" +
                             "<li class=\"line\" title=\"&plusmn;"+json.jws.current.pm10sd+"\"><ul><li class=\"dusttitle\"><?=$DUSTPM10[$lang_idx]?></li><li class=\"y-axis-bar-item-container\" style=\"width: 70%\"><div class=\"y-axis-bar-item "  + getClass('pm10', json) + "\" style=\"width: " + getWidth('pm10', json) + "\"><span class=\"number\">" + json.jws.current.pm10 + "</span>&nbsp;<span class=\"small\">µg/m3</span></div></li></ul></li>" +
                             "<li class=\"line\" title=\"&plusmn;"+json.jws.current.pm25sd+"\"><ul><li class=\"dusttitle\"><?=$DUSTPM25[$lang_idx]?></li><li class=\"y-axis-bar-item-container\" style=\"width: 70%\"><div class=\"y-axis-bar-item " + getClass('pm25', json) + "\" style=\"width: " + getWidth('pm25', json) + "\"><span class=\"number\">" + json.jws.current.pm25 + "</span>&nbsp;<span class=\"small\">µg/m3</span></div></li></ul></li>" +
                             "<li class=\"y-axis-bar-item-container dustexp\" style=\"width: 80%\"><?=$DUST_THRESHOLD3[$lang_idx]?></li>" +
                             "</ul>");
        $("#latestairq .trendstable .trendsvalues .innertrendvalue").eq(0).html(json.jws.yestsametime.pm10change.split(",")[2]);
        $("#latestairq .trendstable .trendsvalues .innertrendvalue").eq(1).html(json.jws.oneHour.pm10change.split(",")[2]);
        $("#latestairq .trendstable .trendsvalues .innertrendvalue").eq(2).html(json.jws.min30.pm10change.split(",")[2]);
        $("#latestwindow .paramtitle").html(json.jws.states.windowtitle<?=$lang_idx?>);
        $("#latestwindow .highlows").html(json.jws.states.windowdesc<?=$lang_idx?>);
        var sigweatherstates = "";
        sigweatherstates += "<li><button type=\"button\" id=\"xClose\" style=\"background-image: url(../img/close.png); border: none;height: 32px;width: 32px;<?=get_inv_s_align()?>: 5px;position: absolute;top: 5px\" onclick=\"$( '#sigweather' ).hide();\"></button></li>";
        for (i = 0; i< json.jws.states.sigweather.length; i++){
            sigweatherstates += "<li><a href=\"" + json.jws.states.sigweather[i].url + "\" >" + json.jws.states.sigweather[i].sigtitle<?=$lang_idx?> + " - " +  json.jws.states.sigweather[i].sigexthtml<?=$lang_idx?> + '<? echo get_arrow();?>' + "</a></li>";
        }
        $('#sigweather').html(sigweatherstates);
        var cclass, sigRunWalkweatherstates = "";
       for (i = 1; i< json.jws.sigRunWalkweather.length; i++){
        if (i == 1) cclass = "class=\"windhumsituation\""; else cclass = "";  
            sigRunWalkweatherstates += "<li " + cclass + "><a href=\"" + json.jws.sigRunWalkweather[i].url + "\" >" + json.jws.sigRunWalkweather[i].sigtitle<?=$lang_idx?> + " <br/> " +  json.jws.sigRunWalkweather[i].sigext<?=$lang_idx?> + '' + "</a></li>";
        }
        var firstlinerunwalk = "";
        if (json.jws.current.solarradiation < 50)
             firstlinerunwalk = "<li class=\"firstlinerunwalk\"><span class=\"number\">" +c_or_f(json.jws.current.temp2, tempunit) + '-' + c_or_f(json.jws.current.temp, tempunit)+'<div class="param">'+tempunit+'</div></span>' + '&nbsp;<span id=\"valleytemprunwalk\" title=\"\">'+ title_temp + '</span>' + '&nbsp;&nbsp;&nbsp;&nbsp;<span class=\"number\">' + c_or_f(json.jws.current.temp3, tempunit)+'<div class="param">'+tempunit+'</div></span>' + '&nbsp;<span id=\"mtemprunwalk\" title=\"\">'+ title_temp2 + '</span></li>';
        else
            firstlinerunwalk = "<li class=\"firstlinerunwalk\"><span class=\"number\">" + c_or_f(json.jws.current.temp, tempunit)+'<div class="param">'+tempunit+'</div></span>' + '&nbsp;<span id=\"valleytemprunwalk\" title=\"\">'+ title_temp + '</span>' + '&nbsp;&nbsp;&nbsp;&nbsp;<span class=\"number\">' + c_or_f(json.jws.current.temp2, tempunit)+'<div class="param">'+tempunit+'</div></span>' + '&nbsp;<span id=\"mtemprunwalk\" title=\"\">'+ title_temp2 + '</span></li>';
       $("#latestrunwalk .exp").html("<ul>"+firstlinerunwalk+sigRunWalkweatherstates+"</ul>");
       
       var forecastHours = "";
        for (i = 0; i< json.jws.sigforecastHours.length; i++){
       
           forecastHours += "<ul class=\"nav forecasttimebox\" >";
           forecastHours += "<li class=\"tsfh currentts\" style=\"display:none\"><span>" + json.jws.sigforecastHours[i].currentDateTime + "</span></li>";
           forecastHours += "<li class=\"tsfh text timefh\"><span>" + json.jws.sigforecastHours[i].date + "</span></li>";
           forecastHours += "<li class=\"tsfh forecasttemp\"><span>" + json.jws.sigforecastHours[i].time + ":00" + (json.jws.sigforecastHours[i].plusminus > 0 ? "&nbsp;&plusmn;"+json.jws.sigforecastHours[i].plusminus : "") +"</span></li>";
           //forecastHours += "<li class=\"forecasttemp\" id=\"tempfh"+ json.jws.sigforecastHours[i].time + "\"><span>" + c_or_f(json.jws.sigforecastHours[i].temp, tempunit) + "<img style=\"vertical-align: middle\" src=\"images/clothes/"+json.jws.sigforecastHours[i].cloth+"\" height=\"15\" width=\"20\" /></span></li>";
           forecastHours += "<li style=\"padding:0;\"><div title=\"" + json.jws.sigforecastHours[i].wind_title<? echo $lang_idx;?>+"\" class=\"wind_icon "+json.jws.sigforecastHours[i].wind_class+" \"></div></li>";
           forecastHours += "<li class=\"forcast_icon\"><span><img src=\"images/icons/day/"+json.jws.sigforecastHours[i].icon+"\" height=\"30\" width=\"30\" /></span></li>";
           forecastHours += "<li class=\"forcast_title\"><span>"+json.jws.sigforecastHours[i].title<? echo $lang_idx;?>+"</span></li>";
           forecastHours += "</ul>";
       }
       var forecastHoursD = "";
       var forecastHoursNG = "";
       var max_temp = -10; var min_temp = 110;
       var max_hum = -10; var min_hum = 110;
        for (i = 0; i< json.jws.forecastHours.length; i++){
        //if (i >= json.jws.states.nowHourIndex){
            if (parseInt(json.jws.forecastHours[i].temp) > max_temp) max_temp = json.jws.forecastHours[i].temp; 
            if (parseInt(json.jws.forecastHours[i].temp) < min_temp) min_temp = json.jws.forecastHours[i].temp;
            if (json.jws.forecastHours[i].hum > max_hum) max_hum = json.jws.forecastHours[i].hum; 
            if (json.jws.forecastHours[i].hum < min_hum) min_hum = json.jws.forecastHours[i].hum;
            if ((json.jws.forecastHours[i].time % 3 == 0) || (json.jws.forecastHours[i].plusminus > 0))
            {
                var  TempCloth = '&nbsp;<a href=\"javascript:void(0)\" class=\"info\" ><img style=\"vertical-align: middle\" src=\"'+json.jws.forecastHours[i].cloth+'\" width=\"22\" height=\"22\" title=\"'+json.jws.forecastHours[i].cloth_title<? echo $lang_idx;?>+'\" alt=\"\" /><span class=\"info\">'+json.jws.forecastHours[i].cloth_title<? echo $lang_idx;?>+'</span></a>';
                forecastHoursD += "<li class=\"nav forecasttimebox\" index=\"" + i + "\" ><ul>";
                forecastHoursD += "<li class=\"plus\"><div class=\"open-close-button\" index=\"" + i + "\"></div></li>";
                forecastHoursD += "<li class=\"tsfh currentts text\" style=\"display:none\"><span>" + json.jws.forecastHours[i].currentDateTime + "</span></li>";
                var strDate = json.jws.forecastHours[i].time + ":00" + (json.jws.forecastHours[i].plusminus > 0 ? "&nbsp;&plusmn;"+json.jws.forecastHours[i].plusminus : "");
                if (json.jws.forecastHours[i].time == 0)
                        strDate = json.jws.forecastHours[i].day<? echo $lang_idx;?>;
                forecastHoursD += "<li class=\"tsfh text timefh \"><span>" + strDate + "</span></li>";
                //forecastHoursD += "<li class=\"timefh forcast_time\"><span>" + json.jws.forecastHours[i].time + ":00" + (json.jws.forecastHours[i].plusminus > 0 ? "&nbsp;&plusmn;"+json.jws.forecastHours[i].plusminus : "") +"</span></li>";
                forecastHoursD += "<li class=\"tsfh forecasttemp\" id=\"tempfh"+ json.jws.forecastHours[i].time + "\"><div class=\"number\">" + c_or_f(json.jws.forecastHours[i].temp, tempunit) + "" +TempCloth + "</div></li>";
                forecastHoursD += "<li class=\"wind\" style=\"padding:0;\"><div title=\"" + json.jws.forecastHours[i].wind_title<? echo $lang_idx;?>+"\" class=\"wind_icon "+json.jws.forecastHours[i].wind_class+" \"></div><div class=\"humidity extra"+i+"\"><?=$HUMIDITY[$lang_idx]?>" + "  " +json.jws.forecastHours[i].hum+"%</div></li>";
                forecastHoursD += "<li class=\"forcast_icon\"><span><img src=\"images/icons/day/"+json.jws.forecastHours[i].icon+"\" height=\"30\" width=\"30\" /></span></li>";
                forecastHoursD += "<li class=\"forcast_title text\"><span>"+json.jws.forecastHours[i].title<? echo $lang_idx;?>+"</span></li>";
                forecastHoursD += "</ul></li>";
                
            }
       // }
        
       if (i == 6) {
            //    forecastHoursD += "<ul class=\"nav forecasttimebox\" ><li class=\"forcast_each invfloat\" style=\"padding-left:2em\"><a href=\"http://shaon-horef.co.il\" target=_blank >שאון חורף > פעם אחרונה לטירוף של החורף!</a></li></ul>  ";
        
        }
       }
       var prev_wind, bottom, tempclass, addonclass;
       for (i = 0; i< json.jws.forecastHours.length; i++){
        //if (i >= json.jws.states.nowHourIndex)
        //{
            forecastHoursNG += "<li class=\"x-axis-bar-item\">";
            toptime =  (json.jws.forecastHours[i].time % 4 == 0) ? json.jws.forecastHours[i].day<? echo $lang_idx;?>+"</br>"+json.jws.forecastHours[i].time+":00" : json.jws.forecastHours[i].time + ":00";
            forecastHoursNG += "<div class=\"x-axis-bar-item-container\" onclick=\"showcircleperhour('"+toptime+"','"+json.jws.forecastHours[i].icon+"',"+ json.jws.forecastHours[i].temp+","+json.jws.forecastHours[i].wind+",'"+json.jws.forecastHours[i].cloth.substring(json.jws.forecastHours[i].cloth.split('/', 2).join('/').length)+"',"+json.jws.forecastHours[i].rain+","+json.jws.forecastHours[i].hum+","+i+",''" + ")\">";
            forecastHoursNG += "<div class=\"x-axis-bar primary\" style=\"height: 100%\">"+toptime+"</div>";    
            bottom = 85;
            forecastHoursNG += "<div class=\"x-axis-bar tertiary icon\" style=\"height: "+ bottom +"%;\"><img style=\"vertical-align: middle\" src=\"images/icons/day/"+json.jws.forecastHours[i].icon+"\" height=\"30\" width=\"35\" alt=\""+json.jws.forecastHours[i].icon+"\" /></div>";
            bottom = ((json.jws.forecastHours[i].temp-min_temp)*80)/(max_temp - min_temp);
            if (bottom < 10) bottom = 13;
            else if (bottom < 20) bottom = bottom + 3;
            else if (bottom > 60) addonclass = "uppervalue"; else addonclass = "";
            tempclass = (i % 2 == 0) ? "secondary" : "secondaryalt";
            forecastHoursNG += "<div class=\"x-axis-bar "+ tempclass + " " + addonclass+" temp\" style=\"height: "+bottom+"%;\"><span class=\"span-value\" data-value=\""+ json.jws.forecastHours[i].temp +"° "+json.jws.forecastHours[i].hum+"%\">"+ c_or_f(json.jws.forecastHours[i].temp, tempunit) + "</span></div>";
            forecastHoursNG += "<div class=\"x-axis-bar tertiary cloth icon "+ addonclass + "\" style=\"display:none;height: "+ bottom +"%;\"><span class=\"span-value "+ addonclass + "\" data-value=\"" + json.jws.forecastHours[i].cloth_title<?=$lang_idx;?> +  "\"><img style=\"vertical-align: middle\" src=\""+json.jws.forecastHours[i].cloth+"\" height=\"30\" width=\"30\" /></span></div>";
            bottom = 40;
            if (json.jws.forecastHours[i].plusminus > 0)
                forecastHoursNG += "<div class=\"x-axis-bar tertiary\" style=\"height: "+ bottom +"%;\"><span class=\"span-value\" data-value=\""+"&nbsp;&plusmn;"+json.jws.forecastHours[i].plusminus+"\"></span></div>";
            bottom = 82;
            if (i == json.jws.states.nowHourIndex || (json.jws.forecastHours[i].wind != prev_wind))
                forecastHoursNG += "<div class=\"x-axis-bar tertiary wind\" style=\"height: "+ bottom +"%;\"><div title=\""+json.jws.forecastHours[i].wind_title<? echo $lang_idx;?>+"\" class=\"wind_icon "+json.jws.forecastHours[i].wind_class+" \"></div></div>";
            bottom = json.jws.forecastHours[i].rain;
            if (bottom > 0)
                forecastHoursNG += "<div class=\"x-axis-bar tertiary rain\" style=\"display:none;height: "+ bottom +"%;\"><span class=\"span-value\" data-value=\"\">"+json.jws.forecastHours[i].rain+"%</span></div>";
            bottom = json.jws.forecastHours[i].hum;
            forecastHoursNG += "<div class=\"x-axis-bar tertiary humidity\" style=\"display:none;height: "+ (bottom-5) +"%;\"><span class=\"span-value\" data-value=\"<?=$HUMIDITY[$lang_idx]?>\">"+json.jws.forecastHours[i].hum+"%</span></div>";
            forecastHoursNG += "</div>";
            forecastHoursNG += "</li>";
            prev_wind = json.jws.forecastHours[i].wind;
        //}
       }
       
      
       //$('#for24_given').html('<? echo $GIVEN[$lang_idx]." ".$AT[$lang_idx]." ";?>' + json.jws.TAF.timetaf + ':00 ' + json.jws.TAF.dayF + '/' + json.jws.TAF.monthF + '/' + json.jws.TAF.yearF);
       var userpics_str = "";
       for (i = 0; i< json.jws.LatestUserPic.length; i++){
             userpics_str += "<a href=\"https://www.02ws.co.il?section=userPics&amp;lang=1\" title=\"" + json.jws.LatestUserPic[i].comment + "\"><img id=\"pic_thumb" + (i+1) + "\" src=\"" + json.jws.LatestUserPic[i].picname + "\" width=\"30\" alt=\"" + json.jws.LatestUserPic[i].name + "\"  /></a>\n";
       }
       $('#map_thumbs').html(userpics_str);
       $('#for24_hours_s').html(forecastHours);
       $('#for24_graph_ng, .for24_graph_ng').html(forecastHoursNG);
       $('#forcast_hours_table').html(forecastHoursD);
       $('#for24_hours').html(forecastHours);
       $('#date').html(json.jws.current.date<?=$lang_idx?>).addClass('glow');
       fetch("https://www.02ws.co.il/activities.json")
                .then(response => response.json())
                .then(data => fillactivities(data, json))
                .catch(error => console.log("error fetching activities:" + error))
      
        
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
       /*
       forecastDays = "<table style=\"border-spacing:4px;width:100%\">";
       forecastDays += "<tr id=\"titlerow\" style=\"height:2em;background: transparent;\">";
       link_for_yest = "<a id=\"linkyesterday\" hrf=\"javascript:void(0)\" onclick=\"$('#yesterday_line').show();\"><img src=\"<?=BASE_URL?>/images/yesterday.png\" width=\"14\" height=\"14\" title=\"<?=$LAST_DAY[$lang_idx]?>\" /></a>";
       forecastDays += "<td>" + link_for_yest + "</td><td id=\"plus\"></td>";
       forecastDays += "<td id=\"morning\">" + json.jws.desc.early_morning<? echo $lang_idx;?> + "</td>";
       forecastDays += "<td id=\"noon\">" + json.jws.desc.noon<? echo $lang_idx;?> + "</td>";
       forecastDays += "<td id=\"night\"><?=$NIGHT[$lang_idx]?></td>";
       forecastDays += "<td></td>";
       forecastDays += "<td></td>";
       forecastDays += "</tr>";
       forecastDays += "<tr id=\"yesterday_line\" style=\"display:none\">";
       forecastDays += "<td class=\"\" style=\"text-align:center;\">" + date_value + "</td><td></td>";
       forecastDays += "<td class=\"tsfh\"><div class=\"number\">" + c_or_f(morning_value, tempunit) + "</div></td>";
       forecastDays += "<td class=\"tsfh\">" + c_or_f(noon_value, tempunit) +"</td>";
       forecastDays += "<td class=\"tsfh\">" + c_or_f(night_value, tempunit) + "</td>";
       forecastDays += "<td></td>";
       forecastDays += "<td></td>";
       forecastDays += "</tr>";
        for (i = 0; i< json.jws.forecastDays.length; i++){
            TempLowClothfull = '<div class=\"cloth extra' + i + '\"><a href=\"javascript:void(0)\" class=\"info\" ><img style=\"vertical-align: middle\" src=\"<?=BASE_URL?>/'+json.jws.forecastDays[i].TempLowCloth+'\" width=\"20\" height=\"20\" title=\"'+json.jws.forecastDays[i].TempLowClothTitle<? echo $lang_idx;?>+'\" alt=\"\" /><span class=\"info\">'+json.jws.forecastDays[i].TempLowClothTitle<? echo $lang_idx;?>+'</span></a></div>';
            TempHighClothfull = '<div class=\"cloth extra' + i + '\"><a href=\"javascript:void(0)\" class=\"info\" ><img style=\"vertical-align: middle\" src=\"<?=BASE_URL?>/'+json.jws.forecastDays[i].TempHighCloth+'\" width=\"20\" height=\"20\" title=\"'+json.jws.forecastDays[i].TempHighClothTitle<? echo $lang_idx;?>+'\" alt=\"\" /><span class=\"info\">'+json.jws.forecastDays[i].TempHighClothTitle<? echo $lang_idx;?>+'</span></a></div>';
            TempNightClothfull = '<div class=\"cloth extra' + i + '\"><a href=\"javascript:void(0)\" class=\"info\" ><img style=\"vertical-align: middle\" src=\"<?=BASE_URL?>/'+json.jws.forecastDays[i].TempNightCloth+'\" width=\"20\" height=\"20\" title=\"'+json.jws.forecastDays[i].TempNightClothTitle<? echo $lang_idx;?>+'\" alt=\"\" /><span class=\"info\">'+json.jws.forecastDays[i].TempNightClothTitle<? echo $lang_idx;?>+'</span></a></div>';
        
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
                //forecastDays += "<tr class=\"adunit\"><td colspan=\"6\" style=\"padding:0 8px 0 0\"><a style=\"text-decoration:none\" href=\"https://headstart.co.il/project/63080\" target=_blank >יש! אפליקציה חדשה לירושמיים<?=get_arrow();?></a></td></tr>  ";
                            }
                            <?}?>
             forecastDays += "<tr>";
             forecastDays += "<td class=\"date\" >"  + json.jws.forecastDays[i].day_name<?=$lang_idx?> + "<div class=\"datetext\">" + json.jws.forecastDays[i].date + "<div></td><td class=\"plus\">" + "<div index=\"" + i + "\" id=\"" + i + "\" class='open-close-button'></div>" + "</td>";
            forecastDays += "<td class=\"tsfh\"><div class=\"number\">" + c_or_f(json.jws.forecastDays[i].TempLow, tempunit) + TempLowCloth +  "</div><div class=\"icon extra" + i + "\"><div class=\"humidity\">" + json.jws.forecastDays[i].humMorning + "%</div></div>" + TempLowClothfull + "<div class=\"icon extra" + i + "\" id=\"morning_icon" + i + "\">" + "<a href=\"legend.php\" rel=\"external\"><img src=\"<?=BASE_URL?>/" + json.jws.forecastDays[i].morning_icon + "\" width=\"28\" height=\"28\" alt=\"" + json.jws.forecastDays[i].morning_icon +"\" /></a></div><div class=\"icon extra" + i + "\"><div class=\"wind_icon " + json.jws.forecastDays[i].windMorning + "\">" + json.jws.forecastDays[i].windMorningSpd + " <span class=\"param\"><?=$WIND_UNIT[$lang_idx]?></span></div></div></td>";
            forecastDays += "<td class=\"tsfh\"><div class=\"number\">" + c_or_f(json.jws.forecastDays[i].TempHigh, tempunit) + TempHighCloth + "</div><div class=\"icon extra" + i + "\"><div class=\"humidity\">" + json.jws.forecastDays[i].humDay +"%</div></div>" + TempHighClothfull + "<div class=\"icon extra" + i + "\" id=\"day_icon" + i + "\">" + "<a href=\"legend.php\" rel=\"external\"><img src=\"<?=BASE_URL?>/" + json.jws.forecastDays[i].icon + "\" width=\"28\" height=\"28\" alt=\"" + json.jws.forecastDays[i].icon +"\" /></a></div><div class=\"icon extra" + i + "\"><div class=\"wind_icon " + json.jws.forecastDays[i].windDay + "\">" + json.jws.forecastDays[i].windDaySpd + " <span class=\"param\"><?=$WIND_UNIT[$lang_idx]?></span></div></div></td>";
            forecastDays += "<td class=\"tsfh\"><div class=\"number\">" + c_or_f(json.jws.forecastDays[i].TempNight, tempunit) + TempNightCloth + "</div><div class=\"icon extra" + i + "\"><div class=\"humidity\">" + json.jws.forecastDays[i].humNight +"%</div></div>" + TempNightClothfull + "<div class=\"icon extra" + i + "\" id=\"night_icon" + i + "\">" + "<a href=\"legend.php\" rel=\"external\"><img src=\"<?=BASE_URL?>/" + json.jws.forecastDays[i].night_icon + "\" width=\"28\" height=\"28\" alt=\"" + json.jws.forecastDays[i].night_icon +"\" /></a></div><div class=\"icon extra" + i + "\"><div class=\"wind_icon " + json.jws.forecastDays[i].windNight + "\">" + json.jws.forecastDays[i].windNightSpd + " <span class=\"param\"><?=$WIND_UNIT[$lang_idx]?></span></div></div></td>";
            forecastDays += "<td class=\"forcast_each icon_day\" >";
            if (i==0)
                forecastDays += noon_value_change;
            if (json.jws.forecastDays[i].windDay == "high_wind")
                wind_extra = "<div class=\"wind_icon high_wind\"></div>";
            else
                wind_extra = "";                        
            forecastDays += "<span class=\"icon extra" + i + "\" id=\"icon" + i + "\">" + wind_extra + "<img src=\"<?=BASE_URL?>/" + json.jws.forecastDays[i].icon + "\" width=\"34\" height=\"34\" alt=\"" + json.jws.forecastDays[i].icon +"\" /></span><div class=\"tsfh\"><div class=\"enlarge icon extra" + i + "\"><a href=\"<?=BASE_URL?>/dailydetailed.php?m=1&dayid=" + (i+1) + "\" rel=\"external\" ><img src=\"<?=BASE_URL?>/images/enlarge_64.png\" width=\"35\" alt=\"enlarge\"/></a></div></div>"+"</td>";
            fulltextforecast = json.jws.forecastDays[i].lang<? echo $lang_idx;?>;
            containsanchor = fulltextforecast.indexOf("<a");
            partialtextlastindex = (containsanchor > 0) ? containsanchor - 1 : lastindex;
            partialtext = fulltextforecast.substring(0, partialtextlastindex);
            if ((fulltextforecast.length > lastindex)&&!(containsanchor > 0))
                textforecast = "<span class=\"extra" + i + "\">" + fulltextforecast.substring(0, partialtext.lastIndexOf(" ")) + '<? echo get_arrow();?>' + "</span>";
            else
                textforecast = "<span class=\"extra" + i + "\">" + fulltextforecast + "</span>";
            var get_fullt = '<?=$_GET['fullt']?>';
            if ((get_fullt)&&(get_fullt > 0)){
                textforecast = fulltextforecast;
                textforecastwidth = "130px";
            }
            forecastDays += "<td class=\"text\" ><span class=\"extra" + i + " fulltext\">" + fulltextforecast + "</span>" +  textforecast +"</td>";
            forecastDays += "</tr>";
       }
       forecastDays += "<tr><td style=\"text-align:center\">" + json.jws.desc.month_in_word<?=$lang_idx?> + " <?=$AVERAGE[$lang_idx]?></td><td></td><td class=\"tsfh average\" style=\"text-align:center\">" + c_or_f(json.jws.thisMonth.lowtemp_av, tempunit) + "</td><td class=\"tsfh average\" style=\"text-align:center\">" + c_or_f(json.jws.thisMonth.hightemp_av, tempunit) + "</td><td></td><td></td><td></td></tr>";
       forecastDays += "</table>";  
       */

      var ad_html, ad_container;
       for (i = 0; i< json.jws.Ads.length; i++){
        ad_html = "<a href='"+json.jws.Ads[i].link+"' >" + "<img src=\"" + json.jws.Ads[i].img_url + "\" width=\"" + json.jws.Ads[i].width  + "\" height=\"" + json.jws.Ads[i].height  +  "\" /></a>";
        ad_container = '#if'+(i+1);
        $(ad_container).html(ad_html);
        $(ad_container).attr('idx', json.jws.Ads[i].index);
        $(ad_container).attr('type', json.jws.Ads[i].session_or_pageviews);
       }

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
          console.error('parsing json: ' + e);
          }
      try{loadData(json);} catch (e) {
        console.error('extracting json to page: ' + e);
          }
      
   }
//
// startup script
//
var isUserAdApproved = false;
var new_session = false;
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
if ((isMobile.any())
    &&(!isOnMobilePage())
    &&(window.location.href.indexOf("updateForecast") < 0)
    &&(window.location.href.indexOf("frommobile") < 0)
    &&(window.location.href.indexOf("login_form") < 0)){
    
    //$.colorbox({href:"#mobile_redirect"});
    //$("#mobile_redirect").show();
    redirect_to_mobile(<?=$lang_idx?>);
}
function toggleForecastDay(index){
    $('.extra' + index).toggle(0);
    var down = parseInt($('#whatmore').css('top')) + 200;
    var up = parseInt($('#whatmore').css('top')) - 200;
   // if ($('.extra' + index).css('display') == 'none')
   // $('#whatmore').animate({'top':down + 'px'}, 200);
   // else
   // $('#whatmore').animate({"top":up + "px"}, 200);
    
	//$('#' + 'morning_icon' + index).toggle("slow");
	//$('#' + 'day_icon' + index).toggle("slow");
	//$('#' + 'night_icon' + index).toggle("slow");
	//$('#' + 'icon' + index).toggle("slow");
}
function toggleSunShade(){
    $('.sun_shade_nav li').toggleClass("active");
    $('#coldmeter .sun').toggle();
    $('#coldmeter .shade').toggle();
}
function openForecastDay(index){
    $('.extra' + index).show(0);
}
function showHourlyParam(param, idx){
        $('#legends span').css('text-decoration', 'none');
        $('#legend' + idx).css('text-decoration', 'underline');
        $('.x-axis-bar-item .temp, .x-axis-bar-item .humidity, .x-axis-bar-item .rain, .x-axis-bar-item .cloth ').hide(0);
        $('.x-axis-bar-item .' + param).show(0);
    }

function showcircleperhour(toptime, icon, temp, wind, cloth, rain, humidity, hour_index, json){
    
    $('#chartjs-tooltip').css({
        opacity: 1,
        width:'310px',
        fontSize: '1.9em',
        margin:'0 auto',
        top:'30px',
        padding: '4px 11px 18px',
        lineheight:'1em'
    });
    $('#chartjs-tooltip').html( toptime + "<br/><div class=\"cloth\">&nbsp;<img src=\"images/clothes/" + cloth + "\" width=\"30.25\" height=\"25\" style=\"vertical-align: middle\">&nbsp;<img style=\"vertical-align: middle\" src=\"images/icons/day/" + icon + "\" height=\"30\" width=\"35\" alt=\""  + icon + "\"></div>&nbsp;<div class=\"temp\">"  + temp + "°<br/></div><div class=\"wind\">" + wind + " קמש<br/></div><div class=\"rainpercent\">" + rain + "%</div><div class=\"humidity\"><?=$HUMIDITY[$lang_idx] ?>:" + humidity + "%</div>" );
    change_circle('now_line', 'chartjs-tooltip');
    $('.activity').hide();
    $('#activities_yes'+hour_index).show();
    $('#activities_no'+hour_index).show();
    
}
 $(".open-close-button").click(function () {
	  toggleForecastDay($(this).attr("index"));
      return $(this).toggleClass("open");
    });
$(".date").click(function () {
    toggleForecastDay($(this).next('.plus').find('.open-close-button').attr("index"));
    return $(this).next('.plus').find('.open-close-button').toggleClass("open");
});
$(".text, .forcast_each").click(function () {
    toggleForecastDay($(this).prevAll('.plus').find('.open-close-button').attr("index"));
    return $(this).prevAll('.plus').find('.open-close-button').toggleClass("open");
});
$(".tsfh .number").click(function () {
    toggleForecastDay($(this).parent().prevAll('.plus').find('.open-close-button').attr("index"));
    return $(this).parent().prevAll('.plus').find('.open-close-button').toggleClass("open");
});
$("#startpage_chb").click(function () {
    //alert(current_tab);
    rememberCookie ('start_container', current_tab, 0.1);
    rememberCookie ('start_nodeid', current_nideid, 0.1);
    $("#startpage_chb").hide();
});
$(".forcast_text, .forcast_night, .forcast_noon, .forcast_morning").click(function (event) {
    if (event.isDefaultPrevented()) return;
    var dayindex = parseInt($(this).prevAll('.expand_plus').find('.open-close-button').attr("index")) + 1;
    $.colorbox({href:"<?=BASE_URL?>/dailydetailed.php?dayid=" + dayindex, width:"95%", height:"95%"});
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