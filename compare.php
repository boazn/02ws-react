<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
<title>Comparison</title>
<style type="text/css">
<!-- 
.hlink {color: #deb887; cursor:hand; text-decoration: none; } 
. {font-family:Verdana; font-size:12px;}
.big {font-size:16px ;font-weight:bold;}
-->
</style>
</head>
<body bgcolor="#003a4e" text="#ffffff" >

<?php  $tempchange=$HTTP_GET_VARS['tempchange']; 
			 $humchange=$HTTP_GET_VARS['humchange']; 
			 $windchange=$HTTP_GET_VARS['windchange']; 
			 $prschange=$HTTP_GET_VARS['prschange']; 
			 $ytime=$HTTP_GET_VARS['ytime'];
			 $broken=$HTTP_GET_VARS['broken'];
			 $period=$HTTP_GET_VARS['period'];
			 $ext_data=$HTTP_GET_VARS['extdata'];
			 $highorlow=$HTTP_GET_VARS['highorlow'];?>
<center>
<big>change<br> from <br><u><a href="reports/downld02.txt" class=hlink target="_blank" onmouseover="this.style.color=16777215" onmouseout="this.style.color=14596231" >Yesterday</a></u></big>
<?php  echo $ytime; ?><br><br>
<a href="javascript:void(0)" onclick=tpopup('./images/profile2/OutsideTempHistory.gif') onMouseOver=showImage('OutsideTempHistory') onmouseout=hideImage()  class="hlink" alt="show graph">Temp: </a><?php if ($tempchange > 0) echo "<font color=#ff0000 class=big>+"; 
							 else echo "<font color=#00ccff class=big>"; 
							 echo $tempchange,"C","</font>";?>
<br>
<a href="javascript:void(0)" onclick=tpopup('./images/profile2/OutsideHumidityHistory.gif') onmouseover=showImage('OutsideHumidityHistory') onmouseout=hideImage()  class="hlink" alt="show graph">Hum: </a> <?php if ($humchange > 0) echo "+"; echo "${humchange}%"; ?></big>
<br>
<a href="javascript:void(0)" onclick=tpopup('./images/profile2/WindDirectionHistory.gif') onmouseover=showImage('WindDirectionHistory') onmouseout=hideImage()  class="hlink" alt="show graph">Wind: </a> <?php if ($windchange > 0) echo "+"; echo "${windchange}Kt";?>
<br>
<a href="javascript:void(0)" onclick=tpopup('./images/profile2/BarometerHistory.gif') onmouseover=showImage('BarometerHistory') onmouseout=hideImage()  class="hlink" alt="show graph">Bar: </a> <?php if ($prschange > 0) echo "+"; echo "${prschange}mb";?>
<br><br>
</center>
<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
 codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0"
 WIDTH=140 HEIGHT=160>
 <PARAM NAME=movie VALUE="TextTicker.swf"> <PARAM NAME=menu VALUE=false> <PARAM NAME=quality VALUE=high> <PARAM NAME=scale VALUE=noborder> <PARAM NAME=bgcolor VALUE=#000000> <EMBED src="TextTicker.swf" menu=false quality=high scale=noborder bgcolor=#000000  WIDTH=140 HEIGHT=160 TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash"></EMBED>
</OBJECT>
<br><br>
<center>
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"  width="100" height="28">
<param name="movie" value="images/button03.swf">
<param name="play" value="true">
<param name="loop" value="true">
<param name="quality" value="high">
<param name="WMode" value="Transparent">
<embed width="100" height="28" src="images/button03.swf" play="true" loop="true" quality="high" WMode="Transparent" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash"></embed>
</object> 
</center>
<script language="JavaScript1.2">
imgTemp = new Image();
imgHum = new Image();
imgWind = new Image();
imgBar = new Image();
imgTemp.src = "images/profile2/OutsideTempHistory.gif";
imgWind.src = "images/profile2/WindDirectionHistory.gif";
imgHum.src = "images/profile2/OutsideHumidityHistory.gif";
imgBar.src = "images/profile2/BarometerHistory.gif";
function showImage(name){
  if	(window.parent.currImage)	{
			window.parent.spanImage.style.display = "";
			if (name == "WindDirectionHistory")
				window.parent.currImage.src = imgWind.src;
			else if (name == "OutsideHumidityHistory")
				window.parent.currImage.src = imgHum.src;
			else if (name == "OutsideTempHistory")
				window.parent.currImage.src = imgTemp.src;
			else if (name == "BarometerHistory")
				window.parent.currImage.src = imgBar.src;
			window.parent.currImage.width = 400;
			window.parent.spanImage.style.left = "28%";
			window.parent.spanImage.style.top = "15%";
		
	}
	
}
function hideImage(){
	if (window.parent.currImage)	
		window.parent.spanImage.style.display = "none";
		
}
function tpopup(s){
	newwin = window.open(s, "Graph", "scrollbars=no,status=no,toolbar=no,directories=no,menubar=no,location=no,resizable=yes,width=350,height=230");
	newwin.focus();
}
</script>
</body>
</html>
