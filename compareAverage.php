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

<?php     			 
			$hightemp_diff=$HTTP_GET_VARS['hitempdif'];
			$lowtemp_diff=$HTTP_GET_VARS['lowtempdif'];
			$highhum_diff=$HTTP_GET_VARS['hihumdif'];
			$lowhum_diff=$HTTP_GET_VARS['lowhumdif'];
			$rainperc=$HTTP_GET_VARS['rainperc'];
			$raindiff=$HTTP_GET_VARS['raindiff'];
			$rainMonthDiff=$HTTP_GET_VARS['rainMonthDiff'];   
			$rainMonthPerc=$HTTP_GET_VARS['rainMonthPerc'];
?>
<big><center>Difference</center> <center>from</center> <center><u><a href="averages.php" class=hlink target="_blank" onmouseover="this.style.color=16777215" onmouseout="this.style.color=14596231" >average</a></u></center></big>
<br>
<center>
<a title="compared to its decade accumulation from the start (1/9)" align="center" class=hlink target="_blank" href="javascript:void(0)" onclick=tpopup('./images/profile2/RainHistory.gif') onMouseOver=showImage('RainHistory') onmouseout=hideImage()>Rain</a>
<br><u>Total&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Month</u><br> 
<?php 
      if ($raindiff > 0) echo "+"; echo $raindiff,"mm","&nbsp;&nbsp;&nbsp;&nbsp;";
	  if ($rainMonthDiff > 0) echo "+"; echo $rainMonthDiff,"mm<br>";
	  echo $rainperc,"%","&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$rainMonthPerc,"%";
?>
<br><br>

<a title="compared to its month" align=center class=hlink target="_blank" >High Temp</a><br> <?php if ($hightemp_diff > 0) echo "+"; echo $hightemp_diff,"C";?>
<br>
<a title="compared to its month" align=center class=hlink target="_blank" >Low Temp</a><br> <?php if ($lowtemp_diff > 0) echo "+"; echo $lowtemp_diff,"C";?>
<br><br>
<a title="compared to its month" align=center class=hlink target="_blank" >High Hum</a><br> <?php if ($highhum_diff > 0) echo "+"; echo $highhum_diff,"%";?>
<br>
<a title="compared to its month" align=center class=hlink target="_blank" >Low Hum</a><br> <?php if ($lowhum_diff > 0) echo "+"; echo $lowhum_diff,"%";?>
</center>

<script language="JavaScript1.2">
imgRain = new Image();
imgRain.src = "images/profile2/RainHistory.gif";
function showImage(name){
  if	(window.parent.currImage)	{
			window.parent.spanImage.style.display = "";
			if (name == "RainHistory")
				window.parent.currImage.src = imgRain.src;
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