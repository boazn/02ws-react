<?
//echo "typeofsat=".$_REQUEST['typeofsat'];
if ($_REQUEST['typeofsat'] == '')
	$_REQUEST['typeofsat'] = '2';
?>
<h1><?=$SATELLITE[$lang_idx];?></h1>
<div style="padding:0.1em;float:<?echo get_s_align();?>">
<div style="padding:0.5em;clear:both;float:<?echo get_s_align();?>" dir="rtl">
	 <img name="animation" id="sat_loop" width="800" height="600" alt="<? echo getPageTitle();?>" /> 
	<br />
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href="javascript: func()" onclick="incrementimage(++current_image)">
	 <img src="images/forward.png" alt="forward קדימה"/>
	</a>
	&nbsp;&nbsp;
	<a  href="javascript: func()" onclick="stop()">
		<img src="images/stop.png" alt="stop עצור"/>
	</a>
	&nbsp;&nbsp;
	<a href="javascript: func()" onclick="decrementimage(--current_image)">
		 <img src="images/backward.png" alt="backward אחורה"/> 
	</a>
	<div style="clear:both;padding:1em" >
				<form method="POST" action="<? echo get_query_edited_url($url_cur, 'section', 'animation.php');?>">
					<select size="1" id="typeofsat" name="typeofsat" class="inv_plain_2" <? if (isHeb()) echo "dir=\"rtl\""; ?> onchange="changeSat(this.options[this.selectedIndex].value)"> 
					<option	<? if ($_REQUEST['typeofsat'] == "1") echo " selected ";?> value="1">vis</option>
					<option	<? if ($_REQUEST['typeofsat'] == "2") echo " selected ";?> value="2">ir</option>
					</select>
				</form>
	</div>
</div>
<div style="float:<?echo get_s_align();?>">
<script type="text/javascript"><!--
google_ad_client = "pub-2706630587106567";
/* 160x600, created 9/18/10 */
google_ad_slot = "1533809609";
google_ad_width = 160;
google_ad_height = 600;
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
<!-- ///////////// pic animation -->
<script type="text/javascript" src="sprintf2.js"></script>
<script language="JavaScript" type="text/javascript"> 
////////////// pic animation
var file_template = "http://www.sat24.com/image.ashx?country=afis&type=slide&time=&index=%d&sat=<? if ($_REQUEST['typeofsat'] == "1") echo "vis"; else echo "ir";?>";
var numOfPics = 13;
var normal_delay = 300;
var dwell_multipler = 20;
var lowindex = 1;
var pic_id = 'sat_loop';
//////////////
</script>
<script type="text/javascript" src="picanimation.js"></script>
<script language="JavaScript" type="text/javascript"> 
	launch();
</script>
<script language="JavaScript" type="text/javascript">
function changeSat (inprofile)
{
	//alert (inprofile);
	toggle('waiting');
	var loc = "<? echo get_url();?>";
	
	if (loc.indexOf('typeofsat') < 0)
	{
		loc = loc + "&typeofsat=2";	
	}
	
	loc = loc.replace(/typeofsat=\d/g, "typeofsat=" + inprofile);
	//alert(loc);
	top.location.href=loc;
	
	//document.profileChanger.action=loc;
	//document.profileChanger.submit();
	
}
</script>