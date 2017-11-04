<?
ini_set("display_errors","On");
include ("include.php");
include ("lang.php");
ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE);
class CloudMessageType {

    const Gcm = 1;
    const Fcm = 2;
}
/*******************************************************************************************/
function post_to_bufferApp($messageBody, $picture_url)
{
    require_once 'class.bufferapp.php';
    $buffer = new BufferPHP('1/29f298b89c511ae270e37771677bd1cf');//access token

    $data = array('profile_ids' => array());
    $data['profile_ids'][] = '529d7e1211243a4360000082'; //twitter profile ID
    $data['profile_ids'][] = '53ce668a03b018e36febc9c7'; //fb profile ID
    $data['profile_ids'][] = '529d83fa11243a36600000a3'; //g+ profile ID
    $data['text'] = $messageBody;
    if (empty($picture_url)){
        $picture_url = 'http://www.02ws.co.il/images/webCameraB.jpg';
        $picture_url = 'http://www.02ws.co.il/02ws_short.png';
    }
    //$data['media'] = array('link' => 'http://www.02ws.co.il/02ws_short.png');
    //$data['media'] = array('picture' => $picture_url, 'thumbnail' => $picture_url);
    $data['client_id']='53f8f11aa9dc830067715093';
    $data['client_secret']= '228199ac982c39a26378a58a998d2f08';
    $data['redirect_uri']= "www.02ws.co.il";

    //if you want to share this immediately set this to true else set it to false if you wish to schedule it for sharing later
    $data['now']=true;
    //$ret = new stdClass();
    $ret = $buffer->post('updates/create', $data);
    //var_dump($ret);
    
     logger("bufferApp: ".$ret->message);
    return "";
}
function sendAPNToRegIDs($registrationIDs, $message, $picture_url, $embedded_url){
    logger("sendingAPNMessage : ".count($registrationIDs)." ".$message);
    $payload['aps'] = array('alert' => $message, 'badge' => 1, 'sound' => 'lighttrainshort.wav', 'content-available' => 1, 'category' => "share", 'EmbeddedUrl' => $embedded_url, 'picture' => $picture_url);
    $payload = json_encode($payload);

    $apnsHost = 'gateway.push.apple.com';
    $apnsPort = 2195;
    $apnsCert = 'CertPushProd291116.pem';//old= certPushProd.pem;new=apns-prod-1216.pem
    // Keep push alive (waiting for delivery) for 1 hour
    $apple_expiry = time() + (60 * 60);
    $streamContext = stream_context_create();
    stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
    stream_context_set_option($streamContext, 'ssl', 'passphrase', "boaz1972");
    $resultAPNs = "";
    $apns = stream_socket_client('ssl://' . $apnsHost . ':' . $apnsPort, $error, $errorString, 2, STREAM_CLIENT_CONNECT, $streamContext);
    stream_set_blocking ($apns, 0);
    foreach ($registrationIDs as $regIDs){
            //$apnsMessage = chr(0) . chr(0) . chr(32) . pack('H*', str_replace(' ', '', $regIDs['apn_regid'])) . chr(0) . chr(strlen($payload)) . $payload;
            $apnsMessage = pack("C", 1) . pack("N", $regIDs['id']) . pack("N", $apple_expiry) . pack("n", 32) . pack('H*', str_replace(' ', '', $regIDs['apn_regid'])) . pack("n", strlen($payload)) . $payload; 

            if(!fwrite($apns, $apnsMessage, strlen ($apnsMessage))){
                    $resultAPNs .= checkAppleErrorResponse($apns);
                    $query = "update apn_users set ResponseMessage='{$resultAPNs}' where apn_regid='".$regIDs['apn_regid']."';";
                    //logger($query);
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
function cleanInvalidAPNTokens()
{
    $result = db_init("select * FROM apn_users", "");
    $registrationIDs = array();
    $invalidregistrationIDs = array();
     while ($line = mysqli_fetch_array($result["result"], MYSQLI_ASSOC)) {
	  if ($line["apn_regid"] != "")
          {
             array_push ($registrationIDs, array('apn_regid' => $line["apn_regid"], 'id' => $line["id"]));
          }
    }
    logger("cleanInvalidAPNTokens : ".count($registrationIDs)." ".$message);
    
    $apnsHost = 'feedback.push.apple.com';
    $apnsPort = 2196;
    $apnsCert = 'CertPushProd.pem';
       
    $streamContext = stream_context_create();
    stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
    $apns = stream_socket_client('ssl://' . $apnsHost . ':' . $apnsPort, $error, $errorString, 2, STREAM_CLIENT_CONNECT, $streamContext);
    if(!$apns) {
        logger( "ERROR $errcode: $errstr\n");
        return;
    }


    $feedback_tokens = array();
    //and read the data on the connection:
    while(!feof($apns)) {
        $data = fread($apns, 38);
        if(strlen($data)) {
            $feedback_tokens[] = unpack("N1timestamp/n1length/H*devtoken", $data);
        }
    }
    fclose($apns);
    $invalid_feedback_tokens = "";
    foreach ($feedback_tokens as $feedback_token){
        $invalid_feedback_tokens .= ",".$feedback_token['devtoken'];
    }
    logger ("invalid feedback_tokens: ".$invalid_feedback_tokens);
    return $feedback_tokens;
}
function sendAPNMessage($messageBody, $title, $picture_url, $embedded_url, $short_range, $long_range, $tip)
{
  
    global $TIP;
    // Report all PHP errors
    error_reporting(-1);
    $registrationIDs0 = array();
    $registrationIDs1 = array();
    $short_range = ($short_range === 'true');
    $long_range = ($long_range === 'true');
    $tip = ($tip === 'true');
    if (boolval($tip)){
        $messageBody[0] = $TIP[0].": ".$messageBody[0];
        $messageBody[1] = $TIP[1].": ".$messageBody[1];
    }
   
    //$reg_id = "6d5c6ca8d3d36348ea4c52f6e0813e6713ef9b823a3da66a3714228e67146a10"; //d057506a9d09770900a09fbeb25c9e404829937bc1b3da0d34216f9cc57608e5//6d5c6ca8d3d36348ea4c52f6e0813e6713ef9b823a3da66a3714228e67146a10 
    //array_push ($registrationIDs1,array('apn_regid' => $reg_id, 'id' => '8025'));
   $query_extension = "";
        
    if ((boolval($long_range))&&(boolval($short_range))){
        $query = "select * FROM apn_users where active=1 or active_rain_etc=1".$query_extension;
    }
    else if (boolval($long_range)){
        $query = "select * FROM apn_users where active=1".$query_extension;
    }
    else if (boolval($short_range)){
        $query = "select * FROM apn_users where active_rain_etc=1".$query_extension;
    }
    else if (boolval($tip)){
        $query = "select * FROM apn_users where active_tips=1".$query_extension;
    }
     logger($query);
     $result = db_init($query, "");   
    while ($line = mysqli_fetch_array($result["result"], MYSQLI_ASSOC)) {
	  if ($line["apn_regid"] != "")
          {
              if ($line["lang"] == 0)
            array_push ($registrationIDs0, array('apn_regid' => $line["apn_regid"], 'id' => $line["id"]));
            elseif ($line["lang"] == 1)
            array_push ($registrationIDs1, array('apn_regid' => $line["apn_regid"], 'id' => $line["id"]));
          }
    }
 $result = "";
 if (strlen($title[1]) > 0){
    $messageBody[0] = $title[0].": ".$messageBody[0];
    $messageBody[1] = $title[1].": ".$messageBody[1];
 }
 $result = sendAPNToRegIDs($registrationIDs1, date('H:i')." ".$messageBody[1], $picture_url, $embedded_url);
 $result .= sendAPNToRegIDs($registrationIDs0, date('H:i')." ".$messageBody[0], $picture_url, $embedded_url);
 return $result;

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

    $result .= 'Identifier is the rowID (index) in the database that caused the problem, and Apple will disconnect you from server. To continue sending Push Notifications, just start at the next rowID after this Identifier.<br>';

    return $error_response['command']." ".$error_response['identifier']." ".$error_response['status_code'];
}
    return "";
}
function sendGCMMessage($messageBody, $title, $picture_url, $embedded_url, $short_range, $long_range, $tip, $CloudMessageType)
{
    global $TIP;
    $key = "";
    $registrationIDs0 = array();
    $registrationIDs1 = array();
    $lines = 0;
    $query = "";
    $short_range = ($short_range === 'true');
    $long_range = ($long_range === 'true');
    $tip = ($tip === 'true');
    if (boolval($tip)){
        $messageBody[0] = $TIP[0].": ".$messageBody[0];
        $messageBody[1] = $TIP[1].": ".$messageBody[1];
    }
    $messageBody[0] = date('H:i')." ".$messageBody[0];
    $messageBody[1] = date('H:i')." ".$messageBody[1];
    if ($CloudMessageType == CloudMessageType::Fcm)
    {
        $key = FCM_API_KEY;
        $query_extension = " and fcm=1";
    }
    else
    {
        $key = GOOGLE_API_KEY;
        $query_extension = " and fcm<>1";
    }
    if ((boolval($long_range))&&(boolval($short_range))){
        $query = "select * FROM gcm_users where active=1 or active_rain_etc=1".$query_extension;
    }
    else if (boolval($long_range)){
        $query = "select * FROM gcm_users where active=1".$query_extension;
    }
    else if (boolval($short_range)){
        $query = "select * FROM gcm_users where active_rain_etc=1".$query_extension;
    }
    else if (boolval($tip)){
        $query = "select * FROM gcm_users where active_tips=1".$query_extension;
    }
    $result = db_init($query, "");
    while ($line = mysqli_fetch_array($result["result"], MYSQLI_ASSOC)) {
	$lines++;
        //echo "<br />".$line["gcm_regid"]."<br />";
        if ($line["lang"] == 0)
            array_push ($registrationIDs0, $line["gcm_regid"]);
        elseif ($line["lang"] == 1)
            array_push ($registrationIDs1, $line["gcm_regid"]);
    }
    
    logger($query);
    logger("sendingGCMMessage CloudMessageType=".$CloudMessageType.": En:".count($registrationIDs0)." Heb:".count($registrationIDs1));
     
    /* test
   
        $registrationIDs = array();
        $registrationIDs0 = array();
        $registrationIDs1 = array();
    
	 //test boazn1@gmail.com
	 // test efrat
         if ($CloudMessageType == CloudMessageType::Fcm)
            array_push ($registrationIDs1, "cPzSkq79gR8:APA91bEGTjUIg8wceFjU9h0dK-GpooqUbH2qbjPiFZMVsmmyvdGLvcDxBHbdEaFr4WJYWfqyWauoxupi3cbV2rTecW3EqlxoNuR42IX0X94pdUmqRJSl8CFN25WI3GkTn1Hst7obPIkJ");
         else
            array_push ($registrationIDs1, "APA91bHeuwNkpfuhTy5IUUseUL-BOPwnhmY8nJNS_uuV_ZpcYnRDVjQfcaiiQnEI0MxH2W1dDyViJDF22It_ZYawz8UkxDcXgIaZxOMnM1GZBSTz-TPvzfmRCo38KTZLLKZnmqoe1SgICq88Ymy92_cBHWuam8nINA");
       */   
     //
     $result = "";
     $resultCall = array();
     $arrOfRegID0 = array_chunk($registrationIDs0, 1000);
     foreach ($arrOfRegID0 as $regIDs){
        
        $resultCall = callGCMSender ($key, $regIDs, $messageBody[0], $title[0], $picture_url, $embedded_url);
        if ($CloudMessageType == CloudMessageType::Fcm){
            logger($resultCall[1]);
        }
        handleInvalidTokens($resultCall[1], $regIDs, $key);
      }
    
     $arrOfRegID1 = array_chunk($registrationIDs1, 1000);
     foreach ($arrOfRegID1 as $regIDs){
        
        $resultCall = callGCMSender ($key, $regIDs, $messageBody[1], $title[1], $picture_url, $embedded_url);
        //logger($resultCall[1]);
        handleInvalidTokens($resultCall[1], $regIDs, $key);
     }
    
     
     
     //logger($result);
    return "";        
}
function handleInvalidTokens($jsonArray, $registration_ids, $header_key){
    $remove_ids = array();
    $errorMessage = array();
    logger("handleInvalidTokens: header_key(SenderID)=".$header_key." success:".$jsonArray["success"]." + failure:".$jsonArray["failure"]." = ".count($jsonArray["results"]));
     for($i=0; $i<count($jsonArray["results"]);$i++){
        if(isset($jsonArray["results"][$i]["error"])){
            if($jsonArray["results"][$i]["error"] == "NotRegistered"){
                $remove_ids[$i] = $registration_ids[$i];
            }else{
                $errorMessage[$i] = array('id' => $registration_ids[$i], 'desc' => $jsonArray["results"][$i]["error"], 'idx' => $i);
            }
        }
    }
     global $link;
    foreach ($remove_ids as $id){
         //print_r($regIDs);
         $query = "update gcm_users set ResponseCode='9', ResponseMessage='NotRegistered' where gcm_regid='".$id."'";
         $resultUpdate = mysqli_query($link, $query);
         //logger($query);
     }
     foreach ($errorMessage as $err){
         //print_r($regIDs);
         $query = "update gcm_users set ResponseCode='5', ResponseMessage=".$err['desc']." where gcm_regid='".$err['id']."'";
         $resultUpdate = mysqli_query($link, $query);
         logger($err['idx'].". ".$query);
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
function updateMessageFromMessages ($description, $active, $type, $lang, $href, $img_src, $title)
{
    try
    {
        global $lang_idx;
        $lang_idx = $lang;
        $description = nl2br($description);
        $now = replaceDays(date('D j/m/y H:i'));
        $append = true;
        if ($append)
        {

            $res = db_init("SELECT * FROM  `content_sections` WHERE (TYPE =  'forecast') and (lang=?)", $lang);
            while ($line = mysqli_fetch_array($res["result"], MYSQLI_ASSOC) ){
                $description = "<div class=\"alerttime\">".$now."</div>".$description."</br>".$line["Description"];
            }
        }

        //$now = getLocalTime(time());

        $query = "UPDATE `content_sections` SET Description='{$description}', active={$active}, href='{$href}', img_src='{$img_src}', Title='{$title}'  WHERE (type='$type') and (lang=$lang)";
        apc_store('descriptionforecast'.$lang, $description);
        $res = db_init($query, "" );
        // Free resultset 
        @mysqli_free_result($res);
    }
    catch (Exception $ex) {
        $result .= " exception:".$ex->getMessage();
    }   
	
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
   print "None of the POSTed values are empty, posted:\n";
   //var_dump($post);
} else {
   $result .= "We have " . count($empty) . " empty values\n";
   $result .= "Posted:\n"; var_dump($post);
   $result .= "Empty:\n";  var_dump($empty);
   
}
    $result = "";
    $msgSent = true;
    $name = array($_POST['name0'], $_POST['name1']);
    $email = $_POST['email'];
    $message = array($_POST['message0'], $_POST['message1']);
    $msgSpecial = array($_POST['message0'], $_POST['message1']);
    
    $title = array($_POST['title0'], $_POST['title1']);
    $picture_url = $_POST['picture_url'];
    $embedded_url = $_POST['embedded_url'];
    if ($msgSpecial == ""){
        $result = "Empty Message";
        echo $result;
        exit;
    }
    
    if (empty($picture_url))
        $img_tag = "";
    else
        $img_tag = " <img src=\"".$picture_url."\" id=\"alert_image\" alt=\"alert image\" />";
    
    try{
        $msgToAlertSection = array($message[0]."<br />".$img_tag, $message[1]."<br />".$img_tag);
        if (strlen($title[0]) > 0){
            $msgToAlertSection[0] = $title[0].": ".$msgToAlertSection[0];
            $msgToAlertSection[1] = $title[1].": ".$msgToAlertSection[1];
        }
        
        updateMessageFromMessages ($msgToAlertSection[0], 1, 'forecast', 0 ,'' ,'','');
        updateMessageFromMessages ($msgToAlertSection[1], 1, 'forecast', 1 ,'' ,'','');
    } 
    catch (Exception $ex) {
        $result .= " exception updateMessageFromMessages:".$ex->getMessage();
    }
    
    try{
        //$result .= sendGCMMessage($msgSpecial, $title, $picture_url, $embedded_url, $_POST["short_range"], $_POST["long_range"], $_POST["tip"]);   
        $result .= sendGCMMessage($msgSpecial, $title, $picture_url, $embedded_url, $_POST["short_range"], $_POST["long_range"], $_POST["tip"], CloudMessageType::Gcm);
        $result .= sendGCMMessage($msgSpecial, $title, $picture_url, $embedded_url, $_POST["short_range"], $_POST["long_range"], $_POST["tip"], CloudMessageType::Fcm);
    
    } catch (Exception $ex) {
        $result .= " exception sendGCMMessage:".$ex->getMessage();
    }
    
    try{
        $result .= sendAPNMessage($msgSpecial, $title, $picture_url, "alerts.php", $_POST["short_range"], $_POST["long_range"], $_POST["tip"]);
    } 
    catch (Exception $ex) {
        $result .= " exception sendAPNMessage:".$ex->getMessage();
    }
    
    try {
        if (empty($_POST['title1']))
        $EmailSubject = array("02ws Update Service", "שירות עדכון ירושמיים");
        else {
        $EmailSubject = array($title[0], $title[1]);
        }
        $result .= send_Email(array($_POST['message0']." ".$img_tag, $_POST['message1']." ".$img_tag), ALL, EMAIL_ADDRESS, "", "", $EmailSubject);
    } 
    catch (Exception $ex) {
       $result .= " exception send_Email:".$ex->getMessage();
    }
    
    try {
        
         $msgToBuffer = $msgSpecial[1]." ".$picture_url;
         if (strlen($title[1]) > 0) {$msgToBuffer = $title[1].": ".$msgToBuffer;}
	 //$result .= post_to_bufferApp($msgToBuffer, $picture_url); 
    } 
    catch (Exception $ex) {
        $result .= " exception post_to_bufferApp:".$ex->getMessage();
    }
       
    try{
    //   $result = cleanInvalidAPNTokens();
    } catch (Exception $ex) {
        $result .= " exception sendAPNMessage:".$ex->getMessage();
    }
    print_r($result);
?>
