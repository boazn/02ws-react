<?
ini_set("display_errors","On");
include ("include.php");
include ("lang.php");
ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE);
function sendAPNToRegIDs($registrationIDs, $message, $picture_url, $embedded_url){
    logger("sendingAPNMessage : ".count($registrationIDs)." ".$message);
    $payload['aps'] = array('alert' => $message, 'badge' => 1, 'sound' => 'default','EmbeddedUrl' => $embedded_url, 'picture' => $picture_url);
    $payload = json_encode($payload);

    $apnsHost = 'gateway.push.apple.com';
    $apnsPort = 2195;
    $apnsCert = 'apns-prod-1216.pem';//old= certPushProd.pem;new=apnsPushProd_1216.pem;apns-prod-1216.pem
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

            while(!fwrite($apns, $apnsMessage, strlen ($apnsMessage))){
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
    $apnsCert = 'certPushProd.pem';
       
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
$reg_id = "6d5c6ca8d3d36348ea4c52f6e0813e6713ef9b823a3da66a3714228e67146a10"; //d057506a9d09770900a09fbeb25c9e404829937bc1b3da0d34216f9cc57608e5//6d5c6ca8d3d36348ea4c52f6e0813e6713ef9b823a3da66a3714228e67146a10 
array_push ($registrationIDs1,array('apn_regid' => $reg_id, 'id' => '8025'));
/*if (($long_range)&&($short_range))
        $result = db_init("select * FROM apn_users where active=1 or active_rain_etc=1", "");
    else if ($long_range)
        $result = db_init("select * FROM apn_users where active=1", "");
    else if ($short_range)
        $result = db_init("select * FROM apn_users where active=1", "");

    while ($line = mysqli_fetch_array($result["result"], MYSQLI_ASSOC)) {
	  if ($line["apn_regid"] != "")
          {
              if ($line["lang"] == 0)
            array_push ($registrationIDs0, array('apn_regid' => $line["apn_regid"], 'id' => $line["id"]));
            elseif ($line["lang"] == 1)
            array_push ($registrationIDs1, array('apn_regid' => $line["apn_regid"], 'id' => $line["id"]));
          }
    }
*/
 $result = "";
 $result = sendAPNToRegIDs($registrationIDs1, $title[1]." - ".$messageBody[1], $picture_url, $embedded_url);
 $result .= sendAPNToRegIDs($registrationIDs0, $title[0]." - ".$messageBody[0], $picture_url, $embedded_url);
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

    return $result;
}

return "";
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
   var_dump($post);
} else {
   $result .= "We have " . count($empty) . " empty values\n";
   $result .= "Posted:\n"; var_dump($post);
   $result .= "Empty:\n";  var_dump($empty);
   
}
try{
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
    
    $result = sendAPNMessage($msgSpecial, $title, $picture_url, "alerts.php");   
	//$result = cleanInvalidAPNTokens();
    logger($result);
    /*if (empty($_POST['title1']))
        $EmailSubject = array("02ws Update Service", "שירות עדכון ירושמיים");
    else {
        $EmailSubject = array($title[0], $title[1]);
    }
    $result .= send_Email($msgSpecial, ALL, EMAIL_ADDRESS, "", "", $EmailSubject);
    $result .= post_to_bufferApp($msgSpecial[1]); */
} catch (Exception $ex) {
    $result .= " exception:".$ex->getMessage();
}

echo $result;
?>
