<?
ini_set("display_errors","On");
include ("include.php");
include ("lang.php");
ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE);
require_once 'vendor/autoload.php';

use Jose\Component\Core\AlgorithmManager;
use Jose\Component\KeyManagement\JWKFactory;
use Jose\Component\Signature\JWSBuilder;
use Jose\Component\Signature\Algorithm\ES256;
use Jose\Component\Signature\Serializer\JWSSerializerManager;
use Jose\Component\Signature\Serializer\CompactSerializer;


function getToken($cerPath, $secret, $teamId) {
	// 1.
	$algorithmManager = new AlgorithmManager([ 
		new ES256() 
	]);

	// 2.
	$jwk = JWKFactory::createFromKeyFile($cerPath);

	// We instantiate our JWS Builder.
	$jwsBuilder = new JWSBuilder(
	    $algorithmManager
	);

	// 3.
	$payload = json_encode([
	    'iat' => time(),
	    'iss' => $teamId,
	]);

	// 4.
	$jws = $jwsBuilder
	    ->create()                                                  // We want to create a new JWS
	    ->withPayload($payload)                                     // We set the payload
	    ->addSignature($jwk, ['alg' => 'ES256', 'kid' => $secret])  // We add a signature with a simple protected header
	    ->build();                                                  // We build it

    // The serializer manager. We only use the JWS Compact Serialization Mode.
    $serializerManager = new JWSSerializerManager([
        new CompactSerializer(),
    ]);
	
    // 5.
    $token = $serializerManager->serialize("jws_compact", $jws);
	return $token;
}

function sendAPN($registrationIDs, $msg, $picture_url, $embedded_url){
    // open connection 
    $http2ch = curl_init();
    curl_setopt($http2ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);

    // send push    
    $apple_cert = 'ApplePush1218.pem';
    $message = '{"aps":{"alert":"{$msg}","sound":"lighttrainshort.wav","badge":"1"}}';
    $token = '64559e7a912254227033d04a8e347e5563e142a4519a61a937af2c188cba1f1e';
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
    $key = FCM_API_KEY;
    
    //$reg_id = "64559e7a912254227033d04a8e347e5563e142a4519a61a937af2c188cba1f1e"; 
    //array_push ($registrationIDs1,array('apn_regid' => $reg_id, 'id' => '8026'));
    
    $reg_id = "64559e7a912254227033d04a8e347e5563e142a4519a61a937af2c188cba1f1e"; //266bac92854f25196892ed0895ec96f13590069c74c9ef38857586eb11cbfa18//64559e7a912254227033d04a8e347e5563e142a4519a61a937af2c188cba1f1e 
    $reg_id = $_REQUEST["reg_id"];
    array_push ($registrationIDs1,array('apn_regid' => $reg_id, 'id' => '8025'));
   $query_extension = "";
        
    if ((boolval($long_range))&&(boolval($short_range))){
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
   /* logger($query);
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
 $requests = array();
 $mh = curl_multi_init();
 $chunkedOfRegID1 = array_chunk($registrationIDs1, 2);
 foreach ($chunkedOfRegID1 as $regIDs1){
    $resultCall = callAPNSender ($key, $regIDs1, $messageBody[1], $title[1], $picture_url, $embedded_url);
    echo "result=".$resultCall[1];
 }
 $chunkedOfRegID0 = array_chunk($registrationIDs0, 2);
 foreach ($chunkedOfRegID0 as $regIDs0){
    $token = getToken('AuthKey_669J3G9XB5.p8', '669J3G9XB5', 'SAPLRRD8P5');
    $curl = sendAPNToRegIDsAsync($mh, $regIDs0, $title[0], date('H:i')." ".$messageBody[0], $picture_url, $embedded_url, $token);
 }
 curl_multi_close($mh);
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
    
    $result = sendAPNMessage($msgSpecial, $title, $picture_url, "alerts.php", "true", "true", "false", "false");   
	//$result = cleanInvalidAPNTokens();
    logger($result, 0, "APN", "sendAPNMessage", "sendAPNMessage");
    /*if (empty($_POST['title1']))
        $EmailSubject = array("02ws Update Service", "שירות עדכון ירושמיים");
    else {
        $EmailSubject = array($title[0], $title[1]);
    }
    $result .= send_Email($msgSpecial, ALL, EMAIL_ADDRESS, "", "", $EmailSubject);
    $result .= post_to_bufferApp($msgSpecial[1]); */
} catch (Exception $ex) {
    $result .= "<br />Exception in sendAPNMessage:".$ex->getMessage();
}

echo $result;
?>
