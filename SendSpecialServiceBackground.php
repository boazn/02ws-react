<?
ini_set("display_errors","On");
include ("include.php");
include_once("start.php");
ini_set('error_reporting', E_ERROR | E_PARSE);
error_reporting(-1);

class CloudMessageType {

    const Gcm = 1;
    const Fcm = 2;
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
        $messageBody[0] = "Tip".": ".$messageBody[0];
        $messageBody[1] = "טיפ".": ".$messageBody[1];
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
    
    logger($query, 0, "Push", "SendSpecialServiceBackground", "sendPUSHMessage");
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
    
     
     $result .= ' --- '.count($registrationIDs1).' '.$res_fcm.' Completed';
     $result .= ' --- '.count($registrationIDs0).' eng '.$res_fcm.' Completed';
     logger($result, 0, "Push", "SendSpecialServiceBackground", "sendPUSHMessage");
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
                logger(date("H")." ".date("d/n")." ".$line["date"],  0, "Push", "getForecastDay", "SendSpecialServiceBackground");
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
   //var_dump($post);
} else {
   //$result .= "We have " . count($empty) . " empty values\n";
   //$result .= "Posted:\n"; var_dump($post);
   //$result .= "Filed:\n"; var_dump($file);
  // $result .= "Empty:\n";  var_dump($empty);
   
}
   
 // take post-requests vars
$result = "";
$msgSent = true;
//$name = array($_POST['name0'], $_POST['name1']);
$email = $_POST['email'];
$is_test = ($_GET['test'] == 1)? true : false;
$message = array($_POST['message0'], $_POST['message1']);
$msgSpecial = array($_POST['message0'], $_POST['message1']);
$dailyforecast = $_POST["dailyforecast"];
$short_range = $_POST["short_range"];
$long_range = $_POST["long_range"];
$tip = $_POST["tip"];
$title = array($_POST['title0'], $_POST['title1']);
$picture_url = $_POST['picture_url'];
$embedded_url = $_POST['embedded_url'];

if (empty($_POST['title0']) && (!empty($argv[1])))
{
    // send_push "title0" "title1" "msg0" "msg1" short_range long_range tip dailyforecast picture_url
    $msgSpecial = array(urldecode($argv[3]), urldecode($argv[4]));
    $short_range = $argv[5];
    $long_range = $argv[6];
    $tip = $argv[7];
    $title = array(urldecode($argv[1]), urldecode($argv[2]));
    $dailyforecast = $argv[8];
    $picture_url = $argv[9];
    $embedded_url = $argv[9];
    
}

if ($is_test)
{
    echo "test";
    exit;
}


/******************************** send Push ****************/ 

try{
    logger("calling sendPUSHMessage with ".$title[0], 0, "Push", "SendSpecialService", "sendPUSHMessage");
    $result .= "\n<br/>".sendPUSHMessage($msgSpecial, $title, $picture_url, $embedded_url, $short_range, $long_range, $tip, $dailyforecast, CloudMessageType::Fcm);
    
} catch (Exception $ex) {
    $result .= " exception sendPUSHMessage:".$ex->getMessage();
}

print_r($result);
?>
