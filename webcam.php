<?
// spam spam spam
if ($_GET['random'] != "")
	die("spam spam");
function prevPic ($input) {
	if ($input == "webCamera.jpg")
		return "cam048.jpg";
	if ($input == "cam001.jpg")
		return "webCamera.jpg";
	return preg_replace ( "/^(.+?)(_?)(\d*)(\.[^.]+)?$/e", "'\$1'.(\$3-1).'\$4'", $input );
}
function nextPic ($input) {
	if ($input == "cam048.jpg")
		return "webCamera.jpg";
	if ($input == "webCamera.jpg")
		return "cam001.jpg";
	return preg_replace ( "/^(.+?)(_?)(\d*)(\.[^.]+)?$/e", "'\$1'.(\$3+1).'\$4'", $input );
}

?>

<div id="webcam_container" class="inv_plain_3">

<?
$basename = "webCamera";
$imagefile = $_GET['section'];

$latestPics = array();
$path_to_files = "images/alldaypics";
//echo $path_to_files;
$latestPics = getfilesFromdir($path_to_files);

if (!file_exists($imagefile))
	$imagefile = "images/".$imagefile;
// FTP don't work good.
//if (stristr($imagefile, "webCamera.jpg"))
//{
//	$imagefile = $latestPics[0][1];
//}

$updated_pic = getUpdatedPic();
if (stristr($imagefile, "Z"))
	$updated_pic = "images/webCameraZ.jpg";
?>
<!--<ul class="nav" style="width:50%">
					<li>
						<a class="hlink" href="<? echo get_query_edited_url(get_url(), 'section', 'stream.php');?>" title="<? echo($LIVE_STREAM[$lang_idx]);?>">
						<? echo($LIVE_STREAM[$lang_idx]);?> 
						</a>
					</li>
					<li>
						<a title="movie of the past day" href="<? echo get_query_edited_url(get_url(), 'section', 'picmovie.php');?>" class="hlink">
							<? echo($DAILY_LOOP[$lang_idx]);?>
						</a>
					</li>
					<li>
						<a title="<? echo($DAILY_LOOP[$lang_idx]);?> <? echo($BY_DATE[$lang_idx]);?>" href="<? echo get_query_edited_url(get_url(), 'section', 'pic_movie_archive.php');?>" class="hlink">
							<? echo($DAILY_LOOP_ARCHIVE[$lang_idx]);?>
						</a>
					</li>
					
</ul>-->
<div style="padding:1em;clear:both;float:<?echo get_s_align();?>" dir="rtl">
	<div><?=$CAMERA_LOOP[$lang_idx];?></div> 
	 <img name="animation" id="latestpics" width="700px" height="394px" alt="<? echo getPageTitle();?>" />
	 <a href="images/latestwebcam.gif" download><img src="images/download.png" width="60" alt="download" /></a> 
	<br />
	<!--
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
	-->
</div>
<div class="webcam_image" style="clear:both">
	<div><?=$CAMERA[$lang_idx];?> 1 <? echo getLocalTime(filemtime("images/webCamera0.jpg"));?></div>
	<a href="images/webCamera0.jpg" class="colorbox" title="<?=$LIVE_PICTURE[$lang_idx];?>">
	<span></span>
		<img name="animation" id="baseGraph" src="images/webCamera0.jpg" width="475px" height="300px" title="<?=$LIVE_PICTURE[$lang_idx];?>  - <?=$CAMERA[$lang_idx];?> 1" />
	</a>
	
	<div class="inv_plain_3_zebra webcam_desc">
		
		<? if ($lang_idx == $EN) {?>This is a look into the north horizon of Jerusalem. You can see Malcha at the left side and all the way to the old city at the right.<?} ?>
	   <? if ($lang_idx == $HEB) {?>זהו מבט מדרום העיר צפונה. ניתן לראות ממלחה במערב (צד שמאל של התמונה) ועד העיר העתיקה במזרח (צד ימין של התמונה)<?} ?>
	   
	</div>
</div>
<? if (file_exists("images/webCameraB.jpg")) { ?>
<div class="webcam_image">
	<div><?=$CAMERA[$lang_idx];?> 2 <? echo getLocalTime(filemtime("images/webCameraB.jpg"));?></div>
	<a href="images/webCameraB.jpg" class='colorbox' title="<?=$CAMERA[$lang_idx];?> 2;<? echo getLocalTime(filemtime("images/webCameraB.jpg"));?>">
	<span></span>
        <img name="animation" id="baseGraph" src="phpThumb.php?src=images/webCameraB.jpg&amp;w=475&amp;fltr[]=gam|0.8" width="475px" height="300px" title="<?=$LIVE_PICTURE[$lang_idx];?>  - <?=$CAMERA[$lang_idx];?> 2" />
	</a>
	
	<div class="inv_plain_3_zebra webcam_desc">
		
		<? if ($lang_idx == $EN) {?>This is high res zoomed view of small part from the pic of camera 1. It contains whole of the city from west to east, zooming at various places<?} ?>
	   <? if ($lang_idx == $HEB) {?>זו תמונה ברזולוציה גבוהה של חלק קטן מתמונת מצלמה 1. המצלמה עושה סיבוב מערב-מזרח ומצלמת בתקריב כל מיני אתרים בעיר.<?} ?>
	   
	</div>
</div>
<? }?>
<!-- <a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=<?echo nextPic($_GET['section']);?>&amp;lang=<? echo($lang_idx);?>" alt="click to get next picture">
<img src="images/forward.png" alt="click to get next picture לתמונה הבאה"/>
</a> -->



<!-- <div style="display:block;width:270px" >
<div style="float:left;padding:2px;border:1px solid"  <?if ($_GET['section']==="{$basename}.jpg") echo "class=\"trans75\""; else echo "class=\"trans25\" onmouseover=\"this.className='trans75'\" onmouseout=\"this.className='trans25'\"";?>>
<a href="<?=$_SERVER['SCRIPT_NAME'];?>?section=<? echo $basename; ?>.jpg&amp;lang=<? echo($lang_idx);?>"><img src="images/<? echo $basename; ?>.jpg" width="70px" /><br/><? //echo getLocalTime(filemtime("images/{$basename}.jpg"));?></a>
</div>
</div> -->
	
	
	<!-- <div style="clear:both">
		<? if (isHeb()) { ?>
			רשימת תמונות אחרונות
		<? } else { ?>
			Latest pictures list
		<? } ?>
	</div> -->

 
 
<div style="padding:1em" class="float">
	<div><?=$LOCATION[$lang_idx];?></div>
	<a href="images/webcam02ws.jpg" class="colorbox" title="<? if (isHeb()) { ?>
			נקודה אדומה - מצלמה ; חץ כחול - תחנה
			<? } else { ?>
				Red point - camera. Blue arrow - station. 
			<? } ?>">
		<img name="animation" id="baseGraph" src="phpThumb.php?src=images/webcam02ws.jpg&amp;w=200" width="200px" title="<?=$LOCATION[$lang_idx];?>" />
	</a>
	<div class="base image_enlarge">
		<a href="images/webcam02ws.jpg" title="02ws" title='<? if (isHeb()) { ?>
				נקודה אדומה - מצלמה ; חץ כחול - תחנה
			<? } else { ?>
				Red point - camera. Blue arrow - station. 
			<? } ?>' class="colorbox">
		<? if (isHeb()) { ?>
				הגדלה
			<? } else { ?>
				click to enlarge 
			<? } ?>
		</a>
	</div>
</div>
<div style="margin:1em;float:<?echo get_s_align();?>">
		<div >
		<script type="text/javascript"><!--
		google_ad_client = "pub-2706630587106567";
		/* 336x280, created 9/12/10 */
		google_ad_slot = "5143674601";
		google_ad_width = 336;
		google_ad_height = 280;
		google_color_border = ["<?= $forground->bg['+4'] ?>"];
		google_color_bg = ["<?= $forground->bg['+4'] ?>"];
		google_color_link = ["<?= $forground->bg['-9'] ?>"];
		google_color_url = ["<?= $forground->bg['-9'] ?>"];
		google_color_text = ["<?= $forground->bg['-9'] ?>"];

		//--></script>
		<script type="text/javascript"
		  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
		</script>
		</div>
</div>
<div style="clear:both"></div>
<div style="padding:1em;float:<?echo get_s_align();?>" dir="rtl">
<h2><? echo $LAST_DAY[$lang_idx];?></h2>
<a name="windy-webcam-timelapse-player" data-id="1389696018" data-play="day" href="https://windy.com/webcams/1389696018" target="_blank"><? echo $LAST_DAY[$lang_idx];?></a><script async type="text/javascript" src="https://webcams.windy.com/webcams/public/embed/script/player.js"></script>
</div>
<div>
<?
		$archwebcam = 0;
		foreach ($latestPics as $lpic)
		{
                        
						
			if (((($archwebcam < 100)&&((getLocalHour($lpic[0])>4)&&(getLocalHour($lpic[0])<20))))) 
			{$archwebcam = $archwebcam + 1;
			?>
			
			<div style="float:<?echo get_s_align();?>;padding:3px">
				<label><?echo getLocalHourMin($lpic[0]);?></label>
				<a href="<?=$lpic[1]?>" title="<?echo getLocalTime($lpic[0]);?>" class="colorbox">
					<img src="phpThumb.php?src=<? echo $lpic[1]; ?>&amp;w=70" width="70px" title="<?echo getLocalTime($lpic[0]);?>" />
					
				</a>
			</div>
			<? }
		}?>
		</div>
		<div style="clear:both">&nbsp;</div>
		<div style="width:100%;height:160px">
		
		
	</div>
	

<!-- ///////////// pic animation -->
<script type="text/javascript" src="sprintf2.js"></script>
<script language="JavaScript" type="text/javascript"> 
////////////// pic animation
var file_template = "phpThumb.php?src=images/webCamera%d.jpg&w=700&fltr%5B%5D=gam%7C0.55";
var numOfPics = 20;
var normal_delay = 60;
var dwell_multipler = 20;
var lowindex = 0;
var pic_id = 'latestpics';
//////////////
</script>
<script type="text/javascript" src="picanimation.js"></script>
<script language="JavaScript" type="text/javascript"> 
	launch();
</script>

<!-- /////////////////////  -->
	
</div>
