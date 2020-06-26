<div id="picsContainer">
<?
include_once("include.php"); 
include_once("lang.php");
function sendMessageToUser($reg_id)
{
    if ($reg_id == "")
        return false;
    $registrationIDs = array();
    array_push($registrationIDs, $reg_id);
    if (isAndroid($reg_id))
        callGCMSender(FCM_API_KEY, $registrationIDs, "Your picture is live now התמונה אושרה ועלתה לאוויר", "", "", "");
    else
        sendAPNToRegIDs($registrationIDs, "Your picture is live now התמונה אושרה ועלתה לאוויר", "", "", "");
}
function isAndroid($reg_id){
    return (strlen($reg_id) == 152);
}
function rotateAndSave($rotateFilename, $fileType){
    // File and rotation

$degrees = 270;

if($fileType == 'jpg' || $fileType == 'jpeg'){
   header('Content-type: image/jpeg');
   $source = imagecreatefromjpeg($rotateFilename);
   // Rotate
   $rotate = imagerotate($source, $degrees, 0);
   imagejpeg($rotate,$rotateFilename);
   echo $rotateFilename." rotated";
}

// Free the memory
imagedestroy($source);
imagedestroy($rotate);
}
function updateApproved($approved, $idx , $reg_id){
    
    $result = db_init("UPDATE UserPicture SET approved='{$approved}', approvedAt=now() WHERE idx={$idx}","");
    @mysqli_free_result($result);
    sendMessageToUser($reg_id);
}
$empty = $post = array();
foreach ($_POST as $varname => $varvalue) {
   if (empty($varvalue)) {
       $empty[$varname] = $varvalue;
   } else {
       $post[$varname] = $varvalue;
   }
}
if (empty($empty)) {
   //print "None of the POSTed values are empty, posted:\n";
   //var_dump($post);
} else {
   $result .= "We have " . count($empty) . " empty values\n";
  // $result .= "Posted:\n"; var_dump($post);
  // $result .= "Empty:\n";  var_dump($empty);
   echo $result;
}
if ((trim($_POST['command']) == "U"))
{
    updateApproved($_POST['approved'], $_POST['idx'], $_POST['reg_id']);
}
if ((trim($_POST['command']) == "R"))
{
    rotateAndSave($_POST['picname'], 'jpg');
}


$latestPics = array();
$path_to_files = "images/userpic";
//echo $path_to_files;
$latestPics = getfilesFromdir($path_to_files);

		$archwebcam = 0;
		foreach ($latestPics as $lpic)
		{
                        $archwebcam = $archwebcam + 1;
                        if ($archwebcam < 10){
			?>
			
			<div style="float:<?echo get_s_align();?>;padding:3px">
				<a href="<?=$lpic[1]?>" title="<?echo getLocalTime($lpic[0]);?>" class="colorbox">
					<? echo $lpic[1]; ?>
					
				</a>
			</div>
                        <? }
		}

$result = db_init("SELECT * FROM UserPicture order by uploadedAt DESC LIMIT 30","");
$pic_number = 0;
while ($line = $result["result"]->fetch_array(MYSQLI_ASSOC)) {
        $picaname = "images/userpic/".$line["picname"];
        if ($pic_number % 1 == 0)
            echo "<div class=\"clear\" ></div>";
        ?>
        
       <div style="float:<?echo get_s_align();?>;padding-right:5px;width:200px;margin-top:20px;direction:rtl" id="<?=$line["idx"]?>" <? if ($line["approved"] == 1) echo "class=\"inv_plain_3_zebra\"";?>>
           
           <input type="checkbox" id="approved<?=$line["idx"]?>" name="approved<?=$line["idx"]?>"  value="<?=$line["approved"]?>" <? if ($line["approved"] == 1) echo "checked=\"checked\""; ?> />
           <input type="hidden" id="picname<?=$line["idx"]?>" name="<?=$picaname?>"  value="<?=$picaname?>" <? if ($line["approved"] == 1) echo "checked=\"checked\""; ?> />
           <input type="hidden" id="reg_id<?=$line["idx"]?>" value="<?=$line["reg_id"]?>" />&nbsp;&nbsp;&nbsp;&nbsp;
           <img src="images/check.png" width="16px" onclick="getOnePicService(this.parentNode.id, 'U')" style="cursor:pointer" />&nbsp;&nbsp;&nbsp;
           <img src="images/rotate.png" width="16px" onclick="getOnePicService(this.parentNode.id, 'R')" style="cursor:pointer" /><br/>
           <?=$line["name"]." <br/>".$line["comment"]."<br/>".$line["x"]." <br/>".$line["y"]?>
           
       
                                
                <a href="<?=$picaname?>" title="" class="colorbox">
                        
                        <img src="phpThumb.php?src=<? echo $picaname ?>&amp;w=150" width="150px" title="<?=$picaname?>" />

                </a>
        </div>
        
        
        <? 
        $pic_number++;
}?>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
<script language="javascript">
    
function getOnePicService(picToSave, command)
{
    var idx = picToSave;
    var approved = $('#approved'+picToSave).is(":checked") ? 1 : 0;
    var reg_id = $('#reg_id'+picToSave).val();
    var picname = $('#picname'+picToSave).val();
    fillPage('<img src="images/loading.gif" alt="loading" />');
    $.ajax({
        type: "POST",
        mimeType:"text/html",
        url: "userPicsManager.php",
        data: {idx:idx,command:command, approved:approved, reg_id:reg_id, picname:picname},
   }).done(function(str){
       fillPage(str);
   });
    
}

function fillPage(str)
{
	var forecastDetails = document.getElementById('section');
	
	 forecastDetails.innerHTML = str;
	 //forecastDetails.appendChild(newDiv); 
	
}
</script>
