<?
ini_set("display_errors","On");
include ("include.php");
include ("lang.php");
ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE);
/**
 * @param $http2ch          the curl connection
 * @param $http2_server     the Apple server url
 * @param $apple_cert       the path to the certificate
 * @param $app_bundle_id    the app bundle id
 * @param $message          the payload to send (JSON)
 * @param $token            the token of the device
 * @return mixed            the status code
 */
function sendHTTP2Push($http2ch, $http2_server, $apple_cert, $app_bundle_id, $message, $token) {
 
    // url (endpoint)
    $url = "{$http2_server}/3/device/{$token}";
 
    // certificate
    $cert = realpath($apple_cert);
 
    // headers
    $headers = array(
        "apns-topic: {$app_bundle_id}",
        "User-Agent: My Sender"
    );
 
    // other curl options
    curl_setopt_array($http2ch, array(
        CURLOPT_URL => $url,
        CURLOPT_PORT => 443,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_POST => TRUE,
        CURLOPT_POSTFIELDS => $message,
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSLCERT => $cert,
        CURLOPT_HEADER => 1
    ));
 
    // go...
    $result = curl_exec($http2ch);
    if ($result === FALSE) {
      throw new Exception("Curl failed: " .  curl_error($http2ch));
    }
 
    // get response
    $status = curl_getinfo($http2ch, CURLINFO_HTTP_CODE);
 
    return $status;
}
function sendAPN($registrationIDs, $msg, $picture_url, $embedded_url){
    // open connection 
    $http2ch = curl_init();
    curl_setopt($http2ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);

    // send push    
    $apple_cert = 'ApplePush1218.pem';
    $message = '{"aps":{"alert":"{$msg}","sound":"lighttrainshort.wav","badge":"1"}}';
    $token = '60d07e08504afbe5ab71b8be58f0c5ea4ca048f678e1b3393434e431340f450a';
    $http2_server = 'https://api.push.apple.com';
    $app_bundle_id = 'il.co.02ws';

    $status = sendHTTP2Push($http2ch, $http2_server, $apple_cert, $app_bundle_id, $message, $token);
    echo "Response from apple -> {$status}\n";

    // close connection
    curl_close($http2ch);
}


function sendAPNMessage($messageBody, $title, $picture_url, $embedded_url, $short_range, $long_range, $tip, $dailyforecast)
{
  
    global $TIP, $ALERTS_PAYMENT;
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
   
    $reg_id = "51f997efe2ef9b2427581386d0805f0d7d86ddc2cbbbc95eb610e06843b6e9ad"; //d057506a9d09770900a09fbeb25c9e404829937bc1b3da0d34216f9cc57608e5//6d5c6ca8d3d36348ea4c52f6e0813e6713ef9b823a3da66a3714228e67146a10 
    array_push ($registrationIDs1,array('apn_regid' => $reg_id, 'id' => '8025'));
   $query_extension = "";
        
   /* if ((boolval($long_range))&&(boolval($short_range))){
        $query = "select * FROM apn_users where active=1 or active_rain_etc=1".$query_extension;
    }
    else if (boolval($long_range)){
        $query = "select * FROM apn_users where active=1".$query_extension;
    }
    else if (boolval($short_range)){
        $query = "select * FROM apn_users where active_rain_etc=1 and approved=1".$query_extension;
    }
    else if (boolval($tip)){
        $query = "select * FROM apn_users where active_tips=1".$query_extension;
    }
    else if (boolval($dailyforecast)){
        $query = "select * FROM apn_users where dailyforecast=".date("H").$query_extension;
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
    }*/
 $result = "";
 if (strlen($title[1]) > 0){
    $messageBody[0] = $title[0].": ".$messageBody[0];
    $messageBody[1] = $title[1].": ".$messageBody[1];
 }
 $result = sendAPNToRegIDs($registrationIDs1, date('H:i')." ".$messageBody[1], $picture_url, $embedded_url);
 $result .= sendAPNToRegIDs($registrationIDs0, date('H:i')." ".$messageBody[0], $picture_url, $embedded_url);
 return $result;

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
    
    $result = sendAPNMessage($msgSpecial, $title, $picture_url, "alerts.php", "true", "true", "true");   
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
