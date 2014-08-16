<script type='Text/JavaScript' src='jquery-1.3.2.min.js'></script>
<script type='Text/JavaScript' src='ui.core.js'></script>
<script type='Text/JavaScript' src='ui.datepicker.js'></script>
<link href="jquery-ui-1.7.1.custom.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
	$(function() {
		$("#datepicker").datepicker({ dateFormat: 'dd/mm/yy' });
	});
</script>
<?php
function getDisplayDate()
{
	global $day, $month, $year;
	if (isset($_POST['datetosend']))
		return $_POST['datetosend']; 
	else
		return $day."-".$month."-".$year;
}

?>
<h2><? echo($DAILY_LOOP[$lang_idx]);?></h2>
<? if (isHeb()) { ?>
	<h4>החל מינואר 2008</h4>
<? } else { ?>
	<h4>starting from January 2008</h4>
<? } ?>



<div style="float:<?echo get_s_align();?>;width:250px" class="inv_plain_3">
	    
			<form method="POST" name="date" action="" <? if (isHeb()) echo "dir=\"rtl\""; ?>>
				<? echo($BY_DATE[$lang_idx]);?>: <input value='<?=$_POST['datepicker']?>' type="text" id="datepicker" name="datepicker" style="width:90px;" /><br/><br/>
				<input type="submit" name="submit" value="<? echo $SHOW[$lang_idx];?>" style="width:150px;">
			</form>
			<div style="margin:1em;width:180px" class="inv_plain_2">
				<a href="<? echo get_query_edited_url(get_url(), 'section', 'webCamera.jpg');?>" alt="click to get normal pic">
					<? if (isHeb()) { ?>
				לחץ לקבלת תמונה מעודכנת
					<? } else { ?>
					click to get updated picture
						<? } ?>
				</a>
			</div>
			<div style="float:<?echo get_s_align();?>;padding:0.3em;margin:1em" class="inv_plain_3">
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
			</div>
</div>

<? if (isset($_POST['datepicker'])) { ?>
<div class="base"><? echo $_POST['datepicker']; ?></div>
<div style="text-align:center"><object width="640" height="480" id="undefined" name="undefined" data="http://icons.wunderground.com/swf/flowplayer.commercial-3.2.8.swf" type="application/x-shockwave-flash"><param name="movie" value="http://icons.wunderground.com/swf/flowplayer.commercial-3.2.8.swf" /><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="flashvars" value='config={"key":"#@8d339434b223613a374","clip":{"autoPlay":false,"autoBuffering":true},"playlist":[{"url":"http://icons.wunderground.com/webcamarchive/b/o/boazn1/2/2012/10/1349269457-20121003150417IST.jpg","autoPlay":false,"autoBuffering":true},{"url":"http://icons.wunderground.com/webcamarchive/b/o/boazn1/2/<? echo substr($_POST['datepicker'],6 ,4 );?>/<? echo substr($_POST['datepicker'],3 ,2 );?>/<? echo substr($_POST['datepicker'],6 ,4 ).substr($_POST['datepicker'],3 ,2 ).sprintf('%d', substr($_POST['datepicker'],0 ,2 )); ?>.mp4","autoPlay":true,"autoBuffering":true}],"plugins":{"controls":{"all":true,"mute":true,"play":true}}}' /></object><p><a href="http://www.wunderground.com/webcams/boazn1/2/video.html">boazn1's Video Archive</a> &mdash; <a href="http://www.wunderground.com/webcams/">Weather Underground Webcams</a></p></div>

 <div style="text-align:center"><object width="640" height="480" id="undefined" name="undefined" data="http://icons.wunderground.com/swf/flowplayer.commercial-3.2.8.swf" type="application/x-shockwave-flash"><param name="movie" value="http://icons.wunderground.com/swf/flowplayer.commercial-3.2.8.swf" /><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="flashvars" value='config={"key":"#@8d339434b223613a374","clip":{"autoPlay":false,"autoBuffering":true},"playlist":[{"url":"http://icons.wunderground.com/webcamarchive/b/o/boazn1/1/2012/10/1349701373-20121008150253IST.jpg","autoPlay":false,"autoBuffering":true},{"url":"http://icons.wunderground.com/webcamarchive/b/o/boazn1/1/<? echo substr($_POST['datepicker'],6 ,4 );?>/<? echo substr($_POST['datepicker'],3 ,2 );?>/<? echo substr($_POST['datepicker'],6 ,4 ).substr($_POST['datepicker'],3 ,2 ).sprintf('%d', substr($_POST['datepicker'],0 ,2 )); ?>.mp4","autoPlay":true,"autoBuffering":true}],"plugins":{"controls":{"all":true,"mute":true,"play":true}}}' /></object><p><a href="http://www.wunderground.com/webcams/boazn1/1/video.html">boazn1's Video Archive</a> &mdash; <a href="http://www.wunderground.com/webcams/">Weather Underground Webcams</a></p></div> 

 

<? } ?>
<!-- <script type="text/javascript" src="flashSeekbar.js"></script> -->



