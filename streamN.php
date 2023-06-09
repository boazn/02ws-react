<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>Yawcam</title>
<style type="text/css">
div.menu
{
	margin: 0px;
	display: none;
	width: 80px;
	border: 1px solid black;
	background: #3F3F3F;
	background-image: url(img/bg.gif);
	padding: 2px 0px;	
	font-family: verdana, arial, helvetica, sans-serif;
	font-weight: 600;
	font-size: 14px;
	color: #FFFFFF;  
	text-decoration: none;	
	border-right: none;	
	position: absolute;
}

div.passLayer
{
	margin: 0px;
	display: none;
	width: 640px;
	height: 480px;
	border: 1px solid black;
	background: none;
	background-image: url(err);//none; //trick IE there is something in layer
	padding: 0px 0px;
	font-family: verdana, arial, helvetica, sans-serif;
	font-weight: 600;
	font-size: 14px;
	color: #000000;
	text-decoration: none;
	position: absolute;
	z-index: 5;
}

div.menu_child
{
	margin: 0px;
	display: none;
	border: none;
	padding: 0px 0px;
	position: absolute;
}

a.menu_Item
{
  display: block;
  margin: 0px;  
  border: 1px solid black;
  background: #FBFBFB;
  padding: 2px 6px;
  font-family: verdana, arial, helvetica, sans-serif;
  font-size: 12px;
  font-weight: 400;
  color: #6C6C6C;
  width: 85px;
  border-bottom: none;
  text-decoration: none;
}

.heading {color: #000000;}
.text a:link{ color: #4589ff;}
.text a:visited {color: #4589ff;}
.text a:hover {color: #ff0000;}
.text a:active { color: #ff0000;}
.text
{
  font-size: 14px;
  font-family: Verdana, Arial, Helvetica, sans-serif;
  color: #000000;
}

</style>
<script type="text/javascript">
<!-- 

var fps = 3;
var quality = 40;
var timeout = 33;
var baseURL = "http://jweather.dyndns.org:8081/"; //change this to "http://_yawcam_computer_address:port/" when running on own server.
var t_;
var i_;
var ct_;
var id;
var xmlHttp;
var firstReq=true;
var state = "null";

function updateID()
{
	id = Math.random();
}

function setFps(val)
{
	fps = val;
	timeout = Math.round(1000.0/fps);
}

function setQ(val)
{
	quality = val;
}

function scaleIn()
{
	document.images.camImg.width = document.images.camImg.width + 40;
	document.images.camImg.height = document.images.camImg.height + 30;
}

function scaleOut()
{
	document.images.camImg.width = document.images.camImg.width - 40;
	document.images.camImg.height = document.images.camImg.height - 30;
}

function scaleOrg()
{
	document.images.camImg.width = 640;
	document.images.camImg.height = 480;
}

function showLayer(theLayer)
{
	getLayer(theLayer).style.display = "block";
}

function hideLayer(theLayer)
{
	getLayer(theLayer).style.display = "none";
}

function hideAllMenuLayers()
{
	hideLayer('menu_fps');
	hideLayer('menu_fps_child');
	hideLayer('menu_quality');
	hideLayer('menu_quality_child');
	hideLayer('menu_scale');
	hideLayer('menu_scale_child');
	hideLayer('menu_about');
	hideLayer('menu_about_child');
}

function hideAllMenuChildren()
{
	hideLayer('menu_fps_child');
	hideLayer('menu_quality_child');
	hideLayer('menu_scale_child');
	hideLayer('menu_about_child');
}

function showAllMenuCols()
{
	showLayer('menu_fps');
	showLayer('menu_quality');
	showLayer('menu_scale');
	showLayer('menu_about');
}

function fixMenuColPos(owner)
{
	setLyr(owner,'menu_fps',false,0);
	setLyr(owner,'menu_quality',false,1);
	setLyr(owner,'menu_scale',false,2);
	setLyr(owner,'menu_about',false,3);
}

function getLayer(theLayer)
{
	var obj = null;
	if (document.getElementById)
	{
		obj = document.getElementById(theLayer);
	}
	else if (document.all)
	{
		obj = document.all[theLayer];
	}
	else if (document.layers)
	{
		obj = document.layers[theLayer];
	}
	return obj;
}

function getMarker(val,testVal)
{
	var str = null;
	if(val == testVal)
	{
		str = "<img src=\"img/mrk.gif\" style=\"border:none;vertical-align: text-bottom;margin: 0px;\" alt=\"<--\">";
	}
	else 
	{
		str = "";
	}
	return str;
}

function showErrorImage()
{
	clearTimeout(t_);
	clearInterval(i_);
	document.images.camImg.onload = "";
	document.images.camImg.src = "http://www.yawcam.com/offline.jpg";
	window.status = "Webcam offline";
}

function showStatusImage(imgUrl)
{
	clearTimeout(t_);
	clearInterval(i_);
	document.images.camImg.onload = "";
	document.images.camImg.src = imgUrl;
}

function reloadImage()
{
	var theDate = new Date();
	var url = baseURL + "out.jpg?";
	url += ("q="+quality);
	url += ("&id="+id);
	url += "&r=";
	url += theDate.getTime().toString();
	document.images.camImg.src = url;	
	window.status = "Yawcam streaming...";
}

function fixImageTimeout()
{
	t_ = setTimeout("reloadImage();",timeout);
}

function cTO()
{
	if(state=="running")
	{
		clearTimeout(t_);
		reloadImage();
	}
}

function updateFpsMenu()
{
	document.getElementById('fps_30').innerHTML = "30 " + getMarker(fps,30);
	document.getElementById('fps_15').innerHTML = "15 " + getMarker(fps,15);
	document.getElementById('fps_10').innerHTML = "10 " + getMarker(fps,10);
	document.getElementById('fps_5').innerHTML = "5 " + getMarker(fps,5);
	document.getElementById('fps_1').innerHTML = "1 " + getMarker(fps,1);
}

function updateQualityMenu()
{
	document.getElementById('q_75').innerHTML = "75 % " + getMarker(quality,75);
	document.getElementById('q_50').innerHTML = "50 % " + getMarker(quality,50);
	document.getElementById('q_40').innerHTML = "40 % " + getMarker(quality,40);
	document.getElementById('q_30').innerHTML = "30 % " + getMarker(quality,30);
	document.getElementById('q_20').innerHTML = "20 % " + getMarker(quality,20);
	document.getElementById('q_10').innerHTML = "10 % " + getMarker(quality,10);
	document.getElementById('q_5').innerHTML = "5 % " + getMarker(quality,5);
	document.getElementById('q_1').innerHTML = "1 % " + getMarker(quality,1);
}

function setLyr(obj,lyr,drop,col)
{
	var coors = findPos(obj);
	var x = document.getElementById(lyr);
	if(drop == true)
	{
		coors[1] = coors[1]+26;
	}
	x.style.top = coors[1] + 'px';
	coors[0] = coors[0]+(col*80);
	x.style.left = coors[0] + 'px';
}

function findPos(obj)
{
	var curleft = curtop = 0;
	if (obj.offsetParent) 
	{
		curleft = obj.offsetLeft
		curtop = obj.offsetTop
		while (obj = obj.offsetParent) 
		{
			curleft += obj.offsetLeft
			curtop += obj.offsetTop
		}
	}
	return [curleft,curtop];
}	

function startPoll()
{
	document.images.camImg.onload=fixImageTimeout
	fixConnectTimeout();
	getStatus();	
}

function fixStatusTimeout()
{
	ts_ = setTimeout("getStatus();",2000);
}

function fixConnectTimeout()
{
	ct_ = setTimeout("showErrorImage();",4000);
}

function getStatus()
{
	xmlHttp=GetXmlHttpObject()
	if(xmlHttp==null)
	{
		alert("Browser does not support HTTP Request")
		return
	}
	var url=baseURL+"get?id="+id+"&r="+Math.random()
	xmlHttp.onreadystatechange=stateChanged
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
}

function sendPass()
{
	xmlHttp=GetXmlHttpObject()
	if(xmlHttp==null)
	{
		alert("Browser does not support HTTP Request")
		return
	}
	var user = document.getElementById('user').value;
	var pass = document.getElementById('pass').value;
	var url=baseURL+"get?id="+id+"&u="+user+"&p="+pass+"&r="+Math.random()
	xmlHttp.onreadystatechange=stateChanged
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
} 

function stateChanged()
{
	if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		if(xmlHttp.status==200)
		{
			if(xmlHttp.responseText=="ok")
			{
				if(firstReq)
				{
					i_ = setInterval("getStatus();",2000);
					clearTimeout(ct_);
					hideLayer('passLyr');
					firstReq=false;
					state="running";
					document.images.camImg.onload=fixImageTimeout
					reloadImage();					
				}
			} 
			else if(xmlHttp.responseText=="2many")
			{
				clearTimeout(ct_);
				state="2many";
				showStatusImage("img/toomany.jpg");
				window.status = "Try later...";				
			} 
			else if(xmlHttp.responseText=="banned")
			{
				clearTimeout(ct_);
				state="banned";
				showStatusImage("img/banned.jpg");				
				window.status = "You are banned.";
			} 
			else if(xmlHttp.responseText=="dataLimit")
			{
				state="datalimit";
				showStatusImage("img/datalimit.jpg");
				window.status = "You hit data limit.";
			} 
			else if(xmlHttp.responseText=="timeLimit")
			{
				state="timelimit";
				showStatusImage("img/timelimit.jpg");
				window.status = "You hit time limit.";
			} 
			else if(xmlHttp.responseText=="kicked")
			{
				state="kicked";
				showStatusImage("img/kicked.jpg");
				window.status = "You are kicked.";
			} 
			else if(xmlHttp.responseText=="passErr")
			{
				state="passErr";
				document.getElementById('passHeading').innerHTML = '<font color="#FF0000">Login Error!</font>';
				window.status = "Login Error!";
			} 
			else if(xmlHttp.responseText=="pass")
			{
				clearTimeout(ct_);
				state="pass";
				showStatusImage("img/pass.jpg");
				setLyr(document.getElementById('camImg'),'passLyr',false,0);
				showLayer('passLyr');
			} 
			else 
			{
				state="error";
				showErrorImage();
				window.status = "Error...";
				alert("Unknown response: "+xmlHttp.responseText);
			}
		} 
		else if (xmlHttp.status==404)
		{
			//alert("Got 404");
		}
	}
}

function GetXmlHttpObject()
{	
	var XMLHttp_=null
	try
	{
		XMLHttp_=new ActiveXObject("Msxml2.XMLHTTP")
	}
	catch(e)
	{
		try
		{
			XMLHttp_=new ActiveXObject("Microsoft.XMLHTTP")
		}catch(e){}
	}

	if (XMLHttp_==null)
	{
		XMLHttp_=new XMLHttpRequest()
	}

	return XMLHttp_;
}

-->
</script>
</head>

<body style="background-color: #ffffff; background-image: none;">

	<div id="imgLyr" align="center">	
  	<p class="heading"><strong><font size="5" face="Verdana, Arial, Helvetica, sans-serif">It's a webcam!</font></strong> </p>

	<img id="camImg" src="img/loading.jpg" onMouseOver="javascript:fixMenuColPos(this);showAllMenuCols();" onMouseOut="javascript:hideAllMenuLayers();" onLoad="javascript:updateID();startPoll()" onError="javascript:showErrorImage()" width=640 height=480 style="border: 1px solid #000000;">	
	</div>
	
	<div align="center"><br /><div align="left" style="width: 400px;" class="text"><p></p></div></div>
	
	<p align="center" class="text" style="font-size: 10px;">Powered by <a href="http://www.yawcam.com" target="_blank">www.yawcam.com</a></p>
	
	<div id="passLyr" class="passLayer" onMouseOver="javascript:showLayer('passLyr');"> 	  
	  
  <div align="center" style="padding: 20px 20px;position: relative;" onMouseOver="javascript:hideAllMenuLayers();showLayer('passLyr');"> 
    <table width="199" border="0" cellspacing="0" cellpadding="0">
      <tr> 
        <td> <p id="passHeading" align="center">Password Please!</p>

          <form name="form" action="javascript:sendPass()">
            <p align="center">User: 
              <input name="user" type="text" id="user">
            </p>
            <p align="center">Pass: 
              <input name="pass" type="password" id="pass">
            </p>
            <p align="right"> 
              <input name="login" type="submit" id="login" value="Login">
            </p>

          </form></td>
      </tr>
    </table>
  </div>
	</div>

	<div id="menu_fps" class="menu" onMouseOver="javascript:showAllMenuCols();hideAllMenuChildren();updateFpsMenu();setLyr(this,'menu_fps_child',true,0);showLayer('menu_fps_child');">
	<center>Fps</center>
	</div>

	<div id="menu_quality" class="menu" onMouseOver="javascript:showAllMenuCols();hideAllMenuChildren();updateQualityMenu();setLyr(this,'menu_quality_child',true,0);showLayer('menu_quality_child');">
	<center>Quality</center>
	</div>

	<div id="menu_scale" class="menu" onMouseOver="javascript:showAllMenuCols();hideAllMenuChildren();setLyr(this,'menu_scale_child',true,0);showLayer('menu_scale_child');">
	<center>Scale</center>
	</div>

	<div id="menu_about" class="menu" style="border-right: 1px solid black;" onMouseOver="javascript:showAllMenuCols();hideAllMenuChildren();setLyr(this,'menu_about_child',true,0);showLayer('menu_about_child');">
	<center>About</center>
	</div>

	<div id="menu_fps_child" class="menu_child" onMouseOver="javascript:showAllMenuCols();showLayer('menu_fps_child');" onMouseOut="javascript:hideLayer('menu_fps_child');" onClick="javascript:updateFpsMenu();hideLayer('menu_fps_child');">
	<a id="fps_30" class="menu_Item" href="javascript:setFps(30);cTO();" onMouseOver="this.style.backgroundColor='#CEE6F9'" onMouseOut="this.style.backgroundColor='#FBFBFB'" onFocus="this.blur()">30 </a>
	<a id="fps_15" class="menu_Item" href="javascript:setFps(15);cTO();" onMouseOver="this.style.backgroundColor='#CEE6F9'" onMouseOut="this.style.backgroundColor='#FBFBFB'" onFocus="this.blur()">15 </a>
	<a id="fps_10" class="menu_Item" href="javascript:setFps(10);cTO();" onMouseOver="this.style.backgroundColor='#CEE6F9'" onMouseOut="this.style.backgroundColor='#FBFBFB'" onFocus="this.blur()">10 </a>

	<a id="fps_5"  class="menu_Item" href="javascript:setFps(5);cTO();"  onMouseOver="this.style.backgroundColor='#CEE6F9'" onMouseOut="this.style.backgroundColor='#FBFBFB'" onFocus="this.blur()">5 </a>
	<a id="fps_1"  class="menu_Item" style="border-bottom: 1px solid black;" href="javascript:setFps(1);cTO();" onMouseOver="this.style.backgroundColor='#CEE6F9'" onMouseOut="this.style.backgroundColor='#FBFBFB'" onFocus="this.blur()">1 </a>
	</div>

	<div id="menu_quality_child" class="menu_child" onMouseOver="javascript:showAllMenuCols();showLayer('menu_quality_child');" onMouseOut="javascript:hideLayer('menu_quality_child');" onClick="javascript:updateQualityMenu();hideLayer('menu_quality_child');">
	<a id="q_75" class="menu_Item" href="javascript:setQ(75);cTO();" onMouseOver="this.style.backgroundColor='#CEE6F9'" onMouseOut="this.style.backgroundColor='#FBFBFB'" onFocus="this.blur()">75 % </a>
	<a id="q_50" class="menu_Item" href="javascript:setQ(50);cTO();" onMouseOver="this.style.backgroundColor='#CEE6F9'" onMouseOut="this.style.backgroundColor='#FBFBFB'" onFocus="this.blur()">50 % </a>

	<a id="q_40" class="menu_Item" href="javascript:setQ(40);cTO();" onMouseOver="this.style.backgroundColor='#CEE6F9'" onMouseOut="this.style.backgroundColor='#FBFBFB'" onFocus="this.blur()">40 % </a>
	<a id="q_30" class="menu_Item" href="javascript:setQ(30);cTO();" onMouseOver="this.style.backgroundColor='#CEE6F9'" onMouseOut="this.style.backgroundColor='#FBFBFB'" onFocus="this.blur()">30 % </a>
	<a id="q_20" class="menu_Item" href="javascript:setQ(20);cTO();" onMouseOver="this.style.backgroundColor='#CEE6F9'" onMouseOut="this.style.backgroundColor='#FBFBFB'" onFocus="this.blur()">20 % </a>
	<a id="q_10" class="menu_Item" href="javascript:setQ(10);cTO();" onMouseOver="this.style.backgroundColor='#CEE6F9'" onMouseOut="this.style.backgroundColor='#FBFBFB'" onFocus="this.blur()">10 % </a>
	<a id="q_5"  class="menu_Item" href="javascript:setQ(5);cTO();"  onMouseOver="this.style.backgroundColor='#CEE6F9'" onMouseOut="this.style.backgroundColor='#FBFBFB'" onFocus="this.blur()">5 % </a>
	<a id="q_1"  class="menu_Item" style="border-bottom: 1px solid black;" href="javascript:setQ(1);cTO();" onMouseOver="this.style.backgroundColor='#CEE6F9'" onMouseOut="this.style.backgroundColor='#FBFBFB'" onFocus="this.blur()">1 % </a>

	</div>

	<div id="menu_scale_child" class="menu_child" onMouseOver="javascript:showAllMenuCols();showLayer('menu_scale_child');" onMouseOut="javascript:hideLayer('menu_scale_child');" onClick="javascript:hideLayer('menu_scale_child');">
	<a id="z1" class="menu_Item" href="javascript:scaleIn();cTO();" onMouseOver="this.style.backgroundColor='#CEE6F9'" onMouseOut="this.style.backgroundColor='#FBFBFB'" onFocus="this.blur()">Up</a>
	<a id="z2" class="menu_Item" href="javascript:scaleOut();cTO();" onMouseOver="this.style.backgroundColor='#CEE6F9'" onMouseOut="this.style.backgroundColor='#FBFBFB'" onFocus="this.blur()">Down</a>
	<a id="z3" class="menu_Item" style="border-bottom: 1px solid black;" href="javascript:scaleOrg();cTO();" onMouseOver="this.style.backgroundColor='#CEE6F9'" onMouseOut="this.style.backgroundColor='#FBFBFB'" onFocus="this.blur()">1:1</a>
	</div>

	<div id="menu_about_child" class="menu_child" onMouseOver="javascript:showAllMenuCols();showLayer('menu_about_child');" onMouseOut="javascript:hideLayer('menu_about_child');" onClick="javascript:hideLayer('menu_about_child');">
	<a id="a1" class="menu_Item" href="http://www.yawcam.com" onMouseOver="this.style.backgroundColor='#CEE6F9'" onMouseOut="this.style.backgroundColor='#FBFBFB'" onFocus="this.blur()">Yawcam</a>
	<a id="a2" class="menu_Item" style="border-bottom: 1px solid black;" href="http://www.yawcam.com/menuinfo.php" onMouseOver="this.style.backgroundColor='#CEE6F9'" onMouseOut="this.style.backgroundColor='#FBFBFB'" onFocus="this.blur()">This menu</a>
	</div>

</body>
</html>