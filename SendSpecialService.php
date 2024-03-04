<?

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
include_once ("include.php");
include_once("start.php");


// send_push "title0" "title1" "msg0" "msg1" short_range long_range tip dailyforecast picture_url
function send_push($msgSpecial, $title, $picture_url, $embedded_url, $short_range,  $long_range, $tip, $dailyforecast) {
    // prepare the command
    $command = "php /home/boazn/public/02ws.com/public/SendSpecialServiceBackground.php '".urlencode($title[0])."' '".urlencode($title[1])."' '".urlencode($msgSpecial[0])."' '".urlencode($msgSpecial[1])."' {$short_range} {$long_range} {$tip} {$dailyforecast} {$picture_url} ";
    $result = urldecode($command);
    // execute in shell
    $output = shell_exec("/usr/bin/nohup {$command} >/dev/null 2>&1 &");
    $result .= $output;
    return $result;
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
             //           $result = db_init("INSERT INTO `UserPicture` (name, comment, approved, uploadedAt, User, x, y, picname, reg_id) VALUES('$name', '$comment', 0, SYSDATE(), '$user', '$x', '$y', '$picname', '$reg_id');", "");
			// check for successful store
			// get user details
			$id = $link->insert_id; // last inserted id
			logger("New pic user updated:".$id." ".$name." ".$x." ".$y, 0, "Push", "SendSpecialService", "storePic");
              //send_Email("New pic user updated:".$id." ".$name." ".$comment." ".$user." ".$picname." ".$x." ".$y." <a href=\"https://www.02ws.co.il/small.php?section=userPicsManager.php\">click here</a> ", ME, $email, $email, "", array('New pic user updated', 'תמונה חדשה נשלחה'));
			$result = "\n<br\>https://".$_SERVER["HTTP_HOST"]."/".$file_path;  
			return $result;
        } catch (Exception $ex) {
            logger("New storePic exception:.".$name." ", 4, "Push", "SendSpecialService", "storePic");
        }
   
    }
function sendPUSHMessage($messageBody, $title, $picture_url, $embedded_url, $short_range, $long_range, $tip, $dailyforecast, $CloudMessageType)
{
    global $TIP, $REPLY_ENGAGE, $ALERTS_PAYMENT;
    $key = "";
    error_reporting(-1);
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
    if (!boolval($dailyforecast)&&!boolval($tip)){
        $messageBody[0] = date('H:i')." ".mb_substr($messageBody[0], 0, 50, "UTF-8")."...";
        $messageBody[1] = date('H:i')." ".mb_substr($messageBody[1], 0, 50, "UTF-8")."...";
    }
   
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
    $result_db = db_init($query, "");
    while ($line = mysqli_fetch_array($result_db["result"], MYSQLI_ASSOC)) {
	$lines++;
        //echo "<br />".$line["gcm_regid"]."<br />";
        if ($line["lang"] == 0)
            array_push ($registrationIDs0, $line["gcm_regid"]);
        elseif ($line["lang"] == 1)
            array_push ($registrationIDs1, $line["gcm_regid"]);
    }
    
    logger($query, 0, "Push", "SendSpecialService", "sendPUSHMessage");
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
     $arrOfRegID1 = array_chunk($registrationIDs1, 1000);
     foreach ($arrOfRegID1 as $regIDs){
        
        $resultCall = callGCMSender ($key, $regIDs, $messageBody[1], $title[1], $picture_url, $embedded_url);
        handleInvalidTokens($resultCall[1], $regIDs, $key);
     }
     $arrOfRegID0 = array_chunk($registrationIDs0, 1000);
     foreach ($arrOfRegID0 as $regIDs){
        
        $resultCall = callGCMSender ($key, $regIDs, $messageBody[0], $title[0], $picture_url, $embedded_url);
        handleInvalidTokens($resultCall[1], $regIDs, $key);
      }
     
     $result .= ' --- '.count($registrationIDs1).' '.$res_fcm.' Completed';
     $result .= ' --- '.count($registrationIDs0).' eng '.$res_fcm.' Completed';
     logger($result, 0, "Push", "SendSpecialService", "sendPUSHMessage");
    return $result;        
}
function getForecastDay()
{
    global $NIGHT, $NOW, $NOON, $EN, $HEB, $current;
    $query = "select * FROM forecast_days order by idx";
    $result_db = db_init($query, "");
    $first_day = array();$idx = 0; 
    while ($line = mysqli_fetch_array($result_db["result"], MYSQLI_ASSOC)) {
        $idx++;
        //logger(date("H")." ".date("d/n")." ".$line["date"]);
        if (((date("H")<11)&&($idx == 1))||((date("H")>17)&&(explode("/", $line["date"])[0])==getMinusDayDay(-1)))
            {
                logger(date("H")." ".date("d/n")." ".$line["date"],  0, "Push", "getForecastDay", "SendSpecialService");
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

/************************** main ********************************** */


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
 //  var_dump($post);
} else {
 /*  $result .= "We have " . count($empty) . " empty values\n";
   $result .= "Posted:\n"; var_dump($post);
   $result .= "Filed:\n"; var_dump($file);
   $result .= "Empty:\n";  var_dump($empty);*/
   
}
   
 // take post-requests vars
$result = "";
$msgSent = true;
//$name = array($_POST['name0'], $_POST['name1']);
$email = $_POST['email'];
if (isset($_POST['message0'])){
    $message = array($_POST['message0'], $_POST['message1']);
    $msgSpecial = array($_POST['message0'], $_POST['message1']);
    $title = array($_POST['title0'], $_POST['title1']);
    $picture_url = $_POST['picture_url'];
    $embedded_url = $_POST['embedded_url'];
}
$is_test = ($_GET['test'] == 1)? true : false;

print_r($result);


if ($is_test)
{
    echo "test";
    exit;
}
/**********************upload pic ************/
if (isset($_FILES['file'])) {
    $comment0 = $_POST["message0"]; 
    $comment1 = $_POST["message1"]; 
    print_r("storingPic ".$_FILES['file']['name']);
    $res = storePic($_FILES['file']['name'], $comment0, $comment1, 0, 0, 0);
    $picture_url = $res;
    var_dump ($res);
} 
print_r ("\r\npicture_url=".$picture_url);

/************************** dailyforecast ***********/
if (!empty($_POST['dailyforecast'])||!empty($_GET['dailyforecast'])){
    $msgSpecial = getForecastDay();
    $title = array("Daily Forecast", "תחזית יומית");
    $isDailyForecast = true;
}
if ($msgSpecial == ""){
    $result = "Empty Message";
    echo $result;
    exit;
}

 /******************************** msg to alerts section ****************/      
try{   
    /* position: absolute; */
    /* margin-top: 70px; */
    $addon = array("", "");
    $messageType = ($_POST["short_range"]=="true") ? "short_range" : "long_range";
    if ($_POST["tip"]=="true")
        $messageType = "tip";
    
    if ($_POST["alert_section"]=="1"){
        updateAlerts ($message, 'LAlert', '' ,$picture_url, $title, $messageType, $_POST['ttl']);
        updateMessageFromMessages ($message[0], 1, 'LAlert', 0 ,'' ,$picture_url, $title[0], $addon[0], $class_alerttitle, $messageType, $_POST['ttl']);
        updateMessageFromMessages ($message[1], 1, 'LAlert', 1 ,'' ,$picture_url, $title[1], $addon[1], $class_alerttitle, $messageType, $_POST['ttl']);
        
        //$result .= "\n".$message[1];

    }
    
} 
catch (Exception $ex) {
    logger($ex->getMessage(), 4, "Push", "SendSpecialService", "updateMessageFromMessages");
    $result .= " exception updateMessageFromMessages:".$ex->getMessage();
}

/******************************** send Push ****************/ 

try{
    logger("calling sendPUSHMessage with ".$title[0], 0, "Push", "SendSpecialService", "sendPUSHMessage");
   // $result .= "\n<br/>".sendPUSHMessage($msgSpecial, $title, $picture_url, $embedded_url, $_POST["short_range"], $_POST["long_range"], $_POST["tip"], $_POST["dailyforecast"], CloudMessageType::Fcm);
    $result .= "\r\n".send_push($msgSpecial, $title, $picture_url, $embedded_url, $_POST["short_range"], $_POST["long_range"], $_POST["tip"], $_POST["dailyforecast"]);
    
} catch (Exception $ex) {
    $result .= " exception sendPUSHMessage:".$ex->getMessage();
}

/*********************************** send to Email list ***************************/
try {
    if (($_POST["email"]=="1")&&(!boolval($short_range))&&(!boolval($long_range))){
    if (empty($_POST['title1']))
    $EmailSubject = array("02ws Update Service", "שירות עדכון ירושמיים");
    else {
    $EmailSubject = array($title[0], $title[1]);
    }
    logger("calling send_Email with ".$EmailSubject[0], 0, "Push", "SendSpecialService", "send_Email");
        $result .= send_Email(array($_POST['message0']." ".$img_tag, $_POST['message1']." ".$img_tag), ALL, EMAIL_ADDRESS, "", "", $EmailSubject);
    }
    } 
catch (Exception $ex) {
    $result .= " exception send_Email:".$ex->getMessage();
}
/********************************** send to Buffer ************************ */   
try {
    
        $msgToBuffer = $msgSpecial[1]." ".$picture_url;
        if (strlen($title[1]) > 0) {$msgToBuffer = $title[1].": ".$msgToBuffer;}
        if ($_POST["social"]=="true"){
            $picture_url = (empty($picture_url)) ? "https://www.02ws.co.il/images/webCamera0.jpg" : $picture_url;
            $result .= "\r\n".post_to_bufferApp($msgToBuffer, $picture_url); 
        }
        
} 
catch (Exception $ex) {
    $result .= " exception post_to_bufferApp:".$ex->getMessage();
}
    
try{
//   $result = cleanInvalidAPNTokens();
} catch (Exception $ex) {
    $result .= " exception cleanInvalidAPNTokens:".$ex->getMessage();
}
print_r(nl2br($result));
?>
