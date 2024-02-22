<?
include_once("include.php");
include_once("start.php"); 
include_once("lang.php");
define ("PIC_PREFIX_PATH", "images/picOfTheDay/");

function insertNewMessage ($name, $icon, $body, $category, $p_alert)
{
                
    $now = date('Y-m-d G:i:s', strtotime(SERVER_CLOCK_DIFF, time()));
    //$now = getLocalTime(time());
    $body = nl2br($body);
    $body = str_replace("'", "&apos;", $body);
    $p_email = EMAIL_ADDRESS;
    $name = "<span class=\"high\">".$name."</span>";
    //$msg_total_count = $_SESSION['MsgCount'] + $_SESSION['MsgStart'];
    //$name .= "<div class=\"msgcount\">#".$msg_total_count."</div>";
    $query = "call InsertNewMsg ('$name','$icon', '$body', '$now', $category, '$p_email', '$p_alert')";
    logger($query, 0, "picOfTheDayManager", "picOfTheDayManager", "insertNewMessage");
    $result = db_init($query, "");
    // Free resultset 
    @mysqli_free_result($result["result"]);
    global $link;
    mysqli_close($link);
		
	
}
class DB_Functions {
 
    private $db;
 
      
 
    /**
     * Storing new user
     * returns user details
     */
    public function storePic($name, $comment0, $comment1, $x, $y, $base64) {
        // insert user into database
        global $link;
		
			$file_path = PIC_PREFIX_PATH.$name;
     
            if ($base64 == 1){
                $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $_POST["pic"]));
                file_put_contents($file_path, $data);
            }
            else
            {
            $info = pathinfo($_FILES['imagefile']['name']);
            $ext = $info['extension']; // get the extension of the file
            $name = $info['basename'];
            $saveto = $file_path;
            move_uploaded_file($_FILES['imagefile']['tmp_name'], $saveto);
            header('Content-type: image/jpeg');
            $image = imagecreatefromjpeg($saveto);
            // Delete original file
            //@unlink($_FILES['image']['tmp_name']);
            // Target dimensions
            $max_width = 2500;
            $max_height = 1440;


            // Calculate new dimensions
            $old_width      = imagesx($image);
            $old_height     = imagesy($image);
            $scale          = min($max_width/$old_width, $max_height/$old_height);
            $new_width      = ceil($scale*$old_width);
            $new_height     = ceil($scale*$old_height);


            // Create new empty image
            $new = imagecreatetruecolor($new_width, $new_height);

            // Resample old into new
            imagecopyresampled($new, $image, 
                    0, 0, 0, 0, 
                    $new_width, $new_height, $old_width, $old_height);
            
            imagejpeg($new, $saveto, 95);
            
            // Destroy resources
            imagedestroy($image);
            imagedestroy($new);
            $typeok = TRUE;
            $result = "https://".$_SERVER["HTTP_HOST"]."/".$saveto;         
           }
                
            $comment1 = str_replace("'", "`", $comment1);	
            $comment0 = str_replace("'", "`", $comment0);	
			//$result = db_init("call SaveUserPic ('$name', '$comment', '$user', '$picname', '$x', '$y')");
            $rs = db_init("INSERT INTO `PicOfTheDay` (name, comment0, comment1, uploadedAt, x, y, picname) VALUES('$name', '$comment0', '$comment1',SYSDATE(), '$x', '$y', '$name');", "");
			// check for successful store
			// get user details
            $id = $link->insert_id; // last inserted id

           
            return $result;
       
   
    }
 
  
 
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



if ( isset( $_POST["comment1"]) ) 
{
    //print_r($_POST);
   //print_r($_FILES);
    $db = new DB_Functions();
    
    $res = $db->storePic($_FILES['imagefile']['name'], $_POST['comment0'], $_POST['comment1'], 0, 0, 0);
    $mem->set("picOfTheDayName", $_FILES['imagefile']['name']);
    $mem->set("picOfTheDaycomment0", $_POST['comment0']);
    $mem->set("picOfTheDaycomment1", $_POST['comment1']);
    logger($res, 0, "picOfTheDayManager", "picOfTheDayManager", "storePic");
    $file_path = "https://".$_SERVER["HTTP_HOST"]."/".PIC_PREFIX_PATH.$_FILES['imagefile']['name'];
    $img = "<a href=\"".$file_path."\" title=\"pic of the day\" target=\"_blank\"><img src=\"".$file_path."\" alt=\"pic of the day\" /></a>";

    $res .= "<br /><br />".post_to_bufferApp($_POST['comment1'], $file_path); 
    logger($res, 0, "picOfTheDayManager", "picOfTheDayManager", "Pic");		
    insertNewMessage("מנהל ירושמיים", "admin_avatar", "<div class=\"float chatfirstbody\">".$img."<br/>".$_POST['comment1']."</div>", 3, 0);
    echo ("<br/>insertNewMessage done.");
    echo ("".$res."");
}else { //print_r($_POST);
?>
<html>
<head>
<link rel="stylesheet" href="css/main.php?lang=1&type=" type="text/css">
<meta name="viewport" content="width=320" />
<style>
    .result{
        display:block;
        width:80%;
        font-size:1.2em;
        padding:1em
    }
</style>
</head>
<body>
<?
    /*$empty = $post = array();
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
}*/
/****************   start page load ***************** */

/*$latestPics = array();
$path_to_files = PIC_PREFIX_PATH;
//echo $path_to_files;
$latestPics = getfilesFromdir($path_to_files);

		$archwebcam = 0;
		foreach ($latestPics as $lpic)
		{
            $archwebcam = $archwebcam + 1;
            if ($archwebcam < 10){
			?>
			
			<!--<div style="float:<?echo get_s_align();?>;padding:3px">
				<a href="<?=$lpic[1]?>" title="<?echo getLocalTime($lpic[0]);?>" class="colorbox">
					<? echo $lpic[1]; ?>
					
				</a>
			</div>-->
            <? }
		}

$result = db_init("SELECT * FROM PicOfTheDay order by uploadedAt DESC LIMIT 10","");
$pic_number = 0;
while ($line = $result["result"]->fetch_array(MYSQLI_ASSOC)) {
        $picaname = PIC_PREFIX_PATH.$line["picname"];
        if ($pic_number % 1 == 0)
            echo "<div class=\"clear\" ></div>";
        ?>
        
       <!--<div style="float:<?echo get_s_align();?>;padding-right:5px;width:200px;margin-top:20px;direction:rtl" id="<?=$line["idx"]?>" <? if ($line["approved"] == 1) echo "class=\"inv_plain_3_zebra\"";?>>
           
           <input type="checkbox" id="approved<?=$line["idx"]?>" name="approved<?=$line["idx"]?>"  value="<?=$line["approved"]?>" <? if ($line["approved"] == 1) echo "checked=\"checked\""; ?> />
           <input type="hidden" id="picname<?=$line["idx"]?>" name="<?=$picaname?>"  value="<?=$picaname?>" <? if ($line["approved"] == 1) echo "checked=\"checked\""; ?> />
           <input type="hidden" id="reg_id<?=$line["idx"]?>" value="<?=$line["reg_id"]?>" />&nbsp;&nbsp;&nbsp;&nbsp;
           <img src="images/rotate.png" width="16px" onclick="getOnePicService(this.parentNode.id, 'R')" style="cursor:pointer" /><br/>
           <?=$line["name"]." <br/>".$line["comment"]."<br/>".$line["x"]." <br/>".$line["y"]?>
           
       
                                
                <a href="<?=$picaname?>" title="" class="colorbox">
                        
                        <img src="phpThumb.php?src=<? echo $picaname ?>&amp;w=150" width="150px" title="<?=$picaname?>" />

                </a>
        </div>-->
        
        
        <? 
        $pic_number++;
}*/

?>

<form method="post" action="small.php?section=picsOfTheDayManager.php" enctype="multipart/form-data">
<input type='file' onchange="readURL(this);" accept="image/*" name="imagefile" id="imagefile"   size="120"  style="float:left;width:150px"/><br />
<img id="localimg" src="#" alt="your image" width="300"/><br />
comment1<br />
<textarea  name="comment1" id="comment1" size="30" style="height: 3em;width:310px" dir="rtl" wrap="soft"></textarea><br />
comment0<br />
<textarea name="comment0" id="comment0" size="30" style="height: 3em;width:310px" wrap="soft"></textarea><br />
<input type='button' class="button" name='upload_btn' value='upload' onclick="javascript:postToServer();" style="float:left;padding: 2em;width:150px" size="60"/>
</form>
<progress></progress> 
<div id="result"></div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
<script language="javascript">
function postToServer(){
    var fd = new FormData();    
    fd.append( 'imagefile', $('#imagefile')[0].files[0] );
    fd.append( 'comment0', $('#comment0').val() );
    fd.append( 'comment1', $('#comment1').val() );
    $('progress').show();
    $.ajax({
        // Your server script to process the upload
        url: 'picsOfTheDayManager.php',
        type: 'POST',

        // Form data
        data: fd,

        // Tell jQuery not to process data or worry about content-type
        // You *must* include these options!
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            $('progress').hide();
            $('#result').html(data);
            var copyText = document.getElementById("result");
            copyText.select();
            document.execCommand("copy");
        },
        error: function (error) {
            $('progress').hide();
            alert(error.status+ ' '+error.responseText);
        },
        // Custom XMLHttpRequest
        xhr: function() {
            var myXhr = $.ajaxSettings.xhr();
            if (myXhr.upload) {
                // For handling the progress of the upload
                myXhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                        $('progress').attr({
                            value: e.loaded,
                            max: e.total,
                        });
                    }
                } , false);
            }
            return myXhr;
        }
    });
}
 function initGeolocation() {
 if (navigator && navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
        } else {
            console.log('Geolocation is not supported');
        }
}
 
function errorCallback() {}
 
function successCallback(position) {
        alert(position.coords.latitude + ',' + position.coords.longitude);
    }
function validateForm(){
    var image = document.getElementById("imagefile").value;
    var comment1 = document.getElementById("comment1").value;
    var comment0 = document.getElementById("comment0").value;
    if (comment1 =='')
    {
        return false;
    }
    else 
    {
        return true;
    } 
    return true;
}
function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#localimg')
                    .attr('src', e.target.result)
                    .width(300)
                    .show()
                    ;
            };

            reader.readAsDataURL(input.files[0]);
        }
    }    


function fillPage(str)
{
	var forecastDetails = document.getElementById('section');
	
	 forecastDetails.innerHTML = str;
	 //forecastDetails.appendChild(newDiv); 
	
}
$('document').ready(function() {
//    initGeolocation();
    $('progress').hide();
    $('.adunit').hide();
    $('.nav').hide();
    $('#localimg').hide();
    });
</script>
</html>
<?}?>