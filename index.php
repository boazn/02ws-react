<?
header("HTTP/1.0 301 Moved Permanently",1);       // Force the browser to load the WML file instead
header("Location: "."station.php");
exit;

?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<? if (isHeb()) echo "he"; else echo "en"; ?>">
<head>
<link href="generalstyle.php" rel="stylesheet" type="text/css" >
<script language="JavaScript" src="jsFunctions.js" type="text/javascript"></script>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta http-equiv="Refresh" content="600" >
<META http-equiv="Refresh" content="60; URL=station.php">
<meta name="description" content="Jerusalem weather station in Israel. Here you have live picture, 24 hours detailed forecast, 4 days forecast, webcam, live stream, weather graphs, current significant conditions, detailed archive and much more. This is online weather station which updates frequently. כל הפרטים על מזג-האוויר כאן ובעולם . האתר כולל ארכיון מקיף וגרפים. הדגש הוא על פירוט ועומק."  />
<meta name="keywords" content="extreme, climate, average, rain, storm, yearly, monthly, stat, ירושלמי , אקלים, גשם , טיולים, מזג , אויר , אוויר, לחות , היום" />
<title><? echo getPageTitle();?></title>
</head>
<body>
<center>
	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0" width="760" height="50" id="Shot2" align="middle">
	<param name="allowScriptAccess" value="sameDomain" />
	<param name="movie" value="images/Shot2.swf?title=Jerusalem&date=<?=$date?>&extra=<?=ELEVATION?>&extPic=images/headerGCnew.jpg" />
	<param name="loop" value="false" />
	<param name="quality" value="high" />
	<param name="wmode" value="transparent" />
	<param name="bgcolor" value="#ffffff" />
	<embed src="images/Shot2.swf?title=Jerusalem&date=<?=$date?>&extra=<?=ELEVATION?>&extPic=images/headerGCnew.jpg" loop="false" quality="high" wmode="transparent" bgcolor="#ffffff" width="760" height="50" name="Shot2" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
	</object>
	<br/>
    <h2 style="width:644px;border-top:black 1px solid;" class="grad">
	<a href="station.php?lang=<?=$lang_idx?>" dir="rtl" title="<? if (isHeb()) echo "לחץ לכניסה"; else echo "click to enter"; ?>" class="hlink">
	<? echo $LOGO[$lang_idx];?> - <? echo $SLOGAN[$lang_idx];?>
	</a>
	</h2>
	<div id="tempdiv" align="center" style="position:absolute;padding:0.4em;width:210px;height:30px;z-index:1000">
	<span style="filter:alpha(opacity=80);opacity:.80;" class="big" <? if (isHeb()) echo "dir=\"rtl\""?>>
	<? echo $TEMP[$lang_idx];?>&nbsp;	<? echo $current->get_temp(),"&#176;C&nbsp;";?>
	</span>
	</div>
	<?
			$imagefile = "images/webCamera.jpg";
	?>
	<div  id="webcamimage">
	<a href="station.php?lang=<?=$lang_idx?>" title="<? if (isHeb()) echo "לחץ לכניסה"; else echo "click to enter"; ?>" class="info" style="text-decoration: none;">
	<img src="phpThumb.php?src=<? echo $imagefile; ?>&amp;w=253&amp;h=160&amp;sx=0&amp;sy=0&amp;sw=341&amp;sh=227&amp;f=jpg" height="160" id="webcam1" class="transOFF" onmouseover="this.className='transON'" onmouseout="this.className='transOFF'"/>
	<img src="phpThumb.php?src=<? echo $imagefile; ?>&amp;w=253&amp;h=160&amp;sx=341&amp;sy=0&amp;sw=341&amp;sh=227&amp;f=jpg" height="160" id="webcam2" class="transOFF" onmouseover="this.className='transON'" onmouseout="this.className='transOFF'"/>
	<img src="phpThumb.php?src=<? echo $imagefile; ?>&amp;w=253&amp;h=160&amp;sx=682&amp;sy=0&amp;sw=341&amp;sh=227&amp;f=jpg" height="160" id="webcam3" class="transOFF" onmouseover="this.className='transON'" onmouseout="this.className='transOFF'" />
	<br/>
	<img src="phpThumb.php?src=<? echo $imagefile; ?>&amp;w=253&amp;h=160&amp;sx=0&amp;sy=227&amp;sw=341&amp;sh=227&amp;f=jpg" height="160" id="webcam4" class="transOFF" onmouseover="this.className='transON'" onmouseout="this.className='transOFF'" />
	<img src="phpThumb.php?src=<? echo $imagefile; ?>&amp;w=253&amp;h=160&amp;sx=341&amp;sy=227&amp;sw=341&amp;sh=227&amp;f=jpg" height="160" id="webcam5" class="transOFF" onmouseover="this.className='transON'" onmouseout="this.className='transOFF'"/>
	<img src="phpThumb.php?src=<? echo $imagefile; ?>&amp;w=253&amp;h=160&amp;sx=682&amp;sy=227&amp;sw=341&amp;sh=227&amp;f=jpg" height="160" id="webcam6" class="transOFF" onmouseover="this.className='transON'" onmouseout="this.className='transOFF'" />
	<br/>
	<img src="phpThumb.php?src=<? echo $imagefile; ?>&amp;w=253&amp;h=160&amp;sx=0&amp;sy=454&amp;sw=341&amp;sh=227&amp;f=jpg" height="160" id="webcam7" class="transOFF" onmouseover="this.className='transON'" onmouseout="this.className='transOFF'" />
	<img src="phpThumb.php?src=<? echo $imagefile; ?>&amp;w=253&amp;h=160&amp;sx=341&amp;sy=454&amp;sw=341&amp;sh=227&amp;f=jpg" height="160" id="webcam8" class="transOFF" onmouseover="this.className='transON'" onmouseout="this.className='transOFF'" />
	<img src="phpThumb.php?src=<? echo $imagefile; ?>&amp;w=253&amp;h=160&amp;sx=682&amp;sy=454&amp;sw=341&amp;sh=227&amp;f=jpg" height="160" id="webcam9" class="transOFF" onmouseover="this.className='transON'" onmouseout="this.className='transOFF'" />
	<span class="info">
		<? if (isHeb()) echo "לחץ לכניסה"; else echo "click to enter"; ?>
	</span>
	</a>
	</div><br/>
	<? if ($lang_idx == 1) {?>
			<a href="#" title="to english" onclick="changeLang('0')"><img alt="switch to english" src="images/eng.jpg" height="14" /></a>
			<?} 
			else {?>
			<a href="#" onclick="changeLang('1')">עברית</a>
	<?} ?>
</center>
<script language="JavaScript" type="text/javascript">	
show('tempdiv', 'webcamimage', 'webcamimage',+300, -70);

function changeLang (lang)
{
	var loc = "<? echo get_url();?>";
	loc = loc.replace(/lang=\d/g, "lang=" + lang);
	if (loc.indexOf('?') < 0)
	{
		loc = loc + "?";
	}
	if (loc.indexOf('lang') < 0)
	{
		loc = loc + "&lang=" + lang;
	}
	top.location.href=loc;
}
</script>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-647172-1";
urchinTracker();
</script>
</body>
</html>
<? //include "end_caching.php"; ?>
