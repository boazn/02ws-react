<html>
<head>
<title>VisionGS</title>
</head>
<body >
<center>
<h1><? echo($DAILY_LOOP[$lang_idx]);?></h1>
<table>
<tr>
	<td>
		<object id="MediaPlayer1" 
   width="500" 
   height="333" 
   classid="CLSID:22D6F312-B0F6-11D0-94AB-0080C74C7E95" 
   codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701" 
   standby="Jerusalem Weather Station 02ws.com" 
  type="application/x-oleobject" align="middle">
  <param name="FileName" value="images/02ws.avi"> 
  <param name="ShowStatusBar" value="true"> 
  <param name="DefaultFrame" value="mainFrame"> 
  <param name="ShowControls" value="true"> 
  <param name="ShowDisplay" value="false"> 
  <param name="enableContextMenu" value="true">
  <param name="AutoSize" value="false">
  <PARAM NAME="AutoRewind" VALUE="0">
  <param name="ShowTracker" value="1">
  <PARAM name="uiMode" value="full">
  <embed type="application/x-mplayer2" 
  pluginspage = "http://www.microsoft.com/Windows/MediaPlayer/" 
  src="images/02ws.avi" 
  width="500" 
  height="333" 
  defaultframe="mainFrame" 
  autosize="0"
  showstatusbar="1"
  autorewind="0"
  clip="Jerusalme Weather Station 02ws"
  >
   </embed> 
	</object>
	<br/>
	<? if (isHeb()) { ?>
		אם זה לא עובד נסה להוריד את הקובץ למחשב
	<? } else { ?>
		If it does not work try to download movie
	<? } ?>

	<br/>
	<a title="direct link to download" href="images/02ws.avi" class="hlink">
		<? if (isHeb()) { ?>
			לינק להורדה
		<? } else { ?>
			link to download and play
		<? } ?>
	</a>
	<br/>
	
	</td>
	<td width="160px" <? if (isHeb()) echo "dir=\"rtl\""; ?>>
		<script type="text/javascript"><!--
		google_ad_client = "pub-2706630587106567";
		google_ad_width = 120;
		google_ad_height = 240;
		google_ad_format = "120x240_as";
		google_ad_type = "text";
		//2007-05-08: picmovie
		google_ad_channel = "0825594361";
		google_color_border = ["<?= $forground->bg['+4'] ?>"];
		google_color_bg = ["<?= $forground->bg['+4'] ?>"];
		google_color_link = ["<?= $forground->bg['-9'] ?>"];
		google_color_url = ["<?= $forground->bg['-9'] ?>"];
		google_color_text = ["<?= $forground->bg['-9'] ?>"];
		//-->
		</script>
		<script type="text/javascript"
		  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
		</script>
		<fieldset>
		<? if ($lang_idx == $EN) {?>This is a look into the north-western horizon of Jerusalem. You can see old water tower of Kiryat-Menachem neighbourhoud and the green stuff is a forest near my house.<?} ?>
	   <? if ($lang_idx == $HEB) {?> כאן רואים מבט אל עבר האופק הצפון מערבי של ירושלים.<br/>אפשר לראות את קרית יובל, קרית מנחם, מבשרת , מושב אורה ואפילו את הר אדר, אם מתאמצים.<br/>הירוק שבחזית שייך ליער גילה.<?} ?>
		</fieldset>
	</td>
</tr>
</table>
<br/>


</center></font>
<? 
$datafile="picmovie.dat";
include ("counter.php");
?>
<br/><br/>
</body></html>
