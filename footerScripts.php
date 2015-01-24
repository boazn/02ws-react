<?  
    ini_set("display_errors","On");
    header("Content-type: text/javascript");
    include_once('lang.php');
    ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE);
$lang_idx = @$_GET['lang'];

?>


/*!
 * Masonry PACKAGED v3.1.1
 * Cascading grid layout library
 * http://masonry.desandro.com
 * MIT License
 * by David DeSandro
 */

(function(t){"use strict";function e(t){if(t){if("string"==typeof n[t])return t;t=t.charAt(0).toUpperCase()+t.slice(1);for(var e,o=0,r=i.length;r>o;o++)if(e=i[o]+t,"string"==typeof n[e])return e}}var i="Webkit Moz ms Ms O".split(" "),n=document.documentElement.style;"function"==typeof define&&define.amd?define(function(){return e}):t.getStyleProperty=e})(window),function(t){"use strict";function e(t){var e=parseFloat(t),i=-1===t.indexOf("%")&&!isNaN(e);return i&&e}function i(){for(var t={width:0,height:0,innerWidth:0,innerHeight:0,outerWidth:0,outerHeight:0},e=0,i=s.length;i>e;e++){var n=s[e];t[n]=0}return t}function n(t){function n(t){if("string"==typeof t&&(t=document.querySelector(t)),t&&"object"==typeof t&&t.nodeType){var n=r(t);if("none"===n.display)return i();var h={};h.width=t.offsetWidth,h.height=t.offsetHeight;for(var u=h.isBorderBox=!(!a||!n[a]||"border-box"!==n[a]),p=0,f=s.length;f>p;p++){var d=s[p],c=n[d],l=parseFloat(c);h[d]=isNaN(l)?0:l}var m=h.paddingLeft+h.paddingRight,y=h.paddingTop+h.paddingBottom,g=h.marginLeft+h.marginRight,v=h.marginTop+h.marginBottom,_=h.borderLeftWidth+h.borderRightWidth,b=h.borderTopWidth+h.borderBottomWidth,E=u&&o,L=e(n.width);L!==!1&&(h.width=L+(E?0:m+_));var S=e(n.height);return S!==!1&&(h.height=S+(E?0:y+b)),h.innerWidth=h.width-(m+_),h.innerHeight=h.height-(y+b),h.outerWidth=h.width+g,h.outerHeight=h.height+v,h}}var o,a=t("boxSizing");return function(){if(a){var t=document.createElement("div");t.style.width="200px",t.style.padding="1px 2px 3px 4px",t.style.borderStyle="solid",t.style.borderWidth="1px 2px 3px 4px",t.style[a]="border-box";var i=document.body||document.documentElement;i.appendChild(t);var n=r(t);o=200===e(n.width),i.removeChild(t)}}(),n}var o=document.defaultView,r=o&&o.getComputedStyle?function(t){return o.getComputedStyle(t,null)}:function(t){return t.currentStyle},s=["paddingLeft","paddingRight","paddingTop","paddingBottom","marginLeft","marginRight","marginTop","marginBottom","borderLeftWidth","borderRightWidth","borderTopWidth","borderBottomWidth"];"function"==typeof define&&define.amd?define(["get-style-property/get-style-property"],n):t.getSize=n(t.getStyleProperty)}(window),function(t){"use strict";var e=document.documentElement,i=function(){};e.addEventListener?i=function(t,e,i){t.addEventListener(e,i,!1)}:e.attachEvent&&(i=function(e,i,n){e[i+n]=n.handleEvent?function(){var e=t.event;e.target=e.target||e.srcElement,n.handleEvent.call(n,e)}:function(){var i=t.event;i.target=i.target||i.srcElement,n.call(e,i)},e.attachEvent("on"+i,e[i+n])});var n=function(){};e.removeEventListener?n=function(t,e,i){t.removeEventListener(e,i,!1)}:e.detachEvent&&(n=function(t,e,i){t.detachEvent("on"+e,t[e+i]);try{delete t[e+i]}catch(n){t[e+i]=void 0}});var o={bind:i,unbind:n};"function"==typeof define&&define.amd?define(o):t.eventie=o}(this),function(t){"use strict";function e(t){"function"==typeof t&&(e.isReady?t():r.push(t))}function i(t){var i="readystatechange"===t.type&&"complete"!==o.readyState;if(!e.isReady&&!i){e.isReady=!0;for(var n=0,s=r.length;s>n;n++){var a=r[n];a()}}}function n(n){return n.bind(o,"DOMContentLoaded",i),n.bind(o,"readystatechange",i),n.bind(t,"load",i),e}var o=t.document,r=[];e.isReady=!1,"function"==typeof define&&define.amd?(e.isReady="function"==typeof requirejs,define(["eventie/eventie"],n)):t.docReady=n(t.eventie)}(this),function(){"use strict";function t(){}function e(t,e){for(var i=t.length;i--;)if(t[i].listener===e)return i;return-1}var i=t.prototype;i.getListeners=function(t){var e,i,n=this._getEvents();if("object"==typeof t){e={};for(i in n)n.hasOwnProperty(i)&&t.test(i)&&(e[i]=n[i])}else e=n[t]||(n[t]=[]);return e},i.flattenListeners=function(t){var e,i=[];for(e=0;t.length>e;e+=1)i.push(t[e].listener);return i},i.getListenersAsObject=function(t){var e,i=this.getListeners(t);return i instanceof Array&&(e={},e[t]=i),e||i},i.addListener=function(t,i){var n,o=this.getListenersAsObject(t),r="object"==typeof i;for(n in o)o.hasOwnProperty(n)&&-1===e(o[n],i)&&o[n].push(r?i:{listener:i,once:!1});return this},i.on=i.addListener,i.addOnceListener=function(t,e){return this.addListener(t,{listener:e,once:!0})},i.once=i.addOnceListener,i.defineEvent=function(t){return this.getListeners(t),this},i.defineEvents=function(t){for(var e=0;t.length>e;e+=1)this.defineEvent(t[e]);return this},i.removeListener=function(t,i){var n,o,r=this.getListenersAsObject(t);for(o in r)r.hasOwnProperty(o)&&(n=e(r[o],i),-1!==n&&r[o].splice(n,1));return this},i.off=i.removeListener,i.addListeners=function(t,e){return this.manipulateListeners(!1,t,e)},i.removeListeners=function(t,e){return this.manipulateListeners(!0,t,e)},i.manipulateListeners=function(t,e,i){var n,o,r=t?this.removeListener:this.addListener,s=t?this.removeListeners:this.addListeners;if("object"!=typeof e||e instanceof RegExp)for(n=i.length;n--;)r.call(this,e,i[n]);else for(n in e)e.hasOwnProperty(n)&&(o=e[n])&&("function"==typeof o?r.call(this,n,o):s.call(this,n,o));return this},i.removeEvent=function(t){var e,i=typeof t,n=this._getEvents();if("string"===i)delete n[t];else if("object"===i)for(e in n)n.hasOwnProperty(e)&&t.test(e)&&delete n[e];else delete this._events;return this},i.emitEvent=function(t,e){var i,n,o,r,s=this.getListenersAsObject(t);for(o in s)if(s.hasOwnProperty(o))for(n=s[o].length;n--;)i=s[o][n],r=i.listener.apply(this,e||[]),(r===this._getOnceReturnValue()||i.once===!0)&&this.removeListener(t,i.listener);return this},i.trigger=i.emitEvent,i.emit=function(t){var e=Array.prototype.slice.call(arguments,1);return this.emitEvent(t,e)},i.setOnceReturnValue=function(t){return this._onceReturnValue=t,this},i._getOnceReturnValue=function(){return this.hasOwnProperty("_onceReturnValue")?this._onceReturnValue:!0},i._getEvents=function(){return this._events||(this._events={})},"function"==typeof define&&define.amd?define(function(){return t}):"undefined"!=typeof module&&module.exports?module.exports=t:this.EventEmitter=t}.call(this),function(t){"use strict";function e(){}function i(t){function i(e){e.prototype.option||(e.prototype.option=function(e){t.isPlainObject(e)&&(this.options=t.extend(!0,this.options,e))})}function o(e,i){t.fn[e]=function(o){if("string"==typeof o){for(var s=n.call(arguments,1),a=0,h=this.length;h>a;a++){var u=this[a],p=t.data(u,e);if(p)if(t.isFunction(p[o])&&"_"!==o.charAt(0)){var f=p[o].apply(p,s);if(void 0!==f)return f}else r("no such method '"+o+"' for "+e+" instance");else r("cannot call methods on "+e+" prior to initialization; "+"attempted to call '"+o+"'")}return this}return this.each(function(){var n=t.data(this,e);n?(n.option(o),n._init()):(n=new i(this,o),t.data(this,e,n))})}}if(t){var r="undefined"==typeof console?e:function(t){console.error(t)};t.bridget=function(t,e){i(e),o(t,e)}}}var n=Array.prototype.slice;"function"==typeof define&&define.amd?define(["jquery"],i):i(t.jQuery)}(window),function(t,e){"use strict";function i(t,e){return t[a](e)}function n(t){if(!t.parentNode){var e=document.createDocumentFragment();e.appendChild(t)}}function o(t,e){n(t);for(var i=t.parentNode.querySelectorAll(e),o=0,r=i.length;r>o;o++)if(i[o]===t)return!0;return!1}function r(t,e){return n(t),i(t,e)}var s,a=function(){if(e.matchesSelector)return"matchesSelector";for(var t=["webkit","moz","ms","o"],i=0,n=t.length;n>i;i++){var o=t[i],r=o+"MatchesSelector";if(e[r])return r}}();if(a){var h=document.createElement("div"),u=i(h,"div");s=u?i:r}else s=o;"function"==typeof define&&define.amd?define(function(){return s}):window.matchesSelector=s}(this,Element.prototype),function(t){"use strict";function e(t,e){for(var i in e)t[i]=e[i];return t}function i(t,i,n){function r(t,e){t&&(this.element=t,this.layout=e,this.position={x:0,y:0},this._create())}var s=n("transition"),a=n("transform"),h=s&&a,u=!!n("perspective"),p={WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"otransitionend",transition:"transitionend"}[s],f=["transform","transition","transitionDuration","transitionProperty"],d=function(){for(var t={},e=0,i=f.length;i>e;e++){var o=f[e],r=n(o);r&&r!==o&&(t[o]=r)}return t}();e(r.prototype,t.prototype),r.prototype._create=function(){this.css({position:"absolute"})},r.prototype.handleEvent=function(t){var e="on"+t.type;this[e]&&this[e](t)},r.prototype.getSize=function(){this.size=i(this.element)},r.prototype.css=function(t){var e=this.element.style;for(var i in t){var n=d[i]||i;e[n]=t[i]}},r.prototype.getPosition=function(){var t=o(this.element),e=this.layout.options,i=e.isOriginLeft,n=e.isOriginTop,r=parseInt(t[i?"left":"right"],10),s=parseInt(t[n?"top":"bottom"],10);r=isNaN(r)?0:r,s=isNaN(s)?0:s;var a=this.layout.size;r-=i?a.paddingLeft:a.paddingRight,s-=n?a.paddingTop:a.paddingBottom,this.position.x=r,this.position.y=s},r.prototype.layoutPosition=function(){var t=this.layout.size,e=this.layout.options,i={};e.isOriginLeft?(i.left=this.position.x+t.paddingLeft+"px",i.right=""):(i.right=this.position.x+t.paddingRight+"px",i.left=""),e.isOriginTop?(i.top=this.position.y+t.paddingTop+"px",i.bottom=""):(i.bottom=this.position.y+t.paddingBottom+"px",i.top=""),this.css(i),this.emitEvent("layout",[this])};var c=u?function(t,e){return"translate3d("+t+"px, "+e+"px, 0)"}:function(t,e){return"translate("+t+"px, "+e+"px)"};r.prototype._transitionTo=function(t,e){this.getPosition();var i=this.position.x,n=this.position.y,o=parseInt(t,10),r=parseInt(e,10),s=o===this.position.x&&r===this.position.y;if(this.setPosition(t,e),s&&!this.isTransitioning)return this.layoutPosition(),void 0;var a=t-i,h=e-n,u={},p=this.layout.options;a=p.isOriginLeft?a:-a,h=p.isOriginTop?h:-h,u.transform=c(a,h),this.transition({to:u,onTransitionEnd:this.layoutPosition,isCleaning:!0})},r.prototype.goTo=function(t,e){this.setPosition(t,e),this.layoutPosition()},r.prototype.moveTo=h?r.prototype._transitionTo:r.prototype.goTo,r.prototype.setPosition=function(t,e){this.position.x=parseInt(t,10),this.position.y=parseInt(e,10)},r.prototype._nonTransition=function(t){this.css(t.to),t.isCleaning&&this._removeStyles(t.to),t.onTransitionEnd&&t.onTransitionEnd.call(this)},r.prototype._transition=function(t){var e=this.layout.options.transitionDuration;if(!parseFloat(e))return this._nonTransition(t),void 0;var i=t.to,n=[];for(var o in i)n.push(o);var r={};if(r.transitionProperty=n.join(","),r.transitionDuration=e,this.element.addEventListener(p,this,!1),(t.isCleaning||t.onTransitionEnd)&&this.on("transitionEnd",function(e){return t.isCleaning&&e._removeStyles(i),t.onTransitionEnd&&t.onTransitionEnd.call(e),!0}),t.from){this.css(t.from);var s=this.element.offsetHeight;s=null}this.css(r),this.css(i),this.isTransitioning=!0},r.prototype.transition=r.prototype[s?"_transition":"_nonTransition"],r.prototype.onwebkitTransitionEnd=function(t){this.ontransitionend(t)},r.prototype.onotransitionend=function(t){this.ontransitionend(t)},r.prototype.ontransitionend=function(t){t.target===this.element&&(this.removeTransitionStyles(),this.element.removeEventListener(p,this,!1),this.isTransitioning=!1,this.emitEvent("transitionEnd",[this]))},r.prototype._removeStyles=function(t){var e={};for(var i in t)e[i]="";this.css(e)};var l={transitionProperty:"",transitionDuration:""};return r.prototype.removeTransitionStyles=function(){this.css(l)},r.prototype.removeElem=function(){this.element.parentNode.removeChild(this.element),this.emitEvent("remove",[this])},r.prototype.remove=function(){if(!s||!parseFloat(this.layout.options.transitionDuration))return this.removeElem(),void 0;var t=this;this.on("transitionEnd",function(){return t.removeElem(),!0}),this.hide()},r.prototype.reveal=function(){delete this.isHidden,this.css({display:""});var t=this.layout.options;this.transition({from:t.hiddenStyle,to:t.visibleStyle,isCleaning:!0})},r.prototype.hide=function(){this.isHidden=!0,this.css({display:""});var t=this.layout.options;this.transition({from:t.visibleStyle,to:t.hiddenStyle,isCleaning:!0,onTransitionEnd:function(){this.css({display:"none"})}})},r.prototype.destroy=function(){this.css({position:"",left:"",right:"",top:"",bottom:"",transition:"",transform:""})},r}var n=document.defaultView,o=n&&n.getComputedStyle?function(t){return n.getComputedStyle(t,null)}:function(t){return t.currentStyle};"function"==typeof define&&define.amd?define(["eventEmitter/EventEmitter","get-size/get-size","get-style-property/get-style-property"],i):(t.Outlayer={},t.Outlayer.Item=i(t.EventEmitter,t.getSize,t.getStyleProperty))}(window),function(t){"use strict";function e(t,e){for(var i in e)t[i]=e[i];return t}function i(t){return"[object Array]"===p.call(t)}function n(t){var e=[];if(i(t))e=t;else if(t&&"number"==typeof t.length)for(var n=0,o=t.length;o>n;n++)e.push(t[n]);else e.push(t);return e}function o(t){return t.replace(/(.)([A-Z])/g,function(t,e,i){return e+"-"+i}).toLowerCase()}function r(i,r,p,c,l,m){function y(t,i){if("string"==typeof t&&(t=s.querySelector(t)),!t||!f(t))return a&&a.error("Bad "+this.settings.namespace+" element: "+t),void 0;this.element=t,this.options=e({},this.options),e(this.options,i);var n=++v;this.element.outlayerGUID=n,_[n]=this,this._create(),this.options.isInitLayout&&this.layout()}function g(t,i){t.prototype[i]=e({},y.prototype[i])}var v=0,_={};return y.prototype.settings={namespace:"outlayer",item:m},y.prototype.options={containerStyle:{position:"relative"},isInitLayout:!0,isOriginLeft:!0,isOriginTop:!0,isResizeBound:!0,transitionDuration:"0.4s",hiddenStyle:{opacity:0,transform:"scale(0.001)"},visibleStyle:{opacity:1,transform:"scale(1)"}},e(y.prototype,p.prototype),y.prototype._create=function(){this.reloadItems(),this.stamps=[],this.stamp(this.options.stamp),e(this.element.style,this.options.containerStyle),this.options.isResizeBound&&this.bindResize()},y.prototype.reloadItems=function(){this.items=this._getItems(this.element.children)},y.prototype._getItems=function(t){for(var e=this._filterFindItemElements(t),i=this.settings.item,n=[],o=0,r=e.length;r>o;o++){var s=e[o],a=new i(s,this,this.options.itemOptions);n.push(a)}return n},y.prototype._filterFindItemElements=function(t){t=n(t);for(var e=this.options.itemSelector,i=[],o=0,r=t.length;r>o;o++){var s=t[o];if(f(s))if(e){l(s,e)&&i.push(s);for(var a=s.querySelectorAll(e),h=0,u=a.length;u>h;h++)i.push(a[h])}else i.push(s)}return i},y.prototype.getItemElements=function(){for(var t=[],e=0,i=this.items.length;i>e;e++)t.push(this.items[e].element);return t},y.prototype.layout=function(){this._resetLayout(),this._manageStamps();var t=void 0!==this.options.isLayoutInstant?this.options.isLayoutInstant:!this._isLayoutInited;this.layoutItems(this.items,t),this._isLayoutInited=!0},y.prototype._init=y.prototype.layout,y.prototype._resetLayout=function(){this.getSize()},y.prototype.getSize=function(){this.size=c(this.element)},y.prototype._getMeasurement=function(t,e){var i,n=this.options[t];n?("string"==typeof n?i=this.element.querySelector(n):f(n)&&(i=n),this[t]=i?c(i)[e]:n):this[t]=0},y.prototype.layoutItems=function(t,e){t=this._getItemsForLayout(t),this._layoutItems(t,e),this._postLayout()},y.prototype._getItemsForLayout=function(t){for(var e=[],i=0,n=t.length;n>i;i++){var o=t[i];o.isIgnored||e.push(o)}return e},y.prototype._layoutItems=function(t,e){if(!t||!t.length)return this.emitEvent("layoutComplete",[this,t]),void 0;this._itemsOn(t,"layout",function(){this.emitEvent("layoutComplete",[this,t])});for(var i=[],n=0,o=t.length;o>n;n++){var r=t[n],s=this._getItemLayoutPosition(r);s.item=r,s.isInstant=e,i.push(s)}this._processLayoutQueue(i)},y.prototype._getItemLayoutPosition=function(){return{x:0,y:0}},y.prototype._processLayoutQueue=function(t){for(var e=0,i=t.length;i>e;e++){var n=t[e];this._positionItem(n.item,n.x,n.y,n.isInstant)}},y.prototype._positionItem=function(t,e,i,n){n?t.goTo(e,i):t.moveTo(e,i)},y.prototype._postLayout=function(){var t=this._getContainerSize();t&&(this._setContainerMeasure(t.width,!0),this._setContainerMeasure(t.height,!1))},y.prototype._getContainerSize=u,y.prototype._setContainerMeasure=function(t,e){if(void 0!==t){var i=this.size;i.isBorderBox&&(t+=e?i.paddingLeft+i.paddingRight+i.borderLeftWidth+i.borderRightWidth:i.paddingBottom+i.paddingTop+i.borderTopWidth+i.borderBottomWidth),t=Math.max(t,0),this.element.style[e?"width":"height"]=t+"px"}},y.prototype._itemsOn=function(t,e,i){function n(){return o++,o===r&&i.call(s),!0}for(var o=0,r=t.length,s=this,a=0,h=t.length;h>a;a++){var u=t[a];u.on(e,n)}},y.prototype.ignore=function(t){var e=this.getItem(t);e&&(e.isIgnored=!0)},y.prototype.unignore=function(t){var e=this.getItem(t);e&&delete e.isIgnored},y.prototype.stamp=function(t){if(t=this._find(t)){this.stamps=this.stamps.concat(t);for(var e=0,i=t.length;i>e;e++){var n=t[e];this.ignore(n)}}},y.prototype.unstamp=function(t){if(t=this._find(t))for(var e=0,i=t.length;i>e;e++){var n=t[e],o=d(this.stamps,n);-1!==o&&this.stamps.splice(o,1),this.unignore(n)}},y.prototype._find=function(t){return t?("string"==typeof t&&(t=this.element.querySelectorAll(t)),t=n(t)):void 0},y.prototype._manageStamps=function(){if(this.stamps&&this.stamps.length){this._getBoundingRect();for(var t=0,e=this.stamps.length;e>t;t++){var i=this.stamps[t];this._manageStamp(i)}}},y.prototype._getBoundingRect=function(){var t=this.element.getBoundingClientRect(),e=this.size;this._boundingRect={left:t.left+e.paddingLeft+e.borderLeftWidth,top:t.top+e.paddingTop+e.borderTopWidth,right:t.right-(e.paddingRight+e.borderRightWidth),bottom:t.bottom-(e.paddingBottom+e.borderBottomWidth)}},y.prototype._manageStamp=u,y.prototype._getElementOffset=function(t){var e=t.getBoundingClientRect(),i=this._boundingRect,n=c(t),o={left:e.left-i.left-n.marginLeft,top:e.top-i.top-n.marginTop,right:i.right-e.right-n.marginRight,bottom:i.bottom-e.bottom-n.marginBottom};return o},y.prototype.handleEvent=function(t){var e="on"+t.type;this[e]&&this[e](t)},y.prototype.bindResize=function(){this.isResizeBound||(i.bind(t,"resize",this),this.isResizeBound=!0)},y.prototype.unbindResize=function(){i.unbind(t,"resize",this),this.isResizeBound=!1},y.prototype.onresize=function(){function t(){e.resize()}this.resizeTimeout&&clearTimeout(this.resizeTimeout);var e=this;this.resizeTimeout=setTimeout(t,100)},y.prototype.resize=function(){var t=c(this.element),e=this.size&&t;e&&t.innerWidth===this.size.innerWidth||(this.layout(),delete this.resizeTimeout)},y.prototype.addItems=function(t){var e=this._getItems(t);if(e.length)return this.items=this.items.concat(e),e},y.prototype.appended=function(t){var e=this.addItems(t);e.length&&(this.layoutItems(e,!0),this.reveal(e))},y.prototype.prepended=function(t){var e=this._getItems(t);if(e.length){var i=this.items.slice(0);this.items=e.concat(i),this._resetLayout(),this.layoutItems(e,!0),this.reveal(e),this.layoutItems(i)}},y.prototype.reveal=function(t){if(t&&t.length)for(var e=0,i=t.length;i>e;e++){var n=t[e];n.reveal()}},y.prototype.hide=function(t){if(t&&t.length)for(var e=0,i=t.length;i>e;e++){var n=t[e];n.hide()}},y.prototype.getItem=function(t){for(var e=0,i=this.items.length;i>e;e++){var n=this.items[e];if(n.element===t)return n}},y.prototype.getItems=function(t){if(t&&t.length){for(var e=[],i=0,n=t.length;n>i;i++){var o=t[i],r=this.getItem(o);r&&e.push(r)}return e}},y.prototype.remove=function(t){t=n(t);var e=this.getItems(t);if(e&&e.length){this._itemsOn(e,"remove",function(){this.emitEvent("removeComplete",[this,e])});for(var i=0,o=e.length;o>i;i++){var r=e[i];r.remove();var s=d(this.items,r);this.items.splice(s,1)}}},y.prototype.destroy=function(){var t=this.element.style;t.height="",t.position="",t.width="";for(var e=0,i=this.items.length;i>e;e++){var n=this.items[e];n.destroy()}this.unbindResize(),delete this.element.outlayerGUID,h&&h.removeData(this.element,this.settings.namespace)},y.data=function(t){var e=t&&t.outlayerGUID;return e&&_[e]},y.create=function(t,i){function n(){y.apply(this,arguments)}return e(n.prototype,y.prototype),g(n,"options"),g(n,"settings"),e(n.prototype.options,i),n.prototype.settings.namespace=t,n.data=y.data,n.Item=function(){m.apply(this,arguments)},n.Item.prototype=new m,n.prototype.settings.item=n.Item,r(function(){for(var e=o(t),i=s.querySelectorAll(".js-"+e),r="data-"+e+"-options",u=0,p=i.length;p>u;u++){var f,d=i[u],c=d.getAttribute(r);try{f=c&&JSON.parse(c)}catch(l){a&&a.error("Error parsing "+r+" on "+d.nodeName.toLowerCase()+(d.id?"#"+d.id:"")+": "+l);continue}var m=new n(d,f);h&&h.data(d,t,m)}}),h&&h.bridget&&h.bridget(t,n),n},y.Item=m,y}var s=t.document,a=t.console,h=t.jQuery,u=function(){},p=Object.prototype.toString,f="object"==typeof HTMLElement?function(t){return t instanceof HTMLElement}:function(t){return t&&"object"==typeof t&&1===t.nodeType&&"string"==typeof t.nodeName},d=Array.prototype.indexOf?function(t,e){return t.indexOf(e)}:function(t,e){for(var i=0,n=t.length;n>i;i++)if(t[i]===e)return i;return-1};"function"==typeof define&&define.amd?define(["eventie/eventie","doc-ready/doc-ready","eventEmitter/EventEmitter","get-size/get-size","matches-selector/matches-selector","./item"],r):t.Outlayer=r(t.eventie,t.docReady,t.EventEmitter,t.getSize,t.matchesSelector,t.Outlayer.Item)}(window),function(t){"use strict";function e(t,e){var n=t.create("masonry");return n.prototype._resetLayout=function(){this.getSize(),this._getMeasurement("columnWidth","outerWidth"),this._getMeasurement("gutter","outerWidth"),this.measureColumns();var t=this.cols;for(this.colYs=[];t--;)this.colYs.push(0);this.maxY=0},n.prototype.measureColumns=function(){var t=this._getSizingContainer(),i=this.items[0],n=i&&i.element;this.columnWidth||(this.columnWidth=n?e(n).outerWidth:this.size.innerWidth),this.columnWidth+=this.gutter,this._containerWidth=e(t).innerWidth,this.cols=Math.floor((this._containerWidth+this.gutter)/this.columnWidth),this.cols=Math.max(this.cols,1)},n.prototype._getSizingContainer=function(){return this.options.isFitWidth?this.element.parentNode:this.element},n.prototype._getItemLayoutPosition=function(t){t.getSize();var e=Math.ceil(t.size.outerWidth/this.columnWidth);e=Math.min(e,this.cols);for(var n=this._getColGroup(e),o=Math.min.apply(Math,n),r=i(n,o),s={x:this.columnWidth*r,y:o},a=o+t.size.outerHeight,h=this.cols+1-n.length,u=0;h>u;u++)this.colYs[r+u]=a;return s},n.prototype._getColGroup=function(t){if(1===t)return this.colYs;for(var e=[],i=this.cols+1-t,n=0;i>n;n++){var o=this.colYs.slice(n,n+t);e[n]=Math.max.apply(Math,o)}return e},n.prototype._manageStamp=function(t){var i=e(t),n=this._getElementOffset(t),o=this.options.isOriginLeft?n.left:n.right,r=o+i.outerWidth,s=Math.floor(o/this.columnWidth);s=Math.max(0,s);var a=Math.floor(r/this.columnWidth);a=Math.min(this.cols-1,a);for(var h=(this.options.isOriginTop?n.top:n.bottom)+i.outerHeight,u=s;a>=u;u++)this.colYs[u]=Math.max(h,this.colYs[u])},n.prototype._getContainerSize=function(){this.maxY=Math.max.apply(Math,this.colYs);var t={height:this.maxY};return this.options.isFitWidth&&(t.width=this._getContainerFitWidth()),t},n.prototype._getContainerFitWidth=function(){for(var t=0,e=this.cols;--e&&0===this.colYs[e];)t++;return(this.cols-t)*this.columnWidth-this.gutter},n.prototype.resize=function(){var t=this._getSizingContainer(),i=e(t),n=this.size&&i;n&&i.innerWidth===this._containerWidth||(this.layout(),delete this.resizeTimeout)},n}var i=Array.prototype.indexOf?function(t,e){return t.indexOf(e)}:function(t,e){for(var i=0,n=t.length;n>i;i++){var o=t[i];if(o===e)return i}return-1};"function"==typeof define&&define.amd?define(["outlayer/outlayer","get-size/get-size"],e):t.Masonry=e(t.Outlayer,t.getSize)}(window);
/*!
 * imagesLoaded PACKAGED v3.0.4
 * JavaScript is all like "You images are done yet or what?"
 */

(function(){"use strict";function e(){}function t(e,t){for(var n=e.length;n--;)if(e[n].listener===t)return n;return-1}var n=e.prototype;n.getListeners=function(e){var t,n,i=this._getEvents();if("object"==typeof e){t={};for(n in i)i.hasOwnProperty(n)&&e.test(n)&&(t[n]=i[n])}else t=i[e]||(i[e]=[]);return t},n.flattenListeners=function(e){var t,n=[];for(t=0;e.length>t;t+=1)n.push(e[t].listener);return n},n.getListenersAsObject=function(e){var t,n=this.getListeners(e);return n instanceof Array&&(t={},t[e]=n),t||n},n.addListener=function(e,n){var i,r=this.getListenersAsObject(e),o="object"==typeof n;for(i in r)r.hasOwnProperty(i)&&-1===t(r[i],n)&&r[i].push(o?n:{listener:n,once:!1});return this},n.on=n.addListener,n.addOnceListener=function(e,t){return this.addListener(e,{listener:t,once:!0})},n.once=n.addOnceListener,n.defineEvent=function(e){return this.getListeners(e),this},n.defineEvents=function(e){for(var t=0;e.length>t;t+=1)this.defineEvent(e[t]);return this},n.removeListener=function(e,n){var i,r,o=this.getListenersAsObject(e);for(r in o)o.hasOwnProperty(r)&&(i=t(o[r],n),-1!==i&&o[r].splice(i,1));return this},n.off=n.removeListener,n.addListeners=function(e,t){return this.manipulateListeners(!1,e,t)},n.removeListeners=function(e,t){return this.manipulateListeners(!0,e,t)},n.manipulateListeners=function(e,t,n){var i,r,o=e?this.removeListener:this.addListener,s=e?this.removeListeners:this.addListeners;if("object"!=typeof t||t instanceof RegExp)for(i=n.length;i--;)o.call(this,t,n[i]);else for(i in t)t.hasOwnProperty(i)&&(r=t[i])&&("function"==typeof r?o.call(this,i,r):s.call(this,i,r));return this},n.removeEvent=function(e){var t,n=typeof e,i=this._getEvents();if("string"===n)delete i[e];else if("object"===n)for(t in i)i.hasOwnProperty(t)&&e.test(t)&&delete i[t];else delete this._events;return this},n.emitEvent=function(e,t){var n,i,r,o,s=this.getListenersAsObject(e);for(r in s)if(s.hasOwnProperty(r))for(i=s[r].length;i--;)n=s[r][i],o=n.listener.apply(this,t||[]),(o===this._getOnceReturnValue()||n.once===!0)&&this.removeListener(e,s[r][i].listener);return this},n.trigger=n.emitEvent,n.emit=function(e){var t=Array.prototype.slice.call(arguments,1);return this.emitEvent(e,t)},n.setOnceReturnValue=function(e){return this._onceReturnValue=e,this},n._getOnceReturnValue=function(){return this.hasOwnProperty("_onceReturnValue")?this._onceReturnValue:!0},n._getEvents=function(){return this._events||(this._events={})},"function"==typeof define&&define.amd?define(function(){return e}):"undefined"!=typeof module&&module.exports?module.exports=e:this.EventEmitter=e}).call(this),function(e){"use strict";var t=document.documentElement,n=function(){};t.addEventListener?n=function(e,t,n){e.addEventListener(t,n,!1)}:t.attachEvent&&(n=function(t,n,i){t[n+i]=i.handleEvent?function(){var t=e.event;t.target=t.target||t.srcElement,i.handleEvent.call(i,t)}:function(){var n=e.event;n.target=n.target||n.srcElement,i.call(t,n)},t.attachEvent("on"+n,t[n+i])});var i=function(){};t.removeEventListener?i=function(e,t,n){e.removeEventListener(t,n,!1)}:t.detachEvent&&(i=function(e,t,n){e.detachEvent("on"+t,e[t+n]);try{delete e[t+n]}catch(i){e[t+n]=void 0}});var r={bind:n,unbind:i};"function"==typeof define&&define.amd?define(r):e.eventie=r}(this),function(e){"use strict";function t(e,t){for(var n in t)e[n]=t[n];return e}function n(e){return"[object Array]"===c.call(e)}function i(e){var t=[];if(n(e))t=e;else if("number"==typeof e.length)for(var i=0,r=e.length;r>i;i++)t.push(e[i]);else t.push(e);return t}function r(e,n){function r(e,n,s){if(!(this instanceof r))return new r(e,n);"string"==typeof e&&(e=document.querySelectorAll(e)),this.elements=i(e),this.options=t({},this.options),"function"==typeof n?s=n:t(this.options,n),s&&this.on("always",s),this.getImages(),o&&(this.jqDeferred=new o.Deferred);var a=this;setTimeout(function(){a.check()})}function c(e){this.img=e}r.prototype=new e,r.prototype.options={},r.prototype.getImages=function(){this.images=[];for(var e=0,t=this.elements.length;t>e;e++){var n=this.elements[e];"IMG"===n.nodeName&&this.addImage(n);for(var i=n.querySelectorAll("img"),r=0,o=i.length;o>r;r++){var s=i[r];this.addImage(s)}}},r.prototype.addImage=function(e){var t=new c(e);this.images.push(t)},r.prototype.check=function(){function e(e,r){return t.options.debug&&a&&s.log("confirm",e,r),t.progress(e),n++,n===i&&t.complete(),!0}var t=this,n=0,i=this.images.length;if(this.hasAnyBroken=!1,!i)return this.complete(),void 0;for(var r=0;i>r;r++){var o=this.images[r];o.on("confirm",e),o.check()}},r.prototype.progress=function(e){this.hasAnyBroken=this.hasAnyBroken||!e.isLoaded;var t=this;setTimeout(function(){t.emit("progress",t,e),t.jqDeferred&&t.jqDeferred.notify(t,e)})},r.prototype.complete=function(){var e=this.hasAnyBroken?"fail":"done";this.isComplete=!0;var t=this;setTimeout(function(){if(t.emit(e,t),t.emit("always",t),t.jqDeferred){var n=t.hasAnyBroken?"reject":"resolve";t.jqDeferred[n](t)}})},o&&(o.fn.imagesLoaded=function(e,t){var n=new r(this,e,t);return n.jqDeferred.promise(o(this))});var f={};return c.prototype=new e,c.prototype.check=function(){var e=f[this.img.src];if(e)return this.useCached(e),void 0;if(f[this.img.src]=this,this.img.complete&&void 0!==this.img.naturalWidth)return this.confirm(0!==this.img.naturalWidth,"naturalWidth"),void 0;var t=this.proxyImage=new Image;n.bind(t,"load",this),n.bind(t,"error",this),t.src=this.img.src},c.prototype.useCached=function(e){if(e.isConfirmed)this.confirm(e.isLoaded,"cached was confirmed");else{var t=this;e.on("confirm",function(e){return t.confirm(e.isLoaded,"cache emitted confirmed"),!0})}},c.prototype.confirm=function(e,t){this.isConfirmed=!0,this.isLoaded=e,this.emit("confirm",this,t)},c.prototype.handleEvent=function(e){var t="on"+e.type;this[t]&&this[t](e)},c.prototype.onload=function(){this.confirm(!0,"onload"),this.unbindProxyEvents()},c.prototype.onerror=function(){this.confirm(!1,"onerror"),this.unbindProxyEvents()},c.prototype.unbindProxyEvents=function(){n.unbind(this.proxyImage,"load",this),n.unbind(this.proxyImage,"error",this)},r}var o=e.jQuery,s=e.console,a=s!==void 0,c=Object.prototype.toString;"function"==typeof define&&define.amd?define(["eventEmitter/EventEmitter","eventie/eventie"],r):e.imagesLoaded=r(e.EventEmitter,e.eventie)}(window);
/*!
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
$(".href").colorbox({width:"35%", inline:true, href:"#href_dialog"});$("a[rel='external']").colorbox({width:"85%", height:"90%", iframe:true});$(".mood").colorbox({width:"35%", inline:true, href:"#moods_dialog"});}
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
// options
itemSelector: '.white_box2',
isOriginLeft: false,
gutter: 8
});$('#container').imagesLoaded( function() {
  msnry.layout();
});
}
catch (e){
alert (e);
}
}

$(document).ready(function(){$(".colorbox").colorbox();
$("a[rel='external']").colorbox({width:"80%", height:"80%", iframe:true});$("a[title='legend']").colorbox({width:"85%"});
$(".href").colorbox({width:"35%", inline:true, href:"#href_dialog"});
$(".imghref").colorbox({width:"35%", inline:true, href:"#href_img_dialog"});
$(".mood").colorbox({width:"35%", inline:true, href:"#moods_dialog"});
$(".user_icon").colorbox({width:"35%", inline:true, href:"#user_icon_dialog"});
$("#login").colorbox({width:"255px", height:"270px", inline:true, top:"40px", href:"#loginform"});
$(".register").colorbox({width:"255px", height:"410px", inline:true, top:"40px", fixed:true,href:"#registerform"});
$("#forgotpass").colorbox({width:"255px", height:"200px", inline:true, top:"40px", fixed:true, href:"#passforgotform",onOpen:function(){}});
$("#updateprofile").colorbox({width:"255px", inline:true, top:"40px",fixed:true, href:"#profileform"});
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
{$('#'+id).show("fast");}
else
$('#'+ id).hide("fast");}}
function show(id){$('#'+id).show("fast");}
function hide(id){$('#'+id).hide("fast");}
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
     document.getElementById("latestnow").style.display = "none";
     document.getElementById("latesttemp").style.display = "none";
     document.getElementById("latestpressure").style.display = "none";
     document.getElementById("latesthumidity").style.display = "none";
     document.getElementById("latestuv").style.display = "none";
     document.getElementById("latestradiation").style.display = "none";
     document.getElementById("latestrain").style.display = "none";
     document.getElementById("latestwind").style.display = "none";
     document.getElementById("latestairq").style.display = "none";
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
     document.getElementById("aq_line").style.visibility = "hidden";
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
    document.getElementById("forum_hr").style.marginTop = "210px";
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
                 $("#user_name").html(jsonT.user.display);
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
                 $("#user_name").html('<?=$LOGIN[$lang_idx]?>/<?=$REGISTER[$lang_idx]?>');
                 $("#user_icon").attr('class', '');
                 toggle('loggedin');
                 toggle('notloggedin');

                 fillMessage('<img src="img/loading.gif" alt="loading" width="50" height="50"/>');
                $.ajax({
                    type: "POST",
                    url: "chat_service.php",
                    data: {lang:lang, from:limit, update:update},
               }).done(function(str){fillMessage(str);});
            }



        });
        }
        function getMessageService(from, to, start, update, lang, category)
	{	
		if (update==1)
                    tinyMCE.triggerSave();
		var name = $('#profileform_displayname').val();
		var body = $('#new_post_ta').val();
                var mood_elm = "";
                var private = 0;
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
		
		var postData = "lang=" + lang + "&from=" + limit + "&to=" + to + "&private=" + private +"&startLine=" + start + "&category=" + category + "&idx=" + idx + "&name=" + escape(encodeURI(name)) + "&searchname=" + escape(encodeURI(searchname)) + "&body=" + escape(encodeURI(body)) + "&mood=" + escape(encodeURI(mood_elm))  + "&update=" + update;
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
            getMessageService(limit, '', $('#current_forum_startline').val(), 0, lang);
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
                                alert('<?=$USER_LOCKED[$lang_idx]?>');
                             $("#loginform_result").text(jsonT.user.display);
                             $("#loginform_result").addClass('high');
                         }
                       else {
                         $("#cboxClose").click();
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
		          priority:$("#profileform_priority").is(':checked') ? 1 : 0 }
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
                  url: "checkauth.php?action=getuser&lang=" + lang
                }).done(function( jsonstr ) {
                  try{

                     var jsonT = JSON.parse( jsonstr  );
                     if (!jsonT.user.loggedin)
                         {
                            toggle('notloggedin');
                            $("#user_name").html('<?=$LOGIN[$lang_idx]?>/<?=$REGISTER[$lang_idx]?>');
                            $("#chosen_user_icon").val($("#user_icon_contentbox").children().first().children().first().attr('class'));
                            if (jsonT.user.locked)
                                alert('<?=$USER_LOCKED[$lang_idx]?>');
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
            tinymce.init({selector:'textarea',menubar : false, height : "80px", theme: "modern", skin: 'light', forced_root_block : false, directionality : dir, execcommand_callback: "tinyExecCommand", extended_valid_elements : 'iframe[title|class|type|width|height|src|frameborder|allowFullScreen]', content_css : "css/main.php?lang=<?=$lang_idx?>", language: 'he_IL', statusbar: false, toolbar: "emoticons | bullist numlist | link image | bold italic",plugins : 'autolink link image emoticons media'});
            
            
            
     }
//
// startup script
//
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
