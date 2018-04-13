



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
function sendAPNToRegIDs($registrationIDs, $message, $picture_url, $embedded_url){
    logger("sendingAPNMessage : ".$registrationIDs[0]." ".$message);
    $regisIDs = array();
    array_push($regisIDs, array('apn_regid' => $registrationIDs[0], 'id' => 1));
    $payload['aps'] = array('alert' => $message, 'badge' => 1, 'sound' => 'default','EmbeddedUrl' => $embedded_url, 'picture' => $picture_url);
    $payload = json_encode($payload);

    $apnsHost = 'gateway.push.apple.com';
    $apnsPort = 2195;
    $apnsCert = 'CertPushProd291116.pem';//certPushDev.pem;apns-prod-1216.pem;apnProdCert171116.pem
    // Keep push alive (waiting for delivery) for 1 hour
    $apple_expiry = time() + (60 * 60);
    $streamContext = stream_context_create();
    stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
    stream_context_set_option($streamContext, 'ssl', 'passphrase', "boaz1972");
    $resultAPNs = "";
    $apns = stream_socket_client('ssl://' . $apnsHost . ':' . $apnsPort, $error, $errorString, 2, STREAM_CLIENT_CONNECT, $streamContext);
    stream_set_blocking ($apns, 0);
    foreach ($regisIDs as $regIDs){
            //$apnsMessage = chr(0) . chr(0) . chr(32) . pack('H*', str_replace(' ', '', $regIDs['apn_regid'])) . chr(0) . chr(strlen($payload)) . $payload;
            $apnsMessage = pack("C", 1) . pack("N", $regIDs['id']) . pack("N", $apple_expiry) . pack("n", 32) . pack('H*', str_replace(' ', '', $regIDs['apn_regid'])) . pack("n", strlen($payload)) . $payload; 

            if(!fwrite($apns, $apnsMessage, strlen ($apnsMessage))){
                    usleep(400000); //400 msec
                    $resultAPNs .= checkAppleErrorResponse($apns);
                    logger("fwrite failed: ".$regIDs['id']." ".$regIDs['apn_regid']." ".$resultAPNs);
                    $streamContext = stream_context_create();
                    stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
                    stream_context_set_option($streamContext, 'ssl', 'passphrase', "boaz1972");
                    $apns = stream_socket_client('ssl://' . $apnsHost . ':' . $apnsPort, $error, $errorString, 2, STREAM_CLIENT_CONNECT, $streamContext);
                    stream_set_blocking ($apns, 0);
                    
                
            }
        
		//logger($resultAPNs);
    }
    // Workaround to check if there were any errors during the last seconds of sending.
    // Pause for half a second. 
    // Note I tested this with up to a 5 minute pause, and the error message was still available to be retrieved
    usleep(500000); 

    $resultAPNs .= checkAppleErrorResponse($apns);

    $resultAPNs .= ' --- '.count($registrationIDs).' APNs Completed';
    logger($resultAPNs);
    @socket_close($apns);
    fclose($apns);
    return $errorString." ".$resultAPNs;
}
// FUNCTION to check if there is an error response from Apple
// Returns TRUE if there was and FALSE if there was not
function checkAppleErrorResponse($fp) {

//byte1=always 8, byte2=StatusCode, bytes3,4,5,6=identifier(rowID). 
// Should return nothing if OK.

//NOTE: Make sure you set stream_set_blocking($fp, 0) or else fread will pause your script and wait 
// forever when there is no response to be sent. 
$result = "";
stream_set_blocking($fp, 0);
$apple_error_response = fread($fp, 6);

if ($apple_error_response) {

    // unpack the error response (first byte 'command" should always be 8)
    $error_response = unpack('Ccommand/Cstatus_code/Nidentifier', $apple_error_response); 

    if ($error_response['status_code'] == '0') {
    $error_response['status_code'] = '0-No errors encountered';

    } else if ($error_response['status_code'] == '1') {
    $error_response['status_code'] = '1-Processing error';

    } else if ($error_response['status_code'] == '2') {
    $error_response['status_code'] = '2-Missing device token';

    } else if ($error_response['status_code'] == '3') {
    $error_response['status_code'] = '3-Missing topic';

    } else if ($error_response['status_code'] == '4') {
    $error_response['status_code'] = '4-Missing payload';

    } else if ($error_response['status_code'] == '5') {
    $error_response['status_code'] = '5-Invalid token size';

    } else if ($error_response['status_code'] == '6') {
    $error_response['status_code'] = '6-Invalid topic size';

    } else if ($error_response['status_code'] == '7') {
    $error_response['status_code'] = '7-Invalid payload size';

    } else if ($error_response['status_code'] == '8') {
    $error_response['status_code'] = '8-Invalid token';

    } else if ($error_response['status_code'] == '255') {
    $error_response['status_code'] = '255-None (unknown)';

    } else {
    $error_response['status_code'] = $error_response['status_code'].'-Not listed';

    }

    $result =  '<br><b>+ + + + + + ERROR</b> Response Command:<b>' . $error_response['command'] . '</b>&nbsp;&nbsp;&nbsp;Identifier:<b>' . $error_response['identifier'] . '</b>&nbsp;&nbsp;&nbsp;Status:<b>' . $error_response['status_code'] . '</b><br>';

    //$result .= 'Identifier is the rowID (index) in the database that caused the problem, and Apple will disconnect you from server. To continue sending Push Notifications, just start at the next rowID after this Identifier.<br>';

    return $result;
}
}
function callGCMSender($key, $registrationIDs, $messageBody, $title, $picture_url, $embedded_url){
     
    logger("callGCMSender: header_key(SenderID)=".$key."  count=".count($registrationIDs)." ".$messageBody." ".$title." ".$picture_url." ".$embedded_url);
    // Set POST variables
    $url = 'https://android.googleapis.com/gcm/send';

    $fields = array(
        'registration_ids' => $registrationIDs,
        'data' => array( "message" => $messageBody, "title" => $title, "picture_url" => $picture_url, "embedded_url" => $embedded_url),
    );
        
    $headers = array(
        'Authorization: key=' . $key, 
        'Content-Type: application/json'
    );

    // Open connection
    $ch = curl_init();
    //print_r($headers);
    //print_r($registrationIDs);
    // Set the URL, number of POST vars, POST data
    curl_setopt( $ch, CURLOPT_URL, $url);
    curl_setopt( $ch, CURLOPT_POST, true);
    curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( $fields));

    // Execute post
    $result = curl_exec($ch);
    $resultHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    //logger("sendGCMMessage: ".$result);
    // Close connection
    curl_close($ch);
    
    switch ($resultHttpCode) {
            case "200":
                //All fine. Continue response processing.
                break;

            case "400":
                logger("curl_getinfo GCM: ".$resultHttpCode." ".$result);
                break;

            case "401":
                logger("curl_getinfo GCM: ".$resultHttpCode." ".$result);
                break;

            default:
                //TODO: Retry-after
                logger("curl_getinfo GCM: ".$resultHttpCode." ".$result);
                break;
        }
    return array($resultHttpCode, json_decode($result, true));
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

$result = db_init("SELECT * FROM UserPicture order by uploadedAt DESC LIMIT 10","");
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

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
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
