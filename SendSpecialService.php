<?
ini_set("display_errors","On");
include ("include.php");
include_once("start.php");
ini_set('error_reporting', E_ERROR | E_WARNING | E_PARSE);
require_once 'vendor/autoload.php';

use Jose\Component\Core\AlgorithmManager;
use Jose\Component\KeyManagement\JWKFactory;
use Jose\Component\Signature\JWSBuilder;
use Jose\Component\Signature\Algorithm\ES256;
use Jose\Component\Signature\Serializer\JWSSerializerManager;
use Jose\Component\Signature\Serializer\CompactSerializer;

class CloudMessageType {

    const Gcm = 1;
    const Fcm = 2;
}

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
/*******************************************************************************************/
 /**
     * Storing new user
     * returns user details
     */
    function storePic($name, $comment0, $comment1, $x, $y, $base64) {
        // insert user into database
        global $link;
		try{
			$file_path = "images/userpic/";
     
			$file_path = $file_path .$name;
			if ($base64 == 1){
				$data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $_POST["pic"]));
				file_put_contents($file_path, $data);
			}
			 else
				move_uploaded_file($_FILES['file']['tmp_name'], $file_path);
				
			//$result = db_init("call SaveUserPic ('$name', '$comment', '$user', '$picname', '$x', '$y')");
                        $result = db_init("INSERT INTO `UserPicture` (name, comment, approved, uploadedAt, User, x, y, picname, reg_id) VALUES('$name', '$comment', 0, SYSDATE(), '$user', '$x', '$y', '$picname', '$reg_id');", "");
			// check for successful store
			// get user details
			$id = $link->insert_id; // last inserted id
			logger("New pic user updated:".$id." ".$name." ".$comment." ".$user." ".$picname." ".$x." ".$y, 0, "Push", "SendSpecialService", "storePic");
              //send_Email("New pic user updated:".$id." ".$name." ".$comment." ".$user." ".$picname." ".$x." ".$y." <a href=\"https://www.02ws.co.il/small.php?section=userPicsManager.php\">click here</a> ", ME, $email, $email, "", array('New pic user updated', 'תמונה חדשה נשלחה'));
			$result = "https://".$_SERVER["HTTP_HOST"]."/".$file_path;  
			return $result;
        } catch (Exception $ex) {
            logger("New storePic exception:.".$name." ".$comment." ", 4, "Push", "SendSpecialService", "storePic");
        }
   
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
        $query = "select * FROM apn_users where active_rain_etc=1 and approved=1".$query_extension;
    }
    else if (boolval($tip)){
        $query = "select * FROM apn_users where active_tips=1".$query_extension;
    }
    else if (boolval($dailyforecast)){
        $query = "select * FROM apn_users where dailyforecast=".date("H").$query_extension;
    }
    logger($query, 0, "Push", "SendSpecialService", "sendAPNMessage");
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
 
 $chunkedOfRegID1 = array_chunk($registrationIDs1, 10000);
 foreach ($chunkedOfRegID1 as $regIDs1){
    $token = getToken('AuthKey_669J3G9XB5.p8', '669J3G9XB5', 'SAPLRRD8P5');
    $result .= sendAPNToRegIDs($regIDs1, $title[1], date('H:i')." ".$messageBody[1], $picture_url, $embedded_url, $token);
 }
 $chunkedOfRegID0 = array_chunk($registrationIDs0, 10000);
 foreach ($chunkedOfRegID0 as $regIDs0){
    $token = getToken('AuthKey_669J3G9XB5.p8', '669J3G9XB5', 'SAPLRRD8P5');
    $result .= sendAPNToRegIDs($regIDs0, $title[0], date('H:i')." ".$messageBody[0], $picture_url, $embedded_url, $token);
 }
 return $result;

}

function sendGCMMessage($messageBody, $title, $picture_url, $embedded_url, $short_range, $long_range, $tip, $dailyforecast, $CloudMessageType)
{
    global $TIP, $REPLY_ENGAGE, $ALERTS_PAYMENT;
    $key = "";
    $registrationIDs0 = array();
    $registrationIDs1 = array();
    $lines = 0;
    $query = "";
    $short_range = ($short_range === 'true');
    $long_range = ($long_range === 'true');
    $tip = ($tip === 'true');
    if (empty($picture_url)){
      //  $picture_url = 'https://www.02ws.co.il/02ws_short.png';
      //  $picture_url = 'https://www.02ws.co.il/images/webCamera0.jpg';
    }
    if (boolval($tip)){
        $messageBody[0] = $TIP[0].": ".$messageBody[0];
        $messageBody[1] = $TIP[1].": ".$messageBody[1];
    }
    $messageBody[0] = date('H:i')." ".$messageBody[0];
    $messageBody[1] = date('H:i')." ".$messageBody[1];
    $key = FCM_API_KEY;
    $query_extension = "";
    $res_fcm = "FCMs";
   
    if ((boolval($long_range))&&(boolval($short_range))){
        $query = "select lang, gcm_regid  FROM fcm_users where active=1 or active_rain_etc=1 UNION select lang, apn_regid gcm_regid FROM apn_users where active=1 or active_rain_etc=1".$query_extension;
    }
    else if (boolval($long_range)){
        $query = "select lang, gcm_regid FROM fcm_users where active=1 UNION select lang, apn_regid gcm_regid FROM apn_users where active=1".$query_extension;
    }
    else if (boolval($short_range)){
        $query = "select lang, gcm_regid FROM fcm_users where active_rain_etc=1 UNION select lang, apn_regid gcm_regid FROM apn_users where active_rain_etc=1".$query_extension;
    }
    else if (boolval($tip)){
        $query = "select lang, gcm_regid FROM fcm_users where active_tips=1 UNION select lang, apn_regid gcm_regid FROM apn_users where active_tips=1".$query_extension;
    }
    else if (boolval($dailyforecast)){
        $query = "select lang, gcm_regid FROM fcm_users where dailyforecast=".date("H")." UNION select lang, apn_regid FROM apn_users where dailyforecast=".date("H").$query_extension;
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
    
    logger($query, 0, "Push", "SendSpecialService", "sendGCMMessage");
    //logger("sendingGCMMessage CloudMessageType=".$CloudMessageType.": En:".count($registrationIDs0)." Heb:".count($registrationIDs1)." Pic:".$picture_url);
     
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
        handleInvalidTokens($resultCall[1], $regIDs, $key);
      }
    
     $arrOfRegID1 = array_chunk($registrationIDs1, 1000);
     foreach ($arrOfRegID1 as $regIDs){
        
        $resultCall = callGCMSender ($key, $regIDs, $messageBody[1], $title[1], $picture_url, $embedded_url);
        handleInvalidTokens($resultCall[1], $regIDs, $key);
     }
    
     
     $result .= '<br/> --- '.count($registrationIDs1).' '.$res_fcm.' Completed';
     $result .= '<br/> --- '.count($registrationIDs0).' '.$res_fcm.' Completed';
     logger($result, 0, "Push", "SendSpecialService", "sendGCMMessage");
    return $result;        
}
function getForecastDay()
{
    global $NIGHT, $NOW, $NOON, $EN, $HEB, $current;
    $query = "select * FROM forecast_days order by idx";
    $result = db_init($query, "");
    $first_day = array();$idx = 0; 
    while ($line = mysqli_fetch_array($result["result"], MYSQLI_ASSOC)) {
        $idx++;
        //logger(date("H")." ".date("d/n")." ".$line["date"]);
        if (((date("H")<11)&&($idx == 1))||((date("H")>17)&&($line["date"])!=date("d/n")))
            {
                $lang_idx=0;
                $first_day0 = replaceDays($line["day_name"]." ").$line["date"]."\n".$line["lang0"]."\n".$NOW[$EN].": ".$current->get_temp()."°\n".$NOON[$EN].": ".$line["TempHigh"]."° - ".getClothTitle($line["TempHighCloth"], $line["TempHigh"],$line['WindDay'], $line['HumDay'])."\n".$NIGHT[$EN].": ".$line["TempNight"]."° - ".getClothTitle($line["TempNightCloth"], $line["TempNight"],$line['WindNight'], $line['HumNight']);
                $lang_idx=1;
                $first_day1 = replaceDays($line["day_name"]." ").$line["date"]."\n".$line["lang1"]."\n".$NOW[$HEB].": ".$current->get_temp()."°\n".$NOON[$HEB].": ".$line["TempHigh"]."° - ".getClothTitle($line["TempHighCloth"], $line["TempHigh"],$line['WindDay'], $line['HumDay'])."\n".$NIGHT[$HEB].": ".$line["TempNight"]."° - ".getClothTitle($line["TempNightCloth"], $line["TempNight"],$line['WindNight'], $line['HumNight']); 
                $first_day = array($first_day0, $first_day1);
                break;
            }
      }
      return $first_day;
}

$empty = $post = array();
foreach ($_POST as $varname => $varvalue) {
   if (empty($varvalue)) {
       $empty[$varname] = $varvalue;
   } else {
       $post[$varname] = $varvalue;
   }
}
foreach ($_FILES as $varname => $varvalue) {
   if (empty($varvalue)) {
       $empty[$varname] = $varvalue;
   } else {
       $file[$varname] = $varvalue;
   }
}
if (empty($empty)) {
   print "None of the POSTed values are empty, posted:\n";
   //var_dump($post);
} else {
   //$result .= "We have " . count($empty) . " empty values\n";
   //$result .= "Posted:\n"; var_dump($post);
   //$result .= "Filed:\n"; var_dump($file);
  // $result .= "Empty:\n";  var_dump($empty);
   
}
    
    $result = "";
    $msgSent = true;
    //$name = array($_POST['name0'], $_POST['name1']);
    $email = $_POST['email'];
    $message = array($_POST['message0'], $_POST['message1']);
    $msgSpecial = array($_POST['message0'], $_POST['message1']);
    $title = array($_POST['title0'], $_POST['title1']);
    $picture_url = $_POST['picture_url'];
    if (isset($_FILES['file'])) {
        
        $comment0 = $_POST["message0"]; 
		$comment1 = $_POST["message1"]; 
     	print_r("storingPic ".$_FILES['file']['name']);
        $res = storePic($_FILES['file']['name'], $comment0, $comment1, 0, 0, 0);
		$picture_url = $res;
        var_dump ($res);
    } 
    print_r ("picture_url=".$picture_url);
    $embedded_url = $_POST['embedded_url'];
    if (!empty($_POST['dailyforecast'])||!empty($_GET['dailyforecast'])){
        $msgSpecial = getForecastDay();
        $title = array("Daily Forecast", "תחזית יומית");
        
    }
    if ($msgSpecial == ""){
        $result = "Empty Message";
        echo $result;
        exit;
    }
    $class_alerttxt = "";
    if (empty($picture_url))
        $img_tag = "";
    else{
           if((strtolower(end(explode(".",$picture_url))) =="mp4")||(($_POST["video"]=="true")))
        {
            $img_tag = "<video width=\"280\" height=\"240\" controls><source src=\"".$picture_url."\" type=\"video/mp4\"></video>";
        }   
        else{
            $img_tag = "<div id=\"alertbg\" style=\"background-image: url(phpThumb.php?src=".$picture_url."&w=400)\"></div>";
            $img_tag = "<div id=\"alertbg\" style=\"background-image: url(".$picture_url.")\"></div>";
            $class_alerttxt = " class=\"txtindiv\"";
            $class_alerttitle = " txtindiv";
        }
       
    }
        
     try{   
        /* position: absolute; */
        /* margin-top: 70px; */
        $msgformat = "<div id=\"alerttxt\" ".$class_alerttxt.">%s</div>".$img_tag;
        $msgformatNoImg = "<div id=\"alerttxt\" ".$class_alerttxt.">%s</div>";
        if (!sprintf($msgformat, $message[0]))
            $msgToAlertSection = array(sprintf($msgformatNoImg, $message[0]), sprintf($msgformatNoImg, $message[1]));
        else
            $msgToAlertSection = array(sprintf($msgformat, $message[0]), sprintf($msgformat, $message[1]));
        if (strlen($title[0]) > 0){
            $msgformat = "<div class=\"title".$class_alerttitle."\">%s</div> %s";
            $msgToAlertSection[0] = sprintf ($msgformat, $title[0], $msgToAlertSection[0]);
            $msgToAlertSection[1] = sprintf ($msgformat, $title[1], $msgToAlertSection[1]);
            $msgToAlertSection[0] = $title[0]."\n".$message[0];
            $msgToAlertSection[1] = $title[1]."\n".$message[1];
        }
        $addon = array();
        $messageType = "long_range";
        if ($_POST["short_range"]=="true"){
            $addon[0] = $ALERTS_PAYMENT_FULL[0];
            $addon[1] = $ALERTS_PAYMENT_FULL[1];
            $messageType = "short_range";
        }
        else if ($_POST["tip"]=="true"){
            $messageType = "tip";
        }
        if ($_POST["alert_section"]=="1"){
            
            updateMessageFromMessages ($message[0], 1, 'LAlert', 0 ,'' ,$picture_url, $title[0], $addon[0], $class_alerttitle, $messageType, $_POST['ttl']);
            updateMessageFromMessages ($message[1], 1, 'LAlert', 1 ,'' ,$picture_url, $title[1], $addon[1], $class_alerttitle, $messageType, $_POST['ttl']);
    
          }
        } 
    catch (Exception $ex) {
        $result .= " exception updateMessageFromMessages:".$ex->getMessage();
    }
    
    try{
        logger("calling sendGCMMessage with ".$title[0], 0, "Push", "SendSpecialService", "sendGCMMessage");
        $result .= sendGCMMessage($msgSpecial, $title, $picture_url, $embedded_url, $_POST["short_range"], $_POST["long_range"], $_POST["tip"], $_POST["dailyforecast"], CloudMessageType::Fcm);
        //$result .= sendGCMMessage($msgSpecial, $title, $picture_url, $embedded_url, $_POST["short_range"], $_POST["long_range"], $_POST["tip"]);   
        
    } catch (Exception $ex) {
        $result .= " exception sendGCMMessage:".$ex->getMessage();
    }


    try{
      //  logger("calling sendAPNMessage with ".$title[0], 0, "Push", "SendSpecialService", "sendGCMMessage");
      //  $result .= sendAPNMessage($msgSpecial, $title, $picture_url, "alerts.php", $_POST["short_range"], $_POST["long_range"], $_POST["tip"], $_POST["dailyforecast"]);
    } 
    catch (Exception $ex) {
        $result .= " exception sendAPNMessage:".$ex->getMessage();
    }
    
    
    
    
    try {
        if  ($_POST["email"]=="1"){
        if (empty($_POST['title1']))
        $EmailSubject = array("02ws Update Service", "שירות עדכון ירושמיים");
        else {
        $EmailSubject = array($title[0], $title[1]);
        }
         $result .= send_Email(array($_POST['message0']." ".$img_tag, $_POST['message1']." ".$img_tag), ALL, EMAIL_ADDRESS, "", "", $EmailSubject);
        }
       } 
    catch (Exception $ex) {
       $result .= " exception send_Email:".$ex->getMessage();
    }
    
    try {
        
         $msgToBuffer = $msgSpecial[1]." ".$picture_url;
         if (strlen($title[1]) > 0) {$msgToBuffer = $title[1].": ".$msgToBuffer;}
         if ($_POST["social"]=="true")
	        $result .= post_to_bufferApp($msgToBuffer, $picture_url); 
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
