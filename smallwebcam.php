<style>
	#user_info{
		display:none
	}
</style>
<?
$basename = "webCamera";
$imagefile = $_GET['section'];

$latestPics = array();
$path_to_files = $_SERVER['DOCUMENT_ROOT']."/images/alldaypics";
//echo $path_to_files;
$latestPics = getfilesFromdir($path_to_files);

if (!file_exists($imagefile))
	$imagefile = BASE_URL."images/".$imagefile;
// FTP don't work good.
//if (stristr($imagefile, "webCamera.jpg"))
//{
//	$imagefile = $latestPics[0][1];
//}

$updated_pic = getUpdatedPic();
if (stristr($imagefile, "Z"))
	$updated_pic = "images/webCameraZ.jpg";
?>

		
		<div class="inv_plain_3_zebra webcam_desc" style="width:95%">
		
		<? if ($lang_idx == $EN) {?>This is a look into the north horizon of Jerusalem. You can see Malcha at the left side and all the way to the old city at the right.<?} ?>
	   <? if ($lang_idx == $HEB) {?>זהו מבט מדרום העיר צפונה. ניתן לראות ממלחה במערב (צד שמאל של התמונה) ועד העיר העתיקה במזרח (צד ימין של התמונה)<?} ?>
	   
		</div>
	 <img name="animation" id="latestpics" width="320px" height="240px" alt="<? echo getPageTitle();?>" /> 
	

<div>
<?
		$archwebcam = 0;
		foreach ($latestPics as $lpic)
		{
                        
			$image_href = BASE_URL.substr($lpic[1], strpos($lpic[1],"/images"));			
			if (((($archwebcam < 100)&&((getLocalHour($lpic[0])>4)&&(getLocalHour($lpic[0])<20))))) 
			{$archwebcam = $archwebcam + 1;
			?>
			
			<div style="float:<?echo get_s_align();?>;padding:5px">
				<a href="<?=$image_href?>" title="<?echo getLocalTime($lpic[0]);?>" class="colorbox">
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
<script type="text/javascript" src="/sprintf2.js"></script>
<script language="JavaScript" type="text/javascript"> 
////////////// pic animation
var file_template = "phpThumb.php?src=/images/webCamera%d.jpg&w=360";
var numOfPics = 20;
var normal_delay = 60;
var dwell_multipler = 20;
var lowindex = 0;
var pic_id = 'latestpics';
//////////////
</script>
<script type="text/javascript" src="/picanimation.js"></script>
<script language="JavaScript" type="text/javascript"> 
	launch();
</script>
<!-- /////////////////////  -->
	
